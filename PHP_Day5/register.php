<?php
require_once "components/db_connect.php";
require_once "components/file_upload.php";

session_start(); // start a new session or continues the previous
//the name of the input could be the same name of the database//
if (isset($_SESSION['user']) != "") {
    header("Location: home.php"); // redirects to home.php
}
if (isset($_SESSION['adm']) != "") {
    header("Location: dashboard.php"); // redirects to home.php
}
require_once 'components/db_connect.php';
require_once 'components/file_upload.php';
$error = false; //by default is false=we dont have any errors
$fname = $lname = $birth = $email = $pass = $picture = '';
$fnameError = $lnameError = $dateError = $emailError = $passError = $picError = '';
if (isset($_POST['btn-signup'])) {

    // sanitise user input to prevent sql injection
    $fname = trim($_POST['fname']);    // trim - strips whitespace (or other characters) from the beginning and end of a string

    $fname = strip_tags($fname);    // strip_tags -- strips HTML and PHP tags from a string
   
    $fname = htmlspecialchars($fname);// htmlspecialchars converts special characters to HTML entities
    /* to not repeat all that for every single variable write a function up there-delete if:
        function cleanInput($var){
            $value = trim($var);
            $value = strip_tags($var);
            $value = htmlsprecialchars($var);
        } 
        if(isset($_POST["btn-singup"])){
            $fname=cleanInput($_POST["fname"]); 
            $lname=cleanInput($_POST["lname"]);
            $birth=cleanInput($_POST["birth"]);
            $email=cleanInput($_POST["email"]);
            $pass=cleanInput($_POST["pass"]);
            $fname=cleanInput($_POST["fname"]);
        }
        */
    $lname = trim($_POST['lname']);
    $lname = strip_tags($lname);
    $lname = htmlspecialchars($lname);

    $birth = trim($_POST['birth']);
    $birth = strip_tags($birth);
    $birth = htmlspecialchars($birth);

    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $pass = trim($_POST['pass']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);

    $uploadError = '';
    $picture = file_upload($_FILES['picture']);

    // basic name validation
    if (empty($fname) || empty($lname)) {//if first or last name empty
        $error = true;
        $fnameError = "Please enter your full name and surname";
    } else if (strlen($fname) < 3 || strlen($lname) < 3) {
        $error = true;
        $fnameError = "Name and surname must have at least 3 characters.";
    } else if (!preg_match("/^[a-zA-Z]+$/", $fname) || !preg_match("/^[a-zA-Z]+$/", $lname)) { //to be able to insert just letters,if we want to be able to put 2 last names, we have to change the end "/^[a-zA-Z]/-regex quich reference"
        $error = true;
        $fnameError = "Name and surname must contain only letters and no spaces.";
    }
 // checks if the date input was left empty
 if (empty($birth)) {
    $error = true;
    $dateError = "Please enter your date of birth.";
}
    // basic email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {//just emails string@string.string
        $error = true;
        $emailError = "Please enter valid email address.";
    } else {
        // checks whether the email exists or not
        $query = "SELECT email FROM user WHERE email='$email'";
        $result = mysqli_query($connect, $query);//always put, wihtout it would be like tipping the query without presing go, without running it
        $count = mysqli_num_rows($result);
        if ($count != 0) {
            $error = true;
            $emailError = "Provided Email is already in use.";
        }
    }
       // password validation
    if (empty($pass)) {
        $error = true;
        $passError = "Please enter password.";
    } else if (strlen($pass) < 6) {
        $error = true;
        $passError = "Password must have at least 6 characters.";
    }

    // password hashing for security
    $password = hash('sha256', $pass); //sha256 form of the hash
    // if there's no error, continue to signup
    if (!$error) { //if the error ist faulse

        $query = "INSERT INTO user(fname, lname,  birth, email, password, picture)
                  VALUES('$fname', '$lname', '$birth', '$email', '$password', '$picture->fileName')";
                  /* $sql = "INSERT INTO users
                  VALUES(NULL,'$fname', '$lname', '$birth', '$email', '$password', '$picture->fileName')";  --id is auto-increment, status you dont need to write*/ 
        $res = mysqli_query($connect, $query);

        if ($res) {
            $errTyp = "success";
            $errMSG = "Successfully registered, you may login now";
            $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
        } else {
            $errTyp = "danger";
            $errMSG = "Something went wrong, try again later...";
            $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
        }
    }
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Registration System</title>
    <?php require_once 'components/boot.php' ?>
</head>

<body>
    <div class="container">
        <form class="w-75" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" enctype="multipart/form-data">
            <h2>Sign Up.</h2>
            <hr />
            <?php
            if (isset($errMSG)) {
            ?>
                <div class="alert alert-<?php echo $errTyp ?>">
                    <p><?php echo $errMSG; ?></p>
                    <p><?php echo $uploadError; ?></p>
                </div>

            <?php
            }
            ?>

            <input type="text" name="fname" class="form-control" placeholder="First name" maxlength="50" value="<?php echo $fname ?>" />
            <span class="text-danger"> <?php echo $fnameError; ?> </span>

            <input type="text" name="lname" class="form-control" placeholder="Surname" maxlength="50" value="<?php echo $lname ?>" />
            <span class="text-danger"> <?php echo $fnameError; ?> </span>

            <input type="email" name="email" class="form-control" placeholder="Enter Your Email" maxlength="40" value="<?php echo $email ?>" />
            <span class="text-danger"> <?php echo $emailError; ?> </span>
            <div class="d-flex">
                <input class='form-control w-50' type="date" name="birth" value="<?php echo $birth ?>" />
                <span class="text-danger"> <?php echo $dateError; ?> </span>

                <input class='form-control w-50' type="file" name="picture">
                <span class="text-danger"> <?php echo $picError; ?> </span>
            </div>
            <input type="password" name="pass" class="form-control" placeholder="Enter Password" maxlength="15" />
            <span class="text-danger"> <?php echo $passError; ?> </span>
            <hr />
            <button type="submit" class="btn btn-block btn-primary" name="btn-signup">Sign Up</button>
            <hr />
            <a href="index.php">Sign in Here...</a>
        </form>
    </div>
</body>
</html>