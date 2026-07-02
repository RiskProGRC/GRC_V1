<?php
include_once'./risk/riskClass.php';
include_once'./department/departmentClass.php';
include_once'./action/actionClass.php';
include_once'./recommend/recommendClass.php';
include_once'./process/processClass.php';

$recommendclass=new recommendClass();

$processClass=new processClass();
//$showprocess=$processClass->showProcess();

$deptClass=new departmentClass();
$showdept=$deptClass->showDept();

$riskClass=new riskClass();
$showrisk= $riskClass->showRisk();

$actionClass=new actionClass();
$showaction=$actionClass->showaction();

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
    label {
    font-size: 14px;
    color: #000;
    font-weight: 600;
    }
    .form-control, .form-select,.choices{
        font-size: 13px;
        font-weight: 800;
        color: #000;
    }
</style>
    <!-_________________Content location BEGINING______________________->
    <div class="page-content">
        <section  class="row">
            <div class="col-lg-2"></div>

            <div class="col-lg-6">
                
                <section  class="section">
                  <form id="addrecommendform">
                    <div  class="card">
                        <div class="card-header">
                            <h2>ADD Recommendations</h2>
                        </div>
                        <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label>Choose Process:</label>
                                        <input type="hidden" name="rdept_id" value="<?=$sdid?>">
                                        <select class="form-control choices" onchange="fetchprocess(this.value)" name="rmdprocess" id="process">
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
                                        <select class="form-control" name="rmdrisk" id="selectrisk">
                                            <option value="" selected>----SELECT Risk---</option>
                                           
                                        </select>
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label>MRC(Management Risk Committee) Recommendation:</label>
                                        <textarea class="form-control" name="mrc" id="" rows="4"></textarea>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label>ARMC(Audit Risk Management Committee) Recommendation:</label>
                                        <textarea class="form-control" name="armc" id="" rows="4"></textarea>
                                    </div>
                                    
                                    <div class="col-md-12 form-group">
                                         <label>Action:</label>
                                        <select class="form-select choices" name="action" id="">
                                            <option value="" selected>----SELECT Action ---</option>
                                            <?php
                                            foreach($showaction as $action){
                                            echo'<option value='.$action["id"].'>'.$action["action"].'</option>';

                                                }
                                            ?>
                                            
                                        </select>
                                    </div>

                                    <div class="col-md-12 form-group">
                                         <label>Status:</label>
                                        <select class="form-select" name="status" id="">
                                            <option value="" selected>----SELECT Action status---</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                            <option value="ongoing">Ongoing</option>
                                            <option value="overdue">Overdue</option>
                                            
                                        </select>
                                    </div>
                                    <div class="col-md-12 form-group">
                                         <label>Timeline:</label>
                                        <input type="text" class="form-control" name="timeline" id="datepicker">
                                    </div>
                                    
                                
                            </div><!--end of row--->

                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-3">
                                    
                                </div>
                                <div class="col-md-6">
                                    <a href="../Project/recommendations" class="btn btn-lg btn-danger">CLOSE</a>
                                    <button type="submit" name="addrecommend" class="btn btn-lg btn-primary addrecommend">Add Recommend</button>
                                </div>
                                <div class="col-md-3">
                                    
                                </div>

                            </div><!-----end of footer row-->
                                  
                        </div>
                    </div>
                  </form>
                </section>
            </div>

           <!--- <div class="col-lg-4">----begining of side table---
            <div class="card">
                <div class="card-header"><h2>ADDED Control</h2></div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Code</th>
                            <th>Control</th>
                        </tr>
                       
                    </table>
                </div>
            </div>

            </div>---begining of side table---->
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
        if (table1) new simpleDatatables.DataTable(table1);
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
