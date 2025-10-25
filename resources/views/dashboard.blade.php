<x-layout>
  <h1 class="text-xl font-bold mb-4">Dashboard</h1>
  <div class="grid grid-cols-2 gap-4">
    <div class="p-4 border rounded">Total: <b>{{ $stats['total'] }}</b></div>
    <div class="p-4 border rounded">Abertos: <b>{{ $stats['abertos'] }}</b></div>
    <div class="p-4 border rounded">Em andamento: <b>{{ $stats['andamento'] }}</b></div>
    <div class="p-4 border rounded">Resolvidos: <b>{{ $stats['resolvidos'] }}</b></div>
    <div class="p-4 border rounded col-span-2">TMA 1ª resposta: <b>{{ $stats['tma_primeira_resposta_min'] }} min</b></div>
  </div>
  <h2 class="mt-6 font-semibold">Últimos 7 dias</h2>
  <ul class="list-disc ml-6 mt-2">
    @foreach($series as $row)
      <li>{{ \Carbon\Carbon::parse($row->d)->format('d/m') }} — {{ $row->c }} tickets</li>
    @endforeach
  </ul>
</x-layout>
