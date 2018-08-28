

<div class="reveal-modal tiny" id="login" data-reveal>
  
  <form action="" class="loginform text-center"  method='post'>
  <h2 id="Login">Login</h2>
    <input type="email" name='u' required placeholder='Email'>
    <input type="password" name='p'  placeholder='Password' pattern="^[a-zA-Z0-9_]{4,}$">
    <button class='button pink'>Send</button>
    <input type="hidden" name='action' value='login'>


    <div data-alert class="callout alert hide">
      Email or password incorrect.
    </div>

    <hr>
    <div class="row text-center">
      <div class="columns medium-6">
          <h5>Forgot your password?</h5>
          <a href="<?php echo SITEURL;?>resetpassword/" class='button tiny'>Reset password</a>  
      </div>
      <div class="columns medium-6">
        <h5>Not a registered user? </h5>      
      <a href="register/" class="button tiny">Register now</a>    
      </div>
      
    </div>
    
  </form>

  <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<script>
$(document).ready(function () {

 $('.loginform').on('submit', function (e) {
    console.log('login');
    e.preventDefault();
    $.post("<?php echo SITEURL;?>includes/actions.php", 
        $('.loginform').serialize(),

        function(data){
          console.log(data);
            if (data == 0) {
              $('.loginform .alert').removeClass('hide');
            } else {
              window.location.reload();
            }
         }
    );
     
 });


});
</script>
