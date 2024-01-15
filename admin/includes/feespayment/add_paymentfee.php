<?php 	
if($active_tab == 'addpaymentfee')
{
    $fees_pay_id=0;
    if(isset($_REQUEST['fees_pay_id']))
        $fees_pay_id=$_REQUEST['fees_pay_id'];
    $edit=0;
    if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
    {
        $edit=1;
        $result = $obj_feespayment->mj_smgt_get_single_fee_mj_smgt_payment($fees_pay_id);
    }
    ?>
    <div class="panel-body margin_top_20px padding_top_15px_res"><!----- penal Body --------->
        <form name="expense_form" action="" method="post" class="form-horizontal" id="expense_form">
            <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
            <input type="hidden" name="action" value="<?php echo $action;?>">
            <input type="hidden" name="fees_pay_id" value="<?php echo $fees_pay_id;?>">
            <input type="hidden" name="invoice_type" value="expense">
            <div class="form-body user_form">
				<div class="row">
                    <div class="col-md-6 input">
						<label class="ml-1 custom-top-label top" for="hmgt_contry"><?php esc_html_e('Class','school-mgt');?><span class="require-field">*</span></label>
						<?php if($edit){ $classval=$result->class_id; }else{$classval='';}?>
                        <select name="class_id" id="class_list" class="form-control validate[required] load_fees max_width_100">
                            <?php 
                            if($addparent)
                            { 
                                $classdata=mj_smgt_get_class_by_id($student->class_name);
                                ?>
                                <option value="<?php echo $student->class_name;?>"><?php echo $classdata->class_name;?></option>
                                <?php 
                            }?>
                            <option value=""><?php esc_attr_e('Select Class','school-mgt');?></option>
                            <?php
                            foreach(mj_smgt_get_allclass() as $classdata)
                            { ?>
                                <option value="<?php echo $classdata['class_id'];?>"
                                    <?php selected($classval, $classdata['class_id']);  ?>><?php echo $classdata['class_name'];?>
                                </option>
                                <?php 
                            }?>
                        </select>                         
					</div>
                    <div class="col-md-6 input class_section_hide">
						<label class="ml-1 custom-top-label top" for="hmgt_contry"><?php esc_html_e('Class Section','school-mgt');?></label>
                        <?php if($edit){ $sectionval=$result->section_id; }elseif(isset($_POST['class_section'])){$sectionval=$_POST['class_section'];}else{$sectionval='';}?>
                        <select name="class_section" class="form-control max_width_100" id="class_section">
                            <option value=""><?php esc_attr_e('Select Class Section','school-mgt');?></option>
                            <?php
                                    if($edit){
                                        foreach(mj_smgt_get_class_sections($result->class_id) as $sectiondata)
                                        {  ?>
                            <option value="<?php echo $sectiondata->id;?>" <?php selected($sectionval,$sectiondata->id);  ?>>
                                <?php echo $sectiondata->section_name;?></option>
                            <?php } 
                                    }?>
                        </select>                      
					</div>
                    <?php
                    if($edit)
                    {
                        ?>
                        <div class="col-md-6 input class_section_hide">
                            <label class="ml-1 custom-top-label top" for="hmgt_contry"><?php esc_html_e('Student','school-mgt');?></label>
                            <?php if($edit){ $classval=$result->class_id; }else{$classval='';}?>
                            <select name="student_id" id="student_list" class="form-control validate[required] max_width_100">
                                <option value=""><?php esc_attr_e('Select student','school-mgt');?></option>
                                <?php 
                                    if($edit)
                                    {
                                        echo '<option value="'.$result->student_id.'" '.selected($result->student_id,$result->student_id).'>'.mj_smgt_get_user_name_byid($result->student_id).'</option>';
                                    }
                                ?>
                            </select>                    
                        </div>
                        <?php
                    }
                    else
                    {
                        ?>
                        <div class="col-md-6 input class_section_hide">
                            <label class="ml-1 custom-top-label top" for="hmgt_contry"><?php esc_html_e('Student','school-mgt');?></label>
                            <?php if($edit){ $classval=$result->class_id; }else{$classval='';}?>
                            <select name="student_id" id="student_list" class="form-control max_width_100">
                                <option value=""><?php esc_attr_e('Select Student','school-mgt');?></option>
                                <?php 
                                if($edit)
                                {
                                    echo '<option value="'.$result->student_id.'" '.selected($result->student_id,$result->student_id).'>'.mj_smgt_get_user_name_byid($result->student_id).'</option>';
                                }
                                ?>
                            </select>   
                            <p>
                                <i>
                                    <?php 
                                    esc_attr_e('Note : Please select a student to generate invoice for the single student or it will create the invoice for all students for selected class and section.','school-mgt');
                                    ?>
                                </i>
                            </p>                
                        </div>
                        <?php
                    }
                    ?>
                    <?php wp_nonce_field( 'save_payment_fees_admin_nonce' ); ?>
                   
                    <div class="col-md-6 padding_bottom_15px_res rtl_margin_top_15px">
                        <div class="col-sm-12 multiselect_validation_class smgt_multiple_select rtl_padding_left_right_0px">
                            <select name="fees_id[]" multiple="multiple" id="fees_data" class="form-control validate[required] max_width_100">
                                <?php 	
                                if($edit)
                                {
                                    $fees_id=explode(',',$result->fees_id);
                                    foreach($fees_id as $id)
                                    {
                                        if(mj_smgt_get_fees_term_name($id) !== " ")
                                                {
                                        echo '<option value="'.$id.'" '.selected($id,$id).'>'.mj_smgt_get_fees_term_name($id).'</option>';
                                    }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
						<div class="form-group input">
							<div class="col-md-12 form-control">
                                <input id="fees_amount" class="form-control validate[required,min[0],maxSize[8]] text-input" type="text" value="<?php if($edit){ echo $result->total_amount;}elseif(isset($_POST['fees_amount'])) { echo $_POST['fees_amount']; }else{ echo "0"; } ?>" name="fees_amount" readonly>
								<label for="userinput1" class=""><?php esc_html_e('Amount','school-mgt');?>(<?php echo mj_smgt_get_currency_symbol();?>)<span class="required">*</span></label>
							</div>
						</div>
					</div>
                    <div class="col-md-6 note_text_notice">
						<div class="form-group input">
							<div class="col-md-12 note_border margin_bottom_15px_res">
								<div class="form-field">
                                    <textarea name="description" class="textarea_height_47px form-control validate[custom[address_description_validation]]" maxlength="150"> <?php if($edit){ echo $result->description;}elseif(isset($_POST['description'])) echo $_POST['description'];?> </textarea>
									<span class="txt-title-label"></span>
									<label class="text-area address active"><?php esc_attr_e('Description','school-mgt');?></label>
								</div>
							</div>
						</div>
					</div>
                    <div class="col-md-6 input">
						<label class="ml-1 custom-top-label top" for="hmgt_contry"><?php esc_html_e('Starting Year','school-mgt');?><span class="require-field">*</span></label>
                        <select name="start_year" id="start_year" class="form-control validate[required]">
                            <option value=""><?php esc_attr_e('Starting year','school-mgt');?></option>
                            <?php 
                            $start_year = 0;
                            $x = 00;
                            if($edit)
                            $start_year = $result->start_year;
                            for($i=2000 ;$i<2030;$i++)
                            {
                                echo '<option value="'.$i.'" '.selected($start_year,$i).' id="'.$x.'">'.$i.'</option>';
                                $x++;
                            } ?>
                        </select>                        
					</div>
                    <div class="col-md-6 input error_msg_left_margin">
						<label class="ml-1 custom-top-label top" for="hmgt_contry"><?php esc_html_e('Ending Year','school-mgt');?><span class="require-field">*</span></label>
                        <select name="end_year" id="end_year" class="form-control validate[required]">
                            <option value=""><?php esc_attr_e('Ending year','school-mgt');?></option>
                            <?php 
                            $end_year = '';
                            if($edit)
                                $end_year = $result->end_year;
                                for($i=00 ;$i<31;$i++)
                                {
                                    echo '<option value="'.$i.'" '.selected($end_year,$i).'>'.$i.'</option>';
                                }
                            ?>
                        </select>                      
					</div>
                    <div class="col-md-6 padding_bottom_15px_res rtl_margin_top_15px">
                        <div class="form-group">
                            <div class="col-md-12 form-control input_height_50px">
                                <div class="row padding_radio">
                                    <div class="input-group input_checkbox">
                                        <label class="custom-top-label"><?php esc_html_e('Send Email To Parents','school-mgt');?></label>													
                                        <div class="checkbox checkbox_lebal_padding_8px">
                                            <label>
                                            <input type="checkbox" class="margin_right_checkbox margin_right_5px_checkbox margin_right_checkbox_css" name="smgt_enable_feesalert_mail" value="1" <?php echo checked(get_option('smgt_enable_feesalert_mail'),'yes');?> />&nbsp;&nbsp;<?php esc_html_e('Enable','school-mgt');?>
                                            </label>
                                        </div>
                                    </div>
                                </div>												
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 rtl_margin_top_15px">
                        <div class="form-group">
                            <div class="col-md-12 form-control input_height_50px">
                                <div class="row padding_radio">
                                    <div class="input-group input_checkbox">
                                        <label class="custom-top-label"><?php esc_html_e('Send SMS To Parents','school-mgt');?></label>													
                                        <div class="checkbox checkbox_lebal_padding_8px">
                                            <label>
                                                <input type="checkbox" class="margin_right_checkbox margin_right_5px_checkbox margin_right_checkbox_css" name="smgt_enable_feesalert_sms"  value="1" <?php echo checked(get_option('smgt_enable_feesalert_sms'),'yes');?>/>&nbsp;&nbsp;<?php esc_html_e('Enable','school-mgt');?>
                                            </label>
                                        </div>
                                    </div>
                                </div>												
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-body user_form margin_top_20px padding_top_15px_res">
				<div class="row">
                    <div class="col-sm-6">
                        <input type="submit" value="<?php if($edit){ esc_attr_e('Save Invoice','school-mgt'); }else{ esc_attr_e('Create Invoice','school-mgt');}?>" name="save_feetype_payment" class="btn btn-success save_btn" />
                    </div>
                </div>
            </div>
        </form>
    </div><!----- penal Body --------->
    <?php  
} 
?>