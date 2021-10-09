<form method="post" id="pendaftar" action="{{ $action }}" enctype="multipart/form-data">

    @if(!empty($pegadaian))
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="id" value="{{ $pegadaian->uuid }}">
    @endif


    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="nik_peminjam">NIK KTP</label>
                <input type="text" class="form-control" id="nik_peminjam" name="nik_peminjam" placeholder="NIK KTP" value="{{ $pegadaian->nik_peminjam ?? ''}}">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="nama_peminjam">Nama Peminjam</label>
                <input type="text" class="form-control" id="nama_peminjam" name="nama_peminjam" placeholder="Nama Peminjan" value="{{ $pegadaian->nama_peminjam ?? ''}}">
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="alamat_peminjam">Alamat Peminjam</label>
                <textarea class="form-control" name="alamat_peminjam" id="alamat_peminjam" placeholder="Alamat Peminjan">{{ $pegadaian->alamat_peminjam ?? ''}}</textarea>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="no_telepon">Nomor Telepon Peminjam</label>
                <input type="text" class="form-control" id="no_telepon" name="no_telepon" placeholder="Nomor Telepon/WA Peminjan" value="{{ $pegadaian->no_telepon ?? ''}}">
            </div>
        </div>
    </div>

    @if(empty($pegadaian))
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="tanggal_masuk_pinjaman">Tanggal Peminjaman</label>
                <input type="text" class="form-control" id="tanggal_masuk_pinjaman" name="tanggal_masuk_pinjaman" placeholder="Tanggal Peminjaman" value="{{ $pegadaian->tanggal_masuk_pinjaman ?? ''}}">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="tanggal_jatuh_tempo">Tanggal Jatuh Tempo</label>
                <input type="text" class="form-control" id="tanggal_jatuh_tempo" name="tanggal_jatuh_tempo" placeholder="Tanggal Jatuh Tempo" value="{{ $pegadaian->tanggal_jatuh_tempo ?? ''}}">
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="jumlah_pinjaman">Jumlah Pinjaman</label>
                <input type="text" class="form-control" id="jumlah_pinjaman" name="jumlah_pinjaman" placeholder="Jumlah Pinjaman" value="{{ $pegadaian->jumlah_pinjaman ?? ''}}">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="jumlah_tebusan">Jumlah Tebusan</label>
                <input type="text" class="form-control" id="jumlah_tebusan" name="jumlah_tebusan" placeholder="Jumlah Tebusan" value="{{ $pegadaian->jumlah_tebusan ?? ''}}">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="keterangan_jaminan">Keterangan Jaminan</label>
                <input type="text" class="form-control" id="keterangan_jaminan" name="keterangan_jaminan" placeholder="Keterangan Jaminan" value="{{ $pegadaian->keterangan_jaminan ?? ''}}">
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <button type="submit" id="tambah" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Simpan</button>
                <button type="reset" class="btn btn-warning btn-flat"><i class="fa fa-refresh"></i> Reset</button>
            </div>   
        </div>
    </div>    

</form>

<script>

    $('#tanggal_masuk_pinjaman').datepicker({
        autoclose : true,
    });

    $('#tanggal_masuk_pinjaman').datepicker(
        "setDate", new Date()
    );

    $('#tanggal_jatuh_tempo').datepicker({
        autoclose : true,
    });

    $('#tanggal_jatuh_tempo').datepicker(
        "setDate", new Date()
    );

</script>