<?php

/**
 * Astra Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra Child
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define('CHILD_THEME_ASTRA_CHILD_VERSION', '1.0.0');

/**
 * Enqueue styles
 */

// AJAX handler to filter products based on selected categories

function initialize_credit_balance( $user_id ) {
    // Set the initial credit balance for the user
    $initial_credit_balance = 40;
    update_user_meta( $user_id, 'credit_balance', $initial_credit_balance );
}
add_action( 'user_register', 'initialize_credit_balance' );

function reset_credit_balance( $user_id ) {
    // Set the initial credit balance for the user
    $credit_balance = get_user_meta($user_id, 'credit_balance', true);
      
    if (!$credit_balance) {
        $initial_credit_balance = 40;
        update_user_meta( $user_id, 'credit_balance', $initial_credit_balance );
    }    
}
add_action( 'init', 'reset_credit_balance' );
add_action( 'init', 'woocommerce_clear_cart_url' );
function woocommerce_clear_cart_url() {
	if ( isset( $_GET['clear-cart'] ) ) {
		global $woocommerce;
		$woocommerce->cart->empty_cart();
	}
}

add_action( 'woocommerce_payment_complete', 'update_user_meta_after_payment' );
function update_user_meta_after_payment( $order_id ) {
    $order = wc_get_order( $order_id );
    $user_id = $order->get_user_id();
	$initial_credit_balance = 40;
    update_user_meta( $user_id, 'credit_balance', $initial_credit_balance);
//make cart empty
	global $woocommerce;
	$woocommerce->cart->empty_cart();
}

function toggle_favorite_callback() {
    $post_id = $_POST['post_id'];
    // $favorite = $_POST['favorite'];

    if($post_id){
        $user_id = get_current_user_id();
        $favorite_musics = get_user_meta( $user_id, 'favorite_music', false);
        if ($user_id) {
            if( in_array( $post_id, $favorite_musics)){
                delete_user_meta($user_id, 'favorite_music', $post_id);
                wp_send_json_success();
            } else {
                add_user_meta($user_id, 'favorite_music', $post_id);
                wp_send_json_success();
            }
        } else {
            wp_send_json_error();
        }
    }else{
        wp_send_json_error();
    }
}
add_action('wp_ajax_toggle_favorite', 'toggle_favorite_callback');
add_action('wp_ajax_nopriv_toggle_favorite', 'toggle_favorite_callback');

