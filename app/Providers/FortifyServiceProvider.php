<?php

namespace App\Providers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\RateLimiter;
use App\Actions\Fortify\UpdateUserProfileInformation;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        Event::listen('Illuminate\Auth\Events\Login', function ($event) {
            Log::info('Utente loggato con successo', [
                'username' => $event->user->{Fortify::username()},
                'ip' => request()->ip(),
                'azione' => 'login'
            ]);
        });

        Event::listen('Illuminate\Auth\Events\Registered', function ($event) {
            Log::info('Nuova registrazione utente', [
                'username' => $event->user->{Fortify::username()},
                'ip' => request()->ip(),
                'azione' => 'registrazione'
            ]);
        });

        Event::listen('Illuminate\Auth\Events\Logout', function ($event) {
            Log::info('Utente disconnesso', [
                'username' => Auth::user()->{Fortify::username()},
                'ip' => request()->ip(),
                'azione' => 'logout'
            ]);
        });

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::loginView(function () {
            return view('auth.login');
        });

        Fortify::registerView(function () {
            return view('auth.register');
        });
    }
}
