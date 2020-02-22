<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    //
    public function index($name, $last = '')
    {
        //echo __METHOD__;
        return view('admin.welcome', [
            'name' => $name,
            //'last' => $last,
        ]);

        /*return view('admin.welcome')
            ->with([
                'name' => $name,
                'last' => $last,
            ]);*/
        /*$x = 'XX';
        var_dump(compact('name', 'last', 'x'));
        exit;
        return view('admin.welcome', compact('name', 'last'));*/

    }

    public function hello()
    {
        //echo __METHOD__;
        $route = route('welcome', ['last' => 'Safadi', 'name' => 'Mohammed']);

        echo '<a href="' . $route . '">Welcome</a>';
    }
}
