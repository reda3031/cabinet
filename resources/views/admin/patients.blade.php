@extends('layouts.app')
@section('page-title', __('messages.patients'))

@section('content')
<input type="text" id="search-input" class="form-control mb-3" placeholder="{{ __('messages.search_patient') }}">

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead style="background:#f8fafc;">
                <tr>
                    <th>{{ __('messages.name') }}</th>
                    <th>{{ __('messages.email') }}</th>
                    <th>{{ __('messages.phone') }}</th>
                    <th>{{ __('messages.total_appointments') }}</th>
                    <th>{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patients as $patient)
                <tr>
                    <td>{{ $patient->name }}</td>
                    <td>{{ $patient->email }}</td>
                    <td>{{ $patient->phone ?? '-' }}</td>
                    <td><span class="badge badge-info">{{ $patient->appointments_as_patient_count }}</span></td>
                    <td>
                        <a href="{{ route('admin.patients.history', $patient) }}" class="btn btn-sm btn-outline-primary">
                            {{ __('messages.view_history') }}
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">{{ __('messages.no_patient_found') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.getElementById('search-input').addEventListener('input', function(e) {
        let query = e.target.value;
        if (query.length === 0) {
            window.location.reload();
            return;
        }

        axios.get("{{ route('admin.patients.search') }}?q=" + query)
            .then(response => {
                let tbody = document.querySelector('tbody');
                tbody.innerHTML = '';
                if (response.data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted py-4">{{ __('messages.no_patient_found') }}</td></tr>';
                } else {
                    response.data.forEach(patient => {
                        let phone = patient.phone ? patient.phone : '-';
                        let url = `/admin/patients/${patient.id}`;
                        tbody.innerHTML += `
                            <tr>
                                <td>${patient.name}</td>
                                <td>${patient.email}</td>
                                <td>${phone}</td>
                                <td><span class="badge badge-info">${patient.appointments_as_patient_count}</span></td>
                                <td>
                                    <a href="${url}" class="btn btn-sm btn-outline-primary">
                                        {{ __('messages.view_history') }}
                                    </a>
                                </td>
                            </tr>
                        `;
                    });
                }
            });
    });
</script>
@endsection
