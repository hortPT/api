<?php

declare(strict_types=1);

namespace VOSTPT\Http\Controllers;

use Illuminate\Http\JsonResponse;
use VOSTPT\Filters\Contracts\CountyFilter;
use VOSTPT\Http\Requests\County\Index;
use VOSTPT\Http\Requests\County\View;
use VOSTPT\Http\Serializers\CountySerializer;
use VOSTPT\Models\County;
use VOSTPT\Repositories\Contracts\CountyRepository;

class CountyController extends Controller
{
    /**
     * Index Counties.
     *
     * @param Index            $request
     * @param CountyFilter     $filter
     * @param CountyRepository $countyRepository
     *
     * @throws \InvalidArgumentException
     * @throws \OutOfBoundsException
     * @throws \RuntimeException
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Index $request, CountyFilter $filter, CountyRepository $countyRepository): JsonResponse
    {
        $filter->setSortColumn($request->input('sort', $filter->getSortColumn()));
        $filter->setSortOrder($request->input('order', $filter->getSortOrder()));
        $filter->setPageNumber((int) $request->input('page.number', $filter->getPageNumber()));
        $filter->setPageSize((int) $request->input('page.size', $filter->getPageSize()));

        if ($request->has('ids')) {
            $filter->withIds(...$request->input('ids', []));
        }

        if ($request->has('search')) {
            $filter->withSearch($request->input('search'), (bool) $request->input('exact', false));
        }

        if ($request->has('districts')) {
            $filter->withDistricts(...$request->input('districts', []));
        }

        return response()->paginator($countyRepository->getPaginator($filter), new CountySerializer(), [
            'district',
        ]);
    }

    /**
     * View a County.
     *
     * @param View   $request
     * @param County $county
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(View $request, County $county): JsonResponse
    {
        return response()->resource($county, new CountySerializer(), [
            'district',
        ]);
    }
}
