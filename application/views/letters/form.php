<?php $this->load->view("partial/header"); ?>

<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">

<?= form_open('letters/save/' . $letter_id, array('id' => 'letter_form', 'class' => 'form-horizontal')); ?>
<input type="hidden" id="letter_id" name="letter_id" value="<?= $letter_id ?>" />
<input type="hidden" id="linker" value="<?= random_string('alnum', 16); ?>" />


<div class="row">
    <div class="col-lg-12">
        <div class="inqbox float-e-margins">
            <div class="inqbox-title">
                <h5>
                    Letter information
                </h5>
                <div class="inqbox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <!-- <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a> -->
                </div>
            </div>
            <div class="inqbox-content">

                <div class="tabs-container" style="padding-top: 20px">

                    <div class="form-group">

                        <label class="col-sm-2 control-label">Ref. Number :</label>

                        <div class="col-sm-10">

                            <?php
                            echo form_input(
                                    array(
                                        'name' => 'ref_no',
                                        'id' => 'ref_no',
                                        'value' => $letter_info->letter_id,
                                        'class' => 'form-control'
                                    )
                            );
                            ?>
                                                                
                        </div>

                    </div>

                    <div class="hr-line-dashed"></div>

                    <div class="form-group">

                        <label class="col-sm-2 control-label">Subject : </label>

                        <div class="col-sm-10">

                            <?php
                            echo form_input(
                                    array(
                                        'name' => 'subject',
                                        'id' => 'subject',
                                        'value' => $letter_info->subject,
                                        'class' => 'form-control'
                                    )
                            );
                            ?>
                                                                
                        </div>

                    </div>

                    <div class="hr-line-dashed"></div>

                    <div class="form-group"><label class="col-sm-2 control-label"><?=form_label('Receivers Address :', 'address', array('class' => 'wide')); ?></label>
                        <div class="col-sm-10">
                            <?php
                            echo form_textarea(
                                    array(
                                        'name' => 'address',
                                        'id' => 'address',
                                        'value' => $letter_info->address,
                                        'rows' => '3',
                                        'cols' => '17',
                                        'class' => 'form-control'
                                    )
                            );
                            ?>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>

                    <div class="form-group"><label class="col-sm-2 control-label"><?=form_label('Message:', 'message', array('class' => 'wide')); ?></label>
                        <div class="col-sm-10">
                            <?php
                            echo form_textarea(
                                    array(
                                        'name' => 'message',
                                        'id' => 'message',
                                        'value' => $letter_info->message,
                                        'rows' => '10',
                                        'cols' => '17',
                                        'class' => 'form-control'
                                    )
                            );
                            ?>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>

                    <div class="form-group"><label class="col-sm-2 control-label">Creation date:</label>
                        <div class="col-sm-10">

                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                                <?php
                                echo form_input(
                                        array(
                                            'name' => 'date_created',
                                            'type' => 'datetime',
                                            'id' => 'date',
                                            'value' => (isset($letter_info->date_created)) ? date("m/d/Y", strtotime($letter_info->date_created)) : date("m/d/Y", time()),
                                            'class' => 'form-control'
                                        )
                                );
                                ?>
                            </div>
                            
                        </div>

                    </div>

                    <div class="hr-line-dashed"></div>

                    <div class="form-group"><label class="col-sm-2 control-label">Created by :</label>
                        <div class="col-sm-10">

                            <p class="control-label" style="text-align: left;"><?=(isset($letter_info->created_by)) ? ucwords($this->db->where('person_id', $letter_info->created_by)->get('people')->row()->first_name) :ucwords($user_info->first_name . " " . $user_info->last_name); ?></p>

                            <input type="hidden" id="created_by" name="created_by" value="<?= ($letter_info->created_by > 0) ? $letter_info->created_by : $user_info->person_id ?> "/>
                            
                        </div>

                    </div>

                    <div class="hr-line-dashed"></div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group">
        <div class="col-sm-12 text-center">

            <?php

            if ($letter_id < 1)
            { 
                $display = 'false';
            
            }else{ $display = 'true';?>

                <button type="button" class="btn btn-primary" id="btn-edit"> <span class="fa fa-pencil"></span> &nbsp; Edit</button> 

                <a class="btn btn-warning" href="<?=base_url() ?>index.php/letters/printIt/<?=$letter_id ?>"><span class="fa fa-print"></span> &nbsp; Print</a>

            <?php }

                echo form_submit(
                        array(
                            'name' => 'submit',
                            'id' => 'btn-save',
                            'value' => 'Save',
                            'class' => 'btn btn-info',
                            'hidden' => $display
                        )
                ); ?>
        </div>
    </div>
</div>


<?= form_close(); ?>

<?php $this->load->view("partial/footer"); ?>

<!-- Date picker -->
<script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>

<script src="<?=base_url(); ?>js/people.js?v=<?= time(); ?>"></script>

<script type="text/javascript">
    $(document).ready(function () {

        function datepicker_enable(){

                $('.input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                endDate: new Date()
            });
        }

        if ($("#letter_id").val() > -1)
        {
            $("#letter_form input, textarea, select").prop("disabled", true);

            $("#btn-edit").click(function () {
                $("#btn-save").show();
                datepicker_enable();
                $(this).hide();
                $("#letter_form input, textarea, select").prop("disabled", false);
            });

        }
        else{

            datepicker_enable();
        }

        $('#btn-save').click(function(){

            setTimeout(function () {
                    location.reload()
                }, 2000);
        })

        var settings = {

            submitHandler: function (form) {

                $("#submit").prop("disabled", true);

                $(form).ajaxSubmit({
                    success: function (response) {

                        // console.log(response)

                        post_person_form_submit(response);
                        
                        $("#submit").prop("disabled", false);
                    },
                    error:function(response){

                        // console.log(response)
                    },
                    dataType: 'json',
                    type: 'post'
                });

            },
            rules: {
                subject: "required",
                message: "required",
                address: "required"
            },
            messages: {
                subject: "Subject can not be empty",
                message: "Letter content is required",
                address: "Receivers address is required!"
            }
        };

        $('#letter_form').validate(settings);

        function post_person_form_submit(response)
        {
            if (!response.success)
            {
                set_feedback(response.message, 'error_message', { timeOut: 5000 });
            }
            else
            {
                set_feedback(response.message, 'success_message', { timeOut: 5000 });
            }
            
            $("#letter_form").attr("action", "<?= site_url(); ?>/letters/save/" + response.letter_id);
        }


        <?php if(isset($letter_design)){ ?>

            alertify.confirm( "Letter", "<span style='font-size:40px;position:absolute;top:55px' class='lnr lnr-checkmark-circle'></span> <span style='margin-left:55px'>Your letter has been saved. Would you like to view it?</span>",

              function(){

                window.open("<?=$letter_design ?>", "_blank");

                //alertify.success('Yes');

              },
              function(){

                window.location.href='index.php/letters/view/<?=$letter_id ?>';
                //alertify.error('No');

              }).set('labels', {ok:'Yes', cancel:'No'});;

        <?php } ?>
    });
</script>