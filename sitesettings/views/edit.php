<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="jumbotron box">
    <div class="row">
        <div class="span3 bs-docs-sidebar">
            <?php echo isset($template['partials']['Left_Menu']) ? $template['partials']['Left_Menu'] : ""; ?>
        </div><!--/.well -->
        <div class="span9">
            <?php echo anchor($module_name, '<< Back', 'title="Back to listing" class="btn btn-medium btn-primary pull-right"') ?>
            <h4 class="form-signin-heading">Add Setting</h4>
            <?php
            echo form_open('', array('name' => 'form-signin',
                'id' => 'frm_sitesettings_edit',
                'class' => 'form-signin'
            ));

            $setting = $setting[0];
            echo form_hidden('id', $setting->id);
            ?>
            <?php
            $opt_name = (isset($setting->opt_name)) ? $setting->opt_name : set_value('opt_name');
            echo form_hidden('opt_name', $opt_name);
            ?>
            <?php echo form_error('opt_name', '<div class="error">', '</div>'); ?>
            <strong><?php echo $setting->opt_title; ?></strong>
            <div style="clear:both; "></div>
            <?php
            $selectbox_items = array(
                'scheduler_start_day',
                'scheduler_end_day',
                'scheduler_break_start_time',
                'scheduler_break_end_time',
                'scheduler_start_time',
                'scheduler_end_time',
                'scheduler_time_interval',
                'disclaimer',
            );

            $opt_value = (isset($setting->opt_value)) ? $setting->opt_value : set_value('opt_value');

            if (isset($setting->opt_name) and ( in_array($setting->opt_name, $selectbox_items))) {

                /* @var $defaul_option Array */
                $defaul_option = array(
                    0 => 'Select',
                );

                if ($setting->opt_name == 'scheduler_start_day' or $setting->opt_name == 'scheduler_end_day') {

                    /* @var $options Array */
                    $options = array(
                        '0' => 'Sunday',
                        '1' => 'Monday',
                        '2' => 'Tuesday',
                        '3' => 'Wednesday',
                        '4' => 'Thursday',
                        '5' => 'Friday',
                        '6' => 'Saturday',
                    );
                }

                if ($setting->opt_name == 'scheduler_start_time' or
                        $setting->opt_name == 'scheduler_end_time'
                ) {

                    /* @var $options Array */
                    $options = array(
                        '0' => '00:00',
                        '1' => '01:00',
                        '2' => '02:00',
                        '3' => '03:00',
                        '4' => '04:00',
                        '5' => '05:00',
                        '6' => '06:00',
                        '7' => '07:00',
                        '8' => '08:00',
                        '9' => '09:00',
                        '10' => '10:00',
                        '11' => '11:00',
                        '12' => '12:00',
                        '13' => '13:00',
                        '14' => '14:00',
                        '15' => '15:00',
                        '16' => '16:00',
                        '17' => '17:00',
                        '18' => '18:00',
                        '19' => '19:00',
                        '20' => '20:00',
                        '21' => '21:00',
                        '22' => '22:00',
                        '23' => '23:00',
                    );
                }

                if ($setting->opt_name == 'scheduler_break_start_time' or
                        $setting->opt_name == 'scheduler_break_end_time') {

                    /* @var $options Array */
                    $options = array(
                        '0' => '00:00',
                        '0.5' => '00:30',
                        '1' => '01:00',
                        '1.5' => '01:30',
                        '2' => '02:00',
                        '2.5' => '02:30',
                        '3' => '03:00',
                        '3.5' => '03:30',
                        '4' => '04:00',
                        '4.5' => '04:30',
                        '5' => '05:00',
                        '5.5' => '05:30',
                        '6' => '06:00',
                        '6.5' => '06:30',
                        '7' => '07:00',
                        '7.5' => '07:30',
                        '8' => '08:00',
                        '8.5' => '08:30',
                        '9' => '09:00',
                        '9.5' => '09:30',
                        '10' => '10:00',
                        '10.5' => '10:30',
                        '11' => '11:00',
                        '11.5' => '11:30',
                        '12' => '12:00',
                        '12.5' => '12:30',
                        '13' => '13:00',
                        '13.5' => '13:30',
                        '14' => '14:00',
                        '14.5' => '14:30',
                        '15' => '15:00',
                        '15.5' => '15:30',
                        '16' => '16:00',
                        '16.5' => '16:30',
                        '17' => '17:00',
                        '17.5' => '17:30',
                        '18' => '18:00',
                        '18.5' => '18:30',
                        '19' => '19:00',
                        '19.5' => '19:30',
                        '20' => '20:00',
                        '20.5' => '20:30',
                        '21' => '21:00',
                        '21.5' => '21:30',
                        '22' => '22:00',
                        '22.5' => '22:30',
                        '23' => '23:00',
                        '23.5' => '23:30',
                    );
                }

                if ($setting->opt_name == 'scheduler_time_interval') {

                    /* @var $options Array */
                    $options = array(
                        '15' => 'Quarter of an hour',
                        '30' => 'Half an hour',
                        '60' => 'An Hour',
                    );
                }

                if ($setting->opt_name == 'disclaimer') {

                    /* @var $options Array */
                    $options = array(
                        '0' => 'No',
                        '1' => 'Yes',
                    );
                }

                // Build the dropdown box with options data and other configurations.
                echo form_dropdown('opt_value', $options, $opt_value, 'id="opt_value" tabindex="118" class="required"');
            } else {

                echo form_input(array('name' => 'opt_value',
                    'id' => 'opt_value',
                    'class' => 'input-block-level required',
                    'placeholder' => 'Setting Value',
                    'value' => $opt_value,
                    'maxlength' => '255',
                    'tabindex' => '112',
                    'type' => 'text',
                ));
            }
            ?>
            <?php echo form_error('opt_value', '<div class="error">', '</div>'); ?>
            <div style="clear:both; "></div>
            <?php
            echo form_submit(array('name' => 'add_submit',
                'id' => 'add_submit',
                'value' => 'Save',
                'tabindex' => '112',
                'class' => 'btn btn-large btn-primary',
                'type' => 'submit'
            ));
            ?>
            <?php echo form_close(); ?>
        </div>

    </div>
</div><!--/.fluid-container-->
