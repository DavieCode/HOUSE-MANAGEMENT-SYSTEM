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
                
                <div style="text-align: left;" class="col-xs-4">Durational Report</div>

                <div style="text-align: right"><?=date(DATE_RFC822) ?></div>
            </div>

            <div class="row text-center" style="padding: 25px 0 25px 0;border-bottom: 0.5px dashed black">

                <p style="padding: 15px; font-size: 16px">DURATIONAL REPORT</p>

                    <h6><strong> <?= strtoupper($date_range); ?></strong></h6>

            </div>


            <div class="row text-center" style="margin-top: 20px;">

                <table border="1" style="width: 100%;">
                    
                    <thead>                        
                        <tr>
                            <th style="padding: 9px; text-align: center">Item</th>
                            <th colspan="2" style="padding: 9px; text-align: center">Description</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            
                            <td style="padding: 9px; text-align: center">Payments</td>

                            <td colspan="2" style="padding: 9px; text-align: center"><?=to_currency($payment_total, true, 0); ?></td>

                        </tr>

                        <tr>

                            <td rowspan="4" style="padding: 9px; text-align: center"></td>
                            
                            <td style="padding: 9px; text-align: center">Principal</td>

                            <td style="padding: 9px; text-align: center"><?=$payment_breakdown->principal ?></td>

                        </tr>

                        <tr>
                            
                            <td style="padding: 9px; text-align: center">Interest</td>

                            <td style="padding: 9px; text-align: center"><?=$payment_breakdown->interest ?></td>

                        </tr>

                        <tr>
                            
                            <td style="padding: 9px; text-align: center">Appraisal fees</td>

                            <td style="padding: 9px; text-align: center"><?=$payment_breakdown->renewal ?></td>

                        </tr>

                        <tr>
                            
                            <td style="padding: 9px; text-align: center">Penalty</td>

                            <td style="padding: 9px; text-align: center"><?=$payment_breakdown->penalty ?></td>

                        </tr>

                        <tr>
                            
                            <td style="padding: 9px; text-align: center">apartments</td>

                            <td colspan="2" style="padding: 9px; text-align: center"><?=to_currency($total_apartments, true, 0); ?></td>

                        </tr>

                        <tr>
                            
                            <td style="padding: 9px; text-align: center">Expenses</td>

                            <td colspan="2" style="padding: 9px; text-align: center"><?=to_currency($expense, true, 0); ?></td>

                        </tr>


                        <?php $i = 0; foreach ($expense_breakdown as $e_brk) { ?>

                            <tr>

                                <?php if ($i == 0) { ?>

                                    <td rowspan="<?=sizeof($expense_breakdown); ?>" style="padding: 9px; text-align: center"></td>
                                    
                                <?php } ?>
                                
                                <td style="padding: 9px; text-align: center"><?=$e_brk[0] ?></td>

                                <td style="padding: 9px; text-align: center"><?=$e_brk[1] ?></td>

                            </tr>

                        <?php $i++; } ?>

                        <tr>
                            
                            <td style="padding: 9px; text-align: center">Income</td>

                            <td colspan="2" style="padding: 9px; text-align: center"><?=to_currency($income, true, 0) ?></td>

                        </tr>

                        <tr>
                            
                            <td style="padding: 9px; text-align: center">Profit/loss</td>

                            <td colspan="2" style="padding: 9px; text-align: center"><?=to_currency($profit, true, 0) ?></td>

                        </tr>

                    </tbody>
                </table>

            </div>


        </div>

    </body>

</html>