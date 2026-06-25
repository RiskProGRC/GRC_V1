
<?php
include_once'./settings/impactClass.php';
include_once'./settings/likelihoodClass.php';
include_once'./settings/riskcategoryClass.php';
include_once'./risk/riskClass.php';
include_once'./join/JoindpClass.php';
include_once'./department/departmentClass.php';
include_once'./settings/reviewerClass.php';
include_once'./process/processClass.php';

$processClass=new processClass();
$showprocess=$processClass->showProcess();
//review
$reviewerclass=new reviewerClass();
$showreviewer= $reviewerclass->showreviewer();
//department
$deptClass= new departmentClass();
$showdept=$deptClass->showDept();
//dperatment & process joins
$joindpClass=new joindpClass();
$showdp=$joindpClass->riskDept();
//risk
$riskClass= new riskClass();
//riskcategoty
$riskcatClass=new riskCatClass();
$riskCat=$riskcatClass->showRiskCat();
//impact
$impactClass=new impactClass();
$showImpact= $impactClass->showImpact();
//likrelihood
$likelyClass=new likelihoodClass();
$showlikely=$likelyClass->showlikely();

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
                h4{
                    text-align: center;
                }
                label {
                    font-size: 15px;
                    color: #000;
                }
                .form-control,.form-select{
                    font-size: 13px;
                    font-weight: 800;
                    color: #000;
                    border: 1px solid #8c8c8c;
                }
                .nav-tabs{
                    font-size: 14px;
                    font-weight: 800;
                }
                
            </style>  
<div class="page-heading">
    <h4>Enter Risk</h4>
    <div class="website" >
    </div>
</div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
    <!-_________________Content location BEGINING______________________->
  <!-- // Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" id="riskform" action="" method="POST">
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="col-md-8">
                                            <label>Choose Entity:</label>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <select class="form-control" name="dept"  id="dept_id" required>
                                                <option value="" selected>--------------------SELECT Entity</option>
                                                <?php
                                                foreach($showdept as $dp){
                                                    $deptid=$dp["dept_id"];
                                                    $deptname=$deptClass->deptJoins($deptid);
                                               echo' <option value='.$dp["dept_id"].'>'.$deptname.'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-8">
                                                <label>Select Process:</label>
                                                <button class="process btn btn-sm btn-primary"><span class="fa fa-plus"></span></button>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <select class="form-select" name="process" id="process_id" required>
                                                <option value="" selected>----------------------SELECT Process</option>
                                                <?php
                                                foreach($showprocess as $process){
                                                    $processname=ucfirst($process["process_name"]);
                                                   
                                               echo' <option value='.$process["process_id"].'>'.$processname.'</option>';
                                                }
                                                ?>

                                            </select>
                                        </div>
                                        
                                        <div class="col-md-8">
                                                <label>Enter Inherent Risk:</label>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter inherent risk" required>
                                        </div>
                                        <div class="col-md-8">
                                                <label>Choose Risk Category:</label>
                                                <button class="btn btn-sm btn-primary rcategory" ><span class="fa fa-plus"></span></button>
                                        </div>
                                        <div class="col-md-12 form-group">
                                        
                                            <select class="form-select" name="rcat" id="rcat" required>
                                                <option value="" selected>--------------------SELECT Risk Category</option>
                                                    <?php
                                                    foreach($riskCat as $category){
                                                        $cname=ucfirst($category["name"]);
                                                        echo'<option value='.$category["riskcat_id"].'>'.$cname.'</option>';
                                                    }
                                                    
                                                    ?>
                                            </select>
                                           
                                        </div>

                                        

                                        <div class="col-md-8">
                                                <label>Nominee/Risk Owner:</label>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <input type="text" class="form-control" name="nominee" value="super-admin" id="nominee">
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-8">
                                                <label>Enter Risk Cause:</label>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <textarea name="cause" class="form-control" id="cause" cols="20" rows="4" required></textarea>
                                        </div>
                                        <div class="col-md-8">
                                                <label>Enter Consequences:</label>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <textarea name="consequence" class="form-control" id="consequence" cols="20" rows="4" required></textarea>
                                        </div>

                                        <div class="col-md-8">
                                                <label>Risk Champion:</label>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <select class="form-select" name="reviewer" id="reviewer" required>
                                                <option value="" selected>----------------------SELECT Reviewer</option>
                                                <?php
                                                foreach($showusers as $user){
                                                    $reviewername=ucfirst($user["fname"].'&nbsp;'.$user["sname"]);
                                               echo' <option value='.$user["id"].'>'.$reviewername.'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                                <label>Reviewer Date:</label>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <input type="text" class="form-control" name="rdate" id="datepicker" placeholder="" autocomplete="off">
                                        </div>
                                       


                                    </div>
                                    

                                    
                                </div>

                                    
                                    <div class="col-12 d-flex justify-content-end">
                                        <a href="../Project/risklist.php" class="btn btn-danger me-1 mb-1">CLOSE</a>
                                        <button name="" id="addrisk" class="btn btn-primary me-1 mb-1 addrisk">Submit</button>
                                        
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- // Basic multiple Column Form section end -->


    <!-_________________Content location END______________________->
                
            </div>
        </section>
    </div>

  </div>





 <!-_________________Footer location______________________->

        <?php include_once("../layout/footer.php"); ?>
        </div>
        
    </div>
<!-----------------------script for dynamic drop down----------------------------------->
      
      
<!-----------------------------------------Modal For ENTITY-------------------------------->
 <
    <!---------------------------------------- Risk category  Modal-------------------------------------------------------------------------------->
 

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

 <!---------------------------------SWEET ALERTS----------------------------------------->
     <script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>

<!----------------------font awsome------------------------------------------------>
    <script src="../assets/vendors/fontawesome/all.min.js"></script>

   

</body>

</html>
