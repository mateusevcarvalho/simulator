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

            $response[$institution['chave']] = $dataInstitutions;
        }

        if (is_array($formData['instituicoes']) && count($formData['instituicoes'])) {
            $newResponse = [];
            foreach ($formData['instituicoes'] as $institution) {
                $newResponse[$institution] = $response[$institution];
            }
            $response = $newResponse;
        }

        if ($formData['parcela']) {
            $newResponse = [];
            $keys = array_keys($response);
            foreach ($keys as $key) {
                $data = $response[$key];
                $dataFilter = array_filter($data, function ($item) use ($formData) {
                    return $item['parcelas'] === $formData['parcela'];
                });

                $newResponse[$key] = $dataFilter;
            }

            $response = $newResponse;
        }

        return response()->json($response);


    }
}
