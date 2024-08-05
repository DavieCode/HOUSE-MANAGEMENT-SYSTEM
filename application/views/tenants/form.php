<?php $this->load->view("partial/header"); ?>

<?= form_open('tenants/save/' . $person_info->person_id, array('id' => 'tenant_form', 'class' => 'form-horizontal')); ?>
<input type="hidden" id="tenant_id" value="<?= $tenant_id ?>" />
<input type="hidden" id="linker" value="<?= random_string('alnum', 16); ?>" />


<div class="row">
    <div class="col-lg-12">
        <div class="inqbox float-e-margins">
            <div class="inqbox-title">
                <h5>
                    Students basic information
                </h5>
                <div class="inqbox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="inqbox-content">

                <div class="tabs-container">

                    <ul class="nav nav-pills">

                        <li class="active"><a data-toggle="tab" href="#sectionA">Personal Information</a></li>

                        <!-- <?php if ($tenant_id > -1) { ?>
                        
                            <li class=""><a data-toggle="tab" href="#sectionB">Payment History</a></li>

                        <?php  } ?> -->

                    </ul>

                    <hr>

                    <div class="tab-content">

                        <div id="sectionA" class="tab-pane fade in active" style="padding-top: 2em">

                            <div style="text-align: center">
                                <div id="required_fields_message">Please input all the required fields</div>
                                <ul id="error_message_box"></ul>
                            </div>

                            
                            <div class="container-fluid" style="margin-top: 2em">

                                <div class="col-sm-5">
                                    <label class="col-sm-5 control-label">
                                        Passport Photo : 
                                    </label>
                                    <div class="col-sm-7">
                                        <?php if( trim(trim($person_info->photo_url) !== "") && file_exists( FCPATH  . "/uploads/profile-" . $person_info->person_id . "/" . $person_info->photo_url ) ): ?>
                                        <img id="img-pic" src="<?= base_url("uploads/profile-" . $person_info->person_id . "/" . $person_info->photo_url); ?>" style="height:99px" />
                                        <?php else: ?>
                                        <img id="img-pic" src="imgs/80x80.png" style="height:99px" />
                                        <?php endif; ?>
                                        <div id="filelist"></div>
                                        <div id="progress" class="overlay"></div>

                                        <div class="progress progress-task" style="height: 4px; width: 15%; margin-bottom: 2px; display: none">
                                            <div style="width: 0%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="50" role="progressbar" class="progress-bar progress-bar-info">

                                            </div>                                    
                                        </div>

                                        <div id="container">
                                            <a id="pickfiles" href="javascript:;" class="btn btn-sm btn-info" style="min-width: 100px;" data-person-id="<?= $person_info->person_id; ?>">Browse</a> 
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-7" style="padding: 0">

                                    <div class="form-group" style="padding-top: 1em">

                                        <label class="col-sm-3 control-label"><?=form_label('First name ', 'first_name', array('class' => 'required')); ?></label>
                                        <div class="col-sm-9" style="padding: 0">
                                            <?php  
                                                echo form_input(
                                                    array(
                                                        'name' => 'first_name',
                                                        'id'  => 'first_name',
                                                        'value' => $person_info->first_name,
                                                        'class' => 'form-control'
                                                    )
                                            );
                                            
                                            ?>

                                        </div>
                                    </div>
                                    <div class="form-group">

                                        <label class="col-sm-3 control-label"><?=form_label('Last name ', 'last_name', array('class' => 'required')); ?></label>
                                        <div class="col-sm-9" style="padding: 0">
                                            <?php
                                            echo form_input(
                                                    array(
                                                        'name' => 'last_name',
                                                        'id' => 'last_name',
                                                        'value' => $person_info->last_name,
                                                        'class' => 'form-control'
                                                    )
                                            );
                                            ?>
                                        </div>
                                    </div>         

                                </div>
                                </div>

                                <hr>

                                <div class="form-group" style="padding-top: 2em">

                                    <label class="col-sm-2 control-label"><?=form_label('Hostel Name  ', 'apartment_name', array('class' => 'required')); ?></label>
                                    <div class="col-sm-4">
                                        <?php

                                        $display = isset($person_info->apartment_name) ? "none" : "";

                                            echo form_input(
                                                    array(
                                                        'name' => 'apartment_name',
                                                        'id' => 'apartment_name',
                                                        'value' => $person_info->apartment_name,
                                                        'class' => 'form-control',
                                                        'placeholder' => 'Start typing here ...',
                                                        'style' => 'display:'.$display
                                                    )
                                            );
                                        ?>
                                        
                                        <span class="form-text" id="sp-apartment" style="display: <?= ($person_info->apartment_id > 0 ? "" : "none") ?>"><?= $person_info->apartment_name; ?>

                                            <span style="display: <?=isset($person_info->apartment_name) ? "" : "none"?>"><a href="javascript:void(0)" title="Remove Apartment" class="btn-remove-row"><i class="fa fa-times"></i></a></span>

                                        </span>
                                        <input type="hidden" id="apartment" name="apartment" value="<?= $person_info->apartment_id; ?>" />

                                    </div>

                                    <label class="col-sm-2 control-label"><?=form_label( 'House:', 'house_no', array('class' => 'required')); ?></label>
                                    <div class="col-sm-4">
                                        
                                        <select class="form-control" name="house_id" id="houses">

                                            <?php if (isset($person_info->house_id)) { ?>

                                                 <option value="<?=$person_info->house_id ?>" ><?=$person_info->house_no ?></option>

                                            <?php }else{ ?>
                                            
                                                <option>No selected Apartment</option>

                                            <?php } ?>

                                        </select>

                                    </div>
                                </div>

                                <hr/>

                                <div class="form-group" style="padding-top: 2em">

                                    <label class="col-sm-2 control-label"><?=form_label('Email  :', 'email'); ?></label>
                                    <div class="col-sm-4">
                                        <?php
                                        echo form_input(
                                                array(
                                                    'name' => 'email',
                                                    'id' => 'email',
                                                    'value' => $person_info->email,
                                                    'class' => 'form-control'
                                                )
                                        );
                                        ?>
                                    </div>

                                    <label class="col-sm-2 control-label"><?=form_label( 'ID /Passport No:', 'id_number'); ?></label>
                                    <div class="col-sm-4">
                                        <?php
                                        echo form_input(
                                                array(
                                                    'name' => 'id_number',
                                                    'id' => 'id_number',
                                                    'value' => $person_info->id_number,
                                                    'class' => 'form-control'
                                                )
                                        );
                                        ?>
                                    </div>
                                </div>


                                <div class="form-group">

                                <label class="col-sm-2 control-label"><?=form_label('Phone number:', 'id_number'); ?></label>
                                <div class="col-sm-4">
                                    <?php
                                    echo form_input(
                                            array(
                                                'name' => 'phone_number',
                                                'id' => 'phone_number',
                                                'value' => $person_info->phone_number,
                                                'class' => 'form-control'
                                            )
                                    );
                                    ?>
                                </div>

                                <label class="col-sm-2 control-label"><?=form_label('Home Address:', 'home_address'); ?></label>
                                <div class="col-sm-4">
                                    <?php
                                    echo form_input(
                                            array(
                                                'name' => 'home_address',
                                                'id' => 'home_address',
                                                'value' => $person_info->home_address,
                                                'class' => 'form-control'
                                            )
                                    );
                                    ?>
                                </div>
                            </div>

                        </div>

                        <?php if ($tenant_id > -1) { ?>
                                       
                            <div id="sectionB" class="tab-pane fade in" style="padding-top: 2em">

                                <p class="small text-center">The tenants apartment history has been as follows</p>

                                <table class="table table-bordered table-striped text-center" id="datatable">

                                    <thead>
                                        <tr>
                                            <th style="text-align: center; width: 1%">#</th>
                                            <th>Rent</th>
                                            <th>Date issued</th>
                                            <th>Due date</th>
                                            <th>Latest payment</th>
                                            <th>Total Paid</th>
                                            <th>Payment status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                    <?php $i = 1; foreach ($apartment_history as $history){ ?>

                                        <tr>

                                            <td><?=$i ?></td>

                                            <td><?=to_currency($history->apartment_amount, true, 0) ?></td>

                                            <td><?=date("d M, Y", strtotime($history->date_applied)) ?></td>

                                            <td><?=date("d M, Y", strtotime($history->payment_date)) ?></td>

                                            <td><?=(isset($history->latest_payment)) ? date("d M, Y", strtotime($history->latest_payment)) : "N/A" ?></td>

                                            <td><?=to_currency($history->total_paid, true, 0) ?></td>

                                            <td><?=ucwords($history->status) ?></td>

                                            <td>

                                                <div style='display:inline-flex; align-items:center;'>

                                                    <a class="btn-danger btn-sm effect-1" title="apartment Details" href="index.php/apartments/view/<?=$history->apartment_id ?>"> <span class="fa fa-plus"></span> </a>

                                                </div>
                                            </td>

                                        </tr>

                                    <?php $i++; } ?>

                                    </tbody>

                                </table>

                                <div class="text-center">

                                    <a href="<?=base_url() ?>index.php/tenants/printIt/<?=$tenant_id ?>" class="btn btn-sm btn-warning" id="btn-print"> <span class="fa fa-print"></span> &nbsp; Print History</a>
                                    
                                </div>


                            </div>

                        <?php  } ?>


                            <div class="row" style="padding: 2em">
                                <div class="form-group">
                                    <div class="text-center">

                                        <?php if ((int) $tenant_id > -1) : ?>

                                            <button type="button" class="btn btn-sm btn-primary" id="btn-edit"> <span class="fa fa-pencil"></span> &nbsp; Edit</button>

                                            <button type="button" class="btn btn-sm btn-danger" id="btn-vacate"> </span>vacate &nbsp;<span class="fa fa-remove"></button>
                                            

                                        <?php endif; ?>

                                        <?php
                                        $display = '';
                                        if ($tenant_id > -1)
                                        {
                                            $display = 'display: none';
                                        }
                                        ?>

                                        <button type="submit" name="submit" style="display: <?=$display ?>" class="btn btn-info" id="btn-save"> Save Changes &nbsp; <span class="fa fa-save"></span></button>

                                    </div>
                                </div>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?= form_close(); ?>

