<?php //-------- CHECK BROWSER JAVA SCRIPT ----------//
mj_smgt_browser_javascript_check();
$role=mj_smgt_get_user_role(get_current_user_id());
if($role == 'administrator')
{
	$user_access_add=1;
	$user_access_edit=1;
	$user_access_delete=1;
	$user_access_view=1;
}
else
{
	$user_access=mj_smgt_get_userrole_wise_filter_access_right_array('feepayment');
	$user_access_add=$user_access['add'];
	$user_access_edit=$user_access['edit'];
	$user_access_delete=$user_access['delete'];
	$user_access_view=$user_access['view'];
	
	if (isset ( $_REQUEST ['page'] ))
{	
	if($user_access_view=='0')
	{	
		mj_smgt_access_right_page_not_access_message_admin_side();
		die;
	}
	if(!empty($_REQUEST['action']))
	{
		if ('feepayment' == $user_access['page_link'] && ($_REQUEST['action']=='edit'))
		{
			if($user_access_edit=='0')
			{	
				mj_smgt_access_right_page_not_access_message_admin_side();
				die;
			}			
		}
		if ('feepayment' == $user_access['page_link'] && ($_REQUEST['action']=='delete'))
		{
			if($user_access_delete=='0')
			{	
				mj_smgt_access_right_page_not_access_message_admin_side();
				die;
			}	
		}
		if ('feepayment' == $user_access['page_link'] && ($_REQUEST['action']=='insert'))
		{
			if($user_access_add=='0')
			{	
				mj_smgt_access_right_page_not_access_message_admin_side();
				die;
			}	
		} 
	}
}
}

?>
<script type="text/javascript">
jQuery(document).ready(function($){
	"use strict";	
	$('#expense_form').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});
	$('#invoice_date').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		yearRange:'-65:+25',
		beforeShow: function (textbox, instance) 
		{
			instance.dpDiv.css({
				marginTop: (-textbox.offsetHeight) + 'px'                   
			});
		},   
		onChangeMonthYear: function(year, month, inst) {
			$(this).val(month + "/" + year);
		}
    }); 

    	var blank_income_entry ='';
    	var blank_expense_entry ='';
   		blank_expense_entry = $('#expense_entry').html();   	
  	

   	$('#expense_form').validationEngine({
        promptPosition: "bottomLeft",
        maxErrorsPerField: 1
    });
	
    $("#fees_data").multiselect({
        nonSelectedText: '<?php esc_attr_e( 'Select Fees Type', 'school-mgt' ) ;?>',
        includeSelectAllOption: true,
        selectAllText: '<?php esc_attr_e( 'Select all', 'school-mgt' ) ;?>',
        templates: {
           button: '<button class="multiselect btn btn-default dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><span class="multiselect-selected-text"></span><b class="caret"></b></button>',
       }
    });
	
    $('#invoice_date').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        yearRange: '-65:+25',
        beforeShow: function(textbox, instance) {
            instance.dpDiv.css({
                marginTop: (-textbox.offsetHeight) + 'px'
            });
        },
        onChangeMonthYear: function(year, month, inst) {
            $(this).val(month + "/" + year);
        }
    });
    $('#end_year').on('change',function() {

        var end_value = parseInt($('#end_year option:selected').val());
        var start_value = parseInt($('#start_year option:selected').attr("id"));
        if (start_value > end_value) {
            $("#end_year option[value='']").attr('selected', 'selected');
            alert(language_translate2.starting_year_alert);
            return false;
        }
    });

    var blank_income_entry = '';
    var blank_expense_entry = '';
	blank_expense_entry = $('#expense_entry').html();

	function add_entry() {
	    $("#expense_entry").append(blank_expense_entry);
	}

	function deleteParentElement(n) {
	    alert(language_translate2.do_delete_record);
	    n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
	}

});
</script>
<?php 
$obj_fees= new Smgt_fees();
$obj_feespayment= new mj_smgt_feespayment();
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')
{
	if(isset($_REQUEST['fees_id']))
	{
		$result=$obj_fees->mj_smgt_delete_feetype_data($_REQUEST['fees_id']);
		if($result)
		{
			wp_redirect ( admin_url() . 'admin.php?page=smgt_fees_payment&tab=feeslist&message=feetype_del');
		}
	}
	if(isset($_REQUEST['fees_pay_id']))
	{
		$result=$obj_feespayment->mj_smgt_delete_feetpayment_data($_REQUEST['fees_pay_id']);
		if($result)
		{
			wp_redirect ( admin_url() . 'admin.php?page=smgt_fees_payment&tab=feespaymentlist&message=fee_del');
		}
	}	
}

