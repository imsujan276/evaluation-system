<?php

/**
 * @author Lloric Mayuga Gracia <emorickfighter@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Chart extends Admin_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {

        $this->data['data_chart'] = 'datafromphp[0] = {
                                        label: "keyy",
                                        data: 4
                                    }';





        $this->header_view_chart();
        //  $this->_render_page('admin/table', $this->data);
        $this->_render_page('admin/chart', $this->data);
        $this->_render_page('admin/footer_chart', $this->data);
    }

}
