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

/*Route::get('/', function()
{
    return 'Sistema en mantención, vuelva a intentarlo más tarde.';
});*/
//app reserva de horas
Route::get('/','HomeController@Index');
Route::post('reservas/buscar','HomeController@BuscarReserva');
Route::get('/horasdisponibles/{fecha}/{planta}/{patente}/{convenio}','HomeController@HorasDisponibles');
Route::post('reservas/reservar','HomeController@Reservar');
Route::post('email-to-share','HomeController@EmailToShare');


//admin app
Route::get('/admin','HomeController@IndexAdmin');
Route::post('/login','HomeController@Login');
Route::get('/logout','HomeController@Logout');
Route::get('/reservas/list','HomeController@ListarReservas');
Route::get('/reservas/delete/{id}','HomeController@DeleteReservas');
Route::any('/reservas/crud','HomeController@CrudReservas');
Route::get('/plantas/list','HomeController@ListarPlantas');
Route::any('/plantas/crud','HomeController@CrudPlantas');
Route::get('/plantas/horas/{id}/list','HomeController@ListarPlantasHoras');
Route::any('/plantas/horas/{id}/crud','HomeController@CrudPlantasHoras');
Route::get('/plantas/horas_weekend/{id}/list','HomeController@ListarPlantasHorasWeekend');
Route::any('/plantas/horas_weekend/{id}/crud','HomeController@CrudPlantasHorasWeekend');



//informes
Route::get('/informes/general/{planta?}/{fecha_desde?}/{fecha_hasta?}','InformesController@General');
Route::get('/informes/general//{fecha_desde?}/{fecha_hasta?}','InformesController@GeneralFechas');
Route::get('/informes/pordiaget','InformesController@PorDiaGet');
Route::post('/informes/pordia','InformesController@PorDia');
Route::get('/informes/correos','InformesController@ListarCorreos');

//crontab
Route::get('/email/remember','InformesController@SendRememberEmail');