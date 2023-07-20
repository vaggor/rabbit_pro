<div class="modal-content">
                                <div class="modal-body">
                                    <div class="h5 modal-title text-center">
                                        <h4 class="mt-2">
                                            <div>Welcome back,</div>
                                            <span>Please sign in to your account below.</span>
                                        </h4>
                                    </div>
                                    <!-- <form class=""> -->
                                        <?php echo $this->Form->create('User',array('url'=>'/users/login','class'=>'')); ?>
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="position-relative form-group">
                                                    <!-- <input name="email" id="exampleEmail" placeholder="Email here..." type="email" class="form-control"> -->
                                                    <?php echo $this->Form->control('email',array('type'=>'text','label'=>false,'class'=>'form-control placeholder-no-fix','div'=>false,'placeholder'=>'Email here...','required'=>true)); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="position-relative form-group">
                                                    <!-- <input name="password" id="examplePassword" placeholder="Password here..." type="password" class="form-control"> -->
                                                    <?php echo $this->Form->control('password',array('type'=>'password','label'=>false,'class'=>'form-control placeholder-no-fix','div'=>false,'placeholder'=>'Password here...','required'=>true)); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="position-relative form-check">
                                            <input name="check" id="exampleCheck" type="checkbox" class="form-check-input">
                                            <label for="exampleCheck" class="form-check-label">Keep me logged in</label>
                                        </div>
                                    
                                    <div class="divider"></div>
                                    <h6 class="mb-0">No account? <?php echo $this->Html->link('Sign up now',array('controller'=>'users','action'=>'signup'),array('class'=>'text-primary')); ?></h6>
                                </div>
                                <div class="modal-footer clearfix">
                                    <div class="float-left">
                                        <!-- <a href="javascript:void(0);" class="btn-lg btn btn-link">Recover Password</a> -->
                                        <?php echo $this->Html->link('Recover Password',array('controller'=>'users','action'=>'reset_password'),array('class'=>'btn-lg btn btn-link')); ?>
                                    </div>
                                    <div class="float-right">
                                        <button class="btn btn-primary btn-lg">Login to Dashboard</button>
                                    </div>
                                </div>
                            </div>