<?php
	function iqp_metabox($poll){
		global $wpdb;
		$table_name=$wpdb->get_blog_prefix().'iqp_questions';
		$questions=$wpdb->get_results("SELECT * FROM ".$table_name." WHERE poll_id='".$poll->ID."' ORDER BY number");
		echo "<a href='admin.php?page=iq_new_question&poll_id=".$poll->ID."'>".__("Add question","iq_polls")."</a>";
		echo "<ol>";
        foreach($questions as $quest) {
		   echo "<li>".$quest->text."&nbsp;<a href='admin.php?page=iqp_edit_question&quest=".$quest->id."'>Редактировать</a>&nbsp;<a href='admin.php?page=iqp_delete_question&quest=".$quest->id."'>Удалить</a></li>";
          
		} 
		echo "</ol>";
	}
?>