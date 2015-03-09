<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * SiteSettings Model Class
 *
 * @package		SiteSettings
 * @subpackage          Libraries
 * @category            Libraries
 * @author		Khurram
 * @link		
 */
class Model_SiteSettings extends MY_Model {
    /**
     * Variables
     */

    /**
     *
     * @var string 
     */
    private $_table = "artchart_sites_settings";

    /**
     *
     * @var string 
     */
    private $_primarykey = "id";

    /**
     * Constructor
     * 
     * @access public
     * @author Khurram
     */
    public function __construct() {
        //Calls the parent's constructor.
        parent::__construct();

        //Sets tablename and table fields.
        $this->setTableData($this->_table);

        //Sets table primary key.
        $this->setPrimaryKey($this->_primarykey);
    }

    /**
     * Overrides the parent function
     * 
     * @param string $table
     */
    public function setTableData($table) {
        parent::setTableData($table);
        $this->_table = $table;
    }

    /**
     * Overrides the parent function
     * 
     * @param string $key
     */
    public function setPrimaryKey($key) {
        parent::setPrimaryKey($key);
        $this->_primarykey = $key;
    }

    /**
     * Updates setting value
     * 
     * @access public
     * @param array $data
     * @param integer $id
     * @return boolean TRUE on success otherwise FALSE
     * @author Khurram
     */
    public function updateById($data, $id) {

        try {

            // Clear properties
            $this->clear();

            // Set data
            $this->setData($data);

            // Set validation array
            $validation = array(
                'opt_name' => 'required',
                'opt_value' => 'required',
            );

            // Set validation
            $this->setValidation($validation);

            // Set id
            $this->setID($id);

            // Save Data
            $this->save();

            // If there's an error then
            if ($this->getErrors('')) {

                // Return FALSE
                return FALSE;
            } else {
                // Otherwise
                // Return TRUE
                return TRUE;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /**
     * Fetches record by id
     * 
     * @access public
     * @param integer $id Id of the setting
     * @return resultset row of the setting according to id
     * @author Khurram
     */
    public function fetchById($id) {

        try {

            // If the id is set and greater than zero
            if (isset($id) and $id > 0 and is_numeric($id)) {

                // Clear properties
                $this->clear();

                // Fetch data by id
                return $this->fetch('*', 'id = ' . $id . ' AND site_id = ' . $this->site_id);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /**
     * Gets all settings for the current site.
     * 
     * @access public
     * @return resultset The results from the settings table for current site.
     * @author Khurram
     */
    public function fetchAll($limit = NULL, $offset = 0) {

        try {

            // Clear properties
            $this->clear();

            // Set table
            $this->setTableData('artchart_sites_settings');

            // Fetch active patients and return to controller
            return $this->fetch('*', "site_id = " . $this->site_id . " 
                                    AND 
                                is_deleted = 0 ", NULL, $limit, $offset, NULL
            );
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /**
     * Get the value of the setting from settings table for current site.
     * 
     * @param string $setting
     * @return mixed The value of the setting property
     * @author Khurram
     */
    public function getSettingValue($setting, $site_id = NULL) {

        try {

            // Clear properties
            $this->clear();

            // Set table
            $this->setTableData('artchart_sites_settings');

            // Set site id from model if site id is not given as a parameter
            $site_id = isset($site_id) ? $site_id : $this->site_id;

            // Fetch the value for setting
            $res = $this->fetch('opt_value', "opt_name = '" . $setting . "' AND published = 1 AND is_deleted = 0 AND site_id = " . $site_id);

            // If the value of setting is found
            if ($res) {

                // Extract the value from the result
                $opt_value = $res[0]->opt_value;

                // Return the value of the setting
                return $opt_value;
            }

            // Otherwise return FALSE
            return FALSE;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /**
     * Soft deletes the record
     * 
     * @access public
     * @param integer $id
     * @return boolean TRUE on success and FALSE on failure.
     * @author Khurram
     */
    public function del($id) {

        try {

            // Clear properties
            $this->clear();

            // Set ID value
            $this->setID($id);

            // Build data
            $data = array(
                'is_deleted' => 1,
            );

            // set data
            $this->setData($data);

            // Set validation array
            $validation = array(
                'is_deleted' => 'required',
            );

            // Set validation
            $this->setValidation($validation);

            // Return the response.
            $this->save();

            // If there's an error then
            if ($this->getErrors('')) {

                // Return FALSE
                return FALSE;
            } else {
                // Otherwise
                // Return TRUE
                return TRUE;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}

/* End of file Model_Sitesettings.php */
/* Location: ./application/modules/sitesettings/models/Model_Sitesettings.php */
