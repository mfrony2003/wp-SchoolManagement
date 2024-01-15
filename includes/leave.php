<?php
class SmgtLeave
{	
	public function hrmgt_add_leave($data)
	{		
		
		global $wpdb;
		$table_hrmgt_leave = $wpdb->prefix. 'smgt_leave';
		$leavedata['student_id']=$data['student_id'];
		$leavedata['leave_type']=($data['leave_type']);
		$leavedata['leave_duration']=($data['leave_duration']);
		$leavedata['start_date']=date("Y-m-d", strtotime($data['start_date']));
		if(isset($data['end_date']))
		$leavedata['end_date']=date("Y-m-d", strtotime($data['end_date']));;
		$leavedata['status']=$data['status'];
		$leavedata['reason']= stripslashes($data['reason']);
		$leavedata['created_by']=get_current_user_id();

		if($data['action']=='edit'){
			school_append_audit_log(''.esc_html__('Update Leave Detail','hospital_mgt').'',null,get_current_user_id(),'edit');
			$whereid['id']=$data['leave_id'];
			if($data['leave_duration']!='more_then_day'){
				$leavedata['end_date']='';
			}
			$result=$wpdb->update( $table_hrmgt_leave, $leavedata ,$whereid);
			return $result;
		}
		else
		{
			
			school_append_audit_log(''.esc_html__('Add New Leave Detail','hospital_mgt').'',null,get_current_user_id(),'insert');
			$resultdata=$wpdb->insert( $table_hrmgt_leave, $leavedata );
			
			if($resultdata)
			{
				$arr['{{start_date}}'] = ($_POST['start_date']);
				$arr['{{end_date}}'] = (isset($_POST['end_date'])? $_POST['end_date']:'');
				$arr['{{leave_type}}'] = get_the_title($_POST['leave_type']);
				$arr['{{leave_duration}}'] = str_replace('_',' ',$_POST['leave_duration']);
				$arr['{{reason}}'] = mj_smgt_strip_tags_and_stripslashes($_POST['reason']);
				$arr['{{employee_name}}'] = mj_smgt_get_display_name($_POST['student_id']);
				$arr['{{system_name}}'] = get_option('smgt_school_name');				
				$message = get_option('addleave_email_template');			
				if($data['leave_duration']!='more_then_day'){				
					$message = str_replace("to  {{end_date}}","",$message);
				}


				$replace_message =  stripslashes(mj_smgt_string_replacement($arr,$message));
			
				if($replace_message)
				{
					
					$to[]= mj_smgt_get_emailid_byuser_id($_POST['student_id']);				
					 $emails = get_option('add_leave_emails');
					$emails = explode(',',$emails);
				
					foreach($emails as $email)
					{
						$to[]=$email;
					}						
					$subject = stripslashes(get_option('add_leave_subject'));
					$result =  mj_smgt_send_mail($to,$subject,$replace_message);

				}

				$empdata = get_userdata((int)$data['student_id']);		
				
			}
			
			return $result =$resultdata ;
		}	
	}
	
	public function get_all_leaves()
	{
		global $wpdb;
		$table_hrmgt_leave = $wpdb->prefix. 'smgt_leave';
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_leave");
		return $result;	
	}
	public function get_single_user_leaves($id)
	{
		global $wpdb;				
		$table_hrmgt_leave = $wpdb->prefix. 'smgt_leave';
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_leave WHERE student_id=$id");
		return $result;

	}

	public function get_leave_by_status($status)
	{
	    global $wpdb;				
		$table_hrmgt_leave = $wpdb->prefix. 'smgt_leave';
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_leave WHERE status='$status'");
		return $result;
	}

	public function get_leave_by_date($date)
	{

	    global $wpdb;				
		$table_hrmgt_leave = $wpdb->prefix. 'smgt_leave';
		$result = $wpdb->get_results("SELECT * FROM $table_hrmgt_leave WHERE start_date='$date'");
		return $result;

	}
	public function get_single_user_leaves_for_report($employee_id,$start_date,$end_date)
	{		
		global $wpdb;				
		$table_hrmgt_leave = $wpdb->prefix. 'smgt_leave';
		$sql = "SELECT * FROM $table_hrmgt_leave WHERE start_date between '".$start_date."' AND '".$end_date."' AND employee_id='".$employee_id."' ";

		$result = $wpdb->get_results($sql);
		return $result;	
	}

	public function hrmgt_get_single_leave($id)
	{
		global $wpdb;
		$table_hrmgt_leave = $wpdb->prefix. 'smgt_leave';
		$result = $wpdb->get_row("SELECT * FROM $table_hrmgt_leave where id=".$id);			
		return $result;
	}
	public function hrmgt_approve_leave($data)
	{
		global $wpdb;
		$id = $data['leave_id'];
		$table_hrmgt_leave = $wpdb->prefix. 'smgt_leave';
		$row = $wpdb->get_row("SELECT * FROM $table_hrmgt_leave WHERE id=".$id);
		$update = $wpdb->query("UPDATE $table_hrmgt_leave SET status='Approved' where id=".$id);	
		$empdata = get_userdata((int)$row->student_id);
		if($update)
		{	
		    $data['start_date'] = $row->start_date;
			$data['end_date'] = $row->end_date;
			$data['student_id'] = $row->student_id;
			$data['leave_duration'] = $row->leave_duration;
			$leave_data = $this->hrmgt_get_single_leave($id);
			
			$arr=array();

			if(!empty($leave_data->end_date))
			{
				$date = smgt_change_dateformat($leave_data->start_date) .' To '. smgt_change_dateformat($leave_data->end_date);
			}
			else
			{
				//$date  = smgt_change_dateformat($leave_data->start_date);
				$date  = smgt_change_dateformat($leave_data->start_date) .' To -';
			}

			$arr['{{date}}']= $date;					
			$arr['{{system_name}}'] = get_option('smgt_school_name');
			$arr['{{user_name}}'] = mj_smgt_get_display_name($leave_data->student_id);
			$arr['{{comment}}'] = mj_smgt_strip_tags_and_stripslashes($data['comment']);
			$message = get_option('leave_approve_email_template');		
			
			$replace_message =  stripslashes(mj_smgt_string_replacement($arr,$message));
			
			if($replace_message)
			{
				$subject = stripslashes(get_option('leave_approve_subject'));						
				$to[]= mj_smgt_get_emailid_byuser_id($leave_data->student_id);				
				$emails = get_option('leave_approveemails');
				$emails = explode(",",$emails);
				
				foreach($emails as $email)
				{
					$to[]=$email;
				}
				$mail = mj_smgt_send_mail($to,$subject,$replace_message);	
				if($mail)
				{
					return true;
				}
			}


		}

	}

