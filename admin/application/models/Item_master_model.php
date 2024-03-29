<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


class Item_master_model extends CI_Model
{
    function item_masterListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.item_master_id, BaseTbl.item_master_name, BaseTbl.item_master_desc, BaseTbl.item_master_unit,BaseTbl.item_master_created_at,BaseTbl.item_master_update_at,c.item_category_name,u.item_unit_name,BaseTbl.item_master_logo');
        $this->db->from('tbl_item_master as BaseTbl');
        $this->db->join('tbl_item_unit as u', 'u.item_unit_id = BaseTbl.item_master_unit','left');
        $this->db->join('tbl_item_category as c', 'c.item_category_id = BaseTbl.item_master_category','left');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.item_master_name  LIKE '%".$searchText."%'
                            OR  BaseTbl.item_master_desc  LIKE '%".$searchText."%'
                            OR  u.item_unit_name  LIKE '%".$searchText."%'
                            OR  c.item_category_name  LIKE '%".$searchText."%'
                            OR  BaseTbl.item_master_unit  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        //$this->db->where('BaseTbl.roleId !=', 1);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    function item_masterListing($searchText = '', $page, $segment)
    {
        $this->db->select('BaseTbl.item_master_id, BaseTbl.item_master_name, BaseTbl.item_master_desc, BaseTbl.item_master_unit,BaseTbl.item_master_created_at,BaseTbl.item_master_update_at,c.item_category_name,u.item_unit_name,BaseTbl.item_master_logo');
        $this->db->from('tbl_item_master as BaseTbl');
        $this->db->join('tbl_item_unit as u', 'u.item_unit_id = BaseTbl.item_master_unit','left');
        $this->db->join('tbl_item_category as c', 'c.item_category_id = BaseTbl.item_master_category','left');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.item_master_name  LIKE '%".$searchText."%'
                            OR  BaseTbl.item_master_desc  LIKE '%".$searchText."%'
                            OR  u.item_unit_name  LIKE '%".$searchText."%'
                            OR  c.item_category_name  LIKE '%".$searchText."%'
                            OR  BaseTbl.item_master_unit  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->order_by('BaseTbl.item_master_id', 'DESC');
        $this->db->limit($page, $segment);
        $this->db->where('BaseTbl.isDeleted', 0);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
    
    function add_new_item_master($value)
    {
        $item_master_url_slug=$this->makeseourl($value['item_master_name']);
        $vals = array('item_master_name'=>trim($value['item_master_name']),'item_master_url_slug'=>$item_master_url_slug,'item_master_desc'=>$value['item_master_desc'],'item_master_desc_long'=>$value['item_master_desc_long'],'item_master_stock'=>$value['item_master_stock'],'item_master_price'=>$value['item_master_price'],'item_master_unit'=>$value['item_master_unit'],'item_master_created_at'=>date('Y-m-d H:i:s'),'item_master_update_at'=>date('Y-m-d H:i:s'),'item_master_logo'=>$value['item_master_logo'],'item_master_category'=>$value['item_master_category']);
        $this->db->trans_start();
        $this->db->insert('tbl_item_master', $vals);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    
    function get_item_unit_info($id)
    {
         $this->db->select('BaseTbl.item_master_id, BaseTbl.item_master_name, BaseTbl.item_master_desc,BaseTbl.item_master_desc_long,BaseTbl.item_master_unit,BaseTbl.item_master_stock,BaseTbl.item_master_price,BaseTbl.item_master_logo,BaseTbl.item_master_category');
        //$this->db->select('sub_service_id, service_id, sub_service_name');
        $this->db->from('tbl_item_master as BaseTbl');
        $this->db->where('item_master_id', $id);        
        $query = $this->db->get();
        return $query->row_array();
    }

    function get_all_units()
    {
        $this->db->select('*');
        $this->db->from('tbl_item_unit');
        $this->db->order_by('item_unit_id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_all_category()
    {
        $this->db->select('*');
        $this->db->from('tbl_item_category');
        $this->db->order_by('item_category_id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function edit_item_master($val)
    {
        //echo "<pre>";print_r($val);die;
        $this->db->set('item_master_name',trim($val['item_master_name']));
        $this->db->set('item_master_url_slug',($this->makeseourl($val['item_master_name'])));
        $this->db->set('item_master_desc',$val['item_master_desc']);
        $this->db->set('item_master_desc_long',$val['item_master_desc_long']);
        $this->db->set('item_master_unit',$val['item_master_unit']);
        $this->db->set('item_master_stock',$val['item_master_stock']);
        $this->db->set('item_master_category',$val['item_master_category']);
        $this->db->set('item_master_logo',$val['item_master_logo']);
        $this->db->set('item_master_price',$val['item_master_price']);
        $this->db->set('item_master_update_at',date('Y-m-d H:i:s'));
        $this->db->where('item_master_id', $val['item_master_id']);
        $this->db->update('tbl_item_master');
        return TRUE;
    }
    
    function delete_item_master($id)
    {
        $this->db->set('isDeleted',1);
        $this->db->where('item_master_id', $id);
        $this->db->update('tbl_item_master');
        return $this->db->affected_rows();
    }

    function getservicesInfoById($servicesId)
    {
        $this->db->select('servicesId, name, email, mobile, roleId');
        $this->db->from('tbl_services');
        $this->db->where('isDeleted', 0);
        $this->db->where('tbl_item_master', $servicesId);
        $query = $this->db->get();
        
        return $query->row();
    }

    function getservicesInfoWithRole($servicesId)
    {
        $this->db->select('BaseTbl.servicesId, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, BaseTbl.roleId, Roles.role');
        $this->db->from('tbl_services as BaseTbl');
        $this->db->join('tbl_roles as Roles','Roles.roleId = BaseTbl.roleId');
        $this->db->where('BaseTbl.servicesId', $servicesId);
        $this->db->where('BaseTbl.isDeleted', 0);
        $query = $this->db->get();
        
        return $query->row();
    }

    function makeseourl($str)
    {
    if($str !== mb_convert_encoding( mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
    $str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
    $str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
    $str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $str);
    $str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
    $str = preg_replace(array('`[^a-z0-9]`i','`[-]+`'), '-', $str);
    $str = strtolower( trim($str, '-') );
    return $str;
    }

} 