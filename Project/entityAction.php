<?php
require_once __DIR__ . '/core/AuthGuard.php'; // session gate; $uid, $ip, $sdid from session
include_once './connection/connect.php';

$deptid = (int)($_POST['deptid'] ?? 0);

if ($deptid) {
   ///Risk Code
   $rselect=mysqli_query($con,"SELECT risk.risk_id,risk.risk_name,risk.nominee,risk.cause,risk.rdate,riskcat.name,risk.reviewer
     FROM risk
     INNER JOIN riskcat 
        ON risk.rcat=riskcat.riskcat_id
     WHERE dept='$deptid'");

    ///Ki Code
    $kiselect=mysqli_query($con,"SELECT ki.id,ki.risk_id,ki.ki,ki.process_id,ki.owner,risk.risk_name
    FROM ki
    INNER JOIN risk
        ON ki.risk_id=risk.risk_id
    WHERE dept_id='$deptid'
    ORDER BY ki.risk_id ASC");

     //Control Code
    $cselect=mysqli_query($con,"SELECT control.risk,control.control,control.control_id,control.process_id,control.cstrength,control.ctype,control.reviewer,
    risk.risk_name,control_strength.cs_name,control_type.ct_name
    FROM control 
    INNER JOIN risk
        ON control.risk=risk.risk_id
    INNER JOIN control_strength
        ON control.cstrength=control_strength.strength_id
    INNER JOIN control_type
        ON control.ctype=control_type.ctype_id
    WHERE dept_id='$deptid'
    ORDER BY control.risk ASC");

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

    
   
    $select=mysqli_query($con,"SELECT department.dept_id,department.function,company.company_name,users.fname,users.sname
    FROM department 
    INNER JOIN company ON department.company=company.id
    INNER JOIN users ON department.owner=users.id
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
                    <textarea class="form-control"  name="" id="" cols="0" rows="4" disabled><?=$row["function"];?></textarea>
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
                                             <?php
                                             while($rrisk=mysqli_fetch_assoc($rselect)){
                                                //user
                                                $uid=$rrisk['reviewer'];
                                                $select=mysqli_query($con,"SELECT * FROM users WHERE id='$uid'");
                                                $row=mysqli_fetch_assoc($select);
                                                $user=$row["fname"].'&nbsp;'.$row["sname"];
                                                
                                                ?>
                                                    <tr>
                                                        <td>RSK00<?=$rrisk['risk_id']?></td>
                                                        <td><?=$rrisk['risk_name']?></td>
                                                        <td><?=$rrisk['cause']?></td>
                                                        <td><?=$rrisk['nominee']?></td>
                                                        <td><?=$user?></td>
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
                                        </div>
                                        </div>
                                        
                                    </div>
                                </div><!--end of risk--->
                                <div class="tab-pane fade" id="ki" role="tabpanel" aria-labelledby="contact-tab">
                                    <div class="row" style="margin-top: 20px;">
                                        <div class="row col-md-12" ><!---inherent risk tab-->
                                        <div class="overflow">  
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
                                        </div>
                                        
                                    </div>
                                </div><!----end of ki--->
                                <div class="tab-pane fade" id="control" role="tabpanel" aria-labelledby="profile-tab">
                                 <div class="row" style="margin-top: 20px;">
                                        <div class="row col-md-12" ><!---inherent risk tab-->
                                        <div class="overflow">  
                                            <table class="table table-bordered">
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
                                                //process
                                                $pid=$control['process_id'];
                                                $select=mysqli_query($con,"SELECT * FROM process WHERE process_id='$pid'");
                                                $row=mysqli_fetch_assoc($select);
                                                $process=$row["process_name"];
                                                //user
                                                $uid=$control['reviewer'];
                                                $select=mysqli_query($con,"SELECT * FROM users WHERE id='$uid'");
                                                $row=mysqli_fetch_assoc($select);
                                                $user=$row["fname"].'&nbsp;'.$row["sname"];
                                                ?>
                                                    <tr>
                                                        <td>RSK00<?=$control['risk']?></td>
                                                        <td><?=$control['risk_name']?></td>
                                                        <td>C00<?=$control['control_id']?></td>
                                                        <td><?=$control['control']?></td>
                                                        <td><?=$process?></td>
                                                        <td><?=$control['cs_name']?></td>
                                                        <td><?=$control['ct_name']?></td>
                                                        <td><?=$user?></td>
                                                    </tr>
                                                    
                                                    <?php
                                                    }
                                                ?>
                                            </tbody>
                                            

                                        </table>
                                        </div>
                                        </div>
                                        
                                    </div>
                                </div><!----end of control--->
                                <div class="tab-pane fade" id="recommend" role="tabpanel" aria-labelledby="contact-tab">
                                    <div class="row" style="margin-top: 20px;">
                                        <div class="row col-md-12" ><!---inherent risk tab-->
                                        <div class="overflow">  
                                            <table class="table table-bordered">
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
                                        
                                    </div>
                                </div><!----end of recommendation--->
                                
                                <div class="tab-pane fade" id="action" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="row" style="margin-top: 20px;">
                                        <div class="row col-md-12" ><!---inherent risk tab-->
                                        <div class="overflow">  
                                            <table class="table table-bordered">
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