<?php
include_once'./login/loginClass.php';
include_once'./users/usersClass.php';

$loginClass= new loginClass();
$usersClass= new usersClass();
$showlogs= $loginClass->systemlog();
$i=1;

?>
<!DOCTYPE html>
<html lang="en">
<!-_________________Header location______________________->
<?php include_once("../layout/header.php");
    $sdid=$sess_dept_id;
    
    if($sess_roles==1){
        $showRisk=$riskClass->showRisk();
    }elseif($sess_roles==2){
        $showRisk=$riskClass->showRiskdept($sdid);
    }

?>

<body>
    <div id="app">
        <div id="main" class="layout-horizontal">

 <!-_________________Navigation location______________________->

            <?php include_once("../layout/nav.php") ?>

            <div class="content-wrapper container">
                
<div class="page-heading">
    <h4>Activity Logs</h4>
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
                .table{
                    width: 80%;
                    margin: 0 auto;
                }
                .table>thead {
                    background: #2b80fd;
                    color: #fff;
                }
                .dataTable-table th a {
                    border-right: 1px solid #fff;
                    padding: 5px 0px;
                    text-align: center;
                }
                td{
                    font-weight: 400;
                    color: #000;
                    text-align: center;
                }
                    
                                .btn-group-sm>.btn, .btn-sm { border-radius: 0.2rem; font-size: 0.75rem; padding: 0.2rem 0.4rem; }
                .table-buss { border-collapse: collapse; }
                .table-buss th {
                    font-size: 12px; font-weight: 700; color: #fff;
                    background: #02338d; padding: 3px 5px;
                    white-space: nowrap; text-align: center; vertical-align: middle;
                    border: 1px solid rgba(255,255,255,0.3);
                }
                .table-buss td {
                    font-size: 12px; font-weight: 500; color: #222;
                    padding: 2px 5px; text-align: center; vertical-align: middle;
                    white-space: nowrap; border: 1px solid #b8c8de;
                }
                .table-buss tbody tr:hover td { background: #eef4ff; }
                </style>
                  <section class="section">
                  <form method="POST" id="convert_form" action="export.php">
                    <div class="card">
                        <div class="card-header">
                        </div>
                        <div class="card-body">
                        <div class="table-responsive">
<table class="table table-striped table-buss" id="table1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date/Time</th>
                                    <th>Username</th>
                                    <th>Entity</th>
                                    <th>Activity</th>
                                    <th>IP</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($showlogs as $logs){
                                    
                                    $uid=$logs["user_id"];
                                    $username=$usersClass->userjoin($uid)
                                    ?>
                                <tr>
                                    <td><?=$i++?></td>
                                    <td><?=$logs["created_at"]?></td>
                                    <td><?=$username?></td>
                                    <td><?=$logs["entity"]?></td>
                                    <td style="max-width:220px;white-space:normal;padding:4px 8px;font-size:11px;"><?=substr($logs["action"],0,60).'...'?></td>
                                    <td><?=$logs["ip_address"]?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                            </div><!-- table-responsive -->
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

        <?php include_once("../layout/footer.php"); ?>

        
        </div>
        
    </div>

<!-----------------------------------------Modal For RISK-------------------------------->
  <!-----------------------------------DELETE  Modal ---------------------------------------------------------------->


    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>

<!------------------------ Include Choices JavaScript drop down--------------------- -->
        <script src="../assets/vendors/choices.js/choices.min.js"></script>
        <script src="../assets/js/pages/form-element-select.js"></script>

 <!---------------------------------SWEET ALERTS----------------------------------------->
     <script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>

  <!----------------------Datatable Simple------------------------------------------------>
    <script src="../assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script>
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
   <script>
 
   </script>

</body>

</html>
