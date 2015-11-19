<?php

class modelo extends CI_Model {

    //CONEXION
    function conectar($user, $pass) {
        $this->db->select('*');
        $this->db->where('user', $user);
        $this->db->where('pass', ($pass));
        return $this->db->get('usuario');
    }

    //**********************Mantenedor Clientes**************************
    function cargar_clientes() {
        $this->db->select('*');
        $this->db->from('cliente');
        $this->db->order_by('estado_cliente', 'DESC');
        return $this->db->get();
    }

    function cargar_clientes_activos() {
        $this->db->select('*');
        $this->db->where('estado_cliente', '1');
        $this->db->from('cliente');
        return $this->db->get();
    }

    function insert_cliente($nombre, $rut, $direccion, $ciudad, $comuna, $telefono, $giro) {
        $this->db->select('rut_c');
        $this->db->where('rut_c', $rut);
        $cantidad = $this->db->get('cliente')->num_rows();
        if ($cantidad == 0):
            $data = array(
                "rut_c" => $rut,
                "nombre_c" => $nombre,
                "direccion_c" => $direccion,
                "ciudad_c" => $ciudad,
                "comuna_c" => $comuna,
                "telefono_c" => $telefono,
                "giro_c" => $giro,
                "estado_cliente" => 1,
            );
            $this->db->insert("cliente", $data);
            return 0;
        else:
            return 1;
        endif;
    }

    function update_clientes($id_rut, $nombre, $rut, $direccion, $ciudad, $comuna, $telefono, $giro) {
        $data = array(
            "rut_c" => $rut,
            "nombre_c" => $nombre,
            "direccion_c" => $direccion,
            "ciudad_c" => $ciudad,
            "comuna_c" => $comuna,
            "telefono_c" => $telefono,
            "giro_c" => $giro,
        );
        $this->db->where('rut_c', $id_rut);
        $this->db->update('cliente', $data);
        return 0;
    }

    function delete_cliente($rut) {
        $this->db->where('rut_c', $rut);
        $this->db->delete('cliente');
        return 0;
    }

    function delete_cliente_user($rut) {
        $this->db->where('rut_c', $rut);
        $data = array(
            "estado_cliente" => '0',
        );
        $this->db->update('cliente', $data);
        return 0;
    }

    function activar_cliente($rut) {
        $this->db->where('rut_c', $rut);
        $data = array(
            "estado_cliente" => '1',
        );
        $this->db->update('cliente', $data);
        return 0;
    }

    function seleccionar_cliente($rut) {
        $this->db->select('*');
        $this->db->where('rut_c', $rut);
        $this->db->from('cliente');
        return $this->db->get();
    }

    //*******************MANTENEDOR USUARIOS****************************

    function cargar_usuarios() {
        $this->db->select('*');
        $this->db->from('usuario');
        return $this->db->get();
    }

    function insert_usuario($nombre, $user, $pass, $apellido, $tipo) {
        $this->db->select('user');
        $this->db->where('user', $user);
        $cantidad = $this->db->get('usuario')->num_rows();
        if ($cantidad == 0):
            $data = array(
                "user" => $user,
                "pass" => $pass,
                "nombre" => $nombre,
                "apellido" => $apellido,
                "tipo_user" => $tipo,
            );
            $this->db->insert("usuario", $data);
            return 0;
        else:
            return 1;
        endif;
    }

    function update_usuario($id, $nombre, $user, $pass, $apellido, $tipo) {
        $data = array(
            "user" => $user,
            "pass" => $pass,
            "nombre" => $nombre,
            "apellido" => $apellido,
            "tipo_user" => $tipo,
        );
        $this->db->where('id_usuario', $id);
        $this->db->update('usuario', $data);
        return 0;
    }

    function update_usuario_2($id, $nombre, $user, $pass, $apellido, $tipo) {
        $this->db->select('user');
        $this->db->where('user', $user);
        $cantidad = $this->db->get('usuario')->num_rows();
        if ($cantidad == 0):
            $data = array(
                "user" => $user,
                "pass" => $pass,
                "nombre" => $nombre,
                "apellido" => $apellido,
                "tipo_user" => $tipo,
            );
            $this->db->where('id_usuario', $id);
            $this->db->update('usuario', $data);
            return 0;
        else:
            return 1;
        endif;
    }

    function seleccionar_usuario($id) {
        $this->db->select('*');
        $this->db->where('id_usuario', $id);
        $this->db->from('usuario');
        return $this->db->get();
    }

    function delete_usuario($id) {
        $this->db->where('id_usuario', $id);
        $this->db->delete('usuario');
        return 0;
    }

    //******************************FACTURA*****************************+
    function crear_factura($fecha, $hora, $id_user) {
        $data = array(
            "fecha_fac" => $fecha,
            "hora_fac" => $hora,
            "rut_c" => '0-0',
            "estado_fac" => 1,
            "id_usuario" => $id_user,
        );
        $this->db->insert("factura", $data);
        $this->db->select('*');
        $this->db->from('factura');
        $this->db->order_by('num_fac', 'DESC');
        $this->db->limit(1);
        return $this->db->get();
    }

    function insert_datalle_fac($num_fac, $cantidad, $desc, $precio, $total_det) {
        $data = array(
            "cantidad_fac" => $cantidad,
            "detalle_fac" => $desc,
            "precio_fac" => $precio,
            "total_detalle" => $total_det,
            "num_fac" => $num_fac,
        );
        $this->db->insert("detalle_fac", $data);
        $this->db->select('*');
        $this->db->where('num_fac', $num_fac);
        $this->db->from('detalle_fac');
        return $this->db->get();
    }

    function subtotal($num_fac) {
        $this->db->select('subtotal_fac');
        $this->db->where('num_fac', $num_fac);
        $this->db->where('estado_fac', '1');
        return $this->db->get('factura');
    }

    function update_total($num_fac, $subtotal, $neto, $iva, $total) {
        $data = array(
            "subtotal_fac" => $subtotal,
            "neto_fac" => $neto,
            "iva_fac" => $iva,
            "total_fac" => $total,
        );
        $this->db->where('num_fac', $num_fac);
        $this->db->update("factura", $data);
    }

    function delete_detalle_fac($id, $num_fac) {
        $this->db->where('id_detalle_fac', $id);
        $this->db->delete('detalle_fac');
        $this->db->select('*');
        $this->db->where('num_fac', $num_fac);
        $this->db->from('detalle_fac');
        return $this->db->get();
    }

    function update_cliente_fac($rut, $num_fac) {
        $data = array(
            "rut_c" => $rut,
        );
        $this->db->where('num_fac', $num_fac);
        $this->db->where('estado_fac', '1');
        $this->db->update("factura", $data);
    }

    function mantener_factura() {
        $this->db->select('*');
        $this->db->from('factura');
        $this->db->where('estado_fac', 1);
        return $this->db->get();
    }

    function cargar_detalle_fac($num_fac) {
        $this->db->select('*');
        $this->db->where('num_fac', $num_fac);
        $this->db->from('detalle_fac');
        return $this->db->get();
    }

    function mantener_cliente_fac($rut) {
        $this->db->select('*');
        $this->db->where('rut_c', $rut);
        $this->db->from('cliente');
        return $this->db->get();
    }

}
