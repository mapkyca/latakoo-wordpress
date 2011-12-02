<?php
/*
Plugin Name: Latakoo Wordpress
Plugin URI: https://github.com/mapkyca/latakoo-wordpress
Description: Quickly and easily add Latakoo Flight videos to your blog posts.
Version: 1.0
Author: Marcus Povey
Author URI: http://www.marcus-povey.co.uk
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

define('LATAKOOWORDPRESS_VERSION', '1.0');

/**
 * Init the  plugin
 */
function latakoowp_init()
{
    // TODO: Any initialisation
}

/**
 * Latakoo shortcode handler
 */
function latakoowp_shortcode($attr, $content)
{
    // Get attributes
    $attr = shortcode_atts(array(
	    'usedev' => 'no', // Use the dev server
	    'width' => 598,
	    'height' => 336,
    ), $attr);

    // Get the Latakoo video ID
    if ( preg_match( '|/([0-9]+)/?$|', $content, $match) ) {
	    $id = $match[1]; // Just code given
    } else {
	    $id = $content; // Url given
    }
    
    $playerID = rand(0,999999); // Each player must be unique
    $url_base = 'http://latakoo.com/';
    
    if ($attr['usedev'] == 'yes') $url_base = 'http://dev.latakoo.com/';

    ob_start();
?>
<iframe id="_player<?php echo $playerID;?>" name="_player<?php echo $playerID;?>" 
	src="<?php echo $url_base; ?>-/videoembed/<?php echo $id; ?>/" 
	scrolling="no" marginwidth="0" marginheight="0" frameborder="0" vspace="0" hspace="0"
	width="<?php echo $attr['width']; ?>" height="<?php echo $attr['height']; ?>"></iframe>
<?php
    return ob_get_clean();
}

// Listen for init and header requests
add_action('init', 'latakoowp_init');

// Add shortcodes
add_shortcode('latakoo', 'latakoowp_shortcode');
