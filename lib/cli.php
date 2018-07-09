<?php

/**
 * Genetate some fake content for ACF flexible content fields
 */
class Generate_Cli extends \WP_CLI_Command {

    function posts( $content_type = null ){


        $generate_post = new Generate_Posts();

        if( isset($content_type[0]) ){

            $post_types = $this->get_post_types();

            if(in_array($content_type[0], $post_types)){

                $post_id = $generate_post->create_post( $content_type[0] );

                $generated_posts = $generate_post->add_to_post_registry( $post_id );

                $fields = $this->add_content_to_custom_fields( $post_id );

                WP_CLI::success( "Added '" . $content_type[0] . "' with ID: " . $post_id );

            }

        }else{


            WP_CLI::warning( "Please provide a content type as the last argument, for example: 'wp generate-a-tron generate page':" );

            $this->get_post_types( true );

        }
    }

    //ASTOD Move this to the generate_posts.php file or visa versa
    private function get_post_types( $echo = false ){

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

    private function add_content_to_custom_fields( $post_id = 0 ){

        $this->faker = Faker\Factory::create();

        $generate_fields = new Generate_Fields();

        // $available_fields = array();

        // $html_array = $this->build_random_html_array();

        if( function_exists( 'acf_get_field_groups' )){

            $groups = acf_get_field_groups( array( 'post_id' => $post_id ) );

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

                // $supported_field_types = array('email', 'text', 'textarea', 'repeater', 'flexible_content', 'qtranslate_file', 'qtranslate_image', 'qtranslate_text', 'qtranslate_textarea', 'qtranslate_wysiwyg');
                //
                // $supported_field_ids = array('field_54ae9bad435f9');

                foreach( $fields as $field ) {


                    if( $field['type'] == 'flexible_content' ){

                        // echo "<pre>";
                        // print_r($field);
                        // echo "</pre>";


                        //ASTODO check layouts are available before entering for each
                        foreach ($field['layouts'] as $layout) {

                            // echo "<pre>";
                            // print_r($layout);
                            // echo "</pre>";


                            $value = array(
                                array(
                                    'content_blocks__wysiwyg__wysiwyg' => 'asdasdasd',
                                    'acf_fc_layout' => 'content_blocks__wysiwyg'
                                )
                            );

                            // update_field( $field['key'], $value, $post_id );



                            foreach ($layout['sub_fields'] as $key => $sub_field) {

                                // echo "<pre>";
                                // print_r($sub_field['label']."\n");
                                // echo "</pre>";

                                // $generate_fields->generate_content_for_field( $post_id, $field );



                                if($sub_field['label'] == 'Full width image'){

                                    // echo "<pre>";
                                    // print_r($sub_field);
                                    // echo "</pre>";

                                    // echo $faker->paragraph(40);


                                    // echo $faker->imageUrl(800, 400, 'cats');


                                    // $new_media_id = $this->download_random_image( $this->faker );




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




                                    // $available_fields = array(
                                        // array($sub_field['key'] => $new_media_id, "acf_fc_layout" => $layout['name'])
                                    // );

                                }



                            }
                        }



                    }else{


                        $generate_fields->generate_content_for_field( $post_id, $field );

                    }
                }
            }
        }

        return true;

    }


}
