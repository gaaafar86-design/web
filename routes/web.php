<?php
use App\Http\Controllers\Admin\InquiryController as AdminInquiryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PlanController as AdminPlanController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\LocationController as AdminLocationController;
use App\Http\Controllers\Admin\PropertyTypeController as AdminPropertyTypeController;
use App\Http\Controllers\Admin\AmenityController as AdminAmenityController;
use App\Http\Controllers\Admin\DashboardController as AdminDahsboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\AgentController as AdminAgentController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PropertyController as AdminPropertyController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Admin\HeaderController as AdminHeaderController;
use App\Http\Controllers\Admin\WhyChooseUsController as AdminWhyChooseUsController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Admin\SubscriberController as AdminSubscriberController;
use App\Http\Controllers\Admin\TermController as AdminTermController;
use App\Http\Controllers\Admin\PrivacyPolicyController as AdminPrivacyPolicyController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\FooterController as AdminFooterController;
use App\Http\Controllers\Front\User\AuthController as UserAuthController;
use App\Http\Controllers\Front\User\DashboardController as UserDahsboardController;
use App\Http\Controllers\Front\User\MessageController as UserMessageController;
use App\Http\Controllers\Front\Agent\AuthController as AgentAuthController;
use App\Http\Controllers\Front\Agent\DashboardController as AgentDahsboardController;
use App\Http\Controllers\Front\Agent\PaymentController as AgentPaymentController;
use App\Http\Controllers\Front\Agent\PropertyController as AgentPropertyController;
use App\Http\Controllers\Front\Agent\MessageController as AgentMessageController;

// User
Route::controller(UserAuthController::class)->prefix('user')->group(function () {
    Route::get('register', 'register')->name('user.register');
    Route::get('register/{token}', 'registerVerify')->name('user.register.verify');
    Route::post('register', 'registerSubmit')->name('user.register.submit');
    Route::get('login', 'login')->name('user.login');
    Route::post('login', 'loginSubmit')->name('user.login.submit');
    Route::post('logout', 'logout')->middleware('user.auth')->name('user.logout');
    Route::get('forget/password', 'forgetPassword')->name('user.forget.password');
    Route::post('forget/password', 'forgetPasswordSubmit')->name('user.forget.password.submit');
    Route::get('reset/password/{token}', 'resetPassword')->name('user.reset.password');
    Route::post('reset/password', 'resetPasswordSubmit')->name('user.reset.password.submit');
});

Route::controller(UserDahsboardController::class)->prefix('user')->middleware('user.auth')->group(function () {
    Route::get('edit/profile', 'editProfile')->name('user.edit.profile');
    Route::post('edit/profile/{user}', 'editProfileSubmit')->name('user.edit.profile.submit');
    Route::get('wishlist', 'wishlist')->name('user.wishlist');
    Route::get('add-to-wishlist/{property}', 'addToWishlist')->name('user.add.to.wishlist');
    Route::delete('remove-from-wishlist/{wishlist}', 'removeFromWishlist')->name('user.remove.from.wishlist');
});

Route::controller(UserMessageController::class)
    ->prefix('user/messages')
    ->middleware('user.auth')
    ->name('user.messages.')
    ->group(function () {
    Route::get('', 'index')->name('index');
    Route::get('create', 'create')->name('create');
    Route::post('create', 'store')->name('store');
    Route::get('reply/{message}', 'reply')->name('reply');
    Route::post('reply/{message}', 'submitReply')->name('reply.submit');
    Route::delete('{message}', 'destroy')->name('destroy');
});

// Agent
Route::controller(AgentAuthController::class)->prefix('agent')->group(function () {
    Route::get('register', 'register')->name('agent.register');
    Route::get('register/{token}', 'registerVerify')->name('agent.register.verify');
    Route::post('register', 'registerSubmit')->name('agent.register.submit');
    Route::get('login', 'login')->name('agent.login');
    Route::post('login', 'loginSubmit')->name('agent.login.submit');
    Route::post('logout', 'logout')->middleware('agent.auth')->name('agent.logout');
    Route::get('forget/password', 'forgetPassword')->name('agent.forget.password');
    Route::post('forget/password', 'forgetPasswordSubmit')->name('agent.forget.password.submit');
    Route::get('reset/password/{token}', 'resetPassword')->name('agent.reset.password');
    Route::post('reset/password', 'resetPasswordSubmit')->name('agent.reset.password.submit');
});

