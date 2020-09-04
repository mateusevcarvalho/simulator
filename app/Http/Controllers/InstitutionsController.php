<?php

namespace App\Http\Controllers;

use App\Http\Requests\SimulateRequest;
use Illuminate\Http\Request;

class InstitutionsController extends Controller
{
    public function index()
    {
        $institutions = convert_file_json_to_array(path_data('instituicoes.json'));
        return response()->json($institutions);
    }

    public function simulate(SimulateRequest $request)
    {
        $formData = $request->all();
        $feesInstitutions = convert_file_json_to_array(path_data('taxas_instituicoes.json'));
        $institutions = convert_file_json_to_array(path_data('instituicoes.json'));
        $response = [];

        foreach ($institutions as $institution) {
            $feesInstitution = array_filter($feesInstitutions, function ($item) use ($institution) {
                return $item['instituicao'] === $institution['chave'];
            });

            $dataInstitutions = [];
            foreach ($feesInstitution as $item) {
                array_push($dataInstitutions, [
                    'taxas' => $item['taxaJuros'],
                    'parcelas' => $item['parcelas'],
                    'valor_parcela' => round($formData['valor_emprestimo'] * $item['coeficiente'], 2),
                    'convenio' => $item['convenio']
                ]);
            }

            usort($dataInstitutions, function ($a, $b) {
                return $a['parcelas'] > $b['parcelas'];
            });

            array_push($response, [
                $institution['chave'] => $dataInstitutions
            ]);
        }

        return response()->json($response);


    }
}
