/**
 * @author Kishor Mali
 */


jQuery(document).ready(function(){
	
	jQuery(document).on("click", ".deleteUser", function(){
		var userId = $(this).data("userid"),
			hitURL = baseURL + "deleteUser",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this user ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { userId : userId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("User successfully deleted"); }
				else if(data.status = false) { alert("User deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	
	jQuery(document).on("click", ".changeStatusCompany", function(){
		var companyId = $(this).data("companyid"),
			hitURL = baseURL + "changeStatusCompany",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to change the status of this company ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { companyId : companyId } 
			}).done(function(data){
				console.log(data);
				//currentRow.parents('tr').remove();
				if(data.status = true){ 
					alert("Company status successfully changed"); 
					location.reload();
				}else if(data.status = false){ 
					alert("Company status change process failed"); 
				}else{ 
					alert("Access denied..!"); 
				}
			});
		}
	});
	
	jQuery(document).on("click", ".changeStatusZone", function(){
		var zoneId = $(this).data("zoneid"),
			hitURL = baseURL + "changeStatusZone",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to change the status of this zone ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { zoneId : zoneId } 
			}).done(function(data){
				console.log(data);
				//currentRow.parents('tr').remove();
				if(data.status = true){ 
					alert("Zone status successfully changed"); 
					location.reload();
				}else if(data.status = false){ 
					alert("Zone status change process failed"); 
				}else{ 
					alert("Access denied..!"); 
				}
			});
		}
	});
	
	jQuery(document).on("click", ".changeStatusCustomer", function(){
		var customerId = $(this).data("customerid"),
			hitURL = baseURL + "changeStatusCustomer",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to change the status of this customer ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { customerId : customerId } 
			}).done(function(data){
				console.log(data);
				//currentRow.parents('tr').remove();
				if(data.status = true){ 
					alert("Customer status successfully changed"); 
					location.reload();
				}else if(data.status = false){ 
					alert("Customer status change process failed"); 
				}else{ 
					alert("Access denied..!"); 
				}
			});
		}
	});
	
	jQuery(document).on("click", ".changeStatusContest", function(){
		var contestId = $(this).data("contestid"),
			hitURL = baseURL + "changeStatusContest",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to change the status of this contest ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { contestId : contestId } 
			}).done(function(data){
				console.log(data);
				//currentRow.parents('tr').remove();
				if(data.status = true){ 
					alert("Contest status successfully changed"); 
					location.reload();
				}else if(data.status = false){ 
					alert("Contest status change process failed"); 
				}else{ 
					alert("Access denied..!"); 
				}
			});
		}
	});
	
	
	jQuery(document).on("click", ".searchList", function(){
		
	});
	
});
