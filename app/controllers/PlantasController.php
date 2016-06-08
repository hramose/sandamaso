<?php

class PlantasController extends BaseController {

	public function ListarPlantas(){

		$filter = DataFilter::source(new Plantas);
		$filter->label('Plantas');
		$filter->link('/admin/plantas/crud', 'Crear Nueva Planta', 'TR');
		$filter->attributes(array('class'=>'form-inline'));
		$filter->add('nombre','Buscar por nombre', 'text');
		$filter->submit('Buscar');
		$filter->reset('Limpiar');
		$filter->build();

		$grid = DataGrid::source($filter);
	    $grid->paginate(10);
	    $grid->build();

		return View::make('plantas/list', compact('filter', 'grid'));
	}


	public function CrudPlantas(){
        $edit = DataEdit::source(new Plantas());
        $edit->link("/admin/plantas/list","Lista Plantas", "TR")->back();
        $edit->add('nombre','Nombre', 'text')->rule('required');
        $edit->add('sabados','Sabados', 'checkbox');
        $edit->add('dias_restriccion','Primeros/Ultimos Días','checkbox');
        $edit->add('num_dias','Numero de Días','text')->rule('required');
        $edit->add('url_map','URL Mapa','text');
        $edit->add('image_map','Imagen Mapa', 'image')
                        ->rule('mimes:jpeg,png')
                        ->move('img/plantas/');
        $edit->add('email_admin','Correo Administrador','text')->rule('required');
        $edit->add('activa','Activa', 'checkbox');
        $edit->add('convenio','Convenio', 'checkbox');

        return $edit->view('plantas/crud', compact('edit'));
    }

    public function ListarPlantasHoras($id_planta){

		$filter = DataFilter::source(PlantasHoras::where('id_planta', $id_planta));
		$nombre = Plantas::find($id_planta)->nombre;
		$filter->label('Horas Semana Planta '.$nombre);
		$filter->link("/admin/plantas/list","Lista de Plantas", "TR");
		$filter->link("/admin/plantas/horas/".$id_planta."/crud","Agregar Hora", "TR");
		$grid = DataGrid::source($filter);
	    $grid->attributes(array("class"=>"table table-striped"));
	    $grid->add('hora_planta','Hora', true);
	    $grid->add('num_reservas','Numero de Reservas', true);
	    $grid->edit(url().'/admin/plantas/horas/'.$id_planta.'/crud', 'Editar/Borrar','modify|delete');

		return View::make('planta_hora/list', compact('filter', 'grid'));
	}

	public function CrudPlantasHoras($id){
        $edit = DataEdit::source(new PlantasHoras());
        $edit->link("/admin/plantas/horas/".$id."/list","Lista Horas", "TR")->back();
        $edit->add('hora_planta','Hora', 'text')->rule('required');
        $edit->add('num_reservas','Numero de Reservas', 'text')->rule('required');
        $edit->add('id_planta', '', 'hidden')->insertValue($id);

        return $edit->view('planta_hora/crud', compact('edit'));
    }


    public function ListarPlantasHorasWeekend($id_planta){

		$filter = DataFilter::source(PlantasHorasWeekend::where('id_planta', $id_planta));
		$nombre = Plantas::find($id_planta)->nombre;
		$filter->label('Horas Fin de Semana Planta '.$nombre);
		$filter->link("/admin/plantas/list","Lista de Plantas", "TR");
		$filter->link("/admin/plantas/horas_weekend/".$id_planta."/crud","Agregar Hora", "TR");
		$grid = DataGrid::source($filter);
	    $grid->attributes(array("class"=>"table table-striped"));
	    $grid->add('hora_planta','Hora', true);
	    $grid->add('num_reservas','Numero de Reservas', true);
	    $grid->edit(url().'/admin/plantas/horas_weekend/'.$id_planta.'/crud', 'Editar/Borrar','modify|delete');

		return View::make('planta_hora/list', compact('filter', 'grid'));
	}


	public function ListarPlantasEmpresas($id_planta){
		$filter = DataFilter::source(PlantaEmpresa::with('empresas')
						->where('id_planta', $id_planta));
		$nombre = Plantas::find($id_planta)->nombre;
		$filter->label('Empresas con convenio de la Planta '.$nombre);
		$filter->link("/admin/plantas/empresas/".$id_planta."/crud","Agregar Empresa a esta Planta", "TR");
		$grid = DataGrid::source($filter);
	    $grid->attributes(array("class"=>"table table-striped"));
	    $grid->add('{{ $empresas->nombre }}','Empresa', 'id_empresa');
	    $grid->add('{{ $empresas->limite }}','Limite reservas', true);
	    $grid->edit(url().'/admin/plantas/empresas/'.$id_planta.'/crud', 'Editar/Borrar','modify|delete');

		return View::make('planta_empresa/list', compact('filter', 'grid'));
	}


	public function CrudPlantasHorasWeekend($id){
        $edit = DataEdit::source(new PlantasHorasWeekend());
        $edit->link("/admin/plantas/horas_weekend/".$id."/list","Lista Horas", "TR")->back();
         $edit->add('hora_planta','Hora', 'text')->rule('required');
        $edit->add('num_reservas','Numero de Reservas', 'text')->rule('required');
        $edit->add('id_planta', '', 'hidden')->insertValue($id);

        return $edit->view('planta_hora/crud', compact('edit'));
    }


    public function CrudPlantasEmpresas($id){
        $edit = DataEdit::source(new PlantaEmpresa());
        $edit->link("/admin/plantas/empresas/".$id."/list","Lista Empresas", "TR")->back();
        $edit->add('id_empresa','Empresa','select')->options(Empresas::lists("nombre", "id"));
        $edit->add('id_planta', '', 'hidden')->insertValue($id);

        return $edit->view('planta_empresa/crud', compact('edit'));
    }


}
