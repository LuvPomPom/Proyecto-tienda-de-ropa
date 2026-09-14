<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VOGA STORE - Envíos</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <main>
        <h1>Envíos y Pago</h1>

        <!-- Muestra errores de validación si faltan datos -->
        @if ($errors->any())
            <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 15px;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('error'))
            <p style="color: red;">{{ session('error') }}</p>
        @endif

        <form id="form-envio" action="{{ route('pedido.procesar') }}" method="POST">
            @csrf

            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required> <br>

            <label for="apellido">Apellido</label>
            <input type="text" id="apellido" name="apellido" value="{{ old('apellido') }}" required> <br>

            <!-- Campo Requerido por la tabla clientes en Supabase -->
            <label for="email">Correo electrónico</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required> <br>

            <label for="fec_nac">Fecha de nacimiento</label>
            <input type="date" id="fec_nac" name="fec_nac" value="{{ old('fec_nac') }}" required> <br>

            <label for="telf">Teléfono</label>
            <input type="text" id="telf" name="telf" value="{{ old('telf') }}" required> <br>

            <label for="direc">Dirección</label>
            <input type="text" id="direc" name="direc" value="{{ old('direc') }}" required> <br>

            <!-- Campo Método de Pago vinculado a Supabase -->
            <label for="metodo_pago">Método de pago</label>
            <select id="metodo_pago" name="metodo_pago_id" required>
                <option value="" disabled {{ old('metodo_pago_id') ? '' : 'selected' }}>Seleccione un método de pago</option>
                <option value="1" {{ old('metodo_pago_id') == '1' ? 'selected' : '' }}>Tarjeta de Débito</option>
                <option value="2" {{ old('metodo_pago_id') == '2' ? 'selected' : '' }}>Tarjeta de Crédito</option>
                <option value="3" {{ old('metodo_pago_id') == '3' ? 'selected' : '' }}>Efectivo</option>
                <option value="4" {{ old('metodo_pago_id') == '4' ? 'selected' : '' }}>PayPal</option>
                <option value="5" {{ old('metodo_pago_id') == '5' ? 'selected' : '' }}>MercadoPago</option>
            </select> <br><br>

            <button type="submit">Confirmar envío y pago</button>
        </form>
    </main>
</body>
</html>