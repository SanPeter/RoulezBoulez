<?php
    /*
    Plugin Name: ThemeTrust Shortcodes
    Plugin URI: http://themetrust.com/plugin/shortcodes
    Description: Enables shortcodes for all ThemeTrust themes.
    Author: ThemeTrust
    Version: 1.2
    Author URI: http://www.themetrust.com
    License: GPL2

    Copyright 2014  ThemeTrust  (email : support@themetrust.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA


    Some code was adapted from Twitter Bootstrap, available at http://getbootstrap.com/
    */

// Get plugin URL for use in the class
$thispluginurl = WP_PLUGIN_URL . '/' . dirname( plugin_basename( __FILE__ ) ) . '/';

// Require the gfonts picker class
require_once('inc/tt_sc.class.php');

// Instantiate the class
$TT_Sc = new TT_Sc( $thispluginurl );

?>