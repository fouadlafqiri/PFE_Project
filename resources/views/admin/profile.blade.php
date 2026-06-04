@extends('admin.master')

@section('admin-content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">{{ auth()->user()->role === 'livreur' ? 'Mon profil de livreur' : 'Mon profil administrateur' }}</h1>
            <p class="text-muted">Mettez à jour vos informations personnelles.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    @if($user->photo)
                        <img src="{{ $user->photo }}" class="rounded-circle mb-3" alt="Photo de profil" style="width:140px;height:140px;object-fit:cover;" />
                    @else
                        <div class="rounded-circle mb-3 d-flex align-items-center justify-content-center" style="width:140px;height:140px;background:#f0f0f0;color:#333;font-size:42px;">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                    @endif
                    <h5 class="card-title mb-0">{{ $user->name }}</h5>
                    <div class="text-muted mb-2">{{ $user->email }}</div>
                    <div class="text-muted">{{ $user->phone ?? 'Téléphone non renseigné' }}</div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Modifier mes informations</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Nom</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Téléphone</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if(auth()->user()->role === 'livreur')
                            <div class="mb-3">
                                <label class="form-label">Statut</label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="active" {{ old('status', $delivery->status ?? '') === 'active' ? 'selected' : '' }}>Actif</option>
                                    <option value="inactive" {{ old('status', $delivery->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactif</option>
                                    <option value="on_delivery" {{ old('status', $delivery->status ?? '') === 'on_delivery' ? 'selected' : '' }}>En cours de livraison</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Type de Véhicule *</label>
                                <select name="vehicle_type" class="form-control @error('vehicle_type') is-invalid @enderror" required>
                                    <option value="">Sélectionner...</option>
                                    <option value="bike" {{ old('vehicle_type', $delivery->vehicle_type ?? '') === 'bike' ? 'selected' : '' }}>Motocyclette</option>
                                    <option value="car" {{ old('vehicle_type', $delivery->vehicle_type ?? '') === 'car' ? 'selected' : '' }}>Voiture</option>
                                    <option value="truck" {{ old('vehicle_type', $delivery->vehicle_type ?? '') === 'truck' ? 'selected' : '' }}>Camion</option>
                                </select>
                                @error('vehicle_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Numéro d'immatriculation</label>
                                <input type="text" name="vehicle_number" class="form-control @error('vehicle_number') is-invalid @enderror" value="{{ old('vehicle_number', $delivery->vehicle_number ?? '') }}">
                                @error('vehicle_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Photo de profil</label>
                            <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
