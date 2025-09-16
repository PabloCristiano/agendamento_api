<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\VendasVoucherController;



class DashboardController extends Controller
{
    protected $voucherController;
    protected $vendasVoucherController;


    public function __construct()
    {
        $this->voucherController = new VoucherController();
        $this->vendasVoucherController = new VendasVoucherController();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalVouchers = $this->voucherController->totalVouchers();
        $loja007Vouchers = $this->voucherController->totalLoja007();
        $loja011Vouchers = $this->voucherController->totalLoja011();
        // $vendasEmpresas007e011 = $this->vendasVoucherController->vendasEmpresas_007_011();
        // $clientes = collect($vendasEmpresas007e011)->map(function ($item) {
        //     return [
        //     'CLIENTE' => $item['CLIENTE'] ?? null,
        //     'CPF_CNPJ' => $item['CPF_CNPJ'] ?? null,
        //     'CPF_CNPJ_FORMATADO' => $item['CPF_CNPJ_FORMATADO'] ?? null,
        //     ];
        // });
        // dd($clientes);
        $vouchers = Voucher::orderBy('id', 'desc')->paginate(5);
        return view('app.dashboard', compact('totalVouchers', 'loja007Vouchers', 'loja011Vouchers', 'vouchers'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
