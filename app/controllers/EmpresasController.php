<?php

class EmpresasController extends BaseController {

	public function CrudEmpresas(){
        $edit = DataEdit::source(new Empresas());
        $edit->link("/admin/empresas/list","Lista Empresas", "TR")->back();
        $edit->add('nombre','Nombre', 'text')->rule('required');
        $edit->add('limite','Limite de Reservas','text')->rule('required');

        return $edit->view('empresas/crud', compact('edit'));
    }

	public function ListarEmpresas(){

		$filter = DataFilter::source(new Empresas);
		$filter->label('Lista de Empresas con Convenio');
		$filter->link("/admin/empresas/crud","Agregar Empresa", "TR");
		$grid = DataGrid::source($filter);
	    $grid->attributes(array("class"=>"table table-striped"));
	    $grid->add('nombre','Empresa', true);
	    $grid->add('limite','Limite de Reservas', true);
	    $grid->edit(url().'/admin/empresas/crud', 'Editar/Borrar','modify|delete');

		return View::make('empresas/list', compact('filter', 'grid'));
	}

	public function ListaEmpresasPorIdPlanta(){
		$id_planta = Input::get('id');
		$lista = DB::table('empresas')
			->select('empresas.nombre', 'empresas.id')
            ->join('planta_empresa', 'empresas.id', '=', 'planta_empresa.id_empresa')
            ->where('planta_empresa.id_planta', $id_planta)
            ->get();
		return Response::json($lista);
	}

}
