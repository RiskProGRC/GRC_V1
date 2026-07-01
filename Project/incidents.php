<?php 
include_once'./risk/riskClass.php';
include_once'./process/processClass.php';
include_once'./action/actionClass.php';
$processclass=new processClass();
$showprocess=$processclass->showProcess();

$riskclass=new riskClass();
$showrisk=$riskclass->showRisk();

$actionclass=new actionClass();
$showaction=$actionclass->showaction();


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
    <h4>Add Incident</h4>
</div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
    <!-_________________Content location BEGINING______________________->
                <style>
                    tr,td{
                        font-size:13px;
                        font-weight: 800;
                        color: #000;
                    }
                    label{
                        font-size: 13px;
                        font-weight: 800;
                        color: #000;
                    }
                    .form-control,.form-select{
                        font-size: 13px;
                        font-weight: 800;
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
                        <button onclick="location.href='../Project/incidentadd.php'" type="button" class="btn btn-primary btn-userpermission-add" style="float:right;margin-right:30px;">
                        <i class="fas fa-fw fa-plus"></i>Add Incident</button>
                           <!-- <a href="../Project/incidentadd" class="btn btn-primary" style="float:right;margin-right:30px;">
                            <i class="fas fa-fw fa-plus"></i>Add Incident</a>-->
                            
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
<table class="table table-striped table-buss" id="table1">
                                <thead id="thead">
                                    <tr>
                                        <th>Code</th>
                                        <th>Incident</th>
                                        <th>Risk</th>
                                        <th>Date of Loss</th>
                                        <th>Actual Loss</th>
                                        <th>Expected Recovery</th>
                                        <th>Actions</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php 
                                   foreach($showincident as $incident){
                                       $rid=$incident["risk_id"];
                                       $riskname=substr($riskclass->Riskjoin($rid),0,30);

                                       $aid=substr($incident["action"], 0, 30);
                                       $actionname=$actionclass->actionJoins($aid);
                                                                           
                                 echo '<tr>
                                        <td>INC00'.$incident["incident_id"].'</td>
                                        <td style="max-width:220px;white-space:normal;padding:4px 8px;font-size:11px;">'.substr($incident["incident"],0,60).'...</td>
                                        <td>'.$riskname.'</td>
                                        <td>'.$incident["dol"].'</td>
                                        <td>'.$incident["actual"].'</td>
                                        <td>'.$incident["expected"].'</td>
                                        <td>'.$actionname.'</td>
                                        <td>
                                        <button name="edit" value="Edit" class="btn btn-primary btn-sm incidentedit btn-userpermission-edit" id='.$incident["incident_id"].'><i class="fas fa-fw fa-pen"></i></button>
                                        <button name="delete" value="Delete" class="btn btn-sm btn-danger incidentdelete btn-userpermission-delete" id='.$incident["incident_id"].'><i class="fas fa-fw fa-trash"></i></button>
                                         </td>
                                    </tr>';

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
         <!-----------------------------------keyindicator UPDATE Modals--------------------------------------------------------------->
    <div class="modal fade text-left" id="edit-modal" tabindex="-1" role="dialog"aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel17">Edit Incident</h3>
                    <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>        
                <form class="form form-horizontal" id="formupdate" >
                <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label>Enter Incident:</label>
                        <input type="hidden" name="iid" id="iid">
                        <textarea class="form-control" name="incident" id="incident" rows="3"></textarea>
                    </div>
                    
                    <div class="col-md-12 form-group">
                        <label>Choose Process:</label>
                        <select class="form-select"  name="processid" id="processid">
                            <option value="" selected>----SELECT Process---</option>
                            <?php
                            foreach($showprocess as $process){
                            echo'<option value='.$process["process_id"].'>'.$process["process_name"].'</option>';

                                }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-12 form-group">
                        <label>Choose Risk:</label>
                        <select class="form-select" name="selectrisk" id="selectrisk">
                        <?php
                            foreach($showrisk as $risk){
                            echo'<option value='.$risk["risk_id"].'>'.$risk["risk_name"].'</option>';

                                }
                        ?>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Date of Loss:</label>
                        <input type="text" class="form-control" name="dol" id="datepicker" autocomplete="off">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Actual Loss:</label>
                        <input type="number" class="form-control" name="actual" id="actual" placeholder="Actual loss">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Expected Loss:</label>
                        <input type="number" class="form-control" name="expected" id="expected" placeholder="Expected loss" >
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Potential Loss:</label>
                        <input type="number" class="form-control" name="potential" id="potential" placeholder="Potential loss">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Estimated Recovery:</label>
                        <input type="test" class="form-control" name="recovery" id="recovery" placeholder="Estimated Recovery">
                    </div>
                    <div class="col-md-12 form-group">
                        <label>Choose Action:</label>
                        <select class="form-control" name="action" id="action">
                            <option value="" selected>----SELECT Action---</option>
                            <?php
                            foreach($showaction as $action){
                            echo'<option value='.$action["id"].'>'.$action["action"].'</option>';

                                }
                            ?>
                        </select>
                    </div>
                
            
            </div><!--end of row--->

                </div>
                <div class="modal-footer">
                <div class="col-12 alert alert-danger" id="messagedisplay" style="text-align:center;font-size:25px;font-weight:600;"></div>
                    <button type="button" class="btn btn-danger"
                        data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="" name="editCompany" class="incidentupdate btn btn-primary">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">UPDATE</span>
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
                                    <h5 class="modal-title white" id="myModalLabel120">Delete Organisation
                                    </h5>
                                    <button type="button" class="close" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                </div>
                                <form id="deleteform">
                                <div class="modal-body">
                                <div>
                                    <input type="hidden" name="incidentid" id="incidentid" value="">
                                    <h3>Are you Sure you want to delete?</h3>
                                    <div id="messagedelete"></div>
                                <div style="color:#000;font-weight:600;font-size:29px;text-align:center;">Incident Name:<h5 id="dcname"></h5></div>
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
        let table1 = document.querySelector('#table1');
        if (table1) new simpleDatatables.DataTable(table1);
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
