<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Menu;

class IsHaveAccess
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
        $url = $request->path();
        $user_id = auth()->user()->id;

        $isHaveAccess = Menu::getMenuByIdAndUrl($user_id, $url);
        $givenAccess = Menu::getMenuById($user_id);
        $givenAccess = $givenAccess[0]->url;

        if ($isHaveAccess == false) {
            return redirect($givenAccess);
        }

        return $next($request);
    }
}
