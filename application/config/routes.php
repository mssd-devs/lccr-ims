<?php

defined('BASEPATH') or exit('No direct script access allowed');

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
$route['default_controller'] = 'LoginController';
$route['login'] = 'LoginController';


$route['ims/publications/get/(:num)'] = 'PublicationController/get/$1';
$route['ims/publications/edit/(:num)'] = 'PublicationController/edit/$1';
$route['ims/publications/update/(:num)'] = 'PublicationController/update/$1';
$route['ims/publications/delete/(:num)'] = 'PublicationController/delete/$1';

$route['ims/dashboards/analytics'] = 'DashboardController/analytics_dashboard';
$route['ims/dashboards/financial'] = 'FinDasController/financial_dashboard';

// DATA ENTRIES
$route['ims/entries/semestertype'] = 'SemesterTypeController/semestertype';
$route['ims/entries/semestertype/edit/(:num)'] = 'SemesterTypeController/edit';

$route['ims/entries/programs'] = 'ProgramsController/programs';
$route['ims/entries/programs/edit/(:num)'] = 'ProgramsController/edit';
$route['ims/entries/programs/prospectus/(:num)'] = 'ProgramsController/prospectus';

$route['ims/entries/subject'] = 'SubjectController/subject';
$route['ims/entries/subject/edit/(:num)'] = 'SubjectController/edit';

$route['ims/entries/department'] = 'DepartmentController/department';
$route['ims/entries/department/edit/(:num)'] = 'DepartmentController/edit';

$route['ims/entries/rooms'] = 'RoomsController/rooms';
$route['ims/entries/rooms/edit/(:num)'] = 'RoomsController/edit';

$route['ims/studentprofile'] = 'StudentProfileController';
$route['ims/studentprofile/create'] = 'StudentProfileController/create';
$route['ims/studentprofile/edit/(:any)'] = 'StudentProfileController/edit';
$route['ims/studentprofile/view/(:any)'] = 'StudentProfileController/view';
$route['ims/studentprofile/update_remarks'] = 'StudentProfileController/update_remarks';
$route['ims/studentprofile/update_student_id'] = 'StudentProfileController/update_student_id';
$route['ims/studentprofile/generate_selected_accounts'] = 'StudentProfileController/generateSelectedAccounts';
$route['ims/studentprofile/count_selected_eligible'] = 'StudentProfileController/countSelectedEligible';

$route['ims/entries/sections'] = 'SectionsController/sections';
$route['ims/entries/sections/edit/(:num)'] = 'SectionsController/edit';

$route['ims/entries/requirements'] = 'RequirementsController';
$route['ims/entries/requirements/edit/(:num)'] = 'RequirementsController/edit';

$route['employee/register'] = 'FacultyprofController/register';
$route['employee/register/save'] = 'FacultyprofController/savePublicFP';
$route['ims/facultyprof/create'] = 'FacultyprofController/create';
$route['ims/facultyprof'] = 'FacultyprofController';
$route['ims/facultyprof/edit/(:any)'] = 'FacultyprofController/edit';
$route['ims/facultyprof/view/(:any)'] = 'FacultyprofController/view';

$route['ims/scheduling'] = 'SchedulingController';
$route['ims/scheduling/create'] = 'SchedulingController/create';
$route['ims/scheduling/edit/(:num)'] = 'SchedulingController/edit';
$route['ims/scheduling/print_room_schedule'] = 'SchedulingController/print_room_schedule';

$route['ims/enrollment'] = 'EnrollmentController';
$route['ims/enrollment/create'] = 'EnrollmentController/create';
$route['ims/enrollment/edit/(:num)'] = 'EnrollmentController/edit';
$route['ims/enrollment/view/(:num)'] = 'EnrollmentController/view';
$route['ims/enrollment/print/(:num)/(:any)'] = 'EnrollmentController/print';
$route['ims/enrollment/printcert/(:num)/(:any)'] = 'EnrollmentController/printcert';
$route['ims/enrollment/printcor/(:num)/(:any)'] = 'EnrollmentController/printcor';
$route['ims/enrollment/printhd/(:num)/(:any)'] = 'EnrollmentController/printhd';


$route['ims/promotionalreport'] = 'PromotionalReportController';
$route['ims/promotionalreport/print'] = 'PromotionalReportController/printView';
$route['ims/promotionalreport/generateexcel'] = 'PromotionalReportController/generateExcel';
$route['ims/promotionalreport/generatepdf'] = 'PromotionalReportController/generatePDF';

$route['ims/enrollment_report'] = 'EnrollmentReportController';
$route['ims/enrollment_report/print'] = 'EnrollmentReportController/printView';
$route['ims/enrollment_report/excel'] = 'EnrollmentReportController/excelView';
$route['ims/enrollment_report/pdf'] = 'EnrollmentReportController/pdfView';

$route['ims/billing'] = 'BillingController';
$route['ims/audittrail'] = 'AuditTrailController/audittrail';

$route['ims/boardpasser'] = 'BoardPasserController/boardpasser';
$route['ims/boardpasser/create'] = 'BoardPasserController/create';
$route['ims/boardpasser/edit/(:num)'] = 'BoardPasserController/edit/$1';
$route['ims/boardpasser/generateexcel'] = 'BoardPasserController/generateExcel';

