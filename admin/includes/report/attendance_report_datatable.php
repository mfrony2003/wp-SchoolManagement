<div class="panel-body clearfix margin_top_20px padding_top_15px_res">
	<div class="panel-body clearfix">
		<form method="post">  
			<div class="form-body user_form">
				<div class="row">
					<div class="col-md-6 input">
						<label class="ml-1 custom-top-label top" for="hmgt_contry"><?php esc_html_e('Select Class','school-mgt');?><span class="require-field">*</span></label>
						<select name="class_id"  id="class_list" class="line_height_30px form-control class_id_exam validate[required]">
							<?php $class_id="";
							if(isset($_REQUEST['class_id']))
							{
								$class_id=$_REQUEST['class_id'];
							}?>
							<option value="all_class"><?php esc_attr_e('All Class','school-mgt');?></option>
							<?php
							foreach(mj_smgt_get_allclass() as $classdata)
							{
								?>
								<option  value="<?php echo $classdata['class_id'];?>" <?php selected($classdata['class_id'],$class_id)?> ><?php echo $classdata['class_name'];?></option>
								<?php 
							}?>
						</select>         
					</div>
					<div class="col-md-6 input">
						<label class="ml-1 custom-top-label top" for="hmgt_contry"><?php esc_html_e('Status','school-mgt');?></label>
						<select name="status" class="line_height_30px form-control" >
							<option value="all_status"><?php esc_attr_e('All Status','school-mgt');?></option>
							<option value="Present"><?php esc_attr_e('Present','school-mgt');?></option>
							<option value="Absent"><?php esc_attr_e('Absent','school-mgt');?></option>
							<option value="Late"><?php esc_attr_e('Late','school-mgt');?></option>
							<option value="Half Day"><?php esc_attr_e('Half Day','school-mgt');?></option>
						</select>      
					</div>
					<div class="col-md-6">
						<div class="form-group input">
							<div class="col-md-12 form-control">
								<input type="text"  id="sdate" class="form-control" name="sdate" value="<?php if(isset($_REQUEST['sdate'])) echo $_REQUEST['sdate'];else echo date('Y-m-d');?>" readonly>
								<label for="userinput1" class=""><?php esc_html_e('Start Date','school-mgt');?></label>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group input">
							<div class="col-md-12 form-control">
								<input type="text"  id="edate" class="form-control" name="edate" value="<?php if(isset($_REQUEST['edate'])) echo $_REQUEST['edate'];else echo date('Y-m-d');?>" readonly>
								<label for="userinput1" class=""><?php esc_html_e('End Date','school-mgt');?></label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="form-body user_form">
				<div class="row">
					<div class="col-md-6">
						<input type="submit" name="view_attendance" Value="<?php esc_attr_e('Go','school-mgt');?>"  class="btn btn-info save_btn"/>
					</div>
				</div>
			</div>
		</form>
	</div>		
	<?php
	if(isset($_REQUEST['view_attendance']))
	{
		$start_date = $_POST['sdate'];
		$end_date = $_POST['edate'];
		$class_id = $_POST['class_id'];
		$status = $_POST['status'];
		$attendance=mj_smgt_view_attendance_for_report($start_date,$end_date,$class_id,$status);
	}
	else
	{
		$start_date = date('Y-m-d',strtotime('first day of this month'));
		$end_date = date('Y-m-d',strtotime('last day of this month'));
		$attendance=mj_smgt_view_attendance_report_for_start_date_enddate($start_date,$end_date);
	}
	?>
    <div class="panel-body margin_top_20px padding_top_15px_res">
		<?php
        if(!empty($attendance))
        {
            ?>
			<div class="table-responsive">
				<div class="btn-place"></div>
				<form id="frm-example" name="frm-example" method="post">
					<table id="attendance_list_report" class="display" cellspacing="0" width="100%">
						<thead class="<?php echo MJ_smgt_datatable_heder() ?>">
							<tr>
								<th><?php  _e( 'Image', 'school-mgt' ) ;?></th>
								<th><?php esc_attr_e('Student Name','school-mgt');?></th>
								<th><?php esc_attr_e('Class Name','school-mgt');?></th>
								<th><?php esc_attr_e('Date','school-mgt');?></th>
								<th><?php esc_attr_e('Day','school-mgt');?></th>
								<th><?php esc_attr_e('Status','school-mgt');?></th>
								<th><?php esc_attr_e('Description','school-mgt');?></th>
							</tr>
						</thead>
						<tbody>
							<?php
							if(!empty($attendance))
							{
								$i=0;
								foreach($attendance as $attendance_data)
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
									<td class="user_image width_50px profile_image_prescription padding_left_0">
										<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	
											<img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Attendance.png"?>" alt="" class="massage_image center margin_top_3px">
										</p>
									</td>
									<td><?php echo mj_smgt_get_display_name($attendance_data->user_id);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Student Name','school-mgt');?>"></i></td>
									<td><?php echo mj_smgt_get_class_name_by_id(get_user_meta($attendance_data->user_id, 'class_name',true)); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Class Name','school-mgt');?>"></i></td>
									<td><?php echo mj_smgt_getdate_in_input_box($attendance_data->attendence_date); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Date','school-mgt');?>"></i></td>
									<td><?php echo esc_attr_e(date("D", strtotime($attendance_data->attendence_date)),'school-mgt'); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Day','school-mgt');?>"></i></td>
									<td>
										<?php 
										$attendance_status = $attendance_data->status;
										if(!empty($attendance_status))
										{
											if($attendance_status=="Present")
											{
												echo esc_attr__('Present','school-mgt');
											}
											elseif($attendance_status=="Late")
											{
												echo esc_attr__('Late','school-mgt');
											}
											elseif($attendance_status=="Half Day")
											{
												echo esc_attr__('Half Day','school-mgt');
											}
											else
											{
												echo esc_attr__('Absent','school-mgt');
											}
										}
										else 
										{
											echo esc_attr__('Absent','school-mgt');
										}					
										?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Status','school-mgt');?>"></i>
									</td>
									<?php
									$comment =$attendance_data->comment;
									$description = strlen($comment) > 30 ? substr($comment,0,30)."..." : $comment;
									?>
									<td><?php if(!empty($description)){ echo $description; }else{ echo "N/A"; } ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Description','school-mgt');?>"></i></td>              
									<?php
									echo '</tr>';
									$i++;
								}
							}
							?>
						</tbody>        
					</table>
				</form>
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
        }  ?>
    </div>
</div>