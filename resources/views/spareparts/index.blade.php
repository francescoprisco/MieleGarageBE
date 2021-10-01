@extends('layouts.app')
@push('styles')
    <link href="{{ asset('assets/vendors/simple-datatables/style.css') }}" rel="stylesheet">
@endpush
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Parti di Ricambio</h3>
                    <p class="text-subtitle text-muted">Lista dei componenti di ricambio</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route("dashboard") }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Parti di ricambio</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <div class="col-sm-12 d-flex justify-content-end">
                        <a href="{{route("spareparts.create")}}"><button type="button" class="btn btn-primary"><i class="fas fa-plus"></i> Aggiugi una parte di ricambio</button></a>
                    </div>
                    <table class="table table-striped" id="sparePartsTable">
                        <thead>
                        <tr>
                            <th>Immagine</th>
                            <th>Codice</th>
                            <th>Nome</th>
                            <th>Descrizione</th>
                            <th>Quantità</th>
                            <th>Prezzo</th>
                            <th>Modello E-Bike</th>
                            <th>Azioni</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($spare_parts as $spare_part)
                        <tr>
                            <td><img src="{{$spare_part->getFirstMediaUrl('spare_parts_photo', 'thumb')}}"  width="120px"></td>
                            <td>{{$spare_part->code}}</td>
                            <td>{{$spare_part->name}}</td>
                            <td>{{$spare_part->description}}</td>
                            <td>{{$spare_part->qty}}
                            <td>{{$spare_part->price}} €</td>
                            <td>@foreach($spare_part->e_bikes as $e_bike){{$e_bike->name}} @endforeach</td>
                            <td>
                                <form action="{{route("spareparts.destroy",$spare_part)}}" method="POST">
                                    <a href="{{route("spareparts.show",$spare_part)}}"><button type="button" class="btn btn-primary"><i class="fas fa-eye"></i></button></a>
                                    <a href="{{route("spareparts.edit",$spare_part)}}"><button type="button" class="btn btn-warning"><i class="fas fa-edit"></i></button></a>
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </section>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
    <script>
        // Simple Datatable
        let sparePartsTable = document.querySelector('#sparePartsTable');
        let dataTable = new simpleDatatables.DataTable(sparePartsTable);
    </script>
@endpush
