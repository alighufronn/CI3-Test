<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Dashboard
$route['default_controller'] = 'DashboardController';
$route['dashboard'] = 'DashboardController/index';

// Auth
$route['login'] = 'UserController/login';
$route['logout'] = 'UserController/logout';
$route['login/login_process'] = 'UserController/login_process';


// Admin
$route['users'] = 'UserController/index';
$route['UserController/add_user'] = 'UserController/add_user';
$route['UserController/load_users'] = 'UserController/load_users';
$route['UserController/delete_user'] = 'UserController/delete_user';
$route['UserController/get_users'] = 'UserController/get_users';
$route['UserController/edit_user'] = 'UserController/edit_user';

// Calendar
$route['calendar'] = 'CalendarController/index';
$route['CalendarController/load_events'] = 'CalendarController/load_events';
$route['CalendarController/add_event'] = 'CalendarController/add_event';
$route['CalendarController/update_event'] = 'CalendarController/update_event';
$route['CalendarController/delete_event'] = 'CalendarController/delete_event';
$route['CalendarController/add_event_role'] = 'CalendarController/add_event_role';

// To Do List
$route['todo'] = 'todoController/index';
$route['todoController/loads'] = 'todoController/loads';
$route['todoController/add_todo'] = 'todoController/add_todo';
$route['todoController/update_todo'] = 'todoController/update_todo';
$route['todoController/delete_todo'] = 'todoController/delete_todo';
$route['todoController/get_todo'] = 'todoController/get_todo';

// Chat
$route['chat'] = 'ChatController/index';
$route['ChatController/load_chats'] = 'ChatController/load_chats';
$route['ChatController/load_chats_with_user'] = 'ChatController/load_chats_with_user';
$route['ChatController/load_users'] = 'ChatController/load_users';
$route['ChatController/receive_chats'] = 'ChatController/receive_chats';
$route['ChatController/send_chat'] = 'ChatController/send_chat';