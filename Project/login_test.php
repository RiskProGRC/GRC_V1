
<!DOCTYPE html>
<html lang="en">
<!-_________________Header location______________________->
<?php include_once'../layout/header.php'; ?>

<body>
    <div id="app">
        <div id="main" class="layout-horizontal">

 <!-_________________Navigation location______________________->

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
    <h4>BLANK PAGE</h4>
</div>
    <div class="page-content">
        <section class="row">
            <div class="col-1 col-lg-12">
    <!-_________________Content location BEGINING______________________->

               <section class="section">
                   <!-- <form id="riskControl" method="post">
                        <div class="row">
                            <div class="col-12 form-group">
                                <input type="text" class="form-control" name="risk" id="">

                            </div>
                            <div class="col-12 form-group">
                                <select name="control[]" class="choices form-select multiple-remove" multiple="multiple">
                                    <option value="">Select control</option>
                                    /*<?php /*foreach($showcontrol as $control){
                                        $cvalue=substr($control['control'],0,50);
                                        ?>
                                    <option value="<?=$control['control_id']?>"><?=$cvalue?></option>   
                                    <?php }*/ ?>
                                </select>
                            </div>
                            <button class="btn btn-primary addriskcontrol" id="">Submit form</button>
                        </div>
                    </form>-->
                    <div class="card">
                        <div class="card-header">
                            <h2>REGISTRATION FORM</h2>
                        </div>
                        <form id="formValidation" name="formValidation" method="post">
                            <div class="row">
                                <div class="col-8 form-group">
                                    <label for="">Name</label>
                                    <input type="text" class="form-control" name="name" id="" required>
                                </div>
                                <div class="col-8 form-group">
                                <label for="">Email</label>
                                    <input type="text" class="form-control" name="email" id="" required>
                                </div>
                                <div class="col-8 form-group">
                                <label for="">Phone</label>
                                    <input type="text" class="form-control" name="phone" id="" required>
                                </div>
                                <div class="col-8 form-group">
                                <label for="">Subject</label>
                                    <input type="text" class="form-control" name="subject" id="" required>
                                </div>
                                <div class="col-8 form-group">
                                <label for="">Messages</label>
                                    <textarea name="formMessage" class="form-control" id="" required>                                        
                                    </textarea>
                                </div>
                                
                                <button class="btn btn-primary addriskcontrol" id="">Submit form</button>
                            </div>
                        </form>
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
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
  <!----------------------Datatable Simple------------------------------------------------>
    <script src="../assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        if (table1) new simpleDatatables.DataTable(table1);
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
    
    $("#datepicker").datepicker({
        dateFormat:'yy-mm-dd'
    });

   </script> 
   <script>
    /*
    $(document).on('click','.addriskcontrol',function(e){
        e.preventDefault();
        $.ajax({
            url:'riskcontrol.php',
            method:'post',
            data:$("#riskControl").serialize(),
            dataType:'text',
            success:function(response){
                Swal.fire({
                    icon: "success",
                    title: response,
                    timer: 1500
                    })
                    window.setTimeout(function(){//time to switch to location
                        window.location.href ="blank.php";
                    }, 1500);
            }


        });

    });*/
   </script>
   
</body>

</html>
