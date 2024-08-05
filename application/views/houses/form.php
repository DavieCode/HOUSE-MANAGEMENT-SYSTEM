
<div class="modal-header" style="border-bottom: 1px solid #eee; padding: 2em 1em 3em 1em;">
    <h3 class="modal-title col-sm-11" id="modal-head">Add a House / room</h3>
    <button type="button" class="close col-sm-1" data-dismiss="modal" aria-label="Close">
        <span class="fa fa-close" aria-hidden="true"></span>
    </button>
</div>

<?php echo form_open('/houses/save/', array('id' => 'house_form', 'class' => 'form-horizontal')); ?>

<input type="hidden" id="apartment_id" name="apartment_id" value="<?= $apartment_info->apartment_id; ?>" />

<input type="hidden" name="house_id" id="house_id">

<div class="modal-body" style="padding-top: 4em;"> 
        <div class="form-group container-fluid">
            <label class="col-sm-2 control-label"><?=form_label('House / room Number :', 'house_no', array('class' => 'wide required')); ?></label>
            <div class="col-sm-4">
                <?php
                echo form_input(
                        array(
                            'name' => 'house_no',
                            'id' => 'house_no',
                            'class' => 'form-control house_n'
                        )
                );
                ?>       

                <span id="sp-tenant" class="form-text" style="display: none"><span class="tenatn_name"></span>
                    <span><a href="javascript:void(0)" title="Remove tenant" class="btn-remove-row"><i class="fa fa-times"></i></a></span>
                </span>
            </div>

            <label class="col-sm-2 control-label"><?=form_label('House Type  :', 'house_type', array('class' => 'wide required')); ?></label>
            <div class="col-sm-4">
                <?php 
                $house_types = array(
                    "Singe Room",
                    "Double Room",
                    "Bedsitter",
                    "1 Bedroom",
                    "2 Bedroom",
                    "3 Bedroom",
                    "4 Bedroom",
                    "5 Bedroom"
                ) ?>

                <select id="house_type" name="house_type" class="form-control" style="width: 100%; float: left;">

                    <?php foreach ($house_types as $house_type):?>
                    
                        <option value="<?=$house_type?>" > <?=$house_type ?> </option>                    
                    
                    <?php endforeach;?>                        

                </select>
            </div> 

        </div>

        <div class="form-group container-fluid">
            

            <label class="col-sm-2 control-label"><?=form_label('Status  :', 'status'); ?></label>
            <div class="col-sm-4">

                <?php $hse_status = array('Vacant', 'Occupied', 'Under maintenance', 'Out of order'); ?>

                <select name="status" id="status" class="form-control">

                    <?php foreach ($hse_status as  $stat): ?>

                        <option  value="<?=$stat ?>"><?=$stat ?></option>

                    <?php endforeach; ?>                    

                </select>
            </div>

            <label class="col-sm-2 control-label"><?=form_label('Rent :', 'rent'); ?></label>
            <div class="col-sm-4">

                <?php echo form_input(
                    array(
                        'name' => 'rent',
                        'id' => 'rent',
                        'class' => 'form-control'
                    )
                );
                ?>

            </div>
            
        </div>


        <div class="form-group container-fluid">
            <label class="col-sm-2 control-label"><?=form_label('Description:', 'house_description', array('class' => 'wide')); ?></label>
            <div class="col-sm-10">

                <?php echo form_textarea(
                        array(
                            'name' => 'house_description',
                            'id' => 'house_description',
                            'value' => '',
                            'rows' => '2',
                            'cols' => '17',
                            'class' => 'form-control'
                        )
                );
                ?>
            </div>
        </div>

        <h3 style="color: #4EA7A7;">House / room Features</h3>
        <hr>

        <div class="form-group conatiner-fluid">
            <div class="col-sm-12">
                <div class="col-sm-3 text-center">
                    <?php
                    echo form_checkbox(
                            array(
                                'name' => 'features[]',
                                'value'=> 'wifi',
                                'id' => 'wifi'
                                
                            )
                    );
                    ?>
                    <label class="control-label"> <?=form_label('Wifi') ?></label>
                </div>
                
                <div class="col-sm-3 text-center">
                    <?php
                    echo form_checkbox(
                            array(
                                'name' => 'features[]',
                                'value' => 'hot_shower',
                                'id' => 'hot_shower'
                                
                            )
                    );
                    ?>
                    <label class="control-label"> <?=form_label('hot shower') ?></label>
                </div>
                <div class="col-sm-3 text-center">
                    <?php
                    echo form_checkbox(
                            array(
                                'name' => 'features[]',
                                'value' => 'dstv', 
                                'id' => 'dstv'
                            )
                    );
                    ?>
                    <label class="control-label"> <?=form_label('Dstv') ?></label>
                </div>

                <div class="col-sm-3 text-center">
                    <?php
                    echo form_checkbox(
                            array(
                                'name' => 'features[]',
                                'value' => 'water', 
                                'id' => 'water'
                            )
                    );
                    ?>
                    <label class="control-label"> <?=form_label('water') ?></label>
                </div>
            </div>
                
        </div><br>

</div>

<div class="modal-footer" style="text-align: center;">
        <button type="button"  class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" id="save_btn" name="submit" class="btn btn-info">Save</button>
        <?php if($user_info->role == "mgmt"){ ?>

        <button  class="btn btn-danger" id="edit_house" type="button"> <span class="fa fa-pencil"> </span> &nbsp;Edit house</button>

        <?php } ?>

</div>

<?php echo form_close() ?>
