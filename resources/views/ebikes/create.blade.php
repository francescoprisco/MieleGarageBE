@extends("layouts.app")
@section("content")
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Nuova bici elettrica</h3>
                    <p class="text-subtitle text-muted">Inserisci una nuova bici elettrica</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Nuova bici elettrica</li>
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
                            <form class="form" action="{{route("ebikes.store")}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="slug">Codice (Slug-Wordpress)</label>
                                            <input type="text" id="slug" class="form-control" placeholder="Codice (Slug-Wordpress)" name="slug" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="name">Nome Modello</label>
                                            <input type="text" id="name" class="form-control" placeholder="Nome Modello" name="name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="wheels_size">Grandezza Ruote</label>
                                            <input type="number" id="wheels_size" class="form-control" placeholder="Grandezza ruote" name="wheels_size" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="power">Potenza</label>
                                            <input type="number" id="power" class="form-control" name="power" placeholder="Potenza" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="battery">Batteria</label>
                                            <input type="number" id="battery" class="form-control" name="battery" placeholder="Batteria" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="battery">Peso</label>
                                            <input type="number" id="weight" class="form-control" name="weight" placeholder="Peso" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="battery">Velocità Massima</label>
                                            <input type="number" id="max_speed" class="form-control" name="max_speed" placeholder="Velocità Massima" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="battery">Cambio</label>
                                            <input type="number" id="gear" class="form-control" name="gear" placeholder="Cambio" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="battery">Tipo Telaio</label>
                                            <input type="number" id="frame" class="form-control" name="frame" placeholder="Tipo Telaio" required>
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
