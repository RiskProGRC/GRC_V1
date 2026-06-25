
<?php
include_once'./company/companyClass.php';
include_once'./department/departmentClass.php';

$departmentClass=new departmentClass();
$showdept=$departmentClass->showDept();

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
    <h4>Entity Lists</h4>
</div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
    <!-_________________Content location BEGINING______________________->

                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <!--<a href="../Project/add_entity" class="btn btn-primary" style="float:right;margin-right:30px;">-->
                            <button onclick="location.href='../Project/add_entity.php'" type="button" class="btn btn-primary btn-userpermission-add" style="float:right;margin-right:30px;">
                            <span class="fa-fw select-all fas">ï•</span>Create Entity</a></button>
                            
                            
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>Reference</th>
                                        <th>Company</th>
                                        <th>Entity Name</th>
                                        <th>Entity Owner</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                foreach($showdept as $dept){ 
                                    $uid=$dept["owner"];
                                    $username=$userclass->userjoin($uid);

                                    $cid=$dept["company"];
                                    $companyname=$companyClass->companyJoins($cid);

                              echo'  <tr>
                                        <td>ENT00'.$dept["dept_id"].'</td>
                                        <td>'.$companyname.'</td>
                                        <td>'.$dept["dept_name"].'</td>
                                        <td>'.$username.'</td>
                                        <td>
                                        <input type="button" name="edit" value="Edit" class="btn btn-sm btn-primary edit-dept btn-userpermission-edit" id='.$dept["dept_id"].'>
                                        <input type="button" name="edit" value="Delete" class="btn btn-sm btn-danger delete-dept btn-userpermission-delete" id='.$dept["dept_id"].'>
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
          <!-----------------------------------entity UPDATE Modals--------------------------------------------------------------->
    <div class="modal fade text-left" id="editdept-modal" tabindex="-1" role="dialog"aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel17">Add Entity</h3>
                    <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>        
                <form class="form form-horizontal" id="deptupdate">
                <div class="modal-body">
                <div class="row">
                            <div class="col-md-3">
                                <label>Entity Name:</label>
                            </div>
                            <div class="col-md-9 form-group">
                            <input type="hidden"  class="form-control" name="eid" id="eid"
                                    placeholder="Entity name">
                                <input type="text"  class="form-control" name="ename" id="ename"
                                    placeholder="Entity name">
                            </div> 
                            <div class="col-md-3">
                                <label>Select Company:</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <select class="form-control" name="company" id="company">
                                    <option value="" selected>--------------Selected Company----------</option>
                                    <?php
                                    foreach($showcompany as $company){
                                    echo'<option value='.$company["id"].'>'.$company["company_name"].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>                                   
                            
                            <div class="col-md-3">
                                <label>Owner:</label>
                            </div>
                            <div class="col-md-9 form-group">
                            <select class="form-control" name="owner" id="owner">
                                <option value="" selected>---------Choose Owner------</option>
                                    <?php
                                    foreach($showusers as $user){
                                    echo'<option value='.$user["id"].' >'.$user["fname"].'&nbsp;'.$user["sname"].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Entity Functions:</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <textarea class="form-control" name="function" id="function" cols="" rows="5" placeholder=""></textarea>
                            </div>
                                
                            
                        </div><!--end of row--->

                </div>
                <div class="modal-footer">
                <!--<div class="col-12 alert alert-danger" id="messagedisplay" style="text-align:center;font-size:25px;font-weight:600;"></div>-->
                    <button type="button" class="btn btn-danger"
                        data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="" name="update" class="deptupdate btn btn-primary">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">UPDATE</span>
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
     <!-----------------------------------COMPANY EDIT Modals--------------------------------------------------------------->
     <!-----------------------------------DELETE  ENTITY ---------------------------------------------------------------->
     <div class="modal fade text-left" id="deptdelete-modal" tabindex="-1" role="dialog"
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
                                    <input type="hidden" name="entityid" id="entityid" value="">
                                    <h3>Are you Sure you want to delete?</h3>
                                    <div id="messagedelete"></div>
                                <div style="color:#000;font-weight:600;font-size:29px;text-align:center;">Entity Name:<div id="entname">dfsdfsdfd</div></div>
                                </div>
                                </div>
                                <div class="modal-footer">
                                    
                                    <button type="button" class="btn btn-light-secondary"
                                        data-bs-dismiss="modal">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Close</span>
                                    </button>
                                    <button type="button" class="delete-btn btn btn-danger ml-1 "
                                        data-bs-dismiss="modal">
                                        <i class="bx bx-check d-block d-sm-none "></i>
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
