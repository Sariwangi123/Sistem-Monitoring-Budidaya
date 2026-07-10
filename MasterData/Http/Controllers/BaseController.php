<?php

namespace MasterData\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use MasterData\Http\Requests\BaseRequest;
use MasterData\Services\BaseService;

abstract class BaseController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    protected BaseService $service;
    protected string $resourceClass;
    protected string $requestClass;

    public function __construct(
        BaseService $service,
        string $resourceClass,
        string $requestClass
    ) {
        $this->service = $service;
        $this->resourceClass = $resourceClass;
        $this->requestClass = $requestClass;
    }

    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->get('per_page', 20);

        if ($request->has('search')) {
            $data = $this->service->search($request->get('search'), $perPage);
        } else {
            $data = $this->service->getPaginated($perPage);
        }

        return call_user_func([$this->resourceClass, 'collection'], $data);
    }

    public function show(string $uuid): JsonResource
    {
        $model = $this->service->findByUuid($uuid);

        if (!$model) {
            abort(404, 'Resource not found');
        }

        return new $this->resourceClass($model);
    }

    public function store(Request $request): JsonResponse
    {
        $formRequest = app($this->requestClass);
        $formRequest->validate($request->all());

        $model = $this->service->create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data created successfully',
            'data' => new $this->resourceClass($model),
        ], 201);
    }

    public function update(Request $request, string $uuid): JsonResource
    {
        $model = $this->service->findByUuid($uuid);

        if (!$model) {
            abort(404, 'Resource not found');
        }

        $formRequest = app($this->requestClass);
        $formRequest->validate($request->all());

        $model = $this->service->update($model->id, $request->all());

        return new $this->resourceClass($model);
    }

    public function destroy(string $uuid): JsonResponse
    {
        $model = $this->service->findByUuid($uuid);

        if (!$model) {
            abort(404, 'Resource not found');
        }

        $this->service->delete($model->id);

        return response()->json([
            'success' => true,
            'message' => 'Data deleted successfully',
        ]);
    }

    public function restore(string $uuid): JsonResponse
    {
        $model = $this->service->findTrashedByUuid($uuid);

        if (!$model) {
            abort(404, 'Resource not found');
        }

        $model->restore();

        return response()->json([
            'success' => true,
            'message' => 'Data restored successfully',
            'data' => new $this->resourceClass($model),
        ]);
    }

    public function forceDelete(string $uuid): JsonResponse
    {
        $model = $this->service->findTrashedByUuid($uuid);

        if (!$model) {
            abort(404, 'Resource not found');
        }

        $model->forceDelete();

        return response()->json([
            'success' => true,
            'message' => 'Data permanently deleted',
        ]);
    }
}
