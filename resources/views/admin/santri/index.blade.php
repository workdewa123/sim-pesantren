@extends('layouts.admin')

@section('title', 'Data Master Santri')
@section('page_title', 'Manajemen Data Santri')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
    
    <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-slate-50/50">
        <div>
            <h3 class="text-base font-bold text-slate-800">Daftar Santri Aktif</h3>
            <p class="text-xs text-slate-500 mt-0.5">Gunakan filter dropdown di samping untuk memilah data santri per kelas.</p>
        </div>
        
        <form action="{{ route('admin.santri.index') }}" method="GET" class="flex flex-wrap items-center gap-2.5 self-start md:self-center w-full md:w-auto">
            
            <div class="flex items-center bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden group focus-within:border-emerald-600 transition-all">
                <div class="pl-2.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-[11px]"></i>
                </div>
                <input type="text" name="cari_nama" value="{{ request('cari_nama') }}" placeholder="Cari nama santri..." class="pl-2 pr-3 py-2 text-xs w-40 sm:w-48 bg-transparent focus:outline-none text-slate-700 font-medium placeholder:text-slate-400">
            </div>

            <select name="jenis_santri" onchange="this.form.submit()" class="px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 bg-white shadow-sm focus:outline-none focus:border-emerald-600 cursor-pointer">
                <option value="">Semua Status</option>
                <option value="mukim" {{ request('jenis_santri') == 'mukim' ? 'selected' : '' }}>Mukim</option>
                <option value="non-mukim" {{ request('jenis_santri') == 'non-mukim' ? 'selected' : '' }}>Non-Mukim</option>
            </select>

            <select name="kelas_id" onchange="this.form.submit()" class="px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 bg-white shadow-sm focus:outline-none focus:border-emerald-600 cursor-pointer">
                <option value="">Semua Kelas</option>
                @foreach($daftarKelas as $kelas)
                    <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                        Kelas {{ $kelas->nama_kelas }}
                    </option>
                @endforeach
            </select>

            @if(request()->filled('kelas_id') || request()->filled('cari_nama') || request()->filled('jenis_santri'))
                <a href="{{ route('admin.santri.index') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold rounded-xl transition-colors flex items-center gap-1" title="Reset Filter">
                    <i class="fa-solid fa-rotate-left"></i> Clear
                </a>
            @endif
        </form>
    </div>

    @if(session('success'))
        <div class="m-6 mb-0 p-4 bg-emerald-50 border border-emerald-200/60 text-emerald-800 text-xs font-semibold rounded-xl flex items-center gap-2.5 animate-fade-in">
            <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

<div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs min-w-[700px]">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-slate-400 font-bold uppercase tracking-wider">
                    <th class="py-4 px-6 w-1">No</th>
                    <th class="py-4 px-6 text-center w-20">Foto</th>
                    <th class="py-4 px-4 w-1/4">Nama Lengkap Santri</th>
                    <th class="py-4 px-4 w-32">Kelas</th>
                    <th class="py-4 px-4 w-36">Jenis Santri</th>
                    <th class="py-4 px-6 text-center w-36">Aksi Manajemen</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                @forelse($daftarSantri as $row)
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="py-3 px-6">{{ ($daftarSantri->currentPage() - 1) * $daftarSantri->perPage() + $loop->iteration }}</td>
                    <td class="py-3 px-6 text-center whitespace-nowrap">
                        @if($row->foto)
                            <img src="{{ asset('storage/foto_santri/' . $row->foto) }}" alt="Foto" class="w-8 h-10 object-cover rounded shadow-sm mx-auto border border-slate-100">
                        @else
                            <div class="w-8 h-10 bg-emerald-50 text-emerald-700 rounded shadow-sm mx-auto flex items-center justify-center font-bold text-xs border border-emerald-100">
                                {{ strtoupper(substr($row->nama_santri, 0, 1)) }}
                            </div>
                        @endif
                    </td>
                    
                    <td class="py-3 px-4 font-bold text-slate-800 break-words whitespace-normal">
                        {{ $row->nama_santri }}
                    </td>
                    
                    <td class="py-3 px-4 whitespace-nowrap">
                        <span class="px-2 py-1 bg-slate-100 text-slate-700 rounded-md font-semibold border border-slate-200/40">
                            Kelas {{ $row->nama_kelas ?? 'Belum Diplot' }}
                        </span>
                    </td>
                    
                    <td class="py-3 px-4 whitespace-nowrap">
                        @if(($row->jenis_santri ?? '') == 'mukim')
                            <span class="px-2 py-1 bg-emerald-50 text-emerald-700 rounded-md font-bold uppercase tracking-wide text-[10px] border border-emerald-200/40">Mukim</span>
                        @elseif(($row->jenis_santri ?? '') == 'non-mukim')
                            <span class="px-2 py-1 bg-amber-50 text-amber-700 rounded-md font-bold uppercase tracking-wide text-[10px] border border-amber-200/40">Non-Mukim</span>
                        @else
                            <span class="text-slate-400 italic text-[11px]">Belum Diatur</span>
                        @endif
                    </td>
                    
                    <td class="py-3 px-6 text-center whitespace-nowrap">
                        <div class="flex items-center justify-center gap-2">
                            <button type="button" 
                                    onclick="renderDetailSantriToModal({{ json_encode($row) }})" 
                                    class="w-7 h-7 bg-slate-50 hover:bg-slate-100 text-slate-600 rounded-lg flex items-center justify-center border border-slate-200 shadow-sm transition-all cursor-pointer">
                                <i class="fa-solid fa-eye text-[11px]"></i>
                            </button>                            <button type="button" onclick="editSantri({{ json_encode($row) }})" class="p-2 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-lg text-xs transition-colors" title="Ubah Kelas/Status">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <form action="{{ route('admin.santri.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data santri ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-lg text-xs transition-colors" title="Hapus Data">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-12 text-center text-slate-400">
                        <i class="fa-solid fa-users-slash text-3xl text-slate-200 mb-2 block"></i>
                        <span class="text-sm">Tidak ditemukan data santri aktif pada kategori ini.</span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
        @if($daftarSantri->hasPages())
        <div class="p-5 border-t border-slate-100 bg-slate-50/50">
            {{ $daftarSantri->links() }}
        </div>
    @endif
