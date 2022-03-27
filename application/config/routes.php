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
$route['default_controller'] = 'wamistart';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['frontend/contact-form-submit'] = 'frontend/ajaxController/contactform';
// Api calls
$route['frontend/api/checkphnoexist']='frontend/apiController/checkphnoexist';
$route['frontend/api/checkotp']='frontend/apiController/checkotp';
$route['frontend/api/getBrands']='frontend/apiController/getBrands';
$route['frontend/api/getCategories']='frontend/apiController/getCategories';
$route['frontend/api/getBrandbyCategories']='frontend/apiController/getBrandbyCategories';
$route['frontend/api/getProducts']='frontend/apiController/getProducts';
$route['frontend/api/getProductDetail']='frontend/apiController/getProductDetail';
$route['frontend/api/getProductDetailMilk']='frontend/apiController/getProductDetailMilk';
$route['frontend/api/getProductsBycategory']='frontend/apiController/getProductsBycategory';

$route['frontend/api/add_to_cart']='frontend/apiController/add_to_cart';
$route['frontend/api/getCartDetails']='frontend/apiController/getCartDetails';
$route['frontend/api/getOrders']='frontend/apiController/getOrders';
$route['frontend/api/addUserAddress']='frontend/apiController/addUserAddress';
$route['frontend/api/editUserAddress']='frontend/apiController/editUserAddress';
$route['frontend/api/getAllUserAddresses']='frontend/apiController/getAllUserAddresses';
$route['frontend/api/getMasterCatgeories']='frontend/apiController/getMasterCatgeories';
$route['frontend/api/getProductsByMasterCatgeory']='frontend/apiController/getProductsByMasterCatgeory';
$route['frontend/api/getMasterCatgeoryProducts']='frontend/apiController/getMasterCatgeoryProducts';
$route['frontend/api/getAddressbyId']='frontend/apiController/getAddressbyId';
$route['frontend/api/deleteAddressbyId']='frontend/apiController/deleteAddressbyId';
$route['frontend/api/getProductsByMasterSubcategory']='frontend/apiController/getProductsByMasterSubcategory';
$route['frontend/api/update_cart']='frontend/apiController/update_cart';
$route['frontend/api/delete_cart']='frontend/apiController/delete_cart';
$route['frontend/api/getBanners']='frontend/apiController/getBanners';
$route['frontend/api/getSubcategories']='frontend/apiController/getSubcategories';
$route['frontend/api/getSubscriptionbrands']='frontend/apiController/getSubscriptionbrands';
$route['frontend/api/getSubscriptionBybrands']='frontend/apiController/getSubscriptionBybrands';
$route['frontend/api/getProductByPriceRange']='frontend/apiController/getProductByPriceRange';
$route['frontend/api/getProductByBrandsandcat']='frontend/apiController/getProductByBrandsandcat';
$route['frontend/api/getProductsBysubcat']='frontend/apiController/getProductsBysubcat';
$route['frontend/api/getcurMonthweekdays']='frontend/apiController/getcurMonthweekdays';
$route['frontend/api/showscheduler']='frontend/apiController/showscheduler';
$route['frontend/api/sortProductsbypopularity']='frontend/apiController/sortProductsbypopularity';
$route['frontend/api/getSubscriptiontotalamnt']='frontend/apiController/getSubscriptiontotalamnt';
$route['frontend/api/filterProducts']='frontend/apiController/filterProducts';
$route['frontend/api/saveSubscriptionOrder']='frontend/apiController/saveSubscriptionOrder';
$route['frontend/api/one_time_order_products']='frontend/apiController/one_time_order_products';
$route['frontend/api/storeOrder']='frontend/apiController/storeOrder';
$route['frontend/api/getOrderdetails']='frontend/apiController/getOrderdetails';
$route['frontend/api/cancelOrder']='frontend/apiController/cancelOrder';
$route['frontend/api/helpFaq']='frontend/apiController/helpFaq';
$route['frontend/api/scheduledates']='frontend/apiController/scheduledates';
$route['frontend/api/saveSubscribeOrderinstock']='frontend/apiController/saveSubscribeOrderinstock';
$route['frontend/api/mySubscription']='frontend/apiController/mySubscription';
$route['frontend/api/storeOrderFromMysubscribe']='frontend/apiController/storeOrderFromMysubscribe';
$route['frontend/api/orderHistory']='frontend/apiController/orderHistory';
$route['frontend/api/updateProfileInfo']='frontend/apiController/updateProfileInfo';
$route['frontend/api/getProductsSearch']='frontend/apiController/getProductsSearch';
$route['frontend/api/getProductsSearchDetail']='frontend/apiController/getProductsSearchDetail';
$route['frontend/api/getUserCredents']='frontend/apiController/getUserCredents';
$route['frontend/api/uploadfile']='frontend/apiController/uploadfile';
$route['frontend/api/online_hdfc/(:any)']='frontend/apiController/online_hdfc/$1';
$route['frontend/api/payment_submit']='frontend/apiController/payment_submit';
$route['payment/status']='frontend/apiController/status';
$route['frontend/api/getOrderStatus']='frontend/apiController/getOrderStatus';
$route['frontend/api/myTotaljarbuy']='frontend/apiController/myTotaljarbuy';
$route['frontend/api/checkzipcode']='frontend/apiController/checkzipcode';
$route['frontend/api/update_device_post']='frontend/apiController/update_device_post';
$route['frontend/api/getBanners_section_two']='frontend/apiController/getBanners_section_two';
$route['frontend/api/getBanners_section_three']='frontend/apiController/getBanners_section_three';
$route['frontend/api/scheduletimes_per_date']='frontend/apiController/scheduletimes_per_date';
$route['frontend/api/getJarstock']='frontend/apiController/getJarstock';

