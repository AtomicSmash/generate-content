<?php

/**
 * Genetate some fake content for ACF flexible content fields
 */
class Generate_Posts {

    public function create_post( $post_type = 'post' ){

        $faker = Faker\Factory::create();

        $post_id = wp_insert_post(array (
            'post_type' => $post_type,
            'post_title' => $faker->word()." ".$faker->word()." ".$faker->word()." ".$faker->word(),
            // 'post_content' => $your_content,
            'post_status' => 'publish',
        ));

        //ASTODO add post_id to global post array for later deletion
        return $post_id;

    }

    public function add_to_post_registry( $post_id ){

        $generated_posts = get_option( 'generated_posts' );

        $generated_posts[] = $post_id;

        update_option( 'generated_posts', $generated_posts );

        return $generated_posts;

    }


    private function get_post_types($echo = false){

        $args = array(
           'public'   => true,
        );

        foreach ( get_post_types( $args, 'names' ) as $post_type ) {
            // echo "- ".$post_type . "\n";
            if($echo == true){
                echo "- ".$post_type . "\n";
            }
            $post_types[] = $post_type;
        }

        return $post_types;

    }

    private function build_random_html_array(){

        $html = array();

        for ($i = 0; $i < 10; $i++) {
            $html[$i] = file_get_contents('http://loripsum.net/api/4/medium/headers/ul/link/ol/bq/decorate/');
        }

        return $html;

    }

    private function grab_random_html(){

        $html = file_get_contents('http://loripsum.net/api/4/medium/headers/ul/link/ol/bq/decorate/');

        return $html;

    }

    private function download_random_image($faker){

        $image_url = $faker->imageUrl(rand('800','900'), rand('300','700'), 'cats');

        $upload_dir = wp_upload_dir();

        $image_data = file_get_contents($image_url);

        //  $filename = basename($image_url);
        $filename = $faker->Uuid().'.jpg';

        if (wp_mkdir_p($upload_dir['path']))
        $file = $upload_dir['path'] . '/' . $filename;
        else
        $file = $upload_dir['basedir'] . '/' . $filename;

        file_put_contents($file, $image_data);

        $wp_filetype = wp_check_filetype($filename, null);


        // $file = '/path/to/file.png';
        // $filename = basename($file);
        $upload_file = wp_upload_bits($filename, null, file_get_contents($file));
        if (!$upload_file['error']) {
            $wp_filetype = wp_check_filetype($filename, null );
            $attachment = array(
                'post_mime_type' => $wp_filetype['type'],
                'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
                'post_content' => '',
                'post_status' => 'inherit'
            );
            $attachment_id = wp_insert_attachment( $attachment, $upload_file['file'], 0 );
            if (!is_wp_error($attachment_id)) {
                require_once(ABSPATH . "wp-admin" . '/includes/image.php');
                $attachment_data = wp_generate_attachment_metadata( $attachment_id, $upload_file['file'] );
                wp_update_attachment_metadata( $attachment_id,  $attachment_data );
            }
        }

        return $attachment_id;

    }

}
