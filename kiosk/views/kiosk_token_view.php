<?php
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
echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>";
echo "\n<html xmlns='http://www.w3.org/1999/xhtml'>";
echo "\n<head>";
echo "\n<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>";
echo "\n<title>".$this->config->item('title')."</title>";
echo "\n<link rel='icon' type='". base_url()."image/ico' href='images/mds-icon.png'>";
echo "\n<link rel='shortcut icon' href='". base_url()."images/mds-icon.png'>";
echo "\n<link href='". base_url()."/css/mdstheme_navy.css' rel='stylesheet' type='text/css'>";
echo "\n<script type='text/javascript' src='". base_url()."js/jquery.js'></script>";
echo "\n    <script type='text/javascript' src='".base_url()."js/bootstrap/js/bootstrap.min.js' ></script>";
echo "\n    <link href='". base_url()."js/bootstrap/css/bootstrap.min.css' rel='stylesheet' type='text/css' />";
echo "\n    <link href='". base_url()."js/bootstrap/css/bootstrap-theme.min.css' rel='stylesheet' type='text/css' />";  
echo "\n<script type='text/javascript' src='". base_url()."/js/mdsCore.js'></script> ";
echo "\n</head>";
	
?>
<body onclick="$('#pid').focus();" >
    <div class="" >
        <center>
            <h1>QToken V1</h1><hr>
            <div>
                <h4>---------Scan the patient card here----------</h4>
                <input id="pid"  type="text" class="input input-lg" style="background:#ccc;width:400px;" autofocus />
            </div>
			<div id ="err_msg" style="color:red">
			</div>
        </center>
        		
		<div style="position:fixed; bottom:0; width:100%; text-align: center;" >
			<!-- <div >Visit <a href="http://www.govforge.icta.lk/gf/" target="_blank" ><b>www.govforge.icta.lk</b></a> for more details..</div><br>  -->
			 <a href='http://www.gov.lk/' target='_blank'><img src="<?php echo base_url(); ?>images/logo-health-ministry.jpg"  width=200 height=100></a>
			 <a href='http://www.icta.lk/' target='_blank'><img src="<?php echo base_url(); ?>images/icta.jpeg" width=200 height=100></a>		 
			 <!-- <a href='http://www.icta.lk/' target='_blank'><img src="<?php echo base_url(); ?>images/e-samajaya-logo.jpg" width=101 height=39 ></a>  -->
			 <a href='http://ictawebstg.lgcc.gov.lk/ehealth-project/' target='_blank'><img src="<?php echo base_url(); ?>images/digital_health.png" width=200 height=100></a>
			 
				
		</div>
    </div>
</body>
</html>
<script>
var token_win = null;
var ajax_url = "kiosk/new_opd_token";
$(function(){
    $(document).click(function(){$('#pid').focus();});
    $("body").mouseover(function(){$('#pid').focus();});
    $("#pid").keypress(
        function(e) {
            if(e.which == 13) {
                var res = $("#pid").val().substring(4, 10);
                var pid = Number(res);    
                var request = $.ajax({
                    url:ajax_url,
                    type: "post",
                    data:{"pid":pid}
                });
                clear();
                request.done(function (response, textStatus, jqXHR){
                    
                  if (response>0){ 
                    token_win = window.open("<?php echo site_url("/report/pdf/appointment/auto_print/"); ?>/"+response,"token_win","top=0,left=0,width=800,height=800")
                    token_win.focus();
                    setTimeout(function(){
                       token_win.close();
                    }, 5000); //5 seconds
                    clear();
                   
                  }
                   else if  (response ==-2){
                        $("#err_msg").html("Token already issued!");
                   }
				   else if  (response ==-3){
                        $("#err_msg").html("Patient not found!");
                   }
				   else{
				      $("#err_msg").html("Input error/Invalid ID!");
				   }
                }); 
               
            }
			$("#err_msg").html("");
    });

});
function clear(){
        $("#pid").val("");
        $("#err_msg").html("");
}
</script>
