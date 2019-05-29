
    <table class = "table table-striped">
        <thead>
            <tr>
                <th>Symbol</th>
                <th>Name</th>
                <th>Shares</th>
                <th>Price($)</th>
                <th>TOTAL($)</th>
            </tr>
        </thead>
        <tbody>
        <?php
        
            // iterates over the owned stock
            foreach($portfolio as $element)
            {
                $quote = lookup($element["symbol"],false);
                $total =  $quote["price"] * $element["shares"];
                $total = number_format($total ,2);
                $price = number_format($quote["price"],2);
                
                // displays the information about the shares,ect....
                echo("<tr>\n");
                echo("<td>\n\t" . $quote["symbol"] . "\n\t</td>");
                echo("<td>\n\t" . $quote["name"] . "\n\t</td>");
                echo("<td>\n\t" . $element["shares"] . "\n\t</td>");
                echo("<td>\n\t" . $price . "\n\t</td>");
                echo("<td>\n\t" . $total . "\n\t</td>");
                echo("</tr>\n");
            }
        ?>
        <tr>
            <td colspan = 4><b>CASH</b></td>
            <td><b><?= "$" . $cash ?></b></td>
            
        </tr>
        </tbody>
    
    
    </table>
    
    
    
    
    <!--couldn't remove it :) 
    
    <iframe allowfullscreen frameborder="0" height="315" src="https://www.youtube.com/embed/oHg5SJYRHA0?autoplay=1&iv_load_policy=3&rel=0" width="420"></iframe>-->

