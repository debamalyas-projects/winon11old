/**
 * File : editFaq.js
 * 
 * This file contain the validation of edit faq form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Debamalya Sarker
 */

$(document).ready(function(){
	
	var editFaqForm = $("#editFaq");
	
	var validator = editFaqForm.validate({
		
		rules:{
			question:{ required : true, remote : { url : baseURL + "checkFaqExists", type :"post", data : { id : function(){ return $("#id").val(); } } } },
			answer:{ required : true },
		},
		messages:{
			question :{ required : "This field is required", remote : "Faq already added" },
			answer :{ required : "This field is required" }
		}
	});
});

