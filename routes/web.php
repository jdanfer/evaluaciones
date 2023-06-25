<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::get('/enviar_correo', 'App\Http\Controllers\AdminController@sendCorreo');
Route::get('/crearexcel', 'App\Http\Controllers\AdminController@crearExcel');
//Route::get('procesos/arqueo/cobrados', 'App\Http\Controllers\AdminController@showCobrados');

Route::group(['middleware' => 'auth'], function () {
    //    Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
    Route::get('admin/settings', ['as' => 'admin.settings', 'uses' => 'App\Http\Controllers\AdminController@showUser']);
    Route::put('profile/update', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
    Route::get('profile', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
    //Cargos
    Route::get('admin/cargos/crear', ['as' => 'admin/cargos/crear', 'uses' => 'App\Http\Controllers\AdminController@showCargoCreate']);
    Route::get('admin/cargos', ['as' => 'admin/cargos', 'uses' => 'App\Http\Controllers\AdminController@showCargo']);
    Route::get('admin/cargos/{id}/editar', ['as' => 'admin/cargos/{id}/editar', 'uses' => 'App\Http\Controllers\AdminController@showCargoEdit']);
    Route::post('admin/cargos/{id}/editar', ['as' => 'admin/cargos/{id}/editar', 'uses' => 'App\Http\Controllers\AdminController@editCargo']);
    Route::get('admin/cargos/{id}/eliminar', ['as' => 'admin/cargos/{id}/eliminar', 'uses' => 'App\Http\Controllers\AdminController@deleteCargo']);
    Route::post('admin/cargos', ['as' => 'admin/cargos', 'uses' => 'App\Http\Controllers\AdminController@createCargo']);
    ///Períodos
    Route::get('admin/periodos/crear', ['as' => 'admin/periodos/crear', 'uses' => 'App\Http\Controllers\AdminController@showPeriodoCreate']);
    Route::get('admin/periodos', ['as' => 'admin/periodos', 'uses' => 'App\Http\Controllers\AdminController@showPeriodo']);
    Route::get('admin/periodos/{id}/editar', ['as' => 'admin/periodos/{id}/editar', 'uses' => 'App\Http\Controllers\AdminController@showPeriodoEdit']);
    Route::post('admin/periodos/{id}/editar', ['as' => 'admin/periodos/{id}/editar', 'uses' => 'App\Http\Controllers\AdminController@editPeriodo']);
    Route::get('admin/periodos/{id}/eliminar', ['as' => 'admin/periodos/{id}/eliminar', 'uses' => 'App\Http\Controllers\AdminController@deletePeriodo']);
    Route::post('admin/periodos', ['as' => 'admin/periodos', 'uses' => 'App\Http\Controllers\AdminController@createPeriodo']);

    ///Jefaturas
    Route::get('admin/jefaturas/crear', ['as' => 'admin/jefaturas/crear', 'uses' => 'App\Http\Controllers\AdminController@showJefaturaCreate']);
    Route::get('admin/jefaturas', ['as' => 'admin/jefaturas', 'uses' => 'App\Http\Controllers\AdminController@showJefatura']);
    Route::get('admin/jefaturas/{id}/editar', ['as' => 'admin/jefaturas/{id}/editar', 'uses' => 'App\Http\Controllers\AdminController@showJefaturaEdit']);
    Route::post('admin/jefaturas/{id}/editar', ['as' => 'admin/jefaturas/{id}/editar', 'uses' => 'App\Http\Controllers\AdminController@editJefatura']);
    Route::get('admin/jefaturas/{id}/eliminar', ['as' => 'admin/jefaturas/{id}/eliminar', 'uses' => 'App\Http\Controllers\AdminController@deleteJefatura']);
    Route::post('admin/jefaturas', ['as' => 'admin/jefaturas', 'uses' => 'App\Http\Controllers\AdminController@createJefatura']);
    ///Títulos
    Route::get('admin/titulos/crear', ['as' => 'admin/titulos/crear', 'uses' => 'App\Http\Controllers\AdminController@showTituloCreate']);
    Route::get('admin/titulos', ['as' => 'admin/titulos', 'uses' => 'App\Http\Controllers\AdminController@showTitulo']);
    Route::get('admin/titulos/{id}/editar', ['as' => 'admin/titulos/{id}/editar', 'uses' => 'App\Http\Controllers\AdminController@showTituloEdit']);
    Route::post('admin/titulos/{id}/editar', ['as' => 'admin/titulos/{id}/editar', 'uses' => 'App\Http\Controllers\AdminController@editTitulo']);
    Route::get('admin/titulos/{id}/eliminar', ['as' => 'admin/titulos/{id}/eliminar', 'uses' => 'App\Http\Controllers\AdminController@deleteTitulo']);
    Route::post('admin/titulos', ['as' => 'admin/titulos', 'uses' => 'App\Http\Controllers\AdminController@createTitulo']);
    ///Preguntas
    Route::get('admin/preguntas/crear', ['as' => 'admin/preguntas/crear', 'uses' => 'App\Http\Controllers\AdminController@showPreguntaCreate']);
    Route::get('admin/preguntas', ['as' => 'admin/preguntas', 'uses' => 'App\Http\Controllers\AdminController@showPregunta']);
    Route::get('admin/preguntas/{id}/editar', ['as' => 'admin/preguntas/{id}/editar', 'uses' => 'App\Http\Controllers\AdminController@showPreguntaEdit']);
    Route::post('admin/preguntas/{id}/editar', ['as' => 'admin/preguntas/{id}/editar', 'uses' => 'App\Http\Controllers\AdminController@editPregunta']);
    Route::get('admin/preguntas/{id}/eliminar', ['as' => 'admin/preguntas/{id}/eliminar', 'uses' => 'App\Http\Controllers\AdminController@deletePregunta']);
    Route::get('admin/preguntas/jefaturas', ['as' => 'admin/preguntas/jefaturas', 'uses' => 'App\Http\Controllers\AdminController@deletePregunta']);
    Route::post('admin/preguntas', ['as' => 'admin/preguntas', 'uses' => 'App\Http\Controllers\AdminController@createPregunta']);
    ///Personas
    Route::get('admin/personas/crear', ['as' => 'admin/personas/crear', 'uses' => 'App\Http\Controllers\AdminController@showPersonaCreate']);
    Route::get('admin/personas', ['as' => 'admin/personas', 'uses' => 'App\Http\Controllers\AdminController@showPersona']);
    Route::get('admin/personas/editar', ['as' => 'admin/personas/editar', 'uses' => 'App\Http\Controllers\AdminController@showPersonaEdit']);
    Route::post('admin/personas/editar', ['as' => 'admin/personas/editar', 'uses' => 'App\Http\Controllers\AdminController@editPersona']);
    Route::get('admin/personas/{id}/eliminar', ['as' => 'admin/personas/{id}/eliminar', 'uses' => 'App\Http\Controllers\AdminController@deletePersona']);
    Route::get('admin/personas/jefaturas', ['as' => 'admin/personas/jefaturas', 'uses' => 'App\Http\Controllers\AdminController@deletePersona']);
    Route::post('admin/personas', ['as' => 'admin/personas', 'uses' => 'App\Http\Controllers\AdminController@createPersona']);
    ///AutoEvaluaciones
    Route::get('admin/autoevaluaciones/crear', ['as' => 'admin/autoevaluaciones/crear', 'uses' => 'App\Http\Controllers\AdminController@showAutoEvalCreate']);
    Route::get('admin/autoevaluaciones', ['as' => 'admin/autoevaluaciones', 'uses' => 'App\Http\Controllers\AdminController@showAutoeval']); //acá crea la autoeval
    Route::get('admin/autoevaluaciones/{id}/editar', ['as' => 'admin/autoevaluaciones/{id}/editar', 'uses' => 'App\Http\Controllers\AdminController@showAutoEvalEdit']);
    Route::post('admin/autoevaluaciones/{id}/editar', ['as' => 'admin/autoevaluaciones/{id}/editar', 'uses' => 'App\Http\Controllers\AdminController@editAutoEvalua']);
    Route::get('admin/autoevaluaciones/eliminar', ['as' => 'admin/autoevaluaciones/eliminar', 'uses' => 'App\Http\Controllers\AdminController@deleteAutoEval']);
    //    Route::post('admin/autoevaluaciones', ['as' => 'admin/autoevaluaciones', 'uses' => 'App\Http\Controllers\AdminController@createAutoEval']);

    ///Evaluaciones
    Route::get('admin/evaluaciones/crear', ['as' => 'admin/evaluaciones/crear', 'uses' => 'App\Http\Controllers\AdminController@showAutoEvalCreate']);
    Route::get('admin/evaluaciones', ['as' => 'admin/evaluaciones', 'uses' => 'App\Http\Controllers\AdminController@showPersonaEval']);
    Route::get('admin/evaluaciones/{id}/editar', ['as' => 'admin/evaluaciones/{id}/editar', 'uses' => 'App\Http\Controllers\AdminController@showEvalEdit']);
    Route::post('admin/evaluaciones/{id}/editar', ['as' => 'admin/evaluaciones/{id}/editar', 'uses' => 'App\Http\Controllers\AdminController@editEvalua']);
    Route::get('admin/evaluaciones/eliminar', ['as' => 'admin/evaluaciones/eliminar', 'uses' => 'App\Http\Controllers\AdminController@deleteAutoEval']);

    //Permisos
    Route::get('admin/permisos/crear', ['as' => 'admin/permisos/crear', 'uses' => 'App\Http\Controllers\AdminController@showPermisoCreate']);
    Route::get('admin/permisos', ['as' => 'admin/permisos', 'uses' => 'App\Http\Controllers\AdminController@showPermiso']);
    Route::get('admin/permisos/{id}/editar', ['as' => 'admin/permisos/{id}/editar', 'uses' => 'App\Http\Controllers\AdminController@showPermisoEdit']);
    Route::post('admin/permisos/{id}/editar', ['as' => 'admin/permisos/{id}/editar', 'uses' => 'App\Http\Controllers\AdminController@editPermiso']);
    Route::get('admin/permisos/{id}/eliminar', ['as' => 'admin/permisos/{id}/eliminar', 'uses' => 'App\Http\Controllers\AdminController@deletePermiso']);

    //Cierre
    Route::get('admin/autoevaluacion/{documento}/cerrar', ['as' => 'admin/autoevaluacion/{documento}/cerrar', 'uses' => 'App\Http\Controllers\AdminController@showAutoevalCierre']);
    Route::get('admin/evaluacion/{id}/cerrar', ['as' => 'admin/evaluacion/{id}/cerrar', 'uses' => 'App\Http\Controllers\AdminController@showEvalCierre']);

    //PDF inf evaluación
    Route::get('admin/evaluacion/{documento}/pdf', ['as' => 'admin/evaluacion/{documento}/pdf', 'uses' => 'App\Http\Controllers\AdminController@generarPDF']);

    //Informes por jefaturas
    Route::get('admin/informes/jefaturas', ['as' => 'admin/informes/jefaturas', 'uses' => 'App\Http\Controllers\AdminController@informeJefatura']);
    Route::get('admin/informes/jefaturasInf', ['as' => 'admin/informes/jefaturasInf', 'uses' => 'App\Http\Controllers\AdminController@informeJefaturaCreate']);
    //Informes por cargo
    Route::get('admin/informes/cargos', ['as' => 'admin/informes/cargos', 'uses' => 'App\Http\Controllers\AdminController@informeCargo']);
    Route::get('admin/informes/cargosInf', ['as' => 'admin/informes/cargosInf', 'uses' => 'App\Http\Controllers\AdminController@informeCargoCreate']);

    //Informes por preguntas
    Route::get('admin/informes/preguntas', ['as' => 'admin/informes/preguntas', 'uses' => 'App\Http\Controllers\AdminController@informePregunta']);
    Route::get('admin/informes/preguntasInf', ['as' => 'admin/informes/preguntasInf', 'uses' => 'App\Http\Controllers\AdminController@informePreguntaCreate']);

    //Informes con comentarios
    Route::get('admin/informes/comentarios', ['as' => 'admin/informes/comentarios', 'uses' => 'App\Http\Controllers\AdminController@informeComentario']);
    Route::get('admin/informes/comentariosInf', ['as' => 'admin/informes/comentariosInf', 'uses' => 'App\Http\Controllers\AdminController@informeComentarioCreate']);

    //    Route::get('tablasdelsistema', ['as' => 'tablasdelsistema', 'uses' => 'App\Http\Controllers\AdminController@showTabla']);
    //    Route::get('permisos/crear', ['as' => 'permisos.crear', 'uses' => 'App\Http\Controllers\AdminController@showPermisoCreate']);
    //    Route::post('permisos', ['as' => 'permisos', 'uses' => 'App\Http\Controllers\AdminController@createPermiso']);
    //    Route::get('informatica/ver', ['as' => 'informatica.ver', 'uses' => 'App\Http\Controllers\AdminController@verInformaticas']);
    //    Route::get('informatica/imprimir', ['as' => 'informatica.imprimir', 'uses' => 'App\Http\Controllers\AdminController@printInformaticas']);
    //    Route::get('informatica/imprimir/excel', ['as' => 'informatica.imprimir.excel', 'uses' => 'App\Http\Controllers\AdminController@crearExcel']);
    //    Route::get('informatica/imprimir/pdf', ['as' => 'informatica.imprimir.pdf', 'uses' => 'App\Http\Controllers\AdminController@crearPdf']);
    //    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
    //    Route::get('procesos/arqueo/cobrados', ['as' => 'procesos.arqueo.cobrados', 'uses' => 'App\Http\Controllers\AdminController@showCobrados']);
    //    Route::post('procesos/arqueo/cobrados', ['as' => 'procesos.arqueo.cobrados', 'uses' => 'App\Http\Controllers\AdminController@crearPdf']);
    //    Route::get('permisos/obteneruser', ['as' => 'permisos/{username}/obtenerpermiso', 'uses' => 'App\Http\Controllers\AdminController@obtenerPermisos']);
    ///    Route::post('permisos/obteneruser', ['as' => 'permisos/{username}/obtenerpermiso', 'uses' => 'App\Http\Controllers\AdminController@crearPermisos']);
    //   Route::get('permisos/eliminar', ['as' => 'permisos/{permiso}/{usuario}/eliminar', 'uses' => 'App\Http\Controllers\AdminController@showDeletePermiso']);
    //   Route::get('permisos/{permiso}/{usuario}/eliminar', ['as' => 'permisos/{permiso}/{usuario}/eliminar', 'uses' => 'App\Http\Controllers\AdminController@deletePermiso']);
});
