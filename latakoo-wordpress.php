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
<object width="<?php echo $attr['width']; ?>" height="<?php echo $attr['height']; ?>" id="_player<?php echo $playerID;?>" name="_player<?php echo $playerID;?>" data="<?php echo $url_base; ?>flowplayer/flowplayer.commercial-3.2.5.swf" type="application/x-shockwave-flash"><param name="movie" value="<?php echo $url_base; ?>flowplayer/flowplayer.commercial-3.2.5.swf" /><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="flashvars" value='config={"key":"#$dcea44655fdef425c1b", "playlist":[{"url":"<?php echo $url_base; ?>/-/video/<?php echo $id; ?>/thumb.jpg","autoplay":true},{"url":"<?php echo $url_base; ?>/-/video/<?php echo $id; ?>/retrieve","autoPlay":false,"autoBuffering":false}],"clip":{"url":"<?php echo $url_base; ?>-/video/<?php echo $id; ?>/retrieve", "scaling":"fit"}}' /></object>

<?php
    return ob_get_clean();
}

// Listen for init and header requests
add_action('init', 'latakoowp_init');

// Add shortcodes
add_shortcode('latakoo', 'latakoowp_shortcode');
