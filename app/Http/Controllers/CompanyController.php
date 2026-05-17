<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Company;
use App\Models\SolCredential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user      = Auth::user();
        $digitoRuc = $request->digito_ruc;

        $companies = Company::with('solCredential')
            ->when($user->isAsistente(), fn($q) => $q->where('created_by', $user->id))
            ->search($request->q)
            ->when($request->estado, fn($q, $e) => $q->where('estado', $e))
            ->when(is_numeric($digitoRuc), fn($q) => $q->whereRaw("SUBSTR(ruc, -1) = ?", [$digitoRuc]))
            ->orderBy('razon_social')
            ->paginate(15)
            ->withQueryString();

        return view('companies.index', compact('companies', 'digitoRuc'));
    }

    public function create()
    {
        return view('companies.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ruc'                => ['required', 'regex:/^\d{11}$/', 'unique:companies,ruc'],
            'razon_social'       => ['required', 'string', 'max:255'],
            'tipo_contribuyente' => ['nullable', 'in:PERSONA NATURAL,PERSONA JURIDICA,EMPRESA'],
            'direccion_fiscal'   => ['nullable', 'string', 'max:500'],
            'estado'             => ['required', 'in:ACTIVO,BAJA,SUSPENSION'],
            'usuario_sol'        => ['nullable', 'string', 'max:8'],
            'clave_sol'          => ['nullable', 'string', 'min:4'],
        ]);

        $user    = Auth::user();
        $company = Company::create([
            'ruc'                => $data['ruc'],
            'razon_social'       => strtoupper($data['razon_social']),
            'tipo_contribuyente' => $data['tipo_contribuyente'] ?? null,
            'direccion_fiscal'   => $data['direccion_fiscal'] ?? null,
            'estado'             => $data['estado'],
            'created_by'         => $user->id,
        ]);

        if (!empty($data['usuario_sol']) && !empty($data['clave_sol'])) {
            SolCredential::create([
                'company_id'  => $company->id,
                'usuario_sol' => strtoupper($data['usuario_sol']),
                'clave_sol'   => $data['clave_sol'],
                'created_by'  => $user->id,
            ]);
        }

        ActivityLog::record('create_company', "Empresa creada: {$company->ruc} — {$company->razon_social}", [
            'model_type' => Company::class,
            'model_id'   => $company->id,
        ]);

        return redirect()->route('companies.index')
            ->with('success', "Empresa {$company->razon_social} registrada correctamente.");
    }

    public function show(Company $company)
    {
        $this->authorizeCompany($company);
        $company->load('solCredential', 'creator');
        $recentLogs = $company->accessLogs()->with('user')
            ->latest('accessed_at')->take(5)->get();

        return view('companies.show', compact('company', 'recentLogs'));
    }

    public function edit(Company $company)
    {
        $this->authorizeCompany($company);
        return view('companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $this->authorizeCompany($company);

        $data = $request->validate([
            'ruc'                => ['required', 'regex:/^\d{11}$/', Rule::unique('companies')->ignore($company->id)],
            'razon_social'       => ['required', 'string', 'max:255'],
            'tipo_contribuyente' => ['nullable', 'in:PERSONA NATURAL,PERSONA JURIDICA,EMPRESA'],
            'direccion_fiscal'   => ['nullable', 'string', 'max:500'],
            'estado'             => ['required', 'in:ACTIVO,BAJA,SUSPENSION'],
        ]);

        $company->update([...$data, 'updated_by' => Auth::id()]);

        ActivityLog::record('update_company', "Empresa actualizada: {$company->ruc}", [
            'model_type' => Company::class,
            'model_id'   => $company->id,
        ]);

        return redirect()->route('companies.show', $company)
            ->with('success', "Empresa actualizada correctamente.");
    }

    public function destroy(Company $company)
    {
        $this->authorizeCompany($company);
        ActivityLog::record('delete_company', "Empresa eliminada: {$company->ruc} — {$company->razon_social}");
        $company->delete();

        return redirect()->route('companies.index')
            ->with('success', "Empresa eliminada correctamente.");
    }

    public function storeCredential(Request $request, Company $company)
    {
        $this->authorizeCompany($company);

        if ($company->solCredential) {
            return back()->with('error', 'Esta empresa ya tiene credenciales SOL registradas.');
        }

        $data = $request->validate([
            'usuario_sol' => ['required', 'string', 'max:8', 'min:1'],
            'clave_sol'   => ['required', 'string', 'min:4', 'max:20'],
        ]);

        $credential = SolCredential::create([
            'company_id'  => $company->id,
            'usuario_sol' => strtoupper($data['usuario_sol']),
            'clave_sol'   => $data['clave_sol'],
            'created_by'  => Auth::id(),
            'updated_by'  => Auth::id(),
        ]);

        ActivityLog::record('create_credential', "Credencial SOL registrada para: {$company->ruc}", [
            'model_type' => SolCredential::class,
            'model_id'   => $credential->id,
        ]);

        return redirect()->route('companies.show', $company)
            ->with('success', "Credencial SOL registrada correctamente para {$company->razon_social}.");
    }

    private function authorizeCompany(Company $company): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user->isAdmin() || $user->isSupervisor()) return;
        if ($company->created_by !== $user->id) abort(403);
    }
}
