<?php
include_once'./settings/reviewerClass.php';
$reviewerclass=new reviewerClass();
$showreviewer=$reviewerclass->showreviewer();





$alert="";

if(isset($_POST["addreviewer"])){
    $fname=$_POST["fname"];
    $sname=$_POST["sname"];
    $email=$_POST["email"];
    $phone=$_POST["phone"];
  
    if(empty($fname) && empty($sname) && empty($email) && empty($phone)){
        echo "ENTER data";
    }else{

        $reviewerclass->addreviewer($fname,$sname,$email,$phone);

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
</style>
    <!-_________________Content location BEGINING______________________->
    <div class="page-content">
        <section  class="row">
            <div class="col-lg-2"></div>

            <div class="col-lg-6">
                
                <section  class="section">
                  <form action="<?php $_SERVER["PHP_SELF"];?>" method="POST">
                    <div  class="card">
                        <div class="card-header">
                            <h2>ADD Reviewer</h2>
                        </div>
                        <div class="card-body">
                                <div class="row">
                                
                                    <div class="col-md-8">
                                        <label>First Name:</label>
                                    </div>
                                    <div class="col-md-12 form-group">
                                      <input type="text" class="form-control" name="fname" placeholder="firstname" required>
                                    </div>

                                    <div class="col-md-8">
                                            <label>Second Name:</label>
                                    </div>
                                    <div class="col-md-12 form-group">
                                    <input type="text" class="form-control" name="sname" placeholder="Secondname" required>
                                    </div>

                                    <div class="col-md-8">
                                            <label>Email:</label>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <input type="email" class="form-control" name="email" placeholder="email" required>
                                    </div>
                                    <div class="col-md-8">
                                            <label>Phone Number:</label>
                                    </div>
                                    <div class="col-md-12 form-group">
                                         <input type="phone" class="form-control" name="phone" placeholder="phone" required>
                                    </div>
                                    
                                
                            </div><!--end of row--->

                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="submit" name="addreviewer" class="btn btn-lg btn-primary">Add Reviewer</button>
                                </div>
                                <div class="col-md-6">
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
                <div class="card-header"><h2>ADDED Reviewer</h2></div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Code</th>
                            <th>Risk</th>
                            <th>Control</th>
                        </tr>
                        <?php
                        foreach($showreviewer as $reviewer){
                          $reviewername=ucfirst($reviewer["fname"].'&nbsp'.$reviewer["sname"]);
                            echo'
                         <tr>
                            <td>'.$reviewer["id"].'</td>
                            <td>'.$reviewername.'</td>
                            <td>'.$reviewer["phone"].'</td>
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
