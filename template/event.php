<?php
mj_smgt_browser_javascript_check();
$role_name=mj_smgt_get_user_role(get_current_user_id());
$obj_event = new event_Manage(); 
$active_tab = isset($_GET['tab'])?$_GET['tab']:'eventlist';
require_once SMS_PLUGIN_DIR. '/school-management-class.php';

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

//------------------ SAVE EVENT --------------------//
if(isset($_POST['save_event']))	
{
    $nonce = $_POST['_wpnonce'];
    if (wp_verify_nonce( $nonce, 'save_event_nonce' ) )
    {
        if($_FILES['upload_file']['name'] != "" && $_FILES['upload_file']['size'] > 0)	
        {
            if($_FILES['upload_file']['size'] > 0)
            {
                $file_name=mj_smgt_load_documets_new($_FILES['upload_file'],$_FILES['upload_file'],$_POST['upload_file']);	
            }
          
        }
        else
        {
            if(isset($_REQUEST['hidden_upload_file']))
            {
                $file_name=$_REQUEST['hidden_upload_file'];
            }
        }
     
        if(isset($_REQUEST['action']) && $_REQUEST['action']=='edit')//EDIT NOTICE
        {
            $result=$obj_event->mj_smgt_insert_event($_POST,$file_name);
            if($result)
            {
                wp_redirect ( home_url().'?dashboard=user&page=event&tab=eventlist&message=2');
            }
        }
        else
        {
            $result=$obj_event->mj_smgt_insert_event($_POST,$file_name);
            if($result)
            {
                wp_redirect ( home_url().'?dashboard=user&page=event&tab=eventlist&message=1');
            }
        }
            
    }
}

//--------------- DELETE SINGLE EVENT ----------------//
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')
{
    $result=$obj_event->mj_smgt_delete_event($_REQUEST['event_id']);
    if($result){
        wp_redirect ( home_url().'?dashboard=user&page=event&tab=eventlist&message=3');
    }
}

