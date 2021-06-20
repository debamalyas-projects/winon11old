/**
 * File : addAttribute.js
 * 
 * This file contain the validation of add attribute form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Debamalya Sarker
 */

$(document).ready(function(){
	
	var addAttributeForm = $("#addAttribute");
	
	var validator = addAttributeForm.validate({
		
		rules:{
			name :{ required : true, /*remote : { url : baseURL + "checkAttributeExists", type :"post"} */},
			value :{ required : true }
		},
		messages:{
			name :{ required : "This field is required", /*remote : "Attribute already added" */},
			value :{ required : "This field is required" }
		}
	});
});
