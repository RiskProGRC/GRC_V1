<?php 
include_once'./keyindicator/keyindicatorClass.php';
include_once'./risk/riskClass.php';

//display owners details.

$riskclass=new riskClass();
$showrisk= $riskclass->showRisk();
//entity$deptClass= new departmentClass();



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
    <h4>Add Action</h4>
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
                    label {
                        font-size: 12px;
                        color: #000;
                        font-weight: 800;
                    }
                    .form-control,.form-select{
                        font-size: 12px;
                        font-weight: 800;
                        
                        
                    }
                    .choices{
                        font-size: 14px;
                        font-weight: 800;
                        color: #000;
                        padding: 2px 2px;
                    }
                    .nav-tabs{
                        font-size: 13px;
                        font-weight: 800;
                    }
                    tbody{
                        background: #fff;
                        color: #0c141b;
                        font-weight: 600;
                        font-size: 0.8em;
                        height: 10px;
                        overflow: scroll;
                    }
                    .overflow{
                        width: 100%;
                        height: 250px;
                        overflow: scroll;
                    }
                    h4{
                    text-align: center;

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
               <!-- <form method="POST" id="convert_form" action="export.php">-->
                    <div class="card">
                        <div class="card-header">
                       <!-- <input type="hidden" name="file_content" id="file_content">-->
                        <button onclick="location.href='../Project/addaction.php'" type="button" class="btn btn-primary btn-userpermission-add" style="float:right;margin-right:30px;">
                        <i class="fas fa-fw fa-plus"></i>Add Action</button>
                            <!--<a href="../Project/addaction" class="btn btn-primary" style="float:right;margin-right:30px;">
                            <i class="fas fa-fw fa-plus"></i>Add Action</a>-->
                          <!--  <button type="button" name="convert" id="convert" class="btn btn-primary convert" style="float:right;margin-right:30px;">EXPORT</button>   
                -->   </div>
                        <div class="card-body">
                            <div class="table-responsive">
<table class="table table-striped table-buss" id="table1">
                                <thead id="thead">
                                    <tr>
                                        <th>reference id</th>
                                        <th>process</th>
                                        <th>Risk</th>
                                        <th>Action</th>
                                        <th>Timeline</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                foreach($showaction as $action){

                                  $pid=$action["process_id"];
                                  $processname=$processClass->processJoins($pid);

                                  $rid=$action["risk_id"];
                                  $riskname=$riskclass->Riskjoin($rid);
                                  $approval=$action["approval"];
                                  
                                    ?>

                                   <tr>
                                        <td><?='ACT00'.$action["id"]?></td>
                                        <td><?=$processname?></td>
                                        <td><?=$riskname?></td>
                                        <td style="max-width:220px;white-space:normal;padding:4px 8px;font-size:11px;"><?=substr($action["action"],0,60).'...'?></td>
                                        <td><?=$action["timeline"]?></td>
                                        <td><?=$action["priority"]?></td>
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
                                        <button name="delete" value="Delete" class="btn btn-sm btn-primary editactionbtn btn-userpermission-edit" id="<?=$action['id']?>"> <i class="fas fa-fw fa-pen"></i></button>
                                        <button name="delete" value="Delete" class="btn btn-sm btn-danger actiondeletebtn btn-userpermission-delete" id="<?=$action['id']?>"><i class="fas fa-fw fa-trash"></i></button>
                                         </td>
                                    </tr>
                                <?php }
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

    <!-----------------------------------EDIT Action Modals--------------------------------------------------------------->
    <div class="modal fade text-left" id="editaction-modal" tabindex="-1" role="dialog"aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel17">EDIT ACTION</h3>
                    <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>        
                
                <div class="modal-body">
                    <div id="messageaction"></div>
                <form class="form form-horizontal" id="actionform">
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label>Choose Process:</label>
                        <input type="hidden" class="form-control" name="aid" id="aid">
                        <select class="form-control selectprocess choices" onchange="actiondrop(this.value)" name="aprocess" id="aprocess">
                            <option value="" selected>----SELECT Process---</option>
                            <?php
                            foreach($showprocess as $process){
                                $deptid=$process["dept_id"];
                                $deptpname=$deptClass->deptJoins($deptid);
                                
                            echo'<option value='.$process["process_id"].'>'.$process["process_name"].'&nbsp;&nbsp;('.$deptpname.')</option>';

                                }
                            ?>
                        </select>
                        <span class="error" id="aprocess_err"> </span>
                    </div>

                    <div class="col-md-12 form-group">
                        <label>Choose Risk:</label>
                        <select class="form-control" name="arisk" id="arisk">
                        <option value="" selected>----SELECT Risk---</option>
                                                <?php
                                                foreach($showrisk as $risk){
                                                    $selected=($actionfetch["risk_id"]==$risk["risk_id"]) ? "selected" : "";
                                                echo'<option '.$selected.' value='.$risk["risk_id"].'>(RSK0'.$risk["risk_id"].')'.$risk["risk_name"].'</option>';

                                                    }
                                                ?>                
                        </select>
                        <span class="error" id="arisk_err"> </span>
                    </div>

                    <div class="col-md-12 form-group">
                        <label>Action Details:</label>
                        <textarea class="form-control" name="action" id="actionname" rows="3"></textarea>
                        <span class="error" id="action_err"> </span>
                    </div>

                    <div class="col-md-12 form-group">
                            <label>Status:</label>
                        <select class="form-select" name="status" id="status">
                            <option value="" selected>----SELECT Action status---</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                            <option value="ongoing" selected>Ongoing</option>
                            <option value="overdue">Overdue</option>
                            
                        </select>
                    </div>
                    <div class="col-md-12 form-group">
                            <label>Priority:</label>
                        <select class="form-select" name="priority" id="priority">
                            <option value="" selected>----SELECT Action Priority---</option>
                            <option value="Incredibly high">Incredibly high</option>
                            <option value="Very High">Very High</option>
                            <option value="High">High</option>
                            <option value="Medium">Medium</option>
                            <option value="Low">Low</option>                            
                        </select>
                    </div>
                    <div class="col-md-12 form-group">
                            <label>Timeline:</label>
                        <input type="text" class="form-control" autocomplete="off" name="timeline" id="datepicker3">
                        <span class="error" id="atime_err"> </span>
                    </div>
                        
                </div><!--end of row--->

                </div>
                <div class="modal-footer">
                <!--<div class="col-12 alert alert-danger" id="messagedisplaycontrol" style="text-align:center;font-size:25px;font-weight:600;"></div>-->
                    <button type="button" class="btn btn-danger"
                        data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="" name="" class="btn btn-primary updateaction-btn">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Update Action</span>
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
     <!-----------------------------------ADD Action Modals--------------------------------------------------------------->
  
    
     <!-----------------------------------DELETE  Modal ---------------------------------------------------------------->
                <div class="modal fade text-left" id="delete-modal" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel120" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                            role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-danger">
                                    <h5 class="modal-title white" id="myModalLabel120">Delete Action
                                    </h5>
                                    <button type="button" class="close" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                </div>
                                <form id="deleteform">
                                <div class="modal-body">
                                <div>
                                    <input type="hidden" name="actionid" id="actionid" value="">
                                    <h3>Are you Sure you want to delete?</h3>
                                    <div id="messagedelete"></div>
                                <div style="color:#000;font-weight:600;font-size:29px;text-align:center;">Company Name:<h5 id="dcname"></h5></div>
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
        </div>
        
    </div>



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

   

</body>

</html>
