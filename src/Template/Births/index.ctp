<div class="app-main__inner">
                        <div class="app-page-title">
                            <div class="page-title-wrapper">
                                <div class="page-title-heading">
                                    <div class="page-title-icon">
                                        <i class="pe-7s-smile icon-gradient bg-tempting-azure"></i>
                                    </div>
                                    <div>Births
                                        <div class="page-title-subheading">Mange and record all births from here.</div>
                                    </div>
                                </div>
                                <div class="page-title-actions">
                                    
                                    <div class="d-inline-block dropdown">
                                        <button type="button" aria-haspopup="true" aria-expanded="false" class="btn-shadow btn btn-info" data-toggle="modal" data-target="#recordBirthModal">
                                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                                <i class="fa fa-user-plus fa-w-20"></i>
                                            </span>
                                            Record a birth
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
                                        <th>Litter ID</th>
                                        <th>Plan</th>
                                        <th>Live kits</th>
                                        <th>Dead kits</th>
                                        <th>Total kits</th>
                                        <th>Cage</th>
                                        <th>Buck</th>
                                        <th>Doe</th>
                                        <th>Date Bred</th>
                                        <th>Date Kindle</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($data as $data){ 
                                        ?>
                                    <tr>
                                        <td><?php echo h($data->litter_id); ?></td>
                                        <td><?php echo h($planes[$data->plan_id]); ?></td>
                                        <td><?php echo h($data->no_live_kits); ?></td>
                                        <td><?php echo h($data->no_dead_kits); ?></td>
                                        <td><?php echo h($data->no_kits); ?></td>
                                        <td><?php echo h($data->cage); ?></td>
                                        <td><?php echo h($bucks2[$data->buck]); ?></td>
                                        <td><?php echo h($does2[$data->doe]); ?></td>
                                        <td><?php echo date('d M,Y', strtotime($data->date_bred)); ?></td>
                                        <td><?php echo date('d M,Y', strtotime($data->date_born)); ?></td>
                                        <th>
                                            <div class="mb-2 mr-2 btn-group">
                                                <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="dropdown-toggle-split dropdown-toggle btn btn-primary btn-sm">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right" style="">
                                                    <button type="button" tabindex="0" class="dropdown-item" data-toggle="modal" data-target="#editdBirthModal" onclick="editBirth(<?php echo h($data->id); ?>)"><li class="fa fa-edit" style="padding-right:5px;"></li> Edit</button>
                                                    

                                                    <?php echo $this->Html->link('<button type="button" tabindex="0" class="dropdown-item"><li class="fa fa-ban" style="padding-right:5px;"></li> Delete</button>',array('controller'=>'births','action'=>'deleteBirth',h($data->id)),array('escape'=>false,'confirm'=>'Are you sure?')); ?>
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                    <?php } ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Litter ID</th>
                                        <th>Plan</th>
                                        <th>Live kits</th>
                                        <th>Dead kits</th>
                                        <th>Total kits</th>
                                        <th>Cage</th>
                                        <th>Buck</th>
                                        <th>Doe</th>
                                        <th>Date Bred</th>
                                        <th>Date Kindle</th>
                                        <th></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>



