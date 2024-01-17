<?php 		
    $obj_leave = new SmgtLeave();
    $role=mj_smgt_get_user_role(get_current_user_id());

	//-------- CHECK BROWSER JAVA SCRIPT ----------//
	mj_smgt_browser_javascript_check();
	$active_tab = isset($_GET['tab'])?$_GET['tab']:'leave_list';
	//--------------- ACCESS WISE ROLE -----------//
	$user_access=mj_smgt_get_userrole_wise_access_right_array();
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

    if(isset($_POST['save_leave']))		
    {
        $nonce = $_POST['_wpnonce'];
        if (wp_verify_nonce( $nonce, 'save_leave_nonce' ) )
        {
            if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
            {
                $result=$obj_leave->hrmgt_add_leave($_POST);
                if($result)
                {
                    wp_redirect ('?dashboard=user&page=leave&tab=leave_list&message=2');
                }
            }
            else
            {
                $result=$obj_leave->hrmgt_add_leave($_POST);
                if($result)
                {
                    wp_redirect ('?dashboard=user&page=leave&tab=leave_list&message=1');
                }
            }    
        }
    }
    if(isset($_POST['approve_comment'])&& $_POST['approve_comment']=='Submit')
    {	
        $result=$obj_leave->hrmgt_approve_leave($_POST);
        if($result)
        {
            wp_redirect ('?dashboard=user&page=leave&tab=leave_list&message=4');
        }
    }
    
    if(isset($_POST['reject_leave'])&& $_POST['reject_leave']=='Submit')
    {	
        $result=$obj_leave->hrmgt_reject_leave($_POST);		
        if($result)
        {
            wp_redirect ('?dashboard=user&page=leave&tab=leave_list&message=5');
        }
    }
    
    if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
    {
        $result=$obj_leave->hrmgt_delete_leave($_REQUEST['leave_id']);
        if($result)
        {
            wp_redirect ('?dashboard=user&page=leave&tab=leave_list&message=3');
        }
    } 
    if(isset($_REQUEST['delete_selected']))
    {
        if(!empty($_REQUEST['id']))
            foreach($_REQUEST['id'] as $id)
                $result=$obj_leave->hrmgt_delete_leave($id);
                if($result)
                {    
                    wp_redirect ('?dashboard=user&page=leave&tab=leave_list&message=3');
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
                wp_redirect ('?dashboard=user&page=leave&tab=leave_list&message=4');
            }
            else
            {
                wp_redirect ('?dashboard=user&page=leave&tab=leave_list&message=6');
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
                wp_redirect ('?dashboard=user&page=leave&tab=leave_list&message=4');
            }
            else
            { 
                wp_redirect ('?dashboard=user&page=leave&tab=leave_list&message=6');
            }
    }
    
    if(isset($_REQUEST['message']))
    {
        $message =$_REQUEST['message'];
        if($message == 1)
        { ?>
             <div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">
                <button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></span>
                </button>
                <p><?php _e('Leave inserted successfully','school-mgt');?></p>
            </div>
            <?php 
        }
        elseif($message == 2)
        { ?> 
            <div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">
                <button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></span>
                </button>
                <p><?php _e("Leave updated successfully.",'school-mgt');?></p>
            </div><?php 
        }
        elseif($message == 3) 
        { ?>
            <div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">
                <button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></span>
                </button>
                <p><?php _e('Leave deleted successfully','school-mgt');?></p>
            </div><?php				
        }
        elseif($message == 4) 
        { ?>
            <div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">
                <button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></span>
                    </button>
                <p><?php _e('Leave Approved successfully','school-mgt'); ?></p>
            </div><?php
        }
        elseif($message == 5) 
        { ?>
            <div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">
                <button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></span>
                </button>
                <p><?php _e('Leave Reject successfully','school-mgt'); ?></p>
            </div><?php
        }
        elseif($message == 6) 
        { ?>
            <div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">
                <button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></span>
                </button>
                <p><?php _e('Oops, Something went wrong.','school-mgt'); ?></p>
            </div><?php
        }
    }
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
		
		<div class="panel-white"><!--------- penal White ------->
			<div class="panel-body"> <!--------- penal body ------->
				<?php 
				if($active_tab == 'leave_list')
				{
					$user_id=get_current_user_id();
					//------- Leave DATA FOR STUDENT ---------//
					if($school_obj->role == 'student')
					{
                        $own_data=$user_access['own_data'];
						if($own_data == '1')
						{
                            $leave_data=$obj_leave->get_single_user_leaves($user_id);	
						}
						else
						{
							$leave_data = mj_smgt_get_all_data('smgt_leave');
						}
					}
					//------- Leave DATA FOR TEACHER ---------//
					elseif($school_obj->role == 'teacher')
					{
                        $own_data=$user_access['own_data'];
						if($own_data == '1')
						{
							$leave_data	=mj_smgt_get_all_leave_created_by($user_id);
                            
						}
						else
						{
							$leave_data = mj_smgt_get_all_data('smgt_leave');
						}
					}
					//------- Leave DATA FOR PARENT ---------//
					elseif($school_obj->role == 'parent')
					{
		                $child_id =get_user_meta($user_id, 'child', true); 
                        $child_id_str = implode($child_id);
                        $own_data=$user_access['own_data'];
						
						$leave_data	=mj_smgt_get_all_leave_parent_by_child_list($child_id_str);
						
					}
					//------- Leave DATA FOR SUPPORT STAFF ---------//
					else
					{
						$own_data=$user_access['own_data'];
						if($own_data == '1')
						{
							$leave_data	=mj_smgt_get_all_leave_created_by($user_id);
						}
						else
						{
							$leave_data = mj_smgt_get_all_data('smgt_leave');
						}
					}
						
					if(!empty($leave_data))
					{	
						 ?>
						<script type="text/javascript">
							jQuery(document).ready(function($)
							{
								"use strict";	
								var table =  jQuery('#leave_list').DataTable({
									
									"order": [[ 2, "asc" ]],
									"dom": 'lifrtp',
									"aoColumns":[	                  
												{"bSortable": false},
												{"bSortable": true},
												{"bSortable": true},
												{"bSortable": true},
												{"bSortable": true},
												{"bSortable": true},
												{"bSortable": true},
												{"bSortable": true},	
                                                <?php
                                                if($user_access['edit']=='1' || $user_access['delete']=='1')
                                                {
                                                    ?>
                                                    {"bSortable": false}
                                                    <?php
                                                }  
                                                ?> 
                                            ],
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
							});
						</script>

						<div class="panel-body">
							<div class="table-responsive">
								<form id="frm-example" name="frm-example" method="post">	
									<table id="leave_list" class="display admin_transport_datatable" cellspacing="0" width="100%">
										<thead class="<?php echo MJ_smgt_datatable_heder() ?>">
											<tr>
												<th><?php _e( 'Image', 'school-mgt' ) ;?></th>
												<th><?php _e( 'Student Name', 'school-mgt' ) ;?></th>
												<th><?php _e( 'Leave Type', 'school-mgt' ) ;?></th>
												<th><?php _e( 'Leave Duration', 'school-mgt' ) ;?></th>
												<th><?php _e( 'Start Date', 'school-mgt' ) ;?></th>
												<th><?php _e( 'End Date', 'school-mgt' ) ;?></th>
												<th><?php _e( 'Status', 'school-mgt' ) ;?></th>
												<th><?php _e( 'Reason', 'school-mgt' ) ;?></th>
                                                <?php
                                                if($user_access['edit']=='1' || $user_access['delete']=='1')
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
														if($retrieved_data->status == "Approved")
														{
															echo "<span class='green_color'> " .$retrieved_data->status." </span>";
														}
														else
														{
															echo "<span class='red_color'> " .$retrieved_data->status." </span>";
														}

                                                     ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Status','school-mgt');?>"></i></td>
													<td><?php echo $retrieved_data->reason;?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Reason','school-mgt');?>"></i></td>
													<?php 
                                                    if($user_access['edit']=='1' || $user_access['delete']=='1')
                                                    { ?>

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
                                                                                    <a href="#" leave_id="<?php echo $retrieved_data->id ?>" class="float_left_width_100 leave-approve"><i class="fa fa-thumbs-o-up"></i> </i><?php esc_html_e('Approve', 'school-mgt' ) ;?></a>
                                                                                </li>
                                                                                <?php
                                                                            }
                                                                            if(($retrieved_data->status!='Approved') AND ($retrieved_data->status!='Rejected'))
                                                                            {
                                                                                ?>
                                                                                <li class="float_left_width_100 border_bottom_menu">
                                                                                    <a href="#" leave_id="<?php echo $retrieved_data->id ?>" class="leave-reject float_left_width_100"><i class="fa fa-thumbs-o-down" ></i> </i><?php esc_html_e('Reject', 'school-mgt' ) ;?></a>
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
                                                                                if($user_access['edit']=='1')
                                                                                {
                                                                                    ?>
                                                                                    <li class="float_left_width_100 border_bottom_menu">
                                                                                        <a href="?dashboard=user&page=leave&tab=add_leave&action=edit&leave_id=<?php echo $retrieved_data->id; ?>" leave_id="'.$retrieved_data->id.'" class="float_left_width_100"><i class="fa fa-edit"> </i><?php esc_html_e('Edit', 'school-mgt' ) ;?></a>
                                                                                    </li>
                                                                                    <?php
                                                                                }
                                                                                if($user_access['delete']=='1')
                                                                                {
                                                                                    ?>
                                                                                    <li class="float_left_width_100 ">
                                                                                        <a href="?dashboard=user&page=leave&tab=leave_list&action=delete&leave_id=<?php echo $retrieved_data->id; ?>" class="float_left_width_100" style="color: #fd726a !important;" onclick="return confirm('<?php esc_attr_e('Are you sure you want to delete this record?','school-mgt');?>');">
                                                                                        <i class="fa fa-trash"></i> <?php esc_html_e( 'Delete', 'school-mgt' ) ;?> </a>
                                                                                    </li>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </ul>

                                                                    </li>
                                                                </ul>
                                                            </div>	
                                                        </td>
                                                        <?php 
                                                    } ?>
												</tr>
												<?php 
												$i++;
											} 
											?>
										</tbody>
									</table>
								</form>
							</div>
						</div>
     					<?php 
					}
                    else
                    {	
                        if($user_access['add']=='1')
                        {
                            ?>
                            <div class="no_data_list_div no_data_img_mt_30px"> 
                                <a href="<?php echo home_url().'?dashboard=user&page=leave&tab=add_leave';?>">
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
					
					?>
					<!-- Start Panel body -->
					<?php 
				}
                if($active_tab == 'add_leave')
	            { 
                    ?>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
                    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/> 
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $('#leave_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});
                        });
                    </script>
                   
                    <script type="text/javascript">
                        $(document).ready(function() {
                            "use strict";
                            $('.add-search-single-select-js').select2({
                            });
                        })
                    </script> 
                    <script type="text/javascript">
                        $(document).ready(function() 
                        {    //EVENT VALIDATIONENGINE
                            "use strict";
                            var start = new Date();
                            var end = new Date(new Date().setYear(start.getFullYear()+1));
                            $(".leave_start_date").datepicker(
                            {
                                dateFormat: "yy-mm-dd",
                                minDate:0,
                                onSelect: function (selected) {
                                    var dt = new Date(selected);
                                    dt.setDate(dt.getDate() + 0);
                                    $(".leave_end_date").datepicker("option", "minDate", dt);
                                },
                                beforeShow: function (textbox, instance) 
                                {
                                    instance.dpDiv.css({
                                        marginTop: (-textbox.offsetHeight) + 'px'                   
                                    });
                                }
                            });
                            $(".leave_end_date").datepicker(
                            {
                                dateFormat: "yy-mm-dd",
                                minDate:0,
                                onSelect: function (selected) {
                                    var dt = new Date(selected);
                                    dt.setDate(dt.getDate() - 0);
                                    $(".leave_start_date").datepicker("option", "maxDate", dt);
                                },
                                beforeShow: function (textbox, instance) 
                                {
                                    instance.dpDiv.css({
                                        marginTop: (-textbox.offsetHeight) + 'px'                   
                                    });
                                }
                            });
                        } );
                    </script>
                        <?php 	                                 
                        $leave_id=0;
                        if(isset($_REQUEST['leave_id']))
                            $leave_id=$_REQUEST['leave_id'];
                            $edit=0;
                        if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
                        {
                            $edit=1;
                            $result = $obj_leave->hrmgt_get_single_leave($leave_id);
                        }
                    ?>

                    <!-- Start Panel body -->
                    <div class="panel-body margin_top_20px padding_top_15px_res"><!--------- penal body ------->
                        <!-- Start Leave form -->
                        <form name="leave_form" action="" method="post" class="form-horizontal" id="leave_form">
                            <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
                            <input id="action" type="hidden" name="action" value="<?php echo $action;?>">
                            <input type="hidden" name="leave_id" value="<?php echo $leave_id;?>"  />
                            <input type="hidden" name="status" value="<?php echo "Not Approved";?>"  />
                            <!-- <input type="hidden" name="student_id" value="<?php echo $student_id;?>"  /> -->
                            
                            <div class="header">	
                                <h3 class="first_hed"><?php esc_html_e('Leave Information','school-mgt');?></h3>
                            </div>
                            <div class="form-body user_form">
                                <div class="row">
                                    <?php
                                    //------- Leave DATA FOR STUDENT ---------//
                                    if($role=="student")
                                    { ?> 
                                        <input value="<?php print get_current_user_id(); ?>" name="student_id" type="hidden" />
                                        <?php 
                                    }
                                    else
                                    {
                                        ?>
                                        <div class="col-md-6 input single_selecte">
                                            <select class="form-control add-search-single-select-js display-members line_height_30px max_width_700" name="student_id">
                                                <option value=""><?php _e('Select Student','school-mgt');?></option>
                                                <?php 
                                                $id = get_current_user_id();
                                                if($edit)
                                                    $student =$result->student_id;
                                                elseif(isset($_REQUEST['student_id']))
                                                    $student =$_REQUEST['student_id'];  
                                                else 
                                                    $student = "";					
                                                    $studentdata=mj_smgt_get_all_student_list('student');;
                                                    if(!empty($studentdata))
                                                    {
                                                        foreach ($studentdata as $retrive_data){ 
                                                            $uid=$retrive_data->ID;
                                                            $emp_id = get_user_meta($uid, 'student', true);
                                                            echo '<option value="'.$retrive_data->ID.'" '.selected($student,$retrive_data->ID).'>'.$retrive_data->display_name.' ('.$retrive_data->ID .')</option>';
                                                    }
                                                } ?>
                                            </select>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <div class="col-md-5 input">
                                        <label class="ml-1 custom-top-label top" for="leave_type"><?php esc_attr_e('Leave Type','school-mgt');?> <span class="require-field">*</span></label>
                                        <select class="form-control line_height_30px validate[required] leave_type width_100" name="leave_type" id="leave_type">
                                            <option value=""><?php esc_html_e('Select Leave Type','school-mgt');?></option>
                                            <?php 
                                            if($edit)
                                                $category =$result->leave_type;
                                            elseif(isset($_REQUEST['leave_type']))
                                                $category =$_REQUEST['leave_type'];  
                                            else 
                                                $category = "";
                                                
                                            $activity_category=mj_smgt_get_all_category('leave_type');
                                            if(!empty($activity_category))
                                            {
                                                foreach ($activity_category as $retrive_data)
                                                {
                                                    echo '<option value="'.$retrive_data->ID.'" '.selected($category,$retrive_data->ID).'>'.$retrive_data->post_title.'</option>';
                                                }

                                            } 
                                            ?> 
                                        </select>	
                                    </div>
                                    <div class="col-sm-12 col-md-1 col-lg-1 col-xl-1 mb-3">
                                        <button id="addremove_cat" class="save_btn sibling_add_remove" model="leave_type"><?php esc_attr_e('Add','school-mgt');?></button>		
                                    </div>

                                    <div class="col-md-6 res_margin_bottom_20px rtl_margin_top_15px">
                                        <div class="form-group">
                                            <div class="col-md-12 form-control">
                                                <div class="row padding_radio">
                                                    <div class="input-group">
                                                        <label class="custom-top-label margin_left_0" for="reason"><?php esc_html_e('Leave Duration','school-mgt');?><span class="required">*</span></label>
                                                        <div class="d-inline-block">
                                                            <?php $durationval = ""; if($edit){ $durationval=$result->leave_duration; }elseif(isset($_POST['duration'])) {$durationval=$_POST['duration'];}?>
                                                            <label class="radio-inline">
                                                                <input id="half_day" type="radio" value="half_day" class="tog duration" name="leave_duration" idset ="<?php if($edit) print $result->id; ?>"  <?php  checked( 'half_day', $durationval);  ?>/><?php _e('Half Day','school-mgt');?>
                                                            </label>
                                                            <label class="radio-inline">
                                                                <?php
                                                                if($edit)
                                                                {
                                                                    ?>
                                                                    <input id="full_day" type="radio" value="full_day" class="tog duration" idset ="<?php if($edit) print $result->id; ?>"  name="leave_duration"  <?php  checked( 'full_day', $durationval);  ?> /><?php _e('Full Day','school-mgt');?> 
                                                                    <?php
                                                                }
                                                                else
                                                                {
                                                                    ?>
                                                                    <input id="full_day" type="radio" value="full_day" class="tog duration" idset ="<?php if($edit) print $result->id; ?>"  name="leave_duration"  <?php  checked( 'full_day', $durationval);  ?> checked /><?php _e('Full Day','school-mgt');?> 
                                                                    <?php
                                                                }
                                                                ?>
                                                            </label>
                                                            <label class="radio-inline margin_left_top">
                                                                <input id="more_then_day" type="radio" idset ="<?php if($edit) print $result->id; ?>" value="more_then_day" class="tog duration" name="leave_duration"  <?php  checked( 'more_then_day', $durationval);  ?>/><?php _e('More Than One Day','school-mgt');?> 
                                                            </label>
                                                        </div>
                                                    </div>												
                                                </div>
                                            </div>
                                        </div>
                                    </div>		
                                    <div id="leave_date" class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                        <?php
                                        if($edit)
                                        {
                                            $durationval=$result->leave_duration;
                                            if($durationval == "more_then_day" )
                                            {
                                                ?>
                                                <div class="row">
                                                    <div  class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                        <div class="form-group input">
                                                            <div class="col-md-12 form-control">
                                                                <input id="leave_start_date" class="form-control validate[required] leave_start_date start_date datepicker1" autocomplete="off" type="text"  name="start_date" value="<?php if($edit){ echo esc_attr(date("Y-m-d",strtotime($result->start_date)));}elseif(isset($_POST['start_date'])) echo esc_attr($_POST['start_date']); else echo date("Y-m-d");?>">
                                                                <label class="active" for="start"><?php esc_html_e('Leave Start Date','school-mgt');?><span class="require-field">*</span></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div  class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                        <div class="form-group input">
                                                            <div class="col-md-12 form-control">
                                                                <input id="leave_end_date" class="form-control validate[required] leave_end_date start_date datepicker2" type="text"  name="end_date" autocomplete="off" value="<?php if($edit){ echo esc_attr(date("Y-m-d",strtotime($result->end_date)));}elseif(isset($_POST['end_date'])) echo esc_attr($_POST['end_date']); else echo date("Y-m-d");?>">
                                                                <label class="active" for="end"><?php esc_html_e('Leave End Date','school-mgt');?><span class="require-field">*</span></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php 
                                            }
                                            else
                                            {
                                                ?>
                                                <div class="form-group input">
                                                    <div class="col-md-12 form-control">
                                                        <input id="leave_start_date" class="form-control validate[required] leave_start_date start_date datepicker1" autocomplete="off" type="text"  name="start_date" value="<?php if($edit){ echo esc_attr(date("Y-m-d",strtotime($result->start_date)));}elseif(isset($_POST['start_date'])) echo esc_attr($_POST['start_date']); else echo date("Y-m-d");?>">
                                                        <label class="active" for="start"><?php esc_html_e('Leave Start Date','school-mgt');?><span class="require-field">*</span></label>
                                                    </div>
                                                </div>
                                                <?php
                                            }

                                        }
                                        else
                                        {
                                            ?>
                                            <div class="form-group input">
                                                <div class="col-md-12 form-control">
                                                    <input id="leave_start_date" class="form-control validate[required] leave_start_date start_date datepicker1" autocomplete="off" type="text"  name="start_date" value="<?php if($edit){ echo esc_attr(date("Y-m-d",strtotime($result->start_date)));}elseif(isset($_POST['start_date'])) echo esc_attr($_POST['start_date']); else echo date("Y-m-d");?>">
                                                    <label class="active" for="start"><?php esc_html_e('Leave Start Date','school-mgt');?><span class="require-field">*</span></label>
                                                </div>
                                            </div>
                                             <?php
                                        }
                                        ?>
                                    </div>	
                                    <div class="col-md-6 note_text_notice">
                                        <div class="form-group input">
                                            <div class="col-md-12 note_border margin_bottom_15px_res">
                                                <div class="form-field">
                                                    <textarea id="reason" maxlength="150" class="textarea_height_47px form-control validate[required,custom[address_description_validation]]" name="reason"><?php if($edit){echo $result->reason; }elseif(isset($_POST['reason'])) echo $_POST['reason']; ?> </textarea>
                                                    <span class="txt-title-label"></span>
                                                    <label  class="text-area address active" for="note"><?php esc_attr_e('Reason','school-mgt');?><span class="require-field">*</span></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php wp_nonce_field( 'save_leave_nonce' ); ?>
                                </div>
                            </div>
                            <div class="form-body user_form">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input type="submit" value="<?php if($edit){ _e('Save','school-mgt'); }else{ _e('Add Leave','school-mgt');}?>" name="save_leave" class="btn btn-success save_btn"/>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- End Leave form -->
                    </div>
                    <!-- End Panel body -->
                    <?php
                }
				?>
			</div><!--------- penal body ------->
		</div><!--------- penal White ------->
	</div>
</div>
