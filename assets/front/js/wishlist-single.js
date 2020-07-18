jQuery(document).ready(function($) {
	
	
	// Wishlist Copy //
	// ===== //
	
	$(document).on('click', ".pickplugins_wl_button_copy", function() {
		
		wishlist_id = $(this).attr( 'wishlist_id' );
		
		if( typeof wishlist_id === "undefined" || wishlist_id.length == 0 ) return;
		
		__HTML__ = $(this).html();
		$(this).html("Copying...");
		
		$.ajax(
			{
		type: 'POST',
		context: this,
		url:wishlist_single_js.ajaxurl,
		data: {
			"action"		: "pickplugins_wl_ajax_wishlist_copy",
			"wishlist_id" 	: wishlist_id,
		},
		success: function( data ) {
			
			$(this).html( __HTML__ );
			window.location.replace( data );
		}
			});
		
	})
	
	
	
	// Share Wishlist //
	// ===== //
	
	
	
	
	
	// Vote Action //
	// ===== //
	$(document).on('click', ".wl_vote_confirm", function() {
		
		if( $(this).hasClass('wl_vote_up') ) vote_type = "vote_up";
		else if( $(this).hasClass('wl_vote_down') ) vote_type = "vote_down";
		else vote_type = "";
		
		user_id 	= $(this).parent().attr( 'user_id' );
		wishlist_id = $(this).parent().attr( 'wishlist_id' );
		
		if( typeof user_id === "undefined" || user_id.length == 0 ) return;
		if( typeof wishlist_id === "undefined" || wishlist_id.length == 0 ) return;
		if( vote_type.length == 0 ) return;
		
		$.ajax(
			{
		type: 'POST',
		context: this,
		url:wishlist_single_js.ajaxurl,
		data: {
			"action"		: "pickplugins_wl_ajax_update_vote",
			"wishlist_id" 	: wishlist_id,
			"vote_type"		: vote_type,
		},
		success: function(response) {
			
			data = JSON.parse( response );
			
			$(this).parent().find('.wl_vote_up_count').html( data['vote_up'] );
			$(this).parent().find('.wl_vote_down_count').html( data['vote_down'] );
		}
			});
	})
	
	
	
	// Update wishlist views //
	// ===== //

	$(document).on('pickplugins_wl_set_views', function(event, wishlist_id) {
		
		if( typeof wishlist_id === "undefined" || wishlist_id.length == 0 || wishlist_id == 0 ) return; 
		
		pickplugins_wl_views_counted 	= localStorage.getItem( 'pickplugins_wl_views_counted' );
		views_counted_array 			= JSON.parse( pickplugins_wl_views_counted );
		
		if( typeof views_counted_array === "undefined" || views_counted_array == null ) views_counted_array = [];
		if( views_counted_array.indexOf( wishlist_id ) !== -1 ) return;
		
		$.ajax(
			{
		type: 'POST',
		context: this,
		url:wishlist_single_js.ajaxurl,
		data: {
			"action"		: "pickplugins_wl_ajax_set_views",
			"wishlist_id" 	: wishlist_id,
		},
		success: function(data) {
			
			console.log( data );
			
			views_counted_array.push( wishlist_id );
			localStorage.setItem( 'pickplugins_wl_views_counted',  JSON.stringify( views_counted_array ) );
		}
			});
	})
	
	
	

	
	
	
	$(document).on('click', ".wishlist_editing .button_delete", function() {


		confirm = $(this).attr('confirm');
		confirmText = $(this).attr('confirmText');

		if(confirm=='yes'){
			console.log(confirm);

			wishlist_id		= $(this).attr('wishlist_id');

			if( typeof wishlist_id === "undefined" || wishlist_id.length == 0 ) return;

			__HTML__ = $(this).html();
			$(this).html("Deleting...");

			$.ajax(
				{
					type: 'POST',
					context: this,
					url:wishlist_single_js.ajaxurl,
					data: {
						"action"		: "pickplugins_wl_ajax_update_wishlist",
						"pickplugins_wl_action" 	: "delete",
						"wishlist_id" 	: wishlist_id,
					},
					success: function(data) {

						window.location.replace( data );
					}

				});


		}else{
			$(this).attr('confirm', 'yes');
			$(this).html(confirmText);

		}


	})
	
	

	
	
	
	// Popup Edit Screen //
	// ===== //

	$(document).on('click', ".popup_edit .pickplugins_wl_popup_save", function() {
		
		wishlist_id		= $('.popup_edit').attr('wishlist_id');
		wishlist_title 	= $('.popup_edit .pickplugins_wl_wishlist_title').val();
		wishlist_sd 	= $('.popup_edit .pickplugins_wl_wishlist_sd').val();
		wishlist_status = $('.popup_edit .wishlist_status').val();

		if( typeof wishlist_id === "undefined" || wishlist_id.length == 0 ) return;
		if( typeof wishlist_title === "undefined" || wishlist_title.length == 0 ) return;
		
		__HTML__ = $(this).html();
		$(this).html("<i class='fa fa-cog fa-spin' ></i> Saving...");
		
		$.ajax(
			{
		type: 'POST',
		context: this,
		url:wishlist_single_js.ajaxurl,
		data: {
			"action"				: "pickplugins_wl_ajax_update_wishlist",
			"pickplugins_wl_action"	: "update",
			"wishlist_id" 			: wishlist_id,
			"wishlist_title"		: wishlist_title,
			"wishlist_sd"			: wishlist_sd,
			"wishlist_status"		: wishlist_status,
		},
		success: function(data) {
			
			if( data.length != 0 )  window.location.replace( data );
		}
			});
	})
	
	
	
	$(document).on('click', ".wishlist_editing .button_edit", function() {

	    console.log('Hello');

		$('.popup_edit').fadeIn();
	})
	
	
	
	$(document).on('click', ".popup_edit .popup_cancel", function() {
		$('.popup_edit').fadeOut();
	})
	
	


});


