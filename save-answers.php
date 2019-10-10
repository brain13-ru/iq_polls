<?php
	include_once($_POST['wp_load_path']);
	global $wpdb;
	if(!is_user_logged_in()){
      echo "Вы не авторизованы. ";
      wp_loginout($_POST['path_back']);
	}
	else{

		/*echo "<pre>";
		print_r($_SESSION['answers']);
		echo "</pre>";

		echo "<pre>";
		print_r($_SESSION['answers_ids']);
		echo "</pre>";

		echo "<pre>";
		print_r($_SESSION['bonus']);
		echo "</pre>";*/


		$user_id=get_current_user_id();
		$user_info=get_userdata($user_id);
		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
		   $ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
		   $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
		   $ip = $_SERVER['REMOTE_ADDR'];
		}

		$table_name=$wpdb->get_blog_prefix().'iqp_questions';
        $questions=$wpdb->get_results("SELECT * FROM ".$table_name." WHERE poll_id=".$_POST['poll_id']." ORDER BY number");


		$table_name=$wpdb->get_blog_prefix().'iqp_answers';

        foreach ($_SESSION['answers'] as $key => $value) {
        	if(!is_numeric($key)) continue;
        	$wpdb->query($wpdb->prepare("INSERT INTO ".$table_name." (user_id,ip,poll_id,quest_id,answer_var_id,bonus) VALUES (%d,%s,%d,%d,%d,%d)",$user_id,$ip,$_POST['poll_id'],$questions[$key]->id,$_SESSION['answers_ids'][$key],$_SESSION['bonus'][$key]));

           
        }


        $table_name=$wpdb->get_blog_prefix().'iqp_users_totals';
        $total_row=$wpdb->get_row("SELECT * FROM ".$table_name." WHERE user_id=".$user_id,ARRAY_A);
        if($total_row==null){
        	$wpdb->query($wpdb->prepare("INSERT INTO ".$table_name." (user_id,total) VALUES (%d,%d)",$user_id,$_POST['total']));	
        }
        else{
        	$cur_total=$total_row['total'];
        	$wpdb->update($table_name,array('user_id'=>$user_id,'total'=>($cur_total+$_POST['total'])),array('ID'=>$total_row['id']));
        }

        $_SESSION['answers']=array();
		$_SESSION['answers_ids']=array();
		$_SESSION['bonus']=array();

        wp_redirect(site_url( '?post_type=iq_polls'));


	}

?>