<?php
require("../includes/config.php");
$history = cs50::query("SELECT transaction, date, symbol, shares ,price FROM history WHERE user_id = ? ORDER BY id", $_SESSION["id"]);
// checks if the user has already made some sort of transaction and views the appropriate output
if(sizeof($history) == 0)
{
    render("history_info.php",["table" => false, "title" => "History", "body"=>"You have not done any transactions yet.", "head" => "Nothing to Show"]);
}
else
{
    render("history_info.php",["table" => true, "title" => "History", "body"=> $history]);
}
?>