function download_audio_file() {
    if (isset($_POST['music_id']) && isset($_POST['file_url'])) {
        $music_id = $_POST['music_id'];
        $file_url = $_POST['file_url'];

        // Retrieve the user's credit balance and download count for this music
        $user_id = get_current_user_id();
        $credit_balance = get_user_meta($user_id, 'credit_balance', true);
        $download_count = get_user_meta($user_id, 'download_count_' . $music_id, true);

        // Initialize credit balance and download count if they don't exist
        if (!$credit_balance) {
            add_user_meta($user_id, 'credit_balance', 40);
            $credit_balance = 40;
        }
        if (!$download_count) {
            add_user_meta($user_id, 'download_count_' . $music_id, 0);
            $download_count = 0;
        }

        // Check if the user has enough credits and download count is less than 5
        if ($credit_balance >= 1 && $download_count < 5) {
            // Deduct 1 credit from the user's account
            $new_credit_balance = $credit_balance - 1;
            update_user_meta($user_id, 'credit_balance', $new_credit_balance);

            // Increment the download count for this music for the user
            $new_download_count = $download_count + 1;
            update_user_meta($user_id, 'download_count_' . $music_id, $new_download_count);

             // Serve the audio file for download
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file_url) . '"');
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: ' . filesize($file_url));

            readfile($file_url);
            wp_send_json_success();
        } else {
            // Return an error message indicating insufficient credits or maximum download limit reached
            wp_send_json_error('Insufficient credits or maximum download limit reached.');
        }
    }
}
add_action('wp_ajax_download_audio_file', 'download_audio_file');
add_action('wp_ajax_nopriv_download_audio_file', 'download_audio_file');
function filter_products()
{
    // Cancel previous ongoing request
    // wp_ajax_abort();

    // Get the selected categories from the AJAX request
    $selectedCategories = json_decode(stripslashes($_POST['categories']));
    $searchQuery = stripslashes($_POST['query']);
    $allMusic = json_decode(stripslashes($_POST['all']));
    $favoriteOnly = json_decode(stripslashes($_POST['favorite_only']));
    
    $user_id = get_current_user_id(); // Get the current user ID
    $favorite_music = get_user_meta($user_id, 'favorite_music', false); 

    if ($allMusic) {
        $args = array(
            'post_type' => 'music',
            'post_status' => 'publish',
            'posts_per_page' => -1,
        );
    } else {
        if(empty($selectedCategories)){
            $args = array(
                'post_type' => 'music',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                's' => $searchQuery
            );  
        } else {
            $args = array(
                'post_type' => 'music',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                's' => $searchQuery,
                // 'meta_key' => 'singer_name', 
                // 'meta_value' => $singerName, 
                'tax_query' => array(
                    array(
                        'taxonomy' => 'music_category',
                        'field' => 'term_id',
                        'terms' => $selectedCategories
                        )
                    )
            );  
        }
       
    }

    if ( $favoriteOnly) {
        if( empty($favorite_music)){
            echo '<div class="audio-bg mt-3 text-white text-center">There is no music in favorites.</div>';
            wp_reset_postdata();
            wp_die();
        }
        $args['post__in'] = $favorite_music;
    }

    $query = new WP_Query($args);

    // var_dump($query->request);
    $user_id = get_current_user_id(); 

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            $tag_list = array();
            $tags = wp_get_post_terms(get_the_ID(), 'music_tags');

            if ($tags) {
                foreach ($tags as $tag) {
                    $tag_list[] = $tag->name;
                }
            }
            $attachment_id = get_post_meta(get_the_ID(), 'music_file', true);
            $file_path = wp_get_attachment_url($attachment_id);

            $favorite_musics= get_user_meta($user_id, 'favorite_music', false);
            $favorite_btn = "";

            if (in_array( get_the_ID(), $favorite_musics)) {
                $favorite_btn = '<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 512 512">
                <path d="M462.3 62.6C407.5 15.9 326 24.3 275.7 76.2L256 96.5l-19.7-20.3C186.1 24.3 104.5 15.9 49.7 62.6c-62.8 53.6-66.1 149.8-9.9 207.9l193.5 199.8c12.5 12.9 32.8 12.9 45.3 0l193.5-199.8c56.3-58.1 53-154.3-9.8-207.9" fill="#BF4261"/></svg>
              ';
            } else {
                $favorite_btn = '<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 512 512"><path d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8v-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5v3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20c0 0-.1-.1-.1-.1c0 0 0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5v3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2v-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z" fill="#F8F8F8" stroke="#F8F8F8" stroke-width="1.5"/></svg>';
            }

            echo '<div class="row audio-bg mt-3 py-4 py-md-2 mx-0">
            <input type="hidden" name="singer-name" value="' . get_post_meta(get_the_ID(), 'singer_name', true) . '"/>
            <audio id="audio-' . get_the_ID() . '" src="' . $file_path . '"></audio>
            <div class="col-xl-1 col-md-1 col-3">
                <div class="play-btn btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="21" height="25" viewBox="0 0 21 25" fill="none">
                        <path d="M21 12.5L0.750001 24.1913L0.750002 0.808657L21 12.5Z" fill="#FBFBFB"></path>
                    </svg>
                </div>
                <div class="play-icon btn" style="display: none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="22" viewBox="0 0 14 22" fill="none">
                        <path
                            d="M1.75 0C2.21413 0 2.65925 0.185516 2.98744 0.515736C3.31563 0.845957 3.5 1.29383 3.5 1.76083V19.3692C3.5 19.8362 3.31563 20.284 2.98744 20.6143C2.65925 20.9445 2.21413 21.13 1.75 21.13C1.28587 21.13 0.840752 20.9445 0.512563 20.6143C0.184375 20.284 0 19.8362 0 19.3692V1.76083C0 1.29383 0.184375 0.845957 0.512563 0.515736C0.840752 0.185516 1.28587 0 1.75 0ZM12.25 0C12.7141 0 13.1592 0.185516 13.4874 0.515736C13.8156 0.845957 14 1.29383 14 1.76083V19.3692C14 19.8362 13.8156 20.284 13.4874 20.6143C13.1592 20.9445 12.7141 21.13 12.25 21.13C11.7859 21.13 11.3408 20.9445 11.0126 20.6143C10.6844 20.284 10.5 19.8362 10.5 19.3692V1.76083C10.5 1.29383 10.6844 0.845957 11.0126 0.515736C11.3408 0.185516 11.7859 0 12.25 0Z"
                            fill="white"></path>
                    </svg>
                </div>
            </div>
            <div class="col-xl-2 col-md-2 col-9">
                <div class="audio-title"><span class="d-md-none">Title: </span>' . get_the_title() . '</div>
                <div class="audio-desc">
                    ' . get_post_meta(get_the_ID(), 'singer_name', true) . '
                </div>
            </div>
            <div class="col-xl-2 col-md-3 py-3 py-md-0">
                <div class="svg-wrapper">
                    <svg class="progress-bar" xmlns="http://www.w3.org/2000/svg" width="202" height="64" viewBox="0 0 202 64" version="1.1"><path d="" stroke="none" fill="#282424" fill-rule="evenodd"></path><path d="M 25.991 4.750 C 25.987 7.362, 25.689 11.944, 25.331 14.931 C 24.739 19.855, 24.579 20.136, 23.614 17.931 C 22.663 15.759, 22.515 16.058, 22.223 20.750 C 21.948 25.156, 21.585 26, 19.967 26 C 18.744 26, 17.809 25.086, 17.411 23.500 C 17.066 22.125, 16.157 21, 15.392 21 C 14.626 21, 14 20.518, 14 19.929 C 14 18.862, 11.573 16, 10.668 16 C 9.962 16, 8.874 25.705, 8.874 32 C 8.874 38.295, 9.962 48, 10.668 48 C 11.573 48, 14 45.138, 14 44.071 C 14 43.482, 14.626 43, 15.392 43 C 16.157 43, 17.066 41.875, 17.411 40.500 C 17.809 38.914, 18.744 38, 19.967 38 C 21.585 38, 21.948 38.844, 22.223 43.250 C 22.515 47.942, 22.663 48.241, 23.614 46.069 C 24.579 43.864, 24.739 44.145, 25.331 49.069 C 25.689 52.056, 25.987 56.638, 25.991 59.250 C 26.004 66.456, 27.704 64.933, 29.066 56.494 C 29.777 52.083, 31.044 48.102, 32.138 46.841 C 33.162 45.660, 34 44.088, 34 43.347 C 34 42.606, 34.420 42, 34.933 42 C 35.446 42, 36.151 41.101, 36.499 40.002 C 36.848 38.904, 38.341 37.717, 39.817 37.364 C 41.292 37.012, 43.057 36.286, 43.737 35.750 C 45.639 34.253, 48 35.666, 48 38.302 C 48 41.900, 48.969 42.139, 51.585 39.186 C 53.600 36.911, 54.117 36.729, 54.967 38 C 55.518 38.825, 55.976 41.413, 55.985 43.750 C 55.993 46.087, 56.257 48, 56.571 48 C 57.553 48, 60 45.196, 60 44.071 C 60 43.482, 60.626 43, 61.392 43 C 62.157 43, 63.066 41.875, 63.411 40.500 C 63.809 38.914, 64.744 38, 65.967 38 C 67.585 38, 67.948 38.844, 68.223 43.250 C 68.515 47.942, 68.663 48.241, 69.614 46.069 C 70.579 43.864, 70.739 44.145, 71.331 49.069 C 71.689 52.056, 71.987 56.638, 71.991 59.250 C 72.004 66.456, 73.704 64.933, 75.066 56.494 C 75.777 52.083, 77.044 48.102, 78.138 46.841 C 79.162 45.660, 80 44.088, 80 43.347 C 80 42.606, 80.420 42, 80.933 42 C 81.446 42, 82.151 41.101, 82.499 40.002 C 82.848 38.904, 84.341 37.717, 85.817 37.364 C 87.292 37.012, 89.057 36.286, 89.737 35.750 C 91.639 34.253, 94 35.666, 94 38.302 C 94 41.900, 94.969 42.139, 97.585 39.186 C 99.600 36.911, 100.117 36.729, 100.967 38 C 101.518 38.825, 101.976 41.413, 101.985 43.750 C 101.993 46.087, 102.257 48, 102.571 48 C 103.553 48, 106 45.196, 106 44.071 C 106 43.482, 106.626 43, 107.392 43 C 108.157 43, 109.066 41.875, 109.411 40.500 C 109.809 38.914, 110.744 38, 111.967 38 C 113.585 38, 113.948 38.844, 114.223 43.250 C 114.515 47.942, 114.663 48.241, 115.614 46.069 C 116.579 43.864, 116.739 44.145, 117.331 49.069 C 117.689 52.056, 117.987 56.638, 117.991 59.250 C 118.004 66.456, 119.704 64.933, 121.066 56.494 C 121.777 52.083, 123.044 48.102, 124.138 46.841 C 125.162 45.660, 126 44.088, 126 43.347 C 126 42.606, 126.420 42, 126.933 42 C 127.446 42, 128.151 41.101, 128.499 40.002 C 128.848 38.904, 130.341 37.717, 131.817 37.364 C 133.292 37.012, 135.057 36.286, 135.737 35.750 C 137.639 34.253, 140 35.666, 140 38.302 C 140 41.900, 140.969 42.139, 143.585 39.186 C 145.600 36.911, 146.117 36.729, 146.967 38 C 147.518 38.825, 147.976 41.413, 147.985 43.750 C 147.993 46.087, 148.257 48, 148.571 48 C 149.553 48, 152 45.196, 152 44.071 C 152 43.482, 152.626 43, 153.392 43 C 154.157 43, 155.066 41.875, 155.411 40.500 C 155.809 38.914, 156.744 38, 157.967 38 C 159.585 38, 159.948 38.844, 160.223 43.250 C 160.515 47.942, 160.663 48.241, 161.614 46.069 C 162.579 43.864, 162.739 44.145, 163.331 49.069 C 163.689 52.056, 163.987 56.638, 163.991 59.250 C 164.004 66.456, 165.704 64.933, 167.066 56.494 C 167.777 52.083, 169.044 48.102, 170.138 46.841 C 171.162 45.660, 172 44.088, 172 43.347 C 172 42.606, 172.420 42, 172.933 42 C 173.446 42, 174.151 41.101, 174.499 40.002 C 174.848 38.904, 176.341 37.717, 177.817 37.364 C 179.292 37.012, 181.057 36.286, 181.737 35.750 C 183.639 34.253, 186 35.666, 186 38.302 C 186 39.603, 186.261 40.928, 186.580 41.247 C 187.616 42.283, 194 34.326, 194 32 C 194 29.674, 187.616 21.717, 186.580 22.753 C 186.261 23.072, 186 24.397, 186 25.698 C 186 28.334, 183.639 29.747, 181.737 28.250 C 181.057 27.714, 179.292 26.988, 177.817 26.636 C 176.341 26.283, 174.848 25.096, 174.499 23.998 C 174.151 22.899, 173.446 22, 172.933 22 C 172.420 22, 172 21.394, 172 20.653 C 172 19.912, 171.162 18.340, 170.138 17.159 C 169.044 15.898, 167.777 11.917, 167.066 7.506 C 165.704 -0.933, 164.004 -2.456, 163.991 4.750 C 163.987 7.362, 163.689 11.944, 163.331 14.931 C 162.739 19.855, 162.579 20.136, 161.614 17.931 C 160.663 15.759, 160.515 16.058, 160.223 20.750 C 159.948 25.156, 159.585 26, 157.967 26 C 156.744 26, 155.809 25.086, 155.411 23.500 C 155.066 22.125, 154.157 21, 153.392 21 C 152.626 21, 152 20.518, 152 19.929 C 152 18.804, 149.553 16, 148.571 16 C 148.257 16, 147.993 17.913, 147.985 20.250 C 147.976 22.587, 147.518 25.175, 146.967 26 C 146.117 27.271, 145.600 27.089, 143.585 24.814 C 140.969 21.861, 140 22.100, 140 25.698 C 140 28.334, 137.639 29.747, 135.737 28.250 C 135.057 27.714, 133.292 26.988, 131.817 26.636 C 130.341 26.283, 128.848 25.096, 128.499 23.998 C 128.151 22.899, 127.446 22, 126.933 22 C 126.420 22, 126 21.394, 126 20.653 C 126 19.912, 125.162 18.340, 124.138 17.159 C 123.044 15.898, 121.777 11.917, 121.066 7.506 C 119.704 -0.933, 118.004 -2.456, 117.991 4.750 C 117.987 7.362, 117.689 11.944, 117.331 14.931 C 116.739 19.855, 116.579 20.136, 115.614 17.931 C 114.663 15.759, 114.515 16.058, 114.223 20.750 C 113.948 25.156, 113.585 26, 111.967 26 C 110.744 26, 109.809 25.086, 109.411 23.500 C 109.066 22.125, 108.157 21, 107.392 21 C 106.626 21, 106 20.518, 106 19.929 C 106 18.804, 103.553 16, 102.571 16 C 102.257 16, 101.993 17.913, 101.985 20.250 C 101.976 22.587, 101.518 25.175, 100.967 26 C 100.117 27.271, 99.600 27.089, 97.585 24.814 C 94.969 21.861, 94 22.100, 94 25.698 C 94 28.334, 91.639 29.747, 89.737 28.250 C 89.057 27.714, 87.292 26.988, 85.817 26.636 C 84.341 26.283, 82.848 25.096, 82.499 23.998 C 82.151 22.899, 81.446 22, 80.933 22 C 80.420 22, 80 21.394, 80 20.653 C 80 19.912, 79.162 18.340, 78.138 17.159 C 77.044 15.898, 75.777 11.917, 75.066 7.506 C 73.704 -0.933, 72.004 -2.456, 71.991 4.750 C 71.987 7.362, 71.689 11.944, 71.331 14.931 C 70.739 19.855, 70.579 20.136, 69.614 17.931 C 68.663 15.759, 68.515 16.058, 68.223 20.750 C 67.948 25.156, 67.585 26, 65.967 26 C 64.744 26, 63.809 25.086, 63.411 23.500 C 63.066 22.125, 62.157 21, 61.392 21 C 60.626 21, 60 20.518, 60 19.929 C 60 18.804, 57.553 16, 56.571 16 C 56.257 16, 55.993 17.913, 55.985 20.250 C 55.976 22.587, 55.518 25.175, 54.967 26 C 54.117 27.271, 53.600 27.089, 51.585 24.814 C 48.969 21.861, 48 22.100, 48 25.698 C 48 28.334, 45.639 29.747, 43.737 28.250 C 43.057 27.714, 41.292 26.988, 39.817 26.636 C 38.341 26.283, 36.848 25.096, 36.499 23.998 C 36.151 22.899, 35.446 22, 34.933 22 C 34.420 22, 34 21.394, 34 20.653 C 34 19.912, 33.162 18.340, 32.138 17.159 C 31.044 15.898, 29.777 11.917, 29.066 7.506 C 27.704 -0.933, 26.004 -2.456, 25.991 4.750" stroke="none" fill="#242424" fill-rule="evenodd"></path></svg>
                    <svg class="play-bar" xmlns="http://www.w3.org/2000/svg" width="202" height="64" viewBox="0 0 202 64" version="1.1"><path d="" stroke="#1a66c9" fill="#1a66c9" fill-rule="evenodd"></path><path d="M 25.991 4.750 C 25.987 7.362, 25.689 11.944, 25.331 14.931 C 24.739 19.855, 24.579 20.136, 23.614 17.931 C 22.663 15.759, 22.515 16.058, 22.223 20.750 C 21.948 25.156, 21.585 26, 19.967 26 C 18.744 26, 17.809 25.086, 17.411 23.500 C 17.066 22.125, 16.157 21, 15.392 21 C 14.626 21, 14 20.518, 14 19.929 C 14 18.862, 11.573 16, 10.668 16 C 9.962 16, 8.874 25.705, 8.874 32 C 8.874 38.295, 9.962 48, 10.668 48 C 11.573 48, 14 45.138, 14 44.071 C 14 43.482, 14.626 43, 15.392 43 C 16.157 43, 17.066 41.875, 17.411 40.500 C 17.809 38.914, 18.744 38, 19.967 38 C 21.585 38, 21.948 38.844, 22.223 43.250 C 22.515 47.942, 22.663 48.241, 23.614 46.069 C 24.579 43.864, 24.739 44.145, 25.331 49.069 C 25.689 52.056, 25.987 56.638, 25.991 59.250 C 26.004 66.456, 27.704 64.933, 29.066 56.494 C 29.777 52.083, 31.044 48.102, 32.138 46.841 C 33.162 45.660, 34 44.088, 34 43.347 C 34 42.606, 34.420 42, 34.933 42 C 35.446 42, 36.151 41.101, 36.499 40.002 C 36.848 38.904, 38.341 37.717, 39.817 37.364 C 41.292 37.012, 43.057 36.286, 43.737 35.750 C 45.639 34.253, 48 35.666, 48 38.302 C 48 41.900, 48.969 42.139, 51.585 39.186 C 53.600 36.911, 54.117 36.729, 54.967 38 C 55.518 38.825, 55.976 41.413, 55.985 43.750 C 55.993 46.087, 56.257 48, 56.571 48 C 57.553 48, 60 45.196, 60 44.071 C 60 43.482, 60.626 43, 61.392 43 C 62.157 43, 63.066 41.875, 63.411 40.500 C 63.809 38.914, 64.744 38, 65.967 38 C 67.585 38, 67.948 38.844, 68.223 43.250 C 68.515 47.942, 68.663 48.241, 69.614 46.069 C 70.579 43.864, 70.739 44.145, 71.331 49.069 C 71.689 52.056, 71.987 56.638, 71.991 59.250 C 72.004 66.456, 73.704 64.933, 75.066 56.494 C 75.777 52.083, 77.044 48.102, 78.138 46.841 C 79.162 45.660, 80 44.088, 80 43.347 C 80 42.606, 80.420 42, 80.933 42 C 81.446 42, 82.151 41.101, 82.499 40.002 C 82.848 38.904, 84.341 37.717, 85.817 37.364 C 87.292 37.012, 89.057 36.286, 89.737 35.750 C 91.639 34.253, 94 35.666, 94 38.302 C 94 41.900, 94.969 42.139, 97.585 39.186 C 99.600 36.911, 100.117 36.729, 100.967 38 C 101.518 38.825, 101.976 41.413, 101.985 43.750 C 101.993 46.087, 102.257 48, 102.571 48 C 103.553 48, 106 45.196, 106 44.071 C 106 43.482, 106.626 43, 107.392 43 C 108.157 43, 109.066 41.875, 109.411 40.500 C 109.809 38.914, 110.744 38, 111.967 38 C 113.585 38, 113.948 38.844, 114.223 43.250 C 114.515 47.942, 114.663 48.241, 115.614 46.069 C 116.579 43.864, 116.739 44.145, 117.331 49.069 C 117.689 52.056, 117.987 56.638, 117.991 59.250 C 118.004 66.456, 119.704 64.933, 121.066 56.494 C 121.777 52.083, 123.044 48.102, 124.138 46.841 C 125.162 45.660, 126 44.088, 126 43.347 C 126 42.606, 126.420 42, 126.933 42 C 127.446 42, 128.151 41.101, 128.499 40.002 C 128.848 38.904, 130.341 37.717, 131.817 37.364 C 133.292 37.012, 135.057 36.286, 135.737 35.750 C 137.639 34.253, 140 35.666, 140 38.302 C 140 41.900, 140.969 42.139, 143.585 39.186 C 145.600 36.911, 146.117 36.729, 146.967 38 C 147.518 38.825, 147.976 41.413, 147.985 43.750 C 147.993 46.087, 148.257 48, 148.571 48 C 149.553 48, 152 45.196, 152 44.071 C 152 43.482, 152.626 43, 153.392 43 C 154.157 43, 155.066 41.875, 155.411 40.500 C 155.809 38.914, 156.744 38, 157.967 38 C 159.585 38, 159.948 38.844, 160.223 43.250 C 160.515 47.942, 160.663 48.241, 161.614 46.069 C 162.579 43.864, 162.739 44.145, 163.331 49.069 C 163.689 52.056, 163.987 56.638, 163.991 59.250 C 164.004 66.456, 165.704 64.933, 167.066 56.494 C 167.777 52.083, 169.044 48.102, 170.138 46.841 C 171.162 45.660, 172 44.088, 172 43.347 C 172 42.606, 172.420 42, 172.933 42 C 173.446 42, 174.151 41.101, 174.499 40.002 C 174.848 38.904, 176.341 37.717, 177.817 37.364 C 179.292 37.012, 181.057 36.286, 181.737 35.750 C 183.639 34.253, 186 35.666, 186 38.302 C 186 39.603, 186.261 40.928, 186.580 41.247 C 187.616 42.283, 194 34.326, 194 32 C 194 29.674, 187.616 21.717, 186.580 22.753 C 186.261 23.072, 186 24.397, 186 25.698 C 186 28.334, 183.639 29.747, 181.737 28.250 C 181.057 27.714, 179.292 26.988, 177.817 26.636 C 176.341 26.283, 174.848 25.096, 174.499 23.998 C 174.151 22.899, 173.446 22, 172.933 22 C 172.420 22, 172 21.394, 172 20.653 C 172 19.912, 171.162 18.340, 170.138 17.159 C 169.044 15.898, 167.777 11.917, 167.066 7.506 C 165.704 -0.933, 164.004 -2.456, 163.991 4.750 C 163.987 7.362, 163.689 11.944, 163.331 14.931 C 162.739 19.855, 162.579 20.136, 161.614 17.931 C 160.663 15.759, 160.515 16.058, 160.223 20.750 C 159.948 25.156, 159.585 26, 157.967 26 C 156.744 26, 155.809 25.086, 155.411 23.500 C 155.066 22.125, 154.157 21, 153.392 21 C 152.626 21, 152 20.518, 152 19.929 C 152 18.804, 149.553 16, 148.571 16 C 148.257 16, 147.993 17.913, 147.985 20.250 C 147.976 22.587, 147.518 25.175, 146.967 26 C 146.117 27.271, 145.600 27.089, 143.585 24.814 C 140.969 21.861, 140 22.100, 140 25.698 C 140 28.334, 137.639 29.747, 135.737 28.250 C 135.057 27.714, 133.292 26.988, 131.817 26.636 C 130.341 26.283, 128.848 25.096, 128.499 23.998 C 128.151 22.899, 127.446 22, 126.933 22 C 126.420 22, 126 21.394, 126 20.653 C 126 19.912, 125.162 18.340, 124.138 17.159 C 123.044 15.898, 121.777 11.917, 121.066 7.506 C 119.704 -0.933, 118.004 -2.456, 117.991 4.750 C 117.987 7.362, 117.689 11.944, 117.331 14.931 C 116.739 19.855, 116.579 20.136, 115.614 17.931 C 114.663 15.759, 114.515 16.058, 114.223 20.750 C 113.948 25.156, 113.585 26, 111.967 26 C 110.744 26, 109.809 25.086, 109.411 23.500 C 109.066 22.125, 108.157 21, 107.392 21 C 106.626 21, 106 20.518, 106 19.929 C 106 18.804, 103.553 16, 102.571 16 C 102.257 16, 101.993 17.913, 101.985 20.250 C 101.976 22.587, 101.518 25.175, 100.967 26 C 100.117 27.271, 99.600 27.089, 97.585 24.814 C 94.969 21.861, 94 22.100, 94 25.698 C 94 28.334, 91.639 29.747, 89.737 28.250 C 89.057 27.714, 87.292 26.988, 85.817 26.636 C 84.341 26.283, 82.848 25.096, 82.499 23.998 C 82.151 22.899, 81.446 22, 80.933 22 C 80.420 22, 80 21.394, 80 20.653 C 80 19.912, 79.162 18.340, 78.138 17.159 C 77.044 15.898, 75.777 11.917, 75.066 7.506 C 73.704 -0.933, 72.004 -2.456, 71.991 4.750 C 71.987 7.362, 71.689 11.944, 71.331 14.931 C 70.739 19.855, 70.579 20.136, 69.614 17.931 C 68.663 15.759, 68.515 16.058, 68.223 20.750 C 67.948 25.156, 67.585 26, 65.967 26 C 64.744 26, 63.809 25.086, 63.411 23.500 C 63.066 22.125, 62.157 21, 61.392 21 C 60.626 21, 60 20.518, 60 19.929 C 60 18.804, 57.553 16, 56.571 16 C 56.257 16, 55.993 17.913, 55.985 20.250 C 55.976 22.587, 55.518 25.175, 54.967 26 C 54.117 27.271, 53.600 27.089, 51.585 24.814 C 48.969 21.861, 48 22.100, 48 25.698 C 48 28.334, 45.639 29.747, 43.737 28.250 C 43.057 27.714, 41.292 26.988, 39.817 26.636 C 38.341 26.283, 36.848 25.096, 36.499 23.998 C 36.151 22.899, 35.446 22, 34.933 22 C 34.420 22, 34 21.394, 34 20.653 C 34 19.912, 33.162 18.340, 32.138 17.159 C 31.044 15.898, 29.777 11.917, 29.066 7.506 C 27.704 -0.933, 26.004 -2.456, 25.991 4.750" stroke="none" fill="#1a66c9" fill-rule="evenodd"></path></svg>
                </div>
            </div>
            <div class="col-xl-1 col-md-2 col-4">
                <div class="audio-temp  text-white text-md-center"><span class="d-md-none">Tempor: </span>
                    ' . get_post_meta(get_the_ID(), 'tempo', true) . '
                </div>
            </div>
            <div class="col-xl-1 col-md-2 col-8">
                <div class="audio-temp text-white text-end text-md-center"><span class="d-md-none">Key: </span>
                    ' . get_post_meta(get_the_ID(), 'key', true) . '
                </div>
            </div>
            <div class="col-xl-1 col-md-2">
                <div class="audio-temp text-white text-md-end text-xl-center"><span class="d-md-none">Library: </span>
                    ' . get_post_meta(get_the_ID(), 'library', true) . '
                </div>
            </div>
            <div class="col-xl-2 col-md-8">
                <div class="text-white text-lg-wrap text-xl-wrap"><span class="d-xl-none">Tags: </span>'
                . implode(', ', $tag_list) . '
                </div>
            </div>
            <div class="col-xl-2 col-md-4">
                <div class="icons text-md-end text-xl-center">
                    <div class="inner-icons mx-auto" style="display: inline-flex">
                        <div class="btn favorite-btn px-3 pt-3 pb-0 pb-md-3" data-post-id="' . get_the_ID() . '" data-favorite="' .( in_array( get_the_ID(), $favorite_musics)) . '">
                        '. $favorite_btn .'
                        </div>
                        <div class="btn download-btn px-0 pt-3 pb-0 pb-md-3" data-music-id="' . get_the_ID() . '" data-file-url="' . $file_path . '" data-download-count="'. get_user_meta($user_id, 'download_count_' . get_the_ID() , true) . '" data-credit-balance="'. get_user_meta($user_id, 'credit_balance', true) .'">                               
                            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="22" viewBox="0 0 23 22" fill="none">
                                <path d="M11.5 12V21M11.5 21L15 17.5M11.5 21L8 17.5" stroke="#F8F8F8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M19.1364 17C20.5622 16.4001 22 15.0333 22 12.2768C22 8.17613 18.8182 7.15097 17.2273 7.15097C17.2273 5.10065 17.2273 1 11.5 1C5.77273 1 5.77273 5.10065 5.77273 7.15097C4.18181 7.15097 1 8.17613 1 12.2768C1 15.0333 2.43781 16.4001 3.86364 17" stroke="#F8F8F8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>';
        }

    } else {
        echo '<div class="audio-bg mt-3 text-white text-center">There is no music to show</div>';
    }
    wp_reset_postdata();
    wp_die();
}

