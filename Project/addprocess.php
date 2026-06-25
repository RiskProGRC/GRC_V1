<?php
include_once'./process/processClass.php';


$processClass=new processClass();
$showProcess=$processClass->showProcess();
/*

$alert="";

if(isset($_POST["addprocess"])){

           
    $name=$_POST["name"];
    $dept=$_POST["dept"];
    $detail=$_POST["detail"];
    //$owner=$_POST["owner"];
  
    if($dept==""){
        $alert="<div class='col-12 alert alert-danger'>CHOOSE Department</div>";
    }elseif($name==""){
        $alert="<div class='col-12 alert alert-danger'>ENTER Process Name</div>";
    }elseif($detail==""){
        $alert="<div class='col-12 alert alert-danger'>ENTER Process Detail</div>";
    }elseif($dept && $name && $detail){
        $alert=$processClass->addProcess($uid,$ipaddress,$name,$dept,$detail);
    }else{
        
    }
}
*/

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
                  <form id="processform">
                    <div  class="card">
                        <div class="card-header">
                            <h2>ADD PROCESS</h2>
                        </div>
                        <div class="card-body">
                                <div class="row">
                                
                                <div class="col-md-8">
                                            <label>Entity:</label>
                                    </div>    
                                <div class="col-md-12 form-group">
                                        <select class="form-control" name="dept" id="">
                                            <option value="" selected>----SELECT Entity---</option>
                                            <?php
                                            foreach($showdept as $dept){
                                                echo'<option value='.$dept["dept_id"].'>'.$dept["dept_name"].'</option>';

                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <label>Enter Process:</label>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <input type="text" class="form-control" name="name"
                                            placeholder="Enter Process">
                                    </div>

                                    <div class="col-md-8">
                                            <label>Enter details:</label>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <textarea class="form-control" name="detail" id="" rows="5"></textarea>
                                    </div>
                                
                            </div><!--end of row--->

                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <button name="" class="btn btn-lg btn-primary addprocess" id="myButton1">Add Process</button>
                                </div>
                                <div class="col-md-6">
                                    <a href="../Project/processlist.php" class="btn btn-lg btn-danger">CLOSE</a>
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

 <!------------------------------SWEET ALERTS---------------------------------->
 <script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>
<!----------------------font awsome------------------------------------------------>

    <script src="../assets/vendors/fontawesome/all.min.js"></script>

<!------------- Include Choices select JavaScript ------------------------------------------------>
<script src="../assets/vendors/choices.js/choices.min.js"></script>
<script src="../assets/js/pages/form-element-select.js"></script>

   

</body>

</html>
