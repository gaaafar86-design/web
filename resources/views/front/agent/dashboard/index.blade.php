@extends('front.layouts.master')
@section('content')
    <div class="page-top" style="background-image: url({{ asset('website-images/' . $setting->banner) }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Agent Dashboard</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content user-panel">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12">
                    <x-dashboard/>
                </div>
                <div class="col-lg-9 col-md-12">
                    <h3>Hello {{ $agent->name }}</h3>
                    <p>See all the statistics at a glance:</p>

                    <div class="row box-items">
                        <div class="col-md-4">
                            <div class="box1">
                                <h4>{{ $totalActiveProperties }}</h4>
                                <p>Active Properties</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="box2">
                                <h4>{{ $totalPendingProperties }}</h4>
                                <p>Pending Properties</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="box3">
                                <h4>{{ $totalFeaturedProperties }}</h4>
                                <p>Featured Properties</p>
                            </div>
                        </div>
                    </div>

                    <h3 class="mt-5">Recent Properties</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle">
                            <tbody>
                                <tr>
                                    <th>SL</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                @foreach ($recentProperties as $property)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $property->name }}</td>
                                        <td>{{ $property->propertyType->name }}</td>
                                        <td>{{ $property->location->name }}</td>
                                        <td>
                                            <span class="badge {{ displayIcon($property->status, 'bg-success', 'bg-danger') }}">{{ $property->status ? 'Active' : 'Pending' }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('agent.properties.edit', $property) }}" class="btn btn-warning btn-sm text-white"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('agent.properties.destroy', $property) }}" method="POST" style="display: inline;">
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
@endsection
