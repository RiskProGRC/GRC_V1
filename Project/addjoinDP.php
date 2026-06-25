<?php
include_once'./department/departmentClass.php';
include_once'./process/processClass.php';
include_once'./join/JoindpClass.php';

$joindpClass=new joindpClass();
$showjoindp=$joindpClass->showjoindp();


$deptClass=new departmentClass();
$showDept=$deptClass->showDept();

$processClass=new processClass();
$showProcess=$processClass->showProcess();

$alert="";

if(isset($_POST["addjoin"])){
    $dept_id=$_POST["dept"];
    $process_id=$_POST["process"];
    
  
    if(empty($dept_id) && empty($process_id) ){

        echo "ENTER data";

    }else{

        foreach($process_id as $pid){
            
            $alert= $joindpClass->addjoinDP($dept_id,$pid);
        }

    }


}
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
    .scrolloption {
        height:200px;
        overflow-y: scroll;
    }
        
        
        
    
</style>
    <!-_________________Content location BEGINING______________________->
    <div class="page-content">
        <section  class="row">
            <div class="col-lg-1">
               
            </div>

            <div class="col-lg-7">
                
                <section  class="section">
                  <form action="<?php $_SERVER["PHP_SELF"];?>" method="POST">
                    <div  class="card">
                        <div class="card-header">
                            <h2>JOIN PROCESS WITH DEPARTMENT</h2>
                        </div>
                        <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <?php echo $alert;?>
                                        <label>Select Department:</label>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <select class="form-control" name="dept" id="">
                                            <option value="" selected disabled>-----------------------SELECT DEPARTMENT----------------</option>
                                            <?php
                                            foreach($showDept as $dept){
                                                $deptname= ucfirst($dept["name"]);
                                          echo '<option value='.$dept["id"].'>'.$deptname.'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <hr><br>

                                    <div class="col-md-8">
                                            <h2>Choose process:</h2>
                                    </div>
                                    <div class="col-md-12 form-group scrolloption">
                                        <table class="table">
                                            <tr>
                                                
                                                <th>CODE</th>
                                                <th>Process</th>
                                                <th>Choose</th>
                                            </tr>

                                            <?php
                                            foreach($showProcess as $process){
                                                $processname=ucfirst($process["name"]);
                                            echo'<tr>
                                                
                                                <td>P00'.$process["id"].'</td>
                                                <td>'.$processname.'</td>
                                                <td><input type="checkbox" name="process[]" id="" value='.$process["id"].'></td>
                                            </tr>';
                                            }
                                            ?>
                                        </table>
                                    </div>
                                   
                                    
                                
                            </div><!--end of row--->

                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" name="addjoin" class="btn btn-lg btn-primary">SAVE</button>
                                </div>
                                <div class="col-md-4">
                                    <a href="company.php" class="btn btn-lg btn-danger">CLOSE</a>
                                </div>

                            </div><!-----end of footer row-->
                                  
                        </div>
                    </div>
                  </form>
                </section>
            </div>

            <div class="col-lg-4"><!-----begining of side table---->
            <div class="card">
                <div class="card-header"><h2>ADDED Process</h2></div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Department</th>
                            <th>Process</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        foreach($showjoindp as $dp){
                            $deptid= $dp["dept_id"];
                            $deptname=$deptClass->deptJoins($deptid);

                            $pid=$dp["process_id"];
                            $processname=$processClass->processJoins($pid);

                            echo'<tr>
                            <td>'.$deptname.'</td>
                            <td>'.$processname.'</td>
                            <td><a href="" class="btn btn-sm btn-primary"><span class="fa-fw select-all fas">ï•</span>&nbsp;&nbsp;Risk</a></td>
                        </tr>';
                    }
                        ?>
                    </table>
                </div>
            </div>

            </div><!-----begining of side table---->
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

<!------------- Include Choices select JavaScript ------------------------------------------------>
<script src="../assets/vendors/choices.js/choices.min.js"></script>
<script src="../assets/js/pages/form-element-select.js"></script>

   

</body>

</html>
