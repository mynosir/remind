<?php
/**
 * undone count manager controller
 *
 *
 */
class count_manager extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('count_manager_model', 'def_model');
        $this->load->model('order_manager_model', 'corder_model');
        $this->load->model('customer_manager_model', 'customer_model');
    }


    public function index() {
        $this->load->view('count/count_manager');
    }

    public function info($id=0) {
        $data = array(
            'actionxm' => 'insert',
            'info' => array()
        );
        if(intval($id)>0) {
            $data['actionxm'] = 'insert';
            $info = $this->def_model->get_info_byid($id);
            $info['step'] = intval($info['step']) + 1;
            $data['info'] = $info;
            $nextid = $info['nextid'];
            $this->load->view('orders/info/step_'.$nextid, $data);
        }else{
            $this->load->view('orders/info/step_0', $data);
        }
    }


    // 打开详情页面
    public function details($customer=0) {
        $data = array(
            'actionxm' => 'insert',
            'info' => array()
        );
        if($customer != '0') {
            $info['customer'] = $customer;
            $data['info'] = $info;
            $this->load->view('count/count_manager_info', $data);
        }
    }

    // 查询customer表
    public function customers() {
        $customers = $this->customer_model->getList();
        echo json_encode($customers);
    }

    public function get() {
        $actionxm = $this->get_request('actionxm');
        $result = array();
        switch($actionxm) {
            case 'search':
                $params = $this->input->post('rs');
                $order = get_datagrid_order();
                $page = get_datagrid_page();
                $result = $this->def_model->search($params, $order, $page);
                echo json_encode($result);
                break;
            case 'search_1':
                $params = $this->input->post('rs');
                $order = get_datagrid_order();
                $page = get_datagrid_page();
                $result = $this->def_model->search_1($params, $order, $page);
                echo json_encode($result);
                break;
        }
    }

}
