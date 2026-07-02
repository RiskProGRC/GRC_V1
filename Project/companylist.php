
<?php
include_once'./company/companyClass.php';
$companyClass=new companyClass();
$showcompany=$companyClass->showCompany();

?>
<!DOCTYPE html>
<html lang="en">
<!-_________________Header location______________________->
<?php include_once("../layout/header.php"); ?>

<body>
    <div id="app">
        <div id="main" class="layout-horizontal">

 <!-_________________Navigation location______________________->

            <?php include_once("../layout/nav.php") ?>

            <div class="content-wrapper container">
                
<div class="page-heading">
    <h4>Company Lists</h4>
</div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
    <!-_________________Content location BEGINING______________________->

                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <button onclick="location.href='../Project/addcompany.php'" type="button" class="btn btn-primary btn-userpermission-add" style="float:right;margin-right:30px;"><span class="fa-fw select-all fas">ï•</span>Create Company</button>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>Reference</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Telephone</th>
                                        <th>Website</th>
                                        <th>Address</th>
                                        <th>Logo</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <?php
                                            foreach($showcompany as $company){
                                                
                                                $image="<img src='".$company['logo']."' alt='' width='50px' height='50px'>";
                                            echo'
                                                    <tr>
                                                            <td>C00'.$company["id"].'</td>
                                                            <td>'.$company["company_name"].'</td>
                                                            <td>'.$company["email"].'</td>
                                                            <td>'.$company["phone"].'</td>
                                                            <td>'.$company["website"].'</td>
                                                            <td>'.$company["address"].'</td>
                                                            <td>'.$image.'</td>
                                                            <td>
                                                            <button name="edit" value="Edit" class="btn btn-sm btn-primary edit-button btn-userpermission-delete" id='.$company["id"].'><span class="fa-fw select-all fas">ïŒƒ</span></button>
                                                            <button name="delete" value="Delete" class="btn btn-sm btn-danger delete-button btn-userpermission-delete" id='.$company["id"].'><span class="fa-fw select-all fas">ï‹­</span></button>
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

        <?php include_once("../layout/footer.php"); ?>

        

     <!-----------------------------------RISK Modals--------------------------------------------------------------->
     <!-----------------------------------Company UPDATE Modals--------------------------------------------------------------->
    <div class="modal fade text-left" id="editcompany-modal" tabindex="-1" role="dialog"aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel17">Add Organisation</h3>
                    <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>        
                <form class="form form-horizontal" id="formupdate" action="" method="">
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Company name:</label>
                            </div>
                            <div class="col-md-8 form-group">
                            <input type="hidden" class="form-control" name="companyid" id="cid"
                                    placeholder="First name">
                                <input type="text" class="form-control" name="cname" id="cname"
                                    placeholder="First name">
                            </div>
                            
                            <div class="col-md-4">
                                <label>Email:</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="email"  class="form-control" name="email" id="email"
                                    placeholder="email">
                            </div>                                    
                            <div class="col-md-4">
                                <label>Telephone:</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="text"  class="form-control"  name="phone" id="phone"
                                    placeholder="Telephone">
                            </div>
                            <div class="col-md-4">
                                <label>Website:</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="text"  class="form-control"  name="website" id="website"
                                    placeholder="website">
                            </div>
                            <div class="col-md-4">
                                <label>Address:</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <textarea class="form-control" name="address" id="address" cols="" rows="5" placeholder="e.g P.O.BOX "></textarea>
                            </div>
                        </div><!--end of row--->

                </div>
                <div class="modal-footer">
                <div class="col-12 alert alert-danger" id="messagedisplay" style="text-align:center;font-size:25px;font-weight:600;"></div>
                    <button type="button" class="btn btn-light-secondary"
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

<!-----------------------------------------Modal For ENTITY-------------------------------->


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

<!----------------------font awsome------------------------------------------------>
    <script src="../assets/vendors/fontawesome/all.min.js"></script>

    <!------------------------------SWEET ALERTS---------------------------------->
    <script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>

<!------------- Include Choices select JavaScript ------------------------------------------------>
<script src="../assets/vendors/choices.js/choices.min.js"></script>
<script src="../assets/js/pages/form-element-select.js"></script>

   

</body>

</html>
