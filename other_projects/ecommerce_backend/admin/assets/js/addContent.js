/**
 * File : addContent.js
 * 
 * This file contain the validation of add content form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Debamalaya sarker
 */

$(document).ready(function(){
	
	var addContentForm = $("#addContent");
	
	var validator = addContentForm.validate({
		
		rules:{
			tag :{ required : true, remote : { url : baseURL + "checkContentExists", type :"post"} }
		},
		messages:{
			tag :{ required : "This field is required", remote : "Content with same name alreday exists."}
		}
	});
});
