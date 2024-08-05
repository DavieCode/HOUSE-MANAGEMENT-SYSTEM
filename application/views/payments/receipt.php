

<!DOCTYPE html>
<html>
<!-- <html lang="ar"> for arabic only -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>Payment Receipt</title>
    <style>
        @media print {
            @page {
                margin: 0 auto; /* imprtant to logo margin */
                sheet-size: 80mm 160mm; /* imprtant to set paper size */
            }
            html {
                direction: rtl;
            }
            html,body{margin:0;padding:0}
            #printContainer {
                width: 250px;
                margin: auto;
                padding: 10px auto;
                /*border: 2px dotted #000;*/
                text-align: left;
            }

            td{vertical-align: top;}

           .text-center{text-align: center;}
        }
    </style>
</head>
<body style="font-family: raleway">

<div id='printContainer'>
    <h3 id="slogan" style="margin-top:10px; font-size: 120%" class="text-center">

    	<img style="filter: grayscale(1);" src="<?= (trim($this->config->item("logo")) !== "") ? base_url("uploads/logo/" . $this->config->item('logo')) : base_url("uploads/common/no_img.png"); ?>" alt='Logo' height="80px">

    	<br><?=strtoupper($this->config->item('company'))  ?>

    <div style="font-size: 80%; font-weight: normal;" class="text-center">
        <?=$this->config->item('email') ?> <br>
        <?=$this->config->item('phone') ?>
    </div></h3>
<hr>

    <table>
        <tr>
            <td>Rcpt No.</td>
            <td><b>#<?php printf("%04d", $payment_id) ?></b></td>
        </tr>
        <tr>
            <td>Date</td>
            <td><b><?= date("d M, Y", time()); ?><br></b></td>
        </tr>
        <tr>
            <td>Time</td>
            <td><b><?= date("H:i A", time()); ?><br></b></td>
        </tr>

    </table>
<hr>
<table>

        <tr>
            <td>Client : </td>
            <td><b><?=$client ?></b></td>
        </tr>

        <tr>
            <td>Account : </td>
            <td><b><?=$account ?></b></td>
        </tr>

    </table>

    <hr>

    <table>
        <tr>
            <td>Amount : </td>
            <td><b> <?=$amount_paid ?></b></td>
        </tr>
        <tr>
            <td>Method : </td>
            <td><b> <?=$method ?></b></td>
        </tr>
        <tr>
            <td>Paid by : </td>
            <td><b> <?=$paid_by ?></b></td>
        </tr>
        <tr>
            <td>Date Paid : </td>
            <td><b> <?=$trans_date ?></b></td>
        </tr>
    </table>
    <hr>

    <table>
        <tr>
            <td colspan="2" style="font-size: 80%; text-align: center">YOU WERE SERVED BY <?=$teller ?></td>
        </tr>
        <tr>
            <td colspan="2" style="font-size: 70%;">Powered by kca hostels,  <?=date('Y') ?></td>
        </tr>
    </table>

</div>
</body>
</html>