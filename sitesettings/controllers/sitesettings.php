<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class SiteSettings extends Main_Controller {
    /**
     * SiteSettings class variables 
     * @author Khurram
     */

    /**
     * @var $module_name String
     */
    private $module_name;

    /**
     * @var $module_methods
     */
    private $_module_methods = array('index', 'edit');

    /**
     *
     * @var array 
     */
    private $_data;

    /**
     * Constructor 
     * @author Khurram
     */
    function __construct() {
        // calling parent constructor
        parent::__construct();

        // Set methods property
        $this->setMethods($this->_module_methods);

        // Set Module name.
        $this->module_name = strtolower(pathinfo(__FILE__, PATHINFO_FILENAME));
        $this->_data['module_name'] = $this->module_name;

        // Load Model.
        $this->load->model($this->module_name . '/model_' . $this->module_name, 'mss');

        // setting Title of the page
        $this->setTitle('Site Settings');
    }

    /**
     * Default method, Showing the users listing page page
     * 
     * @access public
     * @return void
     * @author Khurram
     */
    public function index() {

        try {

            // Load SiteRcopia model
            $this->load->model('sitercopia/model_sitercopia', 'msr');

            // Check if the site is Rcopia enabled
            $this->_data['rcopia_enabled'] = $this->msr->isSiteRcopiaEnabled($this->msr->site_id);

            // Load pagination library.
            $this->load->library('pagination');
            $this->mss->fetchAll();

            // Pagination config options.
            $config['base_url'] = base_url() . $this->module_name . '/index';
            $config['total_rows'] = $this->mss->numRows;
            $config['per_page'] = 20;

            // Initialize the pagination library with configurations.
            $this->pagination->initialize($config);

            // Setup menu positions for specific action.
            $positions_arr = array("Top", "Left", "Footer", "Cpanel");
            $this->_load_menu($positions_arr);

            // Set the template.
            $this->setPageTemplate($this->_template_private);

            // Get data
            $this->_data['settings'] = $this->mss->fetchAll($config['per_page'], $this->uri->segment(3));

            // Render the listing page.
            $this->_view('index', $this->_data); // application/sitesettings/views/index.php
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /**
     * Changes the status of a setting
     * 
     * @access public
     * @return void
     * @author Khurram
     */
    public function changeStatus() {

        try {

            // Get the id of the record from uri.
            $id = (int) $this->uri->segment(4);

            // Get the status code from uri.
            $status = (int) $this->uri->segment(6);

            // Set up the data for status update.
            $data = array(
                'published' => $status,
            );

            // Clear the model class properties.
            $this->mss->clear();

            // Set the id property of the model.
            $this->mss->setID($id);

            // Set the update data before calling the save.
            $this->mss->setData($data);

            //Set Validation Array
            $validation = array(
                'published' => 'required'
            );

            //set Validation Rules
            $this->mss->setValidation($validation);

            // Call the model's save method and capture the value returned.
            $res = $this->mss->save();

            // If model's save method doesn't not succeeds.
            if ($res === FALSE) {

                // Throw an exception.
                throw new Exception('Status not saved.');
                exit;
            }

            // Sets success msg in the template.
            $this->setSuccess('Status has been successfully updated');

            // Redirect to listing page.
            redirect($this->module_name);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /**
     * Add a new setting
     * 
     * @access public
     * @return void
     * @author Khurram
     */
    public function edit() {

        try {

            // Setup menu positions for specific action.
            $positions_arr = array("Top", "Left", "Footer", "Cpanel");
            $this->_load_menu($positions_arr);

            // Set the template.
            $this->setPageTemplate($this->_template_private);

            // Get the id of the record from uri.
            $id = (int) $this->uri->segment(4);

            // Fetch Record by id
            $this->_data['setting'] = $this->mss->fetchById($id);

            // Set validation rules
            $this->form_validation->set_rules('opt_name', 'Setting Name', 'trim|required');
            $this->form_validation->set_rules('opt_value', 'Setting Value', 'trim|required');

            // If the validation fails or the form is not submitted.
            if ($this->form_validation->run() === FALSE) {

                // Render the listing page.
                $this->_view('edit', $this->_data); // application/sitesettings/views/edit.php
            } else {
                // Otherwise
                // Get input
                $opt_name = $this->input->post('opt_name');
                $opt_value = $this->input->post('opt_value');

                // Build data
                $data = array(
                    'opt_name' => $opt_name,
                    'opt_value' => $opt_value,
                );

                // If updated by id then
                if ($this->mss->updateById($data, $id)) {

                    // Set success message in the template.
                    $this->setSuccess('Record successfully updated!');

                    // Redirect to listing page.
                    redirect($this->module_name);
                } else {

                    // Sets error msg in the template.
                    $this->setError('Error in updating record');

                    // Redirect to listing page.
                    redirect($this->module_name);
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /**
     * Soft deletes a setting
     * 
     * @access public
     * @return void
     * @author Khurram
     */
    public function del() {
        try {
            // Get the id of the record from uri.
            $id = (int) $this->uri->segment(4);

            // If the delete is successful then
            if ($this->mss->del($id)) {

                // Sets success msg in the template.
                $this->setSuccess('Record has been successfully deleted');

                // Redirect to listing page.
                redirect($this->module_name);
            } else {

                // Sets error msg in the template.
                $this->setError("Error in deleting record.");

                // Redirect to listing page.
                redirect($this->module_name);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /**
     * Returns the candidate methods for ACL.
     * 
     * @access public
     * @return array name of class methods
     * @author Khurram
     */
    public function getMethods() {
        try {
            // Return the module methods
            return $this->module_methods;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}

/* End of file Sitesettings.php */
/* Location: ./application/modules/sitesettings/controllers/Sitesettings.php */