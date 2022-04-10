<div class="container vertical-scrollable">
    <div>
        <h1>Pesan</h1>
        <form>
            <div class="form-group">
                Nama
                <input type="text" wire:model.defer="customer_name" class="form-control" required>
            </div>
            <div class="form-group">
                Meja
                <input type="number" wire:model.defer="customer_table" class="form-control" required>
            </div>
        </form>
        <table class="table table-hover">
            <tbody>
                <tr>
                    <th><input type="checkbox"></th>
                    <th>Nama Makanan/Minuman</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
                @foreach ($carts as $cart)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $cart->getproduct->name }}</td>
                        <td>{{ $cart->getproduct->price }}</td>
                        <td>{{ $cart->quantity }}</td>
                        <td>{{ $cart->getproduct->price * $cart->quantity }}</td>
                        <td><button class="btn btn-secondary btn-sm"
                            onclick="confirm('Are you sure you want to delete this record?') || event.stopImmediatePropagation()"
                            wire:click="destroy({{ $cart->id }})"><i class="fa fa-trash"
                                aria-hidden="true">Delete</i></button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <h6>Total Item Pemesanan: {{ $totalquantity }}</h6>
        <h6>Total Harga Pemesanan: {{ $totalprice }}</h6>
        <button class="btn btn-dark" wire:click.defer="pesan">Pesan</button>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-md-2 col-6">
                        <button wire:click.prevent="tambahmenu({{ $product->id }})" data-toggle="modal" data-target="#exampleModal">
                            <img src="{{ asset('download.jpg') }}" alt="">
                            <h5>{{ $product->name }} (Rp. {{ number_format($product->price) }})</h5>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ $productname }} (Rp. {{ number_format($productprice) }})</h5>
                    <button type="button" wire:click.prevent='resetInput()' class="btn btn-secondary" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" wire:model.defer="productid">
                        <div class="form-group">
                            <center>
                                <img src="{{ asset('download.jpg') }}" alt="daw">
                            </center>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Jumlah Pesan</label>
                            <input type="number" wire:model="quantity" class="form-control" placeholder="Masukan Jumlah">
                        </div>
                        <br>
                        <button type="button" wire:click.prevent='resetInput()' class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button wire:click.prevent="simpancart" class="btn btn-dark" data-dismiss="modal">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>