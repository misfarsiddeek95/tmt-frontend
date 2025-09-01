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
$route['default_controller'] = 'FrontController';
$route['404_override'] = 'FrontController/notFound';
$route['translate_uri_dashes'] = FALSE;

$route['about-us'] = 'FrontController/aboutUs';
$route['anti-fraud-policy'] = 'FrontController/antiFraudPolicy';
$route['privacy-policy'] = 'FrontController/privacyPolicy';
$route['terms-of-use'] = 'FrontController/termsOfUse';
$route['faq'] = 'FrontController/siteFaqs';
$route['contact-us'] = 'FrontController/contactUs';
$route['submit-contact-form'] = 'FrontController/submitContactForm';

$route['get-search-data'] = 'FrontController/getSearchData';
$route['search'] = 'FrontController/accommodation';
$route['filter-list'] = 'FrontController/filterList';
$route['detail'] = 'FrontController/accommodationDetail';

$route['subscribe'] = 'FrontController/subscribeEmail';
$route['sign-up'] = 'FrontController/signUp';
$route['sign-in'] = 'FrontController/signIn';
$route['sign-out'] = 'FrontController/logout';
$route['submit-signup-form'] = 'FrontController/submitSignUp';
$route['submit-signin-form'] = 'FrontController/submitSignIn';

$route['inquiry/main/internet-inquiry'] = 'FrontController/mainInquiry';
$route['load-accom-rooms'] = 'FrontController/loadAccomRooms';
$route['get-specific-detail'] = 'FrontController/getSpecificDetail';
$route['send-main-inquiry'] = 'FrontController/sendMainInquiry';

$route['booking'] = 'FrontController/booking';
$route['calculate-price'] = 'FrontController/calculatePrice';
$route['submit-booking'] = 'FrontController/submitBooking';

$route['copy-price/(:num)/(:num)'] = 'FrontController/copyPrice/$1/$2';

# after login.
$route['add-to-wishlist'] = 'FrontController/addToWishlist';
$route['dashboard'] = 'UserController/index';
$route['my-bookings'] = 'UserController/myBookings';
$route['view-booking'] = 'UserController/viewBooking';
$route['my-wishlist'] = 'UserController/myWishlists';
$route['profile'] = 'UserController/myProfile';
$route['remove-from-wishlist'] = 'UserController/removeFromWhishlist';
$route['update-user-detail'] = 'UserController/updateUserDetail';
$route['upload-avatar'] = 'UserController/uploadAvatar';
$route['remove-avatar'] = 'UserController/removeAvatar';
$route['change-password'] = 'UserController/changePassword';
$route['forgot-password'] = 'FrontController/forgotPassword';
$route['forgot-password/reset-password'] = 'FrontController/resetPasswordPage';
$route['forgot-password/do-reset-password'] = 'FrontController/doResetPassword';