<?php
    include('./header.php');
?>
 <form action="software_suites.php" method="POST">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-3">
                            <h2>Account</h2>
                            <p>Please fill out details to add to the Software Suite</p>
                            <div>
                                <label for="email">Email</label>
                                <input class = "form-control" name="email" type="email" required>
                            </div>
                            <div>
                                    <label for="website">Website</label>
                                    <input class = "form-control" name="website" type="url" required>
                            </div>
                            <div>
                                <label for="expire_date">Expiry Date</label>
                                <input class = "form-control" name="expire_date" type="date" required>
                            </div>
                            <input name='create' type="submit" class = "buttons" value="Add Account"></input>
                            <div>
                                <?php
                                    if(isset($_POST['create'])){
                                        if(!$_POST['email']){
                                            $error.="<br/>please Enter Your Email";	
                                        }
                                        if(!$_POST['website']){
                                            $error.="<br/>please Enter Your Website";	
                                        }
                                        if(!$_POST['expire_date']){
                                            $error.="<br/>please Enter the expire date";	
                                        }
                                        if (isset($error)) {
                                            echo "There Were error(s) In Your account info :" .$error;	
                                        } 
                                        else {
                                                include('config.php');
                                                $email = $_POST['email'];
                                                $website = $_POST['website'];
                                                $expire_date = $_POST['expire_date'];

                                                $host_web = parse_url($website, PHP_URL_HOST);

                                                $query1 ="INSERT INTO general_account(email,website,service_description) VALUES ('".mysqli_real_escape_string($conn,$email)."','$website', 'Provides software suite services');";
                                                $query ="INSERT INTO software_suite(email,website,expire_date) VALUES ('$email','$host_web', '$expire_date');";
                                                if (mysqli_query($conn, $query) && mysqli_query($conn, $query1)){
                                                    header("Location: ./success.php");
                                                } else {
                                                    header("Location: ./failure.php");
                                                }
                                            }
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
<?php
    include('./footer.php');
?>
