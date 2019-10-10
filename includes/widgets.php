<?php 

	class iqp_show_top_widget extends WP_Widget {
		function __construct(){

			parent::__construct(
				'iqp_show_top_widget', 
				__('Top of tests users','iq_polls'),
				array( 'description' => __('View top of tests users','iq_polls'), 'classname'=>'iqp_show_top_widget_class' )
			);
		}



		function widget($args,$instance){
			echo "<h2>".__('Top of tests users','iq_polls')."</h2>";
			echo "<ol>";
			global $wpdb;
			$table_name=$wpdb->get_blog_prefix().'iqp_users_totals';		
		    $totals=$wpdb->get_results("SELECT * FROM ".$table_name." ORDER BY total DESC LIMIT 10");
		    foreach($totals as $total){
		    	$user_info=get_userdata($total->user_id);
		    	echo "<li>".$user_info->first_name." ".$user_info->last_name." ".$user_info->user_login." : ".$total->total." ".__('points','iq_polls')." </li>";
		    }
			echo "</ol>";
		}
	}

	class iqp_users_polls_widget extends WP_Widget {

		function __construct(){

			parent::__construct(
				'iqp_users_polls_widget', 
				__('Tests of current user','iq_polls'),
				array( 'description' => __('View tests of current user','iq_polls'), 'classname'=>'iqp_users_polls_class' )
			);
		}



		function widget($args,$instance){
			if(is_user_logged_in()){
				echo "<h2>Ваши опросы</h2>";
				echo "<ul>";
				global $wpdb;
				$user_id=get_current_user_id();

				$table_name=$wpdb->get_blog_prefix().'iqp_answers';		
			    $answ=$wpdb->get_results("SELECT DISTINCT poll_id FROM ".$table_name." WHERE user_id=".$user_id);
			    $polls=$wpdb->get_results("SELECT * FROM ".$wpdb->posts." WHERE post_type='iq_polls'");
			    foreach ($answ as $an_val){
                    foreach($polls as $poll){
                    	if($an_val->poll_id==$poll->ID){
                    		echo "<li><a href='".site_url()."?iq_polls=".$poll->post_name."&mode=archive&user_id=".$user_id."'>".$poll->post_title."</a></li>";
                    		break;
                    	}
                    }
			    }
				echo "</ul>";
		    }
		    else echo "";
		}
		
	}

	function iqp_register_widgets(){
		register_widget('iqp_show_top_widget');
		register_widget('iqp_users_polls_widget');
	}



?>