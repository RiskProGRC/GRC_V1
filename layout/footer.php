<?php
 if($sess_roles==1){
    echo
    "<style>
        a.userpermission-edit,.userpermission-delete,.userpermission-control {
            pointer-events: none;
            text-decoration: none;
        }
    </style>
    <script>
    $(document).ready(function(){
        $('.btn-userpermission-add').prop('disabled', true);
        $('.btn-userpermission-delete').prop('disabled', true);
        $('.btn-userpermission-edit').prop('disabled', true);
    });
   </script>
   ";
 }elseif($sess_roles==2){
    echo
    "<script>
    $(document).ready(function(){
        $('.btn-add-group').prop('disabled', false);
    });
   </script> ";
 }else{

 }
?>

<script src="../assets/js/app.js"></script>

<footer>
    <div class="container">
        <div class="footer clearfix mb-0 text-muted">
            <div class="float-start">
                <p>2025 &copy; <a href="../Project/userslist.php"> GRC</a></p>
            </div>
            <div class="float-end">
                <p>Developed By <span class="text-danger"><i class="bi bi-bookmarks-fill"></i></span> wellington risk consulting </a></p>
            </div>
        </div>
    </div>
</footer>

            