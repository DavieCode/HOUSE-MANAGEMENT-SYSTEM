<?php $this->load->view("partial/header"); ?>
<style>
    table#datatable td:nth-child(2),
    td:nth-child(7)
    {
        text-align: center
    }
</style>



<div class="row">
    <div class="col-lg-12">
        <div class="inqbox float-e-margins">
            <div class="inqbox-content">
                <h2></h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?= site_url(); ?>">Home</a>
                    </li>
                    <li>
                        <a><?= ucwords('system reports'); ?></a>
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
            <div class="inqbox-title border-top-success">
                <h5>
                    System Reports
                </h5>
                <div class="inqbox-tools">

                </div>
            </div>

            <div class="inqbox-content table-responsive" style="padding-top: 3em">

                <?php foreach ($report_types as $type) { ?>
                                             
                    <div class="col-lg-4">
                        <div class="inqbox float-e-margins">
                            <div class="inqbox-title border-top-warning" style="background: #efe">
                                <h5><?=ucwords(preg_replace("/_/", " ", $type)) ?></h5>
                            </div>
                            <div class="inqbox-content container-fluid" style="background: #efe">
                                <div class="col-lg-6">
                                    
                                    <h2 class="no-margins"><?=$this->db->count_all_results($type) ?></h2>

                                    <small><?=ucwords(preg_replace("/_/", " ", $type)) ?></small>

                                </div>

                                    <a class="btn btn-sm btn-info" href="index.php/reports/printIt/<?=$type ?>" > <span class="fa fa-print"></span> &nbsp; Generate</a>
                            </div>
                        </div>
                    </div>

                <?php } ?>

            </div>
        </div>
    </div>
</div>

<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript">
    
    <?php if(isset($pdf_file)){ ?>

lnr        alertify.confirm( "<?=ucfirst($controller) ?> Report", "<span style='font-size:40px;position:absolute;top:55px' class='lnr lnr-check-circle-o'></span> <span style='margin-left:55px'>Your file is ready. Would you like to view it?</span>",

          function(){

            window.open("<?=$pdf_file ?>", "_blank");

            //alertify.success('Yes');

          },
          function(){

            window.location.href='index.php/reports';
            //alertify.error('No');

          }).set('labels', {ok:'Yes', cancel:'No'});;

    <?php } ?>

</script>
