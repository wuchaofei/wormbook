<?php

// *********************************************************************
//
//       CUSTOM TEMPLATE FUNCTIONS
//
// *********************************************************************

// This is ONLY added on post pages.  I guess that is okay.
// Originally, I had thought I would direct users
// to 1) register
// 2) send them to the admin panel to post a new entry.
// the admin panel, too.
function add_custom_javascript() { ?>
 <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/custom/custom.js"></script>
    <?php
    }

//add_action('wp_head','add_custom_javascript');



// Set up some custom templates
remove_action('thesis_hook_custom_template','thesis_custom_template_sample');

////////////////////////////////////////////////
//
// gazette_home_page: The Home Page for the WBG
//     page ID: 8
function gazette_home_page() {
  
  if (is_page('8') || is_front_page() ) {    
    echo '<div id="content">';
    //    thesis_content_classes();
    //    echo ">";    
    //thesis_hook_before_content();
    
    // Customize the loop
    // We will only include entries from the current
    // issue specified as a variable in the page content itself.
    global $post;
    global $thesis;
    
    while (have_posts()) {
      the_post();
      $post_image = thesis_post_image_info('image');
      
      thesis_hook_before_post_box();          
      	?>
      <div class="post_box top" id="post-<?php the_ID(); ?>">
	 
	 <?php

	 // Stick in the current cover, floating left with the TOC wrapping around it.
	 // TODO
	 // This should be DYNAMIC and should LINK TO the current cover
	 //	 echo '<div id="cover-image-solo">
         //      <a href="/wbg/volumes/current-cover-large.jpg">
         //            <img src="/wbg/volumes/current-cover.jpg" width="250px" />
         //      </a>
         // </div>';

	 echo '<div id="pseudo-sidebar">';
              echo '<div id="cover-image">
                    <a href="/wbg/volumes/current-cover-large.jpg">
                    <img src="/wbg/volumes/current-cover.jpg" />
                 </a>
                 </div>';
	 
	 echo '<div id="big-note">
	   <h3>Next Worm Breeder\'s Gazette</h3>
           <p class="noindent">
	   The next issue of the Worm Breeder\'s Gazette (Volume 19, #1) will be released in Dec 2010.  The <b>submission deadline</b> is <b>November 15th, 2010</b>.</p>
          <h3>Meetings, Courses and Workshops</h3>
          <p class="noindent">
              Workshop on the Biology of the <em>C. elegans</em> Male, June 29-July 1, 2010
          </p>

          <h3>Stay up-to-date!</h3>
          <p class="noindent">Subscribe for updates to the WBG by <a href="http://feedburner.google.com/fb/a/mailverify?uri=TheWormBreedersGazette&amp;loc=en_US">email</a> or <a href="http://feedburner.google.com/TheWormBreedersGazette">RSS</a>.
          </p>
         
          <div class="readmore"><a href="/wbg/news/">read more...</a></div>
';

	 //	 echo '<p class="noindent">
         //      <a href="http://feedburner.google.com/fb/a/mailverify?uri=TheWormBreedersGazette&amp;loc=en_US">Subscribe to The Worm Breeder\'s Gazette by Email</a>
	 // </p>';

	 echo '</div></div>';

      ?>

      <?php
	    // Custom headline area not needed for home
	    // custom_thesis_headline_area(false, $post_image);
	 
	    // The content of the post
	    // The page content should specify the category name of the current
	    // issue. It will make calls to display_issue_contents() 
	    // and thesis_hook_after_headline.

	  // This is really PAGE content...
	  thesis_post_content(false, $post_image); 
	 echo "</div>";
	 echo "</div>";
	 
	 thesis_hook_after_post_box();
    }
    
    thesis_hook_after_content();
    
    echo "</div>";

    // To use dynamic sidebars, uncomment this.
    // thesis_sidebars();

    // Instead we will over-ride Thesis's sidebar build
    // on the home page. The WBG theme as a whole will
    // be single column, but the home page will LOOK
    // like it has a sidebar. 
    //    echo '<div id="sidebars">';
    //echo '			<div id="sidebar_1" class="sidebar">' . "\n";
    //echo '				<ul class="sidebar_list">' . "\n";
    //echo '<img src="/wbg/i/covers/current-cover.jpg" width="250px" />';
    //echo '</ul></div></div>';


    echo ' </div>' . "\n";
  }
}
add_action('thesis_hook_custom_template','gazette_home_page');


