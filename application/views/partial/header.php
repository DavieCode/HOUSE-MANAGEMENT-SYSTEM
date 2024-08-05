<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <base href="<?=base_url(); ?>" />
        <title><?=$this->config->item('company') . ' -- Powered by David Mwania' ; ?></title>

        <script>
            BASE_URL = '<?=base_url(); ?>';
            TOKEN_HASH = '<?=$this->security->get_csrf_hash(); ?>';
        </script>

        <!-- Toastr style -->
        <link href="css/plugins/toastr/toastr.min.css" rel="stylesheet"></link>

        <link href="<?=base_url(); ?>css/bootstrap.min.css" rel="stylesheet"></link>
        <link href="<?=base_url(); ?>fonts/font-awesome/css/font-awesome.css" rel="stylesheet"></link>

        <link rel="stylesheet" type="text/css" href="fonts/linearicons/linearicons.css">

        <link href="<?=base_url(); ?>css/animate.css" rel="stylesheet"></link>
        <link href="<?=base_url(); ?>css/style.css" rel="stylesheet"></link>
        <link href="<?=base_url(); ?>css/menu.css" rel="stylesheet"></link>
        <link href="<?=base_url(); ?>css/forms/kforms.css" rel="stylesheet"></link>

        <!-- Data Tables -->
        <link href="css/plugins/dataTables/dataTables.material.css" rel="stylesheet"></link>
        <link href="css/plugins/dataTables/fixedHeader.dataTables.min.css" rel="stylesheet"></link>
        <!-- <link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet"></link> -->
        <!-- <link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet"></link> -->
        <link href="js/alertifyjs/css/alertify.css" rel="stylesheet"></link>

        <!-- Mainly scripts -->
        <script src="<?=base_url(); ?>js/jquery-2.1.1.js"></script>
        <script src="<?=base_url(); ?>js/bootstrap.min.js"></script>
        <script src="<?=base_url(); ?>js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script src="<?=base_url(); ?>js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

        <!-- Data Tables -->
        <script src="<?=base_url(); ?>js/plugins/dataTables/jquery.dataTables.js"></script>
        <script src="<?=base_url(); ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>
        <script src="<?=base_url(); ?>js/plugins/dataTables/dataTables.responsive.js"></script>
        <script src="<?=base_url(); ?>js/plugins/dataTables/dataTables.tableTools.min.js"></script>        
        <script src="<?=base_url(); ?>js/plugins/dataTables/dataTables.fixedHeader.min.js"></script>       
        <script src="<?=base_url(); ?>js/plugins/dataTables/fixedHeader.bootstrap.min.js"></script>

        <script src="<?=base_url(); ?>js/manage_tables.js"></script>
        <script src="<?=base_url(); ?>js/jquery.form.min.js"></script>

       <!-- charts -->
       <script src="<?=base_url();?>js/chart.js"></script>
       <link href="<?=base_url(); ?>css/chart.css" rel="stylesheet"></link>

        <!-- Jquery Validate -->
        <script src="<?=base_url(); ?>js/plugins/validate/jquery.validate.min.js"></script>

        <!-- Toastr script -->
        <script src="<?=base_url(); ?>js/plugins/toastr/toastr.min.js"></script>

        <script src="<?=base_url(); ?>js/jquery.autocomplete/dist/jquery.autocomplete.js" type="text/javascript" charset="UTF-8"></script>

        <script src="<?=base_url(); ?>js/plupload/plupload.full.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
        <script src="<?=base_url(); ?>js/alertifyjs/alertify.js"></script>
        <script src="<?=base_url(); ?>js/jquery-migrate-1.2.1.js"></script>
        <script src="<?=base_url(); ?>js/jquery.blockUI.js"></script>
        <script src="<?=base_url(); ?>js/common.js" type="text/javascript" language="javascript" charset="UTF-8"></script>

        <!-- pdf export -->

        <script type="text/javascript" src="<?=base_url() ?>js/export_data/dataTables.buttons.min.js"></script>
        
        <script type="text/javascript" src="<?=base_url() ?>js/export_data/buttons.flash.min.js"></script>

        <script type="text/javascript" src="<?=base_url() ?>js/export_data/pdfmake.min.js"></script>

        <script type="text/javascript" src="<?=base_url() ?>js/export_data/vfs_fonts.js"></script>

        <script type="text/javascript" src="<?=base_url() ?>js/export_data/jszip.min.js"></script>

        <script type="text/javascript" src="<?=base_url() ?>js/export_data/buttons.html5.min.js"></script>

        <!-- favicon icon -->
        <link rel="shortcut icon" href="<?=base_url() ?>/favicon.ico" type="image/x-icon">

    </head>
    <body>

        <input type="hidden" id="token_hash" value="<?=$this->security->get_csrf_hash(); ?>" />
        <input type="hidden" id="site_url" value="<?=site_url() ?>" />

        <div id="wrapper">
            <nav class="navbar-default navbar-static-side fixed-menu" role="navigation">
                <div class="sidebar-collapse">
                    <div id="hover-menu"></div>
                    <ul class="nav metismenu" id="side-menu">
                        <li>
                            <div class="logopanel" style="margin-left: 0px; z-index: 99999;background: #E9573F">
                                <div class="profile-element"> 
                                    <h3 style="font-weight: normal; color: #fff;"><?=strtoupper($this->config->item('company')) ?></h3>
                                </div>
                                <div class="logo-element">
                                    JK
                                </div>
                            </div>
                        </li>

                        <li>

                            <!-- START : Left sidebar -->
                            <div class="nano left-sidebar">
                                <div class="nano-content">
                                    <ul class="nav nav-pills nav-stacked nav-inq">

                        <li>
                            <div class="leftpanel-profile">
                                <div class="text-center">
                                    <a href="<?= site_url("staffs/view/" . $user_info->person_id); ?>">
                                        <?php if (trim($user_info->photo_url) !== "" && file_exists( FCPATH  .  "/uploads/profile-" . $user_info->person_id . "/" . $user_info->photo_url ) ):  ?>
                                        <img src="<?= base_url("uploads/profile-" . $user_info->person_id . "/" . $user_info->photo_url); ?>" style="width:80px;height:80px" alt="" class="media-object img-circle" />
                                        <?php else: ?>
                                        <img src="imgs/user.png" style="width:80px;height:80px"  alt="" class="media-object img-circle" />
                                        <?php endif; ?>
                                    </a>
                                </div>
                                <div class="profile-name text-center" style="white-space:wrap;padding-top: 12px;">

                                    <h4 class="media-heading"><?= ucwords($user_info->first_name); ?> <?= ucwords($user_info->last_name); ?></h4>

                                    <h5 class="" style="color: #fff;"><?= ucwords($user_info->phone_number); ?> </h5>
                                    
                                </div>
                            </div>


                        </li>
                                        <?php $selected = (strpos(strtolower(substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1)), strtolower('home')) !== FALSE) ? "active" : ""; ?>
                                        <li class="<?= $selected; ?>">
                                            <a href="<?=  site_url("home")?>"><i class="fa fa-home"></i> <span class="nav-label">Dashboard</span></a>
                                        </li>

                                        <?php foreach ($this->db->order_by("sort","asc")->get('modules')->result() as $module) : ?>

                                            <?php
                                            $select_list = ($this->uri->segment(1) === $module->module_id && $this->uri->segment(2) !== "view") ? "active" : "";
                                            $select_new = ($this->uri->segment(1) === $module->module_id && $this->uri->segment(2) === "view") ? "active" : "";
                                            ?>

                                            <?php if (!in_array($module->controller, ["config", "apartments/calculator", "overdues", "calculator"])): ?>
                                                
                                                <li class="nav-parent <?= ($select_new !== "") ? $select_new : $select_list; ?>">
                                                    <a href="<?=site_url("$module->controller"); ?>" title="<?=$module->module_id; ?>">
                                                        <i><?= str_replace("font-size: 50px", "font-size: 16px", $module->icons); ?></i>
                                                        <span class="nav-label"><?=$module->module_id ?></span>
                                                    </a>

                                                     <ul class="children nav">
                                                        <?php if ($module->module_id !== "messages" && $module->module_id !== "staff"): ?>

                                                            <li><a href="<?=site_url("$module->controller"); ?>/view/-1" class="<?= $select_new; ?>">New</a></li>

                                                            <li><a href="<?=site_url("$module->controller"); ?>" class="<?= $select_list; ?>">List</a></li>

                                                        <?php elseif ($module->module_id === "staff" && $user_info->role === "mgmt"): ?>

                                                            <li><a href="<?=site_url("$module->controller"); ?>/view/-1" class="<?= $select_new; ?>">New</a></li>

                                                            <li><a href="<?=site_url("$module->controller"); ?>" class="<?= $select_list; ?>">List</a></li>
                                                        
                                                        <?php elseif ($module->module_id === "staff" && $user_info->role !== "mgmt"): ?>

                                                            <li><a href="<?=site_url("$module->controller"); ?>" class="<?= $select_list; ?>">List</a></li>

                                                        <?php elseif ($module->module_id === "messages"): ?>                                                            
                                                            <li><a href="<?=site_url("$module->controller"); ?>/view/-1" class="<?= ($this->uri->segment(1) === "messages" && $this->uri->segment(2) === "view" ? "active" : ""); ?>">New</a></li>
                                                            <li><a href="<?=site_url("messages/inbox"); ?>" class="<?= ($this->uri->segment(2) === "inbox" ? "active" : ""); ?>">Inbox</a></li>
                                                            <li><a href="<?=site_url("messages/outbox"); ?>" class="<?= ($this->uri->segment(2) === "outbox" ? "active" : ""); ?>">Outbox</a></li>

                                                        <?php endif; ?>
                                                    </ul>

                                                </li>

                                            <?php else: ?>

                                                <?php $selected = ($this->uri->segment(1) === $module->controller) ? "active" : ""; ?>
                                                <li class="<?= $selected; ?>">
                                                    <a href="<?=site_url("$module->controller"); ?>"><i><?= str_replace("font-size: 50px", "font-size: 16px", $module->icons); ?></i> <span class="nav-label"><?=$module->module_id; ?></span></a>
                                                </li>
                                            <?php endif; ?>
                                        <?php endforeach; ?> 


                                        <!-- <li>
                                            <a href="#" id="modalButtton" type="button" data-toggle="modal" data-target="#myModal"><i class="lnr lnr-question-circle"></i> &nbsp;<span class="nav-parent">HOW TO</span></a>
                                        </li> -->
                                    </ul>
                                </div>
                            </div>
                            <!-- END : Left sidebar -->

                        </li>
                    </ul>
                </div>
            </nav>

            <div id="page-wrapper" class="gray-bg">
                <!-- BEGIN HEADER -->
                <div id="header">
                    <nav class="navbar navbar-fixed-top show-menu-full" id="nav" role="navigation" style="margin-bottom: 0; height: 62px;">
                        <div class="navbar-header">
                            <a class="navbar-minimalize minimalize-styl-2" href="javascript:void(0)"><i class="fa fa-bars" style="font-size:27px;color: #e9573f"></i> </a>

                            <a class="minimalize-styl-2 hide-small" style="color: #e9573f;padding: .6em;" href="javascript:void(0)"><i class="fa fa-calendar"></i> &nbsp; <?=date("d M Y", time()) ?> </a>


                            <!-- <form role="search" class="navbar-form-custom">
                                <div class="form-group">
                                    <div class="kform theme-primary">
                                        <div>
                                            <label class="field append-icon">
                                                <input type="text" name="search" id="search" class="gui-input" placeholder="Type your search here..." />
                                                <label for="search" class="field-icon">
                                                    <i class="fa fa-search"></i>
                                                </label>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form> -->


                        </div>

                        <style type="text/css">


                        </style>

                        <ul class="nav navbar-top-links navbar-right" style="display: inline-flex;">

                           <?php if(strpos(strtolower($_SERVER['PHP_SELF']),'home')){ ?> 

                            <li class="dropdown">

                                <a href="#" class="dropdown-toggle" id="reportrange"  style="color: #e9573f !important" data-toggle="dropdown" aria-expanded="true">

                                    <span class="fa fa-clock-o" style="font-weight: normal; font-size: 1.6em;" title="Stat settings"></span>
                                    
                                </a>

                            </li>

                            <?php } ?>

                            <li class="dropdown">

                                <a style="color: #e9573f !important" title="Delayed apartments" class="dropdown-toggle" data-toggle="dropdown">

                                    <i class="fa fa-bomb" style="color: #e9573f !important; font-size: 1.6em"></i>

                                        <span class="badge" id="overdue_count" style="position: absolute; top: 9px; right: 8px"></span>
                                    
                                </a>

                                <ul class="dropdown-menu m-t-xs" style="border-radius: 0px; width: 300px;">

                                    <li style="padding-bottom: .3em"><a href="<?=site_url() ?>/overdues"> All Overdue Payments <i class="pull-right fa fa-long-arrow-right text-danger" style="padding-top: .5em"></i></a></li>

                                </ul>

                            </li>

                            <li class="divider"> </li>

                            <li class="dropdown">

                                <a href="#" title="Logout, about KCA Hostels" class="dropdown-toggle" style="color: #e9573f; font-size: 16px; display: flex; justify-content: center; vertical-align: middle;" data-toggle="dropdown" aria-expanded="true">
                                    <?php if (trim($user_info->photo_url) !== "" && file_exists( FCPATH  .  "/uploads/profile-" . $user_info->person_id . "/" . $user_info->photo_url ) ):  ?>
                                    <img src="<?= base_url("uploads/profile-" . $user_info->person_id . "/" . $user_info->photo_url); ?>" style="width:25px;height:25px; border: 1px solid #e9573f; padding: 1px" alt="" class="media-object img-circle" />
                                    <?php else: ?>
                                    <img src="imgs/user.png" style="width:25px;height:25px; border: 1px solid #e9573f; padding: 1px"  alt="" class="media-object img-circle" />
                                    <?php endif; ?>

                                </a>

                                <ul class="dropdown-menu m-t-xs" style="border-radius: 0px">

                                    <li><a href="<?= site_url("staffs/view/" . $user_info->person_id); ?>"><i class="fa fa-circle text-success"></i> &nbsp; My Profile</a></li>

                                    <li><a href="<?= site_url("home/logout")?>"><i class="fa fa-sign-out"></i> &nbsp; Logout</a></li>

                                    <li class="divider"></li>

                                    <li><a href="#" id="modalButtton" type="button" data-toggle="modal" data-target="#modal_abt_apam"><i class="fa fa-smile-o"></i> &nbsp; About KCA Hostels</a></li>

                                </ul>

                            </li>
                        </ul>
                    </nav>
                </div>
                <!-- END HEADER -->

                <div style="clear: both; height: 61px;"></div>

                <!-- BEGIN CONTENT -->
                <div class="wrapper wrapper-content">

        <div class="modal fade" id="myModal" role="dialog">

        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">

            <div class="modal-header" style="background: #e9573f">

              <button type="button" class="close" data-dismiss="modal">&times;</button>

              <h4 id="modal-title" style="color: white"> HOW TO ..... </h4>

            </div>

            <div class="modal-body" >

              <div class="panel-group" id="accordion" >

                            <div class="panel panel-default">

                                <div class="panel-heading">

                                    <h4 class="panel-title" style="color: DarkCyan">

                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" >
                                        <b>How to get summary of total payments, apartments and epenses within a specified period of time?</b>

                                    </a>

                                    </h4>

                                </div>

                                <div id="collapseOne" class="panel-collapse collapse">

                                    <div class="panel-body">
                                    <p>
                                   		
                                   		<ol style="color: SeaGreen">
                                   			
                                   			<li><h5><b>Go to the home page.</b></h5></li>

                                   			<li><h5><b>On the right side above there are several icons.</b></h5></li>

                                   			<li><h5><b>Select the first icon from right side.</b></h5></li>

                                   			<li><h5><b>Select the summary duration of your choice, the system calculates the summary for you.</b></h5></li>
                                   			
                                   		</ol> 	

                                    </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="panel panel-default">

                                <div class="panel-heading">

                                    <h4 class="panel-title" style="color: DarkCyan">

                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">

                                    	<b>How to add details of a new tenant into the system?</b>

                                    </a>
                                    </h4>
                                </div>

                                <div id="collapseTwo" class="panel-collapse collapse">

                                    <div class="panel-body">

                                    <p>
                                    	
                                    	<ol style="color: SeaGreen">
                                    		
                                    		<li><h5><b>Click on "tenantS" tab while on the home page.</b></h5></li>

                                    		<li><h5><b>Select "new" among the options which appears.</b></h5></li>

                                    		<li><h5><b>Enter details of the tenants in the form which appears.</b></h5></li>

                                    		<li><h5><b>Remember to fill all the required fields.</b></h5></li>

                                    		<li><h5><b>Save the tenants details.</b></h5></li>

                                    		<li><h5><b>A prompt message "tenant updated successfully" appeas after you have saved the tenant's details.</b></h5></li>

                                    	</ol>

                                    </p>

                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">

                                <div class="panel-heading">

                                    <h4 class="panel-title" style="color: DarkCyan">

                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse3">

                                    	<b>How to view the total number of tenants in the system?</b>

                                    </a>
                                    </h4>
                                </div>

                                <div id="collapse3" class="panel-collapse collapse">
                                    <div class="panel-body">
                                    <p>
                                    	
                                    	<ol style="color: SeaGreen">
                                    		
                                    		<li><h5><b>Click on "tenantS" tab while on the home page.</b></h5></li>

                                    		<li><h5><b>Select "list" among the options which appears.</b></h5></li>

                                    		<li><h5><b>All the total number of tenants appears.</b></h5></li>

                                    	</ol>

                                    </p>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">

                                <div class="panel-heading">

                                    <h4 class="panel-title" style="color: DarkCyan">

                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse4">

                                    	<b>How to lend a new apartment to tenant ?</b>

                                    </a>
                                    </h4>
                                </div>

                                <div id="collapse4" class="panel-collapse collapse">
                                    <div class="panel-body">
                                    <p>
                                    	
                                    	<ol style="color: SeaGreen">
                                    		
                                    		<li><h5><b>Click on "apartmentS" tab while on the home page.</b></h5></li>

                                    		<li><h5><b>Select "new" among the options which appears.</b></h5></li>

                                    		<li><h5><b>Enter tenant's apartment details in the form which appears.</b></h5></li>

                                    		<li><h5><b>Remember to fill all the required fields.</b></h5></li>

                                    		<li><h5><b>Save the apartment details.</b></h5></li>

                                    		<li><h5><b>A prompt message "apartment added successfully" appeas after you have saved the apartment details.</b></h5></li>
                                    		
                                    	</ol>

                                    </p>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">

                                <div class="panel-heading">
                                    <h4 class="panel-title" style="color: DarkCyan">

                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse5">

                                    	<b>How to view the list of apartments lended to tenants?</b>

                                    </a>
                                    </h4>
                                </div>

                                <div id="collapse5" class="panel-collapse collapse">
                                    <div class="panel-body">
                                    <p>
                                    	
                                    	<ol style="color: SeaGreen">
                                    		
                                    		<li><h5><b>Click on "apartmentS" tab while on the home page.</b></h5></li>

                                    		<li><h5><b>Select "List" among the options which appears.</b></h5></li>

                                    		<li><h5><b>All the total number of apartments appears.</b></h5></li>
                                    		
                                    	</ol>

                                    </p>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">

                                <div class="panel-heading">

                                    <h4 class="panel-title" style="color: DarkCyan">

                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse6">

                                    	<b>How to add details of a new payment made by a tenant into the system?</b>

                                    </a>
                                    </h4>
                                </div>

                                <div id="collapse6" class="panel-collapse collapse">
                                    <div class="panel-body">
                                    <p>
                                    	
                                    	<ol style="color: SeaGreen">
                                    		
                                    		<li><h5><b>Click on "PAYMENTS" tab while on the home page.</b></h5></li>

                                    		<li><h5><b>Select "new" among the options which appears.</b></h5></li>

                                    		<li><h5><b>Enter details of the new payment made in the form which appears.</b></h5></li>

                                    		<li><h5><b>Remember to fill all the required fields.</b></h5></li>

                                    		<li><h5><b>Remember to fill all the required fields.</b></h5></li>

                                    		<li><h5><b>Save the payment details.</b></h5></li>

                                    		<li><h5><b>A prompt message "Payment added successfully" appeas after you have saved the payment details.</b></h5></li>
                                    		

                                    	</ol>

                                    </p>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">

                                <div class="panel-heading">

                                    <h4 class="panel-title" style="color: DarkCyan">

                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse7">

                                    	<b>How to view the list of payments made by tenants?</b>

                                    </a>
                                    </h4>
                                </div>

                                <div id="collapse7" class="panel-collapse collapse">
                                    <div class="panel-body">
                                    <p>
                                    	
                                    	<ol style="color: SeaGreen">
                                    		
                                    		<li><h5><b>Click on "PAYMENTS" tab while on the home page.</b></h5></li>

                                    		<li><h5><b>Select "List" among the options which appears.</b></h5></li>

                                    		<li><h5><b>All the total number of payments made appears.</b></h5></li>
                                    		
                                    	</ol>

                                    </p>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">

                                <div class="panel-heading">

                                    <h4 class="panel-title" style="color: DarkCyan">

                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse8">

                                    	<b>How to view the the total number of delayed apartments?</b>

                                    </a>
                                    </h4>
                                </div>

                                <div id="collapse8" class="panel-collapse collapse">

                                    <div class="panel-body">

                                    <p>
                                    	
                                    	<ol style="color: SeaGreen">
                                    		
                                    		<li><h5><b>Click on "DELAYED apartmentS" tab while on the home page.</b></h5></li>

                                    		<li><h5><b>The list appears with total number of delayed apartments.</b></h5></li>
                                    		
                                    	</ol>

                                    </p>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">

                                <div class="panel-heading">

                                    <h4 class="panel-title" style="color: DarkCyan">

                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse9">

                                    	<b>How to add details of a new staff into the system?</b>

                                    </a>
                                    </h4>
                                </div>

                                <div id="collapse9" class="panel-collapse collapse">

                                    <div class="panel-body">

                                    <p>
                                    	
                                    	<ol style="color: SeaGreen">
                                    		
                                    		<li><h5><b>Click on "staffS" tab while on the home page.</b></h5></li>

                                    		<li><h5><b>Select "New" among the options which appears.</b></h5></li>

                                    		<li><h5><b>Enter details of the new staff in the form which appears.</b></h5></li>

                                    		<li><h5><b>Remember to fill all the required fields.</b></h5></li>

                                    		<li><h5><b>Save the staff details.</b></h5></li>

                                    		<li><h5><b>A prompt message "staff added successfully" appeas after you have saved the payment details.</b></h5></li>

                                    	</ol>

                                    </p>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">

                                <div class="panel-heading">

                                    <h4 class="panel-title" style="color: DarkCyan">

                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse10">

                                    	<b>How to view the list of exixting staffs?</b>

                                    </a>
                                    </h4>
                                </div>

                                <div id="collapse10" class="panel-collapse collapse">

                                    <div class="panel-body">

                                    <p>
                                    	
                                    	<ol style="color: SeaGreen">
                                    		
                                    		<li><h5><b>Click on "staffS" tab while on the home page.</b></h5></li>

                                    		<li><h5><b>Select "List" among the options which appears.</b></h5></li>

                                    		<li><h5><b>The list appears with total number of existing staffs.</b></h5></li>

                                    	</ol>

                                    </p>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">

                                <div class="panel-heading">

                                    <h4 class="panel-title" style="color: DarkCyan">

                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse11">

                                    	<b>How to add details of a new expenditure into the system?</b>

                                    </a>
                                    </h4>
                                </div>

                                <div id="collapse11" class="panel-collapse collapse">

                                    <div class="panel-body">

                                    <p>
                                    	
                                    	<ol style="color: SeaGreen">
                                    		
                                    		<li><h5><b>Click on "EXPENSES" tab while on the home page.</b></h5></li>

                                    		<li><h5><b>Select "New" among the options which appears.</b></h5></li>

                                    		<li><h5><b>Enter details of the new expenditure in the form which appears.</b></h5></li>

                                    		<li><h5><b>Remember to fill all the required fields.</b></h5></li>

                                    		<li><h5><b>Save the expenditure details.</b></h5></li>

                                    		<li><h5><b>A prompt message "Expense added successfully" appeas after you have saved the payment details.</b></h5></li>

                                    	</ol>

                                    </p>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">

                                <div class="panel-heading">

                                    <h4 class="panel-title" style="color: DarkCyan">

                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse12">

                                    	<b>How to view the list  of expenses made?</b>

                                    </a>
                                    </h4>
                                </div>

                                <div id="collapse12" class="panel-collapse collapse">

                                    <div class="panel-body">

                                    <p>
                                    	
                                    	<ol style="color: SeaGreen">
                                    		
                                    		<li><h5><b>Click on "EXPENSES" tab while on the home page.</b></h5></li>

                                    		<li><h5><b>Select "List" among the options which appears.</b></h5></li>

                                    		<li><h5><b>The list appears with total number of expenses made.</b></h5></li>

                                    	</ol>

                                    </p>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">

                                <div class="panel-heading">

                                    <h4 class="panel-title" style="color: DarkCyan">

                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse14">

                                    	<b>How to view the list  contacts of tenant in the system?</b>

                                    </a>
                                    </h4>
                                </div>

                                <div id="collapse14" class="panel-collapse collapse">

                                    <div class="panel-body">

                                    <p>
                                    	
                                    	<ol style="color: SeaGreen">
                                    		
                                    		<li><h5><b>Go to the home page.</b></h5></li>

                                    		<li><h5><b>On the right side above there are several icons.</b></h5></li>

                                    		<li><h5><b>Select the second icon from right side.</b></h5></li>

                                    		<li><h5><b>Select  "Contacts" in menu which appears</b></h5></li>

                                    		<li><h5><b>All list of contacts appears </b></h5></li>

                                    	</ol>

                                    </p>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">

                                <div class="panel-heading">

                                    <h4 class="panel-title" style="color: DarkCyan">

                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">

                                    	<b>How to configure or edit the settings of the system??</b>

                                    </a>
                                    </h4>
                                </div>

                                <div id="collapseThree" class="panel-collapse collapse">

                                    <div class="panel-body">

                                    <p>
                                    	
                                    	<ol style="color: SeaGreen">
                                    		
                                    		<li><h5><b>Click on "SETTINGS" tab while on the home page.</b></h5></li>

                                    		<li><h5><b>Enter the details want to change in the fields in form which appears</b></h5></li>

                                    		<li><h5>Remember to fill the required fields<b></b></h5></li>

                                    		<li><h5><b>Remember to fill all the required fields.</b></h5></li>

                                    		<li><h5><b>Then save changes you have made</b></h5></li>

                                    		<li><h5><b>A prompt message "Settings updated successfully" appeas after you have saved the 
                                    		settings details.</b></h5></li>

                                    	</ol>

                                    </p>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">

                                <div class="panel-heading">
                                    <h4 class="panel-title" style="color: DarkCyan">

                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse15">

                                    	<b>How to view a specific tenant?</b>

                                    </a>
                                    </h4>
                                </div>

                                <div id="collapse15" class="panel-collapse collapse">

                                    <div class="panel-body">

                                    <p>
                                    	
                                    	<ol style="color: SeaGreen">
                                    		
                                    		<li><h5><b>Click on "tenantS" tab while on the home page.</b></h5></li>

                                    		<li><h5><b>Select "List" among the options which appears.</b></h5></li>

                                    		<li><h5><b>The list tenants appears.</b></h5></li>

                                    		<li><h5><b>Click the round bluish button on the left side on the "action" column of the tenant you want to view.</b></h5></li>

                                    		<li><h5><b>The details of the tenant you have selected appears.</b></h5></li>

                                    	</ol>

                                    </p>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">

                                <div class="panel-heading">

                                    <h4 class="panel-title" style="color: DarkCyan">

                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse16">

                                    	<b>How to print a statement of a certain tenant?</b>

                                    </a>
                                    </h4>
                                </div>

                                <div id="collapse16" class="panel-collapse collapse">

                                    <div class="panel-body">

                                    <p>
                                    	
                                    	<ol style="color: SeaGreen">
                                    		
                                    		<li><h5><b>Click on "tenantS" tab while on the home page.</b></h5></li>

                                    		<li><h5><b>Select "List" among the options which appears.</b></h5></li>

                                    		<li><h5><b>The list tenants appears.</b></h5></li>

                                    		<li><h5><b>Click the round yellowish button on the left side on the "action" column of the tenant you want to view.</b></h5></li>

                                    		<li><h5><b>The system downloads and saves the statement for you</b></h5></li>

                                    		<li><h5><b>Open the statement and print</b></h5></li>

                                    	</ol>

                                    </p>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">

                                <div class="panel-heading">

                                    <h4 class="panel-title" style="color: DarkCyan">

                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse13">

                                    	<b>How to log out of the system?</b>

                                    </a>
                                    </h4>
                                </div>

                                <div id="collapse13" class="panel-collapse collapse">

                                    <div class="panel-body">

                                    <p>
                                    	
                                    	<ol style="color: SeaGreen">
                                    		
                                    		<li><h5><b>Go to the home page.</b></h5></li>

                                    		<li><h5><b>On the right side above there are several icons.</b></h5></li>

                                    		<li><h5><b>Click the second icon from right side.</b></h5></li>

                                    		<li><h5><b>Click on "Logout" among the menu which appears.</b></h5></li>
                                    		
                                    		<li><h5><b>The system logs you out.</b></h5></li>

                                    	</ol>

                                    </p>
                                    </div>
                                </div>
                            </div>

                        </div>
            </div>
            <div class="modal-footer">
              <p class="text-center">If there is mising information that could be helpful on this documentation. kindly inform the developers for an instant update.</p>
            </div>
          </div>

        </div>
      </div> <!-- end of Modal -->


      <!-- ABOUT PROJECT apam MODAL -->

        <div class="modal fade" id="modal_abt_apam" role="dialog">

        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">

            <div class="modal-header" style="background: #e9573f">

              <button type="button" class="close" data-dismiss="modal">&times;</button>

              <h4 id="modal-title" style="color: white"> KCA Hostels </h4>

            </div>

            <div class="modal-body" >

                <h4>ABOUT KCA Hostels</h4>

                <p>KCA Hostels is a Management Information System fashioned to help in and computerize the business operations of a hostels' Institution. Among the services than KCA Hostels does offer is tenants/ students record keeping, apartment/hostel, payments and Firm expenses record keeping, Profit or loss, income & expense calculation within standard time ranges, apartment/hostel Interest and Penalty auto calculation among others.</p>

                <hr>

                <h4>THE DEVELOPERS</h4>

                <p>The developer of KCA Hostels, David Mwania, is experienced software developer driven by passion of software development and Graphic design.</p>

                <p>Other products by this developer can be found on his website, You want to find out what they can do? .....</p>

                <div class="row text-center">
                    
                    <a target="_blank" href="https://www.davidmwania.com" class="btn btn-sm btn-default" style="background: #e9573f">Visit the developer website</a>
                </div>
            </div>
          </div>

        </div>
      </div> 

      <!-- end of Modal -->