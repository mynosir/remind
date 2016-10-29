<?php
/**
 * undone orders manager controller
 *
 *
 */
class order_undone_manager extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('order_manager_model', 'def_model');
        $this->load->model('customer_manager_model', 'customer_model');
    }


    public function index() {
        $this->load->view('orders/order_undone_manager');
        // var_dump($this->session);exit();
        // $customers = $this->customer_model->getList();
        // var_dump($customers); exit();
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
    public function details($applyid=0) {
        $data = array(
            'actionxm' => 'insert',
            'info' => array()
        );
        if($applyid != '0') {
            $info = $this->def_model->get_info($applyid);
            $data['isend'] = $info[0]['isend'];
            $data['applyid'] = $info[0]['applyid'];

            $data['info'] = $info;
            $this->load->view('orders/info/info', $data);
        }else{
            $this->load->view('orders/info/step_0', $data);
        }
    }

    // 打开缴费页面
    public function pay($applyid=0) {
        $this->load->model('payRecord_model');
        $data['info'] = $this->payRecord_model->getRecordList($applyid);
        $data['applyid'] = $applyid;
        $this->load->view('orders/payRecord', $data);
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
            case 'details':
                $id = $this->get_request('id');
                $result = $this->def_model->get_detail($id);
                echo $result;
                break;
            case 'stepsinfo':
                $this->load->config('corder');
                $config = $this->config->item('corder');
                $applyid = $this->get_request('applyid');
                $info = $this->def_model->get_info($applyid, 'DESC', 'Y');
                $renddata = array();
                foreach ($info as $k =>& $v) {
                    foreach ($v as $kk => $vv) {
                        if(isset($config['step_'.$v['handelpoint']][$kk])) {
                            $renddata[] = array(
                                'name' =>  $config['step_'.$v['handelpoint']][$kk],
                                'value' => $vv,
                                'group' => '步骤'.$v['step'].' - '.$config['step'][$v['handelpoint']]
                            );
                        }
                    }
                }
                $result = array(
                    'total' => count($renddata),
                    'rows' => $renddata
                );
                echo json_encode($result);
                break;
            case 'getPromoter':
                $this->load->model('sys/user_model', 'user_model');
                $result = $this->user_model->get_list();
                echo json_encode($result);
                break;
        }
    }

    public function post() {
        $actionxm = $this->get_request('actionxm');
        $result = array();
        switch($actionxm) {
            case 'insert':
                $info = $this->get_request();
                $result = $this->def_model->insert($info);
                break;
            case 'savePay':
                $this->load->model('payRecord_model');
                $info = $this->get_request();
                $result = $this->payRecord_model->insert($info);
                break;
        }
        $this->output_result($result);
    }

}
