<x-layout>
  <h1 class="text-xl font-bold mb-4">Tickets</h1>
  <a class="btn" href="{{ route('tickets.create') }}">Abrir ticket</a>
  <table class="table-auto w-full mt-4">
    <thead><tr><th>ID</th><th>Assunto</th><th>Status</th><th>Criado</th></tr></thead>
    <tbody>
      @foreach($tickets as $t)
        <tr>
          <td>#{{ $t->id }}</td>
          <td><a href="{{ route('tickets.show',$t) }}">{{ $t->subject }}</a></td>
          <td>{{ Str::title(str_replace('_',' ',$t->status)) }}</td>
          <td>{{ $t->created_at->diffForHumans() }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
  {{ $tickets->links() }}
</x-layout>
