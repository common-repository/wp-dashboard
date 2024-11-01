<?php

/**
 * The gravity form functionality of the plugin.
 *
 * @link       https://wpdashboard.io
 * @since      1.1.13
 *
 * @package    Wpdashboard
 * @subpackage Wpdashboard/api
 */

/**
 * The gravity form functionality of the plugin.
 *
 * @package    Wpdashboard
 * @subpackage Wpdashboard/api
 * @author     WP Dashboard <brianldj@gmail.com>
 */

/**
 * Required Classes
 */

class Wpdashboard_Gravity_Forms {


    private $request;
    private $response;
    private $plugin_name;

    /**
     * Wpdashboard_Gravity_Forms constructor.
     * @param $plugin_name
     * @param $request
     * @param $response
     */
    public function __construct($plugin_name, $request, $response) {

        $this->plugin_name = $plugin_name;
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Default response generator for the API.
     *
     * @since    1.0.0
     *
     * @param $response The response object from Klein
     *
     * @param array $data The data being passed to the response
     *
     * @param bool $success The status of the response
     *
     * @param int $errorCode Error code if applicable
     *
     * @param string $errorMessage Error message if applicable
     *
     * @return string
     */
    public function respond($response, $data = [], $success = true, $errorCode = 200, $errorMessage = '') {
        $response->code($errorCode)
            ->header('Content-Type', 'application/json')
            ->json([
                'success' => $success,
                'data' => $data,
                'status_code' => $errorCode,
                'message' => $errorMessage,
            ]);
        die();
    }

    /**
     * Get Option from Wordpress.
     *
     * @since    1.0.0
     *
     * @param $name
     * @return mixed
     */
    public function get_option($name) {
        return get_option($this->plugin_name . '_' . $name);
    }

    /**
     * Update Option from Wordpress.
     *
     * @since    1.0.0
     *
     * @param $name
     * @param $value
     * @param $autoload
     * @return mixed
     */
    public function update_option($name, $value, $autoload) {
        return update_option($this->plugin_name . '_' . $name, $value, $autoload);
    }

    /**
     * Delete Option from Wordpress.
     *
     * @since    1.0.106
     *
     * @param $name
     * @return mixed
     */
    public function delete_option($name) {
        return delete_option($this->plugin_name . '_' . $name);
    }

    /**
     * @return string
     */
    public function execute() {
        if(class_exists('GFAPI')) {
            switch($this->request->param('a')) {
                case 'check':
                    $this->respond($this->response, [], true, 200, 'Gravity Forms installed.');
                    break;
                case 'get-forms':
                    $this->get_forms();
                    break;
                case 'get-entries':
                    $this->get_entries();
                    break;
                default:
                    $this->respond($this->response);
            }
        } else {
            $this->respond($this->response, [], false, 200, 'Gravity Forms not installed');
        }
    }


    /**
     * Get forms from Gravity Forms.
     *
     * @since    1.1.13
     *
     * @return mixed
     */
    protected function get_forms() {
        $forms = GFAPI::get_forms();
        $this->respond($this->response, $forms);
    }


    /**
     * Get entries from Gravity Forms.
     *
     * @since    1.1.13
     *
     * @return mixed
     */
    protected function get_entries() {
        $search_criteria['start_date'] = date('Y-m-d', strtotime($this->request->param('start_date', 'today')));
        $search_criteria['end_date'] = date('Y-m-d', strtotime($this->request->param('end_date', 'today')));
        $entries = GFAPI::get_entries($this->request->param('form_id'), $search_criteria, null, ['page_size' => 999999]);
        $this->respond($this->response, $entries);
    }


    /**
     * Generate Random String.
     *
     * @since    1.0.0
     *
     * @param $data
     * @return string
     */
    protected function __generate_random_string($data) {
        assert(strlen($data) == 16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

}
