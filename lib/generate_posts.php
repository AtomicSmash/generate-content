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

}
