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
       
        
        $missing_data = array();

        
        if(!empty($_POST['email']))
        {
           
            
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
             echo "<label> Was Username not empty => check</label><br>";
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
        
        
        
        
        
    /*FIRST Check if Username or Email is already registered*/
     $queri = "SELECT Email, Username FROM User_registered WHERE Username = '" . $username . "' OR Email = '" . $email .  "'";
     $db_erg = mysqli_query($dbc, $queri);
     echo "<label> MySQL Query => check</label><br>";
        
     $userData = mysqli_fetch_array( $db_erg);
     echo "<label> Try Getting result => check</label><br>";
    
      if($userData)
      {
          echo "<label>Username or Email already taken!</label>";
          exit();
      }else
      {
          echo "<label> Nothing found => check</label><br>";
      }
        
        
        
      /*If the User is available than register him in database and get him a folder for his stuff*/
      $query = "INSERT INTO User_registered(Email, Username, FName, LName, Password, gender ,Register_date, security, folder_path)VALUES(?,?,?,?,?,?,?,?,?)";
      $stmt = mysqli_prepare($dbc, $query);
      echo "<label> Prepare statement => check</label><br>";
        
      if($stmt)
      {
          echo "<label> Statement good? => yes</label><br>";
       
          /*
          Folderpath will be User + the ID of the User
          this method should allow to search a cetain folder by ID if neccesary        
          */
          $queri = "SELECT ID FROM User_registered ORDER BY ID DESC LIMIT 1";
          $db_erg = mysqli_query($dbc, $queri);
          echo "<label> Query good? => yes</label><br>";
          
          if(!$db_erg)
          {
              $curUser_ID = 1;
             echo "<label> Current User id? => 1</label><br>";
          }else{ 
            $zeile = mysqli_fetch_array( $db_erg);
            $curUser_ID = $zeile['ID'] + 1;
              echo "<label> Current User id? => >1</label><br>";
          }
          
          $folder_path = 'img/User' . $curUser_ID;
          echo "<label> get Data for Folder => check</label><br>";
        
          $curdate = date('Y-m-d');
          echo "<label> get Current date? => yes</label><br>";
        
          /*
          PERMISSION/RANKS:
          0 = Nothing
          1 = default User
          2 = Supporter
          3 = Moderator
          4 = Owner
          */
        
          $permission = 1;   //standard für jeden
        
          mysqli_stmt_bind_param($stmt, "sssssssis", $email, $username, $Fname,$Lname , $password, $gender, $curdate, $permission ,$folder_path );
           echo "<label> Parameters bound? => yes</label><br>";
        
          if(!mysqli_stmt_execute($stmt))
          {
              echo "<label>Failed to Execute Statement</label>";
          }
          mysqli_stmt_close($stmt);
          echo "<label> Statement closed? => yes</label><br>";

      }else{ echo "<label> Statement really good? => no</label><br><br>"; exit(); }
    
      /*
      Create Folder for the User
      */
    
      if (!file_exists($folder_path)) 
      { 
          echo "<label> Folder exits? => no</label><br>";
          mkdir($folder_path, 0777, true); 
          echo "<label> Folder created? => yes</label><br>";
        
          /*After folder should be created check if folder really exits there*/
          if (!file_exists($folder_path)) 
          { 
              echo "<label>Could not create Folder!</label><br>";
              mysqli_close($dbc);
              exit();
          }
      }
          echo "<label> Path good? => yes</label><br><br>";
        
     
        
        
        
        
        
        
        
        
        
    /*--------------------------Sets Profile-pic and Banner image in Database to default----------------------------------------------*/

    
    
    $query = "INSERT INTO profile_settings(User_ID, pofile_picture, bg_pic, tags)VALUES(?,?,?,?)";
    $stmt = mysqli_prepare($dbc, $query);
     echo "<label> Prepare number 2 => check</label><br>";
    
    
    if($stmt)
    {
        
        $upload = 'NULL';
        $default_profilePic = 'img/default/default_profile_pic.jpg';
        $default_banner = 'NULL'; //maybe i find use for this later...
        $tag = "default,pofile,Pixi";
          
        mysqli_stmt_bind_param($stmt, "isss", $curUser_ID, $default_profilePic, $default_banner, $tag);
        echo "<label> Binding number 2 => check</label><br>";
        if(!mysqli_stmt_execute($stmt))
        {
            echo "<label>Failed to Execute second Statement</label><br>";
        }
        mysqli_stmt_close($stmt);
        echo "<label> Statement 2 closed => check</label><br>";
    }
    
        mysqli_close($dbc);
         echo "<label> Close connection => check</label><br>";
    
    
    /*------------------------------------------------------------------------------------------------------------------------------------*/
    
        
        
        
        
        
        
        
        
        
        
    }
    

?>