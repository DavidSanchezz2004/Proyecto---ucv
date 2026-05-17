{{-- Modal de simulación Ejecutivo --}}
<div x-show="open" class="sol-overlay" @click.self="open=false" style="display:none">
    <div class="exec-modal-content text-start">
        <div class="d-flex align-items-center gap-3 mb-4 border-bottom pb-3">
            <div style="width:40px;height:40px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                <i class="bi bi-buildings" style="color:#64748b;font-size:18px"></i>
            </div>
            <div>
                <div style="font-size:1rem;font-weight:700;color:#1e293b" x-text="companyName"></div>
                <div style="font-size:0.75rem;color:#64748b;letter-spacing:0.05em;">RUC <span x-text="ruc" class="font-monospace"></span></div>
            </div>
        </div>

        <div style="font-size:0.8rem;font-weight:600;color:#475569;margin-bottom:1rem;text-transform:uppercase;letter-spacing:0.05em;">
            Secuencia de Automatización
        </div>

        <div class="mb-4">
            <template x-for="(step, i) in steps" :key="i">
                <div class="d-flex align-items-center gap-3 py-2" style="font-size:0.85rem; font-weight:500;">
                    <div style="width:16px; display:flex; justify-content:center;">
                        <template x-if="currentStep > i">
                            <div class="step-indicator done"></div>
                        </template>
                        <template x-if="currentStep === i && !completed">
                            <div class="step-indicator active"></div>
                        </template>
                        <template x-if="currentStep < i">
                            <div class="step-indicator pending"></div>
                        </template>
                    </div>
                    <span :class="currentStep >= i ? 'text-dark' : 'text-muted'" x-text="step.label"></span>
                </div>
            </template>
        </div>

        {{-- Resultado final --}}
        <div x-show="completed" style="display:none" x-transition.opacity>
            <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:1rem; margin-bottom:1rem;">
                <div class="d-flex align-items-start gap-2">
                    <i class="bi bi-check2-circle" style="color:#059669; font-size:1.25rem;"></i>
                    <div>
                        <div style="font-size:0.85rem; font-weight:700; color:#065f46; margin-bottom:0.25rem;">Acceso Completado</div>
                        <div style="font-size:0.75rem; color:#166534;">
                            Tiempo de ejecución: <strong x-text="durationText"></strong><br>
                            Ahorro estimado: <strong x-text="savedText"></strong>
                        </div>
                    </div>
                </div>
            </div>
            <div style="font-size:0.7rem; color:#64748b; line-height:1.4;">
                <strong>Nota de Investigación:</strong> Este entorno académico simula la inyección segura de credenciales. En producción, ocurriría una redirección con sesión tokenizada.
            </div>
        </div>

        <div class="d-flex justify-content-end mt-4">
            <button @click="open=false" class="btn-exec-outline w-100 text-center" x-show="completed">
                Cerrar Panel
            </button>
        </div>
    </div>
</div>
