<?php

Route::domain(env('DOMAIN_HOME'))->group(function () {
	Route::get('{a?}/{b?}/{c?}', function () {
		return view('home');
	});
});

Route::domain(env('DOMAIN_AGENT'))->group(function () {
	Route::get('{a?}/{b?}/{c?}', function () {
		return view('agent');
	});
});