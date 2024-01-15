<?php 
$role_name=mj_smgt_get_user_role(get_current_user_id());
?>
<script type="text/javascript">
	jQuery(document).ready(function($){
		"use strict";	
		
		$('#notice_list').DataTable({
			
			"dom": 'lifrtp',
			"aoColumns":[		                  
				<?php
					if($role_name == "supportstaff")
					{
						?>
						{"bSortable": false},
						<?php
					}
					?>                 
					{"bSortable": false},
					{"bSortable": true},
					{"bSortable": true},
					{"bSortable": true},
					{"bSortable": true},
					{"bSortable": true},
					{"bSortable": true},	                  
					{"bSortable": false}],
			language:<?php echo mj_smgt_datatable_multi_language();?>	
		});
		$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'school-mgt') ?>");
		
		$('.select_all').on('click', function(e)
		{
			if($(this).is(':checked',true))  
			{
				$(".smgt_sub_chk").prop('checked', true);  
			}  
			else  
			{  
				$(".smgt_sub_chk").prop('checked',false);  
			} 
		});
		$('.smgt_sub_chk').on('change',function()
		{ 
			if(false == $(this).prop("checked"))
			{ 
				$(".select_all").prop('checked', false); 
			}
			if ($('.smgt_sub_chk:checked').length == $('.smgt_sub_chk').length )
			{
				$(".select_all").prop('checked', true);
			}
		});

		$("#delete_selected").on('click', function()
		{	
			if ($('.smgt_sub_chk:checked').length == 0 )
			{
				alert(language_translate2.one_record_select_alert);
				return false;
			}
			else
			{
				var alert_msg=confirm(language_translate2.delete_record_alert);
				if(alert_msg == false)
				{
					return false;
				}
				else
				{
					return true;
				}
			}
		});

		
		$('#notice_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});
		$("#notice_Start_date").datepicker({
			dateFormat: "yy-mm-dd",
			minDate:0,
			onSelect: function (selected) {
				var dt = new Date(selected);
				dt.setDate(dt.getDate() + 0);
				$("#notice_end_date").datepicker("option", "minDate", dt);
			}
		});
		$("#notice_end_date").datepicker({
		dateFormat: "yy-mm-dd",
			onSelect: function (selected) {
				var dt = new Date(selected);
				dt.setDate(dt.getDate() - 0);
				$("#notice_Start_date").datepicker("option", "maxDate", dt);
			}
		});
	});

	$(".ui-datepicker-next, .ui-datepicker-prev").on('hover',function () {
		$(this).addClass("hover");
	},
	function () {
		$(this).removeClass("hover");
	});
