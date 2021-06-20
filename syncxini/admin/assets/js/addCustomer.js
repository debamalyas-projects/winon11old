/**
 * File : addCustomer.js
 * 
 * This file contain the validation of add customer form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Kishor Mali
 */

$(document).ready(function(){
	
	var addCustomerForm = $("#addCustomer");
	
	var validator = addCustomerForm.validate({
		
		rules:{
			FirstName :{ required : true },
			LastName :{ required : true },
			MobileNumber :{ required : true, remote : { url : baseURL + "checkCustomerExists", type :"post"} },
			EmailAddress :{ required : true, remote : { url : baseURL + "checkCustomerExists", type :"post"} },
			PanNumber :{ required : true, remote : { url : baseURL + "checkCustomerExists", type :"post"} },
			AadharNumber :{ required : true, remote : { url : baseURL + "checkCustomerExists", type :"post"} },
			Password :{ required : true },
			ConfirmPassword : {required : true, equalTo: "#Password"}
		},
		messages:{
			FirstName :{ required : "This field is required" },
			LastName :{ required : "This field is required" },
			MobileNumber :{ required : "This field is required", remote : "Customer with this mobile number already added" },
			EmailAddress :{ required : "This field is required", remote : "Customer with this email address already added" },
			PanNumber :{ required : "This field is required", remote : "Customer with this pan number already added" },
			AadharNumber :{ required : "This field is required", remote : "Customer with this aadhar number already added" },
			ConfirmPassword : {required : "This field is required", equalTo: "Please enter same password" }
		}
	});
});
