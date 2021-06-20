/**
 * File : addReview.js
 * 
 * This file contain the validation of add review form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Debamalya Sarker
 */

$(document).ready(function(){
	
	var addReviewForm = $("#addReview");
	
	var validator = addReviewForm.validate({
		
		rules:{
			name :{ required : true, /*remote : { url : baseURL + "checkReviewExists", type :"post"} */},
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
