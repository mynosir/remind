<?php
/**
 * done orders manager controller
 *
 *
 */
class order_manager extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('order_manager_model', 'def_model');
    }


    public function index() {
        $this->load->view('orders/order_manager');
    }

    public function details($id=0) {
        $data = array(
            'actionxm' => 'details',
            'info' => array()
        );
        if(intval($id)>0) {
            $info = $this->def_model->get_info($id);
            if(count($info)>0) {
                $data['actionxm'] = 'details';
                $data['info'] = $info;
            }
        }
        $this->load->view('orders/order_detail_info', $data);
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
        }
    }

}
