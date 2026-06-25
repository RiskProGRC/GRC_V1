<?php 
include_once'./settings/likelihoodClass.php';
$likelyclass=new likelihoodClass();
$showlikely= $likelyclass->showlikely();
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
    <h4>Likelihood level Lists</h4>
</div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
    <!-_________________Content location BEGINING______________________->

                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <button class="btn btn-primary addlikely btn-userpermission-add" style="float:right;margin-right:30px;">
                            <span class="fa-fw select-all fas">ï•</span>Add Likelihood<button>
                            
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Likelihood name</th>
                                        <th>Likelihood level</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <tr>
                                     <?php
                                        foreach($showlikely as $likely){
                                            $lname=ucfirst($likely["name"]);
                                        echo'<tr>
                                            <td>'.$i++.'</td>
                                            <td>'.$lname.'</td>
                                            <td>'.$likely["level"].'</td>
                                            <td>
                                            <button class="btn btn-sm btn-primary editlikely btn-userpermission-edit" id='.$likely["id"].'><span class="fa-fw select-all fas">ïŒƒ</span></button>
                                            <button class="btn btn-sm btn-danger deletelikely btn-userpermission-delete" id='.$likely["id"].'><span class="fa-fw select-all fas">ï‹­</span></button>
                                            </td>
                                        </tr>';
                                        }
                                    ?> 
                                </tbody>
                            </table>
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
            <div class="modal fade text-left" id="addlikely-modal" tabindex="-1" role="dialog"aria-labelledby="myModalLabel17" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="myModalLabel17">ADD LIKELIHOOD</h3>
                            <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>        
                        <form id="addlikelyform">
                        <div class="modal-body">
                        <div class="row">
                        <div class="col-md-4">
                            <label>Likelihood name:</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="text" class="form-control" name="name"
                                    placeholder="First name">
                            </div>
                            <div class="col-md-4">
                                <label>Level:</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="number"  class="form-control" name="level"
                                    placeholder="level">
                            </div>           
                            <div class="col-md-4">
                            <label>Description:</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <textarea class="form-control" name="ldesc"  cols="2" rows="5"></textarea>
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
                            <button class="btn btn-primary addlikely-btn">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">ADD Likelihood</span>
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

<!-----------------------------------Edit impact Modals--------------------------------------------------------------->
            <div class="modal fade text-left" id="editlikely-modal" tabindex="-1" role="dialog"aria-labelledby="myModalLabel17" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="myModalLabel17">EDIT Likelihood</h3>
                            <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>        
                        <form id="likelyupdateform">
                        <div class="modal-body">
                        <div class="row">
                        <div class="col-md-4">
                            <label>Likelihood name:</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="hidden" name="lid" id="lid">
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Likelihood name">
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
                                <textarea class="form-control" name="ldesc" id="ldesc"  cols="2" rows="5"></textarea>
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
                            <button name="addaction-btn" class="btn btn-primary updatelikely">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">EDIT LIKELIHOOD</span>
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
                                    <h5 class="modal-title white" id="myModalLabel120">Delete Likelihood
                                    </h5>
                                    <button type="button" class="close" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                </div>
                                <form id="deleteform">
                                <div class="modal-body">
                                <div>
                                    <input type="hidden" name="ldelete" id="ldelete" value="">
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

   

</body>

</html>