////////////////////////////////////////////////
//
// A single column page with no comments.
//   Used for
//      * Instructions for authors (68)
//      * About (2)
//      * Citing the Gazette (178)
//      * Gazette Archive (list of all issues) (91)
//      * News
function single_column_no_comments_page() {
 
  if (is_page('68') || is_page('2') || is_page('178')  || is_page('91') || is_archive() || is_page('845')) {
    echo '<div id="content_box" class="narrow_box">' . "\n";
    
    // Display content ( derived from thesis_content_column )
    echo '<div id="content"';
    thesis_content_classes();
    thesis_hook_before_content();
    
    // Customize the loop and remove the "comments closed"
    // Was: thesis_page_loop();
    global $post;
    global $thesis;
    
    while (have_posts()) {
      the_post();
      $post_image = thesis_post_image_info('image');
      
      thesis_hook_before_post_box();
	?>
	
	<div class="post_box top" id="post-<?php the_ID(); ?>">
	   <?php custom_thesis_headline_area(false, $post_image); ?>
	   <div class="format_text">
	      
	      <?php thesis_post_content(false, $post_image); ?>
	      </div>
		  </div>
		  
		  <?php
		  thesis_hook_after_post_box();
    }
    
    thesis_hook_after_content();
    
    echo "</div>";
    echo '</div>' . "\n";
  }
}
add_action('thesis_hook_custom_template','single_column_no_comments_page');



////////////////////////////////////////////////
//
// Individual Post templates
//
//  This is handled by single.php in the
//  thesis root/                             
//





// ******************************************************
//
//       BOILERPLATE FORMATTING
//
// ******************************************************

// Remove the comments thing. It's ugly.
// This is a filter.
function remove_comments_intro($content) {
  $content = '<div class="comments_intro">';
  $content .= '<p><span>Add a Comment</span></p>';
  $content .= '</div>' . "\n";
  return $content;
}
add_filter('thesis_comments_intro', 'remove_comments_intro');



// The Generic header
function add_header() {
?>
 <div id="header-left">
    <p id="logo">
      <a href="/wbg/">
      <img src="/wbg/i/banner_small.png" alt="The Worm Breeder's Gazette" width="800px" />
      </a>
    </p>
  </div>
<?php
 
}

remove_action('thesis_hook_header','thesis_default_header');
add_action('thesis_hook_header','add_header');


# Add the search box to the navigation bar.
function _search_box() {
  
?>
<div class="widget thesis_widget_search">
<form method="get" class="search_form" action="http://dev.wormbook.org/wbg/">
<input class="text_input" type="text" 
       value="Search the Gazette" 
       name="s" 
       id="s" onfocus="if (this.value == 'To search, type and hit enter') {this.value = '';}" onblur="if (this.value == '') {this.value = 'To search, type and hit enter';}" />
<input type="hidden" id="searchsubmit" value="Search" />
</form>
</div>

<?php
}
add_action('thesis_hook_last_nav_item', 'thesis_search_form');



// Add in a custom footer
function add_footer() {
  ?>
 
 <div style="float:left">
    <span style="border-right:1px solid #DDDDDD;float:left;padding-right:10px;margin-right:10px">
    <a href="http://www.wormbook.org">
    <img width="125px" src="/images/wormbook_sponsor.png" />
    </a>
    </span>
    <span style="border-right:1px solid #DDDDDD;float:left;padding-right:10px;margin-right:10px">
    
    <a href="http://creativecommons.org/licenses/by/2.5/" target="_blank">
    <img style="float:left;border:0" src="/images/somerights20.gif" align="middle" alt="Creative Commons License"/>
    </a>
    </span>
    </div>
    
    <div>    
    All content, except where otherwise noted, is licensed under a
    <a href="http://creativecommons.org/licenses/by/2.5/" title="Creative Commons Attribution License" target="_blank">
    Creative Commons Attribution License.
    </a>
    <br></br>
    General information about the Worm Breeder's Gazette on this page is copyrighted under the 
      <a href="/db/misc/copyright_gfdl">GNU Free Documentation License</a>.
</div>

<?php
}
remove_action('thesis_hook_footer','thesis_footer_scripts');
add_action('thesis_hook_footer','add_footer');
// Remove thesis attribution
remove_action('thesis_hook_footer','thesis_attribution');


// Move the navigation menu BELOW the header.
// We have to remove it from the before_header_hook
remove_action('thesis_hook_before_header','thesis_nav_menu');
add_action('thesis_hook_after_header','thesis_nav_menu');


