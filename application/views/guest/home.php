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


<style type="text/css">
    .field{
        height: 100px;
        text-align: center;
        font-size: 50px;
        cursor: pointer;
        width: 33%;
    }
</style>

<script type="text/javascript">

    var curPLayer = 'O';
    var occupiedField = [];
    var finish = false;

    function changePlayer(selected){
        curPLayer = $(selected).val();
        console.log(curPLayer);
    }

    var winCondtion = [];
    //horizontal
    winCondtion.push([0,1,2]);
    winCondtion.push([3,4,5]);
    winCondtion.push([6,7,8]);

    //vertical
    winCondtion.push([0,3,6]);
    winCondtion.push([1,4,7]);
    winCondtion.push([2,5,8]);

    //miring
    winCondtion.push([0,4,8]);
    winCondtion.push([2,4,6]);

    function draw(selected){

        if (finish) {
            alert('The game has ended');
            return false;
        }

        let id = $(selected).attr('id');
        if (jQuery.inArray(id, occupiedField) !== -1) {
            alert('Field already selected');
            return false;
        }
        else{
            $(selected).text(curPLayer);
            occupiedField.push(id);
            $('#curRole').show()
            if (isWin()) {
                return false;
            }
            else if(occupiedField.length == 9){
                $('#playAgain').show();
                $('td').prop('disabled', true);
                $('td').prop('style', 'background-color: grey');

                $('#curRole').hide();
                $('#winState').show();
                $('#winState').html('Draw!');
                return false;
            }
        }

        
        if  (curPLayer == 'O') {
            curPLayer = 'X';
        }
        else{
            curPLayer = 'O';
        } 
        // alert('kkljlj');
        $('#curRole').html('Player '+curPLayer+' turn!');

        $('#role').hide();
        $('#roleLabel').hide();
        
    }

    function isWin(){
        $.each( winCondtion, function( key, value ) {
            var countX = 0;
            var countO = 0;
            var winXArr = [];
            var winOArr = [];
            $.each(value, function( idx, val ) {
                if ($('#'+val).text() == 'X') {
                    winXArr.push(val);
                    countX++;
                }else if($('#'+val).text() == 'O'){
                    winOArr.push(val);
                    countO++;
                }
            });

            if (countX == 3) {
                // alert('Player X Win!');
                $('#playAgain').show();
                $('td').prop('disabled', true);
                $('td').prop('style', 'background-color: grey');

                $.each(winXArr, function( idx, val ) {
                    $('#'+val).prop('style', 'background-color: red');
                });

                $('#curRole').hide();
                $('#winState').show();
                $('#winState').html('Player '+curPLayer+' Wins!');

                finish = true;

                return true;
            }
            else if (countO == 3){
                // alert('Player O Win!');
                $('#playAgain').show();
                $('td').prop('disabled', true);
                $('td').prop('style', 'background-color: grey');

                $.each(winOArr, function( idx, val ) {
                    $('#'+val).prop('style', 'background-color: red');
                });

                $('#curRole').hide();
                $('#winState').show();
                $('#winState').html('Player '+curPLayer+' Wins!');

                finish = true;

                return true;
            }
        });

        return false;
    }

</script>

<div class="container-fluid" style="padding: 0;">
  <div class="jumbotron">
    <h1 align="center">Printerous Code Challenge</h1>      
    <h1 align="center">Hi <?php echo $username ?>!</h1>      
    <!-- <p align="center">Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum </p>
    <p align="center">Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum </p>      
    <p align="center">Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum </p>  -->
  </div>

  <div class="portlet-body">
    <div class="col-md-12" align="center">

        <h5 class="text-primary"><b>Tic Tac Toe</b></h5>

        <br>
        <h6 id="curRole" style="display: none;"><b></b></h6>
        <h6 id="winState" style="display: none;"><b></b></h6>
        <h6 id="playAgain" style="display: none; cursor: pointer;" onclick="window.location.reload()"><b>Play Again</b></h6>
        <h6 id="roleLabel"><b>Select Your Role</b></h6>
        <select id="role" class="form-control col-3" onChange="changePlayer(this)">
            <option value="O">Player O</option>
            <option value="X">Player X</option>
        </select>

        <br>
        <br>

        <table class="table-bordered" width="50%">
            <tr>
                <td class="field" id="0" onClick="draw(this)"></td>
                <td class="field" id="1" onClick="draw(this)"></td>
                <td class="field" id="2" onClick="draw(this)"></td>
            </tr>
            <tr>
                <td class="field" id="3" onClick="draw(this)"></td>
                <td class="field" id="4" onClick="draw(this)"></td>
                <td class="field" id="5" onClick="draw(this)"></td>
            </tr>
            <tr>
                <td class="field" id="6" onClick="draw(this)"></td>
                <td class="field" id="7" onClick="draw(this)"></td>
                <td class="field" id="8" onClick="draw(this)"></td>
            </tr>
        </table>
    </div>
</div>

</div>   

<!-- space between footer -->
<br>
<br>
<br>
<br>
<br>