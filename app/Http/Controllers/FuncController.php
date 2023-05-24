<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Laravel\Sanctum\PersonalAccessToken;

class FuncController extends Controller
{
    public static function get_profile()
    {
        if (isset($_COOKIE['token']) && !empty($_COOKIE['token'])) {
            $token = PersonalAccessToken::findToken($_COOKIE['token']);

            return $token->tokenable;
        } else {
            abort(Response::HTTP_NOT_FOUND);
        }
    }

    public static function cek_user()
    {
        if (isset($_COOKIE['token']) && !empty($_COOKIE['token'])) {
            abort(Response::HTTP_NOT_FOUND);
        }
    }

    public static function set_access_status($status)
    {
        if (isset($_COOKIE['token']) && !empty($_COOKIE['token'])) {
            $token = PersonalAccessToken::findToken($_COOKIE['token']);

            $user = $token->tokenable;

            if ($user->status != $status) {
                abort(Response::HTTP_NOT_FOUND);
            }
        } else {
            abort(Response::HTTP_NOT_FOUND);
        }
    }

    public static function set_access_level($level)
    {
        if (isset($_COOKIE['token']) && !empty($_COOKIE['token'])) {
            $token = PersonalAccessToken::findToken($_COOKIE['token']);

            $user = $token->tokenable;

            if ($user->level_id != $level) {
                abort(Response::HTTP_NOT_FOUND);
            }
        } else {
            abort(Response::HTTP_NOT_FOUND);
        }
    }
}
