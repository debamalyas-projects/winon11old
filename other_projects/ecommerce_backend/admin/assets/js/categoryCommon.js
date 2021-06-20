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
	
	jQuery(document).on("click", ".changeStatusCategoryt", function(){
		var categoryId = $(this).data("categoryid"),
			hitURL = baseURL + "changeStatuscategory",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to change the status of this category ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { id : categoryId } 
			}).done(function(data){
				console.log(data);
				//currentRow.parents('tr').remove();
				if(data.status = true){ 
					alert("Category status successfully changed"); 
					location.reload();
				}else if(data.status = false){ 
					alert("Category status change process failed"); 
				}else{ 
					alert("Access denied..!"); 
				}
			});
		}
	});
	
	jQuery(document).on("click", ".searchList", function(){
		
	});
	
});
