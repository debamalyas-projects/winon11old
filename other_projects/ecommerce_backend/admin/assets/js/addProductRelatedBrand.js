/**
 * File : addProductRelatedBrand.js
 * 
 * This file contain the validation of add product related brand form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Debamalya Sarker
 */

$(document).ready(function(){
	
	var addProductRelatedBrandForm = $("#addProductRelatedBrand");
	
	var validator = addProductRelatedBrandForm.validate({
		
		rules:{
			product_id :{ required : true, remote : { url : baseURL + "checkProductRelatedBrandExists", type :"post", data : { product_id : function(){ return $("#product_id").val(); } } } },
			brand_id :{ required : true},
			
		},
		messages:{
			product_id :{ required : "This field is required", remote : "Vendor Product already added" },
			brand_id :{ required : "This field is required"  },
		}
	});
});
