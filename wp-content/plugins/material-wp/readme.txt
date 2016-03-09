=== Material WP ===
Contributors: aanduque
Requires at least: 3.5.0
Tested up to: 4.2.2

Completely tranform your admin interface with the Google's Material Design styles.

== Description ==

Material WP

Completely tranform your admin interface with the Google's Material Design styles.

== Installation ==

1. Upload 'material-wp' to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress


== Changelog ==

0.0.16
- Fixed: little style incompatibility with MailPoet
- Fixed: Admin bar height ajusted in the frontend
- New Feature: Remove the opacity trasition in the parallax block
|-- Note: This may require you to re-select the color you want to use in the parallax block.
- New Feature: Display only a color block in parallax block

0.0.15
- Fixed: Bug in margins in the themes.php when only one theme is installed
- New default logo for the plugin

0.0.14
- Fixed: Some corrections on the news brought by WordPress 4.4
- Fixed: Text color on button primary changed

0.0.13
- Fixed: Custom height of adminbar leaking to the frontend even when frontend styles were disabled.
- Fixed: Removed a unecessary piece of code that was causing bugs with OptionsTree and Admin Menu Editor Pro.

0.0.12
- Fixed: Missing points in the encapsulated process of Titan Framework.
- Fixed: WordPress Social Login plugin, Tabs being hidden.
- Fixed: Incompatibilities with FormCraft plugin.
- Fixed: Incompatibilities with Bookly

0.0.11
- Fixed: little incompatibility with WP Admin Menu Manager
- Fixed: problems with Custom Sidebars from WPMUDEV
- Fixed: problems with Real Media Library

0.0.10
- Fixed: removed shortcut PHP definition (<?php instead of <?) in one of the files to prevent fatal errors in environments where the PHP don't support it.

0.0.9
- LONG WAITED CHANGE: MULTISITE SUPPORT
-- Now when "Network Active" Material displays the options menu only in the network admin, letting you choose global settings that will be applied to every blog in the network.
- New: Ability to change the link in the logo in the login page.
- New: Ability to display or hide the "Back to Blog" link in the login.

0.0.8
- HUGE UPDATE: The block system used in the theme was replaced from .wrap (which is recomended by WordPress but devs often don't use - what was causing a number of plugin incompatibilities) to #wpbody-content. With that change, Material WP is now virtually compatible with all WordPress plugins. (But if you spot something spooky, just send us a message as always).
- New: Change the height of the admin bar as well as its subitems
- Encapsulated Titan Framework to avoid conflict with other plugins and theme using it

0.0.7
- New: Ability to disable menu editing
- New: Change or Hide the menu label ("Main Menu" text over the admin menu)
- New: Ability to use the default admin bar in the frontend
- New: Ability to disable random color in the admin menu icons and setting your own
- New: Our "Happy Buyers Club" Newsletter Link Added
- New: POT files added for plugin translation
- New: Option to position the admin menu on the right
- New Compatibility: WP Clone by WP Academy
- New Compatibility: Google Analytics Dashboard for WP
- New Compatibility: CiviCRM
- New Compatibility: SkyStatus Plugin
- Fixed: Admin Menu Pro Icon Changer

0.0.6
- Fixed: Customizer Bug
- Fixed some compatibility issues with plugins (Now 100% Compatible):
-- Visual Composer and Visual Composer Fullscreen
-- OptinLinks
-- UserPro
-- UberMenu
-- Premium SEO Pack
-- Ultimate Tweaker
-- UpdraftPlus Backup/Restore
-- Layered Popups
-- Admin Menu Editor Pro
-- WordFence
-- ZenCache
-- WP Media Folder
-- Easy Social Share Buttons for WordPress
-- Flow-Flow — Social Streams Plugin
-- Askimet
-- All-in-One WP Migration
-- NestedPages
-- CQPIM WordPress Project Management Plugin

0.0.5
- Fixed: autoupdates displaying update notice without any updates available.
- 100% Compatibility List: MyMail added.
- Admin menu default width is now 280px.

0.0.4
- Active Admin Menu now stays open.
- Fix: Titan Framework leaking custom CSS to the frontend.

0.0.3
- New Customization options added, such as:
--- Custom CSS field (with SCSS support!);
--- Sidemenu width;
--- Parallax block height;

- Update of options framework used
- Fix in the styles of the "inactivity" login modal

- Basic import and Export features using JSON (improvements will be mande in this to allow for media import from external sources and much more)

- Material WP now uses luminosity tests to determine with text color to use on buttons and toolbars based on the colors choose by the user!
- Hooks in our framework to allow us to display errors when they occur

0.0.2
- Only loads styes in frontend when logged (wpadminbar is shown).
- Removed some extra CSS enqueued to the frontend that could cause conflicts with frontend themes.
- Custom logo src url fix.
- Fix in some custom icons not showing up.

0.0.1 - Initial Release on CodeCanyon