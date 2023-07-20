
<!-- Modal -->
<div class="modal fade" id="editTaskModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header model-header-color">
                <h5 class="modal-title" id="exampleModalLabel">Edit Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <?php echo $this->Form->create('User',array('url'=>'/tasks/edit_task','class'=>'')); ?>
                <div class="row">                    
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Name*</label>
                            <!-- <input placeholder="default" type="text" class="mb-2 form-control" autocomplete="off" cursor: auto;"> -->
                            <?php echo $this->Form->control('name',array('type'=>'text','id'=>'editTask_name','label'=>false,'class'=>'mb-2 form-control','div'=>false,'placeholder'=>'Name here...','required'=>true,'autocomplete'=>'off'));
                                echo $this->Form->control('soruce',array('type'=>'hidden','id'=>'soruce','value'=>'web'));
                                echo $this->Form->control('id',array('type'=>'hidden','id'=>'editTask_id'));
                             ?>
                        </div>


                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Date*</label>
                            <input type="date" id="editTask_date" name="date" class="mb-2 form-control" required="required">   
                        </div>

                    </div>





                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Category</label>
                            <?php echo $this->Form->control('schedule_type_id',array('type'=>'select','id'=>'editTask_schedule_type_id','label'=>false,'class'=>'multiselect-dropdown form-control','div'=>false,'options' => array(''=>'Select Category',$schedule_types))); ?>
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