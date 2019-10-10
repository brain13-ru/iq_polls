<?php
	function iqp_settings_page(){
		global $wpdb;
		$polls=$wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_type='iq_polls'");
				     	
		echo '<h3>'.__("Options page","iq_polls").'</h3>'.
		'<h4>Опросы</h4><a href="post-new.php?post_type=iq_polls">'.__("Add poll","iq_polls").'</a><ul>';
		foreach($polls as $poll) {
		   echo "<li>".$poll->post_title."&nbsp;<a href='post.php?post=".$poll->ID."&action=edit'>".__("Edit","iq_polls")."</a>&nbsp;<a href='post.php?post=".$poll->ID."&action=trash'>".__("Delete","iq_polls")."</a></li>";
          
		} 
	    echo "</ul>";
		
	}
?>
