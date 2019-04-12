<?php

/**
 * Initialize the custom Meta Boxes.
 */
add_action( 'admin_init', 'custom_meta_boxes' );

global $post;

/**
 * Meta Boxes demo code.
 *
 * You can find all the available option types in demo-theme-options.php.
 *
 * @return    void
 * @since     2.0
 */
function custom_meta_boxes() {

	/**
	 * Create a custom meta boxes array that we pass to
	 * the OptionTree Meta Box API Class.
	 */
	$homepage_sections       = array(
		'id'       => 'home_sections',
		'title'    => __( 'Page Sections', 'oct-physiotherapy' ),
		'desc'     => '',
		'pages'    => array( 'page' ),
		'context'  => 'normal',
		'class'    => 'ot_meta',
		'priority' => 'high',
		'fields'   => array(
			/* Banner Section */
			array(
				'label' => __( 'Banner', 'oct-physiotherapy' ),
				'id'    => 'home_banner',
				'type'  => 'tab'
			),
			array(
				'label' => __( 'Show Banner', 'oct-physiotherapy' ),
				'id'    => 'home_banner_switch',
				'type'  => 'on-off',
				'class' => 'switch_div',
				'std'   => 'on',
			),
			array(
				'id'        => 'home_banner_image',
				'label'     => __( 'Banner Image', 'oct-physiotherapy' ),
				'type'      => 'upload',
				'class'     => 'ot-upload-attachment-id',
				'condition' => 'home_banner_switch:is(on)',
			),
			array(
				'id'        => 'banner_caption_align',
				'label'     => __( 'Caption Alignment', 'oct-physiotherapy' ),
				'std'       => 'center',
				'type'      => 'select',
				'class'     => 'inline-cols',
				'condition' => 'home_banner_switch:is(on)',
				'section'   => 'option_types',
				'choices'   => array(
					array(
						'value' => 'align-right',
						'label' => __( 'Right', 'oct-physiotherapy' ),
					),
					array(
						'value' => 'align-center',
						'label' => __( 'Center', 'oct-physiotherapy' ),
					),
					array(
						'value' => 'align-left',
						'label' => __( 'Left', 'oct-physiotherapy' ),
					)
				)
			),
			array(
				'label'     => __( 'Banner Height', 'oct-physiotherapy' ),
				'desc'      => '<span class="dashicons dashicons-external"></span> ' . sprintf( '<a href="%s" target="_blank">' . __( 'Change the font for this banner', 'oct-physiotherapy' ) . '</a>', admin_url( 'admin.php?page=octheme_settings#section_typo_option' ) ),
				'id'        => 'banner_height',
				'type'      => 'select',
				'std'       => 'custom_height',
				'choices'   => array(
					array(
						'value' => 'auto_height',
						'label' => __( 'Auto', 'oct-physiotherapy' ),
					),
					array(
						'value' => 'full_view',
						'label' => __( 'Full Viewport', 'oct-physiotherapy' ),
					),
					array(
						'value' => 'custom_height',
						'label' => __( 'Custom', 'oct-physiotherapy' ),
					),
				),
				'condition' => 'home_banner_switch:is(on)',
			),
			array(
				'id'        => 'hbanner_height',
				'label'     => __( 'Banner Custom Height', 'oct-physiotherapy' ),
				'class'     => 'inline-cols',
				'std'       => array( '630', 'px' ),
				'type'      => 'measurement',
				'condition' => 'banner_height:is(custom_height),home_banner_switch:is(on)',
			),
			array(
				'id'        => 'banner_caption_content',
				'label'     => __( 'Banner Caption - Content', 'oct-physiotherapy' ),
				'type'      => 'textarea',
				'std'       => '',
				'rows'      => '3',
				'condition' => 'home_banner_switch:is(on)',
			),
			array(
				'id'        => 'banner_button_label',
				'label'     => __( 'Button Label', 'oct-physiotherapy' ),
				'type'      => 'text',
				'std'       => '',
				'condition' => 'home_banner_switch:is(on)',
			),
			array(
				'id'        => 'banner_button_link',
				'label'     => __( 'Button Link', 'oct-physiotherapy' ),
				'type'      => 'text',
				'std'       => get_permalink( 'contact' ),
				'condition' => 'home_banner_switch:is(on)',
			),
			/* Therepies Section */
			array(
				'label' => __( 'Services', 'oct-physiotherapy' ),
				'id'    => 'home_courses',
				'type'  => 'tab'
			),
			array(
				'label' => __( 'Show Section', 'oct-physiotherapy' ),
				'id'    => 'home_courses_switch',
				'type'  => 'on-off',
				'class' => 'switch_div',
				'std'   => 'on'
			),
			array(
				'label'     => __( 'Section Title', 'oct-physiotherapy' ),
				'id'        => 'courses_section_title',
				'type'      => 'text',
				'std'       => '',
				'condition' => 'home_courses_switch:is(on)'
			),
			array(
				'label'     => __( 'Section Content', 'oct-physiotherapy' ),
				'id'        => 'courses_section_content',
				'type'      => 'textarea',
				'row'       => '3',
				'condition' => 'home_courses_switch:is(on)'
			),
			array(
				'id'        => 'home_courses_ids',
				'label'     => __( 'Please select the therapies to be diplayed.', 'oct-physiotherapy' ),
				'desc'      => __( 'The selected therapies will be displayed.', 'oct-physiotherapy' ),
				'std'       => '',
				'type'      => 'custom-post-type-checkbox',
				'post_type' => 'therapy',
				'condition' => 'home_courses_switch:is(on),home_courses_posts_switch:is(on)',
				'operator'  => 'and'
			),
			array(
				'id'        => 'home_readmore_button',
				'label'     => __( 'Read more button text', 'oct-physiotherapy' ),
				'std'       => 'Read more',
				'type'      => 'text',
				'condition' => 'home_courses_switch:is(on),home_courses_posts_switch:is(on)',
				'operator'  => 'and'
			),
			array(
				'id'        => 'home_all_service_button_text',
				'label'     => __( 'All services button text', 'oct-physiotherapy' ),
				'std'       => 'See all services',
				'type'      => 'text',
				'condition' => 'home_courses_switch:is(on),home_courses_posts_switch:is(on)',
				'operator'  => 'and'
			),
			array(
				'id'        => 'home_all_service_button_link',
				'label'     => __( 'All services button link', 'oct-physiotherapy' ),
				'type'      => 'text',
				'condition' => 'home_courses_switch:is(on),home_courses_posts_switch:is(on)',
				'operator'  => 'and'
			),
			array(
				'label' => __( 'Features', 'oct-physiotherapy' ),
				'id'    => 'home_features',
				'type'  => 'tab'
			),
			array(
				'label' => __( 'Show Section', 'oct-physiotherapy' ),
				'id'    => 'home_features_switch',
				'type'  => 'on-off',
				'class' => 'switch_div',
				'std'   => 'on'
			),
			array(
				'label'     => __( 'Section Title', 'oct-physiotherapy' ),
				'id'        => 'features_section_title',
				'type'      => 'text',
				'std'       => '',
				'condition' => 'home_features_switch:is(on)'
			),
			array(
				'label'     => __( 'Section Content', 'oct-physiotherapy' ),
				'id'        => 'features_section_content',
				'type'      => 'textarea',
				'row'       => '5',
				'std'       => '',
				'condition' => 'home_features_switch:is(on)'
			),
			array(
				'label'     => __( 'Button Title', 'oct-physiotherapy' ),
				'id'        => 'features_section_btn_title',
				'type'      => 'text',
				'std'       => '',
				'condition' => 'home_features_switch:is(on)',
			),
			array(
				'label'     => __( 'Button Link', 'oct-physiotherapy' ),
				'id'        => 'features_section_btn_link',
				'type'      => 'text',
				'std'       => '#',
				'condition' => 'home_features_switch:is(on)',
			),
			array(
				'label' => __( 'About us section', 'oct-physiotherapy' ),
				'id'    => 'home_experience',
				'type'  => 'tab'
			),
			array(
				'label' => __( 'Show Section', 'oct-physiotherapy' ),
				'id'    => 'home_surfing_switch',
				'type'  => 'on-off',
				'class' => 'switch_div',
				'std'   => 'on'
			),
			array(
				'label'     => __( 'Section Title', 'oct-physiotherapy' ),
				'id'        => 'experience_section_title',
				'type'      => 'text',
				'std'       => '',
				'condition' => 'home_surfing_switch:is(on)'
			),
			array(
				'label'     => __( 'Section Sub Title', 'oct-physiotherapy' ),
				'id'        => 'experience_section_sub_title',
				'type'      => 'text',
				'std'       => '',
				'condition' => 'home_surfing_switch:is(on)'
			),
			array(
				'label'     => __( 'Section Content', 'oct-physiotherapy' ),
				'id'        => 'experience_section_content',
				'type'      => 'textarea',
				'row'       => '5',
				'condition' => 'home_surfing_switch:is(on)'
			),
			array(
				'label'     => __( 'Button 1 Title', 'oct-physiotherapy' ),
				'id'        => 'experience_section_btn_title',
				'type'      => 'text',
				'std'       => '',
				'condition' => 'home_surfing_switch:is(on)'
			),
			array(
				'label'     => __( 'Button 1 Link', 'oct-physiotherapy' ),
				'id'        => 'experience_section_btn_link',
				'type'      => 'text',
				'std'       => '#',
				'condition' => 'home_surfing_switch:is(on)'
			),
			array(
				'label'     => __( 'Button 2 Title', 'oct-physiotherapy' ),
				'id'        => 'experience_section_btn_title_2',
				'type'      => 'text',
				'std'       => '',
				'condition' => 'home_surfing_switch:is(on)'
			),
			array(
				'label'     => __( 'Button 2 Link', 'oct-physiotherapy' ),
				'id'        => 'experience_section_btn_link_2',
				'type'      => 'text',
				'std'       => '#',
				'condition' => 'home_surfing_switch:is(on)'
			),
			array(
				'label'     => __( 'Section Image', 'oct-physiotherapy' ),
				'id'        => 'experience_section_bg',
				'type'      => 'background',
				'class'     => 'ot-upload-attachment-id',
				'condition' => 'home_surfing_switch:is(on)',
			),
			/* Pricing Section */
			array(
				'label' => __( 'Price', 'oct-physiotherapy' ),
				'id'    => 'home_testimonial',
				'type'  => 'tab'
			),
			array(
				'label' => __( 'Show Section', 'oct-physiotherapy' ),
				'id'    => 'home_testimonial_switch',
				'type'  => 'on-off',
				'class' => 'switch_div',
				'std'   => 'on'
			),
			array(
				'label'     => __( 'Section Title', 'oct-physiotherapy' ),
				'id'        => 'testimonial_section_title',
				'type'      => 'text',
				'std'       => '',
				'condition' => 'home_testimonial_switch:is(on)'
			),
			array(
				'label'     => __( 'Section Content', 'oct-physiotherapy' ),
				'id'        => 'testimonial_section_content',
				'type'      => 'textarea',
				'std'       => '',
				'condition' => 'home_testimonial_switch:is(on)'
			),
			array(
				'id'        => 'testimonial_list_item',
				'label'     => __( 'Price', 'oct-physiotherapy' ),
				'desc'      => __( 'The added plans will be displayed in the order they are arranged here.', 'oct-physiotherapy' ),
				'type'      => 'list-item',
				'condition' => 'home_testimonial_switch:is(on)',
				'operator'  => 'and',
				'settings'  => array(
					array(
						'id'    => 'testimonial_amount',
						'label' => __( 'Price', 'oct-physiotherapy' ),
						'type'  => 'text'
					),
					array(
						'id'    => 'testimonial_content',
						'label' => __( 'Content', 'oct-physiotherapy' ),
						'type'  => 'textarea-lite',
						'rows'  => '3',
					),
				),
				'std'       => [ [ 'title' => '' ] ],
			),
			array(
				'id'    => 'testimonial_button_text',
				'label' => __( 'Button label', 'oct-physiotherapy' ),
				'type'  => 'text'
			),
			array(
				'id'    => 'testimonial_button_link',
				'label' => __( 'Button link', 'oct-physiotherapy' ),
				'type'  => 'text'
			),
			/* Gallery Section */
			array(
				'label' => __( 'Gallery', 'oct-physiotherapy' ),
				'id'    => 'home_gallery',
				'type'  => 'tab'
			),
			array(
				'label' => __( 'Show Section', 'oct-physiotherapy' ),
				'id'    => 'home_gallery_switch',
				'type'  => 'on-off',
				'class' => 'switch_div',
				'std'   => 'on'
			),
			array(
				'label'     => __( 'Section Title', 'oct-physiotherapy' ),
				'id'        => 'gallery_section_title',
				'type'      => 'text',
				'std'       => '',
				'condition' => 'home_gallery_switch:is(on)'
			),
			array(
				'label'     => __( 'Section Content', 'oct-physiotherapy' ),
				'id'        => 'gallery_section_content',
				'type'      => 'textarea',
				'row'       => '5',
				'std'       => '',
				'condition' => 'home_gallery_switch:is(on)'
			),
			array(
				'id'        => 'gallery_images',
				'label'     => __( 'Gallery', 'oct-physiotherapy' ),
				'std'       => '',
				'type'      => 'gallery',
				'class'     => 'ot-gallery-shortcode',
				'condition' => 'home_gallery_switch:is(on)'
			)
		)
	);
	$contact_sections        = array(
		'id'       => 'contact_sections',
		'title'    => __( 'Page Section', 'oct-physiotherapy' ),
		'desc'     => '',
		'pages'    => array( 'page' ),
		'context'  => 'normal',
		'priority' => 'low',
		'fields'   => array(
			array(
				'label' => __( 'Banner Settings', 'oct-physiotherapy' ),
				'id'    => 'banner_settings',
				'type'  => 'tab',
			),
			array(
				'label' => __( 'Show Banner', 'oct-physiotherapy' ),
				'id'    => 'internal_banner_switch',
				'type'  => 'on-off',
				'class' => 'switch_div',
				'std'   => 'on'
			),
			array(
				'label' => __( 'Select banner image', 'oct-physiotherapy' ),
				'id'    => 'banner_image',
				'type'  => 'upload',
				'class' => 'ot-upload-attachment-id',
				'condition' => 'internal_banner_switch:is(on)'
			),
			array(
				'label'     => __( 'Page Subtitle', 'oct-physiotherapy' ),
				'id'        => 'page_subtitle',
				'type'      => 'textarea-lite',
				'rows'      => '2',
				'condition' => 'internal_banner_switch:is(on)'
			),
			array(
				'label' => __( 'Content', 'oct-physiotherapy' ),
				'id'    => 'content_tab',
				'type'  => 'tab'
			),
			array(
				'label' => __( 'Show Title', 'oct-physiotherapy' ),
				'id'    => 'custom_page_title_switch',
				'type'  => 'on-off',
				'class' => 'switch_div',
				'std'   => 'on'
			),
			array(
				'id'        => 'custom_page_title',
				'label'     => __( 'Custom Title', 'oct-physiotherapy' ),
				'type'      => 'text',
				'std'       => '',
				'rows'      => '1',
				'condition' => 'custom_page_title_switch:is(on)'
			),
			array(
				'label' => __( 'Form Section', 'oct-physiotherapy' ),
				'id'    => 'booking_tab',
				'type'  => 'tab',
			),
			array(
				'label' => __( 'Show Section', 'oct-physiotherapy' ),
				'id'    => 'booking_sec_switch',
				'type'  => 'on-off',
				'class' => 'switch_div',
				'std'   => 'on',
			),
			array(
				'id'        => 'form_section_title',
				'label'     => __( 'Form Title', 'oct-physiotherapy' ),
				'type'      => 'text',
				'std'       => '',
				'condition' => 'booking_sec_switch:is(on)'
			),
			array(
				'id'        => 'form_section_desc',
				'label'     => __( 'Form Description', 'oct-physiotherapy' ),
				'type'      => 'textarea-lite',
				'std'       => '',
				'rows'      => '3',
				'condition' => 'booking_sec_switch:is(on)'
			),
			array(
				'id'        => 'form_labels',
				'label'     => __( 'Form Fields Labels', 'oct-physiotherapy' ),
				'std'       => '',
				'type'      => 'textblock-titled',
				'section'   => 'contact_options',
				'class'     => 'inline_cols',
				'condition' => 'booking_sec_switch:is(on)',
				'operator'  => 'and'
			),
			array(
				'id'        => 'form_label_2',
				'label'     => __( 'Name', 'oct-physiotherapy' ),
				'std'       => 'Name',
				'type'      => 'text',
				'section'   => 'contact_options',
				'class'     => 'inline_cols',
				'condition' => 'booking_sec_switch:is(on)',
				'operator'  => 'and'
			),
			array(
				'id'        => 'form_label_5',
				'label'     => __( 'Phone', 'oct-physiotherapy' ),
				'std'       => 'Phone',
				'type'      => 'text',
				'section'   => 'contact_options',
				'class'     => 'inline_cols',
				'condition' => 'booking_sec_switch:is(on)',
				'operator'  => 'and'
			),
			array(
				'id'        => 'form_label_1',
				'label'     => __( 'Email', 'oct-physiotherapy' ),
				'std'       => 'Email',
				'type'      => 'text',
				'section'   => 'contact_options',
				'class'     => 'inline_cols',
				'condition' => 'booking_sec_switch:is(on)',
				'operator'  => 'and'
			),

			array(
				'id'        => 'form_label_3',
				'label'     => __( 'Message', 'oct-physiotherapy' ),
				'std'       => 'Message',
				'type'      => 'text',
				'section'   => 'contact_options',
				'class'     => 'inline_cols',
				'condition' => 'booking_sec_switch:is(on)',
				'operator'  => 'and'
			),
			array(
				'id'        => 'form_label_4',
				'label'     => __( 'Button Text', 'oct-physiotherapy' ),
				'std'       => 'SEND MESSAGE',
				'type'      => 'text',
				'section'   => 'contact_options',
				'class'     => 'inline_cols',
				'condition' => 'booking_sec_switch:is(on)',
				'operator'  => 'and'
			),
			array(
				'id'        => 'form_label_6',
				'label'     => __( 'Choose Service category', 'oct-physiotherapy' ),
				'std'       => 'Choose Service category',
				'type'      => 'text',
				'section'   => 'contact_options',

				'condition' => 'booking_sec_switch:is(on)',
				'operator'  => 'and'
			),

			array(
				'id'        => 'service_options',
				'label'     => __( 'Services', 'oct-physiotherapy' ),
				'std'       => 'Services',
				'type'      => 'list-item',
				'section'   => 'contact_options',
				'condition' => 'booking_sec_switch:is(on)',
				'operator'  => 'and',
				'settings' => array(
					array(
						'label' => __( 'Value', 'oct-physiotherapy' ),
						'type' => 'text',
						'id' => 's_value'
					)
				)
			),
			array(
				'id'        => 'cmail_subject',
				'label'     => __( 'Email Subject', 'oct-physiotherapy' ),
				'std'       => 'Contact query from website ' . get_bloginfo( 'name' ),
				'type'      => 'text',
				'section'   => 'contact_options',
				'condition' => 'booking_sec_switch:is(on)',
				'operator'  => 'and'
			),
			array(
				'id'        => 'recipient_email',
				'label'     => __( 'Recipients', 'oct-physiotherapy' ),
				'desc'      => __( 'Provide email accounts where you want to receive emails from this form.', 'oct-physiotherapy' ),
				'std'       => get_option( 'admin_email' ),
				'type'      => 'text',
				'section'   => 'contact_options',
				'condition' => 'booking_sec_switch:is(on)',
				'operator'  => 'and'
			),
			array(
				'label'     => __( 'Custom Form', 'oct-physiotherapy' ),
				'desc'      => 'This will replace the default form.',
				'id'        => 'custom_form_switch',
				'type'      => 'on-off',
				'std'       => 'off',
				'condition' => 'booking_sec_switch:is(on)',
			),
			array(
				'label'     => __( 'Form Embed Code or Shortcode', 'oct-physiotherapy' ),
				'desc'      => __( 'Please copy and paste the Embed Code or Shortcode of the custom form (if any). This will replace the default form.', 'oct-physiotherapy' ),
				'id'        => 'booking_form_embed',
				'type'      => 'textarea',
				'rows'      => '3',
				'condition' => 'custom_form_switch:is(on), booking_sec_switch:is(on)',
			),
			array(
				'label'     => __( 'Section Background', 'oct-physiotherapy' ),
				'id'        => 'booking_section_bg',
				'type'      => 'background',
				'class'     => 'ot-upload-attachment-id',
				'condition' => 'booking_sec_switch:is(on)',
			),
			array(
				'label' => __( 'Information Blocks', 'oct-physiotherapy' ),
				'id'    => 'contact_tab',
				'type'  => 'tab',
			),
			array(
				'label'    => __( 'Information Blocks', 'oct-physiotherapy' ),
				'id'       => 'contact_page_blocks',
				'type'     => 'list-item',
				'operator' => 'and',
				'settings' => array(
					array(
						'label' => __( 'Content', 'oct-physiotherapy' ),
						'id'    => 'block_content',
						'type'  => 'textarea-lite',
						'rows'  => '3',
					),
				),
				'std'      => [ [ 'title' => '' ] ],
			),
			array(
				'label' => __('Map Section', 'oct-physiotherapy'),
				'id' => 'map_tab',
				'type' => 'tab',
			),
			array(
				'label' => __('Show Section', 'oct-physiotherapy'),
				'id' => 'map_sec_switch',
				'type' => 'on-off',
				'class'     => 'switch_div',
				'std' => 'on',
			),
			array(
				'label' => __('Map Embed Code', 'oct-physiotherapy'),
				'id' => 'map_section_code',
				'type' => 'textarea',
				'rows' => '3',
				'condition' => 'map_sec_switch:is(on)',
			),
			/* Gallery Section */
			array(
				'label' => __( 'Gallery', 'oct-physiotherapy' ),
				'id'    => 'home_gallery',
				'type'  => 'tab'
			),
			array(
				'label' => __( 'Show Section', 'oct-physiotherapy' ),
				'id'    => 'home_gallery_switch',
				'type'  => 'on-off',
				'class' => 'switch_div',
				'std'   => 'on'
			),
			array(
				'label'     => __( 'Section Title', 'oct-physiotherapy' ),
				'id'        => 'gallery_section_title',
				'type'      => 'text',
				'std'       => '',
				'condition' => 'home_gallery_switch:is(on)'
			),
			array(
				'label'     => __( 'Section Content', 'oct-physiotherapy' ),
				'id'        => 'gallery_section_content',
				'type'      => 'textarea-lite',
				'rows'      => '3',
				'std'       => '',
				'condition' => 'home_gallery_switch:is(on)'
			),
			array(
				'id'        => 'gallery_images',
				'label'     => __( 'Gallery', 'oct-physiotherapy' ),
				'std'       => '',
				'type'      => 'gallery',
				'class'     => 'ot-gallery-shortcode',
				'condition' => 'home_gallery_switch:is(on)'
			)
		)
	);
	$blog_settings           = array(
		'id'       => 'blog_settings',
		'title'    => __( 'Page Sections', 'oct-physiotherapy' ),
		'desc'     => '',
		'pages'    => array( 'page' ),
		'context'  => 'normal',
		'priority' => 'low',
		'fields'   => array(
			array(
				'label' => __( 'Banner Settings', 'oct-physiotherapy' ),
				'id'    => 'banner_settings',
				'type'  => 'tab',
			),
			array(
				'label' => __( 'Show Banner?', 'oct-physiotherapy' ),
				'id'    => 'internal_banner_switch',
				'type'  => 'on-off',
				'class' => 'switch_div',
				'std'   => 'on'
			),
			array(
				'label'     => __( 'Banner Text', 'oct-physiotherapy' ),
				'id'        => 'int_ban_text',
				'type'      => 'textarea-simple',
				'rows'      => '2',
				'condition' => 'internal_banner_switch:is(on)'
			),
			array(
				'label'     => __( 'Banner Image', 'oct-physiotherapy' ),
				'id'        => 'banner_image',
				'type'      => 'upload',
				'class'     => 'ot-upload-attachment-id',
				'condition' => 'internal_banner_switch:is(on)'
			),
			/* Gallery Section */
			array(
				'label' => __( 'Gallery', 'oct-physiotherapy' ),
				'id'    => 'home_gallery',
				'type'  => 'tab'
			),
			array(
				'label' => __( 'Show Section', 'oct-physiotherapy' ),
				'id'    => 'home_gallery_switch',
				'type'  => 'on-off',
				'class' => 'switch_div',
				'std'   => 'on'
			),
			array(
				'label'     => __( 'Section Title', 'oct-physiotherapy' ),
				'id'        => 'gallery_section_title',
				'type'      => 'text',
				'std'       => '',
				'condition' => 'home_gallery_switch:is(on)'
			),
			array(
				'label'     => __( 'Section Content', 'oct-physiotherapy' ),
				'id'        => 'gallery_section_content',
				'type'      => 'textarea',
				'row'       => '5',
				'std'       => '',
				'condition' => 'home_gallery_switch:is(on)'
			),
			array(
				'id'        => 'gallery_images',
				'label'     => __( 'Gallery', 'oct-physiotherapy' ),
				'std'       => '',
				'type'      => 'gallery',
				'class'     => 'ot-gallery-shortcode',
				'condition' => 'home_gallery_switch:is(on)'
			)
		)
	);
	$about_sections          = array(
		'id'       => 'int_ban_box',
		'title'    => __( 'Banner Setting', 'oct-physiotherapy' ),
		'desc'     => '',
		'pages'    => array( 'page' ),
		'context'  => 'normal',
		'priority' => 'low',
		'fields'   => array(
			array(
				'label' => __( 'Banner Settings', 'oct-physiotherapy' ),
				'id'    => 'banner_settings',
				'type'  => 'tab',
			),
			array(
				'label' => __( 'Show Banner', 'oct-physiotherapy' ),
				'id'    => 'internal_banner_switch',
				'type'  => 'on-off',
				'class' => 'switch_div',
				'std'   => 'on'
			),
			array(
				'label' => __( 'Select banner image', 'oct-physiotherapy' ),
				'id'    => 'banner_image',
				'type'  => 'upload',
				'class' => 'ot-upload-attachment-id',
				'condition' => 'internal_banner_switch:is(on)'
			),
			array(
				'label'     => __( 'Page Subtitle', 'oct-physiotherapy' ),
				'id'        => 'page_subtitle',
				'type'      => 'textarea-lite',
				'rows'      => '2',
				'condition' => 'internal_banner_switch:is(on)'
			),
			array(
				'label' => __( 'Treatment Settings', 'oct-physiotherapy' ),
				'id'    => 'benefits_section',
				'type'  => 'tab'
			),
			array(
				'label' => __( 'Show Section', 'oct-physiotherapy' ),
				'id'    => 'show_benefits_switch',
				'type'  => 'on-off',
				'class' => 'switch_div',
				'std'   => 'on'
			),
			array(
				'label'     => __( 'Title', 'oct-physiotherapy' ),
				'id'        => 'benefit_section_title',
				'type'      => 'text',
				'condition' => 'show_benefits_switch:is(on)',
			),
			array(
				'label'     => __( 'Content', 'oct-physiotherapy' ),
				'id'        => 'benefit_section_desc',
				'type'      => 'textarea-lite',
				'rows'      => 3,
				'condition' => 'show_benefits_switch:is(on)',
			),
			array(
				'label'     => __( 'Features', 'oct-physiotherapy' ),
				'id'        => 'benefit_list',
				'type'      => 'list-item',
				'condition' => 'show_benefits_switch:is(on)',
				'settings'  => array(
					array(
						'label' => __( 'Content', 'oct-physiotherapy' ),
						'type'  => 'textarea-simple',
						'rows'  => 3,
						'id'    => 'benefits_content'
					)
				)
			),
			array(
				'label'     => __( 'Button Title', 'oct-physiotherapy' ),
				'id'        => 'benefit_button_text',
				'type'      => 'text',
				'condition' => 'show_benefits_switch:is(on)',
			),
			array(
				'label'     => __( 'Button Link', 'oct-physiotherapy' ),
				'id'        => 'benefit_button_url',
				'type'      => 'text',
				'condition' => 'show_benefits_switch:is(on)',
			),
			array(
				'label' => __( 'Newsletter', 'oct-physiotherapy' ),
				'id'    => 'home_newsletter',
				'type'  => 'tab'
			),

			array(
				'label' => __( 'Show Section', 'oct-physiotherapy' ),
				'id'    => 'home_newsletter_switch',
				'type'  => 'on-off',
				'class' => 'switch_div',
				'std'   => 'on'
			),

			array(
				'label'     => __( 'Title', 'oct-physiotherapy' ),
				'id'        => 'newsletter_section_title',
				'type'      => 'text',
				'std'       => '',
				'condition' => 'home_newsletter_switch:is(on)'
			),

			array(
				'label'     => __( 'Content', 'oct-physiotherapy' ),
				'id'        => 'newsletter_section_content',
				'type'      => 'textarea',
				'row'       => '5',
				'std'       => '',
				'condition' => 'home_newsletter_switch:is(on)'
			),

			array(
				'label'     => __( 'Button Title', 'oct-physiotherapy' ),
				'id'        => 'newsletter_btn_title',
				'type'      => 'text',
				'std'       => '',
				'condition' => 'home_newsletter_switch:is(on)'
			),

			array(
				'label'     => __( 'Custom Form', 'oct-physiotherapy' ),
				'desc'      => __( 'This will replace the default form.', 'oct-physiotherapy' ),
				'id'        => 'newsletter_form_switch',
				'type'      => 'on-off',
				'class'     => 'switch_div',
				'std'       => 'on',
				'condition' => 'home_newsletter_switch:is(on)'
			),

			array(
				'label'     => __( 'Form Embed Code or Shortcode', 'oct-physiotherapy' ),
				'id'        => 'newsletter_embed_code',
				'desc'      => __( 'Please copy and paste the Embed Code or Shortcode of the custom form (if any). This will replace the default form.', 'oct-physiotherapy' ),
				'type'      => 'textarea',
				'row'       => '5',
				'operator'  => 'and',
				'condition' => 'home_newsletter_switch:is(on),newsletter_form_switch:is(on)'
			),
			array(
				'label' => __( 'Instructors', 'oct-physiotherapy' ),
				'id'    => 'testimonial_section',
				'type'  => 'tab'
			),
			array(
				'label' => __( 'Show Section', 'oct-physiotherapy' ),
				'id'    => 'show_testimonial_switch',
				'type'  => 'on-off',
				'class' => 'switch_div',
				'std'   => 'on'
			),
			array(
				'label'     => __( 'Title', 'oct-physiotherapy' ),
				'id'        => 'testimonial_section_title',
				'type'      => 'text',
				'condition' => 'show_testimonial_switch:is(on)',
			),
			array(
				'label'     => __( 'Content', 'oct-physiotherapy' ),
				'id'        => 'testimonial_section_content',
				'type'      => 'textarea-lite',
				'condition' => 'show_testimonial_switch:is(on)',
				'rows'      => 3
			),
			array(
				'label'    => __( 'Instructors', 'oct-physiotherapy' ),
				'id'       => 'testimonials',
				'type'     => 'list-item',
				'settings' => array(
					array(
						'label' => __( 'Subtitle', 'oct-physiotherapy' ),
						'type'  => 'text',
						'id'    => 'testimonial_desig',
						'rows'  => '3'
					),
					array(
						'label' => __( 'Content', 'oct-physiotherapy' ),
						'type'  => 'textarea-simple',
						'id'    => 'testimonial_content',
						'rows'  => '3'
					),
					array(
						'label' => __( 'Image', 'oct-physiotherapy' ),
						'type'  => 'upload',
						'class' => 'ot-upload-attachment-id',
						'id'    => 'testimonial_author'
					),
				)
			),
			/* Gallery Section */
			array(
				'label' => __( 'Gallery', 'oct-physiotherapy' ),
				'id'    => 'home_gallery',
				'type'  => 'tab'
			),
			array(
				'label' => __( 'Show Section', 'oct-physiotherapy' ),
				'id'    => 'home_gallery_switch',
				'type'  => 'on-off',
				'class' => 'switch_div',
				'std'   => 'on'
			),
			array(
				'label'     => __( 'Title', 'oct-physiotherapy' ),
				'id'        => 'gallery_section_title',
				'type'      => 'text',
				'std'       => '',
				'condition' => 'home_gallery_switch:is(on)'
			),
			array(
				'label'     => __( 'Content', 'oct-physiotherapy' ),
				'id'        => 'gallery_section_content',
				'type'      => 'textarea-lite',
				'rows'      => '3',
				'std'       => '',
				'condition' => 'home_gallery_switch:is(on)'
			),
			array(
				'id'        => 'gallery_images',
				'label'     => __( 'Gallery', 'oct-physiotherapy' ),
				'std'       => '',
				'type'      => 'gallery',
				'class'     => 'ot-gallery-shortcode',
				'condition' => 'home_gallery_switch:is(on)'
			)
		)
	);
	$therapies_template_meta = array(
		'id'       => 'int_ban_box',
		'title'    => __( 'Gallery', 'oct-physiotherapy' ),
		'desc'     => '',
		'pages'    => array( 'page' ),
		'context'  => 'normal',
		'priority' => 'low',
		'fields'   => array(
			array(
				'label' => __( 'Banner Settings', 'oct-physiotherapy' ),
				'id'    => 'banner_settings',
				'type'  => 'tab',
			),
			array(
				'label' => __( 'Show Banner', 'oct-physiotherapy' ),
				'id'    => 'internal_banner_switch',
				'type'  => 'on-off',
				'class' => 'switch_div',
				'std'   => 'on'
			),
			array(
				'label' => __( 'Select banner image', 'oct-physiotherapy' ),
				'id'    => 'banner_image',
				'type'  => 'upload',
				'class' => 'ot-upload-attachment-id',
				'condition' => 'internal_banner_switch:is(on)'
			),
			array(
				'label'     => __( 'Page Subtitle', 'oct-physiotherapy' ),
				'id'        => 'page_subtitle',
				'type'      => 'textarea-lite',
				'rows'      => '2',
				'condition' => 'internal_banner_switch:is(on)'
			),
			/* Gallery Section */
			array(
				'label' => __( 'Gallery', 'oct-physiotherapy' ),
				'id'    => 'home_gallery',
				'type'  => 'tab'
			),
			array(
				'label' => __( 'Show Section', 'oct-physiotherapy' ),
				'id'    => 'home_gallery_switch',
				'type'  => 'on-off',
				'class' => 'switch_div',
				'std'   => 'on'
			),
			array(
				'label'     => __( 'Section Title', 'oct-physiotherapy' ),
				'id'        => 'gallery_section_title',
				'type'      => 'text',
				'std'       => '',
				'condition' => 'home_gallery_switch:is(on)'
			),
			array(
				'label'     => __( 'Section Content', 'oct-physiotherapy' ),
				'id'        => 'gallery_section_content',
				'type'      => 'textarea-lite',
				'rows'      => '3',
				'std'       => '',
				'condition' => 'home_gallery_switch:is(on)'
			),
			array(
				'id'        => 'gallery_images',
				'label'     => __( 'Gallery', 'oct-physiotherapy' ),
				'std'       => '',
				'type'      => 'gallery',
				'class'     => 'ot-gallery-shortcode',
				'condition' => 'home_gallery_switch:is(on)'
			)
		)
	);
	$page_banners            = array(
		'id'       => 'int_ban_box',
		'title'    => __( 'Banner Setting', 'oct-physiotherapy' ),
		'desc'     => '',
		'pages'    => array( 'page' ),
		'context'  => 'normal',
		'priority' => 'low',
		'fields'   => array(
			array(
				'label' => __( 'Banner Settings', 'oct-physiotherapy' ),
				'id'    => 'banner_settings',
				'type'  => 'tab',
			),
			array(
				'label' => __( 'Show Banner', 'oct-physiotherapy' ),
				'id'    => 'internal_banner_switch',
				'type'  => 'on-off',
				'class' => 'switch_div',
				'std'   => 'on'
			),
			array(
				'label' => __( 'Select banner image', 'oct-physiotherapy' ),
				'id'    => 'banner_image',
				'type'  => 'upload',
				'class' => 'ot-upload-attachment-id',
				'condition' => 'internal_banner_switch:is(on)'
			),
			array(
				'label'     => __( 'Page Subtitle', 'oct-physiotherapy' ),
				'id'        => 'page_subtitle',
				'type'      => 'textarea-lite',
				'rows'      => '2',
				'condition' => 'internal_banner_switch:is(on)'
			),
		)
	);
	$layouts = array(
		'id' => 'single_page_meta_box',
		'title' => __('Layout', 'oct-physiotherapy'),
		//'desc'        => '',
		'pages' => array('page', 'post'),
		'context' => 'side',
		'priority' => 'low',
		'fields' => array(
			array(
				'id' => 'single_post_page_layout',
				//'label'       => __( 'Sidebar', 'oct-physiotherapy' ),
				'std' => '',
				'type' => 'radio-image',
				'choices' => array(
					array(
						'value' => 'one-column-right-sidebar',
						'label' => __('One column with right sidebar', 'oct-physiotherapy'),
						'src' => get_template_directory_uri().'/option-tree/assets/images/layout/one-column-sidebar.png',
					),
					array(
						'value' => 'one-column-no-sidebar',
						'label' => __('One column without sidebar', 'oct-physiotherapy'),
						'src' => get_template_directory_uri() . '/option-tree/assets/images/layout/one-column.png',
					),
					array(
						'value' => 'one-column-left-sidebar',
						'label' => __('One column with left sidebar', 'oct-physiotherapy'),
						'src' => get_template_directory_uri() . '/option-tree/assets/images/layout/sidebar-one-column.png',
					),
				)
			),
		)
	);
	$therapies_meta          = array(
		'id'       => 'int_ban_box',
		'title'    => __( 'Page Sections', 'oct-physiotherapy' ),
		'desc'     => '',
		'pages'    => array( 'therapy' ),
		'context'  => 'normal',
		'priority' => 'low',
		'fields'   => array(
			array(
				'label' => __( 'Internal Banners', 'oct-physiotherapy' ),
				'id'    => 'banner_settings',
				'type'  => 'tab',
			),
			array(
				'label' => __( 'Show Banner?', 'oct-physiotherapy' ),
				'id'    => 'internal_banner_switch',
				'type'  => 'on-off',
				'class' => 'switch_div',
				'std'   => 'on'
			),
			array(
				'label' => __( 'Image', 'oct-physiotherapy' ),
				'id'    => 'banner_image',
				'type'  => 'upload',
				'class' => 'ot-upload-attachment-id'
			),
			array(
				'label'     => __( 'Subtitle', 'oct-physiotherapy' ),
				'id'        => 'page_subtitle',
				'type'      => 'textarea-lite',
				'rows'      => '2',
				'condition' => 'internal_banner_switch:is(on)'
			),
			array(
				'label' => __( 'Banner', 'oct-physiotherapy' ),
				'id'    => 'slider-tab',
				'type'  => 'tab'
			),
			array(
				'label'    => __( 'Image', 'oct-physiotherapy' ),
				'id'       => 'slider_images',
				'type'     => 'list-item',
				'settings' => array(
					array(
						'label' => __( 'Image', 'oct-physiotherapy' ),
						'type'  => 'upload',
						'class' => 'ot-upload-attachment-id',
						'id'    => 'therapy_slide'
					)
				)
			),
			array(
				'label' => __( 'Listing', 'oct-physiotherapy' ),
				'id'    => 'therapy_icon',
				'type'  => 'tab',
			),
			array(
				'label' => __( 'Image', 'oct-physiotherapy' ),
				'id'    => 'therapy_icon_home',
				'type'  => 'upload',
				'class' => 'ot-upload-attachment-id',
//				'desc'  => __( 'This icon will be displayed in front page', 'oct-physiotherapy' )
			),
			array(
				'label' => __( 'Subtitle', 'oct-physiotherapy' ),
				'id'    => 'therapy_subtitle',
				'type'  => 'textarea-simple',
				'rows'  => 3,
				'desc'  => __( 'This will be displayed in Listing Page section', 'oct-physiotherapy' )
			),
			array(
				'label' => __( 'Introduction', 'oct-physiotherapy' ),
				'id'    => 'therapy_introduction',
				'type'  => 'textarea-simple',
				'rows'  => 3,
				'desc'  => __( 'This will be displayed in Listing Page section', 'oct-physiotherapy' )
			),
			array(
				'label' => __( 'Buttons', 'oct-physiotherapy' ),
				'id'    => 'therapy_buttons',
				'type'  => 'tab',
			),
			array(
				'label' => __( 'First button title', 'oct-physiotherapy' ),
				'type'  => 'text',
				'id'    => 'therapy_first_button_text'
			),
			array(
				'label' => __( 'First button link', 'oct-physiotherapy' ),
				'type'  => 'text',
				'id'    => 'therapy_first_button_link'
			),
			array(
				'label' => __( 'Button 2 Title', 'oct-physiotherapy' ),
				'type'  => 'text',
				'id'    => 'therapy_second_button_text',
				'desc'  => __( 'This button will open detailed page', 'oct-physiotherapy' )
			),
			array(
				'label' => __( 'Features', 'oct-physiotherapy' ),
				'id'    => 'therapy_benefit_tab',
				'type'  => 'tab'
			),
			array(
				'label'    => __( 'Features', 'oct-physiotherapy' ),
				'type'     => 'list-item',
				'id'       => 'single_therapy_benefit',
				'settings' => array(
					array(
						'label' => __( 'Image', 'oct-physiotherapy' ),
						'type'  => 'upload',
						'class' => 'ot-upload-attachment-id',
						'id'    => 'single_therapy_ben_icon'
					),
					array(
						'label' => __( 'Content', 'oct-physiotherapy' ),
						'type'  => 'textarea-simple',
						'id'    => 'single_therapy_ben_text',
						'rows'  => '3'
					)
				)
			),
			/* Gallery Section */
			array(
				'label' => __( 'Gallery', 'oct-physiotherapy' ),
				'id'    => 'home_gallery',
				'type'  => 'tab'
			),
			array(
				'label' => __( 'Show Section', 'oct-physiotherapy' ),
				'id'    => 'home_gallery_switch',
				'type'  => 'on-off',
				'class' => 'switch_div',
				'std'   => 'on'
			),
			array(
				'label'     => __( 'Section Title', 'oct-physiotherapy' ),
				'id'        => 'gallery_section_title',
				'type'      => 'text',
				'std'       => '',
				'condition' => 'home_gallery_switch:is(on)'
			),
			array(
				'label'     => __( 'Section Content', 'oct-physiotherapy' ),
				'id'        => 'gallery_section_content',
				'type'      => 'textarea-lite',
				'rows'      => '3',
				'std'       => '',
				'condition' => 'home_gallery_switch:is(on)'
			),
			array(
				'id'        => 'gallery_images',
				'label'     => __( 'Gallery', 'oct-physiotherapy' ),
				'std'       => '',
				'type'      => 'gallery',
				'class'     => 'ot-gallery-shortcode',
				'condition' => 'home_gallery_switch:is(on)'
			),
		)
	);
	$instructor_subtitle     = array(
		'id'       => 'inst_sub',
		'title'    => __( 'Subtitle', 'oct-physiotherapy' ),
		'desc'     => '',
		'pages'    => array( 'post' ),
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			array(
				'label' => __( 'Banner Settings', 'oct-physiotherapy' ),
				'id'    => 'banner_settings',
				'type'  => 'tab',
			),
			array(
				'label' => __( 'Show Banner?', 'oct-physiotherapy' ),
				'id'    => 'internal_banner_switch',
				'type'  => 'on-off',
				'class' => 'switch_div',
				'std'   => 'on'
			),
			array(
				'label'     => __( 'Banner Text', 'oct-physiotherapy' ),
				'id'        => 'int_ban_text',
				'type'      => 'textarea-simple',
				'rows'      => '2',
				'condition' => 'internal_banner_switch:is(on)'
			),
			array(
				'label'     => __( 'Banner Image', 'oct-physiotherapy' ),
				'id'        => 'banner_image',
				'type'      => 'upload',
				'class'     => 'ot-upload-attachment-id',
				'condition' => 'internal_banner_switch:is(on)'
			),
		)
	);
	/**
	 * Register our meta boxes using the
	 * ot_register_meta_box() function.
	 */
	if ( function_exists( 'ot_register_meta_box' ) ) /* Exclude these templates from having common metaboxes. */ {
		$exclude_page_templates = array(
			'page-templates/about-us.php',
			'page-templates/contact-page.php',
			'page-templates/services-page.php',
		);
	}

	/* Blog Page ID */
	$blog_page_id       = get_option( 'page_for_posts' );
	$page_id            = get_permalink();
	$page_template_file = '';
	if ( isset( $_REQUEST['post'] ) ) {
		$page_id            = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'];
		$page_template_file = get_post_meta( $page_id, '_wp_page_template', true );
	}
	if ( isset( $_POST['post_ID'] ) ) {
		$page_id            = $_POST['post_ID'];
		$page_template_file = get_post_meta( $page_id, '_wp_page_template', true );
	}

	$front_page = get_option( 'page_on_front' );
	if ( isset( $page_id ) && $front_page == $page_id ) {
		ot_register_meta_box( $homepage_sections );
	}

	/* About Us Page Metaboxes */
	if ( $page_template_file == 'page-templates/about-us.php' ) {
		ot_register_meta_box( $about_sections );
	}

	/* Contact Page Metaboxes */
	if ( $page_template_file == 'page-templates/contact-page.php' ) {
		ot_register_meta_box( $contact_sections );
	}
	/* CPT Listing Metaboxes */

	if ( $page_template_file == 'page-templates/services-page.php' ) {

		ot_register_meta_box( $therapies_template_meta );
	}

	/* Blog Page Metaboxes */
	if ( $blog_page_id == $page_id ) {
		ot_register_meta_box( $blog_settings );
	}

	/* General Pages Banner Settings */
	if ( isset( $page_id ) && $front_page != $page_id && $blog_page_id != $page_id && ! in_array( $page_template_file, $exclude_page_templates ) ) {
		ot_register_meta_box( $page_banners );
		ot_register_meta_box($layouts);
	}

	ot_register_meta_box( $instructor_subtitle );
	ot_register_meta_box( $therapies_meta );
}
