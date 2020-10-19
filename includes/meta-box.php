<?php
/*
   ** Added metabox in custom post type
   ** @since  1.1.1.1
   ** Post type: awesome_checkout
   */
add_action( 'add_meta_boxes','wacout_add_admin_meta_box');
function wacout_add_admin_meta_box(){
	//remove_meta_box( 'submitdiv', 'awesome_checkout', 'side' );
	add_meta_box(
		'wacout_metabox',
		__( 'Template Settings', 'wacout' ),
		'wacout_metabox_display_html',
		'awesome_checkout',
		'normal',
		'low'
	);
}



/*
   ** Added metabox Html
   ** @since  1.1.1.1
   ** Post type: awesome_checkout
   */
function wacout_metabox_display_html($meta_id){

	 $template_settings = get_post_meta( $meta_id->ID,'_wacout_template_layout_settings',true );

	if(isset($template_settings) && !empty($template_settings)){
		/*Template al setting*/
		$template_all_settings = $template_settings['template_layout_all_settings'];

		/*Template Section setting*/
		$temp_layout_selection = $template_all_settings['layout_select'];

		/*Template positions*/
		$temp_layout_position = $template_all_settings['layout_pos'];

		/*Template sorting*/
		$temp_layout_sorting = $template_all_settings['layout_sorting'];

		/*Template custom section*/
		$temp_layout_custom_sec = $template_all_settings['layout_custom_sections'];

		/*Template sections label*/
		$temp_layout_section_label = $template_all_settings['layout_sec_lbl'];

		/*Template form fields label*/
		$temp_layout_field_lbl = $template_all_settings['layout_fields_lbl'];

		/*Template form button text*/
		$temp_layout_button_text = $template_all_settings['layout_Button_text'];

		/*Template layout styling option*/
		$temp_layout_styling_option = $template_all_settings['layout_style_option'];

		/*Template layout products*/
		$temp_layout_more_product = $template_all_settings['layout_more_prd'];

	}

	/*meta box tab*/
	$type = get_post_type();
	$post_id = get_the_ID();
	if(isset($_GET['action']) && $_GET['action'] == 'edit'){$action = $_GET['action'];}else{$action = "edit";}


	if (isset($_GET['tab']) && !empty($_GET['tab'])) {
		$tab = $_GET['tab'];
	} else {
		$tab = 'wacout_layout';
	}

	$menus = array();
	$menus['wacout_layout'] = __('Layout' , 'wacout');
	$menus['wacout_cms_sec'] = __('Custom Sections' , 'wacout');
	$menus['wacout_fld_clr'] = __( 'Fields & Colors' , 'wacout' );
	$menus['wacout_product'] = __( 'Products' , 'wacout' );

	$menus = apply_filters('wacout_extand_layout_setting_menus', $menus);


?>
<div id="wacout_metabox_content">
	<div class="wacout_metabox_tabs_sidebar">
		<ul class="nav wacout_metabox_tabs_ul">
			<?php

				$i = 0;
				foreach ($menus as $key => $menu) {
					$i++;
					if(isset($_GET['action']) && $_GET['action'] == 'edit'){
						$tab_url = add_query_arg(array(
						'post' =>	absint($post_id),
						'action' => esc_html($action),
						'tab' => esc_html($key),
						), admin_url('post.php'));
						$create_post = "";
					}else{
						$tab_url = "#wacout_metabox_side_tab".$i;
						$create_post = "tab";
					}
				?>
				<li>
					<a class="wacout_side_tab <?php if (esc_html($tab) == esc_html($key)) echo 'active'; ?>" href="<?php echo esc_url($tab_url); ?>" data-toggle="<?php echo esc_attr($create_post);?>"><?php echo esc_html($menu); ?></a>
				</li>
				<?php
				}
				?>
		</ul>
		<?php
		$tab_url_new = add_query_arg(array(
					'post' =>	absint($post_id),
					'action' => esc_html($action),
					'tab' => esc_html($tab),
				), admin_url('post.php'));
		?>
			<input type="hidden" name="wacout_tab_url" id="wacout_tab_url" value="<?php echo esc_url($tab_url_new); ?>">
	</div>
	<div class="wacout_metabox_tabs_content">
		<div class="tab-content">
			<!-- layout section start-->
			<div class="tab-pane <?php if(esc_html($tab) == "wacout_layout"){echo "active";}?>" id="wacout_metabox_side_tab1">
				<?php

					/*
					** check if select layout value is not empty
					* @selection value maybe 0,1,2
					*/
				   if(isset($temp_layout_selection) && !empty($temp_layout_selection)){

					   $select_lay = sanitize_text_field($temp_layout_selection);

				   }else{
					   $select_lay = '';
				   }
				?>

				<div class="wacout_select_layout_div">
					<div class="wacout_select_layout_in">
						<div class="wacout_select_layout_lbl"><?php _e('Select layout','wacout');?></div>
						<select name='wacout_select_layout' id="wacout_select_layout">
							<option <?php if(absint($select_lay) == 0){echo "selected";}?> value="0"><?php _e('-- Select layout --' , 'wacout') ;?></option>
							<option <?php if(absint($select_lay) == 1){echo "selected";}?> value="1"><?php _e('One column layout' , 'wacout') ;?></option>
							<option <?php if(absint($select_lay) == 2){echo "selected";}?> value="2"><?php _e('Two column layout' , 'wacout') ;?></option>
						</select>
					</div>
				</div>


				<!-- one column layout-->
				<div id="wacout_one_column" <?php if(absint($select_lay) == 1){echo "style='display:block'";}else{echo "style='display:none'";}?> >
					<ul id="one_column_sortable">
						<?php
							/*
							** Check if sorting layout setting is not empty
							*/
							if(isset($temp_layout_sorting) && !empty($temp_layout_sorting)){

								$template_layout_fields = explode(",",sanitize_text_field($temp_layout_sorting));

							/*
							**Start foreach
							*/
							foreach($template_layout_fields as $template_layout_field):

								if(isset($template_layout_field) && !empty($template_layout_field)):

									$template_field_label = str_replace("_"," ",sanitize_text_field($template_layout_field));

									echo '<li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>'.esc_html($template_field_label).'</li>';

								endif;

							endforeach;
						?>
						<input type="hidden" name="wacout_template_layout" id="wacout_template_layout" value="<?php echo esc_attr($temp_layout_sorting);?>"><?php

						}else{
							$default_sorting_settings = array('Billing fields','Shipping fields','Order details','Payment information','Related products','Custom Section A','Custom Section B','Custom Section C');
							foreach($default_sorting_settings as $default_sorting_setting):

								echo '<li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>'.esc_html($default_sorting_setting).'</li>';

							endforeach;?>
							<input type="hidden" name="wacout_template_layout" id="wacout_template_layout" value="billing_fields,shipping_fields,order_details,payment_information,related_products,custom_section_a,custom_section_b,custom_section_c">
						<?php }
						?>
					</ul>
				</div>
				<!-- two column layout-->
				<div id="wacout_two_column" <?php if(absint($select_lay) == 2){echo "style='display:block'";}else{echo "style='display:none'";}?>>
					<ul id="wacout_column_left" class="connectedSortable">
						<?php

							if(isset($temp_layout_position['wacout_template_left']) && !empty($temp_layout_position['wacout_template_left'])){
								$temp_layout_left_psn = sanitize_text_field($temp_layout_position['wacout_template_left']);
								$temp_layout_left_positions = explode(",",$temp_layout_left_psn);
								foreach($temp_layout_left_positions as $temp_layout_left_position){
									$template_layouts = str_replace("_"," ",$temp_layout_left_position);
									echo '<li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>'.esc_html($template_layouts).'</li>';
								}
						?>
						<input type="hidden" name="layout_pos[wacout_template_left]" id="wacout_template_left" value="<?php echo esc_attr($temp_layout_left_psn);?>"><?php

						}else{
							$default_layout_settings = array('Billing fields','Shipping fields','Related products','Custom Section A');
							foreach($default_layout_settings as $default_layout_setting){
								echo '<li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>'.esc_html($default_layout_setting).'</li>';
							}
						?>
						<input type="hidden" name="layout_pos[wacout_template_left]" id="wacout_template_left" value="billing_fields,shipping_fields,related_products,custom_section_a">
						<?php }?>

					</ul>
					<ul id="wacout_column_right" class="connectedSortable">
						<?php

							if(isset($temp_layout_position['wacout_template_right']) && !empty($temp_layout_position['wacout_template_right'])){
								$temp_layout_right_psn = sanitize_text_field($temp_layout_position['wacout_template_right']);
								$temp_layout_right_positions = explode(",",$temp_layout_right_psn);
								foreach($temp_layout_right_positions as $temp_layout_right_position){
									$template_layouts = str_replace("_"," ",$temp_layout_right_position);
									echo '<li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>'.esc_html($template_layouts).'</li>';
								}
						?>
						<input type="hidden" name="layout_pos[wacout_template_right]" id="wacout_template_right" value="<?php echo esc_attr($temp_layout_right_psn);?>"><?php
							}else{
							$layout_setting = array('Order details','Payment information','Custom Section B','Custom Section C');
							foreach($layout_setting as $layout_settings){
							echo '<li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>'.esc_html($layout_settings).'</li>';
							}?>
						<input type="hidden" name="layout_pos[wacout_template_right]" id="wacout_template_right" value="order_details,payment_information,custom_section_b,custom_section_c">
						<?php }?>
					</ul>
					<div class="clear"></div>
				</div>
			</div>
			<!-- layout section end-->
			<!-- layout custom section start-->
			<div class="tab-pane <?php if(esc_html($tab) == "wacout_cms_sec"){echo "active";}?>" id="wacout_metabox_side_tab2">
				<div class="wacout_custom_section_tab">
					<?php
						/*
						** Check if for custom section label is not empty
						*/
						if(isset($temp_layout_custom_sec['wacout_cstm_sec1']) && !empty($temp_layout_custom_sec['wacout_cstm_sec1'])){
						 $wacout_cstm_sec1_ttl = sanitize_text_field($temp_layout_custom_sec['wacout_cstm_sec1']);
						} else{ $wacout_cstm_sec1_ttl = ""; }

						if(isset($temp_layout_custom_sec['wacout_cstm_sec2']) && !empty($temp_layout_custom_sec['wacout_cstm_sec2'])){
						 $wacout_cstm_sec2_ttl = sanitize_text_field($temp_layout_custom_sec['wacout_cstm_sec2']);
						} else{ $wacout_cstm_sec2_ttl = ""; }

						if(isset($temp_layout_custom_sec['wacout_cstm_sec3']) && !empty($temp_layout_custom_sec['wacout_cstm_sec3'])){
						 $wacout_cstm_sec3_ttl = sanitize_text_field($temp_layout_custom_sec['wacout_cstm_sec3']);
						} else{ $wacout_cstm_sec3_ttl = ""; }

					?>
					<div class="wacout_cstm_sec1 cstm_sec">
						<h3><?php _e('Custom Section A' , 'wacout') ;?></h3>
						<div class="cstm_sec_group mb_20">
							<div class="cstm_sec_in">
								<div class="cstm_sec_lbl"><?php _e('Title' , 'wacout') ;?></div>
								<input class="cstm_sec_ctrl" type="text" name="wacout_custom_sections[wacout_cstm_sec1]" value="<?php echo esc_attr($wacout_cstm_sec1_ttl); ?>">
							</div>
						</div>
						<div class="cstm_sec_group mb_20">
							<div class="cstm_sec_in">
								<div class="cstm_sec_lbl"><?php _e('Description' , 'wacout') ;?></div>
								<?php
									/*
									** Check if custom section a description in not empty
									*/
								   if(isset($temp_layout_custom_sec['wacout_csec_wp_editor1']) && !empty($temp_layout_custom_sec['wacout_csec_wp_editor1'])){
									   $wacout_cstm_sec1_edtr1 = wp_kses_post($temp_layout_custom_sec['wacout_csec_wp_editor1']);
								   } else{ $wacout_cstm_sec1_edtr1 = ""; }

								   $editor_id = 'wacout_csec_wp_editor1';
								   $option_name='wacout_csec_wp_editor1';
								   wp_editor( wp_kses_post($wacout_cstm_sec1_edtr1), $editor_id,array('textarea_name' => $option_name,'media_buttons' => true,'editor_height' => 100,'tinymce' => array(
									   'theme_advanced_buttons1' => 'formatselect,|,bold,italic,underline,|,' .
									   'bullist,blockquote,|,justifyleft,justifycenter' .
									   ',justifyright,justifyfull,|,link,unlink,|' .
									   ',spellchecker,wp_fullscreen,wp_adv'
								   ))  );
								?>
							</div>
						</div>
					</div>
					<div class="wacout_cstm_sec2 cstm_sec">
						<h3><?php _e('Custom Section B' , 'wacout') ;?></h3>
						<div class="cstm_sec_group mb_20">
							<div class="cstm_sec_in">
								<div class="cstm_sec_lbl"><?php _e('Title' , 'wacout') ;?></div>
								<input class="cstm_sec_ctrl" type="text" name="wacout_custom_sections[wacout_cstm_sec2]" value="<?php echo esc_attr($wacout_cstm_sec2_ttl); ?>">
							</div>
						</div>
						<div class="cstm_sec_group mb_20">
							<div class="cstm_sec_in">
								<div class="cstm_sec_lbl"><?php _e('Description' , 'wacout') ;?></div>
								<?php
									/*
									** Check if custom section b description in not empty
									*/
								   if(isset($temp_layout_custom_sec['wacout_csec_wp_editor2']) && !empty($temp_layout_custom_sec['wacout_csec_wp_editor2'])){
									   $wacout_cstm_sec1_edtr2 = wp_kses_post($temp_layout_custom_sec['wacout_csec_wp_editor2']);
								   } else{ $wacout_cstm_sec1_edtr2 = ""; }

								   $editor_id = 'wacout_csec_wp_editor2';
								   $option_name='wacout_csec_wp_editor2';
								   wp_editor( wp_kses_post($wacout_cstm_sec1_edtr2), $editor_id,array('textarea_name' => $option_name,'media_buttons' => true,'editor_height' => 100,'tinymce' => array(
									   'theme_advanced_buttons1' => 'formatselect,|,bold,italic,underline,|,' .
									   'bullist,blockquote,|,justifyleft,justifycenter' .
									   ',justifyright,justifyfull,|,link,unlink,|' .
									   ',spellchecker,wp_fullscreen,wp_adv'
								   ))  );
								?>
							</div>
						</div>
					</div>
					<div class="wacout_cstm_sec3 cstm_sec">
						<h3><?php _e('Custom Section C' , 'wacout') ;?></h3>
						<div class="cstm_sec_group mb_20">
							<div class="cstm_sec_in">
								<div class="cstm_sec_lbl"><?php _e('Title' , 'wacout') ;?></div>
								<input class="cstm_sec_ctrl" type="text" name="wacout_custom_sections[wacout_cstm_sec3]" value="<?php echo esc_attr($wacout_cstm_sec3_ttl); ?>">
							</div>
						</div>
						<div class="cstm_sec_group mb_20">
							<div class="cstm_sec_in">
								<div class="cstm_sec_lbl"><?php _e('Description' , 'wacout') ;?></div>
								<?php
									/*
									** Check if custom section c description in not empty
									*/
								   if(isset($temp_layout_custom_sec['wacout_csec_wp_editor3']) && !empty($temp_layout_custom_sec['wacout_csec_wp_editor3'])){
									   $wacout_cstm_sec1_edtr3 = wp_kses_post($temp_layout_custom_sec['wacout_csec_wp_editor3']);
								   } else{ $wacout_cstm_sec1_edtr3 = ""; }

								   $editor_id = 'wacout_csec_wp_editor3';
								   $option_name='wacout_csec_wp_editor3';
								   wp_editor( wp_kses_post($wacout_cstm_sec1_edtr3), $editor_id,array('textarea_name' => $option_name,'media_buttons' => true,'editor_height' => 100,'tinymce' => array(
									   'theme_advanced_buttons1' => 'formatselect,|,bold,italic,underline,|,' .
									   'bullist,blockquote,|,justifyleft,justifycenter' .
									   ',justifyright,justifyfull,|,link,unlink,|' .
									   ',spellchecker,wp_fullscreen,wp_adv'
								   ))  );
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- layout custom section end-->
			<!-- layout fields and colors section start-->
			<div class="tab-pane <?php if(esc_html($tab) == "wacout_fld_clr"){echo "active";}?>" id="wacout_metabox_side_tab3">
				<div class="wacout_layout_stng_sidebar">
					<ul class="nav wacout_stng_nav">
						<li><a href="#wacout_metabox_layout_tab1" class="wacout_side_tab active" data-toggle="tab"><?php _e('Sections Heading' , 'wacout') ;?></a></li>
						<li><a href="#wacout_metabox_layout_tab2" class="wacout_side_tab" data-toggle="tab"><?php _e('Fields Settings' , 'wacout') ;?></a></li>
						<li><a href="#wacout_metabox_layout_tab3" class="wacout_side_tab" data-toggle="tab"><?php _e( 'Color options' , 'wacout' ) ;?></a></li>
						<li><a href="#wacout_metabox_layout_tab4" class="wacout_side_tab" data-toggle="tab"><?php _e( 'Button Settings' , 'wacout' ) ;?></a></li>
					</ul>
				</div>
				<div class="wacout_layout_stng_cntnt">
					<!-- start general setting-->
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="wacout_metabox_layout_tab1">
							<div class="tabpane_inner">
								<?php
								   if(isset($temp_layout_section_label['wacout_billing_heading']) && !empty($temp_layout_section_label['wacout_billing_heading'])){
									   $billing = sanitize_text_field($temp_layout_section_label['wacout_billing_heading']);
								   } else{ $billing = ""; }


								   if(isset($temp_layout_section_label['wacout_shipping_heading']) && !empty($temp_layout_section_label['wacout_shipping_heading'])){
									   $shipping = sanitize_text_field($temp_layout_section_label['wacout_shipping_heading']);
								   } else{ $shipping = ""; }

								   if(isset($temp_layout_section_label['wacout_order_heading']) && !empty($temp_layout_section_label['wacout_order_heading'])){
									   $order = sanitize_text_field($temp_layout_section_label['wacout_order_heading']);
								   } else{ $order = ""; }

								   if(isset($temp_layout_section_label['wacout_related_heading']) && !empty($temp_layout_section_label['wacout_related_heading'])){
									   $related = sanitize_text_field($temp_layout_section_label['wacout_related_heading']);
								   } else{ $related = ""; }

								   if(isset($temp_layout_section_label['wacout_payment_heading']) && !empty($temp_layout_section_label['wacout_payment_heading'])){
									   $payment = sanitize_text_field($temp_layout_section_label['wacout_payment_heading']);
								   } else{ $payment = ""; }

								?>
								<h3><?php _e('Sections Heading' , 'wacout') ;?></h3>
								<div class="form-table">
									<div class="fm_group mb_20">
										<div class="fm_in">
											<div class="fm_lbl"><?php _e('Billing' , 'wacout') ;?></div>
											<input class="fm_ctrl" type="text" name="wacout_sec_lbl[wacout_billing_heading]" value="<?php echo esc_attr($billing); ?>" />
										</div>
									</div>
									<div class="fm_group mb_20">
										<div class="fm_in">
											<div class="fm_lbl"><?php _e('Shipping' , 'wacout') ;?></div>
											<input class="fm_ctrl" type="text" name="wacout_sec_lbl[wacout_shipping_heading]" value="<?php echo esc_attr($shipping); ?>" />
										</div>
									</div>
									<div class="fm_group mb_20">
										<div class="fm_in">
											<div class="fm_lbl"><?php _e('Order Details' , 'wacout') ;?></div>
											<input class="fm_ctrl" type="text" name="wacout_sec_lbl[wacout_order_heading]" value="<?php echo esc_attr($order); ?>" />
										</div>
									</div>
									<div class="fm_group mb_20">
										<div class="fm_in">
											<div class="fm_lbl"><?php _e('Related Product' , 'wacout') ;?></div>
											<td>
												<input class="fm_ctrl" type="text" name="wacout_sec_lbl[wacout_related_heading]" value="<?php echo esc_attr($related); ?>" />
										</div>
									</div>
									<div class="fm_group">
										<div class="fm_in">
											<div class="fm_lbl"><?php _e('Payment Information' , 'wacout') ;?></div>
											<input class="fm_ctrl" type="text" name="wacout_sec_lbl[wacout_payment_heading]" value="<?php echo esc_attr($payment); ?>" />
										</div>
									</div>
								</div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane" id="wacout_metabox_layout_tab2">
							<div class="tabpane_inner">
								<?php

								   /*
								   ** Fields Custom label
								   */
								   if(isset($temp_layout_field_lbl['billing_first_name']) && !empty($temp_layout_field_lbl['billing_first_name'])){ $wacout_billing_first_name = sanitize_text_field($temp_layout_field_lbl['billing_first_name']); } else{ $wacout_billing_first_name = ""; }

								   if(isset($temp_layout_field_lbl['billing_last_name']) && !empty($temp_layout_field_lbl['billing_last_name'])){ $wacout_billing_last_name = sanitize_text_field($temp_layout_field_lbl['billing_last_name']); } else{ $wacout_billing_last_name = ""; }

								   if(isset($temp_layout_field_lbl['billing_company']) && !empty($temp_layout_field_lbl['billing_company'])){ $wacout_billing_company = sanitize_text_field($temp_layout_field_lbl['billing_company']); } else{ $wacout_billing_company = ""; }

								   if(isset($temp_layout_field_lbl['billing_country']) && !empty($temp_layout_field_lbl['billing_country'])){ $wacout_billing_country = sanitize_text_field($temp_layout_field_lbl['billing_country']); } else{ $wacout_billing_country = ""; }

								   if(isset($temp_layout_field_lbl['billing_phone']) && !empty($temp_layout_field_lbl['billing_phone'])){ $wacout_billing_phone = sanitize_text_field($temp_layout_field_lbl['billing_phone']); } else{ $wacout_billing_phone = ""; }

								   if(isset($temp_layout_field_lbl['billing_email']) && !empty($temp_layout_field_lbl['billing_email'])){ $wacout_billing_email = sanitize_text_field($temp_layout_field_lbl['billing_email']); } else{ $wacout_billing_email = ""; }

								   if(isset($temp_layout_field_lbl['shipping_first_name']) && !empty($temp_layout_field_lbl['shipping_first_name'])){ $wacout_shipping_first_name = sanitize_text_field($temp_layout_field_lbl['shipping_first_name']); } else{ $wacout_shipping_first_name = ""; }

								   if(isset($temp_layout_field_lbl['shipping_last_name']) && !empty($temp_layout_field_lbl['shipping_last_name'])){ $wacout_shipping_last_name = sanitize_text_field($temp_layout_field_lbl['shipping_last_name']); } else{ $wacout_shipping_last_name = ""; }

								   if(isset($temp_layout_field_lbl['shipping_company']) && !empty($temp_layout_field_lbl['shipping_company'])){ $wacout_shipping_company = sanitize_text_field($temp_layout_field_lbl['shipping_company']); } else{ $wacout_shipping_company = ""; }

								   if(isset($temp_layout_field_lbl['shipping_country']) && !empty($temp_layout_field_lbl['shipping_country'])){ $wacout_shipping_country = sanitize_text_field($temp_layout_field_lbl['shipping_country']); } else{ $wacout_shipping_country = ""; }

								   if(isset($temp_layout_field_lbl['address_1']) && !empty($temp_layout_field_lbl['address_1'])){ $wacout_address_1 = sanitize_text_field($temp_layout_field_lbl['address_1']); } else{ $wacout_address_1 = ""; }

								   if(isset($temp_layout_field_lbl['city']) && !empty($temp_layout_field_lbl['city'])){ $wacout_city = sanitize_text_field($temp_layout_field_lbl['city']); } else{ $wacout_city = ""; }

								   if(isset($temp_layout_field_lbl['state']) && !empty($temp_layout_field_lbl['state'])){ $wacout_state = sanitize_text_field($temp_layout_field_lbl['state']); } else{ $wacout_state = ""; }

								   if(isset($temp_layout_field_lbl['postcode']) && !empty($temp_layout_field_lbl['postcode'])){ $wacout_postcode = sanitize_text_field($temp_layout_field_lbl['postcode']); } else{ $wacout_postcode = ""; }


								    /*
								   ** Fields Custom Class
								   */
								   if(isset($temp_layout_field_lbl['fields_class']['billing_first_name_class']) && !empty($temp_layout_field_lbl['fields_class']['billing_first_name_class'])){ $wacout_billing_first_name_class = sanitize_html_class($temp_layout_field_lbl['fields_class']['billing_first_name_class']); } else{ $wacout_billing_first_name_class = ""; }

								   if(isset($temp_layout_field_lbl['fields_class']['billing_last_name_class']) && !empty($temp_layout_field_lbl['fields_class']['billing_last_name_class'])){ $wacout_billing_last_name_class = sanitize_html_class($temp_layout_field_lbl['fields_class']['billing_last_name_class']); } else{ $wacout_billing_last_name_class = ""; }

								   if(isset($temp_layout_field_lbl['fields_class']['billing_company_class']) && !empty($temp_layout_field_lbl['fields_class']['billing_company_class'])){ $wacout_billing_company_class = sanitize_html_class($temp_layout_field_lbl['fields_class']['billing_company_class']); } else{ $wacout_billing_company_class = ""; }

								   if(isset($temp_layout_field_lbl['fields_class']['billing_country_class']) && !empty($temp_layout_field_lbl['fields_class']['billing_country_class'])){ $wacout_billing_country_class = sanitize_html_class($temp_layout_field_lbl['fields_class']['billing_country_class']); } else{ $wacout_billing_country_class = ""; }

								   if(isset($temp_layout_field_lbl['fields_class']['billing_phone_class']) && !empty($temp_layout_field_lbl['fields_class']['billing_phone_class'])){ $wacout_billing_phone_class = sanitize_html_class($temp_layout_field_lbl['fields_class']['billing_phone_class']); } else{ $wacout_billing_phone_class = ""; }

								   if(isset($temp_layout_field_lbl['fields_class']['billing_email_class']) && !empty($temp_layout_field_lbl['fields_class']['billing_email_class'])){ $wacout_billing_email_class = sanitize_html_class($temp_layout_field_lbl['fields_class']['billing_email_class']); } else{ $wacout_billing_email_class = ""; }

								   if(isset($temp_layout_field_lbl['fields_class']['shipping_first_name_class']) && !empty($temp_layout_field_lbl['fields_class']['shipping_first_name_class'])){ $wacout_shipping_first_name_class = sanitize_html_class($temp_layout_field_lbl['fields_class']['shipping_first_name_class']); } else{ $wacout_shipping_first_name_class = ""; }

								   if(isset($temp_layout_field_lbl['fields_class']['shipping_last_name_class']) && !empty($temp_layout_field_lbl['fields_class']['shipping_last_name_class'])){ $wacout_shipping_last_name_class = sanitize_html_class($temp_layout_field_lbl['fields_class']['shipping_last_name_class']); } else{ $wacout_shipping_last_name_class = ""; }

								   if(isset($temp_layout_field_lbl['fields_class']['shipping_company_class']) && !empty($temp_layout_field_lbl['fields_class']['shipping_company_class'])){ $wacout_shipping_company_class = sanitize_html_class($temp_layout_field_lbl['fields_class']['shipping_company_class']); } else{ $wacout_shipping_company_class = ""; }

								   if(isset($temp_layout_field_lbl['fields_class']['shipping_country_class']) && !empty($temp_layout_field_lbl['fields_class']['shipping_country_class'])){ $wacout_shipping_country_class = sanitize_html_class($temp_layout_field_lbl['fields_class']['shipping_country_class']); } else{ $wacout_shipping_country_class = ""; }

								   if(isset($temp_layout_field_lbl['fields_class']['address_1_class']) && !empty($temp_layout_field_lbl['fields_class']['address_1_class'])){ $wacout_address_1_class = sanitize_html_class($temp_layout_field_lbl['fields_class']['address_1_class']); } else{ $wacout_address_1_class = ""; }

								   if(isset($temp_layout_field_lbl['fields_class']['city_class']) && !empty($temp_layout_field_lbl['fields_class']['city_class'])){ $wacout_city_class = sanitize_html_class($temp_layout_field_lbl['fields_class']['city_class']); } else{ $wacout_city_class = ""; }

								   if(isset($temp_layout_field_lbl['fields_class']['state_class']) && !empty($temp_layout_field_lbl['fields_class']['state_class'])){ $wacout_state_class = sanitize_html_class($temp_layout_field_lbl['fields_class']['state_class']); } else{ $wacout_state_class = ""; }

								   if(isset($temp_layout_field_lbl['fields_class']['postcode_class']) && !empty($temp_layout_field_lbl['fields_class']['postcode_class'])){ $wacout_postcode_class = sanitize_html_class($temp_layout_field_lbl['fields_class']['postcode_class']); } else{ $wacout_postcode_class = ""; }


								  /*
								   ** Fields Required
								   */
								 $req_fields = get_post_meta( $meta_id->ID,'_wacout_fields_req',true );

								 if(isset($req_fields['billing_first_name_req']) && !empty($req_fields['billing_first_name_req'])){ $wacout_billing_first_name_req =  absint($req_fields['billing_first_name_req']); }else{ $wacout_billing_first_name_req = null; }

								 if(isset($req_fields['billing_last_name_req']) && !empty($req_fields['billing_last_name_req'])){ $wacout_billing_last_name_req =  absint($req_fields['billing_last_name_req']); }else{ $wacout_billing_last_name_req = null; }

								 if(isset($req_fields['billing_company_req']) && !empty($req_fields['billing_company_req'])){ $wacout_billing_company_req =  absint($req_fields['billing_company_req']); }else{ $wacout_billing_company_req = null; }

								 if(isset($req_fields['billing_country_req']) && !empty($req_fields['billing_country_req'])){ $wacout_billing_country_req =  absint($req_fields['billing_country_req']); }else{ $wacout_billing_country_req = null; }

								 if(isset($req_fields['billing_phone_req']) && !empty($req_fields['billing_phone_req'])){ $wacout_billing_phone_req =  absint($req_fields['billing_phone_req']); }else{ $wacout_billing_phone_req = null; }

								 if(isset($req_fields['billing_email_req']) && !empty($req_fields['billing_email_req'])){ $wacout_billing_email_req =  absint($req_fields['billing_email_req']); }else{ $wacout_billing_email_req = null; }

								 if(isset($req_fields['shipping_first_name_req']) && !empty($req_fields['shipping_first_name_req'])){ $wacout_shipping_first_name_req =  absint($req_fields['shipping_first_name_req']); }else{ $wacout_shipping_first_name_req = null; }

								 if(isset($req_fields['shipping_last_name_req']) && !empty($req_fields['shipping_last_name_req'])){ $wacout_shipping_last_name_req =  absint($req_fields['shipping_last_name_req']); }else{ $wacout_shipping_last_name_req = null; }

								 if(isset($req_fields['shipping_company_req']) && !empty($req_fields['shipping_company_req'])){ $wacout_shipping_company_req =  absint($req_fields['shipping_company_req']); }else{ $wacout_shipping_company_req = null; }

								 if(isset($req_fields['shipping_country_req']) && !empty($req_fields['shipping_country_req'])){ $wacout_shipping_country_req =  absint($req_fields['shipping_country_req']); }else{ $wacout_shipping_country_req = null; }

								 if(isset($req_fields['address_1_req']) && !empty($req_fields['address_1_req'])){ $wacout_address_1_req =  absint($req_fields['address_1_req']); }else{ $wacout_address_1_req = null; }

								 if(isset($req_fields['city_req']) && !empty($req_fields['city_req'])){ $wacout_city_req =  absint($req_fields['city_req']); }else{ $wacout_city_req = null; }

								 if(isset($req_fields['state_req']) && !empty($req_fields['state_req'])){ $wacout_state_req =  absint($req_fields['state_req']); }else{ $wacout_state_req = null; }

								 if(isset($req_fields['postcode_req']) && !empty($req_fields['postcode_req'])){ $wacout_postcode_req =  absint($req_fields['postcode_req']); }else{ $wacout_postcode_req = null; }



								?>
								<div class="wacout_flds_lbls_wrap">
									<div class="tcol_row">
										<div class="tcol_2 mb2p5">
											<div class="tcol_in">
												<h3><?php _e('Billing Details Fields' , 'wacout') ;?></h3>
												<div class="form-table">
													<div class="fm_group mb_20">
														<div class="fm_in">
															<div class="fm_lbl"></div>
															<div class="fmf_vipt"><strong><?php _e('Label' , 'wacout') ;?></strong></div>
															<div class="fmf_vipt"><strong><?php _e('Class' , 'wacout') ;?></strong></div>
															<div class="fmf_viptreq"><strong><?php _e('Required?' , 'wacout') ;?></strong></div>
														</div>
													</div>
													<div class="fm_group mb_20">
														<div class="fm_in">
															<div class="fm_lbl"><?php _e('First name' , 'wacout') ;?></div>
															<div class="fmf_vipt">
																<input class="fm_ctrl" type="text" name="wacout_flds_lbls[billing_first_name]" value="<?php echo esc_attr($wacout_billing_first_name); ?>">

															</div>
															<div class="fmf_vipt">
																<input type="text" class="fm_ctrl" name="wacout_flds_lbls[fields_class][billing_first_name_class]" value="<?php echo esc_attr($wacout_billing_first_name_class); ?>">

															</div>
															<div class="fmf_viptreq">
																<label class="switch">
																	<input type="checkbox" class="required" name="fields_required[billing_first_name_req]" <?php checked( 1, esc_html($wacout_billing_first_name_req) ) ?> value="1"/>
																	<span class="slider round"></span>
																</label>

															</div>
														</div>
													</div>
													<div class="fm_group mb_20">
														<div class="fm_in">
															<div class="fm_lbl"><?php _e('Last name' , 'wacout') ;?></div>
															<div class="fmf_vipt"><input class="fm_ctrl" type="text" name="wacout_flds_lbls[billing_last_name]" value="<?php echo esc_attr($wacout_billing_last_name); ?>"></div>
															<div class="fmf_vipt">
																<input type="text" class="fm_ctrl" name="wacout_flds_lbls[fields_class][billing_last_name_class]" value="<?php echo esc_attr($wacout_billing_last_name_class); ?>">
															</div>
															<div class="fmf_viptreq">
																<label class="switch">
																	<input type="checkbox" class="required" name="fields_required[billing_last_name_req]" <?php checked( 1, esc_html($wacout_billing_last_name_req) ) ?> value="1"/>
																	<span class="slider round"></span>
																</label>
															</div>
														</div>
													</div>
													<div class="fm_group mb_20">
														<div class="fm_in">
															<div class="fm_lbl"><?php _e('Company name' , 'wacout') ;?></div>
															<div class="fmf_vipt"><input class="fm_ctrl" type="text" name="wacout_flds_lbls[billing_company]" value="<?php echo esc_attr($wacout_billing_company); ?>"></div>
															<div class="fmf_vipt">
																<input type="text" class="fm_ctrl" name="wacout_flds_lbls[fields_class][billing_company_class]" value="<?php echo esc_attr($wacout_billing_company_class); ?>">
															</div>
															<div class="fmf_viptreq">
																<label class="switch">
																	<input type="checkbox" class="required" name="fields_required[billing_company_req]" <?php checked( 1, esc_html($wacout_billing_company_req) ) ?> value="1"/>
																	<span class="slider round"></span>
																</label>
															</div>
														</div>
													</div>
													<div class="fm_group mb_20">
														<div class="fm_in">
															<div class="fm_lbl"><?php _e('Country / Region' , 'wacout') ;?></div>
															<div class="fmf_vipt"><input class="fm_ctrl" type="text" name="wacout_flds_lbls[billing_country]" value="<?php echo esc_attr($wacout_billing_country); ?>"></div>
															<div class="fmf_vipt">
																<input type="text" class="fm_ctrl" name="wacout_flds_lbls[fields_class][billing_country_class]" value="<?php echo esc_attr($wacout_billing_country_class); ?>">
															</div>
															<div class="fmf_viptreq">
																<label class="switch">
																	<input type="checkbox" class="required" name="fields_required[billing_country_req]" <?php checked( 1, esc_html($wacout_billing_country_req) ) ?> value="1"/>
																	<span class="slider round"></span>
																</label>
															</div>
														</div>
													</div>
													<div class="fm_group mb_20">
														<div class="fm_in">
															<div class="fm_lbl"><?php _e('Phone' , 'wacout') ;?></div>
															<div class="fmf_vipt"><input class="fm_ctrl" type="text" name="wacout_flds_lbls[billing_phone]" value="<?php echo esc_attr($wacout_billing_phone); ?>"></div>
															<div class="fmf_vipt">
																<input type="text" class="fm_ctrl" name="wacout_flds_lbls[fields_class][billing_phone_class]" value="<?php echo esc_attr($wacout_billing_phone_class); ?>">
															</div>
															<div class="fmf_viptreq">
																<label class="switch">
																	<input type="checkbox" class="required" name="fields_required[billing_phone_req]" <?php checked( 1, esc_html($wacout_billing_phone_req) ) ?> value="1"/>

																	<span class="slider round"></span>
																</label>
															</div>
														</div>
													</div>
													<div class="fm_group">
														<div class="fm_in">
															<div class="fm_lbl"><?php _e('Email address' , 'wacout') ;?></div>
															<div class="fmf_vipt"><input class="fm_ctrl" type="text" name="wacout_flds_lbls[billing_email]" value="<?php echo esc_attr($wacout_billing_email); ?>"></div>
															<div class="fmf_vipt">
																<input type="text" class="fm_ctrl" name="wacout_flds_lbls[fields_class][billing_email_class]" value="<?php echo esc_attr($wacout_billing_email_class); ?>">
															</div>
															<div class="fmf_viptreq">
																<label class="switch">
																	<input type="checkbox" class="required" name="fields_required[billing_email_req]" <?php checked( 1, esc_html($wacout_billing_email_req) ) ?> value="1"/>

																	<span class="slider round"></span>
																</label>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="tcol_2 mb2p5">
											<div class="tcol_in">
												<h3><?php _e('Shipping Details Fields' , 'wacout') ;?></h3>
												<div class="form-table">
													<div class="fm_group mb_20">
														<div class="fm_in">
															<div class="fm_lbl"></div>
															<div class="fmf_vipt"><strong><?php _e('Label' , 'wacout') ;?></strong></div>
															<div class="fmf_vipt"><strong><?php _e('Class' , 'wacout') ;?></strong></div>
															<div class="fmf_viptreq"><strong><?php _e('Required?' , 'wacout') ;?></strong></div>
														</div>
													</div>
													<div class="fm_group mb_20">
														<div class="fm_in">
															<div class="fm_lbl"><?php _e('First name' , 'wacout') ;?></div>
															<div class="fmf_vipt"><input class="fm_ctrl" type="text" name="wacout_flds_lbls[shipping_first_name]" value="<?php echo esc_attr($wacout_shipping_first_name); ?>"></div>
															<div class="fmf_vipt">
																<input type="text" class="fm_ctrl" name="wacout_flds_lbls[fields_class][shipping_first_name_class]" value="<?php echo esc_attr($wacout_shipping_first_name_class); ?>">
															</div>
															<div class="fmf_viptreq">
																<label class="switch">
																	<input type="checkbox" class="required" name="fields_required[shipping_first_name_req]" <?php checked( 1, esc_html($wacout_shipping_first_name_req) ) ?> value="1"/>

																	<span class="slider round"></span>
																</label>
															</div>
														</div>
													</div>
													<div class="fm_group mb_20">
														<div class="fm_in">
															<div class="fm_lbl"><?php _e('Last name' , 'wacout') ;?></div>
															<div class="fmf_vipt"><input class="fm_ctrl" type="text" name="wacout_flds_lbls[shipping_last_name]" value="<?php echo esc_attr($wacout_shipping_last_name); ?>"></div>
															<div class="fmf_vipt">
																<input type="text" class="fm_ctrl" name="wacout_flds_lbls[fields_class][shipping_last_name_class]" value="<?php echo esc_attr($wacout_shipping_last_name_class); ?>">
															</div>
															<div class="fmf_viptreq">
																<label class="switch">
																	<input type="checkbox" class="required" name="fields_required[shipping_last_name_req]" <?php checked( 1, esc_html($wacout_shipping_last_name_req) ) ?> value="1"/>

																	<span class="slider round"></span>
																</label>
															</div>
														</div>
													</div>
													<div class="fm_group mb_20">
														<div class="fm_in">
															<div class="fm_lbl"><?php _e('Company name' , 'wacout') ;?></div>
															<div class="fmf_vipt"><input class="fm_ctrl" type="text" name="wacout_flds_lbls[shipping_company]" value="<?php echo esc_attr($wacout_shipping_company); ?>"></div>
															<div class="fmf_vipt">
																<input type="text" class="fm_ctrl" name="wacout_flds_lbls[fields_class][shipping_company_class]" value="<?php echo esc_attr($wacout_shipping_company_class); ?>">
															</div>
															<div class="fmf_viptreq">
																<label class="switch">
																	<input type="checkbox" class="required" name="fields_required[shipping_company_req]" <?php checked( 1, esc_html($wacout_shipping_company_req) ) ?> value="1"/>
																	<span class="slider round"></span>
																</label>
															</div>
														</div>
													</div>
													<div class="fm_group">
														<div class="fm_in">
															<div class="fm_lbl"><?php _e('Country / Region' , 'wacout') ;?></div>
															<div class="fmf_vipt"><input class="fm_ctrl" type="text" name="wacout_flds_lbls[shipping_country]" value="<?php echo esc_attr($wacout_shipping_country); ?>"></div>
															<div class="fmf_vipt">
																<input type="text" class="fm_ctrl" name="wacout_flds_lbls[fields_class][shipping_country_class]" value="<?php echo esc_attr($wacout_shipping_country_class); ?>">
															</div>
															<div class="fmf_viptreq">
																<label class="switch">
																	<input type="checkbox" class="required" name="fields_required[shipping_country_req]" <?php checked( 1, esc_html($wacout_shipping_country_req) ) ?> value="1"/>
																	<span class="slider round"></span>
																</label>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="tcol_2">
											<div class="tcol_in">
												<h3><?php _e('Common Fields' , 'wacout') ;?></h3>
												<div class="form-table">
													<div class="fm_group mb_20">
														<div class="fm_in">
															<div class="fm_lbl"></div>
															<div class="fmf_vipt"><strong><?php _e('Label' , 'wacout') ;?></strong></div>
															<div class="fmf_vipt"><strong><?php _e('Class' , 'wacout') ;?></strong></div>
															<div class="fmf_viptreq"><strong><?php _e('Required?' , 'wacout') ;?></strong></div>
														</div>
													</div>
													<div class="fm_group mb_20">
														<div class="fm_in">
															<div class="fm_lbl"><?php _e('Street address' , 'wacout') ;?></div>
															<div class="fmf_vipt"><input class="fm_ctrl" type="text" name="wacout_flds_lbls[address_1]" value="<?php echo esc_attr($wacout_address_1); ?>"></div>
															<div class="fmf_vipt">
																<input type="text" class="fm_ctrl" name="wacout_flds_lbls[fields_class][address_1_class]" value="<?php echo esc_attr($wacout_address_1_class); ?>">
															</div>
															<div class="fmf_viptreq">
																<label class="switch">
																	<input type="checkbox" class="required" name="fields_required[address_1_req]" <?php checked( 1, esc_html($wacout_address_1_req) ) ?> value="1"/>
																	<span class="slider round"></span>
																</label>
															</div>
														</div>
													</div>
													<div class="fm_group mb_20">
														<div class="fm_in">
															<div class="fm_lbl"><?php _e('Town / City' , 'wacout') ;?></div>
															<div class="fmf_vipt"><input class="fm_ctrl" type="text" name="wacout_flds_lbls[city]" value="<?php echo esc_attr($wacout_city); ?>"></div>
															<div class="fmf_vipt">
																<input type="text" class="fm_ctrl" name="wacout_flds_lbls[fields_class][city_class]" value="<?php echo esc_attr($wacout_city_class); ?>">
															</div>
															<div class="fmf_viptreq">
																<label class="switch">
																	<input type="checkbox" class="required" name="fields_required[city_req]" <?php checked( 1, esc_html($wacout_city_req) ) ?> value="1"/>
																	<span class="slider round"></span>
																</label>
															</div>
														</div>
													</div>
													<div class="fm_group mb_20">
														<div class="fm_in">
															<div class="fm_lbl"><?php _e('State' , 'wacout') ;?></div>
															<div class="fmf_vipt"><input class="fm_ctrl" type="text" name="wacout_flds_lbls[state]" value="<?php echo esc_attr($wacout_state); ?>"></div>
															<div class="fmf_vipt">
																<input type="text" class="fm_ctrl" name="wacout_flds_lbls[fields_class][state_class]" value="<?php echo esc_attr($wacout_state_class); ?>">
															</div>
															<div class="fmf_viptreq">
																<label class="switch">
																	<input type="checkbox" class="required" name="fields_required[state_req]" <?php checked( 1, esc_html($wacout_state_req) ) ?> value="1"/>
																	<span class="slider round"></span>
																</label>
															</div>
														</div>
													</div>
													<div class="fm_group">
														<div class="fm_in">
															<div class="fm_lbl"><?php _e('ZIP' , 'wacout') ;?></div>
															<div class="fmf_vipt"><input class="fm_ctrl" type="text" name="wacout_flds_lbls[postcode]" value="<?php echo esc_attr($wacout_postcode); ?>"></div>
															<div class="fmf_vipt">
																<input type="text" class="fm_ctrl" name="wacout_flds_lbls[fields_class][postcode_class]" value="<?php echo esc_attr($wacout_postcode_class); ?>">
															</div>
															<div class="fmf_viptreq">
																<label class="switch">
																	<input type="checkbox" class="required" name="fields_required[postcode_req]" <?php checked( 1, esc_html($wacout_postcode_req) ) ?> value="1"/>
																	<span class="slider round"></span>
																</label>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane" id="wacout_metabox_layout_tab3">
							<div class="tabpane_inner">
								<?php

								  if(isset($temp_layout_styling_option['one_column_styling']['one_column_width']) && !empty($temp_layout_styling_option['one_column_styling']['one_column_width'])){ $wacout_one_column_width = absint($temp_layout_styling_option['one_column_styling']['one_column_width']); } else{ $wacout_one_column_width = "500"; }


								   if(isset($temp_layout_styling_option['section_style']['sec_bdr_width']) && !empty($temp_layout_styling_option['section_style']['sec_bdr_width'])){ $wacout_sec_bdr_width = absint($temp_layout_styling_option['section_style']['sec_bdr_width']); } elseif(isset($temp_layout_styling_option['section_style']['sec_bdr_width']) && ($temp_layout_styling_option['section_style']['sec_bdr_width'] == 0) ){$wacout_sec_bdr_width = "0";}else{ $wacout_sec_bdr_width = "6"; }

								   if(isset($temp_layout_styling_option['section_style']['sec_padding']) && !empty($temp_layout_styling_option['section_style']['sec_padding'])){ $wacout_sec_padding = absint($temp_layout_styling_option['section_style']['sec_padding']); }else{ $wacout_sec_padding = "30"; }

								   if(isset($temp_layout_styling_option['heading_style']['hd_background']) && !empty($temp_layout_styling_option['heading_style']['hd_background'])){ $wacout_hd_background = sanitize_hex_color($temp_layout_styling_option['heading_style']['hd_background']); } else{ $wacout_hd_background = "#007ead"; }

								   if(isset($temp_layout_styling_option['heading_style']['hd_font_color']) && !empty($temp_layout_styling_option['heading_style']['hd_font_color'])){ $wacout_hd_font_color = sanitize_hex_color($temp_layout_styling_option['heading_style']['hd_font_color']); } else{ $wacout_hd_font_color = "#ffffff"; }

								   if(isset($temp_layout_styling_option['heading_style']['hd_font_size']) && !empty($temp_layout_styling_option['heading_style']['hd_font_size'])){ $wacout_hd_font_size = absint($temp_layout_styling_option['heading_style']['hd_font_size']); } else{ $wacout_hd_font_size = "24"; }

								   if(isset($temp_layout_styling_option['form_fields_style']['lbl_font_color']) && !empty($temp_layout_styling_option['form_fields_style']['lbl_font_color'])){ $wacout_lbl_font_color = sanitize_hex_color($temp_layout_styling_option['form_fields_style']['lbl_font_color']); } else{ $wacout_lbl_font_color = "#343434"; }

								   if(isset($temp_layout_styling_option['form_fields_style']['lbl_font_size']) && !empty($temp_layout_styling_option['form_fields_style']['lbl_font_size'])){ $wacout_lbl_font_size = absint($temp_layout_styling_option['form_fields_style']['lbl_font_size']); } else{ $wacout_lbl_font_size = "18"; }

								   if(isset($temp_layout_styling_option['form_fields_style']['fld_bdr_color']) && !empty($temp_layout_styling_option['form_fields_style']['fld_bdr_color'])){ $wacout_fld_bdr_color = sanitize_hex_color($temp_layout_styling_option['form_fields_style']['fld_bdr_color']); } else{ $wacout_fld_bdr_color = "#e2e2e2"; }

								   if(isset($temp_layout_styling_option['form_fields_style']['fld_bdr_size']) && !empty($temp_layout_styling_option['form_fields_style']['fld_bdr_size'])){ $wacout_fld_bdr_size = absint($temp_layout_styling_option['form_fields_style']['fld_bdr_size']); } else{ $wacout_fld_bdr_size = "2"; }

								?>
								<h3><?php _e('One Column Styling' , 'wacout') ;?></h3>
								<div class="form-table wacout_clr_opt">
									<div class="fm_group">
										<div class="fm_in">
											<div class="fm_lbl"><?php _e('Width' , 'wacout') ;?></div>
											<div class="wacout_range_slider fm_ctrl">
												<input class="wacout_rs" type="range" value="<?php echo esc_attr($wacout_one_column_width); ?>" name="wacout_layout_styling[one_column_styling][one_column_width]" min="400" max="1170">
												<span class="wacout_rsv"><?php esc_html_e($wacout_one_column_width)?></span>
											</div>
										</div>
									</div>
								</div>

								<h3><?php _e('Section style' , 'wacout') ;?></h3>
								<div class="form-table wacout_clr_opt">
									<div class="fm_group mb_20">
										<div class="fm_in">
											<div class="fm_lbl"><?php _e('Section border width' , 'wacout') ;?></div>
											<div class="wacout_range_slider fm_ctrl">
												<input class="wacout_rs" type="range" value="<?php echo esc_attr($wacout_sec_bdr_width); ?>" name="wacout_layout_styling[section_style][sec_bdr_width]" min="0" max="10">
												<span class="wacout_rsv"><?php esc_html_e($wacout_sec_bdr_width)?></span>
											</div>
										</div>
									</div>
									<div class="fm_group">
										<div class="fm_in">
											<div class="fm_lbl"><?php _e('Section padding' , 'wacout') ;?></div>
											<div class="wacout_range_slider fm_ctrl">
												<input class="wacout_rs" type="range" value="<?php echo esc_attr($wacout_sec_padding); ?>" name="wacout_layout_styling[section_style][sec_padding]" min="1" max="50">
												<span class="wacout_rsv"><?php esc_html_e($wacout_sec_padding)?></span>
											</div>
										</div>
									</div>
								</div>
								<h3><?php _e('Heading Style' , 'wacout') ;?></h3>
								<div class="form-table wacout_clr_opt">
									<div class="fm_group mb_20">
										<div class="fm_in">
											<div class="fm_lbl"><?php _e('Background' , 'wacout') ;?></div>
											<input class="color-picker" data-alpha="true" type="text" name="wacout_layout_styling[heading_style][hd_background]" value="<?php echo esc_attr($wacout_hd_background); ?>"/>
										</div>
									</div>
									<div class="fm_group mb_20">
										<div class="fm_in">
											<div class="fm_lbl"><?php _e('Font Color' , 'wacout') ;?></div>
											<input class="color-picker" data-alpha="true" type="text" name="wacout_layout_styling[heading_style][hd_font_color]" value="<?php echo esc_attr($wacout_hd_font_color); ?>"/>
										</div>
									</div>
									<div class="fm_group">
										<div class="fm_in">
											<div class="fm_lbl"><?php _e('Font Size' , 'wacout') ;?></div>
											<div class="wacout_range_slider fm_ctrl">
												<input class="wacout_rs" type="range" value="<?php echo esc_attr($wacout_hd_font_size); ?>" name="wacout_layout_styling[heading_style][hd_font_size]" min="1" max="50">
												<span class="wacout_rsv"><?php esc_html_e($wacout_hd_font_size)?></span>
											</div>
										</div>
									</div>
								</div>
								<h3><?php _e('Form Fields Style' , 'wacout') ;?></h3>
								<div class="form-table wacout_clr_opt">
									<div class="fm_group mb_20">
										<div class="fm_in">
											<div class="fm_lbl"><?php _e('Label Font Color' , 'wacout') ;?></div>
											<input class="color-picker" data-alpha="true" type="text" name="wacout_layout_styling[form_fields_style][lbl_font_color]" value="<?php echo esc_attr($wacout_lbl_font_color); ?>"/>
										</div>
									</div>
									<div class="fm_group mb_20">
										<div class="fm_in">
											<div class="fm_lbl"><?php _e('Label Font Size' , 'wacout') ;?></div>
											<div class="wacout_range_slider fm_ctrl">
												<input class="wacout_rs" type="range" value="<?php echo esc_attr($wacout_lbl_font_size); ?>" name="wacout_layout_styling[form_fields_style][lbl_font_size]" min="1" max="50">
												<span class="wacout_rsv"><?php esc_html_e($wacout_lbl_font_size)?></span>
											</div>
										</div>
									</div>
									<div class="fm_group mb_20">
										<div class="fm_in">
											<div class="fm_lbl"><?php _e('Fields border Color' , 'wacout') ;?></div>
											<input class="color-picker" data-alpha="true" type="text" name="wacout_layout_styling[form_fields_style][fld_bdr_color]" value="<?php echo esc_attr($wacout_fld_bdr_color); ?>"/>
										</div>
									</div>
									<div class="fm_group mb_20">
										<div class="fm_in">
											<div class="fm_lbl"><?php _e('Fields border Size' , 'wacout') ;?></div>
											<div class="wacout_range_slider fm_ctrl">
												<input class="wacout_rs" type="range" value="<?php echo esc_attr($wacout_fld_bdr_size); ?>" name="wacout_layout_styling[form_fields_style][fld_bdr_size]" min="1" max="50">
												<span class="wacout_rsv"><?php esc_html_e($wacout_fld_bdr_size)?></span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane" id="wacout_metabox_layout_tab4">
							<div class="tabpane_inner">
								<?php
								   // button text
								   if(isset($temp_layout_button_text['apply_coupan_button']) && !empty($temp_layout_button_text['apply_coupan_button'])){ $wacout_apply_coupan_button = sanitize_text_field($temp_layout_button_text['apply_coupan_button']); } else{ $wacout_apply_coupan_button = ""; }

								   if(isset($temp_layout_button_text['place_order_button']) && !empty($temp_layout_button_text['place_order_button'])){ $wacout_place_order_button = sanitize_text_field($temp_layout_button_text['place_order_button']); } else{ $wacout_place_order_button = ""; }

								   // button style
								   if(isset($temp_layout_button_text['btn_setting']['button_background']) && !empty($temp_layout_button_text['btn_setting']['button_background'])){ $wacout_button_background = sanitize_hex_color($temp_layout_button_text['btn_setting']['button_background']); } else{ $wacout_button_background = "#fe3232"; }

								   if(isset($temp_layout_button_text['btn_setting']['button_bg_hvr']) && !empty($temp_layout_button_text['btn_setting']['button_bg_hvr'])){ $wacout_button_bg_hvr = sanitize_hex_color($temp_layout_button_text['btn_setting']['button_bg_hvr']); } else{ $wacout_button_bg_hvr = "#005c90"; }

								   if(isset($temp_layout_button_text['btn_setting']['button_font_color']) && !empty($temp_layout_button_text['btn_setting']['button_font_color'])){ $wacout_button_font_color = sanitize_hex_color($temp_layout_button_text['btn_setting']['button_font_color']); } else{ $wacout_button_font_color = "#ffffff"; }

								   if(isset($temp_layout_button_text['btn_setting']['button_border_color']) && !empty($temp_layout_button_text['btn_setting']['button_border_color'])){ $wacout_button_border_color = sanitize_hex_color($temp_layout_button_text['btn_setting']['button_border_color']); } else{ $wacout_button_border_color = "#fe3232"; }

								   if(isset($temp_layout_button_text['btn_setting']['button_border_size']) && !empty($temp_layout_button_text['btn_setting']['button_border_size'])){ $wacout_button_border_size = absint($temp_layout_button_text['btn_setting']['button_border_size']); } else{ $wacout_button_border_size = "1"; }

								   if(isset($temp_layout_button_text['btn_setting']['button_font_size']) && !empty($temp_layout_button_text['btn_setting']['button_font_size'])){ $wacout_button_font_size = absint($temp_layout_button_text['btn_setting']['button_font_size']); } else{ $wacout_button_font_size = "19"; }


								?>
								<div class="wacout_flds_lbls_wrap bts_box">
									<h3><?php _e('Button Text' , 'wacout') ;?></h3>
									<div class="form-table">
										<div class="fm_group mb_20">
											<div class="fm_in">
												<div class="fm_lbl"><?php _e('Apply Coupon' , 'wacout') ;?></div>
												<input class="fm_ctrl" type="text" name="wacout_btn_txt[apply_coupan_button]" value="<?php echo esc_attr($wacout_apply_coupan_button); ?>">
											</div>
										</div>
										<div class="fm_group mb_20">
											<div class="fm_in">
												<div class="fm_lbl"><?php _e('Place Order' , 'wacout') ;?></div>
												<input class="fm_ctrl" type="text" name="wacout_btn_txt[place_order_button]" value="<?php echo esc_attr($wacout_place_order_button); ?>">
											</div>
										</div>
									</div>
									<h3><?php _e('Button Style' , 'wacout') ;?></h3>
									<div class="form-table wacout_btn_stng">
										<div class="fm_group mb_20">
											<div class="fm_in">
												<div class="fm_lbl"><?php _e('Background' , 'wacout') ;?></div>
												<input class="color-picker" data-alpha="true" type="text" name="wacout_btn_txt[btn_setting][button_background]" value="<?php echo esc_attr($wacout_button_background); ?>"/>
											</div>
										</div>
										<div class="fm_group mb_20">
											<div class="fm_in">
												<div class="fm_lbl"><?php _e('Background on Hover' , 'wacout') ;?></div>
												<input class="color-picker" data-alpha="true" type="text" name="wacout_btn_txt[btn_setting][button_bg_hvr]" value="<?php echo esc_attr($wacout_button_bg_hvr); ?>"/>
											</div>
										</div>
										<div class="fm_group mb_20">
											<div class="fm_in">
												<div class="fm_lbl"><?php _e('Font Color' , 'wacout') ;?></div>
												<input class="color-picker" data-alpha="true" type="text" name="wacout_btn_txt[btn_setting][button_font_color]" value="<?php echo esc_attr($wacout_button_font_color); ?>"/>
											</div>
										</div>
										<div class="fm_group mb_20">
											<div class="fm_in">
												<div class="fm_lbl"><?php _e('Border Color' , 'wacout') ;?></div>
												<input class="color-picker" data-alpha="true" type="text" name="wacout_btn_txt[btn_setting][button_border_color]" value="<?php echo esc_attr($wacout_button_border_color); ?>"/>
											</div>
										</div>
										<div class="fm_group mb_20">
											<div class="fm_in">
												<div class="fm_lbl"><?php _e('Border Size' , 'wacout') ;?></div>
												<div class="fm_ctrl wacout_range_slider">
													<input class="wacout_rs" type="range" value="<?php echo esc_attr($wacout_button_border_size); ?>" name="wacout_btn_txt[btn_setting][button_border_size]" min="1" max="20">
													<span class="wacout_rsv"><?php esc_html_e($wacout_button_border_size)?></span>
												</div>
											</div>
										</div>
										<div class="fm_group">
											<div class="fm_in">
												<div class="fm_lbl"><?php _e('Font Size' , 'wacout') ;?></div>
												<div class="fm_ctrl wacout_range_slider">
													<input class="wacout_rs" type="range" value="<?php echo esc_attr($wacout_button_font_size); ?>" name="wacout_btn_txt[btn_setting][button_font_size]" min="1" max="20">
													<span class="wacout_rsv"><?php esc_html_e($wacout_button_font_size)?></span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			<!-- layout fields and colors section end-->

			<!-- layout Product section start-->
			<div class="tab-pane <?php if(esc_html($tab) == "wacout_product"){echo "active";}?>" id="wacout_metabox_side_tab4">
				<div class="wacout_layout_stng_sidebar">
					<ul class="nav wacout_stng_nav">
						<li><a href="#wacout_metabox_layout_prd_tab1" class="wacout_side_tab active" data-toggle="tab"><?php _e('By default Product' , 'wacout') ;?></a></li>
						<li><a href="#wacout_metabox_layout_prd_tab2" class="wacout_side_tab" data-toggle="tab"><?php _e('Related Products' , 'wacout') ;?></a></li>

					</ul>
				</div>
				<div class="wacout_layout_stng_cntnt">
					<!-- start general setting-->
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="wacout_metabox_layout_prd_tab1">
							<div class="tabpane_inner">
								<?php


								   if(isset($temp_layout_more_product['wacout_bdpc_id']) && !empty($temp_layout_more_product['wacout_bdpc_id'])){
									   $wacout_bdpc_id = sanitize_text_field($temp_layout_more_product['wacout_bdpc_id']);
								   } else{ $wacout_bdpc_id = ""; }

								?>
								<div class="wacout_bdpc_wrap">
									<div class="wacout_bdpc_group mb_20">
										<div class="wacout_bdpc_in">
											<div class="wacout_bdpc_lbl"><?php _e('Product' , 'wacout') ;?></div>
											<select name="wacout_more_prd[wacout_bdpc_id]" class="wacout_product_search" multiple="multiple" data-placeholder="<?php esc_attr_e( 'Search for a product', 'wacout' ); ?>">
												<?php
											   if(is_array($wacout_bdpc_id)){
												   foreach ($wacout_bdpc_id as $key => $id) {
													   $product_name =  esc_html(get_the_title($id));
													   $html = '<option value="'.esc_attr($id). '" selected="selected">'.$product_name.'(#'.esc_html($id).')'.'</option>';
													   echo $html;
												   }
											   }
											   else{
												   $id = $wacout_bdpc_id ;
												   $product_name =  esc_html(get_the_title($id));
												   $html = '<option value="'.esc_attr($id). '" selected="selected">'.$product_name.'(#'.esc_html($id).')'.'</option>';
												   echo $html;
											   }
												?>
											</select>
										</div>
									</div>

								</div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane" id="wacout_metabox_layout_prd_tab2">
							<div class="tabpane_inner">
								<?php

								   if(isset($temp_layout_more_product['wacout_more_prd_add_count']) && !empty($temp_layout_more_product['wacout_more_prd_add_count'])){
									   $wacout_more_prd_add_count = $temp_layout_more_product['wacout_more_prd_add_count'];
								   } else{ $wacout_more_prd_add_count = "0"; }


								?>
								<div class="wacout_more_prd_wrap">
									<div class="wacout_more_prd_hd">
										<a class="wacout_more_prd_add_button"><?php _e('+ Add New' , 'wacout') ;?></a>
										<input type="hidden" name="wacout_more_prd[wacout_more_prd_add_count]" id="wacout_more_prd_add_count" value="<?php echo $wacout_more_prd_add_count; ?>">
									</div>
									<?php
									   for ($y = 0; $y <= $wacout_more_prd_add_count; $y++) {

										   if(isset($temp_layout_more_product['wacout_more_prd_id'][$y]) && !empty($temp_layout_more_product['wacout_more_prd_id'][$y])){
											   $wacout_more_prd_id = sanitize_text_field($temp_layout_more_product['wacout_more_prd_id'][$y]);
										   } else{$wacout_more_prd_id = "";}

										   if(isset($temp_layout_more_product['wacout_more_prd_des'][$y]) && !empty($temp_layout_more_product['wacout_more_prd_des'][$y])){
											   $wacout_more_prd_des = wp_kses_post($temp_layout_more_product['wacout_more_prd_des'][$y]);
										   } else{ $wacout_more_prd_des = ""; }

										   if(isset($temp_layout_more_product['wacout_more_prd_btn'][$y]) && !empty($temp_layout_more_product['wacout_more_prd_btn'][$y])){
											   $wacout_more_prd_btn = sanitize_text_field($temp_layout_more_product['wacout_more_prd_btn'][$y]);
										   } else{ $wacout_more_prd_btn = ""; }

									?>

									<div class="wacout_more_prd_single">
										<div class="wacout_more_prd_remove">X</div>

										<div class="wacout_more_prd_group mb_20">
											<div class="wacout_more_prd_in">
												<div class="wacout_more_prd_lbl"><?php _e('Product' , 'wacout') ;?></div>
												<select name="wacout_more_prd[wacout_more_prd_id][]" class="wacout_product_search" multiple="multiple" data-placeholder="<?php _e( 'Search for a product', 'wacout' ); ?>">
													<?php
												   if(is_array($wacout_more_prd_id)){
													   foreach ($wacout_more_prd_id as $key => $id) {
															 $product_name =  esc_html(get_the_title($id));
														   $html = '<option value="'.esc_attr($id). '" selected="selected">'.$product_name.'(#'.esc_html($id).')'.'</option>';
														   echo $html;
													   }
												   }
												   else{
													   $id = $wacout_more_prd_id ;
														 $product_name =  esc_html(get_the_title($id));
													   $html = '<option value="'.esc_attr($id). '" selected="selected">'.$product_name.'(#'.esc_html($id).')'.'</option>';
													   echo $html;
												   }
													?>
												</select>
											</div>
										</div>
										<div class="wacout_more_prd_group mb_20">
											<div class="wacout_more_prd_in">
												<div class="wacout_more_prd_lbl"><?php _e('Description' , 'wacout') ;?></div>
												<textarea class="wacout_more_prd_ctrl" name="wacout_more_prd[wacout_more_prd_des][]"><?php echo wp_kses_post($wacout_more_prd_des);?></textarea>
											</div>
										</div>

										<div class="wacout_more_prd_group">
											<div class="wacout_more_prd_in">
												<div class="wacout_more_prd_lbl"><?php _e('Button Text' , 'wacout') ;?></div>
												<input class="wacout_more_prd_ctrl" type="text" name="wacout_more_prd[wacout_more_prd_btn][]" value="<?php echo esc_attr($wacout_more_prd_btn);?>">
											</div>
										</div>

									</div>

									<?php }

									?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="clear test1234"></div>
				<?php  wp_nonce_field( 'post_save_wpnonce','save-post-nonce-field' );?>
			</div>
			<!-- layout Product section end-->
			<div class="clear"></div>
		</div>
	</div>
	<div class="clear"></div>
</div>
<?php
}


