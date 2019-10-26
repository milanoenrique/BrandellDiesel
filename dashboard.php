<?php
	include_once("config.php");
	include_once("includes/functions.php");
    include_once("templates/classHeader.php");

	//session_start();
	if(isset($_SESSION['google_data'])) {
		$techName   = $_SESSION['google_data']['given_name'];
		$techId     = $_SESSION['google_data']['email'];		
		$resultArray = getValidateUser($techId, '', 'G', 'A');
		$_SESSION['getValidateUser']=$resultArray;
		$_SESSION["expire"]=time();
		if (isset($_SESSION['getValidateUser']['rol'])) {
			$profile	= $_SESSION['getValidateUser']['rol'];
		}else {
			header("Location:index_managerg.php?user=invalid");
			//$profile	= 'TV';
		}
	} else {
		$techName   = $_SESSION['getValidateUser']['fullNameUser'];
		$techId     = $_SESSION['getValidateUser']['idUser'];
		$profile	= $_SESSION['getValidateUser']['rol'];

	if(!isset($_SESSION['getValidateUser']) || empty($_SESSION['getValidateUser'])) {
		header("Location: http://reqparts.bdicalgary.com/BrandellDiesel/index_tech.php");
		die();
		}
	}

    $header=new classHeader();     

    $header->setDefaultMenuItems($_SESSION['perfil'],$profile);
    $header->getHeader();
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
 
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");

