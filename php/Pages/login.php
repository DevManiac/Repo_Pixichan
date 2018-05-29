<section class="nice_font" id="register">
    
    <h1>Log in!</h1>

    <form  id="reg" method="post" action="">
        
        <input type="text" name="Username" class="regBox" placeholder="Enter your Username"><br>
        <input type="password" name="Password" class="regBox" placeholder="Enter your Password"><br>
        <button type="submit" name="submit" class="regBtn"><sup>Login</sup></button>
    
    </form>
    
    <img src="/img/pixi_ganz.png" id="pixi_ganz" >
    
    
    <?php
                
    include('mysqli_con.php');

    /*Array zum speichern wenn ein Feld leer oder ungültig ist*/
    if(isset($_POST['submit']))
    {

        /*check if there is a connection*/
        if(!$dbc) 
            {
            echo "<label>" . mysqli_connect_error() . "</label>";
            exit();
            }

        
        $queri = "SELECT Username, Password FROM User_registered WHERE Username = '" . $_POST['Username'] . "'";
        $db_erg = mysqli_query($dbc, $queri);
        
        $userData = mysqli_fetch_array( $db_erg);
        
        //echo "<label>" . $userData['Username'] . '__'. $userData['Password'] . "</label>";
        
        if($userData)
        {
        
            if($userData['Password'] === md5($_POST['Password']))
            {
                echo "<label>Login Successfull</label>";
                
                mysqli_close($dbc);
    
                $_SESSION['name'] = $userData['Username'];
                header("Location: http://zap36817-1.plesk06.zap-webspace.com/php/Pages/user_profile.php");
                exit();
            }else
                echo "<label>Passwort does not match :(</label>";
            
            
            
        }else
        {
            echo '<label>User does not exist</label>';
        }
        
        
    
    
    }


?>
    
    
    

    
    
    

</section>
