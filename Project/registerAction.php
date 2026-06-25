<?php
require_once __DIR__ . '/core/AuthGuard.php'; // session gate; $uid, $ip, $sdid from session
include_once './connection/connect.php';
include_once './risk/riskClass.php';

$riskClass = new riskClass();

$dept = (int)($_POST['dept'] ?? 0);

$query=mysqli_query($con,"SELECT * from process WHERE dept_id='$dept'") or die(mysqli_error($con));


?>

<table id="example">
    <tr>
        <th>Process</th>
        <th></th>
    </tr> 
<?php while($row=mysqli_fetch_assoc($query)){
    $pid=$row["process_id"];
    ?>
    <tr>
        <td style="font-size:25px;border:2px solid #000;font-weight:800;"><?='P00'.$pid?> <?=$row["process_name"]?></td>
        <td style="border:2px solid #000;">
            <?php $query2=mysqli_query($con,"SELECT * from risk WHERE process='$pid'") or die(mysqli_error($con)); ?>
            <?php while($rrow=mysqli_fetch_assoc($query2)){
                $rid=$rrow["risk_id"];
                ?>
                <table id="" class="table risktable">
                    <tr>
                        <th>Inherent risk</th>
                        <th>Cause</th>
                        <th>INHERENT ASSESSMENT</th>
                        <th>Control</th>
                        <th>Residual ASSESSMENT</th>
                        <th>ACTION</th>
                        <th>Key Indicator</th>
                        <th>Recommendation</th>
                        <th>Timeline</th>
                        <th>Incident</th>    
                    </tr>
                    <tr>
                        <td>
                            <?php
                                
                                if(empty($rrow["risk_name"])){
                                }else{
                                    echo $rrow["risk_name"];
                                } 
                            ?>
                        </td>
                        <td>
                            <?php
                            
                            if(empty($rrow["cause"])){
                            }else{
                                echo $rrow["cause"];
                            }   
                            ?>

                        </td>
                        <td style="padding:0px;">
                            <?php 
                            $query3=mysqli_query($con,"SELECT * from assessment WHERE risk_id='$rid'") or die(mysqli_error($con));
                            $arow=mysqli_fetch_assoc($query3);

                            if(empty($arow["iimp"]) || empty($arow["ilikely"])){
                            }else{
                                //$control=$arow["control"];
                                $iimp=$arow["iimp"];
                                $ilikely=$arow["ilikely"];
                                $irass= $iimp * $ilikely;
                                $alert=$riskClass->inherent($irass);
                                echo'<input type="button" style="width:100%;padding:50px 25px;border-radius:0px;" value="" class="tablebtn btn '.$alert.'">';

                            }     

                            ?>
                                
                        </td>
                        <td>
                            <?php
                                
                                if(empty($rid)){
                                }else{
                                $query4=mysqli_query($con,"SELECT * FROM risk_control WHERE risk_id='$rid'");
                                
                                
                                //$qcontrol=mysqli_query($con,"SELECT * FROM control WHERE control_id='$cid'");
                               // $ctlrow=mysqli_fetch_assoc($qcontrol);
                                //echo $ctlrow["control"];

                            }
                            while($crow=mysqli_fetch_assoc($query4)){
                                $cid=$crow["control_id"];
                                $qcontrol=mysqli_query($con,"SELECT * FROM control WHERE control_id='$cid'");
                                $ctlrow=mysqli_fetch_assoc($qcontrol);
                                echo "CTR".$ctlrow['control_id']."-". $ctlrow['control']."</br>";
                                //echo $cid;
                            }
                                   
                               
                            ?>
                        </td>
                        <td style="padding:0px;">
                            <?php
                                    if(empty($arow["rimp"]) || empty($arow["rlikely"])){
                                    }else{
                                        $rimp=$arow["rimp"];
                                        $rlikely=$arow["rlikely"];
                                        $rrass= $rimp * $rlikely;
                                        $alertr=$riskClass->inherent($rrass);
                                        echo'<input type="button" style="width:100%;padding:50px 25px;border-radius:0px;" value="" class="tablebtn btn '.$alertr.'">';
                                    }   
                                        
                            ?>
                        </td>
                        <td>
                            <?php 
                            $query5=mysqli_query($con,"SELECT * from action WHERE risk_id='$rid'") or die(mysqli_error($con));
                            $actionrow=mysqli_fetch_assoc($query5);
                            if(empty($actionrow["action"])){
                            }else{
                                echo $actionrow["action"];
                            }                                
                            ?>
                        </td>
                        <td>
                                <?php 
                                $query6=mysqli_query($con,"SELECT * from ki WHERE risk_id='$rid'") or die(mysqli_error($con));
                                $kirow=mysqli_fetch_assoc($query6);
                                if(empty($kirow["ki"])){
                                }else{
                                    echo $kirow["ki"];
                                }                                  
                                ?>
                        </td>
                        <td>
                                <?php 
                                $query7=mysqli_query($con,"SELECT * from recommend WHERE risk_id='$rid'") or die(mysqli_error($con));
                                $recrow=mysqli_fetch_assoc($query7);
                                if(empty($recrow["mrc"])){
                                }else{
                                    echo $recrow["mrc"];
                                }                               
                                ?>
                        </td>
                        <td>
                            <?php
                            if(empty($recrow["timeline"])){
                                }else{
                                    echo $recrow["timeline"];
                                }  
                                ?>
                        </td>
                        <td>
                                <?php 
                                $query8=mysqli_query($con,"SELECT * from incident WHERE risk_id='$rid'") or die(mysqli_error($con));
                                $irow=mysqli_fetch_assoc($query8);
                                if(empty($irow["incident"])){
                                }else{
                                    echo $irow["incident"];
                                }                              
                                ?>
                        </td>
                    </tr>
                </table>
            <?php } ?>  
        </td>         
    </tr>
<?php } ?>
</table>
