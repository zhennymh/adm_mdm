<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Menu;

class IsSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user_id = auth()->user()->id;
        $givenAccess = Menu::getMenuById($user_id);
        $givenAccess = $givenAccess[0]->url;

        if (auth()->user()->role_id !== 1) {
            return redirect($givenAccess);
        }

        return $next($request);
    }
}