add_action('wp_ajax_filter_products', 'filter_products');
add_action('wp_ajax_nopriv_filter_products', 'filter_products');


function child_enqueue_styles()
{
    wp_enqueue_style('astra-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all');

    // FOldable Table.
    // wp_register_style('foldtable-style', get_stylesheet_directory_uri() . '/foldtable-style.css',  CHILD_THEME_ASTRA_CHILD_VERSION, 'all');
    wp_register_script('foldtable-script', get_stylesheet_directory_uri() . '/foldtable-script.js', array('jquery'), CHILD_THEME_ASTRA_CHILD_VERSION, true);


}
// add_action('wp_enqueue_scripts', 'child_enqueue_styles', 15);


// Register Custom Post Type Music
function custom_post_type_music()
{
    $labels = array(
        'name' => _x('Music', 'Post Type General Name', 'text_domain'),
        'singular_name' => _x('Music', 'Post Type Singular Name', 'text_domain'),
        'menu_name' => __('Music', 'text_domain'),
        'name_admin_bar' => __('Music', 'text_domain'),
        'archives' => __('Music Archives', 'text_domain'),
        'attributes' => __('Music Attributes', 'text_domain'),
        'parent_item_colon' => __('Parent Music:', 'text_domain'),
        'all_items' => __('All Music', 'text_domain'),
        'add_new_item' => __('Add New Music', 'text_domain'),
        'add_new' => __('Add New', 'text_domain'),
        'new_item' => __('New Music', 'text_domain'),
        'edit_item' => __('Edit Music', 'text_domain'),
        'update_item' => __('Update Music', 'text_domain'),
        'view_item' => __('View Music', 'text_domain'),
        'view_items' => __('View Music', 'text_domain'),
        'search_items' => __('Search Music', 'text_domain'),
        'not_found' => __('Not found', 'text_domain'),
        'not_found_in_trash' => __('Not found in Trash', 'text_domain'),
        'featured_image' => __('Featured Image', 'text_domain'),
        'set_featured_image' => __('Set featured image', 'text_domain'),
        'remove_featured_image' => __('Remove featured image', 'text_domain'),
        'use_featured_image' => __('Use as featured image', 'text_domain'),
        'insert_into_item' => __('Insert into Music', 'text_domain'),
        'uploaded_to_this_item' => __('Uploaded to this Music', 'text_domain'),
        'items_list' => __('Music list', 'text_domain'),
        'items_list_navigation' => __('Music list navigation', 'text_domain'),
        'filter_items_list' => __('Filter Music list', 'text_domain'),
    );
    $args = array(
        'label' => __('Music', 'text_domain'),
        'description' => __('Music', 'text_domain'),
        'labels' => $labels,
        'supports' => array('title'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-format-audio',
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => false,
        // Disable single pages for Music
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
    );
    register_post_type('music', $args);
}
add_action('init', 'custom_post_type_music', 0);

// Register Custom Taxonomy Music Categories
function custom_taxonomy_music_categories()
{
    $labels = array(
        'name' => _x('Music Categories', 'Taxonomy General Name', 'text_domain'),
        'singular_name' => _x('Music Category', 'Taxonomy Singular Name', 'text_domain'),
        'menu_name' => __('Music Categories', 'text_domain'),
        'all_items' => __('All Categories', 'text_domain'),
        'parent_item' => __('Parent Category', 'text_domain'),
        'parent_item_colon' => __('Parent Category:', 'text_domain'),
        'new_item_name' => __('New Category Name', 'text_domain'),
        'add_new_item' => __('Add New Category', 'text_domain'),
        'edit_item' => __('Edit Category', 'text_domain'),
        'update_item' => __('Update Category', 'text_domain'),
        'view_item' => __('View Category', 'text_domain'),
        'separate_items_with_commas' => __('Separate categories with commas', 'text_domain'),
        'add_or_remove_items' => __('Add or remove categories', 'text_domain'),
        'choose_from_most_used' => __('Choose from the most used', 'text_domain'),
        'popular_items' => __('Popular Categories', 'text_domain'),
        'search_items' => __('Search Categories', 'text_domain'),
        'not_found' => __('Not Found', 'text_domain'),
        'no_terms' => __('No categories', 'text_domain'),
        'items_list' => __('Categories list', 'text_domain'),
        'items_list_navigation' => __('Categories list navigation', 'text_domain'),
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
        'show_in_quick_edit' => true,
        'rewrite' => false,
        // Disable archive pages for Music Categories
    );
    register_taxonomy('music_category', array('music'), $args);
}
add_action('init', 'custom_taxonomy_music_categories', 0);

// Register Custom Taxonomy Music Tags
function custom_taxonomy_music_tags()
{
    $labels = array(
        'name' => _x('Music Tags', 'Taxonomy General Name', 'text_domain'),
        'singular_name' => _x('Music Tag', 'Taxonomy Singular Name', 'text_domain'),
        'menu_name' => __('Music Tags', 'text_domain'),
        'all_items' => __('All Tags', 'text_domain'),
        'parent_item' => __('Parent Tag', 'text_domain'),
        'parent_item_colon' => __('Parent Tag:', 'text_domain'),
        'new_item_name' => __('New Tag Name', 'text_domain'),
        'add_new_item' => __('Add New Tag', 'text_domain'),
        'edit_item' => __('Edit Tag', 'text_domain'),
        'update_item' => __('Update Tag', 'text_domain'),
        'view_item' => __('View Tag', 'text_domain'),
        'separate_items_with_commas' => __('Separate tags with commas', 'text_domain'),
        'add_or_remove_items' => __('Add or remove tags', 'text_domain'),
        'choose_from_most_used' => __('Choose from the most used', 'text_domain'),
        'popular_items' => __('Popular Tags', 'text_domain'),
        'search_items' => __('Search Tags', 'text_domain'),
        'not_found' => __('Not Found', 'text_domain'),
        'no_terms' => __('No tags', 'text_domain'),
        'items_list' => __('Tags list', 'text_domain'),
        'items_list_navigation' => __('Tags list navigation', 'text_domain'),
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
    );
    register_taxonomy('music_tags', array('music'), $args);
}
add_action('init', 'custom_taxonomy_music_tags', 0);