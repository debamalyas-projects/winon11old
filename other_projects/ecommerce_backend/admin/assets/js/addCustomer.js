/**
 * File : addCustomer.js
 * 
 * This file contain the validation of add customer form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Debamalya Sarker
 */

$(document).ready(function(){
	
	var addCustomerForm = $("#addCustomer");
	
	var validator = addCustomerForm.validate({
		
		rules:{
			name :{ required : true },
			shipping_address :{ required : true },
			billing_address :{ required : true },
			contact_number :{ required : true },
			email :{ required : true, remote : { url : baseURL + "checkCustomerExists", type :"post"} }
		},
		messages:{
			name :{ required : "This field is required" },
			shipping_address :{ required : "This field is required" },
			billing_address :{ required : "This field is required" },
			contact_number :{ required : "This field is required" },
			email :{ required : "This field is required", remote : "Customer already added"}
		}
	});
});
