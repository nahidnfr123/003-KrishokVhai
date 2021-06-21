<?php

use App\Http\Controllers\Api\ChatAppController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\CountryCityStateController;
use App\Http\Controllers\Api\PostCategoryController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ProductCategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductOrderController;
use App\Http\Controllers\Api\TodosController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\SocialAuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


use Laravel\Fortify\Features;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\ConfirmablePasswordController;
use Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController;
use Laravel\Fortify\Http\Controllers\EmailVerificationNotificationController;
use Laravel\Fortify\Http\Controllers\EmailVerificationPromptController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\PasswordController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\ProfileInformationController;
use Laravel\Fortify\Http\Controllers\RecoveryCodeController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\TwoFactorQrCodeController;
use Laravel\Fortify\Http\Controllers\VerifyEmailController;


// Social Login ...
Route::prefix('social-login')->group(function () {
    Route::get('/{provider}', [SocialAuthController::class, 'redirectToProvider'])
        ->middleware(['guest']);

    Route::get('/callback/{provider}', [SocialAuthController::class, 'handleProviderCallback'])
        ->middleware(['guest']);
});

// Get User ... data ...
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    $user = $request->user();
    $roles = [];
    $permissions = [];
    if (auth()) {
        $roles = auth()->user()->getRoleNames();
        $permissions = auth()->user()->getPermissionsViaRoles();
    }
    return ['user' => $user, 'roles' => $roles, 'permissions' => $permissions];
    //return $request->user();
});


Route::get('/countries', [CountryCityStateController::class, 'searchCountries']);
Route::get('/states/{countryId}', [CountryCityStateController::class, 'searchStates']);
Route::get('/cities/{stateId}', [CountryCityStateController::class, 'searchCities']);


// Email Verification ...
Route::prefix('email')->middleware(['auth:sanctum',])->group(function () {
    // After verification redirects to /api/email/verify
    /*Route::get('/verify', [EmailVerificationPromptController::class, '__invoke'])
        ->name('verification.notice');*/

    /*Route::get('/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');*/

    Route::post('/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware(['throttle:6,1'])
        ->name('verification.send');
});

if (Features::enabled(Features::resetPasswords())) {
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware(['guest'])
        ->name('password.email');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->middleware(['guest'])
        ->name('password.update');
}


// Not protected routes ...
// Post and post category resource ... //
Route::get('/post/category/view', [PostCategoryController::class, 'index']); // Category ...
Route::get('/post/frontend', [PostController::class, 'getPostFrontend']); // Posts ...
Route::get('/post/search', [PostController::class, 'search']); // Post Search ...
Route::get('/post/{post_slug}', [PostController::class, 'show']); // Show Posts ...
Route::get('/getAuthor/{id}', [UserController::class, 'getAuthor']); // Get authors ...


// Replying to message ...
Route::post('/contact/reply', [ContactController::class, 'reply']);
Route::resource('/contact', ContactController::class);

Route::middleware(['auth:sanctum', 'verified', 'role:developer|super admin|admin|agricultural-officer'])->group(function () {
    Route::resource('/post/category', PostCategoryController::class); // Categories ...
    //--------------------------------------------
    Route::post('/post/image', [PostController::class, 'uploadImage']); // Post image upload ...
    Route::delete('/post/image/{key}/{postId}/delete', [PostController::class, 'deleteImage']); // Delete post image ...
    Route::resource('post', PostController::class); // Post resource ...
});
/// End posts ///

/*Route::post('token', [\App\Http\Controllers\Api\PaymentController::class, 'token'])->name('token');*/

// Products ... //
Route::get('/product/category', [ProductCategoryController::class, 'index']);
Route::get('/products/all', [ProductController::class, 'showAllProducts']);
Route::get('/products/show/{slug}', [ProductController::class, 'show']); // Show Posts ...

Route::middleware(['auth:sanctum', 'verified', 'role:developer|super admin|admin|farmer|retailer|customer'])->group(function () {
    Route::get('/product/order', [ProductOrderController::class, 'index']);
    Route::delete('/product/order/remove/{id}', [ProductOrderController::class, 'remove']);
    Route::get('/product/order/restore/{id}', [ProductOrderController::class, 'restore']);
    Route::get('/orders/show-new-orders', [ProductOrderController::class, 'showNewOrders']);
    Route::put('/product/order/{order_id}/{product_id}', [ProductOrderController::class, 'update']);
    Route::put('/product/order/update/seen/{order_id}', [ProductOrderController::class, 'updateSeen']);
    Route::apiResource('/product/order', ProductOrderController::class);

});


Route::middleware(['auth:sanctum', 'verified', 'role:developer|super admin|admin|farmer'])->group(function () {
    Route::post('/product/category', [ProductCategoryController::class, 'store'])->middleware(['verified']);
    Route::put('/product/category/{id}', [ProductCategoryController::class, 'update'])->middleware(['verified']);
    Route::delete('/product/category/{id}', [ProductCategoryController::class, 'destroy'])->middleware(['verified']);

    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);
    //Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    Route::get('/products/{id}/restore', [ProductController::class, 'restore']);
    Route::get('/products/deleted', [ProductController::class, 'showDeleted']);
    Route::put('/products/restore/{id}', [ProductController::class, 'restore']);
    Route::delete('/product/image/{key}/{productId}/delete', [ProductController::class, 'deleteImage']); // Delete post image ...
    Route::get('/products/deleted/count', [ProductController::class, 'deletedCount']); // Delete post image ...
    Route::apiResource('products', ProductController::class);
});


