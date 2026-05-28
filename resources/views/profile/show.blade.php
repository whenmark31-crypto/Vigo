@extends('layouts.app')
@section('title','My Profile')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3 p-md-4">

                {{-- Avatar + info header --}}
                <div class="d-flex flex-column flex-sm-row align-items-center align-items-sm-start gap-3 mb-4 pb-3 border-bottom text-center text-sm-start">
                    @if($user->profile_picture)
                        <img src="{{ Storage::url($user->profile_picture) }}"
                             class="rounded-circle flex-shrink-0"
                             width="88" height="88"
                             style="object-fit:cover;border:3px solid #e94560">
                    @else
                        <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center flex-shrink-0 mx-auto mx-sm-0"
                             style="width:88px;height:88px;font-size:2rem;font-weight:700;border:3px solid #e94560">
                            {{ strtoupper(substr($user->name,0,1)) }}
                        </div>
                    @endif
                    <div>
                        <h4 class="mb-0 fw-bold">{{ $user->name }}</h4>
                        <p class="text-muted mb-1 small">{{ $user->email }}</p>
                        @if($user->phone)<p class="text-muted mb-1 small"><i class="bi bi-telephone"></i> {{ $user->phone }}</p>@endif
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
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-semibold">Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name',$user->name) }}" required>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email',$user->email) }}" required>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-semibold">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone',$user->phone) }}" placeholder="+63 9XX XXX XXXX">
                        </div>
                        <div class="col-12 col-sm-6">
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
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-semibold">
                                New Password <small class="text-muted">(leave blank to keep)</small>
                            </label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-semibold">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-danger px-4 fw-bold w-100 w-sm-auto">
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
