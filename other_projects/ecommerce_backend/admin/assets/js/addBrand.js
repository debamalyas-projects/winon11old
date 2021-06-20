/**
 * File : addBrand.js
 * 
 * This file contain the validation of add brand form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Debamalaya sarker
 */

$(document).ready(function(){
	
	var addBrandForm = $("#addBrand");
	
	var validator = addBrandForm.validate({
		
		rules:{
			name :{ required : true, remote : { url : baseURL + "checkBrandExists", type :"post"} }
		},
		messages:{
			name :{ required : "This field is required", remote : "Brand with same name already exists." }
		}
	});
});
