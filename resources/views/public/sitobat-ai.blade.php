@extends('layouts.app') 
@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 70vh;">
    <div class="text-center">
        <i class="bi bi-robot text-success" style="font-size: 5rem;"></i>
        <h2 class="mt-3 fw-bold">SITOBAT-AI</h2>
        <p class="text-muted">Fitur asisten cerdas etnobotani sedang dalam tahap pengembangan.</p>
        <a href="{{ url('/') }}" class="btn btn-success rounded-pill px-4">Kembali ke Beranda</a>
    </div>
</div>
@endsection