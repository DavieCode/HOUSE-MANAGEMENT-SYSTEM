<?php $this->load->view("partial/header"); ?>
<style>
    table#datatable td:nth-child(2),
    td:nth-child(7), 
    td:nth-child(9) {
        white-space: nowrap;
        text-align: center;
    }
</style>


<div class="row">
    <div class="col-lg-12">

        <div class="inqbox float-e-margins">
            <div class="inqbox-title border-top-success">
                <h5>
                   Payments list
                </h5>
                <div class="inqbox-tools">

                    <?= anchor("$controller_name/view/-1", "<span class='fa fa-plus-circle'></span> &nbsp; New payment", array('id' => 'new', 'class' => 'btn btn-sm btn-sm btn-info', 'style' => 'color:white;margin-right:10px;')); ?>

                    <?php if($user_info->role == "mgmt") echo anchor("$controller_name/delete", '<span class="fa fa-trash"></span> &nbsp; Delete </span>', array('id' => 'delete', 'class' => 'btn btn-sm btn-sm btn-danger', 'style' => 'color:white;')); ?>

                </div>
            </div>
            <div class="inqbox-content table-responsive">

                <table id="datatable" class="table table-hover text-center" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="text-align: center; width: 1%"><input type="checkbox" class="select_all_" /></th>
                            <th style="text-align: center">Payment id</th>
                            <th style="text-align: center" title="tenant account number">Acc.</th>
                            <th style="text-align: center" title="tenant Names">student</th>
                            <th style="text-align: center" title="apartment">hostel</th>                    
                            <th style="text-align: center" title="Amount paid">Amount</th>                    
                            <th style="text-align: center" title="Paid by">Paid By</th>
                            <th style="text-align: center" title="Payment breakdown">Info</th>
                            <th style="text-align: center" title="Date Paid">Date</th>
                            <th style="text-align: center" title="Payment Method">Method</th>
                            <th style="text-align: center; max-width: 6%">Action</th>
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


<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript">
    $(document).ready(function ()
    {
        var table = $("#datatable").DataTable({

            "columnDefs" : [

                {"targets" : [0, 10] , "orderable" : false},

                {"targets" : [1], "visible": false},

                {"targets" : [1, 4, 5, 6], "searchable" : false}

            ],

            fixedHeader : true,

            "aLengthMenu": [[25, 50, 100, 200, -1], [25, 50, 100, 200, "All"]],

            "iDisplayLength": -1,

            "order": [],

            buttons: [{

                extend:'pdf',

                download: 'open',

                text:' <span class="fa fa-print"></span> &nbsp; Print',

                className:'btn btn-sm btn-warning btn-sm',

                title: " ",

                footer : true,

                exportOptions: {

                    columns: [2, 3, 4, 5, 6, 8]
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

                            {text : "Payments", margin : 7, fontSize : 9 },

                            {text : "Printed by : <?=ucfirst($user_info->first_name) ?>", alignment: 'right', margin : 7, fontSize : 9}

                            ]

                        },

                        {
                             canvas: [{ type: 'line', x1: 0, y1: 0, x2: 515, y2: 0, lineWidth: 0.5 }]
                        },

                        {   
                            margin : 10,

                            fontSize : 8,

                            text: "This document is a summary of <?=$this->config->item('company') ?> apartment payments that have been made just as they appear in the company's computer system",

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


            //Amount Totals
                if (api.column(5).data().length){
                var amountTotal = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                return intVal(a) + intVal(b);
                } ) }
                else{ total = 0};

                 
            // Amount
            $( api.column(5).footer() ).html(
                'Ksh. '+ amountTotal
            );
        }
        });

        $.get("<?=base_url() ?>index.php/payments/data", function(data){


            table.clear() //clear content

            var obj = JSON.parse(data);

            //console.log(obj)

            table.rows.add(obj)

           table.draw() //update display

        });  
        
        enable_delete('Are you sure to delete?', 'Please select a record to delete!');

        $(".select_all_").click(function () {
            if ($(this).is(":checked"))
            {
                $("input[name='chk[]']").prop("checked", true);
            }
            else
            {
                $("input[name='chk[]']").prop("checked", false);
            }
        });

        <?php if(isset($pdf_file)){ ?>

            alertify.confirm( "Payment receipt", "<span style='font-size:40px;position:absolute;top:55px' class='lnr lnr-checkmark-circle'></span> <span style='margin-left:55px'>Your file has been saved. Would you like to view it?</span>",

              function(){

                window.open("<?=$pdf_file ?>", "_blank");

                //alertify.success('Yes');

              },
              function(){

                window.location.href='index.php/payments';
                //alertify.error('No');

              }).set('labels', {ok:'Yes', cancel:'No'});;

        <?php } ?>

    });
</script>
