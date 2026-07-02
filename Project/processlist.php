<?php 

?>
<!DOCTYPE html>
<html lang="en">
<!-_________________Header location______________________->
<?php include_once'../layout/header.php';?>

<?php 

?>

<body>
    <div id="app">
        <div id="main" class="layout-horizontal">

 <!-_________________Navigation location______________________->

 <?php include_once'../layout/nav.php'; ?>

            <div class="content-wrapper container">
                
<div class="page-heading">
    <h4>Process Lists</h4>
</div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
    <!-_________________Content location BEGINING______________________->

                <section class="section">
                    
                    <div class="card">
                        <div class="card-header">
                        

                            <!--<a href="../Project/addprocess" class="btn btn-primary" style="float:right;margin-right:30px;">
                            <span class="fa-fw select-all fas">ï•</span>Add Process</a>-->
                            <button onclick="location.href='../Project/addprocess.php'" type="button" class="btn btn-primary btn-userpermission-add" style="float:right;margin-right:30px;">
                            <span class="fa-fw select-all fas">ï•</span>Add Process</button>

                            
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="table1">
                                <thead id="thead">
                                    <tr>
                                        <th>Code</th>
                                        <th>Entity</th>
                                        <th>Process</th>
                                        <th>Details</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (is_array($showprocess) || is_object($showprocess))//used when the array is blank
                                    {
                                    foreach($showprocess as $process){
                                    $detail= substr($process["details"], 0, 50);
                                    $processname=ucfirst($process["process_name"]);

                                    $deptid=$process["dept_id"];
                                    $deptname=$deptClass->deptJoins($deptid);

                                    echo' <tr>
                                            <td>P00'.$process["process_id"].'</td>
                                            <td>'.$deptname.'</td>
                                            <td>'.$processname.'</td>
                                            <td>'.$detail.'</td>
                                            <td>
                                            <button name="edit" class="btn btn-sm btn-primary editprocess btn-userpermission-edit" id='.$process["process_id"].'><span class="fa-fw select-all fas">ïŒƒ</span></button>
                                            <button name="delete"  class="btn btn-sm btn-danger processdelete btn-userpermission-delete" id='.$process["process_id"].'><span class="fa-fw select-all fas">ï‹­</span></button>
                                            </td>
                                        </tr>';
                                    }
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
        
        </div>
        
    </div>
   <!-----------------------------------Company UPDATE Modals--------------------------------------------------------------->
   <div class="modal fade text-left" id="edit-modal" tabindex="-1" role="dialog"aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel17">EDIT PROCESS</h3>
                    <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>        
                <form class="form form-horizontal" id="formupdate" action="" method="">
                <div class="modal-body">
                <div class="row">
                                <div class="col-md-8">
                                            <label>Entity:</label>
                                    </div>    
                                <div class="col-md-12 form-group">
                                        <input type="hidden" name="pid" id="pid">

                                        <select class="form-control" name="entity" id="entity">
                                            <option value="" selected>----SELECT Entity---</option>
                                            <?php
                                            foreach($showdept as $dept){
                                                echo'<option value='.$dept["dept_id"].'>'.$dept["dept_name"].'</option>';

                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <label>Enter Process:</label>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <input type="text" class="form-control" name="pname" id="pname"
                                            placeholder="Enter Process">
                                    </div>

                                    <div class="col-md-8">
                                            <label>Enter details:</label>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <textarea class="form-control" name="detail" id="detail" rows="5"></textarea>
                                    </div>
                                
                            
                        </div><!--end of row--->

                </div>
                <div class="modal-footer">
                <div class="col-12 alert alert-danger" id="messagedisplay" style="text-align:center;font-size:25px;font-weight:600;"></div>
                    <button type="button" class="btn btn-light-secondary"
                        data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="" name="edit" class="updateprocess btn btn-primary">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">UPDATE</span>
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
     <!-----------------------------------COMPANY EDIT Modals--------------------------------------------------------------->
    
    
     <!-----------------------------------DELETE  Modal ---------------------------------------------------------------->
                <div class="modal fade text-left" id="delete-modal" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel120" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                            role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-danger">
                                    <h3 class="modal-title white" id="myModalLabel120">Delete Process
                                    </h3>
                                    <button type="button" class="close" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                </div>
                                <form id="deleteform">
                                <div class="modal-body">
                                <div>
                                    <input type="hidden" name="pdid" id="pdid" value="">
                                    <h3>Are you Sure you want to delete?</h3>
                                    <div id="messagedelete"></div>
                                <div style="color:#000;font-weight:600;font-size:29px;text-align:center;">Process Name:<h3 id="pdname"></h3></div>
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
    


    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>

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


     <!------------------------------SWEET ALERTS---------------------------------->
 <script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>
   
   <script>
    
    $("#datepicker").datepicker({
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
