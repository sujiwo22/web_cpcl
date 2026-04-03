<table class="table table-bordered table-sm">
    <thead>
        <tr class="bg-primary">
            @if($type=='setting')
            <th style="width: 80px;">Act.</th>
            <th style="width: 80px;">Order</th>
            @endif
            <th>Rincian Kegiatan</th>
            <th class="text-center">Jan</th>
            <th class="text-center">Feb</th>
            <th class="text-center">Mar</th>
            <th class="text-center">Apr</th>
            <th class="text-center">Mei</th>
            <th class="text-center">Jun</th>
            <th class="text-center">Jul</th>
            <th class="text-center">Agt</th>
            <th class="text-center">Sep</th>
            <th class="text-center">Okt</th>
            <th class="text-center">Nov</th>
            <th class="text-center">Des</th>
        </tr>
    </thead>
    <tbody>
        @foreach($result as $rs)
        @php
        $bulan_skrg=date('m');
        $bg_1='';
        $bg_2='';
        $bg_3='';
        $bg_4='';
        $bg_5='';
        $bg_6='';
        $bg_7='';
        $bg_8='';
        $bg_9='';
        $bg_10='';
        $bg_11='';
        $bg_12='';

        $bg_1=$rs['bulan_start']==1 && $rs['bulan_end']>=1?'bg-primary':$bg_1;
        $bg_2=$rs['bulan_start']<=2 && $rs['bulan_end']>=2?'bg-primary':$bg_2;
            $bg_2=$rs['tambahan_bulan']!=null && $rs['bulan_add']!=null && in_array(2,$rs['bulan_add'])?'bg-warning':$bg_2;
            $bg_3=$rs['bulan_start']<=3 && $rs['bulan_end']>=3?'bg-primary':$bg_3;
                $bg_3=$rs['tambahan_bulan']!=null && $rs['bulan_add']!=null && in_array(3,$rs['bulan_add'])?'bg-warning':$bg_3;
                $bg_4=$rs['bulan_start']<=4 && $rs['bulan_end']>=4?'bg-primary':$bg_4;
                    $bg_4=$rs['tambahan_bulan']!=null && $rs['bulan_add']!=null && in_array(4,$rs['bulan_add'])?'bg-warning':$bg_4;
                    $bg_5=$rs['bulan_start']<=5 && $rs['bulan_end']>=5?'bg-primary':$bg_5;
                        $bg_5=$rs['tambahan_bulan']!=null && $rs['bulan_add']!=null && in_array(5,$rs['bulan_add'])?'bg-warning':$bg_5;
                        $bg_6=$rs['bulan_start']<=6 && $rs['bulan_end']>=6?'bg-primary':$bg_6;
                            $bg_6=$rs['tambahan_bulan']!=null && $rs['bulan_add']!=null && in_array(6,$rs['bulan_add'])?'bg-warning':$bg_6;
                            $bg_7=$rs['bulan_start']<=7 && $rs['bulan_end']>=7?'bg-primary':$bg_7;
                                $bg_7=$rs['tambahan_bulan']!=null && $rs['bulan_add']!=null && in_array(7,$rs['bulan_add'])?'bg-warning':$bg_7;
                                $bg_8=$rs['bulan_start']<=8 && $rs['bulan_end']>=8?'bg-primary':$bg_8;
                                    $bg_8=$rs['tambahan_bulan']!=null && $rs['bulan_add']!=null && in_array(8,$rs['bulan_add'])?'bg-warning':$bg_8;
                                    $bg_9=$rs['bulan_start']<=9 && $rs['bulan_end']>=9?'bg-primary':$bg_9;
                                        $bg_9=$rs['tambahan_bulan']!=null && $rs['bulan_add']!=null && in_array(9,$rs['bulan_add'])?'bg-warning':$bg_9;
                                        $bg_10=$rs['bulan_start']<=10 && $rs['bulan_end']>=10?'bg-primary':$bg_10;
                                            $bg_10=$rs['tambahan_bulan']!=null && $rs['bulan_add']!=null && in_array(10,$rs['bulan_add'])?'bg-warning':$bg_10;
                                            $bg_11=$rs['bulan_start']<=11 && $rs['bulan_end']>=11?'bg-primary':$bg_11;
                                                $bg_11=$rs['tambahan_bulan']!=null && $rs['bulan_add']!=null && in_array(11,$rs['bulan_add'])?'bg-warning':$bg_11;
                                                $bg_12=$rs['bulan_start']<=12 && $rs['bulan_end']>=12?'bg-primary':$bg_12;
                                                    $bg_12=$rs['tambahan_bulan']!=null && $rs['bulan_add']!=null && in_array(12,$rs['bulan_add'])?'bg-warning':$bg_12;

                                                    @endphp
                                                    <tr>
                                                        @if($type=='setting')
                                                        <td>
                                                            <div class="btn-group">
                                                                <div class="btn btn-success btn-sm" onclick="editData({{ $rs['id'] }})"><i class="fa fa-edit"></i></div>
                                                                <div class="btn btn-danger btn-sm" onclick="deleteData({{ $rs['id'] }})"><i class="fa fa-times-circle"></i></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <div class="btn btn-info btn-sm" onclick="ubahUrutan('up',{{ $rs['id'] }})"><i class="fa fa-chevron-circle-up"></i></div>
                                                                <div class="btn btn-info btn-sm" onclick="ubahUrutan('down',{{ $rs['id'] }})"><i class="fa fa-chevron-circle-down"></i></div>
                                                            </div>
                                                        </td>
                                                        @endif
                                                        <td nowrap>{{ $rs['nama_kegiatan'] }}</td>
                                                        <td class="{{ $bg_1 }}"></td>
                                                        <td class="{{ $bg_2 }}"></td>
                                                        <td class="{{ $bg_3 }}"></td>
                                                        <td class="{{ $bg_4 }}"></td>
                                                        <td class="{{ $bg_5 }}"></td>
                                                        <td class="{{ $bg_6 }}"></td>
                                                        <td class="{{ $bg_7 }}"></td>
                                                        <td class="{{ $bg_8 }}"></td>
                                                        <td class="{{ $bg_9 }}"></td>
                                                        <td class="{{ $bg_10 }}"></td>
                                                        <td class="{{ $bg_11 }}"></td>
                                                        <td class="{{ $bg_12 }}"></td>
                                                    </tr>
                                                    @endforeach
    </tbody>
</table>

<table class="table table-sm" style="width: 30%; border:0px">
    <tr>
        <td class="bg-primary" style="width: 30%;"></td>
        <td>Timeline Normal</td>
    </tr>
    <tr>
        <td class="bg-warning"></td>
        <td>Timeline Tambahan</td>
    </tr>
</table>