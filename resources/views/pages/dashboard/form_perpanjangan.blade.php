<form method="post" id="perpanjang" action="{{ $action }}" enctype="multipart/form-data">

    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="id" value="{{ $pegadaian['uuid'] }}">

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="tanggal_perpanjang">Tanggal Perpanjang</label>
                <input type="text" class="form-control" id="tanggal_perpanjang" name="tanggal_perpanjang" placeholder="Tanggal Perpanjang">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="tanggal_jatuh_tempo1">Tanggal Perpanjangan Jatuh Tempo</label>
                <input type="text" class="form-control" id="tanggal_jatuh_tempo1" name="tanggal_jatuh_tempo1" placeholder="Tanggal Perpanjangan Jatuh Tempo">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <button type="submit" id="tambah" class="btn btn-primary btn-flat"><i class="fa fa-save"></i> Perpanjang</button>
            </div>
        </div>
    </div>

</form>

<script>

    $('#tanggal_perpanjang').datepicker({
        autoclose: true,
    });

    $('#tanggal_perpanjang').datepicker(
        "setDate", new Date("{{ $pegadaian['tanggal_perpanjangan'] }}")
    );

    $('#tanggal_jatuh_tempo1').datepicker({
        autoclose: true,
    });

    $('#tanggal_jatuh_tempo1').datepicker(
        "setDate", new Date("{{ $pegadaian['tanggal_jatuh_tempo'] }}")
    );
</script>