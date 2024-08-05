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

            td{
                padding: 5px;

                vertical-align:

                middle;

                font-size: 12px
            }

            h3{font-size: 16px}

            h4{font-size: 14px}

            .small{font-style: italic;}

            table{width: 100%}
        </style>

    </head>

    <body style="font-size: 11px; width: 595.28px; font-family: raleway">

        <div>

            <!-- PAGE HEADER -->
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
                
                <div style="text-align: left;" class="col-xs-4"> apartment Application Form</div>

                <div style="text-align: right"><?=date(DATE_RFC822) ?></div>
            </div>

            <h3><strong>FORM &ndash; RC 1.&nbsp; apartment APPLICATION FORM</strong></h3>

            <h4><strong>tenant'S DETAILS:</strong></h4>

            <?php //var_dump($tenant_info) ?>

            <table border="1">
                <tbody>
                    <tr>
                        <td width="277">Full names</td>
                        <td width=""><i><?=$tenant_name ?></i></td>
                    </tr>
                    <tr>
                        <td width="277">I.D./Passport number</td>
                        <td width=""><i><?=$tenant_info->id_number ?></i></td>
                    </tr>
                    <tr>
                        <td width="277">Contacts &ndash; Telephone number</td>
                        <td width="347"><i><?=$tenant_info->phone_number ?></i></td>
                    </tr>
                    <tr>
                        <td width="277">Postal address</td>
                        <td width="347"><i><?=ucwords($tenant_info->postal_address) ?></i></td>
                    </tr>
                    <tr>
                        <td width="277">Physical address &ndash; Business Location</td>
                        <td width="347"><i><?=ucwords($tenant_info->physical_address) ?></i></td>
                    </tr>
                    <tr>
                        <td width="277">Home address</td>
                        <td width="347"><i><?=ucwords($tenant_info->home_address) ?></i></td>
                    </tr>
                    <tr>
                        <td width="277">Email address</td>
                        <td width="347"><i><?=$tenant_info->email ?></i></td>
                    </tr>
                    <tr>
                        <td width="277">Occupation</td>
                        <td width="347"><i><?=ucwords($tenant_info->occupation) ?></i></td>
                    </tr>
                    <tr>
                        <td width="277">Business name / Employer</td>
                        <td width="347"><i><?=ucwords($tenant_info->employer) ?></i></td>
                    </tr>
                </tbody>
            </table>

            <p>&nbsp;</p>

            <h4><strong>I/ we the above mentioned have applied for a apartment facility as follows:</strong></h4>

            <?php //var_dump($apartment_info) ?>
            <table border="1">
                <tbody>
                    <tr>
                        <td width="277">Amount in Kes:</td>
                        <td width="347"><i><?=ucfirst(to_currency($apartment_info->apartment_amount, true, 0)) ?></i></td>
                    </tr>
                    <tr>
                        <td width="277">apartment purpose:</td>
                        <td width="347"><i><?=ucfirst($apartment_info->description) ?></i></td>
                    </tr>
                    <tr>
                        <td width="277">Repayment period</td>
                        <td width="347"><i><?=round((strtotime($apartment_info->payment_date) - strtotime($apartment_info->date_applied))/(24*60*60) - 1); ?> days</i></td>
                    </tr>
                </tbody>
            </table>

            <p>&nbsp;</p>

            <h4><strong>Security for the facility: </strong></h4>
            <p>Collateral pledged by the tenant: <br>(Note &ndash; Value to be more than twice the borrowed amount).</p>

            <?php //var_dump($collaterals) ?>

            <table border="1">
                <tbody>
                    <tr>
                        <td width="277"><strong>Description of the item (Serial no.)</strong></td>
                        <td width="347"><strong>Estimated Current Market Value</strong></td>
                    </tr>
                    <?php 

                    $collat_count = sizeof($collaterals);

                    $collat_totals = 0;

                    if( $collat_count > 0 && $collaterals[0]['name'] != ""){

                        foreach ($collaterals as $collat) { 

                            $collat_totals += $collat['amount'];
                            ?>
                            <tr>
                                <td width="277"><i><?=ucwords($collat['name'] ." - ". $collat['serial']) ?></i></td>
                                <td width="347"><i><?=ucfirst(to_currency($collat['amount'], true, 0)) ?></i></td>
                            </tr>
                            
                        <?php }

                        $loops = 5 - $collat_count;

                        while ($loops > 0) { ?>

                            <tr>
                                <td width="277"><strong>&nbsp;</strong></td>
                                <td width="347"></td>
                            </tr>
                            
                        <?php $loops--; } ?>

                        <tr>
                            <td width="277"><strong>Total Market value. </strong></td>
                            <td width="347"><strong><i><?=ucfirst(to_currency($collat_totals, true, 0)) ?></i></strong></td>
                        </tr>

                    <?php } else { ?>

                        <tr>
                            <td width="277"><strong>&nbsp;</strong></td>
                            <td width="347"></td>
                        </tr>
                        <tr>
                            <td width="277"><strong>&nbsp;</strong></td>
                            <td width="347"></td>
                        </tr>
                        <tr>
                            <td width="277"><strong>&nbsp;</strong></td>
                            <td width="347"></td>
                        </tr>
                        <tr>
                            <td width="277"><strong>&nbsp;</strong></td>
                            <td width="347"></td>
                        </tr>
                        <tr>
                            <td width="277"><strong>&nbsp;</strong></td>
                            <td width="347"></td>
                        </tr>
                        <tr>
                            <td width="277"><strong>Total Market value. </strong></td>
                            <td width="347"><strong>Kes.</strong></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <!-- PAGE FOOTER -->

            <p>&nbsp;</p>

            <strong>Client’s Name &  Signature: ………......................…………………….  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Date:  ……………………......... </strong>
            <p>&nbsp;</p>

            <ul class="small">
                <li>All payment should be done through our Bank Accounts and the deposit slip  forwarded to our offices for confirmation. </li>
                <li>Timely repayments and good credit record will attract rebates payable yearly.</li>
                <li>Our turn around time is at most 24 hours- provide all the necessary requirements on time.</li>
            </ul>


            <!-- PAGE 2 -->
            <!-- PAGE HEADER -->
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
                
                <div style="text-align: left;" class="col-xs-4"> apartment Application Form</div>

                <div style="text-align: right"><?=date(DATE_RFC822) ?></div>
            </div>
            <p>&nbsp;</p>

            <h4><strong>A sketch map showing client's business / work premises and residence</strong></h4>

            <table border="1">
                <tbody>
                    <tr>
                        <td width="180"> 1. Business / Work premises</td>
                        <td width="446">
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td width="180"> 2. Residence</td>
                        <td width="446">
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                        </td>
                    </tr>
                </tbody>
            </table>

            <p>&nbsp;</p>

            <h4><strong>Acceptance of the tenant</strong>:</h4>

            <table border="1">
                <tbody>
                    <tr>
                        <td width="626">
                            <p>&nbsp;</p>
                            <p><strong>I have read and agreed to the terms and conditions here below:</strong> </p>

                            <ol>
                                &nbsp;&nbsp;&nbsp;&nbsp;<li>I have willingly applied for the above apartment facility and I shall abide by the said terms and conditions.</li>
                                &nbsp;&nbsp;&nbsp;&nbsp;<li>The pledged items are strictly prohibited from being disposed in any way until the facility is fully repaid.</li>
                                &nbsp;&nbsp;&nbsp;&nbsp;<li>The lender reserves the right to cancel the application and or recall the facility in the event that the tenant acts in contravention to the set terms and conditions of this agreement.</li>
                                &nbsp;&nbsp;&nbsp;&nbsp;<li>I shall cater for any legal cost that may arise from my failure to honour my apartment facility.</li>
                            </ol>
                            <p>&nbsp;</p>

                            <strong>Client’s Signature: ………................ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Date:  ……………………..............&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Time:  ……………………..............</span>  </strong>
                            <p>&nbsp;</p>


                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- PAGE FOOTER -->
            <p>&nbsp;</p>

            <strong>Client’s Name &  Signature: ………......................……………………. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Date:  ……………………..............</strong>
            <p>&nbsp;</p>

            <ul class="small">
                <li>All payment should be done through our Bank Accounts and the deposit slip  forwarded to our offices for confirmation. </li>
                <li>Timely repayments and good credit record will attract rebates payable yearly.</li>
                <li>Our turn around time is at most 24 hours- provide all the necessary requirements on time.</li>
            </ul>


            <!-- PAGE 3 -->
            <!-- PAGE HEADER -->
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
                
                <div style="text-align: left;" class="col-xs-4"> apartment Application Form</div>

                <div style="text-align: right"><?=date(DATE_RFC822) ?></div>
            </div>
            <p>&nbsp;</p>
            <h3><strong>RC 2. GUARANTOR'S INFORMATION</strong></h3> 

            <?php //var_dump($guarantor) ?>

            <table border="1">
                <tbody>
                    <tr>
                        <td width="277">Full names</td>
                        <td width="347"><i><?=ucwords($guarantor[0]['first_name']." ".$guarantor[0]['last_name'] ) ?></i></td>
                    </tr>
                    <tr>
                        <td width="277">Relationship with the tenant</td>
                        <td width="347"><i><?=ucwords($guarantor[0]['relationship']) ?></i></td>
                    </tr>
                    <tr>
                        <td width="277">I.D./Passport number</td>
                        <td width="347"><i><?=ucwords($guarantor[0]['id_number']) ?></i></td>
                    </tr>
                    <tr>
                        <td width="277">Contacts &ndash; Telephone / Mobile phone.</td>
                        <td width="347"><i><?=ucwords($guarantor[0]['phone_number']) ?></i></td>
                    </tr>
                    <tr>
                        <td width="277">Postal Address</td>
                        <td width="347"><i><?=ucwords($guarantor[0]['postal_address']) ?></i></td>
                    </tr>
                    <tr>
                        <td width="277">Physical location &ndash; Business / residence</td>
                        <td width="347"><i><?=ucwords($guarantor[0]['physical_address']) ?></i></td>
                    </tr>
                    <tr>
                        <td width="277">Home Address</td>
                        <td width="347"><i><?=ucwords($guarantor[0]['home_address']) ?></i></td>
                    </tr>
                    <tr>
                        <td width="277">E-Mail Address</td>
                        <td width="347"><i><?=$guarantor[0]['email'] ?></i></td>
                    </tr>
                    <tr>
                        <td width="277">Name of the business / employer if employed</td>
                        <td width="347"><i><?=ucwords($guarantor[0]['employer']) ?></i></td>
                    </tr>
                </tbody>
            </table>

            <p>&nbsp;</p>


            <p>I undertake to guarantee the above tenant for the facility plus all the interest accrued thereof until the facility is fully paid.</p>

            <p>&nbsp;</p>

            <p><strong>I pledge the following assets as collateral for this borrowing: </strong></p>

            <p>&nbsp;</p>

            <?php //var_dump($collaterals_g) ?>

            <table border="1">
                <tbody>
                    <tr>
                        <td width="277"><strong>Description of the item (Serial no.)</strong></td>
                        <td width="347"><strong>Estimated Current Market Value</strong></td>
                    </tr>
                    <?php 

                    $collat_count = sizeof($collaterals);

                    $collat_totals = 0;

                    if( $collat_count > 0 && $collaterals_g[0]['name'] != ""){

                        foreach ($collaterals_g as $collat) { 

                            $collat_totals += $collat['amount'];
                            ?>
                            <tr>
                                <td width="277"><i><?=ucwords($collat['name'] ." - ". $collat['serial']) ?></i></td>
                                <td width="347"><i><?=ucfirst(to_currency($collat['amount'], true, 0)) ?></i></td>
                            </tr>
                            
                        <?php }

                        $loops = 3 - $collat_count;

                        while ($loops > 0) { ?>

                            <tr>
                                <td width="277"><strong>&nbsp;</strong></td>
                                <td width="347"></td>
                            </tr>
                            
                        <?php $loops--; } ?>

                        <tr>
                            <td width="277"><strong>Total Market value. </strong></td>
                            <td width="347"><strong><i><?=ucfirst(to_currency($collat_totals, true, 0)) ?></i></strong></td>
                        </tr>

                    <?php } else { ?>

                        <tr>
                            <td width="277"><strong>&nbsp;</strong></td>
                            <td width="347"></td>
                        </tr>
                        <tr>
                            <td width="277"><strong>&nbsp;</strong></td>
                            <td width="347"></td>
                        </tr>
                        <tr>
                            <td width="277"><strong>Total Market value. </strong></td>
                            <td width="347"><strong>Kes.</strong></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <p>&nbsp;</p>

            <p><strong>&nbsp;</strong></p>
            <p><strong>Acceptance of the Guarantor</strong>:</p>
            <table border="1">
            <tbody>
            <tr>
            <td width="626">
                <p>&nbsp;</p>
                <p><strong>Name : ______________________________ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Signature :  ___________________</strong></p>
            <p>&nbsp;</p>
            </td>
            </tr>
            </tbody>
            </table>
            <p>&nbsp;</p>

            <strong>Client’s Name &  Signature: ………......................…………………….&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Date:  …………………….............. </strong>
            <p>&nbsp;</p>

            <ul class="small text-italic">
                <li>All payment should be done through our Bank Accounts and the deposit slip  forwarded to our offices for confirmation. </li>
                <li>Timely repayments and good credit record will attract rebates payable yearly.</li>
                <li>Our turn around time is at most 24 hours- provide all the necessary requirements on time.</li>
            </ul>


            <!-- PAGE 4 -->
            <!-- PAGE HEADER -->
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
                
                <div style="text-align: left;" class="col-xs-4"> apartment Application Form</div>

                <div style="text-align: right"><?=date(DATE_RFC822) ?></div>
            </div>

            <h3><strong>RC3. REFEREE'S INFORMATION</strong></h3>

            <?php //var_dump($referee) ?>

            <table border="1">
                <tbody>
                    <tr>
                        <td width="277">Full names </td>
                        <td width="347"><i><?=ucwords($referee[0]['first_name'] ." ". $referee[0]['last_name']) ?></i></td>
                    </tr>
                    <tr>
                        <td width="277">Relationship with the tenant</td>
                        <td width="347"><i><?=ucwords($referee[0]['relationship']) ?></i></td>
                    </tr>
                    <tr>
                        <td width="277">I.D./Passport number </td>
                        <td width="347"><i><?=ucwords($referee[0]['id_number']) ?></i></td>
                    </tr>
                    <tr>
                        <td width="277">Contacts &ndash; Telephone / Mobile phone</td>
                        <td width="347"><i><?=ucwords($referee[0]['phone_number']) ?></i></td>
                    </tr>
                    <tr>
                        <td width="277">Postal Address </td>
                        <td width="347"><i><?=ucwords($referee[0]['postal_address']) ?></i></td>
                    </tr>
                    <tr>
                        <td width="277">Physical location &ndash; Business / residence</td>
                        <td width="347"><i><?=ucwords($referee[0]['physical_address']) ?></i></td>
                    </tr>
                    <tr>
                        <td width="277">Home Address</td>
                        <td width="347"><i><?=ucwords($referee[0]['home_address']) ?></i></td>
                    </tr>
                    <tr>
                        <td width="277">E-Mail Address</td>
                        <td width="347"><i><?=ucwords($referee[0]['email']) ?></i></td>
                    </tr>
                    <tr>
                        <td width="277">Name of the business / employer if employed</td>
                        <td width="347"><i><?=ucwords($referee[0]['employer']) ?></i></td>
                    </tr>
                </tbody>
            </table>
            <p>&nbsp;</p>
            <p>I undertake to be a referee for the above tenant for the facility offered. I shall undertake to ensure the facility is fully repaid and in case of a default produce the tenant when called upon to do so. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>


            <p>&nbsp;</p>

            <p><strong>&nbsp;</strong></p>
            <p><strong>Acceptance of the Referee</strong>:</p>
            <table border="1">
            <tbody>
            <tr>
            <td width="626">
                <p>&nbsp;</p>
                <p><strong>Name : ______________________________ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature:  ___________________</strong></p>
                <p>&nbsp;</p>
            </td>
            </tr>
            </tbody>
            </table>

            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>


            <strong>Client’s Name &  Signature: ………......................……………………. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Date:  ……………………..............</strong>

            <p>&nbsp;</p>

            <ul class="small text-italic">
                <li>All payment should be done through our Bank Accounts and the deposit slip  forwarded to our offices for confirmation. </li>
                <li>Timely repayments and good credit record will attract rebates payable yearly.</li>
                <li>Our turn around time is at most 24 hours- provide all the necessary requirements on time.</li>
            </ul>


            <!-- PAGE 5 -->
            <!-- PAGE HEADER -->
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
                
                <div style="text-align: left;" class="col-xs-4"> apartment Application Form</div>

                <div style="text-align: right"><?=date(DATE_RFC822) ?></div>
            </div>

            <p><strong>&nbsp;</strong></p>

            <h3><strong>RC 4. OFFICE VERDICT</strong></h3>

            <p><strong>&nbsp;</strong></p>

            <table border="1">
                <tbody>
                    <tr>
                        <td colspan="2" width="626"><h4 class="text-center"><strong><u>FOR OFFICIAL USE ONLY</u></strong></h4>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>Company Name Ltd received your apartment request and Approved&nbsp;&nbsp; ___ / declined ____. </strong></p>
                            <p><strong>&nbsp;</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td width="313">
                            <p><strong>&nbsp;</strong></p>
                            <h5><strong>If approved</strong><strong>: </strong></h5>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>Amount applied: ____________________</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>Date received&nbsp;&nbsp; &nbsp;: _____________________</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                        </td>
                        <td width="313">
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>Amount approved:&nbsp; ___________________ </strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>Date to be approved: ___________________</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" width="626">
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>Name &amp; Signature of the approving officer : __________________________________________</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                            <p><strong>&nbsp;</strong></p>
                        </td>
                    </tr>
                </tbody>
            </table>

            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>

            <strong>Client’s Name &  Signature: ………......................……………………. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Date:  ……………………..............  </strong>

            <p>&nbsp;</p>

            <ul class="small text-italic">
                <li>All payment should be done through our Bank Accounts and the deposit slip  forwarded to our offices for confirmation. </li>
                <li>Timely repayments and good credit record will attract rebates payable yearly.</li>
                <li>Our turn around time is at most 24 hours- provide all the necessary requirements on time.</li>
            </ul>
            
            <p>&nbsp;</p>

            <!-- PAGE 6 -->
            <!-- PAGE HEADER -->
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
                
                <div style="text-align: left;" class="col-xs-4"> apartment Application Form</div>

                <div style="text-align: right"><?=date(DATE_RFC822) ?></div>
            </div>

            <p><strong>&nbsp;</strong></p>

            <h3><strong>RC 5. REPAYMENT SCHEDULE</strong></h3>            

            <?php $sch = json_decode($repayment_schedule) ?>

            <p><strong>&nbsp;</strong></p>

            <p>This apartment is scheduled to be paid in <?=$installments ?> installment(s)</p>

            <p><strong>&nbsp;</strong></p>

            <table border="1">
                <tbody>
                    <tr>
                        <td><strong>Date</strong></td>
                        <td><strong>Installment Principal</strong></td>
                        <td><strong>Installment Interest</strong></td>
                        <td><strong>Total</strong></td>
                    </tr>

                    <?php foreach ($sch as $sc ) { ?>
                        <tr>
                            <td><?=$sc->date ?></td>
                            <td><?=to_currency($sc->principal, true, 0) ?></td>
                            <td><?=to_currency($sc->interest, true, 0) ?></td>
                            <td><?=to_currency($sc->total, true, 0) ?></td>
                        </tr>                        
                    <?php } ?>
                        <tr>
                            <td> </td>
                            <td></td>
                            <td><strong><?=to_currency($total_interest, true, 0) ?></strong></td>
                            <td><strong><?=to_currency($total_payment, true, 0) ?></strong></td>
                        </tr>   
                </tbody>
            </table>

            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>

            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>

            <strong>Client’s Name &  Signature: ………......................……………………. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Date:  ……………………..............  </strong>

            <p>&nbsp;</p>

            <ul class="small text-italic">
                <li>All payment should be done through our Bank Accounts and the deposit slip  forwarded to our offices for confirmation. </li>
                <li>Timely repayments and good credit record will attract rebates payable yearly.</li>
                <li>Our turn around time is at most 24 hours- provide all the necessary requirements on time.</li>
            </ul>
            
            <p>&nbsp;</p>


        </div>

    </body>

</html>