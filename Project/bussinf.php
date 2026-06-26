
<?php
include_once'./company/companyClass.php';
include_once'./department/departmentClass.php';
include_once'./users/usersClass.php';
include_once'./settings/impactClass.php';
include_once'./settings/likelihoodClass.php';
include_once'./settings/controltypeClass.php';
include_once'./process/processClass.php';

$processclass= new processClass();
$showprocess= $processclass->showProcess();

$cstypeclass=new  controltypeClass();
$showctype= $cstypeclass->showcontroltype();

$likelyclass=new likelihoodClass();
$showlikely= $likelyclass->showlikely();

$impactclass=new impactClass();
$showimpact= $impactclass->showImpact();

$userClass=new usersClass();
$showusers=$userClass->fetchusers();

$departmentClass=new departmentClass();
$showdept=$departmentClass->showDept();

$companyClass=new companyClass();
$showcompany=$companyClass->showCompany();
$showgroup=$companyClass->showgroup();

$tab= $_GET["tab"] ?? "group";
?>
<!DOCTYPE html>
<html lang="en">
<!-_________________Header location______________________->
<?php include_once'../layout/header.php';?>
<style>
.btn-group-sm>.btn, .btn-sm {
    border-radius: 0.2rem;
    font-size: 0.75rem;
    padding: 0.2rem 0.4rem;
}
.btn-buss {
    width: 50px;
    height: 400px;
}
.btn-buss .bi {
    font-size: 25px;
}
.table-buss {
    border-collapse: collapse;
}
.table-buss th {
    font-size: 12px;
    font-weight: 700;
    color: #fff;
    background: #2c3e50;
    padding: 6px 8px;
    white-space: nowrap;
    text-align: center;
    vertical-align: middle;
    border: 1px solid rgba(255,255,255,0.3);
}
.table-buss td {
    font-size: 12px;
    font-weight: 500;
    color: #222;
    padding: 5px 8px;
    text-align: center;
    vertical-align: middle;
    white-space: nowrap;
    border: 1px solid #b8c8de;
}
.table-buss tbody tr:hover td {
    background: #eef4ff;
}
.nav-link {
    border: 1px solid #1b6ae1 !important;
    display: block;
    color: #000;
    padding: 8px 16px;
    text-decoration: none;
    border-radius: 0px !important;
}
.col-2,.col-9,.nav-col {
    padding: 0px;
    box-shadow: 5px 10px 18px #98b4e0;
}
.tab-pane {
    padding: 10px 10px 0px 10px;
}
label {
    margin-top: 10px;
}
</style>
<body>
    <div id="app">
        <div id="main" class="layout-horizontal">

 <!-_________________Navigation location______________________->

 <?php include_once'../layout/nav.php'; ?>

            <div class="content-wrapper container">
                
<div class="page-heading">
    <h4>Business Overview/ Business infrastructure</h4>
</div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
    <!-_________________Content location BEGINING______________________->

                <section class="section">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2 nav-col">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                    aria-orientation="vertical">
                                    <a class="nav-link <?php echo $tab =='group' ? 'active': ''?>" id="v-pills-home-tab" data-bs-toggle="pill"
                                        href="#group" role="tab" onclick="changeTab('group')" aria-controls="v-pills-group"
                                        aria-selected="true"><i class="fas fa-fw fa-layer-group"></i> <span>Groups</span>  </a>

                                    <a class="nav-link <?php echo $tab =='company' ? 'active': ''?>" id="v-pills-profile-tab" data-bs-toggle="pill"
                                        href="#company" role="tab" onclick="changeTab('company')" aria-controls="v-pills-Company"
                                        aria-selected="false"><i class="fas fa-fw fa-building"></i> <span>Company</span></a>

                                    <a class="nav-link <?php echo $tab =='entity' ? 'active': ''?>" id="v-pills-messages-tab" data-bs-toggle="pill"
                                        href="#entity" role="tab" onclick="changeTab('entity')" aria-controls="v-pills-messages"
                                        aria-selected="false"><i class="fas fa-fw fa-sitemap"></i> <span>Entity/Dept.</span></a>

                                    <a class="nav-link <?php echo $tab =='process' ? 'active': ''?>" id="v-pills-settings-tab" data-bs-toggle="pill"
                                        href="#process" role="tab" onclick="changeTab('process')" aria-controls="v-pills-settings"
                                        aria-selected="false"><i class="fas fa-fw fa-cogs"></i> <span>Process</span></a>

                                    <a class="nav-link  <?php echo $tab =='risk_category' ? 'active': ''?>" id="v-pills-rcat-tab" data-bs-toggle="pill"
                                        href="#rcat" role="tab" onclick="changeTab('risk_category')" aria-controls="v-pills-settings"
                                        aria-selected="false"><span class="fa fa-cogs"></span>  <span>Risk Category</span></a>

                                    <!--<a class="nav-link" id="v-pills-users-tab" data-bs-toggle="pill"
                                        href="#users" role="tab" aria-controls="v-pills-settings"
                                        aria-selected="false"><span class="fa-fw select-all fas">ï”€</span>  <span>Users</span></a>-->

                                    <a class="nav-link <?php echo $tab =='impact' ? 'active': ''?>" id="v-pills-impact-tab" data-bs-toggle="pill"
                                        href="#impact" role="tab" onclick="changeTab('impact')" aria-controls="v-pills-settings"
                                        aria-selected="false"><span class="fa fa-asterisk"></span>  <span>Impact levels</span></a>

                                    <a class="nav-link <?php echo $tab =='likelihood' ? 'active': ''?>" id="v-pills-likely-tab" data-bs-toggle="pill"
                                        href="#likely" role="tab" onclick="changeTab('likelihood')" aria-controls="v-pills-settings"
                                        aria-selected="false"><span class="fa fa-battery-half"></span>  <span>Likelihood Level</span></a>

                                    <a class="nav-link <?php echo $tab =='control_type' ? 'active': ''?>" id="v-pills-ctype-tab" data-bs-toggle="pill"
                                        href="#ctype" role="tab" onclick="changeTab('control_type')" aria-controls="v-pills-settings"
                                        aria-selected="false"><span class="fa fa-certificate"></span>  <span>Control Type</span></a>

                                    <a class="nav-link <?php echo $tab =='control_strength' ? 'active': ''?>" id="v-pills-cstrength-tab" data-bs-toggle="pill"
                                        href="#cstrength" role="tab" onclick="changeTab('control_strength')" aria-controls="v-pills-settings"
                                        aria-selected="false"><span class="fa fa-cubes"></span>  <span>Control Strength</span></a>
                                    
                                </div>
                            </div>
                            <div class="col-10">
                                <div class="tab-content" id="v-pills-tabContent">

                                    <div class="tab-pane fade show active" id="group" role="tabpanel"
                                        aria-labelledby="v-pills-group-tab">
                                            <div class="row">
                                                <div class="col-11">
                                                <div class="table-responsive">
                                                <table class="table table-bordered table-buss" id="table1">
                                                    <thead>
                                                        <tr>
                                                            <th>Reference</th>
                                                            <th>Name</th>
                                                            <th>Website</th>
                                                            <th>Country</th>
                                                            <th>Objectives</th>
                                                            <th>Logo</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            foreach($showgroup as $group){
                                                                $image="<img src='".$group['logo']."' alt='' width='20px' height='20px'>";
                                                            echo'
                                                                <tr>
                                                                    <td>G00'.$group["id"].'</td>
                                                                    <td>'.$group["name"].'</td>
                                                                    <td>'.$group["website"].'</td>
                                                                    <td>'.$group["country"].'</td>
                                                                    <td>'.$group["objectives"].'</td>
                                                                    <td>'.$image.'</td>
                                                                    <td>
                                                                    <button name="edit" class="btn btn-sm btn-primary btn-userpermission-edit" id="'.$group["id"].'"><i class="fas fa-fw fa-pen"></i></button>
                                                                    <button name="delete"  class="btn btn-sm btn-danger btn-userpermission-delete" ><i class="fas fa-fw fa-trash"></i></button>
                                                                    </td>
                                                                </tr>';
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                </div><!-- end table-responsive -->
                                                </div>
                                                <div class="col-1">
                                                    <button class="btn btn-outline-primary btn-userpermission-add" data-bs-toggle="modal"
                                                    data-bs-target="#group-modal">
                                                     <i class="fa fa-plus"></i>Add
                                                    </button>
                                                </div>
                                            </div>
                                    </div>

                                    <div class="tab-pane fade" id="company" role="tabpanel"
                                        aria-labelledby="v-pills-company-tab">
                                        <div class="row">
                                            <div class="col-11">
                                                <div class="table-responsive">
                                                <table class="table table-bordered table-buss" id="table1">
                                                    <thead>
                                                        <tr>
                                                            <th>Reference</th>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Telephone</th>
                                                            <th>Address</th>
                                                            <th>Logo</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            foreach($showcompany as $company){
                                                                $image="<img src='".$company['logo']."' alt='' width='20px' height='20px'>";
                                                            echo'
                                                                <tr>
                                                                    <td>C00'.$company["id"].'</td>
                                                                    <td>'.$company["company_name"].'</td>
                                                                    <td>'.$company["email"].'</td>
                                                                    <td>'.$company["phone"].'</td>
                                                                    <td>'.$company["address"].'</td>
                                                                    <td>'.$image.'</td>
                                                                    <td>
                                                                    <button name="edit" class="btn btn-sm btn-primary editcompany btn-userpermission-edit" id="'.$company["id"].'"><i class="fas fa-fw fa-pen"></i></button>
                                                                    <button name="delete"  class="btn btn-sm btn-danger deletecompany btn-userpermission-delete" ><i class="fas fa-fw fa-trash"></i></button>
                                                                    </td>
                                                                </tr>';
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                </div><!-- table-responsive -->
                                            </div>
                                            <div class="col-1">
                                                <a href="companylist.php" class="btn btn-outline-primary btn-userpermission-add addcompany"  >
                                                    <i class="fa fa-plus"></i>Add
                                                        </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="entity" role="tabpanel"
                                        aria-labelledby="v-pills-entity-tab">
                                        <!--------------------------start of entity------------------------------------------->
                                        <div class="row">
                                            <div class="col-11">
                                                <div class="table-responsive">
                                                <table class="table table-striped table-buss" id="table2">
                                                    <thead>
                                                        <tr>
                                                            <th>Reference</th>
                                                            <th>Company</th>
                                                            <th>Entity Name</th>
                                                            <th>Entity Owner</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                            foreach($showdept as $dept){ 
                                                                $uid=$dept["owners"];
                                                                $username=$userclass->userjoin($uid);

                                                                $cid=$dept["company"];
                                                                $companyname=$companyClass->companyJoins($cid);

                                                                        echo'  <tr>
                                                                    <td>ENT00'.$dept["dept_id"].'</td>
                                                                    <td>'.$companyname.'</td>
                                                                    <td>'.$dept["dept_name"].'</td>
                                                                    <td>'.$username.'</td>
                                                                    <td>
                                                                    <button class="btn btn-sm btn-primary editentity btn-userpermission-edit" id='.$dept["dept_id"].'><i class="fas fa-fw fa-pen"></i></button>
                                                                    <button class="btn btn-sm btn-danger delete-dept btn-userpermission-delete" id='.$dept["dept_id"].'><i class="fas fa-fw fa-trash"></i></button>
                                                                    </td>
                                                                </tr>';
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                </div><!-- table-responsive -->
                                            </div>
                                            <div class="col-1">
                                                <button class="btn btn-outline-primary btn-userpermission-add addentitybtn"  data-bs-toggle="modal"  
                                                >
                                                    <i class="fa fa-plus"></i>Add
                                                </button>
                                            </div>
                                        </div>
                                        
                                        
                                    <!--------------------------End of entity------------------------------------------->
                                    </div>
                                    <div class="tab-pane fade" id="process" role="tabpanel"
                                        aria-labelledby="v-pills-sub-tab">
                                        <div class="row">
                                                <div class="col-11">
                                                    <div class="table-responsive">
                                                    <table class="table table-striped table-buss" id="table3">
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
                                                                    <button name="edit" class="btn btn-sm btn-primary editprocess btn-userpermission-edit" id='.$process["process_id"].'><i class="fas fa-fw fa-pen"></i></button>
                                                                    <button name="delete"  class="btn btn-sm btn-danger processdelete btn-userpermission-delete" id='.$process["process_id"].'><i class="fas fa-fw fa-trash"></i></button>
                                                                    </td>
                                                                </tr>';
                                                            }
                                                        }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                    </div><!-- table-responsive -->
                                                </div>
                                                <div class="col-1">
                                                    <button class="btn btn-outline-primary btn-userpermission-add addprocessmodal"  data-bs-toggle="modal"  
                                                    data-bs-target="#">
                                                        <i class="fa fa-plus"></i>Add
                                                    </button>
                                                </div>
                                            </div>
                                            
                                    </div>
                                    <div class="tab-pane fade" id="users" role="tabpanel"
                                        aria-labelledby="v-pills-users-tab">
                                        <!--------------begining of user part---------------------------->
                                            <div class="row">
                                                <div class="col-11">
                                                    <div class="table-responsive">
                                                    <table class="table table-striped table-buss" id="table1">
                                                    <thead>
                                                        <tr>
                                                            <th>Userid</th>
                                                            <th>Name</th>
                                                            <th>Gender</th>
                                                            <th>Department</th>
                                                            <th>Username</th>
                                                            <th>Phone</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>                                                                                 
                                                <?php foreach($showusers as $users){
                                                        $deptid=$users["dept_id"];
                                                        $deptname=$departmentClass->deptJoins($deptid);
                                                        
                                                    ?>
                                                        <tr>
                                                        <tr>
                                                        <td>UID00<?=$users["id"]?></td>
                                                        <td><?= $users["fname"]?>&nbsp;<?=$users["sname"]?></td>
                                                        <td><?=$users["gender"]?></td>
                                                        <td><?=$deptname?></td>
                                                        <td><?=$users["username"]?></td>
                                                        <td>0<?=$users["phone"]?></td>
                                                        <td>
                                                            <a href=”userslist”>
                                                                <dt class=”the-icon”><i class=”fas fa-fw fa-eye”></i></dt>
                                                            </a>
                                                            
                                                         </td>
                                                        </tr>
                                                <?php } ?>
                                                    </tbody>
                                                    </table>
                                                    </div><!-- table-responsive -->
                                                </div>
                                                <div class="col-1">
                                                    <button class="btn btn-outline-primary btn-userpermission-add addusermodal"  data-bs-toggle="modal"  
                                                    >
                                                        <i class="fa fa-plus"></i>Add
                                                    </button>
                                                </div>
                                            </div>
                                    <!--------------end of user part---------------------------->
                                    </div>
                                    <div class="tab-pane fade" id="impact" role="tabpanel"
                                        aria-labelledby="v-pills-users-tab">
                                        <!--------------begining of Impact levels part---------------------------->
                                            <div class="row">
                                                <div class="col-11">
                                                    <div class="table-responsive">
                                                    <table class="table table-striped table-buss" id="table1">
                                                        <thead>
                                                            <tr>
                                                                <th>Code</th>
                                                                <th>Impact name</th>
                                                                <th>Impact level</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                            <?php
                                                                foreach($showimpact as $impact){
                                                                    $iname=ucfirst($impact["name"]);
                                                                echo'<tr>
                                                                    <td>'.$i++.'</td>
                                                                    <td>'.$iname.'</td>
                                                                    <td>'.$impact["level"].'</td>
                                                                    <td>
                                                                    <button class="btn btn-sm btn-primary editimpact btn-userpermission-edit" id='.$impact["id"].'><i class="fas fa-fw fa-pen"></i></button>
                                                                    <button class="btn btn-sm btn-danger deleteimpact btn-userpermission-delete" id='.$impact["id"].'><i class="fas fa-fw fa-trash"></i></button>
                                                                    </td>
                                                                </tr>';
                                                                }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                    </div><!-- table-responsive -->
                                                </div>
                                                <div class="col-1">
                                                    <button class="btn btn-outline-primary btn-userpermission-add addimpactmodal"  data-bs-toggle="modal"  
                                                    data-bs-target="#group">
                                                        <i class="fa fa-plus"></i>Add
                                                    </button>
                                                </div>
                                            </div>
                                    <!--------------end of Impact levels part---------------------------->
                                    </div>
                                    <div class="tab-pane fade" id="likely" role="tabpanel"
                                        aria-labelledby="v-pills-users-tab">
                                        <!--------------begining of Likelihood part---------------------------->
                                            <div class="row">
                                                <div class="col-11">
                                                    <div class="table-responsive">
                                                    <table class="table table-striped table-buss" id="table1">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Likelihood name</th>
                                                                <th>Likelihood level</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                                <tr>
                                                                <?php
                                                                $il=1;
                                                                foreach($showlikely as $likely){
                                                                    $lname=ucfirst($likely["name"]);
                                                                echo'<tr>
                                                                    <td>'.$il++ .'</td>
                                                                    <td>'.$lname.'</td>
                                                                    <td>'.$likely["level"].'</td>
                                                                    <td>
                                                                    <button class="editlikelihood btn btn-sm btn-primary btn-userpermission-edit" id='.$likely["id"].'><i class="fas fa-fw fa-pen"></i></button>
                                                                    <button class="btn btn-sm btn-danger deletelikely btn-userpermission-delete" id='.$likely["id"].'><i class="fas fa-fw fa-trash"></i></button>
                                                                    </td>
                                                                </tr>';
                                                                }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                    </div><!-- table-responsive -->
                                                </div>
                                                <div class="col-1">
                                                    <button class="btn btn-outline-primary btn-userpermission-add addlikely"  data-bs-toggle="modal"  
                                                    data-bs-target="#group">
                                                        <i class="fa fa-plus"></i>Add
                                                    </button>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="tab-pane fade" id="rcat" role="tabpanel"
                                        aria-labelledby="v-pills-users-tab">
                                        <!--------------begining of Risk Category part---------------------------->
                                            <div class="row">
                                                <div class="col-11">
                                                    <div class="table-responsive">
                                                    <table class="table table-striped table-buss" id="table1">
                                                        <thead>
                                                            <tr>
                                                                <th>Number</th>
                                                                <th>Risk Category</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php 
                                                        foreach($showRiskCat as $values){  
                                                        echo '<tr>
                                                                <td>'.$values["riskcat_id"].'</td>
                                                                <td>'.$values["name"].'</td>
                                                                <td>
                                                                <button class="btn btn-sm btn-primary editriskcat btn-userpermission-edit" id='.$values["riskcat_id"].'><i class="fas fa-fw fa-pen"></i></button>
                                                                <button class="btn btn-sm btn-danger deleteriskcat btn-userpermission-delete" id='.$values["riskcat_id"].'><i class="fas fa-fw fa-trash"></i></button>
                                                                    </td>
                                                            </tr>';
                                                            }
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                    </div><!-- table-responsive -->
                                                </div>
                                                <div class="col-1">
                                                    <button class="btn btn-outline-primary btn-userpermission-add addriskcat"  data-bs-toggle="modal"  
                                                    data-bs-target="#group">
                                                        <i class="fa fa-plus"></i>Add
                                                    </button>
                                                </div>

                                                <!--------------end of Risk Category part---------------------------->
                                            </div>
                                            
                                               
                                    </div>
                                    <div class="tab-pane fade" id="cstrength" role="tabpanel"
                                        aria-labelledby="v-pills-users-tab">
                                        <!--------------begining of Control Strength part---------------------------->
                                            <div class="row">
                                                <div class="col-11">
                                                    <div class="table-responsive">
                                                    <table class="table table-striped table-buss">
                                                        <thead>
                                                            <tr>
                                                                <th>Code</th>
                                                                <th>Control Strength Name</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                            foreach($showcstrength as $cs){
                                                            echo' 
                                                            <tr>
                                                                    <td>'.$cs["strength_id"].'</td>
                                                                    <td>'.$cs["cs_name"].'</td>
                                                                    <td>
                                                                    <button class="btn btn-sm btn-primary editcs btn-userpermission-edit" id='.$cs["strength_id"].'><i class="fas fa-fw fa-pen"></i></button>
                                                                    <button class="btn btn-sm btn-danger deletecs btn-userpermission-delete" id='.$cs["strength_id"].'><i class="fas fa-fw fa-trash"></i></button>
                                                                    </td>
                                                                </tr>';
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                    </div><!-- table-responsive -->
                                                </div>
                                                <div class="col-1">
                                                    <button class="btn btn-outline-primary btn-userpermission-add addcs"  data-bs-toggle="modal"  
                                                    data-bs-target="#group">
                                                        <i class="fa fa-plus"></i>Add
                                                    </button>
                                                </div>
                                                 
                                            </div>
                                    </div>
                                    <div class="tab-pane fade" id="ctype" role="tabpanel"
                                        aria-labelledby="v-pills-users-tab">
                                        <!--------------begining of Control type part---------------------------->
                                            <div class="row">
                                                <div class="col-11">
                                                    <div class="table-responsive">
                                                    <table class="table table-striped table-buss" id="table1">
                                                        <thead>
                                                            <tr>
                                                                <th>Code</th>
                                                                <th>Control Type Name</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                             $ict=1;
                                                            foreach($showctype as $ct){
                                                            echo' 
                                                            <tr>
                                                                    <td>'.$ict++.'</td>
                                                                    <td>'.$ct["ct_name"].'</td>
                                                                    <td>
                                                                    <button class="btn btn-sm btn-primary editct btn-userpermission-edit" id='.$ct["ctype_id"].'><i class="fas fa-fw fa-pen"></i></button>
                                                                    <button class="btn btn-sm btn-danger deletect btn-userpermission-delete" id='.$ct["ctype_id"].'><i class="fas fa-fw fa-trash"></i></button>
                                                                    </td>
                                                                </tr>';
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                    </div><!-- table-responsive -->
                                                </div>
                                                <div class="col-1">
                                                    <button class="btn btn-outline-primary btn-userpermission-add addct"  data-bs-toggle="modal"  
                                                    data-bs-target="#group">
                                                        <i class="fa fa-plus"></i>Add
                                                    </button>
                                                </div>
                                                </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    
                </section>


    <!-_________________Content location END______________________->
                
            </div>
        </section>
    </div>

  </div>


<!----=========================================================
MODAL FOR WHOLE INFRUSTRUCTURE
=========================================================-->

<!--=======================Add Group Objectives==========================================-->
<div class="modal fade text-left" id="group-modal" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel130" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" 
		role="document">
		
			<div class="modal-content">
				<div class="modal-header bg-info">
					<h5 class="modal-title white" id="myModalLabel130">ADD GROUP FORM
					</h5>
					<button type="button" class="close" data-bs-dismiss="modal"
						aria-label="Close">
						<i data-feather="x"></i>
					</button>
				</div>
				<div class="modal-body">
				<form class="form" method="POST" action="group.php" enctype="multipart/form-data">
					<div class="row">
						<div class="col-md-6">
							<div class="col-12">
								<div class="form-group">
									<label for="">Group Name</label>
									<input type="text" id="groupname" name="groupname" class="form-control"
										name="fname" placeholder="Group Name">
								</div>
							</div>
							<div class="col-12">
								<div class="form-group">
									<label for="">Address</label>
									<input type="text" id="address" class="form-control"
										name="address" placeholder="Address">
								</div>
							</div>
							<div class="col-12">
								<div class="form-group">
									<label for="">Logo</label>
									<div class="input-group">
										<input type="file" class="form-control" name="file" id="inputGroupFile04"
											aria-describedby="inputGroupFileAddon04" aria-label="Upload">
										
									</div>
								</div>
							</div>
                            <div class="col-12">
                                <div class="form-group">
									<label for="">Website</label>
									<input type="text" id="website" class="form-control"
										name="website" placeholder="Address">
								</div>
							</div>
							<div class="col-12">
								<div class="form-group">
									<label for="">Country</label>
									<fieldset class="form-group">
										<select class="form-select" name="country" id="basicSelect">
											<option>Select Country</option>
											<option value="kenya">Kenya</option>
											<option value="Uganda">Uganda</option>
                                            <option value="Tanzania">Tanzania</option>
										</select>
									</fieldset>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="col-12">
								<label for="group">GROUP OBJECTIVES</label>
								<div class="form-group with-title mb-3">
									<textarea class="form-control" name="objectives"  rows="10"></textarea>
									<label>Group Objectives</label>
								</div>
							</div>
						</div>
					  
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light-secondary"
						data-bs-dismiss="modal">
						<i class="bx bx-x d-block d-sm-none"></i>
						<span class="d-none d-sm-block">Close</span>
					</button>
					<input type="submit" class="btn btn-primary" value="submit">
				</div>
			</div>
		</form>
	</div>
</div>

<!--=======================-ADD Company Modals=========================================-->
<div class="modal fade text-left" id="addcompany-modal" tabindex="-1" role="dialog" 
    aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel17">ADD Company</h3>
                <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>        
            <form id="companyform" action="companyaction.php" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <label>Company name:</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="text" class="form-control" name="name"
                            placeholder="First name">
                    </div>
                    <div class="col-md-4">
                        <label>Group name:</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <select class="form-select" name="group" >
                            <option value="0" selected>Non-Group</option>
                            <?php
                            foreach($showgroup as $group){?>
                            <option value="<?=$group['id']?>"><?=$group['name']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    
                    <div class="col-md-4">
                        <label>Email:</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="email"  class="form-control" name="email"
                            placeholder="email">
                    </div>                                    
                    <div class="col-md-4">
                        <label>Telephone:</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="text"  class="form-control" name="phone"
                            placeholder="Telephone">
                    </div>
                    <div class="col-md-4">
                        <label>Website:</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="text"  class="form-control"  name="website"
                            placeholder="website">
                    </div>
                    <div class="col-md-4">
                        <label>Address:</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <textarea class="form-control" name="address"  cols="" rows="2" placeholder="e.g P.O.BOX "></textarea>
                    </div>
                    
                    <div class="col-md-4">
                        <label>Upload Logo:</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="file" name="file" class="form-contol">
                    </div>
                </div><!--end of row--->

            </div>
            <div class="modal-footer">
            <!--<div class="col-12 alert alert-danger" id="messagedisplaycontrol" style="text-align:center;font-size:25px;font-weight:600;"></div>-->
                <div class="col-md-5">
                    <input type="submit" class="btn btn-lg btn-primary" value="Add Company">
                    
                </div>
                <div class="col-md-5">
                    <a href="bussinf.php" class="btn btn-lg btn-danger">CLOSE</a>
                </div>

            </div>
            </form>
        </div>
    </div>
</div>
          <!-----------------------------------entity UPDATE Modals--------------------------------------------------------------->
<div class="modal fade text-left" id="editcompany-modal" tabindex="-1" role="dialog" 
    aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel17">Edit Company</h3>
                <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>        
            <form class="form form-horizontal" id="companyupdateform">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <label>Company name:</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="hidden" class="form-control" name="companyid" id="companyid"
                            placeholder="First name">
                        <input type="text" class="form-control" name="cname" id="cuname"
                            placeholder="First name">
                    </div>
                    <div class="col-md-4">
                        <label>Group name:</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <select class="form-select" name="group" id="cugroup">
                            <option value="0" selected>Non-Group</option>
                            <?php
                            foreach($showgroup as $group){?>
                            <option value="<?=$group['id']?>"><?=$group['name']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Email:</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="email"  class="form-control" name="email" id="cuemail"
                            placeholder="email">
                    </div>                                    
                    <div class="col-md-4">
                        <label>Telephone:</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="text"  class="form-control"  name="phone" id="cuphone"
                            placeholder="Telephone">
                    </div>
                    <div class="col-md-4">
                        <label>Website:</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="text"  class="form-control"  name="website" id="cuwebsite"
                            placeholder="website">
                    </div>
                    <div class="col-md-4">
                        <label>Address:</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <textarea class="form-control" name="address" id="cuaddress" cols="" rows="5" placeholder="e.g P.O.BOX "></textarea>
                    </div>
                </div><!--end of row--->

            </div>
            <div class="modal-footer">
            <!--<div class="col-12 alert alert-danger" id="messagedisplay" style="text-align:center;font-size:25px;font-weight:600;"></div>-->
                    <button type="button" class="btn btn-light-secondary"
                        data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="" class="btn btn-primary updatecompanybtn">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">UPDATE</span>
                    </button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-----------------------------------DELETE  ENTITY ---------------------------------------------------------------->
<div class="modal fade text-left" id="deptdelete-modal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel120" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
            role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title white" id="myModalLabel120">Delete Entity
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form id="entitydeleteform">
                <div class="modal-body">
                <div>
                    <input type="hidden" name="" id="" value="">
                    <h3>Are you Sure you want to delete?</h3>
                    <div id="messagedelete"></div>
                <div style="color:#000;font-weight:600;font-size:29px;text-align:center;">Entity Name:<div id="entname">dfsdfsdfd</div></div>
                </div>
                </div>
                <div class="modal-footer">
                    
                    <button type="button" class="btn btn-light-secondary"
                        data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="button" class="delete-btn btn btn-danger ml-1 "
                        data-bs-dismiss="modal">
                        <i class="bx bx-check d-block d-sm-none "></i>
                        <span class="d-none d-sm-block">DELETE</span>
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!------------------------------------------------------------------------------------------------------------------------>
  



<!--=======================-ADD Entity Modals=========================================-->
<div class="modal fade text-left" id="addentity-modal" tabindex="-1" role="dialog" 
    aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel17">ADD Entity</h3>
                <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>        
            <form id="entityform">
            <div class="modal-body">
                <div id="message"></div>
                <div class="row">  
                    <div class="col-md-4">
                        <label>Entitys Name:</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="hidden" name="entityuid" id="entityuid" value="<?=$suid?>">
                        <input type="hidden" name="entityip" id="entityip" value="<?php $ip=getuseripaddress(); echo $ip; ?>">
                        <input type="text"  class="form-control" name="name" id="entityname"
                            placeholder="Entity name">
                            <span class="error" id="entity_err"> </span>
                    </div> 
                    <div class="col-md-4">
                        <label>Select Company:</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <select class="form-control" name="company" id="entcomp">
                            <option value="" selected>--------------Selected Company----------</option>
                            <?php
                            foreach($showcompany as $company){
                            echo'<option value='.$company["id"].'>'.$company["company_name"].'</option>';
                            }
                            ?>
                        </select>
                        <span class="error" id="company_err"> </span>
                    </div>                                   
                    
                    <div class="col-md-4">
                        <label>Owner:</label>
                    </div>
                    <div class="col-md-8 form-group">
                    <select class="form-control" name="owner" id="entowner">
                        <option value="" selected>---------Choose Owner------</option>
                            <?php
                            foreach($showusers as $user){
                            echo'<option value='.$user["id"].' >'.$user["fname"].'&nbsp;'.$user["sname"].'</option>';
                            }
                            ?>
                        </select>
                        <span class="error" id="owner_err"> </span>
                    </div>
                    <div class="col-md-4">
                        <label>Entity Functions:</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <textarea class="form-control" name="function"  cols="" rows="5" placeholder=""></textarea>
                    </div>
                </div><!--end of row--->

            </div>
            <div class="modal-footer">
            <!--<div class="col-12 alert alert-danger" id="messagedisplaycontrol" style="text-align:center;font-size:25px;font-weight:600;"></div>-->
                <button type="button" class="btn btn-danger"
                    data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
                <button class="btn btn-primary addentity">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">ADD Entity</span>
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
          <!-----------------------------------entity UPDATE Modals--------------------------------------------------------------->
<div class="modal fade text-left" id="editdept-modal" tabindex="-1" role="dialog" 
    aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel17">Edit Entity</h3>
                <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>        
            <form class="form form-horizontal" id="deptupdate">
            <div class="modal-body">
            <div class="row">
                        <div class="col-md-3">
                            <label>Entity Name:</label>
                        </div>
                        <div class="col-md-9 form-group">
                        <input type="hidden"  class="form-control" name="eid" id="eid"
                                placeholder="Entity name">
                        <input type="hidden" name="entityuid" id="" value="<?=$suid?>">
                        <input type="hidden" name="entityip" id="" value="<?php $ip=getuseripaddress(); echo $ip; ?>">
                            <input type="text"  class="form-control" name="ename" id="ename"
                                placeholder="Entity name">
                        </div> 
                        <div class="col-md-3">
                            <label>Select Company:</label>
                        </div>
                        <div class="col-md-9 form-group">
                            <select class="form-control" name="company" id="company">
                                <?php
                                foreach($showcompany as $company){
                                echo'<option value='.$company["id"].'>'.$company["company_name"].'</option>';
                                }
                                ?>
                            </select>
                        </div>                                   
                        
                        <div class="col-md-3">
                            <label>Owner:</label>
                        </div>
                        <div class="col-md-9 form-group">
                        <select class="form-control" name="owner" id="owner">
                            <option value="" selected>---------Choose Owner------</option>
                                <?php
                                foreach($showusers as $user){
                                echo'<option value='.$user["id"].' >'.$user["fname"].'&nbsp;'.$user["sname"].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Entity Functions:</label>
                        </div>
                        <div class="col-md-9 form-group">
                            <textarea class="form-control" name="function" id="function" cols="" rows="5" placeholder=""></textarea>
                        </div>
                            
                        
                    </div><!--end of row--->

            </div>
            <div class="modal-footer">
            <!--<div class="col-12 alert alert-danger" id="messagedisplay" style="text-align:center;font-size:25px;font-weight:600;"></div>-->
                <button type="button" class="btn btn-danger"
                    data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
                <button type="" name="update" class="deptupdate btn btn-primary">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">UPDATE</span>
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-----------------------------------DELETE  ENTITY ---------------------------------------------------------------->
<div class="modal fade text-left" id="deptdelete-modal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel120" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
            role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title white" id="myModalLabel120">Delete Entity
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form id="">
                <div class="modal-body">
                <div>
                    <input type="hidden" name="entityid" id="entityid" value="">
                    <h3>Are you Sure you want to delete?</h3>
                    <div id="messagedelete"></div>
                <div style="color:#000;font-weight:600;font-size:29px;text-align:center;">Entity Name:<div id="entname">dfsdfsdfd</div></div>
                </div>
                </div>
                <div class="modal-footer">
                    
                    <button type="button" class="btn btn-light-secondary"
                        data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="button" class="delete-btn btn btn-danger ml-1 "
                        data-bs-dismiss="modal">
                        <i class="bx bx-check d-block d-sm-none "></i>
                        <span class="d-none d-sm-block">DELETE</span>
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!------------------------------------------------------------------------------------------------------------------------>
  
<!-----------------------------------entity EDIT Modals--------------------------------------------------------------->
    
<!--=======================-ADD Users Modals=========================================-->
<div class="modal fade text-left" id="users-modal" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel1">Users Modal</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form id="usersform">
                <div class="modal-body">
                    <div class="row form-group">
                        <div class="col-md-7 row">
                            <div class="col-sm-6">
                                <label class="labels">Name</label>
                                <input type="text" class="form-control" name="fname" value="">
                            </div>
                            <div class="col-6">
                                <label class="labels">Second name</label>
                                <input type="text" class="form-control" name="sname" value="" >
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Username</label>
                                <input type="text" class="form-control" name="uname" value="">
                            </div>

                            <div class="col-md-12">
                                <label class="labels">Mobile Number</label>
                                <input type="text" class="form-control" name="phone" value="">
                            </div>

                            <div class="col-md-12">
                                <label class="labels">Gender</label>
                                <select class="form-select" name="gender" >
                                    <option value="male" selected>Male</option>
                                    <option value="female">Female</option>';
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="labels">Email ID</label>
                                <input type="text" class="form-control" name="email" value="">
                            </div>
                        </div>
                        <div class="col-md-5 row">
                            <div class="col-md-12">
                                <label class="labels"><h5>Choose User Roles</h5></label>
                                <select class="form-select" name="roles" >
                                    <option value="" selected>Select User Roles</option>
                                    <option value="1" >Risk Owner</option>
                                    <option value="2">Risk Champion</option>';
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="labels"><h5>Choose Department</h5></label>
                                <select class="form-select" name="dept" >
                                    <option value="">Select Department</option>
                                    <?php
                                    foreach($showdept as $dept){
                                        $selected=($profile["dept_id"]==$dept["dept_id"]) ? "selected" : "";
                                        echo'<option '.$selected.' value='.$dept["dept_id"].'>'.$dept["dept_name"].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="labels"><h5 style="color: red;">ENTER PASSWORD</h5></label>
                                <input type="Password" class="form-control" name="password" value="">
                                <label class="labels"><h5 style="color: red;">Re-ENTER PASSWORD</h5></label>
                                <input type="Password" class="form-control" name="" value="">
                            </div>

                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button class="btn btn-primary addusers-button">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">ADD Users</span>
                    </button>
                </div>
                </form>
            </div>
    </div>
</div>

<!--=======================-ADD Impact Modals=========================================-->
<div class="modal fade text-left" id="addimpact-modal" tabindex="-1" role="dialog" 
    aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel17">ADD IMPACT</h3>
                <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>        
            <form id="addimpactform">
            <div class="modal-body">
            <div class="row">
            <div class="col-md-4">
                <label>Impact name:</label>
                </div>
                <div class="col-md-8 form-group">
                    <input type="text" class="form-control" name="impname" id="impname" placeholder="Impact name">
                </div>
                <div class="col-md-4">
                    <label>Level:</label>
                </div>
                <div class="col-md-8 form-group">
                    <input type="number" class="form-control" name="implevel" id="implevel"
                        placeholder="level">
                </div>  
                <div class="col-md-4">
                <label>Description:</label>
                </div>
                <div class="col-md-8 form-group">
                    <textarea class="form-control" name="impdesc"  cols="2" rows="5"></textarea>
                </div>    
            </div><!--end of row--->

            </div>
            <div class="modal-footer">
            <!--<div class="col-12 alert alert-danger" id="messagedisplaycontrol" style="text-align:center;font-size:25px;font-weight:600;"></div>-->
                <a href="bussinf.php" class="btn btn-danger"
                    data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </a>
                <button class="btn btn-primary addimpact-btn">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">ADD IMPACT</span>
                </button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-----------------------------------Edit impact Modals--------------------------------------------------------------->
<div class="modal fade text-left" id="editimpact" tabindex="-1" role="dialog" 
    aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel17">EDIT IMPACT</h3>
                <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>        
            <form id="impactupdateform">
            <div class="modal-body">
                <div class="row">
                <div class="col-md-4">
                <label>Impact name:</label>
                </div>
                <div class="col-md-8 form-group">
                    <input type="hidden" name="iid" id="iid">
                    <input type="text" class="form-control" name="name" id="name"
                        placeholder="Impact name">
                </div>
                <div class="col-md-4">
                    <label>Level:</label>
                </div>
                <div class="col-md-8 form-group">
                    <input type="number"  class="form-control" name="level" id="level"
                        placeholder="level">
                </div>  
                <div class="col-md-4">
                <label>Description:</label>
                </div>
                <div class="col-md-8 form-group">
                    <textarea class="form-control" name="impdesc" id="impactdesc" cols="2" rows="5"></textarea>
                </div>  
            </div><!--end of row--->

            </div>
            <div class="modal-footer">
            <!--<div class="col-12 alert alert-danger" id="messagedisplaycontrol" style="text-align:center;font-size:25px;font-weight:600;"></div>-->
                <button type="button" class="btn btn-danger"
                    data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
                <button name="addaction-btn" class="btn btn-primary updateimpact">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">EDIT IMPACT</span>
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-----------------------------------DELETE  Modal ---------------------------------------------------------------->
<div class="modal fade text-left" id="delete-modal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel120" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
            role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title white" id="myModalLabel120">Delete IMPACT
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form id="impdeleteform">
                <div class="modal-body">
                <div>
                    <input type="hidden" name="impdelete" id="impdelete" value="">
                    <h3>Are you Sure you want to delete?</h3>
                <div style="color:#000;font-weight:600;font-size:29px;text-align:center;">Impact Name:<h5 id="impdcname"></h5></div>
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
 <!--====================Process Modals==============================================-->
<!------------------------------------------------------------------------------>
<div class="modal fade text-left" id="addprocess-modal" tabindex="-1" role="dialog" 
    aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel17">ADD PROCESS</h3>
                <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>        
                <form id="processform">
                    <div class="modal-body">
                     <div id="processmessage"></div>
                            <div class="row">                            
                            <div class="col-md-8">
                                        <label>Entity:</label>
                                </div>    
                            <div class="col-md-12 form-group">
                                    <select class="form-control" name="dept" id="pentity">
                                        <option value="" selected>----SELECT Entity---</option>
                                        <?php
                                        foreach($showdept as $dept){
                                            echo'<option value='.$dept["dept_id"].'>'.$dept["dept_name"].'</option>';

                                            }
                                        ?>
                                    </select>
                                    <span class="error" id="pentity_err"> </span>
                                </div>
                                <div class="col-md-8">
                                    <label>Enter Process:</label>
                                </div>
                                <div class="col-md-12 form-group">
                                    <input type="text" class="form-control" name="name" id="processname"
                                        placeholder="Enter Process">
                                    <span class="error" id="process_err"> </span>
                                </div>
                                
                                <div class="col-md-8">
                                        <label>Enter details:</label>
                                </div>
                                <div class="col-md-12 form-group">
                                    <textarea class="form-control" name="detail"  rows="5"></textarea>
                                </div>
                            
                        </div><!--end of row--->

                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-danger"
                                    data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Close</span>
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button name="" class="btn btn-primary addprocess" id="myButton1">Add</button>
                            </div>
                            

                        </div><!-----end of footer row-->
                                
                    </div>
                </form>
        </div>
    </div>
</div>
<!-----------------------------------Edit process Modals--------------------------------------------------------------->
<div class="modal fade text-left" id="editprocess-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel17">EDIT PROCESS</h3>
                    <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>        
                <form id="formprocessupdate">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                        <label>Entity:</label>
                            </div>    
                            <div class="col-md-12 form-group">
                                <input type="hidden" name="pid" id="pid">
                                      
                                    <select class="form-control" name="entity" id="entityprocess">
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
                        <button type="button" class="btn btn-danger"
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
 <!-----------------------------------DELETE  Modal ---------------------------------------------------------------->
 <div class="modal fade text-left" id="deleteprocess-modal" tabindex="-1" role="dialog"
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
                <form id="deleteprocessform">
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
                    <button type="button" class="deleteprocess-btn btn btn-danger ml-1"
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
   

<!--====================Likelihood Modals==============================================-->
<!------------------------------------------------------------------------------>
<div class="modal fade text-left" id="addlikely-modal" tabindex="-1" role="dialog" 
    aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel17">ADD LIKELIHOOD</h3>
                <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>        
            <form id="addlikelyform">
            <div class="modal-body">
            <div class="row">
                <div class="col-md-4">
                <label>Likelihood name:</label>
                </div>
                <div class="col-md-8 form-group">
                    <input type="text" class="form-control" name="name" placeholder="First name">
                </div>
                <div class="col-md-4">
                    <label>Level:</label>
                </div>
                <div class="col-md-8 form-group">
                    <input type="number"  class="form-control" name="level"
                        placeholder="level">
                </div>    
                <div class="col-md-4">
                <label>Description:</label>
                </div>
                <div class="col-md-8 form-group">
                    <textarea class="form-control" name="ldesc"  cols="2" rows="5"></textarea>
                </div>        
            </div><!--end of row--->

            </div>
            <div class="modal-footer">
            <!--<div class="col-12 alert alert-danger" id="messagedisplaycontrol" style="text-align:center;font-size:25px;font-weight:600;"></div>-->
                <a href="bussinf.php" class="btn btn-danger">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </a>
                <button class="btn btn-primary addlikely-btn">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">ADD Likelihood</span>
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-----------------------------------Edit impact Modals--------------------------------------------------------------->
<div class="modal fade text-left" id="editlikelihood-modal" tabindex="-1" role="dialog" 
    aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel17">EDIT Likelihood</h3>
                <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>        
            <form id="likelyupdateform">
            <div class="modal-body">
            <div class="row">
            <div class="col-md-4">
                <label>Likelihood name:</label>
                </div>
                <div class="col-md-8 form-group">
                    <input type="hidden" name="lid" id="lid">
                    <input type="text" class="form-control" name="name" id="likelyname"
                        placeholder="Likelihood name">
                </div>
                <div class="col-md-4">
                    <label>Level:</label>
                </div>
                <div class="col-md-8 form-group">
                    <input type="number"  class="form-control" name="level" id="likelylevel"
                        placeholder="level">
                </div> 
                <div class="col-md-4">
                <label>Description:</label>
                </div>
                <div class="col-md-8 form-group">
                    <textarea class="form-control" name="ldesc" id="ldesc" cols="2" rows="5"></textarea>
                </div> 
            </div><!--end of row--->

            </div>
            <div class="modal-footer">
            <!--<div class="col-12 alert alert-danger" id="messagedisplaycontrol" style="text-align:center;font-size:25px;font-weight:600;"></div>-->
                <button type="button" class="btn btn-danger"
                    data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
                <button name="addaction-btn" class="btn btn-primary updatelikely">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">EDIT Likelihood</span>
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
 <!-----------------------------------DELETE  Modal ---------------------------------------------------------------->
 <div class="modal fade text-left" id="delete-modal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel120" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
            role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title white" id="myModalLabel120">Delete Likelihood
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form id="ldeleteform">
                <div class="modal-body">
                <div>
                    <input type="hidden" name="ldelete" id="ldelete" value="">
                    <h3>Are you Sure you want to delete?</h3>
                <div style="color:#000;font-weight:600;font-size:29px;text-align:center;">Likelihood Name:<h5 id="ldcname"></h5></div>
                </div>
                </div>
                <div class="modal-footer">
                    
                    <button type="button" class="btn btn-light-secondary"
                        data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="button" class="btn btn-danger ml-1 lklydelete-btn"
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


<!--====================================risk Category Modals=====================--->
<!------------------------------------------------------------------------------>
<div class="modal fade text-left" id="riskcat-modal" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel1">Add RISK CATEGORY</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form id="addriskcatform">  
            <div class="modal-body">
                <div class="col-md-8">
                    <label>Enter Risk Category:</label>
                </div>
                <div class="col-md-12 form-group">
                    <input type="text" class="form-control" name="riskcat" id="riskcat"
                        placeholder="Enter risk category">
                </div>
                <div class="col-md-12">
                    <label>Description:</label>
                    </div>
                <div class="col-md-12 form-group">
                    <textarea class="form-control" name="rcdesc"  cols="2" rows="5"></textarea>
                </div>
            </div>

            <div class="modal-footer form-group">
                <button type="button" class="btn btn-danger" 
                data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
                <button class="btn btn-primary addriskcat-btn">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">ADD RISK CATEGORY</span>
                </button>
            </div>
        </form>
        </div>
    </div>
</div>
<!-----------------------------------Edit impact Modals--------------------------------------------------------------->
<div class="modal fade text-left" id="editriskcat-modal" tabindex="-1" role="dialog"aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel17">EDIT RISK CATEGORY</h3>
                <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>        
            <form id="riskcatupdateform">
            <div class="modal-body">
            <div class="row">
                <div class="col-md-8">
                <label>Enter Risk Category:</label>
                </div>
                <div class="col-md-12 form-group">
                    <input type="hidden" name="rcid" id="rcid">
                    <input type="text" class="form-control" name="riskcatname" id="riskcatname"
                        placeholder="Enter risk category">
                </div>
                <div class="col-md-12">
                    <label>Description:</label>
                    </div>
                <div class="col-md-12 form-group">
                    <textarea class="form-control" name="rcedesc" id="rcedesc" cols="2" rows="5"></textarea>
                </div>
            </div><!--end of row--->

            </div>
            <div class="modal-footer">
            <!--<div class="col-12 alert alert-danger" id="messagedisplaycontrol" style="text-align:center;font-size:25px;font-weight:600;"></div>-->
                <button type="button" class="btn btn-danger"
                    data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
                <button name="addaction-btn" class="btn btn-primary updateriskcat">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">EDIT RISK CATEGORY</span>
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-----------------------------------DELETE  Modal ---------------------------------------------------------------->
<div class="modal fade text-left" id="delete-modal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel120" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
            role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title white" id="myModalLabel120">Delete RISK CATEGORY
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form id="rcdeleteform">
                    <div class="modal-body">
                    <div>
                        <input type="hidden" name="rcdelete" id="rcdelete" value="">
                        <h3>Are you Sure you want to delete?</h3>
                    <div style="color:#000;font-weight:600;font-size:29px;text-align:center;">Risk Category Name:<h5 id="dcname"></h5></div>
                    </div>

                </div>
                <div class="modal-footer">
                    
                    <button type="button" class="btn btn-light-secondary"
                        data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="button" class="delete-btn btn btn-danger ml-1 riskcatdelete-btn"
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

<!--=====================================control strength Modals=================================-->
<!------------------------------------------------------------------------------>
<div class="modal fade text-left" id="addcs-modal" tabindex="-1" role="dialog"aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel17">ADD Control STRENGTH</h3>
                <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>        
            <form id="addcsform">
            <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                <label>Control Strength:</label>
                </div>
                <div class="col-md-12 form-group">
                    <input type="text" class="form-control" name="name"
                        placeholder="Control strength name">
                </div>

                <div class="col-md-12">
                <label>Description:</label>
                </div>
                <div class="col-md-12 form-group">
                    <textarea class="form-control" name="desc"  cols="2" rows="5"></textarea>
                </div>
                
            </div><!--end of row--->

            </div>
            <div class="modal-footer">
            <!--<div class="col-12 alert alert-danger" id="messagedisplaycontrol" style="text-align:center;font-size:25px;font-weight:600;"></div>-->
                <a href="bussinf.php" class="btn btn-danger">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </a>
                <button class="btn btn-primary addcs-btn">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">ADD Control Strength</span>
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
<!------------------------------------------------------------------------------>
<!-----------------------------------Edit impact Modals--------------------------------------------------------------->
<div class="modal fade text-left" id="editcs-modal" tabindex="-1" role="dialog"aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel17">EDIT Control STRENGTH</h3>
                <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>        
            <form id="editcsform">
            <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                <label>Control Strength:</label>
                </div>
                <div class="col-md-12 form-group">
                    <input type="hidden" name="csid" id="csid">
                    <input type="text" class="form-control" name="csname" id="csname"
                        placeholder="Control strength name">
                </div>
                <hr>
                
                <div class="col-md-12">
                <label>Description:</label>
                </div>
                <div class="col-md-12 form-group">
                    <textarea class="form-control" name="csdesc" id="csdesc" cols="2" rows="5"></textarea>
                </div>
            </div><!--end of row--->

            </div>
            <div class="modal-footer">
            <!--<div class="col-12 alert alert-danger" id="messagedisplaycontrol" style="text-align:center;font-size:25px;font-weight:600;"></div>-->
                <button type="button" class="btn btn-danger"
                    data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
                <button class="btn btn-primary updatecs">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Edit Control Strength</span>
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-----------------------------------DELETE  Modal ---------------------------------------------------------------->
<div class="modal fade text-left" id="csdelete-modal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel120" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
            role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title white" id="myModalLabel120">Delete Control Strength
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form id="csdeleteform">
                <div class="modal-body">
                <div>
                    <input type="hidden" name="csdelete" id="csdelete" value="">
                    <h3>Are you Sure you want to delete?</h3>
                <div style="color:#000;font-weight:600;font-size:29px;text-align:center;">Control Strength Name:<h5 id="dcname"></h5></div>
                </div>

                </div>
                <div class="modal-footer">
                    
                    <button type="button" class="btn btn-light-secondary"
                        data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="button" class="csdelete-btn btn btn-danger ml-1"
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

<!--===========================control Type Modal======================================-->
<div class="modal fade text-left" id="addct-modal" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel1">Add CONTROL TYPE</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form id="addctform">  
            <div class="modal-body">
                <div class="row">
                    
                        <div class="col-md-4">
                            <label>Control Type:</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" class="form-control" name="ctname" id="ctname"
                                placeholder="Control Type name">
                        </div>
                        <div class="col-md-4">
                        <label>Description:</label>
                        </div>
                        <div class="col-md-8 form-group">
                            <textarea class="form-control" name="ctdesc"  cols="2" rows="5"></textarea>
                        </div>
                    
                </div><!--end of row--->
            </div>
            <div class="modal-footer form-group">
                <a href="bussinf.php" type="button" class="btn btn-danger">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </a>
                <button class="btn btn-primary addct-btn">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">ADD CONTROL TYPE</span>
                </button>
            </div>
        </form>
        </div>
    </div>
</div>  
<!-----------------------------------Edit control type Modals--------------------------------------------------------------->
<div class="modal fade text-left" id="editctype-modal" tabindex="-1" role="dialog" 
    aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel17">EDIT CONTROL TYPE</h3>
                <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>        
            <form id="ctupdateform">
            <div class="modal-body">
                <div class="row">
                <div class="col-md-4">
                    <label>Control Type:</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="hidden" name="ctid" id="ctid">
                        <input type="text" class="form-control" name="ctypename" id="ctypename"
                            placeholder="Enter control type">
                    </div>
                    <div class="col-md-4">
                    <label>Description:</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <textarea class="form-control" name="ctedesc" id="ctedesc" cols="2" rows="5"></textarea>
                    </div>
                    
                </div><!--end of row--->

            </div>
            <div class="modal-footer">
            <!--<div class="col-12 alert alert-danger" id="messagedisplaycontrol" style="text-align:center;font-size:25px;font-weight:600;"></div>-->
                <a href="bussinf.php" type="button" class="btn btn-danger">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </a>
                <button name="addaction-btn" class="btn btn-primary updatect">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">EDIT Control Type</span>
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-----------------------------------DELETE control type   Modal ---------------------------------------------------------------->
<div class="modal fade text-left" id="ctdelete-modal" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel120" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
        role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title white" id="myModalLabel120">Delete ControlType
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form id="ctypedeleteform">
                <div class="modal-body">
                <div>
                    <input type="text" name="ctypedelete" id="ctdelete" value="">
                    <h3>Are you Sure you want to delete?</h3>
                <div style="color:#000;font-weight:600;font-size:29px;text-align:center;">Company Name:<h5 id="name"></h5></div>
                </div>

            </div>
            <div class="modal-footer">
                
                <a href="bussinf.php" type="button" class="btn btn-primary">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </a>
                <button type="button" class="delete-btn btn btn-danger ml-1 ctypedelete-btn"
                    data-bs-dismiss="modal">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">DELETE</span>
                </button>
            </div>
        </form>
        </div>
    </div>
</div>
<!------------------------------------------------------------------------------------------------------------------------>
<!--=================end of Control type part=======================================-->




<!----=========================================================
=======================================================
MODAL FOR WHOLE INFRUSTRUCTURE
=========================================================
=========================================================-->

 <!-_________________Footer location______________________->

        <?php include_once'../layout/footer.php'; ?>
        
        </div>
        
    </div>
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>

  <!----------------------Datatable Simple------------------------------------------------>
    <script src="../assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script>
        let table1 = document.querySelector('#table1');
        let table2 = document.querySelector('#table2');
        let table3 = document.querySelector('#table3');
        if (table1) new simpleDatatables.DataTable(table1);
        if (table2) new simpleDatatables.DataTable(table2);
        if (table3) new simpleDatatables.DataTable(table3);
    </script>

<!------------------------------SWEET ALERTS---------------------------------->
<script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>

<!----------------------Datatable Simple end------------------------------------------------>

    <script src="../assets/js/pages/horizontal-layout.js"></script>

<!----------------------font awsome------------------------------------------------>
    <script src="../assets/vendors/fontawesome/all.min.js"></script>

   
   <script>
    function changeTab(tab){
        const urlsearchParam = new URLSearchParams(window.location.search)
        urlsearchParam.set("tab", tab)
        const newPath = window.location.pathname + "?" + urlsearchParam.toString()
        history.pushState(null, "", newPath)
    }
   </script>
     
   
   
</body>

</html>
