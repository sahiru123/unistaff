<?php
/*
Plugin Name: Univesity academic staff display
Description: dsplay academic staff 
Version: 1.0
Author: Microweb Global (PVT) LTD
*/



function custom_event_display_styles_and_scripts() {
    echo '<style>';
    include(plugin_dir_path(__FILE__) . 'university-academic-staff.css');
    echo '</style>';

   
}
add_action('wp_head', 'custom_event_display_styles_and_scripts');


// Shortcode to display academic staff
function university_academic_staff_shortcode() {
    $args = array(
        'post_type'      => 'staff',
        'posts_per_page' => -1,
        'orderby'        => 'date',
        'order'          => 'DESC', 
    );


    $query = new WP_Query($args);

    $output = '';

    if ($query->have_posts()) {
        $output .= '<div class="university-academic-staff">';
        while ($query->have_posts()) {
            $query->the_post();

            $staff_name = get_field('staff_name');
            $staff_position = get_field('staff_position');
            $staff_description = get_field('staff_description');
            $staff_image = get_field('staff_image'); 

            $output .= '<div class="staff-profile">';
            if (!empty($staff_image)) {
                $output .= '<img src="' . esc_url($staff_image['url']) . '" alt="' . esc_attr($staff_name) . '" class="staff-image">'; // Display the image using its URL
            }
            $output .= '<div class="staff-info">';
            if (!empty($staff_name)) {
                $output .= '<h3 class="staff-name">' . esc_html($staff_name) . '</h3>';
            }
            if (!empty($staff_position)) {
                $output .= '<p class="staff-position">' . esc_html($staff_position) . '</p>';
            }
            if (!empty($staff_description)) {
                $output .= '<div class="staff-description">' . $staff_description . '</div>';
            }
            $output .= '<a href="' . esc_url(get_field('staff_profile_pdf')) . '" class="staff-button">View Profile</a>';
            $output .= '</div>'; 
            $output .= '</div>'; 
        }
        $output .= '</div>';

        wp_reset_postdata();
    } else {
        $output .= 'No academic staff found.';
    }

    return $output;
}
add_shortcode('university_academic_staff', 'university_academic_staff_shortcode');
?>
