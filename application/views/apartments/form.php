<?php $this->load->view("partial/header"); ?>

<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">


<?=form_open('/apartments/save/' . $apartment_info->apartment_id, array('id' => 'apartment_form', 'class' => 'form-horizontal')); ?>
<style>
    #drop-target {
        border: 10px dashed #999; 
        text-align: center;
        color: #999;
        font-size: 20px;
        width: 600px;
        height: 300px;
        line-height: 300px;
        cursor: pointer;
    }

    #drop-target.dragover {
        background: rgba(255, 255, 255, 0.4);
        border-color: green;
    }
</style>
<input type="hidden" id="apartment_id" name="apartment_id" value="<?= $apartment_info->apartment_id; ?>" />
<input type="hidden" id="controller" value="<?= strtolower('apartments'); ?>" />
<input type="hidden" id="linker" value="<?= random_string('alnum', 16); ?>" />

<div class="row">
    <div class="col-lg-12">
        <div class="inqbox float-e-margins">
            <div class="inqbox-title">
                <h5>
                    Hostel Information</h5>
                <div class="inqbox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="inqbox-content">
                <div class="tabs-container">
                    <ul class="nav nav-pills tab-border-top-danger">

                        <li class="active" id="b_info"><a data-toggle="tab"  href="#sectionA">Basic information</a></li>
                       <?php if($apartment_info->apartment_id > 0) { ?>
                        <li><a data-toggle="tab" id="house_tab" href="#sectionB" disa>houses/rooms</a></li>
                       <?php } ?>
                    </ul>

                    <hr>

                    <div class="tab-content">

                        <div id="sectionA" class="tab-pane fade in active">

                            <div style="text-align: center; padding: 2em;">

                                <h3>Basic information</h3>
                            </div>
                            
                            <div class="form-group"><label class="col-sm-2 control-label"><?=form_label('Hostel Name :', 'inp-apartment', array('class' => 'wide required')); ?></label>
                                <div class="col-sm-4">
                                    <?php
                                    echo form_input(
                                            array(
                                                'name' => 'inp-apartment',
                                                'id' => 'inp-apartment',
                                                'value' => $apartment_info->name,
                                                'class' => 'form-control',
                                                'placeholder' => 'Start typing here...',
                                                'style' => 'display:' . ($apartment_info->tenant_id <= 0 ? "" : "none")
                                            )
                                    );
                                    ?>       

                                    <span id="sp-tenant" class="form-text" style="display: <?= ($apartment_info->tenant_id > 0 ? "" : "none") ?>">
                                        <?=$tenant_name; ?>
                                        <span><a href="javascript:void(0)" title="Remove tenant" class="btn-remove-row"><i class="fa fa-times"></i></a></span>
                                    </span>
                                    <input type="hidden" id="tenant" name="tenant" value="<?= $apartment_info->tenant_id; ?>" />

                                </div>

                                <label class="col-sm-2 control-label"><?=form_label('Location  :', 'location', array('class' => 'wide required')); ?></label>
                                <div class="col-sm-4">
                                    <?php
                                    echo form_input(
                                            array(
                                                'name' => 'location',
                                                'id' => 'location',
                                                'value' => $apartment_info->location,
                                                'class' => 'form-control'
                                            )
                                    );
                                    ?>
                                </div>
                                
                            </div>
                            

                            <div class="form-group"><label class="col-sm-2 control-label"><?=form_label('No of floors:', 'floors', array('class' => 'required')); ?></label>
                                <div class="col-sm-4">
                                    <?php
                                    echo form_input(
                                            array(
                                                'name' => 'floors',
                                                'id' => 'floors',
                                                'value' => $apartment_info->floors,
                                                'class' => 'form-control',
                                                'type' => 'number',
                                                'min' => '0',
                                                'max' => '200'
                                            )
                                    );
                                    ?>
                                </div>
                            </div>

                            <div class="form-group"><label class="col-sm-2 control-label"><?=form_label('Description:', 'description', array('class' => 'wide')); ?></label>
                                <div class="col-sm-10">
                                    <?php
                                    echo form_textarea(
                                            array(
                                                'name' => 'description',
                                                'id' => 'description',
                                                'value' => $apartment_info->description,
                                                'rows' => '5',
                                                'cols' => '17',
                                                'class' => 'form-control'
                                            )
                                    );
                                    ?>
                                </div>
                            </div>

                            <div class="form-group" id="data_1">

                                <!-- PENALTY RATE -->

                            </div>

                            <div class="form-group">

                                

                                <label class="col-sm-2 control-label"><?=form_label('Agent :', 'agent', array('class' => 'wide')); ?></label>

                                <div class="col-sm-4">

                                    <span class="form-text">

                                        <?php if ($user_info->person_id === '1'): ?>
                                            <?=form_dropdown("sel_agent", $staffs, ($apartment_info->apartment_agent_id > 0 ? $apartment_info->apartment_agent_id : $user_info->person_id), "id='sel_agent' class='form-control'"); ?>

                                        <?php else: ?>
                                            <?= ucwords($user_info->first_name . " " . $user_info->last_name); ?>
                                        <?php endif; ?>
                                        <!--
                                        <?=isset($apartment_info->agent_name) ? ucwords($apartment_info->agent_name) : ucwords($user_info->first_name . " " . $user_info->last_name); ?>
                                        -->
                                    </span>
                                    <input type="hidden" id="agent" name="agent" value="<?= ($apartment_info->apartment_agent_id > 0 ? $apartment_info->apartment_agent_id : $user_info->person_id) ?>" />

                                    <input type="hidden" id="approver" name="approver" value="<?= $apartment_info->apartment_approved_by_id; ?>" />

                                </div>

                                <label class="col-sm-2 control-label"><?=form_label('Date Added :', 'date', array('class' => 'wide')); ?></label>

                                <div class="col-sm-4">

                                    <span class="form-text">

                                        <?php echo date('F j Y, h:i a') ?>
                                        
                                    </span>
                                </div>

                            </div>
                           

                            <div class="row">
                                <div class="form-group">
                                    <div class="text-center">
                                        
                                        <?php if($user_info->role == "mgmt" && $apartment_info->apartment_id > 0){ ?>

                                            <button id="btn-edit" class="btn btn-danger" type="button"> <span class="fa fa-pencil"> </span> &nbsp;Edit apartment</button>

                                        <?php } ?>
                                        
                                        <?php
                                        echo form_submit(
                                                array(
                                                    'name' => 'submit',
                                                    'type' => 'submit',
                                                    'id' => 'btn-save',
                                                    'value' => 'Save',
                                                    'class' => 'btn btn-sm btn-primary'
                                                )
                                        );
                                        ?>

                                    </div>
                                </div>
                            </div>


                        </div>

                        <?php if($apartment_info->apartment_id) { ?>

                            <div id="sectionB" class="tab-pane fade in">            
                                
                                    <div class="houses_section row">
                                        <div class="thumbnail col-sm-2"  id="hse_add" style="margin-right: .2em; width:100px;height:100px;background: #ededed;font-size:5em;text-align:center;cursor:pointer">
                                        +
                                    </div>

                                <?php foreach ($houses  as $house) { ?>
                              
                                    <div class="thumbnail thumbnail_house col-sm-2 container-flui hs_display<?=$house->house_id ?>" id = "<?=$house->house_id ?>">

                                        <input type="hidden" id="" value="<?=$house->house_id?>">

                                        <div id="house-no" style="color: #fff; font-size: 18px; padding-top: .3em; font-weight: 600;"><?=$house->house_no?></div> 

                                        <div style="color: #fff; padding: .5em;" id="house-type"><?=$house->house_type?></div>

                                        <div style="padding-right: 4px; padding-left: 4px; border: 1px solid #fff; width: 70px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap; border-radius: 1em; text-align: center; margin:auto; color: #fff;"> <span ><?=$house->status ?></span></div>
                                        
                                    </div>
                                                                       
                                 <?php } ?>     
                                       
                            </div>
                        <?php }?>

                    </div>           

                </div>
            </div>
        </div>
    </div>
