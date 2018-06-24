<?php

/**
 * Genetate some fake content for ACF flexible content fields
 */
class Generate_Cli extends \WP_CLI_Command {

    function posts( $content_type = null ){

        if( isset($content_type[0]) ){

            $post_types = $this->get_post_types();

            if(in_array($content_type[0], $post_types)){

                $post_id = $this->create_post($content_type[0]);

                $fields = $this->find_field_groups_and_generate( $post_id );

            }

        }else{

            echo "Please provide a content type as the last argument, for example: 'wp generate-a-tron generate page':\n";

            $this->get_post_types(true);

        }
    }

    private function create_post( $post_type = 'post' ){

        $faker = Faker\Factory::create();

        $post_id = wp_insert_post(array (
            'post_type' => $post_type,
            'post_title' => $faker->word()." ".$faker->word()." ".$faker->word()." ".$faker->word(),
            // 'post_content' => $your_content,
            'post_status' => 'publish',
        ));

        //ASTODO add post_id to global post array for later deletion
        return $post_id;

        // return 8;
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

    private function find_field_groups_and_generate( $post_id = 0 ){

        $this->faker = Faker\Factory::create();

        $available_fields = array();

        // $test = get_field('field_54ae9bad435f9',5);
        //
        // echo "<pre>";
        // print_r($test);
        // echo "</pre>";
        //
        // $value[] = array("field_54aea320c8f4f" => 'content', "acf_fc_layout" => "content_blocks__wysiwyg");
        //
        // echo "<pre>";
        // print_r($value);
        // echo "</pre>";
        //
        // update_field( 'field_54ae9bad435f9', $value, 5 );



        $html_array = $this->build_random_html_array();

        // echo "<pre>";
        // print_r($html_array);
        // echo "</pre>";

        // die();

        $groups = acf_get_field_groups( array( 'post_id' => $post_id ) );


        // echo "<pre>";
        // print_r($groups);
        // echo "</pre>";



        foreach( $groups as $group ){



            // Way of generating fake HTML
            // $document = new \DOMDocument();
            // // $this->idGenerator = new UniqueGenerator($this->generator);
            //
            // $head = $document->createElement("head");
            // $body = $document->createElement("body");
            // $node = $document->createElement("p");
            //
            // $document->appendChild($node);
            //
            // $text = $document->createTextNode('asdhaskjdhaskdjhask akjsdh akdjhas kdjhask');
            // $link = $document->createElement('a');
            // $link->setAttribute("href", 'example-link');
            // $link->appendChild($text);
            // $node->appendChild($link);
            //
            //
            // echo $document->saveHTML();




            // die();

            $fields = acf_get_fields( $group );

            $supported_field_types = array('email', 'text', 'textarea', 'repeater', 'flexible_content', 'qtranslate_file', 'qtranslate_image', 'qtranslate_text', 'qtranslate_textarea', 'qtranslate_wysiwyg');

            $supported_field_ids = array('field_54ae9bad435f9');

            foreach( $fields as $field ) {
                //


                // if (in_array($field['type'], $supported_field_types)) {
                // if (in_array($field['key'], $supported_field_ids)) {

                    if( $field['type'] == 'flexible_content' ){

                        foreach ($field['layouts'] as $layout) {

                            foreach ($layout['sub_fields'] as $key => $sub_field) {

                                // echo "<pre>";
                                // print_r($sub_field['label']."\n");
                                // echo "</pre>";



                                if($sub_field['label'] == 'WYSIWYG'){
                                    // $available_fields = array(
                                    //     array($sub_field['key'] => $html_array[2], "acf_fc_layout" => $layout['name'])
                                    // );
                                }

                                if($sub_field['label'] == 'Full width image'){

                                    // echo "<pre>";
                                    // print_r($sub_field);
                                    // echo "</pre>";

                                    // echo $faker->paragraph(40);


                                    // echo $faker->imageUrl(800, 400, 'cats');


                                    $new_media_id = $this->download_random_image($faker);




                                    //
                                    // echo "<pre>";
                                    // print_r($wp_filetype);
                                    // echo "</pre>";
                                    // echo "\n";
                                    // echo "<pre>";
                                    // print_r($file);
                                    // echo "</pre>";
                                    // echo "\n";
                                    // echo "<pre>";
                                    // print_r($filename);
                                    // echo "</pre>";



                                    //  $attachment = array(
                                    //  'post_mime_type' => $wp_filetype['type'],
                                    //  'post_title' => sanitize_file_name($filename),
                                    //  'post_content' => '',
                                    //  'post_status' => 'inherit'
                                    //  );

                                    //  require_once(ABSPATH . 'wp-admin/includes/image.php');
                                    //  $attach_data = wp_generate_attachment_metadata($attach_id, $file);
                                    //  wp_update_attachment_metadata($attach_id, $attach_data);




                                    $available_fields = array(
                                        array($sub_field['key'] => $new_media_id, "acf_fc_layout" => $layout['name'])
                                    );

                                }



                            }
                        }

                    }else{

                        // echo "<pre>";
                        // print_r();
                        // echo "</pre>";

                        $this->generate_content_for_field( $post_id, $field );

                    }
                    // echo "<pre>";
                    // print_r($available_fields);
                    // echo "</pre>";




                // }
            }
        };

        return $available_fields;

    }

    // This might be useful in the future, but moved the content generation to inside
    // find_field_groups_and_generate() function
    // private function generate_content_for_fields( $available_fields ){
    //
    //     foreach ($available_fields as $key => $available_field) {
    //
    //         echo "<pre>";
    //         print_r($available_field);
    //         echo "</pre>";
    //
    //         echo $key;
    //
    //     }
    // }




}
