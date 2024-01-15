<!------- panel White ------->
<div class="panel-white margin_top_20px padding_top_25px_res">
	<?php 	
	$edit=0;
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
	{
		$edit=1;
		$route_data= mj_smgt_get_route_by_id($_REQUEST['route_id']);
	}
	?>
	
	<link rel="stylesheet"	href="<?php echo SMS_PLUGIN_URL.'/assets/css/timepicker_rtl.css'; ?>">
	<script>
		//-------- timepicker ---------//
		jQuery(document).ready(function($){
			mdtimepicker('#timepicker', {
			events: {
					timeChanged: function (data) {
					}
				},
			theme: 'purple',
			readOnly: false,
			//lang:'hi',
			// locale: moment.locale('ar'),
			// label:translateFn("AM")
			});
		})
	</script>
	<div class="panel-body"> <!------- panel Body ------->
        <form name="route_form" action="" method="post" class="form-horizontal" id="rout_form">
			<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
			<input type="hidden" name="action" value="<?php echo $action;?>">

			<div class="form-body user_form">
				<div class="row">
					<div class="col-md-6 input">
						<label class="ml-1 custom-top-label top" for="hmgt_contry"><?php esc_html_e('Class','school-mgt');?><span class="required">*</span></label>
						<?php if($edit){ $classval=$route_data->class_id; }elseif(isset($_POST['class_id'])){$classval=$_POST['class_id'];}else{$classval='';}?>
						<select name="class_id"  id="class_list" class="form-control validate[required] max_width_100">
							<option value=" "><?php esc_attr_e('Select class Name','school-mgt');?></option>
							<?php
							foreach(mj_smgt_get_allclass() as $classdata)
							{  
							?>
							<option  value="<?php echo $classdata['class_id'];?>" <?php   selected($classval, $classdata['class_id']);  ?>><?php echo $classdata['class_name'];?></option>
							<?php }?>
						</select>                                 
					</div>
					<?php wp_nonce_field( 'save_root_admin_nonce' ); ?>
					<div class="col-md-6 input">
						<label class="ml-1 custom-top-label top" for="hmgt_contry"><?php esc_html_e('Class Section','school-mgt');?></label>
						<?php if($edit){ $sectionval=$route_data->section_name; }elseif(isset($_POST['class_section'])){$sectionval=$_POST['class_section'];}else{$sectionval='';}?>
						<select name="class_section" class="form-control max_width_100 section_id_exam" id="class_section">
							<option value=""><?php esc_attr_e('Select Class Section','school-mgt');?></option>
							<?php
							if($edit)
							{
								foreach(mj_smgt_get_class_sections($route_data->class_id) as $sectiondata)
								{ 
									?>
									<option value="<?php echo $sectiondata->id;?>" <?php selected($sectionval,$sectiondata->id);  ?>><?php echo $sectiondata->section_name;?></option>
									<?php 
								} 
							}?>
						</select>                             
					</div>
					<div class="col-md-6 input">
						<label class="ml-1 custom-top-label top" for="hmgt_contry"><?php esc_html_e('Subject','school-mgt');?><span class="required">*</span></label>
						<?php if($edit){ $subject_id=$route_data->subject_id; }elseif(isset($_POST['subject_id'])){$subject_id=$_POST['subject_id'];}else{$subject_id='';}?>
						<select name="subject_id" id="subject_list" class="form-control validate[required] max_width_100">
							<?php
							if( $edit )
							{
								$subject = mj_smgt_get_subject_by_classid($route_data->class_id);
								if(!empty($subject))
								{
									foreach ($subject as $ubject_data)
									{
									?>
										<option value="<?php echo $ubject_data->subid ;?>" <?php selected($subject_id, $ubject_data->subid);  ?>><?php echo $ubject_data->sub_name;?></option>
									<?php 
									}
								}
							}
							else 
							{
							?>
								<option value=""><?php esc_attr_e('Select Subject','school-mgt');?></option>
							<?php
							}
							?>
						</select>                      
					</div>
					<div class="col-md-6 input">
						<label class="ml-1 custom-top-label top" for="hmgt_contry"><?php esc_html_e('Day','school-mgt');?></label>
						<?php if($edit){ $day_key=$route_data->weekday; }elseif(isset($_POST['weekday'])){$day_key=$_POST['weekday'];}else{$day_key='';}?>
						<select name="weekday" class="form-control validate[required] max_width_100" id="weekday">
							<?php 
							foreach(mj_smgt_sgmt_day_list() as $daykey => $dayname)
								echo '<option  value="'.$daykey.'" '.selected($day_key,$daykey).'>'.$dayname.'</option>';
							?>
						</select>                          
					</div>
					<?php
					if($edit)
					{
						//------------ Start time convert --------------//
						$stime = explode(":", $route_data->start_time);
						$start_hour=$stime[0];
						$start_min=$stime[1];
						$shours = str_pad($start_hour, 2, "0", STR_PAD_LEFT);
						$smin = str_pad($start_min, 2, "0", STR_PAD_LEFT);
						$start_am_pm=$stime[2];
						$start_time=$shours.':'.$smin.':'.$start_am_pm;

						//-------------------- end time convert -----------------//
						$etime = explode(":", $route_data->end_time);
						$end_hour=$etime[0];
						$end_min=$etime[1];
						$ehours = str_pad($end_hour, 2, "0", STR_PAD_LEFT);
						$emin = str_pad($end_min, 2, "0", STR_PAD_LEFT);
						$end_am_pm=$etime[2];
						$end_time=$ehours.':'.$emin.':'.$end_am_pm;
					}
					?>
					<div class="col-md-6">
						<div class="form-group input">
							<div class="col-md-12 form-control">
								<input type="text" id="timepicker" name="start_time" class="form-control validate[required] start_time" value="<?php if(!empty($route_data->start_time)){ echo $start_time; } ?>" />
								<label for="userinput1" class=""><?php esc_html_e('Start Time','school-mgt');?><span class="required">*</span></label>
							</div>
						</div>
					</div>	
					<div class="col-md-6 error_msg_left_margin">
						<div class="form-group input">
							<div class="col-md-12 form-control">
								<input type="text" id="timepicker" name="end_time" class="form-control validate[required] end_time" value="<?php if(!empty($route_data->end_time)){ echo $end_time; } ?>" />
								<label for="userinput1" class=""><?php esc_html_e('End Time','school-mgt');?><span class="required">*</span></label>
							</div>
						</div>
					</div>
				</div>
			</div>

			<?php 
			
			if(get_option('smgt_enable_virtual_classroom') == "yes")
			{
				if(!$edit)
				{ 
					?>
					<!-- Create Virtual Classroom --> 
					<div class="form-body user_form">
						<div class="row">
							<div class="col-md-6 rtl_margin_top_15px">
								<div class="form-group">
									<div class="col-md-12 form-control input_height_50px">
										<div class="row padding_radio">
											<div class="input-group input_checkbox">
												<label class="custom-top-label"><?php esc_html_e('Create Virtual Class','school-mgt');?></label>													
												<div class="checkbox checkbox_lebal_padding_8px">
													<label>
														<input type="checkbox" id="isCheck" class="margin_right_checkbox_css create_virtual_classroom" name="create_virtual_classroom"  value="1" />&nbsp;&nbsp;<?php esc_attr_e('Enable','school-mgt');?>
													</label>
												</div>
											</div>
										</div>												
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="form-body user_form create_virtual_classroom_div create_virtual_classroom_div_none margin_top_15px">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group input">
									<div class="col-md-12 form-control">
										<input id="start_date_new" class="form-control validate[required] text-input start_date" type="text" placeholder="<?php esc_html_e('Enter Start Date','school-mgt');?>" name="start_date" value="<?php echo date("Y-m-d"); ?>" readonly>
										<label for="userinput1" class=""><?php esc_html_e('Start Date','school-mgt');?></label>
									</div>
								</div>
							</div>
							<div class="col-md-6">	
								<div class="form-group input">
									<div class="col-md-12 form-control">
										<input id="end_date_new" class="form-control validate[required] text-input end_date" type="text" placeholder="<?php esc_html_e('Enter End Date','school-mgt');?>" name="end_date" value="<?php echo date("Y-m-d"); ?>" readonly>
										<label for="userinput1"><?php esc_html_e('End Date','school-mgt');?></label>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group input">
									<div class="col-md-12 form-control">
										<input class="form-control validate[custom[address_description_validation]]" type="text" name="password" value="">
										<label for="userinput1" class=""><?php esc_html_e('Topic','school-mgt');?></label>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group input">
									<div class="col-md-12 form-control">
										<input class="form-control text-input" type="password" name="agenda" value="">
										<label for="userinput1" class=""><?php esc_html_e('Password','school-mgt');?></label>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php 
				}
			}
			?>
			<!-- End Create Virtual Classroom -->
			<div class="form-body margin_top_15px">
				<div class="row">
					<div class="col-sm-6">        	
						<input type="submit" value="<?php if($edit){ esc_attr_e('Save Route','school-mgt'); }else{ esc_attr_e('Add Route','school-mgt');}?>" name="save_route" class="btn save_btn" />
					</div> 
				</div>
			</div>       
     	</form>
    </div><!------- panel White ------->
</div> <!------- panel White ------->