</script>
<?php  
//-------- CHECK BROWSER JAVA SCRIPT ----------//
mj_smgt_browser_javascript_check();
$active_tab = isset($_GET['tab'])?$_GET['tab']:'noticelist';
//--------------- ACCESS WISE ROLE -----------//
$user_access=mj_smgt_get_userrole_wise_access_right_array();
if (isset ( $_REQUEST ['page'] ))
{	
	if($user_access['view']=='0')
	{	
		mj_smgt_access_right_page_not_access_message();
		die;
	}
	if(!empty($_REQUEST['action']))
	{
		if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='edit'))
		{
			if($user_access['edit']=='0')
			{	
				mj_smgt_access_right_page_not_access_message();
				die;
			}			
		}
		if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='delete'))
		{
			if($user_access['delete']=='0')
			{	
				mj_smgt_access_right_page_not_access_message();
				die;
			}	
		}
		if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='insert'))
		{
			if($user_access['add']=='0')
			{	
				mj_smgt_access_right_page_not_access_message();
				die;
			}	
		} 
	}
}
//-------------------- SAVE NOTICE ---------------------------//
if(isset($_POST['save_notice']))
{	
	$nonce = $_POST['_wpnonce'];
	if ( wp_verify_nonce( $nonce, 'save_notice_admin_nonce' ) )
	{
		$start_date = date('Y-m-d',strtotime($_REQUEST['start_date']));
		$end_date = date('Y-m-d',strtotime($_REQUEST['end_date']));
		$exlude_id = mj_smgt_approve_student_list();
		if($start_date > $end_date )
		{ ?>
			<script type="text/javascript" src="<?php echo SMS_PLUGIN_URL.'/assets/js/pages/notice-date-error.js'; ?>" ></script>
			
			<?php
		}
		else
		{
			
			if(isset($_POST['class_id']) && $_POST['class_id'] == 'all')
			{
				foreach(mj_smgt_get_allclass() as $class)
				{
					$query_data['exclude']=$exlude_id;
					$query_data['meta_query'] = array(array('key' => 'class_name','value' => $class['class_id'],'compare' => '=') );
					$results = get_users($query_data);
					
					if(!empty($results))
					{
						foreach($results as $retrive_data)
						{
							$token = get_user_meta($retrive_data->ID,'token_id',true);
							$title = mj_smgt_popup_category_validation($_POST['notice_title']);
							$text = mj_smgt_address_description_validation($_POST['notice_content']);
							$bicon = get_user_meta($retrive_data->ID,'bicon',true);
							$new_bicon = $bicon + 1;
							$badge = $new_bicon;
							$a = array('registration_ids'=>array($token),'notice'=>array('title'=>$title,'text'=>$text,'badge'=>$badge));
							$json = json_encode($a);
							
							$curl = curl_init();

							curl_setopt_array($curl, array(
								CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
								CURLOPT_RETURNTRANSFER => true,
								CURLOPT_ENCODING => "",
								CURLOPT_MAXREDIRS => 10,
								CURLOPT_TIMEOUT => 300,
								CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
								CURLOPT_CUSTOMREQUEST => "POST",
								CURLOPT_POSTFIELDS => $json,
								CURLOPT_HTTPHEADER => array(
								"authorization: key=".get_option('smgt_notification_fcm_key'),
								"cache-control: no-cache",
								"content-type: application/json",
								"postman-token: ff7ad440-bbe0-6a2a-160d-83369683bc63"
								),
							));

							$response1 = curl_exec($curl);
							
							$err = curl_error($curl);

							curl_close($curl);
							
							
							update_user_meta($retrive_data->ID,'bicon',$new_bicon);
							
						}
					}
					
				}
			}
			else
			{
				$query_data['exclude']=$exlude_id;
				$query_data['meta_key'] = 'class_name';
				$query_data['meta_value'] = $_POST['class_id'];
				$query_data['meta_query'] = array(array('key' => 'class_name','value' => $_POST['class_id'],'compare' => '=') );
				$results = get_users($query_data);
				if(!empty($results))
				{
					foreach($results as $retrive_data)
					{
						$token = get_user_meta($retrive_data->ID,'token_id',true);
						$title = mj_smgt_popup_category_validation($_POST['notice_title']);
						$text = mj_smgt_address_description_validation($_POST['notice_content']);
						$bicon = get_user_meta($retrive_data->ID,'bicon',true);
						$new_bicon = $bicon + 1;
						$badge = $new_bicon;
						$a = array('registration_ids'=>array($token),'notice'=>array('title'=>$title,'text'=>$text,'badge'=>$badge));
						$json = json_encode($a);
						
						$curl = curl_init();

						curl_setopt_array($curl, array(
						CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => "",
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 300,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => "POST",
						CURLOPT_POSTFIELDS => $json,
						CURLOPT_HTTPHEADER => array(
							"authorization: key=".get_option('smgt_notification_fcm_key'),
							"cache-control: no-cache",
							"content-type: application/json",
							"postman-token: ff7ad440-bbe0-6a2a-160d-83369683bc63"
						),
						));

						$response1 = curl_exec($curl);
						
						$err = curl_error($curl);

						curl_close($curl);
						
						
						update_user_meta($retrive_data->ID,'bicon',$new_bicon);
						
					}
				}
			}

			if(isset($_POST['class_id']))
				$class_id 	=	$_REQUEST['class_id'];
		
			if($_REQUEST['action']=='edit')
			{
				$args = array(
					'ID'           => $_REQUEST['notice_id'],
					'post_title'   => mj_smgt_popup_category_validation($_REQUEST['notice_title']),
					'post_content' => mj_smgt_address_description_validation($_REQUEST['notice_content']),
				);
				
				$result1	=	wp_update_post( $args );
				$result2	=	update_post_meta($_REQUEST['notice_id'], 'notice_for', $_REQUEST['notice_for']);
				$result3	=	update_post_meta($_REQUEST['notice_id'], 'start_date',$_REQUEST['start_date']);
				$result4	=	update_post_meta($_REQUEST['notice_id'], 'end_date',$_REQUEST['end_date']);
							
				if(isset($_POST['class_id']))
					$result5	=	update_post_meta($_REQUEST['notice_id'], 'smgt_class_id',$_REQUEST['class_id']);
				
				if(isset($_POST['class_section']))
					$result6	=	update_post_meta($_REQUEST['notice_id'], 'smgt_section_id',$_REQUEST['class_section']);
				
				$role	=	$_POST['notice_for'];
				$smgt_sms_service_enable=0;
				$current_sms_service_active		=	get_option( 'smgt_sms_service');
				
					if(isset($_POST['smgt_sms_service_enable']))
					$smgt_sms_service_enable 	= 	$_POST['smgt_sms_service_enable'];
			
				if($smgt_sms_service_enable)
				{	
					$current_sms_service 	= 	get_option( 'smgt_sms_service');
					if(!empty($current_sms_service))
					{
						$userdata	=	mj_smgt_get_user_notice($role,$_REQUEST['class_id'],$_REQUEST['class_section']);
						
						if(!empty($userdata))
						{
							$mail_id 	= 	array();
							$i	 = 	0;
							foreach($userdata as $user)
							{						
								if($role == 'parent' && $class_id != 'all')
								$mail_id[]	=	$user['ID'];
								else 
									$mail_id[]	=	$user->ID;
								
								$i++;
							}
							$parent_number=array();
							foreach($mail_id as $user)
							{
								$parent_number[] = "+".mj_smgt_get_countery_phonecode(get_option( 'smgt_contry' )).get_user_meta($user, 'mobile_number',true);
							}
							
							if(is_plugin_active('sms-pack/sms-pack.php'))
							{
								$args = array();
								$args['mobile']=$parent_number;
								$args['message_from']="notice";
								$args['message']=$_POST['sms_template'];					
								if($current_sms_service=='telerivet' || $current_sms_service ="MSG91" || $current_sms_service=='bulksmsgateway.in' || $current_sms_service=='textlocal.in' || $current_sms_service=='bulksmsnigeria' || $current_sms_service=='africastalking')
								{				
									$send = send_sms($args);							
								}
							}
								
							foreach($mail_id as $user_id)
							{							
								$user_info 	= 	get_userdata(1);			
								$reciever_number 	= 	"+".mj_smgt_get_countery_phonecode(get_option( 'smgt_contry' )).get_user_meta($user_id, 'mobile_number',true);						
								$message_content 	= 	$_POST['sms_template'];						
								if($current_sms_service == 'clickatell')
								{			
									$clickatell		=	get_option('smgt_clickatell_sms_service');
									$to 	= 	$reciever_number;
									$message 	= 	str_replace(" ","%20",$message_content);
									$username 	= 	$clickatell['username']; //clickatell username
									$password 	= 	$clickatell['password']; // clickatell password
									$api_key 	= 	$clickatell['api_key'];//clickatell apikey
									$baseurl 	=	"http://api.clickatell.com";
					
									// auth call
									$url = "$baseurl/http/auth?user=$username&password=$password&api_id=$api_key";
					
									// do auth call
									$ret = file($url);
					
									// explode our response. return string is on first line of the data returned
									$sess = explode(":",$ret[0]);
									if ($sess[0] == "OK") {
										
										$sess_id = trim($sess[1]); // remove any whitespace
										$url = "$baseurl/http/sendmsg?session_id=$sess_id&to=$to&text=$message";
										
										// do sendmsg call
										$ret = file($url);
										$send = explode(":",$ret[0]);								
									}
								}
								if($current_sms_service == 'twillo')
								{
									//Twilio lib
									require_once SMS_PLUGIN_DIR. '/lib/twilio/Services/Twilio.php';
									$twilio=get_option( 'smgt_twillo_sms_service');
									$account_sid = $twilio['account_sid']; //Twilio SID
									$auth_token = $twilio['auth_token']; // Twilio token
									$from_number = $twilio['from_number'];//My number
									$receiver = $reciever_number; //Receiver Number
									$message = $message_content; // Message Text
									//twilio object
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
									$mobile_number=get_user_meta($user_id, 'mobile_number',true);
									$country_code="+".mj_smgt_get_countery_phonecode(get_option( 'smgt_contry' ));
									$message = $message_content; // Message Text
									smgt_msg91_send_mail_function($mobile_number,$message,$country_code);
								}											
							} 		
						}
					}
				}
				if($result1 || $result2 || $result3 || $result4 || isset($result5))
				{ 
					wp_redirect ( home_url() . '?dashboard=user&page=notice&tab=noticelist&message=2'); 
				}
			}
			else
			{			
				$current_sms_service 	= 	get_option( 'smgt_sms_service');
				$post_id 	= 	wp_insert_post( array(
					'post_status' 	=>	'publish',
					'post_type' 	=> 	'notice',
					'post_title' 	=> 	mj_smgt_popup_category_validation($_REQUEST['notice_title']),
					'post_content' 	=> 	mj_smgt_address_description_validation($_REQUEST['notice_content'])
				));
				
				if(!empty($_POST['notice_for']))
				{
					delete_post_meta($post_id, 'notice_for');
					$result		=	add_post_meta($post_id, 'notice_for',$_POST['notice_for']);
					$result		=	add_post_meta($post_id, 'start_date',$_POST['start_date']);
					$result		=	add_post_meta($post_id, 'end_date',$_POST['end_date']);
					
					if(isset($_POST['class_id']))
					$result		=	add_post_meta($post_id, 'smgt_class_id',$_POST['class_id']);
				
					if(isset($_POST['class_section']))
					$result6	=	update_post_meta($_REQUEST['notice_id'], 'smgt_section_id',$_REQUEST['class_section']);
				
					$role	=	$_POST['notice_for'];
					$smgt_sms_service_enable	=	0;
					$smgt_mail_service_enable	=	0;
					$current_sms_service_active =	get_option( 'smgt_sms_service');
					
								
					$userdata	=	mj_smgt_get_user_notice($role,$_POST['class_id']);		
						
					if(!empty($userdata))
					{
						if(isset($_POST['smgt_mail_service_enable']))
						$smgt_mail_service_enable = $_POST['smgt_mail_service_enable'];
						
						if($smgt_mail_service_enable)
						{
							$mail_id = array();
							$i = 0;
							$startdate	= 	strtotime($_POST['start_date']);
							$enddate 	= 	strtotime($_POST['end_date']);
							if($startdate == $enddate)
							{
								$date	 =	mj_smgt_getdate_in_input_box($_POST['start_date']);
							}
							else
							{
								$date	 =	mj_smgt_getdate_in_input_box($_POST['start_date'])." To ".mj_smgt_getdate_in_input_box($_POST['end_date']);
							}
							
							$search['{{notice_title}}']	 	= 	$_REQUEST['notice_title'];
							$search['{{notice_date}}'] 		= 	$date;
							$search['{{notice_for}}'] 		= 	$_POST['notice_for'];
							$search['{{notice_comment}}']	=	$_REQUEST['notice_content'];								
							$search['{{school_name}}'] 		= 	get_option('smgt_school_name');								
							$message = mj_smgt_string_replacement($search,get_option('notice_mailcontent'));					
							foreach($userdata as $user)
							{
								if(get_option('smgt_mail_notification') == '1')
								{
									wp_mail($user->user_email,get_option('notice_mailsubject'),$message);
								}
								if($role == 'parent' && $class_id != 'all')
									$mail_id[]=$user['ID'];
								else 
									$mail_id[]=$user->ID;						
									$i++;
							}
						}
						
					if(isset($_POST['smgt_sms_service_enable']))
						$smgt_sms_service_enable = $_POST['smgt_sms_service_enable'];
					
						if($smgt_sms_service_enable)
						{
							if(!empty($current_sms_service))
							{
								$parent_number=array();
								foreach($mail_id as $user)
								{
									$parent_number[] = "+".mj_smgt_get_countery_phonecode(get_option( 'smgt_contry' )).get_user_meta($user, 'mobile_number',true);
								}			
								if(is_plugin_active('sms-pack/sms-pack.php'))
								{							
									$args 	= 	array();
									$args['mobile']		=	$parent_number;
									$args['message_from']	=	"notice";
									$args['message'] 	= 	$_POST['sms_template'];
									
									if($current_sms_service == 'telerivet'|| $current_sms_service == 'MSG91' || $current_sms_service=='bulksmsgateway.in' || $current_sms_service=='bulksmsnigeria' || $current_sms_service=='textlocal.in' || $current_sms_service=='africastalking')
									{				
										$send = send_sms($args);						
									}
								} 		 
								foreach($mail_id as $user_id)
								{
									$user_info = get_userdata(1);				 	
									$reciever_number = "+".mj_smgt_get_countery_phonecode(get_option( 'smgt_contry' )).get_user_meta($user_id, 'mobile_number',true);				 		
									$message_content = $_POST['sms_template'];
									$current_sms_service = get_option( 'smgt_sms_service');
									
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
											$mobile_number=get_user_meta($user_id, 'mobile_number',true);
											$country_code="+".mj_smgt_get_countery_phonecode(get_option( 'smgt_contry' ));
											$message = $message_content; // Message Text
											smgt_msg91_send_mail_function($mobile_number,$message,$country_code);
										}		
								} 
							}
						}
				}
					if($result){ 
						wp_redirect ( home_url() . '?dashboard=user&page=notice&tab=noticelist&message=1'); 
					}
				}			
			}	
		}
	}
}
if(isset($_REQUEST['delete_selected']))
{		
	if(!empty($_REQUEST['id']))
	foreach($_REQUEST['id'] as $id)
		$result=wp_delete_post($id);
	if($result)
	{
		wp_redirect ( home_url() . '?dashboard=user&page=notice&tab=noticelist&message=3'); 
	}
}
//----------------------------- SAVE NOTICE -----------------------------------//
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')
{
	$result=wp_delete_post($_REQUEST['notice_id']);
	if($result)
	{
		wp_redirect ( home_url() . '?dashboard=user&page=notice&tab=noticelist&message=3'); 
	}
}
?>
<!-- View Popup Code -->	
<div class="popup-bg">
    <div class="overlay-content">    
    	<div class="notice_content"></div>    
    </div>
