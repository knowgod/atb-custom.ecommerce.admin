@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">User Account List</div>
                    @forelse($users as $user)
                        <li>
                            <?php var_dump($user['attributes']) ?>

                            {{-- @Myroslav sample output like this: --}}
                            {{$user->firstname}}
                            {{$user->lastname}}
                        </li>
                    @empty
                        <p>No users</p>
                    @endforelse
                </div>

                {!! $users->render() !!}
            </div>
        </div>
    </div>
@endsection
