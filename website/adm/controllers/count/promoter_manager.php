<?php
/**
 * 发起人报表管理控制器
 *
 * @author linzequan <lowkey361@gmail.com>
 *
 */
class promoter_manager extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('order_manager_model', 'def_model');
    }


    public function index() {
        $this->load->view('count/promoter_manager');
    }


    public function get() {
        $actionxm=$this->get_request('actionxm');
        $result=array();
        switch($actionxm) {
            case 'search':
                $params = $this->input->post('rs');
                $order  = get_datagrid_order();
                $page   = get_datagrid_page();
                $result = $this->def_model->searchPromoter($params, $order, $page);
                break;
            case 'getPromoter':
                $this->load->model('sys/user_model', 'user_model');
                $result = $this->user_model->get_list();
                break;
        }
        echo json_encode($result);
    }

}
