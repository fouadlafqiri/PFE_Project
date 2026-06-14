@extends('layouts.masterr')

@section('title', 'Artisana - Profil')

@section('content1')
<div class="breadcrumb-section breadcrumb-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="breadcrumb-text">
						<p>Fresh and Organic</p>
						<h1>Profile</h1>
					</div>
				</div>
			</div>
		</div>
	</div>


<div class="profile-page section-padding" style="padding-top: 40px; padding-bottom: 80px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        @if(auth()->user()->photo)
                            <img src="{{ auth()->user()->photo_url }}" class="rounded-circle mb-3" alt="Photo de profil" style="width:140px;height:140px;object-fit:cover;" />
                        @else
                            <div class="rounded-circle mb-3" style="width:140px;height:140px;display:flex;align-items:center;justify-content:center;background:#f0f0f0;color:#333;font-size:42px;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                        @endif
                        <h3>{{ auth()->user()->name }}</h3>
                        <p class="text-muted mb-1">{{ auth()->user()->email }}</p>
                        <p class="text-muted">{{ auth()->user()->phone ?? 'Téléphone non renseigné' }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <h4 class="mb-4">Mon profil</h4>
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label class="form-label">Nom complet</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required />
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required />
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Téléphone</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', auth()->user()->phone) }}" />
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Photo de profil</label>
                                <input type="file" name="photo" class="form-control" accept="image/*" />
                            </div>

                            <div class="d-grid gap-2 mt-3">
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
