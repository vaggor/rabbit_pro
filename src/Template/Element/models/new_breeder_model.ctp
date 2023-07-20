
<!-- Modal -->
<div class="modal fade" id="newBreederModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header model-header-color">
                <h5 class="modal-title" id="exampleModalLabel">New Breeder</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <?php echo $this->Form->create('User',array('url'=>'/breeders/addNewBreed','class'=>'','id'=>'newBreederForm')); ?>
                <div class="row">                    
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Name*</label>
                            <!-- <input placeholder="default" type="text" class="mb-2 form-control" autocomplete="off" cursor: auto;"> -->
                            <?php echo $this->Form->control('name',array('type'=>'text','id'=>'name','label'=>false,'class'=>'mb-2 form-control','div'=>false,'placeholder'=>'Name here...','required'=>true,'autocomplete'=>'off'));
                                echo $this->Form->control('soruce',array('type'=>'hidden','id'=>'soruce','value'=>'web'));
                             ?>
                        </div>

                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Breeder ID</label>
                            <!-- <input placeholder="default" type="text" class="mb-2 form-control" autocomplete="off" cursor: auto;"> -->
                            <?php echo $this->Form->control('breeder_id',array('type'=>'text','id'=>'breeder_id','label'=>false,'class'=>'mb-2 form-control','div'=>false,'placeholder'=>'Breeder ID here...','autocomplete'=>'off')); ?>
                        </div>

                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Breed</label>
                            <!-- <input placeholder="default" type="text" class="mb-2 form-control" autocomplete="off" cursor: auto;"> -->
                            <?php echo $this->Form->control('breed_id',array('type'=>'select','id'=>'breed_id','label'=>false,'class'=>'multiselect-dropdown form-control','div'=>false,'options' => array(''=>'Select Breed',$breeds))); ?>
                        </div>

                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Date of Birth</label>
                            <input type="date" id="date_born" name="date_born" max="<?php echo date('Y-m-d'); ?>" class="mb-2 form-control">   
                        </div>

                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Father</label>
                            <?php echo $this->Form->control('father',array('type'=>'select','id'=>'father','label'=>false,'class'=>'multiselect-dropdown form-control','div'=>false,'options' => array(''=>'Select Father',$bucks))); ?>
                        </div>
                    </div>





                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Cage ID</label>
                            <!-- <input placeholder="default" type="text" class="mb-2 form-control" autocomplete="off" cursor: auto;"> -->
                            <?php echo $this->Form->control('cage',array('type'=>'text','id'=>'cage','label'=>false,'class'=>'mb-2 form-control','div'=>false,'placeholder'=>'Cage ID here...','autocomplete'=>'off')); ?>
                        </div>

                        <div class="position-relative form-group">
                        <label for="exampleCustomSelect" class="">Colour</label>
                            <!-- <input placeholder="default" type="text" class="mb-2 form-control" autocomplete="off" cursor: auto;"> -->
                            <?php echo $this->Form->control('color',array('type'=>'text','id'=>'color','label'=>false,'class'=>'mb-2 form-control','div'=>false,'placeholder'=>'Colour here...','autocomplete'=>'off')); ?>
                    </div>

                    <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Sex*</label>
                            <!-- <input placeholder="default" type="text" class="mb-2 form-control" autocomplete="off" cursor: auto;"> -->
                            <?php echo $this->Form->control('sex_id',array('type'=>'select','id'=>'sex_id','label'=>false,'class'=>'multiselect-dropdown form-control','div'=>false,'required'=>true,'options' => array(''=>'Select Sex',$sexes))); ?>
                    </div>

                    <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Date Acquired</label>
                            <input type="date" id="date_acquired" name="date_acquired" max="<?php echo date('Y-m-d'); ?>" class="mb-2 form-control">   
                    </div>

                    <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Mother</label>
                            <?php echo $this->Form->control('mother',array('type'=>'select','id'=>'mother','label'=>false,'class'=>'multiselect-dropdown form-control','div'=>false,'options' => array(''=>'Select Mother',$does))); ?>
                    </div>

                </div>
        </div>
            </div>
            <!-- </form> -->
            <div class="modal-footer model-header-color">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="newBreederSubmit1_Btn">Close</button>
                <button type="submit" class="btn btn-primary" id="newBreederSubmit1_Btn">Submit</button>
            </div>
        </div>
        </form>
    </div>
</div>