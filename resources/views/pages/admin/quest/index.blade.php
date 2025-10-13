@extends('layouts.admin')

@section('title', 'Manage Questions')

@section('content')
    <div class="container-fluid px-3 py-4">
        <div class="row">
            <!-- Form Section -->
            <div class="col-lg-5 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white fw-bold">
                        <i class="bi bi-plus-circle me-2"></i> Add New Question
                    </div>
                    <div class="card-body">
                        <form id="addQuestionForm">
                            @csrf
                            <div class="mb-3">
                                <label for="questionText" class="form-label fw-semibold">Question Text</label>
                                <input type="text" class="form-control" id="questionText" name="question_text"
                                    placeholder="Masukkan pertanyaan..." required>
                            </div>

                            <div class="mb-3">
                                <label for="questionType" class="form-label fw-semibold">Question Type</label>
                                <select class="form-select" id="questionType" name="type">
                                    <option value="text">Text (Jawaban bebas)</option>
                                    <option value="radio">Radio (Pilih satu)</option>
                                    <option value="checkbox">Checkbox (Pilih lebih dari satu)</option>
                                </select>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="required">
                                <label class="form-check-label" for="required">Pertanyaan wajib diisi</label>
                            </div>

                            <!-- Option Repeater -->
                            <div id="optionsRepeater" class="bg-light border rounded p-3" style="display: none;">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <h6 class="mb-0 fw-semibold text-secondary">Pilihan Jawaban</h6>
                                    <button type="button" class="btn btn-sm btn-outline-primary" id="addOptionBtn">
                                        <i class="bi bi-plus"></i> Tambah Option
                                    </button>
                                </div>
                                <p class="text-muted small mb-3">Tambahkan minimal 2 pilihan (text dan skor).</p>

                                <div class="repeater-group">
                                    <div class="repeater mb-2">
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" placeholder="Option Text"
                                                name="optionText[]">
                                            <input type="number" class="form-control" placeholder="Value"
                                                name="optionValue[]">
                                        </div>
                                    </div>
                                    <div class="repeater mb-2">
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" placeholder="Option Text"
                                                name="optionText[]">
                                            <input type="number" class="form-control" placeholder="Value"
                                                name="optionValue[]">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-save me-1"></i> Simpan Pertanyaan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="col-lg-7">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-secondary text-white fw-bold">
                        <i class="bi bi-list-ul me-2"></i> Daftar Pertanyaan
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 90px;">Urutan</th>
                                    <th>Pertanyaan</th>
                                    <th>Tipe</th>
                                    <th>Wajib</th>
                                    <th style="width: 180px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="questionsTable">
                                <!-- Data akan dimuat dari localStorage -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // let questions = JSON.parse(localStorage.getItem('questions')) || [
            //     { id: 1, order: 1, question_text: 'Bagaimana kepuasan Anda terhadap layanan kami?', type: 'radio', required: true,
            //       options: [{ text: 'Sangat Puas', value: 10 }, { text: 'Kurang Puas', value: 5 }] },
            //     { id: 2, order: 2, question_text: 'Masukkan saran Anda untuk kami.', type: 'text', required: false }
            // ];

            let questions = @json($quests)

            const form = document.getElementById('addQuestionForm');
            const tableBody = document.getElementById('questionsTable');
            const questionType = document.getElementById('questionType');
            const optionsRepeater = document.getElementById('optionsRepeater');
            const addOptionBtn = document.getElementById('addOptionBtn');

            // Render Table
            // Render Table
            function renderQuestions() {
                tableBody.innerHTML = '';

                if (!questions || questions.length === 0) {
                    // Jika belum ada data
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                    <td colspan="5" class="text-center text-muted py-3">
                        <i class="fa-solid fa-circle-info me-2"></i> Belum ada data pertanyaan.
                    </td>
                `;
                    tableBody.appendChild(tr);
                    return; // Hentikan fungsi
                }

                // Jika ada data, tampilkan seperti biasa
                questions.sort((a, b) => a.order - b.order).forEach(q => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td><input type="number" class="form-control form-control-sm text-center" style="width:70px;" value="${q.order}" onchange="updateOrder(${q.id}, this.value)"></td>
                        <td>${q.question_text}</td>
                        <td><span class="badge bg-info text-dark text-capitalize">${q.type}</span></td>
                        <td>${q.required ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-secondary">No</span>'}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-primary" onclick="editQuestion(${q.id})"><i class="fa-solid fa-pencil"></i></button>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteQuestion(${q.id})"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </td>
                    `;
                    tableBody.appendChild(tr);
                });

                // Simpan di localStorage (opsional)
                localStorage.setItem('questions', JSON.stringify(questions));
            }


            // Add Question
            form.addEventListener('submit', async e => {
                e.preventDefault();

                const text = document.getElementById('questionText').value.trim();
                const type = questionType.value;
                const required = document.getElementById('required').checked;
                const order = questions.length + 1;
                let options = [];

                // 🔸 Validasi opsi jika tipe pertanyaan adalah radio/checkbox
                if (type === 'radio' || type === 'checkbox') {
                    const texts = document.querySelectorAll('input[name="optionText[]"]');
                    const values = document.querySelectorAll('input[name="optionValue[]"]');

                    for (let i = 0; i < texts.length; i++) {
                        if (texts[i].value.trim()) {
                            options.push({
                                text: texts[i].value.trim(),
                                value: parseInt(values[i].value) || 0
                            });
                        }
                    }

                    if (options.length < 2) {
                        alert('Minimal 2 options diperlukan untuk radio/checkbox!');
                        return;
                    }
                }

                // 🔸 Validasi pertanyaan kosong
                if (!text) {
                    alert('Teks pertanyaan tidak boleh kosong!');
                    return;
                }

                const formData = {
                    question_text: text,
                    type,
                    required,
                    order,
                    options
                };

                try {
                    const response = await fetch("{{ route('quest.store') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json", // ✅ WAJIB
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify(formData)
                    });

                    // 🔸 Cek apakah response bukan JSON (misalnya error HTML dari Laravel)
                    const contentType = response.headers.get("content-type");
                    let result;

                    if (contentType && contentType.includes("application/json")) {
                        result = await response.json();
                    } else {
                        const text = await response.text();
                        console.error("Response bukan JSON:", text);
                        alert("Server mengembalikan respons tidak valid. Periksa console log.");
                        return;
                    }

                    // 🔸 Jika response OK (status 200–299)
                    if (response.ok) {
                        questions.push(result.data);
                        localStorage.setItem('questions', JSON.stringify(questions));
                        renderQuestions();
                        form.reset();
                        optionsRepeater.style.display = 'none';
                        alert('Pertanyaan berhasil ditambahkan ke database!');
                    } else {
                        alert('Gagal menyimpan pertanyaan: ' + (result.message ||
                            'Terjadi kesalahan.'));
                    }

                } catch (error) {
                    console.error('Fetch error:', error);
                    alert('Terjadi kesalahan koneksi ke server.');
                }
            });



            // Toggle Repeater
            questionType.addEventListener('change', function() {
                optionsRepeater.style.display = (this.value === 'radio' || this.value === 'checkbox') ?
                    'block' : 'none';
            });

            // Add Repeater Row
            addOptionBtn.addEventListener('click', function() {
                const group = optionsRepeater.querySelector('.repeater-group');
                const div = document.createElement('div');
                div.className = 'repeater mb-2';
                div.innerHTML = `
            <div class="input-group mb-2">
                <input type="text" class="form-control" placeholder="Option Text" name="optionText[]">
                <input type="number" class="form-control" placeholder="Value" name="optionValue[]">
                <button type="button" class="btn btn-outline-danger" onclick="this.closest('.repeater').remove()"><i class="bi bi-x"></i></button>
            </div>
        `;
                group.appendChild(div);
            });

            // Global functions
            // 🔹 Update urutan pertanyaan
            window.updateOrder = async function(id, newOrder) {
                const q = questions.find(q => q.id === id);
                if (!q) return;

                q.order = parseInt(newOrder);
                questions.sort((a, b) => a.order - b.order);
                questions.forEach((q, i) => q.order = i + 1);

                try {
                    const response = await fetch(`/admin/quest/${id}`, {
                        method: "PUT",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            question_text: q.question_text,
                            type: q.type,
                            required: q.required,
                            order: q.order,
                            options: q.options || []
                        })
                    });

                    if (response.ok) {
                        renderQuestions();
                    } else {
                        alert("Gagal memperbarui urutan pertanyaan.");
                    }
                } catch (err) {
                    console.error(err);
                    alert("Terjadi kesalahan koneksi ke server.");
                }
            };


            // 🔹 Edit pertanyaan
            window.editQuestion = async function(id) {
                try {
                    // Ambil data pertanyaan dari server
                    const res = await fetch(`/admin/quest/${id}/edit`);
                    const q = await res.json();

                    if (!q) {
                        alert('Pertanyaan tidak ditemukan.');
                        return;
                    }

                    const newText = prompt('Edit Pertanyaan:', q.question_text);
                    if (newText === null || newText.trim() === '') return;

                    const newType = prompt('Ubah Tipe (text/radio/checkbox):', q.type);
                    if (!['text', 'radio', 'checkbox'].includes(newType)) return;

                    const newRequired = confirm('Wajib diisi? (OK = Ya, Cancel = Tidak)');

                    // Update ke database
                    const response = await fetch(`/admin/quest/${id}`, {
                        method: "PUT",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            question_text: newText.trim(),
                            type: newType,
                            required: newRequired,
                            order: q.order,
                            options: q.options || []
                        })
                    });

                    const result = await response.json();

                    if (response.ok) {
                        // Update array lokal
                        const index = questions.findIndex(item => item.id === id);
                        if (index !== -1) questions[index] = result.data;

                        localStorage.setItem('questions', JSON.stringify(questions));
                        renderQuestions();
                        alert('Pertanyaan berhasil diperbarui!');
                    } else {
                        alert('Gagal memperbarui pertanyaan.');
                    }

                } catch (error) {
                    console.error(error);
                    alert('Terjadi kesalahan koneksi ke server.');
                }
            };

            window.deleteQuestion = async function(id) {
                if (!confirm('Hapus pertanyaan ini?')) return;

                try {
                    const response = await fetch(`/admin/quest/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content,
                            'Accept': 'application/json'
                        }
                    });

                    if (!response.ok) {
                        throw new Error('Gagal menghapus pertanyaan');
                    }

                    const result = await response.json();
                    alert(result.message || 'Pertanyaan berhasil dihapus.');

                    // 🔹 Hapus dari array lokal dan rerender
                    questions = questions.filter(q => q.id !== id);
                    questions.forEach((q, i) => q.order = i + 1);
                    renderQuestions();

                } catch (error) {
                    console.error(error);
                    alert('Terjadi kesalahan saat menghapus pertanyaan.');
                }
            };


            renderQuestions();
        });
    </script>
@endpush
