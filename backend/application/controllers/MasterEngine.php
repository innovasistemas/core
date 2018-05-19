<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MasterEngine extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */

    public function __construct() 
    {
        parent::__construct();

        $this->load->helper(array("url", "form"));
        $this->load->library('form_validation');
        $this->load->model("ManagementModel");
    }

    public function __destruct() 
    {

    }

    public function index()
    {
        
    }


    // Función para devolver un listado general de registros en un objeto JSON 
    // Puede incluir un criterio de búsqueda por el campo especificado
    public function listRecords($schema="", $table="", $chainFields="*", $field="", $data="")
    {
        // Separar los campos que se quieran pasar a la consulta separados con guión: -
        $arrayFields = explode("-", $chainFields);
        $objResult = $this->ManagementModel->read($schema, $table, $arrayFields, $field, $data);
        $arrayRecords = [];
        foreach ($objResult->result() as $row){
            $arrayRecords[] = $row;  
        }
        echo json_encode($arrayRecords);
    }


    // Función para eliminar registros de una tabla a partir de su id
    public function deleteRecords($schema="", $table="", $id=0)
    {
        $this->ModeloGestion->delete($schema, $table, $id);
        $arrayResult = array("content" => "Successfully deleted record");
        echo json_encode($arrayResult);
    }


    // Función para devolver el total de registros de una entidad
    public function totalRecords($schema="", $table="")
    {
        echo json_encode(['totalRecords' => $this->ManagementModel->totalRecords($schema, $table)]);
    }

    
    
    
    public function guardarRegistro()
    {
        $id = $this->input->post("id");
        $titulo = $this->input->post("title");
        $descripcion = $this->input->post("description");
        
        
        $this->form_validation->set_rules('title', 'Title', 'required|min_length[3]|max_length[50]');
        $this->form_validation->set_rules('description', 'Description', 'required|min_length[3]|max_length[1000]');
//        $this->form_validation->set_rules('image', 'Image', 'required');
        
        if ($this->form_validation->run() == FALSE)
        {
            $mensaje = validation_errors();
        }
        else
        {
            if($id=="")
            {
                //Cargar imagen
                ///++++++++++++++++++++++++++++++++++
                if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
                {
                    $mensaje = "";

                    //***************************************
                    //Carga de imagen
                    //obtenemos el archivo a subir
                    $file = $_FILES['fleArchivo']['name'];
                    $type = $_FILES['fleArchivo']['type'];
                    $size = $_FILES['fleArchivo']['size'];
                    $error = "";

                    if($file)
                    {
                        //Comprobamos si existe un directorio para subir el archivo, si no es así, lo creamos
                //        if(!is_dir("files/")) 
                //            mkdir("files/", 0777);

                        if(strpos($type, "jpeg") || strpos($type, "png") || strpos($type, "gif"))
                        {
                            //Comprobamos si el archivo ha subido
                            //if (move_uploaded_file($_FILES['fleArchivo']['tmp_name'],"files/".$file))
                            if (move_uploaded_file($_FILES['fleArchivo']['tmp_name'],"../backend/assets/images-article/".$file))
                            {
//                               sleep(2);//retrasamos la petición 2 segundos
//                               $arrayResult["imagen"] = $file; //Devolvemos el nombre del archivo para pintar la imagen
//                               $arrayResult["ext"] = $type; 
//                               $arrayResult["siz"] = $size; 
                                
                                $arrayRegistro =['title'=>$titulo, 'description'=>$descripcion, 'image'=>$file];
                                $this->ModeloGestion->insertarRegistro('article', $arrayRegistro);
                            }
                            else
                            {
                                $error = "Ocurrió un error al subir el archivo";
                            }
                        }
                        else
                        {
                            $error = "Archivo no válido";
                        }


                    }


                    //***************************************

                    //$arrayResult["mensaje"] = $mensaje;
                    //$arrayResult["error"] = $error;

                    //echo $mensaje;
                    //echo json_encode($arrayResult);
                    
                    

                }
                else
                {
                    //throw new Exception("Error Processing Request", 1);   
                    echo "Error Procesando la petición";   
                }

                
            }
            else
            {
                $arrayRegistro =['title'=>$titulo, 'description'=>$descripcion];
                $this->ModeloGestion->actualizarRegistro('article', $arrayRegistro, $id);
            }
            $mensaje = "Saved record";
        }
        
        $arrayDatos = array("contenido" => $mensaje);
        echo json_encode($arrayDatos);
    }
    
    // public function actualizarRegistro($id=0)
    // {
    //     $camposArray = ["*"];
    //     $buscarRegistro = $this->ModeloGestion->buscarClave("article", "id", $id);
    //     foreach ($buscarRegistro->result() as $fila)
    //     {
            
            
    //     }
    //     redirect('http://localhost/PHPWorkshopJaimeMontoya/frontend/articles-new.html');
    // }

    public function actualizarRegistro($id=0)
    {
        $camposArray = ["*"];
        $buscarRegistro = $this->ModeloGestion->buscarClave("article", "id", $id);
        foreach ($buscarRegistro->result() as $fila)
        {
            $arrayDatos = ["id"=> $fila->id, "title"=>$fila->title, "description"=>$fila->description];
        }
        
        echo json_encode($arrayDatos);
        //redirect("http://localhost:8080/PHPWorkshopJaimeMontoya/frontend/articles-new.html");
    }
    
    public function cargarImagen()
    {
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
        {
            $mensaje = "";

            //***************************************
            //Carga de imagen
            //obtenemos el archivo a subir
            $file = $_FILES['fleArchivo']['name'];
            $type = $_FILES['fleArchivo']['type'];
            $size = $_FILES['fleArchivo']['size'];
            $error = "";

            if($file)
            {
                //Comprobamos si existe un directorio para subir el archivo, si no es así, lo creamos
        //        if(!is_dir("files/")) 
        //            mkdir("files/", 0777);

                if(strpos($type, "jpeg") || strpos($type, "png") || strpos($type, "gif"))
                {
                    //Comprobamos si el archivo ha subido
                    //if (move_uploaded_file($_FILES['fleArchivo']['tmp_name'],"files/".$file))
                    if (move_uploaded_file($_FILES['fleArchivo']['tmp_name'],"../backend/assets/images-article/".$file))
                    {
                       sleep(2);//retrasamos la petición 2 segundos
                       $arrayResult["imagen"] = $file; //Devolvemos el nombre del archivo para pintar la imagen
                       $arrayResult["ext"] = $type; 
                       $arrayResult["siz"] = $size; 
                    }   
                }
                else
                {
                    $error = "Archivo no válido";
                }


            }


            //***************************************

            $arrayResult["mensaje"] = $mensaje;
            $arrayResult["error"] = $error;

            //echo $mensaje;
            echo json_encode($arrayResult);

        }
        else
        {
            //throw new Exception("Error Processing Request", 1);   
            echo "Error Procesando la petición";   
        }

    }
}
