<?php
$active_tab = isset($_GET['tab2'])?$_GET['tab2']:'income_graph_payment'; 
$role=mj_smgt_get_roles(get_current_user_id());
?>
<ul class="nav nav-tabs panel_tabs margin_left_1per" role="tablist">
    <li class="<?php if($active_tab=='income_graph_payment'){?>active<?php }?>">			
        <a href="<?php if($role == 'administrator'){ echo "?page=smgt_report"; }else{ echo "?dashboard=user&page=report"; }?>&tab=fianance_report&tab1=income_payment&tab2=income_graph_payment" class="padding_left_0 tab <?php echo $active_tab == 'income_graph_payment' ? 'active' : ''; ?>">
        <?php esc_html_e('Graph', 'school-mgt'); ?></a> 
    </li>
    <li class="<?php if($active_tab=='income_datatable'){?>active<?php }?>">
        <a href="<?php if($role == 'administrator'){ echo "?page=smgt_report"; }else{ echo "?dashboard=user&page=report"; }?>&tab=fianance_report&tab1=income_payment&tab2=income_datatable" class="padding_left_0 tab <?php echo $active_tab == 'income_datatable' ? 'active' : ''; ?>">
        <?php esc_html_e('DataTable', 'school-mgt'); ?></a> 
    </li>
