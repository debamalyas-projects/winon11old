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
	
	jQuery(document).on("click", ".changeStatusProduct", function(){
		var productId = $(this).data("productid"),
			hitURL = baseURL + "changeStatusProduct",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to change the status of this product ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { id : productId } 
			}).done(function(data){
				console.log(data);
				//currentRow.parents('tr').remove();
				if(data.status = true){ 
					alert("Product status successfully changed"); 
					location.reload();
				}else if(data.status = false){ 
					alert("Product status change process failed"); 
				}else{ 
					alert("Access denied..!"); 
				}
			});
		}
	});
	
	jQuery(document).on("click", ".changeStatusFaq", function(){
		var faqId = $(this).data("faqid"),
			hitURL = baseURL + "changeStatusFaq",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to change the status of this faq?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { id : faqId } 
			}).done(function(data){
				console.log(data);
				//currentRow.parents('tr').remove();
				if(data.status = true){ 
					alert("Faq status successfully changed"); 
					location.reload();
				}else if(data.status = false){ 
					alert("Faq status change process failed"); 
				}else{ 
					alert("Access denied..!"); 
				}
			});
		}
	});
	
	jQuery(document).on("click", ".changeStatusVendor", function(){
		var vendorId = $(this).data("vendorid"),
			hitURL = baseURL + "changeStatusVendor",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to change the status of this vendor ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { id : vendorId } 
			}).done(function(data){
				console.log(data);
				//currentRow.parents('tr').remove();
				if(data.status = true){ 
					alert("Vendor status successfully changed"); 
					location.reload();
				}else if(data.status = false){ 
					alert("Vendor status change process failed"); 
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
			data : { id : customerId } 
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
	
	jQuery(document).on("click", ".changeStatusDeliverypersonmanagement", function(){
		var deliverypersonmanagementId = $(this).data("deliverypersonid"),
			hitURL = baseURL + "changeStatusDeliverypersonmanagement",
			currentRow = $(this);
			
		var confirmation = confirm("Are you sure to change the status of this Delivery Person ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { id : deliverypersonmanagementId } 
			}).done(function(data){
				console.log(data);
				//currentRow.parents('tr').remove();
				if(data.status = true){ 
					alert("Delivery Person status successfully changed"); 
					location.reload();
				}else if(data.status = false){ 
					alert("Delivery Person status change process failed"); 
				}else{ 
					alert("Access denied..!"); 
				}
			});
		}
	});
	
	jQuery(document).on("click", ".changeStatusService", function(){
		var serviceId = $(this).data("serviceid"),
			hitURL = baseURL + "changeStatusService",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to change the status of this service ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { id : serviceId } 
			}).done(function(data){
				console.log(data);
				//currentRow.parents('tr').remove();
				if(data.status = true){ 
					alert("Service status successfully changed"); 
					location.reload();
				}else if(data.status = false){ 
					alert("Service status change process failed"); 
				}else{ 
					alert("Access denied..!"); 
				}
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
	
	jQuery(document).on("click", ".changeStatusVendorProduct", function(){
		var vendorProductId = $(this).data("vendorproductid"),
			hitURL = baseURL + "changeStatusVendorProduct",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to change the status of this Venodr's product ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { id : vendorProductId } 
			}).done(function(data){
				console.log(data);
				//currentRow.parents('tr').remove();
				if(data.status = true){ 
					alert("Venodr's product status successfully changed"); 
					location.reload();
				}else if(data.status = false){ 
					alert("Venodr's product status change process failed"); 
				}else{ 
					alert("Access denied..!"); 
				}
			});
		}
	});
	
	
	jQuery(document).on("click", ".changeStatusProductInformation", function(){
		var productInformationId = $(this).data("productid"),
			hitURL = baseURL + "changeStatusProductInformation",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to change the status of this Venodr's product ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { id : productInformationId } 
			}).done(function(data){
				console.log(data);
				//currentRow.parents('tr').remove();
				if(data.status = true){ 
					alert("Product information status successfully changed"); 
					location.reload();
				}else if(data.status = false){ 
					alert("Product information status change process failed"); 
				}else{ 
					alert("Access denied..!"); 
				}
			});
		}
	});
	
	jQuery(document).on("click", ".changeStatusProductRelatedBrand", function(){
		var productRelatedBrandId = $(this).data("productid"),
			hitURL = baseURL + "changeStatusProductRelatedBrand",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to change the status of this Venodr's product ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { id : productRelatedBrandId } 
			}).done(function(data){
				console.log(data);
				//currentRow.parents('tr').remove();
				if(data.status = true){ 
					alert("Product information status successfully changed"); 
					location.reload();
				}else if(data.status = false){ 
					alert("Product information status change process failed"); 
				}else{ 
					alert("Access denied..!"); 
				}
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
	
	jQuery(document).on("click", ".changeStatusReview", function(){
		var reviewId = $(this).data("reviewid"),
			hitURL = baseURL + "changeStatusReview",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to change the status of this review ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { id : reviewId } 
			}).done(function(data){
				console.log(data);
				//currentRow.parents('tr').remove();
				if(data.status = true){ 
					alert("Review status successfully changed"); 
					location.reload();
				}else if(data.status = false){ 
					alert("Review status change process failed"); 
				}else{ 
					alert("Access denied..!"); 
				}
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
	
	jQuery(document).on("click", ".changeStatusCategory", function(){
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
	
	jQuery(document).on("click", ".changeStatusAttribute", function(){
		var attributeId = $(this).data("attributeid"),
			hitURL = baseURL + "changeStatusAttribute",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to change the status of this attribute ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { id : attributeId } 
			}).done(function(data){
				console.log(data);
				//currentRow.parents('tr').remove();
				if(data.status = true){ 
					alert("Attribute status successfully changed"); 
					location.reload();
				}else if(data.status = false){ 
					alert("Attribute status change process failed"); 
				}else{ 
					alert("Access denied..!"); 
				}
			});
		}
	});
	jQuery(document).on("click", ".changeStatusPromotion", function(){
		var promotionId = $(this).data("promotionid"),
			hitURL = baseURL + "changeStatusPromotion",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to change the status of this promotion ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { id : promotionId } 
			}).done(function(data){
				console.log(data);
				//currentRow.parents('tr').remove();
				if(data.status = true){ 
					alert("Promotion status successfully changed"); 
					location.reload();
				}else if(data.status = false){ 
					alert("Promotion status change process failed"); 
				}else{ 
					alert("Access denied..!"); 
				}
			});
		}
	});
	
	jQuery(document).on("click", ".changeStatusassetLink", function(){
		var assetlinkId = $(this).data("passetlinkid"),
			hitURL = baseURL + "changeStatusAssetLink",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to change the status of this assetlink ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { id : assetLinkId } 
			}).done(function(data){
				console.log(data);
				//currentRow.parents('tr').remove();
				if(data.status = true){ 
					alert("assetLink status successfully changed"); 
					location.reload();
				}else if(data.status = false){ 
					alert("assetLink status change process failed"); 
				}else{ 
					alert("Access denied..!"); 
				}
			});
		}
	});
	
	jQuery(document).on("click", ".changeStatusContent", function(){
		var contentId = $(this).data("contentid"),
			hitURL = baseURL + "changeStatusContent",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to change the status of this content ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { id : contentId } 
			}).done(function(data){
				console.log(data);
				//currentRow.parents('tr').remove();
				if(data.status = true){ 
					alert("Content status successfully changed"); 
					location.reload();
				}else if(data.status = false){ 
					alert("Content status change process failed"); 
				}else{ 
					alert("Access denied..!"); 
				}
			});
		}
	});
	
	jQuery(document).on("click", ".changeStatusassetLink", function(){
		var assetlinkId = $(this).data("assetlinkid"),
			hitURL = baseURL + "changeStatusassetLink",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to change the status of this assetlink ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { id : assetlinkId } 
			}).done(function(data){
				console.log(data);
				//currentRow.parents('tr').remove();
				if(data.status = true){ 
					alert("assetLink status successfully changed"); 
					location.reload();
				}else if(data.status = false){ 
					alert("assetLink status change process failed"); 
				}else{ 
					alert("Access denied..!"); 
				}
			});
		}
	});
	
	jQuery(document).on("click", ".changeStatusBrand", function(){
		var brandId = $(this).data("brandid"),
			hitURL = baseURL + "changeStatusBrand",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to change the status of this brand ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { id : brandId } 
			}).done(function(data){
				console.log(data);
				//currentRow.parents('tr').remove();
				if(data.status = true){ 
					alert("Brand status successfully changed"); 
					location.reload();
				}else if(data.status = false){ 
					alert("Brand status change process failed"); 
				}else{ 
					alert("Access denied..!"); 
				}
			});
		}
	});
	
	jQuery(document).on("click", ".searchList", function(){
		
	});
	
});
