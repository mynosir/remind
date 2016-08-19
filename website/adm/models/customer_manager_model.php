<?php
/**
 * 客户信息管理模型
 *
 */
class customer_manager_model extends MY_Model {

    private $table = 'customer';
    private $fields = 'id, user_name, type, id_code, address, zip_code, linkman, fixed_tel, mobile_tel, create_time, update_time';


    public function __construct() {
        parent::__construct();
    }


    /**
     * 搜索客户信息列表
     * @param  [type] $params [description]
     * @param  [type] $order  [description]
     * @param  [type] $page   [description]
     * @return [type]         [description]
     */
    public function search($params, $order, $page) {

        $start_time = get_value($params, 'start_time');               // 创建开始时间
        $end_time = get_value($params, 'end_time');                   // 创建结束时间
        $user_name = get_value($params, 'user_name');                 // 申请人
        $id_code = get_value($params, 'id_code');                     // 身份证or机构编码
        $mobile_tel = get_value($params, 'mobile_tel');               // 手机号
        $type = get_value($params, 'type');                           // 客户类型

        $where = array();
        if($start_time!='') {
            $where[] = array('update_time', strtotime($start_time), '>=');
        }
        if($end_time!='') {
            $where[] = array('update_time', strtotime($end_time), '<=');
        }
        if($user_name!='') {
            $where[] = array('user_name', $user_name, 'like');
        }
        if($id_code!='') {
            $where[] = array('id_code', $id_code);
        }
        if($mobile_tel!='') {
            $where[] = array('mobile_tel', $mobile_tel);
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

    public function getList() {

        $datas = $this->db->get_list($this->table, $this->fields);

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
            'user_name'              => get_value($info, 'user_name'),
            'type'                   => get_value($info, 'type'),
            'id_code'                => get_value($info, 'id_code'),
            'address'                => get_value($info, 'address'),
            'zip_code'               => get_value($info, 'zip_code'),
            'linkman'                => get_value($info, 'linkman'),
            'fixed_tel'              => get_value($info, 'fixed_tel'),
            'mobile_tel'             => get_value($info, 'mobile_tel'),
            'create_time'            => time(),
            'update_time'            => time()
        );
        $this->db->insert($this->table, $data);
        return $this->create_result(true, 0, array('id'=>$this->db->insert_id()));
    }


    public function update($id, $info) {
        if($info['type']=='1') {
            $info['linkman'] = '';
        }
        $data = array(
            'user_name'              => get_value($info, 'user_name'),
            'type'                   => get_value($info, 'type'),
            'id_code'                => get_value($info, 'id_code'),
            'address'                => get_value($info, 'address'),
            'zip_code'               => get_value($info, 'zip_code'),
            'linkman'                => get_value($info, 'linkman'),
            'fixed_tel'              => get_value($info, 'fixed_tel'),
            'mobile_tel'             => get_value($info, 'mobile_tel'),
            'create_time'            => time(),
            'update_time'            => time()
        );
        $where = array('id'=> $id);
        $this->db->update($this->table, $data, $where);
        return $this->create_result(true, 0, $where);
    }


    public function delete($id) {
        $this->db->delete($this->table, array('id'=>$id));
        return $this->create_result(true, 0, array('id'=>$id));
    }
}
