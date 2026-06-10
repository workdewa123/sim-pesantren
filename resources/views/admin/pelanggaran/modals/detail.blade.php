<div id="modalDetailSantri" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm" onclick="tutupModalDetail()"></div>
    <div class="flex items-center justify-center min-h-screen px-4 py-6 text-center sm:p-0">
        <div class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full w-full">
            
            <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <h3 class="font-bold text-slate-800 flex items-center gap-2 text-sm uppercase tracking-tight">
                    <i class="fa-solid fa-id-card text-emerald-600"></i> Rekam Kedisiplinan Santri
                </h3>
                <button onclick="tutupModalDetail()" class="text-slate-400 hover:text-slate-600 p-2 rounded-lg hover:bg-slate-100 transition-colors">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            
            <div class="p-5 space-y-5 max-h-[75vh] overflow-y-auto">
                <div class="flex flex-col sm:flex-row items-center gap-4 bg-emerald-50/40 p-4 rounded-2xl border border-emerald-100/50">
                    <div id="modal-foto-container"></div>
                    <div class="text-center sm:text-left space-y-1">
                        <h4 id="modal-nama" class="text-base font-black text-slate-800">-</h4>
                        <div class="flex flex-wrap justify-center sm:justify-start gap-2">
                            <span class="px-2 py-0.5 bg-white border border-slate-200 text-slate-600 text-[10px] font-bold rounded-md uppercase">Kelas: <span id="modal-kelas">-</span></span>
                            <span id="modal-status" class="px-2 py-0.5 rounded-md text-[10px] font-bold uppercase bg-emerald-100 text-emerald-700">-</span>
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    <h5 class="font-bold text-slate-700 text-xs flex items-center gap-1.5 px-1 uppercase tracking-wider">
                        <i class="fa-solid fa-clock-rotate-left text-emerald-600"></i> Histori Pelanggaran
                    </h5>
                    <div class="border border-slate-100 rounded-xl overflow-hidden bg-white shadow-sm">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-50 text-slate-400 font-bold uppercase border-b border-slate-100 text-[9px]">
                                <tr>
                                    <th class="p-3 text-center w-24">Tanggal</th>
                                    <th class="p-3 text-center w-16">Tingkat</th>
                                    <th class="p-3">Keterangan Kronologi</th>
                                    <th class="p-3 w-24">Pencatat</th>
                                </tr>
                            </thead>
                            <tbody id="modal-tabel-riwayat" class="divide-y divide-slate-100 text-slate-600"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="p-4 bg-slate-50 border-t border-slate-100 text-right">
                <button onclick="tutupModalDetail()" class="px-5 py-2 bg-white border border-slate-200 text-slate-600 rounded-xl text-xs font-bold hover:bg-slate-100 transition-colors shadow-sm">Tutup Histori</button>
            </div>
        </div>
    </div>
</div>