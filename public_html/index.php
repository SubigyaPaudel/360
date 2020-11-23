<?php include("./header.php")?>
            
            <h1>One For All</h1>
            <p id = "Miscellanous_p">
                WELCOME TO 360. YOUR ONE STOP CONNECTION TO ALL YOUR SUBSCRIPTIONS
            </p>
            <p>
                To continue please login.
            </p>
            
            <div id = "login_part">
                <div>
                    <input name="username" type="text" placeholder="Username">
                </div>
                <div>
                    <input name="password" type="password" placeholder="Password">
                </div>
                <div>
                    <input name="remember" type="radio" value="Remember me"> Remember me
                </div>
                    <button id = "login_button" class = "buttons" type="submit">Login</button>
                <div>
                    New Users :  <a href="registration.php">register here</a> 
                </div>
            </div>
       
<?php include('./footer.php');
