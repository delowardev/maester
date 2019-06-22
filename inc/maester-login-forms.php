<?php

if(!is_user_logged_in()){
    add_action( 'maester_after_footer_hook', 'login_registration_form', 10, 1 );
}

function login_registration_form(){

    ?>
    <div id='open-user-modal' style='display: none'>
        <div class='user-modal-overlay'></div>
        <div class='user-modal-inner'>
            <div class='maester-tabs user-modal-tabs'>
                <ul class='tabs'>
                    <li class='tab-link active' data-tab='tab-1'><?php esc_html_e('Login', 'maester'); ?></li>
                    <li class='tab-link' data-tab='tab-2'><?php esc_html_e('Registration', 'maester'); ?></li>
                </ul>
                <div class='tab-1 tab-content active'>
                    <form id="login" action="login" method="post">
                        <div class="user-input-group">
                            <p class="status"></p>
                        </div>
                        <div class="user-input-group">
                            <input id="username" placeholder="<?php esc_html_e('Username', 'maester'); ?>" type="text" name="username" required>
                        </div>
                        <div class="user-input-group">
                            <input id="password" placeholder="<?php esc_html_e('Password', 'maester'); ?>" type="password" name="password" required>
                        </div>
                        <div class="user-input-group">
                            <input type="checkbox" name="rememberme" id="rememberme" value="true">
                            <label for="rememberme"><?php esc_html_e('Remember Me?', 'maester'); ?></label>
                        </div>
                        <div class="user-input-group">
                            <input class="submit_button btn-primary" type="submit" value="<?php esc_html_e('Login', 'maester'); ?>" name="submit">
                        </div>
                        <div class="user-input-group">
                            <a class="lost tab-link" data-tab="tab-3" href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php esc_html_e('Lost your password?', 'maester'); ?></a>
                        </div>
                        <?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
                    </form>
                </div>
                <div class='tab-2 tab-content'>
                    <form id="registration" action="registration" method="post">
                        <div class="user-input-group">
                            <p class="status"></p>
                        </div>
                        <div class="user-input-group">
                            <input id="reg-username" placeholder="<?php esc_html_e('Username', 'maester'); ?>" type="text" name="reg-username" required>
                        </div>
                        <div class="user-input-group">
                            <input id="email" placeholder="<?php esc_html_e('Email', 'maester'); ?>" type="email" name="email" required>
                        </div>
                        <div class="user-input-group">
                            <input id="reg-password" placeholder="<?php esc_html_e('Password', 'maester'); ?>" type="password" name="reg-password" required>
                        </div>
                        <div class="user-input-group">
                            <input type="checkbox" name="agree" id="agree" value="true" disabled checked required>
                            <label for="agree"><?php esc_html_e('I agree to Terms and Conditions and Privacy Policy', 'maester'); ?></label>
                        </div>
                        <div class="user-input-group">
                            <input class="submit_button btn-primary" type="submit" value="<?php esc_html_e('Registration', 'maester'); ?>" name="submit">
                        </div>
                        <div class="user-input-group">
                            <a class="login tab-link" data-tab="tab-1" href="#"><?php esc_html_e('Already Have Account? Login', 'maester'); ?></a>
                        </div>
                        <?php wp_nonce_field( 'ajax-registration-nonce', 'reg-security' ); ?>
                    </form>
                </div>
                <div class='tab-3 tab-content'>
                    <form id="lostpass" action="lostpass" method="post">
                        <div class="user-input-group">
                            <p class="status"></p>
                            <p class="info"><?php esc_html_e('Please enter your username or email address. You will receive a link to create a new password via email.', 'maester'); ?></p>
                        </div>
                        <div class="user-input-group">
                            <input id="forget-email" placeholder="<?php esc_html_e('Email', 'maester'); ?>" type="email" name="forget-email" required>
                        </div>
                        <div class="user-input-group">
                            <input class="submit_button btn-primary" type="submit" value="<?php esc_html_e('Registration', 'maester'); ?>" name="submit">
                        </div>
                        <div class="user-input-group">
                            <a class="login tab-link" data-tab="tab-1" href="#"><?php esc_html_e('Already Have Account? Login', 'maester'); ?></a>
                        </div>
                        <?php wp_nonce_field( 'ajax-forget-nonce', 'forget-security' ); ?>
                    </form>
                </div>
            </div> <!--maester-tabs-->
        </div> <!--user-modal-inner-->
    </div> <!--open-user-modal-->

    <?php
}
