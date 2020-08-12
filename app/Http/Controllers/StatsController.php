<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use App\Device;
use App\Event;
use App\Order;

class StatsController extends Controller
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

    public function csvs() {
        // get: params
        $user = Auth::user();

        // return: view
        return view('stats/csvs', compact('user'));
    }

    public function users() {
        // get: params
        $users = User::all();
        
        // return view
        return view('stats.users', compact('users'));
    }

    public function orders() {
        // get: params
        $orders = Order::all();
        
        // return view
        return view('stats.orders', compact('orders'));
    }

    public function showUser(User $user) {
        // get: other params
        $events = $user->events;
        $date_begin = Carbon::today();
        $date_end = Carbon::tomorrow();

        // find: the devices that company worked on
        $rec_events = collect();
        $tri_events = collect();
        $iss_events = collect();
        $rep_events = collect();
        $shi_events = collect();
        $scr_events = collect();
        $ret_events = collect();
        foreach($events as $event) {
            if ($event->body == 'received' and $event->created_at->between($date_begin, $date_end)) {
                $rec_events->push($event);
            }
            
            else if (substr($event->body, 0, 7) == 'triage:' and $event->created_at->between($date_begin, $date_end)) {
                $tri_events->push($event);
            }

            else if ($event->body == 'issueless' and $event->created_at->between($date_begin, $date_end)) {
                $iss_events->push($event);
            }
            
            else if ($event->body == 'repaired' and $event->created_at->between($date_begin, $date_end)) {
                $rep_events->push($event);
            }

            else if ($event->body == 'shipped' and $event->created_at->between($date_begin, $date_end)) {
                $shi_events->push($event);
            }

            else if ($event->body == 'scrapped' and $event->created_at->between($date_begin, $date_end)) {
                $scr_events->push($event);
            }

            else if (substr($event->body, 0, 7) == 'return:' and $event->created_at->between($date_begin, $date_end)) {
                $ret_events->push($event);
            }
        }

        // turn: events into devices
        $rec_devices = $this->eventsToDevices($rec_events);
        $tri_devices = $this->eventsToDevices($tri_events);
        $iss_devices = $this->eventsToDevices($iss_events);
        $rep_devices = $this->eventsToDevices($rep_events);
        $shi_devices = $this->eventsToDevices($shi_events);
        $scr_devices = $this->eventsToDevices($scr_events);
        $ret_devices = $this->eventsToDevices($ret_events);

        // return authenticated View
        return view('stats.user', compact('user', 'rec_devices', 'tri_devices', 'iss_devices', 'rep_devices', 'shi_devices', 'scr_devices', 'ret_devices'));
    }

    public function showOrder(Order $order) {
        // get: other params
        // double foreach: fix later, by adding order id to events
        $devices = $order->devices;
        $events = collect();
        foreach($devices as $device) {
            foreach($device->events as $event) {
                $events->push($event);
            }
        }
        
        $date_begin = Carbon::today();
        $date_end = Carbon::tomorrow();

        // find: the devices that company worked on
        $rec_events = collect();
        $tri_events = collect();
        $iss_events = collect();
        $rep_events = collect();
        $shi_events = collect();
        $scr_events = collect();
        $ret_events = collect();
        foreach($events as $event) {
            if ($event->body == 'received' and $event->created_at->between($date_begin, $date_end)) {
                $rec_events->push($event);
            }
            
            else if (substr($event->body, 0, 7) == 'triage:' and $event->created_at->between($date_begin, $date_end)) {
                $tri_events->push($event);
            }

            else if ($event->body == 'issueless' and $event->created_at->between($date_begin, $date_end)) {
                $iss_events->push($event);
            }
            
            else if ($event->body == 'repaired' and $event->created_at->between($date_begin, $date_end)) {
                $rep_events->push($event);
            }

            else if ($event->body == 'shipped' and $event->created_at->between($date_begin, $date_end)) {
                $shi_events->push($event);
            }

            else if ($event->body == 'scrapped' and $event->created_at->between($date_begin, $date_end)) {
                $scr_events->push($event);
            }

            else if (substr($event->body, 0, 7) == 'return:' and $event->created_at->between($date_begin, $date_end)) {
                $ret_events->push($event);
            }
        }

        // turn: events into devices
        $rec_devices = $this->eventsToDevices($rec_events);
        $tri_devices = $this->eventsToDevices($tri_events);
        $iss_devices = $this->eventsToDevices($iss_events);
        $rep_devices = $this->eventsToDevices($rep_events);
        $shi_devices = $this->eventsToDevices($shi_events);
        $scr_devices = $this->eventsToDevices($scr_events);
        $ret_devices = $this->eventsToDevices($ret_events);

        // return authenticated View
        return view('stats.order', compact('order', 'rec_devices', 'tri_devices', 'iss_devices', 'rep_devices', 'shi_devices', 'scr_devices', 'ret_devices'));
    }
    
    public function showCompany() {
        // get: other params
        $events = Event::all();
        $date_begin = Carbon::today();
        $date_end = Carbon::tomorrow();

        // find: the devices that company worked on
        $rec_events = collect();
        $tri_events = collect();
        $iss_events = collect();
        $rep_events = collect();
        $shi_events = collect();
        $scr_events = collect();
        $ret_events = collect();
        foreach($events as $event) {
            if ($event->body == 'received' and $event->created_at->between($date_begin, $date_end)) {
                $rec_events->push($event);
            }
            
            else if (substr($event->body, 0, 7) == 'triage:' and $event->created_at->between($date_begin, $date_end)) {
                $tri_events->push($event);
            }

            else if ($event->body == 'issueless' and $event->created_at->between($date_begin, $date_end)) {
                $iss_events->push($event);
            }
            
            else if ($event->body == 'repaired' and $event->created_at->between($date_begin, $date_end)) {
                $rep_events->push($event);
            }

            else if ($event->body == 'shipped' and $event->created_at->between($date_begin, $date_end)) {
                $shi_events->push($event);
            }

            else if ($event->body == 'scrapped' and $event->created_at->between($date_begin, $date_end)) {
                $scr_events->push($event);
            }

            else if (substr($event->body, 0, 7) == 'return:' and $event->created_at->between($date_begin, $date_end)) {
                $ret_events->push($event);
            }
        }

        // turn: events into devices
        $rec_devices = $this->eventsToDevices($rec_events);
        $tri_devices = $this->eventsToDevices($tri_events);
        $iss_devices = $this->eventsToDevices($iss_events);
        $rep_devices = $this->eventsToDevices($rep_events);
        $shi_devices = $this->eventsToDevices($shi_events);
        $scr_devices = $this->eventsToDevices($scr_events);
        $ret_devices = $this->eventsToDevices($ret_events);

        // return: view
        return view('stats.company', compact('rec_devices', 'tri_devices', 'iss_devices', 'rep_devices', 'shi_devices', 'scr_devices', 'ret_devices'));
    }

    public function filterCompany() {
        // validate
        $this->validate(request(), [
            'date_begin' => 'required',
            'date_end' => 'required'
        ]);

        // get: other params
        $events = Event::all();

        // find: the devices that company worked on
        $rec_events = collect();
        $tri_events = collect();
        $iss_events = collect();
        $rep_events = collect();
        $shi_events = collect();
        $scr_events = collect();
        $ret_events = collect();
        foreach($events as $event) {
            if ($event->body == 'received' and $event->created_at->between(Carbon::parse(request('date_begin')), Carbon::parse(request('date_end')))) {
                $rec_events->push($event);
            }
            
            else if ($event->body == 'issueless' and $event->created_at->between(Carbon::parse(request('date_begin')), Carbon::parse(request('date_end')))) {
                $iss_events->push($event);
            }
            
            else if (substr($event->body, 0, 7) == 'triage:' and $event->created_at->between(Carbon::parse(request('date_begin')), Carbon::parse(request('date_end')))) {
                $tri_events->push($event);
            }
            
            else if ($event->body == 'repaired' and $event->created_at->between(Carbon::parse(request('date_begin')), Carbon::parse(request('date_end')))) {
                $rep_events->push($event);
            }

            else if ($event->body == 'shipped' and $event->created_at->between(Carbon::parse(request('date_begin')), Carbon::parse(request('date_end')))) {
                $shi_events->push($event);
            }

            else if ($event->body == 'scrapped' and $event->created_at->between(Carbon::parse(request('date_begin')), Carbon::parse(request('date_end')))) {
                $scr_events->push($event);
            }

            else if (substr($event->body, 0, 7) == 'return:' and $event->created_at->between(Carbon::parse(request('date_begin')), Carbon::parse(request('date_end')))) {
                $ret_events->push($event);
            }
        }

        // turn: events into devices
        $rec_devices = $this->eventsToDevices($rec_events);
        $tri_devices = $this->eventsToDevices($tri_events);
        $iss_devices = $this->eventsToDevices($iss_events);
        $rep_devices = $this->eventsToDevices($rep_events);
        $shi_devices = $this->eventsToDevices($shi_events);
        $scr_devices = $this->eventsToDevices($scr_events);
        $ret_devices = $this->eventsToDevices($ret_events);

        // return: view
        return view('stats.company', compact('rec_devices', 'tri_devices', 'iss_devices', 'rep_devices', 'shi_devices', 'scr_devices', 'ret_devices'));        
    }
    
    public function filterUser(User $user) {
        // validate
        $this->validate(request(), [
            'date_begin' => 'required',
            'date_end' => 'required'
        ]);

        // get: other params
        $events = $user->events;

        // find: the devices that user worked on
        $rec_events = collect();
        $tri_events = collect();
        $iss_events = collect();
        $rep_events = collect();
        $shi_events = collect();
        $scr_events = collect();
        $ret_events = collect();
        foreach($events as $event) {
            if ($event->body == 'received' and $event->created_at->between(Carbon::parse(request('date_begin')), Carbon::parse(request('date_end')))) {
                $rec_events->push($event);
            }
            
            else if ($event->body == 'issueless' and $event->created_at->between(Carbon::parse(request('date_begin')), Carbon::parse(request('date_end')))) {
                $iss_events->push($event);
            }
            
            else if (substr($event->body, 0, 7) == 'triage:' and $event->created_at->between(Carbon::parse(request('date_begin')), Carbon::parse(request('date_end')))) {
                $tri_events->push($event);
            }
            
            else if ($event->body == 'repaired' and $event->created_at->between(Carbon::parse(request('date_begin')), Carbon::parse(request('date_end')))) {
                $rep_events->push($event);
            }

            else if ($event->body == 'shipped' and $event->created_at->between(Carbon::parse(request('date_begin')), Carbon::parse(request('date_end')))) {
                $shi_events->push($event);
            }

            else if ($event->body == 'scrapped' and $event->created_at->between(Carbon::parse(request('date_begin')), Carbon::parse(request('date_end')))) {
                $scr_events->push($event);
            }

            else if (substr($event->body, 0, 7) == 'return:' and $event->created_at->between(Carbon::parse(request('date_begin')), Carbon::parse(request('date_end')))) {
                $ret_events->push($event);
            }
        }

        // turn: events into devices
        $rec_devices = $this->eventsToDevices($rec_events);
        $tri_devices = $this->eventsToDevices($tri_events);
        $iss_devices = $this->eventsToDevices($iss_events);
        $rep_devices = $this->eventsToDevices($rep_events);
        $shi_devices = $this->eventsToDevices($shi_events);
        $scr_devices = $this->eventsToDevices($scr_events);
        $ret_devices = $this->eventsToDevices($ret_events);

        // return authenticated View
        return view('stats.user', compact('user', 'rec_devices', 'tri_devices', 'iss_devices', 'rep_devices', 'shi_devices', 'scr_devices', 'ret_devices'));
    }

    public function showUserRepairs(User $user) {
        // get: other params
        $events = $user->events;

        // find: the devices that were repaired
        $e_events = collect();
        $rep_devices = collect();
        foreach($events as $event) {
            if ($event->body == 'repaired') {
                $e_events->push($event);
            }
        }
        foreach($e_events->sortByDesc('created_at') as $event) {
            $found_device = Device::find($event->device_id);
            if (!$rep_devices->contains('id', $found_device->id)) {
                $rep_devices->push($found_device);
            }
        }

        // return authenticated View
        return view('stats.userRepairs', compact('user', 'rep_devices'));
    }

    public function filterOrder(Order $order) {
        // validate
        $this->validate(request(), [
            'date_begin' => 'required',
            'date_end' => 'required'
        ]);

        // get: other params
        $devices = $order->devices;
        $events = collect();
        foreach($devices as $device) {
            foreach($device->events as $event) {
                $events->push($event);
            }
        }

        // find: the devices that company worked on
        $rec_events = collect();
        $tri_events = collect();
        $iss_events = collect();
        $rep_events = collect();
        $shi_events = collect();
        $scr_events = collect();
        $ret_events = collect();
        foreach($events as $event) {
            if ($event->body == 'received' and $event->created_at->between(Carbon::parse(request('date_begin')), Carbon::parse(request('date_end')))) {
                $rec_events->push($event);
            }
            
            else if ($event->body == 'issueless' and $event->created_at->between(Carbon::parse(request('date_begin')), Carbon::parse(request('date_end')))) {
                $iss_events->push($event);
            }
            
            else if (substr($event->body, 0, 7) == 'triage:' and $event->created_at->between(Carbon::parse(request('date_begin')), Carbon::parse(request('date_end')))) {
                $tri_events->push($event);
            }
            
            else if ($event->body == 'repaired' and $event->created_at->between(Carbon::parse(request('date_begin')), Carbon::parse(request('date_end')))) {
                $rep_events->push($event);
            }

            else if ($event->body == 'shipped' and $event->created_at->between(Carbon::parse(request('date_begin')), Carbon::parse(request('date_end')))) {
                $shi_events->push($event);
            }

            else if ($event->body == 'scrapped' and $event->created_at->between(Carbon::parse(request('date_begin')), Carbon::parse(request('date_end')))) {
                $scr_events->push($event);
            }

            else if (substr($event->body, 0, 7) == 'return:' and $event->created_at->between(Carbon::parse(request('date_begin')), Carbon::parse(request('date_end')))) {
                $ret_events->push($event);
            }
        }

        // turn: events into devices
        $rec_devices = $this->eventsToDevices($rec_events);
        $tri_devices = $this->eventsToDevices($tri_events);
        $iss_devices = $this->eventsToDevices($iss_events);
        $rep_devices = $this->eventsToDevices($rep_events);
        $shi_devices = $this->eventsToDevices($shi_events);
        $scr_devices = $this->eventsToDevices($scr_events);
        $ret_devices = $this->eventsToDevices($ret_events);

        // return: view
        return view('stats.order', compact('order', 'rec_devices', 'tri_devices', 'iss_devices', 'rep_devices', 'shi_devices', 'scr_devices', 'ret_devices'));
    }



}
