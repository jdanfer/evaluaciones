@if (session('mensajealerta'))
    <div class="alert alert-danger alert-dismissible fade show alert-admin" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{ session('mensajealerta') }}
    </div>
@endif