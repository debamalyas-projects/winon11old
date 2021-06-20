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
$route['vendorProductListing/(:num)/(:any)'] = 'vendorProduct/vendorProductListing/$1/$2';
$route['userListing'] = 'user/userListing';
$route['serviceListing'] = 'service/serviceListing';
$route['serviceListing/(:num)'] = 'service/serviceListing/$1';
$route['assetListing'] = 'asset/assetListing';
$route['assetListing/(:num)'] = 'asset/assetListing/$1';
$route['vendorListing'] = 'vendor/vendorListing';
$route['vendorListing/(:num)'] = 'vendor/vendorListing/$1';
$route['faqListing'] = 'faq/faqListing';
$route['faqListing/(:num)'] = 'faq/faqListing/$1';
$route['deliverypersonmanagementListing'] = 'deliverypersonmanagement/deliverypersonmanagementListing';
$route['deliverypersonmanagementListing/(:num)'] = 'deliverypersonmanagement/deliverypersonmanagementListing/$1';
$route['productListing'] = 'product/productListing';
$route['productListing/(:num)'] = 'product/productListing/$1';
$route['customerListing'] = 'customer/customerListing';
$route['customerListing/(:num)'] = 'customer/customerListing/$1';

$route['addNew'] = "user/addNew";
$route['addNewService'] = "service/addNewService";
$route['addNewAsset'] = "asset/addNewAsset";
$route['addNewCustomer'] = "customer/addNewCustomer";
$route['addNewVendor'] = "vendor/addNewVendor";
$route['addNewVendorProduct/(:num)'] = "vendorProduct/addNewVendorProduct/$1";
$route['addNewFaq'] = "faq/addNewFaq";
$route['addNewDeliverypersonmanagement'] = "deliverypersonmanagement/addNewDeliverypersonmanagement";
$route['addNewProduct'] = "product/addNewProduct";
$route['editOld/(:num)'] = "user/editOld/$1";
$route['editServiceOld/(:num)'] = "service/editServiceOld/$1";
$route['editVendorProductOld/(:num)/(:any)'] = "vendorProduct/editVendorProductOld/$1/$2";
$route['editAssetOld/(:num)'] = "asset/editAssetOld/$1";
$route['editCustomerOld/(:num)'] = "customer/editCustomerOld/$1";
$route['editVendorOld/(:num)'] = "vendor/editVendorOld/$1";
$route['editFaqOld/(:num)'] = "faq/editFaqOld/$1";
$route['editDeliverypersonmanagementOld/(:num)'] = "deliverypersonmanagement/editDeliverypersonmanagementOld/$1";
$route['editProductOld/(:num)'] = "product/editProductOld/$1";
$route['editUser'] = "user/editUser";
$route['editService'] = "service/editService";
$route['editVendorProduct'] = "vendorProduct/editVendorProduct";
$route['editAsset'] = "asset/editAsset";
$route['editCustomer'] = "customer/editCustomer";
$route['editVendor'] = "vendor/editVendor";
$route['editFaq'] = "faq/editFaq";
$route['editDeliverypersonmanagement'] = "deliverypersonmanagement/editDeliverypersonmanagement";
$route['editProduct'] = "product/editProduct";
$route['deleteUser'] = "user/deleteUser";
$route['deleteService'] = "service/deleteService";
$route['deleteCustomer'] = "customer/deleteCustomer";
$route['deleteVendor'] = "vendor/deleteVendor";
$route['deleteFaq'] = "faq/deleteFaq";
$route['deleteDeliverypersonmanagement'] = "deliverypersonmanagement/deleteDeliverypersonmanagement";
$route['deleteProduct'] = "product/deleteProduct";
$route['loadChangePass'] = "user/loadChangePass";
$route['changePassword'] = "user/changePassword";
$route['pageNotFound'] = "user/pageNotFound";
$route['checkEmailExists'] = "user/checkEmailExists";
$route['checkServiceExists'] = "service/checkServiceExists";
$route['checkVendorProductExists'] = "vendorProduct/checkVendorProductExists";
$route['checkAssetExists'] = "asset/checkAssetExists";
$route['checkCustomerExists'] = "customer/checkCustomerExists";
$route['checkVendorExists'] = "vendor/checkVendorExists";
$route['checkProductExists'] = "product/checkProductExists";
$route['postProduct'] = "product/postProduct";
$route['postService'] = "service/postService";
$route['postVendorProduct'] = "vendorProduct/postVendorProduct";
$route['postAsset'] = "asset/postAsset";
$route['viewProductOld/(:num)'] = "product/viewProductOld/$1";
$route['viewServiceOld/(:num)'] = "service/viewServiceOld/$1";
$route['viewVendorProductOld/(:num)/(:any)'] = "vendorProduct/viewVendorProductOld/$1/$2";
$route['viewAssetOld/(:num)'] = "asset/viewAssetOld/$1";
$route['changeStatusProduct'] = "product/changeStatusProduct";
$route['changeStatusService'] = "service/changeStatusService";
$route['changeStatusAsset'] = "asset/changeStatusAsset";
$route['checkFaqExists'] = "faq/checkFaqExists";
$route['checkDeliverypersonmanagementExists'] = "deliverypersonmanagement/checkDeliverypersonmanagementExists";
$route['postFaq'] = "faq/postFaq";
$route['postDeliverypersonmanagement'] = "deliverypersonmanagement/postDeliverypersonmanagement";
$route['viewFaqOld/(:num)'] = "faq/viewFaqOld/$1";
$route['viewDeliverypersonmanagementOld/(:num)'] = "deliverypersonmanagement/viewDeliverypersonmanagementOld/$1";
$route['changeStatusFaq'] = "faq/changeStatusFaq";
$route['changeStatusDeliverypersonmanagement'] = "deliverypersonmanagement/changeStatusDeliverypersonmanagement";
$route['postVendor'] = "vendor/postVendor";
$route['viewVendorOld/(:num)'] = "vendor/viewVendorOld/$1";
$route['changeStatusVendor'] = "vendor/changeStatusVendor";
$route['postCustomer'] = "customer/postCustomer";
$route['viewCustomerOld/(:num)'] = "customer/viewCustomerOld/$1";
$route['changeStatusCustomer'] = "customer/changeStatusCustomer";
$route['changeStatusVendorProduct'] = "vendorProduct/changeStatusVendorProduct";

