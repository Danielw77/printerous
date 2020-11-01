<script>
    
$(document).ready(function(){
   $('#usertable').DataTable();
});

function loadFile(){
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('output');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}

function loadFile2(id){
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('output2'+id);
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
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

<?php } ?>

<!-- if validation form error -->
<?php echo validation_errors('<div class="alert alert-danger">','</div>'); ?>

<div class="box">
    <div class="container">
        <div class="title">Organization Detail</div>
        <hr style="width: 94%; border: 1px black solid;">
        <br>

        <!-- detail info -->
        <div class="card col-md-6 mx-auto p-3 shadow">
          <img src="<?php echo base_url($this->encrypt->decode($organization_data[0]->logo)); ?>" class="img-thumbnail mx-auto" width="200" height="200">
          <h5 class="text-center"><b><?php echo $organization_data[0]->name; ?></b></h5>

          <br>

          <table width="80%" style="margin-left: 20%">
            <tr>
              <td>Organization Phone</td>
              <td width="5%">:</td>
              <td><?php echo $organization_data[0]->phone; ?></td>
            </tr>
            <tr>
              <td>Organization email</td>
              <td width="5%">:</td>
              <td><?php echo $organization_data[0]->email; ?></td>
            </tr>
            <tr>
              <td>Organization Website</td>
              <td width="5%">:</td>
              <td><?php echo $organization_data[0]->website; ?></td>
            </tr>
          </table>
        </div>

        <br>
        <br>
        <br>

        <div class="row col-md-11" style="margin-left: 3%">

            <?php if ($this->user->isAdmin() || $this->user->isAccountManager()) { ?>
              <button type="button" class="btn btn-primary btn-md col-md-2 mb-4" data-toggle="modal" data-target="#addpic"><span class="glyphicon glyphicon-plus"></span> Add PIC</button>
            <?php } ?>
            <div class="col-md-12 p-0">
            <table class="display" id="usertable" style="width: 100%;">
              <thead>
                <tr>
                  <th scope="col" style="border-top: none;">#</th>
                  <th class="text-center" scope="col" style="border-top: none;">Avatar</th>
                  <th class="text-center" scope="col" style="border-top: none;">Name</th>
                  <th class="text-center" scope="col" style="border-top: none;">Phone</th>
                  <th class="text-center" scope="col" style="border-top: none;">Email</th>
                  <?php if ($this->user->isAdmin() || $this->user->isAccountManager()) { ?>
                    <th class="text-center" scope="col" style="border-top: none;">Action</th>
                  <?php } ?>
                </tr>
              </thead>
              <tbody>

                <?php if (!empty($pic_data)) { ?>

                        <?php $no=1; foreach ($pic_data as $row) { ?>

                        <tr>
                            <td><b><?php echo $no ?></b></td> 
                            <td class="text-center">
                              <img width="50" height="50" class="img-thumbnail" src="<?php echo base_url($this->encrypt->decode($row->avatar)); ?>" />
                            </td>
                            <td class="text-center"><?php echo $row->user_name ?></td>
                            <td class="text-center"><?php echo $row->user_phone ?></td>
                            <td class="text-center"><?php echo $row->user_email ?></td>
                            <?php if ($this->user->isAdmin() || $this->user->isAccountManager()) { ?>
                              <td class="text-center">
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#editpic<?php echo $row->pic_id ?>">Edit</button>
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deletepic<?php echo $row->pic_id ?>">Delete</button>
                              </td>
                            <?php } ?>
                        </tr>

                        <?php if ($this->user->isAdmin() || $this->user->isAccountManager()) { ?>
                          <div class="modal fade" id="editpic<?php echo $row->pic_id ?>">
                              <?php echo form_open_multipart(base_url().'Organization/edit_pic?id='.$row->id.'&pic_id='.$row->pic_id); ?>
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                            <h4 class="modal-title">Edit PIC</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          </div>
                                          <div class="modal-body">
                                              <div class="form-group">
                                                  <label><b>Name</b></label>
                                                  <input type="text" class="form-control" name="input_name" value="<?php echo $row->user_name ?>" required>
                                               </div>
                                               <div class="form-group">
                                                  <label><b>Phone</b></label>
                                                  <input type="text" class="form-control" name="input_phone" value="<?php echo $row->user_phone ?>" required>
                                               </div>
                                               <div class="form-group">
                                                  <label><b>Email</b></label>
                                                  <input type="email" class="form-control" name="input_email" value="<?php echo $row->user_email ?>" required>
                                               </div>
                                               <div class="form-group">
                                                  <label><b>Avatar (Image)</b></label>
                                                  <input type="file" name="input_avatar" id="input_avatar" accept="image/*" class="form-control-file" onchange="loadFile2('<?php echo $row->pic_id ?>')">
                                               </div>
                                               <img id="output2<?php echo $row->pic_id ?>" width="100" height="100" class="img-thumbnail" src="<?php echo base_url($this->encrypt->decode($row->avatar)); ?>" />
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-dark">Submit</button>
                                          </div>
                                      </div>
                                  </div>
                              </form>
                          </div>

                          <div class="modal fade" id="deletepic<?php echo $row->pic_id ?>">
                              <form action="<?php echo base_url() ?>Organization/delete_pic?id=<?php echo $row->id; ?>&pic_id=<?php echo $row->pic_id; ?>" method="POST">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                            <h4 class="modal-title">Delete PIC</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          </div>
                                          <div class="modal-body">
                                              <p>Are you sure want to delete <b><?php echo $row->user_name ?></b>?</p>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-dark" name="btnSubmit" value="delete">Delete</button>
                                          </div>
                                      </div>
                                  </div>
                              </form>
                          </div>
                        <?php } ?>

                    <?php $no++; } ?>
                <?php } ?>
              </tbody>
            </table>
            </div>

        <a href="<?php echo base_url('organization'); ?>" class="btn btn-primary col-md-3 mx-auto mt-4">Back</a>
    </div>
</div>

<!-- modal add organization -->
    <?php echo form_open_multipart(base_url().'Organization/add_pic?id='.$organization_data[0]->id); ?>
        <div class="modal fade" id="addpic">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Add PIC</h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label><b>Name</b></label>
                            <input type="text" class="form-control" name="input_name" value="<?php echo set_value('input_name') ?>" required>
                         </div>
                         <div class="form-group">
                            <label><b>Phone</b></label>
                            <input type="text" class="form-control" name="input_phone" value="<?php echo set_value('input_phone') ?>" required>
                         </div>
                         <div class="form-group">
                            <label><b>Email</b></label>
                            <input type="email" class="form-control" name="input_email" value="<?php echo set_value('input_email') ?>" required>
                         </div>
                         <div class="form-group">
                            <label><b>Avatar (Image)</b></label>
                            <input type="file" name="input_avatar" id="input_avatar" accept="image/*" class="form-control-file" onchange="loadFile()" required>
                         </div>
                         <img id="output" width="100" height="100" class="img-thumbnail" />
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-dark">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

<!-- space between footer -->
<br>
<br>
<br>
<br>
<br>