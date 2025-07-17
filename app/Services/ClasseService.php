<?php

namespace App\Services;

use App\DTOs\ClasseDto;
use App\Http\Resources\ClasseResource;
use App\Models\Classe;
use App\Models\ClasseContent;
use App\Models\ContentType;
use App\Models\Module;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClasseService
{
    private ModuleService $moduleService;

    public function __construct()
    {
        $this->moduleService = new ModuleService();
    }


    public function getAll()
    {
        return ClasseResource::collection(
            Classe::orderBy('order')
                ->paginate(15)
        );
    }

    public function getOne(string $id)
    {
        return Classe::where('public_id', $id)->firstOrFail();
    }

    /**
     * @throws Exception
     */
    public function create(Request $request)
    {
        $payload = json_decode($request->input('data'), true);

        $classe = DB::transaction(function () use ($payload, $request) {
            $module = $this->moduleService->getOne($payload['module_id']);

            $newClasse = Classe::create([
                'public_id' => uuid_create(),
                'module_id' => $module->id,
                'title'     => $payload['title'],
                'order'     => $payload['order'],
            ]);

            if (isset($payload['contents']) && is_array($payload['contents'])) {
                // Usamos o $index para construir a chave do arquivo
                foreach ($payload['contents'] as $index => $contentBlock) {

                    $contentData = [];

                    switch ($contentBlock['content_type_id']) {
                        case 1: // Vídeo
                            $contentData = $contentBlock['content_data'];
                            break;
                        case 2: // Texto
                            $contentData = $contentBlock['content_data'];
                            break;
                        case 5: // Arquivo
                            // 1. Constrói a chave dinâmica que o frontend está enviando (ex: 'files.0')
                            $fileKey = "files_{$index}";
                            // 2. Usa a chave dinâmica para verificar se o arquivo existe
                            if ($request->hasFile($fileKey)) {
                                $file = $request->file($fileKey);
                                $path = $file->store('uploads/aulas', 'public');
                                $contentData = [
                                    'file_path' => $path,
                                    'file_name' => $file->getClientOriginalName()
                                ];
                            }
                            break;
                    }

                    $newClasse->contents()->create([
                        'public_id' => uuid_create(),
                        'content_type_id' => $contentBlock['content_type_id'],
                        'order' => $contentBlock['order'],
                        'content' => json_encode($contentData)
                    ]);
                }
            }

            // Retorna a aula com todos os conteúdos para a variável $classe
            return $newClasse->load('contents');
        });

        return $classe;
    }
//    public function create(ClasseDto $classeDto, int $authUserId)
//    {
//        // Usando transação para garantir integridade no banco
//        // Futuramente pretendo atualizar o projeto para substituir o mal uso de try-catch ( mybad )
//        return DB::transaction(function () use ($classeDto, $authUserId) {
//            $module = $this->moduleService->getOne($classeDto->module_id);
//
//            if(!$module || $module->course->creator_id !== $authUserId) {
//                throw new Exception("Acesso negado.", 403);
//            }
//
//            $classe = Classe::create([
//                'public_id' => uuid_create(),
//                'module_id' => $module->id,
//                'title' =>  $classeDto->title,
//                'order' => $classeDto->order,
//                'url_content' => $classeDto->url_content,
//                'text_content' => $classeDto->text_content,
//                'file_path' => $classeDto->file_path,
//                'original_file_name' => $classeDto->original_file_name,
//            ]);
//
//            foreach($classeDto->contents as $content) {
//                $classe->contents()->create([
//                    'public_id' => uuid_create(),
//                    'content_type_id' => $content['content_type_id'],
//                    'order' => $content['order'],
//                    'content' => json_encode($content['content_data']),
//                ]);
//            }
//            return $classe->load('contents');
//        });
//    }

    public function update(Request $request, string $id)
    {
        $classe = Classe::where('public_id', $id)->firstOrFail();
        if($classe){
            $classe->update([
               'title' => $request->get('title'),
               'order' => $request->get('order'),
            ]);
            return $classe;
        }
        return false;
    }

    public function delete(string $id)
    {
        $classe = $this->getOne($id);
        $classe->delete();
    }
}
