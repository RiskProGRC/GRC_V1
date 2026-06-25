
<!DOCTYPE html>
<html lang="en">
<!-_________________Header location______________________->
<?php include_once'../layout/header.php'; 

?>

<body>
    <div id="app">
        <div id="main" class="layout-horizontal">

 <!-_________________Navigation location______________________->

 <?php include_once'../layout/nav.php'; ?>

            <div class="content-wrapper container">
                
<div class="page-heading">
    <h4>Overall Controls</h4>
</div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
    <!-_________________Content location BEGINING______________________->
                 <style>
                    tr,td,.btn{
                        font-size:12px;
                        font-weight: 800;
                        color: #000;
                    }
                    label,b {
                        font-size: 13px;
                        font-weight: 800;
                    }
                    .form-control{
                        font-size: 12px;
                        font-weight: 800;
                        padding: 3px 5px;
                    }
                    .choices{
                        font-size: 14px;
                        font-weight: 800;
                        color: #000;
                        padding: 2px 2px;
                    }
                    .form-group {
                        margin-bottom: 0.2rem;
                    }
                    .form-group label{
                        color: #000 !important;
                    }
                    .btn-orange{
                        background-color: #ffc000 !important;
                        color: #fff;
                    }
                    .btn-warning{
                        background-color: #ffff00 !important;
                        color: #000 !important;
                    }
                    .btn-success{
                        background-color: #00b050 !important;
                        color: #fff;
                    }
                    .btn-danger{
                        background-color: #ff0000 !important;
                        color: #fff;
                    }
                    .form-select,.choices{
                        font-size: 12px;
                        font-weight: 800;
                        color: #000;
                        border:1px solid #000;
                    }
                </style>
                <section class="section">
                <form method="POST" id="convert_form" action="export.php">
                 <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="">Choose Control Strength</label>
                                    <select onchange="display(this.value)" name="cstrength" id="" class="form-select">
                                        <option value="0">Select control Strength</option>
                                        <?php
                                        foreach( $showcstrength as $cstrength){
                                            echo'
                                        <option value='.$cstrength["strength_id"].'>'.$cstrength["cs_name"].'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        
                        </div>
                    </div>

                    <div class="card" id="roveralldisplay">
                        <div class="card-header">
                        <input type="hidden" name="file_content" id="file_content">
                            <button type="button" name="convert" id="convert" class="btn btn-primary convert" style="float:right;margin-right:30px;">EXPORT</button>
                            
                        </div>
                        <div class="card-body">
                        <table class="table table-striped table-bordered" id="table1">
                                <thead id="thead">
                                    <tr>
                                        <th>#</th>
                                        <th>KPI(Key Performance Indicator)</th>
                                        <th>KRI(Key Risk Indicator)</th>
                                        <th>ACTION</th>
                                        <th>Date</th>
                                        <th>Risk Limit</th>
                                        <th>Risk Perfomance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                            <td>0</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="padding:0px;"><!--<button style="width:100%;padding:15px 15px;border-radius:0px;" class="btn btn-success"></button>--></td>
                                            
                                    </tr>
                                  
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
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


 <!------------------------------SWEET ALERTS---------------------------------->
<script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>

<!------------- Include Choices select JavaScript ------------------------------------------------>
<script src="../assets/vendors/choices.js/choices.min.js"></script>
<script src="../assets/js/pages/form-element-select.js"></script>
   
   <script>
    var currentDate = new Date();
    $("#datepicker2").datepicker({
        dateFormat:'yy-mm-dd',
        autoclose:true,
        endDate: "currentDate",
        maxDate: currentDate
    });
   </script>


</body>

</html>
