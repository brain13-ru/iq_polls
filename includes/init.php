<?php 
	function iqp_init(){

		if(!session_id()) {
			session_start();
		}

		$args=array(
			'labels'=>array(
				'name'=>'Тесты'
			),
			'labels' => array(
	                'name' => __('Tests and polls','iq_polls'),
	                'singular_name' => __('Test','iq_polls'),
	                'add_new' => __('Add test','iq_polls'),
	                'add_new_item' =>  __('Add test','iq_polls'),
	                'edit' =>  __('Edit','iq_polls'),
	                'edit_item' =>  __('Edit test','iq_polls'),
	                'new_item' =>  __('New test','iq_polls'),
	                'view' =>  __('View','iq_polls'),
	                'view_item' =>  __('View test','iq_polls'),
	                'search_items' =>  __('Search test','iq_polls'),
	                'not_found' =>  __('No test','iq_polls'),
	                'not_found_in_trash' =>  __('No test in trash','iq_polls'),
	            ),
			'public' =>true,
			'has_archive'=>true,
			//'show_in_menu'=>false,
			'show_in_menu'=>true,
			'taxonomies'=>array('subject'),

			//'supports'=>array('title','editor','author','thumbnail','comments' ) 
			'supports'=>array('title','editor','author','thumbnail') 
		);
		register_post_type('iq_polls', $args);
		register_taxonomy('subject','iq_polls',array('hierarhical'=>true, 'label'=>__('Polls topics','iq_polls'),'query_var'=>true,'rewrite'=>true ));
		

		
		
	}

	function end_session() {
		session_destroy ();
	}

	
?>