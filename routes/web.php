<?php

Route::resource('calidad', 'CalidadController');

/*
|--------------------------------------------------------------------------
| Test Routes
|--------------------------------------------------------------------------
*/

Route::get('test', 'TestController@hello');
Route::get('test/filtros', 'TestController@filtros');
Route::get('test/profesoresEnUnCurso', 'CursosController@getProfesores');
Route::get('test/joined', 'AlumnosController@datosJoineados');
Route::get('test/excel', 'ReportesController@getExcel');
Route::get('test/pdf', 'ReportesController@getPdf');

/*
|--------------------------------------------------------------------------
| Login Routes
|--------------------------------------------------------------------------
*/

Auth::routes();
Route::get('/home', 'DashboardController@index');

Route::get('/', 'DashboardController@index');
Route::get('/entrar', 'DashboardController@entrar');
Route::get('/registrar', 'DashboardController@registrar');

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
*/

Route::get('dashboard', 'DashboardController@index');
Route::get('dashboard/datos', 'DashboardController@get');
Route::get('dashboard/data', 'AlumnosController@getActivos');
Route::get('dashboard/draw/first', 'DashboardController@firstDraw');
Route::get('dashboard/draw/areas', 'DashboardController@areas');
Route::get('dashboard/draw/trees', 'DashboardController@trees');
Route::get('dashboard/draw/pies', 'DashboardController@pies');
Route::get('dashboard/draw/heats', 'DashboardController@heats');
Route::get('dashboard/draw/progress', 'DashboardController@progress');

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

