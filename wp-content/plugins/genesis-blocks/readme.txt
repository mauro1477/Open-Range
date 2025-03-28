=== Genesis Blocks ===
Contributors: dreamwhisper, johnstonphilip, marksabbath, mikeday, mindctrl, modernnerd, ryankienstra, studiopress, wpengine
Donate link: https://studiopress.com
Tags: block, blocks, editor, gutenberg, gutenberg blocks
Requires at least: 6.1
Tested up to: 6.6
Stable tag: 3.1.7
Requires PHP: 7.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A collection of content blocks, sections, & full-page layouts for the block editor.

== Description ==

Genesis Blocks is a collection of page building blocks for the Gutenberg block editor. Building pages with the block editor and Genesis Blocks gives you more control to quickly create and launch any kind of site you want!

Installing the customizable Genesis Blocks plugin adds a collection of beautiful, site-building blocks to help you customize page layouts, increase engagement, and get results for your business. Genesis Blocks provides everything from customizable buttons, to beautifully-designed page sections and full-page layout designs via the Section & Layout block.

Along with the blocks themselves, Genesis Blocks extends the content creation experience by providing a library of page sections and full-page layouts, all available from within the block editor.

### Create compelling content faster.
Create and use content quickly with prebuilt and custom content sections and full-page layouts.

### Enhance the Gutenberg editor.
Additional content blocks and the layout selector make it easy to get the most value out of the block-based editor.

### Genesis Blocks currently includes the following blocks to help you build content and pages quickly and effortlessly:

* Section & Layout Block
* Advanced Columns Block
* Newsletter Block
* Pricing Block
* Post Grid Block
* Container Block
* Testimonial Block
* Inline Notice Block
* Accordion Block
* Share Icons Block
* Call-To-Action Block
* Spacer & Divider Block
* Author Profile Block
* Drop Cap Block

Breaking change: The Genesis Blocks Button block is deprecated in favor of the Core Buttons block.

When you open the block editor, this will automatically convert your Genesis Blocks Button blocks to the Core Buttons block.

This will not convert Button blocks if you don't open the block editor.

You might see some styling changes, especially if you have custom styling for classes other than 'gb-block-button'.

### Do more with Genesis Pro
For those wanting to level-up with Genesis Blocks, a Genesis Pro subscription brings even richer tooling and a bigger library of sections and layouts.

* 2 new blocks
* 26 pre-built full-page layouts
* 56 pre-built sections
* Save & reuse your own sections & layouts
* Advanced block-level user permissions
* Access to and support for Genesis Framework & all of our 35 StudioPress-made premium child themes.
* Additional advanced features for the rest of the Genesis Product Suite

