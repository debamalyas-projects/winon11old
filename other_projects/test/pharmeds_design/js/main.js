$(document).ready(function(){
	
	  $('#nav').slicknav();
	  // $("#header-area").sticky({topSpacing:0})
      $('.bxslider').bxSlider({
		  
		  mode: 'fade',
		  captions:true,
          auto:false
          
		    
      });
      
		// off canvar Manu js
		$(".manu-trigger").on("click", function(){
			$(".off-canvar-manu, .off-canvar-overlay").addClass("active");
			return false; 
		});
		$(".manu-close, .off-canvar-overlay").on("click", function(){
			$(".off-canvar-manu, .off-canvar-overlay").removeClass("active");
			
		});
    
     

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
            items:6
        }
    }
})

$('.offerZone-child').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    autoplay:false,
    autoplayTimeout:4000,
    responsive:{
        0:{
            items:3
        },
        500:{
            items:3
        },
        800:{
            items:3
        },
        1000:{
            items:5
        }
    }
})

$('.lab-child').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    autoplay:false,
    autoplayTimeout:4000,
    responsive:{
        0:{
            items:2
        },
        600:{
            items:4
        },
        1000:{
            items:5
        }
    }
})

$('.ads-child').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    autoplay:true,
    autoplayTimeout:3000,
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

$('.child-popular').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    autoplay:false,
    autoplayTimeout:2000,
    responsive:{
        0:{
            items:3
        },
        600:{
            items:4
        },
       
        1000:{
            items:7
        }
    }
})

$('.child-safe').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    autoplay:false,
    autoplayTimeout:2000,
    responsive:{
        0:{
            items:3
        },
        600:{
            items:4
        },
       
        1000:{
            items:7
        }
    }
})
$('.child-monsoon').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    autoplay:false,
    autoplayTimeout:2000,
    responsive:{
        0:{
            items:3
        },
        600:{
            items:4
        },
       
        1000:{
            items:7
        }
    }
})
$('.child-featured').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    autoplay:false,
    autoplayTimeout:2000,
    responsive:{
        0:{
            items:3
        },
        600:{
            items:4
        },
       
        1000:{
            items:7
        }
    }
})

$('.child-deals').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    autoplay:false,
    autoplayTimeout:2000,
    responsive:{
        0:{
            items:3
        },
        600:{
            items:4
        },
       
        1000:{
            items:7
        }
    }
})

$('.child-trending').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    autoplay:false,
    autoplayTimeout:2000,
    responsive:{
        0:{
            items:3
        },
        600:{
            items:4
        },
       
        1000:{
            items:7
        }
    }
})

$('.ingredients-child').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    autoplay:false,
    autoplayTimeout:2000,
    responsive:{
        0:{
            items:2
        },
        600:{
            items:3
        },
       
        1000:{
            items:5
        }
    }
})

$(function () {
    $.scrollUp({
        scrollName: 'scrollUp',      // Element ID
        scrollDistance: 300,         // Distance from top/bottom before showing element (px)
        scrollFrom: 'top',           // 'top' or 'bottom'
        scrollSpeed: 300,            // Speed back to top (ms)
        easingType: 'linear',        // Scroll to top easing (see http://easings.net/)
        animation: 'fade',           // Fade, slide, none
        animationSpeed: 200,         // Animation speed (ms)
        scrollTrigger: false,        // Set a custom triggering element. Can be an HTML string or jQuery object
        scrollTarget: false,         // Set a custom target element for scrolling to. Can be element or number
        scrollText: false, // Text for element, can contain HTML
        scrollTitle: false,          // Set a custom <a> title if required.
        scrollImg: true,            // Set true to use image
        activeOverlay: false,        // Set CSS color to display scrollUp active point, e.g '#00FFFF'
        zIndex: 2147483647           // Z-Index for the overlay
    });
});

    });

    