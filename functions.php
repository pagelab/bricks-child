<?php 
/**
 * Bricks Builder Custom Child-theme.
 *
 * @link  https://epico.studio
 * @since  1.2.0
 */

namespace BricksChild;

// =========================================
// =                 HOOKS                 =
// =========================================

// Disables the block editor from managing widgets in the Gutenberg plugin.
add_filter( 'gutenberg_use_widgets_block_editor', '__return_false', 100 );

// Removes core block patterns and disable remote patterns.
add_action( 'after_setup_theme', __NAMESPACE__ . '\\disable_block_patterns', 15 );

// Allow all helper functions to appear in the dynamic data `echo` tag. https://academy.bricksbuilder.io/article/filter-bricks-code-echo_function_names/
add_filter( 'bricks/code/echo_function_names',  function($function_name) {
    return [
        '@^brx_', // Allow all functions that start with "brx_"
    ];
});

// Disables the block editor from managing widgets. Renamed from wp_use_widgets_block_editor
add_filter( 'use_widgets_block_editor', '__return_false' );

// Register/enqueue custom styles.
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_styles' );

// Remove the native Bricks script.
// add_filter( 'script_loader_tag', __NAMESPACE__ . '\\remove_bricks_script_frontend', 10, 3 );

// Register/enqueue custom scripts.
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_scripts', 11 );

// Add text strings to builder.
add_filter( 'bricks/builder/i18n',  __NAMESPACE__ . '\\add_strings' );

# -----------  Change menu items  -----------

// Include descriptions on menu items.
add_filter( 'walker_nav_menu_start_el',  __NAMESPACE__ . '\\add_description_to_menu_item', 10, 4 );

// Remove specific CSS classes the <li> element on nav menus.
add_filter( 'nav_menu_css_class',  __NAMESPACE__ . '\\remove_classes_from_menu_item', 10, 1 );

// Transfer menu item classes from the <li> to the <a> element.
add_filter( 'nav_menu_link_attributes',  __NAMESPACE__ . '\\add_class_to_menu_link', 10, 4 );


# -----------  Add wrapper div between <header> and <footer>  -----------

// Add the opening wrapper div after the header
// add_action( 'bricks_before_header', __NAMESPACE__ . '\\open_wrapper_before_header' );

// Add the closing wrapper div before the footer
// add_action( 'bricks_before_footer', __NAMESPACE__ . '\\close_wrapper_before_footer' );


# -----------  Change “Users” text in the dashboard  -----------

// Change the text used under “Users” menu.
// add_action( 'admin_menu', __NAMESPACE__ . '\\modify_menu_name' );

// Change the title text under users.php
// add_action( 'admin_head', __NAMESPACE__ . '\\change_user_title' );

// Change the button text under Users → All new user.
// add_filter( 'gettext', __NAMESPACE__ . '\\change_add_new_user_text', 20, 3 );

// Add custom column under Users → All users.
// add_filter( 'manage_users_columns', __NAMESPACE__ . '\\custom_user_columns' );

// Change the values or User columns Users → All users.
// add_filter( 'manage_users_custom_column', __NAMESPACE__ . '\\custom_user_column_values', 10, 3 );

// Transform the user's Biographical data in WYSIWYG.
// add_action( 'edit_user_profile', __NAMESPACE__ . '\\change_biographical_info_field' );


# -----------  Transform images  -----------

// Remove image sizes.
add_action( 'intermediate_image_sizes_advanced', __NAMESPACE__ . '\\remove_default_images' );

// Change size of Scaled image.
add_filter( 'big_image_size_threshold', __NAMESPACE__ . '\\check_image_size',10,3 );

// Add image sizes.
add_action( 'after_setup_theme', __NAMESPACE__ . '\\add_image_sizes' );

// Register the image size names for use in Add Media
add_action( 'image_size_names_choose', __NAMESPACE__ . '\\custom_size_names' );

