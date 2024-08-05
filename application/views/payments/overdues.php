<?php $this->load->view("partial/header"); ?>


<div class="row">
    <div class="col-lg-12">
        <div class="inqbox float-e-margins">
            <div class="inqbox-title border-top-success">
                <h5>
                    Delayed payments
                </h5>
                <div class="inqbox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="inqbox-content table-responsive">

                <div class="row table-body">
                    <div class="col-md-12">
                        <table id="datatable" class="table table-hover text-center" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="text-align: center; width: 1%"><input type="checkbox" class="select_all_" /></th>
                                    <!-- <th style="text-align: center">apartment id</th> -->
                                    <th style="text-align: center">Accnt</th>
                                    <th style="text-align: center">student</th>
                                    <th style="text-align: center">Hostel</th>
                                    <th style="text-align: center">amount payable</th>
                                    <th style="text-align: center">amount paid</th>
                                    <th style="text-align: center">balance</th>
                                    <th style="text-align: center">due date</th>
                                    <th style="text-align: center">month</th>
                                    <th style="text-align: center; width: 4%">Action</th>
                                </tr>
                            </thead>

                            <tfoot align="right">
                                <tr><th></th><th></th><th>Totals</th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <div id="feedback_bar"></div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="apartment_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div id="feedback_bar"></div>
<?php $this->load->view("partial/footer"); ?>


