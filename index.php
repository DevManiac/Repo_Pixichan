<?php
/** @file*/
session_start();

?>


<!doctype html>

<html>
<head>
        <meta charset="UTF-8">
        
        <!-- Useful for @media keyword in CSS to manage responsive design-->
        <meta name="viewport" content="width=device-width">
        
        <!-- Stuff that help find the web page on the internet-->
        <meta name="description" content="A little Website">
        <meta name="keywords" content="pixli, design, image, imageboard">
        <meta name="author" content="Maniac">
        <!-- ------------------------------------------------ -->
        
        <title>Pixichan.net</title>
        <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
        <link rel="stylesheet" href="stylesheets/style.css" type="text/css">
</head>

    
<body>
<!-- class Container makes everything stay centered on the website -->
    
<div class="container">
<?php include ('php/header.php'); ?>
</div>


<div class="container">
   
<?php 
   
    
    /*
    If the url doesn't have a page variable or if it's empty
    show User the About page
    */
    /*!
    Varaible used to browse pages
   */
   $pages = $_GET['page'];
    
    
    /*! \brief If page-variable is empty show about-page
    */
    if(empty($_GET['page']))
    {
        include("php/Pages/about.php");
    }else
    {
        include("php/Pages/" . $pages . ".php");
    }

?>
    
</div>
    
<div class="container">

<?php include('php/footer.php'); ?>

</div>

    
    <script src="script.js"></script>
</body>


</html>