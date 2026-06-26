<?php
require_once __DIR__ . '/core/AuthGuard.php'; // session gate; $uid, $ip, $sdid from session
include_once './connection/connect.php';

$deptid = (int)($_POST['deptid'] ?? 0);

if ($deptid) {
   ///Risk Code
   $rselect=mysqli_query($con,"SELECT risk.risk_id,risk.risk_name,risk.nominee,risk.cause,risk.rdate,riskcat.name,
     CONCAT(users.fname,' ',users.sname) AS reviewer_name
     FROM risk
     INNER JOIN riskcat ON risk.rcat=riskcat.riskcat_id
     INNER JOIN users ON risk.reviewer=users.id
     WHERE dept='$deptid'");

    ///Ki Code
    $kiselect=mysqli_query($con,"SELECT ki.id,ki.risk_id,ki.ki,ki.process_id,risk.risk_name,
    CONCAT(users.fname,' ',users.sname) AS owner_name
    FROM ki
    INNER JOIN risk ON ki.risk_id=risk.risk_id
    INNER JOIN users ON ki.owner=users.id
    WHERE dept_id='$deptid'
    ORDER BY ki.risk_id ASC");

     //Control Code
    $cselect=mysqli_query($con,"SELECT control.risk,control.controls,control.control_id,
    risk.risk_name,control_strength.cs_name,control_type.ct_name,
    process.process_name,
    CONCAT(users.fname,' ',users.sname) AS reviewer_name
    FROM control
    INNER JOIN risk ON control.risk=risk.risk_id
    INNER JOIN control_strength ON control.cstrength=control_strength.strength_id
    INNER JOIN control_type ON control.ctype=control_type.ctype_id
    INNER JOIN process ON control.process_id=process.process_id
    INNER JOIN users ON control.reviewer=users.id
    WHERE control.dept_id='$deptid'
    ORDER BY control.risk ASC");

    //Recomend
    $rmd=mysqli_query($con,"SELECT recommend.risk_id,recommend.id,recommend.mrc,recommend.armc,
    recommend.status,recommend.timeline,risk.risk_name,
    action.action AS action_name
    FROM recommend
    INNER JOIN risk ON recommend.risk_id=risk.risk_id
    LEFT JOIN action ON recommend.action=action.id
    WHERE dept_id='$deptid'
    ORDER BY recommend.risk_id ASC");

    //action
    $aselect=mysqli_query($con,"SELECT action.id,action.risk_id,action.action,
    action.priority,action.status,action.timeline,risk.risk_name,
    process.process_name
    FROM action
    INNER JOIN risk ON action.risk_id=risk.risk_id
    INNER JOIN process ON action.process_id=process.process_id
    WHERE action.dept_id='$deptid'
    ORDER BY action.risk_id ASC");

    
   
    $select=mysqli_query($con,"SELECT department.dept_id,department.functions,company.company_name,users.fname,users.sname
    FROM department
    INNER JOIN company ON department.company=company.id
    INNER JOIN users ON department.owners=users.id
    WHERE department.dept_id='$deptid'");

    $fetch=mysqli_num_rows($select);
    if($fetch > 0 ){
        while($row=mysqli_fetch_assoc($select)){
           // $rows[]=$row;
            
            ?>
                 <div class="col-md-4 form-group">
                    <label>Company:</label>
                    <input type="text" class="form-control" value="<?=$row["company_name"];?>" disabled>
                </div>

                <div class="col-md-4 form-group">
                    <label>Owners:</label>
                    <input type="text" class="form-control" value="<?=$row["fname"].'&nbsp;'.$row["sname"];?>" disabled>
                </div>

                <div class="col-md-4 form-group">
                    <label>Functions:</label>
                    <textarea class="form-control"  name="" id="" cols="0" rows="4" disabled><?=$row["functions"];?></textarea>
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
                                        aria-controls="contact" aria-selected="false">KPIs &nbsp;<span class="badge bg-primary"></span></a>
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
                                            <div class="table-responsive">
                                            <table class="table table-striped table-buss" id="rsktab1">
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
                                             <?php
                                             while($rrisk=mysqli_fetch_assoc($rselect)){
                                                ?>
                                                    <tr>
                                                        <td>RSK00<?=$rrisk['risk_id']?></td>
                                                        <td style="max-width:200px; white-space:normal;"><?=substr($rrisk['risk_name'],0,55).(strlen($rrisk['risk_name'])>55?'...':'')?></td>
                                                        <td style="max-width:220px; white-space:normal;"><?=substr($rrisk['cause'],0,60).(strlen($rrisk['cause'])>60?'...':'')?></td>
                                                        <td><?=$rrisk['nominee']?></td>
                                                        <td><?=$rrisk['reviewer_name']?></td>
                                                        <td><?=$rrisk['rdate']?></td>
                                                        <td><?=$rrisk['name']?></td>
                                                        <td>Approved</td>
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
                                            </div><!-- table-responsive -->
                                        </div>
                                        </div>

                                    </div>
                                </div><!--end of risk--->
                                <div class="tab-pane fade" id="ki" role="tabpanel" aria-labelledby="contact-tab">
                                    <div class="row" style="margin-top: 20px;">
                                        <div class="row col-md-12" ><!---inherent risk tab-->
                                        <div class="overflow">
                                            <div class="table-responsive">
                                            <table class="table table-striped table-buss" id="rsktab2">
                                            <thead>

                                                <tr>
                                                    <th>Risk id</th>
                                                    <th>Risk</th>
                                                    <th>Reference id</th>
                                                    <th>Key Performance indicator</th>
                                                    <th>Owner</th>
                                                    <th>Active</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                             while($kivalue=mysqli_fetch_assoc($kiselect)){
                                                ?>
                                                    <tr>
                                                        <td>Rsk00<?=$kivalue['risk_id']?></td>
                                                        <td style="max-width:200px; white-space:normal;"><?=substr($kivalue['risk_name'],0,55).(strlen($kivalue['risk_name'])>55?'...':'')?></td>
                                                        <td>KI00<?=$kivalue['id']?></td>
                                                        <td style="max-width:220px; white-space:normal;"><?=substr($kivalue['ki'],0,60).(strlen($kivalue['ki'])>60?'...':'')?></td>
                                                        <td><?=$kivalue['owner_name']?></td>
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
                                            </div><!-- table-responsive -->
                                        </div>
                                        </div>

                                    </div>
                                </div><!----end of ki--->
                                <div class="tab-pane fade" id="control" role="tabpanel" aria-labelledby="profile-tab">
                                 <div class="row" style="margin-top: 20px;">
                                        <div class="row col-md-12" ><!---inherent risk tab-->
                                        <div class="overflow">
                                            <div class="table-responsive">
                                            <table class="table table-striped table-buss" id="rsktab3">
                                            <thead>
                                                <tr>
                                                    <th>Risk id</th>
                                                    <th>Risk</th>
                                                    <th>Reference id</th>
                                                    <th>Control Name</th>
                                                    <th>Process</th>
                                                    <th>Control Strength</th>
                                                    <th>Control Type</th>
                                                    <th>Reviewer</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                             while($control=mysqli_fetch_assoc($cselect)){
                                                ?>
                                                    <tr>
                                                        <td>RSK00<?=$control['risk']?></td>
                                                        <td style="max-width:200px; white-space:normal;"><?=substr($control['risk_name'],0,55).(strlen($control['risk_name'])>55?'...':'')?></td>
                                                        <td>C00<?=$control['control_id']?></td>
                                                        <td style="max-width:220px; white-space:normal;"><?=substr($control['controls'],0,60).(strlen($control['controls'])>60?'...':'')?></td>
                                                        <td><?=$control['process_name']?></td>
                                                        <td><?=$control['cs_name']?></td>
                                                        <td><?=$control['ct_name']?></td>
                                                        <td><?=$control['reviewer_name']?></td>
                                                    </tr>
                                                    
                                                    <?php
                                                    }
                                                ?>
                                            </tbody>
                                            

                                        </table>
                                            </div><!-- table-responsive -->
                                        </div>
                                        </div>

                                    </div>
                                </div><!----end of control--->
                                <div class="tab-pane fade" id="recommend" role="tabpanel" aria-labelledby="contact-tab">
                                    <div class="row" style="margin-top: 20px;">
                                        <div class="row col-md-12" ><!---inherent risk tab-->
                                        <div class="overflow">
                                            <div class="table-responsive">
                                            <table class="table table-striped table-buss" id="rsktab4">
                                            <thead>
                                                <tr>
                                                    <th>Risk id</th>
                                                    <th>Risk</th>
                                                    <th>Reference id</th>
                                                    <th>MRC</th>
                                                    <th>ARMC</th>
                                                    <th>Action</th>
                                                    <th>Status</th>
                                                    <th>Timeline</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                             while($recommend=mysqli_fetch_assoc($rmd)){
                                                ?>
                                                    <tr>
                                                        <td>Rsk00<?=$recommend['risk_id']?></td>
                                                        <td style="max-width:200px; white-space:normal;"><?=substr($recommend['risk_name'],0,55).(strlen($recommend['risk_name'])>55?'...':'')?></td>
                                                        <td>RMD00<?=$recommend['id']?></td>
                                                        <td style="max-width:180px; white-space:normal;"><?=substr($recommend['mrc'],0,50).(strlen($recommend['mrc'])>50?'...':'')?></td>
                                                        <td style="max-width:180px; white-space:normal;"><?=substr($recommend['armc'],0,50).(strlen($recommend['armc'])>50?'...':'')?></td>
                                                        <td style="max-width:160px; white-space:normal;"><?=substr($recommend['action_name'],0,40).(strlen($recommend['action_name'])>40?'...':'')?></td>
                                                        <td><?=$recommend['status']?></td>
                                                        <td><?=$recommend['timeline']?></td>                                                        
                                                        
                                                    </tr>
                                                    <?php
                                             }
                                                ?> 
                                            </tbody>
                                            

                                        </table>
                                            </div><!-- table-responsive -->
                                        </div>
                                        </div>

                                    </div>
                                </div><!----end of recommendation--->
                                
                                <div class="tab-pane fade" id="action" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="row" style="margin-top: 20px;">
                                        <div class="row col-md-12" ><!---inherent risk tab-->
                                        <div class="overflow">
                                            <div class="table-responsive">
                                            <table class="table table-striped table-buss" id="rsktab5">
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
                                                ?>
                                                    <tr>
                                                        <td>Rsk00<?=$action['risk_id']?></td>
                                                        <td style="max-width:200px; white-space:normal;"><?=substr($action['risk_name'],0,55).(strlen($action['risk_name'])>55?'...':'')?></td>
                                                        <td>ACT00<?=$action['id']?></td>
                                                        <td style="max-width:220px; white-space:normal;"><?=substr($action['action'],0,60).(strlen($action['action'])>60?'...':'')?></td>
                                                        <td><?=$action['process_name']?></td>
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
                                            </div><!-- table-responsive -->
                                        </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
        <!-----------------------Nav TABS edits end ----------------------------------> 

        <?php

        }

    }else{
        
        echo '<input type="text" class="form-control" value="nothing found"> ';

    }
    


}

?>