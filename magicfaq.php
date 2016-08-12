<?php
/**
*     Plugin Name: Magic FAQs
*     Plugin URI:
*     Description:
*     Version:
*     Author:
*     Author URI:
*     License:
*/

/**
 * Adds Foo_Widget widget.
 */
class Foo_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
            'foo_widget', // Base ID
            __( 'MagicFAQ', 'text_domain' ), // Name
            array( 'description' => __( 'Allow visitors to ask questions of your MagicFAQ system.', 'text_domain' ), ) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }
        //echo __( esc_attr( 'Hello, World!' ), 'text_domain' );
        ?>

<form id="magicfaq-ask" data-base-api-path="<?php echo __( esc_attr( $instance['baseAPIPath']), 'text_domain' ); ?>" onsubmit="magicfaq.askQuestion($('#magicfaq-question').val()); return false;">
<input id="magicfaq-question" style=width:250px type=text name=question /> <input style=margin-left:10px type=submit value="Ask!" />
</form>
<div id="magicfaq-answers-container" style="opacity:0;min-height:100px;">

<h3 class="magicfaq-subtitle default-questions" style="display:none"><?php echo __( esc_attr( $instance['defaultQuestionsTitle']), 'text_domain' ); ?></h3>
<h3 class="magicfaq-subtitle results" style="display:none"><?php echo __( esc_attr( $instance['resultsTitle']), 'text_domain' ); ?></h3>
<h3 class="magicfaq-subtitle not-found" style="display:none"><?php echo __( esc_attr( $instance['notFoundTitle']), 'text_domain' ); ?></h3>
<ul class="magicfaq">
<li class="magicfaq closed"><a class="magicfaq-question" href="#" onclick="return false;">How do I buy transcripts?</a>
<div class="magicfaq-answer">
<p>Answer paragraph.</p>
<span id="magicfaq-helpful"><p style="display:inline-block;float:left">Helpful? </p><p style="display:inline-block;float:right"><a href="#">Yes</a> - <a href="#">Sort of</a> - <a href="#">No</a></span>
</div>
</li>
</ul>
</div>
<div id="magicfaq-recommend" style="display:none">
<p class="magicfaq-recommend-prompt not-helpful"><?php echo __( esc_attr( $instance['notHelpfulPrompt']), 'text_domain' ); ?></p>
<p class="magicfaq-recommend-prompt not-found"><?php echo __( esc_attr( $instance['notFoundPrompt']), 'text_domain' ); ?></p>
<input type="text" style="width:185px;margin-right:15px"><button>Recommend</button>
</div>
<div id="magicfaq-recommend-feedback" style="display:none" >Thank you for your question!</div>
        <?php 
        
        echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Ask MagicFAQ', 'text_domain' );
        $baseAPIPath = ! empty( $instance['baseAPIPath'] ) ? $instance['baseAPIPath'] : __( '', 'text_domain' );
        $resultsTitle = ! empty( $instance['resultsTitle'] ) ? $instance['resultsTitle'] : __( '', 'text_domain' );
        $defaultQuestionsTitle = ! empty( $instance['defaultQuestionsTitle'] ) ? $instance['defaultQuestionsTitle'] : __( '', 'text_domain' );
        $notFoundTitle = ! empty( $instance['notFoundTitle'] ) ? $instance['notFoundTitle'] : __( '', 'text_domain' );
        $notHelpfulPrompt = ! empty( $instance['notHelpfulPrompt'] ) ? $instance['notHelpfulPrompt'] : __( '', 'text_domain' );
        $notFoundPrompt = ! empty( $instance['notFoundPrompt'] ) ? $instance['notFoundPrompt'] : __( '', 'text_domain' );
        ?>
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( esc_attr( 'Title:' ) ); ?></label> 
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'baseAPIPath' ) ); ?>"><?php _e( esc_attr( 'Base API Path:' ) ); ?></label>
        <input placeholder="https://example.com/magicfaq/v1/" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'baseAPIPath' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'baseAPIPath' ) ); ?>" type="text" value="<?php echo esc_attr( $baseAPIPath ); ?>">
        </p>
        
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'resultsTitle' ) ); ?>"><?php _e( esc_attr( 'Results Title:' ) ); ?></label>
        <input placeholder="Answers:" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'resultsTitle' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'resultsTitle' ) ); ?>" type="text" value="<?php echo esc_attr( $resultsTitle ); ?>">
        </p>

        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'defaultQuestionsTitle' ) ); ?>"><?php _e( esc_attr( 'Default Questions Title:' ) ); ?></label>
        <input placeholder="This Week's Hottest Questions" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'defaultQuestionsTitle' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'defaultQuestionsTitle' ) ); ?>" type="text" value="<?php echo esc_attr( $defaultQuestionsTitle ); ?>">
        </p>

        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'notHelpfulPrompt' ) ); ?>"><?php _e( esc_attr( 'Not Helpful Prompt:' ) ); ?></label>
        <input placeholder="Not helpful? Recommend this question:" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'notHelpfulPrompt' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'notHelpfulPrompt' ) ); ?>" type="text" value="<?php echo esc_attr( $notHelpfulPrompt ); ?>">
        </p>

        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'notFoundPrompt' ) ); ?>"><?php _e( esc_attr( 'Not Found Prompt:' ) ); ?></label>
        <input placeholder="Recommend this question:" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'notFoundPrompt' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'notFoundPrompt' ) ); ?>" type="text" value="<?php echo esc_attr( $notFoundPrompt ); ?>">
        </p>

        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'notFoundTitle' ) ); ?>"><?php _e( esc_attr( 'Not Found Title:' ) ); ?></label>
        <input placeholder="No Answers Found" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'notFoundTitle' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'notFoundTitle' ) ); ?>" type="text" value="<?php echo esc_attr( $notFoundTitle ); ?>">
        </p>

        <?php 
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['baseAPIPath'] = ( ! empty( $new_instance['baseAPIPath'] ) ) ? strip_tags( $new_instance['baseAPIPath'] ) : '';
        $instance['resultsTitle'] = ( ! empty( $new_instance['resultsTitle'] ) ) ? strip_tags( $new_instance['resultsTitle'] ) : '';
        $instance['defaultQuestionsTitle'] = ( ! empty( $new_instance['defaultQuestionsTitle'] ) ) ? strip_tags( $new_instance['defaultQuestionsTitle'] ) : '';
        $instance['notHelpfulPrompt'] = ( ! empty( $new_instance['notHelpfulPrompt'] ) ) ? strip_tags( $new_instance['notHelpfulPrompt'] ) : '';
        $instance['notFoundPrompt'] = ( ! empty( $new_instance['notFoundPrompt'] ) ) ? strip_tags( $new_instance['notFoundPrompt'] ) : '';
        $instance['notFoundTitle'] = ( ! empty( $new_instance['notFoundTitle'] ) ) ? strip_tags( $new_instance['notFoundTitle'] ) : '';

        return $instance;
    }

}


function register_foo_widget() {
   register_widget( 'Foo_Widget' );
}
add_action( 'widgets_init', 'register_foo_widget' );

function files_scripts() //load js and css TODO: rewrite to remove registers
{
    wp_enqueue_script('jquery');
    wp_register_script( 'javascript', plugins_url( '/js/functions.js', __FILE__ ) );
    wp_enqueue_script( 'javascript' );
    wp_register_style( 'style', plugins_url( '/css/style.css', __FILE__ ) );
    wp_enqueue_style( 'style' );
}
add_action( 'wp_enqueue_scripts', 'files_scripts' ); //note no equivalent wp_enqueue_styles -- use scripts for css

