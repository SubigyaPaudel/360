<html lang = 'en'>
    <head>
        <title>
            360 Subscribee Login
        </title>
        <link rel="stylesheet" href="common_style.css">
    </head>
    <body>
        <?php
            $redirect = "./index.php";
            if(isset($_COOKIE['is_auth'])):
                $redirect = "./maintenance.php";
            endif;
        ?>
        <a href="<?php echo $redirect?>">
            <div id = "Logo">
                <img id = "backdrop" src="img/logo.png" alt="360logo" width = "15%" height = "10%">
            </div>
        </a>
        <div id = "Topbar">
            <a href="./maintenance.php"><button class = "buttons topbuttons">Maintenance page</button></a>
            <a href="./search_pages.php"><button class = "buttons topbuttons">Search Utilities</button></a>
            <?php
                if(isset($_COOKIE['is_auth'])):
            ?>
            <a href="./logout.php">
                <button class = "admin_buttons" class = "buttons">
                    Logout
                </button>
            </a>
            <?php
                else:
                ?>
                <a href="./admin_login.php">
                    <button id = "admin" class = "admin_buttons">
                        Admin accounts
                    </button>   
                </a> 
                <?php
                endif;
            ?>
        </div>
        <div id="Miscellanous">
            <p>en.yeeply.com.</p>
        </div>
        <div id = "Miscellanous_text">
