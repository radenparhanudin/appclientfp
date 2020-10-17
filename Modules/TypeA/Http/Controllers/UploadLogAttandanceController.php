<?php

namespace Modules\TypeA\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use TADPHP\TADFactory;
use Yajra\Datatables\Facades\Datatables;

class UploadLogAttandanceController extends Controller
{
   public $base_url = "";
   function __construct()
   {
      $this->base_url = config('app.api_url');
   }

   public function index()
   {
      return view('typea::upload-log-attandance.index');
   }

   public function store(Request $request)
   {
      if ($request->ajax()) {

         $mesin_id = $request->get('mesin_id');
         $client   = new Client();
         $dataBody = array(
            'mesin_id' => $mesin_id, 
         );
         $response = $client->request('post',$this->base_url . 'mdl/mesin/upload-log-user/get_mesin', [
            'headers' => [
               'Content-Type'  => 'application/x-www-form-urlencoded',
               'Accept'        => 'application/json', 
               'Authorization' => 'Bearer ' . session()->get('token'), 
            ],
            'form_params' => $dataBody
         ]);

         $body = json_decode($response->getBody(), true);

         $client  = new Client();
         $tanggal = $this->get_tanggal_terakhir($mesin_id);
         $start   = $tanggal['content']['Date'];
         $end     = date('Y-m-d', strtotime('+3 days', strtotime($start)));
         try {
            $tad_factory      = new TADFactory(['ip'=> $body['content']['ip_address']]);
            $tad              = $tad_factory->get_instance();
            $data_log         = $tad->get_att_log();
            $get_att_logs     = $data_log->filter_by_date(['start' => $start, 'end' => $end])->to_array()['Row'];
            $dataBody['data'] = [];
            foreach ($get_att_logs as $gaui) {
               $expDateTime = explode(" ", $gaui['DateTime']);
               $date        = $expDateTime[0];
               $time        = $expDateTime[1];
               $dataBody['data'][] = array(
                  'mesin_id' => $mesin_id, 
                  'PIN'      => $gaui['PIN'], 
                  'Date'     => $date, 
                  'Time'     => $time, 
               );
            }
         } catch (\Exception $e) {
            return response()->json([
               'errors' => true, 
               'message' => 'Tidak dapat memulai koneksi dengan perangkat ' . $body['content']['ip_address'], 
            ], 422);
         }

         try {
            $response = $client->request('post',$this->base_url . 'mdl/mesin/upload-log-attandance', [
               'headers' => [
                  'Content-Type'  => 'application/x-www-form-urlencoded',
                  'Accept'        => 'application/json', 
                  'Authorization' => 'Bearer ' . session()->get('token'), 
               ],
               'form_params' => $dataBody
            ]);
            $body = json_decode($response->getBody(), true);
            if ($body['success']) {
               return response()->json([
                  'success' => true,
                  'message' => $body['message'],
               ]);
            }
         } catch (RequestException $exception) {
            $errException = $exception->getResponse()->getBody(true);
            $data = json_decode($errException, true);
            return response()->json([
               'errors' => true, 
               'message' => $data, 
            ], 402);
         }
      }
      else{
         return abort(404);
      }
   }

   private function get_tanggal_terakhir($mesin_id)
   {
      $client = new Client();
      $response = $client->request('post',$this->base_url . 'mdl/mesin/upload-log-attandance/get_tanggal_terakhir', [
         'headers' => [
            'Content-Type'  => 'application/x-www-form-urlencoded',
            'Accept'        => 'application/json', 
            'Authorization' => 'Bearer ' . session()->get('token'), 
         ],
         'form_params' => [
            'mesin_id' => $mesin_id
         ]
      ]);
      $tanggal = json_decode($response->getBody(), true);

      return $tanggal;
   }

   public function data(Request $request)
   {
      if ($request->ajax()) {
         $client = new Client();
         try {
            $response = $client->request('post',$this->base_url . 'mdl/mesin/upload-log-attandance/data', [
               'headers' => [
                  'Content-Type'  => 'application/x-www-form-urlencoded',
                  'Accept'        => 'application/json', 
                  'Authorization' => 'Bearer ' . session()->get('token'), 
               ]
            ]);
            $body = json_decode($response->getBody(), true);
            $collection = collect($body);

            return Datatables::of($collection)
            ->addIndexColumn()
            ->rawColumns([])
            ->make(true);
         } catch (RequestException $exception) {
            $errException = $exception->getResponse()->getBody(true);
            $data = json_decode($errException, true);
            return response()->json([
               'errors' => true, 
               'message' => $data, 
            ], 402);
         }
      }
      else{
         return abort(404);
      }
   }

   public function get_mesin(Request $request)
   {
      if ($request->ajax()) {
         $client = new Client();
         try {
            $response = $client->request('post',$this->base_url . 'mdl/mesin/upload-log-attandance/get_mesin', [
               'headers' => [
                  'Content-Type'  => 'application/x-www-form-urlencoded',
                  'Accept'        => 'application/json', 
                  'Authorization' => 'Bearer ' . session()->get('token'), 
               ]
            ]);
            $body = json_decode($response->getBody(), true);
            if ($body['success']) {
               return response()->json([
                  'success' => true,
                  'content' => $body['content']
               ]);
            }
         } catch (RequestException $exception) {
            $errException = $exception->getResponse()->getBody(true);
            $data = json_decode($errException, true);
            return response()->json([
               'errors' => true, 
               'message' => $data, 
            ], 402);
         }
      }
      else{
         return abort(404);
      }
   }
}
