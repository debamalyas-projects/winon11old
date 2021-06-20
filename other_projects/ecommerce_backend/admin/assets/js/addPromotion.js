/**
 * File : addPromotion.js
 * 
 * This file contain the validation of add promotion form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Debamalya Sarker
 */

$(document).ready(function(){
	
	var addPromotionForm = $("#addPromotion");
	
	var validator = addPromotionForm.validate({
		
		rules:{
			subject :{ required : true, /*remote : { url : baseURL + "checkPromotionExists", type :"post"} */},
			content :{ required : true }
		},
		messages:{
			subject :{ required : "This field is required", /*remote : "Promotion already added" */},
			content :{ required : "This field is required" }
		}
	});
});
