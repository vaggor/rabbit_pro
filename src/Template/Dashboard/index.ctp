<div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="pe-7s-car icon-gradient bg-mean-fruit"></i>
                                </div>
                                <div>Analytics Dashboard
                                    <div class="page-title-subheading">This is an example dashboard created using build-in elements and components.</div>
                                </div>
                            </div>
                                </div>
                    </div>        <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
                        <li class="nav-item">
							<?php echo $this->Html->link('<button class="mb-2 mr-2 btn-icon btn btn-primary"><i class="pe-7s-tools btn-icon-wrapper"> </i>New Breed</button>',array('controller'=>'breeds','action'=>'new_breed'),array('escape'=>false,'data-toggle'=>"modal",'data-target'=>"#newBreederModal")); ?>
                        </li>
                        <li class="nav-item">
                            <?php echo $this->Html->link('<button class="mb-2 mr-2 btn-icon btn btn-success"><i class="pe-7s-tools btn-icon-wrapper"> </i>New Breeding Plan</button>',array('controller'=>'breeds','action'=>'new_plan'),array('escape'=>false,'data-toggle'=>"modal",'data-target'=>"#breederModal")); ?>
                        </li>
						<li class="nav-item">
                            <?php echo $this->Html->link('<button class="mb-2 mr-2 btn-icon btn btn-warning"><i class="pe-7s-tools btn-icon-wrapper"> </i>Record a birth</button>',array('controller'=>'breeds','action'=>'new_plan'),array('escape'=>false,'data-toggle'=>"modal",'data-target'=>"#recordBirthModal")); ?>
                        </li>
                    </ul>
					<center><?php echo $this->Flash->render(); ?></center>
					<div class="card no-shadow bg-transparent no-border rm-borders mb-3">
                            <div class="card">
                                <div class="no-gutters row">
                                    <div class="col-md-12 col-lg-4">
                                        <ul class="list-group list-group-flush">
                                            <li class="bg-transparent list-group-item">
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-outer">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">Breeders</div>
                                                                <div class="widget-subheading">Total Breeders</div>
                                                            </div>
                                                            <div class="widget-content-right">
                                                                <div class="widget-numbers text-success"><?php echo $data['no_breeders']; ?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="bg-transparent list-group-item">
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-outer">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">Litters</div>
                                                                <div class="widget-subheading">Total Litters</div>
                                                            </div>
                                                            <div class="widget-content-right">
                                                                <div class="widget-numbers text-primary"><?php echo $data['no_litters']; ?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-12 col-lg-4">
                                        <ul class="list-group list-group-flush">
                                            <li class="bg-transparent list-group-item">
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-outer">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">Bucks</div>
                                                                <div class="widget-subheading">Total Bucks</div>
                                                            </div>
                                                            <div class="widget-content-right">
                                                                <div class="widget-numbers text-danger"><?php echo $data['no_bucks']; ?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="bg-transparent list-group-item">
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-outer">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">Mortality</div>
                                                                <div class="widget-subheading">Mortality Rate</div>
                                                            </div>
                                                            <div class="widget-content-right">
                                                                <div class="widget-numbers text-warning"><?php echo $data['mortality_rate']; ?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-12 col-lg-4">
                                        <ul class="list-group list-group-flush">
                                            <li class="bg-transparent list-group-item">
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-outer">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">Does</div>
                                                                <div class="widget-subheading">Total Does</div>
                                                            </div>
                                                            <div class="widget-content-right">
                                                                <div class="widget-numbers text-success"><?php echo $data['no_does']; ?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="bg-transparent list-group-item">
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-outer">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading">Profit/Loss</div>
                                                                <div class="widget-subheading">PnL for <?php echo date('M'); ?></div>
                                                            </div>
                                                            <div class="widget-content-right">
                                                                <div class="widget-numbers text-primary"><?php echo $data['pnl']['profit_loss']; ?></div>
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
					
                    <div class="tabs-animation">
                      <div class="row">
                            <div class="col-sm-12 col-lg-6">
                                <div class="card-hover-shadow-2x mb-3 card">
                                    <div class="card-header-tab card-header">
                                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                            <i class="header-icon lnr-database icon-gradient bg-malibu-beach"> </i>Tasks List
                                        </div>
                                        
                                    </div>
                                    <div class="scroll-area-lg">
                                        <div class="scrollbar-container">
                                            <div class="p-2">
                                                <?php echo $this->Form->create('User',array('url'=>'/tasks/multiple_delete','class'=>'')); ?>
                                                <ul class="todo-list-wrapper list-group list-group-flush">
                                                    
                                                    <?php 
                                                    $i = 0;
                                                    foreach($task_data as $task_data){ 
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
                                                                    <div class="custom-checkbox custom-control">
                                                                        <input type="checkbox" name="delete[]" id="<?php echo h($task_data['id']); ?>" value="<?php echo h($task_data['id']); ?>" class="custom-control-input">
                                                                        <label class="custom-control-label" for="<?php echo h($task_data['id']); ?>">&nbsp;</label>
                                                                    </div>
                                                                </div>
                                                                <div class="widget-content-left">
                                                                    <div class="widget-heading"><?php echo h($task_data['name']); ?>
                                                                        <div class="badge badge-danger ml-2"><?php if(strtotime(date('Y-m-d')) > strtotime($task_data['date'])){ ?> <div class="badge badge-danger ml-2">Expired</div><?php } ?></div>
                                                                    </div>
                                                                    <div class="widget-subheading">
                                                                        <div><?php echo date('d M,Y', strtotime($task_data['date'])); ?></div>
                                                                    </div>
                                                                </div>
                                                                <div class="widget-content-right widget-content-actions1">
                                                                    <div class="mb-2 mr-2 btn-group">
                                                                        <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="dropdown-toggle-split dropdown-toggle btn btn-primary btn-sm">
                                                                            <span class="sr-only">Toggle Dropdown</span>
                                                                        </button>
                                                                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right" style="">
                                                                            
                                                                            <button type="button" tabindex="0" class="dropdown-item" data-toggle="modal" data-target="#editTaskModal" onclick="getTaskForEdit(<?php echo h($task_data['id']); ?>)"><li class="fa fa-edit" style="padding-right:5px;"></li> Edit</button>
                                                                            

                                                                            <?php echo $this->Html->link('<button type="button" tabindex="0" class="dropdown-item"><li class="fa fa-ban" style="padding-right:5px;"></li> Delete</button>',array('controller'=>'tasks','action'=>'deleteTask',h($task_data['id'])),array('escape'=>false,'confirm'=>'Are you sure?')); ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-block text-right card-footer">
                                        <!-- <button class="mr-2 btn btn-link btn-sm">Cancel</button> -->
                                        <button class="btn btn-primary">Multiple Delete</button>
                                    </div>
                                </div>
                            </div>
                            </form>
                            <div class="col-sm-12 col-lg-6">
                                <div class="card-hover-shadow-2x mb-3 card">
                                    <div class="card-header-tab card-header">
                                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                            <i class="header-icon lnr-lighter icon-gradient bg-amy-crisp"></i>
                                            Pending Breeding Plans
                                        </div>
                                        
                                    </div>
                                    <div class="scroll-area-lg">
                                        <div class="scrollbar-container">
                                            <div class="p-4">
                                                <div
                                                    class="vertical-time-simple vertical-without-time vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                                                    <?php 
                                                    $i = 0;
                                                    foreach($plans_data as $plans_data){ 
                                                        $mod = $i%2;
                                                        if($mod == 0){
                                                            $class = 'dot-warning';
                                                        }
                                                        else{
                                                            $class = 'dot-success';
                                                        }
                                                    ?>
                                                    <div class="vertical-timeline-item <?php echo $class; ?> vertical-timeline-element">
                                                        <div>
                                                            <span class="vertical-timeline-element-icon bounce-in"></span>
                                                            <div class="vertical-timeline-element-content bounce-in">
                                                                <p><?php echo h($plans_data['name']); ?> </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-block text-center card-footer">
                                        <?php echo $this->Html->link('<button class="btn-shadow btn-wide btn-pill btn btn-focus">
                                            <span class="badge badge-dot badge-dot-lg badge-warning badge-pulse">Badge</span>
                                            View All Plans
                                        </button>',array('controller'=>'schedules','action'=>'index','all'),array('escape'=>false)); ?>
                                        
                                    </div>
                                </div>
                            </div>
                      </div>
                        <div class="row">
                          <div class="col-md-6 col-xl-3"></div>
                            <div class="col-md-6 col-xl-3"></div>
                            <div class="col-md-6 col-xl-3"></div>
                            <div class="col-md-6 col-xl-3"></div>
                        </div>
                        
  </div>
                </div>