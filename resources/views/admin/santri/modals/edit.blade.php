<div id="modal-edit-santri" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 w-full sm:max-w-xl border border-slate-200">
            
            <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div>
                    <h3 class="text-base font-bold text-slate-800">Formulir Pembaruan Data Santri</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Sesuaikan penempatan ruang kelas dan status tinggal santri.</p>
                </div>
                <button type="button" onclick="closeModal('edit')" class="text-slate-400 hover:text-slate-600 p-2 rounded-lg hover:bg-slate-100 transition-colors">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form id="form-edit-santri" action="" method="POST" enctype="multipart/form-data" class="p-6 space-y-5 text-sm max-h-[70vh] overflow-y-auto">
                @csrf
                @method('PUT')
                
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Lengkap Santri</label>
                    <input type="text" id="edit-nama" name="nama_santri" required class="w-full px-3.5 py-2 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Ruang Kelas Terplotting</label>
                    <select id="edit-kelas-id" name="kelas_id" required class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/10 transition-all bg-white cursor-pointer">
                        @foreach($daftarKelas as $kelas)
                            <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Jenis Santri (Status Tinggal)</label>
                    <div class="grid grid-cols-2 gap-3 mt-1.5">
                        <label class="border border-slate-200 rounded-xl p-3 flex items-center gap-3 cursor-pointer hover:bg-slate-50/80 transition-all">
                            <input type="radio" id="edit-jenis-mukim" name="jenis_santri" value="mukim" required class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-slate-300 accent-emerald-600">
                            <div>
                                <span class="block text-xs font-bold text-slate-700">Mukim</span>
                                <span class="block text-[10px] text-slate-400 mt-0.5">Menetap di asrama</span>
                            </div>
                        </label>
                        <label class="border border-slate-200 rounded-xl p-3 flex items-center gap-3 cursor-pointer hover:bg-slate-50/80 transition-all">
                            <input type="radio" id="edit-jenis-non-mukim" name="jenis_santri" value="non-mukim" required class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-slate-300 accent-emerald-600">
                            <div>
                                <span class="block text-xs font-bold text-slate-700">Non-Mukim</span>
                                <span class="block text-[10px] text-slate-400 mt-0.5">Laju / Pulang Pergi</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Unggah Pas Foto Formal</label>
                    <div id="container-foto-sekarang" class="mb-2 hidden">
                        <img id="edit-foto-preview" src="" alt="Foto Sekarang" class="w-20 h-24 object-cover rounded-lg border border-slate-200 shadow-sm">
                        <span class="text-[10px] text-slate-400 block mt-1">*Foto saat ini</span>
                    </div>
                    <input type="file" name="foto" accept="image/jpeg,image/jpg,image/png" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-all">
                    <p class="text-[11px] text-slate-400 mt-1">Format: JPG, JPEG, PNG. Maksimal ukuran file: 2 MB.</p>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button type="button" onclick="closeModal('edit')" class="px-4 py-2 border border-slate-200 text-slate-500 text-xs font-semibold rounded-xl hover:bg-slate-50 transition-all">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold rounded-xl shadow-md shadow-emerald-700/10 transition-all">Simpan Perubahan</button>
                </div>
            </form>

        </div>
    </div>
</div>