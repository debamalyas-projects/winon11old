/**
 * File : editAsset.js
 * 
 * This file contain the validation of edit asset form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Debamalya Sarker
 */

$(document).ready(function(){
	
	var editAssetForm = $("#editAsset");
	
	var validator = editAssetForm.validate({
		
		rules:{
			name :{ required : true, remote : { url : baseURL + "checkAssetExists", type :"post", data : { id : function(){ return $("#id").val(); } } } }
		},
		messages:{
			name :{ required : "This field is required", remote : "Asset with same name already exists." }
		}
	
	});
});
