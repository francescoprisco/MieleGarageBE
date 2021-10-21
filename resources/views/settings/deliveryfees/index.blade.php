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
                    <h3>Costi di spedizione</h3>
                    <p class="text-subtitle text-muted">Definisci dei costi di spedizione per ogni fascia di peso totale dell'ordine</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route("dashboard") }}">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Impostazioni</li>
                            <li class="breadcrumb-item active" aria-current="page">Costi di Spedizione</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <div class="col-sm-12 d-flex justify-content-end">
                        <a href="{{route("deliveryfees.create")}}"><button type="button" class="btn btn-primary"><i class="fas fa-plus"></i> Aggiugi un costo di spedizione</button></a>
                    </div>
                    <table class="table table-striped" id="ordersTable">
                        <thead>
                        <tr>
                            <th>Peso Limite (Fino a)</th>
                            <th>Costo Spedizione</th>
                            <th>Azioni</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($deliveryFees as $deliveryFee)
                            <tr>
                                <td>{{$deliveryFee->min_weight}} KG</td>
                                <td>{{$deliveryFee->delivery_fee}} €</td>
                                <td>
                                    <form action="{{route("deliveryfees.destroy",$deliveryFee)}}" method="POST">
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
        let ordersTable = document.querySelector('#ordersTable');
        let dataTable = new simpleDatatables.DataTable(ordersTable);
    </script>
@endpush
