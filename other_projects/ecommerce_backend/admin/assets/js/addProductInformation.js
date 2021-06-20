/**
 * File : addProductInformation.js
 * 
 * This file contain the validation of add product information form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Debamalya Sarker
 */

$(document).ready(function(){
	
	var addProductInformationForm = $("#addProductInformation");
	
	var validator = addProductInformationForm.validate({
		
		rules:{
			product_id :{ required : true, remote : { url : baseURL + "checkProductInformationExists", type :"post", data : { product_id : function(){ return $("#product_id").val(); } } } },
			title :{ required : true},
			description :{ required : true, }
			
		},
		messages:{
			product_id :{ required : "This field is required", remote : "Vendor Product already added" },
			title :{ required : "This field is required"  },
			description :{ required : "This field is required"}
		}
	});
});
