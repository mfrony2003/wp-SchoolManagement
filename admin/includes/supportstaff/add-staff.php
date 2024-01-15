<?php	$role='supportstaff'; ?>
<?php 
$edit=0;
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
{
	$edit=1;
	$user_info = get_userdata($_REQUEST['supportstaff_id']);
}
?>       
<div class="panel-body"><!-- panel-body -->
	<form name="student_form" action="" method="post" class="form-horizontal" id="teacher_form">
		<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="role" value="<?php echo $role;?>"  />
		<div class="header">	
			<h3 class="first_hed"><?php esc_html_e('PERSONAL Information','school-mgt');?></h3>
		</div>
		<div class="form-body user_form"><!-- user form -->
			<div class="row"><!-- row div -->
				<div class="col-md-6">
					<div class="form-group input">
						<div class="col-md-12 form-control">
							<input id="first_name" class="form-control validate[required,custom[onlyLetter_specialcharacter]] text-input" maxlength="50" type="text" value="<?php if($edit){ echo $user_info->first_name;}elseif(isset($_POST['first_name'])) echo $_POST['first_name'];?>" name="first_name">
							<label class="" for="first_name"><?php esc_attr_e('First Name','school-mgt');?><span class="require-field">*</span></label>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group input">
						<div class="col-md-12 form-control">
							<input id="middle_name" class="form-control validate[custom[onlyLetter_specialcharacter]]" maxlength="50" type="text"  value="<?php if($edit){ echo $user_info->middle_name;}elseif(isset($_POST['middle_name'])) echo $_POST['middle_name'];?>" name="middle_name">
							<label class="" for="middle_name"><?php esc_attr_e('Middle Name','school-mgt');?></label>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group input">
						<div class="col-md-12 form-control">
							<input id="last_name" class="form-control validate[required,custom[onlyLetter_specialcharacter]] text-input" maxlength="50" type="text"  value="<?php if($edit){ echo $user_info->last_name;}elseif(isset($_POST['last_name'])) echo $_POST['last_name'];?>" name="last_name">
							<label class="" for="last_name"><?php esc_attr_e('Last Name','school-mgt');?><span class="require-field">*</span></label>
						</div>
					</div>
				</div>

				<div class="col-md-6 res_margin_bottom_20px rtl_margin_top_15px">
					<div class="form-group">
						<div class="col-md-12 form-control">
							<div class="row padding_radio">
								<div class="input-group">
									<label class="custom-top-label margin_left_0" for="gender"><?php esc_attr_e('Gender','school-mgt');?><span class="require-field">*</span></label>
									<div class="d-inline-block">
										<?php $genderval = "male"; if($edit){ $genderval=$user_info->gender; }elseif(isset($_POST['gender'])) {$genderval=$_POST['gender'];}?>
										<label class="radio-inline">
											<input type="radio" value="male" class="tog validate[required]" name="gender"  <?php  checked( 'male', $genderval);  ?>/><?php esc_attr_e('Male','school-mgt');?> 
										</label>
										&nbsp;&nbsp;
										<label class="radio-inline">
											<input type="radio" value="female" class="tog validate[required]" name="gender"  <?php  checked( 'female', $genderval);  ?>/><?php esc_attr_e('Female','school-mgt');?> 
										</label>
									</div>
								</div>												
							</div>
						</div>
					</div>
				</div>	
				<div class="col-md-6">
					<div class="form-group input">
						<div class="col-md-12 form-control">
							<input id="birth_date" class="form-control validate[required]" type="text"  name="birth_date" value="<?php if($edit){ echo mj_smgt_getdate_in_input_box($user_info->birth_date);}elseif(isset($_POST['birth_date'])) echo mj_smgt_getdate_in_input_box($_POST['birth_date']);?>" readonly>
							<label class="" for="birth_date"><?php esc_attr_e('Date of Birth','school-mgt');?><span class="require-field">*</span></label>
						</div>
					</div>
				</div>
			</div><!-- row div -->
		</div><!-- user form -->

		<div class="header">	
			<h3 class="first_hed"><?php esc_html_e('Contact Information','school-mgt');?></h3>
		</div>
		<div class="form-body user_form"> <!-- user form -->
			<div class="row"><!-- row -->
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="form-group input">
						<div class="col-md-12 form-control">
							<input id="address" class="form-control validate[required,custom[address_description_validation]]" maxlength="120" type="text"  name="address" value="<?php if($edit){ echo $user_info->address;}elseif(isset($_POST['address'])) echo $_POST['address'];?>">
							<label class="" for="address"><?php esc_attr_e('Address','school-mgt');?><span class="require-field">*</span></label>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 error_msg_left_margin">
					<div class="form-group input">
						<div class="col-md-12 form-control">
							<input id="city_name" class="form-control validate[required,custom[city_state_country_validation]]" maxlength="50" type="text"  name="city_name" value="<?php if($edit){ echo $user_info->city;}elseif(isset($_POST['city_name'])) echo $_POST['city_name'];?>">
							<label class="" for="city_name"><?php esc_attr_e('City','school-mgt');?><span class="require-field">*</span></label>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="form-group input">
						<div class="col-md-12 form-control">
							<input id="state_name" class="form-control validate[custom[city_state_country_validation]]" maxlength="50" type="text"  name="state_name" 
							value="<?php if($edit){ echo $user_info->state;}elseif(isset($_POST['state_name'])) echo $_POST['state_name'];?>">
							<label class="" for="state_name"><?php esc_attr_e('State','school-mgt');?></label>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 error_msg_left_margin">
					<div class="form-group input">
						<div class="col-md-12 form-control">
							<input id="zip_code" class="form-control  validate[required,custom[zipcode]]" maxlength="15" type="text"  name="zip_code" value="<?php if($edit){ echo $user_info->zip_code;}elseif(isset($_POST['zip_code'])) echo $_POST['zip_code'];?>">
							<label class="" for="zip_code"><?php esc_attr_e('Zip Code','school-mgt');?><span class="require-field">*</span></label>
						</div>
					</div>
				</div>

				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 mobile_error_massage_left_margin">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group input margin_bottom_0">
								<div class="col-md-12 form-control">

									<input type="text" readonly value="+<?php echo mj_smgt_get_countery_phonecode(get_option( 'smgt_contry' ));?>"  class="form-control country_code phonecode" name="phonecode">

									<label for="phonecode" class="pl-2"><?php esc_html_e('Country Code','school-mgt');?><span class="required red">*</span></label>
								</div>											
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group input margin_bottom_0">
								<div class="col-md-12 form-control">
									<input id="mobile_number" class="form-control btn_top validate[required,custom[phone_number],minSize[6],maxSize[15]] text-input" type="text"  name="mobile_number" value="<?php if($edit){ echo $user_info->mobile_number;}elseif(isset($_POST['mobile_number'])) echo $_POST['mobile_number'];?>">
									<label class="" for="mobile_number"><?php esc_attr_e('Mobile Number','school-mgt');?><span class="require-field">*</span></label>
								</div>
							</div>
						</div>
					</div>
				</div> 

				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group input margin_bottom_0">
								<div class="col-md-12 form-control">
									<input type="text" readonly value="+<?php echo mj_smgt_get_countery_phonecode(get_option( 'smgt_contry' ));?>"  class="form-control country_code phonecode" name="alter_mobile_number">
									<label for="phonecode" class="pl-2"><?php esc_html_e('Country Code','school-mgt');?></label>
								</div>											
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group input margin_bottom_0">
								<div class="col-md-12 form-control">
									<input id="alternet_mobile_number" class="form-control btn_top text-input validate[custom[phone_number],minSize[6],maxSize[15]]" type="text"  name="alternet_mobile_number" value="<?php if($edit){ echo $user_info->alternet_mobile_number;}elseif(isset($_POST['alternet_mobile_number'])) echo $_POST['alternet_mobile_number'];?>">

									<label class="" for="mobile_number"><?php esc_attr_e('Alternate Mobile Number','school-mgt');?></label>
								</div>
							</div>
						</div>
					</div>
				</div> 

				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="form-group input">
						<div class="col-md-12 form-control">
							<input id="phone" class="form-control text-input" type="text"  name="phone" value="<?php if($edit){ echo $user_info->phone;}elseif(isset($_POST['phone'])) echo $_POST['phone'];?>">
							<label class="" for="phone"><?php esc_attr_e('Phone','school-mgt');?></label>
						</div>
					</div>
				</div>

				<?php wp_nonce_field( 'save_supportstaff_admin_nonce' ); ?>

				
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 input">
					<label class="ml-1 custom-top-label top" for="working_hour"><?php esc_attr_e('Working Hour','school-mgt');?></label>
					<?php if($edit){ $workrval=$user_info->working_hour; }elseif(isset($_POST['working_hour'])){$workrval=$_POST['working_hour'];}else{$workrval='';}?>
					<select name="working_hour" class="form-control max_width_100" id="working_hour">
						<option value=""><?php esc_attr_e('Select Job Time','school-mgt');?></option>
						<option value="full_time" <?php selected( $workrval, 'full_time'); ?>><?php esc_attr_e('Full Time','school-mgt');?></option>
						<option value="half_day" <?php selected( $workrval, 'half_day'); ?>><?php esc_attr_e('Part time','school-mgt');?></option>
					</select>
				</div>

				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="form-group input">
						<div class="col-md-12 form-control">
							<input id="email" class="form-control validate[custom[address_description_validation]]" maxlength="50" type="text"  name="possition" 
							value="<?php if($edit){ echo $user_info->possition;}elseif(isset($_POST['possition'])) echo $_POST['possition'];?>">
							<label class="" for="possition "><?php esc_attr_e('Position','school-mgt');?></label>
						</div>
					</div>
				</div>
			</div><!-- row -->
		</div><!-- user form -->

		<div class="header">	
			<h3 class="first_hed"><?php esc_html_e('Login Information','school-mgt');?></h3>
		</div>

		<div class="form-body user_form"> <!-- user form -->
			<div class="row"><!-- row -->
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="form-group input">
						<div class="col-md-12 form-control">
							<input id="email" class="student_email_id form-control validate[required,custom[email]] text-input" maxlength="100" type="text"  name="email" value="<?php if($edit){ echo $user_info->user_email;}elseif(isset($_POST['email'])) echo $_POST['email'];?>">
							<label class="" for="email"><?php esc_attr_e('Email','school-mgt');?><span class="require-field">*</span></label>
						</div>
						<div class="email_validation_div">
							<div class="formError" style="opacity: 0.87; position: absolute; top: 33px; left: 482.5px; margin-top: 0px; display: block;"><div class="formErrorArrow formErrorArrowBottom"><div class="line1"><!-- --></div><div class="line2"><!-- --></div><div class="line3"><!-- --></div><div class="line4"><!-- --></div><div class="line5"><!-- --></div><div class="line6"><!-- --></div><div class="line7"><!-- --></div><div class="line8"><!-- --></div><div class="line9"><!-- --></div><div class="line10"><!-- --></div></div><div class="formErrorContent"><?php esc_html_e('Email id Already Exist.','hospital_mgt');?><br></div></div>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 error_msg_left_margin">
					<div class="form-group input">
						<div class="col-md-12 form-control">
							<input id="password" class="form-control <?php if(!$edit){ echo 'validate[required,minSize[8],maxSize[12]]'; }else{ echo 'validate[minSize[8],maxSize[12]]'; } ?>" type="password"  name="password" value="">
							<label class="" for="password"><?php esc_attr_e('Password','school-mgt');?><?php if(!$edit) {?><span class="require-field">*</span><?php }?></label>
						</div>
					</div>
				</div>
			</div><!-- row -->
		</div><!-- user form -->
		<div class="header">	
			<h3 class="first_hed"><?php esc_html_e('Profile Image','school-mgt');?></h3>
		</div>
		<div class="form-body user_form"><!-- user form -->
			<div class="row"><!-- row -->
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="form-group input">
						<div class="col-md-12 form-control upload-profile-image-patient res_rtl_height_50px">
							<label class="custom-control-label custom-top-label ml-2" for="photo"><?php esc_attr_e('Image','school-mgt');?></label>

							<div class="col-sm-12 display_flex"> 		
								
								<input type="text" id="smgt_user_avatar_url" class="image_path_dots form-control" name="smgt_user_avatar" value="<?php if($edit)echo esc_url( $user_info->smgt_user_avatar );elseif(isset($_POST['smgt_user_avatar'])) echo $_POST['smgt_user_avatar']; ?>" readonly />	
								
								<input id="upload_user_avatar_button" type="button" class="button upload_image_btn" style="float: right;" value="<?php esc_attr_e( 'Upload image', 'school-mgt' ); ?>" />      
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<div id="upload_user_avatar_preview" >
								<?php if($edit) 
								{
									if($user_info->smgt_user_avatar == "")
									{ ?>
										<img class="image_preview_css" src="<?php echo get_option( 'smgt_supportstaff_thumb_new' ) ?>">
								<?php }
									else {
									?>
										<img class="image_preview_css" src="<?php if($edit)echo esc_url( $user_info->smgt_user_avatar ); ?>" />
										<?php 
									}
								}
								else {
								?>
									<img class="image_preview_css" src="<?php echo get_option( 'smgt_supportstaff_thumb_new' ) ?>">
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div><!-- row -->
		</div>  <!-- user form -->

		<div class="offset-sm-0 col-md-6 col-sm-6 col-xs-12">        
			<input type="submit" value="<?php if($edit){ esc_attr_e('Save Support Staff','school-mgt'); }else{ esc_attr_e('Add Support Staff','school-mgt');}?>" name="save_supportstaff" class="save_btn"/>
		</div>    
	</form>
</div><!-- panel-body -->