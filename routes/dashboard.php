<?php

use Illuminate\Support\Facades\Route;

$dashboard_route = config('var.dashboard_route');


Route::get('/', 'App\Http\Controllers\backend\BaseController@index')->name('main_dashboard')->middleware('CheckAdminAuth');
Route::get('/login', 'App\Http\Controllers\backend\BaseController@login_page')->name('dashboard_login');
Route::post('/login', 'App\Http\Controllers\backend\BaseController@login')->name('post_login');

Route::namespace('App\Http\Controllers\backend')->middleware('CheckAdminAuth')->group(function () {

    Route::get('/profile', 'BaseController@profile')->name('dashboard_profile');
    Route::put('/profile', 'BaseController@edit_profile')->name('post_dashboard_profile');
    Route::get('/logout', 'BaseController@logout')->name('dashboard_logout');
    Route::get('/switch_lang/{lang}', 'BaseController@switch_lang')->name('dashboard_switch_lang');
    Route::get('/langs/', 'BaseController@lang')->name('dashboard_lang');
    Route::get('/lang/{file}', 'BaseController@one_lang')->name('dashboard_one_lang');
    Route::post('/lang/{file}/{slug}', 'BaseController@update_lang')->name('dashboard_update_lang');

    Route::get('/clear_cash', function () {

        clearCash();
        redirect()->back();
    });

    Route::get('change_stage_tasks', function () {
        $request = request()->all();
        return changeStageTasksAjax($request['stage'], $request['task']);
    });

    Route::get('reports/single/{key}', 'builder_management\ReportController@single')->name('dashboard_single_report');


    Route::get('get_data_db_table', function () {
        $request = request()->all();
        $data = getValueByTableName($request['table'], [$request['table_field']], [$request['where'] => $request['value']]);
        return response()->json($data);
    });

    Route::get('change_stage_tasks', function () {
        $request = request()->all();
        return changeStageTasksAjax($request['stage'], $request['task']);
    });
    Route::get('change_status_clients', function () {
        $request = request()->all();
        return changeStatusClientAjax($request['status'], $request['client']);
    });
    Route::prefix('database')->namespace('database_management')->group(function () {
        Route::get('/connection', 'SettingsController@index')->name('connect_database.add_form');
        Route::post('/connection', 'SettingsController@connect_database')->name('connect_database.post');
        Route::get('/tables/genrate-migration', 'TablesController@genrateMigrationFiles')->name('tables.genrate-migration');
        Route::resource('tables', 'TablesController', ['names' => 'tables']);

        // Route::resource('tables', 'TablesController', [
        //     'as' => 'tables'
        // ]);

    });
    Route::prefix('builder')->group(function () {
        Route::get('modules/repository', 'builder_management\ModuleController@repository');
        Route::get('modules/repository_delete', 'builder_management\ModuleController@repository_delete');
        Route::resource('modules', 'builder_management\ModuleController', ['names' => 'modules']);
        Route::get('module_fields/translate/{id}', 'builder_management\ModuleFieldsController@translate');
        Route::resource('module_fields', 'builder_management\ModuleFieldsController', ['names' => 'module_fields']);
        Route::resource('charts', 'builder_management\ChartsController', ['names' => 'charts']);
        Route::resource('counters', 'builder_management\CountersController', ['names' => 'counters']);
        Route::resource('reports', 'builder_management\ReportController', ['names' => 'reports']);
        Route::resource('api', 'builder_management\ApiController', ['names' => 'api']);
        Route::resource('notifications', 'builder_management\NotificationController', ['names' => 'notifications']);
        Route::get('tranfare/data_transfare', 'builder_management\TeansfareController@trasfare_data');
        Route::resource('tranfare', 'builder_management\TeansfareController', ['names' => 'tranfare']);

    });

    Route::prefix('setting')->namespace('setting_management')->group(function () {
        Route::resource('general', 'GeneralController', ['names' => 'generals']);
        Route::resource('languages', 'LanguageController', ['names' => 'languages']);

        Route::get('codes/create_file/{id}', 'CodeController@EnumCreator')->name('codes.EnumCreator');
        Route::resource('codes', 'CodeController', ['names' => 'codes']);
        Route::resource('seo', 'SeoController', ['names' => 'seo']);

    });


    Route::prefix('administrator')->namespace('admin_management')->group(function () {
        Route::resource('admins', 'AdminsController', ['names' => 'admins']);
        Route::resource('roles', 'RolesController', ['names' => 'roles']);
        Route::resource('branches', 'BranchesController', ['names' => 'branches']);


    });

    Route::prefix('tasks')->namespace('task_management')->group(function () {
        Route::delete('tasks/delete_all', 'TasksController@destroy_multi');
        Route::resource('tasks', 'TasksController', ['names' => 'tasks']);

        Route::delete('boards/delete_all', 'BoardController@destroy_multi');
        Route::resource('boards', 'BoardController', ['names' => 'boards']);
    });


    Route::prefix('location')->name('location.')->namespace('locations_management')->group(function () {
        Route::delete('locations_districts/delete_all', 'DistrictsController@destroy_multi');
        Route::post('locations_districts/translate/{id}', 'DistrictsController@translate_store');
        Route::get('locations_districts/translate/{id}', 'DistrictsController@translate')->name('area.translate');
        Route::resource('locations_districts', 'DistrictsController', ['names' => 'district']);

        Route::delete('locations_state/delete_all', 'StatesConctroller@destroy_multi');
        Route::post('locations_state/translate/{id}', 'StatesConctroller@translate_store');
        Route::get('locations_state/translate/{id}', 'StatesConctroller@translate')->name('state.translate');
        Route::resource('locations_state', 'StatesConctroller', ['names' => 'state']);

        Route::delete('locations_city/delete_all', 'CitiesController@destroy_multi');
        Route::post('locations_city/translate/{id}', 'CitiesController@translate_store');
        Route::get('locations_city/translate/{id}', 'CitiesController@translate')->name('city.translate');
        Route::resource('locations_city', 'CitiesController', ['names' => 'city']);

        Route::delete('locations_management/delete_all', 'CountriesController@destroy_multi');
        Route::post('locations_management/translate/{id}', 'CountriesController@translate_store');
        Route::get('locations_management/translate/{id}', 'CountriesController@translate')->name('country.translate');
        Route::resource('locations_management', 'CountriesController', ['names' => 'country']);
    });


    Route::delete('account_boards/delete_all', 'accounts_management\BoardController@destroy_multi');
    Route::post('account_boards/translate/{id}', 'accounts_management\BoardController@translate_store');
    Route::get('account_boards/translate/{id}', 'accounts_management\BoardController@translate')->name('translate');
    Route::resource('account_boards', 'accounts_management\BoardController', ['names' => 'account_boards']);

    Route::delete('contact-us/delete_all', 'ticket_support_management\ContactUsController@destroy_multi');
    Route::resource('contact-us', 'ticket_support_management\ContactUsController', ['names' => 'contact-us']);


    Route::prefix('modules')->namespace('custom_modules_management')->group(function () {

//route dynamic here

        Route::delete('subscriptions/delete_all', 'Subscriptions\SubscriptionController@destroy_multi');
        Route::post('subscriptions/translate/{id}', 'Subscriptions\SubscriptionController@translate_store');
        Route::get('subscriptions/translate/{id}', 'Subscriptions\SubscriptionController@translate')->name('subscriptions.translate');
        Route::resource('subscriptions', 'Subscriptions\SubscriptionController', ['names' => 'subscriptions']);

        Route::delete('trips/delete_all', 'Trips\TripController@destroy_multi');
        Route::post('trips/translate/{id}', 'Trips\TripController@translate_store');
        Route::get('trips/translate/{id}', 'Trips\TripController@translate')->name('trips.translate');
        Route::resource('trips', 'Trips\TripController', ['names' => 'trips']);

        Route::delete('packages/delete_all', 'Packages\PackageController@destroy_multi');
        Route::post('packages/translate/{id}', 'Packages\PackageController@translate_store');
        Route::get('packages/translate/{id}', 'Packages\PackageController@translate')->name('packages.translate');
        Route::resource('packages', 'Packages\PackageController', ['names' => 'packages']);

        Route::delete('routes/delete_all', 'Routes\RouteController@destroy_multi');
        Route::post('routes/translate/{id}', 'Routes\RouteController@translate_store');
        Route::get('routes/translate/{id}', 'Routes\RouteController@translate')->name('routes.translate');
        Route::resource('routes', 'Routes\RouteController', ['names' => 'routes']);

        Route::delete('schools/delete_all', 'Schools\SchoolController@destroy_multi');
        Route::post('schools/translate/{id}', 'Schools\SchoolController@translate_store');
        Route::get('schools/translate/{id}', 'Schools\SchoolController@translate')->name('schools.translate');
        Route::resource('schools', 'Schools\SchoolController', ['names' => 'schools']);

        Route::delete('buses/delete_all', 'Buses\BusController@destroy_multi');
        Route::post('buses/translate/{id}', 'Buses\BusController@translate_store');
        Route::get('buses/translate/{id}', 'Buses\BusController@translate')->name('buses.translate');
        Route::resource('buses', 'Buses\BusController', ['names' => 'buses']);

        Route::delete('supervisors/delete_all', 'Supervisors\SupervisorController@destroy_multi');
        Route::post('supervisors/translate/{id}', 'Supervisors\SupervisorController@translate_store');
        Route::get('supervisors/translate/{id}', 'Supervisors\SupervisorController@translate')->name('supervisors.translate');
        Route::resource('supervisors', 'Supervisors\SupervisorController', ['names' => 'supervisors']);

        Route::delete('drivers/delete_all', 'Drivers\DriverController@destroy_multi');
        Route::post('drivers/translate/{id}', 'Drivers\DriverController@translate_store');
        Route::get('drivers/translate/{id}', 'Drivers\DriverController@translate')->name('drivers.translate');
        Route::resource('drivers', 'Drivers\DriverController', ['names' => 'drivers']);

        Route::delete('students/delete_all', 'Students\StudentController@destroy_multi');
        Route::post('students/translate/{id}', 'Students\StudentController@translate_store');
        Route::get('students/translate/{id}', 'Students\StudentController@translate')->name('students.translate');
        Route::resource('students', 'Students\StudentController', ['names' => 'students']);

        Route::delete('parents/delete_all', 'Parents\ParentController@destroy_multi');
        Route::post('parents/translate/{id}', 'Parents\ParentController@translate_store');
        Route::get('parents/translate/{id}', 'Parents\ParentController@translate')->name('parents.translate');
        Route::resource('parents', 'Parents\ParentController', ['names' => 'parents']);


//End route dynamic

    });
});
