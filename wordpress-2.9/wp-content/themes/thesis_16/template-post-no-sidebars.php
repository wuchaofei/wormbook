

<?php 
/** 
 * Template Name Posts: Custom No Sidebars 
 * 
 * An archives template for posts which does not include sidebars. 
 * 
 * @package Thesis 
 */ 


     
if (is_single() || (is_page() && !$thesis['display']['comments']['disable_pages'])) 
     wp_enqueue_script('comment-reply'); 
     
     get_header(apply_filters('thesis_get_header', $name)); 
     
     echo '<div id="container">' . "\n"; 
     echo '<div id="page">' . "\n"; 
     
     thesis_header_area(); 
     thesis_hook_before_content_box(); 
     
     echo '    <div id="content_box" class="narrow_box">' . "\n"; 

    ?> 
     <div id="content"<?php thesis_content_classes(); ?>> 

    <?php 
    thesis_hook_before_content(); 


  // Customize the loop to remove the "comments closed"
  // Was: thesis_page_loop();
  global $post;
  global $thesis;

  while (have_posts()) {
    the_post();
    $post_image = thesis_post_image_info('image');
		
    thesis_hook_before_post_box();

?>  

      <div class="post_box top" id="post-<?php the_ID(); ?>">
    
    <?php 
    /* Display the category as a header to the page */
       $category = get_the_category(); 
       echo "<h1 class=\"post-category\">" 
	 . "<a href=\"" . get_category_link( $category[0]->cat_ID ) . "\">"
	 . $category[0]->cat_name . "</a></h1>"; 



    ?>

    <?php custom_thesis_headline_area(false, $post_image); ?>
     <div class="format_text">

<?php
	      thesis_post_content(false, $post_image);
?>



	    </div>

<?php comments_template(); ?>
       
		</div>

<?php
		thesis_hook_after_post_box();


  }


thesis_hook_after_content(); 
    ?> 
        </div> 

    <?php     

        echo '    </div>' . "\n"; 
     
thesis_hook_after_content_box(); 
thesis_footer_area(); 
     
echo '</div>' . "\n"; 
echo '</div>' . "\n"; 
         
get_footer(apply_filters('thesis_get_footer', $name));
