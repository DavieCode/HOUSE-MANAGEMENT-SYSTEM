<?php $this->load->view("partial/header"); ?>

<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">

<?=form_open('/payments/save/' . $payment_info->payment_id, array('id' => 'payment_form', 'class' => 'form-horizontal')); ?>

<input type="hidden" id="payment_id" name="payment_id" value="<?= $payment_info->payment_id; ?>" />

<div class="row">
    <div class="col-lg-12 border-top-info">
        <div class="inqbox float-e-margins">
            <div class="inqbox-title">
                <h5>
                    Payment information
                </h5>
                <div class="inqbox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="inqbox-content" style="padding: 6em 2em 2em 2em;">

                <div class="form-group">
                    <label class="col-sm-2 control-label"><?=form_label('Student ', 'inp-tenant', array('class' => 'wide required')); ?></label>
                    <div class="col-sm-4">
                        <?php
                        echo form_input(
                                array(
                                    'name' => 'inp-tenant',
                                    'id' => 'inp-tenant',
                                    'value' => $payment_info->tenant_name,
                                    'class' => 'form-control',
                                    'placeholder' => 'Start typing here...',
                                    'style' => 'display:' . ($payment_info->tenant_id <= 0 ? "" : "none")
                                )
                        );

                        ?>

                        <span class="form-text" id="sp-tenant" style="display: <?= ($payment_info->tenant_id > 0 ? "" : "none") ?>">
                            <?= $payment_info->tenant_name; ?>
                        </span>
                        <input type="hidden" id="tenant" name="tenant" value="<?= $payment_info->tenant_id; ?>" />
                    </div>
                    
                    <label class="col-sm-2 control-label"><?=form_label('Account # :', 'inp-tenant-id', array('class' => 'wide')); ?></label>
                    <div class="col-sm-4">
                        <p id="inp-tenant-id" style="margin-top: .5em"><?=isset($payment_info->tenant_id) ? $payment_info->tenant_id: "N/A"?></p>
                        
                        <span id="sp-tenant-id" style="display: <?= ($payment_info->tenant_id > 0 )? "none" : "none" ?>">
                            <?= strval($payment_info->tenant_id); ?>
                            
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label"><?=form_label('Hostel Name :', 'apartment'); ?></label>
                    <div class="col-sm-4">

                        <p id="apartment" style="margin-top: .5em"><?=isset($payment_info->apartment_name) ? $payment_info->apartment_name : "N/A" ?></p>

                    </div>

                    <label class="col-sm-2 control-label"><?=form_label("House number:", 'house_no'); ?></label>

                    <div class="col-sm-4">
                        
                        <p id="house_no" style="margin-top: .5em"><?=isset($payment_info->house_no) ? $payment_info->house_no : "N/A" ?></p>

                    </div>

                    <input type="hidden" id="house_id" name="house_id" value="<?=$payment_info->house_id ?>">
                </div>


            <div class="form-group">
                
                <label class="col-sm-2 control-label"><?=form_label("House Type :", 'house_type'); ?></label>

                <div class="col-sm-4">

                    <p id="house_type" style="margin-top: .5em"><?=isset($payment_info->house_type) ? $payment_info->house_type : "N/A"?></p>

                </div>

                <label class="col-sm-2 control-label"><?=form_label("Expected rent :", 'expected_rent'); ?></label>

                <div class="col-sm-4">

                    <p id="expected_rent" style="margin-top: .5em"><?=isset($payment_info->rent) ? $payment_info->rent : "N/A"?></p>

                </div>

                

            
            </div>

            <hr>


            <div class="form-group" style="padding-top: 2em;"> 

                <label class="col-sm-2 control-label"><?=form_label('Date :', 'payment_date', array('class' => 'wide required')); ?></label>
                    <div class="col-sm-4">
                        <div class="input-group date" id="paid_date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <?php
                            echo form_input(
                                    array(
                                        'name' => 'date_paid',
                                        'id' => 'date_paid',
                                        'value' => (!empty($payment_info->date_paid)) ? date("m/d/Y", strtotime($payment_info->date_paid)) : date('m/d/Y'),
                                        'class' => 'form-control'
                                    )
                            );
                            ?>
                        </div>
                    </div>               
                <?php 
                    $months = array(
                        '1'=>'January',
                        '2'=>'February',
                        '3'=>'March',
                        '4'=>'April',
                        '5'=>'May',
                        '6'=>'June',
                        '7'=>'July',
                        '8'=>'August',
                        '9'=>'September',
                        '10'=>'October',
                        '11'=>'November',
                        '12'=>'December',
                    )
                
                ?> 
                    <label class="col-sm-2 control-label"><?=form_label('Month :', 'month', array('class' => 'wide required')); ?></label>
                    <div class="col-sm-4">

                        <select value="<?=$paid_for->month ?>" name="month" class="form-control" style="width: 50%; float: left;">

                            <?php foreach ($months as $key => $month){ 

                                $current_month = date('m');

                                $selected = "";

                                if (isset($paid_for->month) && $paid_for->month == $key) {

                                    $selected = "selected";
                                    
                                }else{

                                    if ($current_month == $key && $payment_info->payment_id < 1) {

                                        $selected = "selected";
                                        
                                    } 
                                }

                                ?>
                            
                                <option <?=$selected ?> value="<?=$key ?>" > <?=$month ?> </option>
                            
                            
                            <?php }?>
                            

                        </select>

                        <select name="year" class="form-control" style="width: 50%; float: right;">

                                <option <?=(date(" Y") == $paid_for->year) ? "selected" : ''?> value="<?= date(" Y")?>" > <?=date(" Y")?> </option>

                                <option <?=(date(" Y", strtotime("+ 1years")) == $paid_for->year) ? "selected" : ''?> value="<?=date(" Y", strtotime("+ 1years"))?>" > <?= date(" Y", strtotime("+ 1years"))?> </option>

                                <option <?=(date(" Y", strtotime("+ 2years")) == $paid_for->year) ? "selected" : ''?> value="<?=date(" Y", strtotime("+ 2years"))?>" > <?= date(" Y", strtotime("+ 2years"))?> </option>
                            

                        </select>
                    </div>
                
                
            </div>

            <hr>

                <div class="form-group" id="data_1">

                    <label class="col-sm-2 control-label"><?=form_label("Amount" . ':', 'amount', array('class' => 'wide required' )); ?></label>

                    <div class="col-sm-4">
                        <?php
                        echo form_input(
                                array(
                                    'name' => 'amount',
                                    'id' => 'amount',
                                    'value' => $payment_info->amount,
                                    'class' => 'form-control',
                                    'type' => 'text',
                                    'step' => 'any'
                                )
                        );
                        ?>
                        <input type="hidden" name="original_pay_amount" value="<?= $payment_info->amount; ?>" />
                    </div>


                    <label class="col-sm-2 control-label"><?=form_label('Payment method:', 'method', array('class' => 'wide required')); ?></label>

                    <div class="col-sm-4">
                        <?php

                        $items = array(
                            'cash' => 'Cash',
                            'mpesa' => 'Mpesa',
                            'bank_transfer' => 'Bank Transfer');

                        if (empty($payment_info->payment_method)) {

                            $payment_info->payment_method = "cash";

                        }

                        echo form_dropdown('payment_method', $items , $payment_info->payment_method, "class='form-control'");
                        ?>
                    </div>
                </div>

                <div class="form-group">

                    

                        <label class="col-sm-2 control-label"><?=form_label('Paid by:', 'paid_by', array('class' => 'wide required')); ?></label>

                        <div class="col-sm-4">
                            <?php
                                echo form_input(
                                    array(
                                        'name' => 'paid_by',
                                        'id' => 'paid_by',
                                        'value' =>  $payment_info->paid_by,
                                        'class' => 'form-control',
                                        'type' => 'text',
                                    )
                                );                            
                            ?>
                        </div>
                        
                        <label class="col-sm-2 control-label" style="float: left;"><?=form_label('Teller :', 'teller', array('class' => 'wide')); ?></label>

                        <div class="col-sm-2">
                            
                            <span class="form-text" style="float: right;"><?=isset($payment_info->teller_name) ? ucwords($payment_info->teller_name) : ucwords($user_info->first_name . " " . $user_info->last_name); ?></span>
                        </div>


                </div>

                


                <div class="form-group"><label class="col-sm-2 control-label"><?=form_label('Remarks :', 'remarks', array('class' => 'wide')); ?></label>
                    <div class="col-sm-10">
                        <?php
                        echo form_textarea(
                                array(
                                    'name' => 'remarks',
                                    'id' => 'remarks',
                                    'value' => $payment_info->remarks,
                                    'rows' => '3',
                                    'cols' => '10',
                                    'class' => 'form-control'
                                )
                        );
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 border-top-info">
        <div class="inqbox float-e-margins">
            <div class="inqbox-title">
                <h5>
                    Payment breakdown
                </h5>
                <div class="inqbox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="inqbox-content" style="padding: 2em;">

                <p style="padding: 2em" class="text-center"><small>Breakdown the payment so the system can do calculations faster and correctly</small></p>

                <div class="form-group">

                    <div class="col-sm-6">

                        <label class="col-sm-4 control-label"><?=form_label('Deposit:', 'deposit', array('class' => 'wide required')); ?></label>

                        <div class="col-sm-8">
                            <?php
                            echo form_input(

                                array(
                                    'name' => 'deposit',
                                    'id' => 'deposit',
                                    'class' => 'form-control',
                                    'value' => isset($breakdown->deposit) ? $breakdown->deposit : 0
                                    )
                                );
                            ?>
                        </div>

                    </div>

                    <div class="col-sm-6" style="padding-right: 0 ">

                        <label class="col-sm-4 control-label"><?=form_label('Rent :', 'rent', array('class' => 'wide required')); ?></label>

                        <div class="col-sm-8">
                            <?php
                                echo form_input(

                                    array(
                                        'name' => 'rent',
                                        'id' => 'rent',
                                        'class' => 'form-control',
                                        'value' => isset($breakdown->rent) ? $breakdown->rent : 0
                                    )
                                );
                            ?>
                        </div>

                    </div>

                </div>
                <div class="hr-line-dashed"></div>
            </div>
        </div>
    </div>