/**
* Insert values in postmeta table.
*/
add_action('save_post', 'wacout_save_postdata',10,2);
if ( ! function_exists( 'wacout_save_postdata' ) ){
	function wacout_save_postdata($post_id,$post)
	{
		$user = wp_get_current_user();
		$allowed_roles = array('editor', 'administrator', 'author');
		if(isset($_POST['save-post-nonce-field']) && check_admin_referer( 'post_save_wpnonce','save-post-nonce-field' ) && array_intersect($allowed_roles, $user->roles ) && wp_verify_nonce($_POST['save-post-nonce-field'],'post_save_wpnonce')){

		require_once(ABSPATH . 'wp-includes/pluggable.php');

		if( isset($_POST) && !empty($_POST['action']) && $_POST['action'] == 'editpost' || !empty($_POST['wacout_template_layout']) || !empty($_POST['wacout_sec_lbl']) || !empty($_POST['wacout_flds_lbls']) || !empty($_POST['wacout_btn_txt']) || !empty($_POST['wacout_layout_styling']) || !empty($_POST['wacout_custom_sections']) || !empty($_POST['wacout_csec_wp_editor1']) || !empty($_POST['wacout_csec_wp_editor2']) || !empty($_POST['wacout_csec_wp_editor3']) || !empty($_POST['wacout_more_prd']) || !empty($_POST['layout_pos']) || !empty($_POST['fields_required']) ){

			//for template selection
			$layout_settings['layout_select'] = absint($_POST['wacout_select_layout']);

			//for two column layout
			foreach($_POST['layout_pos'] as $temp_select_positions_key => $temp_select_positions_val){

				$temp_two_column[sanitize_key($temp_select_positions_key)] = sanitize_text_field($temp_select_positions_val);
			}
			$layout_settings['layout_pos'] = $temp_two_column;

			//for one column layout
			$layout_settings['layout_sorting'] = sanitize_text_field($_POST['wacout_template_layout']);

			// for custom section label

			foreach($_POST['wacout_custom_sections'] as $temp_custom_section_lbl_key => $temp_custom_section_lbl_key_val){

				$temp_custom_sec_lbl[sanitize_key($temp_custom_section_lbl_key)] = sanitize_text_field($temp_custom_section_lbl_key_val);

			}

			$layout_settings['layout_custom_sections'] = $temp_custom_sec_lbl;

			// for custom section editor1
			$layout_settings['layout_custom_sections']['wacout_csec_wp_editor1'] = wp_kses_post($_POST['wacout_csec_wp_editor1']);
			//Custom Sections editor2
			$layout_settings['layout_custom_sections']['wacout_csec_wp_editor2'] = wp_kses_post($_POST['wacout_csec_wp_editor2']);
			//Custom Sections editor3
			$layout_settings['layout_custom_sections']['wacout_csec_wp_editor3'] = wp_kses_post($_POST['wacout_csec_wp_editor3']);


			// for form sections
			foreach($_POST['wacout_sec_lbl'] as $temp_form_section_key => $temp_form_section_val){

				$temp_form_sec[sanitize_key($temp_form_section_key)] = sanitize_text_field($temp_form_section_val);

			}
			$layout_settings['layout_sec_lbl'] = $temp_form_sec;// section heading

			// for form fields
			foreach($_POST['wacout_flds_lbls'] as $temp_form_field_key => $temp_form_field_val){

				if($temp_form_field_key == 'fields_class'){
					foreach($temp_form_field_val as $temp_form_field_class_key => $temp_form_field_class_val){
						$form_fields['fields_class'][sanitize_key($temp_form_field_class_key)] = sanitize_html_class($temp_form_field_class_val);
					}
				}else{
					$form_fields[sanitize_key($temp_form_field_key)] = sanitize_text_field($temp_form_field_val);
				}
			}
			$layout_settings['layout_fields_lbl'] = $form_fields;


			// for button text and styling
			foreach($_POST['wacout_btn_txt'] as $temp_form_btn_txt_key => $temp_form_btn_txt_val){

				if( is_array($temp_form_btn_txt_val)){

					$colorArray = array('button_background', 'button_bg_hvr', 'button_font_color', 'button_border_color');


					foreach($temp_form_btn_txt_val as $temp_form_btn_style_key => $temp_form_btn_style_val){

						$temp	=	'';

						if(in_array($temp_form_btn_style_key, $colorArray, true)){

								$temp = sanitize_hex_color($temp_form_btn_style_val);
						} else {
								$temp = absint($temp_form_btn_style_val);
						}

						$button_fields[sanitize_key($temp_form_btn_txt_key)][sanitize_key($temp_form_btn_style_key)] = $temp;

					}

				}else{

					$button_fields[sanitize_key($temp_form_btn_txt_key)] = sanitize_text_field($temp_form_btn_txt_val);
				}
			}

			$layout_settings['layout_Button_text'] = $button_fields;// Button Text


			// for layout styling
			foreach($_POST['wacout_layout_styling'] as $temp_form_layout_styling_key => $temp_form_layout_styling_val){

				if(is_array($temp_form_layout_styling_val)){
					$layout_colorArray = array('hd_background','hd_font_color','lbl_font_color','fld_bdr_color');
					foreach($temp_form_layout_styling_val as $temp_form_layout_one_clmn_key => $temp_form_layout_one_clmn_val){
						$template = "";
						if(in_array($temp_form_layout_one_clmn_key, $layout_colorArray, true)){

								$template = sanitize_hex_color($temp_form_layout_one_clmn_val);
						} else {
								$template = absint($temp_form_layout_one_clmn_val);
						}

					$layout_one_column[sanitize_key($temp_form_layout_styling_key)][sanitize_key($temp_form_layout_one_clmn_key)] = $template;

					}
				}
			}
			$layout_settings['layout_style_option'] = $layout_one_column;

			// multiple related product
			for($i=0;$i<count($_POST['wacout_more_prd']['wacout_more_prd_des']);$i++){
				$more_prd['wacout_more_prd_des'][] = wp_kses_post($_POST['wacout_more_prd']['wacout_more_prd_des'][$i]);
				$layout_settings['layout_more_prd'] = array_replace($_POST['wacout_more_prd'],$more_prd);
			}
			$template_layout['template_layout_all_settings'] = $layout_settings;


			// required setting save in wp_options table
			$fields_req = $_POST['fields_required'];
			update_post_meta($post_id,'_wacout_fields_req',$fields_req);
			update_post_meta($post_id,'_wacout_template_layout_settings',$template_layout);

			remove_filter( current_filter(), __FUNCTION__ );

			if ( 'trash' !== $post->post_status ) //adjust the condition
			{
				$post->post_status = 'publish'; // use any post status
				wp_update_post( $post );
			}

		}
		// print_r($_POST['wacout_tab_url']);
		// die;
		if(isset($_POST['wacout_tab_url']) && !empty($_POST['wacout_tab_url'])){
			header("Location:".esc_url_raw($_POST['wacout_tab_url']));
			exit();
		}
	}
}
}

?>
