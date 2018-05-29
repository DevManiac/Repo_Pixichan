<section class="nice_font" id="register">
    
    <h1>Upload an Image!</h1>

    
    <!-- enctype is VERY IMPORTANT for uploading files -->
    <form  id="reg" method="post" action="" enctype="multipart/form-data">
        <input type="file" name="imageToUpload" ><br>
        <button type="submit" name="submit" class="regBtn"><sup>Upload</sup></button>
        
    </form>
    
    <img src="/img/pixi_ganz.png" id="pixi_ganz" >
    

    
    
    
    <?php
    
    
    if(isset($_POST['submit']))
    {
        include('mysqli_con.php');
    
        if(!$dbc) 
        {
            echo "<label>" . mysqli_connect_error() . "</label>";
            exit();
        }
        
        /*
        $_FILE['inputname for fileupload']['attr']
        
        Attr: 
        ['name'] => has the name of the file.extension (f.E. bg.png), ['type'] => has the type of the file(.gif, .jpg, .txt, ...)
        ['tmp_name'] => gets temporary location of the file, ['error'] => checks if a error occured (0 ->no error | 1 -> error)
        ['size'] => gets the size of the File
        */
        
        
        /*$_FILES['Name of input form for upload'] gives information from file*/
        $file = $_FILES['imageToUpload'];
        
        /*check if File has no errors*/
        if($file['error'] == 0)
        {
        
            /*$_POST['imageToUpload']['attr'] to get filename also*/
            $fileName = $file['name'];
            $fileTmp = $file['tmp_name'];
        
            /*to seperate name from extension in name and saves an array (f. E. bg.jpg would be fileExt[0] = bg, fileExt[1] = jpg)*/
            $fileExt = explode('.', $fileName);
            /*end() -> always takes the last element of an array*/
            $fileActualExt = strtolower(end($fileExt));
            
            
            
            /*if you want specific extensions to be uploaded you can make an array with the extensions you want and than chack on upload if file matches these types*/
            $allowedExt = array('jpg', 'jpeg', 'gif', 'png');
            
            if(in_array($fileActualExt, $allowedExt))
            {
                /*you can make an if statement if you want certain filesizes [in kb]*/
            
            
            
            /*uniqid() Gibt eine eindeutige ID mit Präfix zurück, die auf der aktuellen Zeit in Mikrosekunden basiert. */
            $fileName_new = uniqid('', true) . '.' . $fileActualExt;
             
                
        
                
            /*Get's the folder_path from the user to save his pictures in*/
            $queri = "SELECT folder_path FROM `User_registered` WHERE Username = '" . $_SESSION['name'] . "'";
            $db_erg = mysqli_query($dbc, $queri);
            $zeile = mysqli_fetch_array( $db_erg);
                
            
            $fileDestination =  $zeile['folder_path'] . '/' . $fileName_new;

            /*Move file from tmp directory to user_pics*/
            move_uploaded_file($fileTmp, $fileDestination);
            
            
            
            $uploader = $_SESSION['name'];
            $Upload_date = date("Y-m-d", time());
            
            $query = "INSERT INTO Home_Picture_data(Img_title, User_ID, status, canComment, upload_date, Path_to_img)VALUES(?, (SELECT ID FROM User_registered WHERE Username = ? ),?,?,?,?)";
            $stmt = mysqli_prepare($dbc, $query);
            if($stmt)
            {
                $img = 'NULL';
                mysqli_stmt_bind_param($stmt, "ssssss", $img, $uploader , $img, $img, $Upload_date, $fileDestination);
        
            if(!mysqli_stmt_execute($stmt))
            {
                echo "<label>Failed to Execute Statement</label><br>";
            }
                mysqli_stmt_close($stmt);
           
                
            }else
            {

                echo "<label>Failed to create Statement</label><br>";
            }
             
            mysqli_close($dbc);
            header("Location: http://zap36817-1.plesk06.zap-webspace.com/?page=home");
            
            }else
            {
                echo '<br><label>ERROR: Your file has no valid Extension</label>';
            }
                
            
        }else
        {
            echo '<br><label>ERROR: Select a file to upload first</label>';
        }

    }
    ?>
</section>
    