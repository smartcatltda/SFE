<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class controlador extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("modelo");
        $this->load->library('pdf');
    }

    public function index() {
        $this->load->view('header');
        $this->load->view('content');
        $this->load->view('footer');
    }

    //CONEXION

    function conectar() {
        $user = $this->input->post('user');
        $pass = $this->input->post('pass');
        $valor = 0;
        $permiso = "";
        $nombre = "";
        $apellido = "";
        $id_user = "";
        $mensaje = "Combinación de Usuario y Contraseña Incorrecta";
        $datos = $this->modelo->conectar($user, $pass);
        $cookie = array('permiso' => '', 'conectado' => false);
        if ($datos->num_rows() == 1) {
            $valor = 1;
            $data = $datos->result();
            foreach ($data as $fila) {
                $id_user = $fila->id_usuario;
                $permiso = $fila->tipo_user;
                $nombre = strtoupper($fila->nombre);
                $apellido = strtoupper($fila->apellido);
            }
            if ($permiso == "") {
                $mensaje = "EL usuario no cuenta con los permisos necesarios para acceder al Sistema";
                $valor = 0;
            } else {
                $cookie = array('user' => $user, 'permiso' => $permiso, 'nombre' => $nombre, 'apellido' => $apellido, 'id_user' => $id_user, 'conectado' => true);
            }
            $this->session->set_userdata($cookie);
        }
        echo json_encode(array('valor' => $valor, 'mensaje' => $mensaje, 'nombre' => $nombre, 'apellido' => $apellido, 'permiso' => $permiso));
    }

    function verificalogin() {
        $valor = 0;
        $permiso = '';
        $nombre = '';
        $apellido = '';
        if ($this->session->userdata('conectado') == true) {
            $valor = 1;
            $permiso = $this->session->userdata('permiso');
            $nombre = $this->session->userdata('nombre');
            $apellido = $this->session->userdata('apellido');
        }
        echo json_encode(array('valor' => $valor, 'permiso' => $permiso, 'nombre' => $nombre, 'apellido' => $apellido));
    }

    function salir() {
        $valor = 0;
        $cookie = array('conectado' => false);
        $this->session->set_userdata($cookie);
        echo json_encode(array('valor' => $valor));
    }

    function validaRut() {
        $rut = $this->input->post('rut');
        if (strpos($rut, "-") == false) {
            $RUT[0] = substr($rut, 0, -1);
            $RUT[1] = substr($rut, -1);
        } else {
            $RUT = explode("-", trim($rut));
        }
        $elRut = str_replace(".", "", trim($RUT[0]));
        $factor = 2;
        $suma = 0;
        for ($i = strlen($elRut) - 1; $i >= 0; $i--):
            $factor = $factor > 7 ? 2 : $factor;
            $suma += $elRut{$i} * $factor++;
        endfor;
        $resto = $suma % 11;
        $dv = 11 - $resto;
        if ($dv == 11) {
            $dv = 0;
        } else if ($dv == 10) {
            $dv = "k";
        } else {
            $dv = $dv;
        }
        if ($dv == trim(strtolower($RUT[1]))) {
            $return = true;
        } else {
            $return = false;
        }
        echo json_encode(array('return' => $return));
    }

    //****************MANTENEDOR CLIENTE*******************
    function cargar_clientes() {
        $permiso = $this->session->userdata('permiso');
        if ($permiso == 1) {
            $datos = $this->modelo->cargar_clientes();
            $data ['cantidad'] = $datos->num_rows();
            $data ['clientes'] = $datos->result();
        } else {
            $datos = $this->modelo->cargar_clientes_activos();
            $data ['cantidad'] = $datos->num_rows();
            $data ['clientes'] = $datos->result();
        }

        $this->load->view("lista_clientes", $data);
    }

    function cargar_select_clientes() {
        $datos = $this->modelo->cargar_clientes_activos();
        $data ['cantidad'] = $datos->num_rows();
        $data ['clientes'] = $datos->result();
        $this->load->view("select_clientes", $data);
    }

    function insert_cliente() {
        $nombre = $this->input->post('nombre');
        $rut = $this->input->post('rut');
        $direccion = $this->input->post('direccion');
        $ciudad = $this->input->post('ciudad');
        $comuna = $this->input->post('comuna');
        $telefono = $this->input->post('telefono');
        $giro = $this->input->post('giro');
        $valor = 0;
        $msg = "Cliente Ya Registrado";
        if ($this->modelo->insert_cliente($nombre, $rut, $direccion, $ciudad, $comuna, $telefono, $giro) == 0) {
            $msg = "Cliente Registrado Correctamente";
            $valor = 1;
        }
        echo json_encode(array("valor" => $valor, "msg" => $msg));
    }

    function update_clientes() {
        $id_rut = $this->input->post('id_rut');
        $nombre = $this->input->post('nombre');
        $rut = $this->input->post('rut');
        $direccion = $this->input->post('direccion');
        $ciudad = $this->input->post('ciudad');
        $comuna = $this->input->post('comuna');
        $telefono = $this->input->post('telefono');
        $giro = $this->input->post('giro');
        $valor = 0;
        if ($id_rut == $rut) {
            if ($this->modelo->update_clientes($id_rut, $nombre, $rut, $direccion, $ciudad, $comuna, $telefono, $giro) == 0) {
                $valor = 1;
            }
        } else {
            if ($this->modelo->seleccionar_cliente($rut)->num_rows() == 0) {
                if ($this->modelo->update_clientes($id_rut, $nombre, $rut, $direccion, $ciudad, $comuna, $telefono, $giro) == 0) {
                    $valor = 1;
                }
            }
        }
        echo json_encode(array("valor" => $valor));
    }

    function delete_cliente() {
        $rut = $this->input->post('rut');
        $permiso = $this->session->userdata('permiso');
        $msj = "Error, algo salio mal!";
        if ($permiso == 1) {
            if ($this->modelo->delete_cliente($rut) == 0) {
                $msj = "Cliente Eliminado";
            }
        } else {
            if ($this->modelo->delete_cliente_user($rut) == 0) {
                $msj = "Cliente Eliminado";
            }
        }
        echo json_encode(array("msj" => $msj));
    }

    function seleccionar_cliente() {
        $rut = $this->input->post('rut');
        $valor = 0;
        $datos = $this->modelo->seleccionar_cliente($rut)->result();
        $cont = $this->modelo->seleccionar_cliente($rut)->num_rows();
        if ($cont > 0) {
            $valor = 1;
            foreach ($datos as $fila) {
                $rut = $fila->rut_c;
                $nombre = $fila->nombre_c;
                $direccion = $fila->direccion_c;
                $ciudad = $fila->ciudad_c;
                $comuna = $fila->comuna_c;
                $telefono = $fila->telefono_c;
                $giro = $fila->giro_c;
            }
            echo json_encode(array("valor" => $valor, "rut" => $rut, "nombre" => $nombre, "direccion" => $direccion,
                "ciudad" => $ciudad, "comuna" => $comuna, "telefono" => $telefono, "giro" => $giro));
        } else {
            echo json_encode(array("valor" => $valor));
        }
    }

    function estado_cliente() {
        $rut = $this->input->post('rut');
        $estado = $this->input->post('estado');
        if ($estado == 1) {
            if ($this->modelo->delete_cliente_user($rut) == 0) {
                $msj = "Cliente Desactivado";
            }
        } else {
            if ($this->modelo->activar_cliente($rut) == 0) {
                $msj = "Cliente Activado";
            }
        }
        echo json_encode(array("msj" => $msj));
    }

    //*******************MANTENEDOR USUARIO***************************

    function cargar_usuarios() {
        $datos = $this->modelo->cargar_usuarios();
        $data ['cantidad'] = $datos->num_rows();
        $data ['usuarios'] = $datos->result();
        $this->load->view("lista_usuarios", $data);
    }

    function insert_usuario() {
        $nombre = $this->input->post('nombre');
        $user = $this->input->post('user');
        $pass = $this->input->post('pass');
        $apellido = $this->input->post('apellido');
        $tipo = $this->input->post('tipo');
        $valor = 0;
        $msg = "Cliente Ya Registrado";
        if ($this->modelo->insert_usuario($nombre, $user, $pass, $apellido, $tipo) == 0) {
            $msg = "Cliente Registrado Correctamente";
            $valor = 1;
        }
        echo json_encode(array("valor" => $valor, "msg" => $msg));
    }

    function update_usuario() {
        $id = $this->input->post('id');
        $id_nombre = $this->input->post('id_nombre');
        $nombre = $this->input->post('nombre');
        $user = $this->input->post('user');
        $pass = $this->input->post('pass');
        $apellido = $this->input->post('apellido');
        $tipo = $this->input->post('tipo');
        $valor = 0;
        $msg = "Nombre de Usuario Ya Registrado";
        if ($id_nombre == $user) {
            if ($this->modelo->update_usuario($id, $nombre, $user, $pass, $apellido, $tipo) == 0) {
                $msg = "Usuario Modificado Correctamente";
                $valor = 1;
            }
        } else {
            if ($this->modelo->update_usuario_2($id, $nombre, $user, $pass, $apellido, $tipo) == 0) {
                $msg = "Usuario Modificado Correctamente";
                $valor = 1;
            }
        }
        echo json_encode(array("valor" => $valor, "msg" => $msg));
    }

    function seleccionar_usuario() {
        $id = $this->input->post('id');
        $valor = 0;
        $datos = $this->modelo->seleccionar_usuario($id)->result();
        $cont = $this->modelo->seleccionar_usuario($id)->num_rows();
        if ($cont > 0) {
            $valor = 1;
            foreach ($datos as $fila) {
                $id = $fila->id_usuario;
                $user = $fila->user;
                $pass = $fila->pass;
                $nombre = $fila->nombre;
                $apellido = $fila->apellido;
                $tipo = $fila->tipo_user;
            }
            echo json_encode(array("valor" => $valor, "id" => $id, "user" => $user, "pass" => $pass,
                "nombre" => $nombre, "apellido" => $apellido, "tipo" => $tipo));
        } else {
            echo json_encode(array("valor" => $valor));
        }
    }

    function delete_usuario() {
        $id = $this->input->post('id');
        $msj = "Error, algo salio mal!";
        if ($this->modelo->delete_usuario($id) == 0) {
            $msj = "Usuario Eliminado";
        }
        echo json_encode(array("msj" => $msj));
    }

    //************************************FACTURA*****************************************
    function crear_factura() {
        date_default_timezone_set("America/Argentina/Buenos_Aires");
        $fecha = date('Y-m-d');
        $hora = date("H:i:s");
        $prev = 0;
        if ($this->modelo->num_fac()->num_rows() == 0):
            $num_fac = "1";
        else:
            $datos = $this->modelo->num_fac()->result();
            foreach ($datos as $fila) :
                $prev = $fila->num_fac;
            endforeach;
            $num_fac = $prev + 1;
        endif;
        $id_user = $this->session->userdata('id_user');
        $datos = $this->modelo->crear_factura($fecha, $hora, $id_user, $num_fac)->result();
        foreach ($datos as $fila) {
            $num_fac = $fila->num_fac;
        }
        echo json_encode(array("id" => $num_fac));
    }

    function insert_detalle_fac() {
        $num_fac = $this->input->post('num_fac');
        $cantidad = $this->input->post('cantidad');
        $desc = $this->input->post('desc');
        $precio = $this->input->post('precio');
        $total_det = $precio * $cantidad;
        $datos = $this->modelo->insert_datalle_fac($num_fac, $cantidad, $desc, $precio, $total_det);
        $data ['cantidad'] = $datos->num_rows();
        $data ['detalle'] = $datos->result();
        $this->load->view("detalle_factura", $data);
    }

    function delete_detalle_fac() {
        $id = $this->input->post('id');
        $num_fac = $this->input->post('num_fac');
        $datos = $this->modelo->delete_detalle_fac($id, $num_fac);
        $data ['cantidad'] = $datos->num_rows();
        $data ['detalle'] = $datos->result();
        $this->load->view("detalle_factura", $data);
    }

    function cargar_detalle_fac() {
        $num_fac = $this->input->post('num_fac');
        $datos = $this->modelo->cargar_detalle_fac($num_fac);
        $data ['cantidad'] = $datos->num_rows();
        $data ['detalle'] = $datos->result();
        $this->load->view("detalle_factura", $data);
    }

    function calcular() {
        $num_fac = $this->input->post('num_fac');
        $cantidad = $this->input->post('cantidad');
        $precio = $this->input->post('precio');
        $ope = $this->input->post('ope');
        $datos = $this->modelo->subtotal($num_fac)->result();
        $sub = 0;
        foreach ($datos as $fila) :
            $prev = $fila->subtotal_fac;
        endforeach;
        if ($ope != '0'):
            $sub = $prev - $cantidad * $precio;
        else:
            $sub = $prev + $cantidad * $precio;
        endif;
        $subtotal = $sub;
        $neto = round($subtotal / 1.19);
        $iva = round($neto * 0.19);
        $total = $neto + $iva;
        $this->modelo->update_total($num_fac, $subtotal, $neto, $iva, $total);
        echo json_encode(array("subtotal" => $subtotal, "neto" => $neto, "iva" => $iva, "total" => $total));
    }

    function update_cliente_fac() {
        $rut = $this->input->post('rut');
        $num_fac = $this->input->post('num_fac');
        $this->modelo->update_cliente_fac($rut, $num_fac);
    }

    function verf_detalle() {
        $num_fac = $this->input->post('num_fac');
        $detalle = $this->modelo->cargar_detalle_fac($num_fac)->num_rows();
        echo json_encode(array("detalle" => $detalle));
    }

    function descartar_factura() {
        $num_fac = $this->input->post('num_fac');
        $valor = 0;
        $detalle = $this->modelo->cargar_detalle_fac($num_fac)->num_rows();
        if ($this->modelo->descartar_factura($num_fac) == 0):
            $valor = 1;
        endif;
        echo json_encode(array("valor" => $valor, "detalle" => $detalle));
    }

    function mantener_factura() {
        $valor = 0;
        $num_fac = 0;
        $abierta = $this->modelo->mantener_factura()->num_rows();
        if ($abierta != 0) {
            $datos = $this->modelo->mantener_factura()->result();
            foreach ($datos as $fila) {
                $num_fac = $fila->num_fac;
                $subtotal = $fila->subtotal_fac;
                $neto = $fila->neto_fac;
                $iva = $fila->iva_fac;
                $total = $fila->total_fac;
                $rut = $fila->rut_c;
                $valor = 1;
            }
        }
        echo json_encode(array("num_fac" => $num_fac, "subtotal" => $subtotal, "neto" => $neto, "iva" => $iva, "total" => $total, "rut" => $rut, "valor" => $valor));
    }

    function mantener_cliente_fac() {
        $rut = $this->input->post('rut');
        $datos = $this->modelo->mantener_cliente_fac($rut)->result();
        foreach ($datos as $fila):
            $rut = $fila->rut_c;
            $nombre = $fila->nombre_c;
            $direccion = $fila->direccion_c;
            $ciudad = $fila->ciudad_c;
            $comuna = $fila->comuna_c;
            $telefono = $fila->telefono_c;
            $giro = $fila->giro_c;
        endforeach;
        echo json_encode(array("rut" => $rut, "nombre" => $nombre, "direccion" => $direccion,
            "ciudad" => $ciudad, "comuna" => $comuna, "telefono" => $telefono, "giro" => $giro));
    }

    function cerrar_factura() {
        $num_fac = $this->input->post('num_fac');
        $valor = 0;
        $detalle = $this->modelo->cargar_detalle_fac($num_fac)->num_rows();
        if ($this->modelo->cerrar_factura($num_fac) == 0) {
            $valor = 1;
        }
        echo json_encode(array("valor" => $valor, "detalle" => $detalle));
    }

    //*************************INFORMES*******************************************

    function reporte_diario() {
        $tipo = $this->input->post('tipo');
        $fecha = $this->input->post('fecha');
        if ($tipo == "f") {
            $datos["diario_f"] = $this->modelo->diario_f($fecha)->result();
            $datos["cantidad"] = $this->modelo->diario_f($fecha)->num_rows();
            $this->load->view("r_factura", $datos);
        }
    }

}