</div>

<div class="panel-body panel-white frontend_list_margin_30px_res">
	<?php
	$message = isset($_REQUEST['message'])?$_REQUEST['message']:'0';
	switch($message)
	{
		case '1':
			$message_string = esc_attr__('Notice Added Successfully.','school-mgt');
			break;
		case '2':
			$message_string = esc_attr__('Notice Updated Successfully.','school-mgt');
			break;	
		case '3':
			$message_string = esc_attr__('Notice Deleted Successfully.','school-mgt');
			break;
	}
	if($message)
	{ ?>
		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">
			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></span>
			</button>
			<?php echo $message_string;?>
		</div>
		<?php
	} ?>
	<?php
	if($active_tab == 'noticelist')
	{ 
		$user_id=get_current_user_id();
		
		//------- NOTICE DATA FOR STUDENT ---------//
		if($school_obj->role == 'student')
		{
			$own_data=$user_access['own_data'];
			if($own_data == '1')
			{ 
				$class_name  	= 	get_user_meta(get_current_user_id(),'class_name',true);		
				$class_section  = 	get_user_meta(get_current_user_id(),'class_section',true);	
				$notice_list = mj_smgt_student_notice_dashbord($class_name,$class_section);
			}
			else
			{
				$args['post_type'] = 'notice';
				$args['posts_per_page'] = -1;
				$args['post_status'] = 'public';
				$q = new WP_Query();
				$notice_list = $q->query( $args );
			}
			 
		}
		//------- NOTICE DATA FOR TEACHER ---------//
		elseif($school_obj->role == 'teacher')
		{
			$own_data=$user_access['own_data'];
			if($own_data == '1')
			{ 
				$notice_list =mj_smgt_teacher_notice_dashbord();
			}
			else
			{
				$args['post_type'] = 'notice';
				$args['posts_per_page'] = -1;
				$args['post_status'] = 'public';
				$q = new WP_Query();
				$notice_list = $q->query( $args );
			}
		}
		//------- NOTICE DATA FOR PARENT ---------//
		elseif($school_obj->role == 'parent')
		{
			$own_data=$user_access['own_data'];
			if($own_data == '1')
			{  
				$notice_list = mj_smgt_parent_notice_dashbord();
			}
			else
			{
				$args['post_type'] = 'notice';
				$args['posts_per_page'] = -1;
				$args['post_status'] = 'public';
				$q = new WP_Query();
				$notice_list = $q->query( $args );
			}
		}
		//------- NOTICE DATA FOR SUPPORT STAFF ---------//
		else
		{ 
			$own_data=$user_access['own_data'];
			if($own_data == '1')
			{ 
				$notice_list = mj_smgt_supportstaff_notice_dashbord();
			}
			else
			{
				$args['post_type'] = 'notice';
				$args['posts_per_page'] = -1;
				$args['post_status'] = 'public';
				$q = new WP_Query();
				$notice_list = $q->query( $args );
			}
		} 
		?>
		<div class="panel-body">
			<?php
			if(!empty($notice_list))
			{	
				?>
				<div class="table-responsive">
					<form id="frm-example" name="frm-example" method="post"><!-- panel-body -->	
						<table id="notice_list"class="display dataTable notice_datatable" cellspacing="0" width="100%">
							<thead class="<?php echo MJ_smgt_datatable_heder() ?>">
								<tr>
									<?php
									if($role_name == "supportstaff")
									{
										?>
										<th class="padding_0"><input type="checkbox" class="select_all" id="select_all"></th>
										<?php
									}
									?>
									<th><?php  _e( 'Image', 'school-mgt' ) ;?></th>
									<th><?php esc_attr_e('Notice Title','school-mgt');?></th>
									<th><?php esc_attr_e('Notice Comment','school-mgt');?></th>
									<th><?php esc_attr_e('Notice Start Date','school-mgt');?></th>
									<th><?php esc_attr_e('Notice End Date','school-mgt');?></th>
									<th><?php esc_attr_e('Notice For','school-mgt');?></th>
									<th><?php esc_attr_e('Class','school-mgt');?></th>
									<th class="text_align_end"><?php _e( 'Action', 'school-mgt' ) ;?></th>
								</tr>
							</thead>
							<tbody>
								<?php 		
								if (!empty ($notice_list))
								{
									$i=0;	
									foreach ($notice_list as $retrieved_data ) 
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
										?>
										<tr>
											<?php
											if($role_name == "supportstaff")
											{
												?>
												<td class="checkbox_width_10px">
													<input type="checkbox" class="smgt_sub_chk select-checkbox" name="id[]" value="<?php echo $retrieved_data->ID;?>">
												</td>
												<?php
											}
											?>
											<td class="user_image width_50px profile_image_prescription padding_left_0">
												<a class="color_black view-notice" id="<?php echo $retrieved_data->ID;?>" href="#">
													<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	
														<img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/White_icons/notice.png"?>" height= "30px" width ="30px" alt="" class="massage_image center">
													</p>
												</a>
											</td>
											<td><a class="color_black view-notice" id="<?php echo $retrieved_data->ID;?>" href="#"><?php echo $retrieved_data->post_title;?></a> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Notice Title','school-mgt');?>" ></i>
											</td>
											<td>
												<?php 
												if(!empty($retrieved_data->post_content))
												{

													$strlength= strlen($retrieved_data->post_content);
													if($strlength > 50)
														echo substr($retrieved_data->post_content, 0,50).'...';
													else
														echo $retrieved_data->post_content;
												}else{
													echo 'N/A';
												}
												?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Notice Comment','school-mgt');?>" ></i>
											</td>
											<td><?php echo mj_smgt_getdate_in_input_box(get_post_meta($retrieved_data->ID,'start_date',true));?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Notice Start Date','school-mgt');?>" ></i></td> 
											<td><?php echo mj_smgt_getdate_in_input_box(get_post_meta($retrieved_data->ID,'end_date',true));?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Notice End Date','school-mgt');?>" ></i></td> 			      
											<td><?php print esc_attr_e(ucfirst(get_post_meta( $retrieved_data->ID, 'notice_for',true)),'school-mgt'); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Notice For','school-mgt');?>" ></i></td>
											<td>
											<?php 
												if(get_post_meta( $retrieved_data->ID, 'smgt_class_id',true) !="" && get_post_meta( $retrieved_data->ID, 'smgt_class_id',true) =="all")
												{
													esc_attr_e('All','school-mgt');
												}
												elseif(get_post_meta( $retrieved_data->ID, 'smgt_class_id',true) !="")
												{
													echo mj_smgt_get_class_name(get_post_meta( $retrieved_data->ID, 'smgt_class_id',true));
												}?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Class','school-mgt');?>" ></i>
											</td>            									
											<td class="action"> 
												<div class="smgt-user-dropdown">
													<ul class="" style="margin-bottom: 0px !important;">
														<li class="">
															<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">
																<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >
															</a>
															<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">

																<li class="float_left_width_100">
																	<a href="#" class="float_left_width_100 view-notice" id="<?php echo $retrieved_data->ID;?>"><i class="fa fa-eye"> </i><?php esc_attr_e('View Notice Detail','school-mgt');?></a>
																</li>
																<?php
																if($user_access['edit']=='1')
																{
																?>
																	<li class="float_left_width_100 border_bottom_item">
																		<a href="?dashboard=user&page=notice&tab=addnotice&action=edit&notice_id=<?php echo $retrieved_data->ID; ?>" class="float_left_width_100"><i class="fa fa-edit"></i><?php esc_attr_e('Edit','school-mgt');?></a>
																	</li>
																<?php
																}
																if($user_access['delete']=='1')
																{
																?>
																	<li class="float_left_width_100">
																	<a href="?dashboard=user&page=notice&tab=noticelist&action=delete&notice_id=<?php echo $retrieved_data->ID;?>" class="float_left_width_100" style="color: #fd726a !important;" onclick="return confirm('<?php esc_attr_e('Are you sure you want to delete this record?','school-mgt');?>');"><i class="fa fa-trash"></i> <?php esc_attr_e('Delete','school-mgt');?></a>
																<?php
																}
																?>
															</ul>
														</li>
													</ul>
												</div>	
											</td>
										</tr>	
										<?php   
										$i++;    
									}
								}					
								?>
							</tbody>       
						</table>
						<?php
						if($role_name == "supportstaff")
						{
							?>	
							<div class="print-button pull-left">
								<button class="btn btn-success btn-sms-color" type="button">
									<input type="checkbox" name="id[]" class="select_all" value="<?php echo esc_attr($retrieved_data->ID); ?>" style="margin-top: 0px;">
									<label for="checkbox" class="margin_right_5px"><?php esc_html_e( 'Select All', 'school-mgt' ) ;?></label>
								</button>
								<?php 
								if($user_access['delete']=='1')
								{ ?>
									<button id="delete_selected" data-toggle="tooltip" title="<?php esc_html_e('Delete Selected','school-mgt');?>" name="delete_selected" class="delete_selected" ><img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png" ?>" alt=""></button>
									<?php 
								} ?>
							</div>
							<?php
						}
						?>
					</form>
				</div>
				<?php
			}
			else
			{	
				if($user_access['add']=='1')
				{
					?>
					<div class="no_data_list_div no_data_img_mt_30px"> 
						<a href="<?php echo home_url().'?dashboard=user&page=notice&tab=addnotice';?>">
							<img class="col-md-12 width_100px" src="<?php echo get_option( 'smgt_no_data_img' ) ?>" >
						</a>
						<div class="col-md-12 dashboard_btn margin_top_20px">
							<label class="no_data_list_label"><?php esc_html_e('Tap on above icon to add your first Record.','school-mgt'); ?> </label>
						</div> 
					</div>		
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
			}
			?>
		</div>
		<?php
	}
	if($active_tab == 'addnotice')
	{	
		$edit=0;
		if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
		{
			$edit=1;
			$post = get_post($_REQUEST['notice_id']);
		}
		?>
		<div class="panel-body"> 
			<form name="class_form" action="" method="post" class="mt-3 form-horizontal" id="notice_form">
				<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
				<input type="hidden" name="action" value="<?php echo $action;?>">
				<input type="hidden" name="notice_id"   value="<?php if($edit){ echo $post->ID;}?>"/> 

				<div class="header">	
					<h3 class="first_hed"><?php esc_html_e(' Notice Information','school-mgt');?></h3>
				</div>
				<div class="form-body user_form">
					<div class="row">
						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
							<div class="form-group input">
								<div class="col-md-12 form-control">
									<input id="notice_title" class="form-control validate[required,custom[popup_category_validation]] text-input" maxlength="50" type="text" value="<?php if($edit){ echo $post->post_title;}?>" name="notice_title">
									<label class="" for="notice_title"><?php esc_attr_e('Notice Title','school-mgt');?><span class="require-field">*</span></label>
								</div>
							</div>
						</div>

						<div class="col-md-6 note_text_notice">
							<div class="form-group input">
								<div class="col-md-12 note_border margin_bottom_15px_res">
									<div class="form-field">
										<textarea name="notice_content" class="textarea_height_47px form-control validate[custom[address_description_validation]]" maxlength="150" id="notice_content"><?php if($edit){ echo $post->post_content;}?></textarea>
										<span class="txt-title-label"></span>
										<label class="text-area address active" for="notice_content"><?php esc_attr_e('Notice Comment','school-mgt');?></label>
									</div>
								</div>
							</div>
						</div>				

						<div class="col-md-6">
							<div class="form-group input">
								<div class="col-md-12 form-control">
									<input id="notice_Start_date" class="datepicker form-control validate[required] text-input" type="text" value="<?php if($edit){ echo date("Y-m-d",strtotime(get_post_meta($post->ID,'start_date',true)));}else{echo date("Y-m-d"); }?>" name="start_date" readonly>
									<label class="" for="notice_content"><?php esc_attr_e('Notice Start Date','school-mgt');?><span class="require-field">*</span></label>
								</div>
							</div>
						</div>

						<?php wp_nonce_field( 'save_notice_admin_nonce' ); ?>
						<div class="col-md-6 error_msg_left_margin">
							<div class="form-group input">
								<div class="col-md-12 form-control">
									<input id="notice_end_date" class="datepicker form-control validate[required] text-input" type="text" value="<?php if($edit){ echo date("Y-m-d",strtotime(get_post_meta($post->ID,'end_date',true)));}else{echo date("Y-m-d");}?>" name="end_date" readonly>
									<label class="" for="notice_content"><?php esc_attr_e('Notice End Date','school-mgt');?><span class="require-field">*</span></label>
								</div>
							</div>
						</div>

						<div class="col-md-6 input">
							<label class="ml-1 custom-top-label top" for="notice_for"><?php esc_attr_e('Notice For','school-mgt');?></label>
							<select name="notice_for" id="notice_for" class="line_height_30px form-control notice_for_ajax">
								<option value = "all"><?php esc_attr_e('All','school-mgt');?></option>
								<option value="teacher" <?php if($edit) echo selected(get_post_meta( $post->ID, 'notice_for',true),'teacher');?>><?php esc_attr_e('Teacher','school-mgt');?></option>
								<option value="student" <?php if($edit) echo selected(get_post_meta( $post->ID, 'notice_for',true),'student');?>><?php esc_attr_e('Student','school-mgt');?></option>
								<option value="parent" <?php if($edit) echo selected(get_post_meta( $post->ID, 'notice_for',true),'parent');?>><?php esc_attr_e('Parent','school-mgt');?></option>
								<option value="supportstaff" <?php if($edit) echo selected(get_post_meta( $post->ID, 'notice_for',true),'supportstaff');?>><?php esc_attr_e('Support Staff','school-mgt');?></option>
							</select>	
						</div>
				
						<div class="col-md-6 input" id="smgt_select_class">
							<label class="ml-1 custom-top-label top" for="sms_template"><?php esc_attr_e('Select Class','school-mgt');?></label>
							<?php if($edit){ $classval=get_post_meta( $post->ID, 'smgt_class_id',true); }elseif(isset($_POST['class_id'])){$classval=$_POST['class_id'];}else{$classval='';}?>
							<select name="class_id"  id="class_list" class="line_height_30px form-control">
								<option value="all"><?php esc_attr_e('All','school-mgt');?></option>
								<?php
								foreach(mj_smgt_get_allclass() as $classdata)
								{  
									?>
									<option  value="<?php echo $classdata['class_id'];?>" <?php echo selected($classval,$classdata['class_id']);?>><?php echo $classdata['class_name'];?></option>
									<?php 
								}?>
							</select>
						</div>

						<div class="col-md-6 input" id="smgt_select_section">
							<label class="ml-1 custom-top-label top" for="class_name"><?php esc_attr_e('Class Section','school-mgt');?></label>
							<?php if($edit){ $sectionval=get_post_meta( $post->ID, 'smgt_section_id',true); }elseif(isset($_POST['class_section'])){$sectionval=$_POST['class_section'];}else{$sectionval='';}?>
							<select name="class_section" class="line_height_30px form-control" id="class_section">
								<option value=""><?php esc_attr_e('Select Class Section','school-mgt');?></option>
								<?php
								if($edit){
									foreach(mj_smgt_get_class_sections($classval) as $sectiondata)
									{  ?>
									<option value="<?php echo $sectiondata->id;?>" <?php selected($sectionval,$sectiondata->id);  ?>><?php echo $sectiondata->section_name;?></option>
								<?php } 
								}?>
							</select>
						</div>

						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 mb-3 rtl_margin_top_15px">
							<div class="form-group">
								<div class="col-md-12 form-control">
									<div class="row padding_radio">
										<div class="">
											<label class="custom-top-label" for="enable"><?php esc_attr_e('Send Mail','school-mgt');?></label>
											<input id="chk_sms_sent_mail" class="check_box_input_margin" type="checkbox" <?php $smgt_mail_service_enable = 0;if($smgt_mail_service_enable) echo "checked";?> value="1" name="smgt_mail_service_enable">
											<lable><?php esc_attr_e('Mail','school-mgt');?></label>
										</div>												
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 mb-3 rtl_margin_top_15px">
							<div class="form-group">
								<div class="col-md-12 form-control">
									<div class="row padding_radio">
										<div class="">
											<label class="custom-top-label" for="enable"><?php esc_attr_e('Send SMS','school-mgt');?></label>
											<input id="chk_sms_sent" type="checkbox" <?php $smgt_sms_service_enable = 0;if($smgt_sms_service_enable) echo "checked";?> value="1" name="smgt_sms_service_enable">
											<lable> <?php esc_attr_e('SMS','school-mgt');?></label>
										</div>												
									</div>
								</div>
							</div>
						</div>

						<div class="col-md-6 hmsg_message_none mt-3 rtl_margin_top_15px" id="hmsg_message_sent" >
							<div class="form-group input">
								<div class="col-md-12 note_border margin_bottom_15px_res">
									<textarea name="sms_template" class="textarea_height_47px form-control validate[required]" maxlength="160"></textarea>
									<span class="txt-title-label"></span>
									<label class="text-area address active" for="sms_template"><?php esc_attr_e('SMS Text','school-mgt');?><span class="require-field">*</span></label>
								</div>
							</div>
						</div>		
						<div id="hmsg_message_sent" class="hmsg_message_none">
							<div class="mb-3 form-group row">
								<label class="col-sm-2 control-label col-form-label text-md-end" for="sms_template"><?php esc_attr_e('SMS Text','school-mgt');?><span class="require-field">*</span></label>
								<div class="col-sm-8">
									<textarea name="sms_template" class="form-control validate[required]" maxlength="160"></textarea>
									<label><?php esc_attr_e('Max. 160 Character','school-mgt');?></label>
								</div>
							</div>
						</div>
					</div>		
				</div>
				<div class="form-body user_form">
					<div class="row">
						<div class="col-sm-6">       
							<input type="submit" value="<?php if($edit){ esc_attr_e('Save Notice','school-mgt'); }else{ esc_attr_e('Add Notice','school-mgt');}?>" name="save_notice" class="btn btn-success save_btn" />
						</div>    
					</div>
				</div>     
			</form>
		</div>
		<?php
	}
	?>
</div>
<?php ?>