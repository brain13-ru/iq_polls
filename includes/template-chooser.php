<?php  

function iqp_template_chooser( $template_path ) {

    $path= plugin_dir_path( __FILE__ );
    $pos=strrpos($path,"includes");
    $path=substr($path,0,$pos);
    
 
   if ( get_post_type() == 'iq_polls' ) {
        if ( is_single() ) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( 'single-iq_polls.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = $path. 'template\single-iq_polls.php';
            }
        }
        else{
            if ( $theme_file = locate_template( array ( 'iq_polls.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = $path . 'template\iq_polls.php';
            }
        }
    }
    return $template_path;
 
}

?>