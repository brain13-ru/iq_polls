<?php

	function iqp_new_answer_var_page(){

		
		$path = get_home_path(); 
		$path = wp_normalize_path ($path);
		global $wpdb;

		$cur_poll=0;
		if(isset($_GET['poll_id'])){
			$cur_poll=$_GET['poll_id'];
		}

		$cur_quest=0;
		if(isset($_GET['quest_id'])){
			$cur_quest=$_GET['quest_id'];
		}
		
		
		
		$poll=$wpdb->get_row("SELECT * FROM ".$wpdb->posts." WHERE id=".$cur_poll, ARRAY_A);
		$table_name=$wpdb->get_blog_prefix().'iqp_questions';
		
		$question=$wpdb->get_row("SELECT * FROM ".$table_name." WHERE id=".$cur_quest, ARRAY_A);
		/*echo "<pre>";
		print_r($question);
		echo "</pre>";*/
		
		?>
		<h3>Тест "<?php echo $poll['post_title'];?>"</h3>
		<h3><?php echo __('Add answer choice for question','iq_polls'); ?> "<?php echo $question['text'];?>"</h3>
		<form action="<?php echo plugins_url( 'add-answer-var.php',__FILE__ )?>" method="post">
			
			<input type="hidden" name="poll_id" value="<?php echo $cur_poll; ?>"/>
			<input type="hidden" name="quest_id" value="<?php echo $cur_quest; ?>"/>
			<div class ="form-group">
				<label for="text"><?php echo __("Answer text","iq_polls"); ?></label><br>
				<input type="text" size="150" name="text" id="text"/>
			</div>
			<div class ="form-group">
				<label for="bonus"><?php echo __("Bonus","iq_polls"); ?></label><br>
				<input type="number" name="bonus" id="bonus"/>
			</div>
			<input type="hidden" name="wp_load_path" value="<?php echo $path.'/wp-load.php';?>" />
			<div class ="form-group">
				<button type="submit"><?php echo __("Save","iq_polls"); ?></button>
			</div>
        </form>
	
     <?php		
	}

	function iqp_edit_answer_var_page(){

		
		$path = get_home_path(); 
		$path = wp_normalize_path ($path);
		global $wpdb;

		
		$table_name=$wpdb->get_blog_prefix().'iqp_answers_vars';
		$answer_var=$wpdb->get_row("SELECT * FROM ".$table_name." WHERE id=".$_GET['answer'], ARRAY_A);

		$poll=$wpdb->get_row("SELECT * FROM ".$wpdb->posts." WHERE id=".$answer_var['poll_id'], ARRAY_A);
		
		$table_name=$wpdb->get_blog_prefix().'iqp_questions';
		$question=$wpdb->get_row("SELECT * FROM ".$table_name." WHERE id=".$answer_var['quest_id'], ARRAY_A);
		
		?>
		<h3>Тест "<?php echo $poll['post_title'];?>"</h3>
		<h3>Редактирование варианта ответа на вопрос "<?php echo $question['text'];?>"</h3>
		<form action="<?php echo plugins_url( 'update-answer-var.php',__FILE__ )?>" method="post">
			
			<input type="hidden" name="poll_id" value="<?php echo $answer_var['poll_id']; ?>"/>
			<input type="hidden" name="quest_id" value="<?php echo $answer_var['quest_id']; ?>"/>
			<input type="hidden" name="answer_var_id" value="<?php echo $answer_var['id']; ?>"/>
			<div class ="form-group">
				<label for="text"><?php echo __("Answer text","iq_polls"); ?></label><br>
				<input type="text" size="150" name="text" value="<?php echo $answer_var['text']; ?>" id="text"/>
			</div>
			<div class ="form-group">
				<label for="bonus"><?php echo __("Bonus","iq_polls"); ?></label><br>
				<input type="number" name="bonus" id="bonus" value="<?php echo $answer_var['bonus']; ?>" />
			</div>
			<input type="hidden" name="wp_load_path" value="<?php echo $path.'/wp-load.php';?>" />
			<div class ="form-group">
				<button type="submit"><?php echo __("Save","iq_polls"); ?></button>
			</div>
        </form>
	
     <?php		
	}

	function iqp_delete_answer_var_page(){
		$path = get_home_path(); 
		$path = wp_normalize_path ($path);
		global $wpdb;

		
		$table_name=$wpdb->get_blog_prefix().'iqp_answers_vars';		
		$cur_answer=$wpdb->get_row("SELECT * FROM ".$table_name." WHERE id=".$_GET['answer'],ARRAY_A);
		/*cho "<pre>";
		print_r($cur_answer);
		echo "</pre>";*/
		$cur_quest=$cur_answer['quest_id'];
		$wpdb->query("DELETE FROM ".$table_name." WHERE id=".$_GET['answer']);
		 
		wp_redirect(admin_url( 'admin.php?page=iqp_edit_question&quest="'.$cur_quest));	

	}
?>