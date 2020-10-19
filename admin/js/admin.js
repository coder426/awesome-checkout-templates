
jQuery(function () {
	var myOptions = {
    // you can declare a default color here,
    // or in the data-default-color attribute on the input
    defaultColor: false,
    // a callback to fire whenever the color changes to a valid color
    change: function(event, ui){},
    // a callback to fire when the input is emptied or an invalid color
    clear: function() {},
    // hide the color picker controls on load
    hide: true,
    // show a group of common colors beneath the square
    // or, supply an array of colors to customize further
    palettes: true
};
	 jQuery('.color-picker').wpColorPicker(myOptions);
	/*One column sortable*/
	jQuery("#one_column_sortable").sortable({
		update: function (event, ui) {
			var neworder = [];
			jQuery("#one_column_sortable").find(".ui-state-default").each(function () {
				var item = jQuery(this).text();
				var items = item.replace(/ /g, '_');
				var res = items.toLowerCase();
				neworder.push(res);
			});
			jQuery('#wacout_template_layout').remove();
			jQuery(this).after('<input type="hidden" name="wacout_template_layout" id="wacout_template_layout" value="' + neworder + '">');
			//here, you could pass this re-ordered items to a web method and save to the database using AJAX.
		}
	});
	jQuery("#one_column_sortable").disableSelection();

	/*Two column sortable*/
	jQuery("#wacout_column_left").sortable({
		connectWith: ".connectedSortable",
		update: function (event, ui) {
			var left_column = [];
			jQuery(this).find(".ui-state-default").each(function () {
				var item = jQuery(this).text();
				var items = item.replace(/ /g, '_');
				var res = items.toLowerCase();
				left_column.push(res);
			});

			jQuery('#wacout_template_left').remove();
			jQuery(this).after('<input type="hidden" name="layout_pos[wacout_template_left]" id="wacout_template_left" value="' + left_column + '">');
			//here, you could pass this re-ordered items to a webmethod and save to the database using AJAX.
		}
	}).disableSelection();
	jQuery("#wacout_column_right").sortable({
		connectWith: ".connectedSortable",
		update: function (event, ui) {
			var right_column = [];
			jQuery(this).find(".ui-state-default").each(function () {
				var item = jQuery(this).text();
				var items = item.replace(/ /g, '_');
				var res = items.toLowerCase();
				right_column.push(res);
			});

			jQuery('#wacout_template_right').remove();
			jQuery(this).after('<input type="hidden" name="layout_pos[wacout_template_right]" id="wacout_template_right" value="' + right_column + '">');
			//here, you could pass this re-ordered items to a webmethod and save to the database using AJAX.
		}
	}).disableSelection();

	//font ranger
	var rangeSlider = function () {
		var slider = jQuery('.wacout_range_slider'),
			range = jQuery('.wacout_rs'),
			value = jQuery('.wacout_rsv');

		slider.each(function () {

			value.each(function () {
				var value = jQuery(this).prev().attr('name');
				var value1 = jQuery(this).prev().attr('value');
				jQuery(this).html(value1 + 'px');
			});

			range.on('input', function () {
				jQuery(this).next(value).html(this.value + 'px');
			});
		});
	};

	rangeSlider();

	//ranger fill by color
	jQuery('input[type="range"]').on("change mousemove", function () {
		var val = (jQuery(this).val() - jQuery(this).attr('min')) / (jQuery(this).attr('max') - jQuery(this).attr('min'));
		jQuery(this).css('background-image',
			'-webkit-gradient(linear, left top, right top, '
			+ 'color-stop(' + val + ', #2f466b), '
			+ 'color-stop(' + val + ', #d3d3db)'
			+ ')'
		);
	});


});

