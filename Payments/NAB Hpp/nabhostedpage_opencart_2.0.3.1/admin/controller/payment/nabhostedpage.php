<?php

class ControllerPaymentNabHostedPage extends Controller {

    private $error = array();

    public function index() {
        $this->load->language('payment/nabhostedpage');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('nabhostedpage', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $data['entry_merchantid'] = $this->language->get('entry_merchantid');
        $data['entry_test'] = $this->language->get('entry_test');
        $data['entry_completed_status'] = $this->language->get('entry_completed_status');
        $data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $data['entry_log'] = $this->language->get('entry_log');
        
        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_all_zones'] = $this->language->get('text_all_zones');
        $data['text_yes'] = $this->language->get('text_yes');
        $data['text_no'] = $this->language->get('text_no');


        $data['help_test'] = $this->language->get('help_test');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        $data['tab_general'] = $this->language->get('tab_general');
        $data['tab_order_status'] = $this->language->get('tab_order_status');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['merchantid'])) {
            $data['error_merchantid'] = $this->error['merchantid'];
        } else {
            $data['error_merchantid'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_payment'),
            'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('payment/nabhostedpage', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['action'] = $this->url->link('payment/nabhostedpage', 'token=' . $this->session->data['token'], 'SSL');

        $data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

        if (isset($this->request->post['nabhostedpage_merchantid'])) {
            $data['nabhostedpage_merchantid'] = $this->request->post['nabhostedpage_merchantid'];
        } else {
            $data['nabhostedpage_merchantid'] = $this->config->get('nabhostedpage_merchantid');
        }

        if (isset($this->request->post['nabhostedpage_test'])) {
            $data['nabhostedpage_test'] = $this->request->post['nabhostedpage_test'];
        } else {
            $data['nabhostedpage_test'] = $this->config->get('nabhostedpage_test');
        }

        if (isset($this->request->post['nabhostedpage_log'])) {
            $data['nabhostedpage_log'] = $this->request->post['nabhostedpage_log'];
        } else {
            $data['nabhostedpage_log'] = $this->config->get('nabhostedpage_log');
        }

        if (isset($this->request->post['nabhostedpage_completed_status_id'])) {
            $data['nabhostedpage_completed_status_id'] = $this->request->post['nabhostedpage_completed_status_id'];
        } else {
            $data['nabhostedpage_completed_status_id'] = $this->config->get('nabhostedpage_completed_status_id');
        }

        $this->load->model('localisation/order_status');

        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        if (isset($this->request->post['nabhostedpage_geo_zone_id'])) {
            $data['nabhostedpage_geo_zone_id'] = $this->request->post['nabhostedpage_geo_zone_id'];
        } else {
            $data['nabhostedpage_geo_zone_id'] = $this->config->get('nabhostedpage_geo_zone_id');
        }

        $this->load->model('localisation/geo_zone');

        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        if (isset($this->request->post['nabhostedpage_status'])) {
            $data['nabhostedpage_status'] = $this->request->post['nabhostedpage_status'];
        } else {
            $data['nabhostedpage_status'] = $this->config->get('nabhostedpage_status');
        }

        if (isset($this->request->post['nabhostedpage_sort_order'])) {
            $data['nabhostedpage_sort_order'] = $this->request->post['nabhostedpage_sort_order'];
        } else {
            $data['nabhostedpage_sort_order'] = $this->config->get('nabhostedpage_sort_order');
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('payment/nabhostedpage.tpl', $data));
    }

    private function validate() {
        if (!$this->user->hasPermission('modify', 'payment/nabhostedpage')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        if (!$this->request->post['nabhostedpage_merchantid']) {
            $this->error['merchantid'] = $this->language->get('error_merchantid');
        }

        return !$this->error;
    }

}
