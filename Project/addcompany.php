
<?php
include_once'./company/companyClass.php';
$companyClass=new companyClass();
$showgroup=$companyClass->showgroup();

?>
<!DOCTYPE html>
<html lang="en">
<!-_________________Header location______________________->
<?php include_once("../layout/header.php"); ?>

<body>
    <div id="app">
        <div id="main" class="layout-horizontal">

 <!-_________________Navigation location______________________->

            <?php include_once("../layout/nav.php") ?>

            <div class="content-wrapper container">
                
<style>
    .card>.card-header{
        border-bottom: 1px solid #d2d2d2;
        margin:10px 0px;
        background: #fafafa;
    }
    .card>.card-header>h2{
        text-align: center;
        font-weight: 900;
        font-size: 25px;
        
    }
</style>
    <!-_________________Content location BEGINING______________________->
    <div class="page-content">
        <section  class="row">
            <div class="col-lg-2"></div>

            <div class="col-lg-6">
                
                <section  class="section">
                  <form id="companyform" action="companyaction.php" method="POST" enctype="multipart/form-data">
                    <div  class="card">
                        <div class="card-header">
                            <h2>ADD COMPANY/ORGANISATION</h2>
                        </div>
                        <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Company name:</label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <input type="text" class="form-control" name="name"
                                            placeholder="First name" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Group name:</label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <select class="form-select" name="group" id="cugroup">
                                            <option value="0" selected>Non-Group</option>
                                            <?php
                                            foreach($showgroup as $group){?>
                                            <option value="<?=$group['id']?>"><?=$group['name']?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Email:</label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <input type="email"  class="form-control" name="email"
                                            placeholder="email">
                                    </div>                                    
                                    <div class="col-md-4">
                                        <label>Telephone:</label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <input type="text"  class="form-control"  name="phone"
                                            placeholder="Telephone">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Website:</label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <input type="text"  class="form-control"  name="website"
                                            placeholder="website">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Address:</label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <textarea class="form-control" name="address" id="" cols="" rows="5" placeholder="e.g P.O.BOX "></textarea>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <label>Upload Logo:</label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <input type="file" name="file" class="form-contol"  id="">
                                    </div>
                                    
                                </div><!--end of row--->

                        </div>
                        <div class="card-footer">
                            <div class="row">
                                
                                <div class="col-md-5">
                                    <button  name="addCompany" class="btn btn-lg btn-primary addcompany">Add Company</button>
                                </div>
                                <div class="col-md-5">
                                    <a href="company.php" class="btn btn-lg btn-danger">CLOSE</a>
                                </div>

                            </div><!-----end of footer row-->
                                  
                        </div>
                    </div>
                  </form>
                </section>
            </div>

           
            </div><!-----begining of side table---->
    <!-_________________Content location END______________________->
                
            
        </section>
    </div>

  </div>





 <!-_________________Footer location______________________->

        <?php include_once("../layout/footer.php"); ?>

        

     <!-----------------------------------RISK Modals--------------------------------------------------------------->
     
    
        </div>
        
    </div>

    <script>
       /* $(document).on('click','.addcompany',function(e){
            e.preventDefault();
            $.ajax({
                url:'companyaction.php',
                method:'post',
                enctype: 'multipart/form-data',
                data:$("#companyform").serialize(),
                processData: false,
                contentType: false,
                cache: false,
                dataType:'text',
                success:function(response){
                    Swal.fire({
                            icon: "success",
                            title: response,
                            timer: 8500
                        })
                        window.setTimeout(function() {//time to switch to location
                            window.location.href = 'company.php';
                        }, 8500);

                }
            });
        })*/
   </script> 
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
    
    <!-----SWEET ALERTS--------------------------------->
    <script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>

<!----------------------font awsome------------------------------------------------>
    <script src="../assets/vendors/fontawesome/all.min.js"></script>

<!------------- Include Choices select JavaScript ------------------------------------------------>
<script src="../assets/vendors/choices.js/choices.min.js"></script>
<script src="../assets/js/pages/form-element-select.js"></script>

   
   <script>
    
    $("#datepicker").datepicker({
        dateFormat:'yy-mm-dd'
    });

   </script>
   

</body>

</html>
