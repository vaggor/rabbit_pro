<div class="modal-content">
                                <div class="modal-body">
                                    <h5 class="modal-title">
                                        <h4 class="mt-2">
                                            <div>Welcome,</div>
                                            <span>It only takes a <span class="text-success">few seconds</span> to create your account</span>
                                        </h4>
                                    </h5>
                                    <div class="divider row"></div>
                                    <?php echo $this->Form->create('User',array('url'=>'/api/createUser','class'=>'','id'=>'signupForm')); ?>
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="position-relative form-group">
                                                <!-- <input name="email" id="exampleEmail"  placeholder="Email here..." type="email" class="form-control"> -->
                                                <?php echo $this->Form->control('name',array('type'=>'text','id'=>'name','label'=>false,'class'=>'form-control placeholder-no-fix','div'=>false,'placeholder'=>'Your or farm name here...','required'=>true)); ?>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="position-relative form-group">
                                                <!-- <input name="email" id="exampleEmail"  placeholder="Email here..." type="email" class="form-control"> -->
                                                <?php echo $this->Form->control('email',array('type'=>'email','id'=>'email','label'=>false,'class'=>'form-control placeholder-no-fix','div'=>false,'placeholder'=>'Your email here...','required'=>true)); ?>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="position-relative form-group">
                                                <!-- <input name="email" id="exampleEmail"  placeholder="Email here..." type="email" class="form-control"> -->
                                                <?php echo $this->Form->control('phone_no',array('type'=>'text','id'=>'phone_no','label'=>false,'class'=>'form-control placeholder-no-fix','div'=>false,'placeholder'=>'Your phone number here...','required'=>true)); ?>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="position-relative form-group">
                                                <?php echo $this->Form->control('country_id',array('type'=>'select','id'=>'country_id','label'=>false,'class'=>'multiselect-dropdown form-control','div'=>false,'required'=>true,'options' => array(''=>'Select Country',$list_countries))); ?>

                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="position-relative form-group">
                                                <!-- <input name="password"  id="examplePassword" placeholder="Password here..." type="password"  class="form-control"> -->
                                                <?php echo $this->Form->control('password',array('type'=>'password','id'=>'password','label'=>false,'class'=>'form-control','div'=>false,'placeholder'=>'Password here...','required'=>true)); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="position-relative form-group">
                                                <!-- <input name="passwordrep" id="examplePasswordRep" placeholder="Repeat Password here..." type="password" class="form-control"> -->
                                                <?php echo $this->Form->control('cpass',array('type'=>'password','id'=>'cpass','label'=>false,'class'=>'form-control','div'=>false,'placeholder'=>'Repeat Password here...','required'=>true)); ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-3 position-relative form-check">
                                        <!-- <input name="check" id="tnc" type="checkbox" class="form-check-input"> -->
                                        <?php echo $this->Form->control('tnc',array('type'=>'checkbox','id'=>'tnc','label'=>false,'class'=>'form-check-input','div'=>false)); ?>
                                        <label for="tnc" class="form-check-label">Accept our <?php echo $this->Html->link('Terms and Conditions',array('controller'=>'users','action'=>'terms_conditions')); ?>.</label>
                                    </div>
                                    </form>

                                    <div class="alert alert-danger fade show" role="alert" id="signup_error_alert" style="display: none;"></div>
                                    <div class="alert alert-success fade show" role="alert" id="signup_success_alert" style="display: none;"></div>

                                    <div class="divider row"></div>
                                    <h6 class="mb-0">Already have an account? 
                                        <?php echo $this->Html->link('Sign in',array('controller'=>'users','action'=>'login'),array('class'=>'text-primary')); ?> | <?php echo $this->Html->link('Recover Password',array('controller'=>'users','action'=>'reset_password'),array('class'=>'text-primary')); ?>
                                    </h6>
                                </div>
                                <div class="modal-footer d-block text-center">
                                    <button class="btn-wide btn-pill btn-shadow btn-hover-shine btn btn-primary btn-lg" id="submitSignupForm_Btn">Create Account</button>
                                </div>
                            </div>




                        