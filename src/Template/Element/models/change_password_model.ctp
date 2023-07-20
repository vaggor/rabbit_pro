
<!-- Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header model-header-color">
                <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <?php echo $this->Form->create('User',array('url'=>'/users/changePassword','class'=>'')); ?>
                <div class="row">                    
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Old Password*</label>
                            <!-- <input placeholder="default" type="text" class="mb-2 form-control" autocomplete="off" cursor: auto;"> -->
                            <?php echo $this->Form->control('opass',array('type'=>'password','id'=>'name','label'=>false,'class'=>'mb-2 form-control','div'=>false,'placeholder'=>'Old password here...','required'=>true,'autocomplete'=>'off'));
                                echo $this->Form->control('soruce',array('type'=>'hidden','id'=>'soruce','value'=>'web'));
                             ?>
                        </div>


                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Confirm Password*</label>
                            <?php echo $this->Form->control('cpass',array('type'=>'password','id'=>'name','label'=>false,'class'=>'mb-2 form-control','div'=>false,'placeholder'=>'Confirm password here...','required'=>true,'autocomplete'=>'off'));
                             ?>
                        </div>

                    </div>





                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">New Password*</label>
                            <?php echo $this->Form->control('password',array('type'=>'password','id'=>'name','label'=>false,'class'=>'mb-2 form-control','div'=>false,'placeholder'=>'New password here...','required'=>true,'autocomplete'=>'off'));
                             ?>
                        </div>
                    </div>


                </div>

            </div>
            <!-- </form> -->
            <div class="modal-footer model-header-color">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
        </form>
    </div>
</div>