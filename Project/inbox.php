<?php

include_once'./settings/riskcategoryClass.php';
include_once'./risk/riskClass.php';
include_once'./department/departmentClass.php';
include_once'./process/processClass.php';
include_once'./users/usersClass.php';
include_once'./keyindicator/keyindicatorClass.php';
include_once'./control/controlClass.php';
include_once'./settings/controlstrengthClass.php';
include_once'./settings/controltypeClass.php';
include_once'./recommend/recommendClass.php';
include_once'./action/actionClass.php';

$actionClass=new actionClass();
$recommendClass=new recommendClass();
$cstrengthClass=new controlstrengthClass();
$showcstrength=$cstrengthClass->showcontrolstrength();
$ctypeclass= new controltypeClass();
$ctype=$ctypeclass->showcontroltype();
$controlClass= new controlClass();
$kiclass=new kiClass();
$users=new usersClass();
$processClass=new processClass();
$deptClass=new departmentClass();
$riskClass=new riskClass();
$riskCatClass=new riskCatClass();
$showriskcat= $riskCatClass->showRiskCat();

// read session role and department — role 3 is a department-level user
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$sessionRole = $_SESSION['roles']   ?? 0;
$sessionDept = $_SESSION['dept_id'] ?? '';

if ($sessionRole == 3 && $sessionDept !== '') {
    // fetch only records that belong to the logged-in user's department
    $showRisk      = $riskClass->showRiskdept($sessionDept);
    $showcontrol   = $controlClass->showcontroldept($sessionDept);
    $showki        = $kiclass->showKidept($sessionDept);
    $showrecommend = $recommendClass->showrecommenddept($sessionDept);
    $showaction    = $actionClass->showactiondept($sessionDept);

    // derive counts from the already-filtered arrays
    $pending_risk   = count(array_filter($showRisk,      fn($r) => $r['approval'] == 1));
    $approved_risk  = count(array_filter($showRisk,      fn($r) => $r['approval'] == 2));
    $rejected_risk  = count(array_filter($showRisk,      fn($r) => $r['approval'] == 3));
    $pendingcontrl  = count(array_filter($showcontrol,   fn($c) => $c['approval'] == 1));
    $approvedcontrl = count(array_filter($showcontrol,   fn($c) => $c['approval'] == 2));
    $pendingki      = count(array_filter($showki,        fn($k) => $k['approval'] == 1));
    $approvedki     = count(array_filter($showki,        fn($k) => $k['approval'] == 2));
    $pendingrcmd    = count(array_filter($showrecommend, fn($r) => $r['approval'] == 1));
    $approvedrcmd   = count(array_filter($showrecommend, fn($r) => $r['approval'] == 2));
    $pendingaction  = count(array_filter($showaction,    fn($a) => $a['approval'] == 1));
    $approvedaction = count(array_filter($showaction,    fn($a) => $a['approval'] == 2));
} else {
    // admin / other roles — fetch everything
    $showRisk      = $riskClass->showRisk();
    $showcontrol   = $controlClass->showcontrol();
    $showki        = $kiclass->showKi();
    $showrecommend = $recommendClass->showrecommend();
    $showaction    = $actionClass->showaction();

    $pending_risk   = $riskClass->pendingrisks();
    $approved_risk  = $riskClass->approvedrisks();
    $rejected_risk  = $riskClass->rejectedrisks();
    $pendingcontrl  = $controlClass->pendingcontlr();
    $approvedcontrl = $controlClass->approvedcontlr();
    $pendingki      = $kiclass->pendingki();
    $approvedki     = $kiclass->approvedki();
    $pendingrcmd    = $recommendClass->pendingrecommend();
    $approvedrcmd   = $recommendClass->approvedrecommend();
    $pendingaction  = $actionClass->pendingaction();
    $approvedaction = $actionClass->approvedaction();
}
//

$ctme=date('Y-m-d H:i:s');
$i=1;
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
                
