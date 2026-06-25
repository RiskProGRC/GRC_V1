<?php
include_once'./risk/riskClass.php';
include_once'./control/controlClass.php';
include_once'./settings/controlstrengthClass.php';
include_once'./settings/controltypeClass.php';
include_once'./settings/reviewerClass.php';
include_once'./process/processClass.php';

$processclass=new processClass();
$showprocess=$processclass->showProcess();

$controlclass=new controlClass();

$cstrengthClass=new controlstrengthClass();
$showcstrength=$cstrengthClass->showcontrolstrength();

$ctypeclass= new controltypeClass();
$ctype=$ctypeclass->showcontroltype();

$riskClass=new riskClass();
$showrisk= $riskClass->showRisk();

$reviewclass= new reviewerClass();
$showreview=$reviewclass->showreviewer();

$cid=$_GET["id"];
$cdetails=$controlclass->fetchcdetails($cid);



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
                  <form id="controlform">
                    <div  class="card">
                        <div class="card-header">
                            <h2>ADD Control</h2>
                        </div>
                        <div class="card-body">
                                <div class="row">
                                <div class="col-md-12 form-group">
                                        <label>Choose Process:</label>
                                        <input type="hidden" name="cid" value="<?=$cid?>">
                                        <select class="form-control choices" onchange="fetchprocess(this.value)" name="process" id="process">
                                            <option value="" selected>----SELECT Process---</option>
                                            <?php
                                            foreach($showprocess as $process){
                                                $selected = ($cdetails["process_id"] == $process["process_id"]) ? "selected" : "";
                                            echo'<option '.$selected.' value='.$process["process_id"].'>'.$process["process_name"].'</option>';

                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label>Choose Risk:</label>
                                        <select class="form-control" name="crisk" id="crisk">
                                         <option value="" selected>----SELECT Risk---</option>
                                            <?php
                                            foreach($showrisk as $risk){
                                                $selected = ($cdetails["risk"] == $risk["risk_id"]) ? "selected" : "";
                                            echo'<option '.$selected.' value='.$risk["risk_id"].' >'.$risk["risk_name"].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label>Enter Controls:</label>
                                        <textarea class="form-control" name="control" id="" rows="3"><?=$cdetails["control"]?></textarea>
                                    </div>
                                    <div class="col-md-6 form-group">
                                         <label>Control Strength:</label>
                                        <select class="form-select" name="cstrength" id="">
                                            <option value="" selected>----SELECT Control Strength---</option>
                                            <?php
                                            foreach($showcstrength as $cs){
                                                $selected = ($cdetails["cstrength"] == $cs["strength_id"]) ? "selected" : "";
                                            echo'<option '.$selected.' value='.$cs["strength_id"].'>'.$cs["cs_name"].'</option>';

                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6 form-group">
                                         <label>Control Type:</label>
                                        <select class="form-select" name="ctype" id="">
                                            <option value="" selected>----SELECT Control Type---</option>
                                            <?php
                                            foreach($ctype as $ct){
                                                $selected = ($cdetails["ctype"] == $ct["ctype_id"]) ? "selected" : "";
                                            echo'<option '.$selected.' value='.$ct["ctype_id"].'>'.$ct["ct_name"].'</option>';

                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                         <label>Reviewer:</label>
                                        <select class="form-select" name="reviewer" id="">
                                            <option value="" selected>SELECT Reviewer---</option>
                                            <?php
                                            foreach($showusers as $user){
                                                $selected = ($cdetails["reviewer"] == $user["id"]) ? "selected" : "";
                                            echo'<option '.$selected.' value='.$user["id"].'>'.$user["fname"].'&nbsp;'.$user["sname"].'</option>';

                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6 form-group">
                                         <label>Review Date:</label>
                                        <input type="text" class="form-control" name="rdate" id="datepicker" value="<?=$cdetails["rdate"]?>" autocomplete="off">
                                    </div> 
                                    
                                    
                                
                            </div><!--end of row--->

                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-lg btn-primary updatecontrol">Update Control</button>
                                </div>
                                <div class="col-md-6">
                                    <a href="../Project/controls" class="btn btn-lg btn-danger">CLOSE</a>
                                </div>

                            </div><!-----end of footer row-->
                                  
                        </div>
                    </div>
                  </form>
                </section>
            </div>

            <!---<div class="col-lg-4">--begining of side table-
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

            </div>---><!-----begining of side table---->
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

<!---------------------------------SWEET ALERTS----------------------------------------->
    <script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>

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

<!------------- Include Choices select JavaScript ------------------------------------------------>
<script src="../assets/vendors/choices.js/choices.min.js"></script>
<script src="../assets/js/pages/form-element-select.js"></script>

   

</body>

</html>
