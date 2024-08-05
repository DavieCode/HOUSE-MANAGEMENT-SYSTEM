<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" rev="stylesheet" href="<?=base_url(); ?>bootstrap3/css/bootstrap.css" />

        <link href="<?=base_url(); ?>fonts/font-awesome/css/font-awesome.css" rel="stylesheet">

        <link rel="stylesheet" rev="stylesheet" href="<?=base_url(); ?>css/signin.css" />

        <meta http-equiv="content-type" content="text/html; charset=utf-8" />

        <title>User login - KCA Hostels</title>

        <script src="<?=base_url(); ?>js/jquery-1.2.6.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>

        <link rel="stylesheet" type="text/css" href="<?=base_url() ?>css/normalize.css" />
        <link rel="stylesheet" type="text/css" href="<?=base_url() ?>css/style.css" />
        <link rel="stylesheet" type="text/css" href="<?=base_url() ?>css/component.css" />

        <script type="text/javascript">

            $(document).ready(function (){

                $("#login_form input:first").focus();
            });

        </script>

    </head>

    <body>

    <!-- ALERT MESSAGE HERE -->

    <?php if(validation_errors() != ''){ ?>

    <script>setTimeout(function() {$('.alert').hide()},5000);</script>

        <div class="alert container-fluid" style="position: fixed;min-width: 300px;top: 30px; right: 50px; color: #fff; background: rgba(255,100,100,.8);border: 1px solid #551">

            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

            <p style="font-size: 1.3em !important;"><?=validation_errors(); ?></p>

        </div>

    <?php } ?>

    <div class="" style="position: fixed;height: 100vh;width: 100vw; margin: 0px;z-index: -1000;background: url('<?=base_url() ?>imgs/bg1.jpg') no-repeat; background-size: cover;">
    </div>

    <table class="text-center" style="width: 100%; height: 100vh; background: rgba(50,0,0,.6);">

        <tr style="">

            <td class="container-fluid" style="">
                
                <!--login forn-->

                <?=form_open('login', array('class' => 'well form-signin', 'style' => 'max-width:350px;margin:auto; background:rgba(0,0,10,.4); padding: 3em 3em 2em 3em !important; box-shadow: 0px 0px 5px gre inset; border:none', 'id' => 'login_form')) ?>

                <h3 class="form-signin-heading" style="color: gold; font-size: 1.7em">KCA Hostels</h3>

                <?php //echo $this->lang->line('login_welcome_message'); ?>
                
                <label for="username" class="sr-only">Username :</label>

                <?php
                echo form_input(
                        array(
                            'name' => 'username',
                            'size' => '20',
                            'class' => 'form-control',
                            'type' =>'text',
                            'placeholder' => 'username',
                            'value' => '', 
                            'autocomplete' => 'false'
                        )
                );
                ?>
                
                <div class="form-group">
                    
                    <label for="password" class="sr-only">Password :</label>

                    <?php
                    echo form_password(
                            array(
                                'name' => 'password',
                                'size' => '20',
                                'placeholder' => 'password',
                                'class' => 'form-control',
                                'value' => '', 
                                'autocomplete' => 'false'
                            )
                    );
                ?>

                </div>
                <button class="btn btn-sm btn-info" id="loginButton" style="margin-top:1em;" type="submit">LOG IN <span class="fa fa-long-arrow-right"></span></button>

                
                <?=form_close(); ?>

            </td>

        </tr>

    </table>

    <!-- FOOTERS -->

    <div class="container text-center" style="position: fixed;bottom: 10px;left: 10px;color: #0ff;background: transparent;border: none;padding: 2em; width: 100%;">&copy; KCA Hostels 2021 - <?=date('Y')?> &middot; Powered by <a style="color: gold" href="#">David Mwania - KCA University</a></div>

        </div>
    </body>
</html>

        <script src="<?=base_url() ?>js/TweenLite.min.js"></script>
        <script src="<?=base_url() ?>js/EasePack.min.js"></script>
        <script src="<?=base_url() ?>js/rAF.js"></script>
        <script src="<?=base_url() ?>js/demo-2.js"></script>