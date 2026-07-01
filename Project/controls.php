<?php
include_once'./risk/riskClass.php';
include_once'./settings/controlstrengthClass.php';
include_once'./settings/controltypeClass.php';
include_once'./settings/reviewerClass.php';
include_once'./department/departmentClass.php';


$reviewerclass=new reviewerClass();

$cstrengthClass=new controlstrengthClass();
$showcstrength=$cstrengthClass->showcontrolstrength();

$ctypeclass= new controltypeClass();
$ctype=$ctypeclass->showcontroltype();

$deptClass= new departmentClass();

?>
<!DOCTYPE html>
<html lang="en">
<!-_________________Header location______________________->
<?php include_once("../layout/header.php"); ?>

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

            <?php include_once("../layout/nav.php") ?>

            <div class="content-wrapper container">
                
<div class="page-heading">
    <h4>Control Library</h4>
</div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
    <!-_________________Content location BEGINING______________________->
                <style>
                    .btn-orange{
                    background-color: #ff4700;
                    border-color: #ff4700;
                    border:1px solid #fff;
                    color: #fff;
                    }

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
        <!--<form method="POST" id="convert_form" action="export.php">-->
                    <div class="card">
                        <div class="card-header">
                           <!-- <input type="hidden" name="file_content" id="file_content">-->
                            <button onclick="location.href='../Project/addcontrol.php'" type="button" class="btn btn-primary btn-userpermission-add" style="float:right;margin-right:30px;">
                            <i class="fas fa-fw fa-plus"></i>Add Controls</button>
                            <!--<a href="../Project/addcontrol" class="btn btn-primary" style="float:right;margin-right:30px;" >
                                <i class="fas fa-fw fa-plus"></i>Add Controls</a>
                            <button type="button" name="convert" id="convert" class="btn btn-primary convert" style="float:right;margin-right:30px;">EXPORT</button>
                       --> </div>
                        <div class="card-body">
                            <div class="table-responsive">
