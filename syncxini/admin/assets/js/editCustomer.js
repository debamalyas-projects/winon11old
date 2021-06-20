/**
 * File : editCustomer.js
 * 
 * This file contain the validation of edit customer form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Kishor Mali
 */

$(document).ready(function(){
	
	var editCustomerForm = $("#editCustomer");
	
	var validator = editCustomerForm.validate({
		
		rules:{
			FirstName :{ required : true },
			LastName :{ required : true },
			PanNumber :{ required : true, remote : { url : baseURL + "checkCustomerExists", type :"post", data : { ID : function(){ return $("#ID").val(); } } } },
			AadharNumber :{ required : true, remote : { url : baseURL + "checkCustomerExists", type :"post", data : { ID : function(){ return $("#ID").val(); } } }
		},
		messages:{
			FirstName :{ required : "This field is required" },
			LastName :{ required : "This field is required" },
			PanNumber :{ required : "This field is required", remote : "Customer with this pan number already added" },
			AadharNumber :{ required : "This field is required", remote : "Customer with this aadhar number already added" }
		}
	});
});
