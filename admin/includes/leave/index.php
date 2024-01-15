<?php 		
	$obj_leave=new SmgtLeave;
	$active_tab = isset($_GET['tab'])?$_GET['tab']:'leave_list';
	$to =array();
	$arr = array();
?>
<div class="popup-bg">
    <div class="overlay-content">
		<div class="modal-content">
			<div class="category_list"></div>     
		</div>
    </div> 
</div>
<div class="page-inner"><!--------- Page Inner ------->
	<div id="" class="main_list_margin_5px">
		<?php
		if(isset($_POST['save_leave']))
		{
			
			$nonce = $_POST['_wpnonce'];
			if(wp_verify_nonce( $nonce, 'save_leave_nonce' ) )
			{	
				if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
				{
					$result=$obj_leave->hrmgt_add_leave($_POST);
					if($result)
					{
						wp_redirect (admin_url().'admin.php?page=smgt_leave&tab=leave_list&message=2');
					}
				}
				else
				{		
					
					$result=$obj_leave->hrmgt_add_leave($_POST);	
							
					if($result)
					{				
						wp_redirect (admin_url().'admin.php?page=smgt_leave&tab=leave_list&message=1');
					}
				}
			}
		}

		if(isset($_POST['approve_comment'])&& $_POST['approve_comment']=='Submit')
		{
			$result=$obj_leave->hrmgt_approve_leave($_POST);	
			if($result)
			{
				wp_redirect (admin_url().'admin.php?page=hrmgt-leave&tab=leave_list&message=4');
			}
		}

		if(isset($_POST['reject_leave'])&& $_POST['reject_leave']=='Submit')
		{	
			$result=$obj_leave->hrmgt_reject_leave($_POST);		
			if($result)
			{
				wp_redirect (admin_url().'admin.php?page=hrmgt-leave&tab=leave_list&message=5');
			}
		}

		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
		{
			$result=$obj_leave->hrmgt_delete_leave($_REQUEST['leave_id']);
			if($result)
			{
				wp_redirect ( admin_url().'admin.php?page=smgt_leave&tab=leave_list&message=3');
			}
		}

		if(isset($_REQUEST['delete_selected']))
		{		
			if(!empty($_REQUEST['id']))
			{
				foreach($_REQUEST['id'] as $id)
				{
					$result=$obj_leave->hrmgt_delete_leave($id);
					
					wp_redirect ( admin_url().'admin.php?page=smgt_leave&tab=leave_list&message=3');	
				}
			}
			
			if($result)
			{ 
				wp_redirect ( admin_url().'admin.php?page=smgt_leave&tab=leave_list&message=3');				
			}
		}
		
		if(isset($_REQUEST['approve_selected']))
		{
			if(!empty($_REQUEST['id']))
		   foreach($_REQUEST['id'] as $id)
		   {
				$leave_id['leave_id']= $id;
				$result = $obj_leave->hrmgt_approve_leave_selected($id);
			}
			if($result)
			{
				?>
				<div id="message" class="updated below-h2">
					<p><?php _e('Leave Approve Successfully','school-mgt');?></p>
				</div>
				<?php 
			}
			else
			{
				?>
				<div id="message" class="updated below-h2">
					<p><?php _e('Oops, Something went wrong.','school-mgt');?></p>
				</div>
				<?php 
			}
		}
		if(isset($_REQUEST['reject_selected']))
		{
			if(!empty($_REQUEST['id']))
			foreach($_REQUEST['id'] as $id)
			{
				$leave_id['leave_id']= $id;
				$result = $obj_leave->hrmgt_reject_leave_selected($id);
			}
			if($result)
			{	
				?>
				<div id="message" class="updated below-h2">
					<p><?php _e('Leave Reject Successfully','school-mgt');?></p>
				</div>
				<?php 
			}
			else
			{
				?>
				<div id="message" class="updated below-h2">
					<p><?php _e('Oops, Something went wrong.','school-mgt');?></p>
				</div>
				<?php 
			}
		}
		if(isset($_REQUEST['message']))
		{
			$message =$_REQUEST['message'];
			if($message == 1)
			{ ?>
				<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible">
					<p><?php _e('Leave inserted successfully','school-mgt');	?></p>
				</div><?php 	

			}
			elseif($message == 2)	
			{?>
				<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible"><p><?php _e("Leave updated successfully.",'school-mgt');?></p></div><?php 	

			}
			elseif($message == 3) 	
			{ ?>
				<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible"><p><?php _e('Leave deleted successfully','school-mgt');?></div></p><?php 

			}
			elseif($message == 4) 
			{ ?>
				<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible"><p><?php _e('Leave Approved successfully','school-mgt');	?></div></p><?php 
			}
			elseif($message == 5)
			{ ?>
				<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible"><p><?php _e('Leave Reject successfully','school-mgt');	?></div></p><?php 
			}
		} ?>
		<div class="panel-white"><!--------- penal White ------->
			<div class="panel-body"> <!--------- penal body ------->
				<?php 
				if($active_tab == 'leave_list')
				{	
					?>
						<script type="text/javascript">
							jQuery(document).ready(function($)
							{
								"use strict";	
								var table =  jQuery('#leave_list').DataTable({
									responsive: true,
									"order": [[ 2, "asc" ]],
									"dom": 'lifrtp',
									"aoColumns":[	                  
												{"bSortable": false},
												{"bSortable": false},
												{"bSortable": true},
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
								jQuery('#checkbox-select-all').on('click', function(){
								
									var rows = table.rows({ 'search': 'applied' }).nodes();
									jQuery('input[type="checkbox"]', rows).prop('checked', this.checked);
								}); 
							
								$("#delete_selected").on('click', function()
								{	
									if ($('.select-checkbox:checked').length == 0 )
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

								$('#leave_date').datepicker({
									dateFormat: "yy-mm-dd",
									changeMonth: true,
									changeYear: true,
									maxDate:0,
									yearRange:'-65:+0',
								});    
							});
						</script>
						<div class="panel-body margin_top_20px padding_top_15px_res">
							<!-- <div class="table-responsive"> -->
								<form method="post">  
									<div class="form-body user_form">
										<div class="row">
											<div class="col-md-4 input">
												<label for="email"  class="ml-1 custom-top-label top" ><?php _e('Select Student','school-mgt')?></label>		
												<select class="form-control" id="Student_leave" name="Student_id">
													<option value="all_student"><?php _e('Select All Student','school-mgt');?></option>
													<?php
														$emp_id=0;
														if(isset($_POST['Student_id']))
														{
															$emp_id = $_POST['Student_id'];
														}
														$studentdata=mj_smgt_get_all_student_list('student');
														foreach($studentdata as $student)
														{ 	
															$uid = $student->ID;
															$emp_id = get_user_meta($uid, 'student', true);
														?>	
														<option value="<?php print $student->ID ?>" <?php selected($student->ID,$emp_id) ?>><?php echo $student->display_name.' ('.$student->ID .')'?></option>
														<?php 
													} ?>
												</select>
											</div>

											<div class="col-md-3 input">
												<label for="exam_id" class="ml-1 custom-top-label top"><?php _e('Select Status','school-mgt');?></label>
												<select class="form-control" id="lave_status" name="status">
													<option value="all_status"><?php _e('Select All Status','school-mgt');?></option>
													<option value="Not Approved"><?php _e('Not Approved','school-mgt');?></option>
													<option value="Approved"><?php _e('Approved','school-mgt');?></option>
													<option value="Rejected"><?php _e('Rejected','school-mgt');?></option>
												</select>
											</div>
											<div class="col-md-3">
												<div class="form-group input">
													<div class="col-md-12 form-control">
														<input type="text"  id="leave_date" class="form-control" name="leave_date" value="<?php if(isset($_REQUEST['leave_date'])) echo $_REQUEST['leave_date'];else echo date('Y-m-d');?>" readonly>
														<label for="exam_id"><?php _e('Select Date','school-mgt');?></label>
													</div>
												</div>
											</div>
											
											<div class="col-md-2">
												<input type="submit" name="view_student" Value="<?php esc_attr_e('Go','school-mgt');?>"  class="btn btn-info save_btn"/>
											</div>

										</div>
									</div>
								</form>
								<?php
								if(isset($_REQUEST['view_student']))
								{
									$leave_date = $_POST['leave_date'];
									$Student_id = $_POST['Student_id'];
									$status = $_POST['status'];
									$leave_data=mj_smgt_view_leave_student_for_data($leave_date,$Student_id,$status);
								}
								else
								{
									$leave_data=$obj_leave->get_all_leaves();	
								}

								if(!empty($leave_data))
								{	
									?>
										<div class="table-responsive"><!-- table-responsive -->

											<form id="frm-example" name="frm-example" method="post">	
												<table id="leave_list" class="display admin_transport_datatable" cellspacing="0" width="100%">
													<thead class="<?php echo MJ_smgt_datatable_heder() ?>">
														<tr>
															<th class="padding_0" ><input name="select_all" value="all" class="select_all padding_0" id="select_all" type="checkbox" ></th>
															<th><?php _e( 'Image', 'school-mgt' ) ;?></th>
															<th><?php _e( 'Student Name', 'school-mgt' ) ;?></th>
															<th><?php _e( 'Leave Type', 'school-mgt' ) ;?></th>
															<th><?php _e( 'Leave Duration', 'school-mgt' ) ;?></th>
															<th><?php _e( 'Start Date', 'school-mgt' ) ;?></th>
															<th><?php _e( 'End Date', 'school-mgt' ) ;?></th>
															<th><?php _e( 'Status', 'school-mgt' ) ;?></th>
															<th><?php _e( 'Reason', 'school-mgt' ) ;?></th>
															<th class="text_align_end"><?php  _e( 'Action', 'school-mgt' ) ;?></th>
														</tr>
													</thead>
													<tbody>
														<?php 
														$i=0;
														foreach ($leave_data as $retrieved_data)
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
																
																<td class="checkbox_width_10px"><input type="checkbox" class="smgt_sub_chk select-checkbox" name="id[]" value="<?php echo $retrieved_data->id;?>"></td>
																
																<td class="user_image width_50px profile_image_prescription">	
																	<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	
																		<img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/leave.png"?>" alt="" class="massage_image center image_icon_height_25px margin_top_3px">
																	</p>
																</td>
																<td><?php echo mj_smgt_get_display_name($retrieved_data->student_id);?> (<?php echo $retrieved_data->student_id;?>) <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Student Name','school-mgt');?>"></i></td> 
																<td><?php echo get_the_title($retrieved_data->leave_type);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Leave Type','school-mgt');?>"></i></td>				
																<td><?php echo hrmgt_leave_duration_label($retrieved_data->leave_duration);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Leave Duration','school-mgt');?>"></i></td>
																<td><?php echo mj_smgt_getdate_in_input_box($retrieved_data->start_date);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Leave Start Date','school-mgt');?>"></i></td> 
																<td><?php if(!empty($retrieved_data->end_date)){echo mj_smgt_getdate_in_input_box($retrieved_data->end_date);}else{echo "N/A";}?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Leave End Date','school-mgt');?>"></i></td> 
																<td>
																	<?php
																	if($retrieved_data->status == "Approved"){
																		echo "<span class='green_color'> " .$retrieved_data->status." </span>";
																	}
																	else
																	{
																		echo "<span class='red_color'> " .$retrieved_data->status." </span>";
																	}
																	// echo $retrieved_data->status;
																	?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Status','school-mgt');?>"></i></td>
																<td><?php echo $retrieved_data->reason;?><i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Reason','school-mgt');?>"></i></td>
																
																<td class="action">  
																	<div class="smgt-user-dropdown">
																		<ul class="" style="margin-bottom: 0px !important;">
																			<li class="">
																				<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">
																					<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >
																				</a>
																				<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">
																					<?php
																					if(($retrieved_data->status!='Approved') AND ($retrieved_data->status!='Rejected'))
																					{
																						?>
																						<li class="float_left_width_100 border_bottom_menu">
																							<a href="#" leave_id="<?php echo $retrieved_data->id ?>" class="float_left_width_100 leave-approve">
																								<i class="fa fa-thumbs-o-up"></i> <?php esc_html_e('Approve', 'school-mgt' ) ;?> 
																							</a>
																						</li>
																						<?php
																					}
																					if(($retrieved_data->status!='Approved') AND ($retrieved_data->status!='Rejected'))
																					{
																						?>
																						<li class="float_left_width_100 border_bottom_menu">
																							<a href="#" leave_id="<?php echo $retrieved_data->id ?>" class="leave-reject float_left_width_100">
																								<i class="fa fa-thumbs-o-down" ></i> <?php esc_html_e('Reject', 'school-mgt' ) ;?>
																							</a>
																						</li>
																						<?php
																					}
																					if($role == 'admin')
																					{
																						?>
																						<li class="float_left_width_100 border_bottom_menu">
																							<a href="?page=smgt_leave&tab=add_leave&action=edit&leave_id=<?php echo $retrieved_data->id;?>" class="float_left_width_100"><i class="fa fa-edit"> </i><?php esc_html_e('Edit', 'school-mgt' ) ;?></a>
																						</li>
																						<li class="float_left_width_100 ">
																							<a href="?page=smgt_leave&tab=leave_list&action=delete&leave_id=<?php echo $retrieved_data->id;?>" class="float_left_width_100" style="color: #fd726a !important;" onclick="return confirm('<?php esc_attr_e('Are you sure you want to delete this record?','school-mgt');?>');">
																							<i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'school-mgt' ) ;?> </a>
																						</li>
																						<?php
																					}
																					else
																					{
																						?>
																						<li class="float_left_width_100 border_bottom_menu">
																							<a href="?dashboard=user&page=leave&tab=add_leave&action=edit&leave_id=<?php echo $retrieved_data->id; ?>" leave_id="'.$retrieved_data->id.'" class="float_left_width_100 leave-reject"><i class="fa fa-edit"> </i><?php esc_html_e('Edit', 'school-mgt' ) ;?></a>
																						</li>
																						<li class="float_left_width_100 ">
																							<a href="?dashboard=user&page=leave&tab=leave_list&action=delete&leave_id=<?php echo $retrieved_data->id; ?>" class="float_left_width_100" style="color: #fd726a !important;" onclick="return confirm('<?php esc_attr_e('Are you sure you want to delete this record?','school-mgt');?>');">
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
															$i++;
														} 
														?>
													</tbody>
												</table>
												<div class="print-button pull-left">
													<button class="btn-sms-color">
														<input type="checkbox" name="id[]" class="select_all" value="<?php echo esc_attr($retrieved_data->ID); ?>" style="margin-top: 0px;">
														<label for="checkbox" class="margin_right_5px"><?php esc_html_e( 'Select All', 'school-mgt' ) ;?></label>
													</button>
													<button data-toggle="tooltip" id="delete_selected" title="<?php esc_html_e('Delete Selected','school-mgt');?>" name="delete_selected" class="delete_selected" ><img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png" ?>" alt=""></button>
														
												</div>
											</form>

										</div><!--------- Table Responsive ------->
									<?php 
								}
								else
								{
									if(isset($_REQUEST['view_student']))
									{
										?>
											<div class="no_data_list_div"> 
												<img class="no_data_img" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >
											</div>
										<?php
									}else{
										?>
										<div class="no_data_list_div"> 
											<a href="<?php echo admin_url().'admin.php?page=smgt_leave&tab=add_leave';?>">
												<img class="col-md-12 width_100px" src="<?php echo get_option( 'smgt_no_data_img' ) ?>" >
											</a>
											<div class="col-md-12 dashboard_btn margin_top_20px">
												<label class="no_data_list_label"><?php esc_html_e('Tap on above icon to add your first Record.','school-mgt'); ?> </label>
											</div> 
										</div>
										<?php		
									}
								}
								?>
							<!-- </div> -->
						</div>
					<!-- Start Panel body -->
					<?php 
				}
				if($active_tab == 'add_leave')
				{
					require_once SMS_PLUGIN_DIR.'/admin/includes/leave/add_leave.php';
				}
				?>
			</div><!--------- penal body ------->
		</div><!--------- penal White ------->
	</div>
</div>