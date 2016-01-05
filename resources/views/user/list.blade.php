@extends('layouts.app')

@section('title', 'Users List')

@section('content')
    <div class="mdl-grid">
        <div class="mdl-cell mdl-cell--12-col mdl-grid ">

            <table class="mdl-data-table wide-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--2dp">
                <thead>
                <tr>
                    <th class="mdl-data-table__cell--non-numeric">User</th>
                    <th class="mdl-data-table__cell--non-numeric">Email</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                    <tr>
                        <td class="mdl-data-table__cell--non-numeric">{{$user->firstname}} {{$user->lastname}}</td>
                        <td class="mdl-data-table__cell--non-numeric">{{$user->email}}</td>
                        <td>
                            <a class="mdl-js-button mdl-button--primary" href="<?php echo '/user/update/id/' . $user->id ?>">EDIT</a>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="3">No users</td>

                    </tr>
                @endforelse

                </tbody>
            </table>

        </div>
        <div class="mdl-cell mdl-cell--12-col mdl-grid ">
            <div class="pager mdl-shadow--2dp">
                {!! $users->render() !!}
            </div>
        </div>
    </div>

@endsection


@section('fab')
    <div class="fab-bottom">
        <a href="{{ url('/user/create') }}" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored">
            <i class="material-icons">add</i>
        </a>
    </div>
@endsection