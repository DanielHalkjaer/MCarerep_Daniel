<?php
/*** Required: set 'ot_theme_mode' filter to true. */
add_filter( 'ot_theme_mode', '__return_true' );

/*** Meta Boxes */
add_filter( 'ot_meta_boxes', '__return_true' );

/* Theme Options screen customizations */
add_filter( 'ot_show_pages', '__return_false' );

add_filter( 'ot_show_new_layout', '__return_false' );

add_filter( 'ot_header_logo_link', function () {
	return sprintf( '<a href="https://one.com/" target="_blank"><img src="%s" /></a>', THM_DIR_URI . '/assets/images/one-com.svg' );
} );

add_filter( 'ot_header_version_text', function () {
	return THM_NAME . '  v' . THM_VER;
} );

/* Modified Field for Colors */
function onecom_social_icons_colors( $array, $field_id ) {

	unset( $array['focus'] );

	$link_fields = array(
		'social_icons_color',
		'logo_color',
	);

	$menu_fields = array(
		'menu_link_color',
		'submenu_link_color',
		'submenu_typo_bg',
		'menu_typo_bg',
	);

	$banner_fields = array(
		'hbanner_text_color',
		'intbanner_text_color',
	);

	$button_fields = array(
		'ban_buttons_text_color',
		'ban_buttonsh_bg',
		'cont_buttons_text_color',
		'cont_buttonsh_bg',
		'form_buttons_text_color',
		'form_buttonsh_bg',
	);

	if ( in_array( $field_id, $button_fields ) ) {
		$array['link']    = __( 'Text Color', 'oct-physiotherapy' );
		$array['hover']   = __( 'Hover Text Color', 'oct-physiotherapy' );
		$array['active']  = __( 'Background Color', 'oct-physiotherapy' );
		$array['visited'] = __( 'Hover Background Color', 'oct-physiotherapy' );
	}

	if ( in_array( $field_id, $banner_fields ) ) {
		$array['link']   = __( 'Big Text Color', 'oct-physiotherapy' );
		$array['hover']  = __( 'Small Text Color', 'oct-physiotherapy' );
		$array['active'] = __( 'Background Color', 'oct-physiotherapy' );
		unset( $array['visited'] );

		return $array;
	}

	if ( in_array( $field_id, $link_fields ) ) {
		unset( $array['visited'] );
		unset( $array['active'] );

		return $array;
	}

	if ( in_array( $field_id, $menu_fields ) ) {
		unset( $array['visited'] );

		return $array;
	}

	if ( 'headings_colors' === $field_id ) {
		$array['h1'] = 'H1';
		$array['h2'] = 'H2';
		$array['h3'] = 'H3';
		$array['h4'] = 'H4';
		$array['h5'] = 'H5';
		$array['h6'] = 'H6';
		unset( $array['link'] );
		unset( $array['hover'] );
		unset( $array['active'] );
		unset( $array['visited'] );


	}

	return $array;
}

add_filter( 'ot_recognized_link_color_fields', 'onecom_social_icons_colors', 10, 2 );

function onecom_buttons_colors( $array, $field_id ) {
	return $array;
}

add_filter( 'ot_recognized_link_color_fields', 'onecom_buttons_colors', 10, 2 );

/* Typography Fields */
function ot_filter_typography_fields( $array, $field_id ) {
	$array = array( 'font-family', 'font-size', 'font-weight', 'line-height', 'font-style', 'text-decoration' );
	if ( 'secondf_typo' === $field_id ) {
		$array = array( 'font-family' );

		return $array;
	}

	return $array;
}

add_filter( 'ot_recognized_typography_fields', 'ot_filter_typography_fields', 10, 2 );
/* Single Unit Field */
function filter_measurement_unit_types( $array, $field_id ) {
	$array['px'] = 'px';
	$array['em'] = 'em';
	$array['pt'] = 'pt';
	unset( $array['%'] );

	return $array;
}

add_filter( 'ot_measurement_unit_types', 'filter_measurement_unit_types', 10, 2 );

/* Change the default list-item "Title" to "Author" */
//function onecom_set_default_item_title($label, $field_id){
//	return ( ( $field_id === 'testimonial_list_item' ) ? __('Author', 'oct-physiotherapy') : $label );
//}
//add_filter('ot_list_item_title_label', 'onecom_set_default_item_title', 10, 2);