<table class="table table-striped table-buss" id="table1">
                                <thead id="thead">
                                    <tr>
                                        <th>Reference</th>
                                        <th>Control</th>
                                        <th>Department</th>
                                        <th>Control Strength</th>
                                        <th>Reviewer</th> 
                                        <th>Approval</th> 
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach($showcontrol as $control){
                                        // $rid=$control["risk"];
                                            //$riskname=substr($riskClass->Riskjoin($rid), 0 , 60);
                                            
                                            $csid=$control["cstrength"];
                                            $csname=$cstrengthClass->strengthjoin($csid);
                                            
                                            $deptid=$control["dept_id"];
                                            $deptname=$deptClass->deptJoins($deptid);

                                            $uid=$control["reviewer"];
                                            $uname=$userclass->userjoin($uid);
                                            $text= substr($control["controls"], 0 , 80);
                                            $approval=$control["approval"];
                                        
                                    ?>
                                                <tr>
                                            <td><?='CTL00'.$control["control_id"]?></td>
                                            <td style="max-width:220px;white-space:normal;padding:4px 8px;font-size:11px;"><?=$controlname=$controlclass->paragraph($text)?></td>
                                            <td><?=$deptname?></td>
                                            <td><?=$csname?></td>                                            
                                            <td><?=$uname?></td>
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
                                                <button class="btn btn-sm btn-primary editcontrol-btn btn-userpermission-edit" id='<?=$control["control_id"]?>'><i class="fas fa-fw fa-pen"></i></a>                                        
                                                <button class="btn btn-sm btn-danger delete-btn btn-userpermission-delete" id='.$control["control_id"].'><i class="fas fa-fw fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <?php  }
                                        ?>
                                            
                                </tbody>
                            </table>
                            </div><!-- table-responsive -->
                            </div>
                        </div>
                    </form>
                    </section>


        <!-_________________Content location END______________________->
                    
                </div>
            </section>
        </div>

    </div>

    <!-----------------------------------ADD CONTOL Modals--------------------------------------------------------------->
    <div class="modal fade text-left" id="editcontrol-modal" tabindex="-1" role="dialog"aria-labelledby="myModalLabel17" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="myModalLabel17">EDIT CONTROL</h3>
                        <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>        
                    
                    <div class="modal-body">
                    <form class="form form-horizontal" id="editcontrolform">
                    <div id="messagecontrol"></div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label>Choose Process:</label>
                                <input type="hidden" name="cid" id="cid" value="">
                                <input type="hidden" class="form-control"  name="cdept_id" id="cdept_id">
                                <select class="form-control selectprocess"  name="cprocess" id="cprocess">
                                    <option value="" selected>----SELECT Process---</option>
                                    <?php
                                    foreach($showprocess as $process){
                                        $deptid=$process["dept_id"];
                                        $deptpname=$deptClass->deptJoins($deptid);
                                    echo'<option value='.$process["process_id"].'>'.$process["process_name"].'&nbsp;&nbsp;('.$deptpname.')</option>';

                                        }
                                    ?>
                            </select>
                            <span class="error" id="cprocess_err"> </span>
                        </div>

                        <!--<div class="col-md-12 form-group">
                            <label>Choose Risk:</label>
                            <select class="form-control" name="crisk" id="crisk">
                                <option value="" selected>----SELECT Risk---</option>                
                            </select>
                            <span class="error" id="crisk_err"> </span>
                        </div>-->

                        <div class="col-md-12 form-group">
                            <label>Enter Controls:</label>
                            <textarea class="form-control" name="control" id="controls" rows="3"></textarea>
                            <span class="error" id="control_err"> </span>
                        </div>

                        <div class="col-md-6 form-group">
                                <label>Control Strength:</label>
                            <select class="form-select" name="cstrength" id="cstrength">
                                <option value="" selected>----SELECT Control Strength---</option>
                                    <?php
                                    foreach($showcstrength as $cs){
                                        
                                    echo'<option value='.$cs["strength_id"].'>'.$cs["cs_name"].'</option>';

                                        }
                                    ?>
                            </select>
                            <span class="error" id="cstrength_err"> </span>
                        </div>

                        <div class="col-md-6 form-group">
                                <label>Control Type:</label>
                            <select class="form-select" name="ctype" id="ctype">
                                <option value="" selected>----SELECT Control Type---</option>
                                <?php
                                foreach($ctype as $ct){
                                    
                                echo'<option value='.$ct["ctype_id"].'>'.$ct["ct_name"].'</option>';

                                    }
                                ?>
                            </select>
                            <span class="error" id="ctype_err"> </span>
                        </div>
                        <div class="col-md-6 form-group">
                                <label>Reviewer:</label>
                            <select class="form-select" name="reviewer" id="creviewer">
                                <option value="" selected>SELECT Reviewer---</option>
                                <?php
                                foreach($showusers as $user){
                                    
                                echo'<option value='.$user["id"].'>'.$user["fname"].'&nbsp;'.$user["sname"].'</option>';

                                    }
                                ?>
                            </select>
                            <span class="error" id="creviewer_err"> </span>
                        </div>

                        <div class="col-md-6 form-group">
                                <label>Review Date:</label>
                            <input type="text" class="form-control" name="rdate" id="datepicker2" autocomplete="off">
                        </div>
                        <span class="error" id="crdate_err"> </span>
                        
                    
                </div><!--end of row--->

                </div>
                <div class="modal-footer">
                <!--<div class="col-12 alert alert-danger" id="messagedisplaycontrol" style="text-align:center;font-size:25px;font-weight:600;"></div>-->
                    <button type="button" class="btn btn-danger"
                        data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button name="addcontrol-btn" class="updatecontrol-btn btn btn-primary">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">EDIT Control</span>
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
     <!-----------------------------------End of control--------------------------------------------------------------->
     

<!-----------------------------------DELETE  Modal ---------------------------------------------------------------->
                <div class="modal fade text-left" id="delete-modal" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel120" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                            role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-danger">
                                    <h5 class="modal-title white" id="myModalLabel120">Delete Control
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
                                    <div id="messagedelete"></div>
                                <div style="color:#000;font-weight:600;font-size:29px;text-align:center;">Controls:<h6 id="dcname"></h6></div>
                                </div>
                                
                                


                                </div>
                                <div class="modal-footer">
                                    
                                    <button type="button" class="btn btn-light-secondary"
                                        data-bs-dismiss="modal">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Close</span>
                                    </button>
                                    <button type="button" class="delete-control btn btn-danger ml-1"
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
    




 <!-_________________Footer location______________________->

        <?php include_once("../layout/footer.php"); ?>

        
        </div>
        
    </div>

    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>

<!------------------------ Include Choices JavaScript drop down--------------------- -->
        <script src="../assets/vendors/choices.js/choices.min.js"></script>
        <script src="../assets/js/pages/form-element-select.js"></script>

  <!----------------------Datatable Simple------------------------------------------------>
    <script src="../assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script>
        let table1 = document.querySelector('#table1');
        if (table1) new simpleDatatables.DataTable(table1);
    </script>

<!---------------------------------SWEET ALERTS----------------------------------------->
    <script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>

<!----------------------Datatable Simple end------------------------------------------------>

    <script src="../assets/js/pages/horizontal-layout.js"></script>

<!----------------------font awsome------------------------------------------------>
    <script src="../assets/vendors/fontawesome/all.min.js"></script>

   

</body>

</html>
