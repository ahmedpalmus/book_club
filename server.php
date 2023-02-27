<?php
session_start();
$username = "";
$email = "";
$db = mysqli_connect('localhost', 'root', '', 'jobs');
$errors = array();
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
else
{
    mysqli_set_charset($db, "utf8");
}


if (isset($_POST['reg_user']))
{
    error_log("user registration");
    // receive all input values from the form
    $data = $_POST['reg_user'];
    $object = json_decode($data, true);
    $username = mysqli_real_escape_string($db, $object['username']);
    $email = mysqli_real_escape_string($db, $object['email']);
    $password = mysqli_real_escape_string($db, $object['password']);
    $address = mysqli_real_escape_string($db, $object['address']);
    $mobile = mysqli_real_escape_string($db, $object['mobile']);
    $fullname = mysqli_real_escape_string($db, $object['fullname']);

    
    // first check the database to make sure
    // a user does not already exist with the same username and/or email
    $user_check_query = "SELECT * FROM `company` WHERE `company_name`='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user)
    { // if user exists
        if ($user['username'] === $username)
        {
            echo "error: Username is not available";
        }

        if ($user['email'] === $email)
        {
           echo "error: The email is used by another user";
        }
    }

    // Finally, register user if there are no errors in the form
    if (count($errors) == 0)
    {
        $query = "INSERT INTO `user`(`username`, `password`, `address`, `email`, `phone`, `fullname`) 
                  VALUES('$username','$password', '$address', '$email','$mobile','$fullname')";

        if (mysqli_query($db, $query)) {
            echo "success";
          }
         
    }
}


?>