jQuery(document).ready(function ($) {



	if (!wishlishtVars.isLogged) {
		let localWishlists = localStorage.getItem('localWishlists');
		localWishlists = (localWishlists != null) ? JSON.parse(localWishlists) : {};

		var wishlistSelector = document.querySelectorAll('.wishlist_save');


		wishlistSelector.forEach(x => {

			var itemId = x.getAttribute('item_id');


			if (localWishlists[itemId] != undefined) {
				x.classList.add('wishlist_saved');
			}
		})
	}
	//console.log(wishlishtVars.isProUser);

	if (wishlishtVars.isLogged && wishlishtVars.isProUser) {
		let localWishlists = localStorage.getItem('localWishlists');
		localWishlists = (localWishlists != null) ? JSON.parse(localWishlists) : {};

		console.log(localWishlists);

		if (Object.entries(localWishlists).length > 0) {
			$.ajax(
				{
					type: 'POST',
					context: this,
					url: wishlist_button_js.ajaxurl,
					data: {
						"action": "pickplugins_wl_ajax_sync_local_saved",
						"items": localWishlists,
					},
					success: function (data) {

						console.log(data);

						localStorage.removeItem('localWishlists');


					}
				});
		}









	}


	document.addEventListener("click", function (e) {
		if ($('.wishlist_button_menu').hasClass('active') && $(e.target).closest(".wishlist_button_menu").length == 0) {
			$('.wishlist_button_menu').removeClass('active');
		}
	}, true);

	$(document).on('click', ".wishlist-button-wrap .wishlist_save", function () {

		icon_active = $(this).parent().attr('icon_active');
		icon_inactive = $(this).parent().attr('icon_inactive');
		icon_loading = $(this).parent().attr('icon_loading');

		item_id = $(this).parent().attr('item_id');
		obj_type = $(this).parent().attr('obj_type');
		wishlist_id = $(this).attr('wishlist_id');
		islogged = $(this).attr('islogged');


		if (islogged == 'false') {

			let localWishlists = localStorage.getItem('localWishlists');
			localWishlists = (localWishlists != null) ? JSON.parse(localWishlists) : {};

			if (localWishlists[item_id] == undefined) {
				localWishlists[item_id] = { objType: obj_type, objId: item_id, wishlistId: wishlist_id }
				$(this).addClass('wishlist_saved');

			} else {
				delete localWishlists[item_id];
				$(this).removeClass('wishlist_saved');

			}
			console.log(item_id, obj_type, wishlist_id);


			localStorage.setItem('localWishlists', JSON.stringify(localWishlists));


			return;

		}




		pickplugins_wl_action = $(this).hasClass('wishlist_saved') ? 'remove_from_wishlist' : 'add_in_wishlist';


		if (typeof item_id === "undefined" || item_id.length == 0) return;
		if (typeof wishlist_id === "undefined" || wishlist_id.length == 0) {

			if (islogged != 'false') {
				alert(L10n_wishlist.wishlist_id_missing);

			}
			return
		};

		$(this).children('.wishlist_save_icon').html(icon_loading);
		//$(this).children('.wishlist_save_icon').html("<i class='fa fa-cog fa-spin' ></i>");


		$.ajax(
			{
				type: 'POST',
				context: this,
				url: wishlist_button_js.ajaxurl,
				data: {
					"action": "pickplugins_wl_ajax_add_remove_item_on_wishlist",
					"pickplugins_wl_action": pickplugins_wl_action,
					"item_id": item_id,
					"wishlist_id": wishlist_id,
					"obj_type": obj_type,

				},
				success: function (response) {
					var data = JSON.parse(response);

					status = data['status'];
					count = data['count'];
					total_count = data['total_count'];


					$(this).parent().children('.wishlist_count').text(count);


					if (status == 'removed') {
						$(this).children('.wishlist_save_icon').html(icon_inactive);
						$('.wishlist_save_' + item_id).removeClass('wishlist_saved');
						$(this).removeClass('wishlist_saved');

					}

					if (status == 'added') {
						$(this).children('.wishlist_save_icon').html(icon_active);
						$('.wishlist_save_' + item_id).addClass('wishlist_saved');
						$(this).addClass('wishlist_saved');

					}

					$('.menu_items').children('.menu_item-' + wishlist_id).children('.counter').html('(' + total_count + ')');


				}
			});

	})


	$(document).on('click', ".wishlist-button-wrap .wishlist_button_menu", function () {

		//console.log('hello');

		icon_loading = $(this).parent().attr('icon_loading');
		item_id = $(this).parent().attr('item_id');
		is_loaded = $(this).attr('is_loaded');

		icon_menu = $(this).parent().attr('icon_menu');




		if (is_loaded == 'yes') {
			$(this).toggleClass('active');
		} else {
			$(this).children('.wishlist_button_menu_icon').html(icon_loading);


			$.ajax(
				{
					type: 'POST',
					context: this,
					url: wishlist_button_js.ajaxurl,
					data: {
						"action": "pickplugins_wl_ajax_get_wishlist_menu_items",
						"item_id": item_id,
					},
					success: function (data) {

						//console.log(data);

						$(this).toggleClass('active');
						$(this).children('.wishlist_button_menu_icon').html(icon_menu);
						$(this).children('.menu_items').html(data);
						$(this).children('.menu_items').fadeIn('fast');

						$(this).attr('is_loaded', 'yes');

					}
				});
		}


	})

	// $(document).on('click', ".wishlist-button-wrap .wishlist_button_menu .wishlist_button_menu_icon", function() {
	//
	// 	//console.log('hello');
	// 	icon_loading = $(this).parent().parent().attr( 'icon_loading' );
	//
	// 	$(this).html(icon_loading);
	//
	// 	item_id = $(this).parent().find( '.menu_items' ).attr( 'item_id' );
	//
	//
	// 	$.ajax(
	// 		{
	// 			type: 'POST',
	// 			context: this,
	// 			url:wishlist_button_js.ajaxurl,
	// 			data: {
	// 				"action" 		: "pickplugins_wl_ajax_get_wishlist_menu_items",
	// 				"item_id" 	: item_id,
	// 			},
	// 			success: function(data) {
	//
	// 				$(this).html("<i class='fa fa-bars' ></i>");
	//
	// 				$(this).parent().find('.menu_items').html( data );
	// 				$(this).parent().find('.menu_items').fadeIn('fast');
	// 			}
	// 		});
	// })






	// Saved in Wishlist from Menu Item //
	// ===== //
	$(document).on('click', ".wishlist-button-wrap .menu_items .menu_item", function (e) {




		e.stopPropagation();

		icon_active = $(this).parent().parent().parent().attr('icon_active');
		icon_inactive = $(this).parent().parent().parent().attr('icon_inactive');
		icon_loading = $(this).parent().parent().parent().attr('icon_loading');




		if ($(this).hasClass('add_new')) return;

		pickplugins_wl_action = $(this).hasClass('wishlist_saved') ? 'remove_from_wishlist' : 'add_in_wishlist';

		item_id = $(this).parent().attr('item_id');
		wishlist_id = $(this).attr('wishlist');

		if (typeof item_id === "undefined" || item_id.length == 0) return;
		if (typeof wishlist_id === "undefined" || wishlist_id.length == 0) return;

		//$(this).children('i').toggleClass('fa-cog fa-heart');
		$(this).children('i').toggleClass('fa-pulse');

		console.log(wishlist_id);

		$.ajax(
			{
				type: 'POST',
				context: this,
				url: wishlist_button_js.ajaxurl,
				data: {
					"action": "pickplugins_wl_ajax_add_remove_item_on_wishlist",
					"pickplugins_wl_action": pickplugins_wl_action,
					"item_id": item_id,
					"wishlist_id": wishlist_id,
				},
				success: function (response) {

					var data = JSON.parse(response);

					status = data['status'];
					count = data['count'];
					total_count = data['total_count'];

					console.log(data);

					$(this).parent().parent().parent().children('.wishlist_count').text(count);
					//$(this).children('i').toggleClass('fa-heart fa-cog');
					$(this).children('i').toggleClass('fa-pulse');

					if (status == 'removed') {

						$(this).removeClass('wishlist_saved');
						pickplugins_wl_stll_saved = false;

						$(this).parent().find('.menu_item').each(function (index) {
							if ($(this).hasClass('wishlist_saved')) pickplugins_wl_stll_saved = true;
						});

						if (!pickplugins_wl_stll_saved) {
							$('.wishlist_save_' + item_id).removeClass('wishlist_saved');
							$('.wishlist_save_' + item_id).children('.wishlist_save_icon').html(icon_inactive);
						}

					}

					if (status == 'added') {

						$('.wishlist_save_' + item_id).addClass('wishlist_saved');
						$('.wishlist_save_' + item_id).children('.wishlist_save_icon').html(icon_active);

						$(this).addClass('wishlist_saved');
					}

					$('.menu_items').children('.menu_item-' + wishlist_id).children('.counter').html('(' + total_count + ')');


				}
			});


	})



	// Create Wishlist from Popup and Saved from there //
	// ===== //
	$(document).on('click', ".wishlist-create-wrap .wishlist-create-save", function (e) {

		e.stopPropagation();

		wishlist_name = $(this).parent().children('.wishlist_name').val();
		item_id = $(this).parent().children('.item_id').val();
		is_private = $(this).parent().children().children('.make_private').prop("checked");


		console.log(wishlist_name);
		console.log(is_private);


		if (typeof item_id === "undefined" || item_id.length == 0) return;
		if (typeof wishlist_name === "undefined" || wishlist_name.length == 0) return;

		__HTML__ = $(this).html();
		$(this).html("Saving...");

		$.ajax(
			{
				type: 'POST',
				context: this,
				url: wishlist_button_js.ajaxurl,
				data: {
					"action": "pickplugins_wl_ajax_create_save_wishlist",
					"wishlist_name": wishlist_name,
					"item_id": item_id,
					"is_private": is_private,

				},
				success: function (response) {

					var data = JSON.parse(response);

					wishlist_id = data['wishlist_id'];


					wishlist_item = '<li style="background: #ffebd3" class="menu_item wishlist_saved" wishlist="' + wishlist_id + '"><i class="fa fa-heart" ></i> ' + wishlist_name + '</li>';

					//if( data.length == 0 ){

					$('.wishlist_save_' + item_id).addClass('wishlist_saved');

					$(this).html(__HTML__);
					//$('.wishlist-create-wrap').fadeOut();
					$('.wishlist-button-wrap .menu_items .create').fadeOut();
					$('.wishlist-create-wrap .wishlist_name').val("");
					$('.wishlist-button-wrap .menu_items').prepend(wishlist_item);
					setTimeout(function () {
						$('.wishlist-button-wrap .menu_item').css('background', '');
					}, 1000);



					//}
				}
			});

	})


	// Close Wishlist creation popup box //
	// ===== //
	$(document).on('click', ".wishlist-create-wrap .wishlist-create-cancel", function () {

		$('.wishlist-create-wrap .item_id').val("");
		//$('.wishlist-create-wrap').fadeOut();
		$('.wishlist-button-wrap .menu_items .create').fadeOut();
	})



	// Clicked on Add new wishlist from Menu items //
	// ===== //
	$(document).on('click', ".wishlist-button-wrap .menu_items .add_new", function () {

		item_id = $(this).parent().attr('item_id');

		if (typeof item_id === "undefined" || item_id.length == 0) return;
		$('.wishlist-button-wrap .menu_items .create').fadeIn();

		$('.wishlist-create-wrap .item_id').val(item_id);
		// $('.wishlist-button-wrap .menu_items').fadeOut();
		// $('.wishlist-create-wrap').fadeIn();




		//setTimeout(function () { $(".wishlist-button-wrap .menu_items").scrollTop(0) }, 500);


		$(".wishlist-button-wrap .menu_items").animate(
			{
				scrollTop: $(this).scrollTop(0)
			},
			"slow"
		);





	})




});


