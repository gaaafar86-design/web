@extends('admin.layouts.master')
@section('content')
    <x-admin_navbar/>
    <x-admin_sidebar/>
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex justify-content-between">
                <h1>Users</h1>
                <div class="ml-auto">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="fas fa-plus m-2"></i>Create</a>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center align-middle" id="example1">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Photo</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <img src="{{ $user->photo ? asset('user-images/' . $user->photo) : asset('user-images/default.png') }}" class="w_100" alt="User-img">
                                                    </td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->phone }}</td>
                                                    <td>
                                                        @php
                                                            $userStatus = $user->getRawOriginal('status');
                                                        @endphp
                                                        <span @class([
                                                            'badge bg-success' => $userStatus == 1,
                                                            'badge bg-danger' => $userStatus == 0,
                                                            'badge text-bg-warning text-white' => $userStatus == 2,
                                                            ])>
                                                            {{ $user->status }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">
                                                                <i class="fas fa-trash"></i>
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
                </div>
            </div>
        </section>
    </div>
@endsection
