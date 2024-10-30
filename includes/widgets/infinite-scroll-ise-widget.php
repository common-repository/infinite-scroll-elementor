<?php
namespace InfiniteScrollElementorNameSpace\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;
class ISE_InfiniteScroll extends Widget_Base {	
		public function get_name() {
			return 'infinite-scroll-elementor-widget';
		}
		public function get_title() {
			return __( 'Infinite Scroll - ISE', 'infinite-scroll-elementor-td' );
		}
		public function get_icon() {
			return ' eicon-flash';
		}
		public function get_categories() {
			return [ 'infinite-scroll-elementor-category' ];
		}
		public function get_script_depends() {
			return [ 'infinite-scroll-elementor-js', 'infinite-scroll-elementor-jetsmartfilters-js' ];
		}
	   public function get_style_depends() {
			return [ 'infinite-scroll-elementor-css' ];
		}

		protected function _register_controls() {
		$this->start_controls_section(
			'pagination_settings',
			[
				'label' => __( 'Infinite Scroll - ISE', 'infinite-scroll-elementor-td' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'apply_type_setting',
			[
				'label'       => __( 'Infinite Scroll', 'infinite-scroll-elementor-td' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'default'      => 'yes',	
				'label_on'     => __( 'yes', 'infinite-scroll' ),
				'label_off'    => __( 'no', 'infinite-scroll' ),
				'return_value' => 'yes',
			]
		);
		$this->add_control(
			'pagination_for_setting',
			[
				'label'       => __( 'Pagination For', 'infinite-scroll-elementor-td' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'default'     => 'elementor-pro-posts',
				'options'     => [
					'elementor-pro-posts'            => __( 'Elementor Pro Posts', 'infinite-scroll-elementor-td' ),
					'elementor-pro-products'         => __( 'Elementor Pro Products', 'infinite-scroll-elementor-td' ),					
					'elementor-pro-archive-posts'    => __( 'Elementor Pro Archive Posts', 'infinite-scroll-elementor-td' ),
					'elementor-pro-archive-products' => __( 'Elementor Pro Archive Products', 'infinite-scroll-elementor-td' ),
					'use-custom-selectors'           => __( 'Add Custom Selectors', 'infinite-scroll-elementor-td' ),
				],
				'condition' => [
					'apply_type_setting' => 'yes',
				]
			]
		);
		$this->add_control(
			'widget_setting',
			[
				'label'       => __( 'Insert <u>Widget Section</u> ID', 'infinite-scroll-elementor-td' ),
				'separator' => 'before',
				'label_block' => true,
				'placeholder' => __( 'E.g. #post-widget-section', 'infinite-scroll-elementor-td' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
			]
		);
		$this->add_control(
			'documentation',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => __( 'Infinite Scroll Elementor plugin adds advanced Ajax Load More and Infinite Scroll functions to Elementor widgets, for Step By Step tutorial.<br><a href="https://joychetry.com/infinite-scroll-elementor" target="_blank">Check Documentation</a>', 'infinite-scroll-elementor-td' ),
				'content_classes' => 'elementor-control-raw-html elementor-panel-alert elementor-panel-alert-info',
			]
		);
		$this->end_controls_section();
		
		$this->start_controls_section(
			'custom_selectors_section',
			[
				'label' => __( 'Custom Selectors', 'infinite-scroll-elementor-td' ),
				'condition' => [
					'pagination_for_setting' => 'use-custom-selectors',
				]
			]
		);
		$this->add_control(
			'custom_selector_navigation_setting',
			[
				'label'       => __( 'Navigation Selector', 'infinite-scroll-elementor-td' ),
				'label_block' => true,
				'placeholder' => __( 'E.g. nav.navigation', 'infinite-scroll-elementor-td' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'condition' => [
					'pagination_for_setting' => 'use-custom-selectors',
				]
			]
		);
		$this->add_control(
			'custom_selector_next_setting',
			[
				'label'       => __( 'Next Selector', 'infinite-scroll-elementor-td' ),
				'label_block' => true,
				'placeholder' => __( 'E.g. a.next', 'infinite-scroll-elementor-td' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'condition' => [
					'pagination_for_setting' => 'use-custom-selectors',
				]
			]
		);
		$this->add_control(
			'custom_selector_content_setting',
			[
				'label'       => __( 'Content Selector', 'infinite-scroll-elementor-td' ),
				'label_block' => true,
				'placeholder' => __( 'E.g. div.items', 'infinite-scroll-elementor-td' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'condition' => [
					'pagination_for_setting' => 'use-custom-selectors',
				]
			]
		);
		$this->add_control(
			'custom_selector_item_setting',
			[
				'label'       => __( 'Item Selector', 'infinite-scroll-elementor-td' ),
				'label_block' => true,
				'placeholder' => __( 'E.g. div.item', 'infinite-scroll-elementor-td' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'condition' => [
					'pagination_for_setting' => 'use-custom-selectors',
				]
			]
		);
		$this->end_controls_section();	
		
		$this->start_controls_section(
			'assign_options_section',
			[
				'label' => __( 'Extra Options', 'infinite-scroll-elementor-td' ),
			]
		);
		$this->add_control(
			'loading_image_ID_setting',
			[
				'label'       => __( 'Assign <u>Loading Image Section</u> ID', 'infinite-scroll-elementor-td' ),
				'label_block' => true, 
				'placeholder' => __( 'E.g. #loading-image-section', 'infinite-scroll-elementor-td' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
			]
		);
		$this->add_control(
			'no_more_items_ID_setting',
			[
				'label'       => __( 'Assign <u>No More Items Section</u> ID', 'infinite-scroll-elementor-td' ),
				'label_block' => true, 
				'placeholder' => __( 'E.g. #no-more-items-section', 'infinite-scroll-elementor-td' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
			]
		);
		$this->add_control(
			'imageratio_setting',
			[
				'label'        => __( 'Image Ratio', 'infinite-scroll-elementor-td' ),
				'separator'    => 'before',
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'yes', 'infinite-scroll-elementor-td' ),
				'label_off'    => __( 'no', 'infinite-scroll-elementor-td' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'description' => __( 'Make Image Ratio "Yes" if you have modified Image Ratio in the target widget. Make it "Yes" or "No" to what fits best.', 'infinite-scroll-elementor-td' ),
			]
		);
		$this->add_control(
			'jetsmartfilters_setting',
			[
				'label'        => __( 'JetSmartFilters Support', 'infinite-scroll-elementor-td' ),
				'separator'    => 'before',
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'yes', 'infinite-scroll-elementor-td' ),
				'label_off'    => __( 'no', 'infinite-scroll-elementor-td' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'description' => __( 'Turn  JetSmartFilters to "Yes" if you are using JetSmartFilters plugin, ignore if you do not use it.', 'infinite-scroll-elementor-td' ),
			]
		);
		$this->add_control(
			'bottom_offset_setting',
			[
				'label'     => __( 'Bottom Offset', 'infinite-scroll-elementor-td' ),
				'separator' => 'before',
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'min'       => 0,
				'max'       => 100000,
				'step'      => 10,
				'default'   => 200,
			]
		);
		$this->add_control(
			'animation_time_setting',
			[
				'label'     => __( 'Animation Time', 'infinite-scroll-elementor-td' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'min'       => 0,
				'max'       => 100000,
				'step'      => 10,
				'default'   => 1000,
			]
		);
		$this->end_controls_section();
	}

	protected function render() {		
	    $settings = $this->get_settings_for_display();		
        if ( ! is_admin() ) {
            echo '<style>';
			echo '.elementor-widget-infinite-post-elementor-widget { display: none !important; } ';
			if( $settings['widget_setting'] !== '' ) {		
		        echo $settings['widget_setting'] . ' { display: none !important; } ';
		    }
			if( $settings['load_more_setting'] !== '' ) {		
		        echo $settings['load_more_setting'] . ' { display: none; } '; /* Do not use !important */
		    }		
			if( $settings['loading_image_setting'] !== '' ) {		
		        echo $settings['loading_image_setting'] . ' { display: none; } '; /* Do not use !important */
		    }
			if( $settings['no_more_items_setting'] !== '' ) {		
		        echo $settings['no_more_items_setting'] . ' { display: none; } '; /* Do not use !important */
		    }
		    if( $settings['pagination_for_setting'] == 'elementor-pro-archive-posts' || $settings['pagination_for_setting'] == 'elementor-pro-posts' ) {
				echo 'nav.elementor-pagination { display: none !important; } ';
		    }
		    elseif( $settings['pagination_for_setting'] == 'elementor-pro-archive-products' || $settings['pagination_for_setting'] == 'elementor-pro-products' ) {
				echo 'nav.woocommerce-pagination { display: none !important; } ';
		    }
		    else {
				echo $settings['custom_selector_navigation_setting'] . ' { display: none !important; }';
			}
            echo '</style>';
        }
		
		if( $settings['apply_type_setting'] == 'load-more' ) {
		    $options['event'] = 'click';
		}
		if( $settings['pagination_for_setting'] == 'elementor-pro-archive-posts' || $settings['pagination_for_setting'] == 'elementor-pro-posts' ) {
		    $options['navigationSelector'] = 'nav.elementor-pagination';
		    $options['nextSelector'] = 'a.page-numbers.next';
		    $options['contentSelector'] = '.elementor-posts-container';
		    $options['itemSelector'] = '.elementor-post';
		}
		elseif( $settings['pagination_for_setting'] == 'elementor-pro-archive-products' ) {
		    $options['contentSelector'] = 'ul.products';
		    $options['itemSelector'] = 'li.product';
			$options['navigationSelector'] = 'nav.woocommerce-pagination';
		    $options['nextSelector'] = 'a.next.page-numbers';
		}
		elseif( $settings['pagination_for_setting'] == 'elementor-pro-products' ) {			
            $options['contentSelector'] = 'ul.products';
		    $options['itemSelector'] = 'li.product';
			$options['navigationSelector'] = 'nav.woocommerce-pagination';
		    $options['nextSelector'] = 'a.next.page-numbers';
			$options['paginationType'] = 'product-page';
		}
		else {			
		    $options['navigationSelector'] = $settings['custom_selector_navigation_setting'];
		    $options['nextSelector'] = $settings['custom_selector_next_setting'];
		    $options['contentSelector'] = $settings['custom_selector_content_setting'];
		    $options['itemSelector'] = $settings['custom_selector_item_setting'];
		}		
		$options['loadMore'] = $settings['load_more_setting'];	
		$options['loadingImage'] = $settings['loading_image_setting'];$options['finishText'] = $settings['no_more_items_setting'];
		
		if ( $settings['imageratio_setting'] === 'yes' ) {
			$options['imageRatio'] = $settings['imageratio_setting'];
		}
		$options['animationTime'] = $settings['animation_time_setting'];
		$options['bottomOffset'] = $settings['bottom_offset_setting'];
		if ( $settings['jetsmartfilters_setting'] === 'yes' ) {
			wp_deregister_script( 'infinite-scroll-elementor-js' );
		    wp_localize_script( 'infinite-scroll-elementor-jetsmartfilters-js', 'selector', $options );
	        wp_enqueue_script( 'infinite-scroll-elementor-jetsmartfilters-js' );
		}
		else {
			wp_deregister_script( 'infinite-scroll-elementor-jetsmartfilters-js' );
		    wp_localize_script( 'infinite-scroll-elementor-js', 'selector', $options );
	        wp_enqueue_script( 'infinite-scroll-elementor-js' );
		}
	}
}