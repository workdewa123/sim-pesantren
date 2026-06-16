<div id="modal-show-santri" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 w-full sm:max-w-3xl border border-slate-200">
            
            <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <img id="show-foto" src="" alt="Pas Foto" class="w-16 h-20 object-cover rounded-xl border border-slate-200 shadow-sm hidden">
                    <div id="show-avatar" class="w-16 h-20 bg-emerald-100 text-emerald-700 rounded-xl flex items-center justify-center text-2xl font-bold border border-emerald-200 hidden"></div>
                    <div>
                        <h3 id="show-nama-header" class="text-base font-bold text-slate-800"></h3>
                        <p class="text-xs text-slate-500 mt-0.5">Status Akun: 
                            <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 font-bold rounded-md border border-emerald-100 text-[10px] capitalize" id="show-status"></span>
                        </p>
                    </div>
                </div>
                <button type="button" onclick="closeModal('show')" class="text-slate-400 hover:text-slate-600 p-2 rounded-lg hover:bg-slate-100 transition-colors">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <div class="p-6 space-y-6 max-h-[calc(100vh-200px)] overflow-y-auto text-xs">
                
                <div class="space-y-3">
                    <h4 class="text-xs font-bold text-emerald-700 uppercase tracking-wider">Informasi Akademik & Pondok</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 bg-slate-50/50 p-4 rounded-xl border border-slate-100">
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-400 uppercase">Nama Lengkap</span>
                            <span id="show-nama" class="font-semibold text-slate-800">-</span>
                        </div>
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-400 uppercase">Penempatan Kelas</span>
                            <span id="show-kelas" class="font-semibold text-slate-800">-</span>
                        </div>
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-400 uppercase">Jenis Santri</span>
                            <span id="show-jenis" class="font-semibold text-slate-800">-</span>
                        </div>
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-400 uppercase">Tahun Masuk</span>
                            <span id="show-tahun-masuk" class="font-semibold text-slate-800">-</span>
                        </div>
                        <div class="sm:col-span-2">
                            <span class="block text-[11px] font-semibold text-slate-400 uppercase">Pilihan Biaya Bulanan</span>
                            <span id="show-pilihan-biaya" class="font-semibold text-emerald-700 bg-emerald-50 border border-emerald-100/50 px-2 py-0.5 rounded-md inline-block mt-0.5">-</span>
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    <h4 class="text-xs font-bold text-emerald-700 uppercase tracking-wider">Biodata Pribadi & Kontak</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-slate-50/50 p-4 rounded-xl border border-slate-100">
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-400 uppercase">Tanggal Lahir</span>
                            <span id="show-tanggal-lahir" class="font-medium text-slate-800">-</span>
                        </div>
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-400 uppercase">No. HP / WhatsApp Wali</span>
                            <span id="show-hp" class="font-semibold text-slate-800 text-sm">-</span>
                        </div>
                        <div class="sm:col-span-2">
                            <span class="block text-[11px] font-semibold text-slate-400 uppercase">Alamat Tinggal Santri</span>
                            <p id="show-alamat" class="text-slate-700 leading-relaxed font-medium mt-0.5">-</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    <h4 class="text-xs font-bold text-emerald-700 uppercase tracking-wider">Data Orang Tua / Wali</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-slate-50/50 p-4 rounded-xl border border-slate-100">
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-400 uppercase">Nama Ayah Kandung</span>
                            <span id="show-nama-ayah" class="font-medium text-slate-800">-</span>
                        </div>
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-400 uppercase">Nama Ibu Kandung</span>
                            <span id="show-nama-ibu" class="font-medium text-slate-800">-</span>
                        </div>
                        <div class="sm:col-span-2">
                            <span class="block text-[11px] font-semibold text-slate-400 uppercase">Alamat Rumah Orang Tua</span>
                            <p id="show-alamat-ortu" class="text-slate-700 leading-relaxed font-medium mt-0.5">-</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    <h4 class="text-xs font-bold text-emerald-700 uppercase tracking-wider">Berkas Dokumen Pendukung</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-slate-50/50 p-4 rounded-xl border border-slate-100">
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-400 uppercase mb-1">Kartu Keluarga (KK)</span>
                            <div id="container-kk">-</div>
                        </div>
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-400 uppercase mb-1">Akte Kelahiran</span>
                            <div id="container-akte">-</div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-end gap-3">
                <button type="button" onclick="closeModal('show')" class="px-4 py-2 border border-slate-200 text-slate-600 text-xs font-bold rounded-xl hover:bg-slate-100 transition-colors">Tutup</button>
                <button type="button" id="btn-edit-from-show" class="px-4 py-2 bg-amber-50 hover:bg-amber-100 text-amber-700 text-xs font-bold rounded-xl transition-colors flex items-center gap-1.5 border border-amber-200/60">
                    <i class="fa-solid fa-pen-to-square"></i> Edit Biodata
                </button>
            </div>

        </div>
    </div>
</div>

<script>
// Fungsi yang dipanggil dari index.blade.php setelah data berhasil di-fetch
function renderDetailSantriToModal(santri) {
    document.getElementById('show-nama-header').innerText = santri.nama_santri || '-';
    document.getElementById('show-nama').innerText = santri.nama_santri || '-';
    document.getElementById('show-status').innerText = santri.status_santri || 'aktif';
    document.getElementById('show-kelas').innerText = santri.nama_kelas || 'Tanpa Kelas';
    
    document.getElementById('show-jenis').innerText = santri.jenis_santri === 'mukim' 
        ? 'Mukim (Tinggal di Dalam)' 
        : 'Non-Mukim (Pulang Pergi)';

    document.getElementById('show-tahun-masuk').innerText = santri.tahun_masuk || '-';
    document.getElementById('show-pilihan-biaya').innerText = santri.pilihan_biaya || '-';
    document.getElementById('show-tanggal-lahir').innerText = santri.tanggal_lahir ? formatDateIndonesia(santri.tanggal_lahir) : '-';
    document.getElementById('show-hp').innerText = santri.no_hp_wali || '-';
    document.getElementById('show-alamat').innerText = santri.alamat_santri || 'Alamat belum diisi.';
    
    document.getElementById('show-nama-ayah').innerText = santri.nama_ayah || '-';
    document.getElementById('show-nama-ibu').innerText = santri.nama_ibu || '-';
    document.getElementById('show-alamat-ortu').innerText = santri.alamat_orang_tua || '-';

    // Logika Gambar
    const imgFoto = document.getElementById('show-foto');
    const divAvatar = document.getElementById('show-avatar');

    if (santri.foto) {
        imgFoto.src = "{{ asset('storage/foto_santri') }}/" + santri.foto;
        imgFoto.classList.remove('hidden');
        divAvatar.classList.add('hidden');
    } else {
        const inisial = santri.nama_santri ? santri.nama_santri.charAt(0).toUpperCase() : 'S';
        divAvatar.innerText = inisial;
        divAvatar.classList.remove('hidden');
        imgFoto.classList.add('hidden');
    }

    // Tautan Berkas KK
    const containerKK = document.getElementById('container-kk');
    if (santri.file_kk) {
        containerKK.innerHTML = `<a href="/storage/${santri.file_kk}" target="_blank" class="inline-flex items-center gap-1 text-emerald-600 hover:text-emerald-700 font-semibold"><i class="fa-solid fa-file-pdf text-sm"></i> Lihat Berkas KK</a>`;
    } else {
        containerKK.innerHTML = `<span class="text-slate-400 italic">Belum diunggah</span>`;
    }

    // Tautan Berkas Akte
    const containerAkte = document.getElementById('container-akte');
    if (santri.file_akte) {
        containerAkte.innerHTML = `<a href="/storage/${santri.file_akte}" target="_blank" class="inline-flex items-center gap-1 text-emerald-600 hover:text-emerald-700 font-semibold"><i class="fa-solid fa-file-pdf text-sm"></i> Lihat Berkas Akte</a>`;
    } else {
        containerAkte.innerHTML = `<span class="text-slate-400 italic">Belum diunggah</span>`;
    }

    // Tombol Edit di Dalam Modal Detail
    const btnEditFromShow = document.getElementById('btn-edit-from-show');
    btnEditFromShow.onclick = function() {
        closeModal('show');
        if (typeof editSantri === 'function') {
            editSantri(santri);
        }
    };

    // Munculkan Modal
    document.getElementById('modal-show-santri').classList.remove('hidden');
}

function formatDateIndonesia(dateString) {
    if(!dateString) return '-';
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
}
</script>