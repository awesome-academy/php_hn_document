@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>
                <strong>{{ $message }}</strong>
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
        <h1 class="h3 mb-2 text-gray-800">@lang('member.list')</h1>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">@lang('member.list')</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="memberTable">
                        <thead>
                        <tr>
                            <th>@lang('member.id')</th>
                            <th>@lang('member.image')</th>
                            <th>@lang('member.name')</th>
                            <th>@lang('member.email')</th>
                            <th>@lang('member.phone')</th>
                            <th>@lang('member.address')</th>
                            <th>@lang('member.role')</th>
                            <th>@lang('member.status')</th>
                            <th>@lang('member.coin')</th>
                            <th>@lang('member.upgrade')</th>
                            <th>@lang('member.ban')</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>@lang('member.id')</th>
                            <th>@lang('member.image')</th>
                            <th>@lang('member.name')</th>
                            <th>@lang('member.email')</th>
                            <th>@lang('member.phone')</th>
                            <th>@lang('member.address')</th>
                            <th>@lang('member.role')</th>
                            <th>@lang('member.status')</th>
                            <th>@lang('member.coin')</th>
                            <th>@lang('member.upgrade')</th>
                            <th>@lang('member.ban')</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach ($members as $member)
                            <tr>
                                <td>{{ $member->id }}</td>
                                <td>
                                    <img class="img-fluid" width="90" height="90"
                                         src={{ $member->image != null ? asset($member->image) : asset(config('user.image_default')) }}>
                                </td>
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->email }}</td>
                                <td>{{ $member->phone }}</td>
                                <td>{{ $member->address }}</td>
                                <td>{{ $member->role->name ?? config('user.invalid') }}</td>
                                <td>{{ $member->status }}</td>
                                <td>{{ $member->coin }}</td>
                                <td>
                                    <form action="{{ route('admin.members.upgrade', $member->id) }}" method="POST">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="btn btn-warning" >
                                            <i class="fas fa-arrow-up"></i>
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route('admin.members.ban', $member->id) }}" method="POST">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="btn btn-danger" >
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
