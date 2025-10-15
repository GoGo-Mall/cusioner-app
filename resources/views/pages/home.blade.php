@extends('layouts.app')
@section('content')
    {{-- Toast Success --}}
    @if (session('success'))
        <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 2000;">
            <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif
    <form action="{{ route('cusioner.store') }}" method="POST">
        @csrf
        <!-- Nama -->
        <div class="question">
            <label class="question-label">Nama Lengkap<span class="required">*</span></label>
            <input type="text" class="form-control" name="name" placeholder="Masukkan nama Anda" required>
            <input type="hidden" name="agent_name" value="{{ $agent_name }}">
        </div>

        <!-- Email -->
        <div class="question">
            <label class="question-label">Alamat Email</label>
            <input type="email" class="form-control" name="email" placeholder="contoh@email.com">
        </div>

        <div class="question">
            <label for="" class="question-label">Product</label>
            <select name="product" class="form-control" id="">
                <option value="">Pilih Produk</option>
                <option value="acculaser">Acculaser</option>
            </select>
        </div>

        @foreach ($questions as $item)
            @if ($item->type == 'radio')
                <div class="question">
                    <label for="" class="question-label">{{ $item->question_text }}</label>
                    @foreach ($item->options as $opt)
                        <div class="form-check">
                            <input type="{{ $item->type }}" name="answer_{{ $item->id }}" class="form-check-input"
                                value="{{ $opt->id }}">
                            <label for="" class="form-check-label">{{ $opt->option_text }}</label>
                        </div>
                    @endforeach
                </div>
            @endif
        @endforeach

        <!-- Tombol Submit -->
        <button type="submit" class="btn-submit">Kirim</button>
    </form>

    {{-- Script untuk menampilkan toast --}}
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const toastEl = document.getElementById('successToast');
                const toast = new bootstrap.Toast(toastEl, {
                    delay: 3000
                });
                toast.show();
            });
        </script>
    @endif
@endsection
