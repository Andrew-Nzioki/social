<?php
    $servername = "localhost"; //replace with your servername
    $username = "root"; //replace with database username
    $password = ""; // replace with your db user password
    $db = "scheduleApp";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="static/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="static/fontawesome/css/all.css">
    <link rel="stylesheet" href="static/css/index.css">
</head>
<body>
    <nav class="navbar bg-dark navbar-dark">
        <a href="index.html" class="navbar-brand">
            Application
        </a>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a>
                    user
                </a>
            </li>
        </ul>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div id="navigation" class="col-sm-2 col-md-2 col-lg-1 nav navbar-dark bg-dark">
                <ul class="navbar-nav nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a id="home-tab" href="#home" class="nav-link" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true">
                            home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a id="buckets-tab" href="#buckets" class="nav-link " data-toggle="tab" role="tab" aria-controls="buckets" aria-selected="false">
                           buckets
                        </a>
                    </li>
                    <li class="nav-item">
                        <a id="posts-tab" href="#posts" class="nav-link active" data-toggle="tab" role="tab" aria-controls="posts" aria-selected="false">
                           posts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a id="schedule-tab" href="#schedule" class="nav-link" data-toggle="tab" role="tab" aria-controls="schedule" aria-selected="false">
                           schedule
                        </a>
                    </li>
                </ul>
            </div>
            <div id="content" class="col-sm-10 col-md-10 col-lg-11">
                <div class="tab-content">
                    <div id="home" class="tab-pane fade" role="tabpanel" aria-labelledby="home-tab">
                        home
                    </div>
                    <!-- buckets -->
                    <div id="buckets" class="tab-pane fade" role="tabpanel" aria-labelledby="buckets-tab">
                       <div class="card" id="buckets-card">
                            <header class="card-header">
                                <h3>buckets</h3>
                            </header>
                            <div class="card-body">
                                <div id="new">
                                    <button id="add-bucket" class="btn btn-primary" data-toggle="modal" data-target="#new-bucket">
                                        new bucket
                                    </button>
                                </div>
                                <div id="buckets-list">
                                    <header id="latest">
                                        <h5>latest buckets</h5>
                                    </header>
                                    <?php
                                         echo "<table id='buckets-table' class='table col-12'> 
                                                <tr class='table-row'> 
                                                    <th>no.</th> <th> bucket name </th> <th> created on </th><th> updated on </th><th> options</th>
                                                </tr>";
                                        $conn = mysqli_connect($servername, $username, $password, $db); 

                                        if($conn){
                                            $sql = "SELECT * FROM bucket";
                                            $query = $conn->query($sql);
                                            $num = 1;

                                            if($query == TRUE){
                                                while ($row = $query->fetch_assoc()){
                                                    

                                                    echo "<tr class='inner-row'><td>$num</td><td>".$row['bucket_name']."</td> <td>".$row['created_on']."</td><td>".$row['updated_on']."</td>
                                                        <td>                                                                                                        
                                                            <button class='btn btn-primary' data-toggle='modal' data-target='#edit_bucket_".$row['id']."'> edit </button>
                                                    
                                                            <button class='btn btn-danger'> delete </button>                                                    
                                                    
                                                        </td>
                                                    
                                                    </tr>";    
                                                    
                                                    echo "<!-- Bucket Edit -->";
                                                    echo'                                                       
                                                            <div class="modal fade" id="edit_bucket_'.$row['id'].'" tabindex="-1" role="dialog" aria-labelledby="edit-bucket-label" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title ml-auto" id="edit-bucket-label">
                                                                            edit '.$row["bucket_name"].'
                                                                            </h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                        
                                                                            <!-- Edit bucket Form-->
                                                                            <form id="edit_bucket_form" action="forms.php" method="post" enctype="multipart/form-data">
                                                                                <div class="form-group">
                                                                                    <label for="bucket-name">bucket name</label>
                                                                                    <input type="text" name="bucket_name" id="bucket-name" class="form-control" value="'.$row["bucket_name"].'"disabled>
                                                                                </div>  
                                                                                <input type="text" name="bucket_name_hidden" id="bucket-name" value="'.$row["bucket_name"].'" hidden>
                                                                                <div class="form-group">
                                                                                    <div id="document-list"> 
                                                                                        <h5> Documents </h5>
                                                                                        ';
                                                                                            $bucket_id = $row['id'];
                                                                                        
                                                                                            $docs_sql = "SELECT * FROM document WHERE bucket_id = '$bucket_id'";  
                                                                                            $docs_result = $conn->query($docs_sql);
                                                                                        if($docs_result == TRUE){
                                                                                                $docs_no = 0;
                                                                                                echo "<ul>";
                                                                                                while($doc_row = $docs_result->fetch_assoc()){
                                                                                                    echo " <li>".$doc_row['document_name']."</li>";
                                                                                                    $docs_no++;
                                                                                                } 

                                                                                            echo"</ul>";
                                                                                        }
                                                                                        else{
                                                                                            echo "no documents found!";
                                                                                        }
                                                                                        
                                                                                    echo '
                                                                                        <div id="upload-new">
                                                                                            <label for="document">upload new document (DOCX, DOC, PDF)</label>
                                                                                            <input type="file" name="documents[]" multiple="multiple" id="document" class="form-control">
                                                                                        </div>
                                                                                    </div>
                                                                                    
                                                                                </div> 
                                                                                <div class="form-group">                                                                                
                                                                                    <div id="image-list"> 
                                                                                        <h5>Images</h5>
                                                                                        '; 
                                                                                        $img_sql = "SELECT * FROM images WHERE bucket_id = '$bucket_id'";  
                                                                                        $img_result = $conn->query($img_sql);
                                                                                        if($img_result == TRUE){
                                                                                            $img_no = 0;
                                                                                            echo "<ul>";
                                                                                                while($img_row = $img_result->fetch_assoc()){
                                                                                                    echo " <li>".$img_row['image_name']."</li>";
                                                                                                    $img_no++;
                                                                                                } 

                                                                                            echo"</ul>";
                                                                                            }
                                                                                        else{
                                                                                            echo "No images found!";
                                                                                        }
                                                                                        
                                                                                        echo '
                                                                                        <div id="upload-new">
                                                                                            <label for="images">upload new image (JPEG, PNG, JPEG)</label>
                                                                                            <input type="file" name="images[]" multiple="multiple" id="media" class="form-control">
                                                                                        </div>
                                                                                    </div>
                                                                                    
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div id="media-list">
                                                                                        <h5>Media</h5>
                                                                                    '; 
                                                                                    $media_sql = "SELECT * FROM media WHERE bucket_id = '$bucket_id'";  
                                                                                    $media_result = $conn->query($media_sql);
                                                                                    if($media_result == TRUE){
                                                                                            $media_no = 0;
                                                                                            echo "<ul>";
                                                                                            while($media_row = $media_result->fetch_assoc()){
                                                                                                echo " <li>".$media_row['media_name']."</li>";
                                                                                                $media_no++;
                                                                                            } 

                                                                                        echo"</ul>";
                                                                                    }
                                                                                    else{
                                                                                        echo "No media found!";
                                                                                    }
                                                                                
                                                                                echo '
                                                                                        <div id="upload-new">
                                                                                            <label for="media">upload new media (Video or Audio)</label>
                                                                                            <input type="file" name="media[]" multiple="multiple" id="media" class="form-control">
                                                                                        <div>
                                                                                    </div>
                                                                                
                                                                                </div>
                                                                                                        
                                                                                <div class="form-group row">
                                                                                    <div id="cancel" class="col-sm-6 mr-auto">
                                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>                                
                                                                                    </div>
                                                                                    <div id="submit" class="col-sm-6 ml-auto text-right">
                                                                                    <button type="submit" value="save_bucket" name="edit_bucket_form" class="btn btn-primary">Save</button>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>     
                                                    ';
                                                    echo "<!-- Delete Bucket -->";
                                            
                                                    $num++;
                                                }
                                            }
                                            else{
                                                echo "No bucket found!";
                                            }
                                        }
                                        else{
                                            echo "<h6>No database found!</h6>";
                                        }
                                        
                                        mysqli_close($conn);
                                        echo "</table>";
                                    ?>
                                </div>
                            </div>
                       </div>
                    </div>

                    <!-- posts -->
                    <div id="posts" class="tab-pane fade  show active" role="tabpanel" aria-labelledby="posts-tab">
                        <div class="card" id="posts-card">
                            <header class="card-header">
                                <h3>posts</h3>
                            </header>
                            <div class="card-body">
                               <div id="new">
                                   <button id="add-post" class="btn btn-primary" data-toggle="modal" data-target="#new-post">
                                       new post
                                   </button>
                               </div>
                               <div id="posts-list">
                                   <header id="latest">
                                       <h5>latest posts</h5>
                                   </header>
                                   <?php
                                         echo "<table id='posts-table' class='table col-12'> 
                                                <tr class='table-row'> 
                                                    <th>no.</th> <th> title </th> <th> created on </th><th> updated on </th><th> options</th>
                                                </tr>";
                                        $conn = mysqli_connect($servername, $username, $password, $db); 

                                        if($conn){
                                            $sql = "SELECT * FROM post";                                           
                                            $query = $conn->query($sql);
                                            $num = 1;

                                            if($query == TRUE){
                                                while ($row = $query->fetch_assoc()){
                                                    echo"
                                                        <tr>
                                                            <td>".$num."</td>
                                                            <td> ".$row['title']."</td>
                                                            <td> ".$row['created_on']."</td>
                                                            <td> ".$row['edited_on']."</td>
                                                            <td>
                                                                <button class='btn btn-primary' data-toggle='modal' data-target='#edit_post_".$row['id']."'> edit </button>                                                        
                                                                <button class='btn btn-danger'> delete </button>
                                                            </td>
                                                        </tr>
                                                    ";
                                                    echo "<!-- Post Edit -->";
                                                    echo'                                                       
                                                            <div class="modal fade" id="edit_post_'.$row['id'].'" tabindex="-1" role="dialog" aria-labelledby="edit-post-label" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title ml-auto" id="edit-post-label">
                                                                            edit '.$row["title"].'
                                                                            </h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                        
                                                                            <!-- Edit post Form-->
                                                                            <form id="create_post_form" action="forms.php" method="post" enctype="multipart/form-data">
                                                                                <div class="form-group row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="input-group">
                                                                                                <div class="input-group-prepend">
                                                                                                    <span class="input-group-text">
                                                                                                        title
                                                                                                    </span>
                                                                                                </div>
                                                                                                <input type="text" name="post_title" id="post-title" required class="form-control" value="'.$row["title"].'">

                                                                                
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="input-group">
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-text">
                                                                                                    bucket
                                                                                                </span>
                                                                                            </div>
                                                                                                ';
                                                                                                    $bucket_id = $row["bucket_id"];
                                                                                                    $get_bucket_name = "SELECT * FROM bucket WHERE id='$bucket_id'";
                                                                                                    $bucket_name_rows = $conn->query($get_bucket_name);
                                                                                                    $bucket_name_row = $bucket_name_rows->fetch_assoc();
                                                                                                  

                                                                                                    echo ' <select name="bucket" id="bucket" class="form-control col-8" required>
                                                                                                            <option value="'.$bucket_name_row["id"].'"> '.$bucket_name_row["bucket_name"].'</option>
                                                                                                    ';

                                                                                                    //Get all buckets in the db and display as options for select field
                                                                                                    $conn = mysqli_connect($servername, $username, $password, $db); 
                                                                                                    if(!$conn){
                                                                                                        die("Connection failed: " . mysqli_connect_error());
                                                                                                        echo "" . mysqli_connect_error();
                                                                                                    }
                                                                                                    else{
                                                                                                        $get_buckets_sql = "SELECT * FROM bucket";
                                                                                                        
                                                                                                        $buckets = $conn->query($get_buckets_sql);

                                                                                                        if($buckets == TRUE){
                                                                                                        $buckets_no= 0;

                                                                                                        while($bucket_row = $buckets->fetch_assoc()){
                                                                                                            if($bucket_row["bucket_name"] == $bucket_name_row["bucket_name"]){
                                                                                                               $buckets_no-=1;
                                                                                                            }
                                                                                                            else{
                                                                                                                echo '<option value='.$bucket_row["id"].'> '.$bucket_row["bucket_name"].'</option>';
                                                                                                                $buckets_no++;
                                                                                                            }
                                                                                                           
                                                                                                        }
                                                                                                        }
                                                                                                        else{
                                                                                                            echo "Cannot find Database" , $buckets->error_log;
                                                                                                        }
                                                                                                    }
                                                                                                    echo'</select>;

                                                                                                
                                                                                            
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <div class="col-sm-12">
                                                                                        <label for="post_message">message</label>
                                                                                        <textarea name="post_content" id="post_message" cols="30" rows="6" class="form-control" required></textarea>
                                                                                    </div>                                          
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <div class="col-sm-12">
                                                                                        <label for="keyword">keywords</label>
                                                                                    </div>
                                                                                    <div class="col-md-6 input-group">
                                                                                        <div class="input-group-prepend">
                                                                                                <span class="input-group-text">
                                                                                                    #1
                                                                                                </span>
                                                                                        </div>
                                                                                        <input type="text" name="keyword_1" id="keyword" class="form-control" required>
                                                                                    </div>
                                                                                    <div class="col-md-6 input-group">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text">
                                                                                                #2
                                                                                            </span>
                                                                                        </div>
                                                                                        <input type="text" name="keyword_2" id="keyword" class="form-control" required>
                                                                                    </div>
                                                                                    <div class="col-md-6 input-group">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text">
                                                                                                #3
                                                                                            </span>
                                                                                    </div>
                                                                                        <input type="text" name="keyword_3" id="keyword" class="form-control">
                                                                                    </div>
                                                                                    <div class="col-md-6 input-group">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text">
                                                                                                #4
                                                                                            </span>
                                                                                    </div>
                                                                                        <input type="text" name="keyword_4" id="keyword" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <div class="col-12">
                                                                                        <label for="platform">post to</label>
                                                                                    </div>
                                                                                    <div class="col-md-6 input-group">                                               
                                                                                        <div class="input-group-prepend">
                                                                                            <spn class="input-group-text">
                                                                                                platform
                                                                                            </spn>
                                                                                        </div>
                                                                                        <select name="platform" id="platform" class="form-control col-8" required>
                                                                                            <option value="facebook">facebook</option>
                                                                                            <option value="instagram">instagram</option>
                                                                                            <option value="linkedin">linkedin</option>
                                                                                        </select>                                            
                                                                                    </div>
                                                                                    <div class="col-md-6 input-group">
                                                                                        <div class="input-group-prepend">
                                                                                            <spn class="input-group-text">
                                                                                            profile
                                                                                            </spn>
                                                                                        </div>
                                                                                        <input type="url" name="profile" id="profile" class="form-control" required>
                                                                                    </div>
                                                                                </div>
                                                                            
                                                                                <div class="form-group row">
                                                                                    <div id="cancel" class="col-sm-6 mr-auto">
                                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>                                
                                                                                    </div>
                                                                                    <div id="submit" class="col-sm-6 ml-auto text-right">
                                                                                        <button type="submit" value="create post" name="post_form" class="btn btn-primary">Save</button>
                                                                                    </div>
                                                                                    
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>     
                                                    ';
                                                    
                                                    $num++;
                                                }
                                            }
                                            else{
                                                echo "No posts found!";
                                            }
                                        }
                                        else{
                                            echo "<h6>No database found!</h6>";
                                        }
                                        
                                        mysqli_close($conn);
                                        echo "</table>";
                                    ?>
                               </div>
                            </div>
                       </div>
                    </div>

                    <!-- schedule -->
                    <div id="schedule" class="tab-pane fade" role="tabpanel" aria-labelledby="schedule-tab">
                        <div class="card" id="schedule-card">
                            <header class="card-header">
                                <h3>schedule</h3>
                            </header>
                            <div class="card-body">
                                <div id="new">
                                    <button id="add-schedule" class="btn btn-primary" data-toggle="modal" data-target="#new-schedule">
                                        new schedule
                                    </button>
                                </div>
                                <div id="schedule-list">
                                    <header id="latest">
                                        <h5>latest schedule</h5>
                                    </header>
                                    <table id="schedule-table">
 
                                    </table>
                                </div>
                             </div>
                       </div>
                    </div>

                    <!-- Modals -->

                    <!-- buckets-->
                    <div class="modal fade" id="new-bucket" tabindex="-1" role="dialog" aria-labelledby="new-bucket-label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title ml-auto" id="new-bucket-label">create new bucket</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="create_bucket_form" action="forms.php" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="bucket-name">bucket name</label>
                                            <input type="text" name="bucket_name" id="bucket-name" required class="form-control">
                                        </div>  
                                        <div class="form-group">
                                            <label for="documents">upload document (DOCX, DOC, PDF)</label>
                                            <input type="file" name="documents[]" multiple="multiple" id="documents" class="form-control" required>
                                        </div> 
                                        <div class="form-group">
                                            <label for="images">upload image (JPEG, PNG, JPEG)</label>
                                            <input type="file" name="images[]" multiple="multiple" id="images" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="media">upload media (Video or Audio)</label>
                                            <input type="file" name="media[]" multiple="multiple" id="media" class="form-control">
                                        </div>
                                                              
                                       <div class="form-group row">
                                           <div id="cancel" class="col-sm-6 mr-auto">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>                                
                                          </div>
                                          <div id="submit" class="col-sm-6 ml-auto text-right">
                                            <button type="submit" value="create_bucket" name="bucket_form" class="btn btn-primary">Create</button>
                                           </div>
                                       </div>
                                    </form>
                                </div>                              
                            </div>
                          </div>
                    </div>                   

                    <!-- posts -->
                    <div class="modal fade" id="new-post" tabindex="-1" role="dialog" aria-labelledby="new-post-label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content modal-lg">
                                <div class="modal-header">
                                    <h5 class="modal-title ml-auto" id="new-post-label">create new post</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <!-- Create Post Form-->
                                    <form id="create_post_form" action="forms.php" method="post" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                               <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            title
                                                        </span>
                                                    </div>
                                                    <input type="text" name="post_title" id="post-title" required class="form-control">
                                               </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            bucket
                                                        </span>
                                                    </div>
                                                        
                                                        <?php
                                                            echo ' <select name="bucket" id="bucket" class="form-control col-8" required>';

                                                            //Get all buckets in the db and display as options for select field
                                                            $conn = mysqli_connect($servername, $username, $password, $db); 
                                                            if(!$conn){
                                                                die("Connection failed: " . mysqli_connect_error());
                                                                echo "" . mysqli_connect_error();
                                                            }
                                                            else{
                                                                $get_buckets_sql = "SELECT * FROM bucket";
                                                                
                                                                $buckets = $conn->query($get_buckets_sql);

                                                                if($buckets == TRUE){
                                                                  $buckets_no= 0;

                                                                  while($bucket_row = $buckets->fetch_assoc()){
                                                                    echo '<option value='.$bucket_row["id"].'> '.$bucket_row["bucket_name"].'</option>';
                                                                    $buckets_no++;
                                                                  }
                                                                }
                                                                else{
                                                                    echo "Cannot find Database" , $buckets->error_log;
                                                                }
                                                            }
                                                            echo'</select>';

                                                        ?>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label for="post-message">message</label>
                                                <textarea name="post_message" id="post_message" cols="30" rows="6" class="form-control" required></textarea>
                                            </div>                                          
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label for="keyword">keywords</label>
                                            </div>
                                            <div class="col-md-6 input-group">
                                                <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            #1
                                                        </span>
                                                </div>
                                                <input type="text" name="keyword_1" id="keyword" class="form-control" required>
                                            </div>
                                            <div class="col-md-6 input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        #2
                                                    </span>
                                                </div>
                                                <input type="text" name="keyword_2" id="keyword" class="form-control" required>
                                            </div>
                                            <div class="col-md-6 input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        #3
                                                    </span>
                                            </div>
                                                <input type="text" name="keyword_3" id="keyword" class="form-control">
                                            </div>
                                            <div class="col-md-6 input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        #4
                                                    </span>
                                            </div>
                                                <input type="text" name="keyword_4" id="keyword" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-12">
                                                <label for="platform">post to</label>
                                            </div>
                                            <div class="col-md-6 input-group">                                               
                                                   <div class="input-group-prepend">
                                                       <spn class="input-group-text">
                                                          platform
                                                       </spn>
                                                   </div>
                                                <select name="platform" id="platform" class="form-control col-8" required>
                                                    <option value=""></option>
                                                    <option value="facebook">facebook</option>
                                                    <option value="instagram">instagram</option>
                                                    <option value="linkedin">linkedin</option>
                                                </select>                                            
                                            </div>
                                            <div class="col-md-6 input-group">
                                                <div class="input-group-prepend">
                                                    <spn class="input-group-text">
                                                       profile
                                                    </spn>
                                                </div>
                                                <input type="url" name="profile_url" id="profile" class="form-control" required>
                                            </div>
                                        </div>
                                       
                                       <div class="form-group row">
                                           <div id="cancel" class="col-sm-6 mr-auto">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>                                
                                          </div>
                                          <div id="submit" class="col-sm-6 ml-auto text-right">
                                            <button type="submit" value="create post" name="post_form" class="btn btn-primary">Create</button>
                                           </div>
                                           
                                       </div>
                                    </form>
                                </div>
                             
                            </div>
                          </div>
                    </div>

                    <!--schedule -->
                    <div class="modal fade" id="new-schedule" tabindex="-1" role="dialog" aria-labelledby="new-schedule-label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title ml-auto" id="new-schedule-label">create new schedule</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!--Create schedule form-->
                                    <form id="create_schedule_form" action="forms.php" method="post" enctype="multipart/form-data">
                                       
                                       
                                       <div class="form-group row">
                                           <div id="cancel" class="col-sm-6 mr-auto">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>                                
                                          </div>
                                          <div id="submit" class="col-sm-6 ml-auto text-right">
                                            <button type="submit" value="create schedule" name="schedule_form" class="btn btn-primary">Create</button>
                                           </div>
                                       </div>
                                    </form>
                                </div>
                            
                            </div>
                          </div>
                    </div>
                            
                    <!-- Post Edit -->

                    <!-- Schedule Edit -->
                   
            </div>
        </div>
              
    </div>

    <script src="static/jquery/jquery-3.6.0.js"></script>
    <script src="static/popper/popper-2.9.1.js"></script>
    <script src="static/bootstrap/js/bootstrap.js"></script>
    <script src="static/js/form.js"></script>
   
</body>
</html>