
<!-- <div style="overflow-x:auto; max-height: 300px; overflow-y:auto;"> -->
    <!-- <div class="table-container"> -->
    <table class="table table-bordered nowrap table-sm" id="tableReport">
        <thead>
            <tr class="bg-primary">
                <th rowspan="2" class="text-middle" style="vertical-align: middle;" nowrap>POSISI PROGRAM</th>
                <th rowspan="2" style="vertical-align: middle;" nowrap>NAMA PROGRAM</th>
                <th rowspan="2" style="vertical-align: middle;" nowrap>PIC</th>
                <th rowspan="2" style="vertical-align: middle;" nowrap>KONTAK</th>
                <th rowspan="2" style="vertical-align: middle;" nowrap>KUOTA</th>
                <th colspan="{{ $jml_col }}" class="text-center">ALOKASI KABUPATEN/KOTA</th>
                <th colspan="5" class="text-center">STATUS</th>
            </tr>
            <tr class="bg-primary">
                @foreach($list_kota as $lk)
                <th nowrap>{{ strtoupper(str_replace(["Kabupaten ","KABUPATEN "],"", $lk->nama_kota)) }}</th>
                @endforeach
                <th>CPCL</th>
                <th>VERIFIKASI</th>
                <th>KONTRAK</th>
                <th>PENGIRIMAN</th>
                <th>DISTRIBUSI</th>
            </tr>
        </thead>
        <tbody>
            @foreach($result as $rs)
            <tr>
                <td nowrap>{{ $rs->nama_dirjen }}</td>
                <td nowrap>{{ $rs->nama_program }}</td>
                <td nowrap>{{ $rs->pic }}</td>
                <td nowrap>{{ $rs->contact_person }}</td>
                <td nowrap>{{ $rs->kuota }}</td>
                @foreach($list_kota as $lk)
                @php $var = str_replace(" ","_",strtoupper(str_replace(["Kabupaten ","KABUPATEN "],"", $lk->nama_kota))) @endphp
                <td>{{ $rs->$var }}</td>
                @endforeach
                <td nowrap>{{ $rs->cpcl_status }}</td>
                <td nowrap>{{ $rs->verifikasi_status }}</td>
                <td nowrap>{{ $rs->kontrak_status }}</td>
                <td nowrap>{{ $rs->pengiriman_status }}</td>
                <td nowrap>{{ $rs->distribusi_status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <script type="text/javascript">
    var tablePrev = $('#tableReport').DataTable({
        scrollX: true,
        scrollY: '400px',
        scrollCollapse: true,
        paging: false,
        ordering: false
    });
</script>
<!-- </div> -->