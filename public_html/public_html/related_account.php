<?php include('./header.php');
      include("./admin_auth.php");?>
    <h4>Page to link account from subs tables to general account</h4>
    <?php
        include('config.php');
        if(isset($_POST['Link'])):
            $email_s = mysqli_real_escape_string($conn, $_POST["email_s"]);
            $email_g = mysqli_real_escape_string($conn, $_POST["email_g"]);
            $website = mysqli_real_escape_string($conn, $_POST["website"]);
            $query = "INSERT INTO related_account(email_s, email_g, website) VALUES ('{$email_s}','{$email_g}', '$website');";
            if (mysqli_query($conn, $query)){
                header("Location: ./success.php");
            } else {
                header("Location: ./failure.php");
            }
        else:
            include('config.php');
            $query1="SELECT email FROM subs_account GROUP BY email;";
            $query2="SELECT email FROM general_account GROUP BY email;";
            $query3="SELECT website FROM general_account;";
            $result1 = mysqli_query($conn,$query1);
            $result2 = mysqli_query($conn,$query2);
            $result3 = mysqli_query($conn,$query3);
        ?>
        <div id="wrapper">
            <form action="" method="POST">
            <br>
                    <?php 
                        if ($result1->num_rows > 0) {
                            echo '<label>Email_s:';
                            echo '<select name="email_s">';
                            echo '<option value="" disabled selected>all</option>';

                            $num_results = mysqli_num_rows($result1);
                            for ($i=0;$i<$num_results;$i++) {
                                $row = mysqli_fetch_array($result1);
                                $email_s = $row['email'];
                                echo '<option value="' .$email_s. '">' .$email_s. '</option>';
                            }

                            echo '</select>';
                            echo '</label>';
                        } else {
                            echo "0 results";
                        }
                    ?>
                </select>
            <br>
                    <?php
                        if ($result2->num_rows > 0) {
                            echo '<label>Email_g:';
                            echo '<select name="email_g">';
                            echo '<option value="" disabled selected>all</option>';

                            $num_results = mysqli_num_rows($result2);
                            for ($i=0;$i<$num_results;$i++) {
                                $row = mysqli_fetch_array($result2);
                                $email_g = $row['email'];
                                echo '<option value="' .$email_g. '">' .$email_g. '</option>';
                            }

                            echo '</select>';
                            echo '</label>';
                        } else {
                            echo "0 results";
                        }
                    ?>
                </select>
            <br>
                    <?php 
                        if ($result3->num_rows > 0) {
                            echo '<label>Website:';
                            echo '<select name="website">';
                            echo '<option value="" disabled selected>all</option>';

                            $num_results = mysqli_num_rows($result3);
                            for ($k=0;$k<$num_results;$k++) {
                                $row = mysqli_fetch_array($result3);
                                $website = $row['website'];
                                echo '<option value="' .$website. '">' .$website. '</option>';
                            }
                            echo '</select>';
                            echo '</label>';
                        } else {
                            echo "0 results";
                        }
                    ?>
                </select>
                <br>
                <label for="Link">Link accounts</label>
                <input type="submit" name = "Link">
                <br>
            </form>
        </div>
                <?php endif;?>
<?php include('./footer.php'); ?>
