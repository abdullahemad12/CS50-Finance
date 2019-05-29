<?php
require("../includes/config.php");
// checks for the request  method
if($_SERVER["REQUEST_METHOD"] == "GET")
{
    // selects all the symbols that the user owns
    $all = cs50::query("SELECT symbol FROM portfolios WHERE user_id = ? ORDER BY id", $_SESSION["id"]);
    $symbols = [];
    
    // stores the symbols in a more organized array
    for($i = 0, $n = sizeof($all); $i < $n; $i++)
    {
       $symbols[$i] = $all[$i]["symbol"];
    }
    
    // if the user owns any symbol than it will be passed to sell_form.php via render to be displayed
    if(sizeof($all) != 0)
    {
        render("sell_form.php", ["title" => "Sell", "symbols" => $symbols]);
    }
    else
    {
        // the user didn't buy any stocks yet
        render("transaction.php", ["state" => "You do not have any stocks to sell", "head" => "Nothing to Sell", "title" => "SELL"]);
    }
}
else
{
    // if the request method was post then the user is trying to sell an item
    
    // selects all the shares of the requested quote
    $shares = cs50::query("SELECT shares FROM portfolios WHERE user_id = ? AND symbol = ?" , $_SESSION["id"], $_POST["quotes"]);
    
    // if the user submits wihout choosing any quote
    if($_POST["quotes"] == "none")
    {
        
         render("transaction.php", ["state" => "Please select an item to complete your transaction", "head" => "Couldn't complete transaction", "title" => "SELL"]);
    }
    
    //if the user are trying to sell more shares than he actually owns
    else if($shares[0]["shares"] <  $_POST["shares"])
    {
        render("transaction.php", ["state" => "You don't have that much shares. Please select the appropriate number.", "head" => "Couldn't complete transaction", "title" => "SELL"]);
    }
    //handles the case where the user sells all the shares he owns
    else if ($shares[0]["shares"] ==  $_POST["shares"])
    {
        //deletes the symbol from portfolio and updates the cash
        
        $quote = lookup($_POST["quotes"],false);
        $total =  $quote["price"] * $_POST["shares"];
        cs50::query("UPDATE users SET cash = cash + ? WHERE id = ?",$total,$_SESSION["id"]);
        cs50::query("DELETE  FROM portfolios WHERE user_id = ? AND symbol = ?" , $_SESSION["id"], $_POST["quotes"]);
        $total = "$" . number_format($total,3);
        cs50::query("INSERT INTO history (user_id,transaction,symbol,shares,price) VALUES (?,\"SELL\",?,?,?)",$_SESSION["id"],$quote["symbol"],$_POST["shares"],$total);
        render("transaction.php", ["state" => "Your transaction has been completed successfully", "head" => "Process Completed", "title" => "SELL"]);
    }
    // handlesthe case where the user sells only some of the shares of some symbol
    else
    {
        // updates the user's cash and remove the sold shares from portfolio
        
        $quote = lookup($_POST["quotes"],false);
        $total =  $quote["price"] * $_POST["shares"];
        cs50::query("UPDATE users SET cash = cash + ? WHERE id = ?",$total,$_SESSION["id"]);
        cs50::query("UPDATE portfolios SET shares = shares - ? WHERE user_id = ? AND symbol = ?", $_POST["shares"] ,$_SESSION["id"],$quote["symbol"] );
        $total = "$" . number_format($total,3);
        cs50::query("INSERT INTO history (user_id,transaction,symbol,shares,price) VALUES (?,\"SELL\",?,?,?)",$_SESSION["id"],$quote["symbol"],$_POST["shares"],$total);
        render("transaction.php", ["state" => "Your transaction has been completed successfully", "head" => "Process Completed", "title" => "SELL"]);
    }
    
}

?>