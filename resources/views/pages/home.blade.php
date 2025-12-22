@extends('layouts.app')

@section('content')
    {{-- Toast Success --}}
    @if (session('success'))
        <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 2000;">
            <div id="successToast" class="toast align-items-center text-bg-success border-0">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('cusioner.store') }}" method="POST" id="questionForm">
        @csrf

        {{-- STEP 1 : Data Diri --}}
        {{-- STEP 1 : Data Diri --}}
        <div class="question-step">
            <label class="question-label">Nama Lengkap <span class="required">*</span></label>
            <input type="text" class="form-control mb-3" value="{{ request('customer') }}" readonly>
            <input type="hidden" name="name" value="{{ request('customer') }}">

            <label class="question-label">Phone</label>
            <input type="text" class="form-control mb-3" value="{{ request('phone') }}" readonly>
            <input type="hidden" name="phone" value="{{ request('phone') }}">

            <label class="question-label">Product</label>
            <input type="text" class="form-control mb-3" value="{{ request('product') }}" readonly>
            <input type="hidden" name="product" value="{{ request('product') }}">

            <input type="hidden" name="agent_name" value="{{ request('agent_name') }}">

            <button type="button" class="btn btn-primary next-btn mt-3">
                Next
            </button>
        </div>



        {{-- STEP 4+ : Pertanyaan --}}
        @foreach ($questions as $item)
            <div class="question-step">
                <label class="question-label">{{ $item->question_text }}</label>

                @foreach ($item->options as $opt)
                    <div class="form-check">
                        <input type="radio" name="answer_{{ $item->id }}" class="form-check-input"
                            value="{{ $opt->id }}" required>
                        <label class="form-check-label">{{ $opt->option_text }}</label>
                    </div>
                @endforeach

                @if ($loop->last)
                    <button type="submit" class="btn btn-success mt-3">Kirim</button>
                @else
                    <button type="button" class="btn btn-primary next-btn mt-3">Next</button>
                @endif
            </div>
        @endforeach
    </form>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const steps = document.querySelectorAll('.question-step');
            let currentStep = 0;

            steps[currentStep].classList.add('active');

            document.querySelectorAll('.next-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    steps[currentStep].classList.remove('active');
                    currentStep++;

                    if (steps[currentStep]) {
                        steps[currentStep].classList.add('active');
                    }
                });
            });
        });
    </script>
@endpush
