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
        <div class="title">Organization List</div>
        <hr style="width: 94%; border: 1px black solid;">
        <br>

        <div class="row col-md-11" style="margin-left: 3%">

            <?php if ($this->user->isAdmin()) { ?>
                <button type="button" class="btn btn-primary btn-md col-md-2 mb-4" data-toggle="modal" data-target="#addorganization"><span class="glyphicon glyphicon-plus"></span> Add Organization</button>
             <?php } ?>
            <div class="col-md-12 p-0">
            <table id="usertable" style="width: 100%;">
              <thead>
                <tr>
                  <th scope="col" style="border-top: none;">#</th>
                  <th class="text-center" scope="col" style="border-top: none;">Logo</th>
                  <th class="text-center" scope="col" style="border-top: none;">Name</th>
                  <th class="text-center" scope="col" style="border-top: none;">Phone</th>
                  <th class="text-center" scope="col" style="border-top: none;">Email</th>
                  <?php if ($this->user->isAdmin() || $this->user->isAccountManager()) { ?>
                    <th class="text-center" scope="col" style="border-top: none;">Action</th>
                  <?php } ?>
                </tr>
              </thead>
              <tbody>

                <?php if (!empty($organization_data)) { ?>

                        <?php $no=1; foreach ($organization_data as $row) { ?>

                        <tr>
                            <td><b><?php echo $no ?></b></td>
                            <td class="text-center">
                              <img width="50" height="50" class="img-thumbnail" src="<?php echo base_url($this->encrypt->decode($row->logo)); ?>" />
                            </td>
                            <td class="text-center"><a href="<?php echo base_url().'Organization/detail?id='.$row->id ?>" /><?php echo $row->name ?></td>
                            <td class="text-center"><?php echo $row->phone ?></td>
                            <td class="text-center"><?php echo $row->email ?></td>
                            <?php if ($this->user->isAdmin() || $this->user->isAccountManager()) { ?>
                                <td class="text-center">
                                    
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#editorganization<?php echo $row->id ?>">Edit</button>
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteorganization<?php echo $row->id ?>">Delete</button>
                                </td>
                            <?php } ?>
                        </tr>

                        <?php if ($this->user->isAdmin() || $this->user->isAccountManager()) { ?>
                            <div class="modal fade" id="editorganization<?php echo $row->id ?>">
                                <?php echo form_open_multipart(base_url().'Organization/edit_organization?id='.$row->id); ?>
                               <!--  <form method="post" action="<?php echo base_url().'Organization/edit_organization?id='.$row->id; ?>" enctype="multipart/form-data" accept-charset="utf-8"> -->
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                              <h4 class="modal-title">Edit Organization</h4>
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label><b>Name</b></label>
                                                    <input type="text" class="form-control" name="input_name" value="<?php echo $row->name ?>" required>
                                                 </div>
                                                 <div class="form-group">
                                                    <label><b>Phone</b></label>
                                                    <input type="text" class="form-control" name="input_phone" value="<?php echo $row->phone ?>" required>
                                                 </div>
                                                 <div class="form-group">
                                                    <label><b>Email</b></label>
                                                    <input type="email" class="form-control" name="input_email" value="<?php echo $row->email ?>" required>
                                                 </div>
                                                 <div class="form-group">
                                                    <label><b>Website</b></label>
                                                    <input type="text" class="form-control" name="input_website" value="<?php echo $row->website ?>" required>
                                                 </div>
                                                 <div class="form-group">
                                                    <label><b>Logo (Image)</b></label>
                                                    <input type="file" name="input_logo" id="input_logo" accept="image/*" class="form-control-file" onchange="loadFile2('<?php echo $row->id ?>')">
                                                 </div>
                                                 <img id="output2<?php echo $row->id ?>" width="100" height="100" class="img-thumbnail" src="<?php echo $this->encrypt->decode($row->logo) ?>" />
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                              <button type="submit" class="btn btn-dark">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="modal fade" id="deleteorganization<?php echo $row->id ?>">
                                <form action="<?php echo base_url() ?>Organization/delete_organization?id=<?php echo $row->id ?>" method="POST">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                              <h4 class="modal-title">Delete Organization</h4>
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure want to delete <b><?php echo $row->name ?></b>?</p>
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
    </div>
</div>

<!-- modal add organization -->
    <?php echo form_open_multipart(base_url().'Organization/add_organization'); ?>
        <div class="modal fade" id="addorganization">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Add Organization</h4>
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
                            <label><b>Website</b></label>
                            <input type="text" class="form-control" name="input_website" value="<?php echo set_value('input_website') ?>" required>
                         </div>
                         <div class="form-group">
                            <label><b>Logo (Image)</b></label>
                            <input type="file" name="input_logo" id="input_logo" accept="image/*" class="form-control-file" onchange="loadFile()" required>
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