<div class="modal fade" id="PuntoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    @if (isset($autoevaluas))
        <form action="{{ url('/admin/autoevaluaciones/' . $autoevaluas->id . '/editar') }}" method="post">
    @else 
       <form action="#" method="post">
    @endif 
    @csrf
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Puntaje</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <div class="md-form mb-5">
                    <label data-error="wrong" data-success="right" for="puntos">Puntos</label>
                    @if (isset($autoevaluas))
                        <input type="number" min="1" max="4" style="width: 200px;" id="puntos" class="form-control validate" name="puntos" value="{{ old('puntos', $autoevaluas->puntos) }}">
                    @else 
                        <input type="number" min="1" max="4" style="width: 200px;" id="puntos" class="form-control validate" name="puntos">
                    @endif 
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </form>
  </div>

</div>
