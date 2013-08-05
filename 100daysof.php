<?php
/*
Plugin Name: 100 Days of...
Plugin URI: www.romanbenedict.com/freebies
Description: Display a category of posts in a beautiful way, counting down including future posts. To use simply use the shortcode [daysof days='number of days you are planning' category='category of post to display']Text to put in the information box (can be full html)[/daysof] 
Author: Roman Benedict
Version: 1.0
Author URI: www.romanbenedict.com
License: GPL2   
*/
///////////////////////////////////////////////////////////////////////////////////
//plugin function
function hundreddaysof( $atts , $content = null ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'category' => '',
			'days' => '30',
			'displaydate' => 'yes'
		), $atts )
	);

	// Set Up Grid
	include ('includes/top.php');
	//Grid of Images
	$catarray = get_category($categoryid, ARRAY_A);
	$numberofposts = $catarray['count'];
	$numberofincompleteposts = $days - $numberofposts;

	$args = array( 'category'=>$categoryid, 'order'=> 'ASC' , 'numberposts'=>$numberofposts);
	$postslist = get_posts( $args );
	$number = 1;
		foreach ($postslist as $post) :  setup_postdata($post); 
			$postid = $post->ID; ?> 
				<li class="imagewrapper">
						<a href="<?php echo get_permalink($postid); ?> " data-largesrc="<?php $largeimageurl = wp_get_attachment_image_src( get_post_thumbnail_id($postid), 'square-large');
						echo $largeimageurl[0];//echo //get_the_post_thumbnail( $postid, 'full');?>" data-title="<?php echo get_the_title($postid); ?>" data-description="<?php the_excerpt(); ?>">
							<? echo get_the_post_thumbnail( $postid, 'square-med');?>
							<div class="overlayinfo"><span><?php echo $number;?></span><p><?php echo get_the_title($postid); ?></p><p><?php if($displaydate == 'yes'){ echo get_the_time(get_option('date_format'), $postid);}; ?></p></div>
						</a>
				</li >
				
<?php 	$number++;
endforeach;
//Grid of yet to come
	$number = $numberofposts + 1;
while($number<=$days)
  {
  echo "<li class='incompleteinfo'><span>" . $number . "</span></li>";
  $number++;
  };
	//bottom
	include ('includes/bottom.php');
}
add_shortcode( 'daysof', 'hundreddaysof' );
/////////////////////////////
//make css work
wp_register_style( '100daysofcss1', plugins_url( 'css/component.css' , __FILE__ ) );
wp_enqueue_style('100daysofcss1');
wp_register_style( '100daysofcss2', plugins_url( 'css/default.css' , __FILE__ ) );
wp_enqueue_style('100daysofcss2');
wp_register_script( '100daysofjs1', plugins_url( 'js/grid.js' , __FILE__ ) );
wp_enqueue_script('100daysofjs1');
wp_register_script( '100daysofjs2', plugins_url( 'js/modernizr.custom.js' , __FILE__ ) );
wp_enqueue_script('100daysofjs2');
//thumbnail sizes
if ( function_exists( 'add_theme_support' ) ) { 
    add_theme_support( 'post-thumbnails' );
    add_image_size( 'square-med', 250, 250, true); // name, width, height, crop 
	add_image_size( 'square-large', 500, 500, true); // name, width, height, crop 
    add_filter('image_size_names_choose', 'my_image_sizes');
}

function my_image_sizes($sizes) {
    $addsizes = array(
        "square-large" => __( "Large square image"),
		"square-med" => __( "Medium square image")
    );
    $newsizes = array_merge($sizes, $addsizes);
    return $newsizes;
}
?>