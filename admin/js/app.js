var config = window.config = {};

// Config reference element
var $ref = $("#ref");

// Configure responsive bootstrap toolkit
config.ResponsiveBootstrapToolkitVisibilityDivs = {
    'xs': $('<div class="device-xs 				  hidden-sm-up"></div>'),
    'sm': $('<div class="device-sm hidden-xs-down hidden-md-up"></div>'),
    'md': $('<div class="device-md hidden-sm-down hidden-lg-up"></div>'),
    'lg': $('<div class="device-lg hidden-md-down hidden-xl-up"></div>'),
    'xl': $('<div class="device-xl hidden-lg-down			  "></div>'),
};

ResponsiveBootstrapToolkit.use('Custom', config.ResponsiveBootstrapToolkitVisibilityDivs);

//validation configuration
config.validations = {
	debug: true,
	errorClass:'has-error',
	validClass:'success',
	errorElement:"span",

	// add error class
	highlight: function(element, errorClass, validClass) {
		$(element).parents("div.form-group")
		.addClass(errorClass)
		.removeClass(validClass); 
	}, 

	// add error class
	unhighlight: function(element, errorClass, validClass) {
		$(element).parents(".has-error")
		.removeClass(errorClass)
		.addClass(validClass); 
	},

	// submit handler
    submitHandler: function(form) {
        form.submit();
    }
}

//delay time configuration
config.delayTime = 50;

// chart configurations
config.chart = {};

config.chart.colorPrimary = tinycolor($ref.find(".chart .color-primary").css("color"));
config.chart.colorSecondary = tinycolor($ref.find(".chart .color-secondary").css("color"));
/***********************************************
*        Animation Settings
***********************************************/
function animate(options) {
	var animationName = "animated " + options.name;
	var animationEnd = "webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend";
	$(options.selector)
	.addClass(animationName)
	.one(animationEnd, 
		function(){
			$(this).removeClass(animationName);
		}
	);
}

$(function() {
	var $itemActions = $(".item-actions-dropdown");

	$(document).on('click',function(e) {
		if (!$(e.target).closest('.item-actions-dropdown').length) {
			$itemActions.removeClass('active');
		}
	});
	
	$('.item-actions-toggle-btn').on('click',function(e){
		e.preventDefault();

		var $thisActionList = $(this).closest('.item-actions-dropdown');

		$itemActions.not($thisActionList).removeClass('active');

		$thisActionList.toggleClass('active');	
	});
});

/***********************************************
*        NProgress Settings
***********************************************/
var npSettings = { 
	easing: 'ease', 
	speed: 500 
}

NProgress.configure(npSettings);
$(function() {
	setSameHeights();

	var resizeTimer;

	$(window).resize(function() {
		clearTimeout(resizeTimer);
        resizeTimer = setTimeout(setSameHeights, 150);
	});
});


function setSameHeights($container) {

	$container = $container || $('.sameheight-container');

	var viewport = ResponsiveBootstrapToolkit.current();

	$container.each(function() {

		var $items = $(this).find(".sameheight-item");

		// Get max height of items in container
		var maxHeight = 0;

		$items.each(function() {
			$(this).css({height: 'auto'});
			maxHeight = Math.max(maxHeight, $(this).innerHeight());
		});


		// Set heights of items
		$items.each(function() {
			// Ignored viewports for item
			var excludedStr = $(this).data('exclude') || '';
			var excluded = excludedStr.split(',');

			// Set height of element if it's not excluded on 
			if (excluded.indexOf(viewport) === -1) {
				$(this).innerHeight(maxHeight);
			}
		});
	});
}

$(function() {
	animate({
		name: 'flipInY',
		selector: '.error-card > .error-title-block'
	});


	setTimeout(function(){
		var $el = $('.error-card > .error-container');

		animate({
			name: 'fadeInUp',
			selector: $el 
		});

		$el.addClass('visible');
	}, 1000);
})
//LoginForm validation
$(function() {
	if (!$('#login-form').length) {
        return false;
    }

    var loginValidationSettings = {
	    rules: {
	        username: {
	            required: true,
	            email: true
	        },
	        password: "required",
	        agree: "required"
	    },
	    messages: {
	        username: {
	            required: "Please enter username",
	            email: "Please enter a valid email address"
	        },
	        password:  "Please enter password",
	        agree: "Please accept our policy"
	    },
	    invalidHandler: function() {
			animate({
				name: 'shake',
				selector: '.auth-container > .card'
			});
		}
	}

	$.extend(loginValidationSettings, config.validations);

    $('#login-form').validate(loginValidationSettings);
})
//SignupForm validation

