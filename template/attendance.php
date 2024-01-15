<?php
mj_smgt_browser_javascript_check();
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
?>
<script type="text/javascript">
	jQuery(document).ready(function($)
	{
		"use strict";	
		$('#student_attendance').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});
		$('#curr_date_sub123').datepicker({maxDate:'0',dateFormat: "yy-mm-dd"});
		$('#subject_attendance').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});
		$('#curr_date_sub').datepicker({maxDate:'0',dateFormat: "yy-mm-dd"});
		$('#curr_date_teacher').datepicker({
			maxDate:'0',
			dateFormat: "yy-mm-dd",
			changeYear:true,
			changeMonth: true,
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
if($school_obj->role == 'parent' || $school_obj->role == 'student')
{
	echo "403 : Access Denied.";
	die;
}
$active_tab=isset($_REQUEST['tab'])?$_REQUEST['tab']:'daily_attendence';
$obj_attend=new Attendence_Manage();
$current_date = date("y-m-d");
$class_id =0;
$MailCon = get_option('absent_mail_notification');
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
//--------------- SAVE ATTENDANCE ---------------------//
if(isset($_REQUEST['save_attendence']))
{	 
    $nonce = $_POST['_wpnonce'];
	if ( ! wp_verify_nonce( $nonce, 'save_attendence_front_nonce' ) )
	{
		die( 'Failed security check' );
	}
	else
	{
		$class_id=$_POST['class_id'];
		$attend_by=get_current_user_id();	
		
		$exlude_id = mj_smgt_approve_student_list();
		$students = get_users(array('meta_key' => 'class_name', 'meta_value' => $class_id,'role'=>'student','exclude'=>$exlude_id));
		foreach($students as $stud)
		{
			if(isset($_POST['attendanace_'.$stud->ID]))
			{
				if(isset($_POST['smgt_sms_service_enable']))
				{
					$current_sms_service = get_option( 'smgt_sms_service');
					if($_POST['attendanace_'.$stud->ID] == 'Absent')
					{
						$parent_list = mj_smgt_get_student_parent_id($stud->ID);
						if(!empty($parent_list))
						{
							$parent_number =array();
							foreach ($parent_list as $user_id)
							{
								$parent_number[] = "+".mj_smgt_get_countery_phonecode(get_option( 'smgt_contry' )).get_user_meta($user_id, 'mobile_number',true);
							}						
							$message_content = "Your Child ".mj_smgt_get_user_name_byid($stud->ID)." is absent today.";
							if(is_plugin_active('sms-pack/sms-pack.php'))
							{				
								$args = array();
								$args['mobile']=$parent_number;
								$args['message']=$message_content;					
								$args['message_from']='attendanace';					
								$args['message_side']='front';					
							if($current_sms_service=='telerivet' || $current_sms_service ="MSG91" || $current_sms_service=='bulksmsnigeria' || $current_sms_service=='bulksmsgateway.in' || $current_sms_service=='textlocal.in' ||$current_sms_service=='nimbow' || $current_sms_service=='africastalking')
								{					
									$send = send_sms($args);					
								}
							}
							
							foreach ($parent_list as $user_id)
							{
								$parent = get_userdata($user_id);
								$reciever_number = "+".mj_smgt_get_countery_phonecode(get_option( 'smgt_contry' )).get_user_meta($user_id, 'mobile_number',true);				
								$message_content = "Your Child ".mj_smgt_get_user_name_byid($stud->ID)." is absent today.";
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

							$MailArr['{{child_name}}'] = mj_smgt_get_display_name($stud->ID);
							$Mail = mj_smgt_string_replacement($MailArr,$MailCon);
							$email = $parent->user_email;
							mj_smgt_send_mail($email,$Mail,$Mail);
						}
					}
				}
				$savedata = $obj_attend->mj_smgt_insert_student_attendance($_POST['curr_date'],$class_id,$stud->ID,$attend_by,$_POST['attendanace_'.$stud->ID],$_POST['attendanace_comment_'.$stud->ID]);
			}					
		}
		?>
		<div id="message" class="alert_msg alert alert-success alert-dismissible  margin_left_right_0"  role="alert">
			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></span>
			</button>
			<?php esc_attr_e('Attendance saved successfully.','school-mgt');?>
		</div>
		<?php 
	}
}
//------------------------ SAVE SUBJECT WISE ATTENDANCE ---------------------//
if(isset($_REQUEST['save_sub_attendence']))
{
	
	$nonce = $_POST['_wpnonce'];
	if ( ! wp_verify_nonce( $nonce, 'save_sub_attendence_front_nonce' ) )
	{
		die( 'Failed security check' );
	}
	else
	{
		$class_id=$_POST['class_id'];
		$parent_list = mj_smgt_get_user_notice('parent',$class_id);		
		$attend_by=get_current_user_id();
			
		$exlude_id = mj_smgt_approve_student_list();
		$students = get_users(array('meta_key' => 'class_name', 'meta_value' => $class_id,'role'=>'student','exclude'=>$exlude_id));
		foreach($students as $stud)
		{
			if(isset($_POST['attendanace_'.$stud->ID]))
			{
				if(isset($_POST['smgt_sms_service_enable']))
				{
					$current_sms_service = get_option( 'smgt_sms_service');
					if($_POST['attendanace_'.$stud->ID] == 'Absent')
					{
						$parent_list = mj_smgt_get_student_parent_id($stud->ID);
						if(!empty($parent_list))
						{
							foreach ($parent_list as $user_id)
							{
								foreach ($parent_list as $user_id)
								{
									$parent_number[] = "+".mj_smgt_get_countery_phonecode(get_option( 'smgt_contry' )).get_user_meta($user_id, 'mobile_number',true);
								}
								$parent = get_userdata($user_id);
								$reciever_number = "+".mj_smgt_get_countery_phonecode(get_option( 'smgt_contry' )).get_user_meta($user_id, 'mobile_number',true);								
								$message_content = "Your Child ".mj_smgt_get_user_name_byid($stud->ID)." is absent today.";
								
								if(is_plugin_active('sms-pack/sms-pack.php'))
								{				
									$args = array();
									$args['mobile']=$parent_number;
									$args['message']=$message_content;					
									$args['message_from']='attendanace';					
									$args['message_side']='front';					
									if($current_sms_service=='telerivet' || $current_sms_service ="MSG91" || $current_sms_service=='bulksmsnigeria' || $current_sms_service=='bulksmsgateway.in' || $current_sms_service=='textlocal.in' ||$current_sms_service=='nimbow' || $current_sms_service=='africastalking')
									{					
										$send = send_sms($args);					
									}
								}
								
								if($current_sms_service == 'clickatell')
								{									
									$clickatell=get_option('smgt_clickatell_sms_service');
									$to = $reciever_number;
									$message = str_replace(" ","%20",$message_content);
									$username = $clickatell['username']; //clickatell username.
									$password = $clickatell['password']; // clickatell password.
									$api_key = $clickatell['api_key'];//clickatell apikey.
									$baseurl ="http://api.clickatell.com";
											
									// auth call.
									$url = "$baseurl/http/auth?user=$username&password=$password&api_id=$api_key";
											
									// do auth call.
									$ret = file($url);
											
									// explode our response. return string is on first line of the data returned.
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
							$MailArr['{{child_name}}'] = mj_smgt_get_display_name($stud->ID);
							$Mail = mj_smgt_string_replacement($MailArr,$MailCon);								
							mj_smgt_send_mail($parent->user_email,$Mail,$Mail);
						}
					}
				}
				$savedata = $obj_attend->mj_smgt_insert_subject_wise_attendance($_POST['curr_date'],$class_id,$stud->ID,$attend_by,$_POST['attendanace_'.$stud->ID],$_POST['sub_id'],$_POST['attendanace_comment_'.$stud->ID]);
			}					
		}
	}
	?>
	
	<div id="message" class="alert_msg alert alert-success alert-dismissible  margin_left_right_0"  role="alert">
		<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></span>
		</button>
		<?php esc_attr_e('Attendance saved successfully.','school-mgt');?>
	</div>
	<?php 
}
if(isset($_REQUEST['save_teach_attendence']))
{
	$attend_by=get_current_user_id();
	$teacher = get_users(array('role' => 'teacher'));
	foreach($teacher as $stud)
	{
		if(isset($_POST['attendanace_'.$stud->ID]))
		{
			$savedata = $obj_attend->mj_smgt_insert_teacher_attendance($_POST['tcurr_date'],$stud->ID,$attend_by,$_POST['attendanace_'.$stud->ID],$_POST['attendanace_comment_'.$stud->ID]);
		}
	}
	wp_redirect ( home_url().'?dashboard=user&page=attendance&tab=teacher_attendence&message=1');
}
?>
<div class="panel-body panel-white attendance_list frontend_list_margin_30px_res"><!-------------- PENAL BODY ----------------->
		<?php
		$message = isset($_REQUEST['message'])?$_REQUEST['message']:'0';
		switch($message)
		{
			case '1':
				$message_string = esc_attr__('Teacher Attendance successfully saved!','school-mgt');
				break;
		}
	
		if($message)
		{ ?>
			<div id="message" class="alert_msg alert alert-success alert-dismissible  margin_left_right_0"  role="alert">
				<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></span>
				</button>
				<?php echo $message_string; ?>
			</div>
			<?php 
		} ?>
	<!--------------- TABING START ------------------->
	<ul class="nav nav-tabs panel_tabs margin_left_1per mb-4" role="tablist">
		<li class="<?php if($active_tab=='daily_attendence'){?>active<?php }?>">
			<a href="?dashboard=user&page=attendance&tab=daily_attendence" class="padding_left_0 tab <?php echo $active_tab == 'daily_attendence' ? 'nav-tab-active' : ''; ?>">
			<?php echo esc_attr__('Attendance', 'school-mgt'); ?></a>
		</li>
		<?php
		if($school_obj->role == 'supportstaff')
		{
			?>
			<li class="<?php if($active_tab=='teacher_attendence'){?>active<?php }?>">
				<a href="?dashboard=user&page=attendance&tab=teacher_attendence" class="padding_left_0 tab <?php echo $active_tab == 'teacher_attendence' ? 'nav-tab-active' : ''; ?>">
				<?php echo esc_attr__('Teacher Attendance', 'school-mgt'); ?></a>
			</li>
			<?php
		}
		?>
		
		<li class="<?php if($active_tab=='sub_attendence'){?>active<?php }?>">	
			<a href="?dashboard=user&page=attendance&tab=sub_attendence" class="padding_left_0 tab <?php echo $active_tab == 'sub_attendence' ? 'nav-tab-active' : ''; ?>">
			<?php echo esc_attr__('Subject Wise Attendance', 'school-mgt'); ?></a>
		</li>
	</ul>
	<!--------------- TABING END ------------------->
	<?php if($active_tab == 'daily_attendence')
	{ 
		?>
		<div class="panel-body"><!------------ PENAL BODY ------------->
			<!-------------- STUDENT ATTENDENCE FORM -------------------->
			<form method="post" id="student_attendance">  
				<input type="hidden" name="class_id" value="<?php echo $class_id;?>" />  
				<div class="form-body user_form">
					<div class="row">
						<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
							<div class="form-group input">
								<div class="col-md-12 form-control">
									<input id="curr_date_sub123" class="form-control" type="text" value="<?php if(isset($_POST['curr_date'])) echo mj_smgt_getdate_in_input_box($_POST['curr_date']); else echo  date("Y-m-d");?>" name="curr_date" readonly>
									<label class="control-label" for="curr_date"><?php esc_attr_e('Date','school-mgt');?></label>
								</div>
							</div>
						</div>
						<div class="col-md-3 mb-3 input">
							<label class="ml-1 custom-top-label top" for="class_id"><?php esc_attr_e('Select Class','school-mgt');?><span class="require-field">*</span></label>			
							<?php if(isset($_REQUEST['class_id'])) $class_id=$_REQUEST['class_id']; ?>
							<select name="class_id"  id="class_list"  class="line_height_30px form-control validate[required]">
								<option value=" "><?php esc_attr_e('Select class','school-mgt');?></option>
								<?php
								foreach(mj_smgt_get_allclass() as $classdata)
								{
									?>
									<option  value="<?php echo $classdata['class_id'];?>" <?php selected($classdata['class_id'],$class_id)?>><?php echo $classdata['class_name'];?></option>
									<?php 
								}?>
							</select>			
						</div>
						<div class="col-md-3 mb-3 input">
							<label class="ml-1 custom-top-label top" for="class_id"><?php esc_attr_e('Select Class Section','school-mgt');?></label>			
							<?php
							$class_section="";
							if(isset($_REQUEST['class_section'])) $class_section=$_REQUEST['class_section']; ?>
							<select name="class_section" class="line_height_30px form-control" id="class_section">
									<option value=""><?php esc_attr_e('Select Section','school-mgt');?></option>
								<?php if(isset($_REQUEST['class_section'])){
										$class_section=$_REQUEST['class_section'];
										foreach(mj_smgt_get_class_sections($_REQUEST['class_id']) as $sectiondata)
										{  ?>
										<option value="<?php echo $sectiondata->id;?>" <?php selected($class_section,$sectiondata->id);  ?>><?php echo $sectiondata->section_name;?></option>
									<?php }
									} ?>
							</select>
						</div>
						<div class="col-md-3 mb-3">
							<input type="submit" value="<?php esc_attr_e('Take/View  Attendance','school-mgt');?>" name="attendence" class="btn btn-success save_btn"/>
						</div>
					</div>
				</div>
			</form><!-------------- STUDENT ATTENDENCE FORM -------------------->
			<div class="clearfix"></div>
			<?php 
			if(isset($_REQUEST['attendence']) || isset($_REQUEST['save_attendence']))
			{
				$class_id=$_REQUEST['class_id'];
				$user=count(get_users(array(
					'meta_key' => 'class_name',
					'meta_value' => $class_id
				)));
				$attendanace_date=$_REQUEST['curr_date'];
				$holiday_dates=mj_smgt_get_all_date_of_holidays();
				if (in_array($attendanace_date, $holiday_dates))
				{
					?>
					<div id="message" class=" alert alert-warning alert-dismissible alert_attendence" role="alert">
						<button type="button" class="btn-default notice-dismiss " data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></span>
						</button>
						<?php esc_attr_e('This day is holiday you are not able to take attendance','school-mgt');?>
					</div>
				<?php 
				}
				elseif(0 < $user)
				{
					if(isset($_REQUEST['class_id']) && $_REQUEST['class_id'] != " ")
					$class_id =$_REQUEST['class_id'];
					else 
						$class_id = 0;
					if($class_id == 0)
					{
						?>
						<div class="panel-heading">
							<h4 class="panel-title"><?php esc_attr_e('Please Select Class','school-mgt');?></h4>
						</div>
						<?php 
					}
					else
					{               
						if(isset($_REQUEST['class_section']) && $_REQUEST['class_section'] != "")
						{
							$exlude_id = mj_smgt_approve_student_list();
							$student = get_users(array('meta_key' => 'class_section', 'meta_value' =>$_REQUEST['class_section'],
									'meta_query'=> array(array('key' => 'class_name','value' => $class_id,'compare' => '=')),'role'=>'student','exclude'=>$exlude_id));	
							sort($student);
						}
						else
						{ 
							$exlude_id = mj_smgt_approve_student_list();
							$student = get_users(array('meta_key' => 'class_name', 'meta_value' => $class_id,'role'=>'student','exclude'=>$exlude_id));
							sort($student);
						}
						?>              
					
						<form method="post" class="form-horizontal">        
							<input type="hidden" name="class_id" value="<?php echo $class_id;?>" />
							<input type="hidden" name="class_section" value="<?php echo $_REQUEST['class_section'];?>" />
							<input type="hidden" name="curr_date" value="<?php if(isset($_POST['curr_date'])) echo mj_smgt_getdate_in_input_box($_POST['curr_date']); else echo  date("Y-m-d");?>" />
							<div class="panel-heading">
								<h4 class="panel-title"> <?php esc_attr_e('Class','school-mgt')?> : <?php echo mj_smgt_get_class_name($class_id);?> , 
								<?php esc_attr_e('Date','school-mgt')?> : <?php echo mj_smgt_getdate_in_input_box($_POST['curr_date']);?></h4>
							</div>
							<div class="col-md-12">
								<div class="table-responsive">
									<table class="table">
										<tr>
											<th class="multiple_subject_mark"><?php esc_attr_e('Sr. No.','school-mgt');?></th>
											<th class="multiple_subject_mark"><?php esc_attr_e('Roll No.','school-mgt');?></th>
											<th class="multiple_subject_mark"><?php esc_attr_e('Student','school-mgt');?></th>
											<th class="multiple_subject_mark"><?php esc_attr_e('Attendance','school-mgt');?></th>
											<th class="multiple_subject_mark"><?php esc_attr_e('Comment','school-mgt');?></th>
										</tr>
										<?php
										$date = $_POST['curr_date'];
										$i = 1;

										foreach ( $student as $user )
										{
											$date = $_POST['curr_date'];
											$check_attendance = $obj_attend->mj_smgt_check_attendence($user->ID,$class_id,$date);
											$attendanc_status = "Present";
											if(!empty($check_attendance))
											{
												$attendanc_status = $check_attendance->status;						
											}
											echo '<tr>';				  
											echo '<td>'.$i.'</td>';
											echo '<td><span>' .get_user_meta($user->ID, 'roll_id',true). '</span></td>';
											echo '<td><span>' .$user->first_name.' '.$user->last_name. '</span></td>';					
										?>
										<td>
											<label class="radio-inline"><input type="radio" name = "attendanace_<?php echo $user->ID?>" value ="Present" <?php checked( $attendanc_status, 'Present' );?>>
											<?php esc_attr_e('Present','school-mgt');?></label>
											<label class="radio-inline"> <input type="radio" name = "attendanace_<?php echo $user->ID?>" value ="Absent" <?php checked( $attendanc_status, 'Absent' );?>>
											<?php esc_attr_e('Absent','school-mgt');?></label>
											<label class="radio-inline"><input type="radio" name = "attendanace_<?php echo $user->ID?>" value ="Late" <?php checked( $attendanc_status, 'Late' );?>>
											<?php esc_attr_e('Late','school-mgt');?></label>
											<label class="radio-inline"><input type="radio" name = "attendanace_<?php echo $user->ID?>" value ="Half Day" <?php checked( $attendanc_status, 'Half Day' );?>>
											<?php esc_attr_e('Half Day','school-mgt');?></label>
										</td>
										<td class="padding_left_right_0">
											<div class="form-group input margin_bottom_0px">
												<div class="col-md-12 form-control">
													<input type="text" name="attendanace_comment_<?php echo $user->ID?>" class="form-control" value="<?php if(!empty($check_attendance)) echo $check_attendance->comment;?>">
												</div>
											</div>
										</td>
										<?php 
										echo '</tr>';
										$i++; } ?>                   
									</table>
								</div>
								<div class="form-group row mb-3">
									<label class="col-sm-4 control-label col-form-label" for="enable"><?php esc_attr_e('If student absent then Send  SMS to his/her parents','school-mgt');?></label>
									<div class="col-sm-2 pt-2 ps-0">
										<div class="checkbox">
											<label>
												<input id="chk_sms_sent1" type="checkbox" <?php $smgt_sms_service_enable = 0;if($smgt_sms_service_enable) echo "checked";?> value="1" name="smgt_sms_service_enable">
											</label>
										</div>				 
									</div>
								</div>
							</div>
							<?php wp_nonce_field( 'save_attendence_front_nonce' ); ?>
							<?php 
							if($user_access['add'] == 1 OR $user_access['edit'] == 1)
							{
								?>
								<div class="col-sm-6 rtl_res_att_save"> 
									<input type="submit" value="<?php esc_attr_e('Save  Attendance','school-mgt');?>" name="save_attendence" class="save_btn btn btn-success" />
								</div>   
								<?php 
							} ?>	
						</form>		
						<?php 
					}  
				} 
				else
				{
					?>
					<div class="smgt_no_attence_css">
						<h4 style=" font-size: 24px;font-weight: 500;"><?php esc_html_e("No Any Student In This Class" , "school-mgt"); ?></h4>
					</div>
					<?php
				}
			} ?>
		</div><!------------ PENAL BODY ------------->
		<?php 
	}
	if($active_tab == 'sub_attendence')
	{ 
		?>		
		<div class="panel-body"><!-------------- PENAL BODY --------------->
			<!---------------- SUBJECT WISE ATTENDANCE FORM -------------->
			<form method="post" id="subject_attendance">  
				<input type="hidden" name="class_id" value="<?php echo $class_id;?>" />
				<div class="form-body user_form">
					<div class="row">
						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
							<div class="form-group input">
								<div class="col-md-12 form-control">
									<input id="curr_date_sub" class="form-control" type="text" value="<?php if(isset($_POST['curr_date'])) echo mj_smgt_getdate_in_input_box($_POST['curr_date']); else echo  date("Y-m-d");?>" name="curr_date" readonly>
									<label class="" for="curr_date"><?php esc_attr_e('Date','school-mgt');?></label>	
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 input">
							<label class="ml-1 custom-top-label top" for="class_id"><?php esc_attr_e('Select Class','school-mgt');?><span class="require-field">*</span></label>			
							<?php if(isset($_REQUEST['class_id'])) $class_id=$_REQUEST['class_id']; ?>
							<select name="class_id"  id="class_list"  class="line_height_30px form-control validate[required]">
								<option value=" "><?php esc_attr_e('Select class Name','school-mgt');?></option>
								<?php
								foreach(mj_smgt_get_allclass() as $classdata)
								{ ?>
									<option  value="<?php echo $classdata['class_id'];?>" <?php selected($classdata['class_id'],$class_id)?>><?php echo $classdata['class_name'];?></option>
									<?php 
								}?>
							</select>			
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 input">
							<label class="ml-1 custom-top-label top" for="class_id"><?php esc_attr_e('Select Section','school-mgt');?></label>			
							<?php 
							$class_section="";
							if(isset($_REQUEST['class_section'])) $class_section=$_REQUEST['class_section']; ?>
							<select name="class_section" class="line_height_30px form-control" id="class_section">
							<option value=""><?php esc_attr_e('Select Class Section','school-mgt');?></option>
								<?php if(isset($_REQUEST['class_section'])){
								$class_section=$_REQUEST['class_section']; 
									foreach(mj_smgt_get_class_sections($_REQUEST['class_id']) as $sectiondata)
									{  ?>
										<option value="<?php echo $sectiondata->id;?>" <?php selected($class_section,$sectiondata->id);  ?>><?php echo $sectiondata->section_name;?></option>
									<?php } 
									} ?>		
							</select>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 input">
							<label class="ml-1 custom-top-label top" for="class_id"><?php esc_attr_e('Select Subject','school-mgt');?><span class="require-field">*</span></label>
							<select name="sub_id"  id="subject_list"  class="line_height_30px form-control validate[required]">
								<option value=" "><?php esc_attr_e('Select Subject','school-mgt');?></option>
								<?php $sub_id=0;
								if(isset($_POST['sub_id']))
								{
									$sub_id=$_POST['sub_id'];
									?>
									<?php $allsubjects = mj_smgt_get_subject_by_classid($_POST['class_id']);
									foreach($allsubjects as $subjectdata)
									{ ?>
										<option value="<?php echo $subjectdata->subid;?>" <?php selected($subjectdata->subid,$sub_id); ?>><?php echo $subjectdata->sub_name;?></option>
										<?php
									}
								} ?>
							</select>			
						</div>
					</div>
				</div>
				<div class="form-body user_form">
					<div class="row">		
						<div class="col-md-6">
							<input type="submit" value="<?php esc_attr_e('Take/View  Attendance','school-mgt');?>" name="attendence"  class="btn btn-success save_btn"/>
						</div>
					</div>
				</div>  
			</form><!---------------- SUBJECT WISE ATTENDANCE FORM -------------->
		</div><!-------------- PENAL BODY --------------->
		<div class="clearfix"> </div>
		<?php 
		if(isset($_REQUEST['attendence']) || isset($_REQUEST['save_sub_attendence']))
		{
			$attendanace_date=$_REQUEST['curr_date'];
			$holiday_dates=mj_smgt_get_all_date_of_holidays();
			if (in_array($attendanace_date, $holiday_dates))
			{
				?>
					<div id="message" class=" alert alert-warning alert-dismissible alert_attendence" role="alert">
						<button type="button" class="btn-default notice-dismiss " data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></span>
						</button>
						<?php esc_attr_e('This day is holiday you are not able to take attendance','school-mgt');?>
					</div>
			<?php 
			}
			else
			{
				if(isset($_REQUEST['class_id']) && $_REQUEST['class_id'] != " ")
					$class_id =$_REQUEST['class_id'];
				else 
					$class_id = 0;
				if($class_id == 0)
				{
				?>
					<div class="panel-heading">
						<h4 class="panel-title"><?php esc_attr_e('Please Select Class','school-mgt');?></h4>
					</div>
			<?php  
				}
				else
				{                
					if(isset($_REQUEST['class_section']) && $_REQUEST['class_section'] != "")
					{						
						$exlude_id = mj_smgt_approve_student_list();
						$student = get_users(array('meta_key' => 'class_section', 'meta_value' =>$_REQUEST['class_section'],
						'meta_query'=> array(array('key' => 'class_name','value' => $class_id,'compare' => '=')),'role'=>'student','exclude'=>$exlude_id));
						sort($student);					
					}
					else
					{ 
						$exlude_id = mj_smgt_approve_student_list();
						$student = get_users(array('meta_key' => 'class_name', 'meta_value' => $class_id,'role'=>'student','exclude'=>$exlude_id));
						sort($student);		
					} 
				?>
					<div class="panel-body">  
						<form method="post"  class="form-horizontal mt-4 mt-4">
							<input type="hidden" name="class_id" value="<?php echo $class_id;?>" />
							<input type="hidden" name="sub_id" value="<?php echo $sub_id;?>" />
							<input type="hidden" name="class_section" value="<?php echo $_REQUEST['class_section'];?>" />
							<input type="hidden" name="curr_date" value="<?php if(isset($_POST['curr_date'])) echo mj_smgt_getdate_in_input_box($_POST['curr_date']); else echo  date("Y-m-d");?>" />
					
							<div class="panel-heading">
								<h4 class="panel-title"> <?php esc_attr_e('Class','school-mgt')?> : <?php echo mj_smgt_get_class_name($class_id);?> , 
								<?php esc_attr_e('Date','school-mgt')?> : <?php echo mj_smgt_getdate_in_input_box($_POST['curr_date']);?>,<?php esc_attr_e('Subject','school-mgt')?> : <?php echo mj_smgt_get_subject_byid($_POST['sub_id']); ?></h4>
							</div>
					
							<div class="col-md-12">
								<div class="table-responsive">
									<table class="table">
										<tr>
											<th class="multiple_subject_mark"><?php esc_attr_e('Sr. No.','school-mgt');?></th>
											<th class="multiple_subject_mark"><?php esc_attr_e('Roll No.','school-mgt');?></th>
											<th class="multiple_subject_mark"><?php esc_attr_e('Student Name','school-mgt');?></th>
											<th class="multiple_subject_mark"><?php esc_attr_e('Attendance','school-mgt');?></th>
											<th class="multiple_subject_mark"><?php esc_attr_e('Comment','school-mgt');?></th>
										</tr>
										<?php
										$date = $_POST['curr_date'];
										$i = 1;
										foreach ( $student as $user ) 
										{
											$date = $_POST['curr_date'];                   
											$check_attendance = $obj_attend->mj_smgt_check_sub_attendence($user->ID,$class_id,$date,$_POST['sub_id']);
											$attendanc_status = "Present";
											if(!empty($check_attendance))
											{
												$attendanc_status = $check_attendance->status;
												
											}                   
											echo '<tr>';              
											echo '<td>'.$i.'</td>';
											echo '<td><span>' .get_user_meta($user->ID, 'roll_id',true). '</span></td>';
											echo '<td><span>' .$user->first_name.' '.$user->last_name. '</span></td>';
											?>
											<td>
												<label class="radio-inline"><input type="radio" name = "attendanace_<?php echo $user->ID?>" value ="Present" <?php checked( $attendanc_status, 'Present' );?>>
												<?php esc_attr_e('Present','school-mgt');?></label>
												<label class="radio-inline"> <input type="radio" name = "attendanace_<?php echo $user->ID?>" value ="Absent" <?php checked( $attendanc_status, 'Absent' );?>>
												<?php esc_attr_e('Absent','school-mgt');?></label>
												<label class="radio-inline"><input type="radio" name = "attendanace_<?php echo $user->ID?>" value ="Late" <?php checked( $attendanc_status, 'Late' );?>>
												<?php esc_attr_e('Late','school-mgt');?></label>
												<label class="radio-inline"><input type="radio" name = "attendanace_<?php echo $user->ID?>" value ="Half Day" <?php checked( $attendanc_status, 'Half Day' );?>>
												<?php esc_attr_e('Half Day','school-mgt');?></label>
											</td>
											<td class="padding_left_right_0">
												<div class="form-group input margin_bottom_0px">
													<div class="col-md-12 form-control"> 
														<input type="text" name="attendanace_comment_<?php echo $user->ID?>" class="form-control " value="<?php if(!empty($check_attendance)) echo $check_attendance->comment;?>">
													</div>
												</div>
											</td>
											<?php 
											echo '</tr>';
											$i++; } ?>
									</table>
								</div>
							<?php wp_nonce_field( 'save_sub_attendence_front_nonce' ); ?>
							<div class="form-group row mb-3">
								<label class="col-sm-4 control-label col-form-label" for="enable"><?php esc_attr_e('If student absent then Send  SMS to his/her parents','school-mgt');?></label>
								<div class="col-sm-2 pt-2 ps-0">
									<div class="checkbox">
										<label>
											<input id="chk_sms_sent1" type="checkbox" <?php $smgt_sms_service_enable = 0;if($smgt_sms_service_enable) echo "checked";?> value="1" name="smgt_sms_service_enable">
										</label>
									</div>				 
								</div>
							</div>
							</div>
							<?php 
							if($user_access['add'] == 1 OR $user_access['edit'] == 1)
							{
								?>
								<div class="form-body user_form">
									<div class="row">
										<div class="col-sm-6 rtl_res_att_save"> 
											<input type="submit" value="<?php esc_attr_e("Save  Attendance","school-mgt");?>" name="save_sub_attendence" class="btn btn-success save_btn" />
										</div>  
									</div>
								</div>
								<?php 
							} ?>						
						</form>
					</div>
			<?php 
				}
			}
		}
	} 
	if($active_tab == 'teacher_attendence')
	{
		?>
		<form method="post" id="teacher_attendance">           
			<div class="form-body user_form">
				<div class="row">
					<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
						<div class="form-group input">
							<div class="col-md-12 form-control">
								<input id="curr_date_teacher" class="form-control" type="text" value="<?php if(isset($_POST['tcurr_date'])) echo $_POST['tcurr_date']; else echo  date("Y-m-d");?>" name="tcurr_date" readonly>	
								<label class="" for="curr_date"><?php esc_attr_e('Date','school-mgt');?></label>	
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<!-- <label for="subject_id">&nbsp;</label> -->
						<input type="submit" value="<?php esc_attr_e('Take/View  Attendance','school-mgt');?>" name="teacher_attendence"  class="save_btn"/>
					</div>
				</div>
			</div>
		</form>
		<?php
	}
	//------------------------ SAVE TEACHER ATTENDENCE ----------------------//
	if(isset($_REQUEST['teacher_attendence']) || isset($_REQUEST['save_teach_attendence']))
	{	
		$attendanace_date=$_REQUEST['tcurr_date'];
		$holiday_dates=mj_smgt_get_all_date_of_holidays();
		if (in_array($attendanace_date, $holiday_dates))
		{
			?>
			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible">
				<p><?php esc_attr_e('This day is holiday you are not able to take attendance','school-mgt');?></p>
				<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span class="screen-reader-text">Dismiss this notice.</span></button>
			</div>
			<?php 
		}
		else
		{
			?>
			<div class="panel-body"> <!-- panel-body -->
				<form method="post">        
					<input type="hidden" name="class_id" value="<?php echo $class_id;?>" />
					<input type="hidden" name="tcurr_date" value="<?php echo $_POST['tcurr_date'];?>" />
					<div class="panel-heading">
						<h4 class="panel-title"><?php esc_attr_e('Teacher Attendance','school-mgt');?> , 
						<?php esc_attr_e('Date','school-mgt')?> : <?php echo $_POST['tcurr_date'];?></h4>
					</div>
					<div class="col-md-12 padding_payment smgt_att_tbl_list">
						<div class="table-responsive">
							<table class="table">
								<tr>
									<th><?php esc_attr_e('Srno','school-mgt');?></th>
									<th><?php esc_attr_e('Teacher','school-mgt');?></th>
									<th><?php esc_attr_e('Attendance','school-mgt');?></th>
									<th><?php esc_attr_e('Comment','school-mgt');?></th>
								</tr>
								<?php 
								$date = $_POST['tcurr_date'];
								$i=1;
								$teacher = get_users(array('role'=>'teacher'));
								foreach ($teacher as $user)
								{
									$class_id=0;
									$check_attendance = $obj_attend->mj_smgt_check_attendence($user->ID,$class_id,$date);
									
									$attendanc_status = "Present";
									if(!empty($check_attendance))
									{
										$attendanc_status = $check_attendance->status;
										
									}
									echo '<tr>';  
									echo '<tr>';
								
									echo '<td>'.$i.'</td>';
									echo '<td><span>' .$user->first_name.' '.$user->last_name. '</span></td>';
									?>
									<td>
										<label class="radio-inline"><input type="radio" name = "attendanace_<?php echo $user->ID?>" value ="Present" <?php checked( $attendanc_status, 'Present' );?>>
										<?php esc_attr_e('Present','school-mgt');?></label>
										<label class="radio-inline"> <input type="radio" name = "attendanace_<?php echo $user->ID?>" value ="Absent" <?php checked( $attendanc_status, 'Absent' );?>>
										<?php esc_attr_e('Absent','school-mgt');?></label>
										<label class="radio-inline"><input type="radio" name = "attendanace_<?php echo $user->ID?>" value ="Late" <?php checked( $attendanc_status, 'Late' );?>>
										<?php esc_attr_e('Late','school-mgt');?></label>
										<label class="radio-inline"><input type="radio" name = "attendanace_<?php echo $user->ID?>" value ="Half Day" <?php checked( $attendanc_status, 'Half Day' );?>>
										<?php esc_attr_e('Half Day','school-mgt');?></label>
									</td>

									<td class="">
										<div class="form-group input margin_bottom_0px">
											<div class="col-md-12 form-control">
												<input type="text" name="attendanace_comment_<?php echo $user->ID?>" class="form-control" value="<?php if(!empty($check_attendance)) echo $check_attendance->comment;?>">
											</div>
										</div>
									</td>

									
									<?php 
									
									echo '</tr>';
									$i++;
								}
								?>   
							</table>
						</div>
					</div>		
					<div class="cleatrfix"></div>
					<div class="col-sm-12 padding_top_10px rtl_res_att_save">    
						<input type="submit" value="<?php esc_attr_e("Save  Attendance","school-mgt");?>" name="save_teach_attendence" id="res_rtl_width_100" class="col-sm-12 save_att_btn" />
					</div>       
				</form>
			</div><!-- panel-body -->
			<?php
		}
	}
	?>
</div> <!-------------- PENAL BODY ----------------->