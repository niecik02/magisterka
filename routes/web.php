<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


use Illuminate\Http\Request;

/*Route::get('/', function () {
    return view('layouts.app');
});
*/

app('debugbar')->disable();

Route::group([
	'middleware'=>'roles',
	'roles'=>'Edytor'
],function(){


   /*Route::get('/',[
        'uses'=>'Hello@index',
        'as'=>'hello.index'
    ]);*/


	Route::get('edytor',[
	    'uses'=>'Hello@index',
        'as'=>'hello.index'
    ]);

    Route::get('edytor/create/{page}',[
        'uses'=>'Hello@create',
        'as'=>'hello.create'
    ]);

    Route::post('edytor/store/{page}',[
        'uses'=>'Hello@store',
        'as'=>'hello.store'
    ]);

    Route::post('edytor/ponow/{page}',[
        'uses'=>'Hello@ponow',
        'as'=>'hello.ponow'
    ]);


   Route::get('edytor/{page}/edit',[
        'uses'=>'Hello@edit',
        'as'=>'hello.edit'
    ]);


    Route::put('edytor/{page}',[
        'uses'=>'Hello@update',
        'as'=>'hello.update'
    ]);

    Route::put('edytor/{page}/poprawa',[
        'uses'=>'Hello@poprawa',
        'as'=>'hello.poprawa'
    ]);

    Route::put('edytor/{page}/odrzuc',[
        'uses'=>'Hello@odrzuc',
        'as'=>'hello.odrzuc'
    ]);

    Route::put('edytor/{page}/zmienDate',[
        'uses'=>'Hello@zmienDate',
        'as'=>'hello.zmienDate'
    ]);

    Route::get('edytor/{page}/zmien/Recenzent',[
        'uses'=>'Hello@editRecenzent',
        'as'=>'hello.editRecenzent'
    ]);

    Route::put('edytor/{page}/zmien/Recenzent',[
        'uses'=>'Hello@updateRecenzent',
        'as'=>'hello.updateRecenzent'
    ]);

    Route::delete('edytor/{page}/delete/Recenzent',[
        'uses'=>'Hello@destroy',
        'as'=>'hello.destroy'
    ]);

    Route::get('edytor/{page}',[
        'uses'=>'Hello@show',
        'as'=>'hello.show'
    ]);
    Route::get('uzytkownicy/index',[
        'uses'=>'RoleController@index',
        'as'=>'uzytkownicy.index'
    ]);
    Route::post('uzytkownicy/edit',[
        'uses'=>'RoleController@edit',
        'as'=>'uzytkownicy.edit'
    ]);
    Route::get('statystyka',[
        'uses'=>'Hello@statystyka',
        'as'=>'hello.statystyka'
    ]);

    Route::POST('edytor/create/dodajUser','Hello@add');

});
Route::group([
    'middleware'=>'roles',
    'roles'=>['Uzytkownik','Edytor']
],function(){

    Route::get('autor',[
        'uses'=>'AutorController@index',
        'as'=>'autor.index'
    ]);

    Route::get('autor/create',[
        'uses'=>'AutorController@create',
        'as'=>'autor.create'
    ]);

    Route::get('autor/{page}',[
        'uses'=>'AutorController@show',
        'as'=>'autor.show'
    ]);
    Route::get('autor/uploadfile',[
        'uses'=>'AutorController@index',
        'as'=>'autor.uploadfile'
    ]);

    Route::get('autor/edit/{page}',[
        'uses'=>'AutorController@edit',
        'as'=>'autor.edit'
    ]);

    Route::put('edytor/update/{page}',[
        'uses'=>'AutorController@update',
        'as'=>'autor.update'
    ]);

    Route::post('autor/uploadfile',[
        'uses'=>'AutorController@UploadFile',
        'as'=>'autor.uploadfile'
    ]);

    Route::get('recenzent',[
        'uses'=>'RecenzentController@index',
        'as'=>'recenzent.index'
    ]);

    Route::get('recenzent/{page}/create',[
        'uses'=>'RecenzentController@create',
        'as'=>'recenzent.create'
    ]);

    Route::get('recenzent/{page}/create/Plik',[
        'uses'=>'RecenzentController@createPlik',
        'as'=>'recenzent.createPlik'
    ]);

    Route::get('recenzent/{page}',[
        'uses'=>'RecenzentController@show',
        'as'=>'recenzent.show'
    ]);
    Route::post('recenzent/store/{id}',[
        'uses'=>'RecenzentController@store',
        'as'=>'recenzent.store'
    ]);

    Route::post('recenzent/store/formularz/{id}',[
        'uses'=>'RecenzentController@storeFormularz',
        'as'=>'recenzent.storeFormularz'
    ]);

    Route::put('recenzent/akceptuj/{id}',[
        'uses'=>'RecenzentController@akceptuj',
        'as'=>'recenzent.akceptuj'
    ]);

    Route::put('recenzent/odrzuc/{id}',[
        'uses'=>'RecenzentController@odrzuc',
        'as'=>'recenzent.odrzuc'
    ]);


    Route::put('autor/odpowiedz/{page}',[
        'uses'=>'AutorController@odpowiedz',
        'as'=>'autor.odpowiedz'
    ]);

    Route::get('uzytkownicy/zmiendane',[
        'uses'=>'RoleController@zmiendane',
        'as'=>'uzytkownik.zmiendane'
    ]);

    Route::get('/download', [
        'uses'=>'RecenzentController@getDownload',
        'as'=>'recenzent.pobierz'
    ]);

    Route::POST('uzytkownicy/zmienHaslo','RoleController@zmienHaslo');
    Route::POST('uzytkownicy/zmienImie','RoleController@zmienImie');

});


Auth::routes();

Route::get('/', 'HomeController@index');


