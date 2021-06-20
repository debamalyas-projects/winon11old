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
	
	jQuery(document).on("click", ".changeStatusAsset", function(){
		var assetId = $(this).data("assetid"),
			hitURL = baseURL + "changeStatusAsset",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to change the status of this asset ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { id : assetId } 
			}).done(function(data){
				console.log(data);
				//currentRow.parents('tr').remove();
				if(data.status = true){ 
					alert("Asset status successfully changed"); 
					location.reload();
				}else if(data.status = false){ 
					alert("Asset status change process failed"); 
				}else{ 
					alert("Access denied..!"); 
				}
			});
		}
	});
	
	jQuery(document).on("click", ".searchList", function(){
		
	});
	
});
