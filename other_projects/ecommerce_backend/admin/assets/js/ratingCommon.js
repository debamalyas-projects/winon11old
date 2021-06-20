/**
 * @author Debamalya Sarker
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
	
	jQuery(document).on("click", ".changeStatusRating", function(){
		var ratingId = $(this).data("ratingid"),
			hitURL = baseURL + "changeStatusRating",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to change the status of this rating ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { id : ratingId } 
			}).done(function(data){
				console.log(data);
				//currentRow.parents('tr').remove();
				if(data.status = true){ 
					alert("Rating status successfully changed"); 
					location.reload();
				}else if(data.status = false){ 
					alert("Rating status change process failed"); 
				}else{ 
					alert("Access denied..!"); 
				}
			});
		}
	});
	
	jQuery(document).on("click", ".searchList", function(){
		
	});
	
});
