/**
 * File : editDeliverypersonmanagement.js
 * 
 * This file contain the validation of edit delivery person form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Debmalya Sarkar
 */

$(document).ready(function(){
	
	var editDeliverypersonmanagementForm = $("#editDeliverypersonmanagement");
	
	var validator = editDeliverypersonmanagementForm.validate({
		
		rules:{
			name :{ required : true },
			contact_number :{ required : true },
			email :{ required : true, remote : { url : baseURL + "checkDeliverypersonmanagementExists", type :"post", data : { id : function(){ return $("#id").val(); } } } },
			address :{ required : true }
		},
		messages:{
			name :{ required : "This field is required" },
			contact_number :{ required : "This field is required" },
			email :{ required : "This field is required", remote : "Delivery Person already added"},
			address :{ required : "This field is required"}
		}
	});
});
