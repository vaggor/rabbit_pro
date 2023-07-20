<div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="lnr-map text-info"></i>
                                </div>
                                <div>Details of Rabbit
                                    <div class="page-title-subheading">View all details of rabbit here</div>
                                </div>
                            </div>
                                </div>
                    </div>        <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
                        <li class="nav-item">
                            <button class="mb-2 mr-2 btn btn-primary active" data-toggle="modal" data-target="#editBreederModal" onclick="getBreederDetail(<?php echo h($id); ?>)"><li class="fa fa-edit" style="padding-right:5px;"></li>Edit</button>
                        </li>
                        <li class="nav-item">
                            <?php echo $this->Html->link('<button class="mb-2 mr-2 btn btn-warning active"><li class="fa fa-print" style="padding-right:5px;"></li>Print Cage Card</button>',array('controller'=>'breeders','action'=>'print_cage_card',h($id)),array('escape'=>false,'target'=>'_blank')); ?>
                        </li>
                        <li class="nav-item">
                            <button class="mb-2 mr-2 btn btn-success active" data-toggle="modal" data-target="#breederModal" onclick="getRabbitNameAndSex(<?php echo h($id); ?>)"><li class="fa fa-mercury" style="padding-right:5px;"></li> Breed</button>
                        </li>

                        <li class="nav-item">
                            <button class="mb-2 mr-2 btn btn-danger active" data-toggle="modal" data-target="#newWeightModal" onclick="setBreederIdForWeight(<?php echo h($id); ?>)"><li class="fa fa-balance-scale" style="padding-right:5px;"></li> Record weight</button>
                        </li>

                        <li class="nav-item">
                            <button class="mb-2 mr-2 btn btn-secondary active" data-toggle="modal" data-target="#recordBirthModal"><li class="fa fa-paw" style="padding-right:5px;"></li> Record Birth</button>
                        </li>

                        <li class="nav-item">
                            <button class="mb-2 mr-2 btn btn-info active" data-toggle="modal" data-target="#sellBreederModal" onclick="setBreederIdOnSellForm(<?php echo h($id); ?>,4)"><li class="fa fa-shopping-cart" style="padding-right:5px;"></li> Sell</button>
                        </li>

                        <li class="nav-item">
                            <button class="mb-2 mr-2 btn btn-danger active" data-toggle="modal" data-target="#sellBreederModal" onclick="setBreederIdOnSellForm(<?php echo h($id); ?>,5)"><li class="fa fa-fire" style="padding-right:5px;"></li> Butcher</button>
                        </li>

                        <li class="nav-item">
                            <button class="mb-2 mr-2 btn btn-light active" data-toggle="modal" data-target="#deadBreederModal" onclick="setIdForDeadBreederForm(<?php echo h($id); ?>)"><li class="fa fa-heartbeat" style="padding-right:5px;"></li> Died</button>
                        </li>

                        <li class="nav-item">
                            <?php echo $this->Html->link('<button class="mb-2 mr-2 btn btn-focus active"><li class="fa fa-ban" style="padding-right:5px;"></li> Delete</button>',array('controller'=>'breeders','action'=>'deleteBreeder',h($id)),array('escape'=>false,'confirm'=>'Are you sure?')); ?>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane tabs-animation fade active show" id="tab-content-0" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-8 col-md-12">
                                    <div class="main-card mb-3 card">
                                        <div class="card-body">
                                            
                                            <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Weight</th>
                                        <th>Date</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($data as $data){ 
                                        ?>
                                    <tr>
                                        <td><?php echo h($data['weight'].' '.$data['unit_name']); ?></td>
                                        <td><?php echo h(date('d M,Y', strtotime($data['date_weighed']))); ?></td>
                                        <th>
                                            <?php echo $this->Html->link('<button type="button" tabindex="0" class="dropdown-item"><li class="fa fa-trash" style="padding-right:5px;"></li> </button>',array('controller'=>'breeders','action'=>'deleteWeight',h($data['id'])),array('escape'=>false,'confirm'=>'Are you sure?')); ?>
                                        </th>
                                    </tr>
                                    <?php } ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                       <th>Weight</th>
                                        <th>Date</th>
                                        <th></th>
                                    </tr>
                                    </tfoot>
                                </table>

                                        </div>
                                    </div>
                                </div>








                                <div class="col-md-12 col-lg-4">
                                    <div class="card-shadow-primary card-border mb-3 card">
                                <div class="dropdown-menu-header">
                                    <div class="dropdown-menu-header-inner bg-dark">
                                        <div class="menu-header-content">
                                            <div class="avatar-icon-wrapper mb-3 avatar-icon-xl">
                                                <div class="avatar-icon">
                                                    <?php echo $this->Html->image('images/rabbit.jpg',array('alt'=>'Avatar')) ?>
                                                </div>
                                            </div>
                                            <div>
                                                <h5 class="menu-header-title"><?php echo $resp['name']; ?></h5>
                                                <h6 class="menu-header-subtitle">ID: <?php echo $resp['breeder_id']; ?></h6>
                                            </div>
                                            <div class="menu-header-btn-pane pt-1">
                                                <?php echo $this->Html->link('<button class="btn-icon btn btn-warning btn-sm"><li class="fa fa-print" style="padding-right:5px;"></li>Print Cage Card</button>',array('controller'=>'breeders','action'=>'print_cage_card',h($id)),array('escape'=>false,'target'=>'_blank')); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-3">
                                    <h6 class="text-muted text-uppercase font-size-md opacity-5 font-weight-normal">Detaild</h6>
                                    <ul class="rm-list-borders list-group list-group-flush">
                                        <li class="list-group-item">
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <img width="42" class="rounded-circle" src="assets/images/avatars/5.jpg" alt="">
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">Cage ID</div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <div class="font-size-xlg text-muted">
                                                            <span><?php echo $resp['cage']; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <img width="42" class="rounded-circle" src="assets/images/avatars/4.jpg" alt="">
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">Color</div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <div class="font-size-xlg text-muted">
                                                            <span><?php echo $resp['color']; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <img width="42" class="rounded-circle" src="assets/images/avatars/2.jpg" alt="">
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">Breed</div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <div class="font-size-xlg text-muted">
                                                            <span><?php echo $resp['breed_name']; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <img width="42" class="rounded-circle" src="assets/images/avatars/3.jpg" alt="">
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">Sex</div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <div class="font-size-xlg text-muted">
                                                            <span><?php echo $resp['sex_name']; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>

                                        <li class="list-group-item">
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <img width="42" class="rounded-circle" src="assets/images/avatars/2.jpg" alt="">
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">Date of Birth</div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <div class="font-size-xlg text-muted">
                                                            <span><?php echo date('d M,Y',strtotime($resp['date_born'])); ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>

                                        <li class="list-group-item">
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <img width="42" class="rounded-circle" src="assets/images/avatars/2.jpg" alt="">
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">Date Aquired</div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <div class="font-size-xlg text-muted">
                                                            <span><?php echo date('d M,Y',strtotime($resp['date_acquired'])); ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>

                                        <li class="list-group-item">
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <img width="42" class="rounded-circle" src="assets/images/avatars/2.jpg" alt="">
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">Father</div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <div class="font-size-xlg text-muted">
                                                            <span><?php echo $resp['father_name']; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>

                                        <li class="list-group-item">
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left mr-3">
                                                        <img width="42" class="rounded-circle" src="assets/images/avatars/2.jpg" alt="">
                                                    </div>
                                                    <div class="widget-content-left">
                                                        <div class="widget-heading">Mother</div>
                                                    </div>
                                                    <div class="widget-content-right">
                                                        <div class="font-size-xlg text-muted">
                                                            <span><?php echo $resp['mother_name']; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                              
                            </div>
                                </div>
                            </div>
                        </div>
                        
                       
                    </div>
                </div>