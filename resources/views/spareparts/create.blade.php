@extends("layouts.app")
@push("styles")
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
@endpush
@push("scripts")
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
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
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Nuovo componente di ricambio</h3>
                    <p class="text-subtitle text-muted">Inserisci un nuovo componente</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Nuovo componente di ricambio</li>
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
                                <form class="form" action="{{route("spareparts.store")}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="slug">Codice ricambio</label>
                                                <input type="text" id="code" class="form-control" placeholder="Codice ricambio" name="code" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="name">Nome ricambio</label>
                                                <input type="text" id="name" class="form-control" placeholder="Nome ricambio" name="name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="wheels_size">Quantità in magazzino</label>
                                                <input type="number" id="qty" class="form-control" placeholder="Quantità in magazzino" name="qty" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="price">Prezzo</label>
                                                <input type="number" id="price" class="form-control" name="price" placeholder="Prezzo" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mb-3">
                                                <label for="formFile" class="form-label">Foto</label>
                                                <input class="form-control" type="file" name="photo" id="formFile" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mb-3">
                                                <label for="formFile" class="form-label">Bici elettriche</label>
                                                <select id="choices-multiple-remove-button" name="e_bikes[]" placeholder="Seleziona le bici a cui il ricambio è associato" multiple>
                                                    @foreach($e_bikes as $e_bike)
                                                        <option value="{{$e_bike->id}}">{{$e_bike->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mb-3">
                                                <label for="exampleFormControlTextarea1" class="form-label">Descrizione</label>
                                                <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3" placeholder="Descrizione" required></textarea>
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
