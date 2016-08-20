<?php
/**
 * 客户信息管理模型
 *
 *
 */
class order_manager_model extends MY_Model {

    private $table = 'corder';
    private $fields = 'id, applyid, name, customer, type, islater, billinfo, receiptinfo, handelpoint, step, handeltime, nexthandeler, nextid, remark, zipname, registerdate, applyno, ispaid, isslowdown, isbillout, registrationdate, isend, createtime, createuser';

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
            $where[] = array('createtime', strtotime($start_time), '>=');
        }
        if($end_time!='') {
            $where[] = array('createtime', strtotime($end_time), '<=');
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
            $order[] = 'createtime desc';
        }
        $group_by = array('applyid');
        $datas = $this->db->get_page($this->table, $this->fields, $where, $order, $page, $group_by);
        $datas['total'] = count($datas['rows']);

        $this->load->model('sys/user_model', 'user_model');
        $this->load->model('customer_manager_model', 'customer_model');
        $CI = &get_instance();
        foreach($datas['rows'] as $k=>&$v) {
            // 因gruop by无法组内排序，查询替换最新数据
            $items = $this->get_info($v['applyid']);
            $v['id'] = $items[0]['id'];
            $v['handeltime'] = $items[0]['handeltime'];
            $v['nexthandeler'] = $items[0]['nexthandeler'];
            $v['nextid'] = $items[0]['nextid'];
            $v['step'] = $items[0]['step'];

            if($userinfo=$CI->user_model->get_userinfo_by_id($v['createuser'])) {
                $v['createuser'] = $userinfo['true_name'];
            } else {
                $v['createuser'] = '';
            }
            if($userinfo=$CI->user_model->get_userinfo_by_id($v['nexthandeler'])) {
                $v['nexthandeler'] = $userinfo['true_name'];
            } else {
                $v['nexthandeler'] = '';
            }
            if($cumtomer=$CI->customer_model->get_info($v['customer'])) {
                $v['customer'] = $cumtomer['user_name'];
            } else {
                $v['customer'] = '';
            }

            $v['handeltime'] = date('Y-m-d', $v['handeltime']);
            $v['registerdate'] = date('Y-m-d', $v['registerdate']);
            $v['registrationdate'] = date('Y-m-d', $v['registrationdate']);
            $v['createtime'] = date('Y-m-d', $v['createtime']);

        }
        return $datas;
    }

    // 订单详情查询，根据applyid查询组合
    public function get_info($applyid) {
        if($applyid<0) {
            return array();
        }
        $result = array();
        $query = $this->db->select($this->fields)->where('applyid', $applyid)->order_by('createtime', 'DESC')->get($this->table);
        // var_dump($this->db->last_query());exit();
        $result = $query->result_array();
        return $result;
    }

    public function get_info_byid($id) {
        if($id<0) {
            return array();
        }
        $result = array();
        $query = $this->db->select($this->fields)->where('id', $id)->get($this->table);
        $result = $query->row_array();
        return $result;
    }


    public function insert($info) {
        if ($info['nextid']!='6') {
            $info['isend'] = 0;
        }
        if ($info['nextid']!='3') {
            $info['registerdate'] = 0;
        }
        if ($info['nextid']==1 && $info['step']==1) {
            $info['applyid'] = $this->generateOrderNum();
            if ($info['type']!=1) {
                $info['islater'] = 0;
            }
        }

        if ($info['handelpoint']=='2' && $info['handeltime']=='' && $info['nexthandeler']=='-1') {
            // 因gruop by无法组内排序，查询替换最新数据
            $items = $this->get_info($info['applyid']);
            $info['handeltime'] = date('Y-m-d', $items[0]['handeltime']);
            $info['nexthandeler'] = $items[0]['nexthandeler'];
            $info['nextid'] = 3;
        }

        $data = array(
            'applyid' => get_value($info, 'applyid'),
            'name' => get_value($info, 'name'),
            'customer' => get_value($info, 'customer'),
            'type' => get_value($info, 'type', 0),
            'islater' => get_value($info, 'islater', 0),
            'billinfo' => get_value($info, 'billinfo'),
            'receiptinfo' => get_value($info, 'receiptinfo'),
            'handelpoint' => get_value($info, 'handelpoint'),
            'step' => get_value($info, 'step'),
            'handeltime' => strtotime(get_value($info, 'handeltime')),
            'nexthandeler' => get_value($info, 'nexthandeler'),
            'nextid' => get_value($info, 'nextid'),
            'remark' => get_value($info, 'remark'),
            'zipname' => get_value($info, 'zipname'),
            'registerdate' => get_value($info, 'registerdate', 0),
            'applyno' => get_value($info, 'applyno'),
            'ispaid' => get_value($info, 'ispaid', 0),
            'isslowdown' => get_value($info, 'isslowdown', 0),
            'isbillout' => get_value($info, 'isbillout', 0),
            'registrationdate' => get_value($info, 'registrationdate', 0),
            'isend' => get_value($info, 'isend', 0),
            'createuser' => $this->session->userdata('user_id'),
            'createtime' => time()
        );



        $this->db->insert($this->table, $data);
        // die($this->db->last_query());
        return $this->create_result(true, 0, array('id'=>$this->db->insert_id()));
    }


    /**
     * 生成唯一订单号
     */
    private function generateOrderNum() {
        $username = $this->session->userdata('user_name');
        return md5($username . time());
    }

}
