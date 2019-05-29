<?php
    // configuration
    require("../includes/config.php");
    
    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        
        render("register_form.php", ["title" => "Register"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // stores the date of today
        $date = date("Y-m-d");
        
        // checks for all the missing information or mistakes the user might have commited
        if(empty($_POST["username"]))
        {
           apologize("You must Choose a username.", "Log In", "register_form.php");
        }
        if(empty($_POST["email"]))
        {
           apologize("You must Choose an E-mail.", "Log In", "register_form.php");
        }
        else if(!uname_syntax($_POST["username"]))
        {
            apologize("Username must only contain letters, numbers and/or _ </br> Example: user_name12.", "Log In", "register_form.php");
        }
        else if(empty($_POST["password"]))
        {
           apologize("You must Choose a Password.", "Log In", "register_form.php", "Log In", "register_form.php");
        }
        else if($_POST["password"] != $_POST["password2"])
        {
            apologize("The Passwords You Typed Does not Match.", "Log In", "register_form.php");
        }
        else if($_POST["username"] == $_POST["password"])
        {
            apologize("password and username are identical !", "Log In", "register_form.php");
        }
        else if(strlen($_POST["password"]) <= 4)
        {
           apologize("password is too short. It must contain at least four characters", "Log In", "register_form.php"); 
        }
        
        // if query fails to insert the new elements then the username must have existed before
        else if(cs50::query("INSERT IGNORE INTO users (email,cash,date,username,hash) VALUES (?,10000.0000,?,?,?)",$_POST["email"],$date,$_POST["username"],password_hash($_POST["password"], PASSWORD_DEFAULT))
        == 0)
        {
            apologize("Username or Email already exist, please choose another one.", "Log In", "register_form.php");
        }
        else
        {   //sets the id of the session to this current user id
            //send_mail(["email"=>$_POST["email"], "adress"=>"Welcome to CS50 Finance", "body"=>'Hello ' . $_POST["username"]. ", \r\n CS50 finance offers you the opportunity to try out selling and buying real stocks with virtual moneu. \r\n all the transactions you make on this Website are virtual \r\n this is CS50"]);
            $id = cs50::query("SELECT id FROM users WHERE username = ?" ,$_POST["username"]);
            $_SESSION["id"] = $id[0]["id"];
            redirect("index.php");
        }
    }

?>