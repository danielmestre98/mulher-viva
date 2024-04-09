<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Drads;
use App\Models\Municipio;
use App\Models\StatusCodes;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();


        $csvMunicipios = Storage::disk("local")->get("/seeders/municipios.csv");
        $rowsMunicipios = array_map('str_getcsv', explode("\n", $csvMunicipios));
        $header = array_shift($rowsMunicipios);
        $header = str_replace("\"", "", $header[0]);
        $header = explode(";", $header);

        foreach ($rowsMunicipios as $row) {
            $row = explode(";", $row[0]);
            $data = array_combine($header, $row);
            Municipio::insert([
                'id' => $data['id'],
                'nome' => $data['nome'],
                'ibge' => $data['ibge'],
                'drads_id' => $data['drads_id'],
                'uf' => $data['uf'],
            ]);
        }


        $csvDrads = Storage::disk("local")->get("/seeders/drads.csv");
        $rowsDrads = array_map('str_getcsv', explode("\n", $csvDrads));
        $header = array_shift($rowsDrads);
        $header = str_replace("\"", "", $header[0]);
        $header = explode(";", $header);
        foreach ($rowsDrads as $row) {
            $row = explode(";", $row[0]);
            $data = array_combine($header, $row);
            $data["cep"] = str_replace("\"", "", $data["cep"]);
            Drads::create([
                'id' => $data['id'],
                'nome' => $data['nome'],
                'bairro' => $data['bairro'],
                'endereco' => $data['endereco'],
                'telefone' => $data['telefone'],
                'cep' => $data['cep'],
                'diretor' => $data['diretor'],
                'id_municipio' => $data['id_municipio'],
                'cod_uge' => $data['cod_uge'],
            ]);
        }

        StatusCodes::create([
            "name" => "Aprovado",
        ]);
        StatusCodes::create([
            "name" => "Pendente",
        ]);
        StatusCodes::create([
            "name" => "Recusado",
        ]);
        StatusCodes::create([
            "name" => "Não elegível",
        ]);
    }
}
