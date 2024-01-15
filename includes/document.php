<?php
class smgt_document
{	
        //ADD DOCUMENT FUNCTION
	public function mj_smgt_add_document($data,$document_data)
	{ 
      	global $wpdb;
		$table_name = $wpdb->prefix. 'smgt_document';
		
		if($data['action']=='edit')
		{ 
			school_append_audit_log(''.esc_html__('Update Document Detail','hospital_mgt').'',null,get_current_user_id(),'edit');
            $documentdata['class_id']=$data['class_id'];
            $documentdata['section_id']=$data['class_section'];
            $documentdata['student_id']=$data['selected_users'];
            $documentdata['document_content']=json_encode($document_data);
            $documentdata['description']=$data['description'];
            $documentdata['createdby']=get_current_user_id();
            $documentdata['created_date']=date('Y-m-d');
			
			$whereid['document_id']=$data['document_id'];
			$result=$wpdb->update( $table_name, $documentdata ,$whereid);
			return $result;
		}
		else
		{
			school_append_audit_log(''.esc_html__('Add New Document Detail','hospital_mgt').'',null,get_current_user_id(),'insert');
            $documentdata['class_id']=$data['class_id'];
            $documentdata['section_id']=$data['class_section'];
            $documentdata['student_id']=$data['selected_users'];
            $documentdata['document_content']=json_encode($document_data);
            $documentdata['description']=$data['description'];
            $documentdata['createdby']=get_current_user_id();
            $documentdata['created_date']=date('Y-m-d');
            $result=$wpdb->insert( $table_name, $documentdata );
			return $result;
		}
	
	}
	//GET ALL DOCUMENT FUNCTION
	public function mj_smgt_get_all_documents()
	{
		global $wpdb;
		$table_name = $wpdb->prefix. 'smgt_document';
	
		$result = $wpdb->get_results("SELECT * FROM $table_name");
		return $result;
	
	}
	//GET ALL DOCUMENT FUNCTION
	public function mj_smgt_get_own_documents($user_id)
	{
		global $wpdb;
		$table_name = $wpdb->prefix. 'smgt_document';
	
		$result = $wpdb->get_results("SELECT * FROM $table_name where student_id=$user_id OR createdby=".$user_id);
		return $result;
	
	}
    
	//GET SINGLE DOCUMENT FUNCTION
	public function mj_smgt_get_single_document($id)
	{
		global $wpdb;
		$table_name = $wpdb->prefix. 'smgt_document';
		$result = $wpdb->get_row("SELECT * FROM $table_name where document_id=".$id);
		return $result;
	}

	// DELETE DOCUMENTS
	public function mj_smgt_delete_document($id)
	{
		school_append_audit_log(''.esc_html__('Delete Document Detail','hospital_mgt').'',null,get_current_user_id(),'delete');
		global $wpdb;
		$table_name = $wpdb->prefix. 'smgt_document';
		$result = $wpdb->query("DELETE FROM $table_name where document_id= ".$id);
       
		return $result;
	}

	//GET OWN STUDENT DOCUMENT 
	public function mj_smgt_get_own_student_document($id)
	{
		$section_id= get_user_meta($id, 'class_section',true);
		$class_id= get_user_meta($id, 'class_name',true);
		global $wpdb;
		$table_name = $wpdb->prefix. 'smgt_document';
		$result = $wpdb->get_results("SELECT * FROM $table_name where (class_id='all class' AND section_id='all section') OR (student_id=$id AND section_id=$section_id AND class_id= $class_id ) OR (student_id='all student' AND section_id=$section_id AND class_id= $class_id ) OR (section_id='all section' AND class_id= $class_id  AND student_id='all student') " );
		return $result;
	}
}
?>