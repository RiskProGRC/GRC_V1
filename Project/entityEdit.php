<?php include_once("include/connection.php")?>

<?php
$id = $_GET['id'];
$sql= "SELECT * FROM entity WHERE id=$id";
$query= mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($query);


?>
<!DOCTYPE html>
<html lang="en">
<!-_________________Header location______________________->
<?php include_once("../layout/header.php"); ?>

<body>
    <div id="app">
        <div id="main" class="layout-horizontal">

 <!-_________________Navigation location______________________->

            <?php include_once("layout/nav.php") ?>

            <div class="content-wrapper container">
                
<div class="page-heading">
    <h4>Entity Edit</h4>
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
                            <form class="form">
                                <div class="row">
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column">Entity No.</label>
                                            <input type="text" id="first-name-column" class="form-control" value="ENT00<?=$id?>" name="fname-column" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="last-name-column">description</label>
                                            <input type="text" id="last-name-column" value="<?=$row['description'];?>" class="form-control" name="lname-column">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="city-column">RAM(Risk assessment)</label>
                                            <input type="text" id="city-column" value="<?=$row['ram'];?>" class="form-control" placeholder="City"
                                                name="city-column">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="country-floating">Owner</label>
                                            <input type="text" id="country-floating" value="<?=$row['owner'];?>" class="form-control"
                                                name="country-floating" placeholder="Country">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="company-column">Nominee</label>
                                            <input type="text" id="company-column" value="<?=$row['nominee'];?>" class="form-control"
                                                name="company-column" placeholder="Company">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="email-id-column">Reviewer</label>
                                            <input type="text" id="email-id-column" value="<?=$row['reviewer'];?>" class="form-control"
                                                name="email-id-column" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="email-id-column">Review Date</label>
                                            <input type="text" id="datepicker" value="<?=$row['rdate'];?>" class="form-control"
                                                name="email-id-column" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="email-id-column">Location</label>
                                            <input type="text" id="email-id-column" value="<?=$row['location'];?>" class="form-control"
                                                name="email-id-column" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="email-id-column">Basel Business Line</label>
                                            <input type="text" id="email-id-column" value="<?=$row['bbline'];?>" class="form-control"
                                                name="email-id-column" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="email-id-column">Legal Entity</label>
                                            <input type="text" id="email-id-column" value="<?=$row['lentity'];?>" class="form-control"
                                                name="email-id-column" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="email-id-column">Division</label>
                                            <input type="text" id="email-id-column" value="<?=$row['division'];?>" class="form-control"
                                                name="email-id-column" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="email-id-column">Process</label>
                                            <input type="text" id="email-id-column" value="<?=$row['process'];?>" class="form-control"
                                                name="email-id-column" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="form-group col-12">
                                        <div class='form-check'>
                                            <div class="checkbox form-switch">
                                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                                            <label><h5>ACTIVE</h5></label> 
                                            </div>
                                        </div>
                                    </div>
                        <!-----------------------Nav TABS edits ----------------------------------> 
                            <div class="form-group col-12">
                                <hr>
                            <div class="card">
                                    <div class="card-header">
                                       
                                    </div>
                                    <?php
                                    $sqlRisk= "SELECT * FROM risk WHERE entity_id=$id";
                                    $queryrisk= mysqli_query($conn,$sqlRisk);
                                    $count= mysqli_num_rows($queryrisk);
                                    ?>
                                    <div class="card-body">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab"
                                                    aria-controls="home" aria-selected="true">Risks &nbsp;<span class="badge bg-primary"><?=$count;?></span></a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab"
                                                    aria-controls="profile" aria-selected="false">Events &nbsp;<span class="badge bg-primary">2</span></a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab"
                                                    aria-controls="contact" aria-selected="false">Controls &nbsp;<span class="badge bg-primary">4</span></a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab"
                                                    aria-controls="contact" aria-selected="false">KIs &nbsp;<span class="badge bg-primary">4</span></a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab"
                                                    aria-controls="contact" aria-selected="false">Actions &nbsp;<span class="badge bg-primary">1</span></a>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>Reference</th>
                                                                <th>Description</th>
                                                                <th>Risk Category</th>
                                                                <th>Owner</th>
                                                                <th>Nominee</th>
                                                                <th>Reviewer</th>
                                                                <th>status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $sqlRisk= "SELECT * FROM risk WHERE entity_id=$id";
                                                            $queryrisk= mysqli_query($conn,$sqlRisk);
                                                            ?>
                                                            <?php while($riskrow= mysqli_fetch_assoc($queryrisk)) { ?>
                                                            <tr>
                                                                <td class="text-bold-500">RSK00<?=$riskrow['id']?></td>
                                                                <td><?=$riskrow['description']?></td>
                                                                <td class="text-bold-500"><?=$riskrow['rcat']?></td>
                                                                <td><?=$riskrow['owner']?></td>
                                                                <td><?=$riskrow['nominee']?></td>
                                                                <td><?=$riskrow['reviewer']?></td>
                                                                <td><span class='badge bg-success'>Approved</span></td>
                                                            </tr>
                                                            <?php } ?>
                                                            
                                                        
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                                Integer interdum diam eleifend metus lacinia, quis gravida eros mollis. Fusce non sapien
                                                sit amet magna dapibus
                                                ultrices. Morbi tincidunt magna ex, eget faucibus sapien bibendum non. Duis a mauris ex.
                                                Ut finibus risus sed massa
                                                mattis porta. Aliquam sagittis massa et purus efficitur ultricies. Integer pretium dolor
                                                at sapien laoreet ultricies.
                                                Fusce congue et lorem id convallis. Nulla volutpat tellus nec molestie finibus. In nec
                                                odio tincidunt eros finibus
                                                ullamcorper. Ut sodales, dui nec posuere finibus, nisl sem aliquam metus, eu accumsan
                                                lacus felis at odio. Sed lacus
                                                quam, convallis quis condimentum ut, accumsan congue massa. Pellentesque et quam vel
                                                massa pretium ullamcorper vitae eu
                                                tortor.
                                            </div>
                                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                                <p class="mt-2">Duis ultrices purus non eros fermentum hendrerit. Aenean ornare interdum
                                                    viverra. Sed ut odio velit. Aenean eu diam
                                                    dictum nibh rhoncus mattis quis ac risus. Vivamus eu congue ipsum. Maecenas id
                                                    sollicitudin ex. Cras in ex vestibulum,
                                                    posuere orci at, sollicitudin purus. Morbi mollis elementum enim, in cursus sem
                                                    placerat ut.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                    <!-----------------------Nav TABS edits end ----------------------------------> 
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                    </div>
                                </div>
                            </form>
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

        <?php include_once("layout/footer.php"); ?>
        </div>
        
    </div>

<!-----------------------------------------Modal For ENTITY-------------------------------->


    <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>

  <!----------------------Datatable Simple------------------------------------------------>
    <script src="assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
    </script>
<!----------------------Datatable Simple end------------------------------------------------>

    <script src="assets/js/pages/horizontal-layout.js"></script>

<!----------------------font awsome------------------------------------------------>
    <script src="assets/vendors/fontawesome/all.min.js"></script>

    <script src="assets/vendors/jquery/jquery.min.js"></script>
    <script src="assets/vendors/jquery/jquery-ui.min.js"></script>
   
   <script>
    
    $("#datepicker").datepicker({
        dateFormat:'yy-mm-dd'
    });

   </script> 

</body>

</html>
