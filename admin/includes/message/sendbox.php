
<div class="mailbox-content padding_0"><!-- mailbox-content -->
	<?php
	$offset = 0;
	if(isset($_REQUEST['pg']))
	$offset = $_REQUEST['pg'];
	$max=0;
	$message = mj_smgt_get_send_message(get_current_user_id(),$max,$offset);
	if(!empty($message))
	{
		?>
		<script type="text/javascript">
			jQuery(document).ready(function($)
			{
			"use strict";	
			var table =  jQuery('#sent_list').DataTable({
				responsive: true,
				"dom": 'lifrtp',
				"order": [[ 1, "asc" ]],
				"aoColumns":[		                  
						{"bSortable": false},	                 
						{"bSortable": true},
						{"bSortable": true},
						{"bSortable": true},
						{"bSortable": true},
						{"bSortable": true},	                  
						{"bSortable": true}],
					language:<?php echo mj_smgt_datatable_multi_language();?>
				});
				$('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'school-mgt') ?>");
			

			});
		</script>

		<form name="wcwm_report" action="" method="post"><!-- form-div -->
			<div class="table-responsive" id="sentbox_table"><!-- table-responsive -->
				<table id="sent_list" class="table">
					<thead class="<?php echo MJ_smgt_datatable_heder() ?>">
						<tr>
							<th><?php  _e( 'Image', 'school-mgt' ) ;?></th>
							<th><?php esc_attr_e('Message For','school-mgt');?></th>
							<th><?php esc_attr_e('Class','school-mgt');?></th>
							<th><?php esc_attr_e('Subject','school-mgt');?></th>
							<th><?php esc_attr_e('Description','school-mgt');?></th>
							<th><?php esc_attr_e('Attachment','school-mgt');?></th>
							<th><?php _e( 'Date & Time', 'school-mgt' ) ;?></th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$i=0;	
						foreach($message as $msg_post)
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
							if($msg_post->post_author==get_current_user_id())
							{
								?>
								<tr>
									<td class="user_image width_50px profile_image_prescription padding_left_0">
										<p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	
											<img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/White_icons/sendbox_icon.png"?>" height= "30px" width ="30px" alt="" class="massage_image center">
										</p>
									</td>
									<td>
										<a href="?page=smgt_message&tab=view_message&from=sendbox&id=<?php echo $msg_post->ID;?>" class="text_decoration_none">
											<span>
												<?php 
												$check_message_single_or_multiple=mj_smgt_send_message_check_single_user_or_multiple($msg_post->ID);	
												if($check_message_single_or_multiple == 1)
												{	
													global $wpdb;
													$tbl_name = $wpdb->prefix .'smgt_message';
													$post_id=$msg_post->ID;
													$get_single_user = $wpdb->get_row("SELECT * FROM $tbl_name where post_id = $post_id");
													
													echo mj_smgt_get_display_name($get_single_user->receiver);
												}
												else
												{					
													echo get_post_meta( $msg_post->ID, 'message_for',true);
												}
												?>
											</span>	
										</a> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Message For','school-mgt');?>" ></i>		
									</td>
									<td>
										<a href="?page=smgt_message&tab=view_message&from=sendbox&id=<?php echo $msg_post->ID;?>" class="text_decoration_none">
											<span>
												<?php
												if(get_post_meta( $msg_post->ID, 'smgt_class_id',true) == "" or get_post_meta( $msg_post->ID, 'smgt_class_id',true) == 'all')
												{					
													esc_attr_e('All','school-mgt');
												}
												elseif(get_post_meta( $msg_post->ID, 'smgt_class_id',true) !="")
												{
													$smgt_class_id=get_post_meta( $msg_post->ID, 'smgt_class_id',true);
													$class_id_array=explode(',',$smgt_class_id);
													$class_name_array=array();
													foreach($class_id_array as $data)
													{						
														$class_name_array[]=mj_smgt_get_class_name($data);
															
													}
													echo implode(',',$class_name_array);				
												}
												else
												{
													echo "NA";
												}
												?>
											</span>
										</a> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Class','school-mgt');?>" ></i>
									</td>
									<td class="">
										<a href="?page=smgt_message&tab=view_message&from=sendbox&id=<?php echo $msg_post->ID;?>" class="text_decoration_none">
											<!-- <?php echo $msg_post->post_title;?> -->
											<?php
												$subject_char=strlen($msg_post->post_title);
												if($subject_char <= 10)
												{
													echo $msg_post->post_title;
												}
												else
												{
													$char_limit = 10;
													$subject_body= substr(strip_tags($msg_post->post_title), 0, $char_limit)."...";
													echo $subject_body;
												}
											?>
											<?php 
											if(mj_smgt_count_reply_item($msg_post->ID)>=1)
											{ ?>
												<span class="badge badge-success pull-right"><?php echo mj_smgt_count_reply_item($msg_post->ID);?></span>
												<?php 
											} ?>
										</a> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Subject','school-mgt');?>" ></i>
									</td>
									<td class="">
										<a href="?page=smgt_message&tab=view_message&from=sendbox&id=<?php echo $msg_post->ID;?>" class="text_decoration_none">
											<?php
												$body_char=strlen($msg_post->post_content);
												if($body_char <= 60)
												{
													echo $msg_post->post_content;
												}
												else
												{
													$char_limit = 60;
													$msg_body= substr(strip_tags($msg_post->post_content), 0, $char_limit)."...";
													echo $msg_body;
												}
											?>
										</a> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Description','school-mgt');?>" ></i>
									</td>
									<td>	
										<?php
										$attchment=get_post_meta( $msg_post->ID, 'message_attachment',true);
										
										if(!empty($attchment))
										{
											$attchment_array=explode(',',$attchment);
											foreach($attchment_array as $attchment_data)
											{	
												?>
												<a target="blank" href="<?php echo content_url().'/uploads/school_assets/'.$attchment_data; ?>" class="btn btn-default"><i class="fa fa-download"></i><?php esc_attr_e('View Attachment','school-mgt');?></a></br>
												<?php
											}
										}
										else
										{
											esc_attr_e('No Attachment','school-mgt');
										}
										?>	
									</td>
									<td>
										<a href="?page=smgt_message&tab=view_message&from=sendbox&id=<?php echo $msg_post->ID;?>" class="text_decoration_none">
											<?php		
											$created_date=$msg_post->post_date_gmt;
											echo  mj_smgt_convert_date_time($created_date);
											?>
										</a> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" data-placement="top" title="<?php _e('Date & Time','school-mgt');?>" ></i>
									</td>
								</tr>
								<?php 
								$i++;
							}
						}
						?>
					</tbody>
				</table>
			</div><!-- table-responsive -->
		</form><!-- form-div -->
		<?php
	}
	else
	{
		if($user_access_add=='1')
		{
			?>
			<div class="no_data_list_div no_data_img_mt_30px"> 
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
	?>
</div><!-- mailbox-content -->