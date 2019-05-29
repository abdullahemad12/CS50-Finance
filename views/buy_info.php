
<h3><?= $head ?></h3>
<br>
<div id="quotes">
    <table>
        <tr>
            <th class="title">Name</th>
            <th>Last price($)</th>
            <th>Change($)</th>
            <th>%Change</th>
        </tr>
        <tr>
        <?php
        // iterates over the passed element and formats it into a table
        foreach($info as $element)
        {
            if($element[0] == "-")
            {
                echo('<td class = "low">' . $element . "</td>") ;
    
            }
            else if($element == $info["name"])
            {
                echo('<td class = "name">' . $element . "</td>");
            }
            else if($element == $info["price"])
            {
                echo('<td class = "price">' . $element . "</td>"); 
            }
            else
            {
                 echo('<td class = "high">' . $element . "</td>");
            }
        }
        echo("</tr>"); 
        ?>
    </table>
</div>
<br>

<fieldset>
        <form action = "buy.php" method = "POST">
            <div id =  "buy">        
                <label>Number of Shares: </label>
            
                <input class="form-control" name="shares" type="number" value = 1 min = 1 style = "width:70px"/>
                <button class="btn btn-default" type="submit" name= "buy" value = "<?= $_GET["symbol"] ?>">
                <span aria-hidden="true" class="glyphicon glyphicon-shopping-cart"></span>
                buy
                 </button>
            </div>
        </form>
</fieldset>