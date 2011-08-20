<?php
/*
Plugin Name: Simple-custo-taxo (Simple custom taxonomy)
Plugin URI: http://www.utcwebdesign.co.uk/blog/development/instructions/simple-custo-taxo-wordpress-plugin
Description: Simple plugin to enable the addition of custom taxonomy
Author: Christian Senior
Version: 1
Author URI: http://www.utcwebdesign.co.uk
*/

//build custom taxonomy
 if(!function_exists('build_taxonomies')) 
{ 
		add_action( 'init', 'build_taxonomies', 0 );

		function build_taxonomies() {
    		register_taxonomy( 'custo-cats', 'post', array( 'hierarchical' => true, 'label' => 'Custom Categories', 'query_var' => true, 'rewrite' => true ) );
		}
 
}

//flush the permalinks
add_action('admin_init', 'flush_rewrite_rules');


//start to build widget
class CustomCat extends WP_Widget
{
  function CustomCat()
  {
    $widget_ops = array('classname' => 'CustomCat', 'description' => 'Adds custom taxonomy via a widget' );
    $this->WP_Widget('CustomCat', 'Simple custom taxonomy', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
 
    if (!empty($title))
      echo $before_title . $title . $after_title . '<ul>';
 
    // start widget code
	wp_list_categories( array( 'taxonomy' => 'custo-cats', format => 'list', title_li => '' ) );
	
	//end widget code
 
    echo '</ul>'. $after_widget;
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("CustomCat");') );?>


