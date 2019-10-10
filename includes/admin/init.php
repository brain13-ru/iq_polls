<?php

    include('iqp-settings-page.php');
    include('iqp-questions.php');
    include('iqp-answers-vars.php');
    include('iqp-metabox.php');

    function my_plugin_admin_scripts() {
		wp_enqueue_script( 'picture_download', plugins_url().'/iq_polls/assets/scripts/picture-download.js', array(),false,true );
	}

	function iqp_create_menu(){
		//add_menu_page('IQ tests and polls','IQ Polls','edit_others_posts','iq_polls','iqp_settings_page','');

		$page1=add_submenu_page( null, __('Add question','iq_polls'), __('Add question','iq_polls'), 'edit_others_posts', 'iq_new_question', 'iqp_new_question_page');
		$page2=add_submenu_page( null, __('Edit question','iq_polls'), __('Edit question','iq_polls'), 'edit_others_posts', 'iqp_edit_question', 'iqp_edit_question_page');
		add_submenu_page( null, __('Delete question','iq_polls'), __('Delete question','iq_polls'), 'edit_others_posts', 'iq_delete_question', 'iqp_delete_question_page');
		add_submenu_page( null, __('Add answer choice','iq_polls'), __('Add answer choice','iq_polls'), 'edit_others_posts', 'iqp_new_answer_var', 'iqp_new_answer_var_page');
		add_submenu_page( null, __('Edit answer choice','iq_polls'), __('Edit answer choice','iq_polls'), 'edit_others_posts', 'iqp_edit_answer_var', 'iqp_edit_answer_var_page');
		add_submenu_page( null, __('Delete answer choice','iq_polls'), __('Delete answer choice','iq_polls'), 'edit_others_posts', 'iqp_delete_answer_var', 'iqp_delete_answer_var_page');

		// Используем зарегистрированную страницу для загрузки скрипта
	    add_action( 'load-' . $page1, 'my_plugin_admin_scripts' );
	    add_action( 'load-' . $page2, 'my_plugin_admin_scripts' );
	}

	function iqp_create_metaboxes(){
		add_meta_box('iq_polls_meta_box', __('Questions of the poll','iq_polls'), 'iqp_metabox', 'iq_polls', 'advanced', 'high' );
	}

	function iqp_admin_init(){
		iqp_create_metaboxes();
		
	}
?>