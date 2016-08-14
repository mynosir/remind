<?php
/**
 * 客户信息管理模型
 *
 *
 */
class customer_manager_model extends MY_Model {

    private $table = 'corder';
    private $fields = 'id, applyid, name, customer, type, islater, billinfo, receiptinfo, handelpoint, step, handeltime, nexthandeler, remark, zipname, registerdate, applyno, ispaid, isslowdown, isbillout, registrationdate';

    public function __construct() {
        parent::__construct();
    }


    public function search($params, $order, $page) {

        $start_time = get_value($params, 'start_time');               // 创建开始时间
        $end_time = get_value($params, 'end_time');                   // 创建结束时间
        $name = get_value($params, 'name');                           // 申请名
        $cumtomer = get_value($params, 'customer');                   // 申请人
        $type = get_value($params, 'type');                           // 客户类型

        $where = array();
        if($start_time!='') {
            $where[] = array('update_time', strtotime($start_time), '>=');
        }
        if($end_time!='') {
            $where[] = array('update_time', strtotime($end_time), '<=');
        }
        if($name!='') {
            $where[] = array('name', $name, 'like');
        }
        if($cumtomer!='') {
            $where[] = array('cumtomer', $cumtomer, 'customer');
        }
        if($type!='-1') {
            $where[] = array('type', $type);
        }

        if(count($order)==0) {
            $order[] = ' update_time desc';
        }
        $datas = $this->db->get_page($this->table, $this->fields, $where, $order, $page);

        $datas['total'] = count($datas['rows']);
        return $datas;
    }


    public function get_info($id) {
        if($id<0) {
            return array();
        }
        $result = array();

        $query = $this->db->select($this->fields)->where('id', $id)->get($this->table);
        $result = $query->row_array();

        return $result;
    }


    public function insert($info) {
        if($info['type']=='1') {
            $info['linkman'] = '';
        }
        $data = array(
            //TODO: 节点是否分开
        );
        $this->db->insert($this->table, $data);
        return $this->create_result(true, 0, array('id'=>$this->db->insert_id()));
    }


    public function update($id, $info) {
        if($info['type']=='1') {
            $info['linkman'] = '';
        }
        $data = array(

        );
        $where = array('id'=>$id);
        $this->db->update($this->table, $data, $where);
        return $this->create_result(true, 0, $where);
    }


    public function delete($id) {
        $this->db->delete($this->table, array('id'=>$id));
        return $this->create_result(true, 0, array('id'=>$id));
    }
}
