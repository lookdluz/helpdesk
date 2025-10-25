<x-layout>
  <h1 class="text-xl font-bold mb-4">Abrir ticket</h1>
  <form method="post" action="{{ route('tickets.store') }}">
    @csrf
    <label>Assunto</label>
    <input name="subject" class="input" required>
    <label>Descrição</label>
    <textarea name="description" class="textarea" required></textarea>
    <button class="btn-primary mt-3">Enviar</button>
  </form>
</x-layout>
