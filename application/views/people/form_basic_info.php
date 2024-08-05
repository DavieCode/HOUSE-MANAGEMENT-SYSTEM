
<div class="container-fluid" style="margin-top: 2em">

    <div class="col-sm-5">
        <label class="col-sm-5 control-label">
            Passport Photo : 
        </label>
        <div class="col-sm-7">
            <?php if( trim(trim($person_info->photo_url) !== "") && file_exists( FCPATH  . "/uploads/profile-" . $person_info->person_id . "/" . $person_info->photo_url ) ): ?>
            <img id="img-pic" src="<?= base_url("uploads/profile-" . $person_info->person_id . "/" . $person_info->photo_url); ?>" style="height:99px" />
            <?php else: ?>
            <img id="img-pic" src="imgs/80x80.png" style="height:99px" />
            <?php endif; ?>
            <div id="filelist"></div>
            <div id="progress" class="overlay"></div>

            <div class="progress progress-task" style="height: 4px; width: 15%; margin-bottom: 2px; display: none">
                <div style="width: 0%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="50" role="progressbar" class="progress-bar progress-bar-info">

                </div>                                    
            </div>

            <div id="container">
                <a id="pickfiles" href="javascript:;" class="btn btn-sm btn-info" style="min-width: 100px;" data-person-id="<?= $person_info->person_id; ?>">Browse</a> 
            </div>
        </div>
    </div>

    <div class="col-sm-7" style="padding: 0">

        <div class="form-group" style="padding-top: 1em">

            <label class="col-sm-3 control-label"><?=form_label('First name ', 'first_name', array('class' => 'required')); ?></label>
            <div class="col-sm-9" style="padding: 0">
                <input type="text" name="first_name" id="first_name" class="form-control" value="<?=$person_info->first_name ?>">
            </div>
        </div>
        <div class="form-group">

            <label class="col-sm-3 control-label"><?=form_label('Last name ', 'last_name', array('class' => 'required')); ?></label>
            <div class="col-sm-9" style="padding: 0">
                <?php
                echo form_input(
                        array(
                            'name' => 'last_name',
                            'id' => 'last_name',
                            'value' => $person_info->last_name,
                            'class' => 'form-control'
                        )
                );
                ?>
            </div>
        </div>
    </div>
</div>

<hr/>

<div class="form-group" style="padding-top: 2em">

    <label class="col-sm-2 control-label"><?=form_label('Email  :', 'email'); ?></label>
    <div class="col-sm-4">
        <?php
        echo form_input(
                array(
                    'name' => 'email',
                    'id' => 'email',
                    'value' => $person_info->email,
                    'class' => 'form-control'
                )
        );
        ?>
    </div>

    <label class="col-sm-2 control-label"><?=form_label( 'ID /Passport No:', 'id_number'); ?></label>
    <div class="col-sm-4">
        <?php
        echo form_input(
                array(
                    'name' => 'id_number',
                    'id' => 'id_number',
                    'value' => $person_info->id_number,
                    'class' => 'form-control'
                )
        );
        ?>
    </div>
</div>


<div class="form-group">

    <label class="col-sm-2 control-label"><?=form_label('Phone number:', 'id_number'); ?></label>
    <div class="col-sm-4">
        <?php
        echo form_input(
                array(
                    'name' => 'phone_number',
                    'id' => 'phone_number',
                    'value' => $person_info->phone_number,
                    'class' => 'form-control'
                )
        );
        ?>
    </div>

    <label class="col-sm-2 control-label"><?=form_label('Home Address:', 'home_address'); ?></label>
    <div class="col-sm-4">
        <?php
        echo form_input(
                array(
                    'name' => 'home_address',
                    'id' => 'home_address',
                    'value' => $person_info->home_address,
                    'class' => 'form-control'
                )
        );
        ?>
    </div>
</div>