/* Header Menu Callback - If no menu set */
function onecom_add_nav_menu() {
	return printf( '<a href="%s"><small><u>Add Menu</u></small></a>', admin_url( 'customize.php?autofocus[panel]=nav_menus' ) );
}

/* To display Price listing and timing listing  */
function lesson_display_details( $value ) {
	if ( ! ( isset( $value ) && ! empty( $value ) ) ) {
		return;
	}

	$html = '<ul>';
	if ( ! empty( $value ) ) {
		$lines = explode( '<br>', $value );
		if ( is_array( $lines ) ) {
			foreach ( $lines as $line ) {
				$html .= '<li>' . stripslashes( wp_kses_decode_entities( $line ) ) . '</li>';
			}
		}
		$html .= '</ul>';

		return $html;
	} else {
		return false;
	}
}

/* Breaks Page Title with <br> tags */
if ( ! function_exists( 'break_page_title' ) ) {
	function break_page_title( $title ) {
		if ( ! strpos( $title, '<br>' ) ) {

			$page_title     = $title;
			$page_breaks    = explode( ' ', $page_title );
			$page_breaks[0] = $page_breaks[0] . '<br />';
			$new_title      = join( ' ', $page_breaks );

			return $new_title;
		}

		return $title;
	}
}

if ( ! function_exists( 'get_the_subtitle' ) ) {
	function get_the_subtitle( $id ) {
		if ( ! $id ) {
			global $post;
			$id = $post->ID;
		}
		$subtitle = get_post_meta( $id, 'page_subtitle', true );
		if ( strlen( $subtitle ) ) {
			return $subtitle;
		}
	}
}


/* Page Subtitle Function */
if ( ! function_exists( 'the_subtitle' ) ) {
	function the_subtitle( $id = '' ) {
		if ( ! $id ) {
			global $post;
			$id = $post->ID;
		}
		$subtitle = get_the_subtitle( $id );
		if ( strlen( $subtitle ) ) {
			printf( '<h6>%s</h6>', $subtitle );
		}

		return;
	}
}


/* Section Background Image URL */
function get_section_background_image( $key ) {

	global $post;
	$post_id = $post->ID;
	if ( ! isset( $post_id ) && ! isset( $key ) ) {
		return;
	}

	$image_id = get_post_meta( $post_id, $key, true );
	if ( ! is_array( $image_id ) && strlen( $image_id ) ) {

		$image_url = wp_get_attachment_image_src( $image_id, 'full' );
		if ( ! empty( $image_url ) ) {
			return $banner_img_url = $image_url[0];
		}

		return;
	}

	return;
}


/* Handle contact form request */
add_action( 'wp_ajax_send_contact_form', 'send_contact_form' );
add_action( 'wp_ajax_nopriv_send_contact_form', 'send_contact_form' );

