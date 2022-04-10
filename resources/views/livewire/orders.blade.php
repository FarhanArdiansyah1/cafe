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

            @role(['admin', 'manager'])
            <div>
                @if ($checked)
                    <div class="dropdown ml-4">
                        <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">With Checked
                            ({{ count($checked) }})</button>
                        <div class="dropdown-menu">
                            <a href="#" class="dropdown-item" type="button"
                                onclick="confirm('Are you sure you want to delete these Records?') || event.stopImmediatePropagation()"
                                wire:click="deleteRecords()">
                                Delete
                            </a>
                        </div>
                    </div>
                @endif
            </div>
            @endrole
        </div>
        <div class=" col-md-4">
            <input type="search" wire:model.debounce.500ms="search" class="form-control"
                placeholder="Search">
        </div>
    </div>

    <br>
    @role(['admin', 'manager'])
    @if ($selectPage)
        <div class="col-md-10 mb-2">
            @if ($selectAll)
                <div>
                    You have selected all <strong>{{ $students->total() }}</strong> items.
                </div>
            @else
                <div>
                    You have selected <strong>{{ count($checked) }}</strong> items, Do you want to Select All
                    <strong>{{ $students->total() }}</strong>?
                    <a href="#" class="ml-2" wire:click="selectAll">Select All</a>
                </div>
            @endif

        </div>
    @endif
    @endrole

    <div class="card-body table-responsive p-0">
        <table class="table table-hover">
            <tbody>
                <tr>
                    <th><input type="checkbox" wire:model="selectPage"></th>
                    <th>Nama Pembeli</th>
                    <th>Meja</th>
                    <th>Total Transaksi</th>
                    <th>Kasir</th>
                    <th>Waktu</th>
                    @role(['admin', 'manager'])
                    <th>Action</th>
                    @endrole
                </tr>
                @foreach ($students as $student)
                    <tr class="@if ($this->isChecked($student->id)) table-primary @endif">
                        <td><input type="checkbox" value="{{ $student->id }}" wire:model="checked"></td>
                        <td>{{ $student->customer_name }}</td>
                        <td>{{ $student->customer_table }}</td>
                        <td>{{ $student->total }}</td>
                        <td>{{ $student->getuser->name }}</td>
                        <td>{{ $student->created_at }}</td>
                        @role(['admin', 'manager'])
                        <td>
                            <button class="btn btn-danger btn-sm"
                                onclick="confirm('Are you sure you want to delete this record?') || event.stopImmediatePropagation()"
                                wire:click="deleteSingleRecord({{ $student->id }})"><i class="fa fa-trash"
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
            {{ $students->links() }}
        </div>
    </div>
</div>