$route['forgotPassword'] = "login/forgotPassword";
$route['resetPasswordUser'] = "login/resetPasswordUser";
$route['resetPasswordConfirmUser'] = "login/resetPasswordConfirmUser";
$route['resetPasswordConfirmUser/(:any)'] = "login/resetPasswordConfirmUser/$1";
$route['resetPasswordConfirmUser/(:any)/(:any)'] = "login/resetPasswordConfirmUser/$1/$2";
$route['createPasswordUser'] = "login/createPasswordUser";

//Template

$route['templateListing'] = 'template/templateListing';
$route['templateListing/(:num)'] = "template/templateListing/$1";
$route['addNewTemplate'] = "template/addNewTemplate";
$route['editTemplateOld/(:num)'] = "template/editTemplateOld/$1";
$route['editTemplate'] = "template/editTemplate";
$route['deleteTemplate'] = "template/deleteTemplate";
$route['checkTemplateExists'] = "template/checkTemplateExists";
$route['postTemplate'] = "template/postTemplate";
$route['viewTemplateOld/(:num)'] = "template/viewTemplateOld/$1";
$route['changeStatusTemplate'] = "template/changeStatusTemplate";

//category

$route['categoryListing'] = 'category/categoryListing';
$route['categoryListing/(:num)'] = "category/categoryListing/$1";
$route['addNewCategory'] = "category/addNewCategory";
$route['editCategoryOld/(:num)'] = "category/editCategoryOld/$1";
$route['editCategory'] = "category/editCategory";
$route['deleteCategory'] = "category/deleteCategory";
$route['checkCategoryExists'] = "category/checkCategoryExists";
$route['postCategory'] = "category/postCategory";
$route['viewCategoryOld/(:num)'] = "category/viewCategoryOld/$1";
$route['changeStatusCategory'] = "category/changeStatusCategory";

