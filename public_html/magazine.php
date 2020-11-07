<?php include('./header.php')?>
            <form action="magazine.php" method="POST">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-3">
                            <h2>Account</h2>
                            <p>Please fill out details to add to the Magazine</p>
                            <div>
                                <label for="email">Email</label>
                                <input class = "form-control" name="email" type="email" required>
                            </div>
                            <div>
                                    <label for="website">Website</label>
                                    <input class = "form-control" name="website" type="url" required>
                            </div>
                            <div>
                                <label for="subtype">Subscription Type Online</label>
                                <input class = "form-control" name="subtype" type="checkbox" value ="0">
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
                                        if (isset($error)) {
                                            echo "There Were error(s) In Your account info :" .$error;	
                                        } 
                                        else {
                                                include('config.php');
                                                $email = $_POST['email'];
                                                $website = $_POST['website'];

                                                $host_web = parse_url($website, PHP_URL_HOST);
                                                $myCheckBoxIsChecked = (!empty($_POST['subtype'])) ? 1 : 0;

                                                $link_to_latest_release = $host_web."/latest_release";

                                                $query1 ="INSERT INTO general_account(email,website,service_description) VALUES ('".mysqli_real_escape_string($conn,$email)."','$website', 'Provides magazine services');";
                                                $query ="INSERT INTO magazine(email,website,sub_type,link_to_latest_release) VALUES ('$email','$website', '$myCheckBoxIsChecked', '$link_to_latest_release');";
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
<?php include('./footer.php')?>
