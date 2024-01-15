<?php //-------- CHECK BROWSER JAVA SCRIPT ----------//
mj_smgt_browser_javascript_check();
$role=mj_smgt_get_user_role(get_current_user_id());
if($role == 'administrator')
{
	$user_access_view=1;
}
else
{
	$user_access=mj_smgt_get_userrole_wise_filter_access_right_array('report');
	$user_access_view=$user_access['view'];
	
	if (isset ( $_REQUEST ['page'] ))
	{	
		if($user_access_view=='0')
		{	
			mj_smgt_access_right_page_not_access_message_admin_side();
			die;
		}
	}
}

?>
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.4.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.4.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.4.0/js/buttons.print.min.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($){
		"use strict";	
		$('#failed_report').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	
		$('#student_attendance').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});	
		$('#student_book_issue_report').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});

		$("#sdate").datepicker({
			dateFormat: "yy-mm-dd",
			changeYear: true,
			changeMonth: true,
			maxDate:0,
			onSelect: function (selected) {
				var dt = new Date(selected);
				dt.setDate(dt.getDate() + 0);
				$("#edate").datepicker("option", "minDate", dt);
			}
		});

	
		$("#edate").datepicker({
		dateFormat: "yy-mm-dd",
		changeYear: true,
		changeMonth: true,
		maxDate:0,
			onSelect: function (selected) {
				var dt = new Date(selected);
				dt.setDate(dt.getDate() - 0);
				$("#sdate").datepicker("option", "maxDate", dt);
			}
		});

		$('#fee_payment_report').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});
		$('#student_expence_payment').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});
		$('#student_income_expence_payment').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});
		$('#student_income_payment').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});

		
		$('.sdate').datepicker({dateFormat: "yy-mm-dd",changeYear: true,changeMonth:true}); 
		$('.edate').datepicker({dateFormat: "yy-mm-dd",changeMonth: true,changeMonth:true}); 
	
		var table = jQuery('#table_income_expense').DataTable({
			"responsive": true,
			"order": [[ 2, "Desc" ]],
			"dom": 'lifrtp',
			buttons:[
				{
					extend: 'csv',
					text:'CSV',
					title: 'Monthly Report',
				},
				{
					extend: 'print',
					text:'Print',
					title: 'Monthly Report',
				},
			],
			"aoColumns":[
				{"bSortable": false},
				{"bSortable": true},
				{"bSortable": true},
				{"bSortable": true}
			],
			language:<?php echo mj_smgt_datatable_multi_language();?>
		});
		$('.btn-place').html(table.buttons().container()); 

		var table = jQuery('#tble_income_expense').DataTable({
			"responsive": true,
			"order": [[ 2, "Desc" ]],
			"dom": 'lifrtp',
			buttons:[
				{
					extend: 'csv',
					text:'CSV',
					title: 'Monthly Report',
				},
				{
					extend: 'print',
					text:'Print',
					title: 'Monthly Report',
				},
			],
			"aoColumns":[
				{"bSortable": false},
				{"bSortable": true},
				{"bSortable": true},
				{"bSortable": true}
			],
			language:<?php echo mj_smgt_datatable_multi_language();?>
		});
			
		var table = jQuery('#attendance_list_report').DataTable({
			"responsive": true,
			"order": [[ 2, "Desc" ]],
			"dom": 'lifrtp',
			buttons:[
				{
					extend: 'csv',
					text:'CSV',
					title: 'Monthly Report',
				},
				{
					extend: 'print',
					text:'Print',
					title: 'Monthly Report',
				},
			],
			"aoColumns":[
				{"bSortable": false},
				{"bSortable": true},
				{"bSortable": true},
				{"bSortable": true},
				{"bSortable": true},
				{"bSortable": true},
				{"bSortable": true}
			],
			language:<?php echo mj_smgt_datatable_multi_language();?>
		});
		$('.btn-place').html(table.buttons().container()); 
		$('#fee_payment_report').validationEngine({promptPosition : "bottomLeft",maxErrorsPerField: 1});
		$('#sdate').datepicker({
			dateFormat: "yy-mm-dd",
			changeYear: true,
			changeMonth: true,
			maxDate : 0,
			beforeShow: function (textbox, instance) 
				{
					instance.dpDiv.css({
						marginTop: (-textbox.offsetHeight) + 'px'                   
					});
				}
		}); 
		$('#edate').datepicker({
			dateFormat: "yy-mm-dd",
			changeYear: true,
			changeMonth: true,
			maxDate : 0,
			beforeShow: function (textbox, instance) 
			{
				instance.dpDiv.css({
					marginTop: (-textbox.offsetHeight) + 'px'                   
				});
			}
		}); 

		
	});
