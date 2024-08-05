<?php $this->load->view("partial/header"); ?>

<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">

<?= form_open('expenses/save/' . $expense_info->expense_id, array('id' => 'expense_form', 'class' => 'form-horizontal')); ?>
<input type="hidden" id="expense_id" name="expense_id" value="<?= $expense_id ?>" />
<input type="hidden" id="linker" value="<?= random_string('alnum', 16); ?>" />


<div class="row">
    <div class="col-lg-12">
        <div class="inqbox float-e-margins">
            <div class="inqbox-title">
                <h5>
                    Expense information
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


                <div style="padding: 1.5em">

                    <p class="text-center">Kindly input all the required fields</p>
                    
                </div>

                <div class="tabs-container" style="padding-top: 20px">

                    <div class="form-group">

                        <label class="col-sm-2 control-label"><label class="required">Expense Category </label></label>

                        <div class="col-sm-4">

                            <?php 

                                $categories = json_decode($this->config->item("expense_categories"));

                                asort($categories);
                            ?>
                            
                            <select name="category" class="form-control" id="category">

                                <?php foreach ($categories as $cat) { ?>
                                
                                    <option <?=($cat == ucwords($expense_info->category)) ? "selected" : "" ?> value="<?=$cat ?>" ><?=ucwords($cat) ?></option>
                                    
                                <?php } ?>

                            </select>                                    
                        </div>                        

                        <label class="col-sm-2 control-label">Manage categories </label>
                        <div class="col-sm-4">

                            <button class="btn btn-sm btn-info"  type="button" data-toggle="modal" data-target="#categories_modal"> <span class="fa fa-minus-circle"></span> &nbsp; Manage</button>
                                                        
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><label class="required">Date</label></label>
                        <div class="col-sm-4">

                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                                <?php
                                echo form_input(
                                        array(
                                            'name' => 'date',
                                            'type' => 'datetime',
                                            'id' => 'date',
                                            'value' => (isset($expense_info->date)) ? date("m/d/Y", strtotime($expense_info->date)) : date("m/d/Y", time()),
                                            'class' => 'form-control'
                                        )
                                );
                                ?>
                            </div>
                            
                        </div>

                        <label class="col-sm-2 control-label"><label class="required">Amount (Ksh) </label></label>
                        <div class="col-sm-4">
                            <?php
                            echo form_input(
                                    array(
                                        'name' => 'amount',
                                        'id' => 'amount',
                                        'value' => $expense_info->amount,
                                        'class' => 'form-control'
                                    )
                            );
                            ?>
                            
                        </div>

                    </div>

                    <div class="form-group">

                        <label class="col-sm-2 control-label"><?=form_label('Description:', 'description', array('class' => 'wide')); ?></label>
                        <div class="col-sm-10">
                            <?php
                            echo form_textarea(
                                    array(
                                        'name' => 'description',
                                        'id' => 'description',
                                        'value' => $expense_info->description,
                                        'rows' => '3',
                                        'cols' => '17',
                                        'class' => 'form-control'
                                    )
                            );
                            ?>
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Added by </label>
                        <div class="col-sm-4">

                            <p class="control-label" style="text-align: left;"><?=(isset($expense_info->added_by)) ? ucwords($this->db->where('person_id', $expense_info->added_by)->get('people')->row()->first_name) :ucwords($user_info->first_name . " " . $user_info->last_name); ?></p>

                            <input type="hidden" id="added_by" name="added_by" value="<?= ($expense_info->added_by > 0) ? $expense_info->added_by : $user_info->person_id ?> "/>
                            
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group">
        <div class="col-sm-12 text-center">

            <?php if ((int) $expense_id > -1) : ?>
                <button type="button" class="btn btn-sm btn-primary" id="btn-edit"> <span class="fa fa-pencil"></span> &nbsp; Edit</button>    
            <?php endif; ?>

            <?php
            $display = '';
            if ($expense_id > -1)
            {
                $display = 'display: none';
            }
            ?>

            <button type="submit" name="submit" <?=$display ?> class="btn btn-sm btn-info" id="btn-save"> <span class="fa fa-save"></span> &nbsp; save</button>  
          
        </div>
    </div>
