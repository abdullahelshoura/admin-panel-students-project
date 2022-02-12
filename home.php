<?php
$error_fields=array();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //VALIDATION
    if(! (isset($_POST['id']) && !empty($_POST['id'])) ) {
        $error_fields[]="id";
    }

    if(! (isset($_POST['name']) && !empty($_POST['name'])) ) {
        $error_fields[]="name";
    }

    if(! (isset($_POST['address']) && !empty($_POST['address'])) ) {
        $error_fields[]="address";
    }

    

    if(! $error_fields) {
        //Connect to DB
        $host='localhost';
        $user='root';
        $pass='';
        $db='student';
        $conn=mysqli_connect($host,$user,$pass,$db);
        if(!$conn){
            echo mysqli_connect_error();
            exit;
        }
       
        //Escape any special chars to avoid SQL injection
        if (isset($_POST['add'])) {
            $id=$_POST['id'];
            $name=$_POST['name'];
            $address=$_POST['address'];
            
            $query="INSERT INTO student (id,name,address) Values ($id,'$name','$address')";
            $result=mysqli_query($conn,$query);
            if ($result) {
                header("Location: home.php");
                exit;
            }else {
                echo mysqli_error($conn);
            }
                
            mysqli_close($conn);
        }

        if (isset($_POST['edit'])) {
            $id=$_POST['id'];
            $name=$_POST['name'];
            $address=$_POST['address'];
            
            $query="UPDATE student SET id=$id,name='$name',address='$address' WHERE student.id=$id";
            $result=mysqli_query($conn,$query);
            if ($result) {
                header("Location: home.php");
                exit;
            }else {
                echo mysqli_error($conn);
            }
                
            mysqli_close($conn);
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <!-- <script src="js/bootstrap.js"></script> -->
</head>
<body>
   <div class="d-flex justify-content-center container-fluid">
    <div class="d-flex justify-content-center row " id="mother">
        <div id="form-col" class=" col-lg-3">
            <form action="" method="post">
                <!-- Insert Student Information -->
                <aside>
                    <div id="div">
                        <img src="images/student-logo.png" alt="Website Logo">
                        <h3>ِAdmin Panel</h3>
                        <label for="">Student Number :</label></br>
                        <input type="text" name="id" id="id" value="<?php if (isset($_POST['id'])){ echo $_POST['id'];}?>" /></br>
                        <h5 style="margin-top:5px; margin-bottom:10px; color:red;"><?php if (in_array("id",$error_fields))
                        echo "*Please Enter Studen Number"?>
                        </h5>

                        <label for="">Student Name : </label></br>

                        <input type="text" name="name" id="name" value="<?php if (isset($_POST['name'])){ echo $_POST['name'];}?>"></br>
                        <h5 style="margin-top:5px; margin-bottom:10px;color:red;"><?php if (in_array("name",$error_fields))
                        echo "*Please Enter Student Name"?>
                        </h5> 

                        <label for="">Student Address : </label></br>
                        <input type="text" name="address" id="address" value="<?php if (isset($_POST['address'])){ echo $_POST['address'];}?>" ></br>
                        <h5 style="margin-top:5px; margin-bottom:10px;color:red;"><?php if (in_array("address",$error_fields))
                        echo "*Please Enter Student Address"?>
                        </h5> 

                        <button name="add">Add Student</button>
                    
                    </div>
                </aside>
            </form>
        </div>   
            <!-- Display Student Information -->
        <div class=" col-lg-9">
            <main>
                <table id="tbl">
                    <tr>
                        <th>Student ID</th>
                        <th>Student Name</th>
                        <th>Student Address</th>
                        <th>Actions</th>
                    </tr>
                    
                    <?php
                    $host='localhost';
                    $user='root';
                    $pass='';
                    $db='student';
                    $conn=mysqli_connect($host,$user,$pass,$db);
                    if(!$conn){
                        echo mysqli_connect_error();
                        exit;
                    }
                    $selected=mysqli_query($conn,'SELECT * FROM student');
                        while ($row=mysqli_fetch_array($selected)) { ?>
                    <tr>
                        <td><?=$row['id']?></td> 
                        <td><?=$row['name']?></td>
                        <td><?=$row['address']?></td>
                        <td><a href="edit.php?id= <?=$row['id']?>">Edit</a> <span>|</span> <a href="delete.php?id= <?=$row['id']?>">Delete</a> </td></tr>
                    </tr> 
                        <?php   }?>
                    
                </table>
            </main>
        </div>
        
    </div>
    </div>
</body>
</html>