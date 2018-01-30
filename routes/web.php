<?php

Route::domain('one.com')->group(function () {
	Route::get('{a?}/{b?}/{c?}', function () {
		return view('home');
	});
});

Route::domain('agent.one.com')->group(function () {
	Route::get('{a?}/{b?}/{c?}', function () {
		return view('agent');
	});
});