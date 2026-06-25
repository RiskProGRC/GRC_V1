<?php
include_once'./connection/connect.php';

$rcatid=$_POST["rcatid"];
 ///Risk Code
 $rselect=mysqli_query($con,"SELECT * FROM risk WHERE rcat='$rcatid'");

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
                                        <th>Reference id</th>
                                        <th>Description</th>
                                        <th>Cause</th>
                                        <th>Nominee</th>
                                        <th>Reviewer</th>
                                        <th>Reviewer date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while($rrisk=mysqli_fetch_assoc($rselect)){
                                    //*user
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
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                                

                            </table>
                        </div>
                    </div>
 