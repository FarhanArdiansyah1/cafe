<div>
    <div class="d-flex justify-content-between align-content-center mb-2">
        <div class="d-flex">
            <div>
                <div class="d-flex align-items-center ml-4">
                    <label for="paginate" class="text-nowrap mr-2 mb-0">Per Page</label>
                    <select wire:model="paginate" name="paginate" id="paginate" class="form-control form-control-sm">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                    </select>
                </div>
            </div>

        </div>
        <div class=" col-md-4">
            <input type="search" wire:model.debounce.500ms="search" class="form-control"
                placeholder="Search">
        </div>
    </div>
    <br>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover">
            <tbody>
                <tr>
                    <th>No</th>
                    <th>Nama Pembeli</th>
                    <th>Meja</th>
                    <th>Total Transaksi</th>
                    <th>Kasir</th>
                    <th>Waktu</th>
                    @role(['admin', 'manager'])
                    <th>Action</th>
                    @endrole
                </tr>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ $order->customer_table }}</td>
                        <td>{{ $order->total }}</td>
                        <td>{{ $order->getuser->name }}</td>
                        <td>{{ $order->created_at }}</td>
                        @role(['admin', 'manager'])
                        <td>
                            <button class="btn btn-secondary btn-sm"
                                onclick="confirm('Are you sure you want to delete this record?') || event.stopImmediatePropagation()"
                                wire:click="deleteSingleRecord({{ $order->id }})"><i class="fa fa-trash"
                                    aria-hidden="true">Delete</i></button>
                        </td>
                        @endrole
                    </tr>
                @endforeach
            </tbody>
        </table>
        <h6>Pendapatan Hari ini : {{ $harian }}</h6>
        <h6>Pendapatan Bulan ini : {{ $bulanan }}</h6>
    </div>
    <div class="row mt-4">
        <div class="col-sm-6 offset-5">
            {{ $orders->links() }}
        </div>
    </div>
</div>
