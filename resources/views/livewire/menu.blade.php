<div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Menu</h5>
                    <button type="button" wire:click.prevent='resetInput()' class="btn btn-secondary"
                        data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" wire:submit.prevent="save">
                        <input type="hidden" wire:model.defer="productid">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Nama Makanan/Minuman</label>
                            <input type="text" wire:model.defer="productname" class="form-control"
                                placeholder="Masukan Nama">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Harga</label>
                            <input type="number" wire:model.defer="price" class="form-control"
                                placeholder="Masukan Harga">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="customFile">Input image</label>
                            <input wire:model.defer="image" type="file" class="form-control" id="customFile" />
                        </div>
                        <br>
                        <button wire:click.prevent='resetInput()' type="button" class="btn btn-secondary"
                            data-dismiss="modal">Close</button>
                        <button wire:click.prevent="simpanmenu" class="btn btn-dark"
                            data-dismiss="modal">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModals" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                    <button type="button" wire:click.prevent='resetInput()' class="btn btn-secondary"
                        data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" wire:model.defer="productid">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Nama Makanan/Minuman</label>
                            <input type="text" wire:model.defer="productname" class="form-control"
                                placeholder="Masukan Nama">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Harga</label>
                            <input type="number" wire:model.defer="price" class="form-control"
                                placeholder="Masukan Harga">
                        </div>
                        <br>
                        <button wire:click.prevent='resetInput()' type="button" class="btn btn-secondary"
                            data-dismiss="modal">Close</button>
                        <button wire:click.prevent="simpanedit" class="btn btn-dark"
                            data-dismiss="modal">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
        </div>
        <div class=" col-md-4">
            <input type="search" wire:model.debounce.500ms="search" class="form-control" placeholder="Search">
        </div>
    </div>

    <br>
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

    <button class="btn btn btn-dark btn-sm" data-toggle="modal" data-target="#exampleModal">Tambah</button>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover">
            <tbody>
                <tr>
                    <th><input type="checkbox" wire:model="selectPage"></th>
                    <th>Gambar</th>
                    <th>Nama Makanan/Minuman</th>
                    <th>Harga</th>
                    <th>Action</th>
                </tr>
                @foreach ($students as $student)
                    <tr class="@if ($this->isChecked($student->id)) table-primary @endif">
                        <td><input type="checkbox" value="{{ $student->id }}" wire:model="checked"></td>
                        <td></td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->price }}</td>
                        <td>
                            <button class="btn btn btn-dark btn-sm" wire:click.prevent="edit({{ $student->id }})"
                                data-toggle="modal" data-target="#exampleModals">Edit</button>
                            <button class="btn btn-secondary btn-sm"
                                onclick="confirm('Are you sure you want to delete this record?') || event.stopImmediatePropagation()"
                                wire:click="destroy({{ $student->id }})"><i class="fa fa-trash"
                                    aria-hidden="true">Delete</i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row mt-4">
        <div class="col-sm-6 offset-5">
            {{ $students->links() }}
        </div>
    </div>
</div>
