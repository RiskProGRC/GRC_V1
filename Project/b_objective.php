
<!DOCTYPE html>
<html lang="en">
<!-_________________Header location______________________->
<?php include_once'../layout/header.php'; ?>

<body>
    <div id="app">
        <div id="main" class="layout-horizontal">

 <!-_________________Navigation location______________________->

 <?php include_once'../layout/nav.php';?>

            <div class="content-wrapper container">
                
<div class="page-heading">
    <h4>Business Objectives</h4>
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
                    <div class="card">
                        <div class="card-header">
                           <!-- <a href="../Project/kriadd.php" class="btn btn-primary" style="float:right;margin-right:30px;">
                            <span class="fa-fw select-all fas">ï•</span></a>-->
                            
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>Business Objective</th>
                                        <th>Risk Description</th>
                                        <th>KRI(Key Risk Indicator)</th>
                                        <th>Owner</th>
                                        <th>Risk Limit</th>
                                        <th colspan="3">Tolerance limit</th>
                                        <th>Date</th>
                                        <th>Risk Perfomance</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $datetoday= date('Y-m-d');
                                    
                                    $i=1;
                                    foreach($showb_obj as $kri){
                                        $kpiid=$kri["kpi"];
                                        $kpi=$kiclass->fetchedit($kpiid);
                                        $rid=$kpi["risk_id"];
                                        $riskname=$riskClass->Riskjoin($rid);

                                        $uid=$kri["owner"];
                                        $owner=$userclass->userjoin($uid);

                                        $kid=$kri["kri"];
                                        $rlimit=$kriClass->fetchrisklimit($kid);
                                        $pname=$kriClass->fetchparameter($kid);
                                        $mngt=$kriClass->fetchmngt($kid);
                                        $board=$kriClass->fetchboard($kid);
                                        $mboard=$kriClass->fetchmngtboard($kid);
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
                                            <td><textarea name="" id="" cols="90" class="form-control" rows="6">'.$kri["b_objective"].'</textarea></td>
                                            <td>'.$riskname.'</td>
                                            <td>'.$pname.'</td>
                                            <td>'. $owner.'</td>
                                            <td>'.$rlimit.'&nbsp;'.$rapt.'</td>
                                            <td><button class="btn btn-success">'.$mngt.'&nbsp;'.$rapt.'</button></td>
                                            <td><button class="btn btn-warning">'.$board.'&nbsp;'.$rapt.'</button></td>
                                            <td><button class="btn btn-danger">'.$mboard.'&nbsp;'.$rapt.'</button</td>
                                            <td>'. $sdate.'</td>
                                            <td style="padding:0px;"><button style="width:100%;padding:15px 15px;border-radius:0px;" class="btn '.$alert.'">'.$kri["perform"].'&nbsp;'.$rapt.'</button</td>
                                            
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
   

</body>

</html>
