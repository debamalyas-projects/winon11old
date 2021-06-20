/**
 * File : addContest.js
 * 
 * This file contain the validation of add contest form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Kishor Mali
 */

$(document).ready(function(){
	
	var addContestForm = $("#addContest");
	
	var validator = addContestForm.validate({
		
		rules:{
			ContestName:{ required : true },
			ContestPrizePool:{ required : true, number: true },
			ContestEntryFees:{ required : true, number: true },
			Zero2CroreMargin:{ required : true, number: true },
			ContestSpotsTotal:{ required : true, digits: true },
			ContestDate:{ required : true },
			PSMCDT:{ required : true },
			ContestAllowMultipleTeams:{ required : true },
			ContestMaximumTeamAllowed:{ required : true, digits: true },
			ContestFinalPrizePool:{ required : true, number: true },
			ContestOpenDateTime:{ required : true },
			ContestCloseDateTime:{ required : true },
			ContestVisibleToAll:{ required : true }
		},
		messages:{
			ContestName:{ required : "This field is required" },
			ContestPrizePool:{ required : "This field is required", number : "This field is numeric" },
			ContestEntryFees:{ required : "This field is required", number : "This field is numeric" },
			Zero2CroreMargin:{ required : "This field is required", number : "This field is numeric" },
			ContestSpotsTotal:{ required : "This field is required", digits : "This field is numeric" },
			ContestDate:{ required : "This field is required" },
			PSMCDT:{ required : "This field is required" },
			ContestAllowMultipleTeams:{ required : "This field is required" },
			ContestMaximumTeamAllowed:{ required : "This field is required", digits : "This field is numeric" },
			ContestFinalPrizePool:{ required : "This field is required", number : "This field is numeric" },
			ContestOpenDateTime:{ required : "This field is required" },
			ContestCloseDateTime:{ required : "This field is required" },
			ContestVisibleToAll:{ required : "This field is required" }
		}
	});
});
