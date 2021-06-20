/**
 * File : addVendor.js
 * 
 * This file contain the validation of add vendor form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Debmalya Sarkar
 */

$(document).ready(function(){
	
	var addVendorForm = $("#addVendor");
	
	var validator = addVendorForm.validate({
		
		rules:{
			name :{ required : true },
			address :{ required : true },
			contact_number :{ required : true },
			email :{ required : true, remote : { url : baseURL + "checkVendorExists", type :"post"} }
		},
		messages:{
			name :{ required : "This field is required" },
	        address :{ required : "This field is required" },
            contact_number :{ required : "This field is required" },
		    email  :{ required : "This field is required", remote : "Vendor already added" }
		}
	});
});
