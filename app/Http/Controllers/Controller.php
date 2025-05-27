<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class Controller
{
    public function share(Request $request)
    {
        return [
            'auth' => [
                'user' => $request->user() ? $request->user()->load('role') : null,
            ],
        ];
    }
}
