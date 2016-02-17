<?php
/*
	Plugin Name: q2apro Popular questions widget
	Plugin Author: q2apro
*/

	class q2apro_popular_questions_admin
	{

		function option_default($option)
		{
			switch($option) {
				case 'q2apro_popularqu_enabled':
					return 1;
				case 'q2apro_popularqu_maxqu':
					return 7;
				case 'q2apro_popularqu_lastdays':
					return 3;
				case 'q2apro_popularqu_checkdate':
					return false; // true
				default:
					return null;				
			}
		}
			
		function allow_template($template)
		{
			return ($template!='admin');
		}       
			
		function admin_form(&$qa_content)
		{                       

			// process the admin form if admin hits Save-Changes-button
			$ok = null;
			if (qa_clicked('q2apro_popularqu_save'))
			{
				qa_opt('q2apro_popularqu_enabled', (bool)qa_post_text('q2apro_popularqu_enabled')); // empty or 1
				qa_opt('q2apro_popularqu_maxqu', (int)qa_post_text('q2apro_popularqu_maxqu'));
				qa_opt('q2apro_popularqu_lastdays', (int)qa_post_text('q2apro_popularqu_lastdays'));
				$ok = qa_lang('admin/options_saved');
				
				// in case the options have been changed, update the widget
				q2apro_save_most_viewed_questions();
			}
			
			// form fields to display frontend for admin
			$fields = array();
			
			$fields[] = array(
				'type' => 'checkbox',
				'label' => qa_lang('q2apro_popularqu_lang/enable_plugin'),
				'tags' => 'name="q2apro_popularqu_enabled"',
				'value' => qa_opt('q2apro_popularqu_enabled'),
			);
			
			$fields[] = array(
				'type' => 'input',
				'label' => qa_lang('q2apro_popularqu_lang/admin_maxqu'),
				'tags' => 'name="q2apro_popularqu_maxqu"',
				'value' => qa_opt('q2apro_popularqu_maxqu'),
			);
			
			$fields[] = array(
				'type' => 'input',
				'label' => qa_lang('q2apro_popularqu_lang/admin_lastdays'),
				'tags' => 'name="q2apro_popularqu_lastdays"',
				'value' => qa_opt('q2apro_popularqu_lastdays'),
			);
			
			$fields[] = array(
				'type' => 'static',
				'note' => '<span style="font-size:75%;color:#789;">'.strtr( qa_lang('q2apro_popularqu_lang/contact'), array( 
							'^1' => '<a target="_blank" href="http://www.q2apro.com/forum/">',
							'^2' => '</a>'
						  )).'</span>',
			);
			
			$fields[] = array(
				'type' => 'static',
				'note' => 'Remember, you need to add the widget to your site layout at <a href="'.qa_path('admin/layout').'">/admin/layout</a>',
			);
			
			return array(           
				'ok' => ($ok && !isset($error)) ? $ok : null,
				'fields' => $fields,
				'buttons' => array(
					array(
						'label' => qa_lang('main/save_button'),
						'tags' => 'name="q2apro_popularqu_save"',
					),
				),
			);
		}
	}


/*
	Omit PHP closing tag to help avoid accidental output
*/