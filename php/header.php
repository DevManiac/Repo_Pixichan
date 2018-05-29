<header class="nice_font" >
    <label>Welcome to Pixichan!</label>
</header>


<section class="nice_font" id="navbar">

        <ul>
        <!--<li><a href="http://zap36817-1.plesk06.zap-webspace.com/?page=home">Home</a></li>-->
        <li><a href="http://zap36817-1.plesk06.zap-webspace.com/">About</a></li>

            
            <?php
            
            
            if(empty($_SESSION['name']))
            {
                /* Solange die seite nicht released ist wird das auskommentiert...später                 wieder entkommentieren!! 
                echo '<li><a href="http://zap36817-1.plesk06.zap-webspace.com/?page=login">Login</a></li>';
                echo '<li><a href="http://zap36817-1.plesk06.zap-webspace.com/?page=register">Register</a></li>';
				*/

            }else
            {
                 echo   '<li><button onclick="window.location.href=\'?page=upload\'" id="btn_upload"></button></li>';
                 echo   '<li><button onclick="window.location.href=\'\'" id="btn_inbox"></button></li>';
                 echo   '<li><button onclick="window.location.href=\'\'" id="btn_search"></button></li>';
                 echo '<li><a href="http://zap36817-1.plesk06.zap-webspace.com/php/Pages/user_profile.php" >Profile</a></li>';
                 echo '<li><a href="http://zap36817-1.plesk06.zap-webspace.com/?page=pseudolog" >Logout</a></li>';
            }
            
            ?>

            
        </ul>

    
    <label id="time"></label>
    
</section>