//attribute routes
$route['attributeListing'] = 'attribute/attributeListing';
$route['attributeListing/(:num)'] = "attribute/attributeListing/$1";
$route['addNewAttribute'] = "attribute/addNewAttribute";
$route['editAttributeOld/(:num)'] = "attribute/editAttributeOld/$1";
$route['editAttribute'] = "attribute/editAttribute";
$route['deleteAttribute'] = "attribute/deleteAttribute";
$route['checkAttributeExists'] = "attribute/checkAttributeExists";
$route['postAttribute'] = "attribute/postAttribute";
$route['viewAttributeOld/(:num)'] = "attribute/viewAttributeOld/$1";
$route['changeStatusAttribute'] = "attribute/changeStatusAttribute";

//Unit

$route['unitListing'] = 'unit/unitListing';
$route['unitListing/(:num)'] = "unit/unitListing/$1";
$route['addNewUnit'] = "unit/addNewUnit";
$route['editUnitOld/(:num)'] = "unit/editUnitOld/$1";
$route['editUnit'] = "unit/editUnit";
$route['deleteUnit'] = "unit/deleteUnit";
$route['checkUnitExists'] = "unit/checkUnitExists";
$route['postUnit'] = "unit/postUnit";
$route['viewUnitOld/(:num)'] = "unit/viewUnitOld/$1";
$route['changeStatusUnit'] = "unit/changeStatusUnit";

//review routes
$route['reviewListing'] = 'review/reviewListing';
$route['reviewListing/(:num)'] = "review/reviewListing/$1";
$route['addNewReview'] = "review/addNewReview";
$route['editReviewOld/(:num)'] = "review/editReviewOld/$1";
$route['editReview'] = "review/editReview";
$route['deleteReview'] = "review/deleteReview";
$route['checkReviewExists'] = "review/checkReviewExists";
$route['postReview'] = "review/postReview";
$route['viewReviewOld/(:num)'] = "review/viewReviewOld/$1";
$route['changeStatusReview'] = "review/changeStatusReview";

//rating

$route['ratingListing'] = 'rating/ratingListing';
$route['ratingListing/(:num)'] = "rating/ratingListing/$1";
$route['addNewRating'] = "rating/addNewRating";
$route['editRatingOld/(:num)'] = "rating/editRatingOld/$1";
$route['editRating'] = "rating/editRating";
$route['deleteRating'] = "rating/deleteRating";
$route['checkRatingExists'] = "rating/checkRatingExists";
$route['postRating'] = "rating/postRating";
$route['viewRatingOld/(:num)'] = "rating/viewRatingOld/$1";
$route['changeStatusRating'] = "rating/changeStatusRating";

//promotion
$route['promotionListing'] = 'promotion/promotionListing';
$route['promotionListing/(:num)'] = "promotion/promotionListing/$1";
$route['addNewPromotion'] = "promotion/addNewPromotion";
$route['editPromotionOld/(:num)'] = "promotion/editPromotionOld/$1";
$route['editPromotion'] = "promotion/editPromotion";
$route['deletePromotion'] = "promotion/deletePromotion";
$route['checkPromotionExists'] = "promotion/checkPromotionExists";
$route['postPromotion'] = "promotion/postPromotion";
$route['viewPromotionOld/(:num)'] = "promotion/viewPromotionOld/$1";
$route['changeStatusPromotion'] = "promotion/changeStatusPromotion";

//assetlink

