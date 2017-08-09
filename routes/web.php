<?php

/*
|--------------------------------------------------------------------------
| Test Routes
|--------------------------------------------------------------------------
*/


Route::get('tests', function () {
    return view('test/test');
});

Route::get('test', 'TestController@hello');
Route::get('test/filtros', 'TestController@filtros');

Route::get('test/profesoresEnUnCurso', 'CursosController@getProfesores');

/* Route::get('test/documentos', 'AbmController@tiposDocumentos'); */

Route::get('test/joined', 'AlumnosController@datosJoineados');
Route::get('test/excel', 'ReportesController@getExcel');

Route::get('test/pdf', 'ReportesController@getPdf');

Route::resource('log', 'LogController');

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

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/adminlte', function () {
    return view('adminlte');
});

Route::get('/starter', function () {
    return view('starter');
});

Route::get('/entrar', function () {
    return view('entrar');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

//Dashboard
Route::get('dashboard/datos', 'DashboardController@get');
Route::get('dashboard/data', 'AlumnosController@getActivos');

Route::group(['middleware' => ['logueado']],function () {
    //Descarga
    Route::get('reportes/descargar/excel/{nombre_reporte}', function ($nombre_reporte) {
        return response()->download(__DIR__."/../storage/exports/{$nombre_reporte}.xls");
    });
    Route::get('reportes/descargar/pdf/{nombre_reporte}', function ($nombre_reporte) {
        return response()->download(__DIR__."/../public/{$nombre_reporte}.pdf");
    });
    Route::get('alumnos/descargar/excel/{nombre_archivo}', function ($nombre_archivo) {
        return response()->download(__DIR__."/../storage/exports/{$nombre_archivo}.xls");
    });
    Route::get('alumnos/descargar/pdf/{nombre_archivo}', function ($nombre_archivo) {
        return response()->download(__DIR__."/../storage/app/{$nombre_archivo}.pdf");
    });
    Route::get('descargar/excel/{nombre_archivo}', function ($nombre_archivo) {
        return response()->download(__DIR__."/../storage/exports/{$nombre_archivo}.xls");
    });
    Route::get('descargar/pdf/{nombre_archivo}', function ($nombre_archivo) {
        return response()->download(__DIR__."/../storage/exports/{$nombre_archivo}.pdf");
    });

    //Alumnos
    Route::get('alumnos', 'AlumnosController@get');
    Route::get('alumnos/tabla', 'AlumnosController@getTabla');
    Route::get('alumnos/alta', 'AlumnosController@create');
    Route::get('alumnos/establecimientos', 'AlumnosController@getEstablecimientos');
    Route::get('alumnos/nombre_organismo', 'AlumnosController@getNombreOrganismo');
    Route::get('alumnos/excel', 'AlumnosController@getExcel');
    Route::get('alumnos/pdf', 'AlumnosController@getPdf');
    Route::get('alumnos/filtrado', 'AlumnosController@getFiltrado');
    Route::get('alumnos/documentos/{documento}', 'AlumnosController@checkDocumentos');
    Route::get('alumnos/typeahead/nombres', 'AlumnosController@getNombres');
    Route::get('alumnos/typeahead/apellidos', 'AlumnosController@getApellidos');
    Route::get('alumnos/typeahead/documentos', 'AlumnosController@getDocumentos');
    Route::get('alumnos/{id}', 'AlumnosController@edit');


    Route::post('alumnos', 'AlumnosController@store');

    Route::put('alumnos/{id}', 'AlumnosController@update');

    Route::delete('alumnos/{id}', 'AlumnosController@destroy');

    //Profesores
    Route::get('profesores', 'ProfesoresController@get');
    Route::get('profesores/tabla', 'ProfesoresController@getTabla');
    Route::get('profesores/alta', 'ProfesoresController@create');
    Route::get('profesores/filtrado', 'ProfesoresController@getFiltrado');
    Route::get('profesores/excel', 'ProfesoresController@getExcel');
    Route::get('profesores/pdf', 'ProfesoresController@getPdf');
    Route::get('profesores/documentos/{documento}', 'ProfesoresController@checkDocumentos');
    Route::get('profesores/typeahead', 'ProfesoresController@getTypeahead');
    Route::get('profesores/{id}', 'ProfesoresController@edit');

    Route::post('profesores', 'ProfesoresController@store');

    Route::put('profesores/{id}', 'ProfesoresController@update');

    Route::delete('profesores/{id}', 'ProfesoresController@destroy');

//Cursos
    Route::get('cursos', 'CursosController@get');
    Route::get('cursos/tabla', 'CursosController@getTabla');
    Route::get('cursos/joined', 'CursosController@getJoined');
    Route::get('cursos/alta', 'CursosController@create');
    Route::get('cursos/nombres', 'CursosController@getNombres');
    Route::get('cursos/excel', 'CursosController@getExcel');
    Route::get('cursos/pdf', 'CursosController@getPdf');
    Route::get('cursos/filtrado', 'CursosController@getFiltrado');
    Route::get('cursos/alumno/{id}', 'CursosController@getAprobadosPorAlumno');
    Route::get('cursos/profesor/{id}', 'CursosController@getDictadosPorProfesor');
    Route::get('cursos/provincias/{id}', 'CursosController@getAlumnosDeCursosPorProvincia');
    Route::get('cursos/{id}/alumnos', 'CursosController@getAlumnos');
    Route::get('cursos/{id}/profesores', 'CursosController@getProfesores');
    Route::get('cursos/{id}', 'CursosController@edit');

    Route::post('cursos', 'CursosController@store');

    Route::put('cursos/{id}', 'CursosController@update');

    Route::delete('cursos/{id}', 'CursosController@destroy');

//Relaciones de cursos con alumnos y profesores
    Route::get('curso/{id}', 'CursosController@getByID');
    Route::get('users/{id}/alumnos', 'CursosController@getAlumnos');
/* 
//Filtros para todas las abms
    Route::get('filtros/{tabla}', 'AbmController@filtros');
    Route::get('formularioConFiltros/{tabla}', 'AbmController@formularioConFiltros'); */

//Reportes
    Route::get('reportes', 'ReportesController@get');
    Route::get('reportes/cursos', 'ReportesController@getCursos');
    Route::get('reportes/cursos/provincias/{id}/count', 'CursosController@getCountAlumnos');

    
    Route::get('reportes/excel', 'ReportesController@getExcelReporte');
    Route::get('reportes/excel6', 'CursosController@getExcelReporte');
    Route::get('reportes/pdf', 'ReportesController@getPDFReporte');
    /*Route::get('reportes/pdf','ReportesController@getPdf');*/
    Route::get('reportes/query', 'ReportesController@queryReporte');
    Route::get('reportes/query/test', 'ReportesController@queryTest');
    Route::get('reportes/{id_reporte}', 'ReportesController@reporte');

    //Encuestas
    Route::get('encuestas/g_plannacer', 'Encuestas\EncuestaController@g_plannacer');
    Route::get('encuestas/g_plannacer/datos', 'Encuestas\EncuestaController@g_plannacerDatos');
    Route::get('encuestas/google_form', 'Encuestas\EncuestaController@google_form');
    Route::get('encuestas/survey', 'Encuestas\EncuestaController@survey');
    Route::get('encuestas/grafico', 'Encuestas\EncuestaController@grafico');
    Route::resource('encuestas', 'Encuestas\EncuestaController');

    //Efectores informacion que pueden acceder las provincias.
    Route::get('efectores/nombres', 'EfectoresController@getNombres');
        Route::get('efectores/cuies', 'EfectoresController@getCuiesTypeahead');
        Route::get('efectores/siisas', 'EfectoresController@getSiisas');
        Route::get('efectores/typeahead', 'EfectoresController@getTripleTypeahead');

    Route::group(['middleware' => 'admin'], function () {

//ADMIN
//Areas tematicas
        Route::get('areasTematicas', 'AreasTematicasController@getTodos');
        Route::get('areasTematicas/alta', 'AreasTematicasController@create');
        Route::get('areasTematicasTabla', 'AreasTematicasController@getTabla');
        Route::get('areasTematicas/{id}', 'AreasTematicasController@edit');

        Route::post('areasTematicas', 'AreasTematicasController@store');

        Route::put('areasTematicas/{id}', 'AreasTematicasController@update');

        Route::delete('areasTematicas/{id}', 'AreasTematicasController@destroy');


        //Tipo de acciones
        Route::get('lineasEstrategicas', 'LineasEstrategicasController@getTodos');
        Route::get('lineasEstrategicasTabla', 'LineasEstrategicasController@getTabla');
        Route::get('lineasEstrategicas/alta', 'LineasEstrategicasController@create');
        Route::get('lineasEstrategicas/{id}', 'LineasEstrategicasController@edit');

        Route::post('lineasEstrategicas', 'LineasEstrategicasController@store');

        Route::put('lineasEstrategicas/{id}', 'LineasEstrategicasController@update');

        Route::delete('lineasEstrategicas/{id}', 'LineasEstrategicasController@destroy');

        //Gestores
        Route::get('gestores/tabla', 'GestoresController@getTabla');
        Route::resource('gestores', 'GestoresController');

        //Periodos
        Route::get('periodos/table', 'PeriodosController@table');
        Route::resource('periodos', 'PeriodosController');

        //Funciones/Roles del sumar
        Route::resource('funciones', 'FuncionesController');

        //Tipo de docentes
        Route::resource('tipoDocentes', 'TipoDocentesController');

        //No modificables

        //Paises
        Route::get('paises/nombres', 'PaisesController@getNombres');

        //Provincias
        Route::get('provincias', 'ProvinciasController@index');
        Route::get('provincias/{id}', 'ProvinciasController@show');

        //Efectores
        Route::get('efectores', 'EfectoresController@get');
        Route::get('efectores/tabla', 'EfectoresController@getTabla');       
        Route::get('efectores/{cuie}/cursos', 'EfectoresController@historialCursos');
    });
});

//Otros
Route::get('/registrar', function () {
    return view('registrar');
});
Auth::routes();

Route::get('/home', 'HomeController@index');