<style>
    
    .form-group{
        margin: 0 auto;
    }
    .appstatus{
        font-size: 12px;
    }
    label.error{
        color: #f00;
        font-weight: 600;
        font-size: 12px;
    }
    .btn.icon {
    padding: .0rem .3rem !important;

    }
    .approvaltext{
        font-size: 9px;
        font-weight: 700;
    }
    .dropdown-item:hover{
        background-color: #2e54bc;
        color:#fff;
    }
    .dropdown-menu {
        min-width: 7em;
        box-shadow: 0 0 30px rgb(26 3 3 / 18%);
    }
    .btn-group-sm>.btn, .btn-sm {
        border-radius: 0.2rem;
        font-size: 0.75rem;
        padding: 0.2rem 0.4rem;
    }
    .table-buss {
        border-collapse: collapse;
    }
    .table-buss th {
        font-size: 12px;
        font-weight: 700;
        color: #fff;
        background: #02338d;
        padding: 3px 5px;
        white-space: nowrap;
        text-align: center;
        vertical-align: middle;
        border: 1px solid rgba(255,255,255,0.3);
    }
    .table-buss td {
        font-size: 12px;
        font-weight: 500;
        color: #222;
        padding: 2px 5px;
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
        border: 1px solid #b8c8de;
    }
    .table-buss tbody tr:hover td {
        background: #eef4ff;
    }
    /* ── DataTable top bar ── */
    .datatable-top {
        padding: 2px 4px !important;
        font-size: 10px !important;
    }
    .datatable-top .datatable-selector {
        font-size: 10px !important;
        padding: 1px 3px !important;
        height: auto !important;
        width: 50px !important;
    }
    .datatable-top .datatable-search input {
        font-size: 10px !important;
        padding: 1px 5px !important;
        height: 22px !important;
        width: 120px !important;
    }
    /* ── Nav-tabs — bussinf theme ── */
    #myTab {
        background: #02338d;
        border-bottom: 2px solid #012a73;
        padding: 5px 6px 0;
        gap: 3px;
        border-radius: 6px 6px 0 0;
    }
    #myTab .nav-link {
        display: flex;
        flex-direction: row;
        align-items: center;
        padding: 13px 14px;
        margin: 3px 2px 0;
        border-radius: 8px 8px 0 0 !important;
        border: 1px solid rgba(255,255,255,0.15) !important;
        border-bottom: 3px solid transparent !important;
        background: rgba(255,255,255,0.08);
        color: #cde0ff;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.18s, color 0.18s, border-color 0.18s, box-shadow 0.18s;
    }
    #myTab .nav-link:hover {
        background: rgba(255,255,255,0.18);
        color: #fff;
        border-bottom-color: #a8c8ff !important;
    }
    #myTab .nav-link.active {
        background: #0554e9 !important;
        color: #fff !important;
        font-size: 13px;
        font-weight: 700;
        border-bottom: 3px solid #ffc107 !important;
        box-shadow: 0 3px 10px rgba(0,0,0,0.25);
    }
 </style>

<div class="page-heading">
    <h4>INBOX</h4>
