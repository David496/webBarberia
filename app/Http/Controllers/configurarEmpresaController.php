<?php

namespace App\Http\Controllers;

use App\Models\Departamentos;
use App\Models\Distritos;
use App\Models\Empresa;
use App\Models\Provincias;
use Exception;
use Illuminate\Http\Request;

class configurarEmpresaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function configurarEmpresaVista(){

        $grupo_select = Departamentos::all()->pluck('UB_DEPA_NAME', 'UB_DEPA_CODIGO');
        $grupo_select->prepend('[ SELECCIONE DEPARTAMENTO ]', '');
        $data['grupo_select'] = $grupo_select;

        $empresa = Empresa::first();

        return view('configurarEmpresa.configurarEmpresa', compact('data', 'empresa'));
    }

    public function get_distritos(Request $request)
    {
        try {
            $distritos = Distritos::select('UB_DISTRI_CODIGO as codigo', 'UB_DISTRI_NAME as descripcion')->where('UB_PROVI_CODIGO', $request->get_distritos_name)->get();
            $return = [
                'status' => 'success',
                'data' => $distritos
            ];
        } catch (Exception $ex) {
            $return = [
                'status' => 'error',
                'message' => $ex->getMessage()
            ];
        }
        return response()->json($return);
    }


    public function get_provincias(Request $request)
    {
        try {
            $provincias = Provincias::select('UB_PROVI_CODIGO as codigo', 'UB_PROVI_NAME as descripcion')->where('UB_DEPA_CODIGO', $request->get_provincias_name)->get();
            $return = [
                'status' => 'success',
                'data' => $provincias
            ];
        } catch (Exception $ex) {
            $return = [
                'status' => 'error',
                'message' => $ex->getMessage()
            ];
        }
        return response()->json($return);
    }

    public function actualizarEmpresa(Request $request){
        try {
            $empresa = Empresa::first();
            $empresa->razon_social = $request->razonSocial;
            $empresa->nombre_corto = $request->nombreCorto;
            $empresa->direccion = $request->direccion;
            $empresa->ruc = $request->ruc;
            $empresa->telefono = $request->telefono;
            $empresa->correo_electronico = $request->correo;
            $empresa->UBIG_DEPA = $request->departamento;
            $empresa->UBIG_PROVI = $request->provincia;
            $empresa->UBIG_DISTR = $request->distrito;

            if (!$empresa->save()) {
                $msg = '';
                if ($this->ENVIRONMENT_DEBUG) {
                    foreach ($empresa->getMessages() as $message) {
                        $msg = $msg . $message . "</br>\n";
                    }
                } else {
                    $msg = "No se pudo Actualizar la Empresa. </br>\n";
                }
                $return = [
                    'status' => 'error',
                    'titulo' => '¡Registro no completado!',
                    'message' => 'Obtenemos el siguiente error: ' . $msg . '<br /><strong>NO se ha realizado ningún cambio en la base de datos!</strong>'
                ];
                return $return;
            }

            $return = [
                'status' => 'ok',
                'titulo' => '¡Registro Exitoso!',
                'message' => 'Se registró correctamente la información!'
            ];
            return $return;
        } catch (Exception $ex) {
            $return = [
                'status' => 'error',
                'titulo' => '¡Registro no completado!',
                'message' => $ex->getMessage()
            ];
            return $return;
        }
    }
}
