@extends('layouts.app')

@section('title', 'Invitations List')

@section('content')
    <div class="mdl-grid">
        <div class="mdl-cell mdl-cell--12-col mdl-grid ">

            <table class="mdl-data-table wide-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--2dp">
                <thead>
                <tr>
                    <th class="mdl-data-table__cell--non-numeric">Email</th>
                    <th class="mdl-data-table__cell--non-numeric">Created At</th>
                    <th class="mdl-data-table__cell--non-numeric">Updated At</th>
                    <th class="mdl-data-table__cell--non-numeric">Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($collection as $invite)
                    <tr>
                        <td class="mdl-data-table__cell--non-numeric">{{$invite->email}}</td>
                        <td class="mdl-data-table__cell--non-numeric">{{$invite->created_at}}</td>
                        <td class="mdl-data-table__cell--non-numeric">{{$invite->updated_at}}</td>
                        <td class="mdl-data-table__cell--non-numeric">{{$invite->status}}</td>
                        <td>
                            <a class="mdl-js-button mdl-button--primary" href="<?php echo '/invite/resend/id/' . $invite->id ?>">RESEND INVITE</a>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="3">No invitations</td>

                    </tr>
                @endforelse

                </tbody>
            </table>

        </div>
        <div class="mdl-cell mdl-cell--12-col mdl-grid ">
            <div class="pager mdl-shadow--2dp">
                {!! $collection->render() !!}
            </div>
        </div>
        <div class="fab-bottom">
            <a href="{{ url('/invite/create') }}" ng-click="openCreate()" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored">
                <i class="material-icons">add</i>
            </a>
        </div>
    </div>
@endsection