</div>
    <div class="page-content">
        <section class="row">
            <div class="col-12">
    <!-_________________Content location BEGINING______________________->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title"></h5>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="risk-tab" data-bs-toggle="tab" href="#risk" role="tab"
                                    aria-controls="risk" aria-selected="true">
                                    Risks &nbsp;<span class="badge bg-danger"><?=$pending_risk?></span><br>
                                   <div><span class="appstatus">App:(<?=$approved_risk?>) Pend:(<?=$pending_risk?>) Rej:(<?=$rejected_risk?>) </span></div> 
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="control-tab" data-bs-toggle="tab" href="#control" role="tab"
                                    aria-controls="risk" aria-selected="true">
                                    Controls &nbsp;<span class="badge bg-danger"><?=$pendingcontrl?></span><br>
                                   <div><span class="appstatus">App:(<?=$approvedcontrl?>) Pend:(<?=$pendingcontrl?>) Rej:(<?=$rejected_risk?>) </span></div> 
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="kpi-tab" data-bs-toggle="tab" href="#kpi" role="tab"
                                        aria-controls="risk" aria-selected="true">
                                        KPIs &nbsp;<span class="badge bg-danger"><?=$pendingki?></span><br>
                                    <div><span class="appstatus">App:(<?=$approvedki?>) Pend:(<?=$pendingki?>) Rej:(<?=$rejected_risk?>) </span></div> 
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="recommend-tab" data-bs-toggle="tab" href="#recommend" role="tab"
                                        aria-controls="risk" aria-selected="true">
                                        Recommendation &nbsp;<span class="badge bg-danger"><?=$pendingrcmd?></span><br>
                                    <div><span class="appstatus">App:(<?=$approvedrcmd?>) Pend:(<?=$pendingrcmd?>) Rej:(<?=$rejected_risk?>) </span></div> 
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="action-tab" data-bs-toggle="tab" href="#action" role="tab"
                                        aria-controls="risk" aria-selected="true">
                                        Action &nbsp;<span class="badge bg-danger"><?=$pendingaction?></span><br>
                                        <div><span class="appstatus">App:(<?=$approvedaction?>) Pend:(<?=$pendingaction?>) Rej:(<?=$rejected_risk?>) </span></div> 
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="risk" role="tabpanel" aria-labelledby="risk-tab">
                                <div class="table-responsive">
                                <table class="table table-striped table-buss" id="table1">
                                    <thead id="thead">
                                        <tr>
                                            <th>Reference</th>
                                            <th>Department</th>
                                            <th>Inherent Risk</th>
                                            <th>Risk category</th>
                                            <th>user</th>
                                            <th>created at</th>
                                            <th>status</th>
                                            <th>Approval</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (is_array($showRisk) || is_object($showRisk))//used when the array is blank
                                        {
                                            foreach($showRisk as $values){
                                                $timestamp=strtotime( $values["created_at"]);
                                                $date=date('d-m-Y', $timestamp);
                                                $uid=$values["userid"];
                                                $username=$userclass->userjoin($uid);
                                                

                                                $risk=substr($values["risk_name"], 0 , 80);
                                                $rcatid=$values["rcat"];
                                                $riskcatname=$riskCatClass->riskcatJoins($rcatid);

                                                $deptid=$values["dept"];
                                                $deptname=ucfirst($deptClass->deptJoins($deptid));

                                                $pid=$values["process"];
                                                $processname=ucfirst($processClass->processJoins($pid));
                                                $approval= $values["approval"];
                                                
                                                ?>


                                                <tr>
                                                <td><?='RSK0'.$values["risk_id"]?></td>
                                                <td><?=$deptname?></td>
                                                <td>
                                                    <div style="font-size:13px;">
                                                    <?=$risk?>
                                                    </div>
                                                </td>
                                                <td><?=$riskcatname?></td>                                                
                                                <td><?=$username?></td>
                                                <td><?=$date?></td>
                                                <td>
                                                    <?php
                                                    if($approval==1){
                                                        echo'<button class="btn icon btn-secondary"><i class="approvaltext">Pending</i></button>';
                                                    }elseif($approval==2){
                                                        echo'<button class="btn icon btn-info"><i class="approvaltext">Approved</i></button>';
                                                    }elseif($approval==3){
                                                        echo'<button class="btn icon btn-success"><i class="approvaltext">Ammend</i></button>';
                                                    }
                                                    ?>
                                                </td>
                                                <td> 
                                                    <?php if($approval==2){}else{?>
                                                    <div class="btn-group me-1 mb-1">
                                                        <div class="dropdown">
                                                            <button type="button" href="" class="btn btn-primary btn-sm dropdown-toggle"
                                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Action
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a class="dropdown-item approverisk" id="<?=$values["risk_id"]?>" href="#">Approve</a>
                                                                <a class='dropdown-item rejectrisk' id='<?=$values["risk_id"]?>' href=''>Ammend</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>

                                            <?php
                                            
                                            }                                        
                                        }
                                        ?>
                                            
                                    </tbody>
                                </table>
                                </div><!-- table-responsive -->
                            </div>
                            <div class="tab-pane fade" id="control" role="tabpanel" aria-labelledby="control-tab">
                                <div class="table-responsive">
                                <table class="table table-striped table-buss" id="table3">
                                    <thead id="thead">
                                        <tr>
                                            <th>Reference</th>
                                            <th>Control</th>
                                            <th>Control Strength</th>
                                            <th>Control Type</th>
                                            <th>Reviewer</th> 
                                            <th>Approval</th> 
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                         foreach($showcontrol as $control){
                                        // $rid=$control["risk"];
                                            //$riskname=substr($riskClass->Riskjoin($rid), 0 , 60);
                                            
                                            $csid=$control["cstrength"];
                                            $csname=$cstrengthClass->strengthjoin($csid);
                                            
                                            $ctid=$control["ctype"];
                                            $ctname=$ctypeclass->ctypejoin($ctid);

                                            $uid=$control["reviewer"];
                                            $uname=$userclass->userjoin($uid);
                                            $controlname= substr($control["controls"], 0 , 60);
                                            $approval=$control["approval"];
                                            
                                        ?>
                                                <tr>
                                                <td><?='CTL00'.$control["control_id"]?></td>
                                                <td><?=$controlname?></td>
                                                <td><?=$csname?></td>
                                                <td><?=$ctname?></td>
                                                <td><?=$uname?></td>
                                                <td> 
                                                    <?php
                                                    if($approval==1){
                                                        echo'<button class="btn icon btn-secondary"><i class="approvaltext">Pending</i></button>';
                                                    }elseif($approval==2){
                                                        echo'<button class="btn icon btn-info"><i class="approvaltext">Approved</i></button>';
                                                    }elseif($approval==3){
                                                        echo'<button class="btn icon btn-success"><i class="approvaltext">Ammend</i></button>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                <?php if($approval==2){}else{?>
                                                    <div class="btn-group me-1 mb-1">
                                                        <div class="dropdown">
                                                            <button type="button" href="" class="btn btn-primary btn-sm dropdown-toggle"
                                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Action
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a class="dropdown-item approvecontrol" id="<?=$control["control_id"]?>" href="#">Approve</a>
                                                                <a class='dropdown-item ammendcontrol' id='<?=$control["control_id"]?>' href="#">Ammend</a>
                                                           </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php } 
                                            ?>
                                                
                                    </tbody>
                                </table>
                                </div><!-- table-responsive -->
                            </div>
                            <div class="tab-pane fade" id="kpi" role="tabpanel" aria-labelledby="kpi-tab">
                                <div class="table-responsive">
                                <table class="table table-striped table-buss" id="table2">
                                    <thead id="thead">
                                        <tr>
                                            <th>Ref</th>
                                            <th>Risk</th>
                                            <th>Key Performance Indicator(KPI)</th>
                                            <th>user</th>
                                            <th>created at</th>
                                            <th>status</th>
                                            <th>Approval</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                    <?php
                                    foreach($showki as $ki){
                                        $rid=$ki["risk_id"];
                                        $kirisk=$riskClass->Riskjoin($rid);
                                        //ki username of ki creator
                                        $uid=$ki["uid"];
                                        $kiuser=$userclass->userjoin($uid);
                                    ?>    
                                        <tr>
                                            <td><?='KI00'.$ki["id"];?></td>
                                            <td><?=$kirisk?></td>
                                            <td><?=$ki["ki"]?></td>
                                            <td><?=$kiuser?></td>
                                            <td><?=$ki["created_at"]?></td>
                                            <td>
                                                <?php
                                                    if($ki["approval"]==1){
                                                        echo'<button class="btn icon btn-secondary"><i class="approvaltext">Pending</i></button>';
                                                    }elseif($ki["approval"]==2){
                                                        echo'<button class="btn icon btn-info"><i class="approvaltext">Approved</i></button>';
                                                    }elseif($ki["approval"]==3){
                                                        echo'<button class="btn icon btn-success"><i class="approvaltext">Ammend</i></button>';
                                                    }
                                                ?>
                                            </td>
                                            <td> 
                                                <?php if($ki["approval"]==2){}else{?>
                                                <div class="btn-group me-1 mb-1">
                                                    <div class="dropdown">
                                                        <button type="button" href="" class="btn btn-primary btn-sm dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item approveki" id="<?=$ki["id"]?>" href="#">Approve</a>
                                                            <a class='dropdown-item ammendki' href='' id='<?=$ki["id"]?>'>Ammend</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>    
                                            </td>
                                        </tr>
                                        <?php
                                            }
                                        ?>
                
                                    </tbody>
                                </table>
                                </div><!-- table-responsive -->
                            </div>
                            <div class="tab-pane fade" id="recommend" role="tabpanel" aria-labelledby="recommend-tab">
                                <div class="table-responsive">
                                <table class="table table-striped table-buss" id="table4">
                                    <thead id="thead">
                                        <tr>
                                            <th>reference id</th>
                                            <th>Risk</th>
                                            <th>MRC(Management Risk Committee)</th>
                                            <th>ARMC(Audit Risk Management Committee)</th>
                                            <th>Timeline</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                       foreach($showrecommend as $recommend){
                                        $rid=$recommend["risk_id"];
                                        $riskname=$riskClass->Riskjoin($rid);
                                        
                                        $approval=$recommend["approval"];
                                       /*  $deptid=$recommend["dept_id"];
                                        $deptname=$deptClass->deptJoins($deptid);

                                        

                                        $aid=$recommend["action"];
                                        $actionname=$actionclass->actionJoins($aid);
                                        
                                        */

                                        ?>

                                        <tr>
                                            <td><?='RCMD'.$recommend["id"]?></td>
                                            <td><?=$riskname?></td>
                                            <td><?=$recommend["mrc"]?></td>
                                            <td><?=$recommend["armc"]?></td>
                                            <td><?=$recommend["timeline"]?></td>
                                            <td> 
                                                <?php
                                                        if($approval==1){
                                                            echo'<button class="btn icon btn-secondary"><i class="approvaltext">Pending</i></button>';
                                                        }elseif($approval==2){
                                                            echo'<button class="btn icon btn-info"><i class="approvaltext">Approved</i></button>';
                                                        }elseif($approval==3){
                                                            echo'<button class="btn icon btn-success"><i class="approvaltext">Ammend</i></button>';
                                                        }
                                                        ?>
                                                    </td>
                                            <td>
                                              <?php if($approval==2){}else{?>
                                                <div class="btn-group me-1 mb-1">
                                                    <div class="dropdown">
                                                        <button type="button" href="" class="btn btn-primary btn-sm dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item approverecommend" id="<?=$recommend["id"]?>" href="#">Approve</a>
                                                            <a class='dropdown-item ammendrecommend' id='<?=$recommend["id"]?>' href=''>Ammend</a>
                                                        </div>
                                                    </div>
                                                </div>
                                              <?php }?>  
                                            </td>
                                        </tr>
                                        <?php
                                            }
                                        
                                        ?>
                                    </tbody>
                                </table>
                                </div><!-- table-responsive -->
                            </div>
                            <div class="tab-pane fade" id="action" role="tabpanel" aria-labelledby="action-tab">
                                <div class="table-responsive">
                                <table class="table table-striped table-buss" id="table5">
                                    <thead id="thead">
                                        <tr>
                                            <th>reference id</th>
                                            <th>process</th>
                                            <th>Risk</th>
                                            <th>Action</th>
                                            <th>Timeline</th>
                                            <th>Priority</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    foreach($showaction as $action){

                                    $pid=$action["process_id"];
                                    $processname=$processClass->processJoins($pid);

                                    $rid=$action["risk_id"];
                                    $riskname=$riskClass->Riskjoin($rid);
                                    $approval=$action["approval"];
                                    
                                        ?>

                                    <tr>
                                            <td><?='ACT00'.$action["id"]?></td>
                                            <td><?=$processname?></td>
                                            <td><?=$riskname?></td>
                                            <td><?=$action["action"]?></td>
                                            <td><?=$action["timeline"]?></td>
                                            <td><?=$action["priority"]?></td>
                                            <td>
                                            <?php
                                                if($approval==1){
                                                    echo'<button class="btn icon btn-secondary"><i class="approvaltext">Pending</i></button>';
                                                }elseif($approval==2){
                                                    echo'<button class="btn icon btn-info"><i class="approvaltext">Approved</i></button>';
                                                }elseif($approval==3){
                                                    echo'<button class="btn icon btn-success"><i class="approvaltext">Ammend</i></button>';
                                                }
                                            ?>
                                            </td>
                                            <td>
                                                <?php if($approval==2){}else{?>
                                                <div class="btn-group me-1 mb-1">
                                                    <div class="dropdown">
                                                        <button type="button" href="" class="btn btn-primary btn-sm dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item approveaction" id="<?=$action["id"]?>" href="#">Approve</a>
                                                            <a class='dropdown-item ammendaction' id='<?=$action["id"]?>' href=''>Ammend</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php }
                                        ?>
                                    </tbody>
                                </table>
                                </div><!-- table-responsive -->
                            </div>
                        </div>
                    </div>
                </div>                        


    <!-_________________Content location END______________________->
                
            </div>
        </section>
    </div>

  </div>





 <!-_________________Footer location______________________->

        <?php include_once'../layout/footer.php'; ?>
        
        </div>
        
    </div>

  <!-----------------------------------approval Risk Modals ---------------------------------------------------------------->
        <div class="modal fade text-left" id="approverisk-modal" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel120" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                    role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h3 class="modal-title white" id="myModalLabel120">Do  you want to Approve Risk?
                            </h3>
                            <button type="button" class="close" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <form id="approveriskform">
                        <div class="modal-body">
                        <div>
                            <input type="hidden" name="dcid" id="dcid" value="">
                            
                            <div id="messagedelete"></div>
                        <div style="color:#000;font-weight:600;font-size:29px;text-align:center;">Inherent Risk:<h5 id="dcname"></h5></div>
                        </div>
                        </div>
                        <div class="modal-footer">
                            
                            <button type="button" class="btn btn-danger"
                                data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="button" class="approverisk-btn btn btn-info ml-1"
                                data-bs-dismiss="modal">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Approve</span>
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
  <!-----------------------------------Ammend Risk approval Modal ---------------------------------------------------------------->
  <div class="modal fade text-left" id="rejectrisk-modal" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel120" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                    role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-success">
                            <h3 class="modal-title white" id="myModalLabel120">Please Ammend this Risk?
                            </h3>
                            <button type="button" class="close" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <form id="rejectriskform">
                        <div class="modal-body">
                        <div>
                            <input type="hidden" name="rejrid" id="rejrid" value="">
                            
                            <div id="messagedelete"></div>
                        <div style="color:#000;font-weight:600;font-size:29px;text-align:center;">Inherent Risk:<h5 id="rejname"></h5></div>
                        </div>
                        </div>
                        <div class="modal-footer">
                            
                            <button type="button" class="btn btn-light-secondary"
                                data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="button" class="rejectrisk-btn btn btn-success ml-1"
                                data-bs-dismiss="modal">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Ammend</span>
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

 <!-------------------------------------end of approval---------------------------------------------------------------------------->               
 

<!-----------------------------------approval control Modals ---------------------------------------------------------------->
        <div class="modal fade text-left" id="approvecontrol-modal" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel120" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                    role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h3 class="modal-title white" id="myModalLabel120">Do  you want to Approve This Control?
                            </h3>
                            <button type="button" class="close" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <form id="approvecontrolform">
                        <div class="modal-body">
                        <div>
                            <input type="hidden" name="controlid" id="controlid" value="">
                            
                            <div id="messagedelete"></div>
                        <div style="color:#000;font-weight:600;font-size:29px;text-align:center;">Control:<h5 id="controlname"></h5></div>
                        </div>
                        </div>
                        <div class="modal-footer">
                            
                            <button type="button" class="btn btn-danger"
                                data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="button" class="approvecontrol-btn btn btn-info ml-1"
                                data-bs-dismiss="modal">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Approve</span>
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

  <!-----------------------------------Ammend Action approval Modal ---------------------------------------------------------------->
        <div class="modal fade text-left" id="ammendcontrol-modal" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel120" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                    role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-success">
                            <h3 class="modal-title white" id="myModalLabel120">Please Ammend this control?
                            </h3>
                            <button type="button" class="close" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <form id="ammendcontrolform">
                        <div class="modal-body">
                        <div>
                            <input type="hidden" name="acid" id="acid" value="">
                            
                            <div id="messagedelete"></div>
                        <div style="color:#000;font-weight:600;font-size:29px;text-align:center;">Please Ammend this Control:<h5 id="acname"></h5></div>
                        </div>
                        </div>
                        <div class="modal-footer">
                            
                            <button type="button" class="btn btn-light-secondary"
                                data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="button" class="ammendcontrol-btn btn btn-success ml-1"
                                data-bs-dismiss="modal">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Ammend</span>
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
 <!-------------------------------------end of approval---------------------------------------------------------------------------->               
 

 <!-----------------------------------approval ki Modals ---------------------------------------------------------------->
        <div class="modal fade text-left" id="approveki-modal" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel120" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                    role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h3 class="modal-title white" id="myModalLabel120">Do  you want to Approve This KPI?
                            </h3>
                            <button type="button" class="close" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <form id="approvekiform">
                        <div class="modal-body">
                        <div>
                            <input type="hidden" name="kiid" id="kiid" value="">
                            
                            <div id="messagedelete"></div>
                        <div style="color:#000;font-weight:600;font-size:29px;text-align:center;">Key Indicator:<h5 id="kiname"></h5></div>
                        </div>
                        </div>
                        <div class="modal-footer">
                            
                            <button type="button" class="btn btn-danger"
                                data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="button" class="approveki-btn btn btn-info ml-1"
                                data-bs-dismiss="modal">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Approve</span>
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
  <!-----------------------------------Ammend ki Modal ---------------------------------------------------------------->
        <div class="modal fade text-left" id="ammendki-modal" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel120" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                    role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-success">
                            <h3 class="modal-title white" id="myModalLabel120">Please Ammend this key indicator?
                            </h3>
                            <button type="button" class="close" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <form id="kiammendform">
                        <div class="modal-body">
                        <div>
                            <input type="hidden" name="akiid" id="akiid" value="">
                            
                            <div id="messagedelete"></div>
                        <div style="color:#000;font-weight:600;font-size:29px;text-align:center;">Key Indicator:<h5 id="akiname"></h5></div>
                        </div>
                        </div>
                        <div class="modal-footer">
                            
                            <button type="button" class="btn btn-light-secondary"
                                data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="button" class="ammendki-btn btn btn-success ml-1"
                                data-bs-dismiss="modal">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Ammend</span>
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
 <!-------------------------------------end of approval---------------------------------------------------------------------------->               
 
 <!-----------------------------------approval recommend Modals ---------------------------------------------------------------->
        <div class="modal fade text-left" id="approverecommend-modal" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel120" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                    role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h3 class="modal-title white" id="myModalLabel120">Do  you want to Approve This Recommendation?
                            </h3>
                            <button type="button" class="close" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <form id="approverecommendform">
                        <div class="modal-body">
                        <div>
                            <input type="hidden" name="rcmdid" id="rcmdid" value="">
                            
                            <div id="messagedelete"></div>
                        <div style="color:#000;font-weight:600;font-size:29px;text-align:center;">MRC(Management Risk Committee):<h5 id="mrcname"></h5></div>
                        <div style="color:#000;font-weight:600;font-size:29px;text-align:center;">ARMC(Audit Risk Management Committee):<h5 id="armcname"></h5></div>
                        </div>
                        </div>
                        <div class="modal-footer">
                            
                            <button type="button" class="btn btn-danger"
                                data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="button" class="approverecommend-btn btn btn-info ml-1"
                                data-bs-dismiss="modal">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Approve</span>
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
  <!-----------------------------------Ammend recommend Modal ---------------------------------------------------------------->
        <div class="modal fade text-left" id="ammendrecommend-modal" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel120" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                    role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-success">
                            <h3 class="modal-title white" id="myModalLabel120">Please Ammend this recomendation?
                            </h3>
                            <button type="button" class="close" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <form id="ammendrecommendform">
                        <div class="modal-body">
                        <div>
                            <input type="hidden" name="arid" id="arid" value="">
                            
                            <div id="messagedelete"></div>
                            <div style="color:#000;font-weight:600;font-size:29px;text-align:center;">MRC(Management Risk Committee):<h5 id="ammendmrc"></h5></div>
                            <div style="color:#000;font-weight:600;font-size:29px;text-align:center;">ARMC(Audit Risk Management Committee):<h5 id="ammendarmc"></h5></div>
                        </div>
                        </div>
                        <div class="modal-footer">
                            
                            <button type="button" class="btn btn-light-secondary"
                                data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="button" class="ammendrecommend-btn btn btn-success ml-1"
                                data-bs-dismiss="modal">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Ammend</span>
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
 <!-------------------------------------end of approval---------------------------------------------------------------------------->               
 <!-----------------------------------approval action Modals ---------------------------------------------------------------->
 <div class="modal fade text-left" id="approveaction-modal" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel120" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                    role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h3 class="modal-title white" id="myModalLabel120">Do  you want to Approve This Action?
                            </h3>
                            <button type="button" class="close" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <form id="approveactionform">
                        <div class="modal-body">
                        <div>
                            <input type="hidden" name="aid" id="aid" value="">
                            
                            <div id="messagedelete"></div>
                        <div style="color:#000;font-weight:600;font-size:29px;text-align:center;">Actions:<h5 id="aname"></h5></div>
                        </div>
                        </div>
                        <div class="modal-footer">
                            
                            <button type="button" class="btn btn-danger"
                                data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="button" class="approveaction-btn btn btn-info ml-1"
                                data-bs-dismiss="modal">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Approve</span>
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
  <!-----------------------------------Ammend recommend Modal ---------------------------------------------------------------->
        <div class="modal fade text-left" id="ammendaction-modal" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel120" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                    role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-success">
                            <h3 class="modal-title white" id="myModalLabel120">Please Ammend this Risk?
                            </h3>
                            <button type="button" class="close" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <form id="ammendactionform">
                        <div class="modal-body">
                        <div>
                            <input type="hidden" name="aaid" id="aaid" value="">
                            
                            <div id="messagedelete"></div>
                        <div style="color:#000;font-weight:600;font-size:29px;text-align:center;">Action:<h5 id="aaname"></h5></div>
                        </div>
                        </div>
                        <div class="modal-footer">
                            
                            <button type="button" class="btn btn-light-secondary"
                                data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="button" class="ammendaction-btn btn btn-success ml-1"
                                data-bs-dismiss="modal">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Ammend</span>
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
 <!-------------------------------------end of approval---------------------------------------------------------------------------->               
 
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
  <!----------------------Datatable Simple------------------------------------------------>
    <script src="../assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        let table2 = document.querySelector('#table2');
        let table3 = document.querySelector('#table3');
        let table4 = document.querySelector('#table4');
        let table5 = document.querySelector('#table5');

        if (table1) new simpleDatatables.DataTable(table1);
        if (table2) new simpleDatatables.DataTable(table2);
        if (table3) new simpleDatatables.DataTable(table3);
        if (table4) new simpleDatatables.DataTable(table4);
        if (table5) new simpleDatatables.DataTable(table5);
    </script>

<!------------------------------SWEET ALERTS---------------------------------->
<script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>

<!-- Include Choices JavaScript -->
<script src="../assets/vendors/choices.js/choices.min.js"></script>
<script src="../assets/js/pages/form-element-select.js"></script>

<!----------------------Datatable Simple end------------------------------------------------>

    <script src="../assets/js/pages/horizontal-layout.js"></script>

<!----------------------font awsome------------------------------------------------>
    <script src="../assets/vendors/fontawesome/all.min.js"></script>

<!---------------------------------------toastify----------------------------------->    
    <script src="../assets/vendors/toastify/toastify.js"></script>
    <script src="../assets/js/extensions/toastify.js"></script>

   


</body>

</html>