$route['assetlinkListing'] = 'assetlink/assetlinkListing';
$route['assetlinkListing/(:num)'] = "assetlink/assetlinkListing/$1";
$route['addNewassetLink'] = "assetlink/addNewassetLink";
$route['editassetLinkOld/(:num)'] = "assetlink/editassetLinkOld/$1";
$route['editassetLink'] = "assetlink/editassetLink";
$route['deleteassetLink'] = "assetlink/deleteassetLink";
$route['checkassetLinkExists'] = "assetlink/checkassetLinkExists";
$route['postassetLink'] = "assetlink/postassetLink";
$route['viewassetLinkOld/(:num)'] = "assetlink/viewassetLinkOld/$1";
$route['changeStatusassetLink'] = "assetlink/changeStatusassetLink";

//content
$route['contentListing'] = 'content/contentListing';
$route['contentListing/(:num)'] = "content/contentListing/$1";
$route['addNewContent'] = "content/addNewContent";
$route['editContentOld/(:num)'] = "content/editContentOld/$1";
$route['editContent'] = "content/editContent";
$route['deleteContent'] = "content/deleteContent";
$route['checkContentExists'] = "content/checkContentExists";
$route['postContent'] = "content/postContent";
$route['viewContentOld/(:num)'] = "content/viewContentOld/$1";
$route['changeStatusContent'] = "content/changeStatusContent";

//brand
$route['brandListing'] = 'brand/brandListing';
$route['brandListing/(:num)'] = "brand/brandListing/$1";
$route['addNewBrand'] = "brand/addNewBrand";
$route['editBrandOld/(:num)'] = "brand/editBrandOld/$1";
$route['editBrand'] = "brand/editBrand";
$route['deleteBrand'] = "brand/deleteBrand";
$route['checkBrandExists'] = "brand/checkBrandExists";
$route['postBrand'] = "brand/postBrand";
$route['viewBrandOld/(:num)'] = "brand/viewBrandOld/$1";
$route['changeStatusBrand'] = "brand/changeStatusBrand";

//productInformation
$route['productInformationListing/(:num)/(:any)'] = 'productInformation/productInformationListing/$1/$2';
$route['productInformationListing/(:num)'] = "productInformation/productInformationListing/$1";
$route['addNewProductInformation/(:num)'] = "productInformation/addNewProductInformation/$1";
$route['editProductInformationOld/(:num)/(:any)'] = "productInformation/editProductInformationOld/$1/$2";
$route['editProductInformation'] = "productInformation/editProductInformation";
$route['checkProductInformationExists'] = "productInformation/checkProductInformationExists";
$route['postProductInformation'] = "productInformation/postProductInformation";
$route['viewProductInformationOld/(:num)/(:any)'] = "productInformation/viewProductInformationOld/$1/$2";
$route['changeStatusProductInformation'] = "productInformation/changeStatusProductInformation";

//Product Realted Brand
$route['productRelatedBrandListing/(:num)/(:any)'] = 'productRelatedBrand/productRelatedBrandListing/$1/$2';
$route['productRelatedBrandListing/(:num)'] = "productRelatedBrand/productRelatedBrandListing/$1";
$route['addNewProductRelatedBrand/(:num)'] = "productRelatedBrand/addNewProductRelatedBrand/$1";
$route['editProductRelatedBrandOld/(:num)/(:any)'] = "productRelatedBrand/editProductRelatedBrandOld/$1/$2";
$route['editProductRelatedBrand'] = "productRelatedBrand/editProductRelatedBrand";
$route['checkProductRelatedBrandExists'] = "productRelatedBrand/checkProductRelatedBrandExists";
$route['postProductRelatedBrand'] = "productRelatedBrand/postProductRelatedBrand";
$route['viewProductRelatedBrandOld/(:num)/(:any)'] = "productRelatedBrand/viewProductRelatedBrandOld/$1/$2";
$route['changeStatusProductRelatedBrand'] = "productRelatedBrand/changeStatusProductRelatedBrand";

