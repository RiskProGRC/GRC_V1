<?php

include_once'../Project/control/controlClass.php';
$controlclass= new controlClass();

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

<?php
$tab= $_GET["tab"] ?? "home";

?>
    <div class="page-content">
        <section class="row">
            <div class="col-1 col-lg-12">
    <!-_________________Content location BEGINING______________________->

               <section class="section">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?php echo $tab =='home' ? 'active': ''?>" onclick="changeTab('home')" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Home</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?php echo $tab =='profile' ? 'active': ''?>" onclick="changeTab('profile')" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Profile</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?php echo $tab =='contact' ? 'active': ''?>" onclick="changeTab('contact')" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Contact</button>
                </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade <?php echo $tab =='home' ? 'show active': ''?>" id="home" role="tabpanel" aria-labelledby="home-tab">
                    This is some placeholder content the Home tab's associated content. 
                    Clicking another tab will toggle the visibility of this one for the next.
                    You can use it with tabs, pills, and any other .nav-powered navigation.</div>
                <div class="tab-pane fade <?php echo $tab =='profile' ? 'show active': ''?>" id="profile" role="tabpanel" aria-labelledby="profile-tab"> 
                    The tab JavaScript swaps classes to control the content visibility and styling. 
                    </div>
                <div class="tab-pane fade <?php echo $tab =='contact' ? 'show active': ''?>" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                     The tab JavaScript swaps classes to control the content visibility and styling. 
                    
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
