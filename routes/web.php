<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('index');
});

// apartment
Route::get('/apartment/left', function () {
    return view('apartment.left');
});
Route::get('/apartment/right', function () {
    return view('apartment.right');
});
Route::get('/apartment/single', function () {
    return view('apartment.single');
});
Route::get('/apartment/v1', function () {
    return view('apartment.v1');
});
Route::get('/apartment/v2', function () {
    return view('apartment.v2');
});
Route::get('/apartment/v3', function () {
    return view('apartment.v3');
});
Route::get('/apartment/v4', function () {
    return view('apartment.v4');
});
Route::get('/apartment/v5', function () {
    return view('apartment.v5');
});
Route::get('/apartment/v6', function () {
    return view('apartment.v6');
});

// blogs
Route::get('/blogs/blog', function () {
    return view('blogs.blog');
});
Route::get('/blogs/left', function () {
    return view('blogs.left');
});
Route::get('/blogs/right', function () {
    return view('blogs.right');
});
Route::get('/blogs/single', function () {
    return view('blogs.single');
});

// demo
Route::get('/demo/index2', function () {
    return view('demo.index2');
});
Route::get('/demo/index3', function () {
    return view('demo.index3');
});
Route::get('/demo/index4', function () {
    return view('demo.index4');
});
Route::get('/demo/index5', function () {
    return view('demo.index5');
});
Route::get('/demo/index6', function () {
    return view('demo.index6');
});
Route::get('/demo/index7', function () {
    return view('demo.index7');
});
Route::get('/demo/index8', function () {
    return view('demo.index8');
});
Route::get('/demo/index9', function () {
    return view('demo.index9');
});
Route::get('/demo/index10', function () {
    return view('demo.index10');
});

// pages
Route::get('/pages/about', function () {
    return view('pages.about');
});
Route::get('/pages/contact', function () {
    return view('pages.contact');
});
Route::get('/pages/gallery-v1', function () {
    return view('pages.gallery-v1');
});
Route::get('/pages/gallery-v2', function () {
    return view('pages.gallery-v2');
});
Route::get('/pages/testimonial', function () {
    return view('pages.testimonial');
});

// single
Route::get('/single/index1', function () {
    return view('single.index1');
});
Route::get('/single/index2', function () {
    return view('single.index2');
});
Route::get('/single/index3', function () {
    return view('single.index3');
});
Route::get('/single/index4', function () {
    return view('single.index4');
});
Route::get('/single/index5', function () {
    return view('single.index5');
});
Route::get('/single/index6', function () {
    return view('single.index6');
});
Route::get('/single/index7', function () {
    return view('single.index7');
});
Route::get('/single/index8', function () {
    return view('single.index8');
});
Route::get('/single/index9', function () {
    return view('single.index9');
});
Route::get('/single/index10', function () {
    return view('single.index10');
});