/*on select change layout*/
jQuery(document).ready(function () {

	"use strict";
	/* On ready function trigger*/
	wacout_product_search_init();
	jQuery("#wacout_select_layout").change(function () {
		if (jQuery(this).val() == 1) {
			jQuery('#wacout_one_column').css('display', 'block');
			jQuery('#wacout_two_column').css('display', 'none');
		}
		else if (jQuery(this).val() == 2) {
			jQuery('#wacout_two_column').css('display', 'block');
			jQuery('#wacout_one_column').css('display', 'none');
		} else {
			jQuery('#wacout_one_column').css('display', 'none');
			jQuery('#wacout_two_column').css('display', 'none');
		}
	});

	jQuery('.wacout_product_search option')
		.filter(function () {
			return !this.value || jQuery.trim(this.value).length == 0 || jQuery.trim(this.text).length == 0;
		})
		.remove();



	// append Related product html
	jQuery(document).on('click', '.wacout_more_prd_add_button', function (e) {
		e.preventDefault();
		var counter = jQuery('#wacout_more_prd_add_count').val();
		var counters = parseInt(counter) + 1;
		jQuery('.wacout_more_prd_wrap').append('<div class="wacout_more_prd_single"><div class="wacout_more_prd_remove">X</div><div class="wacout_more_prd_group mb_20"><div class="wacout_more_prd_in"><div class="wacout_more_prd_lbl">Product</div><select name="wacout_more_prd[wacout_more_prd_id][]" class="wacout_product_search" multiple="multiple" data-placeholder="Search for a product&hellip;"></select></div></div><div class="wacout_more_prd_group mb_20"><div class="wacout_more_prd_in"><div class="wacout_more_prd_lbl">Description</div><textarea class="wacout_more_prd_ctrl" name="wacout_more_prd[wacout_more_prd_des][]"></textarea></div></div><div class="wacout_more_prd_group"><div class="wacout_more_prd_in"><div class="wacout_more_prd_lbl">Button Text</div><input class="wacout_more_prd_ctrl" type="text" name="wacout_more_prd[wacout_more_prd_btn][]" value=""></div></div></div>');
		jQuery('#wacout_more_prd_add_count').val(counters);
		wacout_product_search_init();
	});

	// remove Related product html
	jQuery(document).on('click', '.wacout_more_prd_remove', function (e) {
		var counter = jQuery('#wacout_more_prd_add_count').val();
		if (counter > 0) {
			jQuery('#wacout_more_prd_add_count').val(parseInt(counter) - 1);
			jQuery(this).parent().remove();
		}

	});

	jQuery(document).on('click', '#wacout_metabox_side_tab4 .select2', function () {
		var licount = jQuery('#wacout_metabox_side_tab4 .select2 ul.select2-selection__rendered li').length;
		jQuery('#wacout_metabox_side_tab4 .select2-selection__rendered li:first-child').css('display', 'block');
		if (licount >= 2) {
			jQuery('#wacout_metabox_side_tab4 .select2-selection__rendered li').css('display', 'none');
			jQuery('#wacout_metabox_side_tab4 .select2-selection__rendered li:first-child').css('display', 'block');
		}

	});
});



// Product search Filter using ajax
function wacout_product_search_init() {
	jQuery('.wacout_product_search').select2({
		ajax: {
			url: wacout_vars.ajaxurl,
			dataType: 'json',
			delay: 200,
			data: function (params) {
				return {
					q: params.term,
					action: 'wacout_product_search',
					security_nonce: wacout_vars.ajax_public_nonce,
				};
			},
			processResults: function (data) {
				var options = [];
				if (data) {
					jQuery.each(data, function (index, text) {
						text[1] += '( #' + text[0] + ')';
						options.push({ id: text[0], text: text[1] });
					});
				}
				return {
					results: options
				};
			},
			cache: true
		},
		minimumInputLength: 3
	});

}



