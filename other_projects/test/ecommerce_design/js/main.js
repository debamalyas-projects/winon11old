$(document).ready(function(){
	
	  $('#nav').slicknav();
	  // $("#header-area").sticky({topSpacing:0})
      $('.bxslider').bxSlider({
		  
		  mode: 'fade',
		  captions:true,
          auto:true
          
		    
      });
      

      
	  
		
		// off canvar Manu js
		$(".manu-trigger").on("click", function(){
			$(".off-canvar-manu, .off-canvar-overlay").addClass("active");
			return false; 
		});
		$(".manu-close, .off-canvar-overlay").on("click", function(){
			$(".off-canvar-manu, .off-canvar-overlay").removeClass("active");
			
		});
    
       

	  $('.service').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:4
        }
    }
})

  $('.latest-info').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000:{
            items:4
        }
    }
})

$('.bestSeller-info').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        900:
        {
            items:3
        },
        1000:{
            items:6
        }
    }
})



$('.child-product').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    autoplay:true,
    autoplayTimeout:2000,
    responsive:{
        0:{
            items:4
        },
        600:{
            items:5
        },
       
        1000:{
            items:8
        }
    }
})

$('.child-promo').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    autoplay:false,
    autoplayTimeout:4000,
    responsive:{
        0:{
            items:1
        },
        500:{
            items:1
        },
        800:{
            items:3
        },
        1000:{
            items:5
        }
    }
})

$('.slide-child-promo').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    autoplay:true,
    autoplayTimeout:4000,
    responsive:{
        0:{
            items:3
        },
        600:{
            items:4
        },
        1000:{
            items:5
        }
    }
})

$('.child-offer').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    autoplay:false,
    autoplayTimeout:1000,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        
        1000:{
            items:3
        }
    }
})


    });

    