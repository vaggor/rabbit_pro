<div class="app-main__inner">
                        <div class="app-page-title">
                            <div class="page-title-wrapper">
                                <div class="page-title-heading">
                                    <div class="page-title-icon">
                                        <i class="pe-7s-alarm icon-gradient bg-tempting-azure"></i>
                                    </div>
                                    <div><?php echo $title; ?>
                                        <div class="page-title-subheading">Mange all your tasks from here.</div>
                                    </div>
                                </div>
                                <div class="page-title-actions">
                                    
                                    <div class="d-inline-block dropdown">
                                        <button type="button" aria-haspopup="true" aria-expanded="false" class="btn-shadow btn btn-info" data-toggle="modal" data-target="#newTaskModal">
                                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                                <i class="fa fa-user-plus fa-w-20"></i>
                                            </span>
                                            New Task
                                        </button>
                                        
                                    </div>
                                </div>    </div>
                        </div>            
                        <center><?php echo $this->Flash->render(); ?></center>
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <?php echo $this->Form->create('User',array('url'=>'/tasks/multiple_delete','class'=>'')); ?>
                                <button type="submit" class="btn btn-primary" id="multipleDeleteSubmit_Btn" style="margin-bottom: 10px;">Delete selected items</button>
                                <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($data as $data){ 
                                        ?>
                                    <tr>
                                        <td>
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" name="delete[]" id="<?php echo h($data['id']); ?>" value="<?php echo h($data['id']); ?>" class="custom-control-input">
                                                <label class="custom-control-label" for="<?php echo h($data['id']); ?>">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td><?php echo h($data['name']); if(strtotime(date('Y-m-d')) > strtotime($data['date'])){ ?> <div class="badge badge-danger ml-2">Expired</div><?php } ?></td>
                                        <td><?php echo date('d M,Y', strtotime($data['date'])); ?></td>
                                        <td><?php echo h($data['schedule_type']); ?></td>
                                        <th>
                                            <div class="mb-2 mr-2 btn-group">
                                                <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="dropdown-toggle-split dropdown-toggle btn btn-primary btn-sm">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right" style="">
                                                    
                                                    <button type="button" tabindex="0" class="dropdown-item" data-toggle="modal" data-target="#editTaskModal" onclick="getTaskForEdit(<?php echo h($data['id']); ?>)"><li class="fa fa-edit" style="padding-right:5px;"></li> Edit</button>
                                                    

                                                    <?php echo $this->Html->link('<button type="button" tabindex="0" class="dropdown-item"><li class="fa fa-ban" style="padding-right:5px;"></li> Delete</button>',array('controller'=>'tasks','action'=>'deleteTask',h($data['id'])),array('escape'=>false,'confirm'=>'Are you sure?')); ?>
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                    <?php } ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th></th>
                                    </tr>
                                    </tfoot>
                                </table>
                                
                                </form>
                            </div>
                        </div>
                    </div>



