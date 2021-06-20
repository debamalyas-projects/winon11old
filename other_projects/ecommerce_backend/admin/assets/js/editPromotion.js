/**
 * File : editPromotion.js
 * 
 * This file contain the validation of edit promotion form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Debamalya Sarker
 */

$(document).ready(function(){
	
	var editPromotionForm = $("#editPromotion");
	
	var validator = editPromotionForm.validate({
		
		rules:{
			subject :{ required : true, /*remote : { url : baseURL + "checkPromotionExists", type :"post", data : { id : function(){ return $("#id").val(); } } }*/ },
			content :{ required : true }
		},
		messages:{
			subject :{ required : "This field is required", /*remote : "Promotion already added" */},
			content :{ required : "This field is required" }
		}
	});
});
