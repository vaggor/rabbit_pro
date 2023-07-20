<div class="app-main__inner">
                        <div class="app-page-title">
                            <div class="page-title-wrapper">
                                <div class="page-title-heading">
                                    <div class="page-title-icon">
                                        <i class="pe-7s-settings icon-gradient bg-tempting-azure"></i>
                                    </div>
                                    <div>Package Items
                                        <div class="page-title-subheading">Mange your your package items from here.</div>
                                    </div>
                                </div>
                                <div class="page-title-actions">
                                    
                                    <div class="d-inline-block dropdown">
                                        <button type="button" aria-haspopup="true" aria-expanded="false" class="btn-shadow btn btn-info" data-toggle="modal" data-target="#newPackageItemModal">
                                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                                <i class="fa fa-user-plus fa-w-20"></i>
                                            </span>
                                            New Item
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
                                        <th>Package</th>
                                        <th>Quantity</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($data as $data){ ?>
                                    <tr>
                                        <td><?php echo h($data->name); ?></td>
                                        <td><?php echo h($list_packages[$data->package_id]); ?></td>
                                        <td><?php echo h($data->quantity); ?></td>
                                        <th>
                                            <div class="mb-2 mr-2 btn-group">
                                                <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="dropdown-toggle-split dropdown-toggle btn btn-primary btn-sm">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right" style="">
                                                    <?php //echo $this->Html->link('<button type="button" tabindex="0" class="dropdown-item"><li class="fa fa-edit" style="padding-right:5px;"></li> Edit</button>',array('controller'=>'settings','action'=>'editPackageItem',$data->id),array('escape'=>false,"data-toggle"=>"modal", "data-target"=>"#editPackageItemModal")); ?>

                                                    <button type="button" tabindex="0" class="dropdown-item" data-toggle="modal" data-target="#editPackageItemModal" onclick="editPackageItem(<?php echo h($data->id); ?>)"><li class="fa fa-edit" style="padding-right:5px;"></li> Edit</button>
                                                    

                                                    <?php echo $this->Html->link('<button type="button" tabindex="0" class="dropdown-item"><li class="fa fa-ban" style="padding-right:5px;"></li> Delete</button>',array('controller'=>'settings','action'=>'deletePackageItem',$data->id),array('escape'=>false)); ?>
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                    <?php } ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Package</th>
                                        <th>Quantity</th>
                                        <th></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>



