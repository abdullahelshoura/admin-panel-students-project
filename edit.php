<?php
$conn=mysqli_connect("localhost","root","","student");
if(!$conn){
    echo mysqli_connect_error();
    exit;
}
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$select="SELECT * FROM student WHERE student.id=$id LIMIT 1";
$result=mysqli_query($conn,$select);
$row=mysqli_fetch_array($result);


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
</head>
<body>
   
    <div id="mother">
        <form action="" method="post">
            <!-- Insert Student Information -->
            <aside>
                <div id="div">
                    <img src="student-logo.png" alt="Website Logo">
                    <h3>ِAdmin Panel</h3>
                    <label for="">Student Number :</label></br>
                    <input type="text" name="id" id="id" value="<?= (isset($row['id'])) ? $row['id'] :'' ?>" /></br>
                    <h5 style="font-size:13px;margin-top:5px; margin-bottom:10px; color:red;"><?php if (in_array("id",$error_fields))
                    echo "*Please Enter Studen Number"?>
                     </h5>

                    <label for="">Student Name : </label></br>

                    <input type="text" name="name" id="name" value="<?= (isset($row['name'])) ? $row['name'] :'' ?>"></br>
                    <h5 style="font-size:13px;margin-top:5px; margin-bottom:10px;color:red;"><?php if (in_array("name",$error_fields))
                    echo "*Please Enter Student Name"?>
                    </h5> 

                    <label for="">Student Address : </label></br>
                    <input type="text" name="address" id="address" value="<?= (isset($row['address'])) ? $row['address'] :'' ?>" ></br>
                    <h5 style="font-size:13px;margin-top:5px; margin-bottom:10px;color:red;"><?php if (in_array("address",$error_fields))
                    echo "*Please Enter Student Address"?>
                     </h5> 

                    <button name="edit">Edit Student Info</button>
                   
                </div>
            </aside>


            <!-- Display Student Information -->
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
                        <td><a href="delete.php?id= <?=$row['id']?>">Delete</a> </td></tr>
                    </tr> 
                        <?php   }?>
                   
                </table>
            </main>
        </form>
    </div>
</body>
</html>
