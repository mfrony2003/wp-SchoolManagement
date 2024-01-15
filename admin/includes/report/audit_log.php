<div class="panel-body clearfix margin_top_20px padding_top_15px_res"> <!------  penal body  -------->
    <div class="panel-body clearfix">
        <form method="post" id="student_attendance">  
            <div class="form-body user_form">
                <div class="row">
                    <div class="col-md-6 mb-6 input">
                        <label class="ml-1 custom-top-label top" for="class_id"><?php esc_attr_e('Date Type','school-mgt');?><span class="require-field">*</span></label>			
                        <select class="line_height_30px form-control date_type validate[required]" name="date_type" autocomplete="off">
                          
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
                    <div class="col-md-6 mb-6 input">
                        <label class="ml-1 custom-top-label top" for="class_id"><?php esc_attr_e('Action','school-mgt');?></label>			
                        <select class="line_height_30px form-control date_action_filter" name="date_action" autocomplete="off">
                          
                            <option value="all">All</option>
                            <option value="edit">Edit Action</option>
                            <option value="insert">Insert Action</option>
                            <option value="delete">Delete Action</option>
                        </select>
                    </div>
                    <div id="date_type_div" class="date_type_div_none col-md-6 mb-2"></div>	
                    <div class="col-md-3 mb-2">
                        <input type="submit" name="audit_report" Value="<?php esc_attr_e('Go','school-mgt');?>"  class="btn btn-info save_btn"/>
                    </div>
                </div>
            </div>
        </form> 
    </div>	

    <?php
    if(isset($_REQUEST['audit_report']))
    {
        $date_type = $_POST['date_type'];
        $date_action = $_POST['date_action'];
    
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
        $date_action = "all";
        $start_date = date('Y-m-d');
        $end_date= date('Y-m-d');
    }

    if($date_action == "all" || $date_action == "")
    {
        global $wpdb;
        $table_audit_log=$wpdb->prefix.'smgt_audit_log';
        $report_6 = $wpdb->get_results("SELECT * FROM $table_audit_log where created_at BETWEEN '$start_date' AND '$end_date'");
    }
    else
    {
        global $wpdb;
        $table_audit_log=$wpdb->prefix.'smgt_audit_log';
        $report_6 = $wpdb->get_results("SELECT * FROM $table_audit_log where action='$date_action' AND created_at BETWEEN '$start_date' AND '$end_date'");
    }

    if(!empty($report_6))
    {
        ?>
          <script type="text/javascript">
            jQuery(document).ready(function($){
                var table = jQuery('#tble_audit_log_').DataTable({
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
                    <table id="tble_audit_log_" class="display" cellspacing="0" width="100%">
                        <thead class="<?php echo MJ_smgt_datatable_heder() ?>">
                            <tr>
                                <th> <?php esc_attr_e( 'Message', 'school-mgt' ) ;?></th>
                                <th> <?php esc_attr_e( 'User Name', 'school-mgt' ) ;?></th>
                                <th> <?php esc_attr_e( 'IP Address', 'school-mgt' ) ;?></th>
                                <th> <?php esc_attr_e( 'Action', 'school-mgt' ) ;?></th>
                                <th> <?php esc_attr_e( 'Date & Time', 'school-mgt' ) ;?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach($report_6 as $result)
                            {	
                                ?>
                                <tr>
                                    <td class="patient"><?php if(!empty($result->audit_action)){ echo $result->audit_action; }else{ echo "N/A"; } ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Message','school-mgt');?>"></i></td>
                                    <td class="patient_name"><?php if(!empty($result->user_id)){ echo mj_smgt_get_display_name($result->user_id); }else{ echo "N/A"; } ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('User Name','school-mgt');?>"></i></td>
                                    <td class="income_amount"><?php if(!empty($result->ip_address)){ echo $result->ip_address; }else{ echo "N/A"; } ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('IP Address','school-mgt');?>"></i></td>
                                    <td class="status text_transform_capitalize"><?php if(!empty($result->action)){ echo $result->action; }else{ echo "N/A"; } ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Action','school-mgt');?>"></i></td>
                                    <td class="status"><?php if(!empty($result->date_time)){ echo $result->date_time; }else{ echo "N/A"; } ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Date & Time','school-mgt');?>"></i></td>
                                </tr>
                                <?php 
                            } 
                            ?>     
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