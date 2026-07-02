<?php

include_once'./control/controlClass.php';
include_once'./settings/impactClass.php';
include_once'./settings/likelihoodClass.php';

$impactclass=new impactClass();
$showimpact=$impactclass->showImpact();

$likelyclass= new likelihoodClass();
$showlikely=$likelyclass->showlikely();




$controlclass=new controlClass();
$showcontrolass=$controlclass->showcontrolass();

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
        margin:1px 0px;
        background: #fafafa;
    }
    .card>.card-header>h2{
        text-align: center;
        font-weight: 900;
        font-size: 20px;
        
    }
    label {
    font-size: 18px;
    color: #000;
    font-weight: 600;
    }
    .form-control, .form-select{
        font-size: 13px;
        font-weight: 800;
        color: #000;
    }
    .choices{
        font-size: 10px;
        font-weight: 800;
        color: #000;
    }
    
    .divider-text{
        color: #000;
        font-weight: 600;
        padding: 5px 4rem !important;
    }
    .inherent{
        background: #ff7a7a;
        padding-bottom: 10px;
        margin-left: 2px;
        margin-top: 10px;
        border-radius: 5px;
    }
    .residual{
        background: #fff87a;
        padding-bottom: 10px;
        margin-left: 2px;
        margin-top: 10px;
        border-radius: 5px;
    }
    .target{
        background: #7adfff;
        padding-bottom: 10px;
        margin-left: 2px;
        margin-top: 10px;
        border-radius: 5px;
    }
</style>
    <!-_________________Content location BEGINING______________________->
    <div class="page-content">
        <section  class="row">

            <div class="col-lg-12">
                
                <section  class="section">
                  <form id="addassessform">
                    <div  class="card">
                        <div class="card-header">
                            <h2>ADD Assessment</h2>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                    
                                <div class="col-md-12 form-group">
                                    <label>Choose Risk:</label>
                                    <select class="form-control choices" name="riskid" id="riskid" onchange="fetchrisk(this.value)">
                                        <option value="" selected>----SELECT Risk---</option>
                                        <?php
                                        foreach($showriskass as $risk){
                                        echo'<option value='.$risk["risk_id"].'>'.$risk["risk_name"].'</option>';

                                            }
                                        ?>
                                    </select>
                                    <input type="hidden" class="form-control" name="dept" id="riskdept">
                                </div>
                                
                                    
                                <div class="row col-md-3 inherent"><!------begin of inherent----------->

                                    <div class="divider divider-left-center">
                                        <div class="divider-text">Inherent Risk Assessment</div>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Impact:</label>
                                        <select class="form-select" name="iimp" id="iimp">
                                            <option value="">-------SELECT Impact</option>
                                            <?php
                                            foreach($showimpact as $impact){
                                           echo' <option value='.$impact["id"].'>'.$impact["name"].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div> 
                                    <div class="col-md-6 form-group">
                                        <label>Likelihood:</label>
                                        <select class="form-select" name="ilikely" id="ilikely">
                                        <option value="">--------SELECT Likelihood</option>
                                            <?php
                                            foreach($showlikely as $likely){
                                           echo' <option value='.$likely["id"].'>'.$likely["name"].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>

                                </div><!---------end of inherent----->

                                    <div class="row col-md-6 residual"><!------begin of residual----------->

                                        <div class="divider divider-left-center">
                                            <div class="divider-text">Residual Risk Assessment</div>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label>Select Controls:</label>
                                            <select class="form-control choices multiple-remove" multiple="multiple" onchange="fetchcontrol(this.value)" name="controlid[]" id="controlid">
                                                
                                                <?php
                                                foreach($showcontrolass as $control){
                                                echo'<option  value='.$control["control_id"].'>'.$control["controls"].'</option>';

                                                    }
                                                ?>
                                            </select>
                                         </div>
                                        <div class="col-md-6 form-group">
                                            <label>Impact:</label>
                                            <select class="form-select" name="rimp" id="rimp" >
                                                <option value="">-------SELECT Impact</option>
                                                <?php
                                                foreach($showimpact as $impact){
                                            echo' <option value='.$impact["id"].'>'.$impact["name"].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div> 
                                        <div class="col-md-6 form-group">
                                            <label>Likelihood:</label>
                                            <select class="form-select" name="rlikely" id="rlikely" >
                                            <option value="">--------SELECT Likelihood</option>
                                                <?php
                                                foreach($showlikely as $likely){
                                            echo' <option value='.$likely["id"].'>'.$likely["name"].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>

                                    </div><!---------end of residual----->

                                    <div class="row col-md-3 target"><!------begin of Target----------->

                                    <div class="divider divider-left-center">
                                        <div class="divider-text">Target Risk Assessment</div>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Impact:</label>
                                        <select class="form-select" name="timp" id="timp">
                                            <option value="">-SELECT Impact</option>
                                            <?php
                                            foreach($showimpact as $impact){
                                           echo' <option value='.$impact["id"].'>'.$impact["name"].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div> 
                                    <div class="col-md-6 form-group">
                                        <label>Likelihood:</label>
                                        <select class="form-select" name="tlikely" id="tlikely">
                                        <option value="">--------SELECT Likelihood</option>
                                            <?php
                                            foreach($showlikely as $likely){
                                           echo' <option value='.$likely["id"].'>'.$likely["name"].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    </div><!---------end of inherent----->

                            </div><!--end of row--->

                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-3">
                                    
                                </div>
                                <div class="col-md-6">
                                    <a href="../Project/riskassess.php" class="btn btn-lg btn-danger">CLOSE</a>
                                    <button type="submit" name="addki" class="btn btn-lg btn-primary addassess">Add Assessment</button>
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

<!----------------------font awsome------------------------------------------------>
    <script src="../assets/vendors/fontawesome/all.min.js"></script>

<!------------------------------SWEET ALERTS---------------------------------->
<script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>

<!------------- Include Choices select JavaScript ------------------------------------------------>
<script src="../assets/vendors/choices.js/choices.min.js"></script>
<script src="../assets/js/pages/form-element-select.js"></script>

   

</body>

</html>
