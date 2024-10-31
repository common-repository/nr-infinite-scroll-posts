jQuery(function($){

	$('.post-listing').append( '<span class="load-more"></span>' );
        var nr_load_post_type= $('.post-listing').attr('data-post-type');
        var nr_load_post_per_page= $('.post-listing').attr('data-per-page');

        var nr_load_comments_label= $('.post-listing').attr('data-comments');
        var nr_load_date_label= $('.post-listing').attr('data-date');
        var nr_load_author_label= $('.post-listing').attr('data-author');

	var button = $('.post-listing .load-more');
	var page = 1;
	var loading = false;
	var scrollHandling = {
	    allow: true,
	    reallow: function() {
	        scrollHandling.allow = true;
	    },
	    delay: 400 //(milliseconds) adjust to the highest acceptable value
	};
		var data = {
				action: 'nr_infinite_more',				
				page: 1,
				post_type: nr_load_post_type,
				posts_per_page : nr_load_post_per_page,
				is_comments_label : nr_load_comments_label,
				is_author_label : nr_load_author_label,
				is_date_label : nr_load_date_label,
				
			};
			$.post(nrObj.url, data, function(res) {
				if( res.success) {
					$('.post-listing').append( res.data );
					$('.post-listing').append( button );
					page = page + 1;
					loading = false;
				} else {
					// console.log(res);
				}
			}).fail(function(xhr, textStatus, e) {
				// console.log(xhr.responseText);
			});

	$(window).scroll(function(){
		if( ! loading && scrollHandling.allow ) {
			scrollHandling.allow = false;
			setTimeout(scrollHandling.reallow, scrollHandling.delay);
			var offset = $(button).offset().top - $(window).scrollTop();
			if( 2000 > offset ) {
				loading = true;
				var data = {
					action: 'nr_infinite_more',				
					page: page,	
					post_type: nr_load_post_type,
					posts_per_page : nr_load_post_per_page,
					is_comments_label : nr_load_comments_label,
					is_author_label : nr_load_author_label,
					is_date_label : nr_load_date_label,			
				};
				$.post(nrObj.url, data, function(res) {
					if( res.success) {
						$('.post-listing').append( res.data );
						$('.post-listing').append( button );
						page = page + 1;
						loading = false;
					} else {
						// console.log(res);
					}
				}).fail(function(xhr, textStatus, e) {
					// console.log(xhr.responseText);
				});

			}
		}
	});
});
