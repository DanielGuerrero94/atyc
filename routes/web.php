<?php

/*
|--------------------------------------------------------------------------
| Test Routes
|--------------------------------------------------------------------------
*/


Route::get('tests',function ()
{
	return view('test/test');
});
Route::get('test','testController@hello');
Route::get('test/filtros','testController@filtros');

Route::get('test/profesoresEnUnCurso','cursosController@getProfesores');

Route::get('test/documentos','abmController@tiposDocumentos');

Route::get('test/joined','alumnosController@datosJoineados');
Route::get('test/excel','reportesController@getExcel');

Route::get('test/pdf','reportesController@getPdf');

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
/*
Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', function () {
	return view('dashboard');
});

Route::get('/adminlte', function() {
	return view('adminlte');
});

Route::get('/starter', function() {
	return view('starter');
});

Route::get('/entrar', function() {
	return view('entrar');
});

Route::get('/dashboard', function() {
	return view('dashboard');
});



//Dashboard
Route::get('dashboard/datos','dashboardController@get');
Route::get('dashboard/data','alumnosController@getActivos');

Route::group(['middleware' => 'logueado'], function () {
	//Descarga
	Route::get('reportes/descargar/excel/{nombre_reporte}', function($nombre_reporte) {
	    return response()->download('/var/www/html/eLearning/storage/exports/'.$nombre_reporte.'.xls');
	});
	Route::get('reportes/descargar/pdf/{nombre_reporte}', function($nombre_reporte) {
	    return response()->download('/var/www/html/eLearning/public/'.$nombre_reporte.'.pdf');
	});
	

	//Alumnos
	Route::get('alumnos','alumnosController@get');
	Route::get('alumnos/joined','alumnosController@getJoined');
	Route::get('alumnosTabla','alumnosController@getAlumnosTabla');
	Route::get('alumnos/alta','alumnosController@getAlta');
	Route::get('alumnos/establecimientos','alumnosController@getEstablecimientos');
	Route::get('alumnos/nombre_organismo','alumnosController@getNombreOrganismo');
	Route::get('alumnos/{id}','alumnosController@getData');
	Route::get('alumnos/documentos/{documento}','alumnosController@checkDocumentos');



	Route::post('alumnos','alumnosController@set');

	Route::put('alumnos/{id}','alumnosController@modificar');

	Route::delete('alumnos/{id}','alumnosController@borrar');

	//Profesores
	Route::get('profesores','profesoresController@get');
	Route::get('profesoresTabla','profesoresController@getProfesoresTabla');
	Route::get('profesores/alta','profesoresController@getAlta');
	Route::get('profesores/filtrado','profesoresController@getFiltrado');
	Route::get('profesores/{id}','profesoresController@getData');

	Route::post('profesores','profesoresController@set');

	Route::put('profesores/{id}','profesoresController@modificar');

	Route::delete('profesores/{id}','profesoresController@borrar');

//Cursos
	Route::get('cursos','cursosController@get');
	Route::get('cursos/tabla','cursosController@getTabla');
	Route::get('cursos/joined','cursosController@getJoined');
	Route::get('cursos/alta','cursosController@getAlta');
	Route::get('cursos/nombres','cursosController@getNombres');
	Route::get('cursos/alumno/{id}','cursosController@getAprobadosPorAlumno');

	Route::get('cursos/{id}','cursosController@getData');
	Route::get('cursos/{id}/alumnos','cursosController@getAlumnos');
	
	Route::get('cursos/provincias/{id}','cursosController@getAlumnosDeCursosPorProvincia');

	Route::post('cursos','cursosController@set');

	Route::put('cursos/{id}','cursosController@modificar');

	Route::delete('cursos/{id}','cursosController@borrar');

//Relaciones de cursos con alumnos y profesores
	Route::get('curso/{id}','cursosController@getByID');
	Route::get('users/{id}/alumnos', 'cursosController@getAlumnos');

//Encuestas
	Route::resource('encuestas', 'encuestasController');
	/*Route::get('encuestas','encuestasController@get');
	Route::get('encuestas/joined','encuestasController@getJoined');
//No hay nada en las encuestas virtuales la hice al pedo al parecer
	Route::get('encuestas/virtuales','encuestasController@getVirtuales');
	Route::get('encuestas/virtuales/joined','encuestasController@getVirtualesJoined');*/

//Filtros para todas las abms
	Route::get('filtros/{tabla}','abmController@filtros');
	Route::get('formularioConFiltros/{tabla}','abmController@formularioConFiltros');

//Reportes
	Route::get('reportes','reportesController@get');
	Route::get('reportes/cursos','reportesController@getCursos');
	Route::get('reportes/cursos/provincias/{id}/count','cursosController@getCountAlumnos');

	
	Route::get('reportes/excel','reportesController@getExcelReporte');
	Route::get('reportes/pdf','reportesController@getPDFReporte');
	/*Route::get('reportes/pdf','reportesController@getPdf');*/
	Route::get('reportes/query','reportesController@queryReporte');
	Route::get('reportes/query/test','reportesController@queryTest');
	Route::get('reportes/{id_reporte}','reportesController@reporte');


	Route::group(['middleware' => 'admin'], function () {

//ADMIN
//Areas tematicas
		Route::get('areasTematicas','areasTematicasController@getTodos');
		Route::get('areasTematicas/alta','areasTematicasController@getAlta');
		Route::get('areasTematicasTabla','areasTematicasController@getTabla');
		Route::get('areasTematicas/{id}','areasTematicasController@get');

		Route::post('areasTematicas/set','areasTematicasController@set');

		Route::put('areasTematicas/{id}','areasTematicasController@modificar');

		Route::delete('areasTematicas/{id}','areasTematicasController@borrar');


//Lineas estrategicas
		Route::get('lineasEstrategicas','lineasEstrategicasController@getTodos');
		Route::get('lineasEstrategicasTabla','lineasEstrategicasController@getTabla');
		Route::get('lineasEstrategicas/alta','lineasEstrategicasController@getAlta');
		Route::get('lineasEstrategicas/{id}','lineasEstrategicasController@get');

		Route::post('lineasEstrategicas','lineasEstrategicasController@set');

		Route::put('lineasEstrategicas/{id}','lineasEstrategicasController@modificar');

		Route::delete('lineasEstrategicas/{id}','lineasEstrategicasController@borrar');

	//Gestores
		Route::get('gestores/tabla','gestoresController@getTabla');
		Route::resource('gestores', 'gestoresController');

//No modificables

//Paises
		Route::get('paises/nombres','paisesController@getNombres');

//Provincias
		Route::get('provincias','provinciasController@getAll');
		Route::get('provincias/{id}','provinciasController@get');

		Route::post('provincias','provinciasController@set');

//Efectores
		Route::get('efectores','efectoresController@get');
		Route::get('efectores/tabla','efectoresController@getTabla');
		Route::get('efectores/nombres','efectoresController@getNombres');
		Route::get('efectores/cuies','efectoresController@getCuies');
		Route::get('efectores/siisas','efectoresController@getSiisas');
		Route::get('efectores/typeahead','efectoresController@getTripleTypeahead');
	});
});

//Otros
Route::get('/registrar', function() {
	return view('registrar');
});
Auth::routes();

Route::get('/home', 'HomeController@index');



