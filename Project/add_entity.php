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
                
<style>
    .card>.card-header{
        border-bottom: 1px solid #d2d2d2;
        margin:10px 0px;
        background: #fafafa;
    }
    .card>.card-header>h2{
        text-align: center;
        font-weight: 900;
        font-size: 25px;
        
    }
</style>
    <!-_________________Content location BEGINING______________________->
    <div class="page-content">
        <section  class="row">
            <div class="col-lg-2"></div>

            <div class="col-lg-6">
                
                <section  class="section">
                  <form id="entityform">
                    <div  class="card">
                        <div class="card-header">
                            <h2>ADD Entity</h2>
                        </div>
                        <div class="card-body">
                                <div class="row">

                                    <div class="col-md-4">
                                        <label>Entity Name:</label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <input type="text"  class="form-control" name="name"
                                            placeholder="Entity name">
                                    </div> 
                                    <div class="col-md-4">
                                        <label>Select Company:</label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <select class="form-control" name="company" id="">
                                            <option value="" selected>--------------Selected Company----------</option>
                                            <?php
                                            foreach($showcompany as $company){
                                            echo'<option value='.$company["id"].'>'.$company["company_name"].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>                                   
                                    
                                    <div class="col-md-4">
                                        <label>Owner:</label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                    <select class="form-control" name="owner" id="">
                                        <option value="" selected>---------Choose Owner------</option>
                                            <?php
                                            foreach($showusers as $user){
                                            echo'<option value='.$user["id"].' >'.$user["fname"].'&nbsp;'.$user["sname"].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Entity Functions:</label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <textarea class="form-control" name="function" id="" cols="" rows="5" placeholder=""></textarea>
                                    </div>
                                    
                                
                            </div><!--end of row--->

                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <button name="adddepartment" class="btn btn-lg btn-primary addentity">Add Entity</button>
                                </div>
                                <div class="col-md-6">
                                    <a href="entitylist.php" class="btn btn-lg btn-danger">CLOSE</a>
                                </div>
                            </div><!-----end of footer row-->
                                  
                        </div>
                    </div>
                  </form>
                </section>
            </div>

           
    <!-_________________Content location END______________________->
                
            
        </section>
    </div>

  </div>





 <!-_________________Footer location______________________->

        <?php include_once("../layout/footer.php"); ?>

        

     <!-----------------------------------RISK Modals--------------------------------------------------------------->
     
    
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