	public function hrmgt_approve_leave_selected($data1)
	{
		global $wpdb;

		$id = $data1;

		$table_hrmgt_leave = $wpdb->prefix. 'smgt_leave';

		$row = $wpdb->get_row("SELECT * FROM $table_hrmgt_leave WHERE id=".$id);

		if($row->status !='Rejected')

		{

			$update = $wpdb->query("UPDATE $table_hrmgt_leave SET status='Approved' where id=".$id);		

			if($update)

			{	

				$data['start_date'] = $row->start_date;

				$data['end_date'] = $row->end_date;

				$data['employee_id'] = $row->employee_id;
				$data['leave_duration'] = $row->leave_duration;

				//$this->add_leave_entry_in_attendance_details($data['start_date'],isset($data['end_date'])?$data['end_date']:'',$data['leave_duration'],$data['employee_id']);		
				$leave_data = $this->hrmgt_get_single_leave($id);
				$arr=array();
				if(!empty($leave_data->end_date))
				{
					$date = smgt_change_dateformat($leave_data->start_date) .' To '. smgt_change_dateformat($leave_data->end_date);
				}
				else
				{
					//$date  = smgt_change_dateformat($leave_data->start_date);
					$date  = smgt_change_dateformat($leave_data->start_date) .' To -';
				}

				$arr['{{date}}']= $date;					
				$arr['{{system_name}}'] = get_option('smgt_school_name');
				$arr['{{user_name}}'] = hrmgt_get_display_name($leave_data->employee_id);
				$arr['{{comment}}'] = mj_smgt_strip_tags_and_stripslashes($data['comment']);
				$message = get_option('leave_approve_email_template');		
				$replace_message =  stripslashes(hrmgt_string_replacemnet($arr,$message));			
				if($replace_message)
				{
					$subject = stripslashes(get_option('leave_approve_subject'));						
					$to[]= hrmgt_get_emailid_byuser_id($leave_data->employee_id);				
					$emails = get_option('leave_approveemails');
					$emails = explode(",",$emails);
					foreach($emails as $email)
					{
						$to[]=$email;
					}
					$mail = hmgt_send_mail($to,$subject,$replace_message);				
					if($mail)
					{
						return true;
					}
				}
			  return  $update;			
			}
			else
			{
			 	return  $update;
			}
		}	
	}

	public function hrmgt_reject_leave($data)
	{
		global $wpdb;
		$id = $data['leave_id'];
		$table_hrmgt_leave = $wpdb->prefix. 'smgt_leave';
		$row = $wpdb->get_row("SELECT * FROM $table_hrmgt_leave WHERE id=".$id);
		$update = $wpdb->query("UPDATE $table_hrmgt_leave SET status='Rejected' where id=".$id);
		$empdata = get_userdata((int)$row->student_id);

	}

	public function hrmgt_reject_leave_selected($data1)
	{
		global $wpdb;
		$id = $data1;
		$table_hrmgt_leave = $wpdb->prefix. 'smgt_leave';
		$row = $wpdb->get_row("SELECT * FROM $table_hrmgt_leave WHERE id=".$id);
		if($row->status !='Approved')
		{
			$update = $wpdb->query("UPDATE $table_hrmgt_leave SET status='Rejected' where id=".$id);		
			if($update)
			{ 	
				$replace_message="";
				$to = array();
				$leave_data = $this->hrmgt_get_single_leave($id);
				$to[]= hrmgt_get_emailid_byuser_id($leave_data->employee_id);
				$emails= explode(",",get_option('leave_approveemails'));
				foreach($emails as $email)
				{
					$to[] = $email;
				}			
				$subject="Reject Leave";
				$replace_message .= "Hello, \r\n \r\n Leave of ". hrmgt_get_display_name($leave_data->employee_id) . " is  rejected.";
				$replace_message .="\r\n \r\n";
				$replace_message .= "Comment  : ". $data['comment'];

				$mail = hmgt_send_mail($to,$subject,$replace_message);			
				if($mail)
				{
					return true;					
				}
			}	
		}
	}

	public function hrmgt_delete_leave($leave_id)
	{
		school_append_audit_log(''.esc_html__('Delete Leave Detail','hospital_mgt').'',null,get_current_user_id(),'delete');
		global $wpdb;
		$table_hrmgt_leave = $wpdb->prefix. 'smgt_leave';
		$leave_data=$this->hrmgt_get_single_leave($leave_id);	
		$result = $wpdb->query("DELETE FROM $table_hrmgt_leave where id= ".$leave_id);	
		return $result;

	}
}

?>