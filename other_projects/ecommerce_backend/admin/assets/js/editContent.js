/**
 * File : editContent.js
 * 
 * This file contain the validation of edit content form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Debamalya Sarker
 */

$(document).ready(function(){
	
	var editContentForm = $("#editContent");
	
	var validator = editContentForm.validate({
		
		rules:{
			tag :{ required : true, remote : { url : baseURL + "checkContentExists", type :"post", data : { id : function(){ 
			return $("#id").val(); } } } }
		},
		messages:{
			tag :{ required : "This field is required", remote : "Content with same name alreday exists." }
		}
	});
});
