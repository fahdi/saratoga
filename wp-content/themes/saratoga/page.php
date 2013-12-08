<?php
    get_header();
?>

        <h2>Welcome, you can login securely below.</h2>
        <form class="form-signin">
        <input type="email" class="form-control" placeholder="EMAIL" required autofocus>
        <input type="password" class="form-control" placeholder="PASSWORD" required>
        <span id="forgotpass">forgot password?</span>
        <button class="btn btn-lg btn-primary btn-block" id="loginbutton" type="submit">LOGIN</button>
      </form>
      </div>


    <div class="container home">
        <h1>A real estate investment company<br/>focused on value-add multifamily projects.</h1>
        <div class='row'  id='buttons'>
            <div class='col-md-8'>
                <?php 

while ( have_posts() ) : the_post();
the_content();
endwhile;
?>
            </div>
            
        </div>
      </div>
<?php
get_footer();    
    ?>    

  