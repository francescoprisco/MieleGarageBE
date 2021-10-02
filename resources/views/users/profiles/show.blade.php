@extends("layouts.app")
@push("styles")
    <link rel="stylesheet" href="{{asset('assets/vendors/choices.js/choices.min.css')}}" />
@endpush
@push("scripts")
    <script src="{{asset('assets/vendors/choices.js/choices.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            const choices = new Choices('.js-choice', {
                addItems: true,
                removeItems: false,
            });
            choices.disable();
            $('#provincia').change(function(){
                choices.disable();
                choices.clearStore();
                var provincia_id =$(this).val();
                $.post("{{url('api/get_cities')}}", {provincia_id: provincia_id}, function(result){
                    var cities = [];
                    result["data"].forEach(function(city) {
                        cities.push({'value':city["id"],'label':city["name"]});
                    });
                    choices.setChoices(cities);
                    choices.enable();
                });
            });
        });
    </script>
@endpush
@section("content")
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Crea il tuo profilo</h3>
                    <p class="text-subtitle text-muted">Sembra che non ha un profilo! Creane subito uno</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Crea profilo</li>
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
                                <form class="form" action="{{route("profiles.store")}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="name">Nome</label>
                                                <input type="text" id="name" class="form-control" placeholder="Nome" name="name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="surname">Cognome</label>
                                                <input type="text" id="surname" class="form-control" placeholder="Cognome" name="surname" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="phone">Telefono</label>
                                                <input type="text" id="phone" class="form-control" placeholder="Telefono" name="phone" pattern="+[0-9]{2}[0-9]{3}[0-9]{7}" required>
                                                <h7>esempio +393396417822</h7>
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
                                                <label for="formFile" class="form-label">Provincia</label>
                                                <select class="choices form-select" id="provincia" name="provincia_id">
                                                    <option value="" disabled selected>Seleziona una provincia</option>
                                                    @foreach($province as $provincia)
                                                        <option value="{{$provincia->id}}">{{$provincia->name}} ({{$provincia->codice}})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mb-3">
                                                <label for="formFile" class="form-label">Città</label>
                                                <select class="choices js-choice form-select" id="cities" name="city_id">
                                                    <option value="" disabled selected>Seleziona una città</option>
                                                    @foreach($cities as $city)
                                                        <option value="{{$city->id}}">{{$city->name}})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="address">Indirizzo</label>
                                                <input type="text" id="address" class="form-control" placeholder="Indirizzo" name="address" required>
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
