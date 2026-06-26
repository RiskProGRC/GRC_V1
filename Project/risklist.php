<?php
include_once'./settings/riskcategoryClass.php';
include_once'./risk/riskClass.php';
include_once'./department/departmentClass.php';
include_once'./process/processClass.php';
//process
$processClass=new processClass();
//department
$deptClass=new departmentClass();
//risk
$riskClass=new riskClass();
$showRisk=$riskClass->showRisk();
//riskcategory
$riskCatClass=new riskCatClass();
$showriskcat= $riskCatClass->showRiskCat();

$btniass="btn-light";
$btnrass="btn-light";
$btntass="btn-light";

?>
<!DOCTYPE html>
<html lang="en">
<!-_________________Header location______________________->
<?php include_once("../layout/header.php");
    $sdid=$sess_dept_id;
    
    if($sess_roles==1){
        $showRisk=$riskClass->showRisk();
    }elseif($sess_roles==2){
        $showRisk=$riskClass->showRiskdept($sdid);
    }

?>

<body>
    <div id="app">
        <div id="main" class="layout-horizontal">

 <!-_________________Navigation location______________________->

            <?php include_once("../layout/nav.php") ?>

            <div class="content-wrapper container">
                
<div class="page-heading">
    <h4>Risk Lists</h4>
</div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
    <!-_________________Content location BEGINING______________________->
                <style>
                    .btn-orange {
                        background-color: #ff4700;
                        border-color: #ff4700;
                        border: 1px solid #fff;
                        color: #fff;
                    }
                    .btn-group-sm>.btn, .btn-sm {
                        border-radius: 0.2rem;
                        font-size: 0.75rem;
                        padding: 0.2rem 0.4rem;
                    }
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
                  <form method="" id="convert_form" action="">
                    <div class="card">
                        <div class="card-header">
                        <input type="hidden" name="file_content" id="file_content">
                        <button onclick="location.href='../Project/addrisk.php'" type="button" class="btn btn-primary btn-userpermission-add" style="float:right;margin-right:30px;">
                        <i class="fas fa-fw fa-plus"></i> Add Risks</button>
                        <!--<a href="../Project/addrisk" class="btn btn-primary" style="float:right;margin-right:30px;" >
                            <i class="fas fa-fw fa-plus"></i> Add Risks</a>-->
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <table class="table table-striped table-buss" id="table1">
                                <thead id="thead">
                                    <tr>
                                        <th>Reference</th>
                                        <th>Department</th>
                                        <th>Process</th>
                                        <th>Inherent Risk</th>
                                        <th>Risk category</th>
                                        <th>Approval</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (is_array($showRisk) || is_object($showRisk))//used when the array is blank
                                    {
                                        foreach($showRisk as $values){
                                            $rid=$values["risk_id"];

                                            $risk=substr($values["risk_name"], 0 , 80);
                                            $rcatid=$values["rcat"];
                                            $riskcatname=$riskCatClass->riskcatJoins($rcatid);

                                            $deptid=$values["dept"];
                                            $deptname=ucfirst($deptClass->deptJoins($deptid));

                                            $pid=$values["process"];
                                            $processname=ucfirst($processClass->processJoins($pid));
                                            $approval= $values["approval"]
                                            
                                            ?>


                                            <tr>
                                            <td><?='RSK0'.$values["risk_id"]?></td>
                                            <td><?=$deptname?></td>
                                            <td><?=$processname?></td>
                                            <td><div style="font-size:13px;">
                                            <?=$risk?>
                                            </div></td>
                                            <td><?=$riskcatname?></td>
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
                                            <?php if($approval==2){ ?>
                                            <a href="#" class="btn btn-sm btn-primary "><i class="fas fa-fw fa-pen"></i></a>
                                            <?php }else{ ?>
                                                <button class="btn btn-sm btn-primary edit-risk" id='<?=$values["risk_id"]?>'><i class="fas fa-fw fa-pen"></i></button> 
                                            <?php }?>                                          
                                            <button class="btn btn-sm btn-danger delete-risk btn-userpermission-delete" id='.$values["risk_id"].'><i class="fas fa-fw fa-trash"></i></button>
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
                  </form>
                </section>


    <!-_________________Content location END______________________->
                
            </div>
        </section>
    </div>

  </div>





 <!-_________________Footer location______________________->

        <?php include_once("../layout/footer.php"); ?>

        
        </div>
        
    </div>

<!-----------------------------------------Modal For RISK-------------------------------->
<!------------------------------------------------RISK ADD MODAL------------------------------------------------------------>
<div class="modal fade text-left w-100" id="editrisk-modal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel16" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl"
            role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel16">Edit RISK</h4>
                    <button type="button" class="close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    
                <form class="form" id="editriskform">
                <div id="messagerisk"></div>
                        <div class="row">
                            <div class="col-md-6">

                                <div class="col-md-8">
                                    <label>Choose Entity:</label>
                                </div>
                                <div class="col-md-12 form-group">
                                    <input type="hidden" name="risk_id" id="risk_id">
                                    <select class="form-control" name="dept"  id="dept_id" required>
                                        <option value="" selected>--------------------SELECT Entity</option>
                                        <?php
                                        foreach($showdept as $dp){
                                            $deptid=$dp["dept_id"];
                                            $deptname=$deptClass->deptJoins($deptid);
                                        echo' <option value='.$dp["dept_id"].'>'.$deptname.'</option>';
                                        }
                                        ?>
                                    </select>
                                    <span class="error" id="deptid_err"> </span>
                                </div>

                                <div class="col-md-8">
                                        <label>Select Process:</label>
                                </div>
                                <div class="col-md-12 form-group">
                                    <select class="form-control" name="process" id="process_id" required>
                                        <option value="" selected>----------------------SELECT Process</option>
                                        <?php
                                        foreach($showprocess as $process){
                                            $processname=ucfirst($process["process_name"]);
                                            
                                        echo' <option value='.$process["process_id"].'>'.$processname.'</option>';
                                        }
                                        ?>

                                    </select>
                                    <span class="error" id="processid_err"> </span>
                                </div>

                                <div class="col-md-8">
                                        <label>Enter Inherent Risk:</label>
                                </div>
                                <div class="col-md-12 form-group">
                                    <input type="text" class="form-control" name="name" id="inherent" placeholder="Enter inherent risk" required>
                                    <span class="error" id="inherent_err"> </span>
                                </div>
                                <div class="col-md-8">
                                        <label>Choose Risk Category:</label>
                                        
                                </div>
                                <div class="col-md-12 form-group">                            
                                    <select class="form-control" name="rcat" id="rcat" required>
                                        <option value="" selected>--------------------SELECT Risk Category</option>
                                            <?php
                                            foreach($showriskcat as $category){
                                                $cname=ucfirst($category["name"]);
                                                echo'<option value='.$category["riskcat_id"].'>'.$cname.'</option>';
                                            }                                            
                                            ?>
                                    </select>
                                    <span class="error" id="rcat_err"> </span>                                    
                                </div>                              

                                <div class="col-md-8">
                                        <label>Nominee/Risk Owner:</label>
                                </div>
                                <div class="col-md-12 form-group">
                                    <input type="text" class="form-control" name="nominee" value="super-admin" id="nominee">
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="col-md-8">
                                        <label>Enter Risk Cause:</label>
                                </div>
                                <div class="col-md-12 form-group">
                                    <textarea name="cause" class="form-control" id="cause" cols="20" rows="8" required></textarea>
                                    <span class="error" id="cause_err"> </span>   
                                </div>

                                <div class="col-md-8">
                                        <label>Risk Champion:</label>
                                </div>
                                <div class="col-md-12 form-group">
                                    <select class="form-control" name="reviewer" id="reviewer" required>
                                        <option value="" selected>----------------------SELECT Champion</option>
                                        <?php
                                        foreach($showusers as $user){
                                            $reviewername=ucfirst($user["fname"].'&nbsp;'.$user["sname"]);
                                        echo' <option value='.$user["id"].'>'.$reviewername.'</option>';
                                        }
                                        ?>
                                    </select>
                                    <span class="error" id="reviewer_err"> </span> 
                                </div>
                                <div class="col-md-8">
                                        <label>Reviewer Date:</label>
                                </div>
                                <div class="col-md-12 form-group">
                                    <input type="text" class="form-control" name="rdate" id="datepicker" placeholder="" autocomplete="off">
                                    <span class="error" id="rdate_err"> </span>
                                </div>
                                
                            </div>
                            
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary"
                        data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="button" class="btn btn-primary ml-1 editriskbutton">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Edit Risk</span>
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-----------------------------------end RISK ADD Modals--------------------------------------------------------------->
  
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
                                    <input type="hidden" name="dcid" id="dcid" value="">
                                    <h3>Are you Sure you want to delete?</h3>
                                    <div id="messagedelete"></div>
                                <div style="color:#000;font-weight:600;font-size:29px;text-align:center;">Inherent Risk:<h5 id="dcname"></h5></div>
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

<!------------------------ Include Choices JavaScript drop down--------------------- -->
        <script src="../assets/vendors/choices.js/choices.min.js"></script>
        <script src="../assets/js/pages/form-element-select.js"></script>

 <!---------------------------------SWEET ALERTS----------------------------------------->
     <script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>

  <!----------------------Datatable Simple------------------------------------------------>
    <script src="../assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        if (table1) new simpleDatatables.DataTable(table1);
    </script>
<!----------------------Datatable Simple end------------------------------------------------>

    <script src="../assets/js/pages/horizontal-layout.js"></script>

<!----------------------font awsome------------------------------------------------>
    <script src="../assets/vendors/fontawesome/all.min.js"></script>

   
   <script>
       $(document).ready(function(){
            $('#convert').click(function(){
                var table_content='<table>';
                table_content+=$('#thead').html();
                table_content += $('#table1').html();
                table_content += '</table>';
                $('#file_content').val(table_content);
                $('#convert_form').submit();
            });
        });
   </script>

</body>

</html>
