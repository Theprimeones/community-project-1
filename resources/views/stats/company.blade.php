@extends ('layouts.app')

@section ('content')
    <h1>Open Company</h1>
    <form method="POST" action="/stats/company/filter">
        {{ csrf_field() }}
        <input id="data-entry" name="date_begin" type="date" value={{\Carbon\Carbon::today()}}/>
        <input name="date_end" type="date" value={{\Carbon\Carbon::tomorrow()}} />

        <button type="submit">Submit</button>
    </form>
    <br>
    <br>
    <h4>Received: {{$rec_devices->count()}}</h4>
    <h4>Triaged (non-issueless): {{$tri_devices->count()}}</h4>
    <h4>Issueless: {{$iss_devices->count()}}</h4>
    <h4>Repaired: {{$rep_devices->count()}}</h4>
    <h4>Pushed (issueless + repaired): {{$iss_devices->count() + $rep_devices->count()}}</h4>
    <h4>Scrapped: {{$scr_devices->count()}}</h4>
    <h4>Shipped: {{$shi_devices->count()}}</h4>
    <h4>Returned: {{$ret_devices->count()}}</h4>



    
    
@endsection
