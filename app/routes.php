<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//app reserva de horas
Route::get('/','HomeController@Index');
Route::post('reservas/buscar','HomeController@BuscarReserva');
Route::get('/horasdisponibles/{fecha}/{planta}','HomeController@HorasDisponibles');
Route::post('reservas/reservar','HomeController@Reservar');


//admin app
Route::get('/admin','HomeController@IndexAdmin');
Route::post('/login','HomeController@Login');
Route::get('/logout','HomeController@Logout');
Route::get('/reservas/list','HomeController@ListarReservas');
Route::any('/reservas/crud','HomeController@CrudReservas');
