<?php 
include_once'./department/departmentClass.php';
include_once'./risk/riskClass.php';
include_once'./action/actionClass.php';
include_once'./process/processClass.php';
include_once'./recommend/recommendClass.php';


$actionclass=new actionClass();
$showaction=$actionclass->showaction();
//display owners details.
$riskclass=new riskClass();
//entity
$deptClass= new departmentClass();
//display process details
//process
$processClass=new processClass();
$process= $processClass->showProcess();
//action
$actionClass=new actionClass();
$showaction=$actionClass->showaction();



?>
<!DOCTYPE html>
<html lang="en">
<!-_________________Header location______________________->
<?php include_once'../layout/header.php'; ?>

<body class="<?php echo (isset($sess_roles) && in_array((int)$sess_roles, [1, 3])) ? 'role-readonly' : '' ?>">
<style>
.role-readonly .btn-userpermission-edit,
.role-readonly .btn-userpermission-delete,
.role-readonly .btn-userpermission-add {
    opacity: 0.4;
    pointer-events: none;
    cursor: not-allowed;
}
</style>
    <div id="app">
        <div id="main" class="layout-horizontal">

 <!-_________________Navigation location______________________->

 <?php include_once'../layout/nav.php'; ?>

            <div class="content-wrapper container">
                
<div class="page-heading">
    <h4>Add Recommendations</h4>
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
                                .btn-group-sm>.btn, .btn-sm { border-radius: 0.2rem; font-size: 0.75rem; padding: 0.2rem 0.4rem; }
                .table-buss { border-collapse: collapse; }
                .table-buss th {
                    font-size: 12px; font-weight: 700; color: #fff;
                    background: #02338d; padding: 3px 5px;
                    white-space: nowrap; text-align: center; vertical-align: middle;
                    border: 1px solid rgba(255,255,255,0.3);
                }
                .table-buss td {
                    font-size: 12px; font-weight: 500; color: #222;
                    padding: 2px 5px; text-align: center; vertical-align: middle;
                    white-space: nowrap; border: 1px solid #b8c8de;
                }
                .table-buss tbody tr:hover td { background: #eef4ff; }
                </style>

                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <button onclick="location.href='../Project/addrecommend.php'" type="button" class="btn btn-primary btn-userpermission-add" style="float:right;margin-right:30px;">
                            <i class="fas fa-fw fa-plus"></i>Recommendation</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
<table class="table table-striped table-buss" id="table1">
                                <thead id="thead">
                                    <tr>
                                        <th>reference id</th>
                                        <th>Entity</th>
                                        <th>Risk</th>
                                        <th>MRC(Management Risk Committee)</th>
                                        <th>ARMC(Audit Risk Management Committee)</th>
                                        <th>Timeline</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (is_array($showrecommend) || is_object($showrecommend))//used when the array is blank
                                    {
                                    foreach($showrecommend as $recommend){

                                    $deptid=$recommend["dept_id"];
                                    $deptname=$deptClass->deptJoins($deptid);

                                    $rid=$recommend["risk_id"];
                                    $riskname=$riskclass->Riskjoin($rid);

                                    $aid=$recommend["action"];
                                    $actionname=$actionclass->actionJoins($aid);
                                    $approval=$recommend["approval"];

                                    ?>

                                    <tr>
                                        <td><?='RMD00'.$recommend["id"]?></td>
                                        <td><?=$deptname?></td>
                                        <td><?=$riskname?></td>
                                        <td style="max-width:220px;white-space:normal;padding:4px 8px;font-size:11px;"><?=substr($recommend["mrc"],0,60).'...'?></td>
                                        <td style="max-width:220px;white-space:normal;padding:4px 8px;font-size:11px;"><?=substr($recommend["armc"],0,60).'...'?></td>
                                        <td><?=$recommend["timeline"]?></td>
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
                                        <button class="btn btn-sm btn-primary editrecommend" id='<?=$recommend["id"]?>'><i class="fas fa-fw fa-pen"></i></button>
                                       
                                        <button class="btn btn-sm btn-danger recommenddelete btn-userpermission-delete" id='.$recommend["id"].'><i class="fas fa-fw fa-trash"></i></button>
                                         </td>
                                    </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            </div><!-- table-responsive -->
                        </div>
                    </div>
                </section>


    <!-_________________Content location END______________________->
                
            </div>
        </section>
    </div>

  </div>





 <!-_________________Footer location______________________->

        <?php include_once'../layout/footer.php'; ?>
        
        </div>
        
    </div>
 <!------------------------------------------------RISK Recommendation------------------------------------------------------------>
 <div class="modal fade text-left w-100" id="editrecommend-modal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel16" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl"
            role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel16">Edit RECOMMENDAION</h4>
                    <button type="button" class="close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form" id="editrecommendform">
                        <div class="row">
                            <div class="col-md-6">

                                <div class="col-md-12 form-group">
                                    <label>Choose Process:</label>
                                    <input type="hidden" name="rid" id="rid">

                                    <select class="form-control selectprocess" onchange="recommendprocess(this.value)" name="rmdprocess" id="rmdp">
                                        <option value="" selected>----SELECT Process---</option>
                                        <?php
                                            foreach($process as $prs){
                                                $deptid=$prs["dept_id"];
                                                $deptpname=$deptClass->deptJoins($deptid);
                                                
                                            echo'<option value='.$prs["process_id"].'>'.$prs["process_name"].'&nbsp;&nbsp;('.$deptpname.')</option>';

                                            }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-12 form-group">
                                    <label>Choose Risk:</label>
                                        <select class="form-control" name="rmdrisk" id="rmdrisk">
                                        <option value="" selected>----SELECT Risk---</option>
                                                <?php
                                                foreach($showrisk as $risk){
                                                    $selected = ($recommend["risk_id"] == $risk["risk_id"]) ? "selected" : "";
                                                    echo'<option '.$selected.' value='.$risk["risk_id"].'>'.$risk["risk_name"].'</option>';
                                                }
                                                ?>
                                            
                                        </select>
                                </div>
                                <div class="col-md-12 form-group">
                                        <label>Action:</label>
                                    <select class="form-select" name="action" id="action">
                                        <option value="" selected>----SELECT Action ---</option>
                                        <?php
                                        foreach($showaction as $action){
                                        echo'<option value='.$action["id"].'>'.$action["action"].'</option>';

                                            }
                                        ?>
                                        
                                    </select>
                                </div>
                                <div class="col-md-12 form-group">
                                        <label>Status:</label>
                                    <select class="form-select" name="status" id="status">
                                        <option value="" selected>----SELECT Action status---</option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                        <option value="ongoing">Ongoing</option>
                                        <option value="overdue">Overdue</option>
                                        
                                    </select>
                                </div>
                                <div class="col-md-12 form-group">
                                        <label>Timeline:</label>
                                    <input type="text" class="form-control" name="timeline" id="datepicker4">
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12 form-group">
                                    <label>MRC(Management Risk Committee) Recommendation:</label>
                                    <textarea class="form-control" name="mrc" id="mrc" rows="7"></textarea>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label>ARMC(Audit Risk Management Committee) Recommendation:</label>
                                    <textarea class="form-control" name="armc" id="armc" rows="7"></textarea>
                                </div>
                                
                            </div>
                            
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger"
                        data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="button" class="btn btn-primary ml-1 editrecommendation-btn"
                        data-bs-dismiss="modal">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Edit Recommendation</span>
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-----------------------------------end Recommendation Modals--------------------------------------------------------------->
     
 <!-----------------------------------DELETE  Modal ---------------------------------------------------------------->
 <div class="modal fade text-left" id="delete-modal" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel120" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                            role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-danger">
                                    <h5 class="modal-title white" id="myModalLabel120">Delete RISK
                                    </h5>
                                    <button type="button" class="close" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                </div>
                                <form id="deleteform">
                                <div class="modal-body">
                                <div>
                                    <input type="hidden" name="rid" id="rid" value="">
                                    <h3>Are you Sure you want to delete?</h3>
                                    <div id="messagedelete"></div>
                                <div style="color:#000;font-weight:600;font-size:15px;text-align:center;">AMC:<h5 id="amc"></h5></div>
                                <div style="color:#000;font-weight:600;font-size:15px;text-align:center;">ARMC:<h5 id="armc"></h5></div>
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
    


    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>

  <!----------------------Datatable Simple------------------------------------------------>
    <script src="../assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script>
        let table1 = document.querySelector('#table1');
        if (table1) new simpleDatatables.DataTable(table1);
    </script>
<!----------------------Datatable Simple end------------------------------------------------>

    <script src="../assets/js/pages/horizontal-layout.js"></script>

<!------------------------------SWEET ALERTS---------------------------------->
    <script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>

<!----------------------font awsome------------------------------------------------>
    <script src="../assets/vendors/fontawesome/all.min.js"></script>
    
    <script src="../assets/vendors/choices.js/choices.min.js"></script>
    <script src="../assets/js/pages/form-element-select.js"></script>

   

</body>

</html>
