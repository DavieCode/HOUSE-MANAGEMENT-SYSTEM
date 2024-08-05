<?php $selected = "active"; $this->load->view("partial/header"); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="inqbox float-e-margins">
            <div class="inqbox-content">

                <ol class="breadcrumb">
                    <li>
                        <a href="<?= site_url(); ?>">Home</a>
                    </li>
                    <li>
                        <a>apartments</a>
                    </li>
                    <li class="active">
                        <strong>apartment Calculator</strong>
                    </li>
                </ol>
            </div>
        </div>
    </div>    
</div>

<style type="text/css">
	
	.t_box{margin: 1em; padding: .5em; border-radius: 5px;}

</style>

<div class="row">
    <div class="col-lg-12">
        <div class="inqbox float-e-margins">
            <div class="inqbox-title">
                <h5>
                    apartment Calculator
                </h5>
                <div class="inqbox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="inqbox-content">

                <div class="row ">

                    <form class="col-md-12" id="calc_form" style="padding: 4em 0;" method="post" action="#">
                        
                        <div class="col-md-5 col-sm-offset-1" style="margin-top: 2em; padding: 0; border: 1px solid #eee;">                	

                            <h3 class="inqbox-title" style="background: #e9573f">apartment Details</h3>

                            <div style="padding: 2em">

                                <div class="row form-group"><label class="col-sm-3 control-label">Principal :</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" id="principal" required>
                                    </div>
                                </div>

                                <div class="hr-line-dashed"></div>

                                <div class="row form-group"><label class="col-sm-3 control-label">Monthly Interest(%) :</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" id="interest" required>
                                    </div>
                                </div>

                                <div class="hr-line-dashed"></div>

                                <div class="row form-group"><label class="col-sm-3 control-label">Duration (days) :</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" id="duration" required>
                                    </div>
                                </div>

                                <div class="hr-line-dashed"></div>
                            
                                <div class="text-center"><button type="submit" id="btn-calculate" class="btn btn-success"> CALCULATE &nbsp; <span class="fa fa-long-arrow-right"></span></button></div>

                                <p class="form_content text-center"></p>
                            </div>

                        </div>

                        <div class="col-sm-5" style="margin: 2em 1em; border: 1px solid #eee;width: 400px; padding: 0">

                            <h3 class="inqbox-title" style="background: #e9573f">Expected Payments</h3>
                        	
                        	<div class="t_box">

                                <div id="output">

                                </div>

                        	</div>

                        </div>

                    </div>

                </form>

            </div>
        </div>
        <div id="feedback_bar"></div>
    </div>
</div>

<script type="text/javascript">
		
	$(document).ready(function() {
		
		$('#calc_form').on('submit',function(e){

            e.preventDefault();

			var principal = $('#principal').val();

			var monthly_interest = $('#interest').val();

			var duration = $('#duration').val();

            var total_interest = 0;

            var installments = principal/(duration/30); 

            $('#output').html("");

            var output = "";

                var counter = 1;

                while(duration > 0){

                    if (duration >= 30) {

                        interest = principal*(monthly_interest/3000)*30;

                        calc_duration = 30;

                    }else{

                        interest = principal*(monthly_interest/3000)*duration;

                        calc_duration = duration;

                    }                    
                                
                    output = "<h4 style='margin-bottom: 1.5em'><strong>Installment "+counter+"</strong> ("+calc_duration+" days)</h4>";

                    output += "<h4>Principal : <strong>Ksh. "+principal+"</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Interest : <strong>Ksh. "+Math.round(interest)+"</strong></h4>";

                    output += "<hr>";

                    $('#output').append(output);

                    total_interest += interest;

                    duration -= 30;

                    principal -= Math.round(installments);

                    counter++;

                }

                var total_payment = parseInt($('#principal').val()) + parseInt(total_interest);

                $('#output').append("<h4 style='margin-bottom: 1.5em; color:#e9573f'><strong>Total Payment : Ksh. "+total_payment+"</strong></h4>");

                $('#output').append("<h4 style='margin-bottom: 1.5em; color: #e9573f'><strong>Fixed installments : Ksh. "+total_payment/(counter-1)+"</strong></h4>");

                $('.form_content').html("<h4 style='margin: 1em 0; color: #e9573f'><strong>No. of Installments : "+(counter-1)+"</strong></h4>");


			
		});
	})

</script>