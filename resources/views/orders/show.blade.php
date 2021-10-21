aaaaaa
@extends('layouts.app')
@push('styles')
    <link href="{{ asset('assets/vendors/simple-datatables/style.css') }}" rel="stylesheet">
@endpush
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Ordine "{{$order->code}}"</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route("dashboard") }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route("orders.index") }}">Ordini</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Ordine {{$order->code}}</li>
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
                                    <h6>Codice</h6>
                                    <p>{{$order->code}}</p>
                                </div>
                                <div class="col-md-6 col-12">
                                    <h6>Metodo di Pagamento</h6>
                                    <p>{{$order->paymentOption->name}} {{$order->payment}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <h6>Stato Ordine</h6>
                                    <p>@if($order->status == "pending") In Attesa @elseif($order->status == "preparing") In Preparazione @elseif($order->status == "enroute") Spedito @elseif($order->status == "delivered") Consegnato @elseif($order->status == "failed") Fallito @elseif($order->status == "cancelled") Cancellato @else {{$order->status}} @endif @if(!is_null($order->tracking_code)) Codice di tracciamento <a href="https://t.17track.net/it#nums={{$order->tracking_code}}" target="_blank"><strong>{{$order->tracking_code}}</strong></a>@endif</p>
                                    <form action="{{route("orders.update",$order)}}" method="POST">
                                        {{ method_field('PATCH') }}
                                        @csrf
                                        <select class="form-select" id="basicSelect" name="status">
                                            <option value="pending">In Attesa</option>
                                            <option value="preparing">In Preparazione</option>
                                            <option value="enroute">Spedito</option>
                                            <option value="delivered">Consegnato</option>
                                            <option value="failed">Fallito</option>
                                            <option value="cancelled">Cancellato</option>
                                        </select>
                                    </br>
                                        @if($order->status == "preparing")
                                            <input type="text" id="name" class="form-control" placeholder="Codice tracciamento" name="tracking_code" required>
                                            </br>
                                        @endif
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Cambia Stato</button>
                                    </form>
                                </div>
                                <div class="col-md-6 col-12">
                                    <h6>Stato Pagamento</h6>
                                    <p>@if($order->payment_status == "pending") In Attesa @elseif($order->payment_status == "failed") Fallito @elseif($order->payment_status == "successful") Completato @else {{$order->payment_status}} @endif</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <h6>Cliente</h6>
                                    <p>{{$order->user->profile->name}} {{$order->user->profile->surname}}</p>
                                </div>
                                <div class="col-md-6 col-12">
                                    <h6>Effettuato il </h6>
                                    <p>{{$order->created_at}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped" id="ordersTable">
                        <thead>
                        <tr>
                            <th>Immagine</th>
                            <th>Codice</th>
                            <th>Nome</th>
                            <th>Descrizione</th>
                            <th>Quantità</th>
                            <th>Prezzo</th>
                            <th>Modello E-Bike</th>
                            <th>Quantità</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->spare_parts as $orderSparePart)
                            @php
                            $spare_part = $orderSparePart->spare_part;
                            @endphp
                            <tr>
                                <td><img src="{{$spare_part->getFirstMediaUrl('spare_parts_photo', 'thumb')}}"  width="120px"></td>
                                <td>{{$spare_part->code}}</td>
                                <td>{{$spare_part->name}}</td>
                                <td>{{$spare_part->description}}</td>
                                <td>{{$spare_part->qty}}
                                <td>{{$spare_part->price}} €</td>
                                <td>@foreach($spare_part->e_bikes as $e_bike)<a href="{{route("ebikes.show",$e_bike)}}">{{$e_bike->name}}</a> @endforeach</td>
                                <td>{{$orderSparePart->quantity}}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><strong>Subtotale {{$order->sub_total_amount}} €</strong></td>
                            <td><strong>Costo di Spedizione {{$order->delivery_fee}} €</strong></td>
                            <td><strong>Totale {{$order->total_amount}} € </strong></td>
                        </tr>
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
        let ordersTable = document.querySelector('#ordersTable');
        let dataTable = new simpleDatatables.DataTable(ordersTable);
    </script>
@endpush