Route::controller(AgentDahsboardController::class)->prefix('agent')->middleware('agent.auth')->group(function () {
    Route::get('edit/profile', 'editProfile')->name('agent.edit.profile');
    Route::post('edit/profile/{agent}', 'editProfileSubmit')->name('agent.edit.profile.submit');
    Route::get('orders', 'orders')->name('agent.orders');
    Route::get('invoice/{order}', 'invoice')->name('agent.invoice');
    Route::get('plan', 'plan')->name('agent.plan');
});

Route::controller(AgentPaymentController::class)->prefix('agent')->middleware('agent.auth')->group(function () {
    Route::post('payment/send/{plan}', 'send')->name('agent.payment.send');
    Route::get('payment/verify', 'verify')->name('agent.payment.verify');
});

Route::controller(AgentPropertyController::class)->middleware('agent.auth')->prefix('agent')->group(function () {
    Route::get('photo-gallery/{property}', 'photoGallery')->name('agent.photo.gallery');
    Route::post('photo-gallery/{property}', 'photoGallerySubmit')->name('agent.photo.gallery.submit');
    Route::delete('photo-gallery/{propertyPhoto}', 'photoGalleryDestroy')->name('agent.photo.gallery.destroy');
    Route::get('video-gallery/{property}', 'videoGallery')->name('agent.video.gallery');
    Route::post('video-gallery/{property}', 'videoGallerySubmit')->name('agent.video.gallery.submit');
    Route::delete('video-gallery/{propertyVideo}', 'videoGalleryDestroy')->name('agent.video.gallery.destroy');
});
Route::resource('agent/properties', AgentPropertyController::class)->middleware('agent.auth')->names('agent.properties');

Route::controller(AgentMessageController::class)
    ->prefix('agent/messages')
    ->middleware('agent.auth')
    ->name('agent.messages.')
    ->group(function () {
    Route::get('', 'index')->name('index');
    Route::get('reply/{message}', 'reply')->name('reply');
    Route::post('reply/{message}', 'submitReply')->name('reply.submit');
});

// Admin
Route::get('admin', [AdminController::class, 'index'])->middleware('admin.auth')->name('admin.panel');

Route::controller(AdminAuthController::class)->prefix('admin')->group(function () {
    Route::get('login', 'login')->name('admin.login');
    Route::post('login', 'loginSubmit')->name('admin.login.submit');
    Route::post('logout', 'logout')->middleware('admin.auth')->name('admin.logout');
    Route::get('forget/password', 'forgetPassword')->name('admin.forget.password');
    Route::post('forget/password', 'forgetPasswordSubmit')->name('admin.forget.password.submit');
    Route::get('reset/password/{token}', 'resetPassword')->name('admin.reset.password');
    Route::post('reset/password', 'resetPasswordSubmit')->name('admin.reset.password.submit');
});

Route::controller(AdminDahsboardController::class)->prefix('admin')->middleware('admin.auth')->group(function () {
    Route::get('edit/profile', 'editProfile')->name('admin.edit.profile');
    Route::post('edit/profile/{admin}', 'editProfileSubmit')->name('admin.edit.profile.submit');
});

Route::resource('admin/plans', AdminPlanController::class)
    ->middleware('admin.auth')->except('show')->names('admin.plans');
Route::resource('admin/locations', AdminLocationController::class)
    ->middleware('admin.auth')->except('show')->names('admin.locations');
Route::resource('admin/property-types', AdminPropertyTypeController::class)
    ->middleware('admin.auth')->except('show')->names('admin.property.types');
Route::resource('admin/amenities', AdminAmenityController::class)
    ->middleware('admin.auth')->except('show')->names('admin.amenities');
Route::resource('admin/users', AdminUserController::class)
    ->middleware('admin.auth')->except('show')->names('admin.users');
Route::resource('admin/agents', AdminAgentController::class)
    ->middleware('admin.auth')->names('admin.agents');
