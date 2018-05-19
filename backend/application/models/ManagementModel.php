<?php
/**
 * Description of Usuarios
 *
 * @author Jaime
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class ManagementModel extends CI_Model
{
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function __destruct() 
    {
        
    }


    // Función genérica para listar los registros de cualquier entidad; puede incluir un
    // criterio de búsqueda por el campo especificado
    public function read($schema, $table, $arrayFields, $field, $data)
    {
        $this->db->select($arrayFields);
        $this->db->from($schema . "." . $table);

        if($field != ""){
            if(gettype($field != "string")){
                $this->db->where($field, $data);                
            }else{
                $this->db->like($field, $data, 'both');
            }
        }
        return $this->db->get(); 
    }


    // Función genérica para eliminar registros por el atributo id 
    public function delete($schema, $table, $id)
    {
        $this->db->where("id", $id);
        $this->db->delete($tabla);
    }

    
    public function totalRecords($schema, $table)
    {
        return $this->db->get($schema . "." . $table)->num_rows();
    }

    
    public function insertarRegistro($tabla, $registro)
    {
        $this->db->insert($tabla, $registro);
    }
    
    public function actualizarRegistro($tabla, $registro, $id)
    {
        $this->db->where("id", $id);
        $this->db->update($tabla, $registro);
    }
    
    
    public function buscarClave($tabla, $campo, $dato)
    {
        $this->db->where("UPPER($campo)", strtoupper($dato));
        return $this->db->get($tabla);
    }


    //Buscar el registro para tomar el nombre de la imagen y eliminar el archivo correspondiente
    // $buscarRegistro = $this->buscarClave($tabla, "id", $id);
    // foreach ($buscarRegistro->result() as $fila)
    // {
    //     unlink(getcwd() . "/assets/images-article/" . $fila->image);
    // }
        
}

?>
