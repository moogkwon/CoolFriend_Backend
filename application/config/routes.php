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
|	https://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['v1/user/login']='api/login';
$route['v1/user/update']='api/update';
$route['v1/user/location']='api/setLocation';

$route['v1/user/upload-video']='api/uploadVideo';
$route['v1/contacts/selective']='api/selective';
$route['v1/friend/add']='api/addFriend';
$route['v1/friend/remove']='api/removeFriend';
$route['v1/friend/check']='api/checkFriend';
$route['v1/friend/list']='api/listFriends';
$route['v1/payment/done']='api/payment';
$route['v1/pushes/store']='api/storeToken';
$route['v1/pushes/list']='api/getPushes';
$route['v1/pushes/sent']='api/pushSent';

$route['v1/user/check']='api/checkUser';
$route['v1/user/disconnected']='api/userDisconnected';
$route['v1/call/start']='apiCall/callStart';
$route['v1/call/accepted']='apiCall/callAccepted';
$route['v1/call/rejected']='apiCall/callRejected';
$route['v1/call/finished']='apiCall/callFinished';
$route['v1/call/complaint']='apiCall/addComplaint';


$route['ref/(:any)'] = "home/ref/$1";
