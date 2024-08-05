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
    <body style="font-size: 12px; width: 595.28px; font-family: raleway">

        <div>

            <table width="100%">
                <tr>
                    <td align="" style="padding: 20px 0;display: inline-flex;">
                        <img id="img-pic" src="<?= (trim($this->config->item("logo")) !== "") ? base_url("uploads/logo/jr.png") : base_url("uploads/common/no_img.png"); ?>" style="height:100px" /> &nbsp;
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

            <div class="" style="border-top: 1px solid #00aa00;padding-top: 30px;">
                
                <div style="text-align: left;"><?=preg_replace("/\n/", " <br>", $letter_info->address) ?></div>

            </div>

            <div>

                <p class="text-right"><?=date('d F, Y') ?> </p>

                <span class="pull-left" style="font-weight: bold">Ref. No : RC/<?=$letter_info->letter_id."/".date('Y') ?></span>

            </div>

            <div class="container-fluid row text-cnter" style="padding: 5px 0 5px 0;">

                <strong><p style="padding: 15px; font-size: 13px; font-weight: bold">REF : <?=strtoupper($letter_info->subject) ?></p></strong>
            </div>


            <div class="container-fluid row" style="margin-top: 0px;">

                <p><?=preg_replace("/\n/", " <br>", $letter_info->message) ?></p>


            </div>

            <br/>
            <br/>

        </div>

    </body>

</html>