</script>
<?php 
$active_tab = isset($_GET['tab'])?$_GET['tab']:'report1';
$obj_marks = new Marks_Manage();
if($active_tab == 'report1')
{
	// $chart_array = array();
	// $chart_array[] = array( esc_attr__('Class','school-mgt'),esc_attr__('No. of Student Fail','school-mgt'));

	// if(isset($_REQUEST['report_1']))
	// {
	// 	global $wpdb;
	// 	$table_marks = $wpdb->prefix .'marks';
	// 	$table_users = $wpdb->prefix .'users';
	// 	$exam_id = $_REQUEST['exam_id'];
	// 	$class_id = $_REQUEST['class_id'];
	// 	if(isset($_REQUEST['class_section']) && $_REQUEST['class_section']!="")
	// 	{
	// 		$section_id = $_REQUEST['class_section'];	
	// 		$report_1 =$wpdb->get_results("SELECT * , count( student_id ) as count
	// 			FROM $table_marks as m, $table_users as u
	// 			WHERE m.marks <40
	// 			AND m.exam_id = $exam_id
	// 			AND m.Class_id = $class_id
	// 			AND m.section_id = $section_id
	// 			AND m.student_id = u.id
	// 			GROUP BY subject_id");
	// 	}
	// 	else
	// 	{		
	// 		$report_1 =$wpdb->get_results("SELECT * , count( student_id ) as count
	// 			FROM $table_marks as m, $table_users as u
	// 			WHERE m.marks <40
	// 			AND m.exam_id = $exam_id
	// 			AND m.Class_id = $class_id
	// 			AND m.student_id = u.id
	// 			GROUP BY subject_id");
	// 	}
		
	// 	if(!empty($report_1))
	// 	foreach($report_1 as $result)
	// 	{	
	// 		$subject =mj_smgt_get_single_subject_name($result->subject_id);
	// 		$chart_array[] = array("$subject",(int)$result->count);
	// 	}
	// 	$options = Array(
	// 			'title' => esc_attr__('Exam Failed Report','school-mgt'),
	// 			'titleTextStyle' => Array('color' => '#4e5e6a','fontSize' => 16,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
	// 			'legend' =>Array('position' => 'right',
	// 					'textStyle'=> Array('color' => '#4e5e6a','fontSize' => 13,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;')),
					
	// 			'hAxis' => Array(
	// 					'title' =>  esc_attr__('Subject','school-mgt'),
	// 					'titleTextStyle' => Array('color' => '#4e5e6a','fontSize' => 16,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
	// 					'textStyle' => Array('color' => '#4e5e6a','fontSize' => 13,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
	// 					'maxAlternation' => 2
	// 			),
	// 			'vAxis' => Array(
	// 					'title' =>  esc_attr__('No. of Student','school-mgt'),
	// 					'minValue' => 0,
	// 					'maxValue' => 5,
	// 					'format' => '#',
	// 					'titleTextStyle' => Array('color' => '#4e5e6a','fontSize' => 16,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
	// 					'textStyle' => Array('color' => '#4e5e6a','fontSize' => 13,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;')
	// 			),
	// 			'colors' => array('#5840bb')
	// 	);
	// }
}
if($active_tab == 'report2')
{
	$chart_array[] = array(esc_attr__('Class','school-mgt'),esc_attr__('Present','school-mgt'),esc_attr__('Absent','school-mgt'));
	if(isset($_REQUEST['report_2']))
	{
	
		global $wpdb;
		$table_attendance = $wpdb->prefix .'attendence';
		$table_class = $wpdb->prefix .'smgt_class';
		$sdate = $_REQUEST['sdate'];
		$edate = $_REQUEST['edate'];
	
		$report_2 =$wpdb->get_results("SELECT  at.class_id, 
		SUM(case when `status` ='Present' then 1 else 0 end) as Present, 
		SUM(case when `status` ='Absent' then 1 else 0 end) as Absent 
		from $table_attendance as at,$table_class as cl where `attendence_date` BETWEEN '$sdate' AND '$edate' AND at.class_id = cl.class_id AND at.role_name = 'student' GROUP BY at.class_id") ;
		if(!empty($report_2))
		foreach($report_2 as $result)
		{	
			$class_id =mj_smgt_get_class_name($result->class_id);
			$chart_array[] = array("$class_id",(int)$result->Present,(int)$result->Absent);
		}

		$options = Array(
			'title' => esc_attr__('Attendance Report','school-mgt'),
			'titleTextStyle' => Array('color' => '#4e5e6a','fontSize' => 16,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
			'legend' =>Array('position' => 'right',
					'textStyle'=> Array('color' => '#4e5e6a','fontSize' => 13,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;')),
				
			'hAxis' => Array(
					'title' =>  esc_attr__('Class','school-mgt'),
					'titleTextStyle' => Array('color' => '#4e5e6a','fontSize' => 16,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
					'textStyle' => Array('color' => '#4e5e6a','fontSize' => 13,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
					'maxAlternation' => 2


			),
			'vAxis' => Array(
					'title' =>  esc_attr__('No. of Student','school-mgt'),
					'minValue' => 0,
					'maxValue' => 5,
					'format' => '#',
					'titleTextStyle' => Array('color' => '#4e5e6a','fontSize' => 16,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
					'textStyle' => Array('color' => '#4e5e6a','fontSize' => 13,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;')
			),
			'colors' => array('#22BAA0','#f25656')
		);

	}
}

if($active_tab == 'report3')
{
	$chart_array[] = array(esc_attr__('Teacher','school-mgt'),esc_attr__('fail','school-mgt'));
		global $wpdb;
		$table_subject = $wpdb->prefix .'subject';
		$table_name_mark = $wpdb->prefix .'marks';
		$table_name_users = $wpdb->prefix .'users';
		$table_teacher_subject = $wpdb->prefix .'teacher_subject';		
		$teachers = get_users(array("role"=>"teacher"));
		$report_3 = array();
		if(!empty($teachers))
		{
			foreach($teachers as $teacher)
			{
				$report_3[$teacher->ID] = mj_smgt_get_subject_id_by_teacher($teacher->ID);
			}		
		}
		 
		if(!empty($report_3))
		{
			foreach($report_3 as $teacher_id=>$subject)
			{
				
				if(!empty($subject))
				{
					$sub_str = implode(",",$subject);
					$count = $wpdb->get_results("SELECT COUNT(*) as count FROM {$table_name_mark} WHERE marks < 40 AND subject_id in ({$sub_str}) GROUP by subject_id",ARRAY_A);
					$total_fail = array_sum(array_column($count,"count"));	
				}
				else
				{
					$total_fail =0;
				}
				$teacher_name = mj_smgt_get_display_name($teacher_id);
				$chart_array[] = [$teacher_name , $total_fail];
			}
		}
		
		$options = Array(
			'title' => esc_attr__('Teacher Perfomance Report','school-mgt'),
			'titleTextStyle' => Array('color' => '#4e5e6a','fontSize' => 16,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
			'legend' =>Array('position' => 'right',
				'textStyle'=> Array('color' => '#4e5e6a','fontSize' => 13,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;')),
				'hAxis' => Array(
					'title' =>  esc_attr__('Teacher Name','school-mgt'),
					'titleTextStyle' => Array('color' => '#4e5e6a','fontSize' => 16,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
					'textStyle' => Array('color' => '#4e5e6a','fontSize' => 13,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
					'maxAlternation' => 2
				),
				'vAxis' => Array(
					'title' =>  esc_attr__('No. of Student','school-mgt'),
					'minValue' => 0,
					'maxValue' => 5,
					'format' => '#',
					'titleTextStyle' => Array('color' => '#4e5e6a','fontSize' => 16,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;'),
					'textStyle' => Array('color' => '#4e5e6a','fontSize' => 13,'bold'=>false,'italic'=>false,'fontName' =>'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;')
				),
				'colors' => array('#5840bb')
			);
}
require_once SMS_PLUGIN_DIR. '/lib/chart/GoogleCharts.class.php';
$GoogleCharts = new GoogleCharts;
?>
	<!-- POP up code -->
<div class="popup-bg">
    <div class="overlay-content">
		<div class="modal-content">
			<div class="invoice_data"></div>		 
		</div>
    </div>
</div>
<!-- End POP-UP Code -->
<div class="page-inner"><!-- penal Inner --->
	<div class=" transport_list main_list_margin_5px" id=""> 
		<div class="panel-white"> <!-- penal White --->
			<div class="panel-body"> <!-- penal-body --->

				<!--  Student Information Report - start-->
				<?php 
				if($active_tab == 'student_information_report')
				{
					$active_tab = isset($_GET['tab1'])?$_GET['tab1']:'student_report'; 
   					?>
					<div class="clearfix"> </div>
					<!-- tabing start  -->
					<ul class="nav nav-tabs panel_tabs margin_left_1per" role="tablist">
						<li class="<?php if($active_tab=='student_report'){?>active<?php }?>">			
							<a href="?page=smgt_report&tab=student_information_report&tab1=student_report" class="padding_left_0 tab <?php echo $active_tab == 'student_report' ? 'active' : ''; ?>">
							<?php esc_html_e('Student Report', 'school-mgt'); ?></a> 
						</li>
						<li class="<?php if($active_tab=='class_section_report'){?>active<?php }?>">			
							<a href="?page=smgt_report&tab=student_information_report&tab1=class_section_report" class="padding_left_0 tab <?php echo $active_tab == 'class_section_report' ? 'active' : ''; ?>">
							<?php esc_html_e('Class & Section Report', 'school-mgt'); ?></a> 
						</li>
						<li class="<?php if($active_tab=='guardian_report'){?>active<?php }?>">			
							<a href="?page=smgt_report&tab=student_information_report&tab1=guardian_report" class="padding_left_0 tab <?php echo $active_tab == 'guardian_report' ? 'active' : ''; ?>">
							<?php esc_html_e('Guardian Report', 'school-mgt'); ?></a> 
						</li>
						<li class="<?php if($active_tab=='admission_report'){?>active<?php }?>">			
							<a href="?page=smgt_report&tab=student_information_report&tab1=admission_report" class="padding_left_0 tab <?php echo $active_tab == 'admission_report' ? 'active' : ''; ?>">
							<?php esc_html_e('Admission Report', 'school-mgt'); ?></a> 
						</li>
						<li class="<?php if($active_tab=='sibling_report'){?>active<?php }?>">			
							<a href="?page=smgt_report&tab=student_information_report&tab1=sibling_report" class="padding_left_0 tab <?php echo $active_tab == 'sibling_report' ? 'active' : ''; ?>">
							<?php esc_html_e(' Sibling Report', 'school-mgt'); ?></a> 
						</li>
						<li class="<?php if($active_tab=='student_failed'){?>active<?php }?>">			
							<a href="?page=smgt_report&tab=student_information_report&tab1=student_failed" class="padding_left_0 tab <?php echo $active_tab == 'student_failed' ? 'active' : ''; ?>">
							<?php esc_html_e('Student Failed', 'school-mgt'); ?></a> 
						</li>
						<li class="<?php if($active_tab=='teacher_performance_report'){?>active<?php }?>">
							<a href="?page=smgt_report&tab=student_information_report&tab1=teacher_performance_report" class="padding_left_0 tab <?php echo $active_tab == 'teacher_performance_report' ? 'active' : ''; ?>">
							<?php esc_html_e('Teacher Performance', 'school-mgt'); ?></a> 
						</li> 
					</ul>
					<div class="clearfix panel-body">
						<?php 
						if($active_tab == 'student_report')
						{ 				
							require_once SMS_PLUGIN_DIR.'/admin/includes/report/student_report.php';
						} 
						if($active_tab == 'class_section_report')
						{ 				
							require_once SMS_PLUGIN_DIR.'/admin/includes/report/class_section_report.php';
						} 
						if($active_tab == 'guardian_report')
						{ 				
							require_once SMS_PLUGIN_DIR.'/admin/includes/report/guardian_report.php';
						} 
						if($active_tab == 'admission_report')
						{ 				
							require_once SMS_PLUGIN_DIR.'/admin/includes/report/admission_report.php';
						} 
						if($active_tab == 'sibling_report')
						{ 				
							require_once SMS_PLUGIN_DIR.'/admin/includes/report/sibling_report.php';
						} 
						if($active_tab == 'student_failed')
						{ 				
							require_once SMS_PLUGIN_DIR.'/admin/includes/report/student_failed_report.php';
						} 
						if($active_tab == 'teacher_performance_report')
						{ 				
							require_once SMS_PLUGIN_DIR.'/admin/includes/report/teacher_performance_report.php';
						} 
						
						?>
					</div>
    				<?php 
    			}
				//--- Student Information Report - End --//

				//--- Attendance Report - start----//
				if($active_tab == 'attendance_report')
				{
					$active_tab = isset($_GET['tab1'])?$_GET['tab1']:'monthly_attendance_report'; 
   					?>
					<!-- tabing start -->
					<ul class="nav nav-tabs panel_tabs margin_left_1per" role="tablist">
						<li class="<?php if($active_tab=='monthly_attendance_report'){?>active<?php }?>">			
							<a href="?page=smgt_report&tab=attendance_report&tab1=monthly_attendance_report" class="padding_left_0 tab <?php echo $active_tab == 'monthly_attendance_report' ? 'active' : ''; ?>">
							<?php esc_html_e('Monthly Attendance Report', 'school-mgt'); ?></a> 
						</li>
						<li class="<?php if($active_tab=='daily_attendance_report'){?>active<?php }?>">			
							<a href="?page=smgt_report&tab=attendance_report&tab1=daily_attendance_report" class="padding_left_0 tab <?php echo $active_tab == 'daily_attendance_report' ? 'active' : ''; ?>">
							<?php esc_html_e('Daily Attendance Report', 'school-mgt'); ?></a> 
						</li>
						<li class="<?php if($active_tab=='attendance_report_datatable'){?>active<?php }?>">
							<a href="?page=smgt_report&tab=attendance_report&tab1=attendance_report_datatable" class="padding_left_0 tab <?php echo $active_tab == 'attendance_report_datatable' ? 'active' : ''; ?>">
							<?php esc_html_e('Attendance Report In Datatable', 'school-mgt'); ?></a> 
						</li> 
						
						<li class="<?php if($active_tab=='attendance_report_graph'){?>active<?php }?>">			
							<a href="?page=smgt_report&tab=attendance_report&tab1=attendance_report_graph" class="padding_left_0 tab <?php echo $active_tab == 'attendance_report_graph' ? 'active' : ''; ?>">
							<?php esc_html_e('Attendance Report In Graph', 'school-mgt'); ?></a> 
						</li>
					</ul>
					<div class="clearfix panel-body">
						<?php 
						if($active_tab == 'monthly_attendance_report')
						{ 				
							require_once SMS_PLUGIN_DIR.'/admin/includes/report/monthly_attendence_report.php';
						}	
						if($active_tab == 'daily_attendance_report')
						{ 				
							require_once SMS_PLUGIN_DIR.'/admin/includes/report/daily_attendance_report.php';
						}	
						if($active_tab == 'attendance_report_datatable')
						{ 				
							require_once SMS_PLUGIN_DIR.'/admin/includes/report/attendance_report_datatable.php';
						}	
						if($active_tab == 'attendance_report_graph')
						{ 				
							require_once SMS_PLUGIN_DIR.'/admin/includes/report/attendance_report_graph.php';
						} 
						?>
					</div>
    				<div class="clearfix"> </div>
   					 <?php 
    			}
				//--- Attendance Report - End----//


				//--- Attendance Report - start----//
				if($active_tab == 'hostel_report')
				{
					$active_tab = isset($_GET['tab1'])?$_GET['tab1']:'student_hostel_report'; 
   					?>
					<!-- tabing start  -->
					<ul class="nav nav-tabs panel_tabs margin_left_1per" role="tablist">
						<li class="<?php if($active_tab=='student_hostel_report'){?>active<?php }?>">			
							<a href="?page=smgt_report&tab=hostel_report&tab1=student_hostel_report" class="padding_left_0 tab <?php echo $active_tab == 'student_hostel_report' ? 'active' : ''; ?>">
							<?php esc_html_e('Student Hostel Report', 'school-mgt'); ?></a> 
						</li>
					</ul>
					<div class="clearfix panel-body">
						<?php 	
						if($active_tab == 'student_hostel_report')
						{ 				
							require_once SMS_PLUGIN_DIR.'/admin/includes/report/student_hostel_report.php';
						} 
						?>
					</div>
    				<div class="clearfix"> </div>
   					 <?php 
    			}
				//--- Attendance Report - End----//
 

				// fianance / Payment Report 
				if($active_tab == 'fianance_report')
				{
					$active_tab = isset($_GET['tab1'])?$_GET['tab1']:'fees_payment'; 
					?>
					<!-- tabing start  -->
					<ul class="nav nav-tabs panel_tabs margin_left_1per" role="tablist">
						<li class="<?php if($active_tab=='fees_payment'){?>active<?php }?>">			
							<a href="?page=smgt_report&tab=fianance_report&tab1=fees_payment" class="padding_left_0 tab <?php echo $active_tab == 'fees_payment' ? 'active' : ''; ?>">
							<?php esc_html_e('Fees Payment Report', 'school-mgt'); ?></a> 
						</li>
						<li class="<?php if($active_tab=='income_payment'){?>active<?php }?>">			
							<a href="?page=smgt_report&tab=fianance_report&tab1=income_payment" class="padding_left_0 tab <?php echo $active_tab == 'income_payment' ? 'active' : ''; ?>">
							<?php esc_html_e('Income Report', 'school-mgt'); ?></a> 
						</li>
						<li class="<?php if($active_tab=='expense_payment'){?>active<?php }?>">			
							<a href="?page=smgt_report&tab=fianance_report&tab1=expense_payment" class="padding_left_0 tab <?php echo $active_tab == 'expense_payment' ? 'active' : ''; ?>">
							<?php esc_html_e('Expense Report', 'school-mgt'); ?></a> 
						</li>
						<li class="<?php if($active_tab=='income_expense_payment'){?>active<?php }?>">			
							<a href="?page=smgt_report&tab=fianance_report&tab1=income_expense_payment" class="padding_left_0 tab <?php echo $active_tab == 'income_expense_payment' ? 'active' : ''; ?>">
							<?php esc_html_e('Income-Expense Report', 'school-mgt'); ?></a> 
						</li>
					</ul>	  
					<!-- tabing end  -->
					<div class="clearfix panel-body">
						<?php 
						if($active_tab == 'fees_payment')
						{ 				
							require_once SMS_PLUGIN_DIR.'/admin/includes/report/fees_payment.php';
						} 
						if($active_tab == 'income_payment')
						{ 				
							require_once SMS_PLUGIN_DIR.'/admin/includes/report/income_payment.php';
						} 
						if($active_tab == 'expense_payment')
						{ 				
							require_once SMS_PLUGIN_DIR.'/admin/includes/report/expense_payment.php';
						} 
						if($active_tab == 'income_expense_payment')
						{ 				
							require_once SMS_PLUGIN_DIR.'/admin/includes/report/income_expense.php';
						} 
					
						?>
					</div>
					<div id="chart_div" class="chart_div">
					<?php
				}
				// Fees Payment Report  

				// Examinations Report 
				if($active_tab == 'examinations_report')
				{ 
					$active_tab = isset($_GET['tab1'])?$_GET['tab1']:'exam_result_report'; 
					?>
					<!-- tabing start  -->
					<ul class="nav nav-tabs panel_tabs margin_left_1per" role="tablist">
						<li class="<?php if($active_tab=='exam_result_report'){?>active<?php }?>">
							<a href="?page=smgt_report&tab=examinations_report&tab1=exam_result_report" class="padding_left_0 tab <?php echo $active_tab == 'exam_result_report' ? 'active' : ''; ?>">
							<?php esc_html_e('Result', 'school-mgt'); ?></a> 
						</li> 

					</ul>	  
					<!-- tabing end  -->
					<div class="clearfix panel-body">
						<?php 
						if($active_tab == 'exam_result_report')
						{ 				
							require_once SMS_PLUGIN_DIR.'/admin/includes/report/exam_result_report.php';
						}	 
						?>
					</div>
					<div id="chart_div" class="chart_div">
					<?php

				}

				// Library_report Report 
				if($active_tab == 'library_report')
				{ 
					$active_tab = isset($_GET['tab1'])?$_GET['tab1']:'student_book_issue_report'; 
   					?>
					<!-- tabing start  -->
					<ul class="nav nav-tabs panel_tabs margin_left_1per" role="tablist">
						<li class="<?php if($active_tab=='student_book_issue_report'){?>active<?php }?>">			
							<a href="?page=smgt_report&tab=library_report&tab1=student_book_issue_report" class="padding_left_0 tab <?php echo $active_tab == 'student_book_issue_report' ? 'active' : ''; ?>">
							<?php esc_html_e('Book Issue Report', 'school-mgt'); ?></a> 
						</li>
					</ul>
					<div class="clearfix panel-body">
						<?php 	
						if($active_tab == 'student_book_issue_report')
						{ 				
							require_once SMS_PLUGIN_DIR.'/admin/includes/report/student_book_issue_report.php';
						} 
						?>
					</div>
					<?php

				}

				if($active_tab == 'audit_log_report')
				{
					?>
					<div class="clearfix panel-body">
						<?php 
						require_once SMS_PLUGIN_DIR.'/admin/includes/report/audit_log.php';
						?>
					</div>
					<?php
				}
				if($active_tab == 'user_log_report')
				{
					?>
					<div class="clearfix panel-body">
						<?php 
						require_once SMS_PLUGIN_DIR.'/admin/includes/report/user_log.php';
						?>
					</div>
					<?php
				}
				?>
 			</div><!-- penal body --->
 		</div><!-- penal White --->
 	</div>
</div><!-- penal Inner --->