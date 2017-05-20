<?php

/* 
 * 
 */

$banner = wp_get_attachment_url( get_option( 'ptr_banner_id' ));

class ptr_banner_widget extends WP_Widget {
    function ptr_banner_widget() {
        // Constructor del Widget
        $options = array(
            'classname' => 'ptr-simple-banner',
            'description' => __('Promotore simple banner','promotore-simple-banner'));
        $this->WP_Widget('ptr_banner_widget', 'Simple Banner', $options);
    }
    function form($instance) {
        // Agrego el estilo del Plug-in
        wp_enqueue_style(
            'ptr_banner', // Name of the stylesheet. Should be unique.
            plugin_dir_url( __FILE__ ).'libs/css/banner.css');
        ?>       
            <p><?php echo _e('You can configure image in Options -> Simple Banner','promotore-simple-banner') ?></p>
            <img 
                src='<?php echo wp_get_attachment_url( get_option( 'ptr_banner_id' ) ); ?>'
                class='ptr_simple_banner_image'>
            
        <?php
    }
    function update($new_instance, $old_instance) {
    }

    function widget($args, $instance) {
        ?>
            <div class="ptr_simple_banner_div">
                <img 
                    src='<?php echo wp_get_attachment_url( get_option( 'ptr_banner_id' ) ); ?>'
                    class='ptr_simple_banner_image'>
            </div>
        <?php
    }
}

/**
 * Widget
 */
function register_ptr_banner_widget() {
    register_widget('ptr_banner_widget');
}

add_action('widgets_init', 'register_ptr_banner_widget');