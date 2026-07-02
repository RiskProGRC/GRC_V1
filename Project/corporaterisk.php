
<!DOCTYPE html>
<html lang="en">
<!-_________________Header location______________________->
<?php include_once("../layout/header.php"); 
?>

<body>
    <div id="app">
        <div id="main" class="layout-horizontal">

 <!-_________________Navigation location______________________->

            <?php include_once("../layout/nav.php") ?>

            <div class="content-wrapper container">
                
<div class="page-heading">
    <h4>TOP 10 RISKS</h4>
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
                            
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>Reference</th>
                                        <th>Risk</th>
                                        <th>Department</th>
                                        <th>Risk Impact</th>
                                        <th>Risk Likelihood</th>
                                        <th>Risk Ranking</th>
                                        <th>Risk Assessment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($showriskasstop as $riskass){
                                        $rid=$riskass["risk_id"];

                                        $dept=$riskClass->fetchRisk($rid);
                                        $dept_id=$dept["dept"];
                                        $deptname= $deptClass->deptJoins($dept_id);
                                        //$rname=$riskClass->Riskjoin($rid);
                                        
                                        $rimp=$riskass["rimp"];
                                        $rlikely=$riskass["rlikely"];
                                        $rass=$rimp*$rlikely;

                                        $rank=$riskClass->ranking($rass);
                                    echo'<tr>
                                        <td>RSK00'.$riskass["risk_id"].'</td>
                                        <td>'.$riskass["risk_name"].'</td>
                                        <td>'.$deptname.'</td>
                                        <td>'.$rimp.'</td>
                                        <td>'.$rlikely.'</td>
                                        <td>'.$rank.'</td>
                                        <td>'.$rass.'</td>
                                        
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

<!-----------------------------------------Modal For RISK-------------------------------->
 <!------------------------ Include Choices JavaScript drop down--------------------- -->
        <script src="../assets/vendors/choices.js/choices.min.js"></script>
        <script src="../assets/js/pages/form-element-select.js"></script>

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

   
   <script>
    
    $("#datepicker").datepicker({
        dateFormat:'yy-mm-dd'
    });

   </script> 
  

</body>

</html>
