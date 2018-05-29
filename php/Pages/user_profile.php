<?php

session_start();


?>

<html>

<head>
    <title>Home</title>
     <meta name="viewport" content="width=device-width">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="stylesheet" href="../../stylesheets/user_profile_style.css" type="text/css">
</head>


<body>
    
    <div class="container">
  
    
         <?php include('../header.php'); ?>
    
        
        <section id="home" class="nice_font">
    
            <h2 id="pic_title">Your Pictures</h2>
            <?php
        
                require_once('../../mysqli_con.php');

    
                if(!$dbc) 
                {
                    echo "<label>" . mysqli_connect_error() . "</label>";
                    exit();
           
                }
    
            $queri = "SELECT Path_to_img FROM Home_Picture_data WHERE User_ID = (SELECT ID FROM User_registered WHERE Username = '" . $_SESSION['name'] ."')";
    
            $db_erg = mysqli_query($dbc, $queri);
    
                //check ob db erg was gekriegt hat
                if(!$db_erg)
                {
                    echo '<label>Ein Fehler trat auf: ' . mysqli_connect_error() . '</label>';
                }else
                {
       
                    while ($zeile = mysqli_fetch_array( $db_erg))
                    {
             
                        echo   '<div class="PicShow"> 
                        
                                    <label>' . $zeile['Username'] . '</label><br>
                                    <img class="img" src="../../' . $zeile['Path_to_img'] . '">
                  
                                </div>';
                    }
                }      
            ?>
  
        </section>

        
        
        <?php
        
        
        ?>
        
    
            
        <?php include ('../footer.php'); ?>

     </div>
     <script src="../../script.js"></script>
</body>
    
    

</html>



