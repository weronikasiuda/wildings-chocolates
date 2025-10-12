<?php

$form = get_query_var('contact_form');

if (!($form instanceof \Cgit\Postman)) {
    return;
}

?>

<div class="section">
    <div class="form-box" id="contact-form">
        <?php

        if ($form->sent()) {
            ?>
            <div class="alert alert-success">
                Your message has been sent. Thank you.
            </div>
            <?php
        } else {
            if ($form->errors()) {
                ?>
                <div class="alert alert-danger">
                    Some fields contain errors. Please correct them and try again.
                </div>
                <?php
            }

            ?>

            <form action="#contact-form" method="post">
                <input type="hidden" name="postman_form_id" value="contact_form">

                <div class="mb-3">
                    <label for="contact-form-fullname" class="form-label">
                        Name <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="fullname" id="contact-form-fullname" class="form-control <?= $form->error('fullname') ? 'is-invalid' : '' ?>" value="<?= esc_attr($form->value('fullname')) ?>" required>

                    <?php

                    if ($form->error('fullname')) {
                        ?>
                        <div class="invalid-feedback"><?= esc_html($form->error('fullname')) ?></div>
                        <?php
                    }

                    ?>
                </div>

                <div class="mb-3">
                    <label for="contact-form-email" class="form-label">
                        Email <span class="text-danger">*</span>
                    </label>

                    <input type="email" name="email" id="contact-form-email" class="form-control <?= $form->error('email') ? 'is-invalid' : '' ?>" value="<?= esc_attr($form->value('email')) ?>" required>

                    <?php

                    if ($form->error('email')) {
                        ?>
                        <div class="invalid-feedback"><?= esc_html($form->error('email')) ?></div>
                        <?php
                    }

                    ?>
                </div>

                <div class="mb-3">
                    <label for="contact-form-subject" class="form-label">
                        Subject <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="subject" id="contact-form-subject" class="form-control <?= $form->error('subject') ? 'is-invalid' : '' ?>" value="<?= esc_attr($form->value('subject')) ?>" required>

                    <?php

                    if ($form->error('subject')) {
                        ?>
                        <div class="invalid-feedback"><?= esc_html($form->error('subject')) ?></div>
                        <?php
                    }

                    ?>
                </div>

                <div class="mb-3">
                    <label for="contact-form-message" class="form-label">
                        Message <span class="text-danger">*</span>
                    </label>

                    <textarea name="message" id="contact-form-message" class="form-control <?= $form->error('message') ? 'is-invalid' : '' ?>" rows="4" required><?= esc_html($form->value('message')) ?></textarea>

                    <?php

                    if ($form->error('message')) {
                        ?>
                        <div class="invalid-feedback"><?= esc_html($form->error('message')) ?></div>
                        <?php
                    }

                    ?>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="privacy" id="contact-form-privacy" value="1" class="form-check-input <?= $form->error('privacy') ? 'is-invalid' : '' ?>" <?= $form->value('privacy') ? 'checked' : '' ?>>
                        <label for="contact-form-privacy" class="form-check-label">I have read and agree to the privacy policy.</label>

                        <?php

                        $privacy_url = null;

                        if (function_exists('get_field')) {
                            $privacy_url = get_field('privacy_policy_link', 'options')['url'] ?? $privacy_url;
                        }

                        if ($privacy_url) {
                            ?>
                            <a href="<?= esc_url($privacy_url) ?>" target="_blank">Read the privacy policy</a>.
                            <?php
                        }

                        ?>

                        <span class="text-danger">*</span>

                        <?php

                        if ($form->error('privacy')) {
                            ?>
                            <div class="invalid-feedback"><?= esc_html($form->error('privacy')) ?></div>
                            <?php
                        }

                        ?>
                    </div>
                </div>

                <?php

                if ($form->hasReCaptcha()) {
                    ?>
                    <div class="mb-3">
                        <?php

                        echo $form->renderReCaptcha();

                        if ($form->error('recaptcha')) {
                            ?>
                            <div class="form-text text-danger"><?= esc_html($form->error('recaptcha')) ?></div>
                            <?php
                        }

                        ?>
                    </div>
                    <?php
                }

                ?>

                <button type="submit" class="btn btn-primary">Send Message</button>
            </form>

            <?php
        }

        ?>
    </div>
</div>
