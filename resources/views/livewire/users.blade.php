<div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Buat User</h5>
                    <button type="button" wire:click.prevent='resetInput()' class="btn btn-secondary"
                        data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Nama</label>
                            <input type="text" wire:model.defer="name" class="form-control"
                                placeholder="Masukan Nama">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Email</label>
                            <input type="email" wire:model.defer="email" class="form-control"
                                placeholder="Masukan Harga">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Password</label>
                            <input type="password" wire:model.defer="password" class="form-control"
                                placeholder="Masukan Harga">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Role</label>
                            <select  class="form-control" wire:model.defer="role_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sn">
                                <option value="null">-- Pilih Role</option>
                                <option value="admin">Admin</option>
                                <option value="manager">Manajer</option>
                                <option value="kasir">Kasir</option>
                            </select>
                        </div>
                        <br>
                        <button wire:click='resetInput()' type="button" class="btn btn-secondary"
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
                    <h5 class="modal-title" id="exampleModalLabel">Edit user</h5>
                    <button type="button" wire:click.prevent='resetInput()' class="btn btn-secondary"
                        data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" wire:model.defer="iduser">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Nama</label>
                            <input type="text" wire:model.defer="name" class="form-control"
                                placeholder="Masukan Nama">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Email</label>
                            <input type="email" wire:model.defer="email" class="form-control"
                                placeholder="Masukan Harga">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Password</label>
                            <input type="password" wire:model.defer="password" class="form-control"
                                placeholder="Masukan Harga">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Roles</label>
                            <select  class="form-control" wire:model.defer="role_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sn">
                                <option value="manager">Manajer</option>
                                <option value="admin">Admin</option>
                                <option value="kasir">Kasir</option>
                            </select>
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

        </div>
        <div class=" col-md-4">
            <input type="search" wire:model.debounce.500ms="search" class="form-control" placeholder="Search">
        </div>
    </div>

    <br>

    <button class="btn btn btn-dark btn-sm" data-toggle="modal" data-target="#exampleModal">Tambah</button>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover">
            <tbody>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $user->getuser->name }}</td>
                        <td>{{ $user->getuser->email }}</td>
                        <td>{{ $user->getrole->name }}</td>
                        <td>
                            <button class="btn btn btn-dark btn-sm" wire:click.prevent="edit({{ $user->user_id }})"
                                data-toggle="modal" data-target="#exampleModals">Edit</button>
                            <button class="btn btn-secondary btn-sm"
                                onclick="confirm('Are you sure you want to delete this record?') || event.stopImmediatePropagation()"
                                wire:click="destroy({{ $user->user_id }})"><i class="fa fa-trash"
                                    aria-hidden="true">Delete</i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row mt-4">
        <div class="col-sm-6 offset-5">
            {{ $users->links() }}
        </div>
    </div>
</div>
