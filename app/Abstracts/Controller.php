<?php

namespace App\Abstracts;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const SORT_ASC = 'asc';
    const SORT_DESC = 'desc';

    /**
     * Wrap the response
     *
     * @param array $response   the return response
     * @param int   $statusCode the return status code
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    protected function response($response, $statusCode = Response::HTTP_OK): JsonResponse
    {
        return response()->json(
            $response,
            $statusCode
        );
    }

    /**
     * Collect the objects and do a pagination if the request has the necessary
     * queries
     *
     */
    protected function collect($model)
    {
        $request = request();

        if ($this->isPaginated()) {
            $limit = $request->input('limit', 10);
            $page = $request->input('page', 1);

            return $model->paginate(
                $limit,
                ['*'],
                'page',
                $page
            );
        }

        return $model->get();
    }

    protected function isPaginated(): bool
    {
        $request = request();

        return ($request->has('limit') && is_numeric($request->input('limit')))
            || ($request->has('page') && is_numeric($request->input('page')));
    }

    protected function fireEvent(string $event, array $data): void
    {
        $data['subject'] = $event;

        Event::dispatch($event, compact('data'));
    }

    protected function sendGeneralErrorResponse($message = null, $responseCode = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        return $this->response(
            [
                'status' => 'failed',
                'code' => Response::HTTP_BAD_REQUEST,
                'message' => $message ?? __('response.error.general')
            ],
            $responseCode
        );
    }

    /**
     * @param mixed $items
     * @param int $totalItems
     * @param int $perPage
     * @param mixed $currentPage
     * @param array $options (path | meta)
     */
    protected function customPagination($items, $totalItems, $perPage, $currentPage = null, array $options = [])
    {
        $paginate = new LengthAwarePaginator(
            $items,
            $totalItems,
            $perPage,
            $currentPage,
            $options
        );

        return $this->response(
            [
                'data' => $paginate->items(),
                'links' => [
                    'first' => $paginate->url(1),
                    'last' => $paginate->url($paginate->lastPage()),
                    'prev' => $paginate->previousPageUrl(),
                    'next' => $paginate->nextPageUrl(),
                ],
                'meta' => array_merge([
                    'current_page' => $paginate->currentPage(),
                    'from' => $paginate->firstItem(),
                    'path' => $paginate->path(),
                    'per_page' => $paginate->perPage(),
                    'to' => $paginate->lastItem(),
                    'total' => $paginate->total()
                ], $options['meta'] ?? [])
            ]
        );
    }
}
