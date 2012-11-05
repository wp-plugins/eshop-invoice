<?php
 
/**
 * MyOrdersWidget Class
 */
class MyOrdersWidget extends WP_Widget {
    /** constructor */
    function MyOrdersWidget() {
        parent::WP_Widget('myorderswidget', $name = 'MyOrders');
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {
        extract( $args );
        
        if(is_user_logged_in()) {
        
        $title = apply_filters('widget_title', $instance['title']);
        $myorderspageid = $instance['myorderspage'];

        ?>
          <?php echo $before_widget; ?>
              <?php if ( $title ) echo $before_title . $title . $after_title; ?>
                
                <a href="<?php echo get_permalink( $myorderspageid ); ?>"><?php echo get_the_title($myorderspageid); ?></a>
                
                
                
              <?php echo $after_widget; 
        }
    }
    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['myorderspage'] = strip_tags($new_instance['myorderspage']);
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
        $title = esc_attr($instance['title']);
        $myorderspage = esc_attr($instance['myorderspage']);
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        
        <p>
          <label for="<?php echo $this->get_field_id('myorderspage'); ?>"><?php _e('MyOrders Page ID:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('myorderspage'); ?>" name="<?php echo $this->get_field_name('myorderspage'); ?>" type="text" value="<?php echo $myorderspage; ?>" />
        </p>
        
        <?php 
    }

} // class MyOrdersWidget
// register MyOrdersWidget widget
add_action('widgets_init', create_function('', 'return register_widget("MyOrdersWidget");'));
