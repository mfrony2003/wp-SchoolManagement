<?php
$active_tab = isset($_GET['tab2'])?$_GET['tab2']:'income_expense_graph'; 
$role=mj_smgt_get_roles(get_current_user_id());
?>
<ul class="nav nav-tabs panel_tabs margin_left_1per" role="tablist">
    <li class="<?php if($active_tab=='income_expense_graph'){?>active<?php }?>">			
        <a href="<?php if($role == 'administrator'){ echo "?page=smgt_report"; }else{ echo "?dashboard=user&page=report"; }?>&tab=fianance_report&tab1=income_expense_payment&tab2=income_expense_graph" class="padding_left_0 tab <?php echo $active_tab == 'income_expense_graph' ? 'active' : ''; ?>">
        <?php esc_html_e('Graph', 'school-mgt'); ?></a> 
    </li>
    <li class="<?php if($active_tab=='income_expense_datatable'){?>active<?php }?>">
        <a href="<?php if($role == 'administrator'){ echo "?page=smgt_report"; }else{ echo "?dashboard=user&page=report"; }?>&tab=fianance_report&tab1=income_expense_payment&tab2=income_expense_datatable" class="padding_left_0 tab <?php echo $active_tab == 'income_expense_datatable' ? 'active' : ''; ?>">
        <?php esc_html_e('DataTable', 'school-mgt'); ?></a> 
    </li>
</ul>
<?php

if($active_tab == 'income_expense_graph')
{

	$current_year = Date("Y");
	$month =array('1'=>esc_html__('Jan','apartment_mgt'),'2'=>esc_html__('Feb','apartment_mgt'),'3'=>esc_html__('Mar','apartment_mgt'),'4'=>esc_html__('Apr','apartment_mgt'),'5'=>esc_html__('May','apartment_mgt'),'6'=>esc_html__('Jun','apartment_mgt'),'7'=>esc_html__('Jul','apartment_mgt'),'8'=>esc_html__('Aug','apartment_mgt'),'9'=>esc_html__('Sep','apartment_mgt'),'10'=>esc_html__('Oct','apartment_mgt'),'11'=>esc_html__('Nov','apartment_mgt'),'12'=>esc_html__('Dec','apartment_mgt'),);
	$result = array();
	$dataPoints_2 = array();
	//array_push($dataPoints_2, array('Month','Income','Expense'));
	array_push($dataPoints_2, array(esc_html__('Month','apartment_mgt'),esc_html__('Income','apartment_mgt'),esc_html__('Expense','apartment_mgt'),esc_html__('Net Profite','apartment_mgt')));
	$dataPoints_1 = array();
	$expense_array = array();
	$currency_symbol = MJ_smgt_get_currency_symbol(get_option( 'smgt_currency_code' ));
	foreach($month as $key=>$value)
	{
		global $wpdb;
		$table_name = $wpdb->prefix."smgt_income_expense";

		$q = "SELECT * FROM $table_name WHERE YEAR(income_create_date) = $current_year AND MONTH(income_create_date) = $key and invoice_type='income'";

		$q1 = "SELECT * FROM $table_name WHERE YEAR(income_create_date) = $current_year AND MONTH(income_create_date) = $key and invoice_type='expense'";

		$result=$wpdb->get_results($q);
		$result1=$wpdb->get_results($q1);
       
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

        $income_yearly_amount = 0;
        foreach($result as $income_entry)
		{
            $all_entry=json_decode($income_entry->entry);
            $amount=0;
            foreach($all_entry as $entry)
            {
                $amount+=$entry->amount;
            }
		    $income_yearly_amount += $amount;
		}

		if($income_yearly_amount == 0)
		{
			$income_amount = null;
		}
		else
		{
			$income_amount = $income_yearly_amount;
		}

		$expense_array[] = $expense_amount;
		$income_array[] = $income_amount;
        $net_profit_array = $income_amount - $expense_amount;
		array_push($dataPoints_2, array($value,$income_amount,$expense_amount,$net_profit_array));
		
	}

	$new_array = json_encode($dataPoints_2);
 
	if(!empty($income_array))
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
					colors: ['#104B73', '#FF9054', '#70ad46'],
                    
				};
			
				var chart = new google.charts.Bar(document.getElementById('barchart_material'));

				chart.draw(data, google.charts.Bar.convertOptions(options));
			}
		</script>
		<div id="barchart_material" style="width:100%;height: 430px; padding:20px;"></div>
		<?php
	}
	else
	{
		?>
		<div class="calendar-event-new"> 
			<img class="no_data_img" src="<?php echo GMS_PLUGIN_URL."/assets/images/dashboard_icon/no_data_img.png"?>" >
		</div>
		<?php	
	}
}

