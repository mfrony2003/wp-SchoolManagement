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
                        <select class="line_height_30px form-control" name="role_type" autocomplete="off">
                            <option value="all">All</option>
                            <option value="student"><?php esc_attr_e('Students','school-mgt');?></option>	
                            <option value="teacher"><?php esc_attr_e('Teachers','school-mgt');?></option>	
                            <option value="parent"><?php esc_attr_e('Parents','school-mgt');?></option>	
                            <option value="supportstaff"><?php esc_attr_e('Support Staff','school-mgt');?></option>	
                        </select>
                    </div>
                    <div id="date_type_div" class="date_type_div_none col-md-6 mb-2"></div>	
                    <div class="col-md-3 mb-2">
                        <input type="submit" name="user_log_report" Value="<?php esc_attr_e('Go','school-mgt');?>"  class="btn btn-info save_btn"/>
                    </div>
                </div>
            </div>
        </form> 
    </div>	

    <?php
    if(isset($_REQUEST['user_log_report']))
    {
        $date_type = $_POST['date_type'];
        $role_type = $_POST['role_type'];
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
        $role_type = "all";
        $start_date = date('Y-m-d');
        $end_date= date('Y-m-d');
    }

    if($role_type == "all" || $role_type == "")
    {
        global $wpdb;
        $table_user_log=$wpdb->prefix.'smgt_user_log';
        $report_6 = $wpdb->get_results("SELECT * FROM $table_user_log where created_at BETWEEN '$start_date' AND '$end_date'");
    }
    else
    {
        global $wpdb;
        $table_user_log=$wpdb->prefix.'smgt_user_log';
        $report_6 = $wpdb->get_results("SELECT * FROM $table_user_log where role='$role_type' AND  created_at BETWEEN '$start_date' AND '$end_date'");
    }
   
    if(!empty($report_6))
    {
        ?>
         <script type="text/javascript">
            jQuery(document).ready(function($){
                var table = jQuery('#tble_login_log').DataTable({
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
                    <table id="tble_login_log" class="display" cellspacing="0" width="100%">
                        <thead class="<?php echo MJ_smgt_datatable_heder() ?>">
                            <tr>
                                <th> <?php esc_attr_e( 'User Login', 'school-mgt' ) ;?></th>
                                <th> <?php esc_attr_e( 'User Role', 'school-mgt' ) ;?></th>
                                <th> <?php esc_attr_e( 'Class', 'school-mgt' ) ;?></th>
                                <th> <?php esc_attr_e( 'IP Address', 'school-mgt' ) ;?></th>
                                <th> <?php esc_attr_e( 'Login Time', 'school-mgt' ) ;?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach($report_6 as $result)
                            {	
                                $user_object = get_user_by( "login", $result->user_login );
                               
                                $section = mj_smgt_get_class_sections_name(get_user_meta($user_object->ID,'class_section',true));
                               
                                if($section != ' ')
                                { 
                                    $section_name = '('.$section.')'; 
                                }
                                else
                                {
                                    $section_name = "";
                                }
                                ?>
                                <tr>
                                    <td class="patient"><?php if(!empty($result->user_login)){ echo $result->user_login; }else{ echo "N/A"; } ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('User Login','school-mgt');?>"></i></td>
                                    <td class="patient_name text_transform_capitalize"><?php if(!empty($result->role)){ echo $result->role; }else{ echo "N/A"; } ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('User Role','school-mgt');?>"></i></td>
                                    <td class="status"><?php if($result->role == "student"){ echo mj_smgt_get_class_name(get_user_meta($user_object->ID,'class_name',true)).''.$section_name; }else{ echo "N/A"; } ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Class Name','school-mgt');?>"></i></td>
                                    <td class="income_amount"><?php echo getHostByName(getHostName()); ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('IP Address','school-mgt');?>"></i></td>
                                    <td class="status"><?php if(!empty($result->date_time)){ echo $result->date_time; }else{ echo "N/A"; } ?> <i class="fa fa-info-circle fa_information_bg" data-toggle="tooltip" title="<?php esc_html_e('Login Time','school-mgt');?>"></i></td>
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