</div>


<?= form_close(); ?>


<div class="modal fade" id="categories_modal" role="dialog">

    <div class="modal-dialog" style="max-width: 400px;">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header" style="background: #e9573f">

              <button type="button" class="close" data-dismiss="modal">&times;</button>

              <h4 id="modal-title" style="color: white"> EXPENSE CATEGORIES </h4>

            </div>

            <?= form_open('expenses/save_categories/', array('id' => 'expense_category_form', 'class' => 'form-horizontal')); ?>

                <div class="modal-body" style="max-height: 60vh; overflow-y: scroll;" id="cat_container">

                    <table class="text-center" width="100%" border="0">

                        <?php foreach ($categories as $cat) { ?>

                            <tr><td><input type="text" class="form-control" style="margin: 1em .2em" name="categories[]" value="<?=ucwords($cat) ?>"></td><td width="50px"> <span style="cursor: pointer;color: red" title="Delete Category" class="fa remove fa-remove"></span></td></tr>
                            
                        <?php } ?>

                    </table>
                </div>

                <div class="modal-footer">
                    
                    <span class="btn btn-info" id="btn_new_cat">New Category</span>
                    
                    <button type="submit" name="submit" id="submit_categories" class="btn btn-primary ">Save Changes</a>

                </div>

            </form>
        </div>
    </div>
</div>


<?php $this->load->view("partial/footer"); ?>

<!-- Date picker -->
<script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>

<script type="text/javascript">

    $(document).on("click", ".remove",function() {
        $(this).parent().parent().remove();
    });

    $(document).ready(function () {

        $('#btn_new_cat').click(function() {

            $('#cat_container table').append('<tr><td><input type="text" class="form-control" style="margin: 1em .2em" name="categories[]"></td><td width="50px"> <span style="cursor: pointer;color: red" title="Delete Category" class="fa remove fa-remove"></span></td></tr>');

            $('#cat_container').animate({scrollTop: $('#cat_container').prop("scrollHeight")}, 500);
           
        });

        $('.input-group.date').datepicker({
            todaybtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true,
        });

        if ($("#expense_id").val() > -1)
        {
            $("#expense_form input, textarea, select").prop("disabled", true);
            $("#btn-save").hide();

            $("#btn-edit").click(function () {
                $("#btn-save").show();
                $(this).hide();
                $("#expense_form input, textarea, select").prop("disabled", false);
            });
        }
        var settings = {
            submitHandler: function (form) {
                $("#submit").prop("disabled", true);
                $(form).ajaxSubmit({
                    success: function (response) {

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
                description: "required",
                amount: "required"
            },
            messages: {
                description: "Expense must be described!",
                amount: "Expense amount is required!"
            }
        };

        var category_settings = {
            submitHandler: function (form) {
                $("#submit_categories, #btn_new_cat").prop("disabled", true);
                $("#btn_new_cat").hide();
                $(form).ajaxSubmit({
                    success: function (response) {

                        $("#submit_categories, #btn_new_cat").prop("disabled", false);
                        $("#btn_new_cat").show();

                        $('#categories_modal').modal('toggle');

                        post_person_form_submit(response);

                    },
                    error:function(response){

                        // console.log(response)
                    },
                    dataType: 'json',
                    type: 'post'
                });

            }
        };

        $('#expense_form').validate(settings);

        $('#expense_category_form').validate(category_settings);

        function post_person_form_submit(response)
        {

            if (!response.success)
            {
                set_feedback(response.message, 'error_message', false);
            }
            else
            {
                set_feedback(response.message, 'success_message', true);
            }
            
        }

        $('#btn-save').click(function(){

            setTimeout(function () {
                    location.reload()
                }, 2000);
        })
    });
</script>