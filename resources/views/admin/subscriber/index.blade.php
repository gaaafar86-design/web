@extends('admin.layouts.master')
@section('content')
    <x-admin_navbar/>
    <x-admin_sidebar/>
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex justify-content-between">
                <h1>Subscribers</h1>
                <div class="ml-auto">
                    <a href="{{ route('admin.subscribers.export') }}" class="btn btn-primary"><i class="far fa-arrow-alt-circle-down m-2"></i>Export Subscribers as CSV</a>
                    <a href="{{ route('admin.subscribers.create') }}" class="btn btn-primary"><i class="fas fa-plus m-2"></i>Create</a>
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
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th class="w_100">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($subscribers as $subscriber)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $subscriber->email }}</td>
                                                <td>
                                                    <span class="badge {{ displayIcon($subscriber->status, 'badge-success', 'badge-danger')}}">
                                                        {{ $subscriber->status ? 'Active' : 'Inactive' }}
                                                    </span>
                                                <td>
                                                    <form action="{{ route('admin.subscribers.destroy', $subscriber) }}" method="POST" style="display: inline;">
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
