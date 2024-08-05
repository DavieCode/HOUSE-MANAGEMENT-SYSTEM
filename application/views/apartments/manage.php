<?php $this->load->view("partial/header"); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="inqbox float-e-margins">
            <div class="inqbox-title " style="background: linear-gradient(90deg, #e9573f, gold); color: white;">
                <h5>
                    Hostels' SUMMARY
                </h5>
                <div class="inqbox-tools">

                    <?php
                    echo anchor("$controller_name/view/-1", "<span class='fa fa-plus-circle'></span> &nbsp; New hostel", array('id' => 'new', 'class' => 'btn btn-sm btn-success btn-sm', 'title' => 'New apartment' , 'style'=> 'color:#fff'));
                    ?>

                    <!-- <a href="index.php/overdues" title="Delayed lons" id="overdue" class="btn btn-sm btn-info btn-sm" style="color:white"><?= "Delayed (" . $count_overdues . ")" ?></a> -->

                    <?php if($user_info->role == "mgmt") echo anchor("$controller_name/delete", "<span class='fa fa-times'></span> &nbsp; Delete </span>", array('id' => 'delete', 'title' => 'Delete apartment(s)', 'class' => 'btn btn-sm btn-danger btn-sm', 'style'=> 'color:#fff')); ?>

                </div>
            </div>
            <div class="inqbox-content table-responsive">

                <div class="row table-body">
                    <div class="col-md-12">
                        <table id="datatable" class="table table-hover text-center" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="text-align: center; width: 1%"><input type="checkbox" class="select_all_" /></th>
                                    <th style="text-align: center">Apartment id</th>
                                    <th style="text-align: center">Hostel Name</th>
                                    <th style="text-align: center">Description</th>
                                    <th style="text-align: center">Date Added</th>
                                    <th style="text-align: center; width: 1%">Action</th>
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
    $(document).ready(function ()
    {
        var count_show = 0;

        $('body').on('hidden.bs.modal', '.modal', function () {
            $(this).removeData('bs.modal');
            count_show = 0;
        });

        var table = $("#datatable").DataTable({

            "columnDefs" : [{"targets" : [0, 5] , "orderable" : false},

                            {"targets" : [0,1, 4, 5], "searchable": false},

                            {"targets" : [1], "visible": false}],

            "aLengthMenu": [[25, 50, 100, 200, -1], [25, 50, 100, 200, "All"]],

            "iDisplayLength": -1,

            fixedHeader : true,

            "order": [],

            buttons: [{

                extend:'pdf',

                download: 'open',

                text:' <span class="fa fa-print"></span> &nbsp; Print',

                className:'btn btn-sm btn-warning btn-sm',

                title: " ",

                footer : true,

                exportOptions: {

                    columns: [2, 3, 5, 6, 7, 8, 9, 10]
                },

                orientation: 'landscape',

                customize: function(doc) {

                    doc.pageMargins = [70, 30, 70, 50];

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

                    doc.styles.tableFooter = { 

                                            fillColor : '#fff',

                                            margin : [5,15,5,15],                                         

                                            fontSize : '8',

                                            bold : true,

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
                             canvas: [{ type: 'line', x1: 0, y1: 0, x2: 700, y2: 0, lineWidth: 0.5 }]
                        },

                        {

                        columns: [

                            {text : "apartments", margin : 7, fontSize : 9 },

                            {text : "Printed by : <?=ucfirst($user_info->first_name) ?>", alignment: 'right', margin : 7, fontSize : 9}

                            ]

                        },

                        {
                             canvas: [{ type: 'line', x1: 0, y1: 0, x2: 700, y2: 0, lineWidth: 0.5 }]
                        },

                        {   
                            margin : 10,

                            fontSize : 8,

                            text: "This document is a summary of <?=$this->config->item('company') ?> apartments that have been awarded as they appear in the company's computer system",

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

                },

                {
                    extend: 'collection',

                    text:' <span class="fa fa-filter"></span> &nbsp; Filter ',

                    className:'btn btn-sm btn-success btn-sm apartments_filter',

                    buttons: [
                        
                        {
                            text: '<span class="fa fa-check"></span> &nbsp; All apartments',

                            className:'btn btn-sm btn-info btn-sm all-apartments',

                            action: function ( e, dt, node, config ) {

                                table.data().columns(10).search('').draw(); 

                                $('.all-apartments').html("<span class='fa fa-check'></span> &nbsp; All apartments");

                                $('.active-apartments').html("Active apartments");

                                //dt.column( -1 ).visible( ! dt.column( -1 ).visible() );
                            }
                        },
                        {
                            text: 'Active apartments',

                            className:'btn btn-sm btn-info btn-sm active-apartments',

                            action: function ( e, dt, node, config ) {

                                table.data().columns(10).search('unpaid|on payment', true, false, true).draw(); 

                                $('.active-apartments').html("<span class='fa fa-check'></span> &nbsp; Active apartments");

                                $('.all-apartments').html("All apartments");

                                //dt.column( -1 ).visible( ! dt.column( -1 ).visible() );
                            }
                        }
                    ]
                }
            ],

                "dom": "<'row'<'col-sm-4 text-left'l><'col-sm-4 text-center'B><'col-sm-4 text-right'f>>" + "<'row padded'<'col-sm-12'tr>>" + "<'row'<'col-sm-5 text-left'i><'col-sm-7 text-right'p>>"
        });

        function getAll() {

            $.get("<?=base_url() ?>index.php/apartments/data", function(data){

                table.clear() //clear content

                // console.log(data)

                var obj = JSON.parse(data);

                table.rows.add(obj)

               table.draw() //update display

            });
        }

        getAll();

        <?php if(isset($pdf_file)){ ?>

            alertify.confirm( "apartment statement", "<span style='font-size:40px;position:absolute;top:55px' class='lnr lnr-checkmark-circle'></span> <span style='margin-left:55px'>Your file has been saved. Would you like to view it?</span>",

              function(){

                window.open("<?=$pdf_file ?>", "_blank");

                //alertify.success('Yes');

              },
              function(){

                window.location.href='index.php/apartments';
                //alertify.error('No');

              }).set('labels', {ok:'Yes', cancel:'No'});;

        <?php } ?>

        $(document).on("change", "#sel-staff", function(){
            location.href = "<?=site_url($this->uri->segment(1))?>?staff_id=" + $(this).val();
        });
        
        enable_delete('Are you sure to delete?', 'Please select an item to delete!');

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