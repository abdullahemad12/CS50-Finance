<?php
    
    // configuration
    require("../includes/config.php"); 
    
    //extracts the information of the user from the data base
    $portfolio = cs50::query("SELECT symbol, shares FROM portfolios WHERE user_id = ? ORDER BY id", $_SESSION["id"]);
    $info = cs50::query("SELECT cash FROM users WHERE id = ?", $_SESSION["id"]);
    $output = ["cash" => $info[0]["cash"], "portfolio" => $portfolio, "title" => "Portfolio"];
    // passes all the information via render
    render("portfolio.php", $output);


?>
