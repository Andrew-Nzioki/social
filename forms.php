
<?php 
    //upload files destination
    $document_dir = "uploads/documents/";
    $image_dir = "uploads/images/";
    $media_dir = "uploads/media/";
    $uploadOk = 1;

    //Database 
    $servername = "percival"; //replace with your servername
    $username = "Admin"; //replace with database username
    $password = "2Bad$$@@##!!"; // replace with your db user password
    $db = "scheduleApp";

    // new Bucket Form      
    if (isset($_POST['bucket_form'])){                                
        $conn = new mysqli($servername, $username, $password, $db);
        if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

        else{
            $bucket_name = $_POST['bucket_name'];
           

            $bucket_sql = "INSERT INTO bucket (bucket_name) VALUES ('$bucket_name')";
            $created_bucket_sql = "SELECT * FROM bucket WHERE bucket_name='$bucket_name'";

            
            if($conn->query($bucket_sql) === TRUE){
               
                $created_bucket = $conn->query($created_bucket_sql);
                $bucket_row = $created_bucket->fetch_assoc();

                $bucket_id = $bucket_row['id'];
              
                $document_no = 0;

                // Check document and upload
                while($document_no < sizeof($_FILES["documents"]["name"])){
                  
                    $target_document = $document_dir . basename($_FILES["documents"]["name"][$document_no]);

                    
                    $documentType = strtolower(pathinfo($target_document, PATHINFO_EXTENSION));
                    if($documentType != 'docx' && $documentType != 'doc' && $documentType != 'pdf'){
                        echo "Sorry ! Only DOCX, DOC and PDF files accepted<br>";
                        $uploadOk = 0;
                    }

                    if($uploadOk == 0 ){
                        echo "Document not uploaded";
                    }
                    else{
                        if(move_uploaded_file($_FILES["documents"]["tmp_name"][$document_no],$target_document)){
                            $file_name = $_FILES["documents"]["name"][$document_no];
                            $upload_document_sql = "INSERT INTO document (bucket_id, document_name) VALUES ('$bucket_id', '$file_name')";

                            $conn->query($upload_document_sql);
                            echo "Document file uploaded is ", $file_name , " for bucket id ", $bucket_id,"<br>";
                        }
                        
                    }
                    $document_no++;
                }
              
                // check image files and upload
                $image_no = 0;
                while($image_no < sizeof($_FILES["images"]["name"])){
                    
                    $target_image = $image_dir . basename($_FILES["images"]["name"][$image_no]);

                    $imageType = strtolower(pathinfo($target_image, PATHINFO_EXTENSION));
                    if($imageType != 'jpg' && $imageType != 'png' && $documentType != 'jpeg'){
                        echo "Sorry ! Only JPG, JPEG and PNG files accepted<br>";
                        $uploadOk = 0;
                    }

                    if($uploadOk == 0 ){
                        echo "Image file not uploaded";
                    }
                    else{
                        if(move_uploaded_file($_FILES["images"]["tmp_name"][$image_no],$target_image)){
                            $file_name = $_FILES["images"]["name"][$image_no];
                            $upload_image_sql = "INSERT INTO images (bucket_id, image_name) VALUES ('$bucket_id', '$file_name')";

                            $conn->query($upload_image_sql);
                            echo "Image uploaded is ", $file_name, " for bucket id ", $bucket_id,"<br>";
                        }
                        
                    }
                  
                    $image_no++;
                }
                
                // Check media and upload
                $media_no = 0;
                while($media_no < sizeof($_FILES["media"]["name"])){
                    
                    $target_media = $media_dir . basename($_FILES["media"]["name"][$media_no]);

                    $mediaType = strtolower(pathinfo($target_media, PATHINFO_EXTENSION)); 

                    if($mediaType != 'mp4' && $mediaType != 'mp3'){
                        echo "<br>Sorry ! Only MP4 and MP3 files accepted<br>";
                        $uploadOk = 0;
                    }
                    if($uploadOk == 0 ){
                        echo "Media file not uploaded";
                    }
                    else{
                        if(move_uploaded_file($_FILES["media"]["tmp_name"][$media_no],$target_media)){
                            $file_name = $_FILES["media"]["name"][$media_no];
                            $upload_media_sql = "INSERT INTO media (bucket_id, media_name) VALUES ('$bucket_id', '$file_name')";
    
                            $conn->query($upload_media_sql);
                            echo "Media uploaded is ", $file_name, " for bucket id ", $bucket_id,"<br>";
                        }
                       
                    }
                    $media_no++;
                }
              

                // Refresh page
                header("Location: http://localhost/bucketapp/index.php");                 
            }
            else{
               echo "Server not reachable!" . $conn->error;
            }
                      
            $conn->close();
        
        }
    }
    
    //New Post Form
    elseif(isset($_POST['post_form'])){
       
        $conn = new mysqli($servername, $username, $password, $db);
        if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

        else{
            $post_title = $_POST['post_title'];
            $bucket_id = $_POST['bucket'];               
            $post_message = $_POST['post_message'];
            $post_keyword_1 = $_POST['keyword_1'];
            $post_keyword_2 = $_POST['keyword_2'];
            $post_keyword_3 = $_POST['keyword_3'];
            $post_keyword_4 = $_POST['keyword_4'];
            $platform = $_POST['platform'];
            $url = $_POST['profile_url'];

            //sql queries
            $create_post_sql = "INSERT INTO post (bucket_id,title) VALUES ('$bucket_id','$post_title')";
            $selected_post_id_sql = "SELECT  id  FROM post WHERE title ='$post_title'";
           
            
            if($conn->query($create_post_sql) === TRUE){
                $created_post = $conn->query($selected_post_id_sql);
                $post_row = $created_post->fetch_assoc();

                $post_id = $post_row['id'];
                $create_post_message_sql = "INSERT INTO post_message (post_id, post_message) VALUES ('$post_id','$post_message')";
                $create_post_keyword_1_sql = "INSERT INTO post_keywords (post_id, keyword) VALUES ('$post_id','$post_keyword_1')";
                $create_post_keyword_2_sql = "INSERT INTO post_keywords (post_id, keyword) VALUES ('$post_id','$post_keyword_2')";                
                $create_post_profile_sql = "INSERT INTO platform (post_id, platform,profile_url) VALUES ('$post_id','$platform','$url')";
                echo $url;
                
                $conn->query($create_post_message_sql);
                $conn->query( $create_post_keyword_1_sql);
                $conn->query($create_post_keyword_2_sql);
                $conn-> query($create_post_profile_sql);

                //check for empty keywords
                if($post_keyword_3 != "" && $post_keyword_4 != ""){
                    $create_post_keyword_3_sql = "INSERT INTO post_keywords (post_id, keyword) VALUES ('$post_id','$post_keyword_3')";
                    $create_post_keyword_4_sql = "INSERT INTO post_keywords (post_id, keyword) VALUES ('$post_id','$post_keyword_4')";

                    $conn->query($create_post_keyword_3_sql);
                    $conn->query($create_post_keyword_4_sql);
                }
                elseif($post_keyword_3 != "" && $post_keyword_4 == ""){
                    $create_post_keyword_3_sql = "INSERT INTO post_keywords (post_id, keyword) VALUES ('$post_id','$post_keyword_3')";
                    $conn->query($create_post_keyword_3_sql);
                }
                elseif($post_keyword_3 == "" && $post_keyword_4 != ""){
                    $create_post_keyword_4_sql = "INSERT INTO post_keywords (post_id, keyword) VALUES ('$post_id','$post_keyword_4')";
                    $conn->query($create_post_keyword_4_sql);

                }
              

                // Refresh page
                header("Location: http://localhost/bucketapp/index.php");                 
            }
            else{
               echo "Server not reachable!" . $conn->error;
            }
                      
            $conn->close();
        
        }
    }

    // New Schedule form
    elseif(isset($_POST['schedule_form'])){
        $form = $_POST['schedule_form'];
        $conn = new mysqli($servername, $username, $password, $db);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    }

    //Edit bucket form
    elseif(isset($_POST['edit_bucket_form'])){
         $conn = new mysqli($servername, $username, $password, $db);
        if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

        else{
            echo "connection ok <br>";

            $bucket_name = $_POST['bucket_name_hidden'];
           
             // $bucket_sql = "INSERT INTO bucket (bucket_name) VALUES ('$bucket_name')";
            // $created_bucket_sql = "SELECT * FROM bucket WHERE bucket_name='$bucket_name'";

            // Bucket to update
            $bucket_to_update_sql = "SELECT id FROM bucket WHERE bucket_name='$bucket_name'";
            
            if($conn->query( $bucket_to_update_sql) == TRUE){
               echo"db ok!";
               
                $bucket_to_update = $conn->query($bucket_to_update_sql);              
                $bucket_row = $bucket_to_update->fetch_assoc();

                $bucket_id = $bucket_row['id'];

                $update_sql = "UPDATE bucket SET bucket_name='$bucket_name' WHERE id='$bucket_id' ";
              
                $document_no = 0;

                // Check document and upload
                while(sizeof($_FILES["documents"]["name"]) > $document_no){
                  
                    $target_document = $document_dir . basename($_FILES["documents"]["name"][$document_no]);

                    
                    $documentType = strtolower(pathinfo($target_document, PATHINFO_EXTENSION));
                    if($documentType != 'docx' && $documentType != 'doc' && $documentType != 'pdf'){
                        echo "Sorry ! Only DOCX, DOC and PDF files accepted<br>";
                        $uploadOk = 0;
                    }

                    if($uploadOk == 0 ){
                        echo "Document not uploaded";
                    }
                    else{
                        if(move_uploaded_file($_FILES["documents"]["tmp_name"][$document_no],$target_document)){
                            $file_name = $_FILES["documents"]["name"][$document_no];
                            $upload_document_sql = "INSERT INTO document (bucket_id, document_name) VALUES ('$bucket_id', '$file_name')";

                            $conn->query($upload_document_sql);
                            echo "Document file uploaded is ", $file_name , " for bucket id ", $bucket_id,"<br>";
                        }
                        
                    }
                    $document_no++;
                }
              
                // check image files and upload
                $image_no = 0;
                while(sizeof($_FILES["images"]["name"]) > $image_no){
                    
                    $target_image = $image_dir . basename($_FILES["images"]["name"][$image_no]);

                    $imageType = strtolower(pathinfo($target_image, PATHINFO_EXTENSION));
                    if($imageType != 'jpg' && $imageType != 'png' && $documentType != 'jpeg'){
                        echo "Sorry ! Only JPG, JPEG and PNG files accepted<br>";
                        $uploadOk = 0;
                    }

                    if($uploadOk == 0 ){
                        echo "Image file not uploaded";
                    }
                    else{
                        if(move_uploaded_file($_FILES["images"]["tmp_name"][$image_no],$target_image)){
                            $file_name = $_FILES["images"]["name"][$image_no];
                            $upload_image_sql = "INSERT INTO images (bucket_id, image_name) VALUES ('$bucket_id', '$file_name')";

                            $conn->query($upload_image_sql);
                            echo "Image uploaded is ", $file_name, " for bucket id ", $bucket_id,"<br>";
                        }
                        
                    }
                  
                    $image_no++;
                }
                
                // Check media and upload
                $media_no = 0;
                while(sizeof($_FILES["media"]["name"]) > $media_no){
                    
                    $target_media = $media_dir . basename($_FILES["media"]["name"][$media_no]);

                    $mediaType = strtolower(pathinfo($target_media, PATHINFO_EXTENSION)); 

                    if($mediaType != 'mp4' && $mediaType != 'mp3'){
                        echo "<br>Sorry ! Only MP4 and MP3 files accepted<br>";
                        $uploadOk = 0;
                    }
                    if($uploadOk == 0 ){
                        echo "Media file not uploaded";
                    }
                    else{
                        if(move_uploaded_file($_FILES["media"]["tmp_name"][$media_no],$target_media)){
                            $file_name = $_FILES["media"]["name"][$media_no];
                            $upload_media_sql = "INSERT INTO media (bucket_id, media_name) VALUES ('$bucket_id', '$file_name')";
    
                            $conn->query($upload_media_sql);
                            echo "Media uploaded is ", $file_name, " for bucket id ", $bucket_id,"<br>";
                        }
                       
                    }
                    $media_no++;
                }
              

                // Refresh page
                echo "bucket updated";
                header("Location: http://localhost/bucketapp/index.php"); 
                
              
            }
            else{
               echo "Cannot connect to database" . $conn->error;
            }
                      
            $conn->close();
        
        }
    }

    //Edit post form
    elseif(isset($_POST['edit_post_form'])){

    }

    //Edit schedule form
    elseif(isset($_POST['edit_schedule_form'])){

    }
     
    //Delete bucket
    elseif(isset($_POST['delete_bucket'])){

    }

    // Delete post

    //Delete schedule


?>