if(isset($_REQUEST['delete_selected_feetype']))
{		
	if(!empty($_REQUEST['id']))
	foreach($_REQUEST['id'] as $id)
			$result=$obj_feespayment->mj_smgt_delete_feetype_data($id);
	if($result){ 
		?>
		<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible">
			<p><?php esc_attr_e('Fees Type Deleted Successfully.','school-mgt'); ?></p>
			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span class="screen-reader-text">Dismiss this notice.</span></button>
		</div>
		<?php 
	}
}
if(isset($_REQUEST['delete_selected_feelist']))
{		
	if(!empty($_REQUEST['id']))
	foreach($_REQUEST['id'] as $id)
			$result=$obj_feespayment->mj_smgt_delete_feetpayment_data($id);
	if($result)
	{ 
		?>
		<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible">
			<p><?php esc_html_e('Fee Deleted Successfully.','school-mgt'); ?></p>
			<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span class="screen-reader-text">Dismiss this notice.</span></button>
		</div>
		<?php 
	}
}
	
if(isset($_POST['save_feetype']))
{	
    $nonce = $_POST['_wpnonce'];
	if ( wp_verify_nonce( $nonce, 'save_fees_type_admin_nonce' ) )	
	{		
		if($_REQUEST['action']=='edit')
		{	
			$result=$obj_fees->mj_smgt_add_fees($_POST);
			if($result)
			{
				wp_redirect ( admin_url() . 'admin.php?page=smgt_fees_payment&tab=feeslist&message=fee_edit');
			}
		}
		else
		{
			if(!$obj_fees->mj_smgt_is_duplicat_fees($_POST['fees_title_id'],$_POST['class_id']))
			{
				$result=$obj_fees->mj_smgt_add_fees($_POST);			
				if($result)
				{
					wp_redirect ( admin_url() . 'admin.php?page=smgt_fees_payment&tab=feeslist&message=feetype_add');
				}
			}
			else
			{
				wp_redirect ( admin_url() . 'admin.php?page=smgt_fees_payment&tab=feeslist&message=fee_dub');
			}
		}	
    }	
}	
if(isset($_POST['add_feetype_payment']))
{		
	$result=$obj_feespayment->mj_smgt_add_feespayment_history($_POST);			
	if($result)
	{
		wp_redirect ( admin_url() . 'admin.php?page=smgt_fees_payment&tab=feespaymentlist&message=1');
	}
}

