@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.general.home'))

@section('content')
<div class="row mt-4">
    <div class="col">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>@lang('labels.backend.access.announcement.title')</th>
                    <th>@lang('labels.backend.access.announcement.content')</th>
                </tr>
                </thead>
                <tbody>
                @foreach($announcement_all as $announcement)
                    <tr>
                        <td>{{ $announcement->title }}</td>
                        <td>{{ $announcement->content }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div><!--col-->
</div><!--row-->
@endsection