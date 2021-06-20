/**
 * File : addassetLink.js
 * 
 * This file contain the validation of add assetlink form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Debamalya Sarker
 */

$(document).ready(function(){
	
	var addassetLinkForm = $("#addassetLink");
	
	var validator = addassetLinkForm.validate({
		
		rules:{
			name :{ required : true, /*remote : { url : baseURL + "checkassetLinkExists", type :"post"} */},
			link :{ required : true, /*remote : { url : baseURL + "checkassetLinkExists", type :"post"} */},
		},
		messages:{
			name :{ required : "This field is required", /*remote : "assetLink already added" */},
			link :{ required : true, /*remote : { url : baseURL + "checkassetLinkExists", type :"post"} */},
		}
	});
});
