/**
 * File : addRating.js
 * 
 * This file contain the validation of add rating form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Debamalya Sarker
 */

$(document).ready(function(){
	
	var addRatingForm = $("#addRating");
	
	var validator = addRatingForm.validate({
		
		rules:{
			name :{ required : true, /*remote : { url : baseURL + "checkRatingExists", type :"post"} */},
			email :{ required : true },
			contact :{ required : true },
			rating_value :{ required : true}
		},
		messages:{
			name :{ required : "This field is required" },
			email :{ required : "This field is required" },
			contact :{ required : "This field is required" },
			rating_value :{ required : "This field is required",}
		}
	});
});
