<?php
	$edit=0;
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
	{
		$edit=1;
		$holiday_data= mj_smgt_get_holiday_by_id($_REQUEST['holiday_id']);
	}
?>
<div class="panel-body"><!-- panel-body -->
    <form name="holiday_form" action="" method="post" class="form-horizontal" id="holiday_form">
       <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
		<input type="hidden" name="action" value="<?php echo $action;?>">
		<input type="hidden" name="holiday_id" value="<?php if($edit){ echo $holiday_data->holiday_id;}?>"/>
		<div class="header">
			<h3 class="first_hed"><?php esc_html_e('Holiday Information','school-mgt');?></h3>
		</div>
		<div class="form-body user_form">
			<div class="row">
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="form-group input">
						<div class="col-md-12 form-control">
							<input id="holiday_title" class="form-control validate[required] text-input" maxlength="50" type="text" value="<?php if($edit){ echo $holiday_data->holiday_title;}?>" name="holiday_title">
							<label class="" for="holiday_title"><?php esc_attr_e('Holiday Title','school-mgt');?><span class="require-field">*</span></label>
						</div>
					</div>
				</div>

				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="form-group input">
						<div class="col-md-12 form-control">
							<input id="holiday_description" class="form-control validate[custom[address_description_validation]]" maxlength="150" type="text" value="<?php if($edit){ echo $holiday_data->description;}?>" name="description">
							<label class="" for="description"><?php esc_attr_e('Description','school-mgt');?></label>
						</div>
					</div>
				</div>

				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="form-group input">
						<div class="col-md-12 form-control">
							<input id="date" class="form-control validate[required] text-input" type="text" value="<?php if($edit){ echo date("Y-m-d",strtotime($holiday_data->date)); }else{ echo date("Y-m-d"); } ?>" name="date" readonly>
							<label class="" for="date"><?php esc_attr_e('Start Date','school-mgt');?><span class="require-field">*</span></label>
						</div>
					</div>
				</div>
				<?php wp_nonce_field( 'save_holiday_admin_nonce' ); ?>
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 error_msg_left_margin">
					<div class="form-group input">
						<div class="col-md-12 form-control">
							<input id="end_date_new" class="form-control validate[required] text-input" type="text" value="<?php if($edit){ echo date("Y-m-d",strtotime($holiday_data->end_date));}else{ echo date("Y-m-d"); } ?>" name="end_date" readonly>
							<label class="" for="date"><?php esc_attr_e('End Date','school-mgt');?><span class="require-field">*</span></label>
						</div>
					</div>
				</div>
				<?php
				if($edit){

					?>
					<div class="col-md-6 input">
						<label class="ml-1 custom-top-label top" for="sms_template"><?php esc_attr_e('Select Status','school-mgt');?></label>
						<?php $holiday_status = $holiday_data->status; ?>
						<select name="status"  id="status" class="form-control max_width_100">
							<option value=""><?php esc_attr_e('Select Status','school-mgt');?></option>
							<option value="0" <?php if($holiday_status == "0"){ selected($holiday_status,0); } ?> ><?php esc_attr_e('Approve','school-mgt');?></option>
							<option value="1" <?php if($holiday_status == "1"){ selected($holiday_status,1); } ?>><?php esc_attr_e('Not Approve','school-mgt');?></option>
						</select>
					</div>
					<?php
				}
				else {
					?>
						<input class="" type="hidden" value="0" name="status" readonly>
						<?php
				}
				?>
			</div>
		</div>
		<div class="form-body user_form mt-3">
			<div class="row">
				<div class="col-sm-6">
					<input type="submit" value="<?php if($edit){ esc_attr_e('Save Holiday','school-mgt'); }else{ esc_attr_e('Add Holiday','school-mgt');}?>" name="save_holiday" class="btn btn-success save_btn" />
				</div>
			</div>
		</div>
    </form>
</div><!-- panel-body -->
