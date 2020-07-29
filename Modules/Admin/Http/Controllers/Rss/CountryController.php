<?php

namespace Modules\Admin\Http\Controllers\Rss;

use App\Models\Rss\Country;
use Cacher;
use Modules\Admin\Http\Controllers\Controller;
use Modules\Admin\Http\Requests\Rss\CountryRequest;
use Modules\Admin\Http\Requests\Rss\SortRequest;

class CountryController extends Controller
{
    public function index()
    {
        $this->seo()->setTitle('Countries');

        $countries = Country::ordered()->get();

        share(compact('countries'));

        return view('admin::rss.countries.index');
    }

    public function create()
    {
        $this->seo()->setTitle('Create a new country');

        return view('admin::rss.countries.form');
    }

    public function store(CountryRequest $request)
    {
        $country = new Country($request->validated());
        $country->save();

        return response()->json([
            'status' => 'Country has been created',
            'id' => $country->id
        ], 201);
    }

    public function edit(Country $country)
    {
        $this->seo()->setTitle('Edit a country');

        share(compact('country'));

        return view('admin::rss.countries.form');
    }

    public function update(CountryRequest $request, Country $country)
    {
        $country->update($request->validated());

        return response()->json(['status' => 'Country has been updated', 'country' => $country]);
    }

    public function destroy(Country $country)
    {
        $country->delete();
        return response()->json(['status' => 'Country has been deleted']);
    }

    public function sort(SortRequest $request)
    {
        $order = $request->input('order');
        Country::setNewOrder($order);
        Cacher::countiesForHeader();
        return response()->json(['status' => 'Countries has been sorted']);
    }
}
