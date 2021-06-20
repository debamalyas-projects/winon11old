/**
 * File : editReview.js
 * 
 * This file contain the validation of edit review form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Debamalya Sarker
 */

$(document).ready(function(){
	
	var editReviewForm = $("#editReview");
	
	var validator = editReviewForm.validate({
		
		rules:{
			name :{ required : true, /*remote : { url : baseURL + "checkReviewExists", type :"post", data : { id : function(){ return $("#id").val(); } } } */},
			email :{ required : true },
			contact :{ required : true },
			message :{ required : true}
		},
		messages:{
			name :{ required : "This field is required" },
			email :{ required : "This field is required" },
			contact :{ required : "This field is required" },
			message :{ required : "This field is required",}
		}
	});
});
