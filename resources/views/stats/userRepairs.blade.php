@extends ('layouts.app')

@section ('content')
    <h1>User: {{ $user->name}}</h1>
    <h4>Repairs</h4>
    <div class="list">
        <br>
        <ul>
            @isset($rep_devices)
            @foreach ($rep_devices as $device)
                <li class="li-parent"> 
                    <ul>
                        <li>Asset/Serial/Tracking: <a href="/devices/{{ $device->id}}">{{$device->asset}}</a> / <a href="/devices/{{ $device->id}}">{{$device->serial}}</a> / @isset($device->tracking)<a href="/devices/{{ $device->id}}">{{$device->tracking}}</a>@endisset</li>
                        <li>Brand/Model: {{$device->brand}} / {{$device->model}}</li>
                        @isset($device->supplier)
                        <li>Supplier: <a href="/suppliers/{{ $device->supplier->id }}">{{$device->supplier->name}}</a></li>
                        @endisset
                        <li>Last Status: {{$device->events->last()->body}}</li>                    
                        @if ($device->created_at->isToday())
                            <li>Date: {{$device->events->last()->created_at->diffForHumans()}}</li>
                        @else
                            <li>Date: {{$device->events->last()->created_at->format('m-d-Y')}}</li>                        
                        @endif
                    </ul>
                </li>
            @endforeach
            @endisset
        </ul>
    </div>
    
@endsection
