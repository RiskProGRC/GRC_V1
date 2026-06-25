
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
    <h4>Comprehensive Risk Performance sammary</h4>
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
                </style>
                <section class="section">
                <form method="POST" id="convert_form" action="export.php">
                    <div class="card">
                        <div class="card-header">
                        <input type="hidden" name="file_content" id="file_content">
                        <button type="button" name="convert" id="convert" class="btn btn-primary convert" style="float:right;margin-right:30px;">EXPORT</button>
                            
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="table1">
                                <thead id="thead">
                                    <tr>
                                        <th>ref id</th>
                                        <th>Risk Category</th>
                                        <th>KRI(Key Risk Indicator)</th>
                                        <th>KPI(Key Performance Indicator)</th>
                                        <th>Risk</th>
                                        <th>Risk Limit</th>
                                        <th>Date</th>
                                        <th>Owner</th>
                                        <th>Risk Perfomance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $datetoday= date('Y-m-d');
                                    
                                   
                                    foreach($showkri as $kri){
                                        $kpiid=$kri["kpi"];
                                        $kpiname=$kiclass->kpiJoins($kpiid);
                                        $risk=$kiclass->kpidashboard($kpiid); 
                                        $rcatid=$risk["rcat"];
                                        $kricat=$riskcatClass->riskcatJoins($rcatid);
                                                                      

                                        $uid=$kri["owner"];
                                        $owner=$userclass->userjoin($uid);

                                        $kid=$kri["kri"];
                                        $rlimit=$kriClass->fetchrisklimit($kid);
                                        $pname=$kriClass->fetchparameter($kid);
                                        
                                        $apetite=$kriClass->fetchriskapetite($kid);
                                        $rapt=$kriClass->apetite($apetite);
                                        $id=$kri["id"];
                                        $alert=$kriClass->calcperform($id);
                                        $sdate=$kri["date"];
                                        $seldate=strtotime($sdate);
                                        $toddate=strtotime($datetoday);

                                        if($seldate>$toddate){
                                            $href='';
                                        }elseif($seldate<=$toddate){
                                            $href='';
                                        }else{
                                            $href='';
                                        }


                                        echo'<tr>
                                            <td>'.$i++.'</td>
                                            <td>'.$kricat.'</td>
                                            <td>'.$pname.'</td>
                                            <td>'.$kpiname.'</td>
                                            <td>'.$risk["risk_name"].'</td>
                                            <td>'.$rlimit.' '.$rapt.'</td>
                                            <td>'. $sdate.'</td>
                                            <td>'. $owner.'</td>
                                            <td style="padding:0px;"><a href="kri" style="width:100%;padding:15px 15px;border-radius:0px;" class="btn '.$alert.'">'.$kri["perform"].' '.$rapt.'</a></td>
                                            
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
    
    $("#datepicker").datepicker({
        dateFormat:'yy-mm-dd'
    });
    $("#datepicker2").datepicker({
        dateFormat:'yy-mm-dd'
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
