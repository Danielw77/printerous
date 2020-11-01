<script>
	
$(document).ready(function(){
	clockUpdate();
  	setInterval(clockUpdate, 1000);
});

function clockUpdate() {
  var date = new Date();
  $('.digital-clock').css({'color': 'black'});
  function addZero(x) {
    if (x < 10) {
      return x = '0' + x;
    } else {
      return x;
    }
  }

  var h = addZero(date.getHours());
  var m = addZero(date.getMinutes());
  var s = addZero(date.getSeconds());

  $('.digital-clock').text(h + ':' + m + ':' + s)
}
</script>

<?php
	$msg = $this->session->flashdata('message');
	if (!empty($msg)) { 
?>
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
<?php
	}
?>

<style type="text/css">
    .menuHeading{
        color: white;
        position: relative;
        top: 50%;
        transform: translateY(-50%);
        -webkit-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
    }

    .menuLogo{
        color: white;
        font-size: 60px;
        position: relative;
        top: 50%;
        left: 45%;
        text-align: center;
        transform: translateY(-50%);
        -webkit-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
    }
</style>

<div class="box">
    <div class="container">
    	<div class="row">
    		<div class="col-md-8">
    			<div class="title"> Admin Dashboard </div>
    		</div>
    		<div class="col-md-4">
    			<div class="input-group pt-4">
    				<h3 class="pt-2"><?php echo date('D, d M y') ?>&nbsp;&nbsp;&nbsp;</h3>
    				<div class="digital-clock my-auto">00:00:00</div>
    			</div>
    		</div>
    	</div>
    	<hr style="width: 94%; border: 1px black solid;">

        <div class="row">
            <div class="col-md-6" onclick="window.location.href='<?php echo base_url('Admin/accountmanagement') ?>'" style="background-image: linear-gradient(to right top, #051937, #004d7a, #008793, #00bf72, #a8eb12);cursor: pointer;">
                <i class="fa fa-user mb-2 menuLogo" aria-hidden="true"></i>
                <h2 class="menuHeading text-center">Account Management</h2>
            </div>
            <div class="col-md-6" onclick="window.location.href='<?php echo base_url('organization') ?>'" style="height: 500px; background-image: linear-gradient(to right top, #c03c58, #ce404b, #d9483b, #df5427, #e16302);cursor: pointer;">
                <i class="fa fa-users mb-2 menuLogo" aria-hidden="true"></i>
                <h2 class="menuHeading text-center">Organization Management</h2>
            </div>
        </div>

    </div>
</div>
    	