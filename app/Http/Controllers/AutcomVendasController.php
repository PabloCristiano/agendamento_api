<?php

namespace App\Http\Controllers;

use App\Models\AutcomVendas;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;

class AutcomVendasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
    {
        
        // $query = AutcomVendas::query();

        // Aplicar filtros se fornecidos
        // if ($request->filled('empresa')) {
        //     $query->porEmpresa($request->empresa);
        // }

        // if ($request->filled('vendedor')) {
        //     $query->porVendedor($request->vendedor);
        // }

        // if ($request->filled('cliente')) {
        //     $query->porCliente($request->cliente);
        // }

        // if ($request->filled('data_inicio') && $request->filled('data_fim')) {
        //     $query->porPeriodo($request->data_inicio, $request->data_fim);
        // }

        // if ($request->boolean('sem_bonificacao')) {
        //     $query->semBonificacao();
        // }

        // // Ordenação
        // $query->orderBy('det_dtadoc', 'desc');

        // $vendas = $query->paginate(50);

        // if ($request->wantsJson()) {
        //     return response()->json($vendas);
        // }

        return view('cadastroVoucher.cadastro-voucher');
    }

    public function reimprimir(): View
    {
        return view('cadastroVoucher.reimpressao-voucher');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('autcom-vendas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'det_codemp' => 'required|string|max:10',
            'det_codven' => 'nullable|string|max:20',
            'det_codite' => 'nullable|string|max:50',
            'det_codcli' => 'nullable|string|max:20',
            'det_numdoc' => 'nullable|string|max:20',
            'det_espdoc' => 'nullable|string|max:10',
            'det_dtadoc' => 'required|date',
            'det_qtdite' => 'nullable|numeric',
            'det_totite' => 'nullable|numeric',
            'cli_nomcli' => 'nullable|string|max:100',
            'cli_cgccpf' => 'nullable|string|max:20',
            'fornecedor' => 'nullable|string|max:100',
        ]);

        $venda = AutcomVendas::create($validated);

        return response()->json([
            'message' => 'Venda criada com sucesso!',
            'data' => $venda
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(AutcomVendas $autcomVenda): View|JsonResponse
    {
        if (request()->wantsJson()) {
            return response()->json($autcomVenda);
        }

        return view('autcom-vendas.show', compact('autcomVenda'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AutcomVendas $autcomVenda): View
    {
        return view('autcom-vendas.edit', compact('autcomVenda'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AutcomVendas $autcomVenda): JsonResponse
    {
        $validated = $request->validate([
            'det_codemp' => 'required|string|max:10',
            'det_codven' => 'nullable|string|max:20',
            'det_codite' => 'nullable|string|max:50',
            'det_codcli' => 'nullable|string|max:20',
            'det_numdoc' => 'nullable|string|max:20',
            'det_espdoc' => 'nullable|string|max:10',
            'det_dtadoc' => 'required|date',
            'det_qtdite' => 'nullable|numeric',
            'det_totite' => 'nullable|numeric',
            'cli_nomcli' => 'nullable|string|max:100',
            'cli_cgccpf' => 'nullable|string|max:20',
            'fornecedor' => 'nullable|string|max:100',
        ]);

        $autcomVenda->update($validated);

        return response()->json([
            'message' => 'Venda atualizada com sucesso!',
            'data' => $autcomVenda
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AutcomVendas $autcomVenda): JsonResponse
    {
        $autcomVenda->delete();

        return response()->json([
            'message' => 'Venda removida com sucesso!'
        ]);
    }

    /**
     * Relatório de vendas por vendedor
     */
    public function relatorioVendedor(Request $request): JsonResponse
    {
        $request->validate([
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date',
            'empresa' => 'nullable|string'
        ]);

        $query = AutcomVendas::query()
            ->selectRaw('
                det_codven,
                COUNT(*) as total_vendas,
                SUM(det_qtdite) as quantidade_total,
                SUM(valor_total) as valor_total_vendas,
                AVG(valor_total) as ticket_medio
            ')
            ->porPeriodo($request->data_inicio, $request->data_fim)
            ->semBonificacao()
            ->groupBy('det_codven');

        if ($request->filled('empresa')) {
            $query->porEmpresa($request->empresa);
        }

        $relatorio = $query->get();

        return response()->json($relatorio);
    }

    /**
     * Relatório de vendas por cliente
     */
    public function relatorioCliente(Request $request): JsonResponse
    {
        $request->validate([
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date',
            'empresa' => 'nullable|string'
        ]);

        $query = AutcomVendas::query()
            ->selectRaw('
                det_codcli,
                cli_nomcli,
                cli_cgccpf,
                COUNT(*) as total_compras,
                SUM(det_qtdite) as quantidade_total,
                SUM(valor_total) as valor_total_compras,
                MAX(det_dtadoc) as ultima_compra
            ')
            ->porPeriodo($request->data_inicio, $request->data_fim)
            ->semBonificacao()
            ->groupBy(['det_codcli', 'cli_nomcli', 'cli_cgccpf']);

        if ($request->filled('empresa')) {
            $query->porEmpresa($request->empresa);
        }

        $relatorio = $query->get();

        return response()->json($relatorio);
    }

    /**
     * Dashboard com resumo de vendas
     */
    public function dashboard(Request $request): JsonResponse
    {
        $dataInicio = $request->get('data_inicio', now()->startOfMonth());
        $dataFim = $request->get('data_fim', now()->endOfMonth());

        $resumo = AutcomVendas::query()
            ->porPeriodo($dataInicio, $dataFim)
            ->semBonificacao()
            ->selectRaw('
                COUNT(*) as total_vendas,
                SUM(valor_total) as faturamento_total,
                AVG(valor_total) as ticket_medio,
                COUNT(DISTINCT det_codcli) as clientes_unicos,
                COUNT(DISTINCT det_codven) as vendedores_ativos
            ')
            ->first();

        // Top 10 clientes do período
        $topClientes = AutcomVendas::query()
            ->porPeriodo($dataInicio, $dataFim)
            ->semBonificacao()
            ->selectRaw('cli_codcli, cli_nomcli, SUM(valor_total) as total')
            ->groupBy(['cli_codcli', 'cli_nomcli'])
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // Vendas por dia
        $vendasPorDia = AutcomVendas::query()
            ->porPeriodo($dataInicio, $dataFim)
            ->semBonificacao()
            ->selectRaw('DATE(det_dtadoc) as data, SUM(valor_total) as total')
            ->groupBy('data')
            ->orderBy('data')
            ->get();

        return response()->json([
            'resumo' => $resumo,
            'top_clientes' => $topClientes,
            'vendas_por_dia' => $vendasPorDia
        ]);
    }
}