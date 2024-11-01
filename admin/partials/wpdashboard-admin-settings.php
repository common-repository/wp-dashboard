<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wpdashboard.io
 * @since      1.0.0
 *
 * @package    Wpdashboard
 * @subpackage Wpdashboard/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<?php
require 'wpdashboard-admin-partial-header.php';
?>
<div class="container">
    <div class="box">
        <?php
        require 'wpdashboard-admin-partial-tabs.php';
        ?>
        <div class="columns">
            <div class="column">
                <div class="box">
                    <div class="content">
                        <?php if($this->get_option('removing') == true) { ?>
                            <p class="title">Removing from WP Dashboard</p>
                            <p>The email has been sent to the users associated with the domain in WP Dashboard. They have to click on the link in the email to confirm the removal of the site.</p>
                        <?php } else { ?>
                            <p class="title">Remove from WP Dashboard</p>
                            <p>By removing, it will change the key on the site, and remove the site from the dashboard. In order for this to fully happen, an email will be sent confirming the action. Be sure to click on the link in the email to confirm and remove it from the dashboard.</p>
                            <div class="has-text-centered">
                                <a onclick="WPDashboard.remove_from_wp_dashboard()" class="button is-medium is-danger">Remove from WP Dashboard</a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
