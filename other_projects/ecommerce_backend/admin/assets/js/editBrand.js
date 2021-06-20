/**
 * File : editBrand.js
 * 
 * This file contain the validation of edit brand form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Debamalya Sarker
 */

$(document).ready(function(){
	
	var editBrandForm = $("#editBrand");
	
	var validator = editBrandForm.validate({
		
		rules:{
			name :{ required : true, remote : { url : baseURL + "checkBrandExists", type :"post", data : { id : function(){ return $("#id").val(); } } } }
		},
		messages:{
			name :{ required : "This field is required", remote : "Brand with same name already exists." }
		}
	
	});
});
