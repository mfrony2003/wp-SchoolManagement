<?php
class event_Manage
{
    public function mj_smgt_insert_event($data,$file_name)
	{
		global $wpdb;
		$table_name=$wpdb->prefix.'event';
		$eventdata['event_title']=stripslashes($data['event_title']);
		$eventdata['description']=mj_smgt_address_description_validation(stripslashes($data['description']));
		$eventdata['start_date']=$data['start_date'];
		$eventdata['start_time']=$data['start_time'];
		$eventdata['end_date']=$data['end_date'];
		$eventdata['end_time']=$data['end_time'];
		$eventdata['event_doc']=$file_name;
        $eventdata['created_date']=date('Y-m-d');
		$eventdata['created_by']=get_current_user_id();
    
		if($data['action']=='edit')
		{
			school_append_audit_log(''.esc_html__('Update event detail ','hospital_mgt').'',null,get_current_user_id(),'edit');
			$whereid['event_id']=$data['event_id'];
			$result=$wpdb->update( $table_name, $eventdata ,$whereid);
			return $result;
		}
		else
		{
			school_append_audit_log(''.esc_html__('Add New Event','hospital_mgt').'',null,get_current_user_id(),'insert');
			$result=$wpdb->insert( $table_name, $eventdata );
            return $result;
		}
	}
    // GET SINGLE EVENT
	public function MJ_smgt_get_single_event($id)
	{
		global $wpdb;
		$table_name = $wpdb->prefix. 'event';
		$result = $wpdb->get_row("SELECT * FROM $table_name where event_id=".$id);
		return $result;
	}
    // GET All EVENT
	public function MJ_smgt_get_all_event()
	{
		global $wpdb;
		$table_name = $wpdb->prefix. 'event';
		$result = $wpdb->get_results("SELECT * FROM $table_name");
		return $result;
	}
	//------------ DELETE EVENT -----------//
	public function mj_smgt_delete_event($id)
	{
		school_append_audit_log(''.esc_html__('Delete Event','hospital_mgt').'',null,get_current_user_id(),'delete');
		global $wpdb;
		$table_name = $wpdb->prefix. 'event';
		$result = $wpdb->query("DELETE FROM $table_name where event_id= ".$id);
		return $result;
	}
	 // GET ALL EVENT FOR DASHBOARD
	 public function MJ_smgt_get_all_event_for_dashboard()
	 {
		 global $wpdb;
		 $table_name = $wpdb->prefix. 'event';
		 $result = $wpdb->get_results("SELECT * FROM $table_name ORDER BY event_id DESC limit 5");
		 return $result;
	 }
	// GET OWN EVENT DATA
	public function MJ_smgt_get_own_event_list($id)
	{
		global $wpdb;
		$table_name = $wpdb->prefix. 'event';
		$result = $wpdb->get_results("SELECT * FROM $table_name where created_by=$id");
		return $result;
	}
}