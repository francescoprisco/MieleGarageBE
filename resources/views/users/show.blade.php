@extends("layouts.app")
@push('styles')
    <link href="{{ asset('assets/vendors/simple-datatables/style.css') }}" rel="stylesheet">
@endpush
@push('scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
    <script>
        // Simple Datatable
        let sparePartsTable = document.querySelector('#sparePartsTable');
        let dataTable = new simpleDatatables.DataTable(sparePartsTable);
    </script>
@endpush
@section("content")
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Utente "{{$user->profile->name}} {{$user->profile->surname}}"</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Utente "{{$user->profile->name}} {{$user->profile->surname}}"</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <h6>Nome</h6>
                                    <p>{{$user->profile->name}}</p>
                                </div>
                                <div class="col-md-6 col-12">
                                    <h6>Cognome</h6>
                                    <p>{{$user->profile->surname}}</p>
                                </div>
                                <div class="col-md-6 col-12">
                                    <h6>Foto</h6>
                                    <img src="{{$user->profile->getFirstMediaUrl('users_avatar', 'thumb')}}"  width="120px">
                                </div>
                                <div class="col-md-6 col-12">
                                    <h6>Indirizzo</h6>
                                    <p>{{$user->profile->address}}, </br>{{$user->profile->city->name}}, {{$user->profile->provincia->name}} ({{$user->profile->provincia->codice}})</p>
                                </div>
                                <div class="col-md-6 col-12">
                                    <h6>Registrato il</h6>
                                    <p>{{$user->created_at}}</p>
                                </div>
                                <div class="page-heading">
                                    <div class="page-title">
                                        <div class="row">
                                            <div class="col-12 col-md-6 order-md-1 order-last">
                                                <h3>Bici Elettriche</h3>
                                                <p class="text-subtitle text-muted">Lista bici elettriche</p>
                                            </div>
                                        </div>
                                    </div>
                                    <section class="section">
                                        <div class="card">
                                            <div class="card-body">
                                                <table class="table table-striped" id="sparePartsTable">
                                                    <thead>
                                                    <tr>
                                                        <th>Immagine</th>
                                                        <th>Codice</th>
                                                        <th>Nome</th>
                                                        <th>Descrizione</th>
                                                        <th>Potenza</th>
                                                        <th>Batteria</th>
                                                        <th>Azioni</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($user->e_bikes as $ebike)
                                                        <tr>
                                                            <td><img src="{{$ebike->getFirstMediaUrl('bikes_photo', 'thumb')}}"  width="120px"></td>
                                                            <td>{{$ebike->slug}}</td>
                                                            <td>{{$ebike->name}}</td>
                                                            <td>{{$ebike->description}}</td>
                                                            <td>{{$ebike->power}}</td>
                                                            <td>{{$ebike->battery}}</td>
                                                            <td>
                                                                <form action="{{route("ebikes.destroy",$ebike)}}" method="POST">
                                                                    <a href="{{route("ebikes.show",$ebike)}}"><button type="button" class="btn btn-primary"><i class="fas fa-eye"></i></button></a>
                                                                    <a href="{{route("ebikes.edit",$ebike)}}"><button type="button" class="btn btn-warning"><i class="fas fa-edit"></i></button></a>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
