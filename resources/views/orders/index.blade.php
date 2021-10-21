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
                    <h3>Ordini</h3>
                    <p class="text-subtitle text-muted">Lista ordini</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route("dashboard") }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Ordini</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped" id="ordersTable">
                        <thead>
                        <tr>
                            <th>Codice</th>
                            <th>Prezzo Totale</th>
                            <th>Prezzo Parziale</th>
                            <th>Prezzo Spedizione</th>
                            <th>Metodo di pagamento</th>
                            <th>Stato</th>
                            <th>Stato pagamento</th>
                            <th>Cliente</th>
                            <th>Data</th>
                            <th>Azioni</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{$order->code}}</td>
                                <td>{{$order->total_amount}} €</td>
                                <td>{{$order->sub_total_amount}} €</td>
                                <td>{{$order->delivery_fee}} €</td>
                                <td>{{$order->paymentOption->name}}</td>
                                <td>@if($order->status == "pending") In Attesa @elseif($order->status == "preparing") In Preparazione @elseif($order->status == "enroute") Spedito @elseif($order->status == "delivered") Consegnato @elseif($order->status == "failed") Fallito @elseif($order->status == "cancelled") Cancellato @else {{$order->status}} @endif @if(!is_null($order->tracking_code)) Codice di tracciamento <a href="https://t.17track.net/it#nums={{$order->tracking_code}}" target="_blank"><strong>{{$order->tracking_code}}</strong></a>@endif</td>
                                <td>@if($order->payment_status == "pending") In Attesa @elseif($order->payment_status == "failed") Fallito @elseif($order->payment_status == "successful") Completato @else {{$order->payment_status}} @endif</td>
                                <td>{{$order->user->profile->name}} {{$order->user->profile->surname}}</td>
                                <td>{{$order->created_at}}</td>
                                <td>
                                        <a href="{{route("orders.show",$order)}}"><button type="button" class="btn btn-primary"><i class="fas fa-eye"></i></button></a>
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
        let ordersTable = document.querySelector('#ordersTable');
        let dataTable = new simpleDatatables.DataTable(ordersTable);
    </script>
@endpush
