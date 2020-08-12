@extends ('layouts.app')

@section ('content')
    <h1>Users</h1>
    <ul>
        @foreach ($users->sortByDesc('created_at')->take(100) as $user)
            <li class="li-parent"> 
                <ul>        
                    <li>Name: <a href="/stats/users/{{ $user->id }}">{{$user->name}}</a></li>
                </ul>
            </li>
        @endforeach
    </ul>
    
    
@endsection