// Increase the maximum image width to be included in a 'srcset' attribute.
add_filter( 'max_srcset_image_width', __NAMESPACE__ . '\\increase_max_srcset_image_width' );

// Convert Uploaded Images to WebP Format.
add_filter( 'wp_handle_upload', __NAMESPACE__ . '\\handle_upload_convert_to_webp' );

# -----------  Modify the “Toggle” element  -----------

// Define manually the text of the toggle element, which does not offer a text-field to insert a title.
// add_filter( 'bricks/element/set_root_attributes', __NAMESPACE__ . '\define_toggle_element_text', 10, 2 );

// Filter Toggle Element (bug: filter does not work on the front-end)
// add_filter( 'bricks/element/render_attributes', __NAMESPACE__ . '\\change_toggle_element_attribute', 10, 3 );

// Filter Toggle Element (bug: filter does not work on the front-end)
// add_filter( 'bricks/elements/toggle/controls', __NAMESPACE__ . '\\change_toggle_element', 10, 3 );


# -----------  Modify the front-end markup  -----------

// Add an div wrapper inside specific areas.
// add_filter('bricks/frontend/render_data', __NAMESPACE__ . '\\add_div_wrapper', 10, 3 );

// Add the content of each heading as an `data-content` attribute.
// add_filter('bricks/frontend/render_data', __NAMESPACE__ . '\\add_content_to_headings', 10, 3 );

// Add custom attributes to the native Bricks form element.
// add_filter( 'bricks/element/set_root_attributes', 'add_custom_attributes_to_bricks_form_element' 10, 2 );

if ( function_exists( 'wpcf7' ) ) {

    // Dequeue scripts from CF7.
    add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\dequeue_cf7_scripts_styles', 11 );

    // Adds the `data-1p-ignore` attribut to the CF7 email field.
    add_filter( 'wpcf7_form_elements', __NAMESPACE__ . '\\add_custom_attribute' );

    // Adds the `id` attribute to the CF7 form tag.
    add_filter( 'wpcf7_form_id_attr', __NAMESPACE__ . '\\add_custom_id_to_form' );

    // Adds the `data-netlify` attribute to the CF7 form tag.
    add_filter( 'wpcf7_form_additional_atts', __NAMESPACE__ . '\\add_custom_data_attribute_to_form' );

    // Changes the `enctype` attribute for specific CF7 forms.
    // add_filter( 'wpcf7_form_enctype', __NAMESPACE__ . '\\change_enctype' );

    // Adds the `name` attribute to the CF7 form tag.
    add_filter( 'wpcf7_form_name_attr', __NAMESPACE__  . '\\add_custom_name_to_form' );

    // Changes the form action URL.
    add_filter( 'wpcf7_form_action_url', __NAMESPACE__ . '\\add_custom_action_url_to_form' );

    // Adds hidden fields with the subject (for Netlify forms notification feature).
    // add_filter( 'wpcf7_form_hidden_fields', __NAMESPACE__ . '\\add_hidden_fields_for_subject' );

    // Removes CF7 default hidden fields.
    add_action( 'wp_footer', __NAMESPACE__ . '\\remove_default_hidden_fields' );
}

# -----------  Filter plugin functions  -----------


// Check if Simply Static plugin is active before adding the filter
if ( is_plugin_active( 'simply-static/simply-static.php' ) ) {
    // Add custom rules for the Simply Static image extractor.
    add_filter( 'ss_match_tags', __NAMESPACE__ . '\\custom_rules_for_ss_extractor' );
}

// Check if ACF plugin is active before adding the filter
if ( class_exists( 'ACF' ) ) {
    // Google Maps API key
    add_filter( 'acf/fields/google_map/api', __NAMESPACE__ . '\\acf_google_maps_api' );
}


// =========================================
// =               CALLBACKS               =
// =========================================

/**
 * Register/enqueue custom styles.
 *
 * @since  1.2.0
 * @return void
 */
