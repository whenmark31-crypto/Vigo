@extends('layouts.app')
@section('title','PC Parts List')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center border-0 py-3 px-3 px-md-4">
        <span class="fw-bold fs-5">My PC Parts</span>
        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#addPartModal">
            <i class="bi bi-plus-lg"></i> <span class="d-none d-sm-inline">Add Part</span>
        </button>
    </div>
    <div class="card-body p-0">

        {{-- Desktop table --}}
        <div class="table-responsive d-none d-md-block">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr><th>#</th><th>Name</th><th>Category</th><th>Brand</th><th>Price</th><th>Qty</th><th>Added</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @forelse($parts as $i => $part)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td class="fw-semibold">{{ $part->name }}</td>
                        <td><span class="badge bg-primary">{{ $part->category }}</span></td>
                        <td>{{ $part->brand }}</td>
                        <td>₱{{ number_format($part->price,2) }}</td>
                        <td>{{ $part->quantity }}</td>
                        <td>{{ $part->created_at->format('M d, Y') }}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" onclick="editPart({{ $part }})">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form method="POST" action="{{ route('pcparts.destroy',$part) }}" class="d-inline"
                                  onsubmit="return confirm('Delete this part?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">No PC parts added yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile cards --}}
        <div class="d-md-none p-2">
            @forelse($parts as $part)
            <div class="card mb-2 border shadow-none">
                <div class="card-body py-2 px-3">
                    <div class="d-flex justify-content-between align-items-start gap-2">
                        <div class="overflow-hidden">
                            <div class="fw-semibold text-truncate">{{ $part->name }}</div>
                            <div class="d-flex flex-wrap gap-1 mt-1">
                                <span class="badge bg-primary">{{ $part->category }}</span>
                                <span class="badge bg-light text-dark border">{{ $part->brand }}</span>
                            </div>
                            <div class="small text-muted mt-1">
                                ₱{{ number_format($part->price,2) }} &bull; Qty: {{ $part->quantity }} &bull; {{ $part->created_at->format('M d, Y') }}
                            </div>
                        </div>
                        <div class="d-flex gap-1 flex-shrink-0">
                            <button class="btn btn-sm btn-outline-primary" onclick="editPart({{ $part }})">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form method="POST" action="{{ route('pcparts.destroy',$part) }}" class="d-inline"
                                  onsubmit="return confirm('Delete this part?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-center text-muted py-4">No PC parts added yet.</p>
            @endforelse
        </div>

    </div>
</div>

<!-- Add Part Modal -->
<div class="modal fade" id="addPartModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <form method="POST" action="{{ route('pcparts.store') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Add PC Part</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Part Name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Ryzen 5 5600X" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-select" required>
                            <option value="">Select...</option>
                            @foreach(['CPU','GPU','RAM','Motherboard','Storage','PSU','Case','Cooling','Monitor','Peripherals'] as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Brand</label>
                        <input type="text" name="brand" class="form-control" placeholder="e.g. AMD" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Price (₱)</label>
                        <input type="number" name="price" class="form-control" step="0.01" min="0" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="quantity" class="form-control" min="1" value="1" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Add Part</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Part Modal -->
<div class="modal fade" id="editPartModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <form method="POST" id="editPartForm" class="modal-content">
            @csrf @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title">Edit PC Part</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Part Name</label>
                        <input type="text" name="name" id="eName" class="form-control" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Category</label>
                        <select name="category" id="eCategory" class="form-select" required>
                            @foreach(['CPU','GPU','RAM','Motherboard','Storage','PSU','Case','Cooling','Monitor','Peripherals'] as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Brand</label>
                        <input type="text" name="brand" id="eBrand" class="form-control" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Price (₱)</label>
                        <input type="number" name="price" id="ePrice" class="form-control" step="0.01" min="0" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="quantity" id="eQty" class="form-control" min="1" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="eDesc" class="form-control" rows="2"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Update Part</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function editPart(p) {
    document.getElementById('editPartForm').action = '/pcparts/' + p.id;
    document.getElementById('eName').value = p.name;
    document.getElementById('eCategory').value = p.category;
    document.getElementById('eBrand').value = p.brand;
    document.getElementById('ePrice').value = p.price;
    document.getElementById('eQty').value = p.quantity;
    document.getElementById('eDesc').value = p.description || '';
    new bootstrap.Modal(document.getElementById('editPartModal')).show();
}
</script>
@endsection
