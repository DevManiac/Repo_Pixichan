
<section  id="home" class="nice_font">
    
    

    
    
<?php
        
    require_once('mysqli_con.php');
    
    
    if(!$dbc) 
        {
            echo "<label>" . mysqli_connect_error() . "</label>";
            exit();
           
        }
    
    $queri = "SELECT Username, Path_to_img, Profile_pic_path FROM Home_Picture_data 
              JOIN User_registered ON User_registered.ID = Home_Picture_data.User_ID 
              JOIN Profile_img_data ON User_registered.ID = Profile_img_data.User_ID";
    
    $db_erg = mysqli_query($dbc, $queri);
    
        //check ob db erg was gekriegt hat
    if(!$db_erg)
    {
        echo '<label>Ein Fehler trat auf: ' . mysqli_connect_error() . '</label>';
    }else
    {
    
        if(empty($_SESSION['name']))
        {
            $user = "Guest";
        }else
        {
            $user = $_SESSION['name'];
        }
        
        
        $debug_count = 0;
        while ($zeile = mysqli_fetch_array( $db_erg))
        {
             
            echo '<div class="picture_post"> 
            
                       
                        <div class="topbar">
                            <img src="' . $zeile['Profile_pic_path'] . '" class="profile_img_home" >
                            
                            <div class="Username">
                            <label>' . $zeile['Username'] . '</label>
                            </div>
                        

                            <div class="achievebox">
                            </div>

                        </div>
                        
                        
                        <div class="img_Preview">
                            <img class="img" src="' . $zeile['Path_to_img'] . '" alt="Uploaded by ' . $zeile['Username'] .  '" >
                        </div>
                        
                        
                        <div class="like_commentbar">
                            <ul>
                                <button id="like_no"></button>
                                <button id="comment"></button>
                            <ul>
                        </div>
                        
                        
                        <div class="comments">
                             <img src="' . $zeile['Profile_pic_path'] . '" class="profile_img_home" >
                        
                            <div class="Username_comment">
                                <label>' . $user . '</label>
                                
                                
                                <form action="" method="post">
                                    <input type="text" class="comment_input" name="comment" placeholder="Comment the Picture :)">
                                    <button type="submit" name="submit">Post comment</button>
                                </form>
                            </div>
                        
                        </div>
                        
                        
                  
                  </div>';

        }
        
    }
    
    
    
    /*checks if there submit buton from the above picture_post was pressed*/
    if(isset($_POST['submit']))
    {
         if(empty($_SESSION['name']))
         {
             echo '<script>alert("you must be logged in to use the comment function");</script>';
             mysqli_close($dbc);
             exit();
         }
        
        
        
        
        
        echo '<label>Hello fellow</label>';
    }

    mysqli_close($dbc);
?>
  
</section>





    
