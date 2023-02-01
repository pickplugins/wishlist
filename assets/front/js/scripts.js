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
	
	
	

	
	
	// Popup Delete Screen //
	// ===== //

	$(document).on('click', ".popup_delete .popup_delete_confirm", function() {
		
		wishlist_id		= $('.popup_delete').attr('wishlist_id');
		
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
	
	
	
	$(document).on('click', ".wishlist_editing .button_delete", function() {
		$('.popup_delete').fadeIn();
	})
	
	
	
	$(document).on('click', ".popup_delete .popup_cancel", function() {
		$('.popup_delete').fadeOut();
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
			
			if( data.length != 0 )  window.location.replace( data );
		}
			});
	})
	
	
	
	// $(document).on('click', ".wishlist_editing .button_edit", function() {
	// 	$('.popup_edit').fadeIn();
	// })
	
	
	
	// $(document).on('click', ".popup_edit .popup_cancel", function() {
	// 	$('.popup_edit').fadeOut();
	// })
	
	

	// Saved in Wishlist from Top Heart Icon Item //
	// ===== //
	$(document).on('click', ".wishlist-button-wrap .wishlist_save", function() {

		pickplugins_wl_action = $(this).hasClass( 'wishlist_saved' ) ? 'remove_from_wishlist' : 'add_in_wishlist';

		item_id = $(this).parent().attr( 'item_id' );
		wishlist_id = $(this).attr( 'wishlist_id' );

		if( typeof item_id === "undefined" || item_id.length == 0 ) return;
		if( typeof wishlist_id === "undefined" || wishlist_id.length == 0 ) return;

		$(this).children('.wishlist_save_icon').html("<i class='fa fa-cog fa-spin' ></i>");
		//$(this).children('.wishlist_save_icon').html("<i class='fa fa-cog fa-spin' ></i>");


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

			$(this).children('.wishlist_save_icon').html("<i class='fa fa-heart' ></i>");
			$(this).parent().children('.wishlist_count').text(count);


			if( status == 'removed' ) {

				$( '.wishlist_save_' + item_id ).removeClass( 'wishlist_saved' );
				$(this).removeClass( 'wishlist_saved' );

			}

			if( status == 'added' ) {

				$( '.wishlist_save_' + item_id ).addClass( 'wishlist_saved' );
				$(this).addClass( 'wishlist_saved' );

			}

		}
			});

	})



	// Saved in Wishlist from Menu Item //
	// ===== //
	$(document).on('click', ".wishlist-button-wrap .menu_items .menu_item", function() {


		if( $(this).hasClass( 'add_new' ) ) return;

		pickplugins_wl_action = $(this).hasClass( 'wishlist_saved' ) ? 'remove_from_wishlist' : 'add_in_wishlist';

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

			$(this).parent().parent().parent().children('.wishlist_count').text(count);
			//$(this).children('i').toggleClass('fa-heart fa-cog');
			$(this).children('i').toggleClass('fa-pulse');

			if( status == 'removed' ) {

				$(this).removeClass( 'wishlist_saved' );
				pickplugins_wl_stll_saved = false;

				$(this).parent().find('.menu_item').each(function( index ) {
					if( $( this ).hasClass('wishlist_saved') ) pickplugins_wl_stll_saved = true;
				});

				if( ! pickplugins_wl_stll_saved ) $( '.wishlist_save_' + item_id ).removeClass( 'wishlist_saved' );

			}

			if( status == 'added' ) {

				$( '.wishlist_save_' + item_id ).addClass( 'wishlist_saved' );
				$(this).addClass( 'wishlist_saved' );
			}

		}
			});


	})

	
	
	// Create Wishlist from Popup and Saved from there //
	// ===== //
	$(document).on('click', ".wishlist-create-wrap .wishlist-create-save", function() {

		wishlist_name 	= $('.wishlist-create-wrap .wishlist_name').val();
		item_id 		= $('.wishlist-create-wrap .item_id').val();
		is_private 		= $('.wishlist-create-wrap .make_private').val();

console.log(wishlist_name);

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
			"is_private" 	: is_private,

		},
		success: function(data) {


			
			if( data.length == 0 ){
				
				$( '.wishlist_save_' + item_id ).addClass( 'wishlist_saved' );
			
				$(this).html( __HTML__ );
				//$('.wishlist-create-wrap').fadeOut();
				$('.wishlist-button-wrap .menu_items .create').fadeOut();
                $('.wishlist-create-wrap .wishlist_name').val("");
			}
		}
			});

	})

	

	// Close Wishlist creation popup box //
	// ===== //
	$(document).on('click', ".wishlist-create-wrap .wishlist-create-cancel", function() {

		$('.wishlist-create-wrap .item_id').val("");
		//$('.wishlist-create-wrap').fadeOut();
		$('.wishlist-button-wrap .menu_items .create').fadeOut();
	})

	
	
	// Clicked on Add new wishlist from Menu items //
	// ===== //
	$(document).on('click', ".wishlist-button-wrap .menu_items .add_new", function() {

		item_id = $(this).parent().attr( 'item_id' );

		if( typeof item_id === "undefined" || item_id.length == 0 ) return;
		$('.wishlist-button-wrap .menu_items .create').fadeIn();

		$('.wishlist-create-wrap .item_id').val( item_id );
		// $('.wishlist-button-wrap .menu_items').fadeOut();
		// $('.wishlist-create-wrap').fadeIn();



	})



	// Clicked on Menu Icon //
	// ===== //
	$(document).on('click', ".wishlist-button-wrap .wishlist_button_menu .wishlist_button_menu_icon", function() {

		//console.log('hello');

		$(this).html("<i class='fa fa-cog fa-spin' ></i>");

		//$('.wishlist-button-wrap .menu_items').fadeOut();

		item_id = $(this).parent().find( '.menu_items' ).attr( 'item_id' );

		$(this).parent().find('.menu_items').html( "<li class='menu_item'><i class='fa fa-cog fa-spin' ></i> Loading</li>" );

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

			$(this).parent().find('.menu_items').html( data );
			$(this).parent().find('.menu_items').fadeIn('fast');
		}
			});
	})

	$(document).on('mouseleave', ".wishlist-button-wrap ", function() {
		
		$('.wishlist-button-wrap .menu_items').fadeOut();
	})

	// Close Menu of wishlists while clicking outside anywhere //
	// ===== //
	// $(document).click(function( e ) {
	//
	// 	if( $.inArray( 'wishlist_button_menu_icon', e.target.classList ) !== -1 ) return;
	// 	if ( e.target.id != 'menu_items' && !$('#menu_items').find(e.target).length) {
	//
	// 		if( $.inArray( 'menu_item', e.target.classList ) !== -1 ) return;
	// 		$('.wishlist-button-wrap .menu_items').fadeOut();
	// 	}
	// });


});


