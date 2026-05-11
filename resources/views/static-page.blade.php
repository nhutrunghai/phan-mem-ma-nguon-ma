@extends('layouts.app')

@section('content')
    <section class="page-placeholder">
        <div class="container">
            <div class="placeholder-card">
                <div class="placeholder-body">
                    <span class="placeholder-tab">{{ $eyebrow ?? 'Beta Cinemas' }}</span>
                    <h1>{{ $heading ?? $title ?? 'Beta Cinemas' }}</h1>
                    <div class="modal-static-copy">
                        @foreach (($paragraphs ?? []) as $paragraph)
                            <p>{{ $paragraph }}</p>
                        @endforeach

                        @if (!empty($items))
                            <ul>
                                @foreach ($items as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