</div>
<?=form_close(); ?>

    <div class="modal fade" id="add-house" arial-hidden="true" role="dialog">

        <div class="modal-dialog" >
            <div class="modal-content" style="background: #fff;">
                
            <?php $this->load->view('houses/form');?>
                
            </div>
            
        </div>

    </div>

<div id=""> 
    
    <div class="modal fade" id="display-house" arial-hidden="true" role="dialog">

        <div class="modal-dialog" >
            <div class="modal-content" style="background: #fff;">
                
             <?php //$this->load->view('houses/form'); ?>
                
            </div>
            
        </div>

    </div>
</div>

<?php $this->load->view("partial/footer"); ?>

<script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>
<script src="<?=base_url(); ?>js/apartment.js?v=<?= time(); ?>"></script>

<script type='text/javascript'>

    $(document).ready(function(){

        
    })

    // validation and submit handling
    $(document).ready(function () {

        $('#hse_add').click(function(){

            $('#house_form').attr("action", "<?=base_url(); ?>index.php/houses/save/-1")
            $('#modal-head').html("Add a House / room");

            $('#house_no').prop('readonly', false);
            $('#house_type').prop('disabled',false)
            $('#status').prop('disabled',false)
            $('#house_description').prop('readonly',false)
            $('input[type=checkbox]').prop('checked',false)
            $('input[type=checkbox]').prop('disabled',false)
            $('#rent').prop('readonly', false);

            $('#house_description').val('');
            $('#house_no').val('');
            $('#rent').val('');
            
            $('#edit_house').hide();
            $('#save_btn').show();

            $('#add-house').modal('show')
        })

        var selected = "";
                
            $('.thumbnail_house').click(function(e){

                var house_id = $(this).attr('id');

                var checks = $('input[type=checkbox]');
                

                $.ajax({

                    url : "<?=base_url(); ?>index.php/houses/house_info/"+ house_id,

                    method : "post",

                    success : function(res){
                        
                        var data = JSON.parse(res);

                        console.log(data)

                        checks.each(function(){
                            $(this).prop('checked', false)
                        });
                        
                        var features = JSON.parse(data.features);

                        features.forEach(function(value){

                            $("#"+value).prop('checked', true);
                            $("#"+value).prop('disabled', true)

                        });

                        $('#modal-head').html("House / room Details")
                        $('#house_form').attr("action", "<?=base_url(); ?>index.php/houses/save/"+ data.house_id)
                        $('#house_id').val(data.house_id);

                        $('#house_no').val(data.house_no);
                        $('#house_type').val(data.house_type);
                        $('#house_description').val(data.description);
                        $('#rent').val(data.rent);
                        $('#status').val(data.status)
                        selected = data.status
                        $('#status').empty()
                        $('#status').append('<option value="'+data.status+'"> '+data.status+'</option>')

                        $('.house_n').prop('readonly',true)
                        $('.house_n').prop('readonly',true)
                        $('#status').prop('disabled', true)
                        $('#house_type').prop('disabled', true)
                        $('#house_description').prop('readonly', true)  
                        $('#rent').prop('readonly', true);
                         $('input[type=checkbox]').prop('disabled',true) 

                        $('#save_btn').hide();
                        $('#edit_house').show();

                        $('#add-house').modal('show');
                    }
                })
                     

            })

            $("#add-house").on('hide.bs.modal', function(){
                setTimeout(function (){
                    location.reload()
                    console.log('exited')
                }, 500);

                // console.log('exited')
            })

            // $('#house_tab').click(function(){

            //     $('#btn-edit').hide();

            // })

            // $('#house_tab').click(function(){

            //     $('#btn-edit').hide();

            // })

            var statuses = ["Vacant", "Occupied", "Under maintenance", "Out of order"]

            $('#edit_house').click(function(e){
                
                $('#house_type').prop('disabled',false)
                $('#status').prop('disabled',false)
                $('#house_description').prop('readonly',false)
                $('input[type=checkbox]').prop('disabled',false)
                $('#rent').prop('readonly', false);
                $('#status').empty()
                // console.log(selected)
                $.each(statuses, function (index, status) {

                    console.log(selected)

                    if(selected == status){

                        console.log(status)

                        $('#status').append('<option value="'+status+'" selected>'+status+'</option>')

                    } else{

                        $('#status').append('<option value="'+status+'">'+status+'</option>')
                    }
                     
                });
                $('#save_btn').show();
                $('#edit_house').hide();
                
            })

            var active = $('#b-info').hasClass('active');

            if(active){

                $('#btn-edit').show();
            } else{

                $('#btn-edit').hide();
            }
        

        <?php if(isset($pdf_file)){ ?>

            alertify.confirm( "Letter of apartment Request", "<span style='font-size:40px;position:absolute;top:55px' class='lnr lnr-checkmark-circle'></span> <span style='margin-left:55px'>Your file is ready. Would you like to view it?</span>",

              function(){

                window.open("<?=$pdf_file ?>", "_blank");

                //alertify.success('Yes');

              },
              function(){

                window.location.href='index.php/apartments';
                //alertify.error('No');

              }).set('labels', {ok:'Yes', cancel:'No'});;

        <?php } ?>
        $('.input-group.date').datepicker({
            todaybtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true,
            //startDate: new Date()
        });

        $("#sel_agent").change(function () {
            $("#agent").val($(this).val());
        });

        if ($("#agent").val() <= 0)
        {
            $("#agent").val('<?=$user_info->person_id;?>');
        }


        if ($("#apartment_id").val() > -1)
        {
            $(".btn-remove-row").hide();
            $(".remove-file").hide();

            //$("#statement").show();
            $("#apartment_form input, #apartment_form textarea").prop("readonly", true);
            $("#apartment_form select").prop("disabled", true);
            $("#btn-add-row, #btn-add-row-g").prop("disabled", true);
            $("#btn-del-row, #btn-del-row-g").prop("disabled", true);
            $("#btn-save").hide();

            $("#btn-break-gen").show();
            $("#btn-edit").show();

            $("#btn-edit").click(function () {
                $("#btn-save").show();
                $(this).hide();
                $(".btn-remove-row").show();
                $(".remove-file").show();
                $("#apartment_form input, textarea").prop("readonly", false);
                $("#apartment_form select").prop("disabled", false);
                $("#btn-add-row").prop("disabled", false);
                $("#btn-del-row").prop("disabled", false);
                $("#btn-save").show();
            });
        }
        else
        {
            $("#btn-edit").hide();

            $("#btn-print").hide();
        }

        var settings = {
            ignore: "",
            invalidHandler: function (form, validator) {
                set_feedback("Error: Please correct all the required fields", 'error_message', true);
            },
            submitHandler: function (form) {
                $(form).ajaxSubmit({
                    success: function (response) {
                        
                        post_apartment_form_submit(response);

                        //console.log(response);

                        if ($("#apartment_id").val() > 0)
                        {
                            setTimeout(function () {
                                location.reload()
                            }, 5000);
                        }
                    },

                    error:function (response) {
                            
                        // console.log(response);
                    },
                    dataType: 'json',
                    type: 'post'
                });

            },
            rules: {
                account: "required",
                amount: "required",
                payment_date : {required:true, date: true},
                "inp-tenant": "required"
            },
            messages: {
                account: "Please select a tenant",
                amount: "apartment amount can not be 0",
                "inp-tenant": "Please select a tenant"
            }
        };

        $('#apartment_form').validate(settings);

        function post_apartment_form_submit(response) {

            if (!response.success)
            {
                set_feedback(response.message, 'error_message', true);
            }
            else
            {
                set_feedback(response.message, 'success_message', false);
            }

            $('#apartment_form').attr("action", "<?= site_url(); ?>/apartments/save/" + response.apartment_id);
        }


    var house_settings = {
            ignore: "",
            invalidHandler: function (form, validator) {
                set_feedback("Error: Please correct all the required fields", 'error_message', true);
            },
            submitHandler: function (form) {
                $(form).ajaxSubmit({
                    success: function (response) {
                        
                        post_house_form_submit(response);

                        setTimeout(function () {
                            location.reload()
                        }, 800);
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