<script type="text/javascript">
    $(document).ready(function ()
    {
        var count_show = 0;

        var table = $("#datatable").DataTable({

            "columnDefs" : [{"targets" : [0, 9] , "orderable" : false},

                            {"targets" : [0], "visible" : false}

                            // {"targets" : [3, 4, 5, 9], "searchable" : false}

            ],

            "aLengthMenu": [[25, 50, 100, 200, -1], [25, 50, 100, 200, "All"]],

            "iDisplayLength": -1,

            "order": [],

            fixedHeader : true,

            buttons: [{

                extend:'pdf',

                download: 'open',

                text:' <span class="fa fa-print"></span> &nbsp; Print',

                className:'btn btn-sm btn-warning btn-sm',

                title: " ",

                footer : true,

                exportOptions: {

                    columns: [2, 3, 4, 5, 6, 8, 9]
                },

                orientation: 'portrait',

                customize: function(doc) {

                    doc.styles.tableHeader = {

                                            color : '#fff',

                                            fillColor : '#008080',

                                            margin : [5,5,5,5],

                                            fontSize : '8',

                                            alignment : 'center'

                                            };

                    doc.content[1].table.widths =  '*';

                    doc.content[1].layout = 'noBorders';

                    doc.styles.tableBodyOdd = { 

                                            margin : [5,5,5,5],

                                            fontSize : '8',

                                            border: 1,

                                            alignment : 'center'

                                            }                                           

                    doc.styles.tableBodyEven = { 

                                            fillColor : '#eee',

                                            margin : [5,5,5,5],                                         

                                            fontSize : '8',

                                            alignment : 'center'

                                            }

                    doc.defaultStyle.alignment = 'left';
                    
                    doc.styles.tableFooter = { 

                                            fillColor : '#fff',

                                            margin : [5,15,5,15],                                         

                                            fontSize : '8',

                                            bold : true,

                                            alignment : 'center'

                                            }

                    doc.content.splice(1, 0,                        
                        {
                            columns: [
                            {

                                image : '<?='data:image/'.pathinfo(base_url().'uploads/logo/letter_head.jpg',PATHINFO_EXTENSION).';base64,'.base64_encode(file_get_contents(base_url().'uploads/logo/letter_head.jpg')) ?>',

                                width: 60,

                                alignment : 'right'
                            },

                            {
                                text : "<?= $this->config->item('email') ?> \n <?= $this->config->item('website') ?> \n <?= $this->config->item('phone') ?> \n <?= $this->config->item('address')  ?> ",

                                bold : true,

                                fontSize : 9,

                                alignment : 'right'
                            }

                            ]
                        },

                        {
                             canvas: [{ type: 'line', x1: 0, y1: 0, x2: 515, y2: 0, lineWidth: 0.5 }]
                        },

                        {

                        columns: [

                            {text : "Delayed apartments", margin : 7, fontSize : 9 },

                            {text : "Printed by : <?=ucfirst($user_info->first_name) ?>", alignment: 'right', margin : 7, fontSize : 9}

                            ]

                        },

                        {
                             canvas: [{ type: 'line', x1: 0, y1: 0, x2: 515, y2: 0, lineWidth: 0.5 }]
                        },

                        {   
                            margin : 10,

                            fontSize : 8,

                            text: "This document is a summary of <?=$this->config->item('company') ?> apartments whose payments have been delayed just as they appear in the company's computer system",

                            alignment: 'center'
                        },

                        {
                            text : "",

                            margin : 10

                        }
                    );

                    // Create a footer

                    doc['footer']=(function(page, pages) {

                        return {                           
                            

                            columns: [

                                {
                                    text : '© apam <?=date("Y") ?>',

                                    alignment : 'left'
                                },

                                {
                                    alignment: 'center',

                                    width: 100,

                                    text: ['page ', { text: page.toString() },  ' of ', { text: pages.toString() }]
                                },

                                {
                                    // This is the right column
                                    text : '<?=date("D, d M Y H:i:s") ?>',

                                    alignment : 'right'
                                }
                            ],

                            canvas: [{ type: 'line', x1: 100, y1: 0, x2: 455, y2: 0, lineWidth: 0.5 }],

                            fontSize : '8',

                            margin: [70, 0, 70, 0]
                        }
                    });

                }  

                }

            ],

            "dom": "<'row'<'col-sm-4 text-left'l><'col-sm-4 text-center'B><'col-sm-4 text-right'f>>" + "<'row padded'<'col-sm-12'tr>>" + "<'row'<'col-sm-5 text-left'i><'col-sm-7 text-right'p>>",

            footerCallback: function ( row, data, start, end, display ) {
            var api = this.api();

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                //console.log(i.toString().replace(/[\Ksh.,]/g, ''))
                return typeof i === 'string' ?
                    i.replace(/[\ksh.,]/g, '')*1 : typeof i === 'number' ?  i : 0;
                         
            };
  
            // apartment Totals
 
                if (api.column(5).data().length){
                var apartmentTotal = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                return intVal(a) + intVal(b);
                } ) }
                else{ total = 0};

            //Balance Totals
                if (api.column(4).data().length){
                var balanceTotal = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                return intVal(a) + intVal(b);
                } ) }
                else{ total = 0};

            //Penalty Totals
                if (api.column(8).data().length){
                var penaltyTotal = api
                .column( 8, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                return intVal(a) + intVal(b);
                } ) }
                else{ total = 0};
                 
  
            // apartments
            $( api.column(5).footer() ).html(
                "Ksh." +apartmentTotal
            );

            // Balance
            $( api.column(4).footer() ).html(
                "Ksh." +balanceTotal
            );

            // // Penalty
            // $( api.column(8).footer() ).html(
            //     "Ksh." + penaltyTotal
            // );
        }
        });

        $.get("<?=base_url() ?>index.php/overdues/data", function(data){

            // console.log(data);

            table.clear() //clear content

            var obj = JSON.parse(data);

            $('#overdue_count').text(obj.length);

            table.rows.add(obj)

           table.draw() //update display

        }); 

        enable_delete('Are you sure to delete?', 'Please select items to delete!');

        $(".select_all_").click(function ()
        {
            if ($(this).is(":checked"))
            {
                $("input[name='chk[]']").prop("checked", true);
            }
            else
            {
                $("input[name='chk[]']").prop("checked", false);
            }
        });

    });

    function post_apartment_form_submit(response)
    {
        if (!response.success)
        {
            set_feedback(response.message, 'error_message', true);
        }
        else
        {
            set_feedback(response.message, 'success_message', false);
            $('#datatable').dataTable()._fnAjaxUpdate();
            $('#apartment_modal').modal("hide");
        }
    }
</script>