<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequest;
use Illuminate\Support\Facades\DB;
use Exception;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $limit = $request->input('limit');

        $result = Store::getList($keyword, $limit);

        return $this->responseOK('success', $result);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $params = $request->validated();
        DB::beginTransaction();
        try {
            Store::create($params);

            DB::commit();
            return $this->responseCreated('created');
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Store $store)
    {
        return $this->responseOK('success', $store);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Store $store)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, Store $store)
    {
        $params = $request->validated();
        DB::beginTransaction();
        try {
            $store->update($params);

            DB::commit();
            return $this->responseOK('success');
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Store $store)
    {
        DB::beginTransaction();
        try {
            $store->delete();

            DB::commit();
            return $this->responseOK('success');
        } catch (Exception $e) {
            DB::rollBack();
        }
    }
}
