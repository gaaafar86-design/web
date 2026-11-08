@extends('front.layouts.master')
@section('content')
    <div class="page-top" style="background-image: url({{ asset('website-images/' . $setting->banner) }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Messages</h2>
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
                    <a href="{{ route('user.messages.create') }}" class="btn btn-primary btn-sm mb_10">New Message</a>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle">
                            <tbody>
                                <tr>
                                    <th>SL</th>
                                    <th>Subject</th>
                                    <th>Agent</th>
                                    <th>Date & Time</th>
                                    <th class="w-100">Action</th>
                                </tr>
                                @foreach ($messages as $message)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $message->subject }}</td>
                                    <td>
                                        {{ $message->agent->name }},<br>
                                        {{ $message->agent->company }}
                                    </td>
                                    <td>
                                        {{ $message->created_at->format('d M Y') }}<br>
                                        {{ $message->created_at->format('h:i A') }}
                                    </td>
                                    <td>
                                        <a href="{{ route('user.messages.reply', $message) }}" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                                        <form action="{{ route('user.messages.destroy', $message) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onClick="return confirm('Are you sure?');">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-12 mt_30">
                            {{ $messages->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
