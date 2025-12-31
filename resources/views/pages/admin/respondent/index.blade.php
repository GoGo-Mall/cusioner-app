@extends('layouts.admin')
@section('title', 'Respondent')
@section('content')
    <!-- Table Respondents -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name Agent</th>
                <th>Name</th>
                <th>Email</th>
                <th>Product</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="">
            <!-- Data dari localStorage -->\
            @foreach ($respondents as $item)
                @php
                    $score = $item->score / 5 / $item->norespon;
                @endphp
                <tr>
                    <td>{{$item->agent_name}}</td>
                    <td>{{$score}}</td>
                    <td><small>{{$item->respon}}</small>/ <small>{{$item->norespon}}</small></td>
                    <td></td>
                    <td>
                        <a href="" class="btn btn-sm btn-warning">Show</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
@push('script')
    <script>
        // Load data dari localStorage
        let respondents = @json($respondents)

        function renderRespondents() {
            const tbody = document.getElementById('respondentsTable');
            tbody.innerHTML = '';

            // ✅ Jika data kosong
            if (!respondents || respondents.length === 0) {
                const row = tbody.insertRow();
                row.innerHTML = `
            <td colspan="5" class="text-center text-muted py-3">
                <i class="fa-solid fa-circle-info me-2"></i> Belum ada data responden.
            </td>
        `;
                return;
            }

            // ✅ Jika ada data, render seperti biasa
            respondents.forEach(r => {
                const row = tbody.insertRow();
                row.innerHTML = `
            <td>${r.agent_name }</td>
            <td>${r.name}</td>
            <td>${r.email}</td>
            <td>${r.product}</td>
            <td>
                <button class="btn btn-sm btn-info" onclick="viewAssessment(${r.id})">
                    <i class="fa-solid fa-eye me-1"></i> View Assessment
                </button>
            </td>
        `;
            });

            // ✅ Simpan data ke localStorage
            localStorage.setItem('respondents', JSON.stringify(respondents));
        }


        // Render saat load
        renderRespondents();
    </script>
@endpush
