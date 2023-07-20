<div class="scrollbar-sidebar">
                    <div class="app-sidebar__inner">
                        <ul class="vertical-nav-menu">
                            <li class="app-sidebar__heading">Menu</li>
                            <li>
                                <!-- <a href="#"><i class="metismenu-icon pe-7s-home"></i>Dashboards</a> -->
                                <?php echo $this->Html->link('<i class="metismenu-icon pe-7s-home"></i>Dashboards',array('controller'=>'dashboard','action'=>'index'),array('escape'=>false)); ?>
                            </li>
                            <li  class="<?php if($this->request->getParam('controller') == 'Breeders'){echo 'mm-active';} ?>">
                                <a href="#">
                                    <i class="metismenu-icon pe-7s-piggy"></i>Breeders
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>
                                <ul>
                                    <li>
                                        <!-- <a href="index.html"  class="mm-active" ><i class="metismenu-icon"></i>Analytics</a> -->
                                        <?php echo $this->Html->link('<i class="metismenu-icon"></i>New Breeder',array('controller'=>'breeders','action'=>'new_breeder'),array('escape'=>false,'data-toggle'=>"modal",'data-target'=>"#newBreederModal")); ?>
                                    </li>
                                    <li>
                                        <!-- <a href="dashboards-commerce.html" ><i class="metismenu-icon"></i>Commerce</a> -->
                                        <?php echo $this->Html->link('<i class="metismenu-icon"></i>All Breeders',array('controller'=>'breeders','action'=>'index'),array('escape'=>false,'class'=>@$breeder_index_active)); ?>
                                    </li>
                                    <li>
                                        <!-- <a href="dashboards-commerce.html" ><i class="metismenu-icon"></i>Commerce</a> -->
                                        <?php echo $this->Html->link('<i class="metismenu-icon"></i>Bucks',array('controller'=>'breeders','action'=>'getBreedersBySex',2),array('escape'=>false,'class'=>@$buck_active)); ?>
                                    </li>
                                    <li>
                                        <!-- <a href="dashboards-commerce.html" ><i class="metismenu-icon"></i>Commerce</a> -->
                                        <?php echo $this->Html->link('<i class="metismenu-icon"></i>Does',array('controller'=>'breeders','action'=>'getBreedersBySex',1),array('escape'=>false,'class'=>@$doe_active)); ?>
                                    </li>
                                    <li>
                                        <!-- <a href="dashboards-commerce.html" ><i class="metismenu-icon"></i>Commerce</a> -->
                                        <?php echo $this->Html->link('<i class="metismenu-icon"></i>Sold',array('controller'=>'breeders','action'=>'getBreedersByStatus',4),array('escape'=>false,'class'=>@$sold_active)); ?>
                                    </li>
                                    <li>
                                        <!-- <a href="dashboards-commerce.html" ><i class="metismenu-icon"></i>Commerce</a> -->
                                        <?php echo $this->Html->link('<i class="metismenu-icon"></i>Butchered',array('controller'=>'breeders','action'=>'getBreedersByStatus',5),array('escape'=>false,'class'=>@$butchered_active)); ?>
                                    </li>
                                    <li>
                                        <!-- <a href="dashboards-commerce.html" ><i class="metismenu-icon"></i>Commerce</a> -->
                                        <?php echo $this->Html->link('<i class="metismenu-icon"></i>Died',array('controller'=>'breeders','action'=>'getBreedersByStatus',6),array('escape'=>false,'class'=>@$dead_active)); ?>
                                    </li>
                                    <li>
                                        <!-- <a href="dashboards-commerce.html" ><i class="metismenu-icon"></i>Commerce</a> -->
                                        <?php echo $this->Html->link('<i class="metismenu-icon"></i>Export Breeders',array('controller'=>'breeders','action'=>'exportBreeders'),array('escape'=>false)); ?>
                                    </li>
                                </ul>
                            </li>

                            <li  class="<?php if($this->request->getParam('controller') == 'Births'){echo 'mm-active';} ?>">
                                <a href="#">
                                    <i class="metismenu-icon pe-7s-smile"></i>Births
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>
                                <ul>
                                    <li>
                                        <!-- <a href="index.html"  class="mm-active" ><i class="metismenu-icon"></i>Analytics</a> -->
                                        <?php echo $this->Html->link('<i class="metismenu-icon"></i>Record a birth',array('controller'=>'births','action'=>'new_breeder'),array('escape'=>false,'data-toggle'=>"modal",'data-target'=>"#recordBirthModal")); ?>
                                    </li>
                                    <li>
                                        <!-- <a href="dashboards-commerce.html" ><i class="metismenu-icon"></i>Commerce</a> -->
                                        <?php echo $this->Html->link('<i class="metismenu-icon"></i>All Births',array('controller'=>'births','action'=>'index'),array('escape'=>false,'class'=>@$all_births_active)); ?>
                                    </li>
                                    
                                </ul>
                            </li>


                            <li  class="<?php if($this->request->getParam('controller') == 'Schedules'){echo 'mm-active';} ?>">
                                <a href="#">
                                    <i class="metismenu-icon pe-7s-date"></i>Schedules
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>
                                <ul>
                                    <li>
                                        <!-- <a href="index.html"  class="mm-active" ><i class="metismenu-icon"></i>Analytics</a> -->
                                        <?php echo $this->Html->link('<i class="metismenu-icon"></i>Add Breeding Schedule',array('controller'=>'schedules','action'=>'new_schedule'),array('escape'=>false,'data-toggle'=>"modal",'data-target'=>"#breederModal")); ?>
                                    </li>
                                    <li>
                                        <!-- <a href="dashboards-commerce.html" ><i class="metismenu-icon"></i>Commerce</a> -->
                                        <?php echo $this->Html->link('<i class="metismenu-icon"></i>All Schedules',array('controller'=>'schedules','action'=>'index','all'),array('escape'=>false,'class'=>@$schedule_all_active)); ?>
                                    </li>

                                    <li>
                                        <!-- <a href="dashboards-commerce.html" ><i class="metismenu-icon"></i>Commerce</a> -->
                                        <?php echo $this->Html->link('<i class="metismenu-icon"></i>Pending Schedules',array('controller'=>'schedules','action'=>'index','pending'),array('escape'=>false,'class'=>@$schedule_pending_active)); ?>
                                    </li>
                                    
                                </ul>
                            </li>



                            <li  class="<?php if($this->request->getParam('controller') == 'Tasks'){echo 'mm-active';} ?>">
                                <a href="#">
                                    <i class="metismenu-icon pe-7s-alarm"></i>Tasks
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>
                                <ul>
                                    <li>
                                        <!-- <a href="index.html"  class="mm-active" ><i class="metismenu-icon"></i>Analytics</a> -->
                                        <?php echo $this->Html->link('<i class="metismenu-icon"></i>New Task',array('controller'=>'tasks','action'=>'new_task'),array('escape'=>false,'data-toggle'=>"modal",'data-target'=>"#newTaskModal")); ?>
                                    </li>
                                    <li>
                                        <!-- <a href="dashboards-commerce.html" ><i class="metismenu-icon"></i>Commerce</a> -->
                                        <?php echo $this->Html->link('<i class="metismenu-icon"></i>All Tasks',array('controller'=>'tasks','action'=>'index','all'),array('escape'=>false,'class'=>@$task_all_active)); ?>
                                    </li>

                                    <li>
                                        <!-- <a href="dashboards-commerce.html" ><i class="metismenu-icon"></i>Commerce</a> -->
                                        <?php echo $this->Html->link('<i class="metismenu-icon"></i>Pending Tasks',array('controller'=>'tasks','action'=>'index','pending'),array('escape'=>false,'class'=>@$task_pending_active)); ?>
                                    </li>
                                    
                                </ul>
                            </li>

                            <li  class="<?php if($this->request->getParam('controller') == 'Ledgers'){echo 'mm-active';} ?>">
                                <a href="#">
                                    <i class="metismenu-icon pe-7s-graph2"></i>Income/Expense
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>
                                <ul>
                                    <li>
                                        <!-- <a href="index.html"  class="mm-active" ><i class="metismenu-icon"></i>Analytics</a> -->
                                        <?php echo $this->Html->link('<i class="metismenu-icon"></i>New Ledger',array('controller'=>'ledgers','action'=>'new_ledger'),array('escape'=>false,'data-toggle'=>"modal",'data-target'=>"#newLedgerModal")); ?>
                                    </li>
                                    <li>
                                        <!-- <a href="dashboards-commerce.html" ><i class="metismenu-icon"></i>Commerce</a> -->
                                        <?php echo $this->Html->link('<i class="metismenu-icon"></i>All Ledgers',array('controller'=>'ledgers','action'=>'index'),array('escape'=>false,'class'=>@$ledger_all_active)); ?>
                                    </li>

                                    <li>
                                        <!-- <a href="dashboards-commerce.html" ><i class="metismenu-icon"></i>Commerce</a> -->
                                        <?php echo $this->Html->link('<i class="metismenu-icon"></i>Income',array('controller'=>'ledgers','action'=>'index',1),array('escape'=>false,'class'=>@$income_active)); ?>
                                    </li>

                                    <li>
                                        <!-- <a href="dashboards-commerce.html" ><i class="metismenu-icon"></i>Commerce</a> -->
                                        <?php echo $this->Html->link('<i class="metismenu-icon"></i>Expenditure',array('controller'=>'ledgers','action'=>'index',2),array('escape'=>false,'class'=>@$expenditure_active)); ?>
                                    </li>
                                    
                                </ul>
                            </li>


                            <li  class="<?php if($this->request->getParam('controller') == 'Reports'){echo 'mm-active';} ?>">
                                <a href="#">
                                    <i class="metismenu-icon pe-7s-graph1"></i>Reports
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>
                                <ul>
                                    <li>
                                        <!-- <a href="dashboards-commerce.html" ><i class="metismenu-icon"></i>Commerce</a> -->
                                        <?php echo $this->Html->link('<i class="metismenu-icon"></i>Income/Espense',array('controller'=>'reports','action'=>'incomeEspense'),array('escape'=>false,'class'=>@$incomeEspense_active)); ?>
                                    </li>

                                    
                                </ul>
                            </li>

                            
                            <li  class="<?php if($this->request->getParam('controller') == 'Settings'){echo 'mm-active';} ?>">
                                <a href="#">
                                    <i class="metismenu-icon pe-7s-settings"></i>Settings
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>
                                <ul>
                                    <li>
                                        <!-- <a href="index.html"  class="mm-active" ><i class="metismenu-icon"></i>Analytics</a> -->
                                        <?php echo $this->Html->link('<i class="metismenu-icon"></i>Change Password',array('controller'=>'users','action'=>'changePassword'),array('escape'=>false,'data-toggle'=>"modal",'data-target'=>"#changePasswordModal")); ?>
                                    </li>
                                    <?php if($sess['usergroup_id'] == 2){ ?>
                                    <li>
                                        <!-- <a href="dashboards-commerce.html" ><i class="metismenu-icon"></i>Commerce</a> -->
                                        <?php echo $this->Html->link('<i class="metismenu-icon"></i>All Package Items',array('controller'=>'settings','action'=>'packageItems'),array('escape'=>false)); ?>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            
                            
                        </ul>
                    </div>
                </div>