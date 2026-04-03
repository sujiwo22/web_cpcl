<style>
    .table-container {
        max-height: 600px;
        /* Set a fixed height to enable scrolling */
        overflow-y: auto;
        /* Add vertical scrollbar when content overflows */
        width: 100%;
        border: 1px solid #ccc;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        /* Collapse borders for a cleaner look */
    }

    th,
    td {
        padding: 10px;
        text-align: left;
        border: 1px solid #ddd;
        background-color: #f9f9f9;
        /* Add background color to prevent text overlap */
    }

    thead th {
        position: sticky;
        /* Make headers sticky */
        z-index: 10;
        /* Ensure headers appear above body content */
    }

    /* Define the top position for each header row */
    thead tr:first-child th {
        top: 0;
        /* The first row sticks to the top of the container */
    }

    thead tr:nth-child(2) th {
        /* The second row sticks below the first row. Adjust '42px' based on the actual height of the first row. */
        top: 35px;
    }

    /* Repeat for additional header rows if necessary */

    tbody {
        /* You do not need "display: block" on tbody with this method,
       which helps preserve default table layout and column alignment. */
    }
</style>
<!-- <div style="overflow-x:auto; max-height: 500px; overflow-y:auto;"> -->
<div class="table-container">
    <table class="table table-bordered table-striped table-sm" id="tableReport">
        <thead>
            <tr>
                <th rowspan="2" class="text-middle" style="vertical-align: middle;background-color: #007bff; color:#FFFFFF;" nowrap>POSISI PROGRAM</th>
                <th rowspan="2" style="vertical-align: middle; background-color: #007bff; color:#FFFFFF;" nowrap>NAMA PROGRAM</th>
                <th rowspan="2" style="vertical-align: middle; background-color: #007bff; color:#FFFFFF;" nowrap>PIC</th>
                <th rowspan="2" style="vertical-align: middle; background-color: #007bff; color:#FFFFFF;" nowrap>KONTAK</th>
                <th rowspan="2" style="vertical-align: middle; background-color: #007bff; color:#FFFFFF;" nowrap>KUOTA</th>
                <th colspan="{{ $jml_col }}" class="text-center" style=" background-color: #007bff; color:#FFFFFF;">ALOKASI KABUPATEN/KOTA</th>
                <th colspan="5" class="text-center" style=" background-color: #007bff; color:#FFFFFF;">STATUS</th>
            </tr>
            <tr class="bg-primary">
                @foreach($list_kota as $lk)
                <th nowrap style=" background-color: #007bff; color:#FFFFFF;">{{ strtoupper(str_replace(["Kabupaten ","KABUPATEN "],"", $lk->nama_kota)) }}</th>
                @endforeach
                <th style=" background-color: #007bff; color:#FFFFFF;">CPCL</th>
                <th style=" background-color: #007bff; color:#FFFFFF;">VERIFIKASI</th>
                <th style=" background-color: #007bff; color:#FFFFFF;">KONTRAK</th>
                <th style=" background-color: #007bff; color:#FFFFFF;">PENGIRIMAN</th>
                <th style=" background-color: #007bff; color:#FFFFFF;">DISTRIBUSI</th>
            </tr>
        </thead>
        <tbody>
            @foreach($list_kementrian as $lkmen)
            @php $col_span=$jml_col+10 @endphp
            <tr>
                <td colspan="{{ $col_span }}" style="background-color: #cccccc;"><b>{{ $lkmen->nama_kementrian }}</b></td>
            </tr>
            @php
            $dirjen_name=[];
            $dirjen_name_show='';
            $x=0;
            $y=1;
            @endphp

            @php $rowData=1 @endphp
            @foreach($result[$lkmen->id] as $rs)
            @php
            $rowSpan = $result_row[$lkmen->id][$rs['nama_dirjen']];
            $dirjen_name[$x]=$rs['nama_dirjen'];
            $dirjen_name_show = $x>0 && $dirjen_name[$x]==$dirjen_name[$x-1]?'':$dirjen_name[$x];
            $mod=$rowData%2;
            $bg_data = $mod==0?'#FFFFFF':'#e9e9e9';
            @endphp
            <tr>
                @if($y==1)
                <td style="width: 500px; vertical-align:middle; background-color: {{ $bg_data }};" rowspan="{{ $rowSpan }}" nowrap>{{ $dirjen_name_show }}</td>
                @endif
                <td style="width: 40%; background-color: {{ $bg_data }};" nowrap>{{ $rs['nama_program'] }}</td>
                <td nowrap style=" background-color: {{ $bg_data }};">{{ $rs['pic'] }}</td>
                <td nowrap style=" background-color: {{ $bg_data }};">{{ $rs['contact_person'] }}</td>
                <td nowrap style=" background-color: {{ $bg_data }}; text-align:right;">{{ $rs['kuota'] }}</td>
                @foreach($list_kota as $lk)
                @php $var = str_replace(" ","_",strtoupper(str_replace(["Kabupaten ","KABUPATEN "],"", $lk['nama_kota']))) @endphp
                <td style=" background-color: {{ $bg_data }}; text-align:right;">{{ $rs[$var] }}</td>
                @endforeach
                @php
                $tahun=$rs['tahun'];
                $id_program=$rs['id_program'];
                $id=$rs['id'];
                $tl_cpcl=tl_status($rs['cpcl_status']);
                $tl_verifikasi=tl_status($rs['verifikasi_status']);
                $tl_kontrak=tl_status($rs['kontrak_status']);
                $tl_pengiriman=tl_status($rs['pengiriman_status']);
                $tl_distribusi=tl_status($rs['distribusi_status']);

                $status_cpcl=$rs['cpcl_status'];
                $status_verifikasi=$rs['verifikasi_status'];
                $status_kontrak=$rs['kontrak_status'];
                $status_pengiriman=$rs['pengiriman_status'];
                $status_distribusi=$rs['distribusi_status'];
                @endphp
                <td nowrap style=" background-color: {{ $bg_data }};"><span onclick="updateStatus('cpcl','{{ $id }}','{{ $status_cpcl }}')" class="{{ $tl_cpcl }}" style="cursor: pointer;" id="cpcl{{$id}}"> {{ $rs['cpcl_status'] }}</span></td>
                <td nowrap style=" background-color: {{ $bg_data }};"><span onclick="updateStatus('verifikasi','{{ $id }}','{{ $status_verifikasi }}')" class="{{ $tl_verifikasi }}" style="cursor: pointer;" id="verifikasi{{$id}}"> {{ $rs['verifikasi_status'] }}</span></td>
                <td nowrap style=" background-color: {{ $bg_data }};"><span onclick="updateStatus('kontrak','{{ $id }}','{{ $status_kontrak }}')" class="{{ $tl_kontrak }}" style="cursor: pointer;" id="kontrak{{$id}}"> {{ $rs['kontrak_status'] }}</span></td>
                <td nowrap style=" background-color: {{ $bg_data }};"><span onclick="updateStatus('pengiriman','{{ $id }}','{{ $status_pengiriman }}')" class="{{ $tl_pengiriman }}" style="cursor: pointer;" id="pengiriman{{$id}}"> {{ $rs['pengiriman_status'] }}</span></td>
                <td nowrap style=" background-color: {{ $bg_data }};"><span onclick="updateStatus('distribusi','{{ $id }}','{{ $status_distribusi }}')" class="{{ $tl_distribusi }}" style="cursor: pointer;" id="distribusi{{$id}}"> {{ $rs['distribusi_status'] }}</span></td>
            </tr>
            @php
            $x++;
            $rowData++;
            $y=$y==$rowSpan?1:$y+1;
            @endphp
            @endforeach
            @endforeach
        </tbody>
    </table>
    <script type="text/javascript">
        // var tablePrev = $('#tableReport').DataTable({
        //     scrollX: true,
        //     scrollY: '400px',
        //     scrollCollapse: true,
        //     paging: false,
        //     ordering: false
        // });
    </script>
</div>