// Create a navigation bar when viewing issue contents
function previous_next_article() {
        global $thesis;

        $use_arrows = 1;
        $nav_text = "ARTICLES";
        // FORMAT:     <previous>  ARTICLES  <next>
        // FORMAT:     <previous>  VOLUME  <next>

        if (is_single() && $thesis['display']['posts']['nav']) {

            // These posts should be limited to the current category (issue)
            $previous = get_previous_post();
            $next     = get_next_post();


            echo '<div class="prev_next post_nav">' . "\n";
	    echo '<div class="previous">';

            $categories = get_the_category(',');
            echo '<span>' . $categories[0]->cat_name . ': </span>';

            // Link to the TOC
            echo '<a href="/wbg/archive/' . $categories[0]->category_nicename . '/">contents</a>';

            // NEXT is really PREVIOUS for when thinking of a magazine
	    if ($next) {
                 echo " | ";
                 next_post_link('%link', '&#171; previous',1);
            }


           // PREVIOUS is really NEXT when thinking of a magazine
          if ($previous) {                          
                 echo " | ";
                 previous_post_link('%link','next &#187;',1);
           }

           // Provide a link to the PDF using the category slug
           // and the name of the PDF file.
           $slug     = $categories[0]->category_nicename;
           $id = get_the_ID();
           $pdf = get_post_meta($id,'PDF','true');
      
           echo '<div class="navigation-meta">';
           echo "<a title=\"Download a PDF of this article\" href=\"/wbg/volumes/$slug/pdf/$pdf\">
							  Download as PDF
							  </a> | ";

      // Provide a dynamic link to comments - will display the number of comments if there are any.
      echo '<a href="#respond">';
	     comments_number('Submit a comment', '1 comment', '% comments');
      echo "</a>";
      echo "</div>";

    echo '</div>' . "\n";
   echo '</div>' . "\n";
   }
}

// REMOVE THEM FROM THEIR DEFAULT LOCATION
// ... AND PLACE THEM ABOVE THE POST BOX
remove_action('thesis_hook_after_content','thesis_prev_next_posts');
add_action('thesis_hook_before_post_box','previous_next_article');
// OR Below the posts and comment form
// add_action('thesis_hook_after_content','previous_next_article');



// Add some caveats to the comment form.
function comment_caveats() {
?>
<div class="comment-caveat">
   Your email address will not be displayed and will never be shared or distributed.<br /><br />
   Your comment will be held for moderation. The Worm Breeder's 
    Gazette editors reserve the right to refuse offensive or inappropriate comments.

</div>
<?php
    }
add_action('thesis_hook_comment_form','comment_caveats');






// ******************************************************
//
//       Issue-wide and single post processing
//
// ******************************************************

// display_issue_contents: a brief listing of an issue
// Should be supplied with a category name
function display_issue_contents($category) {

  //The Query
  query_posts("category_name=$category");

  //The Loop
  echo '<div id="toc">';

  // Include the image
  // Convert the category into a filename
  // $filename = str_replace(" ","_",$category);
  // $filename = str_replace(",","",$filename);
  // $filename = strtolower($filename);
 
  if ( have_posts() ) {
    while ( have_posts() ) {
      the_post();
      
      echo '<div class="entry">';
      
      // The title and submission meta
      // Needs: Links to pages, authors custom field.
      echo '<div class="title">';
      echo '<a href="' . get_permalink() . '">';
      echo get_the_title() . '</a></div>';
      
      // The authors
      echo '<div class="authors">';
      $id = get_the_ID();
      echo get_post_meta($id,'Authors (TOC)','true');
      echo "</div>";
      
      // Tags
      echo '<div class="tags">';
      echo the_tags() ;
      echo "</div>";
      
      if ($category == "unvetted submissions") {
	// Get submitter info
	$author_name = get_post_meta($id,'Author Name','true');
	$author_home_page = get_post_meta($id,'Author Home Page','true');
	if ($author_home_page) {
	  echo "<div class=\"date\">Submitted by: <a href=\"$author_home_page\">$author_name</a></div>";
	} else {
	  echo "<div class=\"date\">Submitted by: $author_name</div>";
	}
	echo '<div class="date">Submitted on: ' . get_the_time('F j, Y') . "</div>";
      }
      
      echo '</div>';
    }
  }
  echo "</div>";

  //Reset Query
  wp_reset_query();
}


