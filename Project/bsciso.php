<?php 
include_once'./connection/connect.php';

$i=1;


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
    <h4>BSC TOOL</h4>
</div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
    <!-_________________Content location BEGINING______________________->
                <style>
                    tr,td{
                        font-size:13px;
                        font-weight: 600;
                        color: #000;
                    }
                    label{
                        font-size: 13px;
                        font-weight: 800;
                        color: #000;
                    }
                    .form-control,.form-select,.choices{
                        font-size: 13px;
                    }
                </style>
                <section class="section">
                    <div class="card">
                        <div class="card-header">
                                                       
                            <form style="width:60%;" method="POST" action="bscimport.php" class="form" enctype="multipart/form-data">
                                <label style="font-size:23px;float:left" for="">UPLOAD File</label>
                                <input type="file" style="border:2px Dashed #1023d8;" class="form-control" name="file" id="fileinput">
                                <input type="submit" style="margin-top:5px;" class="btn btn-primary form-control" name="importsubmit" value="Upload File">
                            </form>
                        </div>
                        <hr>
                        <div class="card-body">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Key Result Areas</th>
                                        <th>Performance Measure</th>
                                        <th>Baseline</th>
                                        <th>Target</th>
                                        <th>Weight</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $results= $db->query("SELECT * FROM bsctool ORDER BY id desc");
                                    if($results->num_rows>0){
                                        while($row=$results->fetch_assoc()){
                                    ?>
                                    <tr>
                                        <td><?=$i++?></td>
                                        <td><?=$row["kra"]?></td>
                                        <td><?=$row["performance"]?></td>
                                        <td><?=$row["baseline"]?></td>
                                        <td><?=$row["target"]?></td>
                                        <td><?=$row["weight"]?>%</td>
                                        <td><?=$row["created"]?></td>
                                        <td></td>
                                    </tr>
                                    <?php
                                        }
                                    }else{
                                    ?>
                                    <tr>
                                        <td colspan="8">No record(s) Found </td>
                                    </tr>
                                    <?php } ?>
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
<!--Basic Modal -->



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
