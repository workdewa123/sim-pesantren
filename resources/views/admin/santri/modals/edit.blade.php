<div id="modal-edit-santri" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 w-full sm:max-w-2xl border border-slate-200">
            
            <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div>
                    <h3 class="text-base font-bold text-slate-800">Formulir Pembaruan Data Santri</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Kelola seluruh informasi biodata, akademik, dan berkas santri.</p>
                </div>
                <button type="button" onclick="closeModal('edit')" class="text-slate-400 hover:text-slate-600 p-2 rounded-lg hover:bg-slate-100 transition-colors">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <div class="flex border-b border-slate-100 bg-slate-50/30 px-6 text-xs font-bold text-slate-500">
                <button type="button" id="tab-btn-akademik" onclick="switchEditTab('akademik')" class="py-3 px-4 border-b-2 border-emerald-600 text-emerald-700 transition-all flex items-center gap-1.5 focus:outline-none">
                    <i class="fa-solid fa-graduation-cap"></i> Akademik & Pondok
                </button>
                <button type="button" id="tab-btn-biodata" onclick="switchEditTab('biodata')" class="py-3 px-4 border-b-2 border-transparent hover:text-slate-700 transition-all flex items-center gap-1.5 focus:outline-none">
                    <i class="fa-solid fa-user"></i> Biodata Pribadi
                </button>
                <button type="button" id="tab-btn-berkas" onclick="switchEditTab('berkas')" class="py-3 px-4 border-b-2 border-transparent hover:text-slate-700 transition-all flex items-center gap-1.5 focus:outline-none">
                    <i class="fa-solid fa-file-shield"></i> Orang Tua & Berkas
                </button>
            </div>

            <form id="form-edit-santri" action="" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="p-6 space-y-5 text-xs max-h-[calc(100vh-280px)] overflow-y-auto">
                    
                    <div id="tab-content-akademik" class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2">
                                <label class="block font-semibold text-slate-600 mb-1">Nama Lengkap Santri</label>
                                <input type="text" id="edit-nama" name="nama_santri" required class="w-full px-3.5 py-2 rounded-lg border border-slate-200 text-xs focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10 transition-all">
                            </div>
                            <div>
                                <label class="block font-semibold text-slate-600 mb-1">Ruang Kelas Terplotting</label>
                                <select id="edit-kelas-id" name="kelas_id" required class="w-full px-3 py-2 rounded-lg border border-slate-200 text-xs focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10 transition-all bg-white cursor-pointer">
                                    @foreach($daftarKelas as $kelas)
                                        <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block font-semibold text-slate-600 mb-1">Tahun Masuk</label>
                                <input type="number" id="edit-tahun-masuk" name="tahun_masuk" class="w-full px-3.5 py-2 rounded-lg border border-slate-200 text-xs focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10 transition-all" placeholder="Contoh: 2025">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block font-semibold text-slate-600 mb-1">Pilihan Biaya Bulanan</label>
                                <select id="edit-pilihan-biaya" name="pilihan_biaya" required class="w-full px-3 py-2 rounded-lg border border-slate-200 text-xs focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10 transition-all bg-white cursor-pointer">
                                    </select>
                            </div>
                        </div>

                        <div>
                            <label class="block font-semibold text-slate-600 mb-1">Jenis Santri (Status Tinggal)</label>
                            <div class="grid grid-cols-2 gap-3 mt-1">
                                <label class="border border-slate-200 rounded-xl p-3 flex items-center gap-3 cursor-pointer hover:bg-slate-50/80 transition-all">
                                    <input type="radio" id="edit-jenis-mukim" name="jenis_santri" value="mukim" required class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-slate-300 accent-emerald-600">
                                    <div>
                                        <span class="block font-bold text-slate-700">Mukim</span>
                                        <span class="block text-[10px] text-slate-400 mt-0.5">Menetap di asrama</span>
                                    </div>
                                </label>
                                <label class="border border-slate-200 rounded-xl p-3 flex items-center gap-3 cursor-pointer hover:bg-slate-50/80 transition-all">
                                    <input type="radio" id="edit-jenis-non-mukim" name="jenis_santri" value="non-mukim" required class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-slate-300 accent-emerald-600">
                                    <div>
                                        <span class="block font-bold text-slate-700">Non-Mukim</span>
                                        <span class="block text-[10px] text-slate-400 mt-0.5">Laju / Pulang Pergi</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <label class="block font-semibold text-slate-600 mb-1">Pembaruan Pas Foto Formal</label>
                            <div class="flex items-center gap-4 mt-1.5">
                                <div id="container-foto-sekarang" class="hidden shrink-0">
                                    <img id="edit-foto-preview" src="" alt="Foto Sekarang" class="w-14 h-16 object-cover rounded-lg border border-slate-200 shadow-sm">
                                </div>
                                <div class="w-full">
                                    <input type="file" name="foto" accept="image/jpeg,image/jpg,image/png" class="w-full text-[11px] text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-all">
                                    <p class="text-[10px] text-slate-400 mt-1">Format: JPG, JPEG, PNG. Maksimal: 2 MB.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="tab-content-biodata" class="space-y-4 hidden">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-semibold text-slate-600 mb-1">Tanggal Lahir</label>
                                <input type="date" id="edit-tanggal-lahir" name="tanggal_lahir" class="w-full px-3.5 py-2 rounded-lg border border-slate-200 text-xs focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10 transition-all">
                            </div>
                            <div>
                                <label class="block font-semibold text-slate-600 mb-1">No. HP / WhatsApp Wali</label>
                                <input type="text" id="edit-hp" name="no_hp_wali" class="w-full px-3.5 py-2 rounded-lg border border-slate-200 text-xs focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10 transition-all" placeholder="Contoh: 081234567xxx">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block font-semibold text-slate-600 mb-1">Alamat Tinggal Santri</label>
                                <textarea id="edit-alamat" name="alamat_santri" rows="3" class="w-full px-3.5 py-2 rounded-lg border border-slate-200 text-xs focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10 transition-all resize-none" placeholder="Tulis alamat domisili lengkap..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div id="tab-content-berkas" class="space-y-4 hidden">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-semibold text-slate-600 mb-1">Nama Ayah Kandung</label>
                                <input type="text" id="edit-nama-ayah" name="nama_ayah" class="w-full px-3.5 py-2 rounded-lg border border-slate-200 text-xs focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10 transition-all">
                            </div>
                            <div>
                                <label class="block font-semibold text-slate-600 mb-1">Nama Ibu Kandung</label>
                                <input type="text" id="edit-nama-ibu" name="nama_ibu" class="w-full px-3.5 py-2 rounded-lg border border-slate-200 text-xs focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10 transition-all">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block font-semibold text-slate-600 mb-1">Alamat Rumah Orang Tua</label>
                                <textarea id="edit-alamat-ortu" name="alamat_orang_tua" rows="2" class="w-full px-3.5 py-2 rounded-lg border border-slate-200 text-xs focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10 transition-all resize-none" placeholder="Kosongkan jika sama dengan alamat santri..."></textarea>
                            </div>
                        </div>

                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 space-y-3">
                            <span class="block font-bold text-slate-700 border-b border-slate-200 pb-1.5"><i class="fa-solid fa-cloud-arrow-up mr-1 text-emerald-600"></i> Perbarui Dokumen Pendukung</span>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-[11px]">
                                <div>
                                    <label class="block font-semibold text-slate-600 mb-1">Berkas Kartu Keluarga (KK)</label>
                                    <div id="edit-kk-preview-container" class="mb-1.5 text-[10px] text-emerald-700 font-semibold hidden">
                                        <i class="fa-solid fa-circle-check"></i> Sudah ada berkas KK
                                    </div>
                                    <input type="file" name="file_kk" accept="image/*,application/pdf" class="w-full text-[10px] text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:bg-slate-200 file:text-slate-700 hover:file:bg-slate-300 transition-all">
                                </div>
                                <div>
                                    <label class="block font-semibold text-slate-600 mb-1">Berkas Akte Kelahiran</label>
                                    <div id="edit-akte-preview-container" class="mb-1.5 text-[10px] text-emerald-700 font-semibold hidden">
                                        <i class="fa-solid fa-circle-check"></i> Sudah ada berkas Akte
                                    </div>
                                    <input type="file" name="file_akte" accept="image/*,application/pdf" class="w-full text-[10px] text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:bg-slate-200 file:text-slate-700 hover:file:bg-slate-300 transition-all">
                                </div>
                            </div>
                            <p class="text-[10px] text-slate-400 mt-1">*Format berkas: JPG, PNG, atau PDF. Maksimal: 2 MB.</p>
                        </div>
                    </div>

                </div>

                <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-end gap-3">
                    <button type="button" onclick="closeModal('edit')" class="px-4 py-2 border border-slate-200 text-slate-500 text-xs font-semibold rounded-xl hover:bg-slate-50 transition-all">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold rounded-xl shadow-md shadow-emerald-700/10 transition-all">Simpan Perubahan</button>
                </div>
            </form>

        </div>
    </div>
</div>