<!-- Assign Delivery Person to Order -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Assigner un Livreur</h5>
    </div>
    <div class="card-body">
        @php
            $currentDelivery = null;

            try {
                $currentDelivery = $order->orderDeliveries()->first();
            } catch (\Illuminate\Database\QueryException $e) {
                // If the order_deliveries table doesn't exist yet, avoid breaking the whole page.
                if (str_contains($e->getMessage(), 'order_deliveries')) {
                    $currentDelivery = null;
                    // keep rendering the assign form
                    \Log::warning('order_deliveries table missing while rendering delivery-form', [
                        'order_id' => $order->idOrder ?? null,
                        'error' => $e->getMessage(),
                    ]);
                } else {
                    throw $e;
                }
            }
        @endphp

        @if($currentDelivery)
            <div class="alert alert-info">
                <strong>Livreur Assigné:</strong> {{ $currentDelivery->delivery->name }}<br>
                <strong>Téléphone:</strong> {{ $currentDelivery->delivery->phone }}<br>
                <strong>Statut de Livraison:</strong>
                <span class="badge bg-primary">{{ ucfirst(str_replace('_', ' ', $currentDelivery->status)) }}</span>
            </div>

            @if(in_array($currentDelivery->status, ['pending', 'picked_up', 'in_transit']))
                <form action="{{ route('admin.deliveries.updateDeliveryStatus', $currentDelivery->id) }}" method="POST" class="mb-3">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-8">
                            <select name="status" class="form-control" required>
                                <option value="">Sélectionner un statut</option>
                                <option value="picked_up" {{ $currentDelivery->status === 'picked_up' ? 'selected' : '' }}>Colis Récupéré</option>
                                <option value="in_transit" {{ $currentDelivery->status === 'in_transit' ? 'selected' : '' }}>En Transit</option>
                                <option value="delivered" {{ $currentDelivery->status === 'delivered' ? 'selected' : '' }}>Livré</option>
                                <option value="failed" {{ $currentDelivery->status === 'failed' ? 'selected' : '' }}>Échec de Livraison</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="align-middle me-1" data-feather="check"></i> Mettre à Jour
                            </button>
                        </div>
                    </div>
                </form>
            @endif

            <div class="timeline mt-4">
                @if($currentDelivery->assigned_at)
                    <div class="timeline-item">
                        <div class="timeline-marker bg-primary"></div>
                        <div class="timeline-content">
                            <strong>Assigné</strong> - {{ $currentDelivery->assigned_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                @endif

                @if($currentDelivery->picked_up_at)
                    <div class="timeline-item">
                        <div class="timeline-marker bg-info"></div>
                        <div class="timeline-content">
                            <strong>Colis Récupéré</strong> - {{ $currentDelivery->picked_up_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                @endif

                @if($currentDelivery->delivered_at)
                    <div class="timeline-item">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                            <strong>Livré</strong> - {{ $currentDelivery->delivered_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                @endif
            </div>
        @else
            <form action="{{ route('admin.deliveries.assign-order') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <select name="delivery_id" class="form-control" required>
                            <option value="">Sélectionner un livreur</option>
                            @foreach(\App\Models\Delivery::where('status', 'active')->get() as $delivery)
                                <option value="{{ $delivery->idDelivery }}">
                                    {{ $delivery->name }} - {{ $delivery->phone }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="order_id" value="{{ $order->idOrder }}">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-success w-100">
                            <i class="align-middle me-1" data-feather="plus"></i> Assigner
                        </button>
                    </div>
                </div>
            </form>
        @endif
    </div>
</div>

<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }

    .timeline-item:not(:last-child)::before {
        content: '';
        position: absolute;
        left: -20px;
        top: 30px;
        width: 2px;
        height: 50px;
        background: #dee2e6;
    }

    .timeline-marker {
        position: absolute;
        left: -26px;
        top: 0;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        border: 2px solid #fff;
    }

    .timeline-content {
        font-size: 14px;
    }
</style>
