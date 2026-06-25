<?php
include_once'./connection/connect.php';

$csid=$_POST["csid"];
 ///Risk Code
 $cselect=mysqli_query($con,"SELECT control.risk,control.control,control.control_id,control.process_id,control.ctype,control.reviewer,control.rdate,
    risk.risk_name,control_type.ct_name
    FROM control 
    INNER JOIN risk
        ON control.risk=risk.risk_id
    INNER JOIN control_type
        ON control.ctype=control_type.ctype_id
    WHERE cstrength='$csid'");

?>
 <div class="card" id="roveralldisplay">
                        <div class="card-header">
                        <input type="hidden" name="file_content" id="file_content">
                            <button type="button" name="convert" id="convert" class="btn btn-primary convert" style="float:right;margin-right:30px;">EXPORT</button>
                            
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered" id="table1">
                                <thead>
                                    
                                    <tr>
                                        <th>Reference</th>
                                        <th>Control</th>
                                        <th>Risk</th>
                                        <th>Control Type</th>
                                        <th>Reviewer</th> 
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while($control=mysqli_fetch_assoc($cselect)){
                                    //*user
                                    $uid=$control['reviewer'];
                                    $select=mysqli_query($con,"SELECT * FROM users WHERE id='$uid'");
                                    $row=mysqli_fetch_assoc($select);
                                    $user=$row["fname"].'&nbsp;'.$row["sname"];
                                    
                                    
                                    ?>
                                        <tr>
                                            <td>CNT00<?=$control['control_id']?></td>
                                            <td><?=$control['control']?></td>
                                            <td><?=$control['risk_name']?></td>
                                            <td><?=$control['ct_name']?></td>
                                            <td><?=$user?></td>
                                            <td><?=$control['rdate']?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                                

                            </table>
                        </div>
                    </div>
 