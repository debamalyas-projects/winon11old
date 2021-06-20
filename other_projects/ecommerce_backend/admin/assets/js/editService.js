/**
 * File : editService.js
 * 
 * This file contain the validation of edit service form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Debamalya Sarker
 */

$(document).ready(function(){
	
	var editServiceForm = $("#editService");
	
	var validator = editServiceForm.validate({
		
		rules:{
			name :{ required : true, remote : { url : baseURL + "checkServiceExists", type :"post", data : { id : function(){ return $("#id").val(); } } } }
		},
		messages:{
			name :{ required : "This field is required", remote : "Service already added" }
		}
	});
});