jQuery(document).ready(function ($) {
	'use strict';


	$('.wacout_fdtype').attr('checked', false);

	// Review
	$('.wacout_fdtypes').click(function (e) {
		var radio = $(this).val();
		jQuery('#wacout_form_type').val(radio);
		if (radio == 'suggestions') {
			// Hide other options
			$('#wacout_fdtype_1, #wacout_fdtype_3').closest('li').hide();

			// change placeholder message
			$('.wacout_fdback_form').find('.wacout-feedback-message').attr('placeholder', 'Leave plugin developers any feedback here');

			// Show feedback form
			$('.wacout_fdback_form').fadeIn();
			jQuery('#wacout-feedback-message,#wacout-feedback-email').removeAttr('style');
			jQuery('.export_error').remove();

		}
		else if (radio == 'help-needed') {
			// Hide other options
			$('#wacout_fdtype_1, #wacout_fdtype_2').closest('li').hide();

			// change placeholder message
			$('.wacout_fdback_form').find('.wacout-feedback-message').attr('placeholder', 'Leave plugin developers any feedback here');

			// Show feedback form
			$('.wacout_fdback_form').fadeIn();
			jQuery('#wacout-feedback-message,#wacout-feedback-email').removeAttr('style');
			jQuery('.export_error').remove();
		}
		else if (radio == 'review') {
			var rev_url = $('#wacout_fdtype_lnk1').attr("href");
			//window.location.href = rev_url;
			window.open(rev_url, '_blank');
		}
	});

	jQuery('#wacout_fdb_terms').click(function () {
		if (jQuery(this).prop("checked") == true) {
			jQuery('.export_error').remove();
		}
	});


	jQuery("#wacout_sprt_form #wacout-feedback-email,#wacout_sprt_form #wacout-feedback-message").keyup(function () {
		jQuery('.email_response_pass').remove();
		if (jQuery(this).val().length === 0) {
			jQuery(this).css('border-left', '3px solid red');
			return false;
		} else {
			jQuery(this).css('border-left', '3px solid green');
			return true;
		}
	});

	jQuery(document).on('submit', '#wacout_sprt_form', function (e) {
		e.preventDefault();
		var wccb_fdbk_email = jQuery.trim(jQuery('#wacout-feedback-email').val());
		var wccb_fdbk_msg = jQuery.trim(jQuery('#wacout-feedback-message').val());

		if (jQuery('#wacout_fdb_terms').is(':checked') == true && wccb_fdbk_email.length > 1 && wccb_fdbk_msg.length > 1) {

			jQuery('.export_error').remove();
			jQuery('#wacout_sms_loading').show();
			jQuery('#wacout-feedback-email,#wacout-feedback-message').css('border-left', '3px solid green');
			var form_type = jQuery('#wacout_form_type').val();
			var fdbk_trm = jQuery('#wacout_fdb_terms').val();
			var security_nonce = wacout_vars.ajax_public_nonce;

			jQuery.ajax({
				url: wacout_vars.ajaxurl,
				method: "POST",
				data: { form_type: form_type, fdbk_email: wccb_fdbk_email, fdbk_msg: wccb_fdbk_msg, fdbk_trm: fdbk_trm, btn_action: 'wacout_send_email', action: 'wacout_send_email_help',security_nonce:security_nonce }, //form_data,
				success: function (data) {
					if (!data) {
						jQuery('#wacout_sms_loading').hide();
						jQuery('.email_response_fail').remove();
						jQuery('.wacout_sbmt_buttons').after('<div class="mt-2"><p class="email_response_fail">Failed to send an e-mail. Please contact us directly on hirewebxperts.com.</p></div>');
					} else {
						jQuery('#wacout_sms_loading').hide();
						jQuery('.email_response_pass').remove();
						jQuery('.email_response_fail').remove();
						jQuery('#wacout-feedback-email,#wacout-feedback-message').val('');
						jQuery('#wacout_fdb_terms').prop("checked", false);
						jQuery('#wacout-feedback-message,#wacout-feedback-email').css('border-left', '3px solid red');
						jQuery('#wacout-feedback-message,#wacout-feedback-email').removeAttr('style');
						jQuery('.wacout_sbmt_buttons').after('<div class="mt-2"><p class="email_response_pass">Email sent successfully.</p></div>');
					}
				},
			});
			return false;
		}
		else {
			jQuery('.export_error').remove();
			if (wccb_fdbk_email.length == 0) {
				jQuery('#wacout-feedback-email').css('border-left', '3px solid red');
			} if (wccb_fdbk_msg.length == 0) {
				jQuery('#wacout-feedback-message').css('border-left', '3px solid red');
			}
			jQuery('.wacout_fdb_terms_s').after('<div class="export_error"><p>Please fill all field properly.</p></div>');
			return false;
		}
	});



	// Cancel feedback form
	jQuery('#wacout_fd_cancel').click(function (e) {
		e.preventDefault();
		jQuery('.wacout_fdback_form').fadeOut(function () {
			jQuery('.wacout_fdtypes').attr('checked', false).closest('li').show();
		});
		jQuery('.email_response_fail').remove();
		jQuery('.email_response_pass').remove();
		jQuery("#wacout_sprt_form")[0].reset();
	});
	//end support form


});
