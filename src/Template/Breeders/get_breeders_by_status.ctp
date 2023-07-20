<div class="app-main__inner">
                        <div class="app-page-title">
                            <div class="page-title-wrapper">
                                <div class="page-title-heading">
                                    <div class="page-title-icon">
                                        <i class="pe-7s-piggy icon-gradient bg-tempting-azure"></i>
                                    </div>
                                    <div><?php echo $title; ?>
                                        <div class="page-title-subheading">Mange your breeding stock from here.</div>
                                    </div>
                                </div>
                                <div class="page-title-actions">
                                    
                                    <div class="d-inline-block dropdown">
                                        <button type="button" aria-haspopup="true" aria-expanded="false" class="btn-shadow btn btn-info" data-toggle="modal" data-target="#newBreederModal">
                                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                                <i class="fa fa-user-plus fa-w-20"></i>
                                            </span>
                                            New Breeder
                                        </button>
                                        
                                    </div>
                                </div>    </div>
                        </div>            
                        <center><?php echo $this->Flash->render(); ?></center>
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>ID</th>
                                        <th>Cage</th>
                                        <th>Age</th>
                                        <th>Litters</th>
                                        <th>Kits</th>
                                        <th>Weight</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($data as $data){ 
                                        $age = $this->cell('Others::age', [$data['date_born']]);
                                        $no_litters = $this->cell('Others::get_no_of_liters', [$data['sex_id'],$data['id']]);
                                        $no_kits = $this->cell('Others::get_no_of_kits', [$data['sex_id'],$data['id']]);
                                        $weight = $this->cell('Others::get_latest_weight', [$data['id']]);
                                        ?>
                                    <tr>
                                        <td><?php echo h($data['name']); ?></td>
                                        <td><?php echo h($data['breeder_id']); ?></td>
                                        <td><?php echo h($data['cage']); ?></td>
                                        <td><?php echo $age; ?></td>
                                        <td><?php echo $no_litters; ?></td>
                                        <td><?php echo $no_kits; ?></td>
                                        <td><?php echo $weight; ?></td>
                                        <th>
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

                                                    <?php echo $this->Html->link('<button type="button" tabindex="0" class="dropdown-item"><li class="fa fa-ban" style="padding-right:5px;"></li> Delete</button>',array('controller'=>'breeders','action'=>'deleteBreeder',h($data['id'])),array('escape'=>false,'confirm'=>'Are you sure?')); ?>
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                    <?php } ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>ID</th>
                                        <th>Cage</th>
                                        <th>Age</th>
                                        <th>Litters</th>
                                        <th>Kits</th>
                                        <th>Weight</th>
                                        <th></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>



