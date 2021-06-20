/**
 * File : editProductInformation.js
 * 
 * This file contain the validation of edit vendor product form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Debamalya Sarker
 */

$(document).ready(function(){
	
	var editProductInformationForm = $("#editProductInformation");
	
	var validator = editProductInformationForm.validate({
		
		rules:{
			product_id :{ required : true, remote : { url : baseURL + "checkProductInformationExists", type :"post", data : { product_id : function(){ return $("#product_id").val(); }, id : function(){ return $("#id").val(); } } } },
			title :{ required : true},
			description :{ required : true},
		},
		messages:{
			product_id :{ required : "This field is required", remote : "Vendor Product already added" },
			title :{ required : "This field is required"},
			description :{ required : "This field is required"},
			price :{ required : "This field is required"}
		}
	});
});
