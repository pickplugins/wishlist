jQuery(document).ready(function($) {
	
	
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
		
		if( typeof wishlist_id === "undefined" || wishlist_id.length == 0 ) return;
		if( typeof wishlist_title === "undefined" || wishlist_title.length == 0 ) return;
		
		__HTML__ = $(this).html();
		$(this).html("<span class='dashicons dashicons-admin-generic dashicons-spin'></span> Saving...");
		
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
		},
		success: function(data) {
			if( data == 'updated' ) location.reload();
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
		success: function(data) {
			
			console.log( data );
			
			if( data == 'removed' ) {
				
				$( '.pickplugins_wl_wishlist_save_' + item_id ).removeClass( 'pickplugins_wl_saved' );
				$(this).removeClass( 'pickplugins_wl_saved' );
			}
			
			if( data == 'added' ) {
				
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
		success: function(data) {
			
			if( data == 'removed' ) {
				
				$(this).removeClass( 'pickplugins_wl_saved' );
				pickplugins_wl_stll_saved = false;
				
				$(this).parent().find('.pickplugins_wl_menu_item').each(function( index ) {
					if( $( this ).hasClass('pickplugins_wl_saved') ) pickplugins_wl_stll_saved = true;
				});

				if( ! pickplugins_wl_stll_saved ) $( '.pickplugins_wl_wishlist_save_' + item_id ).removeClass( 'pickplugins_wl_saved' );
				
			}
			
			if( data == 'added' ) {
				
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
		$(this).html("<span class='dashicons dashicons-admin-generic dashicons-spin'></span> Saving...");

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

		$('.pickplugins_wl_wishlist_buttons .pickplugins_wl_menu_items').fadeOut();
		
		item_id = $(this).parent().find( '.pickplugins_wl_menu_items' ).attr( 'item_id' );
		
		$(this).parent().find('.pickplugins_wl_menu_items').html( "<li class='pickplugins_wl_menu_item'><span class='dashicons dashicons-admin-generic dashicons-spin'></span> Loading</li>" );

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


