
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
    <h4>Risk Category Lists</h4>
</div>
    <div class="page-content">
        <section class="row">
            <div class="col-6 col-lg-6">
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
                            <button class="btn btn-primary addriskcat btn-userpermission-add" style="float:right;margin-right:30px;">
                            <i class="fas fa-fw fa-plus"></i>Add Risk Category</button>
                            
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
<table class="table table-striped table-buss" id="table1">
                                <thead>
                                    <tr>
                                        <th>Number</th>
                                        <th>Risk Category</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                             <?php 
                             foreach($showRiskCat as $values){  
                             echo '<tr>
                                        <td>'.$values["riskcat_id"].'</td>
                                        <td style="max-width:220px;white-space:normal;padding:4px 8px;font-size:11px;">'.substr($values["name"],0,60).'...</td>
                                        <td>
                                        <button class="btn btn-sm btn-primary editriskcat btn-userpermission-edit" id='.$values["riskcat_id"].'><i class="fas fa-fw fa-pen"></i></button>
                                        <button class="btn btn-sm btn-danger deleteriskcat btn-userpermission-delete" id='.$values["riskcat_id"].'><i class="fas fa-fw fa-trash"></i></button>
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

<!-----------------------------------------Modal For DEpartment-------------------------------->
 <!--Basic Modal ADD MODAL--------------------------->
            <div class="modal fade text-left" id="riskcat-modal" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myModalLabel1">Add RISK CATEGORY</h5>
                                <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <i data-feather="x"></i>
                                </button>
                            </div>
                            <form id="addriskcatform">  
                            <div class="modal-body">
                                <div class="col-md-8">
                                    <label>Enter Risk Category:</label>
                                </div>
                                <div class="col-md-12 form-group">
                                    <input type="text" class="form-control" name="riskcat" id="riskcat"
                                        placeholder="Enter risk category">
                                </div>
                                <div class="col-md-12">
                                    <label>Description:</label>
                                </div>
                                <div class="col-md-12 form-group">
                                    <textarea class="form-control" name="rcdesc"  cols="2" rows="5"></textarea>
                                </div>  
                            </div>
                                

                            <div class="modal-footer form-group">
                                <button type="button" class="btn" data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Close</span>
                                </button>
                                <button class="btn btn-primary addriskcat-btn">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">ADD RISK CATEGORY</span>
                                </button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>

<!-----------------------------------Edit impact Modals--------------------------------------------------------------->
     <div class="modal fade text-left" id="editriskcat-modal" tabindex="-1" role="dialog"aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel17">EDIT RISK CATEGORY</h3>
                    <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>        
                <form id="riskcatupdateform">
                <div class="modal-body">
                 <div class="row">
                    <div class="col-md-8">
                            <label>Enter Risk Category:</label>
                            <div class="col-md-12 form-group">
                                <input type="hidden" name="rcid" id="rcid">
                                <input type="text" class="form-control" name="riskcatname" id="riskcatname"
                                    placeholder="Enter risk category">
                            </div>
                    </div>
                    <div class="col-md-12">
                        <label>Description:</label>
                    </div>
                    <div class="col-md-12 form-group">
                        <textarea class="form-control" name="rcdesc"  id="rcdesc" cols="2" rows="5"></textarea>
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
                    <button name="addaction-btn" class="btn btn-primary updateriskcat">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">EDIT RISK CATEGORY</span>
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
                                    <h5 class="modal-title white" id="myModalLabel120">Delete RISK CATEGORY
                                    </h5>
                                    <button type="button" class="close" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                </div>
                                <form id="deleteform">
                                    <div class="modal-body">
                                    <div>
                                        <input type="hidden" name="rcdelete" id="rcdelete" value="">
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
                                    <button type="button" class="delete-btn btn btn-danger ml-1 riskcatdelete-btn"
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

<!------------------------------SWEET ALERTS---------------------------------->
<script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>

<!----------------------Datatable Simple end------------------------------------------------>

    <script src="../assets/js/pages/horizontal-layout.js"></script>

<!----------------------font awsome------------------------------------------------>
    <script src="../assets/vendors/fontawesome/all.min.js"></script>

   

</body>

</html>