// Main app URLs ...
Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/roles', [UserController::class, 'getRoles']);

    Route::put('/user/{id}/status/update', [UserController::class, 'updateStatus']);
    Route::get('/search/users', [UserController::class, 'search']);
    Route::get('/search/people', [UserController::class, 'searchPeople']);
    Route::post('/user-details/upload', [UserController::class, 'storeUserDetails']);
    Route::get('/user-details', [UserController::class, 'getUserDetails']);
    Route::get('/user/details', [UserController::class, 'getUserDetailsForUpdate']);
    Route::delete('/user/delete/{id}', [UserController::class, 'delete']);
    Route::delete('/user/destroy/{id}', [UserController::class, 'destroy']);
    Route::get('/all-users', [UserController::class, 'getAllUsers']);
    Route::get('/all-users/deleted', [UserController::class, 'getAllDeletedUsers']);
    Route::put('/all-users/restore/{id}', [UserController::class, 'restoreUser']);
    Route::get('/user/show/{id}', [UserController::class, 'show']);
    Route::get('/user/show/{id}/products', [UserController::class, 'showUserProducts']);
    Route::post('/user/avatar/upload', [UserController::class, 'uploadAvatar']);

    Route::get('/user/address', [UserController::class, 'getAddress']);
    Route::post('/user/add-address', [UserController::class, 'addAddress']);
    Route::delete('/user/address/remove/{id}', [UserController::class, 'removeAddress']);

    Route::put('/user/{id}/update', [UserController::class, 'updateUserData']);


    Route::get('/contacts', [ChatAppController::class, 'contacts']); // Get authors ...
    Route::get('/chat/messages/{id}', [ChatAppController::class, 'getMessages']); // Get authors ...
    Route::post('/chat/message/send', [ChatAppController::class, 'sendMessage']); // Get authors ...


    Route::prefix('todos')->group(function () {
        Route::post('/addTask', [TodosController::class, 'addTask']);
        Route::put('/updateTask/{taskId}', [TodosController::class, 'updateTask']);
        Route::delete('/deleteTask/{taskId}', [TodosController::class, 'deleteTask']);
        Route::put('/move/{todoId}', [TodosController::class, 'moveTodo']);
        Route::apiResource('/', TodosController::class);
    });


