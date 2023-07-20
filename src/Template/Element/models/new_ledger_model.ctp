
<!-- Modal -->
<div class="modal fade" id="newLedgerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header model-header-color">
                <h5 class="modal-title" id="exampleModalLabel">Add new ledger</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <?php echo $this->Form->create('User',array('url'=>'/ledgers/new_ledger','class'=>'','id'=>'editBreederForm')); ?>
                <div class="row">                    
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Date*</label>
                            <input type="date" id="new_ledger_date" name="date" max="<?php echo date('Y-m-d'); ?>" class="mb-2 form-control" required='true'>   
                            <?php 
                                echo $this->Form->control('soruce',array('type'=>'hidden','id'=>'soruce','value'=>'web'));
                             ?>
                        </div>

                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Type*</label>
                            <!-- <input placeholder="default" type="text" class="mb-2 form-control" autocomplete="off" cursor: auto;"> -->
                            <?php echo $this->Form->control('ledger_type_id',array('type'=>'select','id'=>'new_ledger_type','label'=>false,'required'=>true,'class'=>'multiselect-dropdown form-control','div'=>false,'options' => array(''=>'Select Breed',$ledger_types))); ?>
                        </div>

                        <div class="position-relative form-group" style="display: none;" id="new_ledger_breeders_div">
                            <label for="exampleCustomSelect" class="">Breeder*</label>
                            <!-- <input placeholder="default" type="text" class="mb-2 form-control" autocomplete="off" cursor: auto;"> -->
                            <?php echo $this->Form->control('breeder_id',array('type'=>'select','id'=>'new_ledger_breeder_id','label'=>false,'class'=>'multiselect-dropdown form-control','div'=>false,'options' => array(''=>'Select Breed',$breeders))); ?>
                        </div>

                        <div class="position-relative form-group" style="display: none;" id="new_ledger_litters_div">
                            <label for="exampleCustomSelect" class="">Litters*</label>
                            <!-- <input placeholder="default" type="text" class="mb-2 form-control" autocomplete="off" cursor: auto;"> -->
                            <?php echo $this->Form->control('litter_id',array('type'=>'select','id'=>'new_ledger_litter_id','label'=>false,'class'=>'multiselect-dropdown form-control','div'=>false,'options' => array(''=>'Select Breed',$litters))); ?>
                        </div>

                        <div class="position-relative form-group" style="display: none;" id="new_ledger_name_div">
                            <label for="exampleCustomSelect" class="">Name*</label>
                            <?php echo $this->Form->control('name',array('type'=>'text','id'=>'new_ledger_name','label'=>false,'class'=>'mb-2 form-control','div'=>false,'placeholder'=>'Name here...','autocomplete'=>'off')); ?>
                        </div>
                    </div>





                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Category*</label>
                            <?php echo $this->Form->control('cat_id',array('type'=>'select','id'=>'new_ledger_cat_id','label'=>false,'required'=>true,'class'=>'multiselect-dropdown form-control','div'=>false,'onChange'=>'categoryClicked(this.value)','options' => array(''=>'Select Category',$schedule_types))); ?>
                        </div>

                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Amount*</label>
                            <!-- <input placeholder="default" type="text" class="mb-2 form-control" autocomplete="off" cursor: auto;"> -->
                            <?php echo $this->Form->control('amount',array('type'=>'text','id'=>'new_ledger_amount','label'=>false,'required'=>true,'class'=>'mb-2 form-control','div'=>false,'placeholder'=>'Amount here...','autocomplete'=>'off')); ?>
                        </div>

                        <div class="position-relative form-group" style="display: none;" id="new_ledger_status_id_div">
                            <label for="exampleCustomSelect" class="">Status*</label>
                            <!-- <input placeholder="default" type="text" class="mb-2 form-control" autocomplete="off" cursor: auto;"> -->
                            <?php echo $this->Form->control('status_id',array('type'=>'select','id'=>'new_ledger_status_id','label'=>false,'class'=>'multiselect-dropdown form-control','div'=>false,'options' => array(''=>'Select Breed',$sold_butchered_statuses))); ?>
                        </div>


                </div>
        </div>
            </div>
            <!-- </form> -->
            <div class="modal-footer model-header-color">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="editBreederSubmit_Btn">Submit</button>
            </div>
        </div>
        </form>
    </div>
</div>