<?php
    require("header.php"); 
    require("config.php");
?>

<?php
    if(isset($_POST['search'])):
        $g_account = $_POST['type_of_g_account'];
        $email = $_POST['email'];
        $sqlquery = "SELECT email, website from {$g_account} X WHERE X.email = '{$email}';" ;
        $result = mysqli_query($conn, $sqlquery);
        $rows = mysqli_fetch_all($result);
        if(count($rows)):
            ?>
            <table class="centre_table">
            <?php
                echo "<tr>";
                while($row = $result->fetch_field()):
                    echo "<th>" . $row->name . "</th>";
                endwhile;
                echo "<th> Link to single row". "</th>";
                echo "</tr>";
                foreach($rows as $row):
                    echo "<tr>";
                    foreach($row as $column):
                        echo "<td>" . $column . "</td>";
                    endforeach;
                    echo "<td><form action='single_row.php' method = 'POST'>";
                        echo "<input type='hidden' name='email' value= '{$email}'>";
                        echo "<input type='hidden' name='subscription' value= '{$g_account}'>";
                        echo "<input type='hidden' name='web' value= '{$column}'>";
                        echo "<input type= 'submit' value = 'details' name = 'Details'>";
                        echo "</form>";
                        echo"</td>";
                    echo "</tr>";
                endforeach;
            ?>
            </table>
            <?php
        else:
            echo "<h1> No account having email = {$email} in {$g_account}</h1>";
        endif;
    else:
        $sqlquery = "SELECT G.email FROM general_account G WHERE 1 GROUP BY G.email;";
        $result = mysqli_query($conn, $sqlquery);
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        ?>
        <form action="<?php $_SERVER['PHP_SELF']?>" method = "POST">
            <select name="email">
            <?php
                foreach($rows as $row):
                    ?>
                    <option value="<?php echo $row['email'];?>"><?php echo $row['email'];?></option>
                    <?php
                endforeach;
            ?>
            </select>
            <select name="type_of_g_account">
                <option value="video_streaming">Video Streaming</option>
                <option value="music_streaming">Music Streaming</option>
                <option value="VPN">VPN</option>
                <option value="magazine">Magazine</option>
                <option value="software_suite">Software Suite</option>
            </select>
            <label for="search">Search</label>
            <input type="submit" value = "search" name = "search">
        </form>
        <?php
    endif;
?>
<?  
    mysql_free_result($result);
    close($conn);
    require("footer.php")
?>