<?php
    require("./header.php");
?>
<?php
    if(isset($_POST['search'])):
        require("./config.php");
        $email_g = mysqli_real_escape_string($conn, $_POST['email_g']);
        $website = mysqli_real_escape_string($conn, $_POST['website']);
        $query = "SELECT GAPD.updates_and_messages, AD.deletion_link, DU.terms_cond_last_updates, DU.link_relevant_page
        FROM general_account_payment_details GAPD, account_deletion AD, data_usage DU
        WHERE GAPD.detail_id IN (select AD.detail_id
                                FROM account_details AD, general_account GA
                                WHERE AD.email = GA.email and AD.website = GA.website and AD.email = '{$email_g}' and AD.website = '{$website}') 
                                and AD.detail_id IN (select AD.detail_id
                                                    FROM account_details AD, general_account GA
                                                    WHERE AD.email = GA.email and AD.website = GA.website and AD.email = '{$email_g}' and AD.website = '{$website}')
                                                    and DU.detail_id IN (select AD.detail_id
                                                                        FROM account_details AD, general_account GA
                                                                        WHERE AD.email = GA.email and AD.website = GA.website and AD.email = '{$email_g}' and AD.website = '{$website}');";
        $result = mysqli_query($conn, $query);
        $clean_data = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        if(count($clean_data)):
            ?>
            <table>
                <tr>
                    <th>Payment-related updates and messages</th>
                    <th>Link to page containing account deletion details</th>
                    <th>Data usage details</th>
                </tr>
                <tr>
                    <td><?php echo $clean_data['updates_and_messages'];?></td>
                    <td><?php echo $clean_data['deletion_link'];?></td>
                    <td>
                        <table>
                            <tr>
                                <th>Data usage policy updated date</th>
                                <th>Link to the relevant page</th>
                            </tr>
                            <tr>
                                <td><?php echo $clean_data['terms_cond_last_updates'];?></td>
                                <td><?php echo $clean_data['link_relevant_page'];?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        <?php
        else:
            echo "<h3>Couldn't obtain details for the account that was described</h3>";
            echo "<h4>Are you sure that the details were correct?</h4>";
            ?>
            <p>To view the general accounts that you are monitoring <a href="show_general_accounts.php">Click here</a></p>
            <?php
        endif;
        mysqli_close($conn);
    else:
        ?>
        <h3>Enter details associated with the account that you are monitoring</h3>
        <form action="<?php $_SERVER['PHP_SELF']?>" method = "POST">
            <label for="email_g">Email associated with a account that you are monitoring</label>
            <input type="text" name = "email_g" placeholder = "email">
            <br/>
            <br/>
            <label for="website">Website associated to the account that you are monitoring</label>
            <input type="text" name = "website" placeholder = "website">
            <br/>
            <br/>
            <input type="submit" name = 'search' value = 'search'>
        </form>
        <?php
    endif;
?>
<?php
    require("./footer.php")
?>