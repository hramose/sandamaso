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
Route::post('reservas/buscar','BuscadorController@BuscarReserva');
Route::get('/horasdisponibles/{fecha}/{planta}/{patente}/{convenio}','BuscadorController@HorasDisponibles');
Route::post('reservas/reservar','HomeController@Reservar');
Route::post('email-to-share','HomeController@EmailToShare');


/*
** Admin app
*/

//login
Route::get('/admin','HomeController@IndexAdmin');
Route::get('/login','HomeController@IndexAdmin');
Route::post('/login','HomeController@Login');
Route::get('/logout','HomeController@Logout');
//reservas
Route::group(array('before' => 'auth'), function()
{
	Route::group(array('prefix' => 'admin'), function(){

		//ADMIN RESERVAS
		Route::get('/reservas/list','ReservasController@ListarReservas');
		Route::get('/reservas-convenio/list','ReservasController@ListarReservasConvenio');
		Route::get('/reservas/delete/{id}','ReservasController@DeleteReservas');
		Route::any('/reservas/crud','ReservasController@CrudReservas');

		//ADMIN PLANTAS
		Route::get('/plantas/list','PlantasController@ListarPlantas');
		Route::any('/plantas/crud','PlantasController@CrudPlantas');
		Route::get('/plantas/horas/{id}/list','PlantasController@ListarPlantasHoras');
		Route::any('/plantas/horas/{id}/crud','PlantasController@CrudPlantasHoras');
		Route::get('/plantas/horas_weekend/{id}/list','PlantasController@ListarPlantasHorasWeekend');
		Route::any('/plantas/horas_weekend/{id}/crud','PlantasController@CrudPlantasHorasWeekend');
		Route::get('/plantas/empresas/{id}/list','PlantasController@ListarPlantasEmpresas');
		Route::any('/plantas/empresas/{id}/crud','PlantasController@CrudPlantasEmpresas');

		//ADMIN EMPRESAS
		Route::get('/empresas/list','EmpresasController@ListarEmpresas');
		Route::any('/empresas/crud','EmpresasController@CrudEmpresas');


		//ADMIN INFORMES
		Route::get('/informes/general','InformesController@General');
		Route::get('/informes/pordiaget','InformesController@PorDiaGet');
		Route::post('/informes/pordia','InformesController@PorDia');
		Route::get('/informes/correos','InformesController@ListarCorreos');
	});




});


//Rutas publicas Ajax
Route::get('/get-empresas','EmpresasController@ListaEmpresasPorIdPlanta');
Route::post('/savesession-idempresa','BuscadorController@SaveSessionIdEmpresa');

/*
** Crontab
*/
Route::get('/email/remember','InformesController@SendRememberEmail');