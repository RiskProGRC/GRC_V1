<?php
include_once'../Project/company/companyClass.php';
//department class functions

$companyclass= new companyClass();
$showcompany=$companyclass->showCompany();

?>
<style>
    card.card{
        margin-top: 20px;
    }
    .choices{
        margin: 0 auto;
        width: 800px;
        font-size: 14px;
        font-weight: 800;
        color: #000;
        padding: 2px 2px;
        border: 1px solid #000;
    }
    
    .overflow{
        overflow-y: scroll;
        width: 1500px;
        height: 500px;
    }
    table th{
        font-size: 15px;
    }
    table td{
        font-size: 12px;
        font-weight: 600;
    }
    .risktable tr td{
        border: 1px solid #000;
        padding:0px 15px;
        font-size: 12px;
        font-weight: 800;
        color:#000;
        width: 2000px;
    }
    .risktable tr th{
        border: 1px solid #000;
        font-size: 15px;
        font-weight: 800;
        color:#000;
        background: #d4e9ff;
    }
    .registertable{
        width: 150% !important;

    }
    .tablebtn{
        padding: 300px;
    }
   .btn-orange{
        background-color: #c49403 !important;
        color: #fff;
    }
    .btn-warning{
        background-color: #ffff00 !important;
        color: #fff;
    }
    .btn-success{
        background-color: #00b050 !important;
        color: #fff;
    }
    .btn-danger{
        background-color: #ff0000 !important;
        color: #fff;
    }
  
</style>
<!DOCTYPE html>
<html lang="en">
<!-_________________Header location______________________->
<?php include_once'../layout/header.php'; ?>

<body>
    <div id="app"> 
        <div id="main" class="layout-horizontal">

 <!-_________________Navigation location______________________->

 <?php include_once'../layout/nav.php';
 
 if (isset($_POST["export"])) {
    $filename = "Export_excel.xls";
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    $isPrintHeader = false;
    if (! empty($productResult)) {
        foreach ($productResult as $row) {
            if (! $isPrintHeader) {
                echo implode("\t", array_keys($row)) . "\n";
                $isPrintHeader = true;
            }
            echo implode("\t", array_values($row)) . "\n";
        }
    }
    exit();
}
?>

            <div class="content-wrapper container">
                
<div class="page-heading">
    <h3>Risk register</h3>
</div>
    <div class="page-content">
        <section class="row">
        <form method="POST" id="export-form">
            <div class="col-sm-12">
            <center>
                <label for=""><h4>SELECT ENTITY</h4></label>
            </center>
                <select style="font-size: 15px;" onchange="display(this.value)" class="form-control choices" name="department" id="department">
                    <option value="" selected>Choose Entity</option>
                        <?php
                        foreach($showdept as $dept){
                            echo'<option value='.$dept["dept_id"].'>'.$dept["dept_name"].'</option>';
                        }
                        
                        ?>
                </select>
                <input type="hidden" value="" id="hidden-type" name="ExportType" />
               <!-- <button type="button" name="ExportType" id="export-to-excel" class="btn btn-primary convert" style="float:right;margin-right:30px;">EXPORT</button>
                    -->
            </div>
            
    <!-_________________Content location BEGINING______________________->
                        <card class="card overflow">
                        <div id="display" class="">
                        
                        </div>
                        </card>

    <!-_________________Content location END______________________->
                
            </div>
         </form>
        </section>
    </div>

  </div>





 <!-_________________Footer location______________________->

        <?php include_once'../layout/footer.php'; ?>
        
        </div>
        
    </div>

<!-----------------------------------------Modal For DEpartment-------------------------------->
 <!--Basic Modal -->


    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>

    <!------------------------ Include Choices JavaScript drop down--------------------- -->
        <script src="../assets/vendors/choices.js/choices.min.js"></script>
        <script src="../assets/js/pages/form-element-select.js"></script>

  <!----------------------Datatable Simple------------------------------------------------>
    <script src="../assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
    </script>
<!----------------------Datatable Simple end------------------------------------------------>

    <script src="../assets/js/pages/horizontal-layout.js"></script>

<!----------------------font awsome------------------------------------------------>
    <script src="../assets/vendors/fontawesome/all.min.js"></script>

   
   <script>
    
    $("#datepicker").datepicker({
        dateFormat:'yy-mm-dd'
    });

   </script> 
   <script>
    $(document).ready(function() {
        jQuery('#export-to-excel').bind("click", function() {
        var target = $(this).attr('id');
        switch(target) {
        case 'export-to-excel' :
        $('#hidden-type').val(target);
        //alert($('#hidden-type').val());
        $('#export-form').submit();
        $('#hidden-type').val('');
        break
        }
        });
    });

   </script>

</body>

</html>


