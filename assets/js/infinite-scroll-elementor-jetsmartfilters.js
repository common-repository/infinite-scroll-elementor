/**
 * Infinite Scroll Elementor jetsmartfilters js
 *
 * @since 1.0.0
 */
(function($) {
	'use strict';
	jQuery(document).ready(function($) {
		$(window).load(function() {
			
			var nextSelector       = selector['nextSelector'];
			var navigationSelector = selector['navigationSelector'];
			var contentSelector    = selector['contentSelector'];
			var itemSelector       = selector['itemSelector'];
			var imageRatio         = selector['imageRatio'];
			var animationTime      = parseInt(selector['animationTime']);
			var bottomOffset       = parseInt(selector['bottomOffset']);
			var trigger            = selector['event'];
			var destUrl            = $(nextSelector).attr('href');
			var destUrlInit        = $(nextSelector).attr('href'); // Save for Jetsmartfilters reset
			var paginationType     = selector['paginationType']; // Jetsmartfilters has 2 variations of pagination paths
			var url                = window.location.href; // Used for Jetsmartfilters pagination path
			var finished           = false;
			var flag               = true; // Disable scroll load
			
			var nextInit = $(navigationSelector).find(nextSelector); // Check if navigation exists on page load
						
			if (nextInit.length !== 0) {
				flag = false; // Enable scroll load
			    $(selector['loadMore']).show();			
			}
			else {
				$(selector['finishText']).show();
			}
	
			$(selector['loadMore'] + ' a').css('cursor', 'pointer'); // If button "Link" input is empty
			    					
			if ('click' == trigger) {
				load_on_click();
			} 
			else {
				load_on_scroll();
			}

			function salfe_load_more() {
				$.ajax({		
					url: destUrl,
					beforeSend: function() {
						
						$(selector['loadingImage']).show(); // Show loading image
						flag = true; // Disable scroll load for now				
					},
					success: function(results) {

						$(selector['loadingImage']).hide(); // Hide loading image
						
						setTimeout(function() {
						    flag = false; // Enable scroll load again
						}, 500);

						var obj  = $(results);
						var elem = obj.find(itemSelector);
						var next = obj.find(nextSelector);				

						if (next.length !== 0) {			
						    $(nextSelector).attr('href', next.attr('href'));					
						}

						elem.each(function() {					
							$(itemSelector)
								.last()
								.after($(this).animate({opacity:0}, 0).animate({opacity:1}, animationTime));
							if ('yes' == imageRatio) {
							    // If is missing elementor-fit-height class on more load, which gives the post thumbnail image ratio
							    $('.elementor-post__thumbnail').addClass('elementor-fit-height');
							}
						});
						
						if (next.length !== 0) {					
                            destUrl = $(nextSelector).attr('href');
						}
						else {				
							finished = true; // Disable scroll load
							$(selector['loadMore']).hide();
							$(selector['finishText']).show();
						}
					},
					error: function(results) {

					}		
				});
			}

			function load_on_scroll() {
				$(window).on('scroll', function() {	
					
					var t    = $(this),
					    elem = $(document);

					if (typeof elem == 'undefined') {
						return;
					}

					if (
						flag === false &&
						!finished && 
						t.scrollTop() + bottomOffset >= 
						    elem.height() - t.height()
					) {
						salfe_load_more();
					}
					
				});
			}

			function load_on_click() {
				$('body').on('click', selector['loadMore'] + ' a', function(e) {	
					e.preventDefault(); // If button "Link" input is not empty
					salfe_load_more();			
				});
			}
			
            $(document).on('jet-filter-loaded', function($scope, JetSmartFilters, provider, query, queryID) {
				
				var next = $(navigationSelector).find(nextSelector);
				
				if (next.length !== 0) {
					
				    var filter = $.param(queryID);
								
				    if ('' === filter) {  // If no filters are selected or have been reset
					    destUrl = destUrlInit;
				    }
				    else if ('product-page' === paginationType) {	// Elementor Pro Products
						destUrl = url + '?jet-smart-filters=' + query + '/default&' + filter + '&product-page=2';
				    }
				    else { // Elementor Pro Archive, Elementor Pro Posts and Elementor Pro Archive Products
						destUrl = url + 'page/2/' + '?jet-smart-filters=' + query + '/default&' + filter;
				    }
				
					flag = false; // Enable scroll load
					$(selector['loadMore']).show();
					$(selector['finishText']).hide();				
				}
				else {
					flag = true; // Disable scroll load
					$(selector['loadMore']).hide();
				}
							
            });	
					
		});
	});	
})(jQuery);
