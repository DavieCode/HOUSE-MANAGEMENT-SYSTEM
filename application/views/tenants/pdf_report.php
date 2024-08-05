<html>
    <head>
        <title>Print Preview</title>
        <link rel="stylesheet" rev="stylesheet" href="<?=base_url(); ?>bootstrap3/css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="<?=base_url(); ?>font-awesome-4.3.0/css/font-awesome.min.css" />
        <style>

            ul.checkbox-grid li {
                display: block;
                float: left;
                width: 40%;
                text-decoration: none;
            }

            .apartments_pdf_company_name, .apartments_pdf_title{
                text-align: center;
            }
        </style>
    </head>
    <body style="font-size: 11px; width: 595.28px; font-family: raleway">

        <div>

            <table width="100%">
                <tr>
                    <td align="" style="padding: 20px 0;display: inline-flex;">
                        <img id="img-pic" src="<?= (trim($this->config->item("logo")) !== "") ? base_url("uploads/logo/letter_head.jpg") : base_url("uploads/common/no_img.png"); ?>" style="height:100px" /> &nbsp;
                        <!-- <h2 style="font-size: 16px; color: green; font-weight: bold"><?= strtoupper($this->config->item('company')); ?> </h2> -->
                    </td>
                    <td class="text-right" style="line-height: 1.7em">
                        <?= $this->config->item('email') ?> <br>
                        <?= $this->config->item('website') ?> <br>
                        <?= $this->config->item('phone') ?> <br>
                        <?=preg_replace('/\\\\{1}n/', "<br>", $this->config->item('address'))  ?>
                        
                    </td>
                </tr>
            </table>

            <div class="" style="border-top: 1px solid #00aa00;border-bottom: 1px solid #00aa00;padding: 8px;">
                
                <div style="text-align: left;" class="col-xs-4">tenant's statement</div>

                <div style="text-align: right"><?=date(DATE_RFC822) ?></div>
            </div>

            <div class="container-fluid row text-cnter" style="padding: 25px 0 25px 0;">

                <strong><p style="padding: 15px; font-size: 13px; font-weight: bold" class="text-center">PERSONAL DETAILS</p></strong>

                <div style="padding-left: 20px">

                    <div class="col-xs-3">
                        <p><strong>Account :</strong> <br>
                            <?= $tenant->person_id; ?></p>
                    </div>

                    <div class="col-xs-4">
                        <p><strong>Name :</strong><br>
                         <?= ucwords($tenant->first_name .' '.$tenant->last_name); ?></p>
                    </div>

                    <div class="col-xs-3">
                        <p><strong>Phone :</strong> <br> 
                            <?= $tenant->phone_number; ?></p>
                    </div>

                    <div class="col-xs-3">
                        <p><strong>Occupation :</strong> <br>
                            <?= $occupation; ?></p>
                    </div>

                    <div class="col-xs-4">
                        <p><strong> Employer :</strong> <br> 
                            <?= $tenant->employer; ?></p>
                    </div>

                </div>
            </div>


            <div class="container-fluid row text-center" style="margin-top: 20px;">

                <strong><p style="padding: 15px; font-size: 13px; font-weight: bold">apartment HISTORY</p></strong>

                <p>Below is a list of the apartments that the above mentioned client has ever been given as indicated in the system</p>
                
                <table border="0.5" style="width: 100%; margin-top: 20px">
                    
                    <thead>
                        
                        <tr>
                            <th style="padding: 0 5px; text-align: center">Date Applied</th>
                            <th style="padding: 5px; text-align: center">Amount</th>
                            <th style="padding: 5px; text-align: center">Due date</th>
                            <th style="padding: 5px; text-align: center">Last Payment</th>
                            <th style="padding: 5px; text-align: center">Total Paid</th>
                            <th style="padding: 5px; text-align: center">Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($apartment_history as $apartment_history) { ?>

                        <tr>
                            
                            <td style="padding: 5px; text-align: center"><?=date('d M Y', strtotime($apartment_history->date_applied)) ?></td>

                            <td style="padding: 5px; text-align: center"><?=to_currency($apartment_history->apartment_amount, true, 0) ?></td>

                            <td style="padding: 5px; text-align: center"><?=date('d M Y', strtotime($apartment_history->payment_date)) ?></td>    

                            <td style="padding: 5px; text-align: center"><?=(isset($history->latest_payment)) ? date("d M, Y", strtotime($history->latest_payment)) : "N/A" ?></td>       

                            <td style="padding: 5px; text-align: center"><?=to_currency($apartment_history->total_paid, true, 0) ?></td>  

                            <td style="padding: 5px; text-align: center"><?=$apartment_history->status ?></td>

                        </tr>

                        <?php } ?>
                    </tbody>
                </table>

            </div>

            <br/>
            <br/>
            <br/>

            <table width="100%" style="font-size: 12px">
                <tr>
                    <td align="center">
                        <h3 style="font-size: 13px">Thank you!</h3>
                    </td>
                </tr>
            </table>


        </div>

    </body>

</html>