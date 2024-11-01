<?php
/*
Plugin Name: Custom Coloured Post Titles
Plugin URI: http://www.samburdge.co.uk/plugins/
Description: Adds the option to select a colour for the post title.
Version: 1.0
Author: Sam Burdge
Author URI: http://www.samburdge.co.uk

*/

/*  Copyright 2006  Sam Burdge (sam@samburdge.co.uk)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA


COLOR PICKER SELECTOR SCRIPT IS COPYRIGHTED BY:

FREE-COLOR-PICKER.COM
HTTP://WWW.FREE-COLOR-PICKER.COM
            
PERMISSION GIVEN TO USE THIS SCRIPT IN ANY KIND
OF APPLICATIONS IF SCRIPT CODE REMAINS
UNCHANGED AND THE ANCHOR TAG "POWERED BY FCP"
REMAINS VALID AND VISIBLE TO THE USER.

*/
//Function: Add Color Picker Javascript to admin head
add_action('admin_head', 'title_colour_js');
function title_colour_js() { 
echo '<script src="'.get_bloginfo('home').'/wp-content/plugins/custom_title_colour/201a.js" type="text/javascript"></script>'; } 



//Function: Add Color Picker div to admin footer
add_action('dbx_post_sidebar', 'title_colour_picker_div');
function title_colour_picker_div() { ?>
<div id="colorpicker201" class="colorpicker201" style="position: absolute; top:400px;"></div>
<?php }

//Function: Add Title Colour To Admin
add_action('dbx_post_sidebar', 'title_colour_admin');
function title_colour_admin() {
	$key = 'title_colour_hex';
$post = $_GET['post'];
?>
<fieldset id="title_colour_div" class="dbx-box">
	<h3 class="dbx-handle">Title Colour</h3> 
	<div class="dbx-content">
	
<input type="button" onclick="showColorGrid2('title_colour_hex','sample_1');" value="Select Colour" /><br />
<input type="text" name="title_colour_hex" id="title_colour_hex" value="<?php echo get_post_meta($post, $key, true); ?>" />&nbsp;
<input type="text" ID="sample_1" size="1" value="" style="background: <?php echo get_post_meta($post, $key, true); ?>;" />

	</div>
</fieldset>
<?php
}

//Function: update options
function title_colour_update($id){
$tckey = 'title_colour_hex';
$title_colour_hex = $_POST["title_colour_hex"];

if($title_colour_hex == "nocolour"){delete_post_meta($id, 'title_colour_hex');}

if (isset($title_colour_hex) && !empty($title_colour_hex) && $title_colour_hex != 'nocolour'){
delete_post_meta($id, 'title_colour_hex');
add_post_meta($id, 'title_colour_hex', $title_colour_hex);}
}

add_action('edit_post', 'title_colour_update');
add_action('publish_post', 'title_colour_update');
add_action('save_post', 'title_colour_update');
add_action('edit_page_form', 'title_colour_update');



//Function: Colour The Title
add_filter('the_title', 'colour_the_title');
function colour_the_title($content) {
$key = 'title_colour_hex';
$the_title_colour = get_post_meta($post->ID, $key, true);
	global $post;
if(strlen(get_post_meta($post->ID, $key, true))<7){return $content;} else {$content = '<font color="'.get_post_meta($post->ID, 'title_colour_hex', true).'">'.$content.'</font>'; return $content;}
	
}


?>