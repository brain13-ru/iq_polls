<?php
	
    include_once($_POST['wp_load_path']);
	global $wpdb;
	$table_name=$wpdb->get_blog_prefix().'iqp_answers_vars';
	
    $wpdb->update($table_name,array('poll_id'=>$_POST['poll_id'],'quest_id'=>$_POST['quest_id'],'text'=>$_POST['text'],'bonus'=>$_POST['bonus']), array('ID'=>$_POST['answer_var_id']));
    wp_redirect(admin_url( 'admin.php?page=iqp_edit_question&quest="'.$_POST['quest_id']));
?>