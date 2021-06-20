/**
 * File : editTemplate.js
 * 
 * This file contain the validation of edit template form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Debamalya Sarker
 */

$(document).ready(function(){
	
	var editTemplateForm = $("#editTemplate");
	
	var validator = editTemplateForm.validate({
		
		rules:{
			name :{ required : true, remote : { url : baseURL + "checkTemplateExists", type :"post", data : { id : function(){ 
			return $("#id").val(); } } } }
		},
		messages:{
			name :{ required : "This field is required", remote : "Template with same name alreday exists." }
		}
	});
});
