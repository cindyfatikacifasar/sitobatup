<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Nama Tanaman *</label>
        <input type="text" name="nama" class="form-control" value="{{ old('nama', $tanaman->nama ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Nama Ilmiah *</label>
        <input type="text" name="nama_ilmiah" class="form-control" value="{{ old('nama_ilmiah', $tanaman->nama_ilmiah ?? '') }}" required>
    </div>
</div>

<div class="row">
    {{-- KATEGORI (CHECKBOX MULTIPLE) --}}
    <div class="col-md-6 mb-3">
        <label class="form-label d-block">Kategori * <small class="text-muted">(Bisa pilih lebih dari 1)</small></label>
        <div class="d-flex flex-wrap gap-3 p-3 border rounded bg-light" style="max-height: 150px; overflow-y: auto;">
            @php
                $selectedKategoris = old('kategori_ids', isset($tanaman) ? $tanaman->kategoris->pluck('id')->toArray() : []);
            @endphp
            @foreach($kategoris as $k)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="kategori_ids[]" 
                           value="{{ $k->id }}" id="kat{{ $k->id }}"
                           {{ in_array($k->id, $selectedKategoris) ? 'checked' : '' }}>
                    <label class="form-check-label" for="kat{{ $k->id }}" style="cursor:pointer;">{{ $k->nama }}</label>
                </div>
            @endforeach
        </div>
    </div>
    
    {{-- BAGIAN YANG DIGUNAKAN (CHECKBOX MULTIPLE) --}}
    <div class="col-md-6 mb-3">
        <label class="form-label d-block">Bagian yang Digunakan *</label>
        <div class="d-flex flex-wrap gap-3 p-3 border rounded bg-light">
            @php
                $opsiBagian = ['Daun', 'Akar', 'Batang', 'Bunga', 'Buah', 'Rimpang', 'Kulit Kayu', 'Biji'];
                $oldBagian = old('bagian_digunakan', $tanaman->bagian_digunakan ?? []);
                if(is_string($oldBagian)) $oldBagian = explode(', ', $oldBagian);
            @endphp
            @foreach($opsiBagian as $opsi)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="bagian_digunakan[]" 
                           value="{{ $opsi }}" id="check{{ $opsi }}"
                           {{ in_array($opsi, (array)$oldBagian) ? 'checked' : '' }}>
                    <label class="form-check-label" for="check{{ $opsi }}" style="cursor:pointer;">{{ $opsi }}</label>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Kolektor</label>
        <input type="text" name="kolektor" class="form-control" value="{{ old('kolektor', $tanaman->kolektor ?? '') }}">
    </div>

</div>

<div class="mb-3">
    <label class="form-label d-block">Tampilkan di Beranda Utama?</label>
    <div class="form-check form-switch border p-2 ps-5 rounded bg-light" style="display: inline-block; min-width: 250px;">
        <input type="hidden" name="is_favourite" value="0">
        <input class="form-check-input" type="checkbox" name="is_favourite" value="1" id="isFavourite" 
               {{ old('is_favourite', $tanaman->is_favourite ?? false) ? 'checked' : '' }} style="width: 40px; height: 20px;">
        <label class="form-check-label ms-2" for="isFavourite" style="cursor:pointer;">Ya, Tampilkan</label>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Asal Tanaman Obat *</label>
    <textarea name="asal_usul" class="form-control" rows="4" required>{{ old('asal_usul', $tanaman->asal_usul ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label class="form-label">Deskripsi *</label>
    <textarea name="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi', $tanaman->deskripsi ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Khasiat & Manfaat *</label>
    <textarea name="khasiat" class="form-control" rows="4" required>{{ old('khasiat', $tanaman->khasiat ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Foto Tanaman</label>
    <input type="file" name="foto" class="form-control">
    @if(isset($tanaman) && $tanaman->foto)
        <img src="{{ Storage::url($tanaman->foto) }}" width="100" class="img-thumbnail mt-2 d-block">
    @endif
</div>