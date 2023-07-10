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
$route['login'] = 'App/login';
$route['account/login'] = 'Page/login';
$route['logout'] = 'Page/logout';
$route['account'] = 'Page/dashboard';

#ACCOUNT 
$route['account/dashboard'] = 'Page/dashboard';
$route['account/product-list'] = 'Page/productList';
$route['account/users-list'] = 'Page/usersList';
$route['account/boarding'] = 'Page/boarding';
$route['account/services'] = 'Page/services';
$route['account/surgery'] = 'Page/surgery';
$route['account/confinement'] = 'Page/confinement';
$route['account/grooming'] = 'Page/grooming';
$route['account/orders'] = 'Page/orders';
$route['account/reports'] = 'Page/reports';
$route['order/(:any)'] = 'Page/viewOrder/$1';
$route['account/activity-logs'] = 'Page/activityLogs';
$route['account/settings'] = 'Page/settings';

# USER
$route['api/v1/user/_get_cashflow'] = 'User/getCashflow';
$route['api/v1/user/_get_category'] = 'User/getCategory';
$route['api/v1/user/_new_cashflow_record'] = 'User/addNewCashflowRecord';
$route['api/v1/user/_get_cashflow_statistics'] = 'User/getCashflowStat';
$route['api/v1/user/_change_password'] = 'User/changePasword';
$route['api/v1/user/_get_cashflow_details'] = 'User/getCashflowDetails';
$route['api/v1/user/_update_cashflow_record'] = 'User/updateNewCashflowRecord';
$route['api/v1/user/_get_account_type'] = 'User/getAccountType';
$route['api/v1/user/_new_account'] = 'User/addNewAccount';
$route['api/v1/user/_get_accounts'] = 'User/getAccounts';
$route['api/v1/user/_get_accounts_list'] = 'User/getAccountsList';

# REPORTS
$route['api/v1/reports/_monthly_sales_reports'] = 'Reports/getMonthlySalesReports';
$route['api/v1/reports/_per_client_monthly_sales_reports'] = 'Reports/getClientSalesReports';
$route['api/v1/report/_add_sales_per_client_remark'] = 'Reports/addSalesPerClientRemark';
$route['api/v1/report/_add_daily_report'] = 'Reports/addDailyReports';
$route['api/v1/report/_activity_logs'] = 'Reports/getActivityLogs';
$route['api/v1/report/_get_daily_report_data'] = 'Reports/getDailyReportDataByDate';

# LOGIN
$route['api/v1/account/_login'] = 'Login/loginProcess';

# Statistics
$route['api/v1/statistics/_get_website_stat'] = 'Statistics/getWebsiteStatsChart';
$route['api/v1/statistics/_most_sold_products'] = 'Statistics/mostSoldProducts';
$route['api/v1/statistics/product_by_qty'] = 'Statistics/productsByQty';
$route['api/v1/statistics/_most_sold_service'] = 'Statistics/mostSoldService';

$route['api/v1/xss/_get_csrf_data'] = 'App/getCsrfData';

$route['default_controller'] = 'App/login';
$route['404_override'] = 'Error404';
$route['translate_uri_dashes'] = TRUE;
