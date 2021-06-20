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
	
	jQuery(document).on("click", ".changeStatusTemplate", function(){
		var templateId = $(this).data("templateid"),
			hitURL = baseURL + "changeStatusTemplate",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to change the status of this template ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { id : templateId } 
			}).done(function(data){
				console.log(data);
				//currentRow.parents('tr').remove();
				if(data.status = true){ 
					alert("Template status successfully changed"); 
					location.reload();
				}else if(data.status = false){ 
					alert("Template status change process failed"); 
				}else{ 
					alert("Access denied..!"); 
				}
			});
		}
	});
	
	jQuery(document).on("click", ".searchList", function(){
		
	});
	
});
