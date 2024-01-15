<?php
// This is Dashboard at admin side!!!!!!!!! 
$obj_attend = new Attendence_Manage();
$obj_event = new event_Manage();  
$all_notice = "";
$args['post_type'] = 'notice';
$args['posts_per_page'] = -1;
$args['post_status'] = 'public';
$q = new WP_Query();
$all_notice = $q->query($args);
$notive_array = array();

if (!empty($all_notice)) {
	foreach ($all_notice as $notice) {
		$notice_start_date = get_post_meta($notice->ID, 'start_date', true);
		$notice_end_date = get_post_meta($notice->ID, 'end_date', true);
		$notice_comment = $notice->post_content;
		if(!empty($notice->post_content))
		{
			$notice_comment = $notice->post_content;
		}
		else
		{
			$notice_comment = "N/A";
		}
		$start_date =  $notice->start_date;
		$end_date =  $notice->end_date;
		$notice_for = ucfirst(get_post_meta($notice->ID, 'notice_for',true));
		$i = 1;
		if(get_post_meta( $notice->ID, 'smgt_class_id',true) != "" && get_post_meta( $notice->ID, 'smgt_class_id',true) =="all")
		{
			$class_name = 'All';
		}
		elseif(get_post_meta( $notice->ID, 'smgt_class_id',true) != "")
		{
			$class_name = mj_smgt_get_class_name(get_post_meta($notice->ID, 'smgt_class_id',true));
		}
		else
		{
			$class_name = '';
		}
		
		$start_to_end_date = $start_date.' To '.$end_date;
		$notice_title = $notice->post_title;
		$notive_array[] = array(
			'event_title' => esc_html__( 'Notice Details', 'school-mgt' ),
			'notice_title' => $notice_title,
			'title' => $notice->post_title,
			'description' => 'notice',
			'notice_comment' => $notice_comment,
			'notice_for' => $notice_for,
			'start' => mysql2date('Y-m-d', $notice_start_date),
			'class_name' => $class_name,
			'end' => date('Y-m-d', strtotime($notice_end_date . ' +' . $i . ' days')),
			'color' => '#44CB7F',
			'start_to_end_date' => $start_to_end_date
		);
	}
}
$holiday_list = mj_smgt_get_all_data('holiday');

if (!empty($holiday_list)) {

	foreach ($holiday_list as $holiday) 
	{
		if($holiday->status == 0)
		{
			$notice_start_date = $holiday->date;
			$notice_end_date = $holiday->end_date;
			$i = 1;
			$holiday_title = $holiday->holiday_title;
			$holiday_comment = $holiday->description;
			if(!empty($holiday->description))
			{
				$holiday_comment = $holiday->description;
			}
			else
			{
				$holiday_comment ="N/A";
			}
			$start_to_end_date = $notice_start_date.' To '.$notice_end_date;
			$notive_array[] = array(
				'event_title' => esc_html__( 'Holiday Details', 'school-mgt' ),
				'title' => $holiday->holiday_title,
				'description' => 'holiday',
				'start' => mysql2date('Y-m-d', $notice_start_date),
				'end' => date('Y-m-d', strtotime($notice_end_date . ' +' . $i . ' days')),
				'color' => '#3c8dbc',
				'holiday_title' => $holiday_title,
				'holiday_comment' => $holiday_comment,
				'start_to_end_date' => $start_to_end_date
			);
			//var_dump($notive_array);
			//die;
		}
	}
}

//----------- EVENT FOR CELENDAR -------------//
$event_list = mj_smgt_get_all_data('event');
if(!empty($event_list))
{
	foreach ($event_list as $event) 
	{
		$event_start_date = $event->start_date;
		$event_end_date = $event->end_date;
		$i = 1;
		
		$notive_array[] = array(
			'event_title' => esc_html__( 'Event Details', 'school-mgt' ),
			'title' => $event->event_title,
			'description' => 'event',
			'start' => mysql2date('Y-m-d', $event_start_date),
			'end' => date('Y-m-d', strtotime($event_end_date . ' +' . $i . ' days')),
			'color' => '#36A8EB',
			'event_heading' => $event->event_title,
			'event_comment' => $event->description,
			'event_start_time' => $event->start_time,
			'event_end_time' => $event->end_time,
			'event_start_date' => $event->start_date,
			'event_end_date' => $event->end_date,
		);
	}
}

