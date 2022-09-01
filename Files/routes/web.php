<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('clear', function () {
    \Artisan::call('view:clear');
    \Artisan::call('config:clear');
    \Artisan::call('route:clear');
    \Artisan::call('cache:clear');
});



Route::get('/cron-match', 'WebsiteController@cronMatchEnd');


Route::get('/', 'WebsiteController@index')->name('site');
Route::get('/tournament/{name?}/{id}', 'WebsiteController@tournament')->name('tournament');
Route::get('/about', 'WebsiteController@about')->name('about');
Route::get('/terms', 'WebsiteController@terms')->name('terms');
Route::get('/policy', 'WebsiteController@policy')->name('policy');
Route::get('/blog', 'WebsiteController@blog')->name('blog');
Route::get('/blog/detail/{slug?}/{id}', 'WebsiteController@blogDetails')->name('info');
Route::get('/faq', 'WebsiteController@faq')->name('faq');

Route::get('/contact', 'WebsiteController@contact')->name('contact');
Route::post('/contact', 'WebsiteController@contactSubmit')->name('contact.submit');


Auth::routes();

Route::group(['prefix' => 'user'], function () {

    Route::get('authorization', 'HomeController@authCheck')->name('user.authorization');

    Route::post('verification', 'HomeController@sendVcode')->name('user.send-vcode');
    Route::post('smsVerify', 'HomeController@smsVerify')->name('user.sms-verify');

    Route::post('verify-email', 'HomeController@sendEmailCode')->name('user.send-emailVcode');
    Route::post('postEmailVerify', 'HomeController@postEmailVerify')->name('user.email-verify');

    Route::middleware(['CheckStatus'])->group(function () {
        Route::get('/home', 'HomeController@index')->name('home');
        Route::post('/prediction', 'HomeController@prediction')->name('prediction');

        Route::get('/password-setting', 'HomeController@changePassword')->name('password-setting');
        Route::post('/password-setting', 'HomeController@submitPassword')->name('password-update');

        Route::get('/profile-setting', 'HomeController@profileSetting')->name('profile-setting');
        Route::post('/profile-setting', 'HomeController@profileUpdate')->name('profile-update');

        Route::get('/deposit-log', 'HomeController@depositLog')->name('depositLog');
        Route::get('/transaction-log', 'HomeController@activity')->name('transaction');
        Route::get('/withdraw-log', 'HomeController@withdrawLog')->name('user.withdraw-log');

        // Deposit
        Route::get('payment', 'Gateway\PaymentController@payment')->name('payment');
        Route::post('payment', 'Gateway\PaymentController@payment')->name('payment');
        Route::post('make-request', 'Gateway\PaymentController@paymentRequest')->name('make-request');
        Route::get('pay-now', 'Gateway\PaymentController@payNow')->name('deposit-confirm');


        Route::get('deposit/manual', 'Gateway\PaymentController@manualDepositConfirm')->name('deposit.manual.confirm');
        Route::post('deposit/manual', 'Gateway\PaymentController@manualDepositUpdate')->name('deposit.manual.update');



        Route::get('/withdraw-money', 'HomeController@withdrawMoney')->name('user.withdraw-money');
        Route::post('/withdraw-money', 'HomeController@withdrawMoneyRequest')->name('user.withdraw-money');
        Route::get('/withdraw-preview', 'HomeController@withdrawReqPreview')->name('user.withdraw.preview');
        Route::post('/withdraw-preview', 'HomeController@withdrawReqSubmit')->name('user.withdraw.submit');


        Route::get('/money-transfer', 'HomeController@moneyTransfer')->name('money-transfer');
        Route::post('/money-transfer', 'HomeController@moneyTransferConfirm')->name('money.transfer');

    });

});

