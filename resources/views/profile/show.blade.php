@extends('layouts.app')
@section('title','My Profile')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-4 mb-4 pb-3 border-bottom">
                    @if($user->profile_picture)
                        <img src="{{ Storage::url($user->profile_picture) }}" class="rounded-circle" width="90" height="90" style="object-fit:cover;border:3px solid #e94560">
                    @else
                        <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center" style="width:90px;height:90px;font-size:2rem;font-weight:700;border:3px solid #e94560">
                            {{ strtoupper(substr($user->name,0,1)) }}
                        </div>
                    @endif
                    <div>
                        <h4 class="mb-0 fw-bold">{{ $user->name }}</h4>
                        <p class="text-muted mb-1">{{ $user->email }}</p>
                        <span class="badge {{ $user->role==='admin'?'bg-danger':'bg-secondary' }}">{{ ucfirst($user->role) }}</span>
                    </div>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger py-2">
                        <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name',$user->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email',$user->email) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone',$user->phone) }}" placeholder="+63 9XX XXX XXXX">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Gender</label>
                            <select name="gender" class="form-select">
                                <option value="">Select...</option>
                                @foreach(['Male','Female','Other'] as $g)
                                    <option value="{{ $g }}" {{ old('gender',$user->gender)===$g?'selected':'' }}>{{ $g }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Address</label>
                            <input type="text" name="address" class="form-control" value="{{ old('address',$user->address) }}" placeholder="Street, City, Province">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Profile Picture</label>
                            <input type="file" name="profile_picture" class="form-control" accept="image/*">
                            <small class="text-muted">JPG/PNG, max 2MB</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">New Password <small class="text-muted">(leave blank to keep)</small></label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-danger px-4 fw-bold">
                                <i class="bi bi-save"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
