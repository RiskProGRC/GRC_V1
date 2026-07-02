<?php
include_once './risk/riskClass.php';
include_once './settings/riskcategoryClass.php';
include_once './settings/ownerClass.php';
include_once './department/departmentClass.php';
include_once './settings/divisionClass.php';
include_once './settings/projectClass.php';

// "Entities" in this application are departments (see entitylist.php) — the original
// code referenced a non-existent entityClass, which fataled the whole page.
$showEntity = (new departmentClass())->showDept();

$riskClass= new riskClass();
$showRisk= $riskClass->showRisk();

$ownerClass=new ownerClass();

$deptClass= new departmentClass();

$divisionClass=new divisionClass();

$riskCatClass=new riskCatClass();

$projectClass=new projectClass();
$showproject=$projectClass->showProject();



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
    <h4>Projects Lists</h4>
</div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
    <!-_________________Content location BEGINING______________________->
<style>
    .Scroll {
  height:150px;
  overflow-y: scroll;
}
</style>
                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <button class="btn btn-primary" style="float:right;margin-right:30px;" data-bs-toggle="modal" data-bs-target="#project">
                            <span class="fa-fw select-all fas">ï•</span>Add Project</button>
                            
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>Reference</th>
                                        <th>Project  Name</th>
                                        <th>Entity(E00-)</th>
                                        <th>Risk's</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach($showproject as $project){
                                            //$eid=explode(',', );
                                            //$entityname=$projectClass->explode($eid);
                                            echo'<tr>
                                            <td>'.$project["id"].'</td>
                                            <td>'.$project["name"].'</td>
                                            <td>'.$project["entityid"].'</td>
                                            <td>RSK00'.$project["riskid"].'</td>
                                            <td>
                                            <a href="#" class="btn btn-sm btn-primary proj-edit" data-id="'.$project["id"].'" data-name="'.htmlspecialchars($project["name"],ENT_QUOTES).'" data-entity="'.htmlspecialchars($project["entityid"],ENT_QUOTES).'" data-risk="'.htmlspecialchars($project["riskid"],ENT_QUOTES).'"><span class="fa-fw select-all fas">ïŒƒ</span></a>
                                            <a href="#" class="btn btn-sm btn-danger stg-del" data-url="projectcrud.php" data-id="'.$project["id"].'" data-name="'.htmlspecialchars($project["name"],ENT_QUOTES).'"><span class="fa-fw select-all fas">ï‹­</span></a>
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

  <!-- Edit Project modal -->
  <div class="modal fade text-left" id="projectedit-modal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-lg modal-dialog-scrollable"><div class="modal-content">
    <div class="modal-header"><h4 class="modal-title">Edit Project</h4><button type="button" class="btn btn-danger close" data-bs-dismiss="modal"><i data-feather="x"></i></button></div>
    <form id="projecteditform" class="stg-form" data-url="projectcrud.php" data-redirect="project.php"><div class="modal-body">
      <input type="hidden" name="id">
      <div class="form-group"><label>Project Name</label><input class="form-control" name="name"></div>
      <label class="mt-2"><b>Entities</b></label>
      <div class="Scroll form-group" style="max-height:180px;overflow:auto;"><table class="table table-bordered table-sm"><tr><th>#</th><th>Entity</th></tr>
        <?php foreach ($showEntity as $entity) echo '<tr><td><input class="form-check-input" type="checkbox" name="entity[]" value="' . (int)$entity['dept_id'] . '"></td><td>' . htmlspecialchars($entity['dept_name'], ENT_QUOTES) . '</td></tr>'; ?>
      </table></div>
      <label class="mt-2"><b>Risks</b></label>
      <div class="Scroll form-group" style="max-height:180px;overflow:auto;"><table class="table table-bordered table-sm"><tr><th>#</th><th>Risk</th></tr>
        <?php foreach ($showRisk as $risk) echo '<tr><td><input class="form-check-input" type="checkbox" name="risk[]" value="' . (int)$risk['id'] . '"></td><td>' . htmlspecialchars($risk['name'], ENT_QUOTES) . '</td></tr>'; ?>
      </table></div>
    </div><div class="modal-footer"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button><button type="submit" class="btn btn-primary">Update Project</button></div></form>
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
 <div class="modal fade text-left" id="project" tabindex="-1" role="dialog"aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg"
        role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel17">Add Project</h3>
                <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>        
            <form class="form form-horizontal ia-simple-add" action="projectAction.php" method="POST" data-redirect="project.php">
            <div class="modal-body">
                    <div class="row">
                        
                            <div class="col-md-4">
                                <label>Project Name:</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="text" class="form-control" name="name"
                                    placeholder="First name">
                            </div><hr><br> 
                            <div class="col-md-2">
                                <label>Select Entity:</label>
                            </div>
                            <div class=" Scroll col-md-10 form-group ">
                               <table class="table table-bordered">
                                   <th>#</th>
                                   <th>Entity (Department)</th>
                               <?php 
                               foreach($showEntity as $entity){
                               echo'
                                <tr>
                                        <td><input class="form-check-input" name="entity[]" type="checkbox" value='.(int)$entity["dept_id"].' id="flexCheckDefault"></td>
                                        <td>'.htmlspecialchars($entity["dept_name"],ENT_QUOTES).'</td>
                                    </tr>';
                               }
                                ?>
                               </table>
                            </div><hr><br>                                   
                            <div class="col-md-2">
                                <label>Select Risks:</label>
                            </div>
                            <div class="Scroll col-md-10 form-group">
                               <table class="table table-bordered">
                                   <th>#</th>
                                   <th>Inherent name</th>
                                   <th>Risk category</th>
                                   <th>Assessment</th>
                                   <th>Control</th>
                               <?php 
                               foreach($showRisk as $risk){
                                   $rcatid=$risk["rcat"];
                                   $rcatname=$riskCatClass->riskcatJoins($rcatid);
                               echo'
                                <tr>
                                        <td><input class="form-check-input" type="checkbox" name="risk[]" value='.$risk["id"].' id="flexCheckDefault"></td>
                                        <td>'.$risk["name"].'</td>
                                        <td>'.$rcatname.'</td>
                                        <td>assessment</td>
                                        <td>C001</td>
                                    </tr>';
                               }
                                ?>  
                               </table>
                            </div>
                                                        
                        </div><!--end of row--->
                        
                      
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary"
                    data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
                <button type="submit" name="addproject" class="btn btn-primary">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Add Project</span>
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
<!------------- Include Choices select JavaScript ------------------------------------------------>
<script src="../assets/vendors/choices.js/choices.min.js"></script>
<script src="../assets/js/pages/form-element-select.js"></script>

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
