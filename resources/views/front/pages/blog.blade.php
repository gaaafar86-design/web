@extends('front.layouts.master')
@section('content')
 <style>
    .custom-page-top-image {
        min-height: 260px !important;
        height: 260px !important;
        background-size: 100% 100% !important;
        background-position: center center !important;
        background-repeat: no-repeat !important;
    }

    @media (max-width: 768px) {
        .custom-page-top-image {
            min-height: 190px !important;
            height: 190px !important;
        }
    }
</style>

<div class="page-top custom-page-top-image"
     style="background-image: url('{{ asset('website-images/cooooo2.png') }}');">

    <div class="bg"></div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                {{-- عنوان الصفحة هنا إذا موجود --}}
            </div>
        </div>
    </div>

</div>

        <div class="bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    
                </div>
            </div>
        </div>
    </div>
    <div class="blog">
        <div class="container">
            <div class="row">
                @foreach ($posts as $post)
                    <div class="col-lg-4 col-md-6">
                        <div class="item border rounded">
                            <div class="photo">
                                <img src="{{ asset('blog-images/' . $post->photo) }}" alt="Post-image"/>
                            </div>
                            <div class="text p_10">
                                <h2>
                                    <a href="{{ route('post', $post->slug) }}">{{ $post->title }}</a>
                                </h2>
                                <div class="short-des" style="height: 150px">
                                    <p>{{ $post->short_description }}</p>
                                </div>
                                <div class="button ">
                                    <a href="{{ route('post', $post->slug) }}" class="btn btn-primary">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-md-12">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
