<?php
add_filter( 'login_redirect', 'mj_smgt_login_redirect',10, 3 );
function mj_smgt_login_redirect($redirect_to, $request, $user )
{
	if (isset($user->roles) && is_array($user->roles)) 
	{
		$roles = ['student','teacher','parent','supportstaff'];
		foreach($roles as $role)
		{
			if (in_array($role, $user->roles))
			{ 
				$redirect_to =  home_url('?dashboard=user');
				break;
			}
		} 
	}
	return $redirect_to;
}
function mj_smgt_student_notice_board($class_name,$class_section)
{
  return $notice_list_student = get_posts(array(
			'post_type' => 'notice',
			'posts_per_page' =>3,
			'meta_query' =>  array(
			'relation' => 'OR',
			array(
			'key' => 'notice_for',
			'value' => 'all',
			'compare' => '='
			),
			array(
			'relation' => 'AND',
			array(
			'key' => 'smgt_class_id',
			'value' => $class_name,
			'compare' => '=',
			),
			array(
			'key' => 'smgt_section_id',
			'value' => $class_section,
			'compare' => '=',	
			)	

			), 
			array(
			'relation' => 'AND',
			array(
			'key' => 'notice_for',
			'value' => 'student',
			'compare' => '=',
			),
			array(
			'key' => 'smgt_class_id',
			'value' => $class_name,
			'compare' => '=',	
			)	
			),
			array(
			'relation' => 'AND',
			array(
			'key' => 'notice_for',
			'value' => 'student',
			'compare' => '=',
			)
			)
			)
			));
}
function mj_smgt_student_notice_dashbord($class_name,$class_section)
{
			return $notice_list_student = get_posts(array(
			'post_type' => 'notice',
			'posts_per_page' =>-1,
			'meta_query' =>  array(
			'relation' => 'OR',
			array(
			'key' => 'notice_for',
			'value' => 'all',
			'compare' => '='
			),
			array(
			'relation' => 'AND',
			array(
			'key' => 'smgt_class_id',
			'value' => $class_name,
			'compare' => '=',
			),
			array(
			'key' => 'smgt_section_id',
			'value' => $class_section,
			'compare' => '=',	
			)	

			), 
			array(
			'relation' => 'AND',
			array(
			'key' => 'notice_for',
			'value' => 'student',
			'compare' => '=',
			),
			array(
			'key' => 'smgt_class_id',
			'value' => $class_name,
			'compare' => '=',	
			)	
			),
			array(
			'relation' => 'AND',
			array(
			'key' => 'notice_for',
			'value' => 'student',
			'compare' => '=',
			)
			)
			)
			));
}
function mj_smgt_teacher_notice_board($class_name)
{
	$smgt_class_id=array('all',$class_name[0]);
	return $notice_list_teacher = get_posts(array(
			'post_type' => 'notice',
			'posts_per_page' =>3,
			'meta_query' =>  array(
				'relation' => 'OR',
				array(
				'key' => 'notice_for',
				'value' => 'all',
				'compare' => '='
				), 
				array(
					'relation' => 'AND',
					array(
					'key' => 'notice_for',
					'value' => 'teacher',
					'compare' => '=',
					),
					array(
					'key' => 'smgt_class_id',
					'value' => $smgt_class_id,
					'compare' => 'IN',	
					)	
				)
			)
			));
}
function mj_smgt_teacher_notice_dashbord()
{
	$class_name=get_user_meta(get_current_user_id(),'class_name',true);	
  $smgt_class_id=array('all',$class_name[0]);
  return $notice_list_teacher = get_posts(array(
			'post_type' => 'notice',
			'meta_query' =>  array(
				'relation' => 'OR',
				array(
				'key' => 'notice_for',
				'value' => 'all',
				'compare' => '='
				), 
				array(
					'relation' => 'AND',
					array(
					'key' => 'notice_for',
					'value' => 'teacher',
					'compare' => '=',
					),
					array(
					'key' => 'smgt_class_id',
					'value' => $smgt_class_id,
					'compare' => 'IN',	
					)	
				)
			)
			));
}
function mj_smgt_parent_notice_board()
{
  return $notice_list_parent = get_posts(array(
			'post_type' => 'notice',
			'posts_per_page' =>3,
			'meta_query' =>  array(
			'relation' => 'AND',
			array(
			'relation' => 'OR',
			array(
			'key' => 'notice_for',
			'value' => 'all',
			'compare' => '='
			),
			
			array(
			'key' => 'notice_for',
			'value' => 'parent',
			'compare' => '=',
			)
			),
			
			)));
}
function mj_smgt_parent_notice_dashbord()
{
	$parents_child_list=get_user_meta(get_current_user_id(), 'child', true);
	$class_array = array();
	if(!empty($parents_child_list))
	{
		foreach ($parents_child_list as $user)
		{
			$class_id=get_user_meta($user, 'class_name',true);
			$class_array[]= $class_id;
		}
		$unique = array_unique($class_array);
	}
    $notice_list_parent = get_posts(array(
			'post_type' => 'notice',
			'posts_per_page' => -1,
			'meta_query' =>  array(
			'relation' => 'OR',
			//Notice for all parent and all clas//
			array(
			'relation' => 'AND',
			array(
			'key' => 'smgt_class_id',
			'value' => 'all',
			'compare' => '='
			),
			array(
			'key' => 'notice_for',
			'value' => 'parent',
			'compare' => '=',
			)
			),
			//Notice for all  and all clas//
			array(
			'relation' => 'AND',
			array(
			'key' => 'notice_for',
			'value' => 'all',
			'compare' => '='
			),
			array(
			'key' => 'smgt_class_id',
			'value' => 'all',
			'compare' => '=',
			)
			),
			//Notice for all  and  own child class//
		   array(
				'relation' => 'AND',
				array(
				'key' => 'notice_for',
				'value' => 'all',
				'compare' => '=',
				),
				array(
				'key' => 'smgt_class_id',
				'value' => $unique,
				'compare' => 'IN',	
				)	
			),
			
			array(
				'relation' => 'AND',
				array(
				'key' => 'notice_for',
				'value' => 'student',
				'compare' => '=',
				),
				array(
				'key' => 'smgt_class_id',
				'value' => $unique,
				'compare' => 'IN',	
				)	
			),
			)));

			return $notice_list_parent;
}
function mj_smgt_supportstaff_notice_board()
{
  return $notice_list_supportstaff = get_posts(array(
			'post_type' => 'notice',
			'posts_per_page' =>3,
			'meta_query' =>  array(
			'relation' => 'AND',
			array(
			'relation' => 'OR',
			array(
			'key' => 'notice_for',
			'value' => 'all',
			'compare' => '='
			),
			
			array(
			'key' => 'notice_for',
			'value' => 'supportstaff',
			'compare' => '=',
			)
			),
			
			)));
}
function mj_smgt_supportstaff_notice_dashbord()
{
  return $notice_list_supportstaff = get_posts(array(
			'post_type' => 'notice',
			'meta_query' =>  array(
			'relation' => 'AND',
			array(
			'relation' => 'OR',
			array(
			'key' => 'notice_for',
			'value' => 'all',
			'compare' => '='
			),
			array(
			'key' => 'notice_for',
			'value' => 'supportstaff',
			'compare' => '=',
			)
			),
			
			)));
}
function mj_smgt_page_access_rolewise_and_accessright()
{
	$menu = get_option( 'smgt_access_right');
	global $current_user;
	$user_roles 	= 	$current_user->roles;
	$user_role 		= 	array_shift($user_roles);
	$flage=0;
	if(!empty($menu))
	{
		foreach ( $menu as $key=>$value ) 
		{
			 if($value['page_link']==$_REQUEST['page'])
			 {
				if($value[$user_role]==0)
				{
					$flage=0;
				}
				else
				{
				   $flage=1;
				}
			}
		}
	}
	
	return $flage;
}
function mj_smgt_check_ourserver()
{
	return false;
}
function mj_smgt_check_productkey($domain_name,$licence_key,$email)
{	
	$result = '0';		
}
/* Setup form submit*/
function mj_smgt_submit_setupform($data)
{
	$domain_name= $data['domain_name'];
	$licence_key = $data['licence_key'];
	$email = $data['enter_email'];
	
	
	$result = mj_smgt_check_productkey($domain_name,$licence_key,$email);
	if($result == '1')
	{
		$message = esc_attr__('Please provide correct Envato purchase key.','school-mgt');
			$_SESSION['cmgt_verify'] = '1';
	}
	elseif($result == '2')
	{
		$message = esc_attr__('This purchase key is already registered with the different domain. If have any issue please contact us at sales@mojoomla.com','school-mgt');
			$_SESSION['cmgt_verify'] = '2';
	}
	elseif($result == '3')
	{
		$message = esc_attr__('There seems to be some problem please try after sometime or contact us on sales@mojoomla.com','school-mgt');
			$_SESSION['cmgt_verify'] = '3';
	}
	elseif($result == '4')
	{
		$message = esc_attr__('Please provide correct Envato purchase key for this plugin.','school-mgt');
			$_SESSION['cmgt_verify'] = '1';
	}
	else
	{
		update_option('domain_name',$domain_name,true);
		update_option('licence_key',$licence_key,true);
		update_option('cmgt_setup_email',$email,true);
		$message = 'Success fully register';
			$_SESSION['cmgt_verify'] = '0';
	}	
	$result_array = array('message'=>$message,'cmgt_verify'=>$_SESSION['cmgt_verify']);
	return $result_array;
}
/* check server live */
function mj_smgt_chekserver($server_name)
{
	if($server_name == 'localhost')
	{
		return true;
	}		
}
/*Check is_verify*/
function mj_smgt_check_verify_or_not($result)
{		
	$server_name = $_SERVER['SERVER_NAME'];
	$current_page = isset($_REQUEST['page'])?$_REQUEST['page']:'';
	$pos = strrpos($current_page, "smgt_");	
	if($pos !== false)			
	{ 	 
		if($server_name == 'localhost')
		{
			return true;
		}
		else
		{ 
			if($result == '0')
			{
				return true;
			}
		}	
		return false;
	}
	
}
function mj_smgt_is_cmgtpage()
{
	$current_page = isset($_REQUEST['page'])?$_REQUEST['page']:'';
	$pos = strrpos($current_page, "smgt_");	
	
	if($pos !== false)			
	{
		return true;
	}
	return false;
}


//Function File
//-----------INSERT NEW RECORD IN CUSOTOM TABLE------------
$obj_attend=new Attendence_Manage();
function mj_smgt_datatable_multi_language()
{
	$datatable_attr=array("sEmptyTable"=> esc_attr__("No data available in table","school-mgt"),
		"sInfo"=> esc_attr__("Showing _START_ to _END_ of _TOTAL_ entries","school-mgt"),
		"sInfoEmpty"=> esc_attr__("Showing 0 to 0 of 0 entries","school-mgt"),
		"sInfoFiltered"=> esc_attr__("(filtered from _MAX_ total entries)","school-mgt"),
		"sInfoPostFix"=> "",
		"sInfoThousands"=>",",
		"sLengthMenu"=> esc_attr__(" _MENU_ ","school-mgt"),
		"sLoadingRecords"=> esc_attr__("Loading...","school-mgt"),
		"sProcessing"=> esc_attr__("Processing...","school-mgt"),
		"sSearch"=>esc_attr__("","school-mgt"),
		"sZeroRecords"=> esc_attr__("No matching records found","school-mgt"),
		"Print"=> esc_attr__("Print","school-mgt"),
		"oPaginate"=>array(
			"sFirst"=> esc_attr__("First","school-mgt"),
			"sLast"=> esc_attr__("Last","school-mgt"),
			"sNext"=> esc_attr__("Next","school-mgt"),
			"sPrevious"=> esc_attr__("Previous","school-mgt")
		),
		"oAria"=>array(
			"sSortAscending"=> esc_attr__(": activate to sort column ascending","school-mgt"),
			"sSortDescending"=> esc_attr__(": activate to sort column descending","school-mgt")
		)
	);
	
	return $data=json_encode( $datatable_attr);
}
function mj_smgt_change_menutitle($key)
{
	$school_obj = new School_Management ( get_current_user_id () );
	$role = $school_obj->role;
	
	if($role=='parent' && $key=='student')
	{
		$key='child';
	}
	
	$menu_titlearray=array('general_settings'=> esc_attr__('General Settings','school-mgt'),'email_template'=> esc_attr__('Email Template','school-mgt'),'custom_field'=> esc_attr__('Custom Field','school-mgt'),'sms_setting'=> esc_attr__('SMS Setting','school-mgt'),'exam_hall'=> esc_attr__('Exam Hall','school-mgt'),'grade'=> esc_attr__('Grade','school-mgt'),'supportstaff'=> esc_attr__('Supportstaff','school-mgt'),'admission'=> esc_attr__('Admission','school-mgt'),'virtual_classroom'=> esc_attr__('Virtual Classroom','school-mgt'),'teacher'=> esc_attr__('Teacher','school-mgt'),'student'=> esc_attr__('Student','school-mgt'),'notification'=> esc_attr__('Notification','school-mgt'),'child'=> esc_attr__('Child','school-mgt'),'parent'=> esc_attr__('Parent','school-mgt'),'subject'=> esc_attr__('Subject','school-mgt'),'class'=> esc_attr__('Class','school-mgt'),'schedule'=> esc_attr__('Class Routine','school-mgt'),'attendance'=> esc_attr__('Attendance','school-mgt'),'exam'=> esc_attr__('Exam','school-mgt'),'manage_marks'=> esc_attr__('Manage Marks','school-mgt'),'migration'=> esc_attr__('Migration','school-mgt'),'feepayment'=> esc_attr__('Fee Payment','school-mgt'),'payment'=> esc_attr__('Payment','school-mgt'),'transport'=> esc_attr__('Transport','school-mgt'),'hostel'=> esc_attr__('Hostel','school-mgt'),'notice'=> esc_attr__('Notice Board','school-mgt'),'event'=> esc_attr__('Event','school-mgt'),'message'=> esc_attr__('Message','school-mgt'),'holiday'=> esc_attr__('Holiday','school-mgt'),'library'=> esc_attr__('Library','school-mgt'),'account'=> esc_attr__('Account','school-mgt'),'report'=> esc_attr__('Report','school-mgt'),'homework'=> esc_attr__('Homework','school-mgt'));
		
	return $menu_titlearray[$key];
}
function mj_smgt_approve_student_list()
{
	 $studentdata = get_users(array('meta_key' => 'hash','role'=>'student'));	
	 $inactive_student_id = wp_list_pluck( $studentdata, 'ID' );
	 return  $inactive_student_id;	 
}

function mj_smgt_get_remote_file($url, $timeout = 30)
{
	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_URL, $url);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$file_contents = curl_exec($ch);
	curl_close($ch);
	return ($file_contents) ? $file_contents : FALSE;
}

function mj_smgt_change_read_status($id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "smgt_message";
	$data['status']=1;
	$whereid['message_id']=$id;
	$retrieve_message_status = $wpdb->update($table_name,$data,$whereid);
		
	return $retrieve_message_status;
}
function mj_smgt_change_read_status_reply($id)
{
	global $wpdb;
	$smgt_message_replies = $wpdb->prefix . 'smgt_message_replies';
		
	$data['status']=1;
	$whereid['message_id']=$id;
	$whereid['receiver_id']=get_current_user_id();
	$retrieve_message_reply_status = $wpdb->update($smgt_message_replies,$data,$whereid);
	
	return $retrieve_message_reply_status;
}
function mj_smgt_get_subject_class($subject_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "subject";
	$result = $wpdb->get_row("SELECT class_id FROM $table_name where subid=$subject_id");
	return $result->class_id;
}
function mj_smgt_get_teachers_subjects($tid)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "subject";
	$result = $wpdb->get_results("SELECT * FROM $table_name where teacher_id=$tid");
	return $result;
}
function mj_smgt_get_all_student_list()
{
	$exlude_id = mj_smgt_approve_student_list();
	$student = get_users(array('role'=>'student','exclude'=>$exlude_id));
	return $student;
}

function mj_smgt_get_teacher_class_student($id)
{	
	$meta_val = get_user_meta($id,'class_name',true);	
	
	$meta_query_result =  get_users(	
		array(
			'meta_key' => 'class_name',
			'meta_value' =>$meta_val,	   
		)
	);
	return $meta_query_result;
}

function mj_smgt_check_class_exits_in_teacher_class($id)
{	
	$TeacherData = get_users(array('role'=>'teacher'));
	$Teacher = array();
	
	// if(!empty($TeacherData))
	// {
	// 	foreach($TeacherData as $teacher)
	// 	{
	// 		$TeacherClass = get_user_meta($teacher->ID,'class_name',true);
	// 		if(in_array($id,$TeacherClass))
	// 		{
	// 			$Teacher[] = $teacher->ID;			
	// 		}
	// 	}
	// }
	// return $Teacher;

	if(!empty($TeacherData))
	{
		foreach($TeacherData as $teacher)
		{
			$TeacherClass = get_user_meta($teacher->ID,'class_name',true);
			if (is_array($TeacherClass)) {
					if(in_array($id,$TeacherClass))
					{
						$Teacher[] = $teacher->ID;			
					}
				}
		}
	}
	return $Teacher;
} 

function mj_smgt_get_all_student_list_class()
{
	$exlude_id = mj_smgt_approve_student_list();
	$student = get_users(array('role'=>'student','exclude'=>$exlude_id));
	return $student;
}

function mj_smgt_get_all_user_in_message()
{
	$school_obj = new School_Management ( get_current_user_id () );
	$teacher = get_users(array('role'=>'teacher'));
	$parent = get_users(array('role'=>'parent'));
	$exlude_id = mj_smgt_approve_student_list();
	$student = get_users(array('role'=>'student','exclude'=>$exlude_id));
	
	$supportstaff = get_users(array('role'=>'supportstaff'));
	
	$parents_child_list=get_user_meta(get_current_user_id(), 'child', true);

	$all_user = array(
		'student'=>$student,
		'teacher'=>$teacher,
		'parent'=>$parent,
		'supportstaff'=>$supportstaff		
	);
	
	if($school_obj->role == 'administrator' || $school_obj->role == 'teacher')
	{
		$all_user = array(
			'student'=>$student,
			'teacher'=>$teacher,
			'parent'=>$parent,
			'supportstaff'=>$supportstaff
		);
	}
	if($school_obj->role == 'parent')
		if(get_option('parent_send_message'))
		{
			if(!empty($parents_child_list))
			{
				$class_array = array();
				foreach ($parents_child_list as $user)
				{
					$class_id=get_user_meta($user, 'class_name',true);
					$class_array[]= $class_id;
				}
				$unique = array_unique($class_array);
				$student = array();
				if(!empty($unique))
					foreach($unique as $class_id)
						$student[]=get_users(array('role'=>'student','meta_key' => 'class_name', 'meta_value' => $class_id));
			
			
			}
			
			$all_user = array(
				'student'=>$student,
				'teacher'=>$teacher,
				'parent'=>$parent,
				'supportstaff'=>$supportstaff
			);			
		}
		else 
		{
			$all_user = array(
				'teacher'=>$teacher,
				'parent'=>$parent,
				'supportstaff'=>$supportstaff
			);
		}
		
	if(get_option('student_send_message'))
	if($school_obj->role == 'student')
	{
		$school_obj->class_info = $school_obj->mj_smgt_get_user_class_id(get_current_user_id());
		$student = $school_obj->mj_smgt_get_student_list($school_obj->class_info->class_id);
		$all_user = array('student'=>$student);
	}
	$return_array = array();
	foreach($all_user as $key => $value)
	{
		if(!empty($value))
		{
		 echo '<optgroup label="'.$key.'" style = "text-transform: capitalize;">';
		 foreach($value as $user)
		 {
		 	if(get_option('parent_send_message'))
			 	if($key == 'student' && $school_obj->role == 'parent')
			 	{
			 		foreach($user as $student_class)
			 		{
			 			echo '<option value="'.$student_class->ID.'">'.$student_class->display_name.'</option>';
			 		}
			 	}
			 	else 
			 	echo '<option value="'.$user->ID.'">'.$user->display_name.'</option>';
			 else 
			 	echo '<option value="'.$user->ID.'">'.$user->display_name.'</option>';
		 }
		}
	}
}
function mj_smgt_send_replay_message($data)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "smgt_message_replies";
	
	$upload_docs_array=array();	
	if(!empty($_FILES['message_attachment']['name']))
	{
		$count_array=count($_FILES['message_attachment']['name']);

		for($a=0;$a<$count_array;$a++)
		{			
			foreach($_FILES['message_attachment'] as $image_key=>$image_val)
			{		
				$document_array[$a]=array(
				'name'=>$_FILES['message_attachment']['name'][$a],
				'type'=>$_FILES['message_attachment']['type'][$a],
				'tmp_name'=>$_FILES['message_attachment']['tmp_name'][$a],
				'error'=>$_FILES['message_attachment']['error'][$a],
				'size'=>$_FILES['message_attachment']['size'][$a]
				);							
			}
		}				
		foreach($document_array as $key=>$value)		
		{	
			$get_file_name=$document_array[$key]['name'];	
			
			$upload_docs_array[]=mj_smgt_load_multiple_documets($value,$value,$get_file_name);				
		} 				
	}
	$upload_docs_array_filter=array_filter($upload_docs_array);	
	if(!empty($upload_docs_array_filter))
	{
		$attachment=implode(',',$upload_docs_array_filter);
	}
	else
	{
		$attachment='';
	}
	$result='';
	
	if(!empty($data['receiver_id']))
	{
		foreach($data['receiver_id'] as $receiver_id)
		{
			$messagedata['message_id'] = $data['message_id'];
			$messagedata['sender_id'] = $data['user_id'];
			$messagedata['receiver_id'] = $receiver_id;
			$messagedata['message_comment'] = $data['replay_message_body'];
			$messagedata['message_attachment'] =$attachment;
			$messagedata['status'] =0;
			$messagedata['created_date'] = date("Y-m-d h:i:s");
			$result=$wpdb->insert( $table_name, $messagedata );
			if($result)	
			{
				$SchoolName 	=  	get_option('smgt_school_name');
				$SubArr['{{school_name}}'] 	= $SchoolName;
				$SubArr['{{from_mail}}'] = mj_smgt_get_display_name($data['user_id']);
				$MailSub = mj_smgt_string_replacement($SubArr,get_option('message_received_mailsubject'));
				
				$user_info = get_userdata($receiver_id);
				$to = $user_info->user_email;    
				
				$MailBody  = get_option('message_received_mailcontent');	
				$MesArr['{{receiver_name}}']	= 	mj_smgt_get_display_name($receiver_id);	
				$MesArr['{{message_content}}']	=	$data['replay_message_body'];
				$MesArr['{{school_name}}']		=	$SchoolName;
				$messg = mj_smgt_string_replacement($MesArr,$MailBody);
				if(get_option('smgt_mail_notification') == '1')
				{
					wp_mail($to, $MailSub, $messg); 
				}					
			}
		}
	}
			if($result)	
				return $result;
}
function mj_smgt_get_all_replies($id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "smgt_message_replies";
	return $result =$wpdb->get_results("SELECT * FROM $table_name where message_id = $id GROUP BY message_id,sender_id,message_comment ORDER BY id ASC");
}
function mj_smgt_get_all_replies_frontend($id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "smgt_message_replies";
	return $result =$wpdb->get_results("SELECT *  FROM $table_name where message_id = $id");
}

function mj_smgt_delete_reply($id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "smgt_message_replies";
	$reply_id['id']=$id;
	return $result=$wpdb->delete( $table_name, $reply_id);
}
function mj_smgt_count_reply_item($id)
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'smgt_message';
	$smgt_message_replies = $wpdb->prefix .'smgt_message_replies';	
	
	$user_id=get_current_user_id();
	$inbox_sent_box =$wpdb->get_results("SELECT *  FROM $tbl_name where ((receiver = $user_id) AND (sender != $user_id)) AND (post_id = $id) AND (status=0)");
	
	$reply_msg =$wpdb->get_results("SELECT *  FROM $smgt_message_replies where (receiver_id = $user_id) AND (message_id = $id) AND ((status=0) OR (status IS NULL))");
	
	$count_total_message=count($inbox_sent_box) + count($reply_msg); 
	
	return $count_total_message; 
}
function mj_smgt_get_countery_phonecode($country_name)
{
	$url = plugins_url( 'countrylist.xml', __FILE__ );
	$xml =simplexml_load_string(mj_smgt_get_remote_file($url));
	foreach($xml as $country)
	{
		if($country_name == $country->name)
			return $country->phoneCode;
		
	}							
}
function mj_smgt_get_roles($user_id){
	$roles = array();
	$user = new WP_User( $user_id );

	if ( !empty( $user->roles ) && is_array( $user->roles ) )
	{
		foreach ( $user->roles as $role )
			 return $role;
	}

	
}

function mj_smgt_get_student_parent_id($student_id)
{
	$parent = get_user_meta($student_id, 'parent_id');
	$parent_idarray = array();
	if(!empty($parent))
	{
		foreach ($parent[0] as $parent_id)
		$parent_idarray[]=$parent_id;
	}
	return  $parent_idarray;
}
function mj_smgt_get_bookname($id)
{
	global $wpdb;
		$table_book=$wpdb->prefix.'smgt_library_book';
		$result = $wpdb->get_row("SELECT * FROM $table_book where id=".$id);
		return $result->book_name;
}
function mj_smgt_get_ISBN($id)
{
	global $wpdb;
		$table_book=$wpdb->prefix.'smgt_library_book';
		$result = $wpdb->get_row("SELECT * FROM $table_book where id=".$id);
		return $result->ISBN;
}
function mj_smgt_get_book_number($id)
{
	global $wpdb;
		$table_book=$wpdb->prefix.'smgt_library_book';
		$result = $wpdb->get_row("SELECT * FROM $table_book where id=".$id);
		return $result->book_number;
}

function mj_smgt_get_parents_child_id($parent_id)
{
	$parent = get_user_meta($parent_id, 'child');
	$parent_idarray = array();
	if(!empty($parent))
	{
		foreach ($parent[0] as $parent_id)
			$parent_idarray[]=$parent_id;
	}
	return  $parent_idarray;
}
function mj_smgt_get_user_notice($role,$class_id,$section_id=0)
{
	if($role == 'all' )
	{
		$userdata = array();
		$roles = array('teacher', 'student', 'parent','supportstaff');
		
		foreach ($roles as $role) :
		$users_query = new WP_User_Query( array(
				'fields' => 'all_with_meta',
				'role' => $role,
				'orderby' => 'display_name'
		));
		$results = $users_query->get_results();
		if ($results) $userdata = array_merge($userdata, $results);
		endforeach;
	}
	elseif($role == 'parent' )
	{
		$new =array();
		if($class_id == 'all')
		{
			$userdata=get_users(array('role'=>$role));
			
		}
		else
		{
			$userdata=get_users(array('role'=>'student','meta_key' => 'class_name', 'meta_value' => $class_id));
			foreach($userdata as $users)
			{
				$parent = get_user_meta($users->ID, 'parent_id', true);
				if(!empty($parent))
				foreach($parent as $p)
				{
					$new[]=array('ID'=>$p);
				}
			}
			$userdata =  $new;
		}
		
	}
	elseif($role == 'administrator' )
	{
		$userdata=get_users(array('role'=>$role));
	}
	else 
	{
		if($class_id == 'all'){
			$userdata=get_users(array('role'=>$role));
		}
		elseif($section_id!=0){
		$userdata = get_users(array('meta_key' => 'class_section', 'meta_value' =>$section_id,
				'meta_query'=> array(array('key' => 'class_name','value' => $class_id,'compare' => '=')),'role'=>'student'));	
		}
		else{
			$userdata=get_users(array('role'=>$role,'meta_key' => 'class_name', 'meta_value' => $class_id));
		}
	}
		
	return $userdata;
}
function mj_smgt_get_feepayment_all_record()
{
	global $wpdb;
	$smgt_fees_payment = $wpdb->prefix .'smgt_fees_payment';
	$result = $wpdb->get_results("SELECT * FROM $smgt_fees_payment where start_year != '' AND end_year != '' group by start_year,end_year");
	return $result;
}
function mj_smgt_get_payment_report($class_id,$fee_term,$sdate,$edate)
{
	$where = '';
	$array_test = array();
	if($class_id != ' ')
		$array_test[] = 'class_id = '.$class_id; 

	if($fee_term != ' ')
		$array_test[] = 'fees_id = '.$fee_term; 


	global $wpdb;
	$smgt_fees_payment = $wpdb->prefix .'smgt_fees_payment';
	$sql = "SELECT * FROM $smgt_fees_payment  ";
	$test_string = implode(" AND ",$array_test);
	$date_string=" AND paid_by_date BETWEEN '$sdate' AND '$edate'";
	$test_string .=$date_string;
	if(!empty($array_test))
	{
		$sql .= " Where "; 
	}
	 $sql .= $test_string;
	$result = $wpdb->get_results($sql);
	return $result;
	
}
///function mj_smgt_get_payment_report_front($class_id,$fee_term,$sdate,$edate)
function mj_smgt_get_payment_report_front($class_id,$fee_term,$payment_status,$sdate,$edate,$section_id)
{
	$where = '';
	$array_test = array();
	if($class_id != ' ')
		$array_test[] = 'class_id = '.$class_id; 

	if($fee_term != ' ')
		$array_test[] = 'fees_id = '.$fee_term; 
	
	if($payment_status != ' ')
		$array_test[] = 'payment_status = '.$payment_status;

	global $wpdb;
	$smgt_fees_payment = $wpdb->prefix .'smgt_fees_payment';
	$sql = "SELECT * FROM $smgt_fees_payment  ";
	$test_string = implode(" AND ",$array_test);
	$date_string=" AND paid_by_date BETWEEN '$sdate' AND '$edate'";
	$test_string .=$date_string;
	if(!empty($array_test))
	{
		$sql .= " Where "; 
	}
	 $sql .= $test_string;
	$result = $wpdb->get_results($sql);
	return $result;
	
}
function mj_smgt_insert_record($tablenm,$records)
{
	global $wpdb;
	$table_name = $wpdb->prefix . $tablenm;
	return $result=$wpdb->insert( $table_name, $records);
}
function mj_smgt_add_class_section($tablenm,$sectiondata)
{
	global $wpdb;
	$table_name = $wpdb->prefix . $tablenm;
	return $result=$wpdb->insert( $table_name, $sectiondata);
	
}
function mj_smgt_get_class_sections($id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . 'smgt_class_section';
	return $result = $wpdb->get_results("SELECT * FROM $table_name where class_id=$id");
}

function mj_smgt_get_class_sections_name($class_section_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . 'smgt_class_section';
	
	$class_sections_name =$wpdb->get_row("SELECT section_name FROM $table_name WHERE id=".$class_section_id);
	if(!empty($class_sections_name))
		return $class_sections_name->section_name;
	else
		return " ";
}

function mj_smgt_get_section_name($id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . 'smgt_class_section';
	$result = $wpdb->get_row("SELECT *FROM $table_name where id=$id");
	return $result->section_name;
}
function mj_smgt_delete_class_section($id)
{
	school_append_audit_log(''.esc_html__('Delete Class Section Detail','hospital_mgt').'',null,get_current_user_id(),'delete');
	global $wpdb;
	$table_name = $wpdb->prefix. 'smgt_class_section';
	$result = $wpdb->query("DELETE FROM $table_name where id= ".$id);
	return $result;
}
//-----------UPDATE RECORD IN CUSOTOM TABLE------------
function mj_smgt_update_record($tablenm,$data,$record_id)
{
	
	global $wpdb;
	$table_name = $wpdb->prefix . $tablenm;
	$result=$wpdb->update($table_name, $data,$record_id);
	return $result;
	
}
//-----------DELETE RECORD IN CUSOTOM TABLE------------
function mj_smgt_delete_subject($tablenm,$record_id)
{
	school_append_audit_log(''.esc_html__('Delete Subject Detail','hospital_mgt').'',null,get_current_user_id(),'delete');
	global $wpdb;
	$table_name = $wpdb->prefix . $tablenm;
	$teacher_table_name = $wpdb->prefix . 'teacher_subject';
	$wpdb->query($wpdb->prepare("DELETE FROM $teacher_table_name WHERE subject_id= %d",$record_id));
	return $result=$wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE subid= %d",$record_id));
	
}
function mj_smgt_delete_class($tablenm,$record_id)
{
	school_append_audit_log(''.esc_html__('Delete Class Detail','hospital_mgt').'',null,get_current_user_id(),'delete');
	global $wpdb;
	$table_name = $wpdb->prefix . $tablenm;
	return $result=$wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE class_id= %d",$record_id));
}
function mj_smgt_delete_grade($tablenm,$record_id)
{
	school_append_audit_log(''.esc_html__('Delete Grade Detail','hospital_mgt').'',null,get_current_user_id(),'delete');
	global $wpdb;
	$table_name = $wpdb->prefix . $tablenm;
	return $result=$wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE grade_id= %d",$record_id));
}
function mj_smgt_delete_exam($tablenm,$record_id)
{
	school_append_audit_log(''.esc_html__('Delete Exam Detail','hospital_mgt').'',null,get_current_user_id(),'delete');
	global $wpdb;
	$table_name = $wpdb->prefix . $tablenm;
	$smgt_exam_hall_receipt = $wpdb->prefix .'smgt_exam_hall_receipt';
	$smgt_exam_time_table = $wpdb->prefix .'smgt_exam_time_table';
	
	$result=$wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE exam_id= %d",$record_id));
	if($result)
	{
		$result_receipt_delete=$wpdb->query($wpdb->prepare("DELETE FROM $smgt_exam_hall_receipt WHERE exam_id= %d",$record_id));
		$result_timetable_delete=$wpdb->query($wpdb->prepare("DELETE FROM $smgt_exam_time_table WHERE exam_id= %d",$record_id));
	}
	return $result;
}
function mj_smgt_delete_usedata($record_id)
{
	school_append_audit_log(''.esc_html__('Delete User Detail','hospital_mgt').'',null,get_current_user_id(),'delete');
	global $wpdb;
	
	$table_name = $wpdb->prefix . 'usermeta';
	$result=$wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE user_id= %d",$record_id));
	$retuenval=wp_delete_user( $record_id );
	return $retuenval;
}
function mj_smgt_delete_message($tablenm,$record_id)
{
	school_append_audit_log(''.esc_html__('Delete Message Detail','hospital_mgt').'',null,get_current_user_id(),'delete');
	global $wpdb;
	$table_name = $wpdb->prefix . $tablenm;
	return $result=$wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE message_id= %d",$record_id));

}
function mj_smgt_get_class_name($cid)
{	
	global $wpdb;
	$table_name = $wpdb->prefix .'smgt_class';
	
	$classname =$wpdb->get_row("SELECT class_name FROM $table_name WHERE class_id=".$cid);
	if(!empty($classname))
		return $classname->class_name;
	else
		return " ";
}

function mj_smgt_get_fees_term_name($fees_id)
{
	global $wpdb;
	$table_smgt_fees = $wpdb->prefix .'smgt_fees';
	$classname =$wpdb->get_row("SELECT fees_title_id FROM $table_smgt_fees WHERE fees_id=".$fees_id);
	if(!empty($classname))
		return get_the_title($classname->fees_title_id);
	else
		return " ";
}

function mj_smgt_get_fees_details($fees_id)
{
	
	global $wpdb;
	$table_smgt_fees = $wpdb->prefix .'smgt_fees';
	$classname =$wpdb->get_row("SELECT * FROM $table_smgt_fees WHERE fees_id=".$fees_id);
	return $classname;
}
function mj_smgt_get_payment_status($fees_pay_id)
{
	
	global $wpdb;
	$table_smgt_fees_payment = $wpdb->prefix .'smgt_fees_payment';
	$result =$wpdb->get_row("SELECT * FROM $table_smgt_fees_payment WHERE fees_pay_id=$fees_pay_id");
	if(!empty($result))
	{	
		if($result->fees_paid_amount == 0)
		{
			return 'Not Paid';
		}
		elseif($result->fees_paid_amount < $result->total_amount)
		{
			return 'Partially Paid';
		}
		else
		{
			return 'Fully Paid';
		}
	}
	else
	{
		return "";
	}
}
function mj_smgt_get_single_fees_payment_record($fees_pay_id)
{
	global $wpdb;
	$table_smgt_fees_payment = $wpdb->prefix .'smgt_fees_payment';
	
	$result =$wpdb->get_row("SELECT * FROM $table_smgt_fees_payment WHERE fees_pay_id=".$fees_pay_id);
	return $result;
}
function mj_smgt_get_payment_history_by_feespayid($fees_pay_id)
{
	global $wpdb;
	$table_smgt_fee_payment_history = $wpdb->prefix .'smgt_fee_payment_history';
	
	$result =$wpdb->get_results("SELECT * FROM $table_smgt_fee_payment_history WHERE fees_pay_id=".$fees_pay_id);
	return $result;
}
function mj_smgt_get_user_name_byid($user_id)
{
	$user_info = get_userdata($user_id);
	if($user_info)
	return  $user_info->display_name;
}
function mj_smgt_get_display_name($user_id) {
	if (!$user = get_userdata($user_id))
		return false;
	return $user->data->display_name;
}
function mj_smgt_get_emailid_byuser_id($id)
{
	if (!$user = get_userdata($id))
		return false;
	return $user->data->user_email;
}
function mj_smgt_get_teacher($id)
{
	
	$user_info = get_userdata($id);
	if($user_info)
	 return  $user_info->first_name." ".$user_info->last_name;
}
function get_mj_smgt_payment_list()
{
	global $wpdb;
	$table_users = $wpdb->prefix .'users';
	$table_payment = $wpdb->prefix .'smgt_payment';
	return  $retrieve_paymentlist = $wpdb->get_results( "SELECT * FROM $table_users as u ,$table_payment p where u.ID = p.student_id");
	
}
function mj_smgt_get_all_data($tablenm)
{
	global $wpdb;
	$user_id=get_current_user_id ();
	$school_obj = new School_Management ($user_id);
	$table_name = $wpdb->prefix . $tablenm;
	return $retrieve_subjects = $wpdb->get_results( "SELECT * FROM ".$table_name);
}

function mj_smgt_get_all_own_subject_data($tablenm)
{
	global $wpdb;
	$user_id=get_current_user_id ();
	$school_obj = new School_Management ($user_id);
	$table_name = $wpdb->prefix . $tablenm;
	
	return $retrieve_subjects = $wpdb->get_results( "SELECT * FROM $table_name where created_by=$user_id");
}	

function mj_smgt_get_teacher_subjects($teacher_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix .'teacher_subject';
	return $retrieve_subjects = $wpdb->get_results( "SELECT * FROM $table_name where teacher_id=$teacher_id");
}
function mj_smgt_get_subject_by_classid($class_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "subject";
	$retrieve_subject = $wpdb->get_results( "SELECT * FROM $table_name WHERE class_id=".$class_id);
	return $retrieve_subject;	
}
function mj_smgt_get_subject($sid)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "subject";
	$retrieve_subject = $wpdb->get_row( "SELECT * FROM $table_name WHERE subid=".$sid);	
	return $retrieve_subject;
}
function mj_smgt_get_book($b_id)
{
	global $wpdb;
	$table_book = $wpdb->prefix. 'smgt_library_book';
	$result = $wpdb->get_row("SELECT * FROM $table_book where id=".$b_id);
	return $result;
}
function mj_smgt_get_single_subject_name($subject_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "subject";
	return $retrieve_subject = $wpdb->get_var( "SELECT sub_name FROM $table_name WHERE subid=".$subject_id);	
}
function mj_smgt_get_single_subject_code($subject_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "subject";
	return $retrieve_subject = $wpdb->get_var( "SELECT subject_code FROM $table_name WHERE subid=".$subject_id);	
}
function mj_smgt_get_subject_name_by_teacher($teacher_id)
{
	global $wpdb;
    $table_name = $wpdb->prefix . "teacher_subject";
    $retrieve_subject = $wpdb->get_results( "SELECT * FROM $table_name WHERE teacher_id=".$teacher_id);    
    $subjec = '';
    if(!empty($retrieve_subject))
    {
        foreach($retrieve_subject as $retrive_data)
        {
            $sub_name = mj_smgt_get_single_subject_name($retrive_data->subject_id);
            $subjec .= $sub_name.', ';
        }
    }
    return $subjec;
	
}

function mj_smgt_get_subject_id_by_teacher($teacher_id)
{
	global $wpdb;
    $table_name = $wpdb->prefix . "teacher_subject";
    $retrieve_subject = $wpdb->get_results( "SELECT * FROM $table_name WHERE teacher_id=".$teacher_id);    
	 
    $subjects = array();
    if(!empty($retrieve_subject))
    {
        foreach($retrieve_subject as $retrive_data)
        {
            $count = mj_smgt_is_subject($retrive_data->subject_id);
			if($count > 0)
			{
				$subjects[] = $retrive_data->subject_id;
			}
        }
    }
	 
    return $subjects;
	
}

function mj_smgt_is_subject($subject_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "subject";
	return $retrieve_subject = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE subid=".$subject_id);	
}

function mj_smgt_get_class_by_id($sid)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "smgt_class";
	 $retrieve_subject = $wpdb->get_row( "SELECT * FROM $table_name WHERE class_id=".$sid);
	return $retrieve_subject;
}

function mj_smgt_get_class_name_by_id($sid)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "smgt_class";
	 $retrieve_subject = $wpdb->get_row( "SELECT * FROM $table_name WHERE class_id=".$sid);
	return $retrieve_subject->class_name;
}


function mj_smgt_get_class_id_by_name($class_name)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "smgt_class";
	$retrieve_subject = $wpdb->get_row( "SELECT * FROM $table_name WHERE class_name = '$class_name'");
	return $retrieve_subject->class_id;
}

function mj_smgt_get_grade_by_id($gid)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "grade";
	return $retrieve_subject = $wpdb->get_row( "SELECT * FROM $table_name WHERE grade_id = ".$gid);
	
}
function mj_smgt_get_grade_by_name($grade_name)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "grade";
	return $retrieve_subject = $wpdb->get_row( "SELECT * FROM $table_name WHERE grade_name = '$grade_name'");
	
}
function mj_smgt_get_exam_by_id($eid)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "exam";
	$retrieve_subject = $wpdb->get_row( "SELECT * FROM $table_name WHERE exam_id = ".$eid);
	return $retrieve_subject;
}

function mj_smgt_get_exam_by_class_id($class_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "exam";
	return $retrieve_subject = $wpdb->get_row( "SELECT * FROM $table_name WHERE class_id = ".$class_id);
	
}
function mj_smgt_get_all_exam_by_class_id($class_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "exam";
	return $retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE class_id =$class_id and section_id='0'");
	
}
function mj_smgt_get_all_exam_by_class_id_all($class_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "exam";
	return $retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE class_id =$class_id");
	
}
function mj_smgt_get_all_class_data_by_class_array($class_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "smgt_class";
	return $retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE class_id IN (".implode(',',$class_id).")");
	
}
function mj_smgt_get_all_class_created_by($user_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "smgt_class";
	return $retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE create_by=".$user_id);
	
}
function mj_smgt_get_all_exam_by_class_id_array($class_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "exam";
	$retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE class_id IN (".implode(',',$class_id).") and section_id='0'");
	return $retrieve_data;
	
}
function mj_smgt_get_all_exam_by_class_id_and_section_id_array($class_id,$section_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "exam";
	return $retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE class_id=$class_id AND section_id=$section_id");
	//return $retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE class_id IN (".implode(',',$class_id).") and section_id IN (".implode(',',$section_id).")");
}

function smgt_change_dateformat($date)
{
	return mysql2date(get_option('date_format'),$date);
}

function mj_smgt_get_all_exam_by_class_id_and_section_id_array_parent($class_id,$section_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "exam";
	
	return $retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name WHERE class_id IN (".implode(',',$class_id).") and section_id IN (".implode(',',$section_id).")");
}
function mj_smgt_get_exam_name_id($eid)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "exam";
	return $retrieve_subject = $wpdb->get_var( "SELECT exam_name FROM $table_name WHERE exam_id = ".$eid);

}

function mj_smgt_get_transport_by_id($tid)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "transport";
	return $retrieve_subject = $wpdb->get_row( "SELECT * FROM $table_name WHERE transport_id = ".$tid);
	
}
function mj_smgt_get_hall_by_id($id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "hall";
	return $retrieve_subject = $wpdb->get_row( "SELECT * FROM $table_name WHERE hall_id = ".$id);
}
function mj_smgt_get_holiday_by_id($id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "holiday";
	return $retrieve_subject = $wpdb->get_row( "SELECT * FROM $table_name WHERE holiday_id = ".$id);
}

function mj_smgt_get_route_by_id($id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "smgt_time_table";
	return $retrieve_subject = $wpdb->get_row( "SELECT * FROM $table_name WHERE route_id = ".$id);
}
function mj_smgt_get_payment_by_id($id)
{
	
	global $wpdb;
	$table_name = $wpdb->prefix . "smgt_payment";
	return $retrieve_subject = $wpdb->get_row( "SELECT * FROM $table_name WHERE payment_id = ".$id);
}
function delete_mj_smgt_payment($tablenm,$tid)
{
	school_append_audit_log(''.esc_html__('Delete Payment Detail','hospital_mgt').'',null,get_current_user_id(),'delete');
	global $wpdb;
	$table_name = $wpdb->prefix . $tablenm;
	return $result=$wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE payment_id= %d",$tid));
}
function mj_smgt_delete_transport($tablenm,$tid)
{
	school_append_audit_log(''.esc_html__('Delete Trasport Detail','hospital_mgt').'',null,get_current_user_id(),'delete');
	global $wpdb;
	$table_name = $wpdb->prefix . $tablenm;
	return $result=$wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE transport_id= %d",$tid));

}
function mj_smgt_delete_hall($tablenm,$id)
{
	school_append_audit_log(''.esc_html__('Delete Exam Hall Detail','hospital_mgt').'',null,get_current_user_id(),'delete');
	global $wpdb;
	$table_name = $wpdb->prefix . $tablenm;
	return $result=$wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE hall_id= %d",$id));
}
function mj_smgt_delete_holiday($tablenm,$id)
{
	school_append_audit_log(''.esc_html__('Delete Holiday Detail','hospital_mgt').'',null,get_current_user_id(),'delete');
	global $wpdb;
	$table_name = $wpdb->prefix . $tablenm;
	return $result=$wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE holiday_id= %d",$id));
}
function mj_smgt_delete_route($tablenm,$id)
{
	school_append_audit_log(''.esc_html__('Delete Route Detail','hospital_mgt').'',null,get_current_user_id(),'delete');
	global $wpdb;
	$obj_virtual_classroom = new mj_smgt_virtual_classroom();
	$table_name = $wpdb->prefix . $tablenm;
	$result = $wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE route_id= %d",$id));
	if ($result)
	{
		$meeting_data = $obj_virtual_classroom->mj_smgt_get_singal_meeting_by_route_data_in_zoom($id);
		if(!empty($meeting_data))
		{
			$obj_virtual_classroom->mj_smgt_delete_meeting_in_zoom($meeting_data->meeting_id);
		}
	}
	return $result;
}
function mj_smgt_get_teacherid_by_subjectid($id)
{
	global $wpdb;
    $teacher = array();
    
    $table_name = $wpdb->prefix . "teacher_subject";
    $retrieve_subject = $wpdb->get_results( "SELECT teacher_id FROM $table_name WHERE subject_id = ".$id);
    foreach($retrieve_subject as $subject)
    {
        $teacher[] = $subject->teacher_id;
    }
    return $teacher;
}


//------------------------------

function mj_smgt_get_teachers_class($teacher_id)
{
	global $wpdb;
		$table = $wpdb->prefix . 'smgt_teacher_class';
		$result = $wpdb->get_results('SELECT * FROM '.$table.' where teacher_id ='.$teacher_id);
		$return_r = array();
		foreach($result as $retrive_data)
		{
			$return_r[] = $retrive_data->class_id;
		}
		if(!empty($return_r))
			$class_idlist = implode(',',$return_r);
		else
			$class_idlist= '0';
		return $class_idlist;
}
function mj_smgt_get_allclass($user_id=0)
{
	global $wpdb;
	$table_name = $wpdb->prefix .'smgt_class';
	if($user_id==0){
		$user_id=get_current_user_id();
	}
	//------------------------TEACHER ACCESS---------------------------------//
	$teacher_access = get_option( 'smgt_access_right_teacher');
	 
	$teacher_access_data=$teacher_access['teacher'];
	
	foreach($teacher_access_data as $key=>$value)
	{
		if($key=='class')
		{
			$data=$value;
		}
	}
	//------------------------TEACHER ACCESS END---------------------------------//

	//------------------------TEACHER ACCESS---------------------------------//
	if($data['own_data']=='1' && mj_smgt_get_roles($user_id)=='teacher')
	{
		$class_id=get_user_meta($user_id,'class_name',true);
		$class_id=mj_smgt_get_teachers_class($user_id);	
		return $classdata =$wpdb->get_results("SELECT * FROM $table_name where class_id in ($class_id)", ARRAY_A);
	}
	else
	{
		return $classdata =$wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
	}
}

function mj_smgt_get_role($user_id)
{
	$user_meta=get_userdata($user_id);	
	return $user_roles=$user_meta->roles;
}
function mj_smgt_get_attendace_status($AttDate)
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'holiday';	
	$sql = "SELECT * FROM $tbl_name WHERE '$AttDate' between date and end_date";
	return $result = $wpdb->get_results($sql);
	
}
function mj_smgt_cheak_type_status($user_id,$type,$type_id)
{
	global $wpdb;	
	$tbl_smgt_check_status = $wpdb->prefix .'smgt_check_status';	
	
	 $rowcount = $wpdb->get_var("SELECT COUNT(*) FROM $tbl_smgt_check_status WHERE user_id =$user_id AND type ='$type' AND type_id=$type_id");
	
	if($rowcount=="0")
	{
		$status ="Unread";		
	}
	else
	{
		$status = "Read";
	}
	return $status;
}


function get_student_mj_smgt_payment_list($std_id)
{
	global $wpdb;	
	$table_payment = $wpdb->prefix .'smgt_payment';
	return $retrieve_paymentlist = $wpdb->get_results( "SELECT * FROM $table_payment WHERE student_id={$std_id}");	
	
}
//get all class   teacher id
function mj_smgt_get_all_teacher_data($teacher_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix .'smgt_teacher_class';	
	return $classdata =$wpdb->get_results("SELECT * FROM $table_name where teacher_id in ($teacher_id)");
}
//-----------FOR GET USER DATA ROLE WISE------------------------------------------
function mj_smgt_get_usersdata($role)
{
	global $wpdb;
	/* $capabilities = $wpdb->prefix .'capabilities';
	$this_role = "'[[:<:]]".$role."[[:>:]]'";
	$query = "SELECT * FROM $wpdb->users WHERE ID = ANY (SELECT user_id FROM $wpdb->usermeta WHERE meta_key = '$capabilities' AND meta_value RLIKE $this_role)";
	$users_of_this_role = $wpdb->get_results($query);
	
	if(!empty($users_of_this_role))
		return $users_of_this_role; */
  /*  */
  
  $users_of_this_role =get_users(array('role'=>$role));
  return $users_of_this_role;
}
function mj_smgt_get_own_usersdata($role)
{
	$get_current_user_id=get_current_user_id();
	global $wpdb;
	$capabilities = $wpdb->prefix .'capabilities';
	$this_role = "'[[:<:]]".$role."[[:>:]]'";
	$query = "SELECT * FROM $wpdb->users WHERE ID = ANY (SELECT user_id FROM $wpdb->usermeta WHERE meta_key = '$capabilities' AND meta_value RLIKE $this_role AND ID=$get_current_user_id)";
	$users_of_this_role = $wpdb->get_results($query);
	
	if(!empty($users_of_this_role))
		return $users_of_this_role;
	
}
function mj_smgt_get_useraa_by_role($role)
{
	return get_users(array('role'=>$role));
}

function mj_smgt_get_student_groupby_class()
{
	global $wpdb;
	$student_list = mj_smgt_get_usersdata('student');
	$students = array();
	if(!empty($student_list))
	{
		foreach($student_list as $student_obj)
		{		
			$class_id=get_user_meta($student_obj->ID, 'class_name',true);
			$student = mj_smgt_get_user_name_byid($student_obj->ID);
			$student_name = str_replace("'","",$student);
			if($class_id != '')
			{
				$classname=	mj_smgt_get_class_name($class_id);
				$students[$classname][$student_obj->ID]=$student_name." ( ".get_user_meta($student_obj->ID, 'roll_id',true)." )";
			}
		}
	}
	return $students;
}

//------------------FOR GET USER IMAGE------------------
function mj_smgt_get_user_image($uid)
{
	global $wpdb;
		
	$usersdata = get_user_meta( $uid, 'smgt_user_avatar' , true );
	return $usersdata;
}
function mj_smgt_get_user_driver_image($tid)
{
	global $wpdb;
	$table_name = $wpdb->prefix .'transport';
	$query = "SELECT smgt_user_avatar FROM $table_name WHERE transport_id = $tid";
	$usersdata = $wpdb->get_results($query,ARRAY_A); 
	foreach($usersdata as $data)
	{
		return $data;
	}
	
}
 
//---------------FOR ADD NEW USER --------------------------
function mj_smgt_add_newuser($userdata,$usermetadata,$firstname,$lastname,$role)
{	
	school_append_audit_log(''.esc_html__('Add New User Detail','hospital_mgt').'',null,get_current_user_id(),'insert');
	$Schoolname = 	 get_option('smgt_school_name');		
	$MailSub 	=	 get_option('student_assign_to_teacher_subject');
	$MailCon	=	 get_option('student_assign_to_teacher_content');

	$returnval;
	$user_id = wp_insert_user( $userdata );
 	$user = new WP_User($user_id);
	 $user->set_role($role);
	foreach($usermetadata as $key=>$val)
	{		
		$returnans=add_user_meta( $user_id, $key,$val, true );		
	}
	
	if($user_id)
	{		
		$string = array();
		$string['{{user_name}}']   =  $firstname .' '.$lastname;
		$string['{{school_name}}'] =  get_option('smgt_school_name');
		$string['{{role}}']        =  $role;
		$string['{{login_link}}']  =  site_url() .'/index.php/school-management-login-page';
		$string['{{username}}']    =  $userdata['user_email'];
		$string['{{Password}}']    =  $userdata['user_pass'];
			
		$MsgContent                =  get_option('add_user_mail_content');		
		$MsgSubject				   =  get_option('add_user_mail_subject');
		$message = mj_smgt_string_replacement($string,$MsgContent);
		$MsgSubject = mj_smgt_string_replacement($string,$MsgSubject);
	
		$email= $userdata['user_email'];
		mj_smgt_send_mail($email,$MsgSubject,$message);
		
		
		// send mail when student assin to teacher.
		if($role=='student')
		{
			 $TeacherIDs = mj_smgt_check_class_exits_in_teacher_class($usermetadata['class_name']);	
			$TeacherEmail = array();
			$string['{{school_name}}']  = $Schoolname;
			$string['{{student_name}}'] =  mj_smgt_get_display_name($user_id);
			$subject = get_option('student_assign_teacher_mail_subject');
			$MessageContent = get_option('student_assign_teacher_mail_content');
			foreach($TeacherIDs as $teacher)
			{		
				$TeacherData = get_userdata($teacher);		
				//$TeacherData->user_email;
				$string['{{teacher_name}}']= mj_smgt_get_display_name($TeacherData->ID);
				$message = mj_smgt_string_replacement($string,$MessageContent);
				mj_smgt_send_mail($TeacherData->user_email,$subject,$message);
			}			 
		}
	}
	
	$returnval=update_user_meta( $user_id, 'first_name', $firstname );
	$returnval=update_user_meta( $user_id, 'last_name', $lastname );
	if($role=='parent')
	{
		$child_list = $_REQUEST['chield_list'];
	
		foreach($child_list as $child_id)
		{
			
			$student_data = get_user_meta($child_id, 'parent_id', true);
			$parent_data = get_user_meta($user_id, 'child', true); 
			
			if($student_data)
			{
				if(!in_array($user_id, $student_data))
				{
					$update = array_push($student_data,$user_id);				
					$returnans=update_user_meta($child_id,'parent_id', $student_data);
					if($returnans)
					{
						$returnval=$returnans;
					}
				}				
			}
			else
			{
				$parant_id = array($user_id);
				$returnans=add_user_meta($child_id,'parent_id', $parant_id );
		
				if($returnans)
				$returnval=$returnans;
			}
			if ($parent_data)
			{
				if(!in_array($child_id, $parent_data))
				{
					$update = array_push($parent_data,$child_id);			
					$returnans=update_user_meta($user_id,'child', $parent_data);
					if($returnans)
					$returnval=$returnans;
				}
			}
			else 
			{		
				$child_id = array($child_id);
				$returnans=add_user_meta($user_id,'child', $child_id );
				if($returnans)
					$returnval=$returnans;
			}		
		}
	}
	
	if($role=="teacher")
	{
		
        $Schoolname = get_option('smgt_school_name');		
		$MailSub 	=	 get_option('student_assign_to_teacher_subject');
		$MailCon	=	 get_option('student_assign_to_teacher_content');
		
		if(!empty($usermetadata['class_name']))
		{			
			$std=array();	
			
			$std = array_merge(mj_smgt_get_student_by_class_id($usermetadata['class_name']),$std);			
			$student_name ='';
			foreach($std as $studentdata)
			{			
				if(!empty($studentdata))
				{
					foreach($studentdata as $key=>$student)
					{		
						if(isset($student) && !empty($student) && $userdata['user_email']==$student->user_email)
						{
							$student_name = mj_smgt_get_display_name($student->ID);							
							$MailArr['{{school_name}}'] 	= 	$Schoolname;				
							$MailArr['{{teacher_name}}'] 	= 	mj_smgt_get_display_name($user_id);
							$MailArr['{{class_name}}'] 		= 	mj_smgt_get_class_name(get_user_meta($student->ID,'class_name',true)); 
							$MailArr['{{student_name}}'] 	=  	$student_name; 					
							$MailSub = mj_smgt_string_replacement($MailArr,$MailSub);
							$MailCon = mj_smgt_string_replacement($MailArr,$MailCon);
							mj_smgt_send_mail($student->user_email,$MailSub,$MailCon);  
						}
					}			
				} 			
			} 		
		}	
	}
	return $user_id;	
}
 
function mj_smgt_load_documets($file,$type,$nm) 
{ 
	
	$parts = pathinfo($_FILES[$type]['name']);
	$inventoryimagename = time()."-".$nm."-"."in".".".$parts['extension'];
	$document_dir = WP_CONTENT_DIR ;
    $document_dir .= '/uploads/school_assets/';
	$document_path = $document_dir;
	 
	if (!file_exists($document_path))
	{
		mkdir($document_path, 0777, true);
	}	
	if (move_uploaded_file($_FILES[$type]['tmp_name'], $document_path.$inventoryimagename)) 
	{
        $imagepath= $inventoryimagename;	
    }
	return $imagepath;
}
// LOAD DOCUMENTS 
function mj_smgt_load_documets_new($file,$type,$nm)
{	
	$parts = pathinfo($type['name']);
	$inventoryimagename = time()."-".$nm."-"."in".".".$parts['extension'];
	$document_dir = WP_CONTENT_DIR;
	$document_dir .= '/uploads/school_assets/';
	$document_path = $document_dir;
	if (!file_exists($document_path)) {
		mkdir($document_path, 0777, true);		
	}
	$imagepath="";	
	if (move_uploaded_file($type['tmp_name'], $document_path.$inventoryimagename)) 
	{
		 $imagepath= $inventoryimagename; 
	}
	return $imagepath;
}
 // LOAD Multiple DOCUMENTS 
function mj_smgt_load_multiple_documets($file,$type,$nm)
{	
	$parts = pathinfo($type['name']);
	
	$inventoryimagename = time()."-".rand().".".$parts['extension'];
	$document_dir = WP_CONTENT_DIR;
	$document_dir .= '/uploads/school_assets/';
	$document_path = $document_dir;
	if (!file_exists($document_path)) {
		mkdir($document_path, 0777, true);		
	}
	$imagepath="";	
	if (move_uploaded_file($type['tmp_name'], $document_path.$inventoryimagename)) 
	{
		 $imagepath= $inventoryimagename; 
	}
	return $imagepath;
}
//-----------------FOR UPDATE USER Profile- ---------------------------------
function mj_smgt_update_user_profile($userdata,$usermetadata)
{
	$returnans='';
	$user_id= wp_update_user($userdata);
	
	foreach($usermetadata as $key=>$val)
	{	
		$returnans=update_user_meta($user_id,$key,$val);		
	}
	
	return $returnans;
}

function hrmgt_leave_duration_label($id)
{
	$lable="";
	if($id=='half_day')
		$lable="Half Day";
	if($id=='full_day')
		$lable="Full Day";
	if($id=='more_then_day')
		$lable="More Then One Day";
	return $lable;
	
}

function mj_smgt_get_all_user_in_plugin()
{
	$all_user=array();
	$student = get_users(array('role'=>'student'));
	$teacher = get_users(array('role'=>'teacher'));
	$supportstaff = get_users(array('role'=>'supportstaff'));
	$parent = get_users(array('role'=>'parent'));
	$all_role = array_merge($student,$teacher,$supportstaff,$parent);
	$all_user = array($all_role);
	
	foreach($all_user as $key=>$values){
		return $values;
	}
}

//-----------------FOR UPDATE USER-------------------------------------------
function mj_smgt_update_user($userdata,$usermetadata,$firstname,$lastname,$role)
{	
	school_append_audit_log(''.esc_html__('Update User Detail','hospital_mgt').'',null,get_current_user_id(),'edit');
	$returnval;
	$user_id 	= 	wp_update_user($userdata);		
	$returnval	=	update_user_meta( $user_id, 'first_name', $firstname );
	$returnval	=	update_user_meta( $user_id, 'last_name', $lastname );
	foreach($usermetadata as $key=>$val)
	{		
		$returnans=update_user_meta( $user_id, $key,$val );
		if($returnans)
			$returnval=$returnans;
	}
	if($role=='parent')
	{
		$child_list = $_REQUEST['chield_list'];	
		$old_child 	= 	get_user_meta($user_id, 'child', true);
		if(!empty($old_child))
		{
			$different_insert_child 	= array_diff($child_list,$old_child);
		    $different_delete_child  	= array_diff($old_child,$child_list);
			
			if(!empty($different_insert_child))
			{
				
				foreach($different_insert_child as $key=>$child)
				{
					$parent 	=	array();
					$parent 	= 	get_user_meta($child, 'parent_id', true);
					$old_child  	= 	get_user_meta($user_id, 'child', true);
					
					array_push($old_child,$child);				
					update_user_meta($user_id,'child',$old_child);
					
					if(empty($parent))
					{					
						$parent1[] = $user_id;
						
						update_user_meta($child,'parent_id',$parent1);
					} 
					else
					{					
						array_push($parent,$user_id);
						update_user_meta($child,'parent_id',$parent);
					}				
				} 
			} 
			
			if(!empty($different_delete_child))
			{		
				
				$child  	= 	get_user_meta($user_id, 'child', true);			
				$childdata = array_diff($child,$different_delete_child);
				update_user_meta($user_id,'child',$childdata);			
				foreach($different_delete_child as $del_key=>$del_child)
				{
					$parent 	=	array();
					$parent 	= 	get_user_meta($del_child, 'parent_id', true);				
									
					if(!empty($parent))
					{
						if(in_array($user_id,$parent))
						{						
							unset($parent[array_search($user_id,$parent)]);
							update_user_meta($del_child,'parent_id',$parent); 
						}
					} 				
					
				} 
			}
		}
		else
		{
			foreach($child_list as $child_id)
			{
				$student_data = get_user_meta($child_id, 'parent_id', true);
				$parent_data = get_user_meta($user_id, 'child', true); 
				if($student_data)
				{
					if(!in_array($user_id, $student_data))
					{
						$update = array_push($student_data,$user_id);				
						$returnans=update_user_meta($child_id,'parent_id', $student_data);
						if($returnans)
						$returnval=$returnans;
					}				
				}
				else
				{
					$parant_id = array($user_id);
					$returnans=add_user_meta($child_id,'parent_id', $parant_id );
					if($returnans)
					$returnval=$returnans;
				}
				if ($parent_data)
				{
					if(!in_array($child_id, $parent_data))
					{
						$update = array_push($parent_data,$child_id);			
						$returnans=update_user_meta($user_id,'child', $parent_data);
						if($returnans)
						$returnval=$returnans;
					}
				}
				else 
				{		
					$child_id = array($child_id);
					$returnans=add_user_meta($user_id,'child', $child_id );
					if($returnans)
						$returnval=$returnans;
				}		
			}
		}
	}
	return $user_id;
}
function mj_smgt_sgmt_day_list()
{
	$day_list = array('1' => esc_attr__('Monday','school-mgt'),
		'2' => esc_attr__('Tuesday','school-mgt'),
		'3' => esc_attr__('Wednesday','school-mgt'),
		'4' => esc_attr__('Thursday','school-mgt'),
		'5' => esc_attr__('Friday','school-mgt'),
		'6' => esc_attr__('Saturday','school-mgt'),
		'7' => esc_attr__('Sunday','school-mgt'));
	return $day_list;
	
}
function mj_smgt_sgmt_day_list_new()
{
	$day_list = array('1' =>'Monday',
		'2' =>'Tuesday',
		'3' =>'Wednesday',
		'4' =>'Thursday',
		'5' =>'Friday',
		'6' =>'Saturday',
		'7' =>'Sunday');
	return $day_list;
	
}
function mj_smgt_menu()
{
	$user_menu = array();
	$user_menu[] = array('menu_icone'=>plugins_url( 'school-management/assets/images/icons/student-icon.png' ),'menu_title'=> esc_attr__( 'Student', 'school-mgt' ),'teacher' => 1,'student' => 1,'parent' =>0,'supportstaff' =>1,'page_link'=>'student');
	$user_menu[] = array('menu_icone'=>plugins_url( 'school-management/assets/images/icons/student-icon.png' ),'menu_title'=> esc_attr__( 'Child', 'school-mgt' ),'teacher' => 0,'student' => 0,'parent' =>1,'supportstaff' =>0,'page_link'=>'child');
	$user_menu[] = array('menu_icone'=>plugins_url( 'school-management/assets/images/icons/teacher.png' ),'menu_title'=> esc_attr__( 'Teacher', 'school-mgt' ),'teacher' => 1,'student' => 1,'parent' =>1,'supportstaff' =>0,'page_link'=>'teacher');
	$user_menu[] = array('menu_icone'=>plugins_url( 'school-management/assets/images/icons/parents.png' ),'menu_title'=> esc_attr__( 'Parent', 'school-mgt' ),'teacher' => 0,'student' => 0,'parent' =>0,'supportstaff' =>0,'page_link'=>'parent');
	$user_menu[] = array('menu_icone'=>plugins_url( 'school-management/assets/images/icons/subject.png' ),'menu_title'=> esc_attr__( 'Subject', 'school-mgt' ),'teacher' => 1,'student' => 1,'parent' =>0,'supportstaff' =>0,'page_link'=>'subject');
	$user_menu[] = array('menu_icone'=>plugins_url( 'school-management/assets/images/icons/class-route.png' ),'menu_title'=> esc_attr__( 'Class Routine', 'school-mgt' ),'teacher' => 1,'student' => 1,'parent' =>1,'supportstaff' =>0,'page_link'=>'schedule');
	$user_menu[] = array('menu_icone'=>plugins_url( 'school-management/assets/images/icons/attandance.png' ),'menu_title'=> esc_attr__( 'Attendance', 'school-mgt' ),'teacher' => 1,'student' => 0,'parent' =>0,'supportstaff' =>0,'page_link'=>'attendance');
	$user_menu[] = array('menu_icone'=>plugins_url( 'school-management/assets/images/icons/exam.png' ),'menu_title'=> esc_attr__( 'Exam', 'school-mgt' ),'teacher' => 1,'student' => 1,'parent' =>1,'supportstaff' =>0,'page_link'=>'exam');
	$user_menu[] = array('menu_icone'=>plugins_url( 'school-management/assets/images/icons/mark-manage.png' ),'menu_title'=> esc_attr__( 'Manage Marks', 'school-mgt' ),'teacher' => 1,'student' => 0,'parent' =>0,'supportstaff' =>1,'page_link'=>'manage_marks');
	$user_menu[] = array('menu_icone'=>plugins_url( 'school-management/assets/images/icons/fee.png' ),'menu_title'=> esc_attr__( 'Fee Payment', 'school-mgt' ),'teacher' => 0,'student' => 1,'parent' =>1,'supportstaff' =>1,'page_link'=>'feepayment');
	$user_menu[] = array('menu_icone'=>plugins_url( 'school-management/assets/images/icons/payment.png' ),'menu_title'=> esc_attr__( 'Payment', 'school-mgt' ),'teacher' => 0,'student' => 1,'parent' =>1,'supportstaff' =>1,'page_link'=>'payment');
	$user_menu[] = array('menu_icone'=>plugins_url( 'school-management/assets/images/icons/transport.png' ),'menu_title'=> esc_attr__( 'Transport', 'school-mgt' ),'teacher' => 1,'student' => 1,'parent' =>1,'supportstaff' =>1,'page_link'=>'transport');
	$user_menu[] = array('menu_icone'=>plugins_url( 'school-management/assets/images/icons/notice.png' ),'menu_title'=> esc_attr__( 'Notice Board', 'school-mgt' ),'teacher' => 1,'student' => 1,'parent' =>1,'supportstaff' =>1,'page_link'=>'notice');
	$user_menu[] = array('menu_icone'=>plugins_url( 'school-management/assets/images/icons/message.png' ),'menu_title'=> esc_attr__( 'Message', 'school-mgt' ),'teacher' => 1,'student' => 1,'parent' =>1,'supportstaff' =>1,'page_link'=>'message');
	$user_menu[] = array('menu_icone'=>plugins_url( 'school-management/assets/images/icons/holiday.png' ),'menu_title'=> esc_attr__( 'Holiday', 'school-mgt' ),'teacher' => 1,'student' => 1,'parent' =>1,'supportstaff' =>1,'page_link'=>'holiday');
	$user_menu[] = array('menu_icone'=>plugins_url( 'school-management/assets/images/icons/library.png' ),'menu_title'=> esc_attr__( 'Library', 'school-mgt' ),'teacher' => 1,'student' => 1,'parent' =>0,'supportstaff' =>1,'page_link'=>'library');
	$user_menu[] = array('menu_icone'=>plugins_url( 'school-management/assets/images/icons/account.png' ),'menu_title'=> esc_attr__( 'Account', 'school-mgt' ),'teacher' => 1,'student' => 1,'parent' =>1,'supportstaff' =>1,'page_link'=>'account');
	return  $user_menu;
}
//----------------- Exam data ------//
function mj_smgt_get_exam_list()
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'exam';
	
	$exam =$wpdb->get_results("SELECT *  FROM $tbl_name");
	return $exam;
}
function mj_smgt_get_exam_id()
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'exam';
	
	$exam =$wpdb->get_row("SELECT *  FROM $tbl_name");
	return $exam;
}
function mj_smgt_get_subject_byid($id)
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'subject';
	
	$subject =$wpdb->get_row("SELECT * FROM $tbl_name where subid=".$id);
	return $subject->sub_name;
}
function mj_smgt_get_student_by_class_id($id)
{
	global $wpdb;
	$student = get_users(array('meta_key' => 'class_name', 'meta_value' => $id));
	return $student;
}
function mj_smgt_cheack_student_rollno_exist_or_not($r_no,$student_id)
{
	global $wpdb;
	$student = get_users(array('meta_key' => 'roll_id', 'meta_value' => $r_no));
	if (!empty($student))
	{
		if ($student[0]->ID == $student_id)
		{
			$status = 1;
		}
		else
		{
			$status = 0;
		}
	}
	else
	{
		$status = 1;
	}
	return $status;
}
//Migration
function mj_smgt_fail_student_list($current_class,$next_class,$exam_id,$passing_marks)
{
	global $wpdb;
	$table_users = $wpdb->prefix . 'users';
	$table_usermeta = $wpdb->prefix . 'usermeta';
	$capabilities = $wpdb->prefix .'capabilities';
	$table_marks = $wpdb->prefix . 'marks';
	$sql ="SELECT DISTINCT u.id,u.user_login,um.meta_value FROM $table_users as u,$table_usermeta as um,$table_marks as m where
	(um.meta_key = 'class_name' AND um.meta_value = '$current_class') AND u.id = um.user_id
	AND u.ID = ANY (SELECT user_id FROM $table_usermeta WHERE meta_key = '$capabilities' AND meta_value RLIKE 'student')
	AND m.marks < $passing_marks AND u.id = m.student_id AND m.exam_id = $exam_id";
	$student =$wpdb->get_results($sql);
	$failed_list = array();
	if(!empty($student))
	{
	foreach ($student as $fail_student)
	{
		$failed_list[]=$fail_student->id;
	}
	}
	
	return $failed_list;
}

function mj_smgt_migration($current_class,$next_class,$exam_id,$fail_list)
{
	global $wpdb;
	$studentdata=mj_smgt_get_usersdata('student');
	$table_usermeta = $wpdb->prefix . 'usermeta';
	if(!empty($studentdata))
	{
		foreach (mj_smgt_get_usersdata('student') as $retrieved_data)
		{
			if (!in_array($retrieved_data->ID,$fail_list))
			{
				$sql_update ="UPDATE $table_usermeta set meta_value = '$next_class' where user_id = $retrieved_data->ID AND meta_value = '$current_class' AND meta_key = 'class_name'";
				$student =$wpdb->query($sql_update);
			}			
		}
	}	
}
//--------------- MIGRATE CLASS WITHOUT EXAM --------------//
function mj_smgt_migration_without_exam($current_class,$next_class)
{
	global $wpdb;
	$studentdata=mj_smgt_get_usersdata('student');
	$table_usermeta = $wpdb->prefix . 'usermeta';
	if(!empty($studentdata))
	{
		foreach (mj_smgt_get_usersdata('student') as $retrieved_data)
		{
			$sql_update ="UPDATE $table_usermeta set meta_value = '$next_class' where user_id = $retrieved_data->ID AND meta_value = '$current_class' AND meta_key = 'class_name'";
			$student =$wpdb->query($sql_update);
		}
	}	
}

//Message
function mj_smgt_count_inbox_item($id)
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'smgt_message';
	$inbox =$wpdb->get_results("SELECT *  FROM $tbl_name where receiver = $id");
	return $inbox;
}
function mj_smgt_count_unread_message($user_id)
{
	
	global $wpdb;
	$tbl_name = $wpdb->prefix .'smgt_message';
	$smgt_message_replies = $wpdb->prefix . 'smgt_message_replies';
	
	$inbox =$wpdb->get_results("SELECT *  FROM $tbl_name where ((receiver = $user_id) AND (sender != $user_id)) AND (status=0)");
	
	$reply_msg =$wpdb->get_results("SELECT *  FROM $smgt_message_replies where (receiver_id = $user_id) AND ((status=0) OR (status IS NULL))");
	
	$count_total_message=count($inbox) + count($reply_msg);
	
	return $count_total_message;
}
function mj_smgt_get_inbox_message($user_id,$p=0,$lpm1=10)
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'smgt_message';
	$tbl_name_message_replies = $wpdb->prefix .'smgt_message_replies';
	
	$inbox =$wpdb->get_results("SELECT DISTINCT b.message_id, a.* FROM $tbl_name a LEFT JOIN $tbl_name_message_replies b ON a.post_id = b.message_id WHERE ( a.receiver = $user_id OR b.receiver_id =$user_id) AND (a.receiver = $user_id OR a.sender = $user_id) ORDER BY date DESC limit $p , $lpm1");

	return $inbox;
}
function mj_smgt_get_send_message($user_id,$max=10,$offset=0)
{
	
	global $wpdb;
	$tbl_name = $wpdb->prefix .'smgt_message';
	$class_obj=new School_Management($user_id);

	$args['post_type'] = 'message';
	$args['posts_per_page'] =$max;
	$args['offset'] = $offset;
	$args['post_status'] = 'public';
	$args['author'] = $user_id;
	
	$q = new WP_Query();
	$sent_message = $q->query( $args );

	return $sent_message;
}

function mj_smgt_count_send_item($id)
{
	global $wpdb;
	$posts = $wpdb->prefix."posts";
	$total =$wpdb->get_var("SELECT Count(*) FROM ".$posts." Where post_type = 'message' AND post_author = $id");
	return $total;
}
function mj_smgt_pagination($totalposts,$p,$lpm1,$prev,$next){
	$adjacents = 1;
	$page_order = "";
	$pagination = "";
	$form_id = 1;
	if(isset($_REQUEST['form_id']))
		$form_id=$_REQUEST['form_id'];
	if(isset($_GET['orderby']))
	{
		$page_order='&orderby='.$_GET['orderby'].'&order='.$_GET['order'];
	}
	if($totalposts > 1)
	{
		$pagination .= '<div class="btn-group">';
		
		if ($p > 1)
			$pagination.= "<a href=\"?page=smgt_message&tab=sentbox&form_id=$form_id&pg=$prev$page_order\" class=\"btn btn-default\"><i class=\"fa fa-angle-left\"></i></a> ";
		else
			$pagination.= "<a class=\"btn btn-default disabled\"><i class=\"fa fa-angle-left\"></i></a> ";
		
		if ($p < $totalposts)
			$pagination.= " <a href=\"?page=smgt_message&tab=sentbox&form_id=$form_id&pg=$next\" class=\"btn btn-default next-page\"><i class=\"fa fa-angle-right\"></i></a>";
		else
			$pagination.= " <a class=\"btn btn-default disabled\"><i class=\"fa fa-angle-right\"></i></a>";
		$pagination.= "</div>\n";
	}
	return $pagination;
}
function mj_smgt_fronted_sentbox_pagination($totalposts,$p,$lpm1,$prev,$next){
	$adjacents = 1;
	$page_order = "";
	$pagination = "";
	$form_id = 1;
	if(isset($_REQUEST['form_id']))
		$form_id=$_REQUEST['form_id'];
	if(isset($_GET['orderby']))
	{
		$page_order='&orderby='.$_GET['orderby'].'&order='.$_GET['order'];
	}
	if($totalposts > 1)
	{
		$pagination .= '<div class="btn-group">';
		
		if ($p > 1)
			$pagination.= "<a href=\"?dashboard=user&page=message&tab=sentbox&pg=$prev$page_order\" class=\"btn btn-default\"><i class=\"fa fa-angle-left\"></i></a> ";
		else
			$pagination.= "<a class=\"btn btn-default disabled\"><i class=\"fa fa-angle-left\"></i></a> ";

		if ($p < $totalposts)
			$pagination.= " <a href=\"?dashboard=user&page=message&tab=sentbox&pg=$next\" class=\"btn btn-default next-page\"><i class=\"fa fa-angle-right\"></i></a>";
		else
			$pagination.= " <a class=\"btn btn-default disabled\"><i class=\"fa fa-angle-right\"></i></a>";
		$pagination.= "</div>\n";
	}
	return $pagination;
}
function mj_smgt_admininbox_pagination($totalposts,$p,$lpm1,$prev,$next)
{
	$adjacents = 1;
	$page_order = "";
	$pagination = "";
	$form_id = 1;
	if(isset($_REQUEST['form_id']))
		$form_id=$_REQUEST['form_id'];
	if(isset($_GET['orderby']))
	{
		$page_order='&orderby='.$_GET['orderby'].'&order='.$_GET['order'];
	}
	if($totalposts > 1)
	{
		$pagination .= '<div class="btn-group">';
		
		if ($p > 1)
			$pagination.= "<a href=\"?page=smgt_message&tab=inbox&pg=$prev\" class=\"btn btn-default\"><i class=\"fa fa-angle-left\"></i></a> ";
		else
			$pagination.= "<a class=\"btn btn-default disabled\"><i class=\"fa fa-angle-left\"></i></a> ";

		if ($p < $totalposts)
			$pagination.= " <a href=\"?page=smgt_message&tab=inbox&pg=$next\" class=\"btn btn-default next-page\"><i class=\"fa fa-angle-right\"></i></a>";
		else
			$pagination.= " <a class=\"btn btn-default disabled\"><i class=\"fa fa-angle-right\"></i></a>";
		$pagination.= "</div>\n";
	}
	return $pagination;
}
function mj_smgt_inbox_pagination($totalposts,$p,$lpm1,$prev,$next)
{
	$adjacents = 1;
	$page_order = "";
	$pagination = "";
	$form_id = 1;
	if(isset($_REQUEST['form_id']))
		$form_id=$_REQUEST['form_id'];
	if(isset($_GET['orderby']))
	{
		$page_order='&orderby='.$_GET['orderby'].'&order='.$_GET['order'];
	}
	if($totalposts > 1)
	{
		$pagination .= '<div class="btn-group">';
		
		if ($p > 1)
			$pagination.= "<a href=\"?dashboard=user&page=message&tab=inbox&pg=$prev\" class=\"btn btn-default\"><i class=\"fa fa-angle-left\"></i></a> ";
		else
			$pagination.= "<a class=\"btn btn-default disabled\"><i class=\"fa fa-angle-left\"></i></a> ";
	
		if ($p < $totalposts)
			$pagination.= " <a href=\"?dashboard=user&page=message&tab=inbox&pg=$next\" class=\"btn btn-default next-page\"><i class=\"fa fa-angle-right\"></i></a>";
		else
			$pagination.= " <a class=\"btn btn-default disabled\"><i class=\"fa fa-angle-right\"></i></a>";
		$pagination.= "</div>\n";
	}
	return $pagination;
}
function mj_smgt_get_message_by_id($id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "smgt_message";
	$qry = $wpdb->prepare("SELECT * FROM $table_name WHERE message_id= %d",$id);
	return $retrieve_subject = $wpdb->get_row($qry);

}

 function mj_smgt_login_failed( $user ) {
	// check what page the login attempt is coming from
	$referrer = $_SERVER['HTTP_REFERER'];
	$curr_args = array(
			'page_id' => get_option('smgt_login_page'),
			'login' => 'failed'
	);
	$referrer_faild = add_query_arg( $curr_args, get_permalink( get_option('smgt_login_page') ) );
	// check that were not on the default login page
	if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') && $user!=null ) 
	{
		// make sure we don't already have a failed login attempt
		if ( !strstr($referrer, '&login=failed' )) 
		{
			// Redirect to the login page and append a querystring of login failed
			wp_redirect( $referrer_faild);
		} else 
		{
			wp_redirect( $referrer );
		}

		exit;
	}
}



 function mj_smgt_pu_blank_login( $user ){
	// check what page the login attempt is coming from
	$referrer = $_SERVER['HTTP_REFERER'];

	$error = false;

	if($_POST['log'] == '' || $_POST['pwd'] == '')
	{
		$error = true;
	}

	// check that were not on the default login page
	if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') && $error ) {

		// make sure we don't already have a failed login attempt
		if ( !strstr($referrer, '&login=failed') ) {
			// Redirect to the login page and append a querystring of login failed
			wp_redirect( $referrer . '&login=failed' );
		} else {
			wp_redirect(site_url() );
		}

		exit;

	}
}

 
function mj_smgt_login_link()
{ ?>
	<style>
		.login-username
		{
			padding-bottom: 10px;
		}
		.login-password label
		{
			padding-right: 140px;
		}
	</style>
	<?php 
	$theme_name=get_current_theme();
	if($theme_name == 'Divi')
	{
		?>
		<style>
		.login-username label
		{
			padding-right: 28px;
		}
		#wp-submit
		{
			background: #5840bb;
			width: 25%;
			height: 30px;
			margin-bottom: 10px;
			color: white;
			border: none;
		}
		#left-area
		{
			text-align: center;
		}
		</style>
		<?php
	}
	if($theme_name == 'Twenty Twenty-One')
	{
		?>
		<style>
			.login-password label
			{
				padding-right: 148px;
			}
			.login-remember{
				margin-top: 12px;
			}
		</style>
		<?php
	}
	if($theme_name == 'Twenty Twenty-Two')
	{?>
		<style>
			.custom_login_form
			{
				position: absolute;
				top: 463px;
				left: 422px;
			}
			footer {
				margin-top: 10rem!important;
			}
			.login-submit input[type="submit" i] {
				height: 46px;
				background-color: #5840bb !important;
				background: #5840bb;
				color: #fff !important;
				width: 40% !important;
				font-weight: 500 !important;
				font-size: 16px;
				line-height: 24px;
				text-align: center;
				color: #FFFFFF;
				text-transform: uppercase;
				border: 0px solid black !important;
			}
			#loginform input[type="password" i], input[type="text" i] {
				height: 46px!important;
			}
			@media only screen and (max-width : 700px) 
			{
				.custom_login_form
				{
					position: absolute!important;
					top: 419px!important;
					left: 5%!important;
				}
				.wp-block-template-part
				{
					padding-top: 90px!important;
				}
			}
		</style>
		<?php 
	}
	if($theme_name == 'Twenty Twenty-Three')
	{?>
		<style>
			.custom_login_form
			{
				position: absolute;
				top: 400px;
				left: 422px;
			}
			footer {
				margin-top: 15rem!important;
			}
			.login-submit input[type="submit" i] {
				height: 46px;
				background-color: #5840bb !important;
				background: #5840bb;
				color: #fff !important;
				width: 40% !important;
				font-weight: 500 !important;
				font-size: 16px;
				line-height: 24px;
				text-align: center;
				color: #FFFFFF;
				text-transform: uppercase;
				border: 0px solid black !important;
			}
			#loginform input[type="password" i], input[type="text" i] {
				height: 46px!important;
			}
			@media only screen and (max-width : 700px) 
			{
				.custom_login_form
				{
					position: absolute!important;
					top: 419px!important;
					left: 5%!important;
				}
				.wp-block-template-part
				{
					padding-top: 21px!important;
				}
				.form-body.user_form.padding_20px_child_theme{
					margin-top: 15px !important;
				}
				/* .wp-block-site-title{
					padding-top: 30px !important;

				} */
				#loginform{
					margin-top: -76px !important;
				}
			}
		</style>
		<?php 
	}
	$args = array( 'redirect' => site_url() );
	if(isset($_GET['login']) && $_GET['login'] == 'failed')
	{
		?>
		<div id="login-error" style="background-color: #FFEBE8;border:1px solid #C00;padding:5px;">
			<p>Login failed: You have entered an incorrect Username or password, please try again.</p>
		</div>
		<?php
	}
	if(isset($_GET['login']) && $_GET['login'] == 'empty')
	{?>

	<div id="login-error" class="login-error" style="background-color: #FFEBE8;border:1px solid #C00;padding:5px;" >
	  <p><?php esc_attr_e('Login Failed: Username and/or Password is empty, please try again.','school-mgt');?></p>
	</div>
    <?php	
	}
	if(isset($_GET['smgt_activate']) && $_GET['smgt_activate'] == 'smgt_activate')
	{
	?>
		<div id="login-error" style="background-color: #FFEBE8;border:1px solid #C00;padding:5px;">
			<p><?php esc_attr_e('Login failed: Your account is inactive. Contact your administrator to activate it.','school-mgt');?></p>
		</div>
	<?php
	}
	global $reg_errors;
	$reg_errors = new WP_Error;
		if ( is_wp_error( $reg_errors ) )
		{
			foreach ( $reg_errors->get_error_messages() as $error )
			{
				echo '<div>';
				echo '<strong>ERROR</strong>:';
				echo $error . '<br/>';
				echo '</div>';         
			}
		}
	 $args = array(
			'echo' => true,
			'redirect' => site_url( $_SERVER['REQUEST_URI'] ),
			'form_id' => 'loginform',
			'label_username' => esc_attr__( 'Username' , 'school-mgt'),
			'label_password' => esc_attr__( 'Password', 'school-mgt' ),
			'label_remember' => esc_attr__( 'Remember Me' , 'school-mgt'),
			'label_log_in' => esc_attr__( 'Log In' , 'school-mgt'),
			'id_username' => 'user_login',
			'id_password' => 'user_pass',
			'id_remember' => 'rememberme',
			'id_submit' => 'wp-submit',
			'remember' => true,
			'value_username' => NULL,
	        'value_remember' => false ); 

	 $args = array('redirect' => site_url('/?dashboard=user') );
	if ( is_user_logged_in() )
	{
		$curent_theme=wp_get_theme();
		if($curent_theme == 'Twenty Twenty-Two')
		{
			$style='position: absolute!important;
			top: 500px!important;
			left: 13%!important;';
		}
		else
		{
			$style='float: left!important;
			margin-left: 7%!important;';
		}
		?>
		<div style="<?php echo $style;?>">
			<a href="<?php echo home_url('/')."?dashboard=user"; ?>">
			<?php esc_attr_e('Dashboard','school-mgt');?>
		</a>
		<br />
		<a href="<?php echo wp_logout_url(); ?>"><?php esc_attr_e('Logout','school-mgt');?></a> 
		</div>
		<?php 
	}
	else 
	{
		?>
		<div class="custom_login_form">
			<?php 
			wp_login_form( $args );	
			echo '<a class="forgot_link" href="'.wp_lostpassword_url().'" title="Lost Password"> '. esc_html__("Forgot your password?","school-mgt") .' </a>'; 
			?>
		</div> 
		<?php   
	}
}
function mj_smgt_view_student_attendance($start_date,$end_date,$user_id)
{
	
	global $wpdb;
	$tbl_name = $wpdb->prefix .'attendence';
	
	$result =$wpdb->get_results("SELECT *  FROM $tbl_name where user_id=$user_id AND role_name = 'student' and attendence_date between '$start_date' and '$end_date'");
	return $result;
}
function mj_smgt_get_attendence($userid,$curr_date)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "attendence";	
	$result=$wpdb->get_var("SELECT status FROM $table_name WHERE attendence_date='$curr_date' and user_id=$userid");
	return $result;

}
function mj_smgt_get_sub_attendence($userid,$curr_date,$sub_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "smgt_sub_attendance";
	
	$result=$wpdb->get_var("SELECT status FROM $table_name WHERE attendance_date='$curr_date' and user_id=$userid and sub_id=$sub_id");
	
	return $result;

}
function mj_smgt_get_attendence_comment($userid,$curr_date)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "attendence";
	$result=$wpdb->get_row("SELECT comment FROM $table_name WHERE attendence_date='$curr_date'  and user_id=$userid");
	if(!empty($result))
	 return $result->comment;
	else
		return '';

}
function mj_smgt_get_sub_attendence_comment($userid,$curr_date,$sub_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "smgt_sub_attendance";
	$result=$wpdb->get_row("SELECT comment FROM $table_name WHERE attendance_date='$curr_date'  and user_id=$userid and sub_id=$sub_id");
	if(!empty($result))
		return $result->comment;
	else
		return '';

}
//All AJAX Function
add_action( 'wp_ajax_mj_smgt_load_subject_class_id_and_section_id',  'mj_smgt_load_subject_class_id_and_section_id');
add_action( 'wp_ajax_mj_smgt_load_subject',  'mj_smgt_load_subject');
add_action( 'wp_ajax_nopriv_mj_smgt_load_subject',  'mj_smgt_load_subject');
add_action( 'wp_ajax_mj_smgt_load_exam',  'mj_smgt_load_exam');
add_action( 'wp_ajax_mj_smgt_load_exam_by_section',  'mj_smgt_load_exam_by_section');
add_action( 'wp_ajax_mj_smgt_ajax_smgt_result',  'mj_smgt_ajax_smgt_result');
add_action( 'wp_ajax_mj_smgt_ajax_create_meeting',  'mj_smgt_ajax_create_meeting');
add_action( 'wp_ajax_mj_smgt_ajax_view_meeting_detail',  'mj_smgt_ajax_view_meeting_detail');
add_action( 'wp_ajax_mj_smgt_active_student',  'mj_smgt_active_student');
add_action( 'wp_mj_smgt_ajax_smgt_result_pdf',  'mj_smgt_ajax_smgt_result_pdf');
add_action( 'wp_ajax_mj_smgt_load_user',  'mj_smgt_load_user');
add_action( 'wp_ajax_mj_smgt_load_section_user',  'mj_smgt_load_section_user');
add_action( 'wp_ajax_mj_smgt_load_books',  'mj_smgt_load_books');
add_action( 'wp_ajax_mj_smgt_load_class_fee_type',  'mj_smgt_load_class_fee_type');
add_action( 'wp_ajax_mj_smgt_load_section_fee_type',  'mj_smgt_load_section_fee_type');
add_action( 'wp_ajax_mj_smgt_load_fee_type_amount',  'mj_smgt_load_fee_type_amount');
add_action('wp_ajax_nopriv_mj_smgt_load_fee_type_amount','mj_smgt_load_fee_type_amount');
add_action( 'wp_ajax_mj_smgt_verify_pkey', 'mj_smgt_verify_pkey');
add_action( 'wp_ajax_mj_smgt_view_notice',  'mj_smgt_ajax_smgt_view_notice');
add_action( 'wp_ajax_mj_smgt_sms_service_setting',  'mj_smgt_sms_service_setting');
add_action( 'wp_ajax_mj_smgt_student_invoice_view',  'mj_smgt_student_invoice_view');
add_action( 'wp_ajax_mj_smgt_student_add_payment',  'mj_smgt_student_add_payment');
add_action( 'wp_ajax_mj_smgt_student_view_paymenthistory',  'mj_smgt_student_view_paymenthistory');
add_action( 'wp_ajax_mj_smgt_student_view_librarryhistory',  'mj_smgt_student_view_librarryhistory');
add_action( 'wp_ajax_mj_smgt_add_remove_feetype',  'mj_smgt_add_remove_feetype');
add_action( 'wp_ajax_nopriv_mj_smgt_add_remove_feetype',  'mj_smgt_add_remove_feetype');
add_action( 'wp_ajax_mj_smgt_add_fee_type',  'mj_smgt_add_fee_type');
add_action( 'wp_ajax_mj_smgt_remove_feetype',  'mj_smgt_remove_feetype');
add_action( 'wp_ajax_nopriv_mj_smgt_remove_feetype',  'mj_smgt_remove_feetype');

add_action( 'wp_ajax_mj_smgt_update_section',  'mj_smgt_update_section');
add_action( 'wp_ajax_mj_smgt_update_cancel_section',  'mj_smgt_update_cancel_section');
add_action( 'wp_ajax_mj_smgt_get_book_return_date',  'mj_smgt_get_book_return_date');
add_action( 'wp_ajax_mj_smgt_accept_return_book',  'mj_smgt_accept_return_book');
add_action( 'wp_ajax_mj_smgt_load_class_section',  'mj_smgt_load_class_section');
add_action( 'wp_ajax_nopriv_mj_smgt_load_class_section',  'mj_smgt_load_class_section');
add_action( 'wp_ajax_nopriv_mj_smgt_load_section_subject',  'mj_smgt_load_section_subject');
add_action( 'wp_ajax_mj_smgt_load_section_subject',  'mj_smgt_load_section_subject');
add_action( 'wp_ajax_nopriv_mj_smgt_load_class_student',  'mj_smgt_load_class_student');
add_action( 'wp_ajax_mj_smgt_load_class_student',  'mj_smgt_load_class_student');
add_action( 'wp_ajax_mj_smgt_notification_user_list','mj_smgt_notification_user_list');
add_action( 'wp_ajax_mj_smgt_document_user_list','mj_smgt_document_user_list');


add_action( 'wp_ajax_mj_smgt_class_by_teacher','mj_smgt_class_by_teacher');
add_action( 'wp_ajax_mj_smgt_teacher_by_class','mj_smgt_teacher_by_class');
add_action( 'wp_ajax_mj_smgt_sender_user_list','mj_smgt_sender_user_list');

add_action( 'wp_ajax_mj_smgt_frontend_sender_user_list','mj_smgt_frontend_sender_user_list');
add_action( 'wp_ajax_mj_smgt_change_profile_photo','mj_smgt_change_profile_photo');

add_action( 'wp_ajax_mj_smgt_assign_route','mj_smgt_assign_route');

add_action( 'wp_ajax_mj_smgt_count_student_in_class','mj_smgt_count_student_in_class');
add_action( 'wp_ajax_mj_smgt_count_student_in_class','mj_smgt_count_student_in_class');
add_action('wp_ajax_mj_smgt_show_event_task','mj_smgt_show_event_task');
add_action('wp_ajax_nopriv_mj_smgt_show_event_task','mj_smgt_show_event_task');

add_action('wp_ajax_mj_smgt_add_or_remove_category_new','mj_smgt_add_or_remove_category_new');
add_action('wp_ajax_nopriv_mj_smgt_add_or_remove_category_new','mj_smgt_add_or_remove_category_new');

add_action('wp_ajax_mj_smgt_add_category_new','mj_smgt_add_category_new');
add_action('wp_ajax_nopriv_mj_smgt_add_category_new','mj_smgt_add_category_new');

add_action('wp_ajax_mj_smgt_remove_category_new','mj_smgt_remove_category_new');
add_action('wp_ajax_nopriv_mj_smgt_remove_category_new','mj_smgt_remove_category_new');

add_action( 'wp_ajax_mj_smgt_admissoin_approved',  'mj_smgt_admissoin_approved');
add_action( 'wp_ajax_mj_smgt_view_all_relpy',  'mj_smgt_view_all_relpy');
add_action( 'wp_ajax_nopriv_mj_smgt_view_all_relpy',  'mj_smgt_view_all_relpy');
add_action( 'wp_ajax_mj_smgt_view_all_message',  'mj_smgt_view_all_message');
add_action( 'wp_ajax_nopriv_mj_smgt_view_all_message',  'mj_smgt_view_all_message');
add_action( 'wp_ajax_nopriv_mj_smgt_generate_access_token',  'mj_smgt_generate_access_token');
add_action( 'wp_ajax_mj_smgt_generate_access_token',  'mj_smgt_generate_access_token');

add_action( 'wp_ajax_nopriv_mj_smgt_import_data',  'mj_smgt_import_data');
add_action( 'wp_ajax_mj_smgt_import_data',  'mj_smgt_import_data');

add_action( 'wp_ajax_nopriv_mj_smgt_export_data',  'mj_smgt_export_data');
add_action( 'wp_ajax_mj_smgt_export_data',  'mj_smgt_export_data');

add_action( 'wp_ajax_nopriv_mj_smgt_student_import_data',  'mj_smgt_student_import_data');
add_action( 'wp_ajax_mj_smgt_student_import_data',  'mj_smgt_student_import_data');

add_action( 'wp_ajax_nopriv_mj_smgt_teacher_import_data',  'mj_smgt_teacher_import_data');
add_action( 'wp_ajax_mj_smgt_teacher_import_data',  'mj_smgt_teacher_import_data');

add_action( 'wp_ajax_nopriv_mj_smgt_support_staff_import_data',  'mj_smgt_support_staff_import_data');
add_action( 'wp_ajax_mj_smgt_support_staff_import_data',  'mj_smgt_support_staff_import_data');

add_action( 'wp_ajax_nopriv_mj_smgt_parent_import_data',  'mj_smgt_parent_import_data');
add_action( 'wp_ajax_mj_smgt_parent_import_data',  'mj_smgt_parent_import_data');

add_action( 'wp_ajax_nopriv_mj_smgt_subject_import_data',  'mj_smgt_subject_import_data');
add_action( 'wp_ajax_mj_smgt_subject_import_data',  'mj_smgt_subject_import_data');

add_action( 'wp_ajax_mj_smgt_load_multiple_day', 'mj_smgt_load_multiple_day');
add_action( 'wp_ajax_nopriv_mj_smgt_load_multiple_day',  'mj_smgt_load_multiple_day');

add_action( 'wp_ajax_mj_smgt_admission_repot_load_date', 'mj_smgt_admission_repot_load_date');
add_action( 'wp_ajax_nopriv_mj_smgt_admission_repot_load_date',  'mj_smgt_admission_repot_load_date');

function mj_smgt_view_all_relpy()
{

	global $wpdb;
	$sTable = $wpdb->prefix .'smgt_message_replies';
      $sTable_wp_users = $wpdb->prefix . 'users';
	 $sLimit = "10";
	 if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' )
	 {
	   $sLimit = "LIMIT ".intval( $_REQUEST['iDisplayStart'] ).", ".
	   intval( $_REQUEST['iDisplayLength'] );
	 }
	   $ssearch = $_REQUEST['sSearch'];
 	   if($ssearch)
	   {	      
			$sQuery = "SELECT * FROM  $sTable INNER JOIN $sTable_wp_users ON ($sTable.sender_id = $sTable_wp_users.ID OR $sTable.receiver_id = $sTable_wp_users.ID) WHERE sender_id LIKE '%$ssearch%' OR $sTable_wp_users.display_name LIKE '%$ssearch%' OR receiver_id LIKE '%$ssearch%' OR message_comment LIKE '%$ssearch%' OR created_date LIKE '%$ssearch%' ORDER BY $sTable.created_date DESC $sLimit"; 
			
			$rResult = $wpdb->get_results($sQuery, ARRAY_A);
			
			$wpdb->get_results("SELECT * FROM  $sTable INNER JOIN $sTable_wp_users ON ($sTable.sender_id = $sTable_wp_users.ID OR $sTable.receiver_id = $sTable_wp_users.ID) WHERE sender_id LIKE '%$ssearch%' OR $sTable_wp_users.display_name LIKE '%$ssearch%' OR receiver_id LIKE '%$ssearch%' OR message_comment LIKE '%$ssearch%' OR created_date LIKE '%$ssearch%' ORDER BY $sTable.created_date DESC"); 
			$iFilteredTotal = $wpdb->num_rows;
			$wpdb->get_results("SELECT * FROM  $sTable INNER JOIN $sTable_wp_users ON ($sTable.sender_id = $sTable_wp_users.ID OR $sTable.receiver_id = $sTable_wp_users.ID) WHERE sender_id LIKE '%$ssearch%' OR $sTable_wp_users.display_name LIKE '%$ssearch%' OR receiver_id LIKE '%$ssearch%' OR message_comment LIKE '%$ssearch%' OR created_date LIKE '%$ssearch%' ORDER BY $sTable.created_date DESC");
			$iTotal = $wpdb->num_rows;          
	   }
	   else
	   {
			$sQuery = "SELECT * FROM $sTable ORDER BY created_date DESC $sLimit";
			$rResult = $wpdb->get_results($sQuery, ARRAY_A);
			$wpdb->get_results("SELECT * FROM $sTable Group BY id , id DESC"); 
			$iFilteredTotal = $wpdb->num_rows;
			$wpdb->get_results(" SELECT * FROM $sTable Group BY id , id DESC");
			$iTotal = $wpdb->num_rows;          
	   }
		  $output = array(
		  "sEcho" => intval($_REQUEST['sEcho']),
		  "iTotalRecords" => $iTotal,
		  "iTotalDisplayRecords" => $iFilteredTotal,
		  "aaData" => array()
		 );	  
		 $i=0;
		 foreach($rResult as $aRow)
		 {
			if($i == 10)
			{
				$i=0;
			}
			if($i == 0)
			{
				$color_class='smgt_class_color0';
			}
			elseif($i == 1)
			{
				$color_class='smgt_class_color1';
			}
			elseif($i == 2)
			{
				$color_class='smgt_class_color2';
			}
			elseif($i == 3)
			{
				$color_class='smgt_class_color3';
			}
			elseif($i == 4)
			{
				$color_class='smgt_class_color4';
			}
			elseif($i == 5)
			{
				$color_class='smgt_class_color5';
			}
			elseif($i == 6)
			{
				$color_class='smgt_class_color6';
			}
			elseif($i == 7)
			{
				$color_class='smgt_class_color7';
			}
			elseif($i == 8)
			{
				$color_class='smgt_class_color8';
			}
			elseif($i == 9)
			{
				$color_class='smgt_class_color9';
			}	 

			$sender_info = get_userdata($aRow['sender_id']);
			
			$receiver_info = get_userdata($aRow['receiver_id']);
			$image_src= SMS_PLUGIN_URL."/assets/images/listpage_icon/More.png";
			$profile_image_src =SMS_PLUGIN_URL."/assets/images/dashboard_icon/White_icons/Message_Chat.png";
			
			$row[0] = '<td class="checkbox_width_10px">
							<input type="checkbox" class="smgt_sub_chk select-checkbox sub_chk" name="id[]" value="'.$aRow['id'].'">
						</td>';
			$row[1] = '<td class="user_image width_50px profile_image_prescription padding_left_0">
							<p class="smgt_message_profile prescription_tag padding_15px margin_bottom_0px '.$color_class.'">	
								<img src="'.$profile_image_src.'" height= "30px" width ="30px" alt="" class="massage_image center">
							</p>
						</td>';
			$row[2] ='<td>'.$sender_info->display_name.' <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="'.esc_html__('Sender','school-mgt').'" ></i></td>';
			$row[3] = '<td>'.$receiver_info->display_name.' <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="'.esc_html__('Receiver','school-mgt').'" ></i><td>';
			$body_char=strlen($msg->message_body);
			$body_char=strlen($aRow['message_comment']);
            if($body_char <= 60)
            {
                $row[4] = '<td>'.$aRow['message_comment'].' <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="'.esc_html__('Description','school-mgt').'" ></i></td>';
            }
            else
            {
                $char_limit = 60;
                $msg_body= substr(strip_tags($aRow['message_comment']), 0, $char_limit)."...";
                $row[4] ='<td>'. $msg_body.' <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="'.esc_html__('Description','school-mgt').'" ></i></td>';
            }
			$attchment=$aRow['message_attachment'];
			
			if(!empty($attchment))
			{
				$attchment_array=explode(',',$attchment);
				$view_attchment='';
				foreach($attchment_array as $attchment_data)
				{					
					$view_attchment.='<a target="blank" href="'.content_url().'/uploads/school_assets/'.$attchment_data.'" class="btn btn-default"><i class="fa fa-download"></i>'. esc_html__('View Attachment','school-mgt').'</a></br>';
				}
				$row[5] ='<td>'.$view_attchment.'</td>';
			}
			else
			{
				 $row[5] = '<td>'.esc_attr__('No Attachment','school-mgt').'</td>';
			}	
			$row[6] ='<td>'. mj_smgt_convert_date_time($aRow['created_date']).' <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="'.esc_html__('Date & Time','school-mgt').'" ></i></td>';
			$row[7] = '<td class="action">
							<div class="smgt-user-dropdown">
								<ul class="" style="margin-bottom: 0px !important;">
									<li class="">
										<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">
											<img src="'.$image_src.'" >
										</a>
										<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">
											<li class="float_left_width_100">
												<a href="?page=smgt_message&tab=view_all_message_reply&action=delete_users_reply_message&users_reply_message_id='.$aRow['id'].'" class="float_left_width_100" style="color: #f06c65!important;" onclick="return confirm(language_translate2.delete_record_alert)"><i class="fa fa-trash"></i> '. esc_attr__('Delete','school-mgt').'</a>
											</li>
										</ul>
									</li>
								</ul>
							</div>
						</td>';
			$output['aaData'][] = $row;
			$i++;
		}
	
 echo json_encode( $output );
 die();
}

function mj_smgt_view_all_message()
{
	global $wpdb;
	$sTable = $wpdb->prefix .'smgt_message';
    $sTable_wp_users = $wpdb->prefix . 'users';
	$tablename="smgt_class";
	$retrieve_class = mj_smgt_get_all_data($tablename);	
	$sLimit = "10";
	 if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' )
	 {
	   $sLimit = "LIMIT ".intval( $_REQUEST['iDisplayStart'] ).", ".
	   intval( $_REQUEST['iDisplayLength'] );
	 }
	   $ssearch = $_REQUEST['sSearch'];
 	   if($ssearch)
	   {	      
			$sQuery = "SELECT * FROM  $sTable INNER JOIN $sTable_wp_users ON ($sTable.sender = $sTable_wp_users.ID OR $sTable.receiver = $sTable_wp_users.ID) WHERE sender LIKE '%$ssearch%' OR $sTable_wp_users.display_name LIKE '%$ssearch%' OR receiver LIKE '%$ssearch%' OR subject LIKE '%$ssearch%' OR message_body LIKE '%$ssearch%' ORDER BY $sTable.date DESC $sLimit"; 
			
			$rResult = $wpdb->get_results($sQuery, ARRAY_A);
			
			$wpdb->get_results("SELECT * FROM  $sTable INNER JOIN $sTable_wp_users ON ($sTable.sender = $sTable_wp_users.ID OR $sTable.receiver = $sTable_wp_users.ID) WHERE sender LIKE '%$ssearch%' OR $sTable_wp_users.display_name LIKE '%$ssearch%' OR receiver LIKE '%$ssearch%' OR subject LIKE '%$ssearch%' OR message_body LIKE '%$ssearch%' ORDER BY $sTable.date DESC"); 
			$iFilteredTotal = $wpdb->num_rows;
			$wpdb->get_results("SELECT * FROM  $sTable INNER JOIN $sTable_wp_users ON ($sTable.sender = $sTable_wp_users.ID OR $sTable.receiver = $sTable_wp_users.ID) WHERE sender LIKE '%$ssearch%' OR $sTable_wp_users.display_name LIKE '%$ssearch%' OR receiver LIKE '%$ssearch%' OR subject LIKE '%$ssearch%' OR message_body LIKE '%$ssearch%' ORDER BY $sTable.date DESC");
			$iTotal = $wpdb->num_rows;          
	   }
	   else
	   {
			$sQuery = "SELECT * FROM $sTable ORDER BY date DESC limit $sLimit";
			$rResult = $wpdb->get_results($sQuery, ARRAY_A);
			$wpdb->get_results("SELECT * FROM $sTable Group BY message_id , message_id DESC"); 
			$iFilteredTotal = $wpdb->num_rows;
			$wpdb->get_results(" SELECT * FROM $sTable Group BY message_id , message_id DESC");
			$iTotal = $wpdb->num_rows;          
	   }
		  $output = array(
		  "sEcho" => intval($_REQUEST['sEcho']),
		  "iTotalRecords" => $iTotal,
		  "iTotalDisplayRecords" => $iFilteredTotal,
		  "aaData" => array()
		 );	  
		 
		 $i=0;
		foreach($rResult as $aRow)
		{		
			if($i == 10)
			{
				$i=0;
			}
			if($i == 0)
			{
				$color_class='smgt_class_color0';
			}
			elseif($i == 1)
			{
				$color_class='smgt_class_color1';
			}
			elseif($i == 2)
			{
				$color_class='smgt_class_color2';
			}
			elseif($i == 3)
			{
				$color_class='smgt_class_color3';
			}
			elseif($i == 4)
			{
				$color_class='smgt_class_color4';
			}
			elseif($i == 5)
			{
				$color_class='smgt_class_color5';
			}
			elseif($i == 6)
			{
				$color_class='smgt_class_color6';
			}
			elseif($i == 7)
			{
				$color_class='smgt_class_color7';
			}
			elseif($i == 8)
			{
				$color_class='smgt_class_color8';
			}
			elseif($i == 9)
			{
				$color_class='smgt_class_color9';
			}	 
			$user_id=$aRow['receiver'];
			$school_obj = new School_Management ($user_id);
						
			$attchment=get_post_meta( $aRow['post_id'], 'message_attachment',true);
			
			$sender_info = get_userdata($aRow['sender']);
			
			$receiver_info = get_userdata($aRow['receiver']);
			$image_src= SMS_PLUGIN_URL."/assets/images/listpage_icon/More.png";
			$profile_image_src =SMS_PLUGIN_URL."/assets/images/dashboard_icon/White_icons/Message_Chat.png";


			$row[0] = '<td class="checkbox_width_10px"><input type="checkbox" class="smgt_sub_chk select-checkbox sub_chk" name="id[]" value="'.$aRow['message_id'].'"></td>';
			$message_for=get_post_meta( $aRow['post_id'], 'message_for',true);

			$row[1] = '<td class="user_image width_50px profile_image_prescription padding_left_0">
					<p class="smgt_message_profile prescription_tag padding_15px margin_bottom_0px '.$color_class.'">	
						<img src="'.$profile_image_src.'" height= "30px" width ="30px" alt="" class="massage_image center">
					</p>
				</td>';
						
			$row[2] = '<td>'.esc_attr__($message_for,'school-mgt').' <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="'.esc_html__('Message For','school-mgt').'" ></i></td>';
			$row[3] = '<td>'.$sender_info->display_name.' <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="'.esc_html__('Sender','school-mgt').'" ></i></td>';
			$row[4] ='<td>'. $receiver_info->display_name.' <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="'.esc_html__('Receiver','school-mgt').'" ></i></td>';
			
			if(get_post_meta( $aRow['post_id'], 'smgt_class_id',true) !="" && get_post_meta( $aRow['post_id'], 'smgt_class_id',true) == 'all')
			{					
				$row[5] ='<td>'. esc_attr_e('All','school-mgt').' <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="'.esc_html__('Class','school-mgt').'" ></i></td>';
			}
			elseif(get_post_meta( $aRow['post_id'], 'smgt_class_id',true) !="")
			{
				$smgt_class_id=get_post_meta( $aRow['post_id'], 'smgt_class_id',true);
				$class_id_array=explode(',',$smgt_class_id);
				$class_name_array=array();
				foreach($class_id_array as $data)
				{						
					$class_name_array[]=mj_smgt_get_class_name($data);
						
				}
				$row[5] ='<td>'. implode(',',$class_name_array).' <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="'.esc_html__('Class','school-mgt').'" ></i></td>';				
			}
			else
			{
				$row[5] ='<td>'. esc_html__('All','school-mgt').' <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="'.esc_html__('Class','school-mgt').'" ></i></td>';
			}
			$subject_char=strlen(get_the_title($aRow['post_id']));
	        if($subject_char <= 10)
	        {
	            $row[6] ='<td>'. get_the_title($aRow['post_id']).' <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="'.esc_html__('Subject','school-mgt').'" ></i></td>';
	        }
	        else
	        {
	            $char_limit = 10;
	            $subject_body= substr(strip_tags(get_the_title($aRow['post_id'])), 0, $char_limit)."...";
	            $row[6] ='<td>'. $subject_body.' <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="'.esc_html__('Subject','school-mgt').'" ></i></td>';
	        }
	        $content_post = get_post($aRow['post_id']);
	        $body_char=strlen($content_post->post_content);
            if($body_char <= 60)
            {
                $row[7] ='<td>'. $content_post->post_content.' <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="'.esc_html__('Description','school-mgt').'" ></i></td>';
            }
            else
            {
                $char_limit = 60;
                $msg_body= substr(strip_tags($content_post->post_content), 0, $char_limit)."...";
                $row[7] ='<td>'. $msg_body.' <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="'.esc_html__('Description','school-mgt').'" ></i></td>';
            }
			// $row[6] = $content_post->post_content; 
			if(!empty($attchment))
			{
				$attchment_array=explode(',',$attchment);
				$view_attchment='';
				
				foreach($attchment_array as $attchment_data)
				{		
					$view_attchment.='<a target="blank" href="'.content_url().'/uploads/school_assets/'.$attchment_data.'" class="btn btn-default"><i class="fa fa-download"></i>'. esc_html__('View Attachment','school-mgt').'</a>';
				}
				$row[8] ='<td>'.$view_attchment.'</td>';
			}
			else
			{
				 $row[8] ='<td>'. esc_attr__('No Attachment','school-mgt').'</td>';
			}
			$created_date=$content_post->post_date_gmt;
			
			$row[9] ='<td>'. mj_smgt_convert_date_time($created_date).' <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="'.esc_html__('Date & Time','school-mgt').'" ></i></td>';
			
			$row[10] = '<td class="action">
							<div class="smgt-user-dropdown">
								<ul class="" style="margin-bottom: 0px !important;">
									<li class="">
										<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">
											<img src="'.$image_src.'" >
										</a>
										<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">
											<li class="float_left_width_100">

												<a href="?page=smgt_message&tab=view_all_message&action=delete_users_message&users_message_id='.$aRow['message_id'].'" class="float_left_width_100" style="color: #f06c65!important;" onclick="return confirm(language_translate2.delete_record_alert)"><i class="fa fa-trash"></i>'. esc_attr__('Delete','school-mgt').'</a>
												</li>
											</ul>
										</li>
									</ul>
								</div>
							</td>';
						
			$output['aaData'][] = $row;
			$i++;
		}
	
 echo json_encode( $output );
 die();
}
function mj_smgt_verify_pkey()
{
	$api_server = 'license.dasinfomedia.com';
	$fp = fsockopen($api_server,80, $errno, $errstr, 2);
	$location_url = admin_url().'admin.php?page=smgt_school';
	if (!$fp)
              $server_rerror = 'Down';
        else
              $server_rerror = "up";
	if($server_rerror == "up")
	{
	$domain_name= $_SERVER['SERVER_NAME'];
	$licence_key = $_REQUEST['licence_key'];
	$email = $_REQUEST['enter_email'];
	$data['domain_name']= $domain_name;
	$data['licence_key']= $licence_key;
	$data['enter_email']= $email;

	$result = mj_smgt_check_productkey($domain_name,$licence_key,$email);
	if($result == '1')
	{
		$message = esc_attr__('Please provide correct Envato purchase key.','school-mgt');
			$_SESSION['cmgt_verify'] = '1';
	}
	elseif($result == '2')
	{
		$message = 'This purchase key is already registered with the different domain. If have any issue please contact us at sales@mojoomla.com';
			$_SESSION['cmgt_verify'] = '2';
	}
	elseif($result == '3')
	{
		$message = 'There seems to be some problem please try after sometime or contact us on sales@mojoomla.com';
			$_SESSION['cmgt_verify'] = '3';
	}
	elseif($result == '4')
	{
		$message = esc_attr__('Please provide correct Envato purchase key for this plugin.','school-mgt');
			$_SESSION['cmgt_verify'] = '4';
	}
	else{
		update_option('domain_name',$domain_name,true);
	update_option('licence_key',$licence_key,true);
	update_option('cmgt_setup_email',$email,true);
		$message = 'Success fully register';
			$_SESSION['cmgt_verify'] = '0';
	}
	
	
	$result_array = array('message'=>$message,'cmgt_verify'=>$_SESSION['cmgt_verify'],'location_url'=>$location_url);
	echo json_encode($result_array);
	}
	else
	{
		$message = 'Server is down Please wait some time';
		$_SESSION['cmgt_verify'] = '3';
		$result_array = array('message'=>$message,'cmgt_verify'=>$_SESSION['cmgt_verify'],'location_url'=>$location_url);
	echo json_encode($result_array);
	}
	die();
}
//section select to load subject
function mj_smgt_load_subject_class_id_and_section_id()
{
		$class_id =$_POST['class_id'];
		$section_id =$_POST['section_id'];
		
		global $wpdb;
		$table_name = $wpdb->prefix . "subject";
		$table_name2 = $wpdb->prefix . "teacher_subject";
		$user_id=get_current_user_id();
		//------------------------TEACHER ACCESS---------------------------------//
		$teacher_access = get_option( 'smgt_access_right_teacher');
		$teacher_access_data=$teacher_access['teacher'];
		foreach($teacher_access_data as $key=>$value)
		{
			if($key=='subject')
			{
				$data=$value;
			}
		}
		if(mj_smgt_get_roles($user_id)=='teacher' && $data['own_data']=='1')
		{
		    if($section_id =='')
			{
			  $retrieve_subject = $wpdb->get_results( "SELECT * FROM $table_name where  teacher_id=$user_id and class_id=".$class_id);
			}
			else
			{
			  $retrieve_subject = $wpdb->get_results( "SELECT p1.*,p2.* FROM $table_name p1 INNER JOIN $table_name2 p2 ON(p1.subid = p2.subject_id) WHERE p2.teacher_id = $user_id AND p1.class_id = $class_id AND p1.section_id=$section_id");
			}
			
		}
		elseif(mj_smgt_get_roles($user_id)=='teacher')
		{
			  $retrieve_subject = $wpdb->get_results( "SELECT p1.*,p2.* FROM $table_name p1 INNER JOIN $table_name2 p2 ON(p1.subid = p2.subject_id) WHERE p2.teacher_id = $user_id AND p1.class_id = $class_id AND p1.section_id=$section_id");
		}
		elseif(is_admin())
		{
		  $retrieve_subject = $wpdb->get_results( "SELECT p1.* FROM $table_name p1 WHERE p1.class_id = $class_id AND p1.section_id=$section_id");
		}
		else
		{
			$retrieve_subject = $wpdb->get_results( "SELECT * FROM $table_name WHERE class_id=".$class_id);
		}
		$defaultmsg= esc_attr__( 'Select subject' , 'school-mgt');
		echo "<option value=''>".$defaultmsg."</option>";	
		foreach($retrieve_subject as $retrieved_data)
		{
			echo "<option value=".$retrieved_data->subid."> ".$retrieved_data->sub_name ."</option>";
		}
		exit;
}
/*Delete Notification*/
function mj_smgt_delete_notification($notification_id)
{
	global $wpdb;
	$smgt_notification = $wpdb->prefix. 'smgt_notification';
	$result = $wpdb->query("DELETE FROM $smgt_notification WHERE notification_id=$notification_id");
	return $result;
}
/* Notification user list*/
function mj_smgt_notification_user_list()
{
	$school_obj = new School_Management ( get_current_user_id () );	
	
	
	$class_list = isset($_REQUEST['class_list'])?$_REQUEST['class_list']:'';
	$class_section = isset($_REQUEST['class_section'])?$_REQUEST['class_section']:'';
	$exlude_id = mj_smgt_approve_student_list();

	
	$html_class_section = '';
	$return_results['section'] = '';
	$user_list = array();
	global $wpdb;
	$defaultmsg= esc_attr__( 'All' , 'school-mgt');
	$html_class_section =  "<option value='All'>".$defaultmsg."</option>";	
	if($class_list != '')
	{
		$retrieve_data=mj_smgt_get_class_sections($class_list);	
		if($retrieve_data)
		foreach($retrieve_data as $section)
		{
			$html_class_section .= "<option value='".$section->id."'>".$section->section_name."</option>";
		}
	}
		
	$query_data['exclude']=$exlude_id;
	if($class_section != 'All' && $class_section != ''){
		$query_data['meta_key'] = 'class_section';
		$query_data['meta_value'] = $class_section;
		$query_data['meta_query'] = array(array('key' => 'class_name','value' => $class_list,'compare' => '=') );
		$results = get_users($query_data);
	}
	elseif($class_list != ''){
		$query_data['meta_key'] = 'class_name';
		$query_data['meta_value'] = $class_list;
		$results = get_users($query_data);
	}
	
	if(isset($results))
	{
		foreach($results as $user_datavalue)
			$user_list[] = $user_datavalue->ID;
	}

	
	$user_data_list = array_unique($user_list);
	$return_results['section'] = $html_class_section;
	$return_results['users'] = '';
	$user_string  = '<select name="selected_users" id="notification_selected_users" class="line_height_30px form-control max_width_100">';
	$user_string .= '<option value="All">'. esc_attr__('All','school-mgt').'</option>';
	if(!empty($user_data_list))
	foreach($user_data_list as $retrive_data)
	{
		$user_string .= "<option value='".$retrive_data."'>".mj_smgt_get_user_name_byid($retrive_data)."</option>";
	}
	$user_string .= '</select>';
	$return_results['users'] = $user_string;
	echo json_encode($return_results);
	die();
}

/* Document user list*/

function mj_smgt_document_user_list()
{

	$school_obj = new School_Management ( get_current_user_id () );	
	
	$class_list = isset($_REQUEST['class_list'])?$_REQUEST['class_list']:'';
	$class_section = isset($_REQUEST['class_section'])?$_REQUEST['class_section']:'';
	$exlude_id = mj_smgt_approve_student_list();

	$html_class_section = '';
	$return_results['section'] = '';
	$user_list = array();
	global $wpdb;
	$defaultmsg= esc_attr__( 'All Section' , 'school-mgt');
	$html_class_section =  "<option value='all section'>".$defaultmsg."</option>";	
	if($class_list != '')
	{
		$retrieve_data=mj_smgt_get_class_sections($class_list);	
		if($retrieve_data)
		foreach($retrieve_data as $section)
		{
			$html_class_section .= "<option value='".$section->id."'>".$section->section_name."</option>";
		}
	}
		
	$query_data['exclude']=$exlude_id;
	if($class_section != 'All' && $class_section != ''){
		$query_data['meta_key'] = 'class_section';
		$query_data['meta_value'] = $class_section;
		$query_data['meta_query'] = array(array('key' => 'class_name','value' => $class_list,'compare' => '=') );
		$results = get_users($query_data);
	}
	elseif($class_list != ''){
		$query_data['meta_key'] = 'class_name';
		$query_data['meta_value'] = $class_list;
		$results = get_users($query_data);
	}
	
	if(isset($results))
	{
		foreach($results as $user_datavalue)
			$user_list[] = $user_datavalue->ID;
	}

	
	$user_data_list = array_unique($user_list);
	$return_results['section'] = $html_class_section;
	$return_results['users'] = '';
	$user_string  = '<select name="selected_users" id="notification_selected_users" class="line_height_30px form-control max_width_100">';
	$user_string .= '<option value="all student">'. esc_attr__('All Student','school-mgt').'</option>';
	if(!empty($user_data_list))
	foreach($user_data_list as $retrive_data)
	{
		$user_string .= "<option value='".$retrive_data."'>".mj_smgt_get_user_name_byid($retrive_data)."</option>";
	}
	$user_string .= '</select>';
	$return_results['users'] = $user_string;
	echo json_encode($return_results);
	die();


	// $school_obj = new School_Management ( get_current_user_id () );	
	// $class_list = isset($_REQUEST['class_list'])?$_REQUEST['class_list']:'';
	// $class_section = isset($_REQUEST['class_section'])?$_REQUEST['class_section']:'';
	// $exlude_id = mj_smgt_approve_student_list();

	// $html_class_section = '';
	// $return_results['section'] = '';
	// $user_list = array();
	// global $wpdb;
	// $defaultmsg= esc_attr__( 'All Section' , 'school-mgt');
	// $html_class_section =  "<option value='all section'>".$defaultmsg."</option>";	
	// if($class_list != '')
	// {
	// 	$retrieve_data=mj_smgt_get_class_sections($class_list);	
	// 	if($retrieve_data)
	// 	foreach($retrieve_data as $section)
	// 	{
	// 		$html_class_section .= "<option value='".$section->id."'>".$section->section_name."</option>";
	// 	}
	// }
		
	// $query_data['exclude']=$exlude_id;
	// if($class_section != 'all section' && $class_section != ''){
	// 	$query_data['meta_key'] = 'class_section';
	// 	$query_data['meta_value'] = $class_section;
	// 	$query_data['meta_query'] = array(array('key' => 'class_name','value' => $class_list,'compare' => '=') );
	// 	$results = get_users($query_data);
	// }
	// elseif($class_list != ''){
	// 	$query_data['meta_key'] = 'class_name';
	// 	$query_data['meta_value'] = $class_list;
	// 	$results = get_users($query_data);
	// }
	
	// if(isset($results))
	// {
	// 	foreach($results as $user_datavalue)
	// 		$user_list[] = $user_datavalue->ID;
	// }

	// $user_data_list = array_unique($user_list);
	// $return_results['section'] = $html_class_section;
	// $return_results['users'] = '';
	// $user_string  = '<select name="selected_users" id="document_selected_users" class="line_height_30px form-control max_width_100">';
	// $user_string .= '<option value="all student">'. esc_attr__('All Student','school-mgt').'</option>';
	// if(!empty($user_data_list))
	// foreach($user_data_list as $retrive_data)
	// {
		
	// 	$user_string .= "<option value='".$retrive_data."'>".mj_smgt_get_user_name_byid($retrive_data).'('.$retrive_data.')'."</option>";
	// }
	// $user_string .= '</select>';
	// $return_results['users'] = $user_string;
	// echo json_encode($return_results);
	// die();
}

function mj_smgt_check_book_issued($student_id)
{
	global $wpdb;
	$table_issuebook=$wpdb->prefix.'smgt_library_book_issue';
	$booklist = $wpdb->get_results("SELECT * FROM $table_issuebook where student_id=$student_id and ( status='Issue' OR status ='Submitted')");
	return $booklist;
}

//--------  Accept And Return Book Pop-up  -------------//
function mj_smgt_accept_return_book()
{
	?>
	<SCRIPT language=Javascript>
	function isNumberKey(evt)
	{
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;

		return true;
	}
	</SCRIPT>
	<?php
		$stud_id=$_REQUEST['student_id'];
		global $wpdb;
		$table_issuebook=$wpdb->prefix.'smgt_library_book_issue';
		$booklist = $wpdb->get_results("SELECT * FROM $table_issuebook where student_id=$stud_id and status='Issue'");
		$student=get_userdata($stud_id);
	?>
	<div class="modal-header model_header_padding dashboard_model_header">
		<a href="javascript:void(0);" class="event_close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>
  		<h4 id="myLargeModalLabel" class="modal-title"><?php echo $student->display_name; ?>(<?php esc_attr_e('Date','school-mgt'); ?> <?php esc_attr_e(':','school-mgt'); ?> <?php echo date('Y-m-d'); ?>)</h4>
	</div>
	<div class="panel-white libraryhistory_panal_white_div"><!----------  panel-white div------------>
		<div class="modal-body"><!----------  Model Body div------------>
			<div id="invoice_print" class="exam_table_res table-responsive"> 
				<?php
				if(!empty($booklist))
				{ 
					?>
					<form name="issue_book-return" method="post">
						<table class="table table-bordered" style="border: 1px solid #D9E1ED;text-align: center;margin-bottom: 0px;"  width="100%">
							<thead>
								<tr>
									<th class="_hall_receipt_table_heading" style="border-top: medium none;border-right: 1px solid #D9E1ED;background-color: #F2F5FA;border-bottom: 1px solid #D9E1ED;text-align: center;"></th>
									<th class="exam_hall_receipt_table_heading" style="border-right: 1px solid #D9E1ED;background-color: #F2F5FA;border-bottom: 1px solid #D9E1ED;text-align: center;"><?php esc_attr_e('Book Title','school-mgt');?></th>
									<th class="exam_hall_receipt_table_heading" style="border-right: 1px solid #D9E1ED;background-color: #F2F5FA;border-bottom: 1px solid #D9E1ED;text-align: center;"><?php esc_attr_e('Overdue By','school-mgt');?></th>
									<th class="exam_hall_receipt_table_heading" style="background-color: #F2F5FA;border-bottom: 1px solid #D9E1ED;text-align: center;"> <?php esc_attr_e('Fine','school-mgt');?></th>
								</tr>
							</thead>
							<tbody>
								<?php 
								foreach($booklist as  $retrieved_data)
								{
									$date1=date_create(date('Y-m-d'));
									$date2=date_create(date("Y-m-d", strtotime($retrieved_data->end_date)));
									$diff=date_diff($date2,$date1);
									?>
									<tr style="border: 1px solid #D9E1ED;">
										<td class="exam_hall_receipt_table_value" style="border-right: 1px solid #D9E1ED;"><input type="checkbox" value="<?php echo $retrieved_data->id;?>" name="books_return[]"></td>
										<td class="exam_hall_receipt_table_value" style="border-right: 1px solid #D9E1ED;"><?php echo stripslashes(mj_smgt_get_bookname($retrieved_data->book_id));?></td>
										<td class="exam_hall_receipt_table_value" style="border-right: 1px solid #D9E1ED;"><?php if ($date1 > $date2) echo $diff->format("%a "). esc_attr__("Days","school-mgt"); else echo esc_attr__("0 Days","school-mgt");?></td>
										<td class="exam_hall_receipt_table_value" style="border-right: 1px solid #D9E1ED;">
											<input type="number" min="0" class="validate[required,min[0],maxSize[5]] number accept_return_table_input" onkeypress="return isNumberKey(event)" name="fine[]" value=""> 
										</td>
									</tr>
									<?php 
								} ?>
							</tbody>
							<tr>
								<td colspan="4">
									<input type="submit" class="btn btn-success save_btn library_submit_btn_css" name="submit_book" value="<?php esc_attr_e("Submit Book","school-mgt");?>" >
								</td>
							</tr>
						</table>
					</form>
					<?php 
				}
				else
				{
					esc_attr_e('No Book Issued','school-mgt');
				} ?>
			</div>
		</div>
	</div>
	<?php 
	die();
}

function mj_smgt_get_book_return_date()
{
	$period_days=get_the_title($_REQUEST['issue_period']);
	$date = date_create($_REQUEST['issue_date']);
	$olddate=date_format($date, 'Y-m-d');
	echo date('Y-m-d', strtotime($olddate. ' + '.$period_days.'Days'));
	die();
}

function mj_smgt_load_subject()
{
	$class_id =$_POST['class_list'];
	global $wpdb;
	$table_name = $wpdb->prefix . "subject";
	$table_name2 = $wpdb->prefix . "teacher_subject";
	$user_id=get_current_user_id();
	if(mj_smgt_get_roles($user_id)=='teacher') 
	{
		$retrieve_subject = $wpdb->get_results( "SELECT p1.*,p2.* FROM $table_name p1 INNER JOIN $table_name2 p2 ON(p1.subid = p2.subject_id) WHERE p2.teacher_id = $user_id AND p1.class_id = $class_id");
	}
	else
	{
		$retrieve_subject = $wpdb->get_results( "SELECT * FROM $table_name WHERE class_id=".$class_id);
	}
	$defaultmsg= esc_attr__('Select subject','school-mgt');	
	echo "<option value=''>".$defaultmsg."</option>";	
	foreach($retrieve_subject as $retrieved_data)
	{
		echo "<option value=".$retrieved_data->subid."> ".$retrieved_data->sub_name ."</option>";
	}
	exit;
}

function mj_smgt_load_section_subject()
{
		
		$section_id =$_POST['section_id'];
		global $wpdb;
		$table_name = $wpdb->prefix . "subject";
		$user_id=get_current_user_id();
		//------------------------TEACHER ACCESS---------------------------------//
		$teacher_access = get_option( 'smgt_access_right_teacher');
		$teacher_access_data=$teacher_access['teacher'];
		foreach($teacher_access_data as $key=>$value)
		{
			if($key=='subject')
			{
				$data=$value;
			}
		}
		if(mj_smgt_get_roles($user_id)=='teacher' && $data['own_data']=='1')
		{
			$retrieve_subject = $wpdb->get_results( "SELECT * FROM $table_name where  teacher_id=$user_id and section_id=".$section_id);
		}
		else
		{
			$retrieve_subject = $wpdb->get_results( "SELECT * FROM $table_name WHERE section_id=".$section_id);
		}
		$defaultmsg= esc_attr__( 'Select subject' , 'school-mgt');
			
		echo "<option value=''>".$defaultmsg."</option>";	
		foreach($retrieve_subject as $retrieved_data)
		{
			echo "<option value=".$retrieved_data->subid."> ".$retrieved_data->sub_name ."</option>";
		}
		exit;
}

function mj_smgt_load_class_student(){
	$class_list = $_REQUEST['class_list'];
	$args = array(
		'role'=>'student',
		'meta_key'=>'class_name',
		'meta_value'=>$class_list

	);
	$result = get_users( $args );
	foreach($result as $key=>$value){
		print "Yes";
	}
exit;

}
function mj_smgt_load_exam()
{
		
	$class_id =$_POST['class_id'];
	global $wpdb;
	
	$table_name_exam = $wpdb->prefix . "exam";
 
		$retrieve_exam = $wpdb->get_results( "SELECT * FROM $table_name_exam where  class_id=$class_id");
		 
		$defaultmsg= esc_attr__( 'Select Exam' , 'school-mgt');
			
		echo "<option value=''>".$defaultmsg."</option>";	
		foreach($retrieve_exam as $retrieved_data)
		{
			echo "<option value=".$retrieved_data->exam_id."> ".$retrieved_data->exam_name ."</option>";
		}
		exit;
}

function mj_smgt_load_exam_by_section()
{
	$class_id =$_POST['class_id'];
	$section_id =$_POST['section_id'];
	
	global $wpdb;
	$table_name_exam = $wpdb->prefix . "exam";
 
		$retrieve_exam = $wpdb->get_results( "SELECT * FROM $table_name_exam where  class_id=$class_id and section_id=$section_id");
		 
		$defaultmsg= esc_attr__( 'Select Exam' , 'school-mgt');
			
		echo "<option value=''>".$defaultmsg."</option>";	
		if(!empty($retrieve_exam))
		{
			foreach($retrieve_exam as $retrieved_data)
			{
				echo "<option value=".$retrieved_data->exam_id."> ".$retrieved_data->exam_name ."</option>";
			}
		}
		
	exit;
}

function mj_smgt_ajax_smgt_result()
{
	$obj_mark = new Marks_Manage(); 
	$uid = $_REQUEST['student_id'];
	$user =get_userdata( $uid );
	$user_meta =get_user_meta($uid);
	
	$class_id = $user_meta['class_name'][0];
	
	$section_id = $user_meta['class_section'][0];

	$subject = $obj_mark->mj_smgt_student_subject_list($class_id,$section_id);
	$total_subject=count($subject);
	$total = 0;
	$grade_point = 0;
	if((int)$section_id !== 0)
	{
		$all_exam = mj_smgt_get_all_exam_by_class_id_and_section_id_array($class_id,$section_id);
	}
	else
	{
		$all_exam = mj_smgt_get_all_exam_by_class_id($class_id);
	}
	
	?>
	<style>
	 .modal-header{
		 height:auto;
	 }
	</style>
<div class="panel-white">
	<div class="modal-header model_header_padding dashboard_model_header"> 
		<a href="javascript:void(0);" class="close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>
		<h4 id="myLargeModalLabel" class="modal-title"><?php echo mj_smgt_get_user_name_byid($uid);?>'s <?php esc_attr_e('Result','school-mgt')?></h4>
	</div>	
  	<?php 
	if(!empty($all_exam))
	{ 
	   ?>
	  <div class="clearfix"></div>
			<div id="accordionExample" class="accordion student_accordion" aria-multiselectable="true" role="tablist">
				<?php 
				$i=0;
				foreach ($all_exam as $exam) /* #### ALL EXAM LOOP STARTS  */
				{
					$exam_id =$exam->exam_id; ?>
					<div class="mt-2 accordion-item">
						<h4 class="accordion-header" id="heading_<?php echo $i;?>"> 
							<button class="accordion-button student_result_collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_<?php echo $i;?>" aria-expanded="true" aria-controls="heading_<?php echo $i;?>">
							<div class="col-md-10">
								<span class="student_exam_result"><?php esc_attr_e('Exam Results : ','school-mgt'); ?></span> &nbsp;
								<span class="student_exam_name"><?php echo $exam->exam_name; ?></span>
							</div>
							<?php
							foreach($subject as $sub) /*** ####  SUBJECT LOOPS STARTS **/
							{
								$marks = $obj_mark->mj_smgt_get_marks($exam_id,$class_id,$sub->subid,$uid);
								if(!empty($marks))
								{
									$new_marks = $marks;
								}
							}
							if(!empty($new_marks))
							{
								?>
								<div class="col-md-2 row justify-content-end smt_view_result">
									<div class="col-md-5 width_50">
										<a href="?page=smgt_student&print=pdf&student=<?php echo $uid;?>&exam_id=<?php echo $exam_id;?>" class="float_right" target="_blank"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/PDF.png"?>" alt=""></a>
									</div>
									<div class="col-md-4 width_50 rtl_margin_left_20px" style="margin-right:22px;">
										<a href="?page=smgt_student&print=print&student=<?php echo $uid;?>&exam_id=<?php echo $exam_id;?>" class="float_right" target="_blank" ><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Print.png"?>" alt=""></a>
									</div>
								</div>
								<?php
							}
							else
							{
								?>
								<span class="student_exam_name">
									<?php esc_attr_e('No Result','school-mgt'); ?>
								</span>
								<?php	
							}
							?>
							</button> 
						</h4>
						<div id="collapse_<?php echo $i;?>" class="accordion-collapse collapse" aria-labelledby="heading_<?php echo $i;?>" data-bs-parent="#accordionExample">
							<div class="clearfix"></div>
								<div class="clearfix"></div>
								<div class="view_result">
									<?php
									if(!empty($new_marks))
									{
										?>
										<div class="table-responsive view_result_table_responsive">				  
											<table class="table table-bordered">
											<tr>
												<th class="view_result_table_heading"><?php esc_attr_e('Subject','school-mgt')?></th>
												<th class="view_result_table_heading"><?php esc_attr_e('Obtain Mark','school-mgt')?></th>
												<th class="view_result_table_heading"><?php esc_attr_e('Grade','school-mgt')?></th>
												<th class="view_result_table_heading"><?php esc_attr_e('Grade Comment','school-mgt')?></th>
											</tr>
											<?php	
												
												$total=0;
												$grade_point = 0; 
												foreach($subject as $sub) /*** ####  SUBJECT LOOPS STARTS **/
												{
													$marks = $obj_mark->mj_smgt_get_marks($exam_id,$class_id,$sub->subid,$uid);
													?>
													<tr>
														<td class="view_result_table_value"><?php echo $sub->sub_name;?></td>
														<td class="view_result_table_value"><?php echo $marks;?> </td>
														<td class="view_result_table_value"><?php echo $obj_mark->mj_smgt_get_grade($exam_id,$class_id,$sub->subid,$uid);?></td>
														<td class="view_result_table_value"><?php echo $obj_mark->mj_smgt_get_grade_marks_comment($obj_mark->mj_smgt_get_grade($exam_id,$class_id,$sub->subid,$uid));?></td>
													</tr>
													<?php
													$total +=  $marks;
													$grade_point += $obj_mark->mj_smgt_get_grade_point($exam_id,$class_id,$sub->subid,$uid);
												} 
											/*####  SUBJECT LOOPS ENDS **/ ?>
											</table>
											<div class="row col-md-12">
												<div class="col-md-6 view_result_total"><?php esc_attr_e("Total Marks","school-mgt"); echo " : "; ?><span class="view_result_total_int"><?php echo $total; ?></span></div>
												<div class="col-md-6 view_result_total"><?php	esc_attr_e("GPA(grade point average)","school-mgt"); $GPA=$grade_point/$total_subject; echo " : "; ?><span class="view_result_total_int"><?php echo round($GPA, 2) ;?></span></div>
											</div>
										</div>
										<?php
									} 
									else
									{
										?>
										<div class="col-md-12" style="text-align:center;padding:10px;">
											<span class="student_exam_name">
												<?php esc_attr_e('No Result Available.','school-mgt'); ?>
											</span>
										</div>
										<?php	
									}
									?>
								</div>
							</div>
						</div>
						<?php
					$i++;
				}  /* #### ALL EXAM LOOP ENDS  */ ?>
			</div>
		</div>
		<?php 
	}
	else 
	{
		?>
		<div class="modal-header model_header_padding dashboard_model_header"> 
			<h6 id="myLargeModalLabel"><?php echo esc_attr_e('No Result Found','school-mgt'); ?></h6>
		</div>
		<?php
		
	}
	exit;
}
function mj_smgt_active_student()
{
	$uid = $_REQUEST['student_id'];
	?>
	<div class="form-group popup_heder_marging"> 	
		<a href="#" class="close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>
		<h4 class="modal-title" id="myLargeModalLabel"><?php echo get_option( 'smgt_school_name' );?></h4>
	</div>
	<div class="panel-body padding_15px">
		<div class="panel-heading">
			<h4 class="panel-title"><?php echo mj_smgt_get_user_name_byid($uid);?></h4>
		</div>
		<form name="expense_form" action="" method="post" class="margin_top_15px form-horizontal" id="expense_form">
			<input type="hidden" name="act_user_id" value="<?php echo $uid;?>">
			<div class="form-body user_form"> <!--form Body div-->   
				<div class="row"><!--Row Div--> 
					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
						<div class="form-group input">
							<div class="col-md-12 form-control">
								<input id="roll_id" class="form-control validate[required,custom[onlyNumberSp]] text-input" maxlength="6" type="text" value="" name="roll_id">
								<label class="" for="roll_id"><?php esc_attr_e('Roll Number','school-mgt');?><span class="require-field">*</span></label>
							</div>
						</div>
					</div>
					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 padding_top_15px_res rtl_margin_top_15px">
						<div class="form-group">
							<div class="col-md-12 form-control checkbox_height_47px">
								<div class="row padding_radio">
									<div class="">
										<label class="custom-top-label" for="smgt_enable_homework_sms"><?php esc_attr_e('Send Mail','school-mgt');?></label>
										<input id="chk_sms_sent1" class=" check_box_input_margin" type="checkbox" <?php $smgt_student_mail_service_enable = 0;if($smgt_student_mail_service_enable) echo "checked";?> value="1" name="smgt_student_mail_service_enable"> <?php esc_attr_e('Enable','school-mgt');?>
									</div>												
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 padding_top_15px_res rtl_margin_top_15px">
						<div class="form-group">
							<div class="col-md-12 form-control checkbox_height_47px">
								<div class="row padding_radio">
									<div class="">
										<label class="custom-top-label" for="smgt_enable_homework_sms"><?php esc_attr_e('Send SMS','school-mgt');?></label>
										<input id="chk_sms_sent1" class="" type="checkbox" <?php $smgt_studnet_sms_service_enable = 0;if($smgt_studnet_sms_service_enable) echo "checked";?> value="1" name="smgt_studnet_sms_service_enable"> &nbsp;<?php esc_attr_e('Enable','school-mgt');?>
									</div>												
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="form-body user_form margin_top_15px"> <!--form Body div-->   
				<div class="row"><!--Row Div--> 
					<div class="col-sm-6">
						<input type="submit" value="<?php esc_attr_e('Active Student','school-mgt');?>" name="active_user" class="btn save_btn"/>
					</div>
				</div>
			</div>
	</form>
	</div>
  <?php
  die();
}
function mj_smgt_downlosd_smgt_result_pdf($sudent_id)
{
	ob_start();
	$obj_mark = new Marks_Manage();
	$uid = $sudent_id;
	
	$user =get_userdata( $uid );
	$user_meta =get_user_meta($uid);
	$class_id = $user_meta['class_name'][0];
	$subject = $obj_mark->mj_smgt_student_subject($class_id);
	$total_subject=count($subject);
	$exam_id =$_REQUEST['exam_id'];
	$total = 0;
	$grade_point = 0;
	$umetadata=mj_smgt_get_user_image($uid); ?>
<center>
  <div style="float:left;width:100%;"> <img src="<?php echo get_option( 'smgt_school_logo' ) ?>"  style="max-height:50px;"/> <?php echo get_option( 'smgt_school_name' );?> </div>
  <div style="width:100%;float:left;border-bottom:1px solid red;"></div>
  <div style="width:100%;float:left;border-bottom:1px solid yellow;padding-top:5px;"></div>
  <br>
  <div style="float:left;width:100%;padding:10px 0;">
    <div style="width:70%;float:left;text-align:left;">
      <p>
        <?php esc_attr_e('Surname','school-mgt');?>
        :
        <?php get_user_meta($uid, 'last_name',true);?>
      </p>
      <p>
        <?php esc_attr_e('First Name','school-mgt');?>
        : <?php echo get_user_meta($uid, 'first_name',true);?></p>
      <p>
        <?php esc_attr_e('Class','school-mgt');?>
        :
        <?php $class_id=get_user_meta($uid, 'class_name',true);
											echo $classname=	mj_smgt_get_class_name($class_id);
						?>
      </p>
      <p>
        <?php esc_attr_e('Exam Name','school-mgt');?>
        :
        <?php 
				echo mj_smgt_get_exam_name_id($exam_id);?>
      </p>
    </div>
    <div style="float:right;width:30%;"> <img src="<?php echo $umetadata['meta_value'];?>" width="100" /> </div>
  </div>
  <br>
  <table style="float:left;width:100%;border:1px solid #000;" cellpadding="0" cellspacing="0">
    <thead>
      <tr style="border-bottom: 1px solid #000;">
        <th style="border-bottom: 1px solid #000;text-align:left;border-right: 1px solid #000;"><?php esc_attr_e('S/No','school-mgt');?></th>
        <th style="border-bottom: 1px solid #000;text-align:left;border-right: 1px solid #000;"><?php esc_attr_e('Subject','school-mgt')?></th>
        <th style="border-bottom: 1px solid #000;text-align:left;border-right: 1px solid #000;"><?php esc_attr_e('Obtain Mark','school-mgt')?></th>
        <th style="border-bottom: 1px solid #000;text-align:left;border-right: 1px solid #000;"><?php esc_attr_e('Grade','school-mgt')?></th>
      </tr>
    </thead>
    <tbody>
      <?php
	        $i=1;
			foreach($subject as $sub)
			{
			?>
      <tr style="border-bottom: 1px solid #000;">
        <td style="border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo $i;?></td>
        <td style="border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo $sub->sub_name;?></td>
        <td style="border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo $obj_mark->mj_smgt_get_marks($exam_id,$class_id,$sub->subid,$uid);?> </td>
        <td style="border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo $obj_mark->mj_smgt_get_grade($exam_id,$class_id,$sub->subid,$uid);?></td>
      </tr>
      <?php
			$i++;
			$total +=  $obj_mark->mj_smgt_get_marks($exam_id,$class_id,$sub->subid,$uid);
			$grade_point += $obj_mark->mj_smgt_get_grade_point($exam_id,$class_id,$sub->subid,$uid);
			} ?>
    </tbody>
  </table>
  <p class="result_total">
    <?php esc_attr_e("Total Marks","school-mgt");
    echo " : ".$total;?>
  </p>
  <p class="result_point">
    <?php	esc_attr_e("GPA(grade point average)","school-mgt");
    $GPA=$grade_point/$total_subject;
    echo " : ".round($GPA, 2);	?>
  </p>
  <hr />
</center>
<?php
		$out_put = ob_get_contents();
		ob_clean();
		header('Content-type: application/pdf');
		header('Content-Disposition: inline; filename="result"');
		header('Content-Transfer-Encoding: binary');
		header('Accept-Ranges: bytes');
		require_once SMS_PLUGIN_DIR . '/lib/mpdf/vendor/autoload.php';
			$mpdf = new Mpdf\Mpdf;
		
		
		$mpdf->WriteHTML($out_put);
		$mpdf->Output();
			
		unset( $out_put );
		unset( $mpdf );
		exit;
}

function mj_smgt_downlosd_smgt_result_print($sudent_id)
{

	// error_reporting(0);
   $obj_mark = new Marks_Manage();
	$uid = $sudent_id;
	$user =get_userdata( $uid );
	$user_meta =get_user_meta($uid);
	$class_id = $user_meta['class_name'][0];
	$subject = $obj_mark->mj_smgt_student_subject($class_id);
	$total_subject=count($subject);
	$exam_id =$_REQUEST['exam_id'];
	$total = 0;
	$grade_point = 0;
	$umetadata=mj_smgt_get_user_image($uid);
	ob_start();
	?>
	
		<style>
			@import url('https://fonts.googleapis.com/css?family=Poppins:400,700,900');
	
			body, body * {
				font-family: 'Poppins' !important;
			}
			@media print 	
			{
				.width_print
				{
					width:95% !important;
				} 
				.color_f5c6cc
				{
					background-color:#f5c6cc !important;
					-webkit-print-color-adjust: exact; 
				}
				.table_color
				{
					background-color:#b8daff !important;
					-webkit-print-color-adjust: exact; 
				}
				.footer_color
				{
					background-color:#eacf80 !important;
					-webkit-print-color-adjust: exact; 
				}
				.tfoot_border
				{
					border-bottom : 1px solid #000 !important;
				}
				.mt_10
				{
					margin-top:10px !important;
				}
			}			
		</style>
					
		<div style="margin-bottom:8px;">
			<div class="width_print" style="border: 2px solid;float:left;width:97%;margin: 6px 0px 0px 0px;padding:20px;">	
				<div style="float:left;width:100%; ">
					<div style="float:left;width:25%;">
						<div class="asasa" style="float:letf;border-radius:50px;">
							<img src="<?php echo get_option( 'smgt_school_logo' ) ?>" style="height: 150px;border-radius:50%;background-repeat:no-repeat;background-size:cover;" />
						</div>
					</div>
					<div style="float:left; width:55%;font-size:24px;padding-top:50px;"> 
						<b style="color:#307994;align-item:center;"><?php echo get_option( 'smgt_school_name' );?></b>
					</div>	 
					<div style="float:left;width:15%;padding-top:55px;">
						<?php
						$term_id=$obj_mark->mj_smgt_get_exam_term($exam_id);
						?>
						<b> <?php echo get_the_title($term_id); ?><?php esc_attr_e('Term Exam Result','school-mgt');?></b>
					</div>
				</div>
			</div>
		</div> 

		<div class="width_print color_f5c6cc" style="border: 2px solid;background-color:#f5c6cc;margin-bottom:8px;float:left;width:97%;padding:20px;margin-top:10px;">
			<div style="float:left;width:100%;">
				<div class="123" style="padding:10px;">

				<div style="float:left;width:33%;"><?php esc_attr_e('Student Name','school-mgt');?>: <b><?php echo get_user_meta($uid, 'first_name',true); ?>&nbsp;<?php echo get_user_meta($uid, 'last_name',true); ?></b></div>

				<div style="float:left;width:33%;"><?php esc_attr_e("Father's Name","school-mgt");?>: <b><?php 
				$parent_id= get_user_meta($uid, 'parent_id',true);
				if(!empty($parent_id))
				{					
					foreach($parent_id as $id)
					{
						$parentinfo=get_userdata($id);
					}
					echo  $parentinfo->display_name;
				}
				else
				{
					echo "N/A";
				}
				?> </b></div>

				<div style="float:left;width:33%;"><?php esc_attr_e("Roll No","school-mgt");?>: 
				<b><?php echo get_user_meta($uid, 'roll_id',true); ?> </b></div>
				</div>
			</div>
			
			<div style="float:left;width:100%;">
			<div class="123" style="padding:10px;">	
				<div style="float:left;width:33%;"><?php esc_attr_e('Class','school-mgt');?>: <b><?php $class_id=get_user_meta($uid, 'class_name',true);
							echo $classname=mj_smgt_get_class_name($class_id); ?></b></div>
				<div style="float:left;width:33%;"><?php esc_attr_e('Section','school-mgt');?>:
					<b><?php 
					$section_name=get_user_meta($uid, 'class_section',true);
					if($section_name!=""){
						echo mj_smgt_get_section_name($section_name); 
					}
					else
					{
						esc_attr_e('No Section','school-mgt');;
					}
					?></b></div>
				<div style="float:left;width:33%;"><?php esc_attr_e('Exam Name','school-mgt');?>:
				<b><?php echo mj_smgt_get_exam_name_id($exam_id); ?>
					</b></div>
					</div>
			</div>
		</div>	
				
		<table style="float:left;width:100%;border:1px solid #000;margin-bottom:8px;" cellpadding="10" cellspacing="0">
			<thead>
				<tr class="table_color" style="border-bottom: 1px solid #000;background-color:#b8daff;">
					<th style="border-bottom: 1px solid #000;text-align:left;border-right: 1px solid #000;"><?php esc_attr_e('Subject','school-mgt')?></th>
					<th style="border-bottom: 1px solid #000;text-align:left;border-right: 1px solid #000;"><?php esc_attr_e('Max Marks','school-mgt')?></th>
					<th style="border-bottom: 1px solid #000;text-align:left;border-right: 1px solid #000;"><?php esc_attr_e('Pass Marks','school-mgt')?></th>
					<th style="border-bottom: 1px solid #000;text-align:left;border-right: 1px solid #000;"><?php esc_attr_e('Obtain Mark','school-mgt')?></th>
					<th style="border-bottom: 1px solid #000;text-align:left;border-right: 1px solid #000;"><?php esc_attr_e('Grade','school-mgt')?></th>
				</tr>
			</thead>
			<tbody>
			  <?php
				$i=1;
				$total_pass_mark= 0;
				$total_max_mark=0;
				foreach($subject as $sub)
				{
					$total_pass_mark += $obj_mark->mj_smgt_get_pass_marks($exam_id); 
					?>
					<tr style="border-bottom: 1px solid #000;">
						<td style="border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo $sub->sub_name;?></td>
						<td style="border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo $obj_mark->mj_smgt_get_max_marks($exam_id);?> </td>
						<td style="border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo $obj_mark->mj_smgt_get_pass_marks($exam_id);?></td>
						<td style="border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php  echo $obj_mark->mj_smgt_get_marks($exam_id,$class_id,$sub->subid,$uid);?></td>
						<td style="border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo $obj_mark->mj_smgt_get_grade($exam_id,$class_id,$sub->subid,$uid);?></td>
					</tr>
					<?php
					$i++;
					$total +=  $obj_mark->mj_smgt_get_marks($exam_id,$class_id,$sub->subid,$uid);
					$total_max_mark += $obj_mark->mj_smgt_get_max_marks($exam_id);
				}				
				?>
			</tbody>
			<tfoot>
				<tr class="table_color tfoot_border mt_10" style=" border-bottom: 1px solid #000; background-color:#b8daff;">
					<th><?php esc_attr_e('TOTAL MARKS','school-mgt')?></th>
					<th><?php 
					if(!empty($total_max_mark))
					{
						echo $total_max_mark; 
					}
					else
					{
						echo "-";
					}
					?></th>
					<th><?php 
					if(!empty($total_pass_mark))
					{
						echo $total_pass_mark; 
					}
					else
					{
						echo "-";
					}
					?></th>
					<th><?php 
					if(!empty($total))
					{
						echo $total; 
					}
					else
					{
						echo "-";
					}
					?></th>
					<th></th>
				</tr>
			</tfoot>
		  </table>		

		  <div class="footer_color" style="border: 2px solid #8b8b8b;background-color:#eacf80;width:100%;float: left;margin-bottom:8px;">
				<div class="row" style="">	
					<div style="float:left;width: 60%;margin: 10px;">	
						<b class="" style="text-align: left"><?php esc_attr_e('Percentage','school-mgt'); ?> : </b>
						<?php 
							$percentage=$total/$total_max_mark*100;
							if(!empty($percentage))
							{
								echo number_format($percentage, 2);
							}
							else
							{
								echo "-";
							}
						?>
					</div>
					<div style="float:right;width: 20%;margin: 0px;margin-top: 10px;">
						<b style="text-align: right;"><?php esc_attr_e('Result','school-mgt'); ?> : </b> 
						<?php
						$result=array();
						$result1=array();
						foreach($subject as $sub)
						{
							if($obj_mark->mj_smgt_get_marks($exam_id,$class_id,$sub->subid,$uid) >= $obj_mark->mj_smgt_get_pass_marks($exam_id))
							{
								$result[] = "pass";
							}
							else 
							{
								$result1[] = "fail";
							}
						}	 
							
						if(isset($result) && in_array("pass", $result) && isset($result1) && in_array("fail", $result1))
						{
							echo  esc_attr_e('Fail','school-mgt');
						}
						elseif(isset($result) && in_array("pass", $result))
						{
							echo  esc_attr_e('Pass','school-mgt');
						}
						elseif(isset($result1) && in_array("fail", $result1))
						{
							echo  esc_attr_e('Fail','school-mgt');
						}
						else 
						{
							echo "-";
						}
						?>
					</div>
				</div>
				
				<div style="float:left;width:100%;border-top:2px solid #8c8778;margin-bottom:10px;">		
				</div>	

				<div class="aaa" style="direction: rtl;margin-right: 20px;">
					<br>
					<div style="float:right;margin-right:0px;margin-left: auto;">
						<div>	
						<img src="<?php echo get_option( 'smgt_principal_signature' ) ?>" style="width:100px; margin-right:15px;" />
						</div>
						<div style="border-top: 1px solid !important;width: 150px;margin-top: 5px;"></div>
						<div style="margin-right:10px;margin-bottom:10px;">
						<?php esc_attr_e('Principal Signature','school-mgt'); ?>
						</div>
					</div>
				</div>
		  </div>			
	
		

<?php
	$out_put = ob_get_contents();	
}
function mj_smgt_print_init_admin_side()
{
	if(isset($_REQUEST['print']) && $_REQUEST['print'] == 'print' && $_REQUEST['page'] == 'smgt_student' )
	{
	?>
    <script>window.onload = function(){ window.print(); };</script>
    <?php 
		$sudent_id = $_REQUEST['student'];
		mj_smgt_downlosd_smgt_result_print($sudent_id);
		exit;
	}			
}
function mj_smgt_print_init_student_side()
{
	if(isset($_REQUEST['print']) && $_REQUEST['print'] == 'print' && $_REQUEST['page'] == 'student' )
	{
	?>
    <script>window.onload = function(){ window.print(); };</script>
    <?php 
		$sudent_id = $_REQUEST['student'];
		mj_smgt_downlosd_smgt_result_print($sudent_id);
		exit;
	}			
}

add_action('init','mj_smgt_print_init_student_side');
add_action('init','mj_smgt_print_init_admin_side');
function mj_smgt_ajax_smgt_result_pdf()
{
	$obj_mark = new Marks_Manage();
	$uid = $_REQUEST['student_id'];
	
	$user =get_userdata( $uid );
	$user_meta =get_user_meta($uid);
	$class_id = $user_meta['class_name'][0];
	$subject = $obj_mark->mj_smgt_student_subject($class_id);
	$exam_id =mj_smgt_get_exam_id()->exam_id;
	$total = 0;
	$grade_point = 0;
	ob_start();
	?>
<div class="panel panel-white">
<form method="post">
  <input type="hidden" name="student_id" value = "<?php echo $uid;?>">
  <button id="pdf" type="button"><?php esc_attr_e('PDF','school-mgt'); ?>  </button>
</form>
<p class="student_name">
  <?php esc_attr_e('Result','school-mgt');?>
</p>
<div class="clearfix panel-heading">
  <h4 class="panel-title"><?php echo mj_smgt_get_user_name_byid($uid);?></h4>
</div>
<div class="panel-body">
  <div class="table-responsive">
    <table class="table table-bordered">
      <tr>
        <th><?php esc_attr_e('Subject','school-mgt');?></th>
        <th><?php esc_attr_e('Obtain Mark','school-mgt');?></th>
        <th><?php esc_attr_e('Grade','school-mgt');?></th>
        <th><?php esc_attr_e('Attendance','school-mgt');?></th>
        <th><?php esc_attr_e('Comment','school-mgt');?></th>
      </tr>
      <?php
		foreach($subject as $sub)
		{
		?>
      <tr>
        <td><?php echo $sub->sub_name;?></td>
        <td><?php echo $obj_mark->mj_smgt_get_marks($exam_id,$class_id,$sub->subid,$uid);?> </td>
        <td><?php echo $obj_mark->mj_smgt_get_grade($exam_id,$class_id,$sub->subid,$uid);?></td>
        <td><?php echo $obj_mark->mj_smgt_get_attendance($exam_id,$class_id,$sub->subid,$uid);?></td>
        <td><?php echo $obj_mark->mj_smgt_get_marks_comment($exam_id,$class_id,$sub->subid,$uid);?></td>
      </tr>
      <?php
		$total +=  $obj_mark->mj_smgt_get_marks($exam_id,$class_id,$sub->subid,$uid);
		$grade_point += $obj_mark->mj_smgt_get_grade_point($exam_id,$class_id,$sub->subid,$uid);
		}
		$GPA=$grade_point/$total_subject;?>
    </table>
  </div>
</div>
<hr />
<?php echo "GPA is".$GPA; ?>
<p class="result_total"><?php esc_attr_e("Total Marks","school-mgt")."=>".$total;?></p>
<hr />
<p class="result_point">
  <?php esc_attr_e("GPA(grade point average)","school-mgt") ."=> ".$grade_point;	?>
</p>
<hr />
<?php
	$out_put = ob_get_contents();
	ob_end_clean();
	require_once SMS_PLUGIN_DIR . '/lib/mpdf/vendor/autoload.php';
	$mpdf = new Mpdf\Mpdf;
	
	$mpdf->WriteHTML($out_put);
	$mpdf->Output('filename.pdf','F');
		
	unset( $out_put );
	unset( $mpdf );
	exit;
	
}
function mj_smgt_load_user()
{
	var_dump($_REQUEST['class_list']);
	$class_id =$_REQUEST['class_list'];
	if(empty($class_id))
	{
		$defaultmsg= esc_attr__( 'Select Student' , 'school-mgt');
	    echo "<option value=''>".$defaultmsg."</option>";
	}
	else
	{
		global $wpdb;		
		$exlude_id = mj_smgt_approve_student_list();
		$retrieve_data = get_users(array('meta_key' => 'class_name', 'meta_value' => $class_id,'role'=>'student','exclude'=>$exlude_id));
		$defaultmsg= esc_attr__( 'Select Student' , 'school-mgt');
		echo "<option value=''>".$defaultmsg."</option>";	
		foreach($retrieve_data as $users)
		{
			echo "<option value=".$users->id.">".$users->first_name." ".$users->last_name."</option>";
		}
	}
	die();		
}

function mj_smgt_load_section_user()
{		
	$section_id =$_POST['section_id'];
	$class_id =$_POST['class_id'];
	if(empty($section_id))
	{
		global $wpdb;		
		$exlude_id = mj_smgt_approve_student_list();
		$retrieve_data = get_users(array('meta_key' => 'class_name', 'meta_value' => $class_id,'role'=>'student','exclude'=>$exlude_id));
		$defaultmsg= esc_attr__( 'Select Student' , 'school-mgt');
		echo "<option value=''>".$defaultmsg."</option>";	
		foreach($retrieve_data as $users)
		{
			echo "<option value=".$users->id.">".$users->first_name." ".$users->last_name."</option>";
		}
		die();
	}
	else
	{	
		global $wpdb;	
		$exlude_id = mj_smgt_approve_student_list();
		$retrieve_data = get_users(array('meta_key' => 'class_section', 'meta_value' => $section_id,'role'=>'student','exclude'=>$exlude_id));
		$defaultmsg= esc_attr__( 'Select student' , 'school-mgt');
		echo "<option value=''>".$defaultmsg."</option>";	
		foreach($retrieve_data as $users)
		{
			echo "<option value=".$users->id.">".$users->first_name." ".$users->last_name."</option>";
		}
		die();	
	}
   die();	
}

function mj_smgt_load_class_section()
{		
		$class_id =$_POST['class_id'];
		global $wpdb;
		$retrieve_data=mj_smgt_get_class_sections($_POST['class_id']);
		$defaultmsg= esc_attr__( 'Select Class Section' , 'school-mgt');
		echo "<option value=''>".$defaultmsg."</option>";	
		foreach($retrieve_data as $section)
		{
			echo "<option value='".$section->id."'>".$section->section_name."</option>";
		}
		die();
		
}
function mj_smgt_teacher_by_subject($subject_id){
	global $wpdb;
	$teacher_rows = array();	
	if(isset($subject_id->subid))
	{
		$subid = (int)$subject_id->subid;	
		$table_smgt_subject = $wpdb->prefix. 'teacher_subject';	
		$result = $wpdb->get_results("SELECT * FROM $table_smgt_subject where subject_id = $subid");
		
		foreach($result as $tch_result)
		{
			$teacher_rows[] = $tch_result->teacher_id;
		}
	}
	return $teacher_rows;
	die();
}
function mj_smgt_class_by_teacher(){
	
	
	$teacher_id = $_REQUEST['teacher_id'];
	
	$teacher_obj = new Smgt_Teacher;
	$classes = $teacher_obj->mj_smgt_get_class_by_teacher($teacher_id);
	
	foreach($classes as $class)
	{
		$classdata = mj_smgt_get_class_by_id($class['class_id']);
		echo "<option value={$class['class_id']}>{$classdata->class_name}</option>";
	}
	wp_die();
}
function mj_smgt_teacher_by_class()
{
	$class_id = $_REQUEST['class_id'];
	$teacher_obj = new Smgt_Teacher;
	$classes = $teacher_obj->mj_smgt_get_class_teacher($class_id);

	foreach($classes as $class)
	{
		
		echo "<option value={$class['teacher_id']}>".mj_smgt_get_user_name_byid($class['teacher_id'])."</option>";
	}
	wp_die();
}
function mj_smgt_load_books()
{
	$cat_id =$_POST['bookcat_id'];
	global $wpdb;
	$table_book=$wpdb->prefix.'smgt_library_book';
	$retrieve_data=$wpdb->get_results(" SELECT * FROM $table_book where cat_id=$cat_id AND quentity !=". 0);
	foreach($retrieve_data as $book)
	{
		echo "<option value=".$book->id.">".stripslashes($book->book_name)."</option>";
	}
	die();
}

function mj_smgt_load_class_fee_type()
{
	$class_list = $_POST['class_list'];
	global $wpdb;
	$table_smgt_fees = $wpdb->prefix. 'smgt_fees';	
	$result = $wpdb->get_results("SELECT * FROM $table_smgt_fees where class_id = $class_list");
	//$defaultmsg= esc_attr__( 'Select Fee Type' , 'school-mgt');
	//echo '<option value="">'.$defaultmsg.'</option>';
	if(!empty($result))
	{
		foreach($result as $retrive_data)
		{
			echo '<option value="'.$retrive_data->fees_id.'">'.get_the_title($retrive_data->fees_title_id).'</option>';
		}
	}
	else
	{
		//$defaultmsg= esc_attr__( 'Select Fee Type' , 'school-mgt');
	    //echo '<option value="">'.$defaultmsg.'</option>';
		return false;
		
	}
	die();
}
function mj_smgt_load_section_fee_type()
{
	$section_id = $_POST['section_id'];
	global $wpdb;
	$table_smgt_fees = $wpdb->prefix. 'smgt_fees';	
	$result = $wpdb->get_results("SELECT * FROM $table_smgt_fees where section_id = $section_id");
	$defaultmsg= esc_attr__( 'Select Fee Type' , 'school-mgt');
		echo "<option value=' '>".$defaultmsg."</option>";
	if(!empty($result))
	{
		foreach($result as $retrive_data)
		{
			echo '<option value="'.$retrive_data->fees_id.'">'.get_the_title($retrive_data->fees_title_id).'</option>';
		}
	}
	else
		return false;
	die();
}
function mj_smgt_load_fee_type_amount()
{
	$fees_id = $_POST['fees_id'];
	global $wpdb;
	$table_smgt_fees = $wpdb->prefix. 'smgt_fees';	
	$fees_amount=array();
	foreach($fees_id as $id)
	{
		$result = $wpdb->get_row("SELECT * FROM $table_smgt_fees where fees_id = $id");
		$fees_amount[]= $result->fees_amount; 
	}
	echo array_sum($fees_amount);
	die();
}
function mj_smgt_ajax_smgt_view_notice()
{
	 $notice = get_post($_REQUEST['notice_id']);
	 ?>
	<div class="form-group popup_heder_marging"> 	
		<img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/notice_1.png";  ?>" alt="" class="popup_image_before_name">
		<a href="#" class="close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>
		<h4 class="modal-title" id="myLargeModalLabel">
			<?php esc_attr_e('Notice Detail','school-mgt'); ?>
		</h4>
	</div>
	<div class="modal-body view_details_body_assigned_bed view_details_body">
		<div class="row">
			<div class="col-md-6 popup_padding_15px">
				<label for="" class="popup_label_heading"><?php esc_attr_e('Title','school-mgt');?></label><br>
				<label for="" class="label_value"><?php echo $notice->post_title;?></label>
			</div>
			<div class="col-md-6 popup_padding_15px">
				<label for="" class="popup_label_heading"><?php esc_attr_e('Start Date To End Date','school-mgt');?></label><br>
				<label for="" class="label_value"><?php echo mj_smgt_getdate_in_input_box(get_post_meta( $notice->ID, 'start_date',true));?> <?php esc_attr_e('To','school-mgt');?> <?php echo mj_smgt_getdate_in_input_box(get_post_meta( $notice->ID, 'end_date',true));?> </label>
			</div>
			<div class="col-md-6 popup_padding_15px">
				<label for="" class="popup_label_heading"><?php esc_attr_e('Notice For','school-mgt');?></label><br>
				<label for="" class="label_value"><?php echo esc_attr_e(ucfirst(get_post_meta($notice->ID, 'notice_for',true)),'school-mgt');?></label>
			</div>
			<div class="col-md-6 popup_padding_15px">
				<label for="" class="popup_label_heading"><?php esc_attr_e('Class Name','school-mgt');?></label><br>
				<label for="" class="label_value">
					<?php 
					if(get_post_meta( $notice->ID, 'smgt_class_id',true) !="" && get_post_meta( $notice->ID, 'smgt_class_id',true) =="all")
					{
						esc_attr_e('All','school-mgt');
					}
					elseif(get_post_meta( $notice->ID, 'smgt_class_id',true) !="")
					{
						echo mj_smgt_get_class_name(get_post_meta( $notice->ID, 'smgt_class_id',true));
					}?>
				</label>
			</div>
			<div class="col-md-12 popup_padding_15px">
				<label for="" class="popup_label_heading"><?php esc_attr_e('Comment','school-mgt');?></label><br>
				<label for="" class="label_value">
					
					<?php
					if(!empty($notice->post_content))
					{
						echo $notice->post_content;
					}else{
						echo "N/A";
					}
					?>
				</label>
			</div>
		</div>  
	</div>
	<?php 
	die();
}

function inventory_image_upmj_smgt_load($file) {

	$type = "subject_syllabus";
	$imagepath =$file;
	$parts = pathinfo($_FILES[$type]['name']);
	$inventoryimagename = mktime(time())."-"."in".".".$parts['extension'];
	$document_dir = WP_CONTENT_DIR ;
    $document_dir .= '/uploads/school_assets/';
	$document_path = $document_dir;
	if($imagepath != "")
	{	
		if(file_exists(WP_CONTENT_DIR.$imagepath))
		unlink(WP_CONTENT_DIR.$imagepath);
	}
	if (!file_exists($document_path)) {
		mkdir($document_path, 0777, true);
	}	
    if (move_uploaded_file($_FILES[$type]['tmp_name'], $document_path.$inventoryimagename)) {
        $imagepath= $inventoryimagename;	
    }
return $imagepath;

}
function smgt_user_avatar_image_upmj_smgt_load($type) {


$imagepath =$file;
     
$parts = pathinfo($_FILES[$type]['name']);


 $inventoryimagename = mktime()."-"."student".".".$parts['extension'];
 $document_dir = WP_CONTENT_DIR ;
           $document_dir .= '/uploads/school_assets/';
	
		$document_path = $document_dir;

 
if($imagepath != "")
{	
	if(file_exists(WP_CONTENT_DIR.$imagepath))
	unlink(WP_CONTENT_DIR.$imagepath);
}
if (!file_exists($document_path)) {
	mkdir($document_path, 0777, true);
}	
       if (move_uploaded_file($_FILES[$type]['tmp_name'], $document_path.$inventoryimagename)) {
          $imagepath= $inventoryimagename;	
       }


return $imagepath;

}
function mj_smgt_register_post()
{
	register_post_type( 'message', array(
	
			'labels' => array(
	
					'name' => esc_attr__( 'Message', 'school-mgt' ),
	
					'singular_name' => 'message'),
	
			'rewrite' => false,
	
			'query_var' => false ) );
	
}
function mj_smgt_sms_service_setting()
{
	
	$select_serveice = $_POST['select_serveice'];
	
	if($select_serveice == 'clickatell')
	{
		$clickatell=get_option( 'smgt_clickatell_sms_service');
		?>
		<div class="form-body user_form">
			<div class="row">
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="form-group input">
						<div class="col-md-12 form-control">
							<input id="username" class="form-control validate[required]" type="text" value="<?php if(isset($clickatell['username'])) echo $clickatell['username'];?>" name="username">
							<label class="" for="username"><?php esc_attr_e('Username','school-mgt');?><span class="require-field">*</span></label>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="form-group input">
						<div class="col-md-12 form-control">
							<input id="password" class="form-control validate[required]" type="text" value="<?php if(isset($clickatell['password'])) echo $clickatell['password'];?>" name="password">
							<label class="" for="password"><?php esc_attr_e('Password','school-mgt');?><span class="require-field">*</span></label>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="form-group input">
						<div class="col-md-12 form-control">
							<input id="api_key" class="form-control validate[required]" type="text" value="<?php if(isset($clickatell['api_key'])) echo $clickatell['api_key'];?>" name="api_key">
							<label class="" for="api_key"><?php esc_attr_e('API Key','school-mgt');?><span class="require-field">*</span></label>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="form-group input">
						<div class="col-md-12 form-control">
							<input id="sender_id" class="form-control validate[required]" type="text" value="<?php echo $clickatell['sender_id'];?>" name="sender_id">
							<label class="" for="sender_id"><?php esc_attr_e('Sender Id','school-mgt');?><span class="require-field">*</span></label>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php 
	}
	if($select_serveice == 'twillo')
	{
	$twillo=get_option( 'smgt_twillo_sms_service');
			?>
			<div class="mb-3 form-group row">
			<label class="col-sm-2 control-label col-form-label text-md-end " for="account_sid"><?php esc_attr_e('Account SID','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="account_sid" class="form-control validate[required]" type="text" value="<?php if(isset($twillo['account_sid'])) echo $twillo['account_sid'];?>" name="account_sid">
			</div>
		</div>
	<div class="mb-3 form-group row">
			<label class="col-sm-2 control-label col-form-label text-md-end" for="auth_token"><?php esc_attr_e('Auth Token','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="auth_token" class="form-control validate[required] text-input" type="text" name="auth_token" value="<?php if(isset($twillo['auth_token'])) echo $twillo['auth_token'];?>">
			</div>
		</div>
		<div class="mb-3 form-group row">
			<label class="col-sm-2 control-label col-form-label text-md-end" for="from_number"><?php esc_attr_e('From Number','school-mgt');?><span class="require-field">*</span></label>
			<div class="col-sm-8">
				<input id="from_number" class="form-control validate[required] text-input" type="text" name="from_number" value="<?php if(isset($twillo['from_number'])) echo $twillo['from_number'];?>">
			</div>
		</div>
		
	<?php }
	if($select_serveice == 'msg91')
	{
		$msg91=get_option( 'smgt_msg91_sms_service');
		?>
		<div class="form-body user_form">
			<div class="row">
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="form-group input">
						<div class="col-md-12 form-control">
							<input id="sms_auth_key" class="form-control validate[required]" type="text" value="<?php echo $msg91['sms_auth_key'];?>" name="sms_auth_key">
							<label class="" for="sms_auth_key"><?php esc_attr_e('Authentication Key','school-mgt');?><span class="require-field">*</span></label>
						</div>
					</div>
				</div>

				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="form-group input">
						<div class="col-md-12 form-control">
							<input id="msg91_senderID" class="form-control validate[required] text-input" type="text" name="msg91_senderID" value="<?php echo $msg91['msg91_senderID'];?>">
							<label class="" for="msg91_senderID"><?php esc_attr_e('SenderID ','school-mgt');?><span class="require-field">*</span></label>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="form-group input">
						<div class="col-md-12 form-control">
							<input id="wpnc_sms_route" class="form-control validate[required] text-input" type="text" name="wpnc_sms_route" value="<?php echo $msg91['wpnc_sms_route'];?>">
							<label class="" for="wpnc_sms_route"><?php esc_attr_e('Route','school-mgt');?><span class="require-field">*</span></label>
						</div>
					</div>
				</div>
			</div>
		</div>
	
	<?php 
	}
	die();
}

function mj_smgt_student_invoice_view()
{
	$obj_invoice= new Smgtinvoice();
	if($_POST['invoice_type']=='invoice')
	{
		$invoice_data=mj_smgt_get_payment_by_id($_POST['idtest']);
	}
	if($_POST['invoice_type']=='income'){
		$income_data=$obj_invoice->mj_smgt_get_income_data($_POST['idtest']);
	}
	if($_POST['invoice_type']=='expense'){
		$expense_data=$obj_invoice->mj_smgt_get_income_data($_POST['idtest']);	
	} ?>
	<div class="modal-header model_header_padding dashboard_model_header">
		<a href="javascript:void(0);" class="close-btn-cat badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>
  		<h4 id="myLargeModalLabel" class="modal-title"><?php echo get_option('smgt_school_name');?></h4>
	</div>
	<div class="modal-body invoice_model_body float_left_width_100 " style="height: 380px;">
		<img class="invoiceimage float_left invoice_image_model"  src="<?php echo plugins_url('/school-management/assets/images/listpage_icon/invoice.png'); ?>" width="100%">
		<div id="invoice_print" class="main_div float_left_width_100 payment_invoice_popup_main_div"> 
			<div class="invoice_width_100 float_left" border="0">
				<div class="row">
					<div class="col-md-1 col-sm-2 col-xs-3">
						<div class="width_1">
							<img class="system_logo"  src="<?php echo esc_url(get_option( 'smgt_school_logo' )); ?>">
						</div>
					</div>						
				<div class="col-md-11 col-sm-10 col-xs-9 invoice_address invoice_address_css">	
					<div class="row">	
						<div class="col-md-1 col-sm-2 col-xs-3 address_css padding_right_0">	
							<label class="popup_label_heading"><?php esc_html_e('Address :','school-mgt');
								$address_length=strlen(get_option( 'smgt_school_address' ));
								if($address_length>120)
								{
								?>
								<BR><BR><BR><BR><BR>
								<?php
								}
								elseif($address_length>90)
								{													
								?>
									<BR><BR><BR><BR>
								<?php												
								}
								elseif($address_length>60)
								{?>
									<BR><BR><BR>
								<?php
								}
								elseif($address_length>30)
								{?>
									<BR><BR>
								<?php
								}
								?>
							</label>
						</div>
						<div class="col-md-9 col-sm-8 col-xs-7">
							<label for="" class="label_value">	<?php
									echo chunk_split(get_option( 'smgt_school_address' ),42,"<BR>").""; 
								?></label>
							</div>
						</div>
						<div class="row invoice_padding_bottom_15px">	
							<div class="col-md-1 col-sm-2 col-xs-3 address_css padding_right_0">	
								<label class="popup_label_heading"><?php esc_html_e('Email :','school-mgt');?> </label>
							</div>
							<div class="col-md-10 col-sm-8 col-xs-7">					
								<label for="" class="label_value"><?php echo get_option( 'smgt_email' ),"<BR>";  ?></label>
							</div>
						</div>
						<div class="row invoice_padding_bottom_15px">	
							<div class="col-md-1 col-sm-2 col-xs-3 address_css padding_right_0">
								<label class="popup_label_heading"><?php esc_html_e('Phone :','school-mgt');?> </label>
							</div>
							<div class="col-md-10 col-sm-8 col-xs-7">				
								<label for="" class="label_value"><?php echo get_option( 'smgt_contact_number' )."<br>";  ?></label>
							</div>
						</div>	
						<div align="right" class="width_24"></div>									
					</div>				
				</div>
			</div>
			<div class="col-md-12 col-sm-12 col-xl-12 mozila_display_css">
				<div class="row">
					<div class="width_50a1 float_left_width_100">
						<div class="col-md-8 col-sm-8 col-xs-5 padding_0 float_left display_grid margin_bottom_20px">
							<div class="billed_to display_flex invoice_address_heading">								
								<?php
								$issue_date='DD-MM-YYYY';
								if(!empty($income_data))
								{
									$issue_date=$income_data->income_create_date;
									$payment_status=$income_data->payment_status;
								}
								if(!empty($invoice_data))
								{
									$issue_date=$invoice_data->date;
									$payment_status=$invoice_data->payment_status;	
								}
								if(!empty($expense_data))
								{
									$issue_date=$expense_data->income_create_date;
									$payment_status=$expense_data->payment_status;
								}
								
								?>
								<h3 class="billed_to_lable invoice_model_heading" style="width: 20%;"><?php esc_html_e('Bill To 11','school-mgt');?> : </h3>
								
								<?php
								if(!empty($expense_data))
								{
									$party_name=$expense_data->supplier_name; 
									echo "<h3 class='display_name invoice_width_100'>".chunk_split(ucwords($party_name),30,"<BR>"). "</h3>";
								}
								else{
									if(!empty($income_data))
										$student_id=$income_data->supplier_name;
									if(!empty($invoice_data))
										$student_id=$invoice_data->student_id;
									$patient=get_userdata($student_id);						
									echo "<h3 class='display_name invoice_width_100'>".chunk_split(ucwords($patient->display_name),30,"<BR>"). "</h3>";
								}
								?>
							</div>
							<div class="width_60b2 address_information_invoice">								
								<?php 	
								if(!empty($expense_data))
								{
									$party_name=$expense_data->supplier_name; 
									echo "<h3 class='display_name invoice_width_100'>".chunk_split(ucwords($party_name),30,"<BR>"). "</h3>";
								}
								else
								{
									if(!empty($income_data))
										$student_id=$income_data->supplier_name;
									if(!empty($invoice_data))
										$student_id=$invoice_data->student_id;
									$patient=get_userdata($student_id);						
									// echo "<h3 class='display_name invoice_width_100'>".chunk_split(ucwords($patient->display_name),30,"<BR>"). "</h3>";
									$address=get_user_meta( $student_id,'address',true );

									echo chunk_split($address,30,"<BR>"); 
									echo get_user_meta( $student_id,'city',true ).","."<BR>"; ; 
									echo get_user_meta( $student_id,'zip_code',true ).",<BR>"; 
								}		
								?>	
								</div>
							</div>
							<div class="col-md-3 col-sm-4 col-xs-7 float_left">
								<div class="width_50a1112">
									<div class="width_20c" align="center">
										<?php
										if(!empty($invoice_data))
										{
											
										}
										?>
										<h5 class="align_left"> <label class="popup_label_heading text-transfer-upercase"><?php   echo esc_html__('Date :','school-mgt') ?> </label>&nbsp;  <label class="invoice_model_value"><?php echo mj_smgt_getdate_in_input_box(date("Y-m-d", strtotime($issue_date))); ?></label></h5>
										<h5 class="align_left"><label class="popup_label_heading text-transfer-upercase"><?php echo esc_html__('Status :','school-mgt')?> </label>  &nbsp;<label class="invoice_model_value"><?php 
											if($payment_status=='Paid') 
											{ echo esc_attr__('Fully Paid','school-mgt');}
											if($payment_status=='Part Paid')
											{ echo esc_attr__('Partially Paid','school-mgt');}
											if($payment_status=='Unpaid')
											{echo esc_attr__('Unpaid','school-mgt'); } ?></h5>														
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>	
				<table class="width_100">	
					<tbody>		
						<tr>
							<td>
								<?php
								if(!empty($invoice_data))
								{
									?>
									<h3 class="display_name"><?php esc_attr_e('Invoice Entries','school-mgt');?></h3>
									<?php
								}
								elseif(!empty($income_data))
								{
									?>
									<h3 class="display_name"><?php esc_attr_e('Income Entries','school-mgt');?></h3>
									<?php
								}
								elseif(!empty($expense_data))
								{
									?>
									<h3 class="display_name"><?php esc_attr_e('Expense Entries','school-mgt');?></h3>
									<?php
								}
								?>
								
							<td>	
						</tr>
					</tbody>
				</table>
				<table class="table model_invoice_table">
					<thead class="entry_heading invoice_model_entry_heading">					
						<tr>
							<th class="entry_table_heading align_center">#</th>
							<th class="entry_table_heading align_center"> <?php esc_attr_e('Date','school-mgt');?></th>
							<th class="entry_table_heading align_center"><?php esc_attr_e('Entry','school-mgt');?> </th>
							<th class="entry_table_heading align_center"><?php esc_attr_e('Price','school-mgt');?></th>
							<th class="entry_table_heading align_center"> <?php esc_attr_e('Issue By','school-mgt');?> </th>
						</tr>						
					</thead>
					<tbody>
						<?php 
						$id=1;
						$total_amount=0;
						if(!empty($income_data) || !empty($expense_data))
						{
							if(!empty($expense_data))
							{
								$income_data=$expense_data;
							}
							
							$patient_all_income=$obj_invoice->mj_smgt_get_onepatient_income_data($income_data->supplier_name);
						
							foreach($patient_all_income as $result_income)
							{
								$income_entries=json_decode($result_income->entry);
								foreach($income_entries as $each_entry)
								{
									$total_amount+=$each_entry->amount;								
									?>
									<tr>
										<td class="align_center invoice_table_data"><?php echo $id;?></td>
										<td class="align_center invoice_table_data"><?php echo $result_income->income_create_date;?></td>
										<td class="align_center invoice_table_data"><?php echo $each_entry->entry; ?> </td>
										<td class="align_center invoice_table_data"> <?php echo "<span> ". mj_smgt_get_currency_symbol() ."</span>" .number_format($each_entry->amount,2) ; ?></td>
										<td class="align_center invoice_table_data"><?php echo mj_smgt_get_display_name($result_income->create_by);?></td>
									</tr>
									<?php 
									$id+=1;
								}
							}
						}
						if(!empty($invoice_data))
						{
							$total_amount=$invoice_data->amount
							?>
							<tr>
								<td class="align_center invoice_table_data"><?php echo $id;?></td>
								<td class="align_center invoice_table_data"><?php echo date("Y-m-d", strtotime($invoice_data->date));?></td>
								<td class="align_center invoice_table_data"><?php echo $invoice_data->payment_title; ?> </td>
								<td class="align_center invoice_table_data"> <?php echo "<span> ". mj_smgt_get_currency_symbol() ." </span>" .number_format($invoice_data->amount,2); ?></td>
								<td class="align_center invoice_table_data"><?php echo mj_smgt_get_display_name($invoice_data->payment_reciever_id);?></td>
							</tr>
							<?php 
						}?>
					</tbody>
				</table>
									
				<?php 
				if(!empty($invoice_data))
				{								
					$grand_total= $total_amount;							
				}
				if(!empty($income_data))
				{
					$grand_total=$total_amount;
				}
				?>								
				
				<div class="row col-md-12 grand_total_main_div margin_top_20px">
					<div class="row col-md-6 col-sm-6 col-xs-6 print-button pull-left invoice_print_pdf_btn">
						<div class="col-md-2 print_btn_rs">
							<a  href="?page=smgt_payment&print=print&invoice_id=<?php echo $_POST['idtest'];?>&invoice_type=<?php echo $_POST['invoice_type'];?>" target="_blank"class="btn color_white btn save_btn invoice_btn_div"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/print.png" ?>" > </a>
						</div>
					
						<div class="col-md-3 pdf_btn_rs">
							<a href="?page=smgt_payment&print=pdf&invoice_id=<?php echo $_POST['idtest'];?>&invoice_type=<?php echo $_POST['invoice_type'];?>" target="_blank" class="btn color_white invoice_btn_div btn save_btn"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/pdf.png" ?>" ></a>
						</div>
						
					</div>
					<div class="row col-md-6 col-sm-6 col-xs-6 view_invoice_lable_css float_left grand_total_div invoice_table_grand_total" style="float: right;">
						<div class="align_right col-md-6 col-sm-6 col-xs-6 view_invoice_lable padding_11 padding_right_0_left_0 float_left grand_total_label_div invoice_model_height line_height_1_5 padding_left_0_px"><h3 class="padding color_white margin invoice_total_label"><?php esc_html_e('Grand Total','school-mgt');?> </h3></div>
						<div class="align_right col-md-6 col-sm-6 col-xs-6 view_invoice_lable  padding_right_5_left_5 padding_11 float_left grand_total_amount_div"><h3 class="padding margin text-right color_white invoice_total_value" style="float: right;"><?php echo "<span>".mj_smgt_get_currency_symbol()."</span> ".number_format($grand_total,2); ?></h3></div>
					</div>
				</div>
				<div class="margin_top_20px"></div>
			</div>
		</div>
	</div>
	<?php 
	 die();
}
function mj_smgt_student_add_payment()
{
	$fees_pay_id = $_POST['idtest'];
	$due_amount = $_POST['due_amount'];
	$student_id = $_POST['student_id'];
	$max_due_amount = str_replace(",", "", $_POST['due_amount']);
	?>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#expense_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	
		} );
	</script>
	<div class="modal-header model_header_padding dashboard_model_header" style="margin-bottom: 20px;">
		<a href="javascript:void(0);" class="close-btn-cat badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>
  		<h4 id="myLargeModalLabel" class="modal-title"><?php echo get_option('smgt_school_name');?></h4>
	</div>
	<div class="panel-white" style="padding: 20px;">
		<form name="expense_form" action="" method="post" class="form-horizontal" id="expense_form">
        	<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
			<input type="hidden" name="student_id" value="<?php echo $student_id;?>">
			<input type="hidden" name="action" value="<?php echo $action;?>">
			<input type="hidden" name="fees_pay_id" value="<?php echo $fees_pay_id;?>">
			<input type="hidden" name="payment_status" value="paid">
			<div class="form-body user_form">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group input">
							<div class="col-md-12 form-control">
								<input id="amount" class="form-control validate[required,min[0],max[<?php echo $max_due_amount; ?>],maxSize[10]] text-input" type="number" step="0.01" value="<?php echo $max_due_amount; ?>" name="amount">
								<label for="userinput1" class="active"><?php esc_html_e('Paid Amount','school-mgt');?>(<?php echo mj_smgt_get_currency_symbol();?>)<span class="required">*</span></label>
							</div>
						</div>
					</div>
					<div class="col-md-6 input">
						<label class="ml-1 custom-top-label top" for="hmgt_contry"><?php esc_html_e('Payment By','school-mgt');?><span class="required">*</span></label>
						<?php global $current_user;
						$user_roles = $current_user->roles;
						$user_role = array_shift($user_roles);
						?>
						<select name="payment_method" id="payment_method" class="font_transform_capitalization form-control select_height_47px">
							<?php
							if($user_role != 'student' AND $user_role != 'parent')
							{?>
								<option value="Cash"><?php esc_attr_e('Cash','school-mgt');?></option>
								<option value="Cheque"><?php esc_attr_e('Cheque','school-mgt');?></option>
								<option value="Bank Transfer"><?php esc_attr_e('Bank Transfer','school-mgt');?></option>
								<?php
							}
							else
							{					
								if(is_plugin_active('paymaster/paymaster.php') && get_option('smgt_paymaster_pack')=="yes")
								{ 
									$payment_method = get_option('pm_payment_method');
									print '<option value="'.$payment_method.'" class="font_transform_capitalization">'.$payment_method.'</option>';
								}
								else
								{ ?>
									<option value="Paypal"><?php esc_attr_e('Paypal','school-mgt');?></option>
								<?php 
								} 
							}
							?>
						</select>                     
					</div>
				</div>
			</div>
			<div class="form-body user_form">
				<div class="row">
					<div class="col-sm-6">
						<input type="submit" value="<?php esc_attr_e('Add Payment','school-mgt');?>" name="add_feetype_payment" class="btn btn-success save_btn"/>
					</div>
				</div>
			</div>
		</form>
	</div>
<?php
	die();
}
function mj_smgt_student_view_paymenthistory()
{	
	?>
	<script>
	function mj_smgt_PrintElem(elem)
	{
		mj_smgt_Popup($('<div/>').append($(elem).clone()).html());
	}
	function mj_smgt_Popup(data) 
	{
		var mywindow = window.open('', 'my div', 'height=500,width=700');
		mywindow.document.write('<html><head><title>Fees Payment Invoice</title>');
		mywindow.document.write('<link rel="stylesheet" href="<?php echo $path;?>" type="text/css" />');
		mywindow.document.write('</head><body class="test_print">');
		mywindow.document.write(data);
		mywindow.document.write('</body></html>');
		mywindow.document.close(); // necessary for IE >= 104
		mywindow.focus(); // necessary for IE >= 10
		mywindow.print();
		mywindow.focus();
		return true;
	}
	</script>

	<?php
		$fees_pay_id = $_REQUEST['idtest'];
		$fees_detail_result = mj_smgt_get_single_fees_payment_record($fees_pay_id);
		$fees_history_detail_result = mj_smgt_get_payment_history_by_feespayid($fees_pay_id);
		$obj_feespayment= new mj_smgt_feespayment();
	?>

	<div class="background_image_print" style="background-image: url(<?php echo SMS_PLUGIN_URL .'/assets/images/Invoice-BG.png' ?>);">
		<div class="modal-body">
			<div class="modal-header">				
				<a href="#" class="close-btn-cat badge badge-success float-end"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>
				<h4 class="modal-title"><?php echo get_option('smgt_school_name');?></h4>
			</div>		
			<div id="invoice_print" class="print-box" width="100%" > 
				<table width="100%" border="0">
					<tbody>
						<tr>
							<td width="70%">
								<img style="max-height:80px;" src="<?php echo get_option( 'smgt_school_logo' ); ?>">
							</td>
							<td align="right" width="24%">
								<h5><?php
								$issue_date='DD-MM-YYYY';
									$issue_date=$fees_detail_result->paid_by_date;						
									echo esc_attr__('Issue Date','school-mgt')." : ". mj_smgt_getdate_in_input_box(date("Y-m-d", strtotime($issue_date)));?></h5>					
									<h5><?php echo esc_attr__('Status','school-mgt')." : "; 
									$payment_status = mj_smgt_get_payment_status($fees_detail_result->fees_pay_id);					
										if($payment_status == 'Fully Paid')
										{	
										echo "<span class='btn btn-success btn-xs'>";							
										echo esc_attr__('Fully Paid','school-mgt');
										}
										if($payment_status=='Partially Paid')
										{
											echo "<span class='btn partially_paid_button_color btn-xs'>";
											echo esc_attr__('Partially Paid','school-mgt');
										}
										if($payment_status=='Not Paid')
										{
											echo "<span class='btn btn-danger btn-xs'>";
											echo esc_attr__('Not Paid','school-mgt');	
										}									
									echo "</span>";?></h5>	
							</td>
						</tr>
					</tbody>
				</table>
				<hr class="hr_margin_new color_black">
				<table width="100%" border="0">
					<tbody>
						<tr>
							<td class="col-md-6">
								<h4><?php esc_attr_e('Payment From','school-mgt');?> </h4>
							</td>
							<td class="col-md-6 pull-right" style="text-align: right;">
								<h4><?php esc_attr_e('Bill To','school-mgt');?> </h4>
							</td>
						</tr>
						<tr>
							<td valign="top"class="col-md-6">
								<?php echo get_option( 'smgt_school_name' )."<br>"; 
								echo get_option( 'smgt_school_address' ).","; 
								echo get_option( 'smgt_contry' )."<br>"; 
								echo get_option( 'smgt_contact_number' )."<br>"; 
								?>
								
							</td>
							<td valign="top" class="col-md-6" style="text-align: right;">
								<?php
								$student_id=$fees_detail_result->student_id;						
								$patient=get_userdata($student_id);									
								echo $patient->display_name."<br>";
								echo 'Student ID'.' <b>'.get_user_meta( $student_id,'roll_id',true )."</b><br>"; 
								echo get_user_meta( $student_id,'address',true ).","; 
								echo get_user_meta( $student_id,'city',true ).","."<BR>"; ; 
								echo get_user_meta( $student_id,'zip_code',true ).",<BR>"; 
								echo get_user_meta( $student_id,'state',true ).","; 
								echo get_option( 'smgt_contry' ).","; 
								echo get_user_meta( $student_id,'mobile',true )."<br>"; 						
								?>
							</td>
						</tr>
					</tbody>
				</table>
				<hr class="hr_margin_new color_black">
				<div class="table-responsive">
					<div>
						<h4 class="invoice_entries_css"><?php esc_attr_e('Invoice Entries','school-mgt');?></h4>
					</div>
					<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
						<thead>
							<tr>
								<th class="text-center padding_10">#</th>
								<th class="text-center padding_10"><?php esc_attr_e('Date','school-mgt');?></th>
								<th class="text-center padding_10"> <?php esc_attr_e('Fees Type','school-mgt');?></th>
								<th class="padding_10"><?php esc_attr_e('Total','school-mgt');?> </th>					
							</tr>
						</thead>
						<?php
						
						$fees_id=explode(',',$fees_detail_result->fees_id);
						$x=1;
						foreach($fees_id as $id)
						{ 
						?>
						<tbody>
							<td class="text-center"> <?php echo $x; ?></td>
							<td class="text-center"> <?php echo mj_smgt_getdate_in_input_box($fees_detail_result->created_date);?></td>
							<td class="text-center"> <?php echo mj_smgt_get_fees_term_name($id); ?></td>
							<td><?php
							$amount=$obj_feespayment->mj_smgt_feetype_amount_data($id);
							echo "<span> ". mj_smgt_get_currency_symbol()." </span>" . number_format($amount,2); 
							?></td>
						</tbody>
						<?php
						$x++;
						}
						?>
						
					</table>
				</div>
				<table width="100%" border="0">
					<tbody>							
						<tr>
							<td  align="right"><?php esc_attr_e('Sub Total :','school-mgt');?></td>
							<td align="right"><?php echo mj_smgt_get_currency_symbol().number_format($fees_detail_result->total_amount,2); ?></td>
						</tr>
						<tr>
							<td width="80%" align="right"><?php esc_attr_e('Payment Made :','school-mgt');?></td>
							<td align="right"><?php echo mj_smgt_get_currency_symbol().number_format($fees_detail_result->fees_paid_amount,2);?></td>
						</tr>
						<tr>
							<td width="80%" align="right"><?php esc_attr_e('Due Amount :','school-mgt');?></td>
							<?php $Due_amount = $fees_detail_result->total_amount - $fees_detail_result->fees_paid_amount; ?>
							<td align="right"><?php echo mj_smgt_get_currency_symbol().number_format($Due_amount,2); ?></td>
						</tr>				
					</tbody>
				</table>
				<hr class="hr_margin_new color_black">
				<?php if(!empty($fees_history_detail_result))
				{ ?>
				<h4><?php esc_attr_e('Payment History','school-mgt');?></h4>
				<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
					<thead>
						<tr>
							<th class="text-center padding_10"><?php esc_attr_e('Date','school-mgt');?></th>
							<th class="text-center padding_10"> <?php esc_attr_e('Amount','school-mgt');?></th>
							<th class="padding_10"><?php esc_attr_e('Method','school-mgt');?> </th>
							
						</tr>
					</thead>
					<tbody>
						<?php 
						foreach($fees_history_detail_result as  $retrive_date)
						{
						?>
						<tr>
							<td class="text-center"><?php echo mj_smgt_getdate_in_input_box($retrive_date->paid_by_date);?></td>
							<td class="text-center"><?php echo mj_smgt_get_currency_symbol() .number_format($retrive_date->amount,2);?></td>
							<td><?php  $data=$retrive_date->payment_method;
								echo esc_attr__("$data","school-mgt");
								?>
							</td>
						</tr>
						<?php }?>
					</tbody>
				</table>
				<?php } ?>
			</div>
			<div class="print-button align-center">
				<input type="button" value="<?php esc_attr_e('Print','school-mgt');?>" class="btn btn-success" onclick="mj_smgt_PrintElem('#invoice_print')" />
				&nbsp;&nbsp;&nbsp;
				<a href="?page=smgt_fees_payment&print=pdf&payment_id=<?php echo $_POST['idtest'];?>&fee_paymenthistory=<?php echo "fee_paymenthistory";?>" target="_blank"class="btn btn-success"><?php esc_attr_e('PDF','school-mgt');?></a>
			</div>		
		</div>
	</div>
	<?php
	die();
}

//----------  Fees Payment PDF ----------//
function mj_smgt_student_paymenthistory_pdf($id)
{ 
	$fees_pay_id = $id;
	$fees_detail_result = mj_smgt_get_single_fees_payment_record($fees_pay_id);	
	$fees_history_detail_result = mj_smgt_get_payment_history_by_feespayid($fees_pay_id);
	?>
	<style>
		.popup_label_heading{
			color: #818386;
			font-size: 14px !important;
			/* line-height: 0px; */
			font-weight: 500;
			font-family: 'Poppins' !important;
			text-transform: capitalize;
		}
	</style>
	
	<h3 class=""><?php echo get_option( 'smgt_school_name' ) ?></h3>
	<?php
	if (is_rtl())
	{
		?>
		<table style="float: right;position: absolute;vertical-align: top;background-repeat: no-repeat;">
			<tbody>
				<tr>
					<td>
						<img class=" invoiceimage float_left invoice_image_model"  src="<?php echo plugins_url('/school-management/assets/images/listpage_icon/invoice_rtl.png'); ?>" width="100%">
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}
	else
	{
		?>
	<table style="float: left;position: absolute;vertical-align: top;background-repeat: no-repeat;">
		<tbody>
			<tr>
				<td>
					<img  class="invoiceimage float_left invoice_image_model"  src="<?php echo plugins_url('/school-management/assets/images/listpage_icon/invoice.png'); ?>" width="100%">
				</td>
			</tr>
		</tbody>
	</table>
	<?php
	}
	?>
	<table style="float: left;width: 100%;position: absolute!important;margin-top:-160px;">
		<tbody>
			<tr>
				<td width="80%">
					<table>
						<tbody>
							<tr>
								<td width="10%" >
									<img class="system_logo"  src="<?php echo esc_url(get_option( 'smgt_school_logo' )); ?>">	
								</td>
								<td width="90%" style="padding-left: 20px;">
									<h4 class="popup_label_heading"><?php esc_html_e('Address','school-mgt'); ?></h4>
									<label for="" class="label_value word_break_all" style="font-size: 16px !important;color: #333333 !important;font-weight: 400;"><?php echo chunk_split(get_option( 'smgt_school_address' ),100,"<BR>").""; ?></label><br>
									
									<h4 class="popup_label_heading"><?php esc_html_e('Email','school-mgt');?> </h4>
									<label for="" style="font-size: 16px !important;color: #333333 !important;font-weight: 400;" class="label_value word_break_all"><?php echo get_option( 'smgt_email' ),"<BR>";  ?></label><br>

									<h4 class="popup_label_heading"><?php esc_html_e('Phone','school-mgt');?> </h4>
									<label for="" style="font-size: 16px !important;color: #333333 !important;font-weight: 400;" class="label_value"><?php echo get_option( 'smgt_contact_number' )."<br>";  ?></label>
								</td>
							</tr>
						</tbody>
					</table>
					
				</td>
			</tr>
		</tbody>
	</table>
	<br>
	<table>
		<tbody>
			<tr>
				<td width="70%">
					<h3 class="billed_to_lable invoice_model_heading bill_to_width_12"><?php esc_html_e('Bill To','school-mgt');?> : </h3>
					<?php
						$student_id=$fees_detail_result->student_id;
						$patient=get_userdata($student_id);						
						echo "<h3 class='display_name invoice_width_100'>".chunk_split(ucwords($patient->display_name),30,"<BR>"). "</h3>";
					?>
					<div>
						<?php 	
							$student_id=$fees_detail_result->student_id;	
							$patient=get_userdata($student_id);						
							// echo "<h3 class='display_name invoice_width_100'>".chunk_split(ucwords($patient->display_name),30,"<BR>"). "</h3>";
							$address=get_user_meta( $student_id,'address',true );

							echo chunk_split($address,30,"<BR>"); 
							echo get_user_meta( $student_id,'city',true ).","."<BR>"; ; 
							echo get_user_meta( $student_id,'zip_code',true ).",<BR>"; 
						?>
					</div>
						
				</td>
				<td width="15%">
					<?php
					$issue_date='DD-MM-YYYY';
					$issue_date=$fees_detail_result->paid_by_date;	
					$payment_status = mj_smgt_get_payment_status($fees_detail_result->fees_pay_id);	
					?>
					<label style="color: #818386 !important;font-size: 14px !important;text-transform: uppercase;font-weight: 500;line-height: 0px;"><?php echo esc_html__('Date','school-mgt') ?> </label>: <label class="invoice_model_value" style="font-weight: 600;color: #333333;font-size: 16px !important;"><?php echo mj_smgt_getdate_in_input_box(date("Y-m-d", strtotime($issue_date))); ?></label><br>
					<label style="color: #818386 !important;font-size: 14px !important;text-transform: uppercase;font-weight: 500;line-height: 0px;"><?php echo esc_html__('Status','school-mgt')?> </label>: <label class="invoice_model_value" style="font-weight: 600;color: #333333;font-size: 16px !important;"><?php 
						if($payment_status=='Fully Paid') 
						{ echo esc_attr__('Fully Paid','school-mgt');}
						if($payment_status=='Partially Paid')
						{ echo esc_attr__('Partially Paid','school-mgt');}
						if($payment_status=='Not Paid')
						{echo esc_attr__('Not Paid','school-mgt'); } ?></label>
				</td>
			</tr>
		</tbody>
	</table>
	<h4 style="font-size: 16px;font-weight: 600;color: #333333;"><?php esc_attr_e('Invoice Entry','school-mgt');?></h4>
	<table class="table table-bordered" width="100%" style="">
		<thead style="background-color: #F2F2F2 !important;">
			<tr style="background-color: #F2F2F2 !important;">
				<th class="align_left" style="font-weight: 600;color: #818386 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;">#</th>
				<th class="align_left" style="font-weight: 600;color: #818386 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php esc_attr_e('Date','school-mgt');?></th>
				<th class="align_left" style="font-weight: 600;color: #818386 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"> <?php esc_attr_e('Fees Type','school-mgt');?></th>
				<th class="align_left" style="color: #818386 !important;font-weight: 600;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php esc_attr_e('Total','school-mgt');?> </th>
			</tr>
		</thead>
		<?php
		$fees_id=explode(',',$fees_detail_result->fees_id);
		$x=1;
		foreach($fees_id as $id)
		{ 
		?>
		<tbody>
			<tr style=" border-bottom: 1px solid #E1E3E5 !important;">
				<td class="align-center" style="text-align: center;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"> <?php echo $x; ?></td>
				<td class="align-center" style="text-align: center;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"> <?php echo mj_smgt_getdate_in_input_box($fees_detail_result->created_date);?></td>
				<td class="align-center" style="text-align: center;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php echo mj_smgt_get_fees_term_name($id);?></td>
				<td class="align-center" style="text-align: center;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php 
				$obj_feespayment= new mj_smgt_feespayment();
				$amount=$obj_feespayment->mj_smgt_feetype_amount_data($id);
				echo "<span> ". mj_smgt_get_currency_symbol()." </span>" . number_format($amount,2);  ?></td>
			</tr>
		</tbody> 
		<?php
		$x++;
		}
		?>
	</table>
	<table width="100%" border="0">
		<tbody>
			<tr>
				<td width="80%" align="right" style="padding-bottom: 10px;font-size: 18px;color: #818386 !important;font-weight: 500;"><?php esc_attr_e( 'Sub Total :','school-mgt' ); ?></td>
				<td align="left" style="padding-bottom: 10px;font-size: 18px;color: #333333 !important;font-weight: 700;"><?php echo "<span> ". mj_smgt_get_currency_symbol() ." </span>" .number_format($fees_detail_result->total_amount,2); ?></td>
			</tr>
			<tr>
				<td width="80%" align="right" style="padding-bottom: 10px;font-size: 18px;color: #818386 !important;font-weight: 500;"><?php esc_attr_e('Payment Made :','school-mgt');?></td>
				<td align="left" style="padding-bottom: 10px;font-size: 18px;color: #333333 !important;font-weight: 700;"><?php echo "<span> ". mj_smgt_get_currency_symbol() ." </span>" . number_format($fees_detail_result->fees_paid_amount,2) ;?></td>
			</tr>
			<tr>
				<td width="80%" align="right" style="padding-bottom: 10px;font-size: 18px;color: #818386 !important;font-weight: 500;"><?php esc_attr_e( 'Due Amount :','school-mgt' ); ?></td>
				<?php $Due_amount = $fees_detail_result->total_amount - $fees_detail_result->fees_paid_amount;?>
				<td align="left" style="padding-bottom: 10px;font-size: 18px;color: #333333 !important;font-weight: 700;"><?php echo "<span> ". mj_smgt_get_currency_symbol() ." </span>" . number_format($Due_amount,2) ?></td>
			</tr>
		</tbody>
	</table>
	<table>
		<tbody>
			<tr>
				<td width="62%"></td>
				<td style="background-color: #5840bb;color: #fff;">
					<table style="background-color: #5840bb;color: #fff;">
						<tbody>
							<tr>
								<?php
									$subtotal = $fees_detail_result->total_amount;
									$paid_amount = $fees_detail_result->fees_paid_amount;
									$grand_total = $subtotal - $paid_amount;
								?>
								<td  style="background-color: #5840bb;color: #fff;padding:10px">
									<h3 >
										<?php esc_html_e('Grand Total','school-mgt');?>
									</h3>
								</td>
								<td  style="background-color: #5840bb;color: #fff;padding:10px;">
									<h3><?php echo "<span>".mj_smgt_get_currency_symbol()."</span> ".number_format($subtotal,2); ?></h3>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
	
	<?php 
	if(!empty($fees_history_detail_result))
	{ ?>
		<h4 style="font-size: 16px;font-weight: 600;color: #333333;"><?php esc_attr_e('Payment History','school-mgt');?></h4>
		<table class="table table-bordered" width="100%" style="">
			<thead style="background-color: #F2F2F2 !important;">
				<tr style="background-color: #F2F2F2 !important;">
					<th class="align_left" style="font-weight: 600;color: #818386 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php esc_attr_e('Date','school-mgt');?></th>
					<th class="align_left" style="font-weight: 600;color: #818386 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"> <?php esc_attr_e('Amount','school-mgt');?></th>
					<th class="align_left" style="font-weight: 600;color: #818386 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php esc_attr_e('Method','school-mgt');?> </th>				
				</tr>
			</thead>
			<tbody>
				<?php 
				foreach($fees_history_detail_result as  $retrive_date)
				{
				?>
				<tr style=" border-bottom: 1px solid #E1E3E5 !important;">
					<td class="align-center" style="text-align: center;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php echo $retrive_date->paid_by_date;?></td>
					<td class="align-center" style="text-align: center;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php echo number_format($retrive_date->amount,2);?></td>
					<td class="align-center" style="text-align: center;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php $data_pay=$retrive_date->payment_method;
						echo esc_attr__("$data_pay","school-mgt"); ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<?php 
	} 
	
}

//---------  Library View Popup ---------//
function mj_smgt_student_view_librarryhistory()
{
	$student_id = $_REQUEST['student_id'];
	$booklist = mj_smgt_get_student_lib_booklist($student_id);
	$student=get_userdata($student_id);
	?>
	<div class="modal-header model_header_padding dashboard_model_header">
		<a href="javascript:void(0);" class="event_close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>
  		<h4 id="myLargeModalLabel" class="modal-title"><?php echo $student->display_name; ?></h4>
	</div>
	<div class="panel-white libraryhistory_panal_white_div"><!----------  panel-white div------------>
		<div class="modal-body"><!----------  Model Body div------------>
			<div id="invoice_print" class="table-responsive"> 
				<?php 
				if(!empty($booklist))
				{ 
					?>
					<table class="table table-bordered" style="border: 1px solid #D9E1ED;text-align: center;margin-bottom: 0px;"  width="100%">
						<thead>
							<tr>
								<th class="exam_hall_receipt_table_heading" style="border-top: medium none;border-right: 1px solid #D9E1ED;background-color: #F2F5FA;border-bottom: 1px solid #D9E1ED;text-align: center;"><?php esc_attr_e('Book Title','school-mgt');?></th>
								<th class="exam_hall_receipt_table_heading" style="border-right: 1px solid #D9E1ED;background-color: #F2F5FA;border-bottom: 1px solid #D9E1ED;text-align: center;"> <?php esc_attr_e('Issue Date','school-mgt');?></th>
								<th class="exam_hall_receipt_table_heading" style="border-right: 1px solid #D9E1ED;background-color: #F2F5FA;border-bottom: 1px solid #D9E1ED;text-align: center;"> <?php esc_attr_e('Return Date','school-mgt');?></th>
								<th class="exam_hall_receipt_table_heading" style="border-right: 1px solid #D9E1ED;background-color: #F2F5FA;border-bottom: 1px solid #D9E1ED;text-align: center;"><?php esc_attr_e('Period','school-mgt');?> </th>
								<th class="exam_hall_receipt_table_heading" style="border-right: 1px solid #D9E1ED;background-color: #F2F5FA;border-bottom: 1px solid #D9E1ED;text-align: center;"><?php esc_attr_e('Overdue By','school-mgt');?> </th>
								<th class="exam_hall_receipt_table_heading" style="background-color: #F2F5FA;border-bottom: 1px solid #D9E1ED;text-align: center;"><?php esc_attr_e('Fine','school-mgt');?> </th>
								
							</tr>
						</thead>
							<tbody>
								<?php 
								foreach($booklist as  $retrieved_data)
								{
									?>
									<tr style="border: 1px solid #D9E1ED;">
										<td class="exam_hall_receipt_table_value" style="border-right: 1px solid #D9E1ED;"><?php echo stripslashes(mj_smgt_get_bookname($retrieved_data->book_id));?></td>
										<td class="exam_hall_receipt_table_value" style="border-right: 1px solid #D9E1ED;"><?php echo $retrieved_data->issue_date;?></td>
										<td class="exam_hall_receipt_table_value" style="border-right: 1px solid #D9E1ED;"><?php echo $retrieved_data->end_date;?></td>
										<td class="exam_hall_receipt_table_value" style="border-right: 1px solid #D9E1ED;"><?php echo get_the_title($retrieved_data->period). esc_attr__(" Days","school-mgt");?></td>
										<?php 
											$date1=date_create(date('Y-m-d'));
											$date2=date_create(date("Y-m-d", strtotime($retrieved_data->end_date)));
											$diff=date_diff($date2,$date1);	
										?>
										<td class="exam_hall_receipt_table_value" style="border-right: 1px solid #D9E1ED;">
											<?php 
											if($retrieved_data->actual_return_date=='' && $date1 < $date2)
											{ 
												echo esc_attr__("0 Days","school-mgt");
											}
											elseif ($date2 > $date3 && $retrieved_data->actual_return_date!='')
											{
												echo esc_attr__("0 Days","school-mgt"); 
											}
											elseif($date1 > $date2)
											{ 
												echo $diff->format("%a"). esc_attr__(" Days","school-mgt"); 
											}
											?>
										</td>
										<td class="exam_hall_receipt_table_value" style="border-right: 1px solid #D9E1ED;"><?php echo  ($retrieved_data->fine != "" || $retrieved_data->fine != 0) ? mj_smgt_get_currency_symbol().$retrieved_data->fine : "N/A";?></td>
									</tr>
									<?php 
								}
								?>
							</tbody>
						</table>
						<?php 
					} ?>
				</div>
			</div>
		</div><!----------  Model Body div------------>
	</div><!----------  panel-white div------------>
	
	<?php
	die();
}
function mj_smgt_get_student_lib_booklist($id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . 'smgt_library_book_issue';
	$results=$wpdb->get_results("select *from $table_name where student_id=$id");
	return $results;
}
function mj_smgt_add_remove_feetype()
{
	$model = $_REQUEST['model'];
	$class_id = $_REQUEST['class_id'];
	mj_smgt_add_category_type($model,$class_id);
}
function mj_smgt_add_category_type($model,$class_id) 
{

	$title = "Title here";
	$table_header_title ="Table head";
	$button_text= "Button Text"; 
	$label_text = "Label Text";
	if($model == 'feetype')
	{
		$obj_fees = new Smgt_fees();
		$cat_result = $obj_fees->mj_smgt_get_all_feetype();
		$title = esc_attr__("Fee type",'school-mgt');
		$table_header_title =  esc_attr__("Fee Type",'school-mgt');
		$button_text=  esc_attr__("Add Fee Type",'school-mgt');
		$label_text =  esc_attr__("Fee Type",'school-mgt');
	}
	if($model == 'book_cat')
	{
		$obj_lib = new Smgtlibrary();
		$cat_result = $obj_lib->mj_smgt_get_bookcat();
		$title = esc_attr__("Category",'school-mgt');
		$table_header_title =  esc_attr__("Category Name",'school-mgt');
		$button_text=  esc_attr__("Add Category",'school-mgt');
		$label_text =  esc_attr__("Category Name",'school-mgt');
	}
	if($model == 'rack_type')
	{
		$obj_lib = new Smgtlibrary();
		$cat_result = $obj_lib->mj_smgt_get_racklist();
		$title = esc_attr__("Rack Location",'school-mgt');
		$table_header_title =  esc_attr__("Rack Location Name",'school-mgt');
		$button_text=  esc_attr__("Add Rack Location",'school-mgt');
		$label_text =  esc_attr__("Rack Location Name",'school-mgt');
	}
	
	if($model == 'class_sec')
	{
		
		$title = esc_attr__("Class Section",'school-mgt');
		$table_header_title =  esc_attr__("Section Name",'school-mgt');
		$button_text=  esc_attr__("Add Section",'school-mgt');
		$label_text =  esc_attr__("Section Name",'school-mgt');
	}
	?>
	
	<script type="text/javascript">
		jQuery(document).ready(function($)
		{
			"use strict";	
			$('#fees_type_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});
		});
	</script>
	<div class="modal-header model_header_padding dashboard_model_header">
		<a href="javascript:void(0);" class="event_close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>
  		<h4 id="myLargeModalLabel" class="modal-title"><?php echo $title;?></h4>
	</div>
	<div class="panel-white">
  		<div class="category_listbox">
		  	<form name="fee_form" action="" method="post" class="category_popup_float form-horizontal admission_form_popup" id="fees_type_form"><!---CATEGORY_FORM----->
				<div class="form-body user_form ">
					<div class="row">	
						<?php 
						if($model == 'period_type')
						{
							?>	
							<div class="col-md-9">
								<div class="form-group input">
									<div class="col-md-12 form-control">
										<input id="fees_type_val" class="form-control text-input validate[required]" maxlength="3" type="number" value=""  oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" name="txtfee_type" placeholder="<?php esc_attr_e('Must Be Enter Number of Days','school-mgt');?>">
										<label for="userinput1" class="active "><?php esc_html_e('Section Name','school-mgt');?><span class="required">*</span></label>
									</div>
								</div>
							</div>
							<?php
						}
						else
						{
							?>
							<div class="col-md-9">
								<div class="form-group input">
									<div class="col-md-12 form-control">
										<input id="fees_type_val" class="form-control text-input validate[required,custom[popup_category_validation]]"  maxlength="50" type="text" value="" name="txtfee_type">
										<label for="userinput1" class=""><?php esc_html_e('Section Name','school-mgt');?><span class="required">*</span></label>
									</div>
								</div>
							</div>
							<?php
						}
						?>
						<div class="col-md-3">
							<input type="button" <?php if($model == 'class_sec'){?> class_id=<?php echo $class_id; }?> value="<?php echo $button_text;?>" name="save_category" class="btn save_btn btn_top btn-success" model="<?php echo $model;?>" id="btn-add-cat"/>
						</div>
					</div>
				</div>
			</form>
			<div class="category_listbox_new admission_pop_up_new">
				<div class="class_detail_append col-lg-12 col-md-12 col-xs-12 col-sm-12"><!---TABLE-RESPONSIVE----->
					<?php
					$i = 1;
					?>
					<div class="div_new_1">
						<?php
						if($model == 'class_sec')
						{
							$section_result=mj_smgt_get_class_sections($class_id);
							if(!empty($section_result))
							{
								
								foreach ($section_result as $retrieved_data)
								{
									?>
									<div class="row new_popup_padding" id="<?php echo "cat-".$retrieved_data->id."";  ?>">
										<div class="col-md-10 width_70">
											<?php
											echo $retrieved_data->section_name;
											?>
										</div> 
										<div class="row col-md-2 padding_left_0_res width_30" id="<?php echo $retrieved_data->id; ?>">
											<div class="col-md-6 width_50_res padding_left_0">
												<a href="#" class="btn-delete-cat" model="<?php echo $model; ?>" id="<?php echo $retrieved_data->id; ?>"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png"?>" alt=""></a>
											</div>
											<div class="col-md-6 edit_btn_padding_left_25px_res width_50_res padding_right_0">
												<a class="btn-edit-cat"  model="<?php echo $model; ?>" href="#" id="<?php echo $retrieved_data->id; ?>"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/edit.png"?>" alt=""></a>
											</div>
										</div>
									</div>
									<?php
									
									$i++;		
								}
							}
						}
						else
						{
							if(!empty($cat_result))
							{
								foreach ($cat_result as $retrieved_data)
								{
									?>
									<div class="row new_popup_padding" id="<?php echo "cat-".$retrieved_data->ID."";  ?>">
										<div class="col-md-11 width_80 mt_7px">
											<?php
											if($model == 'period_type')
											{
												echo $retrieved_data->post_title;
												echo esc_attr__("Days","school-mgt");
											}
											else
											{
												echo $retrieved_data->post_title;
											}
											?>
										</div> 
										<div class="row col-md-1 rs_popup_width_20px" id="<?php echo $retrieved_data->ID; ?>">
											<div class="col-md-12">
												<a href="#" class="btn-delete-cat" model="<?php echo $model; ?>" id="<?php echo $retrieved_data->ID; ?>"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png"?>" alt=""></a>
											</div>
										</div>
									</div>
									<?php
									$i++;		
								}
							}
						}
						?>
					</div>
				</div>
				<!-- <table class="table">
					<?php
					$i = 1;
					if($model == 'class_sec')
					{
						$section_result=mj_smgt_get_class_sections($class_id);
						if(!empty($section_result))
						{
							
							foreach ($section_result as $retrieved_data)
							{
								echo '<tr id="cat-'.$retrieved_data->id.'">';
								echo '<td>'.$retrieved_data->section_name.'</td>';
								echo '<td id='.$retrieved_data->id.'>
								<a class="btn-delete-cat badge badge-delete" model='.$model.' href="#" id='.$retrieved_data->id.'>X</a>
								<a class="btn-edit-cat badge badge-edit" model='.$model.' href="#" id='.$retrieved_data->id.'><i class="fa fa-edit" aria-hidden="true"></i></a>
								</td>';
								echo '</tr>'; 
								$i++;		
							}
						}
					}
					else
					{
						if(!empty($cat_result))
						{
							
							foreach ($cat_result as $retrieved_data)
							{
							echo '<tr id="cat-'.$retrieved_data->ID.'">';
							if($model == 'period_type')
								echo '<td>'.$retrieved_data->post_title.' '. esc_attr__("Days","school-mgt") .'</td>';
							else
								echo '<td>'.$retrieved_data->post_title.'</td>';
							echo '<td id='.$retrieved_data->ID.'><a class="btn-delete-cat badge badge-delete" model='.$model.' href="#" id='.$retrieved_data->ID.'>X</a></td>';
							echo '</tr>';
							$i++;		
							}
						}
					}
					?>
				</table> -->
			</div>
  		</div>
  	</div>
	<?php 
	die();
}
function mj_smgt_add_fee_type()
{
	global $wpdb;
	$model = $_REQUEST['model'];
	$class_id = $_REQUEST['class_id'];
	$array_var = array();
	$data['category_name'] = mj_smgt_strip_tags_and_stripslashes($_REQUEST['fee_type']);
	$dlt_image = SMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png";
	$edit_image = SMS_PLUGIN_URL."/assets/images/listpage_icon/edit.png";
	if($model == 'feetype')
	{
		$obj_fees = new Smgt_fees();
		$obj_fees->mj_smgt_add_feetype($data);
		$id = $wpdb->insert_id;
		$row1 = '<div class="row new_popup_padding" id="cat-'.$id.'"><div class="col-md-11" >'.stripslashes($_REQUEST['fee_type']).'</div><div class="row col-md-1"><div class="col-md-12"><a href="#" class="btn-delete-cat" model="'.$model.'" id="'.$id.'"><img src="'.$dlt_image.'" alt=""></a></a></div></div></div>';
		$option = "<option value='$id'>".stripslashes($_REQUEST['fee_type'])."</option>";
	}
	
	if($model=='book_cat')
	{
		$obj_lib = new Smgtlibrary();
		$cat_result = $obj_lib->mj_smgt_add_bookcat($data);
		$id = $wpdb->insert_id;
		$row1 = '<tr id="cat-'.$id.'"><td>'.stripslashes($_REQUEST['fee_type']).'</td><td><a class="btn-delete-cat badge badge-delete" href="#" id='.$id.'>X</a></td></tr>';
		$option = "<option value='$id'>".stripslashes($_REQUEST['fee_type'])."</option>";
	}
	if($model=='rack_type')
	{
		$obj_lib = new Smgtlibrary();
		$cat_result = $obj_lib->mj_smgt_add_rack($data);
		$id = $wpdb->insert_id;
		$row1 = '<div class="row new_popup_padding" id="cat-'.$id.'"><div class="col-md-11" >'.stripslashes($_REQUEST['fee_type']).'</div><div class="row col-md-1"><div class="col-md-12"><a href="#" class="btn-delete-cat" model="'.$model.'" id="'.$id.'"><img src="'.$dlt_image.'" alt=""></a></a></div></div></div>';
		$option = "<option value='$id'>".stripslashes($_REQUEST['fee_type'])."</option>";
	}
	if($model=='period_type')
	{
		$obj_lib = new Smgtlibrary();
		$cat_result = $obj_lib->mj_smgt_add_period($data);
		$id = $wpdb->insert_id;
		$row1 = '<div class="row new_popup_padding" id="cat-'.$id.'"><div class="col-md-11" >'.stripslashes($_REQUEST['fee_type']).' '. esc_attr__('Days','school-mgt').'</div><div class="row col-md-1"><div class="col-md-12"><a href="#" class="btn-delete-cat" model="'.$model.'" id="'.$id.'"><img src="'.$dlt_image.'" alt=""></a></a></div></div></div>';
		$option = "<option value='$id'>".stripslashes($_REQUEST['fee_type'])." ". esc_attr__('Days','school-mgt')."</option>";
	}
	if($model=='class_sec')
	{
		$tablename="smgt_class_section";
		
		$sectiondata['class_id']=$_REQUEST['class_id'];
		$sectiondata['section_name']=stripslashes($_REQUEST['fee_type']);
		
		$result=mj_smgt_add_class_section($tablename,$sectiondata);
		$id = $wpdb->insert_id;
		$row1 = '<div class="row new_popup_padding" id="cat-'.$id.'"><div class="col-md-10 width_70" >'.stripslashes($_REQUEST['fee_type']).'</div>
		<div class="row col-md-2 padding_left_0_res width_30"><div class="col-md-6 width_50_res padding_left_0"><a href="#" class="btn-delete-cat" model="'.$model.'" id="'.$id.'"><img src="'.$dlt_image.'" alt=""></a></div>
		<div class="col-md-6 edit_btn_padding_left_25px_res width_50_res padding_right_0"><a class="btn-edit-cat"  model="'.$model.'" href="#" id="'.$id.'"><img src="'.$edit_image.'" alt=""></a></div>
		</div></div>';
		$option = "<option value='$id'>".stripslashes($_REQUEST['fee_type'])."</option>";
	}
	$array_var[] = $row1;
	$array_var[] = $option;
	echo json_encode($array_var);
	die();
}
function mj_smgt_remove_feetype()
{
	
	$model = $_REQUEST['model'];
	if($model == 'feetype')
	{
		$obj_fees = new Smgt_fees();
		$obj_fees->mj_smgt_delete_fee_type($_POST['cat_id']);
		die();
	}
	if($model == 'book_cat')
	{
		$obj_lib = new Smgtlibrary();
		$obj_lib->mj_smgt_delete_cat_type($_POST['cat_id']);
		die();
	}
	if($model == 'rack_type')
	{
		$obj_lib = new Smgtlibrary();
		$obj_lib->mj_smgt_delete_rack_type($_POST['cat_id']);
		die();
	}
	if($model == 'period_type')
	{
		$obj_lib = new Smgtlibrary();
		$obj_lib->mj_smgt_delete_period($_POST['cat_id']);
		die();
	}
	if($model == 'class_sec')
	{
		$result=mj_smgt_delete_class_section($_POST['cat_id']);
		die();
	}
}
function mj_smgt_single_section($section_id)
{
	global $wpdb;
	$smgt_class_section = $wpdb->prefix. 'smgt_class_section';
	$result = $wpdb->get_row('Select * from '.$smgt_class_section.' where id = '.$section_id);
	
	return $result;
}
function mj_smgt_update_section()
{
	global $wpdb;
	$smgt_class_section = $wpdb->prefix. 'smgt_class_section';
	$data['section_name']=$_POST['section_name'];
	$data_id['id']=$_POST['cat_id'];	
	$result=$wpdb->update( $smgt_class_section, $data ,$data_id);
	$retrieved_data = mj_smgt_single_section($_POST['cat_id']);
	?>
	<div class="col-md-10 width_70">
		<?php
		echo $retrieved_data->section_name;
		?>
	</div> 
	<div class="row col-md-2 padding_left_0_res width_30" id="<?php echo $retrieved_data->id; ?>">
		<div class="col-md-6 width_50_res padding_left_0">
			<a href="#" class="btn-delete-cat" model="<?php echo $model; ?>" id="<?php echo $retrieved_data->id; ?>"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png"?>" alt=""></a>
		</div>
		<div class="col-md-6 edit_btn_padding_left_25px_res width_50_res padding_right_0">
			<a class="btn-edit-cat"  model="<?php echo $model; ?>" href="#" id="<?php echo $retrieved_data->id; ?>"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/edit.png"?>" alt=""></a>
		</div>
	</div>
	<?php
	die();
}
function mj_smgt_update_cancel_section()
{
	global $wpdb;
	$smgt_class_section = $wpdb->prefix. 'smgt_class_section';	
	$retrieved_data = mj_smgt_single_section($_POST['cat_id']);
	?>
	<div class="col-md-10 width_70">
		<?php
		echo $retrieved_data->section_name;
		?>
	</div> 
	<div class="row col-md-2 padding_left_0_res width_30" id="<?php echo $retrieved_data->id; ?>">
		<div class="col-md-6 width_50_res padding_left_0">
			<a href="#" class="btn-delete-cat" model="<?php echo $model; ?>" id="<?php echo $retrieved_data->id; ?>"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png"?>" alt=""></a>
		</div>
		<div class="col-md-6 edit_btn_padding_left_25px_res width_50_res padding_right_0">
			<a class="btn-edit-cat"  model="<?php echo $model; ?>" href="#" id="<?php echo $retrieved_data->id; ?>"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/edit.png"?>" alt=""></a>
		</div>
	</div>
	<?php
	die();
}
add_action( 'wp_ajax_mj_smgt_edit_section',  'mj_smgt_edit_section');
add_action( 'wp_ajax_nopriv_mj_smgt_edit_section','mj_smgt_edit_section');
function mj_smgt_edit_section()
{
	$model = $_REQUEST['model'];
	$cat_id = $_REQUEST['cat_id'];
	$retrieved_data = mj_smgt_single_section($cat_id);

	?>
	<div class="form-body user_form">
		<div class="row">
			<div class="col-md-10 width_70 margin_right_10px_res">
				<div class="form-group input">
					<div class="col-md-12 form-control">
						<input type="text" class="validate[required,custom[popup_category_validation]]" name="section_name" maxlength="50" value="<?php echo $retrieved_data->section_name; ?>" id="section_name">
					</div>
				</div>
			</div>
			<div class="row col-md-2 margin_top_10px_web padding_left_0_res width_30 margin_top_13px_res" id="<?php echo $retrieved_data->id; ?>">
				<div class="col-md-6 width_50_res padding_left_0">
					<a class="btn-cat-update-cancel" model="<?php echo $model; ?>" href="#" id="<?php echo $retrieved_data->id; ?>"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/cencal.png"; ?>" alt=""></a>
				</div>
				<div class="col-md-6 edit_btn_padding_left_25px_res width_50_res padding_left_0">
					<a class="btn-cat-update" model="<?php echo $model; ?>" href="#" id="<?php echo $retrieved_data->id; ?>"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/save.png"; ?>" alt="">	</a>
				</div>
			</div>
		</div>
	</div>
	<?php
	die();
}

//-------- invoice print function ---------//
function mj_smgt_student_invoice_print($invoice_id)
{
	
	$obj_invoice= new Smgtinvoice();
	if($_REQUEST['invoice_type']=='invoice')
	{
		$invoice_data=mj_smgt_get_payment_by_id($invoice_id);
	}
	if($_REQUEST['invoice_type']=='income'){
		$income_data=$obj_invoice->mj_smgt_get_income_data($invoice_id);
	}
	if($_REQUEST['invoice_type']=='expense'){
		$expense_data=$obj_invoice->mj_smgt_get_income_data($invoice_id);
	}
	?>
	<link rel="stylesheet" href="<?php echo SMS_PLUGIN_URL.'/assets/css/style.css';?>" type="text/css" />
	<?php
	if ( is_rtl() ) 
	{
		?>
		<link rel="stylesheet" href="<?php echo SMS_PLUGIN_URL.'/assets/css/new_design_rtl.css';?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo SMS_PLUGIN_URL.'/assets/css/custome_rtl.css';?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo SMS_PLUGIN_URL.'/assets/css/Bootstrap/bootstrap-rtl.min.css';?>" type="text/css" />
		<?php
	}

	?>
	<link rel="stylesheet" href="<?php echo SMS_PLUGIN_URL.'/assets/css/smgt_new_design.css';?>" type="text/css" />
	<link rel="stylesheet" href="<?php echo SMS_PLUGIN_URL.'/assets/css/Bootstrap/bootstrap.min.css';?>" type="text/css" />
	<link rel="stylesheet" href="<?php echo SMS_PLUGIN_URL.'/assets/css/datatables.min.css';?>" type="text/css" />
	<style>
		@import url('https://fonts.googleapis.com/css?family=Poppins:400,700,900');
	
		body, body * {
			font-family: 'Poppins' !important;
			}
			
	</style>
	<style>
		table thead {
			-webkit-print-color-adjust:exact;
		}
		.invoice_table_grand_total{
			-webkit-print-color-adjust:exact;
			background-color: #5840bb;
		}
	</style>
	<html>
	<?php
		if (is_rtl())
		{
			?>
			<div class="modal-body margin_top_15px_rs invoice_model_body float_left_width_100 padding_0_res"><!---- model body  ----->
				<img class="rtl_image_set_invoice invoiceimage float_left invoice_image_model"  src="<?php echo plugins_url('/school-management/assets/images/listpage_icon/invoice.png'); ?>" width="100%">
				<div id="invoice_print" class="main_div float_left_width_100 payment_invoice_popup_main_div"> 
					<div class="invoice_width_100 float_left" border="0">
						<h3 class=""><?php echo get_option( 'smgt_school_name' ) ?></h3>
						<div class="row margin_top_20px">
							<div class="col-md-1 col-sm-2 col-xs-3" style="width:8.3333%;">
								<div class="width_1 rtl_width_80px">
									<img class="system_logo"  src="<?php echo esc_url(get_option( 'smgt_school_logo' )); ?>">
								</div>
							</div>					
							<div  style="width:91.3333%;" class="col-md-11 col-sm-10 col-xs-9 invoice_address invoice_address_css">	
								<div class="row">	
									<div class="col-md-12 col-sm-12 col-xs-12 invoice_padding_bottom_15px padding_right_0 width_25px_res">	
										<label class="popup_label_heading"><?php esc_html_e('Address','school-mgt');
										?>
										</label><br>
										<label style="padding-top:10px;" for="" class="label_value word_break_all">	<?php
												echo chunk_split(get_option( 'smgt_school_address' ),100,"<BR>").""; 
											?></label>
									</div>
									<div class="row col-md-12 invoice_padding_bottom_15px">	
										<div style="width:50%;" class="col-md-6 col-sm-6 col-xs-6 address_css padding_right_0 email_width_auto">	
											<label class="popup_label_heading"><?php esc_html_e('Email','school-mgt');?> </label><br>
											<label style="padding-top:10px;" for="" class="label_value word_break_all"><?php echo get_option( 'smgt_email' ),"<BR>";  ?></label>
										</div>
								
										<div style="width:50%;" class="col-md-6 col-sm-6 col-xs-6 address_css padding_right_0 padding_left_30px">
											<label class="popup_label_heading"><?php esc_html_e('Phone','school-mgt');?> </label><br>
											<label style="padding-top:10px;" for="" class="label_value"><?php echo get_option( 'smgt_contact_number' )."<br>";  ?></label>
										</div>
									</div>	
									<div align="right" class="width_24"></div>									
								</div>				
							</div>
						</div>
						
					<div class="col-md-12 col-sm-12 col-xl-12 mozila_display_css margin_top_20px">
						<div class="row">
							<div class="float_left_width_100">
								<div class="col-md-12 col-sm-12 col-xs-12 padding_0 float_left display_grid display_inherit_res margin_bottom_20px">
									<div class="billed_to display_flex display_inherit_res invoice_address_heading" style="float:left;width:100%">								
										<?php
										$issue_date='DD-MM-YYYY';
										if(!empty($income_data))
										{
											$issue_date=$income_data->income_create_date;
											$payment_status=$income_data->payment_status;
										}
										if(!empty($invoice_data))
										{
											$issue_date=$invoice_data->date;
											$payment_status=$invoice_data->payment_status;	
										}
										if(!empty($expense_data))
										{
											$issue_date=$expense_data->income_create_date;
											$payment_status=$expense_data->payment_status;
										}
									
										?>
										<div style="display: flex; width: 100%;">
											<div style="width:50%">
												<h3 class="billed_to_lable invoice_model_heading bill_to_width_12" style="width:100%;"><?php esc_html_e('Bill To','school-mgt');?> : </h3>
											</div>
											<div style="width:100%;float: left;">
												
												<?php
												if(!empty($expense_data))
												{
													$party_name=$expense_data->supplier_name; 
													echo "<h3 class='display_name invoice_width_100' style='width:100%;float: right;'>".chunk_split(ucwords($party_name),100). "</h3>";
												}
												else{
													if(!empty($income_data))
														$student_id=$income_data->supplier_name;
													if(!empty($invoice_data))
														$student_id=$invoice_data->student_id;
													$patient=get_userdata($student_id);						
													echo "<h3 class='display_name invoice_width_100' style='width:100%;float: right;'>".chunk_split(ucwords($patient->display_name),100,"<BR>"). "</h3>";
												}
												?>
											</div>
										</div>
									</div>
									<div class="address_information_invoice" width="100%" style="float:right;width:100%;" >								
										<?php 	
										if(!empty($expense_data))
										{
											$party_name=$expense_data->supplier_name; 
											echo "<h3 class='display_name invoice_width_100'>".chunk_split(ucwords($party_name),30,"<BR>"). "</h3>";
										}
										else
										{
											if(!empty($income_data))
												$student_id=$income_data->supplier_name;
											if(!empty($invoice_data))
												$student_id=$invoice_data->student_id;
											$patient=get_userdata($student_id);						
											// echo "<h3 class='display_name invoice_width_100'>".chunk_split(ucwords($patient->display_name),30,"<BR>"). "</h3>";
											$address=get_user_meta( $student_id,'address',true );

											echo chunk_split($address,30,"<BR>"); 
											echo get_user_meta( $student_id,'city',true ).","."<BR>"; ; 
											echo get_user_meta( $student_id,'zip_code',true ).",<BR>"; 
										}		
										?>	
										</div>
									</div>
									<div class="col-md-3 col-sm-3 col-xs-3" style="float:left;width:100%;">
										<div class="width_50a1112">
											<div class="width_20c" align="right">
												<?php
												if(!empty($invoice_data))
												{
													
												}
												?>
												<h5 class="align_left"> <label class="popup_label_heading text-transfer-upercase"><?php   echo esc_html__('Date :','school-mgt') ?> </label>&nbsp;  <label class="invoice_model_value"><?php echo mj_smgt_getdate_in_input_box(date("Y-m-d", strtotime($issue_date))); ?></label></h5>
												<h5 class="align_left"><label class="popup_label_heading text-transfer-upercase"><?php echo esc_html__('Status :','school-mgt')?> </label>  &nbsp;<label class="invoice_model_value"><?php 
													if($payment_status=='Paid') 
													{ echo esc_attr__('Fully Paid','school-mgt');}
													if($payment_status=='Part Paid')
													{ echo esc_attr__('Partially Paid','school-mgt');}
													if($payment_status=='Unpaid')
													{echo esc_attr__('Unpaid','school-mgt'); } ?></h5>														
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>	
						<table class="width_100 margin_top_10px_res">	
							<tbody>		
								<tr>
									<td>
										<?php
										if(!empty($invoice_data))
										{
											?>
											<h3 class="display_name"><?php esc_attr_e('Invoice Entries','school-mgt');?></h3>
											<?php
										}
										elseif(!empty($income_data))
										{
											?>
											<h3 class="display_name"><?php esc_attr_e('Income Entries','school-mgt');?></h3>
											<?php
										}
										elseif(!empty($expense_data))
										{
											?>
											<h3 class="display_name"><?php esc_attr_e('Expense Entries','school-mgt');?></h3>
											<?php
										}
										?>
										
									<td>	
								</tr>
							</tbody>
						</table>
						<div class="table-responsive">
							<table class="table model_invoice_table">
								<thead class="entry_heading invoice_model_entry_heading">					
									<tr>
										<th class="entry_table_heading align_center">#</th>
										<th class="entry_table_heading align_center"> <?php esc_attr_e('Date','school-mgt');?></th>
										<th class="entry_table_heading align_center"><?php esc_attr_e('Entry','school-mgt');?> </th>
										<th class="entry_table_heading align_center"><?php esc_attr_e('Price','school-mgt');?></th>
										<th class="entry_table_heading align_center"> <?php esc_attr_e('Issue By','school-mgt');?> </th>
									</tr>						
								</thead>
								<tbody>
									<?php 
									$id=1;
									$total_amount=0;
									if(!empty($income_data) || !empty($expense_data))
									{
										if(!empty($expense_data))
										{
											$income_data=$expense_data;
										}
										
										$patient_all_income=$obj_invoice->mj_smgt_get_onepatient_income_data($income_data->supplier_name);
									
										foreach($patient_all_income as $result_income)
										{
											$income_entries=json_decode($result_income->entry);
											foreach($income_entries as $each_entry)
											{
												$total_amount+=$each_entry->amount;								
												?>
												<tr>
													<td class="align_center invoice_table_data"><?php echo $id;?></td>
													<td class="align_center invoice_table_data"><?php echo $result_income->income_create_date;?></td>
													<td class="align_center invoice_table_data"><?php echo $each_entry->entry; ?> </td>
													<td class="align_center invoice_table_data"> <?php echo "<span> ". mj_smgt_get_currency_symbol() ."</span>" .number_format($each_entry->amount,2) ; ?></td>
													<td class="align_center invoice_table_data"><?php echo mj_smgt_get_display_name($result_income->create_by);?></td>
												</tr>
												<?php 
												$id+=1;
											}
										}
									}
									if(!empty($invoice_data))
									{
										$total_amount=$invoice_data->amount
										?>
										<tr>
											<td class="align_center invoice_table_data"><?php echo $id;?></td>
											<td class="align_center invoice_table_data"><?php echo date("Y-m-d", strtotime($invoice_data->date));?></td>
											<td class="align_center invoice_table_data"><?php echo $invoice_data->payment_title; ?> </td>
											<td class="align_center invoice_table_data"> <?php echo "<span> ". mj_smgt_get_currency_symbol() ." </span>" .number_format($invoice_data->amount,2); ?></td>
											<td class="align_center invoice_table_data"><?php echo mj_smgt_get_display_name($invoice_data->payment_reciever_id);?></td>
										</tr>
										<?php 
									}?>
								</tbody>
							</table>
						</div>
						
											
						<?php 
						if(!empty($invoice_data))
						{								
							$grand_total= $total_amount;							
						}
						if(!empty($income_data))
						{
							$grand_total=$total_amount;
						}
						?>								
						<div class="row margin_top_10px_res col-md-6 col-sm-6 col-xs-6 view_invoice_lable_css float_left grand_total_div invoice_table_grand_total" style="width:50%;float: right;display:inline-block;margin-right:0px;">
							<div style="width:50%;" class="width_50_res align_right col-md-8 col-sm-8 col-xs-8 view_invoice_lable padding_11 padding_right_0_left_0 float_left grand_total_label_div invoice_model_height line_height_1_5 padding_left_0_px"><h3 style="float: right;" class="padding color_white margin invoice_total_label"><?php esc_html_e('Grand Total','school-mgt');?> </h3></div>
							<div style="width:50%;" class="width_50_res align_right col-md-4 col-sm-4 col-xs-4 view_invoice_lable  padding_right_5_left_5 padding_11 float_left grand_total_amount_div"><h3 class="padding margin text-right color_white invoice_total_value" style="float: right;"><?php echo "<span>".mj_smgt_get_currency_symbol()."</span> ".number_format($grand_total,2); ?></h3></div>
						</div>

						<div class="margin_top_20px"></div>
					</div>
				</div>
			</div><!---- model body  ----->
			<?php
		}
		else 
		{
			?>
			<div class="modal-body margin_top_15px_rs invoice_model_body float_left_width_100 padding_0_res"><!---- model body  ----->
				<img class="invoiceimage float_left invoice_image_model"  src="<?php echo plugins_url('/school-management/assets/images/listpage_icon/invoice.png'); ?>" width="100%">
				<div id="invoice_print" class="main_div float_left_width_100 payment_invoice_popup_main_div"> 
					<div class="invoice_width_100 float_left" border="0">
						<h3 class=""><?php echo get_option( 'smgt_school_name' ) ?></h3>
						<div class="row margin_top_20px">
							<div class="col-md-1 col-sm-2 col-xs-3" style="width:8.3333%;">
								<div class="width_1">
									<img class="system_logo"  src="<?php echo esc_url(get_option( 'smgt_school_logo' )); ?>">
								</div>
							</div>					
							<div  style="width:91.3333%;" class="col-md-11 col-sm-10 col-xs-9 invoice_address invoice_address_css">	
								<div class="row">	
									<div class="col-md-12 col-sm-12 col-xs-12 invoice_padding_bottom_15px padding_right_0 width_25px_res">	
										<label class="popup_label_heading"><?php esc_html_e('Address','school-mgt');
										?>
										</label><br>
										<label style="padding-top:10px;" for="" class="label_value word_break_all">	<?php
												echo chunk_split(get_option( 'smgt_school_address' ),100,"<BR>").""; 
											?></label>
									</div>
									<div class="row col-md-12 invoice_padding_bottom_15px">	
										<div style="width:50%;" class="col-md-6 col-sm-6 col-xs-6 address_css padding_right_0 email_width_auto">	
											<label class="popup_label_heading"><?php esc_html_e('Email','school-mgt');?> </label><br>
											<label style="padding-top:10px;" for="" class="label_value word_break_all"><?php echo get_option( 'smgt_email' ),"<BR>";  ?></label>
										</div>
								
										<div style="width:50%;" class="col-md-6 col-sm-6 col-xs-6 address_css padding_right_0 padding_left_30px">
											<label class="popup_label_heading"><?php esc_html_e('Phone','school-mgt');?> </label><br>
											<label style="padding-top:10px;" for="" class="label_value"><?php echo get_option( 'smgt_contact_number' )."<br>";  ?></label>
										</div>
									</div>	
									<div align="right" class="width_24"></div>									
								</div>				
							</div>
						</div>
						
					<div class="col-md-12 col-sm-12 col-xl-12 mozila_display_css margin_top_20px">
						<div class="row">
							<div class="float_left_width_100">
								<div class="col-md-12 col-sm-12 col-xs-12 padding_0 float_left display_grid display_inherit_res margin_bottom_20px">
									<div class="billed_to display_flex display_inherit_res invoice_address_heading" style="float:left;width:100%">								
										<?php
										$issue_date='DD-MM-YYYY';
										if(!empty($income_data))
										{
											$issue_date=$income_data->income_create_date;
											$payment_status=$income_data->payment_status;
										}
										if(!empty($invoice_data))
										{
											$issue_date=$invoice_data->date;
											$payment_status=$invoice_data->payment_status;	
										}
										if(!empty($expense_data))
										{
											$issue_date=$expense_data->income_create_date;
											$payment_status=$expense_data->payment_status;
										}
									
										?>
										<div style="display: flex; width: 100%;">
											<div style="width:50%">
												<h3 class="billed_to_lable invoice_model_heading bill_to_width_12" style="width:100%;"><?php esc_html_e('Bill To','school-mgt');?> : </h3>
											</div>
											<div style="width:100%;float: left;">
												
												<?php
												if(!empty($expense_data))
												{
													$party_name=$expense_data->supplier_name; 
													echo "<h3 class='display_name invoice_width_100' style='width:100%;float: left;'>".chunk_split(ucwords($party_name),100). "</h3>";
												}
												else{
													if(!empty($income_data))
														$student_id=$income_data->supplier_name;
													if(!empty($invoice_data))
														$student_id=$invoice_data->student_id;
													$patient=get_userdata($student_id);						
													echo "<h3 class='display_name invoice_width_100' style='width:100%;float: left;'>".chunk_split(ucwords($patient->display_name),100,"<BR>"). "</h3>";
												}
												?>
											</div>
										</div>
									</div>
									<div class="address_information_invoice" width="100%" style="float:left;width:100%;" >								
										<?php 	
										if(!empty($expense_data))
										{
											$party_name=$expense_data->supplier_name; 
											echo "<h3 class='display_name invoice_width_100'>".chunk_split(ucwords($party_name),30,"<BR>"). "</h3>";
										}
										else
										{
											if(!empty($income_data))
												$student_id=$income_data->supplier_name;
											if(!empty($invoice_data))
												$student_id=$invoice_data->student_id;
											$patient=get_userdata($student_id);						
											// echo "<h3 class='display_name invoice_width_100'>".chunk_split(ucwords($patient->display_name),30,"<BR>"). "</h3>";
											$address=get_user_meta( $student_id,'address',true );

											echo chunk_split($address,30,"<BR>"); 
											echo get_user_meta( $student_id,'city',true ).","."<BR>"; ; 
											echo get_user_meta( $student_id,'zip_code',true ).",<BR>"; 
										}		
										?>	
										</div>
									</div>
									<div class="col-md-3 col-sm-3 col-xs-3 float_left" style="float:right;">
										<div class="width_50a1112">
											<div class="width_20c" align="right">
												<?php
												if(!empty($invoice_data))
												{
													
												}
												?>
												<h5 class="align_left"> <label class="popup_label_heading text-transfer-upercase"><?php   echo esc_html__('Date :','school-mgt') ?> </label>&nbsp;  <label class="invoice_model_value"><?php echo mj_smgt_getdate_in_input_box(date("Y-m-d", strtotime($issue_date))); ?></label></h5>
												<h5 class="align_left"><label class="popup_label_heading text-transfer-upercase"><?php echo esc_html__('Status :','school-mgt')?> </label>  &nbsp;<label class="invoice_model_value"><?php 
													if($payment_status=='Paid') 
													{ echo esc_attr__('Fully Paid','school-mgt');}
													if($payment_status=='Part Paid')
													{ echo esc_attr__('Partially Paid','school-mgt');}
													if($payment_status=='Unpaid')
													{echo esc_attr__('Unpaid','school-mgt'); } ?></h5>														
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>	
						<table class="width_100 margin_top_10px_res">	
							<tbody>		
								<tr>
									<td>
										<?php
										if(!empty($invoice_data))
										{
											?>
											<h3 class="display_name"><?php esc_attr_e('Invoice Entries','school-mgt');?></h3>
											<?php
										}
										elseif(!empty($income_data))
										{
											?>
											<h3 class="display_name"><?php esc_attr_e('Income Entries','school-mgt');?></h3>
											<?php
										}
										elseif(!empty($expense_data))
										{
											?>
											<h3 class="display_name"><?php esc_attr_e('Expense Entries','school-mgt');?></h3>
											<?php
										}
										?>
										
									<td>	
								</tr>
							</tbody>
						</table>
						<div class="table-responsive">
							<table class="table model_invoice_table">
								<thead class="entry_heading invoice_model_entry_heading">					
									<tr>
										<th class="entry_table_heading align_center">#</th>
										<th class="entry_table_heading align_center"> <?php esc_attr_e('Date','school-mgt');?></th>
										<th class="entry_table_heading align_center"><?php esc_attr_e('Entry','school-mgt');?> </th>
										<th class="entry_table_heading align_center"><?php esc_attr_e('Price','school-mgt');?></th>
										<th class="entry_table_heading align_center"> <?php esc_attr_e('Issue By','school-mgt');?> </th>
									</tr>						
								</thead>
								<tbody>
									<?php 
									$id=1;
									$total_amount=0;
									if(!empty($income_data) || !empty($expense_data))
									{
										if(!empty($expense_data))
										{
											$income_data=$expense_data;
										}
										
										$patient_all_income=$obj_invoice->mj_smgt_get_onepatient_income_data($income_data->supplier_name);
									
										foreach($patient_all_income as $result_income)
										{
											$income_entries=json_decode($result_income->entry);
											foreach($income_entries as $each_entry)
											{
												$total_amount+=$each_entry->amount;								
												?>
												<tr>
													<td class="align_center invoice_table_data"><?php echo $id;?></td>
													<td class="align_center invoice_table_data"><?php echo $result_income->income_create_date;?></td>
													<td class="align_center invoice_table_data"><?php echo $each_entry->entry; ?> </td>
													<td class="align_center invoice_table_data"> <?php echo "<span> ". mj_smgt_get_currency_symbol() ."</span>" .number_format($each_entry->amount,2) ; ?></td>
													<td class="align_center invoice_table_data"><?php echo mj_smgt_get_display_name($result_income->create_by);?></td>
												</tr>
												<?php 
												$id+=1;
											}
										}
									}
									if(!empty($invoice_data))
									{
										$total_amount=$invoice_data->amount
										?>
										<tr>
											<td class="align_center invoice_table_data"><?php echo $id;?></td>
											<td class="align_center invoice_table_data"><?php echo date("Y-m-d", strtotime($invoice_data->date));?></td>
											<td class="align_center invoice_table_data"><?php echo $invoice_data->payment_title; ?> </td>
											<td class="align_center invoice_table_data"> <?php echo "<span> ". mj_smgt_get_currency_symbol() ." </span>" .number_format($invoice_data->amount,2); ?></td>
											<td class="align_center invoice_table_data"><?php echo mj_smgt_get_display_name($invoice_data->payment_reciever_id);?></td>
										</tr>
										<?php 
									}?>
								</tbody>
							</table>
						</div>
						
											
						<?php 
						if(!empty($invoice_data))
						{								
							$grand_total= $total_amount;							
						}
						if(!empty($income_data))
						{
							$grand_total=$total_amount;
						}
						?>								
						<div class="row margin_top_10px_res col-md-6 col-sm-6 col-xs-6 view_invoice_lable_css float_left grand_total_div invoice_table_grand_total" style="width:50%;float: right;display:inline-block;margin-right:0px;">
							<div style="width:50%;" class="width_50_res align_right col-md-8 col-sm-8 col-xs-8 view_invoice_lable padding_11 padding_right_0_left_0 float_left grand_total_label_div invoice_model_height line_height_1_5 padding_left_0_px"><h3 style="float: right;" class="padding color_white margin invoice_total_label"><?php esc_html_e('Grand Total','school-mgt');?> </h3></div>
							<div style="width:50%;" class="width_50_res align_right col-md-4 col-sm-4 col-xs-4 view_invoice_lable  padding_right_5_left_5 padding_11 float_left grand_total_amount_div"><h3 class="padding margin text-right color_white invoice_total_value" style="float: right;"><?php echo "<span>".mj_smgt_get_currency_symbol()."</span> ".number_format($grand_total,2); ?></h3></div>
						</div>

						<div class="margin_top_20px"></div>
					</div>
				</div>
			</div><!---- model body  ----->
			<?php	
		}
}

//----------  Fees Payment Print Function -----------//
function mj_smgt_student_fees_invoice_print($fees_pay_id)
{
    $fees_detail_result = mj_smgt_get_single_fees_payment_record($fees_pay_id);
    $fees_history_detail_result = mj_smgt_get_payment_history_by_feespayid($fees_pay_id);
    $obj_feespayment= new mj_smgt_feespayment();
	?>

	<link rel="stylesheet" href="<?php echo SMS_PLUGIN_URL.'/assets/css/style.css';?>" type="text/css" />
	<link rel="stylesheet" href="<?php echo SMS_PLUGIN_URL.'/assets/css/smgt_new_design.css';?>" type="text/css" />
	<link rel="stylesheet" href="<?php echo SMS_PLUGIN_URL.'/assets/css/Bootstrap/bootstrap.min.css';?>" type="text/css" />
	<link rel="stylesheet" href="<?php echo SMS_PLUGIN_URL.'/assets/css/datatables.min.css';?>" type="text/css" />
	<style>
		@import url('https://fonts.googleapis.com/css?family=Poppins:400,700,900');
	
		body, body * {
			font-family: 'Poppins' !important;
			}
			
	</style>
	<style>
		table thead {
			-webkit-print-color-adjust:exact;
		}
		.invoice_table_grand_total{
			-webkit-print-color-adjust:exact;
			background-color: #5840bb;
		}
	</style>

	<div id="Fees_invoice">
		<div class="modal-body margin_top_15px_rs invoice_model_body float_left_width_100 padding_0_res height_1000px">
			<img class="invoiceimage float_left invoice_image_model"  src="<?php echo plugins_url('/school-management/assets/images/listpage_icon/invoice.png'); ?>" width="100%">
			<div id="invoice_print" class="main_div float_left_width_100 payment_invoice_popup_main_div"> 
				<div class="invoice_width_100 float_left" border="0">
					<h3 class=""><?php echo get_option( 'smgt_school_name' ) ?></h3>
					<div class="row margin_top_20px">
						<div class="col-md-1 col-sm-2 col-xs-3" style="width:8.3333%;">
							<div class="width_1">
								<img class="system_logo"  src="<?php echo esc_url(get_option( 'smgt_school_logo' )); ?>">
							</div>
						</div>						
						<div  style="width:91.3333%;" class="col-md-11 col-sm-10 col-xs-9 invoice_address invoice_address_css">	
							<div class="row">	
								<div class="col-md-12 col-sm-12 col-xs-12 invoice_padding_bottom_15px padding_right_0 width_25px_res">	
									<label class="popup_label_heading"><?php esc_html_e('Address','school-mgt');
									?>
									</label><br>
									<label style="padding-top:10px;" for="" class="label_value word_break_all">	<?php
											echo chunk_split(get_option( 'smgt_school_address' ),100,"<BR>").""; 
										?></label>
								</div>
								<div class="row col-md-12 invoice_padding_bottom_15px">	
									<div style="width:50%;" class="col-md-6 col-sm-6 col-xs-6 address_css padding_right_0 email_width_auto">	
										<label class="popup_label_heading"><?php esc_html_e('Email','school-mgt');?> </label><br>
										<label style="padding-top:10px;" for="" class="label_value word_break_all"><?php echo get_option( 'smgt_email' ),"<BR>";  ?></label>
									</div>
							
									<div style="width:50%;" class="col-md-6 col-sm-6 col-xs-6 address_css padding_right_0 padding_left_30px">
										<label class="popup_label_heading"><?php esc_html_e('Phone','school-mgt');?> </label><br>
										<label style="padding-top:10px;" for="" class="label_value"><?php echo get_option( 'smgt_contact_number' )."<br>";  ?></label>
									</div>
								</div>	
								<div align="right" class="width_24"></div>									
							</div>				
						</div>
						
				</div>
				<div class="col-md-12 col-sm-12 col-xl-12 mozila_display_css margin_top_20px">
					<div class="row">
						<div class="width_50a1 float_left_width_100">
							<div class="col-md-8 col-sm-8 col-xs-5 padding_0 float_left display_grid display_inherit_res margin_bottom_20px">
								<div class="billed_to display_flex display_inherit_res invoice_address_heading" style="float:left;width:100%">								
									<h3 class="billed_to_lable invoice_model_heading bill_to_width_12" style="width:38%;"><?php esc_html_e('Bill To','school-mgt');?> : </h3>
									<?php
										$student_id=$fees_detail_result->student_id;
										$patient=get_userdata($student_id);						
										echo "<h3 class='display_name invoice_width_100'>".chunk_split(ucwords($patient->display_name),50). "</h3>";
									?>
								</div>
								<div class="width_60b2 address_information_invoice">								
									<?php 	
									$student_id=$fees_detail_result->student_id;	
									$patient=get_userdata($student_id);						
									// echo "<h3 class='display_name invoice_width_100'>".chunk_split(ucwords($patient->display_name),30,"<BR>"). "</h3>";
									$address=get_user_meta( $student_id,'address',true );

									echo chunk_split($address,30,"<BR>"); 
									echo get_user_meta( $student_id,'city',true ).","."<BR>"; ; 
									echo get_user_meta( $student_id,'zip_code',true ).",<BR>"; 
									?>	
									</div>
								</div>
								<div class="col-md-3 col-sm-4 col-xs-7 float_left" style="float:right;">
									<div class="width_50a1112">
										<div class="width_20c" align="center">
											<?php
										
											$issue_date='DD-MM-YYYY';
											$issue_date=$fees_detail_result->paid_by_date;	
											$payment_status = mj_smgt_get_payment_status($fees_detail_result->fees_pay_id);	
											?>
											<h5 class="align_left"> <label class="popup_label_heading text-transfer-upercase"><?php   echo esc_html__('Date :','school-mgt') ?> </label>&nbsp;  <label class="invoice_model_value"><?php echo mj_smgt_getdate_in_input_box(date("Y-m-d", strtotime($issue_date))); ?></label></h5>
											<h5 class="align_left"><label class="popup_label_heading text-transfer-upercase"><?php echo esc_html__('Status :','school-mgt')?> </label>  &nbsp;<label class="invoice_model_value"><?php 
												if($payment_status=='Fully Paid') 
												{ echo esc_attr__('Fully Paid','school-mgt');}
												if($payment_status=='Partially Paid')
												{ echo esc_attr__('Partially Paid','school-mgt');}
												if($payment_status=='Not Paid')
												{echo esc_attr__('Not Paid','school-mgt'); } ?></h5>														
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>	
					<table class="width_100 margin_top_10px_res">	
						<tbody>		
							<tr>
								<td>
									<h3 class="display_name"><?php esc_attr_e('Invoice Entries','school-mgt');?></h3>
								<td>	
							</tr>
						</tbody>
					</table>
					<div class="table-responsive padding_bottom_15px">
						<table class="table model_invoice_table">
							<thead class="entry_heading invoice_model_entry_heading">					
								<tr>
									<th class="entry_table_heading align_left">#</th>
									<th class="entry_table_heading align_left"><?php esc_attr_e('Date','school-mgt');?></th>
									<th class="entry_table_heading align_left"> <?php esc_attr_e('Fees Type','school-mgt');?></th>
									<th class="entry_table_heading align_left"><?php esc_attr_e('Total','school-mgt');?> </th>					
								</tr>						
							</thead>
							<tbody>
								<?php 
								$fees_id=explode(',',$fees_detail_result->fees_id);
								$x=1;
								foreach($fees_id as $id)
								{ 
									?>
									<tr>
										<td class="align_left invoice_table_data"> <?php echo $x; ?></td>
										<td class="align_left invoice_table_data"> <?php echo mj_smgt_getdate_in_input_box($fees_detail_result->created_date);?></td>
										<td class="align_left invoice_table_data"> <?php echo mj_smgt_get_fees_term_name($id); ?></td>
										<td class="align_left invoice_table_data">
											<?php
											$amount=$obj_feespayment->mj_smgt_feetype_amount_data($id);
											echo "<span> ". mj_smgt_get_currency_symbol()." </span>" . number_format($amount,2); 
											?>
										</td>
									</tr>
									<?php
									$x++;
								}
								?>
							</tbody>
						</table>
					</div>
					<div class="table-responsive">
						<table width="100%" border="0">
							<tbody>							
								<tr style="">
									<td  align="right" class="padding_bottom_15px total_heading"><?php esc_attr_e('Sub Total :','school-mgt');?></td>
									<td align="left" class="padding_bottom_15px total_value"><?php echo mj_smgt_get_currency_symbol().number_format($fees_detail_result->total_amount,2); ?></td>
								</tr>
								<tr>
									<td width="85%" class="padding_bottom_15px total_heading" align="right"><?php esc_attr_e('Payment Made :','school-mgt');?></td>
									<td align="left" class="padding_bottom_15px total_value"><?php echo mj_smgt_get_currency_symbol().number_format($fees_detail_result->fees_paid_amount,2);?></td>
								</tr>
								<tr>
									<td width="85%" class="padding_bottom_15px total_heading" align="right"><?php esc_attr_e('Due Amount :','school-mgt');?></td>
									<?php $Due_amount = $fees_detail_result->total_amount - $fees_detail_result->fees_paid_amount; ?>
									<td align="left" class="padding_bottom_15px total_value"><?php echo mj_smgt_get_currency_symbol().number_format($Due_amount,2); ?></td>
								</tr>				
							</tbody>
						</table>
					</div>
					
						<?php
						$subtotal = $fees_detail_result->total_amount;
						$paid_amount = $fees_detail_result->fees_paid_amount;
						$grand_total = $subtotal - $paid_amount;
						?>
						<div class="row margin_top_10px_res col-md-6 col-sm-6 col-xs-6 view_invoice_lable_css float_left grand_total_div invoice_table_grand_total" style="width:50%;float: right;display:inline-block;margin-right:0px;">
							<div style="width:50%;" class="width_50_res align_right col-md-8 col-sm-8 col-xs-8 view_invoice_lable padding_11 padding_right_0_left_0 float_left grand_total_label_div invoice_model_height line_height_1_5 padding_left_0_px"><h3 style="float: right;" class="padding color_white margin invoice_total_label"><?php esc_html_e('Grand Total','school-mgt');?> </h3></div>
							<div style="width:50%;" class="width_50_res align_right col-md-4 col-sm-4 col-xs-4 view_invoice_lable  padding_right_5_left_5 padding_11 float_left grand_total_amount_div"><h3 class="padding margin text-right color_white invoice_total_value" style="float: right;"><?php echo "<span>".mj_smgt_get_currency_symbol()."</span> ".number_format($subtotal,2); ?></h3></div>
						</div>
					
					<?php if(!empty($fees_history_detail_result))
					{ 
						?>
						<table class="width_100 margin_top_10px_res">	
							<tbody>		
								<tr>
									<td>
										<h3 class="display_name"><?php esc_attr_e('Payment History','school-mgt');?></h3>
									<td>	
								</tr>
							</tbody>
						</table>
						<div class="table-responsive">
							<table class="table model_invoice_table">
								<thead class="entry_heading invoice_model_entry_heading">
									<tr>
										<th class="entry_table_heading align_left"><?php esc_attr_e('Date','school-mgt');?></th>
										<th class="entry_table_heading align_left"> <?php esc_attr_e('Amount','school-mgt');?></th>
										<th class="entry_table_heading align_left"><?php esc_attr_e('Method','school-mgt');?> </th>
										
									</tr>
								</thead>
								<tbody>
									<?php 
									foreach($fees_history_detail_result as  $retrive_date)
									{
									?>
									<tr>
										<td class="align_left invoice_table_data"><?php echo mj_smgt_getdate_in_input_box($retrive_date->paid_by_date);?></td>
										<td class="align_left invoice_table_data"><?php echo mj_smgt_get_currency_symbol() .number_format($retrive_date->amount,2);?></td>
										<td class="align_left invoice_table_data"><?php  $data=$retrive_date->payment_method;
											echo esc_attr__("$data","school-mgt");
											?>
										</td>
									</tr>
									<?php }?>
								</tbody>
							</table>
						</div>
						<?php 
					} ?>
					
					<div class="margin_top_20px"></div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
function mj_smgt_student_invoice_pdf($invoice_id)
{

	$obj_invoice= new Smgtinvoice();
	if($_REQUEST['invoice_type']=='invoice')
	{
		$invoice_data=mj_smgt_get_payment_by_id($invoice_id);
	}
	if($_REQUEST['invoice_type']=='income')
	{
		$income_data=$obj_invoice->mj_smgt_get_income_data($invoice_id);
	}
	if($_REQUEST['invoice_type']=='expense')
	{
		$expense_data=$obj_invoice->mj_smgt_get_income_data($invoice_id);
	}	
	?>

	<style>
		.popup_label_heading{
			color: #818386;
			font-size: 14px !important;
			font-weight: 500;
			font-family: 'Poppins' !important;
			text-transform: capitalize;
		}
	
	</style>
	<h3 class=""><?php echo get_option( 'smgt_school_name' ) ?></h3>
	<?php
	if (is_rtl())
	{
		?>
		<table style="float: right;position: absolute;vertical-align: top;background-repeat: no-repeat;">
			<tbody>
				<tr>
					<td>
						<img class="invoiceimage float_left invoice_image_model"  src="<?php echo plugins_url('/school-management/assets/images/listpage_icon/invoice_rtl.png'); ?>" width="100%">
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}
	else
	{
		?>
		<table style="float: left;position: absolute;vertical-align: top;background-repeat: no-repeat;">
			<tbody>
				<tr>
					<td>
						<img class="invoiceimage float_left invoice_image_model"  src="<?php echo plugins_url('/school-management/assets/images/listpage_icon/invoice.png'); ?>" width="100%">
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}
	?>
	<table style="float: left;width: 100%;position: absolute!important;margin-top:-170px;">
		<tbody>
			<tr>
				<td>
					<table>
						<tbody>
							<tr>
								<td width="22%" >
									<img class="system_logo"  src="<?php echo esc_url(get_option( 'smgt_school_logo' )); ?>">	
								</td>
								<td width="80%" style="padding-left: 10px;">
									<label class="popup_label_heading"><?php esc_html_e('Address','school-mgt'); ?></label><br>
									<label for="" class="label_value word_break_all" style="color: #333333 !important;font-weight: 400;"><?php echo chunk_split(get_option( 'smgt_school_address' ),100,"<BR>").""; ?></label><br>
									
									<label class="popup_label_heading"><?php esc_html_e('Email','school-mgt');?> </label><br>
									<label for="" style="color: #333333 !important;font-weight: 400;" class="label_value word_break_all"><?php echo get_option( 'smgt_email' ),"<BR>";  ?></label><br>

									<label class="popup_label_heading"><?php esc_html_e('Phone','school-mgt');?> </label><br>
									<label for="" style="color: #333333 !important;font-weight: 400;" class="label_value"><?php echo get_option( 'smgt_contact_number' )."<br>";  ?></label>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
	<br>

	<table>
		<tbody>
			<tr>
				<td width="70%">
					<h3 class="billed_to_lable invoice_model_heading bill_to_width_12"><?php esc_html_e('Bill To','school-mgt');?> : </h3>
					<?php
					if(!empty($expense_data))
					{
						echo $party_name=$expense_data->supplier_name; 
					}
					else
					{
						if(!empty($income_data))
							$student_id=$income_data->supplier_name;
						if(!empty($invoice_data))
							$student_id=$invoice_data->student_id;											
						$patient=get_userdata($student_id);
						echo "<h3 class='display_name invoice_width_100'>".chunk_split(ucwords($patient->display_name),30,"<BR>"). "</h3>";
					}
					?>
					<div>
						<?php 
						if(!empty($expense_data))
						{
							echo $party_name=$expense_data->supplier_name; 
						}
						else
						{
							if(!empty($income_data))
								$student_id=$income_data->supplier_name;
							if(!empty($invoice_data))
								$student_id=$invoice_data->student_id;											
							$patient=get_userdata($student_id);
												
							// echo "<h3 class='display_name invoice_width_100'>".chunk_split(ucwords($patient->display_name),30,"<BR>"). "</h3>";
							$address=get_user_meta( $student_id,'address',true );

							echo chunk_split($address,30,"<BR>"); 
							echo get_user_meta( $student_id,'city',true ).","."<BR>"; ; 
							echo get_user_meta( $student_id,'zip_code',true ).",<BR>"; 
						}	
						?>
					</div>
						
				</td>
				<td width="15%">
					<?php
					if(!empty($invoice_data))
					{
						
					}
					
					$issue_date='DD-MM-YYYY';
					if(!empty($income_data))
					{
						$issue_date=$income_data->income_create_date;
						$payment_status=$income_data->payment_status;
					}
					if(!empty($invoice_data))
					{
						$issue_date=$invoice_data->date;
						$payment_status=$invoice_data->payment_status;	
					}
					if(!empty($expense_data))
					{
						$issue_date=$expense_data->income_create_date;
						$payment_status=$expense_data->payment_status;
					}
					
					?>
					<label style="color: #818386 !important;font-size: 14px !important;text-transform: uppercase;font-weight: 500;line-height: 0px;"><?php echo esc_html__('Date','school-mgt') ?> </label>: <label class="invoice_model_value" style="font-weight: 600;color: #333333;font-size: 16px !important;"><?php echo mj_smgt_getdate_in_input_box(date("Y-m-d", strtotime($issue_date))); ?></label><br>
					<label style="color: #818386 !important;font-size: 14px !important;text-transform: uppercase;font-weight: 500;line-height: 0px;"><?php echo esc_html__('Status','school-mgt')?> </label>: <label class="invoice_model_value" style="font-weight: 600;color: #333333;font-size: 16px !important;"><?php 
				
						if($payment_status=='Paid') 
						{ 
							echo esc_attr__('Fully Paid','school-mgt');
						}
						if($payment_status=='Part Paid')
						{ 
							echo esc_attr__('Partially Paid','school-mgt');
						}
						if($payment_status=='Unpaid')
						{
							echo esc_attr__('Unpaid','school-mgt'); 
						} ?></label>
				</td>
			</tr>
		</tbody>
	</table>

	<h4 style="font-size: 16px;font-weight: 600;color: #333333;"><?php esc_attr_e('Invoice Entry','school-mgt');?></h4>
	<table class="table table-bordered" width="100%" style="">
		<thead style="background-color: #F2F2F2 !important;">
			<tr style="background-color: #F2F2F2 !important;">
				<th class="align_left" style="font-weight: 600;color: #818386 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;">#</th>
				<th class="align_left" style="font-weight: 600;color: #818386 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"> <?php esc_attr_e('Date','school-mgt');?></th>
				<th class="align_left" style="font-weight: 600;color: #818386 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php esc_attr_e('Entry','school-mgt');?> </th>
				<th class="align_left" style="font-weight: 600;color: #818386 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php esc_attr_e('Price','school-mgt');?></th>
				<th class="align_left" style="color: #818386 !important;font-weight: 600;border-bottom-color: #E1E3E5 !important;padding: 15px;"> <?php esc_attr_e('Issue By','school-mgt');?> </th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$id=1;
			$total_amount=0;
			if(!empty($income_data) || !empty($expense_data))
			{
				if(!empty($expense_data))
					$income_data=$expense_data;
						
				$patient_all_income=$obj_invoice->mj_smgt_get_onepatient_income_data($income_data->supplier_name);
				foreach($patient_all_income as $result_income)
				{
					$income_entries=json_decode($result_income->entry);
					foreach($income_entries as $each_entry)
					{
						$total_amount+=$each_entry->amount;
						?>
						<tr>
							<td class="align-center" style="text-align: center !important;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php echo $id;?></td>
							<td class="align-center" style="text-align: center !important;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php echo $result_income->income_create_date;?></td>
							<td class="align-center" style="text-align: center !important;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php echo $each_entry->entry; ?> </td>
							<td class="align-center" style="text-align: center !important;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"> <?php echo "<span>". mj_smgt_get_currency_symbol() ."</span>" .number_format($each_entry->amount,2); ?></td>
							<td class="align-center" style="text-align: center !important;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php echo mj_smgt_get_display_name($result_income->create_by);?></td>
						</tr>
						<?php 
						$id+=1;
					}
				}
						
			}
			if(!empty($invoice_data))
			{
				$total_amount=$invoice_data->amount
				?>
				<tr>
					<td class="align-center" style="text-align: center !important;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php echo $id;?></td>
					<td class="align-center" style="text-align: center !important;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php echo date("Y-m-d", strtotime($invoice_data->date));?></td>
					<td class="align-center" style="text-align: center !important;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php echo $invoice_data->payment_title; ?> </td>
					<td class="align-center" style="text-align: center !important;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"> <?php echo "<span> ". mj_smgt_get_currency_symbol() ."</span>" .number_format($invoice_data->amount,2); ?></td>
					<td class="align-center" style="text-align: center !important;border-bottom: 1px solid #E1E3E5 !important;font-weight: 600;color: #333333 !important;border-bottom-color: #E1E3E5 !important;padding: 15px;"><?php echo mj_smgt_get_display_name($invoice_data->payment_reciever_id);?></td>
				</tr>
				<?php 
			} ?>
		</tbody>
	</table>
	<table>
		<tbody>
			<tr>
				<td width="62%"></td>
				<td>
					<table style="background-color: #5840bb;color: #fff;">
						<tbody>
							<tr>
								<?php 
								if(!empty($invoice_data))
								{								
									$grand_total= $invoice_data->amount;
								}
								if(!empty($income_data))
								{
									$grand_total=$total_amount;
								}
								?>
								<td  style="background-color: #5840bb;color: #fff;padding:10px">
									<h3>
										<?php esc_html_e('Grand Total','school-mgt');?>
									</h3>
								</td>
								<td  style="background-color: #5840bb;color: #fff;padding:10px">
									<h3><?php echo "<span>".mj_smgt_get_currency_symbol()."</span> ".number_format($grand_total,2); ?></h3>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
	<?php 
}

//------ Invoice Print init function  ---------//
function mj_smgt_print_invoice()
{
	if(isset($_REQUEST['print']) && $_REQUEST['print'] == 'print' && $_REQUEST['page'] == 'smgt_payment')
	{
		?>
			<script>window.onload = function(){ window.print(); };</script>
		<?php 
		mj_smgt_student_invoice_print($_REQUEST['invoice_id']);
		exit;
	}	
}
add_action('init','mj_smgt_print_invoice');
//------------  Fees Payment Invoice  -------------//
function mj_smgt_print_fees_invoice()
{
	if(isset($_REQUEST['print']) && $_REQUEST['print'] == 'print' && $_REQUEST['page'] == 'smgt_fees_payment')
	{
		?>
			<script>window.onload = function(){ window.print(); };</script>
		<?php 
		mj_smgt_student_fees_invoice_print($_REQUEST['payment_id']);
		exit;
	}	
}
add_action('init','mj_smgt_print_fees_invoice');

function mj_smgt_install_tables()
{
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	global $wpdb;
	 
	$table_attendence = $wpdb->prefix . 'attendence';//register attendence table
	
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_attendence." (
			  `attendence_id` int(50) NOT NULL AUTO_INCREMENT,
			  `user_id` int(50) NOT NULL,
			  `class_id` int(50) NOT NULL,
			  `attend_by` int(11) NOT NULL,
			  `attendence_date` date NOT NULL,
			  `status` varchar(50) NOT NULL,
			  `role_name` varchar(20) NOT NULL,
			  `comment` text NOT NULL,
			  PRIMARY KEY (`attendence_id`)
			) DEFAULT CHARSET=utf8";
		dbDelta($sql);
		
		
		$table_exam = $wpdb->prefix . 'exam';//register exam table
		
	  $sql = "CREATE TABLE IF NOT EXISTS ".$table_exam." (
		  `exam_id` int(11) NOT NULL AUTO_INCREMENT,
		  `exam_name` varchar(200) NOT NULL,
		  `exam_start_date` date NOT NULL,
		  `exam_end_date` date NOT NULL,
		  `exam_comment` text NOT NULL,
		  `created_date` datetime NOT NULL,
		  `modified_date` datetime NOT NULL,
		  `exam_creater_id` int(11) NOT NULL,
		  PRIMARY KEY (`exam_id`)
		)DEFAULT CHARSET=utf8";
	dbDelta($sql);
		
		$table_grade = $wpdb->prefix . 'grade';//register grade table
		
	  $sql = "CREATE TABLE IF NOT EXISTS ".$table_grade." (
			  `grade_id` int(11) NOT NULL AUTO_INCREMENT,
			  `grade_name` varchar(20) NOT NULL,
			  `grade_point` float NOT NULL,
			  `mark_from` tinyint(3) NOT NULL,
			  `mark_upto` tinyint(3) NOT NULL,
			  `grade_comment` text NOT NULL,
			  `created_date` datetime NOT NULL,
			  `creater_id` int(11) NOT NULL,
			  PRIMARY KEY (`grade_id`)
			)DEFAULT CHARSET=utf8";
	dbDelta($sql);
	
	$table_event = $wpdb->prefix . 'event';//register grade table
		
	  $sql = "CREATE TABLE IF NOT EXISTS ".$table_event." (
				`event_id` int(11) NOT NULL AUTO_INCREMENT,
				`event_title` varchar(100) NOT NULL,
				`description` text NOT NULL,
				`start_date` date NOT NULL,
				`start_time` varchar(100) NOT NULL,
				`end_date` date NOT NULL,
				`end_time` varchar(100) NOT NULL,
				`event_doc` varchar(255) NOT NULL,
				`created_by` int(11) NOT NULL,
				`created_date` date NOT NULL,	
				PRIMARY KEY (`event_id`)
			)DEFAULT CHARSET=utf8";
	dbDelta($sql);
	
	 $table_hall = $wpdb->prefix . 'hall';//register hall table
		
	  $sql = "CREATE TABLE IF NOT EXISTS ".$table_hall." (
			  `hall_id` int(11) NOT NULL AUTO_INCREMENT,
			  `hall_name` varchar(200) NOT NULL,
			  `number_of_hall` int(11) NOT NULL,
			  `hall_capacity` int(11) NOT NULL,
			  `description` text NOT NULL,
			  `date` datetime NOT NULL,
			  PRIMARY KEY (`hall_id`)
			)DEFAULT CHARSET=utf8";
				dbDelta($sql);
				
	$table_holiday = $wpdb->prefix . 'holiday';//register holiday table
	  $sql = "CREATE TABLE IF NOT EXISTS ".$table_holiday." (
			  `holiday_id` int(11) NOT NULL AUTO_INCREMENT,
			  `holiday_title` varchar(200) NOT NULL,
			  `description` text NOT NULL,
			  `date` date NOT NULL,
			  `end_date` date NOT NULL,
			  `created_by` int(11) NOT NULL,
			  PRIMARY KEY (`holiday_id`)
			) DEFAULT CHARSET=utf8 ";
		dbDelta($sql);	
			
		$table_marks = $wpdb->prefix . 'marks';//register marks table
		
	  $sql = "CREATE TABLE IF NOT EXISTS ".$table_marks." (
			  `mark_id` bigint(20) NOT NULL AUTO_INCREMENT,
			  `exam_id` int(11) NOT NULL,
			  `class_id` int(11) NOT NULL,
			  `subject_id` int(11) NOT NULL,
			  `marks` tinyint(3) NOT NULL,
			  `attendance` tinyint(4) NOT NULL,
			  `grade_id` int(11) NOT NULL,
			  `student_id` int(11) NOT NULL,
			  `marks_comment` text NOT NULL,
			  `created_date` datetime NOT NULL,
			  `modified_date` datetime NOT NULL,
			  `created_by` int(11) NOT NULL,
			  PRIMARY KEY (`mark_id`)
			) DEFAULT CHARSET=utf8 ";
		dbDelta($sql);
	
	$table_smgt_class = $wpdb->prefix . 'smgt_class';//register smgt_class table		
	  $sql = "CREATE TABLE IF NOT EXISTS ".$table_smgt_class." (
			  `class_id` int(11) NOT NULL AUTO_INCREMENT,
			  `class_name` varchar(100) NOT NULL,
			  `class_num_name` varchar(5) NOT NULL,
			  `class_section` varchar(50) NOT NULL,
			  `class_capacity` tinyint(4) NOT NULL,
			  `creater_id` int(11) NOT NULL,
			  `created_date` datetime NOT NULL,
			  `modified_date` datetime NOT NULL,
			  PRIMARY KEY (`class_id`)
			) DEFAULT CHARSET=utf8";
		dbDelta($sql);	
		
	$table_smgt_fees = $wpdb->prefix . 'smgt_fees';//register smgt_class table		
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_smgt_fees." (			  
			  `fees_id` int(11) NOT NULL AUTO_INCREMENT,
			  `fees_title_id` bigint(20) NOT NULL,
			  `class_id` int(11) NOT NULL,
			  `fees_amount` float NOT NULL,
			  `description` text NOT NULL,
			  `created_date` datetime NOT NULL,
			  `created_by` int(11) NOT NULL,
			  PRIMARY KEY (`fees_id`)
			) DEFAULT CHARSET=utf8";
		dbDelta($sql);
			
	$table_smgt_fees_payment = $wpdb->prefix . 'smgt_fees_payment';//register smgt_class table		
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_smgt_fees_payment." (			  
			  `fees_pay_id` int(11) NOT NULL AUTO_INCREMENT,
			  `class_id` int(11) NOT NULL,
			  `student_id` bigint(20) NOT NULL,
			  `fees_id` int(11) NOT NULL,
			  `total_amount` float NOT NULL,
			  `fees_paid_amount` float NOT NULL,
			  `payment_status` tinyint(4) NOT NULL,
			  `description` text NOT NULL,
			  `start_year` varchar(20) NOT NULL,
			  `end_year` varchar(20) NOT NULL,
			  `paid_by_date` date NOT NULL,
			  `created_date` datetime NOT NULL,
			  `created_by` bigint(20) NOT NULL,
			  PRIMARY KEY (`fees_pay_id`)
			) DEFAULT CHARSET=utf8";
		dbDelta($sql);
	
	$table_smgt_fee_payment_history = $wpdb->prefix . 'smgt_fee_payment_history';//register smgt_class table		
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_smgt_fee_payment_history." (			  
			  `payment_history_id` bigint(20) NOT NULL AUTO_INCREMENT,
			  `fees_pay_id` int(11) NOT NULL,
			  `amount` float NOT NULL,
			  `payment_method` varchar(50) NOT NULL,
			  `paid_by_date` date NOT NULL,
			  `created_by` bigint(20) NOT NULL,
			  `trasaction_id` varchar(50) NOT NULL,
			  PRIMARY KEY (`payment_history_id`)
			) DEFAULT CHARSET=utf8";
		dbDelta($sql);
		
	$table_message = $wpdb->prefix . 'smgt_message';//register smgt_message table
	  $sql = "CREATE TABLE IF NOT EXISTS ".$table_message." (
				  `message_id` int(11) NOT NULL AUTO_INCREMENT,
				  `sender` int(11) NOT NULL,
				  `receiver` int(11) NOT NULL,
				  `date` datetime NOT NULL,
				  `subject` varchar(150) NOT NULL,
				  `message_body` text NOT NULL,
				  `status` int(11) NOT NULL,
				  `post_id` int(11) NOT NULL,
				  PRIMARY KEY (`message_id`)
				)DEFAULT CHARSET=utf8";
		dbDelta($sql);	
		
	$table_smgt_payment = $wpdb->prefix . 'smgt_payment';//register smgt_payment table
	  $sql = "CREATE TABLE IF NOT EXISTS ".$table_smgt_payment." (
			  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
			  `student_id` int(11) NOT NULL,
			  `class_id` int(11) NOT NULL,
			  `payment_title` varchar(100) NOT NULL,
			  `description` text NOT NULL,
			  `amount` int(11) NOT NULL,
			  `payment_status` varchar(10) NOT NULL,
			  `date` datetime NOT NULL,
			  `payment_reciever_id` int(11) NOT NULL,
			  PRIMARY KEY (`payment_id`)
			) DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 
			";
		dbDelta($sql);	
		
	$table_smgt_time_table = $wpdb->prefix . 'smgt_time_table';//register smgt_time_table table
	  $sql = "CREATE TABLE IF NOT EXISTS ".$table_smgt_time_table." (
			  `route_id` int(11) NOT NULL AUTO_INCREMENT,
			  `subject_id` int(11) NOT NULL,
			  `teacher_id` int(11) NOT NULL,
			  `class_id` int(11) NOT NULL,
			  `start_time` varchar(10) NOT NULL,
			  `end_time` varchar(10) NOT NULL,
			  `weekday` tinyint(4) NOT NULL,
			  PRIMARY KEY (`route_id`)
			)DEFAULT CHARSET=utf8";
		dbDelta($sql);	
		
		
	$table_subject = $wpdb->prefix . 'subject';//register subject table
	  $sql = "CREATE TABLE IF NOT EXISTS ".$table_subject." (
			  `subid` int(11) unsigned NOT NULL AUTO_INCREMENT,
			  `sub_name` varchar(255) NOT NULL,
			  `teacher_id` int(11) NOT NULL,
			  `class_id` int(11) NOT NULL,
			  `author_name` varchar(255) NOT NULL,
			  `edition` varchar(255) NOT NULL,
			  `syllabus` varchar(255) DEFAULT NULL,
			  `created_by` int(11) NOT NULL,
			  PRIMARY KEY (`subid`)
			)  DEFAULT CHARSET=utf8";
		dbDelta($sql);	
		
	$table_transport = $wpdb->prefix .'transport';//register transport table
	  $sql = "CREATE TABLE IF NOT EXISTS ".$table_transport." (
			  `transport_id` int(11) NOT NULL AUTO_INCREMENT,
			  `route_name` varchar(200) NOT NULL,
			  `number_of_vehicle` int(11) NOT NULL,
			  `vehicle_reg_num` varchar(50) NOT NULL,
			  `smgt_user_avatar` varchar(5000) NOT NULL,
			  `driver_name` varchar(100) NOT NULL,
			  `driver_phone_num` varchar(15) NOT NULL,
			  `driver_address` text NOT NULL,
			  `route_description` text NOT NULL,
			  `route_fare` int(11) NOT NULL,
			  `status` tinyint(4) NOT NULL DEFAULT '1',
			  PRIMARY KEY (`transport_id`)
			) DEFAULT CHARSET=utf8";
		dbDelta($sql);	
		
	$table_assign_transport = $wpdb->prefix .'assign_transport';//register assign transport table
	  $sql = "CREATE TABLE IF NOT EXISTS ".$table_assign_transport." (
			  `assign_transport_id` int(11) NOT NULL AUTO_INCREMENT,
			  `transport_id` int(11) NOT NULL,
			  `route_name` varchar(200) NOT NULL,
			  `route_user` text NOT NULL,
			  `route_fare` int(11) NOT NULL,
			  `created_by` int(11) NOT NULL,	
			  PRIMARY KEY (`assign_transport_id`)
			) DEFAULT CHARSET=utf8";
		dbDelta($sql);	
	$table_smgt_income_expense = $wpdb->prefix .'smgt_income_expense';//register transport table
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_smgt_income_expense." (
			 `income_id` int(11) NOT NULL AUTO_INCREMENT,
			  `invoice_type` varchar(50) NOT NULL,
			  `class_id` int(11) NOT NULL,
			  `supplier_name` varchar(100) NOT NULL,
			  `entry` text NOT NULL,
			  `payment_status` varchar(50) NOT NULL,
			  `create_by` int(11) NOT NULL,	
			  `income_create_date` date NOT NULL,
			  PRIMARY KEY (`income_id`)
			) DEFAULT CHARSET=utf8";
		dbDelta($sql);
	
	$table_smgt_audit_log = $wpdb->prefix .'smgt_audit_log';//register transport table
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_smgt_audit_log." (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`audit_action` text NOT NULL,
			`user_id` int(11) NULL,
			`action` text NOT NULL,
			`ip_address` text NOT NULL,
			`created_by` int(11) NOT NULL,
			`created_at` date NOT NULL,
			`date_time` datetime NOT NULL,
			`deleted_status` boolean NOT NULL,
			`updated_by` 	int(11) NULL,
			`updated_date` datetime NULL,
			PRIMARY KEY (`id`)
	  ) DEFAULT CHARSET=utf8";
	dbDelta($sql);

	$table_smgt_user_log = $wpdb->prefix .'smgt_user_log';//register transport table
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_smgt_user_log." (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`user_login` text NOT NULL,
			`role` text NOT NULL,
			`ip_address` text NOT NULL,
			`created_at` date NOT NULL,
			`date_time` datetime NOT NULL,
			`deleted_status` boolean NOT NULL,
			PRIMARY KEY (`id`)
	  ) DEFAULT CHARSET=utf8";
	dbDelta($sql);
		

	$table_smgt_library_book = $wpdb->prefix . 'smgt_library_book';//register smgt_class table		
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_smgt_library_book." (			  
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `ISBN` varchar(50) NOT NULL,
			  `book_name` varchar(200) CHARACTER SET utf8 NOT NULL,
			  `author_name` varchar(100) CHARACTER SET utf8 NOT NULL,
			  `cat_id` int(11) NOT NULL,
			  `rack_location` int(11) NOT NULL,
			  `price` varchar(10) NOT NULL,
			  `quentity` int(11) NOT NULL,
			  `description` text CHARACTER SET utf8 NOT NULL,
			  `added_by` int(11) NOT NULL,
			  `added_date` varchar(20) NOT NULL,
			  PRIMARY KEY (`id`)
			) DEFAULT CHARSET=utf8";
		dbDelta($sql);
		
	$table_smgt_library_book_issue = $wpdb->prefix . 'smgt_library_book_issue';//register smgt_class table		
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_smgt_library_book_issue." (			  
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `class_id` int(11) NOT NULL,
			  `student_id` int(11) NOT NULL,
			  `cat_id` int(11) NOT NULL,
			  `book_id` int(11) NOT NULL,
			  `issue_date` varchar(20) NOT NULL,
			  `end_date` varchar(20) NOT NULL,
			  `actual_return_date` varchar(20) NOT NULL,
			  `period` int(11) NOT NULL,
			  `fine` varchar(20) NOT NULL,
			  `status` varchar(50) NOT NULL,
			  `issue_by` int(11) NOT NULL,
			  PRIMARY KEY (`id`)
			) DEFAULT CHARSET=utf8";
		dbDelta($sql);
	
	$smgt_sub_attendance = $wpdb->prefix . 'smgt_sub_attendance';//register smgt_class table		
	$sql = "CREATE TABLE IF NOT EXISTS ".$smgt_sub_attendance." (			  
			  `attendance_id` int(11) NOT NULL AUTO_INCREMENT,
			  `user_id` int(11) NOT NULL,
			  `class_id` int(11) NOT NULL,
			  `sub_id` int(11) NOT NULL,
			  `attend_by` int(11) NOT NULL,
			  `attendance_date` date NOT NULL,
			  `status` varchar(50) NOT NULL,
			  `role_name` varchar(50) NOT NULL,
			  `comment` text NOT NULL,
			  PRIMARY KEY (`attendance_id`)
			) DEFAULT CHARSET=utf8";
		dbDelta($sql);
	 
	$mj_smgt_homework = $wpdb->prefix . 'mj_smgt_homework';//homework table
		$sql = "CREATE TABLE IF NOT EXISTS ".$mj_smgt_homework." (
			  `homework_id` int(11) NOT NULL AUTO_INCREMENT,
			  `title` varchar(250) NOT NULL,
			  `class_name` int(11) NOT NULL,
			  `section_id` int(11) NOT NULL,
			  `subject` int(11) NOT NULL,
			  `content` text NOT NULL,
			  `submition_date` date NOT NULL,
			  `createdby` int(11) NOT NULL,
			  `created_date` datetime NOT NULL,
			  PRIMARY KEY (`homework_id`)
			) DEFAULT CHARSET=utf8";
		dbDelta($sql);

	$smgt_document = $wpdb->prefix . 'smgt_document';//document table
		$sql = "CREATE TABLE IF NOT EXISTS ".$smgt_document." (
			  `document_id` int(11) NOT NULL AUTO_INCREMENT,
			  `class_id` varchar(255) NOT NULL,
			  `section_id` varchar(255) NOT NULL,
			  `student_id` varchar(255) NOT NULL,
			  `document_content` varchar(255) NOT NULL,
			  `description` text NOT NULL,
			  `createdby` int(11) NOT NULL,
			  `created_date` datetime NOT NULL,
			  PRIMARY KEY (`document_id`)
			) DEFAULT CHARSET=utf8";	
		dbDelta($sql);

	$mj_smgt_student_homework = $wpdb->prefix . 'mj_smgt_student_homework';//Student Homework table
		$sql = "CREATE TABLE IF NOT EXISTS ".$mj_smgt_student_homework." (
			  `stu_homework_id` int(50) NOT NULL AUTO_INCREMENT,
			  `homework_id` int(11) NOT NULL,
			  `student_id` int(11) NOT NULL,
			  `status` tinyint(4) NOT NULL,
			  `uploaded_date` datetime DEFAULT NULL,
			  `file` text NOT NULL,
			  `created_by` int(11) NOT NULL,
		      `created_date` datetime NOT NULL,
			  PRIMARY KEY (`stu_homework_id`)
			) DEFAULT CHARSET=utf8";
		dbDelta($sql);
		
	
	$smgt_message_replies = $wpdb->prefix . 'smgt_message_replies';//register smgt_class table		
		$sql = "CREATE TABLE IF NOT EXISTS ".$smgt_message_replies." (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `message_id` int(11) NOT NULL,
			  `sender_id` int(11) NOT NULL,
			  `receiver_id` int(11) NOT NULL,
			  `message_comment` text NOT NULL,
			  `message_attachment` text,
			  `status` int(11),
			  `created_date` datetime NOT NULL,
			  PRIMARY KEY (`id`)
			) DEFAULT CHARSET=utf8";
		dbDelta($sql);	
	
	$smgt_class_section = $wpdb->prefix . 'smgt_class_section';//register smgt_class table		
		$sql = "CREATE TABLE IF NOT EXISTS ".$smgt_class_section." (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `class_id` int(11) NOT NULL,
			  `section_name` varchar(255) NOT NULL,
			  PRIMARY KEY (`id`)
			) DEFAULT CHARSET=utf8";
			
		dbDelta($sql);

	$smgt_teacher_sub = $wpdb->prefix . 'teacher_subject';		
		$sql = "CREATE TABLE IF NOT EXISTS ".$smgt_teacher_sub." (
			  `teacher_subject_id` int(11) NOT NULL AUTO_INCREMENT,
			  `teacher_id` bigint(20) NOT NULL,
			  `subject_id` bigint(20) NOT NULL,
			  `created_date` datetime NOT NULL,
			  `created_by` bigint(20) NOT NULL,
			  PRIMARY KEY (`teacher_subject_id`)
			) DEFAULT CHARSET=utf8";
	dbDelta($sql);	
	
	$smgt_notification = $wpdb->prefix . 'smgt_notification';		
		$sql = "CREATE TABLE IF NOT EXISTS ".$smgt_notification." (
			  `notification_id` int(11) NOT NULL AUTO_INCREMENT,
			 `student_id` int(11) NOT NULL,
			 `title` varchar(500) DEFAULT NULL,
			 `message` varchar(5000) DEFAULT NULL,
			 `device_token` varchar(255) DEFAULT NULL,
			 `device_type` tinyint(4) NOT NULL,
			 `bicon` int(11) DEFAULT NULL,
			 `created_date` date DEFAULT NULL,
			 `created_by` int(11) DEFAULT NULL,
			 PRIMARY KEY (`notification_id`)
			) DEFAULT CHARSET=utf8";
	dbDelta($sql);	
	
	$table_smgt_exam_time_table = $wpdb->prefix . 'smgt_exam_time_table';//register smgt_exam_time_table
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_smgt_exam_time_table." (			  
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `class_id` int(11) NOT NULL,
			  `exam_id` int(11) NOT NULL,
			  `subject_id` int(11) NOT NULL,
			  `exam_date` date NOT NULL,
			  `start_time`  text NOT NULL,
			  `end_time`  text NOT NULL,
			  `created_date` date NOT NULL,
			  `created_by`  int(11) NOT NULL,
			  PRIMARY KEY (`id`)
			) DEFAULT CHARSET=utf8";
		dbDelta($sql);
		
	$table_smgt_exam_hall_receipt = $wpdb->prefix . 'smgt_exam_hall_receipt';//register smgt_exam_hall_receipt
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_smgt_exam_hall_receipt." (			  
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `exam_id` int(11) NOT NULL,
			  `user_id` int(11) NOT NULL,
			  `hall_id` int(11) NOT NULL,
			  `exam_hall_receipt_status` int(11) NOT NULL,
			  `created_date` date NOT NULL,
			  `created_by`  int(11) NOT NULL,
			  PRIMARY KEY (`id`)
			) DEFAULT CHARSET=utf8";
		dbDelta($sql);

		
	$smgt_smgt_hostel = $wpdb->prefix . 'smgt_hostel';//register smgt_hostel		
	$sql = "CREATE TABLE IF NOT EXISTS ".$smgt_smgt_hostel." (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `hostel_name` varchar(255) NOT NULL,
			  `hostel_type` varchar(255) NOT NULL,
			  `Description` text NOT NULL,
			  `created_by` bigint(20) NOT NULL,
			  `created_date` datetime NOT NULL,
			  `updated_by` bigint(20) NOT NULL,
			  `updated_date` datetime NOT NULL,
			  PRIMARY KEY (`id`)
			) DEFAULT CHARSET=utf8";
	dbDelta($sql);	
	
	$smgt_smgt_room = $wpdb->prefix . 'smgt_room';//register smgt_room	
	$sql = "CREATE TABLE IF NOT EXISTS ".$smgt_smgt_room." (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `room_unique_id` varchar(20) NOT NULL,
			   `hostel_id` int(11) NOT NULL,
			   `room_status` int(11) NOT NULL,
			  `room_category` int(11) NOT NULL,
			  `beds_capacity` int(11) NOT NULL,
			  `room_description` text NOT NULL,
			  `created_by` bigint(20) NOT NULL,
			  `created_date` datetime NOT NULL,
			  `updated_by` bigint(20) NOT NULL,
			  `updated_date` datetime NOT NULL,
			  PRIMARY KEY (`id`)
			) DEFAULT CHARSET=utf8";
	dbDelta($sql);	
	
	$smgt_smgt_beds = $wpdb->prefix . 'smgt_beds';//register smgt_beds 		
	$sql = "CREATE TABLE IF NOT EXISTS ".$smgt_smgt_beds." (
			   `id` int(11) NOT NULL AUTO_INCREMENT,
			   `bed_unique_id` varchar(20) NOT NULL,
			   `room_id` int(11) NOT NULL,
			   `bed_status` int(11) NOT NULL,
			   `bed_description` text NOT NULL,
			  `created_by` bigint(20) NOT NULL,
			  `created_date` datetime NOT NULL,
			  `updated_by` bigint(20) NOT NULL,
			  `updated_date` datetime NOT NULL,
			  PRIMARY KEY (`id`)
			) DEFAULT CHARSET=utf8";
	dbDelta($sql);	
	
	$smgt_smgt_assign_beds = $wpdb->prefix . 'smgt_assign_beds';//register smgt_beds 		
	$sql = "CREATE TABLE IF NOT EXISTS ".$smgt_smgt_assign_beds." (
			   `id` int(11) NOT NULL AUTO_INCREMENT,
			   `hostel_id` int(11) NOT NULL ,
			   `room_id` int(11) NOT NULL,
			   `bed_id` int(11) NOT NULL,
			   `bed_unique_id` varchar(20) NOT NULL,
			   `student_id` int(11) NOT NULL,
			   `assign_date` datetime NOT NULL,
			   `created_by` bigint(20) NOT NULL,
			   `created_date` datetime NOT NULL,
			  PRIMARY KEY (`id`)
			) DEFAULT CHARSET=utf8";
	dbDelta($sql);	
	
	$table_custom_field = $wpdb->prefix .'custom_field';
			$sql = "CREATE TABLE IF NOT EXISTS ".$table_custom_field." (
				 `id` int(11) NOT NULL AUTO_INCREMENT,				 
				 `form_name` varchar(255),							 
				 `field_type` varchar(100) NOT NULL,			  
				 `field_label` varchar(100) NOT NULL,			  
				 `field_visibility` int(10),
				 `field_validation` varchar(100),	
				 `created_by` 	int(11),
				 `created_at` datetime NOT NULL,
				 `updated_by` 	int(11),
				 `updated_at` datetime NOT NULL,		 
				  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";					
			dbDelta($sql);		
			
		$table_custom_field_dropdown_metas = $wpdb->prefix . 'custom_field_dropdown_metas';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_custom_field_dropdown_metas ." (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `custom_fields_id` int(11) NOT NULL,
				  `option_label` varchar(255) NOT NULL,		
				  `created_by` 	int(11),
				  `created_at` datetime NOT NULL,
				  `updated_by` 	int(11),
				  `updated_at` datetime NOT NULL,
				  PRIMARY KEY (`id`)
				) DEFAULT CHARSET=utf8";	
		dbDelta($sql);	
		
		$table_custom_field_metas = $wpdb->prefix . 'custom_field_metas';
		$sql = "CREATE TABLE IF NOT EXISTS ".$table_custom_field_metas ." (
				  `id` int(11) NOT NULL AUTO_INCREMENT,				 
				  `module` varchar(100) NOT NULL,		
				  `module_record_id` int(11) NOT NULL,		
				  `custom_fields_id` int(11) NOT NULL,		
				  `field_value` text,		
				  `created_at` datetime NOT NULL,				  
				  `updated_at` datetime NOT NULL,
				  PRIMARY KEY (`id`)
				) DEFAULT CHARSET=utf8";	
		dbDelta($sql);

    $smgt_check_status = $wpdb->prefix . 'smgt_check_status';
		$sql = "CREATE TABLE IF NOT EXISTS ".$smgt_check_status ." (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `type` varchar(50) NULL,		
				  `user_id` int(11) NOT NULL,
				  `type_id` int(11) NOT NULL,
				  `status` int(11) NOT NULL,
				  PRIMARY KEY (`id`)
				) DEFAULT CHARSET=utf8";	
		dbDelta($sql);

	$smgt_zoom_meeting = $wpdb->prefix . 'smgt_zoom_meeting';
		$sql = "CREATE TABLE IF NOT EXISTS ".$smgt_zoom_meeting ." (
				  `meeting_id` int(11) NOT NULL AUTO_INCREMENT,
				  `title` varchar(255) NOT NULL,		
				  `route_id` int(11) NOT NULL,
				  `zoom_meeting_id` varchar(50) NOT NULL,
				  `uuid` varchar(100) NOT NULL,
				  `class_id` int(11) NOT NULL,
				  `section_id` int(11) NULL,
				  `subject_id` int(11) NOT NULL,
				  `teacher_id` int(11) NOT NULL,
				  `weekday_id` int(11) NOT NULL,
				  `password` varchar(50) NULL,
				  `agenda` varchar(2000) NULL,
				  `start_date` date NOT NULL,
				  `end_date` date NOT NULL,
				  `meeting_join_link` varchar(1000) NOT NULL,
				  `meeting_start_link` varchar(1000) NOT NULL,
				  `created_by` 	int(11),
				  `created_date` datetime NOT NULL,
				  `updated_by` 	int(11),
				  `updated_date` datetime NULL,
				  PRIMARY KEY (`meeting_id`)
				) DEFAULT CHARSET=utf8";	
		dbDelta($sql);

	$table_smgt_reminder_zoom_meeting_mail_log = $wpdb->prefix . 'smgt_reminder_zoom_meeting_mail_log';
	$sql = "CREATE TABLE IF NOT EXISTS ".$table_smgt_reminder_zoom_meeting_mail_log." (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `user_id` int(11) NOT NULL,
			  `meeting_id` int(11) NOT NULL,
			  `class_id` varchar(20) NOT NULL,
			  `alert_date` date NOT NULL,
			  PRIMARY KEY (`id`)
			)DEFAULT CHARSET=utf8";
			
	$wpdb->query($sql);			
		
	/* global $wpdb;
    $section_row = $wpdb->get_results("SELECT *from $smgt_class_section");
	
    if(empty($section_row))
    {
		
		$tablename="smgt_class";
		$retrieve_class = mj_smgt_get_all_data($tablename);
		foreach ($retrieve_class as $retrieved_data)
		{ 
			if($retrieved_data->class_section != "")
			{ 
				$tablename_section="smgt_class_section";
				$sectiondata['class_id']=$retrieved_data->class_id;
				$sectiondata['section_name']=$retrieved_data->class_section;
				$result=mj_smgt_add_class_section($tablename_section,$sectiondata);
				$studentdata = get_users(array('meta_key' => 'class_name', 'meta_value' => $retrieved_data->class_id,'role'=>'student'));
				if(!empty($studentdata))
				{
					foreach($studentdata as $student)
					{
						add_user_meta( $student->ID, "class_section",$retrieved_data->class_section);
					}
				}
			 } 
			
		}
    } */	
	
	$smgt_teacher_class = $wpdb->prefix . 'smgt_teacher_class';//register smgt_class table		
	$sql = "CREATE TABLE IF NOT EXISTS ".$smgt_teacher_class." (
			  `id` bigint(20) NOT NULL AUTO_INCREMENT,
			  `teacher_id` bigint(20) NOT NULL,
			  `class_id` int(11) NOT NULL,
			  `created_by` bigint(20) NOT NULL,
			  `created_date` datetime NOT NULL,
			  PRIMARY KEY (`id`)
			) DEFAULT CHARSET=utf8";
	dbDelta($sql);	

	//----  create Leave tables ----//

	$smgt_leave = $wpdb->prefix . 'smgt_leave';

	$sql = "CREATE TABLE IF NOT EXISTS ".$smgt_leave." (				  

	 `id` int(11) NOT NULL AUTO_INCREMENT,
	  `student_id` int(11) NOT NULL,
	  `leave_type` int(11) NOT NULL,
	  `leave_duration` varchar(50) NOT NULL,
	  `start_date` varchar(50) NOT NULL,
	  `end_date` varchar(50) NOT NULL,
	  `reason` text NOT NULL,
	  `status` varchar(50) NOT NULL,
	  `created_by` int(11) NOT NULL,
	  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	  PRIMARY KEY (`id`)
	  ) DEFAULT CHARSET=utf8";	
	dbDelta($sql);	
	MJ_smgt_add_defult_admission_fees_type();
	MJ_smgt_add_defult_registration_fees_type();
	//---- End Leave tables -----//
	
    $teacher_class = $wpdb->get_results("SELECT *from $smgt_teacher_class");	
	if(empty($teacher_class))
	{
		$teacherlist = get_users(array('role'=>'teacher'));		
		if(!empty($teacherlist))
		{
			foreach($teacherlist as $retrieve_data)
			{
				
				$created_by = get_current_user_id();
				$created_date = date('Y-m-d H:i:s');
				$class_id = get_user_meta($retrieve_data->ID,'class_name',true);				
				$success = $wpdb->insert($smgt_teacher_class,array('teacher_id'=>$retrieve_data->ID,
					'class_id'=>$class_id,
					'created_by'=>$created_by,
					'created_date'=>$created_date));
			}
		}		
	}
	
	/* $table_transport = $wpdb->prefix .'transport';//register transport table
	  $sql = "CREATE TABLE IF NOT EXISTS ".$table_transport." (
			  `transport_id` int(11) NOT NULL AUTO_INCREMENT,
			  `route_name` varchar(200) NOT NULL,
			  `number_of_vehicle` int(11) NOT NULL, */
			  
	/* Update transport*/
	$table_transport = $wpdb->prefix . 'transport';//register marks table	
	$wpdb->query(
	"ALTER  TABLE $table_transport MODIFY number_of_vehicle int(11) NOT NULL");
	
	
	$table_hall = $wpdb->prefix . 'hall';		
	$creted_by_hall =  'created_by';
	if (!in_array($creted_by_hall, $wpdb->get_col( "DESC " . $table_hall, 0 ) ))
	{  $result= $wpdb->query(
			"ALTER     TABLE $table_hall  ADD   $creted_by_hall int(11) NOT NULL");
			
	}	
	/* Update Makrs*/
	$table_marks = $wpdb->prefix . 'marks';//register marks table	
	$wpdb->query(
	"ALTER  TABLE $table_marks MODIFY marks  float");
	
	/* Update Makrs*/
	$table_marks = $wpdb->prefix . 'marks';//register marks table	
	$wpdb->query(
	"ALTER  TABLE $table_marks MODIFY grade_id int(11) NULL");

	$table_smgt_holiday = $wpdb->prefix . 'holiday';		
	$created_date_holiday =  'created_date';
	if (!in_array($created_date_holiday, $wpdb->get_col( "DESC " . $table_smgt_holiday, 0 ) ))
	{ 
		$result= $wpdb->query("ALTER TABLE $table_smgt_holiday  ADD   $created_date_holiday  datetime NULL");
	}
	//------------- alter query for holiday status --------------//
	$table_smgt_holiday_status = $wpdb->prefix . 'holiday';	
	$status_holiday =  'status';
	if (!in_array($status_holiday, $wpdb->get_col( "DESC " . $table_smgt_holiday_status, 0 ) ))
	{ 
		$result= $wpdb->query("ALTER TABLE $table_smgt_holiday_status  ADD   $status_holiday  int(11) NOT NULL" , 0);
	}
	$table_smgt_transport = $wpdb->prefix . 'transport';		
	$creted_by =  'created_by';
	if (!in_array($creted_by, $wpdb->get_col( "DESC " . $table_smgt_transport, 0 ) )){  $result= $wpdb->query(
			"ALTER     TABLE $table_smgt_transport  ADD   $creted_by   text");}	
	$comment_field =  'comment';
	if (!in_array($comment_field, $wpdb->get_col( "DESC " . $smgt_sub_attendance, 0 ) )){  $result= $wpdb->query(
			"ALTER     TABLE $smgt_sub_attendance  ADD   $comment_field   text");}	
	$table_attendance = $wpdb->prefix . 'attendence';
	if (!in_array($comment_field, $wpdb->get_col( "DESC " . $table_attendance, 0 ) )){  $result= $wpdb->query(
			"ALTER     TABLE $table_attendance  ADD   $comment_field   text");}	
	$new_field='post_id';
	$table_smgt_message = $wpdb->prefix . 'smgt_message';	
	if (!in_array($new_field, $wpdb->get_col( "DESC " . $table_smgt_message, 0 ) )){  $result= $wpdb->query(
			"ALTER     TABLE $table_smgt_message  ADD   $new_field   int(11)");}

	$section_id='section_id';
	$created_by='created_by';
	$table_subject = $wpdb->prefix . 'subject';	
	if (!in_array($section_id, $wpdb->get_col( "DESC " . $table_subject, 0 ) )){  $result= $wpdb->query(
			"ALTER     TABLE $table_subject  ADD   $section_id   int(11) NOT NULL");}	

	$table_smgt_fees = $wpdb->prefix . 'smgt_fees';	
	if (!in_array($section_id, $wpdb->get_col( "DESC " . $table_smgt_fees, 0 ) )){  $result= $wpdb->query(
			"ALTER     TABLE $table_smgt_fees  ADD   $section_id   int(11) NOT NULL");}	

	$table_smgt_fees_payment = $wpdb->prefix . 'smgt_fees_payment';	
	if (!in_array($section_id, $wpdb->get_col( "DESC " . $table_smgt_fees_payment, 0 ) )){  $result= $wpdb->query(
			"ALTER     TABLE $table_smgt_fees_payment  ADD   $section_id   int(11) NOT NULL");}		

	$table_smgt_fees_payment = $wpdb->prefix . 'smgt_fees_payment';
	$fees_id='fees_id';
	$result= $wpdb->query("ALTER TABLE $table_smgt_fees_payment MODIFY COLUMN $fees_id varchar(255)");

   $table_smgt_income_expense = $wpdb->prefix . 'smgt_income_expense';	
	if (!in_array($section_id, $wpdb->get_col( "DESC " . $table_smgt_income_expense, 0 ) )){  $result= $wpdb->query(
			"ALTER     TABLE $table_smgt_income_expense  ADD   $section_id   int(11) NOT NULL");}
		
	$table_smgt_library_book_issue = $wpdb->prefix . 'smgt_library_book_issue';	
	if (!in_array($section_id, $wpdb->get_col( "DESC " . $table_smgt_library_book_issue, 0 ) ))
	{  
		$result= $wpdb->query("ALTER     TABLE $table_smgt_library_book_issue  ADD   $section_id   int(11) NOT NULL");
	}
	

	$table_smgt_payment = $wpdb->prefix . 'smgt_payment';	
	if (!in_array($section_id, $wpdb->get_col( "DESC " . $table_smgt_payment, 0 ) )){  $result= $wpdb->query(
			"ALTER     TABLE $table_smgt_payment  ADD   $section_id   int(11) NOT NULL");}	
	$table_smgt_payment = $wpdb->prefix . 'smgt_payment';	
	if (!in_array($created_by, $wpdb->get_col( "DESC " . $table_smgt_payment, 0 ) )){  $result= $wpdb->query(
			"ALTER     TABLE $table_smgt_payment  ADD   $created_by   int(11) NOT NULL");}	
			
	if (!in_array($created_by, $wpdb->get_col( "DESC " . $table_smgt_payment, 0 ) )){  $result= $wpdb->query(
			"ALTER     TABLE $table_smgt_payment  ADD   $created_by   int(11) NOT NULL");}	
			
	$section_name="section_name";
	$table_smgt_time_table = $wpdb->prefix . 'smgt_time_table';	
	if (!in_array($section_name, $wpdb->get_col( "DESC " . $table_smgt_time_table, 0 ) ))
	{ 
		$result= $wpdb->query("ALTER TABLE $table_smgt_time_table  ADD   $section_name   int(11) NOT NULL");
	}	

	$table_marks = $wpdb->prefix . 'marks';	
	if (!in_array($section_id, $wpdb->get_col( "DESC " . $table_marks, 0 ) )){  $result= $wpdb->query(
			"ALTER     TABLE $table_marks  ADD   $section_id   int(11) NOT NULL");}				
	
	$table_smgt_class = $wpdb->prefix . 'smgt_class';//register smgt_class table	
	$wpdb->query(
			"ALTER  TABLE $table_smgt_class  MODIFY   class_capacity  int");
	

		mj_smgt_transfer_sectionid();
		
	$exam_start_date="exam_start_date";
	$exam_end_date="exam_end_date";
	$class_id="class_id";
	$section_id1="section_id";
	$exam_term="exam_term";
	$passing_mark="passing_mark";
	$total_mark="total_mark";
	$exam_syllabus="exam_syllabus";
	$table_smgt_exam = $wpdb->prefix . 'exam';	
	if (!in_array($class_id, $wpdb->get_col( "DESC " . $table_smgt_exam, 0 ) ))
	{ 
		$result= $wpdb->query("ALTER TABLE $table_smgt_exam  ADD   $class_id  int(11) NOT NULL AFTER exam_name");
	}
	if (!in_array($section_id1, $wpdb->get_col( "DESC " . $table_smgt_exam, 0 ) ))
	{ 
		$result= $wpdb->query("ALTER TABLE $table_smgt_exam  ADD   $section_id1  int(11) NOT NULL AFTER class_id");
	}
	if (!in_array($exam_term, $wpdb->get_col( "DESC " . $table_smgt_exam, 0 ) ))
	{ 
		$result= $wpdb->query("ALTER TABLE $table_smgt_exam  ADD   $exam_term  int(11) NOT NULL AFTER section_id");
	}
	if (!in_array($passing_mark, $wpdb->get_col( "DESC " . $table_smgt_exam, 0 ) ))
	{ 
		$result= $wpdb->query("ALTER TABLE $table_smgt_exam  ADD   $passing_mark  tinyint(3) NOT NULL AFTER exam_term");
	}
	if (!in_array($total_mark, $wpdb->get_col( "DESC " . $table_smgt_exam, 0 ) ))
	{ 
		$result= $wpdb->query("ALTER TABLE $table_smgt_exam  ADD   $total_mark  tinyint(3) NOT NULL AFTER passing_mark");
	}
	if (!in_array($exam_start_date, $wpdb->get_col( "DESC " . $table_smgt_exam, 0 ) ))
	{ 
		$result= $wpdb->query("ALTER TABLE $table_smgt_exam  ADD   $exam_start_date  date NOT NULL");
	}
	
	if (!in_array($exam_end_date, $wpdb->get_col( "DESC " . $table_smgt_exam, 0 ) ))
	{ 
		$result= $wpdb->query("ALTER TABLE $table_smgt_exam  ADD   $exam_end_date  date NOT NULL");
	}
	if (!in_array($exam_syllabus, $wpdb->get_col( "DESC " . $table_smgt_exam, 0 ) ))
	{ 
		$result= $wpdb->query("ALTER TABLE $table_smgt_exam  ADD   $exam_syllabus  varchar(255) DEFAULT NULL AFTER exam_end_date");
	}
	$homework_document='homework_document';
	$mj_smgt_homework = $wpdb->prefix . 'mj_smgt_homework';
	if (!in_array($homework_document, $wpdb->get_col( "DESC " . $mj_smgt_homework, 0 ) ))
	{ 
		$result= $wpdb->query("ALTER TABLE $mj_smgt_homework  ADD   $homework_document  varchar(255) DEFAULT NULL AFTER content");
	}
	$subject_code='subject_code';
	$table_subject = $wpdb->prefix . 'subject';	
	if (!in_array($subject_code, $wpdb->get_col( "DESC " . $table_subject, 0 ) )){  $result= $wpdb->query(
			"ALTER     TABLE $table_subject  ADD   $subject_code   varchar(255)  DEFAULT NULL");}		
	$smgt_message_replies = $wpdb->prefix . 'smgt_message_replies';
	$message_attachment='message_attachment';
	$status_reply='status';
	if (!in_array($message_attachment, $wpdb->get_col( "DESC " . $smgt_message_replies, 0 ) ))
	{ 
		$result= $wpdb->query("ALTER TABLE $smgt_message_replies  ADD $message_attachment  text");
	}
	if (!in_array($status_reply, $wpdb->get_col( "DESC " . $smgt_message_replies, 0 ) ))
	{ 
		$result= $wpdb->query("ALTER TABLE $smgt_message_replies ADD $status_reply int(11)");
	}

	$hostel_address='hostel_address';
	$hostel_intake='hostel_intake';
	$table_hostel = $wpdb->prefix . 'smgt_hostel';
	if (!in_array($hostel_address, $wpdb->get_col( "DESC " . $table_hostel, 0 ) ))
	{ 
		$result= $wpdb->query("ALTER TABLE $table_hostel  ADD   $hostel_address  varchar(255) AFTER hostel_name");
	}
	if (!in_array($hostel_intake, $wpdb->get_col( "DESC " . $table_hostel, 0 ) ))
	{ 
		$result= $wpdb->query("ALTER TABLE $table_hostel  ADD   $hostel_intake  int(11) NOT NULL DEFAULT 0 AFTER hostel_type");
	}

	$bed_charge='bed_charge';
	$table_bed = $wpdb->prefix . 'smgt_beds';
	if (!in_array($bed_charge, $wpdb->get_col( "DESC " . $table_bed, 0 ) ))
	{ 
		$result= $wpdb->query("ALTER TABLE $table_bed  ADD   $bed_charge  int(11) NOT NULL DEFAULT 0 AFTER bed_description");
	}
	$book_number = "book_number";
	$table_library_book = $wpdb->prefix . 'smgt_library_book';
	if (!in_array($book_number, $wpdb->get_col( "DESC " . $table_library_book, 0 ) ))
	{ 
		$result= $wpdb->query("ALTER TABLE $table_library_book  ADD   $book_number  int(11) NOT NULL DEFAULT 0 AFTER book_name");
	}
}

function mj_smgt_transfer_sectionid()
{	
	$allclass=mj_smgt_get_all_data('smgt_class');	
	foreach($allclass as $class)
	{		
		$allsections=mj_smgt_get_class_sections($class->class_id);
		foreach($allsections as $section)
		{		
			     $usersdata = get_users(array('meta_key' => 'class_section', 'meta_value' =>$section->section_name,
				'meta_query'=> array(array('key' => 'class_name','value' => $class->class_id,'compare' => '=')),'role'=>'student'));	
				
				foreach($usersdata as $user)
				{					
					update_user_meta( $user->ID, "class_section", $section->id);
				}
		}
	}
}

function mj_smgt_datepicker_dateformat()
{
	$date_format_array = array(
	'Y-m-d'=>'yy-mm-dd',
	'Y/m/d'=>'yy/mm/dd',
	'd-m-Y'=>'dd-mm-yy',
	'm/d/Y'=>'mm/dd/yy');
	return $date_format_array;
}
function mj_smgt_get_phpdateformat($dateformat_value)
{
	$date_format_array = mj_smgt_datepicker_dateformat();
	$php_format = array_search($dateformat_value, $date_format_array);  
	return  $php_format;	
}

function mj_smgt_getdate_in_input_box($date)
{ 	
	return date(mj_smgt_get_phpdateformat(get_option('smgt_datepicker_format')),strtotime($date));	
}

function mj_smgt_sender_user_list()
{
	$school_obj = new School_Management ( get_current_user_id () );	
	$login_user_role = $school_obj->role;	
	$role = $_REQUEST['send_to'];
	$login_user_role = $school_obj->role;
	
	$class_list = isset($_REQUEST['class_list'])?$_REQUEST['class_list']:'';
	$class_section = isset($_REQUEST['class_section'])?$_REQUEST['class_section']:'';
	
	$query_data['role']=$role;
	$exlude_id = mj_smgt_approve_student_list();
	
	$html_class_section = '';
	$return_results['section'] = '';
	$user_list = array();
	global $wpdb;
	$defaultmsg= esc_attr__( 'Select Class Section' , 'school-mgt');
	$html_class_section =  "<option value=''>".$defaultmsg."</option>";	
	if($class_list != '')
	{
		$retrieve_data=mj_smgt_get_class_sections($class_list);	
		if($retrieve_data)
		foreach($retrieve_data as $section)
		{
			$html_class_section .= "<option value='".$section->id."'>".$section->section_name."</option>";
		}
	}
	if($role == 'student')
	{		
		$query_data['exclude']=$exlude_id;
		if($class_section)
		{
			$query_data['meta_key'] = 'class_section';
			$query_data['meta_value'] = $class_section;
			$query_data['meta_query'] = array(array('key' => 'class_name','value' => $class_list,'compare' => '=') );
			$results = get_users($query_data);
		}
		elseif($class_list != '')
		{
			$query_data['meta_key'] = 'class_name';
			$query_data['meta_value'] = $class_list;
			$results = get_users($query_data);
		}			
		else
		{
			if($login_user_role=="parent")
			{
				$parentdata = get_user_meta(get_current_user_id(),'child',true);				
				foreach($parentdata as $key=>$val)
				{					
					$studentdata[]= get_userdata($val);					
				}
				$results = $studentdata;			
			}
			
			if($login_user_role=="teacher")
			{				
			    $teacher_class_data = mj_smgt_get_all_teacher_data(get_current_user_id());			
				foreach($teacher_class_data as $data_key=>$data_val)
				{
					$course_id[]=$data_val->class_id;						
					$query_data['meta_key'] = 'class_name';
					$query_data['meta_value'] = $course_id;
					$result= get_users($query_data);
				}
				$results =$result;				 
			}			
		}		
	}
	
	if($role == 'teacher')
	{
		if($class_list != '')
		{
			global $wpdb;
			$table_smgt_teacher_class = $wpdb->prefix. 'smgt_teacher_class';	
			$teacher_list = $wpdb->get_results("SELECT * FROM $table_smgt_teacher_class where class_id = $class_list");
			if($teacher_list)
			{
				foreach($teacher_list as $teacher)
				{
					$user_list[] = $teacher->teacher_id;
				}
			}			
		}
		else
		$results = get_users($query_data);
	}
	if($role == 'supportstaff' || $role == 'administrator')
	{		
		$results = get_users($query_data);
	}
	
	if($role == 'parent')
	{			
		if($class_list == '')
		{
			$results = get_users($query_data);
		}
		else
		{
			$query_data['role'] = 'student';
			$query_data['exclude']=$exlude_id;
		if($class_section)
		{
			$query_data['meta_key'] = 'class_section';
			$query_data['meta_value'] = $class_section;
			$query_data['meta_query'] = array(array('key' => 'class_name','value' => $class_list,'compare' => '=')
			);
		}
		elseif($class_list != '')
		{
			$query_data['meta_key'] = 'class_name';
			$query_data['meta_value'] = $class_list;
		}			
			$userdata=get_users($query_data);
			foreach($userdata as $users)
			{
				$parent = get_user_meta($users->ID, 'parent_id', true);
				
				if(!empty($parent))
				{
					foreach($parent as $p)
					{
						$user_list[]=$p;
					}
				}
			}
		}
	}
	if(isset($results))
	{
		foreach($results as $user_datavalue)
		{
			$user_list[] = $user_datavalue->ID;
		}
	}

	$user_data_list = array_unique($user_list);
	
	$return_results['section'] = $html_class_section;
	$return_results['users'] = '';
	$user_string  = '<select name="selected_users[]" id="selected_users" class="form-control" multiple="true">';
	if(!empty($user_data_list))
	foreach($user_data_list as $retrive_data)
	{
		if($retrive_data != get_current_user_id())
		{
			$check_data=mj_smgt_get_user_name_byid($retrive_data);
			if($check_data != '')
			{	
				$user_string .= "<option value='".$retrive_data."'>".mj_smgt_get_user_name_byid($retrive_data)."</option>";
			}
		}
	}
	$user_string .= '</select>';
	$return_results['users'] = $user_string;
	echo json_encode($return_results);
	die();
}

function mj_smgt_string_replacement($arr,$MsgContent)
{
	$data = str_replace(array_keys($arr),array_values($arr),$MsgContent);
	return $data;
}

add_filter( 'wp_mail_from_name', function( $name ) {
	$from = get_option('smgt_school_name');
	$fromemail = get_option('smgt_email');
	return "{$from}";
});

function mj_smgt_send_mail($email,$subject,$message)
{
	$from		= 	get_option('smgt_school_name');
	$fromemail		= 	get_option('smgt_email');
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/plain; charset=iso-8859-1\r\n";
	 
	if(get_option('smgt_mail_notification') == '1')
	{
		wp_mail($email,$subject,$message,$headers);	
	}
}

function mj_smgt_get_user_role($id){	
	$result = get_userdata($id);
	$role = implode(', ', $result->roles);
	return $role;
}
//geting teacher class studet
//get currency symbol
function mj_smgt_get_currency_symbol( $currency = '' ) 
{			
    $currency = get_option('smgt_currency_code');
			switch ( $currency ) {
			case 'AED' :
			$currency_symbol = 'د.إ';
			break;
			case 'AUD' :
			$currency_symbol = '&#36;';
			break;
			case 'CAD' :
			$currency_symbol = 'C&#36;';
			break;
			case 'CLP' :
			case 'COP' :
			case 'HKD' :
			$currency_symbol = '&#36';
			break;
			case 'MXN' :
			$currency_symbol = '&#36';
			break;
			case 'NZD' :
			$currency_symbol = '&#36;';
			break;
			case 'SGD' :
			case 'USD' :
			$currency_symbol = '&#36;';
			break;
			case 'BDT':
			$currency_symbol = '&#2547;&nbsp;';
			break;
			case 'BGN' :
			$currency_symbol = '&#1083;&#1074;.';
			break;
			case 'BRL' :
			$currency_symbol = '&#82;&#36;';
			break;
			case 'CHF' :
			$currency_symbol = '&#67;&#72;&#70;';
			break;
			case 'CNY' :
			case 'JPY' :
			case 'RMB' :
			$currency_symbol = '&yen;';
			break;
			case 'CZK' :
			$currency_symbol = '&#75;&#269;';
			break;
			case 'KHR' :
			$currency_symbol = '&#6107;';
			break;

			case 'DKK' :
			$currency_symbol = 'kr.';
			break;
			case 'DOP' :
			$currency_symbol = 'RD&#36;';
			break;
			case 'EGP' :
			$currency_symbol = '£';
			break;
			case 'EUR' :
			$currency_symbol = '&euro;';
			break;
			case 'GBP' :
			$currency_symbol = '&pound;';
			break;
			case 'HRK' :
			$currency_symbol = 'Kn';
			break;
			case 'HUF' :
			$currency_symbol = '&#70;&#116;';
			break;
			case 'IDR' :
			$currency_symbol = 'Rp';
			break;
			case 'ILS' :
			$currency_symbol = '&#8362;';
			break;
			case 'INR' :
			$currency_symbol = '₹';
			break;
			case 'PKR' :
			$currency_symbol = '₨';
			break;
			case 'ISK' :
			$currency_symbol = 'Kr.';
			break;
			case 'KIP' :
			$currency_symbol = '&#8365;';
			break;
			case 'KRW' :
			$currency_symbol = '&#8361;';
			break;
			case 'MYR' :
			$currency_symbol = '&#82;&#77;';
			break;
			case 'NGN' :
			$currency_symbol = '&#8358;';
			break;
			case 'NOK' :
			$currency_symbol = '&#107;&#114;';
			break;
			case 'NPR' :
			$currency_symbol = 'Rs.';
			break;
			case 'PHP' :
			$currency_symbol = '&#8369;';
			break;
			case 'PLN' :
			$currency_symbol = '&#122;&#322;';
			break;
			case 'PYG' :
			$currency_symbol = '&#8370;';
			break;
			case 'RON' :
			$currency_symbol = 'lei';
			break;
			case 'RUB' :
			$currency_symbol = '&#1088;&#1091;&#1073;.';
			break;
			case 'SEK' :
			$currency_symbol = '&#107;&#114;';
			break;
			case 'THB' :
			$currency_symbol = '&#3647;';
			break;
			case 'TRY' :
			$currency_symbol = '&#8378;';
			break;
			case 'TWD' :
			$currency_symbol = '&#78;&#84;&#36;';
			break;
			case 'UAH' :
			$currency_symbol = '&#8372;';
			break;
			case 'VND' :
			$currency_symbol = '&#8363;';
			break;
			case 'ZAR' :
			$currency_symbol = '&#82;';
			break;
			case 'GHC' :
	        $currency_symbol = '&#8373;';
	        break;
			case 'MZN' :
	        $currency_symbol = '&#77;&#84;';
	        break;
			case 'GMD' :
	        $currency_symbol = 'D';
	        break;
			default :
			$currency_symbol = $currency;
			break;
	}
	return $currency_symbol;

}

function mj_smgt_get_teacher_by_class_id($class_id)
{	
	global $wpdb;
	$tbl_name 	= 	$wpdb->prefix .'smgt_teacher_class';	
	$teachers	=	$wpdb->get_results("SELECT * FROM $tbl_name where class_id=".$class_id);
	foreach($teachers as $key=>$teacher)
	{		
		$teachersdata[] = get_userdata($teacher->teacher_id);		
	}
	return $teachersdata;
}

function mj_smgt_GetHTMLContent($fees_pay_id)
{		
	$schooName 	= 	get_option('smgt_school_name');
	$schooLogo 	= 	get_option('smgt_school_logo');
	$schooAddress	= 	get_option( 'smgt_school_address' );
	$schoolCountry	= 	get_option( 'smgt_contry' );
	$schoolNo 	=  get_option( 'smgt_contact_number' );
			
	$fees_detail_result = mj_smgt_get_single_fees_payment_record($fees_pay_id);	
	$fees_history_detail_result = mj_smgt_get_payment_history_by_feespayid($fees_pay_id);
	
	$student_id=$fees_detail_result->student_id;
		$abc="";
	if($student_id !=0)
	{
		$patient=get_userdata($student_id);												
		$patient->display_name."<br>"; 
		$abc = get_user_meta( $student_id,'address',true ).",".get_user_meta( $student_id,'city',true ).",". get_user_meta( $student_id,'zip_code',true ).",<BR>". get_user_meta( $student_id,'state',true ).",".get_option( 'smgt_contry' ).",".get_user_meta( $student_id,'mobile',true )."<br>";
	}
	
	$content	='';
	$content	.='';
	
	$content='	
	<div style="background-color:aliceblue; padding:20px"; class="modal-body">
		<div class="modal-header">
			<h4 class="modal-title">'.$schooName.'</h4>
		</div>
		<div id="invoice_print" class="print-box"> 
			<table width="100%" border="0">
				<tbody>
					<tr>
						<td width="70%">
							<img style="max-height:80px;" src='.get_option( 'smgt_school_logo' ).'/>
						</td>
						<td align="right" width="24%">
							<h5>'; ?>
							<?php 
							$payment_status = mj_smgt_get_payment_status($fees_detail_result->fees_pay_id);					
							if($payment_status == 'Fully Paid') 
							{
								$PStatus= 'Fully Paid';
							}
							if($payment_status == 'Partially Paid')
							{
								$PStatus =  'Partially Paid';
							}
							if($payment_status == 'Not Paid')
							{
								$PStatus = 'Not Paid';
							}
							
							$issue_date="DD-MM-YYYY";
							$issue_date=$fees_detail_result->paid_by_date;	
							$Due_amount = $fees_detail_result->total_amount - $fees_detail_result->fees_paid_amount; 
							$content .= 'Issue Date: '. mj_smgt_getdate_in_input_box(date("Y-m-d", strtotime($issue_date))).'</h5>';					
							$content .= '<h5>Status : <span class="btn btn-success btn-xs">'. $PStatus .'</span></h5>';	
							$content .= '</td></tr><tbody></table>
							
							<table width="100%" border="0">
								<tbody>
									<tr>
										<td align="left">
											<h4>Payment From</h4>
										</td>
										<td align="right">
											<h4>Bill To</h4>
										</td>
									</tr>
									<tr>
										<td valign="top" align="left">
											'.$schooName.'<br>
											'.$schooAddress.',
											'.$schoolCountry .'<br>
											'.$schoolNo.'<br>		
										</td>
										<td valign="top" align="right">'.$abc.'</td>
								</tr>
							</tbody>
						</table><hr>
						<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center"> Fees Type</th>
									<th>Total</th>					
								</tr>
							</thead>
							<tbody>
								<td>1</td>
								<td>'.mj_smgt_get_fees_term_name($fees_detail_result->fees_id).'</td>
								<td><span>'. mj_smgt_get_currency_symbol() ." </span>" . number_format($fees_detail_result->total_amount,2).'</td>
							</tbody>
						</table>
						
						<table width="100%" border="0">
							<tbody>							
								<tr>
									<td width="80%" align="right">Sub Total :</td>
									<td align="right"><span>'.mj_smgt_get_currency_symbol() ." </span>" .number_format($fees_detail_result->total_amount,2) .'</td>
								</tr>
								<tr>
									<td width="80%" align="right">Payment Made :</td>
									<td align="right"><span>'. mj_smgt_get_currency_symbol() ." </span>" . number_format($fees_detail_result->fees_paid_amount,2) .'</td>
								</tr>
								<tr>
									<td width="80%" align="right">Due Amount  :</td>
									<td align="right"><span>'. mj_smgt_get_currency_symbol() ." </span>" . number_format($Due_amount,2) .'</td>';
								$content .='</tr>				
							</tbody>
						</table></div></div>';
						return $content;
}
//strip tags and slashes
function mj_smgt_strip_tags_and_stripslashes($string)
{
	$new_string=stripslashes(strip_tags($string));
	return $new_string;
}	
//dashboard page access right frontedn side//
function mj_smgt_page_access_rolewise_accessright_dashboard($page)
{
	$school_obj = new School_Management ( get_current_user_id () );	
	$role = $school_obj->role;
	$flage = 0;
	if($role=='student')
	{
		$menu = get_option( 'smgt_access_right_student');
	}
	elseif($role=='parent')
	{
		$menu = get_option( 'smgt_access_right_parent');
	}
	elseif($role=='supportstaff')
	{
		$menu = get_option( 'smgt_access_right_supportstaff');
	}
	elseif($role=='teacher')
	{
		$menu = get_option( 'smgt_access_right_teacher');
	}
	
	foreach ( $menu as $key1=>$value1 ) 
	{									
		foreach ( $value1 as $key=>$value ) 
		{	
			if ($page == $value['page_link'])
			{				
				if($value['view']=='0')
				{			
					$flage=0;
				}
				else
				{
				  $flage=1;
				}
			}
		}
	}	
	return $flage;
}
//user role wise access right array In Filter Data frontend and management user role //
function mj_smgt_get_userrole_wise_filter_access_right_array($page_name)
{
    $role=mj_smgt_get_user_role(get_current_user_id());
	if($role=='student')
	{
		$menu = get_option( 'smgt_access_right_student');
	}
	elseif($role=='parent')
	{
		$menu = get_option( 'smgt_access_right_parent');
	}
	elseif($role=='supportstaff')
	{
		$menu = get_option( 'smgt_access_right_supportstaff');
	}
	elseif($role=='teacher')
	{
		$menu = get_option( 'smgt_access_right_teacher');
	}
	elseif($role=='management')
	{
		$menu = get_option( 'smgt_access_right_management');
	}
	else
	{
		$menu=0;
	}
	if(!empty($menu))
	{
		foreach ($menu as $key1=>$value1 ) 
		{		
			foreach ( $value1 as $key=>$value ) 
			{				
				if ($page_name == $value['page_link'])
				{				
					return $value;
				}
			}
		}	
	}
	
} 
//user role wise access right array frontend //
function mj_smgt_get_userrole_wise_access_right_array()
{
	$school_obj = new School_Management ( get_current_user_id () );	
	$role = $school_obj->role;
	$page = '';
	if(!empty($_REQUEST ['page']))
	{
		$page = $_REQUEST ['page'];
	}
	
	if($role=='student')
	{
		$menu = get_option( 'smgt_access_right_student');
	}
	elseif($role=='parent')
	{
		$menu = get_option( 'smgt_access_right_parent');
	}
	elseif($role=='supportstaff')
	{
		$menu = get_option( 'smgt_access_right_supportstaff');
	}
	elseif($role=='teacher')
	{
		$menu = get_option( 'smgt_access_right_teacher');
	}
	else
	{
		$menu=0;
	}
	if(!empty( $menu))
	{
		foreach ( $menu as $key1=>$value1 ) 
		{									
			foreach ( $value1 as $key=>$value ) 
			{	
				if ($page == $value['page_link'])
				{	
					return $value;
				}
			}
		}	
	}
}
// MANAGEMENT ACCESS FOR DASHBOARD //
function mj_smgt_get_management_access_right_array($page)
{
	$page_route = "schedule";
	$page_exam_hall = "exam_hall";
	$page_homework = "homework";
	$fees_payment = 'feepayment';
	if($page == "smgt_route")
	{
		$page_name == $page_route;
	}
	elseif($page == "smgt_hall")
	{
		$page_name == $page_exam_hall;
	}
	elseif($page == "smgt_student_homewrok")
	{
		$page_name == $page_homework;
	}
	elseif($page == "smgt_fees_payment")
	{
		$page_name == $fees_payment;
	}
	else
	{
		$page_name = strtolower(str_replace("smgt_","",$page));
	}

	$role=mj_smgt_get_user_role(get_current_user_id());
	if($role=='management')
	{
		$menu = get_option( 'smgt_access_right_management');
	}
	if(!empty($menu))
	{
		foreach ( $menu as $key1=>$value1 ) 
		{									
			foreach ( $value1 as $key=>$value ) 
			{	
				if ($page_name == $value['page_link'])
				{	
					return $value;
				}
			}
		}	
	}
}
//user role wise access right array by fix page admin side //
function mj_smgt_get_userrole_wise_access_right_array_by_page($page)
{
	$flage='';
	$page_name = str_replace("smgt_","",$page);
	$role=mj_smgt_get_user_role(get_current_user_id());
	if($role=='management')
	{
		$menu = get_option( 'smgt_access_right_management');
	}
	foreach ( $menu as $key1=>$value1 ) 
	{

         		
		foreach ( $value1 as $key=>$value ) 
		{	
			if ($page_name == $value['page_link'])
			{	
				if($value['view']=='0')
				{			
					$flage=0;
				}
				else
				{
				  $flage=1;
				}
			}
			
		}
	}	
	return $flage;
}
// CHANGE PROFILE PHOTO IN USER DASHBOARD //
function mj_smgt_change_profile_photo()
{
	?>

	<div class="modal-header mb-4"> <a href="#" class="close-btn-cat badge badge-danger pull-right"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>
		<h4 class="modal-title update_profile_title"><?php esc_attr_e('Update Profile Picture','school-mgt');?></h4>
	</div>
	<form class="form-horizontal" action="#" method="post" enctype="multipart/form-data">
		<div class="form-body user_form"> <!--form Body div-->   
			<div class="row"><!--Row Div--> 
				<div class="col-md-8">	
					<div class="form-group input">
						<div class="col-md-12 form-control image_upload_popup_account res_rtl_height_50px">	
							<label for="inputEmail" class="label_margin_left_10px custom-control-label custom-top-label ml-2 margin_left_30px"><?php esc_attr_e('Select Profile Picture','school-mgt');?></label>
							<div class="col-sm-12">
								<input id="input-1" name="profile" type="file" onchange="mj_smgt_fileCheck(this);"  class="line_height_26px file profile_file d-inline">
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-sm-4">    
					<button type="submit" class="btn btn-success save_upload_profile_btn save_btn" name="save_profile_pic"><?php esc_attr_e('Save','school-mgt');?></button>
				</div>
			</div>
		</div>
	</form>
    <?php 
	die();
}
function mj_smgt_password_validation($post_string)
{
	$string = str_replace('&nbsp;', ' ', $post_string);
    $string = html_entity_decode($string, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
    $string = html_entity_decode($string, ENT_HTML5, 'UTF-8');
    $string = html_entity_decode($string);
    $string = htmlspecialchars_decode($string);
    $replase_string = strip_tags($string);
	return $replase_string;
}

//REMOVE HTML ENTITY STRING FUNCTION 

function mj_smgt_email_validation($post_string)
{
	$string = str_replace('&nbsp;', ' ', $post_string);
    $string = html_entity_decode($string, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
    $string = html_entity_decode($string, ENT_HTML5, 'UTF-8');
    $string = html_entity_decode($string);
    $string = htmlspecialchars_decode($string);
    $replase_string = strip_tags($string);
	return $replase_string;
}
//REMOVE HTML ENTITY STRING FUNCTION //
 //1)roll_id 2)address_description
function mj_smgt_address_description_validation($post_string)
{
	$string = str_replace('&nbsp;', ' ', $post_string);
    $string = html_entity_decode($string, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
    $string = html_entity_decode($string, ENT_HTML5, 'UTF-8');
    $string = html_entity_decode($string);
    $string = htmlspecialchars_decode($string);
    $replase_string = strip_tags($string);
	return $replase_string;
}

function mj_smgt_phone_number_validation($post_string)
{
	$string = str_replace('&nbsp;', ' ', $post_string);
    $string = html_entity_decode($string, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
    $string = html_entity_decode($string, ENT_HTML5, 'UTF-8');
    $string = html_entity_decode($string);
    $string = htmlspecialchars_decode($string);
    $replase_string = strip_tags($string);
	return $replase_string;
}

function mj_smgt_username_validation($post_string)
{
	$string = str_replace('&nbsp;', ' ', $post_string);
    $string = html_entity_decode($string, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
    $string = html_entity_decode($string, ENT_HTML5, 'UTF-8');
    $string = html_entity_decode($string);
    $string = htmlspecialchars_decode($string);
    $replase_string = strip_tags($string);
	return $replase_string;
}


function mj_smgt_popup_category_validation($post_string)
{
	$string = str_replace('&nbsp;', ' ', $post_string);
    $string = html_entity_decode($string, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
    $string = html_entity_decode($string, ENT_HTML5, 'UTF-8');
    $string = html_entity_decode($string);
    $string = htmlspecialchars_decode($string);
    $replase_string = strip_tags($string);
	return $replase_string;
}
function mj_smgt_city_state_country_validation($post_string)
{
	$string = str_replace('&nbsp;', ' ', $post_string);
    $string = html_entity_decode($string, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
    $string = html_entity_decode($string, ENT_HTML5, 'UTF-8');
    $string = html_entity_decode($string);
    $string = htmlspecialchars_decode($string);
    $replase_string = strip_tags($string);
	return $replase_string;
}

function mj_smgt_onlyLetter_specialcharacter_validation($post_string)
{
	$string = str_replace('&nbsp;', ' ', $post_string);
    $string = html_entity_decode($string, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
    $string = html_entity_decode($string, ENT_HTML5, 'UTF-8');
    $string = html_entity_decode($string);
    $string = htmlspecialchars_decode($string);
    $replase_string = strip_tags($string);
	return $replase_string;
}

function mj_smgt_onlyLetterNumber_validation($post_string)
{
	$string = str_replace('&nbsp;', ' ', $post_string);
    $string = html_entity_decode($string, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
    $string = html_entity_decode($string, ENT_HTML5, 'UTF-8');
    $string = html_entity_decode($string);
    $string = htmlspecialchars_decode($string);
    $replase_string = strip_tags($string);
	return $replase_string;
}
function mj_smgt_onlyLetterSp_validation($post_string)
{
	$string = str_replace('&nbsp;', ' ', $post_string);
    $string = html_entity_decode($string, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
    $string = html_entity_decode($string, ENT_HTML5, 'UTF-8');
    $string = html_entity_decode($string);
    $string = htmlspecialchars_decode($string);
    $replase_string = strip_tags($string);
	return $replase_string;
}

function mj_smgt_onlyNumberSp_validation($post_string)
{
	$string = str_replace('&nbsp;', ' ', $post_string);
    $string = html_entity_decode($string, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
    $string = html_entity_decode($string, ENT_HTML5, 'UTF-8');
    $string = html_entity_decode($string);
    $string = htmlspecialchars_decode($string);
    $replase_string = strip_tags($string);
	return $replase_string;
}
function mj_smgt_count_student_in_class()
{
	global $wpdb;
	$table_name = $wpdb->prefix .'smgt_class';
	$class_id=$_POST['class_id'];
	$student_list =count( get_users(array('meta_key' => 'class_name', 'meta_value' => $class_id, 'role'=>'student')));
	$class_capacity_data =$wpdb->get_row("SELECT class_capacity FROM $table_name WHERE class_id=".$class_id);
	$class_capacity=intval($class_capacity_data->class_capacity);
	
	$class_data=array();
	
	if($class_capacity > $student_list)
	{
		echo "class_empt";
		
		$class_data[0]='class_empt';
	}
	else
	{
		
		$class_data[0]='class_full';
		$class_data[1]=$class_capacity;
		$class_data[2]=$student_list;
	}
	echo json_encode($class_data);
	die;
}

function mj_smgt_convert_date_time($date_time)
{
	$format = get_option( 'smgt_datepicker_format' );
	
	if($format == 'yy-mm-dd')
	{
		$change_formate='Y-m-d';
	}
	elseif($format == 'yy/mm/dd')
	{
		$change_formate='Y/m/d';
		
	}
	elseif($format == 'dd-mm-yy')
	{
		$change_formate='d-m-Y';
		
	}
	elseif($format == 'mm/dd/yy')
	{
		$change_formate='m/d/Y';
	}
	else
	{
		$change_formate='Y-m-d';
	}
	$timestamp = strtotime( $date_time ); // Converting time to Unix timestamp
	$offset = get_option( 'gmt_offset' ) * 60 * 60; // Time offset in seconds
	$local_timestamp = $timestamp + $offset;
	$local_time = date_i18n($change_formate .' H:i:s', $local_timestamp );
	// var_dump($local_time);
	// die;
	return $local_time;
}
//show event and task model code
function mj_smgt_show_event_task()
{	
	$id = $_REQUEST['id'];	
	 
	$model = $_REQUEST['model'];
	 
	if($model=='Notification Details')
	{
		$notification=new Smgt_dashboard;
		$notification_data=$notification->mj_smgt_get_signle_notification_by_id($id);
	}
	if($model=='Noticeboard Details')
	{
		$retrieve_class =get_post($id);
	}
	if($model=='Exam Details')
	{
		$exam_data= mj_smgt_get_exam_by_id($id);
	}
	if($model=='holiday Details')
	{
		$holiday_data= mj_smgt_get_holiday_by_id($id);
	}
	if($model=='Feespayment Details')
	{
		$feespayment_data= mj_smgt_get_feespayment_by_id($id);
	}
	if($model=='Class Details')
	{
		$class_data= mj_smgt_get_class_by_id($id);
	}
	if($model=='Message Details')
	{
		$message_data= mj_smgt_get_message_by_id($id);
	}
	if($model=='Event Details')
	{
		$obj_event = new event_Manage();  
		$event_data = $obj_event->MJ_smgt_get_single_event($id);
	}
	if($model=='transport Details')
	{
		$transport_data= mj_smgt_get_transport_by_id($id);
	}
	
?>
    <div class="modal-header model_header_padding dashboard_model_header"> 
		<img src="<?php if($model=='transport Details'){ echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Transportation.png"; }if($model=='Event Details'){ echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/notice_1.png"; } if($model=='Notification Details'){ echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/notifications_1.png"; } elseif($model=='Noticeboard Details'){ echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/notice_1.png"; } elseif($model=='Exam Details'){ echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Exam.png"; } elseif($model=='holiday Details'){ echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Holiday.png"; }elseif($model=='Feespayment Details'){ echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Fees_Payment.png"; }elseif($model=='Class Details'){ echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Class.png"; }elseif($model=='Message Details'){ echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/message_1.png"; } ?>" alt="" class="popup_image_before_name">
		<a href="javascript:void(0);" class="event_close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>
  		<h4 id="myLargeModalLabel" class="modal-title"><?php if($model=='transport Details'){ esc_attr_e('Transport Details','school-mgt'); } if($model=='Event Details'){ esc_attr_e('Event Details','school-mgt'); } if($model=='Notification Details'){ esc_attr_e('Notification Details','school-mgt'); } elseif($model=='Noticeboard Details'){ esc_attr_e('Notice Details','school-mgt'); } elseif($model=='Exam Details'){ esc_attr_e('Exam Details','school-mgt'); } elseif($model=='holiday Details'){ esc_attr_e('Holiday Details','school-mgt'); }elseif($model=='Feespayment Details'){ esc_attr_e('Fees Payment Details','school-mgt'); }elseif($model=='Class Details'){ esc_attr_e('Class Details','school-mgt'); }elseif($model=='Message Details'){ esc_attr_e('Message Details','school-mgt'); } ?></h4>
	</div>
	<div class="panel-white">
	<?php
	if($model=='Notification Details')
	{
		?>
		<div class="modal-body view_details_body_assigned_bed view_details_body">
			<div class="row">
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Student Name','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo mj_smgt_get_user_name_byid($notification_data->student_id); ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Title','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo $notification_data->title; ?></label>
				</div>
				<div class="col-md-12 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Message','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo $notification_data->message; ?></label>
				</div>
			</div>
        </div>  
	 <?php
	
	}
	if($model=='Class Details')
	{
		$class_id=$class_data->class_id;
		$user=count(get_users(array(
			'meta_key' => 'class_name',
			'meta_value' => $class_id
		)));
		
		?>
		<div class="modal-body view_details_body_assigned_bed view_details_body">
			<div class="row">
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Name','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo $class_data->class_name; ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Create Date','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo mj_smgt_getdate_in_input_box($class_data->created_date); ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Numeric Name','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo $class_data->class_num_name; ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Student Capacity','school-mgt'); ?></label><br>
					<label for="" class="label_value">
						<?php
						echo $class_data->class_capacity;
						?>
					</label>
				</div>
			</div>
        </div>  
	 <?php
	
	}
	if($model=='Message Details')
	{
		$message_for=get_post_meta($message_data->post_id,'message_for',true);
		$attchment=get_post_meta( $message_data->post_id, 'message_attachment',true);
		$auth = get_post($message_data->post_id);
		$authid = $auth->post_author;
		
		?>
		<div class="modal-body view_details_body_assigned_bed view_details_body">
			<div class="row">
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Message For','school-mgt'); ?></label><br>
					<label for="" class="label_value">
						<?php 
							$check_message_single_or_multiple=mj_smgt_send_message_check_single_user_or_multiple($message_data->post_id);	
							
							if($check_message_single_or_multiple == 1)
							{	
								global $wpdb;
								$tbl_name = $wpdb->prefix .'smgt_message';
								$post_id=$message_data->post_id;
								$get_single_user = $wpdb->get_row("SELECT * FROM $tbl_name where post_id = $post_id");
								echo mj_smgt_get_display_name($get_single_user->receiver);
							}
							else
							{					
								echo get_post_meta( $message_data->post_id, 'message_for',true);
							}
						?>
					</label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Message From','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo mj_smgt_get_display_name($authid); ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Subject','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php  echo $message_data->subject; ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Attachment','school-mgt'); ?></label><br>
					<label for="" class="label_value">
						<?php 
							if(!empty($attchment))
							{	
								$attchment_array=explode(',',$attchment);
								foreach($attchment_array as $attchment_data)
								{
									?>
									<a target="blank" href="<?php echo content_url().'/uploads/school_assets/'.$attchment_data; ?>" class="btn btn-default"><i class="fa fa-download"></i><?php esc_attr_e('View Attachment','school-mgt');?></a>
									<?php				
								}
							}
							else
							{
								esc_attr_e('No Attachment','school-mgt');
							} 
						?>
					</label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Message Date','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo mj_smgt_getdate_in_input_box($message_data->date); ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Description','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo $message_data->message_body; ?></label>
				</div>
			</div>
        </div>  
	 <?php
	
	}
	if($model=='Feespayment Details')
	{
		
		?>
		<div class="modal-body view_details_body_assigned_bed view_details_body">
			<div class="row">
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Class Name','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo mj_smgt_get_class_name($feespayment_data->class_id); ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Student Name','school-mgt'); ?></label><br>
					<label for="" class="label_value">
						<?php
							$student_data =	MJ_smgt_get_user_detail_byid($feespayment_data->student_id);	
							echo esc_html($student_data['first_name']." ".$student_data['last_name']);
						?>
					</label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Fees Title','school-mgt'); ?></label><br>
					<label for="" class="label_value">
						<?php 
							$fees_id=explode(',',$feespayment_data->fees_id);
							$fees_type=array();
							foreach($fees_id as $id)
							{ 
								$fees_type[] = mj_smgt_get_fees_term_name($id);
							}
							echo implode(" , " ,$fees_type);
							?>
					</label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Invoice Date','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo mj_smgt_getdate_in_input_box($feespayment_data->paid_by_date); ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Total Amount','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo mj_smgt_get_currency_symbol().''.$feespayment_data->total_amount; ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<?php 
						$total_amount = $feespayment_data->total_amount;
						$paid_amount = $feespayment_data->fees_paid_amount;
						$due_amount = $total_amount - $paid_amount;
					?>
					<label for="" class="popup_label_heading"><?php esc_attr_e('Due Amount','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo mj_smgt_get_currency_symbol().''.$due_amount; ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Paid Amount','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo mj_smgt_get_currency_symbol().''.$feespayment_data->fees_paid_amount; ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Status','school-mgt'); ?></label><br>
					<label for="" class="label_value">
						<?php
						$smgt_get_payment_status=mj_smgt_get_payment_status($feespayment_data->fees_pay_id);
						if($smgt_get_payment_status == 'Not Paid')
						{
						echo "<span class='red_color'>";
						}
						elseif($smgt_get_payment_status == 'Partially Paid')
						{
							echo "<span class='perpal_color'>";
						}
						else
						{
							echo "<span class='green_color'>";
						}
					
						echo esc_html__("$smgt_get_payment_status","school-mgt");					 
						echo "</span>";
						?>
					</label>
				</div>
				<div class="col-md-12 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Description','school-mgt'); ?></label><br>
					<label for="" class="label_value">
						<?php 
						$description = ltrim($feespayment_data->description);
						if(!empty($description)){ echo $description; }else{ echo "N/A"; } ?>
					</label>
				</div>
			</div>
        </div>  
	 <?php
	
	}
	?>
	<?php
	if($model=='Noticeboard Details')
	{
		?>
		<div class="modal-body view_details_body_assigned_bed view_details_body">
			<div class="row">
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Title','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo $retrieve_class->post_title; ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Start Date To End Date','school-mgt');?></label><br>
					<label for="" class="label_value"><?php echo mj_smgt_getdate_in_input_box(get_post_meta( $retrieve_class->ID, 'start_date',true));?> <?php esc_attr_e('To','school-mgt');?> <?php echo mj_smgt_getdate_in_input_box(get_post_meta( $retrieve_class->ID, 'end_date',true));?> </label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Notice For','school-mgt'); ?></label><br>
					<label for="" class="label_value">
						<?php
							if(get_post_meta( $retrieve_class->ID, 'notice_for',true) == 'all')
							{
								echo esc_attr_e('All','school-mgt');
							}
							else
							{
								echo esc_attr_e(get_post_meta( $retrieve_class->ID, 'notice_for',true),'school-mgt');
							}
						?>
					</label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Class Name','school-mgt');?></label><br>
					<label for="" class="label_value">
						<?php 
						if(get_post_meta( $retrieve_class->ID, 'smgt_class_id',true) !="" && get_post_meta( $retrieve_class->ID, 'smgt_class_id',true) =="all")
						{
							esc_attr_e('All','school-mgt');
						}
						elseif(get_post_meta( $retrieve_class->ID, 'smgt_class_id',true) !="")
						{
							echo mj_smgt_get_class_name(get_post_meta( $retrieve_class->ID, 'smgt_class_id',true));
						}?>
					</label>
				</div>
				<div class="col-md-12 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Comment','school-mgt'); ?></label><br>
					<label for="" class="label_value">
						<?php
							if(!empty($retrieve_class->post_content))
							{
								echo $retrieve_class->post_content;
							}else{
								echo "N/A";
							}
						?>
					</label>
				</div>
			</div>
        </div>  		
	 <?php
	
	}
	?>
	<?php
	if($model=='Exam Details')
	{
		?>	
		<div class="modal-body view_details_body_assigned_bed view_details_body">
			<div class="row">
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Title','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo $exam_data->exam_name; ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Term','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo get_the_title($exam_data->exam_term); ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Class Name','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo mj_smgt_get_class_name($exam_data->class_id); ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Section Name','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php if(!empty($exam_data->section_id)){ echo mj_smgt_get_section_name($exam_data->section_id); }else{ echo "N/A"; } ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Total Marks','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo $exam_data->total_mark; ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Passing Marks','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo $exam_data->passing_mark; ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Start Date','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo mj_smgt_getdate_in_input_box($exam_data->exam_start_date); ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('End Date','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo mj_smgt_getdate_in_input_box($exam_data->exam_end_date); ?></label>
				</div>
				<div class="col-md-12 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Comment','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php if(!empty($exam_data->exam_comment)){ echo $exam_data->exam_comment; }else{ echo "N/A"; } ?></label>
				</div>
			</div>
        </div>  		
	 <?php
	}
	?>
	<?php
	if($model=='holiday Details')
	{
		?>
		<div class="modal-body view_details_body_assigned_bed view_details_body">
			<div class="row">
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Holiday Title','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo $holiday_data->holiday_title; ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Start To End Date','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo mj_smgt_getdate_in_input_box($holiday_data->date); ?> <?php esc_attr_e('To','school-mgt'); ?> <?php echo mj_smgt_getdate_in_input_box($holiday_data->end_date); ?></label>
				</div>
				<div class="col-md-12 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Description','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php if(!empty($holiday_data->description)){ echo $holiday_data->description; }else{ echo "N/A"; } ?></label>
				</div>
			</div>
        </div>  		
	 <?php
	}
	if($model == 'Event Details')
	{
		?>
		<div class="modal-body view_details_body_assigned_bed view_details_body">
			<div class="row">
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Title','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php if(!empty($event_data->event_title)){ echo stripslashes($event_data->event_title); }else{ echo "N/A"; } ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Download File','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value">
						<?php
							if(!empty($event_data->event_doc))
							{
								?>
								<a download href="<?php print content_url().'/uploads/school_assets/'.$event_data->event_doc; ?>"  class="btn padding_0 popup_download_btn" record_id="<?php echo $exam_data->exam_id;?>"><i class="fa fa-download" id="download_icon"></i> <?php esc_attr_e('Download','school-mgt'); ?></a>
								<?php
							}
							else 
							{
								echo "N/A";
							}
						?>
					</label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Start Date','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo mj_smgt_getdate_in_input_box($event_data->start_date); ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('End Date','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo mj_smgt_getdate_in_input_box($event_data->end_date); ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Start Time','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo $event_data->start_time; ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('End Time','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo $event_data->end_time; ?></label>
				</div>
				<div class="col-md-12 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Description','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php  if(!empty($event_data->description)){ echo stripslashes($event_data->description);  }else{ echo "N/A"; } ?></label>
				</div>
			</div>
		</div>
		<?php
	}
	if($model == 'transport Details')
	{ 		
		?>
		<div class="modal-body view_details_body_assigned_bed view_details_body">
			<div class="row">
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Route Name','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php echo $transport_data->route_name; ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Vehicle Identifier','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php echo $transport_data->number_of_vehicle; ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Vehicle Registration Number','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php echo $transport_data->vehicle_reg_num; ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Driver Name','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php echo $transport_data->driver_name; ?></label>
				</div>

				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Driver Phone Number','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php echo $transport_data->driver_phone_num; ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Driver Address','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php echo $transport_data->driver_address; ?></label>
				</div> 
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Route Fare','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php echo "<span> ". mj_smgt_get_currency_symbol() ." </span>" . number_format($transport_data->route_fare,2); ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Route Description','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php if(!empty($transport_data->route_description)) { echo $transport_data->route_description; } else { echo "N/A";} ?></label>
				</div>
			</div>
		</div>	
		<?php 
	}
	?>
    </div> 
	<?php   
	die();	 
}
function mj_smgt_get_all_date_of_holidays()
{
	global $wpdb;
	$tbl_holiday = $wpdb->prefix.'holiday';
	$holiday ="SELECT * FROM $tbl_holiday";
	$HolidayData = $wpdb->get_results($holiday);		
	$holidaydates= array();
		
		foreach($HolidayData as $holiday)
		{
			$holidaydates[] = $holiday->date;
			$holidaydates[] = $holiday->end_date;
			$start_date = strtotime($holiday->date);
			$end_date =strtotime($holiday->end_date);
			if($holiday->date != $holiday->end_date)
			{
				for($i=$start_date; $i<$end_date; $i+=86400)
				{
					$holidaydates[] = date("Y-m-d",$i);
				}
			}
		}
		
	$holidaydates = array_unique($holidaydates);
	return $holidaydates;
}
 //-------- Generate Admission Number ------------//
function mj_smgt_generate_admission_number()
{
	global $wpdb;
	$table_wp_users=$wpdb->prefix.'wp_users';
	 				
	$userdata =get_users();
	if(empty($userdata))
	{							
		return $admission_no='00001';
	}
	else
	{
		$all_user = count($userdata);							
		
		$admission_no=$all_user;
		return $admission_no;
	} 
 }
 //ADD OR REMOVE CATEGORUY //
function mj_smgt_add_or_remove_category_new()//smgt_add_or_remove_category_new
{	 
	$model = $_REQUEST['model'];
	
	$title = esc_html__("title",'school-mgt');

	$table_header_title =  esc_html__("header",'school-mgt');

	$button_text=  esc_html__("Add",'school-mgt');

	$label_text =  esc_html__("category Name",'school-mgt');

	
	if($model == 'school_category')//school_category
	{
	
		$title = esc_html__("Add School Name",'school-mgt');

		$table_header_title =  esc_html__("School Name",'school-mgt');

		$button_text=  esc_html__("Add",'school-mgt');

		$label_text =  esc_html__("School Name",'school-mgt');	

	}
	if($model == 'standard_category')//standard_category
	{
	
		$title = esc_html__("Add Standard Name",'school-mgt');

		$table_header_title =  esc_html__("Standard Name",'school-mgt');

		$button_text=  esc_html__("Add",'school-mgt');

		$label_text =  esc_html__("Standard Name",'school-mgt');	

	}
	if($model == 'term_category')//term_category
	{
	
		$title = esc_html__("Add Term Category",'school-mgt');

		$table_header_title =  esc_html__("Term Category Name",'school-mgt');

		$button_text=  esc_html__("Add",'school-mgt');

		$label_text =  esc_html__("Term Category Name",'school-mgt');	

	}
	if($model == 'room_category')//term_category
	{
	
		$title = esc_html__("Add Room Type",'school-mgt');

		$table_header_title =  esc_html__("Room Type Name",'school-mgt');

		$button_text=  esc_html__("Add",'school-mgt');

		$label_text =  esc_html__("Room Type Name",'school-mgt');	

	}
	if($model == 'leave_type')
	{

		$title = esc_attr__("Add Leave Type",'school-mgt');

		$table_header_title =  esc_attr__("Leave Type Name",'school-mgt');

		$button_text=  esc_attr__("Add",'school-mgt');

		$label_text =  esc_attr__("Leave Type Name",'school-mgt');	

	}
	if($model == 'smgt_feetype')//term_category
	{
	
		$title = esc_html__("Add Fees",'school-mgt');

		$table_header_title =  esc_html__("Fees Category Name",'school-mgt');

		$button_text=  esc_html__("Add",'school-mgt');

		$label_text =  esc_html__("Fees Category Name",'school-mgt');	

	}
	if($model == 'smgt_bookcategory')//term_category
	{
	
		$title = esc_html__("Add Book Category",'school-mgt');

		$table_header_title =  esc_html__("Book Category Name",'school-mgt');

		$button_text=  esc_html__("Add",'school-mgt');

		$label_text =  esc_html__("Book Category Name",'school-mgt');	

	}
	if($model == 'smgt_rack')//term_category
	{
	
		$title = esc_html__("Add Rack Location",'school-mgt');

		$table_header_title =  esc_html__("Rack Location Name",'school-mgt');

		$button_text=  esc_html__("Add",'school-mgt');

		$label_text =  esc_html__("Rack Location Name",'school-mgt');	

	}
	if($model == 'period_type')//term_category
	{
	
		$title = esc_attr__("Issue Period",'school-mgt');
		$table_header_title =  esc_attr__("Period Time",'school-mgt');
		$button_text=  esc_attr__("Add",'school-mgt');
		$label_text =  esc_attr__("Period Time",'school-mgt');
	}
	
	if($model == 'period_type')//term_category
	{
		$obj_lib = new Smgtlibrary();
		$cat_result1 = $obj_lib->mj_smgt_get_periodlist();  
	}
	else
	{
		$cat_result = mj_smgt_get_all_category( $model );
	}	 
	?>
	<script src="jquery.maxlength.min.js"></script>

	<script type="text/javascript">
	jQuery(document).ready(function() 
	{
	    jQuery('#category_form_test').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	 
	});
	jQuery('.onlyletter_number_space_validation').keypress(function(e) 
	{     
		var regex = new RegExp("^[0-9a-zA-Z \b]+$");
		var key = String.fromCharCode(!event.charCode ? event.which: event.charCode);
		if (!regex.test(key)) 
		{
			event.preventDefault();
			return false;
		} 
   });
   jQuery('.onlyletter_number').keypress(function(e) 
	{     
		var regex = new RegExp("^[0-9\b]+$");
		var key = String.fromCharCode(!event.charCode ? event.which: event.charCode);
		if (!regex.test(key)) 
		{
			event.preventDefault();
			return false;
		} 
    });   
	</script>

	<div class="modal-header model_header_padding dashboard_model_header">
		<a href="javascript:void(0);" class="event_close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>
  		<h4 id="myLargeModalLabel" class="modal-title"><?php echo $title;?></h4>
	</div>
	<div class="padding_15px"><!---PANEL-WHITE--->

		<form name="category_form" action="" method="post" class="category_popup_float form-horizontal admission_form_popup" id="category_form_test"><!---CATEGORY_FORM----->
			<div class="form-body user_form">
				<div class="row">
					<?php					
					if($model == 'period_type')
					{
						?>
						<div class="col-md-9">
							<div class="form-group input">
								<div class="col-md-12 form-control">
									<input id="category_name" maxlength="50" min="1" class="cat_value validate[required] form-control text-input onlyletter_number" type="number"  value=""  name="category_name"  placeholder="<?php esc_attr_e('Must Be Enter Number of Days','school-mgt');?>">
									<label for="userinput1" class="active "><?php esc_html_e($label_text,'school-mgt');?><span class="required">*</span></label>
								</div>
							</div>
						</div>
						<?php
					}
					else
					{
						?>
						<div class="col-md-9">
							<div class="form-group input">
								<div class="col-md-12 form-control">
									<input id="category_name" maxlength="50" class="cat_value form-control text-input validate[required] onlyletter_number_space_validation" value="" name="category_name" <?php if(isset($placeholder_text)){?> type="number" placeholder="<?php  echo $placeholder_text;}else{?> type="text" <?php }?>>
									<label for="userinput1" class=""><?php esc_html_e($label_text,'school-mgt');?><span class="required">*</span></label>
								</div>
							</div>
						</div>
						<?php
					}
					?>
					<div class="col-sm-3" style="padding-bottom: 10px;">
						<input type="button" value="<?php echo $button_text;?>" name="save_category_test" class="btn save_btn btn-success" model="<?php echo $model;?>" id="btn_add_cat_new_test">
					</div>
				</div>
			</div>	
		</form>

  		<div class="category_listbox_new admission_pop_up_new"><!---CATEGORY_LISTBOX----->
  			<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12"><!---TABLE-RESPONSIVE----->
				<?php 
				$i = 1;
				?>
				<div class="div_new">				
				<?php
				if($model == 'period_type') 
				{			
					foreach ($cat_result1 as $retrieved_data)
					{ 
						?>
						<div class="row new_popup_padding" id="<?php echo "cat_new-".$retrieved_data->ID."";  ?>">
							<div class="col-md-11 width_80 mt_7px">
								<?php
								echo $retrieved_data->post_title;
								echo esc_attr__("Days","school-mgt");
								?>
							</div> 
							<div class="row col-md-1 rs_popup_width_20px" id="<?php echo $retrieved_data->ID; ?>">
								<div class="col-md-12">
									<a href="#" class="btn-delete-cat_new" model="<?php echo $model; ?>" id="<?php echo $retrieved_data->ID; ?>"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png"?>" alt=""></a>
								</div>
								
							</div>
						</div>
						<?php
						$i++;		
					}
				}
				else
				{
					foreach ($cat_result as $retrieved_data)
					{
						?>
						<div class="row new_popup_padding" id="<?php echo "cat_new-".$retrieved_data->ID.""; ?>">
							<div class="col-md-10 width_70">
								<?php
								echo $retrieved_data->post_title;
								?>
							</div>
							<div class="row col-md-2 padding_left_0_res width_30" id="<?php echo $retrieved_data->ID; ?>">
								<div class="col-md-6 width_50_res padding_left_0">
									<a href="#" class="btn-delete-cat_new" model="<?php echo $model; ?>" id="<?php echo $retrieved_data->ID; ?>"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png"?>" alt=""></a>
								</div>
								<div class="col-md-6 edit_btn_padding_left_25px_res width_50_res padding_right_0">
									<a class="btn-edit-cat_popup"  model="<?php echo $model; ?>" href="#" id="<?php echo $retrieved_data->ID; ?>"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/edit.png"?>" alt=""></a>
								</div>
							</div>
						</div>
						<?php
						$i++;		
					}
				}  
				?>
				</div>
			</div><!---END TABLE-RESPONSIVE----->
		</div><!---END CATEGORY_LISTBOX----->	

	</div><!---END PANEL-WHITE--->
	<?php 
	die();	
}
//ADD CATEGORY POPUP //
function mj_smgt_add_category_new($data)
{
	global $wpdb;
	$model = $_REQUEST['model'];
	
	$array_var = array();
	$data = array();
	$data['category_name'] = $_POST['category_name'];
	$data['category_type'] = $_POST['model'];
	$dlt_image = SMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png";
	$edit_image = SMS_PLUGIN_URL."/assets/images/listpage_icon/edit.png";
	$id =mj_smgt_add_categorytype($data);
	if($model == 'period_type')
	{
		$row1 = '<div class="row new_popup_padding" id="cat_new-'.$id.'"><div class="col-md-11 width_80 mt_7px" >'.$_REQUEST['category_name'].' '.esc_attr__("Days","school-mgt").'</div><div class="row col-md-1 rs_popup_width_20px"><div class="col-md-12"><a href="#" class="btn-delete-cat_new" model="'.$model.'" id="'.$id.'"><img src="'.$dlt_image.'" alt=""></a></a></div></div></div>';
		$option = "<option value='$id'>".$_REQUEST['category_name'].' '.esc_attr__('Days','school-mgt').''."</option>";
	}
	else
	{
		$row1 = '<div class="row new_popup_padding" id="cat_new-'.$id.'"><div class="col-md-10 width_70" >'.$_REQUEST['category_name'].'</div><div class="row col-md-2 padding_left_0_res width_30"><div class="col-md-6 width_50_res padding_left_0"><a href="#" class="btn-delete-cat_new" model="'.$model.'" id="'.$id.'"><img src="'.$dlt_image.'" alt=""></a></div><div class="col-md-6 edit_btn_padding_left_25px_res width_50_res padding_right_0"><a class="btn-edit-cat_popup" model="'.$model.'" href="#" id="'.$id.'"><img src="'.$edit_image.'" alt=""></a></div></div></div>';
		$option = "<option value='$id'>".$_REQUEST['category_name']."</option>";
	}

	$array_var[] = $row1;

	$array_var[] = $option;
   
	echo json_encode($array_var);

	die();
}
//-- Add Dynamic Category
function mj_smgt_add_categorytype($data)
{
	global $wpdb;
	if($data['category_type'] == 'period_type')
	{
		$result = wp_insert_post( array(

			'post_status' => 'publish',

			'post_type' =>'smgt_bookperiod',

			'post_title' => $data['category_name']) );
	}
	else
	{
		$result = wp_insert_post( array(

			'post_status' => 'publish',

			'post_type' => $data['category_type'],

			'post_title' => $data['category_name']) );
	}
	$id = $wpdb->insert_id;
	return $id;
}
 //remove category 
function mj_smgt_remove_category_new()
{
	wp_delete_post($_REQUEST['cat_id']);
	die();
}
//-- Get Dynamic Categories
function mj_smgt_get_all_category($model){

	$args= array('post_type'=> $model,'posts_per_page'=>-1,'orderby'=>'post_title','order'=>'Asc');

	$cat_result = get_posts( $args );

	return $cat_result;

}

function mj_smgt_admissoin_approved()
{
	$uid = $_REQUEST['student_id'];
	$user_info=get_userdata($uid);
	?>
	<script type="text/javascript">
		jQuery(document).ready(function() {
				jQuery('#admission_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	 
		} );
	</script>
   
	<style>
		.modal-header{
			height:auto;
		}
	</style>
	<div class="modal-header dashboard_model_header"> 
		<a href="#" class="close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>
		<img class="rtl_float_right" src="<?php echo get_option( 'smgt_school_logo' ) ?>" class="img-circle head_logo" width="40" height="40" style="float: left;"/>
		<h4 class="modal-title"><?php echo get_option( 'smgt_school_name' );?></h4> 
	</div>

<div class="panel-white admission_div_responsive">
	<div class="padding_20px padding_bottom_0px">
		<h4 class="panel-title"><i class="fa fa-user"></i> <?php echo mj_smgt_get_user_name_byid($uid);?></h4>
	</div>
   <form name="admission_form" action="" method="post" class="padding_20px form-horizontal" id="admission_form">
		<input type="hidden" name="act_user_id" value="<?php echo $uid;?>">
		<div class="form-body user_form">
			<div class="row">	
				<div class="col-md-6">
					<div class="form-group input">
						<div class="col-md-12 form-control">
							<input id="email" class="form-control validate[required,custom[email]] text-input email" maxlength="100" value="<?php echo $user_info->user_email;?>"type="text"  name="email" readonly>
							<label for="userinput1" class="active"><?php esc_html_e('Email','school-mgt');?><span class="required">*</span></label>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group input">
						<div class="col-md-12 form-control">
							<input id="password" class="form-control validate[required]" type="password"  name="password" value="">
							<label for="userinput1" class=""><?php esc_html_e('Password','school-mgt');?><span class="required">*</span></label>
						</div>
					</div>
				</div>
				<div class="col-md-6 input">
					<label class="ml-1 custom-top-label top" for="hmgt_contry"><?php esc_html_e('Class','school-mgt');?><span class="required">*</span></label>
					<select name="class_name" class="line_height_30px form-control validate[required] class_in_student width_515" id="class_list">
						<option value=""><?php esc_attr_e('Select Class','school-mgt');?></option>
						<?php
							foreach(mj_smgt_get_allclass() as $classdata)
							{  
							?>
							<option value="<?php echo $classdata['class_id'];?>"><?php echo $classdata['class_name'];?></option>
						<?php }?>
					</select>             
				</div>
				<div class="col-md-6 input">
					<label class="ml-1 custom-top-label top" for="hmgt_contry"><?php esc_html_e('Class Section','school-mgt');?></label>
					<select name="class_section" class="line_height_30px form-control width_515" id="class_section">
						<option value=""><?php esc_attr_e('Select Class Section','school-mgt');?></option>
						<?php
						if($edit){
							foreach(mj_smgt_get_class_sections($user_info->class_name) as $sectiondata)
							{  ?>
							<option value="<?php echo $sectiondata->id;?>"><?php echo $sectiondata->section_name;?></option>
						<?php } 
						}?>
					</select>          
				</div>
				<div class="col-md-6">
					<div class="form-group input">
						<div class="col-md-12 form-control">
							<input id="roll_id" class="form-control validate[required,custom[username_validation]] text-input" maxlength="50" type="text" value="" name="roll_id">
							<label for="userinput1" class=""><?php esc_html_e('Roll No.','school-mgt');?><span class="required">*</span></label>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="form-body user_form">
			<div class="row">
				<div class="col-sm-6">
					<input type="submit" value="<?php esc_attr_e('Active Student','school-mgt');?>" name="active_user_admission" class="btn btn-success save_btn margin_top_20"/>
				</div>
			</div>
		</div>
   </form>
</div>
  <?php
  die();
}

add_action('wp_ajax_mj_smgt_datatable_homework_data_ajax_to_load','mj_smgt_datatable_homework_data_ajax_to_load');

add_action( 'wp_ajax_mj_smgt_leave_approve', 'mj_smgt_leave_approve');
add_action( 'wp_ajax_mj_smgt_leave_reject', 'mj_smgt_leave_reject');

add_action( 'wp_ajax_mj_smgt_load_students_homework','mj_smgt_load_students_homework');

add_action( 'wp_ajax_nopriv_mj_smgt_load_students_homework','mj_smgt_load_students_homework');

add_action( 'wp_ajax_mj_smgt_load_sections_students_homework','mj_smgt_load_sections_students_homework');

add_action( 'wp_ajax_nopriv_mj_smgt_load_sections_students_homework','mj_smgt_load_sections_students_homework');

function mj_smgt_datatable_homework_data_ajax_to_load()
{
     global $wpdb;
	 $sTable = $wpdb->prefix . 'mj_smgt_homework';
	 $sLimit = '10';
	 if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' )
	 {
	   $sLimit = "LIMIT ".intval( $_REQUEST['iDisplayStart'] ).", ".
	   intval( $_REQUEST['iDisplayLength'] );
	 }
	   $ssearch = $_REQUEST['sSearch'];
 	   if($ssearch){
	   $sQuery = "
	   SELECT * FROM  $sTable  WHERE homework_title LIKE '%$ssearch%' OR to_date LIKE '%$ssearch%'"; 
	   }
	   else
	   {
	   $sQuery = "SELECT * FROM $sTable";
	   }
	
		  $rResult = $wpdb->get_results($sQuery, ARRAY_A);
		  
		  $wpdb->get_results(" SELECT * FROM $sTable"); 
		  $iFilteredTotal = $wpdb->num_rows;
		  
		  $wpdb->get_results(" SELECT * FROM $sTable ");
		  $iTotal = $wpdb->num_rows;

		  $output = array(
		  "sEcho" => intval($_REQUEST['sEcho']),
		  "iTotalRecords" => $iTotal,
		  "iTotalDisplayRecords" => $iFilteredTotal,
		  "aaData" => array()
		 );
 
		 foreach($rResult as $aRow)
		 {
			 
			if(isset($aRow['section_id']) && $aRow['section_id']!=0)
			{
			 $section_name=mj_smgt_get_section_name($aRow['section_id']); 
			}
			else
			{
			   $section_name='No Section';
			}
			$row[0] = '<input type="checkbox" class="select-checkbox" name="id[]" value='.$aRow['homework_id'].'">';
			$row[1]=$aRow['homework_title'];
			$row[2]=mj_smgt_get_class_name($aRow['class_id']);
			$row[3]=$section_name;
			$row[4]=mj_smgt_get_single_subject_name($aRow['subject_id']);
			$row[5]=$aRow['to_date'];
			$row[6] = '
		    <a href="?page=smgt_homework&tab=addhomework&action=edit&homework_id='.$aRow['homework_id'].'" class="btn btn-info"><i class="fa fa-edit"></i>&nbsp; '. esc_attr__("Edit","school-mgt").' </a>&nbsp;&nbsp;
		    <a id="delete_selected" href="?page=smgt_homework&tab=homeworklist&action=delete&del_homework_id='.$aRow['homework_id'].'" class="btn btn-danger delete_selected" Onclick="ConfirmDelete()"><i class="fa fa-times"></i>&nbsp; '. esc_attr__("Delete","school-mgt").' </a>&nbsp;&nbsp;
		    <a href="?page=smgt_homework&tab=submission&homework_id='.$aRow['homework_id'].'" class="btn btn-default"><i class="fa fa-eye"></i>&nbsp; '. esc_attr__("View Submissions","school-mgt").' </a>
            ';
		    $output['aaData'][] = $row;
		 } 
 echo json_encode( $output );
 die();
}
function mj_smgt_leave_approve()
{ 
	?>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#leave_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});
		});
	</script>
	<div class="modal-header model_header_padding dashboard_model_header" style="margin-bottom: 20px;">
		<a href="javascript:void(0);" class="close-btn-cat badge badge-success pull-right "><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>
  		<h4 id="myLargeModalLabel" class="modal-title"><?php _e('Leave Approve','school-mgt');?></h4>
	</div>
	<div class="panel-white" style="padding: 20px;">
		<form name="leave_form" action="" method="post" class="form-horizontal" id="leave_form">
			<input type="hidden" name="leave_id" value="<?php print $_REQUEST['leave_id'] ?>">
			<div class="form-body user_form">
				<div class="row">
					<div class="col-md-9">
						<div class="form-group input">
							<div class="col-md-12 note_border margin_bottom_15px_res">
								<div class="form-field">
									<textarea name="comment" cols="50" rows="2" class="textarea_height_47px form-control validate[required,custom[address_description_validation]]" maxlength="250" id=""></textarea>
									<span class="txt-title-label"></span>
									<label class="text-area address active"><?php esc_attr_e('Comment','school-mgt');?><span class="require-field">*</span></label>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<input type="submit" value="<?php _e('Submit','school-mgt'); ?>" name="approve_comment" class="btn btn-success save_btn"  id="btn-add-cat"/>
					</div>
				</div>
			</div>
		</form>
	</div>
	<?php 
	die;	
}

function mj_smgt_leave_reject()
{ 
	?>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#leave_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});
		});
	</script>
	<div class="modal-header model_header_padding dashboard_model_header" style="margin-bottom: 20px;">
		<a href="javascript:void(0);" class="close-btn-cat badge badge-success pull-right "><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>
  		<h4 id="myLargeModalLabel" class="modal-title"><?php _e('Leave Reject','school-mgt');?></h4>
	</div>
	<div class="panel-white" style="padding: 20px;">
		<form name="leave_form" action="" method="post" class="form-horizontal" id="leave_form">
			<input type="hidden" name="leave_id" value="<?php print $_REQUEST['leave_id'] ?>">
			<div class="form-body user_form">
				<div class="row">
					<div class="col-md-9">
						<div class="form-group input">
							<div class="col-md-12 note_border margin_bottom_15px_res">
								<div class="form-field">
									<textarea name="comment" cols="50" rows="2" class="textarea_height_47px form-control validate[required,custom[address_description_validation]]" maxlength="250" id=""></textarea>
									<span class="txt-title-label"></span>
									<label class="text-area address active"><?php esc_attr_e('Comment','school-mgt');?><span class="require-field">*</span></label>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<input type="submit" value="<?php _e('Submit','school-mgt'); ?>" name="reject_leave" class="btn btn-success save_btn"  id="btn-add-cat"/>	
					</div>
				</div>
			</div>
		</form>
	</div>
	<?php 
	die;	
}

function mj_smgt_load_students_homework()
{
	$class_id =$_POST['class_list'];
    global $wpdb;
	$exlude_id = mj_smgt_approve_student_list();
	$retrieve_data = get_users(array('meta_key' => 'class_name', 'meta_value' => $class_id,'role'=>'student','exclude'=>$exlude_id));
	$resoinse=array();
	$student="";
	$sections="";
	$subjects="";
	foreach($retrieve_data as $users)
	{
		$student.="<option value=".$users->id.">".$users->first_name." ".$users->last_name."</option>";
	}
		$resoinse[0]=$student;
		/*---------SECTION-------------*/
		$retrieve_data=mj_smgt_get_class_sections($class_id);

		$defaultmsg= esc_attr__( 'Select Class Section' , 'school-mgt');

		$sections="<option value=''>".$defaultmsg."</option>";	

		foreach($retrieve_data as $section)
		{
			$teacher_access = get_option( 'smgt_access_right_teacher');
			$teacher_access_data=$teacher_access['teacher'];
			foreach($teacher_access_data as $key=>$value)
			{
				if($key=='student')
				{
					$data=$value;
				}
			}
			if($data['own_data']=='1' && mj_smgt_get_roles(get_current_user_id())=='teacher')
			{
				$section=smgt_get_section($section);
			}
			$sections.="<option value='".$section->id."'>".$section->section_name."</option>";
		}
		$resoinse[1]=$sections;
		/*----------subjects--------------*/
		$table_name = $wpdb->prefix . "subject";
		$user_id=get_current_user_id();
		//------------------------TEACHER ACCESS---------------------------------//
		$teacher_access = get_option( 'smgt_access_right_teacher');
		$teacher_access_data=$teacher_access['teacher'];
		foreach($teacher_access_data as $key=>$value)
		{
			if($key=='subject')
			{
				$data=$value;
			}
		}
		if(mj_smgt_get_roles($user_id)=='teacher' && $data['own_data']=='1')
		{
			$retrieve_subject = $wpdb->get_results( "SELECT * FROM $table_name where  teacher_id=$user_id and class_id=".$class_id);
		}
		else
		{
			$retrieve_subject = $wpdb->get_results( "SELECT * FROM $table_name WHERE class_id=".$class_id);
		}
		$defaultmsg= esc_attr__( 'Select subject' , 'school-mgt');
		$subjects="<option value=''>".$defaultmsg."</option>";	
		foreach($retrieve_subject as $retrieved_data)
		{
			$subjects.="<option value=".$retrieved_data->subid."> ".$retrieved_data->sub_name ."</option>";
		}
		$resoinse[2]=$subjects;
		echo json_encode($resoinse);
		die();
}
function mj_smgt_load_sections_students_homework()
{
	global $wpdb;
	$resoinse=array();
	$student="";
	$subjects="";
	$section_id =$_POST['section_id'];
	$exlude_id = mj_smgt_approve_student_list();
	$retrieve_data = get_users(array('meta_key' => 'class_section', 'meta_value' => $section_id,'role'=>'student','exclude'=>$exlude_id));
	foreach($retrieve_data as $users)
	{
		$student.="<option value=".$users->id.">".$users->first_name." ".$users->last_name."</option>";
	}
	$resoinse[0]=$student;
	/*----------subjects--------------*/
	$table_name = $wpdb->prefix . "subject";
	$user_id=get_current_user_id();
	//------------------------TEACHER ACCESS---------------------------------//
		$teacher_access = get_option( 'smgt_access_right_teacher');
		$teacher_access_data=$teacher_access['teacher'];
		foreach($teacher_access_data as $key=>$value)
		{
			if($key=='subject')
			{
				$data=$value;
			}
		}
	if(mj_smgt_get_roles($user_id)=='teacher' && $data['own_data']=='1')
	{
		$retrieve_subject = $wpdb->get_results( "SELECT * FROM $table_name where  teacher_id=$user_id and class_id=".$class_id);
	}
	else
	{
		$retrieve_subject = $wpdb->get_results( "SELECT * FROM $table_name WHERE section_id=".$section_id);
	}
	$defaultmsg= esc_attr__( 'Select subject' , 'school-mgt');
	$subjects="<option value=''>".$defaultmsg."</option>";	
	foreach($retrieve_subject as $retrieved_data)
	{
		$subjects.="<option value=".$retrieved_data->subid."> ".$retrieved_data->sub_name ."</option>";
	}
	$resoinse[1]=$subjects;
	echo json_encode($resoinse);
	die();
}
function mj_smgt_insert_exam_reciept($user_id,$exam_hall,$exam_id)
{
	$current_user=get_current_user_id();
	$created_date = date("Y-m-d");
	$status=1;
	$tablename="smgt_exam_hall_receipt";
	$hall_data=array('exam_id'=>mj_smgt_onlyNumberSp_validation($exam_id),
					'user_id'=>mj_smgt_onlyNumberSp_validation($user_id),
					'hall_id'=>mj_smgt_onlyNumberSp_validation($exam_hall),
					'exam_hall_receipt_status'=>$status,
					'created_date'=>$created_date,
					'created_by'=>$current_user
					);
	global $wpdb;
	$table_name = $wpdb->prefix . $tablename;
	$result=$wpdb->insert($table_name, $hall_data);
			
	return $user_id;
}
add_action( 'wp_ajax_mj_smgt_load_exam_hall_receipt_div','mj_smgt_load_exam_hall_receipt_div');
add_action( 'wp_ajax_nopriv_mj_smgt_load_exam_hall_receipt_div','mj_smgt_load_exam_hall_receipt_div');

function mj_smgt_load_exam_hall_receipt_div()
{  
 
	global $wpdb;
	$exam_data= mj_smgt_get_exam_by_id($_REQUEST['exam_id']);
   
	$exam_id=$_REQUEST['exam_id'];
	$array_var=array();
	$start_date=$exam_data->exam_start_date;
	$end_date=$exam_data->exam_end_date; 
	$class_id=$exam_data->class_id;
	$section_id=$exam_data->section_id;
	 
	//----------- All Student Data ------------//
	$exlude_id = mj_smgt_approve_student_list();
	if(isset($class_id) &&  $section_id!=0)
	{
		$student_data = get_users(
            array(
                'role' => 'student',
				'exclude'=>$exlude_id,
                'meta_query' => array(
                    array(
                        'key' => 'class_name',
                        'value' => $class_id,
                        'compare' => '=='
                    ),
                    array(
                        'key' => 'class_section',
                        'value' => $section_id,
                        'compare' => '=='
                    )
                )
            )
        );
	}
	else
	{
		$student_data = get_users(array('meta_key' => 'class_name', 'meta_value' => $class_id,'role'=>'student','exclude'=>$exlude_id));
		
	}
	if(!empty($student_data))
	{
		foreach($student_data as $s_id)
		{
			$student_id[]=$s_id->ID;
		}
	}
 
	//---------- Asigned Student Data --------//
	$table_name_smgt_exam_hall_receipt = $wpdb->prefix . "smgt_exam_hall_receipt";
	$student_data_asigned = $wpdb->get_results( "SELECT user_id FROM $table_name_smgt_exam_hall_receipt where exam_id=".$exam_id);
	
	if(!empty($student_data_asigned))
	{
		foreach($student_data_asigned as $s_id1)
		{
			$student_id1[]=$s_id1->user_id;
		}
	}
	if(empty($student_data_asigned))
	{
		$student_show_data=$student_id;
	}
	else
	{
		$student_show_data=array_diff($student_id,$student_id1);
	}
	  
	$array_var='
	<div class="exam_hall_receipt_main_div">
		<form name="receipt_form" action="" method="post" class="form-horizontal" id="receipt_form">
			<input type="hidden" name="exam_id" value="'.$exam_id.'">
			<div class="form-group row">
				<div class="table-responsive">
					<table class="table exam_hall_table" id="exam_hall_table" style="border: 1px solid #D9E1ED;text-align: center;margin-bottom: 0px;">
						<thead>
							<tr>
								<th  class="exam_hall_receipt_table_heading" style="border-top: medium none;border-right: 1px solid #D9E1ED;background-color: #F2F5FA;border-bottom: 1px solid #D9E1ED;text-align: center;">'. esc_attr__('Exam','school-mgt').'</th>
								<th  class="exam_hall_receipt_table_heading" style="border-right: 1px solid #D9E1ED;background-color: #F2F5FA;border-bottom: 1px solid #D9E1ED;text-align: center;">'. esc_attr__('Class','school-mgt').'</th>							
								<th  class="exam_hall_receipt_table_heading" style="border-right: 1px solid #D9E1ED;background-color: #F2F5FA;border-bottom: 1px solid #D9E1ED;text-align: center;">'. esc_attr__('Section','school-mgt').'</th>							
								<th  class="exam_hall_receipt_table_heading" style="border-right: 1px solid #D9E1ED;background-color: #F2F5FA;border-bottom: 1px solid #D9E1ED;text-align: center;">'. esc_attr__('Term','school-mgt').'</th>							
								<th  class="exam_hall_receipt_table_heading" style="border-right: 1px solid #D9E1ED;background-color: #F2F5FA;border-bottom: 1px solid #D9E1ED;text-align: center;">'. esc_attr__('Start Date','school-mgt').'</th>							
								<th class="exam_hall_receipt_table_heading" style="background-color: #F2F5FA;border-bottom: 1px solid #D9E1ED;text-align: center;">'. esc_attr__('End Date','school-mgt');'</th>							
							</tr>
						</thead>
						<tfoot></tfoot>
						<tbody>';						
							$array_var.='<tr>
								<td class="exam_hall_receipt_table_value" style="border-right: 1px solid #D9E1ED;">'.$exam_data->exam_name.'</td>							
								<td class="exam_hall_receipt_table_value" style="border-right: 1px solid #D9E1ED;">'.mj_smgt_get_class_name($exam_data->class_id);
								$array_var.='</td>
								<td class="exam_hall_receipt_table_value" style="border-right: 1px solid #D9E1ED;">';
								if($exam_data->section_id!=0)
								{ 
									$array_var.=mj_smgt_get_section_name($exam_data->section_id); 
								}else
								{ 
									$array_var.= esc_attr__('No Section','school-mgt');
								}
								$array_var.='</td>
								<td class="exam_hall_receipt_table_value" style="border-right: 1px solid #D9E1ED;">'.get_the_title($exam_data->exam_term);
								$array_var.='</td>
								<td class="exam_hall_receipt_table_value" style="border-right: 1px solid #D9E1ED;">'. mj_smgt_getdate_in_input_box($start_date);
								$array_var.='</td>
								<td class="exam_hall_receipt_table_value" style="">'.mj_smgt_getdate_in_input_box($end_date);
								$array_var.='</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>	
			<div class="form-body user_form margin_top_20px padding_top_25px_res">
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-12">';
						$table_name = $wpdb->prefix . "hall";
						$retrieve_subject = $wpdb->get_results( "SELECT * FROM $table_name");
						$array_var.='<select name="exam_hall" class="line_height_30px form-control validate[required]" id="exam_hall">';
						$defaultmsg= esc_attr__( 'Select Exam Hall' , 'school-mgt');
						$array_var.='<option value="">'.$defaultmsg.'</option>';	
						foreach($retrieve_subject as $retrieved_data)
						{
							$array_var.='<option id="exam_hall_capacity_'.$retrieved_data->hall_id.'" hall_capacity="'.$retrieved_data->hall_capacity.'" value="'.$retrieved_data->hall_id.'"> '.stripslashes($retrieved_data->hall_name) .'</option>';
						}
						$array_var.='</select>
					</div>
				</div>
			</div>
			<div class="form-group row margin_top_20px padding_top_25px_res">
				<div class="col-md-12">
					<div class="row">';
						if(!empty($student_show_data) || !empty($student_data_asigned))
						{  
							$array_var.="<div class='col-md-6 col-sm-6 col-xs-12'>";
							$array_var.='<h4 class="exam_hall_lable">'. esc_attr__('Not Assign Exam Hall Student List' , 'school-mgt').'</h4>';
							if(isset($student_show_data))
							{
								$array_var.='<table id="not_approve_table" class="display exam_timelist" cellspacing="0" width="100%" style="border: 1px solid #D9E1ED;text-align: center;margin-bottom: 0px;">
									<thead>
										<tr>
											<th class="exam_hall_receipt_table_heading" style="width: 20px; border-top: medium none;background-color: #F2F5FA;border-bottom: 1px solid #D9E1ED;text-align: center;"><input name="select_all[]" value="all" class="hall_receipt_checkbox my_all_check " id="checkbox-select-all" type="checkbox" /></th>
											<th class="exam_hall_receipt_table_heading" style=";background-color: #F2F5FA;border-bottom: 1px solid #D9E1ED;text-align: center;">'. esc_attr__('Student Name' , 'school-mgt').'</th>
											<th class="exam_hall_receipt_table_heading" style="background-color: #F2F5FA;border-bottom: 1px solid #D9E1ED;text-align: center;">'. esc_attr__('Student Roll No', 'school-mgt').'</th>
										</tr>
									</thead>
								
									<tbody>';
									if(!empty($student_show_data))
									{
										foreach($student_show_data as $retrieve_data)
										{
											$userdata=get_userdata($retrieve_data);
											$array_var.='<tr id="'.$retrieve_data.'" style="border: 1px solid #D9E1ED;">
												<td class="exam_hall_receipt_table_value" style="text-align: center;"><input type="checkbox" class="hall_receipt_checkbox select-checkbox my_check hall_receipt_checkbox" name="id[]" dataid="'.$retrieve_data.'"  value="'.$retrieve_data.'"></td>
												<td class="exam_hall_receipt_table_value" style="text-align: center;">'.$userdata->display_name.'</td>
												<td class="exam_hall_receipt_table_value" style="text-align: center;">'.get_user_meta($retrieve_data, 'roll_id',true);
												$array_var.='</td>
											</tr>';
										}
									}
									else
									{
										$array_var.='<td class="no_data_td_remove" style="text-align:center;" colspan="3">'. esc_attr__('No Student Available' , 'school-mgt').'</td>';
									}
									$array_var.='</tbody>
								</table>
								<tr> 
									<td> 
										<button type="button" class="mt-2 btn btn-success save_btn assign_exam_hall" name="assign_exam_hall" id="assign_exam_hall">'. esc_attr__('Assign Exam Hall', 'school-mgt').'</button>
									</td>
								</tr>';
							}
						$array_var.='</div>';
						$array_var.="<div class='col-md-6 col-sm-6 col-xs-12'>";
							$array_var.='<h4 class="exam_hall_lable">'. esc_attr__('Assign Exam Hall Student List' , 'school-mgt').'</h4>';
							if(isset($student_data_asigned))
							{  
								$array_var.='<table id="approve_table" class="display exam_timelist" cellspacing="0" width="100%" style="border: 1px solid #D9E1ED;text-align: center;margin-bottom: 0px;">
									<thead>
										<tr >
											<th class="exam_hall_receipt_table_heading" style="width: 20px; border-top: medium none;background-color: #F2F5FA;border-bottom: 1px solid #D9E1ED;text-align: center;"></th>
											<th class="exam_hall_receipt_table_heading" style=";background-color: #F2F5FA;border-bottom: 1px solid #D9E1ED;text-align: center;">'. esc_attr__('Student Name' , 'school-mgt').'</th>
											<th class="exam_hall_receipt_table_heading" style="background-color: #F2F5FA;border-bottom: 1px solid #D9E1ED;text-align: center;">'. esc_attr__('Student Roll No', 'school-mgt').'</th>
										</tr>
									</thead>
								
									<tbody>';	
									if(!empty($student_data_asigned))
									{
										foreach($student_data_asigned as $retrieve_data1)
										{
											$userdata=get_userdata($retrieve_data1->user_id);
											$dlt_image_icon = SMS_PLUGIN_URL."/assets/images/dashboard_icon/Delete.png";
											$array_var.='<tr id="'.$retrieve_data1->user_id.'" style="border: 1px solid #D9E1ED;">
											<td class="exam_hall_receipt_table_value" style="text-align: center;">
											<a class="delete_receipt_record" href="#" dataid="'.$retrieve_data1->user_id.'"  id='.$retrieve_data1->user_id.'><img src="'.$dlt_image_icon.'" alt="" class="massage_image center"></a></td>
											<td class="exam_hall_receipt_table_value" style="text-align: center;">'.$userdata->display_name.'</td>
											<td class="exam_hall_receipt_table_value" style="text-align: center;">'.get_user_meta($retrieve_data1->user_id, 'roll_id',true);
											$array_var.='</td>
										</tr>';
										}
									}
									else
									{
										$array_var.='<td  class="no_data_td_remove1" style="text-align:center;" colspan="3">'. esc_attr__('No Student Assing in This Hall' , 'school-mgt').'</td>';
									}
									$array_var.='</tbody>
								</table>
								<tr>
									<td>
										<button type="submit" class="mt-2 btn save_btn btn-success" name="send_mail_exam_receipt" id="send_mail_exam_receipt">'. esc_attr__('Send Mail', 'school-mgt').'</button>
									</td>
								</tr>';
							}
						$array_var.='</div>';
						}
						else
						{
							$array_var.='<div><h4 class="">'. esc_attr__('No Student Available', 'school-mgt').'</h4></div>';
						}
					$array_var.='</div>
				</div>
			</div>
		</form>
	</div>';	 
	$data[]=$array_var;
	echo json_encode($data);
	die();
}
add_action( 'wp_ajax_mj_smgt_delete_receipt_record','mj_smgt_delete_receipt_record');
add_action( 'wp_ajax_nopriv_mj_smgt_delete_receipt_record','mj_smgt_delete_receipt_record');
function mj_smgt_delete_receipt_record()
{
	$array_var=array();
	$id=$_POST['record_id'];
	$exam_id=$_POST['exam_id'];
	global $wpdb;
	$table_name_smgt_exam_hall_receipt = $wpdb->prefix . "smgt_exam_hall_receipt";
	$user_id = $wpdb->query("Delete from $table_name_smgt_exam_hall_receipt where exam_id=$exam_id and user_id=".$id);
	if($user_id)
	{
		$userdata=get_userdata($id);
		$array_var.='<tr id="'.$id.'" style="border: 1px solid #D9E1ED;">
			<td class="exam_hall_receipt_table_value" style="text-align: center;"><input type="checkbox" class="select-checkbox my_check hall_receipt_checkbox" name="id[]" dataid="'.$id.'"  value="'.$id.'"></td>
			<td class="exam_hall_receipt_table_value" style="text-align: center;">'.$userdata->display_name.'</td>
			<td class="exam_hall_receipt_table_value" style="text-align: center;">'.get_user_meta($id, 'roll_id',true);
			$array_var.='</td>
		</tr>';
	}
	$data[]=$array_var;
	echo json_encode($data);
	die();
}

add_action( 'wp_ajax_mj_smgt_add_receipt_record','mj_smgt_add_receipt_record');
add_action( 'wp_ajax_nopriv_mj_smgt_add_receipt_record','mj_smgt_add_receipt_record');
function mj_smgt_add_receipt_record()
{
	$array_var=array();
	$user_id_array=$_POST['id_array'];
	$exam_hall=$_POST['exam_hall'];
	$exam_id=$_POST['exam_id'];
	if(!empty($user_id_array))
	{
		
			foreach($user_id_array as $id)
			{
				$user_id=mj_smgt_insert_exam_reciept($id,$exam_hall,$exam_id);
				$userdata=get_userdata($user_id);

				if($user_id)
				{
					$dlt_image_icon = SMS_PLUGIN_URL."/assets/images/dashboard_icon/Delete.png";
					$array_var.='<tr id="'.$user_id.'" style="border: 1px solid #D9E1ED;">
						<td class="exam_hall_receipt_table_value" style="text-align: center;">
							<a class="delete_receipt_record " href="#" id='.$user_id.'><img src="'.$dlt_image_icon.'" alt="" class="massage_image center"></a></td>
						<td class="exam_hall_receipt_table_value" style="text-align: center;">'.$userdata->display_name.'</td>
						<td class="exam_hall_receipt_table_value" style="text-align: center;">'.get_user_meta($user_id, 'roll_id',true);
						$array_var.='</td>
					</tr>';

				}
			} 
	}
	$data[]=$array_var;
	echo json_encode($data);
	die();
}
function mj_smgt_student_exam_receipt_check($student_id)
{
	global $wpdb;
	$table_name_smgt_exam_hall_receipt = $wpdb->prefix . "smgt_exam_hall_receipt";
	$result = $wpdb->get_results("Select * from $table_name_smgt_exam_hall_receipt where user_id=".$student_id);
	return $result;
}

//-------------------- PRINT EXAM RECEIPT -----------------------//
 
function mj_smgt_print_exam_receipt()
{

	if(isset($_REQUEST['student_exam_receipt']) && $_REQUEST['student_exam_receipt'] == 'student_exam_receipt')
	{
		?>
<script>window.onload = function(){ window.print(); };</script>
<?php 
		mj_smgt_student_exam_receipt_print($_REQUEST['student_id'],$_REQUEST['exam_id']);
		exit;
	}			
}
add_action('init','mj_smgt_print_exam_receipt');
function mj_smgt_student_exam_receipt_print($student_id,$exam_id)
{
	$student_data=get_userdata($student_id);
	
	$umetadata=mj_smgt_get_user_image($student_id);
	
	$exam_data= mj_smgt_get_exam_by_id($exam_id);
	
	$exam_hall_data=mj_smgt_get_exam_hall_name($student_id,$exam_id);
	$exam_hall_name=mj_smgt_get_hall_name($exam_hall_data->hall_id);
	
	$obj_exam=new smgt_exam;
	$exam_time_table=$obj_exam->mj_smgt_get_exam_time_table_by_exam($_REQUEST['exam_id']);
  
?>
<style>
 table, .header, span.sign {
    font-family: sans-serif;
    font-size: 12px;
    color: #444;
}
.borderpx {
    border: 1px solid #97C4E7;
}
.count td, .count th {
    padding-left: 10px;
    height: 40px;
}
.resultdate {
    float: left;
    width: 200px;
    padding-top: 100px;
    text-align: center;
}
.signature {
    float: right;
    width: 200px;
    padding-top: 100px;
    text-align: center;
}
.exam_receipt_print{
	width: 90%;
	margin:0 auto;
}
.header_logo{
	float:left;
	width: 100%;
	text-align:center;
}
.font_22
{
	font-size:22px;
}
.Examination_header
{
	float:left; 
	width: 100%;
	font-size:18px;
	text-align:center;
	padding-bottom: 20px;
}
.Examination_header_color{
	color:#970606;
}
.float_width
{
	float:left; 
	width: 100%;
}
.padding_top_20
{
	padding-top:20px;
}
.img_td
{
	text-align:center;
	border-right : 1px solid #97C4E7;
}
.border_bottom{
	border-bottom : 1px solid #97C4E7;
}
.border_bottom_0{
	border-bottom : 0px;
}
.border_bottom_rigth{
	border-bottom : 1px solid #97C4E7;
	border-right : 1px solid #97C4E7;
}
.border_rigth{
	border-right : 1px solid #97C4E7;
}
.main_td
{
	text-align:center;
	border-bottom : 1px solid #97C4E7;
}
.hr_color{
	color:#97C4E7;
}
.header_color{
	color:#204759;
}
.max_height_100
{
	max-height:100px;
}
</style>
		<?php	
		if (is_rtl()){
		?>
		<div class="modal-body" style="direction: rtl;">
			<div id="exam_receipt_print" class="exam_receipt_print"> 
				
				<div class="header_logo">
					<div class="header_logo"><img class="max_height_100" src="<?php echo get_option( 'smgt_school_logo' ) ?>"></div>
					<h4 class="header_logo font_22"><strong class="header_color"><?php  echo get_option( 'smgt_school_name' );?></strong></h4>
				</div>	
				<div class="header Examination_header">
					<span><strong class="Examination_header_color"><?php echo esc_attr_e( 'Examination Hall Ticket', 'school-mgt' ) ;?></strong></span>
				</div>
				
				<div class="float_width">
					<table width="100%" class="count borderpx" cellspacing ="0" cellpadding="0">
						<thead>
						</thead>
						<tbody>
							<tr>					
								<td rowspan="4" class="img_td">
								<?php
								if(empty($umetadata['meta_value']))
								{?>
									<img src="<?php echo get_option( 'smgt_student_thumb_new' ); ?>" width="100px" height="100px">
								<?php
								}
								else
								{
								?>
									<img src="<?php echo $umetadata['meta_value']; ?>" width="100px" height="100px">
								<?php
								}
								?>
								</td>
								<td colspan="2" class="border_bottom">
									<strong><?php echo esc_attr_e( 'Student Name', 'school-mgt' ) ;?> : </strong><?php echo $student_data->display_name;?></a>
								</td>			
							</tr>
							<tr>
								<td class="border_bottom_rigth" align="left">
									<strong><?php echo esc_attr_e( 'Roll No', 'school-mgt' ) ;?> : </strong><?php echo $student_data->roll_id;?>
								</td>
								<td class="border_bottom" align="left">
									<strong><?php echo esc_attr_e( 'Exam Name', 'school-mgt' ) ;?> : </strong><?php echo $exam_data->exam_name;?>									
									
								</td>
							</tr>
							<tr>
								<td class="border_bottom_rigth" align="left">
								<strong><?php echo esc_attr_e( 'Class Name', 'school-mgt' ) ;?></strong><?php echo mj_smgt_get_class_name($student_data->class_name);?>
									
								</td>
								<td class="border_bottom" align="left">
									<strong><?php echo esc_attr_e( 'Section Name', 'school-mgt' ) ;?> : </strong>
									<?php 
										$section_name=$student_data->class_section;
										if($section_name!=""){
											echo mj_smgt_get_section_name($section_name); 
										}
										else
										{
											esc_attr_e('No Section','school-mgt');;
										}
									?> 				
								</td>
							</tr>
							<tr>
								<td class="border_rigth" align="left">
									<strong><?php echo esc_attr_e( 'Start Date', 'school-mgt' ) ;?> : </strong><?php echo mj_smgt_getdate_in_input_box($exam_data->exam_start_date);?>
								</td>
								<td class="border_bottom_0" align="left">
									<strong><?php echo esc_attr_e( 'End Date', 'school-mgt' ) ;?> : </strong><?php echo mj_smgt_getdate_in_input_box($exam_data->exam_end_date);?>	
								</td>
							</tr>
						</tbody>
						<tfoot>
						</tfoot>
					</table>
				</div>
				<div class="padding_top_20 float_width">
					<table width="100%" class="count borderpx" cellspacing ="0" cellpadding="0">
						<thead>
						</thead>
						<tbody>
							<tr>					
								<td class="border_bottom">
									<strong><?php echo esc_attr_e( 'Examination Centre', 'school-mgt' ) ;?> : </strong>
									<?php echo $exam_hall_name;?>, <?php echo get_option( 'smgt_school_name' ) ;?>				
								</td>
							</tr>
							<tr>
								<td class="border_bottom_0">
									<strong><?php echo esc_attr_e( 'Examination Centre Address', 'school-mgt' ) ;?> : </strong><?php echo get_option( 'smgt_school_address' ); ?>
								</td>
							</tr>
						</tbody>
						<tfoot>
						</tfoot>
					</table>
				</div>
				<div class="padding_top_20 float_width">
					<table width="100%" class="count borderpx" cellspacing ="0" cellpadding="0">
						<thead>
							<tr>
								<th colspan="5" class="border_bottom">
									<?php echo esc_attr_e( 'Time Table For Exam Hall', 'school-mgt' ) ;?>								
								</th>
							</tr>
							<tr>
								<th class="main_td border_rigth"><?php echo esc_attr_e( 'Subject Code', 'school-mgt' ) ;?></th>
								<th class="main_td border_rigth"><?php echo esc_attr_e( 'Subject', 'school-mgt' ) ;?></th>
								<th class="main_td border_rigth"><?php echo esc_attr_e( 'Exam Date', 'school-mgt' ) ;?></th>
								<th class="main_td border_rigth"><?php echo esc_attr_e( 'Exam Time', 'school-mgt' ) ;?></th>
								<th class="main_td border_rigth"><?php echo esc_attr_e( 'Examiner Sign.', 'school-mgt' ) ;?></th>
							</tr>
						</thead>
						<tbody>
					   <?php
						if(!empty($exam_time_table))
						{
							foreach($exam_time_table  as $retrieved_data)
							{
							?>
							<tr>
								<td class="main_td border_rigth"><?php echo mj_smgt_get_single_subject_code($retrieved_data->subject_id); ?> </td>
								<td class="main_td border_rigth"><?php echo mj_smgt_get_single_subject_name($retrieved_data->subject_id);  ?></td>
								<td class="main_td border_rigth"><?php echo mj_smgt_getdate_in_input_box($retrieved_data->exam_date); ?> </td>
								<?php 
								$start_time_data = explode(":", $retrieved_data->start_time);
								$start_hour=str_pad($start_time_data[0],2,"0",STR_PAD_LEFT);
								$start_min=str_pad($start_time_data[1],2,"0",STR_PAD_LEFT);
								$start_am_pm=$start_time_data[2];
								$start_time=$start_hour.':'.$start_min.' '.$start_am_pm;
									
								$end_time_data = explode(":", $retrieved_data->end_time);
								$end_hour=str_pad($end_time_data[0],2,"0",STR_PAD_LEFT);
								$end_min=str_pad($end_time_data[1],2,"0",STR_PAD_LEFT);
								$end_am_pm=$end_time_data[2];
								$end_time=$end_hour.':'.$end_min.' '.$end_am_pm;
								?>
								
								<td class="main_td border_rigth"><?php echo $start_time;  ?> <?php echo esc_attr_e( 'To', 'school-mgt' ) ;?> <?php echo $end_time; ?></td>
								<td class="main_td border_rigth"></td>
							</tr>
								<?php 
							}
						}
						else
						{ ?>
							<tr>
								<td class="main_td" colspan="5"><?php echo esc_attr_e( 'No Data Available', 'school-mgt' ) ;?> </td>
							</tr>
						<?php 
						}
					   ?>
						</tbody>
						<tfoot>
						</tfoot>
					</table>
				</div>	
				<div class="resultdate">
					<hr color="#97C4E7">
					<span><?php echo esc_attr_e( 'Student Signature', 'school-mgt' ) ;?></span>
				</div>
				<div class="signature">
					<hr color="#97C4E7">
					<span><?php echo esc_attr_e( 'Authorized Signature', 'school-mgt' ) ;?></span>
				</div>
			
			</div>
		</div>
		<!---RTL ENDS-->
		<?php
		} 
		else 
		{
			?>
			<div class="modal-body">
			<div id="exam_receipt_print" class="exam_receipt_print"> 
				
				<div class="header_logo">
					<div class="header_logo"><img class="max_height_100" src="<?php echo get_option( 'smgt_school_logo' ) ?>"></div>
					<h4 class="header_logo font_22"><strong class="header_color"><?php  echo get_option( 'smgt_school_name' );?></strong></h4>
				</div>	
				<div class="header Examination_header">
					<span><strong class="Examination_header_color"><?php echo esc_attr_e( 'Examination Hall Ticket', 'school-mgt' ) ;?></strong></span>
				</div>
				
				<div class="float_width">
					<table width="100%" class="count borderpx" cellspacing ="0" cellpadding="0">
						<thead>
						</thead>
						<tbody>
							<tr>					
								<td rowspan="4" class="img_td">
								<?php
								if(empty($umetadata))
								{?>
									<img src="<?php echo get_option( 'smgt_student_thumb_new' ); ?>" width="100px" height="100px">
								<?php
								}
								else
								{
								?>
									<img src="<?php echo $umetadata; ?>" width="100px" height="100px">
								<?php
								}
								?>
								</td>
								<td colspan="2" class="border_bottom">
									<strong><?php echo esc_attr_e( 'Student Name', 'school-mgt' ) ;?> : </strong><?php echo $student_data->display_name;?></a>
								</td>			
							</tr>
							<tr>
								<td class="border_bottom_rigth" align="left">
									<strong><?php echo esc_attr_e( 'Roll No', 'school-mgt' ) ;?> : </strong><?php echo $student_data->roll_id;?>
								</td>
								<td class="border_bottom" align="left">
									<strong><?php echo esc_attr_e( 'Exam Name', 'school-mgt' ) ;?> : </strong><?php echo $exam_data->exam_name;?>									
									
								</td>
							</tr>
							<tr>
								<td class="border_bottom_rigth" align="left">
								<strong><?php echo esc_attr_e( 'Class Name', 'school-mgt' ) ;?> : </strong><?php echo mj_smgt_get_class_name($student_data->class_name);?>
									
								</td>
								<td class="border_bottom" align="left">
									<strong><?php echo esc_attr_e( 'Section Name', 'school-mgt' ) ;?> : </strong>
									<?php 
										$section_name=$student_data->class_section;
										if($section_name!=""){
											echo mj_smgt_get_section_name($section_name); 
										}
										else
										{
											esc_attr_e('No Section','school-mgt');;
										}
									?> 				
								</td>
							</tr>
							<tr>
								<td class="border_rigth" align="left">
									<strong><?php echo esc_attr_e( 'Start Date', 'school-mgt' ) ;?> : </strong><?php echo mj_smgt_getdate_in_input_box($exam_data->exam_start_date);?>
								</td>
								<td class="border_bottom_0" align="left">
									<strong><?php echo esc_attr_e( 'End Date', 'school-mgt' ) ;?> : </strong><?php echo mj_smgt_getdate_in_input_box($exam_data->exam_end_date);?>	
								</td>
							</tr>
						</tbody>
						<tfoot>
						</tfoot>
					</table>
				</div>
				<div class="padding_top_20 float_width">
					<table width="100%" class="count borderpx" cellspacing ="0" cellpadding="0">
						<thead>
						</thead>
						<tbody>
							<tr>					
								<td class="border_bottom">
									<strong><?php echo esc_attr_e( 'Examination Centre', 'school-mgt' ) ;?> : </strong>
									<?php echo $exam_hall_name;?>, <?php echo get_option( 'smgt_school_name' ) ;?>				
								</td>
							</tr>
							<tr>
								<td class="border_bottom_0">
									<strong><?php echo esc_attr_e( 'Examination Centre Address', 'school-mgt' ) ;?> : </strong><?php echo get_option( 'smgt_school_address' ); ?>
								</td>
							</tr>
						</tbody>
						<tfoot>
						</tfoot>
					</table>
				</div>
				<div class="padding_top_20 float_width">
					<table width="100%" class="count borderpx" cellspacing ="0" cellpadding="0">
						<thead>
							<tr>
								<th colspan="5" class="border_bottom">
									<?php echo esc_attr_e( 'Time Table For Exam Hall', 'school-mgt' ) ;?>								
								</th>
							</tr>
							<tr>
								<th class="main_td border_rigth"><?php echo esc_attr_e( 'Subject Code', 'school-mgt' ) ;?></th>
								<th class="main_td border_rigth"><?php echo esc_attr_e( 'Subject', 'school-mgt' ) ;?></th>
								<th class="main_td border_rigth"><?php echo esc_attr_e( 'Exam Date', 'school-mgt' ) ;?></th>
								<th class="main_td border_rigth"><?php echo esc_attr_e( 'Exam Time', 'school-mgt' ) ;?></th>
								<th class="main_td border_rigth"><?php echo esc_attr_e( 'Examiner Sign.', 'school-mgt' ) ;?></th>
							</tr>
						</thead>
						<tbody>
					   <?php
						if(!empty($exam_time_table))
						{
							foreach($exam_time_table  as $retrieved_data)
							{
							?>
							<tr>
								<td class="main_td border_rigth"><?php echo mj_smgt_get_single_subject_code($retrieved_data->subject_id); ?> </td>
								<td class="main_td border_rigth"><?php echo mj_smgt_get_single_subject_name($retrieved_data->subject_id);  ?></td>
								<td class="main_td border_rigth"><?php echo mj_smgt_getdate_in_input_box($retrieved_data->exam_date); ?> </td>
								<?php 
								$start_time_data = explode(":", $retrieved_data->start_time);
								$start_hour=str_pad($start_time_data[0],2,"0",STR_PAD_LEFT);
								$start_min=str_pad($start_time_data[1],2,"0",STR_PAD_LEFT);
								$start_am_pm=$start_time_data[2];
								$start_time=$start_hour.':'.$start_min.' '.$start_am_pm;
									
								$end_time_data = explode(":", $retrieved_data->end_time);
								$end_hour=str_pad($end_time_data[0],2,"0",STR_PAD_LEFT);
								$end_min=str_pad($end_time_data[1],2,"0",STR_PAD_LEFT);
								$end_am_pm=$end_time_data[2];
								$end_time=$end_hour.':'.$end_min.' '.$end_am_pm;
								?>
								
								<td class="main_td border_rigth"><?php echo $start_time;  ?> <?php echo esc_attr_e( 'To', 'school-mgt' ) ;?> <?php echo $end_time; ?></td>
								<td class="main_td border_rigth"></td>
							</tr>
								<?php 
							}
						}
						else
						{ ?>
							<tr>
								<td class="main_td" colspan="5"><?php echo esc_attr_e( 'No Data Available', 'school-mgt' ) ;?> </td>
							</tr>
						<?php 
						}
					   ?>
						</tbody>
						<tfoot>
						</tfoot>
					</table>
				</div>	
				<div class="resultdate">
					<hr color="#97C4E7">
					<span><?php echo esc_attr_e( 'Student Signature', 'school-mgt' ) ;?></span>
				</div>
				<div class="signature">
					<hr color="#97C4E7">
					<span><?php echo esc_attr_e( 'Authorized Signature', 'school-mgt' ) ;?></span>
				</div>
			
			</div>
		</div>
			<?php
		}
		?>
		
	<?php 
}
 
function mj_smgt_get_exam_hall_name($student_id,$exam_id)
{
	global $wpdb;
	$table_name_smgt_exam_hall_receipt = $wpdb->prefix . "smgt_exam_hall_receipt";
	$result = $wpdb->get_row("select * from $table_name_smgt_exam_hall_receipt where exam_id=$exam_id and user_id=".$student_id);
	return $result;
}
function mj_smgt_get_hall_name($hall_id)
{
	global $wpdb;
	$table_name_hall = $wpdb->prefix . "hall";
	$result = $wpdb->get_row("select * from $table_name_hall where hall_id=".$hall_id);
	return $result->hall_name;
}
function mj_smgt_get_hall_capacity($hall_id)
{
	global $wpdb;
	$table_name_hall = $wpdb->prefix . "hall";
	$result = $wpdb->get_row("select hall_capacity from $table_name_hall where hall_id=".$hall_id);
	return $result->hall_name;
}
function mj_smgt_student_exam_receipt_pdf($student_id,$exam_id)
{
	$student_data=get_userdata($student_id);
	
	$umetadata=mj_smgt_get_user_image($student_id);
	
	$exam_data= mj_smgt_get_exam_by_id($exam_id);
	
	$exam_hall_data=mj_smgt_get_exam_hall_name($student_id,$exam_id);
	$exam_hall_name=mj_smgt_get_hall_name($exam_hall_data->hall_id);
	
	$obj_exam=new smgt_exam;
	$exam_time_table=$obj_exam->mj_smgt_get_exam_time_table_by_exam($exam_id);
  
?>
<style>
 table, .header, span.sign {
    font-family: sans-serif;
    font-size: 12px;
    color: #444;
}
.borderpx {
    border: 1px solid #97C4E7;
}
.count td, .count th {
    padding-left: 10px;
    height: 40px;
}
.resultdate {
    float: left;
    width: 200px;
    padding-top: 100px;
    text-align: center;
}
.signature {
    float: right;
    width: 200px;
    padding-top: 100px;
    text-align: center;
}
.exam_receipt_print{
	width: 90%;
	margin:0 auto;
}
.header_logo{
	float:left;
	width: 100%;
	text-align:center;
}
.font_22
{
	font-size:22px;
}
.Examination_header
{
	float:left; 
	width: 100%;
	font-size:18px;
	text-align:center;
	padding-bottom: 20px;
}
.Examination_header_color{
	color:#970606;
}
.float_width
{
	float:left; 
	width: 100%;
}
.padding_top_20
{
	padding-top:20px;
}
.img_td
{
	text-align:center;
	border-right : 1px solid #97C4E7;
}
.border_bottom{
	border-bottom : 1px solid #97C4E7;
}
.border_bottom_0{
	border-bottom : 0px;
}
.border_bottom_rigth{
	border-bottom : 1px solid #97C4E7;
	border-right : 1px solid #97C4E7;
}
.border_rigth{
	border-right : 1px solid #97C4E7;
}
.main_td
{
	text-align:center;
	border-bottom : 1px solid #97C4E7;
}
.hr_color{
	color:#97C4E7;
}
.header_color{
	color:#204759;
}
.max_height_100
{
	max-height:100px;
}
.tr_back_color
{
	background-color:#337AB7;
}
.color_white{
	color:white;
}
</style>
		<?php
		if (is_rtl()){
		?>	
		<div class="modal-body" style="direction: rtl;">
			<div id="exam_receipt_print" class="exam_receipt_print"> 
				
				<div class="header_logo" style="">
					<div class="header_logo" style=""><img class="max_height_100" src="<?php echo get_option( 'smgt_school_logo' ) ?>"></div>
					<h4 class="header_logo font_22" style=""><strong class="header_color"><?php  echo get_option( 'smgt_school_name' );?></strong></h4>
				</div>	
				<div class="header Examination_header">
					<span><strong class="Examination_header_color"><?php echo esc_attr_e( 'Examination Hall Ticket', 'school-mgt' ) ;?></strong></span>
				</div>
				
				<div class="float_width">
					<table width="100%" class="count borderpx" cellspacing ="0" cellpadding="0">
						<thead>
						</thead>
						<tbody>
							<tr>					
								<td rowspan="4" class="img_td">
								<?php
								if(empty($umetadata))
								{?>
									<img src="<?php echo get_option( 'smgt_student_thumb_new' ); ?>" width="100px" height="100px">
								<?php
								}
								else
								{
								?>
									<img src="<?php echo $umetadata; ?>" width="100px" height="100px">
								<?php
								}
								?>
								</td>
								<td colspan="2" class="border_bottom">
									<strong><?php echo esc_attr_e( 'Student Name', 'school-mgt' ) ;?> : </strong><?php echo $student_data->display_name;?></a></td>			
								</td>
							</tr>
							<tr>
								<td class="border_bottom_rigth" align="left">
									<strong><?php echo esc_attr_e( 'Roll No : ', 'school-mgt' ) ;?> : </strong><?php echo $student_data->roll_id;?>
								</td>
								<td class="border_bottom" align="left">
									<strong><?php echo esc_attr_e( 'Exam Name', 'school-mgt' ) ;?> : </strong><?php echo $exam_data->exam_name;?>									
									
								</td>
							</tr>
							<tr>
								<td class="border_bottom_rigth" align="left">
								<strong><?php echo esc_attr_e( 'Class Name', 'school-mgt' ) ;?> : </strong><?php echo mj_smgt_get_class_name($student_data->class_name);?>
									
								</td>
								<td class="border_bottom" align="left">
									<strong><?php echo esc_attr_e( 'Section Name', 'school-mgt' ) ;?> : </strong>
									<?php 
										$section_name=$student_data->class_section;
										if($section_name!=""){
											echo mj_smgt_get_section_name($section_name); 
										}
										else
										{
											esc_attr_e('No Section','school-mgt');;
										}
									?> 				
								</td>
							</tr>
							<tr>
								<td class="border_rigth" align="left">
									<strong><?php echo esc_attr_e( 'Start Date', 'school-mgt' ) ;?> : </strong><?php echo mj_smgt_getdate_in_input_box($exam_data->exam_start_date);?>
								</td>
								<td class="border_bottom_0" align="left">
									<strong><?php echo esc_attr_e( 'End Date', 'school-mgt' ) ;?> : </strong><?php echo mj_smgt_getdate_in_input_box($exam_data->exam_end_date);?>	
								</td>
							</tr>
						</tbody>
						<tfoot>
						</tfoot>
					</table>
				</div>
				<div class="padding_top_20 float_width">
					<table width="100%" class="count borderpx" cellspacing ="0" cellpadding="0" >
						<thead>
						</thead>
						<tbody>
							<tr>					
								<td class="border_bottom">
									<strong><?php echo esc_attr_e( 'Examination Centre', 'school-mgt' ) ;?> : </strong>
									<?php echo $exam_hall_name;?>, <?php echo get_option( 'smgt_school_name' ) ;?>				
								</td>
							</tr>
							<tr>
								<td class="border_bottom_0">
									<strong><?php echo esc_attr_e( 'Examination Centre Address', 'school-mgt' ) ;?> : </strong><?php echo get_option( 'smgt_school_address' ); ?>
								</td>
							</tr>
						</tbody>
						<tfoot>
						</tfoot>
					</table>
				</div>
				<div class="padding_top_20 float_width">
					<table width="100%" cellspacing ="0" cellpadding="0" class="count borderpx">
						<thead>
							<tr>
								<th colspan="5" class="border_bottom">
									<?php echo esc_attr_e( 'Time Table For Exam Hall', 'school-mgt' ) ;?>								
								</th>
							</tr>
							<tr class="tr_back_color">
								<th class="main_td color_white border_rigth"><?php echo esc_attr_e( 'Subject Code', 'school-mgt' ) ;?></th>
								<th class="main_td color_white border_rigth"><?php echo esc_attr_e( 'Subject', 'school-mgt' ) ;?></th>
								<th class="main_td color_white border_rigth"><?php echo esc_attr_e( 'Exam Date', 'school-mgt' ) ;?></th>
								<th class="main_td color_white border_rigth"><?php echo esc_attr_e( 'Exam Time', 'school-mgt' ) ;?></th>
								<th class="main_td color_white border_rigth"><?php echo esc_attr_e( 'Examiner Sign.', 'school-mgt' ) ;?></th>
							</tr>
						</thead>
						<tbody>
					   <?php
						if(!empty($exam_time_table))
						{
							foreach($exam_time_table  as $retrieved_data)
							{
							?>
							<tr>
								<td class="main_td border_rigth"><?php echo mj_smgt_get_single_subject_code($retrieved_data->subject_id); ?> </td>
								<td class="main_td border_rigth"><?php echo mj_smgt_get_single_subject_name($retrieved_data->subject_id);  ?></td>
								<td class="main_td border_rigth"><?php echo mj_smgt_getdate_in_input_box($retrieved_data->exam_date); ?> </td>
								<?php 
								
								$start_time_data = explode(":", $retrieved_data->start_time);
								$start_hour=str_pad($start_time_data[0],2,"0",STR_PAD_LEFT);
								$start_min=str_pad($start_time_data[1],2,"0",STR_PAD_LEFT);
								$start_am_pm=$start_time_data[2];
								$start_time=$start_hour.':'.$start_min.' '.$start_am_pm;
									
								$end_time_data = explode(":", $retrieved_data->end_time);
								$end_hour=str_pad($end_time_data[0],2,"0",STR_PAD_LEFT);
								$end_min=str_pad($end_time_data[1],2,"0",STR_PAD_LEFT);
								$end_am_pm=$end_time_data[2];
								$end_time=$end_hour.':'.$end_min.' '.$end_am_pm;
								?>
								<td class="main_td border_rigth"><?php echo $start_time;  ?> <?php echo esc_attr_e( 'To', 'school-mgt' ) ;?> <?php echo $end_time; ?></td>
								<td class="main_td border_rigth"></td>
							</tr>
								<?php 
							}
						}
					   ?>
						</tbody>
						<tfoot>
						</tfoot>
					</table>
				</div>	
				<div class="resultdate">
					<hr color="#97C4E7">
					<span><?php echo esc_attr_e( 'Student Signature', 'school-mgt' ) ;?></span>
				</div>
				<div class="signature">
					<hr color="#97C4E7">
					<span><?php echo esc_attr_e( 'Authorized Signature', 'school-mgt' ) ;?></span>
				</div>
			
			</div>
		</div>
		<!-- RTL END --->
		<?php
		}
		else {
			?>
		<div class="modal-body">
			<div id="exam_receipt_print" class="exam_receipt_print"> 
				
				<div class="header_logo" style="">
					<div class="header_logo" style=""><img class="max_height_100" src="<?php echo get_option( 'smgt_school_logo' ) ?>"></div>
					<h4 class="header_logo font_22" style=""><strong class="header_color"><?php  echo get_option( 'smgt_school_name' );?></strong></h4>
				</div>	
				<div class="header Examination_header">
					<span><strong class="Examination_header_color"><?php echo esc_attr_e( 'Examination Hall Ticket', 'school-mgt' ) ;?></strong></span>
				</div>
				
				<div class="float_width">
					<table width="100%" class="count borderpx" cellspacing ="0" cellpadding="0">
						<thead>
						</thead>
						<tbody>
							<tr>					
								<td rowspan="4" class="img_td">
								<?php
								if(empty($umetadata))
								{?>
									<img src="<?php echo get_option( 'smgt_student_thumb_new' ); ?>" width="100px" height="100px">
								<?php
								}
								else
								{
								?>
									<img src="<?php echo $umetadata; ?>" width="100px" height="100px">
								<?php
								}
								?>
								</td>
								<td colspan="2" class="border_bottom">
									<strong><?php echo esc_attr_e( 'Student Name', 'school-mgt' ) ;?> : </strong><?php echo $student_data->display_name;?></a></td>			
								</td>
							</tr>
							<tr>
								<td class="border_bottom_rigth" align="left">
									<strong><?php echo esc_attr_e( 'Roll No', 'school-mgt' ) ;?> : </strong><?php echo $student_data->roll_id;?>
								</td>
								<td class="border_bottom" align="left">
									<strong><?php echo esc_attr_e( 'Exam Name', 'school-mgt' ) ;?> : </strong><?php echo $exam_data->exam_name;?>									
									
								</td>
							</tr>
							<tr>
								<td class="border_bottom_rigth" align="left">
								<strong><?php echo esc_attr_e( 'Class Name', 'school-mgt' ) ;?> : </strong><?php echo mj_smgt_get_class_name($student_data->class_name);?>
									
								</td>
								<td class="border_bottom" align="left">
									<strong><?php echo esc_attr_e( 'Section Name', 'school-mgt' ) ;?> : </strong>
									<?php 
										$section_name=$student_data->class_section;
										if($section_name!=""){
											echo mj_smgt_get_section_name($section_name); 
										}
										else
										{
											esc_attr_e('No Section','school-mgt');;
										}
									?> 				
								</td>
							</tr>
							<tr>
								<td class="border_rigth" align="left">
									<strong><?php echo esc_attr_e( 'Start Date', 'school-mgt' ) ;?> : </strong><?php echo mj_smgt_getdate_in_input_box($exam_data->exam_start_date);?>
								</td>
								<td class="border_bottom_0" align="left">
									<strong><?php echo esc_attr_e( 'End Date', 'school-mgt' ) ;?> : </strong><?php echo mj_smgt_getdate_in_input_box($exam_data->exam_end_date);?>	
								</td>
							</tr>
						</tbody>
						<tfoot>
						</tfoot>
					</table>
				</div>
				<div class="padding_top_20 float_width">
					<table width="100%" class="count borderpx" cellspacing ="0" cellpadding="0" >
						<thead>
						</thead>
						<tbody>
							<tr>					
								<td class="border_bottom">
									<strong><?php echo esc_attr_e( 'Examination Centre', 'school-mgt' ) ;?> : </strong>
									<?php echo $exam_hall_name;?>, <?php echo get_option( 'smgt_school_name' ) ;?>				
								</td>
							</tr>
							<tr>
								<td class="border_bottom_0">
									<strong><?php echo esc_attr_e( 'Examination Centre Address', 'school-mgt' ) ;?> : </strong><?php echo get_option( 'smgt_school_address' ); ?>
								</td>
							</tr>
						</tbody>
						<tfoot>
						</tfoot>
					</table>
				</div>
				<div class="padding_top_20 float_width">
					<table width="100%" cellspacing ="0" cellpadding="0" class="count borderpx">
						<thead>
							<tr>
								<th colspan="5" class="border_bottom">
									<?php echo esc_attr_e( 'Time Table For Exam Hall', 'school-mgt' ) ;?>								
								</th>
							</tr>
							<tr class="tr_back_color">
								<th class="main_td color_white border_rigth"><?php echo esc_attr_e( 'Subject Code', 'school-mgt' ) ;?></th>
								<th class="main_td color_white border_rigth"><?php echo esc_attr_e( 'Subject', 'school-mgt' ) ;?></th>
								<th class="main_td color_white border_rigth"><?php echo esc_attr_e( 'Exam Date', 'school-mgt' ) ;?></th>
								<th class="main_td color_white border_rigth"><?php echo esc_attr_e( 'Exam Time', 'school-mgt' ) ;?></th>
								<th class="main_td color_white border_rigth"><?php echo esc_attr_e( 'Examiner Sign.', 'school-mgt' ) ;?></th>
							</tr>
						</thead>
						<tbody>
					   <?php
						if(!empty($exam_time_table))
						{
							foreach($exam_time_table  as $retrieved_data)
							{
							?>
							<tr>
								<td class="main_td border_rigth"><?php echo mj_smgt_get_single_subject_code($retrieved_data->subject_id); ?> </td>
								<td class="main_td border_rigth"><?php echo mj_smgt_get_single_subject_name($retrieved_data->subject_id);  ?></td>
								<td class="main_td border_rigth"><?php echo mj_smgt_getdate_in_input_box($retrieved_data->exam_date); ?> </td>
								<?php 
								
								$start_time_data = explode(":", $retrieved_data->start_time);
								$start_hour=str_pad($start_time_data[0],2,"0",STR_PAD_LEFT);
								$start_min=str_pad($start_time_data[1],2,"0",STR_PAD_LEFT);
								$start_am_pm=$start_time_data[2];
								$start_time=$start_hour.':'.$start_min.' '.$start_am_pm;
									
								$end_time_data = explode(":", $retrieved_data->end_time);
								$end_hour=str_pad($end_time_data[0],2,"0",STR_PAD_LEFT);
								$end_min=str_pad($end_time_data[1],2,"0",STR_PAD_LEFT);
								$end_am_pm=$end_time_data[2];
								$end_time=$end_hour.':'.$end_min.' '.$end_am_pm;
								?>
								<td class="main_td border_rigth"><?php echo $start_time;  ?> <?php echo esc_attr_e( 'To', 'school-mgt' ) ;?> <?php echo $end_time; ?></td>
								<td class="main_td border_rigth"></td>
							</tr>
								<?php 
							}
						}
					   ?>
						</tbody>
						<tfoot>
						</tfoot>
					</table>
				</div>	
				<div class="resultdate">
					<hr color="#97C4E7">
					<span><?php echo esc_attr_e( 'Student Signature', 'school-mgt' ) ;?></span>
				</div>
				<div class="signature">
					<hr color="#97C4E7">
					<span><?php echo esc_attr_e( 'Authorized Signature', 'school-mgt' ) ;?></span>
				</div>
			
			</div>
		</div>
		<?php
		}
}
//Generate Room ID
function mj_smgt_generate_room_code()
{
	global $wpdb;
	$user_tbl = $wpdb->prefix . "smgt_room";
	$last = $wpdb->get_row("SHOW TABLE STATUS LIKE '{$user_tbl}'");
	$lastid = $last->Auto_increment; 
	$code = 'RM'.''.sprintf('00'.$lastid);
	return $code;	
}
//Generate Room ID
function mj_smgt_generate_bed_code()
{
	global $wpdb;
	$smgt_beds = $wpdb->prefix . "smgt_beds";
	$last = $wpdb->get_row("SHOW TABLE STATUS LIKE '{$smgt_beds}'");
	$lastid = $last->Auto_increment; 
	$code = 'BD'.''.sprintf('00'.$lastid);
	return $code;	
}
function mj_smgt_get_hostel_name_by_id($id)
{
	global $wpdb;
	$smgt_hostel = $wpdb->prefix . "smgt_hostel";
	$result = $wpdb->get_row("SELECT * From $smgt_hostel where id=".$id);
	if($result)
	{
		return $hostel_name = $result->hostel_name; 
	}
	else
	{
		return "N/A";
	}
}
function mj_smgt_get_room_unique_id_by_id($id)
{
	global $wpdb;
	$smgt_room = $wpdb->prefix . "smgt_room";
	$result = $wpdb->get_row("SELECT * From $smgt_room where id=".$id);
	if($result)
	{
		return $room_unique_id = $result->room_unique_id; 
	}
}
function mj_smgt_get_bed_capacity_by_id($id)
{
	global $wpdb;
	$smgt_room = $wpdb->prefix . "smgt_room";
	$result = $wpdb->get_row("SELECT * From $smgt_room where id=".$id);
	return $bed_capacity = $result->beds_capacity; 
}
function mj_smgt_hostel_room_bed_count($id)
{
	global $wpdb;
	$smgt_beds = $wpdb->prefix . "smgt_beds";
	$result_bed=$wpdb->get_results("SELECT * FROM $smgt_beds where room_id=".$id);
	$bed_count= count($result_bed);
	return $bed_count; 
}
function mj_smgt_hostel_room_status_check($room_id)
{
	global $wpdb;
	$smgt_room = $wpdb->prefix . "smgt_room";
	$smgt_beds = $wpdb->prefix . "smgt_beds";
	$result=$wpdb->get_results("SELECT * FROM $smgt_room where id=".$room_id);
	$final_cnt=0;
	if(!empty($result))
	{
		foreach($result as $data)
		{
			$bed_capacity=$data->beds_capacity;
			$room_id_id=$data->id;
			$result_room=$wpdb->get_results("SELECT * FROM $smgt_beds where room_id=$room_id_id and bed_status=1");
		}
		$final_cnt = count($result_room);
	}
	
	return $final_cnt;
}

//send invoice generated pdf in mail
function mj_smgt_send_mail_receipt_pdf($emails,$subject,$message,$student_id,$exam_id)
{	
	$document_dir = WP_CONTENT_DIR;
	$document_dir .= '/uploads/exam_receipt/';
	$document_path = $document_dir;
	if (!file_exists($document_path))
	{
		mkdir($document_path, 0777, true);		
	}
	$student_data=get_userdata($student_id);
	
	$umetadata=mj_smgt_get_user_image($student_id);
	
	$exam_data= mj_smgt_get_exam_by_id($exam_id);
	
	$exam_hall_data=mj_smgt_get_exam_hall_name($student_id,$exam_id);
	$exam_hall_name=mj_smgt_get_hall_name($exam_hall_data->hall_id);
	
	$obj_exam=new smgt_exam;
	$exam_time_table=$obj_exam->mj_smgt_get_exam_time_table_by_exam($exam_id);
	require_once SMS_PLUGIN_DIR . '/lib/mpdf/vendor/autoload.php';
	$mpdf = new Mpdf\Mpdf;
	//$mpdf=new mPDF();
	// echo '<link rel="stylesheet" href="'.plugins_url( '/assets/css/bootstrap.min.css', __FILE__).'"></link>';
  
	// echo '<script  rel="javascript" src="'.plugins_url( '/assets/js/bootstrap.min.js', __FILE__).'"></script>'; 

		
	$stylesheet = file_get_contents(SMS_PLUGIN_DIR. '/assets/css/receipt_pdf_mail.css'); // Get css content
	$mpdf->WriteHTML('<html>');
	$mpdf->WriteHTML('<head>');
	$mpdf->WriteHTML('<style></style>');
	$mpdf->WriteHTML($stylesheet,1); // Writing style to pdf
	$mpdf->WriteHTML('</head>');
	$mpdf->WriteHTML('<body>');		
	//$mpdf->SetTitle('Invoice');
		$mpdf->WriteHTML('<div class="modal-body">');
			$mpdf->WriteHTML('<div id="exam_receipt_print" class="exam_receipt_print">');
				$mpdf->WriteHTML('<div class="header_logo" style="">');
					$mpdf->WriteHTML('<div class="header_logo" style=""><img class="max_height_100" src="'.get_option( 'smgt_school_logo' ).'"></div>');
					$mpdf->WriteHTML('<h4 class="header_logo font_22" style=""><strong class="header_color">'.get_option( 'smgt_school_name' ).'</strong></h4></div>');
				$mpdf->WriteHTML('<div class="header Examination_header"><span><strong class="Examination_header_color">'. esc_attr__( 'Examination Hall Ticket', 'school-mgt' ).'</strong></span></div>');
				
				$mpdf->WriteHTML('<div class="float_width">');
					$mpdf->WriteHTML('<table width="100%" class="count borderpx" cellspacing ="0" cellpadding="0">');
						$mpdf->WriteHTML('<thead>');
						$mpdf->WriteHTML('</thead>');
						$mpdf->WriteHTML('<tbody>');
						$mpdf->WriteHTML('<tr>');					
								$mpdf->WriteHTML('<td rowspan="4" class="img_td">');
								if(empty($umetadata))
								{ 
									$mpdf->WriteHTML('<img src="'.get_option( 'smgt_student_thumb_new' ).'" width="100px" height="100px">');
								}
								else
								{
									$mpdf->WriteHTML('<img src="'.$umetadata.'" width="100px" height="100px">');
								}
								$mpdf->WriteHTML('</td>');
								$mpdf->WriteHTML('<td colspan="2" class="border_bottom">');
									$mpdf->WriteHTML('<strong>'. esc_attr__( 'Student Name', 'school-mgt' ).' : </strong>'.$student_data->display_name.'</td>');
								$mpdf->WriteHTML('</td>');
							$mpdf->WriteHTML('</tr>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="border_bottom_rigth" align="left">');
									$mpdf->WriteHTML('<strong>'. esc_attr__( 'Roll No', 'school-mgt' ).' : </strong>'.$student_data->roll_id.'
								</td>');
								$mpdf->WriteHTML('<td class="border_bottom" align="left">');
									$mpdf->WriteHTML('<strong>'. esc_attr__( 'Exam Name', 'school-mgt' ).' : </strong>'.$exam_data->exam_name.'</td>');
							$mpdf->WriteHTML('</tr>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="border_bottom_rigth" align="left">');
							$mpdf->WriteHTML('<strong>'. esc_attr__( 'Class Name', 'school-mgt' ).': </strong>'.mj_smgt_get_class_name($student_data->class_name).'</td>');
								$mpdf->WriteHTML('<td class="border_bottom" align="left">');
									$mpdf->WriteHTML('<strong>'. esc_attr__( 'Section Name', 'school-mgt' ).' : </strong>');
										$section_name=$student_data->class_section;
										if($section_name!=""){
											$mpdf->WriteHTML(''.mj_smgt_get_section_name($section_name).'');
										}
										else
										{
											$mpdf->WriteHTML(''. esc_attr__('No Section','school-mgt'.''));
										}
								$mpdf->WriteHTML('</td>');
							$mpdf->WriteHTML('</tr>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="border_rigth" align="left">');
									$mpdf->WriteHTML('<strong>'. esc_attr__( 'Start Date', 'school-mgt' ).' : </strong>'.mj_smgt_getdate_in_input_box($exam_data->exam_start_date).'</td>');
								$mpdf->WriteHTML('<td class="border_bottom_0" align="left">');
									$mpdf->WriteHTML('<strong>'. esc_attr__( 'End Date', 'school-mgt' ).' : </strong>'.mj_smgt_getdate_in_input_box($exam_data->exam_end_date).'</td>');
							$mpdf->WriteHTML('</tr>');
						$mpdf->WriteHTML('</tbody>');
						$mpdf->WriteHTML('<tfoot>');
						$mpdf->WriteHTML('</tfoot>');
					$mpdf->WriteHTML('</table>');
				$mpdf->WriteHTML('</div>');
				$mpdf->WriteHTML('<div class="padding_top_20 float_width">');
					$mpdf->WriteHTML('<table width="100%" class="count borderpx" cellspacing ="0" cellpadding="0" >');
						$mpdf->WriteHTML('<thead>');
						$mpdf->WriteHTML('</thead>');
						$mpdf->WriteHTML('<tbody>');
							$mpdf->WriteHTML('<tr>');					
								$mpdf->WriteHTML('<td class="border_bottom">');
									$mpdf->WriteHTML('<strong>'. esc_attr__( 'Examination Centre', 'school-mgt' ).' : </strong>'.$exam_hall_name.','.get_option( 'smgt_school_name' ).'</td>');
							$mpdf->WriteHTML('</tr>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="border_bottom_0">');
									$mpdf->WriteHTML('<strong>'. esc_attr__( 'Examination Centre Address', 'school-mgt' ).' : </strong>'.get_option( 'smgt_school_address' ).'</td>');
							$mpdf->WriteHTML('</tr>');
						$mpdf->WriteHTML('</tbody>');
						$mpdf->WriteHTML('<tfoot>');
						$mpdf->WriteHTML('</tfoot>');
					$mpdf->WriteHTML('</table>');
				$mpdf->WriteHTML('</div>');
				$mpdf->WriteHTML('<div class="padding_top_20 float_width">');
				$mpdf->WriteHTML('<table width="100%" cellspacing ="0" cellpadding="0" class="count borderpx">');
					$mpdf->WriteHTML('<thead>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<th colspan="5" class="border_bottom">'. esc_attr__( 'Time Table For Exam Hall', 'school-mgt' ).'</th>');
							$mpdf->WriteHTML('</tr>');
							$mpdf->WriteHTML('<tr class="tr_back_color">');
								$mpdf->WriteHTML('<th class="main_td border_rigth color_white">'. esc_attr__( 'Subject Code', 'school-mgt' ).'</th>');
								$mpdf->WriteHTML('<th class="main_td border_rigth color_white">'. esc_attr__( 'Subject', 'school-mgt' ).'</th>');
								$mpdf->WriteHTML('<th class="main_td border_rigth color_white">'. esc_attr__( 'Exam Date', 'school-mgt' ).'</th>');
								$mpdf->WriteHTML('<th class="main_td border_rigth color_white">'. esc_attr__( 'Exam Time', 'school-mgt' ).'</th>');
								$mpdf->WriteHTML('<th class="main_td border_rigth color_white">'. esc_attr__( 'Examiner Sign.', 'school-mgt' ).'</th>');
							$mpdf->WriteHTML('</tr>');
						$mpdf->WriteHTML('</thead>');
						$mpdf->WriteHTML('<tbody>');
						if(!empty($exam_time_table))
						{
							foreach($exam_time_table  as $retrieved_data)
							{
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="main_td border_rigth">'.mj_smgt_get_single_subject_code($retrieved_data->subject_id).'</td>');
								$mpdf->WriteHTML('<td class="main_td border_rigth">'.mj_smgt_get_single_subject_name($retrieved_data->subject_id).'</td>');
								$mpdf->WriteHTML('<td class="main_td border_rigth">'.mj_smgt_getdate_in_input_box($retrieved_data->exam_date).'</td>');
								
								$start_time_data = explode(":", $retrieved_data->start_time);
								$start_hour=str_pad($start_time_data[0],2,"0",STR_PAD_LEFT);
								$start_min=str_pad($start_time_data[1],2,"0",STR_PAD_LEFT);
								$start_am_pm=$start_time_data[2];
								$start_time=$start_hour.':'.$start_min.' '.$start_am_pm;
								
								$end_time_data = explode(":", $retrieved_data->end_time);
								$end_hour=str_pad($end_time_data[0],2,"0",STR_PAD_LEFT);
								$end_min=str_pad($end_time_data[1],2,"0",STR_PAD_LEFT);
								$end_am_pm=$end_time_data[2];
								$end_time=$end_hour.':'.$end_min.' '.$end_am_pm;
								$mpdf->WriteHTML('<td class="main_td border_rigth">'.$start_time.''. esc_attr__( 'To', 'school-mgt' ).''.$end_time.'</td>');
								$mpdf->WriteHTML('<td class="main_td border_rigth"></td>');
							$mpdf->WriteHTML('</tr>');
							}
						}
						$mpdf->WriteHTML('</tbody>');
						$mpdf->WriteHTML('<tfoot>');
						$mpdf->WriteHTML('</tfoot>');
					$mpdf->WriteHTML('</table>');
			$mpdf->WriteHTML('</div>');
				$mpdf->WriteHTML('<div class="resultdate"><hr color="#97C4E7"><span>'. esc_attr__( 'Student Signature', 'school-mgt' ).'</span></div>');
				$mpdf->WriteHTML('<div class="signature"><hr color="#97C4E7"><span>'. esc_attr__( 'Authorized Signature', 'school-mgt' ).'</span></div>');
			$mpdf->WriteHTML('</div>');
		$mpdf->WriteHTML('</div>');
			
	$mpdf->WriteHTML('</body>');
	$mpdf->WriteHTML('</html>');	
	$mpdf->Output($document_path.'exam receipt'.$student_id.'.pdf','F');
	$mail_attachment = array($document_path.'exam receipt'.$student_id.'.pdf'); 
	
	$school=get_option('smgt_school_name');
	$headers="";
	$headers .= 'From: '.$school.' <noreplay@gmail.com>' . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";
	if(get_option('smgt_mail_notification') == '1')
	{
		wp_mail($emails,$subject,$message,$headers,$mail_attachment);
	}			
	unlink($document_path.'exam receipt'.$student_id.'.pdf');
}
function mj_smgt_student_assign_bed_data($id)
{
	global $wpdb;
	$table_smgt_assign_beds=$wpdb->prefix.'smgt_assign_beds';
	$result=$wpdb->get_row("SELECT * FROM $table_smgt_assign_beds where bed_id=".$id);
	return $result;
}
function mj_smgt_get_room_unique_id_by_room_id($room_id)
{
	global $wpdb;
	$table_smgt_room=$wpdb->prefix.'smgt_room';
	$result=$wpdb->get_row("SELECT * FROM $table_smgt_room where id=".$room_id);
	if($result)
	{
		return $result->room_unique_id;
	}
	else
	{
		return "N/A";
	}
}
function mj_smgt_get_room_type_by_room_id($room_id)
{
	global $wpdb;
	$table_smgt_room=$wpdb->prefix.'smgt_room';
	$result=$wpdb->get_row("SELECT * FROM $table_smgt_room where id=".$room_id);
	if($result)
	{
		return $result->room_category;
	}
	else
	{
		return "N/A";
	}
}
function mj_smgt_hostel_name_by_id($hostel_id)
{
	global $wpdb;
	$table_smgt_hostel=$wpdb->prefix.'smgt_hostel';
	$result=$wpdb->get_row("SELECT * FROM $table_smgt_hostel where id=".$hostel_id);
	return $result->hostel_name;
}

function mj_smgt_all_assign_student_data()
{
	global $wpdb;
	$table_smgt_assign_beds=$wpdb->prefix.'smgt_assign_beds';
	$result=$wpdb->get_results("SELECT * FROM $table_smgt_assign_beds");
	return $result;
}
function mj_smgt_send_message_check_single_user_or_multiple($post_id)
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'smgt_message';
	$sent_message =$wpdb->get_var("SELECT COUNT(*) FROM $tbl_name where post_id = $post_id ");
	return $sent_message;
}
//-------------------- VIEW PAGE POPUP -----------------------//

add_action( 'wp_ajax_mj_smgt_view_details_popup','mj_smgt_view_details_popup');
add_action( 'wp_ajax_nopriv_mj_smgt_view_details_popup','mj_smgt_view_details_popup');
//VIEW DETAILS POPUP FUNCTION
function mj_smgt_view_details_popup()
{	?>
	<style>
	.table td, .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
		padding: 15px !important;
	}
	</style>
	<?php

	$recoed_id = $_REQUEST['record_id'];
	$type= $_REQUEST['type'];

	if($type == 'transport_view')
	{ 		
		$transport_data= mj_smgt_get_transport_by_id($recoed_id);
		?>
		<div class="modal-header model_header_padding dashboard_model_header"> 
			<img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Transportation.png";  ?>" alt="" class="popup_image_before_name">
			<a href="javascript:void(0);" class="close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>
			<h4 id="myLargeModalLabel" class="modal-title"><?php esc_attr_e('Transport Details','school-mgt'); ?></h4>
		</div>	
		<div class="modal-body view_details_body_assigned_bed view_details_body">
			<div class="row">
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Route Name','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php echo $transport_data->route_name; ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Vehicle Identifier','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php echo $transport_data->number_of_vehicle; ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Vehicle Registration Number','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php echo $transport_data->vehicle_reg_num; ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Driver Name','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php echo $transport_data->driver_name; ?></label>
				</div>

				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Driver Phone Number','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php echo $transport_data->driver_phone_num; ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Driver Address','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php echo $transport_data->driver_address; ?></label>
				</div> 
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Route Fare','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php echo "<span> ". mj_smgt_get_currency_symbol() ." </span>" . number_format($transport_data->route_fare,2); ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Route Description','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php if(!empty($transport_data->route_description)) { echo $transport_data->route_description; } else { echo "N/A";} ?></label>
				</div>
			</div>
		</div>	
		<?php 
	}
	elseif($type == 'booklist_view')
	{ 	
		$obj_lib = new Smgtlibrary();	
		$book_data=$obj_lib->mj_smgt_get_single_books($recoed_id);
		?>
		<div class="modal-header model_header_padding dashboard_model_header"> 
			<img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Library.png";  ?>" alt="" class="popup_image_before_name">
			<a href="javascript:void(0);" class="close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>
			<h4 id="myLargeModalLabel" class="modal-title"><?php esc_attr_e('Book Details','school-mgt'); ?></h4>
		</div>	
		
		<div class="modal-body view_details_body_assigned_bed view_details_body">
			<div class="row">
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('ISBN','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo $book_data->ISBN; ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Book Number','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php if(!empty($book_data->book_number)){ echo $book_data->book_number; }else{ echo "N/A"; } ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Book Title','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo $book_data->book_name; ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading">
						<?php esc_attr_e('Book Category','school-mgt'); ?>
					</label><br>
					<label for="" class="label_value">
						<?php 					
							echo get_the_title($book_data->cat_id);
						?>
					</label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading">
						<?php esc_attr_e('Author Name','school-mgt'); ?>
					</label><br>
					<label for="" class="label_value">
						<?php echo $book_data->author_name; ?>	
					</label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading">
							<?php esc_attr_e('Rack Location','school-mgt'); ?>
					</label><br>
					<label for="" class="label_value">
						<?php echo get_the_title($book_data->rack_location); ?>
					</label>
				</div>
				 
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading">
						<?php esc_attr_e('Price','school-mgt'); ?>
					</label><br>
					<label for="" class="label_value">
						<?php echo "<span> ". mj_smgt_get_currency_symbol() ." </span>" . number_format($book_data->price,2); ?>
					</label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading">
						<?php esc_attr_e('Quantity','school-mgt'); ?>
					</label><br>
					<label for="" class="label_value">
						<?php echo $book_data->quentity;?>
					</label>
				</div>
				
				<div class="col-md-12 popup_padding_15px">
					<label for="" class="popup_label_heading">
						<?php esc_attr_e('Description','school-mgt'); ?>
					</label><br>
					<label for="" class="label_value">
						<?php
						$description =$book_data->description;
						$description = ltrim($description, ' ');
						 if(!empty($description)) { echo $description; } else { echo "N/A";} 
						 ?>
					</label>
				</div>
			</div>
        </div>  
		<?php 
	}
	elseif($type == 'room_view')
	{ 	
		$obj_hostel=new smgt_hostel;
		$room_data=$obj_hostel->mj_smgt_get_room_by_id($recoed_id);
		?>
		<div class="modal-header model_header_padding dashboard_model_header"> 
			<img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Room.png";  ?>" alt="" class="popup_image_before_name">
			<a href="javascript:void(0);" class="close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>
			<h4 id="myLargeModalLabel" class="modal-title"><?php esc_attr_e('Room Details','school-mgt'); ?></h4>
		</div>	
		<div class="modal-body view_details_body_assigned_bed view_details_body">
			<div class="row">
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Room Unique ID','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php echo $room_data->room_unique_id; ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Hostel Name','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php echo mj_smgt_get_hostel_name_by_id($room_data->hostel_id); ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Room Category','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php echo get_the_title($room_data->room_category);?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Beds Capacity','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php echo $room_data->beds_capacity;?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Status','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value">
						<?php
							$room_cnt =mj_smgt_hostel_room_status_check($room_data->id);
							$bed_capacity=(int)$room_data->beds_capacity;
							
							if($room_cnt >= $bed_capacity)
							{ ?>
								<label class="label_value"><?php esc_attr_e('Occupied','school-mgt');?></label>
								<?php
							}
							else 
							{ ?>
								<label class="label_value"><?php esc_attr_e('Available','school-mgt');?></label>
								<?php 
							}?>
					</label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Description','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value">
						<?php
						if(!empty($room_data->room_description))
						{
							echo $room_data->room_description; 
						}
						else
						{
							echo 'N/A';
						}
						?>
					</label>
				</div>
			</div>
		</div>	
		<?php 
	}
	elseif($type == 'Homework_view')
	{ 	
		$objj=new Smgt_Homework();
		$classdata= $objj->mj_smgt_get_edit_record($recoed_id);
		?>
		<div class="modal-header model_header_padding dashboard_model_header"> 
			<img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/homework.png";  ?>" alt="" class="popup_image_before_name">
			<a href="javascript:void(0);" class="close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>
			<h4 id="myLargeModalLabel" class="modal-title"><?php esc_attr_e('Homework Details','school-mgt'); ?></h4>
		</div>	
		<div class="modal-body view_details_body_assigned_bed view_details_body">
			<div class="row">
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Title','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php echo $classdata->title; ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Subject','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php echo mj_smgt_get_subject_byid($classdata->subject);?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Class','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php echo mj_smgt_get_class_name($classdata->class_name);?> </label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Section Name','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php if(!empty($classdata->section_id)){ echo mj_smgt_get_section_name($classdata->section_id); }else{ echo "N/A"; } ?></label>
				</div>
			
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Date','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php echo mj_smgt_getdate_in_input_box($classdata->created_date);?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Submission Date','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php echo mj_smgt_getdate_in_input_box($classdata->submition_date);?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Documents Title','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value">
						
						<?php 
							$doc_data=json_decode($classdata->homework_document);
							if(!empty($doc_data[0]->title)) 
							{ 
								echo esc_attr($doc_data[0]->title);
							}
							else
							{
								echo "N/A";
							}
						?>
					</label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Download File','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value">
						<?php
							$doc_data=json_decode($classdata->homework_document);
							if(!empty($doc_data[0]->value))
							{
								?>
								<a download href="<?php print content_url().'/uploads/school_assets/'.$doc_data[0]->value; ?>"  class="btn padding_0 popup_download_btn" record_id="<?php echo $retrieved_data->homework_id;?>"><i class="fa fa-download" id="download_icon"></i> <?php esc_attr_e('Download','school-mgt'); ?></a>
								<?php
							}
							else 
							{
								echo "N/A";
							}
						?>
					</label>
				</div>
				
				<div class="col-md-12 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Homework Content','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value">
						<?php
						if(!empty($classdata->content))
						{
							echo $classdata->content;
						}
						else
						{
							echo "N/A";
						}
						?></label>
				</div>
			</div>
		</div>	
		<?php 
	}
	elseif($type == 'Exam_view')
	{ 	
		$id=$recoed_id;
		$exam_data= mj_smgt_get_exam_by_id($recoed_id);
		?>
		<div class="modal-header model_header_padding dashboard_model_header"> 
			<img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Exam.png";  ?>" alt="" class="popup_image_before_name">
			<a href="javascript:void(0);" class="close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>
			<h4 id="myLargeModalLabel" class="modal-title"><?php esc_attr_e('Exam Details','school-mgt'); ?></h4>
		</div>	
		<div class="modal-body view_details_body_assigned_bed view_details_body">
			<div class="row">

				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Title','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo $exam_data->exam_name; ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Term','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo get_the_title($exam_data->exam_term); ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Class Name','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo mj_smgt_get_class_name($exam_data->class_id); ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Section Name','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php if(!empty($exam_data->section_id)){ echo mj_smgt_get_section_name($exam_data->section_id); }else{ echo "N/A"; } ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Total Marks','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo $exam_data->total_mark; ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Passing Marks','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo $exam_data->passing_mark; ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Start Date','school-mgt'); ?> <?php esc_attr_e('To','school-mgt'); ?> <?php esc_attr_e('End Date','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo mj_smgt_getdate_in_input_box($exam_data->exam_start_date); ?> <?php esc_attr_e('To','school-mgt'); ?> <?php echo mj_smgt_getdate_in_input_box($exam_data->exam_end_date); ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Download File','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value">
						<?php
							$doc_data=json_decode($exam_data->exam_syllabus);
							if(!empty($doc_data[0]->value))
							{
								?>
								<a download href="<?php print content_url().'/uploads/school_assets/'.$doc_data[0]->value; ?>"  class="btn padding_0 popup_download_btn" record_id="<?php echo $exam_data->exam_id;?>"><i class="fa fa-download" id="download_icon"></i> <?php esc_attr_e('Download','school-mgt'); ?></a>
								<?php
							}
							else 
							{
								echo "N/A";
							}
						?>
					</label>
				</div>
				<div class="col-md-12 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Comment','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php if(!empty($exam_data->exam_comment)){ echo $exam_data->exam_comment; }else{ echo "N/A"; } ?></label>
				</div>
			</div>
		</div>	
		<?php 
	}
	elseif($type == 'beds_view')
	{ 	
		$obj_hostel=new smgt_hostel;
		$bed_data=$obj_hostel->mj_smgt_get_bed_by_id($recoed_id);
		?>
		<div class="modal-header model_header_padding dashboard_model_header"> 
			<img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Bed.png";  ?>" alt="" class="popup_image_before_name">
			<a href="javascript:void(0);" class="close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>
			<h4 id="myLargeModalLabel" class="modal-title"><?php esc_attr_e('Beds Details','school-mgt'); ?></h4>
		</div>	
		<div class="modal-body view_details_body_assigned_bed view_details_body">
			<div class="row">
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Bed Unique ID','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php echo $bed_data->bed_unique_id; ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Room Unique ID','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php echo mj_smgt_get_room_unique_id_by_id($bed_data->room_id);?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Status','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value">
						<?php
							if($bed_data->bed_status == '0')
							{	?>
								<label class="label_value"><?php esc_attr_e('Available','school-mgt');?></label>
								<?php
							}
							else 
							{ ?>
								<label class="label_value"><?php esc_attr_e('Occupied','school-mgt');?></label>
								<?php 
							}?>
					</label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Charge','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php echo mj_smgt_get_currency_symbol().' '.$bed_data->bed_charge; ?></label>
				</div>
				<div class="col-md-12 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Description','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value">
						<?php
						if(!empty($bed_data->bed_description))
						{
							echo $bed_data->bed_description; 
						}
						else
						{
							echo 'N/A';
						}
						?>
					</label>
				</div>
			</div>
		</div>	
		<?php 
	}
	elseif($type == 'subject_view')
	{
		$subject_data = mj_smgt_get_subject($recoed_id);
		$teacher_group = array();
		$teacher_ids = mj_smgt_teacher_by_subject($subject_data);
		foreach($teacher_ids as $teacher_id)
		{
			$teacher_group[] = mj_smgt_get_teacher($teacher_id);
		}
		$teachers = implode(',',$teacher_group);
	
		?>
		<div class="modal-header model_header_padding dashboard_model_header"> 
			<img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Subject.png";  ?>" alt="" class="popup_image_before_name">
			<a href="javascript:void(0);" class="close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>
			<h4 id="myLargeModalLabel" class="modal-title"><?php esc_attr_e('Subject Details','school-mgt'); ?></h4>
		</div>	
		<div class="modal-body view_details_body_assigned_bed view_details_body">
			<div class="row">
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Subject Code','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php if(!empty($subject_data->subject_code)){ echo $subject_data->subject_code; }else{ echo "N/A"; } ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php echo esc_attr_e('Subject Name','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php if(!empty($subject_data->sub_name)){ echo $subject_data->sub_name;  }else{ echo "N/A"; } ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Class Name','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php  if(!empty($subject_data->class_id)){ echo mj_smgt_get_class_name($subject_data->class_id);  }else{ echo "N/A"; } ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Section Name','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php  if(!empty($subject_data->section_id)){ echo mj_smgt_get_section_name($subject_data->section_id);  }else{ echo "N/A"; } ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Teacher Name','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php  if(!empty($teachers)){ echo $teachers; }else{ echo "N/A"; }  ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Author Name','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php  if(!empty($subject_data->author_name)){ echo $subject_data->author_name;  }else{ echo "N/A"; } ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Edition','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php  if(!empty($subject_data->edition)){ echo $subject_data->edition; }else{ echo "N/A"; }  ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Syllabus','school-mgt'); ?></label>
					<br>
					<?php 
					$syllabus = $subject_data->syllabus;
					?>
					<label for="" class="label_value"><?php  if(!empty($syllabus)){ ?> <a target="blank"  class="status_read btn btn-default download_btn_syllebus" href="<?php print content_url().'/uploads/school_assets/'.$syllabus; ?>" record_id="<?php echo $subject->subject;?>"><i class="fa fa-download"></i>  <?php echo esc_html_e("Download" , "school-mgt");?></a> <?php }else{ echo "N/A"; } ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Create By','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php  if(!empty($subject_data->created_by)){ echo mj_smgt_get_user_name_byid($subject_data->created_by); }else{ echo "N/A"; } ?></label>
				</div>
			</div>
		</div>	
		<?php
	}
	elseif($type == 'examhall_view')
	{
		$exam_hall = mj_smgt_get_hall_by_id($recoed_id);
	
		?>
		<div class="modal-header model_header_padding dashboard_model_header"> 
			<img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Examhall.png";  ?>" alt="" class="popup_image_before_name">
			<a href="javascript:void(0);" class="close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>
			<h4 id="myLargeModalLabel" class="modal-title"><?php esc_attr_e('Exam Hall Details','school-mgt'); ?></h4>
		</div>
		<div class="modal-body view_details_body_assigned_bed view_details_body">
			<div class="row">
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Hall Name','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php if(!empty($exam_hall->hall_name)){ echo stripslashes($exam_hall->hall_name); }else{ echo "N/A"; } ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php echo esc_attr_e('Hall Numeric Value','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php if(!empty($exam_hall->number_of_hall)){ echo $exam_hall->number_of_hall;  }else{ echo "N/A"; } ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Hall Capacity','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php  if(!empty($exam_hall->hall_capacity)){ echo $exam_hall->hall_capacity; }else{ echo "N/A"; }  ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Create Date','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php  if(!empty($exam_hall->date)){ echo mj_smgt_getdate_in_input_box($exam_hall->date);  }else{ echo "N/A"; } ?></label>
				</div>
				<div class="col-md-12 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Description','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php  if(!empty($exam_hall->description)){ echo stripslashes($exam_hall->description);  }else{ echo "N/A"; } ?></label>
				</div>
			</div>
		</div>
		<?php
	}
	elseif($type == 'event_view')
	{
		$obj_event = new event_Manage(); 
		$event_data = $obj_event->MJ_smgt_get_single_event($recoed_id);

		?>
		<div class="modal-header model_header_padding dashboard_model_header"> 
			<img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Examhall.png";  ?>" alt="" class="popup_image_before_name">
			<a href="javascript:void(0);" class="close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>
			<h4 id="myLargeModalLabel" class="modal-title"><?php esc_attr_e('Event Details','school-mgt'); ?></h4>
		</div>
		<div class="modal-body view_details_body_assigned_bed view_details_body">
			<div class="row">
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Title','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php if(!empty($event_data->event_title)){ echo stripslashes($event_data->event_title); }else{ echo "N/A"; } ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Download File','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value">
						<?php
							if(!empty($event_data->event_doc))
							{
								?>
								<a download href="<?php print content_url().'/uploads/school_assets/'.$event_data->event_doc; ?>"  class="btn padding_0 popup_download_btn" record_id="<?php echo $exam_data->exam_id;?>"><i class="fa fa-download" id="download_icon"></i> <?php esc_attr_e('Download','school-mgt'); ?></a>
								<?php
							}
							else 
							{
								echo "N/A";
							}
						?>
					</label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Start Date','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo mj_smgt_getdate_in_input_box($event_data->start_date); ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('End Date','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo mj_smgt_getdate_in_input_box($event_data->end_date); ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Start Time','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo $event_data->start_time; ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('End Time','school-mgt'); ?></label><br>
					<label for="" class="label_value"><?php echo $event_data->end_time; ?></label>
				</div>
				<div class="col-md-12 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Description','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php  if(!empty($event_data->description)){ echo stripslashes($event_data->description);  }else{ echo "N/A"; } ?></label>
				</div>
			</div>
		</div>
		<?php
	}
	elseif($type == 'assign_transport_view')
	{ 		
		$assign_transport_data= mj_smgt_get_single_assign_transport_by_id($recoed_id);
		$transport_data = mj_smgt_get_transport_by_id($assign_transport_data->transport_id);
		?>
		<div class="modal-header model_header_padding dashboard_model_header"> 
			<img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Transportation.png";  ?>" alt="" class="popup_image_before_name">
			<a href="javascript:void(0);" class="close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>
			<h4 id="myLargeModalLabel" class="modal-title"><?php esc_attr_e('Assign Transport Details','school-mgt'); ?></h4>
		</div>	
		<div class="modal-body view_details_body_assigned_bed view_details_body">
			<div class="row">
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Route Name','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php echo $assign_transport_data->route_name; ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Vehicle Identifier','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php echo $transport_data->number_of_vehicle; ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Vehicle Registration Number','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php echo $transport_data->vehicle_reg_num; ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Driver Name','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php echo $transport_data->driver_name; ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Driver Phone Number','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php echo "+" .mj_smgt_get_countery_phonecode(get_option( 'smgt_contry' ));?> <?php echo $transport_data->driver_phone_num; ?></label>
				</div>
				<div class="col-md-6 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Route Fare','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value"><?php echo "<span> ". mj_smgt_get_currency_symbol() ." </span>" . number_format($assign_transport_data->route_fare,2); ?></label>
				</div>
				<div class="col-md-12 popup_padding_15px">
					<label for="" class="popup_label_heading"><?php esc_attr_e('Assign Student','school-mgt'); ?></label>
					<br>
					<label for="" class="label_value">
						<?php 
						$users = json_decode($assign_transport_data->route_user);
						$new_user_array = array();
						foreach($users as $user)
						{
							$new_user_array[] = get_user_meta($user, 'first_name',true).' '.get_user_meta($user, 'last_name',true);
						}
						echo implode(", ", $new_user_array);
						?>
					</label>
				</div>
			</div>
		</div>	
		<?php 
	}
	die();
}
//---------- EDIT POPUP ------------//
add_action( 'wp_ajax_mj_smgt_edit_popup_value','mj_smgt_edit_popup_value');
add_action( 'wp_ajax_nopriv_mj_smgt_edit_popup_value','mj_smgt_edit_popup_value');
function mj_smgt_edit_popup_value()
{

	$model = $_REQUEST['model'];
	$cat_id = $_REQUEST['cat_id'];
	$category_value = get_the_title($cat_id);
	?>
	<div class="form-body user_form">
		<div class="row">
			<div class="col-md-10 width_70 margin_right_10px_res">
				<div class="form-group input rtl_padding_top ">
					<div class="col-md-12 form-control">
						<input type="text" class="validate[required,custom[popup_category_validation]]" name="category_name" maxlength="50" value="<?php echo $category_value; ?>" id="category_name_edit">
					</div>
				</div>
			</div>
			<div class="row col-md-2 margin_top_10px_web padding_left_0_res width_30 margin_top_13px_res" id="<?php echo $cat_id; ?>">
				<div class="col-md-6 padding_left_0 width_50_res">
					<a class="btn-cat-update-cancel_popup" model="<?php echo $model; ?>" href="#" id="<?php echo $cat_id; ?>"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/cencal.png"?>" alt=""></a>
				</div>
				<div class="col-md-6 width_50_res edit_btn_padding_left_25px_res">
					<a class="btn-cat-update_popup" model="<?php echo $model; ?>" href="#" id="<?php echo $cat_id; ?>"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/save.png"?>" alt="">	</a>
				</div>
			</div>
		</div>
	</div>


	<?php
	die();
}
add_action( 'wp_ajax_mj_smgt_update_cancel_popup','mj_smgt_update_cancel_popup');
add_action( 'wp_ajax_nopriv_mj_smgt_update_cancel_popup','mj_smgt_update_cancel_popup');
//------------ CANCEL POPUP --------//
function mj_smgt_update_cancel_popup()
{
	$model=$_REQUEST['model'];
	$cat_result = mj_smgt_get_all_category( $model );	

		$i = 1;

		if(!empty($cat_result))
		{
			foreach ($cat_result as $retrieved_data)
			{
				?>
				<div class="row new_popup_padding" id="<?php echo "cat_new-".$retrieved_data->ID.""; ?>">
					<div class="col-md-10 width_70" >
						<?php
						echo $retrieved_data->post_title;
						?>
					</div>
					<div class="row col-md-2 padding_left_0_res width_30" id="<?php echo $retrieved_data->ID; ?>">
						<div class="col-md-6 width_50_res padding_left_0">
							<a href="#" class="btn-delete-cat_new" model="<?php echo $model; ?>" id="<?php echo $retrieved_data->ID; ?>"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png"?>" alt=""></a>
						</div>
						<div class="col-md-6 edit_btn_padding_left_25px_res width_50_res padding_right_0">
							<a class="btn-edit-cat_popup"  model="<?php echo $model; ?>" href="#" id="<?php echo $retrieved_data->ID; ?>"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/edit.png"?>" alt=""></a>
						</div>
					</div>
				</div>
				<?php
				$i++;		
			}
		}
					 
	die();
}
//-------------------- UPDATE POPUP VALUE CATEGORY ---------//
add_action( 'wp_ajax_mj_smgt_update_cetogory_popup_value','mj_smgt_update_cetogory_popup_value');
add_action( 'wp_ajax_nopriv_mj_smgt_update_cetogory_popup_value','mj_smgt_update_cetogory_popup_value');
function mj_smgt_update_cetogory_popup_value()
{
	$model=$_REQUEST['model'];
	$cat_id=$_REQUEST['cat_id'];
	$category_name=$_REQUEST['category_name'];
	$dlt_image = SMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png";
	$edit_image = SMS_PLUGIN_URL."/assets/images/listpage_icon/edit.png";
		$edited_post = array(
			'ID'           => $cat_id,
			'post_title' => $category_name
		);
	$result=wp_update_post( $edited_post);
			if($model == 'smgt_bookperiod')
			{
				$row1 = '<div class="col-md-10 width_70">'.get_the_title($cat_id).''.esc_attr__('Days','school-mgt').'</div>';
				$row1.='<div class="row col-md-2 padding_left_0_res width_30" id='.$cat_id.'><div class="col-md-6 width_50_res padding_left_0" ><a href="#" class="btn-delete-cat_new" model="'.$model.'" id="'.$cat_id.'"><img src="'.$dlt_image.'" alt=""></a></div><div class="col-md-6 edit_btn_padding_left_25px_res width_50_res padding_right_0"><a class="btn-edit-cat_popup" model="'.$model.'" href="#" id="'.$cat_id.'"><img src="'.$edit_image.'" alt="" style="height: 40px; width: 40px;"></a></div></div>';
				$option = "<option value='$cat_id'>".$_REQUEST['category_name'].''.esc_attr__('Days','school-mgt').''."</option>";
			}
			else
			{
				$row1 = '<div class="col-md-10 width_70">'.get_the_title($cat_id).'</div>';
				$row1.='<div class="row col-md-2 padding_left_0_res width_30" id='.$cat_id.'><div class="col-md-6 width_50_res padding_left_0" ><a href="#" class="btn-delete-cat_new" model="'.$model.'" id="'.$cat_id.'"><img src="'.$dlt_image.'" alt=""></a></div><div class="col-md-6 edit_btn_padding_left_25px_res width_50_res padding_right_0"><a class="btn-edit-cat_popup" model="'.$model.'" href="#" id="'.$cat_id.'"><img src="'.$edit_image.'" alt=""></a></div></div>';
				$option = "<option value='$cat_id'>".$_REQUEST['category_name']."</option>";
			}

			$array_var[] = $row1;

			$array_var[] = $option;
				
		echo json_encode($array_var);
	die();
}
//SEND SMS NOTIFICTION FUNCTION FOR MSG91 SMS//
function smgt_msg91_send_mail_function($mobiles,$message,$countary_code)
{	
	$msg91= get_option('smgt_msg91_sms_service');
	$sender= $msg91['msg91_senderID'];
	$authkey= $msg91['sms_auth_key'];
	$route= $msg91['wpnc_sms_route'];

	$curl = curl_init();	
    $curl_url="http://api.msg91.com/api/sendhttp.php?route=$route&sender=$sender&mobiles=$mobiles&authkey=$authkey&encrypt=1&message=$message&country=$countary_code";
	 curl_setopt_array($curl, array(
	 CURLOPT_URL =>$curl_url ,
	 CURLOPT_RETURNTRANSFER => true,
	 CURLOPT_ENCODING => "",
	 CURLOPT_MAXREDIRS => 10,
	 CURLOPT_TIMEOUT => 30,
	 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	 CURLOPT_CUSTOMREQUEST => "GET",
	 CURLOPT_SSL_VERIFYHOST => 0,
	 CURLOPT_SSL_VERIFYPEER => 0,
     ));
	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	if ($err) {
		echo "err";
	  echo "cURL Error #:" . $err;
	}  
}
function mj_smgt_browser_javascript_check()
{
	$plugins_url = plugins_url( 'school-management/ShowErrorPage.php' );
?>
	<noscript><meta http-equiv="refresh" content="0;URL=<?php echo $plugins_url;?>"></noscript> 
<?php
}
//access right page not access message
function mj_smgt_access_right_page_not_access_message()
{
	?>
	<script type="text/javascript">
		$(document).ready(function() 
		{	
			alert('<?php esc_attr_e('You do not have permission to perform this operation.','school-mgt');?>');
			window.location.href='?dashboard=user';
		});
	</script>
<?php
}
//access right page not access message admin side //
function mj_smgt_access_right_page_not_access_message_admin_side()
{
	?>
	<script type="text/javascript">
		$(document).ready(function() 
		{	
			alert('<?php esc_attr_e('You do not have permission to perform this operation.','school-mgt');?>');
			window.location.href='?page=smgt_dashboard';
		});
	</script>
<?php
}
function mj_smgt_get_all_transport_created_by($user_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "transport";
	return $results=$wpdb->get_results("SELECT * FROM $table_name WHERE  created_by=".$user_id);
}
function mj_smgt_get_all_leave_created_by($user_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "smgt_leave";
	return $results=$wpdb->get_results("SELECT * FROM $table_name WHERE  created_by=".$user_id);
}
//---get all leave by parent and child  ---//
function mj_smgt_get_all_leave_parent_by_child_list($child_id_str)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "smgt_leave";
	$results=$wpdb->get_results("SELECT * FROM $table_name WHERE student_id=$child_id_str");
	return $results;
}
function mj_smgt_get_all_holiday_created_by($user_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "holiday";
	return $results=$wpdb->get_results("SELECT * FROM $table_name WHERE  created_by=".$user_id);
}
function mj_smgt_get_all_holiday_created_by_dashboard($user_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "holiday";
	return $results=$wpdb->get_results("SELECT * FROM $table_name WHERE  created_by=$user_id ORDER BY holiday_id DESC limit 3");
}	
add_action( 'wp_ajax_mj_smgt_load_teacher_by_class',  'mj_smgt_load_teacher_by_class');
add_action( 'wp_ajax_nopriv_mj_smgt_load_teacher_by_class',  'mj_smgt_load_teacher_by_class');
function mj_smgt_load_teacher_by_class()
{
	$class_id =$_POST['class_list'];
	$teacherdata	= 	mj_smgt_get_teacher_by_class_id($class_id);	
	foreach($teacherdata as $retrieved_data)
	{
		if($retrieved_data->ID != "")
		{
			echo "<option value=".$retrieved_data->ID."> ".$retrieved_data->display_name ."</option>";
		}
	}
	exit;
}
//user role wise access right array
function mj_smgt_get_userrole_wise_access_right_array_in_api($user_id,$page_link)
{
	$school_obj = new School_Management ($user_id);	
	$role = $school_obj->role;
	if($role=='student')
	{
		$menu = get_option( 'smgt_access_right_student');
	}
	foreach ( $menu as $key1=>$value1 ) 
	{									
		foreach ( $value1 as $key=>$value ) 
		{				
			if ($page_link == $value['page_link'])
			{				
			   $menu_array1['view'] = $value['view'];
			   $menu_array1['own_data'] = $value['own_data'];
			   $menu_array1['add'] = $value['add'];
			   $menu_array1['edit'] = $value['edit'];
			   $menu_array1['delete'] = $value['delete'];
			   return $menu_array1;
			}
		}
	}	
}
// Function to get all the dates in given range 
function mj_smgt_getDatesFromRange($start, $end) { 
      
    // Declare an empty array 
    $array = array(); 
    // Variable that store the date interval 
    // of period 1 day 
    $interval = new DateInterval('P1D'); 
  
    $realEnd = new DateTime($end); 
    $realEnd->add($interval); 
  
    $period = new DatePeriod(new DateTime($start), $interval, $realEnd); 
  
    // Use loop to store date into array 
    foreach($period as $date) {                  
        $array[] = $date->format('Y-m-d');  
    } 
  
    // Return the array elements 
    return $array; 
}
function mj_smgt_check_username_password( $login, $username, $password ) 
{
// Getting URL of the login page
$referrer = $_SERVER['HTTP_REFERER'];

// if there's a valid referrer, and it's not the default log-in screen
if( !empty( $referrer ) && !strstr( $referrer,'wp-login' ) && !strstr( $referrer,'wp-admin' ) ) {
    if( $username == "" || $password == "" )
    {
        wp_redirect( get_permalink( get_option('smgt_login_page') ) . "?login=empty" ); 
     	exit;
    }
} 

}
//--------------- SEND PAID INVOICE PDF SEND IN MAIL --------------------//
//send invoice generated pdf in mail
function mj_smgt_send_mail_paid_invoice_pdf($emails,$subject,$message,$fees_pay_id)
{
	$document_dir = WP_CONTENT_DIR;
	$document_dir .= '/uploads/invoices/';
	$document_path = $document_dir;
	if (!file_exists($document_path))
	{
		mkdir($document_path, 0777, true);		
	}
	$fees_detail_result = mj_smgt_get_single_fees_payment_record($fees_pay_id);
	$fees_history_detail_result = mj_smgt_get_payment_history_by_feespayid($fees_pay_id);

	require_once SMS_PLUGIN_DIR . '/lib/mpdf/vendor/autoload.php';
	$mpdf = new Mpdf\Mpdf;
	//$mpdf=new mPDF();
	// echo '<link rel="stylesheet" href="'.plugins_url( '/assets/css/bootstrap.min.css', __FILE__).'"></link>';
  
	// echo '<script  rel="javascript" src="'.plugins_url( '/assets/js/bootstrap.min.js', __FILE__).'"></script>'; 

		
	$stylesheet = file_get_contents(SMS_PLUGIN_DIR. '/assets/css/style.css'); // Get css content
	$mpdf->WriteHTML('<html>');
	$mpdf->WriteHTML('<head>');
	$mpdf->WriteHTML('<style></style>');
	$mpdf->WriteHTML($stylesheet,1); // Writing style to pdf
	$mpdf->WriteHTML('</head>');
	$mpdf->WriteHTML('<body>');		
					$mpdf->WriteHTML('<div class="modal-body">');
				$mpdf->WriteHTML('<div id="invoice_print" class="print-box" width="100%">'); 
					$mpdf->WriteHTML('<table width="100%" border="0">');
						$mpdf->WriteHTML('<tbody>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td width="70%">');
								$mpdf->WriteHTML('<img style="max-height:80px;" src="'.get_option( 'smgt_school_logo' ).'">');
								$mpdf->WriteHTML('</td>');
								$mpdf->WriteHTML('<td align="right" width="24%">');
									$mpdf->WriteHTML('<h5>');
										$issue_date='DD-MM-YYYY';
										$issue_date=$fees_detail_result->paid_by_date;						
										$mpdf->WriteHTML(''. esc_attr__('Issue Date','school-mgt')." : ".mj_smgt_getdate_in_input_box(date("Y-m-d", strtotime($issue_date))).'</h5>');
										$mpdf->WriteHTML('<h5>');
										$payment_status = mj_smgt_get_payment_status($fees_detail_result->fees_pay_id);	
										$mpdf->WriteHTML(''. esc_attr__('status','school-mgt')." : ".$payment_status.'</h5>');
								$mpdf->WriteHTML('</td>');
							$mpdf->WriteHTML('</tr>');
						$mpdf->WriteHTML('</tbody>');
					$mpdf->WriteHTML('</table>');
					$mpdf->WriteHTML('<hr class="hr_margin_new">');
					$mpdf->WriteHTML('<table width="100%" border="0">');
						$mpdf->WriteHTML('<tbody>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="col-md-6">');
									$mpdf->WriteHTML('<h4>');
									$mpdf->WriteHTML(''. esc_attr__('Payment From','school-mgt').'');
									$mpdf->WriteHTML('</h4>');
								$mpdf->WriteHTML('</td>');
								$mpdf->WriteHTML('<td class="col-md-6 pull-right" style="text-align: right;">');
									$mpdf->WriteHTML('<h4>');
									$mpdf->WriteHTML(''. esc_attr__('Bill To','school-mgt').'');
									 $mpdf->WriteHTML('</h4>');
								$mpdf->WriteHTML('</td>');
							$mpdf->WriteHTML('</tr>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td valign="top"class="col-md-6">');
									$mpdf->WriteHTML(''.get_option( 'smgt_school_name')."<br>".'');
									$mpdf->WriteHTML(''.get_option( 'smgt_school_address' ).",".'');
									$mpdf->WriteHTML(''.get_option( 'smgt_contry' )."<br>".''); 
									$mpdf->WriteHTML(''.get_option( 'smgt_contact_number' )."<br>".'');
								
								$mpdf->WriteHTML('</td>');
								$mpdf->WriteHTML('<td valign="top" class="col-md-6" style="text-align: right;">');

									$student_id=$fees_detail_result->student_id;						
									$patient=get_userdata($student_id);									
									 $mpdf->WriteHTML(''.$patient->display_name."<br>".'');
									  $mpdf->WriteHTML('Student ID '.'<b>'.get_user_meta( $student_id,'roll_id',true )."</b><br>".'');
									 $mpdf->WriteHTML(''.get_user_meta( $student_id,'address',true ).",".'');
									 $mpdf->WriteHTML(''.get_user_meta( $student_id,'city',true )."<br>".'');
									 $mpdf->WriteHTML(''.get_user_meta( $student_id,'zip_code',true )."<br>".'');
									  $mpdf->WriteHTML(''.get_user_meta( $student_id,'state',true ).",".'');
									 $mpdf->WriteHTML(''.get_option( 'smgt_contry' ).",".'');
									  $mpdf->WriteHTML(''.get_user_meta( $student_id,'mobile',true )."<br>".'');
								 $mpdf->WriteHTML('</td>');
							 $mpdf->WriteHTML('</tr>');
						 $mpdf->WriteHTML('</tbody>');
					 $mpdf->WriteHTML('</table>');
					 $mpdf->WriteHTML('<hr class="hr_margin_new">');
					 $mpdf->WriteHTML('<div class="table-responsive">');
						 $mpdf->WriteHTML('<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">');
							 $mpdf->WriteHTML('<thead>');
								 $mpdf->WriteHTML('<tr>');
									 $mpdf->WriteHTML('<th class="text-center padding_10">#</th>');
									 $mpdf->WriteHTML('<th class="text-center padding_10">'. esc_attr__('Fees Type','school-mgt').'</th>');
									 $mpdf->WriteHTML('<th class="padding_10">'. esc_attr__('Total','school-mgt').'</th>');	
								 $mpdf->WriteHTML('</tr>');
							 $mpdf->WriteHTML('</thead>');
							 $mpdf->WriteHTML('<tbody>');
							 $mpdf->WriteHTML('<tr>');
								 $mpdf->WriteHTML('<td class="text-center">1</td>');
								 $mpdf->WriteHTML('<td class="text-center">');
								$mpdf->WriteHTML(''.mj_smgt_get_fees_term_name($fees_detail_result->fees_id).'</td>');
								$mpdf->WriteHTML('<td>');
								$mpdf->WriteHTML('<span>'.mj_smgt_get_currency_symbol().'</span>'.number_format($fees_detail_result->total_amount,2).'</td>');
								 $mpdf->WriteHTML('</tr>');
							$mpdf->WriteHTML('</tbody>');
						$mpdf->WriteHTML('</table>');
					$mpdf->WriteHTML('</div>');
					$mpdf->WriteHTML('<table width="100%" border="0">');
						$mpdf->WriteHTML('<tbody>');						
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td  align="right">'. esc_attr__('Sub Total : ','school-mgt').'</td>');
								$mpdf->WriteHTML('<td align="right">'.mj_smgt_get_currency_symbol().number_format($fees_detail_result->total_amount,2).'</td>');
							$mpdf->WriteHTML('</tr>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td width="80%" align="right">'. esc_attr__('Payment Made :','school-mgt').'</td>');
								$mpdf->WriteHTML('<td align="right">'.mj_smgt_get_currency_symbol().number_format($fees_detail_result->fees_paid_amount,2).'</td>');
							$mpdf->WriteHTML('</tr>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td width="80%" align="right">'. esc_attr__('Due Amount :','school-mgt').'</td>');
								$Due_amount = $fees_detail_result->total_amount - $fees_detail_result->fees_paid_amount;
								$mpdf->WriteHTML('<td align="right">'.mj_smgt_get_currency_symbol().number_format($Due_amount,2).'</td>');
							$mpdf->WriteHTML('</tr>');			
						$mpdf->WriteHTML('</tbody>');
					$mpdf->WriteHTML('</table>');
					$mpdf->WriteHTML('<hr class="hr_margin_new">');
					if(!empty($fees_history_detail_result))
					{ 
					$mpdf->WriteHTML('<h4>'. esc_attr__('Payment History','school-mgt').'</h4>');
					$mpdf->WriteHTML('<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">');
						$mpdf->WriteHTML('<thead>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<th class="text-center padding_10">'. esc_attr__('Date','school-mgt').'</th>');
								$mpdf->WriteHTML('<th class="text-center padding_10">'. esc_attr__('Amount','school-mgt').'</th>');
								$mpdf->WriteHTML('<th class="padding_10">'. esc_attr__('Method','school-mgt').'</th>');
								
							$mpdf->WriteHTML('</tr>');
						$mpdf->WriteHTML('</thead>');
						$mpdf->WriteHTML('<tbody>');
							foreach($fees_history_detail_result as  $retrive_date)
							{
							
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="text-center">'.mj_smgt_getdate_in_input_box($retrive_date->paid_by_date).'</td>');
								$mpdf->WriteHTML('<td class="text-center">'.mj_smgt_get_currency_symbol() .number_format($retrive_date->amount,2).'</td>');
								$mpdf->WriteHTML('<td>'.$retrive_date->payment_method.'</td>');
							$mpdf->WriteHTML('</tr>');
							}
						$mpdf->WriteHTML('</tbody>');
					$mpdf->WriteHTML('</table>');
					}
				$mpdf->WriteHTML('</div>');		
			$mpdf->WriteHTML('</div>');
			
	$mpdf->WriteHTML('</body>');
	$mpdf->WriteHTML('</html>');	
	$mpdf->Output($document_path.'invoice.pdf','F');
	$mail_attachment = array($document_path.'invoice.pdf'); 
	
	$school=get_option('smgt_school_name');
	$headers="";
	$headers .= 'From: '.$school.' <noreplay@gmail.com>' . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";
	if(get_option('smgt_mail_notification') == '1')
	{
		wp_mail($emails,$subject,$message,$headers,$mail_attachment);
	}			
	unlink($document_path.'invoice.pdf');
}
//--------------- SEND INVOICE TRANSLATE PDF LINK --------------------//
//send invoice translate pdf link
function mj_smgt_api_translate_invoice_pdf($id,$student)
{
	$document_dir = WP_CONTENT_DIR;
	$document_dir .= '/uploads/translate_invoice_pdf/';
	$document_path = $document_dir;
	if (!file_exists($document_path))
	{
		mkdir($document_path, 0777, true);		
	}
	$fees_pay_id = $id;
	$fees_detail_result = mj_smgt_get_single_fees_payment_record($fees_pay_id);
	$fees_history_detail_result = mj_smgt_get_payment_history_by_feespayid($fees_pay_id);
	
	
	        
	require_once SMS_PLUGIN_DIR . '/lib/mpdf/vendor/autoload.php';
	$mpdf = new Mpdf\Mpdf;
	$mpdf->autoScriptToLang = true;
	$mpdf->autoLangToFont = true;
	$stylesheet = file_get_contents(SMS_PLUGIN_DIR. '/assets/css/style.css'); // Get css content
	$mpdf->WriteHTML('<html>');
	$mpdf->WriteHTML('<head>');
	$mpdf->WriteHTML('<style></style>');
	$mpdf->WriteHTML($stylesheet,1); // Writing style to pdf
	$mpdf->WriteHTML('</head>');
	$mpdf->WriteHTML('<body>');		
	//$mpdf->SetTitle('Invoice');
					$mpdf->WriteHTML('<div class="modal-body">');
				$mpdf->WriteHTML('<div id="invoice_print" class="print-box" width="100%">'); 
					$mpdf->WriteHTML('<table width="100%" border="0">');
						$mpdf->WriteHTML('<tbody>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td width="70%">');
								$mpdf->WriteHTML('<img style="max-height:80px;" src="'.get_option( 'smgt_school_logo' ).'">');
								$mpdf->WriteHTML('</td>');
								$mpdf->WriteHTML('<td align="right" width="24%">');
									$mpdf->WriteHTML('<h5>');
										$issue_date='DD-MM-YYYY';
										$issue_date=$fees_detail_result->paid_by_date;						
										$mpdf->WriteHTML(''. esc_attr__('Issue Date','school-mgt')." : ".mj_smgt_getdate_in_input_box(date("Y-m-d", strtotime($issue_date))).'</h5>');
										$mpdf->WriteHTML('<br>');
										$mpdf->WriteHTML('<h5>');
										$payment_status = mj_smgt_get_payment_status($fees_detail_result->fees_pay_id);
										$mpdf->WriteHTML(''. esc_attr__('status','school-mgt')." : ".$payment_status.'</h5>');
								$mpdf->WriteHTML('</td>');
							$mpdf->WriteHTML('</tr>');
						$mpdf->WriteHTML('</tbody>');
					$mpdf->WriteHTML('</table>');
					$mpdf->WriteHTML('<hr class="hr_margin_new">');
					$mpdf->WriteHTML('<table width="100%" border="0">');
						$mpdf->WriteHTML('<tbody>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="col-md-6">');
									$mpdf->WriteHTML('<h4>');
									$mpdf->WriteHTML(''. esc_attr__('Payment From','school-mgt').'');
									$mpdf->WriteHTML('</h4>');
								$mpdf->WriteHTML('</td>');
								$mpdf->WriteHTML('<td class="col-md-6 pull-right" style="text-align: right;">');
									$mpdf->WriteHTML('<h4>');
									$mpdf->WriteHTML(''. esc_attr__('Bill To','school-mgt').'');
									 $mpdf->WriteHTML('</h4>');
								$mpdf->WriteHTML('</td>');
							$mpdf->WriteHTML('</tr>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td valign="top"class="col-md-6">');
									$mpdf->WriteHTML(''.get_option( 'smgt_school_name')."<br>".'');
									$mpdf->WriteHTML(''.get_option( 'smgt_school_address' ).",".'');
									$mpdf->WriteHTML(''.get_option( 'smgt_contry' )."<br>".''); 
									$mpdf->WriteHTML(''.get_option( 'smgt_contact_number' )."<br>".'');
								
								$mpdf->WriteHTML('</td>');
								$mpdf->WriteHTML('<td valign="top" class="col-md-6" style="text-align: right;">');

									$student_id=$fees_detail_result->student_id;						
									$student_data=get_userdata($student_id);		
									$class_id=$student_data->class_name;
									$section_id=$student_data->class_section;
									$class_name=mj_smgt_get_class_name($class_id);
									$section_name=mj_smgt_get_section_name($section_id);
									
									 $mpdf->WriteHTML(''.$student_data->display_name."<br>".'');
									 
									 $mpdf->WriteHTML('Class Name '.'<b>'.$class_name."</b><br>".'');
									 if($section_id!="")
                                     {
                                         $mpdf->WriteHTML('Section Name '.'<b>'.$section_name."</b><br>".'');
                                     }
									  $mpdf->WriteHTML('Student ID '.'<b>'.get_user_meta( $student_id,'roll_id',true )."</b><br>".'');
									 $mpdf->WriteHTML(''.get_user_meta( $student_id,'address',true ).",".'');
									 $mpdf->WriteHTML(''.get_user_meta( $student_id,'city',true )."<br>".'');
									 $mpdf->WriteHTML(''.get_user_meta( $student_id,'zip_code',true )."<br>".'');
									  $mpdf->WriteHTML(''.get_user_meta( $student_id,'state',true ).",".'');
									 $mpdf->WriteHTML(''.get_option( 'smgt_contry' ).",".'');
									  $mpdf->WriteHTML(''.get_user_meta( $student_id,'mobile',true )."<br>".'');
								 $mpdf->WriteHTML('</td>');
							 $mpdf->WriteHTML('</tr>');
						 $mpdf->WriteHTML('</tbody>');
					 $mpdf->WriteHTML('</table>');
					 $mpdf->WriteHTML('<hr class="hr_margin_new">');
					 $mpdf->WriteHTML('<div class="table-responsive">');
					 
						 $mpdf->WriteHTML('<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">');
							 $mpdf->WriteHTML('<thead>');
								 $mpdf->WriteHTML('<tr>');
									 $mpdf->WriteHTML('<th class="text-center padding_10">#</th>');
									 $mpdf->WriteHTML('<th class="text-center padding_10">'. esc_attr__('Fees Type','school-mgt').'</th>');
									 $mpdf->WriteHTML('<th class="padding_10">'. esc_attr__('Total','school-mgt').'</th>');	
								 $mpdf->WriteHTML('</tr>');
							 $mpdf->WriteHTML('</thead>');
							 $mpdf->WriteHTML('<tbody>');
							 
							$fees_array = explode(',', $fees_detail_result->fees_id);
							$n=1;
							foreach($fees_array as $fees_id )
							{
								     $fees_details=mj_smgt_get_fees_details($fees_id);
									 $mpdf->WriteHTML('<tr>');
									 $mpdf->WriteHTML('<td class="text-center">'.$n.'</td>');
									 $mpdf->WriteHTML('<td class="text-center">');
									$mpdf->WriteHTML(''.get_the_title($fees_details->fees_title_id).'</td>');
									$mpdf->WriteHTML('<td>');
									$mpdf->WriteHTML('<span>'.mj_smgt_get_currency_symbol().'</span>'.number_format($fees_details->fees_amount,2).'</td>');
									 $mpdf->WriteHTML('</tr>');
									 $n++;
								
							}
						$mpdf->WriteHTML('</tbody>');
						$mpdf->WriteHTML('</table>');
						
					$mpdf->WriteHTML('</div>');
					$mpdf->WriteHTML('<table width="100%" border="0">');
						$mpdf->WriteHTML('<tbody>');						
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td  align="right">'. esc_attr__('Sub Total : ','school-mgt').'</td>');
								$mpdf->WriteHTML('<td align="right">'.mj_smgt_get_currency_symbol().number_format($fees_detail_result->total_amount,2).'</td>');
							$mpdf->WriteHTML('</tr>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td width="80%" align="right">'. esc_attr__('Payment Made :','school-mgt').'</td>');
								$mpdf->WriteHTML('<td align="right">'.mj_smgt_get_currency_symbol().number_format($fees_detail_result->fees_paid_amount,2).'</td>');
							$mpdf->WriteHTML('</tr>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td width="80%" align="right">'. esc_attr__('Due Amount :','school-mgt').'</td>');
								$Due_amount = $fees_detail_result->total_amount - $fees_detail_result->fees_paid_amount;
								$mpdf->WriteHTML('<td align="right">'.mj_smgt_get_currency_symbol().number_format($Due_amount,2).'</td>');
							$mpdf->WriteHTML('</tr>');			
						$mpdf->WriteHTML('</tbody>');
					$mpdf->WriteHTML('</table>');
					$mpdf->WriteHTML('<hr class="hr_margin_new">');
					if(!empty($fees_history_detail_result))
					{ 
					$mpdf->WriteHTML('<h4>'. esc_attr__('Payment History','school-mgt').'</h4>');
					$mpdf->WriteHTML('<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">');
						$mpdf->WriteHTML('<thead>');
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<th class="text-center padding_10">'. esc_attr__('Date','school-mgt').'</th>');
								$mpdf->WriteHTML('<th class="text-center padding_10">'. esc_attr__('Amount','school-mgt').'</th>');
								$mpdf->WriteHTML('<th class="padding_10">'. esc_attr__('Method','school-mgt').'</th>');
								
							$mpdf->WriteHTML('</tr>');
						$mpdf->WriteHTML('</thead>');
						$mpdf->WriteHTML('<tbody>');
							foreach($fees_history_detail_result as  $retrive_date)
							{
							
							$mpdf->WriteHTML('<tr>');
								$mpdf->WriteHTML('<td class="text-center">'.mj_smgt_getdate_in_input_box($retrive_date->paid_by_date).'</td>');
								$mpdf->WriteHTML('<td class="text-center">'.mj_smgt_get_currency_symbol() .number_format($retrive_date->amount,2).'</td>');
								$mpdf->WriteHTML('<td>'.$retrive_date->payment_method.'</td>');
							$mpdf->WriteHTML('</tr>');
							}
						$mpdf->WriteHTML('</tbody>');
					$mpdf->WriteHTML('</table>');
					}
				$mpdf->WriteHTML('</div>');		
			$mpdf->WriteHTML('</div>');
			
	$mpdf->WriteHTML('</body>');
	$mpdf->WriteHTML('</html>');	
	$mpdf->Output($document_path.'invoice_'.$fees_pay_id.'_'.$student.'.pdf','F');
	$result = get_site_url().'/wp-content/uploads/translate_invoice_pdf/'.'invoice_'.$fees_pay_id.'_'.$student.'.pdf';
	
	return $result;
}
//--------------- SEND INVOICE TRANSLATE PDF LINK --------------------//
//send invoice translate pdf link
function mj_smgt_api_translate_result_pdf($s_id,$e_id)
{
	
	$document_dir = WP_CONTENT_DIR;
	$document_dir .= '/uploads/translate_invoice_pdf/';
	$document_path = $document_dir;
	if (!file_exists($document_path))
	{
		mkdir($document_path, 0777, true);		
	}
	ob_start();
	$obj_mark = new Marks_Manage();
	$uid = $s_id;
	$user =get_userdata( $uid );
	$user_meta =get_user_meta($uid);
	$class_id = $user_meta['class_name'][0];
	$section_id=get_user_meta($uid,'class_section',true);
	if($section_id)
	{
		$subject = $obj_mark->mj_smgt_student_subject($class_id,$section_id);
	}
	else
	{
		$subject = $obj_mark->mj_smgt_student_subject($class_id);
	}
	$total_subject=count($subject);
	$exam_id =$e_id;
	$total = 0;
	$grade_point = 0;
	$umetadata=mj_smgt_get_user_image($uid); 
	
	?>
	<center>
		
	  <div style="float:left;width:100%;"> <img src="<?php echo get_option('smgt_school_logo'); ?>"  style="max-height:50px;"/> <?php echo get_option( 'smgt_school_name' );?> </div>
	  <div style="width:100%;float:left;border-bottom:1px solid red;"></div>
	  <div style="width:100%;float:left;border-bottom:1px solid yellow;padding-top:5px;"></div>
	  <br>
	 
	  <div style="float:left;width:100%;padding:10px 0;">
	    <div style="width:70%;float:left;text-align:left;">
	      <p>
	        <?php esc_attr_e('Surname','school-mgt');?>
	        :
	        <?php echo get_user_meta($uid, 'last_name',true);?>
	      </p>
	      <p>
	        <?php esc_attr_e('First Name','school-mgt');?>
	        : <?php echo get_user_meta($uid, 'first_name',true);?></p>
	      <p>
	        <?php esc_attr_e('Class','school-mgt');?>
	        :
	        <?php $class_id=get_user_meta($uid, 'class_name',true);
												echo $classname=	mj_smgt_get_class_name($class_id);
							?>
	      </p>
	      <p>
	        <?php esc_attr_e('Exam Name','school-mgt');?>
	        :
	        <?php 
					echo mj_smgt_get_exam_name_id($exam_id);?>
	      </p>
	    </div>
	  </div>
	  <br>
	
	  <table style="float:left;width:100%;border:1px solid #000;" cellpadding="0" cellspacing="0">
	    <thead>
	      <tr style="border-bottom: 1px solid #000;">
	        <th style="border-bottom: 1px solid #000;text-align:left;border-right: 1px solid #000;"><?php esc_attr_e('S/No','school-mgt');?></th>
	        <th style="border-bottom: 1px solid #000;text-align:left;border-right: 1px solid #000;"><?php esc_attr_e('Subject','school-mgt')?></th>
	        <th style="border-bottom: 1px solid #000;text-align:left;border-right: 1px solid #000;"><?php esc_attr_e('Obtain Mark','school-mgt')?></th>
	        <th style="border-bottom: 1px solid #000;text-align:left;border-right: 1px solid #000;"><?php esc_attr_e('Grade','school-mgt')?></th>
	      </tr>
	    </thead>
	    <tbody>
	      <?php
		        $i=1;
				foreach($subject as $sub)
				{
				?>
	      <tr style="border-bottom: 1px solid #000;">
	        <td style="border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo $i;?></td>
	        <td style="border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo $sub->sub_name;?></td>
	        <td style="border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo $obj_mark->mj_smgt_get_marks($exam_id,$class_id,$sub->subid,$uid);?> </td>
	        <td style="border-bottom: 1px solid #000;border-right: 1px solid #000;"><?php echo $obj_mark->mj_smgt_get_grade($exam_id,$class_id,$sub->subid,$uid);?></td>
	      </tr>
	      <?php
				$i++;
				$total +=  $obj_mark->mj_smgt_get_marks($exam_id,$class_id,$sub->subid,$uid);
				$grade_point += $obj_mark->mj_smgt_get_grade_point($exam_id,$class_id,$sub->subid,$uid);
				} ?>
	    </tbody>
	  </table>
	  <p class="result_total">
	    <?php esc_attr_e("Total Marks","school-mgt");
	    echo " : ".$total;?>
	  </p>
	
	  <p class="result_point">
	    <?php	esc_attr_e("GPA(grade point average)","school-mgt");
	    $GPA=$grade_point/$total_subject;
	    echo " : ".round($GPA, 2);	?>
	  </p>
	  
	  <hr />
	</center>
	
	<?php
	$out_put = ob_get_contents();

	ob_clean();
	// header('Content-type: application/pdf');
	header('Content-Disposition: inline; filename="result"');
	header('Content-Transfer-Encoding: binary');
	header('Accept-Ranges: bytes');
	// echo "123";
	// die;
	require_once SMS_PLUGIN_DIR . '/lib/mpdf/vendor/autoload.php';
	$mpdf = new Mpdf\Mpdf;
	$mpdf->autoScriptToLang = true;
	$mpdf->autoLangToFont = true;
	$mpdf->WriteHTML($out_put);
	$mpdf->Output($document_path.'invoice_'.$exam_id.'_'.$uid.'.pdf','F');
	$result = get_site_url().'/wp-content/uploads/translate_invoice_pdf/'.'invoice_'.$exam_id.'_'.$uid.'.pdf';
	return $result;
}
//---------------- GET ROOM BY HOSTEL ID --------//
function mj_smgt_get_rooms_by_hostel_id($hostel_id)
{
	global $wpdb;
	$table_smgt_room=$wpdb->prefix.'smgt_room';
	$result=$wpdb->get_results("SELECT * FROM $table_smgt_room where hostel_id=".$hostel_id);
	return $result;
}
//---------------- GET Beds BY ROOM ID --------//
function mj_smgt_get_beds_by_room_id($room_id)
{
	global $wpdb;
	$table_smgt_beds=$wpdb->prefix.'smgt_beds';
	$result=$wpdb->get_results("SELECT * FROM $table_smgt_beds where room_id=".$room_id);
	return $result;
}

function mj_smgt_get_bed_charge_by_id($bed_id)
{
	global $wpdb;
	$table_smgt_beds=$wpdb->prefix.'smgt_beds';
	$result=$wpdb->get_row("SELECT * FROM $table_smgt_beds where id=".$bed_id);
	if($result)
	{
		return $result->bed_charge;
	}
}
//---------------- GET ROOM BY HOSTEL ID --------//
function mj_smgt_get_beds_by_hostel_id($hostel_id)
{
	global $wpdb;
	$room_id=array();
	$table_smgt_room=$wpdb->prefix.'smgt_room';
	$table_smgt_beds=$wpdb->prefix.'smgt_beds';
	$result=$wpdb->get_results("SELECT * FROM $table_smgt_room where hostel_id=".$hostel_id);
	
	if(!empty($result))
	{
		foreach($result as $data)
		{
			$room_id[]=$data->id;
		}
		$implode_room=implode(",",$room_id);
		$result_beds=$wpdb->get_results("SELECT * FROM $table_smgt_beds where room_id IN ($implode_room)");
		return $result_beds;
	}
}
//---------------- GET Hostel Name BY ROOM ID --------//
function mj_smgt_get_hostel_name_by_room_id($room_id)
{
	global $wpdb;
	$table_smgt_room=$wpdb->prefix.'smgt_room';
	$table_smgt_hostel=$wpdb->prefix.'smgt_hostel';
	$result=$wpdb->get_row("SELECT hostel_id FROM $table_smgt_room where id=".$room_id);
	$hostel_id=$result->hostel_id;
	$result_hostel=$wpdb->get_row("SELECT hostel_name FROM $table_smgt_hostel where id=".$hostel_id);
	return $result_hostel->hostel_name;
}
// Comparison function 
function mj_smgt_date_compare($element1, $element2) { 
    $datetime1 = strtotime($element1['notification_date']); 
    $datetime2 = strtotime($element2['notification_date']); 
    return $datetime2 - $datetime1; 
}
function mj_smgt_generate_access_token()
{
	$CLIENT_ID = get_option('smgt_virtual_classroom_client_id');
	$REDIRECT_URI = site_url().'/?page=callback';
	wp_redirect ("https://zoom.us/oauth/authorize?response_type=code&client_id=".$CLIENT_ID."&redirect_uri=".$REDIRECT_URI);

}

// CREATE MEETING FUNCTION
function mj_smgt_ajax_create_meeting()
{
	$obj_mark = new Class_routine(); 
	$route_id = $_REQUEST['route_id'];
	$route_data = mj_smgt_get_route_by_id($route_id);
	$start_time_data = explode(":", $route_data->start_time);
	$end_time_data = explode(":", $route_data->end_time);
	if ($start_time_data[1] == 0 OR $end_time_data[1] == 0)
	{
		$start_time_minit = '00';
		$end_time_minit = '00';
	}
	else
	{
		$start_time_minit = $start_time_data[1];
		$end_time_minit = $end_time_data[1];
	}
	$start_time  = date("h:i A", strtotime("$start_time_data[0]:$start_time_minit $start_time_data[2]"));
	$end_time  = date("h:i A", strtotime("$end_time_data[0]:$end_time_minit $end_time_data[2]"));
	?>
	<style>
	 .modal-header{
		 height:auto;
	 }
	</style>
	<script type="text/javascript">
	$(document).ready(function() {
		$('#meeting_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});
		$("#start_date").datepicker({
	        dateFormat: "yy-mm-dd",
			minDate:0,
	        onSelect: function (selected) {
	            var dt = new Date(selected);
	            dt.setDate(dt.getDate() + 0);
	            $("#end_date").datepicker("option", "minDate", dt);
	        }
	    });
	    $("#end_date").datepicker({
	       dateFormat: "yy-mm-dd",
		   minDate:0,
	        onSelect: function (selected) {
	            var dt = new Date(selected);
	            dt.setDate(dt.getDate() + 0);
	            $("#start_date").datepicker("option", "maxDate", dt);
	        }
	    });
	} );
	</script>
	<div class="modal-header import_csv_popup">
		<a href="#" class="close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>
		<h4 class="modal-title"><?php esc_attr_e('Create Virtual Class','school-mgt');?></h4>
	</div>
	<div class="panel-white"><!---------- Penal white --------->
	  	<div class="panel-body padding_18px_top_0">   
    		<form name="route_form" action="" method="post" class="form-horizontal" id="meeting_form">
				<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
				<input type="hidden" name="action" value="<?php echo $action;?>">
				<input type="hidden" name="route_id" value="<?php echo $route_id;?>">
				<input type="hidden" name="class_id" value="<?php echo $route_data->class_id;?>">
				<input type="hidden" name="subject_id" value="<?php echo $route_data->subject_id;?>">
				<input type="hidden" name="class_section_id" value="<?php echo $route_data->section_name;?>">
				<input type="hidden" name="duration" value="<?php echo $duration;?>">
				<input type="hidden" name="weekday" value="<?php echo $route_data->weekday;?>">
				<input type="hidden" name="start_time" value="<?php echo $start_time;?>">
				<input type="hidden" name="end_time" value="<?php echo $end_time;?>">
				<input type="hidden" name="teacher_id" value="<?php echo $route_data->teacher_id;?>">
				<div class="form-body user_form "><!--user_form div--> 
					<div class="row">
						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
							<div class="form-group input">
								<div class="col-md-12 form-control">
									<input id="class_name" class="form-control" maxlength="50" type="text" value="<?php echo mj_smgt_get_class_name($route_data->class_id); ?>" name="class_name" disabled>
									<label class="active" for="username"><?php esc_attr_e('Class Name','school-mgt');?></label>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
							<div class="form-group input">
								<div class="col-md-12 form-control">
									<input id="class_section" class="form-control" maxlength="50" type="text" value="<?php echo mj_smgt_get_section_name($route_data->section_name); ?>" name="class_section" disabled>
									<label class="active" for="username"><?php esc_attr_e('Class Section','school-mgt');?></label>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
							<div class="form-group input">
								<div class="col-md-12 form-control">
									<input id="subject" class="form-control" type="text" value="<?php echo mj_smgt_get_single_subject_name($route_data->subject_id); ?>" name="class_section" disabled>
									<label class="active" for="username"><?php esc_attr_e('Subject','school-mgt');?></label>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
							<div class="form-group input">
								<div class="col-md-12 form-control">
									<input id="start_time" class="form-control" type="text" value="<?php echo $start_time; ?>" name="start_time" disabled>
									<label class="active" for="username"><?php esc_attr_e('Start Time','school-mgt');?></label>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
							<div class="form-group input">
								<div class="col-md-12 form-control">
									<input id="end_time" class="form-control" type="text" value="<?php echo $end_time; ?>" name="end_time" disabled>
									<label class="active" for="username"><?php esc_attr_e('End Time','school-mgt');?></label>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 virtual_error_msg_left_margin">
							<div class="form-group input">
								<div class="col-md-12 form-control">
									<input id="start_date" class="form-control validate[required] text-input" type="text" name="start_date" value="<?php echo date("Y-m-d") ?>" readonly>
									<label class="active" for="username"><?php esc_attr_e('Start Date','school-mgt');?><span class="require-field">*</span></label>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
							<div class="form-group input">
								<div class="col-md-12 form-control">
									<input id="end_date" class="form-control validate[required] text-input" type="text" name="end_date" value="<?php echo date("Y-m-d") ?>" readonly>
									<label class="active" for="username"><?php esc_attr_e('End Date','school-mgt');?><span class="require-field">*</span></label>
								</div>
							</div>
						</div>
						<div class="col-md-6 note_text_notice">
							<div class="form-group input">
								<div class="col-md-12 note_border margin_bottom_15px_res">
									<div class="form-field">
										<textarea name="agenda" class="textarea_height_47px form-control validate[custom[address_description_validation]]" maxlength="250" id=""></textarea>
										<span class="txt-title-label"></span>
										<label class="text-area address active"><?php esc_attr_e('Topic','school-mgt');?></label>
									</div>
								</div>
							</div>
						</div>
						<?php wp_nonce_field( 'create_meeting_admin_nonce' ); ?>
						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
							<div class="form-group input">
								<div class="col-md-12 form-control">
									<input id="password" class="form-control validate[minSize[8],maxSize[12]]" type="password" value="" name="password">
									<label class="active" for="username"><?php esc_attr_e('Password','school-mgt');?></label>
								</div>
							</div>
						</div>
					</div>
				</div><!--user_form div--> 
				<div class="form-body user_form"><!--user_form div--> 
					<div class="row">
						<div class="col-sm-6">        	
							<input type="submit" value="<?php if($edit){ esc_attr_e('Save Virtual Class','school-mgt'); }else{ esc_attr_e('Create Virtual Class','school-mgt');}?>" name="create_meeting" class="save_btn btn btn-success" />
						</div>     
					</div>
				</div><!--user_form div-->    
    		</form>
    	</div>
	</div><!---------- Penal white --------->
	<?php
	exit;
}
// VIEW MEETING DATA FUNCTION
function mj_smgt_ajax_view_meeting_detail()
{

	$obj_virtual_classroom = new mj_smgt_virtual_classroom;

	$meeting_id = $_REQUEST['meeting_id'];

	$class_data = $obj_virtual_classroom->mj_smgt_get_singal_meeting_data_in_zoom($meeting_id);

	?>

	<script type="text/javascript">

		function copy_text()

		{



			var temp = $("<input>");

		  	$("body").append(temp);

		 	temp.val($('.copy_text').text()).select();

		  	document.execCommand("copy");



		}

	</script>



	<div class="modal-header">

		<a href="#" class="close-btn badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>

		<h4 class="modal-title"><?php esc_attr_e('Virtual Class Details','school-mgt');?></h4>

	</div>

	<div class="panel-white form-horizontal view_notice_overflow" style="padding: 20px;">

		<div class="row">

			<div class="col-md-6 popup_padding_15px">

				<label for="" class="popup_label_heading"><?php esc_attr_e('Meeting ID','school-mgt'); ?></label><br>

				<label for="" class="label_value"><?php echo $class_data->zoom_meeting_id; ?></label>

			</div>

			<div class="col-md-6 popup_padding_15px">

				<label for="" class="popup_label_heading"><?php esc_attr_e('Meeting Title','school-mgt'); ?></label><br>

				<label for="" class="label_value"><?php echo $class_data->title; ?></label>

			</div>

			<div class="col-md-6 popup_padding_15px">

				<label for="" class="popup_label_heading"><?php esc_attr_e('Class Name','school-mgt'); ?></label><br>

				<label for="" class="label_value"><?php echo mj_smgt_get_class_name($class_data->class_id); ?></label>

			</div>

			<div class="col-md-6 popup_padding_15px">

				<label for="" class="popup_label_heading"><?php esc_attr_e('Section Name','school-mgt'); ?></label><br>

				<label for="" class="label_value"><?php if(!empty($class_data->section_id)){ echo mj_smgt_get_section_name($class_data->section_id); }else{ echo "N/A"; } ?></label>

			</div>

			<div class="col-md-6 popup_padding_15px">

				<label for="" class="popup_label_heading"><?php esc_attr_e('Start Date','school-mgt'); ?></label><br>

				<label for="" class="label_value"><?php echo mj_smgt_getdate_in_input_box($class_data->start_date); ?></label>

			</div>

			<div class="col-md-6 popup_padding_15px">

				<label for="" class="popup_label_heading"><?php esc_attr_e('End Date','school-mgt'); ?></label><br>

				<label for="" class="label_value"><?php echo mj_smgt_getdate_in_input_box($class_data->end_date); ?></label>

			</div>

			<div class="col-md-6 popup_padding_15px">

				<label for="" class="popup_label_heading"><?php esc_attr_e('Password','school-mgt'); ?></label><br>

				<label for="" class="label_value"><?php echo $class_data->password; ?></label>

			</div>

			<div class="col-md-6 popup_padding_15px">

				<label for="" class="popup_label_heading"><?php esc_attr_e('Join Virtual Class Link','school-mgt'); ?></label><br>

				<div class="copy_text">

					<label for="" class="label_value word_brack"><?php echo $class_data->meeting_join_link; ?></label>

				</div>

			</div>

			<div class="col-md-12 popup_padding_15px">

				<label for="" class="popup_label_heading"><?php esc_attr_e('Agenda','school-mgt'); ?></label><br>

				<label for="" class="label_value"><?php if(!empty($class_data->agenda)){ echo $class_data->agenda; }else{ echo "N/A"; }  ?></label>

			</div>

			<div class="col-md-3">
				<button type="button" onclick="copy_text();" class="save_btn btn btn-success"><?php esc_attr_e('Copy Link','school-mgt');?></button>
			</div>
		</div>

	</div>

	<?php

	exit;

}
function mj_smgt_refresh_token()
{ 
	require_once SMS_PLUGIN_DIR. '/lib/vendor/autoload.php'; 
	$CLIENT_ID = get_option('smgt_virtual_classroom_client_id');
	$CLIENT_SECRET = get_option('smgt_virtual_classroom_client_secret_id');
	$arr_token = get_option('smgt_virtual_classroom_access_token');
    $token_decode = json_decode($arr_token);
    $refresh_token = $token_decode->refresh_token;
	$client = new GuzzleHttp\Client(['base_uri' => 'https://zoom.us']);
    $response = $client->request('POST', '/oauth/token', [
        'headers' => [
            "Authorization" => "Basic ". base64_encode($CLIENT_ID.':'.$CLIENT_SECRET)
        ],
        'query' => [
            "grant_type" => "refresh_token",
            "refresh_token" => $refresh_token
        ],
    ]); 
    $token = $response->getBody()->getContents();
    update_option( 'smgt_virtual_classroom_access_token', $token );

}

// ACCESS TOKAN REAFRESH FUNCTION
add_filter( 'cron_schedules', 'mj_smgt_isa_add_every_thirty_minutes' );
function mj_smgt_isa_add_every_thirty_minutes( $schedules ) 
{
    $schedules['every_thirty_minutes'] = array(
            'interval'  => 1800,
            'display'   => esc_attr__( 'Every 30 Minutes', 'textdomain' )
    );
    return $schedules;
}

// Schedule an action if it's not already scheduled
if ( ! wp_next_scheduled( 'mj_smgt_isa_add_every_thirty_minutes' ) ) 
{
    wp_schedule_event( time(), 'every_thirty_minutes', 'mj_smgt_isa_add_every_thirty_minutes' );
}

// Hook into that action that'll fire every three minutes
add_action( 'mj_smgt_isa_add_every_thirty_minutes', 'mj_smgt_every_thirty_minutes_event_func' );
function mj_smgt_every_thirty_minutes_event_func() 
{
    mj_smgt_refresh_token();
}
function mj_smgt_get_receiver_name_array($message_id,$sender_id,$created_date,$message_comment)
{
	$message_id=(int)$message_id;
	$sender_id=(int)$sender_id;
	global $wpdb;
	$new_name_array=array();
	$receiver_name=array();
	$tbl_name = $wpdb->prefix .'smgt_message_replies';
	$reply_msg =$wpdb->get_results("SELECT receiver_id  FROM $tbl_name where message_id = $message_id AND sender_id = $sender_id AND message_comment='$message_comment' OR created_date='$created_date'");
	if (!empty($reply_msg)) {
		foreach ($reply_msg as $receiver_id) {
			$receiver_name[]=mj_smgt_get_display_name($receiver_id->receiver_id);
		}
	}
	$new_name_array=implode(", ",$receiver_name);
	return $new_name_array;
}
// VIRCHUAL CLASSROOM REMINDER MAIN CROM FUNCTION
add_filter( 'cron_schedules', 'mj_smgt_isa_add_every_five_minutes' );
function mj_smgt_isa_add_every_five_minutes( $schedules ) 
{
    $schedules['every_five_minutes'] = array(
            'interval'  => 300,
            'display'   => esc_attr__( 'Every 5 Minutes', 'textdomain' )
    );
    return $schedules;
}

// Schedule an action if it's not already scheduled
if ( ! wp_next_scheduled( 'mj_smgt_isa_add_every_five_minutes' ) ) 
{
    wp_schedule_event( time(), 'every_five_minutes', 'mj_smgt_isa_add_every_five_minutes' );
}

// Hook into that action that'll fire every three minutes
add_action( 'mj_smgt_isa_add_every_five_minutes', 'mj_smgt_every_five_minutes_event_func' );
function mj_smgt_every_five_minutes_event_func() 
{
    mj_smgt_virtual_class_mail_reminder();
}
// VIRTUAL CLASS MAIL REMINDER FUNCTION

function mj_smgt_virtual_class_mail_reminder()
{
	$obj_virtual_classroom = new mj_smgt_virtual_classroom;
	$virtual_classroom_enable = get_option('smgt_enable_virtual_classroom');
	$virtual_classroom_reminder_enable = get_option('smgt_enable_virtual_classroom_reminder');
	$virtual_classroom_reminder_time = get_option('smgt_virtual_classroom_reminder_before_time');
	$smgt_enable_sms_virtual_classroom_reminder = get_option('smgt_enable_sms_virtual_classroom_reminder');
	
	if($smgt_enable_sms_virtual_classroom_reminder == 'yes' OR $virtual_classroom_enable == 'yes' OR $virtual_classroom_reminder_enable == 'yes')
	{
		// day code counvert zoom data wise
		$today_day = date('w');
		if ($today_day == '1')
		{
			$weekday = 2;
		}
		elseif($today_day == '2')
		{
			$weekday = 3;
		}
		elseif($today_day == '3')
		{
			$weekday = 4;
		}
		elseif($today_day == '4')
		{
			$weekday = 5;
		}
		elseif($today_day == '5')
		{
			$weekday = 6;
		}
		elseif($today_day == '6')
		{
			$weekday = 7;
		}
		elseif($today_day == '7')
		{
			$weekday = 1;
		}
		$virtual_classroom_data = $obj_virtual_classroom->mj_smgt_get_meeting_data_by_day_in_zoom($weekday);
		
		if (!empty($virtual_classroom_data))
		{ 
			 foreach ($virtual_classroom_data as $data)
			{ 
				$route_data = mj_smgt_get_route_by_id($data->route_id);
				// time class start counver in formate
				$stime = explode(":",$route_data->start_time);
				$start_hour=str_pad($stime[0],2,"0",STR_PAD_LEFT);
				$start_min=str_pad($stime[1],2,"0",STR_PAD_LEFT);
				$start_am_pm=$stime[2];
				$start_time = $start_hour.':'.$start_min.' '.$start_am_pm;
				// class start time counvert in 24 hours fourmet
				$starttime = date("H:i", strtotime($start_time));
				// git cuurunt time
				$currunt_time = current_time('h:i:s');
				// minuse time in minutes
				$duration = '-'.$virtual_classroom_reminder_time.' minutes';
				$class_time = strtotime($duration, strtotime($starttime));
				$befour_class_time = date('h:i:s', $class_time);
				// check time cundition
				 if($currunt_time >= $befour_class_time)
				{ 
					if($smgt_enable_sms_virtual_classroom_reminder == 'yes' && $virtual_classroom_enable == 'yes' && $virtual_classroom_reminder_enable == 'yes')
					{
						mj_smgt_virtual_class_teacher_mail_reminder($data->meeting_id);
						mj_smgt_virtual_class_students_mail_reminder($data->meeting_id);
						mj_smgt_virtual_class_teacher_sms_reminder($data->meeting_id);
						mj_smgt_virtual_class_students_sms_reminder($data->meeting_id);

					}
					if($smgt_enable_sms_virtual_classroom_reminder == 'yes' && $virtual_classroom_enable == 'yes')
					{	
						mj_smgt_virtual_class_teacher_sms_reminder($data->meeting_id);
						mj_smgt_virtual_class_students_sms_reminder($data->meeting_id);
					}
					if($virtual_classroom_enable == 'yes' && $virtual_classroom_reminder_enable == 'yes')
					{
						mj_smgt_virtual_class_teacher_mail_reminder($data->meeting_id);
						mj_smgt_virtual_class_students_mail_reminder($data->meeting_id);
					}
				}
			}
		}
	}
}
// add_action('init' , 'mj_smgt_virtual_class_teacher_mail_reminder');
// VIRTUAL CLASS TEACHER MAIL REMINDER FUNCTION
function mj_smgt_virtual_class_teacher_mail_reminder($meeting_id)
{
	//$meeting_id = 1;
	// define virtual classroom object
	$obj_virtual_classroom = new mj_smgt_virtual_classroom;
	// get singal virtual classroom data by meeting id
	$meeting_data = $obj_virtual_classroom->mj_smgt_get_singal_meeting_data_in_zoom($meeting_id);
	
	// get class name by class id
	$clasname = mj_smgt_get_class_name($meeting_data->class_id);
	// get subject name by subject id
	$subjectname = mj_smgt_get_single_subject_name($meeting_data->subject_id);
	// today date function
	$today_date = mj_smgt_getdate_in_input_box(date("Y-m-d")); //date(get_option('date_format'));
	// teacher name
	$teacher_name = mj_smgt_get_display_name($meeting_data->teacher_id);
	// teacher all data
	$teacher_all_data = get_userdata($meeting_data->teacher_id);
	// get route data by rout id
	$route_data = mj_smgt_get_route_by_id($meeting_data->route_id);
	// class start time data 
	
	$start_time_123 = $route_data->start_time;
	// $starttime =MJ_start_time_convert($start_time_new);
	$end_time_123 = $route_data->end_time;
	// $edittime=MJ_end_time_convert($end_time_new);

	$start_time_data = explode(":", $start_time_123);
	$start_hour=str_pad($start_time_data[0],2,"0",STR_PAD_LEFT);
	$start_min=str_pad($start_time_data[1],2,"0",STR_PAD_LEFT);
	$start_am_pm=$start_time_data[2];
	$start_time_new=$start_hour.':'.$start_min.' '.$start_am_pm;
	$starttime  = date("H:i", strtotime($start_time_new));

	$end_time_data = explode(":", $end_time_123);
	$end_hour=str_pad($end_time_data[0],2,"0",STR_PAD_LEFT);
	$end_min=str_pad($end_time_data[1],2,"0",STR_PAD_LEFT);
	$end_am_pm=$end_time_data[2];
	$end_time_new=$end_hour.':'.$end_min.' '.$end_am_pm;
	$edittime  = date("H:i", strtotime($end_time_new));
	
	/*$stime = explode(":",$route_data->start_time);
	$start_hour=str_pad($stime[0],2,"0",STR_PAD_LEFT);
	$start_min=str_pad($stime[1],2,"0",STR_PAD_LEFT);
	$start_am_pm=$stime[2];
	$start_time = $start_hour.':'.$start_min.' '.$start_am_pm;
	$start_time_data = new DateTime($start_time); 
	$starttime=date_format($start_time_data,'h:i A');
	// class end time function
	$etime = explode(":",$route_data->end_time);
	$end_hour=str_pad($etime[0],2,"0",STR_PAD_LEFT);
	$end_min=str_pad($etime[1],2,"0",STR_PAD_LEFT);
	$end_am_pm=$etime[2];
	$end_time = $end_hour.':'.$end_min.' '.$end_am_pm;
	$end_time_data = new DateTime($end_time); 
	$edittime=date_format($end_time_data,'h:i A');*/
	// concat start time and end time
	$time = $starttime.' TO '.$edittime;
	// start zoom virtual class link data
	$start_zoom_virtual_class_link = "<p><a href=".$meeting_data->meeting_start_link." class='btn btn-primary'>". esc_attr__('Start Virtual Class','school-mgt')."</a></p><br><br>";
	$log_date = date("Y-m-d", strtotime($today_date));
	$mail_reminder_log_data = mj_smgt_cheack_virtual_class_mail_reminder_log_data($meeting_data->teacher_id,$meeting_data->meeting_id,$meeting_data->class_id,$log_date);
	if(empty($mail_reminder_log_data))
	{
		// send mail data
		$string = array();
		$string['{{teacher_name}}'] = "<span>".$teacher_name."</span><br><br>";
		$string['{{class_name}}'] = "<span>".$clasname."</span><br><br>";
		$string['{{subject_name}}'] = "<span>".$subjectname."</span><br><br>";
		$string['{{date}}'] = "<span>".$today_date."</span><br><br>";
		$string['{{time}}'] = "<span>".$time."</span><br><br>";
		$string['{{virtual_class_id}}'] = "<span>".$meeting_data->zoom_meeting_id."</span><br><br>";
		$string['{{password}}'] = "<span>".$meeting_data->password."</span><br><br>";
		$string['{{start_zoom_virtual_class}}'] = $start_zoom_virtual_class_link;
		$string['{{school_name}}'] = "<span>".get_option('smgt_school_name')."</span><br><br>";
		$MsgContent = get_option('virtual_class_teacher_reminder_mail_content');
		$MsgSubject	= get_option('virtual_class_teacher_reminder_mail_subject');
		$message = mj_smgt_string_replacement($string,$MsgContent);
		$MsgSubject = mj_smgt_string_replacement($string,$MsgSubject);
		
		$email= $teacher_all_data->user_email;
		$fromemail = get_option('smgt_email');
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/plain; charset=iso-8859-1\r\n";
		
		if(get_option('smgt_mail_notification') == '1')
		{
			wp_mail($email,$MsgSubject,$message,$headers);	
		}
		
		mj_smgt_insert_virtual_class_mail_reminder_log($meeting_data->teacher_id,$meeting_data->meeting_id,$meeting_data->class_id,$log_date);
	}
	
}
// VIRTUAL CLASS STUDENTS MAIL REMINDER FUNCTION
function mj_smgt_virtual_class_students_mail_reminder($meeting_id)
{
	// define virtual classroom object
	$obj_virtual_classroom = new mj_smgt_virtual_classroom;
	// get singal virtual classroom data by meeting id
	$meeting_data = $obj_virtual_classroom->mj_smgt_get_singal_meeting_data_in_zoom($meeting_id);
	$sections_data = mj_smgt_get_class_sections($meeting_data->class_id);
	if(!empty($sections_data))
	{
		foreach($sections_data as $data)
		{
			if($meeting_data->section_id == $data->id)
			{
				$student_data = get_users(array('meta_key' => 'class_section', 'meta_value' =>$data->id,'meta_query'=> array(array('key' => 'class_name','value' => $data->class_id,'compare' => '=')),'role'=>'student'));
			}
		}
	}
	else
	{
		$student_data = mj_smgt_get_student_by_class_id($meeting_data->class_id);
	}
	// get class name by class id
	$clasname = mj_smgt_get_class_name($meeting_data->class_id);
	// get subject name by subject id
	$subjectname = mj_smgt_get_single_subject_name($meeting_data->subject_id);
	// today date function
	$today_date = mj_smgt_getdate_in_input_box(date("Y-m-d"));  //date(get_option('date_format'));
	// teacher name
	$teacher_name = mj_smgt_get_display_name($meeting_data->teacher_id);
	// get route data by rout id
	$route_data = mj_smgt_get_route_by_id($meeting_data->route_id);
	// class start time data 
	$start_time_123 = $route_data->start_time;
	// $starttime =MJ_start_time_convert($start_time_new);
	$end_time_123 = $route_data->end_time;
	// $edittime=MJ_end_time_convert($end_time_new);

	$start_time_data = explode(":", $start_time_123);
	$start_hour=str_pad($start_time_data[0],2,"0",STR_PAD_LEFT);
	$start_min=str_pad($start_time_data[1],2,"0",STR_PAD_LEFT);
	$start_am_pm=$start_time_data[2];
	$start_time_new=$start_hour.':'.$start_min.' '.$start_am_pm;
	$starttime  = date("H:i", strtotime($start_time_new));

	$end_time_data = explode(":", $end_time_123);
	$end_hour=str_pad($end_time_data[0],2,"0",STR_PAD_LEFT);
	$end_min=str_pad($end_time_data[1],2,"0",STR_PAD_LEFT);
	$end_am_pm=$end_time_data[2];
	$end_time_new=$end_hour.':'.$end_min.' '.$end_am_pm;
	$edittime  = date("H:i", strtotime($end_time_new));
	/*$stime = explode(":",$route_data->start_time);
	$start_hour=str_pad($stime[0],2,"0",STR_PAD_LEFT);
	$start_min=str_pad($stime[1],2,"0",STR_PAD_LEFT);
	$start_am_pm=$stime[2];
	$start_time = $start_hour.':'.$start_min.' '.$start_am_pm;
	$start_time_data = new DateTime($start_time); 
	$starttime=date_format($start_time_data,'h:i A');*/
	// class end time function
	/*$etime = explode(":",$route_data->end_time);
	$end_hour=str_pad($etime[0],2,"0",STR_PAD_LEFT);
	$end_min=str_pad($etime[1],2,"0",STR_PAD_LEFT);
	$end_am_pm=$etime[2];
	$end_time = $end_hour.':'.$end_min.' '.$end_am_pm;
	$end_time_data = new DateTime($end_time); 
	$edittime=date_format($end_time_data,'h:i A');*/
	// concat start time and end time
	$time = $starttime.' TO '.$edittime;

	// start zoom virtual class link data
	$join_zoom_virtual_class_link = "<p><a href=".$meeting_data->meeting_join_link." class='btn btn-primary'>". esc_attr__('Join Virtual Class','school-mgt')."</a></p><br><br>";
	if(!empty($student_data))
	{
		foreach($student_data as $data)
		{
			$log_date = date("Y-m-d", strtotime($today_date));
			$mail_reminder_log_data = mj_smgt_cheack_virtual_class_mail_reminder_log_data($data->ID,$meeting_data->meeting_id,$meeting_data->class_id,$log_date);
			if(empty($mail_reminder_log_data))
			{
				$student_name = mj_smgt_get_display_name($data->ID);
				$string = array();
				$string['{{student_name}}'] = "<span>".$student_name."</span><br><br>";
				$string['{{class_name}}'] = "<span>".$clasname."</span><br><br>";
				$string['{{subject_name}}'] = "<span>".$subjectname."</span><br><br>";
				$string['{{teacher_name}}'] = "<span>".$teacher_name."</span><br><br>";
				$string['{{date}}'] = "<span>".$today_date."</span><br><br>";
				$string['{{time}}'] = "<span>".$time."</span><br><br>";
				$string['{{virtual_class_id}}'] = "<span>".$meeting_data->zoom_meeting_id."</span><br><br>";
				$string['{{password}}'] = "<span>".$meeting_data->password."</span><br><br>";
				$string['{{join_zoom_virtual_class}}'] = $join_zoom_virtual_class_link;
				$string['{{school_name}}'] = "<span>".get_option('smgt_school_name')."</span><br><br>";
				$MsgContent = get_option('virtual_class_student_reminder_mail_content');
				$MsgSubject	= get_option('virtual_class_student_reminder_mail_subject');
				$message = mj_smgt_string_replacement($string,$MsgContent);
				$MsgSubject = mj_smgt_string_replacement($string,$MsgSubject);
				$email= 'vijay.rathod@dasinfomedia.com';
				$email= $data->user_email;
				$fromemail = get_option('smgt_email');
				$headers = "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/plain; charset=iso-8859-1\r\n";
				if(get_option('smgt_mail_notification') == '1')
				{
					wp_mail($email,$MsgSubject,$message,$headers);
				}
				mj_smgt_insert_virtual_class_mail_reminder_log($data->ID,$meeting_data->meeting_id,$meeting_data->class_id,$log_date);
			}
		}
	}
}


// VIRTUAL CLASS TEACHER SMS REMINDER FUNCTION
function mj_smgt_virtual_class_teacher_sms_reminder($meeting_id)
{
	// define virtual classroom object
	$obj_virtual_classroom = new mj_smgt_virtual_classroom;
	// get singal virtual classroom data by meeting id
	$meeting_data = $obj_virtual_classroom->mj_smgt_get_singal_meeting_data_in_zoom($meeting_id);
	// get class name by class id
	$clasname = mj_smgt_get_class_name($meeting_data->class_id);
	// get subject name by subject id
	$subjectname = mj_smgt_get_single_subject_name($meeting_data->subject_id);
	// today date function
	$today_date = date(get_option('date_format'));
	// teacher name
	$teacher_name = mj_smgt_get_display_name($meeting_data->teacher_id);
	// teacher all data
	$teacher_all_data = get_userdata($meeting_data->teacher_id);
	// get route data by rout id
	$route_data = mj_smgt_get_route_by_id($meeting_data->route_id);
	// class start time data 
	$stime = explode(":",$route_data->start_time);
	$start_hour=str_pad($stime[0],2,"0",STR_PAD_LEFT);
	$start_min=str_pad($stime[1],2,"0",STR_PAD_LEFT);
	$start_am_pm=$stime[2];
	$start_time = $start_hour.':'.$start_min.' '.$start_am_pm;
	$start_time_data = new DateTime($start_time); 
	$starttime=date_format($start_time_data,'h:i A');
	// class end time function
	$etime = explode(":",$route_data->end_time);
	$end_hour=str_pad($etime[0],2,"0",STR_PAD_LEFT);
	$end_min=str_pad($etime[1],2,"0",STR_PAD_LEFT);
	$end_am_pm=$etime[2];
	$end_time = $end_hour.':'.$end_min.' '.$end_am_pm;
	$end_time_data = new DateTime($end_time); 
	$edittime=date_format($end_time_data,'h:i A');
	// concat start time and end time
	$time = $starttime.' TO '.$edittime;
	// start zoom virtual class link data
	$start_zoom_virtual_class_link = "<p><a href=".$meeting_data->meeting_start_link." class='btn btn-primary'>". esc_attr__('Start Virtual Class','school-mgt')."</a></p><br><br>";
	$log_date = date("Y-m-d", strtotime($today_date));
	$mail_reminder_log_data = mj_smgt_cheack_virtual_class_mail_reminder_log_data($meeting_data->teacher_id,$meeting_data->meeting_id,$meeting_data->class_id,$log_date);
	if(empty($mail_reminder_log_data))
	{
		$number=get_user_meta($meeting_data->teacher_id, 'mobile_number',true);
		$student_number= "+".mj_smgt_get_countery_phonecode(get_option( 'smgt_contry' )).$number;
		$message_content = "Your virtual class just start";
		$current_sms_service 	= 	get_option( 'smgt_sms_service');	
		if(is_plugin_active('sms-pack/sms-pack.php'))
		{								
			$args = array();
			$args['mobile']=$student_number;
			$args['message']=$message_content;					
			$args['message_from']='attendanace';					
			$args['message_side']='front';					
			if($current_sms_service=='telerivet' || $current_sms_service ="MSG91" || $current_sms_service=='bulksmsnigeria' || $current_sms_service=='bulksmsgateway.in' || $current_sms_service=='textlocal.in' ||$current_sms_service=='ViaNettSMS' || $current_sms_service=='africastalking')
			{
				$send = send_sms($args);					
			}
		}
		else
		{							
			$reciever_number = "+".mj_smgt_get_countery_phonecode(get_option( 'smgt_contry' )).get_user_meta($meeting_data->teacher_id, 'mobile_number',true);		
			$message_content = "Your virtual class just start";
			if($current_sms_service == 'clickatell')
			{
				$clickatell=get_option('smgt_clickatell_sms_service');
				$to = $reciever_number;
				$message = str_replace(" ","%20",$message_content);
				$username = $clickatell['username']; //clickatell username
				$password = $clickatell['password']; // clickatell password
				$api_key = $clickatell['api_key'];//clickatell apikey
				$baseurl ="http://api.clickatell.com";									
				$url = "$baseurl/http/auth?user=$username&password=$password&api_id=$api_key";									
				$ret = file($url);									
				$sess = explode(":",$ret[0]);
				if ($sess[0] == "OK")
				{
					$sess_id = trim($sess[1]); // remove any whitespace
					$url = "$baseurl/http/sendmsg?session_id=$sess_id&to=$to&text=$message";									
					$ret = file($url);
					$send = explode(":",$ret[0]);										
				}				
			}
			if($current_sms_service == 'twillo')
			{
				require_once SMS_PLUGIN_DIR. '/lib/twilio/Services/Twilio.php';
				$twilio=get_option( 'smgt_twillo_sms_service');
				$account_sid = $twilio['account_sid']; //Twilio SID
				$auth_token = $twilio['auth_token']; // Twilio token
				$from_number = $twilio['from_number'];//My number
				$receiver = $reciever_number; //Receiver Number
				$message = $message_content; // Message Text									
				$client = new Services_Twilio($account_sid, $auth_token);
				$message_sent = $client->account->messages->sendMessage(
					$from_number, // From a valid Twilio number
					$receiver, // Text this number
					$message
				);				
			}
			if($current_sms_service == 'msg91')
			{
				//MSG91
				$mobile_number=get_user_meta($meeting_data->teacher_id, 'mobile_number',true);
				$country_code="+".mj_smgt_get_countery_phonecode(get_option( 'smgt_contry' ));
				$message = $message_content; // Message Text
				smgt_msg91_send_mail_function($mobile_number,$message,$country_code);
			}								
		} 
		mj_smgt_insert_virtual_class_mail_reminder_log($meeting_data->teacher_id,$meeting_data->meeting_id,$meeting_data->class_id,$log_date);
	}
}
// VIRTUAL CLASS STUDENTS SMS REMINDER FUNCTION
function mj_smgt_virtual_class_students_sms_reminder($meeting_id)
{
	// define virtual classroom object
	$obj_virtual_classroom = new mj_smgt_virtual_classroom;
	// get singal virtual classroom data by meeting id
	$meeting_data = $obj_virtual_classroom->mj_smgt_get_singal_meeting_data_in_zoom($meeting_id);
	$sections_data = mj_smgt_get_class_sections($meeting_data->class_id);
	if(!empty($sections_data))
	{
		foreach($sections_data as $data)
		{
			if($meeting_data->section_id == $data->id)
			{
				$student_data = get_users(array('meta_key' => 'class_section', 'meta_value' =>$data->id,'meta_query'=> array(array('key' => 'class_name','value' => $data->class_id,'compare' => '=')),'role'=>'student'));
			}
		}
	}
	else
	{
		$student_data = mj_smgt_get_student_by_class_id($meeting_data->class_id);
	}
	// get class name by class id
	$clasname = mj_smgt_get_class_name($meeting_data->class_id);
	// get subject name by subject id
	$subjectname = mj_smgt_get_single_subject_name($meeting_data->subject_id);
	// today date function
	$today_date = date(get_option('date_format'));
	// teacher name
	$teacher_name = mj_smgt_get_display_name($meeting_data->teacher_id);
	// get route data by rout id
	$route_data = mj_smgt_get_route_by_id($meeting_data->route_id);
	// class start time data 
	$stime = explode(":",$route_data->start_time);
	$start_hour=str_pad($stime[0],2,"0",STR_PAD_LEFT);
	$start_min=str_pad($stime[1],2,"0",STR_PAD_LEFT);
	$start_am_pm=$stime[2];
	$start_time = $start_hour.':'.$start_min.' '.$start_am_pm;
	$start_time_data = new DateTime($start_time); 
	$starttime=date_format($start_time_data,'h:i A');
	// class end time function
	$etime = explode(":",$route_data->end_time);
	$end_hour=str_pad($etime[0],2,"0",STR_PAD_LEFT);
	$end_min=str_pad($etime[1],2,"0",STR_PAD_LEFT);
	$end_am_pm=$etime[2];
	$end_time = $end_hour.':'.$end_min.' '.$end_am_pm;
	$end_time_data = new DateTime($end_time); 
	$edittime=date_format($end_time_data,'h:i A');
	// concat start time and end time
	$time = $starttime.' TO '.$edittime;
	// start zoom virtual class link data
	$join_zoom_virtual_class_link = "<p><a href=".$meeting_data->meeting_join_link." class='btn btn-primary'>". esc_attr__('Join Virtual Class','school-mgt')."</a></p><br><br>";
	if(!empty($student_data))
	{
		foreach($student_data as $data)
		{
			$number=get_user_meta($data->ID, 'mobile_number',true);
			$student_number= "+".mj_smgt_get_countery_phonecode(get_option( 'smgt_contry' )).$number;
			$message_content = "Your virtual class just start";
			$current_sms_service 	= 	get_option( 'smgt_sms_service');	
			if(is_plugin_active('sms-pack/sms-pack.php'))
			{								
				$args = array();
				$args['mobile']=$student_number;
				$args['message']=$message_content;					
				$args['message_from']='attendanace';					
				$args['message_side']='front';					
				if($current_sms_service=='telerivet' || $current_sms_service ="MSG91" || $current_sms_service=='bulksmsnigeria' || $current_sms_service=='bulksmsgateway.in' || $current_sms_service=='textlocal.in' ||$current_sms_service=='ViaNettSMS' || $current_sms_service=='africastalking')
				{
					$send = send_sms($args);					
				}
			}
			else
			{							
				$reciever_number = "+".mj_smgt_get_countery_phonecode(get_option( 'smgt_contry' )).get_user_meta($data->ID, 'mobile_number',true);		
				$message_content = "Your virtual class just start";
				if($current_sms_service == 'clickatell')
				{
					$clickatell=get_option('smgt_clickatell_sms_service');
					$to = $reciever_number;
					$message = str_replace(" ","%20",$message_content);
					$username = $clickatell['username']; //clickatell username
					$password = $clickatell['password']; // clickatell password
					$api_key = $clickatell['api_key'];//clickatell apikey
					$baseurl ="http://api.clickatell.com";									
					$url = "$baseurl/http/auth?user=$username&password=$password&api_id=$api_key";									
					$ret = file($url);									
					$sess = explode(":",$ret[0]);
					if ($sess[0] == "OK")
					{
						$sess_id = trim($sess[1]); // remove any whitespace
						$url = "$baseurl/http/sendmsg?session_id=$sess_id&to=$to&text=$message";									
						$ret = file($url);
						$send = explode(":",$ret[0]);										
					}				
				}
				if($current_sms_service == 'twillo')
				{
					require_once SMS_PLUGIN_DIR. '/lib/twilio/Services/Twilio.php';
					$twilio=get_option( 'smgt_twillo_sms_service');
					$account_sid = $twilio['account_sid']; //Twilio SID
					$auth_token = $twilio['auth_token']; // Twilio token
					$from_number = $twilio['from_number'];//My number
					$receiver = $reciever_number; //Receiver Number
					$message = $message_content; // Message Text									
					$client = new Services_Twilio($account_sid, $auth_token);
					$message_sent = $client->account->messages->sendMessage(
						$from_number, // From a valid Twilio number
						$receiver, // Text this number
						$message
					);				
				}
				if($current_sms_service == 'msg91')
				{
					//MSG91
					$mobile_number=get_user_meta($data->ID, 'mobile_number',true);
					$country_code="+".mj_smgt_get_countery_phonecode(get_option( 'smgt_contry' ));
					$message = $message_content; // Message Text
					smgt_msg91_send_mail_function($mobile_number,$message,$country_code);
				}								
			} 
			mj_smgt_insert_virtual_class_mail_reminder_log($data->ID,$meeting_data->meeting_id,$meeting_data->class_id,$log_date);
		}
	}
}


// INSERT VIRTUAL CLASS MAIL REMINDER LOG FUNCTION
function mj_smgt_insert_virtual_class_mail_reminder_log($user_id,$meeting_id,$class_id,$date)
{
	global $wpdb;
	$table_zoom_meeting_mail_reminder_log= $wpdb->prefix. 'smgt_reminder_zoom_meeting_mail_log';
	$meeting_log_data['user_id'] = $user_id;
	$meeting_log_data['meeting_id'] = $meeting_id;
	$meeting_log_data['class_id'] = $class_id;
	$meeting_log_data['alert_date'] = $date;
	$result=$wpdb->insert( $table_zoom_meeting_mail_reminder_log, $meeting_log_data );
}
// CHEACK VIRTUAL CLASS MAIL REMINDER LOG FUNCTION
function mj_smgt_cheack_virtual_class_mail_reminder_log_data($user_id,$meeting_id,$class_id,$date)
{
	global $wpdb;
	$table_zoom_meeting_mail_reminder_log= $wpdb->prefix. 'smgt_reminder_zoom_meeting_mail_log';
	$result = $wpdb->get_row("SELECT * FROM $table_zoom_meeting_mail_reminder_log WHERE user_id=$user_id AND meeting_id=$meeting_id AND class_id=$class_id AND alert_date='$date'");
	return $result;
}

 // Import data function //
function mj_smgt_import_data()
{

	?>
	<script>
		jQuery(document).ready(function($)
		{
			$('#inport_csv').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	
		});
	</script>
	<div class="modal-header import_csv_popup">
		<a href="#" class="close-btn-cat badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>
		<h4 class="modal-title"><?php esc_attr_e('Import Data','school-mgt');?></h4>
	</div>
	<form class="form-horizontal import_csv_popup_form" id="inport_csv" action="#" method="post" enctype="multipart/form-data">
		<div class="form-body user_form">
			<div class="row">
				<div class="col-md-9 input">
					<div class="form-group input rtl_margin_top_0px_popup">
						<div class="col-md-12 form-control res_rtl_height_50px">	
							<label for="" class="custom-control-label custom-top-label ml-2 margin_left_30px"><?php _e('Select CSV File','school-mgt');?><span class="require-field">*</span></label>
							<div class="col-sm-12">
								<input id="input-1" name="csv_file" type="file" class="file validate[required]">
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 margin_bottom_15">
					<button type="submit" class="btn save_btn" name="upload_csv_file"><?php esc_attr_e('Save','school-mgt');?></button>
				</div>
			</div>
		</div>
	</form>
    <?php 
	die();
}
function mj_smgt_calander_laungage()
{
	$lancode=get_locale();
	$code=substr($lancode,0,2);	
     return $code;
}
function mj_smgt_notice_for_value($notice_for)
{
	if($notice_for == 'teacher')
	{
		return 'Teacher';
	}
	elseif($notice_for == 'student')
	{
		return 'Student';
	}
	elseif($notice_for == 'parent')
	{
		return 'Parent';
	}
	elseif($notice_for == 'supportstaff')
	{
		return 'Support Staff';
	}
	else
	{
		return 'Support Staff';
	}
}
function mj_smgt_user_avatar_image_upload($type) 
{
	$imagepath =$file;  
	$parts = pathinfo($_FILES[$type]['name']);
	$inventoryimagename = mktime()."-"."student".".".$parts['extension'];
	$document_dir = WP_CONTENT_DIR ;
	$document_dir .= '/uploads/school_assets/';
	$document_path = $document_dir;
	if($imagepath != "")
	{	
		if(file_exists(WP_CONTENT_DIR.$imagepath))
		unlink(WP_CONTENT_DIR.$imagepath);
	}
	if (!file_exists($document_path)) 
	{
		mkdir($document_path, 0777, true);
	}	
	if (move_uploaded_file($_FILES[$type]['tmp_name'], $document_path.$inventoryimagename)) 
	{
		$imagepath= $inventoryimagename;	
	}
	return $imagepath;
}
function mj_smgt_get_all_class_created_by_user($user_id)
{
   global $wpdb;
   $table_name = $wpdb->prefix . "smgt_class";
   $results = $wpdb->get_results( "SELECT * FROM $table_name WHERE creater_id=".$user_id);
   return $results;
}
function mj_smgt_get_all_grade_data_by_user_id($tablenm)
{
	global $wpdb;
	$user_id=get_current_user_id();
	$table_name = $wpdb->prefix . $tablenm;
	return $retrieve_subjects = $wpdb->get_results("SELECT * FROM $table_name where creater_id
	=$user_id");
}
function mj_smgt_get_all_examhall_by_user_id($tablenm)
{
	global $wpdb;
	$user_id=get_current_user_id();
	$table_name = $wpdb->prefix . $tablenm;
	return $retrieve_subjects = $wpdb->get_results("SELECT * FROM $table_name where created_by=$user_id");
}
function mj_smgt_view_attendance_for_report($start_date,$end_date,$class_id,$status)
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'attendence';
	if($class_id == 'all_class')
	{
		if($status == 'all_status')
		{
		     $result =$wpdb->get_results("SELECT * FROM $tbl_name where role_name = 'student' and attendence_date between '$start_date' and '$end_date'");
	          return $result;
		}
		else
		{
			$result =$wpdb->get_results("SELECT * FROM $tbl_name where role_name = 'student' and attendence_date between '$start_date' and '$end_date' and status='$status'");
	        return $result;   
		}
	}
	else
	{
		if($status == 'all_status')
		{
			 $result =$wpdb->get_results("SELECT * FROM $tbl_name where role_name = 'student' and attendence_date between '$start_date' and '$end_date' and class_id=$class_id");
	         return $result;
		}
		else
		{
			$result =$wpdb->get_results("SELECT * FROM $tbl_name where role_name = 'student' and attendence_date between '$start_date' and '$end_date' and class_id=$class_id and status='$status'");
	        return $result;
		}
	}
}
function mj_smgt_view_attendance_report_for_start_date_enddate($start_date,$end_date)
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'attendence';
    $result =$wpdb->get_results("SELECT * FROM $tbl_name where role_name = 'student' and attendence_date between '$start_date' and '$end_date'");
	return $result;
}



function  mj_smgt_daily_attendance_report_for_all_class_total_present($daily_date)
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'attendence';
    $result =$wpdb->get_results("SELECT * FROM $tbl_name where role_name = 'student' AND attendence_date = '$daily_date' AND status='Present'");
	return count($result);
}
function  mj_smgt_daily_attendance_report_for_all_class_total_absent($daily_date)
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'attendence';
    $result =$wpdb->get_results("SELECT * FROM $tbl_name where role_name = 'student' AND attendence_date = '$daily_date' AND status='Absent'");
	return count($result);
}
function  mj_smgt_daily_attendance_report_for_date_total_present($daily_date,$class_id)
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'attendence';
    $result =$wpdb->get_results("SELECT * FROM $tbl_name where role_name = 'student' AND attendence_date = '$daily_date' AND class_id=$class_id AND status='Present'");
	return count($result);
}
function mj_smgt_daily_attendance_report_for_date_total_absent($daily_date,$class_id)
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'attendence';
    $result =$wpdb->get_results("SELECT * FROM $tbl_name where role_name = 'student' AND  attendence_date = '$daily_date' AND class_id=$class_id AND status='Absent'");
	return count($result);
}
//-----mj smgt_get assign_beds by hostel_id- Start ------//
function mj_smgt_get_assign_beds_by_hostel_id($hostel_id)
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'smgt_assign_beds';
    $result =$wpdb->get_results("SELECT * FROM $tbl_name where hostel_id = $hostel_id");
	return $result;
}
//-----  mj smgt_get assign_beds by hostel_id - End ------//
//-----get all assign_beds data- Start ------//
function mj_smgt_get_all_assign_beds()
{
	global $wpdb;
	$table_smgt_room=$wpdb->prefix.'smgt_assign_beds';
	$result=$wpdb->get_results("SELECT * FROM $table_smgt_room");
	return $result;
}
//-----get all assign_beds data- End ------//

//----- Assign beds data By student_id- Start ------//
function mj_smgt_assign_beds_student_id($student_id)
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'smgt_assign_beds';
    $result =$wpdb->get_results("SELECT * FROM $tbl_name where student_id = $student_id ");
	return $result;
}
//-----  hostel data By student_id - End ------//

//----- Total Attance Count By User_id & Class_id & Status - Start ------//
	function mj_smgt_attendance_report_get_status_for_student_id($start_date,$end_date,$class_id,$user_id,$status)
	{
		global $wpdb;
		$tbl_name = $wpdb->prefix .'attendence';
		$result =$wpdb->get_results("SELECT * FROM $tbl_name where  attendence_date between '$start_date' and '$end_date' and class_id=$class_id and user_id=$user_id and status = '$status'");
		return $result;
	}
//----- Total Attance Count By User_id & Class_id & Status - End ------//


//--------  book issued data by class-id and dastartdate-enddate - Start -------------//
function mj_smgt_check_book_issued_by_class_id_and_date($class_id,$start_date,$end_date)
{
	global $wpdb;
	$table_issuebook=$wpdb->prefix.'smgt_library_book_issue';
	$booklist = $wpdb->get_results("SELECT * FROM $table_issuebook where  issue_date between '$start_date' and '$end_date' and class_id=$class_id ");
	return $booklist;
}
//--------  book issued data by class-id and date - End -------------//

//------   book issued data by class-id and class_section_id and startdate-enddate - Start ----------//
function mj_smgt_check_book_issued_by_class_id_and_class_section_and_date($class_id,$class_section,$start_date,$end_date)
{
	global $wpdb;
	$table_issuebook=$wpdb->prefix.'smgt_library_book_issue';
	$booklist = $wpdb->get_results("SELECT * FROM $table_issuebook where  issue_date between '$start_date' and '$end_date' and class_id=$class_id and section_id=$class_section");
	return $booklist;
}
//--------  book issued data by class-id and class_section_id and startdate-enddate - End -------------//
//------   book issued data by startdate-enddate - Start ----------//
function mj_smgt_check_book_issued_by_startdate_and_enddate($start_date,$end_date)
{
	global $wpdb;
	$table_issuebook=$wpdb->prefix.'smgt_library_book_issue';
	$booklist = $wpdb->get_results("SELECT * FROM $table_issuebook where  issue_date between '$start_date' and '$end_date'");
	return $booklist;
}
//--------  book issued data by class-id and class_section_id and startdate-enddate - End -------------//


//----- view_attendance_status_for_date - Start ------//
	function mj_smgt_view_attendance_status_for_date($date,$class_id,$user_id)
	{
		global $wpdb;
		$tbl_name = $wpdb->prefix .'attendence';
		$result =$wpdb->get_results("SELECT status FROM $tbl_name WHERE user_id = $user_id AND class_id = $class_id AND attendence_date = '$date'");
		return $result;
	}
//----- view_attendance_status_for_date - End ------//

//----- Attance report holiday print By Date ------//
	function mj_smgt_attendance_report_holiday_print_for_date($date)
	{
		global $wpdb;
		$tbl_name = $wpdb->prefix .'holiday';
		$result =$wpdb->get_results("SELECT * FROM $tbl_name WHERE '$date' between date and end_date");
		return $result;
	}
//----- Attance report holiday print By Date ------//



//----- Total holiday Count By month and year - Start ------//
function mj_smgt_get_all_holiday_by_month_year($month,$year)
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'holiday';
	$result =$wpdb->get_results("SELECT * FROM $tbl_name WHERE CONCAT(YEAR(date),'-',MONTH(date))  = '$year-$month'");
	return $result;
}
//----- Total holiday Count By month and year - End ------//

//----- Get Date Admission By start_date to End_date - Start ------//
function mj_smgt_get_all_admission_by_start_date_to_end_date($start_date,$end_date)
{

	$args = array(
		'meta_key'=>'admission_date',
		'meta_value'   => array( $start_date, $end_date ),
		'meta_compare' => 'BETWEEN',
		'role'=>'student_temp'
	);
	$result = get_users( $args );
	return $result;
}
//----- Get Date Admission By start_date to End_date - End ------//

//-----Get all Date Type to star_date and end_date  - Start ------//
function mj_smgt_all_date_type_value($date_type)
{
	$start_date = "";
	$end_date = "";
	$array_res = array();
	if($date_type=="today")
	{
		$start_date = date('Y-m-d');
		$end_date= date('Y-m-d');
	}
	elseif($date_type=="this_week")
	{
		//check the current day
		if(date('D')!='Mon')
		{    
		//take the last monday
		$start_date = date('Y-m-d',strtotime('last sunday'));    

		}else{
			$start_date = date('Y-m-d');   
		}
		//always next saturday
		if(date('D')!='Sat')
		{
			$end_date = date('Y-m-d',strtotime('next saturday'));
		}else{
			$end_date = date('Y-m-d');
		}
	}
	elseif($date_type=="last_week")
	{
		$previous_week = strtotime("-1 week +1 day");
		$start_week = strtotime("last sunday midnight",$previous_week);
		$end_week = strtotime("next saturday",$start_week);

		$start_date = date("Y-m-d",$start_week);
		$end_date = date("Y-m-d",$end_week);
	}
	elseif($date_type=="this_month")
	{
		$start_date = date('Y-m-d',strtotime('first day of this month'));
		$end_date = date('Y-m-d',strtotime('last day of this month'));
	}
	elseif($date_type=="last_month")
	{
		$start_date = date('Y-m-d',strtotime("first day of previous month"));
		$end_date =  date('Y-m-d',strtotime("last day of previous month"));
	}
	elseif($date_type=="last_3_month")
	{
		$month_date =  date('Y-m-d', strtotime('-2 month'));
		$start_date = date("Y-m-01", strtotime($month_date));
		$end_date = date('Y-m-d',strtotime('last day of this month'));
		
	}
	elseif($date_type=="last_6_month")
	{
		$month_date =  date('Y-m-d', strtotime('-5 month'));
		$start_date = date("Y-m-01", strtotime($month_date));
		$end_date = date('Y-m-d',strtotime('last day of this month'));
	}
	elseif($date_type=="last_12_month")
	{
		$month_date =  date('Y-m-d', strtotime('-11 month'));
		$start_date = date("Y-m-01", strtotime($month_date));
		$end_date = date('Y-m-d',strtotime('last day of this month'));
	}
	elseif($date_type=="this_year")
	{
		$start_date = date("Y-01-01", strtotime("0 year"));
		$end_date = date("Y-12-t", strtotime($start_date));

	}
	elseif($date_type=="last_year")
	{
		$start_date = date("Y-01-01", strtotime("-1 year"));
		$end_date = date("Y-12-t", strtotime($start_date));
	}
	elseif($date_type=="period")
	{
		//$result= mj_smgt_admission_repot_load_date();

	}
	$array_res[] = $start_date;
	$array_res[] = $end_date;
	return json_encode($array_res);
}

//-----Attendance report all status value by date - Start ------//
function mj_smgt_attendance_report_all_status_value($date,$class_id,$user_id)
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'holiday';
	$holiday_att_data =$wpdb->get_results("SELECT * FROM $tbl_name WHERE '$date' between date and end_date");
	
	$tbl_name = $wpdb->prefix .'attendence';
	$attendance_data =$wpdb->get_row("SELECT status FROM $tbl_name WHERE user_id = $user_id AND class_id = $class_id AND attendence_date = '$date'");
	if(!empty($holiday_att_data))
	{
		$result= esc_attr__('H','school-mgt');
	}
	elseif(!empty($attendance_data))
	{
		if($attendance_data->status=="Present")
		{
			$status= esc_attr__('P','school-mgt');
		}
		elseif($attendance_data->status=="Absent")
		{
			$status= esc_attr__('A','school-mgt');
		}
		elseif($attendance_data->status=="Late")
		{
			$status= esc_attr__('L','school-mgt');
		}
		elseif($attendance_data->status=="Half Day")
		{
			$status= esc_attr__('F','school-mgt');
		}
		$result= $status;
	}
	else
	{
		$result= "";
	}
	return $result;
}
//-----Attendance report all status value by date - End ------//
function mj_smgt_view_attendance_report_for_start_date_enddate_total_present($start_date,$end_date,$class_id)
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'attendence';
    $result =$wpdb->get_results("SELECT * FROM $tbl_name where role_name = 'student' and attendence_date between '$start_date' and '$end_date' and class_id=$class_id and status='Present'");
	return count($result);
}
function mj_smgt_view_attendance_report_for_start_date_enddate_absent($start_date,$end_date,$class_id)
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'attendence';
    $result =$wpdb->get_results("SELECT * FROM $tbl_name where role_name = 'student' and attendence_date between '$start_date' and '$end_date' and class_id=$class_id and status='Absent'");
	return count($result);
}
function mj_smgt_view_attendance_report_for_start_date_enddate_Late($start_date,$end_date,$class_id)
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'attendence';
    $result =$wpdb->get_results("SELECT * FROM $tbl_name where role_name = 'student' and attendence_date between '$start_date' and '$end_date' and class_id=$class_id and status='Late'");
	return count($result);
}
function mj_smgt_view_attendance_report_for_start_date_enddate_Half_day($start_date,$end_date,$class_id)
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'attendence';
    $result =$wpdb->get_results("SELECT * FROM $tbl_name where role_name = 'student' and attendence_date between '$start_date' and '$end_date' and class_id=$class_id and status='Half Day'");
	return count($result);
}

function mj_smgt_view_attendance_report_for_start_date_enddate_total($class_id)
{
	global $wpdb;
	//$tbl_name = $wpdb->prefix .'attendence';
   // $result =$wpdb->get_results("SELECT * FROM $tbl_name where role_name = 'student' and attendence_date between '$start_date' and '$end_date' and class_id=$class_id");
	$userdata=get_users(array('role'=>'student','meta_key' => 'class_name', 'meta_value' => $class_id));
	return count($userdata);
}

//-- select leave Student view details-leave-list page - start --//
function mj_smgt_view_leave_student_for_data($leave_date,$Student_id,$status)
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'smgt_leave';
	if($Student_id == "all_student" && $status == "all_status" )
	{
		$result = $wpdb->get_results("SELECT * FROM $tbl_name WHERE start_date='$leave_date'");
		return $result;
	}
	elseif($Student_id == "all_student" && $status == !empty("all_status") )
	{
		$result = $wpdb->get_results("SELECT * FROM $tbl_name WHERE status= '$status' AND start_date='$leave_date'");
		return $result;
	}
	elseif($status == "all_status" && $Student_id == !empty("all_student") )
	{
		$result = $wpdb->get_results("SELECT * FROM $tbl_name WHERE student_id=$Student_id AND start_date='$leave_date'");
		return $result;
	}
	else
	{
		$result = $wpdb->get_results("SELECT * FROM $tbl_name WHERE student_id=$Student_id AND start_date='$leave_date' AND status= '$status'");	
		return $result;
	}
}
//-- select Student view details-leave module - End --//

// GET Student DETAILS //

function MJ_smgt_get_user_detail_byid($student_id)

{

	$user_return = array();

	$first_name = get_user_meta($student_id,'first_name',true);

	$last_name = get_user_meta($student_id,'last_name',true);

	$student_id = get_user_meta($student_id,'patient_id',true);

	$user_return =array('id'=>$student_id,'first_name'=>$first_name,'last_name' =>$last_name) ;

	return $user_return;

}

//Get Message
function mj_smgt_message_dashboard($user_id)
{
	global $wpdb;
	$tbl_name = $wpdb->prefix .'smgt_message';
	$result =$wpdb->get_results("SELECT *  FROM $tbl_name where receiver=$user_id ORDER BY message_id DESC limit 5");
	return $result;
}
// Get Holiday for dashboard 
function mj_smgt_holiday_dashboard()
{
	global $wpdb;
	$smgt_holiday = $wpdb->prefix . 'holiday';
	$result = $wpdb->get_results("SELECT * FROM $smgt_holiday ORDER BY holiday_id DESC limit 5");
	return $result;
}
// Get Notification For Dashboard 
function mj_smgt_notification_dashboard()
{
	global $wpdb;
	$smgt_notification = $wpdb->prefix . 'smgt_notification';
	$result = $wpdb->get_results("SELECT * FROM $smgt_notification ORDER BY notification_id DESC limit 5");
	return $result;
}

// Get user Notification For Dashboard 
function mj_smgt_user_notification_dashboard($id)
{
	global $wpdb;
	$smgt_notification = $wpdb->prefix . 'smgt_notification';
	$result = $wpdb->get_results("SELECT * FROM $smgt_notification where student_id=$id ORDER BY notification_id DESC limit 5");
	return $result;
}
// Get Class For Dashboard 
function mj_smgt_class_dashboard()
{
	global $wpdb;
	$smgt_class = $wpdb->prefix . 'smgt_class';
	$result = $wpdb->get_results("SELECT * FROM $smgt_class ORDER BY class_id DESC limit 5");
	return $result;
}

// dashboard new popup 
function mj_smgt_get_feespayment_by_id($id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "smgt_fees_payment";
	return $retrieve_subject = $wpdb->get_row( "SELECT * FROM $table_name WHERE fees_pay_id = ".$id);
}

// Detail page function 

function mh_smgt_feespayment_detail($id)
{
	global $wpdb;
	$table_smgt_fees_payment = $wpdb->prefix. 'smgt_fees_payment';
	$result = $wpdb->get_results("SELECT * FROM $table_smgt_fees_payment where student_id = $id ORDER BY fees_pay_id  DESC  limit 4");
	return $result;
}
function mj_smgt_get_fees_payment_detailpage($id)
{		
	global $wpdb;
	$table_smgt_fees_payment = $wpdb->prefix. 'smgt_fees_payment';
	$result = $wpdb->get_results("SELECT * FROM $table_smgt_fees_payment where student_id = $id");
	return $result;
}
function mj_smgt_monthly_attendence($id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "attendence";
	$date= date('Y-m-d');
	$curr_date=date('Y-m-d',strtotime($date));
	$sdate = date('Y-m-d',strtotime('first day of this month'));
	$edate = date('Y-m-d',strtotime('last day of this month'));
	$result=$wpdb->get_results("SELECT * FROM $table_name WHERE `attendence_date` BETWEEN '$sdate' AND '$edate' AND  user_id=$id");
	return $result;
}
function mj_smgt_hallticket_list($id)
{
	global $wpdb;
	$table_name_smgt_exam_hall_receipt = $wpdb->prefix . "smgt_exam_hall_receipt";
	$result = $wpdb->get_results( "SELECT * FROM $table_name_smgt_exam_hall_receipt where user_id=".$id);
	return $result;
}
function mj_smgt_student_homework_detail($id){
	global $wpdb;
	$table_name = $wpdb->prefix . 'mj_smgt_homework';
	$table_name2 = $wpdb->prefix . 'mj_smgt_student_homework';
	return $result = $wpdb->get_results("SELECT * FROM $table_name as a LEFT JOIN $table_name2 as b ON a.`homework_id` = b.`homework_id`WHERE b.student_id = $id");
}
function mj_smgt_student_issuebook_detail($id)
{
	global $wpdb;
	$table_issuebook=$wpdb->prefix.'smgt_library_book_issue';
	$result = $wpdb->get_results("SELECT * FROM $table_issuebook where student_id=$id");
	return $result;
}
function MJ_smgt_msg_detail($id){

	global $wpdb;
	$tbl_name_message = $wpdb->prefix .'smgt_message';
	$result=$wpdb->get_results("SELECT *  FROM $tbl_name_message where receiver =" .$id );
	return $result;
}

//--------- Export CSV Function ------------//
function mj_smgt_export_data()
{
	?>
	<script>
		jQuery(document).ready(function($)
		{
			$('#upload_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	
		});
	</script>
	<div class="modal-header import_csv_popup">
		<a href="#" class="close-btn-cat badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>
		<h4 class="modal-title"><?php esc_attr_e('Export Data','school-mgt');?></h4>
	</div>
	<div class="panel-body export_csv_padding_18px"><!------- Penal Body ---------->
		<!------- Export Student CSV Form ---------->
		<form name="upload_form" action="" method="post" class="form-horizontal" id="upload_form" enctype="multipart/form-data">
			<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
			<input type="hidden" name="action" value="<?php echo $action;?>">
			<input type="hidden" name="role" value="<?php echo $role;?>"  />
			<div class="form-body user_form"> <!--form Body div-->   
				<div class="row"><!--Row Div--> 
					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 input smgt_form_select">
						<label class="custom-top-label lable_top top" for="class_name"><?php esc_attr_e('Select Class','school-mgt');?><span class="require-field">*</span></label>
						<select name="class_name" class="form-control validate[required]" id="class_list">
							<option value=""><?php esc_attr_e('Select Class','school-mgt');?></option>
							<?php
								foreach(mj_smgt_get_allclass() as $classdata)
								{  
								?>
									<option value="<?php echo $classdata['class_id'];?>" ><?php echo $classdata['class_name'];?></option>
							<?php }?>
						</select>
					</div>
					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 input smgt_form_select">
						<label class="custom-top-label lable_top top" for="class_name"><?php esc_attr_e('Select Section','school-mgt');?></label>
						<select name="class_section" class="form-control" id="class_section">
							<option value=""><?php esc_attr_e('Select Class Section','school-mgt');?></option>
						</select>
					</div>
				</div> <!--Row Div-->  
			</div><!--form Body div-->

			<div class="form-body user_form"> 
				<div class="row">
					<div class="col-sm-6">        	
						<input type="submit" value="<?php esc_attr_e('Export IN CSV','school-mgt');?>" name="exportstudentin_csv" class="save_btn btn btn-success save_btn"/>
					</div>
				</div>
			</div>

		</form><!------- Export Student CSV Form ---------->
	</div><!------- Penal Body ---------->
	<?php
	die();
}

//----------- Import Student CSV Function --------------//
function mj_smgt_student_import_data()
{
	?>
	<script>
		jQuery(document).ready(function($)
		{
			$('#upload_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	
		});
	</script>
	<div class="modal-header import_csv_popup">
		<a href="#" class="close-btn-cat badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>
		<h4 class="modal-title"><?php esc_attr_e('Import Data','school-mgt');?></h4>
	</div>
	<div class="panel-body"><!-------- Penal Body ---------->
		<!-------- Import Student Form ---------->
		<form name="upload_form" action="" method="post" class="form-horizontal" id="upload_form" enctype="multipart/form-data">
			<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
			<input type="hidden" name="action" value="<?php echo $action;?>">
			<input type="hidden" name="role" value="<?php echo $role;?>"  />
			<div class="form-body user_form"> <!--form Body div-->   
				<div class="row"><!--Row Div--> 
					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 input smgt_form_select">
						<label class="custom-top-label lable_top top" for="class_name"><?php esc_attr_e('Select Class','school-mgt');?><span class="require-field">*</span></label>
						<select name="class_name" class="form-control validate[required]" id="class_list">
							<option value=""><?php esc_attr_e('Select Class','school-mgt');?></option>
							<?php
							foreach(mj_smgt_get_allclass() as $classdata)
							{  
							?>
								<option value="<?php echo $classdata['class_id'];?>" ><?php echo $classdata['class_name'];?></option>
							<?php }?>
						</select>
					</div>
					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 input smgt_form_select">
						<label class="custom-top-label lable_top top" for="class_name"><?php esc_attr_e('Select Section','school-mgt');?></label>
						<select name="class_section" class="form-control" id="class_section">
							<option value=""><?php esc_attr_e('Select Class Section','school-mgt');?></option>               
						</select>
					</div>
					<div class="col-md-6">	
						<div class="form-group input">
							<div class="col-md-12 form-control res_rtl_height_50px">	
								<label for="" class="custom-control-label custom-top-label ml-2 margin_left_30px"><?php _e('Select CSV file','school-mgt');?><span class="require-field">*</span></label>
								<div class="col-sm-12">
									<input id="csv_file" type="file" class="validate[required] csvfile_width d-inline" name="csv_file">
								</div>
							</div>
						</div>
					</div>
				</div> <!--Row Div-->  
			</div><!--form Body div-->
			<?php wp_nonce_field( 'upload_teacher_admin_nonce' ); ?>
			<div class="form-body user_form"> <!--form Body div-->   
				<div class="row"><!--Row Div--> 
					<div class="col-sm-6">        	
						<input type="submit" value="<?php esc_attr_e('Upload CSV File','school-mgt');?>" name="upload_csv_file" class="btn btn-success save_btn"/>
					</div>
				</div> <!--Row Div--> 
			</div><!--form Body div-->
		</form><!-------- Import Student Form ---------->
	</div><!-------- Penal Body ---------->
	<?php
	die();
}

//----------- Import Teacher CSV Function --------------//
function mj_smgt_teacher_import_data()
{
	?>
	<script>
		jQuery(document).ready(function($)
		{
			$('#upload_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	
		});
	</script>
	<div class="modal-header import_csv_popup">
		<a href="#" class="close-btn-cat badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>
		<h4 class="modal-title"><?php esc_attr_e('Import Data','school-mgt');?></h4>
	</div>
	<div class="panel-body"><!-- panel-body -->
		<!-------- Import Teacher Form ---------->
		<form name="upload_form" action="" method="post" class="form-horizontal" id="upload_form" enctype="multipart/form-data"><!--form div-->
			<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
			<input type="hidden" name="action" value="<?php echo $action;?>">
			<input type="hidden" name="role" value="<?php echo $role;?>"  />
			<div class="form-body user_form"> <!--form Body div-->   
				<div class="row"><!--Row Div--> 
					<div class="col-md-9">	
						<div class="form-group input">
							<div class="col-md-12 form-control res_rtl_height_50px">	
								<label class="custom-control-label custom-top-label ml-2 margin_left_30px" for="city_name"><?php esc_attr_e('Select CSV file','school-mgt');?><span class="require-field">*</span></label>
								<div class="col-sm-12">
									<input id="csv_file" type="file" class="validate[required] csvfile_width d-inline" name="csv_file">
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-3">        	
						<input type="submit" value="<?php esc_attr_e('Upload CSV File','school-mgt');?>" name="upload_teacher_csv_file" class="btn btn-success save_btn"/>
					</div>
					<?php wp_nonce_field( 'upload_csv_nonce' ); ?>
				</div> <!--Row Div--> 
			</div><!--form Body div-->
		</form><!--form div-->
	</div><!--panel-body-->
	<?php
	die();
}

//----------- Import Support Staff Function --------------//
function mj_smgt_support_staff_import_data()
{
	?>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#upload_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	
		});
	</script>

	<div class="modal-header import_csv_popup">
		<a href="#" class="close-btn-cat badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>
		<h4 class="modal-title"><?php esc_attr_e('Import Data','school-mgt');?></h4>
	</div>
	<div class="panel-body"><!-- panel-body -->
		<!-------- Import Teacher Form ---------->
		<form name="upload_form" action="" method="post" class="form-horizontal" id="upload_form" enctype="multipart/form-data"><!--form div-->
			<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
			<input type="hidden" name="action" value="<?php echo $action;?>">
			<input type="hidden" name="role" value="<?php echo $role;?>"  />

			<div class="form-body user_form"> <!--form Body div-->   
				<div class="row"><!--Row Div--> 
					<div class="col-md-9">	
						<div class="form-group input">
							<div class="col-md-12 form-control res_rtl_height_50px">	
								<label class="custom-control-label custom-top-label ml-2 margin_left_30px" for="city_name"><?php esc_attr_e('Select CSV file','school-mgt');?><span class="require-field">*</span></label>
								<div class="col-sm-12">
									<input id="csv_file" type="file" class="validate[required] csvfile_width"  name="csv_file">
								</div>
							</div>
						</div>
					</div>
					<?php wp_nonce_field( 'upload_csv_nonce' ); ?>
					<div class="col-sm-3">        
						<input type="submit" value="<?php esc_attr_e('Upload CSV File','school-mgt');?>" name="upload_staff_csv_file" class="btn btn-success save_btn"/>
					</div>
				</div> <!--Row Div--> 
			</div><!--form Body div-->
		</form><!--form div-->
	</div><!--panel-body-->
	<?php
	die();
}

//----------- Import Parent Function --------------//
function mj_smgt_parent_import_data()
{
	?>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#upload_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	
		});
	</script>
	<div class="modal-header import_csv_popup">
		<a href="#" class="close-btn-cat badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>
		<h4 class="modal-title"><?php esc_attr_e('Import Data','school-mgt');?></h4>
	</div>
	<div class="panel-body"><!-- panel-body -->
		<!-------- Import Teacher Form ---------->
		<form name="upload_form" action="" method="post" class="form-horizontal" id="upload_form" enctype="multipart/form-data"><!--form div-->
			<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
			<input type="hidden" name="action" value="<?php echo $action;?>">
			<input type="hidden" name="role" value="<?php echo $role;?>"  />

			<div class="form-body user_form"> <!--form Body div-->   
				<div class="row"><!--Row Div--> 
					<div class="col-md-9">	
						<div class="form-group input">
							<div class="col-md-12 form-control res_rtl_height_50px">	
								<label class="custom-control-label custom-top-label ml-2 margin_left_30px" for="city_name"><?php esc_attr_e('Select CSV file','school-mgt');?><span class="require-field">*</span></label>
								<div class="col-sm-12">
									<input id="csv_file" type="file" class="validate[required] csvfile_width"  name="csv_file">
								</div>
							</div>
						</div>
					</div>
					<?php wp_nonce_field( 'upload_csv_nonce' ); ?>
					<div class="col-sm-3">        
						<input type="submit" value="<?php esc_attr_e('Upload CSV File','school-mgt');?>" name="upload_parent_csv_file" class="btn btn-success save_btn"/>
					</div>
				</div> <!--Row Div--> 
			</div><!--form Body div-->
		</form><!--form div-->
	</div><!--panel-body-->
	<?php
	die();
}
//---------- Start Time convert -----------//
function MJ_start_time_convert($time)
{
	$start_time_data  = $time;
	$starttime_convert = date('g:i:a',strtotime($start_time_data));
	$starttime = explode(":", $starttime_convert);
	$start_hour=$starttime[0];
	$start_min_convert=str_pad($starttime[1],2,"0",STR_PAD_LEFT);
	if($start_min_convert == "00" || $start_min_convert == "01" || $start_min_convert == "02" || $start_min_convert == "03" || $start_min_convert == "04" || $start_min_convert == "05" || $start_min_convert == "06" || $start_min_convert == "07" || $start_min_convert == "08" || $start_min_convert == "09" )
	{
		$start_min=substr($start_min_convert,1);
	}
	else
	{
		$start_min=$start_min_convert;
	}
	$start_am_pm=$starttime[2];
	$start_time=$start_hour.':'.$start_min.':'.$start_am_pm;

	return $start_time;
}

//----------- End Time Convert ------------//
function MJ_end_time_convert($time)
{
	$end_time_data  = $time;
	$endtime_convert = date('g:i:a',strtotime($end_time_data));
	$endtime = explode(":", $endtime_convert);
	 
	$end_hour=$endtime[0];
	$end_min_convert=str_pad($endtime[1],2,"0",STR_PAD_LEFT);
	if($end_min_convert == "00" || $end_min_convert == "01" || $end_min_convert == "02" || $end_min_convert == "03" || $end_min_convert == "04" || $end_min_convert == "05" || $end_min_convert == "06" || $end_min_convert == "07" || $end_min_convert == "08" || $end_min_convert == "09" )
	{
		$end_min=substr($end_min_convert,1);
	}
	else
	{
		$end_min=$end_min_convert;
	}
	$end_am_pm=$endtime[2];
	$end_time=$end_hour.':'.$end_min.':'.$end_am_pm;
	return $end_time;
}
//---------- GET NOTIFICATION OF STUDENT OWN DATA -------------//
function mj_smgt_get_all_notification_created_by($user_id)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "smgt_notification";
	return $results=$wpdb->get_results("SELECT * FROM $table_name WHERE created_by=".$user_id);
}

//------------ IMPORT SUBJECT CSV FUNCTION ----------------//

function mj_smgt_subject_import_data()
{
	$teacher_obj = new Smgt_Teacher;
	?>
	<script>
		jQuery(document).ready(function($)
		{
			$('#upload_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	
			$("#subject_teacher").multiselect({ 
					nonSelectedText :'<?php esc_html_e('Select Teacher','school-mgt');?>',
					includeSelectAllOption: true ,
					selectAllText : '<?php esc_html_e('Select all','school-mgt');?>',
					templates: {
					button: '<button class="multiselect btn btn-default dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span><b class="caret"></b></button>',
				},
			});
		});
	</script>
	<div class="modal-header import_csv_popup">
		<a href="#" class="close-btn-cat badge badge-success pull-right dashboard_pop-up_design"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>
		<h4 class="modal-title"><?php esc_attr_e('Import Data','school-mgt');?></h4>
	</div>
	<div class="panel-body"><!-------- Penal Body ---------->
		<!-------- Import Student Form ---------->
		<form name="upload_form" action="" method="post" class="form-horizontal" id="upload_form" enctype="multipart/form-data" style="padding:10px;">
			<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
			<input type="hidden" name="action" value="<?php echo $action;?>">
			<input type="hidden" name="role" value="<?php echo $role;?>"  />
			<div class="form-body user_form"> <!--form Body div-->   
				<div class="row"><!--Row Div--> 
					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 input smgt_form_select">
						<label class="custom-top-label lable_top top" for="class_name"><?php esc_attr_e('Select Class','school-mgt');?><span class="require-field">*</span></label>
						<select name="class_name" class="form-control validate[required]" id="class_list">
							<option value=""><?php esc_attr_e('Select Class','school-mgt');?></option>
							<?php
							foreach(mj_smgt_get_allclass() as $classdata)
							{  
							?>
								<option value="<?php echo $classdata['class_id'];?>" ><?php echo $classdata['class_name'];?></option>
							<?php }?>
						</select>
					</div>
					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 input smgt_form_select">
						<label class="custom-top-label lable_top top" for="class_name"><?php esc_attr_e('Select Section','school-mgt');?></label>
						<select name="class_section" class="form-control" id="class_section">
							<option value=""><?php esc_attr_e('Select Class Section','school-mgt');?></option>               
						</select>
					</div>
					<div class="col-md-6 rs_mb_15px rtl_margin_top_15px">
						<div id="res_rtl_width_100" class="rtl_subject_import_data_multiple col-sm-12 rtl_padding_left_right_0px multiselect_validation_teacher smgt_multiple_select">
							<?php 
							$teachval = array();
							$teacherdata_array=mj_smgt_get_usersdata('teacher');
							?>
							<select name="subject_teacher[]" multiple="multiple" id="subject_teacher" class="form-control validate[required] teacher_list">               
								<?php 
								foreach($teacherdata_array as $teacherdata)
								{ 
									?>
									<option value="<?php echo $teacherdata->ID;?>" <?php echo $teacher_obj->mj_smgt_in_array_r($teacherdata->ID, $teachval) ? 'selected' : ''; ?>><?php echo $teacherdata->display_name;?></option>
									<?php 
								}
								?>
							</select>
						</div>
					</div>
					<div class="col-md-6">	
						<div class="form-group input">
							<div class="col-md-12 form-control res_rtl_height_50px">	
								<label for="" class="custom-control-label custom-top-label ml-2 margin_left_30px"><?php _e('Select CSV file','school-mgt');?><span class="require-field">*</span></label>
								<div class="col-sm-12">
									<input id="csv_file" type="file" class="validate[required] csvfile_width d-inline" name="csv_file">
								</div>
							</div>
						</div>
					</div>
				</div> <!--Row Div-->  
			</div><!--form Body div-->
			<?php wp_nonce_field( 'upload_subject_admin_nonce' ); ?>
			<div class="form-body user_form"> <!--form Body div-->   
				<div class="row"><!--Row Div--> 
					<div class="col-sm-6">        	
						<input type="submit" value="<?php esc_attr_e('Upload CSV File','school-mgt');?>" name="upload_csv_file" class="btn btn-success save_btn"/>
					</div>
				</div> <!--Row Div--> 
			</div><!--form Body div-->
		</form><!-------- Import Student Form ---------->
	</div><!-------- Penal Body ---------->
	<?php
	die();
}
function mj_smgt_admission_repot_load_date()
{
	 $date_type = $_REQUEST['date_type'];
	 //var_dump($date_type);
	 ?>
	
	<script type="text/javascript">
		jQuery(document).ready(function($)
		{
			"use strict";	
			$("#report_sdate").datepicker({
				dateFormat: "yy-mm-dd",
				changeYear: true,
				changeMonth: true,
				maxDate:0,
				onSelect: function (selected) {
					var dt = new Date(selected);
					dt.setDate(dt.getDate() + 0);
					$("#report_edate").datepicker("option", "minDate", dt);
				}
			});

			$("#report_edate").datepicker({
			dateFormat: "yy-mm-dd",
			changeYear: true,
			changeMonth: true,
			maxDate:0,
				onSelect: function (selected) {
					var dt = new Date(selected);
					dt.setDate(dt.getDate() - 0);
					$("#report_sdate").datepicker("option", "maxDate", dt);
				}
			});
		} );
	</script>
	<?php
	if($date_type=='period')
	{ 
		?>
		<div class="row">
		<div class="col-md-6 mb-2">
			<div class="form-group input">
				<div class="col-md-12 form-control">
					<input type="text" id="report_sdate" class="form-control" name="start_date" value="<?php if(isset($_REQUEST['start_date'])) echo $_REQUEST['start_date'];else echo date('Y-m-d');?>" readonly>
					<label for="userinput1" class="active"><?php esc_html_e('Start Date','school-mgt');?></label>
				</div>
			</div>
		</div>
		<div class="col-md-6 mb-2">
			<div class="form-group input">
				<div class="col-md-12 form-control">
					<input type="text" id="report_edate" class="form-control" name="end_date" value="<?php if(isset($_REQUEST['edate'])) echo $_REQUEST['end_date'];else echo date('Y-m-d');?>" readonly>
					<label for="userinput1" class="active"><?php esc_html_e('End Date','school-mgt');?></label>
				</div>
			</div>
		</div> 
		</div>
		<?php 
	} 
	die();
	
}

function mj_smgt_load_multiple_day()
{
	$obj_leave=new SmgtLeave;
	$duration = $_REQUEST['duration'];
	$leave_id = $_REQUEST['idset'];
	$edit=0;
	if($leave_id!='')
	{
		$edit=1;
		$result = $obj_leave->hrmgt_get_single_leave($leave_id);	
	}
	?>
	
	<script type="text/javascript">
		$(document).ready(function() 
		{    //EVENT VALIDATIONENGINE
			"use strict";
			
			var start = new Date();
			var end = new Date(new Date().setYear(start.getFullYear()+1));
			$(".leave_start_date").datepicker(
			{
				dateFormat: "yy-mm-dd",
				minDate:0,
				onSelect: function (selected) {
					var dt = new Date(selected);
					dt.setDate(dt.getDate() + 0);
					$(".leave_end_date").datepicker("option", "minDate", dt);
				},
				beforeShow: function (textbox, instance) 
				{
					instance.dpDiv.css({
						marginTop: (-textbox.offsetHeight) + 'px'                   
					});
				}
			});
			$(".leave_end_date").datepicker(
			{
				dateFormat: "yy-mm-dd",
				minDate:0,
				onSelect: function (selected) {
					var dt = new Date(selected);
					dt.setDate(dt.getDate() - 0);
					$(".leave_start_date").datepicker("option", "maxDate", dt);
				},
				beforeShow: function (textbox, instance) 
				{
					instance.dpDiv.css({
						marginTop: (-textbox.offsetHeight) + 'px'                   
					});
				}
			});
		} );
	</script>
	<?php
	if($duration=='more_then_day')
	{ 
		?>
		<div class="row">


			<div  class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
				<div class="form-group input">
					<div class="col-md-12 form-control">
						<input id="leave_start_date" class="form-control validate[required] leave_start_date datepicker1" autocomplete="off" type="text"  name="start_date" value="<?php if($edit){ echo esc_attr(date("Y-m-d",strtotime($result->start_date)));}elseif(isset($_POST['start_date'])) echo esc_attr($_POST['start_date']); else echo date("Y-m-d");?>">
						<label class="active" for="start"><?php esc_html_e('Leave Start Date','school-mgt');?><span class="require-field">*</span></label>
					</div>
				</div>
			</div>
			<div  class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
				<div class="form-group input">
					<div class="col-md-12 form-control">
						<input id="leave_end_date" class="form-control validate[required] leave_end_date datepicker2" type="text"  name="end_date" autocomplete="off" value="<?php if($edit){ echo esc_attr(date("Y-m-d",strtotime($result->end_date)));}elseif(isset($_POST['end_date'])) echo esc_attr($_POST['end_date']); else echo date("Y-m-d");?>">
						<label class="active" for="end"><?php esc_html_e('Leave End Date','school-mgt');?><span class="require-field">*</span></label>
					</div>
				</div>
			</div>

		</div>

		<?php 
	} 
	else
	{ ?>	

		<div class="form-group input">
			<div class="col-md-12 form-control">
				<input id="leave_start_date" class="form-control validate[required] leave_start_date start_date datepicker1" autocomplete="off" type="text"  name="start_date" value="<?php if($edit){ echo esc_attr(date("Y-m-d",strtotime($result->start_date)));}elseif(isset($_POST['start_date'])) echo esc_attr($_POST['start_date']); else echo date("Y-m-d");?>">
				<label class="active" for="start"><?php esc_html_e('Leave Start Date','school-mgt');?><span class="require-field">*</span></label>
			</div>
		</div>
		<?php 
	} ?>
	<?php 
	die();
} 

add_action( 'wp_ajax_MJ_smgt_check_email_exit_or_not','MJ_smgt_check_email_exit_or_not');
add_action( 'wp_ajax_nopriv_MJ_smgt_check_email_exit_or_not','MJ_smgt_check_email_exit_or_not');
function MJ_smgt_check_email_exit_or_not()
{
    $email= $_POST['email_id'];
	if ( email_exists( $email ) ) 
	{
        $response = 1;
    } else 
	{
        $response = 0;
    }
	echo $response;
	die;
}

add_action( 'wp_ajax_MJ_smgt_check_username_exit_or_not','MJ_smgt_check_username_exit_or_not');
add_action( 'wp_ajax_nopriv_MJ_smgt_check_username_exit_or_not','MJ_smgt_check_username_exit_or_not');
function MJ_smgt_check_username_exit_or_not()
{
	$username= $_POST['username'];
	if ( username_exists( $username ) ) 
	{
        $response = 1;
    } else 
	{
        $response = 0;
    }
	echo $response;
	die;
}

// GET STUDENT NOTIFICATION FOR OWN DATA

function mj_smgt_get_student_own_notification_created_by($user_id)

{

	global $wpdb;

	$table_name = $wpdb->prefix . "smgt_notification";

	return $results=$wpdb->get_results("SELECT * FROM $table_name WHERE student_id=".$user_id);

}

function MJ_smgt_get_trasport_data_for_dashboard()
{
	global $wpdb;
	$table_name = $wpdb->prefix. 'transport';
	$result = $wpdb->get_results("SELECT * FROM $table_name ORDER BY transport_id DESC limit 5");
	return $result;
}

// CHANGE PROFILE PHOTO IN USER DASHBOARD //
function mj_smgt_assign_route()
{
	$transport_id = $_REQUEST['record_id'];
	$assign_transport_data = mj_smgt_get_assign_transport_by_id($_REQUEST['record_id']);
	
	$teacher_obj = new Smgt_Teacher;
	?>
	<script type="text/javascript">
		jQuery(document).ready(function($)
		{
			"use strict";	
			$('#message_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});
			$('#selected_multiple_users').multiselect({ 
				nonSelectedText :"<?php esc_attr_e('Select Users','school-mgt');?>",
				includeSelectAllOption: true,
				selectAllText: '<?php esc_attr_e('Select all','school-mgt');?>',
				templates: {
					button: '<button class="multiselect btn btn-default dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span><b class="caret"></b></button>',
				},
			});
		});
	</script>
	<div class="form-group popup_heder_marging"> 	
		<img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Transportation.png";  ?>" alt="" class="popup_image_before_name">
		<a href="#" class="close-btn-cat badge badge-danger pull-right">
		<img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></a>
		<h4 class="modal-title" id="myLargeModalLabel">
			<?php esc_attr_e('Assign Route','school-mgt'); ?>
		</h4>
	</div>
	<div class="panel-body margin_top_20px padding_top_15px_res"><!--------- penal body ------->
        <form name="assign_transport_form" action="#" method="post" enctype="multipart/form-data" class="form-horizontal" id="assign_transport_form">
			<input type="hidden" value="<?php echo $transport_id; ?>" name="transport_id">
			<div class="form-body user_form"><!--user form -->	
				<div class="row"><!--row -->	
					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 single_class_div support_staff_user_div input">
						<div class="col-sm-12 smgt_multiple_select rtl_padding_left_right_0px">
							<span class="user_display_block">
								<select name="selected_users[]" id="selected_multiple_users" class="form-control min_width_250px" multiple="multiple">					
									<?php 
									if(!empty($assign_transport_data))
									{
										$users = json_decode($assign_transport_data->route_user);
									}
									
									$student_list = mj_smgt_get_all_student_list();
									foreach($student_list  as $retrive_data)
									{
										?>
										<option value="<?php echo $retrive_data->ID;?>"
										<?php echo $teacher_obj->mj_smgt_in_array_r($retrive_data->ID, $users) ? 'selected' : ''; ?>>
										<?php echo $retrive_data->display_name;?>
										<?php
										//echo '<option value="'.$retrive_data->ID.'" >'.$retrive_data->display_name.'</option>';
									}
									?>
								</select>
							</span>
						</div>
					</div>
					<?php wp_nonce_field( 'save_assign_transpoat_admin_nonce' ); ?>
					<div class="col-sm-3">   
						<input type="submit" value="<?php if($edit){ esc_attr_e('Assign Route','school-mgt'); }else{ esc_attr_e('Assign Route','school-mgt');}?>" name="save_assign_route" class="btn btn-success save_btn"/>
					</div>
				</div>
			</div>
		</form>
	</div>
    <?php 
	die();
}

function mj_smgt_get_assign_transport_by_id($tid)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "assign_transport";
	return $retrieve_subject = $wpdb->get_row( "SELECT * FROM $table_name WHERE transport_id = ".$tid);
}
function mj_smgt_get_all_assign_transport()
{
	global $wpdb;
	$table_name = $wpdb->prefix . "assign_transport";
	return $retrieve_subject = $wpdb->get_results( "SELECT * FROM $table_name");
}
function mj_smgt_get_single_assign_transport_by_id($tid)
{
	global $wpdb;
	$table_name = $wpdb->prefix . "assign_transport";
	return $retrieve_subject = $wpdb->get_row( "SELECT * FROM $table_name WHERE assign_transport_id = ".$tid);
}
function mj_smgt_student_assign_bed_data_by_student_id($id)
{
	global $wpdb;
	$table_smgt_assign_beds=$wpdb->prefix.'smgt_assign_beds';
	$result=$wpdb->get_row("SELECT * FROM $table_smgt_assign_beds where student_id=".$id);
	return $result;
}
function mj_smgt_get_room__data_by_room_id($room_id)
{
	global $wpdb;
	$table_smgt_room=$wpdb->prefix.'smgt_room';
	$result=$wpdb->get_row("SELECT * FROM $table_smgt_room where id=".$room_id);
	return $result;
}
function mj_smgt_hostel_type_by_id($hostel_id)
{
	global $wpdb;
	$table_smgt_hostel=$wpdb->prefix.'smgt_hostel';
	$result=$wpdb->get_row("SELECT * FROM $table_smgt_hostel where id=".$hostel_id);
	if(!empty($result->hostel_type))
	{
		return $result->hostel_type;
	}
	else
	{
		return "N/A";
	}
}
//--- Datatable Heder Display show class ----//
function MJ_smgt_datatable_heder()
{
	$datatbl_heder_value = get_option( 'smgt_heder_enable' ); 
	if($datatbl_heder_value == "no")
	{
		$result= "smgt_heder_none";
	}
	else
	{		
		$result= "smgt_heder_block";
	}
	return $result;
	
}

function MJ_smgt_frontend_dashboard_card_access()
{
	$user_id = get_current_user_id();
	$role=MJ_smgt_get_roles($user_id);

	if($role=='student')
	{ 
		$card_access = get_option( 'smgt_dashboard_card_for_student');
	}
	elseif($role=='teacher')
	{
		$card_access = get_option( 'smgt_dashboard_card_for_teacher');
	}
	elseif($role=='parent')
	{
		$card_access = get_option( 'smgt_dashboard_card_for_parent');
	}
	elseif($role=='supportstaff')
	{
		$card_access = get_option( 'smgt_dashboard_card_for_support_staff');
	}
	return $card_access;
}
function MJ_get_total_income($start_date,$end_date)
{
 	global $wpdb;
	$table_income=$wpdb->prefix.'smgt_income_expense';
	$result = $wpdb->get_results("SELECT * FROM $table_income where invoice_type='income' AND income_create_date BETWEEN '$start_date' AND '$end_date' ");
	return $result;
}
function MJ_get_total_expense($start_date,$end_date)
{
 	global $wpdb;
	$table_income=$wpdb->prefix.'smgt_income_expense';
	$result = $wpdb->get_results("SELECT * FROM $table_income where invoice_type='expense' AND income_create_date BETWEEN '$start_date' AND '$end_date' ");
	return $result;
}

function school_append_audit_log($audit_action,$user_id,$created_by,$action)
{
	global $wpdb;
	$table_smgt_audit_log=$wpdb->prefix. 'smgt_audit_log';
	$ip_address = getHostByName(getHostName());
	$data['audit_action']=$audit_action;
	$data['user_id']=$user_id;
	$data['action']=$action;
	$data['ip_address']=$ip_address;
	$data['created_by']=$created_by;
	$data['created_at']=date("Y-m-d");
	$data['deleted_status']=0;
	$data['date_time']=date("Y-m-d H:i:s");
	
	$result=$wpdb->insert( $table_smgt_audit_log,$data);
	return $result;
}

function school_append_user_log($user_login,$role)
{
	global $wpdb;
	$table_smgt_user_log=$wpdb->prefix. 'smgt_user_log';
	$ip_address = getHostByName(getHostName());
	$data['user_login']="$user_login";
	$data['role']="$role";
	$data['ip_address']=$ip_address;
	$data['created_at']=date("Y-m-d");
	$data['deleted_status']=0;
	$data['date_time']=date("Y-m-d H:i:s");

	$result=$wpdb->insert( $table_smgt_user_log,$data);
	return $result;
}

function MJ_smgt_add_defult_admission_fees_type()
{
	

	$data['category_name'] = "Admission Fees";
	$obj_fees = new Smgt_fees();
	$result = $obj_fees->mj_smgt_add_feetype($data);
	
	global $wpdb;
	$id = $wpdb->insert_id;
	$table_smgt_fees = $wpdb->prefix. 'smgt_fees';
	//-------usersmeta table data--------------
	$feedata['fees_title_id']=mj_smgt_onlyNumberSp_validation($id);
	$feedata['class_id']=0;
	$feedata['section_id']=0;
	$feedata['fees_amount']=get_option("smgt_admission_amount");
	$feedata['description']="";		
	$feedata['created_date']=date("Y-m-d H:i:s");
	$feedata['created_by']=get_current_user_id();
	$result=$wpdb->insert( $table_smgt_fees, $feedata );
}

function MJ_smgt_add_defult_registration_fees_type()
{
	$data['category_name'] = "Registration Fees";
	$obj_fees = new Smgt_fees();
	$result = $obj_fees->mj_smgt_add_feetype($data);
	
	global $wpdb;
	$id = $wpdb->insert_id;
	$table_smgt_fees = $wpdb->prefix. 'smgt_fees';
	//-------usersmeta table data--------------
	$feedata['fees_title_id']=mj_smgt_onlyNumberSp_validation($id);
	$feedata['class_id']=0;
	$feedata['section_id']=0;
	$feedata['fees_amount']=get_option("smgt_registration_amount");
	$feedata['description']="";		
	$feedata['created_date']=date("Y-m-d H:i:s");
	$feedata['created_by']=get_current_user_id();
	$result=$wpdb->insert( $table_smgt_fees, $feedata );
}

add_action( 'wp_ajax_mj_smgt_dashboard_append_report_data','mj_smgt_dashboard_append_report_data');
add_action( 'wp_ajax_nopriv_mj_smgt_dashboard_append_report_data','mj_smgt_dashboard_append_report_data');
function mj_smgt_dashboard_append_report_data()
{
	$filter_val = $_REQUEST['filter_val'];
	$result = array();
	$dataPoints_2 = array();

	if($filter_val == "this_month")
	{
		$list=array();
		$month = date("m");
		$current_month = date("m");
		$current_year = date("Y");
		if($month=="2")
		{
			$max_d="28";
		}
		elseif($month=="4" || $month=="6" || $month=="9" || $month=="11")
		{
			$max_d="30";
		}
		else
		{
			$max_d="31";
		}
		for($d=1; $d<= $max_d; $d++)
		{
			$time=mktime(12, 0, 0, $month, $d, $year); 
					
			if (date('m', $time)==$month)       
				
				$date_list[]=date('Y-m-d', $time);
				$day_date[]=date('d', $time);

				$month_first_date = min($date_list);
				$month_last_date =   max($date_list);
		}

		$month = array();
		$i=1;
		foreach($day_date as $value)
		{ 
			$month[$i] = $value;
			$i++;
		}
		array_push($dataPoints_2, array(esc_html__('Day','apartment_mgt'),esc_html__('Fees Payment','apartment_mgt'),esc_html__('Expense','apartment_mgt')));
	}
	elseif($filter_val == "last_month")
	{
	
		$list=array();
		$month = date('m',strtotime("first day of previous month"));

		$current_month = date('m',strtotime("first day of previous month"));
		$current_year =  date('Y',strtotime("last day of previous month"));

		if($month=="2")
		{
			$max_d="28";
		}
		elseif($month=="4" || $month=="6" || $month=="9" || $month=="11")
		{
			$max_d="30";
		}
		else
		{
			$max_d="31";
		}
		for($d=1; $d<= $max_d; $d++)
		{
			$time=mktime(12, 0, 0, $month, $d, $year); 
					
			if (date('m', $time)==$month)       
				
				$date_list[]=date('Y-m-d', $time);
				$day_date[]=date('d', $time);

				$month_first_date = min($date_list);
				$month_last_date =   max($date_list);
		}

		$month = array();
		$i=1;
		foreach($day_date as $value)
		{ 
			$month[$i] = $value;
			$i++;
		}
		array_push($dataPoints_2, array(esc_html__('Day','apartment_mgt'),esc_html__('Fees Payment','apartment_mgt'),esc_html__('Expense','apartment_mgt')));
	}
	elseif($filter_val == "this_year")
	{
		$current_year = Date("Y");
		$month =array('1'=>esc_html__('Jan','apartment_mgt'),'2'=>esc_html__('Feb','apartment_mgt'),'3'=>esc_html__('Mar','apartment_mgt'),'4'=>esc_html__('Apr','apartment_mgt'),'5'=>esc_html__('May','apartment_mgt'),'6'=>esc_html__('Jun','apartment_mgt'),'7'=>esc_html__('Jul','apartment_mgt'),'8'=>esc_html__('Aug','apartment_mgt'),'9'=>esc_html__('Sep','apartment_mgt'),'10'=>esc_html__('Oct','apartment_mgt'),'11'=>esc_html__('Nov','apartment_mgt'),'12'=>esc_html__('Dec','apartment_mgt'),);
		array_push($dataPoints_2, array(esc_html__('Month','apartment_mgt'),esc_html__('Fees Payment','apartment_mgt'),esc_html__('Expense','apartment_mgt')));
	}
	elseif($filter_val == "last_year")
	{
		
		$start_date = date("Y-01-01", strtotime("-1 year"));
		$current_year = date("Y", strtotime($start_date));
		$month =array('1'=>esc_html__('Jan','apartment_mgt'),'2'=>esc_html__('Feb','apartment_mgt'),'3'=>esc_html__('Mar','apartment_mgt'),'4'=>esc_html__('Apr','apartment_mgt'),'5'=>esc_html__('May','apartment_mgt'),'6'=>esc_html__('Jun','apartment_mgt'),'7'=>esc_html__('Jul','apartment_mgt'),'8'=>esc_html__('Aug','apartment_mgt'),'9'=>esc_html__('Sep','apartment_mgt'),'10'=>esc_html__('Oct','apartment_mgt'),'11'=>esc_html__('Nov','apartment_mgt'),'12'=>esc_html__('Dec','apartment_mgt'),);
		array_push($dataPoints_2, array(esc_html__('Month','apartment_mgt'),esc_html__('Fees Payment','apartment_mgt'),esc_html__('Expense','apartment_mgt')));
	}
	
	
	$dataPoints_1 = array();
	$expense_array = array();
	$currency_symbol = MJ_smgt_get_currency_symbol(get_option( 'smgt_currency_code' ));
	foreach($month as $key=>$value)
	{
		global $wpdb;
		$table_name = $wpdb->prefix."smgt_income_expense";
		$fees_table_name = $wpdb->prefix."smgt_fees_payment";

		if($filter_val == "last_month" || $filter_val == "this_month")
		{
			$q = "SELECT * FROM $fees_table_name WHERE YEAR(paid_by_date) = $current_year AND MONTH(paid_by_date) = $current_month AND DAY(paid_by_date) = $value";
			$q1 = "SELECT * FROM $table_name WHERE YEAR(income_create_date) = $current_year AND MONTH(income_create_date) = $current_month AND DAY(income_create_date) = $value and invoice_type='expense'";
		}
		else
		{
			$q = "SELECT * FROM $fees_table_name WHERE YEAR(paid_by_date) = $current_year AND MONTH(paid_by_date) = $key";
			$q1 = "SELECT * FROM $table_name WHERE YEAR(income_create_date) = $current_year AND MONTH(income_create_date) = $key and invoice_type='expense'";
		}
		$result=$wpdb->get_results($q);
		$result1=$wpdb->get_results($q1);

		// EXPENSE ENTRY //
		$expense_yearly_amount = 0;
		foreach($result1 as $expense_entry)
		{
			$all_entry=json_decode($expense_entry->entry);
			$amount=0;
			foreach($all_entry as $entry)
			{
				$amount+=$entry->amount;
			}
			$expense_yearly_amount += $amount;
		}

		if($expense_yearly_amount == 0)
		{
			$expense_amount = null;
		}
		else
		{
			$expense_amount = $expense_yearly_amount;
		}
		// END EXPENSE ENTRY //

	
		// FEES PAYMENT ENTRY //
		$income_yearly_amount = 0;
		if(!empty($result))
		{
			foreach ($result as $retrieved_data) 
			{ 
				$income_amount = $retrieved_data->total_amount;
				$income_yearly_amount += $income_amount;
			}
		}
		
		if($income_yearly_amount == 0)
		{
			$income_amount = null;
		}
		else
		{
			$income_amount = $income_yearly_amount;
		}
		// END FEES PAYMENT ENTRY //
		$expense_array[] = $expense_amount;
		$income_array[] = $income_amount;
		array_push($dataPoints_2, array($value,$income_amount,$expense_amount));																				
	}

	$new_array = json_encode($dataPoints_2);
	
	
	$income_filtered = array_filter($income_array);
	$expense_filtered = array_filter($expense_array);

	if(!empty($income_filtered) || !empty($expense_filtered))
	{
		$new_currency_symbol = html_entity_decode($currency_symbol);
	
		?>
		
		<script type="text/javascript" src="<?php echo SMS_PLUGIN_URL.'/assets/js/chart_loder.js'; ?>"></script>
		<script type="text/javascript">
			google.charts.load('current', {'packages':['bar']});
			google.charts.setOnLoadCallback(drawChart);
			function drawChart() {
				var data = google.visualization.arrayToDataTable(<?php echo $new_array; ?>);

				var options = {
				
					bars: 'vertical', // Required for Material Bar Charts.
					colors: ['#104B73', '#FF9054'],
					
				};
			
				var chart = new google.charts.Bar(document.getElementById('barchart_material'));

				chart.draw(data, google.charts.Bar.convertOptions(options));
			}
		</script>
		<div id="barchart_material" style="width:100%;height: 280px; padding:20px;"></div>
		<?php
	}
	else
	{
		?>
		<div class="calendar-event-new"> 
			<img class="no_data_img" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >
		</div>
		<?php	
	}
	die();
}
?>