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
                        <p class="title">Redirects</p>
                        <p class="subtitle">The following URLs are all redirects. They are managed by WP Dashboard.</p>
                        <?php
                        $redirects = json_decode($this->get_option('redirects'), true);
                        if($redirects) {
                            ?>
                            <table class="table is-fullwidth">
                                <thead>
                                <tr>
                                    <th>URL</th>
                                    <th>Redirect To</th>
                                    <th>Type</th>
                                    <th>Created On</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($redirects AS $key => $redirect) {
                                    ?>
                                    <tr>
                                        <td><?php echo $redirect['url']; ?></td>
                                        <td><?php echo $redirect['redirect']; ?></td>
                                        <td><?php echo $redirect['type']; ?></td>
                                        <td><?php echo date("F j, Y", strtotime($redirect['created'])); ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        <?php } else { ?>
                            <div class="subtitle">No Redirects</div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