//Logueado
Route::group(['middleware' => ['logueado','logging']], function () {

    Route::get('omeka', 'OmekaController@iframe');
    //Materiales
    Route::get('materiales/etapa/{id_etapa}/table', 'MaterialesController@table');
    Route::get('materiales/etapa/{id_etapa}/list', 'MaterialesController@listar');
    Route::get('materiales/etapa/{id_etapa}', 'MaterialesController@view');
    Route::get('materiales/{id}/download', 'MaterialesController@download');
    Route::post('materiales/etapa/{id_etapa}', 'MaterialesController@store');
    Route::post('materiales/{id}', 'MaterialesController@replace');
    Route::resource('materiales', 'MaterialesController', ['except' => ['create', 'edit', 'store']]);

    //Redis
    Route::get('redis/usuarios', 'RedisController@usuarios');

    //Log
    Route::resource('log', 'LogController');

    //Descarga
    Route::get(
        'reportes/descargar/excel/{nombre_archivo}',
        'DescargasController@excel'
    );
    Route::get(
        'descargar/excel/{nombre_archivo}',
        'DescargasController@excel'
    );
    Route::get(
        'alumnos/descargar/excel/{nombre_archivo}',
        'DescargasController@excel'
    );

    Route::get('descargar/pdf/{nombre_archivo}', 'DescargasController@pdf');
    Route::get(
        'reportes/descargar/pdf/{nombre_archivo}',
        'DescargasController@pdfReportes'
    );
    Route::get('alumnos/descargar/pdf/{nombre_archivo}', 'DescargasController@pdfAlumnos');

    //Alumnos
    Route::get('alumnos', 'AlumnosController@get');
    Route::get('alumnos/tabla', 'AlumnosController@getTabla');
    Route::get('alumnos/alta', 'AlumnosController@create');
    Route::get('alumnos/establecimientos', 'AlumnosController@getEstablecimientos');
    Route::get('alumnos/nombre_organismo', 'AlumnosController@getNombreOrganismo');
    Route::get('alumnos/excel', 'AlumnosController@getExcel');
    Route::get('alumnos/pdf', 'AlumnosController@getPdf');
    Route::get('alumnos/filtrado', 'AlumnosController@getFiltrado');
    Route::get('alumnos/documentos', 'AlumnosController@checkDocumentos');
    Route::get('alumnos/typeahead/nombres', 'AlumnosController@getNombres');
    Route::get('alumnos/typeahead/apellidos', 'AlumnosController@getApellidos');
    Route::get('alumnos/typeahead/documentos', 'AlumnosController@getDocumentos');
    Route::get('alumnos/{id}/see', 'AlumnosController@see');
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
    Route::get('profesores/documentos', 'ProfesoresController@checkDocumentos');
    Route::get('profesores/typeahead', 'ProfesoresController@getTypeahead');
    Route::get('profesores/{id}/see', 'ProfesoresController@see');
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
    Route::get('cursos/{id}/excel', 'CursosController@getCompletoExcel');
    Route::get('cursos/{id}/show', 'CursosController@show');
    Route::get('cursos/{id}/see', 'CursosController@see');
    Route::get('cursos/{id}', 'CursosController@edit');

    Route::post('cursos', 'CursosController@store');

    Route::put('cursos/{id}', 'CursosController@update');

    Route::delete('cursos/{id}', 'CursosController@destroy');

    //Relaciones de cursos con alumnos y profesores
    Route::get('curso/{id}', 'CursosController@getByID');
    Route::get('users/{id}/alumnos', 'CursosController@getAlumnos');

    /*
     * Filtros para todas las abms
     * Route::get('filtros/{tabla}', 'AbmController@filtros');
     * Route::get('formularioConFiltros/{tabla}', 'AbmController@formularioConFiltros'); 
     */

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

    //PAC
    Route::get('pacs', 'PacController@get');
    Route::get('pacs/alta', 'PacController@create');
    Route::get('pacs/tabla', 'PacController@getTabla');
    Route::get('pacs/{id_pac}/tablaEdiciones', 'PacController@getTablaEdiciones');
    // Route::get('pacs/filtrarPac', 'PacController@getFiltradoPac');
    // Route::get('pacs/filtrarAcciones', 'PacController@getFiltradoAcciones');
    // Route::get('pacs/excel', 'PacController@getExcel');
    // Route::get('pacs/documentos', 'PacController@checkDocumentos');
    // Route::get('pacs/typeahead', 'PacController@getTypeahead');
    Route::get('pacs/{id}/see', 'PacController@see');
    Route::get('pacs/{id}/edit', 'PacController@edit');
    Route::get('pacs/{id}/excel', 'PacController@getCompletoExcel');

    Route::post('pacs', 'PacController@store');

    // Route::put('pacs/{id}', 'PacController@update');

    Route::delete('pacs/{id_pac}', 'PacController@destroy');

    //Pac->Fichas Tecnicas
    Route::get('pacs/fichas_tecnicas/{id_ficha}/download', 'PacController@downloadFichaTecnica');
    Route::get('pacs/{id_pac}/tablaFicha', 'PacController@getTablaFicha');
    Route::post('pacs/{id_pac}', 'PacController@storeFichaTecnica');
    Route::put('pacs/fichas_tecnicas/{id_ficha}', 'PacController@replaceFichaTecnica');

    //Encuestas
    Route::get('encuestas/g_plannacer', 'Encuestas\EncuestasController@gPlannacer');
    Route::get('encuestas/g_plannacer/datos', 'Encuestas\EncuestasController@gPlannacerDatos');
    Route::get('encuestas/google_form', 'Encuestas\EncuestasController@googleForm');
    Route::get('encuestas/survey', 'Encuestas\EncuestasController@survey');
    Route::get('encuestas/grafico', 'Encuestas\EncuestasController@grafico');
    Route::post('encuestas/subida', 'Encuestas\EncuestasController@subida');
    Route::resource('encuestas', 'Encuestas\EncuestasController');

        //Efectores
    Route::get('efectores', 'EfectoresController@get');
    Route::get('efectores/tabla', 'EfectoresController@getTabla');
    Route::get('efectores/nombres', 'EfectoresController@getNombres');
    Route::get('efectores/cuies', 'EfectoresController@getCuiesTypeahead');
    Route::get('efectores/siisas', 'EfectoresController@getSiisas');
    Route::get('efectores/typeahead', 'EfectoresController@getTripleTypeahead');
    Route::get('efectores/nombres/typeahead', 'EfectoresController@nombresTypeahead');
    Route::get('efectores/cuies/typeahead', 'EfectoresController@cuiesTypeahead');
    Route::get('efectores/filtrar', 'EfectoresController@filtrar');
    Route::get('efectores/provincias/{id_provincia}/departamentos', 'EfectoresController@selectDepartamentos');
    Route::get(
        'efectores/provincias/{id_provincia}/departamentos/{id_departamento}/localidades',
        'EfectoresController@selectLocalidades'
    );
    Route::get('efectores/{cuie}/cursos', 'EfectoresController@historialCursos');
    Route::get('efectores/{cuie}/participantes', 'EfectoresController@getParticipantes');

    Route::get('provincias/localidades/typeahead', 'ProvinciasController@localidadesTypeahead');

    //CALIDAD
    Route::get('calidad/formulario', function() {
            return view('idasdasdas'); 
    });
    //ADMIN
    Route::group(['middleware' => 'admin'], function () {

        Route::get('dashboard/notificaciones', 'DashboardController@getHistorial');
        Route::get('ideas/historial-completo', 'DashboardController@getHistorialCompleto');

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
        Route::get('funciones/table', 'FuncionesController@table');
        Route::resource('funciones', 'FuncionesController');
        
        //Tipo de docentes
        Route::get('tipoDocentes/table', 'TipoDocentesController@table');
        Route::resource('tipoDocentes', 'TipoDocentesController');

        //Session
        Route::get('session', 'TestController@session');

        Route::get('session/put', 'TestController@sessionPut');

        //No modificables

        //Paises
        Route::get('paises/nombres', 'PaisesController@getNombres');

        //Provincias
        Route::get('provincias', 'ProvinciasController@index');
        Route::get('provincias/{id}', 'ProvinciasController@show');

        //Logs
        Route::get('logs/mostrar/{date}','LogController@log');
    });
});
