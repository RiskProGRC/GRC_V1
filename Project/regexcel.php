<?php
	header("Content-Type: application/xls");    
	header("Content-Disposition: attachment; filename=student_list.xls");  
	header("Pragma: no-cache"); 
	header("Expires: 0");

    include_once'./connection/connect.php';
    include_once'./risk/riskClass.php';
    
    $riskClass= new riskClass();
    
    
    $dept=$_POST["dept"];
    
    $query=mysqli_query($con,"SELECT * from process WHERE dept_id='$dept'") or die(mysqli_error($con));
    
    
    ?>
    
    <table class="table table-bordered registertable">
        <tr>
            <th>Process</th>
            <th></th>
        </tr> 
    <?php while($row=mysqli_fetch_assoc($query)){
        $pid=$row["process_id"];
        ?>
        <tr>
            <td style="font-size:25px;border:2px solid #000;font-weight:800;"><?='P00'.$pid?>&nbsp;<?=$row["process_name"]?></td>
            <td style="border:2px solid #000;">
            <?php $query2=mysqli_query($con,"SELECT * from risk WHERE process='$pid'") or die(mysqli_error($con)); ?>
            <?php while($rrow=mysqli_fetch_assoc($query2)){
                $rid=$rrow["risk_id"];
                ?>
                <table class="table risktable">
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
                        <td>
                            <?php 
                            $query3=mysqli_query($con,"SELECT * from assessment WHERE risk_id='$rid'") or die(mysqli_error($con));
                            $arow=mysqli_fetch_assoc($query3);
    
                            if(empty($arow["iimp"]) || empty($arow["ilikely"])){
                            }else{
                                $control=$arow["control"];
                                $iimp=$arow["iimp"];
                                $ilikely=$arow["ilikely"];
                                $irass= $iimp * $ilikely;
                                $alert=$riskClass->inherent($irass);
                                echo'<button class="btn '.$alert.'">inherent</button>';
    
                            }     
    
                            ?>
                                
                       </td>
                       <td>
                        <?php
                            
                            if(empty($arow["control"])){
                            }else{
                                $control=$arow["control"];
                           
    
                            $query4=mysqli_query($con,"SELECT * FROM control WHERE control_id='$control'");
                            $crow=mysqli_fetch_assoc($query4);
                        }
                            if(empty($crow["control"])){
                            }else{
                                echo $crow["control"];
                            }   
                         
                        ?>
                       </td>
                       <td>
                           <?php
                                if(empty($arow["rimp"]) || empty($arow["rlikely"])){
                                }else{
                                    $rimp=$arow["rimp"];
                                    $rlikely=$arow["rlikely"];
                                    $rrass= $rimp * $rlikely;
                                    $alertr=$riskClass->inherent($rrass);
                                    echo'<button class="btn '.$alertr.'">inherent</button>';
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
              <td>
    
             </td>
             
        </tr>
    <?php } ?>
    </table>
?>    