</div>

<!-- <input type="hidden" id="modified_by" name="modified_by" value="<?= $payment_info->modified_by; ?>" /> -->
<input type="hidden" id="user_info" name="teller" value="<?= $user_info->person_id; ?>" />

<div class="row">
    <div class="form-group">
        <div class="text-center">

            <?php if ($user_info->role == "mgmt"): ?>

                <button id="btn-edit" class="btn btn-sm btn-danger" type="button"><span class="fa fa-pencil"></span> &nbsp;Edit Payment</button>
                
            <?php endif ?>

            <?php
              
                echo form_submit(
                        array(
                            'name' => 'submit',
                            'id' => 'btn-save',
                            'value' => 'Save',
                            'class' => 'btn btn-sm btn-primary'
                        )
                );

              ?>

            <?php if ($payment_info->apartment_id > 0) { ?>

                <a style="margin-left: 10px" id="btn-apartment" class="btn btn-sm btn-info" href="<?=site_url("apartments/view/".$payment_info->apartment_id) ?>">View apartment &nbsp;<span class="fa fa-long-arrow-right"></span></a>
                
            <?php }?>

        </div>
    </div>
</div>

<?php
echo form_close();
?>


<?php $this->load->view("partial/footer"); ?>

<!-- Date picker -->
<script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>

