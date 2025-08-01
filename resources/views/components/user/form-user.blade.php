<div>
    <button type="button" class="btn btn-{{ $id ? 'default' : 'primary' }}" data-toggle="modal"
        data-target="#formUser{{ $id ?? '' }}">
        @if ($id)
            <i class="fa fa-edit" style="color: blue;"></i>
        @else
            Tambah User
        @endif
    </button>

    <div class="modal fade" id="formUser{{ $id ?? '' }}">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $id ?? '' }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ $id ? 'Edit User' : 'Add User' }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group my-1">
                            <label for="email"></label>
                            <input type="email" id="email" class="form-control" name="email"
                                value="{{ $id ? $email : old('email') ?? '' }}" placeholder="Email" required>
                        </div>
                        <div class="form-group my-1">
                            <label for="name"></label>
                            <input type="text" id="name" class="form-control" name="name"
                                value="{{ $id ? $name : old('name') ?? '' }}" placeholder="Name" required>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </form>
    </div>
    <!-- /.modal -->
</div>
