<?php
if (isset($_POST['submit'])) {
    if (isset($_POST['name']) &&isset($_POST['enroll']) &&
        isset($_POST['number'])&&isset($_POST['semester'])  &&
        isset($_POST['email']) &&isset($_POST['subject'])&&isset($_POST['reason']) 
        ){
           
            $name=$_POST['name'];
            $enroll=$_POST['enroll'];
            $number=$_POST['number'];
           $semester=$_POST['semester'];
            $email=$_POST['email'];
            $subject=$_POST['subject'];
            $reason=$_POST['reason'];
            $host = "localhost";
            $dbUsername = "root";
            $dbPassword = "";
            $dbName = "reexam";
            $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
            if ($conn->connect_error) {
                die('Could not connect to the database.');
            }
            else{
                $Select="SELECT email FROM registered WHERE email =? LIMIT 1";
                $Insert ="INSERT INTO registered(name,enroll,number,semester,email,subject,reason) values(?,?,?,?,?,?,?)";
                $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($resultEmail);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;
            if ($rnum == 0) {
                $stmt->close();
                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("ssiisss",$name,$enroll,$number,$semester,$email,$subject,$reason);
                if ($stmt->execute()) {
                 header("Location: ending_reexam.html");
                exit(); 
               }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "Someone already registers using this email.";
            }
            $stmt->close();
            $conn->close();
        }
    }
    else {
        echo "All field are required.";
        die();
    }
}
