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
}
