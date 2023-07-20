<div class="row">                    
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Name*</label>
                            <!-- <input placeholder="default" type="text" class="mb-2 form-control" autocomplete="off" cursor: auto;"> -->
                            <?php echo $this->Form->control('name',array('type'=>'text','id'=>'name','label'=>false,'class'=>'mb-2 form-control','div'=>false,'placeholder'=>'Name here...','required'=>true,'autocomplete'=>'off'));
                             ?>
                        </div>

                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Package</label>
                            <?php echo $this->Form->control('package_id',array('type'=>'select','id'=>'package_id','label'=>false,'class'=>'multiselect-dropdown form-control','div'=>false,'options' => array(''=>'Select Father',$list_packages))); ?>
                        </div>
                    </div>





                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Quantity</label>
                            <!-- <input placeholder="default" type="text" class="mb-2 form-control" autocomplete="off" cursor: auto;"> -->
                            <?php echo $this->Form->control('quantity',array('type'=>'text','id'=>'quantity','label'=>false,'class'=>'mb-2 form-control','div'=>false,'placeholder'=>'Quantity here...','autocomplete'=>'off')); ?>
                        </div>

                </div>
        </div>
            </div>
            