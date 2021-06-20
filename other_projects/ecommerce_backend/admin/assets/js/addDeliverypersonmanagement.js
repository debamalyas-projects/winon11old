/**
 * File : addDeliverypersonmanagement.js
 * 
 * This file contain the validation of add delivery person management form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Soumen
 */

$(document).ready(function(){
	
	var addDeliverypersonmanagementForm = $("#addDeliverypersonmanagement");
	
	var validator = addDeliverypersonmanagementForm.validate({
		
		rules:{
			name :{ required : true },
			contact_number :{ required : true },
			email :{ required : true, remote : { url : baseURL + "checkDeliverypersonmanagementExists", type :"post"} },
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
