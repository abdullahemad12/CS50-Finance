<form action="sell.php" method="post">
    <fieldset>
        <div style = "display:inline;">
        
            <select name = "quotes" class="form-control" style = "width:200px;">
                <option value = "none">Select a symbol</option>
                <?php
                // displays the owned stocks in a drop list
                foreach($symbols as $symbol)
                {
                    print("<option value = {$symbol}>{$symbol}</option>");
                }
                ?>
            </select>
        </div>
    
        <div style = "display:inline;">        
            <input class="form-control" name="shares" type="number" value = 1 min = 1 style = "width:65px"/>
        </div>
    
        <br>
        <br>
        <div class="form-group">
            <button class="btn btn-default" type="submit">
                <span aria-hidden="true" class="glyphicon glyphicon-check"></span>
                Sell Stock
            </button>
        </div>
    </fieldset>
</form>