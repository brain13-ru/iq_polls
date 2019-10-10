<?php
	
    include_once($_POST['wp_load_path']);
	global $wpdb;
	$table_name=$wpdb->get_blog_prefix().'iqp_answers_vars';
	$wpdb->query($wpdb->prepare("INSERT INTO ".$table_name." (poll_id,quest_id,text,bonus) VALUES (%d,%d,%s,%d)",$_POST['poll_id'],$_POST['quest_id'],$_POST['text'],$_POST['bonus']));
	

    wp_redirect(admin_url( 'admin.php?page=iqp_edit_question&quest="'.$_POST['quest_id']));
?>