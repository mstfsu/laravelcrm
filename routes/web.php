<?php

use App\Http\Controllers\LanguageController;
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
Auth::routes(['verify' => true]);
Route::group(['middleware'=>['auth','Tenancy']], function () {
    Route::group(["middleware"=>"CheckISP"], function () {
        Route::get('agents/index_data', 'AgentController@index_data')->name('agents_index_data');
        Route::get('agents/get_area', 'AgentController@get_area')->name('agents_get_area');
        Route::get('agent_work_hours/{id}', 'AgentController@agent_work_hours')->name('agents_work_hours')->middleware('role_or_permission:super admin|Show Agent Work Hours');
        Route::post('agent_hours','AgentController@work_hours')->name('work_hours_agent');
        Route::get('agent_classification', 'AgentController@agent_classification')->name('agent-classification')->middleware('role_or_permission:super admin|Show Agent Classification');
        Route::get('delete_agent_from_group', 'AgentController@delete_agent_from_group')->name('delete_agent_from_group');
        Route::post('classification_group_add_agent', 'AgentController@classification_group_add_agent')->name('classification_group_add_agent')->middleware('role_or_permission:super admin|Agent Classification Add Admin');
        Route::get('change_agent_level', 'AgentController@change_agent_level')->name('change_agent_level');
        Route::get('agents/track_agent', 'AgentController@track_agent')->name('track_agent');
        Route::get('agents/get_agent_info', 'AgentController@get_agent_info')->name('get_agent_info');

        Route::get('agents/get_agent_map_infos', 'AgentController@get_agent_map_infos')->name('get_agent_map_infos');
        Route::get('agents/create', 'AgentController@create')->name('agents.create');
        Route::get('agents/remove_all','AgentController@remove_all')->name('agent_remove_all');
        Route::get('agents/approve_all_request','AgentController@approve_all_request')->name('agent_approve_all_request');
        Route::get('agents/approve_agent_request','AgentController@approve_agent_request')->name('agent_approve_agent_request');

        Route::resource('agents', 'AgentController', ['only' => [ 'index']])->middleware('role_or_permission:super admin|Show Agents');
        Route::resource('agents', 'AgentController', ['only' => [ 'show']])->middleware('role_or_permission:super admin|Show Agent');
        Route::resource('agents', 'AgentController', ['only' => [ 'edit']])->middleware('role_or_permission:super admin|Edit Agent');

        Route::resource('agents', 'AgentController', ['only' => [ 'destroy']])->middleware('role_or_permission:super admin|Remove Agent');

        Route::resource('agents', 'AgentController',['except' => ['index','destroy','show','edit']]);
    });

    Route::group(["middleware"=>"CheckISP"], function () {
        Route::get('tasks/get_subjects', 'TaskController@get_subjects')->name('task_get_subjects');
        Route::get('tasks/index_data','TaskController@index_data')->name('task_index_data');
        Route::get('tasks/change_priority', 'TaskController@change_priority')->name('task_change_priority');
        Route::get('tasks/change_status', 'TaskController@change_status')->name('task_change_status');
        Route::get('tasks/change_type', 'TaskController@change_type')->name('tasks_change_type');
        Route::get('tasks/close_ticket', 'TaskController@close_ticket')->name('tasks_close_ticket')->middleware('role_or_permission:super admin|Close Task');
        Route::get('tasks/get_types', 'TaskController@get_types')->name('task_get_types');
        Route::get('tasks/delete_type', 'TaskController@delete_type')->name('task_delete_type')->middleware('role_or_permission:super admin|Remove Task Type');
        Route::get('tasks/delete_subject', 'TaskController@delete_subject')->name('task_delete_subject')->middleware('role_or_permission:super admin|Remove Task Subject');
        Route::get('tasks/add_subject', 'TaskController@add_subject')->name('task_add_subject')->middleware('role_or_permission:super admin|Add Task Subject');
        Route::get('tasks/add_type', 'TaskController@add_type')->name('task_add_type')->middleware('role_or_permission:super admin|Add Task Type');
        Route::get('tasks/config','TaskController@config')->name('task_config')->middleware('role_or_permission:super admin|Show Task Config');
        Route::get('tasks/remove_all','TaskController@remove_all')->name('task_remove_all');
        Route::get('tasks/get_ticket_with_live_search','TaskController@get_ticket_with_live_search')->name('task_get_ticket_with_live_search');
        Route::get('tasks/subjects_of_type','TaskController@subjects_of_type')->name('task_subjects_of_type');

        Route::resource('tasks', 'TaskController', ['only' => [ 'index']])->middleware('role_or_permission:super admin|Show Tasks');
        Route::resource('tasks', 'TaskController', ['only' => [ 'store']])->middleware('role_or_permission:super admin|Create Task');
        Route::resource('tasks', 'TaskController',['except' => ['index','store']]);
    });
    Route::get('lang/{locale}', [LanguageController::class, 'swap']);

});
Route::group(['prefix' => 'Customer'], function () {
       Route::get('/index', 'SubscriberHomeController@index')->name('customers-dashboard');
       Route::get('tickets','SubscriberHomeController@customer_tickets')->name('customer_tickets');
       Route::get('tickets/index_data','SubscriberHomeController@index_data')->name('customer_tickets_index_data');
       Route::get('tickets/show_ticket/{id}','SubscriberHomeController@show_ticket')->name('customer_show_ticket');
       Route::post('tickets/send_message','SubscriberHomeController@send_message')->name('customer_send_message');

});

Route::prefix('Agent')->group(function () {
    Route::post('/generate_token', 'AgentMobileController@generate_token')->name('agent-generate-token');
    Route::post('/create_map_info', 'AgentMobileController@create_map_info')->name('agent-create-map-info')->middleware(['auth:api-agent']);
    Route::get('/get_agent_last_location', 'AgentMobileController@get_agent_last_location')->name('agent-get-agent-last-location')->middleware(['auth:api-agent']);
    Route::post('/set_agent_phone_unique_number', 'AgentMobileController@set_agent_phone_unique_number')->name('agent-set-agent-phone-unique-number');
    Route::get('/get_agent_phone_unique_number', 'AgentMobileController@get_agent_phone_unique_number')->name('agent-get-agent-phone-unique-number')->middleware(['auth:api-agent']);
    Route::get('/change_phone_request', 'AgentMobileController@change_phone_request')->name('agent-change-phone-request')->middleware(['auth:api-agent']);
    Route::get('/get_task', 'AgentMobileController@get_task')->name('agent-get-task')->middleware(['auth:api-agent']);
    Route::get('/get_closed_task', 'AgentMobileController@get_closed_task')->name('agent-get-closed-task')->middleware(['auth:api-agent']);
    Route::get('/close_task', 'AgentMobileController@close_task')->name('agent-close-task')->middleware(['auth:api-agent']);

});
