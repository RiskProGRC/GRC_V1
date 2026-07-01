<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$sessionRole = $_SESSION['roles']   ?? 0;
$sessionDept = $_SESSION['dept_id'] ?? '';

$i=1;
include_once'./raf/kriClass.php';
include_once'./risk/riskClass.php';
include_once'./process/processClass.php';

$processClass= new processClass();
$riskClass= new riskClass();
$kriclass= new kriClass();

// roles 2 and 3 see only KRI rows linked to their department's risks
if (in_array((int)$sessionRole, [2, 3]) && $sessionDept !== '') {
    $krishow = $kriclass->fetchkrideptperf($sessionDept);
} else {
    $krishow = $kriclass->fetchkri();
}
?>
<!DOCTYPE html>
<html lang="en">
<!-_________________Header location______________________->
<?php include_once'../layout/header.php'; ?>

<body class="<?php echo (isset($sess_roles) && in_array((int)$sess_roles, [1, 3])) ? 'role-readonly' : '' ?>">
<style>
.role-readonly .btn-userpermission-edit,
.role-readonly .btn-userpermission-delete,
.role-readonly .btn-userpermission-add,
.role-readonly .btn-userpermission-history {
    opacity: 0.4;
    pointer-events: none;
    cursor: not-allowed;
}
</style>
    <div id="app">
        <div id="main" class="layout-horizontal">

 <!-_________________Navigation location______________________->

 <?php include_once'../layout/nav.php'; ?>

            <div class="content-wrapper container">
                
<div class="page-heading">
    <h4>Add KRI</h4>
