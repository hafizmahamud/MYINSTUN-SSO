@extends('backend.layouts.app')

@section('title', app_name() . ' | '. __('labels.backend.access.announcement.management'))

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                {{ __('labels.backend.access.announcement.management') }}
                </h4>
            </div><!--col-->

            <div class="col-sm-7 pull-right">
                @include('backend.auth.announcements.includes.header-buttons')
            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>@lang('labels.backend.access.announcement.title')</th>
                            <th>@lang('labels.backend.access.announcement.content')</th>
                            <th>@lang('labels.general.actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($announcement_all as $announcement)
                            <tr>
                                <td>{{ $announcement->title }}</td>
                                <td>{{ $announcement->content }}</td>
                                <td>  <div class="btn-group btn-group-sm" role="group" aria-label="@lang('labels.backend.access.users.user_actions')">
                                <a href="{{ route('admin.auth.announcement.update', $announcement->id) }}"
                                class="btn btn-primary" data-toggle="tooltip" >
                                    <i class="fas fa-edit"></i>
                                </a>

                                <a href="{{ route('admin.auth.announcement.destroy', $announcement) }}"
                                data-method="delete"
                                data-trans-button-cancel="@lang('buttons.general.cancel')"
                                data-trans-button-confirm="@lang('buttons.general.crud.delete')"
                                data-trans-title="@lang('strings.backend.general.are_you_sure')"
                                class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="@lang('buttons.general.crud.delete')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div><!--col-->
        </div><!--row-->
        <div class="row">
            <div class="col-7">
                <div class="float-left">
                </div>
            </div><!--col-->

            <div class="col-5">
                <div class="float-right">
                </div>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
@endsection
