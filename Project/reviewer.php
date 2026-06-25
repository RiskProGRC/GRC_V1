<?php
include_once'./settings/reviewerClass.php';

$reviewerclass=new reviewerClass();
$showreviewer=$reviewerclass->showreviewer();



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
                
<div class="page-heading">
    <h4>Reviewers Lists</h4>
</div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
    <!-_________________Content location BEGINING______________________->
                <style>
                    .btn-orange{
                    background-color: #ff4700;
                    border-color: #ff4700;
                    border:1px solid #fff;
                    color: #fff;
                }
                    
                </style>
    <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <a href="addreviewer.php" class="btn btn-primary" style="float:right;margin-right:30px;" ><span class="fa-fw select-all fas">ï•</span>Add Controls</a>
                            
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>Reference</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                        foreach($showreviewer as $reviewer){
                          $reviewername=ucfirst($reviewer["fname"].'&nbsp'.$reviewer["sname"]);
                            echo'
                                    <tr>
                                        <td>'.$reviewer["id"].'</td>
                                        <td>'.$reviewername.'</td>
                                        <td>'.$reviewer["email"].'</td>
                                        <td>'.$reviewer["phone"].'</td>
                                        <td>
                                        <a href="riskEdit.php" class="btn btn-sm btn-primary "><span class="fa-fw select-all fas">ïŒƒ</span></a>
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

        <?php include_once("../layout/footer.php"); ?>

        
        </div>
        
    </div>



    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>

<!------------------------ Include Choices JavaScript drop down--------------------- -->
        <script src="../assets/vendors/choices.js/choices.min.js"></script>
        <script src="../assets/js/pages/form-element-select.js"></script>

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

   
   <script>
    
    $("#datepicker").datepicker({
        dateFormat:'yy-mm-dd'
    });

   </script> 

</body>

</html>
