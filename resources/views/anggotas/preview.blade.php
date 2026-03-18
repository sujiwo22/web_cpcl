<!-- <h4>Preview Data</h4> -->
<table class="table table-bordered table-striped nowrap table-sm" id="tablePreview" style="width: 100%;">
    <thead>
        <tr class="bg-primary">
            @foreach(array_values($sheetData[1]) as $sd)
            <th>{{ $sd }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach(array_slice($sheetData,1) as $sd)
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