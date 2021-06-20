/**
 * File : addFaq.js
 * 
 * This file contain the validation of add faq form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Debamalya Sarker
 */

$(document).ready(function(){
	
	var addFaqForm = $("#addFaq");
	
	var validator = addFaqForm.validate({
		
		rules:{
			question:{ required : true, remote : { url : baseURL + "checkFaqExists", type :"post"} },
			answer:{ required : true },
		},
		messages:{
			question :{ required : "This field is required", remote : "Faq already added" },
			answer :{ required : "This field is required" }
		}
	});
});
