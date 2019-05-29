<?php
// cheks if a message will be displayed
if($table == false)
{
echo("<p><h3>" . htmlspecialchars($head) . "</h3></p>");
echo("<P>" . htmlspecialchars($body) . "</p>");
}
else
{
    // formats a table which will display the the history
    echo
    ("
    <table class = \"table table-striped\">
        <thead>
        <tr>
            <th>Transaction</th>
            <th>Date/Time</th>
            <th>symbol</th>
            <th>Shares</th>
            <th>Price</th>
        </tr>
        </thead>
        <tbody>
    ");
    
    // iterates over each transaction, put it in a row and the puts its elements in columns
    for($i = 0, $n = sizeof($body); $i < $n; $i++)
    {
        echo("<tr>");
        foreach($body[$i] as $element)
        {
            echo("<td>");
            echo(htmlspecialchars($element));
            echo("</td>");
            
        }
        echo("</tr>");
    }
    // terminates the table
    print
    ("
        </tbody>
        </table>
    ");
}

?>