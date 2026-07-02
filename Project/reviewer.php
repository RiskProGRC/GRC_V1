<?php
include_once'./settings/reviewerClass.php';

$reviewerclass=new reviewerClass();
$showreviewer=$reviewerclass->showreviewer();



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
                
<div class="page-heading">
    <h4>Reviewers Lists</h4>
</div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
    <!-_________________Content location BEGINING______________________->
                <style>
                    .btn-orange{
                    background-color: #ff4700;
                    border-color: #ff4700;
                    border:1px solid #fff;
                    color: #fff;
                }
                    
                </style>
    <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <a href="addreviewer.php" class="btn btn-primary" style="float:right;margin-right:30px;" ><span class="fa-fw select-all fas">ï•</span>Add Controls</a>
                            
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>Reference</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                        foreach($showreviewer as $reviewer){
                          $reviewername=ucfirst($reviewer["fname"].'&nbsp'.$reviewer["sname"]);
                            echo'
                                    <tr>
                                        <td>'.$reviewer["id"].'</td>
                                        <td>'.$reviewername.'</td>
                                        <td>'.$reviewer["email"].'</td>
                                        <td>'.$reviewer["phone"].'</td>
                                        <td>
                                        <a href="#" class="btn btn-sm btn-primary stg-edit" data-form="#reviewereditform" data-modal="#reviewial-edit-modal" data-id="'.$reviewer["id"].'" data-fname="'.htmlspecialchars($reviewer["fname"],ENT_QUOTES).'" data-sname="'.htmlspecialchars($reviewer["sname"],ENT_QUOTES).'" data-email="'.htmlspecialchars($reviewer["email"],ENT_QUOTES).'" data-phone="'.htmlspecialchars($reviewer["phone"],ENT_QUOTES).'"><span class="fa-fw select-all fas">ïŒƒ</span></a>
                                        <a href="#" class="btn btn-sm btn-danger stg-del" data-url="reviewercrud.php" data-id="'.$reviewer["id"].'" data-name="'.htmlspecialchars($reviewer["fname"].' '.$reviewer["sname"],ENT_QUOTES).'"><span class="fa-fw select-all fas">ï‹­</span></a>
                                        </td>
                                    </tr>';
                                      }
                                    ?>
                                         
                                </tbody>
                            </table>
                        </div>
                    </div>

                </section>


    <!-_________________Content location END______________________->
                
            </div>
        </section>
    </div>

  </div>





 <!-_________________Footer location______________________->

  <!-- Edit Reviewer modal -->
  <div class="modal fade text-left" id="reviewial-edit-modal" tabindex="-1" aria-hidden="true"><div class="modal-dialog"><div class="modal-content">
    <div class="modal-header"><h4 class="modal-title">Edit Reviewer</h4><button type="button" class="btn btn-danger close" data-bs-dismiss="modal"><i data-feather="x"></i></button></div>
    <form id="reviewereditform" class="stg-form" data-url="reviewercrud.php" data-redirect="reviewer.php"><div class="modal-body">
      <input type="hidden" name="id">
      <div class="form-group"><label>First Name</label><input class="form-control" name="fname"></div>
      <div class="form-group"><label>Surname</label><input class="form-control" name="sname"></div>
      <div class="form-group"><label>Email</label><input type="email" class="form-control" name="email"></div>
      <div class="form-group"><label>Phone</label><input class="form-control" name="phone"></div>
    </div><div class="modal-footer"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button><button type="submit" class="btn btn-primary">Update Reviewer</button></div></form>
  </div></div></div>
  <!-- Shared settings delete modal -->
  <div class="modal fade text-left" id="stgdel-modal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-dialog-centered"><div class="modal-content">
    <div class="modal-header bg-danger"><h5 class="modal-title white">Delete</h5><button type="button" class="close" data-bs-dismiss="modal"><i data-feather="x"></i></button></div>
    <div class="modal-body"><input type="hidden" id="stgdel_url"><input type="hidden" id="stgdel_id"><h5>Delete this record?</h5><div style="font-weight:600;text-align:center;margin-top:8px;" id="stgdel_name"></div></div>
    <div class="modal-footer"><button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Close</button><button type="button" class="btn btn-danger stgdel-confirm">Delete</button></div>
  </div></div></div>

        <?php include_once("../layout/footer.php"); ?>

        
        </div>
        
    </div>



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
        if (table1) new simpleDatatables.DataTable(table1);
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

</body>

</html>
