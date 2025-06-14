@extends('layouts.inventory-staff.master')

@section('css')
    <style>
    </style>
@endsection

@section('title', 'VibePlan-Inventory Supplier Dashboard')

@section('parent_heading', 'Inventory Supplier Dashboard')
@section('parent_icon', 'mdi-account-multiple-outline')
@section('child_heading', 'Inventory Supplier Dashboard')

@section('content')
    <div class="card" style="border-radius: 15px;">
        <div class="card-body">
            <div class="container-fluid mt-3">
                <div class="row">
                   
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#events-table').DataTable();

            $('.select2').select2();

        });
    </script>
@endsection
