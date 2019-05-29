<?php
require("../includes/config.php");
// check for the request method
if($_SERVER["REQUEST_METHOD"] == "GET")
{   
    //renders the page
    render("account_form.php", ["title"=>"Account"]);
}
else
{
        // checks for the validity of the password
        if(empty($_POST["password"]))
        {
           apologize("You must Choose a Password.", "Log In", "account_form.php", "Account", "account_form.php");
        }
        else if($_POST["password"] != $_POST["password2"])
        {
            apologize("The Passwords You Typed Does not Match.", "Account", "account_form.php");
        }
        else if(strlen($_POST["password"]) <= 4)
        {
           apologize("password is too short. It must contain at least four characters", "Account", "account_form.php"); 
        }
        else
        {   
            //updates the password field after hashing it
            cs50::query("UPDATE users SET hash = ? WHERE id = ?",password_hash($_POST["password"], PASSWORD_DEFAULT), $_SESSION["id"]);
            //$email_arr = cs50::query("SELECT email FROM users WHERE id = ?", $_SESSION["id"]);
            //$email = $email_arr[0]["email"];
            //send_mail(["email"=>$email, "adress"=>'Account updated', "body"=>'Your password has been changed to'. $_POST["password"].'Thank you for using cs50 finance']);
            
            //renders a message saying password was updated
            render("transaction.php", ["title"=>"Account", "state" =>"Your password has been changed successfully","head"=> "password changed"]);
        }
}
?>