function enqueue_styles() {
    // Enqueue your files on the canvas & frontend, not the builder panel. Otherwise custom CSS might affect builder.
    if ( ! bricks_is_builder_main() ) {
        wp_enqueue_style( 'bricks-child-styles', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/dist/styles-min.css', ['bricks-frontend'], filemtime( trailingslashit( get_stylesheet_directory() ) . 'assets/dist/styles-min.css' ) );
    }
};


/**
 * Remove the native bricks script.
 *
 * @since  1.2.0
 * @return void
 */
function remove_bricks_script_frontend( $tag, $handle, $src ) {
    if ( 'bricks-scripts' === $handle ) {$tag = '';}
    return $tag;
}

/**
 * Register/enqueue custom scripts.
 *
 * @since  1.2.0
 * @return void
 * @link   https://forum.bricksbuilder.io/t/want-easy-scroll-animations-with-bricks-here-you-go/22051/10
 */
function enqueue_scripts() {
    // Check if both GSAP and ScrollTrigger are already enqueued. Also enqueue files on the canvas & frontend, not the builder panel.
    if ( ! bricks_is_builder_main() && wp_script_is( ! 'bc_gsap_enable', 'enqueued' ) && wp_script_is( ! 'bc_scrolltrigger_enable', 'enqueued' ) ) { return; }

    // Enqueue the script that allows scroll animations using data attributes.
    wp_enqueue_script(
        'bricks-child-scripts',
        trailingslashit( get_stylesheet_directory_uri() ) . 'assets/dist/scripts-min.js',
        [],
        filemtime( trailingslashit( get_stylesheet_directory() ) . 'assets/dist/scripts-min.js' ),
        [ 'strategy'  => 'defer' ]
    );

    // Enqueue the Cloudflare Turnstile's script.
    wp_enqueue_script(
        'cloudflare-turnstile',
        'https://challenges.cloudflare.com/turnstile/v0/api.js',
        [],
        null,
        true
    );
};


/**
 * Dequeue scripts from CF7
 *
 * @since  1.2.0
 * @return void
 */
function dequeue_cf7_scripts_styles() {

    // Dequeue Contact Form 7 scripts
    wp_dequeue_script('contact-form-7');
    wp_dequeue_script('contact-form-7-js');

    // Dequeue Contact Form 7 styles
    wp_dequeue_style('contact-form-7');
    wp_dequeue_style('contact-form-7-css');
}


/**
 * Add text strings to builder
 *
 * @since  1.2.0
 * @return string
 */
function add_strings( $i18n ) {

    // For element category 'custom'
    $i18n['custom'] = esc_html__( 'Custom', 'bricks' );

    return $i18n;
};

/**
 * Removes core block patterns and disable remote patterns.
 *
 * @since  1.2.0
 * @return void
 */
function disable_block_patterns() {
    remove_theme_support( 'core-block-patterns' );
    add_filter( 'should_load_remote_block_patterns', '__return_false' );
}

/*=========================================
=            Change menu items            =
=========================================*/

/**
 * Include descriptions on menu items.
 *
 * @since  1.2.0
 * @return string
 */
function add_description_to_menu_item( $item_output, $item, $depth, $args ) {
    if ( ! empty( $item->description ) ) {
        $item_output .= '<span class="menu-item-description">' . $item->description . '</span>';
    }
    return $item_output;
}


/**
 * Remove specific CSS classes the <li> element on nav menus.
 *
 * @since  1.2.0
 * @return array
 */
function remove_classes_from_menu_item( $classes ) {
  $classes = array_filter( $classes, function( $class ) {
    return strpos( $class, 'ri-' ) !== 0;
  } );
  return $classes;
}


/**
 * Transfer menu item classes from the <li> to the <a> element.
 *
 * @since  1.2.0
 * @return array
 */
function add_class_to_menu_link( $atts, $item, $args, $depth ) {
    $classes = $item->classes;
    $atts['class'] = implode( ' ', $classes );
    return $atts;
}


/*=====================================================================
=            Add wrapper div between <header> and <footer>            =
=====================================================================*/

/**
 *
 * Opens the wrapper before the header.
 *
 * @since  1.2.0
 * @return void
 */
function open_wrapper_before_header() {
    echo '<div class="brx-main-wrapper">';
};


/**
 *
 * Closes the wrapper before the footer.
 *
 * @since  1.2.0
 * @return void
 */
function close_wrapper_before_footer() {
    echo '</div>';
};


/*============================================================
=            Change “Users” text in the dashboard            =
============================================================*/

/**
 *
 * Change the text used under “Users” menu.
 *
 * @since  1.2.0
 * @return void
 */
function modify_menu_name() {
    global $menu, $submenu;

    // Main menu (top)
    foreach ($menu as $main_menu => $single_menu) {
        foreach( $single_menu as $key => $menu_item ) {
            if( $menu_item === 'Users' ) {
                $menu[$main_menu][$key] = 'Team';
                break; // Break after updating the first occurrence
                unset($menu_item); // Avoid conflicts
                unset($key);
            }
        }
    }

    // Submenus
    $submenu['users.php'][5][0] = 'All Team Members';
    $submenu['users.php'][10][0] = 'Add New Member';
}


/**
 *
 * Change the title text under users.php
 *
 * @since  1.2.0
 * @return void
 */
function change_user_title() {
    global $title;

    if ( $title === 'Users' ) {
        $title = 'Team Members';
    }
}


/**
 *
 * Change the button text under Users → All new user
 *
 * @since  1.2.0
 * @return string
 */
function change_add_new_user_text( $translated_text, $text, $domain ) {
    if ( $text === 'Add New User' ) {
        $translated_text = 'Add New Team Member';
    }
    return $translated_text;
}

/**
 *
 * Add custom column under Users → All users
 *
 * @since  1.2.0
 * @return array
 */
function custom_user_columns( $columns ) {
    $columns['custom_field_name'] = 'Photo';
    return $columns;
}

/**
 *
 * Change the values or User columns Users → All users
 *
 * @since  1.2.0
 * @return string
 */
function custom_user_column_values( $value, $column_name, $user_id ) {
    if ( 'custom_field_name' == $column_name ) {
        $image = get_field( 'team_member_photo', 'user_' . $user_id );
        if ( $image ) {
            $value = '<img src="' . $image['url'] . '" alt="' . $image['alt'] . '" width="50" />';
        } else {
            $value = 'N/A';
        }
    }
    return $value;
}


/**
 *
 * Transform the user's Biographical data field in WYSIWYG.
 *
 * @since  1.2.0
 * @return void
 */
function change_biographical_info_field($user) {
    wp_enqueue_editor();

    ?>
    <script>
    document.addEventListener("DOMContentLoaded", function(event) {
        var id = 'description';

        wp.editor.initialize(id, {
            tinymce: {
                wpautop: true
            },
            quicktags: true
        });
    });
    </script>
    <?
}


/*=============================================
=            Transform image sizes            =
=============================================*/

/**
 *
 * Remove image sizes
 *
 * @since  1.2.0
 * @return array
 */
function remove_default_images( $sizes ) {
    unset( $sizes[ 'medium_large' ]);
    unset( $sizes[ '1536x1536' ]);
    unset( $sizes[ '2048x2048' ]);
    return $sizes;
}

/**
 *
 * Change size of Scaled image
 *
 * @since  1.2.0
 * @return int
 */
function check_image_size($imagesize, $file, $attachment_id) {
    return 2400;
}

/**
 *
 * Add image sizes
 *
 * @since  1.2.0
 * @return void
 */
function add_image_sizes() {
    add_image_size( 'image_small', 270 );
    add_image_size( 'image_medium', 300 );
    add_image_size( 'image_large', 600 );
    add_image_size( 'image_x_large', 800 );
    add_image_size( 'image_max', 1600 );
}

/**
 *
 * Register the image size names for use in Add Media
 *
 * @since  1.2.0
 * @return array
 */
function custom_size_names( $sizes ) {
    return array_merge( $sizes, array(
        'image_small'   => __( 'Small', 'bricks-child' ),
        'image_medium'  => __( 'Medium', 'bricks-child' ),
        'image_large'   => __( 'Large', 'bricks-child' ),
        'image_x_large' => __( 'Extra Large', 'bricks-child' ),
        'image_max'     => __( 'Maximum', 'bricks-child' ),
        )
    );
}

/**
 *
 * Increase the maximum image width to be included in a 'srcset' attribute.
 *
 * @since  1.2.0
 * @return int
 */
function increase_max_srcset_image_width( $max_width ) {
    return 2400;
}


/**
 * Convert Uploaded Images to WebP Format
 *
 * This snippet converts uploaded images (JPEG, PNG, GIF) to WebP format
 * automatically in WordPress. Ideal for use in a theme's functions.php file,
 * or with plugins like Code Snippets or WPCodeBox.
 *
 * @package    WordPress_Custom_Functions
 * @author     Mark Harris
 * @link       https://helwp.com/tutorials/convert-images-to-webp-in-wordpress/
 *
 * Usage Instructions:
 * - Add this snippet to your theme's functions.php file, or add it as a new
 *   snippet in Code Snippets or WPCodeBox.
 * - The snippet hooks into WordPress's image upload process and converts
 *   uploaded images to the WebP format.
 *
 * Optional Configuration:
 * - By default, the original image file is deleted after conversion to WebP.
 *   If you prefer to keep the original image file, simply comment out or remove
 *   the line '@unlink( $file_path );' in the wpturbo_handle_upload_convert_to_webp function.
 *   This will preserve the original uploaded image file alongside the WebP version.
 */
function handle_upload_convert_to_webp( $upload ) {
    if ( $upload['type'] == 'image/jpeg' || $upload['type'] == 'image/png' || $upload['type'] == 'image/gif' ) {
        $file_path = $upload['file'];

        // Check if ImageMagick or GD is available
        if ( extension_loaded( 'imagick' ) || extension_loaded( 'gd' ) ) {
            $image_editor = wp_get_image_editor( $file_path );
            if ( ! is_wp_error( $image_editor ) ) {
                $file_info = pathinfo( $file_path );
                $dirname   = $file_info['dirname'];
                $filename  = $file_info['filename'];

                // Create a new file path for the WebP image
                $new_file_path = $dirname . '/' . $filename . '.webp';

                // Attempt to save the image in WebP format
                $saved_image = $image_editor->save( $new_file_path, 'image/webp' );
                if ( ! is_wp_error( $saved_image ) && file_exists( $saved_image['path'] ) ) {
                    // Success: replace the uploaded image with the WebP image
                    $upload['file'] = $saved_image['path'];
                    $upload['url']  = str_replace( basename( $upload['url'] ), basename( $saved_image['path'] ), $upload['url'] );
                    $upload['type'] = 'image/webp';

                    // Optionally remove the original image
                    // @unlink( $file_path );
                }
            }
        }
    }

    return $upload;
}


/*===================================================
=            Modify the “Toggle” element            =
===================================================*/

/**
 *
 * Define manually the text of the toggle element, which does not offer a text-field to insert a title.
 *
 * @since  1.2.0
 * @return array
 */
function define_toggle_element_text( $attributes, $element ) {
    if ( $element->name === 'toggle' ) {
        $attributes['data-title'][] = 'Menu';
        // $attributes['data-title'][] = $element->settings['toggleTitle'];
    }

    return $attributes;
};

/**
 *
 * Filter Toggle Element (bug: filter does not work on the front-end)
 *
 * @since  1.2.0
 * @return array
 */
function change_toggle_element_attribute( $attributes, $key, $element ) {
    if ( $element->name == 'toggle'
       && isset( $element->settings['toggleTitle'] )  ) {
        $attributes[ $key ]['data-title'] = $element->settings['toggleTitle'];
    }

    return $attributes;
};

/**
 *
 * Filter Toggle Element (bug: filter does not work on the front-end)
 *
 * @since  1.2.0
 * @return array
 */
function change_toggle_element( $controls ) {
    $controls['toggleTitle'] = [
        'tab'      => 'content',
        'label'    => esc_html__( 'Title', 'bricks-child' ),
        'type'     => 'text',
        'inlineEditing' => true,
        'default' => 'Menu',
    ];

    return $controls;
};


/*=========================================
=            Modify the markup            =
=========================================*/

/**
 *
 * Add an div wrapper inside specific areas
 *
 * @since  1.2.0
 * @return string
 */
function add_div_wrapper( $content, $post, $area ) {
    // Check if we are in the 'header' or 'content' area
    if ($area === 'header' || $area === 'content') {
        // Wrap the entire content of the 'header' or 'content' area with a div
        $content = '<div class="wrapper">' . $content . '</div>';
    }

    // Return the modified content
    return $content;
};


/**
 *
 * Add the content of each heading as an `data-content` attribute.
 *
 * @since  1.2.0
 * @return array
 */
function add_content_to_headings( $content, $post, $area ) {
  // Iterate over each heading tag
  $content = preg_replace_callback(
    '/(<h[1-6](.*?))>(.*?)(<\/h[1-6]>)/i',
    function( $matches ) {
      // Add 'id' attribute if it doesn't exist
      if (strpos($matches[2], 'data-content=') === false) {
        // Use heading's content as the ID
        $matches[0] = $matches[1] . ' data-content="' . sanitize_title( $matches[3] )
        . '">' . $matches[3] . $matches[4];
      }

      // Return the (potentially) modified heading tag
      return $matches[0];
    },
    $content // Content to modify
  );

  // Return modified content
  return $content;
};

/**
 *
 * Add custom attributes to the native Bricks form element.
 *
 * @since  1.2.0
 * @return string
 */
function add_custom_attributes_to_bricks_form_element( $attributes, $element ) {
    // Add root attributes to every form element
    if ( $element->name === 'form' ) {
        // Add custom attributes
        $attributes['data-netlify'][] = 'true';
        $attributes['netlify-honeypot'][] = 'bot-field';
    }

    return $attributes;
}

/**
 *
 * Add an ID to the footer's CF7 form.
 *
 * @since  1.2.0
 * @param $html_id The current id value
 * @return string  The new id
 */
function add_custom_id_to_form($html_id) {

    // Change this to conditionally add the ID attribute based on the form's ID.
    // $wpcf7   = WPCF7_ContactForm::get_current();
    // $form_id = $wpcf7->id();

    // $default = 'contact-form';

    // switch( $form_id ) {
    //     case '4':
    //         return 'custom-id-1';
    //     case '4032':
    //         return 'custom-id-2';
    //     case '10277':
    //         return 'custom-id-3';
    //     default:
    //         return $default;
    // }

    return 'footer-subscription-form';
};


/**
 *
 * Add the `data-1p-ignore` attribute to the CF7 email field.
 *
 * @since  1.2.0
 * @return string
 */
function add_custom_attribute( $content ) {
    $str_pos = strpos( $content, ' name="your-email"' );
    $content = substr_replace( $content, ' data-1p-ignore required', $str_pos, 0 );
    return $content;
}

/**
 *
 * Add the `data-netlify` attribute to the CF7 form tag.
 *
 * @since  1.2.0
 * @return string
 */
function add_custom_data_attribute_to_form( $additional_atts ) {
    $additional_atts['data-netlify'] = 'true';
    $additional_atts['data-cf-turnstile-sitekey'] = '0x4AAAAAAAaqIjXc2svra1VK';
    $additional_atts['netlify-honeypot'] = 'bot-field';
    return $additional_atts;
}

/**
 * Changes the `enctype` attribute for specific CF7 forms.
 *
 * @since  1.2.0
 * @link   https://github.com/pagelab/contact-form-7-hooks
 * @return string
 */
function change_enctype( $html_enctype = '' ) {
    $wpcf7   = WPCF7_ContactForm::get_current();
    $form_id = $wpcf7->id;

    $default = '';

    switch( $form_id ){
        case '1': // Change the Form's ID (get from the code).
            return 'multipart/form-data';
        default:
            return $default;
    }
}

/**
 *
 * Add the `name` attribute to the CF7 form tag.
 *
 * @since  1.2.0
 * @link   https://github.com/pagelab/contact-form-7-hooks
 * @return string
 */
function add_custom_name_to_form( $html_name ) {

    // Change this to conditionally add the name attribute based on the form's ID.
    // $wpcf7   = WPCF7_ContactForm::get_current();
    // $form_id = $wpcf7->id;

    // $default = 'contact-form';

    // switch( $form_id ){
    //     case '4':
    //         return 'custom-id-1';
    //     case '4032':
    //         return 'whatswhat-group';
    //     case '10277':
    //         return 'publish-your-article';
    //     default:
    //         return $default;
    // }

    return 'subscription-form';
};


/**
 * Change the CF7 form action URL.
 *
 * @param  $url    the current URL
 * @return string  The new URL you want
 */
function add_custom_action_url_to_form( $url ) {
    return '/thankyou';
};


/**
 * Adds hidden field with the subject (for Netlify forms notification feature).
 *
 * @param  $url    the current URL
 * @return string  The new URL you want
 * @link   https://docs.netlify.com/forms/notifications/#customize-the-email-subject-line
 */
function add_hidden_fields_for_subject( $url ) {
    $wpcf7   = WPCF7_ContactForm::get_current();
    $form_id = $wpcf7->id();

    // Define custom hidden fields for specific forms
    switch( $form_id ) {
        case '1': // Change the ID
            $hidden_field['subject'] = 'Texto do assunto 1';
            break;
        case '10': // Change the ID
            $hidden_field['subject'] = 'Texto do assunto 2';
            break;
        case '100': // Change the ID
            $hidden_field['subject'] = 'Texto do assunto 3';
            break;
        default:
            $hidden_field['subject'] = 'Texto do assunto padrão';
    }

    return $hidden_field;

}


/**
 * Removes CF7 default hidden fields.
 *
 * @param  $url    the current URL
 * @return string  The new URL you want
 * @link   https://docs.netlify.com/forms/notifications/#customize-the-email-subject-line
 */
function remove_default_hidden_fields() {
    ?>
    <script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        // Target the specific hidden fields you want to remove
        const fieldsToRemove = [
            '_wpcf7',
            '_wpcf7_version',
            '_wpcf7_locale',
            '_wpcf7_unit_tag',
            '_wpcf7_container_post',
            '_wpcf7_posted_data_hash',
            '_wpnonce'
        ];

        // Get all Contact Form 7 forms on the page
        const cf7Forms = document.querySelectorAll('.wpcf7-form');

        cf7Forms.forEach(function(form) {
            fieldsToRemove.forEach(function(fieldName) {
                const field = form.querySelector('input[name="' + fieldName + '"]');
                if (field) {
                    field.remove();
                }
            });
        });
    });
    </script>
    <?php
}


/**
 * Add custom rules for the Simply Static image extractor.
 *
 * @param  $tags  The list of tags.
 * @return array
 */
function custom_rules_for_ss_extractor( $tags ) {
    $tags['div']  = [ 'href', 'src', 'style' ];
    $tags['li']   = [ 'style' ];
    $tags['span'] = [ 'style' ];

    return $tags;
};


/**
 * Google Maps API key
 *
 * @param  $api  The API key.
 * @return string
 */
function acf_google_maps_api( $api ){
    $api['key'] = 'AIzaSyAybdzmHV7EV8TqAEtqQrwhzzj7pA1PBMY';

    return $api;
}
