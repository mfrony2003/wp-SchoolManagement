<?php
//-------- CHECK BROWSER JAVA SCRIPT ----------//
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
	$user_access=mj_smgt_get_userrole_wise_filter_access_right_array('admission');
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
			if ('admission' == $user_access['page_link'] && ($_REQUEST['action']=='edit'))
			{
				if($user_access_edit=='0')
				{	
					mj_smgt_access_right_page_not_access_message_admin_side();
					die;
				}			
			}
			if ('admission' == $user_access['page_link'] && ($_REQUEST['action']=='delete'))
			{
				if($user_access_delete=='0')
				{	
					mj_smgt_access_right_page_not_access_message_admin_side();
					die;
				}	
			}
			if ('admission' == $user_access['page_link'] && ($_REQUEST['action']=='insert'))
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
<!-- POP up code -->
<div class="popup-bg">
    <div class="overlay-content admission_popup">
		<div class="modal-content">
			<div class="result admission_approval_popup_rs"></div>
		</div>
    </div>    
</div>
<?php
$obj_admission=new smgt_admission;
//------------ ACTIVE ADMISSION ------------//
if(isset($_POST['active_user_admission']))
{		
	$userbyroll_no	=	get_users(
		array('meta_query'	=>
			array('relation' => 'AND',
				array('key'	=>'class_name','value'=>$_POST['class_name']),
				array('key'=>'roll_id','value'=>mj_smgt_strip_tags_and_stripslashes($_POST['roll_id']))
			),
			'role'=>'student')
	);
	$is_rollno = count($userbyroll_no);	
		
	if($is_rollno)
	{
		wp_redirect ( admin_url().'admin.php?page=smgt_admission&tab=admission_list&message=6'); 
	}
	else
	{		
		$active_user_id		= 	$_REQUEST['act_user_id'];
		update_user_meta($active_user_id, 'roll_id', $_REQUEST['roll_id']);
		update_user_meta($active_user_id, 'class_name', $_REQUEST['class_name']);
		update_user_meta($active_user_id, 'class_section', $_REQUEST['class_section']);
		if( email_exists($_REQUEST['email'] ) )
		{ // if the email is registered, we take the user from this
			if( !empty($_REQUEST['password']) )
				wp_set_password($_REQUEST['password'], $active_user_id );
		}
			
		$user_info 	= 	get_userdata($_POST['act_user_id']);
		if(!empty($user_info))
		{
		//--------- SEND STUDENT MAIL ACTIVE ACCOUNT -----------//	
		
			$string = array();
			$string['{{user_name}}']   =  $user_info->display_name;
			$string['{{school_name}}'] =  get_option('smgt_school_name');
			$string['{{role}}']        =  "student";
			$string['{{login_link}}']  =  site_url() .'/index.php/school-management-login-page';
			$string['{{username}}']    =  $user_info->user_login;
			$string['{{class_name}}']  =  mj_smgt_get_class_name($_REQUEST['class_section']);
			$string['{{email}}']  	   =  $user_info->user_email;
			$string['{{Password}}']    =  $_REQUEST['password'];
						
			$MsgContent                =  get_option('add_approve_admission_mail_content');		
			$MsgSubject				   =  get_option('add_approve_admisson_mail_subject');
			$message = mj_smgt_string_replacement($string,$MsgContent);
			$MsgSubject = mj_smgt_string_replacement($string,$MsgSubject);
		
			$email= $user_info->user_email;
			mj_smgt_send_mail($email,$MsgSubject,$message); 
		}	
				
			$role_upadte="student";
			$status="Approved";
			$result = new WP_User($active_user_id);
			$result->set_role($role_upadte);
			$result=update_user_meta($active_user_id, 'role', $role_upadte );
			$result=update_user_meta($active_user_id, 'status', $status );     
			$role_parents="parent"; 
			
			//---------- ADD PARENTS -------------------//
			$patents_add=$obj_admission->mj_smgt_add_parent($active_user_id,$role_parents); 
			
		if(get_user_meta($active_user_id, 'hash', true))  
		{
			delete_user_meta($active_user_id, 'hash'); 
		}
			
		wp_redirect ( admin_url().'admin.php?page=smgt_student&tab=studentlist&message=7');			
	}
}
//------------- SAVE STUDENT ADMISSION FORM ------------------//
if(isset($_POST['student_admission']))
{
	// var_dump($_POST);
	// die;
	$nonce = $_POST['_wpnonce'];
	if ( wp_verify_nonce( $nonce, 'save_admission_form' ) )
	{
		$role=$_POST['role'];
		if(isset($_FILES['father_doc']) && !empty($_FILES['father_doc']) && $_FILES['father_doc']['size'] !=0)
		{			
			if($_FILES['father_doc']['size'] > 0)
				$upload_docs=mj_smgt_load_documets_new($_FILES['father_doc'],$_FILES['father_doc'],$_POST['father_document_name']);		
		}
		else
		{
			$upload_docs='';
		}
		$father_document_data=array();
		if(!empty($upload_docs))
		{
			$father_document_data[]=array('title'=>$_POST['father_document_name'],'value'=>$upload_docs);
		}
		else
		{
			$father_document_data[]='';
		}
		
		if(isset($_FILES['mother_doc']) && !empty($_FILES['mother_doc']) && $_FILES['mother_doc']['size'] !=0)
		{			
			if($_FILES['mother_doc']['size'] > 0)
				$upload_docs1=mj_smgt_load_documets_new($_FILES['mother_doc'],$_FILES['mother_doc'],$_POST['mother_document_name']);		
		}
		else
		{
			$upload_docs1='';
		}
		$mother_document_data=array();
		if(!empty($upload_docs1))
		{
			$mother_document_data[]=array('title'=>$_POST['mother_document_name'],'value'=>$upload_docs1);
		}
		else
		{
			$mother_document_data[]='';
		}
		if ($_REQUEST['action']=='edit')
		{
			//----------EDIT-------------//
			$result= $obj_admission->mj_smgt_add_admission($_POST,$father_document_data,$mother_document_data,$role);
		 	if($result)
			{   
				wp_redirect ( admin_url().'admin.php?page=smgt_admission&tab=admission_list&message=9'); 	  
			} 
		}
		else
		{
			//-------- Email Check --------//
			if(email_exists($_POST['email']))
			{
				wp_redirect ( admin_url().'admin.php?page=smgt_admission&tab=admission_form&message=2');
			} 
			elseif(email_exists($_POST['father_email']))
			{
				wp_redirect ( admin_url().'admin.php?page=smgt_admission&tab=admission_form&message=3');
			}
			elseif(email_exists($_POST['mother_email']))
			{
				wp_redirect ( admin_url().'admin.php?page=smgt_admission&tab=admission_form&message=4');
			}
			else
			{
				// wp_redirect ( admin_url().'admin.php?page=smgt_admission&tab=admission_list&message=1'); 
				//----------ADD-------------//
				  $result= $obj_admission->mj_smgt_add_admission($_POST,$father_document_data,$mother_document_data,$role);
			 
			 	if($result)
				{   
					wp_redirect ( admin_url().'admin.php?page=smgt_admission&tab=admission_list&message=1'); 	  
				} 
			}
	    }
	}
}
//------------- DELETE ADMISSION  ------------------//
if(isset($_REQUEST['delete_selected']))
{		
	if(!empty($_REQUEST['id']))
	{
		foreach($_REQUEST['id'] as $id)
		{
			$result=mj_smgt_delete_usedata($id);
			wp_redirect ( admin_url().'admin.php?page=smgt_admission&tab=admission_list&message=8');
		}
	}
	if($result)
	{
		wp_redirect ( admin_url().'admin.php?page=smgt_admission&tab=admission_list&message=8');
	}
}
// -----------Delete Code--------
if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
{		
	$result=mj_smgt_delete_usedata($_REQUEST['admission_id']);
	if($result)
	{
		wp_redirect ( admin_url().'admin.php?page=smgt_admission&tab=admission_list&message=8');
	}
}
$active_tab = isset($_GET['tab'])?$_GET['tab']:'admission_list';
{
	?>
	<div class="page-inner"><!--------- page inner -------->
		<div class="main_list_margin_15px"><!----- main_list_margin_15px--------->
			<?php
			$message = isset($_REQUEST['message'])?$_REQUEST['message']:'0';
			switch($message)
			{
				case '1':
					$message_string = esc_attr__('Request For Admission Added Successfully.','school-mgt');
					break;
				case '2':
					$message_string = esc_attr__('Student Email-id Already Exist.','school-mgt');
					break;	
				case '3':
					$message_string = esc_attr__('Father Email-id Already Exist.','school-mgt');
					break;	
				case '4':
					$message_string = esc_attr__('Mother Email-id Already Exist.','school-mgt');
					break;	
				case '5':
					$message_string = esc_attr__('Student Admission Successfully.','school-mgt');
					break;
				case '6':
					$message_string = esc_attr__('Student Roll No. Already Exist.','school-mgt');
					break;
				case '7':
					$message_string = esc_attr__('Student Record Approved Successfully.','school-mgt');
					break;
				case '8':
				$message_string = esc_attr__('Request For Admission Deleted Successfully.','school-mgt');
				break;
				case '9':
				$message_string = esc_attr__('Request For Admission Upadated Successfully.','school-mgt');
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
			<div class="row"> <!------- Row Div --------->
				<div class="col-md-12 padding_0"><!------- col-md-12 Div --------->
					<div class="smgt_main_listpage">
						<?php 
						if($active_tab == 'admission_list')
						{
							$studentdata =get_users(array('role'=>'student_temp'));
							if(!empty($studentdata))
							{
								?>  
								<script>
									jQuery(document).ready(function() 
									{
										var table =  jQuery('#admission_list').DataTable({
										responsive: true,
										"dom": 'lifrtp',
										"order": [[ 2, "DESC" ]],
										"aoColumns":[	                  
											{"bSortable": false},
											{"bSortable": false},
											{"bSortable": true},
											{"bSortable": true},
											{"bSortable": true},
											{"bSortable": true},
											{"bSortable": true},
											{"bSortable": false}],
										language:<?php echo mj_smgt_datatable_multi_language();?>
										});
										$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'school-mgt') ?>");
										jQuery('#checkbox-select-all').on('click', function(){     
											var rows = table.rows({ 'search': 'applied' }).nodes();
											jQuery('input[type="checkbox"]', rows).prop('checked', this.checked);
										}); 
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
												if ($('.select-checkbox:checked').length == 0 )
												{
													alert("<?php esc_html_e('Please select atleast one record','school-mgt');?>");
													return false;
												}
											else
											{
													var alert_msg=confirm("<?php esc_html_e('Are you sure you want to delete this record?','school-mgt');?>");
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
								<div class="panel-body">
									<div class="table-responsive">
										<form id="frm-example" name="frm-example" method="post">
											<table id="admission_list" class="display admin_student_datatable display responsive "  width="100%">						
												<thead class="<?php echo MJ_smgt_datatable_heder() ?>">
													<tr>
														<th class="padding_0"><input type="checkbox" class="select_all" id="select_all"></th>
														<th><?php  _e( 'Photo', 'school-mgt' ) ;?></th>
														<th><?php echo esc_attr_e( 'Student Name & Email', 'school-mgt' ) ;?></th>
														<th> <?php echo esc_attr_e( 'Gender', 'school-mgt' ) ;?></th>
														<th> <?php echo esc_attr_e( 'Address', 'school-mgt' ) ;?></th>
														<th> <?php echo esc_attr_e( 'Mobile No.', 'school-mgt' ) ;?></th>
														<th> <?php echo esc_attr_e( 'Previous School', 'school-mgt' ) ;?></th>
														<th class="text_align_end"><?php  _e( 'Action', 'school-mgt' ) ;?></th>
													</tr>
												</thead>
												<tbody>
													<?php 
													if(!empty($studentdata))
													{
														foreach ($studentdata as $retrieved_data)
														{
															$user_info = get_userdata($retrieved_data->ID);
													
															?>
															<tr>
																<td class="checkbox_width_10px"><input type="checkbox" name="id[]" class="smgt_sub_chk select-checkbox" value="<?php echo esc_attr($retrieved_data->id); ?>"></td>
																<td class="user_image width_50px">
																	<a href="?page=smgt_admission&tab=view_admission&action=view_admission&id=<?php echo $retrieved_data->ID;?>">
																		<?php
																			$uid=$retrieved_data->ID;
																			$umetadata=mj_smgt_get_user_image($uid);
																			if(empty($umetadata))
																			{
																				echo '<img src='.get_option( 'smgt_student_thumb_new' ).' class="img-circle" />';
																			}
																			else
																			{
																				echo '<img src='.$umetadata.' class="img-circle" />';
																			}
																		?>
																	</a>
																</td>

																<td class="name">
																	<a class="color_black" href="?page=smgt_admission&tab=view_admission&action=view_admission&id=<?php echo $retrieved_data->ID;?>"><?php echo $retrieved_data->display_name;?></a>
																	<br>
																	<label class="list_page_email"><?php echo $retrieved_data->user_email;?></label>
																</td>
																<td class=""><?php echo esc_attr_e(ucfirst($user_info->gender),'school-mgt');?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Gender','school-mgt');?>" ></i></td>
																<td class=""><?php echo $user_info->address;?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Address','school-mgt');?>" ></i></td>
																<td class="">+<?php echo mj_smgt_get_countery_phonecode(get_option( 'smgt_contry' ));?> <?php echo $user_info->phone;?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Mobile No.','school-mgt');?>" ></i></td>
																<td class=""><?php if(!empty($user_info->preschool_name)){ echo $user_info->preschool_name; }else{ echo "N/A"; }?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Previous School Name','school-mgt');?>" ></i></td>
																<td class="action">  
																	<div class="smgt-user-dropdown">
																		<ul class="" style="margin-bottom: 0px !important;">
																			<li class="">
																				<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">
																					<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >
																				</a>
																				<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">
																					<li class="float_left_width_100">
																						<a href="?page=smgt_admission&tab=view_admission&action=view_admission&id=<?php echo $retrieved_data->ID;?>" class="float_left_width_100"><i class="fa fa-eye"> </i><?php esc_attr_e('View','school-mgt');?></a> 
																					</li>
																					<?php
																					if($user_info->role =="student_temp")
																					{
																						?>
																						<li class="float_left_width_100 ">
																							<a href="?page=smgt_admission&tab=admission_list&action=approve&id=<?php echo $retrieved_data->ID;?>" class="float_left_width_100 show-admission-popup" student_id="<?php echo $retrieved_data->ID; ?>"><i class="fa fa-thumbs-up"> </i><?php esc_html_e('Approve', 'school-mgt' ) ;?></a>
																						</li>
																						<?php 
																					}
																					if($user_access_edit == '1')
																					{
																						?>
																							<li class="float_left_width_100 border_bottom_menu">
																							<a href="?page=smgt_admission&tab=admission_form&action=edit&id=<?php echo $retrieved_data->ID;?>" class="float_left_width_100"><i class="fa fa-edit"> </i><?php esc_html_e('Edit', 'school-mgt' ) ;?></a>
																						</li>

																						<?php 
																					} 
																					if($user_access_delete =='1')
																					{
																						?>
																						<li class="float_left_width_100 ">
																							<a href="?page=smgt_admission&tab=studentlist&action=delete&admission_id=<?php echo $retrieved_data->ID;?>" class="float_left_width_100" style="color: #fd726a !important;" onclick="return confirm('<?php esc_attr_e('Are you sure you want to delete this record?','school-mgt');?>');">
																							<i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'school-mgt' ) ;?> </a>
																						</li>
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
														} 
													} ?>
												</tbody>        
											</table>
											<div class="print-button pull-left">
												<button class="btn-sms-color">
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
								</div>
								
								<?php 	
							}
							else
							{
								if($user_access_add=='1')
								{
									?>
									<div class="no_data_list_div"> 
										<a href="<?php echo admin_url().'admin.php?page=smgt_admission&tab=admission_form';?>">
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
						if($active_tab == 'admission_form')
						{
							require_once SMS_PLUGIN_DIR. '/admin/includes/admission/admission_form.php';
						}
						if($active_tab == 'view_admission')
						{
							require_once SMS_PLUGIN_DIR. '/admin/includes/admission/view_admission.php';
						}
						?>
					</div>
				</div><!------- col-md-12 Div --------->
			</div><!------- Row Div --------->
		</div><!----- main_list_margin_15px--------->
	</div><!--------- page inner -------->
	<?php
}
?>