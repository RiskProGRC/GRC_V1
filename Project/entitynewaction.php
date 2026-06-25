<?php
require_once __DIR__ . '/core/AuthGuard.php'; // session gate; $uid, $ip, $sdid from session
$deptid = (int)($_POST['deptid'] ?? 0);
include_once '../Project/connection/connect.php';
include_once'../Project/users/usersClass.php';
include_once'../Project/company/companyClass.php';
include_once'../Project/department/departmentClass.php';
include_once'../Project/settings/riskcategoryClass.php';
include_once'../Project/settings/controlstrengthClass.php';
include_once'../Project/settings/controltypeClass.php';
include_once'../Project/risk/riskClass.php';
include_once'../Project/department/departmentClass.php';
include_once'../Project/process/processClass.php';
include_once'../Project/control/controlClass.php';
include_once'../Project/recommend/recommendClass.php';
include_once'../Project/action/actionClass.php';
include_once'../Project/company/companyClass.php';

$companyClass=new companyClass();

$userClass= new usersClass();
$departmentClass=new departmentClass();

$sdept=$departmentClass->showDeptentity($deptid);
//controlClass=new controlClass();
foreach($sdept as $selectdept){

$uid=$selectdept["owners"];
$ownername=$userClass->userjoin($uid);

$cid= $selectdept["company"];
$cname= $companyClass->companyJoins($cid);

$function=$selectdept["functions"];

}


$companyClass=new companyClass();
$showcompany=$companyClass->showCompany();

