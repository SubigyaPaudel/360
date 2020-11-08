<html lang = 'en'>
    <head>
        <title>
            360 Subscribee Sign Up
        </title>
        <link rel="stylesheet" href="common_style.css">
    </head>
    <body>
        <div id = "Logo">
            <img id = "backdrop" src="img/logo.png" alt="360logo" width = "15%" height = "10%">
        </div>
        <div id = "Topbar">
            <a href="maintenance.php"><button id ="Maintenance" class = "buttons">Maintenance</button></a>
        </div>
        <div id="Miscellanous">
            <p>en.yeeply.com.</p>
        </div>
        <div id = "Miscellanous_text">
            <form action="registration.php" method="POST">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-3">
                            <h2>Registration</h2>
                            <p>Please fill out details to add to the sub_account table</p>
                            <div>
                                <label for="firstname">Firstname</label>
                                <input class = "form-control" name="firstname" type="text">
                            </div>
                            <div>
                                <label for="lastname">Lastname</label>
                                <input class = "form-control" name="lastname" type="text">
                            </div>
                            <div>
                                <label for="email">Email</label>
                                <input class = "form-control" name="email" type="email" required>
                            </div>
                            <div>
                                <label for="username">Username</label>
                                <input class = "form-control" name="user_name" type="text" required>
                            </div>
                            <div>
                                <label for="password">Password</label>
                                <input class = "form-control" name="sub_pass" type="password" required>
                            </div>
                            <input name = 'create' type="submit" class = "buttons" value="Register"></input>
                            <div>
                                <?php
                                    if(isset($_POST['create'])){
                                        if(!$_POST['email']){
                                            $error.="<br/>please Enter Your Email";	
                                        }
                                                    
                                        if(!$_POST['sub_pass']){
                                            $error.="<br/>please Enter Your Password";
                                        }
                                                                
                                        else {
                                            if (strlen($_POST['sub_pass'])<8){
                                                $error.="<br/>please Enter long Password";
                                            }
                                        }
                                        if (isset($error)) {
                                            echo "There Were error(s) In Your Signup Details :" .$error;	
                                        } 
                                        else {
                                                include('config.php');
                                                if($results) echo "Email is already registered ,, Do you want log In ";
                                            else {
                                                $email = $_POST['email'];
                                                $user_name = $_POST['user_name'];
                                                $password = $_POST['sub_pass'];
                                                $query ="INSERT INTO subs_account(email,username,sub_pass) VALUES ('".mysqli_real_escape_string($conn,$email)."','$user_name', '$password');";
                                                if (mysqli_query($conn, $query)) {
                                                    echo "New record created successfully";
                                                } else {
                                                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                                                }
                                            }
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- Now retuen to :  <a href="login.php">Login page</a>  -->
                </div>
            </form>
        </div>
        <div id="endbar_fixed">
            <p>
                This website is student lab work and does not necessarily reflect Jacobs University Bremen opinions. Jacobs University Bremen does not endorse this site, nor is it checked by Jacobs University
                Bremen regularly, nor is it part of the official Jacobs University Bremen web presence.
                For each external link existing on this website, we initially have checked that the target page
                does not contain contents which is illegal wrt. German jurisdiction. However, as we have no influence on such contents, this may change without our notice. Therefore we deny any responsibility for the websites referenced through our external links from here.
                No information conflicting with GDPR is stored in the server.
            </p>
        </div>
    </body>
</html>