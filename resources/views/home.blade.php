@extends('layouts.app')

@section('content')
<div class="container"> <!-- Remove custom-container class -->
    <div class="row justify-content-center">
        <div class="col-md-8 mb-4"> <!-- Adjust the width by changing the column size -->
            <create-diary-form></create-diary-form>
        </div>
    </div>
</div>
@endsection