</ul>
<?php
if($active_tab == "income_graph_payment")
{
    ?>
    <div class="panel-body clearfix margin_top_20px padding_top_15px_res">
        <?php	
        $month =array('1'=>esc_html__('Jan','apartment_mgt'),'2'=>esc_html__('Feb','apartment_mgt'),'3'=>esc_html__('Mar','apartment_mgt'),'4'=>esc_html__('Apr','apartment_mgt'),'5'=>esc_html__('May','apartment_mgt'),'6'=>esc_html__('Jun','apartment_mgt'),'7'=>esc_html__('Jul','apartment_mgt'),'8'=>esc_html__('Aug','apartment_mgt'),'9'=>esc_html__('Sep','apartment_mgt'),'10'=>esc_html__('Oct','apartment_mgt'),'11'=>esc_html__('Nov','apartment_mgt'),'12'=>esc_html__('Dec','apartment_mgt'),);
    
        $year =isset($_POST['year'])?$_POST['year']:date('Y');
    
        $chart_array = array();
       
        array_push($chart_array, array(esc_html__('Month','apartment_mgt'),esc_html__('Income','apartment_mgt')));
        $sumArray = array(); 
        foreach($month as $key=>$value)
        {
            global $wpdb;
            $table_name = $wpdb->prefix."smgt_income_expense";
            $q = "SELECT * FROM $table_name WHERE YEAR(income_create_date) = $year AND MONTH(income_create_date) = $key and invoice_type='income'";
            $result=$wpdb->get_results($q);		
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

            $income_array[] = $income_amount;
            array_push($chart_array, array($value,$income_amount));
        }
        $new_array = json_encode($chart_array);
        ?>
       <script type="text/javascript" src="<?php echo SMS_PLUGIN_URL.'/assets/js/chart_loder.js'; ?>"></script>
		<script type="text/javascript">
			google.charts.load('current', {'packages':['bar']});
			google.charts.setOnLoadCallback(drawChart);

			function drawChart() {
				var data = google.visualization.arrayToDataTable(<?php echo $new_array; ?>);

				var options = {
				
					bars: 'vertical', // Required for Material Bar Charts.
					colors: ['#58c058'],
					
				};
			
				var chart = new google.charts.Bar(document.getElementById('barchart_material'));

				chart.draw(data, google.charts.Bar.convertOptions(options));
			}
		</script>
		<div id="barchart_material" style="width:100%;height: 430px; padding:20px;"></div>
    </div>
    <?php
}
if($active_tab == "income_datatable")
{
    ?>
    <div class="panel-body clearfix margin_top_20px padding_top_15px_res"> <!------  penal body  -------->
        <div class="panel-body clearfix">
            <form method="post" id="student_income_payment">  
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
                            <input type="submit" name="income_payment" Value="<?php esc_attr_e('Go','school-mgt');?>"  class="btn btn-info save_btn"/>
                        </div>
                    </div>
                </div>
            </form> 
        </div>	
        <?php
        if(isset($_REQUEST['income_payment']))
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
        }
        else
        {
            $start_date = date('Y-m-d');
            $end_date= date('Y-m-d');
        }
        global $wpdb;
        $table_income=$wpdb->prefix.'smgt_income_expense';
        $report_6 = $wpdb->get_results("SELECT * FROM $table_income where invoice_type='income' AND income_create_date BETWEEN '$start_date' AND '$end_date'");
        if(!empty($report_6))
        {
            ?>
            <script type="text/javascript">
	            jQuery(document).ready(function($){
                    var table = jQuery('#tble_income').DataTable({
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
                            {"bSortable": true}
                        ],
                        language:<?php echo mj_smgt_datatable_multi_language();?>
                    });
                    $('.btn-place').html(table.buttons().container()); 
                    $('.dataTables_filter input').attr("placeholder", "<?php esc_html_e('Search...', 'school-mgt') ?>");
                });
            </script>
            <div class="panel-body padding_top_15px_res"> <!------  penal body  -------->
                <div class="btn-place"></div>
                <div class="table-responsive"> <!------  table Responsive  -------->
                    <form id="frm-example" name="frm-example" method="post">
                        <table id="tble_income" class="display" cellspacing="0" width="100%">
                            <thead class="<?php echo MJ_smgt_datatable_heder() ?>">
                                <tr>
                                    <th><?php  _e( 'Image', 'school-mgt' ) ;?></th>
                                    <th> <?php esc_attr_e( 'Roll No.', 'school-mgt' ) ;?></th>
                                    <th> <?php esc_attr_e( 'Student Name', 'school-mgt' ) ;?></th>
                                    <th> <?php esc_attr_e( 'Amount', 'school-mgt' ) ;?></th>
                                    <th> <?php esc_attr_e( 'Date', 'school-mgt' ) ;?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                global $wpdb;
                                $table_income=$wpdb->prefix.'smgt_income_expense';
                                $report_6 = $wpdb->get_results("SELECT * FROM $table_income where invoice_type='income' AND income_create_date BETWEEN '$start_date' AND '$end_date'");
                                if(!empty($report_6))
                                {
                                    $i=0;
                                    foreach($report_6 as $result)
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
                                        $all_entry=json_decode($result->entry);
                                        $total_amount=0;
                                        foreach($all_entry as $entry)
                                        {
                                            $total_amount += $entry->amount;
                                        }						 
                                        ?>
                                        <tr>
                                            <td class="user_image width_50px profile_image_prescription padding_left_0">
                                                <p class="prescription_tag padding_15px margin_bottom_0px <?php echo $color_class; ?>">	
                                                    <img src="<?php echo SMS_PLUGIN_URL."/assets/images/dashboard_icon/Icons/White_icons/Payment.png"?>" alt="" class="massage_image center margin_top_3px">
                                                </p>
                                            </td>
                                            <td class="patient"><?php echo get_user_meta($result->supplier_name, 'roll_id',true);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Roll No.','school-mgt');?>"></i></td>
                                            <td class="patient_name"><?php echo mj_smgt_get_user_name_byid($result->supplier_name);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Student Name','school-mgt');?>"></i></td>
                                            <td class="income_amount"><?php echo "<span> ". mj_smgt_get_currency_symbol() ." </span>" . $total_amount;?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Amount','school-mgt');?>"></i></td>
                                            <td class="status"><?php echo mj_smgt_getdate_in_input_box($result->income_create_date);?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Create Date','school-mgt');?>"></i></td>
                                        </tr>
                                        <?php 
                                        $i++;
                                    } 
                                } ?>     
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
    </div> <!------  penal body  -------->
    <?php
}