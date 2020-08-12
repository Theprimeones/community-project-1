<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Response;
use App\Device;
use App\User;
use App\Supplier;
use App\Event;
use App\Order;
use App\Modelle;
use App\Emc;

class DeviceController extends Controller
{
    public $PAGE_LOAD_MAX = 20;

    public function eventsToDevices($events) {
        $devices = collect();
        foreach($events->sortByDesc('created_at') as $event) {
            $found_device = Device::find($event->device_id);
            if (!$devices->contains('id', $found_device->id)) {
                $devices->push($found_device);
            }
        }
        return $devices;
    }

    public function inventoryExport() {
        // get: params
        $events = Event::all();

        // find: the devices that were received
        $rec_events = collect();
        $iss_events = collect();
        $rep_events = collect();
        $shi_events = collect();
        $scr_events = collect();
        foreach($events as $event) {
            if ($event->body == 'received') {
                $rec_events->push($event);
            }
            else if ($event->body == 'issueless') {
                $iss_events->push($event);
            }
            else if ($event->body == 'repaired') {
                $rep_events->push($event);
            }
            else if ($event->body == 'shipped') {
                $shi_events->push($event);
            }
            else if ($event->body == 'scrapped') {
                $scr_events->push($event);
            }
        }

        // turn: events into devices
        $rec_devices = $this->eventsToDevices($rec_events);
        $iss_devices = $this->eventsToDevices($iss_events);
        $rep_devices = $this->eventsToDevices($rep_events);
        $shi_devices = $this->eventsToDevices($shi_events);
        $scr_devices = $this->eventsToDevices($scr_events);
        
        // find: devices that are received, not shipped, not scrapped, issueless, or repaired
        $fin_devices = $rec_devices->diff($shi_devices);
        $fin_devices = $fin_devices->diff($scr_devices);
        $temp_devices = $iss_devices->merge($rep_devices);
        $fin_devices = $fin_devices->intersect($temp_devices);

        // setup: csv
        $filename = "inventory_devices.csv";
        $handle = fopen($filename, 'w+');

        // create: csv
        fputcsv($handle, array('Asset', 'Serial', 'Brand', 'Model', 'Received By', 'Received On', 'Supplier', 'Last Event', 'Event Date'));
        foreach($fin_devices as $device) {
            fputcsv($handle, array(
                $device->asset,
                $device->serial,
                $device->brand,
                $device->model,
                $device->issetCreatorName(),
                $device->created_at,
                $device->issetSupplierName(),
                $device->events->last()->body,
                $device->events->last()->created_at
            ));
        }
        fclose($handle);

        // finish: csv
        $headers = array(
            'Content-Type' => 'text/csv',
        );

        // return: csv
        return Response::download($filename, 'inventory_devices.csv', $headers);
    }

    public function returnsExport() {
        // get: params
        $events = Event::all();

        // find: the devices that were received
        $ret_events = collect();
        foreach($events as $event) {
            if (substr($event->body, 0, 7) == 'return:') {
                $ret_events->push($event);
            }
        }

        // turn: events into devices
        $ret_devices = $this->eventsToDevices($ret_events);
        
        // setup: csv
        $filename = "returns_devices.csv";
        $handle = fopen($filename, 'w+');

        // create: csv
        fputcsv($handle, array('Asset', 'Serial', 'Brand', 'Model', 'Received By', 'Received On', 'Supplier', 'Return Reason', 'Return Date', 'Triage Reason(s)', 'Triage Date(s)'));
        
        foreach($ret_devices as $device) {
            // get: params
            $device_return = $device->getDeviceReturn();
            $devices_triage = $device->getDevicesTriage($device_return);

            // build: array
            $fin_array = array();
            array_push($fin_array, $device->asset, $device->serial, $device->brand, $device->model, $device->issetCreatorName(), $device->created_at, $device->issetSupplierName(), $device_return->body, $device_return->created_at);

            foreach($devices_triage as $device_triage) {
                if ($device_triage) {
                    array_push($fin_array, $device_triage->body, $device_triage->created_at);
                }
            }
            
            // insert into: file
            fputcsv($handle, $fin_array);
        }
        fclose($handle);

        // finish: csv
        $headers = array(
            'Content-Type' => 'text/csv',
        );

        // return: csv
        return Response::download($filename, 'returns_devices.csv', $headers);
    }


    
    

}
