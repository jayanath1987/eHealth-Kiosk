<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
--------------------------------------------------------------------------------
HHIMS - Hospital Health Information Management System
Copyright (c) 2011 Information and Communication Technology Agency of Sri Lanka
<http: www.hhims.org/>
----------------------------------------------------------------------------------
This program is free software: you can redistribute it and/or modify it under the
terms of the GNU Affero General Public License as published by the Free Software 
Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,but WITHOUT ANY 
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR 
A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along 
with this program. If not, see <http://www.gnu.org/licenses/> or write to:
Free Software  HHIMS
ICT Agency,
160/24, Kirimandala Mawatha,
Colombo 05, Sri Lanka
---------------------------------------------------------------------------------- 
Author: Author: Mr. Jayanath Liyanage   jayanathl@icta.lk
                 
URL: http://www.govforge.icta.lk/gf/project/hhims/
----------------------------------------------------------------------------------
*/
class Kiosk extends MX_Controller {
	 function __construct(){
		parent::__construct();
		$this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
	 }

	public function token()
	{
        $data = array();
        $this->load->vars($data);
		$this->load->view('kiosk_token_view');
    }

    public function new_opd_token(){
        $pid=$this->input->post("pid");
        if(!isset($pid) ||(!is_numeric($pid) ||($pid<=0))){
			echo -1;
            return;
		}
        $this->load->model('mpersistent');
		$this->load->model('mappointment');
		$pat= $this->mpersistent->open_id($pid,"patient","PID");
		if (empty($pat)){
			echo -3;
            return;
		}
		$nu_token= $this->mappointment->check_token(date("Y-m-d"),$pid);
		if ( $nu_token > 0){
			echo -2;
            return;
		}
        $token = $this->mappointment->get_next_token(date("Y-m-d"),"OPD New");
        $sve_data = array(
                "VDate"=>date("Y-m-d"),
                "Type"=>"OPD New",
                "app_type"=>"USUAL",
                "PID"=>$pid,
                "Token"=>$token+1
            );
        $appid = $this->mpersistent->create("appointment", $sve_data);
        echo $appid; 
        
    }
	
} 


//////////////////////////////////////////

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
