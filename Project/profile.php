<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once './users/usersClass.php';
include_once './department/departmentClass.php';

$usersclass = new usersClass();
$deptClass  = new departmentClass();

$uid     = $_GET['id'] ?? '';
$profile = $usersclass->profile($uid);
$upid    = $profile['id'];
$puid    = $usersclass->accessbutton($uid);
$showdept = $deptClass->showDept();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

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
    <form id="profileform">
        <div class="row">
            <div class="col-md-3 border-right">
               
                <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="../assets/images/faces//silhouette-glasses-profile.jpg">
                <span class="font-weight-bold"><?=$profile["username"]?></span><span class="text-black-50"><?=$profile["email"]?></span><span> </span></div>
            </div>
            <div class="col-md-5 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Profile Settings</h4>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6"><label class="labels">Name</label>
                        <input type="hidden" class="form-control" name="uid" value="<?=$upid?>">
                        <input type="text" class="form-control" name="fname" value="<?=$profile["fname"]?>"></div>
                        <div class="col-md-6"><label class="labels">Second name</label>
                        <input type="text" class="form-control" name="sname" value="<?=$profile["sname"]?>" ></div>
                    </div>
                    <div class="row mt-3">
                    <div class="col-md-12"><label class="labels">Username</label>
                        <input type="text" class="form-control" name="user" value="<?=$profile["username"]?>"></div>

                        <div class="col-md-12"><label class="labels">Mobile Number</label>
                        <input type="text" class="form-control" name="phone" value="0<?=$profile["phone"]?>"></div>

                        <div class="col-md-12"><label class="labels">Gender</label>
                            <select class="form-select" name="gender" id="">
                                <?php
                                            $gender=$profile["gender"];
                                            if($gender=="male"){
                                            echo'
                                            <option value="male" selected>Male</option>
                                            <option value="female">Female</option>';
                                            }elseif($gender=="female"){
                                                echo'
                                                <option value="male">Male</option>
                                                <option value="female"  selected>Female</option>';
                                            }else{
                                                echo'<option value="" selected>SELECT</option>';
                                            }
                                ?>
                                    
                            </select>
                        </div>
                        <div class="col-md-12"><label class="labels">Email ID</label>
                        <input type="text" class="form-control" name="email" value="<?=$profile["email"]?>"></div>
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
                    <div class="mt-5 text-center d-flex gap-2 justify-content-center flex-wrap">
                        <a href="../Project/userslist.php" class="btn btn-danger btn-lg">CLOSE</a>
                        <button class="btn btn-primary btn-lg profileupdate" type="button">Update Profile</button>
                        <?php if ($uid != $puid): ?>
                            <button class="btn btn-primary btn-lg access" id="access">Permissions</button>
                        <?php endif; ?>
                        <?php if (isset($sess_roles) && $sess_roles == 1 && $upid != ($suid ?? '')): ?>
                            <button class="btn btn-warning btn-lg reset-pw-btn"
                                    data-uid="<?= htmlspecialchars((string)$upid) ?>"
                                    data-csrf="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                &#128274; Reset Password
                            </button>
                        <?php endif; ?>
                    </div>
                    
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center experience"><span><h4>Select User Roles</h4></span><!--<span class="border px-3 p-1 add-experience"><i class="fa fa-plus"></i>&nbsp;Experience</span>--></div><br>
                    <div class="col-md-12">
                    <label class="labels"><h5>Choose User Roles</h5></label>
                    <select class="form-select" name="roles" id="">
                    <?php
                                $roles=$profile["roles"];
                                if($roles==1){
                                echo'
                                <option value="1" selected>Administrator</option>
                                <option value="2">User</option>';
                                }elseif($roles==2){
                                    echo'
                                    <option value="1">Administrator</option>
                                    <option value="2" selected>User</option>';
                                }else{

                                }
                    ?>
                        
                        
                    </select></div> <br>
                <div class="col-md-12">
                    <label class="labels"><h5>Choose Department</h5></label>
                    <select class="form-select" name="dept" id="">
                        <option value="">Select Department</option>
                        <?php
                        foreach($showdept as $dept){
                            $selected=($profile["dept_id"]==$dept["dept_id"]) ? "selected" : "";
                            echo'<option '.$selected.' value='.$dept["dept_id"].'>'.$dept["dept_name"].'</option>';
                        }
                        ?>
                    </select> <br>
                <!-- <div class="col-md-12"><label class="labels">Additional Details</label><input type="text" class="form-control" placeholder="additional details" value=""></div>-->
                </div>

                <div class="col-md-12">
                    <label class="labels"><h5 style="color: red;">SYSTEM ACCESS</h5></label>
                        <select class="form-select" name="access" id="">
                            <option value="1" selected>ACTIVE</option>
                            <option value="2">SUSPENDED</option>
                        </select>
                </div><br>
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
                                            <input type="hidden" class="form-control" name="uid" value="<?=$upid?>">
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


    <script src="../assets/js/pages/horizontal-layout.js"></script>

<!------------------------------SWEET ALERTS---------------------------------->
     <script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>

<!----------------------font awsome------------------------------------------------>
    <script src="../assets/vendors/fontawesome/all.min.js"></script>

<!------------- Include Choices select JavaScript ------------------------------------------------>
<script src="../assets/vendors/choices.js/choices.min.js"></script>
<script src="../assets/js/pages/form-element-select.js"></script>
<script src="../assets/js/usermanagement.js"></script>

   

</body>

</html>
