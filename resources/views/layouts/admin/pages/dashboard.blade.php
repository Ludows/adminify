@extends('layouts.admin.app')

@section('content')
    @include('layouts.admin.headers.topPageListing')

    <div class="container-fluid mt--7">

        <div class="row mt-5 row-cols-1 row-cols-md-2 row-cols-lg-3">
            @foreach($blocks as $block)
                <div class="col mb-4">
                    {!! $block !!}
                </div>
            @endforeach
        </div>

        @include('layouts.admin.footers.auth')
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
