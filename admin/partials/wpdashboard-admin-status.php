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

$pages = wp_count_posts('page');
$posts = wp_count_posts('post');
$comments = wp_count_comments();
$redirects = json_decode($this->get_option('redirects'), true);
$public_key = $this->get_option('public_key');
$admin_page = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


require 'wpdashboard-admin-partial-header.php';
?>
<div class="container">
    <div class="box">
        <?php
        require 'wpdashboard-admin-partial-tabs.php';
        ?>
        <?php if (!$this->get_option('connected')) { ?>
		<div class="columns">
			<div class="column">
				<div class="box">
					<div class="content">
						<div class="title">Not Connected</div>
						<p class="has-text-centered">
							<a class="button is-large is-primary" href="http://my.wpdashboard.io/sites/activate?api_key=<?php echo $this->get_option('api_key'); ?>&version=<?php echo bloginfo('version'); ?>&domain=<?php echo urlencode(home_url()); ?>&admin_user=<?php echo wp_get_current_user()->user_login ?>&name=<?php echo get_bloginfo('name'); ?>&redir=<?php echo urlencode($admin_page) ?>">Connect to WP Dashboard</a>
							<br />
							<small><a onclick="javascript:this.classList.add('hidden'); document.getElementById('manual_connect').classList.remove('hidden');">Connect Manually</a></small></p>
						<p id="manual_connect" class="hidden">Connect by going to <a href="https://my.wpdashboard.io/sites/connect">WP Dashboard</a>, then enter enter the key: <br /> <input type="text" class="input" name="wpdashboard-key" readonly value="<?php echo $this->get_option('api_key'); ?>"/></p>
						<p></p>
					</div>
				</div>
			</div>
		</div>
		<?php } else { ?>
        <div class="columns is-multiline">
            <div class="column is-4-desktop is-6-tablet is-12-mobile">
                <div class="box">
                    <div class="content">
						<div class="title">Connected</div>
						<div class="subtitle">Status</div>
                    </div>
                </div>
            </div>
            <div class="column is-4-desktop is-6-tablet is-12-mobile">
                <div class="box">
                    <div class="content">
                        <div class="title"><?php echo number_format(count($redirects), 0); ?></div>
                        <div class="subtitle">Redirects Enabled</div>
                    </div>
                </div>
            </div>
            <div class="column is-4-desktop is-6-tablet is-12-mobile">
                <div class="box">
                    <div class="content">
                        <div class="title"><?php echo substr($public_key, 0, 10); ?>...</div>
                        <div class="subtitle">Public API Key</div>
                    </div>
                </div>
            </div>
        </div>
        <hr />
        <div class="title">Basic Information</div>
        <div class="columns is-multiline">
            <div class="column is-4-desktop is-6-tablet is-12-mobile">
                <div class="box">
                    <div class="content">
                        <div class="title"><?php echo number_format($pages->publish, 0) ?></div>
                        <div class="subtitle">Published Pages</div>
                    </div>
                </div>
            </div>
            <div class="column is-4-desktop is-6-tablet is-12-mobile">
                <div class="box">
                    <div class="content">
                        <div class="title"><?php echo number_format($posts->publish, 0) ?></div>
                        <div class="subtitle">Published Posts</div>
                    </div>
                </div>
            </div>
            <div class="column is-4-desktop is-6-tablet is-12-mobile">
                <div class="box">
                    <div class="content">
                        <div class="title"><?php echo number_format($comments->approved, 0) ?></div>
                        <div class="subtitle">Approved Comments</div>
                    </div>
                </div>
            </div>
            <div class="column is-4-desktop is-6-tablet is-12-mobile">
                <div class="box">
                    <div class="content">
                        <div class="title"><?php echo number_format($pages->draft, 0) ?></div>
                        <div class="subtitle">Draft Pages</div>
                    </div>
                </div>
            </div>
            <div class="column is-4-desktop is-6-tablet is-12-mobile">
                <div class="box">
                    <div class="content">
                        <div class="title"><?php echo number_format($posts->draft, 0) ?></div>
                        <div class="subtitle">Draft Posts</div>
                    </div>
                </div>
            </div>
            <div class="column is-4-desktop is-6-tablet is-12-mobile">
                <div class="box">
                    <div class="content">
                        <div class="title"><?php echo number_format($comments->moderated, 0) ?></div>
                        <div class="subtitle">Moderated Comments</div>
                    </div>
                </div>
            </div>
        </div>
		<?php } ?>
    </div>
</div>