<script type='text/javascript'>

    //validation and submit handling
    $(document).ready(function ()
    {

        function datepicker_enable(){

              $('.input-group.date').datepicker({

                    todaybtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    calendarWeeks: true,
                    autoclose: true,
                    endDate: new Date()
                });
        }

        if ($("#payment_id").val() > -1)
        {

            $("input, textarea").prop("readonly", true);
            $("select").prop("disabled", true);
            $("#btn-save").hide();
            $("#btn-edit").show();
            
            // console.log("hello");


            $("#btn-edit").click(function () {
                
                $("#btn-save").show();
               
                $(this).hide();

                datepicker_enable();

                $("input, textarea").prop("readonly", false);

                $("select").prop("disabled", false);
            });
        }
        else
        {
            $("#btn-approve").hide();
            $("#btn-break-gen").hide();
            $("#btn-edit").hide();
            datepicker_enable();    
        }

        $('#btn-save').click(function(){

            setTimeout(function () {
                    location.reload()
                }, 2000);
        })

        // $("#inp-tenant-id").change(function () {
        //     get_tenant_by_id($(this).val());
        // });

        if ($("#teller").val() <= 0)
        {
            $("#teller").val($("#user_info").val());
        }

        $(document).on("change", "#apartment_id", function () {
            var balance = $('#apartment_id option:selected').data('balance');
            $("#balance_amount").val(balance.replace(/[^\d.]/g, '').replace('.',''));
        });

        if ($("#payment_id").val() > -1)
        {
            $("#modified_by").val($("#user_info").val());
            $("#payment_form input, textarea").prop("readonly", true);
            $("#payment_form select").prop("disabled", true);
            $("#btn-save").hide();
        }

        $(document).on("click", ".btn-remove-row", function () {
            clear_tenant();
        });

        $('#inp-tenant').autocomplete({
            serviceUrl: '<?=site_url("payments/tenant_search"); ?>',
            onSelect: function (suggestion) {

                console.log(suggestion);

                var name = suggestion.value;
                $("#inp-tenant-id").text(suggestion.data);
                $("#tenant").val(suggestion.data);
                $("#paid_by").val(name.split(" ")[0]);
                $("#sp-tenant").html(suggestion.value + ' <span><a href="javascript:void(0)" title="Remove tenant" class="btn-remove-row"><i class="fa fa-times"></i></a></span>');
                $("#sp-tenant").show();
                $("#inp-tenant").hide();

                // console.log(suggestion.data);

                populate_apartments(suggestion.data);
            }
        });

        var settings = {
            submitHandler: function (form) {
                $(form).ajaxSubmit({
                    success: function (response) {
                        post_payment_form_submit(response);
                        
                        //console.log(response);
                    },

                    error: function(response) {
                        
                        // console.log(response);
                    },
                    dataType: 'json',
                    type: 'post'
                });
            },
            rules: {
                tenant: "required",
                apartment_id: {greaterThanZero: true, required:true},
                paid_by: "required",
                deposit: {required: true, breakdownSum : true},
                rent: {required: true, breakdownSum : true},
                amount: {greaterThanZero: true, breakdownSum : true}
            },
            messages: {
                tenant: "tenant is required!",
                apartment_id: {greaterThanZero:"tenant doesn't have an active apartment!", required:"Please select a apartment!"}
            }
        };

        $('#payment_form').validate(settings);

        $.validator.addMethod("greaterThanZero", function (value, element) {

            // console.log(value);

            if (parseFloat(value) > 0)
            {
                return true;
            }
            return false;
            
        }, "Amount must be greater than 0!");


        $.validator.addMethod("breakdownSum", function (value, element) {

            var amount = $("#amount").val();

            var deposit = $("#deposit").val();

            var rent = $("#rent").val();

            var totalBrkdown = parseInt(deposit) + parseInt(rent);

            console.log(rent);

            if (parseFloat(totalBrkdown) == amount)
            {
                return true;
            }
            return false;
            
        }, "Amount must be equal to the breakdown sum!");
    });

    function populate_apartments(tenant_id)
    
    {
        $.ajax({
            url: "<?= site_url("payments/get_apartments") ?>/" + tenant_id,
            type: "get",
            dataType: 'json',
            success: function (result) {

                console.log(result);

                    
                $("#apartment").text(result.name);
                $("#house_no").text(result.house_no);
                $("#house_type").text(result.house_type);
                $('#expected_rent').text(result.rent);
                $('#house_id').val(result.house_id);
            }
        });
    }

    function get_tenant_by_id(tenant_id)
    {
        $.ajax({
            url: "<?= site_url("payments/get_tenant") ?>/" + tenant_id,
            type: "get",
            dataType: 'json',
            success: function (suggestion) {
                if ($.trim(suggestion.value) !== "")
                {
                    $("#tenant").val(suggestion.data);
                    $("#sp-tenant").html(suggestion.value + ' <span><a href="javascript:void(0)" title="Remove tenant" class="btn-remove-row"><i class="fa fa-times"></i></a></span>');
                    $("#sp-tenant").show();
                    $("#inp-tenant").hide();
                    populate_apartments(suggestion.data);

                }
                else
                {
                    clear_tenant();
                }
            },
            error: function () {
                
                //console.log();
            }
        });
    }

    function clear_tenant()
    {
        $("#sp-tenant").hide();
        $("#sp-tenant").html("");
        $("#inp-tenant").val("");        
        $("#paid_by").val("");
        $("#inp-tenant").show();
        $("#tenant").val("");
        var options = $("#apartment_id");
        options.empty();
        $("#inp-tenant-id").text("N/A");
        $("#apartment").text("N/A");
        $("#house_no").text("N/A");
        $("#house_type").text("N/A");
        $('#rent').text("N/A");
        $('#apartment_id').val("");
    }


    function post_payment_form_submit(response)
    {
        if (!response.success)
        {
            set_feedback(response.message, 'error_message', true);
        }
        else
        {
            set_feedback(response.message, 'success_message', false);
        }

        $("#payment_form").attr("action", "<?= site_url(); ?>/payments/save/" + response.payment_id);
    }

</script>