function send_contact_form() {

	/* Check Nonce */
	if ( ! wp_verify_nonce( $_POST['validate_nonce'], 'booking_form' ) ) {
		$output = json_encode( array(
			'type' => 'error',
			'text' => 'Invalid security token, please reload the page and try again.'
		) );
		die( $output );
	}

	/* Check Length of the parameters being received from POST request */
	if ( ! strlen( trim( $_POST['name'] ) ) ) {
		$output = json_encode( array(
			'type' => 'error',
			'text' => __( 'Name is empty or too short.', 'oct-physiotherapy' )
		) );
		die( $output );
	}
	//validate phone
	preg_match( '/^([+]?[\s0-9]+)?(\d{3}|[(]?[0-9]+[)])?([-]?[\s]?[0-9])+$/', $_POST['phone'], $match );
	if ( ! $match || ( count( $match ) === 0 ) ) {
		$output = json_encode( array(
			'type' => 'error',
			'text' => __( 'Phone is empty or too short.', 'oct-physiotherapy' )
		) );
		die( $output );
	}
	if ( 80 < mb_strlen( $_POST['name'], '8bit' ) ) {
		$output = json_encode( array( 'type' => 'error', 'text' => __( 'Name is too large.', 'oct-physiotherapy' ) ) );
		die( $output );
	}
	if ( ! ( strlen( trim( $_POST['email'] ) ) && filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ) ) ) {
		$output = json_encode( array(
			'type' => 'error',
			'text' => __( 'Email entered is not valid.', 'oct-physiotherapy' )
		) );
		die( $output );
	}
	if ( 180 < mb_strlen( $_POST['email'], '8bit' ) ) {
		$output = json_encode( array( 'type' => 'error', 'text' => __( 'Email is too large.', 'oct-physiotherapy' ) ) );
		die( $output );
	}
	if ( ! strlen( trim( $_POST['message'] ) ) ) {
		$output = json_encode( array(
			'type' => 'error',
			'text' => __( 'Message text is empty or too short.', 'oct-physiotherapy' )
		) );
		die( $output );
	}
	if ( 1024 < mb_strlen( $_POST['message'], '8bit' ) ) {
		$output = json_encode( array(
			'type' => 'error',
			'text' => __( 'Message is too large, please shorten it.', 'oct-physiotherapy' )
		) );
		die( $output );
	}

	$name    = filter_var( $_POST["name"], FILTER_SANITIZE_STRING );
	$email   = filter_var( mb_strtolower( $_POST["email"], 'UTF-8' ), FILTER_SANITIZE_EMAIL );
	$msg     = filter_var( $_POST["message"], FILTER_SANITIZE_STRING );
	$phone   = filter_var( $_POST["phone"], FILTER_SANITIZE_STRING );
	$service = filter_var( $_POST["service"], FILTER_SANITIZE_STRING );

	$label_1 = filter_var( $_POST["label_1"], FILTER_SANITIZE_STRING );
	if ( ! isset( $label_1 ) && ! strlen( $label_1 ) ) {
		$label_1 = __( "Email ", "oct-physiotherapy" );
	}
	$label_2 = filter_var( $_POST["label_2"], FILTER_SANITIZE_STRING );
	if ( ! isset( $label_2 ) && ! strlen( $label_2 ) ) {
		$label_2 = __( "Name ", "oct-physiotherapy" );
	}

	$label_3 = filter_var( $_POST["label_3"], FILTER_SANITIZE_STRING );
	if ( ! isset( $label_3 ) && ! strlen( $label_3 ) ) {
		$label_3 = __( "Message ", "oct-physiotherapy" );
	}
	$label_5 = filter_var( $_POST["label_5"], FILTER_SANITIZE_STRING );
	if ( ! isset( $label_5 ) && ! strlen( $label_5 ) ) {
		$label_5 = __( "Phone ", "oct-physiotherapy" );
	}

	$label_6 = filter_var( $_POST["label_6"], FILTER_SANITIZE_STRING );
	if ( ! isset( $label_6 ) && ! strlen( $label_6 ) ) {
		$label_6 = __( "Service ", "oct-physiotherapy" );
	}
	//$to = get_option( 'admin_email' );
	$subject = filter_var( $_POST["subject"], FILTER_SANITIZE_STRING );

	if ( ! strlen( $subject ) ) {
		/* set default subject if missing */
		$subject = __( "Contact query from website", "oct-physiotherapy" ) . get_bloginfo( 'name' );
	}

	/*
	  * Leaving the "from" field blank in mail-headers so that wordpress@domain.tld can act as sender
	  * More details: https://app.asana.com/0/307895785186248/529519894576281/f
	  */

	$body = __( "Contact Details ", "oct-physiotherapy" ) . "\n\n\n" .
	        $label_1 . ': ' . $email . " \n" .
	        $label_2 . ': ' . $name . " \n" .
	        $label_3 . ': ' . $msg . " \n" .
	        $label_5 . ': ' . $phone . "\n" .
	        $label_6 . ': ' . $service . "\n" .
	        /*$headers = "From: $email \r\n";*/
	        $headers = "Reply-To: $email \r\n";

	$sendto = $_POST["recipient"];
	if ( ! strlen( $sendto ) ) {
		$sendto    = get_option( 'admin_email' );
		$send_mail = wp_mail( $sendto, $subject, $body, $headers );

	} else if ( ! strpos( $sendto, ',' ) && strlen( $sendto ) ) {
		$sendto    = filter_var( mb_strtolower( $sendto, 'UTF-8' ), FILTER_SANITIZE_EMAIL );
		$send_mail = wp_mail( $sendto, $subject, $body, $headers );
	} else {
		$send_mail = wp_mail( $sendto, $subject, $body, $headers );
	}

	if ( $send_mail ) {
		$output = json_encode( array(
			'type' => 'success',
			'text' => __( 'Your message has been successfully sent.', 'oct-physiotherapy' )
		) );
		die( $output );
	} else {
		$output = json_encode( array(
			'type' => 'error',
			'text' => __( 'Some error occurred, please reload the page and try again.', 'oct-physiotherapy' )
		) );
		die( $output );
	}
}


/* Handle Subscriber form request */
add_action( 'wp_ajax_newsletter_subscribe', 'newsletter_subscribe' );
add_action( 'wp_ajax_nopriv_newsletter_subscribe', 'newsletter_subscribe' );

function newsletter_subscribe() {

	/* Check Nonce */
	if ( ! wp_verify_nonce( $_POST['validate_nonce'], 'subscribe_form' ) ) {
		$output = json_encode( array(
			'type' => 'error',
			'text' => 'Invalid security token, please reload the page and try again.'
		) );
		die( $output );
	}

	/* Check Length of the parameters being received from POST request */
	if ( ! ( strlen( trim( $_POST['email'] ) ) && filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ) ) ) {
		$output = json_encode( array(
			'type' => 'error',
			'text' => __( 'Email entered is not valid or empty.', 'oct-physiotherapy' )
		) );
		die( $output );
	}
	if ( 200 < mb_strlen( $_POST['email'], '8bit' ) ) {
		$output = json_encode( array(
			'type' => 'error',
			'text' => __( 'Email is too large, please use a valid email.', 'oct-physiotherapy' )
		) );
		die( $output );
	}

	$email = filter_var( mb_strtolower( $_POST["email"], 'UTF-8' ), FILTER_SANITIZE_EMAIL );

	if ( email_exists( $email ) ) {
		$output = json_encode( array(
			'type' => 'error',
			'text' => __( 'This email is already used. Please use a different email.', 'oct-physiotherapy' )
		) );
		die( $output );
	}

	/* Make user login from email id */
	$user_login = explode( '@', $email );
	if ( ! empty( $user_login ) ) {
		$user_login = $user_login[0];
	}
	/* avoid duplicates by adding extra digits in the username : day and month */
	$user_login .= date( '_d_m' );

	/* register user */
	$register_subscriber = register_new_user( $email, $email );

	/* if error */
	if ( is_wp_error( $register_subscriber ) ) {
		$output = json_encode( array( 'type' => 'error', 'text' => $register_subscriber->get_error_message() ) );
		die( $output );
	} else {
		/* success */
		$output = json_encode( array(
			'type' => 'success',
			'text' => __( 'Subscribed successfully.', 'oct-physiotherapy' ),
			'id'   => $register_subscriber
		) );
		die( $output );
	}

	$output = json_encode( array(
		'type' => 'error',
		'text' => __( 'Some error occurred, please reload the page and try again.', 'oct-physiotherapy' )
	) );
	die( $output );

}

/* Customize Theme Options link in admin menu. */
add_filter( 'ot_show_pages', '__return_false' );
add_filter( 'ot_theme_options_parent_slug', '__return_false' );
add_filter( 'ot_theme_options_menu_title', function ( $title ) {
	return $title = 'Phyisotherapy';
} );
add_filter( 'ot_theme_options_menu_slug', function ( $slug ) {
	return $slug = 'octheme_settings';
} );
add_filter( 'ot_theme_options_icon_url', function ( $url ) {
	return $url = ' dashicons-admin-customizer';
} );
// Register Custom Post Type - Lesson
function register_cpt_lessons() {

	$labels = array(
		'name'          => __( 'Services', 'oct-physiotherapy' ),
		'singular_name' => __( 'Service', 'oct-physiotherapy' ),
		'new_item'      => __( 'New Service', 'oct-physiotherapy' ),
		'edit_item'     => __( 'Edit Service', 'oct-physiotherapy' ),
		'update_item'   => __( 'Update Service', 'oct-physiotherapy' ),
		'view_item'     => __( 'View Service', 'oct-physiotherapy' ),
		'view_items'    => __( 'View Service', 'oct-physiotherapy' ),
	);
	$args   = array(
		'label'               => __( 'Service', 'oct-physiotherapy' ),
		'description'         => __( 'Service Description', 'oct-physiotherapy' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-book',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type( 'therapy', $args );
}
add_action( 'init', 'register_cpt_lessons', 0 );