//--------------- DELETE MULTIPLE EVENT -----------------//
if(isset($_REQUEST['delete_selected']))
{		
    if(!empty($_REQUEST['id']))
    {
        foreach($_REQUEST['id'] as $id)
        {
            $result=$obj_event->mj_smgt_delete_event($id);
            wp_redirect ( home_url().'?dashboard=user&page=event&tab=eventlist&message=3');
        }
    }
}
?>
<script type="text/javascript">
	$(document).ready(function() 
	{
		//EVENT LIST
		"use strict";
        $('#event_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});
		jQuery('#event_list').DataTable(
		{
			dom: 'lifrtp',
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
				{"bSortable": true},
				{"bSortable": true},
				{"bSortable": true},
				{"bSortable": false}],
				language:<?php echo mj_smgt_datatable_multi_language();?>
		});
		$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'school-mgt') ?>");
	
		jQuery('.select_all').on('click', function(e)
		{
			 if($(this).is(':checked',true))  
			 {
				$(".sub_chk").prop('checked', true);  
			 }  
			 else  
			 {  
				$(".sub_chk").prop('checked',false);  
			 } 
		});
		$("body").on("change",".sub_chk",function(){
			if(false == $(this).prop("checked"))
			{ 
				$(".select_all").prop('checked', false); 
			}
			if ($('.sub_chk:checked').length == $('.sub_chk').length )
			{
				$(".select_all").prop('checked', true);
			}
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
<!-- POP up code -->
<div class="popup-bg">
    <div class="overlay-content">   
    	<div class="notice_content"></div>  
        <div class="modal-content">
			<div class="view_popup"></div>     
		</div>  
    </div>     
</div>
<!-- End POP-UP Code -->
<div class="panel-body panel-white frontend_list_margin_30px_res"><!------------ PANEL BODY ------------>
    <?php
    $message = isset($_REQUEST['message'])?$_REQUEST['message']:'0';
    switch($message)
    {
        case '1':
            $message_string = esc_attr__('Event Inserted successfully.','school-mgt');
            break;
        case '2':
            $message_string = esc_attr__('Event Updated Successfully.','school-mgt');
            break;	
        case '3':
            $message_string = esc_attr__('Event Deleted Successfully.','school-mgt');
            break;
    }
    
    if($message)
    { 
        ?>
		<div id="message" class="alert_msg alert alert-success alert-dismissible " role="alert">
			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true"><img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>" alt=""></span>
			</button>
			<?php echo $message_string;?>
		</div>
		<?php 
    } 
    if($active_tab == 'eventlist')
    {	
        $user_id=get_current_user_id();
		//------- EXAM DATA FOR STUDENT ---------//
		if($school_obj->role == 'student')
		{
			$own_data=$user_access['own_data'];
			if($own_data == '1')
			{ 
                $retrieve_event = $obj_event->MJ_smgt_get_all_event();
			}
			else
			{
                $retrieve_event = $obj_event->MJ_smgt_get_all_event();		
			}
		}
		//------- EXAM DATA FOR TEACHER ---------//
		elseif($school_obj->role == 'teacher')
		{
			$own_data=$user_access['own_data'];
			if($own_data == '1')
			{ 
                $retrieve_event = $obj_event->MJ_smgt_get_own_event_list($user_id);
			}
			else
			{
                $retrieve_event = $obj_event->MJ_smgt_get_all_event();
			}
		}
		//------- EXAM DATA FOR PARENT ---------//
		elseif($school_obj->role == 'parent')
		{
			$own_data=$user_access['own_data'];
			if($own_data == '1')
			{ 
                $retrieve_event = $obj_event->MJ_smgt_get_all_event();
			}
			else
			{
                $retrieve_event = $obj_event->MJ_smgt_get_all_event();
			}
		}
		//------- EXAM DATA FOR SUPPORT STAFF ---------//
		else
		{ 
	       $own_data=$user_access['own_data'];
			if($own_data == '1')
			{			
                $retrieve_event = $obj_event->MJ_smgt_get_own_event_list($user_id);
			}
			else
			{
                $retrieve_event = $obj_event->MJ_smgt_get_all_event();
			}
		} 

        if(!empty($retrieve_event))
        {
            ?>
            <div class="">
                <div class="table-responsive"><!-------- Table Responsive --------->
                    <!-------- Exam List Form --------->
                    <form id="frm-example" name="frm-example" method="post">
                        <table id="event_list" class="display" cellspacing="0" width="100%">
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
                                    <th><?php esc_attr_e('Event Title','school-mgt');?></th>
                                    <th><?php esc_attr_e('Start Date','school-mgt');?></th>
                                    <th><?php esc_attr_e('End Date','school-mgt');?></th>
                                    <th><?php esc_attr_e('Start Time','school-mgt');?></th>
                                    <th><?php esc_attr_e('End Time','school-mgt');?></th>
                                    <th><?php esc_attr_e('Description','school-mgt');?></th>
                                    <th class="text_align_end"><?php _e( 'Action', 'school-mgt' ) ;?></th>
                                </tr>
                            </thead> 
                            <tbody>
                                <?php 
                                $i=0;
                                foreach ($retrieve_event as $retrieved_data)
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
                                        <?php
                                        if($role_name == "supportstaff")
										{
                                            ?>
                                            <td class="checkbox_width_10px">
                                                <input type="checkbox" class="smgt_sub_chk sub_chk select-checkbox" name="id[]" value="<?php echo $retrieved_data->event_id;?>">
                                            </td>
                                            <?php
                                        }
                                        ?>
                                        <td class="user_image width_50px profile_image_prescription padding_left_0">
                                            <a href="#" class="view_details_popup" id="<?php echo $retrieved_data->event_id;?>" type="event_view" >
                                                <p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	
                                                    <img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/White_icons/notice.png"?>" height= "30px" width ="30px" alt="" class="massage_image center">
                                                </p>
                                            </a> 
                                        </td>
                                        <td>
                                            <a href="#" class="view_details_popup" id="<?php echo $retrieved_data->event_id;?>" type="event_view" >
                                                <?php echo $retrieved_data->event_title;?>
                                            </a> 
                                            <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Event Title','school-mgt');?>" ></i>
                                        </td>
                                        <td>
                                            <?php echo mj_smgt_getdate_in_input_box($retrieved_data->start_date); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Start Date','school-mgt');?>" ></i>
                                        </td>
                                        <td>
                                            <?php echo mj_smgt_getdate_in_input_box($retrieved_data->end_date); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('End Date','school-mgt');?>" ></i>
                                        </td>
                                        <td>
                                            <?php echo $retrieved_data->start_time; ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Start Time','school-mgt');?>" ></i>
                                        </td>
                                        <td>
                                            <?php echo $retrieved_data->end_time; ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('End Time','school-mgt');?>" ></i>
                                        </td>
                                        <td>
                                            <?php echo $retrieved_data->description; ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Description','school-mgt');?>" ></i>
                                        </td>
                                        <td class="action">  
                                            <div class="smgt-user-dropdown">
                                                <ul class="" style="margin-bottom: 0px !important;">
                                                    <?php
                                                     if(!empty($retrieved_data->exam_syllabus))
                                                     {
                                                         $doc_data=json_decode($retrieved_data->exam_syllabus);
                                                     }
                                                    ?>
                                                    <li class="">
                                                        <a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >
                                                        </a>
                                                        <ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">
                                                            <li class="float_left_width_100 ">
                                                                <a href="#" class="float_left_width_100 view_details_popup" id="<?php echo $retrieved_data->event_id;?>" type="event_view" ><i class="fa fa-eye" aria-hidden="true"></i>
                                                                    <?php esc_attr_e('View','school-mgt');?>
                                                                </a>
                                                            </li>
                                                            <?php
                                                            if(!empty($retrieved_data->event_doc))
                                                            {
                                                                ?>
                                                                <li class="float_left_width_100">
                                                                    <a target="blank" href="<?php print content_url().'/uploads/school_assets/'.$retrieved_data->event_doc; ?>" class="status_read float_left_width_100" record_id="<?php echo $retrieved_data->exam_id;?>"><i class="fa fa-eye"></i><?php esc_html_e('View Document', 'school-mgt');?></a>
                                                                </li>
                                                                <?php
                                                            }
                                                            if($user_access['edit']=='1')
                                                            {
                                                                ?>
                                                                <li class="float_left_width_100 border_bottom_menu">
                                                                    <a href="?dashboard=user&page=event&tab=add_event&action=edit&event_id=<?php echo $retrieved_data->event_id;?>" class="float_left_width_100"><i class="fa fa-edit"> </i><?php esc_html_e('Edit', 'school-mgt' ) ;?></a>
                                                                </li>
                                                                <?php 
                                                            } 
                                                            if($user_access['delete']=='1')
                                                            {
                                                                ?>
                                                                <li class="float_left_width_100 ">
                                                                    <a href="?dashboard=user&page=event&tab=eventlist&action=delete&event_id=<?php echo $retrieved_data->event_id;?>" class="float_left_width_100" style="color: #fd726a !important;" onclick="return confirm('<?php esc_attr_e('Are you sure you want to delete this record?','school-mgt');?>');">
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
                                    <button data-toggle="tooltip" id="delete_selected" title="<?php esc_html_e('Delete Selected','school-mgt');?>" name="delete_selected" class="delete_selected" ><img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png" ?>" alt=""></button>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                    </form><!-------- Exam List Form --------->
                </div><!-------- Table Responsive --------->
            </div>
            <?php 
        }
        else
        {
            ?>
            <div class="no_data_list_div no_data_img_mt_30px"> 
                <a href="<?php echo home_url().'?dashboard=user&page=event&tab=add_event';?>">
                    <img class="col-md-12 width_100px" src="<?php echo get_option( 'smgt_no_data_img' ) ?>" >
                </a>
                <div class="col-md-12 dashboard_btn margin_top_20px">
                    <label class="no_data_list_label"><?php esc_html_e('Tap on above icon to add your first Record.','school-mgt'); ?> </label>
                </div> 
            </div>		
            <?php
        }
    }
    if($active_tab == 'add_event')
	{
        ?>
        <script type="text/javascript">
            $(document).ready(function() 
            {    //EVENT VALIDATIONENGINE
                "use strict";
                <?php
                if (is_rtl())
                    {
                    ?>	
                        $('#event_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});
                    <?php
                    }
                    else{
                        ?>
                        $('#event_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});
                        <?php
                    }
                ?>
                var start = new Date();
                var end = new Date(new Date().setYear(start.getFullYear()+1));
                $("#start_date_event").datepicker(
                {
                    dateFormat: "yy-mm-dd",
                    minDate:0,
                    onSelect: function (selected) {
                        var dt = new Date(selected);
                        dt.setDate(dt.getDate() + 0);
                        $("#end_date_event").datepicker("option", "minDate", dt);
                    },
                    beforeShow: function (textbox, instance) 
                    {
                        instance.dpDiv.css({
                            marginTop: (-textbox.offsetHeight) + 'px'                   
                        });
                    }
                });
                $("#end_date_event").datepicker(
                {
                dateFormat: "yy-mm-dd",
                minDate:0,
                onSelect: function (selected) {
                        var dt = new Date(selected);
                        dt.setDate(dt.getDate() - 0);
                        $("#start_date_event").datepicker("option", "maxDate", dt);
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
                });
            })
        </script>
        <link rel="stylesheet"	href="<?php echo SMS_PLUGIN_URL.'/assets/css/timepicker_rtl.css'; ?>">
        <script type="text/javascript">
            function fileCheck(obj)
            {   //FILE VALIDATIONENGINE
                "use strict";
                var fileExtension = ['pdf','doc','jpg','jpeg','png'];
                if ($.inArray($(obj).val().split('.').pop().toLowerCase(), fileExtension) == -1)
                {
                    alert("<?php esc_html_e('Sorry, only JPG, pdf, docs., JPEG, PNG And GIF files are allowed.','school-mgt');?>");
                    $(obj).val('');
                }	
            }
        </script>
        <?php 	
        $event_id=0;
        $edit=0;
        if(isset($_REQUEST['event_id']))
        {
            $event_id=$_REQUEST['event_id'];
            $edit=0;
        }
        if(isset($_REQUEST['action']) && sanitize_text_field($_REQUEST['action']) == 'edit')
        {
            $edit=1;
            $result = $obj_event->MJ_smgt_get_single_event($event_id);
        } 
        ?>
                
        <div class="panel-body padding_0"><!--PANEL BODY-->	
            <form name="event_form" action="" method="post" class="form-horizontal" enctype="multipart/form-data" id="event_form"><!--ADD EVENT FORM-->
                <?php $action = sanitize_text_field(isset($_REQUEST['action'])?$_REQUEST['action']:'insert');?>
                <input id="action" type="hidden" name="action" value="<?php echo esc_attr($action);?>">
                <input type="hidden" name="event_id" value="<?php echo esc_attr($event_id);?>"  />
                <div class="header">	
                    <h3 class="first_hed"><?php esc_html_e('Event Information','school-mgt');?></h3>
                </div>
                <div class="form-body user_form"> <!-- user_form Strat-->   
                    <div class="row"><!--Row Div Strat--> 
                        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">
                            <div class="form-group input">
                                <div class="col-md-12 form-control">
                                    <input id="event_title" maxlength="50" class="form-control text-input validate[required,custom[address_description_validation]]" type="text"  value="<?php if($edit){ echo esc_attr($result->event_title);}elseif(isset($_POST['event_title'])) echo esc_attr($_POST['event_title']);?>" name="event_title">
                                    <label class="" for="event_title"><?php esc_html_e('Event Title','school-mgt');?><span class="require-field">*</span></label>
                                </div>
                            </div>
                        </div>
            
                        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 note_text_notice">
                            <div class="form-group input">
                                <div class="col-md-12 note_border margin_bottom_15px_res">
                                    <div class="form-field">
                                        <textarea name="description" id="description" maxlength="150" class="textarea_height_47px form-control validate[required,custom[address_description_validation]] text-input"><?php if($edit){ echo $result->description; }elseif(isset($_POST['description'])) echo esc_textarea($_POST['description']);?></textarea>
                                        <span class="txt-title-label"></span>
                                        <label class="text-area address active" for="desc"><?php esc_html_e('Description','school-mgt');?><span class="require-field">*</span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <style>
                            .dropdown-menu {
                                min-width: 240px;
                            }
                        </style>	
                        <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">
                            <div class="form-group input">
                                <div class="col-md-12 form-control">
                                    <input id="start_date_event" class="form-control validate[required] start_date datepicker1" autocomplete="off" type="text"  name="start_date" value="<?php if($edit){ echo esc_attr(date("Y-m-d",strtotime($result->start_date)));}elseif(isset($_POST['start_date'])) echo esc_attr($_POST['start_date']); else echo date("Y-m-d");?>">
                                    <label class="active" for="start"><?php esc_html_e('Start Date','school-mgt');?><span class="require-field">*</span></label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">
                            <div class="form-group input">
                                <div class="col-md-12 form-control">
                                    <input  id="timepicker" placeholder="<?php esc_html_e('Start Time','school-mgt');?>" type="text" value="<?php if($edit){ echo esc_attr($result->start_time);}elseif(isset($_POST['start_time'])) echo esc_attr($_POST['start_time']);?>" class="form-control validate[required]" name="start_time"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">
                            <div class="form-group input">
                                <div class="col-md-12 form-control">
                                    <input id="end_date_event" class="form-control validate[required] start_date datepicker2" type="text"  name="end_date" autocomplete="off" value="<?php if($edit){ echo esc_attr(date("Y-m-d",strtotime($result->end_date)));}elseif(isset($_POST['end_date'])) echo esc_attr($_POST['end_date']); else echo date("Y-m-d");?>">
                                    <label class="" for="end"><?php esc_html_e('End Date','school-mgt');?><span class="require-field">*</span></label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">
                            <div class="form-group input">
                                <div class="col-md-12 form-control">
                                    <input id="timepicker" placeholder="<?php esc_html_e('End Time','school-mgt');?>" type="text" value="<?php if($edit){ echo esc_attr($result->end_time);}elseif(isset($_POST['end_time'])) echo esc_attr($_POST['end_time']);?>" class="form-control validate[required]" name="end_time"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group input">
                                <div class="col-md-12 form-control upload-profile-image-patient res_rtl_height_50px">
                                    <label class="custom-control-label custom-top-label ml-2" for="Document"><?php esc_html_e('Document','school-mgt');?></label>
                                    <div class="col-sm-12 display_flex">
                                        <input type="hidden" name="hidden_upload_file" value="<?php if($edit){ echo $result->event_doc;}elseif(isset($_POST['upload_file'])) echo $_POST['upload_file'];?>">
                                        <input id="upload_file" name="upload_file" type="file" onchange="fileCheck(this);" class=""  />		
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <!----------   save btn    --------------> 
                <div class="form-body user_form"> <!-- user_form Strat-->   
                    <div class="row"><!--Row Div Strat--> 
                        <div class="col-md-6 col-sm-6 col-xs-12"> 	
                            <?php wp_nonce_field( 'save_event_nonce' ); ?>
                            <input id="save_event_btn" type="submit" value="<?php if($edit){ esc_html_e('Submit','school-mgt'); }else{ esc_html_e('Submit','school-mgt');}?>" name="save_event" class="btn save_btn event_time_validation"/>
                        </div>
                    </div><!--Row Div End--> 
                </div><!-- user_form End--> 
            </form><!--END ADD EVENT FORM-->
        </div><!--END PANEL BODY-->
        <?php
    }
    ?>
</div>