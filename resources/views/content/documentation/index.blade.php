@extends('layouts/contentNavbarLayout')

@section('title', __('Documentations'))

@section('vendor-script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/vendor/js/quill.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/katex.js') }}"></script>
@endsection

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/quill.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/katex.css') }}" />
@endsection

@section('content')

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="mb-1 mt-3">{{ __('Documentations') }}</h4>
        </div>
        <div class="d-flex align-content-center flex-wrap gap-3">
            <button type="submit" form="form" class="btn btn-primary">
                <i class="bx bx-save me-1"></i>{{ __('Send') }}
            </button>
        </div>
    </div>

    <form action="{{ route('documentation.update') }}" method="POST" id="form">
        @csrf

        <div class="nav-align-top mb-4">
            <ul class="nav nav-pills mb-3" role="tablist">
                @foreach ($documentations as $key => $documentation)
                    <li class="nav-item">
                        <button type="button" class="nav-link {{ $loop->first ? 'active' : '' }}" role="tab"
                            data-bs-toggle="tab" data-bs-target="#tab-{{ $key }}"
                            aria-controls="tab-{{ $key }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                            {{ __($documentation->name) }}
                        </button>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach ($documentations as $key => $documentation)
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="tab-{{ $key }}"
                        role="tabpanel">
                        <input type="hidden" name="documentations[{{ $loop->index }}][key]" value="{{ $key }}">

                        <ul class="nav nav-tabs mb-3" role="tablist">
                            @foreach (['en', 'fr', 'ar'] as $locale)
                                <li class="nav-item">
                                    <button type="button"
                                        class="nav-link {{ $loop->first ? 'active' : '' }}"
                                        data-bs-toggle="tab"
                                        data-bs-target="#tab-{{ $key }}-{{ $locale }}"
                                        role="tab">
                                        {{ strtoupper($locale) }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content">
                            @foreach (['en', 'fr', 'ar'] as $locale)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                    id="tab-{{ $key }}-{{ $locale }}" role="tabpanel">
                                    <div class="mb-3">
                                        <div id="editor-{{ $key }}-{{ $locale }}">
                                            {!! $documentation->{'content_' . $locale} !!}
                                        </div>
                                        <input type="hidden"
                                            name="documentations[{{ $loop->parent->index }}][content_{{ $locale }}]"
                                            id="content-{{ $key }}-{{ $locale }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </form>


@endsection

@section('page-script')
    <script>
        $(document).ready(function() {
            const editors = {};

            @foreach ($documentations as $key => $documentation)
                @foreach (['en', 'fr', 'ar'] as $locale)
                    {
                        const editor = new Quill('#editor-{{ $key }}-{{ $locale }}', {
                            theme: 'snow',
                            modules: {
                                toolbar: [
                                    [{
                                        font: []
                                    }, {
                                        size: []
                                    }],
                                    ['bold', 'italic', 'underline', 'strike'],
                                    [{
                                        color: []
                                    }, {
                                        background: []
                                    }],
                                    [{
                                        script: 'super'
                                    }, {
                                        script: 'sub'
                                    }],
                                    [{
                                        header: [1, 2, 3, 4, 5, 6, false]
                                    }, 'blockquote', 'code-block'],
                                    [{
                                        list: 'ordered'
                                    }, {
                                        list: 'bullet'
                                    }, {
                                        indent: '-1'
                                    }, {
                                        indent: '+1'
                                    }],
                                    [{
                                        align: []
                                    }, {
                                        direction: 'rtl'
                                    }],
                                    ['link', 'image', 'video'],
                                    ['clean']
                                ]
                            }
                        });

                        editors['{{ $key }}-{{ $locale }}'] = editor;

                        const $content = $('#content-{{ $key }}-{{ $locale }}');
                        $content.val(editor.root.innerHTML);

                        editor.on('text-change', function() {
                            $content.val(editor.root.innerHTML);
                        });
                    }
                @endforeach
            @endforeach

            $('form').on('submit', function() {
                @foreach ($documentations as $key => $documentation)
                    @foreach (['en', 'fr', 'ar'] as $locale)
                        $('#content-{{ $key }}-{{ $locale }}').val(editors['{{ $key }}-{{ $locale }}'].root.innerHTML);
                    @endforeach
                @endforeach
            });
        });
    </script>
@endsection
