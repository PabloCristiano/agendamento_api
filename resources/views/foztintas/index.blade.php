<!-- @extends('layouts.app') -->
@section('content')
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 10px; text-align: center;">
            <h3>Total de Vouchers</h3>
            <p style="font-size: 24px; font-weight: bold; margin-top: 10px;">150</p>
        </div>
        
        <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 20px; border-radius: 10px; text-align: center;">
            <h3>Vouchers Ativos</h3>
            <p style="font-size: 24px; font-weight: bold; margin-top: 10px;">120</p>
        </div>
        
        <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 20px; border-radius: 10px; text-align: center;">
            <h3>Vouchers Hoje</h3>
            <p style="font-size: 24px; font-weight: bold; margin-top: 10px;">12</p>
        </div>
    </div>
    
    <div style="display: flex; gap: 15px; margin-bottom: 30px; justify-content: center;">
        <a href="/cadastro-voucher" class="btn btn-primary">Novo Cadastro Voucher</a>
        <!-- <a href="/cadastro-voucher" class="btn btn-success">Ver Vouchers -->
        <a href="/reimprimir" class="btn btn-warning">Reimprimir Voucher</a>
    </div>


@endsection   