/**
 * File : addAsset.js
 * 
 * This file contain the validation of add asset form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Debamalaya sarker
 */

$(document).ready(function(){
	
	var addAssetForm = $("#addAsset");
	
	var validator = addAssetForm.validate({
		
		rules:{
			name :{ required : true, remote : { url : baseURL + "checkAssetExists", type :"post"} }
		},
		messages:{
			name :{ required : "This field is required", remote : "Asset with same name already exists." }
		}
	});
});
