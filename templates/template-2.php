<?php

$post_id = wacout_get_post_meta_using_id();
?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<style type="text/css">

			<?php
			$wacout_all_setting 		= get_post_meta( $post_id,'_wacout_template_layout_settings',true );
			if( isset($wacout_all_setting) && count($wacout_all_setting) ){
				$wacout_all_setting			= $wacout_all_setting['template_layout_all_settings'];
				$wacout_temp_pos			= $wacout_all_setting['layout_pos'];
				$wacout_front_btn_style 	= $wacout_all_setting['layout_Button_text']['btn_setting'];
				$wacout_layout_one_styling  = $wacout_all_setting['layout_style_option']['one_column_styling'];
				$wacout_layout_styling		= $wacout_all_setting['layout_style_option']['section_style'];
				$wacout_layout_hdng_styling = $wacout_all_setting['layout_style_option']['heading_style'];
				$wacout_layout_form_styling = $wacout_all_setting['layout_style_option']['form_fields_style'];
			}



			// button style start
			if(isset($wacout_front_btn_style['button_background']) && !empty($wacout_front_btn_style['button_background'])){ $wacout_button_background = sanitize_hex_color($wacout_front_btn_style['button_background']); } else{ $wacout_button_background = "#fe3232"; }

			if(isset($wacout_front_btn_style['button_bg_hvr']) && !empty($wacout_front_btn_style['button_bg_hvr'])){ $wacout_button_bg_hvr = sanitize_hex_color($wacout_front_btn_style['button_bg_hvr']); } else{ $wacout_button_bg_hvr = "#005c90"; }

			if(isset($wacout_front_btn_style['button_font_color']) && !empty($wacout_front_btn_style['button_font_color'])){ $wacout_button_font_color = sanitize_hex_color($wacout_front_btn_style['button_font_color']); } else{ $wacout_button_font_color = "#ffffff"; }

			if(isset($wacout_front_btn_style['button_border_color']) && !empty($wacout_front_btn_style['button_border_color'])){ $wacout_button_border_color = sanitize_hex_color($wacout_front_btn_style['button_border_color']); } else{ $wacout_button_border_color = "#fe3232"; }

			if(isset($wacout_front_btn_style['button_border_size']) && !empty($wacout_front_btn_style['button_border_size'])){ $wacout_button_border_size = absint($wacout_front_btn_style['button_border_size']); } else{ $wacout_button_border_size = "1"; }

			if(isset($wacout_front_btn_style['button_font_size']) && !empty($wacout_front_btn_style['button_font_size'])){ $wacout_button_font_size = absint($wacout_front_btn_style['button_font_size']); } else{ $wacout_button_font_size = "19"; }
			// button style end

			/*Column styling*/


			if(isset($wacout_layout_styling['sec_bdr_width']) && !empty($wacout_layout_styling['sec_bdr_width'])){ $wacout_sec_bdr_width = absint($wacout_layout_styling['sec_bdr_width']); } elseif(isset($wacout_layout_styling['sec_bdr_width']) && ($wacout_layout_styling['sec_bdr_width'] == 0) ){$wacout_sec_bdr_width = "0";}else{ $wacout_sec_bdr_width = "6"; }

			if(isset($wacout_layout_styling['sec_padding']) && !empty($wacout_layout_styling['sec_padding'])){ $wacout_sec_padding = absint($wacout_layout_styling['sec_padding']); }else{ $wacout_sec_padding = "30"; }

			if(isset($wacout_layout_hdng_styling['hd_background']) && !empty($wacout_layout_hdng_styling['hd_background'])){ $wacout_hd_background = sanitize_hex_color($wacout_layout_hdng_styling['hd_background']); } else{ $wacout_hd_background = "#007ead"; }

			if(isset($wacout_layout_hdng_styling['hd_font_color']) && !empty($wacout_layout_hdng_styling['hd_font_color'])){ $wacout_hd_font_color = sanitize_hex_color($wacout_layout_hdng_styling['hd_font_color']); } else{ $wacout_hd_font_color = "#ffffff"; }

			if(isset($wacout_layout_hdng_styling['hd_font_size']) && !empty($wacout_layout_hdng_styling['hd_font_size'])){ $wacout_hd_font_size = absint($wacout_layout_hdng_styling['hd_font_size']); } else{ $wacout_hd_font_size = "24"; }

			if(isset($wacout_layout_form_styling['lbl_font_color']) && !empty($wacout_layout_form_styling['lbl_font_color'])){ $wacout_lbl_font_color = sanitize_hex_color($wacout_layout_form_styling['lbl_font_color']); } else{ $wacout_lbl_font_color = "#343434"; }

			if(isset($wacout_layout_form_styling['lbl_font_size']) && !empty($wacout_layout_form_styling['lbl_font_size'])){ $wacout_lbl_font_size = absint($wacout_layout_form_styling['lbl_font_size']); } else{ $wacout_lbl_font_size = "18"; }

			if(isset($wacout_layout_form_styling['fld_bdr_color']) && !empty($wacout_layout_form_styling['fld_bdr_color'])){ $wacout_fld_bdr_color = sanitize_hex_color($wacout_layout_form_styling['fld_bdr_color']); } else{ $wacout_fld_bdr_color = "#e2e2e2"; }

			if(isset($wacout_layout_form_styling['fld_bdr_size']) && !empty($wacout_layout_form_styling['fld_bdr_size'])){ $wacout_fld_bdr_size = absint($wacout_layout_form_styling['fld_bdr_size']); } else{ $wacout_fld_bdr_size = "2"; }

			?>

			.wacout_checkout_tmp2_body h3 {
				background: <?php echo esc_html($wacout_hd_background);?>;
				font-size: <?php echo absint($wacout_hd_font_size);?>px !important;
				color: <?php echo esc_html($wacout_hd_font_color);?>;
				position: relative;
				padding: 10px !important;
				font-weight: bold !important;
				margin-bottom: 0px !important;
				text-align: center;
				text-transform: uppercase;
				border-radius: 0px 0px;
			}
			.wacout_checkout_tmp2_body .wacout_checkout_tmp2_form .woocommerce-billing-fields__field-wrapper, .wacout_checkout_tmp2_body .wacout_checkout_tmp2_form .woocommerce-checkout-review-order, .wacout_checkout_tmp2_body .wacout_checkout_tmp2_form #order_review {
				padding: <?php echo absint($wacout_sec_padding);?>px;
				background: #ffffff;
				border-radius: 0px 0px 0px 0px;
				border-top: none !important;
				border: <?php echo absint($wacout_sec_bdr_width);?>px solid <?php echo esc_html($wacout_hd_background);?>;
			}
			.wacout_checkout_tmp2_body .wacout_checkout_tmp2_form .woocommerce-additional-fields, .wacout_checkout_tmp2_body .wacout_checkout_tmp2_form .woocommerce-shipping-fields__field-wrapper{
				padding: <?php echo absint($wacout_sec_padding);?>px;
				background: #ffffff;
				border-radius: 0px 0px 0px 0px;
			}
			.wacout_checkout_tmp2_body .p_30 {
				padding: <?php echo absint($wacout_sec_padding);?>px;
			}
			.tmp2_bdr{
				border-top: none !important;
				border: <?php echo absint($wacout_sec_bdr_width);?>px solid <?php echo esc_html($wacout_hd_background);?>;
			}
			.tmp2_bdr2{
				border: <?php echo absint($wacout_sec_bdr_width);?>px solid <?php echo esc_html($wacout_hd_background);?>;
			}
			.wacout_checkout_tmp2_body #payment{
				border-top: none !important;
				border: <?php echo absint($wacout_sec_bdr_width);?>px solid <?php echo esc_html($wacout_hd_background);?>;
				padding: <?php echo absint($wacout_sec_padding);?>px;
				margin-bottom: 30px;
			}
			.wacout_cs1_body,.wacout_cs2_body,.wacout_cs3_body{
				margin-bottom: 30px;
				border-top: none !important;
				border: <?php echo absint($wacout_sec_bdr_width);?>px solid <?php echo esc_html($wacout_hd_background);?>;
				padding: 30px;
			}
			.wacout_checkout_tmp2_body .wacout_rlt_prd {
				border: <?php echo absint($wacout_sec_bdr_width);?>px solid <?php echo esc_html($wacout_hd_background);?>;
				padding-bottom: <?php echo absint($wacout_sec_padding);?>px;
				margin-bottom: 30px;
			}
			.wacout_checkout_tmp2_body .wacout_rlt_prd .wacout_rlt_prd_body {
				padding: <?php echo absint($wacout_sec_padding);?>px;
				padding-bottom: 0px;
				text-align: center;
				background: #ffffff;
				border-radius: 0px;
			}

			.wacout_checkout_tmp2_body .form-row label {
				color: <?php echo esc_html($wacout_lbl_font_color);?>;
				margin-bottom: 2px;
				font-weight: bold;
				font-size: <?php echo absint($wacout_lbl_font_size);?>px;
				text-transform: uppercase;
			}

			.wacout_checkout_tmp2_body button, .wacout_checkout_tmp2_body input[type="button"], .wacout_checkout_tmp2_body input[type="reset"], .wacout_checkout_tmp2_body input[type="submit"], .wacout_checkout_tmp2_body.button, .wacout_checkout_tmp2_body .widget a.button, .wacout_checkout_tmp2_body .button.alt {
				background-color: <?php echo esc_html($wacout_button_background);?>;
				border:<?php echo absint($wacout_button_border_size);?>px solid <?php echo esc_html($wacout_button_border_color);?>;
				color: <?php echo esc_html($wacout_button_font_color);?>;
				font-size: <?php echo absint($wacout_button_font_size);?>px;
				text-transform: uppercase;
				border-radius: 3px;
				outline: 0 !important;
			}

			.wacout_checkout_tmp2_body button:hover, .wacout_checkout_tmp2_body input[type="button"]:hover, .wacout_checkout_tmp2_body input[type="reset"]:hover, .wacout_checkout_tmp2_body input[type="submit"]:hover,
			.wacout_checkout_tmp2_body .button:hover, .wacout_checkout_tmp2_body .widget a.button:hover, .wacout_checkout_tmp2_body button.alt:hover, .wacout_checkout_tmp2_body input[type="button"].alt:hover,
			.wacout_checkout_tmp2_body input[type="reset"].alt:hover, .wacout_checkout_tmp2_body input[type="submit"].alt:hover, .wacout_checkout_tmp2_body .button.alt:hover, .wacout_checkout_tmp2_body .widget-area .widget a.button.alt:hover {
				background-color: <?php echo esc_html($wacout_button_bg_hvr);?>;
				color: <?php echo esc_html($wacout_button_font_color);?>;
				border:<?php echo absint($wacout_button_border_size);?>px solid <?php echo esc_html($wacout_button_border_color);?>;
			}

			.wacout_checkout_tmp2_body .wacout_checkout_tmp2_form .form-row input[type='text'], .wacout_checkout_tmp2_body .wacout_checkout_tmp2_form .form-row input[type='tel'], .wacout_checkout_tmp2_body .wacout_checkout_tmp2_form .form-row input[type='email'] {
				background: #fff;
				border:<?php echo absint($wacout_fld_bdr_size);?>px solid <?php echo esc_html($wacout_fld_bdr_color);?>;
				height: 50px;
				border-radius: 0px;
				color: #333333;
				box-shadow: inset 0px 0px 11px 7px #fbfbfb;
			}

			.wacout_checkout_tmp2_body .wacout_checkout_tmp2_form .state_select,.wacout_checkout_tmp2_body .wacout_checkout_tmp2_form .country_select,.wacout_checkout_tmp2_body .wacout_checkout_tmp2_form .select2-container--default .select2-selection--single{
				background-color: #fff;
				border:<?php echo absint($wacout_fld_bdr_size);?>px solid <?php echo esc_html($wacout_fld_bdr_color);?> !important;
				box-shadow: inset 0px 0px 11px 7px #fbfbfb;
			}
			.wacout_checkout_tmp2_body textarea {
				background: #ffffff;
				box-shadow: inset 0px 0px 11px 7px #fbfbfb;
				border:<?php echo absint($wacout_fld_bdr_size);?>px solid <?php echo esc_html($wacout_fld_bdr_color);?>;
			}
			.woocommerce-checkout-review-order-table{
				margin-bottom: 0px;
			}

			.wacout_clear{clear:both}
			.wacout_checkout_tmp2_form{
				max-width: 1170px;
				width: 100%;
				margin: 0 auto;
				padding: 40px 15px;
			}
			.wacout_checkout_tmp2_body .checkout_coupon {
				padding: 30px;
				background: #ffffff;
				border-radius: 0px 0px 0px 0px;
				border-top: none !important;
				border: 6px solid #007ead;
			}

			.wacout_checkout_tmp2_body #billing_country_field select, .wacout_checkout_tmp2_body #billing_state_field select, .wacout_checkout_tmp2_body #billing_country_field span, .wacout_checkout_tmp2_body #billing_state_field span, .wacout_checkout_tmp2_body #shipping_country_field select, .wacout_checkout_tmp2_body #shipping_state_field select, .wacout_checkout_tmp2_body #shipping_country_field span, .wacout_checkout_tmp2_body #shipping_state_field span {
				height: 50px;
				line-height: 50px;
				border-radius: 0px;
				color: #868686;
			}

			.wacout_checkout_tmp2_form .col2-set {
				width: 100%;
				float: none;
				margin-right: 0;
			}

			.woocommerce-shipping-fields input[type="checkbox"] {
				position: relative;
				cursor: pointer;
				padding: 0;
				margin-right: 10px;
			}
			.woocommerce-shipping-fields input[type="checkbox"]:before {
				content: '';
				margin-right: 10px;
				display: inline-block;
				margin-top: 0px;
				width: 20px;
				height: 20px;
				background: #ffffff;
				border: 1px solid #aaa;
				border-radius: 2px;
				position: absolute;
				top: -4px;
				right: -11px;
			}
			.woocommerce-shipping-fields input[type="checkbox"]:hover:before {
				background: #f5821f;
			}
			.woocommerce-shipping-fields input[type="checkbox"]:focus:before {
				box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.12);
			}
			.woocommerce-shipping-fields input[type="checkbox"]:checked:before {
				background: #f5821f;
				border-color: #f5821f;
			}

			.woocommerce-shipping-fields input[type="checkbox"]:checked:after {
				content: '';
				position: absolute;
				left: -3px;
				top: 5px;
				background: white;
				width: 2px;
				height: 2px;
				box-shadow: 2px 0 0 white, 4px 0 0 white, 4px -2px 0 white, 4px -4px 0 white, 4px -6px 0 white, 4px -8px 0 white;
				transform: rotate(45deg);
			}
			.wacout_checkout_tmp2_body #ship-to-different-address .woocommerce-form__input-checkbox{
				right: 3%;
				position: absolute;
				top: 50%;
				-webkit-transform: translateY(-50%);
				-ms-transform: translateY(-50%);
				transform: translateY(-50%);
			}
			.wacout_checkout_tmp2_body h3 label{
				font-weight: bold !important;
			}

			.wacout_checkout_tmp2_body .mb_30 {
				margin-bottom: 30px;
			}
			.wacout_checkout_tmp2_body #order_review_heading, #order_review {
				float: none !important;
				width: 100% !important;
			}

			.wacout_checkout_tmp2_body .wacout_checkout_tmp2_form .woocommerce-shipping-fields__field-wrapper {
				padding-bottom: 0px !important;
				margin-bottom: 0px;
			}

			.wacout_checkout_tmp2_body .wacout_checkout_tmp2_form .form-row {
				width: 100% !important;
				margin-bottom: 15px;
			}
			.woocommerce-billing-fields__field-wrapper .form-row:last-child,.woocommerce-shipping-fields__field-wrapper .form-row:last-child,.woocommerce-additional-fields__field-wrapper .form-row:last-child{
				margin-bottom: 0px;
			}
			.wacout_checkout_tmp2_body .checkout_coupon {
				margin-bottom: 30px;
			}
			.wacout_checkout_tmp2_body .woocommerce-form-coupon-toggle .woocommerce-info{
				margin-bottom: 0px;
				border-radius:0px;
			}
			.wacout_checkout_tmp2_body form.woocommerce-checkout{
				margin-top: 30px;
			}

			.wacout_checkout_tmp2_body .wacout_rlt_prd .wacout_rlt_prd_body img {
				max-width: 40%;
				width: 100%;
				margin: 0 auto;
				margin-bottom: 10px;
			}
			.wacout_rlt_prd_title {
				font-size: 20px;
				font-weight: bold;
				margin-bottom: 10px;
				color: #000000;
			}
			.wacout_rlt_prd_descr {
				margin-bottom: 10px;
			}
			.wacout_rlt_prd_price {
				font-weight: bold;
				margin-bottom: 10px;
				font-size: 20px;
				color: #000000;
			}

			.wacout_checkout_tmp2_body table:not( .has-background ) th {
				background-color: #ffffff;
				color: #0b0b0b;
				font-size: 18px;
				font-weight: bold;
				text-transform: uppercase;
			}
			.wacout_checkout_tmp2_body .shop_table th, .wacout_checkout_tmp2_body .shop_table td {
				border: 1px solid #e8e8e8;
				padding: .8rem 1.2rem;
			}
			.wacout_checkout_tmp2_body .woocommerce-error{
				margin-top: 30px
			}
			.wacout_add_hide{display: none !important;}

			@media (min-width: 768px){
				.wacout_checkout_tmp2_left,.wacout_checkout_tmp2_right{
					width: 50%;
					float: left;
				}
				.wacout_checkout_tmp2_left{
					padding-right: 15px;
				}
				.wacout_checkout_tmp2_right{
					padding-left: 15px;
				}
			}
			@media (max-width: 767px){
				.wacout_checkout_tmp2_form {
					max-width: 500px;

				}
			}

			@media (max-width: 480px){
				.wacout_checkout_tmp2_body  h3{
					font-size: 20px !important;
					line-height: normal;
					padding: 13px 10px !important;
				}

			}
			@media (max-width: 420px){
				.woocommerce-shipping-fields input[type="checkbox"]:before {
					width: 15px;
					height: 15px;
					top: -2px;
				}
				.wacout_checkout_tmp2_body .form-row label {
					font-size: 17px;
				}

			}
			@media (max-width: 399px){
				#ship-to-different-address {text-align: left;}
			}
			@media (max-width: 320px){
				.wacout_checkout_tmp2_body .form-row label {
					font-size: 15px;
				}
			}

			<?php wp_head();  ?>
		</style>
	</head>
	<body>


		<div class="wacout_checkout_tmp2_body">
			<div class="wacout_checkout_tmp2_form">
				<?php

				wc_print_notices();

				do_action( 'woocommerce_before_checkout_form', $checkout );

				// If checkout registration is disabled and not logged in, the user cannot checkout
				if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
					echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
					return;
				}

				?>

				<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

					<?php if ( $checkout->get_checkout_fields() ) : ?>

					<?php

					$template_left = explode(",",sanitize_text_field($wacout_temp_pos['wacout_template_left']));
					$template_right = explode(",",sanitize_text_field($wacout_temp_pos['wacout_template_right']));
					?>
					<div class="wacout_checkout_tmp2_left">
						<?php
						do_action( 'woocommerce_checkout_before_customer_details' );
						foreach($template_left as $template_section){
							if($template_section == 'billing_fields'){
						?>
						<div class="col2-set" id="customer_details">
							<div class="mb_30">
								<?php
								do_action( 'woocommerce_checkout_billing' );
								?>
							</div>
						</div>
						<?php
							}
							elseif($template_section == 'shipping_fields'){
								do_action( 'woocommerce_before_checkout_shipping_form' );
						?>
						<div class="mb_30 tmp2_bdr2">
							<?php
								do_action( 'woocommerce_checkout_shipping' );
							?>
						</div>
						<?php do_action( 'woocommerce_after_checkout_shipping_form' );
								do_action( 'woocommerce_checkout_after_customer_details' );
							}
							elseif($template_section == 'order_details'){
								do_action( 'woocommerce_checkout_before_order_review' );
						?><h3 id="order_review_heading"><?php _e( 'Order details', 'woocommerce' ); ?></h3><div class="p_30 mb_30 tmp2_bdr"><?php

								woocommerce_order_review();?></div><?php
							}
							elseif($template_section == 'payment_information'){

						?><h3><?php _e( 'Payment information', 'woocommerce' ); ?></h3><?php
								woocommerce_checkout_payment();
								do_action( 'woocommerce_checkout_after_order_review' );
							}
							elseif($template_section == 'related_products'){
								wacout_checkout_render_offer_html();
							}
							elseif($template_section == 'custom_section_a'){
								wacout_custom_section1();
							}
							elseif($template_section == 'custom_section_b'){
								wacout_custom_section2();
							}
							elseif($template_section == 'custom_section_c'){
								wacout_custom_section3();
							}

						}//foreach end
						?>
					</div>
					<div class="wacout_checkout_tmp2_right">
						<?php
						do_action( 'woocommerce_checkout_before_customer_details' );
						foreach($template_right as $template_section){
							if($template_section == 'billing_fields'){
						?>
						<div class="col2-set" id="customer_details">
							<div class="mb_30">
								<?php
								do_action( 'woocommerce_checkout_billing' );
								?>
							</div>
						</div>
						<?php
							}
							elseif($template_section == 'shipping_fields'){
								do_action( 'woocommerce_before_checkout_shipping_form' );
						?>
						<div class="mb_30 tmp2_bdr2">
							<?php
								do_action( 'woocommerce_checkout_shipping' );
							?>
						</div>
						<?php do_action( 'woocommerce_after_checkout_shipping_form' );
								do_action( 'woocommerce_checkout_after_customer_details' );
							}
							elseif($template_section == 'order_details'){
								do_action( 'woocommerce_checkout_before_order_review' );
						?><h3 id="order_review_heading"><?php _e( 'Order details', 'woocommerce' ); ?></h3><div class="p_30 mb_30 tmp2_bdr"><?php

								woocommerce_order_review();?></div><?php
							}
							elseif($template_section == 'payment_information'){

						?><h3><?php _e( 'Payment information', 'woocommerce' ); ?></h3><?php
								woocommerce_checkout_payment();
								do_action( 'woocommerce_checkout_after_order_review' );
							}
							elseif($template_section == 'related_products'){
								wacout_checkout_render_offer_html();
							}
							elseif($template_section == 'custom_section_a'){
								wacout_custom_section1();
							}
							elseif($template_section == 'custom_section_b'){
								wacout_custom_section2();
							}
							elseif($template_section == 'custom_section_c'){
								wacout_custom_section3();
							}

						}//foreach end
						?>
					</div>
					<div class="wacout_clear"></div>
					<?php endif; ?>
				</form>
				<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
			</div>
		</div>
		<?php wp_footer(); ?>
	</body>
</html>