$route['ims/buildingsfurniture'] = 'BuildingsFurnitureController/buildings_furniture';
$route['ims/buildingsfurniture/create'] = 'BuildingsFurnitureController/create';
$route['ims/buildingsfurniture/edit/(:num)'] = 'BuildingsFurnitureController/edit/$1';
$route['ims/buildingsfurniture/generateexcel'] = 'BuildingsFurnitureController/generateExcel';

$route['ims/fees'] = 'FeesController';
$route['ims/fees/create'] = 'FeesController/create';
$route['ims/fees/edit/(:num)'] = 'FeesController/edit';

$route['ims/statements'] = 'StatementOfAccountController';
$route['ims/statements/view/(:num)'] = 'StatementOfAccountController/view';

$route['ims/cashierbilling'] = 'CashierBillingController';
$route['ims/cashierbilling/payment/(:num)/(:any)'] = 'CashierBillingController/payment';
$route['ims/cashierbilling/edit'] = 'CashierBillingController/edit';
$route['ims/cashierbilling/print/(:num)/(:any)'] = 'CashierBillingController/print_receipt';
$route['ims/cashierbilling/printsoa/(:num)/(:any)'] = 'CashierBillingController/print_soa';

$route['ims/myclass'] = 'MyclassController';
$route['ims/myclass/view/(:any)'] = 'MyclassController/view';

$route['ims/grades'] = 'GradesController';
$route['ims/grades/edit/(:any)'] = 'GradesController/edit';
$route['ims/grades/encodegrades/(:any)'] = 'GradesController/encodegrades';
$route['ims/grades/print/(:num)'] = 'GradesController/print';

$route['ims/grade/rgrades'] = 'RgradesController';
$route['ims/grade/rgrades/edit'] = 'RgradesController/edit';
$route['ims/grade/rgrades/torprint/(:any)'] = 'RgradesController/torprint';
$route['ims/grade/rgrades/semprint/(:any)'] = 'RgradesController/semprint';
$route['ims/grade/rgrades/viewprofile/(:any)'] = 'RgradesController/viewprofile';

$route['ims/grade/tfgrades'] = 'TFgradesController';
$route['ims/grade/tfgrades/create'] = 'TFgradesController/create';
$route['ims/grade/tfgrades/edit/(:any)'] = 'TFgradesController/edit';

$route['ims/websettings'] = 'WebSettingsController';
$route['ims/about'] = 'WebSettingsController/about';

$route['ims/enrollment_report'] = 'EnrollmentReportController';
$route['ims/faculty_report'] = 'FacultyReportController';

$route['ims/graduates'] = 'GraduatesController';
$route['ims/graduates/view/(:any)'] = 'GraduatesController/view';

$route['ims/promotionalreport'] = 'PromotionalReportController';
$route['ims/promotionalreport/print'] = 'PromotionalReportController/printView';


$route['ims/promotional'] = 'PromotionalController';

$route['ims/graduatereports'] = 'GraduateReportsController';




$route['ims/profile'] = 'ProfileController';

$route['ims/facultyevaluation'] = 'FacultyEvaluationController';
$route['ims/facultyevaluation/save'] = 'FacultyEvaluationController/save';


$route['ims/newsandupdates'] = 'NewsAndUpdatesController';
$route['ims/newsandupdates/get/(:num)'] = 'NewsAndUpdatesController/get/$1';
$route['ims/newsandupdates/edit/(:num)'] = 'NewsAndUpdatesController/edit/$1';
$route['ims/newsandupdates/update/(:num)'] = 'NewsAndUpdatesController/update/$1';
$route['ims/newsandupdates/delete/(:num)'] = 'NewsAndUpdatesController/delete/$1';

$route['ims/publications'] = 'PublicationController';
$route['ims/alumni-tracker'] = 'AlumniTrackerController';
$route['ims/alumni-tracker/get/(:num)'] = 'AlumniTrackerController/get/$1';
$route['ims/alumni-tracker/save'] = 'AlumniTrackerController/save';
$route['ims/alumni-tracker/update/(:num)'] = 'AlumniTrackerController/update/$1';
$route['ims/alumni-tracker/delete/(:num)'] = 'AlumniTrackerController/delete/$1';
$route['ims/alumni-tracker/ajax-list'] = 'AlumniTrackerController/ajax_list';

$route['ims/gradingsystem'] = 'GradingSystemController';
$route['ims/gradingsystem/edit/(:any)'] = 'GradingSystemController/edit';
$route['ims/gradingsystem/encodegrades/(:any)'] = 'GradingSystemController/encodegrades';
$route['ims/gradingsystem/saveUpdateForm'] = 'GradingSystemController/saveUpdateForm';
$route['ims/gradingsystem/LoadGradeClass'] = 'GradingSystemController/LoadGradeClass';
$route['ims/gradingsystem/print/(:num)'] = 'GradingSystemController/print';
$route['ims/gradingsystem/saveConfig'] = 'GradingSystemController/saveConfig';


$route['ims/users'] = 'UsersController/users';
$route['ims/users/edit/(:num)'] = 'UsersController/edit';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
