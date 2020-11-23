<?php
    require("./header.php");
    require("./config.php");
?>
<?php
    if(isset($_POST['details'])):
        $email_g = mysqli_real_escape_string($conn, $_POST['email_g']);
        $website = mysqli_real_escape_string($conn, $_POST['website']);
        $query = "SELECT *
        FROM general_account G
        WHERE G.email = '{$email_g}' and G.website = '{$website}';";
        $result = mysqli_query($conn, $query);
        $clean_data = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        ?>
        <table>
            <tr>
                <th>Website</th>
                <th>Associated email account in this website</th>
                <th>Service Description</th>
            </tr>
            <tr>
                <td><?php echo $clean_data['website']?></td>
                <td><?php echo $clean_data['email']?></td>
                <td><?php echo $clean_data['service_description']?></td>
            </tr>
        </table>
        <?php
        mysqli_close($conn);
    elseif(isset($_POST['search'])):
        $email = mysqli_real_escape_string($conn, $_POST['email_s']);
        $query = "SELECT G.email, G.website, G.service_description
        FROM general_account G, related_account R
        WHERE G.email = R.email_g and R.email_s = '{$email}' and R.website = G.website;";
        $result = mysqli_query($conn, $query);
        $clean_data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);
        echo "<h2> You are managing accounts for the following websites</h2>";
        echo "<table>";
        echo "<tr> <th> Website </th> <th> Further details</th></tr>";
        foreach($clean_data as $row):
            ?>
            <tr>
            <td>
                <?php echo $row['website'];?>
            </td>
            <td>
                <form action="<?php $_SERVER['PHP_SELF']?>" method = "POST">
                    <input type="hidden" value = "<?php echo $row['email'];?>" name = "email_g">
                    <input type="hidden" value = "<?php echo $row['website'];?>" name = "website">
                    <input type = "submit" value = "details" name = "details">
                </form>
            </td>
            </tr>
            <?php
        endforeach;
        echo "</table>";
        mysqli_close($conn);
    else:
    ?>
        <!-- <h3></h3> -->
        <form action="<?php $_SERVER['PHP_SELF']?>" method = "POST">
            <label for="email_s"><h3>Please enter your email associated to your 360 account:</h3></label>
            <input type="text" id="email_s" name='email_s'>
            <?php 
                $sqlquery = "SELECT S.email FROM subs_account S WHERE 1 GROUP BY S.email;";
                $result = mysqli_query($conn, $sqlquery);
                $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            ?>
            <script>
                var my_tags = [<?php $i = 0; $len = count($rows);
                                    foreach ($rows as $mail_list) {
                                        if ($i == $len-1) {
                                            echo(json_encode($mail_list['email']));
                                        }  
                                        else {
                                            echo(json_encode($mail_list['email']) . ",");
                                        }
                                        $i++;
                                    }
                            ?>];
                    $("#email_s").autocomplete({
                        source: function( request, response ) {
                        var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( request.term ), "i" );
                        response( $.grep( my_tags, function( item ){
                            return matcher.test( item );
                        }) );
                    }
                    });
            </script>
            <br/>
            <br/>
            <input type="submit" name='search' value = 'search'>
        </form>
    <?php
    endif;
?>
<?php
    require("./footer.php");
?>
