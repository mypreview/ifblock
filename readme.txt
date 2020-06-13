=== If Block — Visibility control for Blocks ===
Contributors: mahdiyazdani, mypreview, gookaani
Tags: if block, conditional logic, block logic, access control, user role, conditional display, browser detection
Donate link: https://www.mypreview.one
Requires at least: 5.2
Tested up to: 5.4
Requires PHP: 7.2
Stable tag: 1.2.0
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

This block enables you to configure certain content to appear only if specified conditions are met.

== Description ==

This block enables you to configure certain content to appear only if specified conditions are met (or be hidden) by setting different visibility rules.

You can add any Gutenberg block inside an if-block, have it render on the front-end of your site only if specified conditions are met. This block also provides an additional area (else-block) that can optionally display an alternative content in place when defined conditions are not met. 

The conditional logic of this block supports both **AND** and **OR** operators in conjunction with filtering a specif user role and also detecting visitor’s browser software as well.

== Installation ==
= Minimum Requirements =

* PHP version 7.2 or greater.
* MySQL version 5.6 or greater or MariaDB version 10.0 or greater.
* WordPress version 5.0 or greater.

= Automatic installation =

Automatic installation is the easiest option — WordPress will handle the file transfer, and you won’t need to leave your web browser. To do an automatic install of the plugin, log in to your WordPress dashboard, navigate to the Plugins menu, and click “Add New.”
 
In the search field type “If Block”, then click “Search Plugins.” Once you’ve found the plugin, you can view details about it such as the point release, rating, and description. Click “Install Now,” and WordPress will take it from there.

= Manual installation =

The manual installation method requires downloading the plugin and uploading it to your webserver via your favorite FTP application. The WordPress codex contains [instructions on how to do this here](https://wordpress.org/support/article/managing-plugins/#manual-plugin-installation "Manual plugin installation").

= Updating =

Automatic updates should work smoothly, but we still recommend you back up your site.

== Frequently Asked Questions ==
= How do I use the block? =
1. Log into your WordPress website and navigate to Dashboard.
2. Create a new page, by visiting “Pages” » “Add New”.
3. Click on the “Add Block” button and select the “If Block” block. Alternatively, you can start typing `/ifblock` in a new paragraph block, then press enter.
4. “If Block” can contain other blocks. You can add content by clicking the `+` icon and picking a block.
5. Publish the page.

= What user roles are supported? =
All pre-defined WordPress core user roles including the ones that might be registered by a third-party plugin such as WooCommerce are supported.

= Which browsers are supported? =
Currently, the if-block can detect and limit the content’s appearance to visitors that are browsing the page via any of the following browsers:

* Google Chrome
* Safari
* iPhone Safari
* Netscape 4
* FireFox
* Opera
* Microsoft Edge
* Internet Explorer
* Mac Internet Explorer
* Windows Internet Explorer

= How do I get help with the plugin? =
The easiest way to receive support is to “Create a new topic” by visiting Community Forums page [here](https://wordpress.org/support/plugin/if-block-visibility-control-for-blocks "If Block — Visibility control for Blocks Support Forum").

Make sure to check the “Notify me of follow-up replies via email” checkbox to receive notifications, as soon as a reply posted to your question or inquiry.

*Please note that this is an opensource 100% volunteer project, and it’s not unusual to get reply days or even weeks later.*

= Can I help in translating this plugin into a new language? =
The plugin is fully translation-ready and localized using the GNU framework, and translators are welcome to contribute to the plugin.

Here’s the [WordPress translation website &#8594;](https://translate.wordpress.org/projects/wp-plugins/if-block-visibility-control-for-blocks "WordPress translation website")

= How do I contribute to this plugin? =
We welcome contributions in any form, and you can help reporting, testing, and detailing bugs.

Here’s the [GitHub development repository &#8594;](https://github.com/mypreview/ifblock "GitHub development repository")

= Did you like the idea behind this plugin? =
Please share your experience by leaving this plugin [5 shining stars](https://wordpress.org/support/plugin/if-block-visibility-control-for-blocks/reviews/ "Rate If Block — Visibility control for Blocks 5 stars") if you like it, thanks!

= I need help customizing this plugin? =
I am a full-stack developer with over five years of experience in WordPress theme and plugin development and customization. I would love to have the opportunity to discuss your project with you.

[Hire me on UpWork &#8594;](https://www.upwork.com/o/profiles/users/_~016ad17ad3fc5cce94/ "Mahdi Yazdani Freelancer Profile")

== Screenshots ==
1. Configuring block content to appear only if specified conditions are met.

== Changelog ==
= 1.2.0 =
* Added `autoloader` support.
* Compatibility with WordPress 5.4.1

= 1.1.0 =
* Updated language file.
* Multiple code standards improvements.
* Compatibility with WordPress 5.4.1

= 1.0.0 =
* Initial release.