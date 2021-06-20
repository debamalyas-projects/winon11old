/**
 * File : editZone.js
 * 
 * This file contain the validation of edit zone form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Kishor Mali
 */

$(document).ready(function(){
	
	var editZoneForm = $("#editZone");
	
	var validator = editZoneForm.validate({
		
		rules:{
			ZoneName :{ required : true, remote : { url : baseURL + "checkZoneExists", type :"post", data : { ID : function(){ return $("#ID").val(); } } } },
			ZoneOrder :{ required : true, digits: true }
		},
		messages:{
			ZoneName :{ required : "This field is required", remote : "Zone already added" },
			ZoneOrder :{ required : "This field is required", digits : "This field is numeric" }
		}
	});
});
