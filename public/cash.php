<?php
require("../includes/config.php");

// checks for the request method
if($_SERVER["REQUEST_METHOD"] == "GET")
{
    render("cash_form.php", ["title"=>"Cash"]);
}
else
{
    // prevents the user from depositing more than $1000 per two days
    if($_POST["cash"] > 1000)
    {
        render("transaction.php", ["title"=>"Cash", "state" =>'You can\'t deposit more than $1000',"head"=> "Depositing Failed"]);
        exit();
    }
    // extracts the date of the last deposite from the database and organizes it into variables as ints
    $date = CS50::query("SELECT date FROM users WHERE id = ?", $_SESSION["id"]);
    $days = $date[0]["date"][8] . $date[0]["date"][9];
    $months  = $date[0]["date"][5] . $date[0]["date"][6];
    $years  = $date[0]["date"][2] . $date[0]["date"][3];
    
    // sets today's date into variables as ints 
    $today = date("Y-m-d");
    $days1 = $today[8] . $today[9];
    $months1  = $today[5] . $today[6];
    $years1  = $today[2] . $today[3];
    
    // converts all the values to integers
    $day = intval($days);
    $month = intval($months);
    $year = intval($years);
    $day1 = intval($days1);
    $month1 = intval($months1);
    $year1 = intval($years1);
    
    // checks if two days has already passed
    if($day + 1 <= $day1 && $month <= $month1)
    {
        $date = CS50::query("UPDATE users SET cash = cash + ?, date = ? WHERE id = ?", $_POST["cash"],$today,$_SESSION["id"]);
        render("transaction.php", ["title"=>"Cash", "state" =>"Your money has been deposited successfully","head"=> "Cash Updated"]);
    }
    else
    {
        render("transaction.php", ["title"=>"Cash", "state" =>"You must wait at least one day before depositing more money","head"=> "Depositing Failed"]);   
        
    }
    
}

?>