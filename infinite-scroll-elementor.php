<?php
/**
 * Plugin Name: Infinite Scroll Elementor
 * Description: Infinite Scroll Elementor adds advanced functions like Infinite Scroll, AJAX Load More, Infinite Single Post Template, etc.
 * Tags: infinite scroll, load more, pagination, paginate, scroll, ajax, posts, products, elementor, woocommerce
 * Plugin URI: https://joychetry.com/infinite-scroll-elementor
 * Author: Joy Chetry
 * Author URI: https://joychetry.com/
 * Version: 1.0.28
 * Text Domain: infinite-scroll-elementor
 */

if ( ! defined( 'ABSPATH' ) ) exit;
final class infinite_scroll_elementor_Final {
	const VERSION = '1.0.28';
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
	const MINIMUM_PHP_VERSION = '5.6';

	public function __construct() {
		add_action( 'init', array( $this, 'i18n' ) );
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	public function i18n() {
		load_plugin_textdomain( 'infinite-scroll-elementor-td' );
	}

	public function init() {
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
			return;
		}
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
			return;
		}
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
			return;
		}
		require_once( 'includes/validation.php' );
	}

	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'infinite-scroll-elementor-td' ),
			'<strong>' . esc_html__( 'Infinite Scroll Elementor', 'infinite-scroll-elementor-td' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'infinite-scroll-elementor-td' ) . '</strong>'
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'infinite-scroll-elementor-td' ),
			'<strong>' . esc_html__( 'Infinite Scroll Elementor', 'infinite-scroll-elementor-td' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'infinite-scroll-elementor-td' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'infinite-scroll-elementor-td' ),
			'<strong>' . esc_html__( 'Infinite Scroll Elementor', 'infinite-scroll-elementor-td' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'infinite-scroll-elementor-td' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
}
new infinite_scroll_elementor_Final();