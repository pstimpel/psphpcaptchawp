<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wp.peters-webcorner.de
 * @since      1.0.0
 *
 * @package    Psphpcaptchawp
 * @subpackage Psphpcaptchawp/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Psphpcaptchawp
 * @subpackage Psphpcaptchawp/admin
 * @author     Peter Stimpel <pstimpel+wordpress@googlemail.com>
 */
class Psphpcaptchawp_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Psphpcaptchawp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Psphpcaptchawp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/psphpcaptchawp-admin.css', array(), $this->version, 'all' );
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/psphpcaptchawp-admin.css', array( 'wp-color-picker' ), $this->version, 'all' );
        
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Psphpcaptchawp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Psphpcaptchawp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/psphpcaptchawp-admin.js', array( 'jquery' ), $this->version, false );
        wp_enqueue_media();
        //wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/psphpcaptchawp-admin.js', array(
        // 'jquery', 'wp-color-picker' ), $this->version, false );
        
        
        wp_enqueue_script( 'wp-color-picker');
        wp_enqueue_script( 'wp-color-picker-script-handle', plugins_url('wp-color-picker-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
    
	}
    
    public function add_plugin_admin_menu() {
        
        /*
         * Add a settings page for this plugin to the Settings menu.
         *
         * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
         *
         *        Administration Menus: http://codex.wordpress.org/Administration_Menus
         *
         */
        add_options_page( 'PS PHPCaptcha for Wordpress - Setup', 'PSPHPCaptchaWP', 'manage_options',
            $this->plugin_name,
            array
            ($this, 'display_plugin_setup_page')
        );
    }
    
    public function add_action_links( $links ) {
        /*
        *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
        */
        $settings_link = array(
            '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
        );
        return array_merge(  $settings_link, $links );
        
    }
    
    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */
    
    public function display_plugin_setup_page() {
        include_once( 'partials/psphpcaptchawp-admin-display.php' );
    }
    
    public function options_update() {
        register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
    }
    
    static public function getPresets() {
        $valid=array();
        $valid['stringlength']=6;
        $valid['charstouse']='abcdefghkmnprstuvwxyz23456789';
        $valid['strictlowercase']=1;
        $valid['bgcolor']="#000000";
        $valid['textcolor']="#ffffff";
        $valid['linecolor']="#323232";
        $valid['sizewidth']=200;
        $valid['sizeheight']=50;
        $valid['fontsize']=25;
        $valid['numberoflines']=6;
        $valid['thicknessoflines']=2;
        return $valid;
    }
    
    public function validate($input) {
        // All checkboxes inputs
        $valid = $this::getPresets();
    
        
        $valid['stringlength'] = (isset($input['stringlength']) && !empty($input['stringlength'])) ?
            $input['stringlength'] : $valid['stringlength'];

        $valid['charstouse'] = (isset($input['charstouse']) && !empty($input['charstouse'])) ?
            $input['charstouse'] : $valid['charstouse'];

        $valid['strictlowercase'] = (isset($input['strictlowercase']) && !empty($input['strictlowercase']))
            ? $input['strictlowercase'] : $valid['strictlowercase'];
        
        //bgcolor
        $valid['bgcolor'] = (isset($input['bgcolor']) && !empty($input['bgcolor']))
            ? sanitize_text_field($input['bgcolor']) : $valid['bgcolor'];
        if ( !empty($valid['bgcolor']) && !preg_match( '/^#[a-f0-9]{6}$/i', $valid['bgcolor']  ) ) { // if user insert a HEX color with #
            add_settings_error(
                'bgcolor',                     // Setting title
                'login_background_color_texterror',            // Error ID
                'Please enter a valid hex value color',     // Error message
                'error'                         // Type of message
            );
        }
    
        //textcolor
        $valid['textcolor'] = (isset($input['textcolor']) && !empty($input['textcolor']))
            ? sanitize_text_field($input['textcolor']) : $valid['textcolor'];
        if ( !empty($valid['textcolor']) && !preg_match( '/^#[a-f0-9]{6}$/i', $valid['textcolor']  ) ) { // if user insert a HEX color with #
            add_settings_error(
                'textcolor',                     // Setting title
                'login_background_color_texterror',            // Error ID
                'Please enter a valid hex value color',     // Error message
                'error'                         // Type of message
            );
        }
    
        //linecolor
        $valid['linecolor'] = (isset($input['linecolor']) && !empty($input['linecolor']))
            ? sanitize_text_field($input['linecolor']) : $valid['linecolor'];
        if ( !empty($valid['linecolor']) && !preg_match( '/^#[a-f0-9]{6}$/i', $valid['linecolor']  ) ) { // if user insert a HEX color with #
            add_settings_error(
                'linecolor',                     // Setting title
                'login_background_color_texterror',            // Error ID
                'Please enter a valid hex value color',     // Error message
                'error'                         // Type of message
            );
        }

        $valid['sizewidth'] = (isset($input['sizewidth']) && empty($input['sizewidth']))
            ? $input['sizewidth'] : $valid['sizewidth'];
        
        $valid['sizeheight'] = (isset($input['sizeheight']) && empty($input['sizeheight']))
            ? $input['sizeheight'] : $valid['sizeheight'];
        
        $valid['fontsize'] = (isset($input['fontsize']) && empty($input['fontsize']))
            ? $input['fontsize'] : $valid['fontsize'];
        
        $valid['numberoflines'] = (isset($input['numberoflines']) && empty($input['numberoflines']))
            ? $input['numberoflines'] : $valid['numberoflines'];
        
        $valid['thicknessoflines'] = (isset($input['thicknessoflines']) && empty($input['thicknessoflines']))
            ? $input['thicknessoflines'] : $valid['thicknessoflines'];
        

        return $valid;
    }


}
