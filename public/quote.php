<?php
require("../includes/config.php"); 

// checks if the submission was done via the refresh button
if(!isset($_GET["symbol"]) || empty($_GET["symbol"]) || isset($_GET["refresh"]) ||$_GET["symbol"] == " ")
{
    //this will download a CSV with multiple symbols and read them
    
    // opens a file in a folder called quotes that has some symbols listed nicely line by line
    $symb_file = @fopen("quotes/symbols","r",false);
    // checks for NULL
    if($symb_file == false)
    {
        trigger_error("<h1>The page might be temporary down</h1>");
        exit();
    }
    $url = "";
    
   // stores the number of the symbols
    $lines = 0;
    
    //iterates over the file line by line
    while($symbol = fgets($symb_file))
    {
        $lines++;
        $symbol = trim($symbol," \n");
        
        // sotres this as the url that will be passed to lookup
        $url = $url . $symbol . "+";
    }
    
    //formats the url appropriately
    $url = trim($url, "+");
    fclose($symb_file);
    
    // the true indicates that I want to return the CSV file it self rather than the array
    $csf_symb = lookup($url, true);
    
    // stores an html table in a variable called table (Not the best design, I noticed)
    $table = '<div id="quotes"><table><tr><th class="title">Name</th><th>Last price($)</th><th>Change($)</th>
    <th>%Change</th></tr>';
  
    //iterates over the CSV 
    for($i = 0 ; $i < $lines; $i++ )
    {
        //stores the element of the row in array quote
        $quote = fgetcsv($csf_symb);
        $temp;
        // checks if the symbol is available
        if ($quote[2] !="N/A" || $quote[2] != "0.00")
        {
            // organizes the information about the symbol nicely in an associative array
            $temp["name"] = $quote[0];
            $temp["symbol"] = $quote[1];
            $temp["price"] = number_format($quote[2],4);
            
            // checks if the extra information is available so we can format number them
            if ($quote[3] !="N/A"|| $quote[4] !="N/A")
            {
                $temp["change"] = number_format($quote[3],4);
                $temp["percent"] = $quote[4];
            }
            else
            {
                $temp["change"] = $quote[3];
                $temp["percent"] = $quote[4];
            }
            //$temp["low"] = number_format($name = $quote[5],4);
            //$temp["high"] = number_format($name = $quote[6],4);
            
            // starts a row
            $table = $table . "<tr>"; 
            
            // puts every element of the organized array in a html column
            foreach($temp as $element)
            {
                //specify the class of each colum to format the style of each class later
                
                if($element[0] == "-")
                {
                    $table = $table . '<td class = "low">' . $element . "</td>";
            
                }
                else if($element == $temp["symbol"])
                {
                   $table = $table . '<td class = "symbol">' . $element . "</td>"; 
                }
                else if($element == $temp["name"])
                {
                    $table = $table . '<td class = "name">' . $element . "</td>";
                }
                else if($element == $temp["price"])
                {
                   $table = $table . '<td class = "price">' . $element . "</td>"; 
                }
                else
                {
                     $table = $table . '<td class = "high">' . $element . "</td>";
                }
            }
            
            // terminates the row
            $table = $table . "</tr>" ; 
        }
    }
    // terminates the table
    $table = $table . "</table></div>";
    fclose($csf_symb);
    
    // passes the table to quotes_form via render
    render("quotes_form.php",["title" => "Quote","table" => $table]);
}
else
{
    $quote;
    $quote = lookup($_GET["symbol"],false);
    if($quote == false)
    {
        render("symbol.php",["title" => "Quote", "head"=>"Symbol Not Found", "body" =>"Could not find \"" . $_GET["symbol"] . 
        "\" please check the spelling and try again","cost"=>"", "url" => "http://finance.yahoo.com/"]);
    }
    else
    {
        $price ="$".number_format($quote["price"],2);
        render("symbol.php", ["title" => $quote["symbol"], "head" => $quote["symbol"], "body" => "A share of " . $quote["name"] .
        " (" . $quote["symbol"] .") costs ", "cost" => $price , "url" => "http://finance.yahoo.com/quote/" . $quote["symbol"]]);
    }
}

?>