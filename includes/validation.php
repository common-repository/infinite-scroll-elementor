<?php
namespace InfiniteScrollElementorNameSpace;

class Plugin {

	private static $_instance = null;
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function widget_scripts() {
		wp_register_script( 'infinite-scroll-elementor-js', plugins_url( '../assets/js/infinite-scroll-elementor.js', __FILE__ ), [ 'jquery' ], false, true );
		wp_register_script( 'infinite-scroll-elementor-jetsmartfilters-js', plugins_url( '../assets/js/infinite-scroll-elementor-jetsmartfilters.js', __FILE__ ), [ 'jquery' ], false, true );
	}
	
	public function widget_styles() {
		wp_register_style( 'infinite-scroll-elementor-css', plugins_url( '../assets/css/infinite-scroll-elementor.css', __FILE__ ) );
	}

	private function include_widgets_files() {
		require_once( __DIR__ . '/widgets/infinite-scroll-ise-widget.php' );
	}
	public function register_widgets() {
		$this->include_widgets_files();

		// Register Widgets
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\ISE_InfiniteScroll() );
	}
	
	public function __construct() {
		// Register widgets scripts
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
		
		// Register widgets styles
        add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'widget_styles' ] );

		// Register widgets
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
		
        // Register widgets category
        add_action( 'elementor/init', function() {
	        \Elementor\Plugin::$instance->elements_manager->add_category(
		        'infinite-scroll-elementor-category',
		        [
			        'title' => __( 'Infinite Scroll Elementor', 'infinite-scroll-elementor-td' ),
		        ],
		        1 // Position
	        );
        } );
	}
}
// Instantiate Plugin Class
Plugin::instance();