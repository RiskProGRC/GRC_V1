<?php 

include_once'./settings/impactClass.php';
include_once'./settings/likelihoodClass.php';

$impactclass= new impactClass();
$likelihoodclass= new likelihoodClass();

$showimpact=$impactclass->showImpact();
$showlikely=$likelihoodclass->showlikely();


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
    <h4>Control strength Lists</h4>
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
                            <Button class="btn btn-primary addcs btn-userpermission-add" style="float:right;margin-right:30px;">
                            <i class="fas fa-fw fa-plus"></i>Add Control strength</Button>
                            
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
<table class="table table-striped table-buss" id="table1">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Control Strength Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    foreach($showcstrength as $cs){
                                    echo' 
                                     <tr>
                                            <td>'.$cs["strength_id"].'</td>
                                            <td style="max-width:180px;white-space:normal;padding:4px 8px;font-size:11px;">'.substr($cs["cs_name"],0,50).'...</td>
                                            <td>
                                            <button class="btn btn-sm btn-primary editcs btn-userpermission-edit" id='.$cs["strength_id"].'><i class="fas fa-fw fa-pen"></i></button>
                                            <button class="btn btn-sm btn-danger deletecs btn-userpermission-delete" id='.$cs["strength_id"].'><i class="fas fa-fw fa-trash"></i></button>
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
        
        </div>
        
    </div>
 <!-----------------------------------ADD Action Modals--------------------------------------------------------------->
 <div class="modal fade text-left" id="addcs-modal" tabindex="-1" role="dialog"aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel17">ADD Control STRENGTH</h3>
                    <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>        
                <form id="addcsform">
                <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                    <label>Control Strength:</label>
                    </div>
                    <div class="col-md-12 form-group">
                        <input type="text" class="form-control" name="name"
                            placeholder="Control strength name">
                    </div>
                    <hr>
                    
                    <div class="col-md-12">
                    <label>Description:</label>
                    </div>
                    <div class="col-md-12 form-group">
                        <textarea class="form-control" name="desc"  cols="2" rows="5"></textarea>
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
                    <button class="btn btn-primary addcs-btn">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">ADD Control Strength</span>
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>

<!-----------------------------------Edit impact Modals--------------------------------------------------------------->
        <div class="modal fade text-left" id="editcs-modal" tabindex="-1" role="dialog"aria-labelledby="myModalLabel17" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="myModalLabel17">EDIT Control STRENGTH</h3>
                            <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>        
                        <form id="editcsform">
                        <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                            <label>Control Strength:</label>
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="hidden" name="csid" id="csid">
                                <input type="text" class="form-control" name="csname" id="csname"
                                    placeholder="Control strength name">
                            </div>
                            <hr>
                            
                            <div class="col-md-12">
                            <label>Description:</label>
                            </div>
                            <div class="col-md-12 form-group">
                                <textarea class="form-control" name="csdesc" id="csdesc" cols="2" rows="5"></textarea>
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
                            <button class="btn btn-primary updatecs">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Edit Control Strength</span>
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
<!-----------------------------------DELETE  Modal ---------------------------------------------------------------->
            <div class="modal fade text-left" id="csdelete-modal" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel120" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                            role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-danger">
                                    <h5 class="modal-title white" id="myModalLabel120">Delete Control Strength
                                    </h5>
                                    <button type="button" class="close" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                </div>
                                <form id="deleteform">
                                <div class="modal-body">
                                <div>
                                    <input type="hidden" name="csdelete" id="csdelete" value="">
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
                                    <button type="button" class="csdelete-btn btn btn-danger ml-1"
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

   

</body>

</html>
