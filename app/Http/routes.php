<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'ContactsController@index');

Route::resource('contacts', 'ContactsController');
Route::post('contacts/update/{id}', 'ContactsController@updateTheContact')->name('update.contact');
Route::get('contacts/delete/{id}', 'ContactsController@delete')->name('delete.contact');
Route::get('contacts/autocomplete', ['uses' => 'ContactsController@autocomplete', 'as' => 'contacts.autocomplete']);
Route::post('groups/store', ['uses' => 'GroupsController@store', 'as' => 'groups.store']);

Route::auth();

Route::get('/home', 'HomeController@index');
