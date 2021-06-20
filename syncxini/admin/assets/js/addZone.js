/**
 * File : addZone.js
 * 
 * This file contain the validation of add zone form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Kishor Mali
 */

$(document).ready(function(){
	
	var addZoneForm = $("#addZone");
	
	var validator = addZoneForm.validate({
		
		rules:{
			ZoneName :{ required : true, remote : { url : baseURL + "checkZoneExists", type :"post"} },
			ZoneOrder :{ required : true, digits: true }
		},
		messages:{
			ZoneName :{ required : "This field is required", remote : "Zone already added" },
			ZoneOrder :{ required : "This field is required", digits : "This field is numeric" }
		}
	});
});
