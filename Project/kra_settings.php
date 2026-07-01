<?php 
include_once'../Project/raf/kriClass.php';
$kriClass= new kriClass();


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
    <h4>Add KRI PARAMETERS</h4>
</div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
    <!-_________________Content location BEGINING______________________->
                 <style>
                    th{
                        color: #fff;
                    }
                    tr,td{
                        font-size:13px;
                        font-weight: 600;
                        color: #000;
                    }
                    label,b {
                        
                        font-size: 13px;
                        
                        font-weight: 800;
                    }
                    .form-control{
                        font-size: 12px;
                        font-weight: 800;
                        padding: 3px 5px;
                        
                        
                    }
                    .choices{
                        font-size: 14px;
                        font-weight: 800;
                        color: #000;
                        padding: 2px 2px;
                    }
                    .form-group {
                        margin-bottom: 0.2rem;
                    }
                    .form-group label{
                        color: #000 !important;
                    }
                    td.severe {
                        background-color: red;
                        color:#fff;
                    }
                    td.moderate {
                        background-color: #ffcb0d;
                        color:#fff;
                    }
                    td.low {
                        background-color: #518503;
                        color:#fff;
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
                <form method="POST" id="convert_form" action="export.php">
                    <div class="card">
                        <div class="card-header">
                        <input type="hidden" name="file_content" id="file_content">
                        <button onclick="location.href='../Project/parameteradd.php'" type="button" class="btn btn-primary btn-userpermission-add" style="float:right;margin-right:30px;">
                        <i class="fas fa-fw fa-plus"></i>Add KRI Parameters</button>
                           <!-- <a href="../Project/parameteradd" class="btn btn-primary" style="float:right;margin-right:30px;">
                            <i class="fas fa-fw fa-plus"></i>Add KRI</a>-->
                           <!-- <button type="button" name="convert" id="convert" class="btn btn-primary convert" style="float:right;margin-right:30px;">EXPORT</button>     
-->                     </div>
                        <div class="card-body">
                            <div class="table-responsive">
<table class="table table-striped table-buss" id="table1">
                                <thead id="thead">
                                    <tr>
                                        <th>ID</th>
                                        <th>KRI Measure</th>
                                        <th>Risk Limit</th>
                                        <th>Acceptable/Low Target</th>
                                        <th>Moderate Target</th>
                                        <th>Unacceptable/Severe Target</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach($showkriparameter as $kri){
                                            
                                            //$apetite=$kri["apetite"];
                                            //$apt=$kriClass->apetite($apetite);
                                            ?>

                                           <tr>
                                            <td><?=$kri["id"]?></td>
                                            <td><?=$kri["pname"]?></td>
                                            <td><?=$kri["rlimit"]?></td>
                                            <td class="low"><?=$kri["fmngt"]?> - <?=$kri["tmngt"]?>                                                     
                                            </td>
                                            <td class="moderate"><?=$kri["fboard"]?> - <?=$kri["tboard"]?>                                             
                                            </td>
                                            <td class="severe"><?=$kri["fmboard"]?> - <?=$kri["tmboard"]?>                                             
                                            </td>
                                            <td>
                                            <button name="edit" value="Edit" class="btn btn-sm btn-primary parameteredit btn-userpermission-edit" id="<?=$kri['id']?>" ><i class="fas fa-fw fa-pen"></i></button>
                                            <button  name="delete" value="Delete" class="btn btn-sm btn-danger parameterdelete btn-userpermission-delete" ><i class="fas fa-fw fa-trash"></i></button>
                                            </td>
                                        </tr>
                                   
                                   <?php } ?> 
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

        <?php include_once'../layout/footer.php'; ?>

            <!-----------------------------------action UPDATE Modals--------------------------------------------------------------->
    <div class="modal fade text-left" id="edit-modal" tabindex="-1" role="dialog"aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel17">UPDATE PARAMETERS</h3>
                    <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>        
                <form class="form form-horizontal" id="updateparameterform">
                <div class="modal-body">
                <div class="row">
                <div class="col-md-12 form-group">
                    <label>Enter Parameter Name:</label>
                    <input type="hidden" class="form-control" name="parameterid" id="parameterid">
                    <input type="text" class="form-control" name="p_name" id="p_name">
                </div>
                <div class="col-md-6 form-group">
                    <label>Choose Risk Apetite Details:</label>
                    <select class="form-control" name="apetite" id="apetite">
                        <option value="" selected>----SELECT Apetite Details---</option>
                        <option value="1">Percentages</option>
                        <option value="2">Amount</option>
                        <option value="3">Days</option>
                        <option value="4">People</option>
                        <option value="5">Number</option>
                    </select>
                </div>
                <div class="col-md-6 form-group">
                    <label>Choose Risk Apetite Type:</label>
                    <select class="form-control" name="type" id="type">
                        <option value="" selected>----SELECT Apetite Type---</option>
                        <option value="0">Maximising Apetite</option>
                        <option value="1">Minimising Apetite</option>
                        
                    </select>
                </div>
                <hr>
                <div class="col-md-12 form-group">
                    <label>Enter Risk Apetite Limit:</label>
                        <div class="row">
                            <div class="col-md-2 form-group">
                            </div>
                            <div class="col-md-6 form-group">
                            <b>From:</b> <input class="form-control" name="rlimit" id="rlimit" type="text">
                            </div>

                        </div>

                </div><hr>     
                <div class="col-md-12 form-group">
                    <label>Enter Range For Management Escalation:</label>
                        <div class="row">
                            <div class="col-md-2 form-group">
                                
                            </div>
                            <div class="col-md-4 form-group">
                            <b>From:</b> <input class="form-control" name="fmngt" id="fmngt" type="text">
                            </div>
                            <div class="col-md-4 form-group">
                            <b>To:</b><input class="form-control" name="tmngt" id="tmngt" type="text"> 
                            </div>

                        </div>
                </div>
                <hr>
                <div class="col-md-12 form-group">
                    <label>Enter Range For Board Committe Escalation:</label>
                    <div class="row">
                            <div class="col-md-2 form-group">
                                
                            </div>
                            <div class="col-md-4 form-group">
                            <b>From:</b> <input class="form-control" name="fboard" id="fboard"  type="text">
                            </div>
                            <div class="col-md-4 form-group">
                            <b>To:</b><input class="form-control" name="tboard" id="tboard"  type="text"> 
                            </div>

                        </div>
                </div>
                <hr>
                <div class="col-md-12 form-group">
                    <label>Enter Range To Main Board Escalation:</label>
                    <div class="row">
                            <div class="col-md-2 form-group">
                                
                            </div>
                            <div class="col-md-4 form-group">
                            <b>From:</b> <input class="form-control" name="fmboard" id="fmboard"  type="text">
                            </div>
                            <div class="col-md-4 form-group">
                            <b>To:</b><input class="form-control" name="tmboard" id="tmboard" type="text"> 
                            </div>

                        </div>
                </div>
                    
                </div><!--end of row--->

                </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn-danger"
                        data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="" name="editCompany" class="update btn btn-primary">
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
                                    <input type="hidden" name="dcid" id="dcid" value="">
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
