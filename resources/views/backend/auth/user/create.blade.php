@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | ' . __('labels.backend.access.users.create'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
    {{ html()->form('POST', route('admin.auth.user.store'))->class('form-horizontal')->open() }}
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <h4 class="card-title mb-0">
                            @lang('labels.backend.access.users.management')
                            <small class="text-muted">@lang('labels.backend.access.users.create')</small>
                        </h4>
                    </div><!--col-->
                </div><!--row-->

                <hr>

                <div class="row mt-4 mb-4">
                    <div class="col">

                        <div class="form-group row">
                            {{ html()->label(__('IC Number'))->class('col-md-2 form-control-label')->for('username') }}
                            <div class="col-md-10">
                            <input type="text" maxlength = "12" onkeypress="return isNumber(event)" class="form-control" name="username" id="username" placeholder="IC Number">
                            </div>
                            <!-- <div class="col-md-10">
                                {{ html()->text('username')
                                    ->class('form-control')
                                    ->placeholder(__('IC Number'))
                                    ->attribute('maxlength', 12)
                                    ->required()
                                    ->autofocus() }}
                            </div>
                                -->
                        </div><!--form-group-->
                        <div class="form-group row">
                            {{ html()->label(__('validation.attributes.backend.access.users.display_name'))->class('col-md-2 form-control-label')->for('display_name') }}

                            <div class="col-md-10">
                                {{ html()->text('display_name')
                                    ->class('form-control')
                                    ->placeholder(__('validation.attributes.backend.access.users.display_name'))
                                    ->attribute('maxlength', 191)
                                    ->required()
                                    ->autofocus() }}
                            </div><!--col-->
                        </div><!--form-group-->


                        <div class="form-group row">
                            {{ html()->label(__('validation.attributes.backend.access.users.email'))->class('col-md-2 form-control-label')->for('email') }}

                            <div class="col-md-10">
                                {{ html()->email('email')
                                    ->class('form-control')
                                    ->placeholder(__('validation.attributes.backend.access.users.email'))
                                    ->attribute('maxlength', 191)
                                    ->required() }}
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            {{ html()->label(__('validation.attributes.backend.access.users.password'))->class('col-md-2 form-control-label')->for('password') }}

                            <div class="col-md-10">
                                {{ html()->password('password')
                                    ->class('form-control')
                                    ->placeholder(__('validation.attributes.backend.access.users.password'))
                                    ->required() }}
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            {{ html()->label(__('validation.attributes.backend.access.users.password_confirmation'))->class('col-md-2 form-control-label')->for('password_confirmation') }}

                            <div class="col-md-10">
                                {{ html()->password('password_confirmation')
                                    ->class('form-control')
                                    ->placeholder(__('validation.attributes.backend.access.users.password_confirmation'))
                                    ->required() }}
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            {{ html()->label(__('validation.attributes.backend.access.users.active'))->class('col-md-2 form-control-label')->for('active') }}

                            <div class="col-md-10">
                                <label class="switch switch-label switch-pill switch-primary">
                                    {{ html()->checkbox('active', true)->class('switch-input') }}
                                    <span class="switch-slider" data-checked="yes" data-unchecked="no"></span>
                                </label>
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            {{ html()->label(__('validation.attributes.backend.access.users.confirmed'))->class('col-md-2 form-control-label')->for('confirmed') }}

                            <div class="col-md-10">
                                <label class="switch switch-label switch-pill switch-primary">
                                    {{ html()->checkbox('confirmed', true)->class('switch-input') }}
                                    <span class="switch-slider" data-checked="yes" data-unchecked="no"></span>
                                </label>
                            </div><!--col-->
                        </div><!--form-group-->

                        @if(! config('access.users.requires_approval'))
                            <div class="form-group row">
                                {{ html()->label(__('validation.attributes.backend.access.users.send_confirmation_email') . '<br/>' . '<small>' .  __('strings.backend.access.users.if_confirmed_off') . '</small>')->class('col-md-2 form-control-label')->for('confirmation_email') }}

                                <div class="col-md-10">
                                    <label class="switch switch-label switch-pill switch-primary">
                                        {{ html()->checkbox('confirmation_email')->class('switch-input') }}
                                        <span class="switch-slider" data-checked="yes" data-unchecked="no"></span>
                                    </label>
                                </div><!--col-->
                            </div><!--form-group-->
                        @endif

                        <div class="form-group row">
                            {{ html()->label(__('labels.backend.access.users.table.abilities'))->class('col-md-2 form-control-label') }}

                            <div class="col-md-10">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>@lang('labels.backend.access.users.table.roles')</th>
                                            <th>@lang('labels.backend.access.users.table.permissions')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                @if($roles->count())
                                                    @foreach($roles as $role)
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <div class="checkbox d-flex align-items-center">
                                                                    {{ html()->label(
                                                                            html()->checkbox('roles[]', old('roles') && in_array($role->name, old('roles')) ? true : false, $role->name)
                                                                                  ->class('switch-input')
                                                                                  ->id('role-'.$role->id)
                                                                            . '<span class="switch-slider" data-checked="on" data-unchecked="off"></span>')
                                                                        ->class('switch switch-label switch-pill switch-primary mr-2')
                                                                        ->for('role-'.$role->id) }}
                                                                    {{ html()->label(ucwords($role->name))->for('role-'.$role->id) }}
                                                                </div>
                                                            </div>
                                                            <div class="card-body">
                                                                @if($role->id != 1)
                                                                    @if($role->permissions->count())
                                                                        @foreach($role->permissions as $permission)
                                                                            <i class="fas fa-dot-circle"></i> {{ ucwords($permission->name) }}
                                                                        @endforeach
                                                                    @else
                                                                        @lang('labels.general.none')
                                                                    @endif
                                                                @else
                                                                    @lang('labels.backend.access.users.all_permissions')
                                                                @endif
                                                            </div>
                                                        </div><!--card-->
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>
                                                @if($permissions->count())
                                                    @foreach($permissions as $permission)
                                                        <div class="checkbox d-flex align-items-center">
                                                            {{ html()->label(
                                                                    html()->checkbox('permissions[]', old('permissions') && in_array($permission->name, old('permissions')) ? true : false, $permission->name)
                                                                          ->class('switch-input')
                                                                          ->id('permission-'.$permission->id)
                                                                        . '<span class="switch-slider" data-checked="on" data-unchecked="off"></span>')
                                                                    ->class('switch switch-label switch-pill switch-primary mr-2')
                                                                ->for('permission-'.$permission->id) }}
                                                            {{ html()->label(ucwords($permission->name))->for('permission-'.$permission->id) }}
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div><!--col-->
                        </div><!--form-group-->

			<div class="form-group row">
                        {{ html()->label('Gluu SSO User Type')->class('col-md-2 form-control-label') }}

                        <div class="table-responsive col-md-10">
                            <table class="table">
                                <thead>
                                    <tr>
                                    <th>@lang('labels.backend.access.users.table.roles')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                        <div class="card">
                                                        <div class="card-header">
                                                            <div class="checkbox d-flex align-items-center">
                                                            <!--{{ html()->label(
                                                                html()->checkbox('usertype')
                                                                ->class('switch-input')
                                                                . '<span class="switch-slider" data-checked="on" data-unchecked="off"></span>')
                                                                ->class('switch switch-label switch-pill switch-primary mr-2')
                                                            }}
                                                            {{ html()->label('Kakitangan') }}-->
                                                           <input type="checkbox" name="usertype" class="switch switch-label switch-pill" > Kakitangan
                                                        </div>
                                                        </div>
                                        </div>                
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


			
                    </div><!--col-->
                </div><!--row-->
            </div><!--card-body-->

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col">
                        {{ form_cancel(route('admin.auth.user.index'), __('buttons.general.cancel')) }}
                    </div><!--col-->

                    <div class="col text-right">
                        {{ form_submit(__('buttons.general.crud.create')) }}
                    </div><!--col-->
                </div><!--row-->
            </div><!--card-footer-->
        </div><!--card-->
    {{ html()->form()->close() }}
@endsection



<script>
		function isNumber(evt)
		{
			var charCode = (evt.which) ? evt.which : event.keyCode
			if (charCode > 31 && (charCode < 48 || charCode > 57))
				return false;

			return true;
		}
</script>
