
<!-- Modal -->
<div class="modal fade" id="editPackageItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header model-header-color">
                <h5 class="modal-title" id="exampleModalLabel">Edit Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <?php echo $this->Form->create('PackageItem',array('url'=>'/settings/editPackageItem','class'=>'','id'=>'editPackageItemForm')); 
                    echo $this->Form->control('id',array('type'=>'hidden','id'=>'editPackageItem_id'));
                ?>
                <div class="row">                    
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Name*</label>
                            <!-- <input placeholder="default" type="text" class="mb-2 form-control" autocomplete="off" cursor: auto;"> -->
                            <?php echo $this->Form->control('name',array('type'=>'text','id'=>'editPackageItem_name','label'=>false,'class'=>'mb-2 form-control','div'=>false,'placeholder'=>'Name here...','required'=>true,'autocomplete'=>'off'));
                             ?>
                        </div>

                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Package</label>
                            <?php echo $this->Form->control('package_id',array('type'=>'select','id'=>'editPackageItem_package_id','label'=>false,'class'=>'multiselect-dropdown form-control','div'=>false,'options' => array($list_packages))); ?>
                        </div>
                    </div>





                    <div class="col-md-6">
                        <div class="position-relative form-group">
                            <label for="exampleCustomSelect" class="">Quantity</label>
                            <!-- <input placeholder="default" type="text" class="mb-2 form-control" autocomplete="off" cursor: auto;"> -->
                            <?php echo $this->Form->control('quantity',array('type'=>'text','id'=>'editPackageItem_quantity','label'=>false,'class'=>'mb-2 form-control','div'=>false,'placeholder'=>'Quantity here...','autocomplete'=>'off')); ?>
                        </div>

                </div>
        </div>
            </div>
            <!-- </form> -->
            <div class="modal-footer model-header-color">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
        </form>
    </div>
</div>