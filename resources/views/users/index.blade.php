@extends('layouts.app')
@push('styles')
    <link href="{{ asset('assets/vendors/simple-datatables/style.css') }}" rel="stylesheet">
@endpush
@push('scripts')
    <script>
        $( document ).ready(function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
@endpush
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Lista Utenti</h3>
                    <p class="text-subtitle text-muted">Lista utenti</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route("dashboard") }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Lista utenti</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <div class="col-sm-12 d-flex justify-content-end">
                        <a href="{{route("users.create")}}"><button type="button" class="btn btn-primary"><i class="fas fa-plus"></i> Aggiugi un utente</button></a>
                    </div>
                    <table class="table table-striped" id="sparePartsTable">
                        <thead>
                        <tr>
                            <th>Immagine</th>
                            <th>E-Mail</th>
                            <th>Nome</th>
                            <th>Cognome</th>
                            <th>Indirizzo</th>
                            <th>Verificato</th>
                            <th>Creato Il</th>
                            <th>N° Bici Associate</th>
                            <th>Azioni</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td><div class="avatar avatar-xl"><img src="{{$user->profile->getFirstMediaUrl('users_avatar', 'thumb')}}" alt="Face 1"></div></td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->profile->name}}</td>
                                <td>{{$user->profile->surname}}</td>
                                <td>{{$user->profile->address}}, </br>{{$user->profile->city->name}}, {{$user->profile->provincia->name}} ({{$user->profile->provincia->codice}})</td>
                                <td>@if($user->email_verified_at==null)  <span class="badge bg-danger">Non verificato</span> @else<span class="badge bg-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Verificato il {{$user->email_verified_at}}">Verificato</span>@endif</td>
                                <td>{{$user->created_at}}</td>
                                <td>{{count($user->e_bikes()->get())}}</td>
                                <td>
                                <form action="{{route("users.destroy",$user)}}" method="POST">
                                    @csrf
                                    <a href="{{route("users.show",$user)}}"><button type="button" class="btn btn-primary"><i class="fas fa-eye"></i></button></a>
                                         <a href="{{route("users.edit",$user)}}"><button type="button" class="btn btn-warning"><i class="fas fa-edit"></i></button></a>
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
