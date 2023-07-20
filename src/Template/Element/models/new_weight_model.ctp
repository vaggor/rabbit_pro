
<!-- Modal -->
<div class="modal fade" id="newWeightModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header model-header-color">
                <h5 class="modal-title" id="exampleModalLabel">New Weight</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <?php echo $this->Form->create('User',array('url'=>'/breeders/addWeight','class'=>'')); ?>
                <div class="row">                    
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Weight*</label>
                            <!-- <input placeholder="default" type="text" class="mb-2 form-control" autocomplete="off" cursor: auto;"> -->
                            <?php echo $this->Form->control('weight',array('type'=>'text','id'=>'weight','label'=>false,'class'=>'mb-2 form-control','div'=>false,'placeholder'=>'Weight here...','required'=>true,'autocomplete'=>'off'));
                                echo $this->Form->control('soruce',array('type'=>'hidden','id'=>'soruce','value'=>'web'));
                                echo $this->Form->control('breeder_id',array('type'=>'hidden','id'=>'weight_model_breeder_id'));
                             ?>
                        </div>

                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Date*</label>
                            <input type="date" id="new_weigh_model_date_weighed" name="date_weighed" class="mb-2 form-control" 'required'>   
                        </div>


                    </div>





                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Unit</label>
                            <?php echo $this->Form->control('unit_id',array('type'=>'select','id'=>'unit_id','label'=>false,'class'=>'multiselect-dropdown form-control','div'=>false,'options' => array(''=>'Select Unit',$units))); ?>
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