@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="POST">

                            <!-- Nama -->
                            <div class="question">
                                <label class="question-label">Nama Lengkap<span class="required">*</span></label>
                                <input type="text" class="form-control" name="name" placeholder="Masukkan nama Anda"
                                    value="{{$respondents->name}}">
                                <input type="hidden" name="agent_name" value="{{ $respondents->agent_name }}">
                            </div>

                            <!-- Email -->
                            <div class="question">
                                <label class="question-label">Alamat Email</label>
                                <input type="email" class="form-control" name="email" value="{{ $respondents->email }}">
                            </div>

                            <div class="question">
                                <label for="" class="question-label">Product</label>
                                <select name="product" class="form-control" id="">
                                    <option value="{{ $respondents->product }}">{{ $respondents->product }}</option>
                                </select>
                            </div>

                            @foreach ($answers as $item)
                                @if ($item->question->type == 'radio')
                                    <div class="question">
                                        <label for="" class="question-label">{{ $item->question_text }}</label>
                                        @foreach ($item->question->options as $opt)
                                            <div class="form-check">
                                                <input type="{{ $item->question->type }}"
                                                    name="answer_{{ $item->question->id }}" class="form-check-input"
                                                    value="{{ $opt->id }}" checked>
                                                <label for=""
                                                    class="form-check-label">{{ $opt->option_text }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            @endforeach

                            <!-- Tombol Submit -->
                            <button type="submit" class="btn-submit btn-primary">Kirim</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
