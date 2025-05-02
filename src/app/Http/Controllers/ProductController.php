<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Season;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProductController extends Controller
{
    public function list(Request $request)
    {
        $query = $request->input('search');

        $products = Product::when($query, function ($queryBuilder) use ($query) {
            return $queryBuilder->where('name', 'like', "%{$query}%");
        })->paginate(6);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/img');
            $filename = basename($path);
        }
        return view('products.list', compact('products', 'query'));
    }

    public function search(Request $request)
    {
        if ($request->has('reset')) {
            return redirect('/products/search')->withInput();
        }

        $query = Product::query();

        $query = $this->getSearchQuery($request, $query);

        if ($request->has('order')) {
            $query->orderBy('price', $request->order == 'high' ? 'desc' : 'asc');
        }

        $products = $query->paginate(6);
        $title = !empty($request->name) ? "”{$request->name}”の商品一覧" : "商品一覧";
        $isSearching = !empty($request->name);

        return view('products.list', compact('products', 'title','isSearching'));
    }

    private function getSearchQuery($request, $query)
    {
        if(!empty($request->name)) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }

        return $query;
    }

    public function show($id)
    {
        $product = Product::find($id);

        $seasons = Season::all();

        $selectedSeasons = [$product->season_id];

        return view('products.details', compact('product', 'seasons', 'selectedSeasons'));
    }

    public function destroy(Request $request)
    {
        Product::find($request->id)->delete();
        return redirect('/products');
    }

    public function update(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->only(['name', 'price', 'description', 'season_id', 'image']);

        if (isset($data['season_id'])) {
            $data['season_id'] = is_array($data['season_id']) ? $data['season_id'][0] : $data['season_id'];
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/img');
            $data['image'] = basename($path);
        }

        $product->fill($data);
        $product->save();

        return redirect('/products');
    }

    public function register()
    {
        $seasons = Season::all();
        return view('products.register', compact('seasons'));
    }

    public function store(ProductRequest $request)
    {
        $seasonIds = $request->input('seasons', []);

        $seasonIdString = implode(',', $seasonIds);

        Product::create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'season_id' => $seasonIdString,
            'image' => $request->file('image'),
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/img');
            $filename = basename($path);
            $data['image'] = 'storage/img/' . $filename;
        }
        return redirect()->route('products.list');
    }



}
