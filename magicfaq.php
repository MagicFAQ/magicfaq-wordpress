<?php
   /*
    Plugin Name: Magic FAQs
    Plugin URI: 
    Description: 
    Version: 
    Author: 
    Author URI: 
    License: 
   */


function files_scripts() //load js and css TODO: rewrite to remove registers
{
    wp_enqueue_script('jquery');
    wp_register_script( 'javascript', plugins_url( '/js/functions.js', __FILE__ ) );
    wp_enqueue_script( 'javascript' );
    wp_register_style( 'style', plugins_url( '/css/style.css', __FILE__ ) );
    wp_enqueue_style( 'style' );
}
add_action( 'wp_enqueue_scripts', 'files_scripts' ); //note no equivalent wp_enqueue_styles -- use scripts for css



function your_function() {
    include 'includes/markup.php';
}
add_action('wp_meta', 'your_function');







/*



    //Hooks a function to a filter action, 'the_content' being the action, 'hello_world' the function.
    add_filter('the_content','hello_world');

    //Callback function
        function hello_world($content)
    {
    //Checking if on post page.
        if ( is_single() ) {
    //Adding custom content to end of post.
        return $content . "<h1> Hello Mars </h1>";
        }
        else {
    //else on blog page / home page etc, just return content as usual.
        return $content;
        }
    }
*/
?>