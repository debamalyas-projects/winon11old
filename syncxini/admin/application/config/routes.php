<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "login";
$route['404_override'] = 'error';


/*********** USER DEFINED ROUTES *******************/
$route['loginMe'] = 'login/loginMe';
$route['dashboard'] = 'user';
$route['logout'] = 'user/logout';
$route['userListing'] = 'user/userListing';
$route['companyListing'] = 'company/companyListing';
$route['companyHistoryListing'] = 'company/companyHistoryListing';
$route['companyHistoryListing/(:num)'] = 'company/companyHistoryListing/$1';
$route['companyListing/(:num)'] = "company/companyListing/$1";
$route['zoneListing'] = 'zone/zoneListing';
$route['customerListing'] = 'customer/customerListing';
$route['contestListing'] = 'contest/contestListing';
$route['zoneListing/(:num)'] = "zone/zoneListing/$1";
$route['customerListing/(:num)'] = "customer/customerListing/$1";
$route['contestListing/(:num)'] = "contest/contestListing/$1";
$route['addNew'] = "user/addNew";
$route['addNewCompany'] = "company/addNewCompany";
$route['addNewZone'] = "zone/addNewZone";
$route['addNewCustomer'] = "customer/addNewCustomer";
$route['addNewContest'] = "contest/addNewContest";

$route['addNewUser'] = "user/addNewUser";
$route['postCompany'] = "company/postCompany";
$route['postZone'] = "zone/postZone";
$route['postCustomer'] = "customer/postCustomer";
$route['postContest'] = "contest/postContest";
$route['editOld'] = "user/editOld";
$route['editOld/(:num)'] = "user/editOld/$1";
$route['editCompanyOld/(:num)'] = "company/editCompanyOld/$1";
$route['viewCompanyOld/(:num)'] = "company/viewCompanyOld/$1";
$route['editZoneOld/(:num)'] = "zone/editZoneOld/$1";
$route['editCustomerOld/(:num)'] = "customer/editCustomerOld/$1";
$route['editContestOld/(:num)'] = "contest/editContestOld/$1";
$route['viewZoneOld/(:num)'] = "zone/viewZoneOld/$1";
$route['viewCustomerOld/(:num)'] = "customer/viewCustomerOld/$1";
$route['viewContestOld/(:num)'] = "contest/viewContestOld/$1";
$route['editUser'] = "user/editUser";
$route['editCompany'] = "company/editCompany";
$route['editZone'] = "zone/editZone";
$route['editCustomer'] = "customer/editCustomer";
$route['editContest'] = "contest/editContest";
$route['deleteUser'] = "user/deleteUser";
$route['changeStatusCompany'] = "company/changeStatusCompany";
$route['changeStatusZone'] = "zone/changeStatusZone";
$route['changeStatusCustomer'] = "customer/changeStatusCustomer";
$route['changeStatusContest'] = "contest/changeStatusContest";
$route['loadChangePass'] = "user/loadChangePass";
$route['changePassword'] = "user/changePassword";
$route['pageNotFound'] = "user/pageNotFound";
$route['checkEmailExists'] = "user/checkEmailExists";
$route['checkZoneExists'] = "zone/checkZoneExists";
$route['checkCustomerExists'] = "customer/checkCustomerExists";
$route['checkContestExists'] = "zone/checkContestExists";
$route['checkCompanyExists'] = "company/checkCompanyExists";

$route['forgotPassword'] = "login/forgotPassword";
$route['resetPasswordUser'] = "login/resetPasswordUser";
$route['resetPasswordConfirmUser'] = "login/resetPasswordConfirmUser";
$route['resetPasswordConfirmUser/(:any)'] = "login/resetPasswordConfirmUser/$1";
$route['resetPasswordConfirmUser/(:any)/(:any)'] = "login/resetPasswordConfirmUser/$1/$2";
$route['createPasswordUser'] = "login/createPasswordUser";

/*API Routes*/
$route['register'] = "api/register";

/* End of file routes.php */
/* Location: ./application/config/routes.php */

$route['loginKite'] = 'kite/loginKite';
$route['registerSaveSession'] = 'kite/registerSaveSession';
$route['getLatestInstruments'] = 'kite/getLatestInstruments';
$route['updateAllInstrumentsHistoricalData'] = 'kite/updateAllInstrumentsHistoricalData';
$route['updateContestInstrumentsHistoricalData'] = 'kite/updateContestInstrumentsHistoricalData';