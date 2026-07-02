<?php
include_once'../Project/raf/kriClass.php';
include_once'./action/actionClass.php';
include_once'./keyindicator/keyindicatorClass.php';
$kiclass=new kiClass();
$showkiapprov=$kiclass->showKiappr();
$actionClass=new actionClass();
$showaction=$actionClass->showaction();

$kriClass=new kriClass();
$showraf=$kriClass->fetchkriparameter();




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
                  <form id="addkriform">
                    <div  class="card">
                        <div class="card-header">
                            <h2>ADD Risk Performance</h2>
                        </div>
                        <div class="card-body">
                                <div class="row">
                                <div class="col-md-12 form-group">
                                        <label>Choose KPI(Key Performance Indicator):</label>
                                        <select name="kpi" id="" class="form-select choices">
                                            <option value="" selected>------------------Choose Key Performance Indicator</option>
                                            <?php
                                            foreach($showkiapprov as $ki){
                                                echo'<option value='.$ki["id"].'>'.$ki["ki"].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label>Choose KRI(Key Risk Indicator):</label>
                                        <select name="kri" id="" class="form-select choices">
                                            <option value="" selected>------------------Choose Key Risk Indicator</option>
                                            <?php
                                            foreach($showraf as $raf){
                                                echo'<option value='.$raf["id"].'>'.$raf["pname"].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-12 form-group">
                                        <label>Enter Risk Perfomance:</label>
                                        <input type="number" class="form-control" name="perform">
                                    </div>

                                    
                                    <div class="col-md-12 form-group">
                                        <label>Enter Date:</label>
                                        <input type="text" name="date" id="datepicker" class="form-control">
                                        <input type="hidden" name="did" id="did" class="form-control" value="<?=$sdid?>">
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label>Choose Action:</label>
                                        <select name="action" id="action" class="form-select choices">
                                            <option value="" selected>------------------Choose Action</option>
                                            <?php
                                            foreach($showaction as $action){
                                                echo'<option value='.$action["id"].'>'.$action["action"].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label>Enter Business Objectives:</label>
                                        <textarea name="b_obj" id="" class="form-control" cols="30" rows="6"></textarea>
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label>Choose Owner:</label>
                                        <select name="owner" id="owner" class="form-select choices">
                                            <option value="" selected>------------------Choose Owner</option>
                                            <?php
                                            foreach($showusers as $users){
                                                echo'<option value='.$users["id"].'>'.$users["fname"].'&nbsp'.$users["sname"].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    
                                    
                            </div><!--end of row--->

                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-3">
                                    
                                </div>
                                <div class="col-md-6">
                                    <a href="../Project/kri" class="btn btn-danger">CLOSE</a>
                                    <button type="submit" name="addkri" class="btn btn-primary addkri">ADD Performance</button>
                                </div>
                                <div class="col-md-3">
                                    
                                </div>

                            </div><!-----end of footer row-->
                                  
                        </div>
                    </div>
                  </form>
                </section>
            </div>

           <!-- <div class="col-lg-4">----begining of side table---
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

            </div>-->
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

<!------------------------------SWEET ALERTS---------------------------------->
<script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>

<!----------------------font awsome------------------------------------------------>
    <script src="../assets/vendors/fontawesome/all.min.js"></script>

<!------------- Include Choices select JavaScript ------------------------------------------------>
<script src="../assets/vendors/choices.js/choices.min.js"></script>
<script src="../assets/js/pages/form-element-select.js"></script>

   

</body>

</html>
