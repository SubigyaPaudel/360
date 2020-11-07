<?php 
    $is_auth = $_COOKIE['is_auth'] ?? "no";
    if($is_auth === "no") {
        header("Location: index.php");
    }
?>

<html lang = 'en'>
    <head>
        <title>
            360 Subscribee
        </title>
        <link rel="stylesheet" href="common_style.css">
    </head>
    <body>
        <div id = "Logo">
            <img id = "backdrop" src="img/logo.png" alt="360logo" width = "15%" height = "10%">
         </div>
        <div id = "Topbar">
            <a href="home.php"><button id = "home_buttons" class = "buttons">Home</button>
            <button id = "account_info_button" class = "buttons">Account Info</button>
            <button id = "settings_buttons" class="buttons">Settings</button>
            </button>
            <div id = "useroptions">
                <select id = "useroptions_dropdown">
                    <option value = "1">Switch Accounts</option>
                    <option value = "2"> Logout</option>
                </select>
            </div>   
        </div>
        <div id = "sidepanel">
            <select id = "account_types">
                <option value="General Accounts">General Accounts</option>
                <option value="video_streaming">Video Streaming</option>
                <option value="music_streaming">Music Streaming</option>
                <option value="VPN">VPN</option>
                <option value="Software Suite">Software Suites</option>
                <option value="Magazine">Magazines</option>
                <option value="Miscellaneous">Miscellaneous</option>
            </select>
            <a href="maintenance.php"><button id= "maintenance_button" class = "buttons">Maintenance</button></a>
            <a href="general_account.php"><button id= "add_account_button" class = "buttons">Add account</button></a>
            <button id = "explore_buttons" class = "buttons">Explore</button>
            
        </div>
            <div id="Content_Area">
