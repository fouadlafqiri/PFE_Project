@extends('admin.master')

@section('admin-content')

<div class="row">
    <div class="col-md-8">
        <h1 class="h3 mb-3"><strong>Ajouter un Livreur</strong></h1>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.deliveries.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nom *</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               placeholder="Nom du livreur" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               placeholder="email@exemple.com" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Téléphone *</label>
                        <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror"
                               placeholder="+212 6XX XXX XXX" value="{{ old('phone') }}" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Adresse</label>
                        <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                               placeholder="Adresse du livreur" value="{{ old('address') }}">
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Type de Véhicule</label>
                            <select name="vehicle_type" class="form-control @error('vehicle_type') is-invalid @enderror">
                                <option value="">Sélectionner...</option>
                                <option value="bike" {{ old('vehicle_type') === 'bike' ? 'selected' : '' }}>Motocyclette</option>
                                <option value="car" {{ old('vehicle_type') === 'car' ? 'selected' : '' }}>Voiture</option>
                                <option value="truck" {{ old('vehicle_type') === 'truck' ? 'selected' : '' }}>Camion</option>
                            </select>
                            @error('vehicle_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Numéro d'Immatriculation</label>
                            <input type="text" name="vehicle_number" class="form-control @error('vehicle_number') is-invalid @enderror"
                                   placeholder="ABC 12345" value="{{ old('vehicle_number') }}">
                            @error('vehicle_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="align-middle me-1" data-feather="check"></i> Ajouter
                        </button>
                        <a href="{{ route('admin.deliveries.index') }}" class="btn btn-secondary">
                            <i class="align-middle me-1" data-feather="x"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
