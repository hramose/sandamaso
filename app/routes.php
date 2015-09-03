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
Route::get('/horasdisponibles/{fecha}/{planta}/{patente}','HomeController@HorasDisponibles');
Route::post('reservas/reservar','HomeController@Reservar');


//admin app
Route::get('/admin','HomeController@IndexAdmin');
Route::post('/login','HomeController@Login');
Route::get('/logout','HomeController@Logout');
Route::get('/reservas/list','HomeController@ListarReservas');
Route::any('/reservas/crud','HomeController@CrudReservas');
Route::get('/plantas/list','HomeController@ListarPlantas');
Route::any('/plantas/crud','HomeController@CrudPlantas');


//informes
Route::get('/informes/general/{planta?}/{fecha_desde?}/{fecha_hasta?}','InformesController@General');
Route::get('/informes/general//{fecha_desde?}/{fecha_hasta?}','InformesController@GeneralFechas');
Route::get('/informes/pordiaget','InformesController@PorDiaGet');
Route::post('/informes/pordia','InformesController@PorDia');