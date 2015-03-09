<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="jumbotron box">
    <div class="row">
        <div class="span3 bs-docs-sidebar">
            <?php echo isset($template['partials']['Left_Menu']) ? $template['partials']['Left_Menu'] : ""; ?>
        </div><!--/.well -->
        <div class="span9">
            <h4>Site Settings</h4>

            <div class="row">
                <div class="span1">
                    <strong>ID</strong>
                </div>
                <div class="span5">
                    <strong>Title</strong>
                </div>
                <div class="span2">
                    <strong>Actions</strong>
                </div>
            </div>
            <div id="list"> 
                <?php
                if ($settings[0]):
                    foreach ($settings as $setting) :
                        if ($setting->opt_title == 'Auto Add New Patients to Rcopia' and !$rcopia_enabled):
                        // Do nothing
                        else:
                            ?>
                            <div class="row">
                                <div class="span1">
                                    <?php echo $setting->id; ?>
                                </div>

                                <div class="span5">
                                    <?php echo $setting->opt_title; ?>
                                </div>
                                <div class="span3">
                                    <?php echo anchor($module_name . '/edit/id/' . $setting->id, 'Edit', 'title="Edit" class="btn btn-small btn-info"') ?>
                                </div>
                            </div>
                        <?php
                        endif;
                    endforeach;
                endif;
                ?>
                <?php echo $this->pagination->create_links(); ?>
            </div>
        </div>
    </div>
</div><!--/.fluid-container-->
