<?php
require("../includes/config.php");
//checks for data submission
if($_SERVER["REQUEST_METHOD"] == "GET" && empty($_GET["symbol"]))
{
    render("buy_form.php",["title"=>"buy"]);
}
// if the user submited iva the view button
if($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET["symbol"]) && isset($_GET["price"]))
{
    // loads the data of the symbol
    $quote = lookup($_GET["symbol"], false);
    if($quote != false)
    {
        // organizes the datat then pass it render which in turn will pass them as variables to buy_info.php
        if ($quote["price"] !="N/A" || $quote["price"] != "0.00")
        {
            $head;
            $head = $quote["symbol"];
            unset($quote["symbol"]);
            $head = strtoupper($head);
            $quote["price"] = number_format($quote["price"],4);
            
            //could'nt retrieve data
            if ($quote["change"] !="N/A")
            {
                $quote["change"] = number_format($quote["change"],4);
            }
            else
            {
                $quote["change"] = $quote["change"];
                
            }
            render("buy_info.php",["title" => "Buy","info" => $quote, "head" =>$head]);
        }
    }
    else
    {
        //quote was not found
        render("transaction.php",["title" => "Buy","state" => "The Symbol or the company you are looking for was not found.", "head" =>"Transaction Failed"]);
    }
}
else
{
    //the user submits via buy
    
    //the data are organized into variables
    $shares = $_POST["shares"];
    $symbol = $_POST["buy"];
    $quote = lookup($symbol, false);
    extract($quote);
    
    // Selects the cash of the user
    $cash_arr = cs50::query("SELECT cash FROM users WHERE id = ?", $_SESSION["id"]);
    extract($cash_arr[0]);
    
    //checks if the user have enough cash
    if($cash < ($shares * $price))
    {
        render("transaction.php",["title" => "Buy","state" => "You don't have enough Money to complete the transaction process", "head" =>"Transaction Failed"]);
    }
    else
    {
        // buys the quote for the user
        $exist = cs50::query("SELECT symbol FROM portfolios WHERE user_id = ? AND symbol = ?", $_SESSION["id"], $symbol);
        
        // checks if the user already has some shares of this quote
        if(isset($exist[0]["symbol"]))
        {
            // updates the shares if he does
            cs50::query("UPDATE portfolios SET shares = shares + ? WHERE user_id = ? AND symbol = ?",$shares, $_SESSION["id"], $symbol);
        }
        else
        {
            // insert new quote into portfolio if he doesn't
             cs50::query("INSERT INTO portfolios (user_id, symbol, shares) VALUES (?, ?, ?)", $_SESSION["id"], $symbol, $shares);
        }
        // updates the cash of the user
        cs50::query("UPDATE users SET cash = cash - ? WHERE id = ?",$shares * $price, $_SESSION["id"]);
        $total ="$" . number_format($shares * $price,3);
        
        // saves this transaction into history
        cs50::query("INSERT INTO history (user_id,transaction,symbol,shares,price) VALUES (?,\"BUY\",?,?,?)",$_SESSION["id"],$symbol,$shares,$total);
        render("transaction.php",["title" => "Buy","state" => "You have bought {$shares} shares of {$name}", "head" =>"Transaction is processed"]);
    }
}
?>