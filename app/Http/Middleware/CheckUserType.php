<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$type)
    {
        if (!Auth::check()) {
            return redirect(route('login'));
        }
        //$user = Auth::user();
        $user = $request->user();
        
        //if ($user->type != $type) {
        if (!in_array($user->type, $type)) {
            abort(403, 'You are not Admin!!!');
            //return view();
        }

        return $next($request);
    }
}
