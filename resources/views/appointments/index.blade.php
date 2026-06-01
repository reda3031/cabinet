@extends('layouts.app')
@section('page-title', 'Rendez-vous')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 font-weight-bold">{{ __('messages.appointments') }}</h5>
@if(Auth::check() && in_array(Auth::user()->role, ['patient', 'admin']))
<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createModal">
    {{ __('messages.new_rdv') }}
</button>
@endif
</div>

{{-- Barre de recherche Axios (on la branchera plus tard) --}}
<div class="mb-3">
    <input type="text" id="search-input" class="form-control" placeholder="{{ __('messages.search') }}">
</div>

<div id="appointments-table">
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead style="background:#f8fafc;">
                <tr>
                    <th>{{ __('messages.patient') }}</th>
                    <th>{{ __('messages.doctor') }}</th>
                    <th>{{ __('messages.service') }}</th>
                    <th>{{ __('messages.date') }}</th>
                    <th>{{ __('messages.status') }}</th>
                    <th>{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->patient->name }}</td>
                    <td>{{ $appointment->medecin->name }}</td>
                    <td>{{ $appointment->service->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y H:i') }}</td>
                    <td>
                        @php
                            $badge = [
                                'pending'   => 'warning',
                                'confirmed' => 'success',
                                'cancelled' => 'danger',
                            ][$appointment->status] ?? 'secondary';
                        @endphp
                        <span class="badge badge-{{ $badge }}">{{ ucfirst($appointment->status) }}</span>
                    </td>
                    <td>
                        <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-sm btn-outline-primary">
                            {{ __('messages.update') }}
                        </a>
                        <button class="btn btn-sm btn-outline-danger btn-delete"
                            data-id="{{ $appointment->id }}"
                            data-name="{{ $appointment->patient->name }}">
                            {{ __('messages.delete') }}
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">{{ __('messages.no_rdv') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $appointments->links() }}</div>
</div>

{{-- Modal de confirmation de suppression --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">{{ __('messages.confirm_delete') }}</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                {{ __('messages.confirm_msg') }} <strong id="patient-name"></strong> ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.cancel') }}</button>
                <form id="delete-form" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">{{ __('messages.delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- Modale Ajout Rapide --}}
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    {{ __('messages.new_rdv') }}
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ route('appointments.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ __('messages.doctor') }}</label>
                        <select name="medecin_id" class="form-control" required>
                            <option value="">{{ __('messages.choose_doctor') }}</option>
                            @foreach($medecins as $medecin)
                                <option value="{{ $medecin->id }}">{{ $medecin->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ __('messages.service') }}</label>
                        <select name="service_id" class="form-control" required>
                            <option value="">{{ __('messages.choose_service') }}</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ __('messages.appointment_date') }}</label>
                        <input type="datetime-local" name="appointment_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('messages.notes') }} <small class="text-muted">({{ __('messages.optional') }})</small></label>
                        <textarea name="notes" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        {{ __('messages.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-primary">
                        {{ __('messages.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
// Recherche Axios
const searchInput = document.getElementById('search-input');
const tableBody   = document.querySelector('#appointments-table tbody');

searchInput.addEventListener('input', function () {
    const query = this.value;

    if (query.length === 0) {
        location.reload();
        return;
    }

    axios.get('{{ route("appointments.search") }}', { params: { q: query } })
        .then(response => {
            const appointments = response.data;
            tableBody.innerHTML = '';

            if (appointments.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            {{ __('messages.no_rdv') }}
                        </td>
                    </tr>`;
                return;
            }

            appointments.forEach(rdv => {
                const statusColors = {
                    pending:   'warning',
                    confirmed: 'success',
                    cancelled: 'danger'
                };
                const statusNames = {
                    pending:   "{{ __('messages.pending') }}",
                    confirmed: "{{ __('messages.confirmed') }}",
                    cancelled: "{{ __('messages.cancelled') }}"
                };
                const badge = statusColors[rdv.status] || 'secondary';
                const translatedStatus = statusNames[rdv.status] || rdv.status;
                const locale = "{{ app()->getLocale() }}" === 'fr' ? 'fr-FR' : 'en-US';
                const date  = new Date(rdv.appointment_date).toLocaleString(locale, {
                    day: '2-digit', month: '2-digit', year: 'numeric',
                    hour: '2-digit', minute: '2-digit'
                });

                tableBody.innerHTML += `
                    <tr>
                        <td>${rdv.patient ? rdv.patient.name : '-'}</td>
                        <td>${rdv.medecin ? rdv.medecin.name : '-'}</td>
                        <td>${rdv.service ? rdv.service.name : '-'}</td>
                        <td>${date}</td>
                        <td><span class="badge badge-${badge}">${translatedStatus}</span></td>
                        <td>
                            <a href="/appointments/${rdv.id}/edit" class="btn btn-sm btn-outline-primary">
                                {{ __('messages.update') }}
                            </a>
                            <button class="btn btn-sm btn-outline-danger btn-delete"
                                data-id="${rdv.id}"
                                data-name="${rdv.patient ? rdv.patient.name : ''}">
                                {{ __('messages.delete') }}
                            </button>
                        </td>
                    </tr>`;
            });

            // Rebind delete buttons after Axios render
            bindDeleteButtons();
        })
        .catch(error => console.error('Erreur recherche:', error));
});

// Suppression modale
function bindDeleteButtons() {
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function () {
            const id   = this.dataset.id;
            const name = this.dataset.name;
            document.getElementById('patient-name').textContent = name;
            document.getElementById('delete-form').action = '/appointments/' + id;
            $('#deleteModal').modal('show');
        });
    });
}

bindDeleteButtons();
</script>
@endsection
