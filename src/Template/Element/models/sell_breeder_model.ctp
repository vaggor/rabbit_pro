
<!-- Modal -->
<div class="modal fade" id="sellBreederModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header model-header-color">
                <h5 class="modal-title" id="sellModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <?php echo $this->Form->create('User',array('url'=>'/breeders/sellBreeder','class'=>'','id'=>'sellBreederForm')); ?>
                <div class="row">                    
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Amount*</label>
                            <!-- <input placeholder="default" type="text" class="mb-2 form-control" autocomplete="off" cursor: auto;"> -->
                            <?php echo $this->Form->control('amount',array('type'=>'text','id'=>'amount','label'=>false,'class'=>'mb-2 form-control','div'=>false,'placeholder'=>'Amount here...','required'=>true,'autocomplete'=>'off'));
                                echo $this->Form->control('soruce',array('type'=>'hidden','id'=>'soruce','value'=>'web'));
                                echo $this->Form->control('breeder_id',array('type'=>'hidden','id'=>'sellBreeder_breeder_id'));
                                echo $this->Form->control('status_id',array('type'=>'hidden','id'=>'sellBreeder_status_id'));
                                echo $this->Form->control('date',array('type'=>'hidden','id'=>'date','value'=>date('Y-m-d')));
                                echo $this->Form->control('cat_id',array('type'=>'hidden','id'=>'soruce','value'=>2));
                                echo $this->Form->control('ledger_type_id',array('type'=>'hidden','id'=>'ledger_type_id','value'=>1));
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