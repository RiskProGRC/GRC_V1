
<?php
include_once'./company/companyClass.php';
include_once'./department/departmentClass.php';
include_once'./settings/riskcategoryClass.php';
include_once'./risk/riskClass.php';
include_once'./department/departmentClass.php';
include_once'./process/processClass.php';
include_once'./settings/controltypeClass.php';
//process
$processClass=new processClass();

$riskClass=new riskClass();
$showRisk=$riskClass->showRisk();
//riskcategoryf
$riskCatClass=new riskCatClass();
$showriskcat= $riskCatClass->showRiskCat();

$departmentClass=new departmentClass();
$showdept=$departmentClass->showDept();

$companyClass=new companyClass();
$showcompany=$companyClass->showCompany();

//control type
$ctypeclass= new controltypeClass();
$ctype=$ctypeclass->showcontroltype();
?>
<!DOCTYPE html>
<html lang="en">
<!-_________________Header location______________________->
<?php include_once'../layout/header.php';
$deptid=$sdid;
?>
<style>
.btn-group-sm>.btn, .btn-sm {
    border-radius: 0.2rem;
    font-size: .5rem;
    padding: 0.15rem 0.2rem;
}
.btn-buss{
    width:50px;
    height:400px
  }
  .btn-buss .bi{
    font-size: 25px;
  }
  tr,td{
        font-size:11px;
        font-weight: 800;
        color: #000;
        height: 9px;
        padding:2px 0px 2px !important;
    }
.nav-link {
  border: 1px solid #1b6ae1 !important;
  display: block;
  color: #000;
  padding: 8px 16px;
  text-decoration: none;
  border-radius: 0px !important;
}
.col-2,.col-9,.nav-col{
    padding: 0px;
    box-shadow: 5px 10px 18px #98b4e0;
}
.tab-pane{
    padding:10px 10px 0px 10px;
}
.form-card{
padding-top: 0px !important;
box-shadow: 5px 10px 18px #98b4e0;
}
.overflow{
    width: 100%;
    height: 450px;
    overflow: scroll;
}
.btn-success{
    width: 50px;
    height: 30px;
    font-size: 12px;

}
.details{
    font-weight: 600;
    color: #000;
}
.alert-warning {
    background-color: #eaca4a;
    color: #fff;
    padding: 5px;
    text-align: center;
}
</style>
<body>
    <div id="app">
        <div id="main" class="layout-horizontal">

 <!-_________________Navigation location______________________->

 <?php include_once'../layout/nav.php'; ?>

            <div class="content-wrapper container">
                
<div class="page-heading">
    <center> <h4>Risk Tracker</h4></center>
</div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
    <!-_________________Content location BEGINING______________________->

                <section class="section">
                    <div class="card ">
                        <div class="card-header">
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <!---beginning of form--------->
                                    <div class="row match-height">
                                        <div class="col-md-12 col-12">
                                            <div class="card">
                                                <div class="card-content">
                                                    <div class="card-body form-card">
                                                        <form class="form form-vertical">
                                                            <div class="form-body">
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <label for="first-name-vertical">Choose Entity</label>
                                                                                <select class="choices form-select" onchange="display(this.value)" id="deptid" name="deptid">
                                                                                    <option value="" selected>Choose Entity</option>
                                                                                    <?php foreach($showdept as $entity ){?>
                                                                                    <option value="<?=$entity['dept_id']?>"><?=$entity['dept_name']?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!---end of form--------->
                                </div>
                                <div class="col-sm-9" >
                                    <!---beginning of form--------->
                                        <div class="row" id="display">
                                            <div class="col-3">
                                                <input type="text" class="form-control" value="" placeholder="Company" disabled>
                                            </div>
                                            <div class="col-6">
                                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="2" placeholder="function" disabled></textarea>
                                            </div>
                                            <div class="col-3">
                                             <input type="text" class="form-control" id="" value="" placeholder="risk owner" disabled>
                                            </div>
                                            <hr/>
                                                
                                            <div class="col-12">
                                                <div class="tab-content" id="v-pills-tabContent">
                                                    <div class="tab-pane fade show active" id="v-pills-group" role="tabpanel"
                                                        aria-labelledby="v-pills-group-tab">
                                                        <!--------------------------begin of risk------------------------------------------->
                                                                <table class="table table-striped" id="table1">
                                                                        <thead id="thead">
                                                                            <tr>
                                                                                <th>Reference</th>
                                                                                <th>Department</th>
                                                                                <th>Process</th>
                                                                                <th>Inherent Risk</th>
                                                                                <th>Risk category</th>
                                                                                <th>Action</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                </tr>
                                                                        </tbody>
                                                                    </table>
                                                        <!--------------------------end of risk------------------------------------------->

                                                    </div>
                                                    <div class="tab-pane fade" id="v-pills-company" role="tabpanel"
                                                        aria-labelledby="v-pills-company-tab">
                
                                                    </div>
                                                    <div class="tab-pane fade" id="v-pills-entity" role="tabpanel"
                                                        aria-labelledby="v-pills-entity-tab">
                                                        <!--------------------------start of entity------------------------------------------->
                                                            <table class="table table-striped" id="table2">
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
                                                                        <input type="button" name="edit" value="Edit" class="btn btn-sm btn-primary edit-dept" id='.$dept["dept_id"].'>
                                                                        <input type="button" name="edit" value="Delete" class="btn btn-sm btn-danger delete-dept" id='.$dept["dept_id"].'>
                                                                        </td>
                                                                    </tr>';
                                                                }
                                                                    ?> 
                                                                </tbody>
                                                            </table>
                                                    <!--------------------------End of entity------------------------------------------->
                                                    </div>
                                                    <div class="tab-pane fade" id="v-pills-sub" role="tabpanel"
                                                        aria-labelledby="v-pills-sub-tab">
                                                        this should include items where the tabs is in the sub-Entity.<br>
                                                        this should include items where the tabs is in the sub-Entity.<br>
                                                        this should include items where the tabs is in the sub-Entity.<br>
                                                        this should include items where the tabs is in the sub-Entity.
                                                        this should include items where the tabs is in the sub-Entity.
                                                    </div>
                                                    <div class="tab-pane fade" id="v-pills-users" role="tabpanel"
                                                        aria-labelledby="v-pills-users-tab">
                                                        this should include items where the tabs is in the users.<br>
                                                        this should include items where the tabs is in the users.<br>
                                                        this should include items where the tabs is in the users.<br>
                                                        this should include items where the tabs is in the users.
                                                        this should include items where the tabs is in the users.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <!---end of form--------->

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
  <!------------------------------------------------RISK ADD MODAL------------------------------------------------------------>
    <div class="modal fade text-left w-100" id="addentrisk-modal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel16" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl"
            role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel16">ADD RISK</h4>
                    <button type="button" class="close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    
                <form class="form" id="addriskform">
                <div id="messagerisk"></div>
                        <div class="row">
                            <div class="col-md-6">

                                <div class="col-md-8">
                                    <label>Choose Entity:</label>
                                </div>
                                <div class="col-md-12 form-group">
                                    <select class="form-control" name="dept"  id="dept_id" required>
                                        <option value="" selected>--------------------SELECT Entity</option>
                                        <?php
                                        foreach($showdept as $dp){
                                            $deptid=$dp["dept_id"];
                                            $deptname=$deptClass->deptJoins($deptid);
                                        echo' <option value='.$dp["dept_id"].'>'.$deptname.'</option>';
                                        }
                                        ?>
                                    </select>
                                    <span class="error" id="deptid_err"> </span>
                                </div>

                                <div class="col-md-8">
                                        <label>Select Process:</label>
                                        
                                </div>
                                <div class="col-md-12 form-group">
                                    <select class="form-control" name="process" id="process_id" required>
                                        <option value="" selected>----------------------SELECT Process</option>
                                        <?php
                                        foreach($showprocess as $process){
                                            $processname=ucfirst($process["process_name"]);
                                            
                                        echo' <option value='.$process["process_id"].'>'.$processname.'</option>';
                                        }
                                        ?>

                                    </select>
                                    <span class="error" id="processid_err"> </span>
                                </div>

                                <div class="col-md-8">
                                        <label>Enter Inherent Risk:</label>
                                </div>
                                <div class="col-md-12 form-group">
                                    <input type="text" class="form-control" name="name" id="inherent" placeholder="Enter inherent risk" required>
                                    <span class="error" id="inherent_err"> </span>
                                </div>
                                <div class="col-md-8">
                                        <label>Choose Risk Category:</label>
                                        
                                </div>
                                <div class="col-md-12 form-group">                            
                                    <select class="form-control" name="rcat" id="rcat" required>
                                        <option value="" selected>--------------------SELECT Risk Category</option>
                                            <?php
                                            foreach($showriskcat as $category){
                                                $cname=ucfirst($category["name"]);
                                                echo'<option value='.$category["riskcat_id"].'>'.$cname.'</option>';
                                            }                                            
                                            ?>
                                    </select>
                                    <span class="error" id="rcat_err"> </span>                                    
                                </div>                              

                                <div class="col-md-8">
                                        <label>Nominee/Risk Owner:</label>
                                </div>
                                <div class="col-md-12 form-group">
                                    <input type="text" class="form-control" name="nominee" value="super-admin" id="nominee">
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="col-md-8">
                                        <label>Enter Risk Cause:</label>
                                </div>
                                <div class="col-md-12 form-group">
                                    <textarea name="cause" class="form-control" id="cause" cols="8" rows="4" required></textarea>
                                    <span class="error" id="cause_err"> </span>   
                                </div>
                                <div class="col-md-8">
                                        <label>Enter Consequence:</label>
                                </div>
                                <div class="col-md-12 form-group">
                                    <textarea name="consequence" class="form-control" id="consequence" cols="8" rows="4" required></textarea>

                                    <span class="error" id="cause_err"> </span>   
                                </div>

                                <div class="col-md-8">
                                        <label>Risk Champion:</label>
                                </div>
                                <div class="col-md-12 form-group">
                                    <select class="form-control" name="reviewer" id="reviewer" required>
                                        <option value="" selected>----------------------SELECT Champion</option>
                                        <?php
                                        foreach($showusers as $user){
                                            $reviewername=ucfirst($user["fname"].'&nbsp;'.$user["sname"]);
                                        echo' <option value='.$user["id"].'>'.$reviewername.'</option>';
                                        }
                                        ?>
                                    </select>
                                    <span class="error" id="reviewer_err"> </span> 
                                </div>
                                <div class="col-md-8">
                                        <label>Reviewer Date:</label>
                                </div>
                                <div class="col-md-12 form-group">
                                    <input type="text" class="form-control" name="rdate" id="datepicker" placeholder="" autocomplete="off">
                                    <span class="error" id="rdate_err"> </span>
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
                    <button type="button" class="btn btn-primary ml-1 addrisksbutton">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Add Risk</span>
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-----------------------------------end RISK ADD Modals--------------------------------------------------------------->
    
    <!-----------------------------------keyindicator ADD Modals--------------------------------------------------------------->
    <div class="modal fade text-left" id="addki-modal" tabindex="-1" role="dialog"aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel17">Add Key Performance Indicator</h3>
                    <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>        
                
                <div class="modal-body">
                    <div id="messageki"></div>
                <form class="form form-horizontal" id="kientaddform">
                <div class="row">
                        <div class="col-md-12 form-group">
                            <label>Choose Process:</label>
                            <input type="hidden" class="form-control"  name="dept_id" id="pdept_id">
                            <select class="form-control selectprocess choices" onchange="fetchprocess(this.value)" name="processid" id="kiprocess">
                                <option value="" selected>----SELECT Process---</option>
                                <?php
                                foreach($showprocess as $process){
                                    $deptid=$process["dept_id"];
                                    $deptpname=$deptClass->deptJoins($deptid);
                                echo'<option value='.$process["process_id"].'>'.$process["process_name"].'&nbsp;&nbsp;('.$deptpname.')</option>';

                                    }
                                ?>
                            </select>
                            <span class="error" id="kiprocess_err"> </span>
                        </div>

                        <div class="col-md-12 form-group">
                            <label>Choose Risk:</label>
                            <select class="form-select" name="selectrisk" id="selectrisk">
                                <option value="">----SELECT Risk---</option>
                            </select>
                            <span class="error" id="kirisk_err"> </span>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Enter Key Indicator:</label>
                            <textarea class="form-control" name="ki" id="ki" rows="3"></textarea>
                            <span class="error" id="ki_err"> </span>
                        </div>
                        <!--<div class="col-md-12 form-group">
                            <label>Key Risk Indicator:</label>
                            <select class="form-control" name="kri" id="kri" >
                                <option value="" selected>----SELECT KEY RISK INDICATOR---</option>
                               
                            </select>
                        </div>-->
                        <div class="col-md-12 form-group">
                                <label>Owner:</label>
                            <select class="form-select" name="owner" id="kiowner">
                                <option value="" selected>----SELECT Owner---</option>
                                <?php
                                foreach($showusers as $user){
                                    
                                echo'<option value='.$user["id"].'>'.$user["fname"].'&nbsp;'.$user["sname"].'</option>';

                                    }
                                ?>
                            </select>
                            <span class="error" id="kiowner_err"> </span>
                        </div>
                                    
                                
                            
                </div><!--end of row--->

                </div>
                <div class="modal-footer">
                <!--<div class="col-12 alert alert-danger" id="messagedisplayki" style="text-align:center;font-size:25px;font-weight:600;"></div>-->
                <button type="button" class="btn btn-danger"
                        data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="" name="editCompany" class="btn btn-primary kiadd-btn">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Add Key Indicator</span>
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
     <!-----------------------------------COMPANY EDIT Modals--------------------------------------------------------------->
     
  <!-----------------------------------ADD CONTOL Modals--------------------------------------------------------------->
    <div class="modal fade text-left" id="addcontrol-modal" tabindex="-1" role="dialog"aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel17">ADD CONTROL</h3>
                    <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>        
                
                <div class="modal-body">
                <form class="form form-horizontal" id="addcontrolform">
                <div id="messagecontrol"></div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label>Choose Process:</label>
                            <input type="hidden" class="form-control"  name="cdept_id" id="cdept_id">
                            <select class="form-control selectprocess choices" onchange="controlprocess(this.value)" name="cprocess" id="cprocess">
                                <option value="" selected>----SELECT Process---</option>
                                <?php
                                foreach($showprocess as $process){
                                    $deptid=$process["dept_id"];
                                    $deptpname=$deptClass->deptJoins($deptid);
                                echo'<option value='.$process["process_id"].'>'.$process["process_name"].'&nbsp;&nbsp;('.$deptpname.')</option>';

                                    }
                                ?>
                            </select>
                            <span class="error" id="cprocess_err"> </span>
                        </div>

                        

                        <div class="col-md-12 form-group">
                            <label>Enter Controls:</label>
                            <textarea class="form-control" name="control" id="controls" rows="3"></textarea>
                            <span class="error" id="control_err"> </span>
                        </div>

                        <div class="col-md-6 form-group">
                                <label>Control Strength:</label>
                            <select class="form-select" name="cstrength" id="cstrength">
                                <option value="" selected>----SELECT Control Strength---</option>
                                <?php
                                foreach($showcstrength as $cs){
                                    
                                echo'<option value='.$cs["strength_id"].'>'.$cs["cs_name"].'</option>';

                                    }
                                ?>
                            </select>
                            <span class="error" id="cstrength_err"> </span>
                        </div>

                        <div class="col-md-6 form-group">
                                <label>Control Type:</label>
                            <select class="form-select" name="ctype" id="ctype">
                                <option value="" selected>----SELECT Control Type---</option>
                                <?php
                                foreach($ctype as $ct){
                                    
                                echo'<option value='.$ct["ctype_id"].'>'.$ct["ct_name"].'</option>';

                                    }
                                ?>
                            </select>
                            <span class="error" id="ctype_err"> </span>
                        </div>
                        <div class="col-md-6 form-group">
                                <label>Reviewer:</label>
                            <select class="form-select" name="reviewer" id="creviewer">
                                <option value="" selected>SELECT Reviewer---</option>
                                <?php
                                foreach($showusers as $user){
                                    
                                echo'<option value='.$user["id"].'>'.$user["fname"].'&nbsp;'.$user["sname"].'</option>';

                                    }
                                ?>
                            </select>
                            <span class="error" id="creviewer_err"> </span>
                        </div>

                        <div class="col-md-6 form-group">
                                <label>Review Date:</label>
                            <input type="text" class="form-control" name="rdate" id="datepicker2" autocomplete="off">
                        </div>
                        <span class="error" id="crdate_err"> </span>
                        
                    
                </div><!--end of row--->

                </div>
                <div class="modal-footer">
                <!--<div class="col-12 alert alert-danger" id="messagedisplaycontrol" style="text-align:center;font-size:25px;font-weight:600;"></div>-->
                    <button type="button" class="btn btn-danger"
                        data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button name="addcontrol-btn" class="addentcontrol-btn btn btn-primary">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">ADD Control</span>
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
     <!-----------------------------------End of control--------------------------------------------------------------->
     
 <!-----------------------------------ADD Action Modals--------------------------------------------------------------->
    <div class="modal fade text-left" id="addaction-modal" tabindex="-1" role="dialog"aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel17">ADD ACTION</h3>
                    <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>        
                
                <div class="modal-body">
                    <div id="messageaction"></div>
                <form class="form form-horizontal" id="actionform">
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label>Choose Process:</label>
                        <input type="hidden" class="form-control"  name="adept_id" id="adept_id">
                        <select class="form-control selectprocess choices" onchange="actiondrop(this.value)" name="aprocess" id="aprocess">
                            <option value="" selected>----SELECT Process---</option>
                            <?php
                            foreach($showprocess as $process){
                                $deptid=$process["dept_id"];
                                $deptpname=$deptClass->deptJoins($deptid);
                                
                            echo'<option value='.$process["process_id"].'>'.$process["process_name"].'&nbsp;&nbsp;('.$deptpname.')</option>';

                                }
                            ?>
                        </select>
                        <span class="error" id="aprocess_err"> </span>
                    </div>

                    <div class="col-md-12 form-group">
                        <label>Choose Risk:</label>
                        <select class="form-control" name="arisk" id="arisk">
                            <option value="" selected>----SELECT Risk---</option>                
                        </select>
                        <span class="error" id="arisk_err"> </span>
                    </div>

                    <div class="col-md-12 form-group">
                        <label>Action Details:</label>
                        <textarea class="form-control" name="action" id="actionname" rows="3"></textarea>
                        <span class="error" id="action_err"> </span>
                    </div>

                    <div class="col-md-12 form-group">
                            <label>Status:</label>
                        <select class="form-select" name="status" id="status">
                            <option value="" selected>----SELECT Action status---</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                            <option value="ongoing" selected>Ongoing</option>
                            <option value="overdue">Overdue</option>
                            
                        </select>
                    </div>
                    <div class="col-md-12 form-group">
                            <label>Priority:</label>
                        <select class="form-select" name="priority" id="priority">
                            <option value="" selected>----SELECT Action Priority---</option>
                            <option value="Incredibly high">Incredibly high</option>
                            <option value="Very High">Very High</option>
                            <option value="High">High</option>
                            <option value="Medium">Medium</option>
                            <option value="Low">Low</option>                            
                        </select>
                    </div>
                    <div class="col-md-12 form-group">
                            <label>Timeline:</label>
                        <input type="text" class="form-control" autocomplete="off" name="timeline" id="datepicker3">
                        <span class="error" id="atime_err"> </span>
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
                    <button type="" name="addaction-btn" class="btn btn-primary addentaction-btn">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">ADD Action</span>
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
     <!-----------------------------------ADD Action Modals--------------------------------------------------------------->
   <!------------------------------------------------RISK ADD MODAL------------------------------------------------------------>
    <div class="modal fade text-left w-100" id="addentrecommend-modal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel16" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl"
            role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel16">ADD RECOMMENDAION</h4>
                    <button type="button" class="close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form" id="addentrecommendform">
                        <div class="row">
                            <div class="col-md-6">

                                <div class="col-md-12 form-group">
                                    <label>Choose Process:</label>
                                    <input type="hidden" class="form-control"  name="rdept_id" id="rdept_id">
                                    <select class="form-control selectprocess choices" onchange="recommendprocess(this.value)" name="rmdprocess" id="rmdprocess">
                                        <option value="" selected>----SELECT Process---</option>
                                        <?php
                                            foreach($showprocess as $process){
                                                $deptid=$process["dept_id"];
                                                $deptpname=$deptClass->deptJoins($deptid);
                                                
                                            echo'<option value='.$process["process_id"].'>'.$process["process_name"].'&nbsp;&nbsp;('.$deptpname.')</option>';

                                            }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-12 form-group">
                                    <label>Choose Risk:</label>
                                    <select class="form-control" name="rmdrisk" id="rmdrisk">
                                        <option value="" selected>----SELECT Risk---</option>
                                        
                                    </select>
                                </div>

                                
                                
                                <div class="col-md-12 form-group">
                                        <label>Action:</label>
                                    <select class="form-select choices" name="action" id="">
                                        <option value="" selected>----SELECT Action ---</option>
                                        <?php
                                        foreach($showaction as $action){
                                        echo'<option value='.$action["id"].'>'.$action["action"].'</option>';

                                            }
                                        ?>
                                        
                                    </select>
                                </div>

                                <div class="col-md-12 form-group">
                                        <label>Status:</label>
                                    <select class="form-select" name="status" id="">
                                        <option value="" selected>----SELECT Action status---</option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                        <option value="ongoing">Ongoing</option>
                                        <option value="overdue">Overdue</option>
                                        
                                    </select>
                                </div>
                                <div class="col-md-12 form-group">
                                        <label>Timeline:</label>
                                    <input type="text" class="form-control" name="timeline" id="datepicker4">
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12 form-group">
                                    <label>MRC(Management Risk Committee) Recommendation:</label>
                                    <textarea class="form-control" name="mrc" id="" rows="7"></textarea>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label>ARMC(Audit Risk Management Committee) Recommendation:</label>
                                    <textarea class="form-control" name="armc" id="" rows="7"></textarea>
                                </div>
                                
                            </div>
                            
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger"
                        data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="button" class="btn btn-primary ml-1 addentrecommend-btn"
                        data-bs-dismiss="modal">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Add Recommendation</span>
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-----------------------------------end RISK ADD Modals--------------------------------------------------------------->
     


 <!-_________________Footer location______________________->

        <?php include_once'../layout/footer.php'; ?>
        
        </div>
        
    </div>
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>

    <!-- Include Choices JavaScript -->
    <script src="../assets/vendors/choices.js/choices.min.js"></script>
    <script src="../assets/js/pages/form-element-select.js"></script>

  <!----------------------Datatable Simple------------------------------------------------>
    <script src="../assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        let table2 = document.querySelector('#table2');
        
        let dataTable1 = new simpleDatatables.DataTable(table1);
        let dataTable2 = new simpleDatatables.DataTable(table2);
    </script>

<!------------------------------SWEET ALERTS---------------------------------->
<script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>

<!----------------------Datatable Simple end------------------------------------------------>

    <script src="../assets/js/pages/horizontal-layout.js"></script>

<!----------------------font awsome------------------------------------------------>
    <script src="../assets/vendors/fontawesome/all.min.js"></script>

   
    
</body>

</html>
