<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class Lang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $acceptLang = $request->header('Accept-Language');
        //return response($acceptLang);
        $acceptLangArr = ['en']; //explode(',', $acceptLang);

        $route = Route::current();
        $lang = $route->parameter('lang', $acceptLangArr[0]);
        //return response($lang);
        App::setLocale($lang);

        URL::defaults([
            'lang' => $lang,
        ]);

        $route->forgetParameter('lang');

        return $next($request);
    }
}