<?php $this->load->view("partial/footer"); ?>

<script src="<?=base_url(); ?>js/people.js?v=<?= time(); ?>"></script>

<script type="text/javascript">
    $(document).ready(function () {

        var table = $("#datatable").DataTable({

            "fixedHeader" : true,

            "columnDefs" : [{"targets" : [0, 7] , "orderable" : false}],

            "aLengthMenu": [[25, 50, 100, 200, 100000], [25, 50, 100, 200, "All"]],

            "iDisplayLength": 25,

            "order" : [],

            "dom": "<'row'<'col-sm-4 text-left'l><'col-sm-4 text-center'><'col-sm-4 text-right'f>>" + "<'row padded'<'col-sm-12'tr>>" + "<'row'<'col-sm-5 text-left'i><'col-sm-7 text-right'p>>"
        });

        

        if ($("#tenant_id").val() > -1)
        {

            $("#tenant_form input, textarea, select").prop("disabled", true);

            $("#btn-edit").click(function () {
                $("#btn-save").show();                
                $(".btn-remove-row").show();
                $(this).hide();
                $("#tenant_form input, textarea, select").prop("disabled", false);
                populate_houses($("apartment").val);
            });
        }  


        $("#sel_agent").change(function () {
            $("#agent").val($(this).val());
        });

        if ($("#agent").val() <= 0)
        {
            $("#agent").val('<?=$user_info->person_id;?>');
        }


        if ($("#tenant_id").val() > -1)
        {
            $(".btn-remove-row").hide();
            $(".remove-file").hide();

            $("#btn-save").hide();

            $("#btn-break-gen").show();
            $("#btn-edit").show();
            $("#btn-print").show();

            $("#btn-edit").click(function () {
                $("#btn-save").show();
                $(this).hide();
                $(".btn-remove-row").show();
                $(".remove-file").show();
                $("#btn-save").show();
            });

            $("#btn-vacate").click(function(){

             var tenant_id = $("#tenant_id").val() 

             var house_id = $("#houses").val();

                $.ajax({
                    url: "<?= site_url("tenants/vacate") ?>/" + tenant_id + "/" + house_id,
                    type: "get",
                    dataType: 'json',
                    success: function (data) {
                        
                        console.log(data);

                        post_person_form_submit(data);
                        
                    }
                });

            })
        }
        else
        {
            $("#btn-edit").hide();

            $("#btn-print").hide();
        }


        $('#apartment_name').autocomplete({
            serviceUrl: '<?=site_url("apartments/suggest"); ?>',
            onSelect: function (suggestion) {

                var name = suggestion.value;
                $("#apartment").val(suggestion.data);
                $("#apartment_name").val(suggestion.data);
                $("#sp-apartment").html(suggestion.value + ' <span><a href="javascript:void(0)" title="Remove Apartment" class="btn-remove-row"><i class="fa fa-times"></i></a></span>');
                $("#sp-apartment").show();
                $(".btn-remove-row").show();
                $("#apartment_name").hide();

                populate_houses(suggestion.data);
            }
        });

        function populate_houses(apartment_id) {
            
            $.ajax({
                url: "<?= site_url("tenants/get_houses") ?>/" + apartment_id + "/vacant",
                type: "get",
                dataType: 'json',
                success: function (data) {
                    
                    // console.log(data);

                    var options = $("#houses");
                    options.empty();

                    if(data.length == 0){

                        options.append($("<option />").val(0).text("No Vacant Houses"));

                    }else{
                        $.each(data, function () {
                            options.append($("<option />").val(this.house_id).text(this.house_no));

                        });

                    }
                }
            });
        }

        $(document).on("click", ".btn-remove-row", function () {
            $(this).hide();
            $("#sp-apartment").hide();
            $("#sp-apartment").html("");

            $("#apartment_name").show();
            $("#apartment_name").val("");

            $("#houses").empty();
            $("#houses").append($("<option />").val(0).text("No selected apartment"));
        });

        var settings = {
            submitHandler: function (form) {
                $("#btn-save").prop("disabled", true);
                $(form).ajaxSubmit({
                    success: function (response) {

                        post_person_form_submit(response);
                        $("#submit").prop("disabled", false);

                        // console.log(response)
                    },
                    error:function(response){

                        // console.log(response)
                    },
                    dataType: 'json',
                    type: 'post'
                });

            },
            rules: {
                first_name: "required",
                last_name: "required",
                email: "email"
            },
            messages: {
                first_name: "First name is required",
                last_name: "Last name is required",
                email: "Please enter a valid email address"
            }
        };

        $('#tenant_form').validate(settings);

        function post_person_form_submit(response)
        {
            if (!response.success)
            {
                set_feedback(response.message, 'error_message', true);
            }
            else
            {
                set_feedback(response.message, 'success_message', false);
            }
            
            $("#tenant_form").attr("action", "<?= site_url(); ?>/tenants/save/" + response.person_id);
        }


        <?php if(isset($pdf_file)){ ?>

            alertify.confirm( "tenant Statement", "<span style='font-size:40px;position:absolute;top:55px' class='lnr lnr-checkmark-circle'></span> <span style='margin-left:55px'>Your file has been saved. Would you like to view it?</span>",

              function(){

                window.open("<?=$pdf_file ?>", "_blank");

                //alertify.success('Yes');

              },
              function(){

                window.location.href='index.php/tenants';
                //alertify.error('No');

              }).set('labels', {ok:'Yes', cancel:'No'});;

        <?php } ?>

        $('#btn-save').click(function(){

            setTimeout(function(){

                location.reload()
            }, 2000);
        })

    });
</script>