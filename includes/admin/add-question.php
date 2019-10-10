<?php
	
    include($_POST['wp_load_path']);
	global $wpdb;
	$table_name=$wpdb->get_blog_prefix().'iqp_questions';
	$wpdb->query($wpdb->prepare("INSERT INTO ".$table_name." (poll_id,text,picture,number) VALUES (%d,%s,%d,%d)",$_POST['poll_id'],$_POST['text'],$_POST['picture_file_name'],$_POST['number']));
	$cur_id=$wpdb->insert_id;
	if(isset($_POST['prev_quest'])){
		$id_prev=$_POST['prev_quest'];
		if($id_prev!==0){
				$wpdb->update($table_name,array('next_quest'=>$cur_id), array('ID'=>$id_prev));
			}
	}
	if(isset($_POST['next_quest'])){
		$id_next=$_POST['next_quest'];
		if($id_next!==0){
			$wpdb->update($table_name,array('next_quest'=>$cur_id), array('ID'=>$id_next));
		}
	}
	
	//wp_redirect(admin_url( 'admin.php?page=iq_questions&poll_id='.$_POST['poll_id']));
    wp_redirect(admin_url( ' post.php?post='.$_POST['poll_id']).'&action=edit');
?>