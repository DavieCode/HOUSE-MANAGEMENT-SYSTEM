<?php $this->load->view("partial/header"); ?>
<style>
    table#datatable td:nth-child(6) {
        width: 15%;
        text-align: center;
    }   

    table#datatable td:nth-child(7) {
        white-space: nowrap;
    } 
</style>

<div class="row">
    <div class="col-lg-12">
        <div class="inqbox float-e-margins">
            <div class="inqbox-content">
                <h2><?=$this->lang->line('common_list_of') . ' ' . $this->lang->line('module_' . $controller_name); ?></h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= site_url(); ?>">Home</a>
                    </li>
                    <li>
                        <a><?=$this->lang->line('module_' . $controller_name);?></a>
                    </li>
                    <li class="active">
                        <strong>List</strong>
                    </li>
                </ol>
            </div>
        </div>
    </div>    
</div>


<div class="row">
    <div class="col-lg-12">

        <div class="inqbox float-e-margins">
            <div class="inqbox-title border-top-danger">
                <h5>
                    <?= $this->lang->line('module_' . $controller_name); ?>
                </h5>
                <div class="inqbox-tools">

                    <div style="display: inline-block; margin-right: 10px">

                        <div id="filelist"></div>
                        <div id="progress" class="overlay"></div>

                        <div class="progress progress-task" style="height: 4px; width: 15%; margin-bottom: 2px; display: none">
                            <div style="width: 0%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="50" role="progressbar" class="progress-bar progress-bar-info">

                            </div>                                    
                        </div>

                        <div id="container">
                            <a id="pickfiles" href="javascript:;" class="btn btn-sm btn-default btn-xs" style="color:white" data-person-id=""><?= $this->lang->line("common_browse"); ?></a> 
                        </div>

                    </div>

                    <?= anchor("$controller_name/view/-1", "<div class='btn btn-sm btn-primary btn-xs' style='float: left; margin-right:10px;'><span>" . $this->lang->line($controller_name . '_new') . "</span></div>", array('data-toggle' => 'modal', 'data-target' => '#payment_modal', 'title' => $this->lang->line($controller_name . '_new'))); ?>
                    <?=anchor("$controller_name/delete", $this->lang->line($controller_name . "_delete"), array('id' => 'delete', 'class' => 'btn btn-sm btn-danger btn-xs', 'style' => 'color:white')); ?>

                </div>
            </div>
            <div class="inqbox-content table-responsive">

                <table id="datatable" class="table table-hover table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="text-align: center; width: 1%"><input type="checkbox" class="select_all_" /></th>
                            <?php foreach ($fields as $field): ?>
                                <?php if ($field !== "module_files"): ?>
                                    <th style="text-align: center"><?= $this->lang->line($field) ?></th>
                                <?php endif; ?>
                            <?php endforeach; ?>

                            <th style="text-align: center; width: 1%"><?= $this->lang->line("common_action"); ?></th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>
    </div>
</div>


<div id="feedback_bar"></div>
<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript" src="<?= site_url() ?>/js/plugin.js"></script>

<script type="text/javascript">
    $(document).ready(function ()
    {
        $('body').on('hidden.bs.modal', '.modal', function () {
            $(this).removeData('bs.modal');
        });

        $("#datatable").dataTable({
            "aoColumnDefs": [
                {'bSortable': false, 'aTargets': [0]}
            ],
            "language": {
                "url": "<?=site_url($this->config->item('language') . ".json"); ?>"
            },
            "processing": true,
            "serverSide": true,
            "aLengthMenu": [[50, 100, 200, 100000], [50, 100, 200, "<?= $this->lang->line("common_all"); ?>"]],
            "iDisplayLength": 50,
            "order": [1, "desc"],
            "ajax": {
                "url": "<?=site_url("$controller_name/data") ?>"
            },
            "initComplete": function (settings, json) {
                $("#datatable_filter").find("input[type='search']").attr("placeholder", "<?= $this->lang->line("common_search") ?>");
            }
        });

        enable_delete('<?=$this->lang->line($controller_name . "_confirm_delete") ?>', '<?=$this->lang->line($controller_name . "_none_selected") ?>');

        $('#generate_barcodes').click(function ()
        {
            var selected = get_selected_values();
            if (selected.length == 0)
            {
                alert('<?=$this->lang->line('items_must_select_item_for_barcode'); ?>');
                return false;
            }

            $(this).attr('href', 'index.php/item_kits/generate_barcodes/' + selected.join(':'));
        });

        $(".select_all_").click(function () {
            if ($(this).is(":checked"))
            {
                $(".select_").prop("checked", true);
            }
            else
            {
                $(".select_").prop("checked", false);
            }
        });

    });

    function post_form_submit(response)
    {
        if (!response.success)
        {
            set_feedback(response.message, 'error_message', true);
        }
        else
        {
            set_feedback(response.message, 'success_message', false);
            $('#datatable').dataTable()._fnAjaxUpdate();
            $('#apartment_type_modal').modal("hide");
        }
    }
</script>