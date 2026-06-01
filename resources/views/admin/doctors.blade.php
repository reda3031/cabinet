@extends('layouts.app')
@section('page-title', __('messages.doctors'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 font-weight-bold">{{ __('messages.doctor_list') }}</h5>
    <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary btn-sm">
        {{ __('messages.add_doctor') }}
    </a>
</div>

<input type="text" id="search-input" class="form-control mb-3" placeholder="{{ __('messages.search_doctor') }}">

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead style="background:#f8fafc;">
                <tr>
                    <th>{{ __('messages.name') }}</th>
                    <th>{{ __('messages.email') }}</th>
                    <th>{{ __('messages.phone') }}</th>
                    <th>{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($doctors as $doctor)
                <tr>
                    <td>{{ $doctor->name }}</td>
                    <td>{{ $doctor->email }}</td>
                    <td>{{ $doctor->phone ?? '-' }}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-danger btn-delete"
                            data-id="{{ $doctor->id }}"
                            data-name="{{ $doctor->name }}">
                            {{ __('messages.delete') }}
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">{{ __('messages.no_doctor_found') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
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
                {{ __('messages.confirm_msg') }} <strong id="doctor-name"></strong> ?
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

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    function bindDeleteButtons() {
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function () {
                const id   = this.dataset.id;
                const name = this.dataset.name;
                document.getElementById('doctor-name').textContent = name;
                document.getElementById('delete-form').action = '/admin/doctors/' + id;
                $('#deleteModal').modal('show');
            });
        });
    }

    bindDeleteButtons();

    document.getElementById('search-input').addEventListener('input', function(e) {
        let query = e.target.value;
        if (query.length === 0) {
            window.location.reload();
            return;
        }

        axios.get("{{ route('admin.doctors.search') }}?q=" + query)
            .then(response => {
                let tbody = document.querySelector('tbody');
                tbody.innerHTML = '';
                if (response.data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted py-4">{{ __('messages.no_doctor_found') }}</td></tr>';
                } else {
                    response.data.forEach(doctor => {
                        let phone = doctor.phone ? doctor.phone : '-';
                        tbody.innerHTML += `
                            <tr>
                                <td>${doctor.name}</td>
                                <td>${doctor.email}</td>
                                <td>${phone}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-danger btn-delete"
                                        data-id="${doctor.id}"
                                        data-name="${doctor.name}">
                                        {{ __('messages.delete') }}
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    bindDeleteButtons();
                }
            });
    });
</script>
@endsection
