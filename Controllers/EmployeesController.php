<?php

namespace Controllers;

use Entity\Empleado;
use Entity\Areas;
use Entity\Roles;
use Entity\Empleado_rol;

/**
 * @start "Homepage"
 */
class EmployeesController
{
	/* Renderizar FrondEnd de la carpeta Public (Lado Cliente) */
	public function home()
	{
		include_once("Public/index.html");
	}

	/* Renderizar los datos en json */
	public function render($data)
	{
		echo json_encode($data, JSON_PRETTY_PRINT);
	}

	/* Lista de Empleados */
	public function list()
	{
		$Employees = new Empleado();
		$this->render($Employees->read());
	}

	public function read($params)
	{
		$Employees = new Empleado();
		$this->render($Employees->read('*', $params));
	}

	/* Agregar Empleado */
	public function add($params)
	{
		/* ?nombre=Andres Sandoval&email=sandovalfenix@example.co&sexo=M&area_id=5&boletin=1&descripcion=Hola mundo */
		$Employees = new Empleado();
		$row = $Employees->read('id', array('email' => $params['email']), true);
		$id = ($row) ? false : $Employees->create($params);
		$alert = array(
			'id' => $id,
			'type' => ($id) ? 'success' : 'warning',
			'msg' => ($id) ? 'El Empleado fue registrado con éxito. Codigo de registro: ' . md5($id)
				: 'El Empleado no pudo ser registrado. El correo ' . $params['email'] . ' ya existe!'
		);

		$this->render($alert);
	}

	/* Actualizar un Empleado */
	public function edit($params)
	{
		/* ?id=5&nombre=Andres Sandoval&email=sandovalfenix@example.co&sexo=M&area_id=5&boletin=1&descripcion=Hola mundo */
		$Employees = new Empleado();
		$row = $Employees->read('id', array('id' => $params['id']), true);
		$update = ($row) ? $Employees->update($params) : false;

		$alert = array(
			'type' => ($update) ? 'success' : 'warning',
			'msg' => ($update) ? 'El Empleado fue actualizado con éxito. Codigo de registro: ' . md5($params['id'])
				: 'El Empleado no pudo ser actualizado.'
		);

		$this->render($alert);
	}

	/* Eliminar un Empleado */
	public function delete($params)
	{
		extract($params);
		$Employees = new Empleado();
		$row = $Employees->read('id', array('id' => $params['id']), true);
		$delete = ($row) ? $Employees->delete($id) : false;

		$alert = array(
			'type' => ($delete) ? 'success' : 'warning',
			'msg' => ($delete) ? 'El Empleado fue borrado con éxito. Codigo de registro: ' . md5($id)
				: 'El Empleado no pudo ser borrado.'
		);

		$this->render($alert);
	}

	/* Lista de Areas */
	public function listAreas()
	{
		$Areas = new Areas();
		$this->render($Areas->read());
	}

	/* Obtener un Area */
	public function readArea($params)
	{
		$Areas = new Areas();
		$row = $Areas->read('id', array('id' => $params['id']), true);
		$alert = array(
			'type' => ($row) ? 'success' : 'warning',
			'msg' => ($row) ? 'El Area fue encontrada con éxito. Codigo de registro: ' . md5($params['id'])
				: 'El Area no pudo ser encontrada.'
		);
		$this->render(array_push(
			$row,
			array('alert' => $alert)
		));
	}

	/* Lista de Roles */
	public function listRoles()
	{
		$Roles = new Roles();
		$this->render($Roles->read());
	}

	/* Obtener un Rol */
	public function readRol($params)
	{
		$Roles = new Roles();
		$row = $Roles->read('id', array('id' => $params['id']), true);
		$alert = array(
			'type' => ($row) ? 'success' : 'warning',
			'msg' => ($row) ? 'El Rol fue encontrado con éxito. Codigo de registro: ' . md5($params['id'])
				: 'El Rol no pudo ser encontrado.'
		);
		$this->render(array_push(
			$row,
			array('alert' => $alert)
		));
	}

	/* Agregar Roles de un Empleado */
	public function addRolesEmployee($params)
	{
		extract($params);
		$Employees = new Empleado_rol();
		foreach (array_diff($params, array($params['empleado_id'])) as $key => $value) {
			$Employees->create(array('empleado_id' => $empleado_id, 'rol_id' => $value));
		}
	}
	/* Obtener Roles de un Empleado */
	public function rolesEmployee($params)
	{
		$RolesEmpleado = new Empleado_rol();
		$rows = $RolesEmpleado->read('*', array('empledo_id' => $params['id']));
		$alert = array(
			'type' => ($rows) ? 'success' : 'warning',
			'msg' => ($rows) ? 'Los Roles fueron encontrados con éxito. Codigo de registro: ' . md5($params['id'])
				: 'Los Roles no pudieron ser encontrados.'
		);
		$this->render(array_push(
			$rows,
			array('alert' => $alert)
		));
	}
}
