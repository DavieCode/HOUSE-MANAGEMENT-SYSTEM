
<?php $this->load->view("partial/header"); ?>

<!-- moment js - required for the calendar plugs to work -->

<script type="text/javascript" src="js/fullcalendar/moment.min.js"></script>

<!-- full calendar -->

<link rel="stylesheet" type="text/css" href="css/plugins/fullcalendar/fullcalendar.css">

<script type="text/javascript" src="js/fullcalendar/fullcalendar.min.js"></script>

<!-- date range picker -->

<link rel="stylesheet" type="text/css" href="plugins/date_range_picker/daterangepicker.css">

<script type="text/javascript" src="plugins/date_range_picker/daterangepicker.js"></script>
<div class="row" style="padding-top: 20px">

    <div class="col-lg-5" style="margin-bottom: 15px">

        <div class="border-top border-success">
        
            <div class="float-e-margins-home col-sm-6">

                <div class="inqbox-content container-fluid" style="padding-bottom: 10px;">

                    <div class="row container-fluid">

                        <h3 class="no-margins text-success" style="font-size: 1.5em"><span class=" p_total"><?= to_currency($payments, true, 0); ?></span>

                        <i class="lnr lnr-checkmark-circle text-success pull-right" style="font-size: 1.5em;"></i></h3>

                        <small>Total payments</small>

                    </div>

                    <div class="row no-margins" style="padding-top: 10px;">                        

                        <span class="dropdown badge" style="background: transparent;" title="More Info.">

                            <span class="dropdown-toggle fa fa-plus-circle text-success" style="font-size: 13px; position: absolute;top: -3.5px" data-toggle="dropdown" aria-expanded="true">
                            </span>

                            <ul class="dropdown-menu m-t-xs" style="border-radius: 0px; pointer-events: none;z-index: 2002">

                                <li><a href="#"><strong>Payment summary</a></strong></li>

                                <li class="divider"></li>

                                <li><a href="#" class="p_brkdn_p">Principal : <?=to_currency($breakdown->principal, true, 0) ?></a></li>

                                <li><a href="#" class="p_brkdn_i">Interest : <?=to_currency($breakdown->interest, true, 0) ?></a></li>

                                <li><a href="#" class="p_brkdn_pen">Penalty : <?=to_currency($breakdown->penalty, true, 0) ?></a></li>

                                <li><a href="#" class="p_brkdn_r">Appraisal : <?=to_currency($breakdown->renewal, true, 0) ?></a></li>

                            </ul>

                        </span>

                        <span class="p_increase stat-percent   text-info"><?=$payment_increase ?></span>

                    </div>
                </div>
            </div>

            <div class="float-e-margins-home col-sm-6" style="padding-left: 1px !important">         
                
                <div class="inqbox-content container-fluid" style="padding-bottom: 10px;">

                    <div class="row container-fluid">

                        <h3 class="no-margins text-warning" style="font-size: 1.5em;"><span class="e_total"><?= to_currency($expenses, true, 0); ?></span>

                        <i class="lnr lnr-circle-minus text-warning pull-right" style="font-size: 1.5em;"></i></h2>

                        <small>Total expenses</small>

                    </div>

                    <div class="row container-fluid no-margns" style="padding-top: 10px;">                        

                        <span class="dropdown badge" style="background: transparent;" title="More Info.">

                            <span class="dropdown-toggle fa fa-plus-circle text-warning" style="font-size: 13px; position: absolute;top: -3.5px" data-toggle="dropdown" aria-expanded="true">
                            </span>

                            <ul class="dropdown-menu m-t-xs e_brkdn" style="border-radius: 0px; pointer-events: none;z-index: 2002">

                            </ul>

                        </span>

                        <span class="e_increase stat-percent   text-info"><?=$expense_increase ?></span>

                    </div>
                </div>
            </div> 
            
            <div class="float-e-margins-home col-sm-6">

                <div class="inqbox-content container-fluid" style=" padding-bottom: 10px;">

                    <div class="row container-fluid">

                        <h3 class="no-margins text-danger" style="font-size: 1.5em;"><span class=" l_total"><?=$hostels_count; ?></span>

                        <i class="lnr lnr-briefcase text-danger pull-right" style="font-size: 1.5em;"></i></h3>

                        <small>Total Hostels</small>

                    </div>

                    <div class="row no-margins" style="padding-top: 10px;">                        

                        <span class="lnr lnr-apartment stat-percent text-info"></span>

                    </div>
                </div>
            </div>   

            <div class="float-e-margins-home col-sm-6" style="padding-left: 1px !important">

                <div class="inqbox-content container-fluid" style=" padding-bottom: 10px;">

                    <div class="row container-fluid">

                        <h3 class="no-margins text-info" style="font-size: 1.5em"><span class="income"><?= to_currency($income, true, 0); ?></span>

                        <i class="lnr lnr-arrow-up-circle text-info pull-right" style="font-size: 1.5em;"></i></h3>

                        <small>Total profit</small>

                    </div>

                    <div class="row container-fluid no-margns text-right" style="padding-top: 10px;">

                        <span class="lnr lnr-leaf text-right text-info"></span>

                    </div>
                </div>
            </div>

        </div>        
    </div>
    
    <div class="col-lg-3">

        <div class="border-top border-info">
            
            <div class="float-e-margins-home">

                <div class="inqbox-content container-fluid" style="padding-bottom: 10px;">

                    <div class="row container-fluid text-center">

                        <h4>RANGE REPORT</h4>

                        <hr style="width: 20px; margin: 1em auto">

                        <p class="text-center"><span class="duration"></span> statistics.</p>

                        <div style="padding: 1em 0">
                            
                            <span class="" style="background: transparent;" title="Date Range values">

                                <a class="dropdown"></a>

                                <span class="dropdown-toggle btn btn-sm btn-info btn-sm" style="border-radius: 30px !important; padding: .3em 1em; margin-right: 5px" data-toggle="dropdown" aria-expanded="true">Duration
                                </span>

                                <ul class="dropdown-menu m-t-xs" style="border-radius: 0px; margin-top: -50px; pointer-events: none;z-index: 2002">

                                    <li><a class="range-values" href="#">Weekly</a></li>

                                </ul>

                            </span>

                            <a class="btn btn-sm btn-warning btn-sm print_report" style="border-radius: 30px !important; padding: .3em 1em" href="#"> <span class="fa fa-print"></span> &nbsp; Print</a>

                        </div>

                    </div>

                    <div class="row no-margins" style="padding-top: 10px;">

                        <span class="lnr lnr-highlight text-info"></span>

                        <span class="lnr lnr-highlight stat-percent text-info"></span>

                    </div>
                </div>
            </div>

        </div>        
    </div>
    
    <div class="col-lg-4">

        <div class="border-top border-warning">

            <div class="col-xs-6 float-e-margins-home">
            
                <div class="float-e-margins-home">

                    <div class="inqbox-content container-fluid" style="padding-bottom: 10px;">

                        <div class="row container-fluid">

                            <h3 class="no-margins text-success" style="font-size: 1.4em"><span><?=$this->tenant->count_all() ?></span>

                            <i class="lnr lnr-smile text-success pull-right" style="font-size: 1.4em;"></i></h3>

                            <small>student count</small>

                        </div>
                    </div>
                </div>

                <div class="float-e-margins-home">         
                    
                    <div class="inqbox-content container-fluid" style="padding-bottom: 10px;">

                        <div class="row container-fluid">

                            <h3 class="no-margins text-warning" style="font-size: 1.4em;"><span><?=$this->staff->count_all() ?></span>

                            <i class="lnr lnr-user text-warning pull-right" style="font-size: 1.4em;"></i></h2>

                            <small>Staff members</small>

                        </div>
                    </div>
                </div> 
                
                <div class="float-e-margins-home">

                    <div class="inqbox-content container-fluid" style=" padding-bottom: 10px;">

                        <div class="row container-fluid">

                            <h3 class="no-margins text-danger" style="font-size: 1.4em;"><span><?=$hostels_count; ?></span>

                            <i class="lnr lnr-unlink text-danger pull-right" style="font-size: 1.4em;"></i></h3>

                            <small>Saved Hostels</small>

                        </div>
                    </div>
                </div> 
            </div>  

            <div class="float-e-margins-home col-xs-6" style="padding-left: 1px !important">

                <div class="inqbox-content container-fluid" style="padding: 6.5px">
                    
                    <div class="leftpanel-profile" style="color: #e9573f; background: white;">

                        <div class="text-center">
                            <a href="#" style="pointer-events: none;">
                                <?php if (trim($user_info->photo_url) !== "" && file_exists( FCPATH  .  "/uploads/profile-" . $user_info->person_id . "/" . $user_info->photo_url ) ):  ?>
                                <img src="<?= base_url("uploads/profile-" . $user_info->person_id . "/" . $user_info->photo_url); ?>" style="width:75px;height:75px; border-color: #e9573f" alt="" class="media-object img-circle" />
                                <?php else: ?>
                                <img src="imgs/user.png" style="width:75px;height:75px; border-color: #e9573f"  alt="" class="media-object img-circle" />
                                <?php endif; ?>
                            </a>
                        </div>
                        <div class="text-center" style="white-space:wrap;">

                            <h4 class="text-success elipsize"><?= ucwords($user_info->first_name); ?> <?= ucwords($user_info->last_name); ?></h4>

                            <a class="btn btn-sm btn-danger btn-sm" style="margin-top: 4px; border-radius: 30px !important; padding: .3em 1.5em" href="<?= site_url("home/logout")?>">LOGOUT</span></a>
                            
                        </div>
                    </div>
                </div>
            </div>

        </div>        
    </div>

    <div class="col-lg-12 row row-flex" style="display: flex; flex-wrap: wrap;">
    
        <div class="col-lg-8 container-fluid" style="margin-bottom: 2em;">
            <div class="inqbox float-e-margins-home" style="background: rgba(250,255,250,.8); min-height: 100%; border-radius: 5px;">
                <div class="inqbox-content"  style="background: transparent; color: #e9573f">

                    <canvas id="myChart" width="320px" height="160px"></canvas>
                    
                </div>
            </div>
        </div>
        
        <div class="col-lg-4" style="margin-bottom: 2em">
            <div class="inqbox float-e-margins-home">
                <div class="inqbox-title" style="background: rgba(26,179,148,.8) !important;color: white">
                    <h5>DAILY STATISTICS</h5>
                </div>
                <div class="inqbox-content">

                    <h4 class="text-center text-success current_date"><?=date('d M, Y', time()) ?></h4>           

                    <style type="text/css">.table tbody tr td{height: 40px !important;vertical-align: middle;}</style>

                        <br><canvas id="myPiChart" width="50px" height="30px"></canvas>

                        <div id="pie_legend"></div>
                    
                </div>
            </div>
        </div>
    </div>

    <hr class="container" style="border-style: none; ">


    <?php if($user_info->role === "mgmt"){ ?>

<div class="row container" style="margin-top: 2em;">
    
    <div class="col-lg-6" style="margin-bottom: 15px">

        <div class="border-top border-success">
            
            <div class="float-e-margins-home col-sm-6" style="border-right: 2px solid #eee">

                <div class="inqbox-content container-fluid" style="padding-bottom: 10px;">

                    <div class="row container-fluid">

                        <h3 class="no-margins text-warning" style="font-size: 1.5em;"><span class="expenditure"><?= to_currency($expenses, true, 0); ?></span>

                        <i class="lnr lnr-briefcase text-warning pull-right" style="font-size: 1.5em;"></i></h3>

                        <small>Total Expenses</small>

                    </div>

                    <div class="row no-margins" style="padding-top: 10px;">                        

                        <span class="text-warning lnr lnr-highlight" ></span>

                        <span class="text-warning lnr lnr-highlight pull-right"></span>

                    </div>
                </div>
            </div>   
            
            <div class="float-e-margins-home col-sm-6">

                <div class="inqbox-content container-fluid" style="padding-bottom: 10px;">

                    <div class="row container-fluid">

                        <h2 class="no-margins text-success" style="font-size: 1.5em;"><span class="profit"><?= to_currency($income, true, 0); ?></span>

                        <i class="lnr lnr-checkmark-circle text-success pull-right" style="font-size: 1.5em;"></i></h2>

                        <small>Total Profit</small>

                    </div>

                    <div class="row no-margins" style="padding-top: 10px;">                        

                        <span class="text-info lnr lnr-highlight text-success" ></span>

                        <span class="text-info lnr lnr-highlight pull-right"></span>

                    </div>
                </div>
            </div> 
        </div>        
    </div>

    <?php $backup_date = json_decode(file_get_contents(base_url().'backup_logs.json'))[0]->time_stamp ?>

    <div class="col-lg-3">

         <div class="inqbox-content container-fluid border-top border-danger" style=" padding-bottom: 10px;">

            <div class="row container-fluid">

                <h2 class="no-margins text-danger" style="font-size: 1.5em;"><span class=""><?=date('d F, Y', $backup_date) ?></span>

                <i class="lnr lnr-calendar-full text-danger pull-right" style="font-size: 1.5em;"></i></h2>

                <small>Lastest Backup</small>

            </div>

            <div class="row no-margins" style="padding-top: 10px;">                        

                <span class="text-warning lnr lnr-highlight" ></span>

                <span class="text-warning lnr lnr-highlight pull-right"></span>

            </div>
        </div>
    </div>

    

</div>

    <?php } ?>

