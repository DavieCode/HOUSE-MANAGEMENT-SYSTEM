<?php $this->load->view("partial/header"); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="inqbox float-e-margins">
            <div class="inqbox-title border-top-success">
                <h5>
                    Letters summary
                </h5>
                <div class="inqbox-tools">

                    <?php
                    echo anchor("$controller_name/view/-1", "<span class='fa fa-plus-circle'></span> &nbsp; New Letter", array('id' => 'new', 'class' => 'btn btn-sm btn-info btn-sm', 'title' => 'New Expense' , 'style'=> 'color:#fff'));
                    ?>

                    <?php if($user_info->role == "mgmt") echo anchor("$controller_name/delete", "<span class='fa fa-times'></span> &nbsp; Delete </span>", array('id' => 'delete', 'title' => 'Delete expense(s)', 'class' => 'btn btn-sm btn-danger btn-sm', 'style'=> 'color:#fff')); ?>

                </div>
            </div>
            <div class="inqbox-content table-responsive text-center">

                <div class="row table-body">
                    <div class="col-md-12">
                        <table id="datatable" class="table table-hover text-center" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="text-align: center; width: 1%"><input type="checkbox" class="select_all_" /></th>
                                    <th style="text-align: center;">Ref.</th>
                                    <th style="text-align: center">Receiver</th>
                                    <th style="text-align: center">Subject</th>
                                    <th style="text-align: center; width: 50%">Message</th>
                                    <th style="text-align: center">Created by</th>
                                    <th style="text-align: center">Date</th>
                                    <th style="text-align: center; width: 5%">Action</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>

            </div>
        </div>
        <div id="feedback_bar"></div>
    </div>
</div>

<div id="feedback_bar"></div>
<?php $this->load->view("partial/footer"); ?>


<script type="text/javascript">

    $(document).ready(function ()    {

       var table = $("#datatable").DataTable({

            "columnDefs" : [

                {"targets" : [ 7,0,1] , "orderable" : false},

                {"targets" : [4] , "visible" : false}

            ],

            
            "fixedHeader": true,

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

                    columns: [2, 3, 5, 6]
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

                            {text : "Letters", margin : 7, fontSize : 9 },

                            {text : "Printed by : <?=ucfirst($user_info->first_name) ?>", alignment: 'right', margin : 7, fontSize : 9}

                            ]

                        },

                        {
                             canvas: [{ type: 'line', x1: 0, y1: 0, x2: 515, y2: 0, lineWidth: 0.5 }]
                        },

                        {   
                            margin : 10,

                            fontSize : 8,

                            text: "",

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

        });

        $.get("<?=base_url() ?>index.php/letters/data", function(data){


            // console.log(data)

            table.clear() //clear content

            var obj = JSON.parse(data);

            table.rows.add(obj)

           table.draw() //update display

        });
        
        enable_delete('Are you sure to delete?', 'Please select something to delete!');

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

    });

</script>