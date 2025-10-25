<x-layout>
  <div class="flex justify-between">
    <h1 class="text-xl font-bold">Ticket #{{ $ticket->id }} — {{ $ticket->subject }}</h1>
    @can('is-admin')
    <form method="post" action="{{ route('tickets.update',$ticket) }}">
      @csrf @method('PUT')
      <select name="status">
        @foreach(['aberto','em_andamento','resolvido'] as $s)
          <option value="{{ $s }}" @selected($ticket->status===$s)>{{ Str::title(str_replace('_',' ',$s)) }}</option>
        @endforeach
      </select>
      <button class="btn">Atualizar</button>
    </form>
    @endcan
  </div>

  <p class="mt-2 text-gray-600">{{ $ticket->description }}</p>

  <hr class="my-4">
  <h2 class="font-semibold mb-2">Respostas</h2>
  @foreach($ticket->replies as $r)
    <div class="border p-3 mb-2">
      <div class="text-sm text-gray-500">
        {{ $r->author->name }} — {{ $r->created_at->format('d/m/Y H:i') }}
        @if($r->author->role === 'admin') <span class="ml-2 px-2 py-0.5 bg-indigo-100 text-indigo-700 text-xs rounded">Admin</span> @endif
      </div>
      <div class="mt-2">{{ $r->message }}</div>
      @if($r->attachment_path)
        <a class="text-blue-600 underline" target="_blank" href="{{ Storage::disk('public')->url($r->attachment_path) }}">Anexo</a>
      @endif
    </div>
  @endforeach

  <form class="mt-4" method="post" action="{{ route('tickets.reply',$ticket) }}" enctype="multipart/form-data">
    @csrf
    <textarea name="message" class="textarea" placeholder="Escreva uma resposta…" required></textarea>
    <input type="file" name="attachment" class="mt-2">
    <button class="btn-primary mt-2">Responder</button>
  </form>
</x-layout>