/** Delivery App **/
$route['delivery/api/checkphnoexist']='delivery/apiController/checkphnoexist';
$route['delivery/api/checkotp']='delivery/apiController/checkotp';
$route['delivery/api/getAllOrders']='delivery/apiController/getAllOrders';
$route['delivery/api/getOrderdetails']='delivery/apiController/getOrderdetails';
$route['delivery/api/viewOrderTypesdetail']='delivery/apiController/viewOrderTypesdetail';
$route['delivery/api/confirmDelivery']='delivery/apiController/confirmDelivery';
$route['delivery/api/deliveryStatus']='delivery/apiController/deliveryStatus';

/** Backend Area Admin Control**/
$route['admincontrol']='backend/auth/loginController';
$route['admincontrol/logincheck']='backend/auth/loginController/logincheck';
$route['admincontrol/logout']='backend/auth/loginController/logout';
$route['admincontrol/forget-password']='backend/auth/loginController/forgetpassword';
$route['admincontrol/forgotpassemail']='backend/auth/loginController/sendemailforgetpassword';
$route['admincontrol/reset-password']='backend/auth/loginController/resetpassword';
$route['admincontrol/reset-password-update']='backend/auth/loginController/resetpassupdate';
$route['admincontrol/dashboardadmin']='backend/auth/dashboardadmin';
$route['admincontrol/dashboardadmin/(:any)']='backend/auth/dashboardadmin/customFunctions';
$route['admincontrol/dashboardadmin/(:any)/(:any)']='backend/auth/dashboardadmin/Fourparamfunctions';

/** Logistics **/
$route['logisticpanel']='backend/logistics/logisticloginController';
$route['logisticpanel/logincheck']='backend/logistics/logisticloginController/logincheck';
$route['logisticpanel/logout']='backend/logistics/logisticloginController/logout';
$route['logisticpanel/logisticdashboardadmin']='backend/logistics/logisticdashboardadmin';
$route['logisticpanel/logisticdashboardadmin/(:any)']='backend/logistics/logisticdashboardadmin/customFunctions';
$route['logisticpanel/logisticdashboardadmin/(:any)/(:any)']='backend/logistics/logisticdashboardadmin/Fourparamfunctions';
$route['logisticpanel/forget-password']='backend/logistics/logisticloginController/forgetpassword';
$route['logisticpanel/forgotpassemail']='backend/logistics/logisticloginController/sendemailforgetpassword';
$route['logisticpanel/reset-password']='backend/logistics/logisticloginController/resetpassword';
$route['logisticpanel/reset-password-update']='backend/logistics/logisticloginController/resetpassupdate';

/** Frontend **/
$route['privacy-policy']='frontend/ajaxController/privacy';
$route['terms-conditions']='frontend/ajaxController/termsconditions';
$route['cookie']='frontend/ajaxController/cookie';
