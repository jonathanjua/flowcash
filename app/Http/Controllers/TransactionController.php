<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Requests\TransactionStoreRequest;
use App\Http\Requests\TransactionUpdateRequest;

class TransactionController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Transaction::class);

        $search = $request->get('search', '');

        $transactions = Transaction::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.transactions.index',
            compact('transactions', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Transaction::class);

        $categories = Category::pluck('name', 'id');
        $users = User::pluck('name', 'id');

        return view('app.transactions.create', compact('categories', 'users'));
    }

    /**
     * @param \App\Http\Requests\TransactionStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionStoreRequest $request)
    {
        $this->authorize('create', Transaction::class);

        $validated = $request->validated();

        $transaction = Transaction::create($validated);

        return redirect()
            ->route('transactions.edit', $transaction)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Transaction $transaction)
    {
        $this->authorize('view', $transaction);

        return view('app.transactions.show', compact('transaction'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        $categories = Category::pluck('name', 'id');
        $users = User::pluck('name', 'id');

        return view(
            'app.transactions.edit',
            compact('transaction', 'categories', 'users')
        );
    }

    /**
     * @param \App\Http\Requests\TransactionUpdateRequest $request
     * @param \App\Models\Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(
        TransactionUpdateRequest $request,
        Transaction $transaction
    ) {
        $this->authorize('update', $transaction);

        $validated = $request->validated();

        $transaction->update($validated);

        return redirect()
            ->route('transactions.edit', $transaction)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Transaction $transaction)
    {
        $this->authorize('delete', $transaction);

        $transaction->delete();

        return redirect()
            ->route('transactions.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