// Provide a custom thesis_headline_area.
// This is the headline for a given post
// This is a component of thesis_hook_headline but there isn't a specific
// hook for this function.
function custom_thesis_headline_area($post_count = false, $post_image = false) {
  
  /* We're not setting up the headline area for the front page */
  if (is_front_page() ) {
    return true;
  }
  
    ?>
  <div class="headline_area">
  <?php
  
  thesis_hook_before_headline($post_count);
  
  if ($post_image['show'] && $post_image['y'] == 'before-headline')
    echo $post_image['output'];
  
  if (is_404()) {
    echo '<h1>';
    thesis_hook_404_title();
    echo '</h1>' . "\n";
  } elseif (is_page()) {
    if (is_front_page()) {
      // Suppress the page title on the front page
      // echo '<h2>' . get_the_title() . '</h2>' . "\n";
    } else {
      echo '<h1>' . get_the_title() . '</h1>' . "\n";
      
      if ($post_image['show'] && $post_image['y'] == 'after-headline')
	echo $post_image['output'];
      
      thesis_hook_after_headline($post_count);
      thesis_byline();
    }
  } else {
    if (is_single()) {      
      echo '<h1 class="entry-title">' . get_the_title() . '</h1>';      
    } else {
  ?>
 <h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent link to <?php the_title(); ?>">
    <?php the_title(); ?>
    </a>
	</h2>
	<?php
	}
    
    if ($post_image['show'] && $post_image['y'] == 'after-headline')
      echo $post_image['output'];
    
    thesis_hook_after_headline($post_count);
    thesis_byline($post_count);
    thesis_post_categories();
  }
    ?>
  </div>
  <?php
}
 

// Add custom fields meta data to single posts after the post headline.
// This pulls data from the custom fields.
 function add_meta_data_after_post_headline() {

   if (is_single()) {
     echo '<div class="post-meta">';

     echo '<div class="authors">';
     $id = get_the_ID();
     echo get_post_meta($id,'Authors (post)','true');
     echo "</div>";
     
     echo '<div class="affiliations">';
     echo get_post_meta($id,'Affiliations (post)','true');
     echo "</div>";

     $correspondence = get_post_meta($id,'Correspondence to (post)','true');
     if ($correspondence) {

       echo '<div class="correspondence-to">';
       echo "Correspondence to: ";
       echo $correspondence;
       echo "</div>";

     }

     echo "</div>";  
   }
}
add_action('thesis_hook_after_headline','add_meta_data_after_post_headline');







////////////////////////////////////////////////
//
// WBG Submissions
//

