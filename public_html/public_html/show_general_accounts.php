<?php
    require("./header.php");
?>
<?php
    if(isset($_POST['details'])):
        require("./config.php");
        $email_g = mysqli_real_escape_string($conn, $_POST['email_g']);
        $website = mysqli_real_escape_string($conn, $_POST['website']);
        $query = "SELECT *
        FROM general_account G
        WHERE G.email = '{$email_g}' and G.website = '{$website}';";
        $result = mysqli_query($conn, $query);
        $clean_data = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        ?>
        <table class = "cushioned">
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
        require("./config.php");
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
        <h3>Please enter your email associated to your 360 account</h3>
        <form action="<?php $_SERVER['PHP_SELF']?>" method = "POST">
            <input type="text" name='email_s'>
            <input type="submit" name='search' value = 'Search'>
        </form>
    <?php
    endif;
?>
<?php
    require("./footer.php");
?>