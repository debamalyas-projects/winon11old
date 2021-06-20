/**
 * File : addCategorymanagement.js
 * 
 * This file contain the validation of add categorymanagement form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Debamalya Sarker
 */

$(document).ready(function(){
	
	var addCategorymanagementForm = $("#addCategorymanagement");
	
	var validator = addCategorymanagementForm.validate({
		
		rules:{
			name :{ required : true, remote : { url : baseURL + "checkCategoryExists", type :"post"} },
			
		},
		messages:{
			name :{ required : "This field is required", remote : "Category already added" },
		}
	});
});
