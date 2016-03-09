<?php
/**
 * Plugin Name: Material WP
 * Plugin URI: http://codecanyon.net/item/material-wp-material-design-dashboard-theme/12981098?ref=732
 * Description: Bring Material Design to you WordPress Dashboard.
 * Version: 0.0.16
 * Author: Arindo Duque - 732
 * Author URI: http://weare732.com/
 * Copyright: Arindo Duque, seventhreetwo
 */

/**
 * Loads our incredibily awesome Paradox Framework, which we are going to use a lot.
 */
require 'paradox/paradox.php';

/**
 * Here starts our plugin.
 */
class MaterialWP extends ParadoxFramework {

  /**
   * EVENTS
   * The section bellow handles the events that may happen like activation, deactivation, uninstall and
   * first run
   */
  
  /**
   * Place code that will be run on the first Run of the plugin
   */
  public function onFirstRun() {} // end onFirstRun;
  
  /**
   * Place code that will be run on activation
   */
  public function onActivation() {} // end onActivation;
  
  /**
   * Place code that will be run on deactivation
   */
  public function onDeactivation() {} // end onDeactivation;
  
  /**
   * Place code that will be run on uninstall
   */
  public function onUninstall() {} // end onUninstall;
  
  /**
   * SCRIPTS AND STYLES
   * The section bellow handles the adding of scripts and css files to the different hooks WordPress offers
   * such as Admin, Frontend and Login. Calling anyone of these hooks on the child class you automaticaly 
   * add the scripts hooked to the respective hook.
   */
  
  /**
   * Enqueue and register Admin JavaScript files here.
   */
  public function enqueueAdminScripts() {
    //global $wp_scripts;var_dump($wp_scripts);
    
    // Deregister common cause we need to make some changes to it.
    wp_dequeue_script('common');
    wp_deregister_script('common');
    
    // Reeneque our own custom
    wp_enqueue_script('common', $this->url('assets/js/common.min.js'), array('jquery', 'hoverIntent', 'utils'), false, 1);
    
    // Localize it
    wp_localize_script('common', 'commonL10n', array(
		'warnDelete' => __("You are about to permanently delete the selected items.\n  'Cancel' to stop, 'OK' to delete.", $this->td),
		'dismiss'    => __('Dismiss this notice.', $this->td),
	));
    
    // Enqueue base script
    wp_enqueue_script($this->id, $this->url('assets/js/scripts.min.js'), array('jquery'), false, false);
    
  } // end enqueueAdminScripts;
  
  /**
   * Enqueue and register Admin CSS files here.
   */
  public function enqueueAdminStyles() {
    
    // We enqueue our styles, customized for this version
    wp_enqueue_style($this->id, $this->url('assets/css/material-wp.css'));
    
  } // end enqueueAdminStyles;
  
  /**
   * Enqueue and register Frontend JavaScript files here.
   */
  public function enqueueFrontendScripts() {} // end enqueueFrontendScripts;
  
  /**
   * Enqueue and register Frontend CSS files here.
   */
  public function enqueueFrontendStyles() {
    
    // Only enqueue if user is logged
    if (!is_admin_bar_showing() || !$this->options->getOption('admin-bar-frontend')) return;
    
    // We enqueue our login-specific styles
    wp_enqueue_style($this->slugfy('admin-bar'), $this->url('assets/css/material-wp-admin-bar.css'));
    
    $css = "#wpadminbar {
      background-color: ".$this->options->getOption('primary-color')." !important;
    }";
    
