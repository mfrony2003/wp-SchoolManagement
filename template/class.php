<?php
$role_name=mj_smgt_get_user_role(get_current_user_id());
$user_access=mj_smgt_get_userrole_wise_access_right_array();
?>
<script type="text/javascript">
jQuery(document).ready(function($)
{
	"use strict";	
	$('#class_list').DataTable({
		"order": [[ 2, "asc" ]],
		"dom": 'lifrtp',
		"aoColumns":[	                  
					<?php
					if($role_name == "supportstaff")
					{
						?>
						{"bSortable": false},
						<?php
					}
					?>
					  {"bSortable": false},
	                  {"bSortable": true},
	                  {"bSortable": true},
					  {"bSortable": true},
					  <?php
					  if($user_access['add']=='1' || $user_access['edit']=='1' || $user_access['delete']=='1')
					  {
						?>
						{"bSortable": true},
						<?php
					  }
					  ?>
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
    $('#class_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});
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
});
</script>
<?php 
//-------- CHECK BROWSER JAVA SCRIPT ----------//
mj_smgt_browser_javascript_check();
$active_tab = isset($_GET['tab'])?$_GET['tab']:'classlist';
//--------------- ACCESS WISE ROLE -----------//

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

//------------ SAVE CLASS FORM --------------//
if(isset($_POST['save_class']))
{
	$nonce = $_POST['_wpnonce']; // FOR SECURITY //
	if ( wp_verify_nonce( $nonce, 'save_class_admin_nonce' ) )
	{
		$created_date = date("Y-m-d H:i:s");
		$classdata=array('class_name'=>mj_smgt_popup_category_validation(stripslashes($_POST['class_name'])),
						'class_num_name'=>mj_smgt_onlyNumberSp_validation($_POST['class_num_name']),
						'class_capacity'=>mj_smgt_onlyNumberSp_validation($_POST['class_capacity']),	
						'creater_id'=>get_current_user_id(),
						'created_date'=>$created_date
						
		);
		$tablename="smgt_class";
		if($_REQUEST['action']=='edit') // EDIT TIME SAVE CODE //
		{
			$classid=array('class_id'=>$_REQUEST['class_id']);
			$result=mj_smgt_update_record($tablename,$classdata,$classid);
			if($result)
			{
				wp_redirect ( home_url() . '?dashboard=user&page=class&tab=classlist&message=2');
				exit;
			}
		}
		else  // ADD TIME SAVE CODE //
		{
			$result=mj_smgt_insert_record($tablename,$classdata);
			if($result)
			{
				wp_redirect ( home_url() . '?dashboard=user&page=class&tab=classlist&message=1');
				exit;
			}
		}
	}
}
//-------------- DELETE SELECTED CLASS -----------------//
if(isset($_REQUEST['delete_selected']))
{		
	if(!empty($_REQUEST['id']))
	{
		foreach($_REQUEST['id'] as $id)
		{
			$tablename="smgt_class";
			$result=mj_smgt_delete_class($tablename,$id);
			wp_redirect ( home_url().'?dashboard=user&page=class&tab=classlist&message=3'); 
		}
	}
	if($result)
	{
		wp_redirect ( home_url().'?dashboard=user&page=class&tab=classlist&message=3'); 
	}
}
//------------ DELETE CLASS ----------------//
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')
{
	$tablename="smgt_class";
	$result=mj_smgt_delete_class($tablename,$_REQUEST['class_id']);
	if($result)
	{
		wp_redirect ( home_url() . '?dashboard=user&page=class&tab=classlist&message=3');
		exit;
	}
}
if(isset($_GET['message']) && $_GET['message'] == 1 )
{
	?>
	<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">
		<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></span>
		</button>
		<?php esc_attr_e('Class Added Successfully.','school-mgt');?>
	</div>
	<?php
}
if(isset($_GET['message']) && $_GET['message'] == 2 )
{
	?>
	<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">
		<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></span>
		</button>
		<?php esc_attr_e('Class Updated Successfully.','school-mgt');?>
	</div>
	<?php
}
if(isset($_GET['message']) && $_GET['message'] == 3 )
{
	?>
	<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">
		<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></span>
		</button>
		<?php esc_attr_e('Class Deleted Successfully.','school-mgt');?>
	</div>
	<?php
}
?>
<!-- Nav tabs -->
<div class="panel-body panel-white frontend_list_margin_30px_res"><!-------------- PENAL BODY ------------>
	<?php
	//------------- ACTIVE TAB CLASS LIST -------------//
	if($active_tab == 'classlist')
	{
		$tablename="smgt_class";
		$user_id=get_current_user_id();
		$own_data=$user_access['own_data'];
		//------- EXAM DATA FOR TEACHER ---------//
		if($school_obj->role == 'teacher')
		{
			
			if($own_data == '1')
			{ 
				$class_id 	= 	get_user_meta(get_current_user_id(),'class_name',true);	
				$retrieve_class	=mj_smgt_get_all_class_data_by_class_array($class_id);
			}
			else
			{
				$retrieve_class = mj_smgt_get_all_data($tablename);			
			}
		}
		//------- EXAM DATA FOR SUPPORT STAFF ---------//
		else
		{ 
	        if($own_data == '1')
			{ 
			  $retrieve_class = mj_smgt_get_all_class_created_by_user($user_id);	
			}
			else
			{
				$retrieve_class = mj_smgt_get_all_data($tablename);	
				
			}
		} 
		if(!empty($retrieve_class))
		{
			?>
			<div class="panel-body"><!--------------- PENAL BODY ------------->
				<div class="table-responsive"><!--------------- TABLE RESPONSIVE ----------->
					<!----------- CLASS LIST FORM START ---------->
					<form id="frm-example" name="frm-example" method="post">
						<table id="class_list" class="display dataTable exam_datatable" cellspacing="0" width="100%">
							<thead class="<?php echo MJ_smgt_datatable_heder() ?>">
								<tr>
									<?php
									if($role_name == "supportstaff")
									{
										?>
											<th class="padding_0"><input type="checkbox" class="select_all" id="select_all"></th>
										<?php
									}
									?>
									<th><?php  _e( 'Image', 'school-mgt' ) ;?></th>
									<th><?php esc_attr_e('Class Name','school-mgt');?></th>
									<th><?php esc_attr_e('Class Numeric Name','school-mgt');?></th>
									<th><?php esc_attr_e('Student Capacity','school-mgt');?></th>
									<th><?php esc_attr_e('Registered Student','school-mgt');?></th>
									<?php
									if($user_access['add']=='1' || $user_access['edit']=='1' || $user_access['delete']=='1')
									{
										?>
										<th class="text_align_end"><?php _e( 'Action', 'school-mgt' ) ;?></th>
										<?php
									}
									?>
								</tr>
							</thead>
							<tbody>
								<?php 
								foreach ($retrieve_class as $retrieved_data)
								{ 
									?>
									<tr>
										<?php
										if($role_name == "supportstaff")
										{
											?>
											<td class="checkbox_width_10px"><input type="checkbox" class="smgt_sub_chk select-checkbox" name="id[]" value="<?php echo $retrieved_data->class_id;?>"></td>
											<?php
										}
										?>
										
										<td class="user_image width_50px"><img src="<?php echo get_option( 'smgt_student_thumb_new' ) ?>" class="img-circle" /></td>
										<td ><?php if($retrieved_data->class_name){ echo $retrieved_data->class_name; }else{ echo "N/A"; } ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Class Name','school-mgt');?>" ></i></td>
										<td><?php if($retrieved_data->class_num_name){ echo $retrieved_data->class_num_name; }else{ echo "N/A"; } ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Class Numeric Name','school-mgt');?>" ></i></td>
										<td><?php if($retrieved_data->class_capacity){ echo $retrieved_data->class_capacity; }else{ echo "N/A"; } ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Student Capacity','school-mgt');?>" ></i></td>
										<?php
										$class_id=$retrieved_data->class_id;
										$user=count(get_users(array(
											'meta_key' => 'class_name',
											'meta_value' => $class_id
										)));
										?>
										<td><?php if($user != 0){ echo $user; }else{ echo "N/A"; } ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Registered Student','school-mgt');?>" ></i></td>
										<?php
										if($user_access['add']=='1' || $user_access['edit']=='1' || $user_access['delete']=='1')
										{
											?>
											<td class="action">  
												<div class="smgt-user-dropdown">
													<ul class="" style="margin-bottom: 0px !important;">
														<li class="">
															<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">
																<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >
															</a>
															<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">
																<?php
															
																if($user_access['add']=='1')
																{
																	?>
																	<li class="float_left_width_100 ">
																		<a class="float_left_width_100" href="#" id="addremove" class_id="<?php echo $retrieved_data->class_id;?>" model="class_sec"><i class="fa fa-eye"> </i><?php esc_attr_e('View Or Add Section','school-mgt');?></a>
																	</li>
																	<?php
																}
																if($user_access['edit']=='1')
																{
																	?>
																	<li class="float_left_width_100 border_bottom_menu">
																		<a href="?dashboard=user&page=class&tab=addclass&action=edit&class_id=<?php echo $retrieved_data->class_id;?>" class="float_left_width_100"><i class="fa fa-edit"> </i><?php esc_html_e('Edit', 'school-mgt' ) ;?></a>
																	</li>

																	<?php 
																} 
																if($user_access['delete']=='1')
																{
																	?>
																	<li class="float_left_width_100 ">
																		<a href="?dashboard=user&page=class&tab=classlist&action=delete&class_id=<?php echo $retrieved_data->class_id;?>" class="float_left_width_100" style="color: #fd726a !important;" onclick="return confirm('<?php esc_attr_e('Are you sure you want to delete this record?','school-mgt');?>');">
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
											<?php
										}
										?>
									</tr>
									<?php 
								} 
								?>
							</tbody>
						</table>
						<?php
						if($role_name == "supportstaff")
						{
							?>
							<div class="print-button pull-left">
								<button class="btn-sms-color">
									<input type="checkbox" name="id[]" class="select_all" value="<?php echo esc_attr($retrieved_data->ID); ?>" style="margin-top: 0px;">
									<label for="checkbox" class="margin_right_5px"><?php esc_html_e( 'Select All', 'school-mgt' ) ;?></label>
								</button>
								<?php
								if($user_access['delete']=='1')
								{
									?>
									<button id="delete_selected" data-toggle="tooltip" title="<?php esc_html_e('Delete Selected','school-mgt');?>" name="delete_selected" class="delete_selected" ><img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png" ?>" alt=""></button>
									<?php
								}
								?>
							</div>
							<?php
						}
						?>
					</form>
				</div><!------------- TABLE RESPONSIVE ------------------>
			</div><!------------- PENAL BODY ----------------->
			<?php
		}
		else
		{
			if($user_access['add']=='1')
			{
				?>
				<div class="no_data_list_div no_data_img_mt_30px"> 
					<a href="<?php echo home_url().'?dashboard=user&page=class&tab=addclass';?>">
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

	//------------- ACTIVE TAB ADD CLASS FORM ----------------------//
	if($active_tab == 'addclass')
	{
		$edit=0;
		if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
		{
			$edit=1;
			$classdata= mj_smgt_get_class_by_id($_REQUEST['class_id']);
		} 
		?>
       <div class="panel-body"><!-------- penal body -------->
			<form name="class_form" action="" method="post" class="form-horizontal" id="class_form"><!------- form Start --------->
				<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
				<input type="hidden" name="action" value="<?php echo $action;?>">
				<div class="header">	
					<h3 class="first_hed"><?php esc_html_e('Class Information','school-mgt');?></h3>
				</div>
				<div class="form-body user_form">
					<div class="row">	
						<div class="col-md-6">
							<div class="form-group input">
								<div class="col-md-12 form-control">
									<input id="class_name" class="form-control validate[required,custom[popup_category_validation]]" maxlength="50" type="text" value="<?php if($edit){ echo $classdata->class_name;}?>" name="class_name">
									<label for="userinput1" class=""><?php esc_html_e('Class Name','school-mgt');?><span class="required">*</span></label>
								</div>
							</div>
						</div>
						<div class="col-md-6 error_msg_left_margin">
							<div class="form-group input">
								<div class="col-md-12 form-control">
									<input id="class_num_name" class="form-control validate[required,min[0],maxSize[4]] text-input" oninput="this.value = Math.abs(this.value)"  type="number" value="<?php if($edit){ echo $classdata->class_num_name;}?>" name="class_num_name" >
									<label for="userinput1" class=""><?php esc_html_e('Numeric Class Name','school-mgt');?><span class="required">*</span></label>
								</div>
							</div>
						</div>
						<?php wp_nonce_field( 'save_class_admin_nonce' ); ?>		
						<div class="col-md-6">
							<div class="form-group input">
								<div class="col-md-12 form-control">
									<input id="class_capacity" oninput="this.value = Math.abs(this.value)" class="form-control validate[required, min[0],maxSize[4]]" type="number" value="<?php if($edit){ echo $classdata->class_capacity;}?>" name="class_capacity">
									<label for="userinput1" class=""><?php esc_html_e('Student Capacity','school-mgt');?><span class="required">*</span></label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="form-body user_form">
					<div class="row">	
						<div class="col-sm-6 col-md-6 col-lg-6 col-xs-12">        	
							<input type="submit" value="<?php if($edit){ esc_attr_e('Save Class','school-mgt'); }else{ esc_attr_e('Add Class','school-mgt');}?>" name="save_class" class="save_btn" />
						</div> 
					</div>        
				</div>               
			</form> <!------- form end --------->
		</div><!-------- penal body -------->	
		<?php
	}
	?>
</div> <!-------------- PENAL BODY ------------>