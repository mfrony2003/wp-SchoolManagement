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
	$user_access=mj_smgt_get_userrole_wise_filter_access_right_array('notification');
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
			if ('notification' == $user_access['page_link'] && ($_REQUEST['action']=='edit'))
			{
				if($user_access_edit=='0')
				{	
					mj_smgt_access_right_page_not_access_message_admin_side();
					die;
				}			
			}
			if ('notification' == $user_access['page_link'] && ($_REQUEST['action']=='delete'))
			{
				if($user_access_delete=='0')
				{	
					mj_smgt_access_right_page_not_access_message_admin_side();
					die;
				}	
			}
			if ('notification' == $user_access['page_link'] && ($_REQUEST['action']=='insert'))
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
	$('#notification_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});
});
</script>
<?php 
if(isset($_POST['save_notification']))
{
	$nonce = $_POST['_wpnonce'];
	if ( wp_verify_nonce( $nonce, 'save_notice_admin_nonce' ) )
	{
		global $wpdb;
		$smgt_notification = $wpdb->prefix. 'smgt_notification';
		$exlude_id = mj_smgt_approve_student_list();
		if(isset($_POST['selected_users']) && $_POST['selected_users'] != 'All')
		{
			$token = get_user_meta($_POST['selected_users'],'token_id',true);
			$title = mj_smgt_popup_category_validation(stripslashes($_POST['title']));
			$text = mj_smgt_address_description_validation(stripslashes($_POST['message_body']));
			$bicon = get_user_meta($_POST['selected_users'],'bicon',true);
			$new_bicon = (int)$bicon + 1;
			$badge = $new_bicon;
			$a = array('registration_ids'=>array($token),'notification'=>array('title'=>$title,'text'=>$text,'badge'=>$badge));
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
			
			
			update_user_meta($_POST['selected_users'],'bicon',$new_bicon);
			
			$data['student_id'] = $_POST['selected_users'];
			$data['title'] = mj_smgt_popup_category_validation(stripslashes($_POST['title']));
			$data['message'] = mj_smgt_address_description_validation(stripslashes($_POST['message_body']));
			$data['created_date'] = date('Y-m-d');
			$data['created_by'] = get_current_user_id();
			$result=$wpdb->insert( $smgt_notification,$data );
		}
		elseif(isset($_POST['class_id']) && $_POST['class_id'] == 'All')
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
								$title = mj_smgt_popup_category_validation(stripslashes($_POST['title']));
								$text = mj_smgt_address_description_validation(stripslashes($_POST['message_body']));
								$bicon = get_user_meta($retrive_data->ID,'bicon',true);
								if(!empty($bicon))
								{
									$new_bicon = $bicon + 1;
								}
								else
								{
									$new_bicon = 1;
								}
							
								$badge = $new_bicon;
								$a = array('registration_ids'=>array($token),'notification'=>array('title'=>$title,'text'=>$text,'badge'=>$badge));
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
								
								$data['student_id'] = $retrive_data->ID;
								$data['title'] = mj_smgt_popup_category_validation(stripslashes($_POST['title']));
								$data['message'] = mj_smgt_address_description_validation(stripslashes($_POST['message_body']));
								$data['created_date'] = date('Y-m-d');
								$data['created_by'] = get_current_user_id();
								$result=$wpdb->insert( $smgt_notification,$data );
							}
						}
						
					//}
				//}
				
			}
		}
		elseif(isset($_POST['class_section']) && $_POST['class_section'] == 'All')
		{
			$query_data['exclude']=$exlude_id;
			$query_data['meta_query'] = array(array('key' => 'class_name','value' => $_POST['class_id'],'compare' => '=') );
			$results = get_users($query_data);
			
			if(!empty($results))
			{
				foreach($results as $retrive_data)
				{
					$token = get_user_meta($retrive_data->ID,'token_id',true);
					$title = mj_smgt_popup_category_validation(stripslashes($_POST['title']));
					$text = mj_smgt_address_description_validation(stripslashes($_POST['message_body']));
					$bicon = get_user_meta($retrive_data->ID,'bicon',true);
					$new_bicon = $bicon + 1;
					$badge = $new_bicon;
					$a = array('registration_ids'=>array($token),'notification'=>array('title'=>$title,'text'=>$text,'badge'=>$badge));
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
					
					$data['student_id'] = $retrive_data->ID;
					$data['title'] = mj_smgt_popup_category_validation(stripslashes($_POST['title']));
					$data['message'] = mj_smgt_address_description_validation(stripslashes($_POST['message_body']));
					$data['created_date'] = date('Y-m-d');
					$data['created_by'] = get_current_user_id();
					$result=$wpdb->insert( $smgt_notification,$data );
				}
			}
		}
		else
		{
			$query_data['exclude']=$exlude_id;
			$query_data['meta_key'] = 'class_section';
			$query_data['meta_value'] = $_POST['class_section'];
			$query_data['meta_query'] = array(array('key' => 'class_name','value' => $_POST['class_id'],'compare' => '=') );
			$results = get_users($query_data);
			if(!empty($results))
			{
				foreach($results as $retrive_data)
				{
					$token = get_user_meta($retrive_data->ID,'token_id',true);
					$title = mj_smgt_popup_category_validation(stripslashes($_POST['title']));
					$text = mj_smgt_address_description_validation(stripslashes($_POST['message_body']));
					$bicon = get_user_meta($retrive_data->ID,'bicon',true);
					$new_bicon = $bicon + 1;
					$badge = $new_bicon;
					$a = array('registration_ids'=>array($token),'notification'=>array('title'=>$title,'text'=>$text,'badge'=>$badge));
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
					
					$data['student_id'] = $retrive_data->ID;
					$data['title'] = mj_smgt_popup_category_validation(stripslashes($_POST['title']));
					$data['message'] = mj_smgt_address_description_validation(stripslashes($_POST['message_body']));
					$data['created_date'] = date('Y-m-d');
					$data['created_by'] = get_current_user_id();
					$result=$wpdb->insert( $smgt_notification,$data );
				}
			}
		}
		if($result)
		{
		  wp_redirect ( admin_url().'admin.php?page=smgt_notification&tab=notificationlist&message=1');
		
		}
    }
}	
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')
{
	$result=mj_smgt_delete_notification($_REQUEST['notification_id']);
	if($result)
	{
		wp_redirect ( admin_url().'admin.php?page=smgt_notification&tab=notificationlist&message=2');
	}
}

