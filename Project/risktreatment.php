<?php
include_once'./settings/riskcategoryClass.php';
include_once'./risk/riskClass.php';
include_once'./department/departmentClass.php';
include_once'./process/processClass.php';
include_once'./connection/connect.php';
include_once'./action/actionClass.php';

$riskClass= new riskClass();

$actionClass=new actionClass();
$showaction=$actionClass->showaction();

//$showass= $riskClass->showassessment();

$i=1;
$btniass="btn-light";
$btnrass="btn-light";
$btntass="btn-light";

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
    <h4>Risk Treatment</h4>
</div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
    <!-_________________Content location BEGINING______________________->
                <style>
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
                                        <th>Controls</th>
                                        <th>Apetite</th>
                                        <th>Treatment Strategy</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($showriskasstop as $assess){
                                        $apetite = $assess["apetite"];
                                        $treatment= $assess["treatment"];

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
                                        $btntass=$riskClass->inherent($trass);//end of residual risk.
                                        ?>


                                        
                                    <tr style="height:10px;">
                                        <td><?=$i++?></td>
                                        <td><div style="font-size:13px;"><?='RSK0'.$assess["risk_id"].'('.$riskname.')'?></div></td>
                                        <td style="padding:0px;border-left:2px solid #000;"><input type="button" style="width:100%;padding:30px 15px;border-radius:0px;" class="btn assess <?=$btniass?>" Value="<?=$irass?>"></td>
                                        <td style="padding:0px;border-left:2px solid #000;"><input type="button" style="width:100%;padding:30px 15px;border-radius:0px;" class="btn assess <?=$btnrass?>" Value="<?=$rrass?>"></td>
                                        <td style="max-width:220px;white-space:normal;padding:4px 8px;font-size:11px;">
                                            <?php
                                            if(empty($rid)){
                                            }else{
                                            $query4=mysqli_query($con,"SELECT * FROM risk_control WHERE risk_id='$rid'");

                                            while($crow=mysqli_fetch_assoc($query4)){
                                                $cid=$crow["control_id"];
                                                $qcontrol=mysqli_query($con,"SELECT * FROM control WHERE control_id='$cid'");
                                                $ctlrow=mysqli_fetch_assoc($qcontrol);
                                                echo "CTR".$ctlrow['control_id']."-".substr($ctlrow['controls'],0,60)."...</br>";
                                                }

                                            }
                                           ?>
                                        </td>
                                        <td><?php
                                        if($apetite==1){
                                            echo "Low Apetite";
                                        }elseif($apetite==2){
                                            echo "Medium Apetite";
                                        }elseif($apetite==3){
                                            echo "High Apetite";        
                                        }else{
                                            echo "No Apetite";
                                        }
                                        
                                        ?></td>
                                        <td>
                                            <?php
                                            if($treatment==1){
                                                echo"Accepted";

                                            }elseif($treatment==2){
                                                echo"Avoid";

                                            }elseif($treatment==3){
                                                echo"Transfer";

                                            }elseif($treatment==4){
                                                echo"Mitigate";

                                            }else{
                                            ?>
                                            
                                            <div class="btn-group me-1 mb-1">
                                                <div class="dropdown">
                                                    <button type="button" href="" class="btn btn-info btn-sm dropdown-toggle"
                                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Treatment
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item riskaccept" href="#" id='<?=$assess["id"]?>'>Accept</a>
                                                        <a class='dropdown-item riskavoid' href='#' id='<?=$assess["id"]?>'>Avoid</a>
                                                        <a class='dropdown-item risktransfer' href='#' id='<?=$assess["id"]?>'>Transfer</a>    
                                                        <a class='dropdown-item riskmitigate' href='#' id='<?=$assess["id"]?>'>Mitigate</a>                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>

                                        </td>
                                    </tr>
                                   <?php } ?>
                                         
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
<!------------------------Accept risk Modal ---------------------------------------------------------------->
    <div class="modal fade text-left" id="risk-acceptmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel130" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                role="document">
                 
                    <div class="modal-content">  
                                       
                        <div class="modal-header bg-info">
                            <h5 class="modal-title white" id="myModalLabel130">ACCEPT RISK TREATMENT
                            </h5>
                            <button type="button" class="close" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <form id="treatmentform">
                        <div class="modal-body">
                            <div class="col-md-12 form-group">
                                <input type="hidden" name="assmtid" id="assmtid" value="">
                                
                                <label>Select Risk Apetite:</label>
                                <select class="form-control" name="apetite" id="">         
                                    <option value='1'>Low Apetite</option>
                                    <option value='2'>Medium Apetite</option>
                                    <option value='3'>High Apetite</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-body" style="height:250px;">
                            <div class="col-md-12 form-group">
                                <label>Select Actions:</label>
                                <select class="form-control choices multiple-remove" multiple="multiple" onchange="fetchcontrol(this.value)" name="action[]" id="controlid">                                
                                    <?php
                                    foreach($showaction as $action){
                                    echo'<option value='.$action["id"].'>'.$action["action"].'</option>';

                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger"
                                data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="" name="" class="btn btn-primary addaccepttreat">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">ADD Treatment</span>
                            </button>
                        
                        </div>
                      </form>
                    </div>
                
            </div>
        </div>
    </div>

<!------------------------info theme Modal ---------------------------------------------------------------->

<!------------------------reject Modal ---------------------------------------------------------------->
    <div class="modal fade text-left" id="risk-avoidmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel130" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                role="document">
                 
                    <div class="modal-content">  
                                       
                        <div class="modal-header bg-danger">
                            <h5 class="modal-title white" id="myModalLabel130">AVOID RISK TREATMENT
                            </h5>
                            <button type="button" class="close" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <form id="treatmentavoidform">
                        <div class="modal-body">
                            <div class="col-md-12 form-group">
                                <input type="hidden" name="assavoidid" id="assavoidid" value="">
                                
                                <label>Select Risk Apetite:</label>
                                <select class="form-control" name="apetite" id="">         
                                    <option value='1'>Low Apetite</option>
                                    <option value='2'>Medium Apetite</option>
                                    <option value='3'>High Apetite</option>
                                </select>
                            </div>
                        </div>
                        <!--<div class="modal-body" style="height:250px;">
                            <div class="col-md-12 form-group">
                                <label>Select Actions:</label>
                                <select class="form-control choices multiple-remove" multiple="multiple" onchange="fetchcontrol(this.value)" name="action[]" id="controlid">                                
                                    
                                    ?>
                                </select>
                            </div>
                        </div>-->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger"
                                data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="" name="" class="btn btn-primary addavoidtreat">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">ADD Treatment</span>
                            </button>
                        
                        </div>
                      </form>
                    </div>
                
            </div>
        </div>
    </div>

<!------------------------info theme Modal ---------------------------------------------------------------->

<!------------------------Transfer Modal ---------------------------------------------------------------->
    <div class="modal fade text-left" id="risk-transfermodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel130" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                role="document">
                 
                    <div class="modal-content">  
                                       
                        <div class="modal-header bg-danger">
                            <h5 class="modal-title white" id="myModalLabel130">Transfer RISK TREATMENT
                            </h5>
                            <button type="button" class="close" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <form id="treatmenttransferform">
                        <div class="modal-body">
                            <div class="col-md-12 form-group">
                                <input type="hidden" name="asstransferid" id="asstransferid" value="">
                                
                                <label>Select Risk Apetite:</label>
                                <select class="form-control" name="apetite" id="">         
                                    <option value='1'>Low Apetite</option>
                                    <option value='2'>Medium Apetite</option>
                                    <option value='3'>High Apetite</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-body" style="height:250px;">
                            <div class="col-md-12 form-group">
                                <label>Select Actions:</label>
                                <select class="form-control choices multiple-remove" multiple="multiple" onchange="fetchcontrol(this.value)" name="action[]" id="controlid">                                
                                    <?php
                                    foreach($showaction as $action){
                                    echo'<option value='.$action["id"].'>'.$action["action"].'</option>';

                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger"
                                data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="" name="" class="btn btn-primary addtransfertreat">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">ADD Treatment</span>
                            </button>
                        
                        </div>
                      </form>
                    </div>
                
            </div>
        </div>
    </div>

<!------------------------info theme Modal ---------------------------------------------------------------->
<!------------------------Transfer Modal ---------------------------------------------------------------->
    <div class="modal fade text-left" id="risk-mitigatemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel130" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                role="document">
                 
                    <div class="modal-content">  
                                       
                        <div class="modal-header bg-danger">
                            <h5 class="modal-title white" id="myModalLabel130">MITIGATE RISK TREATMENT
                            </h5>
                            <button type="button" class="close" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <form id="treatmentmitigateform">
                        <div class="modal-body">
                            <div class="col-md-12 form-group">
                                <input type="hidden" name="assmitigateid" id="assmitigateid" value="">
                                
                                <label>Select Risk Apetite:</label>
                                <select class="form-control" name="apetite" id="">         
                                    <option value='1'>Low Apetite</option>
                                    <option value='2'>Medium Apetite</option>
                                    <option value='3'>High Apetite</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-body" style="height:250px;">
                            <div class="col-md-12 form-group">
                                <label>Select Actions:</label>
                                <select class="form-control choices multiple-remove" multiple="multiple" onchange="fetchcontrol(this.value)" name="action[]" id="controlid">                                
                                    <?php
                                    foreach($showaction as $action){
                                    echo'<option value='.$action["id"].'>'.$action["action"].'</option>';

                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger"
                                data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="" name="" class="btn btn-primary addmitigatetreat">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">ADD Treatment</span>
                            </button>
                        
                        </div>
                      </form>
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
 <!---------------------------------SWEET ALERTS----------------------------------------->
     <script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>
<!----------------------font awsome------------------------------------------------>
    <script src="../assets/vendors/fontawesome/all.min.js"></script>

   
   <script>
       $(document).on('click','.riskaccept',function(e){
            e.preventDefault();
            $("#assmtid").val($(this).attr("id"));
            $("#risk-acceptmodal").modal('show');
       });
       $(document).on('click','.riskavoid',function(e){
            e.preventDefault();
            $("#assavoidid").val($(this).attr("id"));
            $("#risk-avoidmodal").modal('show');
       });
       $(document).on('click','.risktransfer',function(e){
            e.preventDefault();
            $("#asstransferid").val($(this).attr("id"));
            $("#risk-transfermodal").modal('show');
       });
       $(document).on('click','.riskmitigate',function(e){
            e.preventDefault();
            $("#assmitigateid").val($(this).attr("id"));
            $("#risk-mitigatemodal").modal('show');
       });
   </script>

</body>

</html>
