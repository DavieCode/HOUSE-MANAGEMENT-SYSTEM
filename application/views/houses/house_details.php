<div class="modal-header">

            <h3 class="modal-title" id="modal-head">House information</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span class="fa fa-close" aria-hidden="true"></span>
            </button>
</div>
<?php $apartment= $apartment_info->apartment_id ?>

<?=form_open('/houses/save/' . $house_info->house_id, array('id' => 'house_form', 'class' => 'form-horizontal')); ?>
<input type="hidden" value="<?=$apartment?>" name="apartment">
<div class="modal-body"> 
        <div class="form-group container-fluid">
            <label class="col-sm-2 control-label"><?=form_label('House Number :', 'house_no'); ?></label>
            <div class="col-sm-4">
                <?php
                echo form_input(
                        array(
                            'name' => 'house_no',
                            'id' => 'house_no',
                            'value' => $house_info->house_no,
                            'class' => 'form-control',
                            // 'placeholder' => 'Start typing here...',
                            'style' => 'display:' . ($house_info->tenant_id <= 0 ? "" : "none")
                        )
                );
                ?>       

                <span id="sp-tenant" class="form-text" style="display: <?= ($house_info->tenant_id > 0 ? "" : "none") ?>">
                    <?=$tenant_name; ?>
                    <span><a href="javascript:void(0)" title="Remove tenant" class="btn-remove-row"><i class="fa fa-times"></i></a></span>
                </span>
                <input type="hidden" id="tenant" name="tenant" value="<?= $house_info->tenant_id; ?>" />

            </div>

            <label class="col-sm-2 control-label"><?=form_label('House Type  :', 'house_type'); ?></label>
            <div class="col-sm-4">
                <?php 
                $houses = array(
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
                            <?php foreach ($houses as  $house):?>
                            
                                <option value="<?=$house ?>" > <?=$house ?> </option>
                            
                            
                            <?php endforeach;?>
                            

                    </select>
            </div> 

        </div>

        <div class="form-group container-fluid">
            

            <label class="col-sm-2 control-label"><?=form_label('Status  :', 'status'); ?></label>
            <div class="col-sm-4">
                <?php
                $status= array(

                    'Vacant',
                    'Occupied',
                    'Under maintenance',
                    'Out of order'

                );
                
                ?>
                <select name="status" id="status" class="form-control">
                    <?php foreach ($status as  $stat):?>

                        <option value="<?=$stat ?>"><?=$stat ?></option>

                    <?php endforeach;?>
                    

                </select>
            </div>


            
        </div>


        <div class="form-group container-fluid">
            <label class="col-sm-2 control-label"><?=form_label('Description:', 'house_description', array('class' => 'wide')); ?></label>
            <div class="col-sm-10">
                <?php
                echo form_textarea(
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

        <h3 style="color: #4EA7A7;">House Features</h3>
        <hr>

        <div class="form-group conatiner-fluid">
            <div class="col-sm-12">
                <div class="col-sm-4">
                    <?php
                    echo form_checkbox(
                            array(
                                'name' => 'features[]',
                                'value'=> 'wifi',
                                'id' => 'wifi',
                                
                            )
                    );
                    ?>
                    <label class="control-label"> <?=form_label('Wifi',) ?></label>
                </div>
                
                <div class="col-sm-4">
                    <?php
                    echo form_checkbox(
                            array(
                                'name' => 'features[]',
                                'value' => 'hot shower',
                                'id' => 'hot-shower',
                                
                            )
                    );
                    ?>
                    <label class="control-label"> <?=form_label('hot shower',) ?></label>
                </div>
                <div class="col-sm-4">
                    <?php
                    echo form_checkbox(
                            array(
                                'name' => 'features[]',
                                'value' => 'dstv', 
                                'id' => 'dstv',
                            )
                    );
                    ?>
                    <label class="control-label"> <?=form_label('Dstv',) ?></label>
                </div>
            </div>
                
        </div><br>

</div>




<div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" name="submit" class="btn btn-info">Save</button>
</div>

<?php echo form_close() ?>

<script>

$(document).ready(function () {

    var house_settings = {
            ignore: "",
            invalidHandler: function (form, validator) {
                set_feedback("Error: Please correct all the required fields", 'error_message', true);
            },
            submitHandler: function (form) {
                $(form).ajaxSubmit({
                    success: function (response) {
                        
                        post_house_form_submit(response);

                        console.log(response);

                        // if ($("#house_id").val() > 0)
                        // {
                        //     setTimeout(function () {
                        //         location.reload()
                        //     }, 5000);
                        // }
                    },

                    error:function (response) {
                            
                        console.log(response);
                    },
                    dataType: 'json',
                    type: 'post'
                });

            },
            rules: {
                house_type: "required",
                house_no: "required"
            },
            messages: {
                house_type: "Please select house type",
                house_no: "House number is required"
            }
        };

        $('#house_form').validate(house_settings);

        function post_house_form_submit(response) {

            if (!response.success)
            {
                set_feedback(response.message, 'error_message', true);
            }
            else
            {
                set_feedback(response.message, 'success_message', false);
            }

            $('#house_form').attr("action", "<?= site_url(); ?>/houses/add/" + response.apartment_id);
        }

    });

</script>