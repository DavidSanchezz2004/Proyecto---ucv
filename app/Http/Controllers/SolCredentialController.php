<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Company;
use App\Models\SolCredential;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SolCredentialController extends Controller
{
    public function index()
    {
        $credentials = SolCredential::with(['company', 'creator', 'updater'])
            ->orderBy('updated_at', 'desc')
            ->paginate(15);

        return view('sol.credentials.index', compact('credentials'));
    }

    public function create()
    {
        // Solo empresas sin credencial registrada
        $companies = Company::active()
            ->whereDoesntHave('solCredential')
            ->orderBy('razon_social')
            ->get();

        return view('sol.credentials.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'company_id'  => ['required', 'exists:companies,id', 'unique:sol_credentials,company_id'],
            'usuario_sol' => ['required', 'string', 'max:8', 'min:1'],
            'clave_sol'   => ['required', 'string', 'min:4', 'max:20'],
        ]);

        $credential = SolCredential::create([
            'company_id'  => $data['company_id'],
            'usuario_sol' => strtoupper($data['usuario_sol']),
            'clave_sol'   => $data['clave_sol'],
            'created_by'  => auth()->id(),
            'updated_by'  => auth()->id(),
        ]);

        $company = Company::find($data['company_id']);
        ActivityLog::record('create_credential', "Credencial SOL registrada para: {$company->ruc}", [
            'model_type' => SolCredential::class,
            'model_id'   => $credential->id,
        ]);

        return redirect()->route('sol-credentials.index')
            ->with('success', "Credencial SOL registrada correctamente para {$company->razon_social}.");
    }

    public function edit(SolCredential $solCredential)
    {
        abort(403, 'Las credenciales SOL solo pueden ser modificadas por el asistente contable asignado.');
    }

    public function update(Request $request, SolCredential $solCredential)
    {
        abort(403, 'Las credenciales SOL solo pueden ser modificadas por el asistente contable asignado.');
        $data = $request->validate([
            'usuario_sol' => ['required', 'string', 'max:8', 'min:1'],
            'clave_sol'   => ['nullable', 'string', 'min:4', 'max:20'],
        ]);

        $updateData = [
            'usuario_sol' => strtoupper($data['usuario_sol']),
            'updated_by'  => auth()->id(),
        ];

        // Solo actualiza la clave si se proporcionó una nueva
        if (!empty($data['clave_sol'])) {
            $updateData['clave_sol'] = $data['clave_sol'];
        }

        $solCredential->update($updateData);

        ActivityLog::record('update_credential', "Credencial SOL actualizada para: {$solCredential->company->ruc}", [
            'model_type' => SolCredential::class,
            'model_id'   => $solCredential->id,
        ]);

        return redirect()->route('sol-credentials.index')
            ->with('success', "Credencial actualizada correctamente.");
    }

    public function destroy(SolCredential $solCredential)
    {
        abort(403, 'Las credenciales SOL solo pueden ser eliminadas por el asistente contable asignado.');

        return redirect()->route('sol-credentials.index')
            ->with('success', "Credencial eliminada correctamente.");
    }
}
