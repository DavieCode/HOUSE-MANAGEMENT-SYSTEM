<html>
    <head>
        <title>Print Preview</title>
        <link rel="stylesheet" rev="stylesheet" href="<?=base_url(); ?>bootstrap3/css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="<?=base_url(); ?>font-awesome-4.3.0/css/font-awesome.min.css" />
        <style>

            *{

                font-family: Raleway;
            }
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
    <body>

        <div>

            <table width="100%" >
                <tr>
                    <td align="center" style="padding: 20px">
                        <img id="img-pic" src="<?= (trim($this->config->item("logo")) !== "") ? base_url("uploads/logo/" . $this->config->item('logo')) : base_url("uploads/common/no_img.png"); ?>" style="height:99px" /><br/>
                        <h2><?= ucwords($this->config->item('company')); ?> </h2>

                        <p><?= ucwords($this->config->item('address')); ?></p>

                        <p><?= $this->config->item('website'); ?> </p>

                        <?= $this->config->item('phone') . " " . $this->config->item('rnc'); ?>
                    </td>
                </tr>
            </table>

            <hr>

            <h4 class="text-center">staffs Statement</h4>

            <div class="row text-center" style="margin-top: 20px;">

                <p style="padding: 10px;">This document shows the details of all <?=$this->config->item('company') ?> staffs that have access to the companies apartmentinst System:</p>

                <table style="margin: auto;font-size: 1em">

                    <tr rowspan="2">
                        
                        <th>#</th>

                        <th>Name</th>

                        <th>ID/Passport</th>

                        <th>Email address</th>

                        <th>Phone no.</th>

                        <th>Home address</th>

                    </tr>

                    <tbody>
                        
                        <?php $count=1; foreach ($staffs as $staff) { ?>

                            <tr>
                                <td><?=$count ?></td>

                                <td><?=$staff->first_name .' '. $staff->last_name ?></td>

                                <td width="140"><?=$staff->id_number ?></td>

                                <td width="140"><?=$staff->email ?></td>

                                <td width="140"><?=$staff->phone_number ?></td>

                                <td width="140"><?=$staff->home_address ?></td>
                            </tr>                            

                        <?php $count++; } ?>

                    </tbody>
                </table>

            </div>

            <br/>
            <br/>
            <br/>

            <table width="100%">
                <tr>
                    <td align="center">
                        <h3>Thank you!</h3>
                    </td>
                </tr>
            </table>


        </div>

    </body>

</html>