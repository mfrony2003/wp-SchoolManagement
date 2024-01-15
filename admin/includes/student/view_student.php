<?php
 $active_tab1 = isset($_REQUEST['tab1'])?$_REQUEST['tab1']:'general';
 $student_data=get_userdata($_REQUEST['student_id']);
 $user_meta =get_user_meta($_REQUEST['student_id'], 'parent_id', true);

 $parent_list 	= 	mj_smgt_get_student_parent_id($_REQUEST['student_id']);	
 $custom_field_obj = new Smgt_custome_field;								
 $module='student';	
 $user_custom_field=$custom_field_obj->mj_smgt_getCustomFieldByModule($module);
 $student_id = $_REQUEST['student_id'];
 $page_name = $_REQUEST ['page']; 
//  $user_access=mj_smgt_get_management_access_right_array($page_name);
 $school_obj = new School_Management ( get_current_user_id () );
 $role=$school_obj->role;
?>
<!-- POP up code -->


<!-- POP up code -->
<div class="panel-body view_page_main"><!-- START PANEL BODY DIV-->
	<div class="content-body">
		<!-- Detail Page Header Start -->
		<section id="user_information" class="">
			<div class="view_page_header_bg">
				<div class="row">
					<div class="col-xl-10 col-md-9 col-sm-10">
						<div class="user_profile_header_left float_left_width_100">
							<?php
							$userimage=mj_smgt_get_user_image($student_data->ID);
							
							?>
							<img class="user_view_profile_image" src="<?php if(!empty($userimage)) {echo $userimage; }else{ echo get_option( 'smgt_student_thumb_new' );}?>">
							<div class="row profile_user_name">
								<div class="float_left view_top1">
									<div class="col-xl-12 col-md-12 col-sm-12 float_left_width_100">
										<label class="view_user_name_label"><?php echo esc_html($student_data->display_name);?></label>
										<?php
										if($user_access_edit=='1')
										{
											?>
											<div class="view_user_edit_btn">
												<a class="color_white margin_left_2px" href="?page=smgt_student&tab=addstudent&action=edit&student_id=<?php echo $student_data->ID;?>">
												<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/edit.png"?>">
												</a>
											</div>
											<?php
										}
										?>
									</div>
									<div class="col-xl-12 col-md-12 col-sm-12 float_left_width_100">
										<div class="view_user_phone float_left_width_100">
											<img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/phone_figma.png"?>">&nbsp;+<?php echo mj_smgt_get_countery_phonecode(get_option( 'smgt_contry' ));?>&nbsp;&nbsp;<lable class="color_white_rs"><?php echo $student_data->mobile_number;?></label>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-12 col-md-12 col-sm-12">
									<div class="view_top2">
										<div class="row view_user_doctor_label">
											<div class="col-md-12 address_student_div">
												<img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/location.png"?>" alt="">&nbsp;&nbsp;<lable class="address_detail_page"><?php echo $student_data->address; ?></label>
											</div>		
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-2 col-lg-3 col-md-3 col-sm-2 add_btn_possition_res">
						<div class="group_thumbs">
							<img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Group.png"?>">
						</div>
						<div class="viewpage_add_icon dropdown_menu_icon">
							<li class="dropdown_icon_menu_div">
								<a class="dropdown_icon_link" href="#" data-bs-toggle="dropdown" aria-expanded="false" >
									<img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/add_more_icon.png"?>" class="add_more_icon_detailpage">
								</a>
								<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">
									<li class="float_left_width_100">
										<a href="admin.php?page=smgt_attendence" class="float_left_width_100"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/plus_icon.png"?>" alt="" class="image_margin_right_10px"><?php esc_html_e('Attendance','school-mgt');?></a>
									</li>
									<li class="float_left_width_100">
										<a href="admin.php?page=smgt_result" class="float_left_width_100"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/plus_icon.png"?>" alt="" class="image_margin_right_10px"><?php esc_html_e('Manage Marks','school-mgt');?></a>
									</li>
									<li class="float_left_width_100">
										<a href="admin.php?page=smgt_hostel&tab=room_list" class="float_left_width_100"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/plus_icon.png"?>" alt="" class="image_margin_right_10px"><?php esc_html_e('Assign Room','school-mgt');?></a>
									</li>
									<li class="float_left_width_100">
										<a href="admin.php?page=smgt_message&tab=compose" class="float_left_width_100"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/plus_icon.png"?>" alt="" class="image_margin_right_10px"><?php esc_html_e('Message','school-mgt');?></a>
									</li>
									<li class="float_left_width_100">
										<a href="admin.php?page=smgt_fees_payment&tab=addpaymentfee" class="float_left_width_100"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/plus_icon.png"?>" alt="" class="image_margin_right_10px"><?php esc_html_e('Fees Payment','school-mgt');?></a>
									</li>
									<li class="float_left_width_100">
										<a href="admin.php?page=smgt_library&tab=issuebook" class="float_left_width_100"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/plus_icon.png"?>" alt="" class="image_margin_right_10px"><?php esc_html_e('Issue Books','school-mgt');?></a>
									</li>
								</ul>
							</li>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Detail Page Header End -->

		<!-- Detail Page Tabing Start -->
		<section id="body_area" class="student_view_tab">
			<div class="row">
				<div class="col-xl-12 col-md-12 col-sm-12 rs_width">
					<ul class="nav nav-tabs panel_tabs margin_left_1per" role="tablist">
						<li class="<?php if($active_tab1=='general'){?>active<?php }?>">			
							<a href="admin.php?page=smgt_student&tab=view_student&action=view_student&tab1=general&student_id=<?php echo $_REQUEST['student_id'];?>" class="padding_left_0 tab <?php echo $active_tab1 == 'general' ? 'active' : ''; ?>">
							<?php esc_html_e('GENERAL', 'school-mgt'); ?></a> 
						</li>
						<li class="<?php if($active_tab1=='parent'){?>active<?php }?>">
							<a href="admin.php?page=smgt_student&tab=view_student&action=view_student&tab1=parent&student_id=<?php echo $_REQUEST['student_id'];?>" class="padding_left_0 tab <?php echo $active_tab1 == 'parent' ? 'active' : ''; ?>">
							<?php esc_html_e('Parent List', 'school-mgt'); ?></a> 
						</li>  
						<li class="<?php if($active_tab1=='feespayment'){?>active<?php }?>">
							<a href="admin.php?page=smgt_student&tab=view_student&action=view_student&tab1=feespayment&student_id=<?php echo $_REQUEST['student_id'];?>" class="padding_left_0 tab <?php echo $active_tab1 == 'feespayment' ? 'active' : ''; ?>">
							<?php esc_html_e('Fees Payment', 'school-mgt'); ?></a> 
						</li>  
						<li class="<?php if($active_tab1=='attendance'){?>active<?php }?>">
							<a href="admin.php?page=smgt_student&tab=view_student&action=view_student&tab1=attendance&student_id=<?php echo $_REQUEST['student_id'];?>" class="padding_left_0 tab <?php echo $active_tab1 == 'attendance' ? 'active' : ''; ?>">
							<?php esc_html_e('Attendance', 'school-mgt'); ?></a> 
						</li>  
						<li class="<?php if($active_tab1=='hallticket'){?>active<?php }?>">
							<a href="admin.php?page=smgt_student&tab=view_student&action=view_student&tab1=hallticket&student_id=<?php echo $_REQUEST['student_id'];?>" class="padding_left_0 tab <?php echo $active_tab1 == 'hallticket' ? 'active' : ''; ?>">
							<?php esc_html_e('Hall Ticket', 'school-mgt'); ?></a> 
						</li>  
						<li class="<?php if($active_tab1=='homework'){?>active<?php }?>">
							<a href="admin.php?page=smgt_student&tab=view_student&action=view_student&tab1=homework&student_id=<?php echo $_REQUEST['student_id'];?>" class="padding_left_0 tab <?php echo $active_tab1 == 'homework' ? 'active' : ''; ?>">
							<?php esc_html_e('HomeWork', 'school-mgt'); ?></a> 
						</li>  
						<li class="<?php if($active_tab1=='issuebook'){?>active<?php }?>">
							<a href="admin.php?page=smgt_student&tab=view_student&action=view_student&tab1=issuebook&student_id=<?php echo $_REQUEST['student_id'];?>" class="padding_left_0 tab <?php echo $active_tab1 == 'issuebook' ? 'active' : ''; ?>">
							<?php esc_html_e('Issue Book', 'school-mgt'); ?></a> 
						</li> 
						<li class="<?php if($active_tab1=='exam_result'){?>active<?php }?>">
							<a href="admin.php?page=smgt_student&tab=view_student&action=view_student&tab1=exam_result&student_id=<?php echo $_REQUEST['student_id'];?>" class="padding_left_0 tab <?php echo $active_tab1 == 'exam_result' ? 'active' : ''; ?>">
							<?php esc_html_e('Exam Results', 'school-mgt'); ?></a> 
						</li> 
						<li class="<?php if($active_tab1=='message'){?>active<?php }?>">
							<a href="admin.php?page=smgt_student&tab=view_student&action=view_student&tab1=message&student_id=<?php echo $_REQUEST['student_id'];?>" class="padding_left_0 tab <?php echo $active_tab1 == 'message' ? 'active' : ''; ?>">
							<?php esc_html_e('Messages', 'school-mgt'); ?></a> 
						</li> 
					</ul>
				</div>
			</div>
		</section>
		<!-- Detail Page Tabing End -->

		<!-- Detail Page Body Content Section  -->
		<section id="body_content_area" class="">
			<div class="panel-body"><!-- START PANEL BODY DIV-->
				<?php 
				// general tab start 
				if($active_tab1 == "general")
				{
					?>
					<div class="popup-bg">
						<div class="overlay-content content_width">
							<div class="modal-content d-modal-style">
								<div class="task_event_list">
								</div>
							</div>
						</div>
					</div>
					<div class="row margin_top_15px">
						<div class="col-xl-4 col-md-3 col-sm-12 margin_bottom_10_res">
							<label class="view_page_header_labels"> <?php esc_html_e('Email ID', 'school-mgt'); ?> </label><br/>
							<label class="view_page_content_labels"> <?php echo $student_data->user_email; ?> </label>
						</div>
						<div class="col-xl-2 col-md-3 col-sm-12 margin_bottom_10_res">
							<label class="view_page_header_labels"> <?php esc_html_e('Roll Number', 'school-mgt'); ?> </label><br/>
							<label class="view_page_content_labels"><?php if(!empty($student_data->roll_id)){ echo $student_data->roll_id; }else{ echo "N/A"; } ?></label>	
						</div>
						<div class="col-xl-2 col-md-3 col-sm-12 margin_bottom_10_res">
							<label class="view_page_header_labels"> <?php esc_html_e('Class Name', 'school-mgt'); ?> </label><br/>
							<label class="view_page_content_labels"> 
								<?php $class_name = mj_smgt_get_class_name($student_data->class_name); 
								if($class_name == " "){ echo "N/A";}else{ echo $class_name;} ?> 
							</label>	
						</div>
						<div class="col-xl-3 col-md-3 col-sm-12 margin_bottom_10_res">
							<label class="view_page_header_labels"> <?php esc_html_e('Section Name', 'school-mgt'); ?> </label><br/>
							<label class="view_page_content_labels"> 
								<?php 
								if(!empty($student_data->class_section))
								{
									echo mj_smgt_get_section_name($student_data->class_section); 
								}
								else
								{
									echo esc_attr_e('No Section','school-mgt');
								}
								
								?> 
							</label>
						</div>
					</div>
					<!-- student Information div start  -->
					<div class="row margin_top_20px">
						<div class="col-xl-8 col-md-8 col-sm-12">
							<div class="col-xl-12 col-md-12 col-sm-12 margin_top_20px">
								<div class="guardian_div">
									<label class="view_page_label_heading"> <?php esc_html_e('Student Information', 'school-mgt'); ?> </label>
									<div class="row">
										<div class="col-xl-3 col-md-3 col-sm-12 margin_top_15px">
											<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('Full Name', 'school-mgt'); ?> </label> <br>
											<label class="view_page_content_labels"><?php echo $student_data->display_name; ?></label>
										</div>
										<div class="col-xl-3 col-md-3 col-sm-12 margin_top_15px">
											<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('Phone', 'school-mgt'); ?> </label><br>
											<label class="ftext_style_capitalization view_page_content_labels"><?php if(!empty($student_data->phone)){ echo $student_data->phone; }else{ echo "N/A"; } ?></label>
										</div>
										<div class="col-xl-3 col-md-3 col-sm-12 margin_top_15px">
											<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('Alt. Mobile Number', 'school-mgt'); ?> </label><br>
											<label class="view_page_content_labels"><?php if(!empty($student_data->alternet_mobile_number)){ ?>+<?php echo mj_smgt_get_countery_phonecode(get_option( 'smgt_contry' ));?>&nbsp;<?php echo $student_data->alternet_mobile_number; }else{ echo "N/A"; } ?></label>
										</div>
										<div class="col-xl-3 col-md-3 col-sm-12 margin_top_15px">
											<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('Gender', 'school-mgt'); ?> </label><br>
											<label class="view_page_content_labels">
												<?php 
												if($student_data->gender=='male') 
													echo esc_attr__('Male','school-mgt');
												elseif($student_data->gender=='female') 
													echo esc_attr__('Female','school-mgt');
												?>
											</label>
										</div>
										<div class="col-xl-3 col-md-3 col-sm-12 margin_top_15px">
											<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('Date of Birth', 'school-mgt'); ?> </label><br>
											<label class="view_page_content_labels"><?php echo mj_smgt_getdate_in_input_box($student_data->birth_date); ?></label>
										</div>
										<div class="col-xl-3 col-md-3 col-sm-12 margin_top_15px">
											<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('City', 'school-mgt'); ?> </label><br>
											<label class="view_page_content_labels"><?php echo $student_data->city; ?></label>
										</div>
										<div class="col-xl-3 col-md-3 col-sm-12 margin_top_15px">
											<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('State', 'school-mgt'); ?> </label><br>
											<label class="view_page_content_labels"><?php if(!empty($student_data->state)){ echo $student_data->state; }else{ echo "N/A"; } ?></label>
										</div>
										<div class="col-xl-3 col-md-3 col-sm-12 address_rs_css margin_top_15px">
											<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('Zipcode', 'school-mgt'); ?> </label><br>
											<label class="view_page_content_labels"><?php echo $student_data->zip_code; ?></label>
										</div>
									</div>
								</div>	
							</div>
							<div class="col-xl-12 col-md-12 col-sm-12 margin_top_20px margin_top_15px_rs">
								<div class="guardian_div parent_information_div_overflow">
									<label class="view_page_label_heading"> <?php esc_html_e('Parent Information', 'school-mgt'); ?> </label>
									<?php
									if(!empty($user_meta))
									{
										
										foreach($user_meta as $parentsdata)
										{
											$parent=get_userdata($parentsdata);
											// if(!empty($parent))
											// {
												// var_dump($user_meta);
												?>
												<div class="row">
													<div class="col-xl-3 col-md-3 col-sm-12 margin_top_15px">
														<p class="view_page_header_labels"><?php esc_attr_e('Name','school-mgt'); ?></p>
														<p class="view_page_content_labels"><a class="color_black" href="admin.php?page=smgt_parent&tab=view_parent&action=view_parent&parent_id=<?php echo $parent->ID;?>"><?php echo $parent->first_name." ".$parent->last_name; ?></a></p>
													</div>		
													<div class="col-xl-4 col-md-4 col-sm-12 margin_top_15px">
														<p class="view_page_header_labels"><?php esc_attr_e('Email','school-mgt'); ?></p>
														<p class="view_page_content_labels"><?php echo $parent->user_email; ?></p>
													</div>		
													<div class="col-xl-3 col-md-3 col-sm-12 margin_top_15px">
														<p class="view_page_header_labels"><?php esc_attr_e('Mobile No.','school-mgt'); ?></p>
														<p class="view_page_content_labels">+<?php echo mj_smgt_get_countery_phonecode(get_option( 'smgt_contry' ));?>&nbsp;&nbsp;<?php echo $parent->mobile_number;?></p>
													</div>	
													<div class="col-xl-2 col-md-2 col-sm-12 margin_top_15px">
														<p class="view_page_header_labels"><?php esc_attr_e('Relation','school-mgt'); ?></p>
														<p class="view_page_content_labels"><?php if($parent->relation=='Father'){ echo esc_attr__('Father','school-mgt'); }elseif($parent->relation=='Mother'){ echo esc_attr__('Mother','school-mgt');} ?></p>
													</div>			
												</div>
												<?php
											// }
										}
									}
									else
									{
										?>
										<div class="col-xl-12 col-md-12 col-sm-12 margin_top_15px" style="text-align: center;">
											<p class="view_page_content_labels"><?php echo esc_attr__('No Any Parent.','school-mgt'); ?></p>
										</div>	
										<?php	
									}
									?>
								</div>	
							</div>
						</div>
						<!-- other information div start  -->
						<!-- Fees Payment Card Div Start  -->
						<div class="col-xl-4 col-md-4 col-sm-12 margin_top_20px margin_top_15px_rs">
							<div class="col-xl-12 col-md-12 col-sm-12">
								<div class="view_card detail_page_card">
									<div class="card_heading">
										<label class="card_heading_label"><?php esc_html_e('Fees Payment', 'school-mgt'); ?> </label>
									</div>
									<div class="events">
										<?php								
										$feespayment = mh_smgt_feespayment_detail($student_id);
									
										if(!empty($feespayment))
										{
											$i=0;
											foreach ($feespayment as $retrieved_data)
											{		
												if($i == 0)
												{
													$color_class='smgt_assign_bed_color0';
												}
												elseif($i == 1)
												{
													$color_class='smgt_assign_bed_color1';

												}
												elseif($i == 2)
												{
													$color_class='smgt_assign_bed_color2';

												}
												elseif($i == 3)
												{
													$color_class='smgt_assign_bed_color3';

												}
												elseif($i == 4)
												{
													$color_class='smgt_assign_bed_color4';

												}
												?>		
												<div class="calendar-event feespayment_detailpage_div"> 
													<p class="remainder_title Bold viewbedlist show_task_event date_font_size" id="<?php echo esc_attr($retrieved_data->fees_pay_id); ?>" model="Feespayment Details" style=""> 	  
														<label for="" class="date_assignbed_label">
														<?php
														echo mj_smgt_get_currency_symbol().''.$retrieved_data->total_amount;
														?>
														</label>
														<span class=" <?php echo $color_class; ?>"></span>
													</p>
													<p class="remainder_date assignbed_name assign_bed_name_size">
													<?php
														$student_data =	MJ_smgt_get_user_detail_byid($retrieved_data->student_id);	
														echo esc_html($student_data['first_name']." ".$student_data['last_name']);
													?>	
													</p>
													<p class="remainder_date assign_bed_date assign_bed_name_size">
													<?php echo mj_smgt_getdate_in_input_box($retrieved_data->created_date); ?>
													</p>
												</div>							
												
												<?php
												$i++;
											}
										}
										else
										{
											?>
											<div class="calendar-event-new"> 
												<img class="no_data_img" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >
											</div>	
											<?php
										}	
										?>
									</div>	
								</div>	
							</div> 
						</div> 
					</div>
					
					<?php
					$hostel_data = mj_smgt_student_assign_bed_data_by_student_id($student_id);
					$room_data='';
					if(!empty($hostel_data))
					{
						$room_data = mj_smgt_get_room__data_by_room_id($hostel_data->room_id);
					}
				
					$student_data_for_sibling = get_userdata($student_id);
					?>
					<!--------- Other student Imformation -------------->
					<div class="row margin_top_20px">
						<?php
						$sibling_data = $student_data_for_sibling->sibling_information;
						$sibling = json_decode($sibling_data);
						if(!empty($student_data_for_sibling->sibling_information))
						{ 
							foreach ($sibling as $value) 
							{
								if(!empty($value->siblingsclass) && !empty($value->siblingsstudent))
								{
									?>
									<div class="col-xl-6 col-md-6 col-sm-12">
										<div class="col-xl-12 col-md-12 col-sm-12 margin_top_20px">
											<div class="guardian_div">
												<label class="view_page_label_heading"> <?php esc_html_e('Sibling Information', 'school-mgt'); ?> </label>
												<div class="row">
													<div class="col-xl-5 col-md-5 col-sm-12 margin_top_15px">
														<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('Name', 'school-mgt'); ?> </label> <br>
														<label class="view_page_content_labels"><a class="color_black" href="?page=smgt_student&tab=view_student&action=view_student&student_id=<?php echo $value->siblingsstudent;?>"><?php echo mj_smgt_get_user_name_byid($value->siblingsstudent); ?>-<?php echo get_user_meta($value->siblingsstudent, 'roll_id',true);?></a></label>
													</div>
													<div class="col-xl-4 col-md-4 col-sm-12 margin_top_15px">
														<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('Class Name', 'school-mgt'); ?> </label> <br>
														<label class="view_page_content_labels"><?php echo mj_smgt_get_class_name($value->siblingsclass); ?></label>
													</div>
													<div class="col-xl-3 col-md-3 col-sm-12 margin_top_15px">
														<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('Section Name', 'school-mgt'); ?> </label> <br>
														<label class="view_page_content_labels"><?php if(!empty($value->siblingssection)){ echo mj_smgt_get_section_name($value->siblingssection); }else{ echo "N/A"; } ?></label>
													</div>
												</div>
											</div>	
										</div>
									</div>
									<?php
								}
							}
						}
						if(!empty($hostel_data))
						{
							?>
							<div class="col-xl-6 col-md-6 col-sm-12">
								<div class="col-xl-12 col-md-12 col-sm-12 margin_top_20px">
									<div class="guardian_div">
										<label class="view_page_label_heading"> <?php esc_html_e('Hostel Information', 'school-mgt'); ?> </label>
										<div class="row">
											<div class="col-xl-4 col-md-4 col-sm-12 margin_top_15px">
												<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('Hostel Name', 'school-mgt'); ?> </label> <br>
												<label class="view_page_content_labels"><?php if(!empty($hostel_data)){ if($hostel_data->hostel_id){ echo mj_smgt_hostel_name_by_id($hostel_data->hostel_id); }else{ echo "N/A"; } }else{ echo "N/A"; } ?></label>
											</div>
											<div class="col-xl-4 col-md-4 col-sm-12 margin_top_15px">
												<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('Hostel Type', 'school-mgt'); ?> </label> <br>
												<label class="view_page_content_labels"><?php if(!empty($hostel_data)){ if($hostel_data->hostel_id){ echo mj_smgt_hostel_type_by_id($hostel_data->hostel_id); }else{ echo "N/A"; } }else{ echo "N/A"; } ?></label>
											</div>
											<div class="col-xl-4 col-md-4 col-sm-12 margin_top_15px">
												<label class="guardian_labels view_page_header_labels"> <?php esc_html_e('Room Name', 'school-mgt'); ?> </label> <br>
												<label class="view_page_content_labels"><?php if(!empty($room_data)){ if($room_data->room_unique_id){ echo $room_data->room_unique_id; }else{ echo "N/A"; } }else{ echo "N/A"; } ?></label>
											</div>
										</div>
									</div>	
								</div>
							</div>
							<?php
						}
						if(!empty($user_custom_field))
						{
							?>
							<div class="col-xl-6 col-md-6 col-sm-6 margin_top_20px margin_top_15px_rs">
								<div class="guardian_div">
									<label class="view_page_label_heading"> <?php esc_html_e('Other Information', 'school-mgt'); ?> </label>
									<div class="row">
										<?php
										foreach($user_custom_field as $custom_field)
										{
											$custom_field_id=$custom_field->id;
											$module_record_id=$_REQUEST['student_id'];
											$custom_field_value=$custom_field_obj->mj_smgt_get_single_custom_field_meta_value($module,$module_record_id,$custom_field_id);
											?>
											<div class="col-xl-3 col-md-3 col-sm-12 margin_top_15px">
												<p class="view_page_header_labels"><?php esc_attr_e(''.$custom_field->field_label.'','school-mgt'); ?></p>
												<?php
												if($custom_field->field_type =='date')
												{	
													?>
													<p class="view_page_header_labels"><?php if(!empty($custom_field_value)){ echo mj_smgt_getdate_in_input_box($custom_field_value); }else{ echo 'N/A'; } ?></p>
													<?php
												}
												elseif($custom_field->field_type =='file')
												{
													if(!empty($custom_field_value))
													{
														?>
														<!-- <a target="blank" href="<?php echo content_url().'/uploads/school_assets/'.$custom_field_value;?>"><button class="btn btn-default view_document" type="button">
														<i class="fa fa-eye"></i> <?php esc_attr_e('View','school-mgt');?></button></a> -->
															
														<a target="" href="<?php echo content_url().'/uploads/school_assets/'.$custom_field_value;?>" download="CustomFieldfile"><button class="btn btn-default view_document" type="button">
														<i class="fa fa-download"></i> <?php esc_attr_e('Download','school-mgt');?></button></a>
														
														<?php 
													}
													else
													{
														echo 'N/A';
													}
												}
												else
												{
													?>
													<p class="user-info"><?php if(!empty($custom_field_value)){ echo $custom_field_value; }else{ echo 'N/A'; } ?></p>
													<?php		
												}
												?>
											</div>		
											<?php
										}
										?>
									</div>
								</div>	
							</div>
							<?php
						}
						?>
					</div>
					<!--------- Other student Imformation End -------------->
					<?php
				}

				// prents tab start 
				elseif($active_tab1 == "parent")
				{
					if(!empty($user_meta))
					{
						?>
						<script type="text/javascript">
							jQuery(document).ready(function($)
							{
								"use strict";	
								jQuery('#parents_list_detailpage').DataTable({
									responsive: true,
									"order": [[ 1, "asc" ]],
									"responsive": true,
									dom: '<"float-right"f>rt<"row"<"col-sm-1"l><"col-sm-8"i><"col-sm-3"p>>',
									"aoColumns":[	                  
												{"bSortable": false},
												{"bSortable": false},
												{"bSortable": true},
												{"bSortable": true}],
									language:<?php echo mj_smgt_datatable_multi_language();?>
								});
								$('.dataTables_filter').addClass('search_btn_view_page');
								$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'school-mgt') ?>");
							});
						</script>
						<div class="">
							<div id="Section1" class="">
								<div class="row">
									<div class="col-lg-12">
										<div class="">
											<div class="card-content">
												<div class="table-responsive">
													<table id="parents_list_detailpage" class="display table" cellspacing="0" width="100%">
														<thead class="<?php echo MJ_smgt_datatable_heder() ?>">
															<tr>
																<th><?php  _e( 'Photo', 'school-mgt' ) ;?></th>
																<th><?php echo esc_attr_e( 'Parent Name & Email', 'school-mgt' ) ;?></th>
																<th> <?php esc_attr_e( 'Mobile Number', 'school-mgt' ) ;?></th>
																<th> <?php echo esc_attr_e( 'Relation', 'school-mgt' ) ;?></th>
															</tr>
														</thead>
														<tbody>
															<?php
															if(!empty($user_meta))
															{
																foreach($user_meta as $parentsdata)
																{
																	if(!empty($parentsdata->errors))
																	{
																		$parent = "";
																	}
																	else
																	{
																		$parent=get_userdata($parentsdata);
																	}
					
																	if (!empty($parent)) 
																	{
																		
																		?>
																	
																		<tr>
																			<td class="width_50px"><?php 
																				if($parentsdata)
																				{
																					$umetadata=mj_smgt_get_user_image($parentsdata);
																				}
																				if(empty($umetadata))
																				{
																					echo '<img src='.get_option( 'smgt_parent_thumb_new' ).' height="50px" width="50px" class="img-circle" />';
																				}
																				else
																					echo '<img src='.$umetadata.' height="50px" width="50px" class="img-circle"/>';?>
																			</td>
																			<td class="name">
																				<a class="color_black" href="admin.php?page=smgt_parent&tab=view_parent&action=view_parent&parent_id=<?php echo $parent->ID;?>">
																					<?php echo $parent->first_name." ".$parent->last_name;?>
																				</a>
																				<br>
																				<label class="list_page_email"><?php echo $parent->user_email;?></label>
																			</td>
																			<td>+<?php echo mj_smgt_get_countery_phonecode(get_option( 'smgt_contry' ));?>&nbsp;&nbsp;<?php echo $parent->mobile_number;?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Mobile Number','school-mgt');?>" ></i></td>
																		
																			<td><?php if($parent->relation=='Father'){ echo esc_attr__('Father','school-mgt'); }elseif($parent->relation=='Mother'){ echo esc_attr__('Mother','school-mgt');} ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Relation','school-mgt');?>" ></i></td>
																		</tr>
																		<?php
																	}
																}
															}
															?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php
					}
					else
					{
						?>
						<div class="no_data_list_div"> 
							<a href="<?php echo admin_url().'admin.php?page=smgt_parent&tab=addparent';?>">
								<img class="col-md-12 width_100px" src="<?php echo get_option( 'smgt_no_data_img' ) ?>" >
							</a>
							<div class="col-md-12 dashboard_btn margin_top_20px">
								<label class="no_data_list_label"><?php esc_html_e('Tap on above icon to add your first Record.','school-mgt'); ?> </label>
							</div> 
						</div>		
						<?php
					}
				}

				// feespayment tab start 
				elseif($active_tab1 == "feespayment")
				{
					$fees_payment  = mj_smgt_get_fees_payment_detailpage($student_id);
					if(!empty($fees_payment))
					{
						?>
						<div class="popup-bg">
							<div class="overlay-content">
								<div class="modal-content">
									<div class=" invoice_data"></div>
									<div class="category_list">
									</div>     
								</div>
							</div>
						</div>
						<script type="text/javascript">
							jQuery(document).ready(function($) {
								"use strict";
								jQuery('#feespayment_list_detailpage').DataTable({
									"responsive": true,
									"order": [[ 1, "desc" ]],
									"aoColumns":[	                  
												{"bSortable": false},
												{"bSortable": true},
												{"bSortable": true},
												{"bSortable": true},
												{"bSortable": true},
												{"bSortable": true},
												{"bSortable": true},
												{"bSortable": true},
												{"bSortable": true}],
									dom: '<"float-right"f>rt<"row"<"col-sm-1"l><"col-sm-8"i><"col-sm-3"p>>',
									language:<?php echo mj_smgt_datatable_multi_language();?>
									});
									$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'school-mgt') ?>");
								$('.dataTables_filter').addClass('search_btn_view_page');
							} );
						</script>
				
						<div class="table-div"><!-- PANEL BODY DIV START -->
							<div class="table-responsive"><!-- TABLE RESPONSIVE DIV START -->
								<table id="feespayment_list_detailpage" class="display" cellspacing="0" width="100%">
									<thead class="<?php echo MJ_smgt_datatable_heder() ?>">
										<tr>
											<th><?php  _e( 'Image', 'school-mgt' ) ;?></th>
											<th><?php esc_attr_e('Fees Type','school-mgt');?></th>  
											<th><?php esc_attr_e('Student Name & Roll No.','school-mgt');?></th>
											<th><?php esc_attr_e('Section Name','school-mgt');?></th>  
											<th><?php esc_attr_e('Total Amount','school-mgt');?> </th>  
											<th><?php esc_attr_e('Paid Amount','school-mgt');?> </th>  
											<th><?php esc_attr_e('Due Amount','school-mgt'); ?></th>
											<th><?php esc_attr_e('Payment Status','school-mgt');?></th>
											<th><?php esc_attr_e('Start Year To End Year','school-mgt');?></th>
										</tr>
									</thead>
									<tbody>
										<?php
										$i=0;	
										if(!empty($fees_payment))
										{
											foreach ($fees_payment as $retrieved_data)
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
												<?php 
												$Due_amt = $retrieved_data->total_amount-$retrieved_data->fees_paid_amount;
												$due_amount=number_format($Due_amt,2);
												?>
												<tr>
													<td class="cursor_pointer user_image width_50px profile_image_prescription">
														<p class="remainder_title_pr Bold prescription_tag <?php echo $color_class; ?>">	
															<img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Payment.png"?>" alt="" class="massage_image center">
														</p>
													</td>
													<td class="cursor_pointer">
														<a  href="?page=smgt_fees_payment&tab=view_fesspayment&idtest=<?php echo $retrieved_data->fees_pay_id; ?>&view_type=view_payment">
														<?php 
														$fees_id=explode(',',$retrieved_data->fees_id);
														$fees_type=array();
														foreach($fees_id as $id)
														{ 
															$fees_type[] = mj_smgt_get_fees_term_name($id);
														}
														echo implode(" , " ,$fees_type);	
															?></a> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Fees Type','school-mgt');?>"></i>
													</td>
													<td><?php echo mj_smgt_get_user_name_byid($retrieved_data->student_id);?>-<?php echo get_user_meta($retrieved_data->student_id, 'roll_id',true);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Student Name & Roll No.','school-mgt');?>"></i></td>
													<td class="name"><?php if($retrieved_data->section_id!=0){ echo mj_smgt_get_section_name($retrieved_data->section_id); }else { esc_attr_e('No Section','school-mgt');}?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Section Name','school-mgt');?>"></i></td>
													
													<td><?php echo "<span> ". mj_smgt_get_currency_symbol() ." </span>" . number_format($retrieved_data->total_amount,2); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Total Amount','school-mgt');?>"></i></td>
													<td class="department"><?php echo "<span> ". mj_smgt_get_currency_symbol() ." </span>" . number_format($retrieved_data->fees_paid_amount,2); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Paid Amount','school-mgt');?>"></i></td>
													<?php 
													$Due_amt = $retrieved_data->total_amount-$retrieved_data->fees_paid_amount;
													$due_amount=number_format($Due_amt,2);
													?>
													<td><?php echo "<span> ". mj_smgt_get_currency_symbol() ." </span>" .$due_amount; ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Due Amount','school-mgt');?>"></i></td>
													<td>
														<?php 
														$smgt_get_payment_status=mj_smgt_get_payment_status($retrieved_data->fees_pay_id);
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
														?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Payment Status','school-mgt');?>"></i>
													</td>
													<td><?php echo $retrieved_data->start_year.'-'.$retrieved_data->end_year;?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Start Year To End Year','school-mgt');?>"></i></td>
												</tr>
												<?php 
												$i++;	
											}	 
										}
										?>
									</tbody>
								</table>
								
							</div><!-- TABLE RESPONSIVE DIV END -->
						</div>
						<?php
					}
					else
					{
						$page_1='feepayment';
						$feepayment_1 = mj_smgt_get_userrole_wise_filter_access_right_array($page_1);
						if($role == 'admin' || $feepayment_1['add']=='1')
						{
							?>
							<div class="no_data_list_div"> 
								<a href="<?php echo admin_url().'admin.php?page=smgt_fees_payment&tab=addpaymentfee';?>">
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

				// attendance tab start 
				elseif($active_tab1 == "attendance")
				{
					$attendance_list = mj_smgt_monthly_attendence($student_id);
					if(!empty($attendance_list))
					{
						?>
						<script type="text/javascript">
							jQuery(document).ready(function($) {
								"use strict";
								jQuery('#attendance_list_detailpage').DataTable({
									"responsive": true,
									"order": [[ 1, "desc" ]],
									"aoColumns":[	                  
												{"bSortable": false},
												{"bSortable": true},
												{"bSortable": true},
												{"bSortable": true},
												{"bSortable": true},
												{"bSortable": true},
												{"bSortable": true},
												{"bSortable": true}],
									dom: '<"float-right"f>rt<"row"<"col-sm-1"l><"col-sm-8"i><"col-sm-3"p>>',
									language:<?php echo mj_smgt_datatable_multi_language();?>
									});
									$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'school-mgt') ?>");
								$('.dataTables_filter').addClass('search_btn_view_page');
							} );
						</script>
				
						<div class="table-div"><!-- PANEL BODY DIV START -->
							<div class="table-responsive"><!-- TABLE RESPONSIVE DIV START -->
								<table id="attendance_list_detailpage" class="display" cellspacing="0" width="100%">
									<thead class="<?php echo MJ_smgt_datatable_heder() ?>">
										<tr>
											<th><?php  _e( 'Image', 'school-mgt' ) ;?></th>
											<th><?php esc_attr_e('Number','school-mgt');?></th>  
											<th><?php esc_attr_e('Student Name & Roll No.','school-mgt');?></th>
											<th><?php esc_attr_e('Class Name','school-mgt');?></th>  
											<th><?php esc_attr_e('Attendance Date','school-mgt');?> </th>  
											<th><?php esc_attr_e('Day','school-mgt');?> </th>  
											<th><?php esc_attr_e('Status','school-mgt'); ?></th>
											<th><?php esc_attr_e('Comment','school-mgt');?></th>
										</tr>
									</thead>
									<tbody>
										<?php 
										$i=0;	
										$srno = 1;
										if(!empty($attendance_list))
										{
											foreach ($attendance_list as $retrieved_data)
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
													<td class="user_image width_50px profile_image_prescription">
														<p class="remainder_title_pr Bold prescription_tag <?php echo $color_class; ?>">	
															<img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Attendance.png"?>" alt="" class="massage_image center">
														</p>
													</td>
													<td><?php echo $srno;?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Number','school-mgt');?>"></i></td>
													<td class="department"><?php echo mj_smgt_get_user_name_byid($retrieved_data->user_id);?>-<?php echo get_user_meta($retrieved_data->user_id, 'roll_id',true);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Student Name & Roll No.','school-mgt');?>"></i></td>
													<td class="">
														<?php echo mj_smgt_get_class_name($retrieved_data->class_id); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Class Name','school-mgt');?>"></i>
													</td>
													<?php $curremt_date=mj_smgt_getdate_in_input_box($retrieved_data->attendence_date); $day=date("D", strtotime($curremt_date)); ?>
													<td class="name"><?php echo mj_smgt_getdate_in_input_box($retrieved_data->attendence_date); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Attendance Date','school-mgt');?>"></i></td>
													<td class="department"><?php 
													if($day == 'Mon')
													{
														esc_html_e('Monday','school-mgt');
													}  
													elseif($day == 'Sun')
													{
														esc_html_e('Sunday','school-mgt');
													} 
													elseif($day == 'Tue')
													{
														esc_html_e('Tuesday','school-mgt');
													}
													elseif($day == 'Wed')
													{
														esc_html_e('Wednesday','school-mgt');
													}
													elseif($day == 'Thu')
													{
														esc_html_e('Thursday','school-mgt');
													}
													elseif($day == 'Fri')
													{
														esc_html_e('Friday','school-mgt');
													}
													elseif($day == 'Sat')
													{
														esc_html_e('Saturday','school-mgt');
													}
													?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Day','school-mgt');?>"></i></td>
													<td><?php echo esc_html_e($retrieved_data->status,'school-mgt'); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Status','school-mgt');?>"></i></td>
													<?php
													$comment =$retrieved_data->comment;
													$comment_out = strlen($comment) > 30 ? substr($comment,0,30)."..." : $comment;
													?>
													<td class="width_20"><?php if(!empty($retrieved_data->comment)){ echo esc_html_e($comment_out); }else{ echo "N/A"; } ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Comment','school-mgt');?>"></i></td>
												</tr>
												<?php 
												$i++;	
												$srno++;
											}	 
										}
										?>
									</tbody>
								</table>
								
							</div><!-- TABLE RESPONSIVE DIV END -->
						</div>
						<?php
					}
					else
					{
						$page_1='attendance';
						$fattendance_1 = mj_smgt_get_userrole_wise_filter_access_right_array($page_1);
						if($role == 'admin' || $fattendance_1['add']=='1')
						{
							?>
							<div class="no_data_list_div"> 
								<a href="<?php echo admin_url().'admin.php?page=smgt_attendence';?>">
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

				// hallticket tab start 
				elseif($active_tab1 == "hallticket")
				{
					$hall_ticket = mj_smgt_hallticket_list($student_id);
					if(!empty($hall_ticket))
					{
						?>
						<script type="text/javascript">
							jQuery(document).ready(function($) {
								"use strict";
								jQuery('#hall_ticket_detailpage').DataTable({
									"responsive": true,
									"order": [[ 1, "desc" ]],
									"aoColumns":[	                  
												{"bSortable": false},
												{"bSortable": true},
												{"bSortable": true},
												{"bSortable": true},
												{"bSortable": true},
												{"bSortable": true},
												{"bSortable": true}],
									dom: '<"float-right"f>rt<"row"<"col-sm-1"l><"col-sm-8"i><"col-sm-3"p>>',
									language:<?php echo mj_smgt_datatable_multi_language();?>
									});
									$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'school-mgt') ?>");
								$('.dataTables_filter').addClass('search_btn_view_page');
							} );
						</script>
					
						<div class="table-div"><!-- PANEL BODY DIV START -->
							<div class="table-responsive"><!-- TABLE RESPONSIVE DIV START -->
								<table id="hall_ticket_detailpage" class="display" cellspacing="0" width="100%">
									<thead class="<?php echo MJ_smgt_datatable_heder() ?>">
										<tr>
											<th><?php  _e( 'Image', 'school-mgt' ) ;?></th>
											<th><?php esc_attr_e('Hall Name','school-mgt');?></th>  
											<th><?php esc_attr_e('Student Name & Roll No.','school-mgt');?></th>
											<th><?php esc_attr_e('Exam Name','school-mgt');?></th>  
											<th><?php esc_attr_e('Exam Term','school-mgt');?> </th>  
											<th><?php esc_attr_e('Exam Start To End Date','school-mgt');?> </th>  
											<th><?php esc_attr_e('Action','school-mgt'); ?></th>
										</tr>
									</thead>
									<tbody>
										<?php 
										
										$i=0;	
										if(!empty($hall_ticket))
										{
											
											foreach ($hall_ticket as $retrieved_data)
											{
												$exam_data= mj_smgt_get_exam_by_id($retrieved_data->exam_id);
												$start_date=$exam_data->exam_start_date;
												$end_date=$exam_data->exam_end_date; 
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
													<td class="user_image width_50px profile_image_prescription">
														<p class="remainder_title_pr Bold prescription_tag <?php echo $color_class; ?>">	
															<img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/White_icons/Exam_hall.png"?>" alt="" class="massage_image center image_icon_height_25px">
														</p>
													</td>
													<td><?php echo mj_smgt_get_hall_name($retrieved_data->hall_id);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Hall Name','school-mgt');?>"></i></td>
													<td class="department"><?php echo mj_smgt_get_user_name_byid($retrieved_data->user_id);?>-<?php echo get_user_meta($retrieved_data->user_id, 'roll_id',true);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Student Name & Roll No.','school-mgt');?>"></i></td>
													<td class="name"><?php echo mj_smgt_get_exam_name_id($retrieved_data->exam_id); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Exam Name','school-mgt');?>"></i></td>
													<td class="department"><?php echo get_the_title($exam_data->exam_term); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Exam Term','school-mgt');?>"></i></td>
													<td class="department"><?php echo mj_smgt_getdate_in_input_box($start_date); ?><?php echo esc_html_e(" To ","school-mgt"); ?><?php echo mj_smgt_getdate_in_input_box($end_date); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Exam Start To End Date','school-mgt');?>"></i></td>
													<td class="action"> 
														<div class="smgt-user-dropdown">
															<ul class="" style="margin-bottom: 0px !important;">
																<li class="">
																	<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">
																		<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >
																	</a>
																	<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">
																	
																		<li class="float_left_width_100">
																			<a href="?page=smgt_student&student_exam_receipt=student_exam_receipt&student_id=<?php echo $retrieved_data->user_id;?>&exam_id=<?php echo $retrieved_data->exam_id;?>" target="_blank" class="float_left_width_100"><i class="fa fa-eye"> </i><?php esc_html_e('Print', 'school-mgt' ) ;?> </a>
																		</li>
																		<li class="float_left_width_100">
																			<a href="?page=smgt_student&student_exam_receipt_pdf=student_exam_receipt_pdf&student_id=<?php echo $retrieved_data->user_id;?>&exam_id=<?php echo $retrieved_data->exam_id;?>" target="_blank" class="float_left_width_100"><i class="fa fa-bar-chart"> </i><?php esc_attr_e('PDF', 'school-mgt');?></a>
																		</li>
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
								
							</div><!-- TABLE RESPONSIVE DIV END -->
						</div>
						<?php
					}
					else
					{
						$page_1='exam_hall';
						$exam_hall_1 = mj_smgt_get_userrole_wise_filter_access_right_array($page_1);
						if($role == 'admin' || $exam_hall_1['add']=='1')
						{
							?>
							<div class="no_data_list_div"> 
								<a href="<?php echo admin_url().'admin.php?page=smgt_hall&tab=exam_hall_receipt';?>">
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

				// homework tab start 
				elseif($active_tab1 == "homework")
				{
					?>
					<div class="popup-bg">
						<div class="overlay-content">
							<div class="modal-content">
								<div class="view_popup"></div>     
							</div>
						</div>    
					</div>
					<?php
					$student_homework=mj_smgt_student_homework_detail($student_id);
					if(!empty($student_homework))
					{
						?>
						<script type="text/javascript">
							jQuery(document).ready(function($) {
								"use strict";
								jQuery('#homework_detailpage').DataTable({
									"responsive": true,
									"order": [[ 1, "desc" ]],
									"aoColumns":[	                  
												{"bSortable": false},
												{"bSortable": true},
												{"bSortable": true},
												{"bSortable": true},
												{"bSortable": true},
												{"bSortable": true},
												{"bSortable": true}],
									dom: '<"float-right"f>rt<"row"<"col-sm-1"l><"col-sm-8"i><"col-sm-3"p>>',
									language:<?php echo mj_smgt_datatable_multi_language();?>
									});
									$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'school-mgt') ?>");
								$('.dataTables_filter').addClass('search_btn_view_page');
							} );
						</script>
					
						<div class="table-div"><!-- PANEL BODY DIV START -->
							<div class="table-responsive"><!-- TABLE RESPONSIVE DIV START -->
								<table id="homework_detailpage" class="display" cellspacing="0" width="100%">
									<thead class="<?php echo MJ_smgt_datatable_heder() ?>">
										<tr>
											<th><?php  _e( 'Image', 'school-mgt' ) ;?></th>
											<th><?php esc_attr_e('Homework Title','school-mgt');?></th>
											<th><?php esc_attr_e('Class Name','school-mgt');?></th>
											<th><?php esc_attr_e('Subject Name','school-mgt');?></th>
											<th><?php esc_attr_e('Status','school-mgt');?></th>
											<th><?php esc_attr_e('Submission Date','school-mgt');?></th>
											<th><?php esc_attr_e('Homework Date','school-mgt');?></th>
										</tr>
									</thead>
									<tbody>
										<?php 
										
										$i=0;	
										if(!empty($student_homework))
										{
											foreach ($student_homework as $retrieved_data)
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
													<td class="user_image width_50px profile_image_prescription">
														<p class="remainder_title_pr Bold prescription_tag <?php echo $color_class; ?>">	
															<img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/homework.png"?>" alt="" class="massage_image center image_icon_height_25px">
														</p>
													</td>
													<td class="cursor_pointer view_details_popup" type="Homework_view" id="<?php echo $retrieved_data->homework_id;?>"><?php echo $retrieved_data->title;?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Homework Title','school-mgt');?>"></i></td>
													<td><?php echo mj_smgt_get_class_name($retrieved_data->class_name);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Class Name','school-mgt');?>"></i></td>  
													<td><?php echo mj_smgt_get_single_subject_name($retrieved_data->subject);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Subject Name','school-mgt');?>"></i></td>
													<?php
												
													if($retrieved_data->uploaded_date == NULL)
													{
													?>
													<td><label class="red_color"><?php esc_attr_e('Pending','school-mgt'); ?></label> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Status','school-mgt');?>"></i></td>
													<?php
													}
													elseif($retrieved_data->uploaded_date <= $retrieved_data->submition_date)
													{
													?><td><label class="green_color"><?php esc_attr_e('Submitted','school-mgt');?></label> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Status','school-mgt');?>"></i></td><?php
													}
													else
													{
														?><td><label class="perpal_color"><?php esc_attr_e('Late Submitted','school-mgt');?></label> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Status','school-mgt');?>"></i></td><?php
													}
												
													?>
													<td><?php echo mj_smgt_getdate_in_input_box($retrieved_data->submition_date);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Submission Date','school-mgt');?>"></i></td>
													<td><?php echo mj_smgt_getdate_in_input_box($retrieved_data->created_date);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Homework Date','school-mgt');?>"></i></td>
													
												</tr>
												<?php 
												$i++;	
											}	 
										}
										?>
									</tbody>
								</table>
								
							</div><!-- TABLE RESPONSIVE DIV END -->
						</div>
						<?php
					}
					else
					{
						$page_1='homework';
						$homework_1 = mj_smgt_get_userrole_wise_filter_access_right_array($page_1);
						if($role == 'admin' || $homework_1['add']=='1')
						{
							?>
							<div class="no_data_list_div"> 
								<a href="<?php echo admin_url().'admin.php?page=smgt_student_homewrok&tab=addhomework';?>">
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

				// issuebooks tab start 
				elseif($active_tab1 == "issuebook")
				{
					$student_issuebook=mj_smgt_student_issuebook_detail($student_id);
					if(!empty($student_issuebook))
					{
						?>
						<script type="text/javascript">
							jQuery(document).ready(function($) {
								"use strict";
								jQuery('#issuebook_detailpage').DataTable({
									"responsive": true,
									"order": [[ 1, "desc" ]],
									"aoColumns":[	                  
												{"bSortable": false},
												{"bSortable": true},
												{"bSortable": true},
												{"bSortable": true},
												{"bSortable": true},
												{"bSortable": true},
												{"bSortable": true}],
									dom: '<"float-right"f>rt<"row"<"col-sm-1"l><"col-sm-8"i><"col-sm-3"p>>',
									language:<?php echo mj_smgt_datatable_multi_language();?>
									});
									$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'school-mgt') ?>");
								$('.dataTables_filter').addClass('search_btn_view_page');
							} );
						</script>
					
						<div class="table-div"><!-- PANEL BODY DIV START -->
							<div class="table-responsive"><!-- TABLE RESPONSIVE DIV START -->
								<table id="issuebook_detailpage" class="display" cellspacing="0" width="100%">
									<thead class="<?php echo MJ_smgt_datatable_heder() ?>">
										<tr>
											<th><?php  _e( 'Image', 'school-mgt' ) ;?></th>
											<th><?php esc_attr_e('Student Name & Roll No.','school-mgt');?></th>
											<th><?php esc_attr_e('Class Name','school-mgt');?></th>
											<th><?php esc_attr_e('Book Title','school-mgt');?></th>
											<th><?php esc_attr_e('Issue Date','school-mgt');?></th>
											<th><?php esc_attr_e('Expected Return Date','school-mgt');?></th>
											<th><?php esc_attr_e('Time Period','school-mgt');?></th>
										</tr>
									</thead>
									<tbody>
										<?php 
										$i=0;	
										if(!empty($student_issuebook))
										{
											foreach ($student_issuebook as $retrieved_data)
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
													<td class="user_image width_50px profile_image_prescription">
														<p class="remainder_title_pr Bold prescription_tag <?php echo $color_class; ?>">	
															<img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Library.png"?>" alt="" class="massage_image center image_icon_height_25px">
														</p>
													</td>
													<td class="department"><?php echo mj_smgt_get_user_name_byid($retrieved_data->student_id);?>-<?php echo get_user_meta($retrieved_data->student_id, 'roll_id',true);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Student Name & Roll No.','school-mgt');?>"></i></td>
													<td><?php echo mj_smgt_get_class_name($retrieved_data->class_id);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Class Name','school-mgt');?>"></i></td>
													<td><?php echo stripslashes(mj_smgt_get_bookname($retrieved_data->book_id));?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Book Title','school-mgt');?>"></i></td>
													<td><?php echo mj_smgt_getdate_in_input_box($retrieved_data->issue_date);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Issue Date','school-mgt');?>"></i></td>
													<td><?php echo mj_smgt_getdate_in_input_box($retrieved_data->end_date);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Expected Return Date','school-mgt');?>"></i></td>
													<td><?php echo get_the_title($retrieved_data->period);?><?php echo " Days"; ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Time Period','school-mgt');?>"></i></td>
													
												</tr>
												<?php 
												$i++;	
											}	 
										}
										?>
									</tbody>
								</table>
								
							</div><!-- TABLE RESPONSIVE DIV END -->
						</div>
						<?php
					}
					else
					{
						$page_1='smgt_library';
						$library_1 = mj_smgt_get_userrole_wise_filter_access_right_array($page_1);

						if($role == 'admin' || $library_1['add'] == '1')
						{
							?>
							<div class="no_data_list_div"> 
								<a href="<?php echo admin_url().'admin.php?page=smgt_library&tab=issuebook';?>">
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

				if($active_tab1 == "exam_result")
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
					// var_dump($all_exam);
					// die;
					if(!empty($all_exam))
					{
						?>
						<script type="text/javascript">
							jQuery(document).ready(function($) {
								"use strict";
								jQuery('#messages_detailpage').DataTable({
									"responsive": true,	
									"order": [[ 1, "desc" ]],
									"aoColumns":[	                  
												{"bSortable": false},
												{"bSortable": true},
												{"bSortable": true},
												{"bSortable": true},
												{"bSortable": false}],
									dom: '<"float-right"f>rt<"row"<"col-sm-1"l><"col-sm-8"i><"col-sm-3"p>>',
									language:<?php echo mj_smgt_datatable_multi_language();?>
									});
									$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'school-mgt') ?>");
								$('.dataTables_filter').addClass('search_btn_view_page');
							} );
						</script>
						<div class="table-div"><!-- PANEL BODY DIV START -->
							<div class="table-responsive"><!-- TABLE RESPONSIVE DIV START -->
								<table id="messages_detailpage" class="display" cellspacing="0" width="100%">
									<thead class="<?php echo MJ_smgt_datatable_heder() ?>">
										<tr>
											<th><?php  _e( 'Image', 'school-mgt' ) ;?></th>
											<th><?php esc_attr_e('Exam Name','school-mgt');?></th>
											<th><?php esc_attr_e('Start Date','school-mgt');?></th>
											<th><?php esc_attr_e('End Date','school-mgt');?></th>
											<th class="exam_exam"><?php esc_attr_e('Action','school-mgt');?></th>
										</tr>
									</thead>
									<tbody>
										<?php 
										// var_dump($all_exam);
										// die;
										$i=0;	
										if(!empty($all_exam))
										{
											foreach ($all_exam as $retrieved_data)
											{
												$exam_id =$retrieved_data->exam_id;
												// $sender_id=$retrieved_data->sender;
												// $sender=MJ_smgt_get_display_name($sender_id);
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
													<td class="user_image width_50px profile_image_prescription">
														<p class="remainder_title_pr Bold prescription_tag <?php echo $color_class; ?>">	
															<img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/White_icons/Exam_hall.png"?>" alt="" class="massage_image center image_icon_height_25px">
														</p>
													</td>
													<td class="subject_name width_20px">
														<label class=""><?php echo _e($retrieved_data->exam_name,"school-mgt"); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Exam Name','school-mgt');?>"></i></label>
													</td>
													<td class="department width_15px">
														<label class=""><?php echo mj_smgt_getdate_in_input_box($retrieved_data->exam_start_date); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Start Date','school-mgt');?>"></i></label>
													</td>
													<td class="department width_15px">
														<label class=""><?php echo mj_smgt_getdate_in_input_box($retrieved_data->exam_end_date); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('End Date','school-mgt');?>"></i></label>
													</td>
													<td class="department width_20px">
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
															<div class="col-md-12 row padding_left_50px  smt_view_result">
																<div class="col-md-2 width_50">
																	<a href="?page=smgt_student&print=pdf&student=<?php echo $uid;?>&exam_id=<?php echo $exam_id;?>" class="float_right" target="_blank"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/PDF.png"?>" alt=""></a>
																</div>
																<div class="col-md-2 width_50 rtl_margin_left_20px" style="margin-right:22px;">
																	<a href="?page=smgt_student&print=print&student=<?php echo $uid;?>&exam_id=<?php echo $exam_id;?>" class="float_right" target="_blank" ><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Print.png"?>" alt=""></a>
																</div>
															</div>
															<?php
														}
														?>
														<!-- <label class=""><?php echo $retrieved_data->exam_name; ?>  <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Subject','school-mgt');?>"></i></label> -->
													</td>
												</tr>
												<?php 
												$i++;	
											}	 
										}
										?>
									</tbody>
								</table>
							</div><!-- TABLE RESPONSIVE DIV END -->
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
				// Message Tab Start
				if($active_tab1 == "message")
				{
					$student_message=MJ_smgt_msg_detail($student_id);	
					if(!empty($student_message))
					{
						?>
						<script type="text/javascript">
							jQuery(document).ready(function($) {
								"use strict";
								jQuery('#messages_detailpage').DataTable({
									"responsive": true,
									"order": [[ 1, "desc" ]],
									"aoColumns":[	                  
												{"bSortable": false},
												{"bSortable": true},
												{"bSortable": true},
												{"bSortable": true},
												{"bSortable": true}],
									dom: '<"float-right"f>rt<"row"<"col-sm-1"l><"col-sm-8"i><"col-sm-3"p>>',
									language:<?php echo mj_smgt_datatable_multi_language();?>
									});
									$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'school-mgt') ?>");
								$('.dataTables_filter').addClass('search_btn_view_page');
							} );
						</script>
						<div class="table-div"><!-- PANEL BODY DIV START -->
							<div class="table-responsive"><!-- TABLE RESPONSIVE DIV START -->
								<table id="messages_detailpage" class="display" cellspacing="0" width="100%">
									<thead class="<?php echo MJ_smgt_datatable_heder() ?>">
										<tr>
											<th><?php  _e( 'Image', 'school-mgt' ) ;?></th>
											<th><?php esc_attr_e('Sender','school-mgt');?></th>
											<th><?php esc_attr_e('Subject','school-mgt');?></th>
											<th><?php esc_attr_e('Description','school-mgt');?></th>
											<th><?php esc_attr_e('Date','school-mgt');?></th>
										</tr>
									</thead>
									<tbody>
										<?php 
										$i=0;	
										if(!empty($student_message))
										{
											foreach ($student_message as $retrieved_data)
											{
												$sender_id=$retrieved_data->sender;
												$sender=MJ_smgt_get_display_name($sender_id);
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
													<td class="user_image width_50px profile_image_prescription">
														<p class="remainder_title_pr Bold prescription_tag <?php echo $color_class; ?>">	
															<img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/White_icons/Message_Chat.png"?>" alt="" class="massage_image center image_icon_height_25px">
														</p>
													</td>
													<td class="subject_name width_20px">
														<label class=""><?php echo _e($sender,"school-mgt"); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Sender','school-mgt');?>"></i></label>
													</td>
													<td class="department width_20px">
														<label class=""><?php echo $retrieved_data->subject; ?>  <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Subject','school-mgt');?>"></i></label>
													</td>
													<?php
													$massage =$retrieved_data->message_body;
													$massage_out = strlen($massage) > 30 ? substr($massage,0,30)."..." : $massage;
													?>
													<td class="specialization">
														<label class=""><?php echo $massage_out; ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Description','school-mgt');?>"></i></label>
													</td>
													<td class="department width_15px">
														<label class=""><?php echo mj_smgt_getdate_in_input_box($retrieved_data->date); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Date','school-mgt');?>"></i></label>
													</td>
												</tr>
												<?php 
												$i++;	
											}	 
										}
										?>
									</tbody>
								</table>
							</div><!-- TABLE RESPONSIVE DIV END -->
						</div>
						<?php
					}
					else
					{
						if($role == 'management' || $role == 'admin')
						{
							?>
							<div class="no_data_list_div"> 
								<a href="<?php echo admin_url().'admin.php?page=smgt_message&tab=compose';?>">
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
				// Message Tab End 
				?>	
			</div><!-- END PANEL BODY DIV-->
		</section>
		<!-- Detail Page Body Content Section End -->
	</div>
</div>