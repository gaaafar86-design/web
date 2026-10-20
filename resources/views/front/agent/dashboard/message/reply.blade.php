@extends('front.layouts.master')
@section('content')
    <div class="page-top" style="background-image: url({{ asset('website-images/' . $setting->banner) }})">
        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Subject: {{ $message->subject }}</h2>
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
                    <form action="{{ route('agent.messages.reply.submit', $message)}}" method="POST" class="mb_30">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Reply to {{ $message->user->name }} *</label>
                            <div class="form-group">
                                <textarea name="reply" class="form-control h-150">{{ old('reply') }}</textarea>
                                @error('reply')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary btn-sm" value="Submit">
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle">
                            <tbody>
                                <tr>
                                    <td class="w-100">
                                        <img src="{{ $message->user->photo ? asset('user-images/'. $message->user->photo) : asset('user-images/default.png') }}" alt="User-image" class="w-100 rounded-circle mb_10">
                                    </td>
                                    <td class="w-200">
                                        <b>{{ $message->user->name }}</b><br>
                                        Posted On: <br>{{ $message->created_at->format('d M Y - H:i:s') }}<br>
                                        <span class="badge bg-success">Customer</span>
                                    </td>
                                    <td>
                                        {{ $message->message }}
                                    </td>
                                </tr>
                                @foreach ($replies as $reply)
                                    @php
                                        $sentByCustomer = $reply->sender == 'Customer';
                                    @endphp
                                    <tr>
                                        <td class="w-100">
                                            @if ($sentByCustomer)
                                                <img src="{{ $message->user->photo ? asset('user-images/'. $message->user->photo) : asset('user-images/default.png') }}" alt="User-image" class="w-100 rounded-circle mb_10">
                                            @else
                                                <img src="{{ $message->agent->photo ? asset('user-images/'. $message->agent->photo) : asset('user-images/default.png') }}" alt="Agent-image" class="w-100 rounded-circle mb_10">
                                            @endif
                                        </td>
                                        <td class="w-200">
                                            @if ($sentByCustomer)
                                                <b>{{ $message->user->name }}</b><br>
                                            @else
                                                <b>{{ $message->agent->name }}</b><br>
                                            @endif
                                            Posted On: <br>{{ $reply->created_at->format('d M Y - H:i:s') }}<br>
                                            @if ($sentByCustomer)
                                                <span class="badge bg-success">Customer</span>
                                            @else
                                                <span class="badge bg-primary">Agent</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $reply->message }}
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
