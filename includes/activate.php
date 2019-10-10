<?php
	function iqp_activate_plugin(){
		if(version_compare(get_bloginfo('version'),'4.2','<')){
			wp_die(__('You must update WordPress to use this plugin','iq_polls'));
		}
		global $wpdb;
		require(ABSPATH.'/wp-admin/includes/upgrade.php');
		$table_name=$wpdb->get_blog_prefix().'iqp_questions';
		$createSQL="CREATE TABLE {$table_name} ( `id` BIGINT(20) NOT NULL AUTO_INCREMENT ,  `poll_id` BIGINT(20) NOT NULL ,  `text` VARCHAR(1500) NOT NULL , `prev_quest` BIGINT(20) NOT NULL , `next_quest` BIGINT(20) NOT NULL , `picture` VARCHAR(250), `number` BIGINT(20) NOT NULL,   PRIMARY KEY  (`id`)) ENGINE = InnoDB";		
		dbDelta($createSQL);
		$table_name=$wpdb->get_blog_prefix().'iqp_answers_vars';
		$createSQL="CREATE TABLE {$table_name} ( `id` BIGINT(20) NOT NULL AUTO_INCREMENT ,  `poll_id` BIGINT(20) NOT NULL ,  `quest_id` BIGINT(20) NOT NULL, `text` VARCHAR(250) NOT NULL ,  `next_quest` BIGINT(20) NOT NULL ,`bonus` INT(20) NOT NULL ,    PRIMARY KEY  (`id`)) ENGINE = InnoDB";		
		dbDelta($createSQL);
		$table_name=$wpdb->get_blog_prefix().'iqp_answers';
		$createSQL="CREATE TABLE {$table_name} ( `id` BIGINT(20) NOT NULL AUTO_INCREMENT ,  `user_id` BIGINT(20) NOT NULL, `ip` VARCHAR(80) NOT NULL, `poll_id` BIGINT(20) NOT NULL ,  `quest_id` BIGINT(20) NOT NULL,  `answer_var_id` BIGINT(20) NOT NULL,  `bonus` INT(20) NOT NULL ,    PRIMARY KEY  (`id`)) ENGINE = InnoDB";		
		dbDelta($createSQL);
		$table_name=$wpdb->get_blog_prefix().'iqp_users_totals';
		$createSQL="CREATE TABLE {$table_name} ( `id` BIGINT(20) NOT NULL AUTO_INCREMENT ,  `user_id` BIGINT(20) NOT NULL, `total` INT(20) NOT NULL ,  PRIMARY KEY  (`id`)) ENGINE = InnoDB";
		dbDelta($createSQL);
	}	
?>