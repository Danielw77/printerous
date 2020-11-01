<div class="wrapper fadeInDown">
  <div id="formContent">
    <div class="fadeIn first">
      <br>
      <h2><b>Register</b></h2>
      <br>
    </div>

    <!-- if validation form error -->
    <?php echo validation_errors('<div class="alert alert-danger">','</div>'); ?>

    <!-- flashdata if success register -->
    <?php
      if ($this->session->flashdata('message')) {
        echo '<div class="alert alert-success">'.$this->session->flashdata('message').'</div>';
      }
    ?>
    <form action="<?php echo base_url() ?>Register/register" method="POST">
      <input type="email" class="fadeIn second loginform" name="input_email" value="<?php echo set_value('input_email'); ?>" placeholder="E-Mail" required>
      <input type="text" class="fadeIn second loginform" name="input_name" value="<?php echo set_value('input_name'); ?>" placeholder="Name" required>
      <input type="password" class="fadeIn third loginform" name="input_password" placeholder="Password" required>
      <input type="password" class="fadeIn third loginform" name="input_repassword" placeholder="Re-type Password" required>
      <input type="submit" class="fadeIn fourth loginform" value="Register" name="submit_register">
    </form>

    <!-- Remind Passowrd -->
    <div id="formFooter">
      <a class="underlineHover" href="<?php echo base_url() ?>login/index">Back to Login</a>
    </div>

  </div>
</div>

<!-- space between footer -->
<br>
<br>
<br>
<br>
<br>