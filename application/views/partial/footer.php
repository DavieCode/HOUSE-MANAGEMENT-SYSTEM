</div>
<!-- END CONTENT -->

<!-- BEGIN FOOTER -->
<div class="footer" style="margin-top: 3em !important; position: relative;margin: 0;color: #e9573f !important">

    <div class="pull-right">
       &copy; KCA hostels 2021 - <?=date('Y') ?> &middot; All rights reserved.
    </div>


    <div>
        Powered by David Mwania <span style="color: #20B899;"><i><h4 style="font-size: 10;">Student KCA University</h4></i> </span> 
    </div>

</div>
<!-- BEGIN FOOTER -->
</div>
</div>


<!-- Modal -->
<div class="modal fade" id="config_modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Modal -->
<!-- <div class="modal fade" id="print_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        </div> -->
        <!-- /.modal-content -->
    <!-- </div> -->
    <!-- /.modal-dialog -->
<!-- </div> -->
<!-- /.modal -->




</body>
</html>


<!-- Custom and plugin javascript -->
<script src="js/main.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>

<script type="text/javascript" src="<?=base_url(); ?>js/jquery.niftymodals/js/jquery.modalEffects.js"></script>
<script>
    $(document).ready(function () {
        $('.md-trigger').modalEffects();

            $.get("<?=base_url() ?>index.php/overdues/data", function(data){

                    var obj = JSON.parse(data);

                    $('#overdue_count').text(obj.length);

            }); 
    });
</script>
