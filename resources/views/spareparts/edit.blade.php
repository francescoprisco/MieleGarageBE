@extends("layouts.app")
@push("styles")
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
@endpush
@push("scripts")
    <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
    <script>
        $(document).ready(function(){
            var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
                removeItemButton: true,
                searchResultLimit:5,
                renderChoiceLimit:5
            });
        });
    </script>
@endpush
@section("content")
    @php
    @endphp
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Modifica componente di ricambio "{{$spare_part->name}}"</h3>
                    <p class="text-subtitle text-muted">Modifica un componente</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Modifica componente di ricambio</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- // Basic multiple Column Form section start -->
        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" action="{{route("spareparts.update",$spare_part)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    {{ method_field('PATCH') }}
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="slug">Codice ricambio</label>
                                                <input type="text" id="code" class="form-control" placeholder="Codice ricambio" name="code" value="{{$spare_part->code}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="name">Nome ricambio</label>
                                                <input type="text" id="name" class="form-control" placeholder="Nome ricambio" value="{{$spare_part->name}}" name="name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="wheels_size">Quantit?? in magazzino</label>
                                                <input type="number" id="qty" class="form-control" placeholder="Quantit?? in magazzino" value="{{$spare_part->qty}}" name="qty" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="price">Prezzo</label>
                                                <input type="number" id="price" class="form-control" name="price" value="{{$spare_part->price}}" placeholder="Prezzo" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mb-3">
                                                <label for="formFile" class="form-label">Foto</label>
                                                <input class="form-control" type="file" name="photo" id="formFile">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mb-3">
                                                <label for="formFile" class="form-label">Bici elettriche</label>
                                                <select id="choices-multiple-remove-button" name="e_bikes[]" placeholder="Seleziona le bici a cui il ricambio ?? associato" multiple>
                                                    @foreach($e_bikes as $e_bike)
                                                        @if(isset($spare_part->e_bikes->pluck('id','name')[$e_bike->name]))
                                                            <option value="{{$e_bike->id}}" selected>{{$e_bike->name}}</option>
                                                        @else
                                                            <option value="{{$e_bike->id}}" >{{$e_bike->name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mb-3">
                                                <label for="exampleFormControlTextarea1" class="form-label">Descrizione</label>
                                                <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3" placeholder="Descrizione" required>{{$spare_part->description}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Invia</button>
                                            <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- // Basic multiple Column Form section end -->
@endsection
