@extends('layouts.app')
@push('styles')
    <link href="{{ asset('assets/vendors/simple-datatables/style.css') }}" rel="stylesheet">
@endpush
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Bike Connector</h3>
                    <p class="text-subtitle text-muted">Lista bici elettriche assegnate agli utenti</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route("dashboard") }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Bike Connector</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <div class="col-sm-12 d-flex justify-content-end">
                        <a href="{{route("ebikesconnector.create")}}"><button type="button" class="btn btn-primary"><i class="fas fa-plus"></i> Collega una bici</button></a>
                    </div>
                    <table class="table table-striped" id="sparePartsTable">
                        <thead>
                        <tr>
                            <th>Bici</th>
                            <th>Utente</th>
                            <th>Nome Bici</th>
                            <th>Azioni</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($ebikesUser as $ebikeUser)
                            <tr>
                                <td><a href="{{route("ebikes.show",$ebikeUser->e_bike)}}">{{$ebikeUser->e_bike->name}}</a></td>
                                <td><a href="{{route("users.show",$ebikeUser->user)}}">{{$ebikeUser->user->profile->name}} {{$ebikeUser->user->profile->name}}</a></td>
                                <td>{{$ebikeUser->name}}</td>
                                <td>
                                    <form action="{{route("ebikesconnector.destroy",$ebikeUser)}}" method="POST">
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