$exam_list = mj_smgt_get_all_data('exam');
if (!empty($exam_list)) {
	foreach ($exam_list as $exam) {
		
		$exam_start_date = $exam->exam_start_date;
		$exam_end_date = $exam->exam_end_date;
		$i = 1;
		$exam_title = $exam->exam_name;
		$exam_term =  get_the_title($exam->exam_term);
		$class_name = mj_smgt_get_class_name($exam->class_id);
		if(!empty($exam->section_id))
		{ 
			$section_name = mj_smgt_get_section_name($exam->section_id); 
		}
		else
		{ 
			$section_name = "N/A"; 
		}
		if(!empty($exam->exam_comment))
		{ 
			$comment = $exam->exam_comment;
		}
		else
		{ 
			$comment = "N/A"; 
		}
		$total_mark = $exam->total_mark;
		$passing_mark = $exam->passing_mark;
		$notive_array[] = array(
			'exam_title' => $exam_title,
			'exam_term' => $exam_term,
			'section_name' => $section_name,
			'class_name' => $class_name,
			'total_mark' => $total_mark,
			'passing_mark' => $passing_mark,
			'comment' => $comment,
			'start_date' => $exam_start_date,
			'end_date' => $exam_end_date,
			'event_title' => esc_html__( 'Exam Details', 'school-mgt' ),
			'title' => $exam->exam_name,
			'description' => 'exam',
			'start' => mysql2date('Y-m-d', $exam_start_date),
			'end' => date('Y-m-d', strtotime($exam_end_date . ' +' . $i . ' days')),
			'color' => '#5840bb'
		);
	}
}
?>
<style>
	.ui-dialog-titlebar-close
	{
		font-size: 13px !important;
		border: 1px solid transparent !important;
		border-radius: 0 !important;
		outline: 0!important;
		background-color: #fff !important;
		background-image: url("<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Close.png"?>");
		background-repeat: no-repeat;
		float: right;
		color: #fff !important;
		width: 10% !important;
		height: 30px !important;
	}
	.ui-widget-header {
		border: 0px solid #aaaaaa !important;
		background: unset !important;
		font-size: 22px !important;
		color: #333333 !important;
		font-weight: 500 !important;
		font-style: normal!important;
		font-family: Poppins!important;
	}
	.ui-dialog {
		background: #ffffff none repeat scroll 0 0;
		border-radius: 4px;
		box-shadow: 0 0 5px rgb(0 0 0 / 90%);
		cursor: default;
	}
	@media (max-width: 768px)
	{
		.ui-dialog.ui-corner-all.ui-widget.ui-widget-content.ui-front.ui-draggable.ui-resizable
		{
			width: 332px !important;
			left: -131px !important;
			top: 2878.5px !important;
		}
	}
</style>
<!--------------- NOTICE CALENDER POPUP ---------------->
<div id="event_booked_popup" class="modal-body " style="display:none;"><!--MODAL BODY DIV START-->
	<div class="penal-body">
		<div class="row">
			<div class="col-md-6 popup_padding_15px">
				<label for="" class="popup_label_heading"><?php esc_attr_e('Title','school-mgt');?></label><br>
				<label for="" class="label_value" id="notice_title"></label>
			</div>
			<div class="col-md-6 popup_padding_15px">
				<label for="" class="popup_label_heading"><?php esc_attr_e('Start Date To End Date','school-mgt');?></label><br>
				<label for="" class="label_value" id="start_to_end_date"></label>
			</div>
			<div class="col-md-6 popup_padding_15px">
				<label for="" class="popup_label_heading"><?php esc_attr_e('Notice For','school-mgt');?></label><br>
				<label for="" class="label_value" id="notice_for"></label>
			</div>
			<div class="col-md-6 popup_padding_15px">
				<label for="" class="popup_label_heading"><?php esc_attr_e('Class Name','school-mgt');?></label><br>
				<label for="" class="label_value" id="class_name_111"></label>
			</div>
			<div class="col-md-12 popup_padding_15px">
				<label for="" class="popup_label_heading"><?php esc_attr_e('Comment','school-mgt');?></label><br>
				<label for="" class="label_value " id="discription"> </label>
			</div>
		</div>  
	</div>
</div>
<!--------------- HOLIDAY CALENDER POPUP ---------------->
<div id="holiday_booked_popup" class="modal-body " style="display:none;"><!--MODAL BODY DIV START-->
	<div class="penal-body">
		<div class="row">
			<div class="col-md-6 popup_padding_15px">
				<label for="" class="popup_label_heading"><?php esc_attr_e('Title','school-mgt');?></label><br>
				<label for="" class="label_value" id="holiday_title"></label>
			</div>
			<div class="col-md-6 popup_padding_15px">
				<label for="" class="popup_label_heading"><?php esc_attr_e('Start Date To End Date','school-mgt');?></label><br>
				<label for="" class="label_value" id="start_to_end_date"></label>
			</div>
			<div class="col-md-12 popup_padding_15px">
				<label for="" class="popup_label_heading"><?php esc_attr_e('Description','school-mgt');?></label><br>
				<label for="" class="label_value" id="holiday_comment"></label>
			</div>
		</div>  
	</div>
</div>

<!--------------- EXAM CALENDER POPUP ---------------->
<div id="exam_booked_popup" class="modal-body " style="display:none;"><!--MODAL BODY DIV START-->
	<div class="penal-body">
		<div class="row">
			<div class="col-md-6 popup_padding_15px">
				<label for="" class="popup_label_heading"><?php esc_attr_e('Title','school-mgt');?></label><br>
				<label for="" class="label_value" id="exam_title"></label>
			</div>
			<div class="col-md-6 popup_padding_15px">
				<label for="" class="popup_label_heading"><?php esc_attr_e('Term','school-mgt');?></label><br>
				<label for="" class="label_value" id="exam_term"></label>
			</div>
			<div class="col-md-6 popup_padding_15px">
				<label for="" class="popup_label_heading"><?php esc_attr_e('Start Date','school-mgt');?></label><br>
				<label for="" class="label_value" id="start_date"></label>
			</div>
			<div class="col-md-6 popup_padding_15px">
				<label for="" class="popup_label_heading"><?php esc_attr_e('End Date','school-mgt');?></label><br>
				<label for="" class="label_value" id="end_date"></label>
			</div>
			<div class="col-md-6 popup_padding_15px">
				<label for="" class="popup_label_heading"><?php esc_attr_e('Class Name','school-mgt');?></label><br>
				<label for="" class="label_value" id="class_name_123"></label>
			</div>
			<div class="col-md-6 popup_padding_15px">
				<label for="" class="popup_label_heading"><?php esc_attr_e('Section Name','school-mgt');?></label><br>
				<label for="" class="label_value" id="section_name_123"></label>
			</div>
			<div class="col-md-6 popup_padding_15px">
				<label for="" class="popup_label_heading"><?php esc_attr_e('Total Mark','school-mgt');?></label><br>
				<label for="" class="label_value" id="total_mark"></label>
			</div>
			<div class="col-md-6 popup_padding_15px">
				<label for="" class="popup_label_heading"><?php esc_attr_e('Passing Mark','school-mgt');?></label><br>
				<label for="" class="label_value" id="passing_mark"></label>
			</div>
			<div class="col-md-12 popup_padding_15px">
				<label for="" class="popup_label_heading"><?php esc_attr_e('Description','school-mgt');?></label><br>
				<label for="" class="label_value" id="comment"></label>
			</div>
		</div>  
	</div>
</div>

<!--------------- EVENT CALENDER POPUP ---------------->
<div id="event_list_booked_popup" class="modal-body " style="display:none;"><!--MODAL BODY DIV START-->
	<div class="penal-body">
		<div class="row">
			<div class="col-md-6 popup_padding_15px">
				<label for="" class="popup_label_heading"><?php esc_attr_e('Title','school-mgt');?></label><br>
				<label for="" class="label_value" id="event_heading"></label>
			</div>
			<div class="col-md-6 popup_padding_15px">
				<label for="" class="popup_label_heading"><?php esc_attr_e('Start Date','school-mgt');?></label><br>
				<label for="" class="label_value" id="event_start_date_calender"></label>
			</div>
			<div class="col-md-6 popup_padding_15px">
				<label for="" class="popup_label_heading"><?php esc_attr_e('End Date','school-mgt');?></label><br>
				<label for="" class="label_value" id="event_end_date_calender"></label>
			</div>
			<div class="col-md-6 popup_padding_15px">
				<label for="" class="popup_label_heading"><?php esc_attr_e('Start Time','school-mgt');?></label><br>
				<label for="" class="label_value" id="event_start_time_calender"></label>
			</div>
			<div class="col-md-6 popup_padding_15px">
				<label for="" class="popup_label_heading"><?php esc_attr_e('End Time','school-mgt');?></label><br>
				<label for="" class="label_value" id="event_end_time_calender"></label>
			</div>
			<div class="col-md-6 popup_padding_15px">
				<label for="" class="popup_label_heading"><?php esc_attr_e('Description','school-mgt');?></label><br>
				<label for="" class="label_value" id="event_comment_calender"></label>
			</div>
		</div>  
	</div>
</div>
<!DOCTYPE html>
	<html lang="en"><!-- HTML START -->
		<head>
		</head>
		<script>
			var calendar_laungage ="<?php echo mj_smgt_calander_laungage();?>";
			// $ = jQuery.noConflict();
			document.addEventListener('DOMContentLoaded', function() {
				var calendarEl = document.getElementById('calendar');
				var calendar = new FullCalendar.Calendar(calendarEl,{
					initialView: 'dayGridMonth',
					dayMaxEventRows: 1,
					locale: calendar_laungage,
					headerToolbar: {
						left: 'prev,today,next ',
						center: 'title',
						right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
					},
					events: <?php echo json_encode($notive_array); ?>,
					eventClick:  function(event, jsEvent, view) 
					{
						//----------FOR ZOOM ----------//
						if(event.event._def.extendedProps.description=='notice')
						{
							$("#event_booked_popup #notice_title").html(event.event._def.extendedProps.notice_title);
							$("#event_booked_popup #start_to_end_date").html(event.event._def.extendedProps.start_to_end_date);
							$("#event_booked_popup #discription").html(event.event._def.extendedProps.notice_comment);	
							$("#event_booked_popup #notice_for").html(event.event._def.extendedProps.notice_for);					
							$("#event_booked_popup #class_name_111").html(event.event._def.extendedProps.class_name);
							
							$( "#event_booked_popup" ).removeClass( "display_none" );
							$("#event_booked_popup").dialog({ modal: true, title: event.event._def.extendedProps.event_title,width:550, height:300 });
						}
						if(event.event._def.extendedProps.description=='holiday')
						{
							$("#holiday_booked_popup #holiday_title").html(event.event._def.extendedProps.holiday_title);
							$("#holiday_booked_popup #start_to_end_date").html(event.event._def.extendedProps.start_to_end_date);
							$("#holiday_booked_popup #holiday_comment").html(event.event._def.extendedProps.holiday_comment);	
							
							$( "#holiday_booked_popup" ).removeClass( "display_none" );
							$("#holiday_booked_popup").dialog({ modal: true, title: event.event._def.extendedProps.event_title,width:550, height:250 });
						}
						if(event.event._def.extendedProps.description=='exam')
						{
							$("#exam_booked_popup #exam_title").html(event.event._def.extendedProps.exam_title);
							$("#exam_booked_popup #start_date").html(event.event._def.extendedProps.start_date);
							$("#exam_booked_popup #end_date").html(event.event._def.extendedProps.end_date);	
							$("#exam_booked_popup #section_name_123").html(event.event._def.extendedProps.section_name);					
							$("#exam_booked_popup #class_name_123").html(event.event._def.extendedProps.class_name);
							$("#exam_booked_popup #passing_mark").html(event.event._def.extendedProps.passing_mark);					
							$("#exam_booked_popup #total_mark ").html(event.event._def.extendedProps.total_mark);
							$("#exam_booked_popup #exam_term ").html(event.event._def.extendedProps.exam_term);
							$("#exam_booked_popup #comment ").html(event.event._def.extendedProps.comment);
							
							$( "#exam_booked_popup" ).removeClass( "display_none" );
							$("#exam_booked_popup").dialog({ modal: true, title: event.event._def.extendedProps.event_title,width:550, height:480 });
						}
						if(event.event._def.extendedProps.description=='event')
						{
							$("#event_list_booked_popup #event_heading").html(event.event._def.extendedProps.event_heading);
							$("#event_list_booked_popup #event_start_date_calender").html(event.event._def.extendedProps.event_start_date);
							$("#event_list_booked_popup #event_end_date_calender").html(event.event._def.extendedProps.event_end_date);	
							$("#event_list_booked_popup #event_comment_calender").html(event.event._def.extendedProps.event_comment);					
							$("#event_list_booked_popup #event_start_time_calender ").html(event.event._def.extendedProps.event_start_time);
							$("#event_list_booked_popup #event_end_time_calender ").html(event.event._def.extendedProps.event_end_time);
							
							$( "#event_list_booked_popup" ).removeClass( "display_none" );
							$("#event_list_booked_popup").dialog({ modal: true, title: event.event._def.extendedProps.event_title,width:550, height:350 });
						}
					},
				});
				calendar.render();
			});
		</script>
		<!-- body part start  -->
		<body>
			<!--task-event POP up code -->
			<div class="popup-bg">
				<div class="overlay-content content_width">
					<div class="modal-content d-modal-style">
						<div class="task_event_list">
						</div>
					</div>
				</div>
			</div>
			<?php
			if ( is_rtl() )
			{
				$rtl_left_icon_class = "fa-chevron-left";
			}
			else
			{
				$rtl_left_icon_class = "fa-chevron-right";
			}

			$role=mj_smgt_get_user_role(get_current_user_id());
			if($role == "management")
			{
				$admission_page = 'admission';
				$admission_access = mj_smgt_get_userrole_wise_filter_access_right_array($admission_page);

				$student_page='student';
				$student_access = mj_smgt_get_userrole_wise_filter_access_right_array($student_page);

				$teacher_page='teacher';
				$teacher_access = mj_smgt_get_userrole_wise_filter_access_right_array($teacher_page);

				$supportstaff_page='supportstaff';
				$supportstaff_access = mj_smgt_get_userrole_wise_filter_access_right_array($supportstaff_page);

				$parent_page='parent';
				$parent_access = mj_smgt_get_userrole_wise_filter_access_right_array($parent_page);

				$class_page='class';
				$class_access = mj_smgt_get_userrole_wise_filter_access_right_array($class_page);

				$schedule_page='schedule';
				$schedule_access = mj_smgt_get_userrole_wise_filter_access_right_array($schedule_page);

				$virtual_classroom_page='virtual_classroom';
				$virtual_classroom_access = mj_smgt_get_userrole_wise_filter_access_right_array($virtual_classroom_page);

				$subject_page='subject';
				$subject_access = mj_smgt_get_userrole_wise_filter_access_right_array($subject_page);

				$exam_page='exam';
				$exam_access = mj_smgt_get_userrole_wise_filter_access_right_array($exam_page);

				$exam_hall_page='exam_hall';
				$exam_hall_access = mj_smgt_get_userrole_wise_filter_access_right_array($exam_hall_page);

				$manage_marks_page='manage_marks';
				$manage_marks_access = mj_smgt_get_userrole_wise_filter_access_right_array($manage_marks_page);

				$grade_page='grade';
				$grade_access = mj_smgt_get_userrole_wise_filter_access_right_array($grade_page);

				$homework_page='homework';
				$homework_access = mj_smgt_get_userrole_wise_filter_access_right_array($homework_page);

				$attendance_page='attendance';
				$attendance_access = mj_smgt_get_userrole_wise_filter_access_right_array($attendance_page);

				$feepayment_page='feepayment';
				$feepayment_access = mj_smgt_get_userrole_wise_filter_access_right_array($feepayment_page);

				$payment_page='payment';
				$payment_access = mj_smgt_get_userrole_wise_filter_access_right_array($payment_page);

				$library_page='library';
				$library_access = mj_smgt_get_userrole_wise_filter_access_right_array($library_page);

				$hostel_page='hostel';
				$hostel_access = mj_smgt_get_userrole_wise_filter_access_right_array($hostel_page);

				$leave_page='leave';
				$leave_access = mj_smgt_get_userrole_wise_filter_access_right_array($leave_page);
				
				$transport_page='transport';
				$transport_access = mj_smgt_get_userrole_wise_filter_access_right_array($transport_page);

				$report_page='report';
				$report_access = mj_smgt_get_userrole_wise_filter_access_right_array($report_page);

				$notice_page='notice';
				$notice_access = mj_smgt_get_userrole_wise_filter_access_right_array($notice_page);

				$message_page='message';
				$message_access = mj_smgt_get_userrole_wise_filter_access_right_array($message_page);

				$holiday_page='holiday';
				$holiday_access = mj_smgt_get_userrole_wise_filter_access_right_array($holiday_page);

				$notification_page='notification';
				$notification_access = mj_smgt_get_userrole_wise_filter_access_right_array($notification_page);

				$event_page='event';
				$event_access = mj_smgt_get_userrole_wise_filter_access_right_array($event_page);

				$custom_field_page='custom_field';
				$custom_field_access = mj_smgt_get_userrole_wise_filter_access_right_array($custom_field_page);

				$sms_setting_page='sms_setting';
				$sms_setting_access = mj_smgt_get_userrole_wise_filter_access_right_array($sms_setting_page);

				$general_settings_page='general_settings';
				$general_settings_access = mj_smgt_get_userrole_wise_filter_access_right_array($general_settings_page);

				$email_template_page='email_template';
				$email_template_access = mj_smgt_get_userrole_wise_filter_access_right_array($email_template_page);
				
				$migration_page='migration';
				$migration_access =mj_smgt_get_userrole_wise_filter_access_right_array($migration_page);

				$student_view_access = $student_access['view'];
				$student_add_access = $student_access['add'];

				$admission_view_access = $admission_access['view'];
				$admission_add_access = $admission_access['add'];

				$staff_view_access = $supportstaff_access['view'];
				$staff_add_access = $supportstaff_access['add'];

				$teacher_view_access = $teacher_access['view'];
				$teacher_add_access = $teacher_access['add'];

				$parent_view_access = $parent_access['view'];
				$parent_add_access = $parent_access['add'];

				$exam_view_access = $exam_access['view'];
				$exam_add_access = $exam_access['add'];

				$hall_view_access = $exam_hall_access['view'];
				$hall_add_access = $exam_hall_access['add'];

				$mark_view_access = $manage_marks_access['view'];
				$mark_add_access = $manage_marks_access['add'];

				$grade_view_access = $grade_access['view'];
				$grade_add_access = $grade_access['add'];

				$homework_view_access = $homework_access['view'];
				$homework_add_access = $homework_access['add'];

				$attendance_view_access = $attendance_access['view'];
				$attendance_add_access = $attendance_access['add'];

				$fees_view_access = $feepayment_access['view'];
				$fees_add_access = $feepayment_access['add'];

				$payment_view_access = $payment_access['view'];
				$payment_add_access = $payment_access['add'];

				$library_view_access = $library_access['view'];
				$library_add_access = $library_access['add'];

				$leave_view_access  = $leave_access['view'];
				$leave_add_access  = $leave_access['add'];

				$hostel_view_access = $hostel_access['view'];
				$hostel_add_access = $hostel_access['add'];

				$transport_view_access = $transport_access['view'];
				$transport_add_access = $transport_access['add'];

				$report_view_access = $report_access['view'];
				$report_add_access = $report_access['add'];

				$notice_view_access = $notice_access['view'];
				$notice_add_access = $notice_access['add'];

				$message_view_access = $message_access['view'];
				$message_add_access = $message_access['add'];

				$holiday_view_access = $holiday_access['view'];
				$holiday_add_access = $holiday_access['add'];

				$notification_view_access = $notification_access['view'];
				$notification_add_access = $notification_access['add'];

				$event_view_access = $event_access['view'];
				$event_add_access = $event_access['add'];

				$field_view_access = $custom_field_access['view'];
				$field_add_access = $custom_field_access['add'];

				$sms_view_access = $sms_setting_access['view'];
				$sms_add_access = $sms_setting_access['add'];

				$mail_view_access = $email_template_access['view'];
				$mail_add_access = $email_template_access['add'];

				$class_view_access = $class_access['view'];
				$class_add_access = $class_access['add'];

				$schedule_view_access = $schedule_access['view'];
				$schedule_add_access = $schedule_access['add'];

				$virtual_class_view_access = $virtual_classroom_access['view'];
				$virtual_class_add_access = $virtual_classroom_access['add'];

				$subject_view_access = $subject_access['view'];
				$subject_add_access = $subject_access['add'];

				$migration_view_access = $migration_access['view'];
				$migration_add_access = $migration_access['add'];
			}
			else
			{
				$student_view_access = 1;
				$student_add_access = 1;

				$admission_view_access = 1;
				$admission_add_access = 1;

				$staff_view_access = 1;
				$staff_add_access = 1;

				$teacher_view_access = 1;
				$teacher_add_access = 1;

				$parent_view_access = 1;
				$parent_add_access = 1;

				$exam_view_access = 1;
				$exam_add_access = 1;

				$hall_view_access = 1;
				$hall_add_access = 1;

				$mark_view_access = 1;
				$mark_add_access = 1;

				$grade_view_access = 1;
				$grade_add_access = 1;

				$homework_view_access = 1;
				$homework_add_access = 1;

				$attendance_view_access = 1;
				$attendance_add_access = 1;

				$fees_view_access = 1;
				$fees_add_access = 1;

				$payment_view_access = 1;
				$payment_add_access = 1;

				$library_view_access = 1;
				$library_add_access = 1;

				$leave_view_access = 1;
				$leave_add_access = 1;

				$hostel_view_access = 1;
				$hostel_add_access = 1;

				$transport_view_access = 1;
				$transport_add_access = 1;

				$report_view_access = 1;
				$report_add_access = 1;

				$notice_view_access = 1;
				$notice_add_access = 1;

				$message_view_access = 1;
				$message_add_access = 1;

				$holiday_view_access = 1;
				$holiday_add_access = 1;

				$notification_view_access = 1;
				$notification_add_access = 1;

				$event_view_access = 1;
				$event_add_access = 1;

				$field_view_access = 1;
				$field_add_access = 1;

				$sms_view_access = 1;
				$sms_add_access = 1;

				$mail_view_access = 1;
				$mail_add_access = 1;

				$class_view_access = 1;
				$class_add_access = 1;

				$schedule_view_access = 1;
				$schedule_add_access = 1;

				$virtual_class_view_access = 1;
				$virtual_class_add_access = 1;

				$subject_view_access = 1;
				$subject_add_access = 1;

				$migration_view_access = 1;
				$migration_add_access = 1;
			}
			?>
			<div class="row smgt-header admin_dashboard_main_div" style="margin: 0;">
				<!--HEADER PART IN SET LOGO & TITEL START-->
				<div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 padding_0">
					<a href="<?php echo admin_url().'admin.php?page=smgt_school';?>" class='smgt-logo'>
						<img src="<?php  echo get_option( 'smgt_system_logo' ); ?>" class="system_logo_height_width">
					</a>
					
					<!--  toggle button && desgin start-->
					<button type="button" id="sidebarCollapse" class="navbar-btn">
						<span></span>
						<span></span>
						<span></span>
					</button>
					<!--  toggle button && desgin end-->
				</div>
				<div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 smgt-right-heder">
					<div class="row">
						<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 name_and_icon_dashboard align_items_unset_res smgt_header_width">
							<div class="smgt_title_add_btn">
								<!-- Page Name  -->
								<h3 class="smgt-addform-header-title rtl_menu_backarrow_float">
									<?php
										$school_obj = new School_Management ( get_current_user_id () );
										$page_name = "";
										$active_tab = "";
										$action = "";
										if(!empty($_REQUEST['page']))  
										{
											$page_name = $_REQUEST ['page'];  
										}
										if(!empty($_REQUEST['tab']))  
										{
											$active_tab = $_REQUEST['tab'];
										}
										if(!empty($_REQUEST['action']))
										{
											$action = $_REQUEST['action'];
										}
										$role=$school_obj->role;
									
										if(isset( $_REQUEST ['page'] ) && $_REQUEST ['page'] == 'smgt_school')
										{
											echo esc_html_e( 'Welcome to ', 'school-mgt' );
											if($role == 'management')
											{
												echo esc_html_e( "Management", 'school-mgt' );
											}
											else
											{
												echo esc_html_e('Admin', 'school-mgt' );
											}
											echo esc_html_e( ' Dashboard', 'school-mgt' );
										}
										elseif($page_name == 'smgt_student')
										{
											if($active_tab == 'addstudent' || $active_tab == 'view_student')
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_student&tab=studentlist';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">
												</a>
												<?php
												if($action == 'edit'){
													echo esc_html_e('Edit Student', 'school-mgt' );
												}
												elseif($action == 'view_student'){
													echo esc_html_e('View student', 'school-mgt' );
												}
												else{
													echo esc_html_e( 'Add Student', 'school-mgt' );
												}
											}
											else
											{
												echo esc_html_e( 'Student', 'school-mgt' );
											}
										}
										elseif($page_name == 'smgt_teacher')
										{
											if($active_tab == 'addteacher' || $active_tab == 'view_teacher')
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_teacher&tab=teacherlist';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">
												</a>
												<?php
												if($action == 'edit'){
													echo esc_html_e('Edit Teacher', 'school-mgt' );
												}
												elseif($active_tab == 'view_teacher'){
													echo esc_html_e('View teacher', 'school-mgt' );
												}
												else{
													echo esc_html_e( 'Add Teacher', 'school-mgt' );
												}
											}
											else
											{
												echo esc_html_e( 'Teacher', 'school-mgt' );
											}
										}
										elseif($page_name == 'smgt_parent')
										{
											if($active_tab == 'addparent' || $active_tab == 'view_parent')
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_parent&tab=parentlist';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">
												</a>
												<?php
												if($action == 'edit'){
													echo esc_html_e('Edit Parent', 'school-mgt' );
												}
												elseif($action == 'view_parent'){
													echo esc_html_e('View parent', 'school-mgt' );
												}
												else{
													echo esc_html_e( 'Add Parent', 'school-mgt' );
												}
											}
											else
											{
												echo esc_html_e( 'Parent', 'school-mgt' );
											}
										}
										elseif($page_name == 'smgt_supportstaff')
										{
											if($active_tab == 'addsupportstaff' || $active_tab == 'view_supportstaff')
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_supportstaff&tab=supportstaff_list';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">
												</a>
												<?php
												if($action == 'edit')
												{
													echo esc_html_e('Edit Support Staff', 'school-mgt' );
												}
												elseif($action == 'view_supportstaff')
												{
													echo esc_html_e('View support staff', 'school-mgt' );
												}
												else
												{
													echo esc_html_e( 'Add Support Staff', 'school-mgt' );
												}
											}
											else
											{
												echo esc_html_e( 'Support Staff', 'school-mgt' );
											}
										}
										elseif($page_name == 'smgt_student_homewrok')
										{
											if($active_tab == 'addhomework')
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_student_homewrok&tab=homeworklist';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">
												</a>
												<?php
												if($action == 'edit')
												{
													?>
													<?php
													echo esc_html_e('Homework', 'school-mgt' );
												}
												else
												{
													?>
													<?php
													echo esc_html_e( 'Homework', 'school-mgt' );
												}
											}
											elseif($active_tab == 'view_stud_detail')
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_student_homewrok&tab=homeworklist';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">
												</a>
												<?php
												echo esc_html_e( 'View Submission', 'school-mgt' );
											}
											else
											{
												echo esc_html_e( 'Homework', 'school-mgt' );
											}
										}
										elseif($page_name == 'smgt_library')
										{
											if($active_tab == 'booklist' || $active_tab == 'addbook' )
											{
												echo esc_html_e('Book', 'school-mgt' );
											}
											elseif($active_tab == 'issuelist' || $active_tab == 'issuebook')
											{
												echo esc_html_e('Issue Book', 'school-mgt' );
											}
											else
											{
												echo esc_html_e( 'Library', 'school-mgt' );
											}
										}
										elseif($page_name == 'smgt_class')
										{
											if($active_tab == 'addclass')
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_class&tab=classlist';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">
												</a>
												<?php
												if($action == 'edit')
												{
													echo esc_html_e('Edit Class', 'school-mgt' );
												}
												else
												{
													echo esc_html_e( 'Add Class', 'school-mgt' );
												}
											}
											else
											{
												echo esc_html_e( 'Class', 'school-mgt' );
											}
											
										}
										elseif($page_name == 'smgt_admission')
										{
											if($active_tab == 'admission_form' || $active_tab == 'view_admission')
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_admission';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">
												</a>
												<?php
												if($action == 'edit')
												{
													echo esc_html_e('Edit Admission', 'school-mgt' );
												}
												elseif($action == 'view_admission')
												{
													echo esc_html_e( 'View Admission', 'school-mgt' );
												}
												else
												{
													echo esc_html_e( 'Add Admission', 'school-mgt' );
												}
											}
											else
											{
												echo esc_html_e( 'Admission', 'school-mgt' );
											}
											
										}
										elseif($page_name == 'smgt_route')
										{
											if($active_tab == 'addroute')
											{
												?>
												<!-- <a href='<?php echo admin_url().'admin.php?page=smgt_route&tab=route_list';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">
												</a> -->
												<?php
												if($action == 'edit')
												{
													echo esc_html_e('Class Time Table', 'school-mgt' );
												}
												else
												{
													echo esc_html_e( 'Class Time Table', 'school-mgt' );
												}
											}
											else
											{
												echo esc_html_e( 'Class Time Table', 'school-mgt' );
											}
											
										}
										elseif($page_name == 'smgt_virtual_classroom')
										{
											if($active_tab == 'edit_meeting')
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_virtual_classroom';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">
												</a>
												<?php
												if($action == 'edit')
												{
													echo esc_html_e('Edit Virtual Classroom', 'school-mgt' );
												}
												else
												{
													echo esc_html_e( 'Add Virtual Classroom', 'school-mgt' );
												}
											}
											elseif($active_tab == 'view_past_participle_list')
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_virtual_classroom';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">
												</a>
												<?php
												echo esc_html_e( 'Participant List', 'school-mgt' );
											}
											else
											{
												echo esc_html_e( 'Virtual Classroom', 'school-mgt' );
											}
											
										}
										elseif($page_name == 'smgt_exam')
										{
											if($active_tab == 'addexam')
											{
												?>
												<!-- <a href='<?php echo admin_url().'admin.php?page=smgt_exam&tab=examlist';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">
												</a> -->
												<?php
												if($action == 'edit')
												{
													echo esc_html_e('Exam', 'school-mgt' );
												}
												else
												{
													echo esc_html_e( 'Exam', 'school-mgt' );
												}
											}
											else
											{
												echo esc_html_e( 'Exam', 'school-mgt' );
											}
											
										}
										elseif($page_name == 'smgt_Subject')
										{
											if($active_tab == 'addsubject')
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_Subject&tab=Subject';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">
												</a>
												<?php
												if($action == 'edit')
												{
													echo esc_html_e('Edit Subject', 'school-mgt' );
												}
												else
												{
													echo esc_html_e( 'Add Subject', 'school-mgt' );
												}
											}
											else
											{
												echo esc_html_e( 'Subject', 'school-mgt' );
											}
										}
										elseif($page_name == 'smgt_hall')
										{
											if($active_tab == 'addhall')
											{
												?>
												<!-- <a href='<?php echo admin_url().'admin.php?page=smgt_hall&tab=hall_list';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">
												</a> -->
												<?php
												if($action == 'edit')
												{
													echo esc_html_e('Exam Hall', 'school-mgt' );
												}
												else
												{
													echo esc_html_e( 'Exam Hall', 'school-mgt' );
												}
											}
											else
											{
												echo esc_html_e( 'Exam Hall', 'school-mgt' );
											}
										}
										elseif($page_name == 'smgt_grade')
										{
											if($active_tab == 'addgrade')
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_grade&tab=gradelist';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">
												</a>
												<?php
												if($action == 'edit')
												{
													echo esc_html_e('Edit Grade', 'school-mgt' );
												}
												else
												{
													echo esc_html_e( 'Add Grade', 'school-mgt' );
												}
											}
											else
											{
												echo esc_html_e( 'Grade', 'school-mgt' );
											}
										}
									
										elseif($page_name == 'smgt_result')
										{
											if($active_tab == 'result')
											{
												echo esc_html_e( 'Manage Marks', 'school-mgt' );
											}
											elseif($active_tab == 'export_marks')
											{
												echo esc_html_e( 'Export Marks', 'school-mgt' );
											}
											elseif($active_tab == 'multiple_subject_marks')
											{
												echo esc_html_e( 'Multiple Subject Marks', 'school-mgt' );
											}
											else
											{
												echo esc_html_e( 'Manage Marks', 'school-mgt' );
											}
										}
										elseif($page_name == 'smgt_attendence')
										{
											echo esc_html_e( 'Attendance', 'school-mgt' );
										}
										elseif($page_name == 'smgt_library')
										{
											echo esc_html_e( 'Library', 'school-mgt' );
										}
										//--- Leave Module start ---//
										elseif($page_name == 'smgt_leave')
										{
											if($active_tab == 'add_leave')
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_leave&tab=leave_list';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">
												</a>
												<?php
												if($action == 'edit')
												{
													echo esc_html_e('Edit Leave', 'school-mgt' );
												}
												else
												{
													echo esc_html_e( 'Add Leave', 'school-mgt' );
												}
											}
											else
											{
												echo esc_html_e( 'Leave', 'school-mgt' );
											}
										}
										//--- Leave Module End ---//
										//Hostel Module start
										elseif($page_name == 'smgt_hostel')
										{
											if($page_name == 'smgt_hostel' && $active_tab == 'hostel_list')
											{
												echo esc_html_e( 'Hostel', 'school-mgt' );
											}
											elseif($page_name == 'smgt_hostel' && $active_tab == 'room_list')
											{
												echo esc_html_e( 'Room', 'school-mgt' );
											}
											elseif($page_name == 'smgt_hostel' && $active_tab == 'bed_list')
											{
												echo esc_html_e( 'Beds', 'school-mgt' );
											}
											elseif($page_name == 'smgt_hostel' && $active_tab == 'add_hostel')
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_hostel&tab=hostel_list';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">
												</a>
												<?php
												if($action == 'edit')
												{
													echo esc_html_e('Edit Hostel', 'school-mgt' );
												}
												else
												{
													echo esc_html_e( 'Add Hostel', 'school-mgt' );
												}
											}
											elseif($page_name == 'smgt_hostel' && $active_tab == 'add_room')
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_hostel&tab=room_list';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">
												</a>
												<?php
												if($action == 'edit_room')
												{
													echo esc_html_e('Edit Room', 'school-mgt' );
												}
												else
												{
													echo esc_html_e( 'Add Room', 'school-mgt' );
												}
											}
											elseif($page_name == 'smgt_hostel' && $active_tab == 'assign_room')
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_hostel&tab=room_list';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">
												</a>
												<?php
												echo esc_html_e('Assign Room', 'school-mgt' );
											}
											elseif($page_name == 'smgt_hostel' && $active_tab == 'add_bed')
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_hostel&tab=bed_list';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">
												</a>
												<?php
												if($action == 'edit_bed')
												{
													echo esc_html_e('Edit Beds', 'school-mgt' );
												}
												else
												{
													echo esc_html_e( 'Add Beds', 'school-mgt' );
												}
											}
											else
											{
												echo esc_html_e( 'Hostel', 'school-mgt' );
											}
											
										}
										//Hostel Module End
										elseif($page_name == 'smgt_notice')
										{
											if($active_tab == 'addnotice')
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_notice&tab=noticelist';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">
												</a>
												<?php
												if($action == 'edit')
												{
													echo esc_html_e('Edit Notice', 'school-mgt' );
												}
												else
												{
													echo esc_html_e( 'Add Notice', 'school-mgt' );
												}
											}
											else
											{
												echo esc_html_e( 'Notice', 'school-mgt' );
											}
										}
										elseif($page_name == 'smgt_event')
										{
											if($active_tab == 'add_event')
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_event&tab=eventlist';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">
												</a>
												<?php
												if($action == 'edit')
												{
													echo esc_html_e('Edit Event', 'school-mgt' );
												}
												else
												{
													echo esc_html_e( 'Add Event', 'school-mgt' );
												}
											}
											else
											{
												echo esc_html_e( 'Event', 'school-mgt' );
											}
										}
										elseif($page_name == 'smgt_notification')
										{
											if($active_tab == 'addnotification')
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_notification&tab=notificationlist';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">
												</a>
												<?php
												echo esc_html_e( 'Add Notification', 'school-mgt' );
											}
											else
											{
												echo esc_html_e( 'Notification', 'school-mgt' );
											}
										}
										elseif($page_name == 'smgt_holiday')
										{
											if($active_tab == 'addholiday')
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_holiday&tab=holidaylist';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">
												</a>
												<?php
												if($action == 'edit'){
													echo esc_html_e('Edit Holiday', 'school-mgt' );
												}
												else{
													echo esc_html_e( 'Add Holiday', 'school-mgt' );
												}
											}
											else
											{
												echo esc_html_e( 'Holiday', 'school-mgt' );
											}
										}
										elseif($page_name == 'smgt_message')
										{
											echo esc_html_e( 'Message', 'school-mgt' );
										}
										elseif($page_name == 'smgt_Migration')
										{
											echo esc_html_e( 'Migration', 'school-mgt' );
										}
										elseif($page_name == 'smgt_payment')
										{
											if($active_tab == 'payment')
											{
												echo esc_html_e( 'Payment', 'school-mgt' );
											}
											elseif($active_tab == 'incomelist')
											{
												echo esc_html_e( 'Income', 'school-mgt' );
											}
											elseif($active_tab == 'expenselist')
											{
												echo esc_html_e( 'Expense', 'school-mgt' );
											}

											if($active_tab == 'addpayment')
											{
												?>
												<!-- <a href='<?php echo admin_url().'admin.php?page=smgt_payment&tab=payment';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">
												</a> -->
												<?php
												if($action == 'edit')
												{
													echo esc_html_e( 'Payment', 'school-mgt' );
												}
												else
												{
													echo esc_html_e( 'Payment', 'school-mgt' );
												}
												
											}
											elseif($active_tab == 'addincome')
											{
												?>
												<!-- <a href='<?php echo admin_url().'admin.php?page=smgt_payment&tab=incomelist';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">
												</a> -->
												<?php
												if($action == 'edit')
												{
													echo esc_html_e( 'Income', 'school-mgt' );
												}
												else
												{
													echo esc_html_e( 'Income', 'school-mgt' );
												}
												
											}
											elseif($active_tab == 'addexpense')
											{
												?>
												<!-- <a href='<?php echo admin_url().'admin.php?page=smgt_payment&tab=expenselist';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">
												</a> -->
												<?php
												if($action == 'edit')
												{
													echo esc_html_e( 'Expense', 'school-mgt' );
												}
												else
												{
													echo esc_html_e( 'Expense', 'school-mgt' );
												}
											}
											elseif($active_tab == 'view_invoice')
											{
												if($_REQUEST['invoice_type'] == 'invoice')
												{
													?>
													<a href='<?php echo admin_url().'admin.php?page=smgt_payment&tab=payment';?>'>
														<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">
													</a>
													<?php
												}
												elseif($_REQUEST['invoice_type'] == 'income')
												{
													?>
													<a href='<?php echo admin_url().'admin.php?page=smgt_payment&tab=incomelist';?>'>
														<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">
													</a>
													<?php
												}
												elseif($_REQUEST['invoice_type'] == 'expense')
												{
													?>
													<a href='<?php echo admin_url().'admin.php?page=smgt_payment&tab=expenselist';?>'>
														<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">
													</a>
													<?php
												}
												echo esc_html_e( 'View Invoice', 'school-mgt' );
											}
										}
										elseif($page_name == 'smgt_fees_payment')
										{
											if($active_tab == 'feeslist')
											{
												echo esc_html_e( 'Fees Type', 'school-mgt' );
											}
											elseif($active_tab == 'feespaymentlist')
											{
												echo esc_html_e( 'Fees Payment', 'school-mgt' );
											}

											if($active_tab == 'addfeetype')
											{
												?>
												<!-- <a href='<?php echo admin_url().'admin.php?page=smgt_fees_payment&tab=feeslist';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">
												</a> -->
												<?php
												if($action == 'edit')
												{
													echo esc_html_e( 'Fees Type', 'school-mgt' );
												}
												else
												{
													echo esc_html_e( 'Fees Type', 'school-mgt' );
												}
												
											}
											elseif($active_tab == 'addpaymentfee')
											{
												?>
												<!-- <a href='<?php echo admin_url().'admin.php?page=smgt_fees_payment&tab=feespaymentlist';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">
												</a> -->
												<?php
												if($action == 'edit')
												{
													echo esc_html_e( 'Fees Payment', 'school-mgt' );
												}
												else
												{
													echo esc_html_e( 'Fees Payment', 'school-mgt' );
												}
												
											}
											elseif($active_tab == 'view_fesspayment')
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_fees_payment&tab=feespaymentlist';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">
												</a>
												<?php
												echo esc_html_e( 'View Fees Payment Invoice', 'school-mgt' );
											}
										}
										elseif($page_name == 'smgt_transport')
										{
											if($active_tab == 'addtransport')
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_transport&tab=transport';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">
												</a>
												<?php
												if($action == 'edit')
												{
													echo esc_html_e( 'Edit Transport', 'school-mgt' );
												}
												else
												{
													echo esc_html_e( 'Add Transport', 'school-mgt' );
												}
											}
											else
											{
												echo esc_html_e( 'Transport', 'school-mgt' );
											}
										}
										elseif($page_name == 'smgt_report')
										{
											echo esc_html_e( 'Reports', 'school-mgt' );
										}
										elseif($page_name == 'smgt_setup')
										{
											echo esc_html_e( 'License settings', 'school-mgt' );
										}
										elseif($page_name == 'custom_field')
										{
											if($active_tab == 'add_custome_field')
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=custom_field&tab=custome_field_list';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">
												</a>
												<?php
												if($action == 'edit')
												{
													echo esc_html_e( 'Edit Custom Field', 'school-mgt' );
												}
												else
												{
													echo esc_html_e( 'Add Custom Field', 'school-mgt' );
												}
											}
											else
											{
												echo esc_html_e( 'Custom Fields', 'school-mgt' );
											}
										}
										elseif($page_name == 'smgt_sms-setting')
										{
											echo esc_html_e( 'SMS Settings', 'school-mgt' );
										}
										elseif($page_name == 'smgt_email_template')
										{
											echo esc_html_e( 'Email Template', 'school-mgt' );
										}
										elseif($page_name == 'smgt_access_right')
										{
											echo esc_html_e( 'Access Right', 'school-mgt' );
										}
										elseif($page_name == 'smgt_gnrl_settings')
										{
											echo esc_html_e( 'General Settings', 'school-mgt' );
										}
										elseif($page_name == 'smgt_document')
										{
											if($active_tab == 'add_document')
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_document&tab=documentlist';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Back_Arrow.png"?>">
												</a>
												<?php
												if($action == 'edit'){
													echo esc_html_e('Edit Document', 'school-mgt' );
												}
												else{
													echo esc_html_e( 'Add Document', 'school-mgt' );
												}
											}
											else
											{
												echo esc_html_e( 'Documents', 'school-mgt' );
											}
										}
										else
										{
											echo $page_name;
										}
										
									?>
								</h3>
								<div class="smgt_add_btn"><!-------- Plus button div -------->
									<?php
										if($page_name == "smgt_student" && $active_tab != 'addstudent' && $action != 'view_student')
										{
											if($student_add_access == 1)
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_student&tab=addstudent';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">
												</a>
												<?php
											}
											
										}
										elseif($page_name == "smgt_admission" && $active_tab != 'admission_form' && $active_tab != 'view_admission')
										{
											if($admission_add_access == 1)
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_admission&tab=admission_form';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">
												</a>
												<?php
											}
										}
										elseif($page_name == "smgt_class" && $active_tab != 'addclass')
										{
											if($class_add_access == 1)
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_class&tab=addclass';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">
												</a>
												<?php
											}
										}
										elseif($page_name == "smgt_route" && $active_tab != 'addroute')
										{
											if($schedule_add_access == 1)
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_route&tab=addroute';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">
												</a>
												<?php
											}
										}
										elseif($page_name == "smgt_teacher" && $active_tab != 'addteacher' && $active_tab != 'view_teacher' && $action != 'view_teacher')
										{
											if($teacher_add_access == 1)
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_teacher&tab=addteacher';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">
												</a>
												<?php
											}
										}
										elseif($page_name == "smgt_parent" && $active_tab != 'addparent' && $action != 'view_parent')
										{
											if($parent_add_access == 1)
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_parent&tab=addparent';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">
												</a>
												<?php
											}
										}
										elseif($page_name == "smgt_supportstaff" && $active_tab != 'addsupportstaff' && $action != 'view_supportstaff')
										{
											if($staff_add_access == 1)
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_supportstaff&tab=addsupportstaff';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">
												</a>
												<?php
											}
										}
										elseif($page_name == "smgt_student_homewrok" && $active_tab != 'addhomework' && $active_tab != 'view_stud_detail')
										{
											if($homework_add_access == 1)
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_student_homewrok&tab=addhomework';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">
												</a>
												<?php
											}
										}
										elseif($page_name == "smgt_virtual_classroom" && $active_tab != 'edit_meeting' && $active_tab != 'view_past_participle_list')
										{
											if($virtual_class_add_access == 1)
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_route&tab=addroute';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">
												</a>
												<?php
											}
										}
										elseif($page_name == "smgt_Subject" && $active_tab != 'addsubject')
										{
											if($subject_add_access == 1)
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_Subject&tab=addsubject';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">
												</a>
												<?php
											}
										}
										elseif($page_name == "smgt_exam" && $active_tab != 'addexam')
										{
											if($exam_add_access == 1)
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_exam&tab=addexam';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">
												</a>
												<?php
											}
										}
										elseif($page_name == "smgt_hall" && $active_tab != 'addhall')
										{
											if($hall_add_access == 1)
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_hall&tab=addhall';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">
												</a>
												<?php
											}
										}
										elseif($page_name == "smgt_library" && $active_tab == 'issuelist')
										{
											if($library_add_access == 1)
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_library&tab=issuebook';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">
												</a>
												<?php
											}
										}
										elseif($page_name == "smgt_library" && $active_tab == 'booklist')
										{
											if($library_add_access == 1)
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_library&tab=addbook';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">
												</a>
												<?php
											}
										}
										elseif($page_name == "smgt_grade" && $active_tab != 'addgrade')
										{
											if($grade_add_access == 1)
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_grade&tab=addgrade';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">
												</a>
												<?php
											}
										}
										elseif($page_name == 'smgt_hostel' && $active_tab == 'hostel_list')
										{
											if($hostel_add_access == 1)
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_hostel&tab=add_hostel';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">
												</a>
												<?php
											}
										}
										elseif($page_name == "smgt_payment")
										{
											if($active_tab == 'payment')
											{
												if($payment_add_access == 1)
												{
													?>
													<a href='<?php echo admin_url().'admin.php?page=smgt_payment&tab=addpayment';?>'>
														<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">
													</a>
													<?php
												}
											}
											elseif($active_tab == 'incomelist')
											{
												if($payment_add_access == 1)
												{
													?>
													<a href='<?php echo admin_url().'admin.php?page=smgt_payment&tab=addincome';?>'>
														<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">
													</a>
													<?php
												}
											}
											elseif($active_tab == 'expenselist')
											{
												if($payment_add_access == 1)
												{
													?>
													<a href='<?php echo admin_url().'admin.php?page=smgt_payment&tab=addexpense';?>'>
														<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">
													</a>
													<?php
												}
											}
										}
										elseif($page_name == "smgt_fees_payment")
										{
											if($active_tab == 'feeslist')
											{
												if($fees_add_access == 1)
												{
													?>
													<a href='<?php echo admin_url().'admin.php?page=smgt_fees_payment&tab=addfeetype';?>'>
														<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">
													</a>
													<?php
												}
											}
											elseif($active_tab == 'feespaymentlist')
											{
												if($fees_add_access == 1)
												{
													?>
													<a href='<?php echo admin_url().'admin.php?page=smgt_fees_payment&tab=addpaymentfee';?>'>
														<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">
													</a>
													<?php
												}
											}
										}
										elseif($page_name == "smgt_transport" && $active_tab != 'addtransport')
										{
											if($hostel_add_access == 1)
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_transport&tab=addtransport';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">
												</a>
												<?php
											}
										}
										elseif($page_name == "smgt_leave" && $active_tab != 'add_leave')
										{
											if($leave_add_access == 1)
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_leave&tab=add_leave';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">
												</a>
												<?php
											}
										}
										elseif($page_name == 'smgt_hostel' && $active_tab == 'room_list')
										{
											if($hostel_add_access == 1)
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_hostel&tab=add_room';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">
												</a>
												<?php
											}
										}
										elseif($page_name == 'smgt_hostel' && $active_tab == 'bed_list')
										{
											if($hostel_add_access == 1)
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_hostel&tab=add_bed';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">
												</a>
												<?php
											}
										}
										//--- Add Btn hostel End ---//
										elseif($page_name == "smgt_notice" && $active_tab != 'addnotice')
										{
											if($notice_add_access == 1)
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_notice&tab=addnotice';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">
												</a>
												<?php
											}
										}
										elseif($page_name == "smgt_event" && $active_tab != 'add_event')
										{
											if($event_add_access == 1)
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_event&tab=add_event';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">
												</a>
												<?php
											}
										}
										elseif($page_name == "smgt_notification" && $active_tab != 'addnotification')
										{
											if($notification_add_access == 1)
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_notification&tab=addnotification';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">
												</a>
												<?php
											}
										}
										elseif($page_name == "smgt_holiday" && $active_tab != 'addholiday')
										{
											if($holiday_add_access == 1)
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_holiday&tab=addholiday';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">
												</a>
												<?php
											}
										}
										elseif($page_name == "smgt_message")
										{
											if($message_add_access == 1)
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_message&tab=compose';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">
												</a>
												<?php
											}
										}
										elseif($page_name == "custom_field" && $active_tab != 'add_custome_field')
										{
											if($field_add_access == 1)
											{
												?>
												<a href='<?php echo admin_url().'admin.php?page=custom_field&tab=add_custome_field';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">
												</a>
												<?php
											}
										}
										elseif($page_name == "smgt_document" && $active_tab != 'add_document')
										{
											// if($holiday_add_access == 1)
											// {
												?>
												<a href='<?php echo admin_url().'admin.php?page=smgt_document&tab=add_document';?>'>
													<img src="<?php echo SMS_PLUGIN_URL."/assets/images/listpage_icon/Add_new_Button.png" ?>">
												</a>
												<?php
											// }
										}
									
									?>
								</div><!-------- Plus button div -------->
								<!-- End Page Name  -->
							</div>
						</div>
						
						<!-- Right Header  -->
						<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
							<div class="smgt-setting-notification">
								<a href='<?php echo admin_url().'admin.php?page=smgt_gnrl_settings';?>' class="smgt-setting-notification-bg">
									<img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Settings.png"?>" class="smgt-right-heder-list-link">
								</a>
								<a href='<?php echo admin_url().'admin.php?page=smgt_notification';?>' class="smgt-setting-notification-bg">
									<img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Bell-Notification.png"?>" class="smgt-right-heder-list-link">
									<spna class="between_border123 smgt-right-heder-list-link"> </span>
								</a>
								<div class="smgt-user-dropdown">
									<ul class="">
										<!-- BEGIN USER LOGIN DROPDOWN -->
										<li class="">
											<a class="" href="#" data-bs-toggle="dropdown" aria-expanded="false">
												<img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Avatar1.png"?>" class="smgt-dropdown-userimg">
											</a>
											<ul class="dropdown-menu extended action_dropdawn logout_dropdown_menu logout heder-dropdown-menu" aria-labelledby="dropdownMenuLink">
												<li class="float_left_width_100 ">
													<a class="dropdown-item smgt-back-wp float_left_width_100" href="<?php echo admin_url();?>"><i class="fa fa-user"></i>
													<?php esc_html_e( 'Back to wp-admin', 'school-mgt' ); ?></a>
												</li>
												<li class="float_left_width_100 ">
													<a class="dropdown-item float_left_width_100" href="<?php echo wp_logout_url(home_url()); ?>"><i class="fa fa-sign-out"></i><?php esc_html_e( 'Log Out', 'school-mgt' ); ?></a>
												</li>
											</ul>
										</li>
										<!-- END USER LOGIN DROPDOWN -->
									</ul>
								</div>
							</div>
						</div>
						<!-- Right Header  -->
					</div>	
				</div>	
			</div>
			
			<div class="row main_page admin_dashboard_menu_rs"  style="margin: 0;">
				<div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 padding_0" id="main_sidebar-bgcolor">
					<!-- menu sidebar main div strat  -->
					<div class="main_sidebar">
						<nav id="sidebar">
							<ul class='smgt-navigation navbar-collapse rs_side_menu_bgcolor' id="navbarNav">
								<?php
								if($_SESSION['cmgt_verify'] == '')
								{
								?>
								<li class="card-icon">
									<a href='<?php echo admin_url().'admin.php?page=smgt_setup';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_setup") { echo "active"; } ?>">
										<img class="icon img-top" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/license.png"?>">
										<img class="icon " src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/license.png"?>">
										<span><?php esc_html_e( 'License settings', 'school-mgt' ); ?></span>
									</a>
								</li>
								<?php
								} 
								?>

								<li class="card-icon">
									<a href="<?php echo admin_url().'admin.php?page=smgt_school';?>" class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_school") { echo "active"; } ?>">
										<img class="icon img-top" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/dashboards.png"?>">
										<img class="icon " src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/dashboards.png"?>">
										<span><?php esc_html_e( 'Dashboard', 'school-mgt' ); ?></span>
									</a>
								</li>
								<?php
								if($admission_view_access == 1)
								{
									?>
									<li class="card-icon">
										<a href='<?php echo admin_url().'admin.php?page=smgt_admission';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_admission") { echo "active"; } ?>">
										<img class="icon img-top" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Admission.png"?>">
										<img class="icon " src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Admission.png"?>">
										<span><?php esc_html_e( 'Admission', 'school-mgt' ); ?></span>
										</a>
									</li>
									<?php
								}
								if($class_view_access == 1 || $schedule_view_access == 1 || $virtual_class_view_access == 1 || $subject_view_access == 1)
								{
									?>
									<li class="has-submenu nav-item card-icon">
										<a href='#' class=" <?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_class" || $_REQUEST ['page'] && $_REQUEST ['page'] == "smgt_route" || $_REQUEST ['page'] && $_REQUEST ['page'] == "smgt_virtual_classroom" || $_REQUEST ['page'] && $_REQUEST ['page'] == "smgt_Subject" ) { echo "active"; } ?>">
											<img class="icon img-top" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Class.png"?>">
											<img class="icon " src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Class.png"?>">
											<span><?php esc_html_e('Class', 'school-mgt' ); ?></span>
											<i class="fa <?php echo $rtl_left_icon_class; ?> dropdown-right-icon icon" aria-hidden="true"></i>
											<i class="fa fa-chevron-down icon dropdown-down-icon" aria-hidden="true"></i>
										</a>
										<ul class='submenu dropdown-menu'>
											<?php
											if($class_view_access == 1)
											{
												?>
												<li class=''>
													<a href='<?php echo admin_url().'admin.php?page=smgt_class';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_class") { echo "active"; } ?>">
													<span><?php esc_html_e( 'Class', 'school-mgt' ); ?></span>
													</a>
												</li>
												<?php
											}
											if($schedule_view_access == 1)
											{
												?>
												<li class=''>
													<a href='<?php echo admin_url().'admin.php?page=smgt_route';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_route") { echo "active"; } ?>">
													<span><?php esc_html_e( 'Class Routine', 'school-mgt' ); ?></span>
													</a>
												</li>
												<?php
											}
											if($virtual_class_view_access == 1)
											{
												if(get_option('smgt_enable_virtual_classroom') == "yes")
												{
													?>
													<li class=''>
														<a href='<?php echo admin_url().'admin.php?page=smgt_virtual_classroom';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_virtual_classroom") { echo "active"; } ?>">
														<span><?php esc_html_e( 'Virtual Classroom', 'school-mgt' ); ?></span>
														</a>
													</li>
													<?php 
												}
											}
											if($subject_view_access == 1)
											{
												?>
												<li class=''>
													<a href='<?php echo admin_url().'admin.php?page=smgt_Subject';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_Subject") { echo "active"; } ?>">
													<span><?php esc_html_e( 'Subject', 'school-mgt' ); ?></span>
													</a>
												</li>
												<?php
											}
											?>
										</ul> 
									</li>
									<?php
								}
								if($student_view_access == 1 || $staff_view_access == 1 || $teacher_view_access == 1 || $parent_view_access == 1)
								{
									?>
									<li class="has-submenu nav-item card-icon">
										<a href='#' class=" <?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_student" || $_REQUEST ['page'] && $_REQUEST ['page'] == "smgt_teacher" || $_REQUEST ['page'] && $_REQUEST ['page'] == "smgt_supportstaff" || $_REQUEST ['page'] && $_REQUEST ['page'] == "smgt_parent" ) { echo "active"; } ?>">
											<img class="icon img-top margin_left_3px" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/user-black.png"?>">
											<img class="icon margin_left_3px" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/user-white.png"?>">
											<span class="margin_left_12px"><?php esc_html_e('Users', 'school-mgt' ); ?></span>
											<i class="fa <?php echo $rtl_left_icon_class; ?> dropdown-right-icon icon" aria-hidden="true"></i>
											<i class="fa fa-chevron-down icon dropdown-down-icon" aria-hidden="true"></i>
										</a>
										<ul class='submenu dropdown-menu'>
											<?php
											if($student_view_access == 1)
											{
												?>
												<li class=''>
													<a href='<?php echo admin_url().'admin.php?page=smgt_student';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_student") { echo "active"; } ?>">
													<span><?php esc_html_e( 'Student', 'school-mgt' ); ?></span>
													</a>
												</li>
												<?php
											}
											if($teacher_view_access == 1)
											{
												?>
												<li class=''>
													<a href='<?php echo admin_url().'admin.php?page=smgt_teacher';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_teacher") { echo "active"; } ?>">
													<span><?php esc_html_e( 'Teacher', 'school-mgt' ); ?></span>
													</a>
												</li>
												<?php
											}
											if($staff_view_access == 1)
											{
												?>
												<li class=''>
													<a href='<?php echo admin_url().'admin.php?page=smgt_supportstaff';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_supportstaff") { echo "active"; } ?>">
													<span><?php esc_html_e( 'Support Staff', 'school-mgt' ); ?></span>
													</a>
												</li>
												<?php
											}
											if($parent_view_access == 1)
											{
												?>
												<li class="">
													<a href='<?php echo admin_url().'admin.php?page=smgt_parent';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_parent") { echo "active"; } ?>">
													<span><?php esc_html_e( 'Parent', 'school-mgt' ); ?></span>
													</a>
												</li>
												<?php
											}
											?>
										</ul> 
									</li>
									<?php
								}
								if($exam_view_access == 1 || $hall_view_access == 1 || $mark_view_access == 1 || $grade_view_access == 1 || $migration_view_access == 1)
								{
									?>
									<li class="has-submenu nav-item card-icon">
										<a href='#' class=" <?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_exam" || $_REQUEST ['page'] && $_REQUEST ['page'] == "smgt_hall" || $_REQUEST ['page'] && $_REQUEST ['page'] == "smgt_result" || $_REQUEST ['page'] && $_REQUEST ['page'] == "smgt_grade" || $_REQUEST ['page'] && $_REQUEST ['page'] == "smgt_Migration" ) { echo "active"; } ?>">
											<img class="icon img-top" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Exam.png"?>">
											<img class="icon " src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Exam.png"?>">
											<span class=""><?php esc_html_e('Student Evaluation', 'school-mgt' ); ?></span>
											<i class="fa <?php echo $rtl_left_icon_class; ?> dropdown-right-icon icon" aria-hidden="true"></i>
											<i class="fa fa-chevron-down icon dropdown-down-icon" aria-hidden="true"></i>
										</a>
										<ul class='submenu dropdown-menu'>
											<?php
											if($exam_view_access == 1)
											{
												?>
												<li class=''>
													<a href='<?php echo admin_url().'admin.php?page=smgt_exam';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_exam") { echo "active"; } ?>">
													<span><?php esc_html_e( 'Exam', 'school-mgt' ); ?></span>
													</a>
												</li>
												<?php
											}
											if($hall_view_access == 1)
											{
												?>
												<li class=''>
													<a href='<?php echo admin_url().'admin.php?page=smgt_hall';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_hall") { echo "active"; } ?>">
													<span><?php esc_html_e( 'Exam Hall', 'school-mgt' ); ?></span>
													</a>
												</li>
												<?php
											}
											if($mark_view_access == 1)
											{
												?>
												<li class=''>
													<a href='<?php echo admin_url().'admin.php?page=smgt_result';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_result") { echo "active"; } ?>">
													<span><?php esc_html_e( 'Manage Marks', 'school-mgt' ); ?></span>
													</a>
												</li>
												<?php
											}
											if($grade_view_access == 1)
											{
												?>
												<li class="">
													<a href='<?php echo admin_url().'admin.php?page=smgt_grade';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_grade") { echo "active"; } ?>">
													<span><?php esc_html_e( 'Grade', 'school-mgt' ); ?></span>
													</a>
												</li>
												<?php
											}
											if($migration_view_access == 1)
											{
												?>
												<li class="">
													<a href='<?php echo admin_url().'admin.php?page=smgt_Migration';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_Migration") { echo "active"; } ?>">
													<span><?php esc_html_e( 'Migration', 'school-mgt' ); ?></span>
													</a>
												</li>
												<?php
											}
											?>
										</ul> 
									</li>
									<?php
								}
								if($homework_view_access == 1)
								{
									?>
									<li class="card-icon">
										<a href='<?php echo admin_url().'admin.php?page=smgt_student_homewrok';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_student_homewrok") { echo "active"; } ?>">
											<img class="icon img-top" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/homework.png"?>">
											<img class="icon " src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/homework.png"?>">
											<span><?php esc_html_e( 'Homework', 'school-mgt' ); ?></span>
										</a>
									</li>
									<?php
								}
								if($attendance_view_access == 1)
								{
									?>
									<li class="card-icon">
										<a href='<?php echo admin_url().'admin.php?page=smgt_attendence';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_attendence") { echo "active"; } ?>">
										<img class="icon img-top" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Attendance.png"?>">
										<img class="icon " src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Attendance.png"?>">
										<span><?php esc_html_e( 'Attendance', 'school-mgt' ); ?></span>
										</a>
									</li>
									<?php
								}

								//--  Start ADD document side menu page name and link  --//

								if($leave_view_access == 1)
								{	?>
									<li class="card-icon">
										<a href='<?php echo admin_url().'admin.php?page=smgt_document';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_document") { echo "active"; } ?>">
										<img class="icon img-top" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/document.png"?>">
										<img class="icon " src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/document.png"?>">
										<span><?php esc_html_e( 'Documents', 'school-mgt' ); ?></span>
										</a>
									</li>
									<?php
								}

								//-- End- ADD document side menu page name and link  --//

								//--  Start ADD leave side menu page name and link  --//
								if($leave_view_access == 1)
								{	?>
									<li class="card-icon">
										<a href='<?php echo admin_url().'admin.php?page=smgt_leave';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_leave") { echo "active"; } ?>">
										<img class="icon img-top" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/leave.png"?>">
										<img class="icon " src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/leave.png"?>">
										<span><?php esc_html_e( 'Leave', 'school-mgt' ); ?></span>
										</a>
									</li>
									<?php
								}
								//-- End- ADD leave side menu page name and link  --//
								if($fees_view_access == 1 || $payment_view_access == 1)
								{
									?>
									<li class="has-submenu nav-item card-icon">
										<a href='#' class=" <?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_fees_payment" || $_REQUEST ['page'] && $_REQUEST ['page'] == "smgt_payment" ) { echo "active"; } ?>">
											<img class="icon img-top" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Payment.png"?>">
											<img class="icon " src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Payment.png"?>">
											<span><?php esc_html_e('Payment', 'school-mgt' ); ?></span>
											<i class="fa <?php echo $rtl_left_icon_class; ?> dropdown-right-icon icon" aria-hidden="true"></i>
											<i class="fa fa-chevron-down icon dropdown-down-icon" aria-hidden="true"></i>
										</a>
										<ul class='submenu dropdown-menu'>
											<?php
											if($fees_view_access == 1)
											{
												?>
												<li class=''>
													<a href='<?php echo admin_url().'admin.php?page=smgt_fees_payment&tab=feeslist';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_fees_payment") { echo "active"; } ?>">
													<span><?php esc_html_e( 'Fees payment', 'school-mgt' ); ?></span>
													</a>
												</li>
												<?php
											}
											if($payment_view_access == 1)
											{
												?>
												<li class=''>
													<a href='<?php echo admin_url().'admin.php?page=smgt_payment&tab=payment';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_payment") { echo "active"; } ?>">
													<span><?php esc_html_e( 'Payment', 'school-mgt' ); ?></span>
													</a>
												</li>
												<?php
											}
											?>
										</ul> 
									</li>
									<?php
								}
								if($library_view_access == 1)
								{
									?>
									<li class="card-icon">
										<a href='<?php echo admin_url().'admin.php?page=smgt_library';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_library") { echo "active"; } ?>">
										<img class="icon img-top" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Library.png"?>">
										<img class="icon " src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Library.png"?>">
										<span><?php esc_html_e( 'Library', 'school-mgt' ); ?></span>
										</a>
									</li>
									<?php
								}
								if($hostel_view_access == 1)
								{
									?>
									<li class="has-submenu nav-item card-icon">
										<a href='#' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_hostel") { echo "active"; } ?>">
											<img class="icon img-top" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/hostel.png"?>">
											<img class="icon " src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/hostel.png"?>">
											<span><?php esc_html_e( 'Hostel', 'school-mgt' ); ?></span>
											<i class="fa <?php echo $rtl_left_icon_class; ?> dropdown-right-icon icon" aria-hidden="true"></i>
											<i class="fa fa-chevron-down icon dropdown-down-icon" aria-hidden="true"></i>
										</a>
										<ul class='submenu dropdown-menu'>
											<li class=''>
												<a href='<?php echo admin_url().'admin.php?page=smgt_hostel&tab=hostel_list';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_hostel") { echo "active"; } ?>">
												<span><?php esc_html_e( 'Hostel', 'school-mgt' ); ?></span>
												</a>
											</li>
											<li class=''>
												<a href='<?php echo admin_url().'admin.php?page=smgt_hostel&tab=room_list';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_hostel") { echo "active"; } ?>">
												<span><?php esc_html_e( 'Room', 'school-mgt' ); ?></span>
												</a>
											</li>
											<li class=''>
												<a href='<?php echo admin_url().'admin.php?page=smgt_hostel&tab=bed_list';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_hostel") { echo "active"; } ?>">
												<span><?php esc_html_e( 'Beds', 'school-mgt' ); ?></span>
												</a>
											</li>
										</ul> 
									</li>
									<?php
								}
								if($transport_view_access == 1)
								{
									?>
									<li class="card-icon">
										<a href='<?php echo admin_url().'admin.php?page=smgt_transport';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_transport") { echo "active"; } ?>">
										<img class="icon img-top" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/Transportation.png"?>">
										<img class="icon " src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Transportation.png"?>">
										<span><?php esc_html_e( 'Transport', 'school-mgt' ); ?></span>
										</a>
									</li>
									<?php
								}
								if($report_view_access == 1)
								{
									?>
									<li class="has-submenu nav-item card-icon report_menu">
										<a href='#' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_report") { echo "active"; } ?>">
											<img class="icon img-top" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/report.png"?>">
											<img class="icon " src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/report.png"?>">
											<span><?php esc_html_e( 'Reports', 'school-mgt' ); ?></span>
											<i class="fa <?php echo $rtl_left_icon_class; ?> dropdown-right-icon icon" aria-hidden="true"></i>
											<i class="fa fa-chevron-down icon dropdown-down-icon" aria-hidden="true"></i>
										</a>
										<ul class='submenu dropdown-menu'>
											<li class=''>
												<a href='<?php echo admin_url().'admin.php?page=smgt_report&tab=student_information_report';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_report") { echo "active"; } ?>">
												<span><?php esc_html_e( 'Student Information', 'school-mgt' ); ?></span>
												</a>
											</li>
											<li class=''>
												<a href='<?php echo admin_url().'admin.php?page=smgt_report&tab=fianance_report';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_report") { echo "active"; } ?>">
												<span><?php esc_html_e( 'Finance/Payment', 'school-mgt' ); ?></span>
												</a>
											</li>
											<li class=''>
												<a href='<?php echo admin_url().'admin.php?page=smgt_report&tab=attendance_report';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_report") { echo "active"; } ?>">
												<span><?php esc_html_e( 'Attendance', 'school-mgt' ); ?></span>
												</a>
											</li>
											
											<li class=''>
												<a href='<?php echo admin_url().'admin.php?page=smgt_report&tab=examinations_report';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_report") { echo "active"; } ?>">
												<span><?php esc_html_e( 'Examinations', 'school-mgt' ); ?></span>
												</a>
											</li>
											<li class=''>
												<a href='<?php echo admin_url().'admin.php?page=smgt_report&tab=library_report';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_report") { echo "active"; } ?>">
												<span><?php esc_html_e( 'Library', 'school-mgt' ); ?></span>
												</a>
											</li>
											<li class=''>
												<a href='<?php echo admin_url().'admin.php?page=smgt_report&tab=hostel_report';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_report") { echo "active"; } ?>">
												<span><?php esc_html_e( 'Hostel', 'school-mgt' ); ?></span>
												</a>
											</li>
											<li class=''>
												<a href='<?php echo admin_url().'admin.php?page=smgt_report&tab=user_log_report';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_report") { echo "active"; } ?>">
												<span><?php esc_html_e( 'User Log', 'school-mgt' ); ?></span>
												</a>
											</li>
											<li class=''>
												<a href='<?php echo admin_url().'admin.php?page=smgt_report&tab=audit_log_report';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_report") { echo "active"; } ?>">
												<span><?php esc_html_e( 'Audit Trail Report', 'school-mgt' ); ?></span>
												</a>
											</li>
										</ul> 
									</li>
									<?php
								}
								if($notice_view_access == 1 || $message_view_access == 1 || $holiday_view_access == 1 || $notification_view_access == 1 || $event_view_access == 1)
								{
									?>
									<li class="has-submenu nav-item card-icon general_setting_menu">
										<a href='#' class=" <?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_notice" || $_REQUEST ['page'] && $_REQUEST ['page'] == "smgt_message" || $_REQUEST ['page'] && $_REQUEST ['page'] == "smgt_event" || $_REQUEST ['page'] && $_REQUEST ['page'] == "smgt_notification" || $_REQUEST ['page'] && $_REQUEST ['page'] == "smgt_holiday" ) { echo "active"; } ?>">
											<img class="icon img-top" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/notifications.png"?>">
											<img class="icon " src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/notifications.png"?>">
											<span><?php esc_html_e('Notification', 'school-mgt' ); ?></span>
											<i class="fa <?php echo $rtl_left_icon_class; ?> dropdown-right-icon icon" aria-hidden="true"></i>
											<i class="fa fa-chevron-down icon dropdown-down-icon" aria-hidden="true"></i>
										</a>
										<ul class='submenu dropdown-menu'>
											<?php
											if($notice_view_access == 1)
											{
												?>
												<li class=''>
													<a href='<?php echo admin_url().'admin.php?page=smgt_notice';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_notice") { echo "active"; } ?>">
													<span><?php esc_html_e( 'Notice', 'school-mgt' ); ?></span>
													</a>
												</li>
												<?php
											}
											if($event_view_access == 1)
											{
												?>
												<li class=''>
													<a href='<?php echo admin_url().'admin.php?page=smgt_event';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_event") { echo "active"; } ?>">
													<span><?php esc_html_e( 'Event', 'school-mgt' ); ?></span>
													</a>
												</li>
												<?php
											}
											if($message_view_access == 1)
											{
												?>
												<li class=''>
													<a href='<?php echo admin_url().'admin.php?page=smgt_message';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_message") { echo "active"; } ?>">
													<span><?php esc_html_e( 'Message', 'school-mgt' ); ?></span>
													</a>
												</li>
												<?php
											}
											if($notification_view_access == 1)
											{
												?>
												<li class=''>
													<a href='<?php echo admin_url().'admin.php?page=smgt_notification';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_notification") { echo "active"; } ?>">
													<span><?php esc_html_e( 'Notification', 'school-mgt' ); ?></span>
													</a>
												</li>
												<?php
											}
											if($holiday_view_access == 1)
											{
												?>
												<li class=''>
													<a href='<?php echo admin_url().'admin.php?page=smgt_holiday';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_holiday") { echo "active"; } ?>">
													<span><?php esc_html_e( 'Holiday', 'school-mgt' ); ?></span>
													</a>
												</li>
												<?php
											}
											?>
										</ul> 
									</li>
									<?php
								}
								if($field_view_access == 1 || $sms_view_access == 1 || $mail_view_access == 1)
								{
									?>
									<li class="has-submenu nav-item card-icon <?php if($role != "management"){ ?> general_setting_menu <?php } ?>">
										<a href='#' class=" <?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "custom_field" || $_REQUEST ['page'] && $_REQUEST ['page'] == "smgt_sms-setting" || $_REQUEST ['page'] && $_REQUEST ['page'] == "smgt_email_template" || $_REQUEST ['page'] && $_REQUEST ['page'] == "smgt_access_right" || $_REQUEST ['page'] && $_REQUEST ['page'] == "smgt_gnrl_settings" ) { echo "active"; } ?>">
											<img class="icon img-top" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/setting.png"?>">
											<img class="icon " src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/setting.png"?>">
											<span><?php esc_html_e('System Settings', 'school-mgt' ); ?></span>
											<i class="fa <?php echo $rtl_left_icon_class; ?> dropdown-right-icon icon" aria-hidden="true"></i>
											<i class="fa fa-chevron-down icon dropdown-down-icon" aria-hidden="true"></i>
										</a>
										<ul class='submenu dropdown-menu'>
											<?php
											if($field_view_access == 1)
											{
												?>
												<li class=''>
													<a href='<?php echo admin_url().'admin.php?page=custom_field';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "custom_field") { echo "active"; } ?>">
													<span><?php esc_html_e( 'Custom Fields', 'school-mgt' ); ?></span>
													</a>
												</li>
												<?php
											}
											if($sms_view_access == 1)
											{
												?>
												<li class=''>
													<a href='<?php echo admin_url().'admin.php?page=smgt_sms-setting';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_sms-setting") { echo "active"; } ?>">
													<span><?php esc_html_e( 'SMS Settings', 'school-mgt' ); ?></span>
													</a>
												</li>
												<?php
											}
											if($mail_view_access == 1)
											{
												?>
												<li class=''>
													<a href='<?php echo admin_url().'admin.php?page=smgt_email_template';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_email_template") { echo "active"; } ?>">
													<span><?php esc_html_e( 'Email Template', 'school-mgt' ); ?></span>
													</a>
												</li>
												<?php
											}
											$role=$school_obj->role;
											if($role == 'admin')
											{
												?>
												<li class=''>
													<a href='<?php echo admin_url().'admin.php?page=smgt_access_right';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_access_right") { echo "active"; } ?>">
													<span><?php esc_html_e( 'Access Right', 'school-mgt' ); ?></span>
													</a>
												</li>
												
												<li class=''>
													<a href='<?php echo admin_url().'admin.php?page=smgt_gnrl_settings';?>' class="<?php if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == "smgt_gnrl_settings") { echo "active"; } ?>">
													<span><?php esc_html_e( 'General Settings', 'school-mgt' ); ?></span>
													</a>
												</li>
												<?php
											}
											?>
										</ul> 
									</li>
									<?php
								}
								?>
							</ul>
						</nav>	
					</div>
					<!-- End menu sidebar main div  -->
				</div>
				<!-- dashboard content div start  -->
				<div class="col col-sm-12 col-md-12 col-lg-10 col-xl-10 dashboard_margin padding_left_0 padding_right_0">		
					<div class="page-inner min_height_1088 admin_homepage_padding_top">
						<!-- main-wrapper div START-->  
						<div id="main-wrapper" class="main-wrapper-div label_margin_top_15px admin_dashboard">
						<?php
						
						$page_name = $_REQUEST ['page'];
						
						if($_REQUEST ['page'] == 'smgt_student')
						{
							require_once SMS_PLUGIN_DIR. '/admin/includes/student/index.php';
						}
						elseif($_REQUEST ['page'] == 'smgt_teacher'){
							require_once SMS_PLUGIN_DIR. '/admin/includes/teacher/index.php';
						}
						elseif($_REQUEST ['page'] == 'smgt_supportstaff'){
							require_once SMS_PLUGIN_DIR. '/admin/includes/supportstaff/index.php';
						}
						elseif($_REQUEST ['page'] == 'smgt_parent'){
							require_once SMS_PLUGIN_DIR. '/admin/includes/parent/index.php';
						}
						elseif($_REQUEST ['page'] == 'smgt_class'){
							require_once SMS_PLUGIN_DIR. '/admin/includes/class/index.php';
						}
						elseif($_REQUEST ['page'] == 'smgt_route')
						{
							require_once SMS_PLUGIN_DIR. '/admin/includes/routine/index.php';
						}
						elseif($_REQUEST ['page'] == 'smgt_admission')
						{
							require_once SMS_PLUGIN_DIR. '/admin/includes/admission/index.php';
						}
						elseif($_REQUEST ['page'] == 'smgt_virtual_classroom')
						{
							require_once SMS_PLUGIN_DIR. '/admin/includes/virtual_classroom/index.php';
						}
						elseif($_REQUEST ['page'] == 'smgt_Subject')
						{
							require_once SMS_PLUGIN_DIR. '/admin/includes/subject/index.php';
						}
						elseif($_REQUEST ['page'] == 'smgt_exam')
						{
							require_once SMS_PLUGIN_DIR. '/admin/includes/exam/index.php';
						}
						elseif($_REQUEST ['page'] == 'smgt_hall')
						{
							require_once SMS_PLUGIN_DIR. '/admin/includes/hall/index.php';
						}
						elseif($_REQUEST ['page'] == 'smgt_result')
						{
							require_once SMS_PLUGIN_DIR. '/admin/includes/mark/index.php';
						}
						elseif($_REQUEST ['page'] == 'smgt_grade')
						{
							require_once SMS_PLUGIN_DIR. '/admin/includes/grade/index.php';
						}
						elseif($_REQUEST ['page'] == 'smgt_Migration')
						{
							require_once SMS_PLUGIN_DIR. '/admin/includes/migration/index.php';
						}
						elseif($_REQUEST ['page'] == 'smgt_student_homewrok')
						{
							require_once SMS_PLUGIN_DIR. '/admin/includes/student_HomeWork/index.php';
						}
						elseif($_REQUEST ['page'] == 'smgt_attendence')
						{
							require_once SMS_PLUGIN_DIR. '/admin/includes/attendence/index.php';
						}
						elseif($_REQUEST ['page'] == 'smgt_fees_payment')
						{
							require_once SMS_PLUGIN_DIR. '/admin/includes/feespayment/index.php';
						}
						elseif($_REQUEST ['page'] == 'smgt_payment')
						{
							require_once SMS_PLUGIN_DIR. '/admin/includes/payment/index.php';
						}
						elseif($_REQUEST ['page'] == 'smgt_library')
						{
							require_once SMS_PLUGIN_DIR. '/admin/includes/library/index.php';
						}
						elseif($_REQUEST ['page'] == 'smgt_hostel')
						{
							require_once SMS_PLUGIN_DIR. '/admin/includes/hostel/index.php';
						}
						elseif($_REQUEST ['page'] == 'smgt_leave')
						{
							require_once SMS_PLUGIN_DIR. '/admin/includes/leave/index.php';
						}
						elseif($_REQUEST ['page'] == 'smgt_transport')
						{
							require_once SMS_PLUGIN_DIR. '/admin/includes/transport/index.php';
						}
						elseif($_REQUEST ['page'] == 'smgt_report')
						{
							require_once SMS_PLUGIN_DIR. '/admin/includes/report/index.php';
						}
						elseif($_REQUEST ['page'] == 'smgt_notice')
						{
							require_once SMS_PLUGIN_DIR. '/admin/includes/notice/index.php';
						}
						elseif($_REQUEST ['page'] == 'smgt_event')
						{
							require_once SMS_PLUGIN_DIR. '/admin/includes/event/index.php';
						}
						elseif($_REQUEST ['page'] == 'smgt_notification')
						{
							require_once SMS_PLUGIN_DIR. '/admin/includes/notification/index.php';
						}
						elseif($_REQUEST ['page'] == 'smgt_message')
						{
							require_once SMS_PLUGIN_DIR. '/admin/includes/message/index.php';
						}
						elseif($_REQUEST ['page'] == 'smgt_holiday')
						{
							require_once SMS_PLUGIN_DIR. '/admin/includes/holiday/index.php';
						}
						elseif($_REQUEST ['page'] == 'custom_field')
						{
							require_once SMS_PLUGIN_DIR. '/admin/includes/customfield/index.php';
						}
						elseif($_REQUEST ['page'] == 'smgt_sms-setting')
						{
							require_once SMS_PLUGIN_DIR. '/admin/includes/sms_setting/index.php';
						}
						elseif($_REQUEST ['page'] == 'smgt_email_template')
						{
							require_once SMS_PLUGIN_DIR. '/admin/includes/email-template/index.php';
						}
						elseif($_REQUEST ['page'] == 'smgt_access_right')
						{
							require_once SMS_PLUGIN_DIR. '/admin/includes/access_right/index.php';
						}
						elseif($_REQUEST ['page'] == 'smgt_gnrl_settings')
						{
							require_once SMS_PLUGIN_DIR. '/admin/includes/general-settings.php';
						}
						elseif($_REQUEST ['page'] == 'smgt_setup')
						{
							require_once SMS_PLUGIN_DIR. '/admin/includes/setupform/index.php';
						}
						elseif($_REQUEST ['page'] == 'smgt_document')
						{
							require_once SMS_PLUGIN_DIR. '/admin/includes/ducuments/index.php';
						}
						?>

						<?php
						if(isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == 'smgt_school')
						{
							?>
							<!-- Row Div Start  -->
							<!-- Four Card , Chart and Fees Payment Row Div  -->
							<div class="row menu_row dashboard_content_rs first_row_padding_top">
								<div class="col-lg-4 col-md-4 col-xl-4 col-sm-4 four_card_div">
									<div class="row">
										<!-- Member card start -->
										<div class="col-lg-6 col-md-6 col-xl-6 col-sm-6 smgt-card">
											<div class="smgt-card-member-bg center" id="card-member-bg">
												<a href='<?php echo admin_url().'admin.php?page=smgt_teacher';?>'>
												<img class="center" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Parents_dashboard.png"?>">
												</a>
											</div>
											<div class="smgt-card-number">
												<?php
												$user_query = new WP_User_Query(array('role' => 'teacher'));
												$teacher_count = (int) $user_query->get_total();
												?>
												<h3><?php echo $teacher_count;?></h3>
											</div>
											<div class="smgt-card-title">
												<span><?php esc_html_e('Teachers','school-mgt');?></span>
											</div>
										</div>
										<!-- Member card end -->
										<!-- Accountant card start -->
										<div class="col-lg-6 col-md-6 col-xl-6 col-sm-6 smgt-card hmgt_card_2">
											<div class="smgt-card-member-bg center" id="card-supportstaff-bg">
												<a href='<?php echo admin_url().'admin.php?page=smgt_supportstaff';?>'>
													<img class="center" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Supportstaff_dashboard.png"?>">
												</a>
											</div>
											<div class="smgt-card-number">
												<?php
												$user_query = new WP_User_Query(array('role' => 'supportstaff'));
												$support_count = (int) $user_query->get_total();
												?>
												<h3><?php echo $support_count;?></h3>
											</div>
											<div class="smgt-card-title">
												<span><?php esc_html_e('Support Staffs','school-mgt');?></span>
											</div>
										</div>
										<!-- Accountant card end -->
										<!-- Notice card start -->
										<div class="col-lg-6 col-md-6 col-xl-6 col-sm-6 smgt-card">
											<div class="smgt-card-member-bg center" id="card-notice-bg">
												<a href='<?php echo admin_url().'admin.php?page=smgt_notice';?>'>
													<img class="center" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Notice_dashboard.png"?>">
												</a>
											</div>
											<div class="smgt-card-number">
												<?php
												global $wpdb;
												$table_post = $wpdb->prefix . 'posts';
												$total_notice = $wpdb->get_row("SELECT COUNT(*) as  total_notice FROM $table_post where post_type='notice' ");
				
												?>
												<h3><?php echo $total_notice->total_notice; ?></h3>
											</div>
											<div class="smgt-card-title prescription_name_div">
												<span><?php esc_html_e('Notices','school-mgt');?></span>
											</div>
										</div>
										<!-- Notice card end -->
										<!-- Message card start -->
										<div class="col-lg-6 col-md-6 col-xl-6 col-sm-6 smgt-card hmgt_card_2">
											<div class="smgt-card-member-bg center" id="card-message-bg">
												<a href='<?php echo admin_url().'admin.php?page=smgt_message';?>'>
													<img class="center" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Message_dashboard.png"?>">
												</a>
											</div>
											<div class="smgt-card-number">
												<h3><?php echo count(mj_smgt_count_inbox_item(get_current_user_id()));?></h3>
											</div>
											<div class="smgt-card-title">
												<span><?php esc_html_e('Messages','school-mgt');?></span>
											</div>
										</div>
										<!--Message card end -->
									</div>
								</div>
						
								<div class="col-lg-4 col-md-4 col-xs-12 col-sm-12 responsive_div_dasboard">
									<div class="panel panel-white smgt-line-chat">
									
										<div class="panel-heading" id="smgt-line-chat-p">
											<h3 class="panel-title" style="float: left;"><?php esc_html_e('Students & Parents','school-mgt');?></h3>
											<a href="<?php echo admin_url().'admin.php?page=smgt_student'; ?>"><img class="vertical_align_unset" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Redirect.png"?>"></a>
										</div>
									
										<script src="https://github.com/chartjs/Chart.js/releases/download/v2.9.3/Chart.min.js"></script>
										<link rel="stylesheet" href="https://github.com/chartjs/Chart.js/releases/download/v2.9.3/Chart.min.css">
										<div class="smgt-member-chart">
											<div class="outer">
												<canvas id="chartJSContainer" width="300" height="250"></canvas>
												
												<p class="percent">
												<?php
												$user_query = new WP_User_Query(array('role' => 'parent'));
												$parent_count = (int) $user_query->get_total();
												$user_query_1 = new WP_User_Query(array('role' => 'student'));
												$student_count = (int) $user_query_1->get_total();
												$total_student_parent = $parent_count + $student_count; 
												echo (int)$total_student_parent;
												?>
												</p>
												<p class="percent1">
													<?php esc_html_e('Students & Parents','school-mgt');?>
												</p>
											</div>
											<script>
													var options1 = {
														type: 'doughnut',
														data: {
															
															labels: ["<?php esc_html_e('Students','school-mgt');?>", "<?php esc_html_e('Parents','school-mgt');?>"],
															datasets: [
															{
																		label: '# of Votes',
																		data: [<?php echo $student_count; ?>,<?php echo $parent_count;?>],
																		backgroundColor: [
																			'#FFB400',
																			'#44CB7F',
																		],
																		borderColor: [
																			'rgba(255, 255, 255 ,1)',
																			'rgba(255, 255, 255 ,1)',
																			
																		],
																		borderWidth: 5,
																		
																	}
																]
														},
														options: {
														rotation: 1 * Math.PI,
																	circumference: 1 * Math.PI,
																	legend: {
																		display: false
																	},
																	tooltip: {
																		enabled: false
																	},
																	cutoutPercentage: 85
														}
														}

														var ctx1 = document.getElementById('chartJSContainer').getContext('2d');
														new Chart(ctx1, options1);

														var options2 = {
														type: 'doughnut',
														data: {
														labels: ["", "Purple", ""],
																	datasets: [
																	{
																			data: [88.5, 1],
																			backgroundColor: [
																				"rgba(0,0,0,0)",
																				"rgba(255,255,255,1)",
																				
																			],
																			borderColor: [
																			'rgba(0, 0, 0 ,0)',
																			'rgba(46, 204, 113, 1)',
																			
																		],
																		borderWidth: 5
																		
																		}]
														},
														options: {
															cutoutPercentage: 95,
															rotation: 1 * Math.PI,
															circumference: 1 * Math.PI,
																	legend: {
																		display: false
																	},
																	tooltips: {
																		enabled: false
																	}
														}
														}

														var ctx2 = document.getElementById('secondContainer').getContext('2d');
														new Chart(ctx2, options2);
											</script>
										</div>

										<div class="row hmgt-line-chat">
											<div class="col-md-5 line-chart-checkcolor-center color_dot_div_left chart_div_1">
												<p class="line-chart-checkcolor-RegularMember"></p>
											</div>
											<div  class="col-md-2 chart_div_3"></div>
											<div class="col-md-5 line-chart-checkcolor-center color_dot_div_right chart_div_1">
												<p class="line-chart-checkcolor-VolunteerMember"></p>
											</div>
										</div>
										<div class="row d-flex align-items-center justify-content-center">
											<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 col-xs-5 responsive_div_dasboard chart_div_1" id="smgt-line-chat-right-border">
												<p class="count_patient"><?php echo $student_count;?></p>
												<p class="name_patient"><?php esc_html_e('Students','school-mgt');?></p>
											</div>
											<div class="col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xs-2 chart_div_3">
												<p class="between_border"></p>
											</div>
											<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 col-xs-5 responsive_div_dasboard chart_div_1 inpatient_div">
												<p class="count_patient"><?php echo $parent_count;?></p>
												<p class="name_patient"><?php esc_html_e('Parents','school-mgt');?></p>
											</div>
										</div>
									</div>
								</div>

								<div class="col-lg-4 col-md-4 col-xs-12 col-sm-12 responsive_div_dasboard precription_padding_left1">
									<div class="panel panel-white admmision_div">
										<div class="panel-heading" id="smgt-line-chat-p">
											<h3 class="panel-title"><?php esc_html_e('Fees Payment','school-mgt');?></h3>						
											<a class="page_link1" href="<?php echo admin_url().'admin.php?page=smgt_fees_payment&tab=feespaymentlist'; ?>">
												<img class="vertical_align_unset" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Redirect.png"?>">
											</a>
										</div>
										<div class="panel-body">
											<div class="events1">
												<?php
												$obj_feespayment = new mj_smgt_feespayment();
												$i= 0;
											
												$feespayment_data = $obj_feespayment->mj_smgt_get_five_fees();
									
												if(!empty($feespayment_data))
												{
													foreach ($feespayment_data as $retrieved_data)
													{
														
														if($i == 0)
														{
															$color_class='smgt_assign_bed_color0';
														}
														elseif($i == 1)
														{
															$color_class='smgt_assign_bed_color1';

														}
														elseif($i == 2)
														{
															$color_class='smgt_assign_bed_color2';

														}
														elseif($i == 3)
														{
															$color_class='smgt_assign_bed_color3';

														}
														elseif($i == 4)
														{
															$color_class='smgt_assign_bed_color4';

														}
													?>									
														<div class="fees_payment_height calendar-event"> 
															<p class="fees_payment_padding_top_0 remainder_title Bold viewbedlist show_task_event date_font_size" id="<?php echo esc_attr($retrieved_data->fees_pay_id); ?>" model="Feespayment Details" style=""> 	  
																<label for="" class="date_assignbed_label">
																<?php
																echo mj_smgt_get_currency_symbol().''.$retrieved_data->total_amount;
																?>
																</label>
																<span class=" <?php echo $color_class; ?>"></span>
															</p>
															<p class="remainder_date assignbed_name assign_bed_name_size">
															<?php
																$student_data =	MJ_smgt_get_user_detail_byid($retrieved_data->student_id);	
																echo esc_html($student_data['first_name']." ".$student_data['last_name']);
															?>	
															</p>
															<p class="remainder_date assign_bed_date assign_bed_name_size">
															<?php echo mj_smgt_getdate_in_input_box($retrieved_data->created_date); ?>
															</p>
														</div>		
													<?php
													$i++;
													}

												}
												else
												{
													?>
														<div class="calendar-event-new"> 
															<img class="no_data_img" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >
															<div class="col-md-12 dashboard_btn">
																<a href="<?php echo admin_url().'admin.php?page=smgt_fees_payment&tab=addpaymentfee'; ?>" class="btn save_btn event_for_alert line_height_31px"><?php esc_html_e('Fees Payment','school-mgt');?></a>
															</div>	
														</div>	
													<?php
												}		
												?>	
											</div>                       
										</div>
									</div>
								</div>
							</div>
							<!-- Four Card , Chart and Fees Payment Row Div  -->

							<!-- Celender And Chart Row  -->
							<div class="row calander-chart-div">
								<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
									<div class="smgt-attendance">
										<div class="smgt-attendance-list panel">
											<div class="panel-heading">
												<h3 class="panel-title"><?php esc_html_e('Today Attendance Report','school-mgt');?></h3>
												<a class="page-link123" href="<?php echo admin_url().'admin.php?page=smgt_attendence'; ?>" style="float: right;"><img class="" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Redirect.png"?>"></a>
											</div>
											<?php
											global $wpdb;
											$table_attendance = $wpdb->prefix . 'attendence';
											$table_class = $wpdb->prefix . 'smgt_class';
					
											$report_1 = $wpdb->get_results("SELECT  at.class_id,
													SUM(case when `status` ='Present' then 1 else 0 end) as Present,
													SUM(case when `status` ='Absent' then 1 else 0 end) as Absent
													from $table_attendance as at,$table_class as cl where at.attendence_date >  DATE_SUB(NOW(), INTERVAL 1 DAY) AND at.class_id = cl.class_id AND at.role_name = 'student' GROUP BY at.class_id");
											$chart_array = array();
											$chart_array[] = array(esc_attr__('Class', 'school-mgt'), esc_attr__('Present', 'school-mgt'), esc_attr__('Absent', 'school-mgt'));
											
											if (!empty($report_1))
												foreach ($report_1 as $result) {
													$class_id = mj_smgt_get_class_name($result->class_id);
													$chart_array[] = array("$class_id", (int)$result->Present, (int)$result->Absent);
												}
					
											$options = array(
												'title' => esc_attr__('Today Attendance Report', 'school-mgt'),
												'titleTextStyle' => array('color' => '#4e5e6a', 'fontSize' => 16, 'bold' => false, 'italic' => false, 'fontName' => '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
												'legend' => array(
													'position' => 'right',
													'textStyle' => array('color' => '#4e5e6a', 'fontSize' => 13, 'bold' => false, 'italic' => false, 'fontName' => '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;')
												),
					
												'hAxis' => array(
													'title' =>  esc_attr__('Class', 'school-mgt'),
													'titleTextStyle' => array('color' => '#4e5e6a', 'fontSize' => 16, 'bold' => false, 'italic' => false, 'fontName' => '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
													'textStyle' => array('color' => '#4e5e6a', 'fontSize' => 13, 'bold' => false, 'italic' => false, 'fontName' => '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
													'maxAlternation' => 2
					
					
												),
												'vAxis' => array(
													'title' =>  esc_attr__('No of Student', 'school-mgt'),
													'minValue' => 0,
													'maxValue' => 4,
													'format' => '#',
													'titleTextStyle' => array('color' => '#4e5e6a', 'fontSize' => 16, 'bold' => false, 'italic' => false, 'fontName' => '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
													'textStyle' => array('color' => '#4e5e6a', 'fontSize' => 13, 'bold' => false, 'italic' => false, 'fontName' => '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;')
												),
												'colors' => array('#22BAA0', '#f25656')
					
											);
											require_once SMS_PLUGIN_DIR . '/lib/chart/GoogleCharts.class.php';
											$GoogleCharts = new GoogleCharts;
											if (!empty($report_1)) {
												$chart = $GoogleCharts->load('column', 'chart_div_today')->get($chart_array, $options);
											}
											if (isset($report_1) && count($report_1) > 0)
											{
					
											?>
												<div id="chart_div_today"></div>
					
												<!-- Javascript -->
												<script type="text/javascript" src="https://www.google.com/jsapi"></script>
												<script type="text/javascript">
													<?php echo $chart; ?>
												</script>
												<?php
											}
											else 
											{
												?>
												<div class="calendar-event-new no_data_img_center"> 
													<img class="no_data_img" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >
												</div>				
												<?php
											} ?>
										</div>
										<div class="smgt-feesreport-list panel">
											<div class="panel-heading">
												<h3 class="panel-title"><?php esc_html_e('Fees Payment Report','school-mgt');?></h3>
												<a class="page-link123" href="<?php echo admin_url().'admin.php?page=smgt_fees_payment&tab=feespaymentlist'; ?>" style="float: right;"><img class="" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Redirect.png"?>"></a>
											</div>
											<?php
											$month = array(
												'1' => esc_attr__('January', 'school-mgt'), '2' => esc_attr__('February', 'school-mgt'), '3' => esc_attr__('March', 'school-mgt'), '4' => esc_attr__('April', 'school-mgt'), '5' => esc_attr__('May', 'school-mgt'), '6' => esc_attr__('June', 'school-mgt'), '7' => esc_attr__('July', 'school-mgt'), '8' => esc_attr__('August', 'school-mgt'),
												'9' => esc_attr__('September', 'school-mgt'), '10' => esc_attr__('October', 'school-mgt'), '11' => esc_attr__('November', 'school-mgt'), '12' => esc_attr__('December', 'school-mgt'),
											);
											$year = isset($_POST['year']) ? $_POST['year'] : date('Y');

											global $wpdb;
											$table_smgt_fees_payment = $wpdb->prefix . "smgt_fee_payment_history";
											$income = "SELECT EXTRACT(MONTH FROM paid_by_date) as date,sum(amount) as count FROM " . $table_smgt_fees_payment . " WHERE YEAR(paid_by_date) =" . $year . " group by month(paid_by_date) ORDER BY paid_by_date ASC";
											$income_result = $wpdb->get_results($income);
											$month_array = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12");
											$data_array = array();
											foreach ($month_array as $m) {
												$data_array[$m] = 0;
												foreach ($income_result as $a) {
													if ($a->date == $m) {
														$data_array[$m] = $data_array[$m] + $a->count;
													}
												}

												if ($data_array[$m] == 0) {
													unset($data_array[$m]);
												}
											}

											$chart_array = array();
											$currency = mj_smgt_get_currency_symbol();
											$currency_1 = html_entity_decode($currency);
											$chart_array[] = array(esc_attr__('Month', 'school-mgt'), esc_attr__('Payment', 'school-mgt'));
											$currency = mj_smgt_get_currency_symbol();
											foreach ($data_array as $key => $value) {
												foreach ($month as $key1 => $value1) {
													if ($key1 == $key) {
														$chart_array[] = array(esc_attr__($value1, 'school-mgt'), $value);
													}
												}
											}
											$options = array(
												'title' => esc_attr__('Payment by month', 'school-mgt'),
												'titleTextStyle' => array('color' => '#4e5e6a', 'fontSize' => 16, 'bold' => false, 'italic' => false, 'fontName' => '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
												'legend' => array(
													'position' => 'right',
													'textStyle' => array('color' => '#4e5e6a', 'fontSize' => 13, 'bold' => false, 'italic' => false, 'fontName' => '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;')
												),

												'hAxis' => array(
													'title' => esc_attr__('Month', 'school-mgt'),
													'titleTextStyle' => array('color' => '#4e5e6a', 'fontSize' => 16, 'bold' => false, 'italic' => false, 'fontName' => '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
													'textStyle' => array('color' => '#4e5e6a', 'fontSize' => 13, 'bold' => false, 'italic' => false, 'fontName' => '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
													'maxAlternation' => 2

												),
												'vAxis' => array(
													'title' => esc_attr__('Payment', 'school-mgt'),
													'minValue' => 0,
													'maxValue' => 5,
													'format' =>  html_entity_decode($currency),
													'titleTextStyle' => array('color' => '#4e5e6a', 'fontSize' => 16, 'bold' => false, 'italic' => false, 'fontName' => '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
													'textStyle' => array('color' => '#4e5e6a', 'fontSize' => 13, 'bold' => false, 'italic' => false, 'fontName' => '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;')
												),
												'colors' => array('#5840bb')
											);
											require_once SMS_PLUGIN_DIR . '/lib/chart/GoogleCharts.class.php';
											$GoogleCharts = new GoogleCharts;
											
											if (!empty($income_result)) {
												$chart = $GoogleCharts->load('column', 'chart_div_payment_report')->get($chart_array, $options);
											}
											if (isset($income_result) && count($income_result) > 0) 
											{
											?>
												<div id="chart_div_payment_report"></div>

												<!-- Javascript -->
												<script type="text/javascript" src="https://www.google.com/jsapi"></script>
												<script type="text/javascript">
													<?php echo $chart; ?>
												</script>
											<?php
											}
											else 
											{
												?>
												<div class="calendar-event-new no_data_img_center"> 
													<img class="no_data_img" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >
												</div>									
												<?php 
											} ?>
										</div>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
									<div class="smgt-calendar panel">
										<div class="row panel-heading activities">
											<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
												<h3 class="panel-title calander_heading_title_width"><?php esc_html_e('Calendar','school-mgt');?></h3>
											</div>
											<div class="smgt-cal-py col-sm-12 col-md-8 col-lg-8 col-xl-8 celender_dot_div">
												<div class="smgt-card-head">
													<ul class="smgt-cards-indicators smgt-right">
														<!--set caldender-header event-List Start -->
														<li><span class="smgt-indic smgt-blue-indic"></span> <?php esc_html_e( 'Holiday', 'school-mgt' ); ?></li>
														<li><span class="smgt-indic smgt-green-indic"></span> <?php esc_html_e( 'Notice', 'school-mgt' );?></li>
														<li><span class="smgt-indic smgt-perple-indic"></span> <?php esc_html_e( 'Exam', 'school-mgt' );?></li>
														<li><span class="smgt-indic smgt-light-blue-indic"></span> <?php esc_html_e( 'Event', 'school-mgt' );?></li>
														<!--set caldender-header event-List End -->
													</ul>
												</div>   
											</div>
										</div>
										<div class="smgt-cal-py smgt-calender-margin-top">
											<div id="calendar"></div>
										</div>
									</div>
								</div>
							</div>
							<!-- Celender And Chart Row  -->

							<!---------------  FEES PAYMENT AND EXPENSE REPORT GRAPH  ---------------->
							<div class="row">
								<div class="col-md-12 col-lg-12 col-sm-12 com-xs-12 responsive_div_dasboard precription_padding_left">
									<div class="panel panel-white fess_report priscription">
										<div class="panel-heading ">					
											<h3 class="panel-title padding_bottom_10px"><?php esc_html_e('Fees Payment & Expense Report','school-mgt');?></h3>
											<div class="col-md-2 mb-2 input" style="float:right;">
												<select class="input_height_30px_dor_dashboard form-control date_type validate[required] dashboard_report_value" name="date_type" autocomplete="off">
													<option value="this_month">This Month</option>
													<option value="last_month">Last Month</option>
													<option value="this_year">This Year</option>
													<option value="last_year">Last Year</option>
												</select>
											</div>
										</div>
										<div class="panel-body class_padding">
											<div class="events1" id="report_append_id">
												<?php
												$result = array();
												$dataPoints_2 = array();
											
												$list=array();
												$month = date("m");
												$current_month = date("m");
												$current_year = date("Y");
												if($month=="2")
												{
													$max_d="28";
												}
												elseif($month=="4" || $month=="6" || $month=="9" || $month=="11")
												{
													$max_d="30";
												}
												else
												{
													$max_d="31";
												}
												for($d=1; $d<= $max_d; $d++)
												{
													$time=mktime(12, 0, 0, $month, $d, $year); 
															
													if (date('m', $time)==$month)       
														
														$date_list[]=date('Y-m-d', $time);
														$day_date[]=date('d', $time);
										
														$month_first_date = min($date_list);
														$month_last_date =   max($date_list);
												}
												
												$month = array();
												$i=1;
												foreach($day_date as $value)
												{ 
													$month[$i] = $value;
													$i++;
												}
												
												array_push($dataPoints_2, array(esc_html__('Day','apartment_mgt'),esc_html__('Fees Payment','apartment_mgt'),esc_html__('Expense','apartment_mgt')));
												$dataPoints_1 = array();
												$expense_array = array();
												$currency_symbol = MJ_smgt_get_currency_symbol(get_option( 'smgt_currency_code' ));
												foreach($month as $key=>$value)
												{
													
													global $wpdb;
													$table_name = $wpdb->prefix."smgt_income_expense";
													$fees_table_name = $wpdb->prefix."smgt_fees_payment";
											
													$q = "SELECT * FROM $fees_table_name WHERE YEAR(paid_by_date) = $current_year AND MONTH(paid_by_date) = $current_month AND DAY(paid_by_date) = $value";
													$q1 = "SELECT * FROM $table_name WHERE YEAR(income_create_date) = $current_year AND MONTH(income_create_date) = $current_month AND DAY(income_create_date) = $value and invoice_type='expense'";

													$result=$wpdb->get_results($q);
													$result1=$wpdb->get_results($q1);

													// EXPENSE ENTRY //
													$expense_yearly_amount = 0;
													foreach($result1 as $expense_entry)
													{
														$all_entry=json_decode($expense_entry->entry);
														$amount=0;
														foreach($all_entry as $entry)
														{
															$amount+=$entry->amount;
														}
														$expense_yearly_amount += $amount;
													}

													if($expense_yearly_amount == 0)
													{
														$expense_amount = null;
													}
													else
													{
														$expense_amount = $expense_yearly_amount;
													}
													// END EXPENSE ENTRY //

												
													// FEES PAYMENT ENTRY //
													$income_yearly_amount = 0;
													if(!empty($result))
													{
														foreach ($result as $retrieved_data) 
														{ 
															$income_amount = $retrieved_data->total_amount;
															$income_yearly_amount += $income_amount;
														}
													}
													
													if($income_yearly_amount == 0)
													{
														$income_amount = null;
													}
													else
													{
														$income_amount = $income_yearly_amount;
													}
													// END FEES PAYMENT ENTRY //
													$expense_array[] = $expense_amount;
													$income_array[] = $income_amount;
													array_push($dataPoints_2, array($value,$income_amount,$expense_amount));		
												}

												$new_array = json_encode($dataPoints_2);
												
												$income_filtered = array_filter($income_array);
												$expense_filtered = array_filter($expense_array);
												if(!empty($income_filtered) || !empty($expense_filtered))
												{
													$new_currency_symbol = html_entity_decode($currency_symbol);
												
													?>
													
													<script type="text/javascript" src="<?php echo SMS_PLUGIN_URL.'/assets/js/chart_loder.js'; ?>"></script>
													<script type="text/javascript">
														google.charts.load('current', {'packages':['bar']});
														google.charts.setOnLoadCallback(drawChart);
														function drawChart() {
															var data = google.visualization.arrayToDataTable(<?php echo $new_array; ?>);

															var options = {
															
																bars: 'vertical', // Required for Material Bar Charts.
																colors: ['#104B73', '#FF9054'],
																
															};
														
															var chart = new google.charts.Bar(document.getElementById('barchart_material'));

															chart.draw(data, google.charts.Bar.convertOptions(options));
														}
													</script>
													<div id="barchart_material" style="width:100%;height: 280px; padding:20px;"></div>
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
												?>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!---------------  FEES PAYMENT AND EXPENSE REPORT GRAPH  ---------------->

							<!-- Class and Exam List Row  -->
							<div class="row">
								<div class="col-md-6 col-lg-6 col-sm-12 com-xs-12 responsive_div_dasboard precription_padding_left">
									<div class="panel panel-white event priscription">
										<div class="panel-heading ">					
											<h3 class="panel-title"><?php esc_html_e('Class','school-mgt');?></h3>						
											<a class="page-link123" href="<?php echo admin_url().'admin.php?page=smgt_class'; ?>"><img class="vertical_align_unset" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Redirect.png"?>"></a>
										</div>
										<div class="panel-body class_padding">
											<div class="events1">
												<?php 
												$class_data = mj_smgt_class_dashboard();
												$i=0;
												if(!empty($class_data))
												{
													foreach ($class_data as $retrieved_data)
													{ 
														$class_id=$retrieved_data->class_id;
														$user=count(get_users(array(
															'meta_key' => 'class_name',
															'meta_value' => $class_id
														)));

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
														?>			
													
														<div class="row smgt-group-list-record profile_image_class class_record_height">
															<div class="cursor_pointer col-sm-2 col-md-2 col-lg-2 col-xl-2 <?php echo $color_class; ?> remainder_title class_tag Bold save1 show_task_event show_task_event_list profile_image_appointment smgt_class_color0" id="<?php echo $retrieved_data->class_id;?>" model="Class Details">
																<img class="class_image_1 center" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Class.png"?>">
															</div>
															<div class="d-flex align-items-center col-sm-7 col-md-7 col-lg-7 col-xl-7 smgt-group-list-record-col-img">
																<div class="cursor_pointer class_font_color cmgt-group-list-group-name remainder_title_pr Bold viewdetail show_task_event" id="<?php echo $retrieved_data->class_id;?>" model="Class Details">
																	<span><?php echo $retrieved_data->class_name;?></span>
																</div>
															</div>
															<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 justify-content-end d-flex align-items-center smgt-group-list-record-col-count">
																<div class="smgt-group-list-total-group">
																	<?php	
																		echo $user;
																		esc_attr_e(' Out Of ', 'school-mgt');
																		echo $retrieved_data->class_capacity;
																	?>
																</div>
															</div>
														</div>
														<?php
														$i++;
													}
												}	
												else
												{
													?>
													<div class="calendar-event-new"> 
														<img class="no_data_img" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >
														<div class="col-md-12 dashboard_btn padding_top_30px">
															<a href="<?php echo admin_url().'admin.php?page=smgt_class&tab=addclass'; ?>" class="btn save_btn event_for_alert line_height_31px"><?php esc_html_e('ADD Class','school-mgt');?></a>
														</div>	
															
													</div>		
													<?php
												}	
												?>	
											</div>                       
										</div>
									</div>
								</div>
								<div  class="col-md-6 col-lg-6 col-sm-12 com-xs-12 responsive_div_dasboard precription_padding_left1">
									<div class="panel panel-white event operation">
										<div class="panel-heading ">
											<h3 class="panel-title"><?php esc_html_e('Exam List','school-mgt');?></h3>						
											<a class="page-link123" href="<?php echo admin_url().'admin.php?page=smgt_exam'; ?>"><img class="vertical_align_unset" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Redirect.png"?>"></a>
										</div>
										<div class="panel-body">
											<div class="events">
												<?php
												$exam = new smgt_exam;
												$examdata = $exam->mj_smgt_exam_list_for_dashboard();
												$i=0;
												if(!empty($examdata))
												{
													foreach ($examdata as $retrieved_data)
													{	
														$cid=$retrieved_data->class_id;	
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
														?>
																
														<div class="calendar_event_p calendar-event view-complaint"> 
															<p class="cursor_pointer smgt_exam_list_img show_task_event <?php echo $color_class;?>" id="<?php echo $retrieved_data->exam_id; ?>" model="Exam Details">
																<img class="class_image_1 center" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/White_icons/Exam_hall.png"?>">
															</p>
															<p class="cursor_pointer smgt_exam_remainder_title_pr remainder_title_pr Bold viewpriscription show_task_event"  id="<?php echo $retrieved_data->exam_id;?>" model="Exam Details">
																<?php echo $retrieved_data->exam_name;?>&nbsp;&nbsp;<span class="smgt_exam_start_date">
																<?php echo get_the_title($retrieved_data->exam_term);?>&nbsp;|&nbsp;<?php echo mj_smgt_get_class_name($cid);?></span>	
															</p>
															<p class="smgt_exam_remainder_title_pr smgt_description_line">
																<span class="smgt_activity_date" id="smgt_start_date_end_date"><?php  echo mj_smgt_getdate_in_input_box($retrieved_data->exam_start_date); ?>&nbsp;|&nbsp;<?php echo mj_smgt_getdate_in_input_box($retrieved_data->exam_end_date); ?></span>
															</p>
														</div>
														<?php
														$i++;
													}
												}	
												else
												{
													?>
													<div class="calendar-event-new"> 
														<img class="no_data_img" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >
														<div class="col-md-12 dashboard_btn padding_top_30px">
															<a href="<?php echo admin_url().'admin.php?page=smgt_exam&tab=addexam'; ?>" class="btn save_btn event_for_alert line_height_31px"><?php esc_html_e('ADD Exam','school-mgt');?></a>
														</div>	
													</div>		
													<?php
												}	
												?>		
											</div>                       
										</div>
									</div>
								</div>
							</div>
							<!-- Class and Exam list Row End -->

							<!-- Notice and Event Row Div Start  -->
							<div class="row">
								<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 responsive_div_dasboard precription_padding_left">
									<div class="panel panel-white event">
										<div class="panel-heading ">
											<h3 class="panel-title"><?php esc_html_e('Notice','school-mgt');?></h3>						
											<a class="page-link123" href="<?php echo admin_url().'admin.php?page=smgt_notice'; ?>"><img class="vertical_align_unset" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Redirect.png"?>"></a>
										</div>					
										<div class="panel-body">
											<div class="events">	
												<?php         
												$args['post_type'] = 'notice';
												$args['posts_per_page'] = 4;
												$args['post_status'] = 'public';
												$q = new WP_Query();
												$retrieve_class = $q->query($args);
					
												$format = get_option('date_format');
												$i=0;
												if(!empty($retrieve_class))
												{ 
													foreach ($retrieve_class as $retrieved_data)
													{ 
														if($i == 0)
														{
															$color_class='smgt_notice_color0';
														}
														elseif($i == 1)
														{
															$color_class='smgt_notice_color1';

														}
														elseif($i == 2)
														{
															$color_class='smgt_notice_color2';

														}
														elseif($i == 3)
														{
															$color_class='smgt_notice_color3';

														}
														elseif($i == 4)
														{
															$color_class='smgt_notice_color4';
														}
														?>
														<div class="calendar-event notice_div <?php echo $color_class; ?>"> 
															<div class="notice_div_contant profile_image_prescription">
																<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 notice_description_div">
																	<p class="cursor_pointer remainder_title Bold viewdetail notice_descriptions show_task_event notice_heading notice_content_rs" id="<?php echo esc_attr($retrieved_data->ID); ?>" model="Noticeboard Details" style="width: 100%;">	
																		<label for="" class="cursor_pointer notice_heading_label notice_heading">
																			<?php echo esc_html($retrieved_data->post_title); ?>	
																		</label>
																		
																		<a href="#" class="notice_date_div">
																		<?php echo mj_smgt_getdate_in_input_box(get_post_meta($retrieved_data->ID,'start_date',true)); ?> &nbsp;|&nbsp; <?php echo mj_smgt_getdate_in_input_box(get_post_meta($retrieved_data->ID,'end_date',true)); ?>
																		</a>
																	</p>
																	<p class="cursor_pointer remainder_title viewdetail notice_descriptions" style="width: 100%;"><?php echo esc_html($retrieved_data->post_content); ?></p>
																</div>
															</div>
														</div>	
													<?php
													$i++;
													}
												}
												else
												{
													?>
													<div class="calendar-event-new"> 
														<img class="no_data_img" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >
														<div class="col-md-12 dashboard_btn padding_top_30px">
															<a href="<?php echo admin_url().'admin.php?page=smgt_notice&tab=addnotice'; ?>" class="btn save_btn event_for_alert line_height_31px"><?php esc_html_e('ADD Notice','school-mgt');?></a>
														</div>	
													</div>		
													<?php
												}	
												?>
											</div>                       
										</div>
									</div>
								</div>
								<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 responsive_div_dasboard precription_padding_left1">
									<div class="panel panel-white massage">
										<div class="panel-heading">
											<h3 class="panel-title"><?php esc_html_e('Event List','school-mgt');?></h3>						
											<a class="page-link123" href="<?php echo admin_url().'admin.php?page=smgt_event&tab=eventlist'; ?>"><img class="vertical_align_unset" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Redirect.png"?>"></a>
										</div>
										<div class="panel-body">
											<div class="events notice_content_div">
												<?php  
												$event_data = $obj_event->MJ_smgt_get_all_event_for_dashboard();
												$i=0;
												if(!empty($event_data))
												{ 
													foreach ($event_data as $retrieved_data)
													{ 
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
														?>						
														<div class="calendar-event profile_image_class"> 
															
															<p class="cursor_pointer class_tag Bold save1 show_task_event show_task_event_list profile_image_appointment <?php echo $color_class; ?>" id="<?php echo $retrieved_data->event_id; ?>" model="Event Details">
																<img class="class_image center" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/White_icons/notice.png"?>">
															</p>
															<p class="cursor_pointer padding_top_5px_res remainder_title_pr card_content_width show_task_event padding_top_card_content viewpriscription class_width" style="color: #333333;"  id="<?php echo $retrieved_data->event_id; ?>" model="Event Details"> 
																<?php echo $retrieved_data->event_title; ?>
															</p>
															<p class="remainder_date_pr date_background class_width"> <label for="" class="label_for_date"><?php echo mj_smgt_getdate_in_input_box($retrieved_data->start_date); ?></label> </p>
															<p class="remainder_title_pr viewpriscription card_content_width class_width assignbed_name1 card_margin_top"> 
																<?php
																	$strlength = strlen($retrieved_data->description);
																	if ($strlength > 90) 
																	{
																		echo substr($retrieved_data->description, 10, 90) . '...';
																	} else 
																	{
																		echo $retrieved_data->description;
																	}
																?>
															</p>
															
														</div>		
														<?php
														$i++;
													}
												}
												else
												{
													?>
													<div class="calendar-event-new"> 
														<img class="no_data_img" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >
														<div class="col-md-12 dashboard_btn padding_top_30px">
															<a href="<?php echo admin_url().'admin.php?page=smgt_event&tab=add_event'; ?>" class="btn save_btn event_for_alert line_height_31px"><?php esc_html_e('ADD Event','school-mgt');?></a>
														</div>	
													</div>		
													<?php
												}	
												?>					
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- Notice and Event Row Div End  -->
									
							<!-- Holiday And Notification Row Div Start  -->
							<div class="row">
								<div class="col-md-6 col-lg-6 col-sm-12 com-xs-12 responsive_div_dasboard precription_padding_left">
									<div class="panel panel-white event priscription">
										<div class="panel-heading ">					
											<h3 class="panel-title"><?php esc_html_e('Notification','school-mgt');?></h3>						
											<a class="page-link123" href="<?php echo admin_url().'admin.php?page=smgt_notification'; ?>"><img class="vertical_align_unset" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Redirect.png"?>"></a>
										</div>
										<div class="panel-body message_rtl_css">
											<div class="events1">
												<?php 
												$notification_data = mj_smgt_notification_dashboard();
										
												$i=0;
												if(!empty($notification_data))
												{
													foreach ($notification_data as $retrieved_data)
													{ 
												
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
														?>	
												
														<div class="calendar-event profile_image_class"> 
															<p class="cursor_pointer remainder_title_pr Bold viewpriscription show_task_event class_tag <?php echo $color_class; ?>" id="<?php echo esc_attr($retrieved_data->notification_id); ?>" model="Notification Details" >
																<img class="class_image center" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/White_icons/Notification.png"?>">
															</p>
															<p class="cursor_pointer padding_top_5px_res card_content_width remainder_title_pr viewpriscription show_task_event class_width padding_top_card_content" id="<?php echo esc_attr($retrieved_data->notification_id); ?>" model="Notification Details" style="color: #333333;">
																<?php echo $retrieved_data->title; ?> 
															</p>
															<p class="remainder_date_pr date_background class_width"> <label for="" class="label_for_date"><?php echo mj_smgt_getdate_in_input_box($retrieved_data->created_date); ?></label> </p>
															<p class="remainder_title_pr card_content_width viewpriscription class_width assignbed_name1 card_margin_top" > 
																<?php echo $retrieved_data->message; ?> 
															</p>
														</div>	
												<?php
												$i++;
													}
												}	
												else
												{
													?>
													<div class="calendar-event-new"> 
														<img class="no_data_img" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >
														<div class="col-md-12 dashboard_btn padding_top_30px">
															<a href="<?php echo admin_url().'admin.php?page=smgt_notification&tab=addnotification'; ?>" class="btn save_btn event_for_alert line_height_31px"><?php esc_html_e('ADD Notification','school-mgt');?></a>
														</div>	
															
													</div>		
													<?php
												}	
												?>	
											</div>                       
										</div>
									</div>
								</div>
								<div  class="col-md-6 col-lg-6 col-sm-12 com-xs-12 responsive_div_dasboard precription_padding_left1">
									<div class="panel panel-white event operation">
										<div class="panel-heading ">
											<h3 class="panel-title"><?php esc_html_e('Holiday List','school-mgt');?></h3>						
											<a class="page-link123" href="<?php echo admin_url().'admin.php?page=smgt_holiday'; ?>"><img class="vertical_align_unset" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Redirect.png"?>"></a>
										</div>
										<div class="panel-body">
											<div class="events rtl_notice_css">
												<?php
												$holidaydata = mj_smgt_holiday_dashboard();
											
												$i=0;
												if(!empty($holidaydata))
												{
													foreach ($holidaydata as $retrieved_data)
													{		
														
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
														
														if($retrieved_data->status == 0)
														{

															?>
															<div class="calendar-event profile_image_class"> 
															
																<p class="cursor_pointer remainder_title class_tag Bold save1 show_task_event show_task_event_list profile_image_appointment <?php echo $color_class; ?>" id="<?php echo $retrieved_data->holiday_id; ?>" model="holiday Details">
																	<img class="class_image center" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/White_icons/Holiday.png"?>">
																</p>
																<p class="cursor_pointer holiday_list_description_res remainder_title_pr show_task_event padding_top_card_content viewpriscription holiday_width" style="color: #333333;"  id="<?php echo $retrieved_data->holiday_id; ?>" model="holiday Details"> 
																	<?php echo $retrieved_data->holiday_title; ?> <span class="date_div_color"><?php echo mj_smgt_getdate_in_input_box($retrieved_data->date); ?> | <?php echo mj_smgt_getdate_in_input_box($retrieved_data->end_date); ?></span> 
																</p>
																<p class="remainder_title_pr holiday_list_description_res viewpriscription holiday_width assignbed_name1 card_margin_top"> 
																	<?php
																		echo $retrieved_data->description;
																	?>
																</p>
																
															</div>	
															<?php
														}
														$i++;
													}
												}	
												else
												{
													?>
													<div class="calendar-event-new"> 
														<img class="no_data_img" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >
														<div class="col-md-12 dashboard_btn padding_top_30px">
															<a href="<?php echo admin_url().'admin.php?page=smgt_holiday&tab=addholiday'; ?>" class="btn save_btn event_for_alert line_height_31px"><?php esc_html_e('ADD Holiday','school-mgt');?></a>
														</div>	
													</div>		
													<?php
												}	
												?>		
											</div>                       
										</div>
									</div>
								</div>
							</div>
							<!-- Notification And Holiday Row Div End -->

							<!------------- MESSAGE AND TRASPORT ROW DIV START ------------------>
							<div class="row">
								<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 responsive_div_dasboard precription_padding_left1">
									<div class="panel panel-white massage">
										<div class="panel-heading">
											<h3 class="panel-title"><?php esc_html_e('Message','school-mgt');?></h3>						
											<a class="page-link123" href="<?php echo admin_url().'admin.php?page=smgt_message'; ?>"><img class="vertical_align_unset" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Redirect.png"?>"></a>
										</div>
										<div class="panel-body">
											<div class="events notice_content_div">
												<?php         
												//$message_data = mj_smgt_message_dashboard();
												$max = 5;
												if(isset($_GET['pg']))
												{
													$p = $_GET['pg'];
												}
												else
												{
													$p = 1;
												}
												$limit = ($p - 1) * $max;
											
												$post_id=0;
												$message_data = mj_smgt_get_inbox_message(get_current_user_id(),$limit,$max);
											
												$i=0;
												if(!empty($message_data))
												{ 
													foreach ($message_data as $retrieved_data)
													{ 
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
														?>						
														<div class="calendar-event profile_image_class"> 
															
															<p class="cursor_pointer class_tag Bold save1 show_task_event show_task_event_list profile_image_appointment <?php echo $color_class; ?>" id="<?php echo $retrieved_data->message_id; ?>" model="Message Details">
																<img class="class_image center" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/White_icons/Message_Chat.png"?>">
															</p>
															<p class="cursor_pointer padding_top_5px_res remainder_title_pr card_content_width show_task_event padding_top_card_content viewpriscription class_width" style="color: #333333;"  id="<?php echo $retrieved_data->message_id; ?>" model="Message Details"> 
																<?php echo $retrieved_data->subject; ?>
															</p>
															<p class="remainder_date_pr date_background class_width"> <label for="" class="label_for_date"><?php echo mj_smgt_getdate_in_input_box($retrieved_data->date); ?></label> </p>
															<p class="remainder_title_pr viewpriscription card_content_width class_width assignbed_name1 card_margin_top"> 
																<?php
																	$strlength = strlen($retrieved_data->message_body);
																	if ($strlength > 90) 
																	{
																		echo substr($retrieved_data->message_body, 10, 90) . '...';
																	} else 
																	{
																		echo $retrieved_data->message_body;
																	}
																?>
															</p>
															
														</div>		
														<?php
														$i++;
													}
												}
												else
												{
													?>
													<div class="calendar-event-new"> 
														<img class="no_data_img" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >
														<div class="col-md-12 dashboard_btn padding_top_30px">
															<a href="<?php echo admin_url().'admin.php?page=smgt_message&tab=compose'; ?>" class="btn save_btn event_for_alert line_height_31px"><?php esc_html_e('ADD Message','school-mgt');?></a>
														</div>	
													</div>		
												<?php
												}	
												?>					
											</div>
										</div>
									</div>
								</div>
								<div  class="col-md-6 col-lg-6 col-sm-12 com-xs-12 responsive_div_dasboard precription_padding_left1">
									<div class="panel panel-white event operation">
										<div class="panel-heading ">
											<h3 class="panel-title"><?php esc_html_e('Transport List','school-mgt');?></h3>						
											<a class="page-link123" href="<?php echo admin_url().'admin.php?page=smgt_transport'; ?>"><img class="vertical_align_unset" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Redirect.png"?>"></a>
										</div>
										<div class="panel-body">
											<div class="events rtl_notice_css">
												<?php
												$transport_data = MJ_smgt_get_trasport_data_for_dashboard();
											
												$i=0;
												if(!empty($transport_data))
												{
													foreach ($transport_data as $retrieved_data)
													{		
														?>
														<div class="calendar-event profile_image_class"> 
															<p class="cursor_pointer remainder_title class_tag Bold save1 show_task_event show_task_event_list profile_image_appointment" id="<?php echo $retrieved_data->transport_id; ?>" model="transport Details">
																<?php
																$tid=$retrieved_data->transport_id;
																$umetadata=mj_smgt_get_user_driver_image($tid);
															
																if(empty($umetadata) || $umetadata['smgt_user_avatar'] == "")
																{	
																	echo '<img src="'.get_option( 'smgt_driver_thumb_new' ).'" height="50px" width="50px" class="img-circle" />';
																}
																else
																echo '<img src='.$umetadata['smgt_user_avatar'].' height="50px" width="50px" class="img-circle" />';?>				
															</p>
															<p class="cursor_pointer holiday_list_description_res remainder_title_pr show_task_event padding_top_card_content viewpriscription holiday_width" style="color: #333333;"  id="<?php echo $retrieved_data->transport_id; ?>" model="transport Details"> 
																<?php echo $retrieved_data->route_name; ?> <span class="date_div_color"> <?php echo $retrieved_data->vehicle_reg_num; ?> </span> 
															</p>
															<p class="remainder_title_pr holiday_list_description_res viewpriscription holiday_width assignbed_name1 card_margin_top"> 
																<?php
																	echo $retrieved_data->driver_name;
																?>
															</p>
															
														</div>	
														<?php
													}
												}	
												else
												{
													?>
													<div class="calendar-event-new"> 
														<img class="no_data_img" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >
														<div class="col-md-12 dashboard_btn padding_top_30px">
															<a href="<?php echo admin_url().'admin.php?page=smgt_transport&tab=addtransport'; ?>" class="btn save_btn event_for_alert line_height_31px"><?php esc_html_e('ADD Transport','school-mgt');?></a>
														</div>	
													</div>		
													<?php
												}	
												?>		
											</div>                       
										</div>
									</div>
								</div>
							</div>
							<?php
						}
						?>
						</div>
					</div>
				</div>
				<!-- End dashboard content div -->
			</div>
			<!-- Footer Part Start  -->
			<footer class='smgt-footer'>
				<p><?php echo get_option('smgt_footer_description'); ?></p>
			</footer>
			<!-- Footer Part End  -->
		</body>
		<!-- body part End  -->
	</html>
<!-- End task-event POP-UP Code -->