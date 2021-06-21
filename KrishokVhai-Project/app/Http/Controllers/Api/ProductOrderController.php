<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrdersResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use App\Mail\PurchaseInvoiceInformation;
use App\Models\Address;
use App\Models\FarmerDetails;
use App\Models\OfficerDetails;
use App\Models\Order;
use App\Models\Product;
use App\Models\RetailerDetails;
use App\Models\Role;
use App\Models\User;
use App\Notifications\Invoice;
use App\Notifications\UserStatusNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use phpDocumentor\Reflection\Types\Boolean;

class ProductOrderController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $query = request()->input('query');
        $status = request()->input('status');
        $removedOrders = request()->input('removedOrders');
        $sellerId = request()->input('sellerId');
        $customerId = request()->input('customerId');
        $pinned = request()->input('pinned');

        $order_query = Order::query()
            ->orderBy('pinned', 'DESC')
            ->withFilters($query, $status, $removedOrders, $sellerId, $pinned);

        if ($customerId) {
            $order_query->where('user_id', $customerId);
        }

        if ($removedOrders == "true") {
            $order_query->onlyTrashed();
        }

        $orders = $order_query->latest()->paginate(30);

        //abort_unless((bool)Gate::authorize('view_category'), 403);
        return (OrdersResource::collection($orders))->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $products = $request->cartData;
        $Orders = new Order();
        $Orders->user_id = \auth()->id();
        $Orders->address_id = $request->address_id;
        $Orders->total_price = $request->total_price;
        $Orders->payment_method = $request->payment_method;
        $Orders->save();

        foreach ($products as $product) {
            $productData = Product::where('id', $product['id'])->first();
            if (!empty($productData)) {
                $checkStock = (int)$productData->total_stock - (int)$product['quantity'];
                if ($checkStock >= 0) {
                    $productData->total_stock = $checkStock;
                    $productData->save();
                } else {
                    return response()->json(['error' => 'A product is out of stock.'], 400);
                }
            } else {
                return response()->json(['error' => 'Cannot find product.'], 400);
            }
            $Orders->products()->attach($product['id'], ['quantity' => $product['quantity'], 'buying_price' => $product['regular_price']]);
        }
        return response()->json($Orders, 200);
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): \Illuminate\Http\JsonResponse
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $order_id, $product_id): \Illuminate\Http\JsonResponse
    {
        $order = Order::findOrFail($order_id);
        if ($request->status) {
            $order->products()->updateExistingPivot($product_id, ['individual_order_status' => $request->status]);
            $counter = 0;
            foreach ($order->products as $product) {
                if ($product->pivot->individual_order_status == 'confirmed') {
                    ++$counter;
                }
            }
            if ($counter == count($order->products)) {
                $order->order_status = 'confirmed';
                $user = User::findOrFail($order->user_id);
                Mail::to($user->email)->send(new PurchaseInvoiceInformation($order));
            } else {
                $order->order_status = 'processing';
            }
            $order->save();
        }
        return (new OrdersResource($order))->response();
    }


    public function search(Request $request): \Illuminate\Http\JsonResponse
    {

    }


    public function restore($id): \Illuminate\Http\JsonResponse
    {
        $orders = Order::withTrashed()->findOrFail($id);
        if (!$orders->restore()) {
            return response()->json(['error' => "Failed to delete order!"], 500);
        }
        $products = $orders->products;
        foreach ($products as $product) {
            $productData = Product::where('id', $product['id'])->first();
            if (!empty($productData)) {
                $checkStock = (int)$productData->total_stock - (int)$product->pivot->quantity;
                if ($checkStock >= 0) {
                    $productData->total_stock = $checkStock;
                    $productData->save();
                } else {
                    $this->remove($orders->id);
                    return response()->json(['error' => 'A product is out of stock.'], 400);
                }
            } else {
                return response()->json(['error' => 'Cannot find product.'], 400);
            }
        }
        return (new OrdersResource($orders))->response();
    }

    public function remove($id): \Illuminate\Http\JsonResponse
    {
        $orders = Order::findOrFail($id);
        if (!$orders->delete()) {
            return response()->json(['error' => "Failed to delete order!"], 500);
        }

        $products = $orders->products;
        //dd($products);
        foreach ($products as $product) {
            $productData = Product::where('id', $product->id)->first();
            if (!empty($productData)) {
                $checkStock = (int)$productData->total_stock + (int)$product->pivot->quantity;
                $productData->total_stock = $checkStock;
                $productData->save();
            } else {
                return response()->json(['error' => 'Cannot find product.'], 500);
            }
        }
        return (new OrdersResource($orders))->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): \Illuminate\Http\JsonResponse
    {
        $order = Order::findOrFail($id);
        $products = $order->products;
        foreach ($products as $product) {
            $productData = Product::where('id', $product->id)->first();
            $order->products()->detach($product->id);
        }

        if (!$order->forceDelete()) {
            return response()->json(['error' => "Failed to delete order!"], 500);
        }
        return (new OrdersResource($order))->response();
    }

    public function updateSeen(Request $request, $order_id): \Illuminate\Http\JsonResponse
    {
        $loggedInUserId = \auth()->id();
        $order = Order::findOrFail($order_id);
        $products = $order->products(function ($q) use ($loggedInUserId) {
            $q->where('seller_id', $loggedInUserId);
        })->get();
        foreach ($products as $product) {
            if ($product->seller_id == $loggedInUserId) {
                $order->products()->updateExistingPivot($product->id, ['seen' => 1]);
            }
        }
        return (new OrdersResource($order))->response();
    }

    public function showNewOrders(): \Illuminate\Http\JsonResponse
    {
        $sellerId = request()->input('sellerId');
        $seen = request()->input('seen');
        $user = \auth()->user();

        $order_query = Order::query()->with('products')
            ->orderBy('pinned', 'DESC')
            ->withNewOrderFilters($sellerId, $seen);

        $orders = $order_query->latest()->paginate(10);

        //abort_unless((bool)Gate::authorize('view_category'), 403);
        return (OrdersResource::collection($orders))->response();
    }


}
