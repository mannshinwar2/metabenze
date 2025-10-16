@extends('user.layouts.app')

@section('title', 'Deposit History')

@section('content')
<div class="container-fluid content-inner mt-4 py-4">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Deposit History</h4>
                    </div>
                </div>
                <div class="card-body">
                    <p>Here is your deposit history. Status indicates whether your payment has been confirmed or is pending.</p>
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped" data-toggle="data-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>UserId</th>
                                    <th>Name</th>
                                    <th>Amount($)</th>
                                    <th>Currency</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach($history as $row)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $row->userid }}</td>
                                    <td>{{ $row->usersname }}</td>
                                    <td>{{ round($row->amountusdt, 2) }}</td>
                                    <td style="text-transform:uppercase;">{{ $row->currency }}</td>
                                    <td>{{ $row->created_at }}</td>
                                    <td class="text-end {{ $row->statusclass }}">{{ $row->status }}</td>
                                </tr>
                                @php $i++; @endphp
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>UserId</th>
                                    <th>Name</th>
                                    <th>Amount($)</th>
                                    <th>Currency</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="card-arrow">
                    <div class="card-arrow-top-left"></div>
                    <div class="card-arrow-top-right"></div>
                    <div class="card-arrow-bottom-left"></div>
                    <div class="card-arrow-bottom-right"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- DataTables Scripts -->
<script src="{{asset('ctassets/plugins/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('ctassets/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            responsive: true,
            pageLength: 10,
            order: [[0, 'desc']]
        });
    });
</script>
@endsection
