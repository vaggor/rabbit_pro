
<!-- Modal -->
<div class="modal fade" id="editBreedPlanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header model-header-color">
                <h5 class="modal-title" id="exampleModalLabel">Edit Breed Plan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <?php echo $this->Form->create('User',array('url'=>'/schedules/editSchedule','class'=>'','id'=>'breedForm')); ?>
                <div class="row">                    
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Buck*</label>
                            <!-- <input placeholder="default" type="text" class="mb-2 form-control" autocomplete="off" cursor: auto;"> -->
                            <?php echo $this->Form->control('buck',array('type'=>'select','id'=>'edit_breed_buck','label'=>false,'class'=>'multiselect-dropdown form-control','div'=>false,'required'=>true,'options' => array(''=>'Select Buck',$bucks)));
                                echo $this->Form->control('soruce',array('type'=>'hidden','id'=>'soruce','value'=>'web'));
                                echo $this->Form->control('id',array('type'=>'hidden','id'=>'edit_breed_model_id'));
                             ?>
                        </div>

                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Date*</label>
                            <input type="date" id="edit_breed_model_date" name="date" class="mb-2 form-control" onfocusout="getTaskDates('edit')" 'required'>   
                        </div>

                    </div>





                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Doe*</label>
                            <!-- <input placeholder="default" type="text" class="mb-2 form-control" autocomplete="off" cursor: auto;"> -->
                            <?php echo $this->Form->control('doe',array('type'=>'select','id'=>'edit_breed_doe','label'=>false,'class'=>'multiselect-dropdown form-control','div'=>false,'required'=>true,'options' => array(''=>'Select Doe',$does))); ?>
                        </div>


                </div>
        </div>

        <div>
                                <div class="card-hover-shadow-2x mb-3 card">
                                    <div class="card-header-tab card-header">
                                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                            <i class="header-icon lnr-database icon-gradient bg-malibu-beach"> </i>Tasks List
                                        </div>
                                        
                                    </div>
                                    <div class="scroll-area-lg">
                                        <div class="scrollbar-container">
                                            <div class="p-2">
                                                <ul class="todo-list-wrapper list-group list-group-flush">
                                                    <?php 
                                                    $i = 0;
                                                    foreach($default_tasks as $default_task){ 
                                                        $mod = $i%2;
                                                        if($mod == 0){
                                                            $class = 'bg-warning';
                                                        }
                                                        else{
                                                            $class = 'bg-primary';
                                                        }
                                                    ?>
                                                    <li class="list-group-item">
                                                        <div class="todo-indicator <?php echo $class; ?>"></div>
                                                        <div class="widget-content p-0">
                                                            <div class="widget-content-wrapper">
                                                                <div class="widget-content-left mr-2">
                                                                    <!-- <div class="custom-checkbox custom-control">
                                                                        <input type="checkbox" id="exampleCustomCheckbox12" class="custom-control-input">
                                                                        <label class="custom-control-label" for="exampleCustomCheckbox12">&nbsp;</label>
                                                                    </div> -->
                                                                </div>
                                                                <div class="widget-content-left">
                                                                    <div class="widget-heading"><?php echo h($default_task->name); ?>
                                                                        <!-- <div class="badge badge-danger ml-2">Rejected</div> -->
                                                                    </div>
                                                                    <div class="widget-subheading"><i id="edit_breed_model_task_date_<?php echo $default_task->id; ?>"></i>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <?php $i++;} ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                   
                                </div>
                            </div>
            </div>
            <!-- </form> -->
            <div class="modal-footer model-header-color">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CLose</button>
                <button type="submit" class="btn btn-primary" id="newBreederSubmit_Btn">Submit</button>
            </div>
        </div>
        </form>
    </div>
</div>