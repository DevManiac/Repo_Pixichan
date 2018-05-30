
<!-- 

My Goal here is to get the register and the login form on one page.
The login and register -php stuff is in 2 seperate <?php?> tags.

-->
<section>

    <fieldset>
    <legend>Register [* is required]</legend>
    
    <form action="" method="POST">
        <input type="text" name="email" placeholder="Your email address*"/>
        <input type="text" name="username" placeholder="Create a username*"/>
        <input type="password" name="password" placeholder="Create a password*"/>
        <input type="text" name="FName" placeholder="First Name"/>
        <input type="text" name="LName" placeholder="Last Name"/>
        <input type="text" name="gender" placeholder="Your gender"/>
        <input type="submit" name="reg_submit" value="Register now"/>
        
    </form>
        
        
    </fieldset>

    <fieldset>
    <legend>Login</legend>
    <form action="" method="POST">
        <input type="text" name="username" placeholder="Your username"/>
        <input type="password" name="password" placeholder="Your password"/>
        <input type="submit" name="log_submit" value="Log in"/>
    </form>
    </fieldset>


</section>

<!-- Login -->
<?php

?>



<!-- Register -->
<?php
    
    include('mysqli_con.php');
    /*check if there is a connection*/
    if(!$dbc) 
    {
        echo "<label>" . mysqli_connect_error() . "</label>";
        exit();
    }


    



    if(isset($_POST['reg_submit']))
    {
       
        /*Array that saves every name of field that is missing from the register form*/
        $missing_data = array();

        
        if(!empty($_POST['email']))
        {
           
            /*Email validation if the $_POST variable has something in it
              I use regex101.com to check if this validates correctly ^^
            */
            if(!preg_match("/[A-Za-z.-_]*@[A-Za-z]*.[a-z.]{2,}/", $_POST['email']))
            {
                $missing_data[] = "Email";
                 exit();
            }else
            {
                $email = $_POST['email'];
        
            }
            
        }else
        {
            $missing_data[] = "Email";
            exit();
        }

        
        
        
        
        if(!empty($_POST['username']))
        {
            
            if(!preg_match("/[A-Za-z_.0-9]{3,}/", $_POST['username']))
            {
                $missing_data[] = "Username";
                 exit();
            }else
            {
                $username = $_POST['username'];
            }
            
            
        }else
        {
            $missing_data[] = "Username";
            exit();
        }
        
        
        
        if(!empty($_POST['password']))
        {
            if(!preg_match("/[A-Za-z_.0-9]{5,}/", $_POST['password']))
            {
                $missing_data[] = "Password";
                exit();
            }else
            {
                $password = $_POST['password'];
            }
        }else
        {
            $missing_data[] = "Password";
            exit();
        }
        
        
        /*
        First name/Last name and gender is Optional so their name will not be 
        saved in the $missing_data array. Instead if they are empty or invalid they get just set tu NULL
        */
        if(!empty($_POST['FName']))
        {
        
            if(!preg_match("/^[^0-9]+$/", $_POST['FName']))
            {
                $Fname = "NULL";

            }else
            {
                $Fname = $_POST['FName'];

            }
            
        }else
        {
            $Fname = "NULL";

        }
        
        
        
         if(!empty($_POST['LName']))
        {

            
            if(!preg_match("/^[^0-9]+$/", $_POST['LName']))
            {
                $Lname = "NULL";

            }else
            {
                $Lname = $_POST['LName'];
            }
            
        }else
        {
            $Lname = "NULL";
        }
        
        
        
        
        
        if(!empty($_POST['gender']))
        {
            
            if(!preg_match("/^[^0-9]+$/", $_POST['gender']))
            {
                $gender = "NULL";
            }else
            {
                $gender = $_POST['gender'];

            }
            
        }else
        {
            $gender = "NULL";
        }
        
        
        
    /*IF register-Form was okay than set everthing in the Database accordingly*/
        
        
        
    /*FIRST Check if Username or Email is already registered*/
     $queri = "SELECT Email, Username FROM User_registered WHERE Username = '" . $username . "' OR Email = '" . $email .  "'";
     $db_erg = mysqli_query($dbc, $queri);
    
     $userData = mysqli_fetch_array( $db_erg);
     
    
      if($userData)
      {
          echo "<label>Username or Email already taken!</label>";
          exit();
      }
        
        
      /*If the User is available than register him in database and get him a folder for his stuff*/
      $query = "INSERT INTO User_registered(Email, Username, FName, LName, Password, gender ,Register_date, security, folder_path)VALUES(?,?,?,?,?,?,?,?,?)";
      $stmt = mysqli_prepare($dbc, $query);
     
        
      if($stmt)
      {
       
          /*
          Folderpath will be User + the ID of the User
          this method should allow to search a cetain folder by ID if neccesary        
          */
          $queri = "SELECT ID FROM User_registered ORDER BY ID DESC LIMIT 1";
          $db_erg = mysqli_query($dbc, $queri);
          
          /*
          if no user is in the database yet and the result gets nothing just set current userid
          to 1.
          */
          if(!$db_erg)
          {
              $curUser_ID = 1;
             
          }else{ 
            $zeile = mysqli_fetch_array( $db_erg);
            $curUser_ID = $zeile['ID'] + 1;
            
          }
          
          $folder_path = 'img/User' . $curUser_ID;

          $curdate = date('Y-m-d'); //get's current date the user registers
          
        
          /*
          PERMISSION/RANKS:
          0 = Nothing
          1 = default User
          2 = Supporter
          3 = Moderator
          4 = Owner
          */
        
          $permission = 1;   //standard for everybody
        
          mysqli_stmt_bind_param($stmt, "sssssssis", $email, $username, $Fname,$Lname , $password, $gender, $curdate, $permission ,$folder_path );
         
        
          if(!mysqli_stmt_execute($stmt))
          {
              echo "<label>Failed to Execute Statement</label>";
          }
          mysqli_stmt_close($stmt);

      }
    
      /*
      Create Folder for the User
      */
    
      if (!file_exists($folder_path)) 
      { 
          
          mkdir($folder_path, 0777, true); 
        
          /*
          After folder should be created check if folder really exits there
          if so than close connection and exit script
          (function to delete the user from the database again or some other handling of such a scenario 
          is beeing thought off ^^")
          */
          if (!file_exists($folder_path)) 
          { 
              mysqli_close($dbc);
              exit();
          }
      }
         
        
        
        
        
        
        
    /*--------------------------Sets Profile-pic and Banner image in Database to default----------------------------------------------*/

    
    
    $query = "INSERT INTO profile_settings(User_ID, pofile_picture, bg_pic, tags)VALUES(?,?,?,?)";
    $stmt = mysqli_prepare($dbc, $query);
    
    
    
    if($stmt)
    {
        
        $upload = 'NULL';
        $default_profilePic = 'img/default/default_profile_pic.jpg';
        $default_banner = 'NULL'; //maybe i find use for this later...
        $tag = "default,pofile,Pixi";
          
        mysqli_stmt_bind_param($stmt, "isss", $curUser_ID, $default_profilePic, $default_banner, $tag);
        
        if(!mysqli_stmt_execute($stmt))
        {
            echo "<label>Failed to Execute second Statement</label><br>";
        }
        mysqli_stmt_close($stmt);
    }
    
        mysqli_close($dbc);
    
    
    /*------------------------------------------------------------------------------------------------------------------------------------*/
    
        
        
    /*
    
    There are some Tables in the Database who need to get configured but are not programmed out yet.
    because i am documenting and setting things up for github :p ...
    
    */
        
        
        
        
        
        
        
    }
    

?>