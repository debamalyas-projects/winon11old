/**
 * File : addService.js
 * 
 * This file contain the validation of add service form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Debamalaya sarker
 */

$(document).ready(function(){
	
	var addServiceForm = $("#addService");
	
	var validator = addServiceForm.validate({
		
		rules:{
			name :{ required : true, remote : { url : baseURL + "checkServiceExists", type :"post"} }
		},
		messages:{
			name :{ required : "This field is required", remote : "Service already added" }
		}
	});
});
