<?php
date_default_timezone_set('Asia/Jakarta');
$this->session = \Config\Services::session();
$this->request = \Config\Services::request();

use Config\Database;

$this->db = Database::connect("default");

$icon = "";
$nama = "";
$identity = $this->db->table("identity")->get();
foreach($identity->getResult() as $identity){
    $icon = $identity->identity_logo;
    $nama = $identity->identity_name;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/identity_logo/<?=$icon;?>">
    <title><?=$nama;?></title>

    <!-- Bootstrap Core CSS -->
    <link href="css/lib/bootstrap/bootstrap.min.4.5.2.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:** -->
    <!--[if lt IE 9]>
    <script src="https:**oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https:**oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]--> 


    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <link href="css/lib/toastr/toastr.min.css" rel="stylesheet">
    <script src="js/lib/toastr/toastr.min.js"></script>
    <script src="js/lib/toastr/toastr.init.js"></script>

    <script
    src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
    </script>


    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>

    <!--Fungsi Pemisah Ribuan -->
    <script src="js/pemisah_ribuan.js"></script>

    <script id="tinymce1" src="tinymce/js/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
    <script>tinymce.init({selector:'textarea'});</script>

    <style>
        .toast {
            min-width: 300px;
            position: fixed;
            bottom: 50px;
            right: 50px;
            z-index: 1000000000 !important;
            display: none;
        }

        .toast-header {
            background-color: aquamarine;
        }

        .toast-body {
            min-height: 100px;
        }

        .border {
            border: black solid 1px !important;
        }

        th,
        td {
            text-align: center;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }

        td {
            font-size: 14px;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            color: black !important;
        }

        .btn-action {
            padding: 0px;
            margin: 2px;
            display: inline;
        }

        .bold {
            font-weight: bold;
        }

        .green {
            color: olive;
        }
        .hidebar{
            height:inherit;
            overflow: auto;
        }

       /* Hide scrollbar for Chrome, Safari and Opera */
        .hidebar::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .hidebar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        .hide{display: none !important;}
        .container-fluid{
            padding:5px;
            margin:0px;
        }
        .page-titles{
            margin-bottom:-13px;
        }
        .tunjuk{
            cursor:pointer;
        }
        .navitem{
            padding:0px;
            font-size:30px!important;
        }
        .navlink{
            margin:0px !important; 
            padding:0px !important;
            padding-left:10px !important;
            font-size:30px!important;
        }
        .navlink::after {
            content: "Menu";
            color: rgba(128, 128, 128, 0.6); 
            font-weight: bold;
            font-size:15px!important;
            position: absolute; 
            top: 50%; 
            transform: translate(10px,-50%); 
        }
        #logotop{height: 50px; width: auto;}
        .table-responsive{overflow-x: auto; cursor: grab;}
    </style>
    

</head>

<body class="fix-header fix-sidebar">