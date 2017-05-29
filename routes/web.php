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
		return response()->download(__DIR__.'/../storage/exports/'.$nombre_reporte.'.xls');	
	});
	Route::get('reportes/descargar/pdf/{nombre_reporte}', function($nombre_reporte) {
	    return response()->download(__DIR__.'/../public/'.$nombre_reporte.'.pdf');
	});
	Route::get('alumnos/descargar/excel/{nombre_archivo}', function($nombre_archivo) {
		return response()->download(__DIR__.'/../storage/exports/'.$nombre_archivo.'.xls');
	});
	Route::get('alumnos/descargar/pdf/{nombre_archivo}', function($nombre_archivo) {
		return response()->download(__DIR__.'/../storage/app/'.$nombre_archivo.'.pdf');
	});
	Route::get('descargar/excel/{nombre_archivo}', function($nombre_archivo) {
		return response()->download(__DIR__.'/../storage/exports/'.$nombre_archivo.'.xls');
	});
	Route::get('descargar/pdf/{nombre_archivo}', function($nombre_archivo) {
		return response()->download(__DIR__.'/../storage/exports/'.$nombre_archivo.'.pdf');
	});	

	//Alumnos
	Route::get('alumnos','alumnosController@get');
	Route::get('alumnos/tabla','alumnosController@getTabla');
	Route::get('alumnos/alta','alumnosController@create');
	Route::get('alumnos/establecimientos','alumnosController@getEstablecimientos');
	Route::get('alumnos/nombre_organismo','alumnosController@getNombreOrganismo');
	Route::get('alumnos/excel','alumnosController@getExcel');
	Route::get('alumnos/pdf','alumnosController@getPdf');
	Route::get('alumnos/filtrado','alumnosController@getFiltrado');
	Route::get('alumnos/documentos/{documento}','alumnosController@checkDocumentos');
	Route::get('alumnos/{id}','alumnosController@edit');


	Route::post('alumnos','alumnosController@store');

	Route::put('alumnos/{id}','alumnosController@update');

	Route::delete('alumnos/{id}','alumnosController@destroy');

	//Profesores
	Route::get('profesores','profesoresController@get');
	Route::get('profesores/tabla','profesoresController@getTabla');
	Route::get('profesores/alta','profesoresController@create');
	Route::get('profesores/filtrado','profesoresController@getFiltrado');
	Route::get('profesores/excel','profesoresController@getExcel');
	Route::get('profesores/pdf','profesoresController@getPdf');
	Route::get('profesores/documentos/{documento}','profesoresController@checkDocumentos');
	Route::get('profesores/{id}','profesoresController@edit');

	Route::post('profesores','profesoresController@store');

	Route::put('profesores/{id}','profesoresController@update');

	Route::delete('profesores/{id}','profesoresController@destroy');

//Cursos
	Route::get('cursos','cursosController@get');
	Route::get('cursos/tabla','cursosController@getTabla');
	Route::get('cursos/joined','cursosController@getJoined');
	Route::get('cursos/alta','cursosController@create');
	Route::get('cursos/nombres','cursosController@getNombres');
	Route::get('cursos/excel','cursosController@getExcel');
	Route::get('cursos/pdf','cursosController@getPdf');
	Route::get('cursos/filtrado','cursosController@getFiltrado');
	Route::get('cursos/alumno/{id}','cursosController@getAprobadosPorAlumno');
	Route::get('cursos/profesor/{id}','cursosController@getDictadosPorProfesor');
	Route::get('cursos/provincias/{id}','cursosController@getAlumnosDeCursosPorProvincia');
	Route::get('cursos/{id}/alumnos','cursosController@getAlumnos');
	Route::get('cursos/{id}','cursosController@edit');

	Route::post('cursos','cursosController@store');

	Route::put('cursos/{id}','cursosController@update');

	Route::delete('cursos/{id}','cursosController@destroy');

//Relaciones de cursos con alumnos y profesores
	Route::get('curso/{id}','cursosController@getByID');
	Route::get('users/{id}/alumnos', 'cursosController@getAlumnos');

	//Encuestas
	Route::resource('encuestas', 'Encuestas\EncuestaController');

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
		Route::get('areasTematicas/alta','areasTematicasController@create');
		Route::get('areasTematicasTabla','areasTematicasController@getTabla');
		Route::get('areasTematicas/{id}','areasTematicasController@edit');

		Route::post('areasTematicas','areasTematicasController@store');

		Route::put('areasTematicas/{id}','areasTematicasController@update');

		Route::delete('areasTematicas/{id}','areasTematicasController@destroy');


//Lineas estrategicas
		Route::get('lineasEstrategicas','lineasEstrategicasController@getTodos');
		Route::get('lineasEstrategicasTabla','lineasEstrategicasController@getTabla');
		Route::get('lineasEstrategicas/alta','lineasEstrategicasController@create');
		Route::get('lineasEstrategicas/{id}','lineasEstrategicasController@edit');

		Route::post('lineasEstrategicas','lineasEstrategicasController@store');

		Route::put('lineasEstrategicas/{id}','lineasEstrategicasController@update');

		Route::delete('lineasEstrategicas/{id}','lineasEstrategicasController@destroy');

	//Gestores
		Route::get('gestores/tabla','gestoresController@getTabla');
		Route::resource('gestores', 'gestoresController');

//No modificables

//Paises
		Route::get('paises/nombres','paisesController@getNombres');

//Provincias
		Route::get('provincias','provinciasController@index');
		Route::get('provincias/{id}','provinciasController@show');

//Efectores
		Route::get('efectores','efectoresController@get');
		Route::get('efectores/tabla','efectoresController@getTabla');
		Route::get('efectores/nombres','efectoresController@getNombres');
		Route::get('efectores/cuies','efectoresController@getCuiesTypeahead');
		Route::get('efectores/siisas','efectoresController@getSiisas');
		Route::get('efectores/typeahead','efectoresController@getTripleTypeahead');
		Route::get('efectores/{cuie}/cursos','efectoresController@historialCursos');
	});
});

//Otros
Route::get('/registrar', function() {
	return view('registrar');
});
Auth::routes();

Route::get('/home', 'HomeController@index');



