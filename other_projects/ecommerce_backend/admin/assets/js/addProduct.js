/**
 * File : addProduct.js
 * 
 * This file contain the validation of add product form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Debamalya Sarker
 */

$(document).ready(function(){
	
	var addProductForm = $("#addProduct");
	
	var validator = addProductForm.validate({
		
		rules:{
			name :{ required : true, remote : { url : baseURL + "checkProductExists", type :"post"} },
			description :{ required : true },
			specification :{ required : true },
			price :{ required : true, number : true },
			discount :{ required : true, number : true }
		},
		messages:{
			name :{ required : "This field is required", remote : "Product already added" },
			description :{ required : "This field is required" },
			specification :{ required : "This field is required" },
			price :{ required : "This field is required", digits : "This field is numeric" },
			discount :{ required : "This field is required", digits : "This field is numeric" }
		}
	});
});
