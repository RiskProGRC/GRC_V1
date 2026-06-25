<?php
$kriid=$_GET["id"];

$i=1;
include_once'./raf/kriClass.php';
/*$kriClass= new kriClass();

$kriid=$_POST["kriid"];

if($kriid){
    $kriedit=$kriClass->fetchkrichecklist($kriid);
    echo json_encode($kriedit);
}else{
    echo "no value picked";
}
*/
?>

<!DOCTYPE html>
<html lang="en">
<!-_________________Header location______________________->
<?php include_once'../layout/header.php'; 

//$kricurr=$kriClass->fetchkrichecklist($kriid);
$rphist=$kriClass->fetchrphistory($kriid);

?>

<body>
    <div id="app">
        <div id="main" class="layout-horizontal">

 <!-_________________Navigation location______________________->

 <?php include_once'../layout/nav.php'; ?>

            <div class="content-wrapper container">
                
<div class="page-heading">
    <h4>RISK PERFORMANCE HISTORY</h4>
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
                    .card{
                        width:800px;
                        margin:0px auto ;
                    }
                </style>
                <section class="section">
                <form method="POST" id="convert_form" action="export.php">              

                    <div class="card">
                        <div class="card-header">
                        </div>
                        <div class="card-body">
                        <table class="table table-striped table-bordered" id="table1" >
                                <thead id="thead">
                                    <tr>
                                        <th>#</th>
                                        <th>KRI(Key Risk Indicator)</th>
                                        <th>ACTION</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($rphist as $rperf){
                                        echo'
                                    <tr>
                                            <td>'.$i++.'</td>
                                            <td>'.$rperf["measure"].'</td>
                                            <td>'.$rperf["rapetite"].'</td>
                                            <td>'.$rperf["date"].'</td><td style="padding:0px;"><!--<button style="width:100%;padding:15px 15px;border-radius:0px;" class="btn btn-success"></button>--></td>
                                            
                                    </tr>';
                                    }
                                    ?>
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
      <!-----------------------------------HIST KRI Modal ---------------------------------------------------------------->
    <div class="modal fade text-left" id="update-modal" tabindex="-1" role="dialog"aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel17">History Risk Performance</h3>
                <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>        
            <section  class="section">
                <form id="riskperformform">
                <div  class="card">
                    <div class="card-header">
                        <h2></h2>
                    </div>
                    <div class="card-body">

                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-4">

                            </div>
                            <div class="col-md-4">
                                <button type="submit" name="addkri" class="btn btn-primary btn-lg riskperfhist">UPDATE Performance</button>
                            </div>
                            <div class="col-md-4">
                                <a href="#" class="btn btn-danger btn-lg" data-bs-dismiss="modal" aria-label="Close">CLOSE</a>
                            </div>

                        </div><!-----end of footer row-->
                                
                    </div>
                </div>
                </form>
            </section>
        </div>
    </div>
    </div>
    <!------------------------------------------------------------------------------------------------------------------------>
    
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

    <script>
        $(document).ready(function(){
            $('#convert').click(function(){
                var table_content='<table>';
                table_content+=$('#thead').html();
                table_content += $('#table1').html();
                table_content += '</table>';
                $('#file_content').val(table_content);
                $('#convert_form').submit();
            });
        });
   </script>

</body>

</html>
