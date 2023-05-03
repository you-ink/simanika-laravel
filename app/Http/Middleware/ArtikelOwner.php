<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ArtikelOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentUser = Auth::user();
        $artikel = Artikel::findOrFail($request->id);

        if ($artikel->user_id != $currentUser->id) {
            return response()->json([
                'error' => true,
                'message' => 'Hanya dapat diakses oleh pembuat.',
                'data' => []
            ]);
        }

        return $next($request);
    }
}
