<?php

$kriid=$_GET["id"];


?>
<!DOCTYPE html>
<html lang="en">
<!-_________________Header location______________________->
<?php include_once'../layout/header.php'; 

$rphist=$kriClass->fetchrphistory($kriid);
?>

<body>
    <div id="app">
        <div id="main" class="layout-horizontal">

 <!-_________________Navigation location______________________->

 <?php include_once'../layout/nav.php'; ?>

            <div class="content-wrapper container">

                
<style>
    .card{
        width:600px;
        margin: 0 auto;
    }
    .form-group{
        margin: 0 auto;
    }
    label.error{
        color: #f00;
        font-weight: 600;
        font-size: 12px;
    }
    .btn{
        margin-top: 20px;
    }
 </style>    

<div class="page-heading">
    <h4>KRI CHART</h4>
</div>

<?php
$tab= $_GET["tab"] ?? "home";

?>
    <div class="page-content">
        <section class="row">
            <div class="col-1 col-lg-12">
    <!-_________________Content location BEGINING______________________->

               <section class="section">
                    <div class="card">
                        <div id="curve_chart" style="width: 800px; height: 450px"></div>
                    </div>       
                </section>


    <!-_________________Content location END______________________->
                
            </div>
        </section>
    </div>

  </div>





 <!-_________________Footer location______________________->

        <?php include_once'../layout/footer.php'; ?>
        
        </div>
        
    </div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Month', 'Performance'],
          <?php
          foreach($rphist as $hist){
            $month=date("F", strtotime($hist["date"]));
            $performance=$hist["rapetite"];
            //$ass=$cat["count"];

              echo "['".$month."',".$performance."],";
          }
          ?>
        
        ]);

        var options = {
          title: 'Key Risk Indicator',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>

    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
  <!----------------------Datatable Simple------------------------------------------------>
    <script src="../assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
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

   
   <script>
    function changeTab(tab){
        const urlsearchParam = new URLSearchParams(window.location.search)
        urlsearchParam.set("tab", tab)
        const newPath = window.location.pathname + "?" + urlsearchParam.toString()
        history.pushState(null, "", newPath)
    }
   </script> 
   <script>


   </script>
   
</body>

</html>
