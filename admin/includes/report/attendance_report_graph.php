<div class="panel-body clearfix margin_top_20px padding_top_15px_res">
	<?php
	global $wpdb;
	$table_attendance = $wpdb->prefix . 'attendence';
	$table_class = $wpdb->prefix . 'smgt_class';

	if(isset($_REQUEST['view_attendance']))
	{
	$sdate = $_REQUEST['sdate'];
	$edate = $_REQUEST['edate'];
	}
	else
	{
		$sdate = date('Y-m-d',strtotime('first day of this month'));
		$edate = date('Y-m-d',strtotime('last day of this month'));
	}

	$report_2 =$wpdb->get_results("SELECT  at.class_id, 
	SUM(case when `status` ='Present' then 1 else 0 end) as Present, 
	SUM(case when `status` ='Absent' then 1 else 0 end) as Absent
	from $table_attendance as at,$table_class as cl where `attendence_date` BETWEEN '$sdate' AND '$edate' AND at.class_id = cl.class_id AND at.role_name = 'student' GROUP BY at.class_id") ;

	$chart_array = array();
	$chart_array[] = array(esc_attr__('Class', 'school-mgt'), esc_attr__('Present', 'school-mgt'), esc_attr__('Absent', 'school-mgt'));
	if (!empty($report_2))
	{
		foreach ($report_2 as $result) 
		{

			$class_id = mj_smgt_get_class_name($result->class_id);
			$chart_array[] = array("$class_id", (int)$result->Present, (int)$result->Absent);
		}
	}
	$options = array(
		'title' => esc_attr__('Current Month Attendance Report', 'school-mgt'),
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
	if (!empty($report_2)) 
	{
		$chart = $GoogleCharts->load('column', 'chart_div_last_month')->get($chart_array, $options);
	}
	else
	{
		?>
		<div class="calendar-event-new"> 
			<img class="no_data_img" src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >
		</div>	
		<?php
	}

	if (isset($report_2) && count($report_2) > 0) 
	{
		?>
		<div id="chart_div_last_month" class="w-100 h-500-px"></div>

		<!-- Javascript -->
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		<script type="text/javascript">
			<?php echo $chart; ?>
		</script>
	<?php
	}
	?>
</div>