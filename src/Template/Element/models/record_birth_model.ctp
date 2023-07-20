
<!-- Modal -->
<div class="modal fade" id="recordBirthModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header model-header-color">
                <h5 class="modal-title" id="exampleModalLabel">Record Birth</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <?php echo $this->Form->create('User',array('url'=>'/births/recordBirth','class'=>'','id'=>'newBreederForm')); ?>
                <div class="row">                    
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Litter ID*</label>
                            <!-- <input placeholder="default" type="text" class="mb-2 form-control" autocomplete="off" cursor: auto;"> -->
                            <?php echo $this->Form->control('litter_id',array('type'=>'text','id'=>'name','label'=>false,'class'=>'mb-2 form-control','div'=>false,'placeholder'=>'Liter ID here...','required'=>true,'autocomplete'=>'off'));
                                echo $this->Form->control('soruce',array('type'=>'hidden','id'=>'soruce','value'=>'web'));
                             ?>
                        </div>

                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class=""># live kits</label>
                            <!-- <input placeholder="default" type="text" class="mb-2 form-control" autocomplete="off" cursor: auto;"> -->
                            <?php echo $this->Form->control('no_live_kits',array('type'=>'text','id'=>'no_live_kits','label'=>false,'class'=>'mb-2 form-control','div'=>false,'placeholder'=>'No. of live kits here...','autocomplete'=>'off')); ?>
                        </div>

                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Total no. of kits</label>
                            <!-- <input placeholder="default" type="text" class="mb-2 form-control" autocomplete="off" cursor: auto;"> -->
                            <?php echo $this->Form->control('no_kits',array('type'=>'text','id'=>'no_kits','label'=>false,'class'=>'mb-2 form-control','div'=>false,'placeholder'=>'Total no. of kits here...','autocomplete'=>'off')); ?>
                        </div>

                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Date of Birth</label>
                            <input type="date" id="date_born" name="date_born" max="<?php echo date('Y-m-d'); ?>" class="mb-2 form-control">   
                        </div>

                    </div>





                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Schedule</label>
                            <?php echo $this->Form->control('plan_id',array('type'=>'select','id'=>'plan_id','label'=>false,'class'=>'multiselect-dropdown form-control','div'=>false,'required'=>true,'options' => array(''=>'Select Schedule',$planes))); ?>
                        </div>

                        <div class="position-relative form-group">
                        <label for="exampleCustomSelect" class=""># Dead Kits</label>
                            <!-- <input placeholder="default" type="text" class="mb-2 form-control" autocomplete="off" cursor: auto;"> -->
                            <?php echo $this->Form->control('no_dead_kits',array('type'=>'text','id'=>'no_dead_kits','label'=>false,'class'=>'mb-2 form-control','div'=>false,'placeholder'=>'No. of dead kits here...','autocomplete'=>'off')); ?>
                        </div>

                    <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Cage ID</label>
                            <!-- <input placeholder="default" type="text" class="mb-2 form-control" autocomplete="off" cursor: auto;"> -->
                            <?php echo $this->Form->control('cage',array('type'=>'text','id'=>'cage','label'=>false,'class'=>'mb-2 form-control','div'=>false,'placeholder'=>'Cage ID here...','autocomplete'=>'off')); ?>
                    </div>

                    <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Date Bred</label>
                            <input type="date" id="date_bred" name="date_bred" max="<?php echo date('Y-m-d'); ?>" class="mb-2 form-control">   
                        </div>


                </div>
        </div>
            </div>
            <!-- </form> -->
            <div class="modal-footer model-header-color">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="recordBirthSubmit_Btn">Submit</button>
            </div>
        </div>
        </form>
    </div>
</div>