// Build up custom entries in the admin interface.
// This is MOSTLY for administrative purposes (ie correcting errors)
if ( !class_exists('myCustomFields') ) {

  class myCustomFields {
    /**
     * @var  string  $prefix  The prefix for storing custom fields in the postmeta table
     */
    var $prefix = '_mcf_';
    /**
     * @var  array  $customFields  Defines the custom fields available
     */
    var $customFields =array(
			     array(
				   "name"=> "block-of-text",
				   "title"=> "A block of text",
				   "description"=> "",
				   "type"=> "textarea",
				   "scope"=>array( "page" ),
				   "capability"=> "edit_pages"
				   ),
			     array(
				   "name"=> "short-text",
				   "title"=> "A short bit of text",
				   "description"=> "",
				   "type"=>"text",
				   "scope"=>array( "post" ),
				   "capability"=> "edit_posts"
				   ),
			     array(
				   "name"=> "checkbox",
				   "title"=> "Checkbox",
				   "description"=> "",
				   "type"=> "checkbox",
				   "scope"=>array( "post", "page" ),
				   "capability"=> "manage_options"
				   )
			     );
			     
			     

			     /**
			      * PHP 4 Compatible Constructor
			      */
			     function myCustomFields() { $this->__construct(); }
    /**
     * PHP 5 Constructor
     */
    function __construct() {
      add_action( 'admin_menu', array( &$this, 'createCustomFields' ) );
      add_action( 'save_post', array( &$this, 'saveCustomFields' ), 1, 2 );
      // Comment this line out if you want to keep default custom fields meta box
      //      add_action( 'do_meta_boxes', array( &$this, 'removeDefaultCustomFields' ), 10, 3 );
    }

    /** 
    * Remove the default Custom Fields meta box
    */
    function removeDefaultCustomFields( $type, $context, $post ) {
      foreach ( array( 'normal', 'advanced', 'side' ) as $context ) {
	remove_meta_box( 'postcustom', 'post', $context );
	remove_meta_box( 'postcustom', 'page', $context );
	//Use the line below instead of the line above for WP versions older than 2.9.1
	//remove_meta_box( 'pagecustomdiv', 'page', $context );
      }
    }
    /**
     * Create the new Custom Fields meta box
     */
    function createCustomFields() {
      if ( function_exists( 'add_meta_box' ) ) {
	//	add_meta_box( 'my-custom-fields', 'Custom Fields', array( &$this, 'displayCustomFields' ), 'page', 'normal', 'high' );
	add_meta_box( 'custom-submitting-author-fields', 'Submitting Author', array( &$this, 'displaySubmittingAuthorFields' ), 'post', 'normal', 'high' );
	add_meta_box( 'custom-author-fields',            'Authors',           array( &$this, 'displayAuthorFields' ),           'post', 'normal', 'high' );
	add_meta_box( 'custom-affiliation-fields',       'Affiliations',      array( &$this, 'displayAffiliationFields' ),      'post', 'normal', 'high' );
	add_meta_box( 'custom-submitted-text-fields',    'Submitted Text',    array( &$this, 'displaySubmittedTextFields' ),    'post', 'normal', 'high' );
	add_meta_box( 'custom-reference-fields',         'References',        array( &$this, 'displayReferenceFields' ),        'post', 'normal', 'high' );
	add_meta_box( 'custom-figure-fields',            'Figures',           array( &$this, 'displayFigureFields' ),        'post', 'normal', 'high' );
	add_meta_box( 'custom-word-upload-fields',       'Original File',     array( &$this, 'displayWordUploadFields' ),        'post', 'normal', 'high' );
      }
    }

    function displaySubmittingAuthorFields() {
      global $post;
      ?>
	<div class="form-wrap">
	   <?php
	   wp_nonce_field( 'custom-submitting-author-fields', 'custom-submitting-author-fields_wpnonce', false, true );

      echo "<table><tr><th>First Name</th><th>Last Name</th><th>EMail</th></tr>";
				
	$firstname = $this->prefix . "submitting_author_firstname";
	echo '<td><input type="text" size="25" name="' . $firstname
	  . '" id="' . $firstname . '" value="' 
	  . htmlspecialchars( get_post_meta( $post->ID, $firstname, true ) ) . '" /></td>';
	
	$lastname = $this->prefix . "submitting_author_lastname";
	echo '<td><input type="text" size="25" name="' . $lastname
	  . '" id="' . $lastname 
	  . '" value="' 
	  . htmlspecialchars( get_post_meta( $post->ID, $lastname, true ) ) . '" /></td>';
	
	$email = $this->prefix . "submitting_author_email";
	echo '<td><input type="text" size="25" name="' . $email
	  . '" id="' . $email 
	  . '" value="' 
	  . htmlspecialchars( get_post_meta( $post->ID, $email, true ) ) . '" /></td>';
	
	echo '</tr></table>'; 
	echo '</div>';	
    }
    

    function displayAffiliationFields() {
      global $post;
      ?>
	<div class="form-wrap">
	   <?php
	   wp_nonce_field( 'custom-affiliation-fields', 'custom-affiliation-fields_wpnonce', false, true );

      echo "<p><i>Affiliations. The order here is important. Affiliation #1 will be listed first and so on. Affiliation IDs are used to associated authors <-> affiliations, too.</i></p>";
							
      // Display 10 maximum affiliations
      echo "<table><tr><th>ID</th><th>Affiliation</th><th width='50%'>Associated Authors";
      //      echo "<table width='100%'><tr>";
      //          for ($count = 1 ; $count<11; $count++) {
      //      	echo "<td>$count</td>";
      //            }
      //            echo "</tr></table>";
      echo "</th></tr>";

      for ($affiliationid = 1 ; $affiliationid<6; $affiliationid++) {

	echo "<tr><td>$count</td>";

	$affiliation = $this->prefix . "affiliation" . $affiliationid;
	echo '<td><textarea rows="3" cols="40" name="' . $affiliation
	  . '" id="' . $affiliation . '" value="' 
	  . htmlspecialchars( get_post_meta( $post->ID, $affiliation, true ) ) . '"></textarea></td>';


	// The form show affiliations -> authors,
	// but the data schema maps authors -> affiliations in order to facilitate display.
	// To display
	// 1. iterate over authors, getting their ids
	// 2. get_post_meta for prefixauthors2affiliations$id (possibly array of affiliation ids)
	// 3. list the corresponding affiliation
	echo '<td>';
	echo '<table width="100%"><tr>';
	for ($authorid=1;$authorid<11; $authorid++) {
	  //	  $affiliations2authors = $this->prefix . "affiliations2authors" . $affiliationid;
	  $authors2affiliations = $this->prefix . "authors2affiliations" . $authorid;
	  //	  echo '<td>' . $authorid . '<input type="checkbox" name="' . $affiliations2authors
	  echo '<td>' . $authorid . '<input type="checkbox" name="' . $authors2affiliations . '" '
	    . 'id="' . $affiliationid . '" '
	    . 'value="' . $affiliationid . '" ';
	  // Need to check state.
	  //	  if (get_post_meta( $post->ID, $affiliations2authors, true )) {
	  if (get_post_meta( $post->ID, $authors2affiliations, true )) {
	    echo ' checked';
	  }
	  echo ' /></td>';
	}
	echo '</tr></table>';
	echo '</td></tr>';
	
      }
      echo '</tr></table>';      
      echo '</div>';
    }
    
    
    function displayAuthorFields() {
      global $post;
	?>
	<div class="form-wrap">
	   <?php
	   wp_nonce_field( 'custom-author-fields', 'custom-author-fields_wpnonce', false, true );
      
      // Display 10 author fields (should use javascript to dynamically add more options)
      
      echo "<table><tr><th>Author</th><th>First Name</th><th>Last Name</th><th>Corresponding<br /> Author?</th><th>EMail</th><th>Affiliations</th></tr>";
      
      for ($count = 1 ; $count<11; $count++) {
	
	echo "<tr><td>$count</td>";
	$firstname = $this->prefix . "author" . $count . "_firstname";
	echo '<td><input type="text" size="25" name="' . $firstname
	  . '" id="' . $firstname . '" value="' 
	  . htmlspecialchars( get_post_meta( $post->ID, $firstname, true ) ) . '" /></td>';
	
	$lastname = $this->prefix . "author" . $count . "_lastname";
	echo '<td><input type="text" size="25" name="' . $lastname
	  . '" id="' . $lastname . '"'
	  . ' value="' 
	  . htmlspecialchars( get_post_meta( $post->ID, $lastname, true ) ) . '" /></td>';
	
	// CHeckbox for corresponding author
	$is_corresponding = $this->prefix . "author" . $count . "_is_corresponding";
	echo '<td><input type="checkbox" name="' . $is_corresponding
	  . '" id="' . $is_corresponding . '"'
	  . ' value="' . get_post_meta( $post->ID, $is_corresponding, true ) . '" /></td>';
	

	$email = $this->prefix . "author" . $count . "_email";
	echo '<td><input type="text" size="25" name="' . $email
	  . '" id="' . $email . '"'
	  . ' value="' 
	  . htmlspecialchars( get_post_meta( $post->ID, $email, true ) ) . '" /></td>';
	
	// Authors2affiliations.
	// Values here correspond to affiliations indices.
	// TODO Need to check state
	echo '<td>';
	for ($affiliationid=1;$affiliationid<6; $affiliationid++) {
	  $affiliation = $this->prefix . "author" . $count . "_affiliations";
	  echo '<input type="checkbox" name="' . $affiliation
	    . '" id="' . $affiliationid . '"'
		    . ' value="' . $affiliationid . '"';
	  // Need to check state.
	  if (get_post_meta( $post->ID, $affiliation, true )) {
	    echo ' checked';
	  }
	  echo ' />';
	}
	echo '</td>';
	
	// Just displayed the associated affiliations. Editable below
	//echo '<td>' . get_post_meta( $post->ID, $affiliation, true )) {
	//echo '<td></td>';
	echo '</tr>';
      }
      
      echo "</table>";

      // SAVE THIS.
      // The PAGE version of this form will use this to dynamically add form elements.
      // Dropdowns of affiliations, populated by Javascript with previously entered affiliations
      //      echo '<td><a href="#" onClick="addFormField(); return false;">Add</a></td>';
      
      //echo '<form action="#" method="get" id="form1">
      //                 <input type="hidden" id="id" value="1">
		    //             </form>
      //<p><input type="submit" value="Submit" name="submit">
      //<input type="button" id="button"  value="Add field" / >
      //<input type="reset" value="Reset" name="reset"></p>
      //                 <div id="divTxt"></div>
      //';

      echo '</div>';
    }


    
    function displaySubmittedTextFields() {
      global $post;
	?>
	<div class="form-wrap">
	   <?php
	   wp_nonce_field( 'custom-submitted-text-fields', 'custom-submitted-text-fields_wpnonce', false, true );
      
      echo "<p><i>This is the text as originally submitted. It is preserved here for verification purposes. The marked up version of this text is stored as the post entry, which is used for building page entries.</i></p>";
      
      $title = $this->prefix . "submitted_title";      
      echo '<label for="' . $title .'" style="display:inline;"><b>Submitted Title</b></label>&nbsp;&nbsp;';
      echo '<p><input type="text" size="80" name="' . $title
	. '" id="' . $title 
	. '" value="' 
	. htmlspecialchars( get_post_meta( $post->ID, $title, true ) ) . '" /></p>';
      
      
      $text = $this->prefix . "submitted_text";
      echo '<label for="' . $text .'" style="display:inline;"><b>Submitted Abstract</b></label>&nbsp;&nbsp;';
      echo '<p><textarea rows="30" cols="80" name="' . $text
	. '" id="' . $text . '" value="' 
	. htmlspecialchars( get_post_meta( $post->ID, $text, true ) ) . '"></textarea></p>';
      echo '</div>';	
    }
    
    
    function displayReferenceFields() {
      global $post;
	?>
	<div class="form-wrap">
	   <?php
	   wp_nonce_field( 'custom-reference-fields', 'custom-reference-fields_wpnonce', false, true );
      
      // Display 10 maximum references
      echo "<table><tr><th>ID</th><th>Submitted Reference</th><th>Marked up Reference</th></tr>";
      
      for ($count = 1 ; $count<11; $count++) {
	
	echo "<tr><td>$count</td>";
	
	$submitted = $this->prefix . "reference" . $count . "_submitted";
	echo '<td><textarea rows="3" cols="40" name="' . $submitted
	  . '" id="' . $submitted . '" value="' 
	  . htmlspecialchars( get_post_meta( $post->ID, $submitted, true ) ) . '"></textarea></td>';
	
	$markedup = $this->prefix . "reference" . $count . "_markedup";
	echo '<td><textarea rows="3" cols="40" name="' . $submitted
	  . '" id="' . $markedup . '" value="' 
	  . htmlspecialchars( get_post_meta( $post->ID, $markedup, true ) ) . '"></textarea></td></tr>';
      }
      echo '</tr></table>';      
      echo '</div>';
    }

    function displayFigureFields() {
      global $post;
	?>
	<div class="form-wrap">
	   <?php
	   wp_nonce_field( 'custom-figure-fields', 'custom-figure-fields_wpnonce', false, true );
      

      echo "<table><tr><th>ID</th><th>Figure Upload</th><th>Figure Legend</th></tr>";
      
      for ($id = 1 ; $id<4; $id++) {
	
	echo "<tr><td>$id</td>";

	// The figure filename. This should NOT be editable...
	// If there IS an upload, display a small thumbnail,
	// the filename, and the caption.
	$figure = $this->prefix . "figure" . $id . "_upload";
	echo '<td><textarea rows="3" cols="40" name="' . $figure
	  . '" id="' . $figure . '" value="' 
	  . htmlspecialchars( get_post_meta( $post->ID, $figure, true ) ) . '"></textarea></td>';
	
	$legend = $this->prefix . "figure" . $id . "_legend";
	echo '<td><textarea rows="3" cols="40" name="' . $legend
	  . '" id="' . $legend . '" value="' 
	  . htmlspecialchars( get_post_meta( $post->ID, $legend, true ) ) . '"></textarea></td></tr>';
      }
      echo '</tr></table>';      
      echo '</div>';
    }
    

    function displayWordUploadFields() {
      global $post;
	?>
	<div class="form-wrap">
	   <?php
	   wp_nonce_field( 'custom-word-upload-fields', 'custom-word-upload-fields_wpnonce', false, true );
      echo '<p><i>This is the original Word-formatted upload, used to verify formatting</i></p>';
      
      // This should just be a link to the file - no need to make it editable.
	$file = $this->prefix . "original_word_upload";
	echo '<td><input type="text" size="25" name="' . $file
	  . '" id="' . $file . '" value="' 
	  . htmlspecialchars( get_post_meta( $post->ID, $file, true ) ) . '" /></td>';
	echo '</div>';
    }


    
    /**
     * Display the Custom Fields box
     */
    function displayCustomFields() {
      global $post;
      ?>
	<div class="form-wrap">
	   <?php
	   wp_nonce_field( 'my-custom-fields', 'my-custom-fields_wpnonce', false, true );
      foreach ( $this->customFields as $customField ) {
	// Check scope
	$scope = $customField[ 'scope' ];
	$output = false;
	foreach ( $scope as $scopeItem ) {
	  switch ( $scopeItem ) {
	  case "post": {
	    // Output on any post screen
	    if ( basename( $_SERVER['SCRIPT_FILENAME'] )=="post-new.php" || $post->post_type=="post" )
	      $output = true;
	    break;
	  }
	  case "page": {
	    // Output on any page screen
	    if ( basename( $_SERVER['SCRIPT_FILENAME'] )=="page-new.php" || $post->post_type=="page" )
	      $output = true;
	    break;
	  }
	  }
	  if ( $output ) break;
	}
	// Check capability
	if ( !current_user_can( $customField['capability'], $post->ID ) )
	  $output = false;
	// Output if allowed
	if ( $output ) { ?>
<div class="form-field form-required">
   <?php
   switch ( $customField[ 'type' ] ) {
     case "checkbox": {
       // Checkbox
       echo '<label for="' . $this->prefix . $customField[ 'name' ] .'" style="display:inline;"><b>' . $customField[ 'title' ] . '</b></label>&nbsp;&nbsp;';
       echo '<input type="checkbox" name="' . $this->prefix . $customField['name'] . '" id="' . $this->prefix . $customField['name'] . '" value="yes"';
       if ( get_post_meta( $post->ID, $this->prefix . $customField['name'], true ) == "yes" )
       echo ' checked="checked"';
       echo '" style="width: auto;" />';
       break;
     }
     case "textarea":
     case "wysiwyg": {
       // Text area
       echo '<label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' . $customField[ 'title' ] . '</b></label>';
       echo '<textarea name="' . $this->prefix . $customField[ 'name' ] . '" id="' . $this->prefix . $customField[ 'name' ] . '" columns="30" rows="3">' . htmlspecialchars( get_post_meta( $post->ID, $this->prefix . $customField[ 'name' ], true ) ) . '</textarea>';
       // WYSIWYG
       if ( $customField[ 'type' ] == "wysiwyg" ) { ?>
<script type="text/javascript">
   jQuery( document ).ready( function() {
     jQuery( "<?php echo $this->prefix . $customField[ 'name' ]; ?>" ).addClass( "mceEditor" );
     if ( typeof( tinyMCE ) == "object" && typeof( tinyMCE.execCommand ) == "function" ) {
       tinyMCE.execCommand( "mceAddControl", false, "<?php echo $this->prefix . $customField[ 'name' ]; ?>" );
     }
   });
</script>
    <?php }
       break;
     }
     default: {
       // Plain text field
       echo '<label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' . $customField[ 'title' ] . '</b></label>';
       echo '<input type="text" name="' . $this->prefix . $customField[ 'name' ] . '" id="' . $this->prefix . $customField[ 'name' ] . '" value="' . htmlspecialchars( get_post_meta( $post->ID, $this->prefix . $customField[ 'name' ], true ) ) . '" />';
       break;
     }
   }
?>
   <?php if ( $customField[ 'description' ] ) echo '<p>' . $customField[ 'description' ] . '</p>'; ?>
       </div>
	   <?php
	   }
      } ?>
							</div>
							    <?php
							    }

    /**
     * Save the new Custom Fields values
     */
    function saveCustomFields( $post_id, $post ) {
      if ( !wp_verify_nonce( $_POST[ 'my-custom-fields_wpnonce' ], 'my-custom-fields' ) )
	return;
      if ( !current_user_can( 'edit_post', $post_id ) )
	return;
      if ( $post->post_type != 'page' && $post->post_type != 'post' )
	return;
      foreach ( $this->customFields as $customField ) {
	if ( current_user_can( $customField['capability'], $post_id ) ) {
	  if ( isset( $_POST[ $this->prefix . $customField['name'] ] ) && trim( $_POST[ $this->prefix . $customField['name'] ] ) ) {
	    $value = $_POST[ $this->prefix . $customField['name'] ];
	    // Auto-paragraphs for any WYSIWYG
	    if ( $customField['type'] == "wysiwyg" ) $value = wpautop( $value );
	    update_post_meta( $post_id, $this->prefix . $customField[ 'name' ], $value );
	  } else {
	    delete_post_meta( $post_id, $this->prefix . $customField[ 'name' ] );
	  }
	}
      }
    }


  }
}

// Instantiate the class
if ( class_exists('myCustomFields') ) {
  $myCustomFields_var = new myCustomFields();
}





//      var id = getElementById("id").value;
//      //  $("#divTxt").append("hello");
//      
//      //  $(‘#row’ + id).highlightFade({
//      //speed:1000
//      //	});
//      
//      // id = (id – 1) + 2;
//      //document.getElementById(“id”).value = id;


//
     // This should be more like
      // <a id="add_form_element">Add Author</a>
      // $('#add_form_element').click(function() {
      
      // Get the inner value, see what it is, then insert the appropriate form element.
      
      //    }