if($active_tab == 'income_expense_datatable')
{
    ?>
    <div class="panel-body clearfix margin_top_20px padding_top_15px_res">
        <div class="panel-body clearfix">
            <form method="post" id="student_income_expence_payment">  
                <div class="form-body user_form">
                    <div class="row">
                        <div class="col-md-3 mb-3 input">
                            <label class="ml-1 custom-top-label top" for="class_id"><?php esc_attr_e('Date Type','school-mgt');?><span class="require-field">*</span></label>			
                            <select class="line_height_30px form-control date_type validate[required]" name="date_type" autocomplete="off">
                                <option value="">Select</option>
                                <option value="today">Today</option>
                                <option value="this_week">This Week</option>
                                <option value="last_week">Last Week</option>
                                <option value="this_month">This Month</option>
                                <option value="last_month">Last Month</option>
                                <option value="last_3_month">Last 3 Months</option>
                                <option value="last_6_month">Last 6 Months</option>
                                <option value="last_12_month">Last 12 Months</option>
                                <option value="this_year">This Year</option>
                                <option value="last_year">Last Year</option>
                                <option value="period">Period</option>
                            </select>
                        </div>
                        <div id="date_type_div" class="date_type_div_none row col-md-6 mb-2"></div>	
                        <div class="col-md-3 mb-2">
                            <input type="submit" name="income_expense_report" Value="<?php esc_attr_e('Go','school-mgt');?>"  class="btn btn-info save_btn"/>
                        </div>
                    </div>
                </div>
            </form> 
        </div>	
        <?php
        if(isset($_REQUEST['income_expense_report']))
        {
            $date_type = $_POST['date_type'];
            if($date_type=="period")
            {
                $start_date = $_REQUEST['start_date'];
                $end_date = $_REQUEST['end_date'];
            }
            else
            {
                $result =  mj_smgt_all_date_type_value($date_type);
        
                $response =  json_decode($result);
                $start_date = $response[0];
                $end_date = $response[1];
            }

            $income_data = MJ_get_total_income($start_date,$end_date);
            $expense_data = MJ_get_total_expense($start_date,$end_date);

            //----------- Expense Record Sum ------------//
            $expense_yearly_amount = 0;
            foreach($expense_data as $expense_entry)
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
                $expense_amount = "$expense_yearly_amount";
            }
            //----------- Expense Record Sum ------------//


            //----------- Income Record Sum -------------//
            $income_yearly_amount = 0;
            foreach($income_data as $income_entry)
            {
                $all_entry=json_decode($income_entry->entry);
                $amount=0;
                foreach($all_entry as $entry)
                {
                    $amount+=$entry->amount;
                }
                $income_yearly_amount += $amount;
            }
    
            if($income_yearly_amount == 0)
            {
                $income_amount = null;
            }
            else
            {
                $income_amount = "$income_yearly_amount";
            }
            //----------- Income Record Sum -------------//

        }
        else
        {
            $start_date = date('Y-m-d');
            $end_date= date('Y-m-d');
            $income_data = MJ_get_total_income($start_date,$end_date);
            $expense_data = MJ_get_total_expense($start_date,$end_date);

           //----------- Expense Record Sum ------------//
           $expense_yearly_amount = 0;
           foreach($expense_data as $expense_entry)
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
               $expense_amount = "$expense_yearly_amount";
           }
           //----------- Expense Record Sum ------------//

            //----------- Income Record Sum -------------//
            $income_yearly_amount = 0;
            foreach($income_data as $income_entry)
            {
                $all_entry=json_decode($income_entry->entry);
                $amount=0;
                foreach($all_entry as $entry)
                {
                    $amount+=$entry->amount;
                }
                $income_yearly_amount += $amount;
            }
    
            if($income_yearly_amount == 0)
            {
                $income_amount = null;
            }
            else
            {
                $income_amount = "$income_yearly_amount";
            }
            //----------- Income Record Sum -------------//
        }

        if(!empty($expense_amount) || !empty($income_amount))
        {
            ?>
            <script src="">
                
            </script>
            <div class="panel-body padding_top_15px_res"> <!------  penal body  -------->
                <div class="btn-place"></div>
                <div class="table-responsive"> <!------  table Responsive  -------->
                    <form id="frm-example1" name="frm-example1" method="post">
                        <table id="table_income_expense" class="display" cellspacing="0" width="100%">
                            <thead class="<?php echo MJ_smgt_datatable_heder() ?>">
                                <tr>
                                    <th><?php  _e( 'Image', 'school-mgt' ) ;?></th>
                                    <th> <?php esc_attr_e( 'Total Income', 'school-mgt' ) ;?></th>
                                    <th> <?php esc_attr_e( 'Total Expense', 'school-mgt' ) ;?></th>
                                    <th> <?php esc_attr_e( 'Net Profit', 'school-mgt' ) ;?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $net_profit = $income_amount - $expense_amount;
                                ?>
                                <tr>
                                    <td class="user_image width_50px profile_image_prescription padding_left_0">
                                        <p class="prescription_tag padding_15px margin_bottom_0px smgt_class_color0">	
                                            <img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Payment.png"?>" alt="" class="massage_image center margin_top_3px">
                                        </p>
                                    </td>
                                    <td class="patient"><?php if(!empty($income_amount)){ echo mj_smgt_get_currency_symbol().' '.$income_amount; }else{ echo mj_smgt_get_currency_symbol()." 0"; } ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Total Income','school-mgt');?>"></i></td>
                                    <td class="patient_name"><?php if(!empty($expense_amount)){ echo mj_smgt_get_currency_symbol().' '.$expense_amount; }else{ echo mj_smgt_get_currency_symbol()." 0"; } ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Total Expense','school-mgt');?>"></i></td>
                                    <td class="income_amount" style="<?php if($net_profit < 0){ echo "color: red !important"; } ?>"><?php if(!empty($net_profit)){ echo mj_smgt_get_currency_symbol().' '.$net_profit; }else{ echo mj_smgt_get_currency_symbol()." 0"; } ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Net Profit/Loss','school-mgt');?>"></i></td>
                                </tr>
                                  
                            </tbody>        
                        </table>
                    </form>
                </div> <!------  table responsive  -------->
            </div> <!------  penal body  -------->
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
    <?php
}