//Product Related Category
$route['productRelatedCategoryListing/(:num)/(:any)'] = 'productRelatedCategory/productRelatedCategoryListing/$1/$2';
$route['productRelatedCategoryListing/(:num)'] = "productRelatedCategory/productRelatedCategoryListing/$1";
$route['addNewProductRelatedCategory/(:num)'] = "productRelatedCategory/addNewProductRelatedCategory/$1";
$route['editProductRelatedCategoryOld/(:num)/(:any)'] = "productRelatedCategory/editProductRelatedCategoryOld/$1/$2";
$route['editProductRelatedCategory'] = "productRelatedCategory/editProductRelatedCategory";
$route['checkProductRelatedCategoryExists'] = "productRelatedCategory/checkProductRelatedCategoryExists";
$route['postProductRelatedCategory'] = "productRelatedCategory/postProductRelatedCategory";
$route['viewProductRelatedCategoryOld/(:num)/(:any)'] = "productRelatedCategory/viewProductRelatedCategoryOld/$1/$2";
$route['changeStatusProductRelatedCategory'] = "productRelatedCategory/changeStatusProductRelatedCategory";

//Asset Realted Asset

$route['productRelatedAssetListing/(:num)/(:any)'] = 'productRelatedAsset/productRelatedAssetListing/$1/$2';
$route['productRelatedAssetListing/(:num)'] = "productRelatedAsset/productRelatedAssetListing/$1";
$route['addNewProductRelatedAsset/(:num)'] = "productRelatedAsset/addNewProductRelatedAsset/$1";
$route['editProductRelatedAssetOld/(:num)/(:any)'] = "productRelatedAsset/editProductRelatedAssetOld/$1/$2";
$route['editProductRelatedAsset'] = "productRelatedAsset/editProductRelatedAsset";
$route['checkProductRelatedAssetExists'] = "productRelatedAsset/checkProductRelatedAssetExists";
$route['postProductRelatedAsset'] = "productRelatedAsset/postProductRelatedAsset";
$route['viewProductRelatedAssetOld/(:num)/(:any)'] = "productRelatedAsset/viewProductRelatedAssetOld/$1/$2";
$route['changeStatusProductRelatedAsset'] = "productRelatedAsset/changeStatusProductRelatedAsset";

//Asset link Related Asset Link
$route['productRelatedAssetLinkListing/(:num)/(:any)'] = 'productRelatedAssetLink/productRelatedAssetLinkListing/$1/$2';
$route['productRelatedAssetLinkListing/(:num)'] = "productRelatedAssetLink/productRelatedAssetLinkListing/$1";
$route['addNewProductRelatedAssetLink/(:num)'] = "productRelatedAssetLink/addNewProductRelatedAssetLink/$1";
$route['editProductRelatedAssetLinkOld/(:num)/(:any)'] = "productRelatedAssetLink/editProductRelatedAssetLinkOld/$1/$2";
$route['editProductRelatedAssetLink'] = "productRelatedAssetLink/editProductRelatedAssetLink";
$route['checkProductRelatedAssetLinkExists'] = "productRelatedAssetLink/checkProductRelatedAssetLinkExists";
$route['postProductRelatedAssetLink'] = "productRelatedAssetLink/postProductRelatedAssetLink";
$route['viewProductRelatedAssetLinkOld/(:num)/(:any)'] = "productRelatedAssetLink/viewProductRelatedAssetLinkOld/$1/$2";
$route['changeStatusProductRelatedAssetLink'] = "productRelatedAssetLink/changeStatusProductRelatedAssetLink";

