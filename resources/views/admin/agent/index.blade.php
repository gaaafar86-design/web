@extends('admin.layouts.master')
@section('content')
    <x-admin_navbar/>
    <x-admin_sidebar/>
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex justify-content-between">
                <h1>Agents</h1>
                <div class="ml-auto">
                    <a href="{{ route('admin.agents.create') }}" class="btn btn-primary"><i class="fas fa-plus m-2"></i>Create</a>
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
                                                <th>Company</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($agents as $agent)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <img src="{{ $agent->photo ? asset('user-images/' . $agent->photo) : asset('user-images/default.png') }}" class="w_100" alt="Agent-image">
                                                    </td>
                                                    <td>{{ $agent->name }}</td>
                                                    <td>{{ $agent->email }}</td>
                                                    <td>{{ $agent->phone }}</td>
                                                    <td>{{ $agent->company }}</td>
                                                    <td>
                                                        @php
                                                            $agentStatus = $agent->getRawOriginal('status');
                                                        @endphp
                                                        <span @class([
                                                            'badge bg-success' => $agentStatus == 1,
                                                            'badge bg-danger' => $agentStatus == 0,
                                                            'badge text-bg-warning text-white' => $agentStatus == 2,
                                                            ])>
                                                            {{ $agent->status }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.agents.edit', $agent) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                                        <a href="{{ route('admin.agents.show', $agent) }}" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                                                        <form action="{{ route('admin.agents.destroy', $agent) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(
                                                            'This action will delete all the properties associated with this agent!'
                                                            );">
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
