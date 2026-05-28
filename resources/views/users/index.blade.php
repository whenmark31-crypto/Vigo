@extends('layouts.app')
@section('title','Users Management')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center border-0 py-3">
        <span class="fw-bold fs-5">All Users</span>
        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="bi bi-plus-lg"></i> Add User
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr><th>#</th><th>Name</th><th>Email</th><th>Role</th><th>Created</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @forelse($users as $i => $user)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if($user->profile_picture)
                                    <img src="{{ Storage::url($user->profile_picture) }}" class="rounded-circle" width="32" height="32" style="object-fit:cover">
                                @else
                                    <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center" style="width:32px;height:32px;font-size:.8rem;font-weight:700">
                                        {{ strtoupper(substr($user->name,0,1)) }}
                                    </div>
                                @endif
                                {{ $user->name }}
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td><span class="badge {{ $user->role==='admin'?'bg-danger':'bg-secondary' }}">{{ ucfirst($user->role) }}</span></td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" onclick="editUser({{ $user }})">
                                <i class="bi bi-pencil"></i>
                            </button>
                            @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('users.destroy',$user) }}" class="d-inline" onsubmit="return confirm('Delete this user?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">No users found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('users.store') }}" class="modal-content">
            @csrf
            <div class="modal-header"><h5 class="modal-title">Add User</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="mb-3"><label class="form-label">Name</label><input type="text" name="name" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required></div>
                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select"><option value="user">User</option><option value="admin">Admin</option></select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Add User</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" id="editUserForm" class="modal-content">
            @csrf @method('PUT')
            <div class="modal-header"><h5 class="modal-title">Edit User</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="mb-3"><label class="form-label">Name</label><input type="text" name="name" id="editName" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" id="editEmail" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">New Password <small class="text-muted">(leave blank to keep)</small></label><input type="password" name="password" class="form-control"></div>
                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" id="editRole" class="form-select"><option value="user">User</option><option value="admin">Admin</option></select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Update User</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function editUser(user) {
    document.getElementById('editUserForm').action = '/users/' + user.id;
    document.getElementById('editName').value = user.name;
    document.getElementById('editEmail').value = user.email;
    document.getElementById('editRole').value = user.role;
    new bootstrap.Modal(document.getElementById('editUserModal')).show();
}
</script>
@endsection
