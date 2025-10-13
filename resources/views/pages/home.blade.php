@extends('layouts.app')
@section('content')
    <form action="{{route('cusioner.store')}}" method="POST">
        @csrf
        <!-- Nama -->
        <div class="question">
            <label class="question-label">Nama Lengkap<span class="required">*</span></label>
            <input type="text" class="form-control" name="name" placeholder="Masukkan nama Anda" required>
            <input type="hidden" name="agent_name" value="{{$agent_name}}">
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
            @if($item->type == 'radio')
                <div class="question">
                    <label for="" class="question-label">{{$item->question_text}}</label>
                    @foreach ($item->options as $opt)
                        <div class="form-check">
                            <input type="{{$item->type}}" name="answer_{{$item->id}}" class="form-check-input" value="{{$opt->id}}">
                            <label for="" class="form-check-label">{{$opt->option_text}}</label>
                        </div>
                    @endforeach
                </div>
            @endif
        @endforeach

        <!-- Tombol Submit -->
        <button type="submit" class="btn-submit">Kirim</button>
    </form>
@endsection