</div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
    <!-_________________Content location BEGINING______________________->
                 <style>
                    tr,td,.btn{
                        font-size:11px;
                        font-weight: 700;
                        color: #000;
                    }
                    label,b {
                        font-size: 13px;
                        font-weight: 800;
                    }
                    .btn-sm
                    {
                        color: #fff !important;
                    }
                    a{
                        text-decoration: none;
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
                    td.severe {
                        background-color: red;
                        color:#fff;
                        text-align: center;
                    }
                    td.moderate {
                        background-color: #ffcb0d;
                        color:#fff;
                        text-align: center;
                    }
                    td.low {
                        background-color: #518503;
                        color:#fff;
                        text-align: center;
                    }
                    .kri_btn {
                        font-size: 11px;
                        color: #fff;
                    }
                    .form-control{
                        border: 1px solid #000;
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
                        <button onclick="location.href='../Project/performance.php'" type="button" class="btn btn-primary btn-userpermission-add" style="float:right;margin-right:30px;">
                        <i class="fas fa-fw fa-plus"></i>Add KRI</button>
                        <!--<a href="../Project/kriadd" class="btn btn-primary" style="float:right;margin-right:30px;">
                        <i class="fas fa-fw fa-plus"></i>Add Risk Performance</a>-->
                            
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
<table class="table table-striped table-buss" id="table1">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Risk</th>
                                        <th>Process</th>
                                        <th>KRI</th>
                                        <th>Parameter</th>
                                        <th>Risk Apetite</th>
                                        <th>Description</th>
                                        <th>Update</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($krishow as $kri){
                                        $rid=$kri["risk_id"];
                                        $riskname= $riskClass->Riskjoin($rid);
                                        $pid=$kri["process_id"];
                                        $processname= $processClass->processJoins($pid);

                                        $pid=$kri["apetite"];
                                        $parameter = $kriclass->fetchparameterid($pid);
                                        $pname=$parameter["pname"];
                                        $fmngt=$parameter["fmngt"];
                                        $tmngt=$parameter["tmngt"];
                                        $fboard=$parameter["fboard"];
                                        $tboard=$parameter["tboard"];
                                        $fmboard=$parameter["fmboard"];
                                        $tmboard=$parameter["tmboard"];
                                        $rlimit=$parameter["rlimit"];
                                        $rperform=$kri["risk_apetite"];

                                    ?>
                                    <tr>
                                            <td><?= $i++?> </td>                                            
                                            <td><?= $riskname?></td>
                                            <td><?= $processname ?></td>
                                            <td><?= $kri["measure"]?></td>
                                            <td><?= $pname ?></td>
                                            <td class="<?php
                                            if($rperform<$rlimit){
                                                echo "low";
                                            }elseif($rperform<=$fmngt && $rperform<=$tmngt){
                                                echo "low";
                                            }elseif($rperform<=$fboard && $rperform<=$tboard){
                                                echo "moderate";
                                            }elseif($rperform=$fmboard && $rperform<=$tmboard){
                                                echo "severe";
                                            }elseif($rperform > $tmboard){
                                                echo "severe";
                                                }?>"> <?= $kri["risk_apetite"] ?></td>
                                            <td style="max-width:220px;white-space:normal;padding:4px 8px;font-size:11px;"><?=substr($kri["rapetite_desc"],0,60).'...'?></td>
                                            <td>
                                                <button name="edit" class="btn btn-sm btn-primary histadd btn-userpermission-edit" id="<?=$kri["id"]?>" title="Update"><i class="fas fa-fw fa-pen"></i></button>
                                                <button name="delete" class="btn btn-sm kribtn btn-danger btn-userpermission-history" title="History"><a class="kri_btn" href="krihist.php?id=<?= $kri['id']?>"><i class="fas fa-fw fa-clock"></i></a></button>
                                                <button name="delete" class="btn btn-sm kribtn btn-danger" title="Chart"><a class="kri_btn" href="krichart.php?id=<?= $kri['id']?>"><i class="fas fa-fw fa-chart-line"></i></a></button>
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





 <!-_________________Footer location______________________->

        <?php include_once'../layout/footer.php'; ?>

            <!-----------------------------------action UPDATE Modals--------------------------------------------------------------->
    <!--Basic Modal -->
        <div class="modal fade text-left" id="Action" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myModalLabel1">ACTIONS</h5>
                                <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <i data-feather="x"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h5 id="actionname">
                                    
                                </h5>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Close</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
         </div>
     <!-----------------------------------COMPANY EDIT Modals--------------------------------------------------------------->
     <div class="modal fade text-left" id="edit-modal" tabindex="-1" role="dialog"aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel17">UPDATE Risk Performance</h3>
                    <button type="button" class="btn btn-info close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>        
                <form class="form form-horizontal" id="updatekriform">
                <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 form-group">
                                        <label>Choose KPI(Key Performance Indicator):</label>
                                        <input type="hidden" id="kriid" name="kriid">
                                        
                                        <select name="kpi" id="kpi" class="form-select">
                                            <option value="" selected>------------------Choose Key Performance Indicator</option>
                                            <?php
                                            foreach($showki as $ki){
                                                echo'<option value='.$ki["id"].'>'.$ki["ki"].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label>Choose KRI(Key Risk Indicator):</label>
                                        <select name="kri" id="kri" class="form-select">
                                            <option value="" selected>------------------Choose Key Risk Indicator</option>
                                            <?php
                                            foreach($showkriparameter as $raf){
                                                echo'<option value='.$raf["id"].'>'.$raf["pname"].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-12 form-group">
                                        <label>Enter Risk Perfomance:</label>
                                        <input type="number" class="form-control" name="perform" id="perform">
                                    </div>

                                    
                                    <div class="col-md-12 form-group">
                                        <label>Enter Date:</label>
                                        <input type="text" name="date" id="datepicker" class="form-control" name="kri">
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label>Choose Action:</label>
                                        <select name="action" id="action" class="form-select">
                                            <option value="" selected>------------------Choose Action</option>
                                            <?php
                                            foreach($showaction as $action){
                                                echo'<option value='.$action["id"].'>'.$action["action"].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label>Enter Business Objectives:</label>
                                        <textarea name="b_obj" id="b_obj" class="form-control" cols="30" rows="6"></textarea>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label>Choose Owner:</label>
                                        <select name="owner" id="owner" class="form-select ">
                                            <option value="" selected>------------------Choose Owner</option>
                                            <?php
                                            foreach($showusers as $users){
                                                echo'<option value='.$users["id"].'>'.$users["fname"].'&nbsp'.$users["sname"].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                    
                </div><!--end of row--->

                </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn-danger"
                        data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="" name="editCompany" class="update btn btn-primary">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">UPDATE</span>
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
    
    
    <!------------------------------------------------------------------------------------------------------------------------>
    <!-----------------------------------DELETE  Modal ---------------------------------------------------------------->
    <div class="modal fade text-left" id="delete-modal" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel120" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                            role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-danger">
                                    <h3 class="modal-title white" id="myModalLabel120">Delete Performance
                                    </h3>
                                    <button type="button" class="close" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                </div>
                                <form id="deleteform">
                                <div class="modal-body">
                                <div>
                                    <input type="hidden" name="pid" id="pid" value="">
                                    <h3>Are you Sure you want to delete?</h3>
                                    <div id="messagedelete"></div>
                                <div style="color:#000;font-weight:600;font-size:29px;text-align:center;">Performance:<h3 id="performance"></h3></div>
                                </div>
                                
                                


                                </div>
                                <div class="modal-footer">
                                    
                                    <button type="button" class="btn btn-light-secondary"
                                        data-bs-dismiss="modal">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Close</span>
                                    </button>
                                    <button type="button" class="delete-btn btn btn-danger ml-1"
                                        data-bs-dismiss="modal">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">DELETE</span>
                                    </button>
                                </div>
                             </form>
                            </div>
                        </div>
                    </div>
                </div>
    <!------------------------------------------------------------------------------------------------------------------------>

 <!-----------------------------------HIST KRI Modal ---------------------------------------------------------------->
    <div class="modal fade text-left" id="update-modal" tabindex="-1" role="dialog"aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
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
                            <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label>KRI Name:</label>
                                        <input type="hidden" name="upkriid" id="upkriid">
                                        <input type="text" class="form-control" name="measure" id="upmeasure">                                        
                                    </div>

                                    <div class="divider">
                                        <div class="divider-text">Measurement</div>
                                    </div>
                                    
                                    <div class="col-md-6 form-group">
                                        <label>Previous Risk Apetite:</label>
                                        <input type="text" class="form-control" name="prev_rapetite" id="up_apetite" disabled>                                        
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Previous Date:</label>
                                        <input type="text" class="form-control" name="prev_date" id="up_date" disabled>                                        
                                    </div>
                                    <hr>
                                    <div class="col-md-6 form-group">                                        
                                        <label>Enter New Risk Performance:</label>
                                        <input type="number" class="form-control" name="rapetite">                                                                                 
                                    </div>                                             
                                         
                                    <div class="col-md-6 form-group">
                                         <label>Enter New Timeline:</label>
                                        <input type="text" class="form-control" name="timeline" id="datepicker2">
                                    </div>                                
                                </div><!--end of row--->

                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-4">

                            </div>
                            <div class="col-md-4">
                                <button type="submit" name="addkri" class="btn btn-primary btn-lg riskperfhist">UPDATE</button>
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
