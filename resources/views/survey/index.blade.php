@extends('layouts.app')
@section('title', 'Encuesta Piloto')
@section('page-title', 'Encuesta de Usabilidad y Desempeño')

@push('styles')
<style>
/* Executive Styles */
.exec-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
}
.exec-header-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    letter-spacing: -0.02em;
    margin: 0;
}
.exec-header-subtitle { font-size: 0.8rem; color: #64748b; font-weight: 500; }

.exec-alert-academic {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-left: 4px solid #3b82f6;
    border-radius: 6px;
    padding: 1rem;
    display: flex;
    gap: 1rem;
    align-items: center;
    margin-bottom: 1.5rem;
}

.exec-panel {
    background: #fff;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    margin-bottom: 1.5rem;
    overflow: hidden;
}
.exec-panel-header {
    background: linear-gradient(90deg, #1e293b, #334155);
    padding: 1.25rem 1.5rem;
    color: #fff;
}
.exec-panel-title {
    font-size: 0.9rem;
    font-weight: 600;
    margin: 0;
    letter-spacing: 0.03em;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.table-likert th {
    font-size: 0.65rem;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    background: #f8fafc;
    padding: 1rem 0.5rem;
    vertical-align: middle;
}
.table-likert td {
    padding: 1rem 0.5rem;
    vertical-align: middle;
    border-bottom: 1px solid #e2e8f0;
}

.question-text {
    font-size: 0.85rem;
    font-weight: 500;
    color: #334155;
    line-height: 1.4;
}
.question-number {
    font-size: 0.7rem;
    font-weight: 700;
    color: #94a3b8;
    margin-right: 0.5rem;
}

.likert-radio {
    width: 20px;
    height: 20px;
    cursor: pointer;
    accent-color: #3b82f6;
}
.likert-radio:focus {
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
}

.btn-exec-primary {
    background: #3b82f6;
    color: #fff;
    font-size: 0.85rem;
    font-weight: 600;
    padding: 0.6rem 1.5rem;
    border-radius: 6px;
    border: none;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
}
.btn-exec-primary:hover { background: #2563eb; color: #fff; box-shadow: 0 4px 10px rgba(59,130,246,0.2); }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="exec-header">
            <div>
                <h5 class="exec-header-title">Encuesta Piloto (Escala Likert)</h5>
                <div class="exec-header-subtitle">Instrumento de recolección de datos para validación de hipótesis</div>
            </div>
        </div>

        <div class="exec-alert-academic">
            <i class="bi bi-clipboard-data-fill" style="font-size:1.5rem; color:#3b82f6;"></i>
            <div>
                <div style="font-size:0.8rem; font-weight:600; color:#1e293b; margin-bottom:0.2rem;">Investigación Formativa UCV 2026</div>
                <div style="font-size:0.75rem; color:#64748b;">
                    Por favor, evalúe las siguientes afirmaciones según su experiencia utilizando el sistema prototipo. 
                    <br>
                    <strong>Escala:</strong> (1) Totalmente en Desacuerdo &nbsp;→&nbsp; (5) Totalmente de Acuerdo.
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('survey.store') }}">
            @csrf

            @foreach($questions as $dimension => $items)
            <div class="exec-panel">
                <div class="exec-panel-header">
                    <h6 class="exec-panel-title">
                        <i class="bi bi-bookmark-fill text-blue-300"></i>{{ $dimension }}
                    </h6>
                    <div style="font-size:0.7rem; color:#94a3b8; margin-top:0.2rem; font-weight:500;">
                        Variable: {{ $items->first()->variable }}
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-likert mb-0">
                        <thead>
                            <tr>
                                <th style="width:50%; text-align:left; padding-left:1.5rem;">Afirmación a Evaluar</th>
                                <th class="text-center" style="width:10%;">1 - Totalmente<br>Desacuerdo</th>
                                <th class="text-center" style="width:10%;">2 - En<br>Desacuerdo</th>
                                <th class="text-center" style="width:10%;">3 -<br>Neutral</th>
                                <th class="text-center" style="width:10%;">4 - De<br>Acuerdo</th>
                                <th class="text-center" style="width:10%;">5 - Totalmente<br>Acuerdo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $question)
                            <tr>
                                <td style="padding-left:1.5rem;">
                                    <div class="question-text">
                                        <span class="question-number">P{{ $question->order_number }}.</span>
                                        {{ $question->question_text }}
                                    </div>
                                    @error("responses.{$question->id}")
                                    <div class="text-danger mt-1" style="font-size:0.7rem; font-weight:600;"><i class="bi bi-exclamation-circle me-1"></i>Requerido</div>
                                    @enderror
                                </td>
                                @for($s = 1; $s <= 5; $s++)
                                <td class="text-center">
                                    <input type="radio" name="responses[{{ $question->id }}]"
                                        value="{{ $s }}"
                                        class="likert-radio"
                                        {{ old("responses.{$question->id}") == $s ? 'checked' : '' }}
                                        required>
                                </td>
                                @endfor
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach

            <div class="exec-panel p-4" style="background:#f8fafc; display:flex; align-items:center; justify-content:space-between;">
                <div style="font-size:0.8rem; color:#64748b; font-weight:500;">
                    <i class="bi bi-info-circle me-2 text-primary"></i>Las respuestas enviadas son definitivas y no podrán ser modificadas.
                </div>
                <button type="submit" class="btn-exec-primary">
                    <i class="bi bi-send-fill me-2"></i>Registrar Respuestas
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
