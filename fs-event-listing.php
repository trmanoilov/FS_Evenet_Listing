<?php
/**
 * Plugin Name: Event Listing
 * Description: Coding challenge 
 * Author: tmanoilov
 * Version: 0.1
 * Text Domain: fs-event-listing
 * License: GPL2
*/

define( 'PATH_INCLUDES', dirname( __FILE__ ) . '/inc' );

class FS_Event_Listing {

	public function __construct() {
		add_action('wp_enqueue_scripts', array($this, 'add_css'));

		add_action( 'init', array( $this, 'register_event_post_type' ) );
		
		add_action( 'add_meta_boxes', array( $this, 'add_cf_metaboxes' ) );

		add_action( 'save_post', array( $this, 'save_cfs' ) );

		add_action( 'init', array( $this, 'register_shortcode' ) );
	}

	public function register_event_post_type() {
		register_post_type( 'fs_event', array(
			'labels' => array(
				'name' => __("Events", 'fs_event'),
				'singular_name' => __("Event", 'fs_event'),
				'add_new' => __("Add New", 'fs_event' ),
				'add_new_item' => __("Add New Event", 'fs_event' ),
				'edit_item' => __("Edit Event", 'fs_event' ),
				'new_item' => __("New Event", 'fs_event' ),
				'view_item' => __("View Event", 'fs_event' ),
				'search_items' => __("Search Events", 'fs_event' ),
				'not_found' =>  __("No events found", 'fs_event' ),
				'not_found_in_trash' => __("No events found in Trash", 'fs_event' ),
			),
			'description' => __("Events", 'fs_event'),
			'public' => true,
			'publicly_queryable' => true,
			'rewrite' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'menu_position' => 40,
			'supports' => array(
				'title',
				'editor',
				'thumbnail',
				'custom-fields',
				'page-attributes'
			)
			)
		);
	}

	public function add_cf_metaboxes() {
		add_meta_box(
			'fs_event_details',
			'Event Details',
			array( $this, 'fs_event_details'),
			'fs_event',
			'side',
			'default'
		);
	}

	public function fs_event_details( $post, $metabox )
	{
		$fs_event_date = "";
		$fs_event_location = "";
		$fs_event_url = "";

		if( !empty( $post ) ) {
			$fs_event_date = get_post_meta( $post->ID, 'fs_event_date', true );
			$fs_event_location = get_post_meta( $post->ID, 'fs_event_location', true );
			$fs_event_url = get_post_meta( $post->ID, 'fs_event_url', true );
		}
		?>
		<label for="fs_event_date">Event Date</label><br/>
		<input type="date" id="fs_event_date" name="fs_event_date" value="<?=$fs_event_date?>"><br/><br/>

		<label for="fs_event_location">Event Location</label><br/>
		<input type="text" id="fs_event_location" name="fs_event_location" value="<?=$fs_event_location?>"><br/><br/>

		<label for="fs_event_url">Event URL</label><br/>
		<input type="text" id="fs_event_url" name="fs_event_url" value="<?=$fs_event_url?>"><br/>

		<?php

	}

	public function save_cfs( $post_id ) {
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! isset( $_POST['post_type'] ) || $_POST['post_type'] != 'fs_event' ) {
			return;
		}
		
		if ( isset( $_POST['fs_event_date']  ) ) {
			update_post_meta( $post_id, 'fs_event_date',  esc_html( $_POST['fs_event_date'] ) );
		}
		if ( isset( $_POST['fs_event_location']  ) ) {
			update_post_meta( $post_id, 'fs_event_location',  esc_html( $_POST['fs_event_location'] ) );
		}
		if ( isset( $_POST['fs_event_url']  ) ) {
			update_post_meta( $post_id, 'fs_event_url',  esc_html( $_POST['fs_event_url'] ) );
		}
	}

	public function register_shortcode() {
		add_shortcode( 'fs_events_list', array( $this, 'show_events_list' ) );
	}

	public function show_events_list( $attr, $content = null ) {
		include_once( PATH_INCLUDES . '/events-list-template.php' );
	}
	
	public function add_css() {
		wp_register_style( 'fs_styles', plugins_url( '/css/style.css', __FILE__ ), array(), '1.0', 'screen' );
		wp_enqueue_style( 'fs_styles' );
	}
	
}

$fs_event_listing = new FS_Event_Listing();