$(function() {

	$(".wyswyg").each(function() {

		var $editor = $(this).find(".editor");
		var $toolbar = $(this).find(".toolbar");

		var editor = new Quill($editor.get(0), {
			theme: 'snow',
			// modules: {
			// 	toolbar: toolbarOptions
			// }
			modules: {
				toolbar: $toolbar.get(0)
			}
		});

		


	});

});

$(function () {

	$('#sidebar-menu, #customize-menu').metisMenu({
		activeClass: 'open'
	});


	$('#sidebar-collapse-btn').on('click', function(event){
		event.preventDefault();
		
		$("#app").toggleClass("sidebar-open");
	});

	$("#sidebar-overlay").on('click', function() {
		$("#app").removeClass("sidebar-open");
	});

	if ($.browser.mobile) {
		var $appContainer = $('#app ');
		var $mobileHandle = $('#sidebar-mobile-menu-handle ');

		$mobileHandle.swipe({
			swipeLeft: function() {
				if($appContainer.hasClass("sidebar-open")) {
					$appContainer.removeClass("sidebar-open");	
				}
			},
			swipeRight: function() {
				if(!$appContainer.hasClass("sidebar-open")) {
					$appContainer.addClass("sidebar-open");
				}
			},
			// excludedElements: "button, input, select, textarea, .noSwipe, table", 
			triggerOnTouchEnd: false
		});
	}
	
});


$(function() {
	

	function drawDashboardItemsListSparklines(){
		$(".dashboard-page .items .sparkline").each(function() {
			var type = $(this).data('type');

			// There is predefined data
			if ($(this).data('data')) {
				var data = $(this).data('data').split(',').map(function(item) {
					if (item.indexOf(":") > 0) {
						return item.split(":");
					}
					else {
						return item;
					}
				});
			}
			// Generate random data
			else {
				var data = [];
				for (var i = 0; i < 17; i++) {
					data.push(Math.round(100 * Math.random()));
				}
			}


			$(this).sparkline(data, {
				barColor: config.chart.colorPrimary.toString(),
				height: $(this).height(),
				type: type
			});
		});
	}

	drawDashboardItemsListSparklines();

	$(document).on("themechange", function(){
        drawDashboardItemsListSparklines();
    });
});




$(function() {

	$('.actions-list > li').on('click', '.check', function(e){
		e.preventDefault();

		$(this).parents('.tasks-item')
		.find('.checkbox')
		.prop("checked",  true);

		removeActionList();
	});

});
$(function(){

	// set sortable options
	var sortable = new Sortable($('.images-container').get(0), {
		animation: 150,
		handle: ".control-btn.move",
		draggable: ".image-container",
		onMove: function (evt) {
			var $relatedElem = $(evt.related);

	        if ($relatedElem.hasClass('add-image')) {
	        	return false;
	        }
	    }
	});


	$controlsButtons = $('.controls');

	$controlsButtonsStar = $controlsButtons.find('.star');
	$controlsButtonsRemove = $controlsButtons.find('.remove');

	$controlsButtonsStar.on('click',function(e){
		e.preventDefault();

		$controlsButtonsStar.removeClass('active');
		$controlsButtonsStar.parents('.image-container').removeClass('main');

		$(this).addClass('active');

		$(this).parents('.image-container').addClass('main');
	})

})

$(function() {

    if (!$('#select-all-items').length) {
        return false;
    }


    $('#select-all-items').on('change', function() {
        var $this = $(this).children(':checkbox').get(0);    

        $(this).parents('li')
            .siblings()
            .find(':checkbox')
            .prop('checked', $this.checked)
            .val($this.checked)
            .change();
    });


    function drawItemsListSparklines(){
        $(".items-list-page .sparkline").each(function() {
            var type = $(this).data('type');

            // Generate random data
            var data = [];
            for (var i = 0; i < 17; i++) {
                data.push(Math.round(100 * Math.random()));
            }

            $(this).sparkline(data, {
                barColor: config.chart.colorPrimary.toString(),
                height: $(this).height(),
                type: type
            });
        });
    }

    drawItemsListSparklines();

    $(document).on("themechange", function(){
        drawItemsListSparklines();
    });

});



$(function() {

	$("body").addClass("loaded");

});


/***********************************************
*        NProgress Settings
***********************************************/

// start load bar
NProgress.start();

// end loading bar 
NProgress.done();