<?php $this->load->view('partial/footer'); ?>

</div>


<script type="text/javascript">
    
    $(document).ready(

    function() {

        var start = moment().subtract(7, 'days');
        var end = moment();

        var label = "weekly";

        function cb(start, end, label) {

            // console.log(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));

            $(".range-values").html(start.format('DD MMMM YYYY') + ' - ' + end.format('DD MMMM YYYY'));

            start = start.format('YYYY-MM-DD');

            end = end.format('YYYY-MM-DD'); 

            $(".print_report").attr("href", "index.php/home/printIt/"+ start + "/" + end + "/" + "report");

            updateStats(start, end, label);
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            maxDate: moment(),
            ranges: {
               // 'Today': [moment(), moment()],
               'weekly': [moment().subtract(1, 'week'), moment()],
               'Monthly': [moment().subtract(1, 'month'), moment()],
               'Quaterly': [moment().subtract(3, 'month'), moment()],
               'Semi-annualy': [moment().subtract(6, 'month'), moment()],
               'Annualy': [moment().subtract(12, 'month'), moment()]
            }
        }, cb);

        cb(start, end, label);

        getStats();
        
        $('#calendar').fullCalendar({

            defaultView: 'month',

            dayClick: function (date, allDay, jsEvent, view) {

                if ($(this).hasClass('fc-future') == false) {

                    // alert("Thats a future date!");

                    $(".fc-state-highlight").removeClass("fc-state-highlight");

                    $("td[data-date="+date.format('YYYY-MM-DD')+"]").addClass("fc-state-highlight");

                    var maxDate = "<%= finish.strftime('%Y/%m/%d') %>";

                    var currentDate = $(this).data("date");

                    // console.log(currentDate);

                    getStats(currentDate);
                }
                
            }

        });

        <?php if(isset($pdf_file)){ ?>

            alertify.confirm( "General Report", "<span style='font-size:40px;position:absolute;top:55px' class='lnr lnr-checkmark-circle'></span> <span style='margin-left:55px'>Your report has been created. Would you like to view it?</span>",

              function(){

                window.open("<?=$pdf_file ?>", "_blank");

                //alertify.success('Yes');

              },
              function(){

                window.location.href='index.php/home';
                //alertify.error('No');

              }).set('labels', {ok:'Yes', cancel:'No'});;

        <?php } ?>

    });

    function getStats(timeStamp){

        $.get("index.php/home/getStats/" + timeStamp, function(response){

            // console.log(response);

            $results = JSON.parse(response);

            $(".current_date").html($results['date']);

            $(".stats").html($results['data']);
        });


    }
                    
    function updateStats(startDate, endDate, label) {

        $.get("index.php/home/index/" + startDate + "/" + endDate + "/" + label, function(response){

            console.log(response);

            // console.log("Hello world");

            $results = JSON.parse(response);

            console.log($results)

            // var payment_brkdn = $results['payment_breakdown'];

            // var expense_brkdn = $results['expense_breakdown'];

            // // UPDATE DATA

            // $(".duration").html($results['duration']);

            // $(".p_total").html($results['payments']);

            // $(".p_increase").html($results['payment_increase']);

            // $(".l_total").html($results['total_apartments']);

            // $(".l_increase").html($results['apartment_increase']);

            // $(".e_total").html($results['expense']);

            // $(".e_increase").html($results['expense_increase']);

            // $(".income").html($results['income']);

            // $(".expenditure").html($results['expenditure']);

            // $(".profit").html($results['profit']);

            // //POPULATE PAYMENT BREAKDOWN

            // $(".p_brkdn_p").html("Principal : " + payment_brkdn['principal']);

            // $(".p_brkdn_i").html("Interest : " + payment_brkdn['interest']);

            // $(".p_brkdn_pen").html("Penalty : " + payment_brkdn['penalty']);

            // $(".p_brkdn_r").html("Appraisal : " + payment_brkdn['renewal']);

            // //POPULATE EXPENSE BREAKDOWN

            // var e_brkdn = '<li><a href="#"><strong>Expense summary</a></strong></li><li class="divider"></li>';

            // for (var i = expense_brkdn.length - 1; i >= 0; i--) {

            //     // console.log(i + ':' + expense_brkdn[i]);

            //     e_brkdn += '<li><a href="#">'+ expense_brkdn[i][0] +' : '+ expense_brkdn[i][1] +'</a></li>';
                
            // }

            // $(".e_brkdn").html(e_brkdn);
            

        });

        var myChart = $('#myChart')

        var myPiChart = $('#myPiChart')

        var chart = new Chart(myChart, {
            
            type:'bar',

            // size: '2px';,
            
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],

                datasets: [{

                    label: 'Payments',

                    backgroundColor: '#E9573F',

                    borderColor: '#fff',

                    data: [2000/1000, 9000/1000, 34000/1000, 3000/1000, 20000/1000,4000/1000, 1000/1000, 5000/1000, 23000/1000, 7000/1000, 21000/1000, 0/1000]

                    
                    },
                    {
                    label: 'Expenses',

                    barThickness: "2px",

                    backgroundColor: '#ddd',

                    borderColor: '#fff',

                    data: [8000/1000, 5000/1000, 30000/1000, 45000/1000, 6000/1000, 34000/1000, 22000/1000, 5000/1000, 4000/1000, 7000/1000, 44000/1000, 0/1000]
                }
                ]
            },

            options: {

                response: true,

                scales: {

                    yAxes: [{
                        ticks: {
                            begeinAtZero: true,

                            suggestedMax: 60
                        },

                        scaleLabel: {
                            display: true,
                            labelString: "Amount (x1000)"
                        }
                    }],

                    xAxes: [{
                        barPercentage: 0.5,
                        barThickness: 10,
                        maxBarThickness: 15,
                        minBarLength: 5,
                        gridLines: {
                            display: false
                        }
                    }] 
                },

                legend: {

                    labels:{

                         usePointStyle: true,

                         padding: 30


                    }

                   
                }
            }
        })

        var piechart = new Chart(myPiChart, {

            type: 'doughnut',

            data:{

                datasets: [{

                    data: [10, 30, 20],

                    backgroundColor: [
                        
                        '#008080',

                        '#E9573F',

                        '#F8D404'
                    ]

                }],

                borderColor: '#fff',
                    
                backgroundColor: [
                    
                    '#E9573F',

                    '#000',

                    'ffff00'
                ],

                labels: [
                        
                        'Payments',

                        'Expenses',

                        'Overdues'
                    ],

            }, 

             options: {

                responsive: true,

                legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',

                cutoutPercentage: 83,

                legend: false,
                
                legendCallback: function(chart) {
                    var text = [];
                    text.push('<ul class="' + chart.id + '">');
                    for (var i = 0; i < chart.data.datasets[0].data.length; i++) {
                    text.push('<li><span style="background-color:' + chart.data.datasets[0].backgroundColor[i] + '">');
                    if (chart.data.labels[i]) {
                        text.push(chart.data.labels[i]);
                    }
                    text.push('</span></li>');
                    }
                    text.push('</ul>');
                    return text.join("");
                },

                mode: "single",

                callbacks: {
                label: function(tooltipItems, data) {
                    var sum = data.datasets[0].data.reduce(add, 0);
                    function add(a, b) {
                    return a + b;
                    }

                    return parseInt((data.datasets[0].data[tooltipItems.index] / sum * 100), 10) + ' %';
                },
                beforeLabel: function(tooltipItems, data) {
                    return data.datasets[0].data[tooltipItems.index] + ' hrs';
                }
                }



                // legend: {

                //     position: "bottom",

                //     labels: {

                //         usePointStyle: true,

                //         boxWidth: 150
                //     }
                // }

             }
        });

        $("#pie_legend").html(piechart.generateLegend());
    }

</script>

<style type="text/css">

        
    #pie_legend {
    position:relative;
    text-align: center;
    width:100%;
    bottom:10%;
    padding: 2em;
    font-size: 11px;
    }

    ul{
        list-style: none;
        margin: 0;
        padding: 0;
    }
    #pie_legend li {
    cursor:pointer;
    margin: 10px 4px;
    display: inline-table;
    }
    #pie_legend li span {
    position:relative;
    padding: 3px 11px;
    border-radius:30px;
    color:white;
    z-index:2;
    }
    
    .fc-state-highlight{

        background-color: rgba(128,255,128, .5);
        
    }

    .fc-past, .fc-today{

        cursor: pointer;
    }

    .fc-past:hover, .fc-today:hover{

        background-color: rgba(200,255,200,.4);
    }

    .fc-future{

        opacity: .4;

        cursor: not-allowed;
    }

    .fc-left h2{

        font-size: 1.2em;
    }

    /*date range calendar*/

    .daterangepicker{

        border-radius: 0px !important;
    }

    .daterangepicker td.active, .daterangepicker td.active:hover, .daterangepicker .ranges li.active{

        background: #e9573f;
    }

    .daterangepicker .drp-buttons .btn{

        font-weight: normal;
    }

</style>