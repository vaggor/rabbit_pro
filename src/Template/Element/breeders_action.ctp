<?php if($this->request->getParam('action') == 'index'){ ?>
<div class="mb-2 mr-2 btn-group">
                                                <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="dropdown-toggle-split dropdown-toggle btn btn-primary btn-sm">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right" style="">
                                                    <button type="button" tabindex="0" class="dropdown-item" data-toggle="modal" data-target="#editBreederModal" onclick="getBreederDetail(<?php echo h($data->id); ?>)"><li class="fa fa-edit" style="padding-right:5px;"></li> Edit</button>
                                                    
                                                    <?php echo $this->Html->link('<button type="button" tabindex="0" class="dropdown-item"><li class="fa fa-print" style="padding-right:5px;"></li> Print Cage Card</button>',array('controller'=>'breeders','action'=>'edit'),array('escape'=>false)); ?>

                                                    <button type="button" tabindex="0" class="dropdown-item" data-toggle="modal" data-target="#breederModal" onclick="getRabbitNameAndSex(<?php echo h($data->id); ?>)"><li class="fa fa-mercury" style="padding-right:5px;"></li> Breed</button>

                                                    <button type="button" tabindex="0" class="dropdown-item" data-toggle="modal" data-target="#recordBirthModal"><li class="fa fa-paw" style="padding-right:5px;"></li> Record Birth</button>

                                                    <button type="button" tabindex="0" class="dropdown-item" data-toggle="modal" data-target="#sellBreederModal" onclick="setBreederIdOnSellForm(<?php echo h($data->id); ?>,4)"><li class="fa fa-shopping-cart" style="padding-right:5px;"></li> Sell</button>

                                                    <button type="button" tabindex="0" class="dropdown-item" data-toggle="modal" data-target="#sellBreederModal" onclick="setBreederIdOnSellForm(<?php echo h($data->id); ?>,5)"><li class="fa fa-fire" style="padding-right:5px;"></li> Butcher</button>

                                                    <button type="button" tabindex="0" class="dropdown-item" data-toggle="modal" data-target="#deadBreederModal" onclick="setIdForDeadBreederForm(<?php echo h($data->id); ?>)"><li class="fa fa-heartbeat" style="padding-right:5px;"></li> Died</button>

                                                    <?php echo $this->Html->link('<button type="button" tabindex="0" class="dropdown-item"><li class="fa fa-ban" style="padding-right:5px;"></li> Delete</button>',array('controller'=>'breeders','action'=>'deleteBreeder',h($data->id)),array('escape'=>false,'confirm'=>'Are you sure?')); ?>
                                                </div>
                                            </div>



<?php }else{ ?>
<div class="mb-2 mr-2 btn-group">
                                                <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="dropdown-toggle-split dropdown-toggle btn btn-primary btn-sm">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right" style="">
                                                    <button type="button" tabindex="0" class="dropdown-item" data-toggle="modal" data-target="#editBreederModal" onclick="getBreederDetail(<?php echo h($data['id']); ?>)"><li class="fa fa-edit" style="padding-right:5px;"></li> Edit</button>
                                                    
                                                    <?php echo $this->Html->link('<button type="button" tabindex="0" class="dropdown-item"><li class="fa fa-print" style="padding-right:5px;"></li> Print Cage Card</button>',array('controller'=>'breeders','action'=>'edit'),array('escape'=>false)); ?>

                                                    <button type="button" tabindex="0" class="dropdown-item" data-toggle="modal" data-target="#breederModal" onclick="getRabbitNameAndSex(<?php echo h($data['id']); ?>)"><li class="fa fa-mercury" style="padding-right:5px;"></li> Breed</button>

                                                    <button type="button" tabindex="0" class="dropdown-item" data-toggle="modal" data-target="#recordBirthModal"><li class="fa fa-paw" style="padding-right:5px;"></li> Record Birth</button>

                                                    <button type="button" tabindex="0" class="dropdown-item" data-toggle="modal" data-target="#sellBreederModal" onclick="setBreederIdOnSellForm(<?php echo h($data['id']); ?>,4)"><li class="fa fa-shopping-cart" style="padding-right:5px;"></li> Sell</button>

                                                    <button type="button" tabindex="0" class="dropdown-item" data-toggle="modal" data-target="#sellBreederModal" onclick="setBreederIdOnSellForm(<?php echo h($data['id']); ?>,5)"><li class="fa fa-fire" style="padding-right:5px;"></li> Butcher</button>

                                                    <button type="button" tabindex="0" class="dropdown-item" data-toggle="modal" data-target="#deadBreederModal" onclick="setIdForDeadBreederForm(<?php echo h($data['id']); ?>)"><li class="fa fa-heartbeat" style="padding-right:5px;"></li> Died</button>

                                                    <?php echo $this->Html->link('<button type="button" tabindex="0" class="dropdown-item"><li class="fa fa-ban" style="padding-right:5px;"></li> Delete</button>',array('controller'=>'breeders','action'=>'deleteBreeder',h($data->id)),array('escape'=>false,'confirm'=>'Are you sure?')); ?>
                                                </div>
                                            </div>
<?php } ?>