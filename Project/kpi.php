<?php 
include_once'./process/processClass.php';
include_once'./department/departmentClass.php';
include_once'./risk/riskClass.php';
include_once'./raf/kriClass.php';

$kriclass=new kriClass();
$showkri=$kriclass->fetchkri();

$riskclass=new riskClass();
$showrisk= $riskclass->showRisk();

//display process details
$processClass=new processClass();
$showprocess=$processClass->showProcess();


?>
<!DOCTYPE html>
<html lang="en">
<!-_________________Header location______________________->
<?php include_once'../layout/header.php'; ?>

<body>
    <div id="app">
        <div id="main" class="layout-horizontal">

 <!-_________________Navigation location______________________->

 <?php include_once'../layout/nav.php'; ?>

            <div class="content-wrapper container">
                
<div class="page-heading">
    <h4>Add Key Indicator</h4>
</div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
    <!-_________________Content location BEGINING______________________->
                <style>
                    tr,td{
                        font-size:13px;
                        font-weight: 600;
                        color: #000;
                    }
                    label{
                        font-size: 13px;
                        font-weight: 800;
                        color: #000;
                    }
                    .form-control,.form-select,.choices{
                        font-size: 13px;
                    }
                </style>
                <section class="section">
                <!--<form id="convert_form" >-->
                    <div class="card">
                        <div class="card-header">
                            <!--<input type="hidden" name="file_content" id="file_content">-->
                            <button onclick="location.href='../Project/addkeyindicator.php'" type="button" class="btn btn-primary btn-userpermission-add" style="float:right;margin-right:30px;">
                            <span class="fa-fw select-all fas">ï•</span>Add KPI</button>
                            <!--<a href="../Project/addkeyindicator" class="btn btn-primary" style="float:right;margin-right:30px;">
                            <span class="fa-fw select-all fas">ï•</span>Add KPI</a>-->
                           <!-- <button type="button" name="convert" id="convert" class="btn btn-primary convert" style="float:right;margin-right:30px;">EXPORT</button> -->
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="table1">
                                <thead id="thead">
                                    <tr>
                                        <th>Code</th>
                                        <th>Process</th>
                                        <th>Risk</th>
                                        <th>Key Performance Indicator(KPI)</th>
                                        <th>Owner</th>
                                        <th>Approval</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                foreach($showki as $ki){
                                  $uid=$ki["owner"];
                                  $username=$userclass->userjoin($uid);

                                  $pid=$ki["process_id"];
                                  $processname=$processClass->processJoins($pid);

                                  $rid=$ki["risk_id"];
                                  $riskname=$riskclass->Riskjoin($rid);
                                  $approval=$ki["approval"];
                                   
                                   ?>                                
                                  <tr>
                                        <td><?='KI00'.$ki["id"]?></td>
                                        <td><?=$processname?></td>
                                        <td><?=$riskname?></td>
                                        <td><?=$ki["ki"]?></td>
                                        <td><?=$username?></td>
                                        <td> 
                                            <?php
                                            if($approval==1){
                                                echo'<button class="btn icon btn-secondary"><i class="approvaltext">Pending</i></button>';
                                            }elseif($approval==2){
                                                echo'<button class="btn icon btn-info"><i class="approvaltext">Approved</i></button>';
                                            }elseif($approval==3){
                                                echo'<button class="btn icon btn-success"><i class="approvaltext">Ammend</i></button>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                        <button class="btn btn-primary btn-userpermission-edit kiedit-btn" id='<?=$ki["id"]?>'><span class="fa-fw select-all fas">ïŒƒ</span></button>
                                        <button name="delete" value="Delete" class="btn btn-sm btn-danger kidelete btn-userpermission-delete" id='.$ki["id"].'><span class="fa-fw select-all fas">ï‹­</span></button>
                                         </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                 <!--</form>-->
                </section>


    <!-_________________Content location END______________________->
                
            </div>
        </section>
    </div>

  </div>





 <!-_________________Footer location______________________->

        <?php include_once'../layout/footer.php'; ?>
         <!-----------------------------------keyindicator UPDATE Modals--------------------------------------------------------------->
    <div class="modal fade text-left" id="editki-modal" tabindex="-1" role="dialog"aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel17">EDIT Key Performance Indicator</h3>
                    <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>        
                <form id="formupdate">
                <div class="modal-body">
                <div class="row">
                        <div class="col-md-12 form-group">
                            <label>Choose Process:</label>
                            <input type="hidden" name="kiid" id="kiid">
                            <select class="form-control" onchange="fetchprocess(this.value)" name="process" id="process">
                                <option value="" selected>----SELECT Process---</option>
                                <?php
                                foreach($showprocess as $process){
                                echo'<option value='.$process["process_id"].'>P00'.$process["process_id"].'-'.$process["process_name"].'</option>';

                                    }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-12 form-group">
                            <label>Choose Risk:</label>
                            <select class="form-control" name="risk" id="editrisk">
                                <option value="" selected>----SELECT Risk---</option>
                                <?php
                                foreach($showrisk as $risk){
                                    
                                echo'<option value='.$risk["risk_id"].'>(RSK0'.$risk["risk_id"].')'.$risk["risk_name"].'</option>';

                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Enter Key Indicator:</label>
                            <textarea class="form-control" name="ki" id="ki" rows="3"></textarea>
                        </div>
                        <!--<div class="col-md-12 form-group">
                            <label>Key Risk Indicator:</label>
                            <select class="form-control" name="kri" id="kri" >
                                <option value="" selected>----SELECT KEY RISK INDICATOR---</option>
                                
                            </select>
                        </div>-->
                        <div class="col-md-12 form-group">
                                <label>Owner:</label>
                            <select class="form-select" name="owner" id="owner">
                                <option value="" selected>----SELECT Owner---</option>
                                <?php
                                foreach($showusers as $user){
                                    
                                echo'<option value='.$user["id"].'>'.$user["fname"].'&nbsp;'.$user["sname"].'</option>';

                                    }
                                ?>
                            </select>
                        </div>
                                    
                                
                            
                </div><!--end of row--->

                </div>
                <div class="modal-footer">
                
                    <button type="button" class="btn btn-danger"
                        data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="" name="" class="kiupdate btn btn-primary">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">UPDATE</span>
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
     <!-----------------------------------COMPANY EDIT Modals--------------------------------------------------------------->
     <!-----------------------------------keyindicator ADD Modals--------------------------------------------------------------->
    <div class="modal fade text-left" id="addki-modal" tabindex="-1" role="dialog"aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel17">Add Key Performance Indicator</h3>
                    <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>        
                
                <div class="modal-body">
                    <div id="messageki"></div>
                <form class="form form-horizontal" id="kientaddform">
                <div class="row">
                        <div class="col-md-12 form-group">
                            <label>Choose Process:</label>
                            <input type="hidden" class="form-control"  name="dept_id" id="pdept_id">
                            <select class="form-control selectprocess choices" onchange="fetchprocess(this.value)" name="processid" id="kiprocess">
                                <option value="" selected>----SELECT Process---</option>
                                <?php
                                foreach($showprocess as $process){
                                    $deptid=$process["dept_id"];
                                    $deptpname=$deptClass->deptJoins($deptid);
                                echo'<option value='.$process["process_id"].'>'.$process["process_name"].'&nbsp;&nbsp;('.$deptpname.')</option>';

                                    }
                                ?>
                            </select>
                            <span class="error" id="kiprocess_err"> </span>
                        </div>

                        <div class="col-md-12 form-group">
                            <label>Choose Risk:</label>
                            <select class="form-select" name="selectrisk" id="selectrisk">
                                <option value="">----SELECT Risk---</option>
                            </select>
                            <span class="error" id="kirisk_err"> </span>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Enter Key Indicator:</label>
                            <textarea class="form-control" name="ki" id="ki" rows="3"></textarea>
                            <span class="error" id="ki_err"> </span>
                        </div>
                        <!--<div class="col-md-12 form-group">
                            <label>Key Risk Indicator:</label>
                            <select class="form-control" name="kri" id="kri" >
                                <option value="" selected>----SELECT KEY RISK INDICATOR---</option>
                               
                            </select>
                        </div>-->
                        <div class="col-md-12 form-group">
                                <label>Owner:</label>
                            <select class="form-select" name="owner" id="kiowner">
                                <option value="" selected>----SELECT Owner---</option>
                                <?php
                                foreach($showusers as $user){
                                    
                                echo'<option value='.$user["id"].'>'.$user["fname"].'&nbsp;'.$user["sname"].'</option>';

                                    }
                                ?>
                            </select>
                            <span class="error" id="kiowner_err"> </span>
                        </div>
                                    
                                
                            
                </div><!--end of row--->

                </div>
                <div class="modal-footer">
                <!--<div class="col-12 alert alert-danger" id="messagedisplayki" style="text-align:center;font-size:25px;font-weight:600;"></div>-->
                <button type="button" class="btn btn-danger"
                        data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="" name="editCompany" class="btn btn-primary kiadd-btn">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Add Key Indicator</span>
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
     <!-----------------------------------COMPANY EDIT Modals--------------------------------------------------------------->
     
    
     <!-----------------------------------DELETE  Modal ---------------------------------------------------------------->
                <div class="modal fade text-left" id="delete-modal" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel120" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                            role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-danger">
                                    <h5 class="modal-title white" id="myModalLabel120">Delete KPI
                                    </h5>
                                    <button type="button" class="close" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                </div>
                                <form id="deleteform">
                                <div class="modal-body">
                                <div>
                                    <input type="hidden" name="dcid" id="dcid" value="">
                                    <h3>Are you Sure you want to delete?</h3>
                                    
                                <div style="color:#000;font-weight:600;font-size:29px;text-align:center;">KPI:<h5 id="dcname"></h5></div>
                                </div>
                                
                                </div>
                                <div class="modal-footer">
                                    
                                    <button type="button" class="btn btn-light-secondary"
                                        data-bs-dismiss="modal">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Close</span>
                                    </button>
                                    <button type="button" class="delete-btn btn btn-danger ml-1"
                                        data-bs-dismiss="modal">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">DELETE</span>
                                    </button>
                                </div>
                             </form>
                            </div>
                        </div>
                    </div>
                </div>
    <!------------------------------------------------------------------------------------------------------------------------>
    
        </div>
        
    </div>



    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>

  <!----------------------Datatable Simple------------------------------------------------>
    <script src="../assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
    </script>
<!----------------------Datatable Simple end------------------------------------------------>

    <script src="../assets/js/pages/horizontal-layout.js"></script>

<!------------------------------SWEET ALERTS---------------------------------->
     <script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>

<!----------------------font awsome------------------------------------------------>
    <script src="../assets/vendors/fontawesome/all.min.js"></script>
<!------------- Include Choices select JavaScript ------------------------------------------------>
    <script src="../assets/vendors/choices.js/choices.min.js"></script>
    <script src="../assets/js/pages/form-element-select.js"></script>

   

</body>

</html>
