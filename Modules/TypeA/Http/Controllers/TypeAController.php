<?php

namespace Modules\TypeA\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use TADPHP\TADFactory;


class TypeAController extends Controller
{
    public function get_log_user(Request $request)
    {
        $tad_factory = new TADFactory(['ip'=>'192.168.0.102']);
        $tad = $tad_factory->get_instance();
        return $tad->get_all_user_info()->to_array();
    }

    public function get_att_log(Request $request)
    {
        $tad_factory = new TADFactory(['ip'=>'192.168.0.102']);
        $tad = $tad_factory->get_instance();
        $att_logs = $tad->get_att_log();
        $filtered_att_logs = $att_logs->filter_by_date(
            ['start' => '2020-09-28','end' => '2020-09-28']
        );
        return $filtered_att_logs->to_array();
    }

    public function reg_mesin(Request $request)
    {
        $tad_factory = new TADFactory(['ip'=>'192.168.0.102']);
        $tad = $tad_factory->get_instance();
        $reg_mesin = array(
            'platform'         => $tad->get_platform()->to_array()['Row']['Information'], 
            'serial_number'    => $tad->get_serial_number()->to_array()['Row']['Information'], 
            'oem_vendor'       => $tad->get_oem_vendor()->to_array()['Row']['Information'], 
            'mac_address'      => $tad->get_mac_address()->to_array()['Row']['Information'], 
            'device_name'      => $tad->get_device_name()->to_array()['Row']['Information'], 
            'manufacture_time' => $tad->get_manufacture_time()->to_array()['Row']['Information'], 
            'firmware_version' => $tad->get_firmware_version()->to_array()['Row']['Information']
        );

        return $reg_mesin;
    }

    public function add_user_to_mesin(Request $request)
    {
        $tad_factory = new TADFactory(['ip'=>'192.168.0.102']);
        $tad = $tad_factory->get_instance();
        $add_user_to_mesin = $tad->set_user_info([
            'pin' => 111123,
            'name'=> 'Foo Bar',
            'privilege'=> 1
        ]);

        return $add_user_to_mesin;
    }

    public function delete_user(Request $request)
    {
        $tad_factory = new TADFactory(['ip'=>'192.168.0.102']);
        $tad = $tad_factory->get_instance();
        $delete_user = $tad->delete_user([
            'pin' => 111123
        ]);

        return $delete_user;
    }

    public function restart(Request $request)
    {
        $tad_factory = new TADFactory(['ip'=>'192.168.0.102']);
        $tad = $tad_factory->get_instance();
        $restart = $tad->restart();

        return $restart;
    }

    public function poweroff(Request $request)
    {
        $tad_factory = new TADFactory(['ip'=>'192.168.0.102']);
        $tad = $tad_factory->get_instance();
        $poweroff = $tad->poweroff();

        return $poweroff;
    }

    public function get_date(Request $request)
    {
        $tad_factory = new TADFactory(['ip'=>'192.168.0.102']);
        $tad = $tad_factory->get_instance();
        $get_date = $tad->get_date()->to_array();

        return $get_date;
    }



}
// get_date,
// get_att_log,
// get_user_info,
// get_all_user_info,
// get_user_template,
// get_combination,
// get_option,
// get_free_sizes,
// get_platform,
// get_fingerprint_algorithm,
// get_serial_number,
// get_oem_vendor,
// get_mac_address,
// get_device_name,
// get_manufacture_time,
// get_antipassback_mode,
// get_workcode,
// get_ext_format_mode,
// get_encrypted_mode,
// get_pin2_width,
// get_ssr_mode,
// get_firmware_version,
// set_date,
// set_user_info,
// set_user_template,
// delete_user,
// delete_template,
// delete_data,
// delete_user_password,
// delete_admin,
// enable,
// disable,
// refresh_db,
// restart,
// and poweroff.

