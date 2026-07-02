<?php
include_once'./users/usersClass.php';

$usersclass= new usersClass();

$uid = $_GET["id"] ?? '';
if ($uid === '' || !ctype_digit((string)$uid)) { // guard: page requires a target user id (avoids a TypeError/500 on direct access)
    header('Location: userslist.php');
    exit;
}
$profile=$usersclass->profile($uid);
$permission=$usersclass->fetchpermission($uid);
$puid=$uid;
    ?>

<!DOCTYPE html>
<html lang="en">
<!-_________________Header location______________________->
<?php include_once("../layout/header.php"); ?>
<style>
    body {
    background: rgb(39 59 120)
}

.form-control:focus {
    box-shadow: none;
    border-color: #BA68C8
}
.access{
    margin-left: 20px;
    background: rgb(99, 39, 120);
}

.profile-button {
    background: #435ebe;
    box-shadow: none;
    border: none
}

.profile-button:hover {
    background: #682773
}

.profile-button:focus {
    background: #682773;
    box-shadow: none
}

.profile-button:active {
    background: #682773;
    box-shadow: none
}

.back:hover {
    color: #682773;
    cursor: pointer
}

.labels {
    font-size: 11px
}

.add-experience:hover {
    background: #BA68C8;
    color: #fff;
    cursor: pointer;
    border: solid 1px #BA68C8
}
.space{
    margin-right: 20px;
}
</style>
<body>
    
    <div id="app">
        <div id="main" class="layout-horizontal">

 <!-_________________Navigation location______________________->

            <?php include_once("../layout/nav.php") ?>

            <div class="content-wrapper container">
                

    <!-_________________Content location BEGINING______________________->

    
    <div class="page-content">
        <section  class="row">
            <div class="col-lg-12">
            <div class="container rounded bg-white mt-5 mb-5">
    <form action="permissionaction.php" method="post" class="ia-simple-add" data-redirect="userslist.php">
        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="../assets/images/faces//silhouette-glasses-profile.jpg">
                <span class="font-weight-bold"><?=$profile["username"]?></span><span class="text-black-50"><?=$profile["email"]?></span><span> </span></div>
            </div>
            <div class="col-md-5 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Permission Settings</h4>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12">
                        <h4 class="card-title">Key Roles</h4>
                                <ul class="list-unstyled mb-0">
                                    <li class="d-inline-block me-2 mb-1">
                                        <div class="form-check">
                                            <div class="checkbox space">
                                            <input type="hidden" class="form-control" name="uid" value="<?=$puid?>">
                                                <input type="checkbox" id="checkbox1" name="add" class="form-check-input" <?php if($permission["add_btn"]==1){echo "checked";}else{} ?>>
                                                <label for="checkbox1">ADD</label>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-inline-block me-2 mb-1">
                                        <div class="form-check">
                                            <div class="checkbox space">
                                                <input type="checkbox" name="edit" class="form-check-input" id="checkbox2" <?php if($permission["edit_btn"]==1){echo "checked";}else{} ?>>
                                                <label for="checkbox2">EDIT</label>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-inline-block me-2 mb-1">
                                        <div class="form-check">
                                            <div class="checkbox space">
                                                <input type="checkbox" id="checkbox3" name="delete" value="1" class="form-check-input" <?php if($permission["delete_btn"]==1){echo "checked";}else{} ?>>
                                                <label for="checkbox3">DELETE</label>
                                            </div>
                                        </div>
                                    </li>
                                    <hr>
                                </ul>
                        </div>
                    </div>
                    <div class="row mt-3">
                    <div class="col-md-12">
                        <h4 class="card-title">Menus</h4>
                            <ul class="list-unstyled mb-0">
                                <li class="d-inline-block me-2 mb-1">
                                    <div class="form-check">
                                        <div class="checkbox space">
                                            <input type="checkbox" id="checkbox1" name="process" value="1" class="form-check-input" <?php if($permission["process"]==1){echo "checked";}else{} ?>>
                                            <label for="checkbox1">Process</label>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-inline-block me-2 mb-1">
                                    <div class="form-check">
                                        <div class="checkbox space">
                                            <input type="checkbox" id="checkbox1" name="control" value="1" class="form-check-input" <?php if($permission["control"]==1){echo "checked";}else{} ?>>
                                            <label for="checkbox1">Control</label>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-inline-block me-2 mb-1">
                                    <div class="form-check">
                                        <div class="checkbox space">
                                            <input type="checkbox" id="checkbox1" name="recommend" value="1" class="form-check-input" <?php if($permission["recommend"]==1){echo "checked";}else{} ?>>
                                            <label for="checkbox1">Recommendation</label>
                                        </div>
                                    </div>
                                </li>
                                <hr>
                            </ul>
                    </div>

                        <div class="col-md-12">
                         <h4 class="card-title">Risk</h4>
                            <ul class="list-unstyled mb-0">
                                <li class="d-inline-block me-2 mb-1">
                                    <div class="form-check">
                                        <div class="checkbox space">
                                            <input type="checkbox" id="checkbox1" name="rlist" value="1" class="form-check-input" <?php if($permission["rlist"]==1){echo "checked";}else{} ?>>
                                            <label for="checkbox1">Risk List</label>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-inline-block me-2 mb-1">
                                    <div class="form-check">
                                        <div class="checkbox space">
                                            <input type="checkbox" id="checkbox1" name="rassess" value="1" class="form-check-input" <?php if($permission["rassess"]==1){echo "checked";}else{} ?>>
                                            <label for="checkbox1">Risk Assessment</label>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-inline-block me-2 mb-1">
                                    <div class="form-check">
                                        <div class="checkbox space">
                                            <input type="checkbox" id="checkbox1" name="rregister" value="1" class="form-check-input" <?php if($permission["rregister"]==1){echo "checked";}else{} ?>>
                                            <label for="checkbox1">Risk Register</label>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-inline-block me-2 mb-1">
                                    <div class="form-check">
                                        <div class="checkbox space">
                                            <input type="checkbox" id="checkbox1" name="top" value="1" class="form-check-input" <?php if($permission["top"]==1){echo "checked";}else{} ?>>
                                            <label for="checkbox1">Top 10</label>
                                        </div>
                                    </div>
                                </li>
                                <hr>
                            </ul>   
                    </div>
                        <!--<div class="col-md-12"><label class="labels">Postcode</label><input type="text" class="form-control" placeholder="enter address line 2" value=""></div>
                        <div class="col-md-12"><label class="labels">State</label><input type="text" class="form-control" placeholder="enter address line 2" value=""></div>
                        <div class="col-md-12"><label class="labels">Area</label><input type="text" class="form-control" placeholder="enter address line 2" value=""></div>
                        <div class="col-md-12"><label class="labels">Address Line 2</label><input type="text" class="form-control" placeholder="enter email id" value=""></div>
                        <div class="col-md-12"><label class="labels">Education</label><input type="text" class="form-control" placeholder="education" value=""></div>-->
                    </div>
                    <div class="row mt-3">
                        <!--<div class="col-md-6"><label class="labels">Country</label><input type="text" class="form-control" placeholder="country" value=""></div>
                        <div class="col-md-6"><label class="labels">State/Region</label><input type="text" class="form-control" value="" placeholder="state"></div>-->
                    </div>
                    <div class="mt-5 text-center">
                        <a href="../Project/userslist.php" class="btn btn-danger btn-lg" type="button">CLOSE</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                       <!-- <button class="btn btn-primary btn-lg profile-button" type="button">Update Permission</button>-->
                        <input type="submit" class="btn btn-primary btn-lg"  value="Update Permission">
                    </div>
                    
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 py-5">
             <div class="d-flex justify-content-between align-items-center experience"><span><h4></h4></span><span class="border px-3 p-1 add-experience"><i class=""></i>&nbsp;</span></div><br>                 <div class="col-md-12">
                      <h4 class="card-title">Risk Monitoring</h4>
                        <ul class="list-unstyled mb-0">
                            <li class="d-inline-block me-2 mb-1">
                                <div class="form-check">
                                    <div class="checkbox">
                                        <input type="checkbox" id="checkbox1" name="kpi" value="1" class="form-check-input" <?php if($permission["kpi"]==1){echo "checked";}else{} ?>>
                                        <label for="checkbox1">KPI</label>
                                    </div>
                                </div>
                            </li>
                            <li class="d-inline-block me-2 mb-1">
                                <div class="form-check">
                                    <div class="checkbox ">
                                        <input type="checkbox" id="checkbox1" name="kri" value="1" class="form-check-input" <?php if($permission["kri"]==1){echo "checked";}else{} ?>>
                                        <label for="checkbox1">KRI</label>
                                    </div>
                                </div>
                            </li>
                            <li class="d-inline-block me-2 mb-1">
                                <div class="form-check">
                                    <div class="checkbox ">
                                        <input type="checkbox" id="checkbox1" name="perform" value="1" class="form-check-input" <?php if($permission["perform"]==1){echo "checked";}else{} ?>>
                                        <label for="checkbox1">Risk Performance</label>
                                    </div>
                                </div>
                            </li>
                            <li class="d-inline-block me-2 mb-1">
                                <div class="form-check">
                                    <div class="checkbox ">
                                        <input type="checkbox" id="checkbox1" name="incident" value="1" class="form-check-input" <?php if($permission["incident"]==1){echo "checked";}else{} ?>>
                                        <label for="checkbox1">Incidents</label>
                                    </div>
                                </div>
                            </li>
                            <li class="d-inline-block me-2 mb-1">
                                <div class="form-check">
                                    <div class="checkbox ">
                                        <input type="checkbox" id="checkbox1" name="action" value="1" class="form-check-input" <?php if($permission["action"]==1){echo "checked";}else{} ?>>
                                        <label for="checkbox1">Actions</label>
                                    </div>
                                </div>
                            </li>
                            <li class="d-inline-block me-2 mb-1">
                                <div class="form-check">
                                    <div class="checkbox ">
                                        <input type="checkbox" id="checkbox1" name="objective" value="1" class="form-check-input" <?php if($permission["objective"]==1){echo "checked";}else{} ?>>
                                        <label for="checkbox1">Business Objectives</label>
                                    </div>
                                </div>
                            </li>
                            <hr>
                        </ul>
                    </div> <br>
                <div class="col-md-12">
                  <h4 class="card-title">Audit Report</h4>
                    <ul class="list-unstyled mb-0">
                        <li class="d-inline-block me-2 mb-1">
                                <div class="form-check">
                                    <div class="checkbox space">
                                    <input type="checkbox" id="checkbox1" name="report" value="1" class="form-check-input" <?php if($permission["report"]==1){echo "checked";}else{} ?>>
                                    <label for="checkbox1">Audit Report</label>
                                </div>
                            </div>
                        </li>
                        <li class="d-inline-block me-2 mb-1">
                            <div class="form-check">
                                <div class="checkbox space">
                                    <input type="checkbox" id="checkbox1" name="card" value="1" class="form-check-input" <?php if($permission["card"]==1){echo "checked";}else{} ?>>
                                    <label for="checkbox1">Tracking Card</label>
                                </div>
                            </div>
                        </li>
                        <li class="d-inline-block me-2 mb-1">
                            <div class="form-check">
                                <div class="checkbox space">
                                    <input type="checkbox" id="checkbox1" name="rating" value="1" class="form-check-input" <?php if($permission["rating"]==1){echo "checked";}else{} ?>>
                                    <label for="checkbox1">Audit Rating</label>
                                </div>
                            </div>
                        </li>
                        <hr>
                    </ul>
                <!-- <div class="col-md-12"><label class="labels">Additional Details</label><input type="text" class="form-control" placeholder="additional details" value=""></div>-->
                </div>

                
            </div>
        </div>
    </form>
</div>
</div>
</div>
</div>

    <!---_________________Content location END______________________-->
                
            
        </section>
    </div>

  </div>





 <!-_________________Footer location______________________->

        <?php include_once("../layout/footer.php"); ?>

        

     <!-----------------------------------RISK Modals--------------------------------------------------------------->
     
    
        </div>
        
    </div>

<!-----------------------------------------Modal For PERMISSIONS-------------------------------->
<!--Basic Modal -->
<div class="modal fade text-left" id="access-modal" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <form id="permission">
                <h5 class="modal-title" id="myModalLabel1">User Permisions</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <section id="basic-checkbox">                    
                <div class="row">                            
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <h4 class="card-title">Key Roles</h4>
                                <ul class="list-unstyled mb-0">
                                    <li class="d-inline-block me-2 mb-1">
                                        <div class="form-check">
                                            <div class="checkbox space">
                                            <input type="hidden" class="form-control" name="uid" value="<?=$uid?>">
                                                <input type="checkbox" id="checkbox1" name="add" value="1" class="form-check-input" checked>
                                                <label for="checkbox1">ADD</label>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-inline-block me-2 mb-1">
                                        <div class="form-check">
                                            <div class="checkbox space">
                                                <input type="checkbox" name="edit" value="1" class="form-check-input" id="checkbox2" checked>
                                                <label for="checkbox2">EDIT</label>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-inline-block me-2 mb-1">
                                        <div class="form-check">
                                            <div class="checkbox space">
                                                <input type="checkbox" id="checkbox3" name="delete" value="1" class="form-check-input" checked>
                                                <label for="checkbox3">DELETE</label>
                                            </div>
                                        </div>
                                    </li>
                                    <hr>
                                </ul>
                                <div class="row">
                                    <div class="col-sm-12">
                                    <h4 class="card-title">Menus</h4>
                                        <ul class="list-unstyled mb-0">
                                            <li class="d-inline-block me-2 mb-1">
                                                <div class="form-check">
                                                    <div class="checkbox space">
                                                        <input type="checkbox" id="checkbox1" name="process" value="1" class="form-check-input" checked>
                                                        <label for="checkbox1">Process</label>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="d-inline-block me-2 mb-1">
                                                <div class="form-check">
                                                    <div class="checkbox space">
                                                        <input type="checkbox" id="checkbox1" name="control" value="1" class="form-check-input" checked>
                                                        <label for="checkbox1">Control</label>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="d-inline-block me-2 mb-1">
                                                <div class="form-check">
                                                    <div class="checkbox space">
                                                        <input type="checkbox" id="checkbox1" name="recommend" value="1" class="form-check-input" checked>
                                                        <label for="checkbox1">Recommendation</label>
                                                    </div>
                                                </div>
                                            </li>
                                            <hr>
                                        </ul>
                                    </div>
                                    <div class="col-sm-12"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                    <h4 class="card-title">Risk</h4>
                                        <ul class="list-unstyled mb-0">
                                            <li class="d-inline-block me-2 mb-1">
                                                <div class="form-check">
                                                    <div class="checkbox space">
                                                        <input type="checkbox" id="checkbox1" name="rlist" value="1" class="form-check-input" checked>
                                                        <label for="checkbox1">Risk List</label>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="d-inline-block me-2 mb-1">
                                                <div class="form-check">
                                                    <div class="checkbox space">
                                                        <input type="checkbox" id="checkbox1" name="rassess" value="1" class="form-check-input" checked>
                                                        <label for="checkbox1">Risk Assessment</label>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="d-inline-block me-2 mb-1">
                                                <div class="form-check">
                                                    <div class="checkbox space">
                                                        <input type="checkbox" id="checkbox1" name="rregister" value="1" class="form-check-input" checked>
                                                        <label for="checkbox1">Risk Register</label>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="d-inline-block me-2 mb-1">
                                                <div class="form-check">
                                                    <div class="checkbox space">
                                                        <input type="checkbox" id="checkbox1" name="top" value="1" class="form-check-input" checked>
                                                        <label for="checkbox1">Top 10</label>
                                                    </div>
                                                </div>
                                            </li>
                                            <hr>
                                        </ul>
                                    </div>
                                    <div class="col-sm-12"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                    <h4 class="card-title">Risk Monitoring</h4>
                                        <ul class="list-unstyled mb-0">
                                            <li class="d-inline-block me-2 mb-1">
                                                <div class="form-check">
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="checkbox1" name="kpi" value="1" class="form-check-input" checked>
                                                        <label for="checkbox1">KPI</label>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="d-inline-block me-2 mb-1">
                                                <div class="form-check">
                                                    <div class="checkbox ">
                                                        <input type="checkbox" id="checkbox1" name="kri" value="1" class="form-check-input" checked>
                                                        <label for="checkbox1">KRI</label>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="d-inline-block me-2 mb-1">
                                                <div class="form-check">
                                                    <div class="checkbox ">
                                                        <input type="checkbox" id="checkbox1" name="perform" value="1" class="form-check-input" checked>
                                                        <label for="checkbox1">Risk Performance</label>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="d-inline-block me-2 mb-1">
                                                <div class="form-check">
                                                    <div class="checkbox ">
                                                        <input type="checkbox" id="checkbox1" name="incident" value="1" class="form-check-input" checked>
                                                        <label for="checkbox1">Incidents</label>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="d-inline-block me-2 mb-1">
                                                <div class="form-check">
                                                    <div class="checkbox ">
                                                        <input type="checkbox" id="checkbox1" name="action" value="1" class="form-check-input" checked>
                                                        <label for="checkbox1">Actions</label>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="d-inline-block me-2 mb-1">
                                                <div class="form-check">
                                                    <div class="checkbox ">
                                                        <input type="checkbox" id="checkbox1" name="objective" value="1" class="form-check-input" checked>
                                                        <label for="checkbox1">Business Objectives</label>
                                                    </div>
                                                </div>
                                            </li>
                                            <hr>
                                        </ul>
                                    </div>
                                    <div class="col-sm-12"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                    <h4 class="card-title">Audit Report</h4>
                                        <ul class="list-unstyled mb-0">
                                            <li class="d-inline-block me-2 mb-1">
                                                <div class="form-check">
                                                    <div class="checkbox space">
                                                        <input type="checkbox" id="checkbox1" name="report" value="1" class="form-check-input" checked>
                                                        <label for="checkbox1">Audit Report</label>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="d-inline-block me-2 mb-1">
                                                <div class="form-check">
                                                    <div class="checkbox space">
                                                        <input type="checkbox" id="checkbox1" name="card" value="1" class="form-check-input" checked>
                                                        <label for="checkbox1">Tracking Card</label>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="d-inline-block me-2 mb-1">
                                                <div class="form-check">
                                                    <div class="checkbox space">
                                                        <input type="checkbox" id="checkbox1" name="rating" value="1" class="form-check-input" checked>
                                                        <label for="checkbox1">Audit Rating</label>
                                                    </div>
                                                </div>
                                            </li>
                                            <hr>
                                        </ul>
                                    </div>
                                    <div class="col-sm-12"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                    
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
                <button type="button" class="btn btn-primary permission-button" id="" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Add Permision</span>
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

<!------------------------------SWEET ALERTS---------------------------------->
     <script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>

<!----------------------font awsome------------------------------------------------>
    <script src="../assets/vendors/fontawesome/all.min.js"></script>

<!------------- Include Choices select JavaScript ------------------------------------------------>
<script src="../assets/vendors/choices.js/choices.min.js"></script>
<script src="../assets/js/pages/form-element-select.js"></script>

   

</body>

</html>
