<?php

	function iqp_new_question_page(){
		$path = get_home_path(); 
		$path = wp_normalize_path ($path);
		global $wpdb;

		$cur_poll=0;
		if(isset($_GET['poll_id'])){
			$cur_poll=$_GET['poll_id'];
		}
		
		
		?>
		<h3>Добавление нового вопроса</h3>
		<form action="<?php echo plugins_url( 'add-question.php',__FILE__ )?>" method="post">
			
			<input type="hidden" name="poll_id" value="<?php echo $cur_poll;?>"/>
			<div class ="form-group">
				<label for="text"><?php echo __("Question text","iq_polls"); ?></label><br>
				<textarea name="text" value="id" cols="120" rows="5"></textarea>
			</div>

			<div class ="form-group">
				<label for="picture"><?php echo __("Picture","iq_polls"); ?></label>
				<input type="file" name="picture" accept="image/*">
			</div>
			<div><img src="" id="picture" width="400px"/></div>
			<input type="hidden" name="picture_file_name" id="picture_file_name" value=""/>

			<div class ="form-group">
				<label for="number"><?php echo __("Number of the question in the poll","iq_polls"); ?></label><br>
				<input type="number" name="number"/></textarea>
			</div>

			<input type="hidden" name="wp_load_path" value="<?php echo $path.'/wp-load.php';?>" />
			<div class ="form-group">
				<button type="submit"><?php echo __("Save","iq_polls"); ?></button>
			</div>
        </form>
	
     <?php		
	}

	function iqp_new_question_page_old(){
		$path = get_home_path(); 
		$path = wp_normalize_path ($path);
		global $wpdb;

		$cur_poll=0;
		if(isset($_GET['poll_id'])){
			$cur_poll=$_GET['poll_id'];
		}
		
		$polls=$wpdb->get_results("SELECT * FROM ".$wpdb->posts." WHERE post_type='iq_polls'");
		$table_name=$wpdb->get_blog_prefix().'iqp_questions';
		if($cur_poll==0){
			$questions=$wpdb->get_results("SELECT * FROM ".$table_name);
		}
		else {
			$questions=$wpdb->get_results("SELECT * FROM ".$table_name." WHERE poll_id=".$cur_poll);
		}
		
		?>
		<h3>Добавление нового вопроса</h3>
		<form action="<?php echo plugins_url( 'add-question.php',__FILE__ )?>" method="post">
			<div class ="form-group">
				<label for="poll_id"><?php echo __("Опрос","iq_polls"); ?></label>
				<select class="form-control" name="poll_id" id="poll_id">
					<option disabled value='0'>Выберите опрос</option>
				<?php
					foreach($polls as $poll){
						$selected=($poll->ID==$cur_poll)?" selected ":"";
						echo "<option value='".$poll->ID."' ".$selected.">".$poll->post_title."</option>";
				}
				?>	
				</select>
			</div>
			<div class ="form-group">
				<label for="text"><?php echo __("Текст вопроса","iq_polls"); ?></label><br>
				<textarea name="text" value="id" cols="120" rows="5"></textarea>
			</div>

			<div class ="form-group">
				<label for="picture"><?php echo __("Картинка","iq_polls"); ?></label>
				<input type="file" name="picture" accept="image/*">
			</div>
			<div><img src="" id="picture" width="400px"/></div>
			<input type="hidden" name="picture_file_name" id="picture_file_name" value=""/>

			<div class ="form-group">
				<label for="prev_quest"><?php echo __("Предыдущий вопрос","iq_polls"); ?></label>

				<select class="form-control" name="prev_quest" id="prev_quest">
					<option disabled value='0'>Выберите  предыдущий вопрос (если есть)</option>	
				<?php
				foreach($questions as $quest){
					echo "<option value='".$quest->id."'>".$quest->text."</option>";
				}
				echo "<option value='0' selected>Не выбран</option>";
				?>	
				</select>
			</div>

			

			<a href="#" class="upload_files button" id="upload_files">Загрузить файлы</a>
			<div class="ajax-reply"></div>

			<div class ="form-group">
				<label for="next_quest"><?php echo __("Следующий вопрос","iq_polls"); ?></label>
				<select class="form-control" name="next_quest" id="next_quest">
					<option disabled value='0'>Выберите  следующий вопрос (если есть)</option>
				<?php
				foreach($questions as $quest){

					echo "<option value='".$quest->id."'>".$quest->text."</option>";
				}

				echo "<option value='0' selected>Не выбран</option>";
				?>	
				</select>
			</div>
            

			<input type="hidden" name="wp_load_path" value="<?php echo $path.'/wp-load.php';?>" />
			<div class ="form-group">
				<button type="submit">Сохранить</button>
			</div>
        </form>
	
     <?php		
	}

	function iqp_edit_question_page(){
		$path = get_home_path(); 
		$path = wp_normalize_path ($path);
		global $wpdb;


		$cur_quest=0;
		if(isset($_GET['quest'])){
			$cur_quest=$_GET['quest'];
		}
	
		$table_name=$wpdb->get_blog_prefix().'iqp_questions';
		
		$question=$wpdb->get_row("SELECT * FROM ".$table_name." WHERE id=".$cur_quest,ARRAY_A);
	
		$table_name=$wpdb->get_blog_prefix().'iqp_answers_vars';
		$answer_vars=$wpdb->get_results("SELECT * FROM ".$table_name." WHERE quest_id=".$question['id']);
		
		?>
		<h3>Редактирование вопроса</h3>
		<form action="<?php echo plugins_url( 'update-question.php',__FILE__ )?>" method="post">
			<input type="hidden" name="poll_id" value="<?php echo $question['poll_id'];?>"/>
			<div class ="form-group">
				<label for="text"><?php echo __("Answer text","iq_polls"); ?></label><br>
				<textarea name="text" id="text" cols="120" rows="5" ><?php echo $question['text'];?></textarea>
			</div>

			<div class ="form-group">
				<label for="picture"><?php echo __("Picture","iq_polls"); ?></label>
				<input type="file" name="picture" accept="image/*">
			</div>
			<a href="#" class="upload_files button" id="upload_files"><?php echo __("Upload files","iq_polls"); ?></a>
			<div class="ajax-reply"></div>
			<?php
			    if(isset($question['picture'])){
			    	$picture_path=plugins_url()."/iq_polls/uploads/".$question['picture'];
			    }	
			    else {	    	
					$picture_path="";
				}	
			?>
			<div><img src="<?php echo $picture_path;?>" id="picture" width="400px"/></div>
			<input type="hidden" name="picture_file_name" id="picture_file_name" value="<?php echo $question['picture']; ?>"/>

			<div class ="form-group">
				<label for="number"><?php echo __("Number of the question in the poll","iq_polls"); ?></label><br>
				<input type="number" name="number" value="<?php echo $question['number'];?>"/></textarea>
			</div>
			<input type="hidden" name="wp_load_path" value="<?php echo $path.'/wp-load.php';?>" />
			<input type="hidden" name="quest_id" value="<?php echo $question['id'];?>" />
			<div style="border-style: solid; border-width: 1px; border-color: grey; padding: 0px 5px 5px 10px; margin-bottom: 5px;">
				<h4><?php echo __("Answer choices","iq_polls"); ?></h4>
				<?php
					echo "<a href='admin.php?page=iqp_new_answer_var&poll_id=".$question['poll_id']."&quest_id=".$question['id']."'>".__("Add new answer choice","iq_polls")."</a>";
					echo "<ol>";
				
					foreach($answer_vars as $var){
						echo "<li>".$var->text."&nbsp;<a href='admin.php?page=iqp_edit_answer_var&answer=".$var->id."'>".__("Edit","iq_polls")."</a>&nbsp;<a href='admin.php?page=iqp_delete_answer_var&answer=".$var->id."'>Удалить</a></li>";
					}

					echo "</ol>";
				?>
			</div>
			<div class ="form-group">
				<button type="submit"><?php echo __("Save","iq_polls"); ?></button>
			</div>
        </form>
	
     <?php		
	}

	function iqp_edit_question_page_old(){
		$path = get_home_path(); 
		$path = wp_normalize_path ($path);
		global $wpdb;


		$cur_quest=0;
		if(isset($_GET['quest'])){
			$cur_quest=$_GET['quest'];
		}
		
		$polls=$wpdb->get_results("SELECT * FROM ".$wpdb->posts." WHERE post_type='iq_polls'");

		$table_name=$wpdb->get_blog_prefix().'iqp_questions';
		
		$question=$wpdb->get_row("SELECT * FROM ".$table_name." WHERE id=".$cur_quest,ARRAY_A);
		$questions=$wpdb->get_results("SELECT * FROM ".$table_name." WHERE poll_id=".$question['poll_id']);

		$table_name=$wpdb->get_blog_prefix().'iqp_answers_vars';
		$answer_vars=$wpdb->get_results("SELECT * FROM ".$table_name." WHERE quest_id=".$question['id']);
		/*echo "<pre>";
		print_r($question);
		echo "</pre>";*/
		?>
		<h3>Редактирование вопроса</h3>
		<form action="<?php echo plugins_url( 'update-question.php',__FILE__ )?>" method="post">
			<div class ="form-group">
				<label for="poll_id"><?php echo __("Опрос","iq_polls"); ?></label>
				<select class="form-control" name="poll_id" id="poll_id">
					<option disabled value='0'>Выберите опрос</option>
				<?php
					foreach($polls as $poll){
						$selected=($poll->id==$question['poll_id'])?" selected ":"";
						echo "<option value='".$poll->ID."' ".$selected.">".$poll->post_title."</option>";
				}
				?>	
				</select>
			</div>
			<div class ="form-group">
				<label for="text"><?php echo __("Текст вопроса","iq_polls"); ?></label><br>
				<textarea name="text" id="text" cols="120" rows="5" ><?php echo $question['text'];?></textarea>
			</div>

			<div class ="form-group">
				<label for="picture"><?php echo __("Картинка","iq_polls"); ?></label>
				<input type="file" name="picture" accept="image/*">
			</div>
			<a href="#" class="upload_files button" id="upload_files">Загрузить файлы</a>
			<div class="ajax-reply"></div>
			<?php
			    if(isset($question['picture'])){
			    	$picture_path=plugins_url()."/iq_polls/uploads/".$question['picture'];
			    }	
			    else {	    	
					$picture_path="";
				}	
			?>
			<div><img src="<?php echo $picture_path;?>" id="picture" width="400px"/></div>
			<input type="hidden" name="picture_file_name" id="picture_file_name" value="<?php echo $question['picture']; ?>"/>

			<div class ="form-group">
				<label for="prev_quest"><?php echo __("Предыдущий вопрос","iq_polls"); ?></label>

				<select class="form-control" name="prev_quest" id="prev_quest">
					<option disabled value='0'>Выберите  предыдущий вопрос (если есть)</option>	
				<?php
				foreach($questions as $quest){
					if($quest->id==$question['id']) continue;
					$selected=($quest->id==$question['prev_quest'])?" selected ":"";
					echo "<option value='".$quest->id."' ".$selected.">".$quest->text."</option>";
				}
				$selected=($question['prev_quest']==0)?" selected ":"";
				    echo "<option value='0' ".$selected.">Не выбран</option>";
				?>	
				</select>
			</div>
			<div class ="form-group">
				<label for="next_quest"><?php echo __("Следующий вопрос","iq_polls"); ?></label>
				<select class="form-control" name="next_quest" id="next_quest">
					<option disabled value='0'>Выберите  следующий вопрос (если есть)</option>
				<?php

				foreach($questions as $quest){
					if($quest->id==$question['id']) continue;
					$selected=($quest->id==$question['next_quest'])?" selected ":"";
					echo "<option value='".$quest->id."' ".$selected.">".$quest->text."</option>";
				}
				$selected=($question['next_quest']==0)?" selected ":"";
				    echo "<option value='0' ".$selected.">Не выбран</option>";
				?>	
				</select>
			</div>
			<input type="hidden" name="wp_load_path" value="<?php echo $path.'/wp-load.php';?>" />
			<input type="hidden" name="quest_id" value="<?php echo $question['id'];?>" />
			<div style="border-style: solid; border-width: 1px; border-color: grey; padding: 0px 5px 5px 10px; margin-bottom: 5px;">
				<h4>Варианты ответов</h4>
				<?php
					echo "<a href='admin.php?page=iqp_new_answer_var&poll_id=".$question['poll_id']."&quest_id=".$question['id']."'>Добавить вариант ответа</a>";
					echo "<ol>";
				
					foreach($answer_vars as $var){
						echo "<li>".$var->text."&nbsp;<a href='admin.php?page=iqp_edit_answer_var&answer=".$var->id."'>Редактировать</a>&nbsp;<a href='admin.php?page=iqp_delete_answer_var&answer=".$var->id."'>Удалить</a></li>";
					}

					echo "</ol>";
				?>
			</div>
			<div class ="form-group">
				<button type="submit">Сохранить</button>
			</div>
        </form>
	
     <?php		
	}

	function iqp_delete_question_page(){
		$path = get_home_path(); 
		$path = wp_normalize_path ($path);
		global $wpdb;

		$cur_quest=0;
		if(isset($_GET['quest'])){
			$cur_quest=$_GET['quest'];
		}

		$table_name=$wpdb->get_blog_prefix().'iqp_questions';		
		$question=$wpdb->get_row("SELECT * FROM ".$table_name." WHERE id=".$cur_quest,ARRAY_A);
		$cur_poll=$question['poll_id'];
		$wpdb->query("DELETE FROM ".$table_name." WHERE id=".$cur_quest);
		 
		wp_redirect(admin_url( ' post.php?post='.$cur_poll).'&action=edit');	

	}
?>