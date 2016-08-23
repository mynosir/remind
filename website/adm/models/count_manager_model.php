<?php
/**
 * 客户信息管理模型
 *
 */
class count_manager_model extends MY_Model {

    private $table = 'corder';
    private $fields = 'id, applyid, name, type, customer, createtime';

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
        $step = get_value($params, 'step');                          // 过滤申请步骤为1的
        $customer = get_value($params, 'customer');                  // 申请人

        $where = array();
        if($customer!='' && $customer!='-1') {
            $where[] = array('customer', $customer, 'like');
        }
        if($step!='') {
            $where[] = array('step', $step);
        }

        if(count($order)==0) {
            $order[] = 'createtime desc';
        }

        $group_by = array('customer');
        $datas = $this->db->get_page($this->table, 'customer', $where, $order, $page, $group_by);

        $datas['total'] = count($datas['rows']);

        // 处理返回结果
        $resultArray = array();
        foreach ($datas['rows'] as $k => $v) {
            $where_in = array();
            $where_in[] = array('customer', $v['customer']);
            $where_in[] = array('step', '1');

            $group_by_in = array('type');
            $datas_in = $this->db->get_list($this->table, 'customer, type, count(1) as num', $where_in, $order, $group_by_in);

            $item = array();
            foreach ($datas_in['rows'] as $kk => $vv) {
                $this->load->model('customer_manager_model', 'customer_model');
                $CI = &get_instance();
                if($customerdata=$CI->customer_model->get_info($v['customer'])) {
                    $item['customername'] = $customerdata['user_name'];
                } else {
                    $item['customername'] = '';
                }
                $item['customer'] = $v['customer'];
                $item['type_'.$vv['type']] = $vv['num'];
            }
            $resultArray[] = $item;
        }
        $datas['rows'] = $resultArray;
        return $datas;
    }

    public function search_1($params, $order, $page) {
        $step = get_value($params, 'step');                      // 过滤申请步骤为1的
        $name = get_value($params, 'name');                      // 申请名称
        $type = get_value($params, 'type');                      // 申请类型
        $customer = get_value($params, 'customer');              // 申请类型

        $where = array();
        if($customer!='') {
            $where[] = array('customer', $customer);
        }
        if($name!='') {
            $where[] = array('name', $name, 'like');
        }
        if($step!='') {
            $where[] = array('step', $step);
        }
        if($type!='' && $type!='-1') {
            $where[] = array('type', $type);
        }
        if(count($order)==0) {
            $order[] = 'createtime desc';
        }
        $datas = $this->db->get_page($this->table, 'applyid, name, type, customer', $where, $order, $page);
        $datas['total'] = count($datas['rows']);

        $this->load->model('customer_manager_model', 'customer_model');
        $CI = &get_instance();
        foreach($datas['rows'] as $k=>&$v) {
            if($customer=$CI->customer_model->get_info($v['customer'])) {
                $v['customername'] = $customer['user_name'];
            } else {
                $v['customername'] = '';
            }
        }
        return $datas;
    }

}
