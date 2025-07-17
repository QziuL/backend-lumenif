<?php

namespace App\Services;

use App\DTOs\ModuleDto;
use App\Http\Resources\ModuleResource;
use App\Models\Module;
use Exception;
use Illuminate\Http\Request;

class ModuleService
{
    private CourseService $courseService;

    public function __construct()
    {
        $this->courseService = new CourseService();
    }

    public function getAll()
    {
        return ModuleResource::collection(
            Module::with('course')
            ->orderBy('order')
            ->paginate(15)
        );
    }

    public function getOne(string $public_id)
    {
        return Module::where('public_id', $public_id)->firstOrFail();
    }

    /**
     * @throws Exception
     */
    public function create(ModuleDto $moduleDto, int $authUserId)
    {
        $course = $this->courseService->getOneForCreateOrUpdate($moduleDto->course_id);
        if(!$course ||  $course->creator_id  !== $authUserId)
            throw new Exception("Acesso negado.");
        return Module::create([
            'public_id' => uuid_create(),
            'course_id' => $course->id,
            'title' => $moduleDto->title,
            'description' => $moduleDto->description,
            'order' => $moduleDto->order,
        ]);
    }

    public function update(Request $request, string $public_id)
    {
        $module = Module::where('public_id', $public_id)->first();

        if($module){
            $module->update([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'order' => $request->input('order'),
            ]);
            return $module;
        }

        return false;
    }

    public function delete($public_id): void
    {
        $module = $this->getOne($public_id);
        $module->delete();
    }

}
