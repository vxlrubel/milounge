<?php

use App\Services\SocketIoNotificationService;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/session', function () {
    dd(session()->all());
});
Route::get('/session/clear', function () {
    session()->flush();
    return redirect('/');
});

Route::get('/send-socket-io-notification', function () {
    // Send Notification to SocketIo

    $provider = \App\Services\Utils::getProvider();
    $provider_uuid = $provider->uuid ?? null;

    return SocketIoNotificationService::send([
        "order_id" => '111',
        "event_name" => 'notification',
        "providerId" => \App\Services\BranchService::current().'-'.$provider_uuid,
    ]);

});


Route::get('/cache', function () {
    dd(
        cache('branches'),
        cache('globalSettings'),
        cache('categories'),
        cache('products'),
        cache('branch_categories'),
        cache('branch_products'),
    );
});

Route::get('/cache/forget', function () {
    \Illuminate\Support\Facades\Cache::forget('branches');
    \Illuminate\Support\Facades\Cache::forget('categories');
    \Illuminate\Support\Facades\Cache::forget('products');
    \Illuminate\Support\Facades\Cache::forget('globalSettings');
    \Illuminate\Support\Facades\Cache::forget('branch_categories');
    \Illuminate\Support\Facades\Cache::forget('branch_products');
    return redirect('/');
});

Route::group(['prefix' => 'branch'], function () {
    Route::get('/set/{branch_value}', function ($branch_value) {
        session()->put([
            'branch' => $branch_value
        ]);
        return redirect('/menu');
    });
});

Route::group(['prefix' => 'auth', 'middleware' => 'guest'], function () {
    Route::get('/login', [\App\Http\Controllers\Auth\AuthController::class, 'loginIndex']);
    Route::post('/login', [\App\Http\Controllers\Auth\AuthController::class, 'login'])->name('auth.login');

    Route::view('/register', 'auth.register');
    Route::post('/register', [\App\Http\Controllers\Auth\AuthController::class, 'register'])->name('auth.register');

    Route::view('/forget-password', 'auth.forgetpassword');
    Route::get('/reset-password', function (\Illuminate\Http\Request $request) {
        $email = $request->email;

        return view('auth.resetpassword', compact('email'));
    });

    //Social Auth
    Route::get('/redirect/{provider}', [\App\Http\Controllers\Auth\SocialiteController::class, 'redirect']);
    Route::get('/callback/{provider}', [\App\Http\Controllers\Auth\SocialiteController::class, 'callback']);
});

Route::get('/home', [\App\Http\Controllers\WelcomeController::class, 'home']);
Route::get('/{branch?}/home', [\App\Http\Controllers\WelcomeController::class, 'indexBranch']);

Route::get('/menu', [\App\Http\Controllers\MenuController::class, 'index']);
Route::get('/{branch?}/menu', [\App\Http\Controllers\MenuController::class, 'indexBranch']);

Route::get('/product/{uuid}', [\App\Http\Controllers\ProductController::class, 'show']);

Route::view('/about-us', 'about_us');
Route::view('/contact-us', 'contact_us');
Route::view('/cart', 'cart');
Route::view('/table-booking', 'table_booking');

Route::view('/terms-and-conditions', 'terms-and-conditions');
Route::view('/privacy-policy', 'privacy-policy');
Route::view('/return-policy', 'return-policy');
Route::view('/cookie-policy', 'cookie-policy');
Route::view('/faq', 'faq');
Route::view('/refund-policy', 'refund-policy');
Route::view('/offer', 'offer');
Route::view('/gallery', 'gallery');

Route::group(['prefix' => 'checkout'], function () {
    Route::get('/', [\App\Http\Controllers\CheckoutController::class, 'index']);
    Route::post('/', [\App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout');
});

Route::view('/order-confirm', 'order-confirm');


// Calculate Postcode distance
Route::get('/postcode/distance', [\App\Http\Controllers\PostcodeDistanceController::class, 'calculate']);

Route::group(['middleware' => 'auth'], function () {

    // Logout
    Route::post('/auth/logout', [\App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('auth.logout');

    Route::group(['prefix' => 'profile'], function () {
        Route::view('/details', 'profile.accountdetails');
        Route::post('/details', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile-details-update');
        Route::post('/upload-profile-picture', [\App\Http\Controllers\ProfileController::class, 'updateProfilePicture'])->name('profile-upload-picture');

        Route::view('/order', 'profile.myorders');
    });

    Route::view('/security', 'profile.security');

});

Route::group(['prefix' => 'payment'], function () {
    Route::get('/', [\App\Http\Controllers\PaymentController::class, 'index']);
    Route::get('/hosted', [\App\Http\Controllers\PaymentController::class, 'indexHosted']);

    Route::post('/cardstream-hosted', [\App\Http\Controllers\CardStreamController::class, 'hosted'])->name('payment.cardstream.hosted');
    Route::any('/cardstream-direct', [\App\Http\Controllers\CardStreamController::class, 'direct'])->name('payment.cardstream.direct');
    Route::any('/cardstream-hosted-gateway', [\App\Http\Controllers\CardStreamController::class, 'hostedGateway'])->name('payment.cardstream.hosted.gateway');
});

// if branch is given in the url
Route::get('/{branch?}', [\App\Http\Controllers\WelcomeController::class, 'index']);
