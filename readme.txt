=== WP Dashboard ===
Contributors: wpdashboard
Donate link: https://wpdashboard.io
Tags: wpdashboard, wp, dashboard, manage, updates, plugins, wpdash, dash
Requires at least: 4.0.0
Tested up to: 5.2.4
Requires PHP: 5.6
Stable tag: 2.0.10
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Manage all of your Wordpress installations in one place.

== Description ==

### The Last Wordpress Manager You Need

Manage all of your Wordpress installations in one place.

Want more information? [Check out our site!](https://wpdashboard.io?utm_source=wordpress&utm_medium=readme&utm_campaign=readme)


#### Integrations

* Gravity Forms (Coming Soon)
    Collect Gravity Forms entries, view forms, and export them all in one place. All form entries are captured, and encrypted. No one but YOU have access to YOUR information.

* Google Analytics (Coming Soon)
    Connect Google Analytics to WP Dashboard, and instantly see your pages on your site, errors, sessions, and more in one place.

* Google Tag Manager (Coming Soon)
    Setup Google Tag Manager on your site, from a drop-down. No code, no editing themes, it just works.

* Google Search Console (Coming Soon)
    See your errors, and organic rankings. See what you can do to modify and improve your search results.

* HubSpot (Coming Soon)
    Connecting HubSpot sets up the tracking script automatically. No configuration required.

* SMS Notifications (Coming Soon)
    Get important information about your site in real time via SMS.

* Slack Notifications (Coming Soon)
    See 404 errors as they happen, when your site has visit spikes, or broken links. Get notified instantly.


Apps coming soon, get notifications straight to your phone, and manage your sites in one place.


== Installation ==

e.g.

1. Upload `wpdashboard.zip` through the Add Plugin uploader
1. Activate the plugin through the 'Plugins' menu in WordPress

== Changelog ==

= 2.0.10 =
* Fixed bug where we missed including the update.php file causing some errors

= 2.0.9 =
* Updated to handle custom wp-content directories

= 2.0.7 =
* Fixed typo

= 2.0.6 =
* Fixing issues found by Wordpress.org
    * Sanitizing inputs
    * Updated imports

= 2.0.5 =
* Fixed issue with arguments
* Removed random `wp_die()` that was left in place.

= 2.0.4 =
* Fixed URL issue on the admin settings page.

= 2.0.2 =
* Wordpress SVN freakout, fixed it though

= 2.0.0 =
* Complete re-work of the information gathering!
* Moved to Webhook version, no more pounding servers/sites for information!
* Gathering more information, and re-working how the plugin's backend works!
* Implementation of the REST API extension, instead of using our own

= 1.1.19 =
* Added warning about V2.0

= 1.1.18 =
* Added HubSpot integration.
* Added Gathering of Pages, Posts, and Comments

= 1.1.17 =
* Added Google Tag Manager integration.

= 1.1.16 =
* Adding the descriptions and everything required for the Wordpress SVN repository to work correctly.

= 1.1.15 =
* Fixed issue with Plugin Version definition for Wordpress submission

= 1.1.14 =
* Fixed issue with Gravity Forms only returning 20 entries

= 1.1.13 =
* Adding Gravity Forms integration in
    - Gives access to export and view forms in WP Dashboard
    - All data saved IS encrypted, and only decrypted for logged-in users

= 1.1.12 =
* Updating to new URL for the dashboard

= 1.1.11 =
* Added cookies for tracking users

= 1.1.10 =
* Fixed auto login issue

= 1.1.09 =
* Added tracking for time on page

= 1.1.08 =
* Removed GuzzleHttp
* Using Wp_Http from core Wordpress
* Fixed issue with deactivation not really removing the settings

= 1.1.07 =
* Added removing settings on deactivation of the plugin.

= 1.1.06 =
* Fixed issue with auto connect button and with the remove button.

= 1.1.06 =
* Added auto connect to WP Dashboard!
    * (This means no more copy-paste of the API Key!)

= 1.1.04 =
* Fixed issue with PHP version 5.4 and below. You can now log in using auto login!

= 1.1.03 =
* Minor bug fixes

= 1.1.02 =
* Fixed issue with loading the style and JS files across the admin

= 1.1.01 =
* Changed showing the full Public API Key

= 1.1.0 =
* Bulma updated to 0.6.1
* Updated look
* Added more information to the main dashboard
* Split out admin pages in a better way

= 1.0.110 =
* Cleaned up the interface
* Fixed bug with theme updates not reporting
* Added in the ability to control redirects on the site

= 1.0.109 =
* Added extra tracking information to the pageview tracker

= 1.0.108 =
* Ability to request removal of site from WP Dashboard added
* Added Pageview Tracking - pings WPDashboard with the URL, even if it is a 404!
    - Allows you to view the 404's all in one place

= 1.0.107 =
* Bug Fixes

= 1.0.106 =
* Added delete site functionality, and fixed issue with setting the admin user

= 1.0.105 =
* Bug Fixes for Plugin Updates

= 1.0.104 =
* Bug Fixes

= 1.0.103 =
* Bug Fixes

= 1.0.102 =
* Bug Fixes

= 1.0.101 =
* Added plugin updater

= 1.0.1 =
* Added the auto-login user to the admin panel

= 1.0 =
* Initial Release