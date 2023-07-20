<div class="alert alert-danger fade show" role="alert" id="password_reset_error_alert" style="display: none;"></div>
<div class="alert alert-success fade show" role="alert" id="password_reset_success_alert" style="display: none;"></div>

<div class="modal-content">
                                <div class="modal-header">
                                    <div class="h5 modal-title">Forgot your Password?
                                        <h6 class="mt-1 mb-0 opacity-8">
                                            <span>Use  the form below to recover it.</span>
                                        </h6>
                                    </div>
                                </div>
                                <div class="modal-body">
                                    <div>
                                        <?php echo $this->Form->create('User',array('url'=>'/api/resetPassword','class'=>'','id'=>'passwordRequestForm')); ?>
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail" class="">Email</label>
                                                        <!-- <input name="email" id="exampleEmail" placeholder="Email here..." type="email" class="form-control"> -->
                                                        <?php echo $this->Form->control('email',array('type'=>'email','id'=>'email','label'=>false,'class'=>'form-control','div'=>false,'placeholder'=>'Email here...','required'=>true)); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="divider"></div>
                                    <h6 class="mb-0">
                                        <!-- <a href="javascript:void(0);" class="text-primary">Sign in existing account</a> -->
                                        <?php echo $this->Html->link('Sign in existing account',array('controller'=>'users','action'=>'login'),array('class'=>'text-primary')); ?>
                                    </h6>
                                </div>
                                <div class="modal-footer clearfix">
                                    <div class="float-right">
                                        <button class="btn btn-primary btn-lg" id="resetPassword_Btn">Recover Password</button>
                                    </div>
                                </div>
                            </div>