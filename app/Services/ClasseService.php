<?php

namespace App\Services;

use App\DTOs\ClasseDto;
use App\Http\Resources\ClasseResource;
use App\Models\Classe;
use App\Models\ContentType;
use App\Models\Module;
use Exception;
use Illuminate\Http\Request;

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
        return Classe::where('public_id', $id)->first();
    }

    /**
     * @throws Exception
     */
    public function create(ClasseDto $classDto, int $authUserId)
    {
        $module = $this->moduleService->getOne($classDto->module_id);
        $contentType = ContentType::where('id', $classDto->content_type_id)->first();

        if(!$module || !$contentType || $module->course->creator_id !== $authUserId)
            throw new Exception("Acesso negado.");
        return Classe::create([
            'public_id' => uuid_create(),
            'module_id' => $module->id,
            'content_type_id' => $contentType->id,
            'title' =>  $classDto->title,
            'duration_seconds'  => $classDto->duration_seconds,
            'url_content' => $classDto->url_content,
            'text_content' => $classDto->text_content,
            'order' => $classDto->order,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $classe = Classe::where('public_id', $id)->first();
        if($classe){
            $classe->update([
               'title' => $request->get('title'),
               'duration_seconds' => $request->get('duration_seconds'),
               'url_content' => $request->get('url_content'),
               'text_content' => $request->get('text_content'),
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
