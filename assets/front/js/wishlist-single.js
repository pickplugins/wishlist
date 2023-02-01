jQuery(document).ready(function ($) {



	if (!wishlishtVars.isLogged) {

		let localWishlists = localStorage.getItem('localWishlists');
		localWishlists = (localWishlists != null) ? JSON.parse(localWishlists) : {};

		var offlineSelector = document.querySelector('#offline-wishlist');
		var offlineItemsSelector = document.querySelector('#offline-wishlist .items');
		var logginError = document.querySelector('#loggin-error');
		var offlineTitle = document.querySelector('.offline-title');
		var offlineExport = document.querySelector('.offline-export');


		if (Object.entries(localWishlists).length > 0) {
			$.ajax(
				{
					type: 'POST',
					context: this,
					url: wishlist_single_js.ajaxurl,
					data: {
						"action": "pickplugins_wl_ajax_offline_wishlist_items",
						"items": localWishlists,
					},
					success: function (data) {


						var items = JSON.parse(data);


						var html = '';

						for (var i in items) {
							var item = items[i];

							html += '<div>';
							html += '<img class="item-thumb" src="' + item.thumb + '"/>';
							html += '<div class="item-title">' + item.title + '</div>';
							html += '</div>';

						}


						offlineItemsSelector.insertAdjacentHTML('beforeend', html);

						logginError.style.display = 'none'
						offlineTitle.style.display = 'block'
						if (offlineExport != null) {
							offlineExport.style.display = 'inline-block'

						}

					}
				});
		}


	}


	function download(filename, text) {
		var element = document.createElement('a');
		element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
		element.setAttribute('download', filename);

		element.style.display = 'none';
		document.body.appendChild(element);

		element.click();

		document.body.removeChild(element);
	}



	if (!wishlishtVars.isLogged) {

		let localWishlists = localStorage.getItem('localWishlists');
		localWishlists = (localWishlists != null) ? JSON.parse(localWishlists) : {};

		var offlineExport = document.querySelector('.offline-export');



		if (offlineExport != null) {
			offlineExport.addEventListener('click', () => {



				if (Object.entries(localWishlists).length > 0) {
					$.ajax(
						{
							type: 'POST',
							context: this,
							url: wishlist_single_js.ajaxurl,
							data: {
								"action": "pickplugins_wl_ajax_offline_wishlist_items",
								"items": localWishlists,
							},
							success: function (data) {


								var items = JSON.parse(data);


								var text = '';


								for (var i in items) {
									var item = items[i];

									text += 'Product Title: ' + item.title;
									text += '\n';
									text += 'Product ID: ' + i;
									text += '\n';
									text += '\n';


								}


								var filename = 'wishlist-' + Date.now() + ".txt";

								download(filename, text);


							}
						});
				}



			})

		}





	}





	// Wishlist Copy //
	// ===== //

	$(document).on('click', ".pickplugins_wl_button_copy", function () {

		wishlist_id = $(this).attr('wishlist_id');

		if (typeof wishlist_id === "undefined" || wishlist_id.length == 0) return;

		__HTML__ = $(this).html();
		$(this).html("Copying...");

		$.ajax(
			{
				type: 'POST',
				context: this,
				url: wishlist_single_js.ajaxurl,
				data: {
					"action": "pickplugins_wl_ajax_wishlist_copy",
					"wishlist_id": wishlist_id,
				},
				success: function (data) {

					$(this).html(__HTML__);
					window.location.replace(data);
				}
			});

	})



	// Share Wishlist //
	// ===== //





	// Vote Action //
	// ===== //
	$(document).on('click', ".wl_vote_confirm", function () {

		if ($(this).hasClass('wl_vote_up')) vote_type = "vote_up";
		else if ($(this).hasClass('wl_vote_down')) vote_type = "vote_down";
		else vote_type = "";

		user_id = $(this).parent().attr('user_id');
		wishlist_id = $(this).parent().attr('wishlist_id');

		if (typeof user_id === "undefined" || user_id.length == 0) return;
		if (typeof wishlist_id === "undefined" || wishlist_id.length == 0) return;
		if (vote_type.length == 0) return;

		$.ajax(
			{
				type: 'POST',
				context: this,
				url: wishlist_single_js.ajaxurl,
				data: {
					"action": "pickplugins_wl_ajax_update_vote",
					"wishlist_id": wishlist_id,
					"vote_type": vote_type,
				},
				success: function (response) {

					data = JSON.parse(response);

					$(this).parent().find('.wl_vote_up_count').html(data['vote_up']);
					$(this).parent().find('.wl_vote_down_count').html(data['vote_down']);
				}
			});
	})






	$(document).on('click', ".wishlist-items .remove", function () {


		confirm = $(this).attr('confirm');
		confirmText = $(this).attr('confirmText');
		$(this).html('Confirm');
		$(this).addClass('confirm');


		if (confirm == 'yes') {

			wishlist_id = $(this).attr('wishlist_id');
			item_id = $(this).attr('item_id');

			if (typeof wishlist_id === "undefined" || wishlist_id.length == 0) return;

			__HTML__ = $(this).html();
			$(this).html("Deleting...");

			$.ajax(
				{
					type: 'POST',
					context: this,
					url: wishlist_single_js.ajaxurl,
					data: {
						"action": "pickplugins_wl_ajax_remove_wishlist_item",
						"wishlist_id": wishlist_id,
						"item_id": item_id,

					},
					success: function (response) {
						data = JSON.parse(response);



						var removed = data['removed'];

						if (removed) {
							$('.wl-single-item-' + item_id).remove();
						}

						//window.location.replace( data );
					}

				});


		} else {
			$(this).attr('confirm', 'yes');
			$(this).html(confirmText);

		}


	})





	$(document).on('click', ".wishlist_editing .button_delete", function () {


		confirm = $(this).attr('confirm');
		confirmText = $(this).attr('confirmText');

		if (confirm == 'yes') {

			wishlist_id = $(this).attr('wishlist_id');

			if (typeof wishlist_id === "undefined" || wishlist_id.length == 0) return;

			__HTML__ = $(this).html();
			$(this).html("Deleting...");

			$.ajax(
				{
					type: 'POST',
					context: this,
					url: wishlist_single_js.ajaxurl,
					data: {
						"action": "pickplugins_wl_ajax_update_wishlist",
						"pickplugins_wl_action": "delete",
						"wishlist_id": wishlist_id,
					},
					success: function (data) {

						window.location.replace(data);
					}

				});


		} else {
			$(this).attr('confirm', 'yes');
			$(this).html(confirmText);

		}


	})






	// Popup Edit Screen //
	// ===== //

	$(document).on('click', ".popup_edit .pickplugins_wl_popup_save", function () {

		wishlist_id = $('.popup_edit').attr('wishlist_id');
		wishlist_title = $('.popup_edit .pickplugins_wl_wishlist_title').val();
		wishlist_sd = $('.popup_edit .pickplugins_wl_wishlist_sd').val();
		wishlist_status = $('.popup_edit .wishlist_status').val();

		if (typeof wishlist_id === "undefined" || wishlist_id.length == 0) return;
		if (typeof wishlist_title === "undefined" || wishlist_title.length == 0) return;

		__HTML__ = $(this).html();
		$(this).html("<i class='fa fa-cog fa-spin' ></i> Saving...");

		$.ajax(
			{
				type: 'POST',
				context: this,
				url: wishlist_single_js.ajaxurl,
				data: {
					"action": "pickplugins_wl_ajax_update_wishlist",
					"pickplugins_wl_action": "update",
					"wishlist_id": wishlist_id,
					"wishlist_title": wishlist_title,
					"wishlist_sd": wishlist_sd,
					"wishlist_status": wishlist_status,
				},
				success: function (data) {

					if (data.length != 0) window.location.replace(data);
				}
			});
	})



	$(document).on('click', ".wishlist_editing .button_edit", function () {


		$('.popup_edit').fadeIn();
	})



	$(document).on('click', ".popup_edit .popup_cancel", function () {
		$('.popup_edit').fadeOut();
	})




});