    $css .= "html[class], html[lang] {
      margin-top: ".$this->options->getOption('adminbar-height')."px !important;
    }";
    
    // Print CSS
    printf('<style type="text/css">%s</style>', $css); 
    
  } // end enqueueFrontendStyles;
  
  /**
   * Enqueue and register Login JavaScript files here.
   */
  public function enqueueLoginScripts() {} // end enqueueLoginScripts;
  
  /**
   * Enqueue and register Login CSS files here.
   */
  public function enqueueLoginStyles() {
    
    // We enqueue our login-specific styles
    wp_enqueue_style($this->slugfy('login'), $this->url('assets/css/material-wp-login.min.css'));
    
  } // end enqueueLoginStyles;
  
  /**
   * IMPORTANT METHODS
   * Set bellow are the must important methods of this framework. Without them, none would work.
   */
  
  /**
   * Here is where we create and manage our admin pages
   */
  public function adminPages() {
    
    /**
     * Create our admin panel, so qe can add our styling and setup configs
     */
    $panel = $this->options->createAdminPanel(array(
      'id'    => $this->slugfy('settings'),
      'name'  => __('Material WP', $this->td),
      'title' => __('Material WP', $this->td),
      'desc'  => __('The badges in each tab represents the number of new options in this version!<br>Also, check the "Activate Material WP" tab to join our <strong>CodeCanyon Happy Buyers Club</strong>!', $this->td),
      'icon'  => 'dashicons-art',
      //'capability' => $this->options->getOption('super-admin-only') ? 'manage_network' : 'manage_options'
    ));
    
    /**
     * Start creating tab
     */
    
    // Styling Tab
    $style = $panel->createTab(array(
      'id'   => 'style',
      'name' => __('Styling Settings', $this->td).'<span class="new badge no-new" style="margin-left:5px;" title="'. sprintf(__('%s new options!'), 2) .'">2</span>',
    ));
    
    // Functionality Tabs
    $func = $panel->createTab(array(
      'id'   => 'func',
      'name' => __('Functionality', $this->td), // .'<span class="new badge no-new" style="margin-left:5px;" title="'. sprintf(__('%s new options!'), 1) .'">2</span>',
    ));
    
    // Custom CSS and JS Tab
    $customCode = $panel->createTab(array(
      'name' => __('Custom CSS', $this->td),
    ));
    
    /**
     * Custom Code tab options
     */
    
    $customCode->createOption(array(
      'id'   => 'custom-css',
      'type' => 'code',
      'lang' => 'scss',
      'name' => __('Custom CSS Code', $this->td),
      'desc' => __('Enter your custom CSS code to be applied to the dashboard! SCSS syntax is supported!', $this->td),
    ));
    
    $customCode->createOption(array(
      'type' => 'save',
    ));
    
    /**
     * Start creating options
     */
    
    // Primary Color
    $style->createOption(array(
      'id'   => 'primary-color',
      'name' => __('Primary Color', $this->td),
      'desc' => __('This color will be used in the admin bar adn in the parallax block effect.', $this->td),
      'type' => 'color',
      'default' => '#2296F3',
    ));
    
    // Accent Color
    $style->createOption(array(
      'id'   => 'accent-color',
      'name' => __('Accent Color', $this->td),
      'desc' => __('This color will be used in the buttons and links across the admin.', $this->td),
      'type' => 'color',
      'default' => '#8AC249',
    ));
    
    // Enable Menu Random colors
    $style->createOption(array(
      'id'      => 'menu-random-color',
      'name'    => __('Menu Icons Radom Colors', $this->td),
      'desc'    => __('Use this option to enable/disable the random colors for the admin links.', $this->td),
      'type'    => 'enable',
      'default' => true,
    ));
    
    // Menu icon Color Custom
    $style->createOption(array(
      'id'      => 'menu-custom-color',
      'name'    => __('Menu Icons Custom Color', $this->td),
      'desc'    => __('Select your own color to the admin menu icons. Note: this only works for the icon-font icons and this options is only user if the "Menu Icons Random
      Colors" option is disabled.', $this->td),
      'type'    => 'color',
      'default' => '#333',
    ));
    
    // Sidemenu Width
    $style->createOption(array(
      'id'   => 'menu-width',
      'name' => __('Admin Menu Width', $this->td),
      'desc' => __('Change the width of the sidemenu.', $this->td),
      'type' => 'number',
      'unit' => 'px',
      'default' => '280',
      'min'  => '180',
      'max'  => '320',
    ));
    
    // Parallax Block Height
    $style->createOption(array(
      'id'   => 'parallax-height',
      'name' => __('Parallax Block Height', $this->td),
      'desc' => __('Change the height of the parallax block.', $this->td),
      'type' => 'number',
      'unit' => 'px',
      'default' => '300',
      'min'  => '250',
      'max'  => '300',
    ));
    
    /**
     * New in 0.0.8: Admin Bar height selector
     */
    $style->createOption(array(
      'id'   => 'adminbar-height',
      'name' => __('Adminbar Height', $this->td),
      'desc' => __('Change the height of the adminbar.', $this->td),
      'type' => 'number',
      'unit' => 'px',
      'default' => '55',
      'min'  => '35',
      'max'  => '100',
    ));
    
    /**
     * New in 0.0.8: Admin Bar subitem height selector
     */
    $style->createOption(array(
      'id'   => 'adminbar-subitem-height',
      'name' => __('Adminbar Subitem Height', $this->td),
      'desc' => __('Change the height of the items of the adminbar submenu.', $this->td),
      'type' => 'number',
      'unit' => 'px',
      'default' => '40',
      'min'  => '25',
      'max'  => '55',
    ));
    
    // Parallax options
    $style->createOption(array(
      'id'   => 'parallax-options',
      'name' => __('Parallax Block Settings', $this->td),
      'desc' => __('Here you can select the style of the display of the parallax block. You can choose to use a solid color, the parallax with the opacity effect or just the parallax effect.', $this->td),
      'type' => 'radio',
      'default' => 'default',
      'options' => array(
        'default'     => __('Parallax + Opacity Effect', $this->td),
        'parallax'    => __('Only Parallax Effect', $this->td),
        'solid-color' => __('Solid Color', $this->td),
      ),
    ));
    
    // Menu icon Color Custom
    $style->createOption(array(
      'id'      => 'parallax-bg-color',
      'name'    => __('Parallax BG Color', $this->td),
      'desc'    => __('Select the background color of the parallax block.', $this->td),
      'type'    => 'color',
      'default' => '#2296F3',
    ));
    
    // preset BG
    $style->createOption(array(
      'id'   => 'default-bg',
      'name' => __('Preset Parallax Block BG', $this->td),
      'desc' => __('Select the background image of the parallax block from one of our preset images. You you prefer, you can choose your own image using the field bellow.', $this->td),
      'type' => 'radio-image',
      'default' => 'bg1',
      'options' => array(
        'bg1'   => $this->getAsset('bgs-small/bg1.jpg'),
        'bg2'   => $this->getAsset('bgs-small/bg2.jpg'),
        'bg3'   => $this->getAsset('bgs-small/bg3.jpg'),
        'bg4'   => $this->getAsset('bgs-small/bg4.jpg'),
        //'no-bg' => $this->getAsset('bgs-small/no-bg.jpg'),
      ),
    ));
    
    // Custom BG
    $style->createOption(array(
      'id'   => 'custom-bg',
      'name' => __('Custom Parallax Block BG', $this->td),
      'desc' => __('Select your custom Parallax Block BG.', $this->td),
      'type' => 'upload',
      'placeholder' => __('Select your custom parallax block BG.', $this->td),
      'default' => false,
    ));
    
    // Custom Logo
    $style->createOption(array(
      'id'   => 'custom-logo',
      'name' => __('Custom Logo', $this->td),
      'desc' => __('Select the custom Logo you want to use. It will be displayed in the admin bar and in the login page as well.', $this->td),
      'type' => 'upload',
      'placeholder' => __('Select your custom logo image.', $this->td),
      'default' => $this->getAsset('logo.png'),
    ));
    
    // Save Button
    $style->createOption(array(
      'type' => 'save',
    ));
    
    /**
     * Functionality Settings
     * All the Settings that relate to enablign and disabling functionality
     */
    
    // Block Admin Menu
    $func->createOption(array(
      'name' => __('Admin Menu', $this->td),
      'desc' => __('Use this block to change the settings regarding the admin menu', $this->td),
      'type' => 'heading',
    ));
    
    // Enable menu editing
    $func->createOption(array(
      'id'      => 'menu-reordering',
      'name'    => __('Menu Reordering', $this->td),
      'desc'    => __('If enabled, the reordering functionality will be presented to the backend users.', $this->td),
      'type'    => 'enable',
      'default' => true,
    ));
    
    // Chnage the menu Label
    $func->createOption(array(
      'id'          => 'menu-label',
      'name'        => __('Menu Label', $this->td),
      'desc'        => __('Select the little text that appears ontop of the admin menu. Leave blank to display nothing.', $this->td),
      'placeholder' => 'This will display nothing.',
      'type'        => 'text',
      'default'     => __('Main Menu', $this->td),
    ));
    
    // Change the menu position
    $func->createOption(array(
      'id'          => 'menu-position',
      'name'        => __('Menu Position', $this->td),
      'desc'        => __('You can position the admin menu in either side of the screen.', $this->td),
      'type'        => 'radio',
      'default'     => 'left',
      'options'     => array(
        'left'      => __('Left', $this->td),
        'right'     => __('Right', $this->td),
      )
    ));
    
    // Save Button
    $func->createOption(array(
      'type' => 'save',
    ));
    
    // -- Admin Bar --
    
    // Block Admin Menu
    $func->createOption(array(
      'name' => __('Admin Bar', $this->td),
      'desc' => __('Use this block to change the settings regarding the admin bar', $this->td),
      'type' => 'heading',
    ));
    
    $func->createOption(array(
      'id'      => 'admin-bar-frontend',
      'name'    => __('Admin Bar in the Frontend', $this->td),
      'desc'    => __('You can choose to use the default WordPress admin bar styles in the frontend by disabling our custom styles.', $this->td),
      'type'    => 'enable',
      'default' => true,
    ));
    
    // Save Button
    $func->createOption(array(
      'type' => 'save',
    ));
    
    // -- Login --
    
    // Block Login Page
    $func->createOption(array(
      'name' => __('Login Page', $this->td),
      'desc' => __('Use this block to change some options of the login page.', $this->td),
      'type' => 'heading',
    ));
    
    $func->createOption(array(
      'id'      => 'logo-link',
      'name'    => __('Link in the Logo', $this->td),
      'desc'    => __('Change the link in the logo displayed above the login form. Leave blank to link to your site\'s homepage.', $this->td),
      'type'    => 'text',
      'placeholder' => __('Defaults to your site\'s homepage', $this->td),
    ));
    
    $func->createOption(array(
      'id'      => 'back-to-blog',
      'name'    => __('Display "Back to Blog" link?', $this->td),
      'desc'    => __('Using this option you can choose to display or hide the back to blog link in the admin form.', $this->td),
      'type'    => 'enable',
      'default' => true,
    ));
    
    // Save Button
    $func->createOption(array(
      'type' => 'save',
    ));
        
    /**
     * EVEN MORE IMPORTANT: Our customizer in the login page goes here!
     */
    //include_once $this->path('modules/login-customizer/login-customizer.php');
    
    /**
     * IMPORTANT: We need to initialize our export functionality
     */
    if (method_exists($this, 'addExportTab')) $this->addExportTab($panel);
    
    /**
     * IMPORTANT: We need to initialize our activation page
     */
    $this->addAutoUpdateOptions($panel);
    
    // Add this to branding
    $this->pages[] = $this->slugfy('settings');
    
  } // end adminPages;
  
  /**
   * Place code for your plugin's functionality here.
   */
  public function Plugin() {
    
    // remove WP logo from adminbar
    add_action('wp_before_admin_bar_render', array($this, 'editAdminBar'));

    // adds our custom site logo
    add_action('admin_bar_menu', array($this, 'addLogo'), 0);
    
    // Adds plus button
    add_action('in_admin_header', array(&$this, 'addParallaxBlock'));
    
    // Clean Footer on the Left
    add_filter('admin_footer_text', array($this, 'clearFooter'), 99999);
    
    // Clean Footer on the Right
    add_filter('update_footer', array($this, 'clearFooter'), 99999);
    
    // Remove colorscheme selector
    remove_action('admin_color_scheme_picker', 'admin_color_scheme_picker');
    
    // Add custom styles to our login page
    add_action('login_enqueue_scripts', array($this, 'loginInlineCSS'));
    
    // Compile and render our dinamic styles in login
    add_action('login_enqueue_scripts', array($this, 'adminInlineCSS'));
    
    // Sent to the frontend as well
    add_action('wp_enqueue_scripts', array($this, 'adminInlineCSS'));
    
    // Compile and render our dinamic styles
    add_action('in_admin_header', array($this, 'adminInlineCSS'));
    
    // Add our custom control Body Classes
    add_filter('admin_body_class', array($this, 'addControlAdminClasses'));
    
    // Load our Edit Menu Module
    add_action('init', array($this, 'editMenuModule'));
    
  } // end Plugin;
  
  /**
   * SPECIFIC METHODS CALLED BY PLUGIN
   * The methods bellow are exclusive to this plugin, and they are called by the Plugin method
   */
  
  /**
   * Add a class or many to the body in the dashboard
   * @param  string $classes Classes already attached to the admin body class
   * @return string New body classes string
   */
  function addControlAdminClasses($classes) {
    
    // Our control classes carrier
    $controlClasses = array();
    
    // If the menu position is switched, add the control class "material-wp-menu-$position"
    $controlClasses[] = "material-wp-menu-".$this->options->getOption('menu-position');
    
    // Add class for opacity if the user have selected
    if ($this->options->getOption('parallax-options') == 'parallax') {
      $controlClasses[] = 'material-wp-no-opacity'; 
    }
    
    // Return the classes plus our own
    return "$classes ".implode(' ', $controlClasses);
    
  } // end addControlAdminClasses;
  
  /**
   * Check to see if the current page is the login/register page
   * Use this in conjunction with is_admin() to separate the front-end from the back-end of your theme
   * @return bool
   */
  public function isLoginPage() {
    return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
  }
  
  /**
   * Adds the inline CSS styles to the login page
   */
  public function loginInlineCSS() {
    // wp_enqueue_script('jquery');
    include $this->path('inc/login-styles.php');
  }
  
  /**
   * Adds the inline CSS styles to the login page
   */
  public function adminInlineCSS() {
    
    // Set sass instance
    require_once $this->path('inc/titan-framework/inc/scssphp/scss.inc.php', true);
    if (class_exists('titanscssc')) $sass = new titanscssc();

    // Get our styles
    ob_start();
    
    // We only need our dynamic styles in the backend
    if (is_admin() || $this->isLoginPage()) include $this->path('inc/dynamic-styles.php');
    
    // If we are in the frontend, we just enqueue if options says so
    if (is_admin_bar_showing() && $this->options->getOption('admin-bar-frontend')) {
      include $this->path('inc/wp-admin-bar.php'); 
    }
    
    // Put in a variable
    $styles = ob_get_clean();
    
    // We need to protect our code by handling exceptions
    try {
      
      // If is an object
      if (is_object($sass)) {
                  
        // Compile our code
        $compiledCSS = $sass->compile($styles);

        // Print styles
        printf('<style type="text/css">%s</style>', $compiledCSS);
      
      } // end if;

    } catch (Exception $e) {
      
      // Add the error to our display
      $this->errors[] = __('Something in your Material WP options may be causing SCSS compiling errors. Please verify if all of your options have correct values (a color field, for example, can not contain a value different of a hex code (#fff))');
      
    } // end catch;
    
    // If we are in the admin, compile also the custom code
    if (is_admin() || $this->isLoginPage()) {
      
      // We also need to add to this mixture our custom CSS field contents
      $customCSS = '   ' . $this->options->getOption('custom-css');

      // We need to protect our code by handling exceptions
      try {

        // If is an object
        if (is_object($sass)) {

          // Compile our code
          $compiledCustomCSS = $sass->compile($customCSS);

          // Print styles
          printf('<style type="text/css">%s</style>', $compiledCustomCSS);
        
        } // end if;

      } catch (Exception $e) {
        
        // Add the error to our display
        $this->errors[] = __('Your custom CSS (with SCSS) code has some syntax error. Please verify.');

      } // end catch;
      
    } // end if;
  
  } // end adminInlineCSS;
  
  /**
   * Add the edit menu functionality to the Admin Dashboard
   */
  public function editMenuModule() {
    
    // Only load things if this is enabled
    if (is_object($this->options) && $this->options->getOption('menu-reordering') == false) return;
        
    // Require model
    require_once $this->path('modules/module.php');
    
    // Get Menu edit module
    require_once $this->path('modules/menu-editing/menu-editing.php');
    
  }
  
  /**
   * Clear footer text
   */
  public function clearFooter($text) {
    return '';
  }
  
  /**
   * Adds Parallax Block
   */
  public function addParallaxBlock() {
    // We only add if it is not the VC Frontend
    if (isset($_GET['vc_action']) && $_GET['vc_action'] == 'vc_inline') return;
    // Include our SCSS Compiler class
    $this->render('parallax-block');
  }

  /*
   * Remove the WordPress Logo from the WordPress Admin Bar
   */
  public function editAdminBar() {
    
    // If it does not go to the backend, does even show
    if (!is_admin() && !$this->options->getOption('admin-bar-frontend')) return;
    
    // Get global var admin bar
    global $wp_admin_bar;
    
    // Remove undesired nodes
    $wp_admin_bar->remove_menu('my-account');
    $wp_admin_bar->remove_menu('wp-logo');
    
    // Updates
    $update_node = $wp_admin_bar->get_node('updates');
    
    // If Node Exists 
    if ($update_node) {
      
      // Add classes
      $update_node->meta['class'] = "force-mdi tooltiped tooltip-ajust";
      // Ajust title
      $update_node->title = str_replace('<span class="ab-icon"></span>', '<i class="mdi-notification-sync"></i>', $update_node->title);

      $updates = array(
        'id'     => $update_node->id,
        'title'  => $update_node->title,
        'href'   => $update_node->href,
        'parent' => $update_node->parent,
        'meta'   => $update_node->meta,
      );
      
      // Add Editted Updates
      $wp_admin_bar->add_node($updates);
      
    }
    
    // We need to check if this is network
    if (!is_network_admin()) {
      
      // Commnets
      $comments_node = $wp_admin_bar->get_node('comments');
      // Add classes
      $comments_node->meta['class'] = "force-mdi tooltiped tooltip-ajust";
      // Ajust title
      $comments_node->title = str_replace('<span class="ab-icon"></span>', '<i class="mdi-notification-sms"></i>', $comments_node->title);

      $comments = array(
        'id'     => $comments_node->id,
        'title'  => $comments_node->title,
        'href'   => $comments_node->href,
        'parent' => $comments_node->parent,
        'meta'   => $comments_node->meta,
      );
      
      // Editted commnets
      $wp_admin_bar->add_node($comments);
      
    } // end if;
    
    // help
    $help = array(
      'id'    => 'mwp-help',
      'title' => '<i class="mdi-action-help"></i>',
      'href'  => wp_logout_url(),
      'parent'=> 'top-secondary',
      'meta'  => array(
        'class' => "force-mdi tooltiped tooltip-ajust",
        'title' => __('Help')
      )
    );
    
    // Settings
    $settings = array(
      'id'    => 'mwp-settings',
      'title' => '<i class="mdi-action-settings"></i>',
      'href'  => admin_url('options-general.php'),
      'parent'=> 'top-secondary',
      'meta'  => array(
        'class' => "force-mdi tooltiped tooltip-ajust",
        'title' => __('Settings')
      )
    );
    
    // Logout
    $logout = array(
      'id'    => 'mwp-logout',
      'title' => '<i class="mdi-action-exit-to-app"></i>',
      'href'  => wp_logout_url(),
      'parent'=> 'top-secondary',
      'meta'  => array(
        'class' => "force-mdi tooltiped tooltip-ajust",
        'title' => __('Logout')
      )
    );
    
    // Editted My Sites
    // $wp_admin_bar->add_node($mysite);
    
    // Add logout
    $wp_admin_bar->add_node($logout);
    // Add settings
    $wp_admin_bar->add_node($settings);
    // Add help
    // $wp_admin_bar->add_node($help);
  }

  /**
   * Add the custom logo based on user choice
   */
  public function addLogo() {
    
    // If it does not go to the backend, does even show
    if (!is_admin() && !$this->options->getOption('admin-bar-frontend')) return;
    
    // Get admin bar global
    global $wp_admin_bar;
    
    // Get Logo Image
    $logo = $this->options->getOption('custom-logo');
    
    // If has nothing, adds nothing
    if (empty($logo) || !$logo) return;
    
    // We need to check if logo is just an id
    $logo = is_numeric($logo) ? $this->getAttachmentURL($logo) : $logo;

    // Check if title is image or text
    $title = "<img class='material-wp-logo' src='". $logo ."'>";
    
    $args = array(
      'id'     => 'my-site-logo',
      'href'   => admin_url(),
      'title'  => $title,
      'meta'   => array(
        'class' => "custom-site-logo",
      )
    );
    
    // Finaly adds the block
    $wp_admin_bar->add_node($args);
    
  } // end addLogo;
  
} // end MaterialWP;

// Now we need to load our config file
$config = include 'config.php';

/**
 * We execute our plugin, passing our config file
 */
$MaterialWP = new MaterialWP($config);