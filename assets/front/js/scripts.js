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
		url:pickplugins_wl_ajax.pickplugins_wl_ajaxurl,
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
		url:pickplugins_wl_ajax.pickplugins_wl_ajaxurl,
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
		url:pickplugins_wl_ajax.pickplugins_wl_ajaxurl,
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
	
	
	
	// Popup Delete Screen //
	// ===== //

	$(document).on('click', ".pickplugins_wl_popup_delete .pickplugins_wl_popup_delete_confirm", function() {
		
		wishlist_id		= $('.pickplugins_wl_popup_delete').attr('wishlist_id');
		
		if( typeof wishlist_id === "undefined" || wishlist_id.length == 0 ) return;

		__HTML__ = $(this).html();
		$(this).html("Deleting...");
		
		$.ajax(
			{
		type: 'POST',
		context: this,
		url:pickplugins_wl_ajax.pickplugins_wl_ajaxurl,
		data: {
			"action"		: "pickplugins_wl_ajax_update_wishlist",
			"pickplugins_wl_action" 	: "delete",
			"wishlist_id" 	: wishlist_id,
		},
		success: function(data) {
			
			window.location.replace( data );
		}
			});
	})
	
	
	
	$(document).on('click', ".pickplugins_wl_editing .pickplugins_wl_button_delete", function() {
		$('.pickplugins_wl_popup_delete').fadeIn();
	})
	
	
	
	$(document).on('click', ".pickplugins_wl_popup_delete .pickplugins_wl_popup_cancel", function() {
		$('.pickplugins_wl_popup_delete').fadeOut();
	})
	
	
	
	// Popup Edit Screen //
	// ===== //

	$(document).on('click', ".pickplugins_wl_popup_edit .pickplugins_wl_popup_save", function() {
		
		wishlist_id		= $('.pickplugins_wl_popup_edit').attr('wishlist_id');
		wishlist_title 	= $('.pickplugins_wl_popup_edit .pickplugins_wl_wishlist_title').val();
		wishlist_sd 	= $('.pickplugins_wl_popup_edit .pickplugins_wl_wishlist_sd').val();
		wishlist_status = $('.pickplugins_wl_popup_edit .pickplugins_wl_wishlist_status').val();
		wishlist_tags 	= $('.pickplugins_wl_popup_edit .pickplugins_wl_wishlist_tags').val();
		
		if( typeof wishlist_id === "undefined" || wishlist_id.length == 0 ) return;
		if( typeof wishlist_title === "undefined" || wishlist_title.length == 0 ) return;
		
		__HTML__ = $(this).html();
		$(this).html("<i class='fa fa-cog fa-spin' ></i> Saving...");
		
		$.ajax(
			{
		type: 'POST',
		context: this,
		url:pickplugins_wl_ajax.pickplugins_wl_ajaxurl,
		data: {
			"action"				: "pickplugins_wl_ajax_update_wishlist",
			"pickplugins_wl_action"	: "update",
			"wishlist_id" 			: wishlist_id,
			"wishlist_title"		: wishlist_title,
			"wishlist_sd"			: wishlist_sd,
			"wishlist_status"		: wishlist_status,
			"wishlist_tags"			: wishlist_tags,
		},
		success: function(data) {
			
			if( data.length != 0 )  window.location.replace( data );
		}
			});
	})
	
	
	
	$(document).on('click', ".pickplugins_wl_editing .pickplugins_wl_button_edit", function() {
		$('.pickplugins_wl_popup_edit').fadeIn();
	})
	
	
	
	$(document).on('click', ".pickplugins_wl_popup_edit .pickplugins_wl_popup_cancel", function() {
		$('.pickplugins_wl_popup_edit').fadeOut();
	})
	
	
	
	// Saved in Wishlist from Top Heart Icon Item //
	// ===== //
	$(document).on('click', ".pickplugins_wl_wishlist_buttons .pickplugins_wl_wishlist_save", function() {
		
		pickplugins_wl_action = $(this).hasClass( 'pickplugins_wl_saved' ) ? 'remove_from_wishlist' : 'add_in_wishlist';
		
		item_id = $(this).parent().attr( 'item_id' );
		wishlist_id = $(this).attr( 'wishlist_id' );
		
		if( typeof item_id === "undefined" || item_id.length == 0 ) return;
		if( typeof wishlist_id === "undefined" || wishlist_id.length == 0 ) return;

		$(this).children('.pickplugins_wl_wishlist_save_icon').html("<i class='fa fa-cog fa-spin' ></i>");
		//$(this).children('.pickplugins_wl_wishlist_save_icon').html("<i class='fa fa-cog fa-spin' ></i>");


		$.ajax(
			{
		type: 'POST',
		context: this,
		url:pickplugins_wl_ajax.pickplugins_wl_ajaxurl,
		data: {
			"action" 		: "pickplugins_wl_ajax_add_remove_item_on_wishlist",
			"pickplugins_wl_action" 	: pickplugins_wl_action,
			"item_id" 	: item_id,
			"wishlist_id" 	: wishlist_id,
		},
		success: function(response) {
			var data = JSON.parse( response );

			status = data['status'];
			count = data['count'];

			//console.log( status );
			//console.log( count );

			$(this).children('.pickplugins_wl_wishlist_save_icon').html("<i class='fa fa-heart' ></i>");
			$(this).parent().children('.pickplugins_wl_item_count').text(count);


			if( status == 'removed' ) {
				
				$( '.pickplugins_wl_wishlist_save_' + item_id ).removeClass( 'pickplugins_wl_saved' );
				$(this).removeClass( 'pickplugins_wl_saved' );

			}
			
			if( status == 'added' ) {
				
				$( '.pickplugins_wl_wishlist_save_' + item_id ).addClass( 'pickplugins_wl_saved' );
				$(this).addClass( 'pickplugins_wl_saved' );

			}
			
		}
			});
			
	})
	
	
	
	// Saved in Wishlist from Menu Item //
	// ===== //
	$(document).on('click', ".pickplugins_wl_wishlist_buttons .pickplugins_wl_menu_items .pickplugins_wl_menu_item", function() {
		
		if( $(this).hasClass( 'pickplugins_wl_add_new' ) ) return;
		
		pickplugins_wl_action = $(this).hasClass( 'pickplugins_wl_saved' ) ? 'remove_from_wishlist' : 'add_in_wishlist';
		
		item_id = $(this).parent().attr( 'item_id' );
		wishlist_id = $(this).attr( 'wishlist' );
		
		if( typeof item_id === "undefined" || item_id.length == 0 ) return;
		if( typeof wishlist_id === "undefined" || wishlist_id.length == 0 ) return;

		//$(this).children('i').toggleClass('fa-cog fa-heart');
		$(this).children('i').toggleClass('fa-pulse');

		
		$.ajax(
			{
		type: 'POST',
		context: this,
		url:pickplugins_wl_ajax.pickplugins_wl_ajaxurl,
		data: {
			"action" 		: "pickplugins_wl_ajax_add_remove_item_on_wishlist",
			"pickplugins_wl_action" 	: pickplugins_wl_action,
			"item_id" 	: item_id,
			"wishlist_id" 	: wishlist_id,
		},
		success: function(response) {

			var data = JSON.parse( response );

			status = data['status'];
			count = data['count'];

			console.log(count);

			$(this).parent().parent().parent().children('.pickplugins_wl_item_count').text(count);
			//$(this).children('i').toggleClass('fa-heart fa-cog');
			$(this).children('i').toggleClass('fa-pulse');

			if( status == 'removed' ) {
				
				$(this).removeClass( 'pickplugins_wl_saved' );
				pickplugins_wl_stll_saved = false;
				
				$(this).parent().find('.pickplugins_wl_menu_item').each(function( index ) {
					if( $( this ).hasClass('pickplugins_wl_saved') ) pickplugins_wl_stll_saved = true;
				});

				if( ! pickplugins_wl_stll_saved ) $( '.pickplugins_wl_wishlist_save_' + item_id ).removeClass( 'pickplugins_wl_saved' );
				
			}
			
			if( status == 'added' ) {
				
				$( '.pickplugins_wl_wishlist_save_' + item_id ).addClass( 'pickplugins_wl_saved' );
				$(this).addClass( 'pickplugins_wl_saved' );
			}
			
		}
			});

		
	})
	
	
	
	// Create Wishlist from Popup and Saved from there //
	// ===== //
	$(document).on('click', ".pickplugins_wl_quick_add_wishlist_container .pickplugins_wl_button_save", function() {

		wishlist_name 	= $('.pickplugins_wl_quick_add_wishlist_container .wishlist_name').val();
		item_id 		= $('.pickplugins_wl_quick_add_wishlist_container .item_id').val();

		if( typeof item_id === "undefined" || item_id.length == 0 ) return;
		if( typeof wishlist_name === "undefined" || wishlist_name.length == 0 ) return;

		__HTML__ = $(this).html();
		$(this).html("<i class='fa fa-cog fa-spin' ></i> Saving...");

		$.ajax(
			{
		type: 'POST',
		context: this,
		url:pickplugins_wl_ajax.pickplugins_wl_ajaxurl,
		data: {
			"action" 		: "pickplugins_wl_ajax_create_save_wishlist",
			"wishlist_name" : wishlist_name,
			"item_id" 	: item_id,
		},
		success: function(data) {


			
			if( data.length == 0 ){
				
				$( '.pickplugins_wl_wishlist_save_' + item_id ).addClass( 'pickplugins_wl_saved' );
			
				$(this).html( __HTML__ );
				$('.pickplugins_wl_quick_add_wishlist_container').fadeOut();
                $('.pickplugins_wl_quick_add_wishlist_container .wishlist_name').val("");
			}
		}
			});

	})

	
	
	// Close Wishlist creation popup box //
	// ===== //
	$(document).on('click', ".pickplugins_wl_quick_add_wishlist_container .pickplugins_wl_button_cancel", function() {

		$('.pickplugins_wl_quick_add_wishlist_container .item_id').val("");
		$('.pickplugins_wl_quick_add_wishlist_container').fadeOut();
	})

	
	
	// Clicked on Add new wishlist from Menu items //
	// ===== //
	$(document).on('click', ".pickplugins_wl_wishlist_buttons .pickplugins_wl_menu_items .pickplugins_wl_add_new", function() {

		item_id = $(this).parent().attr( 'item_id' );

		if( typeof item_id === "undefined" || item_id.length == 0 ) return;

		$('.pickplugins_wl_quick_add_wishlist_container .item_id').val( item_id );
		$('.pickplugins_wl_wishlist_buttons .pickplugins_wl_menu_items').fadeOut();
		$('.pickplugins_wl_quick_add_wishlist_container').fadeIn();
	})



	// Clicked on Menu Icon //
	// ===== //
	$(document).on('click', ".pickplugins_wl_wishlist_buttons .pickplugins_wl_wishlist_menu .pickplugins_wl_wishlist_menu_icon", function() {

		console.log('hello');

		$(this).html("<i class='fa fa-cog fa-spin' ></i>");

		//$('.pickplugins_wl_wishlist_buttons .pickplugins_wl_menu_items').fadeOut();
		
		item_id = $(this).parent().find( '.pickplugins_wl_menu_items' ).attr( 'item_id' );
		
		$(this).parent().find('.pickplugins_wl_menu_items').html( "<li class='pickplugins_wl_menu_item'><i class='fa fa-cog fa-spin' ></i> Loading</li>" );

		$.ajax(
			{
		type: 'POST',
		context: this,
		url:pickplugins_wl_ajax.pickplugins_wl_ajaxurl,
		data: {
			"action" 		: "pickplugins_wl_ajax_get_wishlist_menu_items",
			"item_id" 	: item_id,
		},
		success: function(data) {

			$(this).html("<i class='fa fa-bars' ></i>");

			$(this).parent().find('.pickplugins_wl_menu_items').html( data );
			$(this).parent().find('.pickplugins_wl_menu_items').fadeIn('fast');
		}
			});
	})

	
	
	// Close Menu of wishlists while clicking outside anywhere //
	// ===== //
	$(document).click(function( e ) {

		if( $.inArray( 'pickplugins_wl_wishlist_menu_icon', e.target.classList ) !== -1 ) return;
		if ( e.target.id != 'pickplugins_wl_menu_items' && !$('#pickplugins_wl_menu_items').find(e.target).length) {

			if( $.inArray( 'pickplugins_wl_menu_item', e.target.classList ) !== -1 ) return;
			$('.pickplugins_wl_wishlist_buttons .pickplugins_wl_menu_items').fadeOut();
		}
	});


});


