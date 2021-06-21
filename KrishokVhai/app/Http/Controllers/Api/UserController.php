<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserWithProductsResource;
use App\Mail\Notification;
use App\Models\Address;
use App\Models\FarmerDetails;
use App\Models\OfficerDetails;
use App\Models\Product;
use App\Models\RetailerDetails;
use App\Models\Role;
use App\Models\User;
use App\Notifications\UserStatusNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //abort_unless((bool)Gate::authorize('view_category'), 403);
    }

    public function getAllUsers()
    {
        $userId = Auth::id();
        //$users = User::with('roles', 'address', 'farmer', 'retailer', 'officer')
        $users = User::with('roles')
            ->where('id', '!=', $userId)
            ->orderBy('id', 'DESC')
            ->paginate(20);

        return (UserResource::collection($users))->response();
    }

    public function getAllDeletedUsers(): \Illuminate\Http\JsonResponse
    {
        $userId = Auth::id();
        //$users = User::with('roles', 'address', 'farmer', 'retailer', 'officer')
        $users = User::with('roles')
            ->where('id', '!=', $userId)
            ->orderBy('id', 'DESC')
            ->onlyTrashed()
            ->paginate(20);

        return (UserResource::collection($users))->response();
    }

    public function getRoles(): \Illuminate\Http\JsonResponse
    {
        $roles = Role::with('permissions')
            ->where('name', '!=', 'developer')
            ->orderBy('id', 'DESC')->get();
        return (RoleResource::collection($roles))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    public function validateUserDetailsRequest($request, $user)
    {
        $this->validate($request, [
            'userType' => ['required', 'string'],
            'address' => ['required', 'string'],
            'country_id' => ['required', 'numeric'],
            'state_id' => ['required', 'numeric'],
            'city_id' => 'nullable|numeric',

            'acres' => $user->hasRole('farmer') ? 'required|numeric' : '',
            'farmerType' => $user->hasRole('farmer') ? 'required|string' : '',

            'retailer_interest' => $user->hasRole('retailer') ? 'required|string' : '',

            'office_name' => $user->hasRole('agricultural-officer') ? 'required|string|min:5|max:60' : '',
            'job_title' => $user->hasRole('agricultural-officer') ? 'required|string|min:2|max:30' : '',
            'certificate' => $user->hasRole('agricultural-officer') ? 'required|file|mimes:pdf|max:4148' : '',
        ], [
            'country_id.required' => 'Country field is required!',
            'state_id.required' => 'State/Province field is required!',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeUserDetails(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();
        if (!$user) {
            abort(419, 'User authentication failed!');
        }
        //$this->validateUserDetailsRequest($request, $user);

        $roles = $user->getRoleNames()->toArray();
        $userType = explode('_', $request->userType);
        $difference = array_diff($userType, $roles);

        if ($difference) {
            abort(419, 'Invalid user type.');
        } else {
            $userDetails = [];
            if ($user->hasRole('farmer')) {
                if (count(FarmerDetails::where('user_id', $user->id)->get()) > 0) {
                    abort(419, 'User details already added.');
                }
                $userDetails = new FarmerDetails();
                $userDetails->user_id = $user->id;
                $userDetails->acres = $request->acres;
                $userDetails->farmer_type = $request->farmerType;
                $userDetails->save();
            }
            if ($user->hasRole('retailer')) {
                if (count(RetailerDetails::where('user_id', $user->id)->get()) > 0) {
                    abort(419, 'User details already added.');
                }
                $userDetails = new RetailerDetails();
                $userDetails->user_id = $user->id;
                $userDetails->retailer_interest = $request->retailer_interest;
                $userDetails->save();
            }
            if ($user->hasRole('agricultural-officer')) {
                if (count(OfficerDetails::where('user_id', $user->id)->get()) > 0) {
                    abort(419, 'User details already added.');
                }
                $userDetails = new OfficerDetails();
                $userDetails->user_id = $user->id;
                $userDetails->office_name = $request->office_name;
                $userDetails->job_title = $request->job_title;


                if ($request->hasFile('certificate')) {
                    $get_image = $request->file('certificate'); // get the image form post method...
                    $fileNameWithExt = $get_image->getClientOriginalName(); // get full file name ...
                    $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME); // get only the file name without extension ....
                    $extension = $get_image->getClientOriginalExtension();// get the file extension

                    $newFileName = $user->first_name . '_' . $user->last_name . '_' . time() . '.' . $extension;
                    $fileLocation = '/public/users/document/';
                    $get_image->storeAs($fileLocation, $newFileName); // set the storage path ...
                    $StorageLink2 = '/storage/users/document/' . $newFileName;
                    $userDetails->certificate = $StorageLink2;
                } else {
                    return response()->json(['Error' => 'Work place document must be given.'], 400);
                }
                $userDetails->save();
            }

            $address = new Address();
            $address->user_id = $user->id;
            $address->address = $request->address;
            $address->country_id = $request->country_id;
            $address->state_id = $request->state_id;
            $address->city_id = $request->city_id;
            $address->save();

            $userDetailsResponse = [
                'userDetails' => $userDetails,
                'address' => $address,
            ];
            return response()->json(['userDetails' => $userDetailsResponse], 200);
        }
    }

    public function getUserDetails(): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();
        if (!$user) {
            abort(419, 'User authentication failed!');
        }
        $userDetailsResponse = [];
        $address = Address::where('user_id', $user->id)->first();

        if ($user->hasRole('farmer')) {
            $farmer = FarmerDetails::where('user_id', $user->id)->first();
            if ($farmer) {
                $userDetailsResponse = [
                    'userDetails' => $farmer,
                    'address' => $address,
                ];
            }
        }
        if ($user->hasRole('retailer')) {
            $retailer = RetailerDetails::where('user_id', $user->id)->first();
            if ($retailer) {
                $userDetailsResponse = [
                    'userDetails' => $retailer,
                    'address' => $address,
                ];
            }
        }
        if ($user->hasRole('agricultural-officer')) {
            $officer = OfficerDetails::where('user_id', $user->id)->first();
            if ($officer) {
                $userDetailsResponse = [
                    'userDetails' => $officer,
                    'address' => $address,
                ];
            }
        }
        //return (new UserResource($userDetailsResponse))->response();
        return response()->json($userDetailsResponse, 200);
    }


    public function getUserDetailsForUpdate(): \Illuminate\Http\JsonResponse
    {
        $userDetails = User::findOrFail(\auth()->id());
        return (new UserResource($userDetails))->response();
    }

    public function UpdateProfileData(Request $request): \Illuminate\Http\JsonResponse
    {
        $userDetails = User::findOrFail(\auth()->id());

        return (new UserResource($userDetails))->response();
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): \Illuminate\Http\JsonResponse
    {
        $user = User::where('id', $id)
            ->where('id', '!=', auth()->id())
            ->first();
        return (new UserResource($user))->response();
    }

    public function showUserProducts(int $id): \Illuminate\Http\JsonResponse
    {
        $limit = 6;
        //$user = User::where('id', $id)->where('id', '!=', auth()->id())->first();
        $user = User::where('id', $id)->first();
        $products = Product::where('seller_id', $user->id)->where('status', 1)->paginate($limit);
        return (ProductResource::collection($products))->response();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }


    public function updateUserData(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $user = User::findOrFail(\auth()->id());
        if ($request->dob) {
            $dates = date('Y-m-d', strtotime($request->dob));
            $request->merge(['dob' => Carbon::parse($request->dob)->format('Y-m-d')]);
        }
        $this->validate($request, [
            'postal_code' => ['required', 'string'],
            'dob' => 'nullable|date_format:Y-m-d|before:-18 years',
            'mobile_number' => ['required', 'numeric'],
            'about' => ['required', 'string'],

            /*'acres' => $user->hasRole('farmer') ? 'required|numeric' : '',
            'farmerType' => $user->hasRole('farmer') ? 'required|string' : '',

            'retailer_interest' => $user->hasRole('retailer') ? 'required|string' : '',
            'office_name' => $user->hasRole('agricultural-officer') ? 'required|string|min:5|max:60' : '',
            'job_title' => $user->hasRole('agricultural-officer') ? 'required|string|min:2|max:30' : '',*/
        ], [
            'dob.before' => 'You age should be at-least 18 years old.',
        ]);

        $user->postal_code = $request->postal_code;
        $user->about = $request->about;
        $user->dob = $request->dob;
        $user->mobile_number = $request->mobile_number;
        $user->save();
        return (new UserResource($user))->response();
    }


    public function updateStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user->status == 'active') {
            $user->status = 'blocked';
        } else {
            $user->status = 'active';
        }
        $user->save();
        $user->notify(new UserStatusNotification($user));
        //Mail::to($user->email)->send(new Notification());
        return (new UserResource($user))->response();
    }


    public function uploadAvatar(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();
        if ($request->hasFile('avatar')) {
            $uploadedImageName = $this->uploadFile($request->file('avatar'), 'users/');
            $user->avatar = '/storage/images/users/' . $uploadedImageName;
            if ($user->save()) {
                return response()->json($user, 200);
            }
        }
        return response()->json(['error' => 'Could not upload profile picture.'], 500);
    }


    public function searchPeople(): \Illuminate\Http\JsonResponse
    {
        $query = request()->input('searchQuery');
        $searchRole = request()->input('searchRole');
        $searchStatus = request()->input('searchStatus') ?: 'active';

        $Users = User::query()
            ->where('id', '!=', \auth()->id())
            ->where('status', '=', 'active')
            ->where('email_verified_at', '!=', null)
            ->orderBy('id', 'DESC')
            ->withFilters($query, $searchRole, $searchStatus);

        return (UserResource::collection($Users->latest()->paginate(30)))->response();
    }

    public function search(Request $request): \Illuminate\Http\JsonResponse
    {
        $query = $request->get('query');
        $role = $request->get('role_name');
        $status = $request->get('status');
        $trashed = $request->get('trashed');
        $UserId = Auth::id();

        $Users = User::query()->with('roles')->where('id', '!=', $UserId)
            ->orderBy('id', 'DESC');
        $query ? $Users->SearchUsers($query) : false;
        $role ? $Users->role($role) : false;

        if ($status) {
            $operator = '=';
            if ($status === 'active') { // If user is active then STATUS = 1 and VERIFIED_AT != null
                $status = 'active';
                $operator = '!=';
            } elseif ($status === 'blocked') { // If user is blocked then STATUS = 0 and VERIFIED_AT != null
                $status = 'blocked';
                $operator = '!=';
            } elseif ($status === 'not_verified') { // If user is not_Verified then STATUS = 0 and VERIFIED_AT = null
                $status = 'active';
                $operator = '=';
            } elseif ($status === 'pending') { // If user is not_Verified then STATUS = 0 and VERIFIED_AT = null
                $status = 'pending';
                $operator = '!=';
            }
            $Users->where('status', '=', $status)
                ->where('email_verified_at', $operator, null);
        }

        $trashed == "true" ? $Users->onlyTrashed() : false;

        return (UserResource::collection($Users->latest()->paginate(20)))->response();
    }


    public function restoreUser($id): \Illuminate\Http\JsonResponse
    {
        $user = User::withTrashed()->findOrFail($id);
        if (!$user->restore()) {
            return response()->json(['error' => "Failed to restore user!"], 500);
        }
        return (new UserResource($user))->response();
    }

    public function delete($id): \Illuminate\Http\JsonResponse
    {
        $user = User::findOrFail($id);
        if (!$user->delete()) {
            return response()->json(['error' => "Failed to delete user!"], 500);
        }
        return (new UserResource($user))->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): \Illuminate\Http\JsonResponse
    {
        $user = User::onlyTrashed()->where('id', $id)->first();
        if (!$user->forceDelete()) {
            return response()->json(['error' => "Failed to delete user!"], 500);
        }
        return (new UserResource($user))->response();
    }

    public function getAuthor($id): \Illuminate\Http\JsonResponse
    {
        $user = User::findOrFail($id);
        return (new UserResource($user))->response();

    }

    public function getAddress(): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();
        return (new UserResource($user))->response();
    }


    public function addAddress(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->validate($request, [
            'address' => ['required', 'string'],
            'country_id' => ['required', 'numeric'],
            'state_id' => ['required', 'numeric'],
            'city_id' => 'nullable|numeric',
        ], [
            'country_id.required' => 'Country field is required!',
            'state_id.required' => 'State/Province field is required!',
        ]);

        $user = auth()->user();
        $address = new Address();
        $address->user_id = $user->id;
        $address->address = $request->address;
        $address->country_id = $request->country_id;
        $address->state_id = $request->state_id;
        $address->city_id = $request->city_id;
        $address->save();
        return (new UserResource($user))->response();
    }


    public function removeAddress($id): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();
        $address = Address::findOrFail($id);
        if (!$address->forceDelete()) {
            return response()->json(['error' => "Failed to delete address!"], 500);
        }
        return (new UserResource($user))->response();
    }


}
