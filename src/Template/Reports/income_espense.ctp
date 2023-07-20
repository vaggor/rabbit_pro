<div class="app-main__inner">
                        <div class="app-page-title">
                            <div class="page-title-wrapper">
                                <div class="page-title-heading">
                                    <div class="page-title-icon">
                                        <i class="pe-7s-graph1 icon-gradient bg-tempting-azure"></i>
                                    </div>
                                    <div><?php echo $title; ?>
                                        <div class="page-title-subheading">Run all Income and Espense report from here</b> from here.</div>
                                    </div>
                                </div>
                                <div class="page-title-actions">
                                    
                                    
                                </div>    </div>
                        </div>  



                        <div class="tab-content">
                        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                    <?php echo $this->Form->create('User',array('url'=>'/reports/incomeEspense','class'=>'','id'=>'editBreederForm')); ?>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="exampleEmail11" class="">Date From</label>
                                                    <input type="date" id="date_from" name="date_from" class="mb-2 form-control" required="required">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="examplePassword11" class="">Date To</label>
                                                    <input type="date" id="date_to" name="date_to" class="mb-2 form-control" required="required">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="exampleEmail11" class="">Category</label>
                                                    <?php echo $this->Form->control('cat_id',array('type'=>'select','id'=>'ledger_cat_id','label'=>false,'class'=>'multiselect-dropdown form-control','div'=>false,'options' => array(''=>'Select Category',$schedule_types))); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="examplePassword11" class="">Type</label>
                                                    <?php echo $this->Form->control('ledger_type_id',array('type'=>'select','id'=>'ledger_type','label'=>false,'class'=>'multiselect-dropdown form-control','div'=>false,'options' => array(''=>'Select Type',$ledger_types))); ?>
                                                </div>
                                            </div>
                                        </div>

                                       
                                        <button type="sunbmit" class="mt-2 btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                            
                        </div>
                    </div>



                        <div class="mb-3 card">
                            <div class="card-header-tab card-header">
                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                    <i class="header-icon lnr-charts icon-gradient bg-happy-green"> </i>
                                    Profit/Loss
                                </div>
                                
                            </div>
                            <div class="no-gutters row">
                                <div class="col-sm-6 col-md-4 col-xl-4">
                                    <div class="card no-shadow rm-border bg-transparent widget-chart text-left">
                                        <div class="icon-wrapper rounded-circle">
                                            <div class="icon-wrapper-bg opacity-10 bg-warning"></div>
                                            <i class="lnr-laptop-phone text-dark opacity-8"></i>
                                        </div>
                                        <div class="widget-chart-content">
                                            <div class="widget-subheading">Income</div>
                                            <div class="widget-numbers"><?php echo $resp['stats']['income']; ?></div>
                                            <!-- <div class="widget-description opacity-8 text-focus">
                                                <div class="d-inline text-info pr-1">
                                                    <span class="pl-1"><?php //echo date('M'); ?></span>
                                                </div>
                                                 earnings
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="divider m-0 d-md-none d-sm-block"></div>
                                </div>
                                <div class="col-sm-6 col-md-4 col-xl-4">
                                    <div class="card no-shadow rm-border bg-transparent widget-chart text-left">
                                        <div class="icon-wrapper rounded-circle">
                                            <div class="icon-wrapper-bg opacity-9 bg-danger"></div>
                                            <i class="lnr-graduation-hat text-white"></i>
                                        </div>
                                        <div class="widget-chart-content">
                                            <div class="widget-subheading">Expense</div>
                                            <div class="widget-numbers"><span><?php echo $resp['stats']['expense']; ?></span></div>
                                            <!-- <div class="widget-description opacity-8 text-focus">
                                                <div class="d-inline text-danger pr-1">
                                                    <span class="pl-1"><?php echo date('M'); ?></span>
                                                </div>
                                                 expense
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="divider m-0 d-md-none d-sm-block"></div>
                                </div>
                                <div class="col-sm-12 col-md-4 col-xl-4">
                                    <div class="card no-shadow rm-border bg-transparent widget-chart text-left">
                                        <div class="icon-wrapper rounded-circle">
                                            <div class="icon-wrapper-bg opacity-9 bg-success"></div>
                                            <i class="lnr-apartment text-white"></i>
                                        </div>
                                        <div class="widget-chart-content">
                                            <div class="widget-subheading">Profit/Loss</div>
                                            <?php if($resp['stats']['pnl'] > 0){ ?>
                                            <div class="widget-numbers text-success"><span><?php echo $resp['stats']['pnl']; ?></span></div>
                                            <?php }else{ ?>
                                                <div class="widget-numbers text-danger"><span><?php echo $resp['stats']['pnl']; ?></span></div>
                                            <?php } ?>
                                            <?php if($resp['stats']['pnl'] > 0){ ?>
                                            <div class="widget-description text-focus">
                                                Profit 
                                                <span class="text-warning pl-1">
                                                    <i class="fa fa-angle-up"></i>
                                                    <span class="pl-1"><?php echo date('M'); ?></span>
                                                </span>
                                            </div>
                                            <?php }else{ ?>
                                                <div class="widget-description text-focus">
                                                Loss  
                                                <span class="text-warning pl-1">
                                                    <i class="fa fa-angle-down"></i>
                                                    <span class="pl-1"><?php echo date('M'); ?></span>
                                                </span>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <center><?php echo $this->Flash->render(); ?></center>
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <?php 
                                if(isset($resp['data'])){
                                    echo $this->Html->link('<button type="submit" class="btn btn-primary" id="multipleDeleteSubmit_Btn" style="margin-bottom: 10px;">Export</button>',array('controller'=>'reports','action'=>'incomeEspenseExport',$date_from,$date_to,$cat_id,$type,$csrf),array('escape'=>false));
                                }
                                 ?>
                                <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Breeder</th>
                                        <th>Category</th>
                                        <th>Type</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($resp['data'] as $data){ 
                                        ?>
                                    <tr>
                                        
                                        <td><?php echo h($data['name']); ?></td>
                                        <td><?php echo date('d M,Y', strtotime($data['date'])); ?></td>
                                        <td><?php echo h($data['amount']); ?></td>
                                        <td><?php echo h($data['breeder']); ?></td>
                                        <td><?php echo h($data['cat_name']); ?></td>
                                        <td><?php echo h($data['ledger_type_name']); ?></td>
                                        <th>
                                            <div class="mb-2 mr-2 btn-group">
                                                <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="dropdown-toggle-split dropdown-toggle btn btn-primary btn-sm">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right" style="">
                                                    
                                                    <button type="button" tabindex="0" class="dropdown-item" data-toggle="modal" data-target="#editLedgerModal" onclick="getLedgerForEdit(<?php echo h($data['id']); ?>)"><li class="fa fa-edit" style="padding-right:5px;"></li> Edit</button>
                                                    

                                                    <?php echo $this->Html->link('<button type="button" tabindex="0" class="dropdown-item"><li class="fa fa-ban" style="padding-right:5px;"></li> Delete</button>',array('controller'=>'ledgers','action'=>'deleteLedger',h($data['id'])),array('escape'=>false,'confirm'=>'Are you sure?')); ?>
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                    <?php } ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Breeder</th>
                                        <th>Category</th>
                                        <th>Type</th>
                                        <th></th>
                                    </tr>
                                    </tfoot>
                                </table>
                                
                            </div>
                        </div>
                    </div>



