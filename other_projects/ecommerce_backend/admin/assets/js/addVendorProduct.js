/**
 * File : addVendorProduct.js
 * 
 * This file contain the validation of add vendor product form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Debamalya Sarker
 */

$(document).ready(function(){
	
	var addVendorProductForm = $("#addVendorProduct");
	
	var validator = addVendorProductForm.validate({
		
		rules:{
			vendor_id :{ required : true, remote : { url : baseURL + "checkVendorProductExists", type :"post", data : { product_id : function(){ return $("#product_id").val(); } } } },
			stock :{ required : true, number : true },
			discount :{ required : true, number : true },
			price :{ required : true, number : true }
		},
		messages:{
			vendor_id :{ required : "This field is required", remote : "Vendor Product already added" },
			stock :{ required : "This field is required", number : "This field is numeric" },
			discount :{ required : "This field is required", number : "This field is numeric" },
			price :{ required : "This field is required", number : "This field is numeric" }
		}
	});
});