Route::group(['prefix' => $_ENV['admin'], 'namespace' => 'Admin', 'middleware' => ['auth:admin', 'CheckAdminStatus']], function () {

    

        Route::get('/dashboard', 'AdminController@dashboard')->name('admin.dashboard')->middleware('adminAuthorize:1');

        Route::get('/change-prefix', 'AdminController@ChangePrefix')->name('admin.changePrefix')->middleware('adminAuthorize:8');
        Route::post('/change-prefix', 'AdminController@updatePrefix')->name('admin.updatePrefix');


        Route::get('/profile', 'AdminController@profile')->name('admin.profile');
        Route::post('/profile', 'AdminController@updateProfile')->name('admin.profile');
        Route::get('/password', 'AdminController@changePassword')->name('admin.password');
        Route::post('/password', 'AdminController@updatePassword')->name('admin.password-update');


        Route::get('/staff', 'ManageAdminRoleController@staff')->name('staff')->middleware('adminAuthorize:7');
        Route::post('/staff', 'ManageAdminRoleController@storeStaff')->name('storeStaff');
        Route::put('/staff/{id}', 'ManageAdminRoleController@updateStaff')->name('updateStaff');


        Route::group(['middleware' => ['adminAuthorize:2']], function () {
            Route::get('/tournament', 'ProphecyManageController@tournament')->name('admin.events');
            Route::post('/tournament', 'ProphecyManageController@updateTournament')->name('update.events');

            Route::get('/events/running', 'ProphecyManageController@matches')->name('admin.matches');
            Route::get('/events/closed', 'ProphecyManageController@closeMatches')->name('close.matches');
            Route::get('/events/create', 'ProphecyManageController@addMatch')->name('add.match');
            Route::post('/events/create', 'ProphecyManageController@saveMatch')->name('add.match');
            Route::get('/events/edit/{id}', 'ProphecyManageController@editMatch')->name('edit.match');
        });

        Route::post('/events/update', 'ProphecyManageController@updateMatch')->name('update.match');

        Route::group(['middleware' => ['adminAuthorize:2']], function () {
            Route::get('/events/question/{id}', 'ProphecyManageController@viewQuestion')->name('view.question');
            Route::post('/events/add-question', 'ProphecyManageController@saveQuestion')->name('save.question');
            Route::post('/events/question-update', 'ProphecyManageController@updateQuestion')->name('update.question');
            Route::get('/events/options/{id}', 'ProphecyManageController@viewOption')->name('view.option');
            Route::post('/events/options', 'ProphecyManageController@createNewOption')->name('createNewOption');
            Route::post('/events/option-update', 'ProphecyManageController@updateOption')->name('update.option');
        });


        Route::group(['middleware' => ['adminAuthorize:3']], function () {

            Route::get('/result', 'ProphecyManageController@endDateByQuestion')->name('awaiting.winner');
            Route::post('result', 'ProphecyManageController@refundBetInvest')->name('refundBetInvest');

            Route::get('/result/predictor-list/{id}', 'ProphecyManageController@awaitingWinnerUserlist')->name('awaiting.winner.userlist');
            Route::post('/result/refundSingleUser', 'ProphecyManageController@refundBetInvestSingleUser')->name('refundBetInvestSingleUser');

            Route::get('/result/for-winner-select/{id}', 'ProphecyManageController@viewOptionEndTime')->name('view.option.endtime');
            Route::post('/result/make-winner', 'ProphecyManageController@makeWinner')->name('make.winner');
            Route::get('/result/predictor-list/option/{id}', 'ProphecyManageController@betOptionUserlist')->name('bet-option-userlist');
        });

        Route::group(['middleware' => ['adminAuthorize:5']], function () {
            Route::get('/payment-log', 'PaymentLogController@index')->name('deposit.log');
            Route::get('/payment-log/pending', 'PaymentLogController@pending')->name('deposit.pending');
            Route::get('/payment-log/rejected', 'PaymentLogController@rejected')->name('deposit.rejected');
            Route::get('/payment-log/approved', 'PaymentLogController@approved')->name('deposit.approved');
            Route::post('/payment-log/reject', 'PaymentLogController@reject')->name('deposit.reject');
            Route::post('/payment-log/approve', 'PaymentLogController@approve')->name('deposit.approve');



            Route::get('/payment-method', 'PaymentGatewayController@paymentMethod')->name('payment-method');
            Route::get('/payment-method/{id}', 'PaymentGatewayController@paymentMethodEdit')->name('payment-method.edit');
            Route::put('/payment-method/{id}', 'PaymentGatewayController@paymentMethodUpdate')->name('payment-method.update');



            // Manual Methods
            Route::get('payment/manual', 'ManualGatewayController@index')->name('admin.deposit.manual.index');
            Route::get('payment/manual/new', 'ManualGatewayController@create')->name('admin.deposit.manual.create');
            Route::post('payment/manual/new', 'ManualGatewayController@store')->name('admin.deposit.manual.store');
            Route::get('payment/manual/edit/{alias}', 'ManualGatewayController@edit')->name('admin.deposit.manual.edit');
            Route::post('payment/manual/update/{id}', 'ManualGatewayController@update')->name('admin.deposit.manual.update');
            Route::post('payment/manual/activate', 'ManualGatewayController@activate')->name('admin.deposit.manual.activate');
            Route::post('payment/manual/deactivate', 'ManualGatewayController@deactivate')->name('admin.deposit.manual.deactivate');

        });

        Route::group(['middleware' => ['adminAuthorize:6']], function () {
            Route::get('/withdraw-log', 'WithdrawLogController@index')->name('withdraw-log');
            Route::get('/withdraw-request', 'WithdrawLogController@request')->name('withdraw-request');
            Route::put('/withdraw-log/{id}', 'WithdrawLogController@action')->name('withdraw-action');

            Route::get('/withdraw-method', 'WithdrawGatewayController@index')->name('withdraw-method');
            Route::get('/withdraw-method/create', 'WithdrawGatewayController@create')->name('withdraw-method.create');
            Route::post('/withdraw-method/create', 'WithdrawGatewayController@store')->name('withdraw-method.store');
            Route::get('/withdraw-method/{id}', 'WithdrawGatewayController@edit')->name('withdraw-method.edit');
            Route::put('/withdraw-method/{id}', 'WithdrawGatewayController@update')->name('withdraw-method.update');
        });


        /*
         * User Manage Controller
         */

        Route::group(['middleware' => ['adminAuthorize:4']], function () {
            Route::get('users', 'UserManageController@users')->name('users');
            Route::get('user-search', 'UserManageController@userSearch')->name('search.users');

            Route::get('user/{user}', 'UserManageController@singleUser')->name('user.single');
            Route::put('user/updateStatus/{user}', 'UserManageController@statupdate')->name('user.status');

            Route::get('user/password/{user}', 'UserManageController@passwordSetting')->name('user.password');
            Route::put('user/updatePassword/{user}', 'UserManageController@updatePassword')->name('user.pass-update');

            Route::get('/user/balance/{id}', 'UserManageController@manageBalanceByUsers')->name('user.balance');
            Route::post('user/balance/{id}', 'UserManageController@saveBalanceByUsers')->name('user.balance.update');

            Route::get('/user/mail/{user}', 'UserManageController@userEmail')->name('user.email');
            Route::post('user/sendMail', 'UserManageController@sendEmail')->name('send.email');
            Route::get('/user/sms/{user}', 'UserManageController@userSendSms')->name('user.sms');
            Route::post('user/sendSMS', 'UserManageController@sendSmsToUser')->name('send.sms');

            Route::get('/user/predictions/{id}', 'UserManageController@predictions')->name('user.predictions');
            Route::get('/user/paymentLog/{id}', 'UserManageController@paymentLog')->name('user.paymentLog');
            Route::get('/user/withdrawLog/{id}', 'UserManageController@withdrawLog')->name('user.withdrawLog');
            Route::get('/user/transferSEND/{id}', 'UserManageController@transferSEND')->name('user.transferSEND');
            Route::get('/user/transferRECEIVE/{id}', 'UserManageController@transferRECEIVE')->name('user.transferRECEIVE');
            Route::get('/user/trx/{id}', 'UserManageController@transactionLog')->name('user.transactionLog');
            Route::get('/user/loginLogs/{id}', 'UserManageController@loginLogs')->name('user.loginLogs');
        });

        /*
         * UI Settings
         */

        Route::group(['middleware' => ['adminAuthorize:9']], function () {
            Route::get('/site-settings', 'UIController@siteControl')->name('siteControl');
            Route::post('/site-settings', 'UIController@testimonialHeadingUpdate')->name('siteControl');
            Route::get('/charge-control', 'UIController@chargeControl')->name('charge-control');
            Route::post('/charge-control', 'UIController@chargeControlUpdate')->name('charge-control');
        });

        Route::get('/about', 'UIController@aboutUs')->name('admin.about')->middleware('adminAuthorize:12');
        Route::get('/terms', 'UIController@terms')->name('admin.terms')->middleware('adminAuthorize:14');
        Route::get('/policy', 'UIController@policy')->name('admin.policy')->middleware('adminAuthorize:15');


        //Mail SMS Setting
        Route::group(['middleware' => ['adminAuthorize:13']], function () {
            Route::get('/mail-setting', 'SmsMailManageController@index')->name('mail-setting');
            Route::post('/mail-setting', 'SmsMailManageController@update')->name('mail-setting');
            Route::get('/sms-setting', 'SmsMailManageController@smsApi')->name('sms-setting');
            Route::post('/sms-setting', 'SmsMailManageController@smsUpdate')->name('sms-setting');
        });

        Route::group(['middleware' => ['adminAuthorize:17']], function () {
            Route::get('/slider', 'UIController@manageSlider')->name('slider');
            Route::get('/slider/create', 'UIController@sliderCreate')->name('slider.create');
            Route::post('/slider/create', 'UIController@storeSlider')->name('slider.store');
            Route::post('/slider/delete', 'UIController@deleteSlider')->name('slider.delete');
        });


        Route::group(['middleware' => ['adminAuthorize:11']], function () {
            Route::get('/testimonial', 'UIController@testimonial')->name('testimonial');
            Route::get('/testimonial/create', 'UIController@testimonialCreate')->name('testimonial.create');
            Route::post('/testimonial/create', 'UIController@storeTestimonial')->name('testimonial.store');
            Route::post('/testimonial/delete', 'UIController@deleteTestimonial')->name('testimonial.delete');
            Route::get('/testimonial/{id}/edit', 'UIController@testimonialEdit')->name('testimonial.edit');
            Route::post('/testimonial/update', 'UIController@updateTestimonial')->name('testimonial.update');

            Route::get('/testimonial/heading', 'UIController@testimonialHeading')->name('testimonial.heading');
        });
        Route::post('/testimonial/heading', 'UIController@testimonialHeadingUpdate')->name('testimonial.heading');


        Route::group(['middleware' => ['adminAuthorize:10']], function () {
            Route::get('/blog', 'UIController@manageBlog')->name('admin.blog');
            Route::post('/blog', 'UIController@testimonialHeadingUpdate')->name('admin.blog');
            Route::get('/blog/create', 'UIController@blogCreate')->name('admin.blog.create');
            Route::post('/blog/create', 'UIController@storeBlog')->name('admin.blog.store');
            Route::post('/blog/delete', 'UIController@deleteBlog')->name('admin.blog.delete');
            Route::get('/blog/edit/{id}', 'UIController@blogEdit')->name('admin.blog.edit');
            Route::post('/blog/update', 'UIController@updateBlog')->name('admin.blog.update');
        });

        Route::group(['middleware' => ['adminAuthorize:13']], function () {
            Route::get('/faqs', 'UIController@manageFaq')->name('admin.faqs');
            Route::get('/faqs/create', 'UIController@faqCreate')->name('admin.faqs.create');
            Route::post('/faqs/create', 'UIController@storeFaq')->name('admin.faqs.store');
            Route::post('/faqs/delete', 'UIController@deleteFaq')->name('admin.faqs.delete');
            Route::get('/faqs/edit/{id}', 'UIController@FaqEdit')->name('admin.faqs.edit');
            Route::post('/faqs/update', 'UIController@updateFaq')->name('admin.faqs.update');
        });
        
        Route::get('/howItWork', 'UIController@manageHowItWork')->name('admin.howItWork');
        Route::get('/howItWork/create', 'UIController@howItWorkCreate')->name('admin.howItWork.create');
        Route::post('/howItWork/create', 'UIController@storeHowItWork')->name('admin.howItWork.store');
        Route::post('/howItWork/delete', 'UIController@deleteHowItWork')->name('admin.howItWork.delete');
        Route::get('/howItWork/edit/{id}', 'UIController@howItWorkEdit')->name('admin.howItWork.edit');
        Route::post('/howItWork/update', 'UIController@updateHowItWork')->name('admin.howItWork.update');






    Route::get('/logout', 'AdminController@logout')->name('admin.logout');
});


Route::group(['prefix' => $_ENV['admin']], function () {
    Route::get('/', 'Admin\LoginController@index')->name('admin.loginForm');
    Route::post('/', 'Admin\LoginController@login')->name('admin.login');
});


/*============== User Password Reset Route list ===========================*/
Route::get('user-password/reset', 'User\ForgotPasswordController@showLinkRequestForm')->name('user.password.request');

Route::post('user-password/email', 'User\ForgotPasswordController@sendResetLinkEmail')->name('user.password.email');
Route::get('user-password/reset/{token}', 'User\ResetPasswordController@showResetForm')->name('user.password.reset');
Route::post('user-password/reset', 'User\ResetPasswordController@reset');
