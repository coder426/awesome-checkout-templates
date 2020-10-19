<div class="wacout_stng_cntnt"><!-- start support setting-->
	<div class="tab-content">
        <div role="tabpanel" class="tab-pane wacout_support_tab" id="wacout_support_tab" style="display:block">
            <div class="tabpane_inner">
                <h2 class="qck_lnk wacout_stng_hd"><?php echo esc_html__('Support', 'wacout') ?><span class="tgl-indctr" aria-hidden="true"></span></h2>
                <div class="ref_lnk">
                    <form action="#" id="wacout_sprt_form" method="post" name="wacout_sprt_form">
                        <ul class="wacout_fdtype">
                            <li>
                                <input type="radio" class="wacout_fdtypes" id="wacout_fdtype_1" name="wacout-fdtypes" value="review" />
                                <a id="wacout_fdtype_lnk1" href="https://wordpress.org/support/plugin/woo-awesome-checkout-template/" target="_blank">
                                    <i></i>
                                    <span><?php echo esc_html__(__('I would like to review this plugin', 'wacout')) ?></span>
                                </a>
                            </li>
                            <li>
                                <input type="radio" class="wacout_fdtypes" id="wacout_fdtype_2" name="wacout-fdtypes" value="suggestions" />
                                <label for="wacout_fdtype_2">
                                    <i></i>
                                    <span><?php echo esc_html__(__('I have ideas to improve this plugin', 'wacout')) ?></span>
                                </label>
                            </li>
                            <li>
                                <input type="radio" class="wacout_fdtypes" id="wacout_fdtype_3" name="wacout-fdtypes" value="help-needed" />
                                <label for="wacout_fdtype_3">
                                    <i></i>
                                    <span><?php echo esc_html__(__('I need help with this plugin', 'wacout')) ?></span>
                                </label>
                            </li>
                        </ul>
                        <div class="wacout_fdback_form">
                            <div class="wacout_field">
                                <input placeholder="<?php echo __('Enter your email address..', 'wacout'); ?>" type="email" id="wacout-feedback-email" class="wacout-feedback-email" />
                            </div>
                            <div class="wacout_field mb3">
                                <textarea rows="4" id="wacout-feedback-message" class="wacout-feedback-message" placeholder="<?php echo __('Leave plugin developers any feedback here..', 'wacout'); ?>"></textarea>
                            </div>
                            <div class="wacout_field wacout_fdb_terms_s">
                                <input type="checkbox" class="wacout_fdb_terms" id="wacout_fdb_terms" />
                                <label for="wacout_fdb_terms"><?php echo esc_html__(__('I agree that by clicking the send button below my email address and comments will be send to a plugin support', 'wacout')) ?></label>
                            </div>
                            <div class="wacout_field">
                                <div class="wacout_sbmt_buttons">
                                <button class="btn btn-warning text-white" type="submit" id="wacout-feedback-submit">
                                <i class="fa fa-send"></i> <?php echo __('Send','wacout');?>
                                <img src="<?php echo WACOUT_IMG.'wacout-sms-loading.gif'?>" height="15px" id="wacout_sms_loading" style="display:none">
                                </button>
                                <input type="hidden" id="wacout_form_type" name="wacout_form_type">
                                <a class="wacout_fd_cancel btn" id="wacout_fd_cancel" href="#"><?php echo __('Cancel','wacout');?></a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