Genesis Pro includes even more value for modern WordPress content creators, marketers, and developers. [Learn more about Genesis Pro here](https://www.studiopress.com/genesis-pro/).

### Google AMP Support
The Accelerated Mobile Pages (AMP) project is a publishing format created by Google to enhance site performance for mobile website users. AMP pages are specially designed for Google search users to quickly load website pages without using any extraneous data. Genesis Blocks has support for AMP built into each block!

### Help & Docs

User and developer docs for Genesis Blocks [can be found here](https://developer.wpengine.com/genesis-pro/).

== Installation ==

This plugin can be installed directly from your site.

1. Log in and navigate to _Plugins &rarr; Add New.
2. Type "Genesis Blocks" into the Search and hit Enter.
3. Locate the Genesis Blocks plugin in the list of search results and click **Install Now**.
4. Once installed, click the Activate link.

It can also be installed manually.

1. Download the Genesis Blocks plugin from WordPress.org.
2. Unzip the package and move to your plugins directory.
3. Log into WordPress and navigate to the Plugins screen.
4. Locate Genesis Blocks in the list and click the *Activate* link.

== Frequently Asked Questions ==

= Can Genesis Blocks be used with any theme? =

Yes, you can use Genesis Blocks with any theme, but we recommend using one of the Gutenberg-ready StudioPress themes such as [Revolution](https://my.studiopress.com/themes/revolution/) for the best presentation. Both of these themes have beautiful styles built in specifically for Genesis Blocks.

= Do I need the new block editor to use Genesis Blocks? =

Yes, you will need to have WordPress 5.3 or later installed to take advantage of Genesis Blocks.

== Screenshots ==

1. Library of pre-designed page layouts
2. A pre-designed call-to-action page design
3. Some of the many blocks included in Genesis Blocks

== Changelog ==

= 3.1.7 =
* Fixed: Resolved deprecation notices for use of translation functions too early.

= 3.1.6 =
* Security: Genesis Blocks now uses its own update mechanism from WP Engine servers.

= 3.1.5 =
* Fixed: Escape exception output as prompted by Plugin Check. 

= 3.1.4 =
* Fixed: Security improvement for the sharing block.

= 3.1.3 =
* Fixed: Minor security vulnerability.

= 3.1.2 =
* Fixed: WP 6.5 compatibility problem with responsive font size controls.

= 3.1.1 =
* Fixed: Prevent block errors in wp-admin/widgets.php and in the Customizer with block widgets.

= 3.1.0 =
* Changed: Make the minimum required PHP version 7.1 again.
* Fixed: Prevent JS error on changing Paragraph and Heading block fonts.

= 3.0.1 =
* Changed: Bump the minimum required PHP version to 8.1.

= 3.0.0 =
* Breaking change: Deprecate the Call To Action block in favor of Core blocks. This will automatically convert your Call To Action blocks to Core blocks when opening the block editor. The blocks should look mainly the same, but there could be some styling changes, especially if you have custom styling for classes other than 'gb-block-cta'.
* Breaking change: In the Product Features block (child of Pricing block), the settings 'List Border Color', 'List Border Style', and 'List Border Width' are removed. If you set a 'List Border Color', that color won't appear anymore. But the styling for 'List Border Width' and 'List Border Color' will be the same, you just won't be able to change those via the settings, only Advanced > Additional CSS Classes. This change will only happen when you open the block editor. So if you don't open the block editor for the post, your Product Features blocks will stay the same as before.

= 2.0.0 =
* Breaking change: Deprecate the Button block in favor of Core Buttons block. This will automatically convert your GB Button blocks to Core Buttons blocks when opening the block editor. The buttons should look mainly the same, but there could be some styling changes, especially if you have custom styling for classes other than 'gb-block-button'.

= 1.5.5 =
* Fixed: Prevent duplicate blocks in the inserter when another plugin uses a GB category.

= 1.5.4 =
* Fixed: Fix PHP 8 uksort.
* Fixed: Prevent a PHP error on the Newlsetter block.
* Changed: Add filter to disable responsive font size controls.

= 1.5.3 =
* Fixed: Fix a block error with Desktop responsive controls on the Heading and Paragraph blocks.

= 1.5.2 =
* Changed: NPM tooling overhaul.
* Changed: Unignore eslint rules, fix linting.
* Fixed: Prevent an error if another plugin incorrectly filters 'admin_body_class'.

= 1.5.1 =
* Fixed: Revert changes that modified Profile Box avatar styling.

= 1.5.0 =
* Changed: Remove Google Analytics entirely.
* Fixed: Ensure styles are enqueued.
* Fixed: Fix post grid warning.

= 1.4.0 =
* Added: New Getting Started pages to assist with onboarding.
* Added: Optional analytics tracking for responsive styles and layout modal.
* Changed: Collections Tab is now the first tab in the layout modal for Sections and Layouts.

= 1.3.0 =
* Added: Responsive controls for the paragraph and heading core blocks.

= 1.2.5 =
* Added: block_categories_all filter for WordPress 5.8.
* Changed: Replace Font Awesome with SVG files in the Profile Box (aka Author Profile) block, and the Sharing block.
* Changed: Ensure the Post Grid block works outside of a post context (such as the WordPress 5.8 widgets screen).
* Fixed: Improve accessibility & readability of the Slate Collection colors.

= 1.2.4 =
* Added: The Post Grid block now allows for multiple categories to be selected.
* Changed: The Post Grid block now requires the user to begin typing the name of the category they wish to add, instead of selecting it from a dropdown menu.
* Fixed: The Post Grid block has been optimized to reduce load on server and wait times for sites with many categories/pages.
* Fixed: The Post Grid Block, when set to show pages, incorrectly used the "Number of items" option to limit the number of pages shown. This has been fixed. The "Number of items" option no longer applies to pages while previewing the block in the editor. The number of pages selected are the number of pages shown. Note that this bug did not affect the frontend, but only what you see in the block editor in wp-admin.
* Fixed: The genesis_blocks_allowed_layout_components filter was broken for Layouts (but not Sections) since version 1.2.2 and has been fixed here.

= 1.2.3 =
* Fixed: Layout link has been moved back to the left of the admin toolbar.

= 1.2.2 =
* Fixed: Corrected the settings link in the Newsletter Block.
* Added: Collection images to layout modal.
* Added: Fallback images for section/layout previews that fail to load.
* Added: Ability to use section keys to build layouts.

= 1.2.1 =
* Fixed: The layouts block is no longer left over in the editor if the modal is closed by the user.
* Fixed: The layouts button in the Block Editor header toolbar uses a more reliable javascript event to ensure it is always visible.
* Fixed: The Post and Page Grid block now shows all pages selected, instead of cutting it off at the number of posts set to show.
* New: Added a "Leave a review" button to the settings page.

= 1.2.0 =
* New: Introducing Collections, a curated suite of pattern designs to quickly build out beautiful pages and full websites.
* Added support for migrating Genesis Blocks Pro users.

= 1.1.1 =
* Fixed an issue for sites migrating from Atomic Blocks where in some cases the migration did not complete due to an error when deactivating the Atomic Blocks plugin.

= 1.1.0 =
* Added a way to migrate from Atomic Blocks to Genesis Blocks. Update now to learn more!
* Fixed issue with border radius in the Accordion block.
* Fixed minor bug in the Post Grid block that could cause PHP notices if the block is used in non-standard locations outside of post content.
* When using the Advanced Columns block, the inner column block now has a label of Column instead of Advanced Column to make it easier to distinguish from the outer column block that wraps it.
* Added a Getting Started page to make it easier to access documentation, discover Genesis themes, and provide us feedback about the plugin. Send us your thoughts!

= 1.0 =
* Initial release.
