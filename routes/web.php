<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('index');
});

Route::get('/apartment/v4', function () {
    return view('apartment.v4');
});

Route::get('/demo/index5', function () {
    return view('demo.index5');
});

Route::get('/single/index5', function () {
    return view('single.index5');
});
