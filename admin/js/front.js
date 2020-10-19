// Place Order Button text change after ajax stop
jQuery(document).ajaxStop(function (event) {
	wacout_btn_text_change();
});

function wacout_btn_text_change() {
	var button_text = jQuery('button#place_order').html();
	var security_nonce = wacout_front_vars.ajax_public_nonce;
	jQuery.ajax({
		url: wacout_front_vars.ajaxurl,
		method: "POST",
		data: { post_id: wacout_front_vars.postID, btn_txt: button_text, action: 'wacout_button_style',security_nonce:security_nonce }, //form_data,
		dataType: "json",
		global: false,
		success: function (data) {
			if (data.data_resp == 'success') {
				jQuery('button#place_order').html(data.wacout_place_order_button);
			} else {
				jQuery('button#place_order').html(data.wacout_place_order_button);
			}
		},
	});
}



jQuery(document).ready(function () {
	// Owl Carousel js
	jQuery('.wacout_tmp_owl-carousel-slider').owlCarousel({
		items: 1,
		smartSpeed: 450,
		nav: false,
		dots: true,
		responsive: {
			0: {
				items: 1,
				dots: true,
				nav: false
			},
			700: {
				items: 1,
				dots: true,
				nav: false
			},
			1000: {
				items: 1,
				dots: true,
				nav: false
			}
		}
	});



	/*Add Product*/
	jQuery(document).on('click', '.wacout_rlt_prd_button .wacout_add_cart', function () {

		var product_id = jQuery(this).attr('id');

		var element = jQuery(this);

		var data = {
			'action': 'wacout_add_to_cart',
			'product_id': product_id,
			'security_nonce': wacout_front_vars.ajax_public_nonce,
		}


		if (product_id) {
			jQuery.ajax({
				url: wacout_front_vars.ajaxurl,
				type: "POST",
				data: data,
				dataType: "json",
					global: false,
				success: function (response) {
					if (response.success == 'true') {
						jQuery(document.body).trigger('update_checkout');
						element.addClass('wacout_add_hide');
						element.closest('.wacout_rlt_prd_button').find('.wacout_remove').removeClass('wacout_add_hide');

					}
				}
			});
		}

	});

	/*Remove Product*/
	jQuery(document).on('click', '.wacout_rlt_prd_button .wacout_remove', function () {

		var product_id = jQuery(this).attr('id');
		var element = jQuery(this);

		var data = {
			'action': 'wacout_remove_prd',
			'product_id': product_id,
			'security_nonce': wacout_front_vars.ajax_public_nonce,
		}

		if (product_id) {
			jQuery.ajax({
				url: wacout_front_vars.ajaxurl,
				type: "POST",
				data: data,
				dataType: "json",
					global: false,
				success: function (response) {
					if (response.success == 'true') {
						jQuery(document.body).trigger('update_checkout');
						element.addClass('wacout_add_hide');
						element.closest('.wacout_rlt_prd_button').find('.wacout_add_cart').removeClass('wacout_add_hide');

					}
				}
			});
		}

	});

	/*Inser error out of checkout form*/
	jQuery('form.checkout.woocommerce-checkout').bind('DOMSubtreeModified', function () {
		if (jQuery('ul.woocommerce-error').length) {
			jQuery('ul.woocommerce-error').insertAfter('.woocommerce-notices-wrapper')//where you want to place
		}
	});


	// upadte checkout
	jQuery(window).load(function () {
		jQuery(document.body).trigger('update_checkout');
	});
	jQuery(document).on('click', '.remove_from_cart_button', function () {
		setTimeout(function () { jQuery(document.body).trigger('update_checkout'); }, 1000);
	});


});
