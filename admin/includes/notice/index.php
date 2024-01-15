<?php //-------- CHECK BROWSER JAVA SCRIPT ----------//
mj_smgt_browser_javascript_check();
$role=mj_smgt_get_user_role(get_current_user_id());
if($role == 'administrator')
{
	$user_access_add=1;
	$user_access_edit=1;
	$user_access_delete=1;
	$user_access_view=1;
}
else
{
	$user_access=mj_smgt_get_userrole_wise_filter_access_right_array('notice');
	$user_access_add=$user_access['add'];
	$user_access_edit=$user_access['edit'];
	$user_access_delete=$user_access['delete'];
	$user_access_view=$user_access['view'];
	
	if (isset ( $_REQUEST ['page'] ))
	{	
		if($user_access_view=='0')
		{	
			mj_smgt_access_right_page_not_access_message_admin_side();
			die;
		}
		if(!empty($_REQUEST['action']))
		{
			if ('notice' == $user_access['page_link'] && ($_REQUEST['action']=='edit'))
			{
				if($user_access_edit=='0')
				{	
					mj_smgt_access_right_page_not_access_message_admin_side();
					die;
				}			
			}
			if ('notice' == $user_access['page_link'] && ($_REQUEST['action']=='delete'))
			{
				if($user_access_delete=='0')
				{	
					mj_smgt_access_right_page_not_access_message_admin_side();
					die;
				}	
			}
			if ('notice' == $user_access['page_link'] && ($_REQUEST['action']=='insert'))
			{
				if($user_access_add=='0')
				{	
					mj_smgt_access_right_page_not_access_message_admin_side();
					die;
				}	
			} 
		}
	}
}
?>
<script type="text/javascript">
	jQuery(document).ready(function($)
	{
		"use strict";	
		$('#notice_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});
		
			$("#notice_Start_date").datepicker({
			dateFormat: "yy-mm-dd",
			minDate:0, 
			onSelect: function (selected) {
				var dt = new Date(selected);
				dt.setDate(dt.getDate() + 0);
				$("#notice_end_date").datepicker("option", "minDate", dt);
			},
			beforeShow: function (textbox, instance) 
			{
				instance.dpDiv.css({
					marginTop: (-textbox.offsetHeight) + 'px'                   
				});
			}
		});
		$("#notice_end_date").datepicker({
		dateFormat: "yy-mm-dd",
			onSelect: function (selected) {
				var dt = new Date(selected);
				dt.setDate(dt.getDate() - 0);
				$("#notice_Start_date").datepicker("option", "maxDate", dt);
			},
			beforeShow: function (textbox, instance) 
			{
				instance.dpDiv.css({
					marginTop: (-textbox.offsetHeight) + 'px'                   
				});
			}
		});

	});
</script>
<?php
	if(isset($_POST['save_notice']))
	{	
        $nonce = $_POST['_wpnonce'];
	    if ( wp_verify_nonce( $nonce, 'save_notice_admin_nonce' ) )
		{
			$start_date = date('Y-m-d',strtotime($_REQUEST['start_date']));
			$end_date = date('Y-m-d',strtotime($_REQUEST['end_date']));
			if($start_date > $end_date )
			{ ?>
				<script type="text/javascript" src="<?php echo SMS_PLUGIN_URL.'/assets/js/pages/notice-date-error.js'; ?>" ></script>
			<?php }
			else
			{
				if(isset($_POST['class_id']))
					$class_id 	=	$_REQUEST['class_id'];
			
				if($_REQUEST['action']=='edit')
				{
					school_append_audit_log(''.esc_html__('Update Notice Detail','hospital_mgt').'',null,get_current_user_id(),'edit');
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
					if($result1 || $result2 || $result3 || $result4 || isset($result5) )
					{ 
						wp_redirect ( admin_url().'admin.php?page=smgt_notice&tab=noticelist&message=2');
					}
				}
				else
				{		
					school_append_audit_log(''.esc_html__('Add New Notice Detail','hospital_mgt').'',null,get_current_user_id(),'insert');	
					$current_sms_service 	= 	get_option( 'smgt_sms_service');
					$post_id 	= 	wp_insert_post( array(
						'post_status' 	=>	'publish',
						'post_type' 	=> 	'notice',
						'post_title' 	=> 	mj_smgt_popup_category_validation($_REQUEST['notice_title']),
						'post_content' 	=> 	mj_smgt_address_description_validation($_REQUEST['notice_content'])
					));
					
					if(!empty($_POST['notice_for']))
					{
						$exlude_id = mj_smgt_approve_student_list();
						$query_data['exclude']=$exlude_id;
						$results = get_users($query_data);
						
						foreach($results as $retrive_data)
						{
							$token = get_user_meta($retrive_data->ID,'token_id',true);
							$title = mj_smgt_popup_category_validation($_POST['notice_title']);
							$text = mj_smgt_address_description_validation($_POST['notice_content']);
							$bicon = get_user_meta($retrive_data->ID,'bicon',true);
							if(empty($bicon))
							{
								$bicon = 0;
							}
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

						delete_post_meta($post_id, 'notice_for');
						$result		=	add_post_meta($post_id, 'notice_for',$_POST['notice_for']);
						$result		=	add_post_meta($post_id, 'start_date',$_POST['start_date']);
						$result		=	add_post_meta($post_id, 'end_date',$_POST['end_date']);
						$result 	=	add_post_meta($post_id, 'notice_status', 0);
						
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
					}
					if($result)
					{ 
						wp_redirect ( admin_url().'admin.php?page=smgt_notice&tab=noticelist&message=1');				
					}
				}				
			}
	    }
	}
	if(isset($_REQUEST['delete_selected']))
	{		
		if(!empty($_REQUEST['id']))
		{
			school_append_audit_log(''.esc_html__('Delete Notice Detail','hospital_mgt').'',null,get_current_user_id(),'delete');
			foreach($_REQUEST['id'] as $id)
			{
				$result=wp_delete_post($id);
				if($result)
				{
					wp_redirect ( admin_url().'admin.php?page=smgt_notice&tab=noticelist&message=3');
				}
			}
		}
	}
	
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')
	{
		school_append_audit_log(''.esc_html__('Delete Notice Detail','hospital_mgt').'',null,get_current_user_id(),'delete');
		$result=wp_delete_post($_REQUEST['notice_id']);
		if($result)
		{
			wp_redirect ( admin_url().'admin.php?page=smgt_notice&tab=noticelist&message=3');
		}
	}
	$active_tab = isset($_GET['tab'])?$_GET['tab']:'noticelist';
	?>
<!-- View Popup Code -->	
<div class="popup-bg">
    <div class="overlay-content">   
    	<div class="notice_content"></div>    
    </div>     
</div>	
<div class="page-inner"><!-- page-inner -->
	<div class="main_list_margin_15px"><!-- main_list_margin_15px -->
		<?php
		$message = isset($_REQUEST['message'])?$_REQUEST['message']:'0';
		switch($message)
		{
			case '1':
				$message_string = esc_attr__('Notice Added successfully.','school-mgt');
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
			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible">
				<p><?php echo $message_string;?></p>
				<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span class="screen-reader-text">Dismiss this notice.</span></button>
			</div>
			<?php 
		} ?>
		<div class="row"><!-- row -->
			<div class="col-md-12 padding_0"><!-- col-md-12 -->
				<div class="smgt_main_listpage"><!-- smgt_main_listpage -->
					<?php
					if($active_tab == 'noticelist')
					{ 
						$args['post_type'] = 'notice';
						$args['posts_per_page'] = -1;
						$args['post_status'] = 'public';
						$q = new WP_Query();
						$retrieve_class = $q->query( $args );
						$format =get_option('date_format') ;
						
						if(!empty($retrieve_class))
						{
							?>	
							<script type="text/javascript">
								jQuery(document).ready(function($)
								{
									"use strict";	
									var table =  jQuery('#notice_list').DataTable({
										responsive: true,
										"dom": 'lifrtp',
										"order": [[ 2, "asc" ]],
										"aoColumns":[		                  
												{"bSortable": false},	                 
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
								});
							</script>
							<div class="panel-body"><!-- panel-body -->
								<div class="table-responsive">
									<form id="frm-example" name="frm-example" method="post"><!-- panel-body -->	
										<table id="notice_list" class="display" cellspacing="0" width="100%">
											<thead class="<?php echo MJ_smgt_datatable_heder() ?>">
												<tr>
													<th class="padding_0"><input type="checkbox" class="select_all" id="select_all"></th>
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
												$i=0;	
												foreach ($retrieve_class as $retrieved_data)
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
														<td class="checkbox_width_10px">
															<input type="checkbox" class="smgt_sub_chk select-checkbox" name="id[]" value="<?php echo $retrieved_data->ID;?>">
														</td>
														<td class="user_image width_50px profile_image_prescription padding_left_0">
															<a class="view-notice" id="<?php echo $retrieved_data->ID;?>" href="#">
																<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	
																	<img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/White_icons/notice.png"?>" height= "30px" width ="30px" alt="" class="massage_image center">
																</p>
															</a>
														</td>
														<td>
															<a class="color_black view-notice" id="<?php echo $retrieved_data->ID;?>" href="#"><?php echo $retrieved_data->post_title;?></a> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Notice Title','school-mgt');?>" ></i>
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
														<td>
															<?php echo mj_smgt_getdate_in_input_box(get_post_meta($retrieved_data->ID,'start_date',true));?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Notice Start Date','school-mgt');?>" ></i>
														</td> 
														<td>
															<?php echo mj_smgt_getdate_in_input_box(get_post_meta($retrieved_data->ID,'end_date',true));?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Notice End Date','school-mgt');?>" ></i>
														</td> 				
														<td>
															<?php echo esc_attr_e(ucfirst(get_post_meta( $retrieved_data->ID, 'notice_for',true)),'school-mgt');?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Notice For','school-mgt');?>" ></i>
														</td>   
														<td>
															<?php 
															if(get_post_meta( $retrieved_data->ID, 'smgt_class_id',true) !="" && get_post_meta( $retrieved_data->ID, 'smgt_class_id',true) =="all")
															{
																esc_attr_e('All','school-mgt');
															}
															elseif(get_post_meta( $retrieved_data->ID, 'smgt_class_id',true) !=""){
															echo mj_smgt_get_class_name(get_post_meta( $retrieved_data->ID, 'smgt_class_id',true));}?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Class','school-mgt');?>" ></i>
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
																				<a href="#" class="float_left_width_100 view-notice" id="<?php echo $retrieved_data->ID;?>"><i class="fa fa-eye"> </i><?php esc_attr_e('View','school-mgt');?></a>
																			</li>
																			<?php 
																			if($user_access_edit == '1')
																			{ ?>
																				<li class="float_left_width_100 border_bottom_item">
																					<a href="?page=smgt_notice&tab=addnotice&action=edit&notice_id=<?php echo $retrieved_data->ID;?>" class="float_left_width_100"><i class="fa fa-edit"> </i><?php esc_attr_e('Edit','school-mgt');?></a> 
																				</li>
																				<?php 
																			} ?>
																			<?php 
																			if($user_access_delete =='1')
																			{ ?>
																				<li class="float_left_width_100">
																					<a href="?page=smgt_notice&tab=noticelist&action=delete&notice_id=<?php echo $retrieved_data->ID;?>" class="float_left_width_100" style="color: #fd726a !important;" onclick="return confirm('<?php esc_attr_e('Are you sure you want to delete this record?','school-mgt');?>');"><i class="fa fa-trash"></i> <?php esc_attr_e('Delete','school-mgt');?></a> 
																				</li>
																				<?php 
																			} ?>               
																		</ul>
																	</li>
																</ul>
															</div>	
														</td>
													</tr>
													<?php 
													$i++;
												} ?>
											</tbody>
										</table>
										<div class="print-button pull-left">
											<button class="btn btn-success btn-sms-color" type="button">
												<input type="checkbox" name="id[]" class="select_all" value="<?php echo esc_attr($retrieved_data->ID); ?>" style="margin-top: 0px;">
												<label for="checkbox" class="margin_right_5px"><?php esc_html_e( 'Select All', 'school-mgt' ) ;?></label>
											</button>
											<?php 
											if($user_access_delete =='1')
											{ ?>
												<button id="delete_selected" data-toggle="tooltip" title="<?php esc_html_e('Delete Selected','school-mgt');?>" name="delete_selected" class="delete_selected" ><img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png" ?>" alt=""></button>
												<?php 
											} ?>
										</div>
									</form>
								</div>
							</div><!-- panel-body -->
							<?php 
						}
						else
						{
							if($user_access_add=='1')
							{	
								?>
								<div class="no_data_list_div"> 
									<a href="<?php echo admin_url().'admin.php?page=smgt_notice&tab=addnotice';?>">
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
					}
					if($active_tab == 'addnotice')
					{
						require_once SMS_PLUGIN_DIR. '/admin/includes/notice/add-notice.php';
					} ?>
				</div><!-- smgt_main_listpage -->
	 		</div><!-- col-md-12 -->
	 	</div><!-- row -->
	</div><!-- main_list_margin_15px -->
</div><!-- page-inner -->
<?php ?>