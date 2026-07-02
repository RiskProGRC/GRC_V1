<?php
include_once'./settings/impactClass.php';
include_once'./settings/likelihoodClass.php';
include_once'./settings/riskcategoryClass.php';
include_once'./risk/riskClass.php';
include_once'./join/JoindpClass.php';
include_once'./department/departmentClass.php';
include_once'./process/processClass.php';

$processClass=new processClass();
$showprocess=$processClass->showProcess();
//department
$deptClass= new departmentClass();
$showdept=$deptClass->showDept();

//risk
$riskClass= new riskClass();
$showriskass=$riskClass->showassessment();

?>
<!DOCTYPE html>
<html lang="en">
<!-_________________Header location______________________->
<?php include_once("../layout/header.php"); ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawSeriesChart);

    function drawSeriesChart() {

      var data = google.visualization.arrayToDataTable([
        ['ID', 'Impact', 'Likely', 'rname',     'assessment'],
        ['rsk00',    0,             0,      'risk',  0],
        ['rsk000',    10,             10,      'risk',  30],
        <?php
        foreach($showriskass as $riskass){
            $rid=$riskass["risk_id"];
            $rname=$riskClass->Riskjoin($rid);
            $rimp=$riskass["rimp"];
            $rlikely=$riskass["rlikely"];
            $rass=$rimp*$rlikely;

              echo "['RSK00".$rid."',".$rlikely.",".$rimp.",'".$rname."',".$rass."],";

        }
        ?>
        
      ]);

      var options = {
        title: '.' +
          ' X=Likelyhood, Y=Impact, Bubble size=assessment, Bubble color=assessment',
        hAxis: {title: 'Impact'},
        vAxis: {title: 'Likelyhood'},
        bubble: {textStyle: {fontSize: 11}}
      };

      var chart = new google.visualization.BubbleChart(document.getElementById('series_chart_div'));
      chart.draw(data, options);
    }
    </script>
<body>
    <div id="app">
        <div id="main" class="layout-horizontal">

 <!-_________________Navigation location______________________->

            <?php include_once("../layout/nav.php") ?>

            <div class="content-wrapper container">
            <style>
                h4{
                    text-align: center;
                }
                label {
                    font-size: 15px;
                    color: #000;
                }
                .form-control,.form-select,.choices{
                    font-size: 13px;
                    font-weight: 800;
                    color: #000;
                    border: 1px solid #8c8c8c;
                }
                .nav-tabs{
                    font-size: 14px;
                    font-weight: 800;
                }
                table{
                    width:80%;
                    margin: 0 auto;
                }
                td{
                    border:4px solid #fff;
                    height:90px;
                }
                .btn-info{
                    background-color: #000;
                    border-radius: 50%;
                }
                
            </style>  
<div class="page-heading">
    <h4>Risk Matrix</h4>
    <div class="website" >
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
                            <div class="row">
                                <div class="col-12 form-group">
                                    <select class="form-control choices" name="dept"  id="dept_id" required>
                                        <option value="" selected>--------------------SELECT ENTITY</option>
                                        <?php
                                        foreach($showdept as $dp){
                                            $deptid=$dp["dept_id"];
                                            $deptname=$deptClass->deptJoins($deptid);
                                        echo' <option value='.$dp["dept_id"].'>'.$deptname.'</option>';
                                        }
                                        ?>
                                    </select>                                    
                                </div>
                                <div class="col-12" style="margin-top:30px;">
                                    <table>
                                        <tr>
                                            <td rowspan="5" style="width:20px;padding:20px;font-size:20px;font-weight:600;background:#457373;color:#fff;">likelyhood</td>
                                            <td style="background:#f0de26;">1</td>
                                            <td style="background:#f99b07;">2</td>
                                            <td style="background:#e54c51;">3</td>
                                            <td style="background:#e54c51;">4</td>
                                            <td style="background:#e54c51;">5</td>
                                        </tr>
                                        <tr>
                                            <td style="background:#3bba53;">1</td>
                                            <td style="background:#f0de26;">2</td>
                                            <td style="background:#f99b07;">3</td>
                                            <td style="background:#e54c51;">4</td>
                                            <td style="background:#e54c51;">5</td>
                                        </tr>
                                        <tr>
                                            <td style="background:#3bba53;">1</td>
                                            <td style="background:#f0de26;">2</td>
                                            <td style="background:#f0de26;">
                                            <button type="button" class="btn btn-info" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Loss of IT equipment">
                                            </button>
                                            
                                            </td>
                                            <td style="background:#f99b07;">4</td>
                                            <td style="background:#e54c51;">5</td>
                                        </tr>
                                        <tr>
                                            <td style="background:#3bba53;">1</td>
                                            <td style="background:#3bba53;">2</td>
                                            <td style="background:#f0de26;">3</td>
                                            <td style="background:#f0de26;">4</td>
                                            <td style="background:#f99b07;">5</td>
                                        </tr>
                                        <tr>
                                            <td style="background:#3bba53;">1</td>
                                            <td style="background:#3bba53;">2</td>
                                            <td style="background:#3bba53;">3</td>
                                            <td style="background:#3bba53;">4</td>
                                            <td style="background:#f0de26;">5</td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" style="width:20px;text-align:center;font-size:20px;font-weight:600;background:#457373;color:#fff;">Impact</td>
                                            
                                        </tr>
                                    </table>                                     
                                </div>
                            </div>
                            
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
        </div>
        
    </div>
<!-----------------------script for dynamic drop down----------------------------------->
      
      
<!-----------------------------------------Modal For ENTITY-------------------------------->

<script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>

  <!----------------------Datatable Simple------------------------------------------------>
    <script src="../assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        if (table1) new simpleDatatables.DataTable(table1);

       
    </script>
<!----------------------Datatable Simple end------------------------------------------------>

    <script src="../assets/js/pages/horizontal-layout.js"></script>

<!----------------------font awsome------------------------------------------------>
    <script src="../assets/vendors/fontawesome/all.min.js"></script>

<!------------- Include Choices select JavaScript ------------------------------------------------>
<script src="../assets/vendors/choices.js/choices.min.js"></script>
<script src="../assets/js/pages/form-element-select.js"></script>

   
   <script>
      ///date picker 
    $("#datepicker").datepicker({
        dateFormat:'yy-mm-dd'
    });

/*Dynamic drop down jquery
        function fetchprocess(id){
        $('#process_id').html('<option>select CITY</option>')

        $.ajax({
            type:'POST',
            url:'ajaxdata.php',
            data: {dept_id:id},
            success: function(data){
                $('#process_id').html(data);
            },
            error: function (data) {
           alert('failed');
        },

        });
    }*/
    //////insert to db    

     //tooltip
     var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
   </script> 
   <script>     
   </script>

</body>

</html>
