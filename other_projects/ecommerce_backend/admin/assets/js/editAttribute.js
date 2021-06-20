/**
 * File : editAttribute.js
 * 
 * This file contain the validation of edit attribute form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Debamalya Sarker
 */

$(document).ready(function(){
	
	var editAttributeForm = $("#editAttribute");
	
	var validator = editAttributeForm.validate({
		
		rules:{
			name :{ required : true, /*remote : { url : baseURL + "checkAttributeExists", type :"post", data : { id : function(){ return $("#id").val(); } } }*/ },
			value :{ required : true }
		},
		messages:{
			name :{ required : "This field is required", /*remote : "Attribute already added" */},
			value :{ required : "This field is required" }
		}
	});
});
