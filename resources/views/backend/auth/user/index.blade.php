@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.users.management'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    {{ __('labels.backend.access.users.management') }} <small class="text-muted">{{ __('labels.backend.access.users.active') }}</small>
                </h4>
            </div><!--col-->

            <div class="col-sm-7">
                @include('backend.auth.user.includes.header-buttons')
            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                <form action="{{ route('search') }}" method="GET" class="form-inline">
                <input type="text" class="form-control" id="ex3" name="search" style="width: 50%;" required/><button type="submit" class="btn btn-primary" style="direction: rtl;">Search</button>

                </form>
                    <table class="table" id="userTable">
                        <thead>
                        <tr>
                            <th>@lang('Full Name')</th>
                            <th>@lang('IC Number')</th>
                            <th>@lang('Email')</th>
                            <th>@lang('Date Register')</th>
                            <th>@lang('labels.general.actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($users->isNotEmpty())
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->display_name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at }}</td>
                                <!--
                                <td>@include('backend.auth.user.includes.confirm', ['user' => $user])</td>
                                <td>{{ $user->roles_label }}</td>
                                <td>{{ $user->permissions_label }}</td>
                                <td>@include('backend.auth.user.includes.social-buttons', ['user' => $user])</td>
                                <td>{{ $user->updated_at->diffForHumans() }}</td> -->
                                <td class="btn-td">@include('backend.auth.user.includes.actions', ['user' => $user])</td>
                            </tr>
                        @endforeach
                        @else 
                            <div>
                            <h2>No user found</h2>
                            </div>
                        @endif
                        </tbody>
                    </table>
                    <div class="col-5">
                <div class="float-right">
                    {!! $users->render() !!}
                </div>
            </div><!--col-->
        </div><!--row-->
                </div>
            </div><!--col-->
        </div><!--row-->
        
    </div><!--card-body-->
</div><!--card-->
@endsection


@section('page-js-script')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
@stop
