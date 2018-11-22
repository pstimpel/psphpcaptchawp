<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wp.peters-webcorner.de
 * @since      1.0.0
 *
 * @package    Psphpcaptchawp
 * @subpackage Psphpcaptchawp/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Psphpcaptchawp
 * @subpackage Psphpcaptchawp/public
 * @author     Peter Stimpel <pstimpel+wordpress@googlemail.com>
 */
require_once __DIR__ . '/../admin/class-psphpcaptchawp-admin.php';


class Psphpcaptchawp_Public {

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
	 * The config of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $config    The current config of this plugin.
	 */
	private $config;
	
	
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		
		
		add_action( 'comment_form_after_fields', array( $this, 'add_captcha_form' ) );
		
		add_filter( 'preprocess_comment', array( $this, 'add_comment_with_captcha' ) );
		
		add_action('init',array($this, 'register_session'));
		
		$this->config = Psphpcaptchawp_Public::getConfig();
		
	}
	
	function register_session(){
		if( !session_id() )
			session_start();
	}
	
	public static function setSession($value) {
		$_SESSION['psphpcaptchawp_challenge'] = $value;
	}
	
	public static function getConfig() {
		
		$preset = Psphpcaptchawp_Admin::getPresets();
		
		$preset['strictlowercase'] = ($preset['strictlowercase'] == 1) ? true:false;
		
		if(file_exists(__DIR__ . "/../config.php")) {
			require_once __DIR__ . "/../config.php";
			$preset['stringlength']=$stringlength;
			$preset['charstouse']=$charstouse;
			$preset['strictlowercase']=$strictlowercase;
			$preset['bgcolor']=$bgcolor;
			$preset['textcolor']=$textcolor;
			$preset['linecolor']=$linecolor;
			$preset['sizewidth']=$sizewidth;
			$preset['sizeheight']=$sizeheight;
			$preset['fontsize']=$fontsize;
			$preset['numberoflines']=$numberoflines;
			$preset['thicknessoflines']=$thicknessoflines;
			$preset['allowad']=$allowad;
			
		}
		
		return $preset;
	}
	
	function add_captcha_form() {
		
		echo '<p><img src="'.plugin_dir_url(__FILE__).'renderimage.php" alt="PS PHPCaptcha WP" title="PS PHPCaptcha WP"/>';
		if($this->config['allowad'] == "1") {
			echo '<br><small><a href="https://github.com/pstimpel/ps-phpcaptcha-wp" target="_blank">PS PHPCaptcha for Wordpress</a></small>';
		}
		echo '</p>';
	
		echo '<p class="comment-form-captcha">';
		echo '<label for="captcha">';
		_e('Enter text displayed at Captcha image', 'psphpcaptchawp');
		echo '<span class="required"> *</span></label>';
		echo '<input id="captcha" name="captcha" type="text" value="" size="30" maxlength="'.$this->config['stringlength'].'"
			aria-describedby="email-notes" required="required" />';
		echo '</p>';

	}
	
	function add_comment_with_captcha( $comment ) {
		
		$current_user = wp_get_current_user();
		if (user_can( $current_user, 'administrator' )) {

			//loggedin admins, no captcha displayed, no check needed
			
			return $comment;

		} else {
			
			if ( ! isset( $_SESSION['psphpcaptchawp_challenge'] ) || ! isset( $_POST['captcha'] ) || strlen( $_POST['captcha'] ) == 0 ) {
				wp_die( __( 'Please enter the displayed text into the Captcha text field below the Captcha image',
					'psphpcaptchawp' ) );
			}
			
			if ( $this->config['strictlowercase'] == 1 ) {
				if ( strcmp( strtolower( $_SESSION['psphpcaptchawp_challenge'] ),
						strtolower( $_POST['captcha'] ) ) === 0 ) {
					return $comment;
				}
			} else {
				if ( strcmp( $_SESSION['psphpcaptchawp_challenge'], $_POST['captcha'] ) === 0 ) {
					return $comment;
				}
			}
			
			wp_die( __( 'Captcha solved wrong, please try again!', 'psphpcaptchawp' ) );
			
		}
		
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/psphpcaptchawp-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/psphpcaptchawp-public.js', array( 'jquery' ), $this->version, false );

	}

}