</div>

@include('admin.santri.modals.show')
@include('admin.santri.modals.edit')

<script>
    function openShowModal(santri) {
        if (!santri) return;

        // Isi data teks pokok ke elemen modal detail
        document.getElementById('show-nama-header').innerText = santri.nama_santri || '-';
        document.getElementById('show-nama').innerText = santri.nama_santri || '-';
        document.getElementById('show-kelas').innerText = santri.nama_kelas || 'Belum Ada Kelas';
        document.getElementById('show-jenis').innerText = santri.jenis_santri === 'mukim' ? 'Mukim (Tinggal)' : 'Non-Mukim';
        document.getElementById('show-tanggal-lahir').innerText = santri.tanggal_lahir || '-';
        document.getElementById('show-tahun-masuk').innerText = santri.tahun_masuk || '-';
        
        // Data Orang Tua & Kontak Wali
        document.getElementById('show-ayah').innerText = santri.nama_ayah || '-';
        document.getElementById('show-ibu').innerText = santri.nama_ibu || '-';
        document.getElementById('show-hp').innerText = santri.no_hp_wali || '-';
        document.getElementById('show-alamat').innerText = santri.alamat_santri || '-';

        // Logika Pengaturan Foto
        const showFoto = document.getElementById('show-foto');
        const showAvatar = document.getElementById('show-avatar');

        if (santri.foto) {
            showFoto.src = "{{ asset('storage/foto_santri') }}/" + santri.foto;
            showFoto.classList.remove('hidden');
            showAvatar.classList.add('hidden');
        } else {
            // Jika foto kosong, buat avatar inisial huruf nama
            showAvatar.innerText = santri.nama_santri.charAt(0).toUpperCase();
            showAvatar.classList.remove('hidden');
            showFoto.classList.add('hidden');
        }

        // Tampilkan container modal dengan menghapus class hidden
        document.getElementById('modal-show-santri').classList.remove('hidden');
    }

    // 3. Perbarui fungsi editSantri agar mendukung inisialisasi dropdown biaya awal
    function editSantri(santri) {
        // Reset tab ke "akademik" setiap kali modal dibuka pertama kali
        switchEditTab('akademik');

        // Set action URL form update
        document.getElementById('form-edit-santri').action = "/admin/santri/update/" + santri.id;

        // --- TAB 1: AKADEMIK DATA ---
        document.getElementById('edit-nama').value = santri.nama_santri || '';
        document.getElementById('edit-kelas-id').value = santri.kelas_id || '';
        document.getElementById('edit-tahun-masuk').value = santri.tahun_masuk || '';

        // Radio Button Jenis Santri & Inisialisasi Dropdown Biaya
        if (santri.jenis_santri === 'mukim') {
            document.getElementById('edit-jenis-mukim').checked = true;
            updateBiayaDropdown('mukim', santri.pilihan_biaya);
        } else if (santri.jenis_santri === 'non-mukim') {
            document.getElementById('edit-jenis-non-mukim').checked = true;
            updateBiayaDropdown('non-mukim', santri.pilihan_biaya);
        } else {
            document.getElementById('edit-jenis-mukim').checked = false;
            document.getElementById('edit-jenis-non-mukim').checked = false;
            updateBiayaDropdown('', '');
        }

        // Pas Foto Formal Preview
        const containerFoto = document.getElementById('container-foto-sekarang');
        const previewFoto = document.getElementById('edit-foto-preview');
        if (santri.foto) {
            previewFoto.src = "{{ asset('storage/foto_santri') }}/" + santri.foto;
            containerFoto.classList.remove('hidden');
        } else {
            containerFoto.classList.add('hidden');
        }

        // --- TAB 2: BIODATA PRIBADI ---
        document.getElementById('edit-tanggal-lahir').value = santri.tanggal_lahir || '';
        document.getElementById('edit-hp').value = santri.no_hp_wali || '';
        document.getElementById('edit-alamat').value = santri.alamat_santri || '';

        // --- TAB 3: DATA ORANG TUA & STATUS BERKAS ---
        document.getElementById('edit-nama-ayah').value = santri.nama_ayah || '';
        document.getElementById('edit-nama-ibu').value = santri.nama_ibu || '';
        document.getElementById('edit-alamat-ortu').value = santri.alamat_orang_tua || '';

        // Indikator Berkas KK & Akte (Jika ada)
        const kkIndicator = document.getElementById('edit-kk-preview-container');
        const akteIndicator = document.getElementById('edit-akte-preview-container');

        if (santri.file_kk) {
            kkIndicator.classList.remove('hidden');
        } else {
            kkIndicator.classList.add('hidden');
        }

        if (santri.file_akte) {
            akteIndicator.classList.remove('hidden');
        } else {
            akteIndicator.classList.add('hidden');
        }

        // Tampilkan Modal Edit
        document.getElementById('modal-edit-santri').classList.remove('hidden');
    }
    // Tambahkan Fungsi Baru Ini untuk Kontrol Perpindahan Tab
    function switchEditTab(tab) {
        const tabs = ['akademik', 'biodata', 'berkas'];
        
        tabs.forEach(t => {
            const btn = document.getElementById(`tab-btn-${t}`);
            const content = document.getElementById(`tab-content-${t}`);
            
            if (t === tab) {
                // Aktifkan tab yang dipilih
                btn.classList.add('border-emerald-600', 'text-emerald-700');
                btn.classList.remove('border-transparent', 'text-slate-500');
                content.classList.remove('hidden');
            } else {
                // Nonaktifkan tab lainnya
                btn.classList.add('border-transparent', 'text-slate-500');
                btn.classList.remove('border-emerald-600', 'text-emerald-700');
                content.classList.add('hidden');
            }
        });
    }

    // Kirim data biaya terbaru ke context JavaScript di index.blade.php
    const masterKonfigBiaya = @json(\DB::table('pengaturan_biaya')->get());

    function updateBiayaDropdown(jenisSantri, selectedValue = '') {
        const biayaSelect = document.getElementById('edit-pilihan-biaya');
        biayaSelect.innerHTML = ''; 

        // Ambil opsi dari objek master database pendaftaran
        let filtered = masterKonfigBiaya.filter(item => item.jenis_santri === jenisSantri);

        if (filtered.length === 0) {
            biayaSelect.innerHTML = '<option value="">-- Pilih Jenis Santri Terlebih Dahulu --</option>';
            return;
        }

        filtered.forEach(item => {
            const option = document.createElement('option');
            // Masukkan nominal sebagai value
            option.value = item.nominal; 
            option.text = item.teks_tampilan;
            
            // Auto select data lama santri
            if (selectedValue == item.nominal || selectedValue == item.teks_tampilan || selectedValue == `Rp ${item.nominal}`) {
                option.selected = true;
            }
            
            biayaSelect.appendChild(option);
        });
    }

    // 2. Pasang Event Listener agar saat Admin mengubah pilihan radio button di form edit,
    // dropdown biaya langsung ikut berubah saat itu juga.
    document.addEventListener('DOMContentLoaded', function() {
        const radioMukim = document.getElementById('edit-jenis-mukim');
        const radioNonMukim = document.getElementById('edit-jenis-non-mukim');

        if (radioMukim && radioNonMukim) {
            radioMukim.addEventListener('change', function() {
                if (this.checked) updateBiayaDropdown('mukim');
            });

            radioNonMukim.addEventListener('change', function() {
                if (this.checked) updateBiayaDropdown('non-mukim');
            });
        }
    });
    function closeModal(type) {
        if (type === 'show') {
            document.getElementById('modal-show-santri').classList.add('hidden');
        } else if (type === 'edit') {
            document.getElementById('modal-edit-santri').classList.add('hidden');
        }
    }
</script>
@endsection