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
        <div class="title">Account List</div>
        <hr style="width: 94%; border: 1px black solid;">
        <br>

        <div class="row col-md-11" style="margin-left: 3%">

            <button type="button" class="btn btn-primary btn-md col-md-2 mb-4" data-toggle="modal" data-target="#addaccount"><span class="glyphicon glyphicon-plus"></span> Add Account</button>
            <div class="col-md-12 p-0">
            <table id="usertable" style="width: 100%;">
              <thead>
                <tr>
                  <th scope="col" style="border-top: none;">#</th>
                  <th class="text-center" scope="col" style="border-top: none;">Name</th>
                  <th class="text-center" scope="col" style="border-top: none;">Email</th>
                  <th class="text-center" scope="col" style="border-top: none;">Role</th>
                  <th class="text-center" scope="col" style="border-top: none;">Action</th>
                </tr>
              </thead>
              <tbody>

                <?php if (!empty($account_data)) { ?>

                        <?php $no=1; foreach ($account_data as $row) { ?>

                        <tr>
                            <td><b><?php echo $no ?></b></td>
                            <td class="text-center"><?php echo $row->nama ?></td>
                            <td class="text-center"><?php echo $row->email ?></td>
                            <td class="text-center"><?php echo $role[$row->role] ?></td>
                            <td class="text-center">
                                <?php if ($row->role == 'AM') { ?>
                                  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#assign<?php echo $row->id ?>">Assign</button>
                                <?php } ?>

                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteaccount<?php echo $row->id ?>">Delete</button>
                            </td>
                        </tr>

                        <?php if ($row->role == 'AM') { ?>
                          <div class="modal fade" id="assign<?php echo $row->id ?>">
                              <?php echo form_open(base_url().'Admin/assignorganization?id='.$row->id); ?>
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                            <h4 class="modal-title">Assign to organization</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          </div>
                                          <div class="modal-body">
                                              <?php 

                                              if (!empty($organization_data)) {

                                              foreach ($organization_data as $org) { 

                                                $currentAssigned = $row->assigned_organization;

                                                $checked = '';
                                                if ($currentAssigned != null) {
                                                  $organizationAssigned = explode(',', $currentAssigned);

                                                  if (in_array($org->id, $organizationAssigned)) {
                                                    $checked = 'checked';
                                                  }
                                                }

                                              ?>
                                                <div class="form-check">
                                                  <label class="form-check-label">
                                                    <input type="checkbox" name="assignto[]" class="form-check-input" value="<?php echo $org->id ?>" <?php echo $checked; ?>><?php echo $org->name ?>
                                                  </label>
                                                </div>
                                              <?php 
                                                }
                                              }
                                              else{ ?>

                                                <h5>No Organization Data</h5>

                                              <?php } ?>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-dark">Submit</button>
                                          </div>
                                      </div>
                                  </div>
                              </form>
                          </div>
                        <?php } ?>

                        <div class="modal fade" id="deleteaccount<?php echo $row->id ?>">
                            <form action="<?php echo base_url() ?>Admin/delete_account?id=<?php echo $row->id ?>" method="POST">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                          <h4 class="modal-title">Delete Account</h4>
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure want to delete <b><?php echo $row->nama ?></b>?</p>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                          <button type="submit" class="btn btn-dark" name="btnSubmit" value="delete">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php $no++; } ?>
                <?php } ?>
              </tbody>
            </table>
            </div>
    </div>
</div>

<!-- modal add account -->
    <?php echo form_open_multipart(base_url().'Admin/add_account'); ?>
        <div class="modal fade" id="addaccount">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Add Account</h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label><b>Name</b></label>
                            <input type="text" class="form-control" name="input_name" value="<?php echo set_value('input_name') ?>" required>
                         </div>
                         <div class="form-group">
                            <label><b>Email</b></label>
                            <input type="email" class="form-control" name="input_email" value="<?php echo set_value('input_email') ?>" required>
                         </div>
                         <div class="form-group">
                            <label><b>Password</b></label>
                            <input type="password" class="form-control" name="input_password" value="<?php echo set_value('input_password') ?>" required>
                         </div>
                         <div class="form-group">
                            <label><b>Re-type Password</b></label>
                            <input type="password" class="form-control" name="input_repassword" value="<?php echo set_value('input_repassword') ?>" required>
                         </div>
                         <div class="form-group">
                            <label><b>Role</b></label>
                            <select name="select_role" class="form-control">
                              <option value="NA">Normal Account</option>
                              <option value="AM">Account Manager</option>
                            </select>
                         </div>
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