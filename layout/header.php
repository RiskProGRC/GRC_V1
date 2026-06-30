<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include_once'./department/departmentClass.php';
include_once'./process/processClass.php';
include_once'./control/controlClass.php';
include_once'./keyindicator/keyindicatorClass.php';
include_once'./action/actionClass.php';
include_once'./incident/incidentClass.php';
include_once'./recommend/recommendClass.php';
include_once'./risk/riskClass.php';
include_once'./users/usersClass.php';
include_once'./settings/controlstrengthClass.php';
include_once'./raf/kriClass.php';
include_once'./settings/riskcategoryClass.php';

$i=1;


// Set session timeout in seconds (e.g., 30 minutes)
$timeout = 800;

// Check if timeout condition is met
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $timeout)) {
    // Last request was more than 30 minutes ago
    session_unset();     // Unset $_SESSION variable
    session_destroy();   // Destroy session data
    // Redirect to login page or show timeout message
    header("Location: timeout.php");
    exit;
}
//Ip addresss
function getuseripaddress(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        $ip= $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        $ip= $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip= $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}


// Update last activity time
$_SESSION['LAST_ACTIVITY'] = time();

// To prevent hijacking, regenerate session ID periodically
if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
} elseif (time() - $_SESSION['CREATED'] > 800) {
    // Session started more than 30 minutes ago
    session_regenerate_id(true);  // Change session ID and invalidate old one
    $_SESSION['CREATED'] = time(); // Update creation time
}

//check user section
if(!isset($_SESSION["user"])){
    header("Location:../login.php");
 }elseif(!isset($_SESSION["uid"])){
    header("Location:../login.php");
 }else{
   $sess_uid= $_SESSION["uid"];
   $sess_username= $_SESSION["user"];
    $sess_dept_id=$_SESSION["dept_id"];
    $userclass=new usersClass();
    $authrow = $userclass->profile((string)$sess_uid);
    $sess_roles = $authrow ? (int)$authrow["roles"] : (int)$_SESSION["roles"];
    $_SESSION["roles"] = $sess_roles;
 }
 $suid=$sess_uid;
 $sdid=$sess_dept_id;

 

 //department
$deptClass= new departmentClass();
if($sess_roles==1){
    $showdept= $deptClass->showDept();
}else{
    $showdept= $deptClass->showDeptSess($sdid);
}

//process
$processClass=new processClass();
if($sess_roles==1){
    $showprocess=$processClass->showProcess();
}else{
    $showprocess=$processClass->showProcessdept($sdid);
}
//risk
$riskClass=new riskClass();
if($sess_roles==1){
    $showrisk=$riskClass->showRisk();
    $showriskass= $riskClass->showRiskassess();
    $showriskasstop= $riskClass->showassessment();//top 10 risk
    $riskcategory=$riskClass->dashboardrcat();
}else{
    $showrisk=$riskClass->showRiskdept($sdid);
    $showriskass= $riskClass->showRiskassessdept($sdid);
    $showriskasstop= $riskClass->showassessmentdept($sdid);//top 10 risk
    $riskcategory=$riskClass->dashboardrcatdept($sdid);
}
//Risk category
if($sess_roles==1){
    $riskcatClass= new riskCatClass();
    $showRiskCat= $riskcatClass->showRiskCat();
}else{
    $riskcatClass= new riskCatClass();
    $showRiskCat= $riskcatClass->showRiskCat();
}
//control
$controlclass=new controlClass();
if($sess_roles==1){
    $showcontrol=$controlclass->showcontrol();
    $dashcstrength=$controlclass->dashboardcstrength();
}else{
    $showcontrol=$controlclass->showcontroldept($sdid);
    $dashcstrength=$controlclass->dashboardcstrengthdept($sdid);
}
//control strength
$cstrengthclass=new controlstrengthClass();
if($sess_roles==1){
    $showcstrength= $cstrengthclass->showcontrolstrength();
}else{
    $showcstrength= $cstrengthclass->showcontrolstrength();
}

//Key Indicator
$kiclass=new kiClass();
if($sess_roles==1){
    $showki=$kiclass->showKi();
}else{
    $showki=$kiclass->showKidept($sdid);
    
}
//action 
$actionclass=new actionClass();
if($sess_roles==1){
    $showaction=$actionclass->showaction();
   
}else{
    $showaction=$actionclass->showactiondept($sdid);
}

//control strength


//Incident
$incidentclass=new incidentclass();
if($sess_roles==1){
    $showincident=$incidentclass->showincident();
}else{
    $showincident=$incidentclass->showincidentdept($sdid);
}
//recommend
$recommendClass=new recommendClass();

if($sess_roles==1){
    $showrecommend=$recommendClass->showrecommend();
}else{
    $showrecommend=$recommendClass->showrecommenddept($sdid);
}

//users
$showusers=$userclass->fetchusers();

//kri
$kriClass=new kriClass();
if($sess_roles==1){
    $showkri= $kriClass->fetchkri();
    $showb_obj= $kriClass->fetchkriobj();
    $showkriparameter=$kriClass->fetchkriparameter();
    
}else{
    $showkri= $kriClass->fetchkridept($sdid);
    $showkriparameter=$kriClass->fetchkriparameterdept($sdid);
}


?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRC</title>
  

     <!-------------------Chioces for drop down link--------------------------------------->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../assets/vendors/jquery/jquery-ui.min.js"></script>
    
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    
    <link rel="stylesheet" type="text/css" href="../assets/css/jquery-ui.min.css">
    <!-------------------Chioces for drop down link--------------------------------------->
    <link rel="stylesheet" href="../assets/vendors/choices.js/choices.min.css" />
    
   <link rel="stylesheet" href="../assets/vendors/iconly/bold.css">

   

    <link rel="stylesheet" href="../assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="../assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/container.css">
    <link rel="stylesheet" href="../assets/css/app.css">
    <link rel="shortcut icon" href="../assets/images/favicon.svg" type="image/x-icon">

<!-------------------DataTables simple--------------------------------------->

<link rel="stylesheet" href="../assets/vendors/simple-datatables/style.css">

<!---------------------Font Awesome--------------------------------------->
<link rel="stylesheet" href="../assets/vendors/fontawesome/all.min.css">

<!------------------------Sweet alerts------------------------------------>
<link rel="stylesheet" href="../assets/vendors/sweetalert2/sweetalert2.min.css">
<!------------------------tostify alerts------------------------------------>
<link rel="stylesheet" href="../assets/vendors/toastify/toastify.css">

<!------------------------Validation------------------------------------>
<script src="../assets/vendors/validate/jquery.validate.js"></script>


<script>
window.GRC = {
    uid:   "<?= htmlspecialchars($suid ?? '', ENT_QUOTES) ?>",
    sdid:  "<?= htmlspecialchars($sdid ?? '', ENT_QUOTES) ?>",
    roles: <?= (int)($sess_roles ?? 0) ?>,
    ip:    "<?= htmlspecialchars(getuseripaddress(), ENT_QUOTES) ?>"
};
</script>

<style>
    .fontawesome-icons {
        text-align: center;
    }

    article dl {
        background-color: rgba(0, 0, 0, .02);
        padding: 20px;
    }

    .fontawesome-icons .the-icon svg {
        font-size: 24px;
    }
    .form-group > .error{
        color:red;
    }
    
</style>    

</head>