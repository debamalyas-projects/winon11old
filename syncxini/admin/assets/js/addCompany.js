/**
 * File : addCompany.js
 * 
 * This file contain the validation of add comapny form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Kishor Mali
 */

$(document).ready(function(){
	
	var addCompanyForm = $("#addCompany");
	
	var validator = addCompanyForm.validate({
		
		rules:{
			CompanyName :{ required : true },
			CompanyCode :{ required : true, remote : { url : baseURL + "checkCompanyExists", type :"post"} },
			InstrumentToken :{ required : true, digits: true },
			ExchangeToken :{ required : true, digits: true },
			InstrumentType :{ required : true },
			Segment :{ required : true },
			Exchange :{ required : true }
		},
		messages:{
			CompanyName :{ required : "This field is required" },
			CompanyCode :{ required : "This field is required", remote : "Company already added" },
			InstrumentToken :{ required : "This field is required", digits : "This field is numeric" },
			ExchangeToken :{ required : "This field is required", digits : "This field is numeric" },
			InstrumentType :{ required : "This field is required" },
			Segment :{ required : "This field is required" },
			Exchange :{ required : "This field is required" }
		}
	});
});
