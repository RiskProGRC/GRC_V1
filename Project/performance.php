<?php
include_once'./risk/riskClass.php';
include_once'./department/departmentClass.php';
include_once'./settings/ownerClass.php';
include_once'./keyindicator/keyindicatorClass.php';
include_once'./process/processClass.php';
include_once'./raf/kriClass.php';

$kriclass=new kriClass();
$showkri=$kriclass->fetchkri();
$showperf=$kriclass->performance();

$processClass=new processClass();
$showprocess=$processClass->showProcess();

$ownerclass=new ownerClass();
$showowner=$ownerclass->showOwner();

$deptClass=new departmentClass();
$showdept=$deptClass->showDept();

$riskClass=new riskClass();
$showrisk= $riskClass->showRisk();

$kiClass=new kiClass();





    ?>

<!DOCTYPE html>
<html lang="en">
<!-_________________Header location______________________->
<?php include_once("../layout/header.php"); 

$deptid=$sdid;
$deptname=$deptClass->deptJoins($deptid);//displays the department name 

?>

<body>
    <div id="app">
        <div id="main" class="layout-horizontal">

 <!-_________________Navigation location______________________->

            <?php include_once("../layout/nav.php") ?>

            <div class="content-wrapper container">
                
<style>
    .divider{
        color: blue;
    }
    .divider .divider-text:after, .divider .divider-text:before {
        border-top: 1px solid #0570db;
    }
    hr{
        border-top: 1px solid blue;
    }
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
    .rapetite{
        border:3px solid #4103ff9e;
        height: 40px;
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
    thead{
        font-size: 12px;
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
</style>
    <!-_________________Content location BEGINING______________________->
    <div class="page-content">
        <section  class="row">
            <div class="col-lg-2"></div>

            <div class="col-lg-6">
                
                <section  class="section">
                  <form id="addkiform">
                    <div  class="card">
                        <div class="card-header">
                            <h2>Add KRI </h2>
                        </div>
                        <div class="card-body">
                                <div class="row">
                                    
                                    <div class="col-md-12 form-group">
                                        <label>Choose Process:</label>
                                        <input type="hidden" value="<?=$sdid?>" name="dept_id">
                                        <select class="form-control choices" onchange="fetchprocess(this.value)" name="process" id="processid">
                                            <option value="" selected>----SELECT Process---</option>
                                            <?php
                                            foreach($showprocess as $process){
                                            echo'<option value='.$process["process_id"].'>'.$process["process_name"].'&nbsp;&nbsp;('.$deptname.')</option>';

                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label>Choose Risk:</label>
                                        <select class="form-control" name="risk" id="selectrisk">
                                            <option value="" selected>----SELECT Risk--</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label>Enter KRI Measure Name:</label>
                                        <input type="text" class="form-control" name="measure">                                        
                                    </div>

                                    <div class="divider">
                                        <div class="divider-text">Measurement</div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>Choose Risk Apetite:</label>
                                        <select class="form-control" name="apetite" id="apetite">
                                            <option value="" selected>----SELECT Apetite--</option>
                                                <?php
                                                    foreach($showperf as $perform){                                                
                                                    echo'<option value='.$perform["id"].'>'.$perform["pname"].'</option>';
                                                    }
                                                ?>

                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Enter Risk Apetite:</label>
                                        <input type="number" class="form-control rapetite" name="rapetite">                                        
                                    </div>
                                    <div class="col-md-5 form-group">                                        
                                        <label>Description:</label>
                                        <textarea name="description" id="" class="form-control"></textarea>                                                                                 
                                    </div>
                                                                       
                                    <div class="col-md-12 form-group">
                                            <table class="table table-striped" >
                                                <thead id="thead">
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>KRI(Key Risk indicator)</th>
                                                        <th>Risk Limit</th>
                                                        <th>Acceptable/Low Target</th>
                                                        <th>Moderate Target</th>
                                                        <th>Unacceptable/Severe Target</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        foreach($showkriparameter as $kri){
                                                            
                                                            //$apetite=$kri["apetite"];
                                                            //$apt=$kriClass->apetite($apetite);
                                                            ?>

                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td>40</td>
                                                            <td class="low">0-50                                                     
                                                            </td>
                                                            <td class="moderate"> 51-70                                            
                                                            </td>
                                                            <td class="severe"> 71-100                                            
                                                            </td>
                                                        </tr>
                                                
                                                <?php } ?> 
                                                </tbody>
                                            </table>                                        
                                    </div>    
                                         
                                    <hr> 
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
                                    <a href="../Project/kpi" class="btn btn-lg btn-danger">CLOSE</a>
                                    <button name="addki" class="btn btn-lg btn-primary addperform">Add KRI</button>
                                </div>
                                <div class="col-md-3">
                                    
                                    </div>

                            </div><!-----end of footer row-->
                                  
                        </div>
                    </div><!---end of card--->
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
