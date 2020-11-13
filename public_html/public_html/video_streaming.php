<?php
    include("./admin_auth.php");
    include("./header.php");
?>
            <form action="video_streaming.php" method="POST">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-3">
                            <h2>Account</h2>
                            <p>Please fill out details to add to the video streaming</p>
                            <div>
                                <label for="email">Email</label>
                                <input class = "form-control" name="email" type="email" required>
                            </div>
                            <div>
                                    <label for="website">Website</label>
                                    <input class = "form-control" name="website" type="url" required>
                            </div>
                            <div>
                                <label for="max_devices">Max Devices</label>
                                <input class = "form-control" name="max_devices" type="number" min="1" required>
                            </div>
                            <div>
                                <label for="No_of_videos">Number of Videos</label>
                                <input class = "form-control" name="No_of_videos" type="number" min="1" required>
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
                                        if(!$_POST['max_devices']){
                                            $error.="<br/>please Enter Your max_devices";	
                                        }
                                        if(!$_POST['No_of_videos']){
                                            $error.="<br/>please Enter Your No_of_videos";	
                                        }
                                        if (isset($error)) {
                                            echo "There Were error(s) In Your account info :" .$error;	
                                        } 
                                        else {
                                                include('config.php');
                                                $email = $_POST['email'];
                                                $max_devices = $_POST['max_devices'];
                                                $No_of_videos = $_POST['No_of_videos'];
                                                $website = $_POST['website'];

                                                $host_web = parse_url($website, PHP_URL_HOST);

                                                $link_to_upcoming_content = $_POST['$host_web."/upcoming"'];
                                                $link_to_latest_release = $_POST['$host_web."/latest_release"'];
                                                $query1 ="INSERT INTO general_account(email,website,service_description) VALUES ('".mysqli_real_escape_string($conn,$email)."','$website', 'Provides video streaming services');";
                                                $query ="INSERT INTO video_streaming(email,website,link_to_upcoming,link_to_latest_release,max_devices,No_of_videos) VALUES ('".mysqli_real_escape_string($conn,$email)."','$website', '$link_to_upcoming_content', '$link_to_latest_release', '$max_devices', '$No_of_videos');";
                                                if (mysqli_query($conn, $query) && mysqli_query($conn, $query1)){
                                                    echo "New record created successfully";
                                                } else {
                                                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                                                }
                                            }
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
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