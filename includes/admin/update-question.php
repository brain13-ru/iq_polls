<?php
	
    include($_POST['wp_load_path']);
	global $wpdb;
	
	$table_name=$wpdb->get_blog_prefix().'iqp_questions';
	$question=$wpdb->get_row("SELECT * FROM ".$table_name." WHERE id=".$_POST['quest_id'],ARRAY_A);
	$old_prev=$question['prev_quest'];
	$old_next=$question['next_quest'];
	$wpdb->update($table_name,array('poll_id'=>$_POST['poll_id'],'text'=>$_POST['text'],'picture'=>$_POST['picture_file_name'],'number'=>$_POST['number']), array('ID'=>$_POST['quest_id']));
	$cur_id=$_POST['quest_id'];
	/*if(isset($_POST['prev_quest'])){
		$id_prev=$_POST['prev_quest'];
		if($old_prev!==$id_prev){
			$wpdb->update($table_name,array('next_quest'=>0), array('ID'=>$old_prev));
			if($id_prev!==0){
				$wpdb->update($table_name,array('next_quest'=>$cur_id), array('ID'=>$id_prev));
			}
		}		
	}

	if(isset($_POST['next_quest'])){
		$id_next=$_POST['next_quest'];
		if($old_next!==$id_next){
			$wpdb->update($table_name,array('prev_quest'=>0), array('ID'=>$old_next));
			if($id_next!==0){
				$wpdb->update($table_name,array('prev_quest'=>$cur_id), array('ID'=>$id_next));
			}
		}
	}*/
	
    wp_redirect(admin_url( ' post.php?post='.$_POST['poll_id']).'&action=edit');
?>