$controlclass= new controlClass();
$showcontrol=$controlclass->showriskcontrol($deptid);
//risk code
$rselect=mysqli_query($con,"SELECT risk.risk_id,risk.process,risk.risk_name,risk.nominee,risk.cause,risk.rdate,riskcat.name,risk.reviewer
     FROM risk
     INNER JOIN riskcat 
        ON risk.rcat=riskcat.riskcat_id
     WHERE dept='$deptid'");
//Key indicator code
$kiselect=mysqli_query($con,"SELECT ki.id,ki.risk_id,ki.ki,ki.process_id,ki.owner,risk.risk_name
    FROM ki
    INNER JOIN risk
        ON ki.risk_id=risk.risk_id
    WHERE dept_id='$deptid'
    ORDER BY ki.risk_id ASC");

 //Control Code
 /*$cselect=mysqli_query($con,"SELECT control.risk,control.control,control.control_id,control.process_id,control.cstrength,control.ctype,control.reviewer,
 risk.risk_name,control_strength.cs_name,control_type.ct_name
 FROM control_risk
 INNER JOIN control
     ON control_id=
 INNER JOIN risk
     ON control.risk=risk.risk_id
 INNER JOIN control_strength
     ON control.cstrength=control_strength.strength_id
 INNER JOIN control_type
     ON control.ctype=control_type.ctype_id
 WHERE dept_id='$deptid'
 ORDER BY control.risk ASC");   */
 $cselect=mysqli_query($con, "SELECT control_id,risk_id FROM risk_control WHERE dept_id='$deptid'");

 //Recomend
 $rmd=mysqli_query($con,"SELECT recommend.risk_id,recommend.id,recommend.mrc,recommend.armc,recommend.action,recommend.status,recommend.risk_id,recommend.timeline,
 risk.risk_name
 FROM recommend
 INNER JOIN risk
     ON recommend.risk_id=risk.risk_id
 WHERE dept_id='$deptid'
 ORDER BY recommend.risk_id ASC");  
 
 //action
 $aselect=mysqli_query($con,"SELECT action.id,action.risk_id,action.action,action.process_id,action.priority,action.status,action.timeline,
 risk.risk_name
 FROM action
 INNER JOIN risk
     ON action.risk_id=risk.risk_id
 WHERE dept_id='$deptid'
 ORDER BY action.risk_id ASC");


if($deptid){ ?>

    <!---beginning of form--------->
        <div class="row">   
            
            <div class="col-3">
                <input type="text" class="form-control details" value="<?=$cname?>" placeholder="Company" disabled>
            </div>
            <div class="col-6">
                <textarea class="form-control details" id="exampleFormControlTextarea1" rows="2" disabled><?=$function?></textarea>
            </div>
            <div class="col-3">
             <input type="text" class="form-control details" id="" value="<?=$ownername?>" placeholder="risk owner" disabled>
            </div>
            <hr/>

            <div class="col-12">
                <div class="list-group list-group-horizontal-sm mb-1 text-center" role="tablist">
                    <a class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill"
                        href="#risk" role="tab" aria-controls="v-pills-group"
                        aria-selected="true"><i class="fa fa-archive" aria-hidden="true"></i> <span>Risks</span><button class="btn btn-success btn-md addentrisk" id="" >Add</button> </a>
                    <a class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill"
                        href="#kpi" role="tab" aria-controls="v-pills-Company"
                        aria-selected="false"><i class="fa fa-cogs" aria-hidden="true"></i> <span>KPIs</span>  <button class="btn btn-success btn-md addentki" id="">Add</button> </a>
                    <a class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill"
                        href="#control" role="tab" aria-controls="v-pills-messages"
                        aria-selected="false"><i class="fa fa-calculator" aria-hidden="true"></i> <span>Controls</span>  <button class="btn btn-success btn-md addentcontrol" id="">Add</button> </a>
                    <a class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill"
                        href="#recommend" role="tab" aria-controls="v-pills-settings"
                        aria-selected="false"><i class="fa fa-bookmark" aria-hidden="true"></i> <span>Recommend</span>  <button class="btn btn-success btn-md addentrecommend" id="">Add</button> </a>
                    <a class="nav-link" id="v-pills-users-tab" data-bs-toggle="pill"
                        href="#action" role="tab" aria-controls="v-pills-settings"
                        aria-selected="false"><i class="fa fa-magnet" aria-hidden="true"></i>  <span>Actions</span>  <button class="btn btn-success btn-md addentaction" id="">Add</button> </a>
                </div>
            </div>
            <div class="col-12">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="risk" role="tabpanel"
                        aria-labelledby="v-pills-group-tab">
                        <div class="overflow"> 
                            <!--------------------------begin of risk------------------------------------------->
                            <table class="table table-striped table-bordered" id="table1">
                                <thead id="thead">
                                    <tr>
                                        <th>Reference</th>
                                        <th>Process</th>
                                        <th>Inherent Risk</th>
                                        <th>Risk category</th>
                                        <th>User</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    while($rrisk=mysqli_fetch_assoc($rselect)){
                                    //process
                                    $pid=$rrisk['process'];
                                    $select=mysqli_query($con,"SELECT * FROM process WHERE process_id='$pid'");
                                    $row=mysqli_fetch_assoc($select);
                                    $process=$row["process_name"];
                                    //user
                                    $uid=$rrisk['reviewer'];
                                    $select=mysqli_query($con,"SELECT * FROM users WHERE id='$uid'");
                                    $row=mysqli_fetch_assoc($select);
                                    $user=$row["fname"].'&nbsp;'.$row["sname"];
                                    
                                    ?>
                                        <tr>
                                            <td>RSK00<?=$rrisk['risk_id']?></td>
                                            <td><?=$process?></td>
                                            <td><?=$rrisk['risk_name']?></td>
                                            <td><?=$rrisk['name']?></td>
                                            <td><?=$user?></td>
                                            <td>
                                    <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                                    </div>                          
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                        
                                </tbody>
                            </table>
                            <!--------------------------end of risk------------------------------------------->
                        </div>
                        
                    </div>
                    <div class="tab-pane fade" id="kpi" role="tabpanel"
                        aria-labelledby="v-pills-company-tab">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Risk id</th>
                                        <th>Risk</th>
                                        <th>Reference id</th>
                                        <th>Key Performance indicator</th>
                                        <th>owner</th>
                                        <th>Active</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    while($kivalue=mysqli_fetch_assoc($kiselect)){
                                    $uid=$kivalue['owner'];
                                    $select=mysqli_query($con,"SELECT * FROM users WHERE id='$uid'");
                                    $row=mysqli_fetch_assoc($select);
                                    $user=$row["fname"].'&nbsp;'.$row["sname"];

                                    ?>
                                        <tr>
                                            <td>Rsk00<?=$kivalue['risk_id']?></td>
                                            <td><?=$kivalue['risk_name']?></td>
                                            <td>KI00<?=$kivalue['id']?></td>
                                            <td><?=$kivalue['ki']?></td>
                                            <td><?=$user?></td>
                                            <td>
                                    <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                                    </div>                          
                                            </td>
                                            <?php
                                    }
                                    ?></tr>
                                        
                                        
                                </tbody>
                                

                            </table>

                    </div>
                    <div class="tab-pane fade" id="control" role="tabpanel"
                        aria-labelledby="v-pills-entity-tab">
                            <div class="overflow"> 
                                <!--------------------------start of entity------------------------------------------->
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Risk id</th>
                                            <th>Risk</th>
                                            <th>Control id</th>
                                            <th>Control Name</th>
                                            <th>Control Strength</th>
                                            <th>Reviewer</th>
                                            <th>status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    while($control=mysqli_fetch_assoc($cselect)){
                                    //process
                                    /*$pid=$control['process_id'];
                                    $select=mysqli_query($con,"SELECT * FROM process WHERE process_id='$pid'");
                                    $row=mysqli_fetch_assoc($select);
                                    $process=$row["process_name"];*/
                                    
                                    $cid=$control['control_id'];
                                    $select=$db->query("SELECT * FROM control WHERE control_id='$cid'");
                                    $crow=$select->fetch_assoc();
                                    $text=$crow["controls"];                                    
                                    $cstrength=$crow["cstrength"];

                                    //user
                                    $uid=$crow['reviewer'];
                                    $select=mysqli_query($con,"SELECT * FROM users WHERE id='$uid'");
                                    $row=mysqli_fetch_assoc($select);
                                    $user=$row["fname"].'&nbsp;'.$row["sname"];

                                    $select=$db->query("SELECT * FROM control_strength WHERE strength_id='$cstrength'");
                                    $csrow=$select->fetch_assoc();
                                    $strength=$csrow["cs_name"];


                                    $rid=$control['risk_id'];
                                    $select=$db->query("SELECT * FROM risk WHERE risk_id='$rid'");
                                    $rrow=$select->fetch_assoc();
                                    $riskname=$rrow["risk_name"];


                                    ?>
                                        <tr>
                                            <td>RSK00<?=$rid?></td>
                                            <td><?=$riskname?></td>
                                            <td>C00<?=$cid?></td>
                                            <td><?=$controlname=$controlclass->paragraph($text);?></td>
                                            <td><?=$strength?></td>
                                            <td><?=$user?></td>
                                            <td>
                                    <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                                    </div>                          
                                            </td>
                                        </tr>
                                        
                                        <?php
                                        }
                                    ?>   
                                    </tbody>
                                    

                                </table>
                                <!--------------------------End of entity------------------------------------------->
                            </div>    
                    </div>
                    <div class="tab-pane fade" id="recommend" role="tabpanel"
                        aria-labelledby="v-pills-recommend-tab">
                            <div class="overflow">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Risk id</th>
                                            <th>Risk</th>
                                            <th>Reference id</th>
                                            <th>MRC</th>
                                            <th>ARMC</th>
                                            <th>Action</th>
                                            <th>status</th>
                                            <th>Timeline</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while($recommend=mysqli_fetch_assoc($rmd)){
                                            $aid=$recommend['action'];
                                            $select=mysqli_query($con,"SELECT * FROM action WHERE id='$aid'");
                                            $row=mysqli_fetch_assoc($select);
                                            $action=$row["action"];
                                            ?>
                                                <tr>
                                                    <td>Rsk00<?=$recommend['risk_id']?></td>
                                                    <td><?=$recommend['risk_name']?></td>
                                                    <td>RMD00<?=$recommend['id']?></td>
                                                    <td><?=$recommend['mrc']?></td>
                                                    <td><?=$recommend['armc']?></td>
                                                    <td><?=$action?></td>
                                                    <td><?=$recommend['status']?></td>
                                                    <td><?=$recommend['timeline']?></td>                                                        
                                                    
                                                </tr>
                                                <?php
                                        }
                                        ?> 
                                    </tbody>
                                </table>
                            </div>
                    </div>
                    <div class="tab-pane fade" id="action" role="tabpanel"
                        aria-labelledby="v-pills-users-tab">
                            <div class="overflow">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Risk id</th>
                                            <th>Risk</th>
                                            <th>Reference id</th>
                                            <th>Action Name</th>
                                            <th>Process</th>
                                            <th>Priority</th>
                                            <th>Status</th>
                                            <th>Timeline</th>
                                            <th>Active</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        while($action=mysqli_fetch_assoc($aselect)){
                                        //process
                                        $pid=$action['process_id'];
                                        $select=mysqli_query($con,"SELECT * FROM process WHERE process_id='$pid'");
                                        $row=mysqli_fetch_assoc($select);
                                        $process=$row["process_name"];
                                        ?>
                                            <tr>
                                                <td>Rsk00<?=$action['risk_id']?></td>
                                                <td><?=$action['risk_name']?></td>
                                                <td>ACT00<?=$action['id']?></td>
                                                <td><?=$action['action']?></td>
                                                <td><?=$process?></td>
                                                <td><?=$action['priority']?></td>
                                                <td><?=$action['timeline']?></td>
                                                <td><?=$action['status']?></td>
                                                <td>
                                        <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                                        </div>                          
                                                </td>
                                            </tr>
                                            
                                            <?php
                                            }
                                        ?>
                                    </tbody>
                                    

                                </table>
                            </div>   
                    </div>
                </div>
            </div>
        </div>
    <!---end of form--------->

<?php }else{
    echo"no values";
}
?>