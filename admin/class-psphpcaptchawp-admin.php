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
	 * The webpath to renderImage.php
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $urlRenderImage    The webpath to renderImage.php
	 */
	private $urlRenderImage;
	
	
	/**
	 * is true, if this is a multisite wordpress installation.
	 *
	 * @since    1.1.0
	 * @access   private
	 * @var      bool    $isMultisite   is this a multisite installation
	 */
	private $isMultisite;
	
	/**
	 * keeps the current blogid, if is multisite
	 *
	 * @since 1.1.0
	 * @access private
	 * @var string $blogId keeps the blogid on multisite installations, empty on singlesite installs
	 */
	private $blogId;
	
	
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
		
		
		$this->blogId = '';
		
		if ( is_multisite() ) {
			$this->isMultisite = true;
			$this->blogId = get_current_blog_id();
		} else {
			$this->isMultisite = false;
		}
		
		$this->urlRenderImage = plugin_dir_url(__FILE__).'../public/renderimage.php?blogid='.$this->blogId;
		
	}
	
	public static function getBlogId() {
		if(is_multisite()) {
			return get_current_blog_id();
		} else {
			return "";
		}
	}
	
	
	
	public static function isMultisite() {
		
		if ( is_multisite() ) {
			return true;
		} else {
			return false;
		}
		
		
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
        add_options_page( __('PS PHPCaptcha for Wordpress - Setup','psphpcaptchawp'), 'PSPHPCaptchaWP', 'manage_options',
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
            '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' .
            __('Settings', 'psphpcaptchawp') . '</a>',
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
        $valid['charstouse']='abcdefghkmnpqrtuvwxyz23456789';
        $valid['strictlowercase']=1;
        $valid['bgcolor']="#000000";
        $valid['textcolor']="#ffffff";
        $valid['linecolor']="#323232";
        $valid['sizewidth']=200;
        $valid['sizeheight']=50;
        $valid['fontsize']=25;
        $valid['numberoflines']=6;
        $valid['thicknessoflines']=2;
        $valid['allowad']=0;
        return $valid;
    }
    
    private function sanitize_color($valid, $input, $setting_title, $setting_errorid) {
	    $validreturn = (isset($input) && !empty($input))
		    ? sanitize_text_field($input) : $valid;
	    if ( !empty($validreturn) && !preg_match( '/^#[a-f0-9]{6}$/i', $validreturn ) ) {
		    add_settings_error(
			    $setting_title,                     // Setting title
			    $setting_errorid,            // Error ID
			    sprintf(__('Please enter a valid hex value for %s, (#RRGGBB)','psphpcaptchawp'), $setting_title),
			    //
			    # Error
			    'error'                         // Type of message
		    );
		    return $valid;
	    }
	    return $validreturn;
    }
	
	private function sanitize_integer($valid, $input, $setting_title, $setting_errorid) {
		$validreturn = (isset($input) && !empty($input))
			? sanitize_text_field($input) : $valid;
		if ( !empty($validreturn) && !preg_match( '/^[0-9]/i', $validreturn ) ) {
			add_settings_error(
				$setting_title,                     // Setting title
				$setting_errorid,            // Error ID
				sprintf(__('Please enter a valid integer value for %s','psphpcaptchawp'), $setting_title),     // Error
				// message
				'error'                         // Type of message
			);
			return $valid;
		}
		return $validreturn;
	}
	
	private function sanitize_charstouse($valid, $input, $setting_title, $setting_errorid, $minlength, $sourceIfForm) {
		if($sourceIfForm) {
			if(strlen($input) < $minlength) {
				add_settings_error(
					$setting_title,                     // Setting title
					$setting_errorid,            // Error ID
					sprintf(__('Please enter a valid value for %s, at least %d chars long', 'psphpcaptchawp')
						, $setting_title, $minlength), // Error message
					'error'                         // Type of message
				);
				return $valid;
			}
			if ( !preg_match( '/^[a-zA-Z0-9]/i', $input )) {
				add_settings_error(
					$setting_title,                     // Setting title
					$setting_errorid,            // Error ID
					sprintf(__('Please enter a valid value for %s, at least %d chars long', 'psphpcaptchawp')
						, $setting_title, $minlength), // Error message
					'error'                         // Type of message
				);
				return $valid;
			}
			return $input;
		} else {
			return $valid;
		}
	}
	
	private function sanitize_boolean($valid, $input, $setting_title, $setting_errorid, $sourceIsForm) {
        if($sourceIsForm) {
            if(isset($input) && $input == "1") {
                $validreturn = 1;
            } else {
                $validreturn = 0;
            }
        } else {
            $validreturn = $valid;
        }
		if ( !empty($validreturn) && !preg_match( '/^[0-1]{1}$/i', $validreturn )) {
			add_settings_error(
				$setting_title,                     // Setting title
				$setting_errorid,            // Error ID
				sprintf(__('Please enter a valid value for %s, (on/off)','psphpcaptchawp'), $setting_title),
				// Error
				// Error message
				'error'                         // Type of message
			);
			return $valid;
		}
		return $validreturn;
	}

    public function validate($input) {
        // All checkboxes inputs
        $valid = $this::getPresets();

        $sourceIsForm = false;
        if(isset($valid['stringlength'])) {
            $sourceIsForm = true;
        }
	
	    $valid['stringlength'] = $this->sanitize_integer($valid['stringlength'], $input['stringlength'],
            __('Number of characters','psphpcaptchawp') , 'stringlength');
        
        $valid['charstouse'] = $this->sanitize_charstouse($valid['charstouse'], $input['charstouse'],
            __('Characters allowed','psphpcaptchawp'), 'charstouse', 10, $sourceIsForm );

        $valid['strictlowercase'] = $this->sanitize_boolean($valid['strictlowercase'], $input['strictlowercase'],
            __('Strict to lower case','psphpcaptchawp'), 'strictlowercase', $sourceIsForm);
        
        //bgcolor
        $valid['bgcolor'] = $this->sanitize_color($valid['bgcolor'], $input['bgcolor'],
            __('Background color','psphpcaptchawp'), 'background_color');
    
        //textcolor
	    $valid['textcolor'] = $this->sanitize_color($valid['textcolor'], $input['textcolor'],
            __('Text color','psphpcaptchawp'), 'text_color');
    
        //linecolor
	    $valid['linecolor'] = $this->sanitize_color($valid['linecolor'], $input['linecolor'],
            __('Line color','psphpcaptchawp'), 'line_color');

        $valid['sizewidth'] = $this->sanitize_integer($valid['sizewidth'], $input['sizewidth'],
	        __('Image width','psphpcaptchawp'), 'sizewidth');
        
        $valid['sizeheight'] = $this->sanitize_integer($valid['sizeheight'], $input['sizeheight'],
	        __('Image height','psphpcaptchawp'), 'sizeheight');
        
        $valid['fontsize'] = $this->sanitize_integer($valid['fontsize'], $input['fontsize'],
	        __('Font size','psphpcaptchawp'), 'fontsize');
        
        $valid['numberoflines'] = $this->sanitize_integer($valid['numberoflines'], $input['numberoflines'],
	        __('Number of lines','psphpcaptchawp'), 'numberoflines');
        
        $valid['thicknessoflines'] = $this->sanitize_integer($valid['thicknessoflines'], $input['thicknessoflines'],
	        __('Thickness of lines','psphpcaptchawp'), 'thicknessoflines');
	    	
        $valid['allowad'] = $this->sanitize_integer($valid['allowad'], $input['allowad'],
	        __('Allow small advertisement below Captcha image','psphpcaptchawp'), 'allowad');

	    //write setting into file for db-less access
	    $file = __DIR__ ."/../config".$this->blogId.".php";
	    
	    $current='';
	    $current .= "<?php\n";
	    $current .= "//do not edit this file, gets overwritten by admin actions\n";
	    $current .= "//created ".date("Y-m-d H:i:s O")."\n";
	    $current .= '$stringlength='.$valid['stringlength'].";\n";
	    $current .= '$charstouse=\''.$valid['charstouse']."';\n";
	    $current .= '$strictlowercase='.($valid['strictlowercase'] == "1" ? "true":"false").";\n";
	    $current .= '$bgcolor=\''.$valid['bgcolor']."';\n";
	    $current .= '$textcolor=\''.$valid['textcolor']."';\n";
	    $current .= '$linecolor=\''.$valid['linecolor']."';\n";
	    $current .= '$sizewidth='.$valid['sizewidth'].";\n";
	    $current .= '$sizeheight='.$valid['sizeheight'].";\n";
	    $current .= '$fontsize='.$valid['fontsize'].";\n";
	    $current .= '$numberoflines='.$valid['numberoflines'].";\n";
	    $current .= '$thicknessoflines='.$valid['thicknessoflines'].";\n";
	    $current .= '$allowad='.($valid['allowad'] == "1" ? "true":"false").";\n";
	    $current .= "\n\n\n//END OF FILE\n";
	    
		file_put_contents($file, $current);
	
	    return $valid;
    }


}
