<?php

    /**
     * helpers.php
     *
     * Computer Science 50
     * Problem Set 7
     *
     * Helper functions.
     */
    require("libphp-phpmailer/class.phpmailer.php");
    require_once("config.php");
    /**
     * Sends an Email
     **/
     /*function send_mail($arr = [])
     {
        extract($arr);
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->port=587;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Host = "smtp.gmail.com"; // change to your email host
        $mail->Password = "mafia12saleh"; // change to your email password
        $mail->setFrom("boodye@gmail.com"); // change to your email password
        $mail->AddAddress($email); // change to user's email address
        $mail->Subject = $adress; // change to email's subject
        $mail->Body = "<h1>$adress</h1>\n\r" . $body; // change to email's body, add the needed link here
        $mail->Send();
     }*/
    
    /**
     * 
     * Checks the username syntax
     * */
     
     // checks for the appropriate syntax of the username
     function uname_syntax($uname)
     {
        $alphacount = 0;
        //iterates over each character and makes sure it contains no funcy characters or a space
        for ($i = 0, $n = strlen($uname); $i < $n; $i++)
        {
            if(!ctype_alpha($uname[$i]))
            {
                if(!is_numeric($uname[$i]))
                {
                    if($uname[$i] != '_')
                    {
                        return false;
                    }
                }
            }
            else
            {
                $alphacount++;
            }
        }
        if($alphacount == 0)
        {
            return false;
        }
        return true;
     }
     
     /**
      * formats the quote's page
      **/
    function quote($symbol, $table)
    {
        render("quotes_form.php", ["symbol" => $symbol, "table" => $table, "title" => "Quotes"]);
    }
      
    /**
     * Apologizes to user with message.
     */
    function apologize($message, $title, $view)
    {
        render($view, ["message" => $message, "title" => $title]);
    }

    /**
     * Facilitates debugging by dumping contents of argument(s)
     * to browser.
     */
    function dump()
    {
        $arguments = func_get_args();
        require("../views/dump.php");
        exit;
    }

    /**
     * Logs out current user, if any.  Based on Example #1 at
     * http://us.php.net/manual/en/function.session-destroy.php.
     */
    function logout()
    {
        // unset any session variables
        $_SESSION = [];

        // expire cookie
        if (!empty($_COOKIE[session_name()]))
        {
            setcookie(session_name(), "", time() - 42000);
        }

        // destroy session
        session_destroy();
    }

    /**
     * Returns a stock by symbol (case-insensitively) else false if not found.
     */
    function lookup($symbol, $multiple)
    {
        // reject symbols that start with ^
        if (preg_match("/^\^/", $symbol))
        {
            return false;
        }

        // reject symbols that contain commas
        if (preg_match("/,/", $symbol))
        {
            return false;
        }

        // headers for proxy servers
        $headers = [
            "Accept" => "*/*",
            "Connection" => "Keep-Alive",
            "User-Agent" => sprintf("curl/%s", curl_version()["version"])
        ];

        // open connection to Yahoo
        $context = stream_context_create([
            "http" => [
                "header" => implode(array_map(function($value, $key) { return sprintf("%s: %s\r\n", $key, $value); }, $headers, array_keys($headers))),
                "method" => "GET"
            ]
        ]);
        $handle = @fopen("http://download.finance.yahoo.com/d/quotes.csv?f=nsl1c1p2&s={$symbol}", "r", false, $context);
        if ($handle === false)
        {
            // trigger (big, orange) error
            trigger_error("Could not connect to Yahoo!", E_USER_ERROR);
            exit;
        }
 
        // download first line of CSV file
        if($multiple == true)
        {
            return $handle;
        }
        $data = fgetcsv($handle);
        if ($data === false || count($data) == 1)
        {
            return false;
        }

        // close connection to Yahoo
        fclose($handle);

        // ensure symbol was found
        if ($data[2] === "N/A" || $data[2] === "0.00")
        {
            return false;
        }

        // return stock as an associative array
        return [
            "name" => $data[0],
            "symbol" => strtoupper($data[1]),
            "price" => floatval($data[2]),
            "change" => floatval($data[3]),
            "percent" => $data[4],
            //"low" => floatval($data[5]),
            //"high"=>floatval($data[6])
        ];
    }

    /**
     * Redirects user to location, which can be a URL or
     * a relative path on the local host.
     *
     * http://stackoverflow.com/a/25643550/5156190
     *
     * Because this function outputs an HTTP header, it
     * must be called before caller outputs any HTML.
     */
    function redirect($location)
    {
        if (headers_sent($file, $line))
        {
            trigger_error("HTTP headers already sent at {$file}:{$line}", E_USER_ERROR);
        }
        header("Location: {$location}");
        exit;
    }

    /**
     * Renders view, passing in values.
     */
    function render($view, $values = [])
    {
        // if view exists, render it
        if (file_exists("../views/{$view}"))
        {
            // extract variables into local scope
            extract($values);
            // renders errors
            if(isset($message))
            {
                require("../views/header.php");
                require("../views/{$view}");
                require("../views/apology.php");
                require("../views/footer.php");
                exit;
            }
            else if(isset($values["table"]))
            {
                require("../views/header.php");
                require("../views/{$view}");
                echo($values["table"]);
                require("../views/footer.php");
                exit;
            }
            // render view (between header and footer)
            else
            {
                require("../views/header.php");
                require("../views/{$view}");
                require("../views/footer.php");
                exit;
            }
        }

        // else err
        else
        {
            trigger_error("Invalid view: {$view}", E_USER_ERROR);
        }
    }

?>
