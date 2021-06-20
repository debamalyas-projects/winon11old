/**
 * File : editRating.js
 * 
 * This file contain the validation of edit rating form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Debamalya Sarker
 */

$(document).ready(function(){
	
	var editRatingForm = $("#editRating");
	
	var validator = editRatingForm.validate({
		
		rules:{
			name :{ required : true, /*remote : { url : baseURL + "checkRatingExists", type :"post", data : { id : function(){ return $("#id").val(); } } } */},
			email :{ required : true },
			contact :{ required : true },
			rating_value :{ rating_value : true}
		},
		messages:{
			name :{ required : "This field is required" },
			email :{ required : "This field is required" },
			contact :{ required : "This field is required" },
			rating_value :{ rating_value : "This field is required",}
		}
	});
});
