<?php

namespace BeautifulSea\LaravelRamodnil;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class LaravelRamodnilServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands([
            \BeautifulSea\LaravelRamodnil\Commands\Install::class,
        ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public static function routes() {
        Route::group(['prefix' => '/users'], function () {
            Route::post('/first-user', 'UsersController@storeFirstUser')->name('users.first-user');
            Route::get('/profile', 'UsersController@profile')->name('users.profile');
            Route::post('/profile', 'UsersController@updateProfile')->name('users.save-profile');
            Route::post('/check-email', 'UsersController@checkEmail')->name('users.check-email');
            Route::post('/check-profile-email', 'UsersController@checkProfileEmail')->name('users.check-profile-email');
            Route::post('/check-profile-password', 'UsersController@checkProfilePassword')->name('users.check-profile-password');
            Route::get('/block/{user}', 'UsersController@block')->name('users.block');
            Route::get('/unblock/{user}', 'UsersController@unblock')->name('users.unblock');
        });
        Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
        Route::resource('/users', 'UsersController');

        Route::get('/markAsRead', function(){
            auth()->user()->unreadNotifications->markAsRead();
        });
    }
}
