        
<form action="quote.php" method = "GET">
    <div style = "display:inline;">
        <input autocomplete="off" autofocus class="form-control" name="symbol" placeholder="Lookup for Symbols or companies" 
            type="text" style = "width:300px" <?php if(!empty($_GET["symbol"])){printf("value=\"%s\"",$_GET["symbol"]);}?>/>
                
        <button class="btn btn-default" type="submit">
            <span aria-hidden="true" class="glyphicon glyphicon-search"></span>
                Search
        </button>
        <button  class="btn btn-default" type="submit" name = "refresh" value = "refresh">
            <span aria-hidden="true" class="glyphicon glyphicon-refresh"></span>
        </button>
    </div>
</form>
            
                
                    
            


   

<br>
<br>