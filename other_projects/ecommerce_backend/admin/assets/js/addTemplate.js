/**
 * File : addTemplate.js
 * 
 * This file contain the validation of add template form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Debamalaya sarker
 */

$(document).ready(function(){
	
	var addTemplateForm = $("#addTemplate");
	
	var validator = addTemplateForm.validate({
		
		rules:{
			name :{ required : true, remote : { url : baseURL + "checkTemplateExists", type :"post"} }
		},
		messages:{
			name :{ required : "This field is required", remote : "Template with same name alreday exists."}
		}
	});
});
