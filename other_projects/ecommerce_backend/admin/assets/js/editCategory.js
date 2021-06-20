/**
 * File : editCategorymanagement.js
 * 
 * This file contain the validation of edit categorymanagement form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Debamalya Sarker
 */

$(document).ready(function(){
	
	var editCategorymanagementForm = $("#editCategorymanagement");
	
	var validator = editCategorymanagementForm.validate({
		
		rules:{
			name :{ required : true, remote : { url : baseURL + "checkCategoryExists", type :"post", data : { id : function(){ return $("#id").val(); } } } },

		},
		messages:{
			name :{ required : "This field is required", remote : "Category already added" },
		}
	});
});