?>
        <iframe hidden="true" id="PDFtoPrint" width="100%" height="100%"></iframe>

            <div class="row">
                <div class="panel panel-default" id="print-dashboard">
                    <div class="panel-heading" style="padding-bottom: 70px;background:#191919;">
    				<font color='#fff'>
    					<div class="col-xs-12 text-center" id="one">
    						<div class="col-xs-3 text-left" id="date">
    							Invalid Date
    						</div>
    						<div class="col-xs-6 text-left" id="two">
    							<font color='#fff'>
    								<div class="col-md-6">

                                        <div>
                                        <span>Expired: </span><span class="fa fa-circle" style="color:red;"></span><span id="red"></span>
                                        </div>
                                           
                                        <div>
                                        <span>Expiring soon: </span><span class="fa fa-circle" style="color:yellow;"></span><span id="yellow"></span>
                                        </div>
                                        <div>
                                        <span>On Time: </span><span class="fa fa-circle" style="color:green;"></span><span id="green"></span>
                                        </div>
                                                                             
                                        
                                    </div>
                                    <div class="col-md-6">

                                         
                                        <div>
                                        <span>Ordered Delayed: </span><span class="fa fa-circle" style="color:orange;"></span><span id="RI"></span>
                                        </div> 
                                         <div>
                                        <span>Ordered: </span><span class="fa fa-circle" style="color:blue;"></span><span id="orange"></span>
                                        </div>
                                    </div>
                                        
                                        
                                                             
                                        
                                    
    								
    							</font>
    						</div>
    						<div class="col-xs-3 text-right leftspan" id="three">
    							<?php 
    							if ($profile=='TV') {
    								echo '<a href="logout.php?logout=logout'.$_SESSION['perfil'].'"><font color="#fff"><i class="fa fa-sign-in"></i> Logout</font></a>';
    							} else {
    								echo $techName;
    							}		
    							?>
    						</div>
    					</div>
    				</font>
                    </div>
                    <div class="panel-body">

                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#tabdashboard" aria-controls="home" role="tab" data-toggle="tab">Dashboard</a></li>
                            <?php  if ($profile=='ADMIN' || $profile=='MANAGERAD' || $profile=='ASSIST'): ?>
                                <li role="presentation"><a href="#tabwriteups" aria-controls="tabwriteups" role="tab" data-toggle="tab">Write Ups</a></li>
                                <li role="presentation" id= "tab-parts"><a href="#tabstatusparts" aria-controls="tabstatusparts" role="tab" data-toggle="tab">Status Parts</a></li>
                                <li role="presentation" id="tab-expenditure"><a href="#tabexpenditure" aria-controls="tabexpenditure" role="tab" data-toggle="tab">Expenditure</a></li>
                            <?php endif; ?>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">

                            <div role="tabpanel" class="tab-pane active" id="tabdashboard">                   

                                <?php if($profile!='TV'): ?>

                                    <div id="custom-toolbar">
                                        <button class="btn btn-default filter" data-tabletarget="#table-dashboard" data-title="Search Request" data-descriptios="(specialist name, status, ro, vin, enggine)" data-filename="dashboard_search" style="margin-left:4px;"><span class="fa fa-search" aria-hidden="true"></span></button>
                                        <button id="buttonApplyFilter" class="btn btn-default" style="margin-left:4px;" onClick='clearObj("input.form-control","filter");'><span class="fa fa-times" aria-hidden="true"></span></button>
                                        <button id="print" class="btn btn-default" style="margin-left:4px;" onclick="dashboardPDF('print')"><span class="fa fa-print" aria-hidden="true"></span></button>
                                        <button id="exportcsv" class="btn btn-default" style="margin-left:4px;" onclick="dashboardCSV()"><span class="fa fa-file-excel-o" aria-hidden="true"></span></button>
                                        <button id="exportpdf" class="btn btn-default" style="margin-left:4px;" onclick="dashboardPDF('view')"><span class="fa fa-file-pdf-o" aria-hidden="true"></span></button>
                                        <?php if($profile=='PARTSP'): ?>
                                          <button id="audio1" class="btn btn-default" style="margin-left:4px;"><span class="fa fa-volume-up" aria-hidden="true"></span></button>
                                        <?php endif; ?>
                                    </div>
                                    
                                <?php endif; ?>

                                <table id="table-dashboard" data-sort-name="idrequest" data-sort-order="asc" data-show-refresh="false" data-show-toggle="false" data-show-columns="false" data-search="<?php if($profile!='TV'){echo 'true';}else{echo 'false';}?>" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-toolbar="#custom-toolbar" data-toolbar-align="right"></table>

                            </div>

                            <?php  if ($profile=='ADMIN' || $profile=='MANAGERAD' || $profile=='ASSIST'): ?>
                                <div role="tabpanel" class="tab-pane" id="tabwriteups">

                                    <?php if($profile!='TV'): ?>

                                        <div id="custom-toolbarwriteups">
                                            <button class="btn btn-default filter" data-tabletarget="#table-writeups" data-title="Search Writeups" data-descriptios="(Employee, Department)" data-filename="writeupsearch" style="margin-left:4px;"><span class="fa fa-search" aria-hidden="true"></span></button>
                                            <button id="buttonApplyFilterwriteups" class="btn btn-default" style="margin-left:4px;" onClick='clearObj("input.form-control","filter");'><span class="fa fa-times" aria-hidden="true"></span></button>
                                            <button id="exportcsvwriteups" class="btn btn-default" style="margin-left:4px;" onclick="writeUpsCSV()"><span class="fa fa-file-excel-o" aria-hidden="true"></span></button>
                                            <?php if($profile=='PARTSP'): ?>
                                              <button id="audio1" class="btn btn-default" style="margin-left:4px;"><span class="fa fa-volume-up" aria-hidden="true"></span></button>
                                            <?php endif; ?>
                                        </div>
                                        
                                    <?php endif; ?>

                                    <table id="table-writeups" data-sort-name="writeupidwriteup" data-sort-order="desc" data-show-refresh="false" data-show-toggle="false" data-show-columns="false" data-search="<?php if($profile!='TV'){echo 'true';}else{echo 'false';}?>" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-toolbar="#custom-toolbarwriteups" data-toolbar-align="right"></table>


                                </div>
                                 <div role="tab" class="tab-pane" id="tabstatusparts">

                                    <?php if($profile!='TV'): ?>

                                        <div id="custom-toolbarwriteups">
                                            <button class="btn btn-default filter" data-tabletarget="#table-writeups" data-title="Search Write ups" data-descriptios="(employee, supervisor, type of violation)" data-filename="wps-search" style="margin-left:4px;"><span class="fa fa-search" aria-hidden="true"></span></button>
                                            <button id="buttonApplyFilterwriteups" class="btn btn-default" style="margin-left:4px;" onClick='clearObj("input.form-control","filter");'><span class="fa fa-times" aria-hidden="true"></span></button>
                                            <button id="exportcsvwriteups" class="btn btn-default" style="margin-left:4px;" onclick="writeUpsCSV()"><span class="fa fa-file-excel-o" aria-hidden="true"></span></button>
                                            <?php if($profile=='PARTSP'): ?>
                                              <button id="audio1" class="btn btn-default" style="margin-left:4px;"><span class="fa fa-volume-up" aria-hidden="true"></span></button>
                                            <?php endif; ?>
                                        </div>
                                        
                                    <?php endif; ?>

                                    <table id="table-statuspart" data-sort-name="statudordparts" data-sort-order="desc" data-show-refresh="false" data-show-toggle="false" data-show-columns="false" data-search="<?php if($profile!='TV'){echo 'true';}else{echo 'false';}?>" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-toolbar="#custom-toolbarwriteups" data-toolbar-align="right"></table>


                                </div>
                                <div role="tab" class="tab-pane" id="tabexpenditure">

                                <?php if($profile!='TV'): ?>

                                    <div id="custom-toolbarexpenditure">
                                        <button class="btn btn-default filter" data-tabletarget="#table-expenditure" data-title="Search Expenditure" data-descriptios="(project name, afe number)" data-filename="expenditure-search" style="margin-left:4px;"><span class="fa fa-search" aria-hidden="true"></span></button>
                                        <button id="buttonApplyFilterexpenditure" class="btn btn-default" style="margin-left:4px;" onClick='clearObj("input.form-control","filter");'><span class="fa fa-times" aria-hidden="true"></span></button>
                                        <button id="#" class="btn btn-default" style="margin-left:4px;" onclick="expenditureCSV()"><span class="fa fa-file-excel-o" aria-hidden="true"></span></button>
                                        <?php if($profile=='PARTSP'): ?>
                                        <button id="audio1" class="btn btn-default" style="margin-left:4px;"><span class="fa fa-volume-up" aria-hidden="true"></span></button>
                                        <?php endif; ?>
                                    </div>
                                    
                                <?php endif; ?>

                                <table id="table-expenditure" data-sort-name="expenditure" data-sort-order="desc" data-show-refresh="false" data-show-toggle="false" data-show-columns="false" data-search="<?php if($profile!='TV'){echo 'true';}else{echo 'false';}?>" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-toolbar="#custom-toolbarwriteups" data-toolbar-align="right"></table>


                                </div>

                            <?php endif; ?>

                        </div>



                    </div>
                </div>				        	
            </div>



        </div>

        <?php  if ($profile=='ADMIN' || $profile=='MANAGERAD' || $profile=='ASSIST'): ?>

            <!-- Inicio Modal -->
            <input type="hidden" id="writeUp"/>
            <div class="modal" id="myModalWriteUp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="background:#009207;">
                            <font color='#fff'>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> New Write up</h4>
                            </font>
                        </div>
                        <div class="modal-body">
                            <div class="col-sm-16">
                                <div class="widget-box">
                                    <div class="widget-body">
                                        <div class="modal-body datagrid table-responsive" >
                                            <center>
                                                <div class="panel-body" id="writeuppartsRequesition">
                                                    <form class="form-horizontal" style="text-align: left;" data-toggle="validator">
                                                        <div class="form-group" id ="selectEmployee">
                                                            <label class="col-md-3 control-label" for="writeupstartdate"><font color='#009207'>* </font>Write up date</label>
                                                            <div class="col-md-3">
                                                                <div class='input-group date' id='datetimepickerWriteUpDate'>
                                                                    <input type='text' id="writeupdate" class="form-control" />
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                                </div>
                                                            </div>                                                  
                                                            <label class="col-md-3 control-label" for="writeupemployee" ><font color='#009207'>* </font>Employee:</label>
                                                            <div class="col-md-3">
                                                                <select name="writeupemployee" id="writeupemployee" class="form-control">    
                                                                    <option value="">-- Select employee --</option>
                                                                    <?php
                                                                        getEmployeeList('', '', 'A', '');
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>                                          
                                                        <div class="form-group" id ="selectSupervisor">
                                                            <label class="col-md-3 control-label" for="department">Department</label>
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control" id="department" placeholder="">
                                                            </div>                                                  
                                                            <label class="col-md-3 control-label" for="writeupsupervisor"><font color='#009207'>* </font>Supervisor:</label>
                                                            <div class="col-md-3">
                                                                <select name="writeupsupervisor" id="writeupsupervisor" class="form-control">    
                                                                    <option value="">-- Select supervisor --</option>
                                                                    <?php
                                                                        getEmployeelist('', '', 'A', '');
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>                                                  
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label" for="senioritydate">Employee seniority date</label>
                                                            <div class="col-md-3">
                                                                <div class='input-group date' id='datetimepickerSeniorityDate'>
                                                                    <input type='text' id="senioritydate" class="form-control" />
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <label class="col-md-3 control-label" for="writeuptradelevel">Trade level</label>
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control" id="writeuptradelevel" placeholder="">
                                                            </div>
                                                        </div>                                                          
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label" for="disaction"><font color='#009207'>* </font> Disciplinary action</label>
                                                            <div class="col-md-9  inputGroupContainer">
                                                                <label class="btn type-options" ><input type="radio" name="disaction" value="Y" checked> Yes </label>                                                       
                                                                <label class="btn type-options" ><input type="radio" name="disaction" value="N"> No </label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group" id ="selectViolationType">
                                                            <label class="col-md-3 control-label" for="writeupviolationtype"><font color='#009207'>* </font>Type of violation:</label>
                                                            <div class="col-md-9">
                                                                    <?php
                                                                        getTypeOfViolation();
                                                                    ?>
                                                                    <div class="width:50%;">
                                                                    <input type='text' class="form-control txtothers" />
                                                                    </div>
                                                            </div>
                                                        </div>      
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label" for="writeuplastwarn">Last warning date</label>
                                                            <div class="col-md-3">
                                                                <div class='input-group date' id='datetimepickerLastWarnDate'>
                                                                    <input type='text' id="writeuplastwarn" class="form-control" />
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <label class="col-md-3 control-label" for="writeuppreviouswarn">Previous warning date</label>
                                                            <div class="col-md-3">
                                                                <div class='input-group date' id='datetimepickerPreviousWarnDate'>
                                                                    <input type='text' id="writeuppreviouswarn" class="form-control" />
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>  
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label" for="writeupwarnings"><font color='#009207'>* </font>Warnings</label>
                                                            <div class="col-md-9  inputGroupContainer">
                                                                <label class="btn type-options" ><input type="radio" name="writeupwarnings" value="1" checked> 1st </label>                                                     
                                                                <label class="btn type-options" ><input type="radio" name="writeupwarnings" value="2"> 2nd </label>
                                                                <label class="btn type-options" ><input type="radio" name="writeupwarnings" value="3"> 3rd </label>
                                                                <label class="btn type-options" ><input type="radio" name="writeupwarnings" value="4"> Termination </label>
                                                            </div>
                                                        </div>                                                      
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label" for="writeupwpstatement">Employer statement:</label>
                                                            <div class="col-md-9">
                                                                <textarea id="writeupwpstatement" class="form-control" rows="3" placeholder=""></textarea>
                                                            </div>
                                                        </div>                                                  
                                                        <div class="form-group" style="display:none">
                                                            <div class="col-md-5  inputGroupContainer" style="padding-left: 0; width:auto; ">
                                                                <div class="input-group">
                                                                    <input type="hidden" id="writeupnew-techId"   name="new-techId" class="form-control" value="<?php echo $techId ?>"   disabled="disabled"/>
                                                                </div>
                                                            </div>
                                                        </div>                                                          

                                                    </form>
                                                </div>
                                            </center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">       
                                <div class="col-xs-12 col-centered" id="cargar_data_writeup" style="display:none;">
                                </div> 
                            </div>
                            <font size="2">All fields marked with <font color='#009207' size="3">*</font> are required.</font>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary red-tooltip fix-bold-tooltip" data-dismiss="modal" data-toggle="tooltip" title="Disscard all Changes"  style="background:#2C3E50;border-color:#2C3E50;">Close</button>
                            <button type="button" id="buttonSaveWriteUp" data-toggle="tooltip" title="Save all changes" class="btn btn-primary buttonSaveWriteUp red-tooltip fix-bold-tooltip" data-typerecord="save" style="background:#2C3E50;border-color:#2C3E50;">Save</button> 
                        </div>                        
                    </div>
                </div>
            </div>
            <!-- Fin Modal -->
            <!-- Fin Button trigger modal -->


            <!-- Inicio Button trigger modal -->
            <!-- Inicio Modal EDIT -->
            <div class="modal modalWriteupShows" id="modal-editwriteup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="background:#009207;">
                            <font color='#fff'>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> Edit Write up Record</h4>
                            </font>
                        </div>
                        <div class="modal-body">
                            <div class="col-sm-16">
                                <div class="widget-box">
                                    <div class="widget-body">
                                        <div class="modal-body datagrid table-responsive" >
                                            <center>
                                                <div class="panel-body" id="partsRequesition">
                                                    <form class="form-horizontal" style="text-align: left;" data-toggle="validator">
                                                        <div class="form-group" id ="selectEmployee">
                                                            <label class="col-md-3 control-label" for="writeupstartdate"><font color='#009207'>* </font>Write up date</label>
                                                            <div class="col-md-3">
                                                                <div class='input-group date' id='editdatetimepickerWriteUpDate'>
                                                                    <input type='text' id="editwriteupdate" class="form-control" disabled="disabled" />
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                                </div>
                                                            </div>                                                  
                                                            <label class="col-md-3 control-label" for="writeupemployee" ><font color='#009207'>* </font>Employee:</label>
                                                            <div class="col-md-3">
                                                                <select name="writeupemployee" id="editwriteupemployee" class="form-control">    
                                                                    <option value="">-- Select employee --</option>
                                                                    <?php
                                                                        getEmployeeList('', '', 'A', '');
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>                                          
                                                        <div class="form-group" id ="selectSupervisor">
                                                            <label class="col-md-3 control-label" for="department">Department</label>
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control" id="editdepartment" placeholder="">
                                                            </div>                                                  
                                                            <label class="col-md-3 control-label" for="writeupsupervisor"><font color='#009207'>* </font>Supervisor:</label>
                                                            <div class="col-md-3">
                                                                <select name="writeupsupervisor" id="editwriteupsupervisor" class="form-control">    
                                                                    <option value="">-- Select supervisor --</option>
                                                                    <?php
                                                                        getEmployeelist('', '', 'A', '');
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>                                                  
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label" for="senioritydate">Employee seniority date</label>
                                                            <div class="col-md-3">
                                                                <div class='input-group date' id='editdatetimepickerSeniorityDate'>
                                                                    <input type='text' id="editsenioritydate" class="form-control" />
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <label class="col-md-3 control-label" for="writeuptradelevel">Trade level</label>
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control" id="editwriteuptradelevel" placeholder="">
                                                            </div>
                                                        </div>                                                          
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label" for="disaction"><font color='#009207'>* </font> Disciplinary action</label>
                                                            <div class="col-md-9  inputGroupContainer">
                                                                <label class="btn type-options" ><input type="radio" name="disaction" value="Y" checked> Yes </label>                                                       
                                                                <label class="btn type-options" ><input type="radio" name="disaction" value="N"> No </label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group" id ="selectViolationType">
                                                            <label class="col-md-3 control-label" for="writeupviolationtype"><font color='#009207'>* </font>Type of violation:</label>
                                                            <div class="col-md-9">
                                                                    <?php
                                                                        getTypeOfViolation();
                                                                    ?>
                                                                    <div class="width:50%;">
                                                                    <input type='text'  class="form-control txtothers" />
                                                                    </div>
                                                            </div>
                                                        </div>      
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label" for="writeuplastwarn">Last warning date</label>
                                                            <div class="col-md-3">
                                                                <div class='input-group date' id='editdatetimepickerLastWarnDate'>
                                                                    <input type='text' id="editwriteuplastwarn" class="form-control" />
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <label class="col-md-3 control-label" for="writeuppreviouswarn">Previous warning date</label>
                                                            <div class="col-md-3">
                                                                <div class='input-group date' id='editdatetimepickerPreviousWarnDate'>
                                                                    <input type='text' id="editwriteuppreviouswarn" class="form-control" />
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>  
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label" for="writeupwarnings"><font color='#009207'>* </font>Warnings</label>
                                                            <div class="col-md-9  inputGroupContainer">
                                                                <label class="btn type-options" ><input type="radio" name="writeupwarnings" value="1" checked> 1st </label>                                                     
                                                                <label class="btn type-options" ><input type="radio" name="writeupwarnings" value="2"> 2nd </label>
                                                                <label class="btn type-options" ><input type="radio" name="writeupwarnings" value="3"> 3rd </label>
                                                                <label class="btn type-options" ><input type="radio" name="writeupwarnings" value="4"> Termination </label>
                                                            </div>
                                                        </div>                                                      
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label" for="writeupwpstatement">Employer statement:</label>
                                                            <div class="col-md-9">
                                                                <textarea id="editwriteupwpstatement" class="form-control" rows="3" placeholder=""></textarea>
                                                            </div>
                                                        </div>                                                  
                                                        <div class="form-group" style="display:none">
                                                            <div class="col-md-5  inputGroupContainer" style="padding-left: 0; width:auto; ">
                                                                <div class="input-group">
                                                                    <input type="hidden" id="editwriteupnew-techId"   name="new-techId" class="form-control" value="<?php echo $techId ?>"   disabled="disabled"/>
                                                                </div>
                                                            </div>
                                                        </div>                                                          
                                                        <input type="hidden" name="writeid" value="">
                                                    </form>
                                                </div>
                                            </center>                                                                                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">       
                                <div class="col-xs-12 col-centered" id="cargar_data_edit" style="display:none;">
                                </div>
                            </div>
                            <font size="2">All fields marked with <font color='#009207' size="3">*</font> are required.</font>
                        </div>        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary red-tooltip fix-bold-tooltip" data-dismiss="modal" data-toggle="tooltip" title="Discard all changes" style="background:#2C3E50;border-color:#2C3E50;">Cancel</button>
                            <button id="buttonSave" data-toggle="tooltip" title="Save all changes" type="button"  class="btn btn-primary buttonSaveWriteUp red-tooltip fix-bold-tooltip" data-typerecord="update" style="background:#2C3E50;border-color:#2C3E50;">Save</button>
                            <button id="buttonSaveClose" type="button" class="btn btn-primary buttonSaveWriteUp red-tooltip fix-bold-tooltip" data-typerecord="saveclose" data-toggle="tooltip" title="Save all changes and block future modifications." style="background:#2C3E50;border-color:#2C3E50;">Save & Close</button>
                        </div>                  
                    </div>
                </div>
            </div>
            <!-- Fin Modal -->


            <!-- Inicio Modal -->
            <div class="modal" id="writeupmodal-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="background:#009207;">
                            <font color='#fff'>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" ><i class="glyphicon glyphicon-user"></i> Delete Write Up Request</h4>
                            </font>
                        </div>
                        <div class="modal-body">
                            <div class="col-sm-16">
                                <div class="widget-box">
                                    <div class="widget-body">
                                        <div class="modal-body datagrid table-responsive" >
                                            <center>
                                                <div class="panel-body">
                                                    <h4 class="comfirmtext">Are you sure you want to delete the record of the <span></span> project?</h4>
                                                </div>
                                            </center>          
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal" style="background:#2C3E50;border-color:#2C3E50;">Cancel</button>
                            <button id="deletewriteup" type="button" class="btn btn-primary" data-record="#" data-user="#" style="background:#2C3E50;border-color:#2C3E50;">Delete</button>
                        </div>                  
                    </div>
                </div>
            </div>

            <div class="modal" id="expendituremodal-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="background:#009207;">
                            <font color='#fff'>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" ><i class="glyphicon glyphicon-user"></i> Delete Expenditure</h4>
                            </font>
                        </div>
                        <div class="modal-body">
                            <div class="col-sm-16">
                                <div class="widget-box">
                                    <div class="widget-body">
                                        <div class="modal-body datagrid table-responsive" >
                                            <center>
                                                <div class="panel-body">
                                                    <h4 class="comfirmtext">Are you sure you want to delete the record of the <span></span> subject?</h4>
                                                </div>
                                            </center>          
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal" style="background:#2C3E50;border-color:#2C3E50;">Cancel</button>
                            <button id="delete-expenditure-button" type="button" class="btn btn-primary" data-record="#" data-user="#" style="background:#2C3E50;border-color:#2C3E50;">Delete</button>
                        </div>                  
                    </div>
                </div>
            </div>
            <!-- Fin Modal -->

        <?php endif; ?>


            
        <!-- Inicio Button trigger modal -->
        <!-- Inicio Modal -->
		<input type="hidden" id="partsRequesition"/>
        <div class="modal in fixmodalbugscss" id="myModalPartsRequesition" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background:#009207;">
						<font color='#fff'>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> New Parts Request</h4>
						</font>
                    </div>
                    <div class="modal-body">
                        <div class="col-sm-16">
                            <div class="widget-box">
                                <div class="widget-body">
                                    <div class="modal-body datagrid table-responsive" >
                                        <center>
                                            <div class="panel-body" id="partsRequesition">
                                                <form class="form-horizontal" style="text-align: left;" data-toggle="validator">
                                                    <div class="form-group">
                                                       
                                                        <div class="col-md-6  inputGroupContainer" style="padding-left: 0;  ">
                                                            <div class="input-group">
                                                                <input type="hidden" id="new-techId"   name="new-techId" class="form-control" value="<?php echo $techId ?>"   disabled="disabled"/>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label" for="requestType"><font color='#009207'>*</font> TYPE </label>
                                                                <div class="col-md-9   inputGroupContainer">
                                                                    <label class="btn type-options" ><input type="radio" name="requestType" value="O" checked> Order </label>														
                                                                    <label class="btn type-options" ><input type="radio" name="requestType" value="Q"> Quote </label>
                                                                    <label class="btn type-options" ><input type="radio" name="requestType" value="9"> 911 </label>
                                                                </div>
                                                            </div>
                                                                    

                                                        </div>
                                                        <label class="col-md-2 control-label" for="techName">TECH NAME</label>
                                                        <div class="col-md-3" style="padding-left: 2%; padding-right: 0%">
                                                            <div class="input-group col-md-12">
                                                                <input type="text" id="new-techName" name="new-techName" class="form-control" value="<?php echo $techName ?>" disabled="disabled"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- -->
                                                
                                                   	
                                                    <!-- -->
                                                    <div class='row'>
                                                        <div class="form-group">
                                                            <label class="col-md-1 control-label fix-margin-label" for="ro" style="padding-left: 6%;"> *RO#</label>
                                                            <div class="col-md-3" style="padding-left: 4.5%;">
                                                                <input type="text" class="form-control" id="ro" placeholder="">
                                                            </div>
                                                        
                                                        
                                                        
                                                        
                                                            <label class="col-md-4 control-label" for="vin">VIN#</label>
                                                            <div class="col-md-3 fix-align-letf">
                                                                <input type="text" class="form-control" id="vin" placeholder="">
                                                            </div>
                                                        </div>
                                                        
                                                    </div>												
                                                    <div class='row'>
                                                    <div class="form-group">
                                                        <label class="col-md-1 control-label fix-margin-label" for="trans" style="padding-left: 4%;">TRANS#</label>
                                                        <div class="col-md-3" style="padding-left: 4.5%;">
                                                            <input type="text" class="form-control" id="trans" placeholder="">
                                                        </div>
                                                        <label class="col-md-4 control-label" for="engine">ENGINE#</label>
                                                        <div class="col-md-3 fix-align-letf">
                                                            <input type="text" class="form-control" id="engine" placeholder="">
                                                        </div>
                                                    </div>
                                                    
                                                    </div>
                                                    <div class='row'>
                                                    <div class="form-group">
                                                        <label class="col-md-1 control-label fix-margin-label" for="comments" style="padding-left: 2%;">COMMENTS:</label>
                                                        <div class="col-md-10" style="padding-left: 4%;">
                                                            <textarea id="comments" class="form-control" rows="3" placeholder="" maxlength=""></textarea>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    
                                                    <div class="form-group col-md-12" style="padding-right:5.5%" >
                                                        <table id="table-parts" data-sort-name="" data-sort-order="asc" data-show-refresh="false" data-show-toggle="false" data-show-columns="false" data-search="false" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-toolbar="" data-toolbar-align="right"></table>
                                                    </div>
                                                    <div class="form-group" style="padding-left: 1.5%; padding-right: 8%;">
                                                        <div class="col-lg-2" style="padding-left: 0;padding-right: 0;display:none;">
                                                            <input type="text" class="form-control" id="parts" placeholder="* PARTS:">
                                                        </div>
                                                        <div class="col-lg-2" style="padding-left: 0;padding-right: 0;">
                                                            <input name="seg" class="form-control" id="seg" placeholder="* SEG:" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" onkeypress="return Onlynumbers(event)" type = "number" maxlength = "15"/>
                                                        </div>
                                                        <div class="col-lg-3" style="padding-left: 0;padding-right: 0;">
                                                            <input type="text" class="form-control" id="description" placeholder="* DESCRIPTION:" maxlength="250">
                                                        </div>
                                                        <div class="col-lg-2" style="padding-left: 0;padding-right: 0;">
                                                            <input name="qty" step="0.01" class="form-control" id="qty" placeholder="* QTY:" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" onkeypress="return Onlynumbers(event)" type = "number" maxlength = "5"/>
                                                        </div>

                                                        <div class="col-lg-5" style="padding-left: 0;padding-right: 0;">
                                                            <input name="comments"  class="form-control" id="commentsparts" placeholder="Comments of Parts" maxlength="250" />
                                                        </div>
                                                        <div class="col-lg-2 input-group date" id="datetimepickerEndDate" style="display:none;">
                                                                <input type="text" id="dateofdelivery" class="form-control dateofdelivery" placeholder="Date of delivery">
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                        </div>

                                                    </div>
                                                    <div class="form-group" style="text-align: right; padding-right: 7.7%;">
                                                        <button id="buttonAddParts" type="button" class="btn btn-primary" style="background:#2C3E50;border-color:#2C3E50;">Add parts</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="row">		
							<div class="col-xs-12 col-centered" id="cargar_data_requesition" style="display:none;" >
								<img src="loader.gif"/>Please wait, sending mail...
							</div>
						</div>
						<font size="2">All fields marked with <font color='#009207' size="3">*</font> are required.</font>
                    </div>
                    <div class="modal-footer" style="padding-right: 2%;">
                        <button type="button" class="btn btn-primary"  onclick="close_modal()" style="background:#2C3E50;border-color:#2C3E50;">Close</button>
                        <button type="button" id="buttonSavePartsRequesition" class="btn btn-primary" style="background:#2C3E50;border-color:#2C3E50;">Save</button> 
                    </div>                        
                </div>
            </div>
        </div>

        <!-- Inicio Modal Expentiture -->
        <div class="modal" id="myModalAuthorizationExpenditure" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                
                <div class="modal-content fix-authorization-width">
                <div class="header-bdi modal-header">
                     Authorization for Expentiture
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="">
                <div class="text-required">
                    All fields marked with<span class="required"> * </span>are required.
                </div>
                <div class="margin-ra title-1">
                    Project Definition
                </div>
                <form>
                    <div class="form-group col-md-6">
                        <label for="projectname">Project Name <span class="required"> * </span></label>
                        <input type="text" class="form-control require" id="project_name" placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="afe_number">AFE Number <span class="required"> * </span></label>
                        <input type="text" class="form-control require" id="afe_number" placeholder="">
                        </div>
                    <div class="form-group col-md-12">
                        <label for="project_description">Project Description</label>
                        <textarea class="form-control rounded-0" id="project_description"></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="start_date">Starting Date <span class="required"> * </span></label>
                        <div>
                            <div class='input-group date'>
                                <input type='text' id="start_date" class="form-control require" />
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="anticipated_date">Anticipated Completion Date</label>
                        <div>
                            <div class='input-group date'>
                                <input type='text' id="anticipated_date" class="form-control" />
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="amount_request">Amount Requested <span class="required"> * </span></label>
                        <input type="text" class="form-control require" id="amount_request" placeholder="000000" onkeypress="return Onlynumbers(event)">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="requested_by">Requested by <span class="required"> * </span></label>
                        <input type="text" class="form-control require" id="requested_by" placeholder="">
                    </div>
                        <div class="form-group col-md-3">
                        <label for="signature">Signature</label>
                        <input type="text" class="form-control" id="request_signature" placeholder="">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="date_signature">Date</label>
                        <div class="input-group date" data-provide="datepicker">
                            <input type="text" class="form-control" id="date_signature">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group margin-ra">
                        <label for="exampleInputName2">Supporting Documentation (attached)</label>
                        <div class="checkbox disabled">
                            <label>
                                <input type="radio" name="optionsRadios" class="documentation" value="quote">
                                Quote
                            </label>
                            <label>
                                <input type="radio" name="optionsRadios" class="documentation" value="estimate">
                                Estimate
                            </label>
                            <label>
                                <input type="radio" name="optionsRadios" class="documentation" value="business_plan">
                                Business Plan
                            </label>
                            <label>
                                <input type="radio" name="optionsRadios" class="documentation"  value="budgeted" value="">
                                Budgeted
                            </label>
                        </div>
                </div>
                <div class="margin-ra title-1">
                    Signing Authority
                </div>
                <div class="margin-ra title-2 ">
                    President
                </div>
                <div class="form-group col-md-4">
                    <label for="exampleInputPassword1">Print Name</label>
                        <input type="text" class="form-control" id="president_print_name" placeholder="">
                </div>
                    <div class="form-group col-md-4">
                        <label for="exampleInputPassword1">Signature</label>
                        <input type="text" class="form-control" id="president_signature" placeholder="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="exampleInputPassword1">Date Approved</label>
                        <div>
                            <div class='input-group date'>
                                <input type='text' id="date_approved_president" class="form-control" />
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="margin-ra title-2">
                        CFO
                    </div>
                    <div class="form-group col-md-4">
                        <label for="exampleInputPassword1">Print Name</label>
                        <input type="text" class="form-control" id="cfo_name" placeholder="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="exampleInputPassword1">Signature</label>
                        <input type="text" class="form-control" id="cfo_signature" placeholder="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="exampleInputPassword1">Date Approved</label>
                        <div>
                            <div class='input-group date'>
                                <input type='text' id="date_approved_cfo" class="form-control" />
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="btn-action">
                <button type="button" class="btn btn btn-danger fix-width" id="cancel-expenditure">Cancel</button>
                <button type="button" class="btn btn-success fix-width" id="save-expenditure">Save</button>
                </div>
            </div>
                </div>
            </div>
           
        </div>

        <!-- Inicio Modal Expentiture Edit -->
        <div class="modal" id="myModalAuthorizationExpenditure-Edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                
                <div class="modal-content fix-authorization-width">
                <div class="header-bdi modal-header">
                     Authorization for Expentiture
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="">
                <div class="text-required">
                    All fields marked with<span class="required"> * </span>are required.
                </div>
                <div class="margin-ra title-1">
                    Project Definition
                </div>
                <form>
                    <div class="form-group col-md-6">
                        <label for="projectname">Project Name <span class="required"> * </span></label>
                        <input type="text" class="form-control require" id="project_name_edit" placeholder="">
                        <input type="hidden" class="form-control require" id="id_expenditure" placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="afe_number">AFE Number <span class="required"> * </span></label>
                        <input type="text" class="form-control require" id="afe_number_edit" placeholder="">
                        </div>
                    <div class="form-group col-md-12">
                        <label for="project_description">Project Description</label>
                        <textarea class="form-control rounded-0" id="project_description_edit"></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="start_date">Starting Date <span class="required"> * </span></label>
                        <div>
                            <div class='input-group date'>
                                <input type='text' id="start_date_edit" class="form-control require fix-date" />
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="anticipated_date">Anticipated Completion Date</label>
                        <div>
                            <div class='input-group date'>
                                <input type='text' id="anticipated_date_edit" class="form-control fix-date" />
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="amount_request">Amount Requested <span class="required"> * </span></label>
                        <input type="text" class="form-control require" id="amount_request_edit" placeholder="000000" onkeypress="return Onlynumbers(event)">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="requested_by">Requested by <span class="required"> * </span></label>
                        <input type="text" class="form-control require" id="requested_by_edit" placeholder="">
                    </div>
                        <div class="form-group col-md-3">
                        <label for="signature">Signature</label>
                        <input type="text" class="form-control" id="request_signature_edit" placeholder="">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="date_signature">Date</label>
                        <div class="input-group date" data-provide="datepicker">
                            <input type="text" class="form-control fix-date" id="date_signature_edit">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group margin-ra">
                        <label for="exampleInputName2">Supporting Documentation (attached)</label>
                        <div class="checkbox disabled">
                            <label>
                                <input type="radio" name="optionsRadios_edit" id='quote' class="documentation" value="quote">
                                Quote
                            </label>
                            <label>
                                <input type="radio" name="optionsRadios_edit" id='estimate' class="documentation" value="estimate">
                                Estimate
                            </label>
                            <label>
                                <input type="radio" name="optionsRadios_edit" id='business_plan' class="documentation" value="business_plan">
                                Business Plan
                            </label>
                            <label>
                                <input type="radio" name="optionsRadios_edit" id='budgeted' class="documentation"  value="budgeted" value="">
                                Budgeted
                            </label>
                        </div>
                </div>
                <div class="margin-ra title-1">
                    Signing Authority
                </div>
                <div class="margin-ra title-2 ">
                    President
                </div>
                <div class="form-group col-md-4">
                    <label for="exampleInputPassword1">Print Name</label>
                        <input type="text" class="form-control" id="president_print_name_edit" placeholder="">
                </div>
                    <div class="form-group col-md-4">
                        <label for="exampleInputPassword1">Signature</label>
                        <input type="text" class="form-control" id="president_signature_edit" placeholder="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="exampleInputPassword1">Date Approved</label>
                        <div>
                            <div class='input-group date'>
                                <input type='text' id="date_approved_president_edit" class="form-control fix-date" />
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="margin-ra title-2">
                        CFO
                    </div>
                    <div class="form-group col-md-4">
                        <label for="exampleInputPassword1">Print Name</label>
                        <input type="text" class="form-control" id="cfo_name_edit" placeholder="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="exampleInputPassword1">Signature</label>
                        <input type="text" class="form-control" id="cfo_signature_edit" placeholder="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="exampleInputPassword1">Date Approved</label>
                        <div>
                            <div class='input-group date'>
                                <input type='text' id="date_approved_cfo_edit" class="form-control fix-date" />
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="btn-action">
                <button type="button" class="btn btn btn-danger fix-width" id="cancel-expenditure_edit">Cancel</button>
                <button type="button" class="btn btn-success fix-width" id="save-expenditure_edit">Save</button>
                </div>
            </div>
                </div>
            </div>
           
        </div>
        <!-- Fin Modal -->
        <div class="modal" id="myModalAuthorizationExpenditure-view" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                
                <div class="modal-content fix-authorization-width">
                <div class="header-bdi modal-header">
                     Authorization for Expentiture
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="">
                <div class="text-required">
                </div>
                <div class="margin-ra title-1">
                    Project Definition
                </div>
                <form>
                    <div class="form-group col-md-6">
                        <label for="projectname">Project Name </label>
                        <div type="text" class="form-control require" id="project_name_view"></div>
                        <input type="hidden" class="form-control require" id="id_expenditure" placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="afe_number">AFE Number </label>
                        <div type="text" class="form-control require" id="afe_number_view" placeholder=""></div>
                        </div>
                    <div class="form-group col-md-12">
                        <label for="project_description">Project Description</label>
                        <div class="form-control rounded-0" id="project_description_view"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="start_date">Starting Date </label>
                        <div>
                            <div class=''>
                            <div type='text' id="start_date_view" class="form-control require fix-date" ></div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="anticipated_date">Anticipated Completion Date</label>
                        <div>
                            <div class=''>
                                <div id="anticipated_date_view" class="form-control fix-date" ></div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="amount_request">Amount Requested </label>
                        <div class="form-control require" id="amount_request_view"></div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="requested_by">Requested by </label>
                        <div class="form-control require" id="requested_by_view"></div>
                    </div>
                        <div class="form-group col-md-3">
                        <label for="signature">Signature</label>
                        <div class="form-control" id="request_signature_view" placeholder=""></div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="date_signature">Date</label>
                        <div class="">
                            <div type="text" class="form-control fix-date" id="date_signature_view"></div>
                            
                        </div>
                    </div>
                    <div class="form-group margin-ra">
                        <label for="exampleInputName2">Supporting Documentation (attached)</label>
                        <div class="checkbox disabled">
                            <div class="form-control" id='documentation'></div>
                        </div>
                </div>
                <div class="margin-ra title-1">
                    Signing Authority
                </div>
                <div class="margin-ra title-2 ">
                    President
                </div>
                <div class="form-group col-md-4">
                    <label for="exampleInputPassword1">Print Name</label>
                        <div class="form-control" id="president_print_name_view" placeholder=""></div>
                </div>
                    <div class="form-group col-md-4">
                        <label for="exampleInputPassword1">Signature</label>
                        <div type="text" class="form-control" id="president_signature_view" placeholder=""></div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="exampleInputPassword1">Date Approved</label>
                        <div>
                            <div>
                                <div type='text' id="date_approved_president_view" class="form-control fix-date"></div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="margin-ra title-2">
                        CFO
                    </div>
                    <div class="form-group col-md-4">
                        <label for="exampleInputPassword1">Print Name</label>
                        <div type="text" class="form-control" id="cfo_name_view" placeholder=""></div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="exampleInputPassword1">Signature</label>
                        <div class="form-control" id="cfo_signature_view" placeholder=""></div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="exampleInputPassword1">Date Approved</label>
                        <div>
                            <div>
                                <div id="date_approved_cfo_view" class="form-control fix-date"></div>
                                
                            </div>
                        </div>
                    </div>
                </form>
                <div class="btn-action">
                <button type="button" class="btn btn btn-danger fix-width" id="cancel-expenditure_view">Close</button>
                </div>
            </div>
                </div>
            </div>
           
        </div>
          <!-- Inicio Modal Expentiture View -->
          
        <!-- Fin Modal -->
        <!-- Fin Modal -->
        <!-- Fin Button trigger modal -->

       <!-- Inicio cambios view - print HERE -->
   
        <!-- Inicio Button trigger modal -->
        <!-- Inicio Modal VIEW-->
        <div class="modal" id="modal-view" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background:#009207;">
						<font color='#fff'>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> View Parts Request</h4>
						</font>
                    </div>
                    <div class="modal-body">
                        <div class="col-sm-16">
                            <div class="widget-box">
                                <div class="widget-body">
                                    <div class="modal-body datagrid table-responsive" >
                                        <center>
                                            <div class="panel-body" id="partsRequesition" style="padding-right: 2% !important">
                                                <form class="form-horizontal" style="text-align: left;">
													<div class="form-group" style="display:none">
                                                        <label class="col-md-3 control-label" for="idrequest">Request ID</label>
                                                        <div class="col-md-9">
															<div id="idRequest" class="form-control"></div>	
                                                        </div>							
                                                    </div>												
													


                                                    
                                                    <div class="row">
                                                        
                                              <div class="form-group">
                                                        <div class="col-md-12 inputGroupContainer">
                                                            <div class="form-group required" id="pruebaImpresion">
                                                        
                                                        <label class="col-md-2 control-label"  for="vin" style="text-align: left !important; padding-right: 4% ! important">REQUEST DATE</label>
                                                        <div class="col-md-3" style="left: -57px; padding-right:4%;" id="div-rd">
                                                            <div class="form-control" id="date-view"></div>
                                                        </div>                         
                                                    </div>
                                                            
                                                        </div>
                                                        <div class="col-md-6  inputGroupContainer" style="padding-left: 0;  ">
                                                           
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label" for="requestType"><font color="#009207">*</font> TYPE </label>
                                                                <div class="col-md-9  inputGroupContainer">
                                                                    <label class="btn type-options"><input type="radio" name="requestType" value="O"> Order </label>                                                        
                                                                    <label class="btn type-options"><input type="radio" name="requestType" value="Q"> Quote </label>
                                                                    <label class="btn type-options"><input type="radio" name="requestType" value="9"> 911 </label>
                                                                </div>
                                                            </div>
                                                        
                                                        </div>
                                                        <label class="col-md-3 control-label" for="techName">TECH NAME</label>
                                                        <div class="col-md-3  inputGroupContainer" style="padding-right: 1.5%;">
                                                            <div class="input-group col-md-12">
                                                                <div id="view-techname"  class="form-control"></div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    </div>

                                                    <div class="row">
                                                    <div class="form-group">
                                                        <label class="col-md-1 control-label fix-margin-label" for="ro" style="padding-left:6%;">*RO#</label>
                                                        <div class="col-md-3" style="padding-left: 4.5%;">
                                                            <div  class="form-control" id="view-ro"></div>
                                                        </div>
                                                    
                                                        <label class="col-md-5 control-label" for="vin">VIN#</label>
                                                        <div class="col-md-3 fix-modal-view">
                                                            <div class="form-control" id="view-vin"></div>
                                                        </div>
                                                    </div>
                                                    </div>												
                                                   <div class='row'>
                                                  <div class="form-group">
                                                        <label class="col-md-1 control-label fix-margin-label" for="trans" style="padding-left: 4%;">TRANS#</label>
                                                        <div class="col-md-3" style="padding-left: 4.5%;">
                                                            <div  class="form-control" id="view-trans"></div>
                                                        </div>
                                                        <label class="col-md-5 control-label " for="engine">ENGINE#</label>
                                                        <div class="col-md-3 fix-modal-view">
                                                            <div class="form-control" id="view-engine" ></div>                                                               
                                                       </div>

                                                    </div>

                                                   </div>
                                                    <div class='row'>
                                                   <div class="form-group" style="padding-left: 0.6%;">
                                                        <label class="col-md-1 control-label fix-margin-label" for="comments" style="padding-left: 3%;">COMMENTS:</label>
                                                        <div class="col-md-11" style="padding-left:4%; padding-right:1.5%;">
                                                            <div id="view-comments" class="form-control" style="word-break: break-word;"></div>
                                                        </div>
                                                    </div>                                              

                                                    </div>
                                                  
                                                    <div class="form-group">
                                                        <table id="table-parts" data-sort-name="" data-sort-order="asc" data-show-refresh="false" data-show-toggle="false" data-show-columns="false" data-search="false" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-toolbar="" data-toolbar-align="right"></table>
                                                    </div>
                                                </form>
                                            </div>
                                        </center>                                                                                                            
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="row">		
							<div class="col-xs-12 col-centered" id="cargar_data_edit" style="display:none;">
								<img src="loader.gif"/>Please wait, sending mail...
							</div>
						</div>
                    </div>        
                    <div class="modal-footer">					
						<button type="button" class="btn btn-primary" data-dismiss="modal" style="background:#2C3E50;border-color:#2C3E50;" id="btnSendPDF" onclick="sendPDF()">Send PDF</button>
						<button type="button" class="btn btn-primary" data-dismiss="modal" style="background:#2C3E50;border-color:#2C3E50;" id="print" onclick="printpdf()">Print</button>
						<button type="button" class="btn btn-primary" data-dismiss="modal" style="background:#2C3E50;border-color:#2C3E50;">Close</button>
                    </div>                  
                </div>
            </div>
		</div>
        <!-- Fin Modal -->     
        <!-- Modal details-->     
        <div class="modal" id="modal-details" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background:#009207;">
						<font color='#fff'>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> Details of Request</h4>
						</font>
                    </div>
                    <div class="modal-body">
                        <div class="col-sm-16">
                            <div class="widget-box">
                                <div class="widget-body">
                                    <div class="modal-body datagrid table-responsive" >
                                        <center>
                                            <div class="panel-body" id="partsRequesition">
                                                <table id="table-parts-details" data-sort-name="parts-details" data-sort-order="desc" data-show-refresh="false" data-show-toggle="false" data-show-columns="false" data-search="false" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" ></table>
                                            </div>
                                        </center>                                                                                                            
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="row">		
							<div class="col-xs-12 col-centered" id="cargar_data_edit" style="display:none;">
								<img src="loader.gif"/>Please wait, sending mail...
							</div>
						</div>
                    </div>        
                    <div class="modal-footer">					
						
						<button type="button" class="btn btn-primary" data-dismiss="modal" style="background:#2C3E50;border-color:#2C3E50;">Close</button>
                    </div>                  
                </div>
            </div>
		</div>                                                                                                                                                                                    
        <!-- Modal details end -->
        <!-- Modal parts-log -->
        <div class="modal" id="modal-parts-log" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background:#009207;">
						<font color='#fff'>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> Details of Part</h4>
						</font>
                    </div>
                    <div class="modal-body">
                        <div class="col-sm-16">
                            <div class="widget-box">
                                <div class="widget-body">
                                    <div class="modal-body datagrid table-responsive" >
                                        <center>
                                            <div class="panel-body" id="partsRequesition">
                                                <table id="table-parts-log" data-sort-name="parts-log" data-sort-order="desc" data-show-refresh="false" data-show-toggle="false" data-show-columns="false" data-search="false" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" ></table>
                                            </div>
                                        </center>                                                                                                            
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="row">		
							<div class="col-xs-12 col-centered" id="cargar_data_edit" style="display:none;">
								<img src="loader.gif"/>Please wait, sending mail...
							</div>
						</div>
                    </div>        
                    <div class="modal-footer">					
						
						<button type="button" class="btn btn-primary" data-dismiss="modal" style="background:#2C3E50;border-color:#2C3E50;">Close</button>
                    </div>                  
                </div>
            </div>
		</div>                          
        <!-- End Modal parts log -->
        <!-- Fin Button trigger modal -->
		
		<!-- Inicio Button trigger modal -->
        <!-- Inicio Modal SEND MESSAGE-->
        <div class="modal" id="myModalSendMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background:#009207;">
						<font color='#fff'>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> Send Message</h4>
						</font>
                    </div>
                    <div class="modal-body">
                        <div class="col-sm-16">
                            <div class="widget-box">
                                <div class="widget-body">
                                    <div class="modal-body datagrid table-responsive" >
                                        <center>
                                            <div class="panel-body" id="partsRequesition">
                                                <form class="form-horizontal" style="text-align: left;" data-toggle="validator">
													<div class="form-group">
														<div class="col-md-12">
                                                        <h4>Send Message to Groups</h4>
															<!--	<label class="btn btn-default" ><input type="radio" name="optradio" value="Group"> Group</label>
																<label class="btn btn-default" ><input type="radio" name="optradio" value="User"> User</label>
														</div>-->
													</div>

                                                    <div class="form-group" id ="selectGroup">
                                                        <label class="col-md-3 control-label" for="techName" style="padding-top:0px !important"><font color='#009207'>*</font>To:</label>
                                                        <div class="col-md-9">
									<select name="selectName" id="selectName">    
										<option value="">-- Select group --</option>
										<?php
											getGroups('A');
										?>
									</select>

                                                        </div>
						    </div>
                                                    <div class="form-group" id ="selectSingle">
							<label class="col-md-3 control-label" for="techName" style="padding-top:0px !important"><font color='#009207'>*</font>To:</label>
                                                        <div class="col-md-9">
									<select name="selectNameU" id="selectNameU">    
										<option value="" selected="selected">-- Select user name --</option>
										<?php
											getlistUser('', '', 'A', '');
										?>
									</select>
                                                        </div>

                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" for="comments"><font color='#009207'>*</font> Comments:</label>
                                                        <div class="col-md-9">
                                                            <textarea id="msg-comments" class="form-control" rows="3" placeholder=""></textarea>
															<input type="hidden" id="labelMessage" name="labelMessage" class="form-control" value="" disabled="disabled"/>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </center>                                                                                                           
                                    </div>
                                </div>
                            </div>
                        </div>
						<font size="2">All fields marked with <font color='#009207' size="3">*</font> are required.</font>
                    </div>  
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" style="background:#2C3E50;border-color:#2C3E50;">Close</button>
                        <button type="button" id="buttonSendMessage" class="btn btn-primary" style="background:#2C3E50;border-color:#2C3E50;">Send</button> 
                    </div>                        
                </div>
            </div>
        </div>
        <!-- Fin Modal -->
        <!-- Fin Button trigger modal -->
         
 
            
        <!-- Inicio Button trigger modal -->
        <!-- Inicio Modal -->
        <div class="modal" id="modal-assign" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background:#009207;">
						<font color='#fff'>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> Assign Parts Request</h4>
						</font>
					</div>
                    <div class="modal-body">
                        <div class="col-sm-16">
                            <div class="widget-box">
                                <div class="widget-body">
                                    <div class="modal-body datagrid table-responsive" >
                                        <center>
                                            <div class="panel-body" style="min-height:150px">
                                                <input type="hidden" id="assign-techName" 		name="assign-techName" 	value="<?php echo $techName ?>" disabled="disabled"/>
                                                <input type="hidden" id="assign-techId" 		name="assign-techId" 		value="<?php echo $techId ?>" 	disabled="disabled"/>
                                                <input type="hidden" id="idRequest" 	name="idRequest" 	value="" 						disabled="disabled"/>
												<input type="hidden" id="jobnumber"   	name="jobnumber"    value=""                 		disabled="disabled"/>
                                                <div class="form-group">
                                                    <div class="dropdown">
                                                        <button class="btn btn-default dropdown-toggle col-md-12" type="button" data-toggle="dropdown">
                                                            SPECIALIST:
                                                            <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" id="specialist"></ul>
                                                    </div>
                                                </div>
                                                <br>
                                                <br>
                                                <h4 id="titulo"></h4>
                                            </div>
                                        </center>                                                                                                         
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" style="background:#2C3E50;border-color:#2C3E50;">Close</button>
                        <button id="buttonAssignPartsRequesition" type="button" class="btn btn-primary" style="background:#2C3E50;border-color:#2C3E50;">Assign</button>
                    </div>                  
                </div>
            </div>
        </div>
        <!-- Fin Modal -->  

        <!-- Inicio Modal PARTSP Assign -->
        <div class="modal" id="modal-assignsp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background:#009207;">
						<font color='#fff'>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> Assign Parts Request</h4>
						</font>
                    </div>
                    <div class="modal-body">
                        <div class="col-sm-16">
                            <div class="widget-box">
                                <div class="widget-body">
                                    <div class="modal-body datagrid table-responsive" >
                                        <center>
                                            <div class="panel-body">
                                                <input type="hidden" id="assignsp-techName" name="assignsp-techName" value="<?php echo $techName ?>" disabled="disabled"/>
                                                <input type="hidden" id="assignsp-techId"   name="assignsp-techId"   value="<?php echo $techId ?>"   disabled="disabled"/>
												<input type="hidden" id="idRequest" name="idRequest" value="" disabled="disabled"/>
												<input type="hidden" id="jobnumber" name="jobnumber" value="" disabled="disabled"/>
                                                <h4 id="title"></h4>
                                            </div>
                                        </center>                                                                                                                                                                                                                                                                  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" style="background:#2C3E50;border-color:#2C3E50;">Close</button>
                        <button id="buttonAssignPartsRequesitionSp" type="button" class="btn btn-primary" style="background:#2C3E50;border-color:#2C3E50;">Assign</button>
                    </div>                  
                </div>
            </div>
        </div>
        <!-- Fin Modal PARTSP Assign--> 

        <!-- Inicio Button trigger modal -->
        <!-- Inicio Modal -->
        <div class="modal" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background:#009207;">
						<font color='#fff'>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> Delete Parts Request</h4>
						</font>
                    </div>
                    <div class="modal-body">
                        <div class="col-sm-16">
                            <div class="widget-box">
                                <div class="widget-body">
                                    <div class="modal-body datagrid table-responsive" >
                                        <center>
                                            <div class="panel-body">
                                                <input type="hidden" id="del-techName" name="del-techName" value="<?php echo $techName ?>" disabled="disabled"/>
                                                <input type="hidden" id="del-techId"   name="del-techId"   value="<?php echo $techId ?>"   disabled="disabled"/>
                                                <h4 id="titulo"></h4>
                                            </div>
                                        </center>                                                                                                                                                                                                                                                                  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" style="background:#2C3E50;border-color:#2C3E50;">Close</button>
                        <button id="buttonDeletePartsRequesition" type="button" class="btn btn-primary" style="background:#2C3E50;border-color:#2C3E50;">Delete</button>
                    </div>                  
                </div>
            </div>
        </div>
        <!-- Fin Modal -->
		
        <!-- Fin Button trigger modal -->
            
        <!-- Inicio Button trigger modal -->
        <!-- Inicio Modal EDIT -->
        <div class="modal in fixmodalbugscss" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background:#009207;">
						<font color='#fff'>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> Edit Parts Request</h4>
						</font>
                    </div>
                    <div class="modal-body">
                        <div class="col-sm-16">
                            <div class="widget-box">
                                <div class="widget-body">
                                    <div class="modal-body datagrid table-responsive" >
                                        <center>
                                            <div class="panel-body" id="partsRequesition">
                                                <form class="form-horizontal" style="text-align: left;">
                                                    <div class="form-group">
                                                        
                                                        <div class="col-md-6  inputGroupContainer" style="padding-left: 0;  ">
                                                            <div class="input-group">
                                                                <input type="hidden" id="edit-techId"   name="edit-techId" class="form-control" value="<?php echo $techId ?>"   disabled="disabled"/>
                                                                <input type="hidden" id="idRequest"   name="idRequest"    value=""                        disabled="disabled"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-3 control-label" for="requestType"><font color='#009207'>*</font> TYPE </label>
                                                                <div class="col-md-6  inputGroupContainer">
                                                                    <label class="btn type-options" ><input type="radio"  class="secure" name="requestType" value="O" id='order'> Order </label>														
                                                                    <label class="btn type-options" ><input type="radio" class="secure"  name="requestType" value="Q" id='quote'> Quote </label>
                                                                    <label class="btn type-options" ><input type="radio" class="secure"  name="requestType" value="9" id='911'> 911 </label>
                                                                </div>
                                                                <div class="col-md-3  inputGroupContainer">
                                                                   <label for="status_order">Status Order</label>
                                                                   <select name="status_order" id="reqstatus">
                                                                       
                                                                   </select>
                                                                </div>
                                                            </div>
                                                        
                                                        </div>
                                                        <label class="col-md-2 control-label" for="techName">TECH NAME</label>
                                                        <div class="col-md-3  inputGroupContainer" style="padding-right: 0;">
                                                            <div class="input-group col-md-12">
                                                                <input type="text" id="edit-techName" name="edit-techName" class="form-control" disabled="disabled"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                  	
                                                    <div class="row">
                                                    <div class="form-group">
                                                        <label class="col-md-1 control-label fix-margin-label" for="ro" style="padding-left:6%;">*RO#</label>
                                                        <div class="col-md-3" style="padding-left: 4.5%;">
                                                            <input type="text" class="form-control secure" id="edit-ro" placeholder="">
                                                        </div>
                                                    
                                                        <label class="col-md-4 control-label" for="vin">VIN#</label>
                                                        <div class="col-md-3 fix-align-letf" id="div-edit-vin">
                                                            <input type="text" class="form-control secure" id="edit-vin" placeholder="">
                                                        </div>
                                                    </div>
                                                    </div>												
                                                    <div class="row">
                                                    <div class="form-group">
                                                        <label class="col-md-1 control-label fix-margin-label" for="trans" style="padding-left: 4%;">TRANS#</label>
                                                        <div class="col-md-3" style="padding-left: 4.5%;">
                                                            <input type="text" class="form-control secure" id="edit-trans" placeholder="">
                                                        </div>
                                                        <label class="col-md-4 control-label" for="engine">ENGINE#</label>
                                                        <div class="col-md-3 fix-align-letf">
                                                            <input type="text" class="form-control secure" id="edit-engine" placeholder="">                                                               
                                                       </div>

                                                    </div>
                                                    <div class="row">
                                                    <div class="form-group" style="padding-left: 2%;" >
                                                        <label class="col-md-1 control-label fix-margin-label" for="comments" style="padding-left: 3%;">COMMENTS:</label>
                                                        <div class="col-md-10" style="padding-left:4%; padding-right:2.5%;">
                                                            <textarea id="edit-comments" class="form-control secure" rows="3" placeholder=""></textarea>
                                                        </div>
                                                    </div>

                                                    </div>
                                                   
                                                    <div class="form-group fixed-calendar" style="padding-right:9.5%; padding-left: 4%;">
                                                        <table id="table-parts" data-sort-name="" data-sort-order="asc" data-show-refresh="false" data-show-toggle="false" data-show-columns="false" data-search="false" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-toolbar="" data-toolbar-align="right"></table>
                                                    </div>
                                                    <div class="form-group" id="newpart-container" style="padding-left: 4%; padding-right: 9%;">                                                        
                                                        <div class="col-lg-2" style="padding-left: 0;padding-right: 0;display:none;">
                                                            <input type="text" class="form-control" id="edit-parts" placeholder="* PARTS:">
                                                        </div>
                                                        <div class="col-lg-2" style="padding-left: 0;padding-right: 0;">
                                                            <input name="edit-seg" class="form-control" id="edit-seg" placeholder="* SEG:" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" onkeypress="return Onlynumbers(event)" type = "number" maxlength = "10"/>
                                                        </div>
                                                        <div class="col-lg-3" style="padding-left: 0;padding-right: 0;">
                                                            <input type="text" class="form-control" id="edit-description" placeholder="* DESCRIPTION:" maxlength="250">
                                                        </div>
                                                        <div class="col-lg-2" style="padding-left: 0;padding-right: 0;">
                                                            <input name="edit-qty" step="0.01"  class="form-control" id="edit-qty" placeholder="* QTY:" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" onkeypress="return Onlynumbers(event)" type = "number" maxlength = "5"/>
                                                        </div>
                                                        <div class="col-lg-5" style="padding-left: 0;padding-right: 0;">
                                                            <input name="comments"  class="form-control" id="commentspartsedit" placeholder="Comments of Parts" maxlength="250"  />
                                                        </div>
                                                        <div class="col-lg-2 input-group date" id="datetimepickerdeliveryDate" style="display:none";>
                                                                <input type="text" id="editdateofdelivery" class="form-control dateofdelivery" placeholder="Date of delivery">
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                        </div>
                                                    </div>

                                                    
                                                    <div class="form-group pull-right" style="padding-right:9%;">
														<button id="buttonAddPartsE" type="button" class="btn btn-primary" style="background:#2C3E50;border-color:#2C3E50;">Add parts</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </center>                                                                                                            
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="row">		
							<div class="col-xs-12 col-centered" id="cargar_data_edit" style="display:none;">
								<img src="loader.gif"/>Please wait, sending mail...
							</div>
						</div>
						<font size="2">All fields marked with <font color='#009207' size="3">*</font> are required.</font>
                    </div>        
                    <div class="modal-footer" style="padding-right:2%;">
                        <button type="button" id="close-edit" class="btn btn-primary" onclick="" style="background:#2C3E50;border-color:#2C3E50;">Close</button>
                        <button id="buttonSave" type="button" class="btn btn-primary" style="background:#2C3E50;border-color:#2C3E50;" disabled>Save</button>
                    </div>                  
                </div>
            </div>
        </div>
        <!-- Fin Modal -->

		<!-- Inicio Button trigger modal -->
        <!-- Inicio Modal -->
        <div class="modal" id="modal-close" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background:#009207;">
						<font color='#fff'>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> Close Parts Requesition</h4>
						</font>
                    </div>
                    <div class="modal-body">
                        <div class="col-sm-16">
                            <div class="widget-box">
                                <div class="widget-body">
                                    <div class="modal-body datagrid table-responsive" >
                                        <center>
                                            <div class="panel-body">
                                                <input type="hidden" id="close-techName" name="close-techName" value="<?php echo $techName ?>" disabled="disabled"/>
                                                <input type="hidden" id="close-techId"   name="close-techId"   value="<?php echo $techId ?>"   disabled="disabled"/>
                                                <h4 id="titulo"></h4>
                                            </div>
                                        </center>                                                                                                                                                                                                                                                                  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" style="background:#2C3E50;border-color:#2C3E50;">Cancel</button>
                        <button id="buttonClosePartsRequesition" type="button" class="btn btn-primary" style="background:#2C3E50;border-color:#2C3E50;">Close Request</button>
                    </div>                  
                </div>
            </div>
        </div>
        <!-- Fin Modal -->
                                                                    
        <!-- Fin Button trigger modal -->
		
		<!-- Inicio Button trigger modal -->
        <!-- Inicio Modal -->
        <div class="modal" id="modal-filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background:#009207;">
						<font color='#fff'>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> Search Request</h4>
						</font>
                    </div>
                    <div class="modal-body">
                        <div class="col-sm-16">
                            <div class="widget-box">
                                <div class="widget-body">
                                    <div class="modal-body datagrid table-responsive" >
                                        <center>
                                            <div class="panel-body" id="partsRequesition">
                                                <form class="form-horizontal" style="text-align: left; height: 200px" data-toggle="validator">
                                                    <div class="form-group"  style="display:none;">
                                                        <label class="col-md-3 control-label" for="techName">Tech name</label>
                                                        <div class="col-md-4  inputGroupContainer" style="padding-right: 0;">
                                                            <div class="input-group">
																<input type="text" id="techId" name="techId" class="form-control"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" for="startdate">Start Date</label>
                                                        <div class="col-md-9">
                                                            <div class='input-group date' id='datetimepickerStartDate'>
                                                                <input type='text' id="startdate" class="form-control" />
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label" for="enddate">End Date</label>
                                                        <div class="col-md-9">
                                                            <div class='input-group date' id='datetimepickerEndDate1'>
                                                                <input type='text' id="enddate" class="form-control" />
                                                                <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group" style="display:none;">
                                                        <label class="col-md-3 control-label" for="jobnumber">Job Number</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" id="jobnumber" placeholder="">
                                                        </div>
                                                    </div>
													<div class="form-group">
                                                        <label class="col-md-3 control-label" for="keyword">Key Word</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" id="keyword" placeholder="">
															<span class="modal-footdescription"></span>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </center>                                                                                                           
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" style="background:#2C3E50;border-color:#2C3E50;">Close</button>
                        <button type="button" id="buttonApplyFilter" data-tabletarget="" data-filename="" class="btn btn-primary" style="background:#2C3E50;border-color:#2C3E50;">Filter</button>
                    </div>                       
                </div>
            </div>
        </div>
		
        <!-- Fin Modal -->
		
        <!-- Inicio Button trigger modal -->
        <!-- Inicio Modal -->
        <div class="modal" id="modal-adminUsers" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="background:#009207;">
						<font color='#fff'>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> Admin User</h4>
						</font>
                    </div>
                    <div class="modal-body">
                        <div class="col-sm-16">
                            <div class="widget-box">
                                <div class="widget-body">
                                    <div class="modal-body datagrid table-responsive" >
                                        <center>
                                            <div class="panel-body" id="partsRequesition">
                                                <form class="form-horizontal" style="text-align: left;">
                                                    <input type="hidden" id="adminu-techName" name="adminu-techName" class="form-control" value="<?php echo $techName ?>" disabled="disabled"/>
                                                    <input type="hidden" id="adminu-techId"   name="adminu-techId" class="form-control" value="<?php echo $techId ?>"   disabled="disabled"/>
                                                    <div class="form-group">
                                                        <table id="table-userDashboard" data-sort-name="" data-sort-order="asc" data-show-refresh="false" data-show-toggle="false" data-show-columns="false" data-search="true" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-toolbar="" data-toolbar-align="right" data-page-size="5"></table>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-lg-4" style="padding-left: 0;padding-right: 0;">
                                                            <input type="text" class="form-control" id="idUser" placeholder="* Id User:">
                                                        </div>
                                                        <div class="col-lg-4" style="padding-left: 0;padding-right: 0;">
                                                            <input type="text" class="form-control" id="surName" placeholder="* Name:">
                                                        </div>
                                                        <div class="col-lg-4" style="padding-left: 0;padding-right: 0;">
                                                            <input type="text" class="form-control" id="lastName" placeholder="* lastName:">
                                                        </div>
                                                    </div>
													<div class="form-group">
                                                        <div class="col-lg-3" style="padding-left: 0;padding-right: 0;">
                                                            <input type="password" class="form-control" id="password" placeholder="* Password:">
                                                        </div>
														<div class="col-lg-3" style="padding-left: 0;padding-right: 0;">
                                                            <input type="text" class="form-control" id="phonenum" placeholder="Phone:">
                                                        </div>
                                                        <div class="col-lg-3" style="padding-left: 0;padding-right: 0;">
                                                            <select class="form-control" id="idUserType" change="alert('pruebas');"></select>
                                                        </div>
                                                        <div class="col-lg-3" style="padding-left: 0;padding-right: 0;">
                                                            <select class="form-control" id="idRol"></select>
                                                        </div>
                                                    </div>
													<div class="form-group">
                                                        <div class="col-lg-3" style="padding-left: 0;padding-right: 0;">
                                                            <select multiple class="form-control" id="idGroup" style="display: block !important;" ></select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group pull-right">
                                                        <button id="buttonAddUser" type="button" class="btn btn-primary" style="background:#2C3E50;border-color:#2C3E50;">Add user</button>
														<div class="col-lg-7" style="padding-left: 0;padding-right: 0;">
                                                        <button id="buttonEditUser" type="button" class="btn btn-primary" style="display:none;background:#2C3E50;border-color:#2C3E50;">Save user</button>
														</div>
														<div class="col-lg-3" style="padding-left: 0;padding-right: 0;">
                                                        <button id="buttonCancelEdit" type="button" class="btn btn-primary" style="display:none;background:#2C3E50;border-color:#2C3E50;">Cancel</button>
														</div>
                                                    </div>


													<div class="modal" id="modal-deluser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header" style="background:#009207;">
																	<font color='#fff'>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																	<h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> Delete User</h4>
																	</font>
																</div>
																<div class="modal-body">
																	<div class="col-sm-16">
																		<div class="widget-box">
																			<div class="widget-body">
																				<div class="modal-body datagrid table-responsive" >
																					<center>
																						<div class="panel-body">
																							<input type="hidden" id="iduser" name="idUser" value="" disabled="disabled"/>
																							<input type="hidden" id="deluser-techId"   name="deluser-techId"   value="<?php echo $techId ?>"   disabled="disabled"/>
																							<h4 id="titulo"></h4>
																						</div>
																					</center>                                                                                                                                                                                                                                                                  
																				</div>
																			</div>
																		</div>
																	</div>
																</div>        
																<div class="modal-footer">
																	<button type="button" id="buttonCloseDeleteUser" class="btn btn-primary" style="background:#2C3E50;border-color:#2C3E50;">Close</button>
																	<button id="buttonDeleteUser" type="button" class="btn btn-primary" style="background:#2C3E50;border-color:#2C3E50;">Delete</button>
																</div>                  
															</div>
														</div>
													</div>

                                                </form>
                                            </div>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" style="background:#2C3E50;border-color:#2C3E50;">Close</button>
                    </div>                  
                </div>
            </div>
        </div>
        <!-- Fin Modal -->                                                
        <!-- Fin Button trigger modal -->

	
        <!-- Inicio Button trigger modal groups-->
        <!-- Inicio Modal GROUPS -->


        <div class="modal" id="modal-adminGroups" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="background:#009207;">
						<font color='#fff'>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> Admin Groups</h4>
						</font>
                    </div>
                    <div class="modal-body">
                        <div class="col-sm-16">
                            <div class="widget-box">
                                <div class="widget-body">
                                    <div class="modal-body datagrid table-responsive" >
                                        <center>
                                            <div class="panel-body" id="grouplist">
                                                <form class="form-horizontal" style="text-align: left;">
                                                    <input type="hidden" id="admgr-techName" name="admgr-techName" class="form-control" value="<?php echo $techName ?>" disabled="disabled"/>
                                                    <input type="hidden" id="admgr-techId"   name="admgr-techId" class="form-control" value="<?php echo $techId ?>"   disabled="disabled"/>
                                                    <div class="form-group">
                                                        <table id="table-GroupsDashboard" data-sort-name="" data-sort-order="asc" data-show-refresh="false" data-show-toggle="false" data-show-columns="false" data-search="false" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-toolbar="" data-toolbar-align="right"></table>
                                                    </div>
                                                    <div class="form-group">

                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="name" placeholder="* Name:">
                                                               <span class="input-group-addon">-</span>
                                                            <input type="text" class="form-control input-number" maxlength=15 id="phonenumber" placeholder=" Phonenumber:">

                                                        </div>
                                                    </div>													
                                                    <div class="form-group pull-right">
                                                        <button id="buttonAddGroup" type="button" class="btn btn-primary" style="background:#2C3E50;border-color:#2C3E50;">Add group</button>
                                                        
							<div class="col-lg-7" style="padding-left: 0;padding-right: 0;">
                                                        <button id="buttonEditGroup" type="button" class="btn btn-primary" style="display:none;background:#2C3E50;border-color:#2C3E50;">Save group</button>
							</div>
							<div class="col-lg-3" style="padding-left: 0;padding-right: 0;">
                                                        <button id="buttonCancelGroup" type="button" class="btn btn-primary" style="display:none;background:#2C3E50;border-color:#2C3E50;">Cancel</button>
							</div>
                                                    </div>
													<div class="modal" id="modal-delgroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header" style="background:#009207;">
																	<font color='#fff'>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																	<h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-user"></i> Delete Group</h4>
																	</font>
																</div>
																<div class="modal-body">
																	<div class="col-sm-16">
																		<div class="widget-box">
																			<div class="widget-body">
																				<div class="modal-body datagrid table-responsive" >
																					<center>
																						<div class="panel-body">
																							<input type="hidden" id="idgroup" name="idgroup" value="" disabled="disabled"/>
																							<input type="hidden" id="delgroup-techId"   name="delgroup-techId"   value="<?php echo $techId ?>"   disabled="disabled"/>
																							<h4 id="titulo"></h4>
																						</div>
																					</center>                                                                                                                                                                                                                                                                  
																				</div>
																			</div>
																		</div>
																	</div>
																</div>        
																<div class="modal-footer">
																	<button type="button" class="btn btn-primary" data-dismiss="modal" style="background:#2C3E50;border-color:#2C3E50;">Close</button>
																	<button id="buttonDeleteGroup" type="button" class="btn btn-primary" style="background:#2C3E50;border-color:#2C3E50;">Delete</button>
																</div>                  
															</div>
														</div>
													</div>

                                                </form>
                                            </div>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" style="background:#2C3E50;border-color:#2C3E50;">Close</button>
                    </div>                  
                </div>
            </div>
        </div>
        <!-- Fin Modal -->                                                
        <!-- Fin Button trigger modal groups -->



		<script src="js/jquery-1.11.2.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/collapse.js" type="text/javascript"></script>
        <script src="js/transition.js" type="text/javascript"></script>
        <script src="js/moment-with-locales.js" type="text/javascript"></script>
        <script src="js/bootstrap-table.js" type="text/javascript"></script>
        <script src="locale/bootstrap-table-en-US.js" type="text/javascript"></script>
        <script src="js/jquery.blink.js" type="text/javascript"></script>
        <script src="js/bootstrapvalidator.min.js" type="text/javascript"></script>
        <script src="js/ion.sound.min.js" type="text/javascript"></script>
        <script src="js/bootstrap-datetimepicker.js" type="text/javascript"></script>
        <script src="js/ajax.js" type="text/javascript"></script>
        <script src="js/jspdf.debug.js" type="text/javascript"></script>
     
        
        <?php
			/* SCRIPTS */
            require_once('templates/views/viewScriptsDashboard.php');
            require_once('templates/views/viewScrptAuthorizationforExpenditure.php');
            if ($profile=='ADMIN' || $profile=='MANAGERAD' || $profile=='ASSIST') {
                require_once('templates/views/viewScriptsWriteUps.php');
            }

        ?>

		
		<style type="text/css">
		   @media screen {
				#printSection {
				   display: none;
				}
		   }

		   @media print {
				body > *:not(#printSection) {
				   display: none;
				}
				#printSection, #printSection * {
					visibility: visible;
				}
				#printSection {
					position:absolute;
					left:0;
					top:0;
				}
		   }
		</style>
    </body>
</html>
