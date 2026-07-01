<?php
include_once'./settings/riskcategoryClass.php';
include_once'./risk/riskClass.php';
include_once'./department/departmentClass.php';
include_once'./process/processClass.php';


$btniass="btn-light";
$btnrass="btn-light";
$btntass="btn-light";

?>
<!DOCTYPE html>
<html lang="en">
<!-_________________Header location______________________->
<?php include_once("../layout/header.php"); ?>

<body class="<?php echo (isset($sess_roles) && in_array((int)$sess_roles, [1, 3])) ? 'role-readonly' : '' ?>">
<style>
.role-readonly .btn-userpermission-edit,
.role-readonly .btn-userpermission-delete,
.role-readonly .btn-userpermission-add {
    opacity: 0.4;
    pointer-events: none;
    cursor: not-allowed;
}
</style>
    <div id="app">
        <div id="main" class="layout-horizontal">

 <!-_________________Navigation location______________________->

            <?php include_once("../layout/nav.php") ?>

            <div class="content-wrapper container">
                
<div class="page-heading">
    <h4>Risk Assessment</h4>
</div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
    <!-_________________Content location BEGINING______________________->
                <style>
                    .btn-orange{
                        background-color: #ff0000 !important;
                        color: #fff;
                    }
                    .btn-warning{
                        background-color: #ffc000 !important;
                        color: #000 !important;
                    }
                    .btn-success{
                        background-color: #00b050 !important;
                        color: #fff;
                    }
                    .btn-danger{
                        background-color: #c00000 !important;
                        color: #fff;
                    }
                .assess{
                    width:150px;
                    height: 27px;
                    font-size: 13px;
                    font-weight: 800;
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
                    <div class="card">
                        <div class="card-header">
                        <button onclick="location.href='../Project/riskassessadd.php'" type="button" class="btn btn-primary btn-userpermission-add" style="float:right;margin-right:30px;">
                        <i class="fas fa-fw fa-plus"></i>Add Assessment</button>
                           <!-- <a href="../Project/riskassessadd" class="btn btn-primary" style="float:right;margin-right:30px;" >
                            <i class="fas fa-fw fa-plus"></i>Add Assessment</a>-->
                            
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <table class="table table-striped table-buss" id="table1">
                                <thead>
                                    <tr>
                                        <th>Reference</th>
                                        <th>Risk</th>
                                        <th>Inherent</th>
                                        <th>Residual</th>
                                        <th>Target</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($showriskasstop as $assess){

                                        $rid=$assess["risk_id"];
                                        $riskname=substr($assess["risk_name"], 0 , 80);

                                        $iimp=$assess["iimp"];
                                        $ilikely=$assess["ilikely"];
                                        $irass=$iimp*$ilikely;
                                        $btniass=$riskClass->inherent($irass);//end of inherent risk.

                                        $rimp=$assess["rimp"];
                                        $rlikely=$assess["rlikely"];
                                        $rrass=$rimp*$rlikely;
                                        $btnrass=$riskClass->inherent($rrass);//end of redidual risk.

                                        $timp=$assess["timp"];
                                        $tlikely=$assess["tlikely"];
                                        $trass=$timp*$tlikely;
                                        $btntass=$riskClass->inherent($trass);//end of redidual risk.



                                        echo'<tr style="height:10px;">
                                        <td>RSK0'.$assess["risk_id"].'</td>
                                        <td><div style="font-size:13px;">'.$riskname.'</div></td>
                                        <td style="padding:0px;border-left:2px solid #000;"><input type="button" style="width:100%;padding:30px 15px;border-radius:0px;" value="'.$irass.'" class="btn assess '.$btniass.'"></td>
                                        <td style="padding:0px;border-left:2px solid #000;"><input type="button" style="width:100%;padding:30px 15px;border-radius:0px;" value="'.$rrass.'" class="btn assess '.$btnrass.'"></td>
                                        <td style="padding:0px;border-left:2px solid #000;"><input type="button" style="width:100%;padding:30px 15px;border-radius:0px;" value="'.$trass.'" class="btn assess '.$btntass.'"></td>
                                        <td style="padding-left:20px">
                                        <a href="../Project/riskassessedit.php?id='.$assess["id"].'" class="btn btn-sm btn-primary btn-userpermission-edit"><i class="fas fa-fw fa-pen"></i></a>
                                        <a href="#" class="btn btn-sm btn-danger btn-userpermission-delete"><i class="fas fa-fw fa-trash"></i></a>
                                        <a href="../Project/update_rcontrol.php?id='.$assess["risk_id"].'" class="btn btn-sm btn-primary btn-userpermission-edit">Edit control</a>
                                        </td>
                                    </tr>';
                                    }

                                    ?>

                                </tbody>
                            </table>
                            </div><!-- table-responsive -->
                        </div>
                    </div>

                </section>


    <!-_________________Content location END______________________->
                
            </div>
        </section>
    </div>

  </div>
<!------------------------info theme Modal ---------------------------------------------------------------->
    <div class="modal fade text-left" id="risk-matrix" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel130" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h5 class="modal-title white" id="myModalLabel130">RISK ASSESSMENT MATRIX
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                       <img src="../assets/images/risk/risk-matrix.png" width="744px" height="400px" alt="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger"
                            data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>

<!------------------------info theme Modal ---------------------------------------------------------------->

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
       $(document).on('click','.riskmatrix',function(e){
           e.preventDefault();
           $("#risk-matrix").modal("show");
       });

   </script>

</body>

</html>
