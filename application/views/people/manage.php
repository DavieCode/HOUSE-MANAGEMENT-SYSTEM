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
            <div class="inqbox-title">
                <h5>
                    STUDENTS' DATA
                </h5>
                <div class="inqbox-tools">

                    <?= anchor("$controller_name/view/-1", "<span class='fa fa-plus-circle'></span> &nbsp; New Student", array('id' => 'new', 'style'=> 'color:white', 'class' => 'btn btn-sm btn-info btn-sm')); ?>


                    <?php if($user_info->role == "mgmt") echo anchor("$controller_name/delete", '<span class="fa fa-times"></span> &nbsp; Delete </span>', array('id' => 'delete', 'style'=> 'color:white', 'class' => 'btn btn-sm btn-danger btn-sm')); ?>

                </div>
            </div>
            <div class="inqbox-content table-responsive">

                <table id="datatable" class="table table-hover table- text-center table-responsive">
                    <thead>
                        <tr>
                            <th style="text-align: center; width: 1%"><input type="checkbox" class="select_all" /></th>
                            <th style="text-align: center">Last_name</th>
                            <th style="text-align: center">First_name</th>
                            <th style="text-align: center">ID/Passport</th>
                            <th style="text-align: center">Email</th>
                            <th style="text-align: center">Phone</th>
                            <th style="text-align: center">Home_address</th>
                            <th style="text-align: center">Status</th>
                            <th style="text-align: center; width: 8%">action</th>
                        </tr>
                    </thead>

                </table>

            </div>
        </div>
    </div>
</div>

<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript">


    $(document).ready(function ()
    {
        enable_delete('Are you sure to delete?', 'Please select an item to delete!');

        var table = $("#datatable").DataTable({

            fixedHeader : true,

            "columnDefs" : [{"targets" : [0, 7] , "orderable" : false}],

            "aLengthMenu": [[25, 50, 100, 200, 100000], [25, 50, 100, 200, "All"]],

            "iDisplayLength": 25,

            "order": [1, "asc"],

            buttons: [{

                extend:'pdf',

                download: 'open',

                text:' <span class="fa fa-print"></span> &nbsp; Print',

                className:'btn btn-sm btn-warning btn-sm', 

                autoPrint : true,

                title : " ",

                footer : true,

                exportOptions: {

                    columns: [1,2, 3, 4, 5, 6]
                },

                orientation: 'portrait',

                customize: function(doc) {

                    // doc.pageMargins = [70, 30, 70, 50];

                    doc.styles.tableHeader = {

                                            color : '#fff',

                                            fillColor : '#008080',

                                            margin : [5,5,5,5],

                                            fontSize : '8',

                                            alignment : 'center'

                                            };

                    doc.content[1].table.widths =  [50, '*', '*', 60, 60, '*'];

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

                            {text : "tenants", margin : 7, fontSize : 9 },

                            {text : "Printed by : <?=ucfirst($user_info->first_name) ?>", alignment: 'right', margin : 7, fontSize : 9}

                            ]

                        },

                        {
                             canvas: [{ type: 'line', x1: 0, y1: 0, x2: 515, y2: 0, lineWidth: 0.5 }]
                        },

                        {   
                            margin : 10,

                            fontSize : 8,

                            text: "This document is a summary of all <?=$this->config->item('company') ?> tenants that have been registered into the company's computer system",

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

            "dom": "<'row'<'col-sm-4 text-left'l><'col-sm-4 text-center'B><'col-sm-4 text-right'f>>" + "<'row padded'<'col-sm-12'tr>>" + "<'row'<'col-sm-5 text-left'i><'col-sm-7 text-right'p>>"
        });

        $.get("<?=base_url() ?>index.php/tenants/data", function(data){


            table.clear() //clear content

            var obj = JSON.parse(data);

            //console.log(obj)

            table.rows.add(obj)

           table.draw() //update display

        });

        // selecting all
        $(".select_all").click(function () {
            if ($(this).is(":checked"))
            {
                $("input[name='chk[]']").prop("checked", true);
            } else
            {
                $("input[name='chk[]']").prop("checked", false);
            }
        });

    });


</script>