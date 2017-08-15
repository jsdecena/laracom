$(document).ready(function() {
      
	$.fn.menumaker = function(options) {
      
    var cssmenu = $(this), settings = $.extend({
        title: "Menu",
        format: "dropdown",
        sticky: false
      }, options);

      return this.each(function() {
		
		cssmenu.prepend('<div id="menu-button"><i class="fa fa-bars" aria-hidden="true"></i>' + settings.title + '</div>');
		$(this).find("#menu-button").on('click', function(){
		  $(this).toggleClass('menu-opened');
		  var mainmenu = $(this).next('ul');
		  if (mainmenu.hasClass('open')) { 
			mainmenu.slideUp().removeClass('open');
		  }
		  else {
			mainmenu.slideDown().addClass('open');
			if (settings.format === "dropdown") {
			  mainmenu.find('ul').slideDown();
			}
		  }
		});
		
		cssmenu.find('li ul').parent().addClass('has-sub');

		multiTg = function() {
		  cssmenu.find(".has-sub").prepend('<span class="submenu-button"></span>');
		  cssmenu.find('.submenu-button').on('click', function() {
			$(this).toggleClass('submenu-opened');
			if ($(this).siblings('ul').hasClass('open')) {
			  $(this).siblings('ul').removeClass('open').slideUp();
			}
			else {
			  $(this).siblings('ul').addClass('open').slideDown();
			}
		  });
		};

		if (settings.format === 'multitoggle') multiTg();
		else cssmenu.addClass('dropdown');
		
		
      });
	};
	
	$(".navy").menumaker({
		title: "Navigation",
		format: "multitoggle"
	});
	
	
	$(".navytwo").menumaker({
		title: "Charter School Topics",
		format: "multitoggle"
	});
});
$(document).ready(function(){
$('.right_sidebar aside:last-child .content-left-top-section-box ').addClass('no_pad_nav');
$('.sidebar_pan aside:last-child .content-left-top-section-box ').addClass('no_pad_nav');

function navShowHide()
{
	if($(window).width()>767)
	{
		$('.nav').children('ul').css('display','block');
	}
	else
	{
		$('.nav').children('ul').css('display','none');
	}
}

navShowHide();

$(window).resize(function(e) {
    navShowHide();
});
});