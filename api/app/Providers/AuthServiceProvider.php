<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use carbon\carbon;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    private function checkIP($ip, $request_ip) {
        if ($ip === $request_ip) return true;
        if (substr($request_ip, 0, 8) === '192.168.') return true;
        return false;
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        //$this->app['auth']->viaRequest('api', function ($request) {
        //   if ($request->input('api_token')) {
        //        return User::where('api_token', $request->input('api_token'))->first();
        //    }
        //});
        $this->app['auth']->viaRequest('api', function (Request $request) {
            $token = $request->input('token', $request->header('Api-Token'));
            $apiToken = \App\Models\ApiToken::where('token', $token)->first();
            if (!$apiToken) {
                return null;
            }
            $currentIp = $request->server('HTTP_X_FORWARDED_FOR', $request->server('REMOTE_ADDR', null));
            if ($this->checkIP($currentIp, $apiToken->ip) === false) {
                return null;
            }
            if ($apiToken->deleted_at) {
                return null;
            }
            if ($apiToken->expired_at && $apiToken->expired_at->timestamp < Carbon::now()->timestamp) {
                return null;
            }
            if ($apiToken->expired_at) {
                $thirtyMinutesAfter = Carbon::now()->addMinutes(30);
                if ($apiToken->expired_at->timestamp < $thirtyMinutesAfter->timestamp) {
                    $apiToken->expired_at = $thirtyMinutesAfter;
                    $apiToken->save();
                }
            }
            return $apiToken->user;
        });
    }
}
