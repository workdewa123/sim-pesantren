<div id="modal-edit-rincian" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 w-full sm:max-w-md border border-slate-200">
            
            <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50 text-xs">
                <div>
                    <h3 class="text-sm font-bold text-slate-800"><i class="fa-solid fa-pen-to-square text-amber-500 mr-1"></i> Edit Komponen Biaya</h3>
                    <p class="text-slate-400 mt-0.5">Ubah rincian data komponen biaya pendaftaran aktif.</p>
                </div>
                <button type="button" onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 p-2 rounded-lg hover:bg-slate-100 transition-colors">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>

            <form id="form-edit-rincian" action="" method="POST" class="p-5 space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block font-semibold text-slate-600 mb-1">Nama Komponen Biaya</label>
                    <input type="text" id="edit-nama-komponen" name="nama_komponen" required class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-emerald-600 focus:outline-none">
                </div>

                <div>
                    <label class="block font-semibold text-slate-600 mb-1">Peruntukan Santri</label>
                    <select id="edit-jenis-santri" name="jenis_santri" required class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-white focus:border-emerald-600 focus:outline-none">
                        <option value="semua">Semua (Mukim & Non-Mukim)</option>
                        <option value="mukim">Khusus Santri Mukim (Asrama)</option>
                        <option value="non-mukim">Khusus Santri Non-Mukim (Laju)</option>
                    </select>
                </div>

                <div>
                    <label class="block font-semibold text-slate-600 mb-1">Nominal Biaya (Rp)</label>
                    <input type="number" id="edit-nominal" name="nominal" required class="w-full px-3 py-2 rounded-lg border border-slate-200 font-mono focus:border-emerald-600 focus:outline-none">
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 border border-slate-200 text-slate-500 font-semibold rounded-xl hover:bg-slate-50 transition-all">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl transition-colors shadow-sm">
                        <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>