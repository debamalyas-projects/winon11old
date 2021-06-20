/**
 * File : editassetLink.js
 * 
 * This file contain the validation of edit assetlink form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Debamalya Sarker
 */

$(document).ready(function(){
	
	var editassetLinkForm = $("#editassetLink");
	
	var validator = editassetLinkForm.validate({
		
		rules:{
			name :{ required : true, /*remote : { url : baseURL + "checkassetLinkExists", type :"post", data : { id : function(){ return $("#id").val(); } } }*/ },
			link :{ required : true }
		},
		messages:{
			name :{ required : "This field is required", /*remote : "assetLink already added" */},
			link :{ required : "This field is required" }
		}
	});
});
