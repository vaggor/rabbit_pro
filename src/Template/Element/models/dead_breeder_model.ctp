
<!-- Modal -->
<div class="modal fade" id="deadBreederModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header model-header-color">
                <h5 class="modal-title" id="deadModalLabel">Mark as dead</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <?php echo $this->Form->create('User',array('url'=>'/breeders/editBreeder','class'=>'','id'=>'deadBreederForm')); ?>
                <div class="row">                    
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Cause of death*</label>
                            <!-- <input placeholder="default" type="text" class="mb-2 form-control" autocomplete="off" cursor: auto;"> -->
                            <?php echo $this->Form->control('cause_of_death',array('type'=>'text','id'=>'cause_of_death','label'=>false,'class'=>'mb-2 form-control','div'=>false,'placeholder'=>'Cause of death here...','required'=>true,'autocomplete'=>'off'));
                                echo $this->Form->control('soruce',array('type'=>'hidden','id'=>'soruce','value'=>'web'));
                                echo $this->Form->control('id',array('type'=>'hidden','id'=>'deadBreederForm_id'));
                                echo $this->Form->control('status_id',array('type'=>'hidden','value'=>6));
                             ?>
                        </div>

                    </div>




        </div>
            </div>
            <!-- </form> -->
            <div class="modal-footer model-header-color">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="sellBreederSubmit_Btn">Submit</button>
            </div>
        </div>
        </form>
    </div>
</div>