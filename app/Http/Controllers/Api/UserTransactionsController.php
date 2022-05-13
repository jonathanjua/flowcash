<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\TransactionCollection;

class UserTransactionsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $transactions = $user
            ->transactions()
            ->search($search)
            ->latest()
            ->paginate();

        return new TransactionCollection($transactions);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', Transaction::class);

        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['required', 'max:255', 'string'],
            'date' => ['required', 'date'],
            'status' => ['required', 'numeric'],
            'type' => ['required', 'numeric'],
            'value' => ['required', 'numeric'],
        ]);

        $transaction = $user->transactions()->create($validated);

        return new TransactionResource($transaction);
    }
}
