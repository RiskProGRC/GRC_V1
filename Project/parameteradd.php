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
     label {
    font-size: 16px;
    color: #000;
    font-weight: 800;
    }

    label.range{
        color:#fff;
    }

    .severe {
        background-color: red;
        color:#fff;
    }
    .moderate {
        background-color: #ffcb0d;
        color:#fff;
    }
    .low {
        background-color: #518503;
        color:#fff;
    }
    .form-control, .form-select,.choices{
        font-size: 14px;
        font-weight: 800;
        color: #000;
        border:1px solid #000;
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
    hr{
        padding: 0px;
        margin: 2px;
    }
    br{
        color: #000;
    }
    .range{
        font-size: 13px;

    }
</style>
    <!-_________________Content location BEGINING______________________->
    <div class="page-content">
        <section  class="row">
            <div class="col-lg-2"></div>

            <div class="col-lg-6">
                
                <section  class="section">
                  <form id="addparameterform" method="POST">
                    <div  class="card">
                        <div class="card-header">
                            <h2>ADD TARGET PARAMETERS</h2>
                        </div>
                        <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label>Enter KRI Measure Name:</label>
                                        <input type="text" class="form-control" name="p_name" id="">
                                        <input type="hidden" class="form-control" name="did" id="" value="<?=$sdid?>">
                                    </div>
                                    <!--<div class="col-md-6 form-group">
                                        <label>Choose Risk Apetite Details:</label>
                                        <select class="form-control" name="apetite" id="apetite">
                                            <option value="" selected>----SELECT Apetite Details---</option>
                                            <option value="1">Percentages</option>
                                            <option value="2">Amount</option>
                                            <option value="3">Days</option>
                                            <option value="4">People</option>
                                            <option value="5">Number</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Choose Risk Apetite Type:</label>
                                        <select class="form-control" name="type" id="type">
                                            <option value="" selected>----SELECT Apetite Type---</option>
                                            <option value="0">Increasing Apetite(0-100)</option>
                                            <option value="1">Decreasing Apetite(100-0)</option>
                                        </select>
                                    </div>-->
                                    <hr>
                                    </br>
                                    <div class="col-md-12 form-group">
                                        
                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                  <label>Enter Risk Apetite Limit:</label>  
                                                </div>
                                                <div class="col-md-4 form-group"> <input class="form-control" name="rlimit" type="text">
                                                </div>
                                                <div class="col-md-4"></div>
                                            </div>
                                    </div>
                                    
                                    <div class="row range">
                                        
                                    <div class="col-md-4 form-group low">
                                        <label class="range">Enter Range For Acceptable/Low Target :</label>
                                            <div class="row">
                                                <div class="col-md-2 form-group">
                                                    
                                                </div>
                                                <div class="col-md-4 form-group">
                                                <b>From:</b> <input class="form-control" name="fmngt" type="text">
                                                </div>
                                                <div class="col-md-4 form-group">
                                                <b>To:</b><input class="form-control" name="tmngt" type="text"> 
                                                </div>

                                            </div>
                                    </div>
                                   
                                    <div class="col-md-4 form-group moderate">
                                        <label class="range">Enter Range For Moderate Target:</label>
                                        <div class="row">
                                                <div class="col-md-2 form-group">
                                                    
                                                </div>
                                                <div class="col-md-4 form-group">
                                                <b>From:</b> <input class="form-control" name="fboard"  type="text">
                                                </div>
                                                <div class="col-md-4 form-group">
                                                <b>To:</b><input class="form-control" name="tboard"  type="text"> 
                                                </div>

                                            </div>
                                    </div>
                                   
                                    <div class="col-md-4 form-group severe" >
                                        <label class="range">Enter Range For Unacceptable/Severe Target:</label>
                                        <div class="row">
                                                <div class="col-md-2 form-group">
                                                    
                                                </div>
                                                <div class="col-md-4 form-group">
                                                <b>From:</b> <input class="form-control" name="fmboard"  type="text">
                                                </div>
                                                <div class="col-md-4 form-group">
                                                <b>To:</b><input class="form-control" name="tmboard" type="text"> 
                                                </div>

                                            </div>
                                    </div>
                                    </div>
                                    </div>
                                    <hr>                                    
                                    <div class="col-md-12 form-group">
                                        <label>Description:</label>
                                        <textarea class="form-control" name="desc" rows="5" id=""></textarea>
                                    </div>
                                   
                                    
                            </div><!--end of row--->

                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-3">
                                    
                                </div>
                                <div class="col-md-6">
                                    <a href="../Project/kra_settings" class="btn btn-lg btn-danger">CLOSE</a>
                                    <button type="submit" name="addparameter" class="btn btn-lg btn-primary addparameter">ADD KRI Parameter</button>
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
