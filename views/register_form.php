<form action="register.php" method="post">
    <h2>Registration Form</h2>
    <fieldset>
         <div class="form-group">
            <input autocomplete="off" autofocus class="form-control" name="email" placeholder="E-mail" type="text" 
            <?php if(!empty($_POST["email"])){printf("value=\"%s\"",$_POST["email"]);}?>/>
        </div>
        <div class="form-group">
            <input autocomplete="off"  class="form-control" name="username" placeholder="Username" type="text" 
            <?php if(!empty($_POST["username"])){printf("value=\"%s\"",$_POST["username"]);}?>/>
        </div>
        <div class="form-group">
            <input class="form-control" name="password" placeholder="Password" type="password"/>
        </div>
        <div class="form-group">
            <input class="form-control" name="password2" placeholder="Confirm Password" type="password"/>
        </div>
        <div class="form-group">
            <button class="btn btn-default" type="submit">
                <span aria-hidden="true" class="glyphicon glyphicon-register"></span>
                Register
            </button>
        </div>
    </fieldset>
</form>
<div>
    or <a href="login.php">Log in</a> if you already have an account
</div>
