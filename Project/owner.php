<?php
include_once'./department/departmentClass.php';
include_once'./settings/divisionClass.php'; 
include_once'./settings/ownerClass.php';
//department class functions
$deptClass=new departmentClass();
$showDept=$deptClass->showDept();

//division class functions
$divisionClass=new divisionClass();
$showDiv=$divisionClass->showDivision();

$ownerClass=new ownerClass();
$showOwner=$ownerClass->showOwner();

?>
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
    <h4>Owners Lists</h4>
</div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
    <!-_________________Content location BEGINING______________________->

                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <button class="btn btn-primary" style="float:right;margin-right:30px;" data-bs-toggle="modal" data-bs-target="#owner">
                            <span class="fa-fw select-all fas">ï•</span>Add Owner</button>
                            
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>Reference</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Department</th>
                                        <th>Division</th>
                                        <th>Supervisor</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php
                                   foreach($showOwner as $owner){
                                    $deptid=$owner["dept"];
                                    $deptname=$deptClass->deptJoins($deptid);

                                    $divid=$owner["division"];
                                    $divname=$deptClass->deptJoins($divid);
                                        echo'<tr>
                                            <td>OID00'.$owner["id"].'</td>
                                            <td>'.$owner["fname"].'&nbsp;'.$owner["sname"].'</td>
                                            <td>'.$owner["email"].'</td>
                                            <td>'.$deptname.'</td>
                                            <td>'.$divname.'</td>
                                            <td>'.$owner["sup"].'</td>
                                            <td>
                                            <a href="#" class="btn btn-sm btn-primary stg-edit" data-form="#ownereditform" data-modal="#owneredit-modal" data-id="'.$owner["id"].'" data-fname="'.htmlspecialchars($owner["fname"],ENT_QUOTES).'" data-sname="'.htmlspecialchars($owner["sname"],ENT_QUOTES).'" data-email="'.htmlspecialchars($owner["email"],ENT_QUOTES).'" data-sup="'.htmlspecialchars($owner["sup"],ENT_QUOTES).'" data-dept="'.htmlspecialchars($owner["dept"],ENT_QUOTES).'" data-division="'.htmlspecialchars($owner["division"],ENT_QUOTES).'"><span class="fa-fw select-all fas">ïŒƒ</span></a>
                                            <a href="#" class="btn btn-sm btn-danger stg-del" data-url="ownercrud.php" data-id="'.$owner["id"].'" data-name="'.htmlspecialchars($owner["fname"].' '.$owner["sname"],ENT_QUOTES).'"><span class="fa-fw select-all fas">ï‹­</span></a>
                                            </td>
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

  <!-- Edit Owner modal -->
  <div class="modal fade text-left" id="owneredit-modal" tabindex="-1" aria-hidden="true"><div class="modal-dialog"><div class="modal-content">
    <div class="modal-header"><h4 class="modal-title">Edit Owner</h4><button type="button" class="btn btn-danger close" data-bs-dismiss="modal"><i data-feather="x"></i></button></div>
    <form id="ownereditform" class="stg-form" data-url="ownercrud.php" data-redirect="owner.php"><div class="modal-body">
      <input type="hidden" name="id">
      <div class="form-group"><label>First Name</label><input class="form-control" name="fname"></div>
      <div class="form-group"><label>Surname</label><input class="form-control" name="sname"></div>
      <div class="form-group"><label>Email</label><input type="email" class="form-control" name="email"></div>
      <div class="form-group"><label>Supervisor</label><select class="form-control" name="sup"><option value="Admin">Admin</option></select></div>
      <div class="form-group"><label>Department</label><select class="form-control" name="dept"><option value="0">----Choose Department----</option>
        <?php foreach ($showDept as $d) echo '<option value="' . (int)$d['dept_id'] . '">' . htmlspecialchars($d['dept_name'], ENT_QUOTES) . '</option>'; ?></select></div>
      <div class="form-group"><label>Division</label><select class="form-control" name="division"><option value="0">----Choose Division----</option>
        <?php foreach ($showDiv as $dv) echo '<option value="' . (int)$dv['id'] . '">' . htmlspecialchars($dv['name'], ENT_QUOTES) . '</option>'; ?></select></div>
    </div><div class="modal-footer"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button><button type="submit" class="btn btn-primary">Update Owner</button></div></form>
  </div></div></div>
  <!-- Shared settings delete modal -->
  <div class="modal fade text-left" id="stgdel-modal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-dialog-centered"><div class="modal-content">
    <div class="modal-header bg-danger"><h5 class="modal-title white">Delete</h5><button type="button" class="close" data-bs-dismiss="modal"><i data-feather="x"></i></button></div>
    <div class="modal-body"><input type="hidden" id="stgdel_url"><input type="hidden" id="stgdel_id"><h5>Delete this record?</h5><div style="font-weight:600;text-align:center;margin-top:8px;" id="stgdel_name"></div></div>
    <div class="modal-footer"><button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Close</button><button type="button" class="btn btn-danger stgdel-confirm">Delete</button></div>
  </div></div></div>

        <?php include_once'../layout/footer.php'; ?>
        
        </div>
        
    </div>

<!-----------------------------------------Modal For DEpartment-------------------------------->
 <!--Basic Modal -->
 <div class="modal fade text-left" id="owner" tabindex="-1" role="dialog"aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg"
        role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel17">Add Owner</h3>
                <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>        
            <form class="form form-horizontal ia-simple-add" action="ownerAction.php" method="POST" data-redirect="owner.php">
            <div class="modal-body">
                    <div class="row">
                        
                            <div class="col-md-2">
                                <label>First name:</label>
                            </div>
                            <div class="col-md-4 form-group">
                                <input type="text" class="form-control" name="fname"
                                    placeholder="First name">
                            </div>
                            <div class="col-md-2">
                                <label>Second Name:</label>
                            </div>
                            <div class="col-md-4 form-group">
                                <input type="text"  class="form-control" name="sname"
                                    placeholder="Second Name">
                            </div>    <hr><br>                                
                            <div class="col-md-2">
                                <label>Email:</label>
                            </div>
                            <div class="col-md-4 form-group">
                                <input type="email"  class="form-control"  name="email"
                                    placeholder="Email">
                            </div>
                            <div class="col-md-2">
                                <label>Supervisor:</label>
                            </div>
                            <div class="col-md-4 form-group">
                                <select class="form-control" name="sup" id="">
                                    <option value="Admin">Admin</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>Department:</label>
                            </div>
                            <div class="col-md-4 form-group">
                                <select class="form-control" name="dept" id="">
                                    <option value="0" selected>----Choose Department----</option>
                                    <?php
                                    foreach($showDept as $dept){
                                   echo' <option value='.$dept["dept_id"].'>'.$dept["dept_name"].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>Division:</label>
                            </div>
                            <div class="col-md-4 form-group">
                                <select class="form-control" name="division" id="">
                                <option value="0" selected>----Choose Division----</option>
                                <?php
                                foreach($showDiv as $division){
                                    echo'<option value='.$division["id"].'>'.$division["name"].'</option>';
                                }
                                ?>
                                </select>
                            </div>
                            
                        </div><!--end of row--->
                        
                      
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary"
                    data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
                <button type="submit" name="addowner" class="btn btn-primary">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Add Owner</span>
                </button>
            </div>
            </form>
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
