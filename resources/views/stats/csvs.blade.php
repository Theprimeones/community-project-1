@extends ('layouts.app')

@section ('content')
    <div class="container">
        <h1>CSVs</h1>
        <br>
        <form method="POST" action="/devices/inventory/export">
            {{ csrf_field() }}
            <button type="submit">Export Inventory</button>
        </form>
        <br>
        <br>
        <form method="POST" action="/devices/returns/export">
            {{ csrf_field() }}
            <button type="submit">Export Returns</button>
        </form>


    </div>
    
@endsection
