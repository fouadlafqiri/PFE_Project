@extends('layouts.masterr')
@section('content1')

<!--PreLoader-->
<div class="loader">
    <div class="loader-inner">
        <div class="circle"></div>
    </div>
</div>
<!--PreLoader Ends-->

<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>Validation de votre Commande</p>
                    <h1>Paiement et Livraison</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end breadcrumb section -->

<!-- check out section -->
<div class="checkout-section mt-150 mb-150">
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                <strong>Erreur!</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
            @csrf
            <div class="row">
                <!-- Formulaire Principale -->
                <div class="col-lg-8">
                    <div class="checkout-accordion-wrap">
                        <div class="accordion" id="accordionExample">

                            <!-- 1. Adresse de Facturation -->
                            <div class="card single-accordion">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                            <i class="fas fa-map-marker-alt"></i> Adresse de Facturation
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseOne" class="collapse show" data-bs-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="billing-address-form">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Nom Complet *</label>
                                                    <input type="text" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror"
                                                           placeholder="Ex: Jean Dupont" value="{{ old('customer_name', $user->name ?? '') }}" required>
                                                    @error('customer_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Email *</label>
                                                    <input type="email" name="customer_email" class="form-control @error('customer_email') is-invalid @enderror"
                                                           placeholder="Ex: email@exemple.com" value="{{ old('customer_email', $user->email ?? '') }}" required>
                                                    @error('customer_email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Téléphone *</label>
                                                    <input type="tel" name="customer_phone" class="form-control @error('customer_phone') is-invalid @enderror"
                                                           placeholder="Ex: +212 6XX XXX XXX" value="{{ old('customer_phone') }}" required>
                                                    @error('customer_phone')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Pays *</label>
                                                    <input type="text" name="country" class="form-control" placeholder="Ex: Maroc" value="{{ old('country', 'Maroc') }}">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Adresse *</label>
                                                <input type="text" name="billing_address" class="form-control @error('billing_address') is-invalid @enderror"
                                                       placeholder="Ex: 123 Rue de la Paix" value="{{ old('billing_address') }}" required>
                                                @error('billing_address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Ville *</label>
                                                    <input type="text" name="city" class="form-control" placeholder="Ex: Casablanca" value="{{ old('city') }}" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Code Postal *</label>
                                                    <input type="text" name="postal_code" class="form-control" placeholder="Ex: 20000" value="{{ old('postal_code') }}" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Adresse de Livraison -->
                            <div class="card single-accordion">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                            <i class="fas fa-truck"></i> Adresse de Livraison
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseTwo" class="collapse" data-bs-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="form-check mb-3">
                                            <input type="checkbox" class="form-check-input" id="same_address" name="same_address" checked>
                                            <label class="form-check-label" for="same_address">
                                                Même adresse que la facturation
                                            </label>
                                        </div>
                                        <div class="shipping-address-form" id="shipping-form" style="display: none;">
                                            <div class="mb-3">
                                                <label class="form-label">Adresse de Livraison *</label>
                                                <input type="text" name="shipping_address" class="form-control @error('shipping_address') is-invalid @enderror"
                                                       placeholder="Ex: 456 Avenue de la Liberté" value="{{ old('shipping_address') }}">
                                                @error('shipping_address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Ville *</label>
                                                    <input type="text" name="shipping_city" class="form-control" placeholder="Ex: Fès">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Code Postal *</label>
                                                    <input type="text" name="shipping_postal_code" class="form-control" placeholder="Ex: 30000">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 3. Méthode de Paiement -->
                            <div class="card single-accordion">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                            <i class="fas fa-credit-card"></i> Méthode de Paiement
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseThree" class="collapse" data-bs-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="payment-methods">
                                            <!-- Carte de Crédit -->
                                            <div class="form-check mb-3">
                                                <input type="radio" class="form-check-input" id="credit_card" name="payment_method" value="credit_card" onchange="showPaymentDetails()">
                                                <label class="form-check-label" for="credit_card">
                                                    <i class="fas fa-credit-card"></i> Carte de Crédit
                                                </label>
                                            </div>

                                            <!-- Virement Bancaire -->
                                            <div class="form-check mb-3">
                                                <input type="radio" class="form-check-input" id="bank_transfer" name="payment_method" value="bank_transfer" onchange="showPaymentDetails()">
                                                <label class="form-check-label" for="bank_transfer">
                                                    <i class="fas fa-university"></i> Virement Bancaire
                                                </label>
                                            </div>

                                            <!-- Paiement à la Livraison -->
                                            <div class="form-check mb-3">
                                                <input type="radio" class="form-check-input" id="cash_on_delivery" name="payment_method" value="cash_on_delivery" checked onchange="showPaymentDetails()">
                                                <label class="form-check-label" for="cash_on_delivery">
                                                    <i class="fas fa-money-bill"></i> Paiement à la Livraison
                                                </label>
                                            </div>

                                            <!-- Détails Carte de Crédit -->
                                            <div id="card-details" class="card-details mt-4" style="display: none;">
                                                <div class="alert alert-info">
                                                    <strong>Paiement simulé</strong> : aucune transaction réelle n'est effectuée. Seul le numéro de carte est vérifié (16 chiffres).
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Titulaire de la Carte</label>
                                                    <input type="text" name="card_holder" class="form-control @error('card_holder') is-invalid @enderror"
                                                           placeholder="Ex: JEAN DUPONT" value="{{ old('card_holder') }}">
                                                    @error('card_holder')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Numéro de Carte (16 chiffres) *</label>
                                                    <input type="text" name="card_number" class="form-control @error('card_number') is-invalid @enderror"
                                                           placeholder="1234 5678 9012 3456" value="{{ old('card_number') }}" maxlength="19"
                                                           inputmode="numeric" pattern="[0-9 ]*" required>
                                                    @error('card_number')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Date d'Expiration (MM/AA)</label>
                                                        <input type="text" name="expiry_date" class="form-control @error('expiry_date') is-invalid @enderror"
                                                               placeholder="MM/AA" value="{{ old('expiry_date') }}" maxlength="5"
                                                               pattern="(0[1-9]|1[0-2])/[0-9]{2}">
                                                        @error('expiry_date')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">CVV (3-4 chiffres)</label>
                                                        <input type="text" name="cvv" class="form-control @error('cvv') is-invalid @enderror"
                                                               placeholder="123" value="{{ old('cvv') }}" maxlength="4"
                                                               inputmode="numeric" pattern="[0-9]*">
                                                        @error('cvv')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Détails Virement Bancaire -->
                                            <div id="bank-details" class="bank-details mt-4" style="display: none;">
                                                <div class="alert alert-info">
                                                    <strong>Informations de Virement:</strong><br>
                                                    Banque: Banque Centrale du Maroc<br>
                                                    IBAN: MA15XXXXXXXXXXXXXXXXXXXX<br>
                                                    BIC: BMCEMAMC<br>
                                                    <small>Veuillez référencer votre numéro de commande dans la description du virement.</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 4. Notes Spéciales -->
                            <div class="card single-accordion">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                                            <i class="fas fa-sticky-note"></i> Notes Spéciales (Optionnel)
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseFour" class="collapse" data-bs-parent="#accordionExample">
                                    <div class="card-body">
                                        <textarea name="notes" class="form-control" rows="4" placeholder="Ajouter des instructions de livraison ou des notes spéciales...">{{ old('notes') }}</textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Résumé de la Commande -->
                <div class="col-lg-4">
                    <div class="order-details-wrap">
                        <table class="order-details">
                            <thead>
                                <tr>
                                    <th>Détails de la Commande</th>
                                    <th>Prix</th>
                                </tr>
                            </thead>
                            <tbody class="order-details-body">
                                @foreach($cartItems as $item)
                                <tr>
                                    <td>
                                        {{ $item->product->nameProduct }}<br>
                                        <small class="text-muted">Quantité: {{ $item->quantity }}</small>
                                    </td>
                                    <td>{{ number_format($item->product->priceProduct * $item->quantity, 2) }} DH</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tbody class="checkout-details">
                                <tr>
                                    <td><strong>Sous-total</strong></td>
                                    <td><strong>{{ number_format($total, 2) }} DH</strong></td>
                                </tr>
                                <tr>
                                    <td>Livraison</td>
                                    <td>50.00 DH</td>
                                </tr>
                                <tr class="total-row">
                                    <td><strong>Total</strong></td>
                                    <td><strong>{{ number_format($total + 50, 2) }} DH</strong></td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="submit" class="boxed-btn w-100 mt-3">
                            <i class="fas fa-check-circle"></i> Confirmer la Commande
                        </button>
                        <a href="{{ route('cart.index') }}" class="boxed-btn secondary w-100 mt-2" style="background-color: #6c757d;">
                            <i class="fas fa-arrow-left"></i> Retour au Panier
                        </a>
                    </div>

                    <!-- Sécurité Info -->
                    <div class="security-info mt-4 p-3" style="background: #f8f9fa; border-radius: 5px;">
                        <small class="text-muted">
                            <i class="fas fa-lock"></i> <strong>Paiement Sécurisé</strong><br>
                            Vos données sont cryptées et sécurisées.
                        </small>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- end check out section -->

<!-- Styles -->
<style>
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }

    .card-header .btn-link {
        color: #333;
        text-decoration: none;
        font-weight: 500;
    }

    .card-header .btn-link:hover {
        color: #ff6b6b;
    }

    .total-row {
        border-top: 2px solid #dee2e6;
        font-size: 16px;
    }

    .boxed-btn.secondary {
        background-color: #6c757d;
        color: white;
    }

    .boxed-btn.secondary:hover {
        background-color: #5a6268;
    }

    input[type="text"]:invalid,
    input[type="email"]:invalid,
    input[type="tel"]:invalid {
        border-color: #dc3545;
    }
</style>

<!-- JavaScript pour afficher/masquer les champs de paiement -->
<script>
    function showPaymentDetails() {
        const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
        const cardDetails = document.getElementById('card-details');
        const bankDetails = document.getElementById('bank-details');

        // Masquer tous les détails
        cardDetails.style.display = 'none';
        bankDetails.style.display = 'none';

        // Supprimer la validation requise
        document.querySelectorAll('[name="card_number"], [name="card_holder"], [name="expiry_date"], [name="cvv"]').forEach(el => {
            el.removeAttribute('required');
        });

        // Afficher les détails appropriés
        if (paymentMethod === 'credit_card') {
            cardDetails.style.display = 'block';
            document.querySelector('[name="card_number"]').setAttribute('required', 'required');
        } else if (paymentMethod === 'bank_transfer') {
            bankDetails.style.display = 'block';
        }
    }

    // Afficher/masquer adresse de livraison
    document.getElementById('same_address').addEventListener('change', function() {
        const shippingForm = document.getElementById('shipping-form');
        const shippingAddress = document.querySelector('[name="shipping_address"]');
        const billingAddress = document.querySelector('[name="billing_address"]').value;

        if (this.checked) {
            shippingForm.style.display = 'none';
            shippingAddress.removeAttribute('required');
            // Copier l'adresse de facturation
            shippingAddress.value = billingAddress;
        } else {
            shippingForm.style.display = 'block';
            shippingAddress.setAttribute('required', 'required');
            shippingAddress.value = '';
        }
    });

    // Initialiser le formulaire au chargement
    document.addEventListener('DOMContentLoaded', function() {
        showPaymentDetails();

        // Si checkbox est checked, copier l'adresse de facturation
        if (document.getElementById('same_address').checked) {
            document.getElementById('shipping-form').style.display = 'none';
            const billingAddress = document.querySelector('[name="billing_address"]').value;
            document.querySelector('[name="shipping_address"]').value = billingAddress;
        }

        // Préparer la soumission du formulaire pour la simulation de paiement
        document.getElementById('checkout-form').addEventListener('submit', function() {
            const cardNumberInput = document.querySelector('[name="card_number"]');
            if (cardNumberInput) {
                cardNumberInput.value = cardNumberInput.value.replace(/\s+/g, '');
            }

            const sameAddressCheckbox = document.getElementById('same_address');
            if (sameAddressCheckbox && sameAddressCheckbox.checked) {
                const billingAddress = document.querySelector('[name="billing_address"]').value;
                const shippingAddressInput = document.querySelector('[name="shipping_address"]');
                if (shippingAddressInput) {
                    shippingAddressInput.value = billingAddress;
                }
            }
        });
    });

    // Formater le numéro de carte avec espaces
    const cardNumberField = document.querySelector('[name="card_number"]');
    if (cardNumberField) {
        cardNumberField.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s/g, '');
            let formattedValue = value.replace(/(.{4})/g, '$1 ').trim();
            e.target.value = formattedValue;
        });
    }

    // Formater la date d'expiration
    const expiryField = document.querySelector('[name="expiry_date"]');
    if (expiryField) {
        expiryField.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
            e.target.value = value;
        });
    }
</script>

@endsection
