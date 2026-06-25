<?php
include_once'./settings/nomineeClass.php';

//nominee clas
$nomineeClass=new nomineeClass();
$showNominee=$nomineeClass->shownominee();

?>
<!DOCTYPE html>
<html lang="en">
<!-_________________Header location______________________->
<?php include_once'../layout/header.php'; ?>

<body>
    <div id="app">
        <div id="main" class="layout-horizontal">

 <!-_________________Navigation location______________________->

 <?php include_once'../layout/nav.php'; ?>

            <div class="content-wrapper container">
                
<div class="page-heading">
    <h4>Nominee Lists</h4>
</div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
    <!-_________________Content location BEGINING______________________->

                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <button class="btn btn-primary" style="float:right;margin-right:30px;" data-bs-toggle="modal" data-bs-target="#owner">
                            <span class="fa-fw select-all fas">ï•</span>Nominee Owner</button>
                            
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>Reference</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php
                                   foreach($showNominee as $nominee){
                                    
                                        echo'<tr>
                                            <td>NID00'.$nominee["id"].'</td>
                                            <td>'.$nominee["fname"].'&nbsp;'.$nominee["sname"].'</td>
                                            <td>'.$nominee["email"].'</td>
                                            <td>
                                            <a href="" class="btn btn-sm btn-primary "><span class="fa-fw select-all fas">ïŒƒ</span></a>
                                            <a href="#" class="btn btn-sm btn-danger "><span class="fa-fw select-all fas">ï‹­</span></a>
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

        <?php include_once'../layout/footer.php'; ?>
        
        </div>
        
    </div>

<!-----------------------------------------Modal For DEpartment-------------------------------->
 <!--Basic Modal -->
 <div class="modal fade text-left" id="owner" tabindex="-1" role="dialog"aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg"
        role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel17">Add Nominee</h3>
                <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>        
            <form class="form form-horizontal" action="nomineeAction.php" method="POST">
            <div class="modal-body">
                    <div class="row">
                        
                            <div class="col-md-2">
                                <label>First name:</label>
                            </div>
                            <div class="col-md-4 form-group">
                                <input type="text" class="form-control" name="fname"
                                    placeholder="First name">
                            </div>
                            <div class="col-md-2">
                                <label>Second Name:</label>
                            </div>
                            <div class="col-md-4 form-group">
                                <input type="text"  class="form-control" name="sname"
                                    placeholder="Second Name">
                            </div>    <hr><br>                                
                            <div class="col-md-2">
                                <label>Email:</label>
                            </div>
                            <div class="col-md-4 form-group">
                                <input type="email"  class="form-control"  name="email"
                                    placeholder="Email">
                            </div>
                            
                        </div><!--end of row--->
                        
                      
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary"
                    data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
                <button type="submit" name="addNominee" class="btn btn-primary">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Add Nominee</span>
                </button>
            </div>
            </form>
        </div>
    </div>
</div>

    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>

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

   

</body>

</html>
