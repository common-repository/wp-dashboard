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
<nav class="tabs is-boxed">
    <ul>
        <li class="<?php echo ($tab=='status'?'is-active':'') ?>"><a href="?page=wpdashboard_menu&tab=status">Status</a></li>
        <li class="<?php echo ($tab=='redirects'?'is-active':'') ?>"><a href="?page=wpdashboard_menu&tab=redirects">Redirects</a></li>
        <li class="<?php echo ($tab=='settings'?'is-active':'') ?>"><a href="?page=wpdashboard_menu&tab=settings">Settings</a></li>
    </ul>
</nav>
