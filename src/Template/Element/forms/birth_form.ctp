<div class="row">                    
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Litter ID*</label>
                            <!-- <input placeholder="default" type="text" class="mb-2 form-control" autocomplete="off" cursor: auto;"> -->
                            <?php echo $this->Form->control('litter_id',array('type'=>'text','id'=>'birth_form_litter_id','label'=>false,'class'=>'mb-2 form-control','div'=>false,'placeholder'=>'Liter ID here...','required'=>true,'autocomplete'=>'off'));
                                echo $this->Form->control('soruce',array('type'=>'hidden','id'=>'soruce','value'=>'web'));
                             ?>
                        </div>

                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class=""># live kits</label>
                            <!-- <input placeholder="default" type="text" class="mb-2 form-control" autocomplete="off" cursor: auto;"> -->
                            <?php echo $this->Form->control('no_live_kits',array('type'=>'text','id'=>'birth_form_no_live_kits','label'=>false,'class'=>'mb-2 form-control','div'=>false,'placeholder'=>'No. of live kits here...','autocomplete'=>'off')); ?>
                        </div>

                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Total no. of kits</label>
                            <!-- <input placeholder="default" type="text" class="mb-2 form-control" autocomplete="off" cursor: auto;"> -->
                            <?php echo $this->Form->control('no_kits',array('type'=>'text','id'=>'birth_form_no_kits','label'=>false,'class'=>'mb-2 form-control','div'=>false,'placeholder'=>'Total no. of kits here...','autocomplete'=>'off')); ?>
                        </div>

                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Date of Birth</label>
                            <input type="date" id="birth_form_date_born" name="date_born" max="<?php echo date('Y-m-d'); ?>" class="mb-2 form-control">   
                        </div>

                    </div>





                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Schedule</label>
                            <?php echo $this->Form->control('plan_id',array('type'=>'select','id'=>'birth_form_plan_id','label'=>false,'class'=>'multiselect-dropdown form-control','div'=>false,'required'=>true,'options' => array(''=>'Select Schedule',$planes))); ?>
                        </div>

                        <div class="position-relative form-group">
                        <label for="exampleCustomSelect" class=""># Dead Kits</label>
                            <!-- <input placeholder="default" type="text" class="mb-2 form-control" autocomplete="off" cursor: auto;"> -->
                            <?php echo $this->Form->control('no_dead_kits',array('type'=>'text','id'=>'birth_form_no_dead_kits','label'=>false,'class'=>'mb-2 form-control','div'=>false,'placeholder'=>'No. of dead kits here...','autocomplete'=>'off')); ?>
                        </div>

                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Cage ID</label>
                            <!-- <input placeholder="default" type="text" class="mb-2 form-control" autocomplete="off" cursor: auto;"> -->
                            <?php echo $this->Form->control('cage',array('type'=>'text','id'=>'birth_form_cage','label'=>false,'class'=>'mb-2 form-control','div'=>false,'placeholder'=>'Cage ID here...','autocomplete'=>'off')); ?>
                        </div>

                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Date Bred</label>
                            <input type="date" id="birth_form_date_bred" name="date_bred" max="<?php echo date('Y-m-d'); ?>" class="mb-2 form-control">   
                        </div>


                    </div>
                </div>