Route::resource('admin/why-choose-us', AdminWhyChooseUsController::class)
    ->middleware('admin.auth')->except('show')
    ->names('admin.why-choose-us')->parameters(['why-choose-us' => 'item']);
Route::resource('admin/testimonial', AdminTestimonialController::class)
    ->middleware('admin.auth')->except('show')->names('admin.testimonial');
Route::resource('admin/blog', AdminBlogController::class)
    ->middleware('admin.auth')->names('admin.blog');
Route::resource('admin/faq', AdminFaqController::class)
    ->middleware('admin.auth')->names('admin.faq');

Route::controller(AdminPropertyController::class)
    ->prefix('admin/properties')
    ->name('admin.properties.')
    ->middleware('admin.auth')
    ->group(function () {
        Route::post('make-active/{property}', 'makeActive')->name('make.active');
        Route::delete('photo/{propertyPhoto}', 'destroyPhoto')->name('photo.destroy');
        Route::delete('video/{propertyVideo}', 'destroyVideo')->name('video.destroy');
    });
Route::resource('admin/properties', AdminPropertyController::class)
    ->middleware('admin.auth')
    ->names('admin.properties');

Route::controller(AdminNotificationController::class)
    ->prefix('admin/notifications')
    ->name('admin.notifications.')
    ->middleware('admin.auth')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('{id}/read', 'markAsRead')->name('read');
        Route::post('read-all', 'markAllAsRead')->name('read.all');
        Route::delete('delete-all', 'deleteAll')
            ->name('delete.all');
    });

Route::get('admin/subscribers/export', [AdminSubscriberController::class, 'export'])->name('admin.subscribers.export');
Route::resource('admin/subscribers', AdminSubscriberController::class)
    ->middleware('admin.auth')
    ->except(['show', 'edit', 'update'])
    ->names('admin.subscribers');

Route::controller(AdminOrderController::class)->prefix('admin')->middleware('admin.auth')->group(function () {
    Route::get('orders', 'index')->name('admin.orders');
    Route::get('invoice/{order}', 'invoice')->name('admin.invoice');
});

Route::singleton('admin/header', AdminHeaderController::class)->middleware('admin.auth')->names('admin.header');
Route::singleton('admin/terms', AdminTermController::class)->middleware('admin.auth')->names('admin.terms');
Route::singleton('admin/privacy-policy', AdminPrivacyPolicyController::class)->middleware('admin.auth')->names('admin.privacy-policy');
Route::singleton('admin/settings', AdminSettingController::class)->middleware('admin.auth')->except('edit')->names('admin.settings');
Route::singleton('admin/footer', AdminFooterController::class)->middleware('admin.auth')->names('admin.footer');




// Front
Route::controller(FrontController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('select/user', 'selectUser')->name('select.user');
    Route::get('user/dashboard', 'userDashboard')->middleware('user.auth')->name('user.dashboard');
    Route::get('agent/dashboard', 'agentDashboard')->middleware('agent.auth')->name('agent.dashboard');
    Route::get('pricing', 'pricing')->name('pricing');
    Route::get('property/{property:slug}', 'property')->name('property.detail');
    Route::get('properties', 'properties')->name('properties');
    Route::post('property/inquiry/{property}', 'inquirySubmit')->name('property.inquiry.submit');
    Route::get('location/{location:slug}', 'location')->name('location.detail');
    Route::get('locations', 'locations')->name('locations');
    Route::get('agents', 'agents')->name('agents');
    Route::get('agent/{agent}', 'agent')->name('agent.detail');
    Route::get('blog', 'blog')->name('blog');
    Route::get('post/{blog:slug}', 'post')->name('post');
    Route::get('faq', 'faq')->name('faq');
    Route::get('subscribe/{token}', 'subscribeVerify')->name('subscribe.verify');
    Route::post('subscribe', 'subscribe')->name('subscribe');
    Route::get('contact', 'contact')->name('contact');
    Route::post('contact', 'contactSubmit')->name('contact.submit');
    Route::get('terms', 'terms')->name('terms');
    Route::get('privacy-policy', 'privacy')->name('privacy.policy');

});