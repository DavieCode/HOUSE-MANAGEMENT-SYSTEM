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
                
                <div style="text-align: left;" class="col-xs-4">apartment statement</div>

                <div style="text-align: right"><?=date(DATE_RFC822) ?></div>
            </div>

            <div class="row text-center" style="padding: 25px 0 25px 0;">

                <strong><p style="padding: 15px; font-size: 13px; font-weight: bold">apartment DETAILS</p></strong>

                <?php 

                    // PAYABLE AMOUNT

                    $data['amount_paid'] = $this->db->select_sum('amount')->where('apartment_id', $apartment->apartment_id)->get('payments')->row()->amount;

                    $interest = (($apartment->monthly_rate/30) * $apartment->apartment_amount) * round((strtotime(date('Y-m-d', time())) - strtotime($apartment->date_applied))/(24*60*60) - 1);

                    $data['apartment_balance'] = ($apartment->apartment_amount + $interest) - $data['amount_paid'];

                 ?>

                <div class="col-xs-3">

                    <p><strong>tenant :</strong><br>

                     <?= ucwords($tenant->first_name .' '.$tenant->last_name); ?></p>
                     
                </div>

                <div class="col-xs-4">
                    <p><strong>Amount :</strong> <br> 
                        <?=to_currency($apartment->apartment_amount, true, 0); ?></p>
                </div>

                <div class="col-xs-3">
                    <p><strong>Application date :</strong> <br>
                        <?=date('d M Y', strtotime($apartment->date_applied)); ?></p>
                </div>

                <div class="col-xs-3">
                    <p><strong>Due Date :</strong> <br>
                        <?= date('d M Y', strtotime($apartment->payment_date)); ?></p>
                </div>

                <div class="col-xs-4">
                    <p><strong>Interest due :</strong> <br> 
                        <?= to_currency($interest, true, 0); ?>
                    </p>
                </div>

            </div>


            <div class="row text-center" style="margin-top: 20px;">

                <strong><p style="padding: 15px; font-size: 13px; font-weight: bold">apartment PAYMENTS</p></strong>

                <p>Below is a list of payments that are associated with the above described apartment</p>
                
                <table border="0.5" style="width: 100%;">
                    
                    <thead>
                        
                        <tr>
                            <th style="padding: 5px; text-align: center">Payment date</th>
                            <th style="padding: 5px; text-align: center">Amount</th>
                            <th style="padding: 5px; text-align: center">Payment method</th>
                        </tr>
                    </thead>

                    <tbody>
                        
                        <?php foreach ($payments as $payment) {  ?>

                        <tr>
                            
                            <td style="padding: 5px; text-align: center"><?=date('d M Y', strtotime($payment->date_paid)) ?></td>

                            <td style="padding: 5px; text-align: center"><?=to_currency($payment->amount, true, 0) ?></td>

                            <td style="padding: 5px; text-align: center"><?=$payment->payment_method ?></td>

                        </tr>

                        <?php } ?>
                            
                    </tbody>
                </table>

                <p style="text-align: center;padding: 10px;">Total paid : <strong><?=to_currency($data['amount_paid'], true, 0) ?></strong></p>

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