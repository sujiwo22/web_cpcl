@extends('layouts.app')

@section('content')

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Maps') }}</h3>
                    <div class="card-tools">
                        <ul class="nav nav-pills ml-auto">
                            <li class="nav-item">
                                <a class="nav-link active" href="#" onclick="addForm()"><i
                                        class="fa fa-plus-circle"></i> Add Data</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card-body">
                    <div id="map" style="height: 400px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script type="module">
    document.addEventListener('DOMContentLoaded', () => {
        const map = L.map('map').setView([51.505, -0.09], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        L.marker([51.5, -0.09]).addTo(map)
            .bindPopup('A Leaflet marker in Laravel 12!')
            .openPopup();
    });
</script>
@endsection