//----------- Add Multiple Delete record ----------//
if(isset($_REQUEST['delete_selected']))
{
	if(!empty($_REQUEST['id']))
	{
		foreach($_REQUEST['id'] as $id)
		{
			$result=mj_smgt_delete_notification($id);
			wp_redirect ( admin_url().'admin.php?page=smgt_notification&tab=notificationlist&message=2');
		}
	}
	if($result)
	{
		wp_redirect ( admin_url().'admin.php?page=smgt_notification&tab=notificationlist&message=2');
	}
}

$active_tab = isset($_GET['tab'])?$_GET['tab']:'notificationlist';
	
?>
<div class="page-inner"><!-- page-inner -->
	<div class="main_list_margin_15px"><!-- main_list_margin_15px -->
		<?php
		$message = isset($_REQUEST['message'])?$_REQUEST['message']:'0';
		switch($message)
		{
			case '1':
				$message_string = esc_attr__('Notification Inserted Successfully.','school-mgt');
				break;
			case '2':
				$message_string = esc_attr__('Notification Deleted Successfully.','school-mgt');
				break;	
			case '3':
				$message_string = esc_attr__('','school-mgt');
				break;
		}
		 ?>
		<div class="row"><!-- Row -->
		<?php
		if($message)
		{ ?>
			<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible">
				<p><?php echo $message_string;?></p>
				<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span class="screen-reader-text">Dismiss this notice.</span></button>
			</div>
			<?php 
		}
		?>
			<div class="col-md-12 padding_0"><!-- col-md-12 -->
				<div class="smgt_main_listpage"><!-- smgt_main_listpage -->
					<?php 
					//Report 1 
					if($active_tab == 'notificationlist')
					{ 
						global $wpdb;
						$smgt_notification = $wpdb->prefix. 'smgt_notification';	
						$result =$wpdb->get_results("SELECT * FROM $smgt_notification");
						if(!empty($result))
						{	
							?>	
							<script type="text/javascript">
								jQuery(document).ready(function($)
								{
									"use strict";	
									var table =  jQuery('#notification_list').DataTable({
										responsive: true,
										"dom": 'lifrtp',
										"order": [[ 2, "asc" ]],
										"aoColumns":[		                  
												{"bSortable": false},	                 
												{"bSortable": false},
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
											var alert_msg=confirm("Are you sure you want to delete this record?");
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
							<div class="panel-body"><!-- panel-body-->
								<div class="table-responsive"><!--table-responsive-->
									<form name="frm-example" action="" method="post">
										<table id="notification_list" class="display admin_notification_datatable" cellspacing="0" width="100%">
											<thead class="<?php echo MJ_smgt_datatable_heder() ?>">
												<tr>
													<th class="padding_0"><input type="checkbox" class="select_all" id="select_all"></th>
													<th><?php  _e( 'Image', 'school-mgt' ) ;?></th>
													<th><?php echo esc_attr_e('Student Name', 'school-mgt' ) ;?></th>
													<th><?php echo esc_attr_e( 'Title', 'school-mgt' ) ;?></th>
													<th> <?php echo esc_attr_e( 'Message', 'school-mgt' ) ;?></th>
													<th class="text_align_end"><?php _e( 'Action', 'school-mgt' ) ;?></th>
												</tr>
											</thead>
											<tbody>
												<?php 
												$i=0;	
												if($result)
												{
													foreach ($result as $retrieved_data)
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
																<input type="checkbox" class="smgt_sub_chk select-checkbox" name="id[]" value="<?php echo $retrieved_data->notification_id;?>">
															</td>
															<td class="user_image width_50px profile_image_prescription padding_left_0">
																<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	
																	<img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/White_icons/Notification.png"?>" height= "30px" width ="30px" alt="" class="massage_image center">
																</p>
															</td>
															<td>
																<?php echo mj_smgt_get_user_name_byid($retrieved_data->student_id); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Student Name','school-mgt');?>" ></i>
															</td>
															<td>
																<?php echo $retrieved_data->title; ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Title','school-mgt');?>" ></i>
															</td>
															<td>
																<?php
																	// $strlength= strlen($retrieved_data->message);
																	// if($strlength > 60)
																	// 	echo substr($retrieved_data->message, 0,60).'...';
																	// else
																	// 	echo $retrieved_data->message;
																?> 
																<?php echo $retrieved_data->message; ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Message','school-mgt');?>" ></i>
															</td>
															<td class="action"> 
																<div class="smgt-user-dropdown">
																	<ul class="" style="margin-bottom: 0px !important;">
																		<li class="">
																			<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">
																				<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >
																			</a>
																			<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">
																				<?php 
																				if($user_access_delete =='1')
																				{ 
																					?>
																					<li class="float_left_width_100">
																						<a href="?page=smgt_notification&tab=notificationlist&action=delete&notification_id=<?php echo $retrieved_data->notification_id;?>" class="float_left_width_100" style="color: #fd726a !important;" onclick="return confirm('<?php esc_attr_e('Are you sure you want to delete this record?','school-mgt');?>');"><i class="fa fa-trash"></i>
																						<?php esc_attr_e('Delete','school-mgt');?>
																						</a> 
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
													} 
												}?>
											</tbody>
										</table>
										<div class="print-button pull-left">
											<button class="btn btn-success btn-sms-color">
												<input type="checkbox" name="id[]" class="select_all" value="<?php echo esc_attr($retrieved_data->notification_id); ?>" style="margin-top: 0px;">
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
								</div><!--table-responsive-->
							</div><!-- panel-body-->
							<?php 
						}
						else
						{
							if($user_access_add=='1')
							{
								?>
								<div class="no_data_list_div"> 
									<a href="<?php echo admin_url().'admin.php?page=smgt_notification&tab=addnotification';?>">
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
					if($active_tab == 'addnotification')
					{
						require_once SMS_PLUGIN_DIR. '/admin/includes/notification/add-notification.php';
					}
					?>				
				</div><!-- smgt_main_listpage -->
			</div><!-- col-md-12 -->
		</div><!-- Row -->
	</div><!-- main_list_margin_15px -->
</div><!-- page-inner -->
<?php ?>