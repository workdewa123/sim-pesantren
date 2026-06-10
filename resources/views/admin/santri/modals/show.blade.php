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
                            <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 font-semibold rounded-full border border-emerald-200/60 inline-flex items-center gap-1 scale-90 origin-left">
                                <span class="w-1 h-1 rounded-full bg-emerald-500 animate-pulse"></span>Aktif
                            </span>
                        </p>
                    </div>
                </div>
                <button type="button" onclick="closeModal('show')" class="text-slate-400 hover:text-slate-600 p-2 rounded-lg hover:bg-slate-100 transition-colors">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <div class="p-6 space-y-6 text-sm max-h-[70vh] overflow-y-auto">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="space-y-4">
                        <h4 class="text-xs font-bold text-emerald-700 uppercase tracking-wider">Informasi Personal</h4>
                        <div class="space-y-3 bg-slate-50/60 p-4 rounded-xl border border-slate-100">
                            <div>
                                <span class="block text-[11px] font-semibold text-slate-400 uppercase">Nama Lengkap Santri</span>
                                <span id="show-nama" class="font-semibold text-slate-800"></span>
                            </div>
                            <div>
                                <span class="block text-[11px] font-semibold text-slate-400 uppercase">Jenis Kelamin</span>
                                <span id="show-jk" class="font-medium text-slate-700"></span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h4 class="text-xs font-bold text-emerald-700 uppercase tracking-wider">Administrasi Pondok</h4>
                        <div class="space-y-3 bg-slate-50/60 p-4 rounded-xl border border-slate-100">
                            <div>
                                <span class="block text-[11px] font-semibold text-slate-400 uppercase">Penempatan Kelas</span>
                                <span id="show-kelas" class="font-bold text-emerald-800"></span>
                            </div>
                            <div>
                                <span class="block text-[11px] font-semibold text-slate-400 uppercase">Kategori / Jenis Tinggal</span>
                                <span id="show-jenis" class="px-2.5 py-0.5 text-xs font-bold rounded-md uppercase tracking-wider inline-block mt-0.5"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <h4 class="text-xs font-bold text-emerald-700 uppercase tracking-wider">Kontak Orang Tua / Wali</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-slate-50/60 p-4 rounded-xl border border-slate-100">
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-400 uppercase">Nama Wali / Orang Tua</span>
                            <span id="show-wali" class="font-medium text-slate-800"></span>
                        </div>
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-400 uppercase">No. HP / WhatsApp</span>
                            <span id="show-hp" class="font-medium text-slate-800"></span>
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <h4 class="text-xs font-bold text-emerald-700 uppercase tracking-wider">Alamat Rumah</h4>
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <p id="show-alamat" class="text-slate-700 leading-relaxed font-medium"></p>
                    </div>
                </div>
            </div>

            <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-end gap-3">
                <button type="button" onclick="closeModal('show')" class="px-4 py-2 border border-slate-200 text-slate-600 text-xs font-bold rounded-xl hover:bg-slate-100 transition-colors">Tutup</button>
                <button type="button" id="btn-edit-from-show" class="px-4 py-2 bg-amber-50 hover:bg-amber-100 text-amber-700 text-xs font-bold rounded-xl transition-colors flex items-center gap-1.5 border border-amber-200/40">
                    <i class="fa-solid fa-pen-to-square"></i> Ubah Data
                </button>
            </div>

        </div>
    </div>
</div>