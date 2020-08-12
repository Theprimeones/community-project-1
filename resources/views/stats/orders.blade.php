@extends ('layouts.app')

@section ('content')
    <h1>Orders</h1>
    <ul>
        @foreach ($orders->sortByDesc('created_at')->take(100) as $order)
            <li class="li-parent"> 
                <ul>        
                    <li>Name: <a href="/stats/orders/{{ $order->id }}">{{$order->name}}</a></li>
                </ul>
            </li>
        @endforeach
    </ul>



    
    
@endsection