//    Route::group(['middleware' => config('fortify.middleware', ['web'])], function () {
//        $enableViews = config('fortify.views', true);

    // Authentication...
    /*if ($enableViews) {
        Route::get('/login', [AuthenticatedSessionController::class, 'create'])
            ->middleware(['guest'])
            ->name('login');
    }*/


    // Password Reset...
//        if (Features::enabled(Features::resetPasswords())) {
//            if ($enableViews) {
//                Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
//                    ->middleware(['guest'])
//                    ->name('password.request');
//
//                Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
//                    ->middleware(['guest'])
//                    ->name('password.reset');
//            }
//
//            Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
//                ->middleware(['guest'])
//                ->name('password.email');
//
//            Route::post('/reset-password', [NewPasswordController::class, 'store'])
//                ->middleware(['guest'])
//                ->name('password.update');
//        }
//
//        // Registration...
//        if (Features::enabled(Features::registration())) {
//            if ($enableViews) {
//                Route::get('/register', [RegisteredUserController::class, 'create'])
//                    ->middleware(['guest'])
//                    ->name('register');
//            }
//
//            Route::post('/register', [RegisteredUserController::class, 'store'])
//                ->middleware(['guest']);
//        }
//
//        // Email Verification...
//        if (Features::enabled(Features::emailVerification())) {
//            if ($enableViews) {
//                Route::get('/email/verify', [EmailVerificationPromptController::class, '__invoke'])
//                    ->middleware(['auth'])
//                    ->name('verification.notice');
//            }
//
//            Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
//                ->middleware(['auth', 'signed', 'throttle:6,1'])
//                ->name('verification.verify');
//
//            Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
//                ->middleware(['auth', 'throttle:6,1'])
//                ->name('verification.send');
//        }
//
//        // Profile Information...
//        if (Features::enabled(Features::updateProfileInformation())) {
//            Route::put('/user/profile-information', [ProfileInformationController::class, 'update'])
//                ->middleware(['auth'])
//                ->name('user-profile-information.update');
//        }
//
//        // Passwords...
//        if (Features::enabled(Features::updatePasswords())) {
//            Route::put('/user/password', [PasswordController::class, 'update'])
//                ->middleware(['auth'])
//                ->name('user-password.update');
//        }
//
//        // Password Confirmation...
//        if ($enableViews) {
//            Route::get('/user/confirm-password', [ConfirmablePasswordController::class, 'show'])
//                ->middleware(['auth'])
//                ->name('password.confirm');
//
//            Route::get('/user/confirmed-password-status', [ConfirmedPasswordStatusController::class, 'show'])
//                ->middleware(['auth'])
//                ->name('password.confirmation');
//        }
//
//        Route::post('/user/confirm-password', [ConfirmablePasswordController::class, 'store'])
//            ->middleware(['auth']);
//
//        // Two Factor Authentication...
//        if (Features::enabled(Features::twoFactorAuthentication())) {
//            if ($enableViews) {
//                Route::get('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'create'])
//                    ->middleware(['guest'])
//                    ->name('two-factor.login');
//            }
//
//            Route::post('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'store'])
//                ->middleware(['guest']);
//
//            $twoFactorMiddleware = Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword')
//                ? ['auth', 'password.confirm']
//                : ['auth'];
//
//            Route::post('/user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'store'])
//                ->middleware($twoFactorMiddleware);
//
//            Route::delete('/user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'destroy'])
//                ->middleware($twoFactorMiddleware);
//
//            Route::get('/user/two-factor-qr-code', [TwoFactorQrCodeController::class, 'show'])
//                ->middleware($twoFactorMiddleware);
//
//            Route::get('/user/two-factor-recovery-codes', [RecoveryCodeController::class, 'index'])
//                ->middleware($twoFactorMiddleware);
//
//            Route::post('/user/two-factor-recovery-codes', [RecoveryCodeController::class, 'store'])
//                ->middleware($twoFactorMiddleware);
//        }
    //});
});