//Add related product
$route['addRelatedProductListing/(:num)/(:any)'] = 'addRelatedProduct/addRelatedProductListing/$1/$2';
$route['addRelatedProductListing/(:num)'] = "addRelatedProduct/addRelatedProductListing/$1";
$route['addNewAddRelatedProduct/(:num)'] = "addRelatedProduct/addNewAddRelatedProduct/$1";
$route['editAddRelatedProductOld/(:num)/(:any)'] = "addRelatedProduct/editAddRelatedProductOld/$1/$2";
$route['editAddRelatedProduct'] = "addRelatedProduct/editAddRelatedProduct";
$route['checkAddRelatedProductExists'] = "addRelatedProduct/checkAddRelatedProductExists";
$route['postAddRelatedProduct'] = "addRelatedProduct/postAddRelatedProduct";
$route['viewAddRelatedProductOld/(:num)/(:any)'] = "addRelatedProduct/viewAddRelatedProductOld/$1/$2";
$route['changeStatusAddRelatedProduct'] = "addRelatedProduct/changeStatusAddRelatedProduct";

//Product Pincode
$route['productPincodeListing/(:num)/(:any)'] = 'productPincode/productPincodeListing/$1/$2';
$route['productPincodeListing/(:num)'] = "productPincode/productPincodeListing/$1";
$route['addNewProductPincode/(:num)'] = "productPincode/addNewProductPincode/$1";
$route['editProductPincodeOld/(:num)/(:any)'] = "productPincode/editProductPincodeOld/$1/$2";
$route['editProductPincode'] = "productPincode/editProductPincode";
$route['checkProductPincodeExists'] = "productPincode/checkProductPincodeExists";
$route['postProductPincode'] = "productPincode/postProductPincode";
$route['viewProductPincodeOld/(:num)/(:any)'] = "productPincode/viewProductPincodeOld/$1/$2";
$route['changeStatusProductPincode'] = "productPincode/changeStatusProductPincode";

//Product Vendor Attribute
$route['productVendorAttributeListing/(:num)/(:num)/(:any)'] = 'productVendorAttribute/productVendorAttributeListing/$1/$2/$3';
$route['productVendorAttributeListing/(:num)'] = "productVendorAttribute/productVendorAttributeListing/$1";
$route['addNewProductVendorAttribute/(:num)/(:num)'] = "productVendorAttribute/addNewProductVendorAttribute/$1/$2";
$route['editProductVendorAttributeOld/(:num)/(:any)'] = "productVendorAttribute/editProductVendorAttributeOld/$1/$2";
$route['editProductVendorAttribute'] = "productVendorAttribute/editProductVendorAttribute";
$route['checkProductVendorAttributeExists'] = "productVendorAttribute/checkProductVendorAttributeExists";
$route['postProductVendorAttribute'] = "productVendorAttribute/postProductVendorAttribute";
$route['viewProductVendorAttributeOld/(:num)/(:any)'] = "productVendorAttribute/viewProductVendorAttributeOld/$1/$2";
$route['changeStatusProductVendorAttribute'] = "productVendorAttribute/changeStatusProductVendorAttribute";

//Product Vendor Unit
$route['productVendorUnitListing/(:num)/(:num)/(:any)'] = 'productVendorUnit/productVendorUnitListing/$1/$2/$3';
$route['productVendorUnitListing/(:num)'] = "productVendorUnit/productVendorUnitListing/$1";
$route['addNewProductVendorUnit/(:num)/(:num)'] = "productVendorUnit/addNewProductVendorUnit/$1/$2";
$route['editProductVendorUnitOld/(:num)/(:any)'] = "productVendorUnit/editProductVendorUnitOld/$1/$2";
$route['editProductVendorUnit'] = "productVendorUnit/editProductVendorUnit";
$route['checkProductVendorUnitExists'] = "productVendorUnit/checkProductVendorUnitExists";
$route['postProductVendorUnit'] = "productVendorUnit/postProductVendorUnit";
$route['viewProductVendorUnitOld/(:num)/(:any)'] = "productVendorUnit/viewProductVendorUnitOld/$1/$2";
$route['changeStatusProductVendorUnit'] = "productVendorUnit/changeStatusProductVendorUnit";