if(isset($_POST['save_feetype_payment']))
{	
    $nonce = $_POST['_wpnonce'];
	if ( wp_verify_nonce( $nonce, 'save_payment_fees_admin_nonce' ) )
    {	
		if(isset($_REQUEST['smgt_enable_feesalert_mail']))
			update_option( 'smgt_enable_feesalert_mail', 1 );
		else
			update_option( 'smgt_enable_feesalert_mail', 0 );
			
		if($_REQUEST['action']=='edit')
		{
			 
			$result=$obj_feespayment->mj_smgt_add_feespayment($_POST);
			if($result)
			{
				wp_redirect ( admin_url() . 'admin.php?page=smgt_fees_payment&tab=feespaymentlist&message=feetype_edit');
			}
		}
		else
		{		
			$result=$obj_feespayment->mj_smgt_add_feespayment($_POST);			
			if($result)
			{
				wp_redirect ( admin_url() . 'admin.php?page=smgt_fees_payment&tab=feespaymentlist&message=fee_add');
			}			
		}
    }	
}
/* Fees Reminder for Student and Parent */
if(isset($_REQUEST['action']) && $_REQUEST['action']=='reminder' && isset($_REQUEST['fees_pay_id']))
{

	$fees_id=$_REQUEST['fees_pay_id'];
	$data=$obj_feespayment->mj_smgt_get_single_fee_mj_smgt_payment($fees_id);
	$student_id=$data->student_id;
	$studentinfo=get_userdata($student_id);
	$student_mail=$studentinfo->user_email;
	$student_name=$studentinfo->display_name;
	$parent_id= get_user_meta($student_id, 'parent_id',true);
	foreach($parent_id as $id)
	{
		$parentinfo=get_userdata($id);
	}
	$parent_mail=$parentinfo->user_email;
	$parent_name=$parentinfo->display_name;
	$to=$parent_mail;
	$Due_amt = $data->total_amount-$data->fees_paid_amount;
	$due_amount=number_format($Due_amt,2);

	/* SMS Notification */
	$current_sms_service = get_option( 'smgt_sms_service');										
	if(!empty($parent_id))
	{
		$parent_number=array();
		foreach ($parent_id as $user_id)
		{
			$parent_number[] = "+".mj_smgt_get_countery_phonecode(get_option( 'smgt_contry' )).get_user_meta($user_id, 'mobile_number',true);
			$reciever_number = mj_smgt_get_countery_phonecode(get_option( 'smgt_contry' )).get_user_meta($user_id, 'mobile_number',true);	
		}
		$message_content = "We just wanted to send you a reminder that the tuition fee has not been paid against your child ".$student_name;
		if(is_plugin_active('sms-pack/sms-pack.php'))
		{								
			$args = array();
			$args['mobile']=$parent_number;
			$args['message']=$message_content;					
			$args['message_from']='Feeslist';					
			$args['message_side']='front';					
			if($current_sms_service=='telerivet' || $current_sms_service ="MSG91" || $current_sms_service=='bulksmsnigeria' || $current_sms_service=='bulksmsgateway.in' || $current_sms_service=='textlocal.in' ||$current_sms_service=='ViaNettSMS' || $current_sms_service=='africastalking')
			{
				$send = send_sms($args);
			}
		}
		else
		{											
			if($current_sms_service == 'clickatell')
			{
				$clickatell=get_option('smgt_clickatell_sms_service');
				$to = $reciever_number;
				$message = str_replace(" ","%20",$message_content);
				$username = $clickatell['username']; //clickatell username
				$password = $clickatell['password']; // clickatell password
				$api_key = $clickatell['api_key'];//clickatell apikey
				$baseurl ="http://api.clickatell.com";									
				$url = "$baseurl/http/auth?user=$username&password=$password&api_id=$api_key";									
				
				$ret = file_get_contents($url);							
				$sess = explode(":",$ret);
				if ($sess[0] == "OK")
				{
					$sess_id = trim($sess[1]); // remove any whitespace
					$url = "$baseurl/http/sendmsg?session_id=$sess_id&to=$reciever_number&text=".urlencode($message_content);									
					$ret = file_get_contents($url);
					$send = explode(":",$ret[0]);								
				}				
			}
			if($current_sms_service == 'twillo')
			{
				require_once SMS_PLUGIN_DIR. '/lib/twilio/Services/Twilio.php';
				$twilio=get_option( 'smgt_twillo_sms_service');
				$account_sid = $twilio['account_sid']; //Twilio SID
				$auth_token = $twilio['auth_token']; // Twilio token
				$from_number = $twilio['from_number'];//My number
				$receiver = $reciever_number; //Receiver Number
				$message = $message_content; // Message Text									
				$client = new Services_Twilio($account_sid, $auth_token);
				$message_sent = $client->account->messages->sendMessage(
					$from_number, // From a valid Twilio number
					$receiver, // Text this number
					$message
				);				
			}
			if($current_sms_service == 'msg91')
			{
				$country_code=mj_smgt_get_countery_phonecode(get_option( 'smgt_contry' ));
				$message = $message_content; // Message Text
				$send=smgt_msg91_send_mail_function($reciever_number,$message,$country_code);
			}								
		} 
	} 
	/* Mail Notification */
	$subject	= 	get_option('fee_payment_reminder_title'); 
	$Seach['{{student_name}}']	     =	 $student_name;
	$Seach['{{parent_name}}']		 =	 $parent_name;
	$Seach['{{total_amount}}']	 	 =	 $data->total_amount;
	$Seach['{{due_amount}}']		 =	 $due_amount;
	$Seach['{{class_name}}']		 =  	mj_smgt_get_class_name($data->class_id);
	$Seach['{{school_name}}']	     =	 get_option( 'smgt_school_name' );			
	$MsgContent 	= 	mj_smgt_string_replacement($Seach,get_option('fee_payment_reminder_mailcontent'));

	$from		= 	get_option('smgt_school_name');
	$fromemail		= 	get_option('smgt_email');
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/plain; charset=iso-8859-1\r\n";

	if(get_option('smgt_mail_notification') == '1')
	{
		$send=wp_mail($to,$subject,$MsgContent,$headers);	
	}
	if($send)
	{
		wp_redirect ( admin_url() . 'admin.php?page=smgt_fees_payment&tab=feespaymentlist&message=mail_success');
	}
	else
	{
		wp_redirect ( admin_url() . 'admin.php?page=smgt_fees_payment&tab=feespaymentlist&message=mail_faild');
	}
}

if(isset($_REQUEST['fees_reminder_feeslist']))
{		
	if(!empty($_REQUEST['id']))
	{
		foreach($_REQUEST['id'] as $id)
		{
			$fees_id=$id;
			$data=$obj_feespayment->mj_smgt_get_single_fee_mj_smgt_payment($fees_id);
			$student_id=$data->student_id;
			$studentinfo=get_userdata($student_id);
			$student_mail=$studentinfo->user_email;
			$student_name=$studentinfo->display_name;
			$parent_id= get_user_meta($student_id, 'parent_id',true);
			if (is_array($parent_id) || is_object($parent_id))
			{
				foreach($parent_id as $id)
				{
					$parentinfo=get_userdata($id);
				}
			}
			$parent_mail=$parentinfo->user_email;
			$parent_name=$parentinfo->display_name;
			$to=$parent_mail;
			$Due_amt = $data->total_amount-$data->fees_paid_amount;
			$due_amount=number_format($Due_amt,2);
			$subject	= 	get_option('fee_payment_reminder_title'); 
			$Seach['{{student_name}}']	     =	 $student_name;
			$Seach['{{parent_name}}']		 =	 $parent_name;
			$Seach['{{total_amount}}']	 	 =	 $data->total_amount;
			$Seach['{{due_amount}}']		 =	 $due_amount;
			$Seach['{{class_name}}']		 =  	mj_smgt_get_class_name($data->class_id);
			$Seach['{{school_name}}']	     =	 get_option( 'smgt_school_name' );			
			$MsgContent 	= 	mj_smgt_string_replacement($Seach,get_option('fee_payment_reminder_mailcontent'));

			$from		= 	get_option('smgt_school_name');
			$fromemail		= 	get_option('smgt_email');
			$headers  = "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/plain; charset=iso-8859-1\r\n";
			if(get_option('smgt_mail_notification') == '1')
			{
				$mail_send=wp_mail($to,$subject,$MsgContent,$headers);	
			}
			if($mail_send)
			{
			    wp_redirect ( admin_url() . 'admin.php?page=smgt_fees_payment&tab=feespaymentlist&message=mail_success');
			}
			else
			{
			    wp_redirect ( admin_url() . 'admin.php?page=smgt_fees_payment&tab=feespaymentlist&message=mail_faild');
			}
		}
	}	
}


$active_tab = isset($_GET['tab'])?$_GET['tab']:'feeslist';
?>
<!-- POP up code -->
<div class="popup-bg">
    <div class="overlay-content fees_type_add_height">
		<div class="modal-content fees_type_model_height">
			<div class=" invoice_data"></div>
			<div class="category_list">
			</div>     
		</div>
    </div>
</div>
<!-- End POP-UP Code -->
<div class="page-inner">
	<div id="" class="payment_list main_list_margin_5px tab_margin_top_40px"> 
		<?php
		$message_string="";
		if(isset($_REQUEST['message']))
		{	
			$message = isset($_REQUEST['message'])?$_REQUEST['message']:'';
			switch($message)
			{
				case 'feetype_del':
					$message_string = esc_attr__('Fees Type Deleted Successfully.','school-mgt');
					break;
				case 'fee_del':
					$message_string = esc_attr__('Fees Deleted Successfully.','school-mgt');
					break;
				case 'fee_edit':
					$message_string = esc_attr__('Fees Updated Successfully.','school-mgt');
					break;
				case 'fee_add':
					$message_string = esc_attr__('Fees Added Successfully.','school-mgt');
					break;
				case 'fee_dub':
					$message_string = esc_attr__('Duplicate Fees.','school-mgt');
					break;
				case 'feetype_edit':
					$message_string = esc_attr__('Fees Type Updated Successfully.','school-mgt');
					break;
				case 'feetype_add':
					$message_string = esc_attr__('Fees Type Added Successfully.','school-mgt');
					break;
				case 'mail_success':
					$message_string = esc_attr__('Fees Payment reminder sent successfully.','school-mgt');
					break;
					case 'mail_faild':
						$message_string = esc_attr__('we can not send mail reminders.','school-mgt');
						break;
				default:
					$message_string = esc_attr__('Fees Payment Successfully Done.','school-mgt');
			}		
			?>
				<div id="message" class="alert updated below-h2 notice is-dismissible alert-dismissible">
					<p><?php echo $message_string;?></p>
					<button type="button" class="btn-default notice-dismiss" data-bs-dismiss="alert" aria-label="Close"><span class="screen-reader-text">Dismiss this notice.</span></button>
				</div>
				<?php 				
		} 
		?>
		<div class="panel-white">
			<div class="panel-body">
				<?php
				if($active_tab !='view_fesspayment')
				{
					$action = "";
					if(!empty($_REQUEST['action']))
					{
						$action = $_REQUEST['action'];
					}
					?>
					<ul class="nav nav-tabs panel_tabs margin_left_1per" role="tablist">
						<li class="<?php if($active_tab=='feeslist'){?>active<?php }?>">			
							<a href="?page=smgt_fees_payment&tab=feeslist" class="padding_left_0 tab <?php echo $active_tab == 'feeslist' ? 'active' : ''; ?>">
							<?php esc_html_e('Fees Type List', 'school-mgt'); ?></a> 
						</li>
						<?php
						if($active_tab=='addfeetype' && $action == 'edit')
						{
							?>
							<li class="<?php if($active_tab=='addfeetype'){?>active<?php }?>">
								<a href="?page=smgt_payment&tab=addfeetype" class="padding_left_0 tab <?php echo $active_tab == 'addfeetype' ? 'active' : ''; ?>">
								<?php esc_html_e('Edit Fees Type', 'school-mgt'); ?></a> 
							</li> 
							<?php
						}
						elseif($active_tab=='addfeetype')
						{
							?>
							<li class="<?php if($active_tab=='addfeetype'){?>active<?php }?>">
								<a href="?page=smgt_payment&tab=addfeetype" class="padding_left_0 tab <?php echo $active_tab == 'addfeetype' ? 'active' : ''; ?>">
								<?php esc_html_e('Add Fees Type', 'school-mgt'); ?></a> 
							</li> 
							<?php
						}
						?>
						<li class="<?php if($active_tab=='feespaymentlist'){?>active<?php }?>">
							<a href="?page=smgt_fees_payment&tab=feespaymentlist" class="padding_left_0 tab <?php echo $active_tab == 'feespaymentlist' ? 'active' : ''; ?>">
							<?php esc_html_e('Fees Payment List', 'school-mgt'); ?></a> 
						</li>  
						<?php
						if($active_tab=='addpaymentfee' && $action == 'edit')
						{
							?>
							<li class="<?php if($active_tab=='addpaymentfee'){?>active<?php }?>">
								<a href="?page=smgt_payment&tab=addpaymentfee" class="padding_left_0 tab <?php echo $active_tab == 'addpaymentfee' ? 'active' : ''; ?>">
								<?php esc_html_e('Edit Payment Fees', 'school-mgt'); ?></a> 
							</li> 
							<?php
						}
						elseif($active_tab=='addpaymentfee')
						{
							?>
							<li class="<?php if($active_tab=='addpaymentfee'){?>active<?php }?>">
								<a href="?page=smgt_payment&tab=addpaymentfee" class="padding_left_0 tab <?php echo $active_tab == 'addpaymentfee' ? 'active' : ''; ?>">
								<?php esc_html_e('Add Fees Payment', 'school-mgt'); ?></a> 
							</li> 
							<?php
						}
					
						?>
					</ul> 
					<?php
				}
				if($active_tab == 'feeslist')
				{	
					$retrieve_class = $obj_fees->mj_smgt_get_all_fees();
					if(!empty($retrieve_class))
					{
						?>
						<script type="text/javascript">
							jQuery(document).ready(function($){
								"use strict";	

								var table =  jQuery('#feetype_list').DataTable({
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
										{"bSortable": false}],
									language:<?php echo mj_smgt_datatable_multi_language();?>
								});
								$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'school-mgt') ?>");
								$("#delete_selected").on('click', function()
								{	
									if ($('.select-checkbox:checked').length == 0 )
									{
										alert(language_translate2.one_record_select_alert);
										return false;
									}
									else
									{
											var alert_msg=confirm("<?php esc_html_e('Are you sure you want to delete this record?', 'school-mgt') ?>");
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
							});
						</script>

						<div class="panel-body">
							<div class="table-responsive">
								<form id="frm-example" name="frm-example" method="post">
									<table id="feetype_list" class="display admin_feestype_datatable" cellspacing="0" width="100%">
										<thead class="<?php echo MJ_smgt_datatable_heder() ?>">
											<tr>
												<th class="padding_0"><input type="checkbox" class="select_all" id="select_all"></th>
												<th><?php  _e( 'Image', 'school-mgt' ) ;?></th>
												<th><?php esc_attr_e('Fees Title','school-mgt');?></th>
												<th><?php esc_attr_e('Class Name','school-mgt');?> </th> 
												<th><?php esc_attr_e('Section Name','school-mgt');?> </th>
												<th><?php esc_attr_e('Fees Amount','school-mgt');?></th>
												<th><?php esc_attr_e('Description','school-mgt');?></th>
												<th class="text_align_end"><?php _e( 'Action', 'school-mgt' ) ;?></th>
											</tr>
										</thead>
										<tbody>
											<?php 
											$i=0;
											foreach ($retrieve_class as $retrieved_data)
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
													<td class="checkbox_width_10px"><input type="checkbox" class="smgt_sub_chk select-checkbox" name="id[]" value="<?php echo $retrieved_data->fees_id;?>"></td>
													<td class="user_image width_50px profile_image_prescription padding_left_0">
														<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	
															<img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Payment.png"?>" alt="" class="massage_image center margin_top_3px">
														</p>
													</td>
													<td><?php echo get_the_title($retrieved_data->fees_title_id);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Fees Title','school-mgt');?>"></i></td>
													<td><?php echo mj_smgt_get_class_name($retrieved_data->class_id);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Class Name','school-mgt');?>"></i></td>
													<td><?php if($retrieved_data->section_id!=0){ echo mj_smgt_get_section_name($retrieved_data->section_id); }else { esc_attr_e('No Section','school-mgt');}?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Section Name','school-mgt');?>"></i></td>				
													<td><?php echo "<span>".mj_smgt_get_currency_symbol()."</span> ".number_format($retrieved_data->fees_amount,2); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Fees Amount','school-mgt');?>"></i></td>
													<?php
													$comment =$retrieved_data->description;
													$comment = ltrim($comment, ' ');
													$description = strlen($comment) > 30 ? substr($comment,0,30)."..." : $comment;
													?>     
													<td>
														<?php
														if(!empty($comment))
														{
															echo $description;
														}else{
															echo "N/A";
														}
															
														?> 
														<i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Description','school-mgt');?>"></i>
													</td>
													<td class="action">  
														<div class="smgt-user-dropdown">
															<ul class="" style="margin-bottom: 0px !important;">
																<li class="">
																	<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">
																		<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >
																	</a>
																	<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">
																		
																		<?php
																		if($user_access_edit == '1')
																		{
																			?>
																			<li class="float_left_width_100 border_bottom_menu">
																				<a href="?page=smgt_fees_payment&tab=addfeetype&action=edit&fees_id=<?php echo $retrieved_data->fees_id;?>" class="float_left_width_100"><i class="fa fa-edit"> </i><?php esc_html_e('Edit', 'school-mgt' ) ;?></a>
																			</li>
																			<?php 
																		} 
																		if($user_access_delete =='1')
																		{
																			?>
																			<li class="float_left_width_100 ">
																				<a href="?page=smgt_fees_payment&tab=feeslist&action=delete&fees_id=<?php echo $retrieved_data->fees_id;?>" class="float_left_width_100" style="color: #fd726a !important;" onclick="return confirm('<?php esc_attr_e('Are you sure you want to delete this record?','school-mgt');?>');">
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
										<?php if($user_access_delete =='1')
										{ 
											?>
											<button data-toggle="tooltip" id="delete_selected" title="<?php esc_html_e('Delete Selected','school-mgt');?>" name="delete_selected_feetype" class="delete_selected" ><img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png" ?>" alt=""></button>
											<?php
										}
										?>
									</div>
								</form>
							</div>
						</div>
     					<?php 
					}
					else
					{
						if($user_access_add=='1')
						{
							?>
							<div class="no_data_list_div no_data_img_mt_30px"> 
								<a href="<?php echo admin_url().'admin.php?page=smgt_fees_payment&tab=addfeetype';?>">
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
				if($active_tab == 'addfeetype')
				{
					require_once SMS_PLUGIN_DIR. '/admin/includes/feespayment/add_feetype.php';
				}
				if($active_tab == 'feespaymentlist')
				{	
					$retrieve_class = $obj_feespayment->mj_smgt_get_all_fees();	
					if(!empty($retrieve_class))
					{
						?>
						<script type="text/javascript">
							jQuery(document).ready(function($){
								var table =  jQuery('#fee_paymnt').DataTable({
									responsive: true,
									"order": [[ 8, "desc" ]],
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
									{"bSortable": true},
									{"bSortable": true},
									{"bSortable": false}],
									language:<?php echo mj_smgt_datatable_multi_language();?>
								});
								$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'school-mgt') ?>");
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
											var alert_msg=confirm("<?php esc_html_e('Are you sure you want to delete this record?', 'school-mgt') ?>");
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
								
								$("#fees_reminder").on('click', function()
								{	
										if ($('.select-checkbox:checked').length == 0 )
										{
											alert(language_translate2.one_record_select_alert);
											return false;
										}
									else
									{
											var alert_msg=confirm("<?php esc_html_e("Are you sure you want to send a mail reminder?",'school-mgt') ?>");
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
								$("#fees_reminder_single").on('click', function()
								{	
									alert(language_translate2.mail_reminder);
									return true;
								});
							});
						</script>

						<div class="panel-body">
							<div class="table-responsive">
								<form id="frm-example" name="frm-example" method="post">	
									<table id="fee_paymnt" class="display" cellspacing="0" width="100%">
										<thead class="<?php echo MJ_smgt_datatable_heder() ?>">
											<tr>
												<th class="padding_0"><input type="checkbox" class="select_all" id="select_all"></th>
												<th><?php  _e( 'Image', 'school-mgt' ) ;?></th>
												<th><?php esc_attr_e('Fees Title','school-mgt');?></th>  
												<th><?php esc_attr_e('Student Name','school-mgt');?></th>
												<th><?php esc_attr_e('Roll No.','school-mgt');?></th>  
												<th><?php esc_attr_e('Class Name','school-mgt');?> </th>  
												<th><?php esc_attr_e('Section Name','school-mgt');?> </th>  
												<th><?php esc_attr_e('Payment Status','school-mgt'); ?></th>
												<th><?php esc_attr_e('Total Amount','school-mgt');?></th>
												<th><?php esc_attr_e('Due Amount','school-mgt');?></th>
												<th><?php esc_attr_e('Start To End Year','school-mgt');?></th>
												<th class="text_align_end"><?php _e( 'Action', 'school-mgt' ) ;?></th>
											</tr>
										</thead>
										<tbody>
											<?php 
											$i=0;			
											foreach ($retrieve_class as $retrieved_data)
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
													<td class="checkbox_width_10px"><input type="checkbox" class="smgt_sub_chk select-checkbox" name="id[]" value="<?php echo $retrieved_data->fees_pay_id;?>"></td>
													<td class="user_image width_50px profile_image_prescription padding_left_0">
														<a href="?page=smgt_fees_payment&tab=view_fesspayment&idtest=<?php echo $retrieved_data->fees_pay_id; ?>&view_type=view_payment" class="" >
															<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	
																<img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Payment.png"?>" alt="" class="massage_image center margin_top_3px">
															</p>
														</a>
													</td>
													<td><?php
													
													$fees_id=explode(',', $retrieved_data->fees_id);
												
													$fees_type=array();
													foreach($fees_id as $id)
													{ 
														$fees_type[] = mj_smgt_get_fees_term_name($id);
													}
													echo implode(" , " ,$fees_type);	
													?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Fees Title','school-mgt');?>"></i></td>

													<td><a href="?page=smgt_student&tab=view_student&action=view_student&student_id=<?php echo $retrieved_data->student_id;?>"><?php echo mj_smgt_get_user_name_byid($retrieved_data->student_id);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Student Name','school-mgt');?>"></i></a></td>
													<td><?php if(!empty(get_user_meta($retrieved_data->student_id, 'roll_id',true))){ echo get_user_meta($retrieved_data->student_id, 'roll_id',true); }else{ echo "N/A"; } ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Roll No.','school-mgt');?>"></i></td>
													<td><?php if(!empty($retrieved_data->class_id)){ echo mj_smgt_get_class_name($retrieved_data->class_id); }else{ echo "N/A"; } ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Class Name','school-mgt');?>"></i></td>
													<td><?php if($retrieved_data->section_id!=0){ echo mj_smgt_get_section_name($retrieved_data->section_id); }else { esc_attr_e('No Section','school-mgt');}?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Section Name','school-mgt');?>"></i></td>
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
													<td><?php echo "<span> ". mj_smgt_get_currency_symbol() ." </span>" . number_format($retrieved_data->total_amount,2); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Total Amount','school-mgt');?>"></i></td>
														<?php 
														$Due_amt = $retrieved_data->total_amount-$retrieved_data->fees_paid_amount;
														$due_amount=number_format($Due_amt,2);
														?>
													<td><?php echo "<span> ". mj_smgt_get_currency_symbol() ." </span>" .$due_amount; ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Due Amount','school-mgt');?>"></i></td>
													<td><?php echo $retrieved_data->start_year.'-'.$retrieved_data->end_year;?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Start To End Year','school-mgt');?>"></i></td>
													<td class="action">  
														<div class="smgt-user-dropdown">
															<ul class="" style="margin-bottom: 0px !important;">
																<li class="">
																	<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">
																		<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/More.png"?>" >
																	</a>
																	<ul class="dropdown-menu heder-dropdown-menu action_dropdawn" aria-labelledby="dropdownMenuLink">
																		<li class="float_left_width_100 ">
																			<a href="?page=smgt_fees_payment&tab=view_fesspayment&idtest=<?php echo $retrieved_data->fees_pay_id; ?>&view_type=view_payment" class="float_left_width_100" >
																				<i class="fa fa-eye"></i><?php esc_attr_e('View','school-mgt');?>
																			</a>
																		</li>
																		<?php
																		if($retrieved_data->fees_paid_amount < $retrieved_data->total_amount || $retrieved_data->fees_paid_amount == 0)
																		{ 
																			?>
																			<li class="float_left_width_100 ">
																				<a href="#" class="float_left_width_100 show-payment-popup" idtest="<?php echo $retrieved_data->fees_pay_id; ?>" view_type="payment" due_amount="<?php echo $due_amount; ?>" ><i class="fa fa-credit-card" aria-hidden="true"></i><?php esc_attr_e('Pay','school-mgt');?></a>
																			</li>
																			<li class="float_left_width_100 ">
																				<a href="?page=smgt_fees_payment&tab=feespaymentlist&action=reminder&fees_pay_id=<?php echo $retrieved_data->fees_pay_id; ?>" class="float_left_width_100" name="fees_reminder" id="fees_reminder_single"><i class="fa fa-bell" aria-hidden="true"></i><?php esc_attr_e('Reminder','school-mgt');?></a>
																			</li>
																			<?php
																		}
																		?>
																	
																		<?php
																		if($user_access_edit == '1')
																		{
																			?>
																			<li class="float_left_width_100 border_bottom_menu">
																				<a href="?page=smgt_fees_payment&tab=addpaymentfee&action=edit&fees_pay_id=<?php echo $retrieved_data->fees_pay_id;?>" class="float_left_width_100"><i class="fa fa-edit"> </i><?php esc_html_e('Edit', 'school-mgt' ) ;?></a>
																			</li>
																			<?php 
																		} 
																		if($user_access_delete =='1')
																		{
																			?>
																			<li class="float_left_width_100 ">
																				<a href="?page=smgt_fees_payment&tab=feespaymentlist&action=delete&fees_pay_id=<?php echo $retrieved_data->fees_pay_id;?>" class="float_left_width_100" style="color: #fd726a !important;" onclick="return confirm('<?php esc_attr_e('Are you sure you want to delete this record?','school-mgt');?>');">
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
										<?php if($user_access_delete =='1')
										{ 
											?>
											<button data-toggle="tooltip" id="delete_selected" title="<?php esc_html_e('Delete Selected','school-mgt');?>" name="delete_selected_feelist" class="delete_selected" ><img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Delete.png" ?>" alt=""></button>
											<?php
										}
										?>
										<input id="fees_reminder" type="submit" value="<?php esc_attr_e('Fees Reminder Selected','school-mgt');?>" name="fees_reminder_feeslist" class="btn btn-primary select_reminder_background fees_reminder margin_top_10px_res"/>
									</div>
								</form>
							</div>
						</div>
						<?php 
					}
					else
					{
						if($user_access_add=='1')
						{
							?>
							<div class="no_data_list_div no_data_img_mt_30px"> 
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
				if($active_tab == 'addpaymentfee')
				{
					require_once SMS_PLUGIN_DIR. '/admin/includes/feespayment/add_paymentfee.php';		
				}	
				elseif($active_tab == 'view_fesspayment')
				{
					require_once SMS_PLUGIN_DIR. '/admin/includes/feespayment/fees_payment_invoice.php';		
				}  
				?>
			</div>
		</div>
	</div>
</div>