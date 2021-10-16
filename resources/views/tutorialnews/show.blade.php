@extends("layouts.app")
@section("content")
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Bici modello {{$ebike->name}}</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Bici modello {{$ebike->name}}</li>
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
                                    <p>{{$ebike->name}}</p>
                                </div>
                                <div class="col-md-6 col-12">
                                    <h6>Foto</h6>
                                    <img src="{{$ebike->getFirstMediaUrl('bikes_photo', 'thumb')}}"  width="120px">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <h6>Codice (COD Wordpress)</h6>
                                    <p>{{$ebike->slug}}</p>
                                </div>
                                <div class="col-md-6 col-12">
                                    <h6>Grandezza Ruote</h6>
                                    <p>{{$ebike->wheel_size}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <h6>Potenza</h6>
                                    <p>{{$ebike->power}}</p>
                                </div>
                                <div class="col-md-6 col-12">
                                    <h6>Batteria</h6>
                                    <p>{{$ebike->battery}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <h6>Descrizione</h6>
                                    <p>{{$ebike->description}}</p>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
