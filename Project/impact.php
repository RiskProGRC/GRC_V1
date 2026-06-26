<?php 
include_once'./settings/impactClass.php';
$impactclass=new impactClass();
$showimpact= $impactclass->showImpact();



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
    <h4>Impact level Lists</h4>
</div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
    <!-_________________Content location BEGINING______________________->

                                <style>
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
                            <button class="btn btn-primary addimpact btn-userpermission-add" style="float:right;margin-right:30px;">
                            <i class="fas fa-fw fa-plus"></i>Add Impact</button>
                            
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
<table class="table table-striped table-buss" id="table1">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Impact name</th>
                                        <th>Impact level</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <tr>
                                     <?php
                                        foreach($showimpact as $impact){
                                            $iname=ucfirst($impact["name"]);
                                        echo'<tr>
                                            <td>'.$i++.'</td>
                                            <td>'.$iname.'</td>
                                            <td>'.$impact["level"].'</td>
                                            <td>
                                            <a href="#" class="btn btn-sm btn-primary editimpact userpermission-edit" id='.$impact["id"].'><i class="fas fa-fw fa-pen"></i></a>
                                            <a href="#" class="btn btn-sm btn-danger deleteimpact userpermission-delete" id='.$impact["id"].'><i class="fas fa-fw fa-trash"></i></a>
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
      <!-----------------------------------ADD Action Modals--------------------------------------------------------------->
      <div class="modal fade text-left" id="addimpact-modal" tabindex="-1" role="dialog"aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel17">ADD IMPACT</h3>

                    <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>     
                 
                <form id="addimpactform">
                <div class="modal-body">
                    <div id="message"></div>
                <div class="row">
                <div class="col-md-4">
                    <label>Impact name:</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="text" class="form-control" name="impname" id="impname"
                            placeholder="Impact name">
                            <span class="error" id="impname_err"> </span>
                    </div>
                    <div class="col-md-4">
                        <label>Level:</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="number" class="form-control" name="implevel" id="implevel"
                            placeholder="level">
                            <span class="error" id="implevel_err"> </span>
                    </div>  
                    <div class="col-md-4">
                        <label>Description:</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <textarea class="form-control" name="impdesc" id=""></textarea>
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
                    <button class="btn btn-primary addimpact-btn">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">ADD IMPACT</span>
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>

<!-----------------------------------Edit impact Modals--------------------------------------------------------------->
     <div class="modal fade text-left" id="editimpact" tabindex="-1" role="dialog"aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel17">EDIT IMPACT</h3>
                    <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>        
                <form id="impactupdateform">
                <div class="modal-body">
                 <div class="row">
                  <div class="col-md-4">
                    <label>Impact name:</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="hidden" name="iid" id="iid">
                        <input type="text" class="form-control" name="name" id="name"
                            placeholder="Impact name">
                    </div>
                    <div class="col-md-4">
                        <label>Level:</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="number"  class="form-control" name="level" id="level"
                            placeholder="level">
                    </div>  
                    <div class="col-md-4">
                        <label>Description:</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <textarea class="form-control" name="impdesc"  id="descimp"></textarea>
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
                    <button name="addaction-btn" class="btn btn-primary updateimpact">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">EDIT IMPACT</span>
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
 <!-----------------------------------DELETE  Modal ---------------------------------------------------------------->
            <div class="modal fade text-left" id="delete-modal" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel120" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                            role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-danger">
                                    <h5 class="modal-title white" id="myModalLabel120">Delete IMPACT
                                    </h5>
                                    <button type="button" class="close" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                </div>
                                <form id="deleteform">
                                <div class="modal-body">
                                <div>
                                    <input type="hidden" name="impdelete" id="impdelete" value="">
                                    <h3>Are you Sure you want to delete?</h3>
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
    
 <!-_________________Footer location______________________->

        <?php include_once'../layout/footer.php'; ?>
        
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

 <!------------------------------SWEET ALERTS---------------------------------->
     <script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>

<!----------------------Datatable Simple end------------------------------------------------>

    <script src="../assets/js/pages/horizontal-layout.js"></script>

<!----------------------font awsome------------------------------------------------>
    <script src="../assets/vendors/fontawesome/all.min.js"></script>

   
</body>

</html>
