<?php

use Egns\Helper\Egns_Helper;

?>
<div class="modal fade job-form-modal" id="applyModal" tabindex="-1" aria-labelledby="applyModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="applyModalLabel"><?php echo esc_html__('Apply to the position of ', 'adking') . get_the_title(get_the_ID()); ?></h2>
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/innerpages/career-modall-top-shape.png'); ?>" alt="" class="shape-top">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/innerpages/career-modall-bottom-shape.png'); ?>" alt="" class="shape-bottom">
            </div>
            <button type="button" class="modal-close" data-bs-dismiss="modal" aria-label="Close">
                <i class="bi bi-x-lg"></i>
            </button>
            <div class="modal-body">
                <?php echo do_shortcode(Egns_Helper::egns_career_option_value('career_apply_form_shortcode')) ?>
            </div>
        </div>
    </div>
</div>