<?php
/**
 * customers' infomation manager controller
 *
 *
 */
class customer_manager extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('customer_manager_model', 'def_model');
    }


    public function index() {
        $this->load->view('customer/customer_manager');
    }

    public function info($id=0) {
        $data = array(
            'actionxm' => 'insert',
            'info' => array()
        );
        if(intval($id)>0) {
            $info = $this->def_model->get_info($id);
            if(count($info)>0) {
                $data['actionxm'] = 'update';
                $data['info'] = $info;
            }
        }
        $this->load->view('customer/customer_manager_info', $data);
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


    public function post() {
        $actionxm = $this->get_request('actionxm');
        $result = array();
        switch($actionxm) {
            case 'insert':
                $info = $this->get_request();
                $result = $this->def_model->insert($info);
                break;
            case 'update':
                $id = $this->input->post('id');
                $info = $this->get_request();
                $result = $this->def_model->update($id, $info);
                break;
            case 'delete':
                $id = $this->input->post('id');
                $result = $this->def_model->delete($id);
        }
        $this->output_result($result);
    }

}
