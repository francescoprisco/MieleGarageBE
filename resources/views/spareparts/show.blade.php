@extends("layouts.app")
@section("content")
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Parte di ricambio "{{$spare_part->name}}"</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Parte di ricambio "{{$spare_part->name}}"</li>
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
                                    <p>{{$spare_part->name}}</p>
                                </div>
                                <div class="col-md-6 col-12">
                                    <h6>Foto</h6>
                                    <img src="{{$spare_part->getFirstMediaUrl('spare_parts_photo', 'thumb')}}"  width="120px">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <h6>Codice</h6>
                                    <p>{{$spare_part->code}}</p>
                                </div>
                                <div class="col-md-6 col-12">
                                    <h6>Quantità</h6>
                                    <p>{{$spare_part->qty}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <h6>Prezzo</h6>
                                    <p>{{$spare_part->price}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <h6>Descrizione</h6>
                                    <p>{{$spare_part->description}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
@endsection
