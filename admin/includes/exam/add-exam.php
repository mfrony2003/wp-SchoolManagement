<!--Group POP up code -->
<div class="popup-bg">
	<div class="overlay-content admission_popup">
		<div class="modal-content">
			<div class="category_list">
			</div>     
		</div>
	</div>     
</div>
<script type="text/javascript" src="<?php echo SMS_PLUGIN_URL.'/assets/js/pages/add-exam.js'; ?>" ></script>
<?php
$edit=0;
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
{
	$edit=1;
	$exam_data= mj_smgt_get_exam_by_id($_REQUEST['exam_id']);
}
?>
<div class="panel-body margin_top_20px"><!-------- Penal Body --------->
	<form name="exam_form" action="" method="post" class="form-horizontal" enctype="multipart/form-data" id="exam_form"><!-------- Exam Form --------->
		<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input type="hidden" name="action" value="<?php echo $action;?>">
		<div class="header">	
			<h3 class="first_hed"><?php esc_html_e('Exam Information','school-mgt');?></h3>
		</div>
		<div class="form-body user_form">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group input">
						<div class="col-md-12 form-control">
							<input id="exam_name" class="form-control validate[required,custom[popup_category_validation]]" maxlength="50" type="text" value="<?php if($edit){ echo $exam_data->exam_name;}?>" name="exam_name">
							<label for="userinput1" class=""><?php esc_html_e('Exam Name','school-mgt');?><span class="required">*</span></label>
						</div>
					</div>
				</div>
				<div class="col-md-6 input error_msg_left_margin">
					<label class="ml-1 custom-top-label top" for="hmgt_contry"><?php esc_html_e('Class Name','school-mgt');?><span class="required">*</span></label>
					<select name="class_id" class="form-control validate[required] width_100" id="class_list">
						<option value=""><?php echo esc_attr_e( 'Select Class', 'school-mgt' ) ;?></option>
						<?php $classval='';
						if($edit){  
							$classval=$exam_data->class_id; 
							foreach(mj_smgt_get_allclass() as $class)
							{ ?>
							<option value="<?php echo $class['class_id'];?>" <?php selected($class['class_id'],$classval);  ?>>
							<?php echo mj_smgt_get_class_name($class['class_id']);?></option> 
						<?php }
						}else
						{
							foreach(mj_smgt_get_allclass() as $classdata)
							{ ?>
							<option value="<?php echo $classdata['class_id'];?>" <?php selected($classdata['class_id'],$classval);  ?>><?php echo $classdata['class_name'];?></option> 
						<?php }
						}
						?>
					</select>                              
				</div>
				<div class="col-md-6 input">
					<label class="ml-1 custom-top-label top" for="hmgt_contry"><?php esc_html_e('Section Name','school-mgt');?></label>
					<?php if($edit){ $sectionval=$exam_data->section_id; }elseif(isset($_POST['class_section'])){$sectionval=$_POST['class_section'];}else{$sectionval='';}?>
					<select name="class_section" class="form-control width_100" id="class_section">
						<option value=""><?php esc_attr_e('Select Class Section','school-mgt');?></option>
						<?php
						if($edit){
							foreach(mj_smgt_get_class_sections($exam_data->class_id) as $sectiondata)
							{  ?>
							<option value="<?php echo $sectiondata->id;?>" <?php selected($sectionval,$sectiondata->id);  ?>><?php echo $sectiondata->section_name;?></option>
						<?php }
						}?>
					</select>                             
				</div>
				<div class="col-md-5 input width_80">
					<label class="ml-1 custom-top-label top" for="hmgt_contry"><?php esc_html_e('Exam Term','school-mgt');?><span class="required">*</span></label>
					<?php if($edit){ $sectionval1=$exam_data->exam_term; }elseif(isset($_POST['exam_term'])){$sectionval1=$_POST['exam_term'];}else{$sectionval1='';}?>
					<select class="form-control validate[required] term_category width_100" name="exam_term">
						<option value=""><?php esc_html_e('Select Term','school-mgt');?></option>
						<?php 
						$activity_category=mj_smgt_get_all_category('term_category');
						if(!empty($activity_category))
						{
							foreach ($activity_category as $retrive_data)
							{ 		 	
							?>
								<option value="<?php echo $retrive_data->ID;?>" <?php selected($retrive_data->ID,$sectionval1);  ?>><?php echo esc_attr($retrive_data->post_title); ?> </option>
							<?php }
						} 
						?> 
					</select>	                           
				</div>
				<div class="col-md-1 col-sm-1 res_width_20">
					<img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Add_new_plus_btn.png"?>" style="height: 47px;" alt="" model="term_category" class="rtl_margin_top_15px sibling_add_remove add_cirtificate float_right add_bt_hegiht" id="addremove_cat">	
				</div>
				<div class="col-md-6">
					<div class="form-group input">
						<div class="col-md-12 form-control">
							<input id="passing_mark" class="form-control text-input onlyletter_number_space_validation validate[required]" type="number" value="<?php if($edit){ echo $exam_data->passing_mark;}?>" name="passing_mark">
							<label for="userinput1" class=""><?php esc_html_e('Passing Marks','school-mgt');?><span class="required">*</span></label>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group input error_msg_left_margin">
						<div class="col-md-12 form-control">
							<input id="total_mark" class="form-control validate[required] onlyletter_number_space_validation text-input" type="number" value="<?php if($edit){ echo $exam_data->total_mark;}?>" name="total_mark">
							<label for="userinput1" class=""><?php esc_html_e('Total Marks','school-mgt');?><span class="required">*</span></label>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group input">
						<div class="col-md-12 form-control">
							<input id="exam_start_date" class="form-control validate[required] text-input" type="text" name="exam_start_date" value="<?php if($edit){ echo date("Y-m-d",strtotime($exam_data->exam_start_date)); }else{ echo date("Y-m-d"); } ?>" readonly>
							<label for="userinput1" class=""><?php esc_html_e('Exam Start Date','school-mgt');?><span class="required">*</span></label>
						</div>
					</div>
				</div>
				<div class="col-md-6 error_msg_left_margin">
					<div class="form-group input">
						<div class="col-md-12 form-control">
							<input id="exam_end_date" class="form-control validate[required] text-input" type="text" name="exam_end_date" value="<?php if($edit){ echo date("Y-m-d",strtotime($exam_data->exam_end_date)); }else{ echo date("Y-m-d"); } ?>" readonly>
							<label for="userinput1" class=""><?php esc_html_e('Exam End Date','school-mgt');?><span class="required">*</span></label>
						</div>
					</div>
				</div>
				<?php wp_nonce_field( 'save_exam_admin_nonce' ); ?>
				<div class="col-md-6 note_text_notice">
					<div class="form-group input">
						<div class="col-md-12 note_border margin_bottom_15px_res">
							<div class="form-field">
								<textarea name="exam_comment" class="textarea_height_47px form-control validate[custom[address_description_validation]]" maxlength="150" id="exam_comment"><?php if($edit){ echo $exam_data->exam_comment;}?></textarea>
								<span class="txt-title-label"></span>
								<label class="text-area address active"><?php esc_attr_e('Exam Comment','school-mgt');?></label>
							</div>
						</div>
					</div>
				</div>
				<?php
				if($edit)
				{ 
					$doc_data=json_decode($exam_data->exam_syllabus);
					?>
					<div class="col-md-6">	
						<div class="form-group input">
							<div class="col-md-12 form-control res_rtl_height_50px">	
								<label for="" class="custom-control-label custom-top-label ml-2 margin_left_30px"><?php _e('Exam Syllabus','school-mgt');?></label>
								<div class="col-sm-12">
									<input type="file" name="exam_syllabus" class="file_validation"/>						
									<input type="hidden" name="old_hidden_exam_syllabus" value="<?php if(!empty($doc_data[0]->value)){ echo esc_attr($doc_data[0]->value);}elseif(isset($_POST['exam_syllabus'])) echo esc_attr($_POST['exam_syllabus']);?>">					
								</div>
								<?php 
								if(!empty($doc_data[0]->value))
								{ 
									?>
									<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
										<a target="blank"  class="status_read btn btn-default" href="<?php print content_url().'/uploads/document_upload/'.$doc_data[0]->value; ?>" record_id="<?php echo $exam_data->exam_id;?>">
										<i class="fa fa-download"></i><?php esc_attr_e('Download','school-mgt');?></a>
									</div>
									<?php	
								}
								?>
							</div>
						</div>
					</div>
					<?php
				}
				else
				{
					?>
					<div class="col-md-6">	
						<div class="form-group input">
							<div class="col-md-12 form-control res_rtl_height_50px">	
								<label for="" class="custom-control-label custom-top-label ml-2 margin_left_30px"><?php _e('Exam Syllabus','school-mgt');?></label>
								<div class="col-sm-12">
									<input type="file" name="exam_syllabus" class="col-md-12 col-sm-12 col-xs-12 file_validation input-file-1">	
								</div>
							</div>
						</div>
					</div>
					<?php
				}
				?>
			</div>
		</div>
		<div class="form-body user_form">
			<div class="row">
				<div class="col-sm-6">        	
					<input type="submit" id="save_exam" value="<?php if($edit){ esc_attr_e('Save Exam','school-mgt'); }else{ esc_attr_e('Add Exam','school-mgt');}?>" name="save_exam" class="btn btn-success save_btn" />
				</div>    
			</div>
		</div>    
	</form><!-------- Form --------->
</div>  <!-------- Penal Body --------->