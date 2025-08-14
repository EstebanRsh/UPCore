<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use Illuminate\Support\Facades\Schema;

class PlanController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string)$request->get('q', ''));
        $estado = $request->get('estado'); // 'Activo'|'Inactivo'|null

        $planes = Plan::query()
            ->when(
                $q,
                fn($qq) =>
                $qq->where('nombre_plan', 'like', "%{$q}%")
                    ->orWhere('descripcion', 'like', "%{$q}%")
            )
            ->withCount('contracts')
            ->orderByDesc('activo')
            ->orderBy('nombre_plan')
            ->paginate(15)
            ->withQueryString();

        // Si tu columna 'activo' no es booleana y usás 'Activo'/'Inactivo', filtra en colección:
        if (! self::activoColumnIsBoolean() && in_array($estado, ['Activo', 'Inactivo'], true)) {
            $planes->setCollection(
                $planes->getCollection()->filter(fn($p) => (string)$p->activo === $estado)->values()
            );
        }

        return view('settings.plans.index', [
            'planes' => $planes,
            'q'      => $q,
            'estado' => $estado,
        ]);
    }

    public function create()
    {
        return view('settings.plans.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_plan'    => 'required|string|max:120',
            'velocidad_mbps' => 'required|integer|min:1',
            'precio_mensual' => 'required|numeric|min:0',
            'descripcion'    => 'nullable|string|max:2000',
            'activo'         => 'nullable',
        ]);

        // Normalizar 'activo' según el tipo real de columna:
        $data['activo'] = self::activoColumnIsBoolean()
            ? (bool)$request->boolean('activo', true)
            : ($request->has('activo') ? 'Activo' : 'Inactivo');

        Plan::create($data);

        return redirect()->route('settings.planes.index')
            ->with('success', '¡Plan creado correctamente!');
    }

    public function edit(Plan $plane)
    {
        return view('settings.plans.edit', ['plan' => $plane]);
    }

    public function update(Request $request, Plan $plane)
    {
        $data = $request->validate([
            'precio_mensual' => 'required|numeric|min:0',
        ]);

        $plane->update(['precio_mensual' => $data['precio_mensual']]);

        return redirect()->route('settings.planes.index')
            ->with('success', 'Precio actualizado. Afecta futuras facturaciones (no las ya emitidas).');
    }

    public function toggle(Plan $plane)
    {
        if (self::activoColumnIsBoolean()) {
            $nuevo = $plane->activo ? 0 : 1; // forzar 0/1 para evitar ''
            $plane->update(['activo' => $nuevo]);
        } else {
            $nuevo = ((string)$plane->activo === 'Activo') ? 'Inactivo' : 'Activo';
            $plane->update(['activo' => $nuevo]);
        }

        // Releer el estado crudo para el mensaje
        $plane->refresh();
        $activo = self::isActive($plane);

        return redirect()->route('settings.planes.index')
            ->with('success', $activo ? 'Plan activado.' : 'Plan inactivado.');
    }

    public function destroy(Plan $plane)
    {
        if ($plane->contracts()->exists()) {
            return redirect()->route('settings.planes.index')
                ->with('error', 'No se puede eliminar: el plan está asociado a contratos. Inactívalo en su lugar.');
        }

        $plane->delete();

        return redirect()->route('settings.planes.index')
            ->with('success', '¡Plan eliminado correctamente!');
    }

    /** Detecta si la columna 'activo' es booleana/tinyint(1) */
    private static function activoColumnIsBoolean(): bool
    {
        try {
            $type = Schema::getColumnType('plans', 'activo');
            // algunos drivers reportan 'boolean', otros 'tinyint'
            return in_array($type, ['boolean', 'tinyint', 'integer'], true);
        } catch (\Throwable $e) {
            $casts = (new Plan)->getCasts();
            return isset($casts['activo']) && $casts['activo'] === 'bool';
        }
    }

    /** Interpreta el valor 'activo' como boolean, sin importar cómo se almacene */
    private static function isActive(Plan $plan): bool
    {
        $raw = $plan->getRawOriginal('activo');
        if (is_bool($raw)) return $raw;
        if (is_numeric($raw)) return (int)$raw === 1;
        return (string)$raw === 'Activo';
    }
}
