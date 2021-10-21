@extends("layouts.app")
@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function(){
        $('#userSelect').select2();
        $('#bikeSelect').select2();
    });
</script>
@endpush
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
                                <form class="form" action="{{route("ebikesconnector.store")}}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                        <div class="form-group mb-3">
                                            <label for="formFile" class="form-label">Utente</label>
                                            <select class="form-select" id="userSelect" name="user_id" placeholder="Seleziona l'utente da associare">
                                                @foreach($users as $user)
                                                    <option value="{{$user->id}}">{{$user->profile->name}} {{$user->profile->surname}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                        <div class="form-group mb-3">
                                        <label for="formFile" class="form-label">Bici elettrica</label>
                                            <select class="form-select"  id="bikeSelect"  name="e_bike_id" placeholder="Seleziona la bici da associare">
                                                @foreach($e_bikes as $e_bike)
                                                    <option value="{{$e_bike->id}}">{{$e_bike->name}}</option>
                                                @endforeach
                                            </select>
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
