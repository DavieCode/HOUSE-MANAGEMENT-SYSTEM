<?php $this->load->view("partial/header"); ?>

<link href="css/plugins/iCheck/custom.css" rel="stylesheet">

<?=form_open('/staffs/save/' . $person_info->person_id, array('id' => 'staff_form', 'class' => 'form-horizontal')); ?>
<input type="hidden" id="person_id" value="<?= $person_info->person_id ?>" />



<div class="row">
    <div class="col-lg-12">
        <div class="inqbox float-e-margins">
            <div class="inqbox-title">
                <h5>
                    User basic information
                </h5>
                <div class="inqbox-tools">

                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="inqbox-content">

                <?php $this->load->view("people/form_basic_info"); ?>

            </div>
        </div>
    </div>
</div>

<?php //if($user_info->username != "admin"){ ?>

<div class="row">
    <div class="col-lg-12">
        <div class="inqbox float-e-margins">
            <div class="inqbox-title">
                <h5>
                    User login info
                </h5>
                <div class="inqbox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a> 
                </div>
            </div>
            <div class="inqbox-content">
                <br/>
                <div class="form-group"><label class="col-sm-2 control-label"><?=form_label('Username :', 'username'); ?></label>
                    <div class="col-sm-10">
                        <?php
                        echo form_input(
                                array(
                                    'name' => 'username',
                                    'id' => 'username',
                                    'class' => 'form-control',
                                    'value' => $person_info->username
                                )
                        );
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <?php
                $password_label_attributes = $person_info->person_id == "" ? array('class' => 'required') : array();
                ?>

                <div class="form-group"><label class="col-sm-2 control-label"><?=form_label('Password :', 'password', $password_label_attributes); ?></label>
                    <div class="col-sm-10">
                        <?php
                        echo form_password(array(
                            'name' => 'password',
                            'id' => 'password',
                            'class' => 'form-control'
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group"><label class="col-sm-2 control-label"><?=form_label('Confirm password :', 'repeat_password', $password_label_attributes); ?></label>
                    <div class="col-sm-10">
                        <?php
                        echo form_password(array(
                            'name' => 'repeat_password',
                            'id' => 'repeat_password',
                            'class' => 'form-control'
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php ?>

<div class="row">
    <div class="form-group">
        <div class="text-center">

            <?php
            echo form_submit(array(
                'name' => 'submit',
                'id' => 'submit',
                'value' => 'Save changes',
                'class' => 'btn btn-sm btn-primary')
            );
            ?>
        </div>
    </div>

</div>


<?php
echo form_close();
?>

<div id="feedback_bar"></div>

<?php $this->load->view("partial/footer"); ?>

<script src="js/plugins/iCheck/icheck.min.js"></script>
<script src="<?=base_url(); ?>js/people.js?v=<?= time(); ?>"></script>

<script>
    $(document).ready(function () {

        var person_id = $("#person_id").val();
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green'
        });
        var settings = {
            submitHandler: function (form) {

                //$("#submit").prop("disabled", true);

                $(form).ajaxSubmit({

                    dataType: 'json',
                    type: 'post',
                    success: function (response)
                    {
                        //console.log(response);
                        post_person_form_submit(response);
                        $("#submit").prop("disabled", false);

                        setTimeout(function(){

                            location.reload()
                        },2000);
                    }
                });
            },
            rules: {
                first_name: "required",
                last_name: "required",
                username: {
                    required: true,
                    minlength: 5
                },
                password: {
                    required: true,
                    minlength: 8
                },
                repeat_password: {
                    equalTo: "#password"
                }
            },
            messages: {
                first_name: "First name is required",
                last_name: "Last name is required",
                email: "Email is required",
                username: {
                    required: "staffs username is required",
                    minlength: "5"
                },
                password: {
                    required: "staffs password is required",
                    minlength: "8"
                },
                repeat_password: {
                    equalTo: "Password don't match"
                }
            }
        };



        if (person_id !== "")
        {
            settings["rules"]["password"]["required"] = false;
        }

        // Validation 
        $('#staff_form').validate(settings);

        function post_person_form_submit(response)
        {
            if (!response.success)
            {
                set_feedback(response.message, 'error_message', true);
            } else
            {
                set_feedback(response.message, 'success_message', false);
            }

            $("#staff_form").attr("action", "<?= site_url(); ?>/staffs/save/" + response.person_id);
        }

        $('#btn-save').click(function(){

            setTimeout(function () {sub
                    location.reload()
                }, 2000);
        })
    });
</script>
