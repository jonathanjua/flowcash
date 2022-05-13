<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\TransactionCollection;

class CategoryTransactionsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Category $category)
    {
        $this->authorize('view', $category);

        $search = $request->get('search', '');

        $transactions = $category
            ->transactions()
            ->search($search)
            ->latest()
            ->paginate();

        return new TransactionCollection($transactions);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Category $category)
    {
        $this->authorize('create', Transaction::class);

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'description' => ['required', 'max:255', 'string'],
            'date' => ['required', 'date'],
            'status' => ['required', 'numeric'],
            'type' => ['required', 'numeric'],
            'value' => ['required', 'numeric'],
        ]);

        $transaction = $category->transactions()->create($validated);

        return new TransactionResource($transaction);
    }
}
