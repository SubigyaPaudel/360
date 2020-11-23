<?php
    require("header.php");
    require("config.php");
?>

<?php
    if(isset($_POST['search'])):
        $g_account = htmlspecialchars($_POST['type_of_g_account']);
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
        ?>
        <form action="<?php $_SERVER['PHP_SELF']?>" method = "POST">
            <br/>
            <br/>
            <label for="email">Email of general account:</label>
            <input type="email" id="email" name="email" placeholder="email" required/>
            <?php 
                $sqlquery = "SELECT G.email FROM general_account G WHERE 1 GROUP BY G.email;";
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
                    $("#email").autocomplete({
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
                <label for="type_of_g_account">Type of subscription you are looking for</label>
                <input type="text" id="type_of_g_account" name="type_of_g_account" required placeholder="Type of Subscription"/>
                <script>
                    var tags = ["video_streaming", "music_streaming", "software_suite", "VPN", "magazine"]
                    $("#type_of_g_account").autocomplete({
                        source: function( request, response ) {
                        var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( request.term ), "i" );
                        response( $.grep( tags, function( item ){
                            return matcher.test( item );
                        }) );
                    }
                    });
                </script>
            <br/>
            <br/>
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
