<?php 
include_once'./settings/ownerClass.php';
include_once'./process/processClass.php';
//display owners details.
include_once'./department/departmentClass.php';
include_once'./process/processClass.php';
include_once'./join/JoindpClass.php';

$joindpClass=new joindpClass();
$joindp=$joindpClass->showjoindp();

$deptClass=new departmentClass();
//display process details
$processClass=new processClass();
$showprocess=$processClass->showProcess();


?>
<!DOCTYPE html>
<html lang="en">
<!-_________________Header location______________________->
<?php include_once'../layout/header.php'; ?>

<body>
    <div id="app">
        <div id="main" class="layout-horizontal">

 <!-_________________Navigation location______________________->

 <?php include_once'../layout/nav.php'; ?>

            <div class="content-wrapper container">
                
<div class="page-heading">
    <h4>Joined Department & Process Lists</h4>
</div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
    <!-_________________Content location BEGINING______________________->

                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <a href="../Project/addjoinDP.php" class="btn btn-primary" style="float:right;margin-right:30px;">
                            <span class="fa-fw select-all fas">ï•</span>Join Process</a>
                            
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>Department</th>
                                        <th>Processes</th>
                                        <th>Risk</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($joindp as $dp){
                                        $deptid=$dp["dept_id"];
                                        $deptname=ucfirst($deptClass->deptJoins($deptid));

                                        $pid=$dp["process_id"];
                                        $processname=ucfirst($processClass->processJoins($pid));

                                     echo'<tr>
                                        <td>'.$deptname.'</td>
                                        <td>'.$processname.'</td>
                                        <td><a href="../Project/risk.php" class="btn btn-sm btn-primary"><span class="fa-fw select-all fas">ï•</span>&nbsp;&nbsp;Add Risks</a></td>
                                        <td>
                                        <a href="" class="btn btn-sm btn-primary "><span class="fa-fw select-all fas">ïŒƒ</span></a>
                                        <a href="#" class="btn btn-sm btn-danger "><span class="fa-fw select-all fas">ï‹­</span></a>
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

        <?php include_once'../layout/footer.php'; ?>
        
        </div>
        
    </div>



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

   

</body>

</html>
