<?php

/**
 * Genetate some fake content for ACF flexible content fields
 */
class Generate_Fields {

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


    public function generate_content_for_field( $post_id = 0, $field = array() ){

        $this->faker = Faker\Factory::create();

        //ASTODO turn this into a switch
        // Generate a sentence for a text area
        if( $field['type'] == 'text' ){
            update_field( $field['key'], $this->faker->sentence( 6, true ), $post_id );
            return true;
        }

        if( $field['type'] == 'url' ){
            update_field( $field['key'], $this->faker->domainName(), $post_id );
            return true;
        }

        if( $field['type'] == 'range' ){

            // ACF default range values are 0 to 100
            $min = 0;
            $max = 100;

            // If feild is saved with default value ['min'] and ['max'] will be blank
            if( $field['min'] != "" ){
                $min = $field['min'];
            }
            if( $field['max'] != "" ){
                $max = $field['max'];
            }

            update_field( $field['key'], $this->faker->numberBetween( $min, $max ), $post_id );
            return true;
        }

        if( $field['type'] == 'email' ){
            update_field( $field['key'], $this->faker->email(), $post_id );
            return true;
        }

        if( $field['type'] == 'password' ){
            update_field( $field['key'], $this->faker->password(), $post_id );
            return true;
        }
    }

}
