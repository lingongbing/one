<?php

Route::domain('one.com')->group(function () {
	Route::get('/', function () {
		return view('welcome');
	});
});

Route::domain('agent.one.com')->group(function () {
	Route::get('/', function () {
		return view('welcome');
	});
});