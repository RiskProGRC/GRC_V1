
<?php
include_once'./settings/impactClass.php';
include_once'./settings/likelihoodClass.php';
include_once'./settings/riskcategoryClass.php';
include_once'./risk/riskClass.php';
include_once'./join/JoindpClass.php';

include_once'./company/companyClass.php';
include_once'./process/processClass.php';
include_once'./settings/controlstrengthClass.php';
include_once'./settings/controltypeClass.php';
include_once'./raf/kriClass.php';

$kriclass=new kriClass();
$showkri=$kriclass->fetchkri();

$cstrengthClass=new controlstrengthClass();
$showcstrength=$cstrengthClass->showcontrolstrength();

$ctypeclass= new controltypeClass();
$ctype=$ctypeclass->showcontroltype();

$processClass=new processClass();
$showprocess=$processClass->showProcess();

$companyClass=new companyClass();
$showcompany=$companyClass->showCompany();




//dperatment & process joins
$joindpClass=new joindpClass();
$showdp=$joindpClass->riskDept();
//risk
$riskClass= new riskClass();
//riskcategoty
$riskcatClass=new riskCatClass();
$riskCat=$riskcatClass->showRiskCat();
//impact
$impactClass=new impactClass();
$showImpact= $impactClass->showImpact();
//likrelihood
$likelyClass=new likelihoodClass();
$showlikely=$likelyClass->showlikely();


?>
<!DOCTYPE html>
<html lang="en">
<!-_________________Header location______________________->
<?php include_once("../layout/header.php"); 

$deptid=$sdid;
$deptname=$deptClass->deptJoins($deptid);//displays the department name 
?>


<body>
    <div id="app">
        <div id="main" class="layout-horizontal">

 <!-_________________Navigation location______________________->

            <?php include_once("../layout/nav.php") ?>
<style>
    label {
    
    font-size: 13px;
    color: #000;
    font-weight: 800;
}
.form-control{
    font-size: 13px;
    font-weight: 800;
    
    
}
.choices{
    font-size: 14px;
    font-weight: 800;
    color: #000;
    padding: 2px 2px;
}
.nav-tabs{
    font-size: 13px;
    font-weight: 800;
}
thead {
    background: #3b4982;
    color:#ffff;
    font-size: 0.75em;
    
}
tbody{
    background: #fff;
    color: #0c141b;
    font-weight: 600;
    font-size: 0.8em;
    height: 10px;
    overflow: scroll;
}
.overflow{
    width: 100%;
    height: 250px;
    overflow: scroll;
}
h4{
text-align: center;

}
</style>
            <div class="content-wrapper container">
                
<div class="page-heading">
    <h4>Entity</h4>
    <div class="website" >
        <h2 id="messagedisplay"></h2>
    </div>
</div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
    <!-_________________Content location BEGINING______________________->
  <!-- // Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" id="addactionform" action="" method="POST">
                                <div class="row">
                                    <div style="border:3px solid #181d30;background:#bdd1ef;margin-top:3px;padding-top:7px;padding-bottom:4px;" class="col-12 d-flex justify-content-end">
                                    <?php if($sess_roles==1){ ?>
                                        <div class="col-sm-2"><a href="#" data-bs-toggle="modal" data-bs-target="#adddept-modal" class="btn btn-sm btn-primary">Add Entity</a></div>
                                    <?php }else{ ?>   
                                        <div class="col-sm-2"></div> 
                                       <?php } ?>
                                       <div class="col-sm-2"><a href="b_objective.php" class="btn btn-sm btn-primary">Business Obj.</a></div>
                                        <div class="col-sm-2"><a href="addprocess.php" class="btn btn-sm btn-primary">Add Process</a></div>
                                        <div class="col-sm-2"><a href="addrisk.php" class="btn btn-sm btn-primary">Add Risk</a></div>
                                        <div class="col-sm-2"><a href="addcontrol.php" class="btn btn-sm btn-primary">Add Control</a></div>
                                        <div class="col-sm-1"><a href="addkeyindicator.php" class="btn btn-sm btn-primary">Add KPI</a></div>
                                        <div class="col-sm-1"><a href="addaction.php" class="btn btn-sm btn-primary">Add Action</a></div>
                                        <!--<div class="col-sm-2"><input type="button" name="riskcat" value="Risk Category" class="btn btn-sm btn-primary addriskcat" id="addriskcat"></div>-->
                                        <!--<div class="col-sm-2"><a href="../Project/department.php" class="btn btn-sm  btn-danger me-1 mb-1">Close</a></div>-->
   
                                    </div><br>

                                    <div style="margin:0 auto;text-align:center;padding-top:7px;padding-bottom:4px;" class="col-md-6 form-group">
                                        <label style="font-size:1.1em;font-weight:700;">Choose Entity:</label>
                                        <select onchange="display(this.value)" class="form-control choices" name="department" id="department">
                                            <option value="" selected>Choose Entity</option>
                                                <?php
                                                foreach($showdept as $dept){
                                                    echo'<option value='.$dept["dept_id"].'>'.$dept["dept_name"].'</option>';
                                                }
                                                
                                                ?>
                                        </select>
                                    </div>
                                   
                                    

                                   
                                </div>

            <div class="row" id="display">
                <div class="col-md-4 form-group">
                    <label>Company:</label>
                    <input type="text" class="form-control" value="" disabled>
                </div>

                <div class="col-md-4 form-group">
                    <label>Owners:</label>
                    <input type="text" class="form-control" value="" disabled>
                </div>

                <div class="col-md-4 form-group">
                    <label>Functions:</label>
                        <textarea class="form-control"  name="" id="" cols="0" rows="2" disabled></textarea>
                </div>
            
<!-----------------------Nav TABS edits ----------------------------------> 
        <div class="form-group col-12"><!-------------tabs for navigation part----------->
            <hr>
                <div class="card">
                        <div class="card-header">
                        
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab"
                                        aria-controls="home" aria-selected="true">Risks &nbsp;<span class="badge bg-primary"></span></a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#ki" role="tab"
                                        aria-controls="contact" aria-selected="false">KIs &nbsp;<span class="badge bg-primary"></span></a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link " id="home-tab" data-bs-toggle="tab" href="#control" role="tab"
                                        aria-controls="home" aria-selected="true">Controls &nbsp;<span class="badge bg-primary"></span></a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link " id="home-tab" data-bs-toggle="tab" href="#recommend" role="tab"
                                        aria-controls="home" aria-selected="true">Recommendations &nbsp;<span class="badge bg-primary"></span></a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#action" role="tab"
                                        aria-controls="profile" aria-selected="false">Actions &nbsp;<span class="badge bg-primary"></span></a>
                                </li>
                                
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                
                                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                    <div class="row" style="margin-top: 20px;">
                                        <div class="row col-md-12" ><!---inherent risk tab-->
                                        <div class="overflow">  
                                            <table class="table table-bordered">
                                            <thead>
                                                
                                                <tr>
                                                    <th>Reference id</th>
                                                    <th>Description</th>
                                                    <th>Cause</th>
                                                    <th>Nominee</th>
                                                    <th>Reviewer</th>
                                                    <th>Reviewer date</th>
                                                    <th>Category</th>
                                                    <th>Status</th>
                                                    <th>Active</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            
                                                   
                                            </tbody>
                                            

                                        </table>
                                        </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="control" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="row" style="margin-top: 20px;">
                                        <div class="row col-md-12" ><!---inherent risk tab-->
                                        <div class="overflow">  
                                            <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Reference id</th>
                                                    <th>Control Name</th>
                                                    <th>Control Strength</th>
                                                    <th>Reviewer</th>
                                                    <th>Reviewer date</th>
                                                    <th>Control Type</th>
                                                    <th>status</th>
                                                    <th>Active</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    <tr>
                                                        <td>CTL00</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>
                                                <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                                                </div>                          
                                                        </td>
                                                    </tr>
                                                   
                                            </tbody>
                                            

                                        </table>
                                        </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="action" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="row" style="margin-top: 20px;">
                                        <div class="row col-md-12" ><!---inherent risk tab-->
                                        <div class="overflow">  
                                            <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Reference id</th>
                                                    <th>Action Name</th>
                                                    <th>Priority</th>
                                                    <th>Status</th>
                                                    <th>Timeline</th>
                                                    <th>Active</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            

                                        </table>
                                        </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="ki" role="tabpanel" aria-labelledby="contact-tab">
                                <div class="row" style="margin-top: 20px;">
                                        <div class="row col-md-12" ><!---inherent risk tab-->
                                        <div class="overflow">  
                                            <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Reference id</th>
                                                    <th>Key indicator</th>
                                                    <th>Apetite</th>
                                                    <th>owner</th>
                                                    <th>Active</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>
                                                <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                                                </div>                          
                                                        </td>
                                                    </tr>
                                                    
                                                   
                                            </tbody>
                                            

                                        </table>
                                        </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
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
    </section>
    <!-- // Basic multiple Column Form section end -->


    <!-_________________Content location END______________________->
                
            </div>
        </section>
    </div>

  </div>





 <!-_________________Footer location______________________->

        <?php include_once("../layout/footer.php"); ?>

<!------------------------------------------------RISK ADD MODAL------------------------------------------------------------>
    <div class="modal fade text-left w-100" id="addrisk-modal" tabindex="-1" role="dialog"
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
                                        </div>

                                        <div class="col-md-8">
                                                <label>Enter Inherent Risk:</label>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter inherent risk" required>
                                        </div>
                                        <div class="col-md-8">
                                                <label>Choose Risk Category:</label>
                                               
                                        </div>
                                        <div class="col-md-12 form-group">
                                        
                                            <select class="form-control" name="rcat" id="rcat" required>
                                                <option value="" selected>--------------------SELECT Risk Category</option>
                                                    <?php
                                                    foreach($riskCat as $category){
                                                        $cname=ucfirst($category["name"]);
                                                        echo'<option value='.$category["riskcat_id"].'>'.$cname.'</option>';
                                                    }
                                                    
                                                    ?>
                                            </select>
                                           
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
                                        </div>

                                        <div class="col-md-8">
                                                <label>Nominee:</label>
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
                                            <textarea name="cause" class="form-control" id="cause" cols="20" rows="8" required></textarea>
                                        </div>

                                        <div class="col-md-8">
                                                <label>Reviewer:</label>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <select class="form-control" name="reviewer" id="reviewer" required>
                                                <option value="" selected>----------------------SELECT Reviewer</option>
                                                <?php
                                                foreach($showusers as $user){
                                                    $reviewername=ucfirst($user["fname"].'&nbsp;'.$user["sname"]);
                                               echo' <option value='.$user["id"].'>'.$reviewername.'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                                <label>Reviewer Date:</label>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <input type="text" class="form-control" name="rdate" id="datepicker" placeholder="" autocomplete="off">
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
                            <button type="button" class="btn btn-primary ml-1 addrisksbutton"
                                data-bs-dismiss="modal">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Add Risk</span>
                            </button>
                        </div>
                     </form>
                    </div>
                </div>
            </div>
    <!-----------------------------------end RISK ADD Modals--------------------------------------------------------------->
      <!-----------------------------------entity ADD Modals--------------------------------------------------------------->
    <div class="modal fade text-left" id="adddept-modal" tabindex="-1" role="dialog"aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel17">Add Entity</h3>
                    <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>        
                <form class="form form-horizontal" id="adddeptform">
                <div class="modal-body">
                <div class="row">
                            <div class="col-md-3">
                                <label>Entity Name:</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" class="form-control" name="name" id=""
                                    placeholder="Entity name">
                            </div> 
                            <div class="col-md-3">
                                <label>Select Company:</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <select class="form-control" name="company" id="">
                                    <option value="" selected>--------------Selected Company----------</option>
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
                            <select class="form-control" name="owner" id="">
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
                                <textarea class="form-control" name="function" id="" cols="" rows="5" placeholder=""></textarea>
                            </div>
                                
                            
                        </div><!--end of row--->

                </div>
                <div class="modal-footer">
               <!-- <div class="col-12 alert alert-danger" id="adddeptmessage" style="text-align:center;font-size:25px;font-weight:600;"></div>-->
                    <button type="button" class="btn btn-danger"
                        data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button name="update" class="btn btn-primary adddeptbutton">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">ADD Entity</span>
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
     <!-----------------------------------COMPANY EDIT Modals--------------------------------------------------------------->
              <!-----------------------------------keyindicator ADD Modals--------------------------------------------------------------->
    <div class="modal fade text-left" id="addki-modal" tabindex="-1" role="dialog"aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel17">Add Key Indicator</h3>
                    <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>        
                <form class="form form-horizontal" id="kiaddform">
                <div class="modal-body">
                <div class="row">
                        <div class="col-md-12 form-group">
                            <label>Choose Process:</label>
                            <input type="hidden" value="<?=$sdid?>" name="dept_id">
                            <select class="form-control choices processselect" onchange="fetchprocess(this.value)" name="processid" id="processselect">
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
                            <select class="form-select" name="selectrisk" id="selectrisk">
                                <option value="">----SELECT Risk---</option>
                            </select>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Enter Key Indicator:</label>
                            <textarea class="form-control" name="ki" id="ki" rows="3"></textarea>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Key Risk Indicator:</label>
                            <select class="form-control" name="kri" id="kri" >
                                <option value="" selected>----SELECT KEY RISK INDICATOR---</option>
                                <?php
                                foreach($showkri as $kri){
                                echo'<option value='.$kri["id"].'>'.$kri["kri"].'</option>';

                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-12 form-group">
                                <label>Owner:</label>
                            <select class="form-select" name="owner" id="owner">
                                <option value="" selected>----SELECT Owner---</option>
                                <?php
                                foreach($showusers as $user){
                                    
                                echo'<option value='.$user["id"].'>'.$user["fname"].'&nbsp;'.$user["sname"].'</option>';

                                    }
                                ?>
                            </select>
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
                    <button type="" name="editCompany" class="kiadd-btn btn btn-primary">
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
                <form class="form form-horizontal" id="addcontrolform">
                <div class="modal-body">
                <div class="row">
                        <div class="col-md-12 form-group">
                            <label>Choose Process:</label>
                            <input type="hidden" value="<?=$sdid?>" name="dept_id">
                            <select class="form-control choices" onchange="controlprocess(this.value)" name="aprocess" id="aprocess">
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
                            <select class="form-control" name="crisk" id="crisk">
                                <option value="" selected>----SELECT Risk---</option>
                    
                            </select>
                        </div>

                        <div class="col-md-12 form-group">
                            <label>Enter Controls:</label>
                            <textarea class="form-control" name="control" id="control" rows="5"></textarea>
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
                        </div>
                        <div class="col-md-6 form-group">
                                <label>Reviewer:</label>
                            <select class="form-select" name="reviewer" id="reviewer">
                                <option value="" selected>SELECT Reviewer---</option>
                                <?php
                                foreach($showusers as $user){
                                    
                                echo'<option value='.$user["id"].'>'.$user["fname"].'&nbsp;'.$user["sname"].'</option>';

                                    }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                                <label>Review Date:</label>
                            <input type="text" class="form-control" name="rdate" id="datepicker2" autocomplete="off">
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
                    <button name="addcontrol-btn" class="addcontrol-btn btn btn-primary">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">ADD Control</span>
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
     <!-----------------------------------COMPANY EDIT Modals--------------------------------------------------------------->
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
                <form class="form form-horizontal" id="actionform">
                <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label>Choose Process:</label>
                        <input type="hidden" value="<?=$sdid?>" name="dept_id">
                        <select class="form-control choices" onchange=" actiondrop(this.value) " name="aprocess" id="aprocess">
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
                        <select class="form-control" name="arisk" id="arisk">
                            <option value="" selected>----SELECT Risk---</option>
                
                        </select>
                    </div>

                    <div class="col-md-12 form-group">
                        <label>Action Details:</label>
                        <textarea class="form-control" name="action" id="action" rows="3"></textarea>
                    </div>

                    <div class="col-md-12 form-group">
                            <label>Status:</label>
                        <select class="form-select" name="status" id="status">
                            <option value="" selected>----SELECT Action status---</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                            <option value="ongoing">Ongoing</option>
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
                    <button type="" name="addaction-btn" class="btn btn-primary actionaddbutton">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">ADD Control</span>
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
     <!-----------------------------------ADD Action Modals--------------------------------------------------------------->
    <!-----------------------------------------Modal risk category-------------------------------->
     <!--Basic Modal 
    <div class="modal fade text-left" id="riskcatmodal" tabindex="-1" role="dialog"
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
                                    <form id="riskcatform" method="POST">  
                                    <div class="modal-body">
                                    <div class="col-md-8">
                                            <label>Enter Risk Category:</label>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <input type="text" class="form-control" name="name" id="name"
                                                placeholder="Enter category">
                                        </div>
                                    </div>

                                    <div class="modal-footer form-group">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                            <i class="bx bx-x d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Close</span>
                                        </button>
                                        <button type="" name="addaction-btn" class="btn btn-primary riskcatbutton">
                                            <i class="bx bx-x d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">ADD Risk Category</span>
                                        </button>
                                    </div>
                                </form>
                                </div>
                            </div>
                    </div>
        </div>
        
    </div>-->
    <!-----------------------------------------Modal Process-------------------------------->
     <!--Basic Modal -->
     <div class="modal fade text-left" id="processmodal" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h2 class="modal-title" id="myModalLabel1">Add Process</h2>
                                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <i data-feather="x"></i>
                                        </button>
                                    </div>
                        <form id="processform">
                            <div  class="card">
                                
                                <div class="card-body">
                                        <div class="row">
                                        
                                        <div class="col-md-8">
                                                    <label>Entity:</label>
                                            </div>    
                                        <div class="col-md-12 form-group">
                                                <select class="form-control" name="dept" id="">
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
                                                <input type="text" class="form-control" name="name"
                                                    placeholder="Enter Process">
                                            </div>

                                            <div class="col-md-8">
                                                    <label>Enter details:</label>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <textarea class="form-control" name="detail" id="" rows="5"></textarea>
                                            </div>
                                        
                                    </div><!--end of row--->

                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button name="addprocess" class="btn btn-lg btn-primary addprocessbtn">Add Process</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-danger"
                                                data-bs-dismiss="modal">
                                                <i class="bx bx-x d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Close</span>
                                            </button>
                                        </div>

                                    </div><!-----end of footer row-->
                                        
                                </div>
                            </div>
                        </form>
                                </div>
                            </div>
                    </div>
        </div>
        
    </div>
<!-----------------------script for dynamic drop down----------------------------------->

      
<!-----------------------------------------Modal For ENTITY-------------------------------->


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
        if (table1) { new simpleDatatables.DataTable(table1); } // guard: page has no #table1
    </script>
<!----------------------Datatable Simple end------------------------------------------------>
    <script src="../assets/js/pages/horizontal-layout.js"></script>

 <!------------------------------SWEET ALERTS---------------------------------->
    <script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>

<!----------------------font awsome------------------------------------------------>
    <script src="../assets/vendors/fontawesome/all.min.js"></script>

  



</body>

</html>
