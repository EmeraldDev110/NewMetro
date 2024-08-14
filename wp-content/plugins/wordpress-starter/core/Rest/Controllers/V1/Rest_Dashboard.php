<?php
namespace SiteGround_Central\Rest\Controllers\V1;

use DOMDocument;
use SiteGround_Central\Wizard\Wizard;
use SiteGround_Central\ThirdParty\ThirdParty;
use SiteGround_Helper\Helper_Service;

/**
 * Class responsible for Dashboard Page.
 */
class Rest_Dashboard extends Rest {
	/**
	 * Register the routes for the Dashboard page.
	 *
	 * @since  3.0.0
	 */
	public function register_routes() {
		// Add the GET request.
		register_rest_route(
			'siteground-central/v1',
			'/dashboard/',
			array(
				'methods'             => \WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_dashboard_data' ),
				'permission_callback' => array( $this, 'check_permissions' ),
			)
		);
		register_rest_route(
			'siteground-central/v1',
			'/wp-events/',
			array(
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'get_user_events' ),
				'permission_callback' => array( $this, 'check_permissions' ),
			)
		);
	}

	/**
	 * Get the dashboard page data.
	 *
	 * @since 3.0.0
	 *
	 * @param  \WP_REST_Request $request                     Full details about the request.
	 *
	 * @return \WP_Error|\WP_HTTP_Response|\WP_REST_Response Response object.
	 */
	public function get_dashboard_data() {
		// Prepare the data array.
		$data = array(
			'banner'           => $this->get_banner_data(),
			'notices'          => $this->get_notices_data(),
			'design'           => $this->get_design_data(),
			'functionality'    => $this->get_functionality_links_data(),
			'useful_links'     => $this->get_useful_links_data(),
			'wp_events'        => $this->get_wp_events_data(),
		);

		// Send the response.
		return self::send_response( $data );
	}

	/**
	 * Gets the banner data.
	 *
	 * @since 3.0.0
	 *
	 * @return array $data The banner data.
	 */
	public function get_banner_data() {
		// Prepare the data array.
		$data = (object) array();

		// Bail if the wizard is already completed.
		if ( Wizard::is_wizard_completed() ) {
			return $data;
		}

		$data = array(
			'title'       => __( 'WordPress Starter Available!', 'siteground-wizard' ),
			'description' => __( 'Select design, functionality and marketing plugins and start working on your site right away!', 'siteground-wizard' ),
			'button_text' => __( 'START NOW', 'siteground-wizard' ),
			'button_link' => admin_url( 'index.php?page=siteground-wizard' ),
		);

		// Change the title and description if it is a Woo Wizard.
		if ( 'Woo' === Wizard::get_wizard_name() ) {
			$data['title'] = __( 'WooCommerce Starter Available!', 'siteground-wizard' );
			$data['description'] = __( 'Select design, functionality and marketing plugins and start working on your online store right away!', 'siteground-wizard' );
		}

		// Return the data.
		return $data;
	}

	/**
	 * Gets the Important notices section data.
	 *
	 * @since 3.0.0
	 *
	 * @return array $data The Important notices data.
	 */
	public function get_notices_data() {
		// Prepare the data array.
		$data = (object) array();

		// Add notification if we have updates available.
		if ( Helper_Service::has_updates() ) {
			$data = array(
				'section_title' => __( 'Important Notifications', 'siteground-wizard' ),
				'title'         => __( 'Your WordPress needs attention!', 'siteground-wizard' ),
				'description'   => __( 'There are new updates for your website. Check them out and apply the new versions to keep your site updated and secure!', 'siteground-wizard' ),
				'button_text'   => __( 'Update', 'siteground-wizard' ),
				'button_link'   => admin_url( 'update-core.php' ),
			);
		}

		// Return the data.
		return $data;
	}

	/**
	 * Gets the Manage Design section data.
	 *
	 * @since 3.0.0
	 *
	 * @return array $data The Manage Design data.
	 */
	public function get_design_data() {
		// Get the current theme.
		$theme = wp_get_theme();
		$pages = wp_count_posts( 'page' );

		// Prepare the data array.
		$data = array(
			'section_title' => __( 'Manage Design', 'siteground-wizard' ),
			'site_design'   => (object) array(),
			'pages_design'  => (object) array(),
			'theme_design'  => (object) array(),
		);

		// View Site.
		$data['site_design'] = array(
			'title'       => __( 'View Site', 'siteground-wizard' ),
			'description' => __( 'Check out how your website looks!', 'siteground-wizard' ),
			'button_text' => __( 'View Site', 'siteground-wizard' ),
			'button_link' => get_home_url( '/' ),
		);

		// Manage Pages.
		if ( $pages->publish > 0 ) {
			$data['pages_design'] = array(
				'title'       => __( 'Manage Pages', 'siteground-wizard' ),
				'description' => __( 'Edit and create new Pages', 'siteground-wizard' ),
				'button_text' => __( 'Manage Pages', 'siteground-wizard' ),
				'button_link' => admin_url( 'edit.php?post_type=page' ),
			);
		}

		// Change Design.
		if ( ! empty( $theme ) ) {
			$data['theme_design'] = array(
				'title'       => __( 'Change Design', 'siteground-wizard' ),
				'description' => __( 'Your current theme is', 'siteground-wizard' ),
				'theme_name'  => $theme->name,
				'button_text' => __( 'Change Theme', 'siteground-wizard' ),
				'button_link' => admin_url( 'themes.php' ),
			);
		}

		// Return the data.
		return $data;
	}

	/**
	 * Gets the Functionality section data.
	 *
	 * @since 3.0.0
	 *
	 * @return array $data The Functionality data.
	 */
	public function get_functionality_links_data() {
		// Prepare the data array.
		$data = array(
			'section_title' => __( 'Manage Functionality', 'siteground-wizard' ),
			'plugins_data'  => array(),
		);

		// Get plugins data.
		$plugins = ThirdParty::get_active_plugins_data();

		if ( empty( $plugins ) ) {
			return $data;
		}

		foreach ( $plugins as $plugin => $plugin_data ) {
			$data['plugins_data'][] = array(
				'title'       => __( $plugin_data['title'], 'siteground-wizard' ),
				'icon'        => $plugin_data['icon'],
				'button_text' => __( 'Manage', 'siteground-wizard' ),
				'button_link' => $plugin_data['link'],
			);
		}

		// Return the data.
		return $data;
	}

	/**
	 * Gets the Useful Links section data.
	 *
	 * @since 3.0.0
	 *
	 * @return array $data The Useful Links data.
	 */
	public function get_useful_links_data() {
		// Prepare the data array.
		$data = array(
			'section_title'   => __( 'Useful Links', 'siteground-wizard' ),
			'starter_links'   => (object) array(),
			'tutorials_links' => (object) array(),
			'kb_links'        => (object) array(),
			'ebook_links'     => (object) array(),
		);

		// Wizard redirect.
		if ( ! Wizard::is_wizard_completed() ) {
			$data['starter_links'] = array(
				'title'       => __( 'Use our WordPress starter for an easier start!', 'siteground-wizard' ),
				'description' => __( 'Our WordPress Starter allows you to choose a fancy design and add plugins with important functionality for your site. It installs and sets up all the items you chose.', 'siteground-wizard' ),
				'button_text' => __( 'Start Now', 'siteground-wizard' ),
				'button_link' => admin_url( 'index.php?page=siteground-wizard' ),
			);

			if ( 'Woo' === Wizard::get_wizard_name() ) {
				$data['starter_links']['title'] = __( 'Use our WooCommerce starter for an easier start!', 'siteground-wizard' );
				$data['starter_links']['description'] = __( 'Our WooCommerce Starter allows you to choose a fancy design and add plugins with important functionality for your site. It installs and sets up all the items you chose.', 'siteground-wizard' );
			}
		}

		// Tutorials.
		$data['tutorials_links'] = array(
			'title'       => __( 'Take Advantage of our WordPress tutorials!', 'siteground-wizard' ),
			'description' => __( 'We have prepared an easy to follow tutorials with everything you need to know about setting up your WordPress site, creating posts and pages, making backups and a lot more.', 'siteground-wizard' ),
			'button_text' => __( 'View WordPress Tutorial', 'siteground-wizard' ),
			'button_link' => 'https://www.siteground.com/tutorials/wordpress/',
		);

		// Knoledge base.
		$data['kb_links'] = array(
			'title'       => __( 'Visit out WordPress knowledge base!', 'siteground-wizard' ),
			'description' => __( 'If you have a how to question about WordPress it’s quite likely that we already have the answer for you in our Knowledge Base. It contains more than 1000 helpful articles.', 'siteground-wizard' ),
			'button_text' => __( 'Visit Knowledge Base', 'siteground-wizard' ),
			'button_link' => 'https://www.siteground.com/kb/',
		);

		// Ebook.
		$data['ebook_links'] = array(
			'title'       => __( 'Read our WordPress ebooks', 'siteground-wizard' ),
			'description' => __( 'Our top experts have shared their know how on WordPress in specialized ebooks on different topics. Take advantage of their knowledge and make your site faster and safer.', 'siteground-wizard' ),
			'button_text' => __( 'Get the Latest Ebook', 'siteground-wizard' ),
			'button_link' => 'https://www.siteground.com/wordpress-speed-optimization-ebook?utm_source=wpdashboard&utm_campaign=ebookwpspeed',
		);

		if ( 'Woo' === Wizard::get_wizard_name() ) {
			$data['ebook_links']['title'] = __( 'Read our WooCommerce ebooks', 'siteground-wizard' );
			$data['ebook_links']['description'] = __( 'Our top experts have shared their know how on WooCommerce in а specialized ebook. Take advantage of their knowledge and make your site faster and safer.', 'siteground-wizard' );
			$data['ebook_links']['button_link'] = 'https://www.siteground.com/woocommerce-ebook?utm_source=wpdashboard';
		}

		// Return the data.
		return $data;
	}

	/**
	 * Gets the WordPress Events section data.
	 *
	 * @since 3.0.0
	 *
	 * @return array $data The WP events data.
	 */
	public function get_wp_events_data() {
		// Prepare the data array.
		$data = array(
			'section_title'            => __( 'WordPress Events and News', 'siteground-wizard' ),
			'events'                   => (object) array(),
			'events_location'          => (object) array(),
			'events_footer'            => (object) array(),
			'latest_news'              => (object) array(),
			'latest_news_footer_links' => (object) array(),
		);

		$data['events'] = $this->get_user_events();
		$data['events_location'] = $this->get_events_location();
		$data['events_footer'] = $this->get_events_footer( $this->get_events_list() );
		$data['latest_news'] = $this->get_latest_news();
		$data['latest_news_footer_links'] = $this->get_news_footer();

		// Return the data.
		return $data;
	}

	/**
	 * Returns the events based on the user location or request parameters.
	 *
	 * @since 3.0.0
	 *
	 * @param  \WP_REST_Request $request                     Full details about the request.
	 *
	 * @return array|mixed|\WP_Error|\WP_REST_Response       Returns an array with the events based on the user location or request parameters.
	 */
	public function get_user_events( $request = null ) {
		$location = '';

		// Get the location, if set in the request params.
		if ( ! empty( $request ) && ! empty( $request->get_params() ) ) {
			$params = $request->get_params();
			$location = $params['location'];
		}

		$events_list = $this->get_events_list( $location );

		// If accessed directly, return properly escaped values.
		if ( ! empty( $request ) ) {
			// Check if there's an error with locating the given city/country/region from the request.
			if ( ! empty( $events_list['error'] ) && "no_location_available" === $events_list['error'] ) {
				return self::send_response(
					array(
						'message' => esc_attr( sprintf( __( '%s could not be located. Please try another nearby city. For example: Kansas City; Springfield; Portland.', 'siteground-wizard' ), $params['location'] ) ),
					),
					0
				);
			}

			// Check if there are no events and return the correct message, if needed.
			if ( empty( $events_list['events'] ) ) {
				return self::send_response(
					array(
						 'message' => sprintf(
								/* translators: 1: The city the user searched for, 2: Meetup organization documentation URL. */
								__( 'There are no events scheduled near %1$s at the moment. Would you like to <a href="%2$s">organize a WordPress event</a>?', 'siteground-wizard' ),
								$events_list['location']['description'],
								__( 'https://make.wordpress.org/community/handbook/meetup-organizer/welcome/' )
						 )
					),
					0
				);
			}
			// Return the events' list.
			return self::send_response( $events_list['events'] );
		}

		return $events_list['events'];
	}

	/**
	 * Retrieve a list of all events in a specific location.
	 *
	 * @since 3.0.0
	 *
	 * @param string $location      Location, passed from the input field.
	 *
	 * @return array|\WP_Error|null Array with all events nearby.
	 */
	public function get_events_list( $location = '' ) {
		$events = $this->get_events( $location );
		$events_list = $events->get_events( $location );
		return $events_list;
	}

	/**
	 * Retrieves the community events object so that it can be used for the events list.
	 *
	 * @since 3.0.0
	 *
	 * @param  string $location      The location that we are searching for, optional.
	 *
	 * @return \WP_Community_Events  Events object.
	 */
	public function get_events( $location ) {
		// Invoke class, if missing.
		if ( ! class_exists( 'WP_Community_Events' ) ) {
			require_once( ABSPATH . '/wp-admin/includes/class-wp-community-events.php' );
		}

		$user_id = get_current_user_id();
		$saved_location = get_user_option( 'community-events-location', $user_id );
		$events = new \WP_Community_Events( $user_id, $saved_location );

		$events_list = $events->get_events( $location );
		// Re-set the user location if changed through the input field.
		if ( $events_list['location'] !== $saved_location ) {
			update_user_option( $user_id, 'community-events-location', $events_list['location'] );
		}

		return $events;
	}


	/**
	 * Retrieves the location set for the community events by the user.
	 *
	 * @since 3.0.0
	 *
	 * @return array Array with all the of the location information.
 	 */
	public function get_events_location() {

		$location = get_user_option( 'community-events-location', get_current_user_id() );
		if ( false !== $location ) {
			return $location;
		}

		$events = new \WP_Community_Events( get_current_user_id(), $location );
		$events_list = $events->get_events( $location );

		return $events_list['location'];

	}
	/**
	 * Retrieve the footer for events list.
	 *
	 * @since 3.0.0
	 *
	 * @param $events_list List of events.
	 *
	 * @return array       Footer data, text and links.
	 */
	public function get_events_footer( $events_list ) {
		if ( empty( $events_list['events'] ) ) {
			$return_string = sprintf(
			/* translators: 1: The city the user searched for, 2: Meetup organization documentation URL. */
				__( 'There are no events scheduled near %1$s at the moment. Would you like to <a href="%2$s">organize a WordPress event</a>?', 'siteground-wizard' ),
				$events_list['location']['description'],
				__( 'https://make.wordpress.org/community/handbook/meetup-organizer/welcome/' )
			);
			return array(
				'no_events' => true,
				'text'      => $return_string,
				'link'      => __( 'https://make.wordpress.org/community/handbook/meetup-organizer/welcome/' ),
			);
		} else {
			return array(
				'text'      => __( 'Want more events?', 'siteground-wizard' ),
				'text_link' => __( ' Help organize the next one!', 'siteground-wizard' ),
				'link'      => __( 'https://make.wordpress.org/community/organize-event-landing-page/' ),
			);
		}

	}

	/**
	 * Get the latest news from the WP RSS feed.
	 *
	 * @since 3.0.0
	 *
	 * @return array Returns an array with the latest news from the WP RSS feed.
	 */
	public function get_latest_news() {
		// Require the file including the dashboard function, if not existing already.
		if ( ! function_exists( 'wp_dashboard_primary_output' ) ) {
			require_once( ABSPATH . '/wp-admin/includes/dashboard.php' );
		}
		$feeds = array(
			'news'   => array(
				'link'         => apply_filters( 'dashboard_primary_link', __( 'https://wordpress.org/news/' ) ),
				'url'          => apply_filters( 'dashboard_primary_feed', __( 'https://wordpress.org/news/feed/' ) ),
				'title'        => apply_filters( 'dashboard_primary_title', __( 'WordPress Blog' ) ),
				'items'        => 2,
				'show_summary' => 0,
				'show_author'  => 0,
				'show_date'    => 0,
			),
			'planet' => array(
				'link'         => apply_filters( 'dashboard_secondary_link', __( 'https://planet.wordpress.org/' ) ),
				'url'          => apply_filters( 'dashboard_secondary_feed', __( 'https://planet.wordpress.org/feed/' ) ),
				'title'        => apply_filters( 'dashboard_secondary_title', __( 'Other WordPress News' ) ),
				'items'        => apply_filters( 'dashboard_secondary_items', 3 ),
				'show_summary' => 0,
				'show_author'  => 0,
				'show_date'    => 0,
			),
		);

		// Retreive HTML from dashboard widget.
		ob_start();
		\wp_dashboard_primary_output('dashboard_primary', $feeds );
		$content = ob_get_clean();

		// Parse HTML from dashboard widget and get all link tags.
		$result = array();
		$html_document = new DOMDocument();
		$html_document->loadHTML( $content );
		$links = $html_document->getElementsByTagName( 'a' );

		// Iterate all found links and assign a new item for them with the respective text and url.
		for ( $i = 0; $i < $links->length; $i++ ) {
			$result[] = array(
				'text' => utf8_decode( $links->item( $i )->textContent ),
				'url'  => $links->item( $i )->attributes->item(1)->value,
			);
		}

		return $result;
	}

	/**
	 * Get the news footer.
	 *
	 * @since 3.0.0
	 *
	 * @return array The links and text for the footer of the news widget.
	 */
	public function get_news_footer() {
		return array(
			array(
				'link' => 'https://make.wordpress.org/community/meetups-landing-page',
				'text' => __( 'Meetups', 'siteground-wizard' ),
			),
			array(
				'link' => 'https://central.wordcamp.org/schedule/',
				'text' => __( 'WordCamps', 'siteground-wizard' ),
			),
			array(
				'link' => esc_url( _x( 'https://wordpress.org/news/', 'Events and News dashboard widget' ) ),
				'text' => __( 'News', 'siteground-wizard' ),
			),
		);
	}
}