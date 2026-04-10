<!-- <h4>Preview Data</h4> -->
<div class="row">
    <div class="col-lg-3">NAMA KELOMPOK</div>
    <div class="col-lg-9">: @php echo str_replace('"','',json_encode($sheetData[3]['C'])) @endphp</div>
</div>
<div class="row">
    <div class="col-lg-3">ALAMAT</div>
    <div class="col-lg-9">: @php echo str_replace('"','',json_encode($sheetData[4]['C'])) @endphp</div>
</div>
<div class="row">
    <div class="col-lg-3">KABUPATEN/KOTA</div>
    <div class="col-lg-9">: @php echo str_replace('"','',json_encode($sheetData[5]['C'])) @endphp</div>
</div>
<div class="row">
    <div class="col-lg-3">KECAMATAN</div>
    <div class="col-lg-9">: @php echo str_replace('"','',json_encode($sheetData[6]['C'])) @endphp</div>
</div>
<div class="row">
    <div class="col-lg-3">KELURAHAN</div>
    <div class="col-lg-9">: @php echo str_replace('"','',json_encode($sheetData[7]['C'])) @endphp</div>
</div>
<div class="row">
    <div class="col-lg-3">JENIS BANTUAN</div>
    <div class="col-lg-9">: @php echo str_replace('"','',json_encode($sheetData[8]['C'])) @endphp</div>
</div>
<div class="row">
    <div class="col-lg-3">JUMLAH BANTUAN</div>
    <div class="col-lg-9">: @php echo str_replace('"','',json_encode($sheetData[9]['C'])) @endphp</div>
</div>
<div class="row">
    <div class="col-lg-3">TAHUN BANTUAN</div>
    <div class="col-lg-9">: @php echo str_replace('"','',json_encode($sheetData[10]['C'])) @endphp</div>
</div>
<div class="row">
    <div class="col-lg-3">NAMA PENYULUH</div>
    <div class="col-lg-9">: @php echo str_replace('"','',json_encode($sheetData[11]['C'])) @endphp</div>
</div>
<div class="row">
    <div class="col-lg-3">NO. HP PENYULUH</div>
    <div class="col-lg-9">: @php echo str_replace('"','',json_encode($sheetData[12]['C'])) @endphp</div>
</div>
<div class="row">
    <div class="col-lg-3">PENANGGUNG JAWAB</div>
    <div class="col-lg-9">: @php echo str_replace('"','',json_encode($sheetData[13]['C'])) @endphp</div>
</div>
<div class="row">
    <div class="col-lg-3">NO. HP PENANGGUNG JAWAB</div>
    <div class="col-lg-9">: @php echo str_replace('"','',json_encode($sheetData[14]['C'])) @endphp</div>
</div>
<div class="row">
    <div class="col-lg-3">KEMENTRIAN</div>
    <div class="col-lg-9">: @php echo str_replace('"','',json_encode($sheetData[15]['C'])) @endphp</div>
</div>
<table class="table table-bordered table-striped nowrap table-sm" id="tablePreview" style="width: 100%;">
    <thead>
        <tr class="bg-primary">
            @foreach(array_values($sheetData[16]) as $sd)
            <th>{{ $sd }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach(array_slice($sheetData,16) as $sd)
        <tr>
            @foreach($sd as $key => $val)
            <td>{{ $val }}</td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>

<script type="text/javascript">
    var tablePrev = $('#tablePreview').DataTable({
        scrollX: true,
        scrollY: '400px',
        scrollCollapse: true,
    });
</script>