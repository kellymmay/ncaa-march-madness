<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('bracket');
});

Route::get('/how-it-works', function () {
    return view('how-it-works');
});
