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
                    <!-- Main Content -->
                    <div class="col-md-12">
                        <div class="border p-3 mb-3 bg-light">
                            <h4>Inventory Supplier Dashboard</h4>
                            <p>Some text..</p>
                        </div>

                        <div class="row">
                            <div class="col-sm-3">
                                <div class="border p-3 bg-light mb-3">
                                    <h4>Users</h4>
                                    <p>1 Million</p>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="border p-3 bg-light mb-3">
                                    <h4>Pages</h4>
                                    <p>100 Million</p>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="border p-3 bg-light mb-3">
                                    <h4>Sessions</h4>
                                    <p>10 Million</p>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="border p-3 bg-light mb-3">
                                    <h4>Bounce</h4>
                                    <p>30%</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            @for ($i = 0; $i < 3; $i++)
                                <div class="col-sm-4">
                                    <div class="border p-3 bg-light mb-3">
                                        <p>Text</p>
                                        <p>Text</p>
                                        <p>Text</p>
                                    </div>
                                </div>
                            @endfor
                        </div>

                        <div class="row">
                            <div class="col-sm-8">
                                <div class="border p-3 bg-light mb-3">
                                    <p>Text</p>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="border p-3 bg-light mb-3">
                                    <p>Text</p>
                                </div>
                            </div>
                        </div>
                    </div>
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
