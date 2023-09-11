<?php

namespace App\Http\Controllers\Api\Merchant;

use App\Dto\Merchant\CreateShopDto;
use App\Filters\ShopFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\ShopStoreRequest;
use App\Http\Resources\Merchant\ShopListsResource;
use App\Http\Resources\Merchant\ShopSingleResource;
use App\Models\Merchant\Merchant;
use App\Models\Merchant\Shop;
use App\Services\Merchant\ShopService;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function __construct(
        protected ShopService $service
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(ShopFilter $filter)
    {
        /**
         * @var Merchant $merchant
         */
        $merchant = request()->user('api-merchant');

        return response()->success(ShopListsResource::collection($merchant->shopsRelation()->filter($filter)->get()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShopStoreRequest $request)
    {
        $shop = $this->service->createOrUpdate(new CreateShopDto(
            merchant_id: $request->user('api-merchant')->getKey(),
            address: $request->get('address'),
            schedule: $request->get('schedule'),
            latitude: $request->get('latitude'),
            longitude: $request->get('longitude'),
            status: $request->get('status')
        ));

        return response()->success(new ShopSingleResource($shop));
    }

    /**
     * Display the specified resource.
     */
    public function show(Shop $shop)
    {
        return response()->success(new ShopSingleResource($shop));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ShopStoreRequest $request, Shop $shop)
    {
        $shop = $this->service->createOrUpdate(new CreateShopDto(
            merchant_id: $request->user('api-merchant')->getKey(),
            address: $request->get('address'),
            schedule: $request->get('schedule'),
            latitude: $request->get('latitude'),
            longitude: $request->get('longitude'),
            status: $request->get('status'),
            id: $shop->id
        ));

        return response()->success(new ShopSingleResource($shop));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shop $shop)
    {
        $shop->delete();

        return response()->success('Successfully deleted');
    }
}
