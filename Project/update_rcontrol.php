<?php
include_once'./risk/riskClass.php';
include_once'./control/controlClass.php';
include_once'./settings/controlstrengthClass.php';
include_once'./settings/controltypeClass.php';
include_once'./users/usersClass.php';

$rid=$_GET['id'];

$cstrengthClass=new controlstrengthClass();
$ctypeclass= new controltypeClass();
$controlclass=new controlClass();
$riskClass=new riskClass();
$userclass=new usersClass();

$rname=$riskClass->Riskjoin($rid);
$showcontrol=$controlclass->showcontrol();
$showrcontrol=$controlclass->joinriskcontrol($rid);
$riskdata=$riskClass->fetchRisk($rid);

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
    <h4>Edit Risk Controls</h4>
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
                    .card{
                        width: 60%;
                        margin: 0 auto;
                    }

                    tr,td{
                        font-size:11px;
                        padding: 0px !important;
                        font-weight: 800;
                        color: #000;
                    }
                
                    
                </style>
        <section class="section">
            <form action="" id="riskcontrolform">           
                    <div class="card">
                        <div class="card-header row">
                            <center><h3 style="font-weight:800;color:#0829fb;">RISK NAME: &nbsp;</b><?=$rname?></h3></center>
                            
                                <div class="col-md-10">
                                    <label>Select Controls:</label>
                                    <select class="form-control choices multiple-remove" multiple="multiple" onchange="fetchcontrol(this.value)" name="controlid[]" id="controlid">
                                        <?php
                                        foreach($showcontrol as $control){
                                        echo'<option  value='.$control["control_id"].'>'.$control["controls"].'</option>';

                                            }
                                        ?>
                                    </select>
                                </div>
                                <input type="hidden" name="rid" value="<?=$rid?>" id="">
                                <input type="hidden" name="dept" value="<?=$riskdata['dept']?>" id="">
                                <div class="col-md-2">
                                    <label></label>
                                    <button class="btn btn-sm btn-primary addriskcontrol">ADD CONTROL</button>
                                </div>
                            </form>
                           <!-- <input type="hidden" name="file_content" id="file_content">
                            <a href="addcontrol.php" class="btn btn-primary" style="float:right;margin-right:30px;" ><span class="fa-fw select-all fas">ï•</span>Add Controls</a>
                            <button type="button" name="convert" id="convert" class="btn btn-primary convert" style="float:right;margin-right:30px;">EXPORT</button>-->
                        </div>
                
                        <div class="card-body">
                            <table class="table table-striped" id="table1">
                                <thead id="thead">
                                    <tr>
                                        <th>Reference</th>
                                        <th>Control</th>
                                        <th>Control Strength</th>
                                        <th>Control Type</th>
                                        <th>Reviewer</th> 
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                        foreach($showrcontrol as $rcontrol){
                           // $rid=$control["risk"];
                            //$riskname=substr($riskClass->Riskjoin($rid), 0 , 60);
                            $cid=$rcontrol["control_id"];
                            $controlname=$controlclass->joincontrol($cid);
                            
                            $csid=$controlclass->fetchcstrength($cid);
                            $csname=$cstrengthClass->strengthjoin($csid);

                            $ctid=$controlclass->fetchctype($cid);
                            $ctype=$ctypeclass->ctypejoin($ctid);

                            $uid=$controlclass->fetchreviewer($cid);
                            $user=$userclass->userjoin($uid);

                            
                            
                           
                            echo'
                                    <tr>
                                        <td>CTL00'.$cid.'</td>
                                        <td>'.$controlname.'</td>
                                        <td>'.$csname.'</td>
                                        <td>'.$ctype.'</td>
                                        <td>'.$user.'<td>
                                        <td><button class="btn btn-danger btn-sm remove-control" id='.$rcontrol["control_id"].'>Remove</button></td>
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

<!-----------------------------------DELETE  Modal ---------------------------------------------------------------->
                <div class="modal fade text-left" id="delete-modal" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel120" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                            role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-danger">
                                    <h5 class="modal-title white" id="myModalLabel120">Delete Control
                                    </h5>
                                    <button type="button" class="close" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                </div>
                                <form id="deleteform">
                                <div class="modal-body">
                                <div>
                                    <input type="hidden" name="dcid" id="dcid" value="">
                                    <input type="hidden" name="rid" id="" value="<?=$rid?>">
                                    <h3>Are you Sure you want to Remove?</h3>
                                    <div id="messagedelete"></div>
                                <div style="color:#000;font-weight:600;font-size:29px;text-align:center;">Controls:<h6 id="dcname"></h6></div>
                                </div>
                                
                                


                                </div>
                                <div class="modal-footer">
                                    
                                    <button type="button" class="btn btn-light-secondary"
                                        data-bs-dismiss="modal">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Close</span>
                                    </button>
                                    <button type="button" class="delete-control btn btn-danger ml-1"
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
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        if (table1) new simpleDatatables.DataTable(table1);
    </script>

<!---------------------------------SWEET ALERTS----------------------------------------->
    <script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>

<!----------------------Datatable Simple end------------------------------------------------>

    <script src="../assets/js/pages/horizontal-layout.js"></script>

<!----------------------font awsome------------------------------------------------>
    <script src="../assets/vendors/fontawesome/all.min.js"></script>

   
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
