@extends('admin.master')

@section('admin-content')
    <div class="mb-4">
        <h1 class="h3 mb-0">Lecture du message</h1>
        <p class="text-muted">Détails du message envoyé par le client.</p>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <strong>Nom :</strong>
                <div>{{ $contact->name }}</div>
            </div>
            <div class="mb-3">
                <strong>Email :</strong>
                <div>{{ $contact->email }}</div>
            </div>
            <div class="mb-3">
                <strong>Téléphone :</strong>
                <div>{{ $contact->phone ?: 'Non renseigné' }}</div>
            </div>
            <div class="mb-3">
                <strong>Sujet :</strong>
                <div>{{ $contact->subject ?: 'Sans sujet' }}</div>
            </div>
            <div class="mb-3">
                <strong>Message :</strong>
                <div class="border rounded p-3 bg-light">{{ $contact->message }}</div>
            </div>
            <div class="mb-3">
                <strong>Reçu le :</strong>
                <div>{{ $contact->created_at->format('d/m/Y H:i') }}</div>
            </div>

            <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">Retour aux messages</a>
        </div>
    </div>
@endsection
