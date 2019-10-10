<?php 
	include_once($_POST['wp_load_path']);
	global $wpdb;

	$table_name=$wpdb->get_blog_prefix().'iqp_answers_vars';
    $answer_var=$wpdb->get_row("SELECT * FROM ".$table_name." WHERE  id=".$_POST['answer_var'],ARRAY_A);
	$answer_vars=$wpdb->get_results("SELECT * FROM ".$table_name." WHERE quest_id=".$_POST['quest_id']);

	if(!isset($_SESSION['answers'])){
		$_SESSION['answers']=array();
		$_SESSION['answers_ids']=array();
		$_SESSION['bonus']=array();
	}
	
	$var_num=0;
	$cur=0;
	foreach($answer_vars as $a_var){
		if ($a_var->id==$_POST['answer_var']){
			$_SESSION['answers'][$_POST['quest']]=$cur+1;
			$_SESSION['answers_ids'][$_POST['quest']]=$_POST['answer_var'];
			break;
		}
		$cur++;
	}
	
	$_SESSION['bonus'][$_POST['quest']]=$answer_var['bonus'];

	$quest=$_POST['quest']+1;
	wp_redirect(site_url( '?iq_polls='.$_POST['iq_polls'].'&quest='.$quest));
?>    