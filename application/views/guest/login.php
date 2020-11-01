<div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Tabs Titles -->

    <!-- Icon -->
    <div class="fadeIn first">
      <br>
      <img src="<?php echo base_url(); ?>application/assets/img/usericon.png" id="icon" alt="User Icon" />
    </div>

    <br>
    
    <!-- if validation form error -->
      <?php echo validation_errors('<div class="alert alert-danger">','</div>'); ?>

      <?php
        $msg = $this->session->flashdata('message');
        if (!empty($msg)) { ?>
        
        <script type="text/javascript">
            $(document).ready(function(){
                Swal.fire({
                    position: 'top',
                    type: <?php echo "'".$msg['alerttype']."'" ?>,
                    title: <?php echo "'".$msg['message']."'" ?>,
                    showConfirmButton: false,
                    timer: 1000
                })
            });
        </script>

    <?php } ?>

    <form action="<?php echo base_url() ?>Login/login" method="POST">
      <input type="text" class="fadeIn second loginform" name="input_email" value="<?php echo set_value('input_email'); ?>" placeholder="E-Mail" required>
      <input type="password" class="fadeIn third loginform" name="input_password" placeholder="Password" required>
      <input type="submit" class="fadeIn fourth loginform" value="Log In" name="submit_login">
      <br>
    </form>

    <!-- Register -->
    <div id="formFooter">
      <a class="underlineHover" href="<?php echo base_url() ?>register/index">Register click Here</a>
    </div>

  </div>
</div>

<!-- space between footer -->
<br>
<br>
<br>
<br>
<br>