<!-- // resources/views/auth/verify.blade.php
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Verify Your Email</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('verification.verify') }}">
                        @csrf
                        <div class="form-group">
                            <label>Verification Code</label>
                            <input type="text" name="code" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Verify</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection -->