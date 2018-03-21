<?php
/*
Plugin Name: Yakuter Author Plugin (yauthor)
Description: This plugin helps you to show posts with author images
*/

// Register and load the widget
add_action( 'vc_before_init', 'vc_before_init_actions' );
 
function vc_before_init_actions() {
     
    require_once('yauthor-element.php' ); 
     
}

function yakuter_load_plugin_scripts() {
    $plugin_url = plugin_dir_url( __FILE__ );
    
    wp_enqueue_style( 'yakuterstyle1', $plugin_url . 'css/owl.carousel.min.css' );
    wp_enqueue_style( 'yakuterstyle2', $plugin_url . 'css/owl.theme.default.min.css' );
    //wp_enqueue_script( 'yjquery', $plugin_url . 'js/yakuter.jquery.min.js', array (), 1.1, true);
    wp_enqueue_script( 'owl', $plugin_url . 'js/owl.carousel.js', array ( 'jquery' ), 1.1, true);
    wp_enqueue_script( 'yscript', $plugin_url . 'js/yakuter.owl.js', array ( 'owl' ), 1.1, true);

}
add_action( 'wp_enqueue_scripts', 